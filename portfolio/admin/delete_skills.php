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

// Récupérer l'ID de la compétence depuis l'URL
$skill_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Supprimer la compétence de la base de données
    $query = $conn->prepare("DELETE FROM skills WHERE id = :id");
    $query->bindParam(':id', $skill_id, PDO::PARAM_INT);
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
    <title>Supprimer une Compétence</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Supprimer une Compétence</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="delete-skill">
            <form action="delete_skills.php?id=<?php echo $skill_id; ?>" method="post">
                <p>Êtes-vous sûr de vouloir supprimer cette compétence?</p>
                <div class="form-actions">
                    <button type="submit" class="btn">Supprimer</button>
                    <a href="dashboard.php" class="btn">Retour</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
