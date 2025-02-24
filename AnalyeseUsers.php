<?php
include 'connectionDb.php';

$count = $conn->prepare('SELECT COUNT(*) AS TOTAL_VISITERS FROM `visiters`');
$count->execute();
$visiters = $count->get_result();
if($count){
  $row_visiter = $visiters->fetch_assoc();
  $total_Visiters = $row_visiter['TOTAL_VISITERS'];

}
$count->close();


$count = $conn->prepare('SELECT COUNT(*) AS TOTAL_PROCOMPLTED FROM `invoices` WHERE `statut` = 0');
$count->execute();
$pros = $count->get_result();
if($count){
  $row_TOTAL_PROCOMPLTED = $pros->fetch_assoc();
  $TOTAL_PROCOMPLTED = $row_TOTAL_PROCOMPLTED['TOTAL_PROCOMPLTED'];

}
$count->close();
function getTotalCount($conn, $table, $columnName) {
    $stmt = $conn->prepare("SELECT COUNT(id) AS $columnName FROM `$table`");
    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res) {
        $row = $res->fetch_assoc();
        $total = $row[$columnName] ?? 0; // تجنب الأخطاء إذا كان الجدول فارغًا
    } else {
        $total = 0; // في حالة حدوث خطأ
    }

    $stmt->close();
    return $total;
}

$totalFollowers = getTotalCount($conn, 'followrs', 'id');
$totalMessages = getTotalCount($conn, 'messages', 'id');

$conn->close();




?>


<?php
  include 'connectionDb.php';
  
