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

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEDMV_rok_".$kli_vrok."_".$idx.".xml";

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
  <td>EuroSecom - Priznanie DMV <?php echo $kli_vrok; ?> export do XML</td>
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

//NOVA SCHEMA DMV 2015 ulozena do suboru z financneho portalu

<?xml version="1.0" encoding="utf-8"?>
<dokument>
<hlavicka>
<fo>0</fo>
<po>1</po>
<zahranicna>0</zahranicna>
<dic>2022858728</dic>
<datumNarodenia></datumNarodenia>
<typDP>
<rdp>1</rdp>
<odp>0</odp>
<ddp>0</ddp>
</typDP>
<zdanovacieObdobie>
<od></od>
<do></do>
<datumDDP></datumDDP>
</zdanovacieObdobie>
<foPriezvisko></foPriezvisko>
<foMeno></foMeno>
<foTitul></foTitul>
<foTitulZa></foTitulZa>
<foObchodneMeno></foObchodneMeno>
<poObchodneMeno>
<riadok>BUSINESS RELATIONS s. r. o.</riadok>
<riadok></riadok>
</poObchodneMeno>
<sidlo>
<ulica>Stefanikova</ulica>
<cislo>715</cislo>
<psc>90501</psc>
<obec>Senica</obec>
<stat>SK</stat>
<telefon></telefon>
<emailFax></emailFax>
</sidlo>
<adresaOrganizacnejZlozky>
<ulica></ulica>
<cislo></cislo>
<psc></psc>
<obec></obec>
<telefon></telefon>
<emailFax></emailFax>
</adresaOrganizacnejZlozky>
<typZastupcu>
<typZastupca>0</typZastupca>
<dedic>0</dedic>
<spravcaVkonkurznomKonani>0</spravcaVkonkurznomKonani>
<likvidator>0</likvidator>
<statutarnyZastupcaPO>0</statutarnyZastupcaPO>
<pravnyNastupca>0</pravnyNastupca>
</typZastupcu>
<zastupca>
<priezvisko></priezvisko>
<meno></meno>
<titul></titul>
<titulZa></titulZa>
<rc></rc>
<datumNarodenia></datumNarodenia>
<dic></dic>
<obchodneMeno></obchodneMeno>
<adresa>
<ulica></ulica>
<cislo></cislo>
<psc></psc>
<obec></obec>
<stat></stat>
<telefon></telefon>
<emailFax></emailFax>
</adresa>
</zastupca>
</hlavicka>
<telo>
<r35>1</r35>
<r36></r36>
<r37></r37>
<r38></r38>
<r39></r39>
<r40></r40>
<r41>1</r41>
<r42></r42>
<r43></r43>
<r44></r44>
<r45></r45>
<vrateniePreplatku>
<vratit>0</vratit>
<sposobPlatby>
<poukazka>0</poukazka>
<ucet>0</ucet>
</sposobPlatby>
<bankovyUcet>
<cisloUctu></cisloUctu>
<kodBanky></kodBanky>
<IBAN></IBAN>
</bankovyUcet>
<datum></datum>
</vrateniePreplatku>
<poznamky><![CDATA[]]></poznamky>
<datumVyhlasenia>04.11.2015</datumVyhlasenia>
<strana3>
<oznacenie>
<aktualna>1</aktualna>
<celkovo>1</celkovo>
</oznacenie>
<stlpec1>
<r01>01.11.2014</r01>
<r02vzniku>01.11.2014</r02vzniku>
<r02zaniku></r02zaniku>
<r03>M</r03>
<r04>M1</r04>
<r05></r05>
<r06></r06>
<r07></r07>
<r08></r08>
<r09></r09>
<r10pism></r10pism>
<r11pism></r11pism>
<r12></r12>
<r12nizsiaSadzba>0</r12nizsiaSadzba>
<r13znizenbieSadzba1_25>0</r13znizenbieSadzba1_25>
<r13znizenbieSadzba1_20>0</r13znizenbieSadzba1_20>
<r13znizenbieSadzba1_15>0</r13znizenbieSadzba1_15>
<r13znizenbieSadzba2_25>0</r13znizenbieSadzba2_25>
<r13znizenbieSadzba2_20>0</r13znizenbieSadzba2_20>
<r13znizenbieSadzba2_15>0</r13znizenbieSadzba2_15>
<r13zvysenieSadzba1_10>0</r13zvysenieSadzba1_10>
<r13zvysenieSadzba1_20>0</r13zvysenieSadzba1_20>
<r13zvysenieSadzba2_10>0</r13zvysenieSadzba2_10>
<r13zvysenieSadzba2_20>0</r13zvysenieSadzba2_20>
<r14s1></r14s1>
<r14s2></r14s2>
<r15hybrid>0</r15hybrid>
<r15plyn>0</r15plyn>
<r15vodik>0</r15vodik>
<r16s1></r16s1>
<r16s2></r16s2>
<r17>0</r17>
<r18s1></r18s1>
<r18s2></r18s2>
<r19aPocMesS1></r19aPocMesS1>
<r19aPocMesS2></r19aPocMesS2>
<r19bPocDniS1></r19bPocDniS1>
<r19bPocDniS2></r19bPocDniS2>
<r20s1></r20s1>
<r20s2></r20s2>
<r21></r21>
<r22></r22>
<r23></r23>
<r24></r24>
</stlpec1>
<stlpec2>
<r01></r01>
<r02vzniku></r02vzniku>
<r02zaniku></r02zaniku>
<r03></r03>
<r04></r04>
<r05></r05>
<r06></r06>
<r07></r07>
<r08></r08>
<r09></r09>
<r10pism></r10pism>
<r11pism></r11pism>
<r12></r12>
<r12nizsiaSadzba>0</r12nizsiaSadzba>
<r13znizenbieSadzba1_25>0</r13znizenbieSadzba1_25>
<r13znizenbieSadzba1_20>0</r13znizenbieSadzba1_20>
<r13znizenbieSadzba1_15>0</r13znizenbieSadzba1_15>
<r13znizenbieSadzba2_25>0</r13znizenbieSadzba2_25>
<r13znizenbieSadzba2_20>0</r13znizenbieSadzba2_20>
<r13znizenbieSadzba2_15>0</r13znizenbieSadzba2_15>
<r13zvysenieSadzba1_10>0</r13zvysenieSadzba1_10>
<r13zvysenieSadzba1_20>0</r13zvysenieSadzba1_20>
<r13zvysenieSadzba2_10>0</r13zvysenieSadzba2_10>
<r13zvysenieSadzba2_20>0</r13zvysenieSadzba2_20>
<r14s1></r14s1>
<r14s2></r14s2>
<r15hybrid>0</r15hybrid>
<r15plyn>0</r15plyn>
<r15vodik>0</r15vodik>
<r16s1></r16s1>
<r16s2></r16s2>
<r17>0</r17>
<r18s1></r18s1>
<r18s2></r18s2>
<r19aPocMesS1></r19aPocMesS1>
<r19aPocMesS2></r19aPocMesS2>
<r19bPocDniS1></r19bPocDniS1>
<r19bPocDniS2></r19bPocDniS2>
<r20s1></r20s1>
<r20s2></r20s2>
<r21></r21>
<r22></r22>
<r23></r23>
<r24></r24>
</stlpec2>
</strana3>
</telo>
</dokument>
);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv ".
" WHERE oc = 9999 ";

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
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
          xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

