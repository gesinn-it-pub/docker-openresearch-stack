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
$egArraysCompatibilityMode = false;
$egArraysExpansionEscapeTemplates = null;
## ======== Arrays ========

## -------- CookieWarning --------
# wfLoadExtension( "CookieWarning" );
## ======== CookieWarning ========

## -------- ConfirmEdit --------
# wfLoadExtensions([ 'ConfirmEdit', 'ConfirmEdit/QuestyCaptcha' ]);
$wgCaptchaClass = "QuestyCaptcha";
$wgCaptchaTriggers['edit']          = true;
$wgCaptchaTriggers['create']        = true;
$wgCaptchaTriggers['createtalk']    = true;
$wgCaptchaTriggers['addurl']        = true;
$wgCaptchaTriggers['createaccount'] = true;
$wgCaptchaTriggers['badlogin']      = true;
$wgCaptchaQuestions[] = array( "question" => "Germany's highest mountain?", "answer" => "Zugspitze");
$wgCaptchaQuestions[] = array( "question" => "Germany's capital?", "answer" => "Berlin");
# $wgCaptchaQuestions[] = array( "question" => "Deutschlands höchster Berg?", "answer" => "Zugspitze");
# $wgCaptchaQuestions[] = array( "question" => "Deutschlands Hauptstadt?", "answer" => "Berlin");
## ======== ConfirmEdit ========

## -------- CSS --------
wfLoadExtension( "CSS" );
## ======== CSS ========

## -------- DateDiff --------
require_once( "$IP/extensions/DateDiff/DateDiff.php" );
## ======== DateDiff ========

## -------- DisplayTitle --------
wfLoadExtension( "DisplayTitle" );
$wgAllowDisplayTitle = true;
$wgRestrictDisplayTitle = false;
$wgDisplayTitleHideSubtitle = true;
$wgDisplayTitleExcludes = [ "Special:ListRedirects", "Special:DoubleRedirects", "Special:MovePage" ];
## ======== DisplayTitle ========

## -------- Echo --------
wfLoadExtension( "Echo" );
## ======== Echo ========

## -------- ExternalData --------
wfLoadExtension( "ExternalData" );

$wgExternalDataSources['graphviz'] = [
	'name'              => 'GraphViz',
	'program url'       => 'https://graphviz.org/',
	'version command'   => null,
	'command'           => 'dot -K$layout$ -Tsvg',
	'params'            => [ 'layout' => 'dot' ],
	'param filters'     => [ 'layout' => '/^(dot|neato|twopi|circo|fdp|osage|patchwork|sfdp)$/' ],
	'input'             => 'dot',
	'preprocess'        => 'EDConnectorExe::wikilinks4dot',
	'postprocess'       => 'EDConnectorExe::innerXML',
	'min cache seconds' => 30 * 24 * 60 * 60,
	'tag'               => 'graphviz'
];

$wgExternalDataSources['plantuml'] = [
	'name'				=> 'PlantUML',
	'program url'		=> 'https://plantuml.com',
	'version command'	=> 'java -jar /usr/share/java/plantuml.jar -version',
	'command'			=> 'java -jar /usr/share/java/plantuml.jar -tsvg -charset UTF-8 -p',
	'env'				=> [ 'LOG4J_FORMAT_MSG_NO_LOOKUPS' => true ],
	'limits'			=> [ 'memory' => 0 ],
	'params'			=> [ 'uml' ],
	'input'				=> 'uml',
	'preprocess'		=> 'EDConnectorExe::wikilinks4uml',
	'postprocess'		=> 'EDConnectorExe::innerXML',
	'min cache seconds'	=> 30 * 24 * 60 * 60,
	'tag'				=> 'plantuml'
];
## ======== ExternalData ========

## -------- IDProvider --------
wfLoadExtension( "IDProvider" );
## ======== IDProvider ========

## -------- JSBreadCrumbs --------
wfLoadExtension( "JSBreadCrumbs" );
$wgJSBreadCrumbsHorizontalSeparator = '>';
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
$wgPageFormsAutocompleteOnAllChars = true;
$wgPageFormsMaxAutocompleteValues = 3000;;
$wgPageFormsMaxLocalAutocompleteValues = 5000;
$wgPageForms24HourTime = true;
$wgPageFormsListSeparator = ";";
## ======== PageForms ========

## -------- TextExtracts --------
## required by Popups
wfLoadExtension( "TextExtracts" );
## ======== TextExtracts ========

## -------- PageImages --------
## required by Popups
wfLoadExtension( "PageImages" );
$wgPageImagesLeadSectionOnly = false;
## ======== PageImages ========

## -------- Popups --------
# wfLoadExtension( "Popups" );
$wgPopupsHideOptInOnPreferencesPage = true;
$wgPopupsOptInDefaultState = "1";
$wgPopupsReferencePreviewsBetaFeature = false;
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
$srfgFormats[] = "gantt";
$srfgFormats[] = "graph";
$srfgFormats[] = "excel";
$srfgFormats[] = "filtered";
## ======== SemanticResultFormats ========

## -------- SimpleTooltip --------
require_once( "$IP/extensions/SimpleTooltip/SimpleTooltip.php" );
## ======== SimpleTooltip ========

## -------- TitleIcon --------
wfLoadExtension( "TitleIcon" );
$wgTitleIcon_CSSSelector = "h1.firstHeading";
$wgTitleIcon_UseFileNameAsToolTip = false;
## ======== TitleIcon ========

## -------- UrlGetParameters --------
wfLoadExtension( "UrlGetParameters" );
## ======== UrlGetParameters ======

## -------- UserFunctions --------
wfLoadExtension( "UserFunctions" );
$wgUFEnablePersonalDataFunctions = true;
$wgUFAllowedNamespaces[NS_MAIN] = true;
## ======== UserFunctions ========

## -------- UserMerge --------
wfLoadExtension( "UserMerge" );
$wgGroupPermissions["sysop"]["usermerge"] = true;
$wgGroupPermissions["bureaucrat"]["usermerge"] = true;
## ======== UserMerge ========

## -------- Variables --------
wfLoadExtension( "Variables" );
## ======== Variables ========

## -------- VEForAll --------
wfLoadExtension( "VEForAll" );
## ======== VEForAll ========
