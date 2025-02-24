<?php 
    include 'connectionDb.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['com'])){
          $id_btnCom = $_POST['com'];
          $stmt = $conn->prepare('UPDATE `invoices` set `statut` = 1 where `statut` = 0 AND id = (?)');
          $stmt->bind_param('i', $id_btnCom);        
          $stmt->execute();
          $stmt->close();
        }
        

        if(isset($_POST['incom'])){
          $id_btniCom = $_POST['incom'];
          $stmt = $conn->prepare('UPDATE `invoices` set `statut` = 0 where `statut` = 1 AND id = (?)');
          $stmt->bind_param('i', $id_btniCom);        
          $stmt->execute();
          $stmt->close();
  }
}




?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css?v=6">
    <title>Users</title>
</head>
<body>
   <?php
    include("menu.php");
   ?>

 <div class="contentUsers hidden">
        <h2 class="titleAnalyese">User Analytics & Details</h2>
        <br />
        <h3 class="titlePart"><i class="bx bx-data"></i> All Users Overview</h3>
        <div class="serchUser">
        <form action="users.php" method="post">
        <input type="search" name="search" placeholder="Enter a name user for search..." ">
        <button type="submit"><i class="bx bx-search-alt-2"></i></button>
    </form>
          
        </div>
        <div class="usersSpace">
      
          <div class="datatable">
            
 
          <table>
               <form action="" method="post">
              <tr>
                <th>Id</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone number</th>
                <th>Email Address</th>
                <th>Type work</th>
                <th>Countries</th>
                <th>price working</th>
                <th>Satatut Project</th>
            <th>Date debut</th>
                <th>Dtae fin</th>
                <th>options</th>
            
                <th class="tbtnstuts">staut</th>
                
              </tr>

              <?php 
              include 'connectionDb.php';
          
              $searchQuery = "";
              if (isset($_POST['search'])) {
                    $searchQuery = $_POST['search'];
              }
                     if (empty($searchQuery)) {
                          $stmt = $conn->prepare('SELECT * FROM `invoices`');
                            
                      } else {
                          // If no search term, fetch all records
                         $stmt = $conn->prepare('SELECT * FROM `invoices` WHERE `first_name` LIKE ? OR `last_name` LIKE ?');
                          $searchTerm = "%" . $searchQuery . "%";  // To match partial names
                          $stmt->bind_param('ss', $searchTerm, $searchTerm);
                      }
                        $stmt->execute();
                        $result = $stmt->get_result();
                   
                        $stmt->close();
              
                
              
              while($row = $result->fetch_assoc()){

                if($row['statut'] == 0){
                    $staut = "";
                    $staut = "Completed";
                }else{
                  $staut = "incomplted";
                }
          echo '<tr>';
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>". $row["first_name"] ."</td>";
              echo "<td>". $row["last_name"] ."</td>";
              echo "<td>". $row["phone"] ."</td>";
              echo "<td>". $row["email"] ."</td>";
              echo "<td>". $row["typeWork"] ."</td>";
              echo "<td>". $row["countries"] ."</td>";
              
             
              echo "<td>".$row["price"]." Dh"."</td>";
              echo "<td>". $staut ."</td>";
               ?>
          
           <?php
              echo "<td>". $row["date_debut"] ."</td>";
              echo "<td>". $row["date_fin"] ."</td>";

            echo '<td>
                <a href="updateUser.php?id=' . $row['id'] . '"><i class="bx bxs-pencil" style="color: rgb(2, 143, 9)"></i></a>
                <a href="delete.php?id=' . $row['id'] .'"><i class="bx bxs-message-square-x" style="color: rgb(143, 2, 2)"></i></a>';
            if (!empty($row['id'])) {
                echo '<a href="printinvoice.php?id='.$row['id'].'" class="btnPrint"><i class="bx bxs-file-find" style="color: rgb(35, 35, 192)"></i></a>';
            }
            echo '</td>';
            
              echo '<td class="btnStauts">
                   
                    <button name="incom" value="' . $row['id'] . '"><i class="bx bx-check-circle"></i></button>
                     <button name="com" style="color:red" value="' . $row['id'] . '"><i class="bx bx-x-circle"></i></button>
                    
                    </td>';
            
          echo'</tr>';

              }
        
              ?>
            </form>
              </table>

         
   
          </div> 
          
          <div class="bestusersrsAndmessages">
            <div class="bestUsers">
        
                <h3 class="titlePart">
                <i class="bx bxs-inbox"></i> Best Clients Ranking
              </h3>
              <br/>
<?php  
  include 'connectionDb.php';
  $stmt = $conn->prepare('SELECT `first_name`,`last_name` from `invoices` ORDER BY `price` DESC LIMIT 3');
  $stmt->execute();
  $result = $stmt->get_result();
      $posstion = ['1er','2ème','3ème'];
      $index = 0;
  if( $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
      $first_name = $row ['first_name'];
      $last_name = $row ['last_name'];
      $rank = $posstion[$index];
      $index++;
      
?>
              <div class="bestsClinet">
                <div class="formClint">
                  <div class="icontBest">
                    <i class="bx bxs-user-circle"></i>
                  </div>
                  <div class="nameclinet">
                    <h2><?php echo $first_name . "  " . $last_name ?></h2>
                    <p><i class='bx bx-medal' style='color:#ffffff' ></i> Rank <span><?php echo $rank; ?></span></p>
                  </div>
                </div>
              </div>
<?php

    }
  }
?>

        
            </div>

    <div class="msgUsers">
           <div class="navMsUsers">
               <h3 class="titlePart">
                <i class="bx bxs-inbox"></i> Most customer messages
              </h3>
              <br/>
              <div class="seeMsg">
                  <i class='bx bxs-inbox'></i>
                   <a href="inbox.php">All Messages</a>
              </div>
           </div>
     

            <?php 
              include 'connectionDb.php';
              $stmt = $conn->prepare('SELECT `first_name` , `last_name`, `date` from `messages` ORDER BY `date` DESC  LIMIT 3');
              $stmt->execute();
              $result=$stmt->get_result();
             
              if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                  $first_name = $row['first_name'];
                  $last_name = $row['last_name'];
                  $date = $row['date'];
                  $date_object = new DateTime($date);
                  $date_now = new DateTime();

                $date_now->setTime(0, 0); // Reset time to 00:00
                $date_object->setTime(0, 0); 
                   $new_msg = "";
                   $message = "";

                   if($date_now == $date_object){
                    $new_msg = "New";
                    $message = "Meassge";
                   }else{
                    $new_msg = $date_object->format('y/m/d');
                    $message = "Created";
                   }

            ?>       
   <div class="message"> 
    
        
        
                <div class="infoMsg">
                  <div class="iconmessage">
                    <i class="bx bx-message-square-dots"></i>
                  </div>
                  <div class="informessage">
                    <h2><?php echo $first_name ." ". $last_name ?></h2>
                    <p><span><?php echo $new_msg; ?></span><?php echo $message; ?></p>
               
                  </div>
              
                 </div>   
               </div>
         <?php
             }
          }
        
        ?>

      
               
      </div>
          </div>
        </div>
      </div>

</body>
</html>
