<!doctype html>
<HTML>
<?php
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if (!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$rokdmv=2013;
if ( $kli_vrok > 2013 ) { $rokdmv=2013; }

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = 9999;
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
$zoznamaut=1;

$vsetkyprepocty=0;
$prepocitaj = 1*$_REQUEST['prepocitaj'];

$pocetdni = 1*$_REQUEST['pocetdni'];
$vypocitajdan = 1*$_REQUEST['vypocitajdan'];

$xml = 1*$_REQUEST['xml'];

//ramcek fpdf 1=zap,0=vyp
$rmc=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//nastav sadzby 2015
$sql = "SELECT vz08 FROM F".$kli_vxcf."_sadzby_dmv2015 ";
$vysledok = mysql_query($sql);
if (!$vysledok)
     {
$dsqlt = "DROP TABLE F".$kli_vxcf."_sadzby_dmv2015 ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<trexima
(
   csdz             DECIMAL(2,0) DEFAULT 0,
   nsdz             VARCHAR(50) NOT NULL,
   cprm             DECIMAL(2,0) DEFAULT 0,
   pprm             VARCHAR(40) NOT NULL,
   nprm             VARCHAR(40) NOT NULL,
   szba             DECIMAL(10,2) DEFAULT 0,
   szbb             DECIMAL(10,2) DEFAULT 0,
   sznr             DECIMAL(10,2) DEFAULT 0,
   sztn             DECIMAL(10,2) DEFAULT 0,
   sztt             DECIMAL(10,2) DEFAULT 0,
   szke             DECIMAL(10,2) DEFAULT 0,
   szpo             DECIMAL(10,2) DEFAULT 0,
   szza             DECIMAL(10,2) DEFAULT 0,
   vz08             DECIMAL(2,0) DEFAULT 0
);
trexima;

$vsql = "CREATE TABLE F".$kli_vxcf."_sadzby_dmv2015 ".$sqlt;
$vytvor = mysql_query("$vsql");

$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '1', 'objem motora (cm3)', 'do 150 vr.', '50', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '2', 'objem motora (cm3)', 'nad 150 do 900 vr.', '62', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '3', 'objem motora (cm3)', 'nad 900 do 1200 vr.', '80', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '4', 'objem motora (cm3)', 'nad 1200 do 1500 vr.', '115', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '5', 'objem motora (cm3)', 'nad 1500 do 2000 vr.', '148', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '6', 'objem motora (cm3)', 'nad 2000 do 3000 vr.', '180', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '1', 'OsobnÈ vozidlo', '7', 'objem motora (cm3)', 'nad 3000', '218', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult"); 

$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '1', 'hmotnosù (t)', 'nad 0 - do 1', '74', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '2', 'hmotnosù (t)', 'nad 1 - do 2', '133', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '3', 'hmotnosù (t)', 'nad 2 - do 4', '212', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '4', 'hmotnosù (t)', 'nad 4 - do 6', '321', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '5', 'hmotnosù (t)', 'nad 6 - do 8', '417', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '6', 'hmotnosù (t)', 'nad 8 - do 10', '518', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '7', 'hmotnosù (t)', 'nad 10 - do 12', '620', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '8', 'hmotnosù (t)', 'nad 12 - do 14', '777', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '9', 'hmotnosù (t)', 'nad 14 - do 16', '933', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '10', 'hmotnosù (t)', 'nad 16 - do 18', '1089', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '11', 'hmotnosù (t)', 'nad 18 - do 20', '1252', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '12', 'hmotnosù (t)', 'nad 20 - do 22', '1452', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '13', 'hmotnosù (t)', 'nad 22 - do 24', '1660', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '14', 'hmotnosù (t)', 'nad 24 - do 26', '1862', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '15', 'hmotnosù (t)', 'nad 26 - do 28', '2075', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '16', 'hmotnosù (t)', 'nad 28 - do 30', '2269', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '2', '⁄ûitkovÈ vozidlo - 1,2 n·pravy', '17', 'hmotnosù (t)', 'nad 30', '2480', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");


$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '1', 'hmotnosù (t)', 'nad 0 - do 15', '566', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '2', 'hmotnosù (t)', 'nad 15 - do 17', '673', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '3', 'hmotnosù (t)', 'nad 17 - do 19', '828', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '4', 'hmotnosù (t)', 'nad 19 - do 21', '982', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '5', 'hmotnosù (t)', 'nad 21 - do 23', '1144', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '6', 'hmotnosù (t)', 'nad 23 - do 25', '1295', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '7', 'hmotnosù (t)', 'nad 25 - do 27', '1452', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '8', 'hmotnosù (t)', 'nad 27 - do 29', '1599', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '9', 'hmotnosù (t)', 'nad 29 - do 31', '1755', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '10', 'hmotnosù (t)', 'nad 31 - do 33', '1964', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '11', 'hmotnosù (t)', 'nad 33 - do 35', '2172', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '12', 'hmotnosù (t)', 'nad 35 - do 37', '2375', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '13', 'hmotnosù (t)', 'nad 37 - do 40', '2582', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '3', '⁄ûitkovÈ vozidlo - 3 n·pravy', '14', 'hmotnosù (t)', 'nad 40', '2790', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");


$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '1', 'hmotnosù (t)', 'nad 0 - do 23', '721', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '2', 'hmotnosù (t)', 'nad 23 - do 25', '877', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '3', 'hmotnosù (t)', 'nad 25 - do 27', '1033', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '4', 'hmotnosù (t)', 'nad 27 - do 29', '1189', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '5', 'hmotnosù (t)', 'nad 29 - do 31', '1337', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '6', 'hmotnosù (t)', 'nad 31 - do 33', '1548', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '7', 'hmotnosù (t)', 'nad 33 - do 35', '1755', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '8', 'hmotnosù (t)', 'nad 35 - do 37', '1968', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '9', 'hmotnosù (t)', 'nad 37 - do 40', '2172', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv2015 ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '4', '⁄ûitkovÈ vozidlo - 4 a viac n·prav', '10', 'hmotnosù (t)', 'nad 40', '2375', '0', '0', '0', '0', '0', '0', '0' ) "; $ulozene = mysql_query("$sqult");
 
     }
//koniec nastav sadzby 2015

//nacitaj sadzby
$sql = "SELECT vz08 FROM F".$kli_vxcf."_sadzby_dmv ";
$vysledok = mysql_query($sql);
if (!$vysledok)
     {
$dsqlt = "DROP TABLE F".$kli_vxcf."_sadzby_dmv ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<trexima
(
   csdz             DECIMAL(2,0) DEFAULT 0,
   nsdz             VARCHAR(50) NOT NULL,
   cprm             DECIMAL(2,0) DEFAULT 0,
   pprm             VARCHAR(40) NOT NULL,
   nprm             VARCHAR(40) NOT NULL,
   szba             DECIMAL(10,2) DEFAULT 0,
   szbb             DECIMAL(10,2) DEFAULT 0,
   sznr             DECIMAL(10,2) DEFAULT 0,
   sztn             DECIMAL(10,2) DEFAULT 0,
   sztt             DECIMAL(10,2) DEFAULT 0,
   szke             DECIMAL(10,2) DEFAULT 0,
   szpo             DECIMAL(10,2) DEFAULT 0,
   szza             DECIMAL(10,2) DEFAULT 0,
   vz08             DECIMAL(2,0) DEFAULT 0
);
trexima;

$vsql = "CREATE TABLE F".$kli_vxcf."_sadzby_dmv ".$sqlt;
$vytvor = mysql_query("$vsql");

$pocc=1;
while ( $pocc < 5 )
  {
if ( $pocc == 1 ) { $subor = fopen("../import/sadzby_dmv2013_1.csv", "r"); $x_csdz=1; $x_nsdz="OsobnÈ vozidlo"; $pprm="objem motora (cm3)"; }
if ( $pocc == 2 ) { $subor = fopen("../import/sadzby_dmv2013_2.csv", "r"); $x_csdz=2; $x_nsdz="⁄ûitkovÈ vozidlo - 1,2 n·pravy"; $pprm="hmotnosù (t)"; }
if ( $pocc == 3 ) { $subor = fopen("../import/sadzby_dmv2013_3.csv", "r"); $x_csdz=3; $x_nsdz="⁄ûitkovÈ vozidlo - 3 n·pravy"; $pprm="hmotnosù (t)"; }
if ( $pocc == 4 ) { $subor = fopen("../import/sadzby_dmv2013_4.csv", "r"); $x_csdz=4; $x_nsdz="⁄ûitkovÈ vozidlo - 4 a viac n·prav"; $pprm="hmotnosù (t)"; }
$cprm=-1;
while (! feof($subor))
{
//zdvihov˝ objem motora;BA;BB;NR;TN;TT;KE;PO;ZA
//do 900 cm3 vr.;67,18; 62,00; 63,89; 61,00; 64,99; 62,07; 63,19; 61,34;

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

$cprm=$cprm+1;

  $x_nprm = $pole[0];
  $x_szba = trim($pole[1]);
  $x_szbb = trim($pole[2]);
  $x_sznr = trim($pole[3]);
  $x_sztn = trim($pole[4]);
  $x_sztt = trim($pole[5]);
  $x_szke = trim($pole[6]);
  $x_szpo = trim($pole[7]);
  $x_szza = trim($pole[8]);

$x_szba = str_replace(",",".",$x_szba);
  $x_szba = str_replace(" ","",$x_szba);
  $x_szba = 1*$x_szba;

  $x_szbb = str_replace(",",".",$x_szbb);
  $x_szbb = str_replace(" ","",$x_szbb);
  $x_szbb = 1*$x_szbb;

  $x_sznr = str_replace(",",".",$x_sznr);
  $x_sznr = str_replace(" ","",$x_sznr);
  $x_sznr = 1*$x_sznr;

  $x_sztn = str_replace(",",".",$x_sztn);
  $x_sztn = str_replace(" ","",$x_sztn);
  $x_sztn = 1*$x_sztn;

  $x_sztt = str_replace(",",".",$x_sztt);
  $x_sztt = str_replace(" ","",$x_sztt);
  $x_sztt = 1*$x_sztt;

  $x_szke = str_replace(",",".",$x_szke);
  $x_szke = str_replace(" ","",$x_szke);
  $x_szke = 1*$x_szke;

  $x_szpo = str_replace(",",".",$x_szpo);
  $x_szpo = str_replace(" ","",$x_szpo);
  $x_szpo = 1*$x_szpo;

  $x_szza = str_replace(",",".",$x_szza);
  $x_szza = str_replace(" ","",$x_szza);
  $x_szza = 1*$x_szza;

$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv ( csdz, nsdz, cprm, pprm, nprm, szba, szbb, sznr, sztn, sztt, szke, szpo, szza ) VALUES ".
" ( '$x_csdz', '$x_nsdz', '$cprm', '$pprm', '$x_nprm', '$x_szba', '$x_szbb', '$x_sznr', '$x_sztn', '$x_sztt', '$x_szke', '$x_szpo', '$x_szza' ) ";
if ( $x_szza > 0 ) { $ulozene = mysql_query("$sqult"); }
}
$pocc=$pocc+1;
  }
     }
//koniec nacitaj sadzby

//nacitaj sadzby znizene
$sql = "SELECT vz03 FROM F".$kli_vxcf."_sadzby_dmv_znizene ";
$vysledok = mysql_query($sql);
if (!$vysledok)
     {
$dsqlt = "DROP TABLE F".$kli_vxcf."_sadzby_dmv_znizene ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<trexima
(
   csdz             DECIMAL(2,0) DEFAULT 0,
   nsdz             VARCHAR(50) NOT NULL,
   cprm             DECIMAL(2,0) DEFAULT 0,
   pprm             VARCHAR(40) NOT NULL,
   nprm             VARCHAR(40) NOT NULL,
   szke1             DECIMAL(10,2) DEFAULT 0,
   szke2             DECIMAL(10,2) DEFAULT 0,
   szza1             DECIMAL(10,2) DEFAULT 0,
   szza2             DECIMAL(10,2) DEFAULT 0,
   sztt1             DECIMAL(10,2) DEFAULT 0,
   sztt2             DECIMAL(10,2) DEFAULT 0,
   sztn1             DECIMAL(10,2) DEFAULT 0,
   sztn2             DECIMAL(10,2) DEFAULT 0,
   sznr1             DECIMAL(10,2) DEFAULT 0,
   sznr2             DECIMAL(10,2) DEFAULT 0,
   szbb1             DECIMAL(10,2) DEFAULT 0,
   szbb2             DECIMAL(10,2) DEFAULT 0,
   vz03             DECIMAL(2,0) DEFAULT 0
);
trexima;

$vsql = "CREATE TABLE F".$kli_vxcf."_sadzby_dmv_znizene ".$sqlt;
$vytvor = mysql_query("$vsql");

$pocc=1;
while ( $pocc < 4 )
  {
if ( $pocc == 1 ) { $subor = fopen("../import/sadzby_dmv2013_znizene2.csv", "r"); $x_csdz=12; $x_nsdz="⁄ûitkovÈ vozidlo - 1,2 n·pravy"; $pprm="hmotnosù (t)"; }
if ( $pocc == 2 ) { $subor = fopen("../import/sadzby_dmv2013_znizene3.csv", "r"); $x_csdz=13; $x_nsdz="⁄ûitkovÈ vozidlo - 3 n·pravy"; $pprm="hmotnosù (t)"; }
if ( $pocc == 3 ) { $subor = fopen("../import/sadzby_dmv2013_znizene4.csv", "r"); $x_csdz=14; $x_nsdz="⁄ûitkovÈ vozidlo - 4 a viac n·prav"; $pprm="hmotnosù (t)"; }
$cprm=-1;
while (! feof($subor))
{
//hmotnosù(t);KE;;ZA;;TT;;TN;;NR;;BB
//uûitkovÈ vozidl· a autobusy s 1 alebo 2 n·pravami;EURO3;EURO4.5;EURO3;EURO4.5;EURO4.5 a EEV;EURO6;EURO3;EURO4.5;EURO3;EURO4.5;EURO3;EURO4,5,6 a EEV
//do 1;66,22;63,07;69,01;65,73;79,96;75,96;73,02;69,70;82,15;79,96;69,00;62,00;
//1 - 2;118,50;112,86;122,68;116,84;138,74;131,80;129,45;124,47;142,39;138,74;124,00;108,00;

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

$cprm=$cprm+1;

  $x_nprm = $pole[0];
  $x_szke1 = trim($pole[1]);
  $x_szke2 = trim($pole[2]);
  $x_szza1 = trim($pole[3]);
  $x_szza2 = trim($pole[4]);
  $x_sztt1 = trim($pole[5]);
  $x_sztt2 = trim($pole[6]);
  $x_sztn1 = trim($pole[7]);
  $x_sztn2 = trim($pole[8]);
  $x_sznr1 = trim($pole[9]);
  $x_sznr2 = trim($pole[10]);
  $x_szbb1 = trim($pole[11]);
  $x_szbb2 = trim($pole[12]);

  $x_szke1 = str_replace(",",".",$x_szke1);
  $x_szke1 = str_replace(" ","",$x_szke1);
  $x_szke1 = 1*$x_szke1;

  $x_szza1 = str_replace(",",".",$x_szza1);
  $x_szza1 = str_replace(" ","",$x_szza1);
  $x_szza1 = 1*$x_szza1;

  $x_sztt1 = str_replace(",",".",$x_sztt1);
  $x_sztt1 = str_replace(" ","",$x_sztt1);
  $x_sztt1 = 1*$x_sztt1;

  $x_sztn1 = str_replace(",",".",$x_sztn1);
  $x_sztn1 = str_replace(" ","",$x_sztn1);
  $x_sztn1 = 1*$x_sztn1;

  $x_sznr1 = str_replace(",",".",$x_sznr1);
  $x_sznr1 = str_replace(" ","",$x_sznr1);
  $x_sznr1 = 1*$x_sznr1;

  $x_szbb1 = str_replace(",",".",$x_szbb1);
  $x_szbb1 = str_replace(" ","",$x_szbb1);
  $x_szbb1 = 1*$x_szbb1;

  $x_szke2 = str_replace(",",".",$x_szke2);
  $x_szke2 = str_replace(" ","",$x_szke2);
  $x_szke2 = 1*$x_szke2;

  $x_szza2 = str_replace(",",".",$x_szza2);
  $x_szza2 = str_replace(" ","",$x_szza2);
  $x_szza2 = 1*$x_szza2;

  $x_sztt2 = str_replace(",",".",$x_sztt2);
  $x_sztt2 = str_replace(" ","",$x_sztt2);
  $x_sztt2 = 1*$x_sztt2;

  $x_sztn2 = str_replace(",",".",$x_sztn2);
  $x_sztn2 = str_replace(" ","",$x_sztn2);
  $x_sztn2 = 1*$x_sztn2;

  $x_sznr2 = str_replace(",",".",$x_sznr2);
  $x_sznr2 = str_replace(" ","",$x_sznr2);
  $x_sznr2 = 1*$x_sznr2;

  $x_szbb2 = str_replace(",",".",$x_szbb2);
  $x_szbb2 = str_replace(" ","",$x_szbb2);
  $x_szbb2 = 1*$x_szbb2;

$sqult = "INSERT INTO F$kli_vxcf"."_sadzby_dmv_znizene ( csdz, nsdz, cprm, pprm, nprm, szke1, szza1, sztt1, sztn1, sznr1, szbb1, ".
" szke2, szza2, sztt2, sztn2, sznr2, szbb2 ) VALUES ".
" ( '$x_csdz', '$x_nsdz', '$cprm', '$pprm', '$x_nprm', '$x_szke1', '$x_szza1', '$x_sztt1', '$x_sztn1', '$x_sznr1', '$x_szbb1', ".
"  '$x_szke2', '$x_szza2', '$x_sztt2', '$x_sztn2', '$x_sznr2', '$x_szbb2' ) ";
if ( $x_szza2 > 0 ) { $ulozene = mysql_query("$sqult"); }
//echo $sqult;
}
$pocc=$pocc+1;
  }
     }
