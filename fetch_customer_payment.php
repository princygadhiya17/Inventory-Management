<?php
include("config.php");

$user_id = $_POST['user_id'] ?? 0;

$invoices = [];

$sql = "select invoice_no, invoice_date, grand_total,due_amount,id from invoice 
        where user_id = '$user_id' and invoice_type='sales' and due_amount!=0";
$q = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($q)) {
    $invoices[] = $row;
}

echo json_encode([
    'invoices' => $invoices
]);
exit;   
?>