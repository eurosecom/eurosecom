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
$dtb2 = include("oddel_dtb3new.php");
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

$domain = $_SERVER['SERVER_NAME'];

$uprav = 1*$_REQUEST['uprav'];
$cislo_xcf = 1*$_REQUEST['cislo_xcf'];
$hladanie = 1*$_REQUEST['hladanie'];
$cohladat = trim($_REQUEST['cohladat']);
if( $cohladat == '' ){ $hladanie=0; }
//echo $cohladat."<br />";
$nova = 1*$_REQUEST['nova'];
$zmaz = 1*$_REQUEST['zmaz'];

$kopkli=0;
$zmazane=0;


//zmaz
if ( $copern == 8 AND $zmaz == 1 )
  {

$upravttt = "DELETE FROM fir WHERE xcf = $cislo_xcf ";
$upravene = mysql_query("$upravttt");
//echo $upravttt."<br />";

$copern=1;
$zmaz=0;
$cislo_xcf=0;
$kopkli=1;
     }
//koniec zmaz

//nova
$bolanova=0; $jexcf=0;
if ( $copern == 8 AND $nova == 1 )
  {

$h_xcf = 1*strip_tags($_REQUEST['h_xcf']);
$h_naz = strip_tags($_REQUEST['h_naz']);
$h_rok = 1*strip_tags($_REQUEST['h_rok']);
$h_duj = 1*strip_tags($_REQUEST['h_duj']);
$h_dtb = strip_tags($_REQUEST['h_dtb']);
$h_prav = strip_tags($_REQUEST['h_prav']);

$jexcf=0;
$sqlttt = "SELECT * FROM fir WHERE xcf = $h_xcf ";
$sqldok = mysql_query("$sqlttt");
//echo $sqlttt;
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
$jexcf=1;
 }

$upravttt = "INSERT INTO fir ( xcf, naz, rok, duj, dtb, prav ) ".
" VALUES ( '$h_xcf', '$h_naz', '$h_rok', '$h_duj', '$h_dtb', '$h_prav' )";
if( $jexcf == 0 ) { $upravene = mysql_query("$upravttt"); $kopkli=1; $cislo_xcf=0; $nova=0;  }
//echo $upravttt."<br />";

$bolanova=1;
$copern=1;
     }
//koniec nova

//kopiruj
$kopiruj = 1*$_REQUEST['kopiruj'];
if ( $copern == 8 AND $kopiruj == 1 )
  {

$sqlttt = "SELECT * FROM fir WHERE xcf = $cislo_xcf ";
$sqldok = mysql_query("$sqlttt");
echo $sqlttt;
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $h_xcf=$riaddok->xcf+1;
 $h_naz=$riaddok->naz;
 $h_rok=$riaddok->rok;
 $h_duj=$riaddok->duj;
 $h_dtb=$riaddok->dtb;
 $h_prav=$riaddok->prav;
 }


$cislo_xcf=$cislo_xcf+1;
$copern=1;
$nova=1;
$kopkli=0;
     }
//koniec kopiruj