//koniec nacitaj sadzby znizene

//uprav vozidlo
    if ( $copern == 346 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$copern=20;
$strana=3;
$zoznamaut=0;
    }
//koniec uprav vozidlo

//nove vozidlo
    if ( $copern == 336 )
    {
$sql = "INSERT INTO F".$kli_vxcf."_uctpriznanie_dmv (oc,konx1) VALUES ( 1, 0 ) ";
$vysledok = mysql_query($sql);

$cislo_cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ORDER BY cpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_cpl=$riaddok->cpl;
 }
$copern=20;
$strana=3;
$zoznamaut=0;
    }
//koniec nove vozidlo

//zmaz vozidlo
    if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sql = "DELETE FROM F".$kli_vxcf."_uctpriznanie_dmv WHERE cpl = $cislo_cpl ";
$vysledok = mysql_query($sql);

$copern=20;
$strana=5;
$zoznamaut=1;
    }
//zmaz vozidlo

//nacitanie minuleho roka do DMV
    if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ˙daje do DMV z firmy minulÈho roka ? ") )
         { window.close() }
else
         { location.href='priznanie_dmv<?php echo $rokdmv; ?>.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                      }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$uprtxt = "DROP TABLE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "CREATE TABLE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." SELECT * FROM ".$databaza."F$h_ycf"."_uctpriznanie_dmv WHERE datk = '0000-00-00' AND oc = 1 ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid.",F$kli_vxcf"."_uctpriznanie_dmv SET ".
" F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid.".druh=99 ".
" WHERE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid.".vzspz=F$kli_vxcf"."_uctpriznanie_dmv.vzspz ";
$upravene = mysql_query("$uprtxt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." WHERE oc = 1 AND druh != 99 ORDER BY oc,cpl ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sadzbadane=$hlavicka->r08;
if ( $kli_vrok > 2013 ) { $sadzbadane=$hlavicka->r10; }

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctpriznanie_dmv ( oc, druh, vzdnp, vzdno, vznpr, vzchm, vzobm, vzkat, vzzn, vzspz, datz, r10 ) VALUES ".
" ( '$hlavicka->oc', '$hlavicka->druh', '$hlavicka->vzdnp', '$hlavicka->vzdno', '$hlavicka->vznpr', '$hlavicka->vzchm', '$hlavicka->vzobm', ".
" '$hlavicka->vzkat', '$hlavicka->vzzn', '$hlavicka->vzspz', '$hlavicka->datz', '$sadzbadane' ) ";
$upravene = mysql_query("$uprtxt");
}
$i=$i+1;
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv,".$databaza."F$h_ycf"."_uctpriznanie_dmv SET ".
" F$kli_vxcf"."_uctpriznanie_dmv.druh3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.druh3, ".
" F$kli_vxcf"."_uctpriznanie_dmv.dar3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.dar3, ".
" F$kli_vxcf"."_uctpriznanie_dmv.rdc3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.rdc3, ".
" F$kli_vxcf"."_uctpriznanie_dmv.rdk3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.rdk3,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.dic3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.dic3,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.naz3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.naz3,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3prie=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3prie,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3meno=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3meno,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3titl=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3titl,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3uli=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3uli,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3cdm=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3cdm,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3psc=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3psc,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3mes=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3mes,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3tel=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3tel,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.d3fax=".$databaza."F$h_ycf"."_uctpriznanie_dmv.d3fax,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.xstat3=".$databaza."F$h_ycf"."_uctpriznanie_dmv.xstat3,  ".
" F$kli_vxcf"."_uctpriznanie_dmv.dar=".$databaza."F$h_ycf"."_uctpriznanie_dmv.dar, ".
" F$kli_vxcf"."_uctpriznanie_dmv.rdc=".$databaza."F$h_ycf"."_uctpriznanie_dmv.rdc, ".
" F$kli_vxcf"."_uctpriznanie_dmv.rdk=".$databaza."F$h_ycf"."_uctpriznanie_dmv.rdk  ".
" WHERE F$kli_vxcf"."_uctpriznanie_dmv.oc=".$databaza."F$h_ycf"."_uctpriznanie_dmv.oc AND F$kli_vxcf"."_uctpriznanie_dmv.oc=9999 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "DROP TABLE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." ";
$upravene = mysql_query("$uprtxt");

//nova kolonka v 2013 
if ( $kli_vrok == 2013 )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='2' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) AND vzkat = 'N' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='5' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) AND vzkat = 'O' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='1' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) ";
$upravene = mysql_query("$uprtxt");
   }

//uprav sadzby v 2013 pri prenose
if ( $kli_vrok == 2013 )
     {
//osobne vzkat == 'M' sadzba podla obsahu vzobm
//nakladne vzkat == 'N' alebo 'O' sadzba podla poctu naprav vznpr a hmotnosti vzchm
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv  WHERE oc = 1 ORDER BY oc,cpl ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sadzbakraj="xxx";
$ciselnik=1;
$riadok=1;
$fir_uctt01 = StrTr($fir_uctt01, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$fir_uctt01=strtolower($fir_uctt01);
if ( $fir_uctt01 == 'bratislava' ) { $sadzbakraj="szba"; }
if ( $fir_uctt01 == 'nitra' ) { $sadzbakraj="sznr"; }
if ( $fir_uctt01 == 'trencin' ) { $sadzbakraj="sztn"; }
if ( $fir_uctt01 == 'trnava' ) { $sadzbakraj="sztt"; }
if ( $fir_uctt01 == 'kosice' ) { $sadzbakraj="szke"; }
if ( $fir_uctt01 == 'presov' ) { $sadzbakraj="szpo"; }
if ( $fir_uctt01 == 'zilina' ) { $sadzbakraj="szza"; }

if ( $hlavicka->vzkat != 'N' AND $hlavicka->vzkat != 'O' )
{ 
$ciselnik=1; 
if ( $hlavicka->vzobm <= 900 ) { $riadok=1; }
if ( $hlavicka->vzobm >  900 AND $hlavicka->vzobm <= 1200 ) { $riadok=2; }
if ( $hlavicka->vzobm > 1200 AND $hlavicka->vzobm <= 1500 ) { $riadok=3; }
if ( $hlavicka->vzobm > 1500 AND $hlavicka->vzobm <= 2000 ) { $riadok=4; }
if ( $hlavicka->vzobm > 2000 AND $hlavicka->vzobm <= 3000 ) { $riadok=5; }
if ( $hlavicka->vzobm > 3000 ) { $riadok=6; }
}

if ( ( $hlavicka->vzkat == 'N' OR $hlavicka->vzkat == 'N' ) AND $hlavicka->vznpr < 3 )
{ 
$ciselnik=2; 
if ( $hlavicka->vzchm <= 1 ) { $riadok=1; }
if ( $hlavicka->vzchm >  1 AND $hlavicka->vzchm <=  2 ) { $riadok=2; }
if ( $hlavicka->vzchm >  2 AND $hlavicka->vzchm <=  4 ) { $riadok=3; }
if ( $hlavicka->vzchm >  4 AND $hlavicka->vzchm <=  6 ) { $riadok=4; }
if ( $hlavicka->vzchm >  6 AND $hlavicka->vzchm <=  8 ) { $riadok=5; }
if ( $hlavicka->vzchm >  8 AND $hlavicka->vzchm <= 10 ) { $riadok=6; }
if ( $hlavicka->vzchm > 10 AND $hlavicka->vzchm <= 12 ) { $riadok=7; }
if ( $hlavicka->vzchm > 12 AND $hlavicka->vzchm <= 14 ) { $riadok=8; }
if ( $hlavicka->vzchm > 14 AND $hlavicka->vzchm <= 16 ) { $riadok=9; }
if ( $hlavicka->vzchm > 16 AND $hlavicka->vzchm <= 18 ) { $riadok=10; }
if ( $hlavicka->vzchm > 18 AND $hlavicka->vzchm <= 20 ) { $riadok=11; }
if ( $hlavicka->vzchm > 20 AND $hlavicka->vzchm <= 22 ) { $riadok=12; }
if ( $hlavicka->vzchm > 22 AND $hlavicka->vzchm <= 24 ) { $riadok=13; }
if ( $hlavicka->vzchm > 24 AND $hlavicka->vzchm <= 26 ) { $riadok=14; }
if ( $hlavicka->vzchm > 26 AND $hlavicka->vzchm <= 28 ) { $riadok=15; }
if ( $hlavicka->vzchm > 28 AND $hlavicka->vzchm <= 30 ) { $riadok=16; }
if ( $hlavicka->vzobm > 30 ) { $riadok=17; }
}

if ( ( $hlavicka->vzkat == 'N' OR $hlavicka->vzkat == 'N' ) AND $hlavicka->vznpr == 3 )
{ 
$ciselnik=2; 
if ( $hlavicka->vzchm <= 15 ) { $riadok=1; }
if ( $hlavicka->vzchm > 15 AND $hlavicka->vzchm <= 17 ) { $riadok=2; }
if ( $hlavicka->vzchm > 17 AND $hlavicka->vzchm <= 19 ) { $riadok=3; }
if ( $hlavicka->vzchm > 19 AND $hlavicka->vzchm <= 21 ) { $riadok=4; }
if ( $hlavicka->vzchm > 21 AND $hlavicka->vzchm <= 23 ) { $riadok=5; }
if ( $hlavicka->vzchm > 23 AND $hlavicka->vzchm <= 25 ) { $riadok=6; }
if ( $hlavicka->vzchm > 25 AND $hlavicka->vzchm <= 27 ) { $riadok=7; }
if ( $hlavicka->vzchm > 27 AND $hlavicka->vzchm <= 29 ) { $riadok=8; }
if ( $hlavicka->vzchm > 29 AND $hlavicka->vzchm <= 31 ) { $riadok=9; }
if ( $hlavicka->vzchm > 31 AND $hlavicka->vzchm <= 33 ) { $riadok=10; }
if ( $hlavicka->vzchm > 33 AND $hlavicka->vzchm <= 35 ) { $riadok=11; }
if ( $hlavicka->vzchm > 35 AND $hlavicka->vzchm <= 37 ) { $riadok=12; }
if ( $hlavicka->vzchm > 37 AND $hlavicka->vzchm <= 40 ) { $riadok=13; }
if ( $hlavicka->vzobm > 40 ) { $riadok=14; }
}

if ( ( $hlavicka->vzkat == 'N' OR $hlavicka->vzkat == 'N' ) AND $hlavicka->vznpr > 3 )
{ 
$ciselnik=2; 
if ( $hlavicka->vzchm <= 23) { $riadok=1; }
if ( $hlavicka->vzchm > 23 AND $hlavicka->vzchm <= 25 ) { $riadok=2; }
if ( $hlavicka->vzchm > 25 AND $hlavicka->vzchm <= 27 ) { $riadok=3; }
if ( $hlavicka->vzchm > 27 AND $hlavicka->vzchm <= 29 ) { $riadok=4; }
if ( $hlavicka->vzchm > 29 AND $hlavicka->vzchm <= 31 ) { $riadok=5; }
if ( $hlavicka->vzchm > 31 AND $hlavicka->vzchm <= 33 ) { $riadok=6; }
if ( $hlavicka->vzchm > 33 AND $hlavicka->vzchm <= 35 ) { $riadok=7; }
if ( $hlavicka->vzchm > 35 AND $hlavicka->vzchm <= 37 ) { $riadok=8; }
if ( $hlavicka->vzchm > 37 AND $hlavicka->vzchm <= 40 ) { $riadok=9; }
if ( $hlavicka->vzobm > 40 ) { $riadok=10; }
}

$sadzba=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv WHERE csdz = $ciselnik AND cprm = $riadok ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $sadzba=$riaddok->$sadzbakraj;
 }
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r10=$sadzba WHERE cpl = $hlavicka->cpl ";
if ( $sadzba > 0 ) { $upravene = mysql_query("$uprtxt"); }
}
$i=$i+1;
  }
     }
//koniec uprav sadzbu

$prenosminuly=1;
$copern=20;
//koniec nacitania celeho minuleho roka do DMV
    }

//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
$druh = strip_tags($_REQUEST['druh']);
$rdc = strip_tags($_REQUEST['rdc']);
$rdk = strip_tags($_REQUEST['rdk']);
$zoo = strip_tags($_REQUEST['zoo']);
$zoosql=SqlDatum($zoo);
$zod = strip_tags($_REQUEST['zod']);
$zodsql=SqlDatum($zod);
$dar = strip_tags($_REQUEST['dar']);
$darsql=SqlDatum($dar);
$ddp = strip_tags($_REQUEST['ddp']);
$ddpsql=SqlDatum($ddp);
$fod = strip_tags($_REQUEST['fod']);

