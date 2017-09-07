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

$domain = $_SERVER['SERVER_NAME'];


$uprav = 1*$_REQUEST['uprav'];
$nova = 1*$_REQUEST['nova'];
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
$bolanova=0;
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

if( $nova == 1 )
    {

$upravttt = "INSERT INTO klienti ( uziv_meno,uziv_heslo,priezvisko,meno,all_prav,uct_prav,mzd_prav,skl_prav,him_prav,dop_prav, ".
" vyr_prav,fak_prav,ana_prav,txt1,cis1 ) VALUES ('$h_uzm', '$h_uzh', '$h_prie', '$h_meno', '$h_all', '$h_uct', '$h_mzd', '$h_skl', '$h_him', ".
" '$h_dop', '$h_vyr', '$h_fak', '$h_ana', '$h_txt1', '$cis1') ";
$upravene = mysql_query("$upravttt");
//echo $upravttt;

$cislo_id=0;
$sqlttt = "SELECT * FROM klienti WHERE id_klienta > 0 ORDER BY id_klienta DESC ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_id=1*$riaddok->id_klienta;
 }

$bolanova=1;
$nova=0;
    }


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
$uprav=0;
$cislo_id=0;
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
  <meta charset="cp1250">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material.min.css">
  <link rel="stylesheet" href="css/material_edit.css">
  <link rel="stylesheet" href="css/material_list_layout.css">
  <title>UûÌvatelia | EuroSecom</title>
<style>
/* zero row = helper col dimensions */
.ui-list-content tr.zero-row {
  height: 0;
}
.wrap-ui-list > .ui-list-content tr.zero-row + tr {
  border-top-color: #fff;
}
.ui-list-content tr.zero-row > td {
  padding: 0;
  line-height: 0;
}
/* table layout */
.ui-list th:nth-child(1), .ui-list td:nth-child(1) {
  width: 22%;
  text-align: left;
}
.ui-list th:nth-child(2), .ui-list td:nth-child(2) {
  width: 14%;
  text-align: left;
}
.ui-list th:nth-child(3), .ui-list td:nth-child(3) {
  width: 20%;
  text-align: left;
}
.ui-list th:nth-child(4), .ui-list td:nth-child(4) {
  width: 8%;
  text-align: right;
}
.ui-list th:nth-child(5), .ui-list td:nth-child(5) {
  width: 6%;
  text-align: right;
}
.ui-list th:nth-child(6), .ui-list td:nth-child(6) {
  width: 6%;
  text-align: right;
}
.ui-list th:nth-child(7), .ui-list td:nth-child(7) {
  width: 6%;
  text-align: right;
}
.ui-list th:nth-child(8), .ui-list td:nth-child(8) {
  width: 6%;
  text-align: right;
}
.ui-list th:nth-child(9), .ui-list td:nth-child(9) {
  width: 12%;
  text-align: right;
}
/* avatar */
.ui-list .mdl-list__item {
  height: 32px;
  min-height: 32px;
  padding: 0;
  letter-spacing: .02em;
}
.ui-list .list-item-avatar {
  border: 1px solid #039BE5;
  color: rgba(0,0,0,.87);
  background-color: #fff;
}
/* row form navigation */
.ui-row-form .mdl-navigation { /* mobile first */
  padding: 0;
}
@media screen and (min-width: 839px) {
  .ui-row-form .mdl-navigation {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    padding: 8px 0;
  }
}
.ui-row-form .mdl-navigation__link { /* mobile first */
  padding: 12px 8px 12px 8px;
  min-height: 32px;
  line-height: 32px;
  min-width: 100px;
  text-align: center;
}
@media screen and (min-width: 839px) {
  .ui-row-form .mdl-navigation__link {
    padding: 12px 2px 12px 24px;
    text-align: left;
    min-height: 24px;
    line-height: 24px;
  }
}
.ui-row-form .mdl-navigation__link:hover {
  background-color: #E0E0E0;
}
.ui-row-form .mdl-navigation__link.active {
  color: #fff;
  font-weight: 500;
  background-color: #039BE5;
}
.ui-row-form .mdl-navigation__link .dot:after {
  vertical-align: -4px;
  font-weight: 400;
}
.ui-row-form .mdl-navigation__link.mdl-list .mdl-list__item {
  cursor: pointer;
  color: inherit;
  font-weight: inherit;
  font-size: inherit;
}
.row-form-content legend {
  min-width: 48px;
  margin-top: 16px;
}
/* enternext chip */
.row-form-content .text-chip.enternext { /* mobile first */
  background-color: #039be5;
  color: #fff;
  position: absolute;
  top: 68px;
  right: 12px;
}
@media screen and (min-width: 839px) {
  .row-form-content .text-chip.enternext {
    top: 13px;
    right: 72px;
  }
}
/* table with fixed header */
.data-table.fixed-header tbody {
  max-height: 132px;
}
/* common for firms and script */
.data-table:not(.grid-table) th {
  vertical-align: top;
}
.data-table .row-form td {
  padding: 0;
}
/* firm table layout */
.firm-table th:nth-child(1), .firm-table td:nth-child(1) {
  width: 56px;
  text-align: right;
  padding-left: 8px;
}
.firm-table th:nth-child(2), .firm-table td:nth-child(2) {
  width: 82px;
  text-align: right;
}
.firm-table th:nth-child(3), .firm-table td:nth-child(3) {
  width: 82px;
  text-align: right;
}
.firm-table th:nth-child(4), .firm-table td:nth-child(4) {
  width: 100px;
  text-align: right;
  padding-right: 16px;
}
/* script table layout */
.script-table th:nth-child(1), .script-table td:nth-child(1) {
  width: 120px;
  text-align: right;
  padding-right: 24px;
}
.script-table th:nth-child(2), .script-table td:nth-child(2) {
  width: 140px;
  text-align: left;
}
.script-table th:nth-child(3), .script-table td:nth-child(3) {
  width: 100px;
  text-align: right;
  padding-right: 16px;
}
/* grid table layout */
.grid-table tr {
  height: 32px;
}
.grid-table th:nth-child(n), .grid-table td:nth-child(n) {
  width: 55px;
  text-align: center;
  font-size: 12px;
  padding: 0;
}
.grid-table th, .grid-table td {
  border-left: 1px solid #CFD8DC;
}
.grid-table tr:last-of-type, .grid-table th:first-of-type {
  border: 0;
}
/* grid table button */
.grid-table-tools .mdl-button, .grid-table-tools .mdl-menu__item {
  color: #757575;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
  min-width: 150px;
}
.grid-table-tools .material-icons {
  margin: -1px 16px 0 0;
}
</style>
</head>
<body onload="ObnovUI();">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-drawer-button">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header">
  <div class="mdl-layout__header-row ui-header-app-row">
    <span onclick="AppPage();" class="mdl-color-text--yellow-A100">EuroSecom</span>&nbsp;
    <span><?php echo $domain; ?></span>
    <div class="mdl-layout-spacer"></div>
