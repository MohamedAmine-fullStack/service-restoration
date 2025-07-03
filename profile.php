<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <style>
        /* Styles globaux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            /* Couleur de fond douce */
            color: #333;
            /* Couleur du texte */
        }

        header {
            background-color: #007bff;
            /* Couleur de fond de l'en-tête */
            color: white;
            /* Couleur du texte de l'en-tête */
            padding: 20px;
            /* Espacement interne */
            text-align: center;
            /* Centre le texte */
        }

        header h1 {
            margin: 0;
            /* Enlève la marge par défaut */
        }

        nav {
            margin-top: 10px;
            /* Marge au-dessus de la navigation */
        }

        nav ul {
            list-style-type: none;
            /* Enlève les puces de la liste */
            padding: 0;
            /* Enlève le padding par défaut */
        }

        nav ul li {
            display: inline;
            /* Affiche les éléments de la liste en ligne */
            margin: 0 15px;
            /* Marge entre les éléments */
        }

        nav ul li a {
            color: white;
            /* Couleur des liens */
            text-decoration: none;
            /* Enlève le soulignement */
        }

        nav ul li a:hover {
            text-decoration: underline;
            /* Souligne au survol */
        }

        h1,
        h2 {
            color: #007bff;
            /* Couleur des titres */
            text-align: center;
            /* Centre les titres */
        }

        .profile_picture {
            text-align: center;
            /* Centre l'image */
            margin-bottom: 20px;
            /* Marge en bas de l'image */
        }

        img {
            border-radius: 5px;
            /* Arrondir les bords de l'image */
            width: 200px;
            /* Largeur de l'image */
            height: 200px;
            /* Hauteur de l'image */
        }

        form {
            background-color: #fff;
            /* Fond blanc pour le formulaire */
            border-radius: 8px;
            /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Ombre légère */
            padding: 20px;
            /* Espacement interne */
            max-width: 500px;
            /* Largeur maximale du formulaire */
            margin: 20px auto;
            /* Centrer le formulaire avec marge */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            /* Prendre toute la largeur */
            padding: 12px;
            /* Espacement interne */
            margin: 10px 0;
            /* Marge entre les champs */
            border: 1px solid #ccc;
            /* Bordure légère */
            border-radius: 4px;
            /* Coins arrondis pour les champs */
            font-size: 16px;
            /* Taille de la police */
        }

        button {
            background-color: #007bff;
            /* Couleur de fond du bouton */
            color: white;
            /* Couleur du texte du bouton */
            padding: 12px;
            /* Espacement interne du bouton */
            border: none;
            /* Pas de bordure */
            border-radius: 4px;
            /* Coins arrondis pour le bouton */
            cursor: pointer;
            /* Curseur en forme de main au survol */
            font-size: 16px;
            /* Taille de la police du bouton */
            width: 100%;
            /* Prendre toute la largeur */
        }

        button:hover {
            background-color: #0056b3;
            /* Couleur de fond au survol */
        }

        footer {
            background-color: #343a40;
            /* Couleur de fond du pied de page */
            color: white;
            /* Couleur du texte du pied de page */
            /* text-align: center; /* Centre le texte¨ */
        }

        footer {
            background-color: #343a40;
            /* Couleur de fond du pied de page */
            color: white;
            /* Couleur du texte du pied de page */
            text-align: center;
            /* Centre le texte */
            padding: 20px 0;
            /* Espacement interne */
            position: relative;
            /* Position relative pour le footer */
            bottom: 0;
            /* Positionne le footer en bas */
            width: 100%;
            /* Prendre toute la largeur */
        }

        .footer-container {
            display: flex;
            /* Utilise Flexbox pour aligner les éléments */
            justify-content: space-around;
            /* Espace entre les colonnes */
            margin-bottom: 10px;
            /* Marge en bas */
        }

        .footer-info,
        .footer-hours,
        .footer-social {
            max-width: 200px;
            /* Largeur maximale des colonnes */
        }

        .footer-social a {
            display: block;
            /* Affiche chaque lien sur une nouvelle ligne */
            color: white;
            /* Couleur des liens */
            text-decoration: none;
            /* Enlève le soulignement */
        }

        .footer-social a:hover {
            text-decoration: underline;
            /* Souligne au survol */
        }
    </style>
</head>

<body>

    <header>
        <h1>Bienvenue dans notre Restaurant</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>

                <li><a href="reservations.php">Réservations</a></li>
                <li><a href="login.php">Se connecter</a></li>
                <li><a href="signup.php">S'inscrire</a></li>
                <li><a href="dashboard.php">Mon Compte</a></li>
            </ul>
        </nav>
    </header>
    <h1>Profil de <?php echo htmlspecialchars($user['name']); ?></h1>

    <!-- Affichage de la photo de profil -->
    <div class="profile_picture"> <!-- Ajout de la div ici -->
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Photo de Profil">
        <?php else: ?>
            <p>Aucune photo de profil disponible.</p>
        <?php endif; ?>
    </div> <!-- Fin de la div -->
    <!-- <p>Email: <?php echo htmlspecialchars($user['email']); ?></p> -->

    <h2>Modifier le Profil</h2>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <input type="password" name="password" placeholder="Nouveau Mot de Passe (laisser vide pour ne pas changer)">
        <input type="file" name="profile_picture" accept="image/*">
        <button type="submit">Mettre à jour</button>
    </form>
    <footer>
        <div class="footer-container">
            <div class="footer-info">
                <h3>Contactez-nous</h3>
                <p>Email : contact@monrestaurant.com</p>
                <p>Téléphone : +1 514 245 6789</p>
                <p>Adresse : 123 Rue de la Gastronomie, Montreal, Canada</p>
            </div>
            <div class="footer-hours">
                <h3>Heures d'Ouverture</h3>
                <p>Lundi - Vendredi : 5h00 - 22h00</p>
                <p>Samedi - Dimanche : 12h00 - 23h00</p>
            </div>
            <div class="footer-social">
                <h3>Suivez-nous</h3>
                <a href="https://www.facebook.com" target="_blank">Facebook</a>
                <a href="https://www.instagram.com" target="_blank">Instagram</a>
                <a href="https://www.twitter.com" target="_blank">Twitter</a>
            </div>
        </div>
        <p>&copy; 2025 Tous droits réservés.</p>
    </footer>
    <style>

    </style>
</body>

</html>