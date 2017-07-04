<!doctype html>
<html>
<?php
$sys = 'ALL';
$urov = 15000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if ( $newdelenie == 1 )
          {
$dtb2 = include("../oddel_dtb3new.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 0 ) { $copern = 1; }
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) { $strana = 1; }

$server_name = $_SERVER['SERVER_NAME'];

$uprav = 1*$_REQUEST['uprav'];
$cislo_xcf = 1*$_REQUEST['cislo_xcf'];
$hladanie = 1*$_REQUEST['hladanie'];
$cohladat = trim($_REQUEST['cohladat']);
if( $cohladat == '' ){ $hladanie=0; }
//echo $cohladat."<br />";

$kopkli=0;
$zmazane=0;

//uprava
if ( $copern == 8 AND $uprav == 1 )
  {

$h_naz = strip_tags($_REQUEST['h_naz']);
$h_rok = 1*strip_tags($_REQUEST['h_rok']);
$h_duj = 1*strip_tags($_REQUEST['h_duj']);
$h_dtb = strip_tags($_REQUEST['h_dtb']);
$h_prav = strip_tags($_REQUEST['h_prav']);

$upravttt = "UPDATE fir SET naz='$h_naz', rok='$h_rok', duj='$h_duj' WHERE xcf = $cislo_xcf  ";
$upravene = mysql_query("$upravttt");
//echo $upravttt."<br />";

$copern=1;
$uprav=0;
$cislo_xcf=0;
$kopkli=1;
     }
//koniec uprava

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlttt = "SELECT * FROM fir WHERE xcf = $cislo_xcf ";
$sqldok = mysql_query("$sqlttt");
//echo $sqlttt;
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $h_xcf=$riaddok->xcf;
 $h_naz=$riaddok->naz;
 $h_rok=$riaddok->rok;
 $h_duj=$riaddok->duj;
 $h_dtb=$riaddok->dtb;
 $h_prav=$riaddok->prav;
 }

     }
//koniec nacitaj udaje

if( $newdelenie == 1 AND $kopkli == 1 )
          {

if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2017."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2018."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2019."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2015 AND $mysqldb2015 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2015."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2015.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2015.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2014 AND $mysqldb2014 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2014."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2014.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2014.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2013 AND $mysqldb2013 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2013."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2013.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2013.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2012 AND $mysqldb2012 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2012."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2012.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2012.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2011 AND $mysqldb2011 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2011."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2011.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2011.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2010 AND $mysqldb2010 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2010."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2010.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2010.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }


          }
//if( $newdelenie == 1 )

?>
<head>
  <meta charset="cp1250">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material.css">
  <!-- <link rel="stylesheet" href="css/material_edit.css"> -->
  <title>Firmy | EuroSecom</title>
<style>
html {
  box-sizing: border-box; /* width + padding + border */
}
*, *:after, *:before {
  box-sizing: inherit;
}
body {
  font-family: 'Roboto', 'Helvetica', 'Arial', sans-serif;
  line-height: 1;
}
a {
  text-decoration: none;
  display: inline-block;
}
table {
  border-collapse: collapse;
  width: 100%;
  /*background-color: red;*/
}
.right {
  text-align: right;
}
.left {
  text-align: left;
}
.center {
  text-align: center;
}
.tocenter {
  margin: auto;
}
.toleft {
  float: left;
}
.toright {
  float: right;
}
/* prasarna */
.mdl-layout__header-row {
  padding: 0 24px 0 80px;
}
/* prasarna */
.mdl-layout--no-drawer-button .mdl-layout__header-row {
  padding-left: 24px;
}




.ui-header .mdl-layout__drawer-button {
  margin: 0 8px;
  width: 40px;
  height: 40px;
  line-height: 1;
  background-color: transparent;
  min-height: 40px;
  max-height: 40px;
  padding-top: 8px;
}
.ui-header-three-row .mdl-layout__header-row:not(.ui-header-page-row) {
  height: 40px;
}
.ui-header-three-row.is-compact {
  max-height: 136px;
}