<!-- user -->
    <ul class="mdl-list clearfix ilogin">
      <li class="mdl-list__item">
        <span class="mdl-list__item-primary-content">
          <span class="mdl-list__item-avatar list-item-avatar mdl-color--indigo-400"><?php echo $kli_uzid; ?></span>
          <span><?php echo "$kli_uzmeno $kli_uzprie"; ?></span>
        </span>
      </li>
    </ul>
  </div> <!-- .ui-header-app-row -->
  <div class="mdl-layout__header-row ui-header-page-row">
    <span id="header_title" class="mdl-layout-title mdl-color-text--white dropdown">»ÌselnÌk uûÌvateæov</span>
    <span class="mdl-layout-title mdl-color-text--yellow-A100">
<?php
if ( $nova == 1 ) { echo "nov˝ #"; }
if ( $uprav != 0 AND $nova == 0 ) { echo "˙prava # $cislo_id"; }
?>
    </span>
    <div class="mdl-layout-spacer"></div>
<form method="post" action="users_md.php?hladanie=1&copern=1&strana=1&uprav=0" id="formhladaj" name="formhladaj">
    <div class="mdl-textfield mdl-js-textfield mdl-color--light-blue-500 search-box">
      <button id="searchbtn" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--white" style="bottom: 4px; left: 8px;"><i class="material-icons">search</i></button>
      <input type="text" id="cohladat" name="cohladat" value="<?php echo $cohladat; ?>" class="mdl-textfield__input mdl-color-text--white search-input" style="border:0; font-size: 14px; height: 32px; width: 100%;">
      <label for="cohladat" class="mdl-textfield__label mdl-color-text--white" style="font-size: 14px; top: 5px; left: 48px; height: 32px; line-height: 32px; width: 204px;">Zadajte uûÌvateæa</label>
      <button id="resetsearchbtn" onclick="document.formhladaj.cohladat.value='';" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--white search-reset" style="bottom: 4px; right: 8px;"><i class="material-icons">close</i></button>
    </div>
      <span class="mdl-tooltip" data-mdl-for="searchbtn">Hæadaù</span>
      <span class="mdl-tooltip" data-mdl-for="resetsearchbtn">Vymazaù vyhæad·vanie</span>
</form>
    <button type="button" id="new_item" onclick="novyId();" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" style="margin-left: 24px;">
      <i class="material-icons">add</i>
    </button>
      <span class="mdl-tooltip" data-mdl-for="new_item">Vytvoriù novÈho uûÌvateæa</span>
  </div> <!-- .ui-header-page-row -->
  <div class="mdl-layout__header-row wrap-ui-list">
    <table class="ui-list-header ui-list two-line ui-container">
    <tr>
      <th>UûÌvateæ</th>
      <th>Prihlasovacie<br>meno - heslo</th>
      <th>Firmy</th>
      <th>PrÌstup</th>
      <th>⁄Ëto<br>Majetok</th>
      <th>Mzdy<br>Doprava</th>
      <th>Odbyt<br>V˝roba</th>
      <th>Sklad<br>Anal˝zy</th>
      <th>&nbsp;</th>
    </tr>
    </table>
  </div>
</header>

<main class="mdl-layout__content ui-content sticky-footer">
<div id="table_body" class="wrap-ui-list">
<?php
$sqltt = "SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta";
if ( $hladanie == 1 )
{
$sqltt = "SELECT * FROM klienti WHERE all_prav < $min_uzall AND ( priezvisko LIKE '%$cohladat%' OR meno LIKE '%$cohladat%' ) ORDER BY id_klienta";
}
if ( $bolanova == 1 )
{
$sqltt = "SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY id_klienta DESC";
}


