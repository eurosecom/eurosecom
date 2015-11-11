<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$cislo_oc = 1*$_REQUEST['cislo_oc'];

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid.$hhmm;

$nazsub="EVIDENCNY_LIST_OSC_".$cislo_oc."_".$idx.".xml";

$copern=10;
$elsubor=2;
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DMV XML</title>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%" >
 <tr>
  <td>EuroSecom - Evidenèný list osè <?php echo $cislo_oc; ?> export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
 </tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2 )
    {
//prva strana
if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");

$sqlt = <<<mzdprc
(

//NOVA SCHEMA od 1.1.2016
<?xml version="1.0" encoding="UTF-8"?>
<spELDPZec xmlns="http://socpoist.sk/xsd/eldpzec" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://socpoist.sk/xsd/eldpzec ELDP-v2015_1.3.xsd ">
  <zamestnavatel>
    <identifikacia>
      <icz>1122334455</icz>
      <identifikator>
        <ico>11223344</ico>
      </identifikator>
      <nazov>SPtest s.r.o</nazov>
    </identifikacia>
    <korAdresa>
      <ulica>Kvetinková</ulica>
      <oCislo>17</oCislo>
      <obec>Prešov</obec>
      <psc>08001</psc>
    </korAdresa>
  </zamestnavatel>
  <zoznamELDPZec>
    <eldpZec opravny="1">
      <poistenec>
        <rc>531015123</rc>
        <priezvisko>Osobitý</priezvisko>
        <meno>František</meno>
        <rodPriezvisko>Osobitý</rodPriezvisko>
        <miestoNarodenia>Brezno</miestoNarodenia>
        <datNarodenia>15.10.1953</datNarodenia>
        <adresa>
        	<ulica>Vesmírna</ulica>
        	<oCislo>308</oCislo>
        	<obec>Martin</obec>
        	<psc>03601</psc>
			<stat>SK</stat>
        </adresa>
      </poistenec>
      <poistVztah>
        <datVzniku>01.05.2008</datVzniku>
        <datZaniku>30.09.2013</datZaniku>
      </poistVztah>
      <obdobiaPoist datDovrseniaDV="15.10.2012">
        <vzZaObdobiePoist rok="2008" znakPoist="A" datOd="01.05.2008" datDo="31.12.2008" vzDP="123250" />
        <vzZaObdobiePoist rok="2009" znakPoist="A" datOd="01.01.2009" datDo="31.12.2009" vzDP="7458.30" />
        <vzZaObdobiePoist rok="2010" znakPoist="A" datOd="01.01.2010" datDo="31.12.2010" vzDP="10500.00" vzVyluc="1200.00" dniVyluc="20"/>
        <vzZaObdobiePoist rok="2011" znakPoist="A" datOd="01.01.2011" datDo="31.12.2011" vzDP="8421.36" />
        <vzZaObdobiePoist rok="2012" znakPoist="A" datOd="01.01.2012" datDo="14.10.2012" vzDP="12480.20"/>
        <vzZaObdobiePoist rok="2012" znakPoist="A" datOd="15.10.2012" datDo="31.12.2012" vzDP="4258.35" dniVyluc="7"/>
        <vzZaObdobiePoist rok="2013" znakPoist="A" datOd="01.01.2013" datDo="30.09.2013" vzDP="7525.48" />
      </obdobiaPoist>
    </eldpZec>
    <eldpZec opravny="0">
      <poistenec>
        <rc>5511118899</rc>
        <priezvisko>Osoba</priezvisko>
        <meno>¼ubomír</meno>
        <rodPriezvisko>Osoba</rodPriezvisko>
        <miestoNarodenia>Prešov</miestoNarodenia>
        <datNarodenia>11.11.1955</datNarodenia>
        <adresa>
        	<ulica>Dlhá</ulica>
        	<oCislo>54</oCislo>
        	<obec>Obec</obec>
        	<psc>01122</psc>
			<stat>SK</stat>
        </adresa>
      </poistenec>
      <poistVztah>
        <datVzniku>15.04.2014</datVzniku>
        <trva>1</trva>
      </poistVztah>
      <obdobiaPoist>
        <vzZaObdobiePoist rok="2014" znakPoist="A" datOd="15.04.2014" datDo="31.12.2014" vzDP="4826.20"/>
        <vzZaObdobiePoist rok="2015" znakPoist="A" datOd="01.01.2015" datDo="27.10.2015" vzDP="6045.25"/>
      </obdobiaPoist>
    </eldpZec>
  </zoznamELDPZec>
  <datOdoslania>04.11.2015</datOdoslania>
  <kontakt>
  	<priezvisko>Test</priezvisko>
  	<meno>Juraj</meno>
  	<email>j.test@mailova.sk</email>
  	<telCislo>+421911223344</telCislo>
  </kontakt>
</spELDPZec>



);
mzdprc;

//hlavicka

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdevidencny".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdevidencny.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdevidencny.oc = $cislo_oc AND konx = 1 ORDER BY konx,prie,meno";

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
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n";
  fwrite($soubor, $text);

  $text = " <hlavicka> "."\r\n";
  fwrite($soubor, $text);

  $fo=0; $po=1;
  if ( $fir_uctt03 == 999 ) { $fo=1; $po=0; }
  $hodnota=$fo;
  $text = "  <fo><![CDATA[".$hodnota."]]></fo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$po;
  $text = "  <po><![CDATA[".$hodnota."]]></po> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$fir_fdic;
  $text = "  <dic><![CDATA[".$hodnota."]]></dic> "."\r\n"; fwrite($soubor, $text);

  $hodnota=SKDatum($hlavicka->dar);
  if ( $fir_uctt03 != 999 ) $hodnota="";
  if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "  <datumNarodenia><![CDATA[".$hodnota."]]></datumNarodenia> "."\r\n"; fwrite($soubor, $text);

  $riadne="1"; $opravne="0"; $dodat="0";
  if ( $hlavicka->druh == 2 ) { $riadne="0"; $opravne="1"; $dodat="0"; }
  if ( $hlavicka->druh == 3 ) { $riadne="0"; $opravne="0"; $dodat="1"; }
  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$riadne;
  $text = "   <rdp><![CDATA[".$hodnota."]]></rdp> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$opravne;
  $text = "   <odp><![CDATA[".$hodnota."]]></odp> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$dodat;
  $text = "   <ddp><![CDATA[".$hodnota."]]></ddp> "."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
  $hodnota=SkDatum($hlavicka->zoo);
  if( $hodnota == '00.00.0000' ) { $hodnota="01.01.".$kli_vrok; }
  $text = "   <od><![CDATA[".$hodnota."]]></od> "."\r\n"; fwrite($soubor, $text);
  $hodnota=SkDatum($hlavicka->zod);
  if( $hodnota == '00.00.0000' ) { $hodnota="31.12.".$kli_vrok; }
  $text = "   <do><![CDATA[".$hodnota."]]></do> "."\r\n"; fwrite($soubor, $text);
  $hodnota="";
  if ( $hlavicka->druh == 3 ) $hodnota=SkDatum($hlavicka->ddp);
  $text = "   <datumDDP><![CDATA[".$hodnota."]]></datumDDP> "."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
$fod = "";
}
  $hodnota=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <foPriezvisko><![CDATA[".$hodnota."]]></foPriezvisko> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <foMeno><![CDATA[".$hodnota."]]></foMeno> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <foTitul><![CDATA[".$hodnota."]]></foTitul> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $fod);
  $text = "  <foObchodneMeno><![CDATA[".$hodnota."]]></foObchodneMeno> "."\r\n"; fwrite($soubor, $text);

  $text = "  <poObchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $fir_fnaz);
  if ( $fir_uctt03 == 999 ) $hodnota="";
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok> "."\r\n"; fwrite($soubor, $text);
  $hodnota="";
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok> "."\r\n"; fwrite($soubor, $text);
  $text = "  </poObchodneMeno>"."\r\n"; fwrite($soubor, $text);

