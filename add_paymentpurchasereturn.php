<?php
include("config.php");
include("check_session.php");
$json = [];

if (isset($_POST['invoice_id'])) {

    $invoice_id = $_POST['invoice_id'];
    $query = "select paid_amount,due_amount,payment_status,invoice_date,user_id from invoice where id='$invoice_id'";
    $exec = mysqli_query($conn, $query);

    $invoice = mysqli_fetch_assoc($exec);
    // $user_id = $_POST['user_id'];
    $payment_method = $_POST['payment_method'] ?? '';
    $paid_amount = $_POST['paymentamount'];
    $current_due = $invoice['due_amount'];
    $current_paid = $invoice['paid_amount'];
    $payment_status = $invoice['payment_status'];
    $invoice_date = $invoice['invoice_date'];
    $user_id      = $invoice['user_id'];
    $bank_name = $_POST['bank_name'];
    $cheque_no = $_POST['cheque_no'];

    if ($payment_method === 'Bank') {
        if (empty($_POST['bank_name']) || empty($_POST['cheque_no'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Bank Name and Cheque Number are required for Bank payments'
            ]);
            exit;
        }
    }

    $new_paid = $current_paid + $paid_amount;
    $new_due = $current_due - $paid_amount;

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
    if ($paid_amount > $current_due) {
        echo json_encode(['status' => false, 'message' => 'Payment exceeds due amount']);
        exit;
    }

    $update_invoice_query = "update invoice 
                                set paid_amount = '$new_paid', 
                                 due_amount = '$new_due', 
                                 payment_status = '$new_status' 
                                 where id = '$invoice_id'";

    mysqli_query($conn, $update_invoice_query);
    $payment_date = date('Y-m-d H:i:s');

    $insert_payment_query = "INSERT INTO payment(user_id,invoice_id, date, prefix, amount, payment_method,bank_name,cheque_no)
                                 VALUES ('$user_id','$invoice_id', '$payment_date', 'plus', '$paid_amount', '$payment_method','$bank_name','$cheque_no')";

    $exec_insert = mysqli_query($conn, $insert_payment_query);
} else {
    echo "invalid data";
    exit();
}

header('Content-Type: application/json');

// echo json_encode([
//     'status' => true,
//     'message' => 'Payment saved successfully'
// ]);

echo json_encode([
    'status' => true,
    'invoice_id' => $invoice_id,
    'paid_amount' => $new_paid,
    'due_amount' => $new_due,
    'payment_status' => $new_status,
    'message'=>'payment saved successfully',
]);
