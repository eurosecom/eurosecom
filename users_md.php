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
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) { $strana = 1; }
$min_uzall=50000;
if( $kli_uzall >= 100000 ) { $min_uzall=999999;}

$server_name = $_SERVER['SERVER_NAME'];


$uprav = 1*$_REQUEST['uprav'];
$cislo_id = 1*$_REQUEST['cislo_id'];
//$tab = 1*$_REQUEST['tab'];
$hladanie = 1*$_REQUEST['hladanie'];
$cohladat = trim($_REQUEST['cohladat']);
if( $cohladat == '' ){ $hladanie=0; }
//echo $cohladat."<br />";

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
$sqlpoktt = "SELECT * FROM menp WHERE prav='$cislo_id' AND cslm='$cslm' AND  datm='$datm' ";
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



//vybrany uzivatel cislo_id s gridkartou
$jegridid=0;
$sqlpoktt = "SELECT * FROM krtgrd WHERE id = $cislo_id ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jegridid=1;
  }

//vybrany uzivatel cislo_id s obmedzenim skriptov
$jemenpid=0;
$sqlpoktt = "SELECT * FROM menp WHERE prav = $cislo_id ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jemenpid=1;
  }


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
<aside class="floating-toolbar " style="top:80px; ">
  <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-color--green-500"><i class="material-icons">add</i></button>
  <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab"><i class="material-icons">print</i></button>
</aside>



<div class="mdl-grid mdl-grid--no-spacing" style="max-width: 1200px; ">
<div class="mdl-cell--12-col">

<?php
$sqltt = "SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta ";
if( $hladanie == 1 )
{ 
$sqltt = "SELECT * FROM klienti WHERE all_prav < $min_uzall AND ( priezvisko LIKE '%$cohladat%' OR meno LIKE '%$cohladat%' ) ORDER BY id_klienta ";
}
$sql = mysql_query("$sqltt");
//$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < 1 ORDER BY id_klienta ");//prazdny zoznam
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15;
if( $hladanie == 1 ){ $pols = 900; }
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
  <tr style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); height: 48px;">
    <th colspan="2" class="mdl-data-table__cell--non-numeric">
      <span class="table-title">
        <span class="title-upper">Èíselník uívate¾ov</span>
<?php
if ( $uprav != 0 ) echo "/ úprava id $cislo_id";


 ?> <!-- dopyt, doplni ïalšie stavy -->
      </span>
    </th>
    <th colspan="7" class="">
<form method="post" action="users_md.php?hladanie=1&copern=1&strana=1&uprav=0" id="formhladaj" name="formhladaj">
  <div class="" style=" padding-top: 10px; float: right;  ">
    <button id="ulozh" name="ulozh" type="submit" class="mdl-button mdl-js-button mdl-button--icon mdl-color--grey-300 toleft" style=""><i class="material-icons">search</i></button>
    <input type="text" id="cohladat" name="cohladat" value="<?php echo $cohladat; ?>" placeholder="H¾adanı vıraz..." class="mdl-textfield__input" style="font-size: 14px; width: 150px; float: left;">

  </div>



<!--   <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable " style="padding-top: 11px;">
    <label class="mdl-button mdl-js-button mdl-button--icon" for="sample6" style="top:9px;">
      <i class="material-icons">search</i>
    </label>
    <div class="mdl-textfield__expandable-holder">
      <input class="mdl-textfield__input " type="text" id="cohladat" name="cohladat" style="font-size: 14px;">
      <label class="mdl-textfield__label " for="cohladat" style="top: 4px; left: 0; font-size: 14px;">H¾adanı vıraz...</label>
    </div>
  </div> -->
</form>

      </th>
    </tr>
   <tr class="two-line" style="">
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

