#!/bin/bash

NGINX_NAME=/usr/local/webserver/nginx/sbin/nginx

#sudo $NGINX_NAME -s stop

SERVER_PIDS=`ps aux | grep nginx | grep root | grep -v "grep"| awk '{print $2}'`
echo "${NGINX_NAME} server pid is ${SERVER_PIDS}"

for SERVER_PID in ${SERVER_PIDS[@]}
do
        while [ $SERVER_PID ]
        do
          sudo kill $SERVER_PID
          sleep 1
          SERVER_PID=`ps aux | grep nginx | grep root | grep -v "grep"| awk '{print $2}'`
        done
done

SERVER_PIDS=`ps aux | grep nginx | grep -v "grep"| awk '{print $2}'`
if [ -z $SERVER_PIDS ] ; then
  echo "${NGINX_NAME} is stoped"
fi
