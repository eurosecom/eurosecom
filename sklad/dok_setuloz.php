<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
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
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$drupoh = 1*$_REQUEST['drupoh'];

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


//copern=900 uloz nastavenie
if( $copern == 900 )
{
$kliuzid = $_REQUEST['kliuzid'];
$ajpoznam = $_REQUEST['ajpoznam'];
$poznampod = $_REQUEST['poznampod'];
$ajstrzak = $_REQUEST['ajstrzak'];

$ttvv = "DELETE FROM F$kli_vxcf"."_skldokset$kli_uzid WHERE id = $kliuzid ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_skldokset$kli_uzid ( id, ajpoznam, poznampod, ajstrzak ) VALUES ( '$kliuzid', '$ajpoznam', '$poznampod', '$ajstrzak' )";
$ttqq = mysql_query("$ttvv");


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


//prepni do skladu
$cstat=10101;
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../sklad/vstp_u.php?copern=8&drupoh=<?php echo $drupoh; ?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>', '_self' )

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
