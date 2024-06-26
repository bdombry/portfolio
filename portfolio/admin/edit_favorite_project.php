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

// Récupérer l'ID du projet préféré depuis l'URL
$favorite_project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer les projets existants
$projects_query = $conn->query("SELECT * FROM projects");
$projects = $projects_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les informations du projet préféré
$query = $conn->prepare("SELECT * FROM favorite_projects WHERE id = :id");
$query->bindParam(':id', $favorite_project_id, PDO::PARAM_INT);
$query->execute();
$favorite_project = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];

    // Mettre à jour le projet préféré dans la base de données
    $query = $conn->prepare("UPDATE favorite_projects SET project_id = :project_id WHERE id = :id");
    $query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $query->bindParam(':id', $favorite_project_id, PDO::PARAM_INT);
    $query->execute();

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
    <title>Modifier un Projet Préféré</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Modifier un Projet Préféré</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="edit-favorite-project">
            <form action="edit_favorite_project.php?id=<?php echo $favorite_project_id; ?>" method="post">
                <div class="form-group">
                    <label for="project_id">Sélectionner un Projet:</label>
                    <select name="project_id" id="project_id" required>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>" <?php echo $project['id'] == $favorite_project['project_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($project['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
