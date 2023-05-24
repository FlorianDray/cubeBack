<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}?>
<link href="style.css" rel="stylesheet" type="text/css"/>
<?php require './header.php';?>
<body>
<form action="" method="post">   
    <h1>Ajout un produit</h1>
    <input name="size" type="number" min="18" max="50" required>
    <input name="price" type="number" min="0"  step="0.1" required>
    <button type="submit">Ajouter un produit</button>
</form>
<table>
    <thead>
    <tr>
        <th>taille</th>
        <th>prix</th>
    </tr>
    </thead>
    <tbody>
<?php 
$query = "SELECT * FROM sneakers;";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($products as $row){
    echo '<tr>';
    echo '<td>' . $row['size'] .'</td>';
    echo '<td>' . $row['price'] .'</td>';
    echo '<td><a href="./formProduct.php?id=' . $row['id'] . '">Modifier</a><a href="./action/product/deleteProduct.php?id=' . $row['id'] . '" onlick=return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit ?\")>Supprimer</a></td>';
    echo '</tr>';
}
?>
    </tbody>
</table>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{
        $query = "INSERT INTO sneakers(size, price, img_path, id_color, id_brand) VALUES(:size, :price, :img_path, :id_color, :id_brand);";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':size', $_POST['size']);
        $stmt->bindValue(':price', $_POST['price']);
        $stmt->bindValue(':img_path', 'chemin');
        $stmt->bindValue(':id_color', 1);
        $stmt->bindValue(':id_brand', 1);
        if($stmt->execute()){
            echo "<div class='sucess'>Produit ajouté avec succès</div>";
            header('Location: products.php');
        } else {
            echo "<div class='error'>Mail ou mot de passe incorrect</div>";
        }
    } catch (PDOException $e) {
        echo "La requête d'insertion a échoué : " . $e->getMessage();
    }
}
?>