//trvaly pobyt z FOB, sidlo z udajov o firme PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dfax = $fir_riadok->dfax;
$xstat = $fir_riadok->xstat;
if ( $fir_uctt03 != 999 )
{
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dfax = $fir_ffax;
$xstat = "SK";
}
  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$dcdm;
  $text = "   <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$dpsc;
  $text = "   <psc><![CDATA[".$hodnota."]]></psc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $xstat);
  $text = "   <stat><![CDATA[".$hodnota."]]></stat> "."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $dtel);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "   <tel>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "    <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "   </tel>"."\r\n";   fwrite($soubor, $text);

$pole = explode("/", $dfax);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "   <fax>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "    <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "   </fax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

//prechodny adresa pobytu FOB, prevadzkaren PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = trim($fir_riadok->d2uli);
$d2cdm = $fir_riadok->d2cdm;
$d2mes = $fir_riadok->d2mes;
$d2psc = $fir_riadok->d2psc;
$d2tel = $fir_riadok->d2tel;
$d2fax = $fir_riadok->d2fax;
if ( $fir_uctt03 != 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = trim($fir_riadok->pruli);
$d2cdm = $fir_riadok->prcdm;
$d2mes = $fir_riadok->prmes;
$d2psc = $fir_riadok->prpsc;
$d2tel = $fir_ftel;
$d2fax = $fir_ffax;
}
if( $d2uli == '' ) { $d2tel_pred=""; $d2tel_cislo=""; $d2fax_pred=""; $d2fax_cislo=""; }

  $text = "  <prechodnyPobyt>"."\r\n";   fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $d2uli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$d2cdm;
  $text = "   <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$d2psc;
  $text = "   <psc><![CDATA[".$hodnota."]]></psc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $d2mes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec> "."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $d2tel);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "   <tel>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "    <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "   </tel>"."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $d2fax);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "   <fax>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "    <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "   </fax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </prechodnyPobyt>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typZastupcu>"."\r\n"; fwrite($soubor, $text);
  $hodnota="0"; if ( $hlavicka->druh3 == 1 ) $hodnota=1;
  $text = "   <splnomocneny><![CDATA[".$hodnota."]]></splnomocneny> "."\r\n"; fwrite($soubor, $text);
  $hodnota="0"; if ( $hlavicka->druh3 == 2 ) $hodnota=1;
  $text = "   <statutarny><![CDATA[".$hodnota."]]></statutarny> "."\r\n"; fwrite($soubor, $text);
  $hodnota="0"; if ( $hlavicka->druh3 == 3 ) $hodnota=1;
  $text = "   <spravca><![CDATA[".$hodnota."]]></spravca> "."\r\n"; fwrite($soubor, $text);
  $hodnota="0"; if ( $hlavicka->druh3 == 4 ) $hodnota=1;
  $text = "   <pravnyNastupca><![CDATA[".$hodnota."]]></pravnyNastupca> "."\r\n"; fwrite($soubor, $text);
  $hodnota="0"; if ( $hlavicka->druh3 == 5 ) $hodnota=1;
  $text = "   <naDorucovanie><![CDATA[".$hodnota."]]></naDorucovanie> "."\r\n"; fwrite($soubor, $text);
  $text = "  </typZastupcu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "   <priezvisko><![CDATA[".$hodnota."]]></priezvisko> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3meno);
  $text = "   <meno><![CDATA[".$hodnota."]]></meno> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3titl);
  $text = "   <titul><![CDATA[".$hodnota."]]></titul> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->rdc3.$hlavicka->rdk3;
  $text = "   <rc><![CDATA[".$hodnota."]]></rc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=SkDatum($hlavicka->dar3);
  $text = "   <datumNarodenia><![CDATA[".$hodnota."]]></datumNarodenia> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->dic3;
  $text = "   <dic><![CDATA[".$hodnota."]]></dic> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->naz3);
  $text = "   <obchodneMeno><![CDATA[".$hodnota."]]></obchodneMeno> "."\r\n"; fwrite($soubor, $text);

  $text = "   <adresa>"."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3uli);
  $text = "    <ulica><![CDATA[".$hodnota."]]></ulica> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->d3cdm;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->d3psc;
  $text = "    <psc><![CDATA[".$hodnota."]]></psc> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3mes);
  $text = "    <obec><![CDATA[".$hodnota."]]></obec> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->xstat3);
  $text = "    <stat><![CDATA[".$hodnota."]]></stat> "."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $hlavicka->d3tel);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "    <tel>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "     <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "     <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "    </tel>"."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $hlavicka->d3fax);
