<HTML>
<?php
//XML pre Poznamky PODv2013 za rok 2013
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


//koniec nastav tlac z archivu

$nazsub="POZNAMKY_POD304_".$kli_vrok."_".$kli_uzid.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pozn·mky export - EuroSecom</title>
</HEAD>
<BODY class="white" >
<table class="h2" width="100%">
 <tr>
  <td>EuroSecom - Pozn·mky ⁄c POD 3 - 01 k DPPO rok <?php echo $kli_vrok; ?> export</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
 </tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");

//rok2013
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<!-- XML pre Poznamky individualnej uctovnej zavierky (UVPOD3). -->
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<datumK>
			<den>31</den>
			<mesiac>12</mesiac>
			<rok>2012</rok>
		</datumK>
		<dic>123456789</dic>
		<ico>123456789</ico>
		<skNace>
			<k1>31</k1>
			<k2>03</k2>
			<k3>0</k3>
		</skNace>
		<typUzavierky>
			<riadna>1</riadna>
			<mimoriadna>0</mimoriadna>
			<priebezna>0</priebezna>
			<zostavena>0</zostavena>
			<schvalena>0</schvalena>
			<vEuroCentoch>0</vEuroCentoch>
			<vCelychEurach>0</vCelychEurach>
		</typUzavierky>
		<obdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2012</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2012</rok>
			</do>
		</obdobie>
		<bPredObdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2011</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2011</rok>
			</do>
		</bPredObdobie>
		<uctJednotka>
			<obchMeno>
				<riadok>Meno ˙Ëtovej jednotky</riadok>
				<riadok>pokraËovanie mena</riadok>
			</obchMeno>
			<sidlo>
				<ulica>Ulica</ulica>
				<cislo>13</cislo>
				<psc>66666</psc>
				<obec>Obec</obec>
				<telefon>444444444</telefon>
				<fax>444444444</fax>
				<email>e-mail@uctovnaJednotka.sk</email>
			</sidlo>
		</uctJednotka>
		<datZostavenia>16.1.2011</datZostavenia>
		<datSchvalenia>23.1.2011</datSchvalenia>
	</hlavicka>
</dokument>
);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011 ";

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

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = "  <datumK>"."\r\n"; fwrite($soubor, $text);

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

$pole = explode(".", $datk_sk);
$denk_sk=$pole[0];
$mesk_sk=$pole[1];
$rokk_sk=$pole[2];
if ( $rokk_sk < 10 ) $rokk_sk='0'.$rokk_sk;
$den=$denk_sk;
  $text = "   <den><![CDATA[".$den."]]></den>"."\r\n"; fwrite($soubor, $text);
$mesiac=$mesk_sk;
  $text = "   <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
$rok=$rokk_sk;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </datumK>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$ico=$fir_fico;
  $text = "  <ico><![CDATA[".$ico."]]></ico>"."\r\n"; fwrite($soubor, $text);

$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
$k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
$k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typUzavierky>"."\r\n"; fwrite($soubor, $text);

$druz=0;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druz=1*$riadok->druz;
  }

$riadna=1;
$mimoriadna=0;
if( $druz == 1 ) { $riadna=0; $mimoriadna=1; } 
$priebezna=0;
  $text = "   <riadna><![CDATA[".$riadna."]]></riadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <mimoriadna><![CDATA[".$mimoriadna."]]></mimoriadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <priebezna><![CDATA[".$priebezna."]]></priebezna>"."\r\n"; fwrite($soubor, $text);
$zostavena=$hlavicka->a1e;
  $text = "   <zostavena><![CDATA[".$zostavena."]]></zostavena>"."\r\n"; fwrite($soubor, $text);
$schvalena=$hlavicka->a2e;
  $text = "   <schvalena><![CDATA[".$schvalena."]]></schvalena>"."\r\n"; fwrite($soubor, $text);
$eurocenty=1;
  $text = "   <vEuroCentoch><![CDATA[".$eurocenty."]]></vEuroCentoch>"."\r\n"; fwrite($soubor, $text);
$eura=0;
  $text = "   <vCelychEurach><![CDATA[".$eura."]]></vCelychEurach>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typUzavierky>"."\r\n"; fwrite($soubor, $text);

  $text = "  <obdobie>"."\r\n"; fwrite($soubor, $text);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.12.".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
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

$mesiac=$obdm1; $rok=$obdr1;
  $text = "   <od>"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "   </od>"."\r\n"; fwrite($soubor, $text);

