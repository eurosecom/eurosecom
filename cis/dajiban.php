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
//copern=1 z ciselnika ico, copern=2 z udajov o zamestnancovi, copern=3 kontrola z prikazu na uhradu
$copern = 1*$_REQUEST['copern'];
$cislo_ico = 1*$_REQUEST['cislo_ico'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$cislox = 1*$_REQUEST['cislox'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_uce = 1*$_REQUEST['cislo_uce'];

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

$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '0200', 'Všeobecná úverová banka, a.s.', 'SUBASKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '0900', 'Slovenská sporite¾òa, a.s', 'GIBASKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '1100', 'Tatra banka, a.s.', 'TATRSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '1111', 'UniCredit Bank Slovakia, a.s', 'UNCRSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5200', 'OTP Banka Slovensko, a.s.', 'OTPVSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5600', 'OTP Banka Slovensko, a.s.', 'OTPVSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '5900', 'Prvá stavebná sporite¾òa, a.s.', 'PRVASKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '6500', 'Poštová banka, a.s.', 'POBNSKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7300', 'ING Bank N.V.', 'INGBSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7500', 'ÈSOB – Èeskoslovenská obchodná banka, a.s.', 'CEKOSKBX' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '7930', 'Wüstenrot stavebná sporite¾òa, a.s.', 'WUSTSKBA' ) ";
$vytvor = mysql_query("$vsql");
$vsql = "INSERT INTO F".$kli_vxcf."_bicban ( numb, nazb, bicb ) VALUES ( '8170', 'ÈSOB stavebná sporite¾òa, a.s.', 'KBSPSKBX' ) ";
$vytvor = mysql_query("$vsql");

}

$sql = "SELECT ibanold FROM F$kli_vxcf"."_dajiban".$kli_vxcf;
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_dajiban".$kli_vxcf." ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   cislocpl     DECIMAL(8,0) DEFAULT 0,
   ibanold      VARCHAR(35) NOT NULL,
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


$vsql = "INSERT INTO F".$kli_vxcf."_dajiban".$kli_vxcf." ( cislocpl, cislox, ucebx, numx ) VALUES ( 1, '$cislox', '$ucebx', '$numx' ) ";
$vytvor = mysql_query("$vsql");

if( $copern == 3 )
{

$vsql = "DELETE FROM F".$kli_vxcf."_dajiban".$kli_vxcf." ";
$vytvor = mysql_query("$vsql");

//cislocpl	ibanold	cislox	zvysok	kontrol	vynasob	zaokruh	ucebx	numx	ibanx	predc6	uceb10	num4	csl30	bicx
//dok	cpl	uceb	numb	iban	pbic	twib	vsy	ksy	ssy	hodp	hodm	uce	ico	id	datm


$vsql = "INSERT INTO F".$kli_vxcf."_dajiban".$kli_vxcf." SELECT ".
" cpl, iban, 0, 0, '', 0, 0, '', '', '', '', '', '', '', '' ".
" FROM F".$kli_vxcf."_uctprikp WHERE dok = $cislo_dok ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET ".
" ucebx=CONCAT(SUBSTRING(ibanold, 9, 6),'-',SUBSTRING(ibanold, 15, 10)), ".
" numx=SUBSTRING(ibanold, 5, 4)  ".
" WHERE cislocpl > 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "DELETE FROM F".$kli_vxcf."_dajiban".$kli_vxcf." WHERE SUBSTRING(ibanold, 1, 2) != 'SK' ";
$vytvor = mysql_query("$vsql");


}


          $vyslettt = "SELECT * FROM F$kli_vxcf"."_dajiban".$kli_vxcf." WHERE cislocpl > 0 ORDER BY cislocpl ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {
          //zaciatok cyklu

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dajiban$kli_vxcf WHERE cislocpl = $riadok->cislocpl ");
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
$zvysok=$pole[1];

$pole = explode("-", $ucebx);
$predcislie=1*$pole[0];
$cislouctu=1*$pole[1];

$nas="0.".$zvysok;
//echo $nas."<br />";

 $num1 = $nas;
 $num2 = 97;
 $r    = mysql_query("Select @sum:=$num1*$num2");
 $sumR = mysql_fetch_row($r);
 $sum  = $sumR[0];

$vynasob=$sum;


$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zvysok='$zvysok', vynasob=$vynasob WHERE cislocpl = $riadok->cislocpl ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zaokruh=vynasob WHERE cislocpl = $riadok->cislocpl ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET zaokruh=98-zaokruh WHERE cislocpl = $riadok->cislocpl ";
$vytvor = mysql_query("$vsql");

  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dajiban$kli_vxcf WHERE cislocpl = $riadok->cislocpl ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kontx=$riaddok->zaokruh;
  }

$kont2=sprintf("%02.0f", $kontx);
$ibanx=$statx.$kont2.$num4.$predc6.$uceb10;

$vsql = "UPDATE F".$kli_vxcf."_dajiban".$kli_vxcf." SET ibanx='$ibanx', predc6='$predc6', uceb10='$uceb10', num4='$num4', csl30='$csl30' WHERE cislocpl = $riadok->cislocpl ";
$vytvor = mysql_query("$vsql");

$bicx="";
  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_bicban WHERE numb = '$numx' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $bicx=$riaddok->bicb;
  }

//exit;

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
$sqltt = "INSERT INTO F$kli_vxcf"."_mzdtextmzd ( invt ) VALUES ( '$cislo_oc' ) ";
$sql = mysql_query("$sqltt");

