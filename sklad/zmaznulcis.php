<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 820;
$cslm=404500;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

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


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


//zmaz nulove cis LEN AK NIEJE PRIJ alebo VYDAJ
if( $copern == 10 )
{
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklpri WHERE cis >= 0 ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;

if( $cpol > 0 ) { echo "Nulové materiálové karty môžete maza len na zaèiatku roka ak ešte nie sú nahraté príjemky alebo výdajky zo skladu "; exit; }

$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklvyd WHERE cis >= 0 ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;

if( $cpol > 0 ) { echo "Nulové materiálové karty môžete maza len na zaèiatku roka ak ešte nie sú nahraté príjemky alebo výdajky zo skladu "; exit; }

if( $cpol == 0 )
               {

$sql = "ALTER TABLE F$kli_vxcf"."_sklcis ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_sklcis,F$kli_vxcf"."_sklpoc SET plati=9 WHERE F$kli_vxcf"."_sklcis.cis = F$kli_vxcf"."_sklpoc.cis ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_sklcisudaje,F$kli_vxcf"."_sklpoc SET plati=9 WHERE F$kli_vxcf"."_sklcisudaje.xcis = F$kli_vxcf"."_sklpoc.cis ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklcis WHERE plati != 9 AND cis > 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklcisudaje WHERE plati != 9 ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_sklcis DROP plati ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sklcisudaje DROP plati ";
$vysledek = mysql_query("$sql");

               }

}




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Mazanie nulcis</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

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
<td>EuroSecom  -  Mazanie nulových skladových kariet ukonèené !

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
