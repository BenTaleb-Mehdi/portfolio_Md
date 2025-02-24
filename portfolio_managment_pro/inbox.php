<?php
include 'connectionDb.php';

$fname = $lname = $email = $phone = $message = "";

// التحقق مما إذا كان هناك ID مُرسل عبر GET
if(isset($_GET['id'])){
    $id = $_GET['id'];
  $found_message = "";
    // جلب بيانات الرسالة
    $stmt = $conn->prepare('SELECT `first_name`, `last_name`, `Email`, `phone`, `message` FROM `messages` WHERE `id` = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // جلب البيانات وتخزينها في متغيرات
    if($row = $result->fetch_assoc()){
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $email = $row['Email'];
        $phone = $row['phone'];
        $message = $row['message']; 
    }else{
        $found_message = "No message sended";
    }




}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="inbox.css?v=9">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
</head>
<body>
    <?php   
        include 'menu.php';   
    ?>

   <?php
        include 'connectionDb.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accept"])) {
        $id = intval($_POST["id"]);
        $conn->query("UPDATE `messages` SET `deleted` = 0 WHERE id = $id");
        
    }elseif(isset($_POST["notAccepted"])){
      $id = intval($_POST["id"]);
      $conn->query("UPDATE `messages` SET `deleted` = 1 WHERE id = $id");
     
    }
   
    if (isset($_POST["delete"])) {
        $id = intval($_POST["id"]);
        $conn->query("DELETE FROM `messages` WHERE id = $id");
    }
}
    ?>

        <div class="titleInboxpage">
            <h2>Space All <span>Messages</span></h2>
        </div>


<div class="container">
  
 <div class="contentAllMsg">
   <div class="seeMessage">
      <div class="titleMsg">
        <h2>All Messages</h2>
      </div>
      <div class="messageDisplay">
     
        <div class="title">      
            <h2>Message By <span><?php echo $fname, ' ', $lname ;?></span></h2>        
        </div>
       <div class="messageDisplayinfo">
        
           <label>First name</label>
                <h5><?php echo $fname; ?></h5>

                <label>Last name</label>
                <h5><?php echo $lname; ?></h5>

                <label>Email</label>
                <h5><?php echo $email; ?></h5>

                <label>Phone number</label>
                <h5><?php echo $phone; ?></h5>

                <label>Message</label>
                <p><?php echo $message; ?></p>
        </div>
  <form method="POST" class="btnstatut">
   <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
    <button type="submit" name="accept">Acceptable</button>
    <button type="submit" name="notAccepted">Unacceptable</button>
    <button type="submit" name="delete">Delete Message</button>
  </form>
    </div>
  </div>


    <div class="contentMsg">
          <div class="titleMsg">
            <h2>All Messages</h2>
          </div>
      <div class="barscroll">

      <?php
        include 'connectionDb.php';

        $stmt = $conn->prepare('SELECT `id`,`first_name`,`last_name`,`date`,`deleted` FROM `messages` ORDER BY `id` DESC');
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $mdg = "";
        
        if ($result->num_rows < 0) {
          $mdg = "No mEssage sending";
        };
       while($row = $result->fetch_assoc()) {
    
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $date = $row['date'];
        $deleted = $row['deleted'];

        if ($deleted === 1) {
          
          $msgStatu = '<p class="ms">Not Accepted</p>';
        } elseif($deleted === 0) {
          $msgStatu = '<p class="accepted">Accepted</p>';
              
        }else{
             $msgStatu = '<p class="comming">Comming</p>';
          
        }


        $date_object = new DateTime($date);
        $date_now = new DateTime();

        $date_now->setTime(0, 0); // Reset time to 00:00
        $date_object->setTime(0, 0); 

        if($date_now == $date_object) {
          $new = "new";
        }else{
            $new = $date_object->format('y/m/d');
           
        };
    

      ?>
  
        <div class="Msg">        
            <div class="iconMsg">
                <i class='bx bxs-message-dots'></i>
            </div>
            <div class="message">
           
                 <div class="infoMsg">
                     
                    <div class="fullname">
                      <span><?php echo $first_name; ?></span>
                      <span><?php echo $last_name; ?></span>
                    </div>
                    <div class="statutType"> 
                      <p><?php echo $msgStatu; ?></p>
                    </div>
                </div>
                
            
               
               <div class="dateMsg">
               <div class="datecreatMsg">
                     <span>Message Sended</span>
                    <h2><?php echo $new; ?></h2>
               </div>
                 <div class="btndisplayMsg">
               <!-- زر يحتوي على رابط إلى الصفحة نفسها مع تمرير الـ id -->
                    <a href="inbox.php?id=<?php echo $row['id']; ?>" class="btn">
                   <i class='bx bx-right-top-arrow-circle'></i>
               </a>
           </div>
               </div>
            </div>       
        </div>
    
    <?php

   }
   $conn->close();
    ?>

      </div>

    </div>
 </div>


