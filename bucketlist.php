<!-- Sätt titel för sidan samt inkludera header -->
<?php $title = "Butcketlist"; ?>
<?php include 'includes/header.php'; ?>
    <?php
    // Skapa en instans av Bucketlist-klassen
    $bucketlist = new Bucketlist();

    // Kontrollera om en post ska raderas
    if (isset($_GET['deleteid'])) {
        $deleteid = $_GET['deleteid'];
        // Anropa metod för att radera posten
        if ($bucketlist->deletePost($deleteid)) {
            echo "<p class='success'>Posten har raderats!</p>";
        } else {
            echo "<p class='error'>Något gick fel vid radering av posten...</p>";
        }
    }

    // Defaultvärden för formuläret
    $name = "";
    $description = "";
    $priority = "";

    // Kontrollera om formuläret skickades
    if (isset($_POST['name'])) {

        // Hämta data från formuläret
        $name = $_POST['name'];
        $description = $_POST['description'];
        $priority = $_POST['priority'] ?? ""; // Om prioritet inte är vald, sätt till tom sträng

        // Variabel för att hålla koll på valideringen
        $success = true;

        // Validera namn
        if (!$bucketlist->setName($name)) {
            echo "<p class='error'>Ange ett giltigt namn (max 64 tecken)</p>";
            $success = false;
        }

        // Validera beskrivning
        if (!$bucketlist->setDescription($description)) {
            echo "<p class='error'>Ange en giltig beskrivning (max 255 tecken)</p>";
            $success = false;
        }

        // Kontrollera att prioritet är vald
        if (empty($priority)) {
            echo "<p class='error'>Välj en giltig prioritet (1-5)</p>";
            $success = false;
            // Om prioritet är vald, validera att det är korrekt
        } elseif (!$bucketlist->setPriority($priority)) {
            echo "<p class='error'>Välj en giltig prioritet (1-5)</p>";
            $success = false;
        }

        // Om alla värden är giltiga, lägg till posten
        if ($success) {
            if ($bucketlist->addPost($name, $description, $priority)) {
                echo "<p class='success'>Posten har lagts till!</p>";

                // Återställ defaultvärden i formuläret
                $name = "";
                $description = "";
                $priority = "";

            } else {
                echo "<p class='error'>Något gick fel vid lagring av posten...</p>";
            }
        } else {
            echo "<p class='error'>Post ej tillagd! Kontrollera värden och försök igen.</p>";
        }
    }
    ?>
    <h2>Skapa ny post</h2>
    <!-- Formulär för att lägga till post -->
    <form action="bucketlist.php" method="POST">
        <label for="name">Namn</label>
        <!-- Sätt värde till det som skickats, eller tomt om det är första gången -->
        <input type="text" id="name" name="name" placeholder="Ange namn..." value="<?= $name ?>">

        <label for="description">Beskrivning</label>
        <textarea id="description" name="description" rows="5" placeholder="Ange beskrivning..."><?= $description ?></textarea>

        <!-- Label med tooltip -->
        <label for="priority">Prioritet
            <span class="tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">1 = högsta prioritet<br><br>5 = lägsta prioritet</span>
            </span>
        </label>
        <select id="priority" name="priority">
            <!-- Förvald option som inte går att välja igen -->
            <option value="" <?= empty($priority) ? "selected" : ''; ?> disabled>Välj prioritet</option>
            <!-- Sätt prioritet som selected om det är valt -->
            <option value="1" <?= $priority == 1 ? "selected" : ''; ?>>1</option>
            <option value="2" <?= $priority == 2 ? "selected" : ''; ?>>2</option>
            <option value="3" <?= $priority == 3 ? "selected" : ''; ?>>3</option>
            <option value="4" <?= $priority == 4 ? "selected" : ''; ?>>4</option>
            <option value="5" <?= $priority == 5 ? "selected" : ''; ?>>5</option>
        </select>

        <button type="submit" name="submit">Lägg till <i class="fas fa-plus"></i></button>
    </form>

    <h2>Min bucketlist</h2>
        <div class="post-container">
        <?php
        // Hämta alla poster från databasen
        $post_list = $bucketlist->getPosts();
        // Loopa igenom alla poster
        foreach ($post_list as $post) {
            ?>
            <!-- Skriv ut posterna i sektioner -->
            <section class="post">
                <div class="post-info">
                    <h3><?= $post['name']; ?> <span class="priority">- Prio <?= $post['priority']; ?></span></h3>
                    <p><?= $post['description']; ?></p>
                </div>
                <div class="actions">
                    <a href="edit.php?id=<?= $post['id']; ?>" class="edit-btn">Ändra<i class="fas fa-edit"></i></a>
                    <a href="bucketlist.php?deleteid=<?= $post['id']; ?>" class="delete-btn">Radera<i class="fas fa-trash-alt"></i></a>
                </div>
            </section>
            <?php
            }
            ?>
        </div>

<!-- Inkludera footer -->  
<?php include 'includes/footer.php'; ?>