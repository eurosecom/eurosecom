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

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//datova tabulka
$sql = "SELECT druh FROM F$kli_vxcf"."_uctfakuhrdph ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "DROP TABLE F".$kli_vxcf."_uctfakuhrdph ";
$vysledek = mysql_query("$sql");

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   druh        DECIMAL(10,0) DEFAULT 0,
   dppx        DECIMAL(2,0) DEFAULT 0,
   prx7        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "CREATE TABLE F".$kli_vxcf."_uctfakuhrdph ".$sqlt;
$vysledek = mysql_query("$sql");

}

//copern=900 uloz nastavenie vstf_u, 901 uloz z fakuhrdph
if( $copern == 900 OR $copern == 901 )
{

$dppx = 1*$_REQUEST['dppx'];

$sql = "DELETE FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ";
$vysledek = mysql_query("$sql");


$sql = "INSERT INTO F".$kli_vxcf."_uctfakuhrdph ( dok, druh, dppx, prx7 ) VALUES ( '$cislo_dok', '$drupoh', '$dppx', 1 ) ";
if( $dppx == 1 ) { $vysledek = mysql_query("$sql"); }


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
//vstf_u.php?vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=710031&h_fak=710031&h_dol=0&h_prf=0

//prepni do faktury
if( $copern == 900 )
{
?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?copern=8&drupoh=<?php echo $drupoh; ?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT', '_self' )

</script>
<?php
exit;
}
//koniec prepni do faktury


//http://localhost/ucto/fakuhrdph.php?copern=1&cislo_dok=801004&drupoh=2

//prepni do fakuhrdph
if( $copern == 901 )
{
?>
<script type="text/javascript">

window.open('../ucto/fakuhrdph.php?copern=1&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self' )

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