$tel_pred=$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
  $text = "    <fax>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_pred;
  $text = "     <predcislie><![CDATA[".$hodnota."]]></predcislie> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$tel_za;
  $text = "     <cislo><![CDATA[".$hodnota."]]></cislo> "."\r\n"; fwrite($soubor, $text);
  $text = "    </fax>"."\r\n"; fwrite($soubor, $text);
  $text = "   </adresa>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>	"."\r\n"; fwrite($soubor, $text);

  $text = " <telo> "."\r\n"; fwrite($soubor, $text);

  $hodnota=$hlavicka->r35;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r35><![CDATA[".$hodnota."]]></r35> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r36;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r36><![CDATA[".$hodnota."]]></r36> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r37;
  $text = "  <r37><![CDATA[".$hodnota."]]></r37> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r38;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r38><![CDATA[".$hodnota."]]></r38> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r39;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r39><![CDATA[".$hodnota."]]></r39> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r40;
  $text = "  <r40><![CDATA[".$hodnota."]]></r40> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r41;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r41><![CDATA[".$hodnota."]]></r41> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r42;
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r42><![CDATA[".$hodnota."]]></r42> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r43;
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r43><![CDATA[".$hodnota."]]></r43> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r44;
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r44><![CDATA[".$hodnota."]]></r44> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->r45;
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r45><![CDATA[".$hodnota."]]></r45> "."\r\n"; fwrite($soubor, $text);

  $text = "  <vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->zvra;
  $text = "   <vratit><![CDATA[".$hodnota."]]></vratit> "."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->post;
  if ( $hlavicka->zvra == 0 ) $hodnota="0";
  $text = "    <poukazka><![CDATA[".$hodnota."]]></poukazka> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavicka->ucet;
  if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <ucet><![CDATA[".$hodnota."]]></ucet> "."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$fir_fuc1;
  if ( $hlavicka->ucet == 0 ) $hodnota="";
  if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <cisloUctu><![CDATA[".$hodnota."]]></cisloUctu> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$fir_fnm1;
  if ( $hlavicka->ucet == 0 ) $hodnota="";
  if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <kodBanky><![CDATA[".$hodnota."]]></kodBanky> "."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$pole = explode(".", SkDatum($hlavicka->dvp));
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
if ( $den == '00' ) $den="";
if ( $mesiac == '00' ) $mesiac="";
if ( $rok == '0000' ) $rok="";
if ( $hlavicka->zvra == 0 ) { $den=""; $mesiac=""; $rok=""; }
  $text = "   <datum>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$den;
  $text = "    <den><![CDATA[".$hodnota."]]></den> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$mesiac;
  $text = "    <mesiac><![CDATA[".$hodnota."]]></mesiac> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$rok;
  $text = "    <rok><![CDATA[".$hodnota."]]></rok> "."\r\n"; fwrite($soubor, $text);
  $text = "   </datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);

  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->pozn);
  $text = "  <poznamky><![CDATA[".$hodnota."]]></poznamky> "."\r\n"; fwrite($soubor, $text);
  $hodnota=iconv("CP1250", "UTF-8", $hlavicka->pomv);
  $text = "  <pomocneVypocty><![CDATA[".$hodnota."]]></pomocneVypocty> "."\r\n"; fwrite($soubor, $text);