.ui-header-app-row .mdl-layout-title {
  font-size: 12px;
  /*font-weight: 400;*/
}
.ui-header-page-row {
  height: 56px;
  padding: 0 20px 0 56px;
}
.ui-header-page-row .mdl-layout-title {
  font-size: 18px;
}

.material-icons.md-18 { font-size: 18px; }

.mdl-textfield__label:after {
  /*background-color: transparent;*/
}

/* prasarna */
.mdl-tooltip {
  font-size: 11px;
  letter-spacing: 0.02em;
  padding: 12px;
  max-width: 300px;
  text-transform: none;

}



.dropdown-menu > li {
  height: 40px;
  line-height: 40px;
}



.flexbox {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}


.ukaz {
  outline: 1px solid red;
  border: 1px solid red;
}


.ui-table th {
  font-size: 11px;
  font-weight: 500;
  line-height: 1.2;
  box-sizing: border-box;
  text-overflow: ellipsis;
  position: relative;
  height: 40px;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  padding: 0 0 0 0;
}

.ui-table th:first-of-type {
  padding-left: 24px;
}
.ui-table th:last-of-type {
  padding-right: 24px;
}


.ui-table .row-echo:hover {
  background-color: #eeeeee;
}



.ui-table tr:last-of-type td {
  border: 0;
}


.ui-table tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
  border-top: 1px solid rgba(0, 0, 0, 0.12);
}
.ui-table tr:first-of-type {
  border-top-color: rgba(0, 0, 0, 0);
}
.ui-table tr:last-of-type {
  /*border-bottom-color: rgba(0, 0, 0, 0);*/
}

.ui-table .row-form td:first-of-type:before {
  background-color: #39f;
  width: 3px;
  display: inline-block;
  height: 100%;
  content: '';
  position: absolute;
  left: 0;
  top: 0;
}

.ui-table td {
  /*height: 42px;*/
  height: 40px;

  font-size: 13px;
  color: rgba(0,0,0, 0.87);

  line-height: 1.2;
  vertical-align: middle;
  position: relative;
  padding: 0;
}
.ui-table td:first-of-type {
  padding-left: 24px;
}
.ui-table td:last-of-type {
  padding-right: 24px;

}
.ui-table th > .material-icons {
  /*position: absolute;*/
}

.search-box {
  border-radius: 2px;
  height: 40px;
  width: 300px;
  padding: 4px 48px;
}
.search-box > * {
  opacity: .7;

}

.search-box.is-focused .mdl-textfield__label:after {
  visibility: hidden;
}
.search-box .mdl-button--icon {
  position: absolute;
}
.search-box.is-focused > * {
  opacity: 1;

}

</style>
</head>
<body onload="ObnovUI();">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-drawer-button">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header ui-header-three-row">
<div class="mdl-layout__header-row mdl-color--light-blue-700 ui-header-app-row">
  <a href="http://www.edcom.sk/web/eurosecom.html" target="_blank" class="mdl-layout-title mdl-color-text--yellow-A100">EuroSecom</a>&nbsp;
  <span class="mdl-layout-title mdl-color-text--blue-grey-50"><?php echo $server_name; ?></span>
  <div class="mdl-layout-spacer"></div>
  <button id="appsmenubtn" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-grey-100" style=""><i class="material-icons">apps</i></button>
  <div class="mdl-list header-list" style="margin-left: 8px;  ">
    <div class="mdl-list__item mdl-color-text--blue-grey-100 " style="min-height: 40px; padding: 0; ">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md" style="font-size: 24px; height: 24px; line-height: 24px; width: 24px; margin-right: 6px;">person</i>
      <span class="mdl-color-text--blue-grey-100" style="font-size: 12px; letter-spacing: 0.02em;"><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid";?></span>
    </div>
  </div>
