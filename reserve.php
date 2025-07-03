<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Traitement de la réservation si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'reserve') {
    $user_id = $_SESSION['user_id'];
    $reservation_date = $_POST['reservation_date'];
    $number_of_people = $_POST['number_of_people'];

    // Insertion de la réservation dans la base de données
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, reservation_date, number_of_people) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $reservation_date, $number_of_people);

    if ($stmt->execute()) {
        // Redirection vers le tableau de bord après une réservation réussie
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la réservation : " . $stmt->error;
    }

    $stmt->close();
}

// Traitement de l'annulation de réservation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'cancel') {
    $reservation_id = $_POST['reservation_id'];

    // Suppression de la réservation de la base de données
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "Réservation annulée avec succès.";
    } else {
        echo "Erreur lors de l'annulation de la réservation : " . $stmt->error;
    }

    $stmt->close();
}

// Récupération des réservations existantes avec le nom de l'utilisateur
$user_id = $_SESSION['user_id'];
$reservations = $conn->query("SELECT r.*, u.name FROM reservations r JOIN users u ON r.user_id = u.id WHERE r.user_id = $user_id AND r.reservation_date >= NOW()");
$historique = $conn->query("SELECT r.*, u.name FROM reservations r JOIN users u ON r.user_id = u.id WHERE r.user_id = $user_id AND r.reservation_date < NOW()");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers le fichier CSS pour le style -->
</head>

<body>
    <div class="container">
        <header>
            <h1>Réservez Votre Table</h1>
            <p>Bienvenue dans notre restaurant !</p>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="login.php">Se connecter</a></li>
                    <li><a href="dashboard.php">Mon Compte</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="marketing">
                <h1>Pourquoi Réserver ?</h1>
                <h2>Réserver une table est un moyen facile et rapide de garantir votre place et évite les
                    attentes. <br> Avec notre système en ligne,
                    choisissez facilement la date, <br>l'heure et le nombre de personnes,<br>
                    et recevez une confirmation immédiate.
                </h2>
            </section>

            <form action="reserve.php" method="POST" class="reservation-form">
                <h2>Réservez Votre Table</h2>

                <label for="reservation_date">Date et Heure de Réservation :</label>
                <input type="datetime-local" name="reservation_date" class="input-large" required>

                <label for="number_of_people">Nombre de personnes :</label>
                <input type="number" name="number_of_people" class="input-large" placeholder="Nombre de personnes"
                    required>

                <input type="hidden" name="action" value="reserve">
                <button type="submit" class="btn-submit">Réserver</button>
            </form>

            <h2>Mes Réservations Actuelles</h2>
            <div id="reservations">
                <?php
                if ($reservations->num_rows > 0) {
                    while ($row = $reservations->fetch_assoc()) {
                        echo "<div class='reservation'>";
                        echo "Nom: " . $row['name'] . "<br>"; // Affichage du nom de l'utilisateur
                        echo "Réservation ID: " . $row['id'] . "<br>";
                        echo "Date: " . $row['reservation_date'] . "<br>";
                        echo "Nombre de personnes: " . $row['number_of_people'] . "<br>";
                        echo "<form action='reserve.php' method='POST'>";
                        echo "<input type='hidden' name='reservation_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='action' value='cancel'>";
                        echo "<button type='submit'>Annuler</button>";
                        echo "</form>";
                        echo "</div><hr>";
                    }
                } else {
                    echo "Aucune réservation trouvée.";
                }
                ?>
            </div>

            <h2>Historique de mes Réservations</h2>
            <div id="historique">
                <?php
                if ($historique->num_rows > 0) {
                    while ($row = $historique->fetch_assoc()) {
                        echo "<div class='historique'>";
                        echo "Nom: " . $row['name'] . "<br>"; // Affichage du nom de l'utilisateur
                        echo "Réservation ID: " . $row['id'] . "<br>";
                        echo "Date: " . $row['reservation_date'] . "<br>";
                        echo "Nombre de personnes: " . $row['number_of_people'] . "<br>";
                        echo "</div><hr>";
                    }
                } else {
                    echo "Aucune réservation passée trouvée.";
                }
                ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2023 Système de Gestion de Réservations. Tous droits réservés.</p>
        </footer>
    </div>
</body>

</html>