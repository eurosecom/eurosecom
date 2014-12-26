<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Z˙Ëtovanie ZP</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

//potvrdenie
function TlacPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_zp.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_zp.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_zp.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//ziadost
function TlacZiadost()
                {
var h_oc = document.forms.formz1.h_oc.value;

window.open('../mzdy/ziadost_zp.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravZiadost()
                {
var h_oc = document.forms.formz1.h_oc.value;

window.open('../mzdy/ziadost_zp.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuZiadost()
                {
var h_oc = document.forms.formz1.h_oc.value;

window.open('../mzdy/ziadost_zp.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//RZA
function TlacRZA()
                {
var h_oc = document.forms.formrza1.h_oc.value;

window.open('../mzdy/rocne_zpa.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRZA()
                {
var h_oc = document.forms.formrza1.h_oc.value;

window.open('../mzdy/rocne_zpa.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRZA()
                {
var h_oc = document.forms.formrza1.h_oc.value;

window.open('../mzdy/rocne_zpa.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//RZS
function TlacRZS()
                {
var h_oc = document.forms.formrzs1.h_oc.value;

window.open('../mzdy/rocne_zps.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRZS()
                {
var h_oc = document.forms.formrzs1.h_oc.value;

window.open('../mzdy/rocne_zps.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRZS()
                {
var h_oc = document.forms.formrzs1.h_oc.value;

window.open('../mzdy/rocne_zps.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//List SA
function TlacLA()
                {
var h_oc = document.forms.formla1.h_oc.value;

window.open('../mzdy/rocne_zpla.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravLA()
                {
var h_oc = document.forms.formla1.h_oc.value;

window.open('../mzdy/rocne_zpla.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuLA()
                {
var h_oc = document.forms.formla1.h_oc.value;

window.open('../mzdy/rocne_zpla.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//Podanie rzzp
function TlacPRZ()
                {
var h_oc = document.forms.formprz1.h_oc.value;

window.open('../mzdy/rocne_zppod.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPRZ()
                {
var h_oc = document.forms.formprz1.h_oc.value;

window.open('../mzdy/rocne_zppod.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPRZ()
                {
var h_oc = document.forms.formprz1.h_oc.value;

window.open('../mzdy/rocne_zppod.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//Oznamenie zamestnavatela

function TlacRocOznamenie()
                {
var h_zdrv = document.forms.formrh2.h_zdrv.value;

window.open('../mzdy/rocne_zpoznam.php?h_zdrv=' + h_zdrv + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocOznamenie()
                {
var h_zdrv = document.forms.formrh2.h_zdrv.value;

window.open('../mzdy/rocne_zpoznam.php?h_zdrv=' + h_zdrv + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocOznamenie()
                {

var h_zdrv = document.forms.formrh2.h_zdrv.value;

window.open('../mzdy/rocne_zpoznam.php?h_zdrv=' + h_zdrv + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPrilohuOznamenia()
                {

var h_zdrv = document.forms.formrh2.h_zdrv.value;

window.open('../mzdy/rocne_zpoznam.php?h_zdrv=' + h_zdrv + '&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravPrilohuOznamenia()
                {
var h_zdrv = document.forms.formrh2.h_zdrv.value;

window.open('../mzdy/rocne_zpoznamoc.php?cislo_zdrv=' + h_zdrv + '&cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }


//oznamenie zamestnancovi
function TlacOznamz()
                {
var h_oc = document.forms.formoz1.h_oc.value;

window.open('../mzdy/oznamz_zp.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravOznamz()
                {
var h_oc = document.forms.formoz1.h_oc.value;

window.open('../mzdy/oznamz_zp.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuOznamz()
                {
var h_oc = document.forms.formoz1.h_oc.value;

window.open('../mzdy/oznamz_zp.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz rocny 2011
function TlacRocVykaz()
                {
var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011.php?h_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocVykaz()
                {
var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011.php?h_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocVykaz()
                {

var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011.php?h_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPrilohuVykaz()
                {

var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011.php?h_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravPrilohuVykaz()
                {
var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011oc.php?cislo_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function SuborPrilohuVykaz()
                {
var h_zdrv = document.forms.formrh21.h_zdrv.value;
var h_oprav = document.forms.formrh21.h_oprav.value;

window.open('../mzdy/rocne_zpvykaz2011subor.php?cislo_zdrv=' + h_zdrv + '&h_oprav=' + h_oprav + '&cislo_oc=9999&copern=30&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function UpravDividendy()
                {
var h_zdrv = document.forms.formdiv.h_zdrv.value;
var h_oprav = document.forms.formdiv.h_oprav.value;

window.open('../mzdy/vykaz_zpdivid.php?cislo_oc=9999&copern=101&drupoh=1&page=1&subor=0&cislo_zdrv=' + h_zdrv  + '&h_oprav=' + h_oprav  + '&tx=1', '_blank');
                }


//potvrdenie o prijmoch 2013
<?php
$rokpotvrdenia="2013";
?>


function UpravPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_zpprijem<?php echo $rokpotvrdenia; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//oznamenie_odpzp
<?php
$rokoznamenia="";
?>

function TlacOznamenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/oznameniezp_odpoc<?php echo $rokoznamenia; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravOznamenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/oznameniezp_odpoc<?php echo $rokoznamenia; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuOznamenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/oznameniezp_odpoc<?php echo $rokoznamenia; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
  
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  ZdravotnÈho poistenia - potvrdenia, ûiadosti, RZ  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>
<?php
if( $kli_vrok >= 2014 )
     {
?>

<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacOznamenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Ozn·menie zamestnanca na uplatnenie n·roku na odpoËÌtateæn˙ poloûku ZP
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravOznamenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuOznamenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>
<?php
//len 2015 a viac
     }
?>


<?php
if( $kli_vrok >= 2014 )
     {
?>

<table class="vstup" width="100%" >
<FORM name="formdiv" class="obyc" method="post" action="#" >
<tr>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravDividendy();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù' ></a>
</td>


<td class="bmenu" width="98%">ZdravotnÈ poistenie z vyplaten˝ch dividend
<?php
$sql = mysql_query("SELECT zdrv,nzdr FROM F$kli_vxcf"."_zdravpois WHERE zdrv > 0 ORDER BY zdrv");
?>
<select size="1" name="h_zdrv" id="h_zdrv" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zdrv"];?>" >
<?php echo $zaznam["zdrv"];?> <?php echo $zaznam["nzdr"];?></option>
<?php endwhile;?>
</select>

Druh : 
 <select size="1" name="h_oprav" id="h_oprav" >
<option value="0" >N - Riadne</option>
<option value="1" >O - OpravnÈ</option>
<option value="2" >A - AditÌvne</option>
</select>

</td>
</tr>
</FORM>
</table>

<?php
//len 2014 a viac
     }
?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPotvrdenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v potvrdenÌ' ></a>
</td>
<td class="bmenu" width="98%">Ozn·menie o prÌjmoch pre ZdravotnÈ poistenie 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>

</tr>
</FORM>
</table>

<?php
//rz zp
if( $kli_vrok < 2014 )
     {
?>

<table class="vstup" width="100%" >
<FORM name="formrh21" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocVykaz();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù v˝kaz vo form·te PDF max. 2 poistenci vo vybranej ZP' ></a>
</td>
<td class="bmenu" width="78%">V˝kaz preddavkov na poistnÈ na verejnÈ ZP pre ˙Ëely roËnÈho z˙Ëtovania poistnÈho za rok 2011
<?php
$sql = mysql_query("SELECT zdrv,nzdr FROM F$kli_vxcf"."_zdravpois WHERE zdrv > 0 ORDER BY zdrv");
?>
<select size="1" name="h_zdrv" id="h_zdrv" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zdrv"];?>" >
<?php echo $zaznam["zdrv"];?> <?php echo $zaznam["nzdr"];?></option>
<?php endwhile;?>
</select>

Druh v˝kazu : 
 <select size="1" name="h_oprav" id="h_oprav" >
<option value="0" >N - Riadny</option>
<option value="1" >O - Opravn˝</option>
</select>

</td>
<td class="bmenu" width="10%">PrÌloha
<a href="#" onClick="TlacPrilohuVykaz();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù v˝kaz pre vöetk˝ch poistencov vo vybranej ZP vo form·te PDF' ></a>

<a href="#" onClick="SuborPrilohuVykaz();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvoriù s˙bor pre elektronickÈ podanie v˝kazu' ></a>

<a href="#" onClick="UpravPrilohuVykaz();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='Upraviù ˙daje poistencov' ></a>
</td>

</td>


</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravRocVykaz();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v˝kazu' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocVykaz();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do v˝kazu' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPotvrdenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Doklad o v˝öke prÌjmu a o preddavkoch na poistnÈ ZP
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPotvrdenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v potvrdenÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPotvrdenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do prehæadu z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacZiadost();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">éiadosù o vykonanie RoËnÈho z˙Ëtovania zdravotnÈho poistenia 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravZiadost();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuZiadost();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formrza1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRZA();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">RoËnÈ z˙Ëtovanie zdravotnÈho poistenia typ A 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravRZA();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRZA();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formrzs1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRZS();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">RoËnÈ z˙Ëtovanie zdravotnÈho poistenia typ S 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravRZS();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRZS();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formla1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacLA();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">RoËnÈ z˙Ëtovanie zdravotnÈho poistenia List SA - zamestnanec a zamestn·vateæ 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravLA();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuLA();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formprz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPRZ();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Potvrdenie o podanÌ RoËnÈho z˙Ëtovania zdravotnÈho poistenia  
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPRZ();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPRZ();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formrh2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocOznamenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù ozn·menie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="78%">Ozn·menie zamestn·vateæa o preplatkoch a nedoplatkoch za jednotliv˝ch zamestnancov
<?php
$sql = mysql_query("SELECT zdrv,nzdr FROM F$kli_vxcf"."_zdravpois WHERE zdrv > 0 ORDER BY zdrv");
?>
<select size="1" name="h_zdrv" id="h_zdrv" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zdrv"];?>" >
<?php echo $zaznam["zdrv"];?> <?php echo $zaznam["nzdr"];?></option>
<?php endwhile;?>
</select>

</td>
<td class="bmenu" width="10%">PrÌloha
<a href="#" onClick="TlacPrilohuOznamenia();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù prÌlohu ozn·menia vo form·te PDF' ></a>

<a href="#" onClick="UpravPrilohuOznamenia();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='Upraviù prÌlohu ozn·menia' ></a>
</td>

</td>


</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravRocOznamenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v ozn·menÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocOznamenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do ozn·menia ' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formoz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacOznamz();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Ozn·menie o nedoplatku alebo preplatku zamestnanca 
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravOznamz();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuOznamz();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<?php
     }
//koniec rz zp
?>

<br />
<?php
}
//koniec zakladnej ponuky
?>



<?php
// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
