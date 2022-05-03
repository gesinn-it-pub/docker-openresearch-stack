<?php

if (file_exists( "$IP/LocalSettings.Debug.php" )) {
    require_once( "$IP/LocalSettings.Debug.php" );
}

foreach (glob("$IP/includes/openresearch-stack/10-*.php") as $filename) {
    require_once($filename);
}

if (file_exists( "$IP/LocalSettings.Extensions.php" )) {
    require_once( "$IP/LocalSettings.Extensions.php" );
}

foreach (glob("$IP/includes/openresearch-stack/9*.php") as $filename) {
    require_once($filename);
}

if (file_exists( "$IP/LocalSettings.Custom.php" )) {
    require_once( "$IP/LocalSettings.Custom.php" );
}

if (file_exists( "$IP/LocalSettings.CustomPermissions.php" )) {
    require_once( "$IP/LocalSettings.CustomPermissions.php" );
}

# for temporary requirements, used e.g. by cirrus search initialization
if (file_exists( "$IP/LocalSettings.TMP.php" )) {
    require_once( "$IP/LocalSettings.TMP.php" );
}

# versions
