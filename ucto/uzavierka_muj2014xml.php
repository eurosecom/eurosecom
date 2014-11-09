<HTML>
<?php

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

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

$chyby = 1*$_REQUEST['chyby'];

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

$nazsub="UZAVIERKA_MUJ_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzávierka MUJ XML</title>
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
<BODY class="white" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Úètovná závierka MUJ <?php echo $kli_vrok; ?> - export do XML

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2  )
    {

//prva strana


if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");


$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<datumK>
			<den>31</den>
			<mesiac>12</mesiac>
			<rok>2014</rok>
		</datumK>
		<dic>0123456789</dic>
		<ico>12345678</ico>
		<skNace>
			<k1>31</k1>
			<k2>03</k2>
			<k3>0</k3>
		</skNace>
		<typUzavierky>
			<riadna>1</riadna>
			<mimoriadna>0</mimoriadna>
			<priebezna>0</priebezna>
		</typUzavierky>
		<obdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2014</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2014</rok>
			</do>
		</obdobie>
		<bPredObdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2013</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2013</rok>
			</do>
		</bPredObdobie>
		<prilozeneSucasti>
			<suvaha>1</suvaha>
			<vykazZiskovStrat>1</vykazZiskovStrat>
			<poznamky>1</poznamky>
		</prilozeneSucasti>
		<uctJednotka>
			<obchMeno>
				<riadok>Meno úètovej jednotky</riadok>
				<riadok>pokraèovanie mena</riadok>
			</obchMeno>
			<sidlo>
				<ulica>Ulicová</ulica>
				<cislo>13</cislo>
				<psc>66666</psc>
				<obec>Obcová</obec>
				<oznObchodReg>
					<riadok>Oznaèenie obchodného registra a èíslo</riadok>
					<riadok>zápisu obchodnej spoloènosti</riadok>
				</oznObchodReg>
				<telefon>0901123456</telefon>
				<fax>0902123456</fax>
				<email>e-mail@uctovnaJednotka.sk</email>
			</sidlo>
		</uctJednotka>
		<datZostavenia>16.1.2015</datZostavenia>
		<datSchvalenia>23.1.2015</datSchvalenia>
	</hlavicka>
	<telo>
		<ucMuj1Suvaha>
			<r01>
				<s1>1011</s1>
				<s2>1012</s2>
			</r01>
			<r02>
				<s1>1021</s1>
				<s2>1022</s2>
			</r02>
			<r03>
				<s1>1031</s1>
				<s2>1032</s2>
			</r03>
			<r04>
				<s1>1041</s1>
				<s2>1042</s2>
			</r04>
			<r05>
				<s1>1051</s1>
				<s2>1052</s2>
			</r05>
			<r06>
				<s1>1061</s1>
				<s2>1062</s2>
			</r06>
			<r07>
				<s1>1071</s1>
				<s2>1072</s2>
			</r07>
			<r08>
				<s1>1081</s1>
				<s2>1082</s2>
			</r08>
			<r09>
				<s1>1091</s1>
				<s2>1092</s2>
			</r09>
			<r10>
				<s1>1101</s1>
				<s2>1102</s2>
			</r10>
			<r11>
				<s1>1111</s1>
				<s2>1112</s2>
			</r11>
			<r12>
				<s1>1121</s1>
				<s2>1122</s2>
			</r12>
			<r13>
				<s1>1131</s1>
				<s2>1132</s2>
			</r13>
			<r14>
				<s1>1141</s1>
				<s2>1142</s2>
			</r14>
			<r15>
				<s1>1151</s1>
				<s2>1152</s2>
			</r15>
			<r16>
				<s1>1161</s1>
				<s2>1162</s2>
			</r16>
			<r17>
				<s1>1171</s1>
				<s2>1172</s2>
			</r17>
			<r18>
				<s1>1181</s1>
				<s2>1182</s2>
			</r18>
			<r19>
				<s1>1191</s1>
				<s2>1192</s2>
			</r19>
			<r20>
				<s1>1201</s1>
				<s2>1202</s2>
			</r20>
			<r21>
				<s1>1211</s1>
				<s2>1212</s2>
			</r21>
			<r22>
				<s1>1221</s1>
				<s2>1222</s2>
			</r22>
			<r23>
				<s1>1231</s1>
				<s2>1232</s2>
			</r23>
			<r24>
				<s1>1241</s1>
				<s2>1242</s2>
			</r24>
			<r25>
				<s1>1251</s1>
				<s2>1252</s2>
			</r25>
			<r26>
				<s1>1261</s1>
				<s2>1262</s2>
			</r26>
			<r27>
				<s1>1271</s1>
				<s2>1272</s2>
			</r27>
			<r28>
				<s1>1281</s1>
				<s2>1282</s2>
			</r28>
			<r29>
				<s1>1291</s1>
				<s2>1292</s2>
			</r29>
			<r30>
				<s1>1301</s1>
				<s2>1302</s2>
			</r30>
			<r31>
				<s1>1311</s1>
				<s2>1312</s2>
			</r31>
			<r32>
				<s1>1321</s1>
				<s2>1322</s2>
			</r32>
			<r33>
				<s1>1331</s1>
				<s2>1332</s2>
			</r33>
			<r34>
				<s1>1341</s1>
				<s2>1342</s2>
			</r34>
			<r35>
				<s1>1351</s1>
				<s2>1352</s2>
			</r35>
			<r36>
				<s1>1361</s1>
				<s2>1362</s2>
			</r36>
			<r37>
				<s1>1371</s1>
				<s2>1372</s2>
			</r37>
			<r38>
				<s1>1381</s1>
				<s2>1382</s2>
			</r38>
			<r39>
				<s1>1391</s1>
				<s2>1392</s2>
			</r39>
			<r40>
				<s1>1401</s1>
				<s2>1402</s2>
			</r40>
			<r41>
				<s1>1411</s1>
				<s2>1412</s2>
			</r41>
			<r42>
				<s1>1421</s1>
				<s2>1422</s2>
			</r42>
			<r43>
				<s1>1431</s1>
				<s2>1432</s2>
			</r43>
			<r44>
				<s1>1441</s1>
				<s2>1442</s2>
			</r44>
			<r45>
				<s1>1451</s1>
				<s2>1452</s2>
			</r45>
		</ucMuj1Suvaha>
		<ucMuj2VykazZS>
			<r01>
				<s1>2011</s1>
				<s2>2012</s2>
			</r01>
			<r02>
				<s1>2021</s1>
				<s2>2022</s2>
			</r02>
			<r03>
				<s1>2031</s1>
				<s2>2032</s2>
			</r03>
			<r04>
				<s1>2041</s1>
				<s2>2042</s2>
			</r04>
			<r05>
				<s1>2051</s1>
				<s2>2052</s2>
			</r05>
			<r06>
				<s1>2061</s1>
				<s2>2062</s2>
			</r06>
			<r07>
				<s1>2071</s1>
				<s2>2072</s2>
			</r07>
			<r08>
				<s1>2081</s1>
				<s2>2082</s2>
			</r08>
			<r09>
				<s1>2091</s1>
				<s2>2092</s2>
			</r09>
			<r10>
				<s1>2101</s1>
				<s2>2102</s2>
			</r10>
			<r11>
				<s1>2111</s1>
				<s2>2112</s2>
			</r11>
			<r12>
				<s1>2121</s1>
				<s2>2122</s2>
			</r12>
			<r13>
				<s1>2131</s1>
				<s2>2132</s2>
			</r13>
			<r14>
				<s1>2141</s1>
				<s2>2142</s2>
			</r14>
			<r15>
				<s1>2151</s1>
				<s2>2152</s2>
			</r15>
			<r16>
				<s1>2161</s1>
				<s2>2162</s2>
			</r16>
			<r17>
				<s1>2171</s1>
				<s2>2172</s2>
			</r17>
			<r18>
				<s1>2181</s1>
				<s2>2182</s2>
			</r18>
			<r19>
				<s1>2191</s1>
				<s2>2192</s2>
			</r19>
			<r20>
				<s1>2201</s1>
				<s2>2202</s2>
			</r20>
			<r21>
				<s1>2211</s1>
				<s2>2212</s2>
			</r21>
			<r22>
				<s1>2221</s1>
				<s2>2222</s2>
			</r22>
			<r23>
				<s1>2231</s1>
				<s2>2232</s2>
			</r23>
			<r24>
				<s1>2241</s1>
				<s2>2242</s2>
			</r24>
			<r25>
				<s1>2251</s1>
				<s2>2252</s2>
			</r25>
			<r26>
				<s1>2261</s1>
				<s2>2262</s2>
			</r26>
			<r27>
				<s1>2271</s1>
				<s2>2272</s2>
			</r27>
			<r28>
				<s1>2281</s1>
				<s2>2282</s2>
			</r28>
			<r29>
				<s1>2291</s1>
				<s2>2292</s2>
			</r29>
			<r30>
				<s1>2301</s1>
				<s2>2302</s2>
			</r30>
			<r31>
				<s1>2311</s1>
				<s2>2312</s2>
			</r31>
			<r32>
				<s1>2321</s1>
				<s2>2322</s2>
			</r32>
			<r33>
				<s1>2331</s1>
				<s2>2332</s2>
			</r33>
			<r34>
				<s1>2341</s1>
				<s2>2342</s2>
			</r34>
			<r35>
				<s1>2351</s1>
				<s2>2352</s2>
			</r35>
			<r36>
				<s1>2361</s1>
				<s2>2362</s2>
			</r36>
			<r37>
				<s1>2371</s1>
				<s2>2372</s2>
			</r37>
			<r38>
				<s1>2381</s1>
				<s2>2382</s2>
			</r38>
		</ucMuj2VykazZS>
	</telo>
</dokument>
);
mzdprc;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 "; 

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