if( $zoosql == '0000-00-00' ) { $zoosql=$kli_vrok."-01-01"; }
if( $zodsql == '0000-00-00' ) { $zodsql=$kli_vrok."-12-31"; }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" dar='$darsql', ddp='$ddpsql', zoo='$zoosql', zod='$zodsql', fod='$fod', rdc='$rdc', rdk='$rdk', druh='$druh' ".
" WHERE oc = 9999 ";
                    }

if ( $strana == 2 ) {
$druh31 = strip_tags($_REQUEST['druh31']);
$druh32 = strip_tags($_REQUEST['druh32']);
$druh33 = strip_tags($_REQUEST['druh33']);
$druh34 = strip_tags($_REQUEST['druh34']);
$druh35 = strip_tags($_REQUEST['druh35']);
$druh3=0;
if ( $druh31 == 1 ) { $druh3=1; }
if ( $druh32 == 1 ) { $druh3=2; }
if ( $druh33 == 1 ) { $druh3=3; }
if ( $druh34 == 1 ) { $druh3=4; }
if ( $druh35 == 1 ) { $druh3=5; }
$rdc3 = strip_tags($_REQUEST['rdc3']);
$rdk3 = strip_tags($_REQUEST['rdk3']);
$naz3 = strip_tags($_REQUEST['naz3']);
$dic3 = strip_tags($_REQUEST['dic3']);
$d3meno = strip_tags($_REQUEST['d3meno']);
$d3prie = strip_tags($_REQUEST['d3prie']);
$d3titl = strip_tags($_REQUEST['d3titl']);
$d3uli = strip_tags($_REQUEST['d3uli']);
$d3cdm = strip_tags($_REQUEST['d3cdm']);
$d3psc = strip_tags($_REQUEST['d3psc']);
$d3mes = strip_tags($_REQUEST['d3mes']);
$d3tel_pred = strip_tags($_REQUEST['d3tel_pred']);
$d3tel_cislo = strip_tags($_REQUEST['d3tel_cislo']);
$d3tel = $d3tel_pred."/".$d3tel_cislo;
$d3fax_pred = strip_tags($_REQUEST['d3fax_pred']);
$d3fax_cislo = strip_tags($_REQUEST['d3fax_cislo']);
$d3fax = $d3fax_pred."/".$d3fax_cislo;
$xstat3 = strip_tags($_REQUEST['xstat3']);
$dar3 = strip_tags($_REQUEST['dar3']);
$dar3sql=SqlDatum($dar3);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" rdc3='$rdc3', rdk3='$rdk3', dic3='$dic3', d3meno='$d3meno', d3prie='$d3prie', d3titl='$d3titl', dar3='$dar3sql', xstat3='$xstat3', ".
" druh3='$druh3', d3uli='$d3uli', d3cdm='$d3cdm', d3psc='$d3psc', d3mes='$d3mes', d3tel='$d3tel', d3fax='$d3fax', naz3='$naz3' ".
" WHERE oc = 9999 ";
                    }

if ( $strana == 3 ) {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$vzkat = strip_tags($_REQUEST['vzkat']);
$vzdru = strip_tags($_REQUEST['vzdru']);
$vzspz = strip_tags($_REQUEST['vzspz']);
$vzzn = strip_tags($_REQUEST['vzzn']);
$da1 = strip_tags($_REQUEST['da1']);
$da1sql=SqlDatum($da1);
$datz = strip_tags($_REQUEST['datz']);
$datzsql=SqlDatum($datz);
$datk = strip_tags($_REQUEST['datk']);
$datksql=SqlDatum($datk);
$vzobm = strip_tags($_REQUEST['vzobm']);
$vzchm = strip_tags($_REQUEST['vzchm']);
$vznpr = strip_tags($_REQUEST['vznpr']);
$vzdno = strip_tags($_REQUEST['vzdno']);
$vzdnp = strip_tags($_REQUEST['vzdnp']);
$r10 = strip_tags($_REQUEST['r10']);
$r11 = strip_tags($_REQUEST['r11']);
$r12 = strip_tags($_REQUEST['r12']);
$r13 = strip_tags($_REQUEST['r13']);
$r14 = strip_tags($_REQUEST['r14']);
$r15 = strip_tags($_REQUEST['r15']);
$r16 = strip_tags($_REQUEST['r16']);
$r17 = strip_tags($_REQUEST['r17']);
$r18 = strip_tags($_REQUEST['r18']);
$r19 = strip_tags($_REQUEST['r19']);
$r20 = strip_tags($_REQUEST['r20']);
$r21 = strip_tags($_REQUEST['r21']);
$r22 = strip_tags($_REQUEST['r22']);
$r23 = strip_tags($_REQUEST['r23']);
$r24 = strip_tags($_REQUEST['r24']);
$r50 = strip_tags($_REQUEST['r50']);

//ak sa pri ulozeni zmenila sadzba prepocitaj pomernu dan
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE cpl = $cislo_cpl ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $r10old=1*$riaddok->r10;
 $r13old=1*$riaddok->r13;
 $r11old=1*$riaddok->r11;
 }
$r10new=1*$r10;
$r13new=1*$r13;
$r11new=1*$r11;

if ( $r10old != $r10new ) { $vypocitajdan=1; }
if ( $r13old != $r13new ) { $vypocitajdan=1; }
if ( $r11old != $r11new ) { $vypocitajdan=1; }

//ak sa pri ulozeni zmenil datum zac alebo kon prepocitaj dni a pomernu
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE cpl = $cislo_cpl ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $datzold=$riaddok->datz;
 $datkold=$riaddok->datk;
 }
$datznew=$datzsql;
$datknew=$datksql;

if ( $datzold != $datznew ) { $pocetdni=1; }
if ( $datkold != $datknew ) { $pocetdni=1; }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" vzkat='$vzkat', vzdru='$vzdru', vzzn='$vzzn', da1='$da1sql', datz='$datzsql', datk='$datksql', ".
" vzspz='$vzspz', vzobm='$vzobm', vzchm='$vzchm', vznpr='$vznpr', vzdno='$vzdno', vzdnp='$vzdnp', ".
" r10='$r10', r11='$r11', r12='$r12', r13='$r13', r14='$r14', r15='$r15', r16='$r16', r17='$r17', r18='$r18', r19='$r19', r20='$r20', ".
" r21='$r21',r22='$r22', r23='$r23', r24='$r24', r50='$r50' ".
" WHERE oc = 1 AND cpl = $cislo_cpl ";
$strana=3;
                    }

if ( $strana == 4 ) {
$r35 = strip_tags($_REQUEST['r35']);
$r36 = strip_tags($_REQUEST['r36']);
$r37 = strip_tags($_REQUEST['r37']);
$r38 = strip_tags($_REQUEST['r38']);
$r39 = strip_tags($_REQUEST['r39']);
$r40 = strip_tags($_REQUEST['r40']);
$r41 = strip_tags($_REQUEST['r41']);
$r42 = strip_tags($_REQUEST['r42']);
$r43 = strip_tags($_REQUEST['r43']);
$r44 = strip_tags($_REQUEST['r44']);
$r45 = strip_tags($_REQUEST['r45']);
$zvra = strip_tags($_REQUEST['zvra']);
$post = strip_tags($_REQUEST['post']);
$ucet = strip_tags($_REQUEST['ucet']);
$dvp = strip_tags($_REQUEST['dvp']);
$dvpsql=SqlDatum($dvp);
$dvh = strip_tags($_REQUEST['dvh']);
$dvhsql=SqlDatum($dvh);
$pomv = strip_tags($_REQUEST['pomv']);
$pozn = strip_tags($_REQUEST['pozn']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" r35='$r35', r36='$r36', r37='$r37', r38='$r38', r39='$r39', r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44', r45='$r45', ".
" zvra='$zvra', post='$post', ucet='$ucet', dvp='$dvpsql', dvh='$dvhsql', pomv='$pomv', pozn='$pozn' ".
" WHERE oc = 9999 ";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//vypocty
$nerob=0;
if ( $nerob == 0 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdno='1' WHERE oc = 1 AND vzdno = 0 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdnp='A' WHERE oc = 1 AND vzdnp = '' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzkat='M' WHERE oc = 1 AND vzkat = '' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='2' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) AND vzkat = 'N' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='5' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) AND vzkat = 'O' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='1' WHERE oc = 1 AND ( vzdru = '' OR vzdru = 0 ) ";
$upravene = mysql_query("$uprtxt");


//pocet dni v roku
$prvyden=$kli_vrok."-01-01";
$denposledny=$kli_vrok."-12-31";
$sqltt = "SELECT * FROM kalendar WHERE dat >= '$prvyden' AND dat <= '$denposledny' ";
$sql = mysql_query("$sqltt");
$pocetdnirok = mysql_num_rows($sql);

$podmcpl=" AND cpl = $cislo_cpl ";
if ( $prenosminuly == 1 )
{
$pocetdni=1;
$podmcpl="";
}

if ( $pocetdni == 1 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET datz='$prvyden' WHERE oc = 1 AND datz = '0000-00-00' $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=$pocetdni WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=DATEDIFF(datk,'$prvyden')+1 WHERE oc = 1 AND datk > '$prvyden' $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=DATEDIFF('$denposledny',datz)+1 WHERE oc = 1 AND datz >= '$prvyden' $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=DATEDIFF(datk,datz)+1 WHERE oc = 1 AND datz >= '$prvyden' AND datk >= '$prvyden' $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=DATEDIFF(datk,'$prvyden')+1 WHERE oc = 1 AND datz < '$prvyden' AND datk >= '$prvyden' $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r13=DATEDIFF('$denposledny','$prvyden')+1 WHERE oc = 1 AND datz < '$prvyden' AND datk = '0000-00-00' $podmcpl";
$upravene = mysql_query("$uprtxt");
     }

if ( $pocetdni == 1 ) { $vypocitajdan=1; }
if ( $vypocitajdan == 1 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des6=r10/$pocetdnirok*r13 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des6=r11/$pocetdnirok*r13 WHERE r11 != 0 AND oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des6=r10 WHERE des6 > r10 AND oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des6=r11 WHERE r11 != 0 AND des6 > r11 AND oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des6=des6-0.005 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET des2=des6 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r16=des2 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r16=0 WHERE oc = 1 AND r16 < 0 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r17=0 WHERE oc = 1 AND r14 = 0 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r18=0 WHERE oc = 1 AND r15 = 0 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r19=r16+r17+r18 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r21=r19 WHERE oc = 1 $podmcpl";
$upravene = mysql_query("$uprtxt");
     }

$sumadane=0; 
$sqlttt = "SELECT SUM(r21) AS sumr21, SUM(oc) AS sumoc FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumadane=$riaddok->sumr21;
  }

$predpoklad = 1*$_REQUEST['predpoklad'];
if ( $predpoklad == 1 )
     {
$danpredpok=0;

if( $kli_vrok < 2014 OR $kli_vrok > 2014 ) 
      {
$sqlttt = "SELECT SUM(r10) AS sumr10 FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 AND datk = '0000-00-00' ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $danpredpok=$riaddok->sumr10;
  }
      }

if( $kli_vrok == 2014 ) 
      {
$sqlttt = "DROP TABLE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "CREATE TABLE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 AND datk = '0000-00-00' ";
$sqldok = mysql_query("$sqlttt");


$sqltt = "SELECT * FROM F".$kli_vxcf."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 ORDER BY cpl ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
//andrej

$sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 7 "; 
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 7 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 3000 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 6 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 2000 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 5 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 1500 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 4 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 1200 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 3 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 900  ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 2 "; }
if( $riadok->vzkat == 'M' AND $riadok->vzdru == 1 AND $riadok->vzobm <= 150  ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 1 "; }

if( $riadok->vzkat == 'M' AND $riadok->vzdru == 4 ) { $riadok->vzkat="N"; }

if( $riadok->vzkat != 'M' ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 10 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 40 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 9 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 37 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 8 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 35 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 7 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 33 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 6 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 31 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 5 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 29 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 4 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 27 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 3 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 25 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 2 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 4 AND $riadok->vzchm <= 23 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 1 "; }

if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 14 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 40 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 13 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 37 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 12 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 35 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 11 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 33 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 10 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 31 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 9 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 29 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 8 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 27 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 7 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 25 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 6 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 23 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 5 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 21 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 4 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 19 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 3 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 17 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 2 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 3 AND $riadok->vzchm <= 15 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 1 "; }

if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 17 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 30 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 16 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 28 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 15 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 26 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 14 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 24 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 13 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 22 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 12 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 20 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 11 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 18 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 10 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 16 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 9 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 14 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 8 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 12 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 7 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 10 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 6 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 8 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 5 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 6 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 4 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 4 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 3 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 2 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 2 "; }
if( $riadok->vzkat != 'M' AND $riadok->vznpr == 2 AND $riadok->vzchm <= 1 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 1 "; }

$sadzba15=0;
$sqldos = mysql_query("$sqltts");
  if (@$zaznam=mysql_data_seek($sqldos,0))
  {
  $riaddos=mysql_fetch_object($sqldos);
  $sadzba15=$riaddos->szba;
  }

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13='$sadzba15' WHERE cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

  }
$i=$i+1;
   }

//pocet mesiacov 11, zlava 12, sadzba 13, rocna predpokl.dan r10
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r14=YEAR(da1), r15=MONTH(da1) WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r11=0, r12=0, r10=0 WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");

$kli_vrok2=$kli_vrok+1;
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r11=(($kli_vrok2-r14)*12)-(r15-1) WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=-0.25 WHERE oc = 1 AND r11 >=  1 AND r11 <= 36";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=-0.20 WHERE oc = 1 AND r11 >= 37 AND r11 <= 72";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=-0.15 WHERE oc = 1 AND r11 >= 73 AND r11 <= 108";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=0.10 WHERE oc = 1 AND r11 >= 145 AND r11 <= 156";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=0.20 WHERE oc = 1 AND r11 > 156";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=-0.50 WHERE oc = 1 AND r50 = 50 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12=-1.00 WHERE oc = 1 AND r50 = 100 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r11=0, r12=0 WHERE da1 = '0000-00-00' ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r10=(1+r12)*r13 WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");


//elektromobil { $sadzba15=0; }
//hybrid zlava 50%

$sqlttt = "SELECT SUM(r10) AS sumr10 FROM F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 AND datk = '0000-00-00' ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $danpredpok=$riaddok->sumr10;
  }

      }
//koniec rok 2014

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r40=$danpredpok WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
     }
//koniec predpoklad=1

$pocetvozidiel=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ");
$pocetvozidiel = mysql_num_rows($sqldok);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r35=$pocetvozidiel, r36=$sumadane, r41=$pocetvozidiel/2  WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r38=r36-r37, r39=0 WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r39=-r38, r38=0 WHERE oc = 9999 AND r38 < 0 ";
$upravene = mysql_query("$uprtxt");
     }
//nerob=1

//prac.subor a subor vytvorenych rocnych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sql = "SELECT cpl FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctpriznanie_dmv';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cpl          int not null auto_increment,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   rdc          VARCHAR(6) NOT NULL,
   rdk          VARCHAR(4) NOT NULL,
   dar          DATE NOT NULL,
   druh3         DECIMAL(10,0) DEFAULT 0,
   rdc3          VARCHAR(6) NOT NULL,
   rdk3          VARCHAR(4) NOT NULL,
   dar3          DATE NOT NULL,
   dic3          VARCHAR(15) NOT NULL,
   naz3          VARCHAR(35) NOT NULL,
   d3prie        VARCHAR(30) NOT NULL,
   d3meno        VARCHAR(30) NOT NULL,
   d3titl        VARCHAR(30) NOT NULL,
   d3uli         VARCHAR(30) NOT NULL,
   d3cdm         VARCHAR(30) NOT NULL,
   d3psc         VARCHAR(30) NOT NULL,
   d3mes         VARCHAR(30) NOT NULL,
   d3tel         VARCHAR(30) NOT NULL,
   d3fax         VARCHAR(30) NOT NULL,
   xstat3        VARCHAR(30) NOT NULL,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   px01         DECIMAL(10,2) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriznanie_dmv'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_uctpriznanie_dmv (oc,konx1) VALUES ( 9999, 0 ) ";
