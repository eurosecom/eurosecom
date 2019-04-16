<HTML>
<?php
$sys = 'FAK';
$urov = 1;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = $_REQUEST['cislo_dok'];
$cislo_ico = 1*$_REQUEST['cislo_ico'];

//echo $copern;
//exit;
?>
<?php

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/obalka_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/obalka_".$kli_uzid."_".$cislo_dok."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


if( $copern == 10 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
}

if( $copern == 11 )
{
//mala obalka 164x114mm palce 6.5x4.5, stredna obalka 219x109mm palce 8.6x4.3

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_icoobalka$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odosl=$riaddok->odosl;
  $poox1=$riaddok->poox1;
  $pooy1=$riaddok->pooy1;
  $titlx=$riaddok->titlx;
  $komux=$riaddok->komux;
  $obalx=$riaddok->obalx;
  $pozx1=$riaddok->pozx1;
  $pozy1=$riaddok->pozy1;
  $pozx2=$riaddok->pozx2;
  $pozy2=$riaddok->pozy2;
  $pozx3=$riaddok->pozx3;
  $pozy3=$riaddok->pozy3;
  }

$sirka_vyska="130,240";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("L","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();

$poziciax=1*$pozx1;
$poziciay=1*$pozy1;

}
//koniec copern=11

if( $drupoh == 1 )
{
$tabl = "fakodb";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakodb";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
if( $pocstav == 1 ) $tabl = "fakodbpoc";
}

if( $drupoh == 31 )
{
$tabl = "dopfak";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopfak";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 11 )
{
$tabl = "fakdol";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakdol";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 12 )
{
$tabl = "dopdol";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopdol";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 21 )
{
$tabl = "fakvnp";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakvnp";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 22 )
{
$tabl = "dopvnp";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopvnp";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 42 )
{
$tabl = "dopreg";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopreg";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$citreg = include("../doprava/citaj_reg.php");
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 52 )
{
$tabl = "dopprf";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "fakprf";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 2 )
{
$tabl = "fakdod";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakdod";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Dodávate¾";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
if( $pocstav == 1 ) $tabl = "fakdodpoc";
}


if ( $copern == 10 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if ( $copern == 11 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $cislo_ico ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $hlavicka=mysql_fetch_object($sql);

if ( $copern == 10 )
{
$pdf->Cell(180,12,"     ","0",1,"L");
$pdf->Cell(180,12,"     ","0",1,"L");
$pdf->Cell(180,12,"     ","0",1,"L");
$pdf->Cell(180,6,"     ","0",1,"L");

$pdf->Cell(80,5," ","0",0,"L");$pdf->Cell(90,5,"Odosielate¾:","0",1,"L");
$pdf->Cell(80,5," ","0",0,"L");$pdf->Cell(90,5,"$fir_fnaz ","0",1,"L");
$pdf->Cell(80,5," ","0",0,"L");$pdf->Cell(90,5,"$fir_fuli $fir_fcdm","0",1,"L");
$pdf->Cell(80,5," ","0",0,"L");$pdf->Cell(90,5,"$fir_fpsc $fir_fmes","0",1,"L");


$pdf->Cell(180,12,"     ","0",1,"L");
$pdf->Cell(180,6,"     ","0",1,"L");
$pdf->SetFont('arial','',12);

$pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"","0",1,"L");
$pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->nai ","0",1,"L");
$na2=str_replace(" ","",$hlavicka->na2);
$na2dlzka=strlen($na2);
if( $na2dlzka > 5 ) { $pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->na2 ","0",1,"L"); }
$pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->uli","0",1,"L");
$pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->mes","0",1,"L");
$pdf->Cell(190,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->psc","0",1,"L");
}

if ( $copern == 11 )
{

$pdf->SetFont('arial','',10);

  if ( $odosl == 1 )
  {
  $pdf->SetY($pooy1);
  $pdf->SetX($poox1);$pdf->Cell(90,5,"Odosielate¾: $fir_fnaz ","0",1,"L");
  $pdf->SetX($poox1);$pdf->Cell(90,5,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","0",1,"L");
  }

$pdf->SetFont('arial','',12);
$pdf->SetY($poziciay);
$pdf->SetX($poziciax);$pdf->Cell(90,6,"$hlavicka->nai ","0",1,"L");
$na2=str_replace(" ","",$hlavicka->na2);
$na2dlzka=strlen($na2);
if( $na2dlzka > 5 ) { $pdf->SetX($poziciax);$pdf->Cell(90,6,"$hlavicka->na2 ","0",1,"L"); }
$pdf->SetX($poziciax);$pdf->Cell(90,6,"$hlavicka->uli","0",1,"L");
$pdf->SetX($poziciax);$pdf->Cell(90,6,"$hlavicka->mes","0",1,"L");
$pdf->SetX($poziciax);$pdf->Cell(90,6,"$hlavicka->psc","0",1,"L");
}

  }
//koniec hlavicky


$pdf->Output("$outfilex");


?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Obalka PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Obalka <?php echo $cislo_dok;?> PDF formát</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 



?>

<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
