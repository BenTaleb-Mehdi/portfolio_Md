<?php
    $localname = 'localhost';
    $username  = 'root';
    $password = '';
    $database = 'databasepro';

    $conn = new mysqli($localname,$username,$password,$database);

    if($conn->error){
        die('error'.$conn->error);
    };


?>