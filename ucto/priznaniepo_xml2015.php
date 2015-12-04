<HTML>
<?php
//XML pre PO 2014
do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];

$chyby = 1*$_REQUEST['chyby'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Daòové priznanie XML bude pripravené v priebehu januára 2016. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEPO_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PO XML</title>
<style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%">
<tr>
 <td>EuroSecom - Priznanie k dani z príjmu PO rok <?php echo $kli_vrok; ?> export do XML</td>
 <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
</tr>
</table>

<?php
//XML SUBOR elsubor=2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");

//rok2015
$sqlt = <<<mzdprc
(

);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);
  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
  $text = "  <ico><![CDATA[".$ico."]]></ico>"."\r\n"; fwrite($soubor, $text);
$pravnaforma=$fir_uctt03;
  $text = "  <pravnaForma><![CDATA[".$pravnaforma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

$textod=SkDatum($hlavicka->obod);
if ( $textod == '00.00.0000' ) { $textod="01.01.".$kli_vrok; }
$textdo=SkDatum($hlavicka->obdo);
if ( $textdo == '00.00.0000' ) { $textdo="31.12.".$kli_vrok; }

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <od><![CDATA[".$textod."]]></od>"."\r\n"; fwrite($soubor, $text);
  $text = "   <do><![CDATA[".$textdo."]]></do>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$fir_sknace=trim($fir_sknace);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
$k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
$k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
$k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
$cinnost=iconv("CP1250", "UTF-8", $hlavicka->cinnost);
  $text = "   <cinnost><![CDATA[".$cinnost."]]></cinnost>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

  $text = "  <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno = iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchodneMeno>"."\r\n";   fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
$ulica= iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec = iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat = iconv("CP1250", "UTF-8", $hlavicka->xstat);
if ( $stat == '' ) $stat="Slovensko";
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mailfax=iconv("CP1250", "UTF-8", $fir_fem1);
  $text = "   <emailFax><![CDATA[".$mailfax."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

$text=$hlavicka->uoskr;
  $text = "  <uplatnujemPar17><![CDATA[".$text."]]></uplatnujemPar17>"."\r\n"; fwrite($soubor, $text);
$text=$hlavicka->koskr;
  $text = "  <ukoncujemUplatnovaniePar17><![CDATA[".$text."]]></ukoncujemUplatnovaniePar17>"."\r\n"; fwrite($soubor, $text);
$obmedzenie=$hlavicka->nerezident;
  $text = "  <obmedzenie><![CDATA[".$obmedzenie."]]></obmedzenie>"."\r\n"; fwrite($soubor, $text);
$prepojenie=$hlavicka->zahrprep;
  $text = "  <prepojenie><![CDATA[".$prepojenie."]]></prepojenie>"."\r\n"; fwrite($soubor, $text);
$platiteldph=$hlavicka->chpld;
  $text = "  <somPlatitel><![CDATA[".$platiteldph."]]></somPlatitel>"."\r\n"; fwrite($soubor, $text);
$obrat=$hlavicka->cho5k;
  $text = "  <rocnyObratPresiahol500tis><![CDATA[".$obrat."]]></rocnyObratPresiahol500tis>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->chpdl;
  $text = "  <polVyskaDanovejLicPar46bods3><![CDATA[".$riadok."]]></polVyskaDanovejLicPar46bods3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->chndl;
  $text = "  <neplatimDanLicenciu><![CDATA[".$riadok."]]></neplatimDanLicenciu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <stalaPrevadzkaren>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->pruli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->prcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->prpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->prmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$pocetSp=1*$hlavicka->prpoc;
