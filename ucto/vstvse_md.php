<!doctype html>
<html>
<?php

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'UCT';
$urov = 1100;
$cslm=101300;
if( $copern == 10 ) $urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
//echo "nemazat=".$kli_nemazat;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvuct = include("../ucto/vtvuct.php");
endif;

$sql = "SELECT ddu FROM F$kli_vxcf"."_uctban";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD ddu DATE NOT NULL AFTER dok ";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" SET ddu=dat WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ";
$oznac = mysql_query("$sqtoz");

               }

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

// druh pohybu 1=odber , 2=dodav
$drupoh = strip_tags($_REQUEST['drupoh']);

if( $autovalas == 1 AND $drupoh >= 1 AND $drupoh <= 2 AND ( $kli_uzid == 53 OR $kli_uzid == 54 ) ) $nemazat=0;

//nastavenie uctu
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
if(!isset($hladaj_uce) OR $hladaj_uce == '')
{
if( $drupoh == 1 OR $drupoh == 2 )
{
$sqluce = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 1 ) ORDER BY dpok");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dpok;
  }
}
if( $drupoh == 3 )
{
$sqluce = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 2 ) ORDER BY dpok");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dpok;
  }
}
if( $drupoh == 4 )
{
$sqluce = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dban;
  }
}
if( $drupoh == 5 )
{
  $hladaj_uce=1;
}

}
//koniec nastavenia uctu


if( $drupoh == 1 )
{
$tabl = "pokpri";
$cisdok = "pokpri";
$adrdok = "pokprijem";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 2 )
{
$tabl = "pokvyd";
$cisdok = "pokvyd";
$adrdok = "pokvydaj";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 3 )
{
$tabl = "doppokpri";
$cisdok = "xdp05";
$adrdok = "doppokprijem";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 4 )
{
$tabl = "banvyp";
$cisdok = "uctx04";
$adrdok = "banvyp";
$uctpol = "uctban";
$uctpoh = "uctban";
}
if( $drupoh == 5 )
{
$tabl = "uctvsdh";
$cisdok = "uctx05";
if( $hladaj_uce == 2 ) $cisdok = "uctx13";
$adrdok = "vsdh";
$uctpol = "uctvsdp";
$uctpoh = "uctvsdp";
}

$uloz="NO";
$zmaz="NO";
$uprav="NO";


