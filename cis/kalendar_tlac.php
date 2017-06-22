<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 2000;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$premenna = $_REQUEST['premenna'];


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


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlac</title>
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
<td>EuroSecom  -  Kalendár

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM $mysqldb2017.kalendar ORDER BY dat DESC ";

//dat  ume  akyden  svt  rok2012  rok2011  rok2010  nedo  neod  sodo  sood  m012012  


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

if( $j == 0 )  { 


$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,4,"Kalendár ","LTB",0,"L"); 
$pdf->Cell(0,4,"strana $strana ","RTB",1,"R");

$pdf->SetFont('arial','',6);

$pdf->Cell(15,4,"Dátum","1",0,"L");
$pdf->Cell(15,4,"Ume","1",0,"L");
$pdf->Cell(15,4,"Po-Ne/1-7","1",0,"L");
$pdf->Cell(15,4,"Sviatok=1","1",0,"L");
$pdf->Cell(15,4,"SoDo","1",0,"L");
$pdf->Cell(15,4,"SoOd","1",0,"L");
$pdf->Cell(15,4,"NeDo","1",0,"L");
$pdf->Cell(15,4,"NeOd","1",0,"L");

$pdf->Cell(0,4," ","1",1,"L");

}


$pdf->Cell(15,4,"$riadok->dat","0",0,"L");
$pdf->Cell(15,4,"$riadok->ume","0",0,"L");
$pdf->Cell(15,4,"$riadok->akyden","0",0,"L");
$pdf->Cell(15,4,"$riadok->svt","0",0,"L");
$pdf->Cell(15,4,"$riadok->sodo","0",0,"L");
$pdf->Cell(15,4,"$riadok->sood","0",0,"L");
$pdf->Cell(15,4,"$riadok->nedo","0",0,"L");
$pdf->Cell(15,4,"$riadok->neod","0",0,"L");


$pdf->Cell(0,4," ","0",1,"L");
$pdf->Cell(0,1," ","T",1,"L");
}
$i=$i+1;
$j=$j+1;
if( $j >= 48 ) $j=0;
  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
