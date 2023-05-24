<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php require './header.php';?>
<?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $query = "SELECT * FROM sneakers WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $_GET["id"]);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!isset($product) || empty($product)) {
            echo 'Erreur lors de la récupération du produit.';
        }
    } else {
        echo "Erreur: méthode de requête invalide.";
    }
} catch (PDOException $e) {
    echo "La requête a échoué : " . $e->getMessage();
}
?>
<form action="" method="post">
    <h1>Modifier un produit</h1>
    <input name="size" type="number" min="18" max="50" value="<?php echo $product['size']; ?>" required>
    <input name="price" type="number" min="0" step="0.1" value="<?php echo $product['price']; ?>" required>
    <button type="submit">Valider</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $id = $_GET["id"];
        $size = $_POST["size"];
        $price = $_POST["price"];
        $query = "UPDATE sneakers SET size= :size, price= :price WHERE id= :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':size', $size);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            echo "<div class='success'>Produit modifié avec succès</div>";
            header('Location: products.php');
            exit;
        } else {
            echo "<div class='error'>Erreur lors de la modification du produit</div>";
        }
    } catch (PDOException $e) {
        echo "La requête a échoué : " . $e->getMessage();
    }
}
?>
