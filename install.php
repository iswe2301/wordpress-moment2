<?php

// Inkludera konfigurationsfil
include('includes/config.php');

// Skapa anslutning till databas, kontrollera om det går att ansluta
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_error) {
    die('Fel vid anslutning (' . $db->connect_errno . ') ' . $db->connect_error);
}

// Skapa ny tabell om den inte redan finns
$sql = "DROP TABLE IF EXISTS bucketlist;";
$sql .= "CREATE TABLE bucketlist (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    priority INT(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

echo "<pre>$sql</pre>";

if ($db->multi_query($sql)) {
    echo "Tabell skapad!";
} else {
    echo "Fel vid installation av tabell...";
}