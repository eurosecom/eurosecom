<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Pozn·mky bud˙ pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
$urobxml = 1*$_REQUEST['urobxml'];

//$strana=25;
//$dopoz = 1*$_REQUEST['dopoz'];
//if ( $copern == 1 ) $dopoz=1;

$no="";

$h_drp = $_REQUEST['h_drp'];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>Pozn·mky MUJ 2014 | EuroSecom</title>
<style>
div.form-background {
  overflow: hidden;
  width: 950px;
  height: 300px;
  background-color: #fff;
}
img.robot {
  position: absolute;
  top: 30px;
  left: 20px;
  display: block;
  width: 92px;
  height: 137px;
  cursor: pointer;
}
ul.robot-menu {
  position: absolute;
  top: 80px;
  left: 70px;
  padding: 2px 3px;
  background-color: #ffff90;
  border: 2px outset #dbdbdb;
}
ul.robot-menu > li {
  font-size: 12px;
  background-color: #fff;
  padding: 8px 6px;
  border-top: 2px solid #ffff90;
  overflow: auto;
}
ul.robot-menu input[type=text] {
  position: static;
  width: 40px;
  font-size: 14px;
  line-height: 14px;
  height: 14px;
  padding: 3px 3px;
}
ul.robot-menu > li > a {
  color: #39f;
  font-size: 12px;
}
ul.robot-menu > li > a:hover {
  text-decoration: underline;
}
a.btn-file-do {
  display: block;
  font-size: 12px;
  color: #fff !important;
  background-color: #39f;
  padding: 6px 14px;
  border-radius: 2px;
  opacity: 0.8;
}
a.btn-file-do:hover {
  text-decoration: none !important;
  opacity: 1;
}
img.btn-menu-cancel-old {
  width: 15px;
  height: 15px;
  cursor: pointer;
}
</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

  function NacitajMzdy()
  {
   var h_mfir = document.forms.emzdy.h_mfir.value;
   var dopoz = 0;
   if ( document.emzdy.dopoz.checked ) dopoz=1;
   window.open('../ucto/poznamky_muj2014nacitaj.php?h_mfir=' + h_mfir + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=10101&vyb_ume=<?php echo $vyb_umk; ?>&dopoz=' + dopoz + '&xxc=1', '_self');
  }

  function UrobSubor()
  {
   window.open('../ucto/poznamky_muj2014nacitaj.php?&copern=901&drupoh=1&page=1&strana=<?php echo $strana; ?>&dopoz=1', '_self');
  }

  function NacitajHodnotu( riadok )
  {
   var dopoz = 0;
   if ( document.emzdy.dopoz.checked ) dopoz=1;
   window.open('../ucto/poznamky_muj2014nacitaj.php?copern=' + riadok + '&drupoh=1&page=1&dopoz=' + dopoz + '&xxc=1', '_self');
  }

  function obnovUI()
  {
   document.emzdy.dopoz.checked="true";
  }
</script>
</HEAD>
<BODY onload="obnovUI();">

<!-- zahlavie -->
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Pozn·mky k ˙Ëtovnej z·vierke MUJ 2014 - <span class="subheader">naËÌtanie</span></td>
   <td>
    <div class="bar-btn-form-tool"></div>
   </td>
  </tr>
 </table>
</div>

<?php
if ( $copern != 10 )
     {
?>
<div id="content">
<div class="form-background">
 <img src='../obr/robot/robot3.jpg' onclick="robotmenu.style.display='block';"
  alt='Dobr˝ deÚ, som V·ö EkoRobot' class="robot">

<!-- menu ekorobota -->
<FORM name='emzdy' method='post' action='#'>
 <ul id="robotmenu" class="robot-menu">
 <li style="background-color:#ffff90; padding:4px 0 2px 0; text-align:right; display:none;">
  <img src='../obr/zmazuplne.png' onclick="robotmenu.style.display='none';" title='Zavrieù'
   class="btn-menu-cancel-old">
 </li>
 <li>
  <a href="#" onclick="NacitajMzdy();">NaËÌtaù ˙daje o <strong>poËte zamestnancov</strong> z firmy ËÌslo</a>
  <input type='text' name='h_mfir' id='h_mfir' maxlength='4' value='<?php echo $kli_vxcf; ?>'>
 </li>
 <li>
  <a href="#" onclick="NacitajHodnotu( 402 );">NaËÌtaù ˙daje o <strong>z·v‰zkoch</strong> zo saldokonta</a>
 </li>
 <li>
  <a href="#" onclick="NacitajHodnotu( 999 );">NaËÌtaù <strong>minul˝ rok</strong> z Pozn·mok MUJ</a>
 </li>
 <li>
  <a href="#" onclick='UrobSubor();' title='Vytvoriù s˙bor pre naËÌtanie (jeden kr·t klikn˙ù)'
   class="btn-file-do toleft">S˙bor</a>
  <div class="toright" style="width:120px;">Po naËÌtanÌ nasp‰ù<br>
   <input type='checkbox' name='dopoz' value='1'>
  </div>
 </li>
 </ul>
</FORM>

</div>
</div> <!-- koniec #content -->
<?php
     }
?>

<?php
//zostava PDF
if ( $copern == 10 )
     {

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/poznamky_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/poznamky_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014$no WHERE psys >= 0 "."";
//echo $sqltt;
//exit;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; 

//zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$bez1 = 1*$_REQUEST['bez1'];
//strana 1
if ( $strana == 9999 AND $bez1 == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg',0,0,210,297);
}

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
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

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

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

//nacitaj uzavierka k datumu z ufirdalsie
$datksk="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datksk=SkDatum($riadok->datk);
  }
if ( $datksk != '' AND $datksk != '00.00.0000' ) { $datk_sk=$datksk; }

//zostavena k
$pdf->Cell(190,15," ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,28," ","$rmc1",1,"L");
$textxx="1234567890";
$text=$fir_fdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$textxx="12345678";
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//sknace
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
//$sn2c=substr($sknacec,1,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$pdf->SetFont('arial','',10);
$riadna=""; $mimor=""; $priebez="";
if ( $h_drp == 1 ) { $riadna="x"; }
if ( $h_drp == 2 ) { $mimor="x"; }
if ( $h_drp == 3 ) { $priebez="x"; }
if ( $h_zos != '' )
{
$krizzos="x";
if ( trim($h_sch) != '' ) { $krizzos=" "; }
}
if ( $h_sch != '' )
{
$krizsch="x";
}
$pdf->SetY(62);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadna","$rmc",0,"C");
$pdf->SetY(71);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$mimor","$rmc",0,"C");
$pdf->SetY(80);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$priebez","$rmc",0,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
     }
  }

$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;

