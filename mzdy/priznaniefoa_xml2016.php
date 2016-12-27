<!doctype html>
<HTML>
<?php
//XML pre FOA 2016
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

$zablokovane=0;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Daòové priznanie XML bude pripravené v priebehu januára 2017. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
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

$cislo_oc = $_REQUEST['cislo_oc'];
$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEFOA_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;

//zober data z kun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  $prie=$riaddok->prie;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - FOA xml export</title>
<style>
#content {
  box-sizing: border-box;
  background-color: white;
  padding: 30px 25px;
   -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
#content > p {
  line-height: 22px;
  font-size: 14px;
}
#content > p > a {
  color: #00e;
}
#content > p > a:hover {
  text-decoration: underline;
}
#upozornenie > h2 {
  line-height: 20px;
  margin-top: 25px;
  margin-bottom: 10px;
  overflow: auto;
}
#upozornenie > h2 > strong {
  font-size: 16px;
  font-weight: bold;
}
#upozornenie > ul > li {
  line-height: 18px;
  margin: 10px 0;
  font-size: 13px;
}
.red {
  border-left: 4px solid #f22613;
  text-indent: 8px;
}
.orange {
  border-left: 4px solid #f89406;
  text-indent: 8px;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 11px;
  position: relative;
  top: 5px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
.box-red {
  background-color: #f22613;
}
.box-orange {
  background-color: #f89406;
}
.header-section {
  padding-top: 5px;
}
</style>
</HEAD>
<BODY>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Daò z príjmov FOA / Export XML - <span class="subheader"><?php echo "$cislo_oc $meno $prie";?></span></td>
   <td></td>
  </tr>
 </table>
</div>
<?php
//XML SUBOR elsubor=2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");
?>

<?php
//rok2016
$sqlt = <<<mzdprc
(

);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc ";

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
?>

<?php
if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);		

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$rodneCislo=$hlavicka->fdic;
  $text = "  <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);

$datumNarodenia=SkDatum($hlavicka->dar);
  if ( $datumNarodenia == '00.00.0000' ) $datumNarodenia="";
  $text = "  <datumNarodenia><![CDATA[".$datumNarodenia."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n";   fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$datumDDP=SkDatum($hlavicka->ddp); //$datumDDP=""; if ( $ddp == 1 )
if ( $datumDDP == '00.00.0000' ) $datumDDP="";
  $text = "   <datumDDP><![CDATA[".$datumDDP."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);

$meno=iconv("CP1250", "UTF-8", $hlavicka->dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);

$titul=iconv("CP1250", "UTF-8", $hlavicka->dtitl);
  $text = "  <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);

$titul=iconv("CP1250", "UTF-8", $hlavicka->dtitz);
  $text = "  <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaTrvPobytu>"."\r\n";   fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->duli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->dcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->dpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->dmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);

$stat=iconv("CP1250", "UTF-8", $hlavicka->xstat);
if ( $stat == '' ) $stat="SR";
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);

$nerezident=$hlavicka->nrz;
  $text = "  <nerezident><![CDATA[".$nerezident."]]></nerezident>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->d2uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->d2cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->d2psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->d2mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaObvPobytu>"."\r\n";   fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->zprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->zmeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitl);
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitz);
  $text = "   <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->zrdc.$hlavicka->zrdk;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=iconv("CP1250", "UTF-8", $hlavicka->zcdm);
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->zpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->zstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$hlavicka->dtel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mailfax=iconv("CP1250", "UTF-8", $hlavicka->dmailfax);
  $text = "   <email><![CDATA[".$mailfax."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = " <telo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r27;
  $text = "  <r27><![CDATA[".$riadok."]]></r27>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r28;
  $text = "  <r28><![CDATA[".$riadok."]]></r28>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r29>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->mprie);
  $text = "   <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->mrod;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$vlastnePrijmy=$hlavicka->mpri;
if ( $hlavicka->mpri == 0 ) $vlastnePrijmy="0.00";
  $text = "   <vlastnePrijmy><![CDATA[".$vlastnePrijmy."]]></vlastnePrijmy>"."\r\n"; fwrite($soubor, $text);
