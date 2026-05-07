<?php
include("config.php");
require_once('TCPDF-main/tcpdf.php');

class MyCustomPDFWithWatermark extends TCPDF
{
    public function Header()
    {
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto page break
        $this->SetAutoPageBreak(false, 0);


        $this->SetAlpha(0.4); // transparency (0 = invisible, 1 = solid)

        $this->SetFont('helvetica', 'B', 50);
        $this->SetTextColor(150, 150, 150);

        // Rotate text
        $this->StartTransform();
        $this->Rotate(45, $this->getPageWidth() / 2, $this->getPageHeight() / 2);

        // Position text at center
        $this->Text(
            ($this->getPageWidth() / 2) - 90,
            ($this->getPageHeight() / 2),
            'Purchase Invoice'
        );

        $this->StopTransform();

        // Reset styles
        $this->SetAlpha(1);
        $this->SetTextColor(0, 0, 0);

        // Restore auto page break
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();
    }
}


// create new PDF document
$pdf = new  MyCustomPDFWithWatermark(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

/* Write HTML */
$html2 = '';

$html2 .= '
<style>
    .invoice-header {
        width:100%;
        padding-bottom:10px;
    }
    .company-title {
        font-size:28px;
        color:#1a73e8;
        font-weight:bold;
     }

    .from-box {
        padding:10px;
        font-size:11px;
    }
    table.invoice-table {
        width:100%;
        margin-top:15px;
        font-size:11px;
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

</style>

<div class="invoice-header">
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="company-title">Purchase Invoice</div>
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
<br>
<table class="invoice-table" cellpadding="5">
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
    $html2 .= '<tr  align="center">
            <td>' . $row['invoice_no'] . '</td>
            <td>' . $row['invoice_date'] . '</td>
            <td>' . $row['user_name'] . '</td>
            <td>' . $row['grand_total'] . '</td>
            <td>' . $row['paid_amount'] . '</td>
            <td>' . $row['due_amount'] . '</td>
            <td>' . $row['payment_status'] . '</td>            
        </tr>';
}

$html2 .= '</tbody></table>';

$pdf->writeHTML($html2, true, false, true, false, '');

/* Output PDF */
$pdf->Output('invoice_report.pdf', 'I');
