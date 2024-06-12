<?php
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = ''; // Mot de passe vide

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hashed_password = password_hash('BatetBenetFilou76', PASSWORD_DEFAULT);

    // Remplacez 'nouveau_nom_utilisateur' par votre nouveau nom d'utilisateur
    $query = $conn->prepare("UPDATE users SET password = :password WHERE username = 'bdombry'");
    $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "Mot de passe mis à jour avec succès.";
    } else {
        echo "Aucune mise à jour effectuée. Vérifiez le nom d'utilisateur.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
