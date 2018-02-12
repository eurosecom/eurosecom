<HTML>
<?php

$pdfand=200;
$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }

$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//userhash
$userhash = $_REQUEST['userhash'];

require_once('../androidfanti/MCrypt.php');
$mcrypt = new MCrypt();
//#Encrypt
//$encrypted = $mcrypt->encrypt("Text to encrypt");
$encrypted=$userhash;
#Decrypt
$userxplus = $mcrypt->decrypt($encrypted);

//user
$userx=$userxplus;
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];
$cislo_dok=1*$poleu[12];

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";

$anduct=1*$_REQUEST['anduct'];
if( $anduct == 1 )
  {
//nastav databazu
$kli_vrok=1*$_REQUEST['rokx'];
$kli_vxcf=1*$_REQUEST['firx'];
$dbsed="../".$adrsxxx."/nastavdbase.php";
$sDat = include("$dbsed");
mysql_select_db($databaza);
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";
  }

if( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }


$druhid=0;
$cuid=0;
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=10;
    $cuid=1*$riaddok->cuid;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx AND ez_heslo = '$pswdxxx' ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cuid=1*$riaddok->cuid;
    $druhid=20;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."klienti WHERE id_klienta = $cuid AND all_prav > 20000 ORDER BY id_klienta DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=99;
    }

if( $druhid < 20 ) { exit; }
$kli_uzid=$cuid;
if( $kli_uzid == 0 ) { exit; }

$kli_vume=1*$_REQUEST['kli_vume'];
$kli_vduj=1*$_REQUEST['kli_vduj'];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$_REQUEST['h_dap']=$dnes;

$pdfand=1*$_REQUEST['pdfand'];

$cislo_cpid=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_archivdph WHERE druh = 1 AND ume = $kli_vume ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cislo_cpid=$riaddok->cpid;
    }
$_REQUEST['cislo_cpid']=$cislo_cpid;

  }

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }


do
{

$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];
$chyby = 1*$_REQUEST['chyby'];


if( $zandroidu == 0 )
  {
require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
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


//tlac z archivu
if( $copern == 110 )
{
$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_dap = $_REQUEST['cislo_dap'];
$h_arch=0;
$h_drp=$cislo_druh;
$h_dap=$cislo_dap;

$kli_vume=$cislo_ume;
if( $cislo_stvrt == 1 ) { $kli_vume="1.".$kli_vrok; }
if( $cislo_stvrt == 2 ) { $kli_vume="4.".$kli_vrok; }
if( $cislo_stvrt == 3 ) { $kli_vume="7.".$kli_vrok; }
if( $cislo_stvrt == 4 ) { $kli_vume="10.".$kli_vrok; }
//echo $kli_vume;
}
//koniec nastav tlac z archivu

$cislo_cpid = 1*$_REQUEST['cislo_cpid'];

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEDPH_mesiac_".$cislo_ume."_id".$idx.".xml";
if( $cislo_stvrt > 0 ) $nazsub="PRIZNANIEDPH_stvrtrok_".$cislo_stvrt."_".$kli_vrok."_id".$idx.".xml";


$copern=10;
$zarchivu=1;
$elsubor=2;


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Daò z pridanej hodnoty XML</title>
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

<td>EuroSecom  -  Priznanie DPH 2014 export do XML

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
<?xml version="1.0" encoding="utf-8"?>		
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">		
  <hlavicka>		
    <identifikacneCislo>		
      <kodStatu><![CDATA[SK]]></kodStatu>		
      <cislo><![CDATA[2020345678]]></cislo>		
    </identifikacneCislo>		
    <dic><![CDATA[2020345678]]></dic>		
    <danovyUrad><![CDATA[Senica]]></danovyUrad>		
    <nevzniklaPov><![CDATA[0]]></nevzniklaPov>		
    <typDP>		
      <rdp><![CDATA[1]]></rdp>		
      <odp><![CDATA[0]]></odp>		
      <ddp><![CDATA[0]]></ddp>		
      <datumZisteniaDdp/>		
    </typDP>		
    <osoba>		
      <platitel><![CDATA[1]]></platitel>		
      <registrovana><![CDATA[0]]></registrovana>		
      <inaPovinna><![CDATA[0]]></inaPovinna>		
      <zdanitelna><![CDATA[0]]></zdanitelna>		
      <zastupca><![CDATA[0]]></zastupca>		
    </osoba>		
    <zdanObd>		
      <mesiac><![CDATA[01]]></mesiac>		
      <stvrtrok/>		
      <rok><![CDATA[2012]]></rok>		
    </zdanObd>		
    <meno>		
      <riadok><![CDATA[GEONÄÅ¡Ã¡ s.r.o.]]></riadok>		
      <riadok/>		
      <riadok/>		
    </meno>		
    <adresa>		
      <ulica><![CDATA[DlhÃ¡]]></ulica>		
      <cislo><![CDATA[1020/50]]></cislo>		
      <psc><![CDATA[90501]]></psc>		
      <obec><![CDATA[Senica]]></obec>		
      <tel>		
        <predcislie><![CDATA[0905]]></predcislie>		
        <cislo><![CDATA[32033]]></cislo>		
      </tel>		
      <fax>		
        <predcislie><![CDATA[034]]></predcislie>		
        <cislo><![CDATA[6512228]]></cislo>		
      </fax>		
    </adresa>		
    <opravnenaOsoba>		
      <menoPriezvisko><![CDATA[Jan Polak]]></menoPriezvisko>		
      <tel>		
        <predcislie><![CDATA[0905]]></predcislie>		
        <cislo><![CDATA[665443]]></cislo>		
      </tel>		
    </opravnenaOsoba>		
    <datumVyhlasenia><![CDATA[22.02.2012]]></datumVyhlasenia>		
  </hlavicka>		
  <telo>		
    <r01/>		
    <r02/>		
    <r03><![CDATA[800.00]]></r03>		
    <r04><![CDATA[160.00]]></r04>		
    <r05/>		
    <r06/>		
    <r07><![CDATA[100.00]]></r07>		
    <r08><![CDATA[20.00]]></r08>		
    <r09/>		
    <r10/>		
    <r11/>		
    <r12/>		
    <r13/>		
    <r14/>		
    <r15/>		
    <r16/>		
    <r17/>		
    <r18/>		
    <r19><![CDATA[180.00]]></r19>		
    <r20/>		
    <r21><![CDATA[898.00]]></r21>		
    <r22/>		
    <r23><![CDATA[878.00]]></r23>		
    <r24/>		
    <r25/>		
    <r26><![CDATA[-2200.00]]></r26>		
    <r27><![CDATA[-440.00]]></r27>		
    <r28><![CDATA[440.00]]></r28>		
    <r29/>		
    <r30/>		
    <r31/>		
    <splneniePodmienok><![CDATA[0]]></splneniePodmienok>		
    <r32><![CDATA[718.00]]></r32>		
    <r33/>		
    <r34/>		
    <r35/>		
    <r36/>		
    <r37/>		
    <r38/>		
  </telo>		
</dokument>
);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdph".
" WHERE cpid = $cislo_cpid ";

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