$sql = mysql_query("$sqltt");
//prazdny zoznam
//$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < 1 ORDER BY id_klienta ");
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15;
if ( $hladanie == 1 ) { $pols = 900; }
// pocet stran
$xstr = ceil($cpol / $pols);
$npage =  $strana + 1;
// predchadzajuca strana
$ppage =  $strana - 1;
if ( $ppage == 0 ) { $ppage=1; }
if ( $npage >  $xstr ) { $npage=$xstr; }
// zaciatok cyklu
$i = ( $strana - 1 ) * $pols;
// koniec cyklu
$konc = ( $pols*($strana-1))+($pols-1);
?>
  <table class="ui-list-content ui-list ui-container">
  <tr class="zero-row">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php
   while ( $i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<?php if ( ( $uprav != 0 AND $riadok->id_klienta == $cislo_id ) OR ( $nova == 1 AND $i == 0 ) ) { ?>
  <tr class="ui-row-form">
    <td colspan="9" style="padding: 0;">
<form method="post" action="users_md.php?copern=8&strana=<?php echo $strana; ?>&cislo_id=<?php echo $cislo_id; ?>&nova=<?php echo $nova; ?>&uprav=<?php echo $uprav; ?>&hladanie=<?php echo $hladanie; ?>&cohladat=<?php echo $cohladat; ?>" id="formv" name="formv">
    <div class="mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
<!-- left column -->
    <div class="mdl-cell mdl-cell--2-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-color--grey-200">
      <nav class="mdl-navigation">
<?php if ( $nova == 0 ) { ?>
        <a href="#" id="nav_user" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-navigation__link mdl-list">
<?php if ( $riadok->id_klienta == $kli_uzid ) { ?>
          <abbr class="dot" title="Prihl·sen˝ uûÌvateæ" style="position: absolute; top: 24px; left: 4px;">&nbsp;</abbr>
 <?php } ?>
          <div class="mdl-list__item">
            <span class="mdl-list__item-primary-content">
              <span class="mdl-list__item-avatar list-item-avatar"><?php echo $riadok->id_klienta; ?></span>
              <span class="item-avatar-title"><?php echo "$riadok->meno $riadok->priezvisko"; ?></span>
            </span>
          </div>
        </a>
        <a id="nav_firm" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,2);" class="mdl-navigation__link">Firmy</a>
        <a id="nav_script" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,3);" class="mdl-navigation__link">Skripty
          <?php if ( $jemenpid == 1 ) { ?> <abbr class="dot" style="padding: 0;">&nbsp;</abbr> <?php } ?>
        </a>
        <a id="nav_grid" href="#" onclick="upravId(<?php echo $riadok->id_klienta; ?>,4);" class="mdl-navigation__link">Grid karta
          <?php if ( $jegridid == 1 ) { ?> <abbr class="dot">&nbsp;</abbr> <?php } ?>
        </a>
<?php                  } //nova == 0 ?>

<?php if ( $nova == 1 ) { ?>
        <a href="#" id="nav_user" class="mdl-navigation__link mdl-list">
          <div class="mdl-list__item">
            <span class="mdl-list__item-primary-content">
              <span class="mdl-list__item-avatar list-item-avatar">0</span>
              <span class="item-avatar-title">nov˝ uûÌvateæ</span>
            </span>
          </div>
        </a>
<?php } //ak nova == 1 ?>
      </nav>
    </div> <!-- .mdl-cell -->

<!-- right column -->
    <div class="mdl-cell mdl-cell--10-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-color--white" style="padding: 24px 16px 20px 32px;">

<?php
if ( $kopkli == 1 )
     {
echo "UloûenÈ zmeny.";
     }
?>

      <button type="button" id="row_form_close" onclick="closeId(<?php echo $riadok->id_klienta; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-500">
        <i class="material-icons">close</i>
      </button>
        <span data-mdl-for="row_form_close" class="mdl-tooltip">Zavrieù</span>
<?php
if ( $uprav == 1 OR $nova == 1 )
     {
?>
    <section class="row-form-content">
      <fieldset class="clearfix toleft" style="margin-right: 40px;">
        <legend class="toleft">
          <i class="material-icons mdl-color-text--grey-400 md-32">person</i>
        </legend>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 40px; margin-right: 8px;">
          <input type="text" id="h_id" name="h_id" onKeyDown="return H_idEnter(event.which)" <?php if ( $nova == 0 ){ ?>value="<?php echo $cislo_id; ?>"<?php } ?> disabled class="mdl-textfield__input">
          <label for="h_id" class="mdl-textfield__label">ID</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 8px;">
          <input type="text" id="h_meno" name="h_meno" onKeyDown="return H_menoEnter(event.which)" autofocus maxlength="20" class="mdl-textfield__input">
          <label for="h_meno" class="mdl-textfield__label">Meno</label>
          <span class="mdl-textfield__error">PovinnÈ pole!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 8px;">
          <input type="text" id="h_prie" name="h_prie" onKeyDown="return H_prieEnter(event.which)" maxlength="20" required class="mdl-textfield__input">
          <label for="h_prie" class="mdl-textfield__label">Priezvisko *</label>
        </div>
      </fieldset>
      <fieldset class="clearfix">
        <legend class="toleft">
          <i class="material-icons mdl-color-text--grey-400 md-32">lock_open</i>
        </legend>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 8px;">
          <input type="text" id="h_uzm" name="h_uzm" onKeyDown="return H_uzmEnter(event.which)" maxlength="10" required class="mdl-textfield__input">
          <label for="h_uzm" class="mdl-textfield__label">Meno *</label>
          <span class="mdl-textfield__error">PovinnÈ pole!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 120px; margin-right: 8px;">
          <input type="text" id="h_uzh" name="h_uzh" onKeyDown="return H_uzhEnter(event.which)" maxlength="10" required class="mdl-textfield__input">
          <label for="h_uzh" class="mdl-textfield__label">Heslo *</label>
          <span class="mdl-textfield__error">PovinnÈ pole!</span>
        </div>
      </fieldset>
      <fieldset class="clearfix">
        <legend class="toleft">
          <i class="material-icons mdl-color-text--grey-400 md-32">verified_user</i>
        </legend>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100px; margin-right: 32px;">
          <input type="text" id="h_all" name="h_all" onKeyDown="return H_allEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_all" class="mdl-textfield__label">Celkovo</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_uct" name="h_uct" onKeyDown="return H_uctEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_uct" class="mdl-textfield__label">⁄ËtovnÌctvo</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_mzd" name="h_mzd" onKeyDown="return H_mzdEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_mzd" class="mdl-textfield__label">Mzdy</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_fak" name="h_fak" onKeyDown="return H_fakEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_fak" class="mdl-textfield__label">Odbyt</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_skl" name="h_skl" onKeyDown="return H_sklEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_skl" class="mdl-textfield__label">Sklad</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_him" name="h_him" maxlength="6" onKeyDown="return H_himEnter(event.which)" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_him" class="mdl-textfield__label">Majetok</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_dop" name="h_dop" onKeyDown="return H_dopEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_dop" class="mdl-textfield__label">Doprava</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_vyr" name="h_vyr" onKeyDown="return H_vyrEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_vyr" class="mdl-textfield__label">V˝roba</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 70px; margin-right: 16px;">
          <input type="text" id="h_ana" name="h_ana" onKeyDown="return H_anaEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
          <label for="h_ana" class="mdl-textfield__label">Anal˝zy</label>
          <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
        </div>
      </fieldset>
      <fieldset style="width: 132px; margin: 8px 0 0 48px;">
        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="h_status">
          <input type="checkbox" id="h_status" checked class="mdl-switch__input">
          <span class="mdl-switch__label">Ne/aktÌvny</span>
        </label>
      </fieldset>
      <span id="freedom" onmouseover="return Povol_uloz();" style="position: absolute; bottom: 0; right: 0;">
        <button id="uloz" name="uloz">Uloûiù</button>
      </span>
      <abbr id="enternext_user" class="enternext text-chip">EnterNext</abbr>
        <span data-mdl-for="enternext_user" class="mdl-tooltip">Na pres˙vanie medzi polÌËkami mÙûete pouûiù kl·vesu ENTER. TlaËidlo ULOéIç aktivujete prejdenÌm kurzoru okolo tlaËidla.</span>
    </section>
<?php
     }
