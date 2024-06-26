<?php
session_start();

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Supprimer la description de la base de données
$query = $conn->prepare("DELETE FROM about WHERE id = 1");
$query->execute();

// Rediriger vers le dashboard
header('Location: dashboard.php');
exit();
?>
