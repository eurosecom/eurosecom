<HTML>
<?php

//celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 1000;
$cslm=310;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$typhtml = 1*$_REQUEST['typhtml'];
$cinnost = 1*$_REQUEST['cinnost']; //1=upomienka,9=rucne sparovanie,8=vzajomny zapocet,7=prikaz na uhradu,6-faktoring
$uhrvseob = 1*$_REQUEST['uhrvseob'];
//echo $cinnost;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$alchem_orig=$alchem;
$alchem=1;

//ak JU vzdy prepocitaj saldo
if( $kli_vduj == 9 ) 
{ 
//echo "mazem";
include("../ucto/saldo_zmaz_okmoje.php"); 
}

//ak nahrata uhrada prepocitam len pre mna
$sql = "SELECT * FROM F$kli_vxcf"."_uctsaldo_uhr$kli_uzid";
$vysledok = mysql_query($sql);
if (!$vysledok) 
{
if( $cinnost == 0 OR $fir_big == 0 ) { include("../ucto/saldo_zmaz_okmoje.php"); }
}

//kvoli rychlosti nemazem vzdy pri sparovani a upomienkach if( $cinnost == 1 OR $cinnost == 9 ) { include("../ucto/saldo_zmaz_ok.php"); }

//kliknutie na ikonku prepocitaj saldo moje
if( $copern == 1001 ) 
{ 
include("../ucto/saldo_zmaz_okmoje.php"); 
$copern=1;
}

$odber=1;
$dodav=1;
$rusan=1;
if( $kli_uzid != 3338 ) $saldo_subor = include("saldo_subor.php");
if( $kli_uzid == 3338 ) $saldo_subor = include("saldoxx.php");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
<?php if( $typhtml == 0 ) echo "Saldokonto"; ?>
<?php if( $typhtml == 1 AND $cinnost == 1 ) echo "Upomienky"; ?>
<?php if( $typhtml == 1 AND $cinnost == 9 ) echo "RuËnÈ sp·rovanie a opravy saldokonta"; ?>
<?php if( $typhtml == 1 AND $cinnost == 8 ) echo "Vz·jomn˝ z·poËet"; ?>
<?php if( $typhtml == 1 AND $cinnost == 7 ) echo "PrÌkaz na ˙hradu"; ?>
<?php if( $typhtml == 1 AND $cinnost == 6 ) echo "Faktoring"; ?>
</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="sal_ico_xml.js"></script>
<script type="text/javascript" src="sal_saldo_xml.js"></script>

<script type="text/javascript">
var sirkawin = screen.width-10;
var vyskawin = screen.height-10;

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

//posuny Enter[[[[[[[[[[[



function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_ico.value != ''  )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajSaldo();
        }      

        if( document.forms1.h_ico.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }


function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.forms1.h_nai.value != '' )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms1.h_ico.value = ""; 
        volajSaldo();
        }   

        if( document.forms1.h_nai.value == "" ) { document.forms1.h_ico.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky Saldo
function vykonajSaldo(ico,nai,mes,prm1,prm2,prm3,prm4)
                {
        document.forms.forms1.h_ico.value = ico;
        document.forms.forms1.h_nai.value = nai;
        document.forms.forms1.h_mes.value = mes;
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobSaldo();
        mySaldoelement.style.display='';
                }


function Len1Saldo()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobSaldo();
        mySaldoelement.style.display='';
                    }

function Len0Saldo()
                    {
        New.style.display="";
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                    }


function VyberVstup()
                {
        //document.forms.forms1.h_nai.focus();
        //document.forms.forms1.h_nai.select(); 
                }

