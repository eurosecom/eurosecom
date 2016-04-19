<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 2000;
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

$nastav = $_REQUEST['nastav'];

$cislo_oc = $_REQUEST['cislo_oc'];
$umep="1.".$kli_vrok;
$umek="3.".$kli_vrok;
if( $cislo_oc == 2 ) { $umep="4.".$kli_vrok; $umek="6.".$kli_vrok; }
if( $cislo_oc == 3 ) { $umep="7.".$kli_vrok; $umek="9.".$kli_vrok; }
if( $cislo_oc == 4 ) { $umep="10.".$kli_vrok; $umek="12.".$kli_vrok; }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//pozri do sklfak a oprav nulove cen
if( $fir_xsk04 == 1 ) {


$dsqlt = "DROP TABLE F$kli_vxcf"."_sklzaspriemer ";
$dsql = mysql_query("$dsqlt");

$kli_vxcfskl=$kli_vxcf;
$priemer = include("sklzaspriemer.php");


$sqlttxc = "SELECT * FROM F$kli_vxcf"."_sklfak WHERE cen = 0  ";
$tovxc = mysql_query("$sqlttxc");
$tvpolxc = mysql_num_rows($tovxc);


if( $kli_uzid > 0 )
 {

$sqlttx = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE tl3 = 1  ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
          
$ix=0;

  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);

$cenazprijmu=0;
$poslhh = "SELECT * FROM F$kli_vxcf"."_sklpri WHERE cis = $riadokx->cis ORDER BY dat DESC ";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $cenazprijmu = 1*$posled->cen;
  $cis = $posled->cis;
  }

$cenahranica1=0.4*$cenazprijmu; $cenahranica2=1.5*$cenazprijmu;
if( $_SERVER['SERVER_NAME'] == "www.mlynzahorie.sk" ) { $cenahranica1=0.9*$cenazprijmu; $cenahranica2=1.1*$cenazprijmu; }

if( $cenazprijmu > 0 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=$cenazprijmu WHERE cis = $riadokx->cis AND ( cen < $cenahranica1 OR cen > $cenahranica2 ) ";
$dsql = mysql_query("$dsqlt");
  }

}
$ix=$ix+1;
  }

 }
//koniec ak kliuzid > 0

$dsqlt = "UPDATE F$kli_vxcf"."_sklfak,F$kli_vxcf"."_sklzaspriemer SET F$kli_vxcf"."_sklfak.cen=F$kli_vxcf"."_sklzaspriemer.cen ".
" WHERE F$kli_vxcf"."_sklfak.cis=F$kli_vxcf"."_sklzaspriemer.cis AND F$kli_vxcf"."_sklfak.cen=0 ";
$dsql = mysql_query("$dsqlt");

if( $tvpolxc > 0 )
  {
$dsqlt = "DROP TABLE F$kli_vxcf"."_sklzaspriemer ";
$dsql = mysql_query("$dsqlt");

$kli_vxcfskl=$kli_vxcf;
$priemer = include("sklzaspriemer.php");
  }
                      }
//koniec pozri do sklfak a oprav nulove cen

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Informácie o zásobách</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


