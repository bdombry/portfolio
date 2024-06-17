<?php
session_start();

// Connexion à la base de données
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du formulaire
    $project_id = $_POST['project_id'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Vérifier que les données ne sont pas vides
    if (!empty($project_id) && !empty($author) && !empty($content)) {
        // Ajouter le commentaire à la base de données
        $query = $conn->prepare("INSERT INTO comments (project_id, author, content, created_at) VALUES (:project_id, :author, :content, NOW())");
        $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->execute();
    }

    // Rediriger vers la page du projet
    header('Location: project.php?id=' . $project_id);
    exit();
}
?>