$vysledok = mysql_query($sql);
}
//koniec vytvorenie priznaniedmv

$sql = "SELECT r24 FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r16 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD datk DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD datz DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzspz VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzzn VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzkat VARCHAR(1) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzobm DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzchm DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vznpr DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzdno DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzdnp VARCHAR(1) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r08 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r09 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r14 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r15 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r16 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r17 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r18 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r19 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r20 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r23 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r24 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT ucet FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD ddp DATE NOT NULL AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD pos DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r47 DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r48 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r49 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r50 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r51 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r52 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r53 DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r54 DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r55 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r56 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r57 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zvra DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD post DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD ucet DECIMAL(10,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT pomv FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD dvh DATE NOT NULL AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD dvp DATE NOT NULL AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD pomv TEXT AFTER konx1";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT des6 FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD des2 DECIMAL(10,2) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD des6 DECIMAL(13,6) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
}

//zmeny 2013
$sql = "SELECT zod FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r35 DECIMAL(10,0) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r36 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r37 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r38 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r39 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r40 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r41 DECIMAL(10,0) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r42 DECIMAL(10,0) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r43 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r44 DECIMAL(10,2) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r45 DECIMAL(10,0) DEFAULT 0 AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r10 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r11 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r12 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r13 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r14 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv MODIFY r15 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD pozn TEXT AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzdru VARCHAR(5) NOT NULL AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD da1 DATE NOT NULL AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD fod VARCHAR(40) AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zoo DATE NOT NULL AFTER px01";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zod DATE NOT NULL AFTER px01";
$vysledek = mysql_query("$sql");
}

//koniec uprav def. tabulky
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");

//vypocty
if ( $copern == 10 OR $copern == 20 )
{
//echo "PrepoËÌtavam hodnoty v daÚovom priznanÌ.";
$pocet=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");
$pos = mysql_num_rows($sqldok);

//pocet stran
$sqtoz = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET pos=ceil($pos/2) ";
$oznac = mysql_query("$sqtoz");
}
//koniec vypocty

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }
?>

<?php
//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 ) {
$druh = $fir_riadok->druh;
$dar = $fir_riadok->dar;
$darsk=SkDatum($dar);
$zoo = $fir_riadok->zoo;
$zoosk=SkDatum($zoo);
$zod = $fir_riadok->zod;
$zodsk=SkDatum($zod);
$ddp = $fir_riadok->ddp;
$ddpsk=SkDatum($ddp);
$fod = $fir_riadok->fod;
                    }

if ( $strana == 2 ) {
$druh3 = $fir_riadok->druh3;
$rdc3 = $fir_riadok->rdc3;
$rdk3 = $fir_riadok->rdk3;
$naz3 = $fir_riadok->naz3;
$dic3 = $fir_riadok->dic3;
$d3meno = $fir_riadok->d3meno;
$d3prie = $fir_riadok->d3prie;
$d3titl = $fir_riadok->d3titl;
$xstat3 = $fir_riadok->xstat3;
$d3uli = $fir_riadok->d3uli;
$d3cdm = $fir_riadok->d3cdm;
$d3psc = $fir_riadok->d3psc;
$d3mes = $fir_riadok->d3mes;
$d3tel = $fir_riadok->d3tel;
$d3fax = $fir_riadok->d3fax;
$polet = explode("/", $d3tel);
$d3tel_pred=$polet[0];
$d3tel_cislo=$polet[1];
$polef = explode("/", $d3fax);
$d3fax_pred=$polef[0];
$d3fax_cislo=$polef[1];
$dar3 = $fir_riadok->dar3;
$dar3sk=SkDatum($dar3);
                    }

if ( $strana == 3 )
{
//moje upravy stranu 3 robime inak takze vsetko som dal prec
}

if ( $strana == 4 ) {
$r35 = $fir_riadok->r35;
$r36 = $fir_riadok->r36;
$r37 = $fir_riadok->r37;
$r38 = $fir_riadok->r38;
$r39 = $fir_riadok->r39;
$r40 = $fir_riadok->r40;
$r41 = $fir_riadok->r41;
$r42 = $fir_riadok->r42;
$r43 = $fir_riadok->r43;
$r44 = $fir_riadok->r44;
$r45 = $fir_riadok->r45;
$zvra = $fir_riadok->zvra;
$post = $fir_riadok->post;
$ucet = $fir_riadok->ucet;
$dvp = $fir_riadok->dvp;
$dvpsk=SkDatum($dvp);
$dvh = $fir_riadok->dvh;
$dvhsk=SkDatum($dvh);
$pomv = $fir_riadok->pomv;
$pozn = $fir_riadok->pozn;
                    }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z motorov˝ch vozidiel</title>
<style type="text/css">
div.sadzby-dane-box, div.sadzby-dane2-box {
  overflow: auto;
  height: 400px;
  padding: 6px;
  background-color: #ffff90;
}
div.sadzby-dane-box { width: 720px; }
div.sadzby-dane2-box { width: 862px; }
div.sadzby-dane-box h2, div.sadzby-dane2-box h2 {
  float: left;
  height: 25px;
  line-height: 25px;
  padding-bottom: 6px;
  font-weight: bold;
  font-size: 15px;
}
div.sadzby-dane-box img, div.sadzby-dane2-box img {
  display: block;
  float: right;
  width: 25px;
  height: 25px;
  cursor: pointer;
}
table.sadzby-dane, table.sadzby-dane2 {
  background-color: #add8e6;
  margin-top: 6px;
}
table.sadzby-dane { width: 704px; }
table.sadzby-dane2 { width: 846px; }
table.sadzby-dane caption, table.sadzby-dane2 caption {
  width: 270px;
  height: 30px;
  line-height: 30px;
  padding-top: 2px;
  background-color: #add8e6;
  font-size: 13px;
  text-align: center;
  text-transform: uppercase;
}
table.sadzby-dane h3, table.sadzby-dane2 h3 {
  float: left;
  height: 24px;
  line-height: 24px;
  font-size: 11px;
  font-weight: normal;
  color: #fff;
}
table.sadzby-dane h3 { width: 120px; }
table.sadzby-dane2 h3 { width: 90px; }
table.sadzby-dane h4, table.sadzby-dane2 h4 {
  float: left;
  border-right: 3px solid #add8e6;
  font-size: 11px;
  font-weight: normal;
}
table.sadzby-dane h4 {
  width: 70px;
  height: 24px;
  line-height: 24px;
}
table.sadzby-dane2 h4 {
  width: 60px;
  height: 30px;
  line-height: 14px;
}
table.sadzby-dane2 h5 {
  float: left;
  width: 123px;
  height: 24px;
  line-height: 24px;
  border-right: 3px solid #add8e6;
  font-size: 11px;
  font-weight: normal;
}
table.sadzby-dane h6, table.sadzby-dane2 h6 {
  float: left;
  height: 26px;
  line-height: 26px;
  font-size: 11px;
  text-align: right;
}
table.sadzby-dane h6 { width: 120px; }
table.sadzby-dane2 h6 { width: 90px; }
table.sadzby-dane a, table.sadzby-dane2 a {
  float: left;
  display: block;
  height: 26px;
  line-height: 26px;
  border-right: 3px solid #add8e6;
  border-bottom: 3px solid #add8e6;
  background-color: #fff;
  font-size: 12px;
  font-weight: bold;
  color: #000;
  text-align: right;
}
table.sadzby-dane a { width: 70px; }
table.sadzby-dane2 a { width: 60px; }
table.sadzby-dane a:hover, table.sadzby-dane2 a:hover { background-color: #add8e6; }
div.sadzby-dane-box-locate {
  position: absolute;
  z-index: 1;
}
div.wrap-vozidla {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.vozidla {
  width: 914px;
  margin: 5px auto;
}
table.vozidla caption {
  width: 200px;
  height: 38px;
  line-height: 38px;
  margin-top: 5px;
  font-weight: bold;
  font-size: 16px;
  text-align: left;
}
table.vozidla caption img {
  position: absolute;
  top: 42px;
  left: 145px;
  width: 20px;
  height: 20px;
  cursor: pointer;
}
table.vozidla thead td {
  height: 16px;
  line-height: 16px;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.vozidla tbody td {
  height: 30px;
  line-height: 30px;
  border-top: 2px solid #add8e6;
  font-size: 15px;
}
table.vozidla tbody img {
  width: 20px;
  height: 20px;
  vertical-align: text-bottom;
  cursor: pointer;
}
</style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.fir_fdic.value = '<?php echo "$fir_fdic";?>';
   document.formv1.dar.value = '<?php echo "$darsk";?>';
   document.formv1.zoo.value = '<?php echo "$zoosk";?>';
   document.formv1.zod.value = '<?php echo "$zodsk";?>';
   document.formv1.ddp.value = '<?php echo "$ddpsk";?>';
   document.formv1.fod.value = '<?php echo "$fod";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 )                           { ?>
<?php if ( $druh3 == 1 ) { ?>document.formv1.druh31.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 2 ) { ?>document.formv1.druh32.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 3 ) { ?>document.formv1.druh33.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 4 ) { ?>document.formv1.druh34.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 5 ) { ?>document.formv1.druh35.checked = 'true'; <?php } ?>
   document.formv1.rdc3.value = '<?php echo "$rdc3";?>';
   document.formv1.naz3.value = '<?php echo "$naz3";?>';
   document.formv1.rdk3.value = '<?php echo "$rdk3";?>';
   document.formv1.dar3.value = '<?php echo "$dar3sk";?>';
   document.formv1.dic3.value = '<?php echo "$dic3";?>';
   document.formv1.d3prie.value = '<?php echo "$d3prie";?>';
   document.formv1.d3meno.value = '<?php echo "$d3meno";?>';
   document.formv1.d3titl.value = '<?php echo "$d3titl";?>';
   document.formv1.d3uli.value = '<?php echo "$d3uli";?>';
   document.formv1.d3cdm.value = '<?php echo "$d3cdm";?>';
   document.formv1.d3psc.value = '<?php echo "$d3psc";?>';
   document.formv1.d3mes.value = '<?php echo "$d3mes";?>';
   document.formv1.d3tel_pred.value = '<?php echo "$d3tel_pred";?>';
   document.formv1.d3tel_cislo.value = '<?php echo "$d3tel_cislo";?>';
   document.formv1.d3fax_pred.value = '<?php echo "$d3fax_pred";?>';
   document.formv1.d3fax_cislo.value = '<?php echo "$d3fax_cislo";?>';
   document.formv1.xstat3.value = '<?php echo "$xstat3";?>';
<?php                                                                   } ?>

<?php if ( $strana == 4 OR $strana == 9999 )                           { ?>
    document.formv1.r35.value = '<?php echo "$r35";?>';
    document.formv1.r36.value = '<?php echo "$r36";?>';
    document.formv1.r37.value = '<?php echo "$r37";?>';
    document.formv1.r38.value = '<?php echo "$r38";?>';
    document.formv1.r39.value = '<?php echo "$r39";?>';
    document.formv1.r40.value = '<?php echo "$r40";?>';
    document.formv1.r41.value = '<?php echo "$r41";?>';
    document.formv1.r42.value = '<?php echo "$r42";?>';
    document.formv1.r43.value = '<?php echo "$r43";?>';
    document.formv1.r44.value = '<?php echo "$r44";?>';
    document.formv1.r45.value = '<?php echo "$r45";?>';
    document.formv1.dvp.value = '<?php echo "$dvpsk";?>';    
    document.formv1.dvh.value = '<?php echo "$dvhsk";?>';
<?php                                                                   } ?>    
   }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Kontrola datumu Sk
  function kontrola_datum(vstup, Oznam, x1, errflag)
  {
	 var text
	 var index
	 var tecka
	 var den
	 var mesic
	 var rok
	 var ch
                var err

		textxx=""
                err=0

		den=""
		mesic=""
		rok=""
		tecka=0

		for (index = 0; index < vstup.value.length; index++)
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".")
				{textxx="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}

				}
			}

		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}




		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

//Kontrola cisla celeho v rozsahu x az y
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

//Kontrola des.cisla celeho v rozsahu x az y
  function cele(x1,x,y,Oznam,des)
  {
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }
  }

//Kontrola cisla
  function KontrolaCisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
   else { Oznam.style.display="none"; }
  }
//Kontrola cisla desatinneho
  function KontrolaDcisla(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
   else { Oznam.style.display="none"; }
  }
//Kontrola datumu
  function KontrolaDatum(Vstup, Oznam)
  {
   if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
   if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
   else { Oznam.style.display="none"; }
  }
//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function ZnovuPotvrdenie()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacDMV()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes')
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_poucenie_na_vyplnenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Sadzby2015()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv15_sadzby.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function klik31()
  {
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.druh35.checked = false;
  }
  function klik32()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.druh35.checked = false;
  }
  function klik33()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.druh35.checked = false;
  }
  function klik34()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh35.checked = false;
  }
  function klik35()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
  }
  function HelpDanovnici()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_help_danovnik_paragraf85.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }
  function vypocetDni()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&pocetdni=1', '_self' );
  }
  function vypocitajDan()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&vypocitajdan=1', '_self' );
  }
  function vypocitajPredpoDan()
  {
   window.open('priznanie_dmv<?php echo $rokdmv; ?>.php?copern=20&strana=4&predpoklad=1', '_self' );
  }
  function VytvorOznamZanik(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=70&drupoh=1&page=1&cislo_cpl='+ cislo_cpl + '&ukoncenie=1', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes' )
  }
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function ZmazVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=316&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function NoveVzd()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=336&uprav=0', '_self' )
  }

<?php if ( $copern == 20 ) { ?>
  function ukazrobot()
  {
   myRobot = document.getElementById("robot");
   myRobot.innerHTML = htmlmenu;
   robot.style.display='';
  }
  function zhasnirobot()
  {
   robot.style.display='none';
  }
  function VyberZhasni()
  {
   robot.style.display='none';
   document.formv1.r10.focus();
   document.formv1.r10.select();
  }
<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv WHERE csdz = 1 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
var htmlmenu = "<div class='sadzby-dane-box'>";
    htmlmenu += "<h2>Sadzby dane z motorov˝ch vozidiel</h2><img src='../obr/ikony/turnoff_blue_icon.png' onclick='zhasnirobot();' title='Skryù menu'>";
    htmlmenu += "<table class='sadzby-dane'>";
    htmlmenu += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu += "<tr>";
    htmlmenu += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>Bratislava</h4><h4>B.Bystrica</h4><h4>Nitra</h4><h4>TrenËÌn</h4><h4>Trnava</h4>";
    htmlmenu += "<h4>Koöice</h4><h4>Preöov</h4><h4>éilina</h4></th>";
    htmlmenu += "</tr>";
<?php          } ?>
    htmlmenu += "<tr>";
    htmlmenu += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szba; ?>';VyberZhasni();\"><?php echo $riadok->szba; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szbb; ?>';VyberZhasni();\"><?php echo $riadok->szbb; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sznr; ?>';VyberZhasni();\"><?php echo $riadok->sznr; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztn; ?>';VyberZhasni();\"><?php echo $riadok->sztn; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztt; ?>';VyberZhasni();\"><?php echo $riadok->sztt; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szke; ?>';VyberZhasni();\"><?php echo $riadok->szke; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szpo; ?>';VyberZhasni();\"><?php echo $riadok->szpo; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szza; ?>';VyberZhasni();\"><?php echo $riadok->szza; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu += "</table>";

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv WHERE csdz = 2 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
    htmlmenu += "<table class='sadzby-dane'>";
    htmlmenu += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu += "<tr>";
    htmlmenu += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>Bratislava</h4><h4>B.Bystrica</h4><h4>Nitra</h4><h4>TrenËÌn</h4><h4>Trnava</h4>";
    htmlmenu += "<h4>Koöice</h4><h4>Preöov</h4><h4>éilina</h4></th>";
    htmlmenu += "</tr>";
