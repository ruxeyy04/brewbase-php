<?php 
session_start();
if(!isset($_SESSION['usertype'])) {
 echo "<script>window.location.replace('/login/')</script>";
}
if($_SESSION['usertype'] != "Admin") {
    echo "<script>window.location.replace('/login/')</script>";
}
include '../../server.php';
$sql = "SELECT a.order_id, a.order_date, a.status, b.fname as cfname, b.lname as clname, c.amount, COUNT(d.order_id) AS totalitems, e.fname, e.lname
FROM orders a
INNER JOIN person b
ON a.customer_id=b.id
INNER JOIN payment c
ON c.order_id=a.order_id
INNER JOIN orderdetail d
ON d.order_id=a.order_id
INNER JOIN person e
ON a.prepared_by=e.id
GROUP BY a.order_id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brew Base - Manage Order</title>
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
                <h1>Manage Order</h1>
                <p>Home / Admin / Transactions</p>
            </div>
        </div>
        </div>
<div class="container table-responsive" style="margin: 30px auto;">
        <table id="transactions" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Items Count</th>
                    <th>Prepared By</th>
                    <th>Action (Update Status)</th>

                </tr>
            </thead>
            <tbody>
              <?php 
                if(mysqli_num_rows($result)) {
                while($row = mysqli_fetch_assoc($result)) { $date = date_create($row['order_date']);?>
                <tr>
                    <td class="orderid"><?=$row['order_id']?></td>
                    <td><?=date_format($date,"F d, Y | h:i A")?></td>
                    <td><?=$row['status']?></td>
                    <td><?=$row['cfname']?> <?=$row['clname']?></td>
                    <td>₱<?=$row['amount']?></td>
                    <td><?=$row['totalitems']?></td>
                    <td><?=$row['fname']?> <?=$row['lname']?></td>
                    <td>
                    <select class="form-control status" <?=$row['status'] == "Cancelled" || $row['status'] == "Completed"? 'disabled' : '';?>>
                        <option value="Pending" <?=$row['status'] == "Pending" ? 'selected' : '';?>>Pending</option>
                        <option value="Order Confirmed" <?=$row['status'] == "Order Confirmed" ? 'selected' : '';?>>Order Confirmed</option>
                        <option value="On The Way" <?=$row['status'] == "On The Way" ? 'selected' : '';?>>On The Way</option>
                        <option value="To Receive" <?=$row['status'] == "To Receive" ? 'selected' : '';?>>Ready To Receive</option>
                    </select></td>
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
                <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Items Count</th>
                    <th>Prepared By</th>
                    <th>Action (Update Status)</th>
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
    $('#transactions').DataTable();
} );
$('.status').change(function () {
    var status = $(this).val();
    var orderid = $(this).closest('tr').find('.orderid').text()

    $.ajax({
        type: "POST",
        url: "process.php",
        data: {orderid: orderid, status: status},
        success :function() {
            location.reload();
        }
    })
})

</script>
</body>
</html>