<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
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
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

require_once('../../../connection/connection.php');

session_start();

	if(isset($_SESSION['digimart_current_user_id'])) {
        $sql = "SELECT p.id, p.`name` FROM `product` p WHERE p.`is_deleted` = 0";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $itemName[$row['id']] = $row['name'];
            }
        } else {
            $itemName = [];
        }
    }

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

/**
 * 
 *//**
  * 
  */

class pdf extends TCPDF
{
	public function Header() {
		//logo
		$image_file = K_PATH_IMAGES.'logo.png';
		$this->Image($image_file, 15, 12, 60, '', 'PNG', '', 'R', false, 300, '', false, false, 0, false, false, false);

		//set font
		$this->Ln(7);
		$this->SetFont('times', 'B', 14);

		//title
		$this->Cell(189, 5, 'Team DigiMart (Pvt) Ltd          ', 0, 1, 'R');

		$this->SetFont('times', '', 10);
		$this->Cell(189, 3, 'Karagoda, Uyangoda, Kamburupitiya             ', 0, 1, 'R');
		$this->Cell(189, 3, '81000 Matara Sri Lanka             ', 0, 1, 'R');
		$this->Cell(189, 3, 'Phone: +94 77 1637551             ', 0, 1, 'R');
		$this->Cell(189, 3, 'Fax: +94 11 2345678             ', 0, 1, 'R');
		$this->Cell(189, 3, 'Email: teamdigimart@gmail.com             ', 0, 1, 'R');

		$this->SetFont('helvetica', 'B', 11);
		$this->Ln(2);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');

		date_default_timezone_set("Asia/Colombo");
		$tDate=date('Y-m-d H:i:s');
		$clientName=$_SESSION['digimart_current_user_first_name']." ".$_SESSION['digimart_current_user_last_name'];

		$this->Ln(2);
		$this->SetFont('Courier', '', 11);
		$this->Cell(180, 5, 'Printed Date: '.$tDate, 0, 1, 'R');


		$this->Ln(8);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(180, 5, 'Customize Product Quotation Report', 0, 1, 'C');


		$this->Ln(4);
		$this->SetFont('times', 'B', 12);
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
		$this->SetFillColor(221, 18, 61);
		$this->SetTextColor(255,255,255);
		$this->Cell(30, 3, '  Client Name: ', 1, 0, 'L', 1);
		$this->SetFont('Courier', 'B', 12);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(221, 18, 61);
		$this->Cell(150, 3, '  '.$clientName, 1, 1, 'L', 1);

		$this->Ln(4);
		$this->SetFont('times', 'B', 12);
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
		$this->SetFillColor(221, 18, 61);
		$this->SetTextColor(255,255,255);
		$this->Cell(30, 3, '  Issued Date: ', 1, 0, 'L', 1);
		$this->SetFont('Courier', 'B', 12);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(221, 18, 61);
		$this->Cell(150, 3, '  '.date('Y-m-d'), 1, 1, 'L', 1);
	}

	public function Footer() {
		
		$this->SetY(-45);

		$this->Image(K_PATH_IMAGES.'signature.png', 152, 256, 28, '', 'PNG', '', 'R', false, 300, '', false, false, 0, false, false, false);
		
		$this->Ln(5);
		$this->SetFont('Courier', '', 12);

		$this->Cell(12, 15, '       '.date('d/m/Y'), 0, 0);
		$this->Cell(115, 1, '', 0, 0);
		$this->Cell(51, 1, '', 0, 1);

		$this->SetFont('times', '', 12);

		$this->Cell(12, 1, '       _____________________', 0, 0);
		$this->Cell(115, 1, '', 0, 0);
		$this->Cell(51, 1, '_____________________', 0, 1);

		$this->Cell(12, 1, '                        Date', 0, 0);
		$this->Cell(115, 1, '', 0, 0);
		$this->Cell(51, 1, '        Issuer Signature', 0, 1);
		
		
		$this->SetFont('Courier', '', 10);
		$this->Ln(5);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');
		$this->Cell(180, 3, ' - Report of customize product quotation from Team DigiMart -', 0, 1, 'C');
		$this->Cell(205, 3, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, 1, 'C');

	}


}

// create new PDF document
$pdf = new PDF('p', 'mm', 'A4');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DigiMart');
$pdf->SetTitle('Customize Product Quotation Report');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}*/

// ---------------------------------------------------------

