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


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DaÚ z prÌjmov</title>
  <style type="text/css">

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
if( $rokdppo >= 2013 ) { $rokdppo="2013";  }
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

<?php if( $kli_vrok < 2011 ) { ?>

function ELpriznaniepo()
                {
var h_oc = 0;

window.open('../ucto/priznanie_po<?php echo $rokdppo; ?>.php?copern=11&drupoh=1&page=1&typ=PDF&strana=999&xml=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                        } ?>

<?php if( $kli_vrok >= 2011 ) { ?>

function ELpriznaniepo()
                {
var h_oc = 0;

window.open('../ucto/priznaniepo_fdf<?php echo $rokdppo; ?>.php?copern=11&drupoh=1&page=1&typ=PDF&strana=999&xml=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                        } ?>

function TlacPotvrdDPO()
                {
  var okno = window.open("../tmp/potvrddpo.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function POdoXML()
                {

window.open('../ucto/priznaniepo_xml<?php echo $rokdppo; ?>.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//poznamky 2010

function TlacPoznamky()
                {
var h_zos = document.forms.formpoz1.h_zos.value;
var h_sch = document.forms.formpoz1.h_sch.value;
var h_oc = 0;

window.open('../ucto/poznamky_po.php?cislo_oc=' + h_oc + '&h_zos=' + h_zos + '&h_sch=' + h_sch + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPoznamky()
                {
var h_oc = 0;

window.open('../ucto/poznamky_po.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPoznamky()
                {
var h_oc = 0;

window.open('../ucto/poznamky_po.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//priznanie FOB
<?php
$rokfob=$kli_vrok;
$skriptfob="../mzdy/priznanie_fob";
if( $rokfob < 2011 ) { $rokfob="";  }
if( $rokfob == 2011 ) { $rokfob="2011";  }
if( $rokfob == 2012 ) { $rokfob="2012";  }
if( $rokfob >= 2013 ) { $rokfob="2013";  }
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


function ELpriznaniefob()
                {
var h_oc = 9999;

window.open('../ucto/priznaniefob_fdf<?php echo $rokfob; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&strana=9999&xml=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function FOBdoXML()
                {

window.open('../ucto/priznaniefob_xml<?php echo $rokfob; ?>.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//poznamky 2011 podnikatelske

function TlacPoznamky2011()
                {
var h_zos = document.forms.formpoz11.h_zos.value;
var h_sch = document.forms.formpoz11.h_sch.value;
var h_oc = 0;

window.open('../ucto/poznamky_po2011tlac.php?cislo_oc=' + h_oc + '&h_zos=' + h_zos + '&h_sch=' + h_sch + '&copern=10&drupoh=1&page=9999&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NacitajPoznamky2011()
                {
var h_zos = document.forms.formpoz11.h_zos.value;
var h_sch = document.forms.formpoz11.h_sch.value;
var h_oc = 0;

window.open('../ucto/poznamky_po2011tlac.php?copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPoznamky2011()
                {
var h_oc = 0;

window.open('../ucto/poznamky_po2011.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPoznamky2011()
                {
var h_oc = 0;

window.open('../ucto/poznamky_po2011.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function FDFPoznamky2011()
                {
var h_oc = 0;
var h_zos = document.forms.formpoz11.h_zos.value;
var h_sch = document.forms.formpoz11.h_sch.value;

window.open('../ucto/poznamky_po2011fdf.php?copern=11&h_zos=' + h_zos + '&h_sch=' + h_sch + '&drupoh=1&page=1&typ=PDF&strana=999&xml=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function FDFPoznamky2011open()
                {
var h_oc = 0;
var h_zos = document.forms.formpoz11.h_zos.value;
var h_sch = document.forms.formpoz11.h_sch.value;

window.open('../ucto/poznamky_po2011fdf.php?copern=11&h_zos=' + h_zos + '&h_sch=' + h_sch + '&drupoh=1&page=1&typ=PDF&strana=999&xml=1&hnedopen=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Poznamky2011doxml()
                {

window.open('../ucto/poznamky2013_xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
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
if( $kli_vrok >= 2013 ) { $rokdmv=2013; }
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

 
</script>
</HEAD>
<BODY class="white" onload="VyberVstupx();">

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
if( $copern == 1 AND $kli_vduj != 9 )
           {
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  DaÚ z prÌjmov PO</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />




<?php
//$povelak=""; tymto by urobil zostavu vzor 2008
$povelak="__x";
?>


<script type="text/javascript">

function SUvAHA()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SUvAHAEUR()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ELsuvaha()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&xml=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function XMLsuvaha()
                {
var h_zos = document.forms.formsv1.h_zos.value;
var h_sch = document.forms.formsv1.h_sch.value;

window.open('../ucto/suvaha<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&xml=1&vyb_ume=<?php echo $kli_vume; ?>&suborxml=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
</script>

<table class="vstup" width="100%" >
<FORM name="formsv1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SUvAHA();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="SUvAHAEUR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>

<?php $versuv="UVPOD1v09_1"; if( $kli_vrok > 2010 ) $versuv="UVPOD1v11 "; ?>

<td class="bmenu" width="55%">S˙vaha ⁄Ë POD 1 - 01 verzia <?php echo $versuv; ?>
<a href="#" onClick="SynGenSuv();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='SyntetickÈ generovanie riadkov s˙vahy' ></a>
</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="7%" align="right">
<?php if( $kli_vrok < 2012 ) { ?><img src='../obr/import.png' onclick='ELsuvaha();' width=20 height=15 border=0 title='FDF a PDF s˙bory pre tlaË v˝kazu' ><?php } ?>
<img src='../obr/export.png' onclick='XMLsuvaha();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie v˝kazu' >

<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=22&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<?php
$povelak="__x";
?>

<script type="text/javascript">

function VYKZIS()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function VYKZISEUR()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function ELvykzis()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&xml=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function XMLvykzis()
                {
var h_zos = document.forms.formvz1.h_zos.value;
var h_sch = document.forms.formvz1.h_sch.value;

window.open('../ucto/vykzis<?php echo $povelak; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&xml=1&suborxml=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

</script>

<table class="vstup" width="100%" >
<FORM name="formvz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VYKZIS();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="VYKZISEUR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">V˝kaz ziskov a str·t ⁄Ë POD 2 - 01 verzia UVPOD2v09_1</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len˝: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="7%" align="right">
<?php if( $kli_vrok < 2012 ) { ?><img src='../obr/import.png' onclick='ELvykzis();' width=20 height=15 border=0 title='FDF a PDF s˙bory pre tlaË v˝kazu' ><?php } ?>
<img src='../obr/export.png' onclick='XMLvykzis();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie v˝kazu' >

<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=21&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<?php //POD 2014                  ?>
<?php if( $kli_vrok >= 2013 )   { ?>

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
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=191', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GenVysPod()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=192', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
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

<table class="vstup" width="100%" >
<FORM name="formsumuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SuvahaPOD2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="SuvahaPOD2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="64%">S˙vaha ⁄Ë POD 1-01 v.2014</td>
<td class="bmenu" width="28%"></td>
<td class="bmenu" width="2%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvPod();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formvzmuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VysledovkaPOD2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="VysledovkaPOD2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="64%">V˝kaz ziskov a str·t ⁄Ë POD 2-01 v.2014 </td>
<td class="bmenu" width="28%"></td>
<td class="bmenu" width="2%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenVysPod();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formuzpod" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletPOD2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletPOD2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">⁄Ëtovn· z·vierka ⁄Ë POD v.2014  
 <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
<option value="3" >Priebeûn·</option>
</select>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvPod();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
<td class="bmenu" width="2%" align="right">
<img src='../obr/export.png' onclick='KompletPOD2014doxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >
</td>
</tr>
</FORM>
</table>

<?php                           } ?>
<?php //koniec POD 2014           ?>


<?php //MUJ 2014                  ?>
<?php if( $kli_vrok >= 2013 )   { ?>

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
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=91', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function GenVysMuj()
  { 
  window.open('../ucto/vykazy_cis.php?copern=308&drupoh=92', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
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

</script>

<table class="vstup" width="100%" >
<FORM name="formsumuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SuvahaMUJ2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="SuvahaMUJ2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="64%">S˙vaha ⁄Ë MUJ 1-01 
</td>
<td class="bmenu" width="28%"></td>
<td class="bmenu" width="2%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvMuj();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formvzmuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VysledovkaMUJ2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="VysledovkaMUJ2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="64%">V˝kaz ziskov a str·t ⁄Ë MUJ 2-01 </td>
<td class="bmenu" width="28%"></td>
<td class="bmenu" width="2%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenVysMuj();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formuzmuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletMUJ2014();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletMUJ2014cele();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">⁄Ëtovn· z·vierka ⁄Ë MUJ 
 <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
<option value="3" >Priebeûn·</option>
</select>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="2%">
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvMuj();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Nastavenie generovania, bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia a zaokr˙hlenia S˙vahy a V˝kazu ziskov a str·t' ></a>
</td>
<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='KompletMUJ2014doxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >
</td>
</tr>
</FORM>
</table>

<?php                           } ?>
<?php //koniec MUJ 2014           ?>


<?php if( $kli_vrok <  2012 )   { ?>
<script type="text/javascript">

function CASH()
                {
var h_zos = document.forms.formcf1.h_zos.value;
var h_sch = document.forms.formcf1.h_sch.value;

window.open('../ucto/cashflow.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CASHEUR()
                {
var h_zos = document.forms.formcf1.h_zos.value;
var h_sch = document.forms.formcf1.h_sch.value;

window.open('../ucto/cashflow.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CASHGEN()
                {
window.open('../ucto/oprcis.php?copern=308&drupoh=94&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
</script>

<table class="vstup" width="100%" >
<FORM name="formcf1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="CASH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="CASHEUR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">Prehæad o peÚaûn˝ch tokoch - priama metÛda verzia 2010

<a href="#" onClick="CASHGEN();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='Generovanie CASH FLOW' ></a>

</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len˝: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="7%" align="right">

<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=23&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>
<?php                           } ?>

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

<table class="vstup" width="100%" >
<FORM name="formcf1n" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="CASH2011();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="CASHEUR2011();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">Prehæad o peÚaûn˝ch tokoch - priama metÛda verzia 2011

<a href="#" onClick="CASHGEN2011();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='Generovanie CASH FLOW' ></a>

<?php if( $fir_big == 1 ) { ?>
 <select size="1" name="ktoracast" id="ktoracast" >
<option value="0" >vöetky Ëasti naraz</option>
<option value="1" >Ëasù 1</option>
<option value="2" >Ëasù 2</option>
<option value="3" >Ëasù 3</option>
<option value="4" >Ëasù 4</option>
<option value="5" >Ëasù 5</option>
<option value="6" >Ëasù 6</option>
</select>
<?php                     } ?>

<?php if( $fir_big != 1 ) { ?>
<input type="hidden" name="ktoracast" id="ktoracast" value="0" />
<?php                     } ?>

</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len˝: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="7%" align="right">

<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=24&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<?php if( $kli_nezis == 1 ) { ?>

<?php if( $kli_vrok <  2012 )   { ?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no2011.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no2011.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<?php                           } ?>
<?php if( $kli_vrok >= 2012 )   { ?>

<script type="text/javascript">

function SuvahaNO2012()
                {
var h_zos = document.forms.formsuno.h_zos.value;

window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysledovkaNO2012()
                {
var h_zos = document.forms.formvzno.h_zos.value;

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

<table class="vstup" width="100%" >
<FORM name="formsuno" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SuvahaNO2012();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="66%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvNo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov s˙vahy NO' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formvzno" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VysledovkaNO2012();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="66%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="28%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="2%">
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formuznuj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletNUJ2013();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">⁄Ëtovn· z·vierka NUJ prÌloha k opatreniu Ë. MF/17616/2013-74
 <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
</select>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="2%">
<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='KompletNUJ2013doxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >
</td>
</tr>
</FORM>
</table>

<?php                           } ?>

<?php                      } ?>


<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPriznanie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vöetky strany priznania vo form·te PDF' ></a>
</td>
<td class="bmenu" width="89%">DaÚovÈ priznanie k dani z prÌjmov PO 
<a href="#" onClick="TlacPotvrdDPO();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania PO vo form·te PDF" ></a>
</td>

<td class="bmenu" width="9%" align="right">
<?php if( $kli_vrok < 2012 ) { ?>
<img src='../obr/import.png' onclick='ELpriznaniepo();' width=20 height=15 border=0 title='FDF a PDF s˙bory pre tlaË priznania' >
<?php                        } ?>
<img src='../obr/export.png' onclick='POdoXML();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie priznania' >

<a href="#" onClick="UpravPriznanie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù priznanie' ></a>
</td>

</tr>
</FORM>
</table>

<?php if( $kli_vrok <  2012 )   { ?>

<table class="vstup" width="100%" >
<FORM name="formpoz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPoznamky();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="55%">Pozn·mky k DaÚovÈmu priznaniu k dani z prÌjmov PO v.2010</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 ZostavenÈ: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·lenÈ: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>


<td class="bmenu" width="2%">
<a href="#" onClick="UpravPoznamky();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v pozn·mkach' ></a>
</td>

</tr>
</FORM>
</table>

<?php                           } ?>


<?php $vsetky=1; ?>
<?php if( $_SERVER['SERVER_NAME'] == "localhost" OR $vsetky == 1 ) { ?>

<?php if( $kli_vrok <=  2013 ) { ?>
<table class="vstup" width="100%" >
<FORM name="formpoz11" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPoznamky2011();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="55%">Pozn·mky ⁄c POD 3 - 04 k DPPO verzia 2012</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 ZostavenÈ: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·lenÈ: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="NacitajPoznamky2011();">
<img src='../obr/vlozit.png' width=20 height=15 border=0 title='NaËÌtaù ˙daje do pozn·mok 2011' ></a>

</td>

<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='Poznamky2011doxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >

<a href="#" onClick="UpravPoznamky2011();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v pozn·mkach' ></a>
</td>
</tr>
</FORM>
</table>
<?php                         } ?>
<?php if( $kli_vrok >= 2013 ) { ?>
<table class="vstup" width="100%" >
<FORM name="formpoz13" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPoznamky2013();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="55%">Pozn·mky ⁄c POD 3 - 04 k DPPO verzia 2013
 <a href="#" onClick="NechcemStranyPOD2013();">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='NetlaËiù stranu XY Pozn·mok POD 2013' ></a>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 ZostavenÈ: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·lenÈ: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="NacitajPoznamky2013();">
<img src='../obr/vlozit.png' width=20 height=15 border=0 title='NaËÌtaù ˙daje do pozn·mok 2013' ></a>

</td>

<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='Poznamky2013doxml()' width=20 height=15 border=0 title='export pre elektronickÈ komunik·ciu' >

<a href="#" onClick="UpravPoznamky2013();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v pozn·mkach' ></a>
</td>
</tr>
</FORM>
</table>
<?php                         } ?>


<?php if( $kli_nezis ==    1 ) { ?>
<table class="vstup" width="100%" >
<FORM name="formpoz11no" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPoznamky2011no();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="55%">Pozn·mky ⁄c NUJ 3 - 01 k DPPO pre NeziskovÈ organiz·cie
 <a href="#" onClick="NechcemStranyNUJ2013();">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='NetlaËiù stranu XY Pozn·mok NUJ 2013' ></a>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 ZostavenÈ: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·lenÈ: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="NacitajPoznamky2011no();">
<img src='../obr/vlozit.png' width=20 height=15 border=0 title='NaËÌtaù ˙daje do pozn·mok 2011' ></a>

</td>
<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='Poznamky2011NOdoxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >

<a href="#" onClick="UpravPoznamky2011no();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v pozn·mkach' ></a>
</td>
</tr>
</FORM>
</table>
<?php                           } ?>

<?php                                               } ?>

<?php
//koniec podvojne uctovnictvo
           }
?>

<?php
$jedrok=2013;
if( $kli_vrok < 2013 ) { $jedrok=""; } 
?>

<?php
if( $copern == 1 AND $kli_vduj == 9 )
           {
?>
<script type="text/javascript">


function XMLprivyd()
                {
var h_zos = document.forms.formj1.h_zos.value;
var h_sch = document.forms.formj1.h_sch.value;

window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&suborxml=1&celeeura=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function XMLmajzav()
                {
var h_zos = document.forms.formj2.h_zos.value;
var h_sch = document.forms.formj2.h_sch.value;

window.open('../ucto/vmajzav<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&page=1&suborxml=1&celeeura=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function privyd()
                {
var h_zos = document.forms.formj1.h_zos.value;
var h_sch = document.forms.formj1.h_sch.value;
var h_drp = document.forms.formj1.h_drp.value;

window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function majzav()
                {
var h_zos = document.forms.formj2.h_zos.value;
var h_sch = document.forms.formj2.h_sch.value;
var h_drp = document.forms.formj2.h_drp.value;

window.open('../ucto/vmajzav<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function privydeur()
                {
var h_zos = document.forms.formj1.h_zos.value;
var h_sch = document.forms.formj1.h_sch.value;
var h_drp = document.forms.formj1.h_drp.value;

window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&celeeura=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function majzaveur()
                {
var h_zos = document.forms.formj2.h_zos.value;
var h_sch = document.forms.formj2.h_sch.value;
var h_drp = document.forms.formj2.h_drp.value;

window.open('../ucto/vmajzav<?php echo $jedrok; ?>.php?copern=10&drupoh=1&h_zos=' + h_zos + '&h_sch=' + h_sch + '&h_drp=' + h_drp + '&page=1&celeeura=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

</script>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  DaÚ z prÌjmov FO</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<table class="vstup" width="100%" >
<FORM name="formj1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="4%">
<a href="#" onClick="privyd();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>

<a href="#" onClick="privydeur();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v cel˝ch eur·ch" ></a>
</td>
<td class="bmenu" width="60%">V˝kaz o prÌjmoch a v˝davkoch ⁄Ë. FO 1-01
<td class="bmenu" width="30%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
⁄Ët.z·vierka <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
<option value="3" >Priebeûn·</option>
</select>
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 <input type="hidden" name="h_sch" id="h_sch" value="" />
</td>

<td class="bmenu" width="6%" align="right">
<img src='../obr/export.png' onclick='XMLprivyd();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie v˝kazu' >
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formj2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="4%">
<a href="#" onClick="majzav();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>

<a href="#" onClick="majzaveur();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v cel˝ch eur·ch" ></a>
</td>
<td class="bmenu" width="60%">V˝kaz o majetku a z·v‰zkoch ⁄Ë. FO 2-01 
<td class="bmenu" width="30%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
⁄Ët.z·vierka <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
<option value="3" >Priebeûn·</option>
</select>
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 <input type="hidden" name="h_sch" id="h_sch" value="" />
</td>

<td class="bmenu" width="6%" align="right">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=42&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
<img src='../obr/export.png' onclick='XMLmajzav();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie v˝kazu' >
</tr>
<tr>
</FORM>
</table>


<?php if( $kli_vrok >= 2012 )   { ?>

<script type="text/javascript">

function PriVydNOJU2012()
                {
var h_zos = document.forms.formsunoju.h_zos.value;

window.open('../ucto/privyd_noju.php?copern=10&drupoh=1&tis=0&h_zos=' + h_zos + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function MajZavNOJU2012()
                {
var h_zos = document.forms.formsunoju.h_zosx.value;

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


</script>

<table class="vstup" width="100%" >
<FORM name="formsunoju" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="PriVydNOJU2012();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V Eur a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="66%">V˝kaz o prÌjmoch a v˝davkoch pre NEZISKOV… organiz·cie NO UË. 1-01

<a href="#" onClick="GenPriVydNOJU();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov v˝kazu NO' ></a>

</td>
<td class="bmenu" width="30%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>

<td class="bmenu" width="2%"></td>

</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="MajZavNOJU2012();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V Eur a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="66%">V˝kaz o majetku a z·v‰zkoch pre NEZISKOV… organiz·cie NO UË. 2-01

<a href="#" onClick="GenMajZavNOJU();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov v˝kazu NO' ></a>

</td>
<td class="bmenu" width="30%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zosx" id="h_zosx" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="PredMajZavNOJU();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>
</table>

<table class="vstup" width="100%" >
<FORM name="formuznoj" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KompletNO2013();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="55%">⁄Ëtovn· z·vierka NO prÌloha k opatreniu Ë. MF/17616/2013-74
 <select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadna</option>
<option value="2" >Mimoriadna</option>
</select>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="" />
</td>
<td class="bmenu" width="2%">
<td class="bmenu" width="9%" align="right">
<img src='../obr/export.png' onclick='KompletNO2013doxml()' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie' >
</td>
</tr>
</FORM>
</table>


<?php                           } ?>

<table class="vstup" width="100%" >
<FORM name="formuplatju" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="platbyju();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="Platby dane z prÌjmu a odvodov do fondov SP a ZP pre bud˙ci rok" ></a>
</td>
<td class="bmenu" width="98%">Platby dane z prÌjmu a odvodov do fondov SP a ZP pre bud˙ci rok
</td>
</tr>
</FORM>
</table>

<?php
//koniec jednoduche uctovnictvo
           }
?>

<table class="vstup" width="100%" >
<FORM name="formfa1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFOB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="90%">DaÚovÈ priznanie k dani z prÌjmov FO typ B 

<a href="#" onClick="TlacPotvrdFOB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ priznania" ></a>

</td>

<td class="bmenu" width="7%" align="right">
<?php if( $kli_vrok < 2012 ) { ?>
<img src='../obr/import.png' onclick='ELpriznaniefob();' width=20 height=15 border=0 title='FDF a PDF s˙bory pre tlaË priznania' >
<?php                        } ?>
<img src='../obr/export.png' onclick='FOBdoXML();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie priznania' >

<a href="#" onClick="UpravFOB();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v priznanÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFOB();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do priznania - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formdmv11" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacDMV();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="55%">DaÚovÈ priznanie k dani z motorov˝ch vozidiel

<a href="#" onClick="TlacPotvrdDMV();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DMV vo form·te PDF" ></a>


</td>
<td class="bmenu" width="33%">
</td>
<td class="bmenu" width="4%">
<img src='../obr/export.png' onclick='DMVdoXML();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie priznania' >

<a href="#" onClick="UpravDMV();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v priznanÌ' ></a>
</td>
</tr>
</FORM>
</table>

<br /><br />
<?php
// celkovy koniec dokumentu

$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
