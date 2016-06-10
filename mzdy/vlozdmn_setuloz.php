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

$citfir = include("../cis/citaj_fir.php");


//copern=900 uloz nastavenie
if( $copern == 900 )
{
$ucm1 = $_REQUEST['h_ucm1'];
$ajstravne = 1*$_REQUEST['ajstravne'];
$premie = 1*$_REQUEST['premie'];
$ajsv = 1*$_REQUEST['ajsv'];
$ajdv = 1*$_REQUEST['ajdv'];
$ajnh = 1*$_REQUEST['ajnh'];
$eurl = 1*$_REQUEST['eurl'];
$minm = 1*$_REQUEST['minm'];
$vsdn = 1*$_REQUEST['vsdn'];

$ttvv = "DELETE FROM F$kli_vxcf"."_vlozdmnset ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_vlozdmnset ( polozka,ucm1,ajstravne,premie, ajsv, ajdv, ajnh, eurl, minm, vsdn ) ".
" VALUES ( '1', '$ucm1', '$ajstravne', '$premie', '$ajsv', '$ajdv', '$ajnh', '$eurl', '$minm', '$vsdn' )";
$ttqq = mysql_query("$ttvv");
//echo $ttvv;
//exit;


}
//koniec copern=900 uloz nastavenie 


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie uloz</title>
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
$cstat=10101;
if( $cstat == 10101 )
{
?>
<script type="text/javascript">
  var okno = window.open("../mzdy/mes_mzdy.php?copern=1&drupoh=1&page=1","_self");
</script>
<?php 
exit;
}//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