//1.strana

$fo=0; $po=1;
if ( $fir_uctt03 == 999 ) { $fo=1; $po=0; }
$hodnota=$fo;
  $text = "  <fo><![CDATA[".$hodnota."]]></fo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$po;
  $text = "  <po><![CDATA[".$hodnota."]]></po>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavicka->zahos;
  $text = "  <zahranicna><![CDATA[".$hodnota."]]></zahranicna>"."\r\n"; fwrite($soubor, $text);

$hodnota=$fir_fdic;
  $text = "  <dic><![CDATA[".$hodnota."]]></dic>"."\r\n"; fwrite($soubor, $text);

$hodnota=SKDatum($hlavicka->dar);
if ( $fir_uctt03 != 999 ) $hodnota="";
if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "  <datumNarodenia><![CDATA[".$hodnota."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

$riadne="1"; $opravne="0"; $dodat="0";
if ( $hlavicka->druh == 2 ) { $riadne="0"; $opravne="1"; $dodat="0"; }
if ( $hlavicka->druh == 3 ) { $riadne="0"; $opravne="0"; $dodat="1"; }
  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$hodnota=$riadne;
  $text = "   <rdp><![CDATA[".$hodnota."]]></rdp>"."\r\n"; fwrite($soubor, $text);
$hodnota=$opravne;
  $text = "   <odp><![CDATA[".$hodnota."]]></odp>"."\r\n"; fwrite($soubor, $text);
