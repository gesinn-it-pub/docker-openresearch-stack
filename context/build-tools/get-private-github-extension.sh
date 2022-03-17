#!/bin/bash
EXTENSION=$1
VERSION=$2
USER_AND_EXTENSION=${3:-gesinn-it/$EXTENSION}

EXTENSION_URL=https://api.github.com/repos/$USER_AND_EXTENSION/tarball/$VERSION
echo Getting $EXTENSION_URL ...

TGZ_FILE=/tmp/$EXTENSION-$VERSION.tgz
EXTENSION_FOLDER=extensions/$EXTENSION

curl -L -H "Authorization: token $(cat /run/secrets/GH_API_TOKEN)" $EXTENSION_URL -o $TGZ_FILE && \
mkdir $EXTENSION_FOLDER && \
tar -xzf $TGZ_FILE -C $EXTENSION_FOLDER --strip-components 1 && \
rm $TGZ_FILE
