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


$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="VP_UZ_".$kli_vrok."_".$idx.".xml";

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
  <td>EuroSecom - Všeobecné podanie k ÚZ <?php echo $kli_vrok; ?> - XML</td>
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
<?xml version="1.0" encoding="utf-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<secEvidencneCisloSuvisiacehoDOkumentu>
	<valEvidencneCisloSuvisiacehoDokumentu>123456</valEvidencneCisloSuvisiacehoDokumentu>
	<valECSDRok>1234</valECSDRok>
</secEvidencneCisloSuvisiacehoDOkumentu>
<secAdresovanieVP>
	<valOrganFS>DU</valOrganFS>
<secAdresatDU>
	<valDanovyUrad>200</valDanovyUrad>
</secAdresatDU>
</secAdresovanieVP>
<secOblastPodania>
	<valOblastPodania>UCT</valOblastPodania>
</secOblastPodania>
<secAgenda>
	<valAgenda>UCT_PU</valAgenda>
</secAgenda>
<secTypUJ>
	<valTypUJ>RUZ_POD</valTypUJ>
</secTypUJ>
<secUdajeUZ>
<secTypUZ>
	<valTypUZ>0</valTypUZ>
</secTypUZ>
<secZostavenaK>
	<valZostavenaK>2014-12-31</valZostavenaK>
</secZostavenaK>
<secZaObdobieOd>
	<valObdobieMesiacOd>1</valObdobieMesiacOd>
	<valObdobieRokOd>2014</valObdobieRokOd>
</secZaObdobieOd>
<secZaObdobieDo>
	<valObdobieMesiacDo>12</valObdobieMesiacDo>
	<valObdobieRokDo>2014</valObdobieRokDo>
</secZaObdobieDo>
<secPredchadzajuceObdobieOd>
	<valPredchadzajuceMesiacOd>1</valPredchadzajuceMesiacOd>
	<valPredchadzajuceRokOd>2013</valPredchadzajuceRokOd>
</secPredchadzajuceObdobieOd>
<secPredchadzajuceObdobieDo>
	<valPredchadzajuceMesiacDo>12</valPredchadzajuceMesiacDo>
	<valPredchadzajuceRokDo>2013</valPredchadzajuceRokDo>
</secPredchadzajuceObdobieDo>
<secUctovnaZavierka>
<secUctovnaZavierkaRMP>
	<valUctovnaZavierkaRmpRiadna>1</valUctovnaZavierkaRmpRiadna>
	<valUctovnaZavierkaRmpMimoriadna>0</valUctovnaZavierkaRmpMimoriadna>
	<valUctovnaZavierkaRmpPriebezna>0</valUctovnaZavierkaRmpPriebezna>
</secUctovnaZavierkaRMP>
</secUctovnaZavierka>
<secDatumVznikuUJ>
	<valDatumVznikuUJ>1995-01-02</valDatumVznikuUJ>
</secDatumVznikuUJ>
<secZostaveneDna>
	<valZostaveneDna>2015-02-13</valZostaveneDna>
</secZostaveneDna>
<secSchvalenaDna>
	<valSchvaleneDna>2015-02-13</valSchvaleneDna>
</secSchvalenaDna>
<secJazykPodania>
	<valJazykovaVerziaPodania>0</valJazykovaVerziaPodania>
</secJazykPodania>
</secUdajeUZ>
<secUctJednotka>
<secIdUctJedn>
<secIcoUJ>
	<valIcoUj>11568740</valIcoUj>
</secIcoUJ>
	<valDicUj>2023542458</valDicUj>
	<valKodSkNace>01120</valKodSkNace>
	<valObchMenoUj>Obchodné meno účtovnej jednotky</valObchMenoUj>
	<valOznaObchRegACisObchSpol>Okresný súd Trnava, T-2457</valOznaObchRegACisObchSpol>
</secIdUctJedn>
</secUctJednotka>
<secSidlo>
	<valUlica>Ulica</valUlica>
	<valCislo>12</valCislo>
	<valPsc>90901</valPsc>
	<valObec>Obec</valObec>
	<valTelefon>0342244578</valTelefon>
	<valEmail>email@email.sk</valEmail>
</secSidlo>
<secPrilohy>
<secPrilohaUJ>
	<valTypPrilohyUJ>UJ_SPA</valTypPrilohyUJ>
	<valSdUJ>SD_ESP</valSdUJ>
</secPrilohaUJ>
</secPrilohy>
<secDatumPodania>
	<valDatumPodania>2015-02-13</valDatumPodania>
</secDatumPodania>
</dokument>


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
  $text = "<secEvidencneCisloSuvisiacehoDOkumentu>"."\r\n"; fwrite($soubor, $text);
