<?php
// Константы
define("BASEDIR", __DIR__.'../');
define("ENGINE_SELF", basename($_SERVER['PHP_SELF']));
define("QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));
define("SITE_URL", $settings['site_url']);
//define("JAC_OPNMA", $db_name);
define("ADMIN", BASEDIR."admin/");
define("IMAGES", BASEDIR."images/");
define("MAPS", IMAGES."maps/");
define("INCLUDES", BASEDIR."include/");
define("JS", BASEDIR."include/js/");
define("LOCALE", BASEDIR."locale/");
define("THEME", BASEDIR."templates/");
define("LOCALESET", $settings['locale']."/");
define("USER_IP", $_SERVER['REMOTE_ADDR']);
define("ASR",$settings['AMX']);

// Константы таблиц БД
define("DB_ADMIN", DB_PREFIX."admin");
define("DB_BLACKLIST", DB_PREFIX."blacklist");
define("DB_MESSAGES", DB_PREFIX."messages");
define("DB_SETTINGS", DB_PREFIX."settings");
define("DB_USERS", DB_PREFIX."users");
define("DB_SERVERS", DB_PREFIX."servers");
define("DB_VOTES", DB_PREFIX."vote_ip");
define("DB_COMMENTS", DB_PREFIX."comments");
define("DB_ROWSTYLES", DB_PREFIX."rowstyles");
define("DB_SERVERS_EDITS", DB_PREFIX."servers_edits");
