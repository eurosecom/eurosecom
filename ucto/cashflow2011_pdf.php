<?php

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s1.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s1.jpg',0,40,210,290); }
}
$rmc=0;

$pdf->SetY(20);
$pdf->SetFont('arial','',10);

//za obdobie
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

$datumod="01.01.".$kli_vrok;
$datumdo=$pocetdni.".".$kli_vume;

//nacitaj obdobie z priznanie_po
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $obdd1=$riadok->obdd1;
  $obdm1=$riadok->obdm1;
  $obdr1=$riadok->obdr1;
  $obdd2=$riadok->obdd2;
  $obdm2=$riadok->obdm2;
  $obdr2=$riadok->obdr2;
  $obmd1=$riadok->obmd1;
  $obmm1=$riadok->obmm1;
  $obmr1=$riadok->obmr1;
  $obmd2=$riadok->obmd2;
  $obmm2=$riadok->obmm2;
  $obmr2=$riadok->obmr2;
  }
$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) { 
$datumod=$obdd1.".".$obdm1.".20".$obdr1; $datumdo=$obdd2.".".$obdm2.".20".$obdr2; }

$pdf->Cell(6,1," ","$rmc",1,"C");
$pdf->Cell(0,6,"PREH¼AD O PEÒAŽNÝCH TOKOCH za obdobie od $datumod do $datumdo","$rmc",1,"C");
$pdf->Cell(0,6,"pri použití priamej metódy","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//ico
$pdf->Cell(23,6,"IÈO: $fir_fico","$rmc",0,"L");$pdf->Cell(0,6,"   ","$rmc",1,"R");
$pdf->SetFont('arial','',10);

//Názov a sídlo UJ
$pdf->Cell(0,5,"Názov a sídlo ÚJ : $fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");


//položky 1.strana

$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14;
if( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15;
if( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16;
if( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17;
if( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18;
if( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19;
if( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20;
if( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21;
if( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22;
if( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23;
if( $hlavicka->r23 == 0 ) $r23="";

$rm01=$hlavicka->rm01;
if( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02;
if( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03;
if( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04;
if( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05;
if( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06;
if( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07;
if( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08;
if( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09;
if( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10;
if( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11;
if( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12;
if( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13;
if( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14;
if( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15;
if( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16;
if( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17;
if( $hlavicka->rm17 == 0 ) $rm17="";
$rm18=$hlavicka->rm18;
if( $hlavicka->rm18 == 0 ) $rm18="";
$rm19=$hlavicka->rm19;
if( $hlavicka->rm19 == 0 ) $rm19="";
$rm20=$hlavicka->rm20;
if( $hlavicka->rm20 == 0 ) $rm20="";
$rm21=$hlavicka->rm21;
if( $hlavicka->rm21 == 0 ) $rm21="";
$rm22=$hlavicka->rm22;
if( $hlavicka->rm22 == 0 ) $rm22="";
$rm23=$hlavicka->rm23;
if( $hlavicka->rm23 == 0 ) $rm23="";

$rhod=$r01;
//$rhod="123456789.13";
$rmhod=$rm01;
//$rmhod="123456789.13";
$pdf->Cell(150,38," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r02;
//$rhod="123456789.13";
$rmhod=$rm02;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r03;
//$rhod="123456789.13";
$rmhod=$rm03;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r04;
//$rhod="123456789.13";
$rmhod=$rm04;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r05;
//$rhod="123456789.13";
$rmhod=$rm05;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r06;
//$rhod="123456789.13";
$rmhod=$rm06;
//$rmhod="123456789.13";
$pdf->Cell(151,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r07;
//$rhod="123456789.13";
$rmhod=$rm07;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r08;
//$rhod="123456789.13";
$rmhod=$rm08;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r09;
//$rhod="123456789.13";
$rmhod=$rm09;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r10;
//$rhod="123456789.13";
$rmhod=$rm10;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r11;
//$rhod="123456789.13";
$rmhod=$rm11;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r12;
//$rhod="123456789.13";
$rmhod=$rm12;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r13;
//$rhod="123456789.13";
$rmhod=$rm13;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r14;
//$rhod="123456789.13";
$rmhod=$rm14;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r15;
//$rhod="123456789.13";
$rmhod=$rm15;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r16;
//$rhod="123456789.13";
$rmhod=$rm16;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//súèet A1 až A16
$rhod=$r17;
//$rhod="123456789.13";
$rmhod=$rm17;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r18;
//$rhod="123456789.13";
$rmhod=$rm18;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r19;
//$rhod="123456789.13";
$rmhod=$rm19;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r20;
//$rhod="123456789.13";
$rmhod=$rm20;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r21;
//$rhod="123456789.13";
$rmhod=$rm21;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//súèet A1 až A20
$rhod=$r22;
//$rhod="123456789.13";
$rmhod=$rm22;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r23;
//$rhod="123456789.13";
$rmhod=$rm23;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//strana 2

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s2.jpg',0,7,210,297); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//ico
$pdf->Cell(1,4," ","$rmc",1,"C");
$pdf->Cell(12,6," ","$rmc",0,"R");$pdf->Cell(23,6,"IÈO: $fir_fico","$rmc",0,"L");$pdf->Cell(142,6,"strana 2.","$rmc",1,"R");

//položky 2.strana
$pdf->Cell(0,15," ","$rmc",1,"C");


$r24=$hlavicka->r24;
if( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25;
if( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26;
if( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27;
if( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28;
if( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29;
if( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30;
if( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31;
if( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32;
if( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33;
if( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34;
if( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35;
if( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36;
if( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37;
if( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38;
if( $hlavicka->r38 == 0 ) $r38="";
$r39=$hlavicka->r39;
if( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40;
if( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41;
if( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42;
if( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43;
if( $hlavicka->r43 == 0 ) $r43="";
$r44=$hlavicka->r44;
if( $hlavicka->r44 == 0 ) $r44="";
$r45=$hlavicka->r45;
if( $hlavicka->r45 == 0 ) $r45="";
$r46=$hlavicka->r46;
if( $hlavicka->r46 == 0 ) $r46="";

$rm24=$hlavicka->rm24;
if( $hlavicka->rm24 == 0 ) $rm24="";
$rm25=$hlavicka->rm25;
if( $hlavicka->rm25 == 0 ) $rm25="";
$rm26=$hlavicka->rm26;
if( $hlavicka->rm26 == 0 ) $rm26="";
$rm27=$hlavicka->rm27;
if( $hlavicka->rm27 == 0 ) $rm27="";
$rm28=$hlavicka->rm28;
if( $hlavicka->rm28 == 0 ) $rm28="";
$rm29=$hlavicka->rm29;
if( $hlavicka->rm29 == 0 ) $rm29="";
$rm30=$hlavicka->rm30;
if( $hlavicka->rm30 == 0 ) $rm30="";
$rm31=$hlavicka->rm31;
if( $hlavicka->rm31 == 0 ) $rm31="";
$rm32=$hlavicka->rm32;
if( $hlavicka->rm32 == 0 ) $rm32="";
$rm33=$hlavicka->rm33;
if( $hlavicka->rm33 == 0 ) $rm33="";
$rm34=$hlavicka->rm34;
if( $hlavicka->rm34 == 0 ) $rm34="";
$rm35=$hlavicka->rm35;
if( $hlavicka->rm35 == 0 ) $rm35="";
$rm36=$hlavicka->rm36;
if( $hlavicka->rm36 == 0 ) $rm36="";
$rm37=$hlavicka->rm37;
if( $hlavicka->rm37 == 0 ) $rm37="";
$rm38=$hlavicka->rm38;
if( $hlavicka->rm38 == 0 ) $rm38="";
$rm39=$hlavicka->rm39;
if( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40;
if( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41;
if( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42;
if( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43;
if( $hlavicka->rm43 == 0 ) $rm43="";
$rm44=$hlavicka->rm44;
if( $hlavicka->rm44 == 0 ) $rm44="";
$rm45=$hlavicka->rm45;
if( $hlavicka->rm45 == 0 ) $rm45="";
$rm46=$hlavicka->rm46;
if( $hlavicka->rm46 == 0 ) $rm46="";



$rhod=$r24;
//$rhod="123456789.13";
$rmhod=$rm24;
//$rmhod="123456789.13";
$pdf->Cell(150,9," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r25;
//$rhod="123456789.13";
$rmhod=$rm25;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");



//súèet A1 až A23
$rhod=$r26;
//$rhod="123456789.13";
$rmhod=$rm26;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r27;
//$rhod="123456789.13";
$rmhod=$rm27;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r28;
//$rhod="123456789.13";
$rmhod=$rm28;
//$rmhod="123456789.13";
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r29;
//$rhod="123456789.13";
$rmhod=$rm29;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r30;
//$rhod="123456789.13";
$rmhod=$rm30;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r31;
//$rhod="123456789.13";
$rmhod=$rm31;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r32;
//$rhod="123456789.13";
$rmhod=$rm32;
//$rmhod="123456789.13";
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r33;
//$rhod="123456789.13";
$rmhod=$rm33;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r34;
//$rhod="123456789.13";
$rmhod=$rm34;
//$rmhod="123456789.13";
$pdf->Cell(150,8," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r35;
//$rhod="123456789.13";
$rmhod=$rm35;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r36;
//$rhod="123456789.13";
$rmhod=$rm36;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r37;
//$rhod="123456789.13";
$rmhod=$rm37;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r38;
//$rhod="123456789.13";
$rmhod=$rm38;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r39;
//$rhod="123456789.13";
$rmhod=$rm39;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r40;
//$rhod="123456789.13";
$rmhod=$rm40;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r41;
//$rhod="123456789.13";
$rmhod=$rm41;
//$rmhod="123456789.13";
$pdf->Cell(150,8," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r42;
//$rhod="123456789.13";
$rmhod=$rm42;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r43;
//$rhod="123456789.13";
$rmhod=$rm43;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r44;
//$rhod="123456789.13";
$rmhod=$rm44;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r45;
//$rhod="123456789.13";
$rmhod=$rm45;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


$rhod=$r46;
//$rhod="123456789.13";
$rmhod=$rm46;
//$rmhod="123456789.13";
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");


//strana 3

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s3.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s3.jpg',0,12,210,298); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//ico
$pdf->Cell(1,4," ","$rmc",1,"C");
$pdf->Cell(12,6," ","$rmc",0,"R");$pdf->Cell(23,6,"IÈO: $fir_fico","$rmc",0,"L");$pdf->Cell(142,6,"strana 3.","$rmc",1,"R");
//položky 3.strana
$pdf->Cell(0,24," ","$rmc",1,"C");


$r47=$hlavicka->r47;
if( $hlavicka->r47 == 0 ) $r47="";
$r48=$hlavicka->r48;
if( $hlavicka->r48 == 0 ) $r48="";
$r49=$hlavicka->r49;
if( $hlavicka->r49 == 0 ) $r49="";
$r50=$hlavicka->r50;
if( $hlavicka->r50 == 0 ) $r50="";
$r51=$hlavicka->r51;
if( $hlavicka->r51 == 0 ) $r51="";
$r52=$hlavicka->r52;
if( $hlavicka->r52 == 0 ) $r52="";
$r53=$hlavicka->r53;
if( $hlavicka->r53 == 0 ) $r53="";
$r54=$hlavicka->r54;
if( $hlavicka->r54 == 0 ) $r54="";
$r55=$hlavicka->r55;
if( $hlavicka->r55 == 0 ) $r55="";
$r56=$hlavicka->r56;
if( $hlavicka->r56 == 0 ) $r56="";
$r57=$hlavicka->r57;
if( $hlavicka->r57 == 0 ) $r57="";
$r58=$hlavicka->r58;
if( $hlavicka->r58 == 0 ) $r58="";
$r59=$hlavicka->r59;
if( $hlavicka->r59 == 0 ) $r59="";
$r60=$hlavicka->r60;
if( $hlavicka->r60 == 0 ) $r60="";
$r61=$hlavicka->r61;
if( $hlavicka->r61 == 0 ) $r61="";
$r62=$hlavicka->r62;
if( $hlavicka->r62 == 0 ) $r62="";
$r63=$hlavicka->r63;
if( $hlavicka->r63 == 0 ) $r63="";
$r64=$hlavicka->r64;
if( $hlavicka->r64 == 0 ) $r64="";
$r65=$hlavicka->r65;
if( $hlavicka->r65 == 0 ) $r65="";
$r66=$hlavicka->r66;
if( $hlavicka->r66 == 0 ) $r66="";
$r67=$hlavicka->r67;
if( $hlavicka->r67 == 0 ) $r67="";
$r68=$hlavicka->r68;
if( $hlavicka->r68 == 0 ) $r68="";
$r69=$hlavicka->r69;
if( $hlavicka->r69 == 0 ) $r69="";
$r70=$hlavicka->r70;
if( $hlavicka->r70 == 0 ) $r70="";
$r71=$hlavicka->r71;
if( $hlavicka->r71 == 0 ) $r71="";

$rm47=$hlavicka->rm47;
if( $hlavicka->rm47 == 0 ) $rm47="";
$rm48=$hlavicka->rm48;
if( $hlavicka->rm48 == 0 ) $rm48="";
$rm49=$hlavicka->rm49;
if( $hlavicka->rm49 == 0 ) $rm49="";
$rm50=$hlavicka->rm50;
if( $hlavicka->rm50 == 0 ) $rm50="";
$rm51=$hlavicka->rm51;
if( $hlavicka->rm51 == 0 ) $rm51="";
$rm52=$hlavicka->rm52;
if( $hlavicka->rm52 == 0 ) $rm52="";
$rm53=$hlavicka->rm53;
if( $hlavicka->rm53 == 0 ) $rm53="";
$rm54=$hlavicka->rm54;
if( $hlavicka->rm54 == 0 ) $rm54="";
$rm55=$hlavicka->rm55;
if( $hlavicka->rm55 == 0 ) $rm55="";
$rm56=$hlavicka->rm56;
if( $hlavicka->rm56 == 0 ) $rm56="";
$rm57=$hlavicka->rm57;
if( $hlavicka->rm57 == 0 ) $rm57="";
$rm58=$hlavicka->rm58;
if( $hlavicka->rm58 == 0 ) $rm58="";
$rm59=$hlavicka->rm59;
if( $hlavicka->rm59 == 0 ) $rm59="";
$rm60=$hlavicka->rm60;
if( $hlavicka->rm60 == 0 ) $rm60="";
$rm61=$hlavicka->rm61;
if( $hlavicka->rm61 == 0 ) $rm61="";
$rm62=$hlavicka->rm62;
if( $hlavicka->rm62 == 0 ) $rm62="";
$rm63=$hlavicka->rm63;
if( $hlavicka->rm63 == 0 ) $rm63="";
$rm64=$hlavicka->rm64;
if( $hlavicka->rm64 == 0 ) $rm64="";
$rm65=$hlavicka->rm65;
if( $hlavicka->rm65 == 0 ) $rm65="";
$rm66=$hlavicka->rm66;
if( $hlavicka->rm66 == 0 ) $rm66="";
$rm67=$hlavicka->rm67;
if( $hlavicka->rm67 == 0 ) $rm67="";
$rm68=$hlavicka->rm68;
if( $hlavicka->rm68 == 0 ) $rm68="";
$rm69=$hlavicka->rm69;
if( $hlavicka->rm69 == 0 ) $rm69="";
$rm70=$hlavicka->rm70;
if( $hlavicka->rm70 == 0 ) $rm70="";
$rm71=$hlavicka->rm71;
if( $hlavicka->rm71 == 0 ) $rm71="";


//súèet B1 až B19
$rhod=$r47;
//$rhod="123456789.13";
$rmhod=$rm47;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//nulove hodnoty
$rhod=$r48;
//$rhod="123456789.13";
$rmhod=$rm48;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//súèet C1.1 až C1.8
$rhod=$r49;
//$rhod="123456789.13";
$rmhod=$rm49;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r50;
//$rhod="123456789.13";
$rmhod=$rm50;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r51;
//$rhod="123456789.13";
$rmhod=$rm51;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r52;
//$rhod="123456789.13";
$rmhod=$rm52;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r53;
//$rhod="123456789.13";
$rmhod=$rm53;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r54;
//$rhod="123456789.13";
$rmhod=$rm54;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r55;
//$rhod="123456789.13";
$rmhod=$rm55;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r56;
//$rhod="123456789.13";
$rmhod=$rm56;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r57;
//$rhod="123456789.13";
$rmhod=$rm57;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//súèet C2.1 až C2.9
$rhod=$r58;
//$rhod="123456789.13";
$rmhod=$rm58;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r59;
//$rhod="123456789.13";
$rmhod=$rm59;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r60;
//$rhod="123456789.13";
$rmhod=$rm60;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r61;
//$rhod="123456789.13";
$rmhod=$rm61;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r62;
//$rhod="123456789.13";
$rmhod=$rm62;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r63;
//$rhod="123456789.13";
$rmhod=$rm63;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r64;
//$rhod="123456789.13";
$rmhod=$rm64;
//$rmhod="123456789.13";
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r65;
//$rhod="123456789.13";
$rmhod=$rm65;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r66;
//$rhod="123456789.13";
$rmhod=$rm66;
//$rmhod="123456789.13";
$pdf->Cell(150,5," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r67;
//$rhod="123456789.13";
$rmhod=$rm67;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//C3
$rhod=$r68;
//$rhod="123456789.13";
$rmhod=$rm68;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r69;
//$rhod="123456789.13";
$rmhod=$rm69;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

$rhod=$r70;
//$rhod="123456789.13";
$rmhod=$rm70;
//$rmhod="123456789.13";
$pdf->Cell(150,6," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//c6
$rhod=$r71;
//$rhod="123456789.13";
$rmhod=$rm71;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//strana 4

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s4.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/dan_z_prijmov2012/cashflow/cashflow2011priama_s4.jpg',0,12,210,298); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//ico
$pdf->Cell(1,4," ","$rmc",1,"C");
$pdf->Cell(12,6," ","$rmc",0,"R");$pdf->Cell(23,6,"IÈO: $fir_fico","$rmc",0,"L");$pdf->Cell(142,6,"strana 4.","$rmc",1,"R");
//položky 4.strana
$pdf->Cell(0,21," ","$rmc",1,"C");


$r72=$hlavicka->r72;
if( $hlavicka->r72 == 0 ) $r72="";
$r73=$hlavicka->r73;
if( $hlavicka->r73 == 0 ) $r73="";
$r74=$hlavicka->r74;
if( $hlavicka->r74 == 0 ) $r74="";
$r75=$hlavicka->r75;
if( $hlavicka->r75 == 0 ) $r75="";
$r76=$hlavicka->r76;
if( $hlavicka->r76 == 0 ) $r76="";
$r77=$hlavicka->r77;
if( $hlavicka->r77 == 0 ) $r77="";
$r78=$hlavicka->r78;
if( $hlavicka->r78 == 0 ) $r78="";
$r79=$hlavicka->r79;
if( $hlavicka->r79 == 0 ) $r79="";
$r80=$hlavicka->r80;
if( $hlavicka->r80 == 0 ) $r80="";


$rm72=$hlavicka->rm72;
if( $hlavicka->rm72 == 0 ) $rm72="";
$rm73=$hlavicka->rm73;
if( $hlavicka->rm73 == 0 ) $rm73="";
$rm74=$hlavicka->rm74;
if( $hlavicka->rm74 == 0 ) $rm74="";
$rm75=$hlavicka->rm75;
if( $hlavicka->rm75 == 0 ) $rm75="";
$rm76=$hlavicka->rm76;
if( $hlavicka->rm76 == 0 ) $rm76="";
$rm77=$hlavicka->rm77;
if( $hlavicka->rm77 == 0 ) $rm77="";
$rm78=$hlavicka->rm78;
if( $hlavicka->rm78 == 0 ) $rm78="";
$rm79=$hlavicka->rm79;
if( $hlavicka->rm79 == 0 ) $rm79="";
$rm80=$hlavicka->rm80;
if( $hlavicka->rm80 == 0 ) $rm80="";

//C7
$rhod=$r72;
//$rhod="123456789.13";
$rmhod=$rm72;
//$rmhod="123456789.13";
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//C8
$rhod=$r73;
//$rhod="123456789.13";
$rmhod=$rm73;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//C9
$rhod=$r74;
//$rhod="123456789.13";
$rmhod=$rm74;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//súèet C1 až C9
$rhod=$r75;
//$rhod="123456789.13";
$rmhod=$rm75;
//$rmhod="123456789.13";
$pdf->Cell(150,0," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//D
$rhod=$r76;
//$rhod="123456789.13";
$rmhod=$rm76;
//$rmhod="123456789.13";
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//E
$rhod=$r77;
//$rhod="123456789.13";
$rmhod=$rm77;
//$rmhod="123456789.13";
$pdf->Cell(150,4," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//F
$rhod=$r78;
//$rhod="123456789.13";
$rmhod=$rm78;
//$rmhod="123456789.13";
$pdf->Cell(150,7," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//G
$rhod=$r79;
//$rhod="123456789.13";
$rmhod=$rm79;
//$rmhod="123456789.13";
$pdf->Cell(150,9," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//H
$rhod=$r80;
//$rhod="123456789.13";
$rmhod=$rm80;
//$rmhod="123456789.13";
$pdf->Cell(150,8," ","$rmc",1,"R");
$pdf->Cell(121,6," ","$rmc",0,"R");$pdf->Cell(28,6,"$rhod","$rmc",0,"R");$pdf->Cell(28,6,"$rmhod","$rmc",1,"R");

//Zostavené dòa
$pdf->Cell(0,10," ","$rmc",1,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(25,7,"Zostavené dòa: $h_zos","$rmc",1,"L");

//Schválené dòa
$pdf->Cell(0,10," ","$rmc",1,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(25,6,"Schválené dòa: $h_sch","$rmc",1,"L");



}
$i = $i + 1;

  }

?>