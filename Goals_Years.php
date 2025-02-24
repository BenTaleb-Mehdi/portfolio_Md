<?php 
    include 'connectionDb.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $WriteGoal = trim($_POST['WriteGoal']);
        $goalsType = trim($_POST['goalsType']);

        if(!empty($WriteGoal) && !empty($goalsType)){
            $stmt = $conn->prepare('INSERT INTO `goals`(`goal`, `type_goal`) VALUES(?,?)');
            $stmt->bind_param('ss',$WriteGoal,$goalsType);
            $stmt->execute();
            $stmt->close();
            header('Location: Goals_Years.php');
        }
       


    }




?>













<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Goals_Years.css?v=2">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Long term goals</title>
</head>
<body>
      <?php
    include("menu.php");
   ?>

   <div class="title">
            <h2>Hello Mr.Mehdi</h2>
            <h3>What is your Long <span>term goals</span>?</h3>
       </div>
<div class="container">
 
    <div class="formGoals"> 
             <h1>Long term goals</h1>
        <form  method="POST" action="">
      
            <label>Enter a Goals :</label>
            <input type="text" name="WriteGoal" id="" placeholder="Enter your Long term ">
            <label>Type goal </label>
            <select name="goalsType" id="">
                <option value="Business">Business</option>
                <option value="Soft_Skills">Soft Skills</option>
                <option value="Language">Language</option>
                <option value="Relationships">Relationships</option>
                <option value="Other">Other</option>
            </select>
            <button type="submit">Add</button>
        </form>
    </div>

    <div class="DiaplayGoals">
             <div class="goals">
            <h2 class="titleGoals">Goals in years <span>2025</span></h2>
<?php 
    include 'connectionDb.php';
    $stmt = $conn->prepare('SELECT * FROM `goals`');
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){

  


?>
        <div class="goal">
            <div class="Tgoal">
                <div class="goalIcon">
                    <i class="bx bx-task"></i>
                </div>
                <div class="WhriteGoal">
                    <h2><?php echo $row['goal'] ?></h2>
                    <p>type <span><?php echo $row['type_goal'] ?></span></p>
                </div>
            </div>
            <div class="dateCreated">
                <span><?php echo $row['dateCreated'] ?></span>
            </div>
        </div>

 
<?php 
  }
  $stmt->close();
  $conn->close();
?>
          </div>
    </div>
</div>
</body>
</html>