<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'portfolio';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Récupérer les informations de l'utilisateur
$query = $conn->prepare("SELECT * FROM users WHERE username = 'admin'");
$query->execute();
$user_info = $query->fetch(PDO::FETCH_ASSOC);

// Récupérer les projets
$projects_query = $conn->query("SELECT * FROM projects");
$projects = $projects_query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur mon portfolio</h1>
    </header>
    <section id="about">
        <h2>À propos de moi</h2>
        <img src="images/photo.jpg" alt="Ma photo" width="200">
        <p>Nom : <?php echo htmlspecialchars($user_info['username']); ?></p>
        <p>Biographie : Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim.</p>
    </section>
    <section id="skills">
        <h2>Compétences</h2>
        <ul>
            <li>HTML</li>
            <li>CSS</li>
            <li>JavaScript</li>
            <li>PHP</li>
            <li>MySQL</li>
        </ul>
    </section>
    <section id="experience">
        <h2>Expériences professionnelles</h2>
        <ul>
            <li>Développeur Web à Exemple Inc. (2022 - Présent)</li>
            <li>Stagiaire en développement à StartUp XYZ (2021 - 2022)</li>
        </ul>
    </section>
    <section id="education">
        <h2>Formations</h2>
        <ul>
            <li>Licence en Informatique - Université ABC (2019 - 2022)</li>
            <li>Baccalauréat Scientifique - Lycée XYZ (2016 - 2019)</li>
        </ul>
    </section>
    <section id="projects">
        <h2>Mes Projets</h2>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <a href="project/project.php?id=<?php echo $project['id']; ?>">
                        <?php echo htmlspecialchars($project['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