</div> <!-- .ui-header-app-row -->
<div class="mdl-layout__header-row mdl-color--light-blue-600 ui-header-page-row">
  <span id="headertitle" class="mdl-layout-title" style="cursor: pointer;">»ÌselnÌk firiem<i class="material-icons" style="vertical-align: -6px;">arrow_drop_down</i></span>
  <span class="mdl-layout-title mdl-color-text--yellow-A100">
<?php
if ( $copern == 5 ) { echo "| nov· firma"; }
if ( $copern == 6 ) { echo "| vymazanie firmy"; }
if ( $copern == 8 ) { echo "| ˙prava firmy"; }
?>
  </span>
  <div class="mdl-layout-spacer"></div>

<form method="post" action="" id="" name="">
  <div class="mdl-textfield mdl-js-textfield mdl-color--light-blue-500 search-box">
    <button id="searchbtn" class="mdl-button mdl-js-button mdl-button--icon" style="bottom: 4px; left: 8px; "><i class="material-icons" style="">search</i></button>
    <input type="text" id="" name="" value="" class="mdl-textfield__input" style="border:0; font-size: 14px; height: 32px; background-color: ;    width: 100%;   ">
    <label for="" class="mdl-textfield__label mdl-color-text--white"  style="font-size: 14px; top: 6px; left: 48px; height: 32px; line-height: 32px; width: 204px; background-color: ;">Hæadaù v ËÌselnÌku</label>
    <button id="resetsearchbtn" class="mdl-button mdl-js-button mdl-button--icon" style="bottom: 4px; right: 8px; "><i class="material-icons">close</i></button>
  </div>
</form>

  <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-color--white mdl-color-text--blue-grey-400" style="margin-left: 24px;"><i class="material-icons">add</i>&nbsp;Firma</button>





</div> <!-- .ui-header-page-row -->

<div class="mdl-layout__header-row mdl-color--light-blue-600" style="padding-left: 0; padding-right: 0;">
  <div class="wrap-ui-table tocenter" style="max-width: 1080px;  width: 100%;  background-color: ;">
  <table class="ui-table">
  <tr>
    <th class="left" style="width: 8%;">»Ìslo</th>
    <th class="left" style="width: 47%;">N·zov</th>
    <th class="right" style="width: 10%;">Obdobie</th>
    <th class="right" style="width: 15%;">Druh&nbsp;<i id="druhfirm" class="material-icons md-18" style="vertical-align: -5px;">info_outline</i>
    </th>
    <th style="width: 20%;">&nbsp;</th>
  </tr>
  </table>
  </div>
</div>
</header>

<ul for="headertitle" class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-color--white dropdown-menu" style="top:-23px;">
  <li class="mdl-menu__item" onclick="Domena();">DomÈna</li>
  <li class="mdl-menu__item" onclick="Uzivatelia();">»ÌselnÌk uûÌvateæov</li>
  <li class="mdl-menu__item mdl-color-text--light-blue-600" onclick="Firmy();" style="">»ÌselnÌk firiem</li>
</ul>

<span class="mdl-tooltip" data-mdl-for="appsmenubtn">EuroSecom podsystÈmy</span>
<!-- <span class="mdl-tooltip" data-mdl-for="printlist">Zobraziù ËÌselnÌk</span> -->

<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="appsmenubtn" style="padding: 24px; width: 224px; ">
  <li class="mdl-menu__item toleft" style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; ">account_balance</i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">⁄ËtovnÌctvo</div>
  </li>
  <li class="mdl-menu__item " style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; ">euro_symbol</i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">Mzdy</div>
  </li>
  <li class="mdl-menu__item toleft" style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; "></i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">Odbyt</div>
  </li>
  <li class="mdl-menu__item " style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; "></i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">Sklad</div>
  </li>
  <li class="mdl-menu__item toleft" style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; ">business</i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">Majetok</div>
  </li>
  <li class="mdl-menu__item " style="width: 88px; height: 88px; padding: 0;   line-height: unset;">
    <div class="center " style="width: 100%; height: 64px; padding: 8px 0;    ">
      <i class="material-icons mdl-color-text--blue-grey-300 " style="font-size: 48px; "></i>
      <i class="material-icons mdl-color-text--blue-grey-200" style="font-size: 18px; position: absolute; top: 0; right: 0;">open_in_new</i>
    </div>
    <div class="mdl-color-text--blue-grey-400 center" style="width: 100%; height: 24px; ">Anal˝zy</div>
  </li>
