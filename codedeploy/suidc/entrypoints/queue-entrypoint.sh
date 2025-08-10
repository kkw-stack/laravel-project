#!/usr/bin/env bash

HOST=$DB_HOST
PORT=$DB_PORT

wait-for-it $HOST:$PORT -s -t 100

sleep 5

/usr/bin/supervisord -n -c /etc/supervisord.queue.conf