<?php          } ?>
    htmlmenu += "<tr>";
    htmlmenu += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szba; ?>';VyberZhasni();\"><?php echo $riadok->szba; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szbb; ?>';VyberZhasni();\"><?php echo $riadok->szbb; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sznr; ?>';VyberZhasni();\"><?php echo $riadok->sznr; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztn; ?>';VyberZhasni();\"><?php echo $riadok->sztn; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztt; ?>';VyberZhasni();\"><?php echo $riadok->sztt; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szke; ?>';VyberZhasni();\"><?php echo $riadok->szke; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szpo; ?>';VyberZhasni();\"><?php echo $riadok->szpo; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szza; ?>';VyberZhasni();\"><?php echo $riadok->szza; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu += "</table>";

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv WHERE csdz = 3 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
    htmlmenu += "<table class='sadzby-dane'>";
    htmlmenu += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu += "<tr>";
    htmlmenu += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>Bratislava</h4><h4>B.Bystrica</h4><h4>Nitra</h4><h4>TrenËÌn</h4><h4>Trnava</h4>";
    htmlmenu += "<h4>Koöice</h4><h4>Preöov</h4><h4>éilina</h4></th>";
    htmlmenu += "</tr>";
<?php          } ?>
    htmlmenu += "<tr>";
    htmlmenu += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szba; ?>';VyberZhasni();\"><?php echo $riadok->szba; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szbb; ?>';VyberZhasni();\"><?php echo $riadok->szbb; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sznr; ?>';VyberZhasni();\"><?php echo $riadok->sznr; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztn; ?>';VyberZhasni();\"><?php echo $riadok->sztn; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztt; ?>';VyberZhasni();\"><?php echo $riadok->sztt; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szke; ?>';VyberZhasni();\"><?php echo $riadok->szke; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szpo; ?>';VyberZhasni();\"><?php echo $riadok->szpo; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szza; ?>';VyberZhasni();\"><?php echo $riadok->szza; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu += "</table>";

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv WHERE csdz = 4 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
    htmlmenu += "<table class='sadzby-dane'>";
    htmlmenu += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu += "<tr>";
    htmlmenu += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>Bratislava</h4><h4>B.Bystrica</h4><h4>Nitra</h4><h4>TrenËÌn</h4><h4>Trnava</h4>";
    htmlmenu += "<h4>Koöice</h4><h4>Preöov</h4><h4>éilina</h4></th>";
    htmlmenu += "</tr>";
<?php          } ?>
    htmlmenu += "<tr>";
    htmlmenu += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szba; ?>';VyberZhasni();\"><?php echo $riadok->szba; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szbb; ?>';VyberZhasni();\"><?php echo $riadok->szbb; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sznr; ?>';VyberZhasni();\"><?php echo $riadok->sznr; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztn; ?>';VyberZhasni();\"><?php echo $riadok->sztn; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->sztt; ?>';VyberZhasni();\"><?php echo $riadok->sztt; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szke; ?>';VyberZhasni();\"><?php echo $riadok->szke; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szpo; ?>';VyberZhasni();\"><?php echo $riadok->szpo; ?>&nbsp;&nbsp;</a>";
    htmlmenu += "<a href=\"#\" onclick=\"document.formv1.r10.value='<?php echo $riadok->szza; ?>';VyberZhasni();\"><?php echo $riadok->szza; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu += "</table></div>";
<?php                      } ?>


<?php if ( $copern == 20 ) { ?>
  function ukazrobot2()
  {
   myRobot2 = document.getElementById("robot2");
   myRobot2.innerHTML = htmlmenu2;
   robot2.style.display='';
  }
  function zhasnirobot2()
  {
   robot2.style.display='none';
  }
  function VyberZhasni2()
  {
   robot2.style.display='none';
   document.formv1.r11.focus();
   document.formv1.r11.select();
  }

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv_znizene WHERE csdz = 12 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
var htmlmenu2 = "<div class='sadzby-dane2-box'>";
    htmlmenu2 += "<h2>Sadzby dane z motorov˝ch vozidiel</h2><img src='../obr/ikony/turnoff_blue_icon.png' onclick='zhasnirobot2();' title='Skryù menu'>";
    htmlmenu2 += "<table class='sadzby-dane2'>";
    htmlmenu2 += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3></h3><h5>Koöice</h5><h5>éilina</h5><h5>Trnava</h5><h5>TrenËÌn</h5><h5>Nitra</h5><h5>B.Bystrica</h5></th>";
    htmlmenu2 += "</tr>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 4,5<br>EEV</h4><h4>EURO 6</h4>";
    htmlmenu2 += "<h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4></th>";
    htmlmenu2 += "</tr>";
<?php          } ?>
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke1; ?>';VyberZhasni2();\"><?php echo $riadok->szke1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke2; ?>';VyberZhasni2();\"><?php echo $riadok->szke2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza1; ?>';VyberZhasni2();\"><?php echo $riadok->szza1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza2; ?>';VyberZhasni2();\"><?php echo $riadok->szza2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt1; ?>';VyberZhasni2();\"><?php echo $riadok->sztt1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt2; ?>';VyberZhasni2();\"><?php echo $riadok->sztt2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn1; ?>';VyberZhasni2();\"><?php echo $riadok->sztn1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn2; ?>';VyberZhasni2();\"><?php echo $riadok->sztn2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr1; ?>';VyberZhasni2();\"><?php echo $riadok->sznr1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr2; ?>';VyberZhasni2();\"><?php echo $riadok->sznr2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb1; ?>';VyberZhasni2();\"><?php echo $riadok->szbb1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb2; ?>';VyberZhasni2();\"><?php echo $riadok->szbb2; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu2 += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu2 += "</table>";

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv_znizene WHERE csdz = 13 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
    htmlmenu2 += "<table class='sadzby-dane2'>";
    htmlmenu2 += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3></h3><h5>Koöice</h5><h5>éilina</h5><h5>Trnava</h5><h5>TrenËÌn</h5><h5>Nitra</h5><h5>B.Bystrica</h5></th>";
    htmlmenu2 += "</tr>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 4,5<br>EEV</h4><h4>EURO 6</h4>";
    htmlmenu2 += "<h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4></th>";
    htmlmenu2 += "</tr>";
<?php          } ?>
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke1; ?>';VyberZhasni2();\"><?php echo $riadok->szke1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke2; ?>';VyberZhasni2();\"><?php echo $riadok->szke2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza1; ?>';VyberZhasni2();\"><?php echo $riadok->szza1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza2; ?>';VyberZhasni2();\"><?php echo $riadok->szza2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt1; ?>';VyberZhasni2();\"><?php echo $riadok->sztt1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt2; ?>';VyberZhasni2();\"><?php echo $riadok->sztt2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn1; ?>';VyberZhasni2();\"><?php echo $riadok->sztn1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn2; ?>';VyberZhasni2();\"><?php echo $riadok->sztn2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr1; ?>';VyberZhasni2();\"><?php echo $riadok->sznr1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr2; ?>';VyberZhasni2();\"><?php echo $riadok->sznr2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb1; ?>';VyberZhasni2();\"><?php echo $riadok->szbb1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb2; ?>';VyberZhasni2();\"><?php echo $riadok->szbb2; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu2 += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu2 += "</table>";

<?php
$sqltt = "SELECT * FROM F".$kli_vxcf."_sadzby_dmv_znizene WHERE csdz = 14 ORDER BY csdz,cprm ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
if ( $i == 0 ) { ?>
    htmlmenu2 += "<table class='sadzby-dane2'>";
    htmlmenu2 += "<caption><?php echo $riadok->nsdz; ?></caption>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3></h3><h5>Koöice</h5><h5>éilina</h5><h5>Trnava</h5><h5>TrenËÌn</h5><h5>Nitra</h5><h5>B.Bystrica</h5></th>";
    htmlmenu2 += "</tr>";
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<th><h3><?php echo $riadok->pprm; ?></h3><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 4,5<br>EEV</h4><h4>EURO 6</h4>";
    htmlmenu2 += "<h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4><h4>EURO 3</h4><h4>EURO 4,5</h4><h4>EURO 3</h4><h4>EURO 4,5,6<br>EEV</h4></th>";
    htmlmenu2 += "</tr>";
<?php          } ?>
    htmlmenu2 += "<tr>";
    htmlmenu2 += "<td><h6><?php echo $riadok->nprm; ?>&nbsp;&nbsp;&nbsp;</h6>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke1; ?>';VyberZhasni2();\"><?php echo $riadok->szke1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szke2; ?>';VyberZhasni2();\"><?php echo $riadok->szke2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza1; ?>';VyberZhasni2();\"><?php echo $riadok->szza1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szza2; ?>';VyberZhasni2();\"><?php echo $riadok->szza2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt1; ?>';VyberZhasni2();\"><?php echo $riadok->sztt1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztt2; ?>';VyberZhasni2();\"><?php echo $riadok->sztt2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn1; ?>';VyberZhasni2();\"><?php echo $riadok->sztn1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sztn2; ?>';VyberZhasni2();\"><?php echo $riadok->sztn2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr1; ?>';VyberZhasni2();\"><?php echo $riadok->sznr1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->sznr2; ?>';VyberZhasni2();\"><?php echo $riadok->sznr2; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb1; ?>';VyberZhasni2();\"><?php echo $riadok->szbb1; ?>&nbsp;&nbsp;</a>";
    htmlmenu2 += "<a href=\"#\" onclick=\"document.formv1.r11.value='<?php echo $riadok->szbb2; ?>';VyberZhasni2();\"><?php echo $riadok->szbb2; ?>&nbsp;&nbsp;</a></td>";
    htmlmenu2 += "</tr>";
<?php
  }
$i=$i+1;
   }
?>
    htmlmenu2 += "</table></div>";
<?php                      } ?>
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
  if ( $copern == 20 )
  {
?>

<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DaÚ z motorov˝ch vozidiel <?php echo $kli_vrok; ?></td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="Sadzby2015();" title="Sadzby DMV pre rok 2015" class="btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacDMV();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="priznanie_dmv<?php echo $rokdmv; ?>.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&cislo_cpl=<?php echo $cislo_cpl;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active";

$source="../ucto/priznanie_dmv".$rokdmv.".php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">vozidl·</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 5 ) { ?> <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave"> <?php } ?>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str1.jpg" alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2013 1.strana" class="form-background">

<div class="nofill krizik" style="top:236px; left:76px;"><?php if ( $fir_uctt03 == 999 ) echo "x"; ?></div>
<div class="nofill krizik" style="top:236px; left:236px;"><?php if ( $fir_uctt03 != 999 ) echo "x"; ?></div>

<input type="text" name="fir_fdic" id="fir_fdic" disabled="disabled" class="nofill" style="width:220px; top:287px; left:51px;"/>
<input type="text" name="dar" id="dar" disabled="disabled" class="nofill" style="width:195px; top:342px; left:51px;"/>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:290px; left:423px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:315px; left:423px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:340px; left:423px;"/>
<!-- Za zdanovacie obdobie -->
<input type="text" name="zoo" id="zoo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:237px; left:696px;"/>
<input type="text" name="zod" id="zod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:276px; left:696px;"/>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:343px; left:696px;"/>

<?php
//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
if ( $fir_uctt03 != 999 ) { $dmeno = ""; $dprie = ""; $dtitl = ""; }
if ( $fir_uctt03 == 999 ) { $fir_fnaz = ""; }
?>
<!-- Udaje o FO -->
<input type="text" name="dprie" id="dprie" value="<?php echo $dprie; ?>" disabled="disabled" class="nofill" style="width:359px; top:454px; left:51px;"/>
<input type="text" name="dmeno" id="dmeno" value="<?php echo $dmeno; ?>" disabled="disabled" class="nofill" style="width:244px; top:454px; left:430px;"/>
<input type="text" name="dtitl" id="dtitl" value="<?php echo $dtitl; ?>" disabled="disabled" class="nofill" style="width:198px; top:454px; left:694px;"/>
<input type="text" name="fod" id="fod" style="width:842px; top:510px; left:51px;" />
<!-- Udaje o PO -->
<input type="text" name="obchm" id="obchm" value="<?php echo $fir_fnaz; ?>" disabled="disabled" class="nofill" style="width:842px; top:588px; left:51px;"/>
<div class="nofill" style="width:846px; height:26px; top:626px; left:51px;"></div>

<?php
//trvaly pobyt z ufirdalsie, sidlo z udajov o firme PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dfax = $fir_riadok->dfax;
$xstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dfax = $fir_ffax;
$xstat = "SK";
}
$polet = explode("/", $dtel);
$dtel_pred=$polet[0];
$dtel_cislo=$polet[1];
$polef = explode("/", $dfax);
$dfax_pred=$polef[0];
$dfax_cislo=$polef[1];
?>
<!-- Adresa pobytu FO alebo sidlo PO -->
<input type="text" name="duli" id="duli" value="<?php echo $duli; ?>" disabled="disabled" class="nofill" style="width:635px; top:701px; left:51px;"/>
<input type="text" name="dcdm" id="dcdm" value="<?php echo $dcdm; ?>" disabled="disabled" class="nofill" style="width:175px; top:701px; left:718px;"/>
<input type="text" name="dpsc" id="dpsc" value="<?php echo $dpsc; ?>" disabled="disabled" class="nofill" style="width:107px; top:756px; left:51px;"/>
<input type="text" name="dmes" id="dmes" value="<?php echo $dmes; ?>" disabled="disabled" class="nofill" style="width:451px; top:756px; left:178px;"/>
<input type="text" name="xstat" id="xstat" value="<?php echo $xstat; ?>" disabled="disabled" class="nofill" style="width:245px; top:756px; left:648px;"/>
<input type="text" name="dtel_pred" id="dtel_pred" value="<?php echo $dtel_pred; ?>" disabled="disabled" class="nofill" style="width:83px; top:812px; left:51px;"/>
<input type="text" name="dtel_cislo" id="dtel_cislo" value="<?php echo $dtel_cislo; ?>" disabled="disabled" class="nofill" style="width:174px; top:812px; left:166px;"/>
<input type="text" name="dfax_pred" id="dfax_pred" value="<?php echo $dfax_pred; ?>" disabled="disabled" class="nofill" style="width:83px; top:812px; left:361px;"/>
<input type="text" name="dfax_cislo" id="dfax_cislo" value="<?php echo $dfax_cislo; ?>" disabled="disabled" class="nofill" style="width:174px; top:812px; left:476px;"/>