$hodnota=$dodat;
  $text = "   <ddp><![CDATA[".$hodnota."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$hodnota=SkDatum($hlavicka->zoo);
if ( $hodnota == '00.00.0000' ) { $hodnota="01.01.".$kli_vrok; }
  $text = "   <od><![CDATA[".$hodnota."]]></od>"."\r\n"; fwrite($soubor, $text);
$hodnota=SkDatum($hlavicka->zod);
if ( $hodnota == '00.00.0000' ) { $hodnota="31.12.".$kli_vrok; }
  $text = "   <do><![CDATA[".$hodnota."]]></do>"."\r\n"; fwrite($soubor, $text);
$hodnota="";
if ( $hlavicka->druh == 3 ) $hodnota=SkDatum($hlavicka->ddp);
  $text = "   <datumDDP><![CDATA[".$hodnota."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

//udaje o FO z ufirdalsie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
$dtitz = "";
$fod = "";
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dstat = "SK";
}
if ( $fir_uctt03 == 999 )
{
$fir_fnaz = "";
}
$hodnota=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <foPriezvisko><![CDATA[".$hodnota."]]></foPriezvisko>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <foMeno><![CDATA[".$hodnota."]]></foMeno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <foTitul><![CDATA[".$hodnota."]]></foTitul>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <foTitulZa><![CDATA[".$hodnota."]]></foTitulZa>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->fod);
if ( $fir_uctt03 != 999 ) { $hodnota=""; }
  $text = "  <foObchodneMeno><![CDATA[".$hodnota."]]></foObchodneMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "  <poObchodneMeno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $fir_fnaz);
if ( $fir_uctt03 == 999 ) { $hodnota=""; }
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$hodnota="";
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </poObchodneMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$hodnota=$dcdm;
  $text = "   <cislo><![CDATA[".$hodnota."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$dpsc;
  $text = "   <psc><![CDATA[".$hodnota."]]></psc>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dstat);
  $text = "   <stat><![CDATA[".$hodnota."]]></stat>"."\r\n"; fwrite($soubor, $text);

$hodnota = $dtel;
$hodnota=str_replace("/","",$hodnota);
  $text = "   <telefon><![CDATA[".$hodnota."]]></telefon>"."\r\n"; fwrite($soubor, $text);

$hodnota = $fir_fem1;
  $text = "   <emailFax><![CDATA[".$hodnota."]]></emailFax>"."\r\n"; fwrite($soubor, $text);

  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaOrganizacnejZlozky>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zouli);
  $text = "   <ulica><![CDATA[".$hodnota."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zocdm;
  $text = "   <cislo><![CDATA[".$hodnota."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zopsc;
  $text = "   <psc><![CDATA[".$hodnota."]]></psc>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zomes);
  $text = "   <obec><![CDATA[".$hodnota."]]></obec>"."\r\n"; fwrite($soubor, $text);
$hodnota = $hlavicka->zotel;
$hodnota=str_replace("/","",$hodnota);
  $text = "   <telefon><![CDATA[".$hodnota."]]></telefon>"."\r\n"; fwrite($soubor, $text);
