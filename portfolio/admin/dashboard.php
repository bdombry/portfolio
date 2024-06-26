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

// Récupérer les compétences
$skills_query = $conn->query("SELECT * FROM skills");
$skills = $skills_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les projets préférés
$favorite_projects_query = $conn->query("SELECT favorite_projects.id, projects.title FROM favorite_projects JOIN projects ON favorite_projects.project_id = projects.id");
$favorite_projects = $favorite_projects_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la description
$description_query = $conn->query("SELECT description FROM about WHERE id = 1");
$description = $description_query->fetch(PDO::FETCH_ASSOC);
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
        <section class="card" id="skills">
            <h2>Compétences</h2>
            <a href="add_skills.php" class="btn">Ajouter une nouvelle compétence</a>
            <ul>
                <?php foreach ($skills as $skill): ?>
                    <li class="item">
                        <span><?php echo htmlspecialchars($skill['name']); ?></span>
                        <div class="actions">
                            <a href="edit_skills.php?id=<?php echo $skill['id']; ?>" class="btn">Modifier</a>
                            <a href="delete_skills.php?id=<?php echo $skill['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?');">Supprimer</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="card" id="favorite-projects">
            <h2>Projets Préférés</h2>
            <a href="add_favorite_project.php" class="btn">Ajouter un nouveau projet préféré</a>
            <ul>
                <?php foreach ($favorite_projects as $favorite_project): ?>
                    <li class="item">
                        <span><?php echo htmlspecialchars($favorite_project['title']); ?></span>
                        <div class="actions">
                            <a href="edit_favorite_project.php?id=<?php echo $favorite_project['id']; ?>" class="btn">Modifier</a>
                            <a href="delete_favorite_project.php?id=<?php echo $favorite_project['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet préféré ?');">Supprimer</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="card" id="description">
            <h2>Description</h2>
            <div class="description-content">
                <?php if (isset($description['description'])): ?>
                    <p><?php echo htmlspecialchars($description['description']); ?></p>
                <?php else: ?>
                    <p>Aucune description disponible.</p>
                <?php endif; ?>
            </div>
            <div class="actions">
                <a href="edit_description.php" class="btn">Modifier la description</a>
                <a href="delete_description.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la description ?');">Supprimer la description</a>
            </div>
        </section>
    </main>
</body>
</html>
