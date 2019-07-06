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
<title>Deti</title>
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
<td>EuroSecom  -  Zoznam detí zamestnancov 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dan_bonus=$riaddok->dan_bonus;
  }

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/deti_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/deti_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$vsql = "DROP TABLE F".$kli_vxcf."_deti$kli_uzid ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_deti$kli_uzid SELECT * FROM F$kli_vxcf"."_mzddeti WHERE cpl > 0 ";
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid MODIFY p1 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid MODIFY p2 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid MODIFY p3 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid MODIFY p4 DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid ADD dbj DECIMAL(4,0) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid ADD dbn DECIMAL(7,2) DEFAULT 0 AFTER dbj";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid ADD das DATE DEFAULT '0000-00-00' AFTER dbn ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid ADD pcm DECIMAL(4,0) DEFAULT 0 AFTER das";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_deti$kli_uzid ADD rok DECIMAL(4,0) DEFAULT 0 AFTER pcm";
$vysledek = mysql_query("$sql");

$das=$kli_vrok."-".$kli_vmes."-01";

$sql = "UPDATE F$kli_vxcf"."_deti$kli_uzid SET dbj=1, das='".$das."', p1=0, p2=0, p3=0, p4=0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_deti$kli_uzid SET pcm=TIMESTAMPDIFF(MONTH, dr, das) WHERE dr != '0000-00-00' AND das != '0000-00-00' ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_deti$kli_uzid SET dbj=2 WHERE pcm < 72 AND dr != '0000-00-00' ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_deti$kli_uzid SET dbn=$dan_bonus*dbj ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F".$kli_vxcf."_deti".$kli_uzid." SELECT cpl, oc, '', '', '', 99, 0, 0, sum(p4), datm, sum(dbj), sum(dbn), '', 0, 0 ".
" FROM F$kli_vxcf"."_deti".$kli_uzid." WHERE oc > 0 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F".$kli_vxcf."_deti".$kli_uzid." SELECT cpl, 99999, '', '', '', 0, 0, 0, sum(p4), datm, sum(dbj), sum(dbn), '', 0, 0 ".
" FROM F$kli_vxcf"."_deti".$kli_uzid." WHERE p1 = 99 GROUP BY p1 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;




   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_deti$kli_uzid WHERE cpl > 0 ORDER BY oc,p1,dr ";
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
$pdf->Cell(90,6,"Zoznam detí zamestnancov $kli_vume","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(50,6,"Meno ","1",0,"L");$pdf->Cell(40,6,"Rodné číslo","1",0,"L");
$pdf->Cell(40,6,"Dátum narodenia","1",0,"L");
$pdf->Cell(20,6,"počet DB","1",0,"R");$pdf->Cell(0,6,"suma DB","1",1,"R");
     }
//koniec hlavicky j=0



if( $riadok->p1 == 0 AND $riadok->oc != 99999 )
    {
$pdf->SetFont('arial','',8);
$datn=SkDatum($riadok->dr);

$pdf->Cell(50,6,"$riadok->md ","0",0,"L");
$pdf->Cell(40,6,"$riadok->rcd","0",0,"L");
$pdf->Cell(40,6,"$datn","0",0,"L");
$pdf->Cell(20,6,"$riadok->dbj","0",0,"R");
$pdf->Cell(0,6,"$riadok->dbn","0",0,"R");
$pdf->Cell(0,6,"  ","0",1,"L");
    }

if( $riadok->p1 == 99 )
    {
$pdf->SetFont('arial','',8);


$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc = $riadok->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $osc = $riaddok->oc;
  $prie = $riaddok->prie;
  $meno = $riaddok->meno;
  $deti_dn = $riaddok->deti_dn;

  }

$pdf->Cell(80,6,"SPOLU zamestnanec osč.$osc $prie $meno ","T",0,"L");
$pdf->Cell(50,6," počet DB nastavené v údajoch  =  $deti_dn","T",0,"L");
$pdf->Cell(20,6,"$riadok->dbj","T",0,"R");
$pdf->Cell(0,6,"$riadok->dbn","T",0,"R");
$pdf->Cell(0,6,"  ","T",1,"L");
$pdf->Cell(0,6,"  ","T",1,"L");
$j=$j+1;
    }

if( $riadok->p1 == 0 AND $riadok->oc == 99999 )
    {
$pdf->SetFont('arial','',8);


$pdf->Cell(130,6,"SPOLU CELKOM ","T",0,"L");
$pdf->Cell(20,6,"$riadok->dbj","T",0,"R");
$pdf->Cell(0,6,"$riadok->dbn","T",0,"R");
$pdf->Cell(0,6,"  ","T",1,"L");
$pdf->Cell(0,6,"  ","T",1,"L");
    }

}
$i = $i + 1;
$j = $j + 1;
if( $j > 38 ) $j=0;

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
