<?php
require('fpdf17/fpdf.php');
require("../config/config.php");
require("../config/db.php");

session_start();
$datef = $_SESSION['$datef'];
$datet = $_SESSION['$datet'];
//$hid = $_SESSION['id'];
$hid = $_SESSION['id'];

class PDF extends FPDF {
	function Header(){
		$this->SetFont('Arial','B',15);
		
		//dummy cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);
		
		//put logo
		$this->Image('logo-small.png',10,10,20);
		
		$this->Cell(100,10,'       Bookings Report',0,1);
		
		//dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//is equivalent to:
		$this->Ln(5);
		
		$this->SetFont('Arial','B',11);
		// 10 20 20 20 20 20 40 40
		$this->SetFillColor(180,180,255);
        $this->SetDrawColor(180,180,255);
        $this->Cell(10,5,'Bid',1,0,'',true);
        $this->Cell(30,5,'Name',1,0,'',true);
        $this->Cell(40,5,'Phone',1,0,'',true);
        $this->Cell(20,5,'Date',1,0,'',true);
        $this->Cell(20,5,'Time',1,0,'',true);
        $this->Cell(20,5,'Discount',1,0,'',true);
        $this->Cell(20,5,'Seats',1,0,'',true);
		$this->Cell(30,5,'Status',1,1,'',true);	
	}
	function Footer(){
		//add table's bottom line
		$this->Cell(190,0,'','T',1,'',true);
		
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();

$pdf->SetFont('Arial','',9);
$pdf->SetDrawColor(180,180,255);


$query = "SELECT b.bid,b.date,b.time,b.discount,b.people,b.status,c.cusername,c.cphno from bookings as b inner join customer as c on b.cid=c.cid where b.hid='$hid' AND (b.date BETWEEN '$datef' AND '$datet') order by date"; 
$result=mysqli_query($conn,$query);
while($data=mysqli_fetch_array($result)){
    $stat = ' ';
    if($data['status']==0){$stat = "CANCELED";}else if($data['status']==2){$stat = "MISSED";}else if($data['status']==3){$stat = "COMPLETED";}
    $pdf->Cell(10,5,$data['bid'],'LR',0);
    $pdf->Cell(30,5,$data['cusername'],'LR',0);
    $pdf->Cell(40,5,$data['cphno'],'LR',0);
    $pdf->Cell(20,5,$data['date'],'LR',0);
    $pdf->Cell(20,5,$data['time'],'LR',0);
    $pdf->Cell(20,5,$data['discount'],'LR',0);
    $pdf->Cell(20,5,$data['people'],'LR',0);
    $pdf->Cell(30,5,$stat,'LR',1);	
}


$pdf->Output();
?>