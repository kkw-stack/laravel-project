#!/usr/bin/env bash

set -eu

DEPLOY_TOOLS_DIR=/medongaule/deploy
cd ${DEPLOY_TOOLS_DIR}

SCRIPT_DIR=/medongaule/deploy/scripts
chmod -R +x ${SCRIPT_DIR}/*.sh

MEDONG_DIR=/medongaule
chmod -R +x ${DEPLOY_TOOLS_DIR}/entrypoints/*.sh

APP_SOURCE_DIR=/var/www

INSTALL="sudo install --mode 755 --owner ec2-user --group ec2-user --directory"

$INSTALL "$MEDONG_DIR"                                  # 배포에 필요한 스크립트, 데이터를 포함하는 디렉토리
$INSTALL "$MEDONG_DIR/certs"                            # /etc/letsencrypt 디렉토리와 같은 역할
$INSTALL "$MEDONG_DIR/data"                             # mariadb, certbot 등의 런타임에서 생성한 데이터들 들어감
$INSTALL "$MEDONG_DIR/data/mariadb"                     # mariadb 데이터
$INSTALL "$MEDONG_DIR/data/certbot"                     # certbot 데이터
$INSTALL "$APP_SOURCE_DIR"                              
$INSTALL "$APP_SOURCE_DIR/certbot"                      # HTTP01 Challenge를 위해 http로 노출되는 디렉토리
$INSTALL "$APP_SOURCE_DIR/html"                         # 현재 동작하는 소스코드가 위치하는 디렉토리
$INSTALL "$APP_SOURCE_DIR/user-contents"
$INSTALL "$APP_SOURCE_DIR/user-contents/app-public"     # 유저가 업로드한 파일 등의 컨텐츠를 담는 디렉토리

DEPLOY_VARIABLE_FILE=$DEPLOY_TOOLS_DIR/deploy-vars

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
                  "SECRET_ARN")

# 환경변수 검증
for key in ${DEPLOY_VARIABLES[@]}; do
    VAR=`printenv $key`
    if [[ -z "${VAR}" ]]; then
        echo Environment variable \"$key\" is is not defined.
        exit 1
    fi
done

APP_SOURCE_STANDBY=${MEDONG_DIR}/www/html-standby
rm -rf ${APP_SOURCE_STANDBY}
mkdir -p ${APP_SOURCE_STANDBY}
tar -zxf ${DEPLOY_TOOLS_DIR}/source.tgz -C ${APP_SOURCE_STANDBY}

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
cp ${DOTENV} ${DEPLOY_TOOLS_DIR}/

echo "CUSTOM_PHP_IMAGE=${CUSTOM_PHP_IMAGE}" | sudo tee -a ${DEPLOY_TOOLS_DIR}/.env /dev/null

aws ecr get-login-password --region ${AWS_REGION} | docker login --username AWS --password-stdin ${ECR_REGISTRY}

NETWORK_NAME="medongaule_backend"

# 네트워크가 존재하는지 확인 (에러가 발생해도 true로 처리)
if ! docker network inspect "$NETWORK_NAME" > /dev/null 2>&1 || true; then
    APP="docker compose -p medongaule "

    WITH_ENV="--env-file /medongaule/deploy/.env"
    WITH_FILE="--file /medongaule/deploy/docker-compose.yaml"
    $APP ${WITH_ENV} ${WITH_FILE} create
else
  echo "Docker network '$NETWORK_NAME' already exists."
fi

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

# HACK: 왜인지는 모르겠는데 실패한다... 잠시 제거(20241031)
# echo Artisan sitemap:generate
# $RUN_PHP php artisan sitemap:generate

# User-Contents 링크 추가
APP_USER_CONTENTS=$APP_SOURCE_DIR/user-contents/app-public
cd ${APP_SOURCE_STANDBY}/storage/app \
    && rm -rf public \
    && ln -s ${APP_USER_CONTENTS} public \
    && cd ${DEPLOY_TOOLS_DIR}

echo "====================== [END] Install php packages & Prepare source-code ========================"
echo "DONE."
echo;