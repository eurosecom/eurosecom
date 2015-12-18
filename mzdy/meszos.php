<HTML>
<?php
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

if( $copern == 1 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> neboli spracovanÈ naostro , \r urobte najprv ostrÈ spracovanie !");
window.close();
</script>
<?php
exit;
}
    }

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


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

if (File_Exists ("../tmp/mzdpasky$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdpasky$kli_uzid.pdf"); }
if (File_Exists ("../tmp/mzdzos.$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdzos.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/mzdvyp.$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdvyp.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/priemery.$kli_uzid.pdf")) { $soubor = unlink("../tmp/priemery.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/prilohaSP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prilohaSP.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykazSP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazSP.$kli_uzid.pdf"); }
if (File_Exists ("../tmp/vykazZP.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazZP.$kli_uzid.pdf"); }

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


function Dovolenky()
                {
  var aktpr = 0;
  if( document.forms.formnd1.aktpr.checked ) aktpr=1;

window.open('../mzdy/dovolenky.php?&copern=1&aktpr=' + aktpr + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function DovolenkySTR()
                {

window.open('../mzdy/dovolenky_str.php?&copern=1&aktpr=0&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function MinDovolenky()
                {
  var aktpr = 0;
  if( document.forms.formnd1.aktpr.checked ) aktpr=1;

window.open('../mzdy/dovolenky_min.php?&copern=1&aktpr=' + aktpr + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


//Mesacny prehlad dane
<?php
$rokmpreh=1*$kli_vrok;
if( $rokmpreh <= 2012 ) { $rokmpreh="";  }
if( $rokmpreh == 2013 ) { $rokmpreh="2013";  }
if( $rokmpreh == 2014 ) { $rokmpreh="2013";  }
if( $rokmpreh == 2015 ) { $rokmpreh="2013";  }
if( $rokmpreh >= 2016 ) { $rokmpreh="2016";  }
?>

function TlacPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacny<?php echo $rokmpreh; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacny<?php echo $rokmpreh; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=20&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZnovuPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacny<?php echo $rokmpreh; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php if( $kli_vrok <  2014 ) { ?>
function XMLPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacnyxml<?php echo $rokmpreh; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
<?php                         } ?>
<?php if( $kli_vrok >= 2014 ) { ?>
function XMLPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacny<?php echo $rokmpreh; ?>.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
<?php                         } ?>

function PotvrdPrehlad()
                {
  var okno = window.open("../tmp/potvrdmesprehdane<?php echo $kli_vxcf; ?>.<?php echo $kli_uzid; ?>.pdf", '_blank', '<?php echo $tlcswin; ?>' );
                }

<?php if( $kli_vrok == 2012 )           { ?>

function TlacPrilohuPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacny.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=10&drupoh=2&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function UpravPrilohuPrehlad()
                {

window.open('../mzdy/prehladdane_mesacnyoc.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TXTPrehlad()
                {
var h_drp = document.forms.formrh2.h_drp.value;
var h_dap = document.forms.formrh2.h_dap.value;

window.open('../mzdy/prehladdane_mesacnytxt.php?h_drp=' + h_drp + '&h_dap=' + h_dap + '&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php                                   } ?>
    
</script>
</HEAD>
<BODY class="white" >

<?php 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?>





<?php
if( $copern == 1 )
           {
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Mzdy - MesaËnÈ zostavy PU</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php if( $kli_vrok >= 2013 )           { ?>
<table class="vstup" width="100%" >
<FORM name="formrh2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="84%">MesaËn˝ prehæad o prÌjmoch, zrazen˝ch preddavkoch, zam.prÈmii a daÚovom bonuse PREHLADv13

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadny</option>
<option value="2" >Opravn˝</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="PotvrdPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ" ></a>

</td>

<td class="bmenu" width="10%">XML
<a href="#" onClick="XMLPrehlad();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvoriù XML prÌlohu' ></a>
</td>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPrehlad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPrehlad();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty' ></a>
</td>
</tr>
</FORM>
</table>
<?php                                    } ?>

<?php if( $kli_vrok == 2012 )            { ?>
<table class="vstup" width="100%" >
<FORM name="formrh2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="70%">MesaËn˝ prehæad o prÌjmoch, zrazen˝ch preddavkoch, zam.prÈmii a daÚovom bonuse PREHLADv12

<select size="1" name="h_drp" id="h_drp" >
<option value="1" >Riadny</option>
<option value="2" >Opravn˝</option>
</select>
<?php $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
 D·tum: <input type="text" name="h_dap" id="h_dap" maxlenght="10" size="8" value="<?php echo $dnes;?>" />

<a href="#" onClick="PotvrdPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="VytlaËiù potvrdenie o podanÌ" ></a>

</td>
<td class="bmenu" width="18%">PrÌloha
<a href="#" onClick="TlacPrilohuPrehlad();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù prÌlohu vo form·te PDF' ></a>

TXT
<a href="#" onClick="TXTPrehlad();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvoriù TXT prÌlohu' ></a>

Uprav
<a href="#" onClick="UpravPrilohuPrehlad();">
<img src='../obr/klienti.png' width=20 height=15 border=0 title='Upraviù prÌlohu' ></a>
</td>

</td>
<td class="bmenu" width="10%">XML
<a href="#" onClick="XMLPrehlad();">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vytvoriù XML prÌlohu' ></a>
</td>

</td>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPrehlad();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Upraviù hodnoty' ></a>
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="ZnovuPrehlad();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty' ></a>
</td>
</tr>
</FORM>
</table>
<?php                                    } ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/brutto.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Prehæad BRUTTO miezd a zr·ûok</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_sp.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Rozpis odvodov do Soci·lnej poisùovne</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_zp.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Rozpis odvodov do Zdravotn˝ch poisùovnÌ</td>
</tr>
</table>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_dane.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Rozpis odvodov Dane z prÌjmu a zr·ûkovej dane</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/zlozky_mzdy.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Zostava mzdov˝ch zloûiek</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_ddp.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="96%">Zostava DoplnkovÈho DÙchodkovÈho Sporenia ( DDP )</td>

<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_ddp.php?copern=30&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvoriù s˙bor vo form·te XML pre DDP AXA' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_ddp.php?copern=40&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/tatrabanka.jpg' width=20 height=15 border=0 title='Vytvoriù s˙bor vo form·te TXT pre DDP TATRA' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_ddp.php?copern=50&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='Vytvoriù s˙bor vo form·te XML a TXT pre DDP NN d.s.s. ( ING TATRY SYMPATIA )' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/rozpis_ddp.php?copern=60&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Vytvoriù s˙bor vo form·te XML pre DDP STABILITA' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/banka_zam.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Platby cez BANKU - Zamestnanci
 <a href="#" onClick="window.open('../mzdy/banka_zam.php?copern=1&drupoh=2&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF - sumy za mzdovÈ zloûky' ></a>
 <a href="#" onClick="window.open('../mzdy/banka_zam.php?copern=1&drupoh=3&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF - sumy za banky' ></a>
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/vyplat_listina.php?&copern=2&page=1&ostre=0&zaloha=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="48%">V˝platn· listina - Z¡LOHA</td>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/paska_prevzal.php?&copern=2&page=1&ostre=0&zaloha=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="48%">Potvrdenie o prevzatÌ v˝platnej p·sky</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../mzdy/sumar_spzp.php?&copern=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="98%">Sum·r odvodov SP a ZP za zamestnancov a zamestn·vateæa</td>
</tr>
</table>


<table class="vstup" width="100%" >
<FORM name="formnd1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="Dovolenky();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='»erpanie a zostatok dovolenky zamestnancov vo form·te PDF' ></a>
</td>

<td class="bmenu" width="28%">»erpanie a zostatok dovolenky zamestnancov</td>
<td class="bmenu" width="70%">  
<input type="checkbox" name="aktpr" value="1"  />
 Aktu·lne priemery z ˙dajov o zamestnancoch 
</td>

<td class="bmenu" width="2%">
<a href="#" onClick="MinDovolenky();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Evidencia dovolenky prenesenej z minulÈho roka vo form·te PDF' ></a>
</td>
</tr>
</FORM>
</table>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="20%">MzdovÈ zostavy za STREDISK¡</td>
<td class="bmenu" width="12%">
<a href="#" onClick="window.open('../mzdy/str_brutto.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Prehæad BRUTTO miezd a zr·ûok vo form·te PDF' ></a>
BRUTTO</td>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../mzdy/str_rozpis_sp.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Rozpis odvodov do Soci·lnej poisùovne vo form·te PDF' ></a>
Rozpis SP</td>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../mzdy/str_rozpis_zp.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Rozpis odvodov do Zdravotn˝ch poisùovnÌ vo form·te PDF' ></a>
Rozpis ZP</td>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../mzdy/str_rozpis_dane.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Rozpis odvodov Dane z prÌjmu a zr·ûkovej dane vo form·te PDF' ></a>
Rozpis DaÚ z prÌjmu</td>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../mzdy/str_zlozky_mzdy.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Zostavu mzdov˝ch zloûiek vo form·te PDF' ></a>
MzdovÈ zloûky</td>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('../mzdy/banka_zam.php?copern=1&drupoh=1&page=1&zastr=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Zostavu vo form·te PDF' ></a>
Platby cez BANKU</td>
<td class="bmenu" width="10%">
<a href="#" onClick="DovolenkySTR();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù Zostavu vo form·te PDF' ></a>
Dovolenky</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="25%">
<a href="#" onClick="window.open('../mzdy/odprac_dni.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='OdpracovanÈ dni vo form·te PDF' ></a>
OdpracovanÈ dni zamestnancov</td>
<td class="bmenu" width="25%">
</td>
<td class="bmenu" width="25%">
</td>
<td class="bmenu" width="25%">
</td>
</tr>
</table>


<?php
           }
?>


<br /><br />
<?php
// celkovy koniec dokumentu

$zmenume=1; $odkaz="../mzdy/meszos.php?copern=1&drupoh=1&page=1&sysx=MZD";
$cislista = include("mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
