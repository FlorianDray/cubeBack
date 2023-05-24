<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$brands = getAllBrands($conn);
$colors = getAllColors($conn);
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
        <h1>Modifier le produit</h1>
        <input name="name" type="text" placeholder="Nom du produit" value="<?php echo $product['name']?>">
        <textarea name="description" placeholder="Description du produit"  ><?php echo $product['description']?></textarea>
        <select name="brand">
            <?php foreach ($brands as $row) { ?>
                <option value="<?php echo $row['id'] ?>" <?php if($product['id_brand'] == $row['id'] ){  echo 'selected'; }?>> <?php echo $row['name'] ?></option>
            <?php } ?>
        </select>
        <select name="color">
            <?php foreach ($colors as $row) { ?>
                <option value="<?php echo $row['id'] ?>" <?php if($product['id_color'] == $row['id'] ){ echo 'selected'; }?>> <?php echo $row['name'] ?></option>
            <?php } ?>
        </select>
        <input name="size" type="number" min="18" max="70" placeholder="Taille (18 - 70)"  value="<?php echo $product['size']?>" required>
        <input name="price" type="number" min="0" step="0.1" placeholder="Prix" value="<?php echo $product['price']?>" required>
        <button type="submit">Valider</button>
    </form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $id = $_GET["id"];
        $size = $_POST["size"];
        $price = $_POST["price"];
        $query = "UPDATE sneakers SET id_color= :color, id_brand= :brand, description= :description, name = :name, size= :size, price= :price WHERE id= :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id_color', $color);
        $stmt->bindValue(':id_brand', $brand);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':name', $name);
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

function getAllBrands($conn)
{
    try {
        $query = "SELECT * FROM brands;";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($brands) || !empty($brands)) {
            return $brands;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        echo "La récupération des marques a échoué : " . $e->getMessage();
    }
}

function getAllColors($conn)
{
    try {
        $query = "SELECT * FROM colors;";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($colors) || !empty($colors)) {
            return $colors;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        echo "La récupération des couleurs a échoué : " . $e->getMessage();
    }
}
?>
