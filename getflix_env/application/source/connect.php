<?php

// la connexion à la base de données pour Docker et WAMP
//$servername = 'database';
$username = 'root';
//$pass = 'root';
$dbname = 'getflix';

// Connexion WAMP:
$servername = "localhost";
$pass = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "La connexion a été bien établie.";
} catch (PDOException $e) {
    // echo "La connexion a échoué: " . $e->getMessage();
}