if( $j == 0 )
          {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n";
  fwrite($soubor, $text);

  $text = "  <hlavicka>	"."\r\n";
  fwrite($soubor, $text);

  $text = "    <identifikacneCislo>"."\r\n";
  fwrite($soubor, $text);
  $text = "      <kodStatu><![CDATA[SK]]></kodStatu>"."\r\n";
  fwrite($soubor, $text);

$identcislo=$fir_fdic;
if( $kli_vrok >= 2018 )
{
$identcislo=trim(strtoupper($fir_ficd));
$identcislo=str_replace("SK","",$identcislo);
}

$identcislo=trim(strtoupper($fir_ficd));
$identcislo=str_replace("SK","",$identcislo);

  $text = "      <cislo><![CDATA[".$identcislo."]]></cislo>	"."\r\n";
  fwrite($soubor, $text);
  $text = "    </identifikacneCislo>"."\r\n";
  fwrite($soubor, $text);

//ak je platitel=1 DIC sa neuvadza
$fir_fdicx="";

  $text = "    <dic><![CDATA[".$fir_fdicx."]]></dic>	"."\r\n";
  fwrite($soubor, $text);

$fir_uctt01 = iconv("CP1250", "UTF-8", $fir_uctt01);
  $text = "    <danovyUrad><![CDATA[".$fir_uctt01."]]></danovyUrad>	"."\r\n";
  fwrite($soubor, $text);

  $nicnebolo=1;
  $riadok19=$hlavicka->r19;   $riadok20=$hlavicka->r20;  $riadok21=$hlavicka->r21;  $riadok31=$hlavicka->r31;  $riadok32=$hlavicka->r32;
  $riadok15=$hlavicka->r15;   $riadok16=$hlavicka->r16;  $riadok17=$hlavicka->r17;  
  if( $riadok19 != 0 OR $riadok20 != 0 OR $riadok21 != 0 OR $riadok31 != 0 OR $riadok32 != 0 OR $riadok15 != 0 OR $riadok16 != 0  OR $riadok17 != 0 ) $nicnebolo=0;

  $text = "    <nevzniklaPov><![CDATA[".$nicnebolo."]]></nevzniklaPov>	"."\r\n";
  fwrite($soubor, $text);


$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_archivdph WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $dadod=$riadok->dad;
  }