$pdf->AddPage();

$pdf->SetFont('times', 'B', 10);

if(isset($_GET['itemCount'])) {

	$itemCount = $_GET['itemCount'];
	$productId = explode(",",$_GET['productId']);
	$productPrice = explode(",",$_GET['productPrice']);
	$productQty = explode(",",$_GET['productQty']);
	$unitTotal = $_GET['total'];
    $customizeProductQuantity = $_GET['customizeProductQuantity'];

	$i = 1;
	$max = 10;

	$pdf->Ln(65);
	$pdf->SetFont('times', 'B', 10);
	$pdf->SetFillColor(221, 18, 61);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(5, 7, '#', 0, 0, 'C', 1);
	$pdf->Cell(25, 7, 'Pro ID', 0, 0, 'C', 1);
	$pdf->Cell(70, 7, 'Product Name', 0, 0, 'C', 1);
	$pdf->Cell(30, 7, 'Unit Price [LKR]', 0, 0, 'C', 1);
	$pdf->Cell(15, 7, 'Quentity', 0, 0, 'C', 1);
	$pdf->Cell(35, 7, 'Price [LKR]', 0, 1, 'C', 1);

	while ($i <= $itemCount) {

		$pdf->SetFont('Courier', '', 10);
		$pdf->SetTextColor(0,0,0);
		$pdf->Ln(2);
		$pdf->Cell(5, 4, $i, 0, 0, 'C');
		$pdf->Cell(25, 4, $productId[$i-1], 0, 0, 'C');
		$pdf->MultiCell(70, 4, $itemName[$productId[$i-1]], 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(30, 4, number_format($productPrice[$i-1],2), 0, 0, 'R');
		$pdf->Cell(15, 4, $productQty[$i-1], 0, 0, 'C');
		$pdf->Cell(35, 4, number_format(($productPrice[$i-1]*$productQty[$i-1]),2), 0, 1, 'R');
		$pdf->Ln(2);
		$pdf->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');

		if(($i%$max) == 0) {

			$pdf->AddPage();
			$pdf->Ln(65);
			$pdf->SetFont('times', 'B', 10);
			$pdf->SetFillColor(221, 18, 61);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(5, 7, '#', 0, 0, 'C', 1);
			$pdf->Cell(25, 7, 'Pro ID', 0,   0, 'C', 1);
			$pdf->Cell(70, 7, 'Product Name', 0, 0, 'C', 1);
			$pdf->Cell(30, 7, 'Unit Price [LKR]', 0, 0, 'C', 1);
			$pdf->Cell(15, 7, 'Quentity', 0, 0, 'C', 1);
			$pdf->Cell(35, 7, 'Price [LKR]', 0, 1, 'C', 1);

		}

		$i++;
	}

	$pdf->Ln(5);
	$pdf->SetFont('times', 'B', 12);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
	$pdf->Cell(95, 6, '', 0, 0, 'R', 1);
    $pdf->SetFont('times', 'B', 12);
	$pdf->SetFillColor(221, 18, 61);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(35, 6, 'Unit Total:', 1, 0, 'C', 1);
	$pdf->SetFont('Courier', 'B', 12);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(221, 18, 61);
	$pdf->Cell(50, 6, 'LKR '.number_format($unitTotal,2), 1, 1, 'R', 1);
    
    $pdf->Ln(1);
	$pdf->SetFont('times', 'B', 12);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
	$pdf->Cell(95, 6, '', 0, 0, 'R', 1);
    $pdf->SetFont('times', 'B', 12);
	$pdf->SetFillColor(221, 18, 61);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(35, 6, 'Quantity:', 1, 0, 'C', 1);
	$pdf->SetFont('Courier', 'B', 12);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(221, 18, 61);
	$pdf->Cell(50, 6, $customizeProductQuantity, 1, 1, 'R', 1);
    
    $pdf->Ln(5);
	$pdf->SetFont('times', 'B', 15);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
	$pdf->Cell(60, 8, '', 0, 0, 'R', 1);
	$pdf->SetFillColor(221, 18, 61);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(45, 8, 'Total:', 1, 0, 'C', 1);
	$pdf->SetFont('Courier', 'B', 15);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(221, 18, 61);
	$pdf->Cell(75, 8, 'LKR '.number_format($customizeProductQuantity*$unitTotal,2), 1, 1, 'R', 1);
}

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Customize Product Quotation.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