// 16=vymazanie dokladu potvrdene v vspk_u.php
if ( $copern == 16 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpol WHERE dok='$cislo_dok' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpoh WHERE dok='$cislo_dok' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE dok='$cislo_dok' ");
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";

if( ( $cisdokodd != 1 AND $cislo_dok > 1 ) OR $drupoh == 5 )
        {
$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$cislo_dok' WHERE $cisdok > '$cislo_dok'");
        }
if( $cisdokodd == 1 AND $drupoh != 5 )
        {

 if( $drupoh == 1 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 2 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cvyd='$cislo_dok' WHERE cvyd > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 3 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 2 AND dpok = $hladaj_uce"; }
 if( $drupoh == 4 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dban SET cban='$cislo_dok' WHERE cban > '$cislo_dok' AND dban = $hladaj_uce"; }
 //echo $upravtt;
 $upravene = mysql_query("$upravttt");
        }

//ak jedna rada pokladne zapis aj v druhom druhu dokladu prij.vyd
if( $pvpokljed == 1 AND $drupoh >= 1 AND $drupoh <= 2 )
{
 if( $drupoh == 2 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 1 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cvyd='$cislo_dok' WHERE cvyd > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }

 $upravene = mysql_query("$upravttt");
}
//koniec ak jedna rada pokladne zapis aj v druhom druhu dokladu prij.vyd

//echo "POLOéKA DOK:$cislo_dok BOLA VYMAZAN¡ ";
endif;

//pre vacsiu rychlost nemazem pracovny ak vymazavam doklad include("../ucto/saldo_zmaz_uhr.php");
     }
//koniec vymazania


// aktualna strana
$page = strip_tags($_REQUEST['page']);
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
if( $copern == 9 ) $pols = 900;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>
<head>
<meta charset="cp1250">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="../css/material.min.css">
<link rel="stylesheet" href="../css/material_edit.css">
<link rel="stylesheet" href="../css/material_list_layout.css">
<title>VöeobecnÈ doklady | EuroSecom</title>
<style>
/* list layout */
.ui-list th:nth-child(1), .ui-list td:nth-child(1) {
  width: 6%;
  text-align: left;
}
.ui-list th:nth-child(2), .ui-list td:nth-child(2) {
  width: 20%;
  text-align: left;
}
.ui-list th:nth-child(3), .ui-list td:nth-child(3) {
  width: 8%;
  text-align: left;
}
.ui-list th:nth-child(4), .ui-list td:nth-child(4) {
  width: 25%;
  text-align: left;
}
.ui-list th:nth-child(5), .ui-list td:nth-child(5) {
  width: 10%;
  text-align: right;
}
.ui-list th:nth-child(6), .ui-list td:nth-child(6) {
  width: 16%;
  text-align: right;
}
.ui-list th:nth-child(7), .ui-list td:nth-child(7) {
  width: 15%;
  text-align: right;
  padding-right: 0;
}
.ui-list td:nth-child(1), .ui-list td:nth-child(5) {
  /*color: rgba(0,0,0,.54);*/
}
</style>
</head>
<body onload="ObnovUI(); VyberVstup();">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header">
<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 7 && $copern != 9 AND $copern != 10 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
  {
//[[[[[

$sql = mysql_query("SELECT ume, uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dok > 0 AND F$kli_vxcf"."_$tabl.ume >= $kli_vume )".
" OR ( isnull( F$kli_vxcf"."_$tabl.ume) AND F$kli_vxcf"."_$tabl.uce = $hladaj_uce ) ".
" OR ( isnull( F$kli_vxcf"."_$tabl.dat) AND F$kli_vxcf"."_$tabl.uce = $hladaj_uce ) OR isnull( F$kli_vxcf"."_$tabl.uce) OR  F$kli_vxcf"."_$tabl.uce = '' ".
" GROUP BY dok ORDER BY dok DESC".
"");

  }
// zobraz hladanie vo vsetkych prijemkach
if ( $copern == 9 )
  {

$hladaj_nai = strip_tags($_REQUEST['hladaj_nai']);
$hladaj_dok = strip_tags($_REQUEST['hladaj_dok']);
$hladaj_dat = strip_tags($_REQUEST['hladaj_dat']);
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
$hladaj_txp = strip_tags($_REQUEST['hladaj_txp']);

if ( $hladaj_txp != "" ) {

$sqltx = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND txp LIKE '%$hladaj_txp%' ".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltx");

                        }


if ( $hladaj_nai != "" ) {

$hladaj_ico = 1*$hladaj_nai;

$sqltx = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND ( F$kli_vxcf"."_ico.nai LIKE '%$hladaj_nai%' OR F$kli_vxcf"."_ico.ico = $hladaj_ico )".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltx");

                        }


if ( $hladaj_dat != "" ) {

$chladaj_dat=1*$hladaj_dat;
if( $chladaj_dat == 1 OR $chladaj_dat == 2 OR $chladaj_dat == 3 OR $chladaj_dat == 4 OR $chladaj_dat == 5 OR $chladaj_dat == 6 OR $chladaj_dat == 7 OR $chladaj_dat == 8 OR $chladaj_dat == 9 OR $chladaj_dat == 10 OR $chladaj_dat == 11 OR $chladaj_dat == 12 )
{ $hladaj_dat=$chladaj_dat.".".$kli_vrok; }

    if( strlen($hladaj_dat) == 6 OR strlen($hladaj_dat) == 7 )
         {
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.ume = $hladaj_dat ".
" ORDER BY dok DESC".
"";
         }

    if( strlen($hladaj_dat) != 6 AND strlen($hladaj_dat) != 7 )
         {
         $datsql = SqlDatum($hladaj_dat);
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dat = '$datsql' ".
" ORDER BY dok DESC".
"";

         }

//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if ( $hladaj_dok != "" ) {

$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dok = '$hladaj_dok' ".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltt");
}

  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;

//searching period
if( $hladaj_dat == '' ) $hladaj_dat=$kli_vume;
$pole = explode(".", $hladaj_dat);
$mesiac_dat=1*$pole[0];
$rok_dat=1*$pole[1];
$mesiac_dap=$mesiac_dat-1;
if( $mesiac_dap == 0 ) $mesiac_dap=1;
$mesiac_dan=$mesiac_dat+1;
if( $mesiac_dan > 12 ) $mesiac_dan=12;
$kli_pume=$mesiac_dap.".".$rok_dat;
$kli_nume=$mesiac_dan.".".$rok_dat;
?>
<script>


</script>

<form name="formhl1" method="post" action="vstvse.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=9">
  <div class="mdl-layout__header-row ui-header-title-row">
    <ol class="mdl-layout-title ui-header-breadcrumb">
    <li class="breadcrumb-item">
      <a href="#" onclick="Ucto();">⁄ËtovnÌctvo</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="#" id="header_dropdown_menu" class="dropdown">VöeobecnÈ doklady</a>
      <select name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce; ?>" onchange="dajuce();" autofocus class="select-btn toleft">
        <option value="1">Druh Ë.1</option>
        <option value="2">Druh Ë.2</option>
      </select>
    </li>