$riadne="0";
$datumdodat="";
if( $h_drp == 1 ) $riadne="1";
$oprav="0";
if( $h_drp == 2 ) $oprav="1";
$dodat="0";
if( $h_drp == 3 ) { $dodat="1"; $datumdodat=SKDatum($dadod); }

  $text = "    <typDP>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <rdp><![CDATA[".$riadne."]]></rdp>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <odp><![CDATA[".$oprav."]]></odp>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <ddp><![CDATA[".$dodat."]]></ddp>"."\r\n";   fwrite($soubor, $text);		
  $text = "      <datumZisteniaDdp><![CDATA[".$datumdodat."]]></datumZisteniaDdp>"."\r\n";   fwrite($soubor, $text);	
  $text = "    </typDP>"."\r\n";   fwrite($soubor, $text);		

//krizik platitel
$sqlfird = "SELECT * FROM F$kli_vxcf"."_archivdphdalsie WHERE  cpid = $cislo_cpid ";

$fir_vysledokd = mysql_query($sqlfird);
$fir_riadokd=mysql_fetch_object($fir_vysledokd);

$xplc=1*$fir_riadokd->xplc;

mysql_free_result($fir_vysledokd);

$plat1="1"; $plat2="0"; $plat3="0"; $plat4="0"; $plat5="0"; $plat6="0";
if( $xplc == 2 ) { $plat1="0"; $plat2="1"; $plat3="0"; $plat4="0"; $plat5="0"; $plat6="0"; }
if( $xplc == 3 ) { $plat1="0"; $plat2="0"; $plat3="1"; $plat4="0"; $plat5="0"; $plat6="0"; }
if( $xplc == 4 ) { $plat1="0"; $plat2="0"; $plat3="0"; $plat4="1"; $plat5="0"; $plat6="0"; }
if( $xplc == 5 ) { $plat1="0"; $plat2="0"; $plat3="0"; $plat4="0"; $plat5="1"; $plat6="0"; }
if( $xplc == 6 ) { $plat1="0"; $plat2="0"; $plat3="0"; $plat4="0"; $plat5="0"; $plat6="1"; }

  $text = "    <osoba>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <platitel><![CDATA[".$plat1."]]></platitel>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <registrovana><![CDATA[".$plat2."]]></registrovana>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <inaPovinna><![CDATA[".$plat3."]]></inaPovinna>"."\r\n";   fwrite($soubor, $text);		
  $text = "      <zdanitelna><![CDATA[".$plat4."]]></zdanitelna>"."\r\n";   fwrite($soubor, $text);	
  $text = "      <zastupca><![CDATA[".$plat5."]]></zastupca>"."\r\n";   fwrite($soubor, $text);	
  if( $kli_vrok >= 2008 )
  {
  $text = "      <zastupca69aa><![CDATA[".$plat6."]]></zastupca69aa>"."\r\n";   fwrite($soubor, $text);	
  }

  $text = "    </osoba>"."\r\n";   fwrite($soubor, $text);	