if( $j == 0 )
          {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);		
   	
  $text = "  <hlavicka>	"."\r\n"; fwrite($soubor, $text);

  $text = "  <datumK>"."\r\n";   fwrite($soubor, $text);
 

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

$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];



//uzavierka k z ufirdalsie
if( $kli_vrok >= 2013 )
          {

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  if( $riadok->datk != '0000-00-00' )
    {
  $datk_sk=SkDatum($riadok->datk);

$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];

    }
  }

          }




  $text = "    <den><![CDATA[".$den."]]></den>	"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </datumK>"."\r\n";   fwrite($soubor, $text);

  $dic=1*$fir_fdic;
  $text = "    <dic><![CDATA[".$dic."]]></dic>	"."\r\n"; fwrite($soubor, $text);

  $ico=1*$fir_fico;
  $text = "    <ico><![CDATA[".$ico."]]></ico>	"."\r\n"; fwrite($soubor, $text);

$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $text = "  <skNace>"."\r\n";   fwrite($soubor, $text);	
  $k1=$sknacea;
  $text = "    <k1><![CDATA[".$k1."]]></k1>	"."\r\n"; fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "    <k2><![CDATA[".$k2."]]></k2>	"."\r\n"; fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "    <k3><![CDATA[".$k3."]]></k3>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n";   fwrite($soubor, $text);

  $text = "  <typUzavierky>"."\r\n";   fwrite($soubor, $text);