$text=$hlavicka->evci1;
  $text = " <valEvidencneCisloSuvisiacehoDokumentu><![CDATA[".$text."]]></valEvidencneCisloSuvisiacehoDokumentu>"."\r\n"; fwrite($soubor, $text);
$text=$hlavicka->evci2;
  $text = " <valECSDRok><![CDATA[".$text."]]></valECSDRok>"."\r\n"; fwrite($soubor, $text);
  $text = "</secEvidencneCisloSuvisiacehoDOkumentu>"."\r\n"; fwrite($soubor, $text);

  $text = "<secAdresovanieVP>"."\r\n"; fwrite($soubor, $text);
$organ="DU";
  $text = " <valOrganFS><![CDATA[".$organ."]]></valOrganFS>"."\r\n"; fwrite($soubor, $text);

  $text = " <secAdresatDU>"."\r\n"; fwrite($soubor, $text);
$duozn=$hlavicka->duozn;
if ( $hlavicka->duozn == 0 ) { $duozn=""; }
if ( $hlavicka->duozn == 1 ) { $duozn="600"; }
if ( $hlavicka->duozn == 2 ) { $duozn="100"; }
if ( $hlavicka->duozn == 3 ) { $duozn="800"; }
if ( $hlavicka->duozn == 4 ) { $duozn="400"; }
if ( $hlavicka->duozn == 5 ) { $duozn="700"; }
if ( $hlavicka->duozn == 6 ) { $duozn="300"; }
if ( $hlavicka->duozn == 7 ) { $duozn="200"; }
if ( $hlavicka->duozn == 8 ) { $duozn="500"; }
if ( $hlavicka->duozn == 9 ) { $duozn="900"; }
  $text = "  <valDanovyUrad><![CDATA[".$duozn."]]></valDanovyUrad>"."\r\n"; fwrite($soubor, $text);
  $text = " </secAdresatDU>"."\r\n"; fwrite($soubor, $text);
  $text = "</secAdresovanieVP>"."\r\n"; fwrite($soubor, $text);

  $text = "<secOblastPodania>"."\r\n"; fwrite($soubor, $text);
$oblast="UCT";
  $text = " <valOblastPodania><![CDATA[".$oblast."]]></valOblastPodania>"."\r\n"; fwrite($soubor, $text);
  $text = "</secOblastPodania>"."\r\n"; fwrite($soubor, $text);

  $text = "<secAgenda>"."\r\n"; fwrite($soubor, $text);
$agenda=" ";
if ( $kli_vduj == 0 ) { $agenda="UCT_PU"; }
if ( $kli_vduj == 1 ) { $agenda="UCT_PUN"; }
  $text = " <valAgenda><![CDATA[".$agenda."]]></valAgenda>"."\r\n"; fwrite($soubor, $text);
  $text = "</secAgenda>"."\r\n"; fwrite($soubor, $text);

  $text = "<secTypUJ>"."\r\n"; fwrite($soubor, $text);
$typpod=$hlavicka->typpod;
if ( $hlavicka->typpod == 0 ) { $typpod=" "; }
if ( $hlavicka->typpod == 1 ) { $typpod="RUZ_POD"; }
if ( $hlavicka->typpod == 2 ) { $typpod="RUZ_MUJ"; }
if ( $hlavicka->typpod == 3 ) { $typpod="RUZ_NUJ"; }
  $text = " <valTypUJ><![CDATA[".$typpod."]]></valTypUJ>"."\r\n"; fwrite($soubor, $text);
  $text = "</secTypUJ>"."\r\n"; fwrite($soubor, $text);

  $text = "<secUdajeUZ>"."\r\n"; fwrite($soubor, $text);
if ( $kli_vduj == 0 ) {
  $text = " <secTypUZ>"."\r\n"; fwrite($soubor, $text);
$typuz="0";
  $text = "  <valTypUZ><![CDATA[".$typuz."]]></valTypUZ>"."\r\n"; fwrite($soubor, $text);
  $text = " </secTypUZ>"."\r\n"; fwrite($soubor, $text);
                      }

  $text = " <secZostavenaK>"."\r\n"; fwrite($soubor, $text);
