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

// Récupérer les informations de la description
$query = $conn->prepare("SELECT * FROM about WHERE id = 1");
$query->execute();
$description = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description_text = $_POST['description'];

    // Mettre à jour la description dans la base de données
    $query = $conn->prepare("UPDATE about SET description = :description WHERE id = 1");
    $query->bindParam(':description', $description_text, PDO::PARAM_STR);
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
    <title>Modifier une Description</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Modifier une Description</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="edit-description">
            <form action="edit_description.php" method="post">
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required><?php echo htmlspecialchars($description['description']); ?></textarea>
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