//uprav=1, nova=1
?>
<?php
if ( $uprav == 2 )
     {
?>
<?php
$sqlttf = "SELECT * FROM firuz WHERE uzid = $cislo_id ORDER BY cplf DESC";
$sqlf = mysql_query("$sqlttf");

//celkom poloziek
$cpolf = mysql_num_rows($sqlf);
$if = 0;
?>
    <section class="row-form-content mdl-grid mdl-grid--no-spacing">
    <div class="mdl-cell mdl-cell--6-col">
      <div class="tocenter" style="width: 340px;">
      <table class="firm-table data-table fixed-header">
      <thead>
      <tr style="height: 24px">
        <th>Firmy</th>
        <th style="color: rgb(3,169,244);">Od</th>
        <th style="color: rgb(3,169,244);">Do</th>
        <th>
          <i id="firm_list" onclick="viewFirms();" class="material-icons md-18" style="position: relative; top: -2px;">help_outline</i>
            <span for="firm_list" class="mdl-tooltip">Zobraziù dostupnÈ firmy</span>
        </th>
      </tr>
      <tr class="row-form">
        <td>
          <button type="button" id="search_user_firms" onclick="KtoMa();" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500">
            <i class="material-icons">print</i>
          </button>
            <span data-mdl-for="search_user_firms" class="mdl-tooltip">Zobraziù uûÌvateæov s prÌstupom do firiem "od do"</span>
        </td>
        <td>
          <div class="mdl-textfield mdl-js-textfield" style="width: 50px;">
            <label class="mdl-textfield__label" for="fiod">od</label>
            <input type="text" id="fiod" name="fiod" onKeyDown="return FiodEnter(event.which)" autofocus maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
            <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
          </div>
        </td>
        <td>
          <div class="mdl-textfield mdl-js-textfield" style="width: 50px;">
            <label class="mdl-textfield__label" for="fido">do</label>
            <input type="text" id="fido" name="fido" onKeyDown="return FidoEnter(event.which)" maxlength="6" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
            <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
          </div>
        </td>
        <td style="padding: 0;">
          <span id="freedom" onmouseover="return Povol_uloz();">
            <button id="uloz" name="uloz">Uloûiù</button>
          </span>
        </td>
      </tr>
      </thead>
      <tbody>
<?php
while ( $if <= $cpolf )
{
  if ( @$zaznamf=mysql_data_seek($sqlf,$if) )
  {
$riadokf=mysql_fetch_object($sqlf);
?>
      <tr class="row-echo" style="height: 30px;">
        <td>&nbsp;</td>
        <td><?php echo $riadokf->fiod; ?></td>
        <td><?php echo $riadokf->fido; ?></td>
        <td>
          <button type="button" id="firm_edit<?php echo $riadokf->cplf; ?>" onclick="zmazSetFirmy(<?php echo $riadokf->cplf; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500 mini-icon-btn">
            <i class="material-icons">remove</i>
          </button>
            <span data-mdl-for="firm_edit<?php echo $riadokf->cplf; ?>" class="mdl-tooltip">Upraviù / Vymazaù</span>
        </td>
      </tr>
<?php
  }
$if = $if + 1;
   }
?>
      </tbody>
      </table>
      </div> <!-- .tocenter -->
      <abbr id="enternext_user" class="enternext text-chip">EnterNext</abbr>
        <span data-mdl-for="enternext_user" class="mdl-tooltip">Na pres˙vanie medzi polÌËkami mÙûete pouûiù kl·vesu ENTER. TlaËidlo ULOéIç aktivujete prejdenÌm kurzoru okolo tlaËidla.</span>
    </div> <!-- .mdl-cell -->
    <div class="mdl-cell mdl-cell--6-col">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="max-width: 300px;">
        <input class="mdl-textfield__input" type="text" id="h_txt1" name="h_txt1" style="">
        <label class="mdl-textfield__label" for="h_txt1" style="">Firmy (star˝ form·t)</label>
      </div>
    </div>
    </section> <!-- .mdl-grid -->
<?php
     }