if ( $pocetSp == 0 ) { $pocetSp=""; }
  $text = "   <pocetSp><![CDATA[".$pocetSp."]]></pocetSp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </stalaPrevadzkaren>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r100;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r100><![CDATA[".$riadok."]]></r100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r110><![CDATA[".$riadok."]]></r110>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r120;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r120><![CDATA[".$riadok."]]></r120>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r130><![CDATA[".$riadok."]]></r130>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r140;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r140><![CDATA[".$riadok."]]></r140>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r150;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r150><![CDATA[".$riadok."]]></r150>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r160;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r160><![CDATA[".$riadok."]]></r160>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r170;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r170><![CDATA[".$riadok."]]></r170>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r180;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r180><![CDATA[".$riadok."]]></r180>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r200;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r200><![CDATA[".$riadok."]]></r200>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r210;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r210><![CDATA[".$riadok."]]></r210>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r220;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r220><![CDATA[".$riadok."]]></r220>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r230;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r230><![CDATA[".$riadok."]]></r230>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r240;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r240><![CDATA[".$riadok."]]></r240>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r250;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r250><![CDATA[".$riadok."]]></r250>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r260;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r260><![CDATA[".$riadok."]]></r260>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r270;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r270><![CDATA[".$riadok."]]></r270>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r280;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r280><![CDATA[".$riadok."]]></r280>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r290;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r290><![CDATA[".$riadok."]]></r290>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r300;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r300><![CDATA[".$riadok."]]></r300>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r310;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r310><![CDATA[".$riadok."]]></r310>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r320;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r320><![CDATA[".$riadok."]]></r320>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r330;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r330><![CDATA[".$riadok."]]></r330>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r400;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r400><![CDATA[".$riadok."]]></r400>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r410;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r410><![CDATA[".$riadok."]]></r410>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r500;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r500><![CDATA[".$riadok."]]></r500>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r510;
if ( $riadok == 0 ) $riadok="23";
  $text = "  <r510><![CDATA[".$riadok."]]></r510>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r600;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r600><![CDATA[".$riadok."]]></r600>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r610>"."\r\n"; fwrite($soubor, $text);
$text=iconv("CP1250", "UTF-8", $hlavicka->r610text);
  $text = "   <text><![CDATA[".$text."]]></text>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r610;
if ( $riadok == 0 ) $riadok="";
  $text = "   <suma><![CDATA[".$riadok."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r610>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r700;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r700><![CDATA[".$riadok."]]></r700>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r710;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r710><![CDATA[".$riadok."]]></r710>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r800;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r800><![CDATA[".$riadok."]]></r800>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r810;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r810><![CDATA[".$riadok."]]></r810>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r820;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r820><![CDATA[".$riadok."]]></r820>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r830;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r830><![CDATA[".$riadok."]]></r830>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r840;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r840><![CDATA[".$riadok."]]></r840>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r900;
if ( $riadok == 0 ) $riadok="0";
if ( $hlavicka->r901 > 0 ) $riadok="";
  $text = "  <r900><![CDATA[".$riadok."]]></r900>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r910;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r910><![CDATA[".$riadok."]]></r910>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r920;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r920><![CDATA[".$riadok."]]></r920>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r930;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r930><![CDATA[".$riadok."]]></r930>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r940;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r940><![CDATA[".$riadok."]]></r940>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r950;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r950><![CDATA[".$riadok."]]></r950>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r960;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r960><![CDATA[".$riadok."]]></r960>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1000;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1000><![CDATA[".$riadok."]]></r1000>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1001;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1001><![CDATA[".$riadok."]]></r1001>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1010;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1010><![CDATA[".$riadok."]]></r1010>"."\r\n"; fwrite($soubor, $text);

$ddpDatum=SkDatum($hlavicka->dadod);
if ( $ddp == 0 ) $ddpDatum="";
  $text = "  <ddpDatum><![CDATA[".$ddpDatum."]]></ddpDatum>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1020;
if ( $riadok == 0 ) $riadok="0.00";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1020><![CDATA[".$riadok."]]></r1020>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1030;
if ( $riadok == 0 ) $riadok="";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1030><![CDATA[".$riadok."]]></r1030>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1040;
if ( $riadok == 0 ) $riadok="";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1040><![CDATA[".$riadok."]]></r1040>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1050;
if ( $riadok == 0 ) $riadok="";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1050><![CDATA[".$riadok."]]></r1050>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1060;
if ( $riadok == 0 ) $riadok="";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1060><![CDATA[".$riadok."]]></r1060>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1070;
if ( $riadok == 0 ) $riadok="";
if ( $ddp == 0 ) $riadok="";
  $text = "  <r1070><![CDATA[".$riadok."]]></r1070>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabA>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r08;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r09;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r11><![CDATA[".$riadok."]]></r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r12><![CDATA[".$riadok."]]></r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r13><![CDATA[".$riadok."]]></r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r14><![CDATA[".$riadok."]]></r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r15><![CDATA[".$riadok."]]></r15>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabA>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabB>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabB>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabC1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabC1>"."\r\n"; fwrite($soubor, $text);
  
  $text = "  <tabC2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->c2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabC2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabD>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs01>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r02;
if( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs02>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs03>"."\r\n"; fwrite($soubor, $text);
$datumod3=SkDatum($hlavicka->d3od);
if ( $datumod3 == '00.00.0000' ) $datumod3="";
  $text = "    <r01od><![CDATA[".$datumod3."]]></r01od>"."\r\n"; fwrite($soubor, $text);
$datumdo3=SkDatum($hlavicka->d3do);
if ( $datumdo3 == '00.00.0000' ) $datumdo3="";
  $text = "    <r01do><![CDATA[".$datumdo3."]]></r01do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs03>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs04>"."\r\n"; fwrite($soubor, $text);
$datumod4=SkDatum($hlavicka->d4od);
if ( $datumod4 == '00.00.0000' ) $datumod4="";
  $text = "    <r01od><![CDATA[".$datumod4."]]></r01od>"."\r\n"; fwrite($soubor, $text);
$datumdo4=SkDatum($hlavicka->d4do);
if ( $datumdo4 == '00.00.0000' ) $datumdo4="";
  $text = "    <r01do><![CDATA[".$datumdo4."]]></r01do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs04>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs05>"."\r\n"; fwrite($soubor, $text);
$datumod5=SkDatum($hlavicka->d5od);
if ( $datumod5 == '00.00.0000' ) $datumod5="";
  $text = "    <r01od><![CDATA[".$datumod5."]]></r01od>"."\r\n"; fwrite($soubor, $text);
$datumdo5=SkDatum($hlavicka->d5do);
if ( $datumdo5 == '00.00.0000' ) $datumdo5="";
  $text = "    <r01do><![CDATA[".$datumdo5."]]></r01do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs05>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs06>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabD>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabE>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->e1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabE>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabF>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->f1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabF>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabG1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG1>"."\r\n"; fwrite($soubor, $text);
  $text = "  <tabG2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG2>"."\r\n"; fwrite($soubor, $text);
  $text = "  <tabG3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->g3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabG3>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabH>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->hr01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h1r09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
  $text = "   </prijmy>"."\r\n"; fwrite($soubor, $text);

  $text = "   <vydavky>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->h2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->h2r09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);
  $text = "   </vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->hr10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabH>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabI>"."\r\n"; fwrite($soubor, $text);
  $text = "   <vynosy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i1r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "   </vynosy>"."\r\n"; fwrite($soubor, $text);

  $text = "   <naklady>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->i2r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);
  $text = "   </naklady>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabI>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabJ>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabJ>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabK>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs01>"."\r\n"; fwrite($soubor, $text);
$datumk1od=SkDatum($hlavicka->k1od);
if ( $datumk1od == '00.00.0000' ) $datumk1od="";
  $text = "    <r01s01od><![CDATA[".$datumk1od."]]></r01s01od>"."\r\n"; fwrite($soubor, $text);
$datumk1do=SkDatum($hlavicka->k1do);
if ( $datumk1do == '00.00.0000' ) $datumk1do="";
  $text = "    <r01s01do><![CDATA[".$datumk1do."]]></r01s01do>"."\r\n"; fwrite($soubor, $text);
$datumk2od=SkDatum($hlavicka->k2od);
if ( $datumk2od == '00.00.0000' ) $datumk2od="";
  $text = "    <r02s01od><![CDATA[".$datumk2od."]]></r02s01od>"."\r\n"; fwrite($soubor, $text);
$datumk2do=SkDatum($hlavicka->k2do);
if ( $datumk2do == '00.00.0000' ) $datumk2do="";
  $text = "    <r02s01do><![CDATA[".$datumk2do."]]></r02s01do>"."\r\n"; fwrite($soubor, $text);
$datumk3od=SkDatum($hlavicka->k3od);
if ( $datumk3od == '00.00.0000' ) $datumk3od="";
  $text = "    <r03s01od><![CDATA[".$datumk3od."]]></r03s01od>"."\r\n"; fwrite($soubor, $text);
$datumk3do=SkDatum($hlavicka->k3do);
if ( $datumk3do == '00.00.0000' ) $datumk3do="";
  $text = "    <r03s01do><![CDATA[".$datumk3do."]]></r03s01do>"."\r\n"; fwrite($soubor, $text);
$datumk4od=SkDatum($hlavicka->k4od);
if ( $datumk4od == '00.00.0000' ) $datumk4od="";
  $text = "    <r04s01od><![CDATA[".$datumk4od."]]></r04s01od>"."\r\n"; fwrite($soubor, $text);
$datumk4do=SkDatum($hlavicka->k4do);
if ( $datumk4do == '00.00.0000' ) $datumk4do="";
  $text = "    <r04s01do><![CDATA[".$datumk4do."]]></r04s01do>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs01>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s02><![CDATA[".$riadok."]]></r01s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s02><![CDATA[".$riadok."]]></r02s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s02><![CDATA[".$riadok."]]></r03s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k2r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s02><![CDATA[".$riadok."]]></r04s02>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs02>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s03><![CDATA[".$riadok."]]></r03s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s03><![CDATA[".$riadok."]]></r04s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs03>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s04><![CDATA[".$riadok."]]></r02s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s04><![CDATA[".$riadok."]]></r03s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s04><![CDATA[".$riadok."]]></r04s04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05s04><![CDATA[".$riadok."]]></r05s04>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs04>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabKs05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s05><![CDATA[".$riadok."]]></r01s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s05><![CDATA[".$riadok."]]></r02s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s05><![CDATA[".$riadok."]]></r03s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s05><![CDATA[".$riadok."]]></r04s05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k5r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r05s05><![CDATA[".$riadok."]]></r05s05>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs05>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabK>"."\r\n"; fwrite($soubor, $text);

$paragraf50=$hlavicka->pzano;
if ( $hlavicka->pcsum == 0 ) { $paragraf50=1; }
  $text = "  <c4paragraf50><![CDATA[".$paragraf50."]]></c4paragraf50>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpoc;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r1><![CDATA[".$riadok."]]></c4r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcdar;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r2><![CDATA[".$riadok."]]></c4r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpod;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r3><![CDATA[".$riadok."]]></c4r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pc15;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r4><![CDATA[".$riadok."]]></c4r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcdar5;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r5><![CDATA[".$riadok."]]></c4r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpod5;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r6><![CDATA[".$riadok."]]></c4r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pc155;
if ( $paragraf50 == 1 OR $riadok == 0 ) $riadok="";
  $text = "  <c4r7><![CDATA[".$riadok."]]></c4r7>"."\r\n"; fwrite($soubor, $text);

  $text = "  <c4prijimatel1>"."\r\n"; fwrite($soubor, $text);
$suma=$hlavicka->pcsum;
if ( $paragraf50 == 1 OR $suma == 0 ) $suma="";
  $text = "   <suma><![CDATA[".$suma."]]></suma>"."\r\n"; fwrite($soubor, $text);
$pico1=$hlavicka->p1ico;
if ( $paragraf50 == 1 OR $pico1 == 0 ) $pico1="";
if ( $hlavicka->p1ico < 1000000 AND $hlavicka->p1ico > 1 ) { $pico1="00".$hlavicka->p1ico; }
  $text = "   <ico><![CDATA[".$pico1."]]></ico>"."\r\n"; fwrite($soubor, $text);
$psid1=$hlavicka->p1sid;
if ( $paragraf50 == 1 OR $psid1 == 0 ) $psid1="";
  $text = "   <sid><![CDATA[".$psid1."]]></sid>"."\r\n"; fwrite($soubor, $text);
$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->p1pfr);
if ( $paragraf50 == 1 ) $pravnaForma="";
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,0,37));
$obchodneMeno2=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,37,36));
if ( $paragraf50 == 1 ) { $obchodneMeno=""; $obchodneMeno2=""; }
  $text = "    <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <riadok><![CDATA[".$obchodneMeno2."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->p1uli);
