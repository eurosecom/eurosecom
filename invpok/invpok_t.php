<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1;

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlač inventúry pokladne</title>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
</HEAD>
<BODY class="white" >
<table class="h2" width="100%">
<tr><td>EuroSecom - Inventúrny súpis pokladne - TLAČ</td></tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdtlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdtlac$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_invpok".
" WHERE xdok = $cislo_dok ORDER BY xdatm ";
  }

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


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10); 

$skinvdat=SkDatum($riadok->invdat);
$skinvdatzac=SkDatum($riadok->invdatzac);
$skinvdatskc=SkDatum($riadok->invdatskc);

$pdf->SetFont('arial','',12);
$pdf->Cell(90,6,"Inventúrny súpis pokladne","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(0,6,"FIR$kli_vxcf $kli_nxcf","RTB",1,"R");

$pdf->Cell(190,7,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Číslo:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(20,5,"$cislo_dok","$rmc",0,"L");$pdf->Cell(30,5," ","$rmc",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(40,5,"Dátum:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(45,5,"$skinvdat","$rmc",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(10,5,"Mena:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(15,5,"EUR","$rmc",1,"L");



$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Pokladňa:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(20,5,"$riadok->invucet","$rmc",0,"L");$pdf->Cell(30,5," ","$rmc",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(40,5,"Miesto uloženia pokladne:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(65,5,"$riadok->invmulz","$rmc",1,"L");

$pdf->Cell(190,3,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Deň začatia inventúry:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(20,5,"$skinvdatzac","$rmc",0,"L");$pdf->Cell(30,5," ","$rmc",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(40,5,"Osoba hmotne zodpovedná:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(65,5,"$riadok->invohz","$rmc",1,"L");

$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Deň skončenia inventúry:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(20,5,"$skinvdatskc","$rmc",0,"L");$pdf->Cell(30,5," ","$rmc",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(40,5,"Zodpovedná za vykonanie:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(65,5,"$riadok->invozv","$rmc",1,"L");
//$pdf->Cell(125,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$riadok->invozv","$rmc",1,"L");

$pdf->Cell(190,15,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Stav pokladne:","$rmc",0,"L");
$pdf->SetFont('arial','B',11);
$pdf->Cell(20,5,"$riadok->invstav","$rmc",0,"L");$pdf->Cell(140,5," ","$rmc",1,"L");

$pdf->Cell(190,3,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Skutočný stav:","$rmc",0,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(30,5,"Nominálna hodnota","TLB",0,"C");$pdf->Cell(30,5,"Počet kusov","TLB",0,"C");$pdf->Cell(30,5,"Suma","TRLB",1,"C");

$pdf->SetFont('arial','',10);
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"500 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks500e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma500e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"200 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks200e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma200e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"100 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks100e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma100e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"50 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks50e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma50e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"20 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks20e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma20e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"10 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks10e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma10e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"5 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks5e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma5e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"2 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks2e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma2e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"1 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks1e ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma1e ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,50 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks50ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma50ec ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,20 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks20ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma20ec ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,10 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks10ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma10ec ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,05 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks5ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma5ec ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,02 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks2ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma2ec ","1",1,"R");
$pdf->Cell(35,5," ","$rmc",0,"L");
$pdf->Cell(30,6,"0,01 ","1",0,"R");$pdf->Cell(30,6,"$riadok->ks1ec ","1",0,"R");$pdf->Cell(30,6,"$riadok->suma1ec ","1",1,"R");
$pdf->SetFont('arial','B',11);
$pdf->Cell(35,5," ","$rmc",0,"L");$pdf->Cell(60,5," ","$rmc",0,"R");$pdf->Cell(30,8,"$riadok->sumaspolu","$rmc",1,"R");

$pdf->Cell(190,15,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(35,5,"Rozdiel:","$rmc",0,"L");
$pdf->SetFont('arial','B',11);
$pdf->Cell(30,5,"$riadok->invrozdiel","$rmc",1,"L");

     }
//koniec hlavicky j=0

}
$i = $i + 1;
$j = $j + 1;

  }

if( $alchem == 1 )
    {

if( $riadok->invrozdiel == 0 )
  {
$pdf->Cell(30,5,"Alchem text suhlasi","$rmc",1,"L");
  }

if( $riadok->invrozdiel != 0 )
  {
$pdf->Cell(30,5,"Alchem text nesuhlasi","$rmc",1,"L");
  }

    }


$pdf->Output("../tmp/mzdtlac.$kli_uzid.pdf"); 


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdtlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
       
<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
