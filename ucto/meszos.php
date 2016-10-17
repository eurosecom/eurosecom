<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=100020;
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

$rokdph=$kli_vrok;
if( $kli_vrok <  2012 ) { $rokdph=""; }
if( $kli_vrok == 2013 ) { $rokdph="2013"; }
if( $kli_vrok >  2013 ) { $rokdph="2014"; }

//if( $_SERVER['SERVER_NAME'] == "localhost" ) { $kli_vduj=9; }

if (File_Exists ("../tmp/potvrddph$kli_vmes.$kli_vrok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/potvrddph$kli_vmes.$kli_vrok.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/prizdph$kli_vmes.$kli_vrok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prizdph$kli_vmes.$kli_vrok.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/penden.$kli_uzid.pdf")) { $soubor = unlink("../tmp/penden.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/poklkni.$kli_uzid.pdf")) { $soubor = unlink("../tmp/poklkni.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/suvaha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/suvaha.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykzis.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykzis.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/uobrat.$kli_uzid.pdf")) { $soubor = unlink("../tmp/uobrat.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/udennik.$kli_uzid.pdf")) { $soubor = unlink("../tmp/udennik.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/hlkniha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/hlkniha.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/zoznam$kli_uzid.pdf")) { $soubor = unlink("../tmp/zoznam$kli_uzid.pdf"); }
if (File_Exists ("../tmp/saldo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/saldo.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/inventura.$kli_uzid.pdf")) { $soubor = unlink("../tmp/inventura.$kli_uzid.pdf"); }

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>MesaËnÈ zostavy</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function KnihaFakturPDF()
                {
var h_obdp = document.forms.formkf1.h_obdp.value;
var h_obdk = document.forms.formkf1.h_obdk.value;
var h_drp = document.forms.formkf1.h_drp.value;

window.open('../ucto/kniha_faktur.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_drp=' + h_drp +  '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function PriznanieDPH()
                {
var h_drp = document.forms.formp1.h_drp.value;
var h_dap = document.forms.formp1.h_dap.value;
var h_arch = document.forms.formp1.h_arch.value;
var fir_uctx01 = document.forms.formp1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&h_drp=' + h_drp + '&h_dap=' + h_dap + '&h_arch=' + h_arch + '&copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPH()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=30&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPH()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function HlavnaKnihaSumarnaPDF()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/hlkniha.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }

function HlavnaKnihaSumarnaSUPDF()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/hlkniha_su.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }

function HlavnaKnihaSumarnaSUAUPDF()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/hlkniha_suau.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }

function HlavnaKnihaSumarnaSUAUnazovPDF()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/hlkniha_suau.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF&su=1&nazvy=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }

function HlavnaKnihaSumarnaHTML()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/hlkniha.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


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

window.open('../ucto/juknihapoh.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )


                }

