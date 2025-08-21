<?php
require('fpdf186/fpdf.php');

class InvoicePDF extends FPDF
{
    private $title = 'INVOICE';
    private $invoiceNo = 'ACP-KE_INV-368';
    private $date = '3/29/2025 9:44:09';

    // 🔹 Rounded Rectangle Helper
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $x * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }

    function Header()
    {
        // ACPK Header Bar
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(165, 42, 42); // Brown Header
        $this->Rect(0, 0, 210, 30, 'F');
        $this->Cell(0, 30, 'ASSOCIATION OF COMPUTING PRACTITIONERS KENYA', 0, 1, 'C');

        // Invoice Title
        $this->SetY(40);
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(26, 58, 143);
        $this->Cell(95, 10, $this->title, 0, 0, 'R');

        // Invoice Info
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 8, 'Invoice No: ' . $this->invoiceNo, 0, 1, 'C');
        $this->Cell(95, 10, 'Date: ' . $this->date, 0, 1, 'L');

        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-40);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 8, 'If you have any questions on this invoice please contact Treasurer on Tel: +254-724064794, email: info@acpk.or.ke', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, 'P O Box 28209 00100 Nairobi Coop House', 0, 1, 'C');
        $this->Cell(0, 6, 'Website: www.acpk.or.ke | Email: info@acpk.or.ke', 0, 1, 'C');
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function addAddressSection()
    {
        // Draw rounded box
        $this->SetDrawColor(0, 0, 0);
        $this->RoundedRect(10, 70, 170, 75, 5, '');

        $this->SetXY(15, 75);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(26, 58, 143);
        $this->Cell(0, 8, 'ADDRESSED TO:', 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, 'Mr Elvis', 0, 1);
        $this->Cell(0, 6, 'Intern', 0, 1);
        $this->Cell(0, 6, 'ICT Authority', 0, 1);
        $this->Cell(0, 6, 'Website: https://icta.go.ke/', 0, 1);
        $this->Cell(0, 6, 'Email Address: ngolimwachoo@gmail.com', 0, 1);
        $this->Cell(0, 6, 'Mobile Number: 0708607402', 0, 1);

        $this->Ln(3);

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(26, 58, 143);
        $this->Cell(0, 8, 'BILLED TO:', 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, 'ICT Authority', 0, 1);

        $this->Ln(10);
    }

    function addMembershipInfo()
    {
        $this->SetFont('Arial', '', 11);
        $this->Cell(60, 8, 'MEMBERSHIP NUMBER:', 0, 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 8, 'None', 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->Cell(60, 8, 'IDENTITY NUMBER:', 0, 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 8, '37823294', 0, 1);

        $this->Ln(10);
    }

    function addInvoiceTable()
    {
        // Use same width as address box = 170mm
        $descWidth = 90;
        $unitWidth = 40;
        $amountWidth = 40;

        // Header
        $this->SetFillColor(165, 42, 42); // brown
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($descWidth, 10, 'DESCRIPTION', 1, 0, 'C', true);
        $this->Cell($unitWidth, 10, 'UNIT', 1, 0, 'C', true);
        $this->Cell($amountWidth, 10, 'AMOUNT', 1, 1, 'C', true);

        // Rows
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->Cell($descWidth, 10, 'Professional membership', 1, 0);
        $this->Cell($unitWidth, 10, 'KES 3,500/-', 1, 0, 'R');
        $this->Cell($amountWidth, 10, 'KES 3,500', 1, 1, 'R');

        $this->Cell($descWidth, 10, 'First Registration', 1, 0);
        $this->Cell($unitWidth, 10, 'KES 1,000', 1, 0, 'R');
        $this->Cell($amountWidth, 10, 'KES 1,000', 1, 1, 'R');

        // Total
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($descWidth + $unitWidth, 10, 'TOTAL', 1, 0, 'R');
        $this->Cell($amountWidth, 10, 'KES 4,500', 1, 1, 'R');

        $this->Ln(15);
    }


    function addPaymentInfo()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(26, 58, 143);
        $this->Cell(0, 8, 'BANK ACCOUNT DETAILS:', 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, 'ASSOCIATION OF COMPUTING PRACTITIONERS KENYA', 0, 1);
        $this->Cell(0, 6, 'KENYA COMMERCIAL BANK', 0, 1);
        $this->Cell(0, 6, 'A/C-NO.: 1263442854', 0, 1);
        $this->Cell(0, 6, 'KENCOM Branch KENYA', 0, 1);

        $this->Ln(5);

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(26, 58, 143);
        $this->Cell(0, 8, 'LIPA NA MPESA:', 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, 'PAYBILL BUSINESS NO: 541719', 0, 1);
        $this->Cell(0, 6, 'Account No: ACP-KE_INV-368', 0, 1);
        $this->Cell(0, 6, 'ACPK PIN NO: P0518283928', 0, 1);
    }
}

// Generate the PDF
$pdf = new InvoicePDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->addAddressSection();
$pdf->addMembershipInfo();
$pdf->addInvoiceTable();
$pdf->addPaymentInfo();
$pdf->Output('I', 'ACP-KE_INV-368_Custom.pdf');
