<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 1000;
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
//copern=1 z ciselnika ico, copern=2 z udajov o zamestnancovi
$copern = 1*$_REQUEST['copern'];
$cislo_ico = 1*$_REQUEST['cislo_ico'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$cislox = 1*$_REQUEST['cislox'];

$citfir = include("../cis/citaj_fir.php");

$sql = "SELECT numb FROM F$kli_vxcf"."_bicbanky ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_bicban ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   numb         VARCHAR(4) NOT NULL,
   nazb         VARCHAR(50) NOT NULL,
   bicb         VARCHAR(15) NOT NULL
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_bicban ".$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '0200', 'V�eobecn� �verov� banka, a.s.', 'SUBASKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '0900', 'Slovensk� sporite��a, a.s', 'GIBASKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '1100', 'Tatra banka, a.s.', 'TATRSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '1111', 'UniCredit Bank Slovakia, a.s', 'UNCRSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5200', 'OTP Banka Slovensko, a.s.', 'OTPVSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5600', 'OTP Banka Slovensko, a.s.', 'OTPVSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5900', 'Prv� stavebn� sporite��a, a.s.', 'PRVASKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '6500', 'Po�tov� banka, a.s.', 'POBNSKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7300', 'ING Bank N.V.', 'INGBSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7500', '�SOB � �eskoslovensk� obchodn� banka, a.s.', 'CEKOSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7930', 'W�stenrot stavebn� sporite��a, a.s.', 'WUSTSKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '8170', '�SOB stavebn� sporite��a, a.s.', 'KBSPSKBX' ) ";
$vytvor = mysql_query("$vsql");

}

$sql = "SELECT kontrol FROM F$kli_vxcf"."_dajiban".$kli_vxcf;
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_dajiban".$kli_vxcf." ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   cislox       DECIMAL(8,0) DEFAULT 0,

   zvysok       DECIMAL(10,0) DEFAULT 0,
   kontrol      VARCHAR(2) NOT NULL,
   vynasob      DECIMAL(13,8) DEFAULT 0,
   zaokruh      DECIMAL(13,0) DEFAULT 0,

   ucebx        VARCHAR(35) NOT NULL,
   numx         VARCHAR(35) NOT NULL,
   ibanx        VARCHAR(35) NOT NULL,

   predc6       VARCHAR(6) NOT NULL,
   uceb10       VARCHAR(10) NOT NULL,
   num4         VARCHAR(4) NOT NULL,

   csl30        VARCHAR(30) NOT NULL,

   bicx         VARCHAR(35) NOT NULL
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_dajiban".$kli_vxcf." ".$sqlt;
$vytvor = mysql_query("$vsql");

}

$vsql = "DELETE FROM F".$kli_vxcf."_dajiban".$kli_vxcf." ";
$vytvor = mysql_query("$vsql");

if( $copern == 1 AND $cislox == 1 )
{

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $cislo_ico ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucebx=$riaddok->uc1;
  $numx=$riaddok->nm1;
  }

}
if( $copern == 1 AND $cislox == 2 )
{

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $cislo_ico ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucebx=$riaddok->uc2;
  $numx=$riaddok->nm2;
  }

}
if( $copern == 1 AND $cislox == 3 )
{

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $cislo_ico ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucebx=$riaddok->uc3;
  $numx=$riaddok->nm3;
  }

}
if( $copern == 2 AND $cislox == 11 )
{

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucebx=$riaddok->uceb;
  $numx=$riaddok->numb;
  }

}



$vsql = "INSERT INTO F".$kli_vxcf."_dajiban".$kli_vxcf." ( cislox, ucebx, numx ) VALUES ( '$cislox', '$ucebx', '$numx' ) ";
$vytvor = mysql_query("$vsql");

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dajiban$kli_vxcf");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucebx=$riaddok->ucebx;
  $numx=$riaddok->numx;
  }

//rozdel ucebx na predcislie a cislo uctu


$pole = explode("-", $ucebx);
$predcislie=1*$pole[0];
$cislouctu=1*$pole[1];

