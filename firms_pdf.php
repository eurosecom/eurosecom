<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 15000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if ( $newdelenie == 1 )
          {
$dtb2 = include("oddel_dtb3new.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$hladanie = 1*$_REQUEST['hladanie'];
$cohladat = trim($_REQUEST['cohladat']);
if( $cohladat == '' ){ $hladanie=0; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Číselník firiem</title>

<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom
</tr>
</table>
<br />

<?php
if (File_Exists ("tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','fpdf/font/');
   require('fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM fir WHERE xcf >= 0 ORDER BY xcf ";
if( $hladanie == 1 )
{
$sqltt = "SELECT * FROM fir WHERE  xcf >= 0  AND ( naz LIKE '%$cohladat%' OR rok LIKE '%$cohladat%' ) ORDER BY xcf ";
}
//echo $sqltt;
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


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
$pdf->Cell(90,6,"Firmy","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);


$pdf->Cell(20,6,"číslo","1",0,"R");$pdf->Cell(80,6,"nazov","1",0,"L");
$pdf->Cell(0,6,"rok","1",1,"L");

     }
//koniec hlavicky j=0



$pdf->SetFont('arial','',8);

$pdf->Cell(20,6,"$riadok->xcf","0",0,"R");
$pdf->Cell(80,6,"$riadok->naz","0",0,"L");
$pdf->Cell(0,6,"$riadok->rok","0",1,"L");
$pdf->Cell(0,1," ","B",1,"L");

}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }




$pdf->Output("tmp/podklad.$kli_uzid.pdf");

?> 

<script type="text/javascript">
  var okno = window.open("tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
