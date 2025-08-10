#!/usr/bin/env bash

set -e

SCRIPT_DIR=$(dirname $0)
if [ "${SCRIPT_DIR}" = "." ];then
    SCRIPT_DIR=${PWD}
fi

DEPLOY_CONFIG=$SCRIPT_DIR/deploy-config.yml

ARTIFACT_DEST=$(cat $DEPLOY_CONFIG | yq '.config.artifact-dest')
APP_DEST=$(cat $DEPLOY_CONFIG | yq '.config.app-dest')
DOCKER_COMPOSE_FILE=$(cat $DEPLOY_CONFIG | yq '.config.docker-compose-file')

cd $ARTIFACT_DEST/deploy

CURR_DIR=$PWD
SCRIPT_DIR=$(dirname $0)
if [ "${SCRIPT_DIR}" = "." ];then
    SCRIPT_DIR=${PWD}
fi

WAIT_FOR_IT=${SCRIPT_DIR}/wait-for-it.sh

echo "====================== [START] Update application source code ======================="
# 새로운 소스코드 세팅 => 이미 pre-deploy에서 진행했음
# 기존 소스코드 삭제 & 새로운 소스코드 대체
APP_SOURCE=$APP_DEST/html
APP_SOURCE_ARCHIVE=$ARTIFACT_DEST/www/html-archive
APP_SOURCE_STANDBY=$ARTIFACT_DEST/www/html-standby

sudo rm -rf $APP_SOURCE_ARCHIVE
sudo mv $APP_SOURCE $APP_SOURCE_ARCHIVE
echo Current source-code is archived
sudo mv $APP_SOURCE_STANDBY $APP_SOURCE
echo New source-code is deployed
echo "====================== [END] Update application source code ========================="

echo;
echo "====================== [START] Run Server! ======================="
TARGET_ENV=$(cat $DEPLOY_CONFIG | yq '.config.target-env')
APP="docker compose -p medongaule-${TARGET_ENV} "

$APP down

WITH_ENV="--env-file $ARTIFACT_DEST/deploy/.env"
WITH_FILE="--file $ARTIFACT_DEST/deploy/$DOCKER_COMPOSE_FILE"
$APP ${WITH_ENV} ${WITH_FILE} up --detach

sleep 10
echo "====================== [END] Run Server! ========================="

echo "====================== [START] Add crontab schedule ======================="
CRON_JOB="* * * * * $APP exec -it main schedule-exec"
(crontab -l 2>/dev/null | grep -F "$CRON_JOB") || (crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -
echo "====================== [END] Add crontab schedule ========================="

$WAIT_FOR_IT localhost:80 -s -t 30
