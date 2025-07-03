<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'restaurant_reservation');

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérification si l'ID de réservation est passé dans l'URL
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Préparation de la requête pour supprimer la réservation
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        // Redirection vers le tableau de bord après une annulation réussie
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur lors de l'annulation de la réservation : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Aucune réservation spécifiée.";
}
?>