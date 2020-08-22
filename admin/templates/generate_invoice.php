<?php

ini_set('display_errors', 0); 
error_reporting(0);

session_start();

if($_SESSION['auth_admin_login']!="")
	{
	require("../pdf/fpdf.php");
	$link=mysqli_connect('localhost', 'ronalqo42_main', 'e7F3yloBu', "ronalqo42_main");

	require('../config.inc.php');

	$sql="SELECT * FROM ".$prefix."contacts WHERE project = '".$_GET['project']."'";
		if(!$result = $link->query($sql))
			//$this->db_message($sql);
			die("Fout bij genereren PDF bestand");
	$data=$result->fetch_array(MYSQLI_BOTH);

	class Create_PDF Extends FPDF{
		function Header()
		{
			// Logo
			$this->Image('../images/logo.png',30,6,150);
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Move to the right
			$this->Cell(80);
			// Title
			$this->Cell(30,10,'',0,0,'C');
			// Line break
			$this->Ln(20);
		}

		// Page footer
		function Footer()
		{
			// Position at 1.5 cm from bottom
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Page number
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

		// Colored table
		function FancyTable($header, $data)
		{
			// Colors, line width and bold font
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			// Header
			$w = array(40, 35, 40, 45);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Ln();
			// Color and font restoration
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Data
			$fill = false;
			foreach($data as $row)
			{
				$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
				//$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
				//$this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
				//$this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
				$this->Ln();
				$fill = !$fill;
			}
			// Closing line
			$this->Cell(array_sum($w),0,'','T');
		}
	}

	// Instanciation of inherited class
	$pdf = new Create_PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',10);
	//for($i=1;$i<=40;$i++)
	  //  $pdf->Cell(0,10,'Printing line number '.$i,0,1);
	$pdf->Ln(10);
	$pdf->Cell(10,4,"Lachekiekjes", 0,1);
	$pdf->Cell(10,4,"Lijsterstraat 102", 0,1);
	$pdf->Cell(10,4,"3815 DW", 0,1);
	$pdf->Cell(10,4,"Amersfoort", 0,1);
	$pdf->Cell(10,4,"T: 033-7074737", 0,1);
	$pdf->Cell(10,4,"E: info@lachekiekjes.nl", 0,1);
	$pdf->Cell(10,4,"KVK: 12345678", 0,1);

	$pdf->Ln(10);
	$pdf->Cell(10,4,"Factuuradres", 0,1);
	$data_addr[0]=ucwords($data[1]." ".$data[2]);
	$data_addr[1]=ucwords($data[3]." ".$data[4]);
	$data_addr[2]=$data[5];
	$data_addr[3]=ucwords($data[6]);
	//$data_addr[4]=$data[7];
	//$data_addr[5]=$data[8];
	//$data_addr[6]=$data[9];

	for($i=0;$i<=3;$i++)
		$pdf->Cell(10,4,$data_addr[$i], 0,1);
	//$header = array('Bedrijf');
	//$data = $pdf->LoadData('countries.txt');
	$pdf->ImprovedTable($header,$data);
	//$pdf->FancyTable($header,$data);
	if($result->num_rows > 0)
		$pdf->Output("Factuur", "I");
	else
		die("Geen data gevonden voor factuur. Controleer de gegevens.");
}else{
	die("Voor deze actie dien je ingelogd te zijn.");
}

?>
