<?php
session_start();
require 'db.php';
$db = new DBConnection();
$conn = $db->connect();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
require './header.php';?>
<body>
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
    echo '</tr>';
}
?>
    </tbody>
</table>
</body>