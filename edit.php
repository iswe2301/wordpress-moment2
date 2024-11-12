<?php
    // Inkludera config-filen (endast en gång)
    include_once('includes/config.php');

    // Skapa en instans av Bucketlist-klassen
    $bucketlist = new Bucketlist();

    // Kontrollera om ID är skickat via GET
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Konvertera till heltal
        
        // Kontrollera om formuläret skickades
        if (isset($_POST['name'])) {

        // Hämta data från formuläret
        $name = $_POST['name'];
        $description = $_POST['description'];
        $priority = $_POST['priority'] ?? ""; // Om prioritet inte är vald, sätt till tom sträng

        // Variabel för att hålla koll på valideringen
        $success = true;
        $message = ""; // Lagra tom sträng för meddelanden

        // Validera namn
        if (!$bucketlist->setName($name)) {
            $message .= "<p class='error'>Ange ett giltigt namn (max 64 tecken)</p>";
            $success = false;
        }

        // Validera beskrivning
        if (!$bucketlist->setDescription($description)) {
            $message .= "<p class='error'>Ange en giltig beskrivning (max 255 tecken)</p>";
            $success = false;
        }

        // Kontrollera att prioritet är vald
        if (empty($priority)) {
            $message .= "<p class='error'>Välj en giltig prioritet (1-5)</p>";
            $success = false;
            // Om prioritet är vald, validera att det är korrekt
        } elseif (!$bucketlist->setPriority($priority)) {
            $message .= "<p class='error'>Välj en giltig prioritet (1-5)</p>";
            $success = false;
        }

        // Om alla värden är giltiga, lägg till posten
        if ($success) {
            if ($bucketlist->updatePost($id, $name, $description, $priority)) {
                $message .= "<p class='success'>Posten har uppdaterats!</p>";

                // Återställ defaultvärden i formuläret
                $name = "";
                $description = "";
                $priority = "";

            } else {
                $message .= "<p class='error'>Något gick fel vid uppdatering av posten...</p>";
            }
        } else {
            $message .= "<p class='error'>Post ej uppdaterad! Kontrollera värden och försök igen.</p>";
        }
    }

    // Hämta den specifika posten genom ID
    $details = $bucketlist->getPostById($id);
    // Skicka tillbaka till bucketlist om det inte finns något id
    } else {
        header("Location: bucketlist.php");
        exit;
    }

    $title = 'Ändra - ' . $details['name'];
    include('includes/header.php');
?>

    <!-- Rubrik med namn på posten -->
    <h2>Ändra post - <?= $details['name']; ?></h2>

    <!-- Breadcrumb-navigering -->
    <nav class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="bucketlist.php">BUCKETLIST</a></li>
            <li class="breadcrumb-item"> / Ändra post - <?= $details['name']; ?></li>
        </ol>
    </nav>

    <?php
        // Visa meddelanden
        if(isset($message)) {
            echo $message;
        }
    ?>

    <!-- Formulär för att uppdatera post, skicka med id för att veta vilken post som ska uppdateras -->
    <form action="edit.php?id=<?= $id; ?>" method="POST">
        <label for="name">Namn</label>
        <!-- Förifyllda värden med postens namn, beskrivning och prioritet -->
        <input type="text" id="name" name="name" placeholder="Ange namn..." value="<?= $details['name']; ?>">

        <label for="description">Beskrivning</label>
        <textarea id="description" name="description" rows="5" placeholder="Ange beskrivning..."><?= $details['description']; ?></textarea>

        <!-- Label med tooltip -->
        <label for="priority">Prioritet
            <span class="tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">1 = högsta prioritet<br><br>5 = lägsta prioritet</span>
            </span>
        </label>
        <select id="priority" name="priority">
            <!-- Förvald option som inte går att välja igen -->
            <option value="" <?= empty($details['priority']) ? "selected" : ''; ?> disabled>Välj prioritet...</option>
            <!-- Sätt prioritet som selected om det är valt -->
            <option value="1" <?= $details['priority'] == 1 ? "selected" : ''; ?>>1</option>
            <option value="2" <?= $details['priority'] == 2 ? "selected" : ''; ?>>2</option>
            <option value="3" <?= $details['priority'] == 3 ? "selected" : ''; ?>>3</option>
            <option value="4" <?= $details['priority'] == 4 ? "selected" : ''; ?>>4</option>
            <option value="5" <?= $details['priority'] == 5 ? "selected" : ''; ?>>5</option>
        </select>

        <button type="submit" name="submit">Spara ändringar<i class="fas fa-edit"></i></button>
    </form>

<!-- Inkludera footer -->  
<?php include 'includes/footer.php'; ?>