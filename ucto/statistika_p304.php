<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu P304 2017
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

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2017/prod304/prod304_v17";
$jpg_popis="tlaËivo ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ Prod 3-04 ".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
$mes1=1;
$mes2=3;
if ( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="4.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; $mes1=4; $mes2=6; }
if ( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="7.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; $mes1=7; $mes2=9; }
if ( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="10.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; $mes1=10; $mes2=12; }

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*strip_tags($_REQUEST['strana']);
$modul = 1*$_REQUEST['modul'];
if ( $copern == 1 ) { $copern=102; }
if ( $strana == 0 ) { $strana=1; }

//modul 1004
if ( $modul == 1004 )
{
$r02=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 OR LEFT(uce,3) = 503 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r03=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND LEFT(uce,3) >= 511 AND LEFT(uce,3) <= 511 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r05=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 549 OR LEFT(uce,3) = 582 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r06=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 551 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r07=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 521 OR LEFT(uce,3) = 522 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod1004s03='$r03', mod1004s05='$r05', mod1004s06='$r06', mod1004s07='$r07',  ".
" mod1004s02='$r02', mod1004s09=mod5r02 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

if ( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod1004r01=F$kli_vxcf"."_statistika_p304.mod1004r01-F$kli_vxcf"."_statistika_p304archx.mod1004r01, ".
" F$kli_vxcf"."_statistika_p304.mod1004r02=F$kli_vxcf"."_statistika_p304.mod1004r02-F$kli_vxcf"."_statistika_p304archx.mod1004r02, ".
" F$kli_vxcf"."_statistika_p304.mod1004r03=F$kli_vxcf"."_statistika_p304.mod1004r03-F$kli_vxcf"."_statistika_p304archx.mod1004r03, ".
" F$kli_vxcf"."_statistika_p304.mod1004r05=F$kli_vxcf"."_statistika_p304.mod1004r05-F$kli_vxcf"."_statistika_p304archx.mod1004r05, ".
" F$kli_vxcf"."_statistika_p304.mod1004r06=F$kli_vxcf"."_statistika_p304.mod1004r06-F$kli_vxcf"."_statistika_p304archx.mod1004r06, ".
" F$kli_vxcf"."_statistika_p304.mod1004r07=F$kli_vxcf"."_statistika_p304.mod1004r07-F$kli_vxcf"."_statistika_p304archx.mod1004r07  ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


if ( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" SET F$kli_vxcf"."_statistika_p304.mod1004r01=F$kli_vxcf"."_statistika_p304.mod1004r01-F$kli_vxcf"."_statistika_p304archx.mod1004r01, ".
" F$kli_vxcf"."_statistika_p304.mod1004r02=F$kli_vxcf"."_statistika_p304.mod1004r02-F$kli_vxcf"."_statistika_p304archx.mod1004r02, ".
" F$kli_vxcf"."_statistika_p304.mod1004r03=F$kli_vxcf"."_statistika_p304.mod1004r03-F$kli_vxcf"."_statistika_p304archx.mod1004r03, ".
" F$kli_vxcf"."_statistika_p304.mod1004r05=F$kli_vxcf"."_statistika_p304.mod1004r05-F$kli_vxcf"."_statistika_p304archx.mod1004r05, ".
" F$kli_vxcf"."_statistika_p304.mod1004r06=F$kli_vxcf"."_statistika_p304.mod1004r06-F$kli_vxcf"."_statistika_p304archx.mod1004r06, ".
" F$kli_vxcf"."_statistika_p304.mod1004r07=F$kli_vxcf"."_statistika_p304.mod1004r07-F$kli_vxcf"."_statistika_p304archx.mod1004r07  ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


//exit;

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" SET F$kli_vxcf"."_statistika_p304.mod1004r01=F$kli_vxcf"."_statistika_p304.mod1004r01-F$kli_vxcf"."_statistika_p304archx.mod1004r01, ".
" F$kli_vxcf"."_statistika_p304.mod1004r02=F$kli_vxcf"."_statistika_p304.mod1004r02-F$kli_vxcf"."_statistika_p304archx.mod1004r02, ".
" F$kli_vxcf"."_statistika_p304.mod1004r03=F$kli_vxcf"."_statistika_p304.mod1004r03-F$kli_vxcf"."_statistika_p304archx.mod1004r03, ".
" F$kli_vxcf"."_statistika_p304.mod1004r05=F$kli_vxcf"."_statistika_p304.mod1004r05-F$kli_vxcf"."_statistika_p304archx.mod1004r05, ".
" F$kli_vxcf"."_statistika_p304.mod1004r06=F$kli_vxcf"."_statistika_p304.mod1004r06-F$kli_vxcf"."_statistika_p304archx.mod1004r06, ".
" F$kli_vxcf"."_statistika_p304.mod1004r07=F$kli_vxcf"."_statistika_p304.mod1004r07-F$kli_vxcf"."_statistika_p304archx.mod1004r07  ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");
$strana=6;
$copern=402;
}
//koniec modul1004

//modul 1003
if( $modul == 1003 )
{
$r02=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 606 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r03=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 604 OR LEFT(uce,3) = 607 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r05=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 621 OR LEFT(uce,3) = 622 OR LEFT(uce,3) = 623 OR LEFT(uce,3) = 624 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r06=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 611 OR LEFT(uce,3) = 612 OR LEFT(uce,3) = 613 OR LEFT(uce,3) = 614 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r07=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 504 OR LEFT(uce,3) = 507 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod1003s03='$r03', mod1003s05='$r05', mod1003s06='$r06', mod1003s07='$r07',  ".
" mod1003s02='$r02' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

if ( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod1003r01=F$kli_vxcf"."_statistika_p304.mod1003r01-F$kli_vxcf"."_statistika_p304archx.mod1003r01, ".
" F$kli_vxcf"."_statistika_p304.mod1003r02=F$kli_vxcf"."_statistika_p304.mod1003r02-F$kli_vxcf"."_statistika_p304archx.mod1003r02, ".
" F$kli_vxcf"."_statistika_p304.mod1003r03=F$kli_vxcf"."_statistika_p304.mod1003r03-F$kli_vxcf"."_statistika_p304archx.mod1003r03, ".
" F$kli_vxcf"."_statistika_p304.mod1003r05=F$kli_vxcf"."_statistika_p304.mod1003r05-F$kli_vxcf"."_statistika_p304archx.mod1003r05, ".
" F$kli_vxcf"."_statistika_p304.mod1003r06=F$kli_vxcf"."_statistika_p304.mod1003r06-F$kli_vxcf"."_statistika_p304archx.mod1003r06, ".
" F$kli_vxcf"."_statistika_p304.mod1003r07=F$kli_vxcf"."_statistika_p304.mod1003r07-F$kli_vxcf"."_statistika_p304archx.mod1003r07  ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


if ( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" SET F$kli_vxcf"."_statistika_p304.mod82r01=F$kli_vxcf"."_statistika_p304.mod82r01-F$kli_vxcf"."_statistika_p304arch.mod82r01, ".
" F$kli_vxcf"."_statistika_p304.mod1003r02=F$kli_vxcf"."_statistika_p304.mod1003r02-F$kli_vxcf"."_statistika_p304archx.mod1003r02, ".
" F$kli_vxcf"."_statistika_p304.mod1003r03=F$kli_vxcf"."_statistika_p304.mod1003r03-F$kli_vxcf"."_statistika_p304archx.mod1003r03, ".
" F$kli_vxcf"."_statistika_p304.mod1003r05=F$kli_vxcf"."_statistika_p304.mod1003r05-F$kli_vxcf"."_statistika_p304archx.mod1003r05, ".
" F$kli_vxcf"."_statistika_p304.mod1003r06=F$kli_vxcf"."_statistika_p304.mod1003r06-F$kli_vxcf"."_statistika_p304archx.mod1003r06, ".
" F$kli_vxcf"."_statistika_p304.mod1003r07=F$kli_vxcf"."_statistika_p304.mod1003r07-F$kli_vxcf"."_statistika_p304archx.mod1003r07  ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


//exit;

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" F$kli_vxcf"."_statistika_p304.mod1003r02=F$kli_vxcf"."_statistika_p304.mod1003r02-F$kli_vxcf"."_statistika_p304archx.mod1003r02, ".
" F$kli_vxcf"."_statistika_p304.mod1003r03=F$kli_vxcf"."_statistika_p304.mod1003r03-F$kli_vxcf"."_statistika_p304archx.mod1003r03, ".
" F$kli_vxcf"."_statistika_p304.mod1003r05=F$kli_vxcf"."_statistika_p304.mod1003r05-F$kli_vxcf"."_statistika_p304archx.mod1003r05, ".
" F$kli_vxcf"."_statistika_p304.mod1003r06=F$kli_vxcf"."_statistika_p304.mod1003r06-F$kli_vxcf"."_statistika_p304archx.mod1003r06, ".
" F$kli_vxcf"."_statistika_p304.mod1003r07=F$kli_vxcf"."_statistika_p304.mod1003r07-F$kli_vxcf"."_statistika_p304archx.mod1003r07  ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");


$strana=5;
$copern=402;
}
//koniec modul1003


//prepnute z vys_mala.php modul 82(145) odpocitaj predchadzajuce stvrtroky
if ( $modul == 82 )
{
$copern=102;
if ( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod82r01=F$kli_vxcf"."_statistika_p304.mod82r01-F$kli_vxcf"."_statistika_p304archx.mod82r01, ".
" F$kli_vxcf"."_statistika_p304.mod82r02=F$kli_vxcf"."_statistika_p304.mod82r02-F$kli_vxcf"."_statistika_p304archx.mod82r02, ".
" F$kli_vxcf"."_statistika_p304.mod82r03=F$kli_vxcf"."_statistika_p304.mod82r03-F$kli_vxcf"."_statistika_p304archx.mod82r03, ".
" F$kli_vxcf"."_statistika_p304.mod82r04=F$kli_vxcf"."_statistika_p304.mod82r04-F$kli_vxcf"."_statistika_p304archx.mod82r04, ".
" F$kli_vxcf"."_statistika_p304.mod82r05=F$kli_vxcf"."_statistika_p304.mod82r05-F$kli_vxcf"."_statistika_p304archx.mod82r05, ".
" F$kli_vxcf"."_statistika_p304.mod82r06=F$kli_vxcf"."_statistika_p304.mod82r06-F$kli_vxcf"."_statistika_p304archx.mod82r06, ".
" F$kli_vxcf"."_statistika_p304.mod82r07=F$kli_vxcf"."_statistika_p304.mod82r07-F$kli_vxcf"."_statistika_p304archx.mod82r07, ".
" F$kli_vxcf"."_statistika_p304.mod82r08=F$kli_vxcf"."_statistika_p304.mod82r08-F$kli_vxcf"."_statistika_p304archx.mod82r08, ".
" F$kli_vxcf"."_statistika_p304.mod82r09=F$kli_vxcf"."_statistika_p304.mod82r09-F$kli_vxcf"."_statistika_p304archx.mod82r09, ".
" F$kli_vxcf"."_statistika_p304.mod82r10=F$kli_vxcf"."_statistika_p304.mod82r10-F$kli_vxcf"."_statistika_p304archx.mod82r10, ".
" F$kli_vxcf"."_statistika_p304.mod82r99=F$kli_vxcf"."_statistika_p304.mod82r99-F$kli_vxcf"."_statistika_p304archx.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


if ( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" SET F$kli_vxcf"."_statistika_p304.mod82r01=F$kli_vxcf"."_statistika_p304.mod82r01-F$kli_vxcf"."_statistika_p304arch.mod82r01, ".
" F$kli_vxcf"."_statistika_p304.mod82r02=F$kli_vxcf"."_statistika_p304.mod82r02-F$kli_vxcf"."_statistika_p304arch.mod82r02, ".
" F$kli_vxcf"."_statistika_p304.mod82r03=F$kli_vxcf"."_statistika_p304.mod82r03-F$kli_vxcf"."_statistika_p304arch.mod82r03, ".
" F$kli_vxcf"."_statistika_p304.mod82r04=F$kli_vxcf"."_statistika_p304.mod82r04-F$kli_vxcf"."_statistika_p304arch.mod82r04, ".
" F$kli_vxcf"."_statistika_p304.mod82r05=F$kli_vxcf"."_statistika_p304.mod82r05-F$kli_vxcf"."_statistika_p304arch.mod82r05, ".
" F$kli_vxcf"."_statistika_p304.mod82r06=F$kli_vxcf"."_statistika_p304.mod82r06-F$kli_vxcf"."_statistika_p304arch.mod82r06, ".
" F$kli_vxcf"."_statistika_p304.mod82r07=F$kli_vxcf"."_statistika_p304.mod82r07-F$kli_vxcf"."_statistika_p304arch.mod82r07, ".
" F$kli_vxcf"."_statistika_p304.mod82r08=F$kli_vxcf"."_statistika_p304.mod82r08-F$kli_vxcf"."_statistika_p304arch.mod82r08, ".
" F$kli_vxcf"."_statistika_p304.mod82r09=F$kli_vxcf"."_statistika_p304.mod82r09-F$kli_vxcf"."_statistika_p304arch.mod82r09, ".
" F$kli_vxcf"."_statistika_p304.mod82r10=F$kli_vxcf"."_statistika_p304.mod82r10-F$kli_vxcf"."_statistika_p304arch.mod82r10, ".
" F$kli_vxcf"."_statistika_p304.mod82r99=F$kli_vxcf"."_statistika_p304.mod82r99-F$kli_vxcf"."_statistika_p304arch.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }


//exit;

if ( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304arch ".
" SET F$kli_vxcf"."_statistika_p304.mod82r01=F$kli_vxcf"."_statistika_p304.mod82r01-F$kli_vxcf"."_statistika_p304arch.mod82r01, ".
" F$kli_vxcf"."_statistika_p304.mod82r02=F$kli_vxcf"."_statistika_p304.mod82r02-F$kli_vxcf"."_statistika_p304arch.mod82r02, ".
" F$kli_vxcf"."_statistika_p304.mod82r03=F$kli_vxcf"."_statistika_p304.mod82r03-F$kli_vxcf"."_statistika_p304arch.mod82r03, ".
" F$kli_vxcf"."_statistika_p304.mod82r04=F$kli_vxcf"."_statistika_p304.mod82r04-F$kli_vxcf"."_statistika_p304arch.mod82r04, ".
" F$kli_vxcf"."_statistika_p304.mod82r05=F$kli_vxcf"."_statistika_p304.mod82r05-F$kli_vxcf"."_statistika_p304arch.mod82r05, ".
" F$kli_vxcf"."_statistika_p304.mod82r06=F$kli_vxcf"."_statistika_p304.mod82r06-F$kli_vxcf"."_statistika_p304arch.mod82r06, ".
" F$kli_vxcf"."_statistika_p304.mod82r07=F$kli_vxcf"."_statistika_p304.mod82r07-F$kli_vxcf"."_statistika_p304arch.mod82r07, ".
" F$kli_vxcf"."_statistika_p304.mod82r08=F$kli_vxcf"."_statistika_p304.mod82r08-F$kli_vxcf"."_statistika_p304arch.mod82r08, ".
" F$kli_vxcf"."_statistika_p304.mod82r09=F$kli_vxcf"."_statistika_p304.mod82r09-F$kli_vxcf"."_statistika_p304arch.mod82r09, ".
" F$kli_vxcf"."_statistika_p304.mod82r10=F$kli_vxcf"."_statistika_p304.mod82r10-F$kli_vxcf"."_statistika_p304arch.mod82r10, ".
" F$kli_vxcf"."_statistika_p304.mod82r99=F$kli_vxcf"."_statistika_p304.mod82r99-F$kli_vxcf"."_statistika_p304arch.mod82r99 ".
" WHERE F$kli_vxcf"."_statistika_p304arch.psys = 3 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");
$strana=2;
}
//koniec odpocitaj modul 82 z vys_mala.php


//prepnute z uobrat.php modul 112 odpocitaj predchadzajuce stvrtroky
if( $modul == 112 )
{
if( $stvrtrok == 2 OR $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod112r01a1=F$kli_vxcf"."_statistika_p304.mod112r01a1-F$kli_vxcf"."_statistika_p304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a1=F$kli_vxcf"."_statistika_p304.mod112r02a1-F$kli_vxcf"."_statistika_p304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a4=F$kli_vxcf"."_statistika_p304.mod112r02a4-F$kli_vxcf"."_statistika_p304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 3 OR $stvrtrok == 4 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod112r01a1=F$kli_vxcf"."_statistika_p304.mod112r01a1-F$kli_vxcf"."_statistika_p304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a1=F$kli_vxcf"."_statistika_p304.mod112r02a1-F$kli_vxcf"."_statistika_p304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a4=F$kli_vxcf"."_statistika_p304.mod112r02a4-F$kli_vxcf"."_statistika_p304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 2 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod112r01a1=F$kli_vxcf"."_statistika_p304.mod112r01a1-F$kli_vxcf"."_statistika_p304archx.mod112r01a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a1=F$kli_vxcf"."_statistika_p304.mod112r02a1-F$kli_vxcf"."_statistika_p304archx.mod112r02a1, ".
" F$kli_vxcf"."_statistika_p304.mod112r02a4=F$kli_vxcf"."_statistika_p304.mod112r02a4-F$kli_vxcf"."_statistika_p304archx.mod112r02a4 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 3 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod112r12a1=mod112r02a1, mod112r12a4=mod112r02a4,".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r04a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r08a1+mod112r09a1+mod112r10a1+mod112r11a1+mod112r12a1,".
" mod112r99a2=mod112r01a2+mod112r02a2+mod112r03a2+mod112r04a2+mod112r05a2+mod112r06a2+mod112r07a2+mod112r08a2+mod112r09a2+mod112r10a2+mod112r11a2+mod112r12a2,".
" mod112r99a3=mod112r01a3+mod112r02a3+mod112r03a3+mod112r04a3+mod112r05a3+mod112r06a3+mod112r07a3+mod112r08a3+mod112r09a3+mod112r10a3+mod112r11a3+mod112r12a3,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r04a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r08a4+mod112r09a4+mod112r10a4+mod112r11a4+mod112r12a4 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=3;
}
//koniec odpocitaj modul 112 z uobrat.php


//prepnute z uobrat.php modul 146(545) odpocitaj predchadzajuce stvrtroky
if( $modul == 545 )
{
$copern=102;

//nacitaj nove polozky 146
$r11a1=0; $r11a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 061 OR LEFT(uce,3) = 062 OR LEFT(uce,3) = 063 OR LEFT(uce,3) = 069 OR LEFT(uce,3) = 251 OR LEFT(uce,3) = 257 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11a1=$r11a1-$polozka->pdl+$polozka->pmd; $r11a2=$r11a2-$polozka->zdl+$polozka->zmd;  }
$i=$i+1;                   }

$r13a1=0; $r13a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 065 OR LEFT(uce,3) = 253 OR LEFT(uce,3) = 256 OR LEFT(uce,3) = 312 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r13a1=$r13a1-$polozka->pdl+$polozka->pmd; $r13a2=$r13a2-$polozka->zdl+$polozka->zmd;  }
$i=$i+1;                   }

$r14a1=0; $r14a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 066 OR LEFT(uce,3) = 067 OR LEFT(uce,3) = 351 OR LEFT(uce,3) = 355 OR LEFT(uce,2) = 27 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r14a1=$r14a1-$polozka->pdl+$polozka->pmd; $r14a2=$r14a2-$polozka->zdl+$polozka->zmd;  }
$i=$i+1;                   }

$r16a1=0; $r16a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 313 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 316 OR LEFT(uce,3) = 335 OR LEFT(uce,3) = 314 OR LEFT(uce,3) = 051 OR ".
"   LEFT(uce,3) = 052 OR LEFT(uce,3) = 053 OR LEFT(uce,3) = 378 OR LEFT(uce,3) = 374 OR LEFT(uce,3) = 375 OR LEFT(uce,3) = 376 OR LEFT(uce,3) = 371 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r16a1=$r16a1-$polozka->pdl+$polozka->pmd; $r16a2=$r16a2-$polozka->zdl+$polozka->zmd;  }
$i=$i+1;                   }

$r17a1=0; $r17a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 313 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 316 OR LEFT(uce,3) = 314 OR LEFT(uce,3) = 051 OR ".
"   LEFT(uce,3) = 052 OR LEFT(uce,3) = 053 OR LEFT(uce,3) = 374 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r17a1=$r17a1-$polozka->pdl+$polozka->pmd; $r17a2=$r17a2-$polozka->zdl+$polozka->zmd;  }
$i=$i+1;                   }

$r18a1=0; $r18a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,2) = 41 OR LEFT(uce,2) = 42 OR LEFT(uce,2) = 43 OR LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r18a1=$r18a1+$polozka->pdl-$polozka->pmd; $r18a2=$r18a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }

