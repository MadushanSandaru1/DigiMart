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

date_default_timezone_set("Asia/Colombo");

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


		$this->Ln(6);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(180, 5, 'Daily Confirmed Customize Order Report', 0, 1, 'C');
        

		$this->Ln(7);
		$this->SetFont('times', 'B', 12);
		$this->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(221, 18, 61)));
		$this->SetFillColor(221, 18, 61);
		$this->SetTextColor(255,255,255);
		$this->Cell(25, 3, '  Date: ', 1, 0, 'L', 1);
		$this->SetFont('Courier', 'B', 12);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(221, 18, 61);
		$this->Cell(155, 3, '  '.date('F d, Y'), 1, 1, 'L', 1);
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
		$this->Ln(3);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');
		$this->Cell(180, 3, ' - Report of daily confirmed customize order from Team DigiMart -', 0, 1, 'C');
		$this->Cell(205, 3, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, 1, 'C');

	}


}

// create new PDF document
$pdf = new PDF('p', 'mm', 'A4');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DigiMart');
$pdf->SetTitle('Daily Confirmed Customize Order Report');
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


$i = 1;
$max = 1;

$query2 = "SELECT o.`id` AS 'orderId', o.*, c.*, m.* FROM `customize_order` o, `customer` c, `customer_mail_info` m WHERE o.`is_canceled` = 0 AND o.`is_deleted` = 0 AND o.`is_posted` = 0 AND c.`id` = o.`customer_id` AND m.`customer_id` = c.`id` AND m.`is_default` = 1 AND o.`date_time` <= '".date("Y-m-j H:i:s", strtotime('-1 days'))."' ORDER BY o.`date_time` ASC";

$result = $conn->query($query2);

    $pdf->Ln(50);

while ($row = $result->fetch_assoc()) {
    
    $pdf->Ln(8);
    $pdf->SetFont('times', 'B', 12);
    $pdf->SetFillColor(221, 18, 61);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(25, 8, 'Order ID:', 0, 0, 'L', 1);
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->Cell(40, 8, $row['orderId'], 0, 0, 'L', 1);
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(33, 8, 'Ordered Date:', 0, 0, 'L', 1);
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->Cell(82, 8, $row['date_time'], 0, 1, 'L', 1);

    
    $pdf->Ln(2);
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(40, 4, "Ordered by:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(105, 4, $row['first_name']." ".$row['last_name']." [".$row['customer_id']."]", 0, 1, 'L');
    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Ln(2);
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(40, 4, "Email:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(105, 4, $row['email'], 0, 1, 'L');
    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Ln(2);
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(40, 4, "Mobile No:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(105, 4, $row['mobile_no'], 0, 1, 'L');
    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Ln(2);
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(40, 4, "Address:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(105, 4, $row['street_1'].", ".$row['street_2'].", ".$row['city'].". ".$row['zip_code'], 0, 1, 'L');
    $pdf->SetFont('Courier', '', 8);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Ln(1);
    $pdf->Cell(180, 3, '__________________________________________________________________________________________________________', 0, 1, 'C');
    
    $pdf->Ln(2);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(40, 1, "Unit Price:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(60, 1, "LKR ".number_format($row['unit_price'],2), 0, 0, 'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(25, 1, "Quantity:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(25, 1, $row['quantity'], 0, 1, 'L');
    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Ln(2);
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(40, 1, "Total:", 0, 0, 'L');
    $pdf->SetFont('Courier', 'B', 12);
    $pdf->SetTextColor(221, 18, 61);
    $pdf->Cell(115, 1, "LKR ".number_format(($row['unit_price']*$row['quantity']),2), 0, 1, 'L');
    $pdf->SetFont('Courier', '', 8);
    $pdf->SetTextColor(0,0,0);
    
    $pdf->Cell(180, 1, '__________________________________________________________________________________________________________', 0, 1, 'C');
    
    
    
    $query1 = "SELECT cu.`id`, p.`name`, p.`price`, ca.`type` FROM `customize_order_product` cu, `product` p, `category` ca WHERE cu.`product_id` = p.`id` AND ca.`id` = p.`category_id` AND cu.`customize_order_id` = {$row['orderId']} ORDER BY cu.`id` ASC";
    
    $resultItem = $conn->query($query1);
    
    while ($rowItem = $resultItem->fetch_assoc()) {
        $pdf->Ln(2);
        $pdf->SetFont('Courier', '', 12);
        $pdf->Cell(40, 3, $rowItem['type'].": ", 0, 0, 'L');
        $pdf->SetFont('Courier', '', 9);
        $pdf->MultiCell(85, 3, $rowItem['name'], 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('Courier', '', 12);
        $pdf->Cell(55, 3, "LKR ".number_format($rowItem['price'],2), 0, 1, 'R');
        $pdf->Ln(3);
    }
    
    $pdf->SetFont('Courier', 'B', 10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(180, 1, '_____________________________________________________________________________________', 0, 1, 'C');
    

    if(($i%$max) == 0) {

        $pdf->AddPage();
        $pdf->Ln(50);

    }
    
    $i++;
}



// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Daily confirmed customize order report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
