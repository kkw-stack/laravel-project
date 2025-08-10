#!/usr/bin/env bash

set -eu

SCRIPT_DIR=$(dirname $0)
if [ "${SCRIPT_DIR}" = "." ];then
    SCRIPT_DIR=${PWD}
fi

chmod -R +x ${SCRIPT_DIR}/*.sh

DEPLOY_CONFIG=$SCRIPT_DIR/deploy-config.yml

ARTIFACT_DEST=$(cat $DEPLOY_CONFIG | yq '.config.artifact-dest')
APP_DEST=$(cat $DEPLOY_CONFIG | yq '.config.app-dest')
DEPLOY_USER=$(cat $DEPLOY_CONFIG | yq '.config.deploy-user')
DB_EXPOSE_PORT=$(cat $DEPLOY_CONFIG | yq '.config.db-expose-port')

DEPLOY_DIR=$ARTIFACT_DEST/deploy
cd ${DEPLOY_DIR}

chmod -R +x ${DEPLOY_DIR}/entrypoints/*.sh

INSTALL="sudo install --owner $DEPLOY_USER --group $DEPLOY_USER --directory"

$INSTALL "$ARTIFACT_DEST"                                  # 배포에 필요한 스크립트, 데이터를 포함하는 디렉토리
$INSTALL "$ARTIFACT_DEST/certs"                            # /etc/letsencrypt 디렉토리와 같은 역할
$INSTALL "$ARTIFACT_DEST/data"                             # mariadb, certbot 등의 런타임에서 생성한 데이터들 들어감
$INSTALL "$ARTIFACT_DEST/data/mariadb"                     # mariadb 데이터
$INSTALL "$ARTIFACT_DEST/data/certbot"                     # certbot 데이터
$INSTALL "$APP_DEST"                              
$INSTALL "$APP_DEST/certbot"                      # HTTP01 Challenge를 위해 http로 노출되는 디렉토리
$INSTALL "$APP_DEST/html"                         # 현재 동작하는 소스코드가 위치하는 디렉토리
$INSTALL "$APP_DEST/user-contents"
$INSTALL "$APP_DEST/user-contents/app-public"     # 유저가 업로드한 파일 등의 컨텐츠를 담는 디렉토리

sudo find "$ARTIFACT_DEST" -name *.sh -not -path "*/mariadb/*" -exec chmod +x '{}' \;

DEPLOY_VARIABLE_FILE=$DEPLOY_DIR/deploy-vars

if [ ! -e $DEPLOY_VARIABLE_FILE ]; then
    echo \"$DEPLOY_VARIABLE_FILE\" is not exist
    exit 1
fi

# key-value로부터 환경변수를 불러온다.
for line in `cat $DEPLOY_VARIABLE_FILE | sort -u`; do
    if [[ $line != \#* ]];then
        export $line;
    fi;
done

DEPLOY_VARIABLES=("TARGET_ENV"
                  "AWS_REGION"
                  "CUSTOM_PHP_IMAGE"
                  "ECR_REGISTRY"
                  "SOURCE_TGZ"
                  "SECRET_ARN"
                  "IP_ALLOW_LIST")

# 환경변수 검증
for key in ${DEPLOY_VARIABLES[@]}; do
    VAR=`printenv $key`
    if [[ -z "${VAR}" ]]; then
        echo Environment variable \"$key\" is is not defined.
        exit 1
    fi
done

APP_SOURCE_STANDBY=$ARTIFACT_DEST/www/html-standby
sudo rm -rf ${APP_SOURCE_STANDBY}
mkdir -p ${APP_SOURCE_STANDBY}
tar -zxf ${DEPLOY_DIR}/source.tgz -C ${APP_SOURCE_STANDBY}

echo "====================== [START] Generate .env file ======================"
DOTENV="$APP_SOURCE_STANDBY/.env"

# AWS Secrets Manager로부터 .env를 불러온다
aws secretsmanager get-secret-value --secret-id ${SECRET_ARN} --output json \
    | jq '.SecretString' -r \
    | jq -r 'to_entries[] | "\(.key)=\(.value)"' \
    | sort \
    | sudo tee ${DOTENV} /dev/null

sudo chown $(id -u):$(id -g) ${DOTENV}
echo ".env path = ${DOTENV}"
echo "====================== [END] Generate .env file ========================"
echo;echo;

echo "====================== [START] Generate robots.txt ======================"

ROBOTS_TXT_TEMPLATE="$APP_SOURCE_STANDBY/public/robots.txt.template"
export DOMAIN=$(grep "^APP_DOMAIN=" ".env" | cut -d '=' -f2-)
envsubst '${DOMAIN}' < ${ROBOTS_TXT_TEMPLATE} > ${ROBOTS_TXT_TEMPLATE%.template}

echo "====================== [END] Generate robots.txt ========================"
echo;echo;

echo "====================== [START] Install php packages & Prepare source-code ======================"
cp ${DOTENV} ${DEPLOY_DIR}/

echo "CUSTOM_PHP_IMAGE=${CUSTOM_PHP_IMAGE}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "DEPLOY_DIR=${ARTIFACT_DEST}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "APP_SOURCE_DIR=${APP_DEST}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "TARGET_ENV=${TARGET_ENV}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "DB_EXPOSE_PORT=${DB_EXPOSE_PORT}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "IP_ALLOW_LIST=${IP_ALLOW_LIST}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null

# docker-compose 실행을 위한 사용자의 UID, GID를 .env에 추가 => 하지만 실제로는 사용하지 않음
# 해당 유저는 개발환경에서 개발자들이 소스코드 제어를 위해 사용하는 계정이지만 배포환경에서는 사용하지 않음
# 하지만 개발환경도 CI/CD가 동작하는 환경이므로, 배포환경과 동일한 환경변수를 사용하도록 함
# CI/CD가 잘 동작하는게 확인된다면 이 부분은 제거해도 무방
DOCKER_UID=$(id -u $DEPLOY_USER)
DOCKER_GID=$(id -g $DEPLOY_USER)
echo "DOCKER_UID=${DOCKER_UID}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null
echo "DOCKER_GID=${DOCKER_GID}" | sudo tee -a ${DEPLOY_DIR}/.env /dev/null

NETWORK_NAME="db-global"

# 네트워크가 존재하는지 확인 (에러가 발생해도 true로 처리)
if ! docker network inspect "$NETWORK_NAME" > /dev/null 2>&1 || true; then
  echo "Docker network '$NETWORK_NAME' does not exist. Creating..."
  # 네트워크 생성 (에러가 발생해도 무시)
  docker network create "$NETWORK_NAME" > /dev/null 2>&1 || true
  echo "Docker network '$NETWORK_NAME' created."
else
  echo "Docker network '$NETWORK_NAME' already exists."
fi

aws ecr get-login-password --region ${AWS_REGION} | docker login --username AWS --password-stdin ${ECR_REGISTRY}
RUN_PHP="docker run --rm --network $NETWORK_NAME -v ${APP_SOURCE_STANDBY}:/var/www/html --user $(id -u):$(id -g) ${CUSTOM_PHP_IMAGE}"

echo Composer Install Start
$RUN_PHP composer install --no-dev --no-interaction

echo Artisan Storage Link
$RUN_PHP php artisan storage:link

# Route Cache 생성 에러로 optimize 중지.
# 버그 고쳐지면 활성화 할것
# echo Artisan optimize
# $RUN_PHP php artisan optimize

echo Artisan view:cache
$RUN_PHP php artisan view:cache

echo Artisan config:cache
$RUN_PHP php artisan config:cache

echo Artisan event:cache
$RUN_PHP php artisan event:cache

echo Artisan key:generate
$RUN_PHP php artisan key:generate

echo Artisan sitemap:generate
$RUN_PHP php artisan sitemap:generate

# User-Contents 링크 추가
APP_USER_CONTENTS=$APP_DEST/user-contents/app-public
cd ${APP_SOURCE_STANDBY}/storage/app \
    && sudo rm -rf public \
    && ln -s ${APP_USER_CONTENTS} public \
    && cd ${DEPLOY_DIR}

echo "====================== [END] Install php packages & Prepare source-code ========================"
echo "DONE."
echo;