<?php 
  include 'connectionDb.php';
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $taskname = $_POST['taskName'];

if(!empty($taskname)){
      $stmt = $conn->prepare('INSERT INTO `to_do_liste` (`task_name`) VALUES (?) ');
      $stmt->bind_param('s',$taskname);
     $stmt->execute();
     $stmt->close();
     header('Location: todo.php');
   
}
 
  }

  $conn->close();





?>



















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="todo.css?v=2">
    <title>To do liste tesks</title>
</head>
<body>
  <?php
    include("menu.php");
   ?>

      <div class="contentTodoliste">
       

      <form class="formAlltodo" method = "POST" action="todo.php">
        <div class="titleContent">
          <h1 class="t1">Hello Mr.Mehdi</h1>
          <h4 class="t2">What is your <span>plan</span> today?</h4>
        </div>
          <div class="formtodo">
            <label>Enter a your task </label>
            <input type="text" placeholder="Enter what do tou think ..." name="taskName" />
            <button type="submit">Add task</button>
          </div>

          <div class="diplayTasks">
            <div class="editTask">
              <h2>Tasks Completed</h2>
           
              <ul>
                   <?php 
                  include 'connectionDb.php';
                  $stmt = $conn->prepare('SELECT `id`, `task_name`, `statut_Task`, `dateCreated` FROM `to_do_liste`  WHERE statut_Task = 0');
                  $stmt->execute();

                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()){

              ?>
                <li>
                  <div class="data">
                    <i class="bx bx-check"></i>
                    <span><?php echo $row['task_name'] ?></span>
                  </div>
                  <div class="btnedit">
                   <?php echo  '<a href="completTask.php?id= ' . $row['id'] . ' "class="btnCom"><i class="bx bx-check-circle"></i> Completed</a>' ?>
                  <?php echo  '<a href="deleteTask.php?id= ' . $row['id'] . '" class="btnDl"><i class="bx bx-x-circle"></i> Delete</a>' ?>
                  </div>
                </li>
                   <?php 
            }
            $stmt->close();
            $conn->close();
            ?>
              </ul>
            </div>


         
            <div class="completedTask">
              <h2>Tasks Closed</h2>
              <ul>
              <?php 
                  include 'connectionDb.php';
                  $stmt = $conn->prepare('SELECT `id`, `task_name`, `statut_Task`, `dateCreated` FROM `to_do_liste`  WHERE statut_Task = 1');
                  $stmt->execute();

                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc()){

              ?>
                <li>
                  <div class="data">
                    <i class="bx bx-check-double"></i>
                    <span><?php echo $row['task_name'] ?></span>
                  </div>

                  <div class="btndelete">
                      <?php echo  '<a href="deleteTask.php?id= ' . $row['id'] . '" class="btnDl"><i class="bx bx-x-circle"></i> Delete</a>' ?>
                  </div>
                </li>
                    <?php 
            }
            $stmt->close();
            $conn->close();
            ?>
              </ul>
            </div>
          </div>
        </form>
      </div>
</body>
</html>