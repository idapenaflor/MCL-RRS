<?php
  require("plugins/fpdf/fpdf.php");

//=====================CREATED BY ALYSSA GANOTISI AND IDA PENAFLOR=============
class PDF extends FPDF
{
  protected $col = 0; // Current column
  protected $y=0;      // Ordinate of column start
// Page header
  function Header()
  {
      // Logo
      $this->Image('img/logo-permit.png',10,6,30);
      // Arial bold 15
      $this->SetFont('Arial','B',11);
      // Move to the right
      $this->Cell(80);
      // Thickness of frame (1 mm)
      $this->SetLineWidth(1);
      // Title
      $this->Cell(40,20,'PERMIT TO USE FACILITIES/EQUIPMENT',0,0,'C'); 
  }
  function ChapterTitle($file)
  {
     $lbl = 'REQUESTER (FULL NAME)';
     $lbl2 = 'OFFICE/DEPT/COLLEGE';
     $lbl3 = 'DATE OF FILING';
     $lbl4 = 'NATURE OF ACTIVITY/PURPOSE';
     $lbl5 = 'DATE OF USE';
     $lbl6 = 'TIME OF USE';
     $heightT = 5;
     $heightL = 7;
      // Read text file
      $txt = file_get_contents($file);
      $this->SetFont('Arial','',5);
      $this->Ln(13);
      $this->Write(3,$txt); //NANDITO YUNG TEXT
      $this->Line(10, 47, 210-10, 47); //DRAW LINE
      $this->Ln(4);

      $this->SetFillColor(255,255,255);
      $this->SetTextColor(0,0,0);
      $this->SetLineWidth(0.25);

      $this->SetFont('Arial','',6);
      $this->Cell(35,$heightT,$lbl,1,1,'L',true);

      //NAME OF REQUESTER
      $this->SetFont('Arial','',8);
      $this->Cell(85,$heightL,'Alyssa Ganotisi',1,1,'C',true);
      $this->Ln(1);

      //NATURE OF ACTIVITY
      $this->SetFont('Arial','',6);
      $this->Cell(40,$heightT,$lbl4,1,1,'L',true);

      $this->SetFont('Arial','',8);
      $this->Cell(93,$heightL,'CCIS MEETING',1,1,'C',true);

      //The BorderBox
      $actual_position_y = $this->GetY();
      $this->SetFillColor(255, 255, 255);
      $this->SetDrawColor(0, 0, 0);
      // $this->Cell(10, 10, "", 1, 1, 'C');

      //Your actual content ====OFFICE/DEPT/COLLEGE===
      $this->SetXY(98, 48);
      $this->SetFont('Arial','',6);
      $this->Cell(35, $heightT, $lbl2, 1, 1, 'L');

      $this->SetXY(98, 53);
      $this->SetFont('Arial','',8);
      $this->Cell(56,$heightL,'CCIS',1,1,'C',true);

      //DATE OF USE
      $this->SetXY(106, 61);
      $this->SetFont('Arial','',6);
      $this->Cell(21,$heightT,$lbl5,1,1,'L',true);

      $this->SetXY(106, 66);
      $this->SetFont('Arial','',8);
      $this->Cell(48,$heightL,'08/06/2016',1,1,'C',true);

      //DATE OF FILING
      $this->SetXY(157, 48);
      $this->SetFont('Arial','',6);
      $this->Cell(22, $heightT, $lbl3, 1, 1, 'L');

      $this->SetXY(157, 53);
      $this->SetFont('Arial','',8);
      $this->Cell(43,$heightL,'08/01/2016',1,1,'C',true);

      //TIME OF USE
      $this->SetXY(157, 61);
      $this->SetFont('Arial','',6);
      $this->Cell(22, $heightT, $lbl6, 1, 1, 'L');

      $this->SetXY(157, 66);
      $this->SetFont('Arial','',8);
      $this->Cell(43,$heightL,'8:00 am - 10:00 am',1,1,'C',true);

      //TABLE
      $this->SetXY(10, 77);
      $this->Cell(95,55,'',1,1,'C',true);

      $this->SetXY(105, 77);
      $this->Cell(95,55,'',1,1,'C',true);
  }
  function ChapterBody()
  {
     $heightT = 5;
     $heightL = 7;

      //The BorderBox
      $actual_position_y = $this->GetY();
      $this->SetFillColor(0, 0, 0);
      $this->SetTextColor(255,255,255);
      //$this->SetDrawColor(255,255, 255);

      //LABEL BLACK
      $this->SetXY(13, 75);
      $this->SetFont('Arial','',8);
      $this->Cell(90,$heightT,'ADMINISTRATIVE OFFICE (AO)',1,1,'C',true);

      $this->SetXY(107, 75);
      $this->SetFont('Arial','',8);
      $this->Cell(90,$heightT,'LABORATORY MANAGEMENT OFFICE (LMO)',1,1,'C',true);

      
      //CENTER LABEL
      $actual_position_y = $this->GetY();
      $this->SetFillColor(204, 204, 255);
      $this->SetTextColor(0,0,0);
      $this->SetXY(14, 81);
      $this->Cell(181,$heightT,'FACILITIES CHECKLIST',1,1,'C',true);

  }
  
}

 

// Instanciation of inherited class
// $pdf=new PDF();
$pdf = new PDF('P','mm','A4');
// $pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Line(10, 23, 210-10, 23); //DRAW LINE
$pdf->ChapterTitle('plugins/terms.txt');
$pdf->ChapterBody();


$pdf->SetFont('Arial','',5);  
$pdf->Output();

?>