//za obdobie
$me1="0"; $me2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1);
}
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);
$pdf->SetY(58);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$me1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(67);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$Am","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$Bm","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//predchadzajuce obdobie
$mep1="0"; $mep2="1";
$kli_prdph=$kli_rdph-1;
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1);
$kli_prdph=$obmr1;
}
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);
$pdf->SetY(76);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mep1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
$kli_prdph=$obmr2;
}
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);
$pdf->SetY(85);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mepm1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//nazov
$pdf->Cell(190,22," ","$rmc1",1,"L");
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$fir_fnazr2="";
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,37,36);
$A=substr($fir_fnazr2,0,1);
$B=substr($fir_fnazr2,1,1);
$C=substr($fir_fnazr2,2,1);
$D=substr($fir_fnazr2,3,1);
$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);
$G=substr($fir_fnazr2,6,1);
$H=substr($fir_fnazr2,7,1);
$I=substr($fir_fnazr2,8,1);
$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);
$L=substr($fir_fnazr2,11,1);
$M=substr($fir_fnazr2,12,1);
$N=substr($fir_fnazr2,13,1);
$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);
$R=substr($fir_fnazr2,16,1);
$S=substr($fir_fnazr2,17,1);
$T=substr($fir_fnazr2,18,1);
$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);
$W=substr($fir_fnazr2,21,1);
$X=substr($fir_fnazr2,22,1);
$Y=substr($fir_fnazr2,23,1);
$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);
$B1=substr($fir_fnazr2,26,1);
$C1=substr($fir_fnazr2,27,1);
$D1=substr($fir_fnazr2,28,1);
$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);
$G1=substr($fir_fnazr2,31,1);
$H1=substr($fir_fnazr2,32,1);
$I1=substr($fir_fnazr2,33,1);
$J1=substr($fir_fnazr2,34,1);
$K1=substr($fir_fnazr2,35,1);
$L1=substr($fir_fnazr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Sidlo uctovej jednotky
//ulica
$pdf->Cell(190,13," ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$fir_fuli;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");

//cislo
$textxx="111122";
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//obchodny register
$pdf->Cell(190,7," ","$rmc1",1,"L");
$A=substr($fir_obreg,0,1);
$B=substr($fir_obreg,1,1);
$C=substr($fir_obreg,2,1);
$D=substr($fir_obreg,3,1);
$E=substr($fir_obreg,4,1);
$F=substr($fir_obreg,5,1);
$G=substr($fir_obreg,6,1);
$H=substr($fir_obreg,7,1);
$I=substr($fir_obreg,8,1);
$J=substr($fir_obreg,9,1);
$K=substr($fir_obreg,10,1);
$L=substr($fir_obreg,11,1);
$M=substr($fir_obreg,12,1);
$N=substr($fir_obreg,13,1);
$O=substr($fir_obreg,14,1);
$P=substr($fir_obreg,15,1);
$R=substr($fir_obreg,16,1);
$S=substr($fir_obreg,17,1);
$T=substr($fir_obreg,18,1);
$U=substr($fir_obreg,19,1);
$V=substr($fir_obreg,20,1);
$W=substr($fir_obreg,21,1);
$X=substr($fir_obreg,22,1);
$Y=substr($fir_obreg,23,1);
$Z=substr($fir_obreg,24,1);
$A1=substr($fir_obreg,25,1);
$B1=substr($fir_obreg,26,1);
$C1=substr($fir_obreg,27,1);
$D1=substr($fir_obreg,28,1);
$E1=substr($fir_obreg,29,1);
$F1=substr($fir_obreg,30,1);
$G1=substr($fir_obreg,31,1);
$H1=substr($fir_obreg,32,1);
$I1=substr($fir_obreg,33,1);
$J1=substr($fir_obreg,34,1);
$K1=substr($fir_obreg,35,1);
$L1=substr($fir_obreg,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_obregr2="";
$A=substr($fir_obregr2,0,1);
$B=substr($fir_obregr2,1,1);
$C=substr($fir_obregr2,2,1);
$D=substr($fir_obregr2,3,1);
$E=substr($fir_obregr2,4,1);
$F=substr($fir_obregr2,5,1);
$G=substr($fir_obregr2,6,1);
$H=substr($fir_obregr2,7,1);
$I=substr($fir_obregr2,8,1);
$J=substr($fir_obregr2,9,1);
$K=substr($fir_obregr2,10,1);
$L=substr($fir_obregr2,11,1);
$M=substr($fir_obregr2,12,1);
$N=substr($fir_obregr2,13,1);
$O=substr($fir_obregr2,14,1);
$P=substr($fir_obregr2,15,1);
$R=substr($fir_obregr2,16,1);
$S=substr($fir_obregr2,17,1);
$T=substr($fir_obregr2,18,1);
$U=substr($fir_obregr2,19,1);
$V=substr($fir_obregr2,20,1);
$W=substr($fir_obregr2,21,1);
$X=substr($fir_obregr2,22,1);
$Y=substr($fir_obregr2,23,1);
$Z=substr($fir_obregr2,24,1);
$A1=substr($fir_obregr2,25,1);
$B1=substr($fir_obregr2,26,1);
$C1=substr($fir_obregr2,27,1);
$D1=substr($fir_obregr2,28,1);
$E1=substr($fir_obregr2,29,1);
$F1=substr($fir_obregr2,30,1);
$G1=substr($fir_obregr2,31,1);
$H1=substr($fir_obregr2,32,1);
$I1=substr($fir_obregr2,33,1);
$J1=substr($fir_obregr2,34,1);
$K1=substr($fir_obregr2,35,1);
$L1=substr($fir_obregr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$t01=substr($fir_ftel,0,1);
$t02=substr($fir_ftel,1,1);
$t03=substr($fir_ftel,2,1);
$t04=substr($fir_ftel,3,1);
$t05=substr($fir_ftel,4,1);
$t06=substr($fir_ftel,5,1);
$t07=substr($fir_ftel,6,1);
$t08=substr($fir_ftel,7,1);
$t09=substr($fir_ftel,8,1);
$t10=substr($fir_ftel,9,1);
$t11=substr($fir_ftel,10,1);
$t12=substr($fir_ftel,11,1);
$t13=substr($fir_ftel,12,1);
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");

//cislo faxu
$t01=substr($fir_ffax,0,1);
$t02=substr($fir_ffax,1,1);
$t03=substr($fir_ffax,2,1);
$t04=substr($fir_ffax,3,1);
$t05=substr($fir_ffax,4,1);
$t06=substr($fir_ffax,5,1);
$t07=substr($fir_ffax,6,1);
$t08=substr($fir_ffax,7,1);
$t09=substr($fir_ffax,8,1);
$t10=substr($fir_ffax,9,1);
$t11=substr($fir_ffax,10,1);
$t12=substr($fir_ffax,11,1);
$t13=substr($fir_ffax,12,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",1,"C");

//email
$pdf->Cell(190,6," ","$rmc1",1,"L");
$fir_fulicis=$fir_fem1;
$A=substr($fir_fulicis,0,1);
$B=substr($fir_fulicis,1,1);
$C=substr($fir_fulicis,2,1);
$D=substr($fir_fulicis,3,1);
$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);
$G=substr($fir_fulicis,6,1);
$H=substr($fir_fulicis,7,1);
$I=substr($fir_fulicis,8,1);
$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);
$L=substr($fir_fulicis,11,1);
$M=substr($fir_fulicis,12,1);
$N=substr($fir_fulicis,13,1);
$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);
$R=substr($fir_fulicis,16,1);
$S=substr($fir_fulicis,17,1);
$T=substr($fir_fulicis,18,1);
$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);
$W=substr($fir_fulicis,21,1);
$X=substr($fir_fulicis,22,1);
$Y=substr($fir_fulicis,23,1);
$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);
$B1=substr($fir_fulicis,26,1);
$C1=substr($fir_fulicis,27,1);
$D1=substr($fir_fulicis,28,1);
$E1=substr($fir_fulicis,29,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//datum zostavenia
$pdf->Cell(190,9," ","$rcm1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","$rcm1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//datum schvalenia
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(5,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//odkaz na datum uzavierky k
//podla mna zbytocne
$pdf->SetY(25);
$pdf->SetX(60);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(60);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);

//odkaz na uctovne obdobia
$pdf->SetY(55);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
//koniec prva strana

                       } //koniec strana 1

//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$ico01=substr($text,0,1);
$ico02=substr($text,1,1);
$ico03=substr($text,2,1);
$ico04=substr($text,3,1);
$ico05=substr($text,4,1);
$ico06=substr($text,5,1);
$ico07=substr($text,6,1);
$ico08=substr($text,7,1);

//dic
$text=$fir_fdic;
$dic01=substr($text,0,1);
$dic02=substr($text,1,1);
$dic03=substr($text,2,1);
$dic04=substr($text,3,1);
$dic05=substr($text,4,1);
$dic06=substr($text,5,1);
$dic07=substr($text,6,1);
$dic08=substr($text,7,1);
$dic09=substr($text,8,1);
$dic10=substr($text,9,1);

    function vytlactextx($ktorytext, $mysqlhostx, $mysqluserx, $mysqlpasswdx, $mysqldbx, $kli_vxcf)
    {
  @$spojeni = mysql_connect($mysqlhostx, $mysqluserx, $mysqlpasswdx);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldbx);

$ozntext=$ktorytext;
$textvypis="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }
    return $textvypis;
    }
