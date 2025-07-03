<?php
session_start();
$conn = $conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: reserve.php");
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Connexion</h1>
    </header>

    <main>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore inscrit ? <a href="signup.php">Inscrivez-vous ici</a></p>
    </main>

    <footer>
        <p>&copy; 2023 Système de Gestion de Réservations. Tous droits réservés.</p>
    </footer>
</body>

</html>