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
<?php require './header.php'; ?>

<body>
    <form action="" method="post">
        <h1>Ajout d'un produit</h1>
        <input name="name" type="text" placeholder="Nom du produit">
        <textarea name="description" placeholder="Description du produit"></textarea>
        <select name="brand">
            <?php foreach ($brands as $row) { ?>
                <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?></option>
            <?php } ?>
        </select>
        <select name="color">
            <?php foreach ($colors as $row) { ?>
                <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?></option>
            <?php } ?>
        </select>
        <input name="size" type="number" min="18" max="70" placeholder="Taille (18 - 70)" required>
        <input name="price" type="number" min="0" step="0.1" placeholder="Prix" required>
        <button type="submit">Ajouter un produit</button>
    </form>
    <table class="product-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Marque</th>
                <th>Couleur</th>
                <th>Taille</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT s.name, s.description, s.id, s.size, s.price, b.name AS brand, c.name AS color from sneakers s JOIN brands b ON s.id_brand = b.id JOIN colors c ON s.id_color = c.id;";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $row) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>' . $row['brand'] . '</td>';
                echo '<td>' . $row['color'] . '</td>';
                echo '<td>' . $row['size'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '<td><a href="./formProduct.php?id=' . $row['id'] . '">Modifier</a> <a href="./action/product/deleteProduct.php?id=' . $row['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce produit ?\')" class="delete-link">Supprimer</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {        
    try {
        $query = "INSERT INTO sneakers(name, description, size, price, img_path, id_color, id_brand) VALUES(:name, :description, :size, :price, :img_path, :id_color, :id_brand);";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':name', $_POST['name']);
        $stmt->bindValue(':description', $_POST['description']);
        $stmt->bindValue(':size', $_POST['size']);
        $stmt->bindValue(':price', $_POST['price']);
        $stmt->bindValue(':img_path', 'chemin');
        $stmt->bindValue(':id_color', $_POST['color']);
        $stmt->bindValue(':id_brand', $_POST['brand']);
        if ($stmt->execute()) {
            echo "<div class='sucess'>Produit ajouté avec succès</div>";
            header('Location: products.php');
        } else {
            echo "<div class='error'>Erreur lors de l'ajout du produit</div>";
        }
    } catch (PDOException $e) {
        echo "La requête d'insertion a échoué : " . $e->getMessage();
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