<?php
// 
include("config.php");

$range = $_GET['range'] ?? 'today';
// if ($range == 'today') {
//     $date = date('Y-m-d');
//     $query = "SELECT SUM(grand_total) AS total_sales, DATE(invoice_date) AS date 
//               FROM invoice 
//               WHERE invoice_type = 'sales' AND DATE(invoice_date) = '$date' 
//               GROUP BY DATE(invoice_date)";
// } elseif ($range == 'yesterday') {
// }

if ($range == 'today') {
    $where = "DATE(invoice_date)";
}
elseif ($range == 'yesterday') {
}
elseif ($range == 'last7') {
}
elseif ($range == 'month') {
 
}
elseif ($range == 'year') {

}


$labels = [];
$salesMap = [];
$purchaseMap = [];




echo json_encode([
    'labels'   => $labels,
    'sales'    => "",
    'purchase' => ""
]);

?>



