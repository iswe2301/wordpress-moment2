<?php
// Starta sessionen om den inte redan är startad
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

// Kontrollera utvecklingsläge
$devMode = false;

if ($devMode) {
// Aktivera felmeddelanden
error_reporting(-1);
ini_set('display_errors', '1');
}

// Aktivera stöd för att inkludera klassfiler automatiskt
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

if($devMode) {
    // Lokala databasinställningar
    if(!defined('DBHOST')) define('DBHOST', 'localhost');
    if(!defined('DBUSER')) define('DBUSER', 'bucketdb');
    if(!defined('DBPASS')) define('DBPASS', 'password');
    if(!defined('DBDATABASE')) define('DBDATABASE', 'bucketdb');
} else {
    // Publicerade databasinställningar
    if(!defined('DBHOST')) define('DBHOST', 'localhost');
    if(!defined('DBUSER')) define('DBUSER', 's116499_bucketdb');
    if(!defined('DBPASS')) define('DBPASS', 'AWL5KpHUQEECFRrDF9a3');
    if(!defined('DBDATABASE')) define('DBDATABASE', 's116499_bucketdb');
}