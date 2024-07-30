<?php 
session_start();
if(!isset($_SESSION['usertype'])) {
 echo "<script>window.location.replace('/login/')</script>";
}
if($_SESSION['usertype'] != "Admin") {
    echo "<script>window.location.replace('/login/')</script>";
}
include '../../server.php';
$sql = "SELECT a.*, b.order_id, b.status, c.fname, c.lname
FROM payment a
INNER JOIN orders b
ON a.order_id=b.order_id
INNER JOIN person c
ON a.customer_id=c.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - Admin - Transactions</title>
    <link rel="icon" type="image/x-icon" href="/img/brewbase.ico">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap.min.css">
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/admin/styleadmin.css">

</head>
<body class="bg-color">
    <?php require_once '../../navigation.php'?>
    <div class="header-sub">
        <div class="content-text">
            <div class="text">
                <h1>Transactions</h1>
                <p>Home / Admin / Transactions</p>
            </div>
        </div>
        </div>
<div class="container table-responsive" style="margin: 30px auto;">
        <table id="transactions" class="table table-hover table-bordered" style="width:90%; margin:auto;">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Customer Name</th>
                    <th>Payment Method</th>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result)) {
                while($row = mysqli_fetch_assoc($result)) { $date = date_create($row['payment_date']);?>
                <tr>
                    <td><?=$row['pay_id']?></td>
                    <td><?=$row['fname']?> <?=$row['lname']?></td>              
                    <td><?=$row['payment_method']?></td>
                    <td><?=$row['order_id']?></td>
                    <td><?=$row['status']?></td>
                    <td><?=date_format($date,"F d, Y | h:i A")?></td>
                    <td>₱<?=$row['status'] == "Cancelled" ? '0.00' : $row['amount'];?></td>
                </tr>
                <?php 
                }
            } else {
                echo "<td colspan=7>No Transaction Yet</td>";
            }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total: </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php require_once '../../footer.php'?>
<!--Javascript for bootstrap-->

<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/jquery.slicknav.min.js"></script>
<script src="/js/jquery.countTo.min.js"></script>
<script src="/js/jquery.shuffle.min.js"></script>
<script src="/js/script.js"></script>
<script>
$(document).ready(function() {
    $('#transactions').DataTable({
        dom: '<"top">rt<"bottom"lfp><"clear">',
        footerCallback: function(row, data, start, end, display) {
            var api = this.api(), data;

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\₱]/g, '')*1 :
                    typeof i === 'number' ?
                    i : 0;
            };
            //total over all pages
            total = api
                .column(6)
                .data()
                .reduce(function (a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            pageTotal = api
                .column(6, {page: 'current'})
                .data()
                .reduce(function (a,b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(6).footer()).html(
                '₱ '+pageTotal + ' (₱ ' + total + ' total)'
            );
        }
    });
});
</script>
</body>
</html>