$mesiac=$obdm2; $rok=$obdr2;
  $text = "   <do>"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "   </do>"."\r\n";   fwrite($soubor, $text);
  $text = "  </obdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <bPredObdobie>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obmm1; $rok=$obmr1;
  $text = "   <od>"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "   </od>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obmm2; $rok=$obmr2;
  $text = "   <do>"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);  //dopyt, nie je
  $text = "   </do>"."\r\n";   fwrite($soubor, $text);
  $text = "  </bPredObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <uctJednotka>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchMeno>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n"; fwrite($soubor, $text);

  $text = "   <sidlo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = "    <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
  $text = "    <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n"; fwrite($soubor, $text);
$fax=$fir_ffax;
  $text = "    <fax><![CDATA[".$fax."]]></fax>"."\r\n"; fwrite($soubor, $text);
$email=$fir_fem1;
  $text = "    <email><![CDATA[".$email."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sidlo>"."\r\n"; fwrite($soubor, $text);
  $text = "  </uctJednotka>"."\r\n"; fwrite($soubor, $text);


$h_sch=$_REQUEST['h_sch'];
$h_zos=$_REQUEST['h_zos'];
if( $zostavena == 1 ) { $h_sch=""; }
if( $schvalena == 1 ) { $h_zos=""; }

$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
  $text = "  <datZostavenia><![CDATA[".$text."]]></datZostavenia>"."\r\n"; fwrite($soubor, $text);

$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
  $text = "  <datSchvalenia><![CDATA[".$text."]]></datSchvalenia>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n";   fwrite($soubor, $text);
          }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);

$nazsuborpdf="poznamky.".$kli_uzid.".pdf";
?>

<?php
if ( $elsubor == 2 )
{
?>
<br />
<?php if ( $kli_vrok == 2013 ) { ?>
<p>
Stiahnite si niûöie uvedenÈ s˙bory XML a PDF na V·ö lok·lny disk. Pomocou xml naËÌtate len prv˙ stranu pozn·mok.
ZvyönÈ strany posielate cez pdf s˙bor, ktor˝ pri podanÌ d·te ako prÌlohu.<br />
Vyuûiù mÙûete <a href="https://www.financnasprava.sk" target="_blank" title="FinanËn· spr·va SR">port·l finanËnej spr·vy</a> alebo aplik·ciu
<a href="https://www.financnasprava.sk/sk/elektronicke-sluzby/elektronicka-komunikacia/elektronicka-komunikacia-dane/edane" target="_blank" title="aplik·cia eDane Java">eDane</a>.
</p>
<?php                         } ?>

<?php if ( $kli_vrok == 2014 ) { ?>
<p>
<strong>NOVINKA:</strong> pri ˙Ëtovnej z·vierke k <strong>31.12.<?php echo $kli_vrok; ?></strong> stiahnite
<strong>iba pdf s˙bor</strong>, ktor˝ naËÌtate cez prÌlohu k ˙Ëtovnej z·vierke.
</p>
<p>
Vyuûiù mÙûete <a href="https://www.financnasprava.sk" target="_blank" title="FinanËn· spr·va SR">port·l finanËnej spr·vy</a> alebo aplik·ciu
<a href="https://www.financnasprava.sk/sk/elektronicke-sluzby/elektronicka-komunikacia/elektronicka-komunikacia-dane/edane" target="_blank" title="aplik·cia eDane Java">eDane</a>.
</p>
<?php                          } ?>

<?php if ( $kli_vrok >= 2015 ) { ?>
<p>
<strong>NOVINKA:</strong> pri ˙Ëtovnej z·vierke k <strong>31.12.<?php echo $kli_vrok; ?></strong> stiahnite
<strong>iba pdf s˙bor</strong>, ktor˝ naËÌtate cez prÌlohu k ˙Ëtovnej z·vierke.
</p>
<p>
Vyuûiù mÙûete <a href="https://www.financnasprava.sk" target="_blank" title="FinanËn· spr·va SR">port·l finanËnej spr·vy</a> alebo aplik·ciu
<a href="https://www.financnasprava.sk/sk/elektronicke-sluzby/elektronicka-komunikacia/elektronicka-komunikacia-dane/edane" target="_blank" title="aplik·cia eDane Java">eDane</a>.
</p>
<?php                          } ?>


<br>
<a href="../tmp/<?php echo $nazsuborpdf; ?>">../tmp/<?php echo $nazsuborpdf; ?></a>
<br>
<br>
<?php if ( $kli_vrok < 2015 ) { ?>
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<?php                          } ?>

<br>
<br>



<br />
<br />




<?php
}
?>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<?php
//mysql_free_result($vysledok);
     }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>
