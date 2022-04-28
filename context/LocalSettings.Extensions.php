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

## -------- AdminLinks --------
wfLoadExtension( "AdminLinks" );
## ======== AdminLinks ========

## -------- Arrays --------
wfLoadExtension( "Arrays" );
## ======== Arrays ========

## -------- CookieWarning --------
# wfLoadExtension( "CookieWarning" );
## ======== CookieWarning ========

## -------- ConfirmAccount --------
# wfLoadExtension( "ConfirmAccount" );
## ======== ConfirmAccount ========

## -------- ConfirmEdit --------
# wfLoadExtensions([ 'ConfirmEdit', 'ConfirmEdit/QuestyCaptcha' ]);
## ======== ConfirmEdit ========

## -------- CSS --------
wfLoadExtension( "CSS" );
## ======== CSS ========

## -------- DateDiff --------
require_once( "$IP/extensions/DateDiff/DateDiff.php" );
## ======== DateDiff ========

## -------- DisplayTitle --------
wfLoadExtension( "DisplayTitle" );
## ======== DisplayTitle ========

## -------- Echo --------
wfLoadExtension( "Echo" );
## ======== Echo ========

## -------- ExternalData --------
wfLoadExtension( "ExternalData" );
## ======== ExternalData ========

## -------- SyntaxHighlight_GeSHi --------
wfLoadExtension( "SyntaxHighlight_GeSHi" );
## ======== SyntaxHighlight_GeSHi ========

## -------- IDProvider --------
wfLoadExtension( "IDProvider" );
## ======== IDProvider ========

## -------- JSBreadCrumbs --------
wfLoadExtension( "JSBreadCrumbs" );
## ======== JSBreadCrumbs ========

## -------- Loops --------
wfLoadExtension( "Loops" );
$egLoopsCountLimit = 1000;
## ======== Loops ========

## -------- Maps --------
# Maps included via Composer
wfLoadExtension( "Maps" );
## ======== Maps ========

## -------- Matomo --------
# wfLoadExtension( "Matomo" );
## ======== Matomo ========

## -------- Mermaid --------
# Mermaid included via Composer
wfLoadExtension( "Mermaid" );
## ======== Mermaid ========

## -------- MultimediaViewer --------
wfLoadExtension( "MultimediaViewer" );
## ======== MultimediaViewer ========

## -------- NativeSvgHandler --------
wfLoadExtension( "NativeSvgHandler" );
## ======== NativeSvgHandler ========

## -------- NumberFormat --------
require_once( "$IP/extensions/NumberFormat/NumberFormat.php" );
## ======== NumberFormat ========

## -------- OpenLayers --------
wfLoadExtension( "OpenLayers" );
## ======== OpenLayers ========

## -------- ParserFunctions --------
wfLoadExtension( "ParserFunctions" );
$wgPFEnableStringFunctions = true;
## ======== ParserFunctions ========

## -------- PageForms --------
wfLoadExtension( "PageForms" );
## ======== PageForms ========

## -------- TextExtracts --------
## required by Popups
wfLoadExtension( "TextExtracts" );
## ======== TextExtracts ========

## -------- PageImages --------
## required by Popups
wfLoadExtension( "PageImages" );
## ======== PageImages ========

## -------- Popups --------
# wfLoadExtension( "Popups" );
## ======== Popups ========

## -------- RegexFunctions --------
wfLoadExtension( "RegexFunctions" );
## ======== RegexFunctions ========

## -------- ReplaceText --------
wfLoadExtension( "ReplaceText" );
## ======== ReplaceText ========

## -------- SemanticMediaWiki --------
# SemanticMediaWiki included via Composer
wfLoadExtension( "SemanticMediaWiki" );
enableSemantics( $wgServer );
## ======== SemanticMediaWiki ========

## -------- SemanticCompoundQueries --------
# SemanticCompoundQueries included via Composer
wfLoadExtension( "SemanticCompoundQueries" );
## ======== SemanticCompoundQueries ========

## -------- SemanticResultFormats --------
# SemanticResultFormats included via Composer
wfLoadExtension( "SemanticResultFormats" );
## ======== SemanticResultFormats ========

## -------- SimpleTooltip --------
require_once( "$IP/extensions/SimpleTooltip/SimpleTooltip.php" );
## ======== SimpleTooltip ========

## -------- TitleIcon --------
wfLoadExtension( "TitleIcon" );
## ======== TitleIcon ========

## -------- UrlGetParameters --------
wfLoadExtension( "UrlGetParameters" );
## ======== UrlGetParameters ======

## -------- UserFunctions --------
wfLoadExtension( "UserFunctions" );
## ======== UserFunctions ========

## -------- UserMerge --------
wfLoadExtension( "UserMerge" );
## ======== UserMerge ========

## -------- Variables --------
wfLoadExtension( "Variables" );
## ======== Variables ========

## -------- VEForAll --------
wfLoadExtension( "VEForAll" );
## ======== VEForAll ========