//riadna mimoriadna 
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

  $text = "    <riadna><![CDATA[".$riadna."]]></riadna>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <mimoriadna><![CDATA[".$mimoriadna."]]></mimoriadna>	"."\r\n"; fwrite($soubor, $text);
  $zostavena=0;
if( $h_zos != '' ) $zostavena = 1;
if( trim($h_sch) != '' ) { $zostavena=0; $h_zos=""; }
  $text = "    <zostavena><![CDATA[".$zostavena."]]></zostavena>	"."\r\n"; fwrite($soubor, $text);
  $schvalena=0;
if( $h_sch != '' ) $schvalena = 1;  
  $text = "    <schvalena><![CDATA[".$schvalena."]]></schvalena>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </typUzavierky>"."\r\n";   fwrite($soubor, $text);

  $text = "  <obdobie>"."\r\n";   fwrite($soubor, $text); 
//nacitaj obdobie z priznanie_po
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $obdd1=$riadok->obdd1;
  $obdm1=$riadok->obdm1;
  $obdr1=$riadok->obdr1+2000;
  $obdd2=$riadok->obdd2;
  $obdm2=$riadok->obdm2;
  $obdr2=$riadok->obdr2+2000;
  $obmd1=$riadok->obmd1;
  $obmm1=$riadok->obmm1;
  $obmr1=$riadok->obmr1+2000;
  $obmd2=$riadok->obmd2;
  $obmm2=$riadok->obmm2;
  $obmr2=$riadok->obmr2+2000;

  }


