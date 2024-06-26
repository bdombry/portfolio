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

// Récupérer les informations de la compétence
$query = $conn->prepare("SELECT * FROM skills WHERE id = :id");
$query->bindParam(':id', $skill_id, PDO::PARAM_INT);
$query->execute();
$skill = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_name = $_POST['skill'];

    // Mettre à jour la compétence dans la base de données
    $query = $conn->prepare("UPDATE skills SET name = :name WHERE id = :id");
    $query->bindParam(':name', $skill_name, PDO::PARAM_STR);
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
    <title>Modifier une Compétence</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Modifier une Compétence</h1>
            <a href="dashboard.php" class="btn">Retour au Dashboard</a>
        </div>
    </header>
    <main class="dashboard">
        <section class="card" id="edit-skill">
            <form action="edit_skills.php?id=<?php echo $skill_id; ?>" method="post">
                <div class="form-group">
                    <label for="skill">Compétence:</label>
                    <input type="text" name="skill" id="skill" value="<?php echo htmlspecialchars($skill['name']); ?>" required>
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
