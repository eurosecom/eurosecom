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
<title>DaÚ z prÌjmov FO</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

//vyhlasenie k dani
<?php
$rokvyhlasenia=$kli_vrok;
if( $rokvyhlasenia < 2012 ) { $rokvyhlasenia="";  }
if( $rokvyhlasenia == 2012 ) { $rokvyhlasenia="2012";  }
if( $rokvyhlasenia == 2013 ) { $rokvyhlasenia="2013";  }
if( $rokvyhlasenia == 2014 ) { $rokvyhlasenia="2014";  }
if( $rokvyhlasenia == 2015 ) { $rokvyhlasenia="2014";  }
if( $rokvyhlasenia >= 2016 ) { $rokvyhlasenia="2016";  }
?>

function TlacVyhlasenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/vyhlasenie_dane<?php echo $rokvyhlasenia; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravVyhlasenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/vyhlasenie_dane<?php echo $rokvyhlasenia; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuVyhlasenie()
                {
var h_oc = document.forms.formp3.h_oc.value;

window.open('../mzdy/vyhlasenie_dane<?php echo $rokvyhlasenia; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//potvrdenie o prijmoch a preddavkoch
<?php
$rokpotvrdenia=$kli_vrok;
if( $rokpotvrdenia < 2011 ) { $rokpotvrdenia="";  }
if( $rokpotvrdenia == 2011 ) { $rokpotvrdenia="2011";  }
if( $rokpotvrdenia == 2012 ) { $rokpotvrdenia="2012";  }
if( $rokpotvrdenia == 2013 ) { $rokpotvrdenia="2013";  }
if( $rokpotvrdenia == 2014 ) { $rokpotvrdenia="2014";  }
if( $rokpotvrdenia == 2015 ) { $rokpotvrdenia="2015";  }
if( $rokpotvrdenia == 2016 ) { $rokpotvrdenia="2016";  }
if( $rokpotvrdenia >= 2017 ) { $rokpotvrdenia="2017";  }
?>

function TlacPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_fo<?php echo $rokpotvrdenia; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_fo<?php echo $rokpotvrdenia; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPotvrdenie()
                {
var h_oc = document.forms.formp1.h_oc.value;

window.open('../mzdy/potvrd_fo<?php echo $rokpotvrdenia; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//Stvrtrocny prehlad o dani

function TlacPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
<?php if( $kli_vrok < 2010 ) { ?>
var h_drp = 0;
<?php                        } ?>
<?php if( $kli_vrok >= 2010 ) { ?>
var h_drp = document.forms.formp2.h_drp.value;
<?php                        } ?>

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
<?php if( $kli_vrok < 2010 ) { ?>
var h_drp = 0;
<?php                        } ?>
<?php if( $kli_vrok >= 2010 ) { ?>
var h_drp = document.forms.formp2.h_drp.value;
<?php                        } ?>

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
<?php if( $kli_vrok < 2010 ) { ?>
var h_drp = 0;
<?php                        } ?>
<?php if( $kli_vrok >= 2010 ) { ?>
var h_drp = document.forms.formp2.h_drp.value;
<?php                        } ?>

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&h_drp=' + h_drp + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPotvrdPrehlad()
                {
  var okno = window.open("../tmp/potvrdpreh<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

//Rocne zuctovanie
<?php
$rokrocnezuc=$kli_vrok;
if( $rokrocnezuc < 2011 ) { $rokrocnezuc="";  }
if( $rokrocnezuc == 2011 ) { $rokrocnezuc="2011";  }
if( $rokrocnezuc == 2012 ) { $rokrocnezuc="2012";  }
if( $rokrocnezuc == 2013 ) { $rokrocnezuc="2013";  }
if( $rokrocnezuc == 2014 ) { $rokrocnezuc="2014";  }
if( $rokrocnezuc == 2015 ) { $rokrocnezuc="2015";  }
if( $rokrocnezuc == 2016 ) { $rokrocnezuc="2016";  }
if( $rokrocnezuc >= 2017 ) { $rokrocnezuc="2017";  }
?>

function TlacRocnezucto()
                {
var h_oc = document.forms.formrz1.h_oc.value;

window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=10&subor=0&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocnezucto()
                {
var h_oc = document.forms.formrz1.h_oc.value;

window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=20&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocnezucto()
                {
var h_oc = document.forms.formrz1.h_oc.value;

window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php
$rokrocnezucz=$kli_vrok;
if( $rokrocnezucz < 2011 ) { $rokrocnezucz="";  }
if( $rokrocnezucz == 2011 ) { $rokrocnezucz="2011";  }
if( $rokrocnezucz == 2012 ) { $rokrocnezucz="2012";  }
if( $rokrocnezucz == 2013 ) { $rokrocnezucz="2013";  }
if( $rokrocnezucz == 2014 ) { $rokrocnezucz="2013";  }
if( $rokrocnezucz == 2015 ) { $rokrocnezucz="2013";  }
if( $rokrocnezucz >= 2016 ) { $rokrocnezucz="2013";  }
?>

function ZoznamRocnezucto()
                {

window.open('../mzdy/rocne_danezoznam<?php echo $rokrocnezucz; ?>.php?copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//Potvrdenie o zaplateni dane

<?php
$rokrocnezuczp=$kli_vrok;
if( $rokrocnezuczp < 2011 ) { $rokrocnezuczp="";  }
if( $rokrocnezuczp == 2011 ) { $rokrocnezuczp="2011";  }
if( $rokrocnezuczp == 2012 ) { $rokrocnezuczp="2012";  }
if( $rokrocnezuczp == 2013 ) { $rokrocnezuczp="2013";  }
if( $rokrocnezuczp == 2014 ) { $rokrocnezuczp="2013";  }
if( $rokrocnezuczp >= 2015 ) { $rokrocnezuczp="2013";  }
?>

function TlacPotvrd2pdane()
                {
var h_oc = document.forms.formrz1.h_oc.value;

<?php if( $kli_vrok <= 2015 ) { ?>
window.open('../mzdy/potvrdenie_2pdane<?php echo $rokrocnezuczp; ?>.php?cislo_oc=' + h_oc + '&copern=10&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                         } ?>
<?php if( $kli_vrok >= 2016 ) { ?>
window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=10&subor=0&strana=3',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                         } ?>
                }



//Ziadost na Rocne zuctovanie
<?php
$rokziadosti=$kli_vrok;
if( $rokziadosti < 2011 ) { $rokziadosti="";  }
if( $rokziadosti == 2011 ) { $rokziadosti="2011";  }
if( $rokziadosti == 2012 ) { $rokziadosti="2012";  }
if( $rokziadosti == 2013 ) { $rokziadosti="2013";  }
if( $rokziadosti == 2014 ) { $rokziadosti="2014";  }
if( $rokziadosti >= 2015 ) { $rokziadosti="2015";  }
?>

function TlacRocneziadost()
                {
var h_oc = document.forms.formrs1.h_oc.value;

window.open('../mzdy/rocne_ziadost<?php echo $rokziadosti; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocneziadost()
                {
var h_oc = document.forms.formrs1.h_oc.value;

window.open('../mzdy/rocne_ziadost<?php echo $rokziadosti; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocneziadost()
                {
var h_oc = document.forms.formrs1.h_oc.value;

window.open('../mzdy/rocne_ziadost<?php echo $rokziadosti; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//Rocne hlasenie dane 2011

function TlacRocHlasenie()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocHlasenie()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocHlasenie()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPotvrdRocHlasenie()
                {
  var okno = window.open("../tmp/potvrdrocnehlasenie<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

function TlacPrilohuHlasenia()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ElPrilohaHlasenia()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=3&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrilohuHlasenia()
                {

window.open('../mzdy/hlasenie_daneoc.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function XMLHlasenie()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_danexml.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//Rocne hlasenie dane 2012,2013,2014
<?php
$rocnehlasenier="2012";
if( $kli_vrok == 2013 ) { $rocnehlasenier="2013"; }
if( $kli_vrok >= 2014 ) { $rocnehlasenier="2014"; }
?>

function TlacRocHlasenie<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravRocHlasenie<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuRocHlasenie<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacPotvrdRocHlasenie<?php echo $rocnehlasenier; ?>()
                {
  var okno = window.open("../tmp/potvrdrocnehlasenie<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

function TlacPrilohuHlasenia<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ElPrilohaHlasenia<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=3&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ElPrilohaHlasenia<?php echo $rocnehlasenier; ?>c5()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_dane<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=3&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&pril5=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrilohuHlasenia<?php echo $rocnehlasenier; ?>()
                {

window.open('../mzdy/hlasenie_daneoc<?php echo $rocnehlasenier; ?>.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function XMLHlasenie<?php echo $rocnehlasenier; ?>()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/hlasenie_danexml<?php echo $rocnehlasenier; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//priznanie FOA
<?php
$rokfoa=$kli_vrok;
if( $rokfoa < 2011 ) { $rokfoa="";  }
if( $rokfoa == 2011 ) { $rokfoa="2011";  }
if( $rokfoa == 2012 ) { $rokfoa="2012";  }
if( $rokfoa == 2013 ) { $rokfoa="2013";  }
if( $rokfoa == 2014 ) { $rokfoa="2014";  }
if( $rokfoa == 2015 ) { $rokfoa="2015";  }
if( $rokfoa >= 2016 ) { $rokfoa="2016";  }
?>

function TlacFOA( strana )
                {
var h_oc = document.forms.formfa1.h_oc.value;

window.open('../mzdy/priznanie_foa<?php echo $rokfoa; ?>.php?cislo_oc=' + h_oc + '&strana=' + strana + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravFOA()
                {
var h_oc = document.forms.formfa1.h_oc.value;

window.open('../mzdy/priznanie_foa<?php echo $rokfoa; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuFOA()
                {
var h_oc = document.forms.formfa1.h_oc.value;

window.open('../mzdy/priznanie_foa<?php echo $rokfoa; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&prepoc=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPotvrdFOA()
                {
  var okno = window.open("../tmp/potvrdfoa<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

function FOAdoXML()
                {
var h_oc = document.forms.formfa1.h_oc.value;

window.open('../mzdy/priznaniefoa_xml<?php echo $rokfoa; ?>.php?cislo_oc=' + h_oc + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

//oznamenie ZRD
<?php
$rokzrd=$kli_vrok;
if( $rokzrd >= 2016 ) { $rokzrd="2016";  }
?>

function TlacZRD()
                {
var h_oc = document.forms.formzrd1.h_oc.value;
var h_stv = document.forms.formzrd1.h_stv.value;

window.open('../mzdy/oznamenie_zrd<?php echo $rokzrd; ?>.php?cislo_xplat=' + h_oc + '&h_stv=' + h_stv + '&copern=40&drupoh=1&strana=9999&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravZRD()
                {
var h_oc = document.forms.formzrd1.h_oc.value;
var h_stv = document.forms.formzrd1.h_stv.value;

window.open('../mzdy/oznamenie_zrd<?php echo $rokzrd; ?>.php?cislo_xplat=' + h_oc + '&h_stv=' + h_stv + '&copern=101&drupoh=1&strana=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZRDXML()
                {
var h_oc = document.forms.formzrd1.h_oc.value;
var h_stv = document.forms.formzrd1.h_stv.value;

window.open('../mzdy/oznamenie_zrdxml<?php echo $rokzrd; ?>.php?cislo_xplat=' + h_oc + '&h_stv=' + h_stv + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  DaÚ z prÌjmov zo z·vislej Ëinnosti FO

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

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPotvrdenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Potvrdenie o prÌjmoch FO zo z·vislej Ëinnosti, o preddavkoch na daÚ, o daÚovom bonuse
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
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do potvrdenia z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formrs1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocneziadost();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">éiadosù o vykonanie RoËnÈho z˙Ëtovania preddavkov na daÚ z prÌjmov FO zo z·vislej Ëinnosti
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
<a href="#" onClick="UpravRocneziadost();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v z˙ËtovanÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocneziadost();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do  z˙Ëtovania z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formrz1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocnezucto();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">RoËnÈ z˙Ëtovanie preddavkov na daÚ z prÌjmov FO zo z·vislej Ëinnosti
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>

<a href="#" onClick="ZoznamRocnezucto();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Zoznam vykonan˝ch roËn˝ch z˙ËtovanÌ dane z prÌjmu' ></a>

<a href="#" onClick="TlacPotvrd2pdane();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË potvrdenia o zaplatenÌ dane z prÌjmov zo z·vislej Ëinnosti' ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravRocnezucto();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v z˙ËtovanÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocnezucto();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do  z˙Ëtovania z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacVyhlasenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<?php
$nazovzos = "Vyhl·senie na uplatnenie nezdaniteænej Ëasti z·kladu dane na daÚovnÌka a daÚovÈho bonusu ";
if( $kli_vrok < 2014 ) { $nazovzos = "Vyhl·senie na zdanenie prÌjmov fyzick˝ch osÙb zo z·vislej Ëinnosti "; }
?>
<td class="bmenu" width="98%"><?php echo $nazovzos; ?>
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
<a href="#" onClick="UpravVyhlasenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty vo vyhl·senÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuVyhlasenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do vyhl·senia z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>


<?php
//stvrtrocne hlasenie o dani za 2010
if( $kli_vrok >= 2010 AND $kli_vrok < 2012 ) {
?>

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

<a href="#" onClick="TlacPotvrdPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ Prehæadu" ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPrehlad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v prehæade' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPrehlad();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do prehæadu z miezd' ></a>
</td>
</tr>
</FORM>
</table>

<?php
//koniec stvrtrocne hlasenie o dani za 2010
                       }
?>


<?php
//stvrtrocne hlasenie o dani za 2009
if( $kli_vrok < 2010 ) {
?>

<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">ätvrùroËn˝ Prehæad o zrazen˝ch a odveden˝ch preddavkoch dane z prÌjmu a daÚovom bonuse PREHLADv09_1

<select size="1" name="h_oc" id="h_oc" >
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<option value="4" >4.ötvrùrok</option>
</select>

<a href="#" onClick="TlacPotvrdPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ Prehæadu" ></a>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPrehlad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v prehæade' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPrehlad();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do prehæadu z miezd' ></a>
</td>
</tr>
</FORM>
</table>

<?php
//koniec stvrtrocne hlasenie o dani za 2009
                       }
?>

<?php
//rocne hlasenie o dani za 2011
if( $kli_vrok < 2012 ) {
?>

<table class="vstup" width="100%" >
<FORM name="formrh2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocHlasenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù hl·senie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="76%">RoËnÈ Hl·senie o vy˙ËtovanÌ dane, ˙hrne prÌjmov, zrazen˝ch preddavkoch a daÚovom bonuse  HLASENIEv10_1

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Hl·senie</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="TlacPotvrdRocHlasenie();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ Hl·senia" ></a>

</td>
<td class="bmenu" width="10%">PrÌloha
<a href="#" onClick="TlacPrilohuHlasenia();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù prÌlohu hl·senia vo form·te PDF' ></a>

<a href="#" onClick="UpravPrilohuHlasenia();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='Upraviù prÌlohu hl·senia' ></a>
</td>

</td>
<td class="bmenu" width="10%">MÈdium
<a href="#" onClick="ElPrilohaHlasenia();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvoriù elektronick˙ prÌlohu hl·senia vo form·te TXT' ></a>
</td>


<td class="bmenu" width="2%">
<a href="#" onClick="XMLHlasenie();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvoriù hl·senie vo form·te XML' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravRocHlasenie();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v hl·senÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocHlasenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do hl·senia z miezd' ></a>
</td>
</tr>
</FORM>
</table>

<?php
//koniec rocne hlasenie o dani za 2011
                       }
?>

<?php
//rocne hlasenie o dani za 2012,2013
if( $kli_vrok >= 2012 ) {
?>

<table class="vstup" width="100%" >
<FORM name="formrh2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacRocHlasenie<?php echo $rocnehlasenier; ?>();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù hl·senie vo form·te PDF' ></a>
</td>
<td class="bmenu" width="76%">RoËnÈ Hl·senie o vy˙ËtovanÌ dane, ˙hrne prÌjmov, zrazen˝ch preddavkoch a daÚovom bonuse  HLASENIEv<?php echo $rocnehlasenier; ?>

<?php if( $kli_vrok == 2012 ) { ?>
<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Hl·senie</option>
<option value="2" >OpravnÈ</option>
<option value="3" >DodatoËnÈ</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />
<?php                         } ?>
<?php if( $kli_vrok >= 2013 ) { ?>
<input type="hidden" name="h_drp" id="h_drp" />
<input type="hidden" name="h_dap" id="h_dap" />
<?php                         } ?>

<a href="#" onClick="TlacPotvrdRocHlasenie<?php echo $rocnehlasenier; ?>();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ Hl·senia" ></a>

</td>
<td class="bmenu" width="10%">PrÌloha
<a href="#" onClick="TlacPrilohuHlasenia<?php echo $rocnehlasenier; ?>();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù prÌlohu hl·senia vo form·te PDF' ></a>

<a href="#" onClick="UpravPrilohuHlasenia<?php echo $rocnehlasenier; ?>();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='Upraviù prÌlohu hl·senia' ></a>
</td>

</td>
<td class="bmenu" width="10%">
<?php if( $kli_vrok < 2013 ) { ?>
MÈdium
<a href="#" onClick="ElPrilohaHlasenia<?php echo $rocnehlasenier; ?>();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvoriù elektronick˙ prÌlohu IV. hl·senia vo form·te TXT' ></a>

<a href="#" onClick="ElPrilohaHlasenia<?php echo $rocnehlasenier; ?>c5();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvoriù elektronick˙ prÌlohu V. hl·senia vo form·te TXT' ></a>
<?php                        } ?>
</td>


<td class="bmenu" width="2%">
<a href="#" onClick="XMLHlasenie<?php echo $rocnehlasenier; ?>();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvoriù hl·senie vo form·te XML' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravRocHlasenie<?php echo $rocnehlasenier; ?>();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v hl·senÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuRocHlasenie<?php echo $rocnehlasenier; ?>();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty do hl·senia z miezd' ></a>
</td>
</tr>
</FORM>
</table>

<?php
//koniec rocne hlasenie o dani za 2012,2013
                       }
?>


<table class="vstup" width="100%" >
<FORM name="formfa1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacFOA(9999);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="68%">DaÚovÈ priznanie k dani z prÌjmov FO typ A
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>

<a href="#" onClick="TlacPotvrdFOA();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ priznania" ></a>

</td>


<td class="bmenu" width="28%"></td>

<td class="bmenu" width="2%">
<img src='../obr/export.png' onclick='FOAdoXML();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ pod·vanie priznania' >
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravFOA();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty v priznanÌ' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuFOA();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty do priznania z miezd - mÙûete opakovaù viackr·t' ></a>
</td>
</tr>
</FORM>
</table>



<table class="vstup" width="100%" >
<FORM name="formzrd1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacZRD();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="68%">Ozn·menie o zrazenÌ a odvedenÌ zr·ûkovej dane podæa ß43 ods. 3 pÌsm. o) "poskytovatelia zdravotnÌckej starostlivosti"
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
<option value="<?php echo $fir_fico;?>" >
<?php echo $fir_fnaz." iËo ".$fir_fico;?></option>
</select>
</td>

<td class="bmenu" width="28%">
<select size="1" name="h_stv" id="h_stv" >
<?php if( $kli_vrok < 2016 )
 {
?>
<option value="1" >1.ötvrùrok</option>
<option value="2" >2.ötvrùrok</option>
<option value="3" >3.ötvrùrok</option>
<?php
 }
?>
<option value="4" >4.ötvrùrok</option>
</select>
</td>

<td class="bmenu" width="2%"></td>

<td class="bmenu" width="2%">
<img src='../obr/export.png' onclick='ZRDXML();' width=20 height=15 border=0 title='XML s˙bor pre elektronickÈ podanie' >
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="UpravZRD();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty' ></a>
</td>
</tr>
</FORM>
</table>

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
