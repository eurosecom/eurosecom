<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$typ = $_REQUEST['typ'];

//echo $cislo_dok;

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


//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$obddph="";
if( $fir_uctx01 == 2 ) {
$kli_mdph="";
if( $mesp_dph >= 1 AND $mesp_dph <= 3) { $mesp_dph=1; $mesk_dph=3; $obddph="1"; }
if( $mesp_dph >= 4 AND $mesp_dph <= 6) { $mesp_dph=4; $mesk_dph=6; $obddph="2"; }
if( $mesp_dph >= 7 AND $mesp_dph <= 9) { $mesp_dph=7; $mesk_dph=9; $obddph="3"; }
if( $mesp_dph >= 10 AND $mesp_dph <= 12) { $mesp_dph=10; $mesk_dph=12; $obddph="4"; }
                       }

if( $fir_uctx01 == 4 ) {
$kli_mdph="";
$mesp_dph=1; $mesk_dph=12; $obddph="5";
                       }

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;

//exit;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Platby pre uplatnenie DPH</title>
  <style type="text/css">

  </style>

<script type="text/javascript">

    


</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Platby pre uplatnenie DPH 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if( $copern == 40 ) {

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsubpdf="../tmp/prijplatby_".$idx.".pdf";


if (File_Exists ("$nazsubpdf")) { $soubor = unlink("$nazsubpdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$sqltt = "DROP TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE prx7 = 0 AND dpp >= '$datp_dph' AND dpp <= '$datk_dph' ";
$sql = mysql_query("$sqltt");


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdphs$kli_uzid WHERE dok > 0 ORDER BY dok,dou ";

//echo $sqltt;
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
$dat_sk=SkDatum($riadok->dat);

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$datpsk=SkDatum($datp_dph);
$datksk=SkDatum($datk_dph);

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Platby pre uplatnenie DPH od $datpsk do $datksk","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(26,6,"Daòový doklad","LRB",0,"R");
$pdf->Cell(20,6,"Doklad úhrady","LRB",0,"R");
$pdf->Cell(20,6,"Dát.úhrady","LRB",0,"L");
$pdf->Cell(20,6,"Dát.uplatnenia","LRB",0,"L");
$pdf->Cell(20,6,"Uhradené","LRB",0,"R");
$pdf->Cell(20,6,"Základ $fir_dph2%","LRB",0,"R");
$pdf->Cell(20,6,"Upl.DPH $fir_dph2%","LRB",0,"R");
$pdf->Cell(20,6,"Základ $fir_dph1%","LRB",0,"R");
$pdf->Cell(0,6,"Upl.DPH $fir_dph1%","LRB",1,"R");


     }
//koniec hlavicky j=0



$dausk=SkDatum($riadok->dau);
$dppsk=SkDatum($riadok->dpp);

$pdf->SetFont('arial','',7);

$pdf->Cell(26,6,"$riadok->dok","0",0,"R");
$pdf->Cell(20,6,"$riadok->dou","0",0,"R");
$pdf->Cell(20,6,"$dausk","0",0,"L");
$pdf->Cell(20,6,"$dppsk","0",0,"L");
$pdf->Cell(20,6,"$riadok->hou","0",0,"R");
$pdf->Cell(20,6,"$riadok->hz2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hd2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hz1","0",0,"R");
$pdf->Cell(0,6,"$riadok->hd1","0",1,"R");



}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }

$pdf->Cell(0,6," ","0",1,"R");


$pdf->Output("$nazsubpdf");


$sqltt = "DROP TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." ";
$sql = mysql_query("$sqltt");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $nazsubpdf; ?>","_self");
</script>

?>

<?php
//koniec copern=40 tlac zoznamu
             }


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
