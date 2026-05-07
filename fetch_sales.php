<?php
include("config.php");

$invoice_no = $_POST['invoice_no'] ?? '';
$response = [];
if ($invoice_no != '') {
    $sql = "
    select i.id, i.invoice_no, i.user_id,i.invoice_date,i.discount , u.user_name from invoice i
    left join users u ON u.id = i.user_id
    where i.invoice_no = '$invoice_no' and i.invoice_type='sales'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $sale = mysqli_fetch_assoc($result);

        $items_sql = "
    select d.product_id, p.name, d.qty, d.rate,d.unit_id,
           (d.qty * d.rate) as subtotal
    from invoice_details d
    join products p ON p.id = d.product_id
    where d.invoice_id = '{$sale['id']}'";

        $items_res = mysqli_query($conn, $items_sql);

        $items = [];
        $subtotal = 0;

        while ($row = mysqli_fetch_assoc($items_res)) {
            $items[] = $row;
            $subtotal += $row['subtotal'];
        }

        $response = [
            'invoice_id' => $sale['id'],
            'customer_id' => $sale['user_id'],
            'customer_name' => $sale['user_name'],
            'invoice_date' => $sale['invoice_date'],
            'discount'      => $sale['discount'],
            'items' => $items,
            'subtotal' => $subtotal,
        ];
    }
}

echo json_encode($response);
?>