function JUKnihaSumarnaHTML()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/juknihapoh.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&copern=11&drupoh=2&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function JUvykpvpohHTML()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/vykpvpoh.php?h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&copern=11&drupoh=2&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function TlacPotvrdDPH()
                {
  var okno = window.open("../tmp/potvrddph<?php echo $kli_vume; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPD2()
                {
var h_dap = document.forms.formd2.h_dap.value;
var h_dak = document.forms.formd2.h_dak.value;
var h_stp = document.forms.formd2.h_stp.value;
var h_stk = document.forms.formd2.h_stk.value;
var h_aky = document.forms.formd2.h_aky.value;

window.open('../ucto/penden2.php?h_dap=' + h_dap + '&h_dak=' + h_dak + '&h_stp=' + h_stp + '&h_stk=' + h_stk + '&h_aky=' + h_aky + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function TlacPD2013()
                {
var h_dap = document.forms.formd2013.h_dap.value;
var h_dak = document.forms.formd2013.h_dak.value;
var h_stp = document.forms.formd2013.h_stp.value;
var h_stk = document.forms.formd2013.h_stk.value;
var h_aky = document.forms.formd2013.h_aky.value;

window.open('../ucto/penden2013.php?h_dap=' + h_dap + '&h_dak=' + h_dak + '&h_stp=' + h_stp + '&h_stk=' + h_stk + '&h_aky=' + h_aky + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZoznamDPHDOK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHDOK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHFAK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&zfak=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHFAK()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zfak=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHDRD()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&zdrd=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHDRD()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zdrd=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function ZoznamDPHCHB()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=1&page=1&typ=HTML&chyby=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

function TZoznamDPHCHB()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&chyby=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }


function TZoznamDPHPRP()
                {
var fir_uctx01 = document.forms.formg1.fir_uctx01.value;

window.open('../ucto/prijplat_dph.php?fir_uctx01=' + fir_uctx01 + '&copern=40&drupoh=2&page=1&typ=PDF&zdrd=11', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

  function SynGenSuv()
  { 

window.open('../ucto/oprsys.php?copern=308&drupoh=44&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }


function TlacRD()
                {

var h_aky = document.forms.formrd2.h_aky.value;

window.open('../ucto/fakt_dph.php?h_aky=' + h_aky + '&copern=40&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }
    
function VysMalaSU()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/vys_mala.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&synt=1&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VysMalaAU()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/vys_mala.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function MesNakVyn()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/mesnakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function MesNakVynJu()
                {
var h_obdp = document.forms.formvm1ju.h_obdp.value;
var h_obdk = document.forms.formvm1ju.h_obdk.value;

window.open('../ucto/mesnakvynju.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function MesNakVynText()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/mesnakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function MesNakVynTextJu()
                {
var h_obdp = document.forms.formvm1ju.h_obdp.value;
var h_obdk = document.forms.formvm1ju.h_obdk.value;

window.open('../ucto/mesnakvynju.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function HlavnaKnihapolozkovita()
                {
<?php if( $fir_big == 1 ) { echo "var h_s200 = document.forms.formhkp1.h_s200.value;"; } ?>
<?php if( $fir_big == 0 ) { echo "var h_s200=1;"; } ?>

window.open('../ucto/hlkniha_polpdf.php?h_s200=' + h_s200 + '&copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

                }

  function GenSuvNo()
  { 

window.open('../ucto/oprcis.php?copern=308&drupoh=96&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

function MesSuv()
                {

window.open('../ucto/messuv.php?copern=10&drupoh=1&h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function MesSuvText()
                {

window.open('../ucto/messuv.php?copern=10&drupoh=1&h_obdp=1&h_obdk=<?php echo $kli_vmes; ?>&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function RokNakVyn()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/roknakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function RokNakVynText()
                {
var h_obdp = document.forms.formvm1.h_obdp.value;
var h_obdk = document.forms.formvm1.h_obdk.value;

window.open('../ucto/roknakvyn.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function RokSuv()
                {

window.open('../ucto/roksuv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function RokSuvText()
                {

window.open('../ucto/roksuv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&obdx=1&ajtext=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
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
<td>EuroSecom  -  FinanËnÈ ˙ËtovnÌctvo - MesaËnÈ zostavy PU</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava obratovej predvahy' ></a>
</td>
<td class="bmenu" width="90%">Obratov· predvaha</td>
</tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formhkp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="HlavnaKnihapolozkovita();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<?php if( $fir_big == 0 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/hlkniha_pdf.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava hlavnej knihy' ></a>
</td>
<?php                     } ?>
<td class="bmenu" width="90%">Hlavn· kniha - poloûkovit·
<?php if( $fir_big == 1 ) { ?>
 <select size="1" name="h_s200" id="h_s200" >
<option value="1" >strany 001-150</option>
<option value="2" >strany 150-300</option>
<option value="3" >strany 300-450</option>
<option value="4" >strany 450-600</option>
</select>
<?php                     } ?>
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formhk1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="HlavnaKnihaSumarnaPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za analytickÈ ˙Ëty vytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="HlavnaKnihaSumarnaHTML()">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava hlavnej knihy za analytickÈ ˙Ëty ' ></a>
</td>
<td class="bmenu" width="70%">Hlavn· kniha - sum·rna
 <a href="#" onClick="HlavnaKnihaSumarnaSUPDF();">
 <img src='../obr/tlac.png' width=20 height=15 border=0 title='Za syntetickÈ ˙Ëty vytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="HlavnaKnihaSumarnaSUAUPDF();">
 <img src='../obr/tlac.png' width=20 height=15 border=0 title='Za syntetickÈ aj analytickÈ ˙Ëty vytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="HlavnaKnihaSumarnaSUAUnazovPDF();">
 <img src='../obr/tlac.png' width=20 height=15 border=0 title='Za syntetickÈ aj analytickÈ ˙Ëty s n·zvom ˙Ëtu vytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="20%">
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
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<?php if( $fir_big == 0 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava ˙ËtovnÈho dennÌka' ></a>
</td>
<?php                     } ?>
<td class="bmenu" width="90%">⁄Ëtovn˝ dennÌk</td>
<td class="bmenu" width="2%">
<?php if( $fir_fico == 36084344 OR $_SERVER['SERVER_NAME'] == "localhost" ) { ?>
<a href="#" onClick="window.open('../ucto/udennik36084344.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/pdf.png' width=20 height=15 border=0 title='⁄Ëtovn˝ dennÌk STR 5 PRO REGION n. o. DSS Svetluöka' ></a>
<?php                     } ?>
</td>
</tr>
</table>


<table class="vstup" width="100%" >
<FORM name="formkf1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KnihaFakturPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="72%">Kniha fakt˙r 
<select size="1" name="h_drp" id="h_drp" >
<option value="1" >odberateæsk˝ch</option>
<option value="2" >dod·vateæsk˝ch</option>
</select>
</td>
<td class="bmenu" width="20%">
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
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suv_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="25%">S˙vaha jednoduch·</td>
<td class="bmenu" width="4%">
<a href="#" onClick="window.open('../ucto/suv_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&synt=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
SU<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za syntetick˝ ˙Ëet VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="33%" >
<a href="#" onClick="MesSuv();">
MES<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad s˙vahov˝ch ˙Ëtov beûnÈho roka VytlaËiù vo form·te PDF' ></a>
<a href="#" onClick="MesSuvText();">
MESTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad s˙vahov˝ch ˙Ëtov beûnÈho roka aj s n·zvom ˙Ëtu VytlaËiù vo form·te PDF' ></a>

<a href="#" onClick="RokSuv();">
ROK<img src='../obr/tlac.png' width=20 height=15 border=0 title='MedziroËn˝ prehæad s˙vahov˝ch ˙Ëtov VytlaËiù vo form·te PDF' ></a>
<a href="#" onClick="RokSuvText();">
ROKTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MedziroËn˝ prehæad s˙vahov˝ch ˙Ëtov aj s n·zvom ˙Ëtu VytlaËiù vo form·te PDF' ></a>

<td class="bmenu" width="36%">
</tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formvm1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="VysMalaAU();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za analytick˝ ˙Ëet VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="25%">V˝sledovka jednoduch·</td>
<td class="bmenu" width="4%">
<a href="#" onClick="VysMalaSU();">
SU<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za syntetick˝ ˙Ëet VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="4%">
<a href="#" onClick="window.open('../ucto/vys_str.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
STR<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za Stredisk· VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="4%">
<a href="#" onClick="window.open('../ucto/vys_zak.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
ZAK<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za Z·kazky VytlaËiù vo form·te PDF' ></a>
</td>

<td class="bmenu" width="4%">
<a href="#" onClick="window.open('../ucto/vys_strzak.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
STRZAK<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za Stredisk· a Z·kazky VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="4%">
<a href="#" onClick="window.open('../ucto/vys_sku.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
SKU<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za Skupiny VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="4%" >
<a href="#" onClick="window.open('../ucto/vys_stv.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
STA<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za Stavby VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="33%" >
<a href="#" onClick="MesNakVyn();">
MES<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad n·kladov a v˝nosov beûnÈho roka VytlaËiù vo form·te PDF' ></a>
<a href="#" onClick="MesNakVynText();">
MESTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad n·kladov a v˝nosov beûnÈho roka aj s n·zvom ˙Ëtu VytlaËiù vo form·te PDF' ></a>

<?php if( $stavoimpex == 1 ) { ?>
<a href="#" onClick="window.open('../ucto/vys_stvimpx.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
BYT<img src='../obr/tlac.png' width=20 height=15 border=0 title='Za BytovÈ domy VytlaËiù vo form·te PDF' ></a>
<?php                        } ?>

<a href="#" onClick="RokNakVyn();">
ROK<img src='../obr/tlac.png' width=20 height=15 border=0 title='MedziroËn˝ prehæad n·kladov a v˝nosov VytlaËiù vo form·te PDF' ></a>
<a href="#" onClick="RokNakVynText();">
ROKTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MedziroËn˝ prehæad n·kladov a v˝nosov aj s n·zvom ˙Ëtu VytlaËiù vo form·te PDF' ></a>


</td>
<?php
//echo $kli_vmes;
?>

<td class="bmenu" width="20%" >
<select size="1" name="h_obdp" id="h_obdp" >
<?php if( $kli_vmes >= 1 ) { echo "<option value='1' >od 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 2 ) { echo "<option value='2' >od 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 3 ) { echo "<option value='3' >od 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 4 ) { echo "<option value='4' >od 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 5 ) { echo "<option value='5' >od 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 6 ) { echo "<option value='6' >od 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 7 ) { echo "<option value='7' >od 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 8 ) { echo "<option value='8' >od 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 9 ) { echo "<option value='9' >od 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 10 ) { echo "<option value='10' >od 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 11 ) { echo "<option value='11' >od 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 12 ) { echo "<option value='12' >od 12.$kli_vrok</option>";  } ?>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<?php if( $kli_vmes == 1 ) { echo "<option value='1' >do 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 2 ) { echo "<option value='2' >do 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 3 ) { echo "<option value='3' >do 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 4 ) { echo "<option value='4' >do 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 5 ) { echo "<option value='5' >do 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 6 ) { echo "<option value='6' >do 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 7 ) { echo "<option value='7' >do 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 8 ) { echo "<option value='8' >do 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 9 ) { echo "<option value='9' >do 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 10 ) { echo "<option value='10' >do 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 11 ) { echo "<option value='11' >do 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 12 ) { echo "<option value='12' >do 12.$kli_vrok</option>";  } ?>
</select>
</tr>
</FORM>
</table>

<?php if( $kli_vrok < 2009 ) { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=1&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha2008.php?copern=10&drupoh=1&page=1&tis=1&fort=0&vyb_ume=<?php echo $kli_vume; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> bez formul·ra - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">S˙vaha ⁄Ë POD 1-01 verzia UVPOD1v07_1</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=22&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis2008.php?copern=10&drupoh=1&page=1&tis=1&fort=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V tisÌcoch <?php echo $mena1; ?> bez formul·ra - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">V˝kaz ziskov a str·t ⁄Ë POD 2-01 verzia UVPOD2v07_2</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=21&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<?php              } //koniec rok 2008; ?>

<?php if( $kli_vrok >= 2009 AND $kli_vrok <= 2013 ) { ?>


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

<td class="bmenu" width="55%">S˙vaha ⁄Ë POD 1-01 ( platn· do 30.12.2014 )

<a href="#" onClick="SynGenSuv();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='SyntetickÈ generovanie riadkov s˙vahy' ></a>
</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven·: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len·: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="2%">
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
<td class="bmenu" width="55%">V˝kaz ziskov a str·t ⁄Ë POD 2-01 ( platn˝ do 30.12.2014 )

</td>
<td class="bmenu" width="35%">
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 Zostaven˝: <input type="text" name="h_zos" id="h_zos" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Schv·len˝: <input type="text" name="h_sch" id="h_sch" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=21&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</FORM>
</table>

<?php              } //koniec rok 2009 az 2014; ?>


<?php if( $kli_nezis == 1  ) { ?>

<?php if( $kli_vrok < 2012 )    { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no2011.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no2011.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="92%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvNo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov s˙vahy NO' ></a>
</td>
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
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no2011.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="94%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/25682/2007-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<?php                           } ?>

<?php if( $kli_vrok >= 2012 AND $kli_vrok < 2015 )   { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/suvaha_no.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="92%">S˙vaha ⁄Ë NUJ 1-01 prÌloha Ë.1 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="GenSuvNo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Generovanie riadkov s˙vahy NO' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=32&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&page=1&tis=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V <?php echo $mena1; ?> a centoch - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&page=1&tis=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="V cel˝ch <?php echo $mena1; ?> - vytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="94%">V˝sledovka ⁄Ë NUJ 2-01 prÌloha Ë.2 k opatreniu Ë. MF/22603/2012-74</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=31&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
</table>

<?php                           } ?>

<?php                      } ?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="PriznanieDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<?php if( $kli_vrok <  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv10
<?php                        } ?>
<?php if( $kli_vrok == 2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv11
<?php                        } ?>
<?php if( $kli_vrok >  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv12
<?php                        } ?>
<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadne</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËnÈ</option>
<option value="2" >ätvrùroËnÈ</option>
<option value="4" >RoËnÈ</option>
</select>
<a href="#" onClick="TlacPotvrdDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="10%">
<select size="1" name="h_arch" id="h_arch" >
<option value="0" >Nearchivovaù</option>
<option value="1" >Archivovaù</option>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/archivdph<?php echo $rokdph; ?>.php?copern=80&drupoh=1&page=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='ArchÌv DaÚov˝ch priznanÌ DPH rok <?php echo $kli_vrok; ?>' ></a>
</td>
<?php                        } ?>

<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv07_1</td>
<?php                        } ?>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formg1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="TZoznamDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoznamDPH();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te HTML' ></a>
</td>
</td>
<td class="bmenu" width="54%">DaÚ z pridanej hodnoty - Zoznamy dokladov a chybovÈ hl·senia v.<?php echo $kli_vrok; ?>
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËn˝</option>
<option value="2" >ätvrùroËn˝</option>
<option value="4" >RoËnÈ</option>
</select>
</td>

<td class="bmenu" align="right" width="8%">
<?php if( $fir_xvr05 != 2 AND $kli_vrok >= 2016 ) { ?>
PRP
<a href="#" onClick="TZoznamDPHPRP();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam prijat˝ch platieb pre uplatnenie DPH vo form·te PDF" ></a>
<?php                                             } ?>
</td>

<td class="bmenu" align="right" width="8%">FKT
<a href="#" onClick="TZoznamDPHFAK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po fakt˙rach vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHFAK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po fakt˙rach vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DOK
<a href="#" onClick="TZoznamDPHDOK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po dokladoch vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDOK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po dokladoch vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DRD
<a href="#" onClick="TZoznamDPHDRD();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po druhoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">CHB
<a href="#" onClick="TZoznamDPHCHB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHCHB();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te HTML' ></a>
</td>

<?php                        } ?>
<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=30&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava DPH' ></a>
</td>
</td>
<td class="bmenu" width="90%">DaÚ z pridanej hodnoty - Zoznam dokladov a chybovÈ hl·senia v.2008</td>
<?php                        } ?>

</tr>
</FORM>
</table>


<?php
           }
?>


<?php
if( $copern == 1 AND $kli_vduj == 9 )
           {
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FinanËnÈ ˙ËtovnÌctvo - MesaËnÈ zostavy JU</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava peÚaûnÈho dennÌka' ></a>
</td>
<td class="bmenu" width="90%">PeÚaûn˝ dennÌk - druh 1</td>
</tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formd2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPD2();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="30%">PeÚaûn˝ dennÌk - druh 2 verzia pre rok 2012
 <select size="1" name="h_aky" id="h_aky" >
<option value="1" >poloûkovit˝</option>
<option value="2" >suma za doklady</option>
</select>
</td>
<td class="bmenu" width="60%">
<?php 
$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$prvy = "01.01.".$kli_vrok; 
?>
 D·tum od: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $prvy;?>" /> 
 do: <input type="text" name="h_dak" id="h_dak" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Strany od: <input type="text" name="h_stp" id="h_stp" maxlenght="10" size="8" value="1" /> 
 do: <input type="text" name="h_stk" id="h_stk" maxlenght="10" size="8" value="999" />
<td class="bmenu" width="10%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=29&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Nastavenie druh pohybu -> stÂpec peÚaûnÈho dennÌka pre rok 2012' ></a>
</td>
</tr>
<tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formd2013" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPD2013();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>
<td class="bmenu" width="30%">PeÚaûn˝ dennÌk - druh 2 verzia pre rok 2013
 <select size="1" name="h_aky" id="h_aky" >
<option value="1" >poloûkovit˝</option>
<option value="2" >suma za doklady</option>
</select>
</td>
<td class="bmenu" width="60%">
<?php 
$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$prvy = "01.01.".$kli_vrok; 
?>
 D·tum od: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $prvy;?>" /> 
 do: <input type="text" name="h_dak" id="h_dak" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
 Strany od: <input type="text" name="h_stp" id="h_stp" maxlenght="10" size="8" value="1" /> 
 do: <input type="text" name="h_stk" id="h_stk" maxlenght="10" size="8" value="999" />
<td class="bmenu" width="10%"></td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=28&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Nastavenie druh pohybu -> stÂpec peÚaûnÈho dennÌka pre rok 2013' ></a>
</td>
</tr>
<tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formkf1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="KnihaFakturPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="72%">Kniha   
<select size="1" name="h_drp" id="h_drp" >
<option value="3" >pohæad·vok</option>
<option value="4" >z·v‰zkov</option>
</select>
</td>
<td class="bmenu" width="20%">
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
<FORM name="formhk1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="JUKnihaSumarnaPDF();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="JUKnihaSumarnaHTML()">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava ˙Ëtovn˝ch pohybov' ></a>
</td>
<td class="bmenu" width="72%">Prehæad ˙Ëtovn˝ch pohybov</td>
<td class="bmenu" width="20%">
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
<FORM name="formvm1ju" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="MesNakVynJu();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad prÌjmov a v˝davkov zapoËÌtateæn˝ch do daÚovÈho z·kladu VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="72%">MesaËn˝ prehæad prÌjmov a v˝davkov zapoËÌtateæn˝ch do daÚovÈho z·kladu
<a href="#" onClick="MesNakVynTextJu();">
MESTx<img src='../obr/tlac.png' width=20 height=15 border=0 title='MesaËn˝ prehæad prÌjmov a v˝davkov aj s n·zvom pohybu VytlaËiù vo form·te PDF' ></a>
</td>
<?php
//echo $kli_vmes;
?>

<td class="bmenu" width="20%" >
<select size="1" name="h_obdp" id="h_obdp" >
<?php if( $kli_vmes >= 1 ) { echo "<option value='1' >od 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 2 ) { echo "<option value='2' >od 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 3 ) { echo "<option value='3' >od 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 4 ) { echo "<option value='4' >od 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 5 ) { echo "<option value='5' >od 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 6 ) { echo "<option value='6' >od 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 7 ) { echo "<option value='7' >od 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 8 ) { echo "<option value='8' >od 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 9 ) { echo "<option value='9' >od 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 10 ) { echo "<option value='10' >od 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 11 ) { echo "<option value='11' >od 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes >= 12 ) { echo "<option value='12' >od 12.$kli_vrok</option>";  } ?>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<?php if( $kli_vmes == 1 ) { echo "<option value='1' >do 01.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 2 ) { echo "<option value='2' >do 02.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 3 ) { echo "<option value='3' >do 03.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 4 ) { echo "<option value='4' >do 04.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 5 ) { echo "<option value='5' >do 05.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 6 ) { echo "<option value='6' >do 06.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 7 ) { echo "<option value='7' >do 07.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 8 ) { echo "<option value='8' >do 08.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 9 ) { echo "<option value='9' >do 09.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 10 ) { echo "<option value='10' >do 10.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 11 ) { echo "<option value='11' >do 11.$kli_vrok</option>";  } ?>
<?php if( $kli_vmes == 12 ) { echo "<option value='12' >do 12.$kli_vrok</option>";  } ?>
</select>
</tr>
</FORM>
</table>

<?php
$jedrok=2013;
if( $kli_vrok < 2013 ) { $jedrok=""; } 
//if( $_SERVER['SERVER_NAME'] == "localhost" ) { $jedrok="2013"; }
?>

<table class="vstup" width="100%" style="display:none;">
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vprivyd<?php echo $jedrok; ?>.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>
</td>
<td class="bmenu" width="88%">V˝kaz o prÌjmoch a v˝davkoch ⁄Ë. FO 1-01</td>
<td class="bmenu" width="2%" >
<a href="#" onClick="JUvykpvpohHTML()">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='V˝kaz o prÌjmoch a v˝davkoch podæa ˙Ëtovn˝ch pohybov' ></a>

</tr>
</table>

<table class="vstup" width="100%" style="display:none;">
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/vmajzav<?php echo $jedrok; ?>.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF v eurocentoch" ></a>
</td>
<td class="bmenu" width="90%">V˝kaz o majetku a z·v‰zkoch ⁄Ë. FO 2-01 </td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=42&page=1&sysx=UCT', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia' ></a>
</td>
</tr>
<tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formrd2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Zoznam fakt˙r" ></a>
</td>
<td class="bmenu" width="38%">DPH za˙Ëtovan· a zaplaten· na fakt˙rach 
 <select size="1" name="h_aky" id="h_aky" >
<option value="1" >dod·vateæsk˝ch</option>
<option value="2" >odberateæsk˝ch</option>
</select>
</td>
<td class="bmenu" width="60%"></td>
</tr>
<tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="PriznanieDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
</td>

<?php if( $kli_vrok <  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv10
<?php                        } ?>
<?php if( $kli_vrok == 2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv11
<?php                        } ?>
<?php if( $kli_vrok >  2011 ) { ?>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv12
<?php                        } ?>

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadne</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËnÈ</option>
<option value="2" >ätvrùroËnÈ</option>
<option value="4" >RoËnÈ</option>
</select>
<a href="#" onClick="TlacPotvrdDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="10%">
<select size="1" name="h_arch" id="h_arch" >
<option value="0" >Nearchivovaù</option>
<option value="1" >Archivovaù</option>
</select>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/archivdph<?php echo $rokdph; ?>.php?copern=80&drupoh=1&page=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='ArchÌv DaÚov˝ch priznanÌ DPH rok <?php echo $kli_vrok; ?>' ></a>
</td>
<?php                        } ?>

<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
</td>
<td class="bmenu" width="90%">DaÚovÈ priznanie DaÚ z pridanej hodnoty verzia DPHv07_1</td>
<?php                        } ?>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formg1" class="obyc" method="post" action="#" >
<tr>
<?php if( $kli_vrok >= 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="TZoznamDPH();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoznamDPH();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te HTML' ></a>
</td>
</td>
<td class="bmenu" width="70%">DaÚ z pridanej hodnoty - Zoznamy dokladov a chybovÈ hl·senia v.<?php echo $kli_vrok; ?>
<select size="1" name="fir_uctx01" id="fir_uctx01" >
<option value="1" >MesaËn˝</option>
<option value="2" >ätvrùroËn˝</option>
</select>
</td>

<td class="bmenu" align="right" width="8%">DOK
<a href="#" onClick="TZoznamDPHDOK();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDOK();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">DRD
<a href="#" onClick="TZoznamDPHDRD();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHDRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam dokladov po druhoch DPH vo form·te HTML' ></a>
</td>

<td class="bmenu" align="right" width="8%">CHB
<a href="#" onClick="TZoznamDPHCHB();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te PDF" ></a>
<a href="#" onClick="ZoznamDPHCHB();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='VytlaËiù Zoznam chybov˝ch hl·senÌ DPH vo form·te HTML' ></a>
</td>
<?php                        } ?>
<?php if( $kli_vrok < 2009 ) { ?>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=20&drupoh=1&page=1&typ=PDF', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù vo form·te PDF" ></a>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/prizdph_2008.php?copern=30&drupoh=1&page=1&typ=HTML', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava DPH' ></a>
</td>
</td>
<td class="bmenu" width="90%">DaÚ z pridanej hodnoty - Zoznam dokladov a chybovÈ hl·senia v.2008</td>
<?php                        } ?>

</tr>
</FORM>
</table>


<?php
           }
?>





<br /><br />
<?php
// celkovy koniec dokumentu

$zmenume=1; $odkaz="../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
