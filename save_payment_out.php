<?php
include("config.php");

$customer_id    = $_POST['user_id'];
$payment_date   = $_POST['invoice_date'];
$payment_method = $_POST['payment_method'];
$bank_name      = $_POST['bank_name'] ?? '';
$cheque_no      = $_POST['cheque_no'] ?? '';


if (!empty($_POST['settlements'])) {
    foreach ($_POST['settlements'] as $invoice_id => $paid_amount) {
        // $prefix='plus'
        // echo "Invoice ID: $invoice_id<br>"; 

        if ($paid_amount <= 0) {
            continue;
        }

        $inv = "select grand_total,due_amount,paid_amount,payment_status from invoice where id='$invoice_id'";
        $exec = mysqli_query($conn, $inv);
        $fetch = mysqli_fetch_assoc($exec);

        $new_paid = $fetch['paid_amount'] + $paid_amount;
        $new_due  = $fetch['due_amount'] - $paid_amount;
        $payment_status = $fetch['payment_status'];

        if ($new_due <= 0) {
            $new_due = 0;
            $payment_status = 'Paid';
        } elseif ($new_due > 0) {
            $payment_status = 'Partialpaid';
        } else {
            $payment_status = 'pending';
        }

        // echo "$invoice_id , $paid_amount ,$new_paid ,$new_due,$payment_status";
        // exit();
        $query = mysqli_query($conn, "insert into payment(user_id,invoice_id,date,prefix,amount,payment_method,bank_name,cheque_no)
        values('$customer_id','$invoice_id','$payment_date','minus','$paid_amount','$payment_method','$bank_name','$cheque_no')");

        // $query2 = mysqli_query($conn, "update invoice set due_amount = due_amount-$paid_amount ,
        //                                paid_amount = paid_amount+$paid_amount 
        //                                where id='$invoice_id'");
        $query2 = mysqli_query($conn, "update invoice set due_amount =$new_due ,
                                       paid_amount = $new_paid , payment_status='$payment_status'
                                       where id='$invoice_id'");
    }
}
header("Location:payment_out.php");
exit();
?>
