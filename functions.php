<?php
include("config.php");
function updateStockQty($product_id, $qty, $type)
{
    global $conn;
    $checkstockentry = "select * from stock where product_id=$product_id";
    $exec = mysqli_query($conn, $checkstockentry);
    $count = mysqli_num_rows($exec);
    if ($count == 0) {
        mysqli_query($conn, "insert into stock (product_id,qty) values ($product_id,$qty)");
    } else {
        if ($type === 'purchase') {
            mysqli_query(
                $conn,
                "UPDATE stock 
             SET qty = qty + $qty 
             WHERE product_id = '$product_id'"
            );
        }
        if ($type === 'purchase_reverse') {
            mysqli_query($conn, "
            UPDATE stock 
            SET qty = qty - $qty 
            WHERE product_id = '$product_id'
        ");
        }
        if ($type === 'purchase_return') {
            mysqli_query($conn, "
            UPDATE stock 
            SET qty = qty - $qty 
            WHERE product_id = '$product_id'
        ");
        }
        if ($type === 'sales') {
            mysqli_query(
                $conn,
                "UPDATE stock 
             SET qty = qty - $qty 
             WHERE product_id = '$product_id'"
            );
        }
        if ($type === 'sales_reverse') {
            mysqli_query(
                $conn,
                "UPDATE stock 
             SET qty = qty + $qty 
             WHERE product_id = '$product_id'"
            );
        }
        if ($type === 'sales_return') {
            mysqli_query(
                $conn,
                "UPDATE stock 
             SET qty = qty + $qty 
             WHERE product_id = '$product_id'"
            );
        }
    }
}

function updatePayment($invoice_id, $paid_amount, $payment_method, $bank_name, $cheque_no, $type)
{
    global $conn;
    $query = "select paid_amount,due_amount,payment_status,invoice_date,user_id from invoice where id='$invoice_id'";
    $exec = mysqli_query($conn, $query);
    $count = mysqli_num_rows($exec);

    $invoice = mysqli_fetch_assoc($exec);
    $current_paid = $invoice['paid_amount'];
    $current_due = $invoice['due_amount'];
    $payment_status = $invoice['payment_status'];
    $invoice_date = $invoice['invoice_date'];
    $user_id      = $invoice['user_id'];


    if ($type === 'sales' || $type === 'purchasereturn') {

        $new_paid = $current_paid + $paid_amount;
        $new_due = $current_due - $paid_amount;

        if ($new_paid == 0) {
            return;
        }

        if ($new_due <= 0) {
            $new_due = 0;
            $new_status = 'Paid';
        } elseif ($new_due > 0 && $new_paid > 0) {
            $new_status = 'Partialpaid';
        } else {
            $new_status = 'pending';
        }

        // echo $new_status;
        // echo $new_due;
        // echo $new_paid;
        // exit();

        $update_invoice_query = "update invoice 
                                set paid_amount = '$new_paid', 
                                 due_amount = '$new_due', 
                                 payment_status = '$new_status' 
                                 where id = '$invoice_id'";

        mysqli_query($conn, $update_invoice_query);

        // echo $new_status;

        $payment_date = date('Y-m-d H:i:s');
        // $bank_name='';
        // $cheque_no='';
        $insert_payment_query = "INSERT INTO payment(user_id,invoice_id, date, prefix, amount, payment_method,bank_name,cheque_no)
                                VALUES ('$user_id','$invoice_id', '$payment_date', 'plus', '$paid_amount', '$payment_method','$bank_name','$cheque_no')";

        $exec_insert = mysqli_query($conn, $insert_payment_query);
    } elseif ($type === 'purchase' || $type === 'salesreturn') {
        // if ($current_paid == 0) {
        //     return;
        // }
        $new_paid = $current_paid + $paid_amount;
        $new_due = $current_due - $paid_amount;

        if ($new_paid == 0) {
            return;
        }
        if ($new_due <= 0) {
            $new_due = 0;
            $new_status = 'Paid';
        }
        // } else {
        //     $new_status = 'Partially Paid';
        // }
        elseif ($new_due > 0 && $new_paid > 0) {
            $new_status = 'Partialpaid';
        } else {
            $new_status = 'pending';
        }

        // echo $new_status;

        $update_invoice_query = "update invoice 
                                set paid_amount = '$new_paid', 
                                 due_amount = '$new_due', 
                                 payment_status = '$new_status' 
                                 where id = '$invoice_id'";

        mysqli_query($conn, $update_invoice_query);

        // echo $new_status;

        $payment_date = date('Y-m-d H:i:s');
        $insert_payment_query = "INSERT INTO payment(user_id,invoice_id, date, prefix, amount, payment_method,bank_name,cheque_no)
                                VALUES ('$user_id','$invoice_id', '$payment_date', 'minus', '$paid_amount', '$payment_method','$bank_name','$cheque_no')";

        $exec_insert = mysqli_query($conn, $insert_payment_query);
    }
}