<?php  if ( $riadok->id_klienta != $cislo_id ) { ?>
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
  $poslpr = date("d.m.Y H:i:s", strtotime($riadokpok->datm));
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
<i id="<?php echo $riadok->id_klienta; ?>firmsformat" class="material-icons mdl-color-text--grey-500 vacenter" style="font-size: 16px; ">error_outline</i>
<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="<?php echo $riadok->id_klienta; ?>firmsformat">Firmy nastavené v starom formáte</div>




<?php if ( $riadok->txt1 == "0-0" ) { ?>
<?php echo $akefirmy; ?>
<?php                              } ?>

        <?php echo $riadok->txt1; ?>

      </td>
      <td><?php echo $riadok->all_prav; ?></td>
      <td>
        <span id="<?php echo $riadok->id_klienta; ?>uct"><?php echo $riadok->uct_prav; ?></span><br>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>uct" class="mdl-tooltip" style="margin-top: -7px;">Úètovníctvo</span>
        <span id="<?php echo $riadok->id_klienta; ?>maj"><?php echo $riadok->him_prav; ?></span>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>maj" class="mdl-tooltip" style="margin-top: -7px;">Majetok</span>
      </td>
      <td>
        <span id="<?php echo $riadok->id_klienta; ?>mzd"><?php echo $riadok->mzd_prav; ?></span><br>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>mzd" class="mdl-tooltip" style="margin-top: -7px;">Mzdy</span>
        <span id="<?php echo $riadok->id_klienta; ?>dop"><?php echo $riadok->dop_prav; ?></span>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>dop" class="mdl-tooltip" style="margin-top: -7px;">Doprava</span>
      </td>
      <td>
        <span id="<?php echo $riadok->id_klienta; ?>fak"><?php echo $riadok->fak_prav; ?></span><br>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>fak" class="mdl-tooltip" style="margin-top: -7px;">Odbyt</span>
        <span id="<?php echo $riadok->id_klienta; ?>vyr"><?php echo $riadok->vyr_prav; ?></span>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>vyr" class="mdl-tooltip" style="margin-top: -7px;">Vıroba</span>
      </td>
      <td>
        <span id="<?php echo $riadok->id_klienta; ?>skl"><?php echo $riadok->skl_prav; ?></span><br>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>skl" class="mdl-tooltip" style="margin-top: -7px;">Sklad</span>
        <span id="<?php echo $riadok->id_klienta; ?>ana"><?php echo $riadok->ana_prav; ?></span>
        <span data-mdl-for="<?php echo $riadok->id_klienta; ?>ana" class="mdl-tooltip" style="margin-top: -7px;">Analızy</span>
      </td>
      <td>
        <button type="button" id="<?php echo $riadok->id_klienta; ?>itemedit" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-500"><i class="material-icons ">edit</i></button>
      <div class="mdl-tooltip" data-mdl-for="<?php echo $riadok->id_klienta; ?>itemedit">Upravi</div>
        <button id="<?php echo $riadok->id_klienta; ?>moretools" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500"><i class="material-icons">more_vert</i></button>
        <div class="mdl-tooltip" data-mdl-for="<?php echo $riadok->id_klienta; ?>moretools">Ïalšie akcie</div>
<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect table-row-menu" for="<?php echo $riadok->id_klienta; ?>moretools" style=""  >
  <li class="mdl-menu__item"><i class="material-icons mdl-color-text--grey-500 vacenter" style="">content_copy</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kopírova</li>
  <li disabled class="mdl-menu__item"><i class="material-icons vacenter">remove</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vymaza
<i id="<?php echo $riadok->id_klienta; ?>userremove" class="material-icons vacenter" style="">info_outline</i>

  <div data-mdl-for="<?php echo $riadok->id_klienta; ?>userremove" class="mdl-tooltip">Nie je moné vymaza uívate¾a,<br> iba ho nastavi ako neaktívny</div>
  </li>
  <li onclick="NastavFirmu(<?php echo $riadok->id_klienta; ?>, <?php echo $strana; ?>);" class="mdl-menu__item"><i class="material-icons mdl-color-text--grey-500 vacenter">build</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nastavi firmu <?php echo $mojexcf;?> a mesiac <?php echo $mojeume;?></li>
</ul>
     </td>
</tr>
<?php
      } //$uprav=0
