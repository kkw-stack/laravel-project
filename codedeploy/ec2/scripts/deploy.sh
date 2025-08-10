#!/usr/bin/env bash

set -eu

cd /medongaule/deploy

CURR_DIR=$PWD
SCRIPT_DIR=$(dirname $0)
if [ "${SCRIPT_DIR}" = "." ];then
    SCRIPT_DIR=${PWD}
fi

WAIT_FOR_IT=${SCRIPT_DIR}/wait-for-it.sh

echo "====================== [START] Update application source code ======================="
# 새로운 소스코드 세팅 => 이미 pre-deploy에서 진행했음
# 기존 소스코드 삭제 & 새로운 소스코드 대체
APP_SOURCE=/var/www/html
APP_SOURCE_ARCHIVE=/medongaule/www/html-archive
APP_SOURCE_STANDBY=/medongaule/www/html-standby

rm -rf $APP_SOURCE_ARCHIVE
mv $APP_SOURCE $APP_SOURCE_ARCHIVE
echo Current source-code is archived
mv $APP_SOURCE_STANDBY $APP_SOURCE
echo New source-code is deployed
echo "====================== [END] Update application source code ========================="

echo;
echo "====================== [START] Run Server! ======================="
APP="docker compose -p medongaule "

$APP down

WITH_ENV="--env-file /medongaule/deploy/.env"
WITH_FILE="--file /medongaule/deploy/docker-compose.yaml"
$APP ${WITH_ENV} ${WITH_FILE} up --detach

sleep 10
echo "====================== [END] Run Server! ========================="

echo "====================== [START] Add schedule job with chrony ======================="
CRON_JOB="* * * * * $APP exec -it main schedule-exec"
(crontab -l 2>/dev/null | grep -F "$CRON_JOB") || (crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

CONTENTS_BACKUP_SCRIPT=/medongaule/deploy/scripts/backup.sh
if [ -f "${CONTENTS_BACKUP_SCRIPT}" ]; then
    BACKUP_CRON="30 14 * * * ${CONTENTS_BACKUP_SCRIPT}"
    (crontab -l 2>/dev/null | grep -F "$BACKUP_CRON") || (crontab -l 2>/dev/null; echo "$BACKUP_CRON") | crontab -
fi
echo "====================== [END] Add schedule job with chrony ========================="

$WAIT_FOR_IT localhost:80 -s -t 30