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

<link href="style.css" rel="stylesheet" type="text/css"/>

<div class="form-ci">
<img class="logo-sm" src="./assets/images/logo-sneak-me-bleu.png" alt="">
<form action="" method="post">
<h1> Inscription </h1>  
    <input type="text " id="last_name" name="last_name" placeholder="Nom" required autofocus>
    <input type="text" id="first_name" name="first_name" placeholder="Prénom"  required>
    <input type="text" id="adress" name="adress" placeholder="Adresse"  required>
    <input type="mail" id="mail" name="mail" placeholder="Adresse Mail"  required>
    <input type="password" id="password" name="password" placeholder="Mot de passe"  required>
    <button type="submit">S'inscrire</button>
  </form>
<a href="./login.php">Vous avez déjà un compte ?</a>
</div>

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