?>

<?php if ( $uprav != 0 AND $riadok->id_klienta == $cislo_id ) {
?>
<tr>
<td colspan="9" class="mdl-data-table__cell--non-numeric" style="padding: 0;">
<form method="post" action="users_md.php?copern=8&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&uprav=<?php echo $uprav; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>" id="formv" name="formv">

<div class="mdl-card mdl-shadow--4dp card-row-edit" style="flex-direction: row;">

<nav class="mdl-navigation mdl-color--grey-100  " style="flex-direction: column;  width: 22%;  padding-top: 6px; padding-bottom: 6px;">
  <a id="navuser" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-list__item mdl-list__item--two-line mdl-navigation__link " style="cursor: pointer; height: 56px;">
    <span class="mdl-list__item-primary-content" style=" ">
      <span class="mdl-list__item-avatar " style=""><?php echo $cislo_id; ?></span>
      <span class=""><?php echo "$riadok->meno $riadok->priezvisko"; ?></span>
      <span class="mdl-list__item-sub-title">úprava</span> <!-- dopyt, ešte stav novı -->
    </span>
  </a>
  <a id="navfirm" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,2);" class="mdl-navigation__link">Prístupné firmy</a>
  <a id="navscript" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,3);" class="mdl-navigation__link">Blokované skripty<?php if ( $jemenpid == 1 ) { ?><span class="circle">&nbsp;</span><?php } ?></a>

  <a id="navgrid" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,4);" class="mdl-navigation__link">Grid karta<?php if ( $jegridid == 1 ) { ?><span class="circle">&nbsp;</span><?php } ?></a>
</nav>
<div class="mdl-card__supporting-text" style=" width: 78%; position: relative;"> <!-- padding: 12px 12px 8px 12px; -->

<?php if ( $uprav == 1 ) { ?>
<section class="flexbox " style="flex-wrap: wrap; background-color: ; padding-left: 12px;">


<fieldset class="" style="margin-right: 24px;  background-color: ; ">
<i class="material-icons mdl-color-text--grey-500 vacenter" style="">person&nbsp;</i>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 40px; margin-right: 6px;">
    <input type="text" id="h_id" name="h_id" disabled class="mdl-textfield__input"  style="" value="<?php echo $cislo_id; ?>">
    <label for="h_id" class="mdl-textfield__label"  style="">ID</label>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 6px;">
    <input type="text" id="h_meno" name="h_meno" autofocus maxlength="20" required class="mdl-textfield__input"  style="">
    <label for="h_meno" class="mdl-textfield__label"  style="">Meno *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 6px;">
    <input type="text" id="h_prie" name="h_prie" maxlength="20" class="mdl-textfield__input"  style="">
    <label for="h_prie" class="mdl-textfield__label "  style="">Priezvisko</label>
  </div>
</fieldset>
<fieldset style="margin-right: 52px;  ">
  <i class="material-icons mdl-color-text--grey-500 vacenter" style="">lock_open&nbsp;</i>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 6px;">
    <input type="text" id="h_uzm" name="h_uzm" maxlength="10" required class="mdl-textfield__input"  style="">
    <label for="h_uzm" class="mdl-textfield__label"  style="">Meno *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 6px;">
    <input type="text" id="h_uzh" name="h_uzh" maxlength="10" required class="mdl-textfield__input"  style="">
    <label for="h_uzh" class="mdl-textfield__label"  style="">Heslo *</label>
    <span class="mdl-textfield__error">Povinné pole!</span>
  </div>
</fieldset>
<fieldset class="" style="padding-left: 32px;">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 110px; margin-right: 32px;">
    <input type="text" id="h_all" name="h_all" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input" style="">
    <label for="h_all" class="mdl-textfield__label"  style="">Celkovı prístup</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_uct" name="h_uct" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_uct" class="mdl-textfield__label"  style="">Úètovníctvo</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_mzd" name="h_mzd" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_mzd" class="mdl-textfield__label"  style="">Mzdy</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_fak" name="h_fak" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_fak" class="mdl-textfield__label"  style="">Odbyt</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_skl" name="h_skl" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_skl" class="mdl-textfield__label"  style="">Sklad</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>

  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_him" name="h_him" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_him" class="mdl-textfield__label"  style="">Majetok</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_dop" name="h_dop" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_dop" class="mdl-textfield__label"  style="">Doprava</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_vyr" name="h_vyr" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label for="h_vyr" class="mdl-textfield__label"  style="">Vıroba</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80px; margin-right: 6px;">
    <input type="text" id="h_ana" name="h_ana" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input"  style="">
    <label class="mdl-textfield__label" for="h_ana" style="">Analızy</label>
    <span class="mdl-textfield__error">Povolené sú èísla!</span>
  </div>
</fieldset>
<fieldset class=" " style="width: 300px; padding-left: 32px; padding-top: 12px; ">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect toleft" for="switch-1" style=" ">
  <input type="checkbox" id="switch-1" class="mdl-switch__input" checked>
  <span class="mdl-switch__label">Ne/aktívny</span>
</label>
<div id="uvolni" onmouseover="return Povol_uloz();" class="ukaz" style="position: absolute; right: 0; bottom: 0; padding: 16px;">
  <button id="uloz" name="uloz" class=" " style="">Uloi</button>
</div>
</fieldset> <!-- mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--light-blue-700 -->
  </section>
<?php } ?>



