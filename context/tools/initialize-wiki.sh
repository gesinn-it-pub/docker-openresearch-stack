#!/bin/bash

set -euo pipefail

ELASTICSEARCH_HOST=${ELASTICSEARCH_HOST:-}

setup_local_settings() {
    echo "Setting up LocalSettings.php"

    echo '$wgNetworkEnvironment = [];' >> LocalSettings.php;
    if [ "$ELASTICSEARCH_HOST" != "" ]; then
        echo "\$wgNetworkEnvironment[ 'ELASTICSEARCH_HOST' ] = '$ELASTICSEARCH_HOST';" >> LocalSettings.php;
    fi
    echo 'if (file_exists( "$IP/LocalSettings.Extensions.php" )) require_once( "$IP/LocalSettings.Extensions.php" );' >> LocalSettings.php

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
        echo '<?php $wgDisableSearchUpdate = true; echo "*** Inside TMP ***\n"; ' >> LocalSettings.TMP.php
        php extensions/CirrusSearch/maintenance/UpdateSearchIndexConfig.php && \
        rm LocalSettings.TMP.php && \
        php extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipLinks --indexOnSkip && \
        php extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipParse
    fi
}

save_settings() {
    echo "Saving LocalSettings for later"
    cp LocalSettings.php /data
    if [ -e extensions/SemanticMediaWiki/.smw.json ]; then
        cp extensions/SemanticMediaWiki/.smw.json /data
    fi
}

restore_settings() {
    cp /data/LocalSettings.php .
    if [ -e /data/.smw.json ]; then
        cp /data/.smw.json extensions/SemanticMediaWiki
    fi
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

		install-mediawiki.sh
        install_chameleon
        setup_local_settings
        initialize_cirrus
        save_settings
        run-jobs.sh
    fi
    setup_cron_job
fi
