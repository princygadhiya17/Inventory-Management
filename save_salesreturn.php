<?php
include("config.php");
include("functions.php");
if (isset($_POST)) {

    // $invoice_id = $_POST['invoice_id'];
    $invoice_no = $_POST['invoice_no'] ?? '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
    $invoice_date = $_POST['invoice_date'];
    $invoice_type = $_POST['invoice_type'];
    // $qty = $_POST['qty'];
    $sub_total = 0;
    $grand_total = 0;
    $due_amount = 0;
    // $rate = $_POST['rate'];
    $discount = $_POST['discount'] ?? 0;
    $shipping_address = $_POST['shipping_address'];

    $sql = "INSERT INTO invoice(invoice_no,user_id,invoice_date,invoice_type,shipping_address,sub_total,discount,grand_total,due_amount)
          VALUES('$invoice_no','$user_id','$invoice_date','$invoice_type','$shipping_address','$sub_total','$discount','$grand_total','$due_amount')";

    $exec = mysqli_query($conn, $sql);

    $invoice_id = mysqli_insert_id($conn);
    foreach ($_POST['product_id'] as $key => $productID) {

        $unit_id = isset($_POST['unit_id'][$key]) ? $_POST['unit_id'][$key] : 0;
        $qty     = isset($_POST['qty'][$key]) ? $_POST['qty'][$key] : 0;
        $rate    = isset($_POST['rate'][$key]) ? $_POST['rate'][$key] : 0;

        // $sub_total=0;
        $total_price = $qty * $rate;
        $sub_total += $total_price;
        // echo "qty=$qty rate=$rate total=$total_price<br>";
        // // exit;

        $sql_details = "INSERT INTO invoice_details (invoice_id,product_id,unit_id,qty,rate,total_price)
            VALUES ('$invoice_id','$productID','$unit_id','$qty','$rate','$total_price')";

        mysqli_query($conn, $sql_details);
        updateStockQty(
            $productID,
            $qty,
            'sales_return'   // sales vadu subtract stock
        );
        //stock_history ma add as out 
        mysqli_query($conn, "insert into stock_history(product_id, any_id, any_type,qty, prefix, date)
                                values('$productID', '$invoice_id', 'salesreturn','$qty','in', '$invoice_date')");
    }

    // Calculate totals
    $grand_total = $sub_total - $discount;
    $due_amount  = $grand_total;

    // Update totals
    mysqli_query($conn, "UPDATE invoice SET
            sub_total='$sub_total',
            grand_total='$grand_total',
            due_amount='$due_amount'
            WHERE id='$invoice_id'
        ");

    $paid_amount = $_POST['paid_amount'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? null;
    $bank_name = $_POST['bank_name'] ?? null;
    $cheque_no = $_POST['cheque_no'] ?? 0;
    $res = mysqli_query($conn, "SELECT due_amount FROM invoice WHERE id='$invoice_id'");
    $row = mysqli_fetch_assoc($res);

    if ($payment_method == 'bank') {
        if (empty($bank_name) || empty($cheque_no)) {
            echo "<script>
                alert('enter valid bank name and cheque no!');
                window.history.back();  
              </script>";
            exit();
        }
    }

    if ($paid_amount < 0) {
        echo "<script>
                alert('enter valid paid amount!');
                window.history.back();  
              </script>";
        exit();
    }

    if ($paid_amount > $row['due_amount']) {
        // header("Location: add_sales.php?alert=danger&msg=Paid amount exceeds due amount");
        // exit();
        echo "<script>
                alert('Paid amount exceeds the due amount!');
                window.history.back();  
              </script>";
        exit();
    }

    updatePayment($invoice_id, $paid_amount, $payment_method, $bank_name, $cheque_no, 'salesreturn');
}
header("Location: sales_return.php?alert=success&msg=Sales_return $msg Success");
exit();