$pole = explode(".", SkDatum($hlavicka->dvh));
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
if ( $den == 00 ) $den="";
if ( $mesiac == 00 ) $mesiac="";
if ( $rok == 0000 ) $rok="";
  $text = "  <datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$den;
  $text = "   <den><![CDATA[".$hodnota."]]></den> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$mesiac;
  $text = "   <mesiac><![CDATA[".$hodnota."]]></mesiac> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$rok;
  $text = "   <rok><![CDATA[".$hodnota."]]></rok> "."\r\n"; fwrite($soubor, $text);
  $text = "  </datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);
}
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }

//3.strana
$sqlttv = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE F$kli_vxcf"."_uctpriznanie_dmv.oc = 1 ORDER BY vzspz";
$sqlv = mysql_query("$sqlttv");
$polv = mysql_num_rows($sqlv);
$strxx=$polv/2;
$polv=ceil($strxx);
$pocetstran3=$polv;
$polv=$polv*2;

$strana3=0;
$iv=0;
$jv=0; 
  while ( $iv < $polv )
  {
@$zaznam=mysql_data_seek($sqlv,$iv);
$hlavickav=mysql_fetch_object($sqlv);

if ( $jv == 0 ) {

$strana3=$strana3+1;
  $text = "  <strana3>"."\r\n"; fwrite($soubor, $text);
  $text = "   <oznacenie>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$strana3;
  $text = "    <aktualna><![CDATA[".$hodnota."]]></aktualna> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$pocetstran3;
  $text = "    <celkovo><![CDATA[".$hodnota."]]></celkovo> "."\r\n"; fwrite($soubor, $text);
  $text = "   </oznacenie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <stlpec1>"."\r\n"; fwrite($soubor, $text);
                }

if ( $jv == 1 ) {
  $text = "   <stlpec2>"."\r\n"; fwrite($soubor, $text);
                }
  $hodnota=SKDatum($hlavickav->da1);
  if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "    <r01><![CDATA[".$hodnota."]]></r01> "."\r\n"; fwrite($soubor, $text);
  $hodnota=SKDatum($hlavickav->datz);
  if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "    <r02><![CDATA[".$hodnota."]]></r02> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->vzkat;
//if ( $vzkat == '' ) { $vzkat="M"; }
  $text = "    <r03><![CDATA[".$hodnota."]]></r03> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->vzdru;
  if ( $hlavickav->vzkat =='' ) $hodnota="";
  $text = "    <r04><![CDATA[".$hodnota."]]></r04> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->vzspz;
  $text = "    <r05><![CDATA[".$hodnota."]]></r05> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->vzobm;
  if ( $hlavickav->vzkat != 'M' ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r06><![CDATA[".$hodnota."]]></r06> "."\r\n"; fwrite($soubor, $text);
//  if( $vzkat == 'M' ) { $vzchm=""; $vznpr=""; }
  $hodnota=$hlavickav->vzchm;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r07><![CDATA[".$hodnota."]]></r07> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->vznpr;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r08><![CDATA[".$hodnota."]]></r08> "."\r\n"; fwrite($soubor, $text);
  $vzdno = $hlavickav->vzdno;
  $vzdnp = $hlavickav->vzdnp;
//  if( $vzdno == '' ) { $vzdno="1"; }
//  if( $vzdnp == '' ) { $vzdnp="A"; }
  $text = "    <r09>"."\r\n"; fwrite($soubor, $text);
  $text = "     <ods><![CDATA[".$vzdno."]]></ods> "."\r\n"; fwrite($soubor, $text);
  $text = "     <pism><![CDATA[".$vzdnp."]]></pism> "."\r\n"; fwrite($soubor, $text);
  $text = "    </r09>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r10;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r10><![CDATA[".$hodnota."]]></r10> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r11;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r11><![CDATA[".$hodnota."]]></r11> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r12;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r12><![CDATA[".$hodnota."]]></r12> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r13;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r13><![CDATA[".$hodnota."]]></r13> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r14;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r14><![CDATA[".$hodnota."]]></r14> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r15;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r15><![CDATA[".$hodnota."]]></r15> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r16;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r16><![CDATA[".$hodnota."]]></r16> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r17;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r17><![CDATA[".$hodnota."]]></r17> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r18;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r18><![CDATA[".$hodnota."]]></r18> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r19;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r19><![CDATA[".$hodnota."]]></r19> "."\r\n"; fwrite($soubor, $text);
  $hodnota=$hlavickav->r20;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r20><![CDATA[".$hodnota."]]></r20> "."\r\n"; fwrite($soubor, $text);
  $hodnota = $hlavickav->r21;
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r21><![CDATA[".$hodnota."]]></r21> "."\r\n"; fwrite($soubor, $text);

  $hodnota="$hlavickav->r22";
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r22><![CDATA[".$hodnota."]]></r22> "."\r\n"; fwrite($soubor, $text);
  $hodnota="$hlavickav->r23";
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r23><![CDATA[".$hodnota."]]></r23> "."\r\n"; fwrite($soubor, $text);
  $hodnota="$hlavickav->r24";
  if ( $hlavicka->druh != 3 ) $hodnota="";
  if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r24><![CDATA[".$hodnota."]]></r24> "."\r\n"; fwrite($soubor, $text);

if ( $jv == 0 ) {
  $text = "   </stlpec1>"."\r\n"; fwrite($soubor, $text);
                }

if ( $jv == 1 ) {
  $text = "   </stlpec2>"."\r\n"; fwrite($soubor, $text);
  $text = "  </strana3>"."\r\n"; fwrite($soubor, $text);
               }
$iv = $iv + 1;
$jv = $jv + 1;
if ( $jv == 2 ) { $jv=0; }
  }

  $text = " </telo> "."\r\n";
  fwrite($soubor, $text);
  $text = "</dokument> "."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>



<?php if ( $elsubor == 2 ) { ?>

<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />

<?php                      } ?>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<?php
//mysql_free_result($vysledok);
    }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
