<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 100;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$cit_nas = include("../cis/citaj_nas.php");

$zmenu = 1*$_REQUEST['zmenu'];
$niemini = 1*$_REQUEST['niemini'];
if( $zmenu == 1 )
{
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

$kli_vduj=$vyb_duj;
$kli_vxcf=$vyb_xcf;
$kli_nxcf=$vyb_naz;
$kli_vume=$vyb_ume;
$kli_vrok=$vyb_rok;

$cislooc=0;
$sqlttt = "SELECT * FROM klienti WHERE id_klienta = $kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislooc=1*$riaddok->cis1;
  }
if( $kli_xuzmzd == 100 AND $kli_xuzall == 100 AND $cislooc > 0 AND $niemini == 0 ) {
?>
<script type="text/javascript">
window.open("../mzdy/dochadzkamini.php?copern=<?php echo $copern; ?>&zmenu=1","_self");
</script>
<?php
exit;
                                                                }
}

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$sql = "SELECT hodxb FROM F".$kli_vxcf."_mzddochadzka ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_mzddochadzka ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   ume           DECIMAL(7,4) DEFAULT 0,
   oc            DECIMAL(5,0) DEFAULT 0,
   dmxa          DECIMAL(5,0) DEFAULT 0,
   dmxb          DECIMAL(5,0) DEFAULT 0,
   daod          DATE,
   dado          DATE,
   dnixa          DECIMAL(5,2) DEFAULT 0,
   dnixb          DECIMAL(5,2) DEFAULT 0,
   hodxa          DECIMAL(5,2) DEFAULT 0,
   hodxb          DECIMAL(5,2) DEFAULT 0,
   xtxt          VARCHAR(30) NOT NULL,
   datm          TIMESTAMP(14)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddochadzka'.$sqlt;
$vytvor = mysql_query("$vsql");


               }

$sql = "SELECT cplxb FROM F".$kli_vxcf."_mzddochadzka ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka ADD cplxb int DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka MODIFY cplxb int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

               }
$sql = "SELECT polprc FROM F".$kli_vxcf."_mzddochadzka ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka ADD polprc DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");

               }
$sql = "SELECT datn FROM F".$kli_vxcf."_mzddochadzka ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka ADD datn TIMESTAMP(14) AFTER datm";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT mdov FROM F".$kli_vxcf."_mzddochadzkaset ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_mzddochadzkaset ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   ocx           DECIMAL(5,0) DEFAULT 0,
   mail          VARCHAR(80) NOT NULL,
   mdov          VARCHAR(80) NOT NULL,
   dovv          VARCHAR(80) NOT NULL
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddochadzkaset'.$sqlt;
$vytvor = mysql_query("$vsql");


               }
$sql = "SELECT csv FROM F".$kli_vxcf."_mzddochadzkaset ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkaset ADD ndc DECIMAL(10,0) DEFAULT 0 AFTER dovv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkaset ADD csv DECIMAL(10,0) DEFAULT 0 AFTER dovv";
$vysledek = mysql_query("$sql");

               }


//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

//pocet dni v minulom mesiaci
$pocetdnim=31;
$kli_mmes=$kli_vmes-1;
$kli_mume=$kli_mmes.".".$kli_vrok;

if( $kli_vmes == 1 ) { $kli_rume=$kli_vrok-1; if( $kli_rume == 201 ) { $kli_rume="2010"; } $kli_mume="12.".$kli_rume; }

$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_mume ";
$sql = mysql_query("$sqltt");
$pocetdnim = mysql_num_rows($sql);
//echo $pocetdnim;
//echo $kli_mume;

//ktore dni su soboty
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden = 6 ORDER BY dat DESC";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sobota5=$riaddok->dat;
  }

$pole = explode("-", $sobota5);
$sob5=$pole[2];
$sob4=$sob5-7; if( $sob4 < 0 ) $sob4=0;
$sob3=$sob4-7; if( $sob3 < 0 ) $sob3=0;
$sob2=$sob3-7; if( $sob2 < 0 ) $sob2=0;
$sob1=$sob2-7; if( $sob1 < 0 ) $sob1=0;

//ktore dni su nedele
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden = 7 ORDER BY dat DESC";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nedela5=$riaddok->dat;
  }

$pole = explode("-", $nedela5);
$ned5=$pole[2];
$ned4=$ned5-7; if( $ned4 < 0 ) $ned4=0;
$ned3=$ned4-7; if( $ned3 < 0 ) $ned3=0;
$ned2=$ned3-7; if( $ned2 < 0 ) $ned2=0;
$ned1=$ned2-7; if( $ned1 < 0 ) $ned1=0;

//echo $ned5." ".$ned4." ".$ned3." ".$ned2." ".$ned1." ";

$aktcas = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  

//uloz nastavenie
if( $copern == 1059 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_mail = $_REQUEST['h_mail'];
$h_dovv = $_REQUEST['h_dovv'];
$h_mdov = $_REQUEST['h_mdov'];
$csv = 1*$_REQUEST['csv'];
$ndc = 1*$_REQUEST['ndc'];

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzkaset WHERE ocx = $cislo_oc  ";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzkaset ( ocx,mail,mdov,dovv,csv,ndc )".
" VALUES ( '$cislo_oc', '$h_mail', '$h_mdov', '$h_dovv', '$csv', '$ndc'  );"; 
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec uloz nastavenie



//daj nepritomnost
if( $copern == 1021 OR $copern == 1022 OR $copern == 1023 OR $copern == 1024 OR $copern == 1026 OR $copern == 1027 OR $copern == 1028 OR $copern == 1029 OR $copern == 1031 )
{
if( $copern == 1021 ) { $h_dmxa=506; }
if( $copern == 1022 ) { $h_dmxa=801; }
if( $copern == 1023 ) { $h_dmxa=802; }
if( $copern == 1029 ) { $h_dmxa=809; }
if( $copern == 1024 ) { $h_dmxa=518; }
if( $copern == 1026 ) { $h_dmxa=503; }
if( $copern == 1027 ) { $h_dmxa=502; }
if( $copern == 1028 ) { $h_dmxa=520; }
if( $copern == 1031 ) { $h_dmxa=510; }

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
$h_hdo = 1*$_REQUEST['h_hdo'];
if( $h_hdo < 0 ) $h_hdo=8;
if( $h_hdo > 15 ) $h_hdo=8;

//echo $cislo_oc;

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND dmxa = $h_dmxa AND daod = '$h_dod_sql' ";
//echo $sqty;
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt )".
" VALUES ( '$kli_vume', '$cislo_oc', '$h_dmxa', '0', '$h_dod_sql', '$h_ddo_sql', '0', '0', '0', '$h_hdo', '' );"; 
$ulozene = mysql_query("$sqty");

//kolko dni su soboty a nedele od h_dod do h_ddo pri nahradach nemoc nie tam idu vsetky dni
$sobned=0;
if( $copern == 1021 OR $copern == 1024 OR $copern == 1026 OR $copern == 1027 OR $copern == 1028 OR $copern == 1031 )
{
$sqlttt = "SELECT * FROM kalendar WHERE ( akyden = 6 OR akyden = 7 ) AND dat >= '$h_dod_sql' AND dat <= '$h_ddo_sql' ";
$sqldok = mysql_query("$sqlttt");
$sobned = 1*mysql_num_rows($sqldok);

}
//koniec kolko dni su soboty a nedele od h_dod do h_ddo


$sqty = "UPDATE F$kli_vxcf"."_mzddochadzka SET dnixa=TO_DAYS(dado)-TO_DAYS(daod)+1-$sobned WHERE oc = $cislo_oc AND dmxa = $h_dmxa AND daod = '$h_dod_sql' ";
//echo $sqty;
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec daj nepritomnost

//vycisti
if( $copern == 1025 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
//echo $cislo_oc;

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

$sqltt = "DROP TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_mzddochadzka$kli_uzid SET polprc=UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(datm) ";
$sql = mysql_query("$sqltt");
$akostara=190;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka$kli_uzid WHERE oc = $cislo_oc AND daod = '$h_dod_sql' AND dmxa > 2 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akostara=1*$riaddok->polprc;
  }


if( $akostara > 180 AND $kli_uzall < 100000 AND $kli_xuzmzd < 50000 ) { echo "NemÙûete mazaù poloûku staröiu ako 3 min˙ty. Obr·ùte sa na administr·tora. "; exit; }

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND daod = '$h_dod_sql' AND dmxa > 2 ";
//echo $sqty;
$ulozene = mysql_query("$sqty");


$copern=20;
}
//koniec vycisti

$bolprichod=0;
$bolodchod=0;
//prichod,odchod
if( $copern == 1051 OR $copern == 1052 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
//echo $cislo_oc;

$ipadx=$_SERVER["REMOTE_ADDR"];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  
$dnessql=SqlDatum($dnes);

$dnestim = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

if( $h_dod_sql != $dnessql ) { echo "Vyberte spr·vny d·tum - Dnes je ".$dnes." a nie ".$h_dod; exit; }

if( $copern == 1051 ) { $h_dmxa=1; $bolprichod=1; $prichodch="PrÌchod osË.".$cislo_oc." ".$dnestim; }
if( $copern == 1052 ) { $h_dmxa=2; $bolodchod=1; $prichodch="Odchod osË.".$cislo_oc." ".$dnestim; }

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '$h_dmxa', '0', '$h_dod_sql', '$h_ddo_sql', '0', '0', '0', '$h_hdo', '$ipadx', now() );"; 

//echo $sqty;
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec prichod,odchod

//vymaz zaznamy
if( $copern == 116 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$textzam="zamestnanca Ë.".$cislo_oc." ";
if( $cislo_oc == 0 ) {$textzam="";}
?>

<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky z·znamy <?php echo $textzam; ?> v obdobÌ <?php echo $kli_vume; ?> ?") )
         {   var okno = window.open("../mzdy/dochadzka.php?&copern=20","_self");  }
else
  var okno = window.open("../mzdy/dochadzka.php?&copern=1116&cislo_oc=<?php echo $cislo_oc; ?>","_self");
</script>

<?php
exit;
}

