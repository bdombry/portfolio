<?php
session_start();

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $host = 'localhost';
    $db = 'portfolio';
    $user = 'root';
    $pass = '';

    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Récupérer les informations du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];

    // Ajouter le projet à la base de données
    $query = $conn->prepare("INSERT INTO projects (title, description, technologies) VALUES (:title, :description, :technologies)");
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':technologies', $technologies, PDO::PARAM_STR);
    $query->execute();

    $project_id = $conn->lastInsertId();

    // Traiter les images
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $image_name = $_FILES['images']['name'][$key];
        $image_tmp = $_FILES['images']['tmp_name'][$key];
        move_uploaded_file($image_tmp, "../images/$image_name");

        $query = $conn->prepare("INSERT INTO project_images (project_id, image_path) VALUES (:project_id, :image_path)");
        $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query->bindParam(':image_path', $image_name, PDO::PARAM_STR);
        $query->execute();
    }

    // Rediriger vers le dashboard
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Ajouter un Projet</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="add-project">
            <form action="add_project.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Titre:</label>
                    <input type="text" name="title" id="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="technologies">Technologies:</label>
                    <input type="text" name="technologies" id="technologies" required>
                </div>
                <div class="form-group">
                    <label for="images">Images:</label>
                    <input type="file" name="images[]" id="images" multiple required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn">Ajouter</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
