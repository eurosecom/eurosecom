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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="UZAVIERKA_JU_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzávierka JU XML</title>
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
 <table class="h2" width="100%" >
 <tr>
  <td>EuroSecom  -  Úètovná závierka JU <?php echo $kli_vrok; ?> - export do XML</td>
  <td align="right">
   <span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span>
  </td>
 </tr>
 </table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");

//rok 2014
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<datumK>
			<den>20</den>
			<mesiac>12</mesiac>
			<rok>2013</rok>
		</datumK>
		<dic>0123456789</dic>
		<ico>12345678</ico>
		<skNace>
			<k1>12</k1>
			<k2>34</k2>
			<k3>5</k3>
		</skNace> 
		<uctovnaZavierka>
			<riadna>0</riadna>
			<mimoriadna>1</mimoriadna>
			<priebezna>0</priebezna>
		</uctovnaZavierka>
		<zaObdobie>
			<od>
				<mesiac>01</mesiac>
				<rok>2014</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2014</rok>
			</do>
		</zaObdobie>
		<bPredObdobie>
			<od>
				<mesiac>01</mesiac>
				<rok>2013</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2013</rok>
			</do>
		</bPredObdobie>
		<nazovUJ>
			<riadok>prvý riadok názvu úètovnej jednotky</riadok>
			<riadok>a druhý riadok</riadok>
		</nazovUJ>
		<miestoPodnikania>
			<ulica>Poulièná</ulica>
			<cislo>128</cislo>
			<psc>11111</psc>
			<obec>Košice</obec>
			<telefon>0901123456</telefon>
			<email>e-mail@uctovnaJednotka.sk</email>
		</miestoPodnikania>
		<zostaveneDna>01.01.2015</zostaveneDna>
	</hlavicka>
	<telo>
		<ucFo1>	
			<r01>1</r01>
			<r02>2</r02>
			<r03>3</r03>
			<r04>4</r04>
			<r05>5</r05>
			<r06>6</r06>
			<r07>7</r07>
			<r08>8</r08>
			<r09>9</r09>
			<r10>10</r10>
			<r11>11</r11>
			<r12>12</r12>
		</ucFo1>
		<ucFo2>		
			<r01>
				<s1>125</s1>
				<s2>2</s2>
			</r01>
			<r02>
				<s1>555</s1>
				<s2>15</s2>
			</r02>
			<r03>
				<s1>0</s1>
				<s2>0</s2>
			</r03>
			<r04>
				<s1>555</s1>
				<s2></s2>
			</r04>
			<r05>
				<s1>789</s1>
				<s2>8767856</s2>
			</r05>
			<r06>
				<s1>87</s1>
				<s2>8888</s2>
			</r06>
			<r07>
				<s1>7</s1>
				<s2>77</s2>
			</r07>
			<r08>
				<s1>222</s1>
				<s2>65</s2>
			</r08>
			<r09>
				<s1>999</s1>
				<s2>7</s2>
			</r09>
			<r10>
				<s1>20</s1>
				<s2>2</s2>
			</r10>
			<r11>
				<s1>3</s1>
				<s2>111</s2>
			</r11>
			<r12>
				<s1>70</s1>
				<s2>122</s2>
			</r12>
			<r13>
				<s1>77</s1>
				<s2>9999</s2>
			</r13>
			<r14>
				<s1>654</s1>
				<s2>55</s2>
			</r14>
			<r15>
				<s1>20</s1>
				<s2>22</s2>
			</r15>
			<r16>
				<s1>11</s1>
				<s2>22</s2>
			</r16>
			<r17>
				<s1>999</s1>
				<s2>10000</s2>
			</r17>
			<r18>
				<s1>100</s1>
				<s2>10</s2>
			</r18>
			<r19>
				<s1>1000</s1>
				<s2>2000</s2>
			</r19>
			<r20>
				<s1>50</s1>
				<s2>60</s2>
			</r20>
			<r21>
				<s1>40</s1>
				<s2>30</s2>
			</r21>
		</ucFo2>
	</telo>
</dokument>
);
mzdprc;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvprivyds".$kli_uzid." WHERE prx = 1 ";
//echo $sqltt;
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
if ( $kli_vrok >= 2013 )
     {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  if ( $riadok->datk != '0000-00-00' ) {
  $datk_sk=SkDatum($riadok->datk);

$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
                                       }
  }
     }
  $text = "   <den><![CDATA[".$den."]]></den>"."\r\n"; fwrite($soubor, $text);
  $text = "   <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </datumK>"."\r\n"; fwrite($soubor, $text);

$dic=1*$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$ico=1*$fir_fico;
if( $fir_fico < 1000000 ) {$ico="00".$ico;}
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

  $text = "  <uctovnaZavierka>"."\r\n"; fwrite($soubor, $text);
