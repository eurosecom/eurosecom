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


//vypocty
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET prpods=prpod1+prpod2+prpod3+prpod4+prpod5, prppp=1 WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");


$prpodv=0;
$sqlttt = "SELECT SUM(prpods) AS sums, SUM(prppp) AS sump FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $prpodv=$riaddok->sums;
 $prppp=$riaddok->sump;
 }

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET prpodv='$prpodv', prppp='$prppp' WHERE prcpl > 0 ";
$sqldok = mysql_query("$sqlttt");

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

//hlavicka OK podla definicie pre rok 2015
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

//zmena 2015
$zapdl=$hlavicka->zapdl;
  $text = "  <zapocitaniePar46b><![CDATA[".$zapdl."]]></zapocitaniePar46b>"."\r\n"; fwrite($soubor, $text);
//koniec zmena 2015

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

//hlavicka OK podla definicie pre rok 2015

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

//zmena 2015
$riadok=$hlavicka->r301;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r301><![CDATA[".$riadok."]]></r301>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r302;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r302><![CDATA[".$riadok."]]></r302>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r303;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r303><![CDATA[".$riadok."]]></r303>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r304;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r304><![CDATA[".$riadok."]]></r304>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r305;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r305><![CDATA[".$riadok."]]></r305>"."\r\n"; fwrite($soubor, $text);

//koniec zmena 2015

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

//zmena 2015
$riadok=$hlavicka->r501;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r501><![CDATA[".$riadok."]]></r501>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r510;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r510><![CDATA[".$riadok."]]></r510>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavicka->r550;
if ( $riadok == 0 ) $riadok="0";
  $text = "  <r550><![CDATA[".$riadok."]]></r550>"."\r\n"; fwrite($soubor, $text);

//koniec zmena 2015

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

//zmena 2015
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
$riadok=$hlavicka->r1000;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1000><![CDATA[".$riadok."]]></r1000>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1010;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1010><![CDATA[".$riadok."]]></r1010>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1020;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1020><![CDATA[".$riadok."]]></r1020>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1030;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1030><![CDATA[".$riadok."]]></r1030>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1040;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1040><![CDATA[".$riadok."]]></r1040>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1050;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1050><![CDATA[".$riadok."]]></r1050>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1100;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1100><![CDATA[".$riadok."]]></r1100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1101;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1101><![CDATA[".$riadok."]]></r1101>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1110;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1110><![CDATA[".$riadok."]]></r1110>"."\r\n"; fwrite($soubor, $text);

//koniec zmena 2015

$ddpDatum=SkDatum($hlavicka->dadod);
if ( $ddp == 0 ) $ddpDatum="";
  $text = "  <ddpDatum><![CDATA[".$ddpDatum."]]></ddpDatum>"."\r\n"; fwrite($soubor, $text);

//zmena 2015

$riadok=$hlavicka->r1120;
if ( $riadok == 0 ) $riadok="0.00";
  $text = "  <r1120><![CDATA[".$riadok."]]></r1120>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1130><![CDATA[".$riadok."]]></r1130>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1140;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1140><![CDATA[".$riadok."]]></r1140>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r1150;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r1150><![CDATA[".$riadok."]]></r1150>"."\r\n"; fwrite($soubor, $text);

//koniec zmena 2015

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
//zmena 2015
$riadok=$hlavicka->a1r16;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r16><![CDATA[".$riadok."]]></r16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->a1r17;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r17><![CDATA[".$riadok."]]></r17>"."\r\n"; fwrite($soubor, $text);
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
//zmena 2015
$riadok=$hlavicka->b1r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->b1r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
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

//zmena 2015 tabD
  $text = "  <tabD>"."\r\n"; fwrite($soubor, $text);
  $text = "   <tabDs01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d1r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d2od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d2do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d2r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d3od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d3do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d3r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d4od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d4do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d4r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d5od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d5do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d5r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs05>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs06>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d6od);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumOd><![CDATA[".$riadok."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->d6do);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumDo><![CDATA[".$riadok."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r01;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d6r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs06>"."\r\n"; fwrite($soubor, $text);

  $text = "   <tabDs07>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d7r02;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->d7r03;
if ( $riadok == 0 ) $riadok="0";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabDs07>"."\r\n"; fwrite($soubor, $text);


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

