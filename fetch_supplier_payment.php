<?php
include("config.php");

$user_id=$_POST['user_id'] ?? 0;
$invoices=[];
$query=mysqli_query($conn,"select invoice_no,invoice_date,grand_total,due_amount,id from invoice where user_id='$user_id' and invoice_type='purchase'");
while($row=mysqli_fetch_assoc($query)){
    $invoices[]=$row;
}
echo json_encode([
    'invoices'=>$invoices
]);

?>