$nopg2=0;$nopg3=0;$nopg4=0;$nopg5=0;$nopg6=0;$nopg7=0;$nopg8=0;$nopg9=0;
$stranax=1;

//strana 2
if ( $nopg2 == 0 AND ( $strana == 2 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab101.jpg') AND $hlavicka->tlt101 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab101.jpg',0,200,210,40);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

//CLANOK I.
$pdf->SetFont('arial','',11);
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(5,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"»l.1 VöeobecnÈ ˙daje","$rmc",1,"L");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.1 N·zov pr·vnickej osoby a jej sÌdlo alebo meno a priezvisko fyzickej osoby","$rmc",1,"L");
$pdf->SetFont('arial','',9);

$pdf->Cell(190,5," ","$rmc1",1,"L");
$nazovsidlo=$fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;
if ( $fir_uctt03 == 999 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$nazovsidlo=$fir_riadok->dmeno." ".$fir_riadok->dprie;
                          }
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"$nazovsidlo","$rmc",1,"L");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.2 ⁄daje o konsolidovanom celku","$rmc",1,"L");
$pdf->SetFont('arial','',9);

$pdf->Cell(190,10," ","$rmc1",1,"L");
//pocet zamestnancov
if ( $hlavicka->ac11 == 0 ) $hlavicka->ac11="";
if ( $hlavicka->ac12 == 0 ) $hlavicka->ac12="";
if ( $hlavicka->ac21 == 0 ) $hlavicka->ac21="";
if ( $hlavicka->ac22 == 0 ) $hlavicka->ac22="";
if ( $hlavicka->ac31 == 0 ) $hlavicka->ac31="";
if ( $hlavicka->ac32 == 0 ) $hlavicka->ac32="";
$hlavicka->ac11nyg46nyg46nyg46="1234.56";
$hlavicka->ac12nyg46nyg46nyg46="1234.56";
$hlavicka->ac21nyg46nyg46nyg46="1234.56";
$hlavicka->ac22nyg46nyg46nyg46="1234.56";
$hlavicka->ac31nyg46nyg46nyg46="1234.56";
$hlavicka->ac32nyg46nyg46nyg46="1234.56";

$pdf->Cell(190,120," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.3 Priemern˝ prepoËÌtan˝ poËet zamestnancov","$rmc",1,"L");
$pdf->Cell(190,19," ","$rmc1",1,"L");

$yA_text2=206;
if ( $hlavicka->tlt101 == 1 )
{
$pdf->SetFont('arial','',9);
$pdf->Cell(82,6," ","$rmc1",0,"L");$pdf->Cell(47,6,"$hlavicka->ac11","$rmc",0,"R");$pdf->Cell(48,6,"$hlavicka->ac12","$rmc",1,"R");
$pdf->Cell(82,5," ","$rmc1",0,"L");$pdf->Cell(47,10,"$hlavicka->ac21","$rmc",0,"R");$pdf->Cell(48,10,"$hlavicka->ac22","$rmc",1,"R");
$pdf->Cell(82,5," ","$rmc1",0,"L");$pdf->Cell(47,7,"$hlavicka->ac31","$rmc",0,"R");$pdf->Cell(48,7,"$hlavicka->ac32","$rmc",1,"R");

$yA_text2=240;
}