//uprava
if ( $copern == 8 AND $uprav == 1 )
  {

$h_naz = strip_tags($_REQUEST['h_naz']);
$h_rok = 1*strip_tags($_REQUEST['h_rok']);
$h_duj = 1*strip_tags($_REQUEST['h_duj']);
$h_dtb = strip_tags($_REQUEST['h_dtb']);
$h_prav = strip_tags($_REQUEST['h_prav']);

$upravttt = "UPDATE fir SET naz='$h_naz', rok='$h_rok', duj='$h_duj', dtb='$h_dtb', prav='$h_prav' WHERE xcf = $cislo_xcf  ";
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
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material.min.css">
  <link rel="stylesheet" href="css/material_edit.css">
  <title>Firmy | EuroSecom</title>
<style>



</style>
</head>
<body onload="ObnovUI();">
<?php
if ( $copern == 1 OR $copern == 8 ) {
?>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-drawer-button">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header" style="min-height: 136px;">
  <div class="mdl-layout__header-row mdl-color--light-blue-700 ui-header-app-row">
    <span onclick="AppPage();" class="mdl-color-text--yellow-A100">EuroSecom</span>&nbsp;
    <span class="mdl-color-text--blue-grey-50"><?php echo $domain; ?></span>
    <div class="mdl-layout-spacer"></div>
<!-- user -->
    <ul class="mdl-list clearfix ilogin">
      <li class="mdl-list__item">
        <span class="mdl-list__item-primary-content">
          <span class="mdl-list__item-avatar mdl-color--indigo-400"><?php echo $kli_uzid; ?></span>
          <span style="margin-left: 8px;"><?php echo "$kli_uzmeno $kli_uzprie"; ?></span>
        </span>
      </li>
    </ul>
  </div> <!-- .ui-header-app-row -->
  <div class="mdl-layout__header-row mdl-color--light-blue-600 ui-header-page-row">
    <span id="header_title" class="mdl-layout-title mdl-color-text--white" style="cursor: pointer;">»ÌselnÌk firiem<i class="material-icons" style="vertical-align: -6px;">arrow_drop_down</i>&nbsp;
    </span>
    <span class="mdl-layout-title mdl-color-text--yellow-A100">
<?php
if ( $nova == 1 ) { echo "nov·"; }
if ( $zmaz == 1 ) { echo "vymazanie # $cislo_xcf"; }
if ( $uprav == 1 ) { echo "˙prava # $cislo_xcf"; }
?>
    </span>
    <div class="mdl-layout-spacer"></div>
<form method="post" action="firms_md.php?hladanie=1&copern=1&strana=1&uprav=0" id="formhladaj" name="formhladaj">
    <div class="mdl-textfield mdl-js-textfield mdl-color--light-blue-500 search-box">
      <button id="searchbtn" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--white" style="bottom: 4px; left: 8px; "><i class="material-icons">search</i></button>
      <input type="text" id="cohladat" name="cohladat" value="<?php echo $cohladat; ?>" class="mdl-textfield__input search-input mdl-color-text--white" style="border:0; font-size: 14px; height: 32px; width: 100%;">
      <label for="cohladat" class="mdl-textfield__label mdl-color-text--white" style="font-size: 14px; top: 5px; left: 48px; height: 32px; line-height: 32px; width: 204px;">Zadajte n·zov firmy</label>
      <button id="resetsearchbtn" onclick="document.formhladaj.cohladat.value='';" class="mdl-button mdl-js-button mdl-button--icon search-reset mdl-color-text--white" style="bottom: 4px; right: 8px;"><i class="material-icons">close</i></button>
    </div>
</form>
    <button type="button" id="view_list" onclick="viewFirms();" class="mdl-button mdl-js-button mdl-button--icon " style=""><i class="material-icons">print</i></button>

    <button type="button" onclick="novaXcf();" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" style="margin-left: 24px;"><i class="material-icons">add</i></button>
  </div> <!-- .ui-header-page-row -->
  <div class="mdl-layout__header-row mdl-color--light-blue-600" style="padding:0; height: 40px;">
    <table class="ui-table-header ui-table data-table container tocenter">
    <tr class="mdl-color-text--blue-grey-50">
      <th class="right" style="width:8%; padding-right: 16px;">»Ìslo</th>
      <th class="left" style="width:47%;">N·zov</th>
      <th class="right" style="width:10%;">Obdobie</th>
      <th class="right" style="width:15%;">Druh&nbsp;<i id="druhfirm" class="material-icons md-18">help_outline</i>
      </th>
      <th style="width: 20%;">&nbsp;</th>
    </tr>
    </table>
  </div>
</header>

<main class="mdl-layout__content mdl-color--blue-grey-50 sticky-footer">
<div id="table_body" class="mdl-color--white">
<?php
$sqltt = "SELECT * FROM fir WHERE xcf >= 0 ORDER BY xcf ";
if( $nova == 1 OR $bolanova == 1 )
{
$sqltt = "SELECT * FROM fir WHERE xcf >= 0  ORDER BY datm DESC ";
}
if( $hladanie == 1 )
{
$sqltt = "SELECT * FROM fir WHERE  xcf >= 0  AND ( naz LIKE '%$cohladat%' OR rok LIKE '%$cohladat%' ) ORDER BY xcf ";
}
$sql = mysql_query("$sqltt");
//prazdny zoznam
//$sql = mysql_query("SELECT * FROM fir WHERE xcf < 0 ORDER BY xcf ");
//celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15; //dopyt, dame 15
if ( $hladanie == 1 ) { $pols = 900; }
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
  <div class="container tocenter">
<form method="post" action="firms_md.php?copern=8&strana=<?php echo $strana; ?>&cislo_xcf=<?php echo $cislo_xcf; ?>&zmaz=<?php echo $zmaz; ?>&uprav=<?php echo $uprav; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>&nova=<?php echo $nova; ?>" id="formv" name="formv">
  <table class="ui-table-content ui-table data-table">
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

<?php if ( ( $uprav != 0 AND $riadok->xcf == $cislo_xcf ) OR ( $nova == 1 AND $i == 0 ) OR ( $zmaz != 0 AND $riadok->xcf == $cislo_xcf ) ) { ?>
  <tr class="row-form mdl-color--white mdl-shadow--2dp">
    <td class="vatop">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:50px;">
        <input type="text" name="h_xcf" id="h_xcf" onKeyDown="return XcfEnter(event.which)" pattern="-?[0-9]*(\.[0-9]+)?" tabindex="1" required class="mdl-textfield__input">
        <label for="h_xcf" class="mdl-textfield__label">»Ìslo firmy *</label>
<?php if ( $jexcf == 0 OR $bolanova == 0 ) { ?>
        <span class="mdl-textfield__error">PouûÌvajte ËÌsla!</span>
<?php } ?>
<?php if ( $jexcf == 1 AND $bolanova == 1 ) { ?>
        <span class="mdl-textfield__error2">»Ìslo <?php echo $h_xcf; ?> uû existuje!</span>
<?php } ?>
      </div>
      <button type="button" id="all_firms" onclick="allFirms();" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-400" style="">
        <i class="material-icons">print</i>
      </button>
        <span class="mdl-tooltip" data-mdl-for="all_firms">ObsadenÈ ËÌsla firiem</span>
    </td>
    <td>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:80%;">
        <input type="text" id="h_naz" name="h_naz" onKeyDown="return NazEnter(event.which)" required tabindex="2" class="mdl-textfield__input">
        <label for="h_naz" class="mdl-textfield__label">N·zov firmy *</label>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
        <input type="text" id="h_dtb" name="h_dtb" onKeyDown="return DtbEnter(event.which)" tabindex="5" class="mdl-textfield__input">
        <label for="h_dtb" class="mdl-textfield__label">Parametre</label>
      </div>&nbsp;&nbsp;&nbsp;
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
        <input type="text" id="h_prav" name="h_prav" onKeyDown="return PravEnter(event.which)" tabindex="6" class="mdl-textfield__input">
        <label for="h_prav" class="mdl-textfield__label">Prav</label>
      </div>
    </td>
    <td class="vatop right">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
        <select name="h_rok" id="h_rok" required tabindex="3" onKeyDown="return RokEnter(event.which)" class="mdl-textfield__input">
          <option value="2017">2017</option>
          <option value="2016">2016</option>
          <option value="2015">2015</option>
          <option value="2014">2014</option>
          <option value="2013">2013</option>
          <option value="2012">2012</option>
          <option value="2011">2011</option>
          <option value="2010">2010</option>
        </select>
        <label for="h_rok" class="mdl-textfield__label">Obdobie *</label>
      </div>
    </td>
    <td class="vatop right">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:auto;">
        <select name="h_duj" id="h_duj" required tabindex="4" onKeyDown="return DujEnter(event.which)" class="mdl-textfield__input">
          <option value="0">0 = P⁄</option>
          <option value="1">1 = NO P⁄</option>
          <option value="9">9 = J⁄</option>
        </select>
        <label for="h_duj" class="mdl-textfield__label">Druh firmy *</label>
      </div>
    </td>
    <td class="right" style="">
      <button type="button" id="row_form_close" onclick="closeXcf(<?php echo $riadok->xcf; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons">close</i></button>
        <div data-mdl-for="row_form_close" class="mdl-tooltip">Zavrieù</div>
      <span id="freedom" onmouseover="return Povol_uloz();" style="position: absolute; top: 105px; right: 0;">
        <button id="uloz" name="uloz">Uloûiù</button>
      </span>
      <abbr id="enternext" class="mdl-color--light-blue-600 mdl-color-text--white text-chip" style="position: absolute; top: 13px; right: 72px;">EnterNext</abbr>
        <span data-mdl-for="enternext" class="mdl-tooltip">Na pres˙vanie medzi polÌËkami pouûite kl·vesu ENTER. TlaËidlo ULOéIç aktivujete prejdenÌm kurzoru okolo tlaËidla.</span>
    </td>
  </tr> <!-- .row-form -->
<?php                                                    } ?>

<?php if ( $riadok->xcf != $cislo_xcf OR $nova == 1 ) { ?>
  <tr id="echo_row" class="row-echo">
    <td class="right" style="padding-right: 16px;"><strong><?php echo $riadok->xcf; ?></strong></td>
    <td><?php echo $riadok->naz; ?></td>
    <td class="right"><?php echo $riadok->rok; ?></td>
    <td class="right"><?php echo $riadok->duj; ?></td>
    <td class="right">
      <button type="button" id="edit<?php echo $riadok->xcf; ?>" onclick="upravXcf(<?php echo $riadok->xcf; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500"><i class="material-icons">edit</i></button>
      <button type="button" id="copy<?php echo $riadok->xcf; ?>" onclick="kopirujXcf(<?php echo $riadok->xcf; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons">content_copy</i></button>
      <button type="button" id="remove<?php echo $riadok->xcf; ?>" onclick="zmazXcf(<?php echo $riadok->xcf; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500"><i class="material-icons">remove</i></button>
        <div data-mdl-for="edit<?php echo $riadok->xcf; ?>" class="mdl-tooltip">Upraviù</div>
        <div data-mdl-for="copy<?php echo $riadok->xcf; ?>" class="mdl-tooltip">KopÌrovaù</div>
        <div data-mdl-for="remove<?php echo $riadok->xcf; ?>" class="mdl-tooltip">Vymazaù</div>
    </td>
  </tr> <!-- .row-echo -->
<?php                                    } ?>

<?php
  }
$i = $i + 1;
   }