//uprav=2
?>
<?php
if ( $uprav == 3 )
     {
?>
    <section class="row-form-content">
<?php
$sqlttp = "SELECT * FROM menp WHERE prav = $cislo_id ORDER BY datm DESC";
$sqlp = mysql_query("$sqlttp");

//celkom poloziek
$cpolp = mysql_num_rows($sqlp);
$ip = 0;
?>
      <div class="tocenter" style="width: 380px;">
      <table class="script-table data-table fixed-header">
      <thead>
      <tr style="height: 24px;">
        <th style="color: rgb(3,169,244);">Skript</th>
        <th>AktualizovanÈ</th>
        <th>
          <i id="script_list" onclick="ScriptHelp();" class="material-icons md-18">help_outline</i>
            <span for="script_list" class="mdl-tooltip">Zobraziù nastaviteænÈ skripty</span>
        </th>
      </tr>
      <tr class="row-form">
        <td>
          <input type="hidden" name="uzid" id="uzid"/>
          <div class="mdl-textfield mdl-js-textfield" style="width: 80px;">
            <label for="cslm" class="mdl-textfield__label">»Ìslo skriptu</label>
            <input type="text" id="cslm" name="cslm" onKeyDown="return CslmEnter(event.which)" autofocus maxlength="8" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input">
            <span class="mdl-textfield__error">PovolenÈ s˙ ËÌsla!</span>
          </div>
        </td>
        <td>&nbsp;</td>
        <td style="padding: 0;">
          <span id="freedom" onmouseover="return Povol_uloz();">
            <button id="uloz" name="uloz">Uloûiù</button>
          </span>
        </td>
      </tr>
      </thead>
      <tbody>
<?php
   while ( $ip <= $cpolp )
   {
?>
<?php
  if (@$zaznamp=mysql_data_seek($sqlp,$ip))
  {
$riadokp=mysql_fetch_object($sqlp);
$datmsk = date("d.m.Y H:i:s", strtotime($riadokp->datm));
?>
      <tr class="row-echo" style="height: 32px;">
        <td><strong><?php echo $riadokp->cslm; ?></strong></td>
        <td><?php echo $datmsk; ?> <?php echo $riadokp->sys; ?></td>
        <td>
          <button type="button" id="script_edit<?php echo "$riadokp->prav, $riadokp->cslm, $riadokp->datm;" ?>" onclick="ZmazSkript(<?php echo $riadokp->prav; ?>, <?php echo $riadokp->cslm; ?>, '<?php echo $riadokp->datm; ?>');" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--red-500 mini-icon-btn">
            <i class="material-icons">remove</i>
          </button>
            <span data-mdl-for="script_edit<?php echo "$riadokp->prav, $riadokp->cslm, $riadokp->datm;" ?>" class="mdl-tooltip">Upraviù / Vymazaù</span>
        </td>
      </tr>
<?php
  }
$ip = $ip + 1;
   }
?>
      </tbody>
      </table>
      </div>
    </section>
<?php
     }
//uprav=3
?>
<?php
if ( $uprav == 4 )
     {
?>
    <section class="row-form-content mdl-grid mdl-grid--no-spacing">
    <div class="mdl-cell mdl-cell--7-col">
<?php
//tlac grid
if ( $jegridid == 1 )
       {
$sqlttg = "SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1";
$sqlg = mysql_query("$sqlttg");
$cpolg = mysql_num_rows($sqlg);
$ig=0;
?>
      <table class="grid-table data-table tocenter" style="width: 385px;">
      <tr>
        <th>&nbsp;</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>E</th>
        <th>F</th>
      </tr>
<?php
   while ( $ig <= $cpolg )
   {
if (@$zaznamg=mysql_data_seek($sqlg,$ig))
{
$riadokg=mysql_fetch_object($sqlg);
?>
      <tr>
        <th>1</th>
        <td><?php echo $riadokg->a1; ?></td>
        <td><?php echo $riadokg->b1; ?></td>
        <td><?php echo $riadokg->c1; ?></td>
        <td><?php echo $riadokg->d1; ?></td>
        <td><?php echo $riadokg->e1; ?></td>
        <td><?php echo $riadokg->f1; ?></td>
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
        <th>6</th>
        <td><?php echo $riadokg->a6; ?></td>
        <td><?php echo $riadokg->b6; ?></td>
        <td><?php echo $riadokg->c6; ?></td>
        <td><?php echo $riadokg->d6; ?></td>
        <td><?php echo $riadokg->e6; ?></td>
        <td><?php echo $riadokg->f6; ?></td>
      </tr>
<?php
  }
$ig = $ig + 1;
   }
?>
      </table> <!-- .grid-table -->
<?php
//jegridid=1
       }
?>
<?php if ( $jegridid == 0 ) { ?>
      <div class="ui-no-item tocenter" style="margin-top: 20px;">
        <i class="mdl-color-text--grey-400 material-icons md-48">grid_off</i>
        <div class="mdl-color-text--grey-500 no-item-alert">Grid karta nie je vytvoren·</div>
      </div>
<?php } ?>
    </div> <!-- .mdl-cell -->
    <div class="mdl-cell mdl-cell--5-col">
      <div class="grid-table-tools" style="width: 200px;">
        <button type="button" id="grid_view" onclick="viewGrid();" class="mdl-button mdl-js-button left">
          <i class="material-icons">print</i>Zobraziù</button>
        <button type="button" onclick="newGrid();" class="mdl-button mdl-js-button left">
          <i class="material-icons">add</i>Vytvoriù</button>
        <button type="button" id="grid_more" class="mdl-button mdl-js-button left">
          <i class="material-icons">more_vert</i>Viac</button>
          <ul for="grid_more" class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-color--white">
            <li onclick="setsameGrid();" class="mdl-menu__item" style="height: 40px; line-height: 40px;">
              <i class="material-icons vacenter">build</i>Nastaviù rovnakÈ PIN
            </li>
            <li onclick="setnumGrid();" class="mdl-menu__item" style="height: 40px; line-height: 40px;">
              <i class="material-icons vacenter">build</i>Nastaviù PIN 1234
            </li>
            <li onclick="delGrid();" class="mdl-menu__item" style="height: 40px; line-height: 40px;">
              <i class="material-icons vacenter">remove</i>Zruöiù
            </li>
          </ul>
      </div> <!-- .grid-table-tools -->
      </div> <!-- .mdl-cell -->
      </section> <!-- .mdl-grid -->
<?php
//uprav=4
     }
