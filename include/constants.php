<?php
prof_flag("Including " . __FILE__);
// Константы
define("BASEDIR", dirname(__DIR__) . '/');
define("ENGINE_SELF", basename($_SERVER['PHP_SELF']));
// Константы таблиц БД
define("QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));
define("DB_ADMIN", DB_PREFIX . "admin");
define("DB_BLACKLIST", DB_PREFIX . "blacklist");
define("DB_MESSAGES", DB_PREFIX . "messages");
define("DB_SETTINGS", DB_PREFIX . "settings");
define("DB_USERS", DB_PREFIX . "users");
define("DB_SERVERS", DB_PREFIX . "servers");
define("DB_VOTES", DB_PREFIX . "vote_ip");
define("DB_COMMENTS", DB_PREFIX . "comments");
define("DB_ROWSTYLES", DB_PREFIX . "rowstyles");
define("DB_SERVERS_EDITS", DB_PREFIX . "servers_edits");

// Pathes
define("ADMIN", BASEDIR . "admin/");
define("IMAGES", "/images/");
define("MAPS", IMAGES . "maps/");
define("INCLUDES", BASEDIR . "include/");
define("JS", BASEDIR . "include/js/");
define("LOCALE", BASEDIR . "locale/");
define("THEME", BASEDIR . "templates/");
define("USER_IP", (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''));

$games = [
    'cs16' => 'CS 1.6',
    'csgo' => 'CS: GO',
    'cssource' => 'CS: Source',
    'cszero' => 'CS: Zero',
    'hl' => 'Half-Life',
    'hl2' => 'Half-Life 2',
    'l4d' => 'Left 4 dead',
    'l4d2' => 'Left 4 dead 2',
    'teamfortess' => 'Team Fortess',
    'garrysmod' => 'Garry\'s Mod',
];

$modes = [
    'classic' => 'Classic',
    'warcraft' => 'WarCraft',
    'csdm' => 'DeathMatch',
    'gungame' => 'Gun Game',
    'hns' => 'HNS',
    'surf' => 'Surf',
    'jump' => 'Jump',
    'deathrun' => 'Deathrun',
    'diablomod' => 'Diablo',
    'superhero' => 'Super Hero',
    'jailbreak' => 'Jail Break',
    'soccerjam' => 'SoccerJam',
    'knife' => 'Knife',
    'zombiemod' => 'Zombie',
];