function TlacNakup1()
                {

window.open('../sklad/info_nakup.php?copern=10&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacNakup2()
                {

window.open('../sklad/info_nakup.php?copern=20&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacSpotZak()
                {
var h_oc = document.forms.formp3.h_oc.value;
var h_obdp = document.forms.formp3.h_obdp.value;
var h_obdk = document.forms.formp3.h_obdk.value;

window.open('../sklad/info_spotzak.php?cislo_zak=' + h_oc + '&copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPrijZak()
                {
var h_oc = document.forms.formp4.h_oc.value;
var h_obdp = document.forms.formp4.h_obdp.value;
var h_obdk = document.forms.formp4.h_obdk.value;

window.open('../sklad/info_spotzak.php?cislo_zak=' + h_oc + '&copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=2&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacZostZak()
                {
var h_oc = document.forms.formp5.h_oc.value;
var h_obdp = document.forms.formp5.h_obdp.value;
var h_obdk = document.forms.formp5.h_obdk.value;

window.open('../sklad/info_spotzak.php?cislo_zak=' + h_oc + '&copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=3&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPrnem()
                {

                }



  function PohSklO()
  { 
  var okno = window.open("../sklad/pohskl_pdf.php?copern=20&page=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function SklPohO()
  { 
  var okno = window.open("../sklad/pohyby_pdf.php?copern=20&page=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }


  function PohDruO()
  { 
  var okno = window.open("../sklad/pohskl_pdf.php?copern=20&page=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function SpoZakO()
  { 
  var okno = window.open("../sklad/spozak.php?copern=20&page=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZas()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasCSV()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=10&docsv=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasObj()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=10&objdod=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasKat()
  { 
  var okno = window.open("../sklad/sklzaskat_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasKom()
  { 
  var okno = window.open("../sklad/sklzaskom_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasBezKom()
  { 
  var okno = window.open("../sklad/sklzaskom_pdf.php?copern=10&bezkom=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasCPA()
  { 
  var okno = window.open("../sklad/sklzascpa_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasNula()
  { 
  var okno = window.open("../sklad/sklzasnula_pdf.php?copern=10&zapornacen=0","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavCenMinus()
  { 
  var okno = window.open("../sklad/sklzasnula_pdf.php?copern=10&zapornacen=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }


  function StavAlkoholu()
  { 
  var okno = window.open("../sklad/alkohol_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasMin()
  { 
  var okno = window.open("../sklad/sklzasmin_pdf.php?copern=10","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasMinCSV()
  { 
  var okno = window.open("../sklad/sklzasmin_pdf.php?copern=10&docsv=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasMinObj()
  { 
  var okno = window.open("../sklad/sklzasmin_pdf.php?copern=10&objdod=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function StavZasMinObjCSV()
  { 
  var okno = window.open("../sklad/sklzasmin_pdf.php?copern=10&objdod=1&docsv=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function RegletaKom()
  { 
var h_obdp = document.forms.formvk.h_obdp.value;
var h_obdk = document.forms.formvk.h_obdk.value;

  var okno = window.open('../sklad/regletakom_pdf.php?copern=20&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&xx=1',"_blank",'width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

  function RegletaKomCSV()
  { 
var h_obdp = document.forms.formvk.h_obdp.value;
var h_obdk = document.forms.formvk.h_obdk.value;

  var okno = window.open('../sklad/regletakom_pdf.php?copern=20&docsv=1&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&xx=1',"_blank",'width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

  function RegletaKomDod()
  { 
var h_obdp = document.forms.formvk.h_obdp.value;
var h_obdk = document.forms.formvk.h_obdk.value;

  var okno = window.open('../sklad/regletakom_pdf.php?copern=20&zadod=1&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&xx=1',"_blank",'width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

function TlacPohDok()
                {
var h_oc = document.forms.formpp5.h_oc.value;
var h_obdp = document.forms.formpp5.h_obdp.value;
var h_obdk = document.forms.formpp5.h_obdk.value;

window.open('../sklad/info_pohdok.php?cislo_poh=' + h_oc + '&copern=101&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=1&page=1&tlacitR=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyberVstup()
                {


<?php  echo "document.forms.formp3.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formp3.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formp4.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formp4.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formp5.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formp5.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formpp5.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formpp5.h_obdk.value=$kli_vmes; "; ?>

<?php  echo "document.forms.formvk.h_obdp.value=$kli_vmes; "; ?>
<?php  echo "document.forms.formvk.h_obdk.value=$kli_vmes; "; ?>
                } 

  function ExportEan()
  { 
  var okno = window.open("ccis_xml.php?copern=10&drupoh=1&page=1&exportean=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function VpsStavZasMinObj()
  { 
  var okno = window.open("../sklad/sklzasminvps_pdf.php?copern=10&objdod=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function VpsStavZasMinObjCSV()
  { 
  var okno = window.open("../sklad/sklzasminvps_pdf.php?copern=10&objdod=1&docsv=1","_blank",'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

</script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Informácie o zásobách

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
<a href="#" onClick="TlacNakup1();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zostavu v tvare PDF' ></a>
</td>
<td class="bmenu" width="98%">
 Informácie o nákupe zásob - od akých dodávate¾ov sme nakupovali materiálové a tovarové položky 
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacNakup2();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zostavu v tvare PDF' ></a>
</td>
<td class="bmenu" width="98%">
 Informácie o nákupe zásob - èo sme nakupovali od dodávate¾ov
</td>
</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<FORM name="formp3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacSpotZak();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi výdaj na vybranú zákazku a obdobie vo formáte PDF' ></a>
</td>
<td class="bmenu" width="78%">Výdaj na vybranú zákazku za vybrané obdobie
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE zak > 0 ORDER BY zak");
?>
<select size="1" name="h_oc" id="h_oc" >
<option value="999999999999" >Všetky </option>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zak"];?>" >
<?php echo $zaznam["zak"];?> <?php echo $zaznam["nza"];?> </option>
<?php endwhile;?>
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
<FORM name="formp4" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPrijZak();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi príjem na vybranú zákazku a obdobie vo formáte PDF' ></a>
</td>
<td class="bmenu" width="78%">Príjem na vybranú zákazku za vybrané obdobie
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE zak > 0 ORDER BY zak");
?>
<select size="1" name="h_oc" id="h_oc" >
<option value="999999999999" >Všetky </option>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zak"];?>" >
<?php echo $zaznam["zak"];?>  <?php echo $zaznam["nza"];?> </option>
<?php endwhile;?>
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
<FORM name="formp5" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacZostZak();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi príjem na vybranú zákazku a obdobie vo formáte PDF' ></a>
</td>
<td class="bmenu" width="78%">Zostatok materiálu na zákazke za vybrané obdobie
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE zak > 0 ORDER BY zak");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["zak"];?>" >
<?php echo $zaznam["zak"];?>  <?php echo $zaznam["nza"];?> </option>
<?php endwhile;?>
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
<a href="#" onClick="PohSklO();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="98%">Pohyb materiálu v skladoch - okamžitý stav</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="PohDruO();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="98%">Pohyb materiálu za druh - okamžitý stav</td>
</tr>
</table>


<table class="vstup" width="100%" >
<FORM name="formpp5" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="TlacPohDok();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="78%">Doklady za vybraný skladový pohyb
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph WHERE poh > 0 ORDER BY poh");
?>
<select size="1" name="h_oc" id="h_oc" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["poh"];?>" >
<?php echo $zaznam["poh"];?>  <?php echo $zaznam["nph"];?> </option>
<?php endwhile;?>
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
<a href="#" onClick="StavZas();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="StavZasCSV();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export stavu zásob do CSV' ></a>
</td>
<td class="bmenu" width="96%">Stav zásob - okamžitý stav

<a href="#" onClick="StavZasKat();">
KAT<img src='../obr/tlac.png' width=20 height=15 border=0 title='Stav zásob pod¾a Kategórií vo formáte PDF' ></a>

<a href="#" onClick="StavZasKom();">
KOM<img src='../obr/tlac.png' width=20 height=15 border=0 title='Stav Komisionálnych zásob vo formáte PDF' ></a>

<a href="#" onClick="StavZasBezKom();">
-KOM<img src='../obr/tlac.png' width=20 height=15 border=0 title='Stav zásob na sklade bez Komisionálnych zásob vo formáte PDF' ></a>

<a href="#" onClick="StavZasCPA();">
CPA<img src='../obr/tlac.png' width=20 height=15 border=0 title='Stav zásob pod¾a kódov CPA vo formáte PDF' ></a>

<a href="#" onClick="StavZasObj();">-OBJ,-DOD
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Stav zásob s odpoèítaním objednávok a dodacích listov v Eshope vo formáte PDF' ></a>


</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SklPohO();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="98%">Druhy pohybov v skladoch - okamžitý stav</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="StavZasNula();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi Skladové položky s nulovým množstvom a nenulovou hodnotou vo formáte PDF' ></a>
</td>
<td class="bmenu" width="98%">Skladové položky s nulovým množstvom a nenulovou hodnotou alebo 
 <a href="#" onClick="StavCenMinus();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi Skladové položky so zápornou priemernou cenou vo formáte PDF' ></a>
 so zápornou priemernou cenou</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="StavAlkoholu();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="96%">Okamžitý stav zásob alkoholu - pod¾a EAN kódov</td>
<td class="bmenu" width="2%">
<a href="#" onClick="ExportEan();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export EAN kódov do XML' ></a>
</td>
</tr>
</table>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="StavZasMin();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="StavZasMinCSV();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>
<td class="bmenu" width="86%">Vyhodnotenie minimálneho stavu zásob 
<a href="#" onClick="StavZasMinObj();">-OBJ,-DOD
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vyhodnotenie minimálnych zásob so zoh¾adnením objednávok a dodacích listov v Eshope vo formáte PDF' ></a>

<a href="#" onClick="StavZasMinObjCSV();"> 
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>


<td class="bmenu" width="10%">
<a href="#" onClick="VpsStavZasMinObj();">-OB,-DL ièo
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vyhodnotenie minimálnych zásob so zoh¾adnením objednávok a dodacích listov v Eshope pod¾a Dodávate¾ovvo formáte PDF ' ></a>

<a href="#" onClick="VpsStavZasMinObjCSV();"> 
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>

</td>
</tr>
</table>

<table class="vstup" width="100%" >
<FORM name="formvk" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="RegletaKom();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="2%">
<a href="#" onClick="RegletaKomCSV();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Export zostavy do CSV' ></a>
</td>
<td class="bmenu" width="76%">Vyhodnotenie stavu a predaja komisionálnych zásob

<a href="#" onClick="RegletaKomDod();">DOD
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vyhodnotenie stavu a predaja komisionálnych zásob pod¾a dodávate¾a' ></a>

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




<br />
<?php
}
//koniec zakladnej ponuky
?>



<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu

$zmenume=1; $odkaz="../sklad/info_zas.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("skl_lista.php");

       } while (false);
?>
</BODY>
</HTML>
