<?php
include("config.php");
include("functions.php");

$items_json = isset($_POST['items_json']) ? $_POST['items_json'] : '[]';
$items = json_decode($_POST['items_json'], true);
$invoice_id = $_POST['invoice_id'] ?? '';

$invoice_no   = $_POST['invoice_no'];
$user_id      = $_POST['user_id'];
$invoice_date = $_POST['invoice_date'];
$invoice_type = $_POST['invoice_type'];
$shipping_address = $_POST['shipping_address'];
$discount     = isset($_POST['discount']) ? $_POST['discount'] : 0;
if ($discount == '') {
    $discount = 0;
}

$sub_total = 0;
$grand_total = 0;
$due_amount = 0;

mysqli_query($conn, "
    INSERT INTO invoice
    (invoice_no, user_id, invoice_date, invoice_type, shipping_address, sub_total, discount, grand_total, due_amount,items_json)
    VALUES
    ('$invoice_no','$user_id','$invoice_date','$invoice_type','$shipping_address',0,'$discount',0,0,'" . $_POST['items_json'] . "')
");

$invoice_id = mysqli_insert_id($conn);
foreach ($items as $item) {
    $product_id = $item['product_id'];
    $unit_id    = $item['unit_id'];
    $qty        = $item['qty'];
    $rate       = $item['rate'];

    $total_price = $qty * $rate;
    $sub_total += $total_price;
    $result = mysqli_query($conn, "
        insert into invoice_details
        (invoice_id, product_id, unit_id, qty, rate, total_price)
        VALUES ('$invoice_id','$product_id','$unit_id','$qty','$rate','$total_price')");

    updateStockQty($product_id, $qty, 'purchase_return');

    mysqli_query($conn, "INSERT INTO stock_history(product_id, any_id, any_type ,qty, prefix, date)
                     VALUES('$product_id', '$invoice_id', 'purchasereturn','$qty', 'out', '$invoice_date')");
}

$grand_total = $sub_total - $discount;
$due_amount  = $grand_total;

mysqli_query($conn, "
    UPDATE invoice SET
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

updatePayment($invoice_id, $paid_amount, $payment_method, $bank_name, $cheque_no, 'purchasereturn');
// echo $items_json;
// exit();
header("Location: purchase_return.php?alert=success&msg=Sales_return $msg Success");
exit();
?>
