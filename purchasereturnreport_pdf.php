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

        $this->SetAlpha(0.2); // transparency (0 = invisible, 1 = solid)

        $this->SetFont('helvetica', 'B', 50);
        $this->SetTextColor(150, 150, 150);

        // Rotate text
        $this->StartTransform();
        $this->Rotate(45, $this->getPageWidth() / 2, $this->getPageHeight() / 2);

        // Position text at center
        $this->Text(
            ($this->getPageWidth() / 2) - 100,
            ($this->getPageHeight() / 2),
            'Purchase Return Invoice'
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
$pdf->SetFont('times', '', 13);

// add a page
$pdf->AddPage();

/* Write HTML */
$html2 = '';
$html2 .= '<h3 style="text-align:center;">Invoice Report</h3>
<table border="1" cellpadding="5" width="100%">
    <thead>
       <tr style="background-color:#f2f2f2; text-align:center;">
            <th><b>Invoice No</b></th>
            <th><b>Invoice Date</b></th>
            <th><b>Customer</b></th>
            <th><b>Total</b></th>
            <th><b>Paid</b></th>
            <th><b>Due</b></th>
            <th><b>Status</b></th>
        </tr>
    </thead>
    <tbody>';

$invoices = mysqli_query($conn, "
    SELECT i.*, u.user_name
    FROM invoice i
    LEFT JOIN users u ON i.user_id = u.id
    WHERE i.invoice_type = 'purchasereturn'
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