$pole = explode(".", $cislo_ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

if( $cislo_stvrt == 0 ) $cislo_stvrt="";
if( $cislo_stvrt > 0 ) $kli_vmes="";


  $text = "    <zdanObd>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <mesiac><![CDATA[".$kli_vmes."]]></mesiac>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <stvrtrok><![CDATA[".$cislo_stvrt."]]></stvrtrok>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <rok><![CDATA[".$kli_vrok."]]></rok>"."\r\n";   fwrite($soubor, $text);		
  $text = "    </zdanObd>"."\r\n";   fwrite($soubor, $text);		


$obch_meno = iconv("CP1250", "UTF-8", $fir_fnaz);

  $text = "    <meno>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <riadok><![CDATA[".$obch_meno."]]></riadok>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <riadok/>"."\r\n";   fwrite($soubor, $text);			
  $text = "      <riadok/>"."\r\n";   fwrite($soubor, $text);				
  $text = "    </meno>"."\r\n";   fwrite($soubor, $text);		
  $text = "    <adresa>"."\r\n";   fwrite($soubor, $text);			

$ulica = iconv("CP1250", "UTF-8", $fir_fuli);

  $text = "      <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n";   fwrite($soubor, $text);			

$cislo = iconv("CP1250", "UTF-8", $fir_fcdm);

  $text = "      <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n";   fwrite($soubor, $text);			

$psc=str_replace(" ","",$fir_fpsc);

  $text = "      <psc><![CDATA[".$psc."]]></psc>"."\r\n";   fwrite($soubor, $text);			

$mesto = iconv("CP1250", "UTF-8", $fir_fmes);

  $text = "      <obec><![CDATA[".$mesto."]]></obec>"."\r\n";   fwrite($soubor, $text);			

if( $kli_vrok < 2008 )
{

$pole = explode("/", $fir_ftel);
$tel_pred=$pole[0];
$tel_za=1*$pole[1];

  $text = "      <tel>"."\r\n";   fwrite($soubor, $text);				
  $text = "        <predcislie><![CDATA[".$tel_pred."]]></predcislie>"."\r\n";   fwrite($soubor, $text);				
  $text = "        <cislo><![CDATA[".$tel_za."]]></cislo>"."\r\n";   fwrite($soubor, $text);			
  $text = "      </tel>"."\r\n";   fwrite($soubor, $text);			

$pole = explode("/", $fir_ffax);
$fax_pred=$pole[0];
$fax_za=1*$pole[1];

  $text = "      <fax>"."\r\n";   fwrite($soubor, $text);				
  $text = "        <predcislie><![CDATA[".$fax_pred."]]></predcislie>"."\r\n";   fwrite($soubor, $text);				
  $text = "        <cislo><![CDATA[".$fax_za."]]></cislo>"."\r\n";   fwrite($soubor, $text);			
  $text = "      </fax>"."\r\n";   fwrite($soubor, $text);

}

if( $kli_vrok >= 2008 )
{

$telefon = iconv("CP1250", "UTF-8", $fir_ftel);
$mail = iconv("CP1250", "UTF-8", $fir_fem1);
				
  $text = "        <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n";   fwrite($soubor, $text);			
  $text = "        <email><![CDATA[".$mail."]]></email>"."\r\n";   fwrite($soubor, $text);			

}


		
  $text = "    </adresa>"."\r\n";   fwrite($soubor, $text);		

$konatel = iconv("CP1250", "UTF-8", $fir_uctt05);

  $text = "    <opravnenaOsoba>"."\r\n";   fwrite($soubor, $text);

  $text = "        <menoPriezvisko><![CDATA[".$konatel."]]></menoPriezvisko>"."\r\n";   fwrite($soubor, $text);	

if( $kli_vrok < 2008 )
{


$pole = explode("/", $fir_uctt04);
$tel_pred=$pole[0];
$tel_za=1*$pole[1];

  $text = "          <tel>"."\r\n";   fwrite($soubor, $text);
  $text = "            <predcislie><![CDATA[".$tel_pred."]]></predcislie>"."\r\n";   fwrite($soubor, $text);			
  $text = "            <cislo><![CDATA[".$tel_za."]]></cislo>"."\r\n";   fwrite($soubor, $text);		
  $text = "          </tel>"."\r\n";   fwrite($soubor, $text);

}
if( $kli_vrok >= 2008 )
{

$telefon = iconv("CP1250", "UTF-8", $fir_uctt04);
$mail = iconv("CP1250", "UTF-8", "");
				
  $text = "        <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n";   fwrite($soubor, $text);			
  $text = "        <email><![CDATA[".$mail."]]></email>"."\r\n";   fwrite($soubor, $text);			

}


  $text = "    </opravnenaOsoba>"."\r\n";   fwrite($soubor, $text);	

			
  $text = "    <datumVyhlasenia><![CDATA[".$h_dap."]]></datumVyhlasenia>"."\r\n";   fwrite($soubor, $text);			
	
  $text = "  </hlavicka>"."\r\n";   fwrite($soubor, $text);	
  $text = "  <telo>"."\r\n";   fwrite($soubor, $text);


$riadok=$hlavicka->r01;
if( $riadok == 0 ) $riadok="";
  $text = "    <r01><![CDATA[".$riadok."]]></r01>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r02;
if( $riadok == 0 ) $riadok="";
  $text = "    <r02><![CDATA[".$riadok."]]></r02>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r03;
if( $riadok == 0 ) $riadok="";
  $text = "    <r03><![CDATA[".$riadok."]]></r03>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r04;
if( $riadok == 0 ) $riadok="";
  $text = "    <r04><![CDATA[".$riadok."]]></r04>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r05;
if( $riadok == 0 ) $riadok="";
  $text = "    <r05><![CDATA[".$riadok."]]></r05>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r06;
if( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r07;
if( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r08;
if( $riadok == 0 ) $riadok="";
  $text = "    <r08><![CDATA[".$riadok."]]></r08>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r09;
if( $riadok == 0 ) $riadok="";
  $text = "    <r09><![CDATA[".$riadok."]]></r09>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r10;
if( $riadok == 0 ) $riadok="";
  $text = "    <r10><![CDATA[".$riadok."]]></r10>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r11;
if( $riadok == 0 ) $riadok="";
  $text = "    <r11><![CDATA[".$riadok."]]></r11>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r12;
if( $riadok == 0 ) $riadok="";
  $text = "    <r12><![CDATA[".$riadok."]]></r12>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r13;
if( $riadok == 0 ) $riadok="";
  $text = "    <r13><![CDATA[".$riadok."]]></r13>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r14;
if( $riadok == 0 ) $riadok="";
  $text = "    <r14><![CDATA[".$riadok."]]></r14>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r15;
if( $riadok == 0 ) $riadok="";
  $text = "    <r15><![CDATA[".$riadok."]]></r15>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r16;
if( $riadok == 0 ) $riadok="";
  $text = "    <r16><![CDATA[".$riadok."]]></r16>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r17;
if( $riadok == 0 ) $riadok="";
  $text = "    <r17><![CDATA[".$riadok."]]></r17>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r18;
if( $riadok == 0 ) $riadok="";
  $text = "    <r18><![CDATA[".$riadok."]]></r18>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r19;
if( $riadok == 0 ) $riadok="";
  $text = "    <r19><![CDATA[".$riadok."]]></r19>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r20;
if( $riadok == 0 ) $riadok="";
  $text = "    <r20><![CDATA[".$riadok."]]></r20>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r21;
if( $riadok == 0 ) $riadok="";
  $text = "    <r21><![CDATA[".$riadok."]]></r21>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r22;
if( $riadok == 0 ) $riadok="";
  $text = "    <r22><![CDATA[".$riadok."]]></r22>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r23;
if( $riadok == 0 ) $riadok="";
  $text = "    <r23><![CDATA[".$riadok."]]></r23>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r24;
if( $riadok == 0 ) $riadok="";
  $text = "    <r24><![CDATA[".$riadok."]]></r24>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r25;
if( $riadok == 0 ) $riadok="";
  $text = "    <r25><![CDATA[".$riadok."]]></r25>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r26;
if( $riadok == 0 ) $riadok="";
  $text = "    <r26><![CDATA[".$riadok."]]></r26>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r27;
if( $riadok == 0 ) $riadok="";
  $text = "    <r27><![CDATA[".$riadok."]]></r27>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r28;
if( $riadok == 0 ) $riadok="";
  $text = "    <r28><![CDATA[".$riadok."]]></r28>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r29;
if( $riadok == 0 ) $riadok="";
  $text = "    <r29><![CDATA[".$riadok."]]></r29>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r30;
if( $riadok == 0 ) $riadok="";
  $text = "    <r30><![CDATA[".$riadok."]]></r30>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r31;
if( $riadok == 0 ) $riadok="";
  $text = "    <r31><![CDATA[".$riadok."]]></r31>"."\r\n";   fwrite($soubor, $text);

$par79ods2=1*$hlavicka->par79ods2;
if( $par79ods2 != 1  ) { $par79ods2=0; }

  $text = "    <splneniePodmienok><![CDATA[".$par79ods2."]]></splneniePodmienok>"."\r\n";   fwrite($soubor, $text);


$riadok=$hlavicka->r32;
if( $riadok == 0 ) $riadok="";
  $text = "    <r32><![CDATA[".$riadok."]]></r32>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r33;
if( $riadok == 0 ) $riadok="";
  $text = "    <r33><![CDATA[".$riadok."]]></r33>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r34;
if( $riadok == 0 ) $riadok="";
  $text = "    <r34><![CDATA[".$riadok."]]></r34>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r35;
if( $riadok == 0 ) $riadok="";
  $text = "    <r35><![CDATA[".$riadok."]]></r35>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r36;
if( $riadok == 0 ) $riadok="";
  $text = "    <r36><![CDATA[".$riadok."]]></r36>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r37;
if( $riadok == 0 ) $riadok="";
  $text = "    <r37><![CDATA[".$riadok."]]></r37>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->r38;
if( $riadok == 0 ) $riadok="";
  $text = "    <r38><![CDATA[".$riadok."]]></r38>"."\r\n";   fwrite($soubor, $text);




  $text = "  </telo>	"."\r\n";
  fwrite($soubor, $text);
  $text = "  </dokument>	"."\r\n";
  fwrite($soubor, $text);

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
