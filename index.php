<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<?php require './header.php';?>
 <h1>Bonjour <?php $_SESSION['user_name']?></h1>
