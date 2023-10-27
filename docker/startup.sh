#!/bin/sh

sed -i "s,LISTEN_PORT,$PORT,g" /etc/nginx/nginx.conf

/usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisor.conf