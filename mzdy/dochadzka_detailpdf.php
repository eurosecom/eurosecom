<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 100;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_oc = 1*$_REQUEST['cislo_oc'];



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

//udaje o zamestnancovi
$sqlttz = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc  ";
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $prie=$riadok->prie;
  $meno=$riadok->meno;
  $pom=$riadok->pom;
  $uva=1*$riadok->uva;
  }

$nepret=1;
$uvatyp=8;
if( $uva >= 10 ) { $uvatyp=12; }


$dm_nad=201; $dm_so=202; $dm_ne=203; $dm_sv=204; $dm_nc=223; 
$den12_od="06:00"; $noc12_od="18:00"; $rano8_od="06:00"; $poob8_od="14:00"; $nocn8_od="22:00";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddochadzkasetpripl ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dm_nad=1*$riaddok->dm_nad;
  $dm_so=1*$riaddok->dm_so;
  $dm_ne=1*$riaddok->dm_ne;
  $dm_sv=1*$riaddok->dm_sv;
  $dm_nc=1*$riaddok->dm_nc;
  $den12_od=$riaddok->den12_od;
  $noc12_od=$riaddok->noc12_od;

  $rano8_od=$riaddok->rano8_od;
  $poob8_od=$riaddok->poob8_od;
  $nocn8_od=$riaddok->nocn8_od;
  }


$pra=$rano8_od; $ppo=$poob8_od; $pno=$nocn8_od;
if( $uvatyp == 12 ) { $pra=$den12_od; $ppo=$noc12_od; $pno=$noc12_od; }


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dochádzka PDF</title>
  <style type="text/css">
  </style>

<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Dochádzka PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/doch_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/doch_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka$kli_uzid ".
" WHERE oc = $cislo_oc AND ume = $kli_vume ORDER BY oc,daod ";
//echo $sqltt;

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
if ( $copern == 30 )  { $pdf->Cell(90,6,"Dochádzka $kli_vume osè.$cislo_oc - $prie $meno","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf","RTB",1,"R");

$pdf->SetFont('arial','',6);

$pdf->Cell(25,5,"Dátum","1",0,"R");
$pdf->Cell(50,5,"Odpracované hodiny","1",0,"R");
$pdf->Cell(80,5,"Neprítomnosti","1",0,"L");
$pdf->Cell(20,5,"Nad $dm_nad","1",0,"R");$pdf->Cell(20,5,"So $dm_so","1",0,"R");
$pdf->Cell(20,5,"Ne $dm_ne","1",0,"R");$pdf->Cell(20,5,"Sv $dm_sv","1",0,"R");
$pdf->Cell(20,5,"Noc $dm_nc","1",0,"R");$pdf->Cell(0,5," ","1",1,"R");


     }
//koniec hlavicky j=0


$textden="Po";
if( $riadok->akyden == 1 ) { $textden="Po"; } 
if( $riadok->akyden == 2 ) { $textden="Út"; } 
if( $riadok->akyden == 3 ) { $textden="St"; } 
if( $riadok->akyden == 4 ) { $textden="Št"; } 
if( $riadok->akyden == 5 ) { $textden="Pi"; } 

if( $riadok->akyden == 6 ) { $textden="So"; } 
if( $riadok->akyden == 7 ) { $textden="* Ne"; }   
if( $riadok->svt == 1 ) { $textden="Sv ".$textden; } 

$daodsk=SkDatum($riadok->daod);

$pdf->SetFont('arial','',7);

$pdf->Cell(25,5,"$textden $daodsk","B",0,"R");

$riadok=$i + 1;
$kli_den=$riadok.".".$kli_vume; 
$kli_den_sql=$kli_vrok."-".$kli_vmes."-".$riadok;

$polozkax->psob=0; $polozkax->pned=0; $polozkax->psvt=0; $polozkax->pnoc=0; $polozkax->hodxb=""; $cashodmin=""; $hodin="";

$sqlttx = "SELECT * FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND ume = $kli_vume AND daod = '$kli_den_sql' AND dmxa = 1 ORDER BY oc,daod ";
//echo $sqlttx;
$sqlx = mysql_query("$sqlttx");
$polx = 1*mysql_num_rows($sqlx);

