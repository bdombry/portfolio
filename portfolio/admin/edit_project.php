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

// Récupérer l'ID du projet depuis l'URL
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer les informations du projet
$query = $conn->prepare("SELECT * FROM projects WHERE id = :id");
$query->bindParam(':id', $project_id, PDO::PARAM_INT);
$query->execute();
$project = $query->fetch(PDO::FETCH_ASSOC);

// Récupérer les images du projet
$image_query = $conn->prepare("SELECT * FROM project_images WHERE project_id = :project_id");
$image_query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
$image_query->execute();
$project_images = $image_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];

    // Mettre à jour le projet dans la base de données
    $query = $conn->prepare("UPDATE projects SET title = :title, description = :description, technologies = :technologies WHERE id = :id");
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':technologies', $technologies, PDO::PARAM_STR);
    $query->bindParam(':id', $project_id, PDO::PARAM_INT);
    $query->execute();

    // Traiter les nouvelles images
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $image_name = $_FILES['images']['name'][$key];
            $image_tmp = $_FILES['images']['tmp_name'][$key];
            move_uploaded_file($image_tmp, "../images/$image_name");

            $query = $conn->prepare("INSERT INTO project_images (project_id, image_path) VALUES (:project_id, :image_path)");
            $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
            $query->bindParam(':image_path', $image_name, PDO::PARAM_STR);
            $query->execute();
        }
    }

    // Traiter la suppression des images
    if (!empty($_POST['delete_image'])) {
        foreach ($_POST['delete_image'] as $image_id) {
            $query = $conn->prepare("SELECT image_path FROM project_images WHERE id = :id");
            $query->bindParam(':id', $image_id, PDO::PARAM_INT);
            $query->execute();
            $image = $query->fetch(PDO::FETCH_ASSOC);

            if ($image) {
                unlink("../images/" . $image['image_path']);
                $query = $conn->prepare("DELETE FROM project_images WHERE id = :id");
                $query->bindParam(':id', $image_id, PDO::PARAM_INT);
                $query->execute();
            }
        }
    }

    // Récupérer les images mises à jour
    $image_query = $conn->prepare("SELECT * FROM project_images WHERE project_id = :project_id");
    $image_query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $image_query->execute();
    $project_images = $image_query->fetchAll(PDO::FETCH_ASSOC);

    // Ne pas rediriger, rester sur la page
    $success = "Projet mis à jour avec succès!";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Projet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Modifier un Projet</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="edit-project">
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <form action="edit_project.php?id=<?php echo $project_id; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Titre:</label>
                    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="technologies">Technologies:</label>
                    <input type="text" name="technologies" id="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="images">Images actuelles:</label>
                    <?php foreach ($project_images as $image): ?>
                        <div class="current-image">
                            <img src="../images/<?php echo htmlspecialchars($image['image_path'] ?? ''); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" width="200">
                            <label>
                                <input type="checkbox" name="delete_image[]" value="<?php echo $image['id']; ?>">
                                Supprimer
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label for="images">Ajouter des images:</label>
                    <input type="file" name="images[]" id="images" multiple>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn">Modifier</button>
                    <a href="dashboard.php" class="btn">Retour</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