if ( $paragraf50 == 1 ) $ulica="";
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->p1cdm;
if ( $paragraf50 == 1 ) $cislo="";
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->p1psc;
if ( $paragraf50 == 1 ) $psc="";
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->p1mes);
if ( $paragraf50 == 1 ) $obec="";
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </c4prijimatel1>"."\r\n"; fwrite($soubor, $text);

$osobitneZaznamy=iconv("CP1250", "UTF-8", $hlavicka->osobit);
  $text = "  <osobitneZaznamy><![CDATA[".$osobitneZaznamy."]]></osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);

  $text = "  <opravnenaOsoba>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->ooprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->oomeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=$hlavicka->ootitl;
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titul=$hlavicka->otitz;
  $text = "   <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$postavenie=iconv("CP1250", "UTF-8", $hlavicka->oopost);
  $text = "   <postavenie><![CDATA[".$postavenie."]]></postavenie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <trvalyPobyt>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->oouli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->oocdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->oopsc;
  $text = "    <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->oomes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->oostat);
  $text = "    <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$otelefon=$hlavicka->ootel;
  $text = "    <tel><![CDATA[".$otelefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$oemailfax=iconv("CP1250", "UTF-8", $hlavicka->oofax);
  $text = "    <emailFax><![CDATA[".$oemailfax."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "   </trvalyPobyt>"."\r\n"; fwrite($soubor, $text);
  $text = "  </opravnenaOsoba>"."\r\n"; fwrite($soubor, $text);

