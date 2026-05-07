<?php
include("config.php");
$query = "insert into stock(product_id,qty)
        SELECT p.id, 0
        FROM products p
        LEFT JOIN stock s ON s.product_id = p.id
        WHERE s.product_id IS NULL";

if (mysqli_query($conn, $query)) {
    echo "Stock tabal updated successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>