<?php if ( $uprav == 2 ) { ?>
<section class="flexbox" style="padding: 0 72px 0 32px; flex-wrap: wrap; align-items: flex-start; ">

<?php
$sqlttf = "SELECT * FROM firuz WHERE uzid = $cislo_id ORDER BY cplf DESC";
$sqlf = mysql_query("$sqlttf");

//celkom poloziek
$cpolf = mysql_num_rows($sqlf);
$if = 0;
?>

<table class="mdl-data-table data-table" style="border: 0; width: 320px; margin-bottom: 20px; margin-right: 72px;">
<thead class="mdl-color--grey-200">
<tr style=" ">
  <th class="" style="padding:0; width: 25%; text-align:center;">Firmy:&nbsp;<a href="#" class="mdl-color-text--grey-500" style="position: absolute; top: 7px;"><i id="listfirm" class="md-18 material-icons" style="line-height: 1; ">info_outline</i></a>
<span for="listfirm" class="mdl-tooltip">Zobrazi èíselník firiem</span>
</th>
  <th class="" style="width: 25%; text-align: center;">Od</th>
  <th class="" style="width: 25%; text-align: center;">Do</th>
  <th style="width: 25%; padding: 0;">&nbsp;</th>
</tr>
</thead>
<tbody>
<tr class="mdl-color--white">
  <td class="mdl-data-table__cell--non-numeric" style="padding:0; text-align: center; ">
    <a id="searchkto" href="#" onclick="KtoMa();" class="mdl-button mdl-js-button mdl-button--icon" style=""><i class="material-icons">search</i></a>
    <div data-mdl-for="searchkto" class="mdl-tooltip">Kto má prístup do firiem od - do</div>
  </td>
  <td class="" style="text-align: center; ">
    <div class="mdl-textfield mdl-js-textfield" style="width: 50px; padding-top: 12px;">
      <label class="mdl-textfield__label" for="fiod" style="">&nbsp;</label>
      <input type="text" id="fiod" name="fiod" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" autofocus class="mdl-textfield__input">
      <span class="mdl-textfield__error">Povolené sú èísla!</span>
    </div>
  </td>
  <td class="" style="text-align: center; ">
    <div class="mdl-textfield mdl-js-textfield " style="width: 50px; padding-top: 12px;">
      <label class="mdl-textfield__label" for="fido" style="">&nbsp;</label>
      <input type="text" id="fido" name="fido" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
      <span class="mdl-textfield__error">Povolené sú èísla!</span>
    </div>
  </td>
  <td>
    <div id="uvolni" onmouseover="return Povol_uloz();" class="" style=" padding: 16px;">
      <button id="uloz" name="uloz" class=" " style="">Uloi</button>
    </div>
  </td>
</tr>
<?php
while ( $if <= $cpolf )
{
  if ( @$zaznamf=mysql_data_seek($sqlf,$if) )
  {
$riadokf=mysql_fetch_object($sqlf);
?>
<tr class="mini-row-echo" style="">
  <td style="">&nbsp;</td>
  <td style="text-align: center;"><?php echo $riadokf->fiod; ?></td>
  <td class="mdl-data-table__cell--non-numeric" style="text-align: center;"><?php echo $riadokf->fido; ?></td>
  <td class="" style="">
    <i id="edit<?php echo $riadokf->cplf; ?>" onclick="zmazSetFirmy(<?php echo $riadokf->cplf; ?>);" class="material-icons mdl-color-text--red-500 vacenter mini-icon-btn" style="cursor: pointer;">remove</i> <!-- dopyt, spravi class mini button -->
    <div data-mdl-for="edit<?php echo $riadokf->cplf; ?>" class="mdl-tooltip">Upravi / Vymaza</div>
  </td>
</tr>
<?php
  }
$if = $if + 1;
   }
?>
</tbody>
</table>

  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label " style="width: 350px; display: ;">
    <input class="mdl-textfield__input" type="text" id="h_txt1" name="h_txt1" style="">
    <label class="mdl-textfield__label " for="h_txt1" style="">Firmy (starı formát)</label>
  </div>
</section>
<?php } ?>


