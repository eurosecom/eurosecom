<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];

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

//oprava kalendar
$uprt = "UPDATE kalendar SET svt=0 WHERE dat = '2016-05-25' ";
$upravene = mysql_query("$uprt");


$ajstravne=0; $premie=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_vlozdmnset ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ajstravne=1*$riaddok->ajstravne;
  $premie=1*$riaddok->premie;
  }

//zlozky mzdy z mesacnej davky
if( $copern == 1 )
{

if( $wedgb == 1 )
    {
//mzdmes cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 304 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmes ".
" SELECT 0,9998,dat,ume,oc,304,dp,dk,0,0,0,0,kc,str,zak,stj,msx1,msx2,msx3,msx4,pop,id,now() ".
" FROM F$kli_vxcf"."_mzdmes ".
" WHERE dm = 104 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun ".
" SET kc=kc*sz3/100  ".
" WHERE dm = 304 AND dok = 9998 AND F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 304 AND kc = 0 ";
$dsql = mysql_query("$dsqlt");
    }

if( $wedgb == 0 AND $premie == 0 )
    {
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 304 ";
$dsql = mysql_query("$dsqlt");
    }

if( $wedgb == 0 AND $premie == 1 )
    {
//mzdmes cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 304 ";
$dsql = mysql_query("$dsqlt");


$i=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE sz1 > 0 AND sz3 > 0 ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
          
  while ($i < $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmes ".
" SELECT 0,9998,dat,ume,oc,304,dp,dk,0,0,0,0,kc,str,zak,stj,msx1,msx2,msx3,msx4,pop,id,now() ".
" FROM F$kli_vxcf"."_mzdmes ".
" WHERE dm >= 101 AND dm <= 107 AND oc = $riadok->oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdmes ".
" SET kc=kc*$riadok->sz3/100  ".
" WHERE dm = 304 AND dok = 9998 AND oc = $riadok->oc ";
$dsql = mysql_query("$dsqlt");


}
$i = $i + 1;
  }



$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 304 AND kc = 0 ";
$dsql = mysql_query("$dsqlt");
    }


