<?php
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = ''; // Mot de passe vide

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
