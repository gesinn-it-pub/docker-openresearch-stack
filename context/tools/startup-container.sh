#!/bin/bash

set -euxo pipefail

service cron start
service memcached start
initialize-wiki.sh
apache2-foreground