$pocetPriloh=$hlavicka->pril;
if ( $pocetPriloh == 0 ) $pocetPriloh="";
  $text = "  <pocetPriloh><![CDATA[".$pocetPriloh."]]></pocetPriloh>"."\r\n"; fwrite($soubor, $text);
$datumvyhl=SkDatum($hlavicka->datum);
if ( $datumvyhl == '00.00.0000' ) $datumvyhl="";
  $text = "  <datumVyhlasenia><![CDATA[".$datumvyhl."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);
$vratit=$hlavicka->vrat;
  $text = "   <vratit><![CDATA[".$vratit."]]></vratit>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n";   fwrite($soubor, $text);
$poukazka=$hlavicka->vrpp;
if ( $vratit == 0 OR $hlavicka->vruc == 1 ) $poukazka="0";
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->vruc;
if ( $vratit == 0 ) $ucet="0";
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban="";
if ( $hlavicka->vruc == 1 AND $hlavicka->vrat == 1 ) { $iban=$fir_fib1; }
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);
$pole = explode("-", $fir_fuc1);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if ( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }
if ( $ucet == 0 ) $predcislieUctu="";
  $text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);
$ucet="";
if ( $hlavicka->vruc == 1 AND $hlavicka->vrat == 1 ) { $ucet=$cisloUctu; }
  $text = "    <cisloUctu><![CDATA[".$ucet."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky="";
if ( $hlavicka->vruc == 1 AND $hlavicka->vrat == 1 ) { $kodBanky=$fir_fnm1; }
  $text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum_sk=SkDatum($hlavicka->datuk);
if ( $datum_sk == '00.00.0000' ) $datum_sk="";
  $text = "   <datum><![CDATA[".$datum_sk."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);

  $text = "  <dividendy>"."\r\n"; fwrite($soubor, $text);
  $text = "   <divr01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzs01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </divr01>"."\r\n"; fwrite($soubor, $text);
  $text = "   <divr02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzs02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzd02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </divr02>"."\r\n"; fwrite($soubor, $text);
  $text = "   <divr03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzs03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzd03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </divr03>"."\r\n"; fwrite($soubor, $text);
  $text = "   <divr04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzs04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzd04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </divr04>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pzr05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr05><![CDATA[".$riadok."]]></divr05>"."\r\n"; fwrite($soubor, $text);
