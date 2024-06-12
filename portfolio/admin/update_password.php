<?php
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hashed_password = password_hash('adminpassword', PASSWORD_DEFAULT);

    $query = $conn->prepare("UPDATE users SET password = :password WHERE username = 'admin'");
    $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $query->execute();

    echo "Mot de passe mis à jour avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>