$pdf->SetFont('arial','',8);
$ozntext="A_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(65);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="A_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY($yA_text2);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                                           } //koniec strana 2
//strana 3
$stranax=$stranax+1;
if ( $nopg3 == 0 AND ( $strana == 3 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

//CLANOK II.
$pdf->SetFont('arial','',11);
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(5,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"»l.2 Inform·cie o prijat˝ch postupoch","$rmc",1,"L");
$pdf->SetFont('arial','',10);

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.1 NepretrûitÈ pokraËovanie v Ëinnosti","$rmc",1,"L");
$pdf->Cell(190,40," ","$rmc1",1,"L");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.2 SpÙsob oceÚovania jednotliv˝ch poloûiek majetku a z·v‰zkov","$rmc",1,"L");
$pdf->Cell(90,10," ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
$ozntext="B_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(42);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="B_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(96);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 3

//strana 4
$stranax=$stranax+1;
if ( $nopg4 == 0 AND ( $strana == 3 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.3 SpÙsob zostavenia odpisovÈho pl·nu majetku","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,120," ","$rmc1",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.4 Zmeny ˙Ëtovn˝ch z·sad a zmeny ˙Ëtovn˝ch metÛd","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
$ozntext="B_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(40);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="B_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(183);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 4

//strana 5
$stranax=$stranax+1;
if ( $nopg5 == 0 AND ( $strana == 3 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.5 Inform·cie o dot·ci·ch a ich oceÚovanie v ˙ËtovnÌctve","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,120," ","$rmc1",1,"L");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.2.6 Inform·cie o ˙ËtovanÌ v˝znamn˝ch opr·v ch˝b minul˝ch ˙Ëtovn˝ch obdobÌ v beûnom ˙Ëtovnom obdobÌ","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
$ozntext="B_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(40);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="B_text6"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(183);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 5

//strana 6
$stranax=$stranax+1;
if ( $nopg6 == 0 AND ( $strana == 4 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab301.jpg') AND $hlavicka->tlt301 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab301.jpg',0,150,210,70);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->SetFont('arial','',11);
$pdf->Cell(5,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"»l.3. Inform·cie, ktorÈ vysvetæuj˙ a dopÂÚaj˙ s˙vahu a v˝kaz ziskov a str·t","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.3.1 Inform·cia o sume a dÙvodoch vzniku jednotliv˝ch poloûiek n·kladov alebo v˝nosov, ktorÈ maj˙ v˝nimoËn˝ rozsah","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,80," ","$rmc1",1,"L");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.3.2 Inform·cie o z·v‰zkoch","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);

$yC_text2=155;
if ( $hlavicka->tlt301 == 1 )
{
$pdf->Cell(190,14," ","$rmc1",1,"L");

//info o zavazkoch
if ( $hlavicka->gcd11 == 0 ) $hlavicka->gcd11="";
if ( $hlavicka->gcd12 == 0 ) $hlavicka->gcd12="";
$hlavicka->gcd11nyg46nyg46="1234.56";
$hlavicka->gcd12nyg46nyg46="1234.56";
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd11","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd12","$rmc",1,"R");

if ( $hlavicka->gcd21 == 0 ) $hlavicka->gcd21="";
if ( $hlavicka->gcd22 == 0 ) $hlavicka->gcd22="";
$hlavicka->gcd21nyg46nyg46="1234.56";
$hlavicka->gcd22nyg46nyg46="1234.56";
$pdf->Cell(190,4," ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd21","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd22","$rmc",1,"R");

if ( $hlavicka->gcd31 == 0 ) $hlavicka->gcd31="";
if ( $hlavicka->gcd32 == 0 ) $hlavicka->gcd32="";
$hlavicka->gcd31nyg46nyg46="1234.56";
$hlavicka->gcd32nyg46nyg46="1234.56";
$pdf->Cell(190,4," ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd31","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd32","$rmc",1,"R");

if ( $hlavicka->gcd41 == 0 ) $hlavicka->gcd41="";
if ( $hlavicka->gcd42 == 0 ) $hlavicka->gcd42="";
$hlavicka->gcd41nyg46nyg46="1234.56";
$hlavicka->gcd42nyg46nyg46="1234.56";
$pdf->Cell(190,5," ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd41","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd42","$rmc",1,"R");

if ( $hlavicka->gcd51 == 0 ) $hlavicka->gcd51="";
if ( $hlavicka->gcd52 == 0 ) $hlavicka->gcd52="";
$hlavicka->gcd51nyg46nyg46="1234.56";
$hlavicka->gcd52nyg46nyg46="1234.56";
$pdf->Cell(190,4," ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd51","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd52","$rmc",1,"R");

if ( $hlavicka->gcd61 == 0 ) $hlavicka->gcd61="";
if ( $hlavicka->gcd62 == 0 ) $hlavicka->gcd62="";
$hlavicka->gcd61nyg46nyg46="1234.56";
$hlavicka->gcd62nyg46nyg46="1234.56";
$pdf->Cell(190,5," ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd61","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd62","$rmc",1,"R");

$yC_text2=225;
}

$pdf->SetFont('arial','',8);
$ozntext="C_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(42);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="C_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY($yC_text2);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 6

//strana 7
$stranax=$stranax+1;
if ( $nopg7 == 0 AND ( $strana == 4 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab302.jpg') AND $hlavicka->tlt302 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab302.jpg',0,40,210,40);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.3.3 Inform·cie o vlastn˝ch akci·ch","$rmc",1,"L");
$pdf->Cell(190,9," ","$rmc1",1,"L");

$yC_text3=45;
if ( $hlavicka->tlt302 == 1 )
{
$pdf->Cell(90,10," ","$rmc1",1,"L");

if ( $hlavicka->gh12 == 0 ) $hlavicka->gh12="";
if ( $hlavicka->gh13 == 0 ) $hlavicka->gh13="";
if ( $hlavicka->gh14 == 0 ) $hlavicka->gh14="";
if ( $hlavicka->gh15 == 0 ) $hlavicka->gh15="";

$hlavicka->gh11nyg46nyg46="1234.56";
$hlavicka->gh12nyg46nyg46="1234.56";
$hlavicka->gh13nyg46nyg46="1234.56";
$hlavicka->gh14nyg46nyg46="1234.56";
$hlavicka->gh15nyg46nyg46="1234.56";
$hlavicka->gh16nyg46nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh11","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh12","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh13","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh14","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh15","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh16","$rmc",1,"L");

if ( $hlavicka->gh22 == 0 ) $hlavicka->gh22="";
if ( $hlavicka->gh23 == 0 ) $hlavicka->gh23="";
if ( $hlavicka->gh24 == 0 ) $hlavicka->gh24="";
if ( $hlavicka->gh25 == 0 ) $hlavicka->gh25="";

$hlavicka->gh21nyg46nyg46="1234.56";
$hlavicka->gh22nyg46nyg46="1234.56";
$hlavicka->gh23nyg46nyg46="1234.56";
$hlavicka->gh24nyg46nyg46="1234.56";
$hlavicka->gh25nyg46nyg46="1234.56";
$hlavicka->gh26nyg46nyg46="1234.56";

$pdf->Cell(190,2," ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh21","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh22","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh23","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh24","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh25","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh26","$rmc",1,"L");

if( $hlavicka->gh32 == 0 ) $hlavicka->gh32="";
if( $hlavicka->gh33 == 0 ) $hlavicka->gh33="";
if( $hlavicka->gh34 == 0 ) $hlavicka->gh34="";
if( $hlavicka->gh35 == 0 ) $hlavicka->gh35="";

$hlavicka->gh31nyg46nyg46="1234.56";
$hlavicka->gh32nyg46nyg46="1234.56";
$hlavicka->gh33nyg46nyg46="1234.56";
$hlavicka->gh34nyg46nyg46="1234.56";
$hlavicka->gh35nyg46nyg46="1234.56";
$hlavicka->gh36nyg46nyg46="1234.56";

$pdf->Cell(190,1," ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh31","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh32","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh33","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh34","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh35","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh36","$rmc",1,"L");

if( $hlavicka->gh42 == 0 ) $hlavicka->gh42="";
if( $hlavicka->gh43 == 0 ) $hlavicka->gh43="";
if( $hlavicka->gh44 == 0 ) $hlavicka->gh44="";
if( $hlavicka->gh45 == 0 ) $hlavicka->gh45="";

$hlavicka->gh41nyg46nyg46="1234.56";
$hlavicka->gh42nyg46nyg46="1234.56";
$hlavicka->gh43nyg46nyg46="1234.56";
$hlavicka->gh44nyg46nyg46="1234.56";
$hlavicka->gh45nyg46nyg46="1234.56";
$hlavicka->gh46nyg46nyg46="1234.56";

$pdf->Cell(190,2," ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh41","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh42","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh43","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh44","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh45","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh46","$rmc",1,"L");


$yC_text3=95;
}


$pdf->SetFont('arial','',8);
$ozntext="C_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY($yC_text3);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 7


//strana 8
$stranax=$stranax+1;
if ( $nopg8 == 0 AND ( $strana == 5 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab303.jpg') AND $hlavicka->tlt303 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab303.jpg',0,140,210,140);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(190,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.3.4 Inform·cie o org·noch ˙Ëtovnej jednotky","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

if ( $hlavicka->tlt303 == 1 )
{
$pdf->Cell(190,143," ","$rmc1",1,"L");

//prijmy a vyhody clenov
if( $hlavicka->m11b == 0 ) $hlavicka->m11b ="";
if( $hlavicka->m12b == 0 ) $hlavicka->m12b ="";
if( $hlavicka->m13b == 0 ) $hlavicka->m13b ="";
if( $hlavicka->m11c == 0 ) $hlavicka->m11c ="";
if( $hlavicka->m12c == 0 ) $hlavicka->m12c ="";
if( $hlavicka->m13c == 0 ) $hlavicka->m13c ="";

$hlavicka->m11bnyg46="1234.56";
$hlavicka->m12bnyg46="1234.56";
$hlavicka->m13bnyg46="1234.56";
$hlavicka->m11cnyg46="1234.56";
$hlavicka->m12cnyg46="1234.56";
$hlavicka->m13cnyg46="1234.56";

$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m11b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m12b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m13b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m11c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m12c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m13c","$rmc",1,"R");

if( $hlavicka->m21b == 0 ) $hlavicka->m21b ="";
if( $hlavicka->m22b == 0 ) $hlavicka->m22b ="";
if( $hlavicka->m23b == 0 ) $hlavicka->m23b ="";
if( $hlavicka->m21c == 0 ) $hlavicka->m21c ="";
if( $hlavicka->m22c == 0 ) $hlavicka->m22c ="";
if( $hlavicka->m23c == 0 ) $hlavicka->m23c ="";

$hlavicka->m21bnyg46="1234.56";
$hlavicka->m22bnyg46="1234.56";
$hlavicka->m23bnyg46="1234.56";
$hlavicka->m21cnyg46="1234.56";
$hlavicka->m22cnyg46="1234.56";
$hlavicka->m23cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m21b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m22b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m23b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m21c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m22c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m23c","$rmc",1,"R");

if( $hlavicka->m31b == 0 ) $hlavicka->m31b ="";
if( $hlavicka->m32b == 0 ) $hlavicka->m32b ="";
if( $hlavicka->m33b == 0 ) $hlavicka->m33b ="";
if( $hlavicka->m31c == 0 ) $hlavicka->m31c ="";
if( $hlavicka->m32c == 0 ) $hlavicka->m32c ="";
if( $hlavicka->m33c == 0 ) $hlavicka->m33c ="";

$hlavicka->m31bnyg46="1234.56";
$hlavicka->m32bnyg46="1234.56";
$hlavicka->m33bnyg46="1234.56";
$hlavicka->m31cnyg46="1234.56";
$hlavicka->m32cnyg46="1234.56";
$hlavicka->m33cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m31b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m32b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m33b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m31c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m32c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m33c","$rmc",1,"R");

if( $hlavicka->m41b == 0 ) $hlavicka->m41b ="";
if( $hlavicka->m42b == 0 ) $hlavicka->m42b ="";
if( $hlavicka->m43b == 0 ) $hlavicka->m43b ="";
if( $hlavicka->m41c == 0 ) $hlavicka->m41c ="";
if( $hlavicka->m42c == 0 ) $hlavicka->m42c ="";
if( $hlavicka->m43c == 0 ) $hlavicka->m43c ="";

$hlavicka->m41bnyg46="1234.56";
$hlavicka->m42bnyg46="1234.56";
$hlavicka->m43bnyg46="1234.56";
$hlavicka->m41cnyg46="1234.56";
$hlavicka->m42cnyg46="1234.56";
$hlavicka->m43cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m41b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m42b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m43b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m41c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m42c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m43c","$rmc",1,"R");

if( $hlavicka->m51b == 0 ) $hlavicka->m51b ="";
if( $hlavicka->m52b == 0 ) $hlavicka->m52b ="";
if( $hlavicka->m53b == 0 ) $hlavicka->m53b ="";
if( $hlavicka->m51c == 0 ) $hlavicka->m51c ="";
if( $hlavicka->m52c == 0 ) $hlavicka->m52c ="";
if( $hlavicka->m53c == 0 ) $hlavicka->m53c ="";

$hlavicka->m51bnyg46="1234.56";
$hlavicka->m52bnyg46="1234.56";
$hlavicka->m53bnyg46="1234.56";
$hlavicka->m51cnyg46="1234.56";
$hlavicka->m52cnyg46="1234.56";
$hlavicka->m53cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m51b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m52b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m53b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m51c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m52c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m53c","$rmc",1,"R");

if( $hlavicka->m61b == 0 ) $hlavicka->m61b ="";
if( $hlavicka->m62b == 0 ) $hlavicka->m62b ="";
if( $hlavicka->m63b == 0 ) $hlavicka->m63b ="";
if( $hlavicka->m61c == 0 ) $hlavicka->m61c ="";
if( $hlavicka->m62c == 0 ) $hlavicka->m62c ="";
if( $hlavicka->m63c == 0 ) $hlavicka->m63c ="";

$hlavicka->m61bnyg46="1234.56";
$hlavicka->m62bnyg46="1234.56";
$hlavicka->m63bnyg46="1234.56";
$hlavicka->m61cnyg46="1234.56";
$hlavicka->m62cnyg46="1234.56";
$hlavicka->m63cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m61b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m62b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m63b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m61c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m62c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m63c","$rmc",1,"R");

if( $hlavicka->m71b == 0 ) $hlavicka->m71b ="";
if( $hlavicka->m72b == 0 ) $hlavicka->m72b ="";
if( $hlavicka->m73b == 0 ) $hlavicka->m73b ="";
if( $hlavicka->m71c == 0 ) $hlavicka->m71c ="";
if( $hlavicka->m72c == 0 ) $hlavicka->m72c ="";
if( $hlavicka->m73c == 0 ) $hlavicka->m73c ="";

$hlavicka->m71bnyg46="1234.56";
$hlavicka->m72bnyg46="1234.56";
$hlavicka->m73bnyg46="1234.56";
$hlavicka->m71cnyg46="1234.56";
$hlavicka->m72cnyg46="1234.56";
$hlavicka->m73cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m71b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m72b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m73b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m71c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m72c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m73c","$rmc",1,"R");

if( $hlavicka->m81b == 0 ) $hlavicka->m81b ="";
if( $hlavicka->m82b == 0 ) $hlavicka->m82b ="";
if( $hlavicka->m83b == 0 ) $hlavicka->m83b ="";
if( $hlavicka->m81c == 0 ) $hlavicka->m81c ="";
if( $hlavicka->m82c == 0 ) $hlavicka->m82c ="";
if( $hlavicka->m83c == 0 ) $hlavicka->m83c ="";

$hlavicka->m81bnyg46="1234.56";
$hlavicka->m82bnyg46="1234.56";
$hlavicka->m83bnyg46="1234.56";
$hlavicka->m81cnyg46="1234.56";
$hlavicka->m82cnyg46="1234.56";
$hlavicka->m83cnyg46="1234.56";

$pdf->Cell(90,1," ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m81b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m82b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m83b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m81c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m82c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m83c","$rmc",1,"R");

if( $hlavicka->m91b == 0 ) $hlavicka->m91b ="";
if( $hlavicka->m92b == 0 ) $hlavicka->m92b ="";
if( $hlavicka->m93b == 0 ) $hlavicka->m93b ="";
if( $hlavicka->m91c == 0 ) $hlavicka->m91c ="";
if( $hlavicka->m92c == 0 ) $hlavicka->m92c ="";
if( $hlavicka->m93c == 0 ) $hlavicka->m93c ="";

$hlavicka->m91bnyg46="1234.56";
$hlavicka->m92bnyg46="1234.56";
$hlavicka->m93bnyg46="1234.56";
$hlavicka->m91cnyg46="1234.56";
$hlavicka->m92cnyg46="1234.56";
$hlavicka->m93cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m91b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m92b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m93b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m91c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m92c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m93c","$rmc",1,"R");

if( $hlavicka->m101b == 0 ) $hlavicka->m101b ="";
if( $hlavicka->m102b == 0 ) $hlavicka->m102b ="";
if( $hlavicka->m103b == 0 ) $hlavicka->m103b ="";
if( $hlavicka->m101c == 0 ) $hlavicka->m101c ="";
if( $hlavicka->m102c == 0 ) $hlavicka->m102c ="";
if( $hlavicka->m103c == 0 ) $hlavicka->m103c ="";

$hlavicka->m101bnyg46="1234.56";
$hlavicka->m102bnyg46="1234.56";
$hlavicka->m103bnyg46="1234.56";
$hlavicka->m101cnyg46="1234.56";
$hlavicka->m102cnyg46="1234.56";
$hlavicka->m103cnyg46="1234.56";

$pdf->Cell(90,2," ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m101b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m102b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m103b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m101c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m102c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m103c","$rmc",1,"R");

if( $hlavicka->m111b == 0 ) $hlavicka->m111b ="";
if( $hlavicka->m112b == 0 ) $hlavicka->m112b ="";
if( $hlavicka->m113b == 0 ) $hlavicka->m113b ="";
if( $hlavicka->m111c == 0 ) $hlavicka->m111c ="";
if( $hlavicka->m112c == 0 ) $hlavicka->m112c ="";
if( $hlavicka->m113c == 0 ) $hlavicka->m113c ="";

$hlavicka->m111bnyg46="1234.56";
$hlavicka->m112bnyg46="1234.56";
$hlavicka->m113bnyg46="1234.56";
$hlavicka->m111cnyg46="1234.56";
$hlavicka->m112cnyg46="1234.56";
$hlavicka->m113cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m111b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m112b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m113b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m111c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m112c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m113c","$rmc",1,"R");

if( $hlavicka->m121b == 0 ) $hlavicka->m121b ="";
if( $hlavicka->m122b == 0 ) $hlavicka->m122b ="";
if( $hlavicka->m123b == 0 ) $hlavicka->m123b ="";
if( $hlavicka->m121c == 0 ) $hlavicka->m121c ="";
if( $hlavicka->m122c == 0 ) $hlavicka->m122c ="";
if( $hlavicka->m123c == 0 ) $hlavicka->m123c ="";

$hlavicka->m121bnyg46="1234.56";
$hlavicka->m122bnyg46="1234.56";
$hlavicka->m123bnyg46="1234.56";
$hlavicka->m121cnyg46="1234.56";
$hlavicka->m122cnyg46="1234.56";
$hlavicka->m123cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m121b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m122b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m123b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m121c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m122c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m123c","$rmc",1,"R");

if( $hlavicka->m131b == 0 ) $hlavicka->m131b ="";
if( $hlavicka->m132b == 0 ) $hlavicka->m132b ="";
if( $hlavicka->m133b == 0 ) $hlavicka->m133b ="";
if( $hlavicka->m131c == 0 ) $hlavicka->m131c ="";
if( $hlavicka->m132c == 0 ) $hlavicka->m132c ="";
if( $hlavicka->m133c == 0 ) $hlavicka->m133c ="";

$hlavicka->m131bnyg46="1234.56";
$hlavicka->m132bnyg46="1234.56";
$hlavicka->m133bnyg46="1234.56";
$hlavicka->m131cnyg46="1234.56";
$hlavicka->m132cnyg46="1234.56";
$hlavicka->m133cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m131b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m132b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m133b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m131c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m132c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m133c","$rmc",1,"R");

if( $hlavicka->m141b == 0 ) $hlavicka->m141b ="";
if( $hlavicka->m142b == 0 ) $hlavicka->m142b ="";
if( $hlavicka->m143b == 0 ) $hlavicka->m143b ="";
if( $hlavicka->m141c == 0 ) $hlavicka->m141c ="";
if( $hlavicka->m142c == 0 ) $hlavicka->m142c ="";
if( $hlavicka->m143c == 0 ) $hlavicka->m143c ="";

$hlavicka->m141bnyg46="1234.56";
$hlavicka->m142bnyg46="1234.56";
$hlavicka->m143bnyg46="1234.56";
$hlavicka->m141cnyg46="1234.56";
$hlavicka->m142cnyg46="1234.56";
$hlavicka->m143cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m141b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m142b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m143b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m141c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m142c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m143c","$rmc",1,"R");


}


$pdf->SetFont('arial','',8);
$ozntext="C_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(40);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 8

//strana 9
$stranax=$stranax+1;
if ( $nopg9 == 0 AND ( $strana == 6 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab304.jpg') AND $hlavicka->tlt304 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab304.jpg',0,80,210,80);
}

if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab305.jpg') AND $hlavicka->tlt305 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab305.jpg',0,210,210,62);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.3.5 Inform·cie o povinnostiach ˙Ëtovnej jednotky","$rmc",1,"L");
$pdf->Cell(190,10," ","$rmc1",1,"L");

if ( $hlavicka->tlt304 == 1 )
{
$pdf->Cell(190,35," ","$rmc1",1,"L");

//udaje na podsuvahovych uctoch
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"Pods˙vahovÈ poloûky","$rmc",1,"L");
$pdf->Cell(190,14," ","$rmc1",1,"L");
if( $hlavicka->k11 == 0 ) $hlavicka->k11="";
if( $hlavicka->k12 == 0 ) $hlavicka->k12="";

$hlavicka->k11nyg46="1234.56";
$hlavicka->k12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k12","$rmc",1,"R");

if( $hlavicka->k21 == 0 ) $hlavicka->k21="";
if( $hlavicka->k22 == 0 ) $hlavicka->k22="";

$hlavicka->k21nyg46="1234.56";
$hlavicka->k22nyg46="1234.56";

$pdf->Cell(90,2," ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k22","$rmc",1,"R");


if( $hlavicka->k31 == 0 ) $hlavicka->k31="";
if( $hlavicka->k32 == 0 ) $hlavicka->k32="";

$hlavicka->k31nyg46="1234.56";
$hlavicka->k32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k32","$rmc",1,"R");

if( $hlavicka->k41 == 0 ) $hlavicka->k41="";
if( $hlavicka->k42 == 0 ) $hlavicka->k42="";

$hlavicka->k41nyg46="1234.56";
$hlavicka->k42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k42","$rmc",1,"R");

if( $hlavicka->k51 == 0 ) $hlavicka->k51="";
if( $hlavicka->k52 == 0 ) $hlavicka->k52="";

$hlavicka->k51nyg46="1234.56";
$hlavicka->k52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k52","$rmc",1,"R");

if( $hlavicka->k61 == 0 ) $hlavicka->k61="";
if( $hlavicka->k62 == 0 ) $hlavicka->k62="";

$hlavicka->k61nyg46="1234.56";
$hlavicka->k62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k62","$rmc",1,"R");

if( $hlavicka->k71 == 0 ) $hlavicka->k71="";
if( $hlavicka->k72 == 0 ) $hlavicka->k72="";

$hlavicka->k71nyg46="1234.56";
$hlavicka->k72nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k71","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k72","$rmc",1,"R");

if( $hlavicka->k81 == 0 ) $hlavicka->k81="";
if( $hlavicka->k82 == 0 ) $hlavicka->k82="";

$hlavicka->k81nyg46="1234.56";
$hlavicka->k82nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k81","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k82","$rmc",1,"R");

if( $hlavicka->k91 == 0 ) $hlavicka->k91="";
if( $hlavicka->k92 == 0 ) $hlavicka->k92="";

$hlavicka->k91nyg46="1234.56";
$hlavicka->k92nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k91","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k92","$rmc",1,"R");

}
$pdf->Cell(190,10," ","$rmc1",1,"L");

if ( $hlavicka->tlt305 == 1 )
{
//podmienene zavazky tab 1
$pdf->Cell(190,41," ","$rmc1",1,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"PodmienenÈ z·v‰zky - tabuæka Ë.1","$rmc",1,"L");
$pdf->Cell(190,18," ","$rmc1",1,"L");

if( $hlavicka->l1ab11 == 0 ) $hlavicka->l1ab11="";
if( $hlavicka->l1ab12 == 0 ) $hlavicka->l1ab12="";

$hlavicka->l1ab11nyg46="1234.56";
$hlavicka->l1ab12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab12","$rmc",1,"R");

if( $hlavicka->l1ab21 == 0 ) $hlavicka->l1ab21="";
if( $hlavicka->l1ab22 == 0 ) $hlavicka->l1ab22="";

$hlavicka->l1ab21nyg46="1234.56";
$hlavicka->l1ab22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab22","$rmc",1,"R");

if( $hlavicka->l1ab31 == 0 ) $hlavicka->l1ab31="";
if( $hlavicka->l1ab32 == 0 ) $hlavicka->l1ab32="";

$hlavicka->l1ab31nyg46="1234.56";
$hlavicka->l1ab32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab32","$rmc",1,"R");

if( $hlavicka->l1ab41 == 0 ) $hlavicka->l1ab41="";
if( $hlavicka->l1ab42 == 0 ) $hlavicka->l1ab42="";

$hlavicka->l1ab41nyg46="1234.56";
$hlavicka->l1ab42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab42","$rmc",1,"R");

if( $hlavicka->l1ab51 == 0 ) $hlavicka->l1ab51="";
if( $hlavicka->l1ab52 == 0 ) $hlavicka->l1ab52="";

$hlavicka->l1ab51nyg46="1234.56";
$hlavicka->l1ab52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab52","$rmc",1,"R");

if( $hlavicka->l1ab61 == 0 ) $hlavicka->l1ab61="";
if( $hlavicka->l1ab62 == 0 ) $hlavicka->l1ab62="";

$hlavicka->l1ab61nyg46="1234.56";
$hlavicka->l1ab62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab62","$rmc",1,"R");
}

$pdf->SetFont('arial','',8);
$ozntext="C_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(37);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="C_text6"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(170);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 9

//strana 9
$stranax=$stranax+1;
if ( $nopg9 == 0 AND ( $strana == 6 OR $strana == 9999 ) ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab306.jpg') AND $hlavicka->tlt306 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab306.jpg',0,40,210,60);
}

if ( File_Exists('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab307.jpg') AND $hlavicka->tlt307 == 1 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/poznamky_muj2014tabtext/poznamkymuj_v14_tab307.jpg',0,140,210,74);
}

//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,5,"Pozn·mky ⁄Ë M⁄J 3 - 01","1",0,"L");
$pdf->Cell(42,5,"- $stranax -","$rmc1",0,"C");
//ico
$pdf->Cell(10,5,"I»O","$rmc1",0,"C");
$pdf->Cell(5,5,"$ico01","1",0,"C");
$pdf->Cell(5,5,"$ico02","1",0,"C");
$pdf->Cell(5,5,"$ico03","1",0,"C");
$pdf->Cell(5,5,"$ico04","1",0,"C");
$pdf->Cell(5,5,"$ico05","1",0,"C");
$pdf->Cell(5,5,"$ico06","1",0,"C");
$pdf->Cell(5,5,"$ico07","1",0,"C");
$pdf->Cell(5,5,"$ico08","1",0,"C");
//dic
$pdf->Cell(10,5,"DI»","$rmc1",0,"C");
$pdf->Cell(5,5,"$dic01","1",0,"C");
$pdf->Cell(5,5,"$dic02","1",0,"C");
$pdf->Cell(5,5,"$dic03","1",0,"C");
$pdf->Cell(5,5,"$dic04","1",0,"C");
$pdf->Cell(5,5,"$dic05","1",0,"C");
$pdf->Cell(5,5,"$dic06","1",0,"C");
$pdf->Cell(5,5,"$dic07","1",0,"C");
$pdf->Cell(5,5,"$dic08","1",0,"C");
$pdf->Cell(5,5,"$dic09","1",0,"C");
$pdf->Cell(5,5,"$dic10","1",1,"C");

$pdf->Cell(90,10," ","$rmc1",1,"L");

if ( $hlavicka->tlt306 == 1 )
{
//podmienene zavazky 2
$pdf->SetFont('arial','',10);
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"PodmienenÈ z·v‰zky - tabuæka Ë.2","$rmc",1,"L");
$pdf->Cell(190,18," ","$rmc1",1,"L");

if( $hlavicka->l2ab11 == 0 ) $hlavicka->l2ab11="";
if( $hlavicka->l2ab12 == 0 ) $hlavicka->l2ab12="";

$hlavicka->l2ab11nyg46="1234.56";
$hlavicka->l2ab12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab12","$rmc",1,"R");

if( $hlavicka->l2ab21 == 0 ) $hlavicka->l2ab21="";
if( $hlavicka->l2ab22 == 0 ) $hlavicka->l2ab22="";

$hlavicka->l2ab21nyg46="1234.56";
$hlavicka->l2ab22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab22","$rmc",1,"R");

if( $hlavicka->l2ab31 == 0 ) $hlavicka->l2ab31="";
if( $hlavicka->l2ab32 == 0 ) $hlavicka->l2ab32="";

$hlavicka->l2ab31nyg46="1234.56";
$hlavicka->l2ab32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab32","$rmc",1,"R");

if( $hlavicka->l2ab41 == 0 ) $hlavicka->l2ab41="";
if( $hlavicka->l2ab42 == 0 ) $hlavicka->l2ab42="";

$hlavicka->l2ab41nyg46="1234.56";
$hlavicka->l2ab42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab42","$rmc",1,"R");

if( $hlavicka->l2ab51 == 0 ) $hlavicka->l2ab51="";
if( $hlavicka->l2ab52 == 0 ) $hlavicka->l2ab52="";

$hlavicka->l2ab51nyg46="1234.56";
$hlavicka->l2ab52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab52","$rmc",1,"R");

if( $hlavicka->l2ab61 == 0 ) $hlavicka->l2ab61="";
if( $hlavicka->l2ab62 == 0 ) $hlavicka->l2ab62="";

$hlavicka->l2ab61nyg46="1234.56";
$hlavicka->l2ab62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab62","$rmc",1,"R");
}


$pdf->Cell(190,10," ","$rmc1",1,"L");

if ( $hlavicka->tlt307 == 1 )
{
$pdf->Cell(190,28," ","$rmc1",1,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"Podmienen˝ majetok","$rmc",1,"L");
$pdf->Cell(190,14," ","$rmc1",1,"L");

//Lc podmieneny majetok
if( $hlavicka->lc11 == 0 ) $hlavicka->lc11="";
if( $hlavicka->lc12 == 0 ) $hlavicka->lc12="";

$hlavicka->lc11nyg46="1234.56";
$hlavicka->lc12nyg46="1234.56";

$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc11","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc12","$rmc",1,"R");

if( $hlavicka->lc21 == 0 ) $hlavicka->lc21="";
if( $hlavicka->lc22 == 0 ) $hlavicka->lc22="";

$hlavicka->lc21nyg46="1234.56";
$hlavicka->lc22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc21","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc22","$rmc",1,"R");

if( $hlavicka->lc31 == 0 ) $hlavicka->lc31="";
if( $hlavicka->lc32 == 0 ) $hlavicka->lc32="";

$hlavicka->lc31nyg46="1234.56";
$hlavicka->lc32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc31","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc32","$rmc",1,"R");

if( $hlavicka->lc41 == 0 ) $hlavicka->lc41="";
if( $hlavicka->lc42 == 0 ) $hlavicka->lc42="";

$hlavicka->lc41nyg46="1234.56";
$hlavicka->lc42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc41","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc42","$rmc",1,"R");

if( $hlavicka->lc51 == 0 ) $hlavicka->lc51="";
if( $hlavicka->lc52 == 0 ) $hlavicka->lc52="";

$hlavicka->lc51nyg46="1234.56";
$hlavicka->lc52nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc51","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc52","$rmc",1,"R");

if( $hlavicka->lc61 == 0 ) $hlavicka->lc61="";
if( $hlavicka->lc62 == 0 ) $hlavicka->lc62="";

$hlavicka->lc61nyg46="1234.56";
$hlavicka->lc62nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc61","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc62","$rmc",1,"R");

if( $hlavicka->lc71 == 0 ) $hlavicka->lc71="";
if( $hlavicka->lc72 == 0 ) $hlavicka->lc72="";

$hlavicka->lc71nyg46="1234.56";
$hlavicka->lc72nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc71","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc72","$rmc",1,"R");

if( $hlavicka->lc81 == 0 ) $hlavicka->lc81="";
if( $hlavicka->lc82 == 0 ) $hlavicka->lc82="";

$hlavicka->lc81nyg46="1234.56";
$hlavicka->lc82nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc81","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc82","$rmc",1,"R");



}

$pdf->SetFont('arial','',8);

$ozntext="C_text7"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(220);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 10

}
$i = $i + 1;

  }

$pdf->Output("$outfilex");


if ( $urobxml == 0 ) {
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
                     }
     }
//koniec zostava PDF
?>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>