if( $ajstravne == 0 )
    {
$cislo_oc = 1*$_REQUEST['cislo_oc'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 926 AND oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");
    }


//stravne listky
if( $ajstravne == 1 )
    {
$cislo_oc = 1*$_REQUEST['cislo_oc'];
//echo $cislo_oc;
//exit;

$ajsv=0; $ajdv=0; $ajnh=0; $minm=0; $eurl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_vlozdmnset ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ajdv=1*$riaddok->ajdv;
  $ajsv=1*$riaddok->ajsv;
  $ajnh=1*$riaddok->ajnh;
  $minm=1*$riaddok->minm;
  $eurl=1*$riaddok->eurl;
  }


$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 926 AND oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");


$i=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
          
  while ($i < $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];

$dat=$kli_vrokx."-".$kli_vmesx."-01";



$str=0; $zak=0;
$sqltt2 = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $riadok->oc ORDER BY oc DESC LIMIT 1"; 
$sqldo2 = mysql_query("$sqltt2");
 if (@$zaznam=mysql_data_seek($sqldo2,0))
 {
 $riaddo2=mysql_fetch_object($sqldo2);
 $str=1*$riadok->stz;
 $zak=1*$riadok->zkz;
 }

$kli_akyume=$kli_vume;

if( $minm == 1 )
  {

$kli_mmesx=$kli_vmesx-1;
$kli_mrokx=$kli_vrokx;
if( $kli_mmesx == 0 ) { $kli_mmesx=12; $kli_mrokx=$kli_vrokx-1; }

$kli_akyume=$kli_mmesx.".".$kli_mrokx;

  }


//pocet dni v mesiaci
$mnoz=0;
$sql22t = "SELECT * FROM kalendar WHERE ume = $kli_akyume AND akyden >= 1 AND akyden <= 5 ";

if( $ajsv == 0 )
  {
$sql22t = "SELECT * FROM kalendar WHERE ume = $kli_akyume AND akyden >= 1 AND akyden <= 5 AND svt = 0 ";

  }

$sql22 = mysql_query("$sql22t");
$mnoz = 1*mysql_num_rows($sql22);


$tabldavka="mzdmes";
if( $minm == 1 ) { $tabldavka="mzdzalmes"; }

$neplat=0;
//nepritomna nemoc 801,802,803,804
$in2=0;
$sqln2 = "SELECT * FROM F$kli_vxcf"."_$tabldavka WHERE oc = $cislo_oc AND dm >= 801 AND dm <= 804 AND dp != '0000-00-00' AND dk != '0000-00-00' ";
$tovn2 = mysql_query("$sqln2");
$tvpn2 = mysql_num_rows($tovn2);
          
  while ($in2 < $tvpn2 )
  {

  if (@$zaznam=mysql_data_seek($tovn2,$in))
{
$riadokn2=mysql_fetch_object($tovn2);

$neplx=0;
$sql22t = "SELECT * FROM kalendar WHERE ume = $kli_akyume AND dat >= '$riadokn2->dp' AND dat <= '$riadokn2->dk' AND akyden >= 1 AND akyden <= 5 AND svt = 0 ";
$sql22 = mysql_query("$sql22t");
$neplx = 1*mysql_num_rows($sql22);

//echo $neplx;
//echo $sql22t;


$neplat=$neplat+$neplx;


}
$in2 = $in2 + 1;
  }

//nepritomna neplatene a absencia 502, 503
$in2=0;
$sqln2 = "SELECT * FROM F$kli_vxcf"."_$tabldavka WHERE oc = $cislo_oc AND dm >= 502 AND dm <= 503  ";
$tovn2 = mysql_query("$sqln2");
$tvpn2 = mysql_num_rows($tovn2);
          
  while ($in2 < $tvpn2 )
  {

  if (@$zaznam=mysql_data_seek($tovn2,$in))
{
$riadokn2=mysql_fetch_object($tovn2);

$neplx=$riadokn2->dni-0.0049;
$neplx=round($neplx, 0);
$neplat=$neplat+$neplx;

}
$in2 = $in2 + 1;
  }


//nepritomna dovolenka 506,507
if( $ajdv == 0 )
          {
$in2=0;
$sqln2 = "SELECT * FROM F$kli_vxcf"."_$tabldavka WHERE oc = $cislo_oc AND dm >= 506 AND dm <= 507  ";
$tovn2 = mysql_query("$sqln2");
$tvpn2 = mysql_num_rows($tovn2);
          
  while ($in2 < $tvpn2 )
  {

  if (@$zaznam=mysql_data_seek($tovn2,$in))
{
$riadokn2=mysql_fetch_object($tovn2);

$neplx=$riadokn2->dni-0.0049;
$neplx=round($neplx, 0);
$neplat=$neplat+$neplx;

}
$in2 = $in2 + 1;
  }
          }
//koniec ajdv=0
//exit;

//nepritomnae nahrady 518,518,520
if( $ajnh == 0 )
          {
$in2=0;
$sqln2 = "SELECT * FROM F$kli_vxcf"."_$tabldavka WHERE oc = $cislo_oc AND dm >= 518 AND dm <= 520  ";
$tovn2 = mysql_query("$sqln2");
$tvpn2 = mysql_num_rows($tovn2);
          
  while ($in2 < $tvpn2 )
  {

  if (@$zaznam=mysql_data_seek($tovn2,$in))
{
$riadokn2=mysql_fetch_object($tovn2);

$neplx=$riadokn2->dni-0.0049;
$neplx=round($neplx, 0);
$neplat=$neplat+$neplx;

}
$in2 = $in2 + 1;
  }
          }
//koniec ajnh=0
//exit;

//mzdmes cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  

$mnoz=$mnoz-$neplat;
$mnoz=round($mnoz, 0);

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmes ".
" SELECT 0,9998,'$dat','$kli_vume',oc,926,'','',0,0,'$mnoz','$eurl',0,'$str','$zak',0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzdkun ".
" WHERE oc = $riadok->oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdmes ".
" SET kc=mnz*$eurl ".
" WHERE dm = 926 AND dok = 9998 AND oc = $riadok->oc ";
$dsql = mysql_query("$dsqlt");


}
$i = $i + 1;
  }


$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE dok = 9998 AND dm = 926 AND kc <= 0 AND oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");
    }
//stravne listky




?> 
<script type="text/javascript">
  var okno = window.open("../mzdy/mes_mzdy.php?copern=1&drupoh=1&page=1","_self");
</script>
<?php 
}
//koniec zlozky mzdy z mesacnej davky

//narok na dovolenku 21jeden,20vsetci
if( $copern == 20 OR $copern == 21 )
{
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$podmoc=" ( pom = 0 OR pom = 1 ) AND oc > 0 ";
if( $copern == 21 ) { $podmoc=" oc = ".$cislo_oc; }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdkun SET crp=YEAR(dar), nrk=20  WHERE $podmoc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdkun SET crp=$kli_vrok-crp  WHERE $podmoc ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdkun SET nrk=25 WHERE $podmoc AND crp >= 33 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdkun SET crp=0  ";
$oznac = mysql_query("$sqtoz");

?> 
<script type="text/javascript">
  var okno = window.open("../mzdy/zamestnanci.php?sys=MZD&copern=8&page=1&cislo_oc=<?php echo $cislo_oc; ?>&h_oc=<?php echo $cislo_oc; ?>","_self");
</script>
<?php 
}
//koniec narok na dovolenku

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Polozky do mes.davky</title>
  <style type="text/css">

  </style>



<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Polozky do mes. dávky

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
