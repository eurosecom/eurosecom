<HTML>
<?php
$sys = 'UCT';
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

$tlacodpady=1;

if( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) 
{ 
if( $kli_uzid != 17 AND $kli_uzid != 23 AND $kli_uzid != 57 AND $kli_uzid != 58 AND $kli_uzid != 141 ) { $tlacodpady=0; }
}
$dajfinvykazy=0;
$volajfin1a12=1;
if( $kli_nezis == 1 ) { $dajfinvykazy=1; $volajfin1a12=1; }
if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $dajfinvykazy=1; $volajfin1a12=0; }
 
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

                }


function TlacPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;
var h_drp = document.forms.formp2.h_drp.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;
var h_drp = document.forms.formp2.h_drp.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;
var h_drp = document.forms.formp2.h_drp.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//suhrn DPH

function TlacSuhrn()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_fmzdy = 0;
var h_drp = document.forms.formp3.h_drp.value;
var h_dap = document.forms.formp3.h_dap.value;


window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function FDFSuhrn()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_fmzdy = 0;
var h_drp = document.forms.formp3.h_drp.value;
var h_dap = document.forms.formp3.h_dap.value;


window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function SuborSuhrn()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_fmzdy = 0;
var h_drp = document.forms.formp3.h_drp.value;
var h_dap = document.forms.formp3.h_dap.value;

