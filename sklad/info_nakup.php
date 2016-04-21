<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$cslm=403201;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_skl = 1*$_REQUEST['cislo_skl'];



  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Informácie o nákupoch PDF</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Informácie o nákupoch 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/nakup$kli_uzid.pdf")) { $soubor = unlink("../tmp/nakup$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 20 OR $copern == 10 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   dok         INT,
   ico         DECIMAL(10,0),
   fak         DECIMAL(10,0),
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hod         DECIMAL(10,2),
   vdj         DECIMAL(10,3),
   prj         DECIMAL(10,3),
   pcs         DECIMAL(10,3)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

     }
//koniec copern 10,20


if ( $copern == 10 )
    {

//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,dok,ico,fak,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//vypocitaj hodnotu
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET hod=zas*cen";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");

//sumy

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 9,ume,dat,skl,dok,ico,fak,cis,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY cis".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 10,ume,dat,99999999,dok,ico,fak,999999999999999,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE pox = 9 GROUP BY pox ".
"";
$dsql = mysql_query("$dsqlt");

     }
//koniec copern=10


if ( $copern == 20 )
    {

//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,ume,dat,skl,dok,ico,fak,cis,mno,cen,(mno),'0','0','0',0 FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND ume <= $kli_vume )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//vypocitaj hodnotu
$sqlt = "UPDATE F".$kli_vxcf."_sklprcd".$kli_uzid." SET hod=zas*cen";
//echo $sqlt;
$vysledok = mysql_query("$sqlt");

//sumy

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 9,ume,dat,skl,dok,ico,fak,cis,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" GROUP BY ico".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 10,ume,dat,99999999,dok,9999999999,fak,999999999999999,SUM(mno),cen,SUM(zas),SUM(hod),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprcd$kli_uzid ".
" WHERE pox = 9 GROUP BY pox ".
"";
$dsql = mysql_query("$dsqlt");

     }
//koniec copern=20


$neparne=1;

//exit;

if ( $copern == 10 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE hod != 0".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.cis,pox,F$kli_vxcf"."_sklprcd$kli_uzid.dok";

//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 10 )  { $pdf->Cell(90,6,"Nákup zásob pod¾a materiálu $kli_vume ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(15,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"MAT","1",0,"R");$pdf->Cell(80,5,"Dodávate¾","1",0,"L");
$pdf->Cell(20,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Príjem MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");

     }
//koniec hlavicky j=0


if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',7);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(15,5,"$riadok->dok","0",0,"R");$pdf->Cell(20,5,"$riadok->cis","0",0,"R");$pdf->Cell(80,5,"$riadok->nai $riadok->mes","0",0,"L");
$pdf->Cell(20,5,"$riadok->cen","0",0,"R");$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->mno","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

}


if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM MAT $riadok->cis $riadok->nat","T",0,"L");
$pdf->Cell(20,5,"$riadok->mno","T",0,"R");$pdf->Cell(0,5,"$riadok->hod","T",1,"R");
$pdf->Cell(0,5," ","T",1,"R");
$j = $j + 1;
}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM všetok materiál ","1",0,"L");
$pdf->Cell(0,5,"$riadok->hod","1",1,"R");
$j=-1;
}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }

     }
//koniec copern=10

if ( $copern == 20 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE hod != 0".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.ico,pox,F$kli_vxcf"."_sklprcd$kli_uzid.cis,F$kli_vxcf"."_sklprcd$kli_uzid.dok";

//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 20 )  { $pdf->Cell(90,6,"Nákup zásob pod¾a dodávate¾a $kli_vume ","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);

$pdf->Cell(15,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"ICO","1",0,"R");$pdf->Cell(80,5,"Materiál","1",0,"L");
$pdf->Cell(20,5,"Cena za MJ","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(20,5,"Príjem MJ","1",0,"R");$pdf->Cell(0,5,"Hodnota","1",1,"R");

     }
//koniec hlavicky j=0


if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',7);

if( $sZostatok == '0' ) $sZostatok="";

$pdf->Cell(15,5,"$riadok->dok","0",0,"R");$pdf->Cell(20,5,"$riadok->ico","0",0,"R");$pdf->Cell(80,5,"$riadok->cis $riadok->nat","0",0,"L");
$pdf->Cell(20,5,"$riadok->cen","0",0,"R");$pdf->Cell(10,5,"$riadok->mer","0",0,"L");
$pdf->Cell(20,5,"$riadok->mno","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

}


if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM IÈO $riadok->ico $riadok->nai $riadok->mes ","T",0,"L");
$pdf->Cell(20,5,"$riadok->mno","T",0,"R");$pdf->Cell(0,5,"$riadok->hod","T",1,"R");
$pdf->Cell(0,5," ","T",1,"R");
$j = $j + 1;
}

if( $riadok->pox == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(145,5,"CELKOM všetci dodávatelia ","1",0,"L");
$pdf->Cell(0,5,"$riadok->hod","1",1,"R");
$j=-1;
}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }

     }
//koniec copern=20

$pdf->Output("../tmp/nakup.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/nakup.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
