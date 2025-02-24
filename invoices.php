<?php
  include 'connectionDb.php';
$invoice_id = null;
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $typeWork = $_POST['typeWork'];
    $contry = $_POST['contry'];
    $price = $_POST['price'];
    $dated = $_POST['dated'];
    $datef = $_POST['datef'];
  
if(empty($fname) || empty($lname) || empty($phone) || empty($email) || empty($contry)){
    $message_error="All fields are required";
}else{
    $stmt = $conn->prepare('INSERT INTO `invoices` (`id`, `first_name`, `last_name`, `phone`, `email`,`typeWork`, `countries`, `price`, `date_debut`, `date_fin`) VALUES
    (null,?,?,?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssssss',$fname,$lname,$phone,$email,$typeWork,$contry,$price,$dated,$datef);
    $stmt->execute();
    $invoice_id = $conn->insert_id;
    $message="Invoice successfully created";
}
  


  }


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="invoice.css?v=5">
    <title>Invoice Users</title>
</head>
<body>
   <?php
    include("menu.php");
   ?>

    <div class="contentinvoiUser hidden">
      <?php if(!empty($message)):?>
         <div class="spaceerror">
              <p><?php echo htmlspecialchars($message); ?></p>
              <button class="btnclose"><i class='bx bx-x'></i></button>
            </div>
      <?php endif;?>

      <?php if(!empty($message_error)):?>
         <div class="message_error">
              <p><?php echo htmlspecialchars($message_error); ?></p>
              <button class="btnclose_error"><i class='bx bx-x'></i></button>
            </div>
      <?php endif;?>
        <div class="spaceinvoice">
          <h2>Personal and <span>Work</span> Details</h2>
          $invoice_id = null; 
          <form action="" method="POST">
            <div class="forminputs">
              <div class="part1Info">
              <label for="">First name </label>
              <input type="text" name="fname" placeholder="First name .." />

              <label for="">Last name </label>
              <input type="text" name="lname" placeholder="Last name .." />

              <label for="">Phone number </label>
              <input type="text" name="phone" placeholder="Phone number .." />

              <label for="">Email Address </label>
              <input type="email" name="email" placeholder="Email Address .." />

              <label for="">Type project </label>
              <select name="typeWork" id="">
                <option value="Website">Website</option>
                <option value="Dashboard">Dashboard</option>
              </select>
            </div>

            <div class="part2Info">
              <label for="">Country</label>
              <input type="text" name="contry" placeholder="Select Country .." />

              <label for="">Price for working </label>
              <input type="text" name="price" placeholder="Price for working .." />

              <label for="">Date debut </label>
              <input type="date" name="dated" placeholder="date debut .." />

              <label for="">date de fin </label>
              <input type="date" name="datef" placeholder="date de fin .." />
            </div>
            </div>
            <div class="btnSave">
              <button type="submit">Add invoice</button>
            <?php if (!empty($invoice_id)) : ?>
                <a href="printinvoice.php?id=<?php echo $invoice_id; ?>" class="btnPrint">Print Invoice</a>
            <?php endif; ?>
          </div>
          </form>
          
        </div>

      </div>

  <script>
      
    // Close success message
    const spaceError = document.querySelector('.spaceerror');
    const btnClose = document.querySelector('.btnclose');

    if (spaceError && btnClose) {
      btnClose.addEventListener('click', () => {
        spaceError.classList.add('remove');
      });
    }

    // Close error message
    const messageError = document.querySelector('.message_error');
    const btnCloseError = document.querySelector('.btnclose_error');

    if (messageError && btnCloseError) {
      btnCloseError.addEventListener('click', () => {
        messageError.classList.add('remove');
      });
    }
  </script>
</body>
</html>