?>
  </table>
</form>
<form name="forma3" id="forma3" action="#">
  <div class="mdl-color-text--grey-600 ui-table-pagination">
    <span>= <?php echo $cpol; ?></span>
    <div class="mdl-layout-spacer"></div>
    <label for="page_goto" style="margin-right: 24px;">Strana
    <select name="page_goto" id="page_goto" onchange="gotoPage();" class="mdl-textfield__input">
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
    </select>/&nbsp;&nbsp;<?php echo $xstr; ?></label>
    <button type="button" id="page_prev" onclick="navPage(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button>
    <button type="button" id="page_next" onclick="navPage(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button>
      <div class="mdl-tooltip" data-mdl-for="page_prev">Prejsù na stranu <?php echo $ppage; ?></div>
      <div class="mdl-tooltip" data-mdl-for="page_next">Prejsù na stranu <?php echo $npage; ?></div>
  </div> <!-- .ui-table-pagination -->
</form>
  </div> <!-- .container -->
</div> <!-- #table_body -->

<!-- empty state -->
<?php if ( $cpol == 0 ) { ?>
<div id="empty_body" class="ui-no-item" style="margin: 12% auto 10% auto;">
  <i class="material-icons mdl-color-text--grey-400 md-64">sentiment_dissatisfied</i>
  <div class="mdl-color-text--grey-500 no-item-alert">éiadne poloûky</div>
</div>
<?php                   } ?>

