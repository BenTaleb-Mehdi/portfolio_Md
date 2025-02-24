<?php
include "connectionDb.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Sanitize and trim user inputs
    $usernamelogin = trim($_POST['usernamelogin']);
    $passwordlogin = trim($_POST['passwordlogin']);
    $error="Incorecct password or username";

    // Prepare statement to fetch the user record
    $stmt = $conn->prepare("SELECT `id`, `password` FROM `singup` WHERE `username` = ?");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param('s', $usernamelogin);
    $stmt->execute();
    $stmt->store_result();

    // Bind result variables
 

     if ($stmt->num_rows > 0) {
        // جلب القيم
        $stmt->bind_result($id, $passwordhash);
        $stmt->fetch();

        // التحقق من كلمة المرور
        if (!empty($passwordlogin) && password_verify($passwordlogin, $passwordhash)) {
            header("Location: dashboard.php");
            exit;
        }
    }

    $stmt->close();
}
?>










<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=1" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
  </head>
  <body>
    <div class="navbar">
      <div class="typepage">
        <span>Login</span>
      </div>
      <div class="name">
        <h2>Mehdy Bentaleb</h2>
        <img src="imgMd.png" alt="" />
      </div>
    </div>
     <?php if (!empty($error)) : ?>
            <div class="spaceerror">
              <p class="error_message"><?php echo htmlspecialchars($error); ?></p>
              <button class="btnclose"><i class='bx bx-x'></i></button>
            </div>
        <?php endif; ?>
    <div class="container">
      <form action="" method="POST">
        <div class="contentlogin">
        
          <h2>Login <span>Dahsboard</span> Admin</h2>

          <label>Username</label>
          <input type="text" name="usernamelogin" id="" placeholder="Enter a username ..." />

          <label>PassWord</label>
          <input type="password" name="passwordlogin" placeholder="Enter a passwodr ..." />

           <button type="submit">Login</button>
          <div class="btnswitch">
            <a href="">Forget password </a>
            <a href="singup.php" class="singupbtn">Sing Up</a>
          </div>
        </div>
      </form>
    </div>
    <script>
      const spaceerror =document.querySelector('.spaceerror'),
      closebtn = document.querySelector('.btnclose');

      closebtn.addEventListener('click',()=>{
        spaceerror.classList.add('remove');
      })
    </script>
  </body>
</html>
