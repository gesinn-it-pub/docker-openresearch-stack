#!/bin/bash
EXTENSION=$1
VERSION=$2
EXTENSION_URL_PATH=${3:-wikimedia/mediawiki-extensions-$EXTENSION}

EXTENSION_URL=https://github.com/$EXTENSION_URL_PATH/tarball/$VERSION

get-extension.sh $EXTENSION $EXTENSION_URL
