<?php

class Bucketlist {

    // Egenskaper
    private $db;
    private $name;
    private $description;
    private $priority;

    // Konstruktor för att skapa en anslutning till databasen
    function __construct() {
        // Anslut till databasen och kontrollera om det lyckas
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    // Metod för att lägga till en ny post till bucketlistan (db-tabellen)
    public function addPost(string $name, string $description, int $priority) : bool {

       // Använd prepared statements för att undvika SQL-injections
       $stmt = $this->db->prepare("INSERT INTO bucketlist (name, description, priority) VALUES (?, ?, ?)");
       $stmt->bind_param("ssi", $name, $description, $priority);

       // Returnera true om det lyckas, annars false
       return $stmt->execute(); 
    }
}

