<?php
include("config.php");

$customer_id    = $_POST['user_id'];
$payment_date   = $_POST['invoice_date'];
$payment_method = $_POST['payment_method'];
$bank_name      = $_POST['bank_name'] ?? '';
$cheque_no      = $_POST['cheque_no'] ?? '';
$total_amount = $_POST['rate'];

$balance = mysqli_query($conn, "select sum(unused_amount) as balance from payment where user_id='$customer_id'");
$balance_row = mysqli_fetch_assoc($balance);
$unused_balance = $balance_row['balance'];
$total_unused = $total_amount + $unused_balance;

if (!empty($_POST['settlements'])) {
    mysqli_query($conn, "update payment set unused_amount = 0 where user_id = '$customer_id'
    ");
    foreach ($_POST['settlements'] as $invoice_id => $paid_amount) {
        // $prefix='plus'
        // echo "Invoice ID: $invoice_id<br>"; 

        if ($paid_amount <= 0) {
            continue;
        }

        $inv = "select grand_total,due_amount,paid_amount,payment_status from invoice where id='$invoice_id'";
        $exec = mysqli_query($conn, $inv);
        $fetch = mysqli_fetch_assoc($exec);

        if ($total_unused >= $fetch['due_amount']) {
            $paid_amount = $fetch['due_amount'];
        } else {
            $paid_amount = $total_unused;
        }

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

        // $settled_amount = $settled_amount + $paid_amount;

        // echo "$invoice_id , $paid_amount ,$new_paid ,$new_due,$payment_status,$settled_amount";
        // exit;

        $query = mysqli_query($conn, "insert into payment(user_id,invoice_id,date,prefix,amount,payment_method,bank_name,cheque_no)
        values('$customer_id','$invoice_id','$payment_date','plus','$paid_amount','$payment_method','$bank_name','$cheque_no')");

        $last_payment_id = mysqli_insert_id($conn);

        $query2 = mysqli_query($conn, "update invoice set due_amount =$new_due ,
                                       paid_amount = $new_paid , payment_status='$payment_status'
                                       where id='$invoice_id'");

        $total_unused = $total_unused - $paid_amount;
        // $settled_amount = $settled_amount + $paid_amount;
    }

    if ($total_unused > 0) {
        mysqli_query($conn, "update payment set unused_amount='$total_unused' where id='$last_payment_id'");
    }
}

header("Location:payment_in.php");
exit();
