#!/bin/bash

## 20250310: 현재 해당 스크립트는 자동배포 되지 않음. 수동 구성해야함!

CURRENT=$(pwd)

## 환경변수 가져오기
DEPLOY_ENV_VARS=/medongaule/deploy/.env

project_name=${PROJECT_NAME:-medongaule}
app_version="$(grep '^APP_VERSION=' ${DEPLOY_ENV_VARS} | sed 's/^APP_VERSION=//g')"
if [ "${app_version}" == 'prod' ]; then
    app_version=production
fi
db_name="$(grep '^DB_DATABASE=' ${DEPLOY_ENV_VARS} | sed 's/^DB_DATABASE=//g')"
db_user="$(grep '^DB_USERNAME=' ${DEPLOY_ENV_VARS} | sed 's/^DB_USERNAME=//g')"
db_pass="$(grep '^DB_PASSWORD=' ${DEPLOY_ENV_VARS} | sed 's/^DB_PASSWORD=//g')"
backup_date=$(date -u +"%Y%m%d")
backup_tmpdir=/tmp/medongaule-backup/${backup_date}
dest_bucket_name=medongaule-${app_version}-backup-contents-bucket

echo "ProjectName: ${project_name}"
echo "Env: ${app_version}"
echo "DBName: ${db_name}"
echo "DBUser: ${db_user}"
echo "DBPass: ****"
echo "BackupDate: ${backup_date}"
echo "BackupTmpDir: ${backup_tmpdir}"

## 백업용 디렉토리 생성
mkdir -p ${backup_tmpdir}

## TMP BACKUP - Database
tmp_db_backup_dest=${backup_tmpdir}/db-backup.sql
docker compose -p ${project_name} exec mariadb mariadb-dump -u"${db_user}" -p"${db_pass}" ${db_name} > ${tmp_db_backup_dest}
echo "tmp-db-backup: ${tmp_db_backup_dest}"

## TMP BACKUP - User Contents
tmp_user_content_backup_dest=${backup_tmpdir}/user-contents.tar.gz
cd /var/www/user-contents
tar -zcf ${tmp_user_content_backup_dest} ./
echo "tmp-user-contents-backup: ${tmp_user_content_backup_dest}"
cd ${CURRENT}

backup_dest=s3://${dest_bucket_name}/${backup_date}
aws s3 cp --recursive ${backup_tmpdir} ${backup_dest}/

## Clean Up
echo "Delete: $(dirname ${tmp_user_content_backup_dest})"
echo "Delete: ${backup_tmpdir}"
rm -rf ${backup_tmpdir}