$r20a1=0; $r20a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 322 OR LEFT(uce,3) = 473 OR LEFT(uce,3) = 478 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r20a1=$r20a1+$polozka->pdl-$polozka->pmd; $r20a2=$r20a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }

$r21a1=0; $r21a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 231 OR LEFT(uce,3) = 232 OR LEFT(uce,3) = 461 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r21a1=$r21a1+$polozka->pdl-$polozka->pmd; $r21a2=$r21a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }

$r22a1=0; $r22a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 241 OR LEFT(uce,3) = 249 OR LEFT(uce,3) = 361 OR LEFT(uce,3) = 365 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r22a1=$r22a1+$polozka->pdl-$polozka->pmd; $r22a2=$r22a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }

$r24a1=0; $r24a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 316 OR LEFT(uce,3) = 321 OR LEFT(uce,3) = 324 OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 326 OR LEFT(uce,3) = 331 OR LEFT(uce,3) = 475 OR ".
"   LEFT(uce,3) = 333 OR LEFT(uce,3) = 366 OR LEFT(uce,3) = 379 OR LEFT(uce,3) = 341 OR LEFT(uce,3) = 342 OR LEFT(uce,3) = 343 OR LEFT(uce,3) = 479 OR ".
"   LEFT(uce,3) = 345 OR LEFT(uce,3) = 346 OR LEFT(uce,3) = 347 OR LEFT(uce,3) = 336 OR LEFT(uce,3) = 367 OR LEFT(uce,3) = 368 OR LEFT(uce,3) = 379  )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r24a1=$r24a1+$polozka->pdl-$polozka->pmd; $r24a2=$r24a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }

$r25a1=0; $r25a2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( LEFT(uce,3) = 316 OR LEFT(uce,3) = 321 OR LEFT(uce,3) = 324 OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 475 OR LEFT(uce,3) = 479 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r25a1=$r25a1+$polozka->pdl-$polozka->pmd; $r25a2=$r25a2+$polozka->zdl-$polozka->zmd;  }
$i=$i+1;                   }



$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".

" mod146r25a1='$r25a1',  mod146r25a2='$r25a2', ".
" mod146r24a1='$r24a1',  mod146r24a2='$r24a2', ".
" mod146r22a1='$r22a1',  mod146r22a2='$r22a2', ".
" mod146r21a1='$r21a1',  mod146r21a2='$r21a2', ".
" mod146r20a1='$r20a1',  mod146r20a2='$r20a2', ".
" mod146r18a1='$r18a1',  mod146r18a2='$r18a2', ".
" mod146r17a1='$r17a1',  mod146r17a2='$r17a2', ".
" mod146r16a1='$r16a1',  mod146r16a2='$r16a2', ".
" mod146r14a1='$r14a1',  mod146r14a2='$r14a2', ".
" mod146r13a1='$r13a1',  mod146r13a2='$r13a2', ".
" mod146r11a1='$r11a1',  mod146r11a2='$r11a2'  ".
" WHERE ico >= 0";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

if( $stvrtrok == 2 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET ".
" F$kli_vxcf"."_statistika_p304.mod146r11a1=F$kli_vxcf"."_statistika_p304archx.mod146r11a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r12a1=F$kli_vxcf"."_statistika_p304archx.mod146r12a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r13a1=F$kli_vxcf"."_statistika_p304archx.mod146r13a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r14a1=F$kli_vxcf"."_statistika_p304archx.mod146r14a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r15a1=F$kli_vxcf"."_statistika_p304archx.mod146r15a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r16a1=F$kli_vxcf"."_statistika_p304archx.mod146r16a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r17a1=F$kli_vxcf"."_statistika_p304archx.mod146r17a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r18a1=F$kli_vxcf"."_statistika_p304archx.mod146r18a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r19a1=F$kli_vxcf"."_statistika_p304archx.mod146r19a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r20a1=F$kli_vxcf"."_statistika_p304archx.mod146r20a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r21a1=F$kli_vxcf"."_statistika_p304archx.mod146r21a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r22a1=F$kli_vxcf"."_statistika_p304archx.mod146r22a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r23a1=F$kli_vxcf"."_statistika_p304archx.mod146r23a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r24a1=F$kli_vxcf"."_statistika_p304archx.mod146r24a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r25a1=F$kli_vxcf"."_statistika_p304archx.mod146r25a2, ".

" F$kli_vxcf"."_statistika_p304.mod545r01a1=F$kli_vxcf"."_statistika_p304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r02a1=F$kli_vxcf"."_statistika_p304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r03a1=F$kli_vxcf"."_statistika_p304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r04a1=F$kli_vxcf"."_statistika_p304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r05a1=F$kli_vxcf"."_statistika_p304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r06a1=F$kli_vxcf"."_statistika_p304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r07a1=F$kli_vxcf"."_statistika_p304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r08a1=F$kli_vxcf"."_statistika_p304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r09a1=F$kli_vxcf"."_statistika_p304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r10a1=F$kli_vxcf"."_statistika_p304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r11a1=F$kli_vxcf"."_statistika_p304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 3 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET ".
" F$kli_vxcf"."_statistika_p304.mod146r11a1=F$kli_vxcf"."_statistika_p304archx.mod146r11a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r12a1=F$kli_vxcf"."_statistika_p304archx.mod146r12a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r13a1=F$kli_vxcf"."_statistika_p304archx.mod146r13a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r14a1=F$kli_vxcf"."_statistika_p304archx.mod146r14a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r15a1=F$kli_vxcf"."_statistika_p304archx.mod146r15a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r16a1=F$kli_vxcf"."_statistika_p304archx.mod146r16a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r17a1=F$kli_vxcf"."_statistika_p304archx.mod146r17a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r18a1=F$kli_vxcf"."_statistika_p304archx.mod146r18a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r19a1=F$kli_vxcf"."_statistika_p304archx.mod146r19a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r20a1=F$kli_vxcf"."_statistika_p304archx.mod146r20a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r21a1=F$kli_vxcf"."_statistika_p304archx.mod146r21a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r22a1=F$kli_vxcf"."_statistika_p304archx.mod146r22a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r23a1=F$kli_vxcf"."_statistika_p304archx.mod146r23a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r24a1=F$kli_vxcf"."_statistika_p304archx.mod146r24a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r25a1=F$kli_vxcf"."_statistika_p304archx.mod146r25a2, ".

" F$kli_vxcf"."_statistika_p304.mod545r01a1=F$kli_vxcf"."_statistika_p304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r02a1=F$kli_vxcf"."_statistika_p304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r03a1=F$kli_vxcf"."_statistika_p304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r04a1=F$kli_vxcf"."_statistika_p304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r05a1=F$kli_vxcf"."_statistika_p304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r06a1=F$kli_vxcf"."_statistika_p304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r07a1=F$kli_vxcf"."_statistika_p304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r08a1=F$kli_vxcf"."_statistika_p304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r09a1=F$kli_vxcf"."_statistika_p304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r10a1=F$kli_vxcf"."_statistika_p304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r11a1=F$kli_vxcf"."_statistika_p304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 2 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET ".
" F$kli_vxcf"."_statistika_p304.mod146r11a1=F$kli_vxcf"."_statistika_p304archx.mod146r11a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r12a1=F$kli_vxcf"."_statistika_p304archx.mod146r12a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r13a1=F$kli_vxcf"."_statistika_p304archx.mod146r13a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r14a1=F$kli_vxcf"."_statistika_p304archx.mod146r14a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r15a1=F$kli_vxcf"."_statistika_p304archx.mod146r15a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r16a1=F$kli_vxcf"."_statistika_p304archx.mod146r16a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r17a1=F$kli_vxcf"."_statistika_p304archx.mod146r17a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r18a1=F$kli_vxcf"."_statistika_p304archx.mod146r18a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r19a1=F$kli_vxcf"."_statistika_p304archx.mod146r19a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r20a1=F$kli_vxcf"."_statistika_p304archx.mod146r20a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r21a1=F$kli_vxcf"."_statistika_p304archx.mod146r21a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r22a1=F$kli_vxcf"."_statistika_p304archx.mod146r22a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r23a1=F$kli_vxcf"."_statistika_p304archx.mod146r23a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r24a1=F$kli_vxcf"."_statistika_p304archx.mod146r24a2, ".
" F$kli_vxcf"."_statistika_p304.mod146r25a1=F$kli_vxcf"."_statistika_p304archx.mod146r25a2, ".

" F$kli_vxcf"."_statistika_p304.mod545r01a1=F$kli_vxcf"."_statistika_p304archx.mod545r01a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r02a1=F$kli_vxcf"."_statistika_p304archx.mod545r02a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r03a1=F$kli_vxcf"."_statistika_p304archx.mod545r03a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r04a1=F$kli_vxcf"."_statistika_p304archx.mod545r04a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r05a1=F$kli_vxcf"."_statistika_p304archx.mod545r05a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r06a1=F$kli_vxcf"."_statistika_p304archx.mod545r06a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r07a1=F$kli_vxcf"."_statistika_p304archx.mod545r07a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r08a1=F$kli_vxcf"."_statistika_p304archx.mod545r08a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r09a1=F$kli_vxcf"."_statistika_p304archx.mod545r09a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r10a1=F$kli_vxcf"."_statistika_p304archx.mod545r10a2, ".
" F$kli_vxcf"."_statistika_p304.mod545r11a1=F$kli_vxcf"."_statistika_p304archx.mod545r11a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 3 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1+mod545r12a1+".
" mod146r11a1+mod146r12a1+mod146r13a1+mod146r14a1+mod146r15a1+mod146r16a1+mod146r17a1+mod146r18a1+mod146r19a1+mod146r20a1+".
" mod146r21a1+mod146r22a1+mod146r23a1+mod146r24a1+mod146r25a1, ".

" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2+mod545r12a2+".
" mod146r11a2+mod146r12a2+mod146r13a2+mod146r14a2+mod146r15a2+mod146r16a2+mod146r17a2+mod146r18a2+mod146r19a2+mod146r20a2+".
" mod146r21a2+mod146r22a2+mod146r23a2+mod146r24a2+mod146r25a2  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=4;
}
//koniec odpocitaj modul 545 z uobrat.php


//prepnute z suvaha.php modul 1545(146) odpocitaj predchadzajuce stvrtroky
if( $modul == 1545 )
{
$copern=102;
if( $stvrtrok == 2 )
     {
$stvrtrom=$stvrtrok-1;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=1";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod545r12a1=F$kli_vxcf"."_statistika_p304archx.mod545r12a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 1 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 3 )
     {
$stvrtro2=$stvrtrok-2;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=2";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod545r12a1=F$kli_vxcf"."_statistika_p304archx.mod545r12a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 2 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

if( $stvrtrok == 4 )
     {
$stvrtro3=$stvrtrok-3;
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304archx SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=3";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_p304,F$kli_vxcf"."_statistika_p304archx ".
" SET F$kli_vxcf"."_statistika_p304.mod545r12a1=F$kli_vxcf"."_statistika_p304archx.mod545r12a2 ".
" WHERE F$kli_vxcf"."_statistika_p304archx.psys = 3 ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
     }

$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304archx ";
$vysledek = mysql_query("$sql");

$strana=4;
}
//koniec odpocitaj modul 1545 z suvaha.php



//pracovny subor statistika_p304
$sql = "SELECT * FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_p304';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p304
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
statistika_p304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_p304'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_p304 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}
$sql = "SELECT mod113ano FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r99a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r13a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r12a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r11a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r10a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r09a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r08a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r07a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r06a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r05a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r04a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r03a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r02a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r01a4 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r99a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r13a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r12a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r11a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r10a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r09a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r08a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r07a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r06a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r05a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r04a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r03a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r02a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r01a3 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r99a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r13a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r12a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r11a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r10a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r09a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r08a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r07a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r06a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r05a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r04a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r03a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r02a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r01a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r99a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r13a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r12a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r11a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r10a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r09a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r08a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r07a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r06a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r05a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r04a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r03a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r02a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod112r01a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod113nie VARCHAR(1) NOT NULL AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod113ano VARCHAR(1) NOT NULL AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod545r01a1 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r99a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r11a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r10a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r09a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r08a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r07a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r06a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r05a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r04a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r03a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r02a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r01a2 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r99a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r11a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r10a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r09a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r08a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r07a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r06a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r05a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r04a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r03a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r02a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r01a1 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod2r01 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod2r02 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod2r01 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_p304 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD odoslane DATE NOT NULL AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod146r25a2 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r11a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r12a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r13a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r14a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r15a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r16a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r17a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r18a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r19a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r20a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r21a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r22a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r23a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r24a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r25a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r11a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r12a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r13a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r14a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r15a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r16a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r17a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r18a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r19a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r20a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r21a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r22a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r23a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r24a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod146r25a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r99a2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod143r01 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r99 DECIMAL(10,1) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r20 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r19 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r18 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r17 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r16 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r15 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r14 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r13 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r12 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r11 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r10 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r09 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r08 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r07 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r06 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r05 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r04 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r03 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r02 DECIMAL(10,0) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod143r01 DECIMAL(10,1) DEFAULT 0 AFTER mod82r99";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r12a2 DECIMAL(10,0) DEFAULT 0 AFTER mod545r11a2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod545r12a1 DECIMAL(10,0) DEFAULT 0 AFTER mod545r11a2";
$vysledek = mysql_query("$sql");


$sql = "SELECT mod5r01 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r99 DECIMAL(10,1) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r25 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r24 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r23 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r22 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r21 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r20 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r19 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r18 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r17 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r16 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r15 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r14 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r13 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r12 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r11 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r10 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r09 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r08 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod5r01 DECIMAL(10,1) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod1003k01 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003s01 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003naz VARCHAR(20) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1003k01 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT mod1004k09 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s09 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s08 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004s01 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004naz VARCHAR(20) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k08 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k07 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k06 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k05 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k04 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k03 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k02 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k01 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod1004k09 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
//rok 2014
$sql = "SELECT mod82r992 FROM F$kli_vxcf"."_statistika_p304 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD m100065nie VARCHAR(1) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD m100065ano VARCHAR(1) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod82r012 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod82r032 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod82r042 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304 ADD mod82r992 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
//koniec pracovny subor


//nacitanie modul 5 z miezd
if( $copern == 200 )
{
$h_mfir = $kli_vxcf;
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
   pocet        DECIMAL(10,2) DEFAULT 0,
   dm           INT(5),
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   uvax         DECIMAL(10,2) DEFAULT 0,
   uvap         DECIMAL(10,2) DEFAULT 0,
   skrat        DECIMAL(3,0) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,uva,0,0,$fir_fico".
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

/////////////NACITANIE prac.uvazku standartneho
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET uvap=uvax/$uva_hod ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET skrat=1 WHERE uvap < 0.8 ";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,SUM(uvap),0,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 998,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 993,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,0,0,skrat,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE skrat = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

//exit;

$r01=0; $r01p=0; $r01s=0; $r01k=0; $r03=0; $r08=0; $skrat=0; $r02=0; $r02p=0; $r02s=0; $r02k=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 993 AND skrat = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $skrat=$skrat+1; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ump AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01p=$r01p+$polozka->uvap; $r02p=$r02p+$polozka->pocet;}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_ums AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01s=$r01s+$polozka->uvap; $r02s=$r02s+$polozka->pocet;}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_umk AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01k=$r01k+$polozka->uvap; $r02k=$r02k+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+1; }
$i=$i+1;                   }

