#!/bin/bash

set -euo pipefail

PASS=wiki4everyone
INSTALLDBUSER=root
INSTALLDBPASS=database
DBNAME=wiki
DBUSER=wiki
DBPASS=wiki
WIKINAME=wiki
ADMIN=WikiSysop

WIKI_PROTOCOL=${WIKI_PROTOCOL:-http}
WIKI_DOMAIN=${WIKI_DOMAIN:-wiki}
WIKI_PORT=${WIKI_PORT:-80}
MYSQL_HOST=${MYSQL_HOST:-}
ELASTICSEARCH_HOST=${ELASTICSEARCH_HOST:-}

run_jobs() {
  sudo -u www-data php maintenance/runJobs.php
}

install_mediawiki() {
  if [ "$MYSQL_HOST" != "" ]; then
    echo "Using mysql db at $MYSQL_HOST."
    DB_CONFIG="--dbtype=mysql --dbserver=$MYSQL_HOST --installdbuser=$INSTALLDBUSER --installdbpass=$INSTALLDBPASS"

    echo "Waiting for mysql server to be ready..."
    wait-for-it.sh -h $MYSQL_HOST -p 3306 -t 60
  else
    echo "Using sqlite db"
    SQLITE_DB_PATH=/data/sqlite
    DB_CONFIG="--dbtype=sqlite --dbpath=$SQLITE_DB_PATH"
    mkdir -p $SQLITE_DB_PATH
    chown -R www-data $SQLITE_DB_PATH
  fi

  echo "Installing MediaWiki"
  SERVER="$WIKI_PROTOCOL://$WIKI_DOMAIN:$WIKI_PORT"
  sudo -u www-data php maintenance/install.php \
    --scriptpath="" \
    --pass=$PASS \
    --server=$SERVER \
    --dbname=$DBNAME \
    --dbuser=$DBUSER \
    --dbpass=$DBPASS \
    $DB_CONFIG $WIKINAME $ADMIN

  run_jobs
}

install_openresearch_stack() {
  echo "Adding OpenResearch Stack"

  echo '$wgOpenResearchStackEnvironment = [];' >>LocalSettings.php
  test "$ELASTICSEARCH_HOST" != "" && echo "\$wgOpenResearchStackEnvironment[ 'ELASTICSEARCH_HOST' ] = '$ELASTICSEARCH_HOST';" >>LocalSettings.php
  echo "require_once( 'LocalSettings.OpenResearchStack.php' );" >>LocalSettings.php

  sudo -u www-data php maintenance/update.php --skip-external-dependencies --quick
}

install_chameleon() {
  echo "(Re-)installing Chameleon Skin"

  COMPOSER=composer.local.json composer require --no-update mediawiki/chameleon-skin 4.0.0
  # sudo -u www-data composer update mediawiki/chameleon-skin --no-dev -o
  sudo -u www-data composer update mediawiki/chameleon-skin -o
}

initialize_cirrus() {
  if [ "$ELASTICSEARCH_HOST" != "" ]; then
    echo "Initializing Cirrus Search"
    echo "Waiting for elasticsearch server to be ready..."
    wait-for-it.sh -h $ELASTICSEARCH_HOST -p 9200 -t 60
    echo '<?php $wgDisableSearchUpdate = true; echo "*** Inside TMP ***\n"; ' >>LocalSettings.TMP.php
    php extensions/CirrusSearch/maintenance/UpdateSearchIndexConfig.php &&
      rm LocalSettings.TMP.php &&
      php extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipLinks --indexOnSkip &&
      php extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipParse
  fi
}

save_settings() {
  echo "Saving LocalSettings for later"
  cp LocalSettings.php extensions/SemanticMediaWiki/.smw.json /data
}

restore_settings() {
  cp /data/LocalSettings.php .
  cp /data/.smw.json extensions/SemanticMediaWiki
}

setup_cron_job() {
  echo "Setting up cron job for wiki jobs"
  echo "*/1 * * * * /usr/bin/timeout -k 60 300 /usr/local/bin/php /var/www/html/maintenance/runJobs.php --maxtime 50 >> /dev/null 2>&1" | crontab -uwww-data -
}

if [ -e LocalSettings.php ]; then
  # Case 1: The container has already been started before
  echo "LocalSettings.php exists. Nothing to do."
else
  # Case 2: The container is starting the first time after creation from the image
  echo "LocalSettings.php is missing."
  configure-container.sh

  if [ -e /data/LocalSettings.php ]; then
    # Case 2a: there has already been a running container for this environment
    echo "Settings in /data exist. Taking them."
    restore_settings
    install_chameleon
  else
    # Case 2a: this is a completely fresh environment which has to be initialized first
    echo "/data/LocalSettings.php missing, too. Need to create one."
    install_mediawiki
    install_chameleon
    install_openresearch_stack
    initialize_cirrus
    save_settings
    run_jobs
  fi
  setup_cron_job
fi
