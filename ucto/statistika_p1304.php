<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
if ( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="4.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if ( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="7.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if ( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="10.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];


$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;

if ( $copern == 1 ) { $copern=102; };

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//prepnute z vys_mala.php modul 82 odpocitaj predchadzajuce stvrtroky
if ( $modul == 82 )
{
if ( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=1";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod82r01=F$kli_vxcf"."_statistika_p1304.mod82r01-F$kli_vxcf"."_statistika_p1304archx.mod82r01, ".
" F$kli_vxcf"."_statistika_p1304.mod82r02=F$kli_vxcf"."_statistika_p1304.mod82r02-F$kli_vxcf"."_statistika_p1304archx.mod82r02, ".
" F$kli_vxcf"."_statistika_p1304.mod82r03=F$kli_vxcf"."_statistika_p1304.mod82r03-F$kli_vxcf"."_statistika_p1304archx.mod82r03, ".
" F$kli_vxcf"."_statistika_p1304.mod82r04=F$kli_vxcf"."_statistika_p1304.mod82r04-F$kli_vxcf"."_statistika_p1304archx.mod82r04, ".
" F$kli_vxcf"."_statistika_p1304.mod82r05=F$kli_vxcf"."_statistika_p1304.mod82r05-F$kli_vxcf"."_statistika_p1304archx.mod82r05, ".
" F$kli_vxcf"."_statistika_p1304.mod82r06=F$kli_vxcf"."_statistika_p1304.mod82r06-F$kli_vxcf"."_statistika_p1304archx.mod82r06, ".
" F$kli_vxcf"."_statistika_p1304.mod82r07=F$kli_vxcf"."_statistika_p1304.mod82r07-F$kli_vxcf"."_statistika_p1304archx.mod82r07, ".
" F$kli_vxcf"."_statistika_p1304.mod82r08=F$kli_vxcf"."_statistika_p1304.mod82r08-F$kli_vxcf"."_statistika_p1304archx.mod82r08, ".
" F$kli_vxcf"."_statistika_p1304.mod82r09=F$kli_vxcf"."_statistika_p1304.mod82r09-F$kli_vxcf"."_statistika_p1304archx.mod82r09, ".
" F$kli_vxcf"."_statistika_p1304.mod82r10=F$kli_vxcf"."_statistika_p1304.mod82r10-F$kli_vxcf"."_statistika_p1304archx.mod82r10, ".
" F$kli_vxcf"."_statistika_p1304.mod82r99=F$kli_vxcf"."_statistika_p1304.mod82r99-F$kli_vxcf"."_statistika_p1304archx.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


if ( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=2";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304arch ".
" SET F$kli_vxcf"."_statistika_p1304.mod82r01=F$kli_vxcf"."_statistika_p1304.mod82r01-F$kli_vxcf"."_statistika_p1304arch.mod82r01, ".
" F$kli_vxcf"."_statistika_p1304.mod82r02=F$kli_vxcf"."_statistika_p1304.mod82r02-F$kli_vxcf"."_statistika_p1304arch.mod82r02, ".
" F$kli_vxcf"."_statistika_p1304.mod82r03=F$kli_vxcf"."_statistika_p1304.mod82r03-F$kli_vxcf"."_statistika_p1304arch.mod82r03, ".
" F$kli_vxcf"."_statistika_p1304.mod82r04=F$kli_vxcf"."_statistika_p1304.mod82r04-F$kli_vxcf"."_statistika_p1304arch.mod82r04, ".
" F$kli_vxcf"."_statistika_p1304.mod82r05=F$kli_vxcf"."_statistika_p1304.mod82r05-F$kli_vxcf"."_statistika_p1304arch.mod82r05, ".
" F$kli_vxcf"."_statistika_p1304.mod82r06=F$kli_vxcf"."_statistika_p1304.mod82r06-F$kli_vxcf"."_statistika_p1304arch.mod82r06, ".
" F$kli_vxcf"."_statistika_p1304.mod82r07=F$kli_vxcf"."_statistika_p1304.mod82r07-F$kli_vxcf"."_statistika_p1304arch.mod82r07, ".
" F$kli_vxcf"."_statistika_p1304.mod82r08=F$kli_vxcf"."_statistika_p1304.mod82r08-F$kli_vxcf"."_statistika_p1304arch.mod82r08, ".
" F$kli_vxcf"."_statistika_p1304.mod82r09=F$kli_vxcf"."_statistika_p1304.mod82r09-F$kli_vxcf"."_statistika_p1304arch.mod82r09, ".
" F$kli_vxcf"."_statistika_p1304.mod82r10=F$kli_vxcf"."_statistika_p1304.mod82r10-F$kli_vxcf"."_statistika_p1304arch.mod82r10, ".
" F$kli_vxcf"."_statistika_p1304.mod82r99=F$kli_vxcf"."_statistika_p1304.mod82r99-F$kli_vxcf"."_statistika_p1304arch.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p1304arch.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }
//exit;


if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=3";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304arch ".
" SET F$kli_vxcf"."_statistika_p1304.mod82r01=F$kli_vxcf"."_statistika_p1304.mod82r01-F$kli_vxcf"."_statistika_p1304arch.mod82r01, ".
" F$kli_vxcf"."_statistika_p1304.mod82r02=F$kli_vxcf"."_statistika_p1304.mod82r02-F$kli_vxcf"."_statistika_p1304arch.mod82r02, ".
" F$kli_vxcf"."_statistika_p1304.mod82r03=F$kli_vxcf"."_statistika_p1304.mod82r03-F$kli_vxcf"."_statistika_p1304arch.mod82r03, ".
" F$kli_vxcf"."_statistika_p1304.mod82r04=F$kli_vxcf"."_statistika_p1304.mod82r04-F$kli_vxcf"."_statistika_p1304arch.mod82r04, ".
" F$kli_vxcf"."_statistika_p1304.mod82r05=F$kli_vxcf"."_statistika_p1304.mod82r05-F$kli_vxcf"."_statistika_p1304arch.mod82r05, ".
" F$kli_vxcf"."_statistika_p1304.mod82r06=F$kli_vxcf"."_statistika_p1304.mod82r06-F$kli_vxcf"."_statistika_p1304arch.mod82r06, ".
" F$kli_vxcf"."_statistika_p1304.mod82r07=F$kli_vxcf"."_statistika_p1304.mod82r07-F$kli_vxcf"."_statistika_p1304arch.mod82r07, ".
" F$kli_vxcf"."_statistika_p1304.mod82r08=F$kli_vxcf"."_statistika_p1304.mod82r08-F$kli_vxcf"."_statistika_p1304arch.mod82r08, ".
" F$kli_vxcf"."_statistika_p1304.mod82r09=F$kli_vxcf"."_statistika_p1304.mod82r09-F$kli_vxcf"."_statistika_p1304arch.mod82r09, ".
" F$kli_vxcf"."_statistika_p1304.mod82r10=F$kli_vxcf"."_statistika_p1304.mod82r10-F$kli_vxcf"."_statistika_p1304arch.mod82r10, ".
" F$kli_vxcf"."_statistika_p1304.mod82r99=F$kli_vxcf"."_statistika_p1304.mod82r99-F$kli_vxcf"."_statistika_p1304arch.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p1304arch.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_statistika_p1304 SET mod82r10=mod82r01-mod82r04 WHERE psys = $stvrtrok ";
$vysledek = mysql_query("$sql");
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10, ".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r10a1+mod112r05a1+mod112r06a1+mod112r07a1,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r10a4+mod112r05a4+mod112r06a4+mod112r07a4 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=2;
}
//koniec odpocitaj modul 82 z vys_mala.php


//prepnute z uobrat.php modul 112 odpocitaj predchadzajuce stvrtroky
if ( $modul == 112 )
{
if ( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=1";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod112r01a1=F$kli_vxcf"."_statistika_p1304.mod112r01a1-F$kli_vxcf"."_statistika_p1304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a1=F$kli_vxcf"."_statistika_p1304.mod112r02a1-F$kli_vxcf"."_statistika_p1304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a4=F$kli_vxcf"."_statistika_p1304.mod112r02a4-F$kli_vxcf"."_statistika_p1304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=2";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod112r01a1=F$kli_vxcf"."_statistika_p1304.mod112r01a1-F$kli_vxcf"."_statistika_p1304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a1=F$kli_vxcf"."_statistika_p1304.mod112r02a1-F$kli_vxcf"."_statistika_p1304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a4=F$kli_vxcf"."_statistika_p1304.mod112r02a4-F$kli_vxcf"."_statistika_p1304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=3";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod112r01a1=F$kli_vxcf"."_statistika_p1304.mod112r01a1-F$kli_vxcf"."_statistika_p1304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a1=F$kli_vxcf"."_statistika_p1304.mod112r02a1-F$kli_vxcf"."_statistika_p1304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p1304.mod112r02a4=F$kli_vxcf"."_statistika_p1304.mod112r02a4-F$kli_vxcf"."_statistika_p1304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod112r12a1=mod112r02a1, mod112r12a4=mod112r02a4,".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r10a1,".
" mod112r99a2=mod112r01a2+mod112r02a2+mod112r03a2+mod112r04a2+mod112r05a2+mod112r06a2+mod112r07a2+mod112r08a2+mod112r09a2+mod112r10a2+mod112r11a2+mod112r12a2,".
" mod112r99a3=mod112r01a3+mod112r02a3+mod112r03a3+mod112r04a3+mod112r05a3+mod112r06a3+mod112r07a3+mod112r08a3+mod112r09a3+mod112r10a3+mod112r11a3+mod112r12a3,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r10a4 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10, ".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r10a1,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r10a4 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
$strana=2;
}
//koniec odpocitaj modul 112 z uobrat.php


//prepnute z uobrat.php modul 545 odpocitaj predchadzajuce stvrtroky
if ( $modul == 545 )
{
if( $stvrtrok == 2 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=1";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r01a1=F$kli_vxcf"."_statistika_p1304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r02a1=F$kli_vxcf"."_statistika_p1304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r03a1=F$kli_vxcf"."_statistika_p1304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r04a1=F$kli_vxcf"."_statistika_p1304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r05a1=F$kli_vxcf"."_statistika_p1304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r06a1=F$kli_vxcf"."_statistika_p1304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r07a1=F$kli_vxcf"."_statistika_p1304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r08a1=F$kli_vxcf"."_statistika_p1304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r09a1=F$kli_vxcf"."_statistika_p1304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r10a1=F$kli_vxcf"."_statistika_p1304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 3 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=2";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r01a1=F$kli_vxcf"."_statistika_p1304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r02a1=F$kli_vxcf"."_statistika_p1304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r03a1=F$kli_vxcf"."_statistika_p1304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r04a1=F$kli_vxcf"."_statistika_p1304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r05a1=F$kli_vxcf"."_statistika_p1304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r06a1=F$kli_vxcf"."_statistika_p1304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r07a1=F$kli_vxcf"."_statistika_p1304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r08a1=F$kli_vxcf"."_statistika_p1304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r09a1=F$kli_vxcf"."_statistika_p1304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r10a1=F$kli_vxcf"."_statistika_p1304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=3";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r01a1=F$kli_vxcf"."_statistika_p1304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r02a1=F$kli_vxcf"."_statistika_p1304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r03a1=F$kli_vxcf"."_statistika_p1304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r04a1=F$kli_vxcf"."_statistika_p1304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r05a1=F$kli_vxcf"."_statistika_p1304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r06a1=F$kli_vxcf"."_statistika_p1304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r07a1=F$kli_vxcf"."_statistika_p1304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r08a1=F$kli_vxcf"."_statistika_p1304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r09a1=F$kli_vxcf"."_statistika_p1304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r10a1=F$kli_vxcf"."_statistika_p1304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");
$strana=3;
$copern=102;
}
//koniec odpocitaj modul 545 z uobrat.php


//prepnute z suvaha.php modul 1545 odpocitaj predchadzajuce stvrtroky
if ( $modul == 1545 )
{
if ( $stvrtrok == 2 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=1";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 3 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=2";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304archx SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=3";
$vysledek = mysql_query("$sql");
$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p1304,F$kli_vxcf"."_statistika_p1304archx ".
" SET F$kli_vxcf"."_statistika_p1304.mod545r11a1=F$kli_vxcf"."_statistika_p1304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p1304archx.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304archx ";
$vysledek = mysql_query("$sql");
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");
$strana=3;
$copern=102;
}
//koniec odpocitaj modul 1545 z suvaha.php


//pracovny subor statistika_p1304
$sql = "SELECT * FROM F$kli_vxcf"."_statistika_p1304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_p1304';
$vytvor = mysql_query("$vsql");
$sqlt = <<<statistika_p1304
(
   psys         INT,
   cinnost      VARCHAR(80),
   mod82r01     DECIMAL(10,0) DEFAULT 0,
   mod82r02     DECIMAL(10,0) DEFAULT 0,
   mod82r03     DECIMAL(10,0) DEFAULT 0,
   mod82r04     DECIMAL(10,0) DEFAULT 0,
   mod82r05     DECIMAL(10,0) DEFAULT 0,
   mod82r06     DECIMAL(10,0) DEFAULT 0,
   mod82r07     DECIMAL(10,0) DEFAULT 0,
   mod82r08     DECIMAL(10,0) DEFAULT 0,
   mod82r09     DECIMAL(10,0) DEFAULT 0,
   mod82r10     DECIMAL(10,0) DEFAULT 0,
   mod82r99     DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_p1304'.$sqlt;
$vytvor = mysql_query("$vsql");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_p1304 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}
$sql = "SELECT mod2r01 FROM F$kli_vxcf"."_statistika_p1304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod2r02 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod2r01 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod113ano FROM F$kli_vxcf"."_statistika_p1304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r99a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r13a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r12a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r11a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r10a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r09a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r08a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r07a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r06a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r05a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r04a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r03a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r02a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r01a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r99a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r13a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r12a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r11a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r10a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r09a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r08a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r07a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r06a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r05a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r04a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r03a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r02a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r01a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r99a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r13a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r12a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r11a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r10a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r09a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r08a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r07a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r06a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r05a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r04a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r03a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r02a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r01a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r99a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r13a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r12a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r11a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r10a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r09a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r08a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r07a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r06a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r05a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r04a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r03a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r02a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod112r01a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod113nie VARCHAR(1) NOT NULL AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod113ano VARCHAR(1) NOT NULL AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod545r01a1 FROM F$kli_vxcf"."_statistika_p1304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r99a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r11a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r10a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r09a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r08a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r07a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r06a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r05a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r04a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r03a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r02a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r01a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r99a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r11a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r10a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r09a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r08a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r07a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r06a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r05a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r04a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r03a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r02a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod545r01a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod143r01 FROM F$kli_vxcf"."_statistika_p1304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r99 DECIMAL(10,1) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r20 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r19 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r18 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r17 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r16 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r15 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r14 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r13 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r12 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r11 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r10 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r09 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r08 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r07 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r06 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r05 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r04 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r03 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r02 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD mod143r01 DECIMAL(10,1) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_p1304 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p1304 ADD odoslane DATE NOT NULL AFTER cinnost";
$vysledek = mysql_query("$sql");
}
//koniec pracovny subor


//zapis do statistickej TABLE a prepni do stat zostavy
if ( $copern == 200 )
{
$h_mfir = 1*strip_tags($_REQUEST['h_mfir']);
$vyb_ume = strip_tags($_REQUEST['vyb_ume']);
//echo $h_mfir;
//echo $vyb_ume;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   oc           INT(5),
   ume          DECIMAL(7,4) DEFAULT 0,
   rodc         VARCHAR(6),
   zena         INT(1),
   pom          DECIMAL(3,0) DEFAULT 0,
   dhpom        DECIMAL(3,0) DEFAULT 0,
   pocet        DECIMAL(10,0) DEFAULT 0,
   dm           INT(5),
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov
$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE pom != 9 AND ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh, zena=SUBSTRING(rodc,3,2) ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm"; 
$upravene = mysql_query("$uprtxt");  

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 998,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$r01=0; $r01p=0; $r01s=0; $r01k=0; $r03=0; $r08=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ump AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01p=$r01p+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ums AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01s=$r01s+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_umk AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01k=$r01k+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+1; }
$i=$i+1;                   }

$r01=($r01p+$r01s+$r01k)/3;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+1; }
$i=$i+1;                   }

//odpracovane hodiny a eur a odvody
$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,spom,0,1, ".
"9999,0,0,(ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),$fir_fico".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm"; 
$upravene = mysql_query("$uprtxt");  

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 555,oc,ume,rodc,zena,pom,dhpom,pocet, ".
"dm,SUM(dni),SUM(hod),SUM(kc),$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom,dm";
$dsql = mysql_query("$dsqlt");

$r07=0; $r09=0; $r10=0; $r11=0; $r12=0; $r13=0; $r14=0; $r15=0; $r16=0; $r17=0; $r18=0; $r19=0; $r20=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->hod; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09=$r09+$polozka->hod; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 100 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10=$r10+$polozka->kc; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 500 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11=$r11+$polozka->kc; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 1 AND ( dm > 100 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r17=$r17+$polozka->kc; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND ( dm = 803 OR dm = 804 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r18=$r18+$polozka->kc; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dm = 130 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r19=$r19+$polozka->kc; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 9999";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r20=$r20+$polozka->kc; }
$i=$i+1;                   }

//zapis do statistiky
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod143r01='$r01', mod143r02='$r01k', mod143r03='$r03', mod143r05=mod143r02, mod143r07='$r07', mod143r08='$r08', mod143r09='$r09',".
" mod143r10='$r10', mod143r11='$r11', mod143r12='$r12', mod143r13='$r13', mod143r14='$r14', mod143r15='$r15',".
" mod143r16='$r16', mod143r17='$r17', mod143r18='$r18', mod143r19='$r19', mod143r20='$r20',".
" mod143r99=mod143r01+mod143r05+mod143r06+mod143r07+mod143r08+mod143r09+mod143r10,".
" mod143r99=mod143r99+mod143r12+mod143r13+mod143r14+mod143r15+mod143r20".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
//$vytvor = mysql_query("$vsql");
?>
<script type="text/javascript">
 window.open('../ucto/statistika_p1304.php?copern=102&drupoh=1&page=1&strana=3', '_self' )
</script>
<?php
}
//koniec copern=200 nacitaj statistiku z miezd


//zapis upravene udaje
if ( $copern == 103 )
     {
//$cinnost = strip_tags($_REQUEST['cinnost']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);

$mod82r01 = strip_tags($_REQUEST['mod82r01']);
$mod82r02 = strip_tags($_REQUEST['mod82r02']);
$mod82r03 = strip_tags($_REQUEST['mod82r03']);
$mod82r04 = strip_tags($_REQUEST['mod82r04']);
$mod82r05 = strip_tags($_REQUEST['mod82r05']);
$mod82r06 = strip_tags($_REQUEST['mod82r06']);
$mod82r07 = strip_tags($_REQUEST['mod82r07']);
$mod82r08 = strip_tags($_REQUEST['mod82r08']);
$mod82r09 = strip_tags($_REQUEST['mod82r09']);
$mod82r10 = strip_tags($_REQUEST['mod82r10']);
$mod82r99 = strip_tags($_REQUEST['mod82r99']);
$mod113ano = strip_tags($_REQUEST['mod113ano']);
$mod113nie = strip_tags($_REQUEST['mod113nie']);
$mod112r01a1 = strip_tags($_REQUEST['mod112r01a1']);
$mod112r02a1 = strip_tags($_REQUEST['mod112r02a1']);
$mod112r03a1 = strip_tags($_REQUEST['mod112r03a1']);
$mod112r04a1 = strip_tags($_REQUEST['mod112r04a1']);
$mod112r05a1 = strip_tags($_REQUEST['mod112r05a1']);
$mod112r06a1 = strip_tags($_REQUEST['mod112r06a1']);
$mod112r07a1 = strip_tags($_REQUEST['mod112r07a1']);
$mod112r08a1 = strip_tags($_REQUEST['mod112r08a1']);
$mod112r09a1 = strip_tags($_REQUEST['mod112r09a1']);
$mod112r10a1 = strip_tags($_REQUEST['mod112r10a1']);
$mod112r11a1 = strip_tags($_REQUEST['mod112r11a1']);
$mod112r12a1 = strip_tags($_REQUEST['mod112r12a1']);
$mod112r13a1 = strip_tags($_REQUEST['mod112r13a1']);
$mod112r99a1 = strip_tags($_REQUEST['mod112r99a1']);
$mod112r01a4 = strip_tags($_REQUEST['mod112r01a4']);
$mod112r02a4 = strip_tags($_REQUEST['mod112r02a4']);
$mod112r03a4 = strip_tags($_REQUEST['mod112r03a4']);
$mod112r04a4 = strip_tags($_REQUEST['mod112r04a4']);
$mod112r05a4 = strip_tags($_REQUEST['mod112r05a4']);
$mod112r06a4 = strip_tags($_REQUEST['mod112r06a4']);
$mod112r07a4 = strip_tags($_REQUEST['mod112r07a4']);
$mod112r08a4 = strip_tags($_REQUEST['mod112r08a4']);
$mod112r09a4 = strip_tags($_REQUEST['mod112r09a4']);
$mod112r10a4 = strip_tags($_REQUEST['mod112r10a4']);
$mod112r11a4 = strip_tags($_REQUEST['mod112r11a4']);
$mod112r12a4 = strip_tags($_REQUEST['mod112r12a4']);
$mod112r13a4 = strip_tags($_REQUEST['mod112r13a4']);
$mod112r99a4 = strip_tags($_REQUEST['mod112r99a4']);

$mod545r01a1 = strip_tags($_REQUEST['mod545r01a1']);
$mod545r02a1 = strip_tags($_REQUEST['mod545r02a1']);
$mod545r03a1 = strip_tags($_REQUEST['mod545r03a1']);
$mod545r04a1 = strip_tags($_REQUEST['mod545r04a1']);
$mod545r05a1 = strip_tags($_REQUEST['mod545r05a1']);
$mod545r06a1 = strip_tags($_REQUEST['mod545r06a1']);
$mod545r07a1 = strip_tags($_REQUEST['mod545r07a1']);
$mod545r08a1 = strip_tags($_REQUEST['mod545r08a1']);
$mod545r09a1 = strip_tags($_REQUEST['mod545r09a1']);
$mod545r10a1 = strip_tags($_REQUEST['mod545r10a1']);
$mod545r11a1 = strip_tags($_REQUEST['mod545r11a1']);
$mod545r99a1 = strip_tags($_REQUEST['mod545r99a1']);
$mod545r01a2 = strip_tags($_REQUEST['mod545r01a2']);
$mod545r02a2 = strip_tags($_REQUEST['mod545r02a2']);
$mod545r03a2 = strip_tags($_REQUEST['mod545r03a2']);
$mod545r04a2 = strip_tags($_REQUEST['mod545r04a2']);
$mod545r05a2 = strip_tags($_REQUEST['mod545r05a2']);
$mod545r06a2 = strip_tags($_REQUEST['mod545r06a2']);
$mod545r07a2 = strip_tags($_REQUEST['mod545r07a2']);
$mod545r08a2 = strip_tags($_REQUEST['mod545r08a2']);
$mod545r09a2 = strip_tags($_REQUEST['mod545r09a2']);
$mod545r10a2 = strip_tags($_REQUEST['mod545r10a2']);
$mod545r11a2 = strip_tags($_REQUEST['mod545r11a2']);
$mod545r99a2 = strip_tags($_REQUEST['mod545r99a2']);
$mod143r01 = strip_tags($_REQUEST['mod143r01']);
$mod143r02 = strip_tags($_REQUEST['mod143r02']);
$mod143r03 = strip_tags($_REQUEST['mod143r03']);
$mod143r04 = strip_tags($_REQUEST['mod143r04']);
$mod143r05 = strip_tags($_REQUEST['mod143r05']);
$mod143r06 = strip_tags($_REQUEST['mod143r06']);
$mod143r07 = strip_tags($_REQUEST['mod143r07']);
$mod143r08 = strip_tags($_REQUEST['mod143r08']);
$mod143r09 = strip_tags($_REQUEST['mod143r09']);
$mod143r10 = strip_tags($_REQUEST['mod143r10']);
$mod143r11 = strip_tags($_REQUEST['mod143r11']);
$mod143r12 = strip_tags($_REQUEST['mod143r12']);
$mod143r13 = strip_tags($_REQUEST['mod143r13']);
$mod143r14 = strip_tags($_REQUEST['mod143r14']);
$mod143r15 = strip_tags($_REQUEST['mod143r15']);
$mod143r16 = strip_tags($_REQUEST['mod143r16']);
$mod143r17 = strip_tags($_REQUEST['mod143r17']);
$mod143r18 = strip_tags($_REQUEST['mod143r18']);
$mod143r19 = strip_tags($_REQUEST['mod143r19']);
$mod143r20 = strip_tags($_REQUEST['mod143r20']);
$mod143r99 = strip_tags($_REQUEST['mod143r99']);

$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" odoslane='$odoslane_sql', mod2r01='$mod2r01', mod2r02='$mod2r02' ".
" WHERE ico >= 0";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod82r01='$mod82r01',mod82r02='$mod82r02',mod82r03='$mod82r03',mod82r04='$mod82r04',mod82r05='$mod82r05', ".
" mod82r06='$mod82r06',mod82r07='$mod82r07',mod82r08='$mod82r08',mod82r09='$mod82r09',mod82r10='$mod82r10', ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10, ".
" mod113ano='$mod113ano',mod113nie='$mod113nie', ".
" mod112r01a1='$mod112r01a1',mod112r02a1='$mod112r02a1',mod112r03a1='$mod112r03a1',mod112r04a1='$mod112r04a1',mod112r05a1='$mod112r05a1',  ".
" mod112r06a1='$mod112r06a1',mod112r07a1='$mod112r07a1',mod112r08a1='$mod112r08a1',mod112r09a1='$mod112r09a1',mod112r10a1='$mod112r10a1',  ".
" mod112r11a1='$mod112r11a1',mod112r12a1='$mod112r12a1',mod112r13a1='$mod112r13a1',  ".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r10a1,".
" mod112r01a4='$mod112r01a4',mod112r02a4='$mod112r02a4',mod112r03a4='$mod112r03a4',mod112r04a4='$mod112r04a4',mod112r05a4='$mod112r05a4',  ".
" mod112r06a4='$mod112r06a4',mod112r07a4='$mod112r07a4',mod112r08a4='$mod112r08a4',mod112r09a4='$mod112r09a4',mod112r10a4='$mod112r10a4',  ".
" mod112r11a4='$mod112r11a4',mod112r12a4='$mod112r12a4',mod112r13a4='$mod112r13a4',  ".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r10a4 ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod545r01a1='$mod545r01a1',mod545r02a1='$mod545r02a1',mod545r03a1='$mod545r03a1',mod545r04a1='$mod545r04a1',mod545r05a1='$mod545r05a1',  ".
" mod545r06a1='$mod545r06a1',mod545r07a1='$mod545r07a1',mod545r08a1='$mod545r08a1',mod545r09a1='$mod545r09a1',mod545r10a1='$mod545r10a1',  ".
" mod545r11a1='$mod545r11a1',  ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r01a2='$mod545r01a2',mod545r02a2='$mod545r02a2',mod545r03a2='$mod545r03a2',mod545r04a2='$mod545r04a2',mod545r05a2='$mod545r05a2',  ".
" mod545r06a2='$mod545r06a2',mod545r07a2='$mod545r07a2',mod545r08a2='$mod545r08a2',mod545r09a2='$mod545r09a2',mod545r10a2='$mod545r10a2',  ".
" mod545r11a2='$mod545r11a2',  ".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2, ".
" mod143r01='$mod143r01',mod143r02='$mod143r02',mod143r03='$mod143r03',mod143r04='$mod143r04',mod143r05='$mod143r05',  ".
" mod143r06='$mod143r06',mod143r07='$mod143r07',mod143r08='$mod143r08',mod143r09='$mod143r09',mod143r10='$mod143r10',  ".
" mod143r11='$mod143r11',mod143r12='$mod143r12',mod143r13='$mod143r13',mod143r14='$mod143r14',mod143r15='$mod143r15',  ".
" mod143r16='$mod143r16',mod143r17='$mod143r17',mod143r18='$mod143r18',mod143r19='$mod143r19',mod143r20='$mod143r20',  ".
" mod143r99=mod143r01+mod143r05+mod143r06+mod143r07+mod143r08+mod143r09+mod143r10,".
" mod143r99=mod143r99+mod143r12+mod143r13+mod143r14+mod143r15+mod143r20 ".
" WHERE ico >= 0";
                    }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$copern=102;
if (!$upravene):
?>
<script type="text/javascript"> alert( "�DAJE NEBOLI UPRAVEN�" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//vypocty
$sql = "UPDATE F".$kli_vxcf."_statistika_p1304 SET mod82r10=mod82r01-mod82r04 WHERE ico >= 0";
$vysledek = mysql_query("$sql");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05+mod82r06+mod82r07+mod82r08+mod82r09+mod82r10".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod143r99=mod143r01+mod143r05+mod143r06+mod143r07+mod143r08+mod143r09+mod143r10,".
" mod143r99=mod143r99+mod143r12+mod143r13+mod143r14+mod143r15+mod143r20,".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 
//koniec vypocty


//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_p1304 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$odoslane_sk = SkDatum($fir_riadok->odoslane);
$mod82r01 = $fir_riadok->mod82r01;
$mod82r02 = $fir_riadok->mod82r02;
$mod82r03 = $fir_riadok->mod82r03;
$mod82r04 = $fir_riadok->mod82r04;
$mod82r05 = $fir_riadok->mod82r05;
$mod82r06 = $fir_riadok->mod82r06;
$mod82r07 = $fir_riadok->mod82r07;
$mod82r08 = $fir_riadok->mod82r08;
$mod82r09 = $fir_riadok->mod82r09;
$mod82r10 = $fir_riadok->mod82r10;
$mod82r99 = $fir_riadok->mod82r99;

$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;

$mod113ano = $fir_riadok->mod113ano;
$mod113nie = $fir_riadok->mod113nie;

$mod112r01a1 = $fir_riadok->mod112r01a1;
$mod112r02a1 = $fir_riadok->mod112r02a1;
$mod112r03a1 = $fir_riadok->mod112r03a1;
$mod112r04a1 = $fir_riadok->mod112r04a1;
$mod112r05a1 = $fir_riadok->mod112r05a1;
$mod112r06a1 = $fir_riadok->mod112r06a1;
$mod112r07a1 = $fir_riadok->mod112r07a1;
$mod112r08a1 = $fir_riadok->mod112r08a1;
$mod112r09a1 = $fir_riadok->mod112r09a1;
$mod112r10a1 = $fir_riadok->mod112r10a1;
$mod112r11a1 = $fir_riadok->mod112r11a1;
$mod112r12a1 = $fir_riadok->mod112r12a1;
$mod112r13a1 = $fir_riadok->mod112r13a1;
$mod112r99a1 = $fir_riadok->mod112r99a1;

$mod112r01a4 = $fir_riadok->mod112r01a4;
$mod112r02a4 = $fir_riadok->mod112r02a4;
$mod112r03a4 = $fir_riadok->mod112r03a4;
$mod112r04a4 = $fir_riadok->mod112r04a4;
$mod112r05a4 = $fir_riadok->mod112r05a4;
$mod112r06a4 = $fir_riadok->mod112r06a4;
$mod112r07a4 = $fir_riadok->mod112r07a4;
$mod112r08a4 = $fir_riadok->mod112r08a4;
$mod112r09a4 = $fir_riadok->mod112r09a4;
$mod112r10a4 = $fir_riadok->mod112r10a4;
$mod112r11a4 = $fir_riadok->mod112r11a4;
$mod112r12a4 = $fir_riadok->mod112r12a4;
$mod112r13a4 = $fir_riadok->mod112r13a4;
$mod112r99a4 = $fir_riadok->mod112r99a4;

$mod545r01a1 = $fir_riadok->mod545r01a1;
$mod545r02a1 = $fir_riadok->mod545r02a1;
$mod545r03a1 = $fir_riadok->mod545r03a1;
$mod545r04a1 = $fir_riadok->mod545r04a1;
$mod545r05a1 = $fir_riadok->mod545r05a1;
$mod545r06a1 = $fir_riadok->mod545r06a1;
$mod545r07a1 = $fir_riadok->mod545r07a1;
$mod545r08a1 = $fir_riadok->mod545r08a1;
$mod545r09a1 = $fir_riadok->mod545r09a1;
$mod545r10a1 = $fir_riadok->mod545r10a1;
$mod545r11a1 = $fir_riadok->mod545r11a1;
$mod545r99a1 = $fir_riadok->mod545r99a1;

$mod545r01a2 = $fir_riadok->mod545r01a2;
$mod545r02a2 = $fir_riadok->mod545r02a2;
$mod545r03a2 = $fir_riadok->mod545r03a2;
$mod545r04a2 = $fir_riadok->mod545r04a2;
$mod545r05a2 = $fir_riadok->mod545r05a2;
$mod545r06a2 = $fir_riadok->mod545r06a2;
$mod545r07a2 = $fir_riadok->mod545r07a2;
$mod545r08a2 = $fir_riadok->mod545r08a2;
$mod545r09a2 = $fir_riadok->mod545r09a2;
$mod545r10a2 = $fir_riadok->mod545r10a2;
$mod545r11a2 = $fir_riadok->mod545r11a2;
$mod545r99a2 = $fir_riadok->mod545r99a2;

$mod143r01 = $fir_riadok->mod143r01;
$mod143r02 = $fir_riadok->mod143r02;
$mod143r03 = $fir_riadok->mod143r03;
$mod143r04 = $fir_riadok->mod143r04;
$mod143r05 = $fir_riadok->mod143r05;
$mod143r06 = $fir_riadok->mod143r06;
$mod143r07 = $fir_riadok->mod143r07;
$mod143r08 = $fir_riadok->mod143r08;
$mod143r09 = $fir_riadok->mod143r09;
$mod143r10 = $fir_riadok->mod143r10;
$mod143r11 = $fir_riadok->mod143r11;
$mod143r12 = $fir_riadok->mod143r12;
$mod143r13 = $fir_riadok->mod143r13;
$mod143r14 = $fir_riadok->mod143r14;
$mod143r15 = $fir_riadok->mod143r15;
$mod143r16 = $fir_riadok->mod143r16;
$mod143r17 = $fir_riadok->mod143r17;
$mod143r18 = $fir_riadok->mod143r18;
$mod143r19 = $fir_riadok->mod143r19;
$mod143r20 = $fir_riadok->mod143r20;
$mod143r99 = $fir_riadok->mod143r99;
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//kod okresu z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v�kaz Prod 13-04</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
a.archiv-link {
  float: left;
  padding: 6px 5px 5px 5px !important;
  color: #39f !important;
  font-weight: bold;
}
</style>

<script type="text/javascript">
<?php
//uprava
  if ( $copern == 102 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.mod82r01.value = '<?php echo "$mod82r01";?>';
   document.formv1.mod82r02.value = '<?php echo "$mod82r02";?>';
   document.formv1.mod82r03.value = '<?php echo "$mod82r03";?>';
   document.formv1.mod82r04.value = '<?php echo "$mod82r04";?>';
   document.formv1.mod82r05.value = '<?php echo "$mod82r05";?>';
   document.formv1.mod82r06.value = '<?php echo "$mod82r06";?>';
   document.formv1.mod82r07.value = '<?php echo "$mod82r07";?>';
   document.formv1.mod82r08.value = '<?php echo "$mod82r08";?>';
   document.formv1.mod82r09.value = '<?php echo "$mod82r09";?>';
   document.formv1.mod82r10.value = '<?php echo "$mod82r10";?>';

<?php if ( $mod113ano == 1 ) { echo "document.formv1.mod113ano.checked='checked'; "; } ?>
<?php if ( $mod113nie == 1 ) { echo "document.formv1.mod113nie.checked='checked'; "; } ?>

   document.formv1.mod112r01a1.value = '<?php echo "$mod112r01a1";?>';
   document.formv1.mod112r02a1.value = '<?php echo "$mod112r02a1";?>';
   document.formv1.mod112r03a1.value = '<?php echo "$mod112r03a1";?>';
   document.formv1.mod112r05a1.value = '<?php echo "$mod112r05a1";?>';
   document.formv1.mod112r06a1.value = '<?php echo "$mod112r06a1";?>';
   document.formv1.mod112r07a1.value = '<?php echo "$mod112r07a1";?>';
   document.formv1.mod112r10a1.value = '<?php echo "$mod112r10a1";?>';

   document.formv1.mod112r01a4.value = '<?php echo "$mod112r01a4";?>';
   document.formv1.mod112r02a4.value = '<?php echo "$mod112r02a4";?>';
   document.formv1.mod112r03a4.value = '<?php echo "$mod112r03a4";?>';
   document.formv1.mod112r05a4.value = '<?php echo "$mod112r05a4";?>';
   document.formv1.mod112r06a4.value = '<?php echo "$mod112r06a4";?>';
   document.formv1.mod112r07a4.value = '<?php echo "$mod112r07a4";?>';
   document.formv1.mod112r10a4.value = '<?php echo "$mod112r10a4";?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.mod545r01a1.value = '<?php echo "$mod545r01a1";?>';
   document.formv1.mod545r02a1.value = '<?php echo "$mod545r02a1";?>';
   document.formv1.mod545r03a1.value = '<?php echo "$mod545r03a1";?>';
   document.formv1.mod545r04a1.value = '<?php echo "$mod545r04a1";?>';
   document.formv1.mod545r05a1.value = '<?php echo "$mod545r05a1";?>';
   document.formv1.mod545r06a1.value = '<?php echo "$mod545r06a1";?>';
   document.formv1.mod545r07a1.value = '<?php echo "$mod545r07a1";?>';
   document.formv1.mod545r08a1.value = '<?php echo "$mod545r08a1";?>';
   document.formv1.mod545r09a1.value = '<?php echo "$mod545r09a1";?>';
   document.formv1.mod545r10a1.value = '<?php echo "$mod545r10a1";?>';
   document.formv1.mod545r11a1.value = '<?php echo "$mod545r11a1";?>';

   document.formv1.mod545r01a2.value = '<?php echo "$mod545r01a2";?>';
   document.formv1.mod545r02a2.value = '<?php echo "$mod545r02a2";?>';
   document.formv1.mod545r03a2.value = '<?php echo "$mod545r03a2";?>';
   document.formv1.mod545r04a2.value = '<?php echo "$mod545r04a2";?>';
   document.formv1.mod545r05a2.value = '<?php echo "$mod545r05a2";?>';
   document.formv1.mod545r06a2.value = '<?php echo "$mod545r06a2";?>';
   document.formv1.mod545r07a2.value = '<?php echo "$mod545r07a2";?>';
   document.formv1.mod545r08a2.value = '<?php echo "$mod545r08a2";?>';
   document.formv1.mod545r09a2.value = '<?php echo "$mod545r09a2";?>';
   document.formv1.mod545r10a2.value = '<?php echo "$mod545r10a2";?>';
   document.formv1.mod545r11a2.value = '<?php echo "$mod545r11a2";?>';

   document.formv1.mod143r01.value = '<?php echo "$mod143r01";?>';
   document.formv1.mod143r05.value = '<?php echo "$mod143r05";?>';
   document.formv1.mod143r06.value = '<?php echo "$mod143r06";?>';
   document.formv1.mod143r07.value = '<?php echo "$mod143r07";?>';
   document.formv1.mod143r08.value = '<?php echo "$mod143r08";?>';
   document.formv1.mod143r09.value = '<?php echo "$mod143r09";?>';
   document.formv1.mod143r10.value = '<?php echo "$mod143r10";?>';
   document.formv1.mod143r12.value = '<?php echo "$mod143r12";?>';
   document.formv1.mod143r13.value = '<?php echo "$mod143r13";?>';
   document.formv1.mod143r14.value = '<?php echo "$mod143r14";?>';
   document.formv1.mod143r15.value = '<?php echo "$mod143r15";?>';
   document.formv1.mod143r20.value = '<?php echo "$mod143r20";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('../dokumenty/statistika2014/prod1304/prod1304v14_metod_pokyny.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_p1304.php?copern=11&strana=9999', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../ucto/statistika_p1304.php?h_mfir=<?php echo $kli_vxcf; ?>&copern=200&drupoh=1&page=1&typ=PDF&cstat=1304&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function zarch( stvrtrok )
  {
   window.open('../ucto/statistika_p1304.php?copern=11&drupoh=1&page=1&typ=PDF&zarchivu=1&stvarch=' + stvrtrok +  '&xxx=1', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 102 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">�tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Metodick� vysvetlivky k obsahu v�kazu" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi� v�etky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="statistika_p1304.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
$source="statistika_p1304.php?";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <h6 class="toleft" style="margin-left:580px; padding-right:5px;">Arch�v:</h6>
<?php
$tvpol=0;
$sqltt = "SELECT * FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys >= 1 ";
$tov = mysql_query("$sqltt");
if ( $tov) { $tvpol = mysql_num_rows($tov); }
$i=0;
  while ( $i < $tvpol )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
if ( $i == 0 ) { echo " "; }

$psysrim="I.";
if ( $rtov->psys == 2 ) { $psysrim="II."; }
if ( $rtov->psys == 3 ) { $psysrim="III."; }
if ( $rtov->psys == 4 ) { $psysrim="IV."; }
echo "<a href='#' onclick='zarch(".$rtov->psys.")' title='K�pia v�kazu z arch�vu za ".$rtov->psys.".�tvr�rok'
       class='archiv-link' style=''>".$psysrim."</a>";
}
$i=$i+1;
   }
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">Tla�i�:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/prod1304/prod1304v14_str1.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Prod 13-04 1.strana 132kB" class="form-background">
<?php
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
$kli_vrokx = substr($kli_vrok,2,2);
?>
<span class="text-echo" style="top:214px; left:475px; font-size:24px;"><?php echo $kli_vrok; ?></span>
<span class="text-echo" style="top:311px; left:232px; font-size:18px; letter-spacing:30px;"><?php echo $kli_vrokx; ?></span>
<span class="text-echo" style="top:311px; left:312px; font-size:18px; letter-spacing:30px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:311px; left:394px; font-size:18px; letter-spacing:35px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:791px; left:53px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:813px; left:53px;"><?php echo "$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:791px; left:808px;"><?php echo $okres; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastavi� k�d okresu"
  class="btn-row-tool" style="top:789px; left:839px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:864px; left:53px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:880px; left:388px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:932px; left:53px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
 style="width:90px; top:929px; left:390px;"/>

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:1101px; left:680px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:1128px; left:680px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/prod1304/prod1304v14_str2.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Prod 13-04 2.strana 120kB" class="form-background">

<!-- modul 82 -->
<img src="../obr/ikony/download_blue_icon.png"  title="Na��ta� �daje z V�sledovky"
 onclick="window.open('../ucto/vys_mala.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=1304&vyb_ume=<?php echo $vyb_umk; ?>', '_self')"
 style="top:80px; left:387px;" class="btn-row-tool">
<input type="text" name="mod82r01" id="mod82r01" style="width:100px; top:189px; left:680px;"/>
<input type="text" name="mod82r02" id="mod82r02" style="width:100px; top:219px; left:680px;"/>
<input type="text" name="mod82r03" id="mod82r03" style="width:100px; top:250px; left:680px;"/>
<input type="text" name="mod82r04" id="mod82r04" style="width:100px; top:281px; left:680px;"/>
<input type="text" name="mod82r05" id="mod82r05" style="width:100px; top:311px; left:680px;"/>
<input type="text" name="mod82r06" id="mod82r06" style="width:100px; top:342px; left:680px;"/>
<input type="text" name="mod82r07" id="mod82r07" style="width:100px; top:372px; left:680px;"/>
<input type="text" name="mod82r08" id="mod82r08" style="width:100px; top:402px; left:680px;"/>
<input type="text" name="mod82r09" id="mod82r09" style="width:100px; top:434px; left:680px;"/>
<input type="text" name="mod82r10" id="mod82r10" style="width:100px; top:465px; left:680px;"/>
<span class="text-echo" style="top:499px; right:165px;"><?php echo $mod82r99; ?></span>

<!-- modul 100064 -->
<script>
  function klikm113ano()
  {
   document.formv1.mod113nie.checked = false;
  }
  function klikm113nie()
  {
   document.formv1.mod113ano.checked = false;
  }
</script>
<input type="checkbox" name="mod113ano" value="1" onchange="klikm113ano();"
 style="width:100px; top:628px; left:796px;"/>
<input type="checkbox" name="mod113nie" value="1" onchange="klikm113nie();"
 style="width:100px; top:654px; left:796px;"/>

<!-- modul 112a -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovej predvahy"
 onclick="window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=1304&vyb_ume=<?php echo $vyb_umk; ?>', '_self')"
 style="top:789px; left:532px;" class="btn-row-tool">
<input type="text" name="mod112r01a1" id="mod112r01a1" style="width:100px; top:926px; left:510px;"/>
<input type="text" name="mod112r01a4" id="mod112r01a4" style="width:100px; top:926px; left:735px;"/>
<input type="text" name="mod112r02a1" id="mod112r02a1" style="width:100px; top:956px; left:510px;"/>
<input type="text" name="mod112r02a4" id="mod112r02a4" style="width:100px; top:956px; left:735px;"/>
<input type="text" name="mod112r03a1" id="mod112r03a1" style="width:100px; top:987px; left:510px;"/>
<input type="text" name="mod112r03a4" id="mod112r03a4" style="width:100px; top:987px; left:735px;"/>
<input type="text" name="mod112r05a1" id="mod112r05a1" style="width:100px; top:1018px; left:510px;"/>
<input type="text" name="mod112r05a4" id="mod112r05a4" style="width:100px; top:1018px; left:735px;"/>
<input type="text" name="mod112r06a1" id="mod112r06a1" style="width:100px; top:1048px; left:510px;"/>
<input type="text" name="mod112r06a4" id="mod112r06a4" style="width:100px; top:1048px; left:735px;"/>
<input type="text" name="mod112r07a1" id="mod112r07a1" style="width:100px; top:1079px; left:510px;"/>
<input type="text" name="mod112r07a4" id="mod112r07a4" style="width:100px; top:1079px; left:735px;"/>
<input type="text" name="mod112r10a1" id="mod112r10a1" style="width:100px; top:1110px; left:510px;"/>
<input type="text" name="mod112r10a4" id="mod112r10a4" style="width:100px; top:1110px; left:735px;"/>
<span class="text-echo" style="top:1145px; right:334px;"><?php echo $mod112r99a1; ?></span>
<span class="text-echo" style="top:1145px; right:110px;"><?php echo $mod112r99a4; ?></span>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/prod1304/prod1304v14_str3.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Prod 13-04 3.strana 165kB" class="form-background">

<!-- modul 545 -->
<img src="../obr/ikony/download_blue_icon.png"  title="Na��ta� �daje z Obratovej predvahy"
 onclick="window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=1304545&vyb_ume=<?php echo $vyb_umk; ?>', '_self')"
 style="top:87px; left:337px;" class="btn-row-tool">
<input type="text" name="mod545r01a1" id="mod545r01a1" style="width:100px; top:207px; left:592px;"/>
<input type="text" name="mod545r01a2" id="mod545r01a2" style="width:100px; top:207px; left:765px;"/>
<input type="text" name="mod545r02a1" id="mod545r02a1" style="width:100px; top:237px; left:592px;"/>
<input type="text" name="mod545r02a2" id="mod545r02a2" style="width:100px; top:237px; left:765px;"/>
<input type="text" name="mod545r03a1" id="mod545r03a1" style="width:100px; top:268px; left:592px;"/>
<input type="text" name="mod545r03a2" id="mod545r03a2" style="width:100px; top:268px; left:765px;"/>
<input type="text" name="mod545r04a1" id="mod545r04a1" style="width:100px; top:298px; left:592px;"/>
<input type="text" name="mod545r04a2" id="mod545r04a2" style="width:100px; top:298px; left:765px;"/>
<input type="text" name="mod545r05a1" id="mod545r05a1" style="width:100px; top:329px; left:592px;"/>
<input type="text" name="mod545r05a2" id="mod545r05a2" style="width:100px; top:329px; left:765px;"/>
<input type="text" name="mod545r06a1" id="mod545r06a1" style="width:100px; top:360px; left:592px;"/>
<input type="text" name="mod545r06a2" id="mod545r06a2" style="width:100px; top:360px; left:765px;"/>
<input type="text" name="mod545r07a1" id="mod545r07a1" style="width:100px; top:390px; left:592px;"/>
<input type="text" name="mod545r07a2" id="mod545r07a2" style="width:100px; top:390px; left:765px;"/>
<input type="text" name="mod545r08a1" id="mod545r08a1" style="width:100px; top:421px; left:592px;"/>
<input type="text" name="mod545r08a2" id="mod545r08a2" style="width:100px; top:421px; left:765px;"/>
<input type="text" name="mod545r09a1" id="mod545r09a1" style="width:100px; top:452px; left:592px;"/>
<input type="text" name="mod545r09a2" id="mod545r09a2" style="width:100px; top:452px; left:765px;"/>
<input type="text" name="mod545r10a1" id="mod545r10a1" style="width:100px; top:482px; left:592px;"/>
<input type="text" name="mod545r10a2" id="mod545r10a2" style="width:100px; top:482px; left:765px;"/>
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� Celkov� �hrn akt�v zo S�vahy"
 onclick="window.open('../ucto/suvaha__x.php?copern=10&drupoh=1&page=1&tis=0&typ=PDF&cstat=1304&vyb_ume=<?php echo $vyb_umk; ?>', '_self')"
 style="top:514px; left:354px;" class="btn-row-tool">
<input type="text" name="mod545r11a1" id="mod545r11a1" style="width:100px; top:513px; left:592px;"/>
<input type="text" name="mod545r11a2" id="mod545r11a2" style="width:100px; top:513px; left:765px;"/>
<span class="text-echo" style="top:548px; right:252px;"><?php echo $mod545r99a1; ?></span>
<span class="text-echo" style="top:548px; right:79px;"><?php echo $mod545r99a2; ?></span>

<!-- modul 143 -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z miezd"
 onclick="NacitajMzdy();" style="top:633px; left:442px;" class="btn-row-tool">
<input type="text" name="mod143r01" id="mod143r01" onkeyup="CiarkaNaBodku(this);"
 style="width:100px; top:736px; left:680px;"/>
<input type="text" name="mod143r05" id="mod143r05" style="width:100px; top:774px; left:680px;"/>
<input type="text" name="mod143r06" id="mod143r06" style="width:100px; top:804px; left:680px;"/>
<input type="text" name="mod143r07" id="mod143r07" style="width:100px; top:834px; left:680px;"/>
<input type="text" name="mod143r08" id="mod143r08" style="width:100px; top:870px; left:680px;"/>
<input type="text" name="mod143r09" id="mod143r09" style="width:100px; top:912px; left:680px;"/>
<input type="text" name="mod143r10" id="mod143r10" style="width:100px; top:949px; left:680px;"/>
<input type="text" name="mod143r12" id="mod143r12" style="width:100px; top:980px; left:680px;"/>
<input type="text" name="mod143r13" id="mod143r13" style="width:100px; top:1010px; left:680px;"/>
<input type="text" name="mod143r14" id="mod143r14" style="width:100px; top:1041px; left:680px;"/>
<input type="text" name="mod143r15" id="mod143r15" style="width:100px; top:1077px; left:680px;"/>
<input type="text" name="mod143r20" id="mod143r20" style="width:100px; top:1123px; left:680px;"/>
<span class="text-echo" style="top:1166px; right:165px;"><?php echo $mod143r99; ?></span>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//&zarchivu=1&stvarch
$zarchivu = 1*strip_tags($_REQUEST['zarchivu']);
$stvarch = 1*strip_tags($_REQUEST['stvarch']);

//vytlac
if ( $zarchivu == 0 )
     {
$sqltt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET psys=$stvrtrok "; 
$sql = mysql_query("$sqltt");
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_p1304 WHERE ico >= 0 "."";
     }

if ( $zarchivu == 1 )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_p1304arch WHERE psys = $stvarch "; 
$stvrtrok=$stvarch;
$psys=$stvarch;
     }
//echo $sqltt;
//exit;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/prod1304/prod1304v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/prod1304/prod1304v14_str1.jpg',0,0,210,297);
}

//OBDOBIA
$pdf->SetFont('arial','',15);
$pdf->Cell(190,34," ","$rmc1",1,"L");
$pdf->Cell(87,8," ","$rmc1",0,"L");$pdf->Cell(30,5,"$kli_vrok ","$rmc1",1,"C");
$pdf->SetFont('arial','',11);
$pdf->Cell(190,16," ","$rmc1",1,"L");
$R1=substr($kli_vrok,2,1);
$R2=substr($kli_vrok,3,1);
$A=substr($mesiac,0,1);
$B=substr($mesiac,1,1);

if ( $zarchivu == 1 AND $stvarch == 1 ) { $A=0; $B=3; }
if ( $zarchivu == 1 AND $stvarch == 2 ) { $A=0; $B=6; }
if ( $zarchivu == 1 AND $stvarch == 3 ) { $A=0; $B=9; }
if ( $zarchivu == 1 AND $stvarch == 4 ) { $A=1; $B=2; }

$pdf->Cell(38,5," ","$rmc1",0,"L");
$pdf->Cell(9,6,"$R1","$rmc",0,"C");$pdf->Cell(9,6,"$R2","$rmc",0,"C");$pdf->Cell(9,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");
//ico
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(10,6,"$A","$rmc",0,"C");$pdf->Cell(10,6,"$B","$rmc",0,"C");$pdf->Cell(10,6,"$C","$rmc",0,"C");$pdf->Cell(10,6,"$D","$rmc",0,"C");
$pdf->Cell(10,6,"$E","$rmc",0,"C");$pdf->Cell(10,6,"$F","$rmc",0,"C");$pdf->Cell(10,6,"$G","$rmc",0,"C");$pdf->Cell(10,6,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,104," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,4,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,4,"$okres","$rmc",1,"C");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,10," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(43,5,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,7,"$fir_fem1","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
//odoslane
$pdf->Cell(43,7,"$odoslane_sk","$rmc",1,"C");

//modul 2
$mod2r01=$hlavicka->mod2r01;
if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02;
if ( $mod2r02 == 0 ) $mod2r02="";
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$mod2r01","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r02","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/prod1304/prod1304v14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/prod1304/prod1304v14_str2.jpg',0,0,210,297);
}

$mod82r01=$hlavicka->mod82r01;
if ( $hlavicka->mod82r01 == 0 ) $mod82r01="";
$mod82r02=$hlavicka->mod82r02;
if ( $hlavicka->mod82r02 == 0 ) $mod82r02="";
$mod82r03=$hlavicka->mod82r03;
if ( $hlavicka->mod82r03 == 0 ) $mod82r03="";
$mod82r04=$hlavicka->mod82r04;
if ( $hlavicka->mod82r04 == 0 ) $mod82r04="";
$mod82r05=$hlavicka->mod82r05;
if ( $hlavicka->mod82r05 == 0 ) $mod82r05="";
$mod82r06=$hlavicka->mod82r06;
if ( $hlavicka->mod82r06 == 0 ) $mod82r06="";
$mod82r07=$hlavicka->mod82r07;
if ( $hlavicka->mod82r07 == 0 ) $mod82r07="";
$mod82r08=$hlavicka->mod82r08;
if ( $hlavicka->mod82r08 == 0 ) $mod82r08="";
$mod82r09=$hlavicka->mod82r09;
if ( $hlavicka->mod82r09 == 0 ) $mod82r09="";
$mod82r10=$hlavicka->mod82r10;
if ( $hlavicka->mod82r10 == 0 ) $mod82r10="";
$mod82r99=$hlavicka->mod82r99;
//if ( $hlavicka->mod82r99 == 0 ) $mod82r99="";

$mod112r01a1=$hlavicka->mod112r01a1;
if( $hlavicka->mod112r01a1 == 0 ) $mod112r01a1="";
$mod112r02a1=$hlavicka->mod112r02a1;
if( $hlavicka->mod112r02a1 == 0 ) $mod112r02a1="";
$mod112r03a1=$hlavicka->mod112r03a1;
if( $hlavicka->mod112r03a1 == 0 ) $mod112r03a1="";
$mod112r04a1=$hlavicka->mod112r04a1;
if( $hlavicka->mod112r04a1 == 0 ) $mod112r04a1="";
$mod112r05a1=$hlavicka->mod112r05a1;
if( $hlavicka->mod112r05a1 == 0 ) $mod112r05a1="";
$mod112r06a1=$hlavicka->mod112r06a1;
if( $hlavicka->mod112r06a1 == 0 ) $mod112r06a1="";
$mod112r07a1=$hlavicka->mod112r07a1;
if( $hlavicka->mod112r07a1 == 0 ) $mod112r07a1="";
$mod112r08a1=$hlavicka->mod112r08a1;
if( $hlavicka->mod112r08a1 == 0 ) $mod112r08a1="";
$mod112r09a1=$hlavicka->mod112r09a1;
if( $hlavicka->mod112r09a1 == 0 ) $mod112r09a1="";
$mod112r10a1=$hlavicka->mod112r10a1;
if( $hlavicka->mod112r10a1 == 0 ) $mod112r10a1="";
$mod112r11a1=$hlavicka->mod112r11a1;
if( $hlavicka->mod112r11a1 == 0 ) $mod112r11a1="";
$mod112r12a1=$hlavicka->mod112r12a1;
if( $hlavicka->mod112r12a1 == 0 ) $mod112r12a1="";
$mod112r13a1=$hlavicka->mod112r13a1;
if( $hlavicka->mod112r13a1 == 0 ) $mod112r13a1="";
$mod112r99a1=$hlavicka->mod112r99a1;
//if( $hlavicka->mod112r99a1 == 0 ) $mod112r99a1="";

$mod112r01a4=$hlavicka->mod112r01a4;
if( $hlavicka->mod112r01a4 == 0 ) $mod112r01a4="";
$mod112r02a4=$hlavicka->mod112r02a4;
if( $hlavicka->mod112r02a4 == 0 ) $mod112r02a4="";
$mod112r03a4=$hlavicka->mod112r03a4;
if( $hlavicka->mod112r03a4 == 0 ) $mod112r03a4="";
$mod112r04a4=$hlavicka->mod112r04a4;
if( $hlavicka->mod112r04a4 == 0 ) $mod112r04a4="";
$mod112r05a4=$hlavicka->mod112r05a4;
if( $hlavicka->mod112r05a4 == 0 ) $mod112r05a4="";
$mod112r06a4=$hlavicka->mod112r06a4;
if( $hlavicka->mod112r06a4 == 0 ) $mod112r06a4="";
$mod112r07a4=$hlavicka->mod112r07a4;
if( $hlavicka->mod112r07a4 == 0 ) $mod112r07a4="";
$mod112r08a4=$hlavicka->mod112r08a4;
if( $hlavicka->mod112r08a4 == 0 ) $mod112r08a4="";
$mod112r09a4=$hlavicka->mod112r09a4;
if( $hlavicka->mod112r09a4 == 0 ) $mod112r09a4="";
$mod112r10a4=$hlavicka->mod112r10a4;
if( $hlavicka->mod112r10a4 == 0 ) $mod112r10a4="";
$mod112r11a4=$hlavicka->mod112r11a4;
if( $hlavicka->mod112r11a4 == 0 ) $mod112r11a4="";
$mod112r12a4=$hlavicka->mod112r12a4;
if( $hlavicka->mod112r12a4 == 0 ) $mod112r12a4="";
$mod112r13a4=$hlavicka->mod112r13a4;
if( $hlavicka->mod112r13a4 == 0 ) $mod112r13a4="";
$mod112r99a4=$hlavicka->mod112r99a4;
//if( $hlavicka->mod112r99a4 == 0 ) $mod112r99a4="";

//modul 82
$pdf->Cell(190,27," ","$rmc1",1,"L");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r01","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,6,"$mod82r02","$rmc",1,"R");
$pdf->Cell(144,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$mod82r03","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r04","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r05","$rmc",1,"R");
$pdf->Cell(144,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r06","$rmc",1,"R");
$pdf->Cell(144,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r07","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r08","$rmc",1,"R");
$pdf->Cell(144,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r09","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r10","$rmc",1,"R");
$pdf->Cell(144,6," ","$rmc1",0,"L");$pdf->Cell(40,7,"$mod82r99","$rmc",1,"R");

//modul 100064
$mod113ano=" ";
$mod113nie=" ";
if ( $hlavicka->mod113ano == 1 ) { $mod113ano="X"; }
if ( $hlavicka->mod113nie == 1 ) { $mod113nie="X"; }
$pdf->Cell(190,23," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,6,"$mod113ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,6,"$mod113nie","$rmc",1,"C");

//modul 112
$pdf->Cell(190,57," ","$rmc1",1,"L");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,6,"$mod112r01a1","$rmc",0,"R");$pdf->Cell(50,6,"$mod112r01a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$mod112r02a1","$rmc",0,"R");$pdf->Cell(50,7,"$mod112r02a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$mod112r03a1","$rmc",0,"R");$pdf->Cell(50,7,"$mod112r03a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,8,"$mod112r05a1","$rmc",0,"R");$pdf->Cell(50,8,"$mod112r05a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,6,"$mod112r06a1","$rmc",0,"R");$pdf->Cell(50,6,"$mod112r06a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$mod112r07a1","$rmc",0,"R");$pdf->Cell(50,7,"$mod112r07a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$mod112r10a1","$rmc",0,"R");$pdf->Cell(50,7,"$mod112r10a4","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"L");$pdf->Cell(46,8,"$mod112r99a1","$rmc",0,"R");$pdf->Cell(50,8,"$mod112r99a4","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/prod1304/prod1304v14_str3.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/prod1304/prod1304v14_str3.jpg',0,0,210,297);
}

$mod545r01a1=$hlavicka->mod545r01a1;
if( $hlavicka->mod545r01a1 == 0 ) $mod545r01a1="";
$mod545r02a1=$hlavicka->mod545r02a1;
if( $hlavicka->mod545r02a1 == 0 ) $mod545r02a1="";
$mod545r03a1=$hlavicka->mod545r03a1;
if( $hlavicka->mod545r03a1 == 0 ) $mod545r03a1="";
$mod545r04a1=$hlavicka->mod545r04a1;
if( $hlavicka->mod545r04a1 == 0 ) $mod545r04a1="";
$mod545r05a1=$hlavicka->mod545r05a1;
if( $hlavicka->mod545r05a1 == 0 ) $mod545r05a1="";
$mod545r06a1=$hlavicka->mod545r06a1;
if( $hlavicka->mod545r06a1 == 0 ) $mod545r06a1="";
$mod545r07a1=$hlavicka->mod545r07a1;
if( $hlavicka->mod545r07a1 == 0 ) $mod545r07a1="";
$mod545r08a1=$hlavicka->mod545r08a1;
if( $hlavicka->mod545r08a1 == 0 ) $mod545r08a1="";
$mod545r09a1=$hlavicka->mod545r09a1;
if( $hlavicka->mod545r09a1 == 0 ) $mod545r09a1="";
$mod545r10a1=$hlavicka->mod545r10a1;
if( $hlavicka->mod545r10a1 == 0 ) $mod545r10a1="";
$mod545r11a1=$hlavicka->mod545r11a1;
if( $hlavicka->mod545r11a1 == 0 ) $mod545r11a1="";
$mod545r12a1=$hlavicka->mod545r12a1;
if( $hlavicka->mod545r12a1 == 0 ) $mod545r12a1="";
$mod545r13a1=$hlavicka->mod545r13a1;
if( $hlavicka->mod545r13a1 == 0 ) $mod545r13a1="";
$mod545r14a1=$hlavicka->mod545r14a1;
if( $hlavicka->mod545r14a1 == 0 ) $mod545r14a1="";
$mod545r15a1=$hlavicka->mod545r15a1;
if( $hlavicka->mod545r15a1 == 0 ) $mod545r15a1="";
$mod545r16a1=$hlavicka->mod545r16a1;
if( $hlavicka->mod545r16a1 == 0 ) $mod545r16a1="";
$mod545r17a1=$hlavicka->mod545r17a1;
if( $hlavicka->mod545r17a1 == 0 ) $mod545r17a1="";
$mod545r18a1=$hlavicka->mod545r18a1;
if( $hlavicka->mod545r18a1 == 0 ) $mod545r18a1="";
$mod545r19a1=$hlavicka->mod545r19a1;
if( $hlavicka->mod545r19a1 == 0 ) $mod545r19a1="";
$mod545r20a1=$hlavicka->mod545r20a1;
if( $hlavicka->mod545r20a1 == 0 ) $mod545r20a1="";
$mod545r99a1=$hlavicka->mod545r99a1;
//if( $hlavicka->mod545r99a1 == 0 ) $mod545r99a1="";

$mod545r01a2=$hlavicka->mod545r01a2;
if( $hlavicka->mod545r01a2 == 0 ) $mod545r01a2="";
$mod545r02a2=$hlavicka->mod545r02a2;
if( $hlavicka->mod545r02a2 == 0 ) $mod545r02a2="";
$mod545r03a2=$hlavicka->mod545r03a2;
if( $hlavicka->mod545r03a2 == 0 ) $mod545r03a2="";
$mod545r04a2=$hlavicka->mod545r04a2;
if( $hlavicka->mod545r04a2 == 0 ) $mod545r04a2="";
$mod545r05a2=$hlavicka->mod545r05a2;
if( $hlavicka->mod545r05a2 == 0 ) $mod545r05a2="";
$mod545r06a2=$hlavicka->mod545r06a2;
if( $hlavicka->mod545r06a2 == 0 ) $mod545r06a2="";
$mod545r07a2=$hlavicka->mod545r07a2;
if( $hlavicka->mod545r07a2 == 0 ) $mod545r07a2="";
$mod545r08a2=$hlavicka->mod545r08a2;
if( $hlavicka->mod545r08a2 == 0 ) $mod545r08a2="";
$mod545r09a2=$hlavicka->mod545r09a2;
if( $hlavicka->mod545r09a2 == 0 ) $mod545r09a2="";
$mod545r10a2=$hlavicka->mod545r10a2;
if( $hlavicka->mod545r10a2 == 0 ) $mod545r10a2="";
$mod545r11a2=$hlavicka->mod545r11a2;
if( $hlavicka->mod545r11a2 == 0 ) $mod545r11a2="";
$mod545r12a2=$hlavicka->mod545r12a2;
if( $hlavicka->mod545r12a2 == 0 ) $mod545r12a2="";
$mod545r13a2=$hlavicka->mod545r13a2;
if( $hlavicka->mod545r13a2 == 0 ) $mod545r13a2="";
$mod545r14a2=$hlavicka->mod545r14a2;
if( $hlavicka->mod545r14a2 == 0 ) $mod545r14a2="";
$mod545r15a2=$hlavicka->mod545r15a2;
if( $hlavicka->mod545r15a2 == 0 ) $mod545r15a2="";
$mod545r16a2=$hlavicka->mod545r16a2;
if( $hlavicka->mod545r16a2 == 0 ) $mod545r16a2="";
$mod545r17a2=$hlavicka->mod545r17a2;
if( $hlavicka->mod545r17a2 == 0 ) $mod545r17a2="";
$mod545r18a2=$hlavicka->mod545r18a2;
if( $hlavicka->mod545r18a2 == 0 ) $mod545r18a2="";
$mod545r19a2=$hlavicka->mod545r19a2;
if( $hlavicka->mod545r19a2 == 0 ) $mod545r19a2="";
$mod545r20a2=$hlavicka->mod545r20a2;
if( $hlavicka->mod545r20a2 == 0 ) $mod545r20a2="";
$mod545r99a2=$hlavicka->mod545r99a2;
//if( $hlavicka->mod545r99a2 == 0 ) $mod545r99a2="";

$mod143r01=$hlavicka->mod143r01;
if( $hlavicka->mod143r01 == 0 ) $mod143r01="";
$mod143r02=$hlavicka->mod143r02;
if( $hlavicka->mod143r02 == 0 ) $mod143r02="";
$mod143r03=$hlavicka->mod143r03;
if( $hlavicka->mod143r03 == 0 ) $mod143r03="";
$mod143r04=$hlavicka->mod143r04;
if( $hlavicka->mod143r04 == 0 ) $mod143r04="";
$mod143r05=$hlavicka->mod143r05;
if( $hlavicka->mod143r05 == 0 ) $mod143r05="";
$mod143r06=$hlavicka->mod143r06;
if( $hlavicka->mod143r06 == 0 ) $mod143r06="";
$mod143r07=$hlavicka->mod143r07;
if( $hlavicka->mod143r07 == 0 ) $mod143r07="";
$mod143r08=$hlavicka->mod143r08;
if( $hlavicka->mod143r08 == 0 ) $mod143r08="";
$mod143r09=$hlavicka->mod143r09;
if( $hlavicka->mod143r09 == 0 ) $mod143r09="";
$mod143r10=$hlavicka->mod143r10;
if( $hlavicka->mod143r10 == 0 ) $mod143r10="";
$mod143r11=$hlavicka->mod143r11;
if( $hlavicka->mod143r11 == 0 ) $mod143r11="";
$mod143r12=$hlavicka->mod143r12;
if( $hlavicka->mod143r12 == 0 ) $mod143r12="";
$mod143r13=$hlavicka->mod143r13;
if( $hlavicka->mod143r13 == 0 ) $mod143r13="";
$mod143r14=$hlavicka->mod143r14;
if( $hlavicka->mod143r14 == 0 ) $mod143r14="";
$mod143r15=$hlavicka->mod143r15;
if( $hlavicka->mod143r15 == 0 ) $mod143r15="";
$mod143r16=$hlavicka->mod143r16;
if( $hlavicka->mod143r16 == 0 ) $mod143r16="";
$mod143r17=$hlavicka->mod143r17;
if( $hlavicka->mod143r17 == 0 ) $mod143r17="";
$mod143r18=$hlavicka->mod143r18;
if( $hlavicka->mod143r18 == 0 ) $mod143r18="";
$mod143r19=$hlavicka->mod143r19;
if( $hlavicka->mod143r19 == 0 ) $mod143r19="";
$mod143r20=$hlavicka->mod143r20;
if( $hlavicka->mod143r20 == 0 ) $mod143r20="";
$mod143r99=$hlavicka->mod143r99;
//if( $hlavicka->mod143r99 == 0 ) $mod143r99="";

//modul 545
$pdf->Cell(190,31," ","$rmc1",1,"L");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r01a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r01a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r02a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r02a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r03a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r03a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r04a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r04a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r05a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r05a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r06a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r06a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r07a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r07a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r08a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r08a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r09a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r09a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r10a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r10a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,7,"$mod545r11a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r11a2","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(35,8,"$mod545r99a1","$rmc",0,"R");$pdf->Cell(38,8,"$mod545r99a2","$rmc",1,"R");


//modul 143
$pdf->Cell(190,35," ","$rmc1",1,"L");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,9,"$mod143r01","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,7,"$mod143r05","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(70,8,"$mod143r06","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,7,"$mod143r07","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(70,9,"$mod143r08","$rmc",1,"R");
$pdf->Cell(114,9," ","$rmc1",0,"L");$pdf->Cell(70,9,"$mod143r09","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(70,8,"$mod143r10","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(70,6,"$mod143r12","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,7,"$mod143r13","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,7,"$mod143r14","$rmc",1,"R");
$pdf->Cell(114,6," ","$rmc1",0,"L");$pdf->Cell(70,11,"$mod143r15","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,10,"$mod143r20","$rmc",1,"R");
$pdf->Cell(114,7," ","$rmc1",0,"L");$pdf->Cell(70,8,"$mod143r99","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
if ( $zarchivu == 0 )
     {
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_p1304arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p1304arch ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p1304arch SELECT * FROM F".$kli_vxcf."_statistika_p1304 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_p1304arch WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_statistika_p1304arch SELECT * FROM F".$kli_vxcf."_statistika_p1304 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
    }
?> 
<script type="text/javascript">
 var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac


$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>