$r01=($r01p+$r01s+$r01k)/3;
$r02=($r02p+$r02s+$r02k)/3;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 998";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+1; }
$i=$i+1;                   }

//odpracovane hodiny a eur a odvody

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,spom,0,1, ".
"9999,0,0,(ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),0,0,0,$fir_fico".
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
"dm,SUM(dni),SUM(hod),SUM(kc),0,0,0,$fir_fico".
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
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod5r01='$r01', mod5r02='$r02', mod5r06='$r02k', mod5r07='$r03', mod5r13=mod5r06, mod5r10='$r07', mod5r11='$r08', mod5r12='$r09',".
" mod5r15='$r10', mod5r16='$r11', mod5r17='$r12', mod5r18='$r13', mod5r19='$r14', mod5r20='$r15', mod5r08='$skrat',".
" mod5r21='$r16', mod5r22='$r17', mod5r23='$r19', mod5r24='$r18', mod5r25='$r20',".
" mod5r99=mod5r01+mod5r02+mod5r06+mod5r07+mod5r08+mod5r10,".
" mod5r99=mod5r99+mod5r11+mod5r12+mod5r13+mod5r14+mod5r15+mod5r16+mod5r17+mod5r18+mod5r19+mod5r20+mod5r22+mod5r23+mod5r24+mod5r25".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET mod1004s09=mod5r02 WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
//$vytvor = mysql_query("$vsql");

$copern=102;
$strana=7;
}
//koniec nacitanie modul 5 z miezd


