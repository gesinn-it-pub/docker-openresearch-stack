<?php
############################################################################
##    SETTINGS                                                            ##
############################################################################

## PHP Settings
# increase limits of maximum execution time (defaut 30) to avoid issues
# with long running scripts, e.g. Special:Import
set_time_limit(300);

## MediaWiki Settings
$wgFixDoubleRedirects = true;
$wgAPIMaxDBRows = 25000;
$wgPFEnableStringFunctions = true;
$wgCacheDirectory = "$IP/cache";
$wgJobRunRate = 0;
$wgFavicon = "$wgScriptPath/favicon.ico";


## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgParserCacheType = CACHE_NONE;
$wgMessageCacheType = CACHE_NONE;

#$wgMainCacheType = CACHE_MEMCACHED;
#$wgParserCacheType = CACHE_MEMCACHED;
#$wgMessageCacheType = CACHE_MEMCACHED;

#$wgMemCachedServers = array( "127.0.0.1:11211" );

## Shell Memory Settings (required e.g. by PDF Handler for large PDFs)
$wgMaxShellFileSize=614400;
$wgMaxShellMemory=614400;

## Password Attempt Throttle
$wgPasswordAttemptThrottle = [ [ 'count' => 5, 'seconds' => 3600 ], [ 'count' => 2, 'seconds' => 300 ] ];

## E-Mail
$wgEnableEmail      = true;
$wgEnableUserEmail  = true; # UPO

$wgEmergencyContact = "support@acme.com";
$wgPasswordSender   = "support@acme.com";

$wgEnotifUserTalk      = true; # UPO
$wgEnotifWatchlist     = true; # UPO
$wgEmailAuthentication = true;

$wgSMTP = array(
    'host' => 'mail.acme.com',
  'IDHost' => 'acme.com',
    'port' => 25,
'username' => 'test',
'password' => 'secret',
    'auth' => true
);


## Timezone
$wgLocaltimezone = "Europe/Berlin";
putenv("TZ=$wgLocaltimezone");
$wgLocalTZoffset = date("Z") / 60;
$wgDefaultUserOptions['timecorrection'] = 'ZoneInfo|' . (date("I") ? 120 : 60) . '|Europe/Berlin';

#### User Preference Options
## Default Language UPO
$wgDefaultUserOptions['language'] = 'en';

## Files UPO
$wgDefaultUserOptions['thumbsize'] = 0;     # 0 defaults to 60px

## SMW UPO
$wgDefaultUserOptions['smw-prefs-general-options-time-correction'] = 1;
$wgDefaultUserOptions['smw-prefs-general-options-disable-search-info'] = 1;
$wgDefaultUserOptions['smw-prefs-general-options-suggester-textinput'] = 1;
####

## Edit Redlinks with VE by default
$wgHooks['HtmlPageLinkRendererBegin'][] = function ( $linkRenderer, $target, &$text, &$extraAttribs, &$query, &$ret ) {
	$title = Title::newFromLinkTarget( $target );
	if ( !$title->isKnown() ) {
		$query['veaction'] = 'edit';
		$query['action'] = 'view'; // Prevent MediaWiki from overriding veaction
	}
};

## Disable Patrolled Edits
$wgUseRCPatrol = false;
$wgUseNPPatrol = false;

## Files
$wgEnableUploads = true;
$wgFileExtensions = [ 'png', 'gif', 'jpg', 'jpeg', 'svg', 'webp' ];
$wgVerifyMimeType = false;      # required to allow e.g. docx