$pocetMesiacov=$hlavicka->mpom;
if ( $hlavicka->mpom == 0 ) $pocetMesiacov="";
  $text = "   <pocetMesiacov><![CDATA[".$pocetMesiacov."]]></pocetMesiacov>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r29>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r30>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d1prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d1rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00="$hlavicka->d1pomc";
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d1pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d1pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d1pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d1pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d1pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d1pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d1pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d1pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d1pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d1pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d1pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d1pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d2prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d2rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d2pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d2pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d2pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d2pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d2pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d2pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d2pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d2pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d2pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d2pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d2pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d2pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d2pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>	"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d3rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>	"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d3pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d3pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d3pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d3pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d3pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d3pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d3pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d3pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d3pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d3pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d3pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d3pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d3pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d4prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d4rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d4pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d4pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d4pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d4pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d4pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d4pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d4pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d4pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d4pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d4pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d4pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d4pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d4pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r30>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->det4;
  $text = "  <r31viacAko4><![CDATA[".$riadok."]]></r31viacAko4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r32;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r32><![CDATA[".$riadok."]]></r32>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r32a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r32a><![CDATA[".$riadok."]]></r32a>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33><![CDATA[".$riadok."]]></r33>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33a><![CDATA[".$riadok."]]></r33a>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33b;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33b><![CDATA[".$riadok."]]></r33b>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r34;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34><![CDATA[".$riadok."]]></r34>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r35;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r35><![CDATA[".$riadok."]]></r35>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r36;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r36><![CDATA[".$riadok."]]></r36>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r37;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r37><![CDATA[".$riadok."]]></r37>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r38;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r38><![CDATA[".$riadok."]]></r38>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r39;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r39><![CDATA[".$riadok."]]></r39>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r40;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r40><![CDATA[".$riadok."]]></r40>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r41;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r41><![CDATA[".$riadok."]]></r41>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r42;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r42><![CDATA[".$riadok."]]></r42>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r43;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r43><![CDATA[".$riadok."]]></r43>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r44;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r44><![CDATA[".$riadok."]]></r44>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r45;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r45><![CDATA[".$riadok."]]></r45>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r46;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r46><![CDATA[".$riadok."]]></r46>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r47;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r47><![CDATA[".$riadok."]]></r47>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r48;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r48><![CDATA[".$riadok."]]></r48>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r49;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r49><![CDATA[".$riadok."]]></r49>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r50;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r50><![CDATA[".$riadok."]]></r50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r51;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r51><![CDATA[".$riadok."]]></r51>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r52;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r52><![CDATA[".$riadok."]]></r52>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r53;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r53><![CDATA[".$riadok."]]></r53>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r54;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r54><![CDATA[".$riadok."]]></r54>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r55;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r55><![CDATA[".$riadok."]]></r55>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r56;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r56><![CDATA[".$riadok."]]></r56>"."\r\n"; fwrite($soubor, $text);
  
$riadok=$hlavicka->r57;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r57><![CDATA[".$riadok."]]></r57>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r58;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r58><![CDATA[".$riadok."]]></r58>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r59;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r59><![CDATA[".$riadok."]]></r59>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r60;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r60><![CDATA[".$riadok."]]></r60>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r61;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r61><![CDATA[".$riadok."]]></r61>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r62;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r62><![CDATA[".$riadok."]]></r62>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r63;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r63><![CDATA[".$riadok."]]></r63>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r63a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r63a><![CDATA[".$riadok."]]></r63a>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r64;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r64><![CDATA[".$riadok."]]></r64>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r65;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r65><![CDATA[".$riadok."]]></r65>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r66;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r66><![CDATA[".$riadok."]]></r66>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r67;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r67><![CDATA[".$riadok."]]></r67>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r68;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r68><![CDATA[".$riadok."]]></r68>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r69;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r69><![CDATA[".$riadok."]]></r69>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r70;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r70><![CDATA[".$riadok."]]></r70>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r71;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r71><![CDATA[".$riadok."]]></r71>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r72;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r72><![CDATA[".$riadok."]]></r72>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r73;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r73><![CDATA[".$riadok."]]></r73>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r74;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r74><![CDATA[".$riadok."]]></r74>"."\r\n"; fwrite($soubor, $text);

