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
alert ("Daòové priznanie XML bude pripravené v priebehu januára 2015. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
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

//rok2014
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<!-- Danove priznanie k dani z prijmov pravnickej osoby (DPPO), vzor 2014 -->
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<dic>1234567890</dic>
		<ico>12345678</ico>
		<pravnaForma>112</pravnaForma>
		<typDP>
			<rdp>1</rdp>
			<odp>0</odp>
			<ddp>0</ddp>
		</typDP>
		<zdanovacieObdobie>
			<od>01.01.2014</od>
			<do>31.12.2014</do>
		</zdanovacieObdobie>
		<skNace>
			<k1>31</k1>
			<k2>03</k2>
			<k3>0</k3>
			<cinnost>Výroba matracov </cinnost>
		</skNace>
		<obchodneMeno>
			<riadok>Názov riadok 1</riadok>
			<riadok>Názov riadok 2</riadok>
			<riadok>Názov riadok 3</riadok>
		</obchodneMeno>
		<sidlo>
			<ulica>Obyèajná</ulica>
			<cislo>06</cislo>
			<psc>07007</psc>
			<obec>Žilina</obec>
			<stat>Slovensko</stat>
			<tel>055/22445566</tel>
			<emailFax>email@mail.sk</emailFax>
		</sidlo>
		<uplatnujemPar17>0</uplatnujemPar17>
		<ukoncujemUplatnovaniePar17>0</ukoncujemUplatnovaniePar17>
		<obmedzenie>0</obmedzenie>
		<prepojenie>1</prepojenie>
		<somPlatitel>0</somPlatitel>
		<rocnyObratPresiahol500tis>0</rocnyObratPresiahol500tis>
		<polVyskaDanovejLicPar46bods3>0</polVyskaDanovejLicPar46bods3>
		<neplatimDanLicenciu>0</neplatimDanLicenciu>
		<stalaPrevadzkaren>
			<ulica>Ulica</ulica>
			<cislo>13</cislo>
			<psc>14014</psc>
			<obec>Žilina</obec>
			<pocetSp>16</pocetSp>
		</stalaPrevadzkaren>
	</hlavicka>
	<telo>
		<r100>-100000.00</r100>
		<r110>110.11</r110>
		<r120>120.12</r120>
		<r130>130.13</r130>
		<r140>140.14</r140>
		<r150>150.15</r150>
		<r160>160.16</r160>
		<r170>170.17</r170>
		<r180>180.18</r180>
		<r200>-200.20</r200>
		<r210>210.21</r210>
		<r220>220.22</r220>
		<r230>230.23</r230>
		<r240>240.24</r240>
		<r250>250.25</r250>
		<r260>260.26</r260>
		<r270>270.27</r270>
		<r280>280.28</r280>
		<r290>290.29</r290>
		<r300>300.30</r300>
		<r310>-310.31</r310>
		<r320>-320.32</r320>
		<r330>330.33</r330>
		<r400>-400.40</r400>
		<r410>410.41</r410>
		<r500>500.50</r500>
		<r510>510.51</r510>
		<r600>600.60</r600>
		<r610>
			<text>§ 30a zákona è. 595/2003 Z.z.</text>
			<suma>610.61</suma>
		</r610>
		<r700>700.70</r700>
		<r710>710.71</r710>
		<r800>800.80</r800>
		<r810>810.81</r810>
		<r820>820.82</r820>
		<r830>830.83</r830>
		<r840>840.84</r840>
		<r900>900.00</r900>
		<r910>910.91</r910>
		<r920>920.92</r920>
		<r930>930.93</r930>
		<r940>940.94</r940>
		<r950>950.95</r950>
		<r960>960.96</r960>
		<r1000>1000.10</r1000>
		<r1001>1001.01</r1001>
		<r1010>1010.91</r1010>
		<ddpDatum>28.4.2014</ddpDatum>
		<r1020>1020.92</r1020>
		<r1030>-1030.93</r1030>
		<r1040>1040.94</r1040>
		<r1050>-1050.95</r1050>
		<r1060>1060.96</r1060>
		<r1070>-1070.97</r1070>
		<tabA>
			<r01>101.01</r01>
			<r02>102.02</r02>
			<r03>103.03</r03>
			<r04>104.04</r04>
			<r05>105.05</r05>
			<r06>106.06</r06>
			<r07>107.07</r07>
			<r08>108.08</r08>
			<r09>109.09</r09>
			<r10>100.10</r10>
			<r11>111.11</r11>
			<r12>112.12</r12>
			<r13>113.13</r13>
			<r14>114.14</r14>
			<r15>115.15</r15>
		</tabA>
		<tabB>
			<r01>201.01</r01>
			<r02>202.02</r02>
			<r03>203.03</r03>
			<r04>204.04</r04>
		</tabB>
		<tabC1>
			<r01>301.01</r01>
			<r02>302.02</r02>
			<r03>303.03</r03>
			<r04>304.04</r04>
			<r05>305.05</r05>
		</tabC1>
		<tabC2>
			<r01>301.01</r01>
			<r02>302.02</r02>
			<r03>303.03</r03>
			<r04>304.04</r04>
			<r05>305.05</r05>
		</tabC2>
		<tabD>
			<tabDs01>
				<r02>41102.02</r02>
				<r03>41103.03</r03>
				<r06>41106.06</r06>
			</tabDs01>
			<tabDs02>
				<r02>41202.02</r02>
				<r03>41203.03</r03>
				<r04>41204.04</r04>
				<r05>41205.05</r05>
				<r06>41206.06</r06>
				<r07>41207.07</r07>
			</tabDs02>
			<tabDs03>
				<r01od>03.03.2011</r01od>
				<r01do>03.03.2012</r01do>
				<r02>41302.02</r02>
				<r03>41303.03</r03>
				<r04>41304.04</r04>
				<r05>41305.05</r05>
				<r06>41306.06</r06>
			</tabDs03>
			<tabDs04>
				<r01od>04.04.2011</r01od>
				<r01do>04.04.2012</r01do>
				<r02>41402.02</r02>
				<r03>41403.03</r03>
				<r04>41404.04</r04>
				<r05>41405.05</r05>
				<r06>41506.06</r06>
			</tabDs04>
			<tabDs05>
				<r01od>05.05.2011</r01od>
				<r01do>05.05.2012</r01do>
				<r02>41502.02</r02>
				<r03>41503.03</r03>
				<r04>41504.04</r04>
				<r05>41505.05</r05>
				<r06>41606.06</r06>
			</tabDs05>
			<tabDs06>
				<r05>41605.05</r05>
				<r06>41606.06</r06>
			</tabDs06>
		</tabD>
		<tabE>
			<r01>501.01</r01>
			<r02>502.02</r02>
			<r03>500.03</r03>
			<r04>504.04</r04>
			<r05>505.05</r05>
			<r06>506.06</r06>
		</tabE>
		<tabF>
			<r01>601.01</r01>
			<r02>602.02</r02>
			<r03>603.03</r03>
		</tabF>
		<tabG1>
			<r01>711.01</r01>
			<r02>712.02</r02>
			<r03>713.03</r03>
		</tabG1>
		<tabG2>
			<r01>721.01</r01>
			<r02>722.02</r02>
			<r03>723.03</r03>
		</tabG2>
		<tabG3>
			<r01>731.01</r01>
			<r02>732.02</r02>
			<r03>733.03</r03>
			<r04>734.04</r04>
		</tabG3>
		<tabH>
			<r01>801.11</r01>
			<prijmy>
				<r02>802.12</r02>
				<r03>803.13</r03>
				<r04>804.14</r04>
				<r05>805.15</r05>
				<r06>806.16</r06>
				<r07>807.17</r07>
				<r08>808.18</r08>
				<r09>809.19</r09>
			</prijmy>
			<vydavky>
				<r02>822.12</r02>
				<r03>823.13</r03>
				<r04>824.14</r04>
				<r05>825.15</r05>
				<r06>826.16</r06>
				<r07>827.17</r07>
				<r08>828.18</r08>
				<r09>829.19</r09>
			</vydavky>
			<r10>826.16</r10>
		</tabH>
		<tabI>
			<vynosy>
				<r01>901.11</r01>
				<r02>902.12</r02>
				<r03>903.13</r03>
				<r04>904.14</r04>
				<r05>905.15</r05>
				<r06>906.16</r06>
				<r07>907.17</r07>
			</vynosy>
			<naklady>
				<r01>921.11</r01>
				<r02>922.12</r02>
				<r03>923.13</r03>
				<r04>924.14</r04>
				<r05>925.15</r05>
				<r06>926.16</r06>
				<r07>927.17</r07>
			</naklady>
		</tabI>
		<tabJ>
			<r01>1001.01</r01>
			<r02>1002</r02>
			<r03>1003</r03>
			<r04>1004.12</r04>
			<r05>1005.15</r05>
		</tabJ>
		<tabK>
			<tabKs01>
				<r01s01od>01.01.2001</r01s01od>
				<r01s01do>01.02.2001</r01s01do>
				<r02s01od>02.01.2002</r02s01od>
				<r02s01do>02.02.2002</r02s01do>
				<r03s01od>03.01.2003</r03s01od>
				<r03s01do>03.02.2003</r03s01do>
				<r04s01od>04.01.2004</r04s01od>
				<r04s01do>04.02.2004</r04s01do>
			</tabKs01>
			<tabKs02>
				<r01s02>201.01</r01s02>
				<r02s02>202.02</r02s02>
				<r03s02>203.03</r03s02>
				<r04s02>204.04</r04s02>
			</tabKs02>
			<tabKs03>
				<r03s03>303.03</r03s03>
				<r04s03>304.04</r04s03>
			</tabKs03>
			<tabKs04>
				<r02s04>402.04</r02s04>
				<r03s04>403.04</r03s04>
				<r04s04>404.04</r04s04>
				<r05s04>405.04</r05s04>
			</tabKs04>
			<tabKs05>
				<r01s05>501.05</r01s05>
				<r02s05>502.05</r02s05>
				<r03s05>503.05</r03s05>
				<r04s05>504.05</r04s05>
				<r05s05>505.05</r05s05>
			</tabKs05>
		</tabK>
		<c4paragraf50>1</c4paragraf50>
		<c4r1>11</c4r1>
		<c4r2>2400</c4r2>
		<c4r3>3400</c4r3>
		<c4r4>4400</c4r4>
		<c4r5>5400</c4r5>
		<c4r6>6400</c4r6>
		<c4r7>7400</c4r7>
		<c4prijimatel1>
			<suma>7101</suma>
			<ico>12345678</ico>
			<sid>1234</sid>
			<pravnaForma>pravna forma</pravnaForma>
			<obchodneMeno>
				<riadok>Nadacia riadok 1</riadok>
				<riadok>riadok 2</riadok>
			</obchodneMeno>
			<ulica>Neobyèajná</ulica>
			<cislo>71</cislo>
			<psc>71070</psc>
			<obec>Nitra</obec>
		</c4prijimatel1>
		<osobitneZaznamy>tu je text</osobitneZaznamy>
		<opravnenaOsoba>
			<priezvisko>Kurièka</priezvisko>
			<meno>ooJán</meno>
			<titul>MVDr.</titul>
			<titulZa>PhDr.</titulZa>
			<postavenie>osobný lekár</postavenie>
			<trvalyPobyt>
				<ulica>Pod mostom</ulica>
				<cislo>1A/561</cislo>
				<psc>84545</psc>
				<obec>Bratislava</obec>
				<stat>Slovensko</stat>
				<tel>055/22445566</tel>
				<emailFax>055/22445566</emailFax>
			</trvalyPobyt>
		</opravnenaOsoba>
		<pocetPriloh>2</pocetPriloh>
		<datumVyhlasenia>30.11.2014</datumVyhlasenia>
		<vrateniePreplatku>
			<vratit>1</vratit>
			<sposobPlatby>
				<poukazka>0</poukazka>
				<ucet>1</ucet>
			</sposobPlatby>
			<bankovyUcet>
				<IBAN>SK111111111111111</IBAN>
				<predcislieUctu>123456</predcislieUctu>
				<cisloUctu>202202202</cisloUctu>
				<kodBanky>2200</kodBanky>
			</bankovyUcet>
			<datum>27.11.2014</datum>
		</vrateniePreplatku>
		<dividendy>
			<divr01>
				<s1>1.01</s1>
			</divr01>
			<divr02>
				<s1>2.01</s1>
				<s2>2.02</s2>
			</divr02>
			<divr03>
				<s1>3.01</s1>
				<s2>3.02</s2>
			</divr03>
			<divr04>
				<s1>4.01</s1>
				<s2>4.02</s2>
			</divr04>
			<divr05>5.05</divr05>
			<divr06>15</divr06>
			<divr07>7.07</divr07>
			<divr08>8.08</divr08>
			<divr09>9.09</divr09>
			<divr10>10.10</divr10>
			<divr11>11.11</divr11>
			<divr12>12.12</divr12>
			<divr13>13.13</divr13>
			<divr14>14.14</divr14>
			<divr15>15.15</divr15>
			<divr16>16.16</divr16>
			<datum>28.02.2014</datum>
		</dividendy>
		<priloha>
			<prijimatel>
				<poradoveCislo>1</poradoveCislo>
				<suma>720.00</suma>
				<ico>12345678</ico>
				<sid>1234</sid>
				<pravnaForma>nadacia</pravnaForma>
				<obchodneMeno>
					<riadok>riadok 1</riadok>
					<riadok>riadok 2</riadok>
				</obchodneMeno>
				<ulica>Horná</ulica>
				<cislo>7</cislo>
				<psc>72</psc>
				<obec>Žilina</obec>
			</prijimatel>
			<prijimatel>
				<poradoveCislo>2</poradoveCislo>
				<suma>720.00</suma>
				<ico>12345678</ico>
				<sid>1234</sid>
				<pravnaForma>forma</pravnaForma>
				<obchodneMeno>
					<riadok>riadok 1</riadok>
					<riadok>riadok 2</riadok>
				</obchodneMeno>
				<ulica>Ulica</ulica>
				<cislo>2</cislo>
				<psc>20208</psc>
				<obec>Nitra</obec>
			</prijimatel>
			<prijimatel>
				<poradoveCislo>3</poradoveCislo>
				<suma>720.00</suma>
				<ico>3034578</ico>
				<sid>3034</sid>
				<pravnaForma>V.O.S.</pravnaForma>
				<obchodneMeno>
					<riadok>Nazov riadok 1</riadok>
					<riadok>riadok 2</riadok>
				</obchodneMeno>
				<ulica>Gudernova</ulica>
				<cislo>7</cislo>
				<psc>72020</psc>
				<obec>Košice</obec>
			</prijimatel>
		</priloha>
	</telo>
</dokument>
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
  $text = "  <uplatnujemUplatnovaniePar17><![CDATA[".$text."]]></uplatnujemUplatnovaniePar17>"."\r\n"; fwrite($soubor, $text);
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
if ( $riadok == 0 ) $riadok="0.00";
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
$pico=$hlavicka->pico;
$psid=$hlavicka->psid;
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