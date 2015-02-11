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

$nazsub="UZAVIERKA_OZNAMENIE_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzávierka Oznamenie XML</title>
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
  <td>EuroSecom  -  Úètovná závierka oznámenie dátumu schválenia <?php echo $kli_vrok; ?> - export do XML</td>
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

);
mzdprc;


$sqltt = "SELECT * FROM F$kli_vxcf"."_uzavoznamenie WHERE oc = 0 ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql); 


$i=0;
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

  $text = "  </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "  </dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
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



//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>