?>
    </div> <!-- .mdl-cell -->
    </div> <!-- .mdl-grid -->
</form>
    </td>
  </tr> <!-- .ui-row-form -->
<?php
 //uprav=1/2/3/4
      }
?>
<?php if ( $riadok->id_klienta != $cislo_id ) { ?>
  <tr id="echo_row" class="ui-row-echo">
    <td>
<?php if ( $riadok->id_klienta == $kli_uzid ) { ?>
      <abbr class="mdl-color-text--light-blue-400 dot" title="Prihl·sen˝ uûÌvateæ" style="position: absolute; top: 14px; left: 4px;">&nbsp;</abbr>
 <?php } ?>
      <div class="mdl-list">
        <div class="mdl-list__item">
          <span class="mdl-list__item-primary-content">
            <span class="mdl-list__item-avatar list-item-avatar"><?php echo $riadok->id_klienta; ?></span>
            <span style="font-size: 13px;"><?php echo "$riadok->meno $riadok->priezvisko"; ?></span>
          </span>
        </div>
      </div>
    </td>
<?php
//user + grid
$jegrid=0;
$sqlpoktt = "SELECT * FROM krtgrd WHERE id = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jegrid=1;
  }

//user + script
$jemenp=0;
$sqlpoktt = "SELECT * FROM menp WHERE prav = $riadok->id_klienta ";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $jemenp=1;
  }

//last logged
$poslpr="";
$sqlpoktt = "SELECT * FROM dlogin WHERE id = $riadok->id_klienta ORDER BY datm DESC";
$sqlpok = mysql_query("$sqlpoktt");
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $poslpr = date("d.m.Y H:i:s", strtotime($riadokpok->datm));
  }

//set my firm + period
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

//firms echo
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
  if( $ipok == 0 ) { $akefirmy=$akefirmy.$riadokpok->fiod."-".$riadokpok->fido; }
  if( $ipok >  0 ) { $akefirmy=$akefirmy.", ".$riadokpok->fiod."-".$riadokpok->fido; }

  }
$ipok=$ipok+1;
   }
        }
?>
    <td>
      <?php echo "$riadok->uziv_meno - $riadok->uziv_heslo"; ?><br>
<?php if ( $jegrid == 1 ) { ?>
 <abbr id="grid<?php echo $riadok->id_klienta; ?>" class="text-chip mdl-color--grey-300" style="position: relative; top: 3px;">Grid</abbr> <?php } ?>
<?php if ( $jemenp == 1 ) { ?>
 <abbr id="script<?php echo $riadok->id_klienta; ?>" class="text-chip mdl-color--grey-300" style="position: relative; top: 3px;">Skripty</abbr>
  <?php } ?>
      <i id="logged<?php echo $riadok->id_klienta; ?>" class="material-icons mdl-color-text--grey-500 md-18 vacenter">timer</i>
        <span data-mdl-for="grid<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip mdl-tooltip--right">UûÌvateæ s grid kartou</span>
        <span data-mdl-for="script<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip mdl-tooltip--right">UûÌvateæ s obmedzen˝m prÌstupom</span>
        <span data-mdl-for="logged<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip mdl-tooltip--right">PoslednÈ prihl·senie: <?php echo $poslpr; ?></span>
    </td>
    <td>
