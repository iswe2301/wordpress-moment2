<?php
// Starta sessionen
session_start();

// Kontrollera utvecklingsläge
$devMode = true;

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
    define('DBHOST', 'localhost');
    define('DBUSER', 'bucketdb');
    define('DBPASS', 'password');
    define('DBDATABASE', 'bucketdb');
} else {
    // Publicerade databasinställningar
}