if( $kli_vrok >= 2013 )
{

//nacitaj obdobia z ufirdalsie
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


     }
  }
}

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 == 0 OR $cobdm1 == 0 OR $cobdr1 == 0 ) { 
$obdd1="01"; $obdm1="01"; $obdr1=$kli_vrok; $obdd2="01"; $obdm2=$kli_vmes; $obdr2=$kli_vrok; 
$kli_mrok=$kli_vrok-1;
$obmd1="01"; $obmm1="01"; $obmr1=$kli_mrok; $obmd2="31"; $obmm2=12; $obmr2=$kli_mrok;
}

  $text = "  <od>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obdm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obdr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </od>"."\r\n";   fwrite($soubor, $text);

  $text = "  <do>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obdm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obdr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </do>"."\r\n";   fwrite($soubor, $text); 
  $text = "  </obdobie>"."\r\n";   fwrite($soubor, $text);

  $text = "  <bPredObdobie>"."\r\n";   fwrite($soubor, $text);
  $text = "  <od>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obmm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obmr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </od>"."\r\n";   fwrite($soubor, $text);

  $text = "  <do>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obmm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obmr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </do>"."\r\n";   fwrite($soubor, $text); 
  $text = "  </bPredObdobie>"."\r\n";   fwrite($soubor, $text);

  $text = "  <uctJednotka>"."\r\n";   fwrite($soubor, $text); 

  $text = "  <obchMeno>"."\r\n";   fwrite($soubor, $text);
  $riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);
  $riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchMeno>"."\r\n";   fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n";   fwrite($soubor, $text); 
  $ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>	"."\r\n"; fwrite($soubor, $text);
  $cislo=$fir_fcdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>	"."\r\n"; fwrite($soubor, $text);
  $psc=$fir_fpsc;
  $psc=str_replace(" ","",$psc);
  $text = "    <psc><![CDATA[".$psc."]]></psc>	"."\r\n"; fwrite($soubor, $text);
  $obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>	"."\r\n"; fwrite($soubor, $text);
  $telefon=$fir_ftel;
  $text = "    <telefon><![CDATA[".$telefon."]]></telefon>	"."\r\n"; fwrite($soubor, $text);
  $fax=$fir_ffax;
  $text = "    <fax><![CDATA[".$fax."]]></fax>	"."\r\n"; fwrite($soubor, $text);
  $email=$fir_fem1;
  $text = "    <email><![CDATA[".$email."]]></email>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n";   fwrite($soubor, $text);

  $text = "  </uctJednotka>"."\r\n";   fwrite($soubor, $text);

  $datZostavenia=$h_zos;
  $text = "    <datZostavenia><![CDATA[".$datZostavenia."]]></datZostavenia>	"."\r\n"; fwrite($soubor, $text);

  $datSchvalenia=$h_sch;
  $text = "    <datSchvalenia><![CDATA[".$datSchvalenia."]]></datSchvalenia>	"."\r\n"; fwrite($soubor, $text);
 
  $text = "  </hlavicka>"."\r\n";   fwrite($soubor, $text);
 
  $text = "  <telo>"."\r\n";   fwrite($soubor, $text);

//suvaha riadky

$sqlttps = "SELECT * FROM F$kli_vxcf"."_pos_muj2014 WHERE dok > 0 ORDER BY dok "; 
$sqlps = mysql_query("$sqlttps");
$polps = mysql_num_rows($sqlps);

$ips=0;
  while ($ips <= $polps )
  {
  if (@$zaznam=mysql_data_seek($sqlps,$ips))
{
$hlavickps=mysql_fetch_object($sqlps);

$riadok=1*$hlavickps->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickps->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickps->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickps->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickps->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickps->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickps->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickps->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickps->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickps->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickps->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickps->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickps->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickps->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickps->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickps->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickps->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickps->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickps->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickps->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickps->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickps->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickps->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickps->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickps->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickps->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickps->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickps->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickps->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickps->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickps->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickps->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickps->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickps->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickps->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickps->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickps->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickps->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickps->hod; }
if( $riadok == 39 ) { $rm39=1*$hlavickps->hod; }
if( $riadok == 40 ) { $rm40=1*$hlavickps->hod; }
if( $riadok == 41 ) { $rm41=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 43 ) { $rm43=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 45 ) { $rm45=1*$hlavickps->hod; }

}
$ips = $ips + 1;
  }

  $text = "  <ucMuj1Suvaha>"."\r\n";   fwrite($soubor, $text);


  $text = "  <r01>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r01>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r02>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r02>"."\r\n";   fwrite($soubor, $text);


  $text = "  </ucMuj1Suvaha>"."\r\n";   fwrite($soubor, $text);

          }
//koniec ak j=0



}
$i = $i + 1;
$j = $j + 1;
  }

//vykazziskov a strat


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid." WHERE prx = 1 "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavickav=mysql_fetch_object($sql);


if( $j == 0 )
          {

$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; 
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_muj2014 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
$polpv = mysql_num_rows($sqlpv);

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }

}
$ipv = $ipv + 1;
  }


  $text = "  <ucMuj2VykazZS>"."\r\n";   fwrite($soubor, $text);


  $text = "  <r01>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavickav->r01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r01>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r02>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavickav->r02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r02>"."\r\n";   fwrite($soubor, $text);


  $text = "  </ucMuj2VykazZS>"."\r\n";   fwrite($soubor, $text);





  $text = "  </telo>"."\r\n";   fwrite($soubor, $text);    

  $text = "  </dokument>"."\r\n";   fwrite($soubor, $text);
    
          }
//koniec ak j=0



}
$i = $i + 1;
$j = $j + 1;
  }



fclose($soubor);
?>



<?php
if( $elsubor == 2 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
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


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