// zapis upravene udaje
if ( $copern == 103 )
     {
$cinnost = strip_tags($_REQUEST['cinnost']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);

$m100065ano = strip_tags($_REQUEST['m100065ano']);
$m100065nie = strip_tags($_REQUEST['m100065nie']);

$mod82r01 = strip_tags($_REQUEST['mod82r01']);
$mod82r02 = strip_tags($_REQUEST['mod82r02']);
$mod82r03 = strip_tags($_REQUEST['mod82r03']);
$mod82r04 = strip_tags($_REQUEST['mod82r04']);
$mod82r05 = strip_tags($_REQUEST['mod82r05']);
$mod82r99 = strip_tags($_REQUEST['mod82r99']);
$mod82r012 = strip_tags($_REQUEST['mod82r012']);
$mod82r032 = strip_tags($_REQUEST['mod82r032']);
$mod82r042 = strip_tags($_REQUEST['mod82r042']);
$mod82r992 = strip_tags($_REQUEST['mod82r992']);

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
$mod112r01a2 = strip_tags($_REQUEST['mod112r01a2']);
$mod112r02a2 = strip_tags($_REQUEST['mod112r02a2']);
$mod112r03a2 = strip_tags($_REQUEST['mod112r03a2']);
$mod112r04a2 = strip_tags($_REQUEST['mod112r04a2']);
$mod112r05a2 = strip_tags($_REQUEST['mod112r05a2']);
$mod112r06a2 = strip_tags($_REQUEST['mod112r06a2']);
$mod112r07a2 = strip_tags($_REQUEST['mod112r07a2']);
$mod112r08a2 = strip_tags($_REQUEST['mod112r08a2']);
$mod112r09a2 = strip_tags($_REQUEST['mod112r09a2']);
//$mod112r10a2 = strip_tags($_REQUEST['mod112r10a2']);
//$mod112r11a2 = strip_tags($_REQUEST['mod112r11a2']);
$mod112r12a2 = strip_tags($_REQUEST['mod112r12a2']);
$mod112r13a2 = strip_tags($_REQUEST['mod112r13a2']);
$mod112r99a2 = strip_tags($_REQUEST['mod112r99a2']);
$mod112r01a3 = strip_tags($_REQUEST['mod112r01a3']);
$mod112r02a3 = strip_tags($_REQUEST['mod112r02a3']);
$mod112r03a3 = strip_tags($_REQUEST['mod112r03a3']);
$mod112r04a3 = strip_tags($_REQUEST['mod112r04a3']);
$mod112r05a3 = strip_tags($_REQUEST['mod112r05a3']);
$mod112r06a3 = strip_tags($_REQUEST['mod112r06a3']);
$mod112r07a3 = strip_tags($_REQUEST['mod112r07a3']);
$mod112r08a3 = strip_tags($_REQUEST['mod112r08a3']);
$mod112r09a3 = strip_tags($_REQUEST['mod112r09a3']);
$mod112r10a3 = strip_tags($_REQUEST['mod112r10a3']);
$mod112r11a3 = strip_tags($_REQUEST['mod112r11a3']);
$mod112r12a3 = strip_tags($_REQUEST['mod112r12a3']);
$mod112r13a3 = strip_tags($_REQUEST['mod112r13a3']);
$mod112r99a3 = strip_tags($_REQUEST['mod112r99a3']);
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
//$mod112r13a4 = strip_tags($_REQUEST['mod112r13a4']);
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
$mod146r11a1 = strip_tags($_REQUEST['mod146r11a1']);
$mod146r12a1 = strip_tags($_REQUEST['mod146r12a1']);
$mod146r13a1 = strip_tags($_REQUEST['mod146r13a1']);
$mod146r14a1 = strip_tags($_REQUEST['mod146r14a1']);
$mod146r15a1 = strip_tags($_REQUEST['mod146r15a1']);
$mod146r16a1 = strip_tags($_REQUEST['mod146r16a1']);
$mod146r17a1 = strip_tags($_REQUEST['mod146r17a1']);
$mod146r18a1 = strip_tags($_REQUEST['mod146r18a1']);
$mod146r19a1 = strip_tags($_REQUEST['mod146r19a1']);
$mod146r20a1 = strip_tags($_REQUEST['mod146r20a1']);
$mod146r21a1 = strip_tags($_REQUEST['mod146r21a1']);
$mod146r22a1 = strip_tags($_REQUEST['mod146r22a1']);
$mod146r23a1 = strip_tags($_REQUEST['mod146r23a1']);
$mod146r24a1 = strip_tags($_REQUEST['mod146r24a1']);
$mod146r25a1 = strip_tags($_REQUEST['mod146r25a1']);
$mod545r11a1 = strip_tags($_REQUEST['mod545r11a1']);
$mod545r12a1 = strip_tags($_REQUEST['mod545r12a1']);
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
$mod146r11a2 = strip_tags($_REQUEST['mod146r11a2']);
$mod146r12a2 = strip_tags($_REQUEST['mod146r12a2']);
$mod146r13a2 = strip_tags($_REQUEST['mod146r13a2']);
$mod146r14a2 = strip_tags($_REQUEST['mod146r14a2']);
$mod146r15a2 = strip_tags($_REQUEST['mod146r15a2']);
$mod146r16a2 = strip_tags($_REQUEST['mod146r16a2']);
$mod146r17a2 = strip_tags($_REQUEST['mod146r17a2']);
$mod146r18a2 = strip_tags($_REQUEST['mod146r18a2']);
$mod146r19a2 = strip_tags($_REQUEST['mod146r19a2']);
$mod146r20a2 = strip_tags($_REQUEST['mod146r20a2']);
$mod146r21a2 = strip_tags($_REQUEST['mod146r21a2']);
$mod146r22a2 = strip_tags($_REQUEST['mod146r22a2']);
$mod146r23a2 = strip_tags($_REQUEST['mod146r23a2']);
$mod146r24a2 = strip_tags($_REQUEST['mod146r24a2']);
$mod146r25a2 = strip_tags($_REQUEST['mod146r25a2']);
$mod545r11a2 = strip_tags($_REQUEST['mod545r11a2']);
$mod545r12a2 = strip_tags($_REQUEST['mod545r12a2']);
$mod545r99a2 = strip_tags($_REQUEST['mod545r99a2']);

//$mod1003naz = strip_tags($_REQUEST['mod1003naz']);
//$mod1003s01 = strip_tags($_REQUEST['mod1003s01']);
$mod1003s02 = strip_tags($_REQUEST['mod1003s02']);
$mod1003s03 = strip_tags($_REQUEST['mod1003s03']);
$mod1003s04 = strip_tags($_REQUEST['mod1003s04']);
$mod1003s05 = strip_tags($_REQUEST['mod1003s05']);
$mod1003s06 = strip_tags($_REQUEST['mod1003s06']);
$mod1003s07 = strip_tags($_REQUEST['mod1003s07']);
//$mod1003s08 = strip_tags($_REQUEST['mod1003s08']);
//$mod1003s09 = strip_tags($_REQUEST['mod1003s09']);

//$mod1004naz = strip_tags($_REQUEST['mod1004naz']);
//$mod1004s01 = strip_tags($_REQUEST['mod1004s01']);
$mod1004s02 = strip_tags($_REQUEST['mod1004s02']);
$mod1004s03 = strip_tags($_REQUEST['mod1004s03']);
$mod1004s04 = strip_tags($_REQUEST['mod1004s04']);
$mod1004s05 = strip_tags($_REQUEST['mod1004s05']);
$mod1004s06 = strip_tags($_REQUEST['mod1004s06']);
$mod1004s07 = strip_tags($_REQUEST['mod1004s07']);
$mod1004s08 = strip_tags($_REQUEST['mod1004s08']);
$mod1004s09 = strip_tags($_REQUEST['mod1004s09']);

$mod5r01 = strip_tags($_REQUEST['mod5r01']);
$mod5r02 = strip_tags($_REQUEST['mod5r02']);
$mod5r03 = strip_tags($_REQUEST['mod5r03']);
$mod5r04 = strip_tags($_REQUEST['mod5r04']);
$mod5r05 = strip_tags($_REQUEST['mod5r05']);
$mod5r06 = strip_tags($_REQUEST['mod5r06']);
$mod5r07 = strip_tags($_REQUEST['mod5r07']);
$mod5r08 = strip_tags($_REQUEST['mod5r08']);
//$mod5r09 = strip_tags($_REQUEST['mod5r09']);
$mod5r10 = strip_tags($_REQUEST['mod5r10']);
$mod5r11 = strip_tags($_REQUEST['mod5r11']);
$mod5r12 = strip_tags($_REQUEST['mod5r12']);
$mod5r13 = strip_tags($_REQUEST['mod5r13']);
$mod5r14 = strip_tags($_REQUEST['mod5r14']);
$mod5r15 = strip_tags($_REQUEST['mod5r15']);
$mod5r16 = strip_tags($_REQUEST['mod5r16']);
$mod5r17 = strip_tags($_REQUEST['mod5r17']);
$mod5r18 = strip_tags($_REQUEST['mod5r18']);
$mod5r19 = strip_tags($_REQUEST['mod5r19']);
$mod5r20 = strip_tags($_REQUEST['mod5r20']);
//$mod5r21 = strip_tags($_REQUEST['mod5r21']);
$mod5r22 = strip_tags($_REQUEST['mod5r22']);
$mod5r23 = strip_tags($_REQUEST['mod5r23']);
$mod5r24 = strip_tags($_REQUEST['mod5r24']);
$mod5r25 = strip_tags($_REQUEST['mod5r25']);
$mod5r99 = strip_tags($_REQUEST['mod5r99']);

if ( $strana == 1 ) {
$copern=102;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" odoslane='$odoslane_sql' ".
" WHERE ico >= 0";
                    }

if ( $strana == 2 ) {
$copern=102;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" cinnost='$cinnost', mod2r01='$mod2r01', mod2r02='$mod2r02', ".
" m100065ano='$m100065ano', m100065nie='$m100065nie', ".
" mod82r01='$mod82r01', mod82r02='$mod82r02', mod82r03='$mod82r03', mod82r04='$mod82r04', mod82r05='$mod82r05', ".
" mod82r99=mod82r01+mod82r02+mod82r03+mod82r04+mod82r05, ".
" mod82r012='$mod82r012', mod82r032='$mod82r032', mod82r042='$mod82r042', ".
" mod82r992=mod82r012+mod82r032+mod82r042, ".
" mod113ano='$mod113ano', mod113nie='$mod113nie' ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {
$copern=102;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod112r01a1='$mod112r01a1', mod112r02a1='$mod112r02a1', mod112r03a1='$mod112r03a1', ".
" mod112r04a1='$mod112r04a1', mod112r05a1='$mod112r05a1', mod112r06a1='$mod112r06a1', ".
" mod112r07a1='$mod112r07a1', mod112r08a1='$mod112r08a1', mod112r09a1='$mod112r09a1', ".
" mod112r10a1='$mod112r10a1', mod112r11a1='$mod112r11a1', mod112r12a1='$mod112r12a1', mod112r13a1='$mod112r13a1', ".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r04a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r08a1+mod112r09a1+mod112r10a1+mod112r11a1+mod112r12a1+mod112r13a1, ".
" mod112r01a2='$mod112r01a2', mod112r02a2='$mod112r02a2', mod112r03a2='$mod112r03a2', ".
" mod112r04a2='$mod112r04a2', mod112r05a2='$mod112r05a2', mod112r06a2='$mod112r06a2', ".
" mod112r07a2='$mod112r07a2', mod112r08a2='$mod112r08a2', mod112r09a2='$mod112r09a2', ".
" mod112r12a2='$mod112r12a2', mod112r13a2='$mod112r13a2', ".
" mod112r99a2=mod112r01a2+mod112r02a2+mod112r03a2+mod112r04a2+mod112r05a2+mod112r06a2+mod112r07a2+mod112r08a2+mod112r09a2+mod112r12a2+mod112r13a2,".
" mod112r01a3='$mod112r01a3', mod112r02a3='$mod112r02a3', mod112r03a3='$mod112r03a3', ".
" mod112r04a3='$mod112r04a3', mod112r05a3='$mod112r05a3', mod112r06a3='$mod112r06a3', ".
" mod112r07a3='$mod112r07a3', mod112r08a3='$mod112r08a3', mod112r09a3='$mod112r09a3', ".
" mod112r10a3='$mod112r10a3', mod112r11a3='$mod112r11a3', mod112r12a3='$mod112r12a3', mod112r13a3='$mod112r13a3', ".
" mod112r99a3=mod112r01a3+mod112r02a3+mod112r03a3+mod112r04a3+mod112r05a3+mod112r06a3+mod112r07a3+mod112r08a3+mod112r09a3+mod112r10a3+mod112r11a3+mod112r12a3+mod112r13a3, ".
" mod112r01a4='$mod112r01a4', mod112r02a4='$mod112r02a4', mod112r03a4='$mod112r03a4', ".
" mod112r04a4='$mod112r04a4', mod112r05a4='$mod112r05a4', mod112r06a4='$mod112r06a4', ".
" mod112r07a4='$mod112r07a4', mod112r08a4='$mod112r08a4', mod112r09a4='$mod112r09a4', ".
" mod112r10a4='$mod112r10a4', mod112r11a4='$mod112r11a4', mod112r12a4='$mod112r12a4', ".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r04a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r08a4+mod112r09a4+mod112r10a4+mod112r11a4+mod112r12a4 ".
" WHERE ico >= 0";
                    }

if ( $strana == 4 ) {
$copern=102;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod545r01a1='$mod545r01a1', mod545r02a1='$mod545r02a1', mod545r03a1='$mod545r03a1', ".
" mod545r04a1='$mod545r04a1', mod545r05a1='$mod545r05a1', mod545r06a1='$mod545r06a1', ".
" mod545r07a1='$mod545r07a1', mod545r08a1='$mod545r08a1', mod545r09a1='$mod545r09a1', ".
" mod545r10a1='$mod545r10a1', mod545r11a1='$mod545r11a1', mod545r12a1='$mod545r12a1', ".
" mod146r11a1='$mod146r11a1', mod146r12a1='$mod146r12a1', mod146r13a1='$mod146r13a1', ".
" mod146r14a1='$mod146r14a1', mod146r15a1='$mod146r15a1', mod146r16a1='$mod146r16a1', ".
" mod146r17a1='$mod146r17a1', mod146r18a1='$mod146r18a1', mod146r19a1='$mod146r19a1', ".
" mod146r20a1='$mod146r20a1', mod146r21a1='$mod146r21a1', mod146r22a1='$mod146r22a1', ".
" mod146r23a1='$mod146r23a1', mod146r24a1='$mod146r24a1', mod146r25a1='$mod146r25a1', ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1+mod545r12a1+".
" mod146r11a1+mod146r12a1+mod146r13a1+mod146r14a1+mod146r15a1+mod146r16a1+mod146r17a1+mod146r18a1+mod146r19a1+mod146r20a1+".
" mod146r21a1+mod146r22a1+mod146r23a1+mod146r24a1+mod146r25a1, ".
" mod545r01a2='$mod545r01a2', mod545r02a2='$mod545r02a2', mod545r03a2='$mod545r03a2', ".
" mod545r04a2='$mod545r04a2', mod545r05a2='$mod545r05a2', mod545r06a2='$mod545r06a2', ".
" mod545r07a2='$mod545r07a2', mod545r08a2='$mod545r08a2', mod545r09a2='$mod545r09a2', ".
" mod545r10a2='$mod545r10a2', mod545r11a2='$mod545r11a2', mod545r12a2='$mod545r12a2', ".
" mod146r11a2='$mod146r11a2', mod146r12a2='$mod146r12a2', mod146r13a2='$mod146r13a2', ".
" mod146r14a2='$mod146r14a2', mod146r15a2='$mod146r15a2', mod146r16a2='$mod146r16a2', ".
" mod146r17a2='$mod146r17a2', mod146r18a2='$mod146r18a2', mod146r19a2='$mod146r19a2', ".
" mod146r20a2='$mod146r20a2', mod146r21a2='$mod146r21a2', mod146r22a2='$mod146r22a2', ".
" mod146r23a2='$mod146r23a2', mod146r24a2='$mod146r24a2', mod146r25a2='$mod146r25a2', ".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2+mod545r12a2+".
" mod146r11a2+mod146r12a2+mod146r13a2+mod146r14a2+mod146r15a2+mod146r16a2+mod146r17a2+mod146r18a2+mod146r19a2+mod146r20a2+".
" mod146r21a2+mod146r22a2+mod146r23a2+mod146r24a2+mod146r25a2 ".
" WHERE ico >= 0";
                    }

if ( $strana == 5 ) {
$copern=402;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod1003s02='$mod1003s02', mod1003s03='$mod1003s03', mod1003s04='$mod1003s04', ".
" mod1003s05='$mod1003s05', mod1003s06='$mod1003s06', mod1003s07='$mod1003s07' ".
" WHERE ico >= 0";
                    }

if ( $strana == 6 ) {
$copern=402;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod1004s02='$mod1004s02', mod1004s03='$mod1004s03', mod1004s04='$mod1004s04', ".
" mod1004s05='$mod1004s05', mod1004s06='$mod1004s06', mod1004s07='$mod1004s07', ".
" mod1004s08='$mod1004s08', mod1004s09='$mod1004s09' ".
" WHERE ico >= 0";
                    }

if ( $strana == 7 ) {
$copern=102;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod5r01='$mod5r01', mod5r02='$mod5r02', mod5r03='$mod5r03', mod5r04='$mod5r04', ".
" mod5r05='$mod5r05', mod5r06='$mod5r06', mod5r07='$mod5r07', mod5r08='$mod5r08', ".
" mod5r10='$mod5r10', mod5r25='$mod5r25', mod5r11='$mod5r11', ".
" mod5r12='$mod5r12', mod5r13='$mod5r13', mod5r14='$mod5r14', mod5r15='$mod5r15', ".
" mod5r23='$mod5r23', mod5r24='$mod5r24', mod5r16='$mod5r16', mod5r17='$mod5r17', ".
" mod5r18='$mod5r18', mod5r19='$mod5r19', mod5r20='$mod5r20', mod5r22='$mod5r22', ".
" mod5r23='$mod5r23', mod5r24='$mod5r24', mod5r25='$mod5r25', ".
" mod5r99=mod5r01+mod5r02+mod5r03+mod5r04+mod5r05+mod5r06+mod5r07+mod5r08+mod5r10+mod5r11, ".
" mod5r99=mod5r99+mod5r12+mod5r13+mod5r14+mod5r15+mod5r16+mod5r17+mod5r18+mod5r19+mod5r20+mod5r22+mod5r23+mod5r24+mod5r25 ".
" WHERE ico >= 0";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//nacitaj udaje
if ( $copern >= 1 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_p304 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$odoslane_sk = SkDatum($fir_riadok->odoslane);
$cinnost = $fir_riadok->cinnost;
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;

$m100065ano = $fir_riadok->m100065ano;
$m100065nie = $fir_riadok->m100065nie;

$mod82r01 = $fir_riadok->mod82r01;
$mod82r02 = $fir_riadok->mod82r02;
$mod82r03 = $fir_riadok->mod82r03;
$mod82r04 = $fir_riadok->mod82r04;
$mod82r05 = $fir_riadok->mod82r05;
$mod82r99 = $fir_riadok->mod82r99;
$mod82r012 = $fir_riadok->mod82r012;
$mod82r032 = $fir_riadok->mod82r032;
$mod82r042 = $fir_riadok->mod82r042;
$mod82r992 = $fir_riadok->mod82r992;

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
$mod112r01a2 = $fir_riadok->mod112r01a2;
$mod112r02a2 = $fir_riadok->mod112r02a2;
$mod112r03a2 = $fir_riadok->mod112r03a2;
$mod112r04a2 = $fir_riadok->mod112r04a2;
$mod112r05a2 = $fir_riadok->mod112r05a2;
$mod112r06a2 = $fir_riadok->mod112r06a2;
$mod112r07a2 = $fir_riadok->mod112r07a2;
$mod112r08a2 = $fir_riadok->mod112r08a2;
$mod112r09a2 = $fir_riadok->mod112r09a2;
$mod112r12a2 = $fir_riadok->mod112r12a2;
$mod112r13a2 = $fir_riadok->mod112r13a2;
$mod112r99a2 = $fir_riadok->mod112r99a2;
$mod112r01a3 = $fir_riadok->mod112r01a3;
$mod112r02a3 = $fir_riadok->mod112r02a3;
$mod112r03a3 = $fir_riadok->mod112r03a3;
$mod112r04a3 = $fir_riadok->mod112r04a3;
$mod112r05a3 = $fir_riadok->mod112r05a3;
$mod112r06a3 = $fir_riadok->mod112r06a3;
$mod112r07a3 = $fir_riadok->mod112r07a3;
$mod112r08a3 = $fir_riadok->mod112r08a3;
$mod112r09a3 = $fir_riadok->mod112r09a3;
$mod112r10a3 = $fir_riadok->mod112r10a3;
$mod112r11a3 = $fir_riadok->mod112r11a3;
$mod112r12a3 = $fir_riadok->mod112r12a3;
$mod112r13a3 = $fir_riadok->mod112r13a3;
$mod112r99a3 = $fir_riadok->mod112r99a3;
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
$mod146r11a1 = $fir_riadok->mod146r11a1;
$mod146r12a1 = $fir_riadok->mod146r12a1;
$mod146r13a1 = $fir_riadok->mod146r13a1;
$mod146r14a1 = $fir_riadok->mod146r14a1;
$mod146r15a1 = $fir_riadok->mod146r15a1;
$mod146r16a1 = $fir_riadok->mod146r16a1;
$mod146r17a1 = $fir_riadok->mod146r17a1;
$mod146r18a1 = $fir_riadok->mod146r18a1;
$mod146r19a1 = $fir_riadok->mod146r19a1;
$mod146r20a1 = $fir_riadok->mod146r20a1;
$mod146r21a1 = $fir_riadok->mod146r21a1;
$mod146r22a1 = $fir_riadok->mod146r22a1;
$mod146r23a1 = $fir_riadok->mod146r23a1;
$mod146r24a1 = $fir_riadok->mod146r24a1;
$mod146r25a1 = $fir_riadok->mod146r25a1;
$mod545r11a1 = $fir_riadok->mod545r11a1;
$mod545r12a1 = $fir_riadok->mod545r12a1;
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
$mod146r11a2 = $fir_riadok->mod146r11a2;
$mod146r12a2 = $fir_riadok->mod146r12a2;
$mod146r13a2 = $fir_riadok->mod146r13a2;
$mod146r14a2 = $fir_riadok->mod146r14a2;
$mod146r15a2 = $fir_riadok->mod146r15a2;
$mod146r16a2 = $fir_riadok->mod146r16a2;
$mod146r17a2 = $fir_riadok->mod146r17a2;
$mod146r18a2 = $fir_riadok->mod146r18a2;
$mod146r19a2 = $fir_riadok->mod146r19a2;
$mod146r20a2 = $fir_riadok->mod146r20a2;
$mod146r21a2 = $fir_riadok->mod146r21a2;
$mod146r22a2 = $fir_riadok->mod146r22a2;
$mod146r23a2 = $fir_riadok->mod146r23a2;
$mod146r24a2 = $fir_riadok->mod146r24a2;
$mod146r25a2 = $fir_riadok->mod146r25a2;
$mod545r11a2 = $fir_riadok->mod545r11a2;
$mod545r12a2 = $fir_riadok->mod545r12a2;
$mod545r99a2 = $fir_riadok->mod545r99a2;

//$mod1003naz = $fir_riadok->mod1003naz;
//$mod1003s01 = $fir_riadok->mod1003s01;
$mod1003s02 = $fir_riadok->mod1003s02;
$mod1003s03 = $fir_riadok->mod1003s03;
$mod1003s04 = $fir_riadok->mod1003s04;
$mod1003s05 = $fir_riadok->mod1003s05;
$mod1003s06 = $fir_riadok->mod1003s06;
$mod1003s07 = $fir_riadok->mod1003s07;

//$mod1004naz = $fir_riadok->mod1004naz;
//$mod1004s01 = $fir_riadok->mod1004s01;
$mod1004s02 = $fir_riadok->mod1004s02;
$mod1004s03 = $fir_riadok->mod1004s03;
$mod1004s04 = $fir_riadok->mod1004s04;
$mod1004s05 = $fir_riadok->mod1004s05;
$mod1004s06 = $fir_riadok->mod1004s06;
$mod1004s07 = $fir_riadok->mod1004s07;
$mod1004s08 = $fir_riadok->mod1004s08;
$mod1004s09 = $fir_riadok->mod1004s09;

$mod5r01 = $fir_riadok->mod5r01;
$mod5r02 = $fir_riadok->mod5r02;
$mod5r03 = $fir_riadok->mod5r03;
$mod5r04 = $fir_riadok->mod5r04;
$mod5r05 = $fir_riadok->mod5r05;
$mod5r06 = $fir_riadok->mod5r06;
$mod5r07 = $fir_riadok->mod5r07;
$mod5r08 = $fir_riadok->mod5r08;
$mod5r10 = $fir_riadok->mod5r10;
$mod5r11 = $fir_riadok->mod5r11;
$mod5r12 = $fir_riadok->mod5r12;
$mod5r13 = $fir_riadok->mod5r13;
$mod5r14 = $fir_riadok->mod5r14;
$mod5r15 = $fir_riadok->mod5r15;
$mod5r16 = $fir_riadok->mod5r16;
$mod5r17 = $fir_riadok->mod5r17;
$mod5r18 = $fir_riadok->mod5r18;
$mod5r19 = $fir_riadok->mod5r19;
$mod5r20 = $fir_riadok->mod5r20;
$mod5r22 = $fir_riadok->mod5r22;
$mod5r23 = $fir_riadok->mod5r23;
$mod5r24 = $fir_riadok->mod5r24;
$mod5r25 = $fir_riadok->mod5r25;
$mod5r99 = $fir_riadok->mod5r99;
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

//cislo riadku v m1003 a m1004
$cslr1="1.";
if ( $mod1003s02 == 0 AND $mod1003s03 == 0 AND $mod1003s04 == 0 AND
     $mod1003s05 == 0 AND $mod1003s06 == 0 AND $mod1003s07 == 0
   ) { $cslr1=""; }
$cslr2="1.";
if ( $mod1004s02 == 0 AND $mod1004s03 == 0 AND $mod1004s04 == 0 AND
     $mod1004s05 == 0 AND $mod1004s06 == 0 AND $mod1004s06 == 0 AND
     $mod1004s07 == 0 AND $mod1004s08 == 0 AND $mod1004s09 == 0
   ) { $cslr2=""; }

//sknace bez bodiek
$sknace=str_replace(".", "", $fir_sknace);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v˝kaz Prod 3-04</title>
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

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 102 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk"; ?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.cinnost.value = '<?php echo "$cinnost"; ?>';
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php if ( $m100065ano == 1 ) { echo "document.formv1.m100065ano.checked='checked';"; } ?>
<?php if ( $m100065nie == 1 ) { echo "document.formv1.m100065nie.checked='checked';"; } ?>

   document.formv1.mod82r01.value = '<?php echo "$mod82r01";?>';
   document.formv1.mod82r02.value = '<?php echo "$mod82r02";?>';
   document.formv1.mod82r03.value = '<?php echo "$mod82r03";?>';
   document.formv1.mod82r04.value = '<?php echo "$mod82r04";?>';
   document.formv1.mod82r05.value = '<?php echo "$mod82r05";?>';
 //document.formv1.mod82r99.value = '<?php echo "$mod82r99";?>';
   document.formv1.mod82r012.value = '<?php echo "$mod82r012";?>';
   document.formv1.mod82r032.value = '<?php echo "$mod82r032";?>';
   document.formv1.mod82r042.value = '<?php echo "$mod82r042";?>';
 //document.formv1.mod82r992.value = '<?php echo "$mod82r992";?>';

<?php if ( $mod113ano == 1 ) { echo "document.formv1.mod113ano.checked='checked';"; } ?>
<?php if ( $mod113nie == 1 ) { echo "document.formv1.mod113nie.checked='checked';"; } ?>
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.mod112r01a1.value = '<?php echo "$mod112r01a1";?>';
   document.formv1.mod112r02a1.value = '<?php echo "$mod112r02a1";?>';
   document.formv1.mod112r03a1.value = '<?php echo "$mod112r03a1";?>';
   document.formv1.mod112r04a1.value = '<?php echo "$mod112r04a1";?>';
   document.formv1.mod112r05a1.value = '<?php echo "$mod112r05a1";?>';
   document.formv1.mod112r06a1.value = '<?php echo "$mod112r06a1";?>';
   document.formv1.mod112r07a1.value = '<?php echo "$mod112r07a1";?>';
   document.formv1.mod112r08a1.value = '<?php echo "$mod112r08a1";?>';
   document.formv1.mod112r09a1.value = '<?php echo "$mod112r09a1";?>';
   document.formv1.mod112r10a1.value = '<?php echo "$mod112r10a1";?>';
   document.formv1.mod112r11a1.value = '<?php echo "$mod112r11a1";?>';
   document.formv1.mod112r12a1.value = '<?php echo "$mod112r12a1";?>';
   document.formv1.mod112r13a1.value = '<?php echo "$mod112r13a1";?>';
 //document.formv1.mod112r99a1.value = '<?php echo "$mod112r99a1";?>';
   document.formv1.mod112r01a2.value = '<?php echo "$mod112r01a2";?>';
   document.formv1.mod112r02a2.value = '<?php echo "$mod112r02a2";?>';
   document.formv1.mod112r03a2.value = '<?php echo "$mod112r03a2";?>';
   document.formv1.mod112r04a2.value = '<?php echo "$mod112r04a2";?>';
   document.formv1.mod112r05a2.value = '<?php echo "$mod112r05a2";?>';
   document.formv1.mod112r06a2.value = '<?php echo "$mod112r06a2";?>';
   document.formv1.mod112r07a2.value = '<?php echo "$mod112r07a2";?>';
   document.formv1.mod112r08a2.value = '<?php echo "$mod112r08a2";?>';
   document.formv1.mod112r09a2.value = '<?php echo "$mod112r09a2";?>';
   document.formv1.mod112r12a2.value = '<?php echo "$mod112r12a2";?>';
   document.formv1.mod112r13a2.value = '<?php echo "$mod112r13a2";?>';
 //document.formv1.mod112r99a2.value = '<?php echo "$mod112r99a2";?>';
   document.formv1.mod112r01a3.value = '<?php echo "$mod112r01a3";?>';
   document.formv1.mod112r02a3.value = '<?php echo "$mod112r02a3";?>';
   document.formv1.mod112r03a3.value = '<?php echo "$mod112r03a3";?>';
   document.formv1.mod112r04a3.value = '<?php echo "$mod112r04a3";?>';
   document.formv1.mod112r05a3.value = '<?php echo "$mod112r05a3";?>';
   document.formv1.mod112r06a3.value = '<?php echo "$mod112r06a3";?>';
   document.formv1.mod112r07a3.value = '<?php echo "$mod112r07a3";?>';
   document.formv1.mod112r08a3.value = '<?php echo "$mod112r08a3";?>';
   document.formv1.mod112r09a3.value = '<?php echo "$mod112r09a3";?>';
   document.formv1.mod112r10a3.value = '<?php echo "$mod112r10a3";?>';
   document.formv1.mod112r11a3.value = '<?php echo "$mod112r11a3";?>';
   document.formv1.mod112r12a3.value = '<?php echo "$mod112r12a3";?>';
   document.formv1.mod112r13a3.value = '<?php echo "$mod112r13a3";?>';
 //document.formv1.mod112r99a3.value = '<?php echo "$mod112r99a3";?>';
   document.formv1.mod112r01a4.value = '<?php echo "$mod112r01a4";?>';
   document.formv1.mod112r02a4.value = '<?php echo "$mod112r02a4";?>';
   document.formv1.mod112r03a4.value = '<?php echo "$mod112r03a4";?>';
   document.formv1.mod112r04a4.value = '<?php echo "$mod112r04a4";?>';
   document.formv1.mod112r05a4.value = '<?php echo "$mod112r05a4";?>';
   document.formv1.mod112r06a4.value = '<?php echo "$mod112r06a4";?>';
   document.formv1.mod112r07a4.value = '<?php echo "$mod112r07a4";?>';
   document.formv1.mod112r08a4.value = '<?php echo "$mod112r08a4";?>';
   document.formv1.mod112r09a4.value = '<?php echo "$mod112r09a4";?>';
   document.formv1.mod112r10a4.value = '<?php echo "$mod112r10a4";?>';
   document.formv1.mod112r11a4.value = '<?php echo "$mod112r11a4";?>';
   document.formv1.mod112r12a4.value = '<?php echo "$mod112r12a4";?>';
 //document.formv1.mod112r99a4.value = '<?php echo "$mod112r99a4";?>';
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
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
   document.formv1.mod146r11a1.value = '<?php echo "$mod146r11a1";?>';
   document.formv1.mod146r12a1.value = '<?php echo "$mod146r12a1";?>';
   document.formv1.mod146r13a1.value = '<?php echo "$mod146r13a1";?>';
   document.formv1.mod146r14a1.value = '<?php echo "$mod146r14a1";?>';
   document.formv1.mod146r15a1.value = '<?php echo "$mod146r15a1";?>';
   document.formv1.mod146r16a1.value = '<?php echo "$mod146r16a1";?>';
   document.formv1.mod146r17a1.value = '<?php echo "$mod146r17a1";?>';
   document.formv1.mod146r18a1.value = '<?php echo "$mod146r18a1";?>';
   document.formv1.mod146r19a1.value = '<?php echo "$mod146r19a1";?>';
   document.formv1.mod146r20a1.value = '<?php echo "$mod146r20a1";?>';
   document.formv1.mod146r21a1.value = '<?php echo "$mod146r21a1";?>';
   document.formv1.mod146r22a1.value = '<?php echo "$mod146r22a1";?>';
   document.formv1.mod146r23a1.value = '<?php echo "$mod146r23a1";?>';
   document.formv1.mod146r24a1.value = '<?php echo "$mod146r24a1";?>';
   document.formv1.mod146r25a1.value = '<?php echo "$mod146r25a1";?>';
   document.formv1.mod545r11a1.value = '<?php echo "$mod545r11a1";?>';
   document.formv1.mod545r12a1.value = '<?php echo "$mod545r12a1";?>';
 //document.formv1.mod545r99a1.value = '<?php echo "$mod545r99a1";?>';
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
   document.formv1.mod146r11a2.value = '<?php echo "$mod146r11a2";?>';
   document.formv1.mod146r12a2.value = '<?php echo "$mod146r12a2";?>';
   document.formv1.mod146r13a2.value = '<?php echo "$mod146r13a2";?>';
   document.formv1.mod146r14a2.value = '<?php echo "$mod146r14a2";?>';
   document.formv1.mod146r15a2.value = '<?php echo "$mod146r15a2";?>';
   document.formv1.mod146r16a2.value = '<?php echo "$mod146r16a2";?>';
   document.formv1.mod146r17a2.value = '<?php echo "$mod146r17a2";?>';
   document.formv1.mod146r18a2.value = '<?php echo "$mod146r18a2";?>';
   document.formv1.mod146r19a2.value = '<?php echo "$mod146r19a2";?>';
   document.formv1.mod146r20a2.value = '<?php echo "$mod146r20a2";?>';
   document.formv1.mod146r21a2.value = '<?php echo "$mod146r21a2";?>';
   document.formv1.mod146r22a2.value = '<?php echo "$mod146r22a2";?>';
   document.formv1.mod146r23a2.value = '<?php echo "$mod146r23a2";?>';
   document.formv1.mod146r24a2.value = '<?php echo "$mod146r24a2";?>';
   document.formv1.mod146r25a2.value = '<?php echo "$mod146r25a2";?>';
   document.formv1.mod545r11a2.value = '<?php echo "$mod545r11a2";?>';
   document.formv1.mod545r12a2.value = '<?php echo "$mod545r12a2";?>';
 //document.formv1.mod545r99a2.value = '<?php echo "$mod545r99a2";?>';
<?php                     } ?>

<?php if ( $strana == 7 ) { ?>
   document.formv1.mod5r01.value = '<?php echo "$mod5r01";?>';
   document.formv1.mod5r02.value = '<?php echo "$mod5r02";?>';
   //document.formv1.mod5r03.value = '<?php echo "$mod5r03";?>';
   //document.formv1.mod5r04.value = '<?php echo "$mod5r04";?>';
   //document.formv1.mod5r05.value = '<?php echo "$mod5r05";?>';
   document.formv1.mod5r06.value = '<?php echo "$mod5r06";?>';
   document.formv1.mod5r07.value = '<?php echo "$mod5r07";?>';
   document.formv1.mod5r08.value = '<?php echo "$mod5r08";?>';
   document.formv1.mod5r10.value = '<?php echo "$mod5r10";?>';
   document.formv1.mod5r11.value = '<?php echo "$mod5r11";?>';
   document.formv1.mod5r12.value = '<?php echo "$mod5r12";?>';
   document.formv1.mod5r13.value = '<?php echo "$mod5r13";?>';
   document.formv1.mod5r14.value = '<?php echo "$mod5r14";?>';
   document.formv1.mod5r15.value = '<?php echo "$mod5r15";?>';
   document.formv1.mod5r16.value = '<?php echo "$mod5r16";?>';
   document.formv1.mod5r17.value = '<?php echo "$mod5r17";?>';
   document.formv1.mod5r18.value = '<?php echo "$mod5r18";?>';
   document.formv1.mod5r19.value = '<?php echo "$mod5r19";?>';
   document.formv1.mod5r20.value = '<?php echo "$mod5r20";?>';
   document.formv1.mod5r22.value = '<?php echo "$mod5r22";?>';
   document.formv1.mod5r23.value = '<?php echo "$mod5r23";?>';
   document.formv1.mod5r24.value = '<?php echo "$mod5r24";?>';
   document.formv1.mod5r25.value = '<?php echo "$mod5r25";?>';
 //document.formv1.mod5r99.value = '<?php echo "$mod5r99";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

<?php
//uprava modul 1003 a 1004
  if ( $copern == 402 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 5 ) { ?>
  //document.formv1.mod1003s01.value = '<?php echo "$mod1003s01";?>';
   document.formv1.mod1003s02.value = '<?php echo "$mod1003s02";?>';
   document.formv1.mod1003s03.value = '<?php echo "$mod1003s03";?>';
   document.formv1.mod1003s04.value = '<?php echo "$mod1003s04";?>';
   document.formv1.mod1003s05.value = '<?php echo "$mod1003s05";?>';
   document.formv1.mod1003s06.value = '<?php echo "$mod1003s06";?>';
   document.formv1.mod1003s07.value = '<?php echo "$mod1003s07";?>';
  //document.formv1.mod1003naz.value = '<?php echo "$mod1003naz";?>';
<?php                     } ?>

<?php if ( $strana == 6 ) { ?>
  //document.formv1.mod1004s01.value = '<?php echo "$mod1004s01";?>';
   document.formv1.mod1004s02.value = '<?php echo "$mod1004s02";?>';
   document.formv1.mod1004s03.value = '<?php echo "$mod1004s03";?>';
   document.formv1.mod1004s04.value = '<?php echo "$mod1004s04";?>';
   document.formv1.mod1004s05.value = '<?php echo "$mod1004s05";?>';
   document.formv1.mod1004s06.value = '<?php echo "$mod1004s06";?>';
   document.formv1.mod1004s07.value = '<?php echo "$mod1004s07";?>';
   document.formv1.mod1004s08.value = '<?php echo "$mod1004s08";?>';
   document.formv1.mod1004s09.value = '<?php echo "$mod1004s09";?>';
 //document.formv1.mod1004naz.value = '<?php echo "$mod1004naz";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 102 AND $copern != 402 )
  {
?>
  function ObnovUI()
  {
  }
<?php
//koniec nie uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }


  function TlacVykaz()
  {
   window.open('../ucto/statistika_p304.php?copern=11&strana=9999', '_blank');
  }
//  function TlacVykazSirka()
//  {
//   window.open('../ucto/statistika_p304.php?copern=11&strana=9998', '_blank');
//  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../ucto/statistika_p304.php?copern=200&drupoh=1&page=1&typ=PDF&cstat=304&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function NacitajObratovkaM112()
  {
   window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=304&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function NacitajObratovkaM146()
  {
   window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=304545&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function NacitajSuvahaM146()
  {
   window.open('../ucto/suvaha__x.php?copern=10&drupoh=1&page=1&tis=0&typ=PDF&cstat=304&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function NacitajVysledovkaM145()
  {
   window.open('../ucto/vys_mala.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=304&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function NacitajObratovkaM1003()
  {
   window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=20304&vyb_ume=<?php echo $vyb_umk; ?>&modul=1003', '_self');
  }
  function NacitajObratovkaM1004()
  {
   window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=20304&vyb_ume=<?php echo $vyb_umk; ?>&modul=1004', '_self');
  }

  function zarch( stvrtrok )
  {
   window.open('../ucto/statistika_p304.php?copern=11&strana=9999&drupoh=1&page=1&typ=PDF&zarchivu=1&stvarch=' + stvrtrok +  '&xxx=1', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

//bud alebo checkbox v module 100065
  function klikm100065ano()
  {
   document.formv1.m100065nie.checked = false;
  }
  function klikm100065nie()
  {
   document.formv1.m100065ano.checked = false;
  }
//bud alebo checkbox v module 100064
  function klikm113ano()
  {
   document.formv1.mod113nie.checked = false;
  }
  function klikm113nie()
  {
   document.formv1.mod113ano.checked = false;
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 102 OR $copern == 402 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">ätvrùroËn˝ v˝kaz produkËn˝ch odvetvÌ Prod 3-04</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();"
     title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();"
     title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php
$sirka=950;
$vyska=1300;
if ( $strana == 5 OR $strana == 6 ) { $sirka=1250; $vyska=900; }
?>
<div id="content" style="width:<?php echo $sirka; ?>px; height:<?php echo $vyska; ?>px;">
<FORM name="formv1" method="post" action="statistika_p304.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive";
$clas5="noactive"; $clas6="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active"; if ( $strana == 7 ) $clas7="active";
$source="statistika_p304.php?";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=402&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=402&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
<?php
$tvpol=0;
$sqltt = "SELECT * FROM F".$kli_vxcf."_statistika_p304arch WHERE psys >= 1 ORDER BY psys ";
$tov = mysql_query("$sqltt");
if ( $tov) { $tvpol = mysql_num_rows($tov); }
$i=0;
  while ( $i < $tvpol )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
if ( $i == 0 )
{
echo "<h6 class=\"toleft\" style=\"margin-left:420px; padding-right:5px;\">ArchÌv:</h6>";
echo " ";
}
$psysrim="I.";
if ( $rtov->psys == 2 ) { $psysrim="II."; }
if ( $rtov->psys == 3 ) { $psysrim="III."; }
if ( $rtov->psys == 4 ) { $psysrim="IV."; }
echo "<a href='#' onclick='zarch(".$rtov->psys.")' title='KÛpia v˝kazu z archÌvu za ".$rtov->psys.".ötvrùrok'
       class='archiv-link'>".$psysrim."</a>";
}
$i=$i+1;
   }
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=7', '_blank');" class="<?php echo $clas7; ?> toright">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>
<?php
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
$kli_vrokx = substr($kli_vrok,2,2);
?>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 1.strana 127kB">

<span class="text-echo" style="top:370px; left:265px; font-size:18px; letter-spacing:24px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:370px; left:332px; font-size:18px; letter-spacing:24px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:945px; left:55px; line-height: 20px;"><?php echo "$fir_fnaz<br>$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:950px; left:806px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:947px; left:839px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:1025px; left:55px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="width:499px; top:1040px; left:480px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="width:499px; top:1090px; left:55px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);" style="width:90px; top:1085px; left:390px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 2.strana 187kB">

<!-- modul 100340 -->
<input type="text" name="cinnost" id="cinnost" style="width:327px; top:269px; left:563px;"/>
<span class="text-echo center" style="width:327px; top:307px; left:563px;"><?php echo $sknace; ?></span>

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:493px; left:730px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:530px; left:730px;"/>

<!-- modul 100065 -->
<input type="checkbox" name="m100065ano" value="1" onchange="klikm100065ano();" style="width:100px; top:694px; left:796px;"/>
<input type="checkbox" name="m100065nie" value="1" onchange="klikm100065nie();" style="width:100px; top:714px; left:796px;"/>

<!-- modul 145 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z V˝sledovky" onclick="NacitajVysledovkaM145();" style="top:797px; left:388px;" class="btn-row-tool">
<input type="text" name="mod82r01" id="mod82r01" style="width:100px; top:938px; left:590px;"/>
<input type="text" name="mod82r02" id="mod82r02" style="width:100px; top:965px; left:590px;"/>
<input type="text" name="mod82r03" id="mod82r03" style="width:100px; top:993px; left:590px;"/>
<input type="text" name="mod82r04" id="mod82r04" style="width:100px; top:1020px; left:590px;"/>
<input type="text" name="mod82r05" id="mod82r05" style="width:100px; top:1047px; left:590px;"/>
<span class="text-echo" style="top:1080px; right:255px;"><?php echo $mod82r99; ?></span>
<input type="text" name="mod82r012" id="mod82r012" style="width:100px; top:938px; left:760px;"/>
<input type="text" name="mod82r032" id="mod82r032" style="width:100px; top:993px; left:760px;"/>
<input type="text" name="mod82r042" id="mod82r042" style="width:100px; top:1020px; left:760px;"/>
<span class="text-echo" style="top:1080px; right:82px;"><?php echo $mod82r992; ?></span>

<!-- modul 100064 -->
<input type="checkbox" name="mod113ano" value="1" onchange="klikm113ano();" style="width:100px; top:1197px; left:796px;"/>
<input type="checkbox" name="mod113nie" value="1" onchange="klikm113nie();" style="width:100px; top:1217px; left:796px;"/>
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 3.strana 187kB">

<!-- modul 112 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z Obratovky" onclick="NacitajObratovkaM112();" style="top:108px; left:532px;" class="btn-row-tool">
<input type="text" name="mod112r01a1" id="mod112r01a1" style="width:103px; top:324px; left:434px;"/>
<input type="text" name="mod112r01a2" id="mod112r01a2" style="width:103px; top:324px; left:552px;"/>
<input type="text" name="mod112r01a3" id="mod112r01a3" style="width:104px; top:324px; left:669px;"/>
<input type="text" name="mod112r01a4" id="mod112r01a4" style="width:103px; top:324px; left:787px;"/>
<input type="text" name="mod112r02a1" id="mod112r02a1" style="width:103px; top:356px; left:434px;"/>
<input type="text" name="mod112r02a2" id="mod112r02a2" style="width:103px; top:356px; left:552px;"/>
<input type="text" name="mod112r02a3" id="mod112r02a3" style="width:104px; top:356px; left:669px;"/>
<input type="text" name="mod112r02a4" id="mod112r02a4" style="width:103px; top:356px; left:787px;"/>
<input type="text" name="mod112r03a1" id="mod112r03a1" style="width:103px; top:387px; left:434px;"/>
<input type="text" name="mod112r03a2" id="mod112r03a2" style="width:103px; top:387px; left:552px;"/>
<input type="text" name="mod112r03a3" id="mod112r03a3" style="width:104px; top:387px; left:669px;"/>
<input type="text" name="mod112r03a4" id="mod112r03a4" style="width:103px; top:387px; left:787px;"/>
<input type="text" name="mod112r04a1" id="mod112r04a1" style="width:103px; top:419px; left:434px;"/>
<input type="text" name="mod112r04a2" id="mod112r04a2" style="width:103px; top:419px; left:552px;"/>
<input type="text" name="mod112r04a3" id="mod112r04a3" style="width:104px; top:419px; left:669px;"/>
<input type="text" name="mod112r04a4" id="mod112r04a4" style="width:103px; top:419px; left:787px;"/>
<input type="text" name="mod112r05a1" id="mod112r05a1" style="width:103px; top:453px; left:434px;"/>
<input type="text" name="mod112r05a2" id="mod112r05a2" style="width:103px; top:453px; left:552px;"/>
<input type="text" name="mod112r05a3" id="mod112r05a3" style="width:104px; top:453px; left:669px;"/>
<input type="text" name="mod112r05a4" id="mod112r05a4" style="width:103px; top:453px; left:787px;"/>
<input type="text" name="mod112r06a1" id="mod112r06a1" style="width:103px; top:487px; left:434px;"/>
<input type="text" name="mod112r06a2" id="mod112r06a2" style="width:103px; top:487px; left:552px;"/>
<input type="text" name="mod112r06a3" id="mod112r06a3" style="width:104px; top:487px; left:669px;"/>
<input type="text" name="mod112r06a4" id="mod112r06a4" style="width:103px; top:487px; left:787px;"/>
<input type="text" name="mod112r07a1" id="mod112r07a1" style="width:103px; top:519px; left:434px;"/>
<input type="text" name="mod112r07a2" id="mod112r07a2" style="width:103px; top:519px; left:552px;"/>
<input type="text" name="mod112r07a3" id="mod112r07a3" style="width:104px; top:519px; left:669px;"/>
<input type="text" name="mod112r07a4" id="mod112r07a4" style="width:103px; top:519px; left:787px;"/>
<input type="text" name="mod112r08a1" id="mod112r08a1" style="width:103px; top:552px; left:434px;"/>
<input type="text" name="mod112r08a2" id="mod112r08a2" style="width:103px; top:552px; left:552px;"/>
<input type="text" name="mod112r08a3" id="mod112r08a3" style="width:104px; top:552px; left:669px;"/>
<input type="text" name="mod112r08a4" id="mod112r08a4" style="width:103px; top:552px; left:787px;"/>
<input type="text" name="mod112r09a1" id="mod112r09a1" style="width:103px; top:582px; left:434px;"/>
<input type="text" name="mod112r09a2" id="mod112r09a2" style="width:103px; top:582px; left:552px;"/>
<input type="text" name="mod112r09a3" id="mod112r09a3" style="width:104px; top:582px; left:669px;"/>
<input type="text" name="mod112r09a4" id="mod112r09a4" style="width:103px; top:582px; left:787px;"/>
<input type="text" name="mod112r10a1" id="mod112r10a1" style="width:103px; top:615px; left:434px;"/>
<input type="text" name="mod112r10a3" id="mod112r10a3" style="width:104px; top:615px; left:669px;"/>
<input type="text" name="mod112r10a4" id="mod112r10a4" style="width:103px; top:615px; left:787px;"/>
<input type="text" name="mod112r11a1" id="mod112r11a1" style="width:103px; top:647px; left:434px;"/>
<input type="text" name="mod112r11a3" id="mod112r11a3" style="width:104px; top:647px; left:669px;"/>
<input type="text" name="mod112r11a4" id="mod112r11a4" style="width:103px; top:647px; left:787px;"/>
<input type="text" name="mod112r12a1" id="mod112r12a1" style="width:103px; top:678px; left:434px;"/>
<input type="text" name="mod112r12a2" id="mod112r12a2" style="width:103px; top:678px; left:552px;"/>
<input type="text" name="mod112r12a3" id="mod112r12a3" style="width:104px; top:678px; left:669px;"/>
<input type="text" name="mod112r12a4" id="mod112r12a4" style="width:103px; top:678px; left:787px;"/>
<input type="text" name="mod112r13a1" id="mod112r13a1" style="width:103px; top:713px; left:434px;"/>
<input type="text" name="mod112r13a2" id="mod112r13a2" style="width:103px; top:713px; left:552px;"/>
<input type="text" name="mod112r13a3" id="mod112r13a3" style="width:104px; top:713px; left:669px;"/>
<span class="text-echo" style="top:751px; right:410px;"><?php echo $mod112r99a1; ?></span>
<span class="text-echo" style="top:751px; right:292px;"><?php echo $mod112r99a2; ?></span>
<span class="text-echo" style="top:751px; right:175px;"><?php echo $mod112r99a3; ?></span>
<span class="text-echo" style="top:751px; right:58px;"><?php echo $mod112r99a4; ?></span>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str4.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 4.strana 162kB">

<!-- modul 146 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z Obratovky" onclick="NacitajObratovkaM146();" class="btn-row-tool" style="top:98px; left:338px;">
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje zo S˙vahy" onclick="NacitajSuvahaM146();"  class="btn-row-tool" style="top:98px; left:364px;">
<input type="text" name="mod545r01a1" id="mod545r01a1" style="width:160px; top:257px; left:561px;"/>
<input type="text" name="mod545r01a2" id="mod545r01a2" style="width:160px; top:257px; left:732px;"/>
<input type="text" name="mod545r02a1" id="mod545r02a1" style="width:160px; top:289px; left:561px;"/>
<input type="text" name="mod545r02a2" id="mod545r02a2" style="width:160px; top:289px; left:732px;"/>
<input type="text" name="mod545r03a1" id="mod545r03a1" style="width:160px; top:321px; left:561px;"/>
<input type="text" name="mod545r03a2" id="mod545r03a2" style="width:160px; top:321px; left:732px;"/>
<input type="text" name="mod545r04a1" id="mod545r04a1" style="width:160px; top:353px; left:561px;"/>
<input type="text" name="mod545r04a2" id="mod545r04a2" style="width:160px; top:353px; left:732px;"/>
<input type="text" name="mod545r05a1" id="mod545r05a1" style="width:160px; top:385px; left:561px;"/>
<input type="text" name="mod545r05a2" id="mod545r05a2" style="width:160px; top:385px; left:732px;"/>
<input type="text" name="mod545r06a1" id="mod545r06a1" style="width:160px; top:417px; left:561px;"/>
<input type="text" name="mod545r06a2" id="mod545r06a2" style="width:160px; top:417px; left:732px;"/>
<input type="text" name="mod545r07a1" id="mod545r07a1" style="width:160px; top:448px; left:561px;"/>
<input type="text" name="mod545r07a2" id="mod545r07a2" style="width:160px; top:448px; left:732px;"/>
<input type="text" name="mod545r08a1" id="mod545r08a1" style="width:160px; top:480px; left:561px;"/>
<input type="text" name="mod545r08a2" id="mod545r08a2" style="width:160px; top:480px; left:732px;"/>
<input type="text" name="mod545r09a1" id="mod545r09a1" style="width:160px; top:512px; left:561px;"/>
<input type="text" name="mod545r09a2" id="mod545r09a2" style="width:160px; top:512px; left:732px;"/>
<input type="text" name="mod545r10a1" id="mod545r10a1" style="width:160px; top:544px; left:561px;"/>
<input type="text" name="mod545r10a2" id="mod545r10a2" style="width:160px; top:544px; left:732px;"/>
<input type="text" name="mod146r11a1" id="mod146r11a1" style="width:160px; top:576px; left:561px;"/>
<input type="text" name="mod146r11a2" id="mod146r11a2" style="width:160px; top:576px; left:732px;"/>
<input type="text" name="mod146r12a1" id="mod146r12a1" style="width:160px; top:607px; left:561px;"/>
<input type="text" name="mod146r12a2" id="mod146r12a2" style="width:160px; top:607px; left:732px;"/>
<input type="text" name="mod146r13a1" id="mod146r13a1" style="width:160px; top:639px; left:561px;"/>
<input type="text" name="mod146r13a2" id="mod146r13a2" style="width:160px; top:639px; left:732px;"/>
<input type="text" name="mod146r14a1" id="mod146r14a1" style="width:160px; top:671px; left:561px;"/>
<input type="text" name="mod146r14a2" id="mod146r14a2" style="width:160px; top:671px; left:732px;"/>
<input type="text" name="mod146r15a1" id="mod146r15a1" style="width:160px; top:703px; left:561px;"/>
<input type="text" name="mod146r15a2" id="mod146r15a2" style="width:160px; top:703px; left:732px;"/>
<input type="text" name="mod146r16a1" id="mod146r16a1" style="width:160px; top:735px; left:561px;"/>
<input type="text" name="mod146r16a2" id="mod146r16a2" style="width:160px; top:735px; left:732px;"/>
<input type="text" name="mod146r17a1" id="mod146r17a1" style="width:160px; top:767px; left:561px;"/>
<input type="text" name="mod146r17a2" id="mod146r17a2" style="width:160px; top:767px; left:732px;"/>
<input type="text" name="mod146r18a1" id="mod146r18a1" style="width:160px; top:798px; left:561px;"/>
<input type="text" name="mod146r18a2" id="mod146r18a2" style="width:160px; top:798px; left:732px;"/>
<input type="text" name="mod146r19a1" id="mod146r19a1" style="width:160px; top:830px; left:561px;"/>
<input type="text" name="mod146r19a2" id="mod146r19a2" style="width:160px; top:830px; left:732px;"/>
<input type="text" name="mod146r20a1" id="mod146r20a1" style="width:160px; top:862px; left:561px;"/>
<input type="text" name="mod146r20a2" id="mod146r20a2" style="width:160px; top:862px; left:732px;"/>
<input type="text" name="mod146r21a1" id="mod146r21a1" style="width:160px; top:894px; left:561px;"/>
<input type="text" name="mod146r21a2" id="mod146r21a2" style="width:160px; top:894px; left:732px;"/>
<input type="text" name="mod146r22a1" id="mod146r22a1" style="width:160px; top:926px; left:561px;"/>
<input type="text" name="mod146r22a2" id="mod146r22a2" style="width:160px; top:926px; left:732px;"/>
<input type="text" name="mod146r23a1" id="mod146r23a1" style="width:160px; top:957px; left:561px;"/>
<input type="text" name="mod146r23a2" id="mod146r23a2" style="width:160px; top:957px; left:732px;"/>
<input type="text" name="mod146r24a1" id="mod146r24a1" style="width:160px; top:989px; left:561px;"/>
<input type="text" name="mod146r24a2" id="mod146r24a2" style="width:160px; top:989px; left:732px;"/>
<input type="text" name="mod146r25a1" id="mod146r25a1" style="width:160px; top:1021px; left:561px;"/>
<input type="text" name="mod146r25a2" id="mod146r25a2" style="width:160px; top:1021px; left:732px;"/>
<input type="text" name="mod545r11a1" id="mod545r11a1" style="width:160px; top:1053px; left:561px;"/>
<input type="text" name="mod545r11a2" id="mod545r11a2" style="width:160px; top:1053px; left:732px;"/>
<input type="text" name="mod545r12a1" id="mod545r12a1" style="width:160px; top:1085px; left:561px;"/>
<input type="text" name="mod545r12a2" id="mod545r12a2" style="width:160px; top:1085px; left:732px;"/>
<span class="text-echo" style="top:1121px; right:228px;"><?php echo $mod545r99a1; ?></span>
<span class="text-echo" style="top:1121px; right:57px;"><?php echo $mod545r99a2; ?></span>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str5.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 5.strana 272kB" style="width:1250px; height:900px;">
<span class="text-echo" style="top:79px; left:545px; font-size:18px;">1</span>
<span class="text-echo" style="top:79px; left:741px; font-size:18px; letter-spacing:24px;"><?php echo $fir_ficox; ?></span>

<!-- modul 1003 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z Obratovky" onclick="NacitajObratovkaM1003();" class="btn-row-tool" style="top:123px; left:556px;">
<span class="text-echo" style="top:323px; left:123px;"><?php echo $cslr1; ?></span>
<input type="text" name="mod1003s02" id="mod1003s02" style="width:125px; top:320px; left:174px;"/>
<input type="text" name="mod1003s03" id="mod1003s03" style="width:135px; top:320px; left:311px;"/>
<input type="text" name="mod1003s04" id="mod1003s04" style="width:157px; top:320px; left:458px;"/>
<input type="text" name="mod1003s05" id="mod1003s05" style="width:178px; top:320px; left:626px;"/>
<input type="text" name="mod1003s06" id="mod1003s06" style="width:188px; top:320px; left:816px;"/>
<input type="text" name="mod1003s07" id="mod1003s07" style="width:177px; top:320px; left:1016px;"/>
<span class="text-echo" style="top:836px; right:949px;"><?php echo $mod1003s02; ?></span>
<span class="text-echo" style="top:836px; right:801px;"><?php echo $mod1003s03; ?></span>
<span class="text-echo" style="top:836px; right:634px;"><?php echo $mod1003s04; ?></span>
<span class="text-echo" style="top:836px; right:444px;"><?php echo $mod1003s05; ?></span>
<span class="text-echo" style="top:836px; right:245px;"><?php echo $mod1003s06; ?></span>
<span class="text-echo" style="top:836px; right:54px;"><?php echo $mod1003s07; ?></span>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str6.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 6.strana 272kB" style="width:1250px; height:900px;">

<!-- modul 1004 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z Obratovky" onclick="NacitajObratovkaM1004();" class="btn-row-tool" style="top:82px; left:556px;">
<span class="text-echo" style="top:299px; left:120px;"><?php echo $cslr2; ?></span>
<input type="text" name="mod1004s02" id="mod1004s02" style="width:127px; top:295px; left:173px;"/>
<input type="text" name="mod1004s03" id="mod1004s03" style="width:126px; top:295px; left:310px;"/>
<input type="text" name="mod1004s04" id="mod1004s04" style="width:147px; top:295px; left:447px;"/>
<input type="text" name="mod1004s05" id="mod1004s05" style="width:127px; top:295px; left:604px;"/>
<input type="text" name="mod1004s06" id="mod1004s06" style="width:95px; top:295px; left:741px;"/>
<input type="text" name="mod1004s07" id="mod1004s07" style="width:105px; top:295px; left:847px;"/>
<input type="text" name="mod1004s08" id="mod1004s08" style="width:106px; top:295px; left:962px;"/>
<input type="text" name="mod1004s09" id="mod1004s09" style="width:115px; top:295px; left:1078px;"/>
<span class="text-echo" style="top:821px; right:950px;"><?php echo $mod1004s02; ?></span>
<span class="text-echo" style="top:821px; right:813px;"><?php echo $mod1004s03; ?></span>
<span class="text-echo" style="top:821px; right:655px;"><?php echo $mod1004s04; ?></span>
<span class="text-echo" style="top:821px; right:518px;"><?php echo $mod1004s05; ?></span>
<span class="text-echo" style="top:821px; right:413px;"><?php echo $mod1004s06; ?></span>
<span class="text-echo" style="top:821px; right:298px;"><?php echo $mod1004s07; ?></span>
<span class="text-echo" style="top:821px; right:182px;"><?php echo $mod1004s08; ?></span>
<span class="text-echo" style="top:821px; right:56px;"><?php echo $mod1004s09; ?></span>
<?php                                        } ?>


<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str7.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 7.strana 272kB">

<!-- modul 5 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z miezd" onclick="NacitajMzdy();" class="btn-row-tool" style="top:134px; left:378px;">
<input type="text" name="mod5r01" id="mod5r01" onkeyup="CiarkaNaBodku(this);" style="width:206px; top:257px; left:630px;"/>
<input type="text" name="mod5r02" id="mod5r02" style="width:206px; top:289px; left:630px;"/>
<input type="text" name="mod5r06" id="mod5r06" style="width:206px; top:324px; left:630px;"/>
<input type="text" name="mod5r07" id="mod5r07" style="width:206px; top:357px; left:630px;"/>
<input type="text" name="mod5r08" id="mod5r08" style="width:206px; top:389px; left:630px;"/>
<input type="text" name="mod5r10" id="mod5r10" style="width:206px; top:422px; left:630px;"/>
<input type="text" name="mod5r11" id="mod5r11" style="width:206px; top:455px; left:630px;"/>
<input type="text" name="mod5r12" id="mod5r12" style="width:206px; top:492px; left:630px;"/>
<input type="text" name="mod5r13" id="mod5r13" style="width:206px; top:526px; left:630px;"/>
<input type="text" name="mod5r14" id="mod5r14" style="width:206px; top:558px; left:630px;"/>
<input type="text" name="mod5r15" id="mod5r15" style="width:206px; top:590px; left:630px;"/>
<input type="text" name="mod5r16" id="mod5r16" style="width:206px; top:622px; left:630px;"/>
<input type="text" name="mod5r17" id="mod5r17" style="width:206px; top:653px; left:630px;"/>
<input type="text" name="mod5r18" id="mod5r18" style="width:206px; top:685px; left:630px;"/>
<input type="text" name="mod5r19" id="mod5r19" style="width:206px; top:717px; left:630px;"/>
<input type="text" name="mod5r20" id="mod5r20" style="width:206px; top:751px; left:630px;"/>
<input type="text" name="mod5r22" id="mod5r22" style="width:206px; top:788px; left:630px;"/>
<input type="text" name="mod5r23" id="mod5r23" style="width:206px; top:822px; left:630px;"/>
<input type="text" name="mod5r24" id="mod5r24" style="width:206px; top:854px; left:630px;"/>
<input type="text" name="mod5r25" id="mod5r25" style="width:206px; top:888px; left:630px;"/>
<span class="text-echo" style="top:928px; right:110px;"><?php echo $mod5r99; ?></span>
<?php                                        } ?>


<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=402&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=402&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//koniec uprav
     }
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

//if ( $strana != 4 AND $strana != 5 AND $strana != 9998 )
//{
$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
//}
//if ( $strana == 4 OR $strana == 5 OR $strana == 9998 )
//{
//$sirka_vyska="320,220";
//$velkost_strany = explode(",", $sirka_vyska);
//$pdf=new FPDF("P","mm", $velkost_strany );
//$pdf->Open();
//$pdf->AddFont('arial','','arial.php');
//}

//&zarchivu=1&stvarch
$zarchivu = 1*strip_tags($_REQUEST['zarchivu']);
$stvarch = 1*strip_tags($_REQUEST['stvarch']);

//vytlac
if ( $zarchivu == 0 )
     {
$sqltt = "UPDATE F$kli_vxcf"."_statistika_p304 SET psys=$stvrtrok ";
$sql = mysql_query("$sqltt");
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_p304 WHERE ico >= 0 "."";
     }

if ( $zarchivu == 1 )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_p304arch WHERE psys = $stvarch ";
$stvrtrok=$stvarch;
$psys=$stvarch;
     }

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
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//OBDOBIA
$A=substr($mesiac,0,1);
$B=substr($mesiac,1,1);
if ( $zarchivu == 1 AND $stvarch == 1 ) { $A=0; $B=3; }
if ( $zarchivu == 1 AND $stvarch == 2 ) { $A=0; $B=6; }
if ( $zarchivu == 1 AND $stvarch == 3 ) { $A=0; $B=9; }
if ( $zarchivu == 1 AND $stvarch == 4 ) { $A=1; $B=2; }
$pdf->Cell(190,42," ","$rmc1",1,"L");
$pdf->Cell(48,5," ","$rmc1",0,"L");$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");
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
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(8,7,"$B","$rmc",0,"C");
$pdf->Cell(9,7,"$C","$rmc",0,"C");$pdf->Cell(8,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(8,7,"$F","$rmc",0,"C");
$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(8,7,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,106," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,4,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,4,"$okres","$rmc",1,"C");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(43,11,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,0," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,6,"$fir_fem1","$rmc",0,"L");
//odoslane
$pdf->Cell(2,5," ","$rmc1",0,"L");$pdf->Cell(43,6,"$odoslane_sk","$rmc",1,"C");

//modul 100307
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(78,5," ","$rmc1",0,"C");$pdf->Cell(111,5.5,"$fir_mzdt05","$rmc",1,"C");
$pdf->Cell(78,5," ","$rmc1",0,"C");$pdf->Cell(111,6,"$fir_mzdt04","$rmc",1,"C");
$pdf->Cell(78,5," ","$rmc1",0,"C");$pdf->Cell(111,5,"$fir_fem1","$rmc",1,"C");

//modul 100340
$pdf->Cell(195,21," ","$rmc1",1,"L");
$pdf->Cell(78,5," ","$rmc1",0,"C");$pdf->Cell(111,5,"$cinnost","$rmc",1,"C");
$pdf->Cell(78,5," ","$rmc1",0,"C");$pdf->Cell(111,5,"$sknace","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 2
$mod2r01=$hlavicka->mod2r01;
if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02;
if ( $mod2r02 == 0 ) $mod2r02="";
$pdf->Cell(195,14," ","$rmc1",1,"L");
$pdf->Cell(158,5," ","$rmc1",0,"C");$pdf->Cell(31,7,"$mod2r01","$rmc",1,"C");
$pdf->Cell(158,5," ","$rmc1",0,"C");$pdf->Cell(31,7,"$mod2r02","$rmc",1,"C");

//modul 100065
$m100065ano=" ";
$m100065nie=" ";
if ( $hlavicka->m100065ano == 1 ) { $m100065ano="x"; }
if ( $hlavicka->m100065nie == 1 ) { $m100065nie="x"; }
$pdf->Cell(190,20," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100065ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m100065nie","$rmc",1,"C");

//modul 145
$mod82r01=$hlavicka->mod82r01; if ( $hlavicka->mod82r01 == 0 ) $mod82r01="";
$mod82r02=$hlavicka->mod82r02; if ( $hlavicka->mod82r02 == 0 ) $mod82r02="";
$mod82r03=$hlavicka->mod82r03; if ( $hlavicka->mod82r03 == 0 ) $mod82r03="";
$mod82r04=$hlavicka->mod82r04; if ( $hlavicka->mod82r04 == 0 ) $mod82r04="";
$mod82r05=$hlavicka->mod82r05; if ( $hlavicka->mod82r05 == 0 ) $mod82r05="";
$mod82r99=$hlavicka->mod82r99;
//if ( $hlavicka->mod82r99 == 0 ) $mod82r99="";
$mod82r012=$hlavicka->mod82r012; if ( $hlavicka->mod82r012 == 0 ) $mod82r012="";
$mod82r032=$hlavicka->mod82r032; if ( $hlavicka->mod82r032 == 0 ) $mod82r032="";
$mod82r042=$hlavicka->mod82r042; if ( $hlavicka->mod82r042 == 0 ) $mod82r042="";
$mod82r992=$hlavicka->mod82r992;
//if ( $hlavicka->mod82r992 == 0 ) $mod82r992="";
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,6,"$mod82r01","$rmc",0,"R");$pdf->Cell(52,6,"$mod82r012","$rmc",1,"R");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,6,"$mod82r02","$rmc",0,"R");$pdf->Cell(38,6," ","$rmc",1,"R");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,5,"$mod82r03","$rmc",0,"R");$pdf->Cell(52,5,"$mod82r032","$rmc",1,"R");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,5,"$mod82r04","$rmc",0,"R");$pdf->Cell(52,5,"$mod82r042","$rmc",1,"R");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,5,"$mod82r05","$rmc",0,"R");$pdf->Cell(38,5," ","$rmc",1,"R");
$pdf->Cell(83,6," ","$rmc1",0,"L");$pdf->Cell(52,7,"$mod82r99","$rmc",0,"R");$pdf->Cell(52,7,"$mod82r992","$rmc",1,"R");

//modul 100064
$mod113ano=" ";
$mod113nie=" ";
if ( $hlavicka->mod113ano == 1 ) { $mod113ano="x"; }
if ( $hlavicka->mod113nie == 1 ) { $mod113nie="x"; }
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod113ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod113nie","$rmc",1,"C");

//modul 112
$mod112r01a1=$hlavicka->mod112r01a1; if ( $hlavicka->mod112r01a1 == 0 ) $mod112r01a1="";
$mod112r02a1=$hlavicka->mod112r02a1; if ( $hlavicka->mod112r02a1 == 0 ) $mod112r02a1="";
$mod112r03a1=$hlavicka->mod112r03a1; if ( $hlavicka->mod112r03a1 == 0 ) $mod112r03a1="";
$mod112r04a1=$hlavicka->mod112r04a1; if ( $hlavicka->mod112r04a1 == 0 ) $mod112r04a1="";
$mod112r05a1=$hlavicka->mod112r05a1; if ( $hlavicka->mod112r05a1 == 0 ) $mod112r05a1="";
$mod112r06a1=$hlavicka->mod112r06a1; if ( $hlavicka->mod112r06a1 == 0 ) $mod112r06a1="";
$mod112r07a1=$hlavicka->mod112r07a1; if ( $hlavicka->mod112r07a1 == 0 ) $mod112r07a1="";
$mod112r08a1=$hlavicka->mod112r08a1; if ( $hlavicka->mod112r08a1 == 0 ) $mod112r08a1="";
$mod112r09a1=$hlavicka->mod112r09a1; if ( $hlavicka->mod112r09a1 == 0 ) $mod112r09a1="";
$mod112r10a1=$hlavicka->mod112r10a1; if ( $hlavicka->mod112r10a1 == 0 ) $mod112r10a1="";
$mod112r11a1=$hlavicka->mod112r11a1; if ( $hlavicka->mod112r11a1 == 0 ) $mod112r11a1="";
$mod112r12a1=$hlavicka->mod112r12a1; if ( $hlavicka->mod112r12a1 == 0 ) $mod112r12a1="";
$mod112r13a1=$hlavicka->mod112r13a1; if ( $hlavicka->mod112r13a1 == 0 ) $mod112r13a1="";
$mod112r99a1=$hlavicka->mod112r99a1;
//if ( $hlavicka->mod112r99a1 == 0 ) $mod112r99a1="";
$mod112r01a2=$hlavicka->mod112r01a2; if ( $hlavicka->mod112r01a2 == 0 ) $mod112r01a2="";
$mod112r02a2=$hlavicka->mod112r02a2; if ( $hlavicka->mod112r02a2 == 0 ) $mod112r02a2="";
$mod112r03a2=$hlavicka->mod112r03a2; if ( $hlavicka->mod112r03a2 == 0 ) $mod112r03a2="";
$mod112r04a2=$hlavicka->mod112r04a2; if ( $hlavicka->mod112r04a2 == 0 ) $mod112r04a2="";
$mod112r05a2=$hlavicka->mod112r05a2; if ( $hlavicka->mod112r05a2 == 0 ) $mod112r05a2="";
$mod112r06a2=$hlavicka->mod112r06a2; if ( $hlavicka->mod112r06a2 == 0 ) $mod112r06a2="";
$mod112r07a2=$hlavicka->mod112r07a2; if ( $hlavicka->mod112r07a2 == 0 ) $mod112r07a2="";
$mod112r08a2=$hlavicka->mod112r08a2; if ( $hlavicka->mod112r08a2 == 0 ) $mod112r08a2="";
$mod112r09a2=$hlavicka->mod112r09a2; if ( $hlavicka->mod112r09a2 == 0 ) $mod112r09a2="";
$mod112r12a2=$hlavicka->mod112r12a2; if ( $hlavicka->mod112r12a2 == 0 ) $mod112r12a2="";
$mod112r13a2=$hlavicka->mod112r13a2; if ( $hlavicka->mod112r13a2 == 0 ) $mod112r13a2="";
$mod112r99a2=$hlavicka->mod112r99a2;
//if ( $hlavicka->mod112r99a2 == 0 ) $mod112r99a2="";
$mod112r01a3=$hlavicka->mod112r01a3; if ( $hlavicka->mod112r01a3 == 0 ) $mod112r01a3="";
$mod112r02a3=$hlavicka->mod112r02a3; if ( $hlavicka->mod112r02a3 == 0 ) $mod112r02a3="";
$mod112r03a3=$hlavicka->mod112r03a3; if ( $hlavicka->mod112r03a3 == 0 ) $mod112r03a3="";
$mod112r04a3=$hlavicka->mod112r04a3; if ( $hlavicka->mod112r04a3 == 0 ) $mod112r04a3="";
$mod112r05a3=$hlavicka->mod112r05a3; if ( $hlavicka->mod112r05a3 == 0 ) $mod112r05a3="";
$mod112r06a3=$hlavicka->mod112r06a3; if ( $hlavicka->mod112r06a3 == 0 ) $mod112r06a3="";
$mod112r07a3=$hlavicka->mod112r07a3; if ( $hlavicka->mod112r07a3 == 0 ) $mod112r07a3="";
$mod112r08a3=$hlavicka->mod112r08a3; if ( $hlavicka->mod112r08a3 == 0 ) $mod112r08a3="";
$mod112r09a3=$hlavicka->mod112r09a3; if ( $hlavicka->mod112r09a3 == 0 ) $mod112r09a3="";
$mod112r10a3=$hlavicka->mod112r10a3; if ( $hlavicka->mod112r10a3 == 0 ) $mod112r10a3="";
$mod112r11a3=$hlavicka->mod112r11a3; if ( $hlavicka->mod112r11a3 == 0 ) $mod112r11a3="";
$mod112r12a3=$hlavicka->mod112r12a3; if ( $hlavicka->mod112r12a3 == 0 ) $mod112r12a3="";
$mod112r13a3=$hlavicka->mod112r13a3; if ( $hlavicka->mod112r13a3 == 0 ) $mod112r13a3="";
$mod112r99a3=$hlavicka->mod112r99a3;
//if ( $hlavicka->mod112r99a3 == 0 ) $mod112r99a3="";
$mod112r01a4=$hlavicka->mod112r01a4; if ( $hlavicka->mod112r01a4 == 0 ) $mod112r01a4="";
$mod112r02a4=$hlavicka->mod112r02a4; if ( $hlavicka->mod112r02a4 == 0 ) $mod112r02a4="";
$mod112r03a4=$hlavicka->mod112r03a4; if ( $hlavicka->mod112r03a4 == 0 ) $mod112r03a4="";
$mod112r04a4=$hlavicka->mod112r04a4; if ( $hlavicka->mod112r04a4 == 0 ) $mod112r04a4="";
$mod112r05a4=$hlavicka->mod112r05a4; if ( $hlavicka->mod112r05a4 == 0 ) $mod112r05a4="";
$mod112r06a4=$hlavicka->mod112r06a4; if ( $hlavicka->mod112r06a4 == 0 ) $mod112r06a4="";
$mod112r07a4=$hlavicka->mod112r07a4; if ( $hlavicka->mod112r07a4 == 0 ) $mod112r07a4="";
$mod112r08a4=$hlavicka->mod112r08a4; if ( $hlavicka->mod112r08a4 == 0 ) $mod112r08a4="";
$mod112r09a4=$hlavicka->mod112r09a4; if ( $hlavicka->mod112r09a4 == 0 ) $mod112r09a4="";
$mod112r10a4=$hlavicka->mod112r10a4; if ( $hlavicka->mod112r10a4 == 0 ) $mod112r10a4="";
$mod112r11a4=$hlavicka->mod112r11a4; if ( $hlavicka->mod112r11a4 == 0 ) $mod112r11a4="";
$mod112r12a4=$hlavicka->mod112r12a4; if ( $hlavicka->mod112r12a4 == 0 ) $mod112r12a4="";
$mod112r13a4=$hlavicka->mod112r13a4; if ( $hlavicka->mod112r13a4 == 0 ) $mod112r13a4="";
$mod112r99a4=$hlavicka->mod112r99a4;
//if ( $hlavicka->mod112r99a4 == 0 ) $mod112r99a4="";
$pdf->Cell(195,48," ","$rmc1",1,"L");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r01a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r01a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r01a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r01a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r02a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r02a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r02a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r02a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,5,"$mod112r03a1","$rmc",0,"R");$pdf->Cell(27,5,"$mod112r03a2","$rmc",0,"R");
$pdf->Cell(28,5,"$mod112r03a3","$rmc",0,"R");$pdf->Cell(23,5,"$mod112r03a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r04a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r04a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r04a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r04a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,5,"$mod112r05a1","$rmc",0,"R");$pdf->Cell(27,5,"$mod112r05a2","$rmc",0,"R");
$pdf->Cell(28,5,"$mod112r05a3","$rmc",0,"R");$pdf->Cell(23,5,"$mod112r05a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r06a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r06a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r06a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r06a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,5,"$mod112r07a1","$rmc",0,"R");$pdf->Cell(27,5,"$mod112r07a2","$rmc",0,"R");
$pdf->Cell(28,5,"$mod112r07a3","$rmc",0,"R");$pdf->Cell(23,5,"$mod112r07a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r08a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r08a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r08a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r08a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,5,"$mod112r09a1","$rmc",0,"R");$pdf->Cell(27,5,"$mod112r09a2","$rmc",0,"R");
$pdf->Cell(28,5,"$mod112r09a3","$rmc",0,"R");$pdf->Cell(23,5,"$mod112r09a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r10a1","$rmc",0,"R");$pdf->Cell(27,6," ","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r10a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r10a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,5,"$mod112r11a1","$rmc",0,"R");$pdf->Cell(27,5," ","$rmc",0,"R");
$pdf->Cell(28,5,"$mod112r11a3","$rmc",0,"R");$pdf->Cell(23,5,"$mod112r11a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r12a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r12a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r12a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r12a4","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,8,"$mod112r13a1","$rmc",0,"R");$pdf->Cell(27,8,"$mod112r13a2","$rmc",0,"R");
$pdf->Cell(28,8,"$mod112r13a3","$rmc",0,"R");$pdf->Cell(23,8," ","$rmc",1,"R");
$pdf->Cell(91,6," ","$rmc1",0,"L");
$pdf->Cell(20,6,"$mod112r99a1","$rmc",0,"R");$pdf->Cell(27,6,"$mod112r99a2","$rmc",0,"R");
$pdf->Cell(28,6,"$mod112r99a3","$rmc",0,"R");$pdf->Cell(23,6,"$mod112r99a4","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 146
$mod545r01a1=$hlavicka->mod545r01a1; if ( $hlavicka->mod545r01a1 == 0 ) $mod545r01a1="";
$mod545r02a1=$hlavicka->mod545r02a1; if ( $hlavicka->mod545r02a1 == 0 ) $mod545r02a1="";
$mod545r03a1=$hlavicka->mod545r03a1; if ( $hlavicka->mod545r03a1 == 0 ) $mod545r03a1="";
$mod545r04a1=$hlavicka->mod545r04a1; if ( $hlavicka->mod545r04a1 == 0 ) $mod545r04a1="";
$mod545r05a1=$hlavicka->mod545r05a1; if ( $hlavicka->mod545r05a1 == 0 ) $mod545r05a1="";
$mod545r06a1=$hlavicka->mod545r06a1; if ( $hlavicka->mod545r06a1 == 0 ) $mod545r06a1="";
$mod545r07a1=$hlavicka->mod545r07a1; if ( $hlavicka->mod545r07a1 == 0 ) $mod545r07a1="";
$mod545r08a1=$hlavicka->mod545r08a1; if ( $hlavicka->mod545r08a1 == 0 ) $mod545r08a1="";
$mod545r09a1=$hlavicka->mod545r09a1; if ( $hlavicka->mod545r09a1 == 0 ) $mod545r09a1="";
$mod545r10a1=$hlavicka->mod545r10a1; if ( $hlavicka->mod545r10a1 == 0 ) $mod545r10a1="";
$mod545r11a1=$hlavicka->mod545r11a1; if ( $hlavicka->mod545r11a1 == 0 ) $mod545r11a1="";
$mod545r12a1=$hlavicka->mod545r12a1; if ( $hlavicka->mod545r12a1 == 0 ) $mod545r12a1="";
$mod545r13a1=$hlavicka->mod545r13a1; if ( $hlavicka->mod545r13a1 == 0 ) $mod545r13a1="";
$mod545r14a1=$hlavicka->mod545r14a1; if ( $hlavicka->mod545r14a1 == 0 ) $mod545r14a1="";
$mod545r15a1=$hlavicka->mod545r15a1; if ( $hlavicka->mod545r15a1 == 0 ) $mod545r15a1="";
$mod545r16a1=$hlavicka->mod545r16a1; if ( $hlavicka->mod545r16a1 == 0 ) $mod545r16a1="";
$mod545r17a1=$hlavicka->mod545r17a1; if ( $hlavicka->mod545r17a1 == 0 ) $mod545r17a1="";
$mod545r18a1=$hlavicka->mod545r18a1; if ( $hlavicka->mod545r18a1 == 0 ) $mod545r18a1="";
$mod545r19a1=$hlavicka->mod545r19a1; if ( $hlavicka->mod545r19a1 == 0 ) $mod545r19a1="";
$mod545r20a1=$hlavicka->mod545r20a1; if ( $hlavicka->mod545r20a1 == 0 ) $mod545r20a1="";
$mod545r99a1=$hlavicka->mod545r99a1;
//if ( $hlavicka->mod545r99a1 == 0 ) $mod545r99a1="";
$mod545r01a2=$hlavicka->mod545r01a2; if ( $hlavicka->mod545r01a2 == 0 ) $mod545r01a2="";
$mod545r02a2=$hlavicka->mod545r02a2; if ( $hlavicka->mod545r02a2 == 0 ) $mod545r02a2="";
$mod545r03a2=$hlavicka->mod545r03a2; if ( $hlavicka->mod545r03a2 == 0 ) $mod545r03a2="";
$mod545r04a2=$hlavicka->mod545r04a2; if ( $hlavicka->mod545r04a2 == 0 ) $mod545r04a2="";
$mod545r05a2=$hlavicka->mod545r05a2; if ( $hlavicka->mod545r05a2 == 0 ) $mod545r05a2="";
$mod545r06a2=$hlavicka->mod545r06a2; if ( $hlavicka->mod545r06a2 == 0 ) $mod545r06a2="";
$mod545r07a2=$hlavicka->mod545r07a2; if ( $hlavicka->mod545r07a2 == 0 ) $mod545r07a2="";
$mod545r08a2=$hlavicka->mod545r08a2; if ( $hlavicka->mod545r08a2 == 0 ) $mod545r08a2="";
$mod545r09a2=$hlavicka->mod545r09a2; if ( $hlavicka->mod545r09a2 == 0 ) $mod545r09a2="";
$mod545r10a2=$hlavicka->mod545r10a2; if ( $hlavicka->mod545r10a2 == 0 ) $mod545r10a2="";
$mod545r11a2=$hlavicka->mod545r11a2; if ( $hlavicka->mod545r11a2 == 0 ) $mod545r11a2="";
$mod545r12a2=$hlavicka->mod545r12a2; if ( $hlavicka->mod545r12a2 == 0 ) $mod545r12a2="";
$mod545r13a2=$hlavicka->mod545r13a2; if ( $hlavicka->mod545r13a2 == 0 ) $mod545r13a2="";
$mod545r14a2=$hlavicka->mod545r14a2; if ( $hlavicka->mod545r14a2 == 0 ) $mod545r14a2="";
$mod545r15a2=$hlavicka->mod545r15a2; if ( $hlavicka->mod545r15a2 == 0 ) $mod545r15a2="";
$mod545r16a2=$hlavicka->mod545r16a2; if ( $hlavicka->mod545r16a2 == 0 ) $mod545r16a2="";
$mod545r17a2=$hlavicka->mod545r17a2; if ( $hlavicka->mod545r17a2 == 0 ) $mod545r17a2="";
$mod545r18a2=$hlavicka->mod545r18a2; if ( $hlavicka->mod545r18a2 == 0 ) $mod545r18a2="";
$mod545r19a2=$hlavicka->mod545r19a2; if ( $hlavicka->mod545r19a2 == 0 ) $mod545r19a2="";
$mod545r20a2=$hlavicka->mod545r20a2; if ( $hlavicka->mod545r20a2 == 0 ) $mod545r20a2="";
$mod545r99a2=$hlavicka->mod545r99a2;
//if ( $hlavicka->mod545r99a2 == 0 ) $mod545r99a2="";
$mod146r11a1=$hlavicka->mod146r11a1; if ( $hlavicka->mod146r11a1 == 0 ) $mod146r11a1="";
$mod146r12a1=$hlavicka->mod146r12a1; if ( $hlavicka->mod146r12a1 == 0 ) $mod146r12a1="";
$mod146r13a1=$hlavicka->mod146r13a1; if ( $hlavicka->mod146r13a1 == 0 ) $mod146r13a1="";
$mod146r14a1=$hlavicka->mod146r14a1; if ( $hlavicka->mod146r14a1 == 0 ) $mod146r14a1="";
$mod146r15a1=$hlavicka->mod146r15a1; if ( $hlavicka->mod146r15a1 == 0 ) $mod146r15a1="";
$mod146r16a1=$hlavicka->mod146r16a1; if ( $hlavicka->mod146r16a1 == 0 ) $mod146r16a1="";
$mod146r17a1=$hlavicka->mod146r17a1; if ( $hlavicka->mod146r17a1 == 0 ) $mod146r17a1="";
$mod146r18a1=$hlavicka->mod146r18a1; if ( $hlavicka->mod146r18a1 == 0 ) $mod146r18a1="";
$mod146r19a1=$hlavicka->mod146r19a1; if ( $hlavicka->mod146r19a1 == 0 ) $mod146r19a1="";
$mod146r20a1=$hlavicka->mod146r20a1; if ( $hlavicka->mod146r20a1 == 0 ) $mod146r20a1="";
$mod146r21a1=$hlavicka->mod146r21a1; if ( $hlavicka->mod146r21a1 == 0 ) $mod146r21a1="";
$mod146r22a1=$hlavicka->mod146r22a1; if ( $hlavicka->mod146r22a1 == 0 ) $mod146r22a1="";
$mod146r23a1=$hlavicka->mod146r23a1; if ( $hlavicka->mod146r23a1 == 0 ) $mod146r23a1="";
$mod146r24a1=$hlavicka->mod146r24a1; if ( $hlavicka->mod146r24a1 == 0 ) $mod146r24a1="";
$mod146r25a1=$hlavicka->mod146r25a1; if ( $hlavicka->mod146r25a1 == 0 ) $mod146r25a1="";
$mod146r11a2=$hlavicka->mod146r11a2; if ( $hlavicka->mod146r11a2 == 0 ) $mod146r11a2="";
$mod146r12a2=$hlavicka->mod146r12a2; if ( $hlavicka->mod146r12a2 == 0 ) $mod146r12a2="";
$mod146r13a2=$hlavicka->mod146r13a2; if ( $hlavicka->mod146r13a2 == 0 ) $mod146r13a2="";
$mod146r14a2=$hlavicka->mod146r14a2; if ( $hlavicka->mod146r14a2 == 0 ) $mod146r14a2="";
$mod146r15a2=$hlavicka->mod146r15a2; if ( $hlavicka->mod146r15a2 == 0 ) $mod146r15a2="";
$mod146r16a2=$hlavicka->mod146r16a2; if ( $hlavicka->mod146r16a2 == 0 ) $mod146r16a2="";
$mod146r17a2=$hlavicka->mod146r17a2; if ( $hlavicka->mod146r17a2 == 0 ) $mod146r17a2="";
$mod146r18a2=$hlavicka->mod146r18a2; if ( $hlavicka->mod146r18a2 == 0 ) $mod146r18a2="";
$mod146r19a2=$hlavicka->mod146r19a2; if ( $hlavicka->mod146r19a2 == 0 ) $mod146r19a2="";
$mod146r20a2=$hlavicka->mod146r20a2; if ( $hlavicka->mod146r20a2 == 0 ) $mod146r20a2="";
$mod146r21a2=$hlavicka->mod146r21a2; if ( $hlavicka->mod146r21a2 == 0 ) $mod146r21a2="";
$mod146r22a2=$hlavicka->mod146r22a2; if ( $hlavicka->mod146r22a2 == 0 ) $mod146r22a2="";
$mod146r23a2=$hlavicka->mod146r23a2; if ( $hlavicka->mod146r23a2 == 0 ) $mod146r23a2="";
$mod146r24a2=$hlavicka->mod146r24a2; if ( $hlavicka->mod146r24a2 == 0 ) $mod146r24a2="";
$mod146r25a2=$hlavicka->mod146r25a2; if ( $hlavicka->mod146r25a2 == 0 ) $mod146r25a2="";
$pdf->Cell(195,32," ","$rmc1",1,"L");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,6,"$mod545r01a1","$rmc",0,"R");$pdf->Cell(38,6,"$mod545r01a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r02a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r02a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r03a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r03a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r04a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r04a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r05a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r05a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r06a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r06a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r07a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r07a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r08a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r08a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r09a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r09a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r10a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r10a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r11a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r11a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r12a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r12a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r13a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r13a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r14a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r14a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r15a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r15a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r16a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r16a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r17a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r17a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r18a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r18a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r19a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r19a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r20a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r20a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r21a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r21a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r22a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r22a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r23a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r23a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r24a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r24a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod146r25a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod146r25a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r11a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r11a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r12a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r12a2","$rmc",1,"R");
$pdf->Cell(113,6," ","$rmc1",0,"L");
$pdf->Cell(38,7,"$mod545r99a1","$rmc",0,"R");$pdf->Cell(38,7,"$mod545r99a2","$rmc",1,"R");
                                       }

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str4.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str4.jpg',0,0,297,209);
}
$pdf->SetY(10);

//list a ico
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
$pdf->Cell(195,-2," ","$rmc1",1,"L");
$pdf->Cell(115,6," ","$rmc1",0,"L");$pdf->Cell(11,6,"1","$rmc",0,"C");$pdf->Cell(37,6," ","$rmc1",0,"L");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");
$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(9,6,"$D","$rmc",0,"C");
$pdf->Cell(8,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");
$pdf->Cell(8,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

//modul 1003
$mod1003s02=$hlavicka->mod1003s02; if ( $hlavicka->mod1003s02 == 0 ) $mod1003s02="";
$mod1003s03=$hlavicka->mod1003s03; if ( $hlavicka->mod1003s03 == 0 ) $mod1003s03="";
$mod1003s04=$hlavicka->mod1003s04; if ( $hlavicka->mod1003s04 == 0 ) $mod1003s04="";
$mod1003s05=$hlavicka->mod1003s05; if ( $hlavicka->mod1003s05 == 0 ) $mod1003s05="";
$mod1003s06=$hlavicka->mod1003s06; if ( $hlavicka->mod1003s06 == 0 ) $mod1003s06="";
$mod1003s07=$hlavicka->mod1003s07; if ( $hlavicka->mod1003s07 == 0 ) $mod1003s07="";
$pdf->Cell(195,49," ","$rmc1",1,"L");
$pdf->Cell(11,7," ","$rmc1",0,"L");$pdf->Cell(20,6,"$cslr1","$rmc",0,"C");
$pdf->Cell(32,6,"$mod1003s02","$rmc",0,"R");$pdf->Cell(33,6,"$mod1003s03","$rmc",0,"R");
$pdf->Cell(44,6,"$mod1003s04","$rmc",0,"R");$pdf->Cell(46,6,"$mod1003s05","$rmc",0,"R");
$pdf->Cell(47,6,"$mod1003s06","$rmc",0,"R");$pdf->Cell(43,6,"$mod1003s07","$rmc",1,"R");
$pdf->SetY(182);
$pdf->Cell(31,6," ","$rmc1",0,"L");$pdf->Cell(32,6,"$mod1003s02","$rmc",0,"R");
$pdf->Cell(33,6,"$mod1003s03","$rmc",0,"R");$pdf->Cell(44,6,"$mod1003s04","$rmc",0,"R");
$pdf->Cell(46,6,"$mod1003s05","$rmc",0,"R");$pdf->Cell(47,6,"$mod1003s06","$rmc",0,"R");
$pdf->Cell(43,6,"$mod1003s07","$rmc",1,"R");
                                       }

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str5.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str5.jpg',0,0,297,209);
}
$pdf->SetY(10);

//modul 1004
$mod1004s02=$hlavicka->mod1004s02; if ( $hlavicka->mod1004s02 == 0 ) $mod1004s02="";
$mod1004s03=$hlavicka->mod1004s03; if ( $hlavicka->mod1004s03 == 0 ) $mod1004s03="";
$mod1004s04=$hlavicka->mod1004s04; if ( $hlavicka->mod1004s04 == 0 ) $mod1004s04="";
$mod1004s05=$hlavicka->mod1004s05; if ( $hlavicka->mod1004s05 == 0 ) $mod1004s05="";
$mod1004s06=$hlavicka->mod1004s06; if ( $hlavicka->mod1004s06 == 0 ) $mod1004s06="";
$mod1004s07=$hlavicka->mod1004s07; if ( $hlavicka->mod1004s07 == 0 ) $mod1004s07="";
$mod1004s08=$hlavicka->mod1004s08; if ( $hlavicka->mod1004s08 == 0 ) $mod1004s08="";
$mod1004s09=$hlavicka->mod1004s09; if ( $hlavicka->mod1004s09 == 0 ) $mod1004s09="";
$pdf->Cell(195,53," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(20,6,"$cslr1","$rmc",0,"C");
$pdf->Cell(32,6,"$mod1004s02","$rmc",0,"R");$pdf->Cell(30,6,"$mod1004s03","$rmc",0,"R");
$pdf->Cell(37,6,"$mod1004s04","$rmc",0,"R");$pdf->Cell(31,6,"$mod1004s05","$rmc",0,"R");
$pdf->Cell(27,6,"$mod1004s06","$rmc",0,"R");$pdf->Cell(28,6,"$mod1004s07","$rmc",0,"R");
$pdf->Cell(32,6,"$mod1004s08","$rmc",0,"R");$pdf->Cell(28,6,"$mod1004s09","$rmc",1,"R");
$pdf->SetY(182);
$pdf->Cell(13,6," ","$rmc1",0,"L");$pdf->Cell(18,6," ","$rmc",0,"C");
$pdf->Cell(32,6,"$mod1004s02","$rmc",0,"R");$pdf->Cell(30,6,"$mod1004s03","$rmc",0,"R");
$pdf->Cell(37,6,"$mod1004s04","$rmc",0,"R");$pdf->Cell(31,6,"$mod1004s05","$rmc",0,"R");
$pdf->Cell(27,6,"$mod1004s06","$rmc",0,"R");$pdf->Cell(28,6,"$mod1004s07","$rmc",0,"R");
$pdf->Cell(32,6,"$mod1004s08","$rmc",0,"R");$pdf->Cell(28,6,"$mod1004s09","$rmc",1,"R");
                                       }

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str6.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 5
$mod5r01=$hlavicka->mod5r01; if ( $hlavicka->mod5r01 == 0 ) $mod5r01="";
$mod5r02=$hlavicka->mod5r02; if ( $hlavicka->mod5r02 == 0 ) $mod5r02="";
$mod5r03=$hlavicka->mod5r03; if ( $hlavicka->mod5r03 == 0 ) $mod5r03="";
$mod5r04=$hlavicka->mod5r04; if ( $hlavicka->mod5r04 == 0 ) $mod5r04="";
$mod5r05=$hlavicka->mod5r05; if ( $hlavicka->mod5r05 == 0 ) $mod5r05="";
$mod5r06=$hlavicka->mod5r06; if ( $hlavicka->mod5r06 == 0 ) $mod5r06="";
$mod5r07=$hlavicka->mod5r07; if ( $hlavicka->mod5r07 == 0 ) $mod5r07="";
$mod5r08=$hlavicka->mod5r08; if ( $hlavicka->mod5r08 == 0 ) $mod5r08="";
//$mod5r09=$hlavicka->mod5r09; if ( $hlavicka->mod5r09 == 0 ) $mod5r09="";
$mod5r10=$hlavicka->mod5r10; if ( $hlavicka->mod5r10 == 0 ) $mod5r10="";
$mod5r11=$hlavicka->mod5r11; if ( $hlavicka->mod5r11 == 0 ) $mod5r11="";
$mod5r12=$hlavicka->mod5r12; if ( $hlavicka->mod5r12 == 0 ) $mod5r12="";
$mod5r13=$hlavicka->mod5r13; if ( $hlavicka->mod5r13 == 0 ) $mod5r13="";
$mod5r14=$hlavicka->mod5r14; if ( $hlavicka->mod5r14 == 0 ) $mod5r14="";
$mod5r15=$hlavicka->mod5r15; if ( $hlavicka->mod5r15 == 0 ) $mod5r15="";
$mod5r16=$hlavicka->mod5r16; if ( $hlavicka->mod5r16 == 0 ) $mod5r16="";
$mod5r17=$hlavicka->mod5r17; if ( $hlavicka->mod5r17 == 0 ) $mod5r17="";
$mod5r18=$hlavicka->mod5r18; if ( $hlavicka->mod5r18 == 0 ) $mod5r18="";
$mod5r19=$hlavicka->mod5r19; if ( $hlavicka->mod5r19 == 0 ) $mod5r19="";
$mod5r20=$hlavicka->mod5r20; if ( $hlavicka->mod5r20 == 0 ) $mod5r20="";
//$mod5r21=$hlavicka->mod5r21; if ( $hlavicka->mod5r21 == 0 ) $mod5r21="";
$mod5r22=$hlavicka->mod5r22; if ( $hlavicka->mod5r22 == 0 ) $mod5r22="";
$mod5r23=$hlavicka->mod5r23; if ( $hlavicka->mod5r23 == 0 ) $mod5r23="";
$mod5r24=$hlavicka->mod5r24; if ( $hlavicka->mod5r24 == 0 ) $mod5r24="";
$mod5r25=$hlavicka->mod5r25; if ( $hlavicka->mod5r25 == 0 ) $mod5r25="";
$mod5r99=$hlavicka->mod5r99;
//if ( $hlavicka->mod5r99 == 0 ) $mod5r99="";
$pdf->Cell(195,35," ","$rmc1",1,"L");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r01","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r02","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r03","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r04","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r05","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r06","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r07","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r08","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r10","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,11,"$mod5r11","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,10,"$mod5r12","$rmc",1,"R");
$pdf->Cell(141,7," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r13","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r14","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,8,"$mod5r15","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r16","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r17","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r18","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r19","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r20","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r22","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r23","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r24","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,10,"$mod5r25","$rmc",1,"R");
$pdf->Cell(141,6," ","$rmc1",0,"L");$pdf->Cell(47,7,"$mod5r99","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
if ( $zarchivu == 0 )
     {
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_p304arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "nulujem";
$sql = "DROP TABLE F".$kli_vxcf."_statistika_p304arch ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_p304arch SELECT * FROM F".$kli_vxcf."_statistika_p304 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
}
//rok 2014
$sql = "SELECT mod82r992 FROM F$kli_vxcf"."_statistika_p304arch WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD m100065nie VARCHAR(1) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD m100065ano VARCHAR(1) NOT NULL AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD mod82r012 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD mod82r032 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD mod82r042 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_p304arch ADD mod82r992 DECIMAL(10,0) DEFAULT 0 AFTER psys";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_p304arch WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "INSERT INTO F".$kli_vxcf."_statistika_p304arch SELECT * FROM F".$kli_vxcf."_statistika_p304 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
//echo $sql;
    }
?>
<script type="text/javascript">
  var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac
?>

<?php
$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>