<?php

//////////////////////////////////////////
// Search Extensions                    //
//////////////////////////////////////////

## -------- Elastica --------
wfLoadExtension( "Elastica" );
## ======== Elastica ========

## -------- CirrusSearch --------
wfLoadExtension( "CirrusSearch" );
$wgCirrusSearchServers = [$wgNetworkEnvironment[ 'ELASTICSEARCH_HOST' ] ?? "127.0.0.1" ];
$wgSearchType = "CirrusSearch";
$wgCirrusSearchPrefixSearchStartsWithAnyWord = true;
## ======== CirrusSearch ========

//////////////////////////////////////////
// Visual Editor                        //
//////////////////////////////////////////

## -------- VisualEditor --------
wfLoadExtension( "VisualEditor" );
## ======== VisualEditor ========

//////////////////////////////////////////
// Other Extensions                     //
//////////////////////////////////////////

## -------- Chameleon --------
# Chameleon included via Composer
wfLoadExtension( 'Bootstrap' );
wfLoadSkin( 'chameleon' );
$wgDefaultSkin="chameleon";
$egChameleonLayoutFile= __DIR__ . "/skins/chameleon/layouts/fixedhead.xml";
## ======== Chameleon ========

## -------- SemanticMediaWiki --------
# SemanticMediaWiki included via Composer
wfLoadExtension( "SemanticMediaWiki" );
enableSemantics( $wgServer );
## ======== SemanticMediaWiki ========
