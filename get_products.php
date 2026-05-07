<?php
include("config.php");
header('Content-Type: application/json');
$json = [];
if (isset($_REQUEST['cat_id'])) {

    $category_id = $_REQUEST['cat_id'];

    $query = mysqli_query($conn, "SELECT id, name FROM products WHERE cat_id='$category_id'");

    $products = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $products[] = $row;
    }
    $json['data'] = $products;
    echo json_encode($json);
    exit;
}
?>

