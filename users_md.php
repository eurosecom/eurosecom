<!doctype html>
<html>
<?php
$sys = 'ALL';
$urov = 50000;
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
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) { $strana = 1; }
$min_uzall=50000;
if( $kli_uzall >= 100000 ) { $min_uzall=999999;}

$server_name = $_SERVER['SERVER_NAME'];


$uprav = 1*$_REQUEST['uprav'];
$cislo_id = 1*$_REQUEST['cislo_id'];
//$tab = 1*$_REQUEST['tab'];


$kopkli=0;
$zmazane=0;

//vymazanie 
if ( $copern == 6 AND $uprav == 3 )
    {
$cslm = 1*strip_tags($_REQUEST['cslm']);
$uzid = 1*strip_tags($_REQUEST['uzid']);
$datm = strip_tags($_REQUEST['datm']);
$cislo_id = $_REQUEST['cislo_id'];


$z_prav=0; $z_cslm=0;
$sqlpoktt = "SELECT * FROM firuz WHERE prav='$cislo_id' AND cslm='$cslm' AND  datm='$datm' ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $z_prav=$riadokpok->prav;
  $z_cslm=$riadokpok->cslm;
  }

$zmazttt = "DELETE FROM menp WHERE prav='$cislo_id' AND cslm='$cslm' AND  datm='$datm' "; 
$zmazane = mysql_query("$zmazttt");
//echo $zmazttt."<br />";

$copern=1;
$uprav=3;
$kopkli=1;
$zmazane=1;
     }
//koniec vymazania 

//vymazanie 
if ( $copern == 6 AND $uprav == 2 )
    {
$cplf = 1*strip_tags($_REQUEST['cplf']);

$z_fiod=0; $z_fido=0;
$sqlpoktt = "SELECT * FROM firuz WHERE cplf='$cplf' ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $z_fiod=$riadokpok->fiod;
  $z_fido=$riadokpok->fido;
  }


$zmazttt = "DELETE FROM firuz WHERE cplf='$cplf' "; 
$zmazane = mysql_query("$zmazttt");
//echo $zmazttt."<br />";

$copern=1;
$uprav=2;
$kopkli=1;
$zmazane=1;
     }
//koniec vymazania 

//uprava
if ( $copern == 8 AND $uprav == 3 )
  {

$cislo_id = $_REQUEST['cislo_id'];
$cslm = 1*strip_tags($_REQUEST['cslm']);
$uzid = 1*strip_tags($_REQUEST['uzid']);


$upravttt = "INSERT INTO menp ( sys, cslm, prav ) VALUES ( '', '$cslm', '$cislo_id'  ); "; 
if( $cslm > 0 ) { $upravene = mysql_query("$upravttt"); }
//echo $upravttt."<br />";

$copern=1;
$uprav=3;
$kopkli=1;
     }
//koniec uprava

//uprava
if ( $copern == 8 AND $uprav == 2 )
  {
$h_id = $_REQUEST['h_id'];
$h_uzm = $_REQUEST['h_uzm'];
$h_uzh = $_REQUEST['h_uzh'];
$h_prie = $_REQUEST['h_prie'];
$h_meno = $_REQUEST['h_meno'];
$h_all = $_REQUEST['h_all'];
$h_uct = $_REQUEST['h_uct'];
$h_mzd = $_REQUEST['h_mzd'];
$h_skl = $_REQUEST['h_skl'];
$h_him = $_REQUEST['h_him'];
$h_dop = $_REQUEST['h_dop'];
$h_ana = $_REQUEST['h_ana'];
$h_vyr = $_REQUEST['h_vyr'];
$h_fak = $_REQUEST['h_fak'];
$h_txt1 = $_REQUEST['h_txt1'];
$cis1 = $_REQUEST['cis1'];
$cislo_id = $_REQUEST['cislo_id'];

if( $h_all > 10000 AND $kli_uzall < 100000 ) { $h_all=10000; }

$upravttt = "UPDATE klienti SET txt1='$h_txt1' WHERE id_klienta=$cislo_id";
$upravene = mysql_query("$upravttt");
//echo $upravttt."<br />";

$fiod = 1*strip_tags($_REQUEST['fiod']);
$fido = 1*strip_tags($_REQUEST['fido']);

$upravttt = "INSERT INTO firuz ( uzid, fiod, fido ) VALUES ( '$cislo_id', '$fiod', '$fido'  ); "; 
if( $fiod > 0 AND $fiod <= $fido ) { $upravene = mysql_query("$upravttt"); }
//echo $upravttt."<br />";

$copern=1;
$uprav=2;
$kopkli=1;
     }
//koniec uprava

