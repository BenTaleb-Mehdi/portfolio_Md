<?php 
    include 'connectionDb.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $stmt = $conn->prepare('DELETE FROM `to_do_liste` WHERE id = ?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    header('Location: todo.php');




?>