<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $host = 'localhost';
    $db = 'portfolio';
    $user = 'root';
    $pass = ''; // Mot de passe vide

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les informations du formulaire
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérifier les informations de l'utilisateur
        $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin'] = true;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect';
        }
    } catch (PDOException $e) {
        $error = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Connexion Admin</h1>
    </header>
    <section id="login">
        <form action="login.php" method="post">
            <div class="card">
                <div class="input">
                    <p>
                        <input type="text" name="username" id="username" required="" autocomplete="off">
                        <label for="username">Nom d'utilisateur:</label>
                    </p>
                </div>
                <div class="input">
                    <p>
                        <input type="password" name="password" id="password" required="" autocomplete="off">
                        <label for="password">Mot de passe:</label>
                    </p>
                </div>
                <p>
                    <button type="submit" class="btn_login">Connexion</button>
                </p>
                <a href="../index.php" class="deco">Retour</a>
                <?php if (isset($error)): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </form>
    </section>
</body>
</html>
