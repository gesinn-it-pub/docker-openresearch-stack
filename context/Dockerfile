######################################
# docker-openresearch-stack          #
######################################

ARG MEDIAWIKI_VERSION=1.35.7
FROM gesinn/docker-mediawiki-sqlite:${MEDIAWIKI_VERSION}

# start from scratch
RUN rm -rf LocalSettings.php /var/www/data

# add /build-tools and /tools
RUN curl -LJ https://github.com/gesinn-it-pub/docker-mediawiki-tools/tarball/1.1.1 -o /tools.tgz && \
    tar -xzf /tools.tgz -C / --strip-components 1 && rm /tools.tgz
# override by custom tools
COPY tools /tools
RUN chmod +x /build-tools/* /tools/*
ENV PATH="/tools:/build-tools:${PATH}"
ADD patches /patches

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
    apt-get install -y cron ghostscript gnupg graphviz imagemagick libpng-dev libzip-dev poppler-utils software-properties-common wget zip zlib1g-dev && \
    rm -rf /var/lib/apt/lists/*

######################################
# install Java                       #
#
# - External_Data PlantUML
######################################
RUN wget -qO - https://adoptopenjdk.jfrog.io/adoptopenjdk/api/gpg/key/public | sudo apt-key add - && \
    add-apt-repository --yes https://adoptopenjdk.jfrog.io/adoptopenjdk/deb/ && \
    apt-get update && \
    apt-get install -y adoptopenjdk-11-hotspot-jre && \
    rm -rf /var/lib/apt/lists/*

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
RUN composer-require.sh mediawiki/chameleon-skin 4.1.0

######################################
# Extensions                         #
######################################

### AdminLinks
RUN get-github-extension.sh AdminLinks 0.4.2

### Arrays (2022-02-06)
RUN get-github-extension.sh Arrays ce3f62878a825ef5df7a79e51fc2da7c95893a65

### Extension:CategoryTree (TODO: required?)

### Extension:WikiEditor
### Required by CodeEditor

### Extension:CodeEditor
### Requires WikiEditor

### CookieWarning (2022-02-06)
RUN get-github-extension.sh CookieWarning a91b78000f25bd907dcc30bf5b2e10371a837552

### ConfirmAccount (REL1_35 2022-03-28)
RUN get-github-extension.sh ConfirmAccount 2681e4d1712c4b2e9b6fcc02fb1aa01bf1f2404b

### ConfirmEdit (enabled as shipped with MediaWiki)

### CSS (2022-02-06)
RUN get-github-extension.sh CSS 91f9d53fc0c58e2772719cf5e9d0bfd3d12151d4

### Extension:DataTransfer

### DateDiff
RUN get-github-extension.sh DateDiff 0.3.1

### DisplayTitle
RUN get-github-extension.sh DisplayTitle 3.1

### Echo (REL1_35 2022-02-21)
RUN get-github-extension.sh Echo 8c593b995992d4d3ede9bef58d39bc070a6cdd8d

### ExternalData
RUN get-github-extension.sh ExternalData 3.0 && \
	patch.sh extensions/ExternalData/sql/ExternalData.sql

### Extension:HeaderTabs

### IDProvider
RUN get-github-extension.sh IDProvider 2.0.2 gesinn-it/IDProvider

#### ImageMap (enabled as shipped with MediaWiki)

### JSBreadCrumbs
RUN get-github-extension.sh JSBreadCrumbs 1.1.0

### LegalLogin (2022-05-20)
RUN get-github-extension.sh LegalLogin 62fcc432c1a6b7281e48c40fb2e83268a91fcc4a

### Loops (2021-12-13)
RUN get-github-extension.sh Loops 8415e0b22bbe6dce5cb4b34c5edf0c27b219e85b

### Maps
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/maps 9.0.7

### Matomo
RUN get-github-extension.sh Matomo v4.0.1 DaSchTour/matomo-mediawiki-extension

### Mermaid
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/mermaid 3.0.1

### Modern Timeline
RUN COMPOSER=composer.local.json composer require --no-update professional-wiki/modern-timeline 1.2.1

### MultimediaViewer (enabled as shipped with MediaWiki)

### NativeSvgHandler (2021-12-05)
RUN get-github-extension.sh NativeSvgHandler 13c02680047ec77fff4a6b7c4919e23c4ce7b081

### Extension:Nuke

### NumberFormat (2022-02-25)
RUN get-github-extension.sh NumberFormat a704f8834afbe21545079d577390a0a89560f072

### OpenLayers (2022-02-25)
RUN get-github-extension.sh OpenLayers e61f5b7c6ff2ad9321ba7c1e3b3e1333b470f870

### ParserFunctions enabled as shipped with MediaWiki)

### PageForms
RUN get-github-extension.sh PageForms 5.3.4 gesinn-it/mediawiki-extensions-PageForms

### TextExtracts (enabled as shipped with MediaWiki)

### PageImages (enabled as shipped with MediaWiki)

### Popups (2022-03-06)
RUN get-github-extension.sh Popups b6eb2627ff3f1fc93060f663efc2f8b302dbb376

### RegexFunctions (2022-01-11)
RUN get-github-extension.sh RegexFunctions af37c1050139b0b83360285e8d7ff9454d4c6ecc

### ReplaceText (enabled as shipped with MediaWiki)

### SemanticMediaWiki
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/semantic-media-wiki 4.0.0

### SemanticCompoundQueries
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/semantic-compound-queries 2.2.0

### SemanticResultFormats
RUN COMPOSER=composer.local.json composer require --no-update phpoffice/phpspreadsheet 1.22.0
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/semantic-result-formats 4.0.1

### SimpleTooltip
RUN get-github-extension.sh SimpleTooltip 2476bff8f4555f86795c26ca5fdb7db99bfe58d1 Fannon/SimpleTooltip

### Extension:TitleBlacklist

### TitleIcon
RUN get-github-extension.sh TitleIcon 5.2

### UrlGetParameters (2021-11-13)
RUN get-github-extension.sh UrlGetParameters ae491b9472ca60ab4a0afa84874824632bd6c833

### UserFunctions (2021-12-12)
RUN get-github-extension.sh UserFunctions b6ac1ddfc3742cd88d71fa9039b06161cbc11b27

### UserMerge (REL1_35 2022-02-28)
RUN get-github-extension.sh UserMerge 81739e0c967286264b132a64941d0da9575d79a1

### Variables
RUN get-github-extension.sh Variables v2.5.1

### VEForAll
RUN get-github-extension.sh VEForAll 0.4

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
# set openresearch-stack version     #
######################################
ARG OPENRESEARCH_STACK_VERSION=0.0.13
RUN echo $OPENRESEARCH_STACK_VERSION > openresearch-stack-version.txt && \
    echo "\$wgOpenResearchStackVersion = '$OPENRESEARCH_STACK_VERSION';" >> LocalSettings.Include.php

######################################
# add php-settings                   #
######################################
ADD php-settings /usr/local/etc/php/conf.d
RUN chmod 644 /usr/local/etc/php/conf.d/*

# use as volume for persistent storage of data, e.g. the current LocalSettings.php
RUN mkdir /data

CMD [ "startup-container.sh" ]