<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer mdl-color--blue-grey-50 container">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo mdl-color-text--grey-500">© 2017 EuroSecom</div>
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="News();" title="Novinky v EuroSecom" class="mdl-color-text--light-blue-500">Novinky</a></li>
    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="Edcom();" title="EuroSecom powered by EDcom" class="mdl-color-text--light-blue-500">EDcom</a></li>
    </ul>
  </div>
</footer>
</main>



<!-- header nav menu -->
<div style="position:fixed; left: 0px; top: -24px; z-index: 10;">
  <ul for="header_title" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
<!--     <li class="mdl-menu__item" onclick="Domain();">DomÈna</li> -->
    <li class="mdl-menu__item" onclick="Users();">»ÌselnÌk uûÌvateæov</li>
    <li class="mdl-menu__item mdl-color-text--light-blue-600" onclick="Firms();">»ÌselnÌk firiem</li>
  </ul>
</div>


<!-- tooltip -->
<span class="mdl-tooltip" data-mdl-for="ilogin_user"><?php echo "$kli_uzid $kli_uzmeno $kli_uzprie"; ?></span>

<span class="mdl-tooltip" data-mdl-for="view_list">Zobraziù ËÌselnÌk</span>
<span class="mdl-tooltip" data-mdl-for="new_item">Vytvoriù novÈho uûÌvateæa</span>
<span class="mdl-tooltip" data-mdl-for="searchbtn">Hæadaù</span>
<span class="mdl-tooltip" data-mdl-for="resetsearchbtn">Vymazaù vyhæad·vanie</span>
<span data-mdl-for="druhfirm" class="mdl-tooltip">0 = PodvojnÈ ˙ËtovnÌctvo<br>1 = NO podvojnÈ ˙ËtovnÌctvo<br>9 = JednoduchÈ ˙ËtovnÌctvo</span>



