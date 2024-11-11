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

        if(!$this->setName($name)) return false; // Kontrollera att namnet är giltigt
        if(!$this->setDescription($description)) return false; // Kontrollera att beskrivningen är giltig
        if(!$this->setPriority($priority)) return false; // Kontrollera att prioritet är giltig

       // Använd prepared statements för att undvika SQL-injections
       $stmt = $this->db->prepare("INSERT INTO bucketlist (name, description, priority) VALUES (?, ?, ?)");
       $stmt->bind_param("ssi", $name, $description, $priority);

       // Returnera true om det lyckas, annars false
       return $stmt->execute(); 
    }

    // Set-metod för att sätta namn
    public function setName(string $name) : bool {
        // Kontrollera att namnet inte är tomt och inte längre än 64 tecken
        if(!empty($name) && strlen($name) <= 64) {
            $this->name = $name; // Sätt namnet
            return true; // Returnera true om det lyckas
        } else {
            return false; // Returnera false om det misslyckas
        }
    }

    // Set-metod för att sätta beskrivning
    public function setDescription(string $description) : bool {
        // Kontrollera att beskrivningen inte är tomt och inte längre än 255 tecken
        if(!empty($description) && strlen($description) <= 255) {
            $this->description = $description; // Sätt beskrivningen
            return true; // Returnera true om det lyckas
        } else {
            return false; // Returnera false om det misslyckas
        }
    }

    // Set-metod för att sätta prioritet
    public function setPriority(int $priority) : bool {

        // Validera att det är en siffra
        $priority = intval($priority);

        // Kontrollera att prioritet är mellan 1 och 5
        if($priority >= 1 && $priority <= 5) {
            $this->priority = $priority; // Sätt prioritet
            return true; // Returnera true om det lyckas
        } else {
            return false; // Returnera false om det misslyckas
        }
    }
}

