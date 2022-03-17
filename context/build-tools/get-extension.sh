#!/bin/bash
EXTENSION=$1
EXTENSION_URL=${2}

echo Getting $EXTENSION_URL ...

TGZ_FILE=/tmp/$EXTENSION.tgz
EXTENSION_FOLDER=extensions/$EXTENSION

curl -LJ $EXTENSION_URL -o $TGZ_FILE && \
mkdir $EXTENSION_FOLDER && \
tar -xzf $TGZ_FILE -C $EXTENSION_FOLDER --strip-components 1 && \
rm $TGZ_FILE