<?php
//prechodny adresa pobytu FOB, prevadzkaren PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = trim($fir_riadok->d2uli);
$d2cdm = $fir_riadok->d2cdm;
$d2mes = $fir_riadok->d2mes;
$d2psc = $fir_riadok->d2psc;
$d2tel = $fir_riadok->d2tel;
$polet = explode("/", $d2tel);
$d2tel_pred=$polet[0];
$d2tel_cislo=$polet[1];
$d2fax = $fir_riadok->d2fax;
$polef = explode("/", $d2fax);
$d2fax_pred=$polef[0];
$d2fax_cislo=$polef[1];
if ( $fir_uctt03 != 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = trim($fir_riadok->pruli);
$d2cdm = $fir_riadok->prcdm;
$d2mes = $fir_riadok->prmes;
$d2psc = $fir_riadok->prpsc;
$d2tel = $fir_ftel;
$polet = explode("/", $d2tel);
$d2tel_pred=$polet[0];
$d2tel_cislo=$polet[1];
$d2fax = $fir_ffax;
$polef = explode("/", $d2fax);
$d2fax_pred=$polef[0];
$d2fax_cislo=$polef[1];
}
if ( $d2uli == '' ) { $d2tel_pred=""; $d2tel_cislo=""; $d2fax_pred=""; $d2fax_cislo=""; }
?>
<!-- Adresa prechodneho pobytu FO alebo prevadzkarne PO -->
<input type="text" name="d2uli" id="d2uli" value="<?php echo $d2uli; ?>" disabled="disabled" class="nofill" style="width:635px; top:900px; left:51px;"/>
<input type="text" name="d2cdm" id="d2cdm" value="<?php echo $d2cdm; ?>" disabled="disabled" class="nofill" style="width:175px; top:900px; left:718px;"/>
<input type="text" name="d2psc" id="d2psc" value="<?php echo $d2psc; ?>" disabled="disabled" class="nofill" style="width:107px; top:956px; left:51px;"/>
<input type="text" name="d2mes" id="d2mes" value="<?php echo $d2mes; ?>" disabled="disabled" class="nofill" style="width:451px; top:956px; left:178px;"/>
<input type="text" name="d2tel" id="d2tel" value="<?php echo $d2tel_pred; ?>" disabled="disabled" class="nofill" style="width:83px; top:1011px; left:51px;"/>
<input type="text" name="d2tel" id="d2tel" value="<?php echo $d2tel_cislo; ?>" disabled="disabled" class="nofill" style="width:174px; top:1011px; left:166px;"/>
<input type="text" name="d2fax" id="d2fax" value="<?php echo $d2fax_pred; ?>" disabled="disabled" class="nofill" style="width:83px; top:1011px; left:361px;"/>
<input type="text" name="d2fax" id="d2fax" value="<?php echo $d2fax_cislo; ?>" disabled="disabled" class="nofill" style="width:174px; top:1011px; left:476px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str2.jpg" alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2013 2.strana 380kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:69px; left:401px;"/>

<!-- II. ODDIEL -->
<input type="checkbox" name="druh31" id="druh31" value="1" onclick="klik31();" style="top:173px; left:67px;"/>
<input type="checkbox" name="druh32" id="druh32" value="1" onclick="klik32();" style="top:198px; left:67px;"/>
<input type="checkbox" name="druh33" id="druh33" value="1" onclick="klik33();" style="top:223px; left:67px;"/>
<input type="checkbox" name="druh34" id="druh34" value="1" onclick="klik34();" style="top:173px; left:469px;"/>
<input type="checkbox" name="druh35" id="druh35" value="1" onclick="klik35();" style="top:198px; left:469px;"/>

<input type="text" name="d3prie" id="d3prie" style="width:359px; top:278px; left:51px;"/>
<input type="text" name="d3meno" id="d3meno" style="width:244px; top:278px; left:430px;"/>
<input type="text" name="d3titl" id="d3titl" style="width:199px; top:278px; left:694px;"/>
<input type="text" name="rdc3" id="rdc3" style="width:129px; top:334px; left:51px;"/>
<input type="text" name="rdk3" id="rdk3" style="width:84px; top:334px; left:212px;"/>
<input type="text" name="dar3" id="dar3" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:334px; left:327px;"/>
<input type="text" name="dic3" id="dic3" style="width:221px; top:334px; left:568px;"/>
<input type="text" name="naz3" id="naz3" style="width:842px; top:390px; left:51px;"/>

<input type="text" name="d3uli" id="d3uli" style="width:635px; top:466px; left:51px;"/>
<input type="text" name="d3cdm" id="d3cdm" style="width:175px; top:466px; left:718px;"/>
<input type="text" name="d3psc" id="d3psc" style="width:107px; top:522px; left:51px;"/>
<input type="text" name="d3mes" id="d3mes" style="width:451px; top:522px; left:178px;"/>
<input type="text" name="xstat3" id="xstat3" style="width:245px; top:522px; left:648px;"/>
<input type="text" name="d3tel_pred" id="d3tel_pred" style="width:83px; top:578px; left:51px;"/>
<input type="text" name="d3tel_cislo" id="d3tel_cislo" style="width:175px; top:578px; left:166px;"/>
<input type="text" name="d3fax_pred" id="d3fax_pred" style="width:83px; top:578px; left:361px;"/>
<input type="text" name="d3fax_cislo" id="d3fax_cislo" style="width:175px; top:578px; left:476px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE cpl = $cislo_cpl ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$vzkat = $fir_riadok->vzkat;
$vzdru = $fir_riadok->vzdru;
$vzzn = $fir_riadok->vzzn;
$vzspz = $fir_riadok->vzspz;
$da1sk = SkDatum($fir_riadok->da1);
$datzsk = SkDatum($fir_riadok->datz);
$datksk = SkDatum($fir_riadok->datk);
$vzobm = $fir_riadok->vzobm;
$vzchm = $fir_riadok->vzchm;
$vznpr = $fir_riadok->vznpr;
$vzdno = $fir_riadok->vzdno;
$vzdnp = $fir_riadok->vzdnp;
$r10 = $fir_riadok->r10;
$r11 = $fir_riadok->r11;
$r12 = $fir_riadok->r12;
$r13 = $fir_riadok->r13;
$r14 = $fir_riadok->r14;
$r15 = $fir_riadok->r15;
$r16 = $fir_riadok->r16;
$r17 = $fir_riadok->r17;
$r18 = $fir_riadok->r18;
$r19 = $fir_riadok->r19;
$r20 = $fir_riadok->r20;
$r21 = $fir_riadok->r21;
$r22 = $fir_riadok->r22;
$r23 = $fir_riadok->r23;
$r24 = $fir_riadok->r24;
$r50 = $fir_riadok->r50;
?>
<img src="../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str3.jpg" alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2013 3.strana 380kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:69px; left:452px;"/>

<!-- III. ODDIEL -->
<input type="text" name="da1" id="da1" value="<?php echo $da1sk; ?>" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:163px; left:431px;"/>
<input type="text" name="datz" id="datz" value="<?php echo $datzsk; ?>" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:208px; left:431px;"/>

<select size="1" name="vzkat" id="vzkat" style="width:38px; top:251px; left:468px;">
 <option value="M">M</option>
 <option value="N">N</option>
 <option value="O">O</option>
</select>
<select size="1" name="vzdru" id="vzdru" style="width:38px; top:251px; left:595px;">
 <option value="1">1 - osobnÈ vozdlo</option>
 <option value="2">2 - n·kladnÈ vozidlo</option>
 <option value="3">3 - n·kladnÈ vozidlo ñ ùahaË n·vesu</option>
 <option value="4">4 - autobus</option>
 <option value="5">5 - prÌpojnÈ vozidlo ñ n·ves</option>
 <option value="6">6 - prÌpojnÈ vozidlo ñ prÌves</option>
</select>

<input type="text" name="vzspz" id="vzspz" value="<?php echo $vzspz; ?>" style="width:218px; top:297px; left:409px;"/>
<input type="text" name="vzobm" id="vzobm" value="<?php echo $vzobm; ?>" style="width:82px; top:341px; left:545px;"/>
<input type="text" name="vzchm" id="vzchm" value="<?php echo $vzchm; ?>" onkeyup="CiarkaNaBodku(this);" style="width:106px; top:386px; left:395px;"/>
<input type="text" name="vznpr" id="vznpr" value="<?php echo $vznpr; ?>" style="width:14px; top:386px; left:613px;"/>

<select size="1" name="vzdno" id="vzdno" style="width:34px; top:430px; left:525px;">
 <option value="0"></option>
 <option value="1">1</option>
 <option value="2">2</option></select>
<select size="1" name="vzdnp" id="vzdnp" style="width:36px; top:430px; left:603px;">
 <option value=" "></option>
 <option value="A">A</option>
 <option value="B">B</option>
 <option value="C">C</option>
</select>
 <img src="../obr/ikony/info_blue_icon.png" onclick="HelpDanovnici();" title="Druhy daÚovnÌkov podæa ß 85" class="btn-row-tool" style="top:434px; left:650px;" >

<script>
  document.formv1.vzkat.value = '<?php echo "$vzkat";?>';
  document.formv1.vzdru.value = '<?php echo "$vzdru";?>';
  document.formv1.vzdno.value = '<?php echo "$vzdno";?>';
  document.formv1.vzdnp.value = '<?php echo "$vzdnp";?>';
</script>

<input type="text" name="r10" id="r10" value="<?php echo $r10; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:475px; left:476px;"/>
 <img src="../obr/ikony/info_blue_icon.png" onclick="ukazrobot();" title="Sadzby dane z motorov˝ch vozidiel" class="btn-row-tool" style="top:477px; left:650px;">
 <div id="robot" class="sadzby-dane-box-locate" style="top:510px; left:110px;"></div>
<input type="text" name="r11" id="r11" value="<?php echo $r11; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:525px; left:476px;"/>
 <img src="../obr/ikony/info_blue_icon.png" onclick="ukazrobot2();" title="ZnÌûenÈ sadzby dane z motorov˝ch vozidiel" class="btn-row-tool" style="top:525px; left:650px;">
 <div id="robot2" class="sadzby-dane-box-locate" style="top:558px; left:38px;"></div>
<input type="text" name="r12" id="r12" value="<?php echo $r12; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:583px; left:476px;"/>
<input type="text" name="r13" id="r13" value="<?php echo $r13; ?>" style="width:60px; top:635px; left:567px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocetDni();" title="VypoËÌtaù dni, poËas ktor˝ch vozidlo podliehalo dani a pomern˙ Ëasù dane" class="btn-row-tool" style="top:637px; left:645px;">

<input type="text" name="r14" id="r14" value="<?php echo $r14; ?>" style="width:60px; top:679px; left:567px;"/>
<input type="text" name="r15" id="r15" value="<?php echo $r15; ?>" style="width:60px; top:724px; left:567px;"/>
<input type="text" name="r16" id="r16" value="<?php echo $r16; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:768px; left:476px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocitajDan();" title="VypoËÌtaù pomern˙ Ëasù dane podæa poËtu zadan˝ch dnÌ" class="btn-row-tool" style="top:770px; left:645px;">
<input type="text" name="r17" id="r17" value="<?php echo $r17; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:818px; left:476px;"/>
<input type="text" name="r18" id="r18" value="<?php echo $r18; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:880px; left:476px;"/>
<input type="text" name="r19" id="r19" value="<?php echo $r19; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:936px; left:476px;"/>
<input type="text" name="r20" id="r20" value="<?php echo $r20; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:977px; left:476px;"/>
<input type="text" name="r21" id="r21" value="<?php echo $r21; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1018px; left:476px;"/>
<input type="text" name="r22" id="r22" value="<?php echo $r22; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1077px; left:476px;"/>
<input type="text" name="r23" id="r23" value="<?php echo $r23; ?>" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1118px; left:476px;"/>
<input type="text" name="r24" id="r24" value="<?php echo $r24; ?>" onkeyup="CiarkaNaBodku(this);" style="width:172px; top:1159px; left:455px;"/>

<label for="vzzn" class="added-label" style="top:1215px; left:51px;">ZnaËka vozidla</label>
 <input type="text" name="vzzn" id="vzzn" value="<?php echo $vzzn; ?>" style="width:360px; top:1205px; left:285px;"/>
<label for="datk" class="added-label" style="top:1250px; left:51px;">Z·nik daÚovej povinnosti</label>
 <input type="text" name="datk" id="datk" value="<?php echo $datksk; ?>" onkeyup="CiarkaNaBodku(this);" style="width:120px; top:1240px; left:285px;"/>

<label for="datk" class="added-label" style="top:1250px; left:500px;">Zæava 50 alebo 100% elektromobil,hybrid...</label>
 <input type="text" name="r50" id="r50" value="<?php echo $r50; ?>" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:1240px; left:800px;"/>
<?php                     } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str4.jpg" alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2013 4.strana 380kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:69px; left:401px;"/>

<!-- IV. ODDIEL -->
<input type="text" name="r35" id="r35" style="width:82px; top:149px; left:593px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:188px; left:503px;"/>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:229px; left:503px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:269px; left:503px;"/>
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:309px; left:503px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:349px; left:503px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocitajPredpoDan();" title="VypoËÌtaù predpokladan˙ daÚ" class="btn-row-tool" style="top:350px; left:763px;">
<input type="text" name="r41" id="r41" style="width:82px; top:389px; left:593px;"/>

<!-- V. ODDIEL -->
<input type="text" name="r42" id="r42" style="width:82px; top:469px; left:593px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:508px; left:503px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:547px; left:483px;"/>
<input type="text" name="r45" id="r45" style="width:82px; top:588px; left:593px;"/>

<!-- VI. ODDIEL -->
<input type="checkbox" name="zvra" value="1" style="top:673px; left:59px;"/>
<?php if ( $zvra == 1 ) { ?>
<script>document.formv1.zvra.checked = "checked";</script>
<?php                   } ?>

<input type="checkbox" name="post" value="1" onclick="budalebox12();" style="top:723px; left:122px;"/>
<script>
  function budalebox12()
  {                 
  if ( document.formv1.post.checked ) { document.formv1.ucet.checked=''; }
  if ( !document.formv1.post.checked ) { document.formv1.ucet.checked='checked'; }
  } 
</script>
<?php if ( $post == 1 ) { ?>
<script>document.formv1.post.checked = "checked";</script>
<?php                   } ?>

<input type="checkbox" name="ucet" value="1" onclick="budalebox11();" style="top:723px; left:289px;" />
<script type="text/javascript">
  function budalebox11()
  {                 
  if ( document.formv1.ucet.checked ) { document.formv1.post.checked=''; }
  if ( !document.formv1.ucet.checked ) { document.formv1.post.checked='checked'; }
  } 
</script>
<?php if ( $ucet == 1 ) { ?>
<script>document.formv1.ucet.checked = "checked";</script>
<?php                   } ?>
<input type="text" name="fir_fuc1" id="fir_fuc1" value="<?php echo $fir_fuc1; ?>" disabled="disabled" class="nofill" style="width:359px; top:732px; left:402px;"/>
<input type="text" name="fir_fnm1" id="fir_fnm1" value="<?php echo $fir_fnm1; ?>" disabled="disabled" class="nofill" style="width:83px; top:732px; left:803px;"/>
<input type="text" name="dvp" id="dvp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:795px; left:116px;"/>

