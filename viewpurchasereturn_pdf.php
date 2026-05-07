<?php
include("config.php");
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$id = $_GET['id'] ?? 0;


$invoice_q = mysqli_query($conn, "
    select i.*, u.user_name,u.user_mobile,u.email
    from invoice i
    left join users u on i.user_id = u.id
    where i.id='$id' and i.invoice_type='purchasereturn'");
$invoice = mysqli_fetch_assoc($invoice_q);

$items = mysqli_query($conn, "
    select d.*,  p.name as product_name, p.description ,d.rate ,u.name as unit_name , i.discount
    from invoice_details d
    left join invoice i on d.invoice_id = i.id
    left join products p on d.product_id = p.id
    left join units u on d.unit_id = u.id
    WHERE d.invoice_id='$id'
");

$invoiceNo = $invoice['invoice_no'];
$date = date("d/m/Y", strtotime($invoice['invoice_date']));
$customer = $invoice['user_name'];
$phone = $invoice['user_mobile'];
$email = $invoice['email'];
$customerAddress = $invoice['shipping_address'];
$total = $invoice['grand_total'];
$sub_total = $invoice['sub_total'];
$discount = $invoice['discount'];

$itemRows = '';

while ($row = mysqli_fetch_assoc($items)) {
    $subtotal = $row['qty'] * $row['rate'];
    $itemRows .= "
        <tr>
             <td>{$row['product_name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['qty']}</td>
            <td>{$row['rate']}</td>
            <td>$subtotal</td>
        </tr>
    ";
}

$html = "

<style>
body { 
font-size: 15px; 
color: black; 
}

.invoice {
 padding: 20px;
 }

.row {
 width: 100%; 
 display: table; 
 }

.col {
 display: table-cell;
 vertical-align: top;
 }

.text-right {
 text-align: right;
 }

table {
 width: 100%;
border-collapse: collapse;
margin-top: 15px;
border-bottom: 1px solid lightblue;
}

th { 
background: lightblue; 
 padding: 8px; 
 }

td {
text-align:center;
 padding: 8px; 
}
.invoice-head{
color:#1a73e8;
font-weight:bold;
font-size:20px;
text-decoration:underline;
}
.total-table td {
    border-bottom: 1px solid lightblue;
    width: 10%;
    padding: 10px;
}
.totals{
background-color:lightblue;
}
.abc{
padding:10px;
}
.xyz{
padding:5px;
background-color:lightblue;
}

</style>
</head>
<body>
<div class='invoice'>
<div class='row'>
    <div class='col'>
        <h2>Admin, Inc.</h2>
        <small>795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: admin@example.com</small>
    </div>
    <div class='col text-right'>
        <h4 class='invoice-head'><b>Invoice</b></h4>
        <b>Invoice #:</b> $invoiceNo<br>
        <b>Date:</b> $date
    </div>
</div>

<hr>

<div class='row xyz'>
    <div class='col'>
        <strong>Supplier : </strong>
    </div>
</div>
<div class='row'>
    <div class='col'>
    <p>$customer<br>$customerAddress<br>phone:$phone<br>Email:$email</p>
    </div>
</div>

<table>
<tr>
    <th>Product Name</th>
    <th>Description</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Subtotal</th>
</tr>
<tbody>
$itemRows
</tbody>
</table>

<table class='total-table' align='right' width='40%' style='margin-top:30px'>
<tr>
<td class='text-right'>Subtotal : </td>
<td class='text-right'><strong>$sub_total</strong></td>
</tr>
<tr>
<td class='text-right'>Discount : </td>
<td class='text-right'><strong>$discount</strong></td>
</tr>
<tr>
<td class='text-right totals'>Grandtotal : </td>
 <td class='text-right totals'><strong>$total</strong></td>
</tr>


</table>
<!--
<div class='row text-right abc'>
<div class='col-md-6'>
<div><strong>Subtotal : $sub_total</strong></div>
</div>
</div>
<div class='row text-right abc'>
<div class='col-md-6'>
<div><strong>Discount : $discount</strong></div>
</div>
<div class='row text-right abc'>
<div class='col-md-6'>
<div><strong>Grandtotal : $total</strong></div>
</div>
</div>
-->
</div>
</body>
</html>
";

// 6️⃣ Generate PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice_$invoiceNo.pdf", ["Attachment" => false]);