</div> <!-- .mdl-layout -->
<?php             }
//end copern = 1,8
?>

<?php
//print
if( $copern == 11 ) {

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="tmp/firmy_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="tmp/firmy_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','fpdf/font/');
   require('fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM fir WHERE xcf >= 0 ORDER BY xcf ";
if( $hladanie == 1 )
{
$sqltt = "SELECT * FROM fir WHERE  xcf >= 0  AND ( naz LIKE '%$cohladat%' OR rok LIKE '%$cohladat%' ) ORDER BY xcf ";
}
//echo $sqltt;
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $tvpol;

$strana=0;
$j=0;
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);
$dat_sk = date("d.m.Y H:i:s", strtotime($riadok->dat));

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15);
$pdf->SetTopMargin(15);

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Firmy","LTB",0,"L");
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);


$pdf->Cell(20,6,"ËÌslo","1",0,"R");$pdf->Cell(80,6,"nazov","1",0,"L");
$pdf->Cell(0,6,"rok","1",1,"L");

     }
//koniec hlavicky j=0



$pdf->SetFont('arial','',8);

$pdf->Cell(20,6,"$riadok->xcf","0",0,"R");
$pdf->Cell(80,6,"$riadok->naz","0",0,"L");
$pdf->Cell(0,6,"$riadok->rok","0",1,"L");
$pdf->Cell(0,1," ","B",1,"L");

}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }

$pdf->Output("$outfilex");

?>
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
echo $sqltt;
exit;
               }
//end of print copern = 11
?>



