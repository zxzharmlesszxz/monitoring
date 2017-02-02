<?php
// Константы
define("BASEDIR", dirname(__DIR__).'/');
define("ENGINE_SELF", basename($_SERVER['PHP_SELF']));
// Константы таблиц БД
define("QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));
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
$settings = dbarray(dbquery("SELECT * FROM ".DB_SETTINGS));
define("SITE_URL", $settings['site_url']);

// Pathes
define("ADMIN", BASEDIR."admin/");
define("IMAGES", "/images/");
define("MAPS", IMAGES."maps/");
define("INCLUDES", BASEDIR."include/");
define("JS", BASEDIR."include/js/");
define("LOCALE", BASEDIR."locale/");
define("THEME", BASEDIR."templates/");
define("LOCALESET", $settings['locale']."/");
define("USER_IP", (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''));
define("ASR",$settings['AMX']);