$pgf50=$hlavicka->upl50;
  $text = "  <paragraf50><![CDATA[".$pgf50."]]></paragraf50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->spln3;
  $text = "  <splnam3per><![CDATA[".$riadok."]]></splnam3per>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r75;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r75><![CDATA[".$riadok."]]></r75>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r76>"."\r\n"; fwrite($soubor, $text);
$pico=$hlavicka->pico;
if ( $pico == 0 ) $pico="";
if ( $hlavicka->pico < 1000000 AND $hlavicka->pico > 1 ) { $pico="00".$hlavicka->pico; }
  $text = "   <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);

$psid=$hlavicka->psid;
if ( $psid == 0 ) $psid="";
  $text = "   <sid><![CDATA[".$psid."]]></sid>"."\r\n"; fwrite($soubor, $text);

$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->pfor);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  
  $text = "   <obchMeno>"."\r\n";   fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pmen);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n";   fwrite($soubor, $text);
  
$ulica=iconv("CP1250", "UTF-8", $hlavicka->puli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->pcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->ppsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->pmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r76>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->zslu;
  $text = "    <suhlasZaslat><![CDATA[".$riadok."]]></suhlasZaslat>"."\r\n"; fwrite($soubor, $text);
  
  $text = "  <osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);
$uvadza=$hlavicka->uoso;
  $text = "   <uvadza><![CDATA[".$uvadza."]]></uvadza>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks1;
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks2;
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks3;
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

$zaznamy=iconv("CP1250", "UTF-8", $hlavicka->osob);
  $text = "   <zaznamy><![CDATA[".$zaznamy."]]></zaznamy>"."\r\n"; fwrite($soubor, $text);
  $text = "  </osobitneZaznamy>"."\r\n";   fwrite($soubor, $text);

$riadok=iconv("CP1250", "UTF-8", $hlavicka->sdnr);
  $text = "  <r77><![CDATA[".$riadok."]]></r77>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->udnr;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r78><![CDATA[".$riadok."]]></r78>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pril;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r79><![CDATA[".$riadok."]]></r79>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->dat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "  <datumVyhlasenia><![CDATA[".$datum."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);
$vypbonus=$hlavicka->zdbo;
  $text = "   <vyplatitDanovyBonus><![CDATA[".$vypbonus."]]></vyplatitDanovyBonus>"."\r\n"; fwrite($soubor, $text);
$vyplatitZamPremiu=$hlavicka->zpre;
  $text = "   <vyplatitZamPremiu><![CDATA[".$vyplatitZamPremiu."]]></vyplatitZamPremiu>"."\r\n"; fwrite($soubor, $text);
$vypprepl=$hlavicka->zprp;
  $text = "   <vratitDanPreplatok><![CDATA[".$vypprepl."]]></vratitDanPreplatok>"."\r\n"; fwrite($soubor, $text);

  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
$poukazka=$hlavicka->post;
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->ucet;
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban=$hlavicka->diban;
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

//tagy predcislieUctu, cisloUctu a kodBanky vymazali z XSD 2016, keï sa to snažím naèíta do FOA2015 tak ich chce, uvidíme až dorobia FOA 2016
// na portály FS
$nerob=0;
if( $nerob == 0 )
  {
$pole = explode("-", $hlavicka->uceb);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }

if ( $ucet == 0 ) $predcislieUctu="";
  $text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);

if ( $ucet == 0 ) $cisloUctu="";
  $text = "    <cisloUctu><![CDATA[".$cisloUctu."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky=$hlavicka->numb;
if ( $ucet == 0 ) $kodBanky="";
  $text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  }

  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->da2);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);

$pomocneVypocty=iconv("CP1250", "UTF-8", $hlavicka->pomv);
  $text = "  <pomocneVypocty><![CDATA[".$pomocneVypocty."]]></pomocneVypocty>"."\r\n"; fwrite($soubor, $text);

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
<div id="content">
<?php if ( $elsubor == 2 ) { ?>
<p>Stiahnite si nižšie uvedený súbor <strong>.xml</strong> do Vášho poèítaèa a naèítajte ho na
<a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Stránka Finanènej správy">www.financnasprava.sk</a> alebo do aplikácie eDane:
</p>
<p>
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
</p>
<?php                      } ?>

