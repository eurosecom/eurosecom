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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>��seln�k mzdov�ch zlo�iek</title>
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
<td>EuroSecom  -  ��seln�k mzdov�ch zlo�iek 

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




$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddmn".
" WHERE dm != 0 ORDER BY dm";



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

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"��seln�k mzdov�ch zlo�iek","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(10,6,"DM","LRB",0,"R");$pdf->Cell(40,6,"N�zov","LRB",0,"L");
$pdf->Cell(10,6,"DN","LRB",0,"R");
$pdf->Cell(10,6,"ZP","LRB",0,"R");
$pdf->Cell(10,6,"NP","LRB",0,"R");
$pdf->Cell(10,6,"SP","LRB",0,"R");
$pdf->Cell(10,6,"IP","LRB",0,"R");
$pdf->Cell(10,6,"PvN","LRB",0,"R");
$pdf->Cell(10,6,"UP","LRB",0,"R");
$pdf->Cell(10,6,"GF","LRB",0,"R");
$pdf->Cell(10,6,"RF","LRB",0,"R");
$pdf->Cell(10,6,"PN","LRB",0,"R");
$pdf->Cell(10,6,"PM","LRB",0,"R");
$pdf->Cell(10,6,"SF","LRB",0,"R");
$pdf->Cell(0,6,"sa-ko-sax","1",1,"R");

     }
//koniec hlavicky j=0





$pdf->SetFont('arial','',7);

$pdf->Cell(10,6,"$riadok->dm","0",0,"R");$pdf->Cell(40,6,"$riadok->nzdm","0",0,"L");
$pdf->Cell(10,6,"$riadok->td","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_zp","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_np","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_sp","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_ip","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_pn","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_up","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_gf","0",0,"R");
$pdf->Cell(10,6,"$riadok->nap_rf","0",0,"R");
$pdf->Cell(10,6,"$riadok->prn","0",0,"R");
$pdf->Cell(10,6,"$riadok->prm","0",0,"R");
$pdf->Cell(10,6,"$riadok->prs","0",0,"R");
$pdf->SetFont('arial','',6);
$sadzba=1*$riadok->sa;
$pdf->Cell(0,6,"$sadzba-$riadok->ko-$riadok->sax","0",1,"R");



}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }

$pdf->Cell(0,6," ","0",1,"R");
$pdf->Cell(0,6,"DN = v�po�et dane z pr�jmov z tejto mzdovej zlo�ky 0=po��ta� da�, 1=nepo��ta� da� ","0",1,"L");
$pdf->Cell(0,6,"ZP = v�po�et ZP z tejto mzdovej zlo�ky 1=po��ta� ZP, 0=nepo��ta� ZP ","0",1,"L");
$pdf->Cell(0,6,"NP,SP,IP,PvN,UP,GF,RF = v�po�et pr�slu�n�ho fondu SP z tejto mzdovej zlo�ky 1=po��ta� fond, 0=nepo��ta� fond ","0",1,"L");
$pdf->Cell(0,6,"PN = 1 po��ta� z mzdovej zlo�ky priemer na n�hrady","0",1,"L");
$pdf->Cell(0,6,"PM = 1 po��ta� z mzdovej zlo�ky priemer na nemocensk�","0",1,"L");
$pdf->Cell(0,6,"PS = 1 po��ta� z mzdovej zlo�ky soci�lny fond","0",1,"L");
$pdf->Cell(0,6,"SA Sadzba � na hodinu pre KO=40, Ko�ko % z priemeru na n�hrady z kme�ov�ch �dajov pre KO=20, Ko�ko % zo sadzby z kme�ov�ch �dajov pre KO=30","0",1,"L");
$pdf->Cell(0,6,"KO Koeficient KO = 20 sadzba=priemer na n�hrady z kme�ov�ch �dajov, KO = 30 sadzba=sadzba z kme�ov�ch �dajov,","0",1,"L");
$pdf->Cell(0,6,"KO = 40 sadzba=hodnota v sadzbe z ��seln�ka miezd, KO = 50 sadzba=sadzba a mno�stvo z tabu�ky mzdov�ch sadzieb, KO = 60 sadzba=priemer na nemoc. z kme�ov�ch �dajov","0",1,"L");
$pdf->Cell(0,6,"SAX ��slo sadzby  z kme�ov�ch �dajov ak KO=30/39","0",1,"L");

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
