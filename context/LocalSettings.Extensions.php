<?php

//////////////////////////////////////////
// Search Extensions                    //
//////////////////////////////////////////

## -------- Elastica --------
wfLoadExtension( "Elastica" );
## ======== Elastica ========

## -------- CirrusSearch --------
wfLoadExtension( "CirrusSearch" );
$wgCirrusSearchServers = [$wgOpenResearchStackEnvironment[ 'ELASTICSEARCH_HOST' ] ?? "127.0.0.1" ];
$wgSearchType = "CirrusSearch";
$wgCirrusSearchPrefixSearchStartsWithAnyWord = true;
## ======== CirrusSearch ========

//////////////////////////////////////////
// Visual Editor                        //
//////////////////////////////////////////

## -------- VisualEditor --------
wfLoadExtension( 'Parsoid', "$IP/vendor/wikimedia/parsoid/extension.json" );
wfLoadExtension( "VisualEditor" );
$wgHiddenPrefs[] = "visualeditor-enable";
$wgDefaultUserOptions["visualeditor-enable-experimental"] = 1;
$wgVirtualRestConfig['modules']['parsoid'] = [
	'url' => 'http://localhost/rest.php'
];
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