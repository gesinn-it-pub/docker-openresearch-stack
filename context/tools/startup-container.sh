#!/bin/bash

set -euxo pipefail

service cron start
initialize-wiki.sh
apache2-foreground
