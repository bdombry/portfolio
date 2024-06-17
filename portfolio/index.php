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
    <title>Portfolio - Benjamin Dombry</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php"><img src="images/Logo-ben-blanc.png" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="#projects">Projets</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
<section id="main">
    <div class="main-content">
        <div class="benjamin">
            <h1>Benjamin</h1>
        </div>
        <div class="dombry">
            <h1 id="typed-text"></h1>
        </div>
        <p>Développeur Web - Chef de Projet Digital</p>
        <div class="work">
            <div class="vert"></div> 
            <p>Disponible</p>
        </div>
    </div>
</section>
<section id="bento-boxes">
    <div class="container bento-container">
        <div class="bento-box photo">
            <img src="images/photo_ben.webp" alt="Ma photo">
        </div>
        <div class="bento-box description">
            <h1>MOI C'EST BENJAMIN !</h1>
            <div class="bento_gap">
                <p>J'ai découvert le monde du développement à 15 ans au lycée depuis je ne l'ai plus quitté. J'ai très vite compris la puissance et les possibilités infinies de ces outils et c'est pour cela que j'ai continué à évoluer dans ce domaine. Aujourd'hui étudiant je cherche à développer mes compétences pour pouvoir être à la hauteur de mes ambitions</p>
            </div>
        </div>
        <div class="bento-box skills">
            <h2>SKILLS</h2>
            <div class="bento_gap">
                <p>HTML | CSS | JavaScript</p>
                <p>Python | PHP | MySQL</p>
                <p>Wordpress</p>
                <p>Illustrator</p>
                <p>Anglais</p>
            </div>
        </div>
        <div class="bento-box links">
            <div class="icon-container">
                <h2>FORMATION</h2>
                <div class="bento_gap">
                    <p>Normandie Web School</p>
                    <p>Bac +3 Chef de projet Digital</p>
                    <p>Spécialité Dévelopment Web</p>
                </div>
            </div>
        </div>
        <div class="bento-box icons">
            <div class="link-header">Links</div>
            <div class="icon-container">
                <a href="https://www.linkedin.com/in/benjamin-dombry-b8446a299/" target="_blank" class="icon-link"><i class="fab fa-linkedin"></i></a>
                <a href="mailto:bdombry@normandiewebschool.fr" class="icon-link"><i class="fas fa-envelope"></i></a>
                <a href="https://github.com/bdombry" class="icon-link"><i class="fab fa-github"></i></a>
            </div>
        </div>
        <div class="bento-box recent-projects">
            <h2>PROJET PREFERE</h2>
            <p>Infographie NWS</p>
            <p>Tour d'Hanoï</p>
            <p>Escape Game Gastronomique</p>
        </div>
    </div>
</section>
<section id="projects">
    <h2>Mes Projets</h2>
    <div class="container">
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <?php
                // Récupérer la première image du projet
                $image_query = $conn->prepare("SELECT image_path FROM project_images WHERE project_id = :project_id LIMIT 1");
                $image_query->bindParam(':project_id', $project['id'], PDO::PARAM_INT);
                $image_query->execute();
                $image = $image_query->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="project-item">
                    <a href="project/project.php?id=<?php echo $project['id']; ?>">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <img src="images/<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section id="contact">
    <div class="container_footer">
        <h2>Intéressé par mon profil?</h2>
        <p>N'hésitez pas à prendre contact</p>
        <a href="mailto:bdombry@normandiewebschool.fr" class="btn">Contactez-moi</a>
        <p class="contact-info">Contact: bdombry@normandiewebschool.fr</p>
    </div>
</section>
<footer>
    <div class="container_footer">
        <p>&copy; 2024 Benjamin Dombry. Tous droits réservés.</p>
        <a href="admin/login.php" class="btn">Connexion Admin</a>
    </div>
    
</footer>
<script defer src="js/script.js"></script>
</body>
</html>