//uprava
if ( $copern == 8 AND $uprav == 1 )
  {
$h_id = $_REQUEST['h_id'];
$h_uzm = $_REQUEST['h_uzm'];
$h_uzh = $_REQUEST['h_uzh'];
$h_prie = $_REQUEST['h_prie'];
$h_meno = $_REQUEST['h_meno'];
$h_all = $_REQUEST['h_all'];
$h_uct = $_REQUEST['h_uct'];
$h_mzd = $_REQUEST['h_mzd'];
$h_skl = $_REQUEST['h_skl'];
$h_him = $_REQUEST['h_him'];
$h_dop = $_REQUEST['h_dop'];
$h_ana = $_REQUEST['h_ana'];
$h_vyr = $_REQUEST['h_vyr'];
$h_fak = $_REQUEST['h_fak'];
$h_txt1 = $_REQUEST['h_txt1'];
$cis1 = $_REQUEST['cis1'];
$cislo_id = $_REQUEST['cislo_id'];

if( $h_all > 10000 AND $kli_uzall < 100000 ) { $h_all=10000; }

$upravttt = "UPDATE klienti SET uziv_meno='$h_uzm', uziv_heslo='$h_uzh', priezvisko='$h_prie', meno='$h_meno',
 all_prav='$h_all', uct_prav='$h_uct', mzd_prav='$h_mzd', skl_prav='$h_skl', him_prav='$h_him', dop_prav='$h_dop',
 vyr_prav='$h_vyr', fak_prav='$h_fak', ana_prav='$h_ana', cis1='$cis1' WHERE id_klienta=$cislo_id";

$upravene = mysql_query("$upravttt");
//echo $upravttt;

$copern=1;
$uprav=1;
$kopkli=1;
     }
//koniec uprava

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlttt = "SELECT * FROM klienti WHERE id_klienta = $cislo_id ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $h_uzm=$riaddok->uziv_meno;
 $h_uzh=$riaddok->uziv_heslo;
 $h_prie=$riaddok->priezvisko;
 $h_meno=$riaddok->meno;
 $h_all=$riaddok->all_prav;
 $h_uct=$riaddok->uct_prav;
 $h_mzd=$riaddok->mzd_prav;
 $h_skl=$riaddok->skl_prav;
 $h_fak=$riaddok->fak_prav;
 $h_him=$riaddok->him_prav;
 $h_dop=$riaddok->dop_prav;
 $h_vyr=$riaddok->vyr_prav;
 $h_ana=$riaddok->ana_prav;
 $h_txt1=$riaddok->txt1;
 }

     }
//koniec nacitaj udaje

//nastav fir a ume podla mojho konta
if( $copern == 1001 )
{
$cislo_id = 1*$_REQUEST['cislo_id'];

//xcf  id  ume  pr3  pr2  pr1  robot  datm
$sqlttt = "SELECT * FROM nas_id WHERE id = $kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $firma=$riaddok->xcf;
  $ume=$riaddok->ume;
  }

$sqty = "DELETE FROM nas_id WHERE id = $cislo_id  ";
$ulozene = mysql_query("$sqty");

$Cislo=$ume+"";
$ume=sprintf("%0.4f", $Cislo);

$sqty = "INSERT INTO nas_id ( xcf,id,ume,pr3,pr2,pr1,robot,datm )".
" VALUES ( '$firma', '$cislo_id', '$ume', 0, 0, 0, 1, now()  );";
$ulozene = mysql_query("$sqty");

$copern=1;
}
//koniec nastav fir a ume podla mojho konta

