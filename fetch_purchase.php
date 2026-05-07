<?php
include("config.php");

$invoice_no = $_POST['invoice_no'] ?? '';

$q = mysqli_query(
    $conn,
    "select i.id,i.invoice_no, i.user_id, u.user_name,i.items_json,i.sub_total,i.discount,i.grand_total
     from invoice i
     left join users u ON u.id = i.user_id
     where i.invoice_no = '$invoice_no' and i.invoice_type='purchase'"
);

$data = mysqli_fetch_assoc($q);
$data['items'] = json_decode($data['items_json'], true);

echo json_encode($data);
?>
