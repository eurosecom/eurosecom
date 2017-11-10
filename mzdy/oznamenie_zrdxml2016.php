<HTML>
<?php
//XML pre OZNAMENIE ZRD 2016
do
{
$sys = 'MZD';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
//echo $copern;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

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
$citnas = include("../cis/citaj_nas.php");

$cislo_xplat = 1*$_REQUEST['cislo_xplat'];

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$zaobdobie=1*$_REQUEST['h_stv'];

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Oznámenie bude pripravené v priebehu mája 2015. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/oznzrdx_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/oznzrdx_".$kli_uzid."_".$hhmmss.".xml";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazsub=$outfilex;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>EuroSecom - OZNAMENIE xml</title>
<style type="text/css">

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
 <table class="h2" width="100%" >
 <tr>
  <td>EuroSecom - Oznámenie o dani z nepeòažného plnenia ... - export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
 </tr>
 </table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU elsubor=1,2
if ( $copern == 110 )
     {
//prva strana
$soubor = fopen("$nazsub", "a+");

//verzia 2016
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="ozn4317A_2016.xsd">
	<hlavicka>
		<dic></dic>
		<zaObdobie>
			<rok>2016</rok>
		</zaObdobie>
		<doplnenie>0</doplnenie>
		<fyzickaOsoba>
			<priezvisko></priezvisko>
			<meno></meno>
			<titulPred></titulPred>
			<titulZa></titulZa>
			<datumNarodenia></datumNarodenia>
		</fyzickaOsoba>
		<pravnickaOsoba>
			<obchodneMeno>
			<riadok></riadok>
			<riadok></riadok>
			</obchodneMeno>
		</pravnickaOsoba>
		<sidlo>
			<ulica></ulica>
			<supisneOrientacneCislo></supisneOrientacneCislo>
			<psc></psc>
			<obec></obec>
			<stat></stat>
		</sidlo>
		<sidloNaUzemiSr>
			<ulica></ulica>
			<supisneOrientacneCislo></supisneOrientacneCislo>
			<psc></psc>
			<obec></obec>
		</sidloNaUzemiSr>
		<adresaZariadenia>
			<ulica></ulica>
			<supisneOrientacneCislo></supisneOrientacneCislo>
			<psc></psc>
			<obec></obec>
		</adresaZariadenia>
		<suhrnneUdaje>
			<vyskaSr></vyskaSr>
			<vyskaZahr></vyskaZahr>
			<vyskaZahrSr></vyskaZahrSr>
			<vyskaSpolu></vyskaSpolu>
			<dan></dan>
			<datum></datum>
		</suhrnneUdaje>
		<zamedzenieDvojZdaneniu>
			<uhrn1></uhrn1>
			<plneniaPoVynati></plneniaPoVynati>
			<sadzba>19</sadzba>
			<dan></dan>
			<uhrn2></uhrn2>
			<uhrn3></uhrn3>
			<percento></percento>
			<danMaximalna></danMaximalna>
			<danZapocet></danZapocet>
			<danPoVynati></danPoVynati>
			<danZrazena></danZrazena>
			<danNaOdvedenie></danNaOdvedenie>
			<danNaVratenie></danNaVratenie>
		</zamedzenieDvojZdaneniu>
		<vypracoval>
			<vypracoval></vypracoval>
			<dna>03.11.2017</dna>
			<telefon></telefon>
			<podpis>1</podpis>
		</vypracoval>
		<pocetStrPrilohy>1</pocetStrPrilohy>
		<ziadost>
			<vratit>0</vratit>
			<sposobPlatby>
				<poukazka>0</poukazka>
				<ucet>0</ucet>
			</sposobPlatby>
			<iban></iban>
			<datum></datum>
			<podpis>1</podpis>
		</ziadost>
	</hlavicka>
	<telo>
		<priloha>
			<strana>
				<aktualna>1</aktualna>
				<celkovo>3</celkovo>
			</strana>
			<drzitel>
				<dic></dic>
				<vyska></vyska>
				<fyzickaOsoba>
					<priezvisko></priezvisko>
					<meno></meno>
					<titulPred></titulPred>
					<titulZa></titulZa>
				</fyzickaOsoba>
				<pravnickaOsoba>
					<obchodneMeno></obchodneMeno>
				</pravnickaOsoba>
				<sidlo>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
					<stat></stat>
				</sidlo>
				<sidloPrevadzky>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
				</sidloPrevadzky>
			</drzitel>
			<drzitel>
				<dic></dic>
				<vyska></vyska>
				<fyzickaOsoba>
					<priezvisko></priezvisko>
					<meno></meno>
					<titulPred></titulPred>
					<titulZa></titulZa>
				</fyzickaOsoba>
				<pravnickaOsoba>
					<obchodneMeno></obchodneMeno>
				</pravnickaOsoba>
				<sidlo>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
					<stat></stat>
				</sidlo>
				<sidloPrevadzky>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
				</sidloPrevadzky>
			</drzitel>
		</priloha>
		<priloha>
			<strana>
				<aktualna>2</aktualna>
				<celkovo>3</celkovo>
			</strana>
			<drzitel>
				<dic></dic>
				<vyska></vyska>
				<fyzickaOsoba>
					<priezvisko></priezvisko>
					<meno></meno>
					<titulPred></titulPred>
					<titulZa></titulZa>
				</fyzickaOsoba>
				<pravnickaOsoba>
					<obchodneMeno></obchodneMeno>
				</pravnickaOsoba>
				<sidlo>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
					<stat></stat>
				</sidlo>
				<sidloPrevadzky>
					<ulica></ulica>
					<supisneOrientacneCislo></supisneOrientacneCislo>
					<psc></psc>
					<obec></obec>
				</sidloPrevadzky>
			</drzitel>
		</priloha>
	</telo>
</dokument>
);
mzdprc;

//udaje o platitelovi - zamestnancovi
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_xplat ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$rdc = $fir_riadok->rdc;
$rdk = $fir_riadok->rdk;
$nar_sk = SkDatum($fir_riadok->dar);
$zuli = $fir_riadok->zuli;
$zmes = $fir_riadok->zmes;
$zpsc = $fir_riadok->zpsc;
$zcdm = $fir_riadok->zcdm;
$titulp = $fir_riadok->titl;

mysql_free_result($fir_vysledok);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $cislo_xplat ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$titulz = $fir_riadok->ztitz;
$fir_fdicx = $fir_riadok->zdic;

mysql_free_result($fir_vysledok);

//udaje zdrav.zariadenie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$mdic = $fir_riadok->mdic;
$zzul = $fir_riadok->zzul;
$zzcs = $fir_riadok->zzcs;
$zzps = $fir_riadok->zzps;
$zzms = $fir_riadok->zzms;
$datum_sk = SkDatum($fir_riadok->datum);
$datd_sk = SkDatum($fir_riadok->datd);
$fir_fdicx=$mdic;

mysql_free_result($fir_vysledok);

//ak platitel pravnicka osoba
if ( $cislo_xplat > 9999 )
   {
$fir_fdicx=$fir_fdic;
$mdic=$fir_fdic;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$meno = $fir_riadok->dmeno;
$prie = $fir_riadok->dprie;
$titulp = $fir_riadok->dtitl;
$titulz = $fir_riadok->dtitz;
$zuli = $fir_riadok->duli;
$zcdm = $fir_riadok->dcdm;
$zmes = $fir_riadok->dmes;
$zpsc = $fir_riadok->dpsc;
$fir_fnazovx = $fir_fnaz;

if ( $fir_uctt03 != 999 ) {
$meno=""; $prie=""; $titulp=""; $titulz="";
$fir_fnazx = $fir_fnaz;
$nar_sk="";
$zuli = $fir_fuli;
$zcdm = $fir_fcdm;
$zmes = $fir_fmes;
$zpsc = $fir_fpsc;
                          }

if ( $nar_sk == '00.00.0000' ) { $nar_sk=""; }
   }


if ( $strana == 3 )
   {
//udaje priloha
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE cpl = $cislo_cpl ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$xmfo = $fir_riadok->xmfo;
$xpfo = $fir_riadok->xpfo;
$xnpo = $fir_riadok->xnpo;
$xdic = $fir_riadok->xdic;
$prj = $fir_riadok->prj;
$xuli = $fir_riadok->xuli;
$xcis = $fir_riadok->xcis;
$xpsc = $fir_riadok->xpsc;
$xmes = $fir_riadok->xmes;
$xtitulp = $fir_riadok->xtitulp;
$xtitulz = $fir_riadok->xtitulz;
mysql_free_result($fir_vysledok);
   }

$prilohy=0; $pocetdic=0; $pocetdic2=0; $pocetdic3=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie";
$sqldok = mysql_query("$sqlfir");
if ( $sqldok ) { $pocetdic = mysql_num_rows($sqldok); }
$pocetdic2=$pocetdic-2;
$pocetdic3=$pocetdic2/3;
$prilohy=ceil($pocetdic3);
if ( $prilohy < 0 ) { $prilohy=0; }
if ( $prilohy == -0 ) { $prilohy=0; }


//prva strana
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
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
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);

  $text = "<hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = " <dic><![CDATA[".$mdic."]]></dic>"."\r\n"; fwrite($soubor, $text);
  $text = " <zaObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  <rok><![CDATA[".$kli_vrok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = " </zaObdobie>"."\r\n"; fwrite($soubor, $text);