<!-- VII. ODDIEL -->
<textarea name="pozn" id="pozn" style="width:838px; height:99px; top:892px; left:53px;"><?php echo $pozn; ?></textarea>

<!-- VIII. ODDIEL -->
<textarea name="pomv" id="pomv" style="width:838px; height:99px; top:1051px; left:53px;"><?php echo $pomv; ?></textarea>
<input type="text" name="dvh" id="dvh" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1216px; left:116px;"/>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) {

//VYPIS ZOZNAMU VOZIDIEL
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ORDER BY vzspz ";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <table class="vozidla">
 <caption>Zoznam vozidiel
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="NovÈ vozidlo">
 </caption>
 <thead>
  <tr>
   <td width="10%" align="center">E»V</td>
   <td width="35%">ZnaËka</td>
   <td width="5%" align="center">Katg.</td>
   <td width="13%" align="center">D·tum vzniku</td>
   <td width="13%" align="center">D·tum z·niku</td>
   <td width="12%" align="right">DaÚ</td>
   <td width="12%" align="center">&nbsp;</td>
  </tr>
 </thead>

<?php
$i=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
 {
$rsluz=mysql_fetch_object($sluz);
?>
 <tbody>
  <tr>
   <td align="center"><?php echo $rsluz->vzspz;?></td>
   <td><?php echo $rsluz->vzzn;?></td>
   <td align="center" ><?php echo $rsluz->vzkat;?></td>
   <td align="center"><?php echo SkDatum($rsluz->datz);?></td>
   <td align="center">
    <img src="../obr/ikony/list_blue_icon.png" onclick="VytvorOznamZanik(<?php echo $rsluz->cpl;?>);" title="Vytvoriù ozn·menie o z·niku daÚovej povinnosti">
    <?php echo SkDatum($rsluz->datk);?>
   </td>
   <td align="right"><?php echo $rsluz->r21;?></td>
   <td align="center">
    <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl;?>);" title="Upraviù vozidlo">&nbsp;&nbsp;
    <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl;?>);" title="Vymazaù vozidlo">
   </td>
  </tr>
 </tbody>
<?php
 }
$i=$i+1;
   }
?>
 </table>
</div>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">vozidl·</a>
<?php if ( $strana != 5 ) { ?> <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave"> <?php } ?>
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
  }
//koniec uprav udaje
?>