$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix))
{
$polozkax=mysql_fetch_object($sqlx);


  list ($datum, $cas) = split ('[ ]', $polozkax->datn, 2);
  list ($cashod, $casmin, $cassek) = split ('[:]', $cas, 3);
  $cashodmin = "zaè. ".sprintf("%02d:%02d", $cashod, $casmin);
  $hodin = "- ".$polozkax->hodxb." hod.";


}
$ix = $ix + 1;
  }

$pdf->Cell(50,5,"$cashodmin $hodin","B",0,"R");


$nepritomnosti="";
$sqlttx2 = "SELECT * FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND ume = $kli_vume AND daod = '$kli_den_sql' AND dmxa >= 500 ORDER BY oc,daod,dmxa ";
//echo $sqlttx2;
$sqlx2 = mysql_query("$sqlttx2");
$polx2 = 1*mysql_num_rows($sqlx2);

$ix2=0;
  while ($ix2 <= $polx2 )
  {
  if (@$zaznamx=mysql_data_seek($sqlx2,$ix2))
{
$polozkax2=mysql_fetch_object($sqlx2);


$nepritomnosti=$nepritomnosti." DM ".$polozkax2->dmxa." - ".$polozkax2->hodxb." hod.";


}
$ix2 = $ix2 + 1;
  }


$pdf->Cell(80,5,"$nepritomnosti","B",0,"L");

$psob=$polozkax->psob;
if( $psob == 0 ) { $psob=""; }
$pned=$polozkax->pned;
if( $pned == 0 ) { $pned=""; }
$psvt=$polozkax->psvt;
if( $psvt == 0 ) { $psvt=""; }
$pnoc=$polozkax->pnoc;
if( $pnoc == 0 ) { $pnoc=""; }

$pdf->Cell(20,5," ","B",0,"R");$pdf->Cell(20,5,"$psob","B",0,"R");
$pdf->Cell(20,5,"$pned","B",0,"R");$pdf->Cell(20,5,"$psvt","B",0,"R");
$pdf->Cell(20,5,"$pnoc","B",0,"R");$pdf->Cell(0,5," ","B",1,"R");


}
$i = $i + 1;
$j = $j + 1;

  }


$sumhod=0; $sumpndc=0; $sumpsob=0; $sumpned=0; $sumpsvt=0; $sumpnoc=0;
$sqlttz = "SELECT oc, dmxa, SUM(hodxb) AS sumhodxb, SUM(pndc) AS sumpndc, SUM(psob) AS sumpsob, SUM(pned) AS sumpned, SUM(psvt) AS sumpsvt, ".
" SUM(pnoc) AS sumpnoc FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc ";
//echo $sqlttz;
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $sumhod=$riadok->sumhodxb;
  $sumpndc=$riadok->sumpndc;
  $sumpsob=$riadok->sumpsob;
  $sumpned=$riadok->sumpned;
  $sumpsvt=$riadok->sumpsvt;
  $sumpnoc=$riadok->sumpnoc;

  }

$sumnep=0;
$sqlttz = "SELECT oc, dmxa, SUM(hodxb) AS sumhodxb FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa >= 500 GROUP BY oc ";
//echo $sqlttz;
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $sumnep=$riadok->sumhodxb;

  }

$pdf->Cell(25,5,"Celkom","1",0,"R");
$pdf->Cell(50,5,"odpracované $sumhod hod.","1",0,"R");
$pdf->Cell(80,5,"náhrady $sumnep; hod.","1",0,"L");
$pdf->Cell(20,5,"$sumpndc","1",0,"R");$pdf->Cell(20,5,"$sumpsob","1",0,"R");
$pdf->Cell(20,5,"$sumpned","1",0,"R");$pdf->Cell(20,5,"$sumpsvt","1",0,"R");
$pdf->Cell(20,5,"$sumpnoc","1",0,"R");$pdf->Cell(0,5," ","1",1,"R");

$pdf->Output("$outfilex");


?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