<?php
/////////////////////////////////////////////////////////////////////UPOZORNENIE
$upozorni1=0; $upozorni2=0; $upozorni4=0; $upozorni5=0; $upozorni6=0;
?>
<div id="upozornenie" style="display:none;">
<h2>
<strong class="toleft">Upozornenie</strong>
<dl class="toright legend-area">
 <dt class="toleft box-red"></dt><dd class="toleft">kritické</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logické</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( $hlavicka->fdic == "0" AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Nie je vyplnené <strong>DIÈ</strong> daòovníka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->dar != '0000-00-00' AND $hlavicka->fdic != "0" )
{
$upozorni1=1;
echo "Súèasne vyplnené <strong>diè</strong> aj <strong>dátum narodenia</strong> daòovníka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->nrz == 1 AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>nerezidentovi</strong> (bod 11) nie je vyplnený jeho <strong>dátum narodenia</strong> v bode 2.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->druh == 3 AND $hlavicka->ddp == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>dodatoènom</strong> daòovom priznaní <strong> nie je vyplnený dátum</strong> zistenia skutoènosti na podanie dodatoèného priznania.";
}
?>
</li>
<li class="red">
<?php if ( ( $hlavicka->druh == 1 OR $hlavicka->druh == 2 ) AND $hlavicka->ddp != '0000-00-00' )
{
$upozorni1=1;
echo "Vyplnený <strong>dátum</strong> zistenia skutoènosti na podanie dodatoèného priznania, ale <strong>nie je</strong> vybraté dodatoèné daòové priznanie.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->dprie == "" OR $hlavicka->dmeno == "" )
{
$upozorni1=1;
echo "Nie je vyplnené <strong>priezvisko alebo meno</strong> daòovníka.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->dcdm == "" OR $hlavicka->dpsc == "" OR $hlavicka->dmes == "" OR $hlavicka->xstat == "" ) {
$upozorni1=1;
echo "Nie je vyplnená celá <strong>adresa trvalého pobytu</strong> daòovníka.";
} ?>
</li>
</ul>
<ul id="alertpage2" style="display:none;">
<li class="header-section">STRANA 2</li>
<li class="orange">
<?php if ( $hlavicka->r27 == 0 AND $hlavicka->r28 != 0 )
{
$upozorni2=1;
echo "Vyplnená <strong>úhrnná suma dôchodku</strong> v bode 28, avšak nie je zaškrtnuté <strong>poberanie dôchodku</strong> v bode 27.";
}
?>
</li>
</ul>
<ul id="alertpage4" style="display:none;">
<li class="header-section">STRANA 4</li>
<li class="orange">
<?php if ( $hlavicka->druh != 3 AND ( $hlavicka->r67 != 0 OR $hlavicka->r68 != 0 OR $hlavicka->r69 != 0 OR $hlavicka->r70 != 0 OR $hlavicka->r71 != 0 OR $hlavicka->r72 != 0 OR $hlavicka->r73 != 0 OR $hlavicka->r74 != 0 ) )
{
$upozorni4=1;
echo "Vyplnené riadky <strong>VII.oddielu</strong>, ale <strong>nie je</strong> vybraté dodatoèné daòové priznanie na 1.strane.";
}
?>
</li>
</ul>
<ul id="alertpage5" style="display:none;">
<li class="header-section">STRANA 5</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND $hlavicka->r75 != 0 )
{
$upozorni5=1;
echo "<strong>Neuplatòujem postup</strong> pod¾a § 50 zákona a zároveò poukazujem sumu v <strong>bode 75</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND ( $hlavicka->pico != 0 OR $hlavicka->psid != 0 OR $hlavicka->pfor != "" OR $hlavicka->pmen != "" OR $hlavicka->puli != "" OR $hlavicka->pcdm != "" OR $hlavicka->ppsc != "" OR $hlavicka->pmes != "" ) )
{
$upozorni5=1;
echo "<strong>Neuplatòujem postup</strong> pod¾a § 50 zákona a zároveò sú vyplnené <strong>údaje o prijímate¾ovi</strong> v bode 76.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r75 != 0 AND $hlavicka->upl50 == 0 AND ( $hlavicka->pico == 0 OR $hlavicka->psid == 0 OR $hlavicka->pfor == "" OR $hlavicka->pmen == "" ) )
{
$upozorni5=1;
echo "Nie sú vyplnené <strong>údaje o príjimate¾ovi</strong> v bode 76.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->uoso == 0 AND $hlavicka->osob != "" )
{
$upozorni5=1;
echo "Vyplnené <strong>osobitné záznamy</strong>, ale <strong>nie je vybraté uvádzam</strong> osobitné záznamy.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->pzks1 != "" OR $hlavicka->pzpr1 != 0 OR $hlavicka->pzvd1 != 0 OR $hlavicka->pzks2 != "" OR $hlavicka->pzpr2 != 0 OR $hlavicka->pzvd2 != 0 OR $hlavicka->pzks3 != "" OR $hlavicka->pzpr3 != 0 OR $hlavicka->pzvd3 != 0 ) )
{
$upozorni5=1;
echo "V IX.oddiele vyplnené <strong>údaje o príjmoch nerezidenta</strong>, ale nie je vybratý nerezident <strong>v bode 11 na 1.strane</strong>.";
} ?>
</li>
</ul>
<ul id="alertpage6" style="display:none;">
<li class="header-section">STRANA 6</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->sdnr != "" OR $hlavicka->udnr != 0 ) )
{
$upozorni6=1;
echo "V X.oddiele vyplnené <strong>údaje nerezidenta</strong>, ale nie je vybratý nerezident <strong>v bode 11 na 1.strane</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->dat == '0000-00-00' )
{
$upozorni6=1;
echo "Nie je vyplnený <strong>dátum vyhlásenia</strong> daòového priznania.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 AND $hlavicka->zprp == 0 ) AND ( $hlavicka->post == 1 OR $hlavicka->ucet == 1 OR $hlavicka->diban != "" OR $hlavicka->da2 != '0000-00-00' ) )
{
$upozorni6=1;
echo "V <strong>XI.oddiele nežiadam</strong> o vyplatenie / vrátenie, ale sú vyplnené hodnoty súvisiace s vyplatením / vrátením(napr. spôsob, iban alebo dátum).";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 OR $hlavicka->zprp == 1 ) AND $hlavicka->da2 == '0000-00-00' )
{
$upozorni6=1;
echo "V <strong>XI.oddiele žiadam</strong> o vyplatenie / vrátenie, ale nie je vyplnený <strong>dátum</strong> vyplatenia / vrátenia.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 OR $hlavicka->zprp == 1 ) AND $hlavicka->ucet == 1 AND $hlavicka->diban == "" ) {
$upozorni6=1;
echo "V <strong>XI.oddiele žiadam</strong> o vyplatenie / vrátenie na úèet, ale nie je vyplnený <strong>IBAN</strong> úètu na vyplatenie / vrátenie.";
} ?>
</li>
</ul>
</div> <!-- #upozornenie -->

<script type="text/javascript">
<?php
if ( $upozorni1 == 1 OR $upozorni2 == 1 OR $upozorni4 == 1 OR $upozorni5 == 1 OR $upozorni6 == 1 )
     { echo "upozornenie.style.display='block';"; }
if ( $upozorni1 == 1 ) { echo "alertpage1.style.display='block';"; }
if ( $upozorni2 == 1 ) { echo "alertpage2.style.display='block';"; }
if ( $upozorni4 == 1 ) { echo "alertpage4.style.display='block';"; }
if ( $upozorni5 == 1 ) { echo "alertpage5.style.display='block';"; }
if ( $upozorni6 == 1 ) { echo "alertpage6.style.display='block';"; }
?>
</script>
</div> <!-- #content -->

<?php
//mysql_free_result($vysledok);
     }
//koniec XML SUBOR

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>