$datk_sk=$hlavicka->datk;
  $text = "  <valZostavenaK><![CDATA[".$datk_sk."]]></valZostavenaK>"."\r\n"; fwrite($soubor, $text);
  $text = " </secZostavenaK>"."\r\n"; fwrite($soubor, $text);

  $text = " <secZaObdobieOd>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obbod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "  <valObdobieMesiacOd><![CDATA[".$mesiac."]]></valObdobieMesiacOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  <valObdobieRokOd><![CDATA[".$rok."]]></valObdobieRokOd>"."\r\n"; fwrite($soubor, $text);
  $text = " </secZaObdobieOd>"."\r\n"; fwrite($soubor, $text);
  $text = " <secZaObdobieDo>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obbdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "  <valObdobieMesiacDo><![CDATA[".$mesiac."]]></valObdobieMesiacDo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <valObdobieRokDo><![CDATA[".$rok."]]></valObdobieRokDo>"."\r\n"; fwrite($soubor, $text);
  $text = " </secZaObdobieDo>"."\r\n"; fwrite($soubor, $text);

  $text = " <secPredchadzajuceObdobieOd>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obmod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "  <valPredchadzajuceMesiacOd><![CDATA[".$mesiac."]]></valPredchadzajuceMesiacOd>"."\r\n"; fwrite($soubor, $text);
  $text = "  <valPredchadzajuceRokOd><![CDATA[".$rok."]]></valPredchadzajuceRokOd>"."\r\n"; fwrite($soubor, $text);
  $text = " </secPredchadzajuceObdobieOd>"."\r\n"; fwrite($soubor, $text);
  $text = " <secPredchadzajuceObdobieDo>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $hlavicka->obmdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
  $text = "  <valPredchadzajuceMesiacDo><![CDATA[".$mesiac."]]></valPredchadzajuceMesiacDo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <valPredchadzajuceRokDo><![CDATA[".$rok."]]></valPredchadzajuceRokDo>"."\r\n"; fwrite($soubor, $text);
  $text = " </secPredchadzajuceObdobieDo>"."\r\n"; fwrite($soubor, $text);

  $text = " <secUctovnaZavierka>"."\r\n"; fwrite($soubor, $text);
$riadna="1"; $mimoriadna="0"; $priebezna="0";
if ( $hlavicka->typuz == 1 ) { $riadna="0"; $mimoriadna="1"; $priebezna="0"; }
if ( $hlavicka->typuz == 2 ) { $riadna="0"; $mimoriadna="0"; $priebezna="1"; }
if ( $kli_vduj == 0 )
{
  $text = "  <secUctovnaZavierkaRMP>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaRmpRiadna><![CDATA[".$riadna."]]></valUctovnaZavierkaRmpRiadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaRmpMimoriadna><![CDATA[".$mimoriadna."]]></valUctovnaZavierkaRmpMimoriadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaRmpPriebezna><![CDATA[".$priebezna."]]></valUctovnaZavierkaRmpPriebezna>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secUctovnaZavierkaRMP>"."\r\n"; fwrite($soubor, $text);
}
if ( $kli_vduj == 1 )
{
  $text = "  <secUctovnaZavierkaRM>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaRmRiadna><![CDATA[".$riadna."]]></valUctovnaZavierkaRmpRiadna>"."\r\n"; fwrite($soubor, $text);
  $text = "   <valUctovnaZavierkaRmMimoriadna><![CDATA[".$mimoriadna."]]></valUctovnaZavierkaRmpMimoriadna>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secUctovnaZavierkaRM>"."\r\n"; fwrite($soubor, $text);
}
  $text = " </secUctovnaZavierka>"."\r\n"; fwrite($soubor, $text);

  $text = " <secDatumVznikuUJ>"."\r\n"; fwrite($soubor, $text);
$datv_sk=$hlavicka->datv;
  $text = "  <valDatumVznikuUJ><![CDATA[".$datv_sk."]]></valDatumVznikuUJ>"."\r\n"; fwrite($soubor, $text);
  $text = " </secDatumVznikuUJ>"."\r\n"; fwrite($soubor, $text);

  $text = " <secZostaveneDna>"."\r\n"; fwrite($soubor, $text);
$datz_sk=$hlavicka->datz;
  $text = "  <valZostaveneDna><![CDATA[".$datz_sk."]]></valZostaveneDna>"."\r\n"; fwrite($soubor, $text);
  $text = " </secZostaveneDna>"."\r\n"; fwrite($soubor, $text);

  $text = " <secSchvalenaDna>"."\r\n"; fwrite($soubor, $text);
$dats_sk=$hlavicka->dats;
  $text = "  <valSchvaleneDna><![CDATA[".$dats_sk."]]></valSchvaleneDna>"."\r\n"; fwrite($soubor, $text);
  $text = " </secSchvalenaDna>"."\r\n"; fwrite($soubor, $text);

  $text = " <secJazykPodania>"."\r\n"; fwrite($soubor, $text);
