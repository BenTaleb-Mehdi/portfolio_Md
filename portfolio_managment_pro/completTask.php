<?php 
    include 'connectionDb.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $stmt = $conn->prepare('UPDATE `to_do_liste` set statut_Task = 1 WHERE id = ?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    header('Location: todo.php');


    



?>