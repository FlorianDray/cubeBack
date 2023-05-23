<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}
?>

<form action="" method="post">  
    <label for="last_name">Nom :</label>
    <input type="text " id="last_name" name="last_name" required><br><br>
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required><br><br>
    <label for="adress">Adresse :</label>
    <input type="text" id="adress" name="adress" required><br><br>
    <label for="mail">Mail :</label>
    <input type="mail" id="mail" name="mail" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="S'inscrire">
  </form>
<a href="./login.php">Se connecter</a>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{
        $query="INSERT INTO users (last_name, first_name, mail, password, rule, adress) VALUES(:last_name, :first_name, :mail, :password, :rule, :adress);";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':last_name', $_POST['last_name']);
        $stmt->bindValue(':first_name', $_POST['first_name']);
        $stmt->bindValue(':mail', $_POST['mail']);
        $stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $stmt->bindValue(':rule', 1);
        $stmt->bindValue(':adress', $_POST['adress']);
        $stmt->execute();
        header("Location: login.php");
		exit;
    } catch (PDOException $e) {
        echo "La requête d'insertion a échoué : " . $e->getMessage();
    }
}
?>