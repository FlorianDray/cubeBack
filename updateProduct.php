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
    <?php
    try{
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $query = "SELECT * FROM sneakers WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(isset($product) || !empty($product)){
                echo 'Erreur dans la récupération du produit.';
            }
        } else {
            echo "Erreur: méthode de requête invalide.";
        }
    } catch (PDOException $e) {
        echo "La requête de suppression a échoué : " . $e->getMessage();
    }
    ?> 
    <form action="" method="post">   
        <h1>Modifier un produit</h1>
        <input name="size" type="number" min="18" max="50" value="<?php $product['size'] ?>" required>
        <input name="price" type="number" min="0"  step="0.1" value="<?php $product['price'] ?>" required>
        <button type="submit">Valider</button>
    </form>