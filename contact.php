<?php
header('Content-Type: application/json');

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_contacts";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Préparer et exécuter la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}

$conn->close();
?>
