<HTML>
<?php
//XML pre OZNAMENIE ZRD 2015
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
alert ("Hlásenie bude pripravené v priebehu februára 2015. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="OZNAMENIE_stvrtrok_".$zaobdobie."_".$kli_vrok."_".$idx.".xml";
$cislo_oc=1;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>EuroSecom - OZNAMENIE xml</title>
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
  <td>EuroSecom - Oznámenie o dani z nepeòažného plnenia ... - export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
 </tr>
 </table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU elsubor=1,2
if ( $copern == 110 )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");

//verzia 2015
$sqlt = <<<mzdprc
(

);
mzdprc;


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
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n";   fwrite($soubor, $text);

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = "  <dic><![CDATA[".$fir_fdic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$fir_uctt01 = iconv("CP1250", "UTF-8", $fir_uctt01);
  $text = "  <danovyUrad><![CDATA[".$fir_uctt01."]]></danovyUrad>"."\r\n"; fwrite($soubor, $text);

  $text = "  <druhHlasenia>"."\r\n"; fwrite($soubor, $text);
$riadne="1"; $opravne="0"; $dodatocne="0";
if ( $hlavicka->mz12 == 2 ) { $riadne="0"; $opravne="1"; $dodatocne="0"; }
if ( $hlavicka->mz12 == 3 ) { $riadne="0"; $opravne="0"; $dodatocne="1"; }
  $text = "   <rh><![CDATA[".$riadne."]]></rh>"."\r\n"; fwrite($soubor, $text);
  $text = "   <oh><![CDATA[".$opravne."]]></oh>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dh><![CDATA[".$dodatocne."]]></dh>"."\r\n"; fwrite($soubor, $text);
  $text = "  </druhHlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
  $text = "   <rok><![CDATA[".$kli_vrok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$dat_ddp="";
if ( $dodatocne == 1 ) $dat_ddp=SkDatum($hlavicka->r01bd);
if ( $dat_ddp == '00.00.0000' ) $dat_ddp="";
  $text = "   <datumDDP><![CDATA[".$dat_ddp."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);


  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);



     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec prvej strany

  $text = "  <drzitelia>"."\r\n"; fwrite($soubor, $text);

//vytlac drzitelov
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;


  while ($i < $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $stlpec < 3 )
{
$hlavicka=mysql_fetch_object($sql);

  $text = "  <drzitel>"."\r\n"; fwrite($soubor, $text);

$xdic = iconv("CP1250", "UTF-8", $hlavicka->xdic);
  $text = "  <xdic><![CDATA[".$xdic."]]></xdic>"."\r\n"; fwrite($soubor, $text);

  $text = "  </drzitel>"."\r\n"; fwrite($soubor, $text);
}


$i = $i + 1;

  }
//koniec drzitelov

  $text = "  </drzitelia>"."\r\n"; fwrite($soubor, $text);
  $text = "  </dokument>"."\r\n"; fwrite($soubor, $text);
fclose($soubor);
?>

<?php if ( $copern == 110 ) { ?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane:
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
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