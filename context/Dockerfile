######################################
# docker-openresearch-stack          #
######################################

ARG MEDIAWIKI_VERSION=1.35.5
FROM gesinn/docker-mediawiki-sqlite:${MEDIAWIKI_VERSION}

# start from scratch
RUN rm -rf LocalSettings.php /var/www/data

# add /build-tools and /tools
RUN curl -LJ https://github.com/gesinn-it-pub/docker-mediawiki-tools/tarball/1.0.0 -o /tools.tgz && \
    tar -xzf /tools.tgz -C / --strip-components 1 && rm /tools.tgz
ENV PATH="/tools:/build-tools:${PATH}"
# override by custom tools
COPY tools /tools
RUN chmod +x /build-tools/* /tools/*


######################################
# install required apt packages      #
#
# cron
# ghostscript 1)
# gnupg 3)
# graphviz 2)
# imagemagick 1)
# libpng-dev 4)
# libzip-dev 5)
# poppler-utils 1)
# software-properties-common 3)
# wget 3)
# zip 5)
# zlib1g-dev 4)
#
# 1) PDFHandler
# 2) External_Data Graphviz
# 3) External_Data PlantUML
# 4) php-gd / QRLite (PNG)
# 5) SemanticResultFormats (phpoffice/phpspreadsheet)
######################################
RUN apt-get update && \
    apt-get install -y cron ghostscript gnupg graphviz imagemagick libpng-dev libzip-dev poppler-utils software-properties-common wget zip zlib1g-dev

######################################
# install Java                       #
#
# - External_Data PlantUML
######################################
RUN wget -qO - https://adoptopenjdk.jfrog.io/adoptopenjdk/api/gpg/key/public | sudo apt-key add - && \
    add-apt-repository --yes https://adoptopenjdk.jfrog.io/adoptopenjdk/deb/ && \
    apt-get update && \
    apt-get install -y adoptopenjdk-11-hotspot

RUN rm -rf /var/lib/apt/lists/*

######################################
# install required php packages      #
#
# gd 1)
# zip 2)
#
# 1) QRLite (PNG)
# 2) SemanticResultFormats (phpoffice/phpspreadsheet)
######################################
RUN docker-php-ext-install gd zip

######################################
# install PlantUML                   #
######################################
RUN wget http://netcologne.dl.sourceforge.net/project/plantuml/1.2022.2/plantuml-nodot.1.2022.2.jar -P /usr/share/java && \
    (cd /usr/share/java && ln -snf plantuml-nodot.1.2022.2.jar plantuml.jar)

######################################
# Search Extensions                  #
######################################

### Elastica
RUN get-extension.sh Elastica https://github.com/gesinn-it/extdist.wmflabs.org/raw/main/dist/extensions/Elastica-REL1_35-cffef9d.tar.gz && \
    # explicitly require elasticsearch/elasticsearch 5.5.0 to avoid
    # https://phabricator.wikimedia.org/T267106
    # see also https://phabricator.wikimedia.org/T276854 with note about SMW
    #composer require --no-update elasticsearch/elasticsearch 5.5.0 && \
    (cd extensions/Elastica && chown -R www-data:www-data . && sudo -u www-data composer install --no-dev)

### CirrusSearch (2022-02-07)
RUN get-github-extension.sh CirrusSearch bb6b3475dc813bfb328ba012c880fd938d8a88ce

######################################
# Visual Editor                      #
######################################

## VisualEditor
#RUN rm -rf extensions/VisualEditor && \
#    get-extension.sh VisualEditor https://github.com/gesinn-it/extdist.wmflabs.org/raw/main/dist/extensions/VisualEditor-REL1_35-4e63a2f.tar.gz

######################################
# Skin                               #
######################################

### Chameleon
# RUN composer-require.sh mediawiki/chameleon-skin 4.0.0

######################################
# Extensions                         #
######################################

### SemanticMediaWiki
RUN composer-require.sh mediawiki/semantic-media-wiki 4.0.0

######################################
# composer update                    #
######################################
RUN composer-update.sh

######################################
# patches                            #
######################################
RUN \
    # Autocompletion in search field does not work
    sed -i "s!ApiBase::LIMIT_SML1!100!g" \
	    includes/api/Validator/ApiParamValidator.php

######################################
# add openresearch-stack settings    #
######################################
ADD includes includes/openresearch-stack
ADD LocalSettings.Include.php .
ADD LocalSettings.Extensions.php .
ADD LocalSettings.Debug.php .

######################################
# set openresearch-stack version         #
######################################
ARG OPENRESEARCH_STACK_VERSION=5.1.0-alpha1
RUN echo $OPENRESEARCH_STACK_VERSION > openresearch-stack-version.txt

######################################
# add php-settings                   #
######################################
ADD php-settings /usr/local/etc/php/conf.d
RUN chmod 644 /usr/local/etc/php/conf.d/*

# use as volume for persistent storage of data, e.g. the current LocalSettings.php
RUN mkdir /data

CMD [ "startup-container.sh" ]