$doplnenie=1*$hlavicka->opravne;
  $text = "  <doplnenie><![CDATA[".$doplnenie."]]></doplnenie>"."\r\n"; fwrite($soubor, $text);

  $text = " <fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);
$prie = iconv("CP1250", "UTF-8", $prie);
  $text = "  <priezvisko><![CDATA[".$prie."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno = iconv("CP1250", "UTF-8", $meno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
  $text = "  <titulPred><![CDATA[".$titulp."]]></titulPred>"."\r\n"; fwrite($soubor, $text);
  $text = "  <titulZa><![CDATA[".$titulz."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
  $text = "  <datumNarodenia><![CDATA[".$nar_sk."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);
  $text = " </fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);
  $text = "  <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$fir_fnazx = iconv("CP1250", "UTF-8", $fir_fnazx);
$fir_fnazx1 = iconv("CP1250", "UTF-8", $fir_fnazx1);
  $text = "   <riadok><![CDATA[".$fir_fnazx.$fir_fnazx1."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = " </pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <sidlo>"."\r\n"; fwrite($soubor, $text);
$zuli = iconv("CP1250", "UTF-8", $zuli);
  $text = "  <ulica><![CDATA[".$zuli."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "  <supisneOrientacneCislo><![CDATA[".$zcdm."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <psc><![CDATA[".$zpsc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$zmes = iconv("CP1250", "UTF-8", $zmes);
  $text = "  <obec><![CDATA[".$zmes."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = " </sidlo>"."\r\n"; fwrite($soubor, $text);

  $text = " <sidloNaUzemiSr>"."\r\n"; fwrite($soubor, $text);
$sruli = iconv("CP1250", "UTF-8", $hlavicka->sruli);
  $text = "  <ulica><![CDATA[".$sruli."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "  <supisneOrientacneCislo><![CDATA[".$hlavicka->srcdm."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <psc><![CDATA[".$hlavicka->srpsc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$srmes = iconv("CP1250", "UTF-8", $hlavicka->srmes);
  $text = "  <obec><![CDATA[".$srmes."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = " </sidloNaUzemiSr>"."\r\n"; fwrite($soubor, $text);

  $text = " <adresaZariadenia>"."\r\n"; fwrite($soubor, $text);
$zzul = iconv("CP1250", "UTF-8", $zzul);
  $text = "  <ulica><![CDATA[".$zzul."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "  <supisneOrientacneCislo><![CDATA[".$zzcs."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <psc><![CDATA[".$zzps."]]></psc>"."\r\n"; fwrite($soubor, $text);
$zzms = iconv("CP1250", "UTF-8", $zzms);
  $text = "  <obec><![CDATA[".$zzms."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = " </adresaZariadenia>"."\r\n"; fwrite($soubor, $text);

  $text = " <suhrnneUdaje>"."\r\n"; fwrite($soubor, $text);
  $text = "  <vyskaSr><![CDATA[".$hlavicka->r20."]]></vyskaSr>"."\r\n"; fwrite($soubor, $text);
  $text = "  <vyskaZahr><![CDATA[".$hlavicka->r21."]]></vyskaZahr>"."\r\n"; fwrite($soubor, $text);
  $text = "  <vyskaZahrSr><![CDATA[".$hlavicka->r21a."]]></vyskaZahrSr>"."\r\n"; fwrite($soubor, $text);
  $text = "  <vyskaSpolu><![CDATA[".$hlavicka->r22."]]></vyskaSpolu>"."\r\n"; fwrite($soubor, $text);
  $text = "  <dan><![CDATA[".$hlavicka->r23."]]></dan>"."\r\n"; fwrite($soubor, $text);
$text=SkDatum($hlavicka->datum);
  $text = "  <datum><![CDATA[".$text."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = " </suhrnneUdaje>"."\r\n"; fwrite($soubor, $text);

  $text = " <zamedzenieDvojZdaneniu>"."\r\n"; fwrite($soubor, $text);
  $text = " <uhrn1><![CDATA[".$hlavicka->r40."]]></uhrn1>"."\r\n"; fwrite($soubor, $text);
  $text = " <plneniaPoVynati><![CDATA[".$hlavicka->r41."]]></plneniaPoVynati>"."\r\n"; fwrite($soubor, $text);
  $text = " <sadzba><![CDATA[".$hlavicka->r42."]]></sadzba>"."\r\n"; fwrite($soubor, $text);
  $text = " <dan><![CDATA[".$hlavicka->r43."]]></dan>"."\r\n"; fwrite($soubor, $text);
  $text = " <uhrn2><![CDATA[".$hlavicka->r44."]]></uhrn2>"."\r\n"; fwrite($soubor, $text);
  $text = " <uhrn3><![CDATA[".$hlavicka->r45."]]></uhrn3>"."\r\n"; fwrite($soubor, $text);
  $text = " <percento><![CDATA[".$hlavicka->r46."]]></percento>"."\r\n"; fwrite($soubor, $text);
  $text = " <danMaximalna><![CDATA[".$hlavicka->r47."]]></danMaximalna>"."\r\n"; fwrite($soubor, $text);
  $text = " <danZapocet><![CDATA[".$hlavicka->r48."]]></danZapocet>"."\r\n"; fwrite($soubor, $text);
  $text = " <danPoVynati><![CDATA[".$hlavicka->r49."]]></danPoVynati>"."\r\n"; fwrite($soubor, $text);
  $text = " <danZrazena><![CDATA[".$hlavicka->r50."]]></danZrazena>"."\r\n"; fwrite($soubor, $text);
  $text = " <danNaOdvedenie><![CDATA[".$hlavicka->r51."]]></danNaOdvedenie>"."\r\n"; fwrite($soubor, $text);
  $text = " <danNaVratenie><![CDATA[".$hlavicka->r52."]]></danNaVratenie>"."\r\n"; fwrite($soubor, $text);
  $text = " </zamedzenieDvojZdaneniu>"."\r\n"; fwrite($soubor, $text);


  $text = " <vypracoval>"."\r\n"; fwrite($soubor, $text);
$fir_mzdt05 = iconv("CP1250", "UTF-8", $fir_mzdt05);
  $text = "  <vypracoval><![CDATA[".$fir_mzdt05."]]></vypracoval>"."\r\n"; fwrite($soubor, $text);

$text=SkDatum($hlavicka->datd);
  $text = "  <dna><![CDATA[".$text."]]></dna>"."\r\n"; fwrite($soubor, $text);

$telefon=str_replace("/","",$fir_mzdt04);
  $text = "  <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n"; fwrite($soubor, $text);

$podpis="1";
  $text = "  <podpis><![CDATA[".$podpis."]]></podpis>"."\r\n"; fwrite($soubor, $text);
  $text = " </vypracoval>"."\r\n"; fwrite($soubor, $text);
$textx=$prilohy;
if ( $textx == 0 ) $textx="";
  $text = " <pocetStrPrilohy><![CDATA[".$textx."]]></pocetStrPrilohy>"."\r\n"; fwrite($soubor, $text);

  $text = " <ziadost>"."\r\n"; fwrite($soubor, $text);

$vrat=1*$hlavicka->vrat;
  $text = " <vratit><![CDATA[".$vrat."]]></vratit>"."\r\n"; fwrite($soubor, $text);
  $text = " <sposobPlatby>"."\r\n"; fwrite($soubor, $text);

$post=1*$hlavicka->post;
  $text = " <poukazka><![CDATA[".$post."]]></poukazka>"."\r\n"; fwrite($soubor, $text);

$ucet=1*$hlavicka->ucet;
  $text = " <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = " </sposobPlatby>"."\r\n"; fwrite($soubor, $text);
  $text = " <iban><![CDATA[".$fir_fib1."]]></iban>"."\r\n"; fwrite($soubor, $text);

$datd=SkDatum($hlavicka->datd);
  $text = " <datum><![CDATA[".$datd."]]></datum>"."\r\n"; fwrite($soubor, $text);

$podpis="1";
  $text = " <podpis><![CDATA[".$podpis."]]></podpis>"."\r\n"; fwrite($soubor, $text);
  $text = " </ziadost>"."\r\n"; fwrite($soubor, $text);

  $text = "</hlavicka>"."\r\n"; fwrite($soubor, $text);
//po tadeto ok

     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "<telo>"."\r\n"; fwrite($soubor, $text);

//vytlac drzitelov
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0;
$aktualna=1;
$celkovo=ceil($pol/2);

  while ($i < $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $stlpec < 3 )
{
$hlavicka=mysql_fetch_object($sql);

if ( $j == 0 ) {
  $text = "<priloha>"."\r\n"; fwrite($soubor, $text);
  $text = " <strana>"."\r\n"; fwrite($soubor, $text);
  $text = "  <aktualna><![CDATA[".$aktualna."]]></aktualna>"."\r\n"; fwrite($soubor, $text);
  $text = "  <celkovo><![CDATA[".$celkovo."]]></celkovo>"."\r\n"; fwrite($soubor, $text);
  $text = " </strana>"."\r\n"; fwrite($soubor, $text);

               }

  $text = " <drzitel>"."\r\n"; fwrite($soubor, $text);
$xdic = iconv("CP1250", "UTF-8", $hlavicka->xdic);
  $text = "  <dic><![CDATA[".$xdic."]]></dic>"."\r\n"; fwrite($soubor, $text);
  $text = "  <vyska><![CDATA[".$hlavicka->prj."]]></vyska>"."\r\n"; fwrite($soubor, $text);
  $text = "  <fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);
$xpfo = iconv("CP1250", "UTF-8", $hlavicka->xpfo);
  $text = "   <priezvisko><![CDATA[".$xpfo."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$xmfo = iconv("CP1250", "UTF-8", $hlavicka->xmfo);
  $text = "   <meno><![CDATA[".$xmfo."]]></meno>"."\r\n"; fwrite($soubor, $text);
  $text = "   <titulPred><![CDATA[".$hlavicka->xtitulp."]]></titulPred>"."\r\n"; fwrite($soubor, $text);
  $text = "   <titulZa><![CDATA[".$hlavicka->xtitulz."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
  $text = "  </fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = "  <pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);
$xnpo = iconv("CP1250", "UTF-8", $hlavicka->xnpo);
  $text = "   <obchodneMeno><![CDATA[".$xnpo."]]></obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = "  </pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
$xuli = iconv("CP1250", "UTF-8", $hlavicka->xuli);
  $text = "   <ulica><![CDATA[".$xuli."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "   <supisneOrientacneCislo><![CDATA[".$hlavicka->xcis."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <psc><![CDATA[".$hlavicka->xpsc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$xmes = iconv("CP1250", "UTF-8", $hlavicka->xmes);
  $text = "   <obec><![CDATA[".$xmes."]]></obec>"."\r\n"; fwrite($soubor, $text);
$xstat = iconv("CP1250", "UTF-8", $hlavicka->xstat);
  $text = "   <stat><![CDATA[".$xstat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

  $text = "  <sidloPrevadzky>"."\r\n"; fwrite($soubor, $text);
$xspuli = iconv("CP1250", "UTF-8", $hlavicka->xspuli);
  $text = "   <ulica><![CDATA[".$xspuli."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "   <supisneOrientacneCislo><![CDATA[".$hlavicka->xspcdm."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <psc><![CDATA[".$hlavicka->xsppsc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$xspmes = iconv("CP1250", "UTF-8", $hlavicka->xspmes);
  $text = "   <obec><![CDATA[".$xspmes."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidloPrevadzky>"."\r\n"; fwrite($soubor, $text);

  $text = " </drzitel>"."\r\n"; fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
$koniecpriloha=0;
if( $j == 2 ) { $j=0; $aktualna=$aktualna+1; $text = "</priloha>"."\r\n"; fwrite($soubor, $text); $koniecpriloha=1; }
  }
//koniec drzitelov

if( $koniecpriloha == 0 ) { $text = "</priloha>"."\r\n"; fwrite($soubor, $text); }

  $text = "</telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
fclose($soubor);
?>

<?php if ( $copern == 110 ) { ?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane:
<br />
<br />
<a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>
<br />
<br />
<?php                       } ?>

<?php
//mysql_free_result($vysledok);
    }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU


//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>