<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Inscription</h1>
    </header>

    <main>
        <form action="signup.php" method="POST">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
    </main>

    <footer>
        <p>&copy; 2023 Système de Gestion de Réservations. Tous droits réservés.</p>
    </footer>
</body>

</html>