//dopyt, nefunguje
$riadna=1;
$mimoriadna=0;
$priebezna=0;
if ( $h_drp == 1 ) { $riadna="1"; $mimoriadna=0; $priebezna=0; }
if ( $h_drp == 2 ) { $riadna="0"; $mimoriadna=1; $priebezna=0; }
if ( $h_drp == 3 ) { $riadna="0"; $mimoriadna=0; $priebezna=1; }
  $text = "   <riadna><![CDATA[".$riadna."]]></riadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <mimoriadna><![CDATA[".$mimoriadna."]]></mimoriadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <priebezna><![CDATA[".$priebezna."]]></priebezna>"."\r\n"; fwrite($soubor, $text);
  $text = "  </uctovnaZavierka>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zaObdobie>"."\r\n"; fwrite($soubor, $text);
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

if ( $kli_vrok >= 2013 )
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
if ( $cobdd1 == 0 OR $cobdm1 == 0 OR $cobdr1 == 0 ) {
$obdd1="01"; $obdm1="01"; $obdr1=$kli_vrok; $obdd2="01"; $obdm2=$kli_vmes; $obdr2=$kli_vrok; 
$kli_mrok=$kli_vrok-1;
$obmd1="01"; $obmm1="01"; $obmr1=$kli_mrok; $obmd2="31"; $obmm2=12; $obmr2=$kli_mrok;
                                                    }
  $text = "   <od>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obdm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
$rok=$obdr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </od>"."\r\n"; fwrite($soubor, $text);
  $text = "   <do>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obdm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
$rok=$obdr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </do>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zaObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <bPredObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <od>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obmm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
$rok=$obmr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </od>"."\r\n"; fwrite($soubor, $text);
  $text = "   <do>"."\r\n"; fwrite($soubor, $text);
$mesiac=$obmm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>"."\r\n"; fwrite($soubor, $text);
$rok=$obmr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </do>"."\r\n"; fwrite($soubor, $text);
  $text = "  </bPredObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <nazovUJ>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "   <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </nazovUJ>"."\r\n"; fwrite($soubor, $text);

  $text = "  <miestoPodnikania>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
$psc=str_replace(" ","",$psc);
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
$telefon=str_replace("/","",$telefon);
$telefon=str_replace(" ","",$telefon);
  $text = "   <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n"; fwrite($soubor, $text);
$email=$fir_fem1;
  $text = "   <email><![CDATA[".$email."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </miestoPodnikania>"."\r\n"; fwrite($soubor, $text);

$datZostavenia=$h_zos;
  $text = "  <zostaveneDna><![CDATA[".$datZostavenia."]]></zostaveneDna>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);
 
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);
//prijmy-vydavky riadky
  $text = "  <ucFo1>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r01;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r01><![CDATA[".$riadok."]]></r01>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r02;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r02><![CDATA[".$riadok."]]></r02>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r03;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r03><![CDATA[".$riadok."]]></r03>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r04;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r04><![CDATA[".$riadok."]]></r04>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r05;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r05><![CDATA[".$riadok."]]></r05>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r06;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r07;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r08;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r08><![CDATA[".$riadok."]]></r08>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r09;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r09><![CDATA[".$riadok."]]></r09>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r10><![CDATA[".$riadok."]]></r10>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r11><![CDATA[".$riadok."]]></r11>"."\r\n"; fwrite($soubor, $text);

$riadok=1*$hlavicka->r12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <r12><![CDATA[".$riadok."]]></r12>"."\r\n"; fwrite($soubor, $text);
  $text = "  </ucFo1>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
//majetok-zavazky riadky

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." WHERE prx = 1 ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavickav=mysql_fetch_object($sql);

if ( $j == 0 )
     {
$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10="";
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; 

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_uctpocmajzav WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
if ($sqlpv) { $polpv = mysql_num_rows($sqlpv); }

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;
if ( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
}
$ipv = $ipv + 1;
  }
  $text = "  <ucFo2>"."\r\n"; fwrite($soubor, $text);
  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r01;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r02>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r02;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r03>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r03;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r04>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r04;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r05>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r05;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r05>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r06>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r06;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r06>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r07>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r07;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r07>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r08>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r08;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r08>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r09>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r09;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r09>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r10>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r11>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r12>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r13>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r13>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r14>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r14>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r15>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r15>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r16>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm16;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r16;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r16>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r17>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r17>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r18>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm18;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r18;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r18>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r19>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm19;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r19;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r19>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r20>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm20;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r20;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r20>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r21>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$rm21;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=1*$hlavickav->r21;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r21>"."\r\n"; fwrite($soubor, $text);
  $text = "  </ucFo2>"."\r\n"; fwrite($soubor, $text);

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

<?php
if ( $elsubor == 2 )
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


//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>