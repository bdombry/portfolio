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
    $description = $_POST['description'];

    // Ajouter la description à la base de données
    $query = $conn->prepare("INSERT INTO about (description) VALUES (:description)");
    $query->bindParam(':description', $description, PDO::PARAM_STR);
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
    <title>Ajouter une Description</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Ajouter une Description</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="add-description">
            <form action="add_description.php" method="post">
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn">Ajouter</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