$riadok="15";
  $text = "   <divr06><![CDATA[".$riadok."]]></divr06>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr07;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr07><![CDATA[".$riadok."]]></divr07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr08;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr08><![CDATA[".$riadok."]]></divr08>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr09;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr09><![CDATA[".$riadok."]]></divr09>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr10><![CDATA[".$riadok."]]></divr10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr11><![CDATA[".$riadok."]]></divr11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr12><![CDATA[".$riadok."]]></divr12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr13><![CDATA[".$riadok."]]></divr13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr14><![CDATA[".$riadok."]]></divr14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr15><![CDATA[".$riadok."]]></divr15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzr16;
if ( $riadok == 0 ) $riadok="";
  $text = "   <divr16><![CDATA[".$riadok."]]></divr16>"."\r\n"; fwrite($soubor, $text);
$datum_pz=SkDatum($hlavicka->pzdat);
if ( $datum_pz == '00.00.0000' ) $datum_pz="";
  $text = "   <datum><![CDATA[".$datum_pz."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </dividendy>"."\r\n"; fwrite($soubor, $text);

//vytlac prilohu
$sqlttp = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cis > 0 ORDER BY p1cis";
$sqlp = mysql_query("$sqlttp");
if ($sqlp) { $polp = mysql_num_rows($sqlp); }
$strxx=$polp/3;
$polp=ceil($strxx);
$polp=$polp*3;

$ip=0;
$stranap=0;
$stlpecp=1;
  while ( $ip < $polp )
  {
@$zaznam=mysql_data_seek($sqlp,$ip);
$hlavickap=mysql_fetch_object($sqlp);

if ( $stlpecp == 1 ) {
$stranap=$stranap+1;

  $text = "  <priloha>"."\r\n"; fwrite($soubor, $text);
                     }
  $text = "   <prijimatel>"."\r\n"; fwrite($soubor, $text);

//p1cpl  psys  druh  p1cis  pcsum  p1ico  p1sid  p1pfr  p1men  p1uli  p1cdm  p1psc  p1mes  ico 

$poradoveCislo=$hlavickap->p1cis;
$suma=1*$hlavickap->pcsum;
$pico=$hlavickap->p1ico;
if ( $hlavickap->p1ico < 1000000 AND $hlavickap->p1ico > 0 ) { $pico="00".$hlavickap->p1ico; }
$psid=$hlavickap->p1sid;
$pravnaForma=iconv("CP1250", "UTF-8", $hlavickap->p1pfr);
$obchodneMeno=iconv("CP1250", "UTF-8", $hlavickap->p1men);
$ulica=iconv("CP1250", "UTF-8", $hlavickap->p1uli);
$cislo=$hlavickap->p1cdm;
$psc=$hlavickap->p1psc;
$obec=iconv("CP1250", "UTF-8", $hlavickap->p1mes);
if ( $suma == 0 ) { $suma=""; $poradoveCislo=""; $icosid=""; $pravnaForma=""; $obchodneMeno=""; $ulica=""; $cislo="";  $psc=""; $obec=""; }

  $text = "    <poradoveCislo><![CDATA[".$poradoveCislo."]]></poradoveCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "    <suma><![CDATA[".$suma."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "    <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);
  $text = "    <sid><![CDATA[".$psid."]]></sid>"."\r\n"; fwrite($soubor, $text);
  $text = "    <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);

  $text = "    <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = "     <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "     <riadok></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "    </obchodneMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "    <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
  $text = "    <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "   </prijimatel>"."\r\n"; fwrite($soubor, $text);

if ( $stlpecp == 3 ) {
  $text = "  </priloha>"."\r\n"; fwrite($soubor, $text);
                     }

$ip = $ip + 1;
$stlpecp = $stlpecp + 1;
if ( $stlpecp == 4 ) $stlpecp=1;
  }
//koniec vytlac prilohu

//ukonci cely dokument a telo
  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>

<?php if ( $elsubor == 2 ) { ?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.financnasprava.sk alebo do aplikácie eDane:
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />
<?php                      }
?>

<?php
//mysql_free_result($vysledok);
     }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>