<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script type="text/javascript">
//dimensions blank window
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900'; //dopyt, premenn˙ do eng a neskÙr pouûiù

  function ObnovUI()
  {
//pagination
   document.forma3.page_goto.value = '<?php echo $strana; ?>';
<?php if ( $strana == 1 ) { ?>
   document.forma3.page_prev.disabled = true;
<?php } ?>
<?php if ( $strana == $xstr ) { ?>
   document.forma3.page_next.disabled = true;
<?php } ?>

//row action
<?php if ( $uprav == 1 OR $nova == 1 OR $zmaz == 1 )
{
?>
document.getElementById('header_title').style.pointerEvents = 'none';

var headbuttons = document.querySelectorAll('header button');
for ( var i = 0; i < headbuttons.length; i++ ) {
  headbuttons[i].disabled = true;
  headbuttons[i].style.opacity = '0.5';
}

table_body.className = table_body.className == 'mdl-color--grey-50' ? 'mdl-color--white' : 'mdl-color--blue-grey-50';

var rows = document.querySelectorAll('#echo_row > td');
for ( var i = 0; i < rows.length; i++ ) {
  rows[i].style.opacity='0.5';
}

var buttons = document.querySelectorAll('#echo_row button');
for ( var i = 0; i < buttons.length; i++ ) {
  buttons[i].disabled = true;
}

  document.formv.uloz.disabled = true;
  document.forma3.page_goto.disabled = true;
  document.forma3.page_prev.disabled = true;
  document.forma3.page_next.disabled = true;

  document.formhladaj.cohladat.disabled = true;
<?php
}
//row action
?>



//row edit/del
<?php if ( $uprav == 1 OR $zmaz == 1 OR $kopiruj == 1 OR $jexcf == 1 ) { ?>
  document.formv.h_xcf.value = '<?php echo "$h_xcf"; ?>';
  document.formv.h_naz.value = '<?php echo "$h_naz"; ?>';
  document.formv.h_rok.value = '<?php echo "$h_rok"; ?>';
  document.formv.h_dtb.value = '<?php echo "$h_dtb"; ?>';
  document.formv.h_duj.value = '<?php echo "$h_duj"; ?>';
  document.formv.h_prav.value = '<?php echo "$h_prav"; ?>';
<?php } ?>

<?php if ( $uprav == 1 OR $zmaz == 1 ) { ?>
  document.formv.h_xcf.disabled = true;
  document.formv.h_naz.autofocus = true;
<?php } ?>

<?php if ( $zmaz == 1 ) { ?>
  document.formv.h_naz.disabled = true;
  document.formv.h_rok.disabled = true;
  document.formv.h_duj.disabled = true;
  document.formv.h_dtb.disabled = true;
  document.formv.h_prav.disabled = true;
  document.formv.uloz.innerHTML = "Vymazaù";
<?php                   } ?>

<?php if ( $nova == 1 ) { ?>
  document.formv.h_xcf.autofocus = true;
<?php } ?>


//empty state
<?php if ( $cpol == 0 ) { ?>
  document.getElementById('table_body').style.display='none';
<?php                   } ?>
  }







  function upravXcf(xcf,uprav)
  {
    window.open('firms_md.php?copern=<?php echo $copern; ?>&strana=<?php echo $strana; ?>&cislo_xcf=' + xcf + '&uprav=' + uprav + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');

  }

  function kopirujXcf(xcf)
  {
    window.open('firms_md.php?copern=8&strana=1&cislo_xcf=' + xcf + '&kopiruj=1&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');

  }

  function zmazXcf(xcf)
  {
    window.open('firms_md.php?copern=<?php echo $copern; ?>&zmaz=1&strana=<?php echo $strana; ?>&cislo_xcf=' + xcf + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');

  }

  function gotoPage()
  {
   var chodna = document.forma3.page_goto.value;
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }
  function navPage(chodna)
  {
   window.open('firms_md.php?copern=1&strana=' + chodna + '', '_self');
  }

function Users()
  {
  window.open('users_md.php?copern=1&strana=1&xxx=1', '_self');
  }

  function AppPage()
  {
   window.open('http://www.edcom.sk/web/eurosecom.html', '_blank');
  }
function Domain()
{
  window.open('admin_md.php?copern=1', '_self');
}
function Firms()
{
  window.open('firms_md.php?copern=1&strana=1', '_self');
}
  function Edcom()
  {
   window.open('http://www.edcom.sk', '_blank');
  }


function viewFirms()
{
  window.open('firms_md.php?copern=11&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_blank', param);
}
function allFirms()
{
  window.open('firms_md.php?copern=11', '_blank', param);
}

  function closeXcf(firma)
  {
    window.open('firms_md.php?copern=1&strana=<?php echo $strana; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');
  }

  function novaXcf()
  {
    window.open('firms_md.php?copern=1&strana=1&hladanie=0&cohladat=&nova=1', '_self');
  }

    function Povol_uloz()
    {

<?php if ( $uprav == 1 ) { ?>
   document.getElementById('uloz').disabled = false;
<?php } ?>

<?php if ( $nova == 1 ) { ?>
   document.getElementById('uloz').disabled = false;
<?php } ?>

<?php if ( $zmaz == 1 ) { ?>
   document.getElementById('uloz').disabled = false;
<?php } ?>

    }

//enternext

function XcfEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_naz.focus();
        document.formv.h_naz.select();
              }

                }

function NazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_rok.focus();
        document.formv.h_rok.select();
              }

                }

function RokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_duj.focus();
        document.formv.h_duj.select();
              }

                }

function DujEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_dtb.focus();
        document.formv.h_dtb.select();
              }

                }

function DtbEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_prav.focus();
        document.formv.h_prav.select();
              }

                }

function PravEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.formv.h_naz.value == '' ) okvstup=0;
    if ( okvstup == 0 ) { document.formv.h_naz.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv.submit(); return (true); }
              }

                }

</script>
</body>
</html>