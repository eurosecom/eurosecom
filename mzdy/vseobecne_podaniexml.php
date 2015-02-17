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

$nazsub="VSEOBECNE_PODANIE_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Všeobecné podanie XML</title>
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
  <td>EuroSecom - Všeobecné podanie <?php echo $kli_vrok; ?> - XML</td>
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

$sqltt = "SELECT * FROM F$kli_vxcf"."_vseobpodanie WHERE oc = 0 ";
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
  $text = " <secUdajeUZ>"."\r\n"; fwrite($soubor, $text);
$datk_sk=$hlavicka->datk;
//$datk_sk=SkDatum($hlavicka->datk);
  $text = "  <valZostavenaK><![CDATA[".$datk_sk."]]></valZostavenaK>"."\r\n"; fwrite($soubor, $text);

  $text = "  <secZaObdobieOd>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obbod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "   <valObdobieMesiacOd><![CDATA[".$mesiac."]]></valObdobieMesiacOd>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valObdobieRokOd><![CDATA[".$rok."]]></valObdobieRokOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secZaObdobieOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  <secZaObdobieDo>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obbdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "   <valObdobieMesiacDo><![CDATA[".$mesiac."]]></valObdobieMesiacDo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valObdobieRokDo><![CDATA[".$rok."]]></valObdobieRokDo>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secZaObdobieDo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <secPredchadzajuceObdobieOd>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obmod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "   <valPredchadzajuceMesiacOd><![CDATA[".$mesiac."]]></valPredchadzajuceMesiacOd>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valPredchadzajuceRokOd><![CDATA[".$rok."]]></valPredchadzajuceRokOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secPredchadzajuceObdobieOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  <secPredchadzajuceObdobieDo>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obmdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "   <valPredchadzajuceMesiacDo><![CDATA[".$mesiac."]]></valPredchadzajuceMesiacDo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valPredchadzajuceRokDo><![CDATA[".$rok."]]></valPredchadzajuceRokDo>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secPredchadzajuceObdobieDo>"."\r\n"; fwrite($soubor, $text);

$datz_sk=$hlavicka->datz;
//$datz_sk=SkDatum($hlavicka->datz);
  $text = "  <valZostavenaDna><![CDATA[".$datz_sk."]]></valZostavenaDna>"."\r\n"; fwrite($soubor, $text);
$dats_sk=$hlavicka->dats;
//$dats_sk=SkDatum($hlavicka->dats);
  $text = "  <valSchvalenaDna><![CDATA[".$dats_sk."]]></valSchvalenaDna>"."\r\n"; fwrite($soubor, $text);

  $text = "  <secUctovnaZavierka>"."\r\n"; fwrite($soubor, $text);
$typuz="0";
  $text = "   <valTypUctovnejZavierky><![CDATA[".$typuz."]]></valTypUctovnejZavierky>"."\r\n"; fwrite($soubor, $text);
$riadna="1"; $mimoriadna="0";
if ( $hlavicka->druhuz == 1 ) { $riadna="0"; $mimoriadna="1"; }
  $text = "   <valUctovnaZavierkaRiadna><![CDATA[".$riadna."]]></valUctovnaZavierkaRiadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaMimoriadna><![CDATA[".$mimoriadna."]]></valUctovnaZavierkaMimoriadna>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secUctovnaZavierka>"."\r\n"; fwrite($soubor, $text);

  $text = " </secUdajeUZ>"."\r\n"; fwrite($soubor, $text);
  $text = " <secUctJednotka>"."\r\n"; fwrite($soubor, $text);
$typuj="RUZ_POD";
if ( $hlavicka->druhuj == 1 ) { $typuj="RUZ_MUJ"; }
if ( $hlavicka->druhuj == 2 ) { $typuj="RUZ_NO"; }
if ( $hlavicka->druhuj == 3 ) { $typuj="RUZ_NUJ"; }
  $text = "  <valTypUJ><![CDATA[".$typuj."]]></valTypUJ>"."\r\n"; fwrite($soubor, $text);

  $text = "  <secIdUctJedn>"."\r\n"; fwrite($soubor, $text);
$text="";
  $text = "   <valLeiUJ><![CDATA[".$text."]]></valLeiUJ>"."\r\n"; fwrite($soubor, $text);
$dic=1*$fir_fdic;
  $text = "   <valDicUJ><![CDATA[".$dic."]]></valDicUJ>"."\r\n"; fwrite($soubor, $text);
$ico=1*$fir_fico;
if ( $fir_fico < 1000000 ) {$ico="00".$ico;}
  $text = "   <valIcoUJ><![CDATA[".$ico."]]></valIcoUJ>"."\r\n"; fwrite($soubor, $text);
$sid="";
  $text = "   <valSidUJ><![CDATA[".$sid."]]></valSidUJ>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno = iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <valObchMenoNazovUJ><![CDATA[".$obchodneMeno."]]></valObchMenoNazovUJ>"."\r\n"; fwrite($soubor, $text);
$text="";
  $text = "   <valNazovSpravFondu_NazovSpravcSpol><![CDATA[".$text."]]></valNazovSpravFondu_NazovSpravcSpol>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secIdUctJedn>"."\r\n"; fwrite($soubor, $text);

  $text = "  <secSidlo>"."\r\n"; fwrite($soubor, $text);
$ulica= iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "   <valUlica><![CDATA[".$ulica."]]></valUlica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "   <valCislo><![CDATA[".$cislo."]]></valCislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = "   <valPsc><![CDATA[".$psc."]]></valPsc>"."\r\n"; fwrite($soubor, $text);
$obec = iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <valObec><![CDATA[".$obec."]]></valObec>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
$telefon=str_replace("/","",$telefon); $telefon=str_replace(" ","",$telefon);
  $text = "   <valTelefon><![CDATA[".$telefon."]]></valTelefon>"."\r\n"; fwrite($soubor, $text);
$fax=$fir_ffax;
$fax=str_replace("/","",$fax); $fax=str_replace(" ","",$fax);
  $text = "   <valFax><![CDATA[".$fax."]]></valFax>"."\r\n"; fwrite($soubor, $text);
$email=iconv("CP1250", "UTF-8", $fir_fem1);
  $text = "   <valEmail><![CDATA[".$email."]]></valEmail>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secSidlo>"."\r\n"; fwrite($soubor, $text);
  $text = " </secUctJednotka>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
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
Stiahnite si nižšie uvedený súbor xml na Váš lokálny disk a naèítajte na www.financnasprava.sk alebo do aplikácie eDane:
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