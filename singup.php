<?php
include 'connectionDb.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $emil = $_POST['email'];
    $phone = $_POST['phone'];
    $dateC = $_POST['dateC'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Cpassword = $_POST['Cpassword'];

   if(password_verify($Cpassword,$password)){
     $stmt = $conn->prepare("INSERT INTO `singup`( `id`,`first_name`, `last_name`, `Email`, `phone`, `date_created`, `username`, `password`) VALUES 
    (null,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssss',$first_name,$last_name,$emil,$phone,$dateC,$username,$password);
    $stmt->Execute();
    header('location: index.php');
   }else{
    echo 'password is not mached';
   }

 

  }


?>








<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="singup.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sing Up</title>
  </head>
  <body>
    <div class="navbar">
      <div class="typepage">
        <span>Sing Up</span>
      </div>
      <div class="name">
        <h2>Mehdy Bentaleb</h2>
        <img src="imgMd.png" alt="" />
      </div>
    </div>
    <div class="container">
      <form action="" method="POST">
        <div class="contentlogin">
          <h2>Sing Up <span>Dahsboard</span> Admin</h2>

          <div class="content">
            <div class="partcontent1">
              <label>First name</label>
              <input type="text" name="fname" id="" placeholder="Enter a first name ..."/>

              <label>Last name</label>
              <input type="text" name="lname" id="" placeholder="Enter a last name ..." />

              <label>Email</label>
              <input type="email" name="email" id="" placeholder="Enter a Email ..." />

              <label>Phone number</label>
              <input type="text" name="phone" placeholder="Enter a phone number ..." />
            </div>

            <div class="partcontent2">
              <label>Date sing</label>
              <input type="date" name="dateC" id="" placeholder="Enter a date ..." />

              <label>Username</label>
              <input
                type="text"
                name="username"
                id=""
                placeholder="Enter a username ..."
              />

              <label>password</label>
              <input type="password" name="password" id=""placeholder="Enter a passwodr ..."
              />

              <label>Confierm password</label>
              <input type="password" name="Cpassword" placeholder="Enter a confierm password ..."
              />
            </div>
          </div>
        </div>
        <button type="submit">Sing up</button>
        <div class="btnswitch">
          <a href="index.php" class="singupbtn">Login</a>
        </div>
      </form>
    </div>
  </body>
</html>
