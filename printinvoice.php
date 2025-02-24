<?php
include 'connectionDb.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $invoice_id = $_GET['id'];


    $stmt = $conn->prepare('SELECT * FROM `invoices` WHERE id = ?');
    $stmt->bind_param('i', $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
   
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Invoice not found");
    }
    $stmt->close();
} else {
    die("Invalid invoice ID");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="printinvoice.css?v=3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
</head>
<body>
    <?php include 'menu.php' ?>


<div class="content">   

    <div class="invoiceContent">
         <div class="navinvoice">

            <div class="informationsClient">
                <img src="profile.png" alt="">
                <h2><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></h2>
                <p><span>Phone number :</span> <?php echo $row['phone'] ?></p>
                <p><span>Email Address :</span><?php echo $row['email'] ?></p>
                <p><span>Contry :</span><?php echo $row['countries'] ?></p>              
            </div>
            <div class="informationsCompany">
                    <h2>Company Bn_Network</h2>
                    <p><span>phone Company : </span>0630829654</p>
                    <p><span>Email Address : </span>Bn_Network@gmail.com</p>
                    <p><span>Contry : </span>Morrocco</p>
            </div>
         </div>
            <div class="contentTable">
                <table>
                    <tr>
                        <th>Type Service</th>
                        <th>date debut</th>
                        <th>date fin</th>
                        <th>price</th>
                    </tr>

                    <tr>
                        <td><?php echo $row['typeWork'] ?></td>
                        <td><?php echo $row['date_debut'] ?></td>
                        <td><?php echo $row['date_fin'] ?></td>
                        <td><?php echo number_format(($row['price']),2) ?> Dh</td>
                    </tr>
                </table>
            </div>




          
  </div>
    <button onclick="printInvoice()">Print Invoice</button>
    
</div>
</body>

<script>

    function printInvoice() {
            var invoiceContent = document.querySelector('.invoiceContent').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = invoiceContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // لإعادة تحميل الصفحة بعد الطباعة
}
</script>
</html>