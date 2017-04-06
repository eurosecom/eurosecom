<HTML>
<?php
$sys = 'MZD';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>ätatistika a v˝kaznÌctvo</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;



function VyberVstup()
                {
<?php  echo "document.forms.formz1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formz1.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formkk1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formkk1.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formkf1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formkf1.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formnd1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formnd1.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formbr1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formbr1.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formcc1.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formcc1.h_obdk.value=$kli_vmes; "; ?>
                }


function SuborTrexima()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;

window.open('../mzdy/trexima.php?cislo_oc=' + h_oc + '&copern=12&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function PDFTrexima()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;

window.open('../mzdy/trexima.php?cislo_oc=' + h_oc + '&copern=13&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UdajeFirma()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;

window.open('../mzdy/trexima.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UdajeZamestnanci()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;

window.open('../mzdy/trexima.php?cislo_oc=' + h_oc + '&copern=101&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php
$rokpraca204="";
if( $kli_vrok < 2017 ) $rokpraca204="_2016";
if( $kli_vrok < 2016 ) $rokpraca204="_2015";
if( $kli_vrok < 2014 ) $rokpraca204="_2013";
if( $kli_vrok < 2012 ) $rokpraca204="_2011";

?>

function TlacPraca204()
                {
window.open('../mzdy/stat_praca204<?php echo $rokpraca204; ?>.php?copern=101&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function StatPomerPDF()
                {
var h_obdp = document.forms.formkf1.h_obdp.value;
var h_obdk = document.forms.formkf1.h_obdk.value;
var h_doh = document.forms.formkf1.h_doh.value;

window.open('../mzdy/stat_pomer.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_doh=' + h_doh + '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function NadcasyPDF()
                {
var h_obdp = document.forms.formnd1.h_obdp.value;
var h_obdk = document.forms.formnd1.h_obdk.value;

window.open('../mzdy/stat_nadcasy.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function StatKatPDF()
                {
var h_obdp = document.forms.formkk1.h_obdp.value;
var h_obdk = document.forms.formkk1.h_obdk.value;
var h_doh = document.forms.formkk1.h_doh.value;

window.open('../mzdy/stat_kat.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_doh=' + h_doh + '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function TlacZostZak()
                {
var h_zak = document.forms.formz1.h_zak.value;
var h_obdp = document.forms.formz1.h_obdp.value;
var h_obdk = document.forms.formz1.h_obdk.value;

window.open('../mzdy/mzdy_zakazky.php?cislo_zak=' + h_zak + '&copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=3&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacBrutto()
                {

var h_obdp = document.forms.formbr1.h_obdp.value;
var h_obdk = document.forms.formbr1.h_obdk.value;

window.open('../mzdy/brutto.php?copern=2&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacCelkoCena()
                {

var h_obdp = document.forms.formcc1.h_obdp.value;
var h_obdk = document.forms.formcc1.h_obdk.value;

window.open('../mzdy/hrubamzda.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacCelkoCena2()
                {

var h_obdp = document.forms.formcc1.h_obdp.value;
var h_obdk = document.forms.formcc1.h_obdk.value;

window.open('../mzdy/hrubamzda_v2.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//trexima platy vykaz


function SuborTrexima2()
                {
var h_oc = document.forms.formpx2.h_oc.value;

window.open('../mzdy/trexima_platy.php?cislo_oc=' + h_oc + '&copern=12&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UdajeFirma2()
                {
var h_oc = document.forms.formpx2.h_oc.value;

window.open('../mzdy/trexima.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UdajeZamestnanci2()
                {
var h_oc = document.forms.formpx2.h_oc.value;

window.open('../mzdy/trexima_platy.php?cislo_oc=' + h_oc + '&copern=101&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function StatPomerCSV()
                {
var h_obdp = document.forms.formkf1.h_obdp.value;
var h_obdk = document.forms.formkf1.h_obdk.value;
var h_doh = document.forms.formkf1.h_doh.value;

window.open('../mzdy/stat_pomer.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_doh=' + h_doh + '&copern=1&drupoh=1&page=1&typ=PDF&csv=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function TlacCelkoCenaCSV()
                {

var h_obdp = document.forms.formcc1.h_obdp.value;
var h_obdk = document.forms.formcc1.h_obdk.value;

window.open('../mzdy/hrubamzda.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&csv=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacCelkoCena2CSV()
                {

var h_obdp = document.forms.formcc1.h_obdp.value;
var h_obdk = document.forms.formcc1.h_obdk.value;

window.open('../mzdy/hrubamzda_v2.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&csv=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacKontoPrc()
                {

var h_obdp = 1;
var h_obdk = document.forms.formkprc1.h_obdk.value;

window.open('../mzdy/konto_prac.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&csv=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php
$rokunp101="";
if( $kli_vrok < 2016 ) $rokunp101="_2015";
if( $kli_vrok < 2015 ) $rokunp101="_2014";
if( $kli_vrok < 2014 ) $rokunp101="_2013";
if( $kli_vrok < 2012 ) $rokunp101="_2011";
?>

function statistikaunp101()
                {
window.open('../mzdy/stat_unp101<?php echo $rokunp101; ?>.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" onload="VyberVstup();">

<?php 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoa'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?>





<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Mzdy a Personalistika - ätatistika a v˝kaznÌctvo</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SuborTrexima();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvoriù s˙bor pre TEXIMU vo form·te XML' ></a>
</td>
<td class="bmenu" width="98%">ätvrùroËn˝ v˝kaz o cene pr·ce ISCP (MPSVR SR) 1-04 tzv. TREXIMA 

<select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>

<a href="#" onClick="PDFTrexima();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytvoriù zostavu PDF TEXIMA' ></a>

<?php
//////////////////////////////nacitaj cislo firmy mzdy
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzducty WHERE ucty = 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cfuct=1*$riaddok->cfuct;
  if( $cfuct == 0 ) $cfuct=$kli_vxcf;
  }
?>

 Mzdy ËÌslo firmy <input type="text" name="h_fmzdy" id="h_fmzdy" maxlenght="10" size="8" value="<?php echo $cfuct;?>" />
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UdajeFirma();">
<img src='../obr/firmy.png' width=20 height=15 border=0 title='DoplÚuj˙ce ˙daje o firme' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UdajeZamestnanci();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='DoplÚuj˙ce ˙daje o zamestnancoch' ></a>
</td>
</tr>
</FORM>
</table>



<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPraca204();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">ätvrùroËn˝ v˝kaz o pr·ci PR¡CA 2-04
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statistikaunp101();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytorenie ötatistickÈho v˝kazu RoË 1-01" ></a>
</td>
<td class="bmenu" width="90%">RoËn˝ v˝kaz o ˙pln˝ch n·kladoch pr·ce UNP 1-01 </td>
</tr>
</table>


<table class="vstup" width="100%" >
<FORM name="formpx2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SuborTrexima2();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvoriù s˙bor pre TEXIMU vo form·te XML' ></a>
</td>
<td class="bmenu" width="98%">PolroËn˝ v˝kaz PLATY (MPSVR SR) 1-02  

<select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.polrok</option>
<option value="2" >2.polrok</option>
</select>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UdajeFirma2();">
<img src='../obr/firmy.png' width=20 height=15 border=0 title='DoplÚuj˙ce ˙daje o firme' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UdajeZamestnanci2();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='DoplÚuj˙ce ˙daje o zamestnancoch' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formkf1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="StatPomerPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>

<td class="bmenu" width="28%">ätatistick· zostava podæa pomerov
</td>
<td class="bmenu" width="68%"> 
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_doh" id="h_doh" >
<option value="0" >dohody nie</option>
<option value="1" >dohody ·no</option>
</select>

</td>

<td class="bmenu" width="2%">
<a href="#" onClick="StatPomerCSV();;">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formkk1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="StatKatPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>

<td class="bmenu" width="28%">ätatistick· zostava podæa kategÛriÌ
</td>
<td class="bmenu" width="70%"> 
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_doh" id="h_doh" >
<option value="0" >dohody nie</option>
<option value="1" >dohody ·no</option>
</select>

</td>
</tr>
</FORM>
</table>



<table class="vstup" width="100%" >
<FORM name="formnd1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="NadcasyPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>

<td class="bmenu" width="28%">Vyhodnotenie nadËasov˝ch hodÌn
</td>
<td class="bmenu" width="70%">  
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacZostZak();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù mzdy na vybran˙ z·kazku a obdobie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="28%">Mzdy na z·kazke za vybranÈ obdobie

</td>

<td class="bmenu" width="70%">
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

 <input type="text" name="h_zak" id="h_zak" maxlenght="20" size="20" value="0" /> Vybran· z·kazka 0=vöetky


</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formbr1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacBrutto();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù zostavu za obdobie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="28%">Prehæad BRUTTO miezd a zr·ûok za vybranÈ obdobie

</td>

<td class="bmenu" width="70%">
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>




</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formcc1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacCelkoCena();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù zostavu za obdobie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="28%">Prehæad hrubej mzdy a celkovej ceny pr·ce

<a href="#" onClick="TlacCelkoCena2();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù zostavu verzia 2 za obdobie vo form·te PDF' ></a>

</td>

<td class="bmenu" width="66%">
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>
</td>


<td class="bmenu" width="2%">
<a href="#" onClick="TlacCelkoCenaCSV()">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacCelkoCena2CSV()">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy verzia 2 do CSV' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formkprc1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacKontoPrc();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù zostavu za obdobie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="28%">Konto pracovnÈho Ëasu

</td>

<td class="bmenu" width="68%">


<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>
</td>

<td class="bmenu" width="2%">

</td>
</tr>
</FORM>
</table>



<br /><br />
<?php
// celkovy koniec dokumentu

$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
