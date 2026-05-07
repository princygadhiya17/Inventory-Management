<?php
include("config.php");
include("functions.php");
if (isset($_POST)) {

    $invoice_id = $_POST['invoice_id'];
    $invoice_no = $_POST['invoice_no'];
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
    $invoice_date = $_POST['invoice_date'];
    $invoice_type = $_POST['invoice_type'];
    // $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    $sub_total = 0;
    $discount = $_POST['discount'];
    $grand_total = 0;
    $due_amount = 0;
    $rate = $_POST['rate'];
    $shipping_address = $_POST['shipping_address'];
    // $unit_id=$_POST['unit_id'];

    if (isset($_POST['invoice_id']) && $_POST['invoice_id'] != 0) {

        mysqli_query($conn, "UPDATE invoice SET 
        invoice_no='$invoice_no',
        user_id='$user_id',
        invoice_date='$invoice_date',
        shipping_address='$shipping_address',
        discount='$discount'
        WHERE id='$invoice_id'");

        //old stock stock table mate
        $oldItems = mysqli_query($conn, "
        select product_id, qty 
        from invoice_details 
        where invoice_id = '$invoice_id'");
        // while ($row = mysqli_fetch_assoc($oldItems)) {
        //     updateStockQty($conn, $row['product_id'], $row['qty'], 'sales'); //pacho stock add 
        // }

        while ($row = mysqli_fetch_assoc($oldItems)) {
            updateStockQty($row['product_id'], $row['qty'], 'sales_reverse'); //pacho stock add 

            //stock pacho ave etle in 
            mysqli_query($conn, "
        insert into stock_history(product_id, any_id, any_type,qty, prefix, date)
        values('{$row['product_id']}', '$invoice_id', 'sales_reverse','{$row['qty']}','in', '$invoice_date') ");
        }

        // DELETE 

        mysqli_query($conn, "DELETE FROM invoice_details WHERE invoice_id='$invoice_id'");
        // if (isset($_POST['product_id'])) 
        if (!empty($_POST['product_id'])) {
            $grand_total = 0;
            foreach ($_POST['product_id'] as $k => $pid) {
                if ($pid == "") continue;

                $unit_id = isset($_POST['unit_id'][$k]) ? $_POST['unit_id'][$k] : 0;
                $qty     = isset($_POST['quantity'][$k]) ? $_POST['quantity'][$k] : 0;
                $rate    = isset($_POST['rate'][$k]) ? $_POST['rate'][$k] : 0;
                $total = $qty * $rate;
                $subtotal += $total;
                // $grand_total+=$total;
                mysqli_query($conn, "INSERT INTO invoice_details 
                (invoice_id, product_id, unit_id, qty, rate, total_price)
                VALUES ('$invoice_id','$pid','$unit_id','$qty','$rate','$total')");

                updateStockQty(
                    $pid,
                    $qty,
                    'sales'   // edit sales ma pacho -
                );
                // stock history ma add as out 
                mysqli_query($conn, "insert into stock_history(product_id, any_id,any_type,qty,prefix, date)
                                    values('$pid', '$invoice_id','sales','$qty','out', '$invoice_date')");
            }
        }
        // $final_grand_total=$grand_total-$discount;
        $grand_total = $subtotal - $discount;
        $due_amount  = $grand_total;
        mysqli_query($conn, "UPDATE invoice SET
            sub_total='$subtotal',
            grand_total='$grand_total',
            due_amount='$due_amount'
            WHERE id='$invoice_id'
        ");
        //update grand total to invoice table

        $paid_amount = $_POST['paid_amount'] ?? 0;
        $payment_method = $_POST['payment_method'] ?? null;
        $res = mysqli_query($conn, "SELECT due_amount FROM invoice WHERE id='$invoice_id'");
        $row = mysqli_fetch_assoc($res);

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

        updatePayment($invoice_id, $paid_amount, $payment_method, $bank_name, $cheque_no,'sales');
    } else {
        
        // $sub_total = 0;
        // $grand_total = 0;

        $sql = "INSERT INTO invoice(invoice_no,user_id,invoice_date,invoice_type,shipping_address,sub_total,discount,grand_total,due_amount)
          VALUES('$invoice_no','$user_id','$invoice_date','$invoice_type','$shipping_address','$sub_total','$discount','$grand_total','$due_amount')";

        $exec = mysqli_query($conn, $sql);

        $invoice_id = mysqli_insert_id($conn);
        foreach ($_POST['product_id'] as $key => $productID) {

            $unit_id = isset($_POST['unit_id'][$key]) ? $_POST['unit_id'][$key] : 0;
            $qty     = isset($_POST['quantity'][$key]) ? $_POST['quantity'][$key] : 0;
            $rate    = isset($_POST['rate'][$key]) ? $_POST['rate'][$key] : 0;

            $total_price = $qty * $rate;
            $sub_total += $total_price;

            $sql_details = "INSERT INTO invoice_details (invoice_id,product_id,unit_id,qty,rate,total_price)
            VALUES ('$invoice_id','$productID','$unit_id','$qty','$rate','$total_price')";

            mysqli_query($conn, $sql_details);

            updateStockQty(
                $productID,
                $qty,
                'sales'   // sales vadu subtract stock
            );
            //stock_history ma add as out 
            mysqli_query($conn, "insert into stock_history(product_id, any_id, any_type,qty, prefix, date)
                                values('$productID', '$invoice_id', 'sales','$qty','out', '$invoice_date')");
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


        // $res = mysqli_query($conn, "SELECT due_amount FROM invoice WHERE id='$invoice_id'");
        // $row = mysqli_fetch_assoc($res);

        // if ($paid_amount > $row['due_amount']) {
        //     echo "<script>
        // alert('Payments exceed due amount');
        // window.location.href='add_sales.php';
        // </script>";
        //     exit(); 
        // }

        //payent
        // if($_POST['paid_amount']!=0){
        // updatePayment($invoice_id, $paid_amount, $payment_method);
        // };
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
    
        updatePayment($invoice_id, $paid_amount, $payment_method, $bank_name, $cheque_no, 'sales');
    }
    header("Location: sales.php?alert=success&msg=Invoice $msg Success");
    exit();
}
