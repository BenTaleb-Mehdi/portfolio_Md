<?php
  include 'connectionDb.php';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $Rname = $_POST['Rname'];
       $Rprice = $_POST['Rprice'];
        $Aleart = "";
       if(empty($Rname) || empty($Rprice)) {
        $Aleart_false = "your is not reacording name expense name or expense price try again";
       }else{
        $stmt = $conn->prepare("INSERT INTO `balance`(`Expense_name`, `Expense_Price`) VALUES (?, ?)");
        $stmt->bind_param('sd', $Rname, $Rprice);
        $stmt->execute();
        $Aleart_true = "It's Recorded ...";
               
       $stmt->close();
       };
 
   }

   $conn->close();



?>
<?php
  include 'connectionDb.php';
  $count = $conn->prepare("SELECT COUNT(*) AS TOTAL_RECORDS , SUM(Expense_Price) AS 	Expense_Price  FROM `balance`");
$count->execute();
$result = $count->get_result();

if ($result) { // Ensure result exists before fetching
    $countall = $result->fetch_assoc();
    $TOTAL_RECORDS = $countall['TOTAL_RECORDS'];

    $Expense_Price = $countall['Expense_Price'];



} else {
    $TOTAL_RECORDS = 0; // Default value if query fails
};

$count->close();


?>

<?php
  include 'connectionDb.php';
  $count = $conn->prepare("SELECT SUM(price) AS sum_balance FROM `invoices`");
$count->execute();
$result = $count->get_result();

if ($result) { // Ensure result exists before fetching
    $countall = $result->fetch_assoc();
    $TOTAL_balance = $countall['sum_balance'];
    



} else {
    $TOTAL_balance = 0; // Default value if query fails
};

$count->close();


?>