$predc6=sprintf("%06.0f", $predcislie);
$uceb10=sprintf("%010.0f", $cislouctu);
$num4=sprintf("%04.0f", $numx);

if( $cislouctu == 0 ) 
{ 
$predc6="000000";
$uceb10=sprintf("%010.0f", $predcislie);

}

$statx="SK";
$stacx="2820";
//a=10,b=11,cdefghij,k=20,lmnopqr,s=28,tuvwx,y=34,z=35

$ibanx=$statx."00".$num4.$predc6.$uceb10;
$csl30=$num4.$predc6.$uceb10.$stacx."00";


 $num1 = $csl30;
 $num2 = 97;
 $r    = mysql_query("Select @sum:=$num1/$num2");
 $sumR = mysql_fetch_row($r);
 $sum  = $sumR[0];


$vydel=$csl30/97;
$vydel=$sum;
//echo $vydel."<br />";
//echo "773195876301352899281257,73195876<br />";

$pole = explode(".", $vydel);
$cele=1*$pole[0];
$zvysok=1*$pole[1];

$pole = explode("-", $ucebx);
$predcislie=1*$pole[0];
$cislouctu=1*$pole[1];

$nas="0.".$zvysok;

 $num1 = $nas;
 $num2 = 97;
 $r    = mysql_query("Select @sum:=$num1*$num2");
 $sumR = mysql_fetch_row($r);
 $sum  = $sumR[0];

$vynasob=$sum;


$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zvysok='$zvysok', vynasob=$vynasob ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zaokruh=vynasob ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zaokruh=98-zaokruh ";
$vytvor = mysql_query("$vsql");

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dajiban$kli_vxcf");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kontx=$riaddok->zaokruh;
  }

$kont2=sprintf("%02.0f", $kontx);
$ibanx=$statx.$kont2.$num4.$predc6.$uceb10;

$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET ibanx='$ibanx', predc6='$predc6', uceb10='$uceb10', num4='$num4', csl30='$csl30' ";
$vytvor = mysql_query("$vsql");

$bicx="";
  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_bicban WHERE numb = '$numx' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $bicx=$riaddok->bicb;
  }


$ibanxs=$ibanx."-".$bicx;

if( $copern == 1 AND $cislox == 1 )
{

$vsql = "UPDATE F".$kli_vxcf."_ico SET ib1='$ibanxs' WHERE ico = $cislo_ico ";
$vytvor = mysql_query("$vsql");

}
if( $copern == 1 AND $cislox == 2 )
{

$vsql = "UPDATE F".$kli_vxcf."_ico SET ib2='$ibanxs' WHERE ico = $cislo_ico ";
$vytvor = mysql_query("$vsql");

}
if( $copern == 1 AND $cislox == 3 )
{

$vsql = "UPDATE F".$kli_vxcf."_ico SET ib3='$ibanxs' WHERE ico = $cislo_ico ";
$vytvor = mysql_query("$vsql");

}
if( $copern == 2 AND $cislox == 11 )
{

$vsql = "UPDATE F".$kli_vxcf."_mzdtextmzd SET ziban='$ibanx', zswft='$bicx' WHERE invt = $cislo_oc ";
$vytvor = mysql_query("$vsql");

}



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie faktury uloz</title>

<script type="text/javascript">


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
//prepni spat

//cico.php?sys=ALL&copern=8&page=1&cislo_ico=360842&h_ico=360842
if( $copern == 1 )
{
?>
<script type="text/javascript">

window.open('../cis/cico.php?sys=ALL&copern=8&page=1&cislo_ico=<?php echo $cislo_ico; ?>&h_ico=<?php echo $cislo_ico; ?>', '_self' )

</script>
<?php
}

//zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=1&h_oc=1
if( $copern == 2 )
{
?>
<script type="text/javascript">

window.open('../mzdy/zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $cislo_oc; ?>&h_oc=<?php echo $cislo_oc; ?>', '_self' )

</script>
<?php
}



exit;

//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