</ul>

<span class="mdl-tooltip" data-mdl-for="resetsearchbtn">Vymazaù vyhæad·vanie</span>
<span data-mdl-for="druhfirm" class="mdl-tooltip">0 = PodvojnÈ ˙ËtovnÌctvo<br>1 = NO podvojnÈ ˙ËtovnÌctvo<br>9 = JednoduchÈ ˙ËtovnÌctvo</span>

  <span class="mdl-tooltip" data-mdl-for="searchbtn">Hæadaù</span>


<main class="mdl-layout__content mdl-color--blue-grey-50" style="padding: 0 0 50px 0; ">
<?php
$sqltt = "SELECT * FROM fir WHERE xcf >= 0 ORDER BY xcf ";
if( $hladanie == 1 )
{
$sqltt = "SELECT * FROM klienti WHERE  xcf >= 0  AND ( naz LIKE '%$cohladat%' OR rok LIKE '%$cohladat%' ) ORDER BY xcf ";
}
$sql = mysql_query("$sqltt");
//$sql = mysql_query("SELECT * FROM fir WHERE xcf < 0 ORDER BY xcf ");//prazdny zoznam
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 10;
if( $hladanie == 1 ){ $pols = 900; }
// pocet stran
$xstr =ceil($cpol / $pols);
$npage = $strana + 1;
// predchadzajuca strana
$ppage = $strana - 1;
if( $ppage == 0 ) { $ppage=1; }
if( $npage > $xstr ) { $npage=$xstr; }
// zaciatok cyklu
$i = ( $strana - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($strana-1))+($pols-1);
?>
<?php if ( $cpol == 0 ) { ?>
<!-- empty state -->
<div class="no-item " style="  margin: 12% auto 5%; width: 300px; height: 120px; text-align: center;">
  <i class="material-icons mdl-color-text--grey-400" style="font-size: 64px;">sentiment_dissatisfied</i>
  <div class="mdl-color-text--grey-600" style="letter-spacing: 0.02em; font-size: 16px;  font-weight: 500; padding-top: 32px;">»ÌselnÌk je pr·zdny</div>
</div>
<?php                   } ?>

<div id="tablelayout" class="mdl-color--white">
  <div class="wrap-ui-table tocenter" style="max-width: 1080px; background-color: ;">
<form method="post" action="firms_md.php?copern=8&strana=<?php echo $strana; ?>&cislo_xcf=<?php echo $cislo_xcf; ?>&uprav=<?php echo $uprav; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>" id="formv" name="formv">
  <table class="ui-table">
  <colgroup>
    <col style="width:8%;">
    <col style="width:47%;">
    <col style="width:10%;">
    <col style="width:15%;">
    <col style="width:20%;">
  </colgroup>