<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="balance.css?v=6" />
    <title>Balance</title>
  </head>
  <body>
     <?php
    include("menu.php");
   ?>

   <?php if(!empty($Aleart_true)) :?>
    <div class="aleart_true">
      <p><?php echo $Aleart_true; ?></p>
      <button class="closebtn"><i class='bx bx-x'></i></button>
    </div>
    <?php endif; ?>

     <?php if(!empty($Aleart_false)) :?>
    <div class="aleart_false">
      <p><?php echo $Aleart_false; ?></p>
      <button class="closebtn"><i class='bx bx-x'></i></button>
    </div>
    <?php endif; ?>


    <div class="contentBalanceAnalyses">
      <h2 class="titleAnalyeseBalance">Balance Analysis</h2>
      <h3 class="titlePartBalance">
        Monitor your financial trends and key insights
      </h3>
      <br />

      <div class="cardsBalance">
        <div class="card">
          <div class="infoCartd">
            <h2>Current Balance</h2>
            <p>Total Balance Income/Expenses</p>
            <br />
            <span><?php echo number_format(($TOTAL_balance+$Expense_Price),2).' Dh'?></span>
          </div>
          <div class="iconCard">
            <i class="bx bx-money-withdraw"></i>
          </div>
        </div>

        <div class="card">
          <div class="infoCartd">
            <h2>Income</h2>
            <p>Total Balance Income</p>
            <br />
            <span><?php echo number_format(($TOTAL_balance-$Expense_Price),2).' Dh'; ?></span>
          </div>
          <div class="iconCard">
            <i class="bx bx-line-chart"></i>
          </div>
        </div>

        <div class="card">
          <div class="infoCartd">
            <h2>Expenses</h2>
            <p>Total Balance Expenses</p>
            <br />
            <span><?php echo number_format($Expense_Price, 2).' Dh'; ?></span>
          </div>
          <div class="iconCard">
            <i class="bx bx-line-chart-down"></i>
          </div>
        </div>
      </div>
      <br />

      <div class="charts">
        <div class="chart1">
          <h3 class="titlePart">Income vs Expenses</h3>
          <br/>
          <canvas id="balanceChart"></canvas>
        </div>
        <div class="chart2">
           <h3 class="titlePart2">  The Expenses by months</h3>
           <br/>
          <canvas id="balanceChart2"></canvas>
        </div>
      </div>

      <div class="calcul_Expenses">
        <div class="recodrs_Ex">
            <h2>Record expenses</h2>
         <form action="" method="POST">
          <label>Enter an Expense name</label>
          <input type="text" name="Rname" placeholder="Expense name ...">
          <label>Enter an Expense Price</label>
          <input type="text" name="Rprice" placeholder="Expense Price ..." ">
          <button type="submit">Record</button>
        </form>
        </div>


        <div class="allExpenses">
          <h2>All Records Expenses</h2>
        
         <table>
   
          <tr>
            <th>Name Expense</th> 
            <th>Price Expense</th>
            <th>Date Created</th>
            <th>Option</th>
          </tr> 


            <tr>
              <?php 
                include 'connectionDb.php';
                $stmt = $conn->prepare('SELECT * FROM `balance`');
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){

              ?>
                <td><?php echo $row['Expense_name'] ?></td>
                <td><?php echo $row['Expense_Price'].' Dh' ?></td>
                <td><?php echo $row['dateCreated'] ?></td>
                <td>
                  <?php echo' <a href="deleteRecbalance.php?id=' . $row['id'] .'"><i class="bx bxs-message-square-x" style="color: rgb(143, 2, 2) "></i></a>' ?>
                </td>
            </tr>
     
          <?php
            }
            $stmt->close();
          ?>       
          
         </table>
          <div class="TotalExpenses">
            <div class="namesRecords">
              <h2>Records name :</h2>
              <h2>Rescord prices :</h2>
            </div>
            <div class="dataRecords">
              <span><?php echo $TOTAL_RECORDS;  ?></span>
              <span><?php echo number_format($Expense_Price,2).' Dh'; ?></span>
            </div>

          </div>
        </div>

      
      </div>

   
    </div>
    <?php
      include 'connectionDb.php';
      $stmt = $conn->prepare("SELECT DATE_FORMAT(`dateCreated`,'%M') AS months ,
       COUNT(id) AS Expense_Sum FROM `balance` GROUP BY months ORDER BY id DESC ");
       $stmt->execute();
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
          $MONTHS[] = "";
          $TOTAL_EX[] = ""; 

      $MONTHS[] = $row['months'];
      $TOTAL_EX[] = $row['Expense_Sum'];
    
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
const MONTHS = <?php echo json_encode($MONTHS); ?>;
const TOTAL_EX = <?php echo json_encode($TOTAL_EX); ?>;

      const ctx4 = document.getElementById("balanceChart");
      const ctx5 = document.getElementById("balanceChart2");
      new Chart(ctx4, {
        type: "doughnut",
        data: {
          labels: ["Ecome", "Expenses"],
          datasets: [
            {
              label: "Ecomes / Expenses 2025",
              data: [<?php echo $TOTAL_balance; ?>, <?php echo $Expense_Price; ?>],
              borderWidth: 0,
            

              backgroundColor: ["rgb(5, 81, 5)", "rgb(126, 7, 7)"],
            },
          ],
        },
       options: {
          responsive: true,
          plugins: {
            legend: {
              labels: {
                color: "white", 
              },
             
            },
            tooltip: {
              bodyColor: "white", 
              titleColor: "white", 
            },
          },
        }
      });

      new Chart(ctx5, {
        type: "line",
        data: {
          labels: MONTHS,
          datasets: [
            {
              label: "The Expenses in Year 2025",
              data: TOTAL_EX,
              borderWidth: 1,
              borderColor: "#0a7a19",
            },
          ],
        },
        options: {
            plugins: {
            legend: {
              labels: {
                color: "white", 
              },
             
            },
            tooltip: {
              bodyColor: "white", 
              titleColor: "white", 
            },
          },
        },
      });
    </script>

    <script>
      const aleart_true = document.querySelector('.aleart_true'),
       aleart_false = document.querySelector('.aleart_false'),
      closebtn = document.querySelector('.closebtn');

      closebtn.addEventListener('click',()=>{
        aleart_true.classList.add('close');
      });

           closebtn.addEventListener('click',()=>{
        aleart_false.classList.add('close');
      });

    </script>
  </body>
</html>
