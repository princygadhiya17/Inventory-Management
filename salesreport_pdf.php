<?php
include("config.php");
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

$html = '';
$html .= '
<style>
.invoice-header {
        width:100%;
        border-bottom:2px solid black;
        padding-bottom:10px;
        margin-bottom:15px;
    }
    .company-title {
        font-size:28px;
        color:#1a73e8;
        font-weight:bold;
        font-size:30px;

     }
    .from-box {
        padding:10px;
        font-size: 15px;
    }
    table.invoice-table {
        width:100%;
        margin-top:15px;
        font-size:15px;
    }
    table.invoice-table th {
        background-color:#1a73e8;
        color:#ffffff;
        text-align:center;
        padding:8px; 
    }
    table.invoice-table td {
        padding:7px;
        text-align:center;
    }
.watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 100px;
    color: #999;
    opacity: 0.25;
    z-index: -1000;
    white-space: nowrap;
}
</style>
<div class="invoice-header">
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="company-title">Sales Invoice</div>
            </td>
            <td width="50%" align="right">
                <div class="from-box">
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: admin@example.com
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="watermark">Sales Report</div>


<table class="invoice-table">
    <thead>
        <tr>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
';

$invoices = mysqli_query($conn, "
    SELECT i.*, u.user_name
    FROM invoice i
    LEFT JOIN users u ON i.user_id = u.id
    WHERE i.invoice_type = 'purchase'
");

while ($row = mysqli_fetch_assoc($invoices)) {
    $html .= '<tr  align="center">
            <td>' . $row['invoice_no'] . '</td>
            <td>' . $row['invoice_date'] . '</td>
            <td>' . $row['user_name'] . '</td>
            <td>' . $row['grand_total'] . '</td>
            <td>' . $row['paid_amount'] . '</td>
            <td>' . $row['due_amount'] . '</td>
            <td>' . $row['payment_status'] . '</td>            
        </tr>';
}

$html .= '</tbody></table>';
// Load HTML content 
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF 
$dompdf->render();

// Output the generated PDF to Browser 
$dompdf->stream();