<?php
   while ( $i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>



<?php if ( $riadok->xcf != $cislo_xcf ) { ?>
<!-- row echo -->
  <tr class="row-echo" style="background-color: ; ">
    <td class=""><?php echo $riadok->xcf; ?></td>
    <td ><?php echo $riadok->naz; ?></td>
    <td class="right"><?php echo $riadok->rok; ?></td>
    <td class="right"><?php echo $riadok->duj; ?></td>
    <td class="right">
      <button type="button" id="edit<?php echo $riadok->xcf; ?>" onclick="upravXcf(<?php echo $riadok->xcf; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
<div data-mdl-for="edit<?php echo $riadok->xcf; ?>" class="mdl-tooltip">Upraviù</div>
      <button type="button" id="copy<?php echo $riadok->xcf; ?>" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons ">content_copy</i></button>
<div data-mdl-for="copy<?php echo $riadok->xcf; ?>" class="mdl-tooltip">KopÌrovaù</div>
      <button type="button" id="remove<?php echo $riadok->xcf; ?>" onclick="" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons ">remove</i></button>
<div data-mdl-for="remove<?php echo $riadok->xcf; ?>" class="mdl-tooltip">Vymazaù</div>
    </td>
  </tr>

<?php                                    } ?>

<?php  if ( $uprav != 0 AND $riadok->xcf == $cislo_xcf ) { ?>
<!-- row edit/delete/new -->
  <tr class="mdl-color--white mdl-shadow--2dp row-form" style=" ">
    <td style="vertical-align: top;">
      <div class="mdl-textfield mdl-js-textfield" style="width: 80%;">
        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="h_xcf" name="h_xcf" value="<?php echo $riadok->xcf; ?>" disabled>
        <label class="mdl-textfield__label" for="h_xcf">Number...</label>
        <span class="mdl-textfield__error">Input is not a number!</span>
      </div>
    </td>
    <td>
      <div class="mdl-textfield mdl-js-textfield " style="width: 80%;">
        <input class="mdl-textfield__input" type="text" id="h_naz" name="h_naz" autofocus required>
        <label class="mdl-textfield__label" for="h_naz">N·zov firmy</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style=" width: auto;">
        <input class="mdl-textfield__input" type="text" id="">
        <label class="mdl-textfield__label" for="">dtb</label>
      </div>&nbsp;&nbsp;
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style=" width: auto;">
        <input class="mdl-textfield__input" type="text" id="">
        <label class="mdl-textfield__label" for="">prav</label>
      </div>
    </td>
    <td class="right" style="vertical-align: top;">
      <div class="mdl-textfield mdl-js-textfield" style="width: auto;">
        <select name="h_rok" id="h_rok" class="mdl-textfield__input" required>
          <option value="2017">2017</option>
          <option value="2016">2016</option>
          <option value="2015">2015</option>
          <option value="2014">2014</option>
          <option value="2013">2013</option>
          <option value="2012">2012</option>
          <option value="2011">2011</option>
          <option value="2010">2010</option>
        </select>
        <label for="h_rok" class="mdl-textfield__label">Obdobie</label>
      </div>
    </td>
    <td class="right" style="vertical-align: top;">
      <div class="mdl-textfield mdl-js-textfield" style="width: auto;">
        <select name="h_duj" id="h_duj" class="mdl-textfield__input" required>
          <option value="0">0 = P⁄</option>
          <option value="1">1 = NO P⁄</option>
          <option value="9">9 = J⁄</option>
        </select>
        <label for="h_duj" class="mdl-textfield__label">Druh</label>
      </div>
    </td>
    <td class="right" style="">
      <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
      <button type="button" id="edit-closer" onclick="closeXcf(<?php echo $riadok->xcf; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-700 " style=""><i class="material-icons">close</i></button>
      <div data-mdl-for="edit-closer" class="mdl-tooltip">Zavrieù</div>
    </td>
    <td colspan="3">&nbsp;</td>
  </tr>
<?php                                                    } ?>

<?php
  }
$i = $i + 1;
   }
?>
  </table>
</form>
<form name="forma3" id="forma3" action="#" style="">
  <div class="mdl-color-text--grey-600 flexbox ui-table-pagination " style="height: 40px;  font-size: 12px; background-color: ; justify-content: space-between; align-items: center; ">
    <span class="">= <?php echo $cpol; ?></span>
    <div>
      <label for="selectpage" class="" style="margin-right: 24px;">Strana
      <select name="selectpage" id="selectpage" onchange="ChodNaStranu();" style="font-size: 12px; border: 0; color: rgba(0,0,0, 0.87); border-bottom: 1px solid rgba(0,0,0,0.12); background-color: transparent; min-width: 32px; padding-bottom: 2px; padding-top: 4px; margin: 0 7px;">
