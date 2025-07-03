<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = null;

    // Hachage du mot de passe si fourni
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }

    // Gestion de la photo de profil
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);

        // Vérifiez si le fichier est une image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            // Déplacez le fichier téléchargé
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $target_file; // Enregistrez le chemin de la photo
                echo "Photo téléchargée avec succès : " . htmlspecialchars($profile_picture); // Message de débogage
            } else {
                echo "Erreur lors du téléchargement de la photo de profil.";
            }
        } else {
            echo "Le fichier téléchargé n'est pas une image.";
        }
    }

    // Préparation de la requête de mise à jour
    $query = "UPDATE users SET name = ?, email = ?";
    if ($password) {
        $query .= ", password = ?";
    }
    if ($profile_picture) {
        $query .= ", profile_picture = ?";
    }
    $query .= " WHERE id = ?";

    $stmt = $conn->prepare($query);

    // Lier les paramètres en fonction des valeurs fournies
    if ($password && $profile_picture) {
        $stmt->bind_param("ssssi", $name, $email, $password, $profile_picture, $user_id);
    } elseif ($password) {
        $stmt->bind_param("sssi", $name, $email, $password, $user_id);
    } elseif ($profile_picture) {
        $stmt->bind_param("sssi", $name, $email, $profile_picture, $user_id);
    } else {
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    // Exécutez la requête et redirigez si tout va bien
    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
}
?>