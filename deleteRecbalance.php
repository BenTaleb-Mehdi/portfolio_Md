<?php 

include 'connectionDb.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$stmt = $conn->prepare('DELETE FROM `balance` WHERE id = ?');
$stmt->bind_param('i',$id);
$stmt->execute();
header('Location: balance.php');
?>