<?php if ( $uprav == 3 ) { ?>
<section class="flexbox" style="padding: 0 72px 0 32px; flex-wrap: wrap;">
<?php
$sqlttp = "SELECT * FROM menp WHERE prav = $cislo_id ORDER BY datm DESC";
$sqlp = mysql_query("$sqlttp");

//celkom poloziek
$cpolp = mysql_num_rows($sqlp);
$ip = 0;
?>
<table class="mdl-data-table data-table" style="border: 0; width: 350px; margin-bottom: 20px; margin-right: 72px;">
<thead class="mdl-color--grey-200">
<tr>
<!--   <th>UZID</th> -->
  <th class="" style="width: 40%; text-align: left;">Skript&nbsp;<a href="#" onclick="Help();" class="mdl-color-text--grey-500" style="position: absolute; top: 7px;"><i id="listscript" class="md-18 material-icons" style="line-height: 1; ">info_outline</i></a>
<span for="listscript" class="mdl-tooltip">Zobrazi èíselník skriptov</span>
  </th>
  <th style="width: 40%; text-align: left;">Aktualizované</th>
  <th style="width: 20%;">&nbsp;</th>
</tr>
</thead>
<tbody>
<tr class="mdl-color--white">
  <td style="text-align: left; ">
    <input type="hidden" name="uzid" id="uzid"/>
    <div class="mdl-textfield mdl-js-textfield" style="width: 90px; padding-top: 6px;">
      <label class="mdl-textfield__label" for="cslm" style="">&nbsp;</label>
      <input type="text" id="cslm" name="cslm" maxlength="8" pattern="-?[0-9]*(\.[0-9]+)?" autofocus class="mdl-textfield__input">
      <span class="mdl-textfield__error">Povolené sú èísla!</span>
    </div>
  </td>
  <td>&nbsp;</td>
  <td><div id="uvolni" onmouseover="return Povol_uloz();" class="" style=" padding: 16px;">
  <button id="uloz" name="uloz" class=" " style="">Uloi</button>
</div></td>
</tr>
<?php
   while ($ip <= $cpolp )
   {
?>
<?php
  if (@$zaznamp=mysql_data_seek($sqlp,$ip))
  {
$riadokp=mysql_fetch_object($sqlp);
$datmsk = date("d.m.Y H:i:s", strtotime($riadokp->datm));
?>
<tr class="mini-row-echo">
<!--   <td><?php echo $riadokp->prav;?></td> -->
  <td style="text-align: left;"><?php echo $riadokp->cslm;?></td>
  <td style="text-align: left;"><?php echo $datmsk;?> <?php echo $riadokp->sys;?></td>
  <td>
    <i id="edit" onClick="ZmazSkript(<?php echo $riadokp->prav;?>, <?php echo $riadokp->cslm;?>, '<?php echo $riadokp->datm;?>' );" class="material-icons mdl-color-text--red-500 vacenter mini-icon-btn" style="cursor: pointer;">remove</i>
    <div data-mdl-for="edit" class="mdl-tooltip">Upravi / Vymaza</div>
  </td>
</tr>
<?php
  }
$ip = $ip + 1;
   }
?>
</tbody>
</table>


</section>
<?php } ?>