$chartData = $conn->prepare("SELECT DATE_FORMAT(`Date`, '%M') AS months, COUNT(id) AS total_followers 
        FROM `followrs` 
        GROUP BY months
        ORDER BY total_followers DESC");
$chartData->execute();
$result = $chartData->get_result();
$total_followers = [];
$total_months = [];

while ($row = $result->fetch_assoc()) {
  $total_followers[] = $row['total_followers'];
  $total_months[] = $row['months'];
}

$chartData->close();
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="AnalyeseUsers.css?v=4" />
    <title>Analyes User</title>
  </head>
  <body>
     <?php
    include("menu.php");
   ?>
 <div class="spaeceAllUsers">
      <div class="contentCheckUsers">
            <nav>
              <div class="title">          
                <i class='bx bxs-user-plus'></i>
                <h2>Check Followers</h2>
              </div>

              <div class="btnClose">
                <i class='bx bx-x'></i>
              </div>
            </nav>

            <div class="content">
           
              <table>

                    <tr>
                  <th>id</th>
                  <th>Full name</th>
                  <th>Email Address</th>
                  <th>date</th>
                  <th>Emailing</th>
                </tr>
             
   <?php
                include 'connectionDb.php';

                $stmt = $conn->prepare('SELECT * from `followrs`');
                $stmt->execute();
                $res = $stmt->get_result();
                
             
                if ($res) {
                  while ($row = $res->fetch_assoc()) {
                    $date = $row['Date'];
                      $date_object = new DateTime($date);
                      $date_now = new DateTime();

                      $date_now->setTime(0, 0);
                      $date_object->setTime(0, 0); 

                      if($date_now == $date_object) {
                        $new = "new";
                      }else{
                          $new = $date_object->format('y/m/d');
                        
                      };


               
              
              ?>
          

                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $new; ?></td>
                  <td><button>send</button></td>
                </tr>
         

              <?php
                  }
                }
                $stmt->close();
              ?>     
              </table>
            </div>
      </div>
 </div>
    <div class="contentanalysesUsers">
      <div class="titlebalanaceAnalyeses">
        <h2 class="titleAnalyese">Views and Followers Analysis</h2>
        <br/>
        <h3 class="titlePart"><i class="bx bx-line-chart"></i> Overview</h3>
      </div>
      <div class="contentpr1">
        <div class="boxesAnlyses">
          <div class="boxAnalyies">
            <div class="info">
              <div class="titleInfo">
                <h2>Visiters</h2>
                <p>Total visiters</p>
              </div>

              <div class="iconInfo">
                <i class="bx bx-window-open"></i>
              </div>
            </div>
            <div class="nbInfo">
              <div class="nbUserss">
                <h2><span><?php echo $total_Visiters; ?></span></h2>
                <p>/Total</p>
              </div>
              <?php 
                  if($total_Visiters < 40){
                      echo ' 
                              <div class="downup">
                                <span> descent <i class="bx bx-trending-down"></i>  </span>
                              </div>';

                  }else{
                   echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                          </div>';
                  }
              ?>
            </div>
          </div>

          <div class="boxAnalyies">
            <div class="info">
              <div class="titleInfo">
                <h2>Followrs</h2>
                <p>Total Followrs</p>
              </div>

              <div class="iconInfo">
                <i class="bx bxs-user-plus"></i>
              </div>
            </div>
            <div class="nbInfo">
              <div class="nbUserss">
                <h2><span><?php echo $totalFollowers; ?></span></h2>
                <p>Total</p>
              </div>
              <?php 
                  if($totalFollowers < 10){
                      echo ' 
                              <div class="downup">
                                <span> descent <i class="bx bx-trending-down"></i>  </span>
                              </div>';

                  }else{
                   echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                          </div>';
                  }
              ?>
            </div>
          </div>

          <div class="boxAnalyies">
            <div class="info">
              <div class="titleInfo">
                <h2>Statut Projects</h2>
                <p>Total Project Completed</p>
              </div>

              <div class="iconInfo">
                <i class="bx bx-task"></i>
              </div>
            </div>
            <div class="nbInfo">
              <div class="nbUserss">
                <h2><span><?php echo $TOTAL_PROCOMPLTED; ?></span></h2>
                <p>/Completed</p>
              </div>
              <?php 
                  if($TOTAL_PROCOMPLTED > 5){
                      echo ' 
                              <div class="downup">
                                <span> descent <i class="bx bx-trending-down"></i>  </span>
                              </div>';

                  }else{
                   echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                          </div>';
                  }
              ?>
            </div>
          </div>

          <div class="boxAnalyies">
            <div class="info">
              <div class="titleInfo">
                <h2>Messages</h2>
                <p>Total Messages</p>
              </div>

              <div class="iconInfo">
                <i class="bx bx-message-square-dots"></i>
              </div>
            </div>
            <div class="nbInfo">
              <div class="nbUserss">
                <h2><span><?php echo $totalMessages; ?></span></h2>
                <p>/Total</p>
              </div>
                   <?php 
                  if($totalMessages < 15){
                      echo ' 
                              <div class="downup">
                                <span> descent <i class="bx bx-trending-down"></i>  </span>
                              </div>';

                  }else{
                   echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                          </div>';
                  }
              ?>
            </div>
          </div>
        </div>
        <div class="chartAnalyeseUsers">
          <canvas id="myChart2"></canvas>
        </div>
      </div>
     <div class="navcontent2">
        <h3 class="titlePart">
        <i class="bx bxs-bar-chart-alt-2"></i> Analyses Last Followers 
      </h3> 
        <button class="checkUser"><i class="bx bxs-user-detail"></i><br />view All</button>
      </div>
<div class="contentpr02">
       

<?php

  include 'connectionDb.php';
  $stmt = $conn->prepare('SELECT id , fullname FROM `followrs`');
  $stmt->execute();
  $res = $stmt->get_result();
 
      
       
?>   

 <div class="newUsers">
<?php
        
        while ($row = $res->fetch_assoc()) {

?>
           <div class="newUser">
            <div class="prinfo">
              <div class="iconNewuser">
                <i class="bx bxs-user-plus"></i>
              </div>
              <div class="infoNweuser">
                <h2><?php echo $row['fullname']; ?></h2>
                <p>type <span>Web development</span></p>
              </div>
            </div>
            <div class="newFl">
              <h2>New</h2>
             
            </div>
          </div>
      
<?php
    }
?>
      </div>


        <div class="chartAnalyeseUsersCountry">
          <canvas id="myChart3"></canvas>
        </div>
    </div>
</div>






    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const T_followers = <?php echo json_encode($total_followers); ?>;
      const T_months = <?php echo json_encode($total_months); ?>;
      const ctx2 = document.getElementById("myChart2");
      const ctx3 = document.getElementById("myChart3");
      new Chart(ctx2, {
        type: "line",
        data: {
          labels:T_months,
          datasets: [
            {
              label: "Followers in Year 2025",
              data: T_followers,
              borderWidth: 1,
              borderColor: "#0a7a19",
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });

      new Chart(ctx3, {
        type: "bar", // set the chart type here
        data: {
          labels: ["Followers", "visiters"],
          datasets: [
            {
              type: "bar",
              label: "Visitors",
              data: [<?php echo $totalFollowers; ?>,<?php echo $total_Visiters; ?> ],
              backgroundColor: "#11111", // semi-transparent white for bar
              borderWidth: 1,
              borderColor: "green",
            }
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: "rgba(255, 255, 255, 0.1)", // faint gridlines for dark mode
              },
              ticks: {
                color: "white", // white tick marks on the y-axis
              },
            },
            x: {
              ticks: {
                color: "white", // white tick marks on the x-axis
              },
            },
          },
          plugins: {
            legend: {
              labels: {
                color: "white", // white legend text for visibility in dark mode
              },
            },
          },
        },
      });



      const checkUser = document.querySelector('.checkUser'),
      btnClose = document.querySelector('.btnClose'),
      spaeceAllUsers = document.querySelector('.spaeceAllUsers');

      checkUser.addEventListener('click',()=>{
        spaeceAllUsers.classList.add('show');
      });

       btnClose.addEventListener('click',()=>{
        spaeceAllUsers.classList.remove('show');
      });

    </script>
  </body>
</html>
