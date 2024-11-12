<!-- Inkludera konfigurationsfil -->
<?php include('includes/config.php'); ?>

<?php
// Array med undersidor
$pages = array(
"index.php" => "HEM",
"bucketlist.php" => "BUCKETLIST"
);
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> | PHP moment 2></title>
    <!-- Inkluderar CSS och JS -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/javascript.js" defer></script>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:600,700">
    <!-- Font Awesome -->
     <!-- Inkluderar Font Awesome för ikoner -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <!-- Overlay som aktiveras vid mobilmeny -->
    <div id="overlay" class="hidden"></div>
    <header>
            <h1><a href="index.php">MYBUCKETLiST</a></h1>
            <nav id="menu">
                <ul>
                <?php
                // Loopa igenom arrayen och skriv ut länkar
                foreach($pages as $url => $title) {
                    // Kolla om undersidan är aktiv
                    $current = basename($_SERVER["SCRIPT_FILENAME"]);
                    // Skriv ut en länk för varje undersida - kolla om det är aktiv sida
                    if($url == $current) {
                        echo "<li><a class='active' href='$url'>$title</a></li>";
                    } else {
                        echo "<li><a href='$url'>$title</a></li>";
                    }
                }
                ?>
                </ul>
            </nav>
            <!-- Mobilmeny -->
            <div class="menu-container">
                <nav class="mobile-menu">
                    <ul>
                    <?php
                    // Loopa igenom arrayen och skriv ut länkar
                    foreach($pages as $url => $title) {
                        // Kolla om undersidan är aktiv
                        $current = basename($_SERVER["SCRIPT_FILENAME"]);
                        // Skriv ut en länk för varje undersida - kolla om det är aktiv sida
                        if($url == $current) {
                            echo "<li><a class='active' href='$url'>$title</a></li>";
                        } else {
                            echo "<li><a href='$url'>$title</a></li>";
                        }
                    }
                    ?>
                    </ul>
                </nav>
                <!-- Knapp för att växla mobilmenyns synlighet -->
                <button class="menu-toggle">
                    <i class="fa-solid fa-bars"></i>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </header>
        <main>
            <div class="container">