window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravSuhrn()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuSuhrn()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPotvrdPrehlad()
                {
  var okno = window.open("../tmp/potvrdpreh<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

function TlacPotvrdSuhrn()
                {
  var okno = window.open("../tmp/potvrdsuhrn<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

//nahlasovacia povinnost

function TlacNahlas()
                {
  var h_oc = 0;
  var h_fmzdy = 0;

window.open('../ucto/nahlasovacia.php?cislo_oc=' + h_oc + '&copern=361&drupoh=45&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPodklad()
                {
  var h_oc = 0;
  var h_fmzdy = 0;

window.open('../ucto/nahlasovacia.php?cislo_oc=' + h_oc + '&copern=361&drupoh=45&fmzdy=' + h_fmzdy + '&page=1&subor=0&podklad=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravNahlas()
                {
  var h_oc = 0;
  var h_fmzdy = 0;

window.open('../ucto/nahlasovacia.php?cislo_oc=' + h_oc + '&copern=308&drupoh=45&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuNahlas()
                {
  var h_oc = 0;
  var h_fmzdy = 0;

window.open('../ucto/nahlasovacia.php?cislo_oc=' + h_oc + '&copern=358&drupoh=45&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



//vykazy FinNUJ 2012
<?php if( $kli_vrok < 2013 ) { ?>

//vykaz Fin104

function TlacFin104()
                {
var h_oc = document.forms.formfin104.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin104.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin104()
                {
var h_oc = document.forms.formfin104.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin104.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin104()
                {
var h_oc = document.forms.formfin104.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin104.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin204

function TlacFin204()
                {
var h_oc = document.forms.formfin204.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204()
                {
var h_oc = document.forms.formfin204.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204()
                {
var h_oc = document.forms.formfin204.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin601

function TlacFin601()
                {
var h_oc = document.forms.formfin601.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin601.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin601()
                {
var h_oc = document.forms.formfin601.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin601.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin704

function TlacFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin204NUJ

function TlacFin204nuj()
                {
var h_oc = document.forms.formfin204nuj.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj2012.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204nuj()
                {
var h_oc = document.forms.formfin204nuj.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj2012.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204nuj()
                {
var h_oc = document.forms.formfin204nuj.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj2012.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//DBF

function DbfFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;


window.open('fin7dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin204()
                {
var h_oc = document.forms.formfin204.h_oc.value;
var h_fmzdy = 0;


window.open('fin2dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin204nuj()
                {
var h_oc = document.forms.formfin204nuj.h_oc.value;
var h_fmzdy = 0;


window.open('fin2nujdbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin104()
                {
var h_oc = document.forms.formfin104.h_oc.value;
var h_fmzdy = 0;


window.open('fin1dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin601()
                {
var h_oc = document.forms.formfin601.h_oc.value;
var h_fmzdy = 0;


window.open('fin6dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                        } ?>
//koniec vykzy FIN NUJ 2012
    
//vykaz Hlaodpad

function TlacHlaodpad()
                {

<?php if( $tlacodpady == 1 ) { ?>

var h_oc = document.forms.formhlaodpad.h_oc.value;
var h_kmd = document.forms.formhlaodpad.h_kmd.value;
var h_zos = document.forms.formhlaodpad.h_zos.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_hlaodpad.php?stvrtrok=' + h_oc + '&h_kmd=' + h_kmd + '&h_zos=' + h_zos + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

                }


function UpravHlaodpad()
                {
var h_oc = document.forms.formhlaodpad.h_oc.value;
var h_kmd = document.forms.formhlaodpad.h_kmd.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_hlaodpad.php?stvrtrok=' + h_oc + '&h_kmd=' + h_kmd + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&zaciatok=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuHlaodpad()
                {
var h_oc = document.forms.formhlaodpad.h_oc.value;
var h_kmd = document.forms.formhlaodpad.h_kmd.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_hlaodpad.php?stvrtrok=' + h_oc + '&h_kmd=' + h_kmd + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function HelpHlaodpad()
                {

window.open('../dokumenty/vykazy2010/navod_hlasenie.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function XLSHlaodpad()
                {

window.open('../dokumenty/vykazy2010/xls_hlasenie.rar',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//statistika 1304
<?php
$rok1304="";
if( $kli_vrok < 2014 ) $rok1304="_2013";
if( $kli_vrok < 2012 ) $rok1304="_2011";
?>

function stat1304()
                {

window.open('../ucto/statistika_p1304<?php echo $rok1304; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

<?php
$rokopu112="";
if( $kli_vrok < 2016 ) $rokopu112="_2015";
if( $kli_vrok < 2014 ) $rokopu112="_2013";
?>

function statOPU112()
                {

window.open('../ucto/statistika_opu112<?php echo $rokopu112; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


//statistika 304
<?php
$rok304="";
if( $kli_vrok < 2013 ) $rok304="_2012";
if( $kli_vrok < 2014 ) $rok304="_2013";
?>

function stat304()
                {

window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//statistika vts112
<?php
$rokvts112="";
if( $kli_vrok < 2014 ) $rokvts112="_2013";
?>

function statvts112()
                {

window.open('../ucto/statistika_vts112<?php echo $rokvts112; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//statistika vts101
<?php
$rokvts101="";
?>

function statvts101()
                {

window.open('../ucto/statistika_vts101<?php echo $rokvts101; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//opu201
<?php
$rokopu201="";
?>

function statopu201()
                {

window.open('../ucto/statistika_opu201<?php echo $rokopu201; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//statistika zav101
<?php
$rokzav101="";
?>

function statzav101()
                {

window.open('../ucto/statistika_zav101<?php echo $rokzav101; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//vykazy FinNUJ 2013
<?php if( $kli_vrok >= 2013 ) { ?>

//vykaz Fin112

function TlacFin112()
                {
var h_oc = document.forms.formfin112.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin112()
                {
var h_oc = document.forms.formfin112.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin112()
                {
var h_oc = document.forms.formfin112.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin204NUJ13

function TlacFin204nuj13()
                {
var h_oc = document.forms.formfin204nuj13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204nuj13()
                {
var h_oc = document.forms.formfin204nuj13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204nuj13()
                {
var h_oc = document.forms.formfin204nuj13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204nuj.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin204POD13

function TlacFin204pod13()
                {
var h_oc = document.forms.formfin204pod13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204pod13()
                {
var h_oc = document.forms.formfin204pod13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204pod13()
                {
var h_oc = document.forms.formfin204pod13.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin504

function TlacFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin504.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin504.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin6a04

function TlacFin6a04()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin6a04.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function SetFin6a04()
                {
  window.open('../ucto/vykfin_cis.php?copern=308&drupoh=94', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



//DBF

function DbfFin112()
                {
var h_oc = document.forms.formfin112.h_oc.value;
var h_fmzdy = 0;


window.open('fin112dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



function DbfFin204nuj13()
                {
var h_oc = document.forms.formfin204nuj13.h_oc.value;
var h_fmzdy = 0;


window.open('fin204nujdbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin204pod13()
                {
var h_oc = document.forms.formfin204pod13.h_oc.value;
var h_fmzdy = 0;


window.open('fin204poddbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;


window.open('fin504dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin6a04()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin6a04.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0&dajdbf=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }


//vykaz Fin1a12

function TlacFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0&fin1a12=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&fin1a12=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&fin1a12=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('fin1a12csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('fin1a12dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                        } ?>
//koniec vykzy FIN NUJ 2013


</script>
</HEAD>
<BODY class="white" >

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


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?>





<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FinanËnÈ ˙ËtovnÌctvo - ätatistika a v˝kaznÌctvo</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php if( $kli_vrok < 2012 ) { ?>

<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">ätvrùroËn˝ Prehæad o zrazen˝ch a odveden˝ch preddavkoch dane z prÌjmu a daÚovom bonuse PREHLADv10_1

<select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadny</option>
<option value="2" >Opravn˝</option>
</select>

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

<a href="#" onClick="TlacPotvrdPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ Prehæadu" ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPrehlad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v prehæade' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPrehlad();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do prehæadu z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<?php                        } ?>

<?php
$versuh="09_1";
if( $kli_vrok > 2009 ) $versuh="10_1";
?>

<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacSuhrn();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË vo form·te PDF - len pre inform·ciu musÌte tlaËiù z FDF alebo z WEBu www.drsr.sk' ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="FDFSuhrn();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='S˙bory FDF pre tlaË vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">S˙hrnn˝ v˝kaz DaÚ z pridanej hodnoty verzia SVDPHv<?php echo $versuh;?>
 <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadne</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
<option value="5" >mesaËn˝ <?php echo $kli_vume;?></option>
</select>

 <a href="#" onClick="TlacPotvrdSuhrn();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ S˙hrnnÈho v˝kazu" ></a>

<td class="bmenu" width="2%">
<a href="#" onClick="SuborSuhrn();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='XML s˙bor pre elektronick˙ komunik·ciu' ></a>
</td>

</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="stat1304();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu P 13-04" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ v mal˝ch podnikoch P13-04</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/statistika_e104.php?copern=1&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu E(MZ SR) 1-04" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - ätvrùroËn˝ v˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve pre neziskovÈ organiz·cie E(MZ SR) 1-04</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="stat304();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu Prod 3-04" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ Prod 3-04</td>
</tr>
</table>

<?php if( $kli_vrok < 2013 ) { ?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/statistika_r101.php?copern=1&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu RoË 1-01" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - RoËn˝ v˝kaz produkËn˝ch odvetvÌ RoË 1-01 pre 1 ZJ so skupinou modulov Fin, Zav a Prier VTS </td>
</tr>
</table>
<?php                        } ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statvts112();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu VTS 1-12" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - MESA»N› V›KAZ VO VYBRAN›CH TRHOV›CH SLUéB¡CH VTS 1-12</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statOPU112();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu OPU 1-12" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - MESA»N› V›KAZ v obchode, pohostinstve a v ubytovanÌ OPU 1-12</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statopu201();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu OPU 2-01" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - RO»N› V›KAZ produkËn˝ch odvetvÌ v mal˝ch podnikoch v obchode, pohostinstve a v ubytovanÌ OPU 2-01</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statvts101();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu VTS 1-01" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - RO»N› V›KAZ produkËn˝ch odvetvÌ vo vybran˝ch trhov˝ch sluûb·ch VTS 1-01</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="statzav101();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Vytvorenie ötatistickÈho v˝kazu VTS 1-01" ></a>
</td>
<td class="bmenu" width="90%">äTATISTIKA - RO»N› z·vodn˝ v˝kaz vo veæk˝ch podnikoch ZAV 1-01</td>
</tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formpn2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacNahlas();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Nahlasovacia povinnosù hotovostn˝ch platieb fyzick˝m osob·m
 <a href="#" onClick="TlacPodklad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù podklad vo form·te PDF' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravNahlas();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuNahlas();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<?php 
//VYKAZY FIN NUJ rok2012
if( $kli_vrok < 2013 ) { 
?>

<table class="vstup" width="100%" >
<FORM name="formfin104" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin104();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o plnenÌ rozpoËtu subjektu verejnej spr·vy FIN 1 - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin104();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin104();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin104();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formfin204" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin204();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a pasÌv subjektu verejnej spr·vy FIN 2 - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin204();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin204();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin204();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formfin204nuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin204nuj();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a pasÌv subjektu verejnej spr·vy FIN 2 - 04 NUJ
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin204nuj();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin204nuj();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin204nuj();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formfin601" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin601();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o ˙veroch, dlhopisoch, zmenk·ch a finanËnom pren·jme subjektu verejnej spr·vy FIN 6 - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin601();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin601();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">

</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formfin704" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin704();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o prÌrastku a ˙bytku vybran˝ch pohæad·vok a z·v‰zkov subjektu verejnej spr·vy FIN 7 - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>

<a href="#" onClick="DbfFin704();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin704();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin704();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<?php 
//KONIEC VYKAZY FIN NUJ rok2012
                       } 
?>


<?php 
//VYKAZY FIN NUJ rok2013
if( $kli_vrok >= 2013 AND $dajfinvykazy == 1 ) { 
?>

<table class="vstup" width="100%" >
<FORM name="formfin112" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin112();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o plnenÌ rozpoËtu a o nerozpoËtovan˝ch pohyboch na ˙Ëtoch subjektu verejnej spr·vy FIN 1 - 12
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin112();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin112();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin112();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formfin204nuj13" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin204nuj13();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a pasÌv subjektu verejnej spr·vy FIN 2 - 04 NUJ
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin204nuj13();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin204nuj13();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin204nuj13();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formfin204pod13" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin204pod13();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a pasÌv subjektu verejnej spr·vy FIN 2 - 04 POD
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin204pod13();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin204pod13();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin204pod13();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formfin504" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin504();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o ˙veroch, dlhopisoch, zmenk·ch a finanËnom pren·jme subjektu verejnej spr·vy FIN 5 - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin504();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin504();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">

</td>
</tr>
</FORM>
</table>

<?php 
if( $kli_vrok >= 2013 ) { 
?>

<table class="vstup" width="100%" >
<FORM name="formfin604" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin6a04();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz vybran˝ch ˙dajov z ˙ËtovnÌctva subjektu verejnej spr·vy FIN 6a - 04
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>
<a href="#" onClick="DbfFin6a04();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="SetFin6a04();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Hodnoty bezprostredne predch·dzaj˙ceho obdobia a generovanie v˝kazu' ></a>
</td>

<td class="bmenu" width="2%">

</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formfin1a12" class="obyc" method="post" action="#" >
<tr>
<?php
$nazfin1a12="FIN 1a - 12";
if( $volajfin1a12 == 0 ) { $nazfin1a12="FIN 1 - 12";}
?>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFin1a12();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">FinanËn˝ v˝kaz o plnenÌ rozpoËtu a o nerozpoËtovan˝ch pohyboch na ˙Ëtoch subjektu verejnej spr·vy <?php echo $nazfin1a12; ?>
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.<?php echo $kli_vrok; ?></option>
<option value="2" >2.<?php echo $kli_vrok; ?></option>
<option value="3" >3.<?php echo $kli_vrok; ?></option>
<option value="4" >4.<?php echo $kli_vrok; ?></option>
<option value="5" >5.<?php echo $kli_vrok; ?></option>
<option value="6" >6.<?php echo $kli_vrok; ?></option>
<option value="7" >7.<?php echo $kli_vrok; ?></option>
<option value="8" >8.<?php echo $kli_vrok; ?></option>
<option value="9" >9.<?php echo $kli_vrok; ?></option>
<option value="10" >10.<?php echo $kli_vrok; ?></option>
<option value="11" >11.<?php echo $kli_vrok; ?></option>
<option value="12" >12.<?php echo $kli_vrok; ?></option>
</select>
<a href="#" onClick="DbfFin1a12();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Import DBF s˙boru pre AZUV' ></a>
<?php
$nedaj=1; 
      if( $nedaj == 0 ) { ?>
<a href="#" onClick="CsvFin1a12();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export CSV s˙boru' ></a>
<?php                  } ?>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravFin1a12();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFin1a12();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty  - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<?php 
                        }
?>

<?php 
//KONIEC VYKAZY FIN NUJ rok2013
                       } 
?>



<table class="vstup" width="100%" >
<FORM name="formhlaodpad" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">

<?php if( $tlacodpady == 1 ) { ?>

<a href="#" onClick="TlacHlaodpad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>

<?php                        } ?>

</td>
<td class="bmenu" width="50%">HL¡SENIE o objeme v˝roby, dovozu, v˝vozu a reexportu
 <select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>

<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum podpisu: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

</td>

<td class="bmenu" width="48%">Komodita: 
 <select size="1" name="h_kmd" id="h_kmd" >
<option value="0" >vöetky komodity</option>
<option value="1" >obaly z papiera</option>

<option value="2" >obaly z plastov</option>

<option value="3" >obaly z kovu Al</option>

<option value="4" >obaly z kovu Fe</option>

<option value="5" >obaly zo skla</option>

<option value="6" >viacvrstv.obaly</option>

<option value="7" >elektroz. tr1</option>
<option value="8" >elektroz. tr2</option>
<option value="9" >elektroz. tr3</option>
<option value="10" >elektroz. tr4</option>
<option value="11" >elektroz. tr5 sv.zdroje</option>
<option value="12" >elektroz. tr6</option>
<option value="13" >elektroz. tr7</option>
<option value="14" >elektroz. tr8</option>
<option value="15" >elektroz. tr9</option>
<option value="16" >batÈrie pren.</option>
<option value="17" >batÈrie priem.</option>
<option value="18" >batÈrie auto</option>
<option value="19" >pneumatiky</option>
<option value="20" >oleje</option>
<option value="21" >sklo tovar</option>
<option value="22" >viacvrst.mat.</option>
<option value="23" >papier tovar</option>
<option value="24" >plasty tovar</option>
<option value="25" >elektroz. tr5 svietidl·</option>
</select>

<a href="#" onClick="HelpHlaodpad();">HELP
<img src='../obr/pdf.png' width=20 height=15 border=0 title='N·vod na obsluhu hl·senia' ></a>

<a href="#" onClick="XLSHlaodpad();">XLS
<img src='../obr/orig.png' width=20 height=15 border=0 title='XLS s˙bory pre nahr·vanie bez Internetu' ></a>

</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravHlaodpad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Nahr·vanie ˙dajov ' ></a>
</td>

</tr>
</FORM>
</table>


<br /><br />
<?php
// celkovy koniec dokumentu

$zmenume=1; $odkaz="../ucto/statzos.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