<!-- header dropdown nav menu -->
    <li class="wrap-dropdown-menu">
      <ul for="header_dropdown_menu" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
        <li onclick="" class="mdl-menu__item active">VöeobecnÈ doklady</li>
        <li onclick="" class="mdl-menu__item">Druhy dokladov</li>
      </ul>
    </li>
    </ol><!-- .ui-header-breadcrumb -->
    <div class="mdl-layout-spacer"></div>

    <button id="searching" onclick="Searching();" class="mdl-button mdl-js-button mdl-button--icon toleft" style="margin: 0 2px;">
      <i class="material-icons">search</i>
    </button>
      <span data-mdl-for="header_more_tool" class="mdl-tooltip">Hæadaù</span>
<a href="#" onClick="Precisluj();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="PreËÌslovanie dokladov podæa d·tumu za˙Ëtovania ( 2010/2011 ) " title="PreËÌslovanie dokladov podæa d·tumu za˙Ëtovania ( 2010/2011 ) " ></a>

<!-- period nav -->
    <div class="clearfix" style="margin-right: 16px;">
      <button type="button" id="month_prev" onclick="navMonth(1);" class="mdl-button mdl-js-button mdl-button--icon toleft" style="background-color: ;">
        <i class="material-icons">navigate_before</i>
      </button>
        <span class="mdl-tooltip" data-mdl-for="month_prev">Prejsù na <?php echo $kli_pume; ?></span>
      <button type="button" id="month_next" onclick="navMonth(2);" class="mdl-button mdl-js-button mdl-button--icon toleft" style="background-color: ;">
        <i class="material-icons">navigate_next</i>
      </button>
        <span class="mdl-tooltip" data-mdl-for="month_next">Prejsù na <?php echo $kli_dume; ?></span>
      <div class="toleft" style="font-size: 14px; line-height: 32px; margin-left: 4px;"><?php echo $kli_vume; ?></div>
    </div>
<!-- login firm + user -->
    <ul class="ilogin-inline-list">
      <li class="ilogin-list-item"><?php echo "<strong>$kli_vxcf</strong>&nbsp;&nbsp;$kli_nxcf"; ?></li>
      <li id="ilogin_user" class="mdl-color--indigo-400 ilogin-list-item item-avatar"><?php echo $kli_uzid; ?></li>
    </ul>
      <span data-mdl-for="ilogin_user" class="mdl-tooltip">Prihl·sen˝ uûÌvateæ:<br><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid"; ?></span>

<!-- <input type="text" name="hladaj_dok" id="hladaj_dok" size="8" value="<?php echo $hladaj_dok;?>"/>
<input type="text" name="hladaj_dat" id="hladaj_dat" size="8" value="<?php echo $hladaj_dat;?>" onkeyup="CiarkaNaBodku(this);"/>
<input type="text" name="hladaj_nai" id="hladaj_nai" size="30" value="<?php echo $hladaj_nai;?>"/>
<input type="text" name="hladaj_txp" id="hladaj_txp" size="30" value="<?php echo $hladaj_txp;?>"/>
<INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" >
<form name="formhl2" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1">
<INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" >
</form> -->

  </div><!-- .ui-header-title-row -->
</form>
  <div class="mdl-layout__header-row wrap-ui-list" style="background-color: ;">
    <table class="ui-list-header ui-list ui-container">
    <tr>
      <th>Druh</th>
      <th>Doklad</th>
      <th>Vystaven˝
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
      </th>
      <th>Firma</th>
      <th>⁄Ëel</th>
      <th>Hodnota</th>
      <th></th>
    </tr>
    </table><!-- .ui-list-header -->
  </div><!-- .wrap-ui-list -->
</header>
<main class="mdl-layout__content ui-content sticky-footer">
<div class="wrap-ui-list">
  <table class="ui-list-content ui-list ui-container">
<?php
   while ($i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
  <tr class="ui-row-echo">
    <td><?php echo $riadok->uce;?></td>
    <td>
<?php
$uctminusdok=$riadok->hodu-$riadok->hod;
  if ( $sysx == 'UCT' )
  {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/zoznam.png' width=15 height=12 border=0 alt="Roz˙Ëtovanie dokladu" title="Roz˙Ëtovanie dokladu" ></a>
<?php
  }
?>
<?php echo $riadok->dok; ?>
    </td>
    <td><?php echo $riadok->dat; ?></td>
    <td><?php echo $riadok->ico; ?> <?php echo $riadok->nai; ?></td>
    <td><?php echo $riadok->txp; ?></td>
    <td><?php echo $riadok->hodu; ?></td>
    <td>
      <button type="button" id="view<?php echo $riadok->dok; ?>" onclick="viewItem(<?php echo $riadok->dok; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-layout--large-screen-only">
        <i class="material-icons">print</i>
      </button>
        <span data-mdl-for="view<?php echo $riadok->dok; ?>" class="mdl-tooltip">Zobraziù v PDF</span>
<?php
if( $copern != 10 AND $kli_nemazat != 1 )
{
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranÈho dokladu" title="Vymazanie vybranÈho dokladu" ></a></td></a>
<?php
}
?>
<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.pdf"))
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.pdf' target="_blank">
<img src='../obr/pdf.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.jpg") AND $jesub == 0 )
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.jpg' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.bmp") AND $jesub == 0 )
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.bmp' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.gif") AND $jesub == 0 )
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.gif' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.png") AND $jesub == 0 )
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.png' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu  dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
}
?>
    </td>
  </tr><!-- .ui-row-echo -->