<?php if ( $uprav == 4 ) { ?>
<section class="flexbox" style="padding: 0 32px 0 32px; flex-wrap: wrap;">




<?php
//tlac grid
if ( $jegridid == 1 ) {
$sqlttg = "SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1";
$sqlg = mysql_query("$sqlttg");
$cpolg = mysql_num_rows($sqlg);
$ig=0;
?>
<table class=" grid-table" style="width: 350px;  border:0; border-collapse: collapse; padding: 0; ">
<colgroup>
  <col style="width:16%;">
  <col style="width:14%;">
  <col style="width:14%;">
  <col style="width:14%;">
  <col style="width:14%;">
  <col style="width:14%;">
  <col style="width:14%;">
</colgroup>
<tr>
  <th style="width: 16%; border:0;">&nbsp;</th>
  <th style="width: 14%;">A</th>
  <th style="width: 14%;">B</th>
  <th style="width: 14%;">C</th>
  <th style="width: 14%;">D</th>
  <th style="width: 14%;">E</th>
  <th style="width: 14%;">F</th>
</tr>
<?php
   while ($ig <= $cpolg )
   {

if (@$zaznamg=mysql_data_seek($sqlg,$ig))
{
$riadokg=mysql_fetch_object($sqlg);
?>
<tr>
  <th>1</th>
  <td style="border:0;"><?php echo $riadokg->a1; ?></td>
  <td style="border:0;"><?php echo $riadokg->b1; ?></td>
  <td style="border:0;"><?php echo $riadokg->c1; ?></td>
  <td style="border:0;"><?php echo $riadokg->d1; ?></td>
  <td style="border:0;"><?php echo $riadokg->e1; ?></td>
  <td style="border:0;"><?php echo $riadokg->f1; ?></td>
</tr>
<tr>
  <th>2</th>
  <td><?php echo $riadokg->a2; ?></td>
  <td><?php echo $riadokg->b2; ?></td>
  <td><?php echo $riadokg->c2; ?></td>
  <td><?php echo $riadokg->d2; ?></td>
  <td><?php echo $riadokg->e2; ?></td>
  <td><?php echo $riadokg->f2; ?></td>
</tr>
<tr>
  <th>3</th>
  <td><?php echo $riadokg->a3; ?></td>
  <td><?php echo $riadokg->b3; ?></td>
  <td><?php echo $riadokg->c3; ?></td>
  <td><?php echo $riadokg->d3; ?></td>
  <td><?php echo $riadokg->e3; ?></td>
  <td><?php echo $riadokg->f3; ?></td>
</tr>
<tr>
  <th>4</th>
  <td><?php echo $riadokg->a4; ?></td>
  <td><?php echo $riadokg->b4; ?></td>
  <td><?php echo $riadokg->c4; ?></td>
  <td><?php echo $riadokg->d4; ?></td>
  <td><?php echo $riadokg->e4; ?></td>
  <td><?php echo $riadokg->f4; ?></td>
</tr>
<tr>
  <th>5</th>
  <td><?php echo $riadokg->a5; ?></td>
  <td><?php echo $riadokg->b5; ?></td>
  <td><?php echo $riadokg->c5; ?></td>
  <td><?php echo $riadokg->d5; ?></td>
  <td><?php echo $riadokg->e5; ?></td>
  <td><?php echo $riadokg->f5; ?></td>
</tr>
<tr>
  <th style="border:0;">6</th>
  <td style="border:0;"><?php echo $riadokg->a6; ?></td>
  <td style="border:0;"><?php echo $riadokg->b6; ?></td>
  <td style="border:0;"><?php echo $riadokg->c6; ?></td>
  <td style="border:0;"><?php echo $riadokg->d6; ?></td>
  <td style="border:0;"><?php echo $riadokg->e6; ?></td>
  <td style="border:0;"><?php echo $riadokg->f6; ?></td>
</tr>
<?php
  }
$ig = $ig + 1;
   }
?>
<?php if ( $jegridid != 1 ) { ?>
<tr>
  <td colspan="7" rowspan="7"> iadna grid karta</td> <!-- dopyt, lepšie bude obrázok -->
</tr>
<?php } ?>
</table>
<?php
//koniec tlac grid
             }
?>





<div style="padding-left: 12px; width: 210px;">
  <button type="button" onclick="window.open('../cis/grid.php?copern=10&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_blank')" class="mdl-button mdl-js-button " style="width: 100%; font-size: 12px; text-align: left;  background-color: ;">
    <i class="material-icons mdl-list__item-icon" style="margin: -1px 16px 0 0; background-color: ;">print</i>Vytlaèi
  </button>
  <button type="button" onclick="window.open('../cis/grid.php?copern=11&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self')" class="mdl-button mdl-js-button " style="width: 100%; font-size: 12px; text-align: left;  background-color: ;">
    <i class="material-icons mdl-list__item-icon" style="margin: -1px 16px 0 0; background-color: ;">add</i>Generova
  </button>
  <button type="button" onclick="window.open('../cis/grid.php?copern=15&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self')" class="mdl-button mdl-js-button " style="width: 100%; font-size: 12px; text-align: left;  background-color: ;">
    <i class="material-icons mdl-list__item-icon" style="margin: -1px 16px 0 0; background-color: ;">settings</i>Nastavi rovnaké PIN
  </button>
  <button type="button" onclick="window.open('../cis/grid.php?copern=13&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self')" class="mdl-button mdl-js-button " style="width: 100%; font-size: 12px; text-align: left;  background-color: ;">
    <i class="material-icons mdl-list__item-icon" style="margin: -1px 16px 0 0; background-color: ;">settings</i>Nastavi PIN 1234
  </button>
  <button type="button" onclick="window.open('../cis/grid.php?copern=14&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self')" class="mdl-button mdl-js-button " style="width: 100%; font-size: 12px; text-align: left;  background-color: ;">
    <i class="material-icons mdl-list__item-icon" style="margin: -1px 16px 0 0; background-color: ;">remove_circle_outline</i>Zruši
  </button>

</div>



</section>
<?php } ?>


