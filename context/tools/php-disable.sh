#!/bin/bash

INI_FILE=$1

mv $INI_FILE $INI_FILE.DISABLED && \
service apache2 status > /dev/null 2>&1 && service apache2 reload
exit 0
