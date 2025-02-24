<?php
    include 'connectionDb.php';
    if(isset($_GET['id'])){
           $id = $_GET['id'];
    }
 
    $stmt = $conn->prepare('SELECT * FROM `invoices` WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();



    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $typeWork = $_POST['typeWork'];
        $country = $_POST['contry'];
        $price = $_POST['price'];
        $dated = $_POST['dated'];
        $datef = $_POST['datef'];

         $query = $conn->prepare('UPDATE `invoices` SET first_name = ?, last_name = ?, phone = ?, email = ?, typeWork = ?, countries = ?, price = ?, date_debut = ?, date_fin = ? WHERE id = ?');
        $query->bind_param('ssssssissi', $fname, $lname, $phone, $email, $typeWork, $country, $price, $dated, $datef, $id);
            if ($query->execute()) {
                     echo "<script>alert('Invoice updated successfully!'); window.location.href='updateUser.php?id=$id';</script>";
            } else {
                     echo "<script>alert('Error updating invoice');</script>";
            };

    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="updateUser.css">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
     <?php
    include("menu.php");
    
   ?>

<div class="contentFormupdate">
      <div class="spaceinvoice">
          <h2>Personal and <span>Work</span> Details</h2>
          $invoice_id = null; 
          <form action="" method="POST">
            <div class="forminputs">
              <div class="part1Info">
              <label for="">First name </label>
              <input type="text" name="fname" placeholder="First name .." value="<?php echo $row['first_name'] ?>"/>

              <label for="">Last name </label>
              <input type="text" name="lname" placeholder="Last name .." value="<?php echo $row['last_name'] ?>"/>

              <label for="">Phone number </label>
              <input type="text" name="phone" placeholder="Phone number .." value="<?php echo $row['phone'] ?>"/>

              <label for="">Email Address </label>
              <input type="email" name="email" placeholder="Email Address .." value="<?php echo $row['email'] ?>"/>

              <label for="">Type project </label>
              <select name="typeWork" id="" value="<?php echo $row['typeWork'] ?>">
                <option value="Website">Website</option>
                <option value="Dashboard">Dashboard</option>
              </select>
            </div>

            <div class="part2Info">
              <label for="">Country</label>
              <input type="text" name="contry" placeholder="Select Country .." value="<?php echo $row['countries'] ?>"/>

              <label for="">Price for working </label>
              <input type="text" name="price" placeholder="Price for working .." value="<?php echo $row['price'] ?>"/>

              <label for="">Date debut </label>
              <input type="date" name="dated" placeholder="date debut .." value="<?php echo $row['date_debut'] ?>"/>

              <label for="">date de fin </label>
              <input type="date" name="datef" placeholder="date de fin .." value="<?php echo $row['date_fin'] ?>"/>
            </div>
            </div>
            <div class="btnSave">
              <button type="submit">Update invoice</button>
            <?php if (!empty($invoice_id)) : ?>
                <a href="printinvoice.php?id=<?php echo $invoice_id; ?>" class="btnPrint">Print Invoice</a>
            <?php endif; ?>
          </div>
          </form>
          
        </div>
</div>

   
</body>
</html>