</div> <!-- .mdl-card__supporting-text -->

<div class="mdl-card__menu" style="top: 8px; right: 12px;">
  <a href="#" id="edit-closer" onclick="closeId(<?php echo $riadok->id_klienta; ?>);" class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">close</i></a>
  <div data-mdl-for="edit-closer" class="mdl-tooltip">Zavrie</div>
</div>

</div> <!-- .mdl-card -->
</form>
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
<?php if ( $uprav != 0 )
{
?>
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

  // var links = document.querySelectorAll('.mdl-navigation > .mdl-navigation__link');
  // for ( var i = 0; i < links.length; i++ ) {
  //   links[i].style.cssText='pointer-events: none;';
  // }
  // document.querySelector('.header-nav > .header-nav-link.active').style.cssText='color: rgba(255,255,255,.7); border-bottom-color: rgba(255,255,255,.7); pointer-events: none;'






<?php
}
//edit row
?>

<?php if ( $uprav == 1 ) { ?> document.getElementById('navuser').className += ' active'; <?php } ?>
<?php if ( $uprav == 2 ) { ?> document.getElementById('navfirm').className += ' active'; <?php } ?>
<?php if ( $uprav == 3 ) { ?> document.getElementById('navscript').className += ' active'; <?php } ?>
<?php if ( $uprav == 4 ) { ?> document.getElementById('navgrid').className += ' active'; <?php } ?>






