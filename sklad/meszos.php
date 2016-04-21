<HTML>
<?php
$sys = 'SKL';
$urov = 1000;
$cslm=402100;
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
if( $_SERVER['SERVER_NAME'] == "www.mlynzahorie.sk" ) { $cenahranica1=0.95*$cenazprijmu; $cenahranica2=1.05*$cenazprijmu; }

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
<title>Mesaèné zostavy</title>
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

window.open('../ucto/kniha_faktur.php?h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&h_drp=' + h_drp +  '&copern=1&drupoh=1&page=1&typ=PDF', '_blank', '<?php echo $tlcswin; ?>' )
                }

  function PohSklM()
  { 
  var okno = window.open("../sklad/pohskl_pdf.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function PohSklO()
  { 
  var okno = window.open("../sklad/pohskl_pdf.php?copern=20&page=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function PohSklMOld()
  { 
  var okno = window.open("../sklad/pohskl.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function PohSklOOld()
  { 
  var okno = window.open("../sklad/pohskl.php?copern=20&page=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function SklPohM()
  { 
  var okno = window.open("../sklad/pohyby_pdf.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function SklPohO()
  { 
  var okno = window.open("../sklad/pohyby_pdf.php?copern=20&page=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function PohDruM()
  { 
  var okno = window.open("../sklad/pohskl_pdf.php?copern=10&page=1&druh=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function PohDruO()
  { 
  var okno = window.open("../sklad/pohdru.php?copern=20&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function SpoZakM()
  { 
  var okno = window.open("../sklad/spozak.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function SpoZakO()
  { 
  var okno = window.open("../sklad/spozak.php?copern=20&page=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function ZosCisM()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=20","_blank",'<?php echo $tlcswin; ?>');
  }
  function ZosPriM()
  { 
  var okno = window.open("../sklad/zprijmu_pdf.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function ZosVydM()
  { 
  var okno = window.open("../sklad/zvydaja_pdf.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }
  function ZosPreM()
  { 
  var okno = window.open("../sklad/zpresun.php?copern=10&page=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function Regleta()
  { 
  var okno = window.open("../sklad/regleta_pdf.php?copern=20","_blank",'<?php echo $tlcswin; ?>');
  }

  function RegletaDru()
  { 
  var okno = window.open("../sklad/regletadru_pdf.php?copern=20","_blank",'<?php echo $tlcswin; ?>');
  }

</script>
</HEAD>
<BODY class="white" onload="">






<?php
if( $copern == 1 )
           {
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Sklady - Mesaèné zostavy </td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="PohSklM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Pohyb materiálu v skladoch - mesaèný</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="PohDruM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Pohyb materiálu za druh - mesaèný</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="SklPohM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Druhy pohybov v skladoch - mesaèné</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZosCisM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Stav zásob - mesaèný</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZosPriM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Zostava príjmu - mesaèná</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZosVydM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Zostava výdaja - mesaèná</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZosPreM();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Zostava presunu - mesaèná</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="Regleta();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Regleta zásob - mesaèná</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="RegletaDru();">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td class="bmenu" width="90%">Stav zásob pod¾a materiálových druhov - mesaèná</td>
</tr>
</table>


<?php
           }
?>







<br /><br />
<?php
// celkovy koniec dokumentu

$zmenume=1; $odkaz="../sklad/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("skl_lista.php");

       } while (false);
?>
</BODY>
</HTML>