<?php
/////////////////////////////////////////////////VYTLAC ROCNE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/priznaniedmv.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/priznaniedmv.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE F$kli_vxcf"."_uctpriznanie_dmv.oc = 9999 ORDER BY oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_dat = SkDatum($hlavicka->da21 );
if ( $dat_dat == '0000-00-00' ) $dat_dat="";

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kriziky FO,PO
$pdf->SetY(48);
$fo="";
$po="x";
if ( $fir_uctt03 == 999 ) { $fo="x"; $po=""; }
$pdf->SetX(17);
$pdf->Cell(3,4,"$fo","$rmc",0,"C");
$pdf->SetX(52);
$pdf->Cell(4,4,"$po","$rmc",0,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->SetY(61);
$pdf->Cell(86,3," ","$rmc",0,"C");$pdf->Cell(4,4,"$riadne","$rmc",1,"L");
$pdf->SetY(67);
$pdf->Cell(86,3," ","$rmc",0,"C");$pdf->Cell(4,3,"$opravne","$rmc",1,"L");
$pdf->SetY(73);
$pdf->Cell(86,3," ","$rmc",0,"C");$pdf->Cell(4,3,"$dodat","$rmc",0,"L");

//za zdanovacie obdobie od
$pdf->SetY(49);
$text=SkDatum($hlavicka->zoo);
if ( $text =='00.00.0000' ) $text="01.01.".$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//za zdanovacie obdobie do
$pdf->SetY(58);
$text=SkDatum($hlavicka->zod);
if ( $text =='00.00.0000' ) $text="31.12.".$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//datum dodatocneho
$pdf->SetY(73);
$text="";
if ( $hlavicka->druh == 3 ) $text=SkDatum($hlavicka->ddp);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,-18,"                          ","$rmc",1,"L");
$textxx="1234567890";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
//if ( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//datum narodenia
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=SKDatum($hlavicka->dar);
if ( $fir_uctt03 != 999 ) $text="";
if ( $text =='00.00.0000' ) $text="";
$textxx="01012010";
$pole = explode(".", $text);
$text=$pole[0].$pole[1].$pole[2];
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//priezvisko,meno a titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
}
$pdf->Cell(190,20,"                          ","$rmc",1,"L");
$A=substr($dprie,0,1);
$B=substr($dprie,1,1);
$C=substr($dprie,2,1);
$D=substr($dprie,3,1);
$E=substr($dprie,4,1);
$F=substr($dprie,5,1);
$G=substr($dprie,6,1);
$H=substr($dprie,7,1);
$I=substr($dprie,8,1);
$J=substr($dprie,9,1);
$K=substr($dprie,10,1);
$L=substr($dprie,11,1);
$M=substr($dprie,12,1);
$N=substr($dprie,13,1);
$O=substr($dprie,14,1);
$P=substr($dprie,15,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");

$A=substr($dmeno,0,1);
$B=substr($dmeno,1,1);
$C=substr($dmeno,2,1);
$D=substr($dmeno,3,1);
$E=substr($dmeno,4,1);
$F=substr($dmeno,5,1);
$G=substr($dmeno,6,1);
$H=substr($dmeno,7,1);
$I=substr($dmeno,8,1);
$J=substr($dmeno,9,1);
$K=substr($dmeno,10,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");

$A=substr($dtitl,0,1);
$B=substr($dtitl,1,1);
$C=substr($dtitl,2,1);
$D=substr($dtitl,3,1);
$E=substr($dtitl,4,1);
$F=substr($dtitl,5,1);
$G=substr($dtitl,6,1);
$H=substr($dtitl,7,1);
$I=substr($dtitl,8,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//dodatok obchodneho mena FO
$pdf->Cell(190,7,"                          ","$rmc",1,"L");
$text=$hlavicka->fod;
if ( $fir_uctt03 != 999 ) $text="";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//obchodne meno PO
$pdf->Cell(190,11,"                          ","$rmc",1,"L");
if ( $fir_uctt03 == 999 ) $fir_fnaz="";
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//trvaly pobyt z ufirdalsie alebo sidlo z udajov o firme PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dfax = $fir_riadok->dfax;
$xstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dfax = $fir_ffax;
$xstat = "SK";
}

//ulica
$pdf->Cell(190,20,"                          ","$rmc",1,"L");
$text=$duli;
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo
$text=$dcdm;
$textxx="111122";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$dpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$dmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");

//stat
$text=$xstat;
$textxx="SK";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$dtel;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(8,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//cislo faxu
$text=$dfax;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(9,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"L");

//prechodny pobyt FOB alebo prevadzkaren PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = $fir_riadok->d2uli;
$d2cdm = $fir_riadok->d2cdm;
$d2mes = $fir_riadok->d2mes;
$d2psc = $fir_riadok->d2psc;
$d2tel = $fir_riadok->d2tel;
$d2fax = $fir_riadok->d2fax;
if ( $fir_uctt03 != 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$d2uli = $fir_riadok->pruli;
$d2cdm = $fir_riadok->prcdm;
$d2mes = $fir_riadok->prmes;
$d2psc = $fir_riadok->prpsc;
$d2tel = $fir_ftel;
$d2fax = $fir_ffax;
}

//ulica2
$pdf->Cell(190,13,"                          ","$rmc",1,"L");
$text=$d2uli;
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(4,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo2
$text=$d2cdm;
$textxx="01234567";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",1,"C");

//psc2
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$d2psc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(4,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec2
$text=$d2mes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",1,"C");

//cislo telefonu2
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$d2tel;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(8,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"L");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//cislo faxu2
$text=$d2fax;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(9,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,0,"                          ","$rmc",1,"L");
$textxx="0123456789";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
//if( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(81,7," ","$rmc",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//II.ODDIEL splnomocneny zastupca
//druh splnomocnenia
$krz1="";
$krz2="";
$krz3="";
$krz4="";
$krz5="";
if ( $hlavicka->druh3 == 1 ) { $krz1="x"; }
if ( $hlavicka->druh3 == 2 ) { $krz2="x"; }
if ( $hlavicka->druh3 == 3 ) { $krz3="x"; }
if ( $hlavicka->druh3 == 4 ) { $krz4="x"; }
if ( $hlavicka->druh3 == 5 ) { $krz5="x"; }
$pdf->SetY(35);
$pdf->SetX(16);
$pdf->Cell(3,3,"$krz1","$rmc",0,"C");
$pdf->SetX(104);
$pdf->Cell(4,3,"$krz4","$rmc",0,"C");
$pdf->SetY(40);
$pdf->SetX(16);
$pdf->Cell(3,4,"$krz2","$rmc",0,"C");
$pdf->SetX(104);
$pdf->Cell(4,4,"$krz5","$rmc",0,"C");
$pdf->SetY(46);
$pdf->SetX(16);
$pdf->Cell(3,3,"$krz3","$rmc",1,"C");

//priezvisko3
$pdf->Cell(190,9,"                          ","$rmc",1,"L");
$text=$hlavicka->d3prie;
$textxx="ABCDEFGHIJKLMNOP";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$pdf->Cell(3,7," ","$rmc",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//meno3
$text=$hlavicka->d3meno;
$textxx="ABCDEFGHI";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");

//titul3
$text=$hlavicka->d3titl;
$textxx="ABCDEFGHI";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",1,"C");

//rodne cislo3
$pdf->Cell(190,7,"                          ","$rmc",1,"L");
$text=$hlavicka->rdc3.$hlavicka->rdk3;
$textxx="1234567890";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//datum narodenia3
$text=SKDatum($hlavicka->dar3);
$textxx="01012010";
if ( $text =='00.00.0000' ) $text="";
$pole = explode(".", $text);
$text=$pole[0].$pole[1].$pole[2];
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

//dic3
$text=$hlavicka->dic3;
$textxx="1234567890";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(8,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//obchodne meno3
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$hlavicka->naz3;
$textxx="ABCDEFGHIJKLMNOPRSTUVaaaaaaaaaaaaaaa";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//trvaly pobyt3 FO alebo sÌdlo3 PO
//ulica3
$pdf->Cell(190,11,"                          ","$rmc",1,"L");
$text=$hlavicka->d3uli;
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo3
$text=$hlavicka->d3cdm;
$textxx="01234567";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc3
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$hlavicka->d3psc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec3
$text=$hlavicka->d3mes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

//stat3
$text=$hlavicka->xstat3;
$textxx="SK";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",1,"C");

//cislo telefonu3
$pdf->Cell(190,6,"                          ","$rmc",1,"L");
$text=$hlavicka->d3tel;
$text=str_replace(" ","",$text);
$textxx="0905/665882";
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(8,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"R");$pdf->Cell(2,7," ","$rmc",0,"L");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//cislo faxu3
$text=$hlavicka->d3fax;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(8,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(2,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",1,"C");
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {
$stranav=0;
$sqlttv = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE F$kli_vxcf"."_uctpriznanie_dmv.oc = 1 ORDER BY vzspz";
$sqlv = mysql_query("$sqlttv");
$polv = mysql_num_rows($sqlv);
$iv=0;
$jv=0; //zaciatok strany ak by som chcel strankovat

  while ($iv <= $polv )
  {
  if (@$zaznam=mysql_data_seek($sqlv,$iv))
{
$hlavickav=mysql_fetch_object($sqlv);

if ( $jv == 0 ) {
$stranav=$stranav+1;
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,1,"                          ","$rmc",1,"L");
$textxx="0123456789";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
if ( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(92,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");
                }

//VOZIDLO I.
$pdf->SetY(32);
$stlpx=83;
if ( $jv == 1 ) { $stlpx=142; }

//datum prvej evidencie
$text=SKDatum($hlavickav->da1);
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,6,1);
$t06=substr($text,7,1);
$t07=substr($text,8,1);
$t08=substr($text,9,1);
$pdf->SetX($stlpx);
$pdf->Cell(12,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//datum vzniku povinnosti
$pdf->Cell(195,5,"                          ","$rmc",1,"L");
$text=SKDatum($hlavickav->datz);
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,6,1);
$t06=substr($text,7,1);
$t07=substr($text,8,1);
$t08=substr($text,9,1);
$pdf->SetX($stlpx);
$pdf->Cell(12,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//kategoria a druh vozidla
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$vzkatg=$hlavickav->vzkat;
$vzdruh=$hlavickav->vzdru;
if ( $hlavickav->vzkat =='' ) $vzdruh="";
$pdf->SetX($stlpx);
$pdf->Cell(24,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$vzkatg","$rmc",0,"C");$pdf->Cell(24,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$vzdruh","$rmc",1,"C");

//evidencne cislo
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$text=$hlavickav->vzspz;
$textxx="SE676AJ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->SetX($stlpx);
$pdf->Cell(7,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//objem motora
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$text=$hlavickav->vzobm;
if ( $text == 0 ) { $text=""; }
$textxx="900";
$text=sprintf("% 4s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->SetX($stlpx);
$pdf->Cell(38,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//hmotnost vozidla(t)
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$text=100*$hlavickav->vzchm;
if ( $text == 0 ) { $text=""; }
$textxx="1200";
$text=sprintf("% 4s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->SetX($stlpx);
$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

//pocet naprav
$text=100*$hlavickav->vznpr;
if ( $text == 0 ) { $text=""; }
$textxx="2";
$t01=substr($text,0,1);
$pdf->Cell(24,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",1,"C");

//danovnik
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$text=$hlavickav->vzdno;
if ( $text == 0 ) $text="";
$textxx="5";
$text2=$hlavickav->vzdnp;
$text2xx="a";
$t01=substr($text,0,1);
$t02=substr($text2,0,1);
$pdf->SetX($stlpx);
$pdf->Cell(35,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(14,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//rocna sadzba dane
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r10;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121114";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r11
$pdf->Cell(195,6,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r11;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121214";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r12
$pdf->Cell(195,7,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r12;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121214";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r13
$pdf->Cell(195,6,"                          ","$rmc",1,"L");
$hodx=$hlavickav->r13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 3s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->SetX($stlpx);
$pdf->Cell(42,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",1,"C");

//r14
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$hodx=$hlavickav->r14;
if ( $hodx == 0 ) $hodx="";
$hodxxx="28";
$text=sprintf("% 3s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->SetX($stlpx);
$pdf->Cell(42,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",1,"C");

//r15
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$hodx=$hlavickav->r15;
if ( $hodx == 0 ) $hodx="";
$hodxxx="120";
$text=sprintf("% 3s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->SetX($stlpx);
$pdf->Cell(42,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",1,"C");

//r16
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r16;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121314";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r17
$pdf->Cell(195,6,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r17;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121414";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r18
$pdf->Cell(195,8,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r18;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121514";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r19
$pdf->Cell(195,7,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r19;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121614";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r20
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r20;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121714";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r21
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r21;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121814";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r22
$pdf->Cell(195,8,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r22;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxxx="121914";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r23
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r23;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxxx="122014";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->SetX($stlpx);
$pdf->Cell(22,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r24
$pdf->Cell(195,4,"                          ","$rmc",1,"L");
$hodx=100*$hlavickav->r24;
$znamienko=" ";
if ( $hodx == 0 ) $hodx="";
if ( $hlavicka->druh != 3 ) $hodx="";
$hodxxx="-122114";
if ( $hodx < 0 ) { $hodx=-1*$hodx; $znamienko="-"; }
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->SetX($stlpx);
$pdf->Cell(18,6," ","$rmc",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

if ( $jv == 0 ) {
//cislo strany hore v prilohe
$tlachod=$stranav;
$tlachodxx="111";
  $pole = explode(".", $tlachod);
  $tlachod_c = $pole[0];
  $tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 3s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);

$pdf->SetY(11);
$pdf->SetX(38);
$pdf->Cell(5,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");

//pocet stran hore v prilohe
$tlachod=$hlavickav->pos;
$tlachodxx="222";
  $pole = explode(".", $tlachod);
  $tlachod_c = $pole[0];
  $tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 3s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);

$pdf->Cell(11,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
                }
}
$iv = $iv + 1;
$jv = $jv + 1;
if ( $jv == 2 ) { $jv=0; }
  }
                                       } //koniec 3.strany

if ( $strana == 4 OR $strana == 9999 ) {

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists ('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str4.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,0,"                          ","$rmc",1,"L");
$textxx="0123456789";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
//if( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(81,7," ","$rmc",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//r35
$pdf->Cell(195,12,"                          ","$rmc",1,"L");
$hodx=$hlavicka->r35;
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r36
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r36;
if ( $hodx == 0 ) $hodx="";
$hodxx="124822";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r37
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r37;
$hodxx="124922";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r38
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r38;
if ( $hodx == 0 ) $hodx="";
$hodxx="125022";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r39
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r39;
if ( $hodx == 0 ) $hodx="";
$hodxx="125122";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r40
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r40;
$hodxx="125222";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r41
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=$hlavicka->r41;
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r42
$pdf->Cell(195,13,"                          ","$rmc",1,"L");
$hodx=$hlavicka->r42;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="6";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r43
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r43;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="125522";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r44
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=100*$hlavicka->r44;
$znamienko=" ";
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="-125622";
if ( $hodx < 0 ) { $hodx=-1*$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(99,6," ","$rmc",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r45
$pdf->Cell(195,3,"                          ","$rmc",1,"L");
$hodx=$hlavicka->r45;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//VI.ODDIEL
//ziadam o vratenie preplatku
$pdf->Cell(190,14,"                          ","$rmc",1,"L");
$krizik=" ";
if ( $hlavicka->zvra == 1 ) $krizik="x";
$pdf->Cell(6,3," ","$rmc",0,"R");$pdf->Cell(3,3,"$krizik","$rmc",1,"L");

//postovou poukazkou
$pdf->Cell(190,8,"                          ","$rmc",1,"L");
$krizik=" ";
if ( $hlavicka->post == 1 ) $krizik="x";
if ( $hlavicka->zvra == 0 ) $krizik=" ";
$pdf->Cell(20,3," ","$rmc",0,"R");$pdf->Cell(3,3,"$krizik","$rmc",0,"L");

//na ucet
$krizik=" ";
if ( $hlavicka->ucet == 1 ) $krizik="x";
if ( $hlavicka->zvra == 0 ) $krizik=" ";
$pdf->Cell(34,3," ","$rmc",0,"R");$pdf->Cell(3,3,"$krizik","$rmc",0,"R");

//cislo uctu
$text=$fir_fuc1;
if ( $hlavicka->zvra == 0 ) $text=" ";
if ( $hlavicka->ucet == 0 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$pdf->Cell(21,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t01","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"L");$pdf->Cell(4,10,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t04","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t05","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t06","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t07","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t08","$rmc",0,"R");
$pdf->Cell(2,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t12","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t13","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t14","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t15","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t16","$rmc",0,"R");

//kod banky
$text=$fir_fnm1;
if ( $hlavicka->zvra == 0 ) $text=" ";
if ( $hlavicka->ucet == 0 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(9,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t01","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"R");$pdf->Cell(4,10,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,10,"$t04","$rmc",1,"L");

//datum ziadosti
$pdf->Cell(190,7,"                          ","$rmc",1,"L");
$textxx="123456";
$text=SKDatum($hlavicka->dvp);
if ( $hlavicka->zvra == 0 ) $text="";
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(18,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//VII. ODDIEL POZNAMKY
$pdf->Cell(190,16,"                          ","$rmc",1,"L");
$text=$hlavicka->pozn;
$poleosob = explode("\r\n", $text);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }

//VII. ODDIEL
//pomocne vypocty
$pdf->SetY(235);
$text=$hlavicka->pomv;
$poleosob = explode("\r\n", $text);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }

//datum vyhlasenia
$pdf->SetY(273);
$text=SKDatum($hlavicka->dvh);
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(18,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");
                                       } //koniec 4.strany
}
$i = $i + 1;
  }
$pdf->Output("../tmp/priznaniedmv.$kli_uzid.pdf");

//potvrdenie o podani
if ( $copern == 10 )
  {
if ( File_Exists("../tmp/potvrddmv$kli_uzid.pdf")) { $soubor = unlink("../tmp/potvrddmv$kli_uzid.pdf"); }
$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if (File_Exists ('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(8);

//za rok
$pdf->Cell(190,40,"     ","$rmc",1,"L");
$pdf->Cell(151,6," ","$rmc",0,"C");$pdf->Cell(23,5,"$kli_vrok","$rmc",1,"C");

//druh priznania
$pdf->Cell(190,11,"     ","$rmc",1,"L");
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->Cell(190,2,"     ","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc",0,"C");$pdf->Cell(5,4,"$riadne","$rmc",1,"C");
$pdf->Cell(10,4," ","$rmc",0,"C");$pdf->Cell(5,5,"$opravne","$rmc",1,"C");
$pdf->Cell(10,4," ","$rmc",0,"C");$pdf->Cell(5,4,"$dodat","$rmc",1,"C");

//priezvisko,meno alebo obchodne meno
$pdf->Cell(190,24," ","$rmc",1,"L");
$dmeno = "";
$dprie = $fir_fnaz;
$dtitl = "";
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
}
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(164,6,"$dprie $dmeno","$rmc",1,"L");

//dic
$pdf->Cell(190,9," ","$rmc",1,"L");
$text=$fir_fdic;
//if( $text == 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(10,5," ","$rmc",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(6,5,"$B","$rmc",0,"C");$pdf->Cell(7,5,"$C","$rmc",0,"C");
$pdf->Cell(6,5,"$D","$rmc",0,"C");$pdf->Cell(6,5,"$E","$rmc",0,"C");$pdf->Cell(7,5,"$F","$rmc",0,"C");$pdf->Cell(6,5,"$G","$rmc",0,"C");
$pdf->Cell(6,5,"$H","$rmc",0,"C");$pdf->Cell(7,5,"$I","$rmc",0,"C");$pdf->Cell(6,5,"$J","$rmc",0,"C");

//datum narodenia
$text=SKDatum($hlavicka->dar);
if ( $text =='00.00.0000' ) $text="";
$textxx="01012010";
$pole = explode(".", $text);
$text=$pole[0].$pole[1].$pole[2];
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(38,5," ","$rmc",0,"R");$pdf->Cell(7,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");
$pdf->Cell(7,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(7,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");
$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",1,"C");

//trvaly pobyt z FOB alebo sidlo z udajov o firme PO
$pdf->Cell(190,19," ","$rmc",1,"L");
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dfax = $fir_ffax;
$xstat = "SK";
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dfax = $fir_riadok->dfax;
$xstat = $fir_riadok->xstat;
}
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(164,6,"$duli $dcdm","$rmc",1,"L");

//psc a nazov obce
$pdf->Cell(190,9," ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(30,5,"$dpsc","$rmc",0,"L");$pdf->Cell(23,6," ","$rmc",0,"L");$pdf->Cell(111,5,"$dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,9," ","$rmc",1,"L");
$pdf->Cell(11,6," ","$rmc",0,"L");$pdf->Cell(55,7,"$xstat","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,13," ","$rmc",1,"L");
$r36=$hlavicka->r36; if ( $r36 == 0 ) $r36="";
$r38=$hlavicka->r38; if ( $r38 == 0 ) $r38="";
$r39=$hlavicka->r39; if ( $r39 == 0 ) $r39="";
$r35=$hlavicka->r35; if ( $r35 == 0 ) $r35="";
$r41=$hlavicka->r41; if ( $r41 == 0 ) $r41="";
$pdf->Cell(66,5," ","$rmc",0,"L");$pdf->Cell(108,6,"$r36","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc",0,"L");$pdf->Cell(108,5,"$r38","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc",0,"L");$pdf->Cell(108,5,"$r39","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc",0,"L");$pdf->Cell(108,5,"$r35","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc",0,"L");$pdf->Cell(108,5,"$r41","$rmc",1,"R");

$pdf->Output("../tmp/potvrddmv$kli_uzid.pdf");
  }
//koniec potvrdenia o podani
?>

<?php if ( $xml == 0 ) { ?>
<script type="text/javascript">
  var okno = window.open("../tmp/priznaniedmv.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php                  } ?>
<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO
?>

<?php
/////////////////////////////////////////////////VYTLAC OZNAMENIE
if ( $copern == 70 )
{
if ( File_Exists("../tmp/oznamdmv$kli_uzid.pdf")) { $soubor = unlink("../tmp/oznamdmv$kli_uzid.pdf"); }
     $sirka_vyska="210,320";
     $velkost_strany = explode(",", $sirka_vyska);

define('FPDF_FONTPATH','../fpdf/font/');
require('../fpdf/fpdf.php');
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE F$kli_vxcf"."_uctpriznanie_dmv.cpl = $cislo_cpl ORDER BY oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_dat = SkDatum($hlavicka->da21 );
if ( $dat_dat == '0000-00-00' ) $dat_dat="";

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_oznamenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpdmv2013/DMVv13_oznamenie.jpg',0,0,209,297);
}
$pdf->SetY(8);

//sidlo DU
$pdf->Cell(190,26,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"C");$pdf->Cell(42,6,"$fir_uctt01","$rmc",1,"L");

//dic
$pdf->Cell(190,39,"     ","$rmc",1,"L");
$text=$fir_fdic;
//if( $text == 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$J=substr($text,9,1);
$pdf->Cell(130,4," ","$rmc",0,"R");$pdf->Cell(4,4,"$A","$rmc",0,"C");$pdf->Cell(5,4,"$B","$rmc",0,"C");$pdf->Cell(4,4,"$C","$rmc",0,"C");
$pdf->Cell(4,4,"$D","$rmc",0,"C");$pdf->Cell(4,4,"$E","$rmc",0,"C");$pdf->Cell(4,4,"$F","$rmc",0,"C");$pdf->Cell(5,4,"$G","$rmc",0,"C");
$pdf->Cell(4,4,"$H","$rmc",0,"C");$pdf->Cell(4,4,"$I","$rmc",0,"C");$pdf->Cell(5,4,"$J","$rmc",1,"C");

//priezvisko, meno, titul FO
$pdf->Cell(190,38,"      ","$rmc",1,"L");
$dmeno = "";
$dprie = "";
$dtitl = "";
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
}
$pdf->Cell(31,6," ","$rmc",0,"L");$pdf->Cell(49,6,"$dmeno","$rmc",0,"L");$pdf->Cell(12,6," ","$rmc",0,"L");$pdf->Cell(55,6,"$dprie","$rmc",0,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(12,6,"$dtitl","$rmc",1,"L");

//obch.meno
$pdf->Cell(190,1,"             ","$rmc",1,"L");
$pdf->Cell(64,6," ","$rmc",0,"L");$pdf->Cell(105,6,"$fir_fnaz","$rmc",1,"L");

//trvale bydliskoFO alebo sidlo PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dfax = $fir_riadok->dfax;
$xstat = $fir_riadok->xstat;
if ( $fir_uctt03 != 999 )
{
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dfax = $fir_ffax;
$xstat = "SK";
}

//ulica a cislo
$pdf->Cell(190,12,"    ","$rmc",1,"L");
$pdf->Cell(21,6," ","$rmc",0,"L");$pdf->Cell(108,6,"$duli","$rmc",0,"L");$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(30,6,"$dcdm","$rmc",1,"L");

//psc a obec
$pdf->Cell(190,1," ","$rmc",1,"L");
$pdf->Cell(20,6," ","$rmc",0,"L");$pdf->Cell(35,6,"$dpsc","$rmc",0,"L");$pdf->Cell(22,6," ","$rmc",0,"L");$pdf->Cell(92,6,"$dmes","$rmc",1,"L");

//oznamujem DU
$pdf->SetFont('arial','',8);
$pdf->Cell(190,40,"      ","$rmc",1,"L");
$pdf->Cell(122,5," ","$rmc",0,"C");$pdf->Cell(23,5,"$fir_uctt01","$rmc",1,"L");

//datum zaniku povinnosti
$pdf->SetFont('arial','',10);
$datzsk=SKDatum($hlavicka->datk);
if ( $datzsk == '00.00.0000' ) { $datzsk=""; }
$pdf->Cell(62,3," ","$rmc",0,"C");$pdf->Cell(27,4,"$datzsk","$rmc",1,"L");

//SPZ vozidla
$pdf->Cell(190,10," ","$rmc",1,"L");
$text=$hlavicka->vzspz;
$textxx="SE676AJ";
$pdf->Cell(67,5," ","$rmc",0,"C");$pdf->Cell(33,5,"$text","$rmc",1,"L");

//mesto a den oznamenia
$pdf->Cell(190,8,"    ","$rmc",1,"L");
$pdf->Cell(24,5," ","$rmc",0,"C");$pdf->Cell(42,6,"$fir_fmes","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc",0,"C");$pdf->Cell(20,6,"$datzsk","$rmc",1,"L");

}
$i = $i + 1;
  }
$pdf->Output("../tmp/oznamdmv$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/oznamdmv<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA OZNAMENIA copern=70
?>


<?php
//tlac predpoklad
if ( $predpoklad == 1 AND $kli_vrok == 2014 )
     {

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
echo "<table width='100%' >";
echo "<tr><td colspan='10'>PREDPOKLADAN¡ DA“ na bud˙ci rok<td/></tr>";
echo "<tr><td width='10%' >SPZ</td><td width='10%' >1.evidencia </td><td width='10%' >kategÛria </td><td width='5%' >druh </td><td width='5%' >objem</td>";
echo "<td width='10%' >n·prav </td><td width='10%' >hmotnosù </td><td width='10%' >sadzba </td><td width='10%' >mesiacov </td><td width='10%' >zæava </td><td width='10%' >daÚ</td>";
echo "</tr>";
if( $pol > 0 )
          {

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

echo "<tr><td>".$hlavicka->vzspz."</td><td>".SkDatum($hlavicka->da1)."</td><td>".$hlavicka->vzkat."</td><td>".$hlavicka->vzdru."</td><td>";
echo $hlavicka->vzobm."</td><td>".$hlavicka->vznpr."</td><td>".$hlavicka->vzchm."</td><td>".$hlavicka->r13;
echo "</td><td>".$hlavicka->r11."</td><td>".$hlavicka->r12."</td><td>".$hlavicka->r10."</td><tr />";

}
$i = $i + 1;

  }
echo "<tr><td colspan='10'>SPOLU ZA VäETKY VOZIDL¡ ".$danpredpok."<td/></tr></table>";
           }

$sqtoz = "DROP TABLE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid ";
//$oznac = mysql_query("$sqtoz");
exit;


     }
//koniec tlac predpoklad
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>