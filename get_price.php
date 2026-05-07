<?php
include("config.php");
header('Content-Type: application/json');
$json = [];
$id = $_POST['product_id'];

$q = mysqli_query($conn, "SELECT sales_price,purchase_price FROM products WHERE id='$id'");
$row = mysqli_fetch_assoc($q);

$json['purchase_price'] = $row['purchase_price'];
$json['sales_price'] = $row['sales_price'];
echo json_encode($json);
exit;
?>