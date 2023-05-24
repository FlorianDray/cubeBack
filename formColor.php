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
        $query = "SELECT * FROM colors WHERE id = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $_GET["id"]);
        $stmt->execute();
        $color = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!isset($color) || empty($color)) {
            echo 'Erreur lors de la récupération de la couleur.';
        }
    } else {
        echo "Erreur: méthode de requête invalide.";
    }
} catch (PDOException $e) {
    echo "La requête a échoué : " . $e->getMessage();
}
?>
<form action="" method="post">
    <h1>Modifier une couleur</h1>
    <input name="name" type="text" value="<?php echo $color['name']; ?>"  required>
    <button type="submit">Valider</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $id = $_GET["id"];
        $name = $_POST["name"];
        $query = "UPDATE colors SET name= :name WHERE id= :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        if ($stmt->execute()) {
            echo "<div class='success'>Couleur modifié avec succès</div>";
            header('Location: colors.php');
            exit;
        } else {
            echo "<div class='error'>Erreur lors de la modification de la couleur</div>";
        }
    } catch (PDOException $e) {
        echo "La requête a échoué : " . $e->getMessage();
    }
}
?>