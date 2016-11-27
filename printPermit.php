<?php
  require("plugins/fpdf/fpdf.php");
  // $name = $_POST['name'];
  // $dept = $_POST['dept'];
  // $time = $_POST['time'];
  // $dateoffiling = $_POST['dateoffiling'];
  // $dateofuse = $_POST['dateofuse'];
  // $purpose = $_POST['purpose'];
  // $room = $_POST['room'];
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
      $this->Cell(85,$heightL,'Sample',1,1,'C',true);
      $this->Ln(1);

      //NATURE OF ACTIVITY
      $this->SetFont('Arial','',6);
      $this->Cell(40,$heightT,$lbl4,1,1,'L',true);

      $this->SetFont('Arial','',8);
      $this->Cell(93,$heightL,'Sample',1,1,'C',true);

      //The BorderBox
      $actual_position_y = $this->GetY();
      $this->SetFillColor(255, 255, 255);
      $this->SetDrawColor(0, 0, 0);

      //Your actual content ====OFFICE/DEPT/COLLEGE===
      $this->SetXY(98, 48);
      $this->SetFont('Arial','',6);
      $this->Cell(35, $heightT, $lbl2, 1, 1, 'L');

      $this->SetXY(98, 53);
      $this->SetFont('Arial','',8);
      $this->Cell(56,$heightL,'Sample',1,1,'C',true);

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
      $this->Cell(22, $heightT,$lbl3, 1, 1, 'L');

      $this->SetXY(157, 53);
      $this->SetFont('Arial','',8);
      $this->Cell(43,$heightL,'08/01/2016',1,1,'C',true);

      //TIME OF USE
      $this->SetXY(157, 61);
      $this->SetFont('Arial','',6);
      $this->Cell(22, $heightT, $lbl6, 1, 1, 'L');

      $this->SetXY(157, 66);
      $this->SetFont('Arial','',8);
      $this->Cell(43,$heightL,'8:00am-10:00am',1,1,'C',true);

      //TABLE
      $this->SetXY(10, 77);
      $this->Cell(95,55,'',1,1,'C',true);

      $this->SetXY(105, 77);
      $this->Cell(95,55,'',1,1,'C',true);

      //TABLE Equipment
      $this->SetXY(10, 130);
      $this->Cell(95,45,'',1,1,'C',true);

      $this->SetXY(105, 130);
      $this->Cell(95,45,'',1,1,'C',true);

      //TABLE REMARKS
      $this->SetXY(10, 173);
      $this->Cell(190,25,'',1,1,'C',true);

      //TABLE
      $this->SetXY(10, 199);
      $this->Cell(40,20,'',1,1,'C',true);
      $this->SetXY(51, 199);
      $this->Cell(47,20,'',1,1,'C',true);
      $this->SetXY(99, 199);
      $this->Cell(50,20,'',1,1,'C',true);
      $this->SetXY(150, 199);
      $this->Cell(50,20,'',1,1,'C',true);

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

      $this->SetXY(14, 132);
      $this->Cell(181,$heightT,'EQUIPMENT CHECKLIST',1,1,'C',true);

      $this->SetXY(14, 175);
      $this->Cell(181,$heightT,'REMARKS/SPECIAL INSTRUCTION',1,1,'C',true);

      //DISPLAY QUANTITY
      $actual_position_y = $this->GetY();
      $this->SetFont('Arial','',6);
      $Xaxis = 38;
      $Yaxis = 139;
      for($x=0;$x<5;$x++)
      { 
        $this->SetXY($Xaxis, $Yaxis);
        $this->Cell(4,4,"QUANTITY",0,0);
        if($x>=1)
        {
          $Xaxis = $Xaxis + 47;
        }
      }

      //
      $actual_position_y = $this->GetY();
      $this->SetFont('Arial','',7);
      $this->SetXY(14, 159);
      $this->Cell(4,4,"OTHER EQUIPMENT:",0,0);
      $this->SetXY(14, 163);
      $this->Cell(20,4,"Phone, celphone, clicker",0,0);
      $this->Line(15, 168, 210-110, 168); //DRAW LINE


      $this->SetXY(108, 154);
      $this->Cell(4,4,"OTHER EQUIPMENT:",0,0);
      $this->SetXY(109, 160);
      $this->Cell(20,4,"Phone, celphone, clicker",0,0);
      $this->Line(110, 165, 210-13, 165); //DRAW LINE

      //LABEL
      $this->SetXY(99, 204);
      $this->SetFont('Arial','',5);
      $this->Cell(50,4,"FOR LMO FACILITIES AND EQUIPMENT ONLY",0,0,'C');

      $actual_position_y = $this->GetY();
      $this->SetFont('Arial','',7);
      $this->SetFillColor(255, 255, 255);
      $this->SetTextColor(0,0,0);

      $this->SetXY(10, 199);
      $this->Cell(40,5,'REQUESTER/DATE',1,1,'C',true);

      $this->SetXY(51, 199);
      $this->Cell(47,5,'RECOMMENDED BY/DATE',1,1,'C',true);

      $this->SetXY(99, 199);
      $this->Cell(50,5,'VERIFIED BY/DATE',1,1,'C',true);

      $this->SetXY(150, 199);
      $this->Cell(50,5,'APPROVED BY/DATE',1,1,'C',true);

      //VALUES HERE DUN SA MAY BABA
      $this->SetXY(10, 207);
      $this->Cell(40,5,"Alyssa Ganotisi",0,0,'C');
      $this->SetXY(10, 210);
      $this->Cell(40,5,"08/06/2016",0,0,'C');

      $this->SetXY(51, 207);
      $this->Cell(47,5,"Alyssa Ganotisi",0,0,'C');
      $this->SetXY(51, 210);
      $this->Cell(47,5,"08/06/2016",0,0,'C');

      $this->SetXY(99, 207);
      $this->Cell(50,5,"Alyssa Ganotisi",0,0,'C');
      $this->SetXY(99, 210);
      $this->Cell(50,5,"08/06/2016",0,0,'C');

      $this->SetXY(150, 207);
      $this->Cell(50,5,"Alyssa Ganotisi",0,0,'C');
      $this->SetXY(150, 210);
      $this->Cell(50,5,"08/06/2016",0,0,'C');      

      //DETAILSSSSSSSSSS
      $this->SetFont('Arial','',4);
      $this->SetXY(10, 215);
      $this->Cell(40,5,"SIGNATURE OVER PRINTED NAME/DATE",0,0,'C');

      $this->SetXY(51, 213);
      $this->Cell(47,5,"SIGNATURE OVER PRINTED NAME/DATE",0,0,'C');

      $this->SetXY(99, 213);
      $this->Cell(50,5,"SIGNATURE OVER PRINTED NAME/DATE",0,0,'C');

      $this->SetXY(150, 213);
      $this->Cell(50,5,"SIGNATURE OVER PRINTED NAME/DATE",0,0,'C');


      $this->SetXY(51, 215);
      $this->Cell(47,5,"PGM CHAIR/DEAN/ADVISER/DEPT. HEAD",0,0,'C');
      $this->SetXY(99, 215);
      $this->Cell(50,5,"LABORATORY MANAGEMENT OFFICE",0,0,'C');
      $this->SetXY(150, 215);
      $this->Cell(50,5,"ADMINISTRATIVE OFFICE",0,0,'C');

      //===========SIGNATURE==========
      $this->Line(13, 215, 210-163, 215); //SIGNATURE
      $this->Line(55, 214, 210-115, 214); 
      $this->Line(101, 214, 210-64, 214); 
      $this->Line(152, 214, 210-13, 214); 

  }
  function CheckBoxes()
  {
    //Try
    $actual_position_y = $this->GetY();
    $boolean_variable = false;
    $checkbox_size = 3;

    //KAPAG NAKAFALSE WALANG CHECKBOX
    if($boolean_variable == true)
    $check = "4"; else $check = ""; //4 kasi sya yung checkbox

  //====================ADMINISTRATIVE OFFICE================
    $aRooms = array('JP RIZAL HALL LOBBY', 'JP RIZAL HALL AIR WELL', 'TRACK OVAL', 'BASKETBALL COURT', 'VOLLEYBALL COURT', 'ET YUNCHENGCO HALL LOBBY', 'SHANNON DRIVE', 'EINSTEIN DRIVE');

    $pXaxis1 = 17;
    $pYaxis1 = 92;
    $ctr = 8;
    for($y=0; $y<count($aRooms);$y++)
    {

        $this->SetFont('ZapfDingbats','', 7);
        $this->SetXY($pXaxis1, $pYaxis1); //POSITION
        $this->Cell($checkbox_size, $checkbox_size, $check, 1, 0);
        $this->SetFont('Arial','',7); 
        $this->Cell(4,4,$aRooms[$y],0,1); //0-1 katuloy lang
      //$check="4";
        if($y>=3)
        {
          $pXaxis1=55;

          if($y==3)
          {
             $pYaxis1 = 92;
          }
          if($y>3) //Y- AXIS
          {
              $pYaxis1=$pYaxis1+5;
          }
        }
        else{
          $pYaxis1=$pYaxis1+5;
        }
    }

    $this->SetFont('ZapfDingbats','', 7);
    $this->SetXY(28, 114);
    $this->Cell($checkbox_size, $checkbox_size, $check, 1,0);
    $this->SetFont('Arial','',7); 
    $this->Cell(4,4,"LECTURE ROOM",0,2); 

    $this->SetFont('Arial','',5); 
    $this->SetXY(60, 110);
    $this->Cell(4,4,"ROOM NO.",0,0); 

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetLineWidth(0.25);
    $this->SetXY(53, 113);
    $this->SetFont('Arial','',10);
    $this->Cell(25,5,'206',1,1,'C',true);

    $this->Ln(13);
    $this->SetFont('ZapfDingbats','', 7);
    $this->SetXY(28, 120);
    $this->Cell($checkbox_size, $checkbox_size, $check, 1,0);
    $this->SetFont('Arial','',7); 
    $this->Cell(4,4,"OTHERS",0,1);
    $this->SetXY(46, 120);
    $this->SetFont('Arial','',10);
    $this->Cell(4,4,"R314",0,2); //DITO YUNG MGA VALUES
    $this->Line(45, 124, 210-130, 124); //DRAW LINE

    //========================LABORATORY MANAGEMENT OFFICE (LMO)=================//try for loop

    $lRooms = array('AUDITORIUM(R504)', 'PLOTTING/DRAFTING ROOM(R505)','PHOTOGRAPHY STUDIO R506)','PHYSICS/IE LABORATORY(R414)','FOOD LABORATORY(E205)', 'CAFE ENRIQUE(E200)', "CHEMISTRY LAB", "EEC LABORATORY", 'IT LABORATORY', 'ETY HOTEL ROOM', 'MC LABORATORY', 'CMET LABORATORY');

    $remarks = 'SEE REMARKS';
    $pXaxis = 107;
    $pYaxis = 92;
    $bXaxis = 177; //BOX
    $bYaxis = 87;
    for($i=0; $i<count($lRooms);$i++)
    {
      //$check="4";
      $this->SetFont('ZapfDingbats','', 7);
      $this->SetXY($pXaxis, $pYaxis); //POSITION
      $this->Cell($checkbox_size, $checkbox_size, $check, 1, 0);
      $this->SetFont('Arial','',6); 
      $this->Cell(4,4,$lRooms[$i],0,1);

      //POSITION
      if($i>=5)
      {
          $pXaxis = 150;
          if($i==5)
          {
            $pYaxis = 92;
          }

          if($i>5)
          {
            $pYaxis=$pYaxis+5;
            //The BorderBox
            $actual_position_y = $this->GetY();
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0,0,0);
            $this->SetXY($bXaxis, $bYaxis);
            $this->SetFont('Arial','',7);
            $this->Cell(20,4,"M104",1,1,'C',true);
          }

            $bYaxis = $bYaxis + 5;
      }
      else if($i==count($lRooms))
      {
        $pXaxis = 115;
        $pYaxis = 115;
      }
      else
      {
          $pYaxis=$pYaxis+5;
      }
    }//fir loop

    $this->SetFont('Arial','',5); 
    $this->SetXY(181, 88);
    $this->Cell(4,4,"ROOM NO.",0,0); 

    $this->SetFont('ZapfDingbats','', 7);
    $this->SetXY(112, 123);
    $this->Cell($checkbox_size, $checkbox_size, $check, 1,0);
    $this->SetFont('Arial','',7); 
    $this->Cell(4,4,"OTHERS",0,1);
    $this->SetXY(132, 122);
    $this->SetFont('Arial','',10);
    $this->Cell(4,4,"R314",0,2); //DITO YUNG MGA VALUES
    $this->Line(130, 126, 210-30, 126); //DRAW LINE

    //=============EQUIPMENT CHECKLIST ==================
    $eqC = array('Projector','Speakers','Mic','Chairs','Tables','Panel Board','Videocam','Computer','Round Table','Cocktail');

    $eXaxis = 15;
    $eYaxis = 143;

    $eBXaxis = 33;
    for($x=0;$x<count($eqC);$x++)
    {
      $this->SetFont('ZapfDingbats','', 7);
      $this->SetXY($eXaxis, $eYaxis); //POSITION
      $this->Cell($checkbox_size, $checkbox_size, $check, 1, 0);
      $this->SetFont('Arial','',7); 
      $this->Cell(4,4,$eqC[$x],0,1);
      //The BorderBox
      $actual_position_y = $this->GetY();
      $this->SetFillColor(255, 255, 255);
      $this->SetTextColor(0,0,0);
      $this->SetXY($eBXaxis, $eYaxis);
      $this->SetFont('Arial','',7);
      $this->Cell(20,4,"Sample",1,1,'C',true);

      if($x>=2)
      {
        $eXaxis = 60;
        $eBXaxis = 81; //NExt axis of box

        if($x==2)
        {
          $eYaxis = 143;
        }
        if($x>2 && $x<=4) //Chairs and tables
        {
          $eYaxis=$eYaxis+5;
        }
        else if($x>=5)
        {
          $eXaxis = 110;
          $eBXaxis = 128;

          if($x==5) //Panel board
          {
            $eYaxis = 143;
          }
          else if($x>6) //Computer and round table
          {
            $eXaxis = 153;
            $eBXaxis = 177; //Next for box
            $eYaxis = 143;
            if($x==8)
            {
              $eYaxis = $eYaxis + 5;
            }
          }
          else{
             $eYaxis = $eYaxis + 5;
          }
        }
        else{

        }
      }
      else{
        $eYaxis = $eYaxis + 5; 
      }
    }
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
$pdf->CheckBoxes();


$pdf->SetFont('Arial','',5);  
$pdf->Output();

?>
