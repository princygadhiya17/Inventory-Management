<?php
include("config.php");

$id = $_POST['id'];

// invoice ane users
$payment = mysqli_query($conn, "
    select i.*, u.user_name 
    from invoice i
    left join users u ON i.user_id = u.id
    where i.id='$id'
");
$fetch_payment = mysqli_fetch_assoc($payment);
// $row=[];
$payment1 = mysqli_query($conn, "
    select i.*,p.date ,p.amount,p.payment_method,p.bank_name,p.cheque_no
    from invoice i
    left join payment p ON p.invoice_id=i.id
    where i.id='$id'
");
?>
<html>

<body>
    <div class="container-fluid">
        <!-- <h4>Payment Details</h4> -->

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="font-weight-bold">Invoice Number :</label>
                <p><?= $fetch_payment['invoice_no'] ?></p>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Payment Status :</label>
                <p><?php echo $fetch_payment['payment_status']; ?></p>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Customer Name :</label>
                <p><?php echo $fetch_payment['user_name']; ?></p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" text-align="center">
                <thead>
                    <th>Payment Mode</th>
                    <th>Bank Name</th>
                    <th>Cheque No</th>
                    <th>Payment Date</th>
                    <th>Amount Paid</th>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($payment1)) { ?>
                        <tr text-align="center">
                            <td><?php echo $row['payment_method']; ?></td>
                            <td><?php echo $row['bank_name']; ?></td>
                            <td><?php echo $row['cheque_no']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>