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

$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_uce = 1*$_REQUEST['cislo_uce'];

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


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>História spracovania</title>
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
<td>EuroSecom  -  História spracovania 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/hist_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/hist_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdsprclog WHERE osneos > 0 ORDER BY datm DESC ";
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

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"História ostrého spracovania ","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(20,6,"id","LRB",0,"R");$pdf->Cell(20,6,"ume","LRB",0,"L");$pdf->Cell(30,6,"1=sprac, 2=zruš","LRB",0,"L");$pdf->Cell(0,6,"datm","LRB",1,"L");

     }
//koniec hlavicky j=0





$pdf->SetFont('arial','',8);

$pdf->Cell(20,6,"$riadok->kliuzid","RB",0,"R");
$pdf->Cell(20,6,"$riadok->ume","RB",0,"L");
$pdf->Cell(30,6,"$riadok->osneos","RB",0,"L");
$pdf->Cell(0,6,"$riadok->datm","B",1,"L");


}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }



$pdf->Output("$outfilex");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

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
