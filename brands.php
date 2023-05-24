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
    <h1>Ajout d'une marque</h1>
    <input name="name" type="text" placeholder="Nom de la marque" required>
    <button type="submit">Valider</button>
</form>
<table>
    <thead>
    <tr>
        <th>Nom</th>
    </tr>
    </thead>
    <tbody>
<?php 
$query = "SELECT * FROM brands;";
$stmt = $conn->prepare($query);
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($colors as $row){
    echo '<tr>';
    echo '<td>' . $row['name'] .'</td>';
    echo '<td><a href="./formBrand.php?id=' . $row['id'] . '">Modifier</a><a href="./action/brands/deleteBrand.php?id=' . $row['id'] . '" onlick=return confirm(\"Êtes-vous sûr de vouloir supprimer cette marque ?\")>Supprimer</a></td>';
    echo '</tr>';
}
?>
    </tbody>
</table>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{
        $query = "INSERT INTO brands(name) VALUES(:name);";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':name', $_POST['name']);
        if($stmt->execute()){
            echo "<div class='sucess'>ProdMarque ajouté avec succès</div>";
            header('Location: brands.php');
        } else {
            echo "<div class='error'>Erreur lors de l'ajout de la marque</div>";
        }
    } catch (PDOException $e) {
        echo "La requête d'insertion a échoué : " . $e->getMessage();
    }
}
?>