<?php
  }
$i = $i + 1;
   }
?>
  </table> <!-- .ui-list-content -->
<form name="forma3" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=<?php echo $rozuct; ?>&copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $xstr;?>" style="visibility: hidden;">
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
  <div class="ui-list-footer ui-list ui-container">





</form>
<FORM name="forma2" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $ppage;?>" style="visibility: hidden;">
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>

<FORM name="forma1" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $npage;?>" style="visibility: hidden;">
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
  </div><!-- .ui-list-footer -->
</div><!-- .wrap-ui-list -->

<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,7,9

//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Doklad DOK=<?php echo $cislo_dok;?> vymazan˝</span>







<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer ui-container">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo mdl-color-text--grey-500">© 2018 EuroSecom</div>
  </div>
</footer>
</main>

<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">Title</span>
  <nav class="mdl-navigation">
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
    <a class="mdl-navigation__link" href="">Link</a>
  </nav>
</div>



<!-- new item button -->
<button type="button" id="new_item" onclick="window.open('vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1');" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored mdl-js-ripple-effect mdl-shadow--4dp">
  <i class="material-icons">add</i>
</button>
  <span data-mdl-for="new_item" class="mdl-tooltip mdl-tooltip--left">Vytvoriù nov˝ doklad</span>


<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>
</div><!-- .mdl-layout -->

<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami
     }
if( $copern == 1 ) {
$zmenume=1;
$odkaz="../ucto/vstpok.php?copern=1&drupoh=$drupoh&page=1&sysx=$sysx&hladaj_uce=$hladaj_uce&rozuct=$rozuct";
                   }
//echo $odkaz;

//$cislista = include("uct_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<SCRIPT Language="JavaScript" Src="../js/cookies.js"></SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

      function dajuce()
      {

  var ucet = document.formhl1.hladaj_uce.value;
<?php if( $sysx != 'UCT' ) { ?>
  var okno = window.open("vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=" + ucet + "&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
<?php if( $sysx == 'UCT' ) { ?>
  var okno = window.open("vstpok.php?sysx=UCT&hladaj_uce=" + ucet + "&rozuct=ANO&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
      }

// Kontrola cisla celeho v rozsahu x az y
      function intg(x1,x,y,Oznam)
      {
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true;
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              }
             }
      }

// Kontrola des.cisla v rozsahu x az y
      function cele(x1,x,y,Oznam)
      {
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (b>=x && b<=y) return true;
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              }
             }
      }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nai.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//hladanie
  if ( $copern == 9 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
    }

<?php
  }
//koniec hladania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 10 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>





<?php if( $_SESSION['nieie'] >= 0 )  { ?>

    function VytlacPokl(doklad)
    {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
    var cislo_dok = doklad;
    window.open('vspk_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }


    function PoklKniha()
    {

    var ucet = document.formhl1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function MesPoklKniha()
    {

    var ucet = document.formhl1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=0&rozuct=<?php echo $rozuct; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }


    function DnesPoklKniha()
    {

<?php $dnesne = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>

window.open('../ucto/uctpohyby_dokxxl.php?uctpohyby=1&cislo_uce=<?php echo $hladaj_uce; ?>&h_obdk=0&h_obdp=0&h_datk=<?php echo $dnesne; ?>&h_datp=<?php echo $dnesne; ?>&copern=40&drupoh=11&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
    }


<?php if ( $drupoh == 1 )  { ?>
    function ZoznamPokl()
    {
    var ucet = document.formhl1.hladaj_uce.value;
    window.open('../ucto/zozdok.php?copern=103&drupoh=1&page=1&cislo_uce=' + ucet + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }
<?php  } ?>

<?php if ( $drupoh == 2 )  { ?>
    function ZoznamPokl()
    {
    var ucet = document.formhl1.hladaj_uce.value;
    window.open('../ucto/zozdok.php?copern=104&drupoh=2&page=1&cislo_uce=' + ucet + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }
<?php  } ?>

<?php                                } ?>



    function Precisluj()
    {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
if( hladaj_dok == 2010 || hladaj_dok == 2011 )
  {
window.open('../ucto/precisluj_pok.php?cislo_uce=<?php echo $hladaj_uce; ?>&copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&kontrola=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
    }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  </script>
</body>
</html>