$vsql = "UPDATE F".$kli_vxcf."_mzdtextmzd SET ziban='$ibanx', zswft='$bicx' WHERE invt = $cislo_oc ";
$vytvor = mysql_query("$vsql");

}

          }
          //koniec cyklu

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie faktury uloz</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

  </style>
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
?>

<?php
//zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=1&h_oc=1
if( $copern == 2 )
{
?>
<script type="text/javascript">

window.open('../mzdy/zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $cislo_oc; ?>&h_oc=<?php echo $cislo_oc; ?>', '_self' )

</script>
<?php
}
?>

<?php
//ucto/vspr_u.php?sysx=UCT&hladaj_uce=22100&rozuct=NIE&copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT
//&cislo_dok=3&h_ico=36084299&h_uce=22100&h_unk=
if( $copern == 3333 )
{
?>
<script type="text/javascript">

window.open('../ucto/vspr_u.php?sysx=UCT&rozuct=NIE&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_uce=<?php echo $cislo_uce; ?>&copern=8', '_self' )

</script>
<?php
}
?>

<?php
//kontrola prikazu na uhradu
if( $copern == 3 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_dajiban$kli_vxcf WHERE cislocpl > 0 ORDER BY cislocpl ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;

  while ($i <= $pol )
  {

if ( $i == 0 )
      {
?>

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" width="5%">è.p.</td>
<td class="bmenu" width="20%">IBAN na príkaze</td>
<td class="bmenu" width="20%">IBAN vypoèítaný</td>
<td class="bmenu" width="5%">STAV</td>
<td class="bmenu" width="20%">IÈO</td>
<td class="bmenu" width="20%">ZAMESTNANEC</td>
</tr>
<?php
      }
//koniec j=0

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$hvstup="hvstup";
$stav="OK";
if( $polozka->ibanold != $polozka->ibanx ) { $hvstup="hvstup_bred"; $stav="ROZDIEL"; }

$ico=0; $iconaz=""; $polico=0;

if( $polico == 0 ) 
  {
$sqlfir1 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib1 LIKE '%".$polozka->ibanold."%' ";
$fir_vysledok1 = mysql_query($sqlfir1);
$polico1 = 1*mysql_num_rows($fir_vysledok1);
if( $fir_vysledok1 ) 
{
$fir_riadok1=mysql_fetch_object($fir_vysledok1);

$ico = $fir_riadok1->ico;
$iconaz = $fir_riadok1->nai;
}
  }

if( $polico > 0 ) { $polico1=1; $polico2=1; }

if( $polico1 == 0 ) 
  {
$sqlfir2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib2 LIKE '%".$polozka->ibanold."%' ";
$fir_vysledok2 = mysql_query($sqlfir2);
$polico2 = 1*mysql_num_rows($fir_vysledok2);
if( $fir_vysledok2 ) 
{
$fir_riadok2=mysql_fetch_object($fir_vysledok2);

$ico = $fir_riadok2->ico;
$iconaz = $fir_riadok2->nai;
}
  }

if( $polico1 > 0 ) { $polico2=1; }

if( $polico2 == 0 ) 
  {
$sqlfir3 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib3 LIKE '%".$polozka->ibanold."%' ";
$fir_vysledok3 = mysql_query($sqlfir3);
$polico3 = 1*mysql_num_rows($fir_vysledok3);
if( $fir_vysledok3 ) 
{
$fir_riadok3=mysql_fetch_object($fir_vysledok3);

$ico = $fir_riadok3->ico;
$iconaz = $fir_riadok3->nai;
}
  }


$osc=0; $oscnaz=""; 


$sqlfir4 = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd ".
" LEFT JOIN F$kli_vxcf"."_mzdkun ".
" ON F$kli_vxcf"."_mzdtextmzd.invt=F$kli_vxcf"."_mzdkun.oc".
" WHERE ziban LIKE '%".$polozka->ibanold."%' ";
$fir_vysledok4 = mysql_query($sqlfir4);
if( $fir_vysledok4 ) 
{
$fir_riadok4=mysql_fetch_object($fir_vysledok4);

$osc = 1*$fir_riadok4->invt;
$oscnaz = $fir_riadok4->prie." ".$fir_riadok4->meno;
}



?>

<tr>
<td class="<?php echo $hvstup; ?>" ><?php echo $polozka->cislocpl; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $polozka->ibanold; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $polozka->ibanx; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $stav; ?></td>

<td class="<?php echo $hvstup; ?>" >
<?php 
if( $ico > 0 ) { 
?> 
<a href="#" onClick="window.open('../cis/cico.php?sys=ALL&copern=8&page=1&cislo_ico=<?php echo $ico;?>&h_ico=<?php echo $ico;?>','_blank',
'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes')">
<?php echo $ico." ".$iconaz; ?></a>


<?php
               }
?>
</td>

<td class="<?php echo $hvstup; ?>" >
<?php 
if( $osc > 0 ) { 
?> 
<a href="#" onClick="window.open('../mzdy/zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $osc;?>&h_oc=<?php echo $osc;?>','_blank',
'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes')">
<?php echo $osc." ".$oscnaz; ?></a>


<?php
               }
?>
</td>

</tr>
<?php
}

$i = $i + 1;
  }
?>
</table>


<?php
}
?>



<?php
exit;

//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
