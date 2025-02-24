<?php
session_start();
  include 'connectionDb.php';

  $stmt = $conn->prepare('SELECT COUNT(*) AS totla_users FROM `invoices`');
  $stmt->execute();
  $result = $stmt->get_result();
  if($result){
    $row= $result->fetch_assoc();
    $totla_users = $row['totla_users'];
  }


  $stmt = $conn->prepare('SELECT SUM(price) AS Revenue FROM `invoices`');
  $stmt->execute();
  $result = $stmt->get_result();
  if($result){
    $row= $result->fetch_assoc();
    $Revenue = $row['Revenue'];
  }

  $stmt->close();
$conn->close();


?>
<?php
  include 'connectionDb.php';
  $dataChart = $conn->prepare("SELECT DATE_FORMAT(`dateCreated`, '%M') AS months,
 count(id) AS users from `invoices` GROUP BY months order by users DESC");
 $dataChart->execute();
 $result = $dataChart->get_result();
 $Total_users = [];
 $Total_months = [];

while ($row = $result->fetch_assoc()) {
    $Total_users[] = $row['users'];   
    $Total_months[] = $row['months']; 
}

 $dataChart->close();
 $conn->close();

?>

<?php 
  include 'connectionDb.php';
  $stmt = $conn->prepare('SELECT COUNT(id) AS complted_pro FROM `invoices` WHERE `statut` = 0');
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $complted_pro = $row['complted_pro'];


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css?v=5">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>dahsboard</title>
</head>
<body>
    <?php
    include("menu.php");
   ?>


    <div class="contentDashboard">
        <div class="titleUsersection">
          <h2 class="titleAnalyese">Dashboard Overview</h2>
          <br />
          <h3 class="titlePart"><i class="bx bxs-bar-chart-alt-2"></i> Key Metrics Overview</h3>
        </div>
        <div class="boxes">
          <!-- Box 1: Users -->
          <div class="box">
            <div class="prtAnalayses">
              <div class="analeasesT">
                <h2>Users</h2>
                <p>Active users this month</p>
              </div>
              <div class="partIcon">
                <!-- Icon can be added here -->
                <i class="bx bx-user-circle"></i>
              </div>
            </div>
            <div class="numbers">
              <div class="nb">
                <span><?php echo $totla_users; ?></span>
              </div>
              <div class="iconnb">
                   <?php
                  if($totla_users < 10){
                      echo '  <span class="downup">
                                  descent <i class="bx bx-trending-down"></i>
                              </span>';
                  }else{
                    echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                            </div>';
                  }
              ?>
              </div>
            </div>
          </div>

          <!-- Box 2: Projects -->
          <div class="box">
            <div class="prtAnalayses">
              <div class="analeasesT">
                <h2>Projects</h2>
                <p>Completed projects</p>
              </div>
              <div class="partIcon">
                <i class="bx bx-briefcase"></i>
              </div>
            </div>
            <div class="numbers">
              <div class="nb">
                <span><?php echo $complted_pro; ?></span>
              </div>
              <div class="iconnb">
                 <?php
                  if($complted_pro > 5){
                      echo '  <span class="downup">
                                  descent <i class="bx bx-trending-down"></i>
                              </span>';
                  }else{
                    echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                            </div>';
                  }
              ?>
              </div>
            </div>
          </div>

          <!-- Box 3: Revenue -->
          <div class="box">
            <div class="prtAnalayses">
              <div class="analeasesT">
                <h2>Revenue</h2>
                <p>Monthly earnings</p>
              </div>
              <div class="partIcon">
                <i class="bx bx-money-withdraw"></i>
              </div>
            </div>
            <div class="numbers">
              <div class="nb">
                <span><?php echo number_format($Revenue,2).' Dh'; ?></span>
              </div>
              <div class="iconnb">
              <?php
                  if($Revenue < 10000){
                      echo '  <span class="downup">
                                  descent <i class="bx bx-trending-down"></i>
                              </span>';
                  }else{
                    echo ' <div class="iconnb">
                                <span> to rise <i class="bx bx-trending-up"></i> </span>
                            </div>';
                  }
              ?>
              </div>
            </div>
          </div>
 
          <div class="box">
            <div class="prtAnalayses">
              <div class="analeasesT">
                <h2>Tasks</h2>
                <p>Task is not complted</p>
              </div>
              <div class="partIcon">
                <i class="bx bx-check-double"></i>
              </div>
            </div>
            <div class="numbers">
              <div class="nb">
                <span>2</span>
              </div>
              <div class="iconnb">
                <span>
                  to rise
                  <i class="bx bx-error-alt" style="color: rgb(113, 6, 6)"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <h3 class="titlePartanalyes"><i class="bx bx-line-chart"></i> Users by Month</h3>
        <div class="analaysesHome">
          <div class="chart">
            <canvas id="myChart"></canvas>
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
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>
      const T_users = <?php echo json_encode($Total_users) ?>;
      const T_months = <?php echo json_encode($Total_months) ?>;
      const ctx = document.getElementById("myChart");
   
      new Chart(ctx, {
        type: "line",
        data: {
          labels:T_months,
          datasets: [
            {
              label: "Users in Year 2025",
              data: T_users,
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


      </script>
</body>
</html>