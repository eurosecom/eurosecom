<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=103600;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Preh¾ady dokladov</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Finanèné úètovníctvo - Preh¾ady dokladov</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
if( $copern == 1 )
           {
?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=101&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných odberate¾ských faktúr</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=102&drupoh=2&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných dodávate¾ských faktúr</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=103&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných príjmových pokladnièných dokladov</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=104&drupoh=2&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných výdavkových pokladnièných dokladov</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=114&drupoh=4&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných bankových výpisov</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/zozdok.php?copern=115&drupoh=5&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="Vytlaèi" ></a>
</td>
<td class="bmenu" width="90%">Zoznam rozúètovaných všeobecných úètovných dokladov</td>
</tr>
</table>

<?php
           }
?>

<br /><br />
<?php
// celkovy koniec dokumentu

if( $copern == 1 ) { 
$zmenume=1; 
$odkaz="../ucto/prhdok.php?copern=1&drupoh=1&page=1&sysx=UCT"; 
                   }

$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
