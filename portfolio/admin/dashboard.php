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

// Récupérer les projets
$projects_query = $conn->query("SELECT * FROM projects");
$projects = $projects_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les commentaires
$comments_query = $conn->query("SELECT * FROM comments");
$comments = $comments_query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Dashboard Admin</h1>
            <a href="../index.php" class="btn">Déconnexion</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="projects">
            <h2>Projets</h2>
            <a href="add_project.php" class="btn">Ajouter un nouveau projet</a>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li class="item">
                        <span><?php echo htmlspecialchars($project['title']); ?></span>
                        <div class="actions">
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn">Modifier</a>
                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">Supprimer</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="card" id="comments">
            <h2>Commentaires</h2>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li class="item">
                        <span><strong><?php echo htmlspecialchars($comment['author']); ?>:</strong> <?php echo htmlspecialchars($comment['content']); ?></span>
                        <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>