//zmena 2015 tabJ
  $text = "  <tabJ>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->jl1r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabJ>"."\r\n"; fwrite($soubor, $text);

//zmena 2015 tabK
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
$riadok=$hlavicka->k3r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s03><![CDATA[".$riadok."]]></r01s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r02s03><![CDATA[".$riadok."]]></r02s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r03s03><![CDATA[".$riadok."]]></r03s03>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k3r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r04s03><![CDATA[".$riadok."]]></r04s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tabKs03>"."\r\n"; fwrite($soubor, $text);


  $text = "   <tabKs04>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->k4r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r01s04><![CDATA[".$riadok."]]></r01s04>"."\r\n"; fwrite($soubor, $text);
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

//zmena 2015
$riadok=$hlavicka->zslu;
  $text = "    <suhlasZasl><![CDATA[".$riadok."]]></suhlasZasl>"."\r\n"; fwrite($soubor, $text);


//zmena 2015
$riadok=$hlavicka->pcpoc;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r1><![CDATA[".$riadok."]]></c4r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcdar;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r2><![CDATA[".$riadok."]]></c4r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pcpod;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r3><![CDATA[".$riadok."]]></c4r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pc15;
if ( $riadok == 0 ) $riadok="";
  $text = "  <c4r4><![CDATA[".$riadok."]]></c4r4>"."\r\n"; fwrite($soubor, $text);

  $text = "  <c4prijimatel1>"."\r\n"; fwrite($soubor, $text);
$suma=$hlavicka->pcsum;
if ( $suma == 0 ) $suma="";
  $text = "   <suma><![CDATA[".$suma."]]></suma>"."\r\n"; fwrite($soubor, $text);
$pico1=$hlavicka->p1ico;
if ( $pico1 == 0 ) $pico1="";
if ( $hlavicka->p1ico < 1000000 AND $hlavicka->p1ico > 1 ) { $pico1="00".$hlavicka->p1ico; }
  $text = "   <ico><![CDATA[".$pico1."]]></ico>"."\r\n"; fwrite($soubor, $text);
$psid1=$hlavicka->p1sid;
if ( $psid1 == 0 ) $psid1="";
  $text = "   <sid><![CDATA[".$psid1."]]></sid>"."\r\n"; fwrite($soubor, $text);
$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->p1pfr);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,0,37));
$obchodneMeno2=iconv("CP1250", "UTF-8", substr($hlavicka->p1men,37,36));
if ( $paragraf50 == 1 ) { $obchodneMeno=""; $obchodneMeno2=""; }
  $text = "    <riadok><![CDATA[".$obchodneMeno."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <riadok><![CDATA[".$obchodneMeno2."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->p1uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->p1cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->p1psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->p1mes);
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

//zmena 2015
//vytlac prilohu o projektoch

$sqlttp = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpr > 0 ORDER BY prcpr ";
$sqlp = mysql_query("$sqlttp");
if ($sqlp) { $polp = mysql_num_rows($sqlp); }
$strxx=$polp/1;
$polp=ceil($strxx);

$ip=0;
$stranap=0;
$stlpecp=1;
  while ( $ip < $polp )
  {
@$zaznam=mysql_data_seek($sqlp,$ip);
$hlavickap=mysql_fetch_object($sqlp);

  $text = "  <prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavickap->prcpr;
if ( $riadok == 0 ) $riadok="";
  $text = "    <projektCislo><![CDATA[".$riadok."]]></projektCislo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prppp;
if ( $riadok == 0 ) $riadok="";
  $text = "    <pocetProjektov><![CDATA[".$riadok."]]></pocetProjektov>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpdzc);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumRealizacie><![CDATA[".$riadok."]]></datumRealizacie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzo5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Od><![CDATA[".$riadok."]]></s01Od>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavickap->prpzd5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <s01Do><![CDATA[".$riadok."]]></s01Do>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpvz5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s02><![CDATA[".$riadok."]]></s02>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpod5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s03><![CDATA[".$riadok."]]></s03>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r05>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavickap->prpods;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->prptxt);
  $text = "    <ciele><![CDATA[".$riadok."]]></ciele>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavickap->prpodv;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);

  $text = "  </prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$ip = $ip + 1;
  }


//koniec vytlac prilohu o projektoch

//vytlac prilohu o prijimateloch
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
//koniec vytlac prilohu o prijimateloch


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