<?php
//code for Totals messages accepted and not accepted
   include 'connectionDb.php';

    $stmt2 = $conn->prepare('SELECT COUNT(id) AS total FROM `messages`');
   $stmt2->execute();
   $result2 = $stmt2->get_result();

    if($result2){
      $row2 = $result2->fetch_assoc();
      $total = $row2['total'];
   }
//messages accepted
   $stmt = $conn->prepare('SELECT COUNT(id) AS Accepted  FROM `messages` WHERE `deleted` = 0');
   $stmt->execute();
   $result = $stmt->get_result();

   if($result){
    $row = $result->fetch_assoc();
    $Accepted = $row['Accepted'];
   }

//messages not accepted
   $stmt3 = $conn->prepare('SELECT COUNT(id) AS notAccepted FROM `messages` WHERE `deleted` = 1');
   $stmt3->execute();
   $result3 = $stmt3->get_result();

   if($result3){
    $row3 = $result3->fetch_assoc();
    $notAccepted = $row3['notAccepted'];
   }


?>

<div class="contentAnalyeses">
  <div class="titlecontentAnalyses">
      <h2>Analyeses All <span>Messages</span>  </h2>
      
  </div>
    <div class="conterVerify">
   
        <div class="box">
           <div class="statutbox">
                <h2>Messages acceptable</h2>
                <div class="data">
                    <span><?php echo $Accepted ; ?></span>
                    <p><?php echo '/' . $total; ?></p>
                </div>
           </div>

           <div class="iconStatut">
                <i class='bx bxs-message-check'></i>
           </div>
        </div>

        <div class="box">
           <div class="statutbox">
                <h2>Messages Not acceptable</h2>
             <div class="data">
                   <span><?php echo $notAccepted; ?></span>
                    <p><?php echo '/' . $total; ?></p>
             </div>
           </div>

            <div class="iconStatut">
                <i class='bx bxs-message-x'  ></i>
            </div>

        </div>

 <div class="chartMsg">
        <canvas id="myChart"></canvas>
    </div>

    
   <div class="chartMsg2">
        <canvas id="myChart2"></canvas>
    </div>
    </div>

   

</div>

 

 
</div>
<?php
// This code for chart: messages accepted 
include 'connectionDb.php';

$stmt = $conn->prepare('SELECT MONTH(date) AS months ,COUNT(id) AS sum FROM `messages` WHERE `deleted` = 0 GROUP BY MONTH(date)');
$stmt->execute();
$result = $stmt->get_result();

$messages = array_fill(1, 12, 0);
while ($row = $result->fetch_assoc()) {
    $messages[(int)$row['months']] = (int)$row['sum'];
}
$messages_json = json_encode(array_values($messages));

// This code for chart: messages not accepted 
$stmt2 = $conn->prepare('SELECT MONTH(date) AS months ,COUNT(id) AS sum FROM `messages` WHERE `deleted` = 1 GROUP BY MONTH(date)');
$stmt2->execute();
$result2 = $stmt2->get_result();

$messages2 = array_fill(1, 12, 0);
while ($row2 = $result2->fetch_assoc()) {
    $messages2[(int)$row2['months']] = (int)$row2['sum'];
    $totla = $row2['sum'];
}
$messages_json2 = json_encode(array_values($messages2));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label: 'Messages Accepted',
          data: <?php echo $messages_json; ?>,
          fill: false,
          borderColor: 'rgb(15, 139, 20)',
          tension: 0.1
        },
        {
          label: 'Messages Not Accepted',
          data: <?php echo $messages_json2; ?>,
          fill: false,
          borderColor: 'rgb(171, 26, 26)',
          tension: 0.1
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


 new Chart(ctx2, {

    type: 'doughnut',
    data: {
      labels: ['unacceptable','acceptable'],
     datasets: [
    {
     label: 'My First Dataset',
    data: [<?php echo $notAccepted; ?>,<?php echo $Accepted; ?>],
    backgroundColor: [
      'rgb(153, 4, 4)',
      'rgb(10, 154, 5)',
     
    ],
    hoverOffset: 4,
    borderColor:0,
    


       
    },
  
  ]

      
    },


    options: {
      scales: {
       responsive: true,
   
      y: {
        ticks: { color: 'green', beginAtZero: true }
      },
      x: {
        ticks: { color: 'red', beginAtZero: true }
      },

    },

  }
  
  
  });
</script>
</body>
</html>