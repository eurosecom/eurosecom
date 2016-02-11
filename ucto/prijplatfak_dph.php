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

//cpld	dok	druh	dppx	prx7	dou	dpp	dau	hd2	hz2	hd1	hz1	hou

$sql = "DROP TABLE F".$kli_vxcf."_uctfakuhrdphx".$kli_uzid." ";
$vysledek = mysql_query("$sql");

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   fak         DECIMAL(10,0) DEFAULT 0,
   ico         DECIMAL(10,0) DEFAULT 0,
   druh        DECIMAL(10,0) DEFAULT 0,
   dppx        DECIMAL(4,0) DEFAULT 0,
   prx7        DECIMAL(4,0) DEFAULT 0,
   dou         DECIMAL(10,0) DEFAULT 0,
   dpp         DATE not null,
   dau         DATE not null,
   hd2         DECIMAL(10,2) DEFAULT 0,
   hz2         DECIMAL(10,2) DEFAULT 0,
   hd1         DECIMAL(10,2) DEFAULT 0,
   hz1         DECIMAL(10,2) DEFAULT 0,
   hou         DECIMAL(10,2) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "CREATE TABLE F".$kli_vxcf."_uctfakuhrdphx".$kli_uzid." ".$sqlt;
$vysledek = mysql_query("$sql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE prx7 = 1 ORDER BY dok";
//echo $sqltt."<br />";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i11=0;
  while ($i11 <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i11))
{
$hlavicka=mysql_fetch_object($sql);

//echo $hlavicka->dok."<br />";


$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, fak, ico, 2, 1, 0, 0, dat, daz, dn2u, zk2u, dn1u, zk1u, hodu ".
" FROM F$kli_vxcf"."_fakdod WHERE dok = $hlavicka->dok AND daz <= '$datk_dph' ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti"); 

$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, fak, ico, 1, 1, 0, 0, dat, daz, dn2u, zk2u, dn1u, zk1u, hodu ".
" FROM F$kli_vxcf"."_fakodb WHERE dok = $hlavicka->dok AND daz <= '$datk_dph' ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti");


$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, 0, 0, druh, 2, 0, dou, dau, dpp, hd2, hz2, hd1, hz1, hou ".
" FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $hlavicka->dok AND prx7 = 0 AND dpp <= '$datk_dph'";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti"); 


}
$i11 = $i11 + 1;
  }
//exit;


$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, 0, 0, druh, 3, 0, dou, dau, dpp, sum(hd2), sum(hz2), sum(hd1), sum(hz1), sum(hou) ".
" FROM F$kli_vxcf"."_uctfakuhrdphx$kli_uzid WHERE dppx = 1 GROUP BY dok ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti");

$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, 0, 0, druh, 3, 0, dou, dau, dpp, -sum(hd2), -sum(hz2), -sum(hd1), -sum(hz1), -sum(hou) ".
" FROM F$kli_vxcf"."_uctfakuhrdphx$kli_uzid WHERE dppx = 2 GROUP BY dok ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti");

$sqltti = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphx$kli_uzid SELECT ".
" 0, dok, 0, 0, druh, 4, 0, 0, dpp, dau, sum(hd2), sum(hz2), sum(hd1), sum(hz1), sum(hou) ".
" FROM F$kli_vxcf"."_uctfakuhrdphx$kli_uzid WHERE dppx = 3 GROUP BY dok ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti");

$sqltti = "DELETE FROM F$kli_vxcf"."_uctfakuhrdphx$kli_uzid WHERE dppx = 3 ";
//echo $sqltti."<br />";
$sqli = mysql_query("$sqltti");


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



$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdphx$kli_uzid WHERE dok > 0 ORDER BY dok,dppx,dou ";

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
$pdf->Cell(90,6,"Zoznam faktúr v režime uplatnenie DPH až po prijatí platby do $datksk ","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(26,6,"Doklad","LRB",0,"R");
$pdf->Cell(20,6,"Faktúra","LRB",0,"R");
$pdf->Cell(20,6,"IÈO","LRB",0,"R");
$pdf->Cell(20,6,"Hodnota/úhrady","LRB",0,"R");
$pdf->Cell(20,6,"Dodané/uplatnené","LRB",0,"L");
$pdf->Cell(20,6,"Základ $fir_dph2%","LRB",0,"R");
$pdf->Cell(20,6,"DPH $fir_dph2%","LRB",0,"R");
$pdf->Cell(20,6,"Základ $fir_dph1%","LRB",0,"R");
$pdf->Cell(0,6,"DPH $fir_dph1%","LRB",1,"R");


     }
//koniec hlavicky j=0



$dausk=SkDatum($riadok->dau);
$dppsk=SkDatum($riadok->dpp);

$pdf->SetFont('arial','',7);

if( $riadok->dppx == 1 ) 
  {
$pdf->Cell(26,6,"$riadok->dok","0",0,"R");
$pdf->Cell(20,6,"$riadok->fak","0",0,"R");
$pdf->Cell(20,6,"$riadok->ico","0",0,"R");
$pdf->Cell(20,6,"$riadok->hou","0",0,"R");
$pdf->Cell(20,6,"$dppsk","0",0,"L");
$pdf->Cell(20,6,"$riadok->hz2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hd2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hz1","0",0,"R");
$pdf->Cell(0,6,"$riadok->hd1","0",1,"R");
  }

if( $riadok->dppx == 2 ) 
  {
$pdf->Cell(66,6,"Platba $dausk doklad $riadok->dou","0",0,"L");
$pdf->Cell(20,6,"$riadok->hou","0",0,"R");
$pdf->Cell(20,6,"$dppsk","0",0,"L");
$pdf->Cell(20,6,"$riadok->hz2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hd2","0",0,"R");
$pdf->Cell(20,6,"$riadok->hz1","0",0,"R");
$pdf->Cell(0,6,"$riadok->hd1","0",1,"R");
  }

if( $riadok->dppx == 4 ) 
  {
$pdf->Cell(46,6,"SPOLU $riadok->dok","T",0,"R");
$pdf->Cell(40,6,"nezaplatené $riadok->hou","T",0,"R");
$pdf->Cell(20,6," ","T",0,"L");
$pdf->Cell(20,6,"neuplatnené $riadok->hz2","T",0,"R");
$pdf->Cell(20,6,"$riadok->hd2","T",0,"R");
$pdf->Cell(20,6,"$riadok->hz1","T",0,"R");
$pdf->Cell(0,6,"$riadok->hd1","T",1,"R");

$pdf->Cell(0,6," ","0",1,"R");

$j=$j+1;
  }


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
