<?php
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

// Récupérer les commentaires du projet
$comments_query = $conn->prepare("SELECT * FROM comments WHERE project_id = :project_id ORDER BY created_at DESC");
$comments_query->bindParam(':project_id', $project_id, PDO::PARAM_INT);
$comments_query->execute();
$comments = $comments_query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo htmlspecialchars($project['title']); ?></h1>
            <a href="../index.php" class="btn">Retour à l'accueil</a>
        </div>
    </header>
    <main class="project-details">
        <section class="cardp">
            <div class="description">
                <h2>Description</h2>
                <p><?php echo htmlspecialchars($project['description']); ?></p>
            </div>
            <div class="technologies">
                <h2>Technologies utilisées</h2>
                <p><?php echo htmlspecialchars($project['technologies']); ?></p>
            </div>
            <div class="images">
                <h2>Images</h2>
                <?php foreach ($project_images as $image): ?>
                    <img src="../images/<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" width="300">
                <?php endforeach; ?>
            </div>
        </section>
        <section class="cardp comments">
            <h2>Commentaires</h2>
            <ul class="comment-list">
                <?php foreach ($comments as $comment): ?>
                    <li class="comment-item">
                        <p><strong><?php echo htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8'); ?></strong> (<?php echo $comment['created_at']; ?>)</p>
                        <p><?php echo htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h2>Ajouter un commentaire</h2>
            <form action="add_comment.php" method="post" id="comment-form">
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                <div class="form-group">
                    <label for="author">Nom:</label>
                    <input type="text" name="author" id="author" required>
                </div>
                <div class="form-group">
                    <label for="content">Commentaire:</label>
                    <textarea name="content" id="content" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn">Ajouter</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

