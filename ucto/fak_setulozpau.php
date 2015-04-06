<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
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
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$hladaj_uce = 1*$_REQUEST['hladaj_uce'];

$citfir = include("../cis/citaj_fir.php");

$udp=$_REQUEST['udp'];
$adp=$_REQUEST['adp'];
$uzk=$_REQUEST['uzk'];
$azk=$_REQUEST['azk'];
$ajo=$_REQUEST['ajo'];
$aju=$_REQUEST['aju'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//copern=900 uloz nastavenie 
if( $copern == 900 )
{

$ttvv = "DELETE FROM F$kli_vxcf"."_autopausal$kli_uzid ";
$ttqq = mysql_query("$ttvv");

$vsql = "INSERT INTO F".$kli_vxcf."_autopausal".$kli_uzid." ( id, udp, adp, uzk, azk, ajo, aju ) VALUES ".
" ( '$kli_uzid', '$udp', '$adp', '$uzk', '$azk', '$ajo', '$aju' ) ";
$vytvor = mysql_query("$vsql"); 


}
//koniec copern=900 uloz nastavenie 



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

//prepni do pokl
$cstat=10101;
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/vstpok.php?copern=1&drupoh=<?php echo $drupoh; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>', '_self' )

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