<?php if ( $riadok->txt1 != "0-0" ) { ?>
<i id="firms<?php echo $riadok->id_klienta; ?>" class="material-icons mdl-color-text--grey-500 md-18 vacenter">error_outline</i>
      <?php echo $riadok->txt1; ?>
      <span data-mdl-for="firms<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip mdl-tooltip--right">Firmy nastavenÈ v starom form·te</span>
<?php } ?>
<?php if ( $riadok->txt1 == "0-0" ) { ?>
 <?php echo $akefirmy; ?>
      
<?php } ?>
    </td>
    <td><?php echo $riadok->all_prav; ?></td>
    <td>
      <span id="uct<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->uct_prav; ?></span><br>
      <span id="maj<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->him_prav; ?></span>
        <span data-mdl-for="uct<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">⁄ËtovnÌctvo</span>
        <span data-mdl-for="maj<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Majetok</span>
    </td>
    <td>
      <span id="mzd<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->mzd_prav; ?></span><br>
      <span id="dop<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->dop_prav; ?></span>
        <span data-mdl-for="mzd<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Mzdy</span>
        <span data-mdl-for="dop<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Doprava</span>
    </td>
    <td>
      <span id="fak<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->fak_prav; ?></span><br>
      <span id="vyr<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->vyr_prav; ?></span>
        <span data-mdl-for="fak<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Odbyt</span>
        <span data-mdl-for="vyr<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">V˝roba</span>
    </td>
    <td>
      <span id="skl<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->skl_prav; ?></span><br>
      <span id="ana<?php echo $riadok->id_klienta; ?>"><?php echo $riadok->ana_prav; ?></span>
        <span data-mdl-for="skl<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Sklad</span>
        <span data-mdl-for="ana<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip" style="margin-top: -7px;">Anal˝zy</span>
    </td>
    <td>
      <button type="button" id="edit<?php echo $riadok->id_klienta; ?>" onclick="upravId(<?php echo $riadok->id_klienta; ?>,1);" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--light-blue-500">
        <i class="material-icons">edit</i>
      </button>
      <button type="button" id="more<?php echo $riadok->id_klienta; ?>" class="mdl-button mdl-js-button mdl-button--icon mdl-color-text--blue-grey-300">
        <i class="material-icons">more_vert</i>
      </button>
        <ul for="more<?php echo $riadok->id_klienta; ?>" class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect">
          <li class="mdl-menu__item"><i class="material-icons mdl-color-text--blue-grey-300 vacenter">content_copy</i>&nbsp;&nbsp;&nbsp;&nbsp;KopÌrovaù</li>
          <li disabled class="mdl-menu__item"><i class="material-icons vacenter">remove</i>&nbsp;&nbsp;&nbsp;&nbsp;Vymazaù&nbsp;&nbsp;&nbsp;<i id="user_remove<?php echo $riadok->id_klienta; ?>" class="material-icons vacenter">info_outline</i>
            <div data-mdl-for="user_remove<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip">Nie je moûnÈ vymazaù uûÌvateæa,<br>iba ho nastaviù neaktÌvnym</div>
          </li>
          <li onclick="NastavFirmu(<?php echo $riadok->id_klienta; ?>, <?php echo $strana; ?>);" class="mdl-menu__item"><i class="material-icons mdl-color-text--blue-grey-400 vacenter">build</i>&nbsp;&nbsp;&nbsp;&nbsp;Nastaviù firmu <?php echo $mojexcf; ?> a mesiac <?php echo $mojeume; ?></li>
        </ul>
        <span data-mdl-for="edit<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip">Upraviù</span>
        <span data-mdl-for="more<?php echo $riadok->id_klienta; ?>" class="mdl-tooltip">œalöie akcie</span>
     </td>
  </tr> <!-- .ui-row-echo -->
<?php
      } //$uprav=0
?>
<?php
  }
$i = $i + 1;
   }
?>
  </table> <!-- .ui-list-content -->
<form name="forma3" id="forma3" action="#">
  <div class="ui-list-footer ui-list ui-container">
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
    <button type="button" id="page_prev" onclick="navPage(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon">
      <i class="material-icons">navigate_before</i>
    </button>
    <button type="button" id="page_next" onclick="navPage(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon">
      <i class="material-icons">navigate_next</i>
    </button>
      <span class="mdl-tooltip" data-mdl-for="page_prev">Prejsù na stranu <?php echo $ppage; ?></span>
      <span class="mdl-tooltip" data-mdl-for="page_next">Prejsù na stranu <?php echo $npage; ?></span>
  </div> <!-- .ui-table-footer -->
</form>
</div> <!-- #table_body -->

<!-- empty state -->
<?php if ( $cpol == 0 ) { ?>
<div id="empty_body" class="ui-no-item" style="margin: 12% auto 10% auto;">
  <i class="material-icons mdl-color-text--grey-400 md-64">sentiment_dissatisfied</i>
  <div class="mdl-color-text--grey-500 no-item-alert">éiadne poloûky</div>
</div>
<?php                   } ?>

<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer ui-container">
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
    <!-- <li class="mdl-menu__item" onclick="Domain();">DomÈna</li> -->
    <li class="mdl-menu__item mdl-color-text--light-blue-600" onclick="Users();">»ÌselnÌk uûÌvateæov</li>
    <li class="mdl-menu__item" onclick="Firms();">»ÌselnÌk firiem</li>
  </ul>
</div>

</div> <!-- .mdl-layout -->

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script type="text/javascript">

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
<?php if ( $uprav != 0 OR $nova == 1 )
{
?>


var headbuttons = document.querySelectorAll('header button');
for ( var i = 0; i < headbuttons.length; i++ ) {
  headbuttons[i].disabled = true;
  headbuttons[i].style.opacity = '0.5';
}
  table_body.style.backgroundColor = '#eceff1';



document.getElementById('header_title').style.pointerEvents = 'none';

var rows = document.querySelectorAll('#echo_row > td');
for ( var i = 0; i < rows.length; i++ ) {
  rows[i].style.opacity='0.5';
}

var buttons = document.querySelectorAll('#echo_row button');
for ( var i = 0; i < buttons.length; i++ ) {
  buttons[i].disabled = true;
}

  document.forma3.page_goto.disabled = true;
  document.forma3.page_prev.disabled = true;
  document.forma3.page_next.disabled = true;

  document.formhladaj.cohladat.disabled = true;

<?php if ( $uprav == 1 ) { ?> document.getElementById('nav_user').className += ' active'; <?php } ?>
<?php if ( $uprav == 2 ) { ?> document.getElementById('nav_firm').className += ' active'; <?php } ?>
<?php if ( $uprav == 3 ) { ?> document.getElementById('nav_script').className += ' active'; <?php } ?>
<?php if ( $uprav == 4 ) { ?> document.getElementById('nav_grid').className += ' active'; <?php } ?>



<?php if ( $uprav == 4 AND $jegridid == 0 ) { ?>
  document.getElementById('grid_view').disabled = true;
  document.getElementById('grid_more').disabled = true;
<?php } ?>

<?php
}
//row action
?>





//empty state
<?php if ( $cpol == 0 ) { ?>
  document.getElementById('table_body').style.display='none';
<?php                   } ?>