$hodnota = $hlavicka->zoema;
  $text = "   <emailFax><![CDATA[".$hodnota."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaOrganizacnejZlozky>"."\r\n"; fwrite($soubor, $text);

//2.strana
  $text = "  <typZastupcu>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 1 ) $hodnota=1;
  $text = "   <typZastupca><![CDATA[".$hodnota."]]></typZastupca>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 6 ) $hodnota=1;
  $text = "   <dedic><![CDATA[".$hodnota."]]></dedic>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 3 ) $hodnota=1;
  $text = "   <spravcaVkonkurznomKonani><![CDATA[".$hodnota."]]></spravcaVkonkurznomKonani>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 7 ) $hodnota=1;
  $text = "   <likvidator><![CDATA[".$hodnota."]]></likvidator>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 2 ) $hodnota=1;
  $text = "   <statutarnyZastupcaPO><![CDATA[".$hodnota."]]></statutarnyZastupcaPO>"."\r\n"; fwrite($soubor, $text);
$hodnota="0"; if ( $hlavicka->druh3 == 4 ) $hodnota=1;
  $text = "   <pravnyNastupca><![CDATA[".$hodnota."]]></pravnyNastupca>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typZastupcu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "   <priezvisko><![CDATA[".$hodnota."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3meno);
  $text = "   <meno><![CDATA[".$hodnota."]]></meno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3titl);
  $text = "   <titul><![CDATA[".$hodnota."]]></titul>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3titz);
  $text = "   <titulZa><![CDATA[".$hodnota."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->rdc3.$hlavicka->rdk3;
  $text = "   <rc><![CDATA[".$hodnota."]]></rc> "."\r\n"; fwrite($soubor, $text);
$hodnota=SkDatum($hlavicka->dar3);
  $text = "   <datumNarodenia><![CDATA[".$hodnota."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->dic3;
  $text = "   <dic><![CDATA[".$hodnota."]]></dic>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->naz3);
  $text = "   <obchodneMeno><![CDATA[".$hodnota."]]></obchodneMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "   <adresa>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3uli);
  $text = "    <ulica><![CDATA[".$hodnota."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->d3cdm;
  $text = "    <cislo><![CDATA[".$hodnota."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->d3psc;
  $text = "    <psc><![CDATA[".$hodnota."]]></psc>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->d3mes);
  $text = "    <obec><![CDATA[".$hodnota."]]></obec>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->xstat3);
  $text = "    <stat><![CDATA[".$hodnota."]]></stat>"."\r\n"; fwrite($soubor, $text);
$hodnota = $hlavicka->d3tel;
$hodnota=str_replace("/","",$hodnota);
  $text = "    <telefon><![CDATA[".$hodnota."]]></telefon>"."\r\n"; fwrite($soubor, $text);
$hodnota = $hlavicka->d3fax;
$hodnota=str_replace("/","",$hodnota);
  $text = "    <emailFax><![CDATA[".$hodnota."]]></emailFax>"."\r\n"; fwrite($soubor, $text);
  $text = "   </adresa>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>	"."\r\n"; fwrite($soubor, $text);

  $text = " <telo> "."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavicka->r35;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r35><![CDATA[".$hodnota."]]></r35>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r36;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r36><![CDATA[".$hodnota."]]></r36>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r37;
  $text = "  <r37><![CDATA[".$hodnota."]]></r37>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r38;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r38><![CDATA[".$hodnota."]]></r38>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r39;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r39><![CDATA[".$hodnota."]]></r39>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r40;
  $text = "  <r40><![CDATA[".$hodnota."]]></r40>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r41;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r41><![CDATA[".$hodnota."]]></r41>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r42;
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r42><![CDATA[".$hodnota."]]></r42>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r43;
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r43><![CDATA[".$hodnota."]]></r43>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r44;
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r44><![CDATA[".$hodnota."]]></r44>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->r45;
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <r45><![CDATA[".$hodnota."]]></r45>"."\r\n"; fwrite($soubor, $text);

  $text = "  <vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zvra;
  $text = "   <vratit><![CDATA[".$hodnota."]]></vratit>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->post;
