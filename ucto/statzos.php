<!doctype html>
<html>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=102200;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;
if (!isset($kli_vduj)) $kli_vduj = 1;

       do
       {
//cislo operacie
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

if ( $kli_vrok < 2016 )
{
?>
<script type="text/javascript">
  var okno = window.open("../ucto/statzos2015.php?copern=1&drupoh=1&page=1&sysx=UCT", "_self");
</script>
<?php
exit;
}

$rozuct = $_REQUEST['rozuct'];
if (!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if (!isset($sysx)) $sysx = 'INE';
if ( $sysx == 'UCT' ) $rozuct="ANO";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$dajstatvyk=1;
if ( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) { $dajstatvyk=0; }

$dajfinvykazy=0;
$volajfin1a12=1;
if ( $kli_nezis == 1 ) { $dajfinvykazy=1; $volajfin1a12=1; }
if ( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $dajfinvykazy=1; $volajfin1a12=0; }
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $dajfinvykazy=1; }
if ( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) { $dajfinvykazy=0; }

$dajhlaodpad=0;
if ( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) { $dajhlaodpad=1; }
if ( $_SERVER['SERVER_NAME'] == "www.zerotax.sk" ) { $dajhlaodpad=1; }
if ( $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" ) { $dajhlaodpad=1; }
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $dajhlaodpad=1; }

$tlacodpady=1;
if ( $_SERVER['SERVER_NAME'] == "www.enposro.sk" )
{
if ( $kli_uzid != 17 AND $kli_uzid != 23 AND $kli_uzid != 57 AND $kli_uzid != 58 AND $kli_uzid != 141 AND $kli_uzid != 164 ) { $tlacodpady=0; }
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css">
<title>ätatistika a v˝kaznÌctvo</title>
<style type="text/css">
body {
  min-width: 900px;
  font-family: Arial, sans-serif;
}
strong {
  font-weight: bold;
}
div.wrap-heading {
  overflow: auto;
  width: 98%;
  padding: 0 1%;
  background-color: #ffff90;
  -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
div.ilogin {
  font-size: 11px;
  background-color:;
  height: 11px;
  padding-top: 4px;
}
div.ilogin strong {
  margin-left: 6px;
  margin-right: 3px;
}
div.heading {
  height: 36px;
  overflow: hidden;
}
div.heading > h1 {
  line-height: 36px;
  font-size: 20px;
  font-weight: bold;
  font-family: Times, 'Times New Roman', Georgia, serif;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 12px;
  position: relative;
  top: 14px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
div.content {
  margin-top: 14px;
  width: 100%;
}
div.line-area {
  overflow: auto;
  width: 97%;
  height: 32px;
  margin: 0 auto 4px auto;
  background-color: #fff;
  padding: 4px;
  border-radius: 3px;
  clear: left;
}
.line-box-text {
  width: 660px;
  height: 32px;
  line-height: 32px;
  padding-left: 4px;
  font-size: 12px;
}
.line-box-text > div {
  float: left;
  margin-right: 12px;
}
.line-box-text > div > strong {
  font-size: 14px;
  color: #424242;
}
.line-box-text > div > strong > span {
  font-weight: normal;
  margin-left: 4px;
}
.line-box-text > div > select {
  display: block;
  margin-top: 5px;
  font-size: 12px;
  padding: 2px;
}
.line-box-text > div > label {
  display: block;
  float: left;
  margin-right: 4px;
  line-height: 34px;
}
.line-box-text > div input[type=text] {
  display: block;
  float: left;
  width: 75px;
  margin-top: 5px;
  padding: 2px 0;
  font-size: 12px;
  text-indent: 4px;
}
div.line-box {
  margin-right: 4px;
  width: 32px;
  height: 32px;
}
img.line-box {
  width: 16px;
  height: 16px;
  opacity: 1;
  padding: 8px;
  cursor: pointer;
  border-radius: 3px;
  margin: 0 2px;
}
img.line-box:hover {
  opacity: 0.8;
}
body, .box-bluedefault {
  background-color: #add8e6;
}
.box-blue {
  background-color: #5fb3ce;
}
.box-brown {
  background-color: #bcaaa4;
}
.box-green {
  background-color:#a5d6a7;
}
.box-lightblue {
  background-color:#90caf9;
}
.box-red {
  background-color:#ef9a9a;
}
.toleft {
  float: left;
}
.toright {
  float: right;
}
.btn-text {
  border: 0;
  box-sizing: border-box;
  color: #39f;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  height: 32px;
  line-height: 32px;
  /*min-width: 64px;*/
  padding: 0 8px;
  text-align: center;
  text-transform: uppercase;
  /*vertical-align: middle;*/
  background-color: transparent;
  border-radius: 2px;
  margin: 0 2px;
}
.btn-text:hover {
  background-color: rgba(158,158,158,.2);
}
</style>
<script type="text/javascript">


//suhrnny DPH
  function TlacSuhrn()
  {
   var h_oc = document.forms.formp3.h_oc.value;
   var h_fmzdy = 0;
   var h_drp = document.forms.formp3.h_drp.value;
   var h_dap = document.forms.formp3.h_dap.value;
   window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=È',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function SuborSuhrn()
  {
   var h_oc = document.forms.formp3.h_oc.value;
   var h_fmzdy = 0;
   var h_drp = document.forms.formp3.h_drp.value;
   var h_dap = document.forms.formp3.h_dap.value;
   window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=2',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravSuhrn()
  {
   var h_oc = document.forms.formp3.h_oc.value;
   var h_fmzdy = 0;
   window.open('../ucto/suhrn_dph.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }


//vykaz Hlaodpad
<?php
$rokodpad="";
if ( $kli_vrok < 2016 ) $rokodpad="_2015";
?>
  function TlacHlaodpad()
  {
<?php if ( $tlacodpady == 1 ) { ?>
   var h_oc = document.forms.formhlaodpad.h_oc.value;
   var h_kmd = document.forms.formhlaodpad.h_kmd.value;
   var h_zos = document.forms.formhlaodpad.h_zos.value;
   var h_fmzdy = 0;
   window.open('../ucto/vykaz_hlaodpad<?php echo $rokodpad; ?>.php?stvrtrok=' + h_oc + '&h_kmd=' + h_kmd + '&h_zos=' + h_zos + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                         } ?>
  }
  function UpravHlaodpad()
  {
   var h_oc = document.forms.formhlaodpad.h_oc.value;
   var h_kmd = document.forms.formhlaodpad.h_kmd.value;
   var h_fmzdy = 0;
   window.open('../ucto/vykaz_hlaodpad<?php echo $rokodpad; ?>.php?stvrtrok=' + h_oc + '&h_kmd=' + h_kmd + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&zaciatok=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
  function HelpHlaodpad()
  {
   window.open('../dokumenty/vykazy2010/navod_hlasenie.pdf',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function XLSHlaodpad()
  {
   window.open('../dokumenty/vykazy2010/xls_hlasenie.rar',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//vykaz E(MZSR)1-04
<?php
$roke104="";
if ( $kli_vrok < 2017 ) $roke104="_2016";
?>
  function Emzsr104Uprav()
  {
   window.open('../ucto/statistika_e104<?php echo $roke104; ?>.php?copern=1&drupoh=1&page=1', '_blank');
  }

//statistika 1304
<?php
$rok1304="";
if ( $kli_vrok < 2017 ) $rok1304="_2016";
if ( $kli_vrok < 2016 ) $rok1304="_2015";
if ( $kli_vrok < 2014 ) $rok1304="_2013";
if ( $kli_vrok < 2012 ) $rok1304="_2011";
?>
  function stat1304()
  {
   window.open('../ucto/statistika_p1304<?php echo $rok1304; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

<?php
$rokopu112="";
if ( $kli_vrok < 2017 ) $rokopu112="_2016";
if ( $kli_vrok < 2016 ) $rokopu112="_2015";
if ( $kli_vrok < 2014 ) $rokopu112="_2013";
?>
  function statOPU112()
  {
   window.open('../ucto/statistika_opu112<?php echo $rokopu112; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//statistika 304
<?php
$rok304="";
if ( $kli_vrok < 2017 ) $rok304="_2016";
if ( $kli_vrok < 2016 ) $rok304="_2015";
if ( $kli_vrok < 2014 ) $rok304="_2013";
if ( $kli_vrok < 2013 ) $rok304="_2012";
?>
  function stat304()
  {
   window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//statistika vts112
<?php
$rokvts112="";
if ( $kli_vrok < 2017 ) $rokvts112="_2016";
if ( $kli_vrok < 2016 ) $rokvts112="_2015";
if ( $kli_vrok < 2014 ) $rokvts112="_2013";
?>
  function statvts112()
  {
   window.open('../ucto/statistika_vts112<?php echo $rokvts112; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//statistika vts101
<?php
$rokvts101="";
if ( $kli_vrok < 2016 ) $rokvts101="_2015";
if ( $kli_vrok < 2015 ) $rokvts101="_2014";
?>
  function statvts101()
  {
   window.open('../ucto/statistika_vts101<?php echo $rokvts101; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//statistika vts201
<?php
$rokvts201="";
if ( $kli_vrok < 2016 ) $rokvts201="_2015";
if ( $kli_vrok < 2015 ) $rokvts201="_2014";
?>
  function statvts201()
  {
   window.open('../ucto/statistika_vts201<?php echo $rokvts201; ?>.php?copern=1&drupoh=1&page=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

//opu201
<?php
$rokopu201="";
if( $kli_vrok < 2016 ) $rokopu201="_2015";
if( $kli_vrok < 2015 ) $rokopu201="_2014";
?>

function statopu201()
                {

window.open('../ucto/statistika_opu201<?php echo $rokopu201; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//ikap201
<?php
$rokikap201="";
?>

function statikap201()
                {

window.open('../ucto/statistika_ikap201<?php echo $rokikap201; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//statistika zav101
<?php
$rokzav101="";
if( $kli_vrok < 2016 ) $rokzav101="_2015";
if( $kli_vrok < 2015 ) $rokzav101="_2014";
?>

function statzav101()
                {

window.open('../ucto/statistika_zav101<?php echo $rokzav101; ?>.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

//vykazy FinNUJ 2013
<?php if( $kli_vrok >= 2013 ) { ?>





//vykaz Fin204no16
<?php
$rokfin204no="_2016";
?>

function TlacFin204no16()
                {
var h_oc = document.forms.formfin204no16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204no<?php echo $rokfin204no; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204no16()
                {
var h_oc = document.forms.formfin204no16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204no<?php echo $rokfin204no; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204no16()
                {
var h_oc = document.forms.formfin204no16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204no<?php echo $rokfin204no; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin204pod
<?php
$rokfin204pod="_2016";
if( $kli_vrok >= 2018 ) { $rokfin204pod="_2018"; }
?>

function TlacFin204pod16()
                {
var h_oc = document.forms.formfin204pod16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod<?php echo $rokfin204pod; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin204pod16()
                {
var h_oc = document.forms.formfin204pod16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod<?php echo $rokfin204pod; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin204pod16()
                {
var h_oc = document.forms.formfin204pod16.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin204pod<?php echo $rokfin204pod; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin304
<?php
$rokfin304="_2016";
?>

function TlacFin304()
                {
var h_oc = document.forms.formfin304.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin304<?php echo $rokfin304; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin304()
                {
var h_oc = document.forms.formfin304.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin304<?php echo $rokfin304; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin304()
                {
var h_oc = document.forms.formfin304.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin304<?php echo $rokfin304; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin404
<?php
$rokfin404="_2016";
?>

function TlacFin404()
                {
var h_oc = document.forms.formfin404.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin404<?php echo $rokfin304; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin404()
                {
var h_oc = document.forms.formfin404.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin404<?php echo $rokfin404; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin404()
                {
var h_oc = document.forms.formfin404.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin404<?php echo $rokfin404; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin504
<?php
$rokfin504="_2016";
?>


function TlacFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin504<?php echo $rokfin504; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin504<?php echo $rokfin504; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//vykaz Fin604
<?php
$rokfin604="_2016";
?>

function TlacFin604()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin604<?php echo $rokfin604; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin604()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin604<?php echo $rokfin604; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin604()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin604<?php echo $rokfin604; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin704
<?php
$rokfin704="_2016";
?>

function TlacFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704<?php echo $rokfin704; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704<?php echo $rokfin704; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin704<?php echo $rokfin704; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//DBF

function DbfFin112()
                {
var h_oc = document.forms.formfin112.h_oc.value;
var h_fmzdy = 0;


window.open('fin112dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



function DbfFin204no16()
                {
var h_oc = document.forms.formfin204no16.h_oc.value;
var h_fmzdy = 0;


window.open('fin204nodbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin204pod16()
                {
var h_oc = document.forms.formfin204pod16.h_oc.value;
var h_fmzdy = 0;


window.open('fin204poddbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin204pod16()
                {
var h_oc = document.forms.formfin204pod16.h_oc.value;
var h_fmzdy = 0;

window.open('vykaz_fin204pod_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin304()
                {
var h_oc = document.forms.formfin304.h_oc.value;
var h_fmzdy = 0;


window.open('fin304dbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin304()
                {
var h_oc = document.forms.formfin304.h_oc.value;
var h_fmzdy = 0;

window.open('vykaz_fin304_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin404()
                {
var h_oc = document.forms.formfin404.h_oc.value;
var h_fmzdy = 0;


window.open('fin404dbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin404()
                {
var h_oc = document.forms.formfin404.h_oc.value;
var h_fmzdy = 0;

window.open('vykaz_fin404_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;


window.open('fin504dbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin504()
                {
var h_oc = document.forms.formfin504.h_oc.value;
var h_fmzdy = 0;

window.open('vykaz_fin504_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin604()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;


window.open('fin604dbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin604()
                {
var h_oc = document.forms.formfin604.h_oc.value;
var h_fmzdy = 0;

window.open('vykaz_fin604_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin704()
                {
var h_oc = document.forms.formfin704.h_oc.value;
var h_fmzdy = 0;


window.open('fin704dbf_2016.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//vykaz Fin1a12
<?php
$rokfin112="_2016";
?>

function TlacFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('../ucto/vykaz_fin112<?php echo $rokfin112; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&elsubor=0&fin1a12=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112<?php echo $rokfin112; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&fin1a12=1&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;

window.open('../ucto/vykaz_fin112<?php echo $rokfin112; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0&fin1a12=1&strana=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('vykaz_fin112_csv.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DbfFin1a12()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('fin1a12dbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function DbfFin112nujpod()
                {
var h_oc = document.forms.formfin1a12.h_oc.value;
var h_fmzdy = 0;


window.open('fin112nujpoddbf.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


<?php                        } ?>
//koniec vykazy FIN NUJ 2013

<?php
$cislo_stvrtrok=1;
if( $kli_vmes > 3 ) { $cislo_stvrtrok=2; }
if( $kli_vmes > 6 ) { $cislo_stvrtrok=3; }
if( $kli_vmes > 9 ) { $cislo_stvrtrok=4; }
?>

function VyberVstup()
                {

<?php  if( $dajfinvykazy == 1 ) { ?>
        document.forms.formfin1a12.h_oc.value='<?php echo $kli_vmes; ?>';
        document.forms.formfin204no16.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin204pod16.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin304.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin404.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin504.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin604.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
        document.forms.formfin704.h_oc.value='<?php echo $cislo_stvrtrok; ?>';

<?php                           } ?>
<?php  if( $dajstatvyk == 1 ) { ?>

<?php                         } ?>
<?php  if( $dajhlaodpad == 1 ) { ?>
        document.forms.formhlaodpad.h_oc.value='<?php echo $cislo_stvrtrok; ?>';
<?php                          } ?>

                }



</script>
</head>
<body onload="VyberVstup();" >
<!-- zahlavie -->
<div class="wrap-heading">
 <div class="ilogin">
  <h6 class="toleft">EuroSecom</h6>
  <h6 class="toright">
   <strong>UME</strong><?php echo $kli_vume; ?>
   <strong>FIR</strong><?php echo "$kli_vxcf:$kli_nxcf"; ?>
   <strong>login</strong><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid"; ?>
  </h6>
 </div>
 <div class="heading">
  <h1 class="toleft">ätatistika a v˝kaznÌctvo</h1>
  <dl class="toright legend-area">
 	 <dt class="toleft box-blue"></dt><dd class="toleft">Zobraziù v pdf</dd>
	 <dt class="toleft box-brown"></dt><dd class="toleft">Nastaviù</dd>
	 <dt class="toleft box-green"></dt><dd class="toleft">Upraviù</dd>
	 <dt class="toleft box-red"></dt><dd class="toleft">Export</dd>
	 <dt class="toleft box-lightblue"></dt><dd class="toleft">NaËÌtaù</dd>
  </dl>
 </div>
</div> <!-- .wrap-heading -->

<div class="content">
<?php $dnes = Date("d.m.Y", MkTime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>

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

<?php
//VYKAZY STATISTICKE
if ( $dajstatvyk == 1 )
{
?>
<!-- suhrnny dph -->
<div class="line-area" style="margin-bottom:8px;">
<form name="formp3" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacSuhrn();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>S˙hrnn˝ v˝kaz DPH</strong>
 <img src="../obr/info.png" title="SVDPH verzia 10_1">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadny</option>
  <option value="2">Opravn˝</option>
  <option value="3">DodatoËn˝</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven˝:</label>
 <input type="text" name="h_dap" id="h_dap" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
  <option value="5">mesaËn˝ <?php echo $kli_vume; ?></option>
 </select>
</div>
</div>
<img src='../obr/export.png' onclick="SuborSuhrn();" title="Export do XML" class="toleft line-box box-red">
</form>
</div> <!-- .line-area suhrnny dph -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>VTS 1-12<span>MesaËn˝ v˝kaz vo vybran˝ch trhov˝ch sluûb·ch</span></strong>
 <img src="../obr/info.png" title="VTS 1-12 verzia 2016">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statvts112();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area" style="margin-bottom:8px;">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>OPU 1-12<span>MesaËn˝ v˝kaz v obchode, pohostinstve a v ubytovanÌ</span></strong>
 <img src="../obr/info.png" title="OPU 1-12 verzia 2016">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statOPU112();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>E (MZSR) 1-04<span>ätvrùroËn˝ v˝kaz o ekonomike organiz·ciÌ v zdravotnÌctve pre NO</span></strong>
 <img src="../obr/info.png" title="E(MZSR) 1-04">
</div>
</div>
<img src='../obr/zoznam.png' onclick="Emzsr104Uprav();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Prod 13-04<span>ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ v mal˝ch podnikoch</span></strong>
 <img src="../obr/info.png" title="Prod 13-04 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="stat1304();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area" style="margin-bottom:8px;">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Prod 3-04<span>ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ</span></strong>
 <img src="../obr/info.png" title="Prod 3-04 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="stat304();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>RoË IKaP 2-01<span>RoËn˝ v˝kaz produkËn˝ch odvetvÌ v mal˝ch podnikoch v inform·ci·ch, komunik·cii...</span></strong>
 <img src="../obr/info.png" title="RoË IKaP 2-01 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statikap201();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>RoË OPU 2-01<span>RoËn˝ v˝kaz produkËn˝ch odvetvÌ v mal˝ch podnikoch v obchode, pohostinstve ...</span></strong>
 <img src="../obr/info.png" title="RoË OPU 2-01 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statopu201();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>RoË VTS 1-01<span>RoËn˝ v˝kaz produkËn˝ch odvetvÌ vo vybran˝ch trhov˝ch sluûb·ch</span></strong>
 <img src="../obr/info.png" title="RoË VTS 1-01 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statvts101();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>RoË VTS 2-01<span>RoËn˝ v˝kaz produkËn˝ch odvetvÌ v mal˝ch podnikoch vo vybr. trhov˝ch sluûb·ch</span></strong>
 <img src="../obr/info.png" title="RoË VTS 2-01 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statvts201();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->

<div class="line-area" style="margin-bottom:8px;">
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>RoË ZAV 1-01<span>RoËn˝ z·vodn˝ v˝kaz produkËn˝ch odvetvÌ</span></strong>
 <img src="../obr/info.png" title="RoË ZAV 1-01 verzia <?php echo $kli_vrok; ?>">
</div>
</div>
<img src='../obr/zoznam.png' onclick="statzav101();" title="Upraviù hodnoty" class="toleft line-box box-green">
</div> <!-- .line-area -->
<?php
}
?>

<?php
//VYKAZY FIN NUJ rok 2016
if ( $dajfinvykazy == 1 )
{
?>
<div class="line-area"> <!-- fin 1-12 -->
<form name="formfin1a12" method="post" action="#">
<?php
$nazfin1a12="FIN 1-12";
?>
<img src='../obr/tlac.png' onclick="TlacFin1a12();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 1-12<span>FinanËn˝ v˝kaz o prÌjmoch, v˝davkoch a finanËn˝ch oper·ci·ch</span></strong>
 <img src="../obr/info.png" title="<?php echo $nazfin1a12; ?> verzia 2018">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.<?php echo $kli_vrok; ?></option>
  <option value="2">2.<?php echo $kli_vrok; ?></option>
  <option value="3">3.<?php echo $kli_vrok; ?></option>
  <option value="4">4.<?php echo $kli_vrok; ?></option>
  <option value="5">5.<?php echo $kli_vrok; ?></option>
  <option value="6">6.<?php echo $kli_vrok; ?></option>
  <option value="7">7.<?php echo $kli_vrok; ?></option>
  <option value="8">8.<?php echo $kli_vrok; ?></option>
  <option value="9">9.<?php echo $kli_vrok; ?></option>
  <option value="10">10.<?php echo $kli_vrok; ?></option>
  <option value="11">11.<?php echo $kli_vrok; ?></option>
  <option value="12">12.<?php echo $kli_vrok; ?></option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin1a12();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=98&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
<?php if ( $kli_vrok < 2016 ) { ?>
  <button type="button" onclick="DbfFin1a12();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php                         } ?>
<?php if ( $kli_vrok >= 2016 AND $kli_vrok < 2018 ) { ?>
  <button type="button" onclick="DbfFin112nujpod();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php                          } ?>
<?php
$nedaj=0;
if ( $nedaj == 0 ) { ?>
  <button type="button" onclick="CsvFin1a12();" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php              } ?>
<img src='../obr/zoznam.png' onclick="UpravFin1a12();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area fin 1-12 -->

<?php if ( $kli_vrok < 2018 ) { ?>
<div class="line-area">
<form name="formfin204no16" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin204no16();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 2-04 NO<span>FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a z pasÌv</span></strong>
 <img src="../obr/info.png" title="FIN 2-04 NO verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin204no16();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=92&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin204no16();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin204no16();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->
<?php } ?>

<div class="line-area">
<form name="formfin204pod16" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin204pod16();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 2-04 <span>FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a z pasÌv</span></strong>
 <img src="../obr/info.png" title="FIN 2-04 verzia<?php echo $rokfin204pod; ?>">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin204pod16();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=91&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin204pod16();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="CsvFin204pod16()" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin204pod16();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->

<div class="line-area">
<form name="formfin304" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin304();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 3-04<span>FinanËn˝ v˝kaz o finanËn˝ch aktÌvach podæa sektorov</span></strong>
 <img src="../obr/info.png" title="FIN 3-04 verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin304();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=93&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin304();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="CsvFin304();" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin304();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->

<div class="line-area">
<form name="formfin404" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin404();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 4-04<span>FinanËn˝ v˝kaz o finanËn˝ch pasÌvach podæa sektorov</span></strong>
 <img src="../obr/info.png" title="FIN 4-04 verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin404();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=94&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin404();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="CsvFin404();" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin404();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->

<div class="line-area">
<form name="formfin504" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin504();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 5-04<span>FinanËn˝ v˝kaz o dlhov˝ch n·strojoch a vybran˝ch z·v‰zkoch</span></strong>
 <img src="../obr/info.png" title="FIN 5-04 verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<div class="toleft line-box"></div>
<div class="toleft line-box"></div>
  <button type="button" onclick="DbfFin504();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="CsvFin504();" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin504();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->

<?php
if ( $kli_vrok >= 2013 ) {
?>
<div class="line-area">
<form name="formfin604" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin604();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 6-04<span>FinanËn˝ v˝kaz o bankov˝ch ˙Ëtoch a z·v‰zkoch</span></strong>
 <img src="../obr/info.png" title="FIN 6-04 verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin604();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=96&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin604();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="CsvFin604();" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin604();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->

<div class="line-area" style="margin-bottom">
<form name="formfin704" method="post" action="#">
<img src='../obr/tlac.png' onclick="TlacFin704();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<div class="toleft line-box-text">
<div>
 <strong>FIN 7-04<span>FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z ˙ËtovnÌctva</span></strong>
 <img src="../obr/info.png" title="FIN 7-04 verzia 2016">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
</div>
<img src='../obr/vlozit.png' onclick="ZnovuFin704();" title="NaËÌtaù ˙daje" class="toleft line-box box-lightblue">
<img src='../obr/naradie.png' onclick="window.open('../ucto/fin_cis.php?copern=308&drupoh=97&page=1&sysx=UCT', '_blank');"
     title="Nastaviù generovanie" class="toleft line-box box-brown">
  <button type="button" onclick="DbfFin704();" title="Export do DBF" class="btn-text toleft">DBF</button>
<?php if ( $kli_vrok >= 2017 ) { ?>
  <button type="button" onclick="" title="Export do CSV" class="btn-text toleft">CSV</button>
<?php } ?>
<img src='../obr/zoznam.png' onclick="UpravFin704();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->
<?php
                         }
?>
<?php
//KONIEC VYKAZY FIN NUJ rok2016
}
?>

<?php
if( $dajhlaodpad == 1 ) {
?>
<div class="line-area">
<form name="formhlaodpad" method="post" action="#">
<?php if ( $tlacodpady == 1 ) { ?>
<img src='../obr/tlac.png' onclick="TlacHlaodpad();" title="Zobraziù v PDF" class="toleft line-box box-blue">
<?php                         } ?>
<div class="toleft line-box-text" style="width:900px;">
<div>
 <strong>Hl·senie<span>o objeme v˝roby, dovozu, v˝vozu a reexportu</span></strong>
 <img src="../obr/info.png" title="">
</div>
<div>
 <select size="1" name="h_oc" id="h_oc">
  <option value="1">1.ötvrùrok</option>
  <option value="2">2.ötvrùrok</option>
  <option value="3">3.ötvrùrok</option>
  <option value="4">4.ötvrùrok</option>
 </select>
</div>
<div>
 <label for="h_zos">Podpis:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_kmd">Komodita:</label>
 <select size="1" name="h_kmd" id="h_kmd">
  <option value="0">vöetky komodity</option>
  <option value="1">obaly z papiera</option>
  <option value="2">obaly z plastov</option>
  <option value="3">obaly z kovu Al</option>
  <option value="4">obaly z kovu Fe</option>
  <option value="5">obaly zo skla</option>
  <option value="6">viacvrstv.obaly</option>
  <option value="7">elektroz. tr1</option>
  <option value="8">elektroz. tr2</option>
  <option value="9">elektroz. tr3</option>
  <option value="10">elektroz. tr4</option>
  <option value="11">elektroz. tr5 sv.zdroje</option>
  <option value="12">elektroz. tr6</option>
  <option value="13">elektroz. tr7</option>
  <option value="14">elektroz. tr8</option>
  <option value="15">elektroz. tr9</option>
  <option value="16">batÈrie pren.</option>
  <option value="17">batÈrie priem.</option>
  <option value="18">batÈrie auto</option>
  <option value="19">pneumatiky</option>
  <option value="20">oleje</option>
  <option value="21">sklo neobal</option>
  <option value="22">viacvr.mat.neobal</option>
  <option value="23">papier neobal</option>
  <option value="24">plast neobal</option>
  <option value="25">elektroz. tr5 svietidl·</option>
 </select>
</div>
</div>
<img src="../obr/info.png" onclick="HelpHlaodpad();" title="N·vod na obsluhu" class="toleft line-box box-bluedefault">
<img src="../obr/info.png" onclick="XLSHlaodpad();" title="XLS s˙bory pre offline nahr·vanie" class="toleft line-box box-bluedefault">
<div class="toleft line-box"></div>
<img src='../obr/zoznam.png' onclick="UpravHlaodpad();" title="Upraviù hodnoty" class="toleft line-box box-green">
</form>
</div> <!-- .line-area -->
<?php
$dajhlaodpad=0;
                        }
?>

</div> <!-- .content -->
<?php
//celkovy koniec dokumentu

$zmenume=1; $odkaz="../ucto/statzos.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("uct_lista_norm.php");
       } while(false);
?>
</body>
</html>