<?php if ( $uprav == 1 OR $uprav == 2 OR $uprav == 3 OR $nova == 1 ) { ?>
  document.formv.uloz.disabled = true;
<?php                   } ?>



<?php if ( $uprav == 1 ) { ?>
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

<?php if ( $uprav == 3 AND $zmazane == 1 ) { ?>
   document.formv.cslm.value = '<?php echo "$z_cslm"; ?>';
<?php                   } ?>
  }

    function Povol_uloz()
    {
    var okvstup=1;
<?php if ( $uprav == 2 ) { ?>
    if ( document.formv.fiod.value == '' && document.formv.h_txt1.value == '' ) okvstup=0;
    if ( document.formv.fido.value == '' && document.formv.h_txt1.value == '' ) okvstup=0;
    if ( document.formv.fiod.value == '0' && document.formv.h_txt1.value == '' ) okvstup=0;
    if ( document.formv.fido.value == '0' && document.formv.h_txt1.value == '' ) okvstup=0;
<?php                   } ?>

<?php if ( $uprav == 3 ) { ?>
    if ( document.formv.cslm.value == '' ) okvstup=0;
    if ( document.formv.cslm.value == '0' ) okvstup=0;
<?php                   } ?>

    if ( okvstup == 1 ) { document.formv.uloz.disabled = false; return (true); }
       else { document.formv.uloz.disabled = true; return (false) ; }

    }




  function NastavFirmu( id, page )
  {
  window.open('users_md.php?cislo_id=' + id + '&copern=1001&strana=' + page + '&xxx=1', '_self' );
  }




  function gotoPage()
  {
   var chodna = document.forma3.page_goto.value;
   window.open('users_md.php?copern=1&strana=' + chodna + '', '_self');
  }

  function navPage(chodna)
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

function ScriptHelp()
                {
window.open('../cis/pristupy_cslm.php', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KtoMa()
                {
var fod=document.formv.fiod.value;
var fdo=document.formv.fido.value;

window.open('../cis/setuzfir_pdf.php?copern=10&page=1&sysx=UCT&uzid=<?php echo $uzid; ?>&fod=' + fod + '&fdo=' + fdo + '&drupoh=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function viewGrid()
{
  window.open('../cis/grid.php?copern=10&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_blank');
}
function newGrid()
{
  window.open('../cis/grid.php?copern=11&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self');
}
function setsameGrid()
{
  window.open('../cis/grid.php?copern=15&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self');
}
function setnumGrid()
{
  window.open('../cis/grid.php?copern=13&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self');
}
function delGrid()
{
  window.open('../cis/grid.php?copern=14&cislo_id=<?php echo $cislo_id;?>&usermd=1', '_self');
}

  function AppPage()
  {
   window.open('http://www.edcom.sk/web/eurosecom.html', '_blank');
  }

  function Domain()
  {
    window.open('admin_md.php?copern=1', '_self');
  }

  function Users()
  {
  window.open('users_md.php?copern=1&strana=1&xxx=1', '_self');
  }
  function Firms()
  {
    window.open('firms_md.php?copern=1&strana=1', '_self');
  }

function viewFirms()
{
  window.open('firms_md.php?copern=11', '_blank');
}

  function Edcom()
  {
   window.open('http://www.edcom.sk', '_blank');
  }


  function novyId()
  {
    window.open('users_md.php?copern=1&strana=1&hladanie=0&cohladat=&nova=1&uprav=1', '_self');
  }



//enternext firms
function FiodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.fido.focus();
        document.formv.fido.select();
              }

                }

function FidoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.formv.fiod.value == '' && document.formv.fido.value == '' && document.formv.h_txt1.value == ''  ) okvstup=0;
    if ( okvstup == 0 ) { document.formv.fiod.focus(); return (false); }
    if ( okvstup == 1 ) { document.formv.submit(); return (true); }
              }

                }
//enternext user
function CslmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.formv.cslm.value == '' ) okvstup=0;
    if ( document.formv.cslm.value == '0' ) okvstup=0;
    if ( okvstup == 0 ) { document.formv.cslm.focus(); return (false); }
              }

                }

function H_idEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_meno.focus();
        document.formv.h_meno.select();
              }

                }

function H_menoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_prie.focus();
        document.formv.h_prie.select();
              }

                }


function H_prieEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_uzm.focus();
        document.formv.h_uzm.select();
              }

                }

function H_uzmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_uzh.focus();
        document.formv.h_uzh.select();
              }

                }

function H_uzhEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_all.focus();
        document.formv.h_all.select();
              }

                }

function H_allEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_uct.focus();
        document.formv.h_uct.select();
              }

                }

function H_uctEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_mzd.focus();
        document.formv.h_mzd.select();
              }

                }

function H_mzdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_fak.focus();
        document.formv.h_fak.select();
              }

                }

function H_fakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_skl.focus();
        document.formv.h_skl.select();
              }

                }

function H_sklEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_him.focus();
        document.formv.h_him.select();
              }

                }

function H_himEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_dop.focus();
        document.formv.h_dop.select();
              }

                }

function H_dopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_vyr.focus();
        document.formv.h_vyr.select();
              }

                }

function H_vyrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv.h_ana.focus();
        document.formv.h_ana.select();
              }

                }

function  H_anaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.formv.h_meno.value == '' ) okvstup=0;
    if ( document.formv.h_prie.value == '' ) okvstup=0;
    if ( document.formv.h_uzm.value == ''  ) okvstup=0;
    if ( okvstup == 0 ) { document.formv.h_meno.focus(); return (false); }
    if ( okvstup == 1 ) { document.formv.submit(); return (true); }
              }

                }

</script>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>