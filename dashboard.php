<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM reservations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Mon Compte</h1>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="profile.php">Mon Profil</a></li>
        </ul>
    </header>

    <main>
        <h2>Mes Réservations</h2>
        <?php while ($reservation = $result->fetch_assoc()): ?>
            <p>Réservation pour <?php echo $reservation['number_of_people']; ?> personnes le
                <?php echo $reservation['reservation_date']; ?>
            </p>
            <a href="cancel.php?id=<?php echo $reservation['id']; ?>">Annuler</a>
        <?php endwhile; ?>
    </main>

    <footer>
        <p>&copy; 2023 Système de Gestion de Réservations. Tous droits réservés.</p>
    </footer>
</body>

</html>