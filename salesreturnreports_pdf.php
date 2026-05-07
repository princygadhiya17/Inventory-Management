<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
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
            'Sales Return Invoice'
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
$pdf = new MyCustomPDFWithWatermark(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set font
$pdf->SetFont('times', '', 8);

// add a page
$pdf->AddPage();

/* Write HTML */
$html2 = '';

$html2 .= '

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
        font-size:20px;

     }
    .from-box {
        padding:10px;
        font-size: 10px;
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
    </style>

<div class="invoice-header">
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="company-title">Sales Return Invoice</div>
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
    WHERE i.invoice_type = 'salesreturn'
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
// add a page
// $pdf->AddPage();


$pdf->writeHTML($html2, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_051.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+