<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Mon Restaurant</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
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

        <!-- Section avec image d'arrière-plan -->
        <section class="hero">
            <img alt="Intérieur d'un restaurant avec des tables en bois, assiettes blanches, et chaises noires et grises."
                class="w-full h-auto object-cover"
                src="https://storage.googleapis.com/a1aa/image/3e44db70-7f1d-48b6-8853-2e67c7dba8cd.jpg" />
            <h2>Réservez votre table facilement</h2>
            <p>Notre système vous permet de réserver une table en quelques clics. Inscrivez-vous ou connectez-vous pour
                commencer.</p>
            <a href="signup.php" class="button">S'inscrire</a>
            <a href="login.php" class="button">Se connecter</a>
        </section>

        <main>
            <section class="reservation-info">
                <h2>Comment Réserver</h2>
                <p>Pour réserver une table, <br> veuillez vous inscrire ou vous connecter à votre compte. <br> Une fois
                    connecté,
                    vous pourrez choisir la date, <br>l'heure et le nombre de personnes pour votre réservation.</p>
                <a href="reserve.php" class="button">Réserver Maintenant</a>
            </section>


            <section class="about-restaurant">
                <h2>À Propos de Notre Restaurant</h2>
                <p>Notre restaurant offre une expérience culinaire unique, <br>mettant en avant des plats préparés avec
                    des
                    ingrédients frais et locaux. <br>Que ce soit pour un dîner romantique, un repas en famille ou une
                    célébration spéciale, nous avons tout ce qu'il vous faut.<br> Venez découvrir notre ambiance
                    chaleureuse
                    et notre service exceptionnel.</p>
            </section>


        </main>

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
                    <a href="https://www.instagram.com/kaana_di/" target="_blank">Instagram</a>
                    <a href="https://www.twitter.com" target="_blank">Twitter</a>
                </div>
            </div>
            <p>&copy; 2025 Tous droits réservés.</p>
        </footer>
    </div>
</body>

</html>