<?php if( $typhtml != 1 ) { ?>


function OldiesVsetko()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
  var h_su = 0;
  if( document.formx1.h_su.checked ) h_su=1;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

var h_nai = document.forms.forms1.h_nai.value;

window.open('../ucto/saldo_oldpdf.php?nesparovane=0&h_uce=' + h_uce + '&h_nai=' + h_nai + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=14&drupoh=4&page=1&h_su=' + h_su + '&h_al=' + h_al + '&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OldiesNesparovane()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

var h_spl = document.forms.forms2.h_spl.value;
var h_dsp = document.forms.forms2.h_dsp.value;

var h_nai = document.forms.forms1.h_nai.value;

  var h_su = 0;
  if( document.formx1.h_su.checked ) h_su=1;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

window.open('../ucto/saldo_oldpdf.php?nesparovane=1&h_uce=' + h_uce + '&h_nai=' + h_nai + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=14&drupoh=4&page=1&h_su=' + h_su + '&h_al=' + h_al + '&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
  var h_su = 0;
  if( document.formx1.h_su.checked ) h_su=1;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

var h_nai = document.forms.forms1.h_nai.value;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_nai=' + h_nai + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=10&drupoh=1&page=1&h_su=' + h_su + '&h_al=' + h_al + '&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

var h_spl = document.forms.forms2.h_spl.value;
var h_dsp = document.forms.forms2.h_dsp.value;

var h_nai = document.forms.forms1.h_nai.value;

  var h_su = 0;
  if( document.formx1.h_su.checked ) h_su=1;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_nai=' + h_nai + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&h_su=' + h_su + '&h_al=' + h_al + '&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SaldoFak(cislo_fak)
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&cislo_fak=' + cislo_fak + '&copern=12&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPolSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

var h_nai = document.forms.forms1.h_nai.value;

  var h_su = 0;
  if( document.formx1.h_su.checked ) h_su=1;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_nai=' + h_nai +  '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_al=' + h_al + '&h_su=' + h_su + '&copern=14&drupoh=4&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                     } ?>


<?php if( $typhtml == 1 )            { ?>


<?php if( $cinnost == 9 )       { ?>

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var dobropis = document.forms.forms3.dobropis.value;

window.open('../ucto/saldo_htm.php?dobropis=' + dobropis + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function PreuctSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_zapocet.php?preuct=1&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=8',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                           } ?>

<?php if( $cinnost == 8 )       { ?>

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_zapocet.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                           } ?>

<?php if( $cinnost == 6 )       { ?>

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_faktoring.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                           } ?>

<?php if( $cinnost == 7 )       { ?>

function TlacSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_datp = document.forms.formprik.h_datp.value;

window.open('../ucto/saldo_priku.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_datp=' + h_datp + '&copern=10&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>&uhrvseob=<?php echo $uhrvseob; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_datp = document.forms.formprik.h_datp.value;

window.open('../ucto/saldo_priku.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_datp=' + h_datp + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>&uhrvseob=<?php echo $uhrvseob; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                           } ?>

<?php if( $cinnost == 1 )       { ?>

function TlacSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

window.open('../ucto/saldo_htm.php?h_al=' + h_al + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&h_obd=' + h_obd + '&copern=10&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;
  var h_al = 0;
  if( document.formx1.h_al.checked ) h_al=1;

window.open('../ucto/saldo_htm.php?h_al=' + h_al + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                           } ?>

<?php if( $cinnost != 9 AND $cinnost != 8 AND $cinnost != 7 AND $cinnost != 6 AND $cinnost != 1 )       { ?>

function TlacNespSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_htm.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                                                                } ?>

function SaldoFak(cislo_fak)
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_htm.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&cislo_fak=' + cislo_fak + '&copern=12&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPolSaldo()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_htm.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=14&drupoh=4&page=1&cinnost=<?php echo $cinnost; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                     } ?>

function TlacSumy(ucet)
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=10&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>&sumico=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacNumy(ucet)
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_pdf.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>&sumico=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php if( $alchem == 1 )       { ?>

function Dolehotne()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=9&dea=0&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Polehotne()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=1&dea=0&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Zadealerov()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=0&dea=1&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Uhdealerov()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_datp = document.forms.formdeal.h_datp.value;
var h_datk = document.forms.formdeal.h_datk.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=0&dea=1&uhr=1&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_datp=' + h_datp + '&h_datk=' + h_datk +
 '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp +
 '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NeuhIcoRozdel()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alch01.php?uhr=1&pol=0&dea=0&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DolehotneDeal()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=9&dea=1&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function PolehotneDeal()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alchem.php?pol=1&dea=1&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NeuhIcoRozdelDeal()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_alch01.php?uhr=1&pol=0&dea=1&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CisDealerov()
                {

window.open('../cis/dealeri.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Inventarizacia()
                {
var h_datp = document.forms.formdeal.h_datp.value;
var h_datk = document.forms.formdeal.h_datk.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_inventura.php?h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd +
 + '&h_datp=' + h_datp + '&h_datk=' + h_datk + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


<?php                     } ?>

function InfoICO()
                {
var h_ico = document.forms.forms1.h_ico.value;
var h_nai = document.forms.forms1.h_nai.value;

window.open('../ucto/infoico.php?pol=1' + '&h_nai=' + h_nai + '&h_ico=' + h_ico + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function RozdelUhrad()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_alch06.php?h_deal=0&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=0&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VyhodUhrad()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_alch02.php?h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function VyhodHnoj(jar)
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_jar = jar;

window.open('../ucto/saldo_alch03.php?h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_jar=' + h_jar + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function VyhodObch(jar)
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_jar = jar;

window.open('../ucto/saldo_alch04.php?h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_jar=' + h_jar + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NajOdb()
                {

var h_uce = document.forms.forms1.h_uce.value;
var h_obd = document.forms.forms1.h_obd.value;

window.open('../ucto/saldo_alch05.php?h_uce=' + h_uce + '&h_obd=' + h_obd + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function HlaPoh()
                {

window.open('../ucto/hlasenie_euler.php?copern=20&drupoh=1&page=1&strana=5',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function PoZaBanka()
                {
var h_deal = document.forms.formdeal.h_deal.value;
var h_uce = document.forms.forms1.h_uce.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_obd = document.forms.forms1.h_obd.value;
var h_dsp = document.forms.forms2.h_dsp.value;
var h_spl = document.forms.forms2.h_spl.value;

window.open('../ucto/saldo_metalco01.php?uhr=1&pol=0&dea=0&h_deal=' + h_deal + '&h_uce=' + h_uce + '&h_ico=' + h_ico + '&h_obd=' + h_obd + '&h_spl=' + h_spl + '&h_dsp=' + h_dsp + '&copern=11&drupoh=1&page=1&analyzy=<?php echo $analyzy; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }
</script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<?php if( $typhtml == 0 ) { ?>
<td>EuroSecom  -  Saldokonto odberateæskÈ a dod·vateæskÈ
<?php                     } ?>
<?php if( $typhtml == 1 AND $cinnost == 1 ) echo "<td>EuroSecom  -  Upomienky, pen·le odberateæsk˝ch fakt˙r "; ?>
<?php if( $typhtml == 1 AND $cinnost == 9 ) echo "<td>EuroSecom  -  RuËnÈ sp·rovanie a opravy saldokonta "; ?>
<?php if( $typhtml == 1 AND $cinnost == 8 ) echo "<td>EuroSecom  -  Vz·jomn˝ z·poËet fakt˙r "; ?>
<?php if( $typhtml == 1 AND $cinnost == 7 ) echo "<td>EuroSecom  -  PrÌkaz na ˙hradu "; ?>
<?php if( $typhtml == 1 AND $cinnost == 6 ) echo "<td>EuroSecom  -  Faktoring "; ?>

 <a href="#" onClick="window.open('saldo.php?copern=1001&drupoh=1&page=1&sysx=UCT&typhtml=<?php echo $typhtml; ?>&cinnost=<?php echo $cinnost; ?>','_self' );" >
<input type='image' src='../obr/ok.png' width=20 height=20 border=0 alt='Obnov saldokonto' title='Obnov saldokonto'></a>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="fmenu" width="100%" >
<?php if( $cinnost == 7 ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="formprik" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="3" align="lext">
Po splatnosti k d·tumu: <input type="text" name="h_datp" id="h_datp" size="10" maxlength="10" value="" onkeyup="CiarkaNaBodku(this);" />
</tr>
</form>
<?php                     } ?>

<?php if( $typhtml == 0 AND $alchem == 1 ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="formdeal" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="1" align="left">
DOL<img src='../obr/tlac.png' onClick="Dolehotne();" width=15 height=15 border=0 alt='TlaË saldokonta - DOLEHOTN…' title='TlaË saldokonta - DOLEHOTN…' >

POL<img src='../obr/tlac.png' onClick="Polehotne();" width=15 height=15 border=0 alt='TlaË saldokonta - POLEHOTN…' title='TlaË saldokonta - POLEHOTN…' >

ICONR<img src='../obr/tlac.png' onClick="NeuhIcoRozdel();" width=15 height=15 border=0 alt='TlaË neuhraden˝ch pohæad·vok, z·v‰zkov za I»O rozdelenÈ podæa doby po splatnosti' title='TlaË neuhraden˝ch pohæad·vok, z·v‰zkov za I»O rozdelenÈ podæa doby po splatnosti' >

<?php if( $alchem == 1 ) { ?>
<td class="hmenu" colspan="3" align="left">

DEAL<img src='../obr/tlac.png' onClick="Zadealerov();" width=15 height=15 border=0 alt='TlaË saldokonta - podæa DEALEROV' title='TlaË saldokonta - podæa DEALEROV' >

DDEAL<img src='../obr/tlac.png' onClick="DolehotneDeal();" width=15 height=15 border=0 alt='TlaË saldokonta - podæa DEALEROV DOLEHOTN…' title='TlaË saldokonta - podæa DEALEROV DOLEHOTN…' >

PDEAL<img src='../obr/tlac.png' onClick="PolehotneDeal();" width=15 height=15 border=0 alt='TlaË saldokonta - podæa DEALEROV POLEHOTN…' title='TlaË saldokonta - podæa DEALEROV POLEHOTN…' >

ICDEAL<img src='../obr/tlac.png' onClick="NeuhIcoRozdelDeal();" width=15 height=15 border=0 alt='TlaË neuhraden˝ch pohæad·vok, z·v‰zkov podæa DEALEROV za I»O rozdelenÈ podæa doby po splatnosti' title='TlaË neuhraden˝ch pohæad·vok, z·v‰zkov podæa DEALEROV za I»O rozdelenÈ podæa doby po splatnosti' >

DEAU<img src='../obr/tlac.png' onClick="Uhdealerov();" width=15 height=15 border=0 alt='TlaË ˙hrad odberateæsk˝ch fakt˙r podæa DEALEROV' title='TlaË ˙hrad odberateæsk˝ch fakt˙r podæa DEALEROV' >

NAJV<img src='../obr/tlac.png' onClick="NajOdb();" width=15 height=15 border=0 alt='TlaË zoznamu najv˝znamnejöÌch odberateæov/dod·vateæov v roku' title='TlaË zoznamu najv˝znamnejöÌch odberateæov/dod·vateæov v roku' >

HLSP<img src='../obr/tlac.png' onClick="HlaPoh();" width=15 height=15 border=0 title='Hl·senie pohæad·vok poisùovÚa Euler Hermes' >

<?php                    } ?>

<td class="hmenu" colspan="3" align="right">
Od:<input type="text" name="h_datp" id="h_datp" size="10" maxlength="10" value="<?php echo $dnes_sk;?>" onkeyup="CiarkaNaBodku(this);"/>
Do:<input type="text" name="h_datk" id="h_datk" size="10" maxlength="10" value="<?php echo $dnes_sk;?>" onkeyup="CiarkaNaBodku(this);"/>
<select size="1" name="h_deal" id="h_deal" >
<option value="0" >Vöetci dealeri</option>
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dealeri WHERE deal > 0 ORDER BY deal");
?>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["deal"];?>" >
<?php 
$polmen = $zaznam["ndea"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["deal"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>

</select>
<img src='../obr/ziarovka.png' onClick="CisDealerov();" width=15 height=15 border=0 alt='»ÌselnÌk dealerov' title='»ÌselnÌk dealerov' >
</td>
</tr>

<tr>
<td class="hmenu" colspan="1" align="left">
INV<img src='../obr/tlac.png' onClick="Inventarizacia();" width=15 height=15 border=0 alt='Inventari·cia pohæad·vok a z·v‰zkov' title='Inventari·cia pohæad·vok a z·v‰zkov' >

UHR<img src='../obr/tlac.png' onClick="RozdelUhrad();" width=15 height=15 border=0 title='Vyhodnotenie splatnosti ˙hrad fakt˙r '  >

<?php if( $analyzy == 1 AND $alchem_orig == 1 ) { ?>
<td class="hmenu" colspan="3" align="left">
CHEM<img src='../obr/tlac.png' onClick="VyhodUhrad();" width=15 height=15 border=0 title='Vyhodnotenie ˙hrad odberateæsk˝ch fakt˙r CH…MIA za DEALEROV'  >

JARH<img src='../obr/tlac.png' onClick="VyhodHnoj(1);" width=15 height=15 border=0 title='Vyhodnotenie ˙hrad odberateæsk˝ch fakt˙r JAR HNOJIV¡ za DEALEROV'  >

JESH<img src='../obr/tlac.png' onClick="VyhodHnoj(2);" width=15 height=15 border=0 title='Vyhodnotenie ˙hrad odberateæsk˝ch fakt˙r JESE“ HNOJIV¡ za DEALEROV'  >

JSOH<img src='../obr/tlac.png' onClick="VyhodHnoj(3);" width=15 height=15 border=0 title='Vyhodnotenie ˙hrad odberateæsk˝ch fakt˙r JESE“ min.rok odkladovÈ HNOJIV¡ za DEALEROV'  >

OBJR<img src='../obr/tlac.png' onClick="VyhodObch(1);" width=15 height=15 border=0 title='Vyhodnotenie obchodn˝ch podmienok odberateæsk˝ch fakt˙r JARN… VSTUPY za DEALEROV'  >

OBJS<img src='../obr/tlac.png' onClick="VyhodObch(2);" width=15 height=15 border=0 title='Vyhodnotenie obchodn˝ch podmienok odberateæsk˝ch fakt˙r JESENN… VSTUPY za DEALEROV'  >

<?php                                           } ?>

<?php if( $metalco == 1 )                       { ?>
<td class="hmenu" colspan="3" align="left">
PZBU<img src='../obr/tlac.png' onClick="PoZaBanka();" width=15 height=15 border=0 alt='Pohæad·vky - Z·v‰zky pre BANKU' title='Pohæad·vky - Z·v‰zky pre BANKU' >

<?php                                           } ?>

<?php if( $analyzy == 0 ) { ?>
<td class="hmenu" colspan="1" align="left">
OSV<img src='../obr/tlac.png' onClick="OldiesVsetko();" width=15 height=15 border=0 alt='Oldies tvar saldokonta - Vöetky poloûky' title='Oldies tvar saldokonta - Vöetky poloûky' >

OSN<img src='../obr/tlac.png' onClick="OldiesNesparovane();" width=15 height=15 border=0 alt='Oldies tvar saldokonta - Nesp·rovanÈ poloûky' title='Oldies tvar saldokonta - Nesp·rovanÈ poloûky' >

<?php                     } ?>
</tr>

</FORM>

<?php                                      } ?>

<?php if( $typhtml == 0 OR $cinnost == 1 ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="forms2" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="7">
<select size="1" name="h_spl" id="h_spl" >
<?php if( $cinnost != 1 ) { ?>
<option value="0" >Nesumarizovaù po splatnosti</option>
<option value="1" >Sumarizovaù po splatnosti do 1dÚa - do 2dnÌ - do 3dnÌ - do 4dnÌ - do 5dnÌ</option>
<option value="2" >Sumarizovaù po splatnosti do 5dnÌ - do 14dnÌ - do 30dnÌ - do 60dnÌ - do 90dnÌ</option>
<option value="3" >Sumarizovaù po splatnosti do 30dnÌ - do 60dnÌ - do 90dnÌ - do 180dnÌ - do 360dnÌ</option>
<option value="4" >Sumarizovaù po splatnosti do 180dnÌ - do 360dnÌ - do 720dnÌ - do 1080dnÌ - do 1440dnÌ</option>
<?php                     } ?>
<?php if( $cinnost == 1 ) { ?>
<option value="0" >Vöetky fakt˙ry</option>
<option value="1" >ZaplatenÈ fakt˙ry</option>
<option value="2" >NezaplatenÈ fakt˙ry</option>
<?php                     } ?>
</select>
 Po splatnosti k d·tumu: 
 <input type="text" name="h_dsp" id="h_dsp" size="10" value="<?php echo $dnes_sk;?>" onkeyup="CiarkaNaBodku(this);"/>
<td class="hmenu" colspan="3">
</FORM>
<?php                     } ?>

<?php if( $cinnost == 9 ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="forms3" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="4">
<select size="1" name="dobropis" id="dobropis" >
<option value="0" >Dobropis = fakt˙ra, priradiù k nemu ˙hradu</option>
<option value="1" >Dobropis = ˙hrada, odpoËÌtaù od fakt˙ry</option>
<option value="2" >Vöeobecn˝ = fakt˙ra, priradiù k nemu ˙hradu</option>
</select>
<td class="hmenu" colspan="2">
</FORM>
<?php                     } ?>

<FORM name="formx1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu" width="20%">⁄Ëet
 SU<input type="checkbox" name="h_su" value="1" /> ALL<input type="checkbox" name="h_al" value="1" />
<td class="hmenu" width="10%">Obdobie
<td class="hmenu" width="10%">I»O
<img src='../obr/info.png' onClick='InfoICO();' width=12 height=12 border=0 alt='Inform·cie o vybranom I»O' title='Inform·cie o vybranom I»O' >
<td class="hmenu" width="15%">N·zov
<td class="hmenu" width="10%"> 
<td class="hmenu" width="20%">Mesto
<td class="hmenu" width="15%">
</FORM>
<?php if( $cinnost != 8 AND $cinnost != 9 AND $cinnost != 6 ) { ?>
<a href="#" onClick="TlacSaldo();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='TlaË saldokonta - VäETKO' title='TlaË saldokonta - VäETKO'></a>
<?php                                       } ?>
<a href="#" onClick="TlacNespSaldo();" >
<input type='image' src='../obr/tlac.png' width=15 height=15 border=0 alt='TlaË saldokonta - NESP¡ROVAN…' title='TlaË saldokonta - NESP¡ROVAN…'></a>
<?php if( $typhtml != 1 ) { ?>
<a href="#" onClick="TlacPolSaldo();" >
<input type='image' src='../obr/zoznam.png' width=20 height=20 border=0 alt='TlaË poloûkovitÈ saldokonto - VäETKO' title='TlaË poloûkovitÈ saldokonto - VäETKO'></a>
<?php                     } ?>

<?php if( $cinnost == 9 )                   { ?>
<a href="#" onClick="PreuctSaldo();" >
<input type='image' src='../obr/zoznam.png' width=20 height=20 border=0 alt='Pre˙Ëtovanie saldokonta' title='Pre˙Ëtovanie saldokonta'></a>
<?php                                       } ?>
</tr>

<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<?php
$sql = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 1 OR drod = 11 ) ORDER BY dodb");
?>
<select size="1" name="h_uce" id="h_uce" >
<?php if( $cinnost != 7 ) { ?>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
<?php                     } ?>
<?php
$sql = mysql_query("SELECT ddod,ndod FROM F$kli_vxcf"."_ddod WHERE drdo = 1 ORDER BY ucdo");
?>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["ddod"];?>" >
<?php 
$polmen = $zaznam["ndod"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["ddod"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>

<td class="hmenu">
<select size="1" name="h_obd" id="h_obd" >
<option value="0" >Vöetko</option>
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
<option value="100" >PoË.stav</option>

</select>

<td class="hmenu">
<input type="text" name="h_ico" id="h_ico" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_mes.value = '';"
 onKeyDown="return IcoEnter(event.which)"/>

<td class="hmenu" colspan="2"><input type="text" name="h_nai" id="h_nai" size="40" value="<?php echo $h_nai;?>" 
onclick="mySaldoelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_mes.value = '';
  document.forms.forms1.h_ico.value = '';   document.forms.forms1.h_nai.select();"
 onKeyDown="return NaiEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="1" onclick="mySaldoelement.style.display='none'; New.style.display='none'; volajSaldo();" alt="Hæadaj zadanÈ I»O alebo n·zov firmy" >

<td class="hmenu"><input type="text" name="h_mes" id="h_mes" size="25" disabled="disabled" /> 

<td class="obyc" align="right">
<INPUT type="reset" onclick="mySaldoelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_nai.focus();"
 id="resetp" name="resetp" value="NovÈ hæadanie" ></td>

</FORM>
</table>

<div id="mySaldoelement"></div>
<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som firmu podæa zadan˝ch podmienok, sk˙ste znovu</span>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu

$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
