<?php
require("../../db.php");
$db = new DBConnection();
$conn = $db->connect();
try{
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $id = $_GET["id"];
        $query = "DELETE FROM colors WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo "<div class='sucess'>Couleur ajouté avec succès</div>";
        header("Location: ../../colors.php");
    } else {
        echo "Erreur: méthode de requête invalide.";
    }
} catch (PDOException $e) {
    echo "La requête de suppression a échoué : " . $e->getMessage();
}