<?php
$is = 1;
while ( $is <= $xstr )
{
?>
<option value="<?php echo $is; ?>"><?php echo $is; ?></option>
<?php
$is = $is + 1;
}
?>
      </select>
      /&nbsp;&nbsp;&nbsp;<?php echo $xstr; ?></label>

      <button id="btnpageprev" type="button" onclick="NaStr(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button><div class="mdl-tooltip" data-mdl-for="btnpageprev" >Prejsù na stranu <?php echo $ppage; ?></div>
      <button id="btnpagenext" type="button" onclick="NaStr(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button><div class="mdl-tooltip" data-mdl-for="btnpagenext">Prejsù na stranu <?php echo $npage; ?></div>
    </div>



  </div>
</form>
  </div> <!-- .wrap-ui-table -->
</div>
</main>

<nav class="mdl-navigation mdl-layout--large-screen-only header-nav " style="width: 300px; display: none;">
    <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Prehæad</a> <!-- dopyt, cez onclick -->
    <a href="#" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">UûÌvatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- dopyt, cez onclick -->
  </nav>


</div> <!-- .mdl-layout -->

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<script type="text/javascript">

  function ObnovUI()
  {

   document.forma3.selectpage.value = '<?php echo $strana; ?>';

//pagination start/end
<?php if ( $strana == 1 ) { ?>
   document.getElementById('btnpageprev').disabled = true;
<?php } ?>
<?php if ( $strana == $xstr ) { ?>
   document.getElementById('btnpagenext').disabled = true;
<?php } ?>

//row edit
<?php if ( $uprav != 0 )
{
?>
   document.getElementById('uloz').disabled = true;

var bodylist = document.getElementById('tablelayout');
    bodylist.className = bodylist.className == 'mdl-color--blue-grey-50' ? 'mdl-color--white' : 'mdl-color--blue-grey-50';

var rows = document.querySelectorAll('.row-echo');
for ( var i = 0; i < rows.length; i++ ) {
    rows[i].style.opacity='0.5';
  }

  var buttons = document.querySelectorAll('.row-echo button');
  for ( var i = 0; i < buttons.length; i++ ) {
    buttons[i].disabled = true;
  }

// document.getElementById('rowecho').style.opacity = '0.5';
  document.getElementById('btnpageprev').disabled = true;
  document.getElementById('btnpagenext').disabled = true;

<?php
}
//edit row
?>

<?php if ( $uprav == 1 ) { ?>

   document.formv.h_naz.value = '<?php echo "$h_naz"; ?>';
  document.formv.h_rok.value = '<?php echo "$h_rok"; ?>';
      // document.formv.h_rok.value = '<?php echo $naz_rok;?>';
   document.formv.h_duj.value = '<?php echo "$h_duj"; ?>';

<?php                   } ?>

  }

//empty state
<?php if ( $cpol == 0 ) { ?>
  document.forma3.style.visibility='hidden';





<?php                   } ?>

  function upravXcf(xcf,uprav)
  {
    window.open('firms_md.php?copern=<?php echo $copern; ?>&strana=<?php echo $strana; ?>&cislo_xcf=' + xcf + '&uprav=' + uprav + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');

  }

  function ChodNaStranu()
  {
   var chodna = document.forma3.selectpage.value;
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function NaStr(chodna)
  {
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }

function Uzivatelia()
  {
  window.open('users_md.php?copern=1&strana=1&xxx=1', '_self');
  }
function Domena()
{
  window.open('admin_md.php', '_self');
}
function Firmy()
{
  window.open('firms_md.php', '_self');
}

  function closeXcf(firma)
  {
    window.open('firms_md.php?copern=1&strana=<?php echo $strana; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');
  }

    function Povol_uloz()
    {

<?php if ( $uprav == 1 ) { ?>
   document.getElementById('uloz').disabled = false;
<?php } ?>

    }

</script>

</body>
</html>