if( $newdelenie == 1 AND $kopkli == 1 )
          {

if( $mysqldb2016 != $mysqldb2015 AND $mysqldb2015 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2015."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2015.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2015.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2015."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2015.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2015."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }


if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2017."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2017.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2017.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2017."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2017.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2017."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2018."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2018.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2018.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2018."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2018.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2018."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2019."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2019.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2019.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2019."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2019.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2019."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2014 AND $mysqldb2014 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2014."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2014.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2014.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2014."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2014.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2014."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2013 AND $mysqldb2013 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2013."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2013.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2013.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2013."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2013.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2013."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2012 AND $mysqldb2012 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2012."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2012.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2012.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2012."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2012.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2012."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2011 AND $mysqldb2011 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2011."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2011.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2011.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2011."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2011.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2011."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2010 AND $mysqldb2010 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2010."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`klienti` SELECT * FROM `".$mysqldb2016."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2010.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2010.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2010."`.`firuz` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`firuz` SELECT * FROM `".$mysqldb2016."`.`firuz` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2010.".firuz MODIFY cplf int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sqlttt=" DROP TABLE `".$mysqldb2010."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }


          }
//if( $newdelenie == 1 )

?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="css/material.css">
<link rel="stylesheet" href="css/material_edit.css">
<title>Uívatelia | EuroSecom</title>
</head>
<body onload="ObnovUI();" >
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-desktop-drawer-button"> <!--  -->
<header class="mdl-layout__header mdl-color--light-blue-700 mdl-layout__header--waterfall ui-header" style="">
  <div class="mdl-layout__header-row ui-app-row" style=" ">
  <div class="mdl-layout-title " style="">
    <a href="http://www.edcom.sk/web/eurosecom.html" target="_blank" class="mdl-color-text--yellow-A100">EuroSecom</a>
    <a href="admin_md.php" class="mdl-color-text--white "><?php echo $server_name; ?></a>
  </div>
  <nav class="mdl-navigation mdl-layout--large-screen-only header-nav">
    <a href="admin_md.php" class="mdl-navigation__link header-nav-link">Preh¾ad</a> <!-- dopyt, cez onclick -->
    <a href="#" onclick="Uzivatelia();" class="mdl-navigation__link header-nav-link active">Uívatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link header-nav-link">Firmy</a> <!-- dopyt, cez onclick -->
  </nav>
  <div class="mdl-layout-spacer"></div>
  <div class="mdl-list header-list">
    <div class="mdl-list__item mdl-color-text--blue-grey-100">
      <i class="material-icons mdl-list__item-avatar mdl-color--blue-A100 mdl-color-text--blue-A700 item-avatar-md">person</i>
      <span class="">Uívate¾ skúšobnı</span>
    </div>
  </div>
</div> <!-- .ui-app-row -->
</header>

<main class="mdl-layout__content mdl-color--blue-grey-50">

<!-- floating action button -->
<aside class="floating-toolbar" style="top:50px; ">
  <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-color--green-500"><i class="material-icons">add</i></button>
  <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"><i class="material-icons">print</i></button>
</aside>



<div class="mdl-grid mdl-grid--no-spacing" style="max-width: 1200px; ">
<div class="mdl-cell--12-col">

<?php
$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta ");
//$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < 1 ORDER BY id_klienta ");//prazdny zoznam
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15;
// pocet stran
$xstr =ceil($cpol / $pols);
$npage =  $strana + 1;
// predchadzajuca strana
$ppage =  $strana - 1;
if( $ppage == 0 ) { $ppage=1; }
if( $npage >  $xstr ) { $npage=$xstr; }
// zaciatok cyklu
$i = ( $strana - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($strana-1))+($pols-1);
?>
  <table class="mdl-data-table mdl-shadow--2dp data-table full-width" style="margin-top: 8px;     ">
  <colgroup>
    <col style="width:22%;">
    <col style="width:14%;">
    <col style="width:20%;">
    <col style="width:8%;">
    <col style="width:6%;">
    <col style="width:6%;">
    <col style="width:6%;">
    <col style="width:6%;">
    <col style="width:12%;">
  </colgroup>
  <thead class="mdl-color--grey-100" style="">
    <tr style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
      <th colspan="2" class="mdl-data-table__cell--non-numeric">
        <span class="table-title-upper">Èíselník uívate¾ov</span>
      </th>
      <th colspan="7">
<form action="#" class="">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable " style="padding-top: 11px;">
    <label class="mdl-button mdl-js-button mdl-button--icon" for="sample6" style="top:9px;">
      <i class="material-icons">search</i>
    </label>
    <div class="mdl-textfield__expandable-holder">
      <input class="mdl-textfield__input " type="text" id="sample6" style="font-size: 14px;">
      <label class="mdl-textfield__label " for="sample6" style="top: 4px; left: 0; font-size: 14px;">H¾adanı vıraz...</label>
    </div>
  </div>
</form>

      </th>
    </tr>
   <tr style="">
    <th class="mdl-data-table__cell--non-numeric">Uívate¾</th>
    <th class="mdl-data-table__cell--non-numeric">Prihlasovacie<br>meno - heslo</th>
    <th>Firmy</th>
    <th>Prístup</th>
    <th>Úèto<br>Majetok</th>
    <th>Mzdy<br>Doprava</th>
    <th>Odbyt<br>Vıroba</th>
    <th>Sklad<br>Analızy</th>
    <th>&nbsp;</th>
   </tr>
  </thead>
  <tbody>
<?php if ( $cpol == 0 ) { ?>
    <tr>
      <td colspan="9" >
        <div class="tbody-alert center">iadne poloky</div>
      </td>
    </tr>
<?php                   } ?>

<?php
   while ($i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>

<?php  if ( $uprav == 0 OR ( ( $uprav == 1 OR $uprav == 2 OR $uprav == 3 OR $uprav == 4 ) AND $riadok->id_klienta != $cislo_id ) ) { ?>
    <tr class="row-echo">


      <td class="mdl-data-table__cell--non-numeric" >
<?php if ( $riadok->id_klienta == $kli_uzid ) { ?> <div class="colored-divider">&nbsp;</div> <?php } ?>

<div class="mdl-list__item">
    <span class="mdl-list__item-primary-content">
      <span class="mdl-list__item-avatar"><?php echo $riadok->id_klienta; ?></span>
      <span><?php echo "$riadok->meno $riadok->priezvisko"; ?></span>
    </span>
  </div>
      </td>
<?php
//uzivatel s gridkartou
$jegrid=0;
$sqlpoktt = "SELECT * FROM krtgrd WHERE id = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jegrid=1;
  }

//uzivatel s obmedzenim skriptov
$jemenp=0;
$sqlpoktt = "SELECT * FROM menp WHERE prav = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jemenp=1;
  }

//posledne prihlasenie
$poslpr="";
$sqlpoktt = "SELECT * FROM dlogin WHERE id = $riadok->id_klienta ORDER BY datm DESC";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $poslpr=$riadokpok->datm;
  }

//nastav moju firmu a ume
if( $i == 0 )
    {
$mojexcf=0; $mojeume=0;
$sqlpoktt = "SELECT * FROM nas_id WHERE id = $kli_uzid ORDER BY datm DESC";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $mojexcf=1*$riadokpok->xcf;
  $mojeume=1*$riadokpok->ume;
  }
    }

//vypis firiem
$akefirmy="";
if( $riadok->txt1 == "0-0" )
        {
$ipok=0;
$sqlpoktt = "SELECT * FROM firuz WHERE uzid = $riadok->id_klienta ORDER BY fiod ";
$sqlpok = mysql_query("$sqlpoktt");
$cpolpok = mysql_num_rows($sqlpok);
   while ($ipok <= $cpolpok )
   {
  if (@$zaznampok=mysql_data_seek($sqlpok,$ipok))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $akefirmy=$akefirmy.$riadokpok->fiod."-".$riadokpok->fido."<br />";

  }
$ipok=$ipok+1;
   }
        }

?>
      <td class="mdl-data-table__cell--non-numeric"><?php echo "$riadok->uziv_meno - $riadok->uziv_heslo"; ?><br>


<?php if ( $jegrid == 1 ) { ?>
        <span id="<?php echo $riadok->id_klienta; ?>gridinfo" class="text-chip">Grid</span>
<div data-mdl-for="<?php echo $riadok->id_klienta; ?>gridinfo" class="mdl-tooltip mdl-tooltip--right" >Uívate¾ s grid kartou</div>

<?php                     } ?>
<?php if ( $jemenp == 1 ) { ?>
        <span id="<?php echo $riadok->id_klienta; ?>scriptinfo" class="text-chip">Skripty</span>
<div data-mdl-for="<?php echo $riadok->id_klienta; ?>scriptinfo" class="mdl-tooltip mdl-tooltip--right" >Uívate¾ s obmedzenım prístupom</div>
<?php                     } ?>

<i id="<?php echo $riadok->id_klienta; ?>timelogin" class="material-icons mdl-color-text--grey-500 vacenter" style="font-size: 16px; ">timer</i>
<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="<?php echo $riadok->id_klienta; ?>timelogin">Posledné prihlásenie: <?php echo $poslpr; ?></div>
      </td>
  <td>
<?php
       if ( $riadok->txt1 == "0-0" ) { ?>
<?php echo $akefirmy; ?>
<?php                              } ?>

        <?php echo $riadok->txt1; ?>

      </td>
      <td><?php echo $riadok->all_prav; ?></td>
      <td><?php echo $riadok->uct_prav ;?><br><?php echo $riadok->him_prav;?></td>
      <td><?php echo $riadok->mzd_prav;?><br><?php echo $riadok->dop_prav;?></td>
      <td><?php echo $riadok->fak_prav;?><br><?php echo $riadok->vyr_prav;?></td>
      <td><?php echo $riadok->skl_prav;?><br><?php echo $riadok->ana_prav;?></td>
      <td>
        <button type="button" id="<?php echo $riadok->id_klienta; ?>itemedit" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <div class="mdl-tooltip" data-mdl-for="<?php echo $riadok->id_klienta; ?>itemedit">Upravi</div>
        <button id="<?php echo $riadok->id_klienta; ?>moretools" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons">more_vert</i></button>
        <div class="mdl-tooltip" data-mdl-for="<?php echo $riadok->id_klienta; ?>moretools">Ïalšie akcie</div>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect table-row-menu" for="<?php echo $riadok->id_klienta; ?>moretools" style=""  >
  <li class="mdl-menu__item"><i class="material-icons mdl-color-text--grey-500 vacenter" style="">content_copy</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kopírova</li>
  <li class="mdl-menu__item"><i class="material-icons mdl-color-text--red-500 vacenter">remove</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vymaza</li>
  <li onclick="NastavFirmu(<?php echo $riadok->id_klienta; ?>, <?php echo $strana; ?>);" class="mdl-menu__item">Nastavi firmu <?php echo $mojexcf;?> a mesiac <?php echo $mojeume;?></li>
</ul>
     </td>
</tr>
<?php
      } //$uprav=0
?>

<?php if ( ( $uprav == 1 OR $uprav == 2 OR $uprav == 3 OR $uprav == 4 ) AND $riadok->id_klienta == $cislo_id ) {
?>
<tr style="">
<td colspan="9" class="mdl-data-table__cell--non-numeric" style="background-color: #ECEFF1; padding: 0; ">
<!-- <div class="" style="height: 10px; margin: 0 -10px; background-color: #ECEFF1;">&nbsp;</div> -->



<form method="post" action="users_md.php?copern=8&strana=<?php echo $strana;?>&cislo_id=<?php echo $cislo_id; ?>&uprav=<?php echo $uprav; ?>" id="formv" name="formv" style="">

<div class="mdl-card mdl-shadow--4dp " style="min-height: 100px;    "> <!-- mdl-shadow--6dp margin: 0 -10px; -->
<div class="mdl-card__title " style="padding: 0; ">

<div class="mdl-tabs mdl-js-tabs" style="">
<div class="mdl-tabs__tab-bar" style="padding: ; background-color: ; ">
  <a href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-tabs__tab" style="">
    <div class="mdl-list__item" style="padding-top: 8px;">
      <span class="mdl-list__item-primary-content">
        <span class="mdl-list__item-avatar"><?php echo $cislo_id; ?></span>
        <span style="text-transform: none;"><?php echo "$riadok->meno $riadok->priezvisko"; ?> /</span>
        <span style="font-weight: 400; text-transform: ;">&nbsp;úprava</span>
      </span>
    </div>
  </a>
  <div class="mdl-layout-spacer"></div>
  <a href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,2);" class="mdl-tabs__tab">Firmy</a>
  <a href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,3);" class="mdl-tabs__tab">Skripty</a>
  <a href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,4);" class="mdl-tabs__tab">
<?php if ( $jegrid == 1 ) { ?>
  <span class="" style="position: absolute; top: 3px; left:50%; border-radius: 50%; margin-left: -3px; background-color: #39f; width: 6px; height: 6px; ">&nbsp;</span>Grid</a>
<?php                     } ?>
  <a href="#" id="edit-closer" onclick="closeId(<?php echo $riadok->id_klienta; ?>);" class="mdl-tabs__tab"><i class="material-icons vacenter">close</i></a>
  <div data-mdl-for="edit-closer" class="mdl-tooltip">Zavrie</div>
</div>
</div>
</div> <!-- .mdl-card-title -->

<div class="" style="padding: 12px 12px 8px 12px;">

<?php if ( $uprav == 1 ) { ?>
<section class="mdl-tabs__panel flexbox" style="justify-content: space-between;">

<fieldset class="" style="  background-color: ; ">
  <i class="material-icons mdl-color-text--grey-500 vacenter" style="">person&nbsp;</i>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label ukaz hidden" style="width: 40px; ">
    <input type="text" id="h_id" name="h_id" class="mdl-textfield__input"  style="">
    <label for="h_id" class="mdl-textfield__label "  style="">ID</label>
</div>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100px;">
    <input type="text" id="h_meno" name="h_meno" autofocus maxlength="20" required class="mdl-textfield__input"  style="">
    <label for="h_meno" class="mdl-textfield__label"  style="">Meno *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px;">
    <input type="text" id="h_prie" name="h_prie" maxlength="20" class="mdl-textfield__input"  style="">
    <label for="h_prie" class="mdl-textfield__label "  style="">Priezvisko</label>
  </div>
</fieldset>

<fieldset class="" style="  ">
  <i class="material-icons mdl-color-text--grey-500 vacenter">&nbsp;lock_open&nbsp;</i>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100px;">
    <input type="text" id="h_uzm" name="h_uzm" maxlength="10" required class="mdl-textfield__input"  style="">
    <label for="h_uzm" class="mdl-textfield__label"  style="">Meno *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100px;">
    <input type="text" id="h_uzh" name="h_uzh" maxlength="10" required class="mdl-textfield__input"  style="">
    <label for="h_uzh" class="mdl-textfield__label"  style="">Heslo *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
</fieldset>

<fieldset class="" style="">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 56px;">
    <input type="text" id="h_all" name="h_all" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input" style="">
    <label for="h_all" class="mdl-textfield__label"  style="">Prístup</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
</fieldset>
<fieldset class="" style="">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_uct" name="h_uct" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_uct" class="mdl-textfield__label"  style="">Úètovníctvo</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_mzd" name="h_mzd" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_mzd" class="mdl-textfield__label"  style="">Mzdy</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_fak" name="h_fak" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_fak" class="mdl-textfield__label"  style="">Odbyt</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_skl" name="h_skl" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_skl" class="mdl-textfield__label"  style="">Sklad</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_him" name="h_him" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_him" class="mdl-textfield__label"  style="">Majetok</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_dop" name="h_dop" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_dop" class="mdl-textfield__label"  style="">Doprava</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_vyr" name="h_vyr" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_vyr" class="mdl-textfield__label"  style="">Vıroba</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60px;">
    <input type="text" id="h_ana" name="h_ana" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label class="mdl-textfield__label" for="h_ana" style="">Analızy</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
</fieldset>
  </section>
<?php } ?>

<?php if ( $uprav == 2 ) { ?>
<section class="mdl-tabs__panel flexbox">
  <fieldset style="width: 600px;">
  <legend>Prístupné firmy</legend>
<?php
$sqlttf = "SELECT * FROM firuz WHERE uzid = $cislo_id ORDER BY fiod, fido";
$sqlf = mysql_query("$sqlttf");

//celkom poloziek
$cpolf = mysql_num_rows($sqlf);
$if = 0;
?>
<table>
<tr>
  <th>UZID</th>
  <th>Èíslo OD</th>
  <th>Èíslo DO</th>
  <th>Del</th>
  <th>&nbsp;</th>
</tr>
<?php
   while ( $if <= $cpolf )
   {
?>
<?php
  if (@$zaznamf=mysql_data_seek($sqlf,$if))
  {
$riadokf=mysql_fetch_object($sqlf);
?>
<tr>
  <td><?php echo $riadokf->uzid;?></td>
  <td><?php echo $riadokf->fiod;?></td>
  <td><?php echo $riadokf->fido;?></td>
  <td><a href="#" onClick="zmazSetFirmy(<?php echo $riadokf->cplf;?>);">Vymaza</a></td>
</tr>
<?php
  }
$if = $if + 1;
   }
?>
<tr>
<td><?php echo $uzid; ?></td>
<td><input type="text" name="fiod" id="fiod" autofocus size="7"  /></td>
<td><input type="text" name="fido" id="fido" size="7"  /></td>
<td><a href="#" onClick="KtoMa();">Kto má prístup do firiem èíslo od - do</a></td>
</tr>
</table>



  </fieldset>
  <fieldset style="">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 500px;">
    <input class="mdl-textfield__input" type="text" id="h_txt1" name="h_txt1" style="">
    <label class="mdl-textfield__label " for="h_txt1" style="">Firmy</label>
  </div>
  </fieldset>
</section>
<?php } ?>

<?php if ( $uprav == 3 ) { ?>
<section class="mdl-tabs__panel ">
<fieldset>
<legend>Obmedzené skripty</legend>
<?php
$sqlttp = "SELECT * FROM menp WHERE prav = $cislo_id ORDER BY prav, datm DESC";
$sqlp = mysql_query("$sqlttp");

//celkom poloziek
$cpolp = mysql_num_rows($sqlp);
$ip = 0;
?>
<table>
<tr>
  <th>UZID</th>
  <th>Skript</th>
  <th>Aktualizované</th>
  <th>&nbsp;</th>
</tr>
<?php
   while ($ip <= $cpolp )
   {
?>
<?php
  if (@$zaznamp=mysql_data_seek($sqlp,$ip))
  {
$riadokp=mysql_fetch_object($sqlp);
?>
<tr>
  <td><?php echo $riadokp->prav;?></td>
  <td><?php echo $riadokp->cslm;?></td>
  <td>.<?php echo $riadokp->datm;?> <?php echo $riadokp->sys;?></td>
  <td><a href="#" onClick="ZmazSkript(<?php echo $riadokp->prav;?>, <?php echo $riadokp->cslm;?>, '<?php echo $riadokp->datm;?>' );">Vymaza</a></td>
</tr>
<?php
  }
$ip = $ip + 1;
   }
?>
<tr>
  <td><input type="text" name="uzid" id="uzid" style="width: 50px;" />
  <td><input type="text" name="cslm" id="cslm" style="width: 50px;"/>
  <td></td>
  <td></td>
</tr>
</table>
  <a href="#" onClick="Help();">Help</a>
</fieldset>
</section>
<?php } ?>

<?php if ( $uprav == 4 ) { ?>
<section class="mdl-tabs__panel ">
<fieldset>
<legend>Grid karta</legend>
<p>

<a href="#" onClick="window.open('../cis/grid.php?copern=10&cislo_id=<?php echo $cislo_id;?>', '_blank')">Vytlaèi</a><br>
<a href="#" onClick="window.open('../cis/grid.php?copern=11&cislo_id=<?php echo $cislo_id;?>', '_blank')">Vygenerova novú kartu</a><br>
<a href="#" onClick="window.open('../cis/grid.php?copern=15&cislo_id=<?php echo $cislo_id;?>', '_blank')">Nastavi PIN všetky polia rovnaké</a><br>
<a href="#" onClick="window.open('../cis/grid.php?copern=13&cislo_id=<?php echo $cislo_id;?>', '_blank')">Nastavi cviènú GridKartu 1234</a><br>
<a href="#" onClick="window.open('../cis/grid.php?copern=14&cislo_id=<?php echo $cislo_id;?>', '_blank')">Zmaza</a>
</p>
</fieldset>
</section>
<?php } ?>

</div>

<div class="mdl-card__actions  right" style=" ">
  <button class="mdl-button mdl-js-button mdl-color-text--grey-500">Zruši</button>
  <button id="uloz" name="uloz" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--light-blue-700">Uloi</button>
</div>


</div> <!-- .mdl-card -->
</form>
<!-- <div class="" style="height: 16px; margin: 0 -10px; background-color: #ECEFF1;">&nbsp;</div> -->
      </td>

</tr>
<?php
      } //uprav=1
?>





<?php
  }
$i = $i + 1;
   }
?>






  </tbody>
  <tfoot class="mdl-color--grey-100">
    <tr>
      <td colspan="2" class="mdl-data-table__cell--non-numeric">= <?php echo $cpol; ?></td>
      <td colspan="6">
<form name="forma3" id="forma3" action="#" class="table-pagination " style="">
      <label for="selectpage" class="" style="vertical-align: middle; ">Strana&nbsp;&nbsp;&nbsp;<select name="selectpage" id="selectpage" onchange="ChodNaStranu();" style="font-size: 12px; border: 0; color: rgba(0,0,0, 0.87); border-bottom: 1px solid rgba(0,0,0,0.12); background-color: transparent; min-width: 32px; padding-bottom: 2px; padding-top: 4px;">
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
      </select>&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo $xstr; ?></label>
      </td>
      <td>
      <button id="btnpageprev" type="button" onclick="NaStr(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_before</i></button><div class="mdl-tooltip" data-mdl-for="btnpageprev" >Prejs na stranu <?php echo $ppage; ?></div>
      <button id="btnpagenext" type="button" onclick="NaStr(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">navigate_next</i></button><div class="mdl-tooltip" data-mdl-for="btnpagenext">Prejs na stranu <?php echo $npage; ?></div>
      </td>
</form>
    </tr>
  </tfoot>
  </table>

</div> <!-- .mdl-cell -->
</div> <!-- .mdl-grid -->

</main>





<div class="mdl-layout__drawer">
  <span class="mdl-layout-title">EuroSecom</span>
  <nav class="mdl-navigation">
    <a href="admin_md.php" class="mdl-navigation__link">Preh¾ad</a>
    <a href="users_md.php" class="mdl-navigation__link mdl-navigation__link--current">Uívatelia</a>
    <a href="firms_md.php" class="mdl-navigation__link">Firmy</a>
  </nav>
</div>








<!-- <form action="#" class="ukaz " style="">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable" style="">
      <label class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500" for="listfield" style=""><i class="material-icons ">search</i></label>
      <div class="mdl-textfield__expandable-holder" style="">
        <input class="mdl-textfield__input" type="text" id="listfield" pattern="-?[0-9]*(\.[0-9]+)?" style="max-width: 1000px;">
        <label class="mdl-textfield__label" for="listfield">H¾adanı vıraz</label>
        <span class="mdl-textfield__error">Nevyh¾adávajte text!</span>
      </div>
    </div>
</form> -->













<footer class="mdl-mini-footer mdl-color--white hidden">
  <div class="mdl-mini-footer__left-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#">EuroSecom</a></li>
    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#">EDcom</a></li>
    </ul>
  </div>
</footer>
</div> <!-- .mdl-layout -->


<script type="text/javascript">

  function ObnovUI()
  {
   document.forma3.selectpage.value = '<?php echo $strana; ?>';

//start end pagination
<?php if ( $strana == 1 ) { ?>
   document.getElementById('btnpageprev').disabled = true;
<?php } ?>
<?php if ( $strana == $xstr ) { ?>
   document.getElementById('btnpagenext').disabled = true;
<?php } ?>

//edit row
<?php if ( $uprav != 0 ) { ?>
  document.getElementById('selectpage').disabled = true;
  document.getElementById('selectpage').style.cursor = 'default';
  document.getElementById('selectpage').style.opacity = '0.5';
  document.querySelector('.floating-toolbar').style.display = 'none';
  document.querySelector('.data-table').style.backgroundColor = 'transparent';

  // var tableheader = document.querySelector('.data-table thead');
  // tableheader.className = tableheader.className == 'mdl-color--blue-grey-50' ? 'mdl-color--grey-100' : 'mdl-color--blue-grey-50';




  document.querySelector('.data-table thead tr:last-child').style.opacity = '0.5';
//dopyt, ešte ošetri vyh¾adávanie
  var rows = document.querySelectorAll('.row-echo > td');
  for ( var i = 0; i < rows.length; i++ ) {
    rows[i].style.opacity='0.5';
  }
  var buttons = document.querySelectorAll('.row-echo button');
  for ( var i = 0; i < buttons.length; i++ ) {
    buttons[i].disabled = true;
  }
  document.getElementById('btnpageprev').disabled = true;
  document.getElementById('btnpagenext').disabled = true;
<?php                    } ?>






//var widthview = document.documentElement.clientWidth;
//var menu =  document.getElementById('<?php echo $riadok->id_klienta; ?>moretools');

//if ( widthview =< 1024 ) { menu.className=menu.className=='mdl-menu--bottom-right'?'mdl-menu--bottom-left':'mdl-menu--bottom-right'; }



<?php if ( $uprav == 1 ) { ?>


   // document.formv.h_meno.focus();
   document.formv.h_id.value = '<?php echo "$cislo_id"; ?>';
   document.formv.h_uzm.value = '<?php echo "$h_uzm"; ?>';
   document.formv.h_uzh.value = '<?php echo "$h_uzh"; ?>';
   document.formv.h_prie.value = '<?php echo "$h_prie"; ?>';
   document.formv.h_meno.value = '<?php echo "$h_meno"; ?>';
   document.formv.h_all.value = '<?php echo "$h_all"; ?>';
   document.formv.h_uct.value = '<?php echo "$h_uct"; ?>';
   document.formv.h_mzd.value = '<?php echo "$h_mzd"; ?>';
   document.formv.h_skl.value = '<?php echo "$h_skl"; ?>';
   document.formv.h_fak.value = '<?php echo "$h_fak"; ?>';
   document.formv.h_him.value = '<?php echo "$h_him"; ?>';
   document.formv.h_dop.value = '<?php echo "$h_dop"; ?>';
   document.formv.h_vyr.value = '<?php echo "$h_vyr"; ?>';
   document.formv.h_ana.value = '<?php echo "$h_ana"; ?>';


<?php                   } ?>

<?php if ( $uprav == 2 AND $zmazane == 1 ) { ?>
   document.formv.fiod.value = '<?php echo "$z_fiod"; ?>';
   document.formv.fido.value = '<?php echo "$z_fido"; ?>';

<?php                   } ?>

<?php if ( $uprav == 2 ) { ?>
   document.formv.h_txt1.value = '<?php echo "$h_txt1"; ?>';

<?php                   } ?>





  }

  function Uzivatelia()
  {
  window.open('users_md.php?copern=1&strana=1&xxx=1', '_self');
  }


  function NastavFirmu( id, page )
  {
  window.open('users_md.php?cislo_id=' + id + '&copern=1001&strana=' + page + '&xxx=1', '_self' );
  }


  function ZoznamFir(uzivatel) //dopyt, bude len v úprave uívate¾a
  {
  window.open('../cis/setuzfir.php?copern=1&uzid=' + uzivatel + '&tt=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

  function ChodNaStranu()
  {
   var chodna = document.forma3.selectpage.value;
   window.open('users_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function NaStr(chodna)
  {
   window.open('users_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function upravId(uzivatel,uprav)
  {
    window.open('users_md.php?copern=<?php echo $copern; ?>&strana=<?php echo $strana; ?>&cislo_id=' + uzivatel + '&uprav=' + uprav + '', '_self');
  // var tab = document.getElementsByClassName("mdl-tabs__tab");



  }










  function closeId(uzivatel)
  {
    window.open('users_md.php?copern=1&strana=<?php echo $strana; ?>&uprav=0', '_self');
  }

  function zmazId(uzivatel)
  {
  window.open('users_md.php?copern=6&strana=<?php echo $strana;?>&cislo_id=' + uzivatel + '&tt=1','_self');
  }


function zmazSetFirmy(cplf)
                {
window.open('users_md.php?copern=6&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&uprav=2&cplf=' + cplf + '&drupoh=1', '_self' );
                }

function ZmazSkript(uzid, cslm, datm)
                {
window.open('users_md.php?copern=6&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&uprav=3&cslm=' + cslm + '&datm=' + datm + '&drupoh=1', '_self' );
                }


</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>