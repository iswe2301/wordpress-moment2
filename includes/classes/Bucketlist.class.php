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
       $stmt->bind_param("ssi", $this->name, $this->description, $this->priority);

       $result = $stmt->execute(); // Kör prepared statement
       $stmt->close(); // Stäng prepared statement
       return $result; // Returnera true om det lyckas, annars false
    }

    // Metod för att hämta alla poster från bucketlistan
    public function getPosts() : array {
        // SQL-fråga för att hämta alla poster sorterade efter prioritet
        $sql = "SELECT * FROM bucketlist ORDER BY priority ASC";
        $result = $this->db->query($sql); // Kör SQL-frågan

        // Kontrollera om frågan misslyckas
        if (!$result) {
            return []; // Returnera tom array
        }

        $posts = $result->fetch_all(MYSQLI_ASSOC); // Hämta alla rader som en associativ array
        return $posts; // Returnera arrayen med poster
    }

     // Metod för att ta bort en post från bucketlistan
     public function deletePost(int $id) : bool {

        // Använd prepared statements
        $stmt = $this->db->prepare("DELETE FROM bucketlist WHERE id = ?");
        $stmt->bind_param("i", $id);

        $result = $stmt->execute(); // Kör prepared statement
        $stmt->close(); // Stäng prepared statement
        return $result; // Returnera true om det lyckas, annars false
    }

        // Metod för att uppdatera en post i bucketlistan
        public function updatePost(int $id, string $name, string $description, int $priority) : bool {

            if(!$this->setName($name)) return false; // Kontrollera att namnet är giltigt
            if(!$this->setDescription($description)) return false; // Kontrollera att beskrivningen är giltig
            if(!$this->setPriority($priority)) return false; // Kontrollera att prioritet är giltig
    
            // Använd prepared statements
            $stmt = $this->db->prepare("UPDATE bucketlist SET name = ?, description = ?, priority = ? WHERE id = ?");
            $stmt->bind_param("ssii", $this->name, $this->description, $this->priority, $id);
    
            $result = $stmt->execute(); // Kör prepared statement
            $stmt->close(); // Stäng prepared statement
            return $result; // Returnera true om det lyckas, annars false
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

