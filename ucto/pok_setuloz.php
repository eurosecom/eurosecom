<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 900;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$strana = 1*$_REQUEST['strana'];
$hladaj_uce = 1*$_REQUEST['hladaj_uce'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
//$cislo_dok=710031;
//echo $cislo_dok;
//exit;

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$zlava = 1*$_REQUEST['zlava'];

//copern=900 uloz nastavenie pok
if( $copern == 900 )
{
$ucm1 = $_REQUEST['h_ucm1'];
$ucm2 = $_REQUEST['h_ucm2'];
$ucm3 = $_REQUEST['h_ucm3'];
$ucm4 = $_REQUEST['h_ucm4'];
$ucm5 = $_REQUEST['h_ucm5'];
$ico1 = 1*$_REQUEST['h_ico1'];
$ico2 = 1*$_REQUEST['h_ico2'];
$ico3 = 1*$_REQUEST['h_ico3'];
$ico4 = 1*$_REQUEST['h_ico4'];
$ico5 = 1*$_REQUEST['h_ico5'];
$premenna = $_REQUEST['premenna'];
$zmd = 1*$_REQUEST['zmd'];
$zdl = 1*$_REQUEST['zdl'];
$omd = 1*$_REQUEST['omd'];
$odl = 1*$_REQUEST['odl'];
$pmd = 1*$_REQUEST['pmd'];
$pdl = 1*$_REQUEST['pdl'];


$ttvv = "DELETE FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$ttqq = mysql_query("$ttvv");
$ttvv = "DELETE FROM F$kli_vxcf"."_pokladnicaset ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_pokladnicaset ( polozka,ucm1,ucm2,ucm3,ucm4,ucm5,ico1,ico2,ico3,ico4,ico5,zmd,zdl,omd,odl,pmd,pdl ) ".
" VALUES ( '$premenna', '$ucm1', '$ucm2', '$ucm3', '$ucm4', '$ucm5', '$ico1', '$ico2', '$ico3', '$ico4', '$ico5', ".
" '$zmd', '$zdl', '$omd', '$odl', '$pmd', '$pdl' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_pokladnicaset$kli_uzid ( polozka,ucm1,ucm2,ucm3,ucm4,ucm5,ico1,ico2,ico3,ico4,ico5,zmd,zdl,omd,odl,pmd,pdl ) ".
" VALUES ( '$premenna', '$ucm1', '$ucm2', '$ucm3', '$ucm4', '$ucm5', '$ico1', '$ico2', '$ico3', '$ico4', '$ico5', ".
" '$zmd', '$zdl', '$omd', '$odl', '$pmd', '$pdl' )";
$ttqq = mysql_query("$ttvv");

}
//koniec copern=900 uloz nastavenie fak

//echo $drupoh;
//exit;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie faktury uloz</title>
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

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//<a href='vspk_u.php?sysx=UCT&hladaj_uce=21100&rozuct=ANO&copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT
//&cislo_dok=10003&h_ico=31424319&h_uce=21100&h_unk='>

//prepni do pokl
$cstat=10101;
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/vspk_u.php?sysx=UCT&copern=7&drupoh=<?php echo $drupoh; ?>&rozuct=ANO&copern=8&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&h_uce=<?php echo $hladaj_uce; ?>', '_self' );

</script>
<?php
exit;
}
//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
