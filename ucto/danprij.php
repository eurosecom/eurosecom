<!doctype html>
<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=100040;
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


if( $kli_vrok < 2015 )
{
?>
<script type="text/javascript">
  var okno = window.open("../ucto/danprij2014.php?copern=1&drupoh=1&page=1&sysx=UCT","_self");
</script>
<?php
exit;
}

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

if( $fir_uctx01 != 2 ) $fir_uctx01=1;

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

//nacitaj druh uj
$druhuj=" ";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druhuj=$riadok->tpuj;
  }
$ajmuj=1; $ajpod=1;
if( $druhuj == 1 OR $druhuj == 2 ) { $ajmuj=0; }
if( $druhuj == 3 ) { $ajpod=0; }

?> 
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
<title>EuroSecom - DaÚovÈ tlaËiv·</title>
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
.line-box {
  display: block;
  margin-right: 4px;
  width: 32px;
  height: 32px;
  opacity: 1;
  border-radius: 3px;

}
.line-box:hover {
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





.line-box-text {
  width: 630px;
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
  width: 80px;
  margin-top: 5px;
  padding: 2px 0;
  font-size: 12px;
  text-indent: 4px;
}



.line-box > img {
  margin: 8px;
  display: block;
  width: 16px;
  height: 16px;
}



.toleft {
  float: left;
}
.toright {
  float: right;
}
.unhidden {
  display: block;
}
.hidden {
  display: none;
}

</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

  function VyberVstupx()
  {
  }

  function VyberVstup()
  {
<?php if( $kli_vduj != 9 ) { echo "document.forms.formhk1.h_obdp.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 9 ) { echo "document.forms.formhk1.h_obdk.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 99 ) { echo "document.forms.formkf1.h_obdp.value=$kli_vmes; "; } ?>
<?php if( $kli_vduj != 99 ) { echo "document.forms.formkf1.h_obdk.value=$kli_vmes; "; } ?>
<?php echo "document.forms.formp1.fir_uctx01.value=$fir_uctx01; ";  ?>
<?php echo "document.forms.formg1.fir_uctx01.value=$fir_uctx01; ";  ?>
  }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }


function JUKnihaSumarnaPDF()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/jukniha.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF', '_blank', '<width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }


function TlacPotvrdDPH()
                {
  var okno = window.open("../tmp/potvrddph<?php echo $kli_vume; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//PRIZNANIE PO
<?php
$rokdppo=$kli_vrok;
if( $rokdppo < 2011 ) { $rokdppo="";  }
if( $rokdppo == 2011 ) { $rokdppo="2011";  }
if( $rokdppo == 2012 ) { $rokdppo="2012";  }
if( $rokdppo == 2013 ) { $rokdppo="2013";  }
if( $rokdppo >= 2014 ) { $rokdppo="2014";  }
?>

function TlacPriznanie()
                {
var h_oc = 0;

window.open('../ucto/priznanie_po<?php echo $rokdppo; ?>.php?copern=11&drupoh=1&page=1&typ=PDF&strana=999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPriznanie()
                {
var h_oc = 0;

window.open('../ucto/priznanie_po<?php echo $rokdppo; ?>.php?copern=101&drupoh=1&page=1&strana=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPriznanie()
                {
var h_oc = 0;

window.open('../ucto/priznanie_po<?php echo $rokdppo; ?>.php?copern=101&drupoh=1&page=1&strana=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }




function TlacPotvrdDPO()
                {
  var okno = window.open("../tmp/potvrddpo.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function POdoXML()
                {

window.open('../ucto/priznaniepo_xml<?php echo $rokdppo; ?>.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//priznanie FOB
<?php
$rokfob=$kli_vrok;
$skriptfob="../mzdy/priznanie_fob";
if( $rokfob < 2011 ) { $rokfob="";  }
if( $rokfob == 2011 ) { $rokfob="2011";  }
if( $rokfob == 2012 ) { $rokfob="2012";  }
if( $rokfob == 2013 ) { $rokfob="2013";  }
if( $rokfob >= 2014 ) { $rokfob="2014";  }
if( $rokfob >= 2011 ) { $skriptfob="../ucto/priznanie_fob"; }
?>


function TlacFOB()
                {
var h_oc = 9999;

window.open('<?php echo $skriptfob.$rokfob; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravFOB()
                {
var h_oc = 9999;

window.open('<?php echo $skriptfob.$rokfob; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0&prepocitaj=101',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFOB()
                {
var h_oc = 9999;

window.open('<?php echo $skriptfob.$rokfob; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&prepocitaj=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPotvrdFOB()
                {
  var okno = window.open("../tmp/potvrdfob<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function FOBdoXML()
                {

window.open('../ucto/priznaniefob_xml<?php echo $rokfob; ?>.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//poznamky 2013 podnikatelske

function TlacPoznamky2013()
                {
var h_zos = document.forms.formpoz13.h_zos.value;
var h_sch = document.forms.formpoz13.h_sch.value;

window.open('../ucto/poznamky_po2013tlac.php?cislo_oc=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NacitajPoznamky2013()
                {

window.open('../ucto/poznamky_po2013tlac.php?copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPoznamky2013()
                {

window.open('../ucto/poznamky_po2013.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPoznamky2013()
                {

window.open('../ucto/poznamky_po2013.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Poznamky2013doxml()
                {
var h_zos = document.forms.formpoz13.h_zos.value;
var h_sch = document.forms.formpoz13.h_sch.value;

window.open('../ucto/poznamky_po2013tlac.php?cislo_oc=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&copern=10&drupoh=1&page=9999&strana=9999&subor=0&urobxml=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Poznamky2013doxmlLENXML()
                {
var h_zos = document.forms.formpoz13.h_zos.value;
var h_sch = document.forms.formpoz13.h_sch.value;

window.open('../ucto/poznamky2013_xml.php?copern=110&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



//DMV
<?php
$rokdmv="";
if ( $kli_vrok >= 2013 ) { $rokdmv=2013; }
if ( $kli_vrok >= 2015 ) { $rokdmv=2015; }
?>

function TlacDMV()
                {

window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravDMV()
                {
var h_oc = 0;

window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=20&drupoh=1&page=1&strana=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPotvrdDMV()
                {
  var okno = window.open("../tmp/potvrddmv<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DMVdoXML()
                {

window.open('../ucto/priznaniedmv_xml<?php echo $rokdmv; ?>.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//poznamky 2011 neziskove org.
<?php
if( $kli_vrok  < 2013 ) { $poznuj="po2011no"; }
if( $kli_vrok >= 2013 ) { $poznuj="po2013nuj"; }
?>

function TlacPoznamky2011no()
                {
var h_zos = document.forms.formpoz11no.h_zos.value;
var h_sch = document.forms.formpoz11no.h_sch.value;
var h_oc = 0;

window.open('../ucto/poznamky_<?php echo $poznuj; ?>tlac.php?cislo_oc=' + h_oc + '&h_zos=' + h_zos + '&h_sch=' + h_sch + '&copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NacitajPoznamky2011no()
                {
var h_zos = document.forms.formpoz11no.h_zos.value;
var h_sch = document.forms.formpoz11no.h_sch.value;
var h_oc = 0;

window.open('../ucto/poznamky_<?php echo $poznuj; ?>tlac.php?copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPoznamky2011no()
                {
var h_oc = 0;

window.open('../ucto/poznamky_<?php echo $poznuj; ?>.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPoznamky2011no()
                {
var h_oc = 0;

window.open('../ucto/poznamky_<?php echo $poznuj; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Poznamky2011NOdoxml()
                {

window.open('../ucto/poznamky2013nuj_xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  function SynGenSuv()
  { 

window.open('../ucto/oprsys.php?copern=308&drupoh=44&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function GenSuvNo()
  { 

window.open('../ucto/oprcis.php?copern=308&drupoh=96&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }
 
function NechcemStranyPOD2013()
                {

window.open('../ucto/poznamky_podnopage.php?copern=101&page=1&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function platbyju()
                {

window.open('../ucto/platbyju.php?copern=1&page=1&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//OZNAMENIE O SCHVALENI 

function TlacOzUz()
                {

window.open('../ucto/uzavierka_oznamenie.php?copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravOzUz()
                {

window.open('../ucto/uzavierka_oznamenie.php?copern=20&drupoh=1&page=1&strana=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function OzUzdoXML()
                {

window.open('../ucto/uzavierka_oznameniexml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//VSEOBECNE PODANIE 

function TlacVseob()
                {

window.open('../ucto/vseobecne_podanie.php?copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravVseob()
                {

window.open('../ucto/vseobecne_podanie.php?copern=20&drupoh=1&page=1&strana=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function VseobdoXML()
                {

window.open('../ucto/vseobecne_podaniexml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
 
</script>
</HEAD>
<BODY onload="VyberVstupx();">

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
  <h1 class="toleft">DaÚ z prÌjmov</h1>
  <dl class="toright legend-area">
 	 <dt class="toleft box-blue"></dt>
	 <dd class="toleft">Zobraziù v pdf</dd>
	 <dt class="toleft box-brown"></dt>
	 <dd class="toleft">Nastaviù</dd>
	 <dt class="toleft box-green"></dt>
	 <dd class="toleft">Upraviù</dd>
	 <dt class="toleft box-red"></dt>
	 <dd class="toleft">Export</dd>
	 <dt class="toleft box-lightblue"></dt>
	 <dd class="toleft">NaËÌtaù</dd>
  </dl>
 </div>
</div> <!-- .wrap-heading -->

<div class="content">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>

<?php 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
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
//podvojne
if ( $copern == 1 AND $kli_vduj != 9 )
           {
?>
<?php
//POD 2014        
if ( $kli_vrok >= 2013 AND $ajpod == 1 )
{
?>

<script type="text/javascript">

function SuvahaPOD2014()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/suvaha_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=1&lenvzs=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaPOD2014()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/vykzis_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=0&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SuvahaPOD2014cele()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/suvaha_pod2014.php?copern=10&drupoh=1&tis=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=1&lenvzs=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaPOD2014cele()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/vykzis_pod2014.php?copern=10&drupoh=1&tis=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=0&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function KompletPOD2014()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/suvaha_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1&lensuv=1&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletPOD2014cele()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/suvaha_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1&tis=1&lensuv=1&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletPOD2014doxml()
                {
var h_zos = document.forms.formuzpod.h_zos.value;
var h_sch = document.forms.formuzpod.h_sch.value;
var h_drp = document.forms.formuzpod.h_drp.value;

window.open('../ucto/uzavierka_pod2014xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  function GenSuvPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=193', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GenVysPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=194', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function MinSuvPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=193', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function MinVysPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=194', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GesSuvPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=195', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function ZaokPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=196', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
</script>

<div class="line-area"> <!-- uct.zavierka pu -->
<FORM name="formuzpod" method="post" action="#">
<a href="#" onclick="KompletPOD2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="KompletPOD2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>⁄Ëtovn· z·vierka</strong>
 <img src="../obr/info.png" title="⁄Ë POD verzia 2014">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadna</option>
  <option value="2">Mimoriadna</option>
  <option value="3">Priebeûn·</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven·:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len·:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value=""/>
</div>
</div>
<a href="../dokumenty/vykazy_pu2014/pod2014/uzpod_v14_vysvetlivky.pdf" target="_blank"
   title="Vysvetlivky k ˙Ëtovnej z·vierke" class="toleft line-box box-bluedefault">
 <img src="../obr/info.png"></a> <!-- dopyt, in˝ obr·zok -->
<a href="#" onclick="GenSuvPod();" title="Nastavenie generovania, predch·dzaj˙ceho obdobia a zaokr˙hlenia"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a>
<a href="#" onclick="KompletPOD2014doxml();" title="Export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
</FORM>

<div class="toright" style="width:190px; margin-right:-4px;">
 <div class="toleft line-box-text" style="width:114px;">V˝kaz ziskov a str·t</div>
 <a href="#" onclick="VysledovkaPOD2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="VysledovkaPOD2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
</div>
<div class="toright" style="width:130px;">
 <div class="toleft line-box-text" style="width:50px;">S˙vaha</div>
 <a href="#" onclick="SuvahaPOD2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="SuvahaPOD2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
</div>
</div> <!-- .line-area uct.zavierka pu -->


<div class="line-area" style="margin-bottom:8px;"> <!-- poznamky pu -->
<?php
if ( $kli_vrok >= 2013 )
{
?>
<FORM name="formpoz13" method="post" action="#">
<a href="#" onclick="TlacPoznamky2013();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<?php
$textverzia="verzia 2013";
if ( $kli_vrok > 2013 ) { $textverzia="verzia ".$kli_vrok; }
?>
<div>
 <strong>Pozn·mky</strong>
 <img src="../obr/info.png" title="⁄Ë POD 3 - 01 k DPPO <?php echo $textverzia; ?>">
</div>
<div>
 <label for="h_zos">ZostavenÈ:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·lenÈ:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value="<?php echo $dnes; ?>"/>
</div>
</div>
<a href="#" onclick="NechcemStranyPOD2013();" title="Nastavenie str·n, ktorÈ nechcem tlaËiù"
   class="toleft line-box box-brown"><img src='../obr/zmaz.png'></a>
<a href="#" onclick="NacitajPoznamky2013();" title="NaËÌtaù ˙daje do pozn·mok"
   class="toleft line-box box-lightblue"><img src='../obr/vlozit.png'></a>
<a href="#" onclick="Poznamky2013doxml();" title="export do PDF"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravPoznamky2013();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
<?php
}
?>
</div> <!-- .line-area uct.poznamky pu -->
<?php
}
//koniec POD 2014
?>

<?php
//MUJ 2014
if ( $kli_vrok >= 2013 AND $ajmuj == 1 )
{
?>
<script type="text/javascript">
function SuvahaMUJ2014()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/suvaha_muj2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=1&lenvzs=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaMUJ2014()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/vykzis_muj2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=0&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SuvahaMUJ2014cele()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/suvaha_muj2014.php?copern=10&drupoh=1&tis=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=1&lenvzs=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaMUJ2014cele()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/vykzis_muj2014.php?copern=10&drupoh=1&tis=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&lensuv=0&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function KompletMUJ2014()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/suvaha_muj2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1&lensuv=1&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletMUJ2014cele()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/suvaha_muj2014.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1&tis=1&lensuv=1&lenvzs=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletMUJ2014doxml()
                {
var h_zos = document.forms.formuzmuj.h_zos.value;
var h_sch = document.forms.formuzmuj.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/uzavierka_muj2014xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  function GenSuvMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=93', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GenVysMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=94', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function MinSuvMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=93', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function MinVysMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=94', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GesSuvMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=95', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function ZaokMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=96', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


//poznamky MUJ 2014

function TlacPoznamkyMUJ2014()
                {
var h_zos = document.forms.formpozmuj14.h_zos.value;
var h_sch = document.forms.formpozmuj14.h_sch.value;
var h_drp = document.forms.formuzmuj.h_drp.value;

window.open('../ucto/poznamky_muj2014tlac.php?cislo_oc=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NacitajPoznamkyMUJ2014()
                {

window.open('../ucto/poznamky_muj2014tlac.php?copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPoznamkyMUJ2014()
                {

window.open('../ucto/poznamky_muj2014.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
</script>

<div class="line-area"> <!-- uct.zavierka muj -->
<FORM name="formuzmuj" method="post" action="#">
<a href="#" onclick="KompletMUJ2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="KompletMUJ2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>⁄Ëtovn· z·vierka M⁄J</strong>
 <img src="../obr/info.png" title="⁄Ë MUJ">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadna</option>
  <option value="2">Mimoriadna</option>
  <option value="3">Priebeûn·</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven·:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len·:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value=""/>
</div>
</div>
<a href="#" onclick="GenSuvMuj();" title="Nastavenie generovania, predch·dzaj˙ceho obdobia a zaokr˙hlenia"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a>
<a href="#" onclick="KompletMUJ2014doxml();" title="Export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
</FORM> <!-- dopyt, preveriù Ëi d·va d·tumy a typ do uz·vierok -->

<div class="toright" style="width:216px; margin-right:-4px;">
 <div class="toleft line-box-text" style="width:140px;">V˝kaz ziskov a str·t M⁄J</div>
 <a href="#" onclick="VysledovkaMUJ2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="VysledovkaMUJ2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
</div>
<div class="toright" style="width:158px;">
 <div class="toleft line-box-text" style="width:78px;">S˙vaha M⁄J</div>
 <a href="#" onclick="SuvahaMUJ2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="SuvahaMUJ2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
</div>
</div> <!-- .line-area uct.zavierka muj -->


<div class="line-area" style="margin-bottom:8px;"> <!-- poznamky muj -->
<FORM name="formpozmuj14" method="post" action="#">
<a href="#" onclick="TlacPoznamkyMUJ2014();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Pozn·mky M⁄J</strong>
 <img src="../obr/info.png" title="⁄Ë MUJ 3 - 01 k DPPO verzia 2014">
</div>
<div>
 <label for="h_zos">ZostavenÈ:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·lenÈ:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value="<?php echo $dnes; ?>"/>
</div>
</div>
<a href="#" onclick="NacitajPoznamkyMUJ2014();" title="NaËÌtaù ˙daje do pozn·mok"
   class="toleft line-box box-lightblue"><img src='../obr/vlozit.png'></a>
<a href="#" onclick="UpravPoznamkyMUJ2014();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div> <!-- .line-area poznamky muj -->
<?php
}
//koniec MUJ 2014
?>

<script type="text/javascript">
function CASH2011()
                {
var h_zos = document.forms.formcf1n.h_zos.value;
var h_sch = document.forms.formcf1n.h_sch.value;
var ktoracast = document.forms.formcf1n.ktoracast.value;

window.open('../ucto/cashflow2011.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&ktoracast=' + ktoracast + '&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CASHEUR2011()
                {
var h_zos = document.forms.formcf1n.h_zos.value;
var h_sch = document.forms.formcf1n.h_sch.value;
var ktoracast = document.forms.formcf1n.ktoracast.value;

window.open('../ucto/cashflow2011.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&ktoracast=' + ktoracast + '&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CASHGEN2011()
                {
window.open('../ucto/oprcis.php?copern=308&drupoh=95&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
</script>

<div class="line-area" style="margin-bottom:8px;"> <!-- cash flow priama -->
<FORM name="formcf1n" method="post" action="#">
<a href="#" onclick="CASH2011();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="CASHEUR2011();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
<?php
$textverzia="verzia 2011";
if ( $kli_vrok > 2013 ) { $textverzia="verzia ".$kli_vrok; }
?>
 <strong>Cash Flow - priama metÛda</strong>
 <img src="../obr/info.png" title="CF priama metÛda <?php echo $textverzia; ?>">
</div>
<div>
 <label for="h_zos">Zostaven˝:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len˝:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value="<?php echo $dnes; ?>"/>
</div>
<div>
<?php if ( $fir_big == 1 ) { ?>
 <select size="1" name="ktoracast" id="ktoracast"> <!-- dopyt, preveriù Ëi vojde -->
  <option value="0">vöetky Ëasti</option>
  <option value="1">Ëasù 1</option>
  <option value="2">Ëasù 2</option>
  <option value="3">Ëasù 3</option>
  <option value="4">Ëasù 4</option>
  <option value="5">Ëasù 5</option>
  <option value="6">Ëasù 6</option>
 </select>
<?php                      } ?>
<?php if ( $fir_big != 1 ) { ?>
 <input type="hidden" name="ktoracast" id="ktoracast" value="0"/>
<?php                      } ?>
</div>
</div>
<a href="#" onclick="CASHGEN2011();" title="Nastavenie generovania"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a>
<a href="#" onclick="window.open('../ucto/oprsys.php?copern=308&drupoh=24&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');"
   title="Upraviù predch·dzaj˙ce obdobie" class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, prerobiù na function -->
</FORM>
</div> <!-- .line-area cf priama -->


<div class="line-area"> <!-- priznanie po -->
<FORM name="formp1" method="post" action="#"> <!-- dopyt, <form> m· nejak˝ v˝znam -->
<div class="toleft line-box"></div>
<a href="#" onclick="TlacPriznanie();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>Priznanie k dani z prÌjmov PO</strong>
</div>
</div>
<a href="#" onclick="TlacPotvrdDPO();" title="Zobraziù potvrdenie o podanÌ v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="POdoXML();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravPriznanie();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div> <!-- .line-area priznanie po -->

<?php
if ( $kli_nezis == 1 )
{
?>

<?php if ( $kli_vrok >= 2012 ) { ?>

<script type="text/javascript">

function SuvahaNO2012()
                {
var h_zos = document.forms.formuznuj.h_zos.value;

window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaNO2012()
                {
var h_zos = document.forms.formuznuj.h_zos.value;

window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UzavierkaNUJ2013()
                {
var h_zos = document.forms.formuznuj.h_zos.value;

window.open('../ucto/uzavierka_nuj2013.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletNUJ2013()
                {
var h_zos = document.forms.formuznuj.h_zos.value;
var h_sch = document.forms.formuznuj.h_sch.value;
var h_drp = document.forms.formuznuj.h_drp.value;

window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletNUJ2013doxml()
                {
var h_zos = document.forms.formuznuj.h_zos.value;
var h_sch = document.forms.formuznuj.h_sch.value;
var h_drp = document.forms.formuznuj.h_drp.value;

window.open('../ucto/uzavierka_nuj2013xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NechcemStranyNUJ2013()
                {

window.open('../ucto/poznamky_nujnopage.php?copern=101&page=1&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>

<div class="line-area" style="margin-top:8px;"> <!-- uct.zavierka pu nuj -->
<FORM name="formuznuj" method="post" action="#">
<a href="#" onclick="KompletNUJ2013();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>⁄Ëtovn· z·vierka N⁄J</strong>
 <img src="../obr/info.png" title="⁄Ë NUJ resp. UZNUJ">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadna</option>
  <option value="2">Mimoriadna</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven·:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len·:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value=""/>
</div>
</div>
<a href="#" onclick="KompletNUJ2013doxml();" title="Export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
</FORM>

<div class="toright" style="width:216px; margin-right:-4px;">
 <div class="toleft line-box-text" style="width:140px;">V˝kaz ziskov a str·t N⁄J</div>
 <a href="#" onclick="VysledovkaNO2012();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');"
  title="Nastavenie predch·dzaj˙ceho obdobia"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, cez funkciu -->
</div>
<div class="toright" style="width:192px;">
 <div class="toleft line-box-text" style="width:76px;">S˙vaha NUJ</div>
 <a href="#" onclick="SuvahaNO2012();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="GenSuvNo();" title="Nastavenie generovania"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a>
 <a href="#" onclick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');" title="Nastavenie predch·dzaj˙ceho obdobia"
   class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, cez funkciu -->
</div>
</div> <!-- .line-area uct.zavierka pu nuj -->
<?php                          } ?>

<?php
}
//koniec $kli_nezis == 1
?>

<?php $vsetky=1; ?>
<?php if ( $_SERVER['SERVER_NAME'] == "localhost" OR $vsetky == 1 ) { ?>

<?php if ( $kli_nezis == 1 ) { ?> <!-- dopyt, nemÙûeme spojiù s predch·dzaj˙cim "if ( $kli_nezis == 1 )" -->
<div class="line-area" style="margin-bottom:8px;"> <!-- poznamky pu nuj -->
<FORM name="formpoz11no" method="post" action="#">
<a href="#" onclick="TlacPoznamky2011no();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Pozn·mky N⁄J</strong>
 <img src="../obr/info.png" title="⁄Ë NUJ 3-01">
</div>
<div>
 <label for="h_zos">ZostavenÈ:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·lenÈ:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value="<?php echo $dnes; ?>"/>
</div>
</div>
<a href="#" onclick="NechcemStranyNUJ2013();" title="Nastavenie str·n, ktorÈ nechcem tlaËiù"
   class="toleft line-box box-brown"><img src='../obr/zmaz.png'></a>
<a href="#" onclick="Poznamky2011NOdoxml();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="NacitajPoznamky2011no();" title="NaËÌtaù ˙daje do pozn·mok"
   class="toleft line-box box-lightblue"><img src='../obr/vlozit.png'></a>
<a href="#" onclick="UpravPoznamky2011no();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div> <!-- .line-area poznamky pu nuj -->
<?php                        } ?>
<?php                                                               } ?>

<?php
//koniec podvojne
           }
?>

<?php
$jedrok=2013;
if ( $kli_vrok < 2013 ) { $jedrok=""; }
?>
<?php
$uzjuforok=2014;
?>
<?php
//jednoduche
if ( $copern == 1 AND $kli_vduj == 9 )
           {
?>
<script type="text/javascript">


function XMLprivyd()
                {
var h_zos = document.forms.formj1.h_zos.value;
var h_sch = document.forms.formj1.h_sch.value;

window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&suborxml=1&celeeura=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }






function uzavfo2014cele()
                {
var h_zos = document.forms.formuzfo2014.h_zos.value;
var h_sch = document.forms.formuzfo2014.h_sch.value;
var h_drp = document.forms.formuzfo2014.h_drp.value;

window.open('../ucto/vprivyd<?php echo $uzjuforok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&celeeura=1&uzav=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function uzavfo2014()
                {
var h_zos = document.forms.formuzfo2014.h_zos.value;
var h_sch = document.forms.formuzfo2014.h_sch.value;
var h_drp = document.forms.formuzfo2014.h_drp.value;

window.open('../ucto/vprivyd<?php echo $uzjuforok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&uzav=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function uzavfo2014xml()
                {
var h_zos = document.forms.formuzfo2014.h_zos.value;
var h_sch = document.forms.formuzfo2014.h_sch.value;
var h_drp = document.forms.formuzfo2014.h_drp.value;

window.open('../ucto/uzavierka_ju<?php echo $uzjuforok; ?>xml.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&suborxml=1&celeeura=1&uzav=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
</script>

<?php if ( $kli_vrok >= 2014 ) { ?> <!-- dopyt, t·to podmienky tu m· v˝znam, keÔ je to osekanÈ pre rok 2015 -->
<div class="line-area" style="margin-bottom:8px;"> <!-- uct.zavierka ju -->
<FORM name="formuzfo2014" method="post" action="#">
<a href="#" onclick="uzavfo2014();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="uzavfo2014cele();" title="<?php echo $mena1; ?>· - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>⁄Ëtovn· z·vierka</strong>
 <img src="../obr/info.png" title="⁄Ë FO verzia 2014">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadna</option>
  <option value="2">Mimoriadna</option>
  <option value="3">Priebeûn·</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven·:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len·:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value=""/>
</div>
</div>
<a href="../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_vysvetlivky.pdf" target="_blank"
   title="Vysvetlivky k ˙Ëtovnej z·vierke" class="toleft line-box box-bluedefault">
 <img src="../obr/info.png"></a> <!-- dopyt, in˝ obr·zok -->
<a href="#" onclick="uzavfo2014xml();" title="Export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
 <a href="#" onclick="window.open('../ucto/oprsys.php?copern=308&drupoh=42&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');"
  title="Nastavenie predch·dzaj˙ceho obdobia v˝kazu o majetku a z·v‰zkoch"
  class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, cez funkciu -->
</FORM>
</div> <!-- .line-area uct.zavierka ju -->

<?php                          } ?>


<?php if ( $kli_vrok >= 2012 ) { ?>

<script type="text/javascript">

function PriVydNOJU2012()
                {
var h_zos = document.forms.formuznoj.h_zos.value;

window.open('../ucto/privyd_noju.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function MajZavNOJU2012()
                {
var h_zos = document.forms.formuznoj.h_zos.value;

window.open('../ucto/majzav_noju.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function GenPriVydNOJU()
                {
window.open('../ucto/oprcis.php?copern=308&drupoh=97&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function GenMajZavNOJU()
                {
window.open('../ucto/oprcis.php?copern=308&drupoh=98&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function PredMajZavNOJU()
                {
window.open('../ucto/oprsys.php?copern=308&drupoh=47&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }


function KompletNO2013()
                {
var h_zos = document.forms.formuznoj.h_zos.value;
var h_sch = document.forms.formuznoj.h_sch.value;
var h_drp = document.forms.formuznoj.h_drp.value;

window.open('../ucto/privyd_noju.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&kompletka=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KompletNO2013doxml()
                {
var h_zos = document.forms.formuznoj.h_zos.value;
var h_sch = document.forms.formuznoj.h_sch.value;
var h_drp = document.forms.formuznoj.h_drp.value;

window.open('../ucto/uzavierka_no2013xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&tt=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>

<div class="line-area" style="margin-bottom:8px;"> <!-- uct.zavierka ju nuj -->
<FORM name="formuznoj" method="post" action="#">
<a href="#" onclick="KompletNO2013();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>⁄Ëtovn· z·vierka N⁄J</strong>
 <img src="../obr/info.png" title="⁄Ë NO resp. UZNO - prÌloha k opatreniu Ë. MF/17616/2013-74">
</div>
<div>
 <select size="1" name="h_drp" id="h_drp">
  <option value="1">Riadna</option>
  <option value="2">Mimoriadna</option>
 </select>
</div>
<div>
 <label for="h_zos">Zostaven·:</label>
 <input type="text" name="h_zos" id="h_zos" onkeyup="CiarkaNaBodku(this);" maxlenght="10"
        value="<?php echo $dnes; ?>"/>
</div>
<div>
 <label for="h_sch">Schv·len·:</label>
 <input type="text" name="h_sch" id="h_sch" onkeyup="CiarkaNaBodku(this);"
        maxlenght="10" value=""/>
</div>
</div>
<a href="#" onclick="KompletNO2013doxml();" title="Export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
</FORM>

<div class="toright" style="width:270px;"> <!-- dopyt, musÌ tu byù? -->
 <div class="toleft line-box-text">V˝kaz o maj. a z·v‰z. N⁄J</div>
 <a href="#" onclick="MajZavNOJU2012();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="GenMajZavNOJU();" title="Nastavenie generovania riadkov"
    class="toleft line-box box-brown"><img src='../obr/naradie.png'></a>  <!-- dopyt, prÌpadne presun˙ù do riadku ˙Ëtovn· z·vierka -->
 <a href="#" onclick="GenMajZavNOJU();" title="Nastavenie predch·dzaj˙ceho obdobia"
    class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, prÌpadne presun˙ù do riadku ˙Ëtovn· z·vierka -->
</div>
<div class="toright" style="width:230px;"> <!-- dopyt, musÌ tu byù? -->
 <div class="toleft line-box-text">V˝kaz o prÌj. a v˝dav. N⁄J</div>
 <a href="#" onclick="PriVydNOJU2012();" title="<?php echo $mena1; ?>· + centy - zobraziù v PDF"
    class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
 <a href="#" onclick="GenPriVydNOJU();" title="Nastavenie generovania riadkov"
    class="toleft line-box box-brown"><img src='../obr/naradie.png'></a> <!-- dopyt, prÌpadne presun˙ù do riadku ˙Ëtovn· z·vierka -->
</div>
</div> <!-- .line-area uct.zavierka ju nuj -->
<?php                          } ?>

<div class="line-area"> <!-- platby do fondov sp a zp -->
<FORM name="formuplatju" method="post" action="#"> <!-- dopyt, preËo je tu <form> -->
<a href="#" onclick="platbyju();" title="Uk·zaù platby v <?php echo $mena1; ?>· + centy"
   class="toleft line-box box-bluedefault"><img src='../obr/tlac.png'></a> <!-- dopyt, in˙ ikonu, lebo nejde o pdf -->
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Platby dane z prÌjmu a odvodov do fondov SP a ZP pre bud˙ci rok</strong> <!-- dopyt, lepöÌ text -->
</div>
</div>
</FORM>
</div> <!-- .line-area platby do fondov sp a zp -->
<?php
//koniec jednoduche
           }
?>


<div class="line-area"> <!-- priznanie fob -->
<FORM name="formfa1" method="post" action="#"> <!-- dopyt, m· v˝znam <form>? -->
<a href="#" onclick="TlacFOB();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Priznanie k dani z prÌjmov FO typ B</strong>
</div>
</div>
<a href="#" onclick="TlacPotvrdFOB();" title="Zobraziù potvrdenie o podanÌ v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="FOBdoXML();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravFOB();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
<a href="#" onclick="ZnovuFOB();" title="NaËÌtaù ˙daje"
   class="toleft line-box box-lightblue"><img src='../obr/vlozit.png'></a>
</FORM>
</div> <!-- .line-area priznanie fob -->

<div class="line-area" style="margin-bottom:8px;"> <!-- priznanie dmv -->
<FORM name="formdmv11" method="post" action="#"> <!-- dopyt, m· v˝znam <form>? -->
<a href="#" onclick="TlacDMV();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box"></div>
<div class="toleft line-box-text">
<div>
 <strong>Priznanie k dani z motorov˝ch vozidiel</strong>
</div>
</div>
<a href="#" onclick="TlacPotvrdDMV();" title="Zobraziù potvrdenie o podanÌ v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<a href="#" onclick="DMVdoXML();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravDMV();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div> <!-- .line-area priznanie dmv -->

<div class="line-area"> <!-- oznamenie o uz -->
<FORM name="formozuz14" method="post" action="#"> <!-- dopyt, m· v˝znam <form>? -->
<div class="toleft line-box"></div>
<a href="#" onclick="TlacOzUz();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>Ozn·menie o d·tume schv·lenia ˙Ëtovnej z·vierky</strong>
</div>
</div>
<a href="#" onclick="OzUzdoXML();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravOzUz();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div> <!-- .line-area oznamenie o uz -->

<div class="line-area"> <!-- podanie o uz -->
<FORM name="formvseob14" method="post" action="#"> <!-- dopyt, m· v˝znam <form>? -->
<div class="toleft line-box"></div>
<a href="#" onclick="TlacVseob();" title="Zobraziù v PDF"
   class="toleft line-box box-blue"><img src='../obr/tlac.png'></a>
<div class="toleft line-box-text">
<div>
 <strong>VöeobecnÈ podanie k ˙Ëtovnej z·vierke</strong> <!-- dopyt, aktualizovaù aj pre j˙ a keÔ bude n˙j asi nezobrazovaù -->
</div>
</div>
<a href="#" onclick="VseobdoXML();" title="export do XML"
   class="toleft line-box box-red"><img src='../obr/export.png'></a>
<a href="#" onclick="UpravVseob();" title="Upraviù hodnoty"
   class="toleft line-box box-green"><img src='../obr/zoznam.png'></a>
</FORM>
</div>

</div> <!-- .content -->
<?php
//celkovy koniec dokumentu
$cislista = include("uct_lista_norm.php");
       } while (false);
?>
</BODY>
</HTML>