//var widthview = document.documentElement.clientWidth;
//var menu =  document.getElementById('<?php echo $riadok->id_klienta; ?>moretools');

//if ( widthview =< 1024 ) { menu.className=menu.className=='mdl-menu--bottom-right'?'mdl-menu--bottom-left':'mdl-menu--bottom-right'; }



<?php if ( $uprav == 1 ) { ?>
// document.formv.h_meno.select();

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
   document.formv.uloz.disabled = true; 

<?php                   } ?>


<?php if ( $uprav == 3 AND $zmazane == 1 ) { ?>
   document.formv.cslm.value = '<?php echo "$z_cslm"; ?>';

<?php                   } ?>

<?php if ( $uprav == 3 ) { ?>
   document.formv.uloz.disabled = true; 

<?php                   } ?>


  }

    function Povol_uloz()
    {
    var okvstup=1;
<?php if ( $uprav == 2 ) { ?>
    if ( document.formv.fiod.value == '' ) okvstup=0;
    if ( document.formv.fido.value == '' ) okvstup=0;
    if ( document.formv.fiod.value == '0' ) okvstup=0;
    if ( document.formv.fido.value == '0' ) okvstup=0;
<?php                   } ?>

<?php if ( $uprav == 3 ) { ?>
    if ( document.formv.cslm.value == '' ) okvstup=0;
    if ( document.formv.cslm.value == '0' ) okvstup=0;
<?php                   } ?>

    if ( okvstup == 1 ) { document.formv.uloz.disabled = false; return (true); }
       else { document.formv.uloz.disabled = true; return (false) ; }

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
    window.open('users_md.php?copern=<?php echo $copern; ?>&strana=<?php echo $strana; ?>&cislo_id=' + uzivatel + '&uprav=' + uprav + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');
  // var tab = document.getElementsByClassName("mdl-tabs__tab");



  }


  function ZmazSkript(uzid, cslm, datm)
  {
    window.open('users_md.php?copern=6&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&uprav=3&cslm=' + cslm + '&datm=' + datm + '&drupoh=1', '_self' );
  }







  function closeId(uzivatel)
  {
    window.open('users_md.php?copern=1&strana=<?php echo $strana; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>', '_self');
  }

  function zmazId(uzivatel)
  {
  window.open('users_md.php?copern=6&strana=<?php echo $strana;?>&cislo_id=' + uzivatel + '&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>','_self');
  }


function zmazSetFirmy(cplf)
                {
window.open('users_md.php?copern=6&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&uprav=2&cplf=' + cplf + '&drupoh=1', '_self' );
                }

function Help()
                {
window.open('../cis/pristupy_cslm.php', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KtoMa()
                {
var fod=document.formv.fiod.value;
var fdo=document.formv.fido.value;

window.open('../cis/setuzfir_pdf.php?copern=10&page=1&sysx=UCT&uzid=<?php echo $uzid; ?>&fod=' + fod + '&fdo=' + fdo + '&drupoh=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>