if ( $hlavicka->zvra == 0 ) $hodnota="0";
  $text = "    <poukazka><![CDATA[".$hodnota."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->ucet;
if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <ucet><![CDATA[".$hodnota."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$hodnota=$fir_fuc1;
if ( $hlavicka->ucet == 0 ) $hodnota="";
if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <cisloUctu><![CDATA[".$hodnota."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$hodnota=$fir_fnm1;
if ( $hlavicka->ucet == 0 ) $hodnota="";
if ( $hlavicka->zvra == 0 ) $hodnota="";
  $text = "    <kodBanky><![CDATA[".$hodnota."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
$hodnota=$fir_fib1;
  $text = "    <IBAN><![CDATA[".$hodnota."]]></IBAN>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$hodnota=SkDatum($hlavicka->dvp);
if ( $hodnota == '00.00.0000' ) { $hodnota=""; }
  $text = "   <datum>".$hodnota."</datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vrateniePreplatku>"."\r\n"; fwrite($soubor, $text);

$hodnota=iconv("CP1250", "UTF-8", $hlavicka->pozn);
  $text = "  <poznamky><![CDATA[".$hodnota."]]></poznamky>"."\r\n"; fwrite($soubor, $text);

$hodnota=SkDatum($hlavicka->dvh);
if ( $hodnota == '00.00.0000' ) { $hodnota=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); }
  $text = "   <datumVyhlasenia>".$hodnota."</datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

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
  $text = "    <aktualna><![CDATA[".$hodnota."]]></aktualna>"."\r\n"; fwrite($soubor, $text);
  $hodnota=$pocetstran3;
  $text = "    <celkovo><![CDATA[".$hodnota."]]></celkovo>"."\r\n"; fwrite($soubor, $text);
  $text = "   </oznacenie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <stlpec1>"."\r\n"; fwrite($soubor, $text);
                }

if ( $jv == 1 ) {
  $text = "   <stlpec2>"."\r\n"; fwrite($soubor, $text);
                }
$hodnota=SKDatum($hlavickav->da1);
if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "    <r01><![CDATA[".$hodnota."]]></r01>"."\r\n"; fwrite($soubor, $text);
$hodnota=SKDatum($hlavickav->datz);
if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "    <r02vzniku><![CDATA[".$hodnota."]]></r02vzniku>"."\r\n"; fwrite($soubor, $text);
$hodnota=SKDatum($hlavickav->datk);
if ( $hodnota =='00.00.0000' ) $hodnota="";
  $text = "    <r02zaniku><![CDATA[".$hodnota."]]></r02zaniku>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->vzkat;
  $text = "    <r03><![CDATA[".$hodnota."]]></r03>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->vzdru;
  $text = "    <r04><![CDATA[".$hodnota."]]></r04>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->vzspz;
  $text = "    <r05><![CDATA[".$hodnota."]]></r05>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->vzobm;
  $text = "    <r06><![CDATA[".$hodnota."]]></r06>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->vzvyk;
  $text = "    <r07><![CDATA[".$hodnota."]]></r07>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->vzchm;
  $text = "    <r08><![CDATA[".$hodnota."]]></r08>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->vznpr;
  $text = "    <r09><![CDATA[".$hodnota."]]></r09>"."\r\n"; fwrite($soubor, $text);

$dnvnk = $hlavickav->dnvnk;
$oslbd = $hlavickav->oslbd;
if ( $oslbd == 0 ) $oslbd="";
  $text = "     <r10pism><![CDATA[".$dnvnk."]]></r10pism>"."\r\n"; fwrite($soubor, $text);
  $text = "     <r11pism><![CDATA[".$oslbd."]]></r11pism>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavickav->r12;
  $text = "    <r12><![CDATA[".$hodnota."]]></r12>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r12doniz;
  $text = "    <r12nizsiaSadzba><![CDATA[".$hodnota."]]></r12nizsiaSadzba>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavickav->r13s1zni25;
  $text = "    <r13znizenbieSadzba1_25><![CDATA[".$hodnota."]]></r13znizenbieSadzba1_25>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s1zni20;
  $text = "    <r13znizenbieSadzba1_20><![CDATA[".$hodnota."]]></r13znizenbieSadzba1_20>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s1zni15;
  $text = "    <r13znizenbieSadzba1_15><![CDATA[".$hodnota."]]></r13znizenbieSadzba1_15>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s2zni25;
  $text = "    <r13znizenbieSadzba2_25><![CDATA[".$hodnota."]]></r13znizenbieSadzba2_25>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s2zni20;
  $text = "    <r13znizenbieSadzba2_20><![CDATA[".$hodnota."]]></r13znizenbieSadzba2_20>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s2zni15;
  $text = "    <r13znizenbieSadzba2_15><![CDATA[".$hodnota."]]></r13znizenbieSadzba2_15>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavickav->r13s1zvy10;
  $text = "    <r13zvysenieSadzba1_10><![CDATA[".$hodnota."]]></r13zvysenieSadzba1_10>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s1zvy20;
  $text = "    <r13zvysenieSadzba1_20><![CDATA[".$hodnota."]]></r13zvysenieSadzba1_20>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s2zvy10;
  $text = "    <r13zvysenieSadzba2_10><![CDATA[".$hodnota."]]></r13zvysenieSadzba2_10>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavickav->r13s2zvy20;
  $text = "    <r13zvysenieSadzba2_20><![CDATA[".$hodnota."]]></r13zvysenieSadzba2_20>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r14s1;
  $text = "    <r14s1><![CDATA[".$hodnota."]]></r14s1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r14s2;
  $text = "    <r14s2><![CDATA[".$hodnota."]]></r14s2>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r15s1zni50a;
  $text = "    <r15hybrid><![CDATA[".$hodnota."]]></r15hybrid>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r15s1zni50b;
  $text = "    <r15plyn><![CDATA[".$hodnota."]]></r15plyn>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r15s1zni50c;
  $text = "    <r15vodik><![CDATA[".$hodnota."]]></r15vodik>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r16s1;
  $text = "    <r16s1><![CDATA[".$hodnota."]]></r16s1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r16s2;
  $text = "    <r16s2><![CDATA[".$hodnota."]]></r16s2>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r17;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r17><![CDATA[".$hodnota."]]></r17>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r18s1;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r18s1><![CDATA[".$hodnota."]]></r18s1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r18s2;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r18s2><![CDATA[".$hodnota."]]></r18s2>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r19s1mes;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r19aPocMesS1><![CDATA[".$hodnota."]]></r19aPocMesS1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r19s2mes;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r19aPocMesS2><![CDATA[".$hodnota."]]></r19aPocMesS2>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r19s1den;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r19bPocDniS1><![CDATA[".$hodnota."]]></r19bPocDniS1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r19s2den;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r19bPocDniS2><![CDATA[".$hodnota."]]></r19bPocDniS2>"."\r\n"; fwrite($soubor, $text);

$hodnota=$hlavickav->r20s1;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r20s1><![CDATA[".$hodnota."]]></r20s1>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavickav->r20s2;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r20s2><![CDATA[".$hodnota."]]></r20s2>"."\r\n"; fwrite($soubor, $text);

$hodnota = $hlavickav->r21;
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r21><![CDATA[".$hodnota."]]></r21>"."\r\n"; fwrite($soubor, $text);

$hodnota="$hlavickav->r22";
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r22><![CDATA[".$hodnota."]]></r22>"."\r\n"; fwrite($soubor, $text);
$hodnota="$hlavickav->r23";
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r23><![CDATA[".$hodnota."]]></r23>"."\r\n"; fwrite($soubor, $text);
$hodnota="$hlavickav->r24";
if ( $hlavicka->druh != 3 ) $hodnota="";
if ( $hodnota == 0 ) $hodnota="";
  $text = "    <r24><![CDATA[".$hodnota."]]></r24>"."\r\n"; fwrite($soubor, $text);

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

  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);

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
