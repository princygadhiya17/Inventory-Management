<?php
include("config.php");

// Excel file name for download 
$filename = "salesreturn_data" . date('Y-m-d') . ".xls";

// Column names  
$fields = array('invoice_no', 'invoice_date', 'user_name', 'grand_total', 'paid_amount', 'due_amount', 'payment_status');

// Display column names as first row  
$excelData = implode("\t", array_values($fields)) . "\n";

// Query to fetch records from database  
$sql = "select i.*, u.user_name 
              from invoice i
              left join users u on i.user_id = u.id
              where i.invoice_type='salesreturn'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $lineData = array($row['invoice_no'], $row['invoice_date'], $row['user_name'], $row['grand_total'], $row['paid_amount'], $row['due_amount'], $row['payment_status'] );
    $excelData .= implode("\t", array_values($lineData)) . "\n";
}
// Headers for download  
header("Content-Type: application/vnd.ms-excel");  
header("Content-Disposition: attachment; filename=\"$filename\"");  

// Render excel data  
echo $excelData;  

exit; 

?>
