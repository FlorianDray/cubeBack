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
    <h1>Connexion</h1>       
    <input type="email" name="mail" placeholder="Adresse mail" required autofocus>        
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
<a href="./register.php">Pas encore de compte ?</a>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try{
        $query = "SELECT * FROM users WHERE mail = :mail;";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':mail', $_POST['mail']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['password'], $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
		    $_SESSION["user_name"] = $user["last_name"];
            echo "<div class='sucess'>Connexion réussi</div>";
            header("Location: index.php");
		    exit;
        } else{
        echo "<div class='error'>Mail ou mot de passe incorrect</div>";
        } 
    } catch (PDOException $e) {
        echo "La requête d'insertion a échoué : " . $e->getMessage();
    }
}
?>