$jazyk="0";
  $text = "  <valJazykovaVerziaPodania><![CDATA[".$jazyk."]]></valJazykovaVerziaPodania>"."\r\n"; fwrite($soubor, $text);
  $text = " </secJazykPodania>"."\r\n"; fwrite($soubor, $text);
  $text = "</secUdajeUZ>"."\r\n"; fwrite($soubor, $text);

  $text = "<secUctJednotka>"."\r\n"; fwrite($soubor, $text);
  $text = " <secIdUctJedn>"."\r\n"; fwrite($soubor, $text);

  $text = "  <secIcoUJ>"."\r\n"; fwrite($soubor, $text);
$ico=1*$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$ico; }
  $text = "   <valIcoUj><![CDATA[".$ico."]]></valIcoUj>"."\r\n"; fwrite($soubor, $text);
  $text = "  </secIcoUJ>"."\r\n"; fwrite($soubor, $text);
$dic=1*$fir_fdic;
  $text = "  <valDicUj><![CDATA[".$dic."]]></valDicUj>"."\r\n"; fwrite($soubor, $text);
$sknace=$fir_sknace;
$sknace=str_replace(".","",$sknace); $sknace=str_replace(" ","",$sknace);
  $text = "  <valKodSkNace><![CDATA[".$sknace."]]></valKodSkNace>"."\r\n"; fwrite($soubor, $text);
$obchodneMeno = iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "  <valObchMenoUj><![CDATA[".$obchodneMeno."]]></valObchMenoUj>"."\r\n"; fwrite($soubor, $text);
$register = iconv("CP1250", "UTF-8", $fir_obreg);
  $text = "  <valOznaObchRegACisObchSpol><![CDATA[".$register."]]></valOznaObchRegACisObchSpol>"."\r\n"; fwrite($soubor, $text);
  $text = " </secIdUctJedn>"."\r\n"; fwrite($soubor, $text);
  $text = "</secUctJednotka>"."\r\n"; fwrite($soubor, $text);

  $text = "<secSidlo>"."\r\n"; fwrite($soubor, $text);
$ulica= iconv("CP1250", "UTF-8", $fir_fuli);
  $text = " <valUlica><![CDATA[".$ulica."]]></valUlica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = " <valCislo><![CDATA[".$cislo."]]></valCislo>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = " <valPsc><![CDATA[".$psc."]]></valPsc>"."\r\n"; fwrite($soubor, $text);
$obec = iconv("CP1250", "UTF-8", $fir_fmes);
  $text = " <valObec><![CDATA[".$obec."]]></valObec>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
$telefon=str_replace("/","",$telefon); $telefon=str_replace(" ","",$telefon);
  $text = " <valTelefon><![CDATA[".$telefon."]]></valTelefon>"."\r\n"; fwrite($soubor, $text);
$email=iconv("CP1250", "UTF-8", $fir_fem1);
  $text = " <valEmail><![CDATA[".$email."]]></valEmail>"."\r\n"; fwrite($soubor, $text);
  $text = "</secSidlo>"."\r\n"; fwrite($soubor, $text);

  $text = "<secPrilohy>"."\r\n"; fwrite($soubor, $text);
  $text = " <secPrilohaUJ>"."\r\n"; fwrite($soubor, $text);
$typpod=$hlavicka->typpod;
if ( $hlavicka->typdok == 0 ) { $typdok=" "; }
if ( $hlavicka->typdok == 1 ) { $typdok="UJ_SPA"; }
if ( $hlavicka->typdok == 2 ) { $typdok="UJ_VSP"; }
if ( $hlavicka->typdok == 3 ) { $typdok="UJ_FSE"; }
  $text = "  <valTypPrilohyUJ><![CDATA[".$typdok."]]></valTypPrilohyUJ>"."\r\n"; fwrite($soubor, $text);
$spopod="SD_ESP";
  $text = "  <valSdUJ><![CDATA[".$spopod."]]></valSdUJ>"."\r\n"; fwrite($soubor, $text);
  $text = " </secPrilohaUJ>"."\r\n"; fwrite($soubor, $text);
  $text = "</secPrilohy>"."\r\n"; fwrite($soubor, $text);

  $text = "<secDatumPodania>"."\r\n"; fwrite($soubor, $text);
$datp_sk=$hlavicka->datp;
  $text = " <valDatumPodania><![CDATA[".$datp_sk."]]></valDatumPodania>"."\r\n"; fwrite($soubor, $text);
  $text = "</secDatumPodania>"."\r\n"; fwrite($soubor, $text);

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
Stiahnite si nižšie uvedený súbor xml na Váš lokálny disk a načítajte na www.financnasprava.sk alebo do aplikácie eDane:
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