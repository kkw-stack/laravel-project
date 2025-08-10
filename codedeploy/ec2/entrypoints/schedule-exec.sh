#!/usr/bin/env bash

# 매 1분마다 크론탭으로 실행되는 스크립트.
# 공지사항 등 게시글을 특정 시간에 공개로 전환하는데 사용된다.

PHP=/usr/local/bin/php
ARTISAN=/var/www/html/artisan

${PHP} ${ARTISAN} schedule:run >/dev/null