<!-- Inkludera konfigurationsfil -->
<?php include('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> | PHP moment 2></title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $title; ?></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Hem</a></li>
                    <li><a href="bucketlist.php">Bucketlist</a></li>
                </ul>
            </nav>
        </header>
        <main>