if( $copern == 1116 )
{
$cislo_oc = 1*$_REQUEST['cislo_oc'];


$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND ume = $kli_vume ";

if( $cislo_oc == 0 ) { $sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE ume = $kli_vume "; }
//echo $sqty;
$ulozene = mysql_query("$sqty");


$copern=20;
}
//koniec vycisti


if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Doch·dzkov˝ systÈm</title>
  <style type="text/css">
td.hvstup_zelene  { background-color:lightgreen; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bzelene  { background-color:lightgreen; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_modre  { background-color:lightblue; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

td.hvstup_sede { background-color:gray; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_hnede { background-color:brown; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_cervene { background-color:red; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_orange { background-color:orange; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_pink { background-color:pink; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_magenta { background-color:magenta; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


//dochadzka
function GenDoch()
                {

window.open('../mzdy/dochadzka_gen.php?copern=1&drupoh=3&page=1', '_self' );
                }

function TlacMesDoch()
                {

window.open('../mzdy/dochadzkames_pdf.php?cislo_oc=0&copern=1&drupoh=10&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDoch()
                {

window.open('../mzdy/dochadzka_pdf.php?cislo_oc=0&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDochNep()
                {

window.open('../mzdy/dochadzka_pdf.php?cislo_oc=0&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravDoch()
                {

window.open('../mzdy/dochadzka.php?cislo_oc=0&copern=20&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdosliDoch()
                {

window.open('../mzdy/dochadzka_export.php?cislo_oc=0&copern=26&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacDochOC( h_oc )
                {

window.open('../mzdy/dochadzka_pdf.php?cislo_oc=' + h_oc + '&copern=30&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravDochOC( h_oc )
                {

window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdosliDochOC( h_oc )
                {

window.open('../mzdy/dochadzka_export.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazDochOc( h_oc )
                {

window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&copern=116&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazDoch()
                {

window.open('../mzdy/dochadzka.php?cislo_oc=0&copern=116&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  function DochadzkaEdi(h_oc)
  { 

  window.open('../mzdy/dochadzka_edi.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=600, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
    
  function Prionload()
  { 
<?php if( $bolprichod == 1 OR $bolodchod == 1 ) { ?> 
  prichodch.style.display='';
<?php                                           } ?> 
  }

</script>

</HEAD>
<BODY class="white" onload="Prionload();"  >

<?php
//echo $copern;
if ( $copern == 1 OR $copern == 20 )
     {
?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='ponuka' width='100%'><tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr><td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="document.forms.fhiden.ocold.value=0; nastavfakx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm 

 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_dovolenka();" title='Dovolenkov˝ lÌstok' >
 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_lekar();" title='Priepustka lek·rovi, ˙rad...' >
 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_volno();" title='éiadosù o pracovnÈ voæno' >
</td>

<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="document.forms.fhiden.ocold.value=0; nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  

<tr><FORM name='fkoef' method='post' action='#' >
<td colspan='8' align="left">Zamestnanec osË <input type='text' readonly name='h_oscx' id='h_oscx' size='10' maxlenght='10' value="" readonly="readonly" >
<input type='text' readonly name='h_priex' id='h_priex size='20' maxlenght='20' value="" >
<td colspan='2' align='right'></td></tr>  


<tr><td class='ponuka' colspan='10'>D·tum od 
<input type='text' readonly name='h_dod' id='h_dod' size='10' maxlenght='10' value="" > D·tum do 
<input type='text' readonly name='h_ddo' id='h_ddo' size='10' maxlenght='10' value="" > 
Hodiny  <img src='../obr/info.png' width=12 height=12 border=0 title='UplatnÌ sa u n·hrad ak v prv˝ deÚ n·hrady mzdy neËerp· zamestnanec cel˝ deÚ ale len Ëasù'> 

<input type='text' name='h_hdo' id='h_hdo' size='10' maxlenght='10' value="" > 
</td></tr>

<tr>

<td colspan='1' class='ponuka' align='center' onClick="Prichod();"> PrÌchod do pr·ce</td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' onClick="Odchod();"> Odchod z pr·ce</td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' onClick="DajSviatok();"> Sviatok S </td>

</tr>


<tr>
<td colspan='1' class='ponuka' align='center' onClick="DajDovolenku();"> Dovolenka D </td>

<td colspan='1' align='center' onClick="DajLekar();"> N·vöteva lek·ra L</td>

<td colspan='1' class='ponuka' align='center' onClick="DajOsetr();"> OöetrovnÈ O</td>

<td colspan='1' align='center' onClick="DajNemoc();"> Nemoc N</td>

<td colspan='1' class='ponuka' align='center' onClick="DajAbsenciu();"> Absencia A</td>

<td colspan='1' align='center' onClick="DajNeplatene();"> NeplatenÈ voæno V</td>

<td colspan='1' class='ponuka' align='center' onClick="DajIne();"> InÈ I</td>

<td colspan='1' align='center' onClick="DajMatersku();"> Matersk· M</td>

<td colspan='1' class='ponuka' align='center' onClick="Vycisti();"> Vymazaù v obdobÌ</td>

</tr>

</FORM></table>
</div>
<script type="text/javascript">


  function zobraz_robotmenu(oc, menoprie, riadok, datod, datdo, uvazok)
                {
  nastavfakx.style.display='';

    var toprobotmenu = 120+riadok*22;
    var leftrobotmenu = 400;
    var widthrobotmenu = 600;

    var h_ocold = document.forms.fhiden.ocold.value;
    var h_oc = oc;
    var zmenaoc = 0;
    if( h_oc != h_ocold ) zmenaoc=1;
    if( zmenaoc == 0 ) { var datodx = document.forms.fhiden.datodold.value; }
    if( zmenaoc == 1 ) { var datodx = datod; }


    document.forms.fkoef.h_oscx.value=h_oc;
    document.forms.fkoef.h_priex.value=menoprie;

    document.forms.fkoef.h_dod.value=datodx;
    document.forms.fkoef.h_ddo.value=datdo;
    document.forms.fkoef.h_hdo.value=uvazok;

    document.forms.fhiden.ocold.value=h_oc;
    document.forms.fhiden.datodold.value=datodx;

  myRobotmenu = document.getElementById("nastavfakx");
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobotmenu.style.width = widthrobotmenu;

                }

  function tlac_dovolenka()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_lekar()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=2&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_volno()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=3&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_ine()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=4&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }


  function DajIne()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1028&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajAbsenciu()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1026&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajNeplatene()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1027&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


  function DajDovolenku()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1021&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajSviatok()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1031&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajNemoc()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1022&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajOsetr()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1023&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajMatersku()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1029&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajLekar()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1024&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Vycisti()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1025&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Prichod()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1051&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Odchod()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1052&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

</script>

<div id="nastavmailx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr><td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavmailx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm - Nastavenie </td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavmailx.style.display='none';" title='Zhasni menu' >
</td></tr>  

<tr><FORM name='fkoef2' method='post' action='#' >
<td colspan='8' align="left">Zamestnanec osË <input type='text' readonly name='h_oscx' id='h_oscx' size='10' maxlenght='10' value="" readonly="readonly" >
<input type='text' readonly name='h_priex' id='h_priex size='20' maxlenght='20' value="" >
<td colspan='2' align='right'></td></tr>  


<tr><td class='ponuka' colspan='2'>Kam mailovaù 
<td class='ponuka' colspan='8'><input type='text' name='h_mail' id='h_mail' size='80' maxlenght='80' value="" > 
</td></tr>

<tr><td class='ponuka' colspan='2'>Miesto pobytu 
<td class='ponuka' colspan='8'><input type='text' name='h_mdov' id='h_mdov' size='80' maxlenght='80' value="" >
</td></tr>
<tr><td class='ponuka' colspan='2'>DÙvod voæna, priepustky 
<td class='ponuka' colspan='8'><input type='text' name='h_dovv' id='h_dovv' size='80' maxlenght='80' value="" > 
</td></tr>

<tr><td class='ponuka' colspan='10'>  | Ëasov· mzda <input type='checkbox' name='csv' value='1' > | nadËasy <input type='checkbox' name='ndc' value='1' > </td></tr>

<tr><td colspan='10'> <img border=0 src="../obr/ok.png" style="width:15; height:15;" onClick="uloz_upravmail();" title='Uloûiù nastavenie' >  


</td></tr>

<tr><td></td></FORM></tr></table> 

</div>
<script type="text/javascript">
  function zobraz_upravmail(oc, menoprie, riadok, mail, dovv, mdov, csv, ndc)
  { 
  nastavmailx.style.display='';

    var toprobotmenu2 = 120+riadok*22;
    var leftrobotmenu2 = 400;
    var widthrobotmenu2 = 600;
    var h_oc = oc;
    var h_menoprie = menoprie;
    var komumail = mail;
    var dovodvolna = dovv;
    var miestodov = mdov;

    if( csv == 1 ) { document.fkoef2.csv.checked = 'checked'; }
    if( ndc == 1 ) { document.fkoef2.ndc.checked = 'checked'; }
    document.forms.fkoef2.h_oscx.value=oc;
    document.forms.fkoef2.h_priex.value=menoprie;
    document.forms.fkoef2.h_mail.value=mail;
    document.forms.fkoef2.h_mdov.value=mdov;
    document.forms.fkoef2.h_dovv.value=dovv;


  myRobotmenu2 = document.getElementById("nastavmailx");
  myRobotmenu2.style.top = toprobotmenu2;
  myRobotmenu2.style.left = leftrobotmenu2;
  myRobotmenu2.style.width = widthrobotmenu2;

  }

  function uloz_upravmail()
  { 

  var h_oc = document.forms.fkoef2.h_oscx.value;
  var h_mail = document.forms.fkoef2.h_mail.value;
  var h_dovv = document.forms.fkoef2.h_dovv.value;
  var h_mdov = document.forms.fkoef2.h_mdov.value;
  var csv = 0;
  if( document.fkoef2.csv.checked ) csv=1;
  var ndc = 0;
  if( document.fkoef2.ndc.checked ) ndc=1;

  window.open('../mzdy/dochadzka.php?cislo_oc=' + h_oc + '&h_mail=' + h_mail + '&h_dovv=' + h_dovv + '&h_mdov=' + h_mdov + '&csv=' + csv + '&ndc=' + ndc + '&copern=1059&drupoh=1&page=1&subor=0', '_self');
  }

</script>
<?php
     }
?>



<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Doch·dzkov˝ systÈm
</td>
<td align="right">
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   oc           INT(10),
   pomx         DECIMAL(10,0),
   dmxa         DECIMAL(10,0),
   daod         DATE,
   dado         DATE,
   d01x         DECIMAL(10,2),
   d02x         DECIMAL(10,2),
   d03x         DECIMAL(10,2),
   d04x         DECIMAL(10,2),
   d05x         DECIMAL(10,2),
   d06x         DECIMAL(10,2),
   d07x         DECIMAL(10,2),
   d08x         DECIMAL(10,2),
   d09x         DECIMAL(10,2),
   d10x         DECIMAL(10,2),
   d11x         DECIMAL(10,2),
   d12x         DECIMAL(10,2),
   d13x         DECIMAL(10,2),
   d14x         DECIMAL(10,2),
   d15x         DECIMAL(10,2),
   d16x         DECIMAL(10,2),
   d17x         DECIMAL(10,2),
   d18x         DECIMAL(10,2),
   d19x         DECIMAL(10,2),
   d20x         DECIMAL(10,2),
   d21x         DECIMAL(10,2),
   d22x         DECIMAL(10,2),
   d23x         DECIMAL(10,2),
   d24x         DECIMAL(10,2),
   d25x         DECIMAL(10,2),
   d26x         DECIMAL(10,2),
   d27x         DECIMAL(10,2),
   d28x         DECIMAL(10,2),
   d29x         DECIMAL(10,2),
   d30x         DECIMAL(10,2),
   d31x         DECIMAL(10,2),
   l01x         DECIMAL(10,2),
   l02x         DECIMAL(10,2),
   l03x         DECIMAL(10,2),
   l04x         DECIMAL(10,2),
   l05x         DECIMAL(10,2),
   l06x         DECIMAL(10,2),
   l07x         DECIMAL(10,2),
   l08x         DECIMAL(10,2),
   l09x         DECIMAL(10,2),
   l10x         DECIMAL(10,2),
   l11x         DECIMAL(10,2),
   l12x         DECIMAL(10,2),
   l13x         DECIMAL(10,2),
   l14x         DECIMAL(10,2),
   l15x         DECIMAL(10,2),
   l16x         DECIMAL(10,2),
   l17x         DECIMAL(10,2),
   l18x         DECIMAL(10,2),
   l19x         DECIMAL(10,2),
   l20x         DECIMAL(10,2),
   l21x         DECIMAL(10,2),
   l22x         DECIMAL(10,2),
   l23x         DECIMAL(10,2),
   l24x         DECIMAL(10,2),
   l25x         DECIMAL(10,2),
   l26x         DECIMAL(10,2),
   l27x         DECIMAL(10,2),
   l28x         DECIMAL(10,2),
   l29x         DECIMAL(10,2),
   l30x         DECIMAL(10,2),
   l31x         DECIMAL(10,2),
   o01x         DECIMAL(10,2),
   o02x         DECIMAL(10,2),
   o03x         DECIMAL(10,2),
   o04x         DECIMAL(10,2),
   o05x         DECIMAL(10,2),
   o06x         DECIMAL(10,2),
   o07x         DECIMAL(10,2),
   o08x         DECIMAL(10,2),
   o09x         DECIMAL(10,2),
   o10x         DECIMAL(10,2),
   o11x         DECIMAL(10,2),
   o12x         DECIMAL(10,2),
   o13x         DECIMAL(10,2),
   o14x         DECIMAL(10,2),
   o15x         DECIMAL(10,2),
   o16x         DECIMAL(10,2),
   o17x         DECIMAL(10,2),
   o18x         DECIMAL(10,2),
   o19x         DECIMAL(10,2),
   o20x         DECIMAL(10,2),
   o21x         DECIMAL(10,2),
   o22x         DECIMAL(10,2),
   o23x         DECIMAL(10,2),
   o24x         DECIMAL(10,2),
   o25x         DECIMAL(10,2),
   o26x         DECIMAL(10,2),
   o27x         DECIMAL(10,2),
   o28x         DECIMAL(10,2),
   o29x         DECIMAL(10,2),
   o30x         DECIMAL(10,2),
   o31x         DECIMAL(10,2),
   n01x         DECIMAL(10,2),
   n02x         DECIMAL(10,2),
   n03x         DECIMAL(10,2),
   n04x         DECIMAL(10,2),
   n05x         DECIMAL(10,2),
   n06x         DECIMAL(10,2),
   n07x         DECIMAL(10,2),
   n08x         DECIMAL(10,2),
   n09x         DECIMAL(10,2),
   n10x         DECIMAL(10,2),
   n11x         DECIMAL(10,2),
   n12x         DECIMAL(10,2),
   n13x         DECIMAL(10,2),
   n14x         DECIMAL(10,2),
   n15x         DECIMAL(10,2),
   n16x         DECIMAL(10,2),
   n17x         DECIMAL(10,2),
   n18x         DECIMAL(10,2),
   n19x         DECIMAL(10,2),
   n20x         DECIMAL(10,2),
   n21x         DECIMAL(10,2),
   n22x         DECIMAL(10,2),
   n23x         DECIMAL(10,2),
   n24x         DECIMAL(10,2),
   n25x         DECIMAL(10,2),
   n26x         DECIMAL(10,2),
   n27x         DECIMAL(10,2),
   n28x         DECIMAL(10,2),
   n29x         DECIMAL(10,2),
   n30x         DECIMAL(10,2),
   n31x         DECIMAL(10,2),
   a01x         DECIMAL(10,2),
   a02x         DECIMAL(10,2),
   a03x         DECIMAL(10,2),
   a04x         DECIMAL(10,2),
   a05x         DECIMAL(10,2),
   a06x         DECIMAL(10,2),
   a07x         DECIMAL(10,2),
   a08x         DECIMAL(10,2),
   a09x         DECIMAL(10,2),
   a10x         DECIMAL(10,2),
   a11x         DECIMAL(10,2),
   a12x         DECIMAL(10,2),
   a13x         DECIMAL(10,2),
   a14x         DECIMAL(10,2),
   a15x         DECIMAL(10,2),
   a16x         DECIMAL(10,2),
   a17x         DECIMAL(10,2),
   a18x         DECIMAL(10,2),
   a19x         DECIMAL(10,2),
   a20x         DECIMAL(10,2),
   a21x         DECIMAL(10,2),
   a22x         DECIMAL(10,2),
   a23x         DECIMAL(10,2),
   a24x         DECIMAL(10,2),
   a25x         DECIMAL(10,2),
   a26x         DECIMAL(10,2),
   a27x         DECIMAL(10,2),
   a28x         DECIMAL(10,2),
   a29x         DECIMAL(10,2),
   a30x         DECIMAL(10,2),
   a31x         DECIMAL(10,2),
   v01x         DECIMAL(10,2),
   v02x         DECIMAL(10,2),
   v03x         DECIMAL(10,2),
   v04x         DECIMAL(10,2),
   v05x         DECIMAL(10,2),
   v06x         DECIMAL(10,2),
   v07x         DECIMAL(10,2),
   v08x         DECIMAL(10,2),
   v09x         DECIMAL(10,2),
   v10x         DECIMAL(10,2),
   v11x         DECIMAL(10,2),
   v12x         DECIMAL(10,2),
   v13x         DECIMAL(10,2),
   v14x         DECIMAL(10,2),
   v15x         DECIMAL(10,2),
   v16x         DECIMAL(10,2),
   v17x         DECIMAL(10,2),
   v18x         DECIMAL(10,2),
   v19x         DECIMAL(10,2),
   v20x         DECIMAL(10,2),
   v21x         DECIMAL(10,2),
   v22x         DECIMAL(10,2),
   v23x         DECIMAL(10,2),
   v24x         DECIMAL(10,2),
   v25x         DECIMAL(10,2),
   v26x         DECIMAL(10,2),
   v27x         DECIMAL(10,2),
   v28x         DECIMAL(10,2),
   v29x         DECIMAL(10,2),
   v30x         DECIMAL(10,2),
   v31x         DECIMAL(10,2),
   i01x         DECIMAL(10,2),
   i02x         DECIMAL(10,2),
   i03x         DECIMAL(10,2),
   i04x         DECIMAL(10,2),
   i05x         DECIMAL(10,2),
   i06x         DECIMAL(10,2),
   i07x         DECIMAL(10,2),
   i08x         DECIMAL(10,2),
   i09x         DECIMAL(10,2),
   i10x         DECIMAL(10,2),
   i11x         DECIMAL(10,2),
   i12x         DECIMAL(10,2),
   i13x         DECIMAL(10,2),
   i14x         DECIMAL(10,2),
   i15x         DECIMAL(10,2),
   i16x         DECIMAL(10,2),
   i17x         DECIMAL(10,2),
   i18x         DECIMAL(10,2),
   i19x         DECIMAL(10,2),
   i20x         DECIMAL(10,2),
   i21x         DECIMAL(10,2),
   i22x         DECIMAL(10,2),
   i23x         DECIMAL(10,2),
   i24x         DECIMAL(10,2),
   i25x         DECIMAL(10,2),
   i26x         DECIMAL(10,2),
   i27x         DECIMAL(10,2),
   i28x         DECIMAL(10,2),
   i29x         DECIMAL(10,2),
   i30x         DECIMAL(10,2),
   i31x         DECIMAL(10,2),
   m01x         DECIMAL(10,2),
   m02x         DECIMAL(10,2),
   m03x         DECIMAL(10,2),
   m04x         DECIMAL(10,2),
   m05x         DECIMAL(10,2),
   m06x         DECIMAL(10,2),
   m07x         DECIMAL(10,2),
   m08x         DECIMAL(10,2),
   m09x         DECIMAL(10,2),
   m10x         DECIMAL(10,2),
   m11x         DECIMAL(10,2),
   m12x         DECIMAL(10,2),
   m13x         DECIMAL(10,2),
   m14x         DECIMAL(10,2),
   m15x         DECIMAL(10,2),
   m16x         DECIMAL(10,2),
   m17x         DECIMAL(10,2),
   m18x         DECIMAL(10,2),
   m19x         DECIMAL(10,2),
   m20x         DECIMAL(10,2),
   m21x         DECIMAL(10,2),
   m22x         DECIMAL(10,2),
   m23x         DECIMAL(10,2),
   m24x         DECIMAL(10,2),
   m25x         DECIMAL(10,2),
   m26x         DECIMAL(10,2),
   m27x         DECIMAL(10,2),
   m28x         DECIMAL(10,2),
   m29x         DECIMAL(10,2),
   m30x         DECIMAL(10,2),
   m31x         DECIMAL(10,2),
   s01x         DECIMAL(10,2),
   s02x         DECIMAL(10,2),
   s03x         DECIMAL(10,2),
   s04x         DECIMAL(10,2),
   s05x         DECIMAL(10,2),
   s06x         DECIMAL(10,2),
   s07x         DECIMAL(10,2),
   s08x         DECIMAL(10,2),
   s09x         DECIMAL(10,2),
   s10x         DECIMAL(10,2),
   s11x         DECIMAL(10,2),
   s12x         DECIMAL(10,2),
   s13x         DECIMAL(10,2),
   s14x         DECIMAL(10,2),
   s15x         DECIMAL(10,2),
   s16x         DECIMAL(10,2),
   s17x         DECIMAL(10,2),
   s18x         DECIMAL(10,2),
   s19x         DECIMAL(10,2),
   s20x         DECIMAL(10,2),
   s21x         DECIMAL(10,2),
   s22x         DECIMAL(10,2),
   s23x         DECIMAL(10,2),
   s24x         DECIMAL(10,2),
   s25x         DECIMAL(10,2),
   s26x         DECIMAL(10,2),
   s27x         DECIMAL(10,2),
   s28x         DECIMAL(10,2),
   s29x         DECIMAL(10,2),
   s30x         DECIMAL(10,2),
   s31x         DECIMAL(10,2),
   pop          VARCHAR(80)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$generovacie=0;
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $generovacie=1; }
if( $_SERVER['SERVER_NAME'] == "www.eurolark.sk" ) { $generovacie=1; }
$mzdkun="mzdkun";
if( $generovacie == 1 ) 
{
$mzdkun="mzdkunx".$kli_uzid;

$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "CREATE TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume ";
$sqlxx = mysql_query("$sqlttxx");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,'0000-00-00','0000-00-00',".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" '' ".
" FROM F$kli_vxcf"."_$mzdkun".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,dmxa,daod,dado,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" '' ".
" FROM F$kli_vxcf"."_mzddochadzka".
" WHERE oc >= 0 AND ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

$strxx1=" oc < 0 ";
$strxx2=" oc < 0 ";
if( $generovacie == 1 ) 
{
$strxx1=" pomx != 1 ";
$strxx2=" pomx != 1 ";
if( $_SERVER['SERVER_NAME'] == "www.eurolark.sk" ) 
{
$strxx1=" pomx == 99 ";
$strxx2=" pomx == 99 ";
}

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz".$kli_uzid.",F$kli_vxcf"."_$mzdkun ".
" SET F$kli_vxcf"."_rzdanezoz".$kli_uzid.".pomx=F$kli_vxcf"."_$mzdkun.stz ".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz".$kli_uzid." WHERE $strxx1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz".$kli_uzid.",F$kli_vxcf"."_$mzdkun ".
" SET F$kli_vxcf"."_rzdanezoz".$kli_uzid.".pomx=F$kli_vxcf"."_$mzdkun.pom ".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc AND F$kli_vxcf"."_$mzdkun.ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz".$kli_uzid." WHERE $strxx2 ";
$dsql = mysql_query("$dsqlt");


}




//rozdel nepritomnost do dni
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" d".$denx."x=1 WHERE dmxa = 506 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" l".$denx."x=1 WHERE dmxa = 518 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" o".$denx."x=1 WHERE dmxa = 802  AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" m".$denx."x=1 WHERE dmxa = 809  AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }

$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" n".$denx."x=1 WHERE dmxa = 801 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" a".$denx."x=1 WHERE dmxa = 503 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" v".$denx."x=1 WHERE dmxa = 502 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" i".$denx."x=1 WHERE dmxa = 520 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }
$denx=1;
  while ($denx <= 31 )
  {
if( $denx < 10 ) $denx="0".$denx;
$datumx=$kli_vrok."-".$kli_vmes."-".$denx;

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid"." SET".
" s".$denx."x=1 WHERE dmxa = 510 AND ( daod = '$datumx' OR ( daod < '$datumx' AND dado >= '$datumx' ) )"; $dsql = mysql_query("$dsqlt");
$denx=$denx+1;
  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 1,oc,0,0,daod,dado,".
" SUM(d01x),SUM(d02x),SUM(d03x),SUM(d04x),SUM(d05x),SUM(d06x),SUM(d07x),SUM(d08x),SUM(d09x),SUM(d10x),".
" SUM(d11x),SUM(d12x),SUM(d13x),SUM(d14x),SUM(d15x),SUM(d16x),SUM(d17x),SUM(d18x),SUM(d19x),SUM(d20x),".
" SUM(d21x),SUM(d22x),SUM(d23x),SUM(d24x),SUM(d25x),SUM(d26x),SUM(d27x),SUM(d28x),SUM(d29x),SUM(d30x),SUM(d31x),".
" SUM(l01x),SUM(l02x),SUM(l03x),SUM(l04x),SUM(l05x),SUM(l06x),SUM(l07x),SUM(l08x),SUM(l09x),SUM(l10x),".
" SUM(l11x),SUM(l12x),SUM(l13x),SUM(l14x),SUM(l15x),SUM(l16x),SUM(l17x),SUM(l18x),SUM(l19x),SUM(l20x),".
" SUM(l21x),SUM(l22x),SUM(l23x),SUM(l24x),SUM(l25x),SUM(l26x),SUM(l27x),SUM(l28x),SUM(l29x),SUM(l30x),SUM(l31x),".
" SUM(o01x),SUM(o02x),SUM(o03x),SUM(o04x),SUM(o05x),SUM(o06x),SUM(o07x),SUM(o08x),SUM(o09x),SUM(o10x),".
" SUM(o11x),SUM(o12x),SUM(o13x),SUM(o14x),SUM(o15x),SUM(o16x),SUM(o17x),SUM(o18x),SUM(o19x),SUM(o20x),".
" SUM(o21x),SUM(o22x),SUM(o23x),SUM(o24x),SUM(o25x),SUM(o26x),SUM(o27x),SUM(o28x),SUM(o29x),SUM(o30x),SUM(o31x),".
" SUM(n01x),SUM(n02x),SUM(n03x),SUM(n04x),SUM(n05x),SUM(n06x),SUM(n07x),SUM(n08x),SUM(n09x),SUM(n10x),".
" SUM(n11x),SUM(n12x),SUM(n13x),SUM(n14x),SUM(n15x),SUM(n16x),SUM(n17x),SUM(n18x),SUM(n19x),SUM(n20x),".
" SUM(n21x),SUM(n22x),SUM(n23x),SUM(n24x),SUM(n25x),SUM(n26x),SUM(n27x),SUM(n28x),SUM(n29x),SUM(n30x),SUM(n31x),".
" SUM(a01x),SUM(a02x),SUM(a03x),SUM(a04x),SUM(a05x),SUM(a06x),SUM(a07x),SUM(a08x),SUM(a09x),SUM(a10x),".
" SUM(a11x),SUM(a12x),SUM(a13x),SUM(a14x),SUM(a15x),SUM(a16x),SUM(a17x),SUM(a18x),SUM(a19x),SUM(a20x),".
" SUM(a21x),SUM(a22x),SUM(a23x),SUM(a24x),SUM(a25x),SUM(a26x),SUM(a27x),SUM(a28x),SUM(a29x),SUM(a30x),SUM(a31x),".
" SUM(v01x),SUM(v02x),SUM(v03x),SUM(v04x),SUM(v05x),SUM(v06x),SUM(v07x),SUM(v08x),SUM(v09x),SUM(v10x),".
" SUM(v11x),SUM(v12x),SUM(v13x),SUM(v14x),SUM(v15x),SUM(v16x),SUM(v17x),SUM(v18x),SUM(v19x),SUM(v20x),".
" SUM(v21x),SUM(v22x),SUM(v23x),SUM(v24x),SUM(v25x),SUM(v26x),SUM(v27x),SUM(v28x),SUM(v29x),SUM(v30x),SUM(v31x),".
" SUM(i01x),SUM(i02x),SUM(i03x),SUM(i04x),SUM(i05x),SUM(i06x),SUM(i07x),SUM(i08x),SUM(i09x),SUM(i10x),".
" SUM(i11x),SUM(i12x),SUM(i13x),SUM(i14x),SUM(i15x),SUM(i16x),SUM(i17x),SUM(i18x),SUM(i19x),SUM(i20x),".
" SUM(i21x),SUM(i22x),SUM(i23x),SUM(i24x),SUM(i25x),SUM(i26x),SUM(i27x),SUM(i28x),SUM(i29x),SUM(i30x),SUM(i31x),".
" SUM(m01x),SUM(m02x),SUM(m03x),SUM(m04x),SUM(m05x),SUM(m06x),SUM(m07x),SUM(m08x),SUM(m09x),SUM(m10x),".
" SUM(m11x),SUM(m12x),SUM(m13x),SUM(m14x),SUM(m15x),SUM(m16x),SUM(m17x),SUM(m18x),SUM(m19x),SUM(m20x),".
" SUM(m21x),SUM(m22x),SUM(m23x),SUM(m24x),SUM(m25x),SUM(m26x),SUM(m27x),SUM(m28x),SUM(m29x),SUM(m30x),SUM(m31x),".
" SUM(s01x),SUM(s02x),SUM(s03x),SUM(s04x),SUM(s05x),SUM(s06x),SUM(s07x),SUM(s08x),SUM(s09x),SUM(s10x),".
" SUM(s11x),SUM(s12x),SUM(s13x),SUM(s14x),SUM(s15x),SUM(s16x),SUM(s17x),SUM(s18x),SUM(s19x),SUM(s20x),".
" SUM(s21x),SUM(s22x),SUM(s23x),SUM(s24x),SUM(s25x),SUM(s26x),SUM(s27x),SUM(s28x),SUM(s29x),SUM(s30x),SUM(s31x),".
" pop ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid GROUP BY oc".
" ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 0 ";
$dsql = mysql_query("$dsqlt");

                  

//tu nastavim do cislx_oc cislo oc zamestnanca cis1 z tabulky klienti podla kli_uzid
$sqlttt = "SELECT * FROM klienti WHERE id_klienta = $kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo1=1*$riaddok->cis1;
  }

$cislx_oc=1*$cislo1;
$podmnoc=" = $cislx_oc ";
if( $kli_xuzmzd > 1000 OR $kli_xuzall >= 100000 ) { $podmnoc=" >= 0 "; }




$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_$mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzddochadzkaset".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_mzddochadzkaset.ocx".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc $podmnoc "."ORDER BY psys,prie";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);



$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {
?>
<div id="myRdpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>

<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<div id="robotmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="4"> 
<span id="prichodch" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;"><?php echo $prichodch;?></span>
<?php                  if( $kli_xuzmzd > 1000 OR $kli_xuzall >= 100000 ) { ?>

<img src='../obr/tlac.png' onClick="TlacDoch();" width=20 height=15 border=0 title='VytlaËiù doch·dzku podæa zamestnancov vo form·te PDF' >

<img src='../obr/tlac.png' onClick="TlacDochNep();" width=20 height=15 border=0 title='VytlaËiù doch·dzku podæa druhu neprÌtomnosti vo form·te PDF' >

<a href="#" onClick="OdosliDoch();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do mesaËn˝ch miezd vöetk˝ch zamestnancov - mÙûete opakovaù viackr·t' ></a>

<?php                                                                     } ?>

</td>
<td class="bmenu" colspan="17">

<img src='../obr/tlac.png' onClick="TlacMesDoch();" width=20 height=15 border=0 title='VytlaËiù mesaËn˝ evidenËn˝ list doch·dzky vo form·te PDF' >

Obdobie: <?php echo $kli_vume;?>

<?php if( $kli_uzall >= 15000 ) { ?>
<img src='../obr/vlozit.png' onClick="GenDoch();" width=20 height=15 border=0 title='Generovaù mesaËn˙ doch·dzku' >
<?php                           } ?>

</td>
<td class="bmenu" colspan="7">
<?php echo $aktcas;?>
<td class="bmenu" colspan="7" align="right">
<?php                   if( $kli_xuzmzd > 1000 OR $kli_xuzall >= 100000 ) { ?>
<a href="#" onClick="ZmazDoch();">
<img src='../obr/zmazuplne.png' width=20 height=15 border=0 title='Zmazaù z·znamy vöetk˝ch zamestnancov v obdobÌ <?php echo $kli_vume;?>' ></a>
<?php                                                                     } ?>
</td>
</tr>

<?php $farbaden="bmenu"; ?>

<tr>
<td class="bmenu" width="5%">os.Ë.</td>
<td class="hvstup_zlte" width="8%" align="right"> </td>
<td class="bmenu" width="20%">priezvisko meno</td>
<td class="bmenu" width="5%" align="right">Pomer</td>
<?php $den=1; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">01</td>
<?php $den=2; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">02</td>
<?php $den=3; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">03</td>
<?php $den=4; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">04</td>
<?php $den=5; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">05</td>
<?php $den=6; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">06</td>
<?php $den=7; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">07</td>
<?php $den=8; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">08</td>
<?php $den=9; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">09</td>
<?php $den=10; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">10</td>
<?php $den=11; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">11</td>
<?php $den=12; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">12</td>
<?php $den=13; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">13</td>
<?php $den=14; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">14</td>
<?php $den=15; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">15</td>
<?php $den=16; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">16</td>
<?php $den=17; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">17</td>
<?php $den=18; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">18</td>
<?php $den=19; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">19</td>
<?php $den=20; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">20</td>
<?php $den=21; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">21</td>
<?php $den=22; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">22</td>
<?php $den=23; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">23</td>
<?php $den=24; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">24</td>
<?php $den=25; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">25</td>
<?php $den=26; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">26</td>
<?php $den=27; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">27</td>
<?php $den=28; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<td class="<?php echo $farbaden;?>" width="2%" align="center">28</td>
<?php $den=29; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<?php if( $pocetdni > 28 ) { ?><td class="<?php echo $farbaden;?>" width="2%" align="center">29</td><?php } ?> 
<?php $den=30; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<?php if( $pocetdni > 29 ) { ?><td class="<?php echo $farbaden;?>" width="2%" align="center">30</td><?php } ?>
<?php $den=31; $farbaden="bmenu"; if( $ned1 == $den OR $ned2 == $den OR $ned3 == $den OR $ned4 == $den OR $ned5 == $den ) { $farbaden="hvstup_bred"; } ?>
<?php if( $sob1 == $den OR $sob2 == $den OR $sob3 == $den OR $sob4 == $den OR $sob5 == $den ) { $farbaden="hvstup_bzelene"; } ?>
<?php if( $pocetdni > 30 ) { ?><td class="<?php echo $farbaden;?>" width="2%" align="center">31</td><?php } ?>
</tr>

<?php
      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";

$hvstup="hvstup";
$hvstupz="hvstup_zlte";

$vykrz="NIE";

if( $polozka->vykx == 1 ) { $hvstup="hvstup_bred"; $vykrz="¡NO"; }

if( $polozka->pom == 9 ) { $hvstup="hvstup_bsede"; $hvstupz="hvstup_bsede"; }

$riadok=$i+1;

?>

<?php if( $polozka->psys == 1 ) { ?>

<tr>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->oc; ?> 

<a href="#" onClick="TlacDochOC(<?php echo $polozka->oc;?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù doch·dzku zamestnanca Ë.<?php echo $polozka->oc;?> vo form·te PDF' ></a>

</td>
<td class="<?php echo $hvstupz; ?>" align="right">
<a href="#" onClick="ZmazDochOc(<?php echo $polozka->oc;?>);">
<img src='../obr/zmazuplne.png' width=15 height=15 border=0 title='Zmazaù z·znamy zamestnanca Ë. <?php echo $polozka->oc;?> v obdobÌ <?php echo $kli_vume;?>' ></a>
</td>
<td class="<?php echo $hvstup; ?>">

<a href="#" onClick="UpravDochOC(<?php echo $polozka->oc;?>);">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='Upraviù doch·dzku zamestnanca Ë.<?php echo $polozka->oc;?>' ></a>

<img src='../obr/naradie.png'  onClick="zobraz_upravmail(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $polozka->mail;?>', '<?php echo $polozka->dovv;?>', '<?php echo $polozka->mdov;?>', '<?php echo $polozka->csv;?>', '<?php echo $polozka->ndc;?>');" width=15 height=15 border=0 title='Nastaviù mailovÈ ˙daje zamestnanca Ë.<?php echo $polozka->oc;?> vo form·te PDF' >

<?php
$csvmzda=0;
$sqldok = mysql_query("SELECT csv, ndc FROM F$kli_vxcf"."_mzddochadzkaset WHERE csv = 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $csvmzda=1*$riaddok->csv;
  }
?>
<?php if( $csvmzda == 1 ) { ?>
<a href="#" onClick="DochadzkaEdi(<?php echo $polozka->oc;?>);">
<?php                     } ?>
 <?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?> str <?php echo $polozka->stz; ?>
<?php if( $csvmzda == 1 ) { ?>
</a>
<?php                     } ?>
</td>
<td class="<?php echo $hvstup; ?>" align="right">

<?php                   if( $kli_xuzmzd > 1000 OR $kli_xuzall >= 100000 ) { ?>
<a href="#" onClick="OdosliDochOC(<?php echo $polozka->oc;?>);">
<img src='../obr/orig.png' width=15 height=15 border=0 title='NaËÌtaù hodnoty do mesaËn˝ch miezd zamestnanca Ë.<?php echo $polozka->oc;?> - mÙûete opakovaù viackr·t' ></a>
<?php                                                                     } ?>
<?php echo $polozka->pom;?></td>

<?php
$hvstup01=$hvstupz;$hvstup02=$hvstup;$hvstup03=$hvstupz;$hvstup04=$hvstup;$hvstup05=$hvstupz;$hvstup06=$hvstup;
$hvstup07=$hvstupz;$hvstup08=$hvstup;$hvstup09=$hvstupz;$hvstup10=$hvstup;
$hvstup11=$hvstupz;$hvstup12=$hvstup;$hvstup13=$hvstupz;$hvstup14=$hvstup;$hvstup15=$hvstupz;$hvstup16=$hvstup;
$hvstup17=$hvstupz;$hvstup18=$hvstup;$hvstup19=$hvstupz;$hvstup20=$hvstup;
$hvstup21=$hvstupz;$hvstup22=$hvstup;$hvstup23=$hvstupz;$hvstup24=$hvstup;$hvstup25=$hvstupz;$hvstup26=$hvstup;
$hvstup27=$hvstupz;$hvstup28=$hvstup;$hvstup29=$hvstupz;$hvstup30=$hvstup;$hvstup31=$hvstupz;


$t01x="";$t02x="";$t03x="";$t04x="";$t05x="";$t06x="";$t07x="";$t08x="";$t09x="";$t10x="";
$t11x="";$t12x="";$t13x="";$t14x="";$t15x="";$t16x="";$t17x="";$t18x="";$t19x="";$t20x="";
$t21x="";$t22x="";$t23x="";$t24x="";$t25x="";$t26x="";$t27x="";$t28x="";$t29x="";$t30x="";$t31x="";


if( $polozka->d01x > 0 ) { $t01x="D"; $hvstup01="hvstup_zelene";  }
if( $polozka->d02x > 0 ) { $t02x="D"; $hvstup02="hvstup_zelene";  }
if( $polozka->d03x > 0 ) { $t03x="D"; $hvstup03="hvstup_zelene";  }
if( $polozka->d04x > 0 ) { $t04x="D"; $hvstup04="hvstup_zelene";  }
if( $polozka->d05x > 0 ) { $t05x="D"; $hvstup05="hvstup_zelene";  }
if( $polozka->d06x > 0 ) { $t06x="D"; $hvstup06="hvstup_zelene";  }
if( $polozka->d07x > 0 ) { $t07x="D"; $hvstup07="hvstup_zelene";  }
if( $polozka->d08x > 0 ) { $t08x="D"; $hvstup08="hvstup_zelene";  }
if( $polozka->d09x > 0 ) { $t09x="D"; $hvstup09="hvstup_zelene";  }
if( $polozka->d10x > 0 ) { $t10x="D"; $hvstup10="hvstup_zelene";  }
if( $polozka->d11x > 0 ) { $t11x="D"; $hvstup11="hvstup_zelene";  }
if( $polozka->d12x > 0 ) { $t12x="D"; $hvstup12="hvstup_zelene";  }
if( $polozka->d13x > 0 ) { $t13x="D"; $hvstup13="hvstup_zelene";  }
if( $polozka->d14x > 0 ) { $t14x="D"; $hvstup14="hvstup_zelene";  }
if( $polozka->d15x > 0 ) { $t15x="D"; $hvstup15="hvstup_zelene";  }
if( $polozka->d16x > 0 ) { $t16x="D"; $hvstup16="hvstup_zelene";  }
if( $polozka->d17x > 0 ) { $t17x="D"; $hvstup17="hvstup_zelene";  }
if( $polozka->d18x > 0 ) { $t18x="D"; $hvstup18="hvstup_zelene";  }
if( $polozka->d19x > 0 ) { $t19x="D"; $hvstup19="hvstup_zelene";  }
if( $polozka->d20x > 0 ) { $t20x="D"; $hvstup20="hvstup_zelene";  }
if( $polozka->d21x > 0 ) { $t21x="D"; $hvstup21="hvstup_zelene";  }
if( $polozka->d22x > 0 ) { $t22x="D"; $hvstup22="hvstup_zelene";  }
if( $polozka->d23x > 0 ) { $t23x="D"; $hvstup23="hvstup_zelene";  }
if( $polozka->d24x > 0 ) { $t24x="D"; $hvstup24="hvstup_zelene";  }
if( $polozka->d25x > 0 ) { $t25x="D"; $hvstup25="hvstup_zelene";  }
if( $polozka->d26x > 0 ) { $t26x="D"; $hvstup26="hvstup_zelene";  }
if( $polozka->d27x > 0 ) { $t27x="D"; $hvstup27="hvstup_zelene";  }
if( $polozka->d28x > 0 ) { $t28x="D"; $hvstup28="hvstup_zelene";  }
if( $polozka->d29x > 0 ) { $t29x="D"; $hvstup29="hvstup_zelene";  }
if( $polozka->d30x > 0 ) { $t30x="D"; $hvstup30="hvstup_zelene";  }
if( $polozka->d31x > 0 ) { $t31x="D"; $hvstup31="hvstup_zelene";  }

if( $polozka->l01x > 0 ) { $t01x="L"; $hvstup01="hvstup_modre";  }
if( $polozka->l02x > 0 ) { $t02x="L"; $hvstup02="hvstup_modre";  }
if( $polozka->l03x > 0 ) { $t03x="L"; $hvstup03="hvstup_modre";  }
if( $polozka->l04x > 0 ) { $t04x="L"; $hvstup04="hvstup_modre";  }
if( $polozka->l05x > 0 ) { $t05x="L"; $hvstup05="hvstup_modre";  }
if( $polozka->l06x > 0 ) { $t06x="L"; $hvstup06="hvstup_modre";  }
if( $polozka->l07x > 0 ) { $t07x="L"; $hvstup07="hvstup_modre";  }
if( $polozka->l08x > 0 ) { $t08x="L"; $hvstup08="hvstup_modre";  }
if( $polozka->l09x > 0 ) { $t09x="L"; $hvstup09="hvstup_modre";  }
if( $polozka->l10x > 0 ) { $t10x="L"; $hvstup10="hvstup_modre";  }
if( $polozka->l11x > 0 ) { $t11x="L"; $hvstup11="hvstup_modre";  }
if( $polozka->l12x > 0 ) { $t12x="L"; $hvstup12="hvstup_modre";  }
if( $polozka->l13x > 0 ) { $t13x="L"; $hvstup13="hvstup_modre";  }
if( $polozka->l14x > 0 ) { $t14x="L"; $hvstup14="hvstup_modre";  }
if( $polozka->l15x > 0 ) { $t15x="L"; $hvstup15="hvstup_modre";  }
if( $polozka->l16x > 0 ) { $t16x="L"; $hvstup16="hvstup_modre";  }
if( $polozka->l17x > 0 ) { $t17x="L"; $hvstup17="hvstup_modre";  }
if( $polozka->l18x > 0 ) { $t18x="L"; $hvstup18="hvstup_modre";  }
if( $polozka->l19x > 0 ) { $t19x="L"; $hvstup19="hvstup_modre";  }
if( $polozka->l20x > 0 ) { $t20x="L"; $hvstup20="hvstup_modre";  }
if( $polozka->l21x > 0 ) { $t21x="L"; $hvstup21="hvstup_modre";  }
if( $polozka->l22x > 0 ) { $t22x="L"; $hvstup22="hvstup_modre";  }
if( $polozka->l23x > 0 ) { $t23x="L"; $hvstup23="hvstup_modre";  }
if( $polozka->l24x > 0 ) { $t24x="L"; $hvstup24="hvstup_modre";  }
if( $polozka->l25x > 0 ) { $t25x="L"; $hvstup25="hvstup_modre";  }
if( $polozka->l26x > 0 ) { $t26x="L"; $hvstup26="hvstup_modre";  }
if( $polozka->l27x > 0 ) { $t27x="L"; $hvstup27="hvstup_modre";  }
if( $polozka->l28x > 0 ) { $t28x="L"; $hvstup28="hvstup_modre";  }
if( $polozka->l29x > 0 ) { $t29x="L"; $hvstup29="hvstup_modre";  }
if( $polozka->l30x > 0 ) { $t30x="L"; $hvstup30="hvstup_modre";  }
if( $polozka->l31x > 0 ) { $t31x="L"; $hvstup31="hvstup_modre";  }


if( $polozka->o01x > 0 ) { $t01x="O"; $hvstup01="hvstup_hnede";  }
if( $polozka->o02x > 0 ) { $t02x="O"; $hvstup02="hvstup_hnede";  }
if( $polozka->o03x > 0 ) { $t03x="O"; $hvstup03="hvstup_hnede";  }
if( $polozka->o04x > 0 ) { $t04x="O"; $hvstup04="hvstup_hnede";  }
if( $polozka->o05x > 0 ) { $t05x="O"; $hvstup05="hvstup_hnede";  }
if( $polozka->o06x > 0 ) { $t06x="O"; $hvstup06="hvstup_hnede";  }
if( $polozka->o07x > 0 ) { $t07x="O"; $hvstup07="hvstup_hnede";  }
if( $polozka->o08x > 0 ) { $t08x="O"; $hvstup08="hvstup_hnede";  }
if( $polozka->o09x > 0 ) { $t09x="O"; $hvstup09="hvstup_hnede";  }
if( $polozka->o10x > 0 ) { $t10x="O"; $hvstup10="hvstup_hnede";  }
if( $polozka->o11x > 0 ) { $t11x="O"; $hvstup11="hvstup_hnede";  }
if( $polozka->o12x > 0 ) { $t12x="O"; $hvstup12="hvstup_hnede";  }
if( $polozka->o13x > 0 ) { $t13x="O"; $hvstup13="hvstup_hnede";  }
if( $polozka->o14x > 0 ) { $t14x="O"; $hvstup14="hvstup_hnede";  }
if( $polozka->o15x > 0 ) { $t15x="O"; $hvstup15="hvstup_hnede";  }
if( $polozka->o16x > 0 ) { $t16x="O"; $hvstup16="hvstup_hnede";  }
if( $polozka->o17x > 0 ) { $t17x="O"; $hvstup17="hvstup_hnede";  }
if( $polozka->o18x > 0 ) { $t18x="O"; $hvstup18="hvstup_hnede";  }
if( $polozka->o19x > 0 ) { $t19x="O"; $hvstup19="hvstup_hnede";  }
if( $polozka->o20x > 0 ) { $t20x="O"; $hvstup20="hvstup_hnede";  }
if( $polozka->o21x > 0 ) { $t21x="O"; $hvstup21="hvstup_hnede";  }
if( $polozka->o22x > 0 ) { $t22x="O"; $hvstup22="hvstup_hnede";  }
if( $polozka->o23x > 0 ) { $t23x="O"; $hvstup23="hvstup_hnede";  }
if( $polozka->o24x > 0 ) { $t24x="O"; $hvstup24="hvstup_hnede";  }
if( $polozka->o25x > 0 ) { $t25x="O"; $hvstup25="hvstup_hnede";  }
if( $polozka->o26x > 0 ) { $t26x="O"; $hvstup26="hvstup_hnede";  }
if( $polozka->o27x > 0 ) { $t27x="O"; $hvstup27="hvstup_hnede";  }
if( $polozka->o28x > 0 ) { $t28x="O"; $hvstup28="hvstup_hnede";  }
if( $polozka->o29x > 0 ) { $t29x="O"; $hvstup29="hvstup_hnede";  }
if( $polozka->o30x > 0 ) { $t30x="O"; $hvstup30="hvstup_hnede";  }
if( $polozka->o31x > 0 ) { $t31x="O"; $hvstup31="hvstup_hnede";  }


if( $polozka->n01x > 0 ) { $t01x="N"; $hvstup01="hvstup_sede";  }
if( $polozka->n02x > 0 ) { $t02x="N"; $hvstup02="hvstup_sede";  }
if( $polozka->n03x > 0 ) { $t03x="N"; $hvstup03="hvstup_sede";  }
if( $polozka->n04x > 0 ) { $t04x="N"; $hvstup04="hvstup_sede";  }
if( $polozka->n05x > 0 ) { $t05x="N"; $hvstup05="hvstup_sede";  }
if( $polozka->n06x > 0 ) { $t06x="N"; $hvstup06="hvstup_sede";  }
if( $polozka->n07x > 0 ) { $t07x="N"; $hvstup07="hvstup_sede";  }
if( $polozka->n08x > 0 ) { $t08x="N"; $hvstup08="hvstup_sede";  }
if( $polozka->n09x > 0 ) { $t09x="N"; $hvstup09="hvstup_sede";  }
if( $polozka->n10x > 0 ) { $t10x="N"; $hvstup10="hvstup_sede";  }
if( $polozka->n11x > 0 ) { $t11x="N"; $hvstup11="hvstup_sede";  }
if( $polozka->n12x > 0 ) { $t12x="N"; $hvstup12="hvstup_sede";  }
if( $polozka->n13x > 0 ) { $t13x="N"; $hvstup13="hvstup_sede";  }
if( $polozka->n14x > 0 ) { $t14x="N"; $hvstup14="hvstup_sede";  }
if( $polozka->n15x > 0 ) { $t15x="N"; $hvstup15="hvstup_sede";  }
if( $polozka->n16x > 0 ) { $t16x="N"; $hvstup16="hvstup_sede";  }
if( $polozka->n17x > 0 ) { $t17x="N"; $hvstup17="hvstup_sede";  }
if( $polozka->n18x > 0 ) { $t18x="N"; $hvstup18="hvstup_sede";  }
if( $polozka->n19x > 0 ) { $t19x="N"; $hvstup19="hvstup_sede";  }
if( $polozka->n20x > 0 ) { $t20x="N"; $hvstup20="hvstup_sede";  }
if( $polozka->n21x > 0 ) { $t21x="N"; $hvstup21="hvstup_sede";  }
if( $polozka->n22x > 0 ) { $t22x="N"; $hvstup22="hvstup_sede";  }
if( $polozka->n23x > 0 ) { $t23x="N"; $hvstup23="hvstup_sede";  }
if( $polozka->n24x > 0 ) { $t24x="N"; $hvstup24="hvstup_sede";  }
if( $polozka->n25x > 0 ) { $t25x="N"; $hvstup25="hvstup_sede";  }
if( $polozka->n26x > 0 ) { $t26x="N"; $hvstup26="hvstup_sede";  }
if( $polozka->n27x > 0 ) { $t27x="N"; $hvstup27="hvstup_sede";  }
if( $polozka->n28x > 0 ) { $t28x="N"; $hvstup28="hvstup_sede";  }
if( $polozka->n29x > 0 ) { $t29x="N"; $hvstup29="hvstup_sede";  }
if( $polozka->n30x > 0 ) { $t30x="N"; $hvstup30="hvstup_sede";  }
if( $polozka->n31x > 0 ) { $t31x="N"; $hvstup31="hvstup_sede";  }

if( $polozka->a01x > 0 ) { $t01x="A"; $hvstup01="hvstup_cervene";  }
if( $polozka->a02x > 0 ) { $t02x="A"; $hvstup02="hvstup_cervene";  }
if( $polozka->a03x > 0 ) { $t03x="A"; $hvstup03="hvstup_cervene";  }
if( $polozka->a04x > 0 ) { $t04x="A"; $hvstup04="hvstup_cervene";  }
if( $polozka->a05x > 0 ) { $t05x="A"; $hvstup05="hvstup_cervene";  }
if( $polozka->a06x > 0 ) { $t06x="A"; $hvstup06="hvstup_cervene";  }
if( $polozka->a07x > 0 ) { $t07x="A"; $hvstup07="hvstup_cervene";  }
if( $polozka->a08x > 0 ) { $t08x="A"; $hvstup08="hvstup_cervene";  }
if( $polozka->a09x > 0 ) { $t09x="A"; $hvstup09="hvstup_cervene";  }
if( $polozka->a10x > 0 ) { $t10x="A"; $hvstup10="hvstup_cervene";  }
if( $polozka->a11x > 0 ) { $t11x="A"; $hvstup11="hvstup_cervene";  }
if( $polozka->a12x > 0 ) { $t12x="A"; $hvstup12="hvstup_cervene";  }
if( $polozka->a13x > 0 ) { $t13x="A"; $hvstup13="hvstup_cervene";  }
if( $polozka->a14x > 0 ) { $t14x="A"; $hvstup14="hvstup_cervene";  }
if( $polozka->a15x > 0 ) { $t15x="A"; $hvstup15="hvstup_cervene";  }
if( $polozka->a16x > 0 ) { $t16x="A"; $hvstup16="hvstup_cervene";  }
if( $polozka->a17x > 0 ) { $t17x="A"; $hvstup17="hvstup_cervene";  }
if( $polozka->a18x > 0 ) { $t18x="A"; $hvstup18="hvstup_cervene";  }
if( $polozka->a19x > 0 ) { $t19x="A"; $hvstup19="hvstup_cervene";  }
if( $polozka->a20x > 0 ) { $t20x="A"; $hvstup20="hvstup_cervene";  }
if( $polozka->a21x > 0 ) { $t21x="A"; $hvstup21="hvstup_cervene";  }
if( $polozka->a22x > 0 ) { $t22x="A"; $hvstup22="hvstup_cervene";  }
if( $polozka->a23x > 0 ) { $t23x="A"; $hvstup23="hvstup_cervene";  }
if( $polozka->a24x > 0 ) { $t24x="A"; $hvstup24="hvstup_cervene";  }
if( $polozka->a25x > 0 ) { $t25x="A"; $hvstup25="hvstup_cervene";  }
if( $polozka->a26x > 0 ) { $t26x="A"; $hvstup26="hvstup_cervene";  }
if( $polozka->a27x > 0 ) { $t27x="A"; $hvstup27="hvstup_cervene";  }
if( $polozka->a28x > 0 ) { $t28x="A"; $hvstup28="hvstup_cervene";  }
if( $polozka->a29x > 0 ) { $t29x="A"; $hvstup29="hvstup_cervene";  }
if( $polozka->a30x > 0 ) { $t30x="A"; $hvstup30="hvstup_cervene";  }
if( $polozka->a31x > 0 ) { $t31x="A"; $hvstup31="hvstup_cervene";  }


if( $polozka->v01x > 0 ) { $t01x="V"; $hvstup01="hvstup_orange";  }
if( $polozka->v02x > 0 ) { $t02x="V"; $hvstup02="hvstup_orange";  }
if( $polozka->v03x > 0 ) { $t03x="V"; $hvstup03="hvstup_orange";  }
if( $polozka->v04x > 0 ) { $t04x="V"; $hvstup04="hvstup_orange";  }
if( $polozka->v05x > 0 ) { $t05x="V"; $hvstup05="hvstup_orange";  }
if( $polozka->v06x > 0 ) { $t06x="V"; $hvstup06="hvstup_orange";  }
if( $polozka->v07x > 0 ) { $t07x="V"; $hvstup07="hvstup_orange";  }
if( $polozka->v08x > 0 ) { $t08x="V"; $hvstup08="hvstup_orange";  }
if( $polozka->v09x > 0 ) { $t09x="V"; $hvstup09="hvstup_orange";  }
if( $polozka->v10x > 0 ) { $t10x="V"; $hvstup10="hvstup_orange";  }
if( $polozka->v11x > 0 ) { $t11x="V"; $hvstup11="hvstup_orange";  }
if( $polozka->v12x > 0 ) { $t12x="V"; $hvstup12="hvstup_orange";  }
if( $polozka->v13x > 0 ) { $t13x="V"; $hvstup13="hvstup_orange";  }
if( $polozka->v14x > 0 ) { $t14x="V"; $hvstup14="hvstup_orange";  }
if( $polozka->v15x > 0 ) { $t15x="V"; $hvstup15="hvstup_orange";  }
if( $polozka->v16x > 0 ) { $t16x="V"; $hvstup16="hvstup_orange";  }
if( $polozka->v17x > 0 ) { $t17x="V"; $hvstup17="hvstup_orange";  }
if( $polozka->v18x > 0 ) { $t18x="V"; $hvstup18="hvstup_orange";  }
if( $polozka->v19x > 0 ) { $t19x="V"; $hvstup19="hvstup_orange";  }
if( $polozka->v20x > 0 ) { $t20x="V"; $hvstup20="hvstup_orange";  }
if( $polozka->v21x > 0 ) { $t21x="V"; $hvstup21="hvstup_orange";  }
if( $polozka->v22x > 0 ) { $t22x="V"; $hvstup22="hvstup_orange";  }
if( $polozka->v23x > 0 ) { $t23x="V"; $hvstup23="hvstup_orange";  }
if( $polozka->v24x > 0 ) { $t24x="V"; $hvstup24="hvstup_orange";  }
if( $polozka->v25x > 0 ) { $t25x="V"; $hvstup25="hvstup_orange";  }
if( $polozka->v26x > 0 ) { $t26x="V"; $hvstup26="hvstup_orange";  }
if( $polozka->v27x > 0 ) { $t27x="V"; $hvstup27="hvstup_orange";  }
if( $polozka->v28x > 0 ) { $t28x="V"; $hvstup28="hvstup_orange";  }
if( $polozka->v29x > 0 ) { $t29x="V"; $hvstup29="hvstup_orange";  }
if( $polozka->v30x > 0 ) { $t30x="V"; $hvstup30="hvstup_orange";  }
if( $polozka->v31x > 0 ) { $t31x="V"; $hvstup31="hvstup_orange";  }

if( $polozka->i01x > 0 ) { $t01x="I"; $hvstup01="hvstup_pink";  }
if( $polozka->i02x > 0 ) { $t02x="I"; $hvstup02="hvstup_pink";  }
if( $polozka->i03x > 0 ) { $t03x="I"; $hvstup03="hvstup_pink";  }
if( $polozka->i04x > 0 ) { $t04x="I"; $hvstup04="hvstup_pink";  }
if( $polozka->i05x > 0 ) { $t05x="I"; $hvstup05="hvstup_pink";  }
if( $polozka->i06x > 0 ) { $t06x="I"; $hvstup06="hvstup_pink";  }
if( $polozka->i07x > 0 ) { $t07x="I"; $hvstup07="hvstup_pink";  }
if( $polozka->i08x > 0 ) { $t08x="I"; $hvstup08="hvstup_pink";  }
if( $polozka->i09x > 0 ) { $t09x="I"; $hvstup09="hvstup_pink";  }
if( $polozka->i10x > 0 ) { $t10x="I"; $hvstup10="hvstup_pink";  }
if( $polozka->i11x > 0 ) { $t11x="I"; $hvstup11="hvstup_pink";  }
if( $polozka->i12x > 0 ) { $t12x="I"; $hvstup12="hvstup_pink";  }
if( $polozka->i13x > 0 ) { $t13x="I"; $hvstup13="hvstup_pink";  }
if( $polozka->i14x > 0 ) { $t14x="I"; $hvstup14="hvstup_pink";  }
if( $polozka->i15x > 0 ) { $t15x="I"; $hvstup15="hvstup_pink";  }
if( $polozka->i16x > 0 ) { $t16x="I"; $hvstup16="hvstup_pink";  }
if( $polozka->i17x > 0 ) { $t17x="I"; $hvstup17="hvstup_pink";  }
if( $polozka->i18x > 0 ) { $t18x="I"; $hvstup18="hvstup_pink";  }
if( $polozka->i19x > 0 ) { $t19x="I"; $hvstup19="hvstup_pink";  }
if( $polozka->i20x > 0 ) { $t20x="I"; $hvstup20="hvstup_pink";  }
if( $polozka->i21x > 0 ) { $t21x="I"; $hvstup21="hvstup_pink";  }
if( $polozka->i22x > 0 ) { $t22x="I"; $hvstup22="hvstup_pink";  }
if( $polozka->i23x > 0 ) { $t23x="I"; $hvstup23="hvstup_pink";  }
if( $polozka->i24x > 0 ) { $t24x="I"; $hvstup24="hvstup_pink";  }
if( $polozka->i25x > 0 ) { $t25x="I"; $hvstup25="hvstup_pink";  }
if( $polozka->i26x > 0 ) { $t26x="I"; $hvstup26="hvstup_pink";  }
if( $polozka->i27x > 0 ) { $t27x="I"; $hvstup27="hvstup_pink";  }
if( $polozka->i28x > 0 ) { $t28x="I"; $hvstup28="hvstup_pink";  }
if( $polozka->i29x > 0 ) { $t29x="I"; $hvstup29="hvstup_pink";  }
if( $polozka->i30x > 0 ) { $t30x="I"; $hvstup30="hvstup_pink";  }
if( $polozka->i31x > 0 ) { $t31x="I"; $hvstup31="hvstup_pink";  }

if( $polozka->m01x > 0 ) { $t01x="M"; $hvstup01="hvstup_magenta";  }
if( $polozka->m02x > 0 ) { $t02x="M"; $hvstup02="hvstup_magenta";  }
if( $polozka->m03x > 0 ) { $t03x="M"; $hvstup03="hvstup_magenta";  }
if( $polozka->m04x > 0 ) { $t04x="M"; $hvstup04="hvstup_magenta";  }
if( $polozka->m05x > 0 ) { $t05x="M"; $hvstup05="hvstup_magenta";  }
if( $polozka->m06x > 0 ) { $t06x="M"; $hvstup06="hvstup_magenta";  }
if( $polozka->m07x > 0 ) { $t07x="M"; $hvstup07="hvstup_magenta";  }
if( $polozka->m08x > 0 ) { $t08x="M"; $hvstup08="hvstup_magenta";  }
if( $polozka->m09x > 0 ) { $t09x="M"; $hvstup09="hvstup_magenta";  }
if( $polozka->m10x > 0 ) { $t10x="M"; $hvstup10="hvstup_magenta";  }
if( $polozka->m11x > 0 ) { $t11x="M"; $hvstup11="hvstup_magenta";  }
if( $polozka->m12x > 0 ) { $t12x="M"; $hvstup12="hvstup_magenta";  }
if( $polozka->m13x > 0 ) { $t13x="M"; $hvstup13="hvstup_magenta";  }
if( $polozka->m14x > 0 ) { $t14x="M"; $hvstup14="hvstup_magenta";  }
if( $polozka->m15x > 0 ) { $t15x="M"; $hvstup15="hvstup_magenta";  }
if( $polozka->m16x > 0 ) { $t16x="M"; $hvstup16="hvstup_magenta";  }
if( $polozka->m17x > 0 ) { $t17x="M"; $hvstup17="hvstup_magenta";  }
if( $polozka->m18x > 0 ) { $t18x="M"; $hvstup18="hvstup_magenta";  }
if( $polozka->m19x > 0 ) { $t19x="M"; $hvstup19="hvstup_magenta";  }
if( $polozka->m20x > 0 ) { $t20x="M"; $hvstup20="hvstup_magenta";  }
if( $polozka->m21x > 0 ) { $t21x="M"; $hvstup21="hvstup_magenta";  }
if( $polozka->m22x > 0 ) { $t22x="M"; $hvstup22="hvstup_magenta";  }
if( $polozka->m23x > 0 ) { $t23x="M"; $hvstup23="hvstup_magenta";  }
if( $polozka->m24x > 0 ) { $t24x="M"; $hvstup24="hvstup_magenta";  }
if( $polozka->m25x > 0 ) { $t25x="M"; $hvstup25="hvstup_magenta";  }
if( $polozka->m26x > 0 ) { $t26x="M"; $hvstup26="hvstup_magenta";  }
if( $polozka->m27x > 0 ) { $t27x="M"; $hvstup27="hvstup_magenta";  }
if( $polozka->m28x > 0 ) { $t28x="M"; $hvstup28="hvstup_magenta";  }
if( $polozka->m29x > 0 ) { $t29x="M"; $hvstup29="hvstup_magenta";  }
if( $polozka->m30x > 0 ) { $t30x="M"; $hvstup30="hvstup_magenta";  }
if( $polozka->m31x > 0 ) { $t31x="M"; $hvstup31="hvstup_magenta";  }

if( $polozka->s01x > 0 ) { $t01x="S"; $hvstup01="hvstup_zelene";  }
if( $polozka->s02x > 0 ) { $t02x="S"; $hvstup02="hvstup_zelene";  }
if( $polozka->s03x > 0 ) { $t03x="S"; $hvstup03="hvstup_zelene";  }
if( $polozka->s04x > 0 ) { $t04x="S"; $hvstup04="hvstup_zelene";  }
if( $polozka->s05x > 0 ) { $t05x="S"; $hvstup05="hvstup_zelene";  }
if( $polozka->s06x > 0 ) { $t06x="S"; $hvstup06="hvstup_zelene";  }
if( $polozka->s07x > 0 ) { $t07x="S"; $hvstup07="hvstup_zelene";  }
if( $polozka->s08x > 0 ) { $t08x="S"; $hvstup08="hvstup_zelene";  }
if( $polozka->s09x > 0 ) { $t09x="S"; $hvstup09="hvstup_zelene";  }
if( $polozka->s10x > 0 ) { $t10x="S"; $hvstup10="hvstup_zelene";  }
if( $polozka->s11x > 0 ) { $t11x="S"; $hvstup11="hvstup_zelene";  }
if( $polozka->s12x > 0 ) { $t12x="S"; $hvstup12="hvstup_zelene";  }
if( $polozka->s13x > 0 ) { $t13x="S"; $hvstup13="hvstup_zelene";  }
if( $polozka->s14x > 0 ) { $t14x="S"; $hvstup14="hvstup_zelene";  }
if( $polozka->s15x > 0 ) { $t15x="S"; $hvstup15="hvstup_zelene";  }
if( $polozka->s16x > 0 ) { $t16x="S"; $hvstup16="hvstup_zelene";  }
if( $polozka->s17x > 0 ) { $t17x="S"; $hvstup17="hvstup_zelene";  }
if( $polozka->s18x > 0 ) { $t18x="S"; $hvstup18="hvstup_zelene";  }
if( $polozka->s19x > 0 ) { $t19x="S"; $hvstup19="hvstup_zelene";  }
if( $polozka->s20x > 0 ) { $t20x="S"; $hvstup20="hvstup_zelene";  }
if( $polozka->s21x > 0 ) { $t21x="S"; $hvstup21="hvstup_zelene";  }
if( $polozka->s22x > 0 ) { $t22x="S"; $hvstup22="hvstup_zelene";  }
if( $polozka->s23x > 0 ) { $t23x="S"; $hvstup23="hvstup_zelene";  }
if( $polozka->s24x > 0 ) { $t24x="S"; $hvstup24="hvstup_zelene";  }
if( $polozka->s25x > 0 ) { $t25x="S"; $hvstup25="hvstup_zelene";  }
if( $polozka->s26x > 0 ) { $t26x="S"; $hvstup26="hvstup_zelene";  }
if( $polozka->s27x > 0 ) { $t27x="S"; $hvstup27="hvstup_zelene";  }
if( $polozka->s28x > 0 ) { $t28x="S"; $hvstup28="hvstup_zelene";  }
if( $polozka->s29x > 0 ) { $t29x="S"; $hvstup29="hvstup_zelene";  }
if( $polozka->s30x > 0 ) { $t30x="S"; $hvstup30="hvstup_zelene";  }
if( $polozka->s31x > 0 ) { $t31x="S"; $hvstup31="hvstup_zelene";  }

?>


<?php $kli_den="1.".$kli_vume; ?>
<td class="<?php echo $hvstup01; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t01x;?></td>

<?php $kli_den="2.".$kli_vume; ?>
<td class="<?php echo $hvstup02; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t02x;?></td>

<?php $kli_den="3.".$kli_vume; ?>
<td class="<?php echo $hvstup03; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t03x;?></td>

<?php $kli_den="4.".$kli_vume; ?>
<td class="<?php echo $hvstup04; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t04x;?></td>

<?php $kli_den="5.".$kli_vume; ?>
<td class="<?php echo $hvstup05; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t05x;?></td>

<?php $kli_den="6.".$kli_vume; ?>
<td class="<?php echo $hvstup06; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t06x;?></td>

<?php $kli_den="7.".$kli_vume; ?>
<td class="<?php echo $hvstup07; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t07x;?></td>

<?php $kli_den="8.".$kli_vume; ?>
<td class="<?php echo $hvstup08; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t08x;?></td>

<?php $kli_den="9.".$kli_vume; ?>
<td class="<?php echo $hvstup09; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t09x;?></td>

<?php $kli_den="10.".$kli_vume; ?>
<td class="<?php echo $hvstup10; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t10x;?></td>

<?php $kli_den="11.".$kli_vume; ?>
<td class="<?php echo $hvstup11; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t11x;?></td>

<?php $kli_den="12.".$kli_vume; ?>
<td class="<?php echo $hvstup12; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t12x;?></td>

<?php $kli_den="13.".$kli_vume; ?>
<td class="<?php echo $hvstup13; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t13x;?></td>

<?php $kli_den="14.".$kli_vume; ?>
<td class="<?php echo $hvstup14; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t14x;?></td>

<?php $kli_den="15.".$kli_vume; ?>
<td class="<?php echo $hvstup15; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t15x;?></td>

<?php $kli_den="16.".$kli_vume; ?>
<td class="<?php echo $hvstup16; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t16x;?></td>

<?php $kli_den="17.".$kli_vume; ?>
<td class="<?php echo $hvstup17; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t17x;?></td>

<?php $kli_den="18.".$kli_vume; ?>
<td class="<?php echo $hvstup18; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t18x;?></td>

<?php $kli_den="19.".$kli_vume; ?>
<td class="<?php echo $hvstup19; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t19x;?></td>

<?php $kli_den="20.".$kli_vume; ?>
<td class="<?php echo $hvstup20; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t20x;?></td>

<?php $kli_den="21.".$kli_vume; ?>
<td class="<?php echo $hvstup21; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t21x;?></td>

<?php $kli_den="22.".$kli_vume; ?>
<td class="<?php echo $hvstup22; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t22x;?></td>

<?php $kli_den="23.".$kli_vume; ?>
<td class="<?php echo $hvstup23; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t23x;?></td>

<?php $kli_den="24.".$kli_vume; ?>
<td class="<?php echo $hvstup24; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t24x;?></td>

<?php $kli_den="25.".$kli_vume; ?>
<td class="<?php echo $hvstup25; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t25x;?></td>

<?php $kli_den="26.".$kli_vume; ?>
<td class="<?php echo $hvstup26; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t26x;?></td>

<?php $kli_den="27.".$kli_vume; ?>
<td class="<?php echo $hvstup27; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t27x;?></td>

<?php $kli_den="28.".$kli_vume; ?>
<td class="<?php echo $hvstup28; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t28x;?></td>


<?php if( $pocetdni > 28 ) { ?>
<?php $kli_den="29.".$kli_vume; ?>
<td class="<?php echo $hvstup29; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t29x;?></td>

<?php } ?> 
<?php if( $pocetdni > 29 ) { ?>
<?php $kli_den="30.".$kli_vume; ?>
<td class="<?php echo $hvstup30; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t30x;?></td>

<?php } ?> 
<?php if( $pocetdni > 30 ) { ?>
<?php $kli_den="31.".$kli_vume; ?>
<td class="<?php echo $hvstup31; ?>" align="center" 
 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $polozka->uva;?>');" ><?php echo $t31x;?></td>

<?php } ?> 
</tr>

<?php                           } ?>





<?php
}



$i = $i + 1;
$j = $j + 1;
  }

//koniec poloziek

?>

</table>
<br /><br />

<table>
<tr>
<FORM name='fhiden' method='post' action='#' >
<input type='hidden' name='ocold' id='ocold' value='0' >
<input type='hidden' name='datodold' id='datodold' value='0' >
</FORM></tr></table> 

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$zmenume=1; $odkaz="../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0";
$cislista = include("mzd_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
