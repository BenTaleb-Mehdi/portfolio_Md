<?php

include 'connectionDb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $stmt = $conn->prepare('DELETE FROM `invoices` WHERE `id` = ?');
    $stmt->bind_param('i', $id);
  
    if ($stmt->execute()) {
        header("Location: users.php"); 
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid ID or no ID provided.";
}

$conn->close();

?>
