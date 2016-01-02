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

$rokdmv=2015;
if ( $kli_vrok > 2015 ) { $rokdmv=2015; }

$citfir = include("../cis/citaj_fir.php");

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
$rmc1=0;

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


//prepocitaj vsetky vozidla
    if ( $copern == 2020 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_spz = $_REQUEST['cislo_spz'];
?>
<script type="text/javascript">
if( !confirm ("Chcete vypoËÌtaù sadzby a daÚ pre vöetky vozidl· ? \r Pozor program najprv vymaûe pÙvodnÈ sadzby a daÚ vo vöetk˝ch vozidl·ch.") )
         { location.href='priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=9999&drupoh=1&page=1&subor=0&copern=20&strana=5' }
else
         { location.href='priznanie_dmv<?php echo $rokdmv; ?>.php?copern=20&cislo_cpl=0&dajsadzbu=1&dajvsetky=1' }
</script>
<?php
exit;                      
    }
//koniec prepocitaj vsetky vozidla

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
$cislo_spz = $_REQUEST['cislo_spz'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù vozidlo <?php echo $cislo_spz; ?> ?") )
         { location.href='priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=9999&drupoh=1&page=1&subor=0&copern=20&strana=5' }
else
         { location.href='priznanie_dmv<?php echo $rokdmv; ?>.php?copern=3166&page=1&drupoh=1&cislo_cpl=<?php echo $cislo_cpl; ?>' }
</script>
<?php
exit;                      
    }

    if ( $copern == 3166 )
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

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctpriznanie_dmv ( oc, druh, vzdnp, vzdno, vznpr, vzchm, vzobm, vzkat, vzdru, vzzn, vzspz, ".
" datz, r49, r50, vzvyk, dnvnk, da1 ) VALUES ".
" ( '$hlavicka->oc', '$hlavicka->druh', '$hlavicka->vzdnp', '$hlavicka->vzdno', '$hlavicka->vznpr', '$hlavicka->vzchm', '$hlavicka->vzobm', ".
" '$hlavicka->vzkat', '$hlavicka->vzdru', '$hlavicka->vzzn', '$hlavicka->vzspz', '$hlavicka->datz', '$hlavicka->r49', '$hlavicka->r50', ".
" '$hlavicka->vzvyk', '$hlavicka->dnvnk', '$hlavicka->da1' ) ";
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

if( $kli_vrok == 2015 )
  {

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET dnvnk=vzdnp ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r15s1zni50a=1 WHERE r50 = 50 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r12doniz=1 WHERE r49 = 1 ";
$upravene = mysql_query("$uprtxt");

//zmena druhov
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdrx=vzdru ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='' ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='L1' WHERE vzkat = 'L' ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='M1' WHERE vzkat = 'M' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='M2' WHERE vzkat = 'M' AND vzdrx = 4 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='M3' WHERE vzkat = 'M' AND vzdrx = 4 AND vzchm > 5 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='N1' WHERE vzkat = 'N' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='N2' WHERE vzkat = 'N' AND vzchm > 3.5 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='N3' WHERE vzkat = 'N' AND vzchm > 12 ";
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='O1' WHERE vzkat = 'O' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='O2' WHERE vzkat = 'O' AND vzchm > 0.75 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='O3' WHERE vzkat = 'O' AND vzchm > 3.5 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzdru='O4' WHERE vzkat = 'O' AND vzchm > 10 ";
$upravene = mysql_query("$uprtxt");

  }

$prenosminuly=1;
$copern=20;
$strana=5;
//exit;
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
$zahos = 1*$_REQUEST['zahos'];
$zouli = strip_tags($_REQUEST['zouli']);
$zocdm = strip_tags($_REQUEST['zocdm']);
$zopsc = strip_tags($_REQUEST['zopsc']);
$zomes = strip_tags($_REQUEST['zomes']);
$zotel = strip_tags($_REQUEST['zotel']);
$zoema = strip_tags($_REQUEST['zoema']);
if ( $zoosql == '0000-00-00' ) { $zoosql=$kli_vrok."-01-01"; }
if ( $zodsql == '0000-00-00' ) { $zodsql=$kli_vrok."-12-31"; }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" dar='$darsql', ddp='$ddpsql', zoo='$zoosql', zod='$zodsql', fod='$fod', ".
" rdc='$rdc', rdk='$rdk', druh='$druh', zahos='$zahos', ".
" zouli='$zouli', zocdm='$zocdm', zopsc='$zopsc', zomes='$zomes', zotel='$zotel', zoema='$zoema' ".
" WHERE oc = 9999 ";
                    }

if ( $strana == 2 ) {
$druh31 = strip_tags($_REQUEST['druh31']);
$druh32 = strip_tags($_REQUEST['druh32']);
$druh33 = strip_tags($_REQUEST['druh33']);
$druh34 = strip_tags($_REQUEST['druh34']);
//$druh35 = strip_tags($_REQUEST['druh35']);
$dedic = strip_tags($_REQUEST['dedic']);
$likvi = strip_tags($_REQUEST['likvi']);
$druh3=0;
if ( $druh31 == 1 ) { $druh3=1; }
if ( $druh32 == 1 ) { $druh3=2; }
if ( $druh33 == 1 ) { $druh3=3; }
if ( $druh34 == 1 ) { $druh3=4; }
//if ( $druh35 == 1 ) { $druh3=5; }
if ( $dedic == 1 ) { $druh3=6; }
if ( $likvi == 1 ) { $druh3=7; }
$rdc3 = strip_tags($_REQUEST['rdc3']);
$rdk3 = strip_tags($_REQUEST['rdk3']);
$naz3 = strip_tags($_REQUEST['naz3']);
$dic3 = strip_tags($_REQUEST['dic3']);
$d3meno = strip_tags($_REQUEST['d3meno']);
$d3prie = strip_tags($_REQUEST['d3prie']);
$d3titl = strip_tags($_REQUEST['d3titl']);
$d3titz = strip_tags($_REQUEST['d3titz']);
$d3uli = strip_tags($_REQUEST['d3uli']);
$d3cdm = strip_tags($_REQUEST['d3cdm']);
$d3psc = strip_tags($_REQUEST['d3psc']);
$d3mes = strip_tags($_REQUEST['d3mes']);
$d3tel = strip_tags($_REQUEST['d3tel']);
$d3fax = strip_tags($_REQUEST['d3fax']);
$xstat3 = strip_tags($_REQUEST['xstat3']);
$dar3 = strip_tags($_REQUEST['dar3']);
$dar3sql=SqlDatum($dar3);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" rdc3='$rdc3', rdk3='$rdk3', dic3='$dic3', d3meno='$d3meno', d3prie='$d3prie', ".
" d3titl='$d3titl', d3titz='$d3titz', dar3='$dar3sql', xstat3='$xstat3', ".
" druh3='$druh3', d3uli='$d3uli', d3cdm='$d3cdm', d3psc='$d3psc', d3mes='$d3mes', ".
" d3tel='$d3tel', d3fax='$d3fax', naz3='$naz3', dedic='$dedic', likvi='$likvi' ".
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
$r12 = 1*$_REQUEST['r12'];
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
$r49 = 1*$_REQUEST['r49'];
$vzvyk = strip_tags($_REQUEST['vzvyk']);
$r12doniz = 1*$_REQUEST['r12doniz'];
$dnvnk = strip_tags($_REQUEST['dnvnk']);
$oslbd = strip_tags($_REQUEST['oslbd']);
$r13s1zni25 = 1*$_REQUEST['r13s1zni25'];
$r13s1zni20 = 1*$_REQUEST['r13s1zni20'];
$r13s1zni15 = 1*$_REQUEST['r13s1zni15'];
$r13s2zni25 = 1*$_REQUEST['r13s2zni25'];
$r13s2zni20 = 1*$_REQUEST['r13s2zni20'];
$r13s2zni15 = 1*$_REQUEST['r13s2zni15'];
$r13s1zvy10 = 1*$_REQUEST['r13s1zvy10'];
$r13s1zvy20 = 1*$_REQUEST['r13s1zvy20'];
$r13s2zvy10 = 1*$_REQUEST['r13s2zvy10'];
$r13s2zvy20 = 1*$_REQUEST['r13s2zvy20'];

$druh3=0;
if ( $druh31 == 1 ) { $druh3=1; }
if ( $druh32 == 1 ) { $druh3=2; }
if ( $druh33 == 1 ) { $druh3=3; }
if ( $druh34 == 1 ) { $druh3=4; }
//if ( $druh35 == 1 ) { $druh3=5; }
if ( $dedic == 1 ) { $druh3=6; }
if ( $likvi == 1 ) { $druh3=7; }

$r14s1 = strip_tags($_REQUEST['r14s1']);
$r14s2 = strip_tags($_REQUEST['r14s2']);
$r15s1zni50a = 1*$_REQUEST['r15s1zni50a'];
$r15s1zni50b = 1*$_REQUEST['r15s1zni50b'];
$r15s1zni50c = 1*$_REQUEST['r15s1zni50c'];
$r16s1 = strip_tags($_REQUEST['r16s1']);
$r16s2 = strip_tags($_REQUEST['r16s2']);
$r17kombi = strip_tags($_REQUEST['r17kombi']);
$r18s1 = strip_tags($_REQUEST['r18s1']);
$r18s2 = strip_tags($_REQUEST['r18s2']);
$r19s1mes = strip_tags($_REQUEST['r19s1mes']);
$r19s2mes = strip_tags($_REQUEST['r19s2mes']);
$r19s1dni = strip_tags($_REQUEST['r19s1dni']);
$r19s2dni = strip_tags($_REQUEST['r19s2dni']);
$r20s1 = strip_tags($_REQUEST['r20s1']);
$r20s2 = strip_tags($_REQUEST['r20s2']);

//ak sa pri ulozeni zmenila sadzba, pocet mesiacov prepocitaj pomernu dan
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE cpl = $cislo_cpl ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $r12old=1*$riaddok->r12;
 $r19s1mesold=1*$riaddok->r19s1mes;

 }
$r12new=1*$r12;
$r19s1mesnew=1*$r19s1mes;


if ( $r12old != $r12new ) { $vypocitajdan=1; }
if ( $r19s1mesold != $r19s1mesnew ) { $vypocitajdan=1; }

//ak sa pri ulozeni zmenil datum zac alebo kon prepocitaj dni a pomernu
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE cpl = $cislo_cpl ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $datzold=$riaddok->datz;
 $datkold=$riaddok->datk;
 $da1old=$riaddok->da1;
 }
$datznew=$datzsql;
$datknew=$datksql;
$da1new=$da1sql;

if ( $datzold != $datznew ) { $_REQUEST['dajsadzbu']=1; }
if ( $datkold != $datknew ) { $_REQUEST['dajsadzbu']=1; }
if ( $da1old != $da1new ) { $_REQUEST['dajsadzbu']=1; }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" vzkat='$vzkat', vzdru='$vzdru', vzzn='$vzzn', da1='$da1sql', datz='$datzsql', datk='$datksql', ".
" vzspz='$vzspz', vzobm='$vzobm', vzchm='$vzchm', vznpr='$vznpr', vzdno='$vzdno', vzdnp='$vzdnp', ".
" r10='$r10', r11='$r11', r12='$r12', r13='$r13', r14='$r14', r15='$r15', r16='$r16', ".
" r17='$r17', r18='$r18', r19='$r19', r20='$r20', ".
" r21='$r21',r22='$r22', r23='$r23', r24='$r24', r50='$r50', r49='$r49', r12doniz='$r12doniz', ".
" vzvyk='$vzvyk', dnvnk='$dnvnk', oslbd='$oslbd', ".
" r13s1zni25='$r13s1zni25', r13s1zni20='$r13s1zni20', r13s1zni15='$r13s1zni15', ".
" r13s2zni25='$r13s2zni25', r13s2zni20='$r13s2zni20', r13s2zni15='$r13s2zni15', ".
" r13s1zvy10='$r13s1zvy10', r13s1zvy20='$r13s1zvy20', r13s2zvy10='$r13s2zvy10', r13s2zvy20='$r13s2zvy20', ".
" r14s1='$r14s1', r14s2='$r14s2', ".
" r15s1zni50a='$r15s1zni50a', r15s1zni50b='$r15s1zni50b', r15s1zni50c='$r15s1zni50c', ".
" r16s1='$r16s1', r16s2='$r16s2', r17kombi='$r17kombi', r18s1='$r18s1', r18s2='$r18s2', ".
" r19s1mes='$r19s1mes', r19s2mes='$r19s2mes', r19s1dni='$r19s1dni', r19s2dni='$r19s2dni', ".
" r20s1='$r20s1', r20s2='$r20s2' ".
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
//$pomv = strip_tags($_REQUEST['pomv']);
$pozn = strip_tags($_REQUEST['pozn']);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET ".
" r35='$r35', r36='$r36', r37='$r37', r38='$r38', r39='$r39', r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44', r45='$r45', ".
" zvra='$zvra', post='$post', ucet='$ucet', dvp='$dvpsql', dvh='$dvhsql', pozn='$pozn' ".
" WHERE oc = 9999 ";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$copern=20;
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

//vypocty
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET dnvnk='A' WHERE oc = 1 AND dnvnk = '' ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET vzkat='M', vzdru='M1' WHERE oc = 1 AND vzkat = '' ";
$upravene = mysql_query("$uprtxt");


//pocet dni v roku
$prvyden=$kli_vrok."-01-01";
$denposledny=$kli_vrok."-12-31";
if ( $predpoklad == 1 )
{
$kli_vrok2=$kli_vrok+1;
$prvyden=$kli_vrok2."-01-01";
$denposledny=$kli_vrok2."-12-31";
}
$sqltt = "SELECT * FROM kalendar WHERE dat >= '$prvyden' AND dat <= '$denposledny' ";
$sql = mysql_query("$sqltt");
$pocetdnirok = mysql_num_rows($sql);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET datz='$prvyden' WHERE oc = 1 AND datz = '0000-00-00' ";
$upravene = mysql_query("$uprtxt");


$dajvsetky = 1*$_REQUEST['dajvsetky'];
$predpoklad = 1*$_REQUEST['predpoklad'];
$dajsadzbu = 1*$_REQUEST['dajsadzbu'];
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

if( $dajvsetky == 1 OR $predpoklad == 1 OR $dajsadzbu == 1 OR $pocetdni == 1 OR $vypocitajdan == 1 )
          {

$akysub="";
if( $predpoklad == 1 ) { $akysub="x".$kli_uzid; }

$danpredpok=0;

$sqlttt = "DROP TABLE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid ";
$sqldok = mysql_query("$sqlttt");

$podmnacpl="";
if( $dajsadzbu == 1 )
  {
$podmnacpl="cpl = ".$cislo_cpl." AND ";
  }
if( $dajvsetky == 1 )
  {
$podmnacpl="";
  }

$podmdatk="";
if( $predpoklad == 1 )
  {
$podmdatk=" AND datk = '0000-00-00' ";
  }

$sqlttt = "CREATE TABLE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE $podmnacpl oc = 1 $podmdatk ";
$sqldok = mysql_query("$sqlttt");

if( $predpoklad == 1 )
  {
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx".$kli_uzid." SET r19s1mes=0, r19s2mes=0, r13s2zni25=0, r13s2zni20=0, r13s2zni15=0, ".
" r13s2zvy10=0, r13s2zvy20=0 WHERE oc = 1 $podmcpl";
$sqldok = mysql_query("$sqlttt");
  }

$sqltt = "SELECT * FROM F".$kli_vxcf."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 ORDER BY cpl ";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

if( $riadok->vzkat == 'M' AND $riadok->vzdru != 'M1' ) { $riadok->vzkat="N"; }

//osobne podla objemu
if( $riadok->vzkat == 'L' OR $riadok->vzkat == 'M' )
  {
$sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 7 ";
if( $riadok->vzobm <= 3000 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 6 "; }
if( $riadok->vzobm <= 2000 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 5 "; }
if( $riadok->vzobm <= 1500 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 4 "; }
if( $riadok->vzobm <= 1200 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 3 "; }
if( $riadok->vzobm <= 900  ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 2 "; }
if( $riadok->vzobm <= 150  ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 1 AND cprm = 1 "; }
  }

//nakladne podla naprav a hmotnosti
if( $riadok->vzkat == 'N' OR $riadok->vzkat == 'O' )
  {

if( $riadok->vznpr < 2 )
    {
$riadok->vznpr=2;
    }
if( $riadok->vznpr > 4 )
    {
$riadok->vznpr=4;
    }

if( $riadok->r12doniz == 1 )
    {
if( $riadok->vznpr == 2 AND $riadok->vzchm == 2 ) { $riadok->vzchm=1; }
if( $riadok->vznpr == 2 AND $riadok->vzchm >  2 AND $riadok->vzchm <= 30 ) { $riadok->vzchm=$riadok->vzchm-2; }
if( $riadok->vznpr == 2 AND $riadok->vzchm > 30 ) { $riadok->vzchm=28; }

if( $riadok->vznpr == 3 AND $riadok->vzchm > 15 AND $riadok->vzchm <= 37 ) { $riadok->vzchm=$riadok->vzchm-2; }
if( $riadok->vznpr == 3 AND $riadok->vzchm > 37 AND $riadok->vzchm <= 40 ) { $riadok->vzchm=37; }
if( $riadok->vznpr == 3 AND $riadok->vzchm > 40 ) { $riadok->vzchm=40; }

if( $riadok->vznpr == 4 AND $riadok->vzchm > 23 AND $riadok->vzchm <= 37 ) { $riadok->vzchm=$riadok->vzchm-2; }
if( $riadok->vznpr == 4 AND $riadok->vzchm > 37 AND $riadok->vzchm <= 40 ) { $riadok->vzchm=37; }
if( $riadok->vznpr == 4 AND $riadok->vzchm > 40 ) { $riadok->vzchm=40; }
    }

$sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 10 ";
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 40 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 9 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 37 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 8 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 35 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 7 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 33 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 6 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 31 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 5 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 29 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 4 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 27 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 3 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 25 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 2 "; }
if( $riadok->vznpr == 4 AND $riadok->vzchm <= 23 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 4 AND cprm = 1 "; }

if( $riadok->vznpr == 3 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 14 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 40 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 13 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 37 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 12 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 35 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 11 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 33 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 10 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 31 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 9 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 29 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 8 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 27 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 7 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 25 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 6 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 23 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 5 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 21 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 4 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 19 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 3 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 17 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 2 "; }
if( $riadok->vznpr == 3 AND $riadok->vzchm <= 15 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 1 "; }

if( $riadok->vznpr == 2 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 3 AND cprm = 17 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 30 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 16 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 28 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 15 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 26 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 14 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 24 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 13 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 22 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 12 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 20 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 11 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 18 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 10 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 16 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 9 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 14 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 8 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 12 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 7 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 10 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 6 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 8 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 5 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 6 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 4 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 4 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 3 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 2 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 2 "; }
if( $riadok->vznpr == 2 AND $riadok->vzchm <= 1 ) { $sqltts = "SELECT * FROM F$kli_vxcf"."_sadzby_dmv2015 WHERE csdz = 2 AND cprm = 1 "; }
  }

$sadzba12=0;
$sqldos = mysql_query("$sqltts");
  if (@$zaznam=mysql_data_seek($sqldos,0))
  {
  $riaddos=mysql_fetch_object($sqldos);
  $sadzba12=$riaddos->szba;
  }

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r12='$sadzba12' WHERE cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");


//echo "idem sadzba do r12"."<br />";


$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r14=YEAR(da1), r15=MONTH(da1) WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad1=0, mesad2=0, mesad3=0, mesad4=0, mesad5=0, r13=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$kli_vrok2=$kli_vrok;
$kli_vmes2=12;
if( $predpoklad == 1 ) { $kli_vrok2=$kli_vrok+1; $kli_vmes2=0;}
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad1=(($kli_vrok2-r14)*12)-(r15-1)+$kli_vmes2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad2=(($kli_vrok2-r14)*12)-(r15-1)+1 WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad3=MONTH(da1) WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad4=MONTH(datk) WHERE oc = 1 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad5=1 WHERE oc = 1 AND datz < '$prvyden' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad5=MONTH(datz) WHERE oc = 1 AND datz >= '$prvyden' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13s1zni25=0, r13s1zni20=0, r13s1zni15=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13s1zvy10=0, r13s1zvy20=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13=-0.25, r13s1zni25=1 WHERE oc = 1 AND mesad1 >=  1 AND mesad1 <= 36 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13=-0.20, r13s1zni20=1 WHERE oc = 1 AND mesad1 >= 37 AND mesad1 <= 72 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13=-0.15, r13s1zni15=1 WHERE oc = 1 AND mesad1 >= 73 AND mesad1 <= 108 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13=0.10, r13s1zvy10=1 WHERE oc = 1 AND mesad1 >= 145 AND mesad1 <= 156 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET r13=0.20, r13s1zvy20=1 WHERE oc = 1 AND mesad1 > 156 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid SET mesad1=0, r13=0 WHERE da1 = '0000-00-00' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");


$sqlttt = "SELECT r13s1zni25, r13s1zni20, r13s1zni15, r13s1zvy10, r13s1zvy20, mesad1, mesad2, mesad3, mesad4, mesad5 ".
" FROM F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 AND cpl = $riadok->cpl";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $mesad1x=$riaddok->mesad1;
  $mesad2x=$riaddok->mesad2;
  $mesad3x=$riaddok->mesad3;
  $mesad4x=$riaddok->mesad4;
  $mesad5x=$riaddok->mesad5;
  $r13s1zni25x=$riaddok->r13s1zni25;
  $r13s1zni20x=$riaddok->r13s1zni20;
  $r13s1zni15x=$riaddok->r13s1zni15;
  $r13s1zvy10x=$riaddok->r13s1zvy10;
  $r13s1zvy20x=$riaddok->r13s1zvy20;
  }


if( $dajsadzbu == 1 )
    {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r12='$sadzba12' WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zni25='$r13s1zni25x', r13s1zni20='$r13s1zni20x', r13s1zni15='$r13s1zni15x' WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET mesad1='$mesad1x', mesad2='$mesad2x', mesad3='$mesad3x', mesad4='$mesad4x', mesad5='$mesad5x', ".
" r13s1zvy10='$r13s1zvy10x', r13s1zvy20='$r13s1zvy20x' WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$pocetdni=1;
$copern=20;
$strana=3;
$zoznamaut=0;

if( $dajvsetky == 1 )
  {
$zoznamaut=1;
$strana=5;
  }

    }
//koniec dajsadzbu=1



$podmcpl=" AND cpl = $cislo_cpl ";
if ( $predpoklad == 1 )
{
$pocetdni=1;
$podmcpl="";
}
if( $dajvsetky == 1 )
{
$pocetdni=1;
$podmnacpl="";
}

if ( $pocetdni == 1 )
     {
//echo "idem pocet mesiacov r19 "."<br />";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET datz='$prvyden' WHERE oc = 1 AND datz = '0000-00-00' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=$pocetdni WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=DATEDIFF(datk,'$prvyden')+1 WHERE oc = 1 AND datk > '$prvyden' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=DATEDIFF('$denposledny',datz)+1 WHERE oc = 1 AND datz >= '$prvyden' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=DATEDIFF(datk,datz)+1 WHERE oc = 1 AND datz >= '$prvyden' AND datk >= '$prvyden' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=DATEDIFF(datk,'$prvyden')+1 WHERE oc = 1 AND datz < '$prvyden' AND datk >= '$prvyden' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=DATEDIFF('$denposledny','$prvyden')+1 WHERE oc = 1 AND datz < '$prvyden' AND datk = '0000-00-00' AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1dni=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=12 WHERE oc = 1 AND datz < '$prvyden' AND datk = '0000-00-00' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=12-(12-MONTH(datk)) WHERE oc = 1 AND datz < '$prvyden' AND datk >= '$prvyden' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=12-MONTH(datz)+1 WHERE oc = 1 AND datz >= '$prvyden' AND datk = '0000-00-00' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=12-MONTH(datz)+1-(12-MONTH(datk)) WHERE oc = 1 AND datz >= '$prvyden' AND datk >= '$prvyden' AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=12 WHERE oc = 1 AND r19s1mes = 0 AND cpl = $riadok->cpl ";
$sqldok = mysql_query("$sqlttt");


//rozdel do 2 stlpcov 

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r18=(mesad3-1)-(mesad5-1), r19=r19s1mes, r13s2zni25=0, r13s2zni20=0, r13s2zni15=0, r13s2zni0=0, ".
" r13s2zvy20=0, r13s2zvy10=0, r19s2mes=0 ".
" WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r18=0 WHERE oc = 1 AND r18 < 0 AND cpl = $riadok->cpl ";
//$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zni25=1, r13s1zni20=0, r13s2zni20=1, r19s1mes=r18, r19s2mes=r19-r18 ".
" WHERE oc = 1 AND mesad2 < 37 AND mesad1 >= 37 AND r13s1zni20 = 1 AND r18 >= 0 AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zni20=1, r13s1zni15=0, r13s2zni15=1, r19s1mes=r18, r19s2mes=r19-r18 ".
" WHERE oc = 1 AND mesad2 < 73 AND mesad1 >= 73 AND r13s1zni15 = 1 AND r18 >= 0 AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zni15=1, r13s2zni0=1, r19s1mes=r18, r19s2mes=r19-r18 ".
" WHERE oc = 1 AND mesad2 < 109 AND mesad1 >= 109 AND r18 >= 0 AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zvy10=0, r13s2zvy10=1, r19s1mes=r18, r19s2mes=r19-r18 ".
" WHERE oc = 1 AND mesad2 < 145 AND mesad1 >= 145 AND r13s1zvy10 = 1 AND r18 >= 0 AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r13s1zvy10=1, r13s1zvy20=0, r13s2zvy20=1, r19s1mes=r18, r19s2mes=r19-r18 ".
" WHERE oc = 1 AND mesad2 < 157 AND mesad1 >= 157 AND r13s1zvy20 = 1 AND r18 >= 0 AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r19s1mes=r19s2mes, r13s1zni25=r13s2zni25, r13s1zni20=r13s2zni20, r13s1zni15=r13s2zni15, ".
" r13s1zvy20=r13s2zvy20, r13s1zvy10=r13s2zvy10, ".
" r19s2mes=0, r13s2zni25=0, r13s2zni20=0, r13s2zni15=0, r13s2zni0=0, r13s2zvy20=0, r13s2zvy10=0 ".
" WHERE oc = 1 AND r19s1mes = 0 AND r19s2mes > 0 AND ".
" ( r13s2zni25 = 1 OR r13s2zni20 = 1 OR r13s2zni15 = 1 OR r13s2zni0 = 1 OR r13s2zvy10 = 1 OR r13s2zvy20 ) AND cpl = $riadok->cpl ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


     }
//koniec pocetdni=1


if ( $pocetdni == 1 ) { $vypocitajdan=1; }
if ( $vypocitajdan == 1 )
     {
//echo "idem vypocitaj dan r14,16,18,20 "."<br />";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.75 WHERE oc = 1 AND r13s1zni25 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.80 WHERE oc = 1 AND r13s1zni20 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.85 WHERE oc = 1 AND r13s1zni15 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*1.20 WHERE oc = 1 AND r13s1zvy20 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*1.10 WHERE oc = 1 AND r13s1zvy10 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r14s1=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//zniz ak r15
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r14s1 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r14s1*0.50 WHERE oc = 1 AND ( r15s1zni50a = 1 OR r15s1zni50b = 1 OR r15s1zni50c = 1 ) AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r16s1=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//zniz ak r17
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r16s1 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r16s1*0.50 WHERE oc = 1 AND r17kombi = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r18s1=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//s2
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.75 WHERE oc = 1 AND r13s2zni25 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.80 WHERE oc = 1 AND r13s2zni20 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*0.85 WHERE oc = 1 AND r13s2zni15 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*1.00 WHERE oc = 1 AND r13s2zni0 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*1.20 WHERE oc = 1 AND r13s2zvy20 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r12*1.10 WHERE oc = 1 AND r13s2zvy10 = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r14s2=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//zniz ak r15
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r14s2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r14s2*0.50 WHERE oc = 1 AND ( r15s1zni50a = 1 OR r15s1zni50b = 1 OR r15s1zni50c = 1 ) AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r16s2=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//zniz ak r17
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=0, des2=0 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r16s2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r16s2*0.50 WHERE oc = 1 AND r17kombi = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=0 WHERE oc = 1 AND des2 < 0 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r18s2=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");


$pomerdni=0;
if( $pomerdni == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r18s1/$pocetdnirok*r19s1dni WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s1=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s1=0 WHERE r20s1 < 0 AND oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
  }
$pomermes=1;
if( $pomermes == 1 )
  {
//echo "idem pomer mes"."<br />";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r18s1 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s1mes = 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r18s1/12 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s1mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6*r19s1mes WHERE oc = 1 AND cpl = $riadok->cpl AND r19s1mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s1mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s1=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s1=0 WHERE r20s1 < 0 AND oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

//s2
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r18s2 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s2mes = 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=r18s2/12 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s2mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6*r19s2mes WHERE oc = 1 AND cpl = $riadok->cpl AND r19s2mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des6=des6-0.005 WHERE oc = 1 AND cpl = $riadok->cpl AND r19s2mes < 12 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET des2=des6 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s2=des2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r20s2=0 WHERE r20s2 < 0 AND oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");
  }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv$akysub SET r21=r20s1+r20s2 WHERE oc = 1 AND cpl = $riadok->cpl ";
$upravene = mysql_query("$uprtxt");

     }
//koniec vypocitajdan=1




  }
$i=$i+1;
   }

          }
//koniec ak dajvsetko, predpoklad, dajsadzbu



if( $predpoklad == 1 )
  {

$danpredpok=0;
$sqlttt = "SELECT SUM(r21) AS sumr21 FROM F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
   {
   $riaddok=mysql_fetch_object($sqldok);
   $danpredpok=$riaddok->sumr21;
   }

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r40=$danpredpok WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
  }
//koniec ak predpoklad

//suma dane
$sumadane=0;
$sqlttt = "SELECT SUM(r21) AS sumr21, SUM(oc) AS sumoc FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumadane=$riaddok->sumr21;
  }
//koniec suma dne

//pocet vozidiel a na uhradu
$pocetvozidiel=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ");
$pocetvozidiel = mysql_num_rows($sqldok);

$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r35=$pocetvozidiel, r36=$sumadane, r41=$pocetvozidiel/2  WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r38=r36-r37, r39=0 WHERE oc = 9999 ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET r39=-r38, r38=0 WHERE oc = 9999 AND r38 < 0 ";
$upravene = mysql_query("$uprtxt");



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
//zmeny rok 2015
$sql = "SELECT r20s2 FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD new2015 DECIMAL(2,0) DEFAULT 0 AFTER r35";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r12doniz DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s1zni25 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s1zni20 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s1zni15 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zni25 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zni20 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zni15 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s1zvy10 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s1zvy20 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zvy10 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zvy20 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r14s1 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r14s2 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r15s1zni50a DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r15s1zni50b DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r15s1zni50c DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r16s1 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r16s2 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r17kombi DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r18s1 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r18s2 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r19s1mes DECIMAL(10,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r19s1dni DECIMAL(10,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r19s2mes DECIMAL(10,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r19s2dni DECIMAL(10,0) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r20s1 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r20s2 DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT r13s2zni0 FROM F".$kli_vxcf."_uctpriznanie_dmv";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
//str.1
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zahos DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zouli VARCHAR(35) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zocdm VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zopsc VARCHAR(10) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zomes VARCHAR(35) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zotel VARCHAR(20) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD zoema VARCHAR(30) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");

//2.strana
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD d2titz VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD dedic DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD likvi DECIMAL(10,2) DEFAULT 0 AFTER new2015 ";
$vysledek = mysql_query("$sql");

//vozidlo
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzdru VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzvyk DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD dnvnk VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD oslbd VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");

//2.strana
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD d3titz VARCHAR(15) NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD vzdrx DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD mesad1 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD mesad2 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD mesad3 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD mesad4 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD mesad5 DECIMAL(10,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpriznanie_dmv ADD r13s2zni0 DECIMAL(2,0) DEFAULT 0 AFTER new2015 ";
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

//pocet stran
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
//koniec pocet stran
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
$zahos = 1*$fir_riadok->zahos;
$zouli = $fir_riadok->zouli;
$zocdm = $fir_riadok->zocdm;
$zopsc = $fir_riadok->zopsc;
$zomes = $fir_riadok->zomes;
$zotel = $fir_riadok->zotel;
$zoema = $fir_riadok->zoema;
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
$dar3 = $fir_riadok->dar3;
$dar3sk=SkDatum($dar3);
$d3titz = $fir_riadok->d3titz;
$dedic = $fir_riadok->dedic;
$likvi = $fir_riadok->likvi;
                    }

if ( $strana == 3 )
{
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
$r12 = 1*$fir_riadok->r12;
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
$r49 = 1*$fir_riadok->r49;
$r12doniz = 1*$fir_riadok->r12doniz;
$vzvyk = $fir_riadok->vzvyk;
$dnvnk = $fir_riadok->dnvnk;
$oslbd = $fir_riadok->oslbd;
$r13s1zni25 = 1*$fir_riadok->r13s1zni25;
$r13s1zni20 = 1*$fir_riadok->r13s1zni20;
$r13s1zni15 = 1*$fir_riadok->r13s1zni15;
$r13s2zni25 = 1*$fir_riadok->r13s2zni25;
$r13s2zni20 = 1*$fir_riadok->r13s2zni20;
$r13s2zni15 = 1*$fir_riadok->r13s2zni15;
$r13s1zvy10 = 1*$fir_riadok->r13s1zvy10;
$r13s1zvy20 = 1*$fir_riadok->r13s1zvy20;
$r13s2zvy10 = 1*$fir_riadok->r13s2zvy10;
$r13s2zvy20 = 1*$fir_riadok->r13s2zvy20;
$r14s1 = $fir_riadok->r14s1;
$r14s2 = $fir_riadok->r14s2;
$r15s1zni50a = 1*$fir_riadok->r15s1zni50a;
$r15s1zni50b = 1*$fir_riadok->r15s1zni50b;
$r15s1zni50c = 1*$fir_riadok->r15s1zni50c;
$r16s1 = $fir_riadok->r16s1;
$r16s2 = $fir_riadok->r16s2;
$r17kombi = $fir_riadok->r17kombi;
$r18s1 = $fir_riadok->r18s1;
$r18s2 = $fir_riadok->r18s2;
$r19s1mes = $fir_riadok->r19s1mes;
$r19s2mes = $fir_riadok->r19s2mes;
$r19s1dni = $fir_riadok->r19s1dni;
$r19s2dni = $fir_riadok->r19s2dni;
$r20s1 = $fir_riadok->r20s1;
$r20s2 = $fir_riadok->r20s2;
$mesad1 = $fir_riadok->mesad1;
$mesad2 = $fir_riadok->mesad2;
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
if ( $dvhsk == '00.00.0000' ) 
{ 
$dvhsk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
 
$dvhsql=SqlDatum($dvhsk);
$sqlx = "UPDATE F$kli_vxcf"."_uctpriznanie_dmv SET dvh='$dvhsql' WHERE oc = 9999 ";
$vysledekx = mysql_query("$sqlx");
}
$pozn = $fir_riadok->pozn;
                    }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//udaje o FO z ufirdalsie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
$dtitz = "";
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dstat = "SK";
}
if ( $fir_uctt03 == 999 )
{
$fir_fnaz = "";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z motorov˝ch vozidiel</title>
<style type="text/css">
div.sadzby-area {
  position: absolute;
  background-color: #ffff90;
  z-index: 100;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* prefixy */
  padding-bottom: 5px;
}
div.sadzby-area-heading {
  clear: both;
  overflow: auto;
  height: 36px;
}
div.sadzby-area-heading > h1 {
  font-size: 14px;
  text-transform: uppercase;
  margin-top: 14px;
  margin-left: 15px;
}
div.sadzby-area-heading > img {
  width:18px;
  height:18px;
  margin-top: 8px;
  margin-right: 8px;
  opacity: 1; /* prefixy */
  cursor: pointer;
}
div.sadzby-area-heading > img:hover {
  opacity: 0.8; /* prefixy */
}
div.sadzby-area-body {
  clear: both;
}
div.sadzby-area-body > div {
  margin-left: 15px;
}
div.sadzby-section-heading {
  font-size:14px;
  height: 14px;
  padding: 8px 0 2px 0;
  font-weight: bold;
}
table.sadzby {
  background-color: #add8e6;
  margin-right: 15px;
}
table.sadzby caption {
font-size: 14px;
font-weight: ;
text-align: left;
height: 14px;
background-color:;
padding: 8px 0 6px 0;
}
tr.odd {
  background-color: #90ccde;
}
table.sadzby tr td > a {
  height: 24px;
  line-height: 24px;
  background-color: #fff;
  color: #000;
  text-align: right;
  font-weight: bold;
  display: block;
  border-right: 3px solid #add8e6;
  border-bottom: 3px solid #add8e6;
  padding-right: 4px;
}
table.sadzby tr td > a:hover {
  background-color: #eee;
}
table.sadzby th {
  font-size: 11px;
  font-weight: normal;
  padding-top: 3px;
  line-height: 15px;
}
table.sadzby td {
  font-size: 12px;
  text-align: center;
  line-height: 24px;
}
tr.zero-line > td {
  border: 0 !important;
  height: 0 !important;
}
div.wrap-vozidla {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.vozidla {
  width: 900px;
  margin: 16px auto;
  background-color: ;
}
table.vozidla caption {
  height: 20px;
  font-weight: bold;
  font-size: 14px;
  text-align: left;
}
a.btn-item-new {
  position: absolute;
  top: 35px;
  left: 150px;
  cursor: pointer;
  font-weight: bold;
  color: #fff;
  font-size: 10px;
  padding: 8px 12px 7px 12px;
  border-radius: 2px;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
  text-transform: uppercase;
  background-color: #1ccc66;
}
a.btn-item-new:hover {
  background-color: #1abd5f;
}

table.vozidla tr.body:hover {
  background-color: #f1faff;
}
table.vozidla th {
  height: 14px;
  vertical-align: middle;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.vozidla td {
  height: 28px;
  line-height: 28px;
  border-top: 2px solid #add8e6;
  font-size: 14px;
}
table.vozidla td img {
  width: 18px;
  height: 18px;
  vertical-align: text-bottom;
  cursor: pointer;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
.tooltip-body ul li {
  font-size: 13px;
  line-height: 20px;
}
.tooltip-body ul li strong {
  font-size: 14px;
}
</style>

<script type="text/javascript">
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
<?php if ( $zahos == 1 ) { ?> document.formv1.zahos.checked = 'checked'; <?php } ?>
   document.formv1.dar.value = '<?php echo "$darsk";?>';
   document.formv1.zoo.value = '<?php echo "$zoosk";?>';
   document.formv1.zod.value = '<?php echo "$zodsk";?>';
   document.formv1.ddp.value = '<?php echo "$ddpsk";?>';
   document.formv1.fod.value = '<?php echo "$fod";?>';
   document.formv1.zouli.value = '<?php echo "$zouli";?>';
   document.formv1.zocdm.value = '<?php echo "$zocdm";?>';
   document.formv1.zopsc.value = '<?php echo "$zopsc";?>';
   document.formv1.zomes.value = '<?php echo "$zomes";?>';
   document.formv1.zotel.value = '<?php echo "$zotel";?>';
   document.formv1.zoema.value = '<?php echo "$zoema";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<?php if ( $druh3 == 1 ) { ?>document.formv1.druh31.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 2 ) { ?>document.formv1.druh32.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 3 ) { ?>document.formv1.druh33.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 4 ) { ?>document.formv1.druh34.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 6 ) { ?>document.formv1.dedic.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 7 ) { ?>document.formv1.likvi.checked = 'true'; <?php } ?>
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
   document.formv1.d3tel.value = '<?php echo "$d3tel";?>';
   document.formv1.d3fax.value = '<?php echo "$d3fax";?>';
   document.formv1.xstat3.value = '<?php echo "$xstat3";?>';
   document.formv1.d3titz.value = '<?php echo "$d3titz";?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   urobVzdru();
   document.formv1.vzdru.value = '<?php echo "$vzdru";?>';
<?php                                        } ?>

<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
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
<?php if ( $zvra == 1 ) { ?> document.formv1.zvra.checked = "checked"; <?php } ?>
<?php if ( $post == 1 ) { ?> document.formv1.post.checked = "checked"; <?php } ?>
<?php if ( $ucet == 1 ) { ?> document.formv1.ucet.checked = "checked"; <?php } ?>
<?php                                        } ?>
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

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function TlacDMV()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self', 'width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes')
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Sadzby2015()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_sadzby.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
//bud alebo checkbox v ii.oddiele
  function klik31()
  {
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.dedic.checked = false;
   document.formv1.likvi.checked = false;
  }
  function klik32()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.dedic.checked = false;
   document.formv1.likvi.checked = false;
  }
  function klik33()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.dedic.checked = false;
   document.formv1.likvi.checked = false;
  }
  function klik34()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.dedic.checked = false;
   document.formv1.likvi.checked = false;
  }
  function klik36()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.likvi.checked = false;
  }
  function klik37()
  {
   document.formv1.druh31.checked = false;
   document.formv1.druh32.checked = false;
   document.formv1.druh33.checked = false;
   document.formv1.druh34.checked = false;
   document.formv1.dedic.checked = false;
  }

//bud alebo checkbox v riadku 13
  function zni25s1()
  {
   document.formv1.r13s1zni20.checked = false;
   document.formv1.r13s1zni15.checked = false;
   document.formv1.r13s1zvy10.checked = false;
   document.formv1.r13s1zvy20.checked = false;
  }
  function zni20s1()
  {
   document.formv1.r13s1zni25.checked = false;
   document.formv1.r13s1zni15.checked = false;
   document.formv1.r13s1zvy10.checked = false;
   document.formv1.r13s1zvy20.checked = false;
  }
  function zni15s1()
  {
   document.formv1.r13s1zni25.checked = false;
   document.formv1.r13s1zni20.checked = false;
   document.formv1.r13s1zvy10.checked = false;
   document.formv1.r13s1zvy20.checked = false;
  }
  function zni25s2()
  {
   document.formv1.r13s2zni20.checked = false;
   document.formv1.r13s2zni15.checked = false;
   document.formv1.r13s2zvy10.checked = false;
   document.formv1.r13s2zvy20.checked = false;
  }
  function zni20s2()
  {
   document.formv1.r13s2zni25.checked = false;
   document.formv1.r13s2zni15.checked = false;
   document.formv1.r13s2zvy10.checked = false;
   document.formv1.r13s2zvy20.checked = false;
  }
  function zni15s2()
  {
   document.formv1.r13s2zni25.checked = false;
   document.formv1.r13s2zni20.checked = false;
   document.formv1.r13s2zvy10.checked = false;
   document.formv1.r13s2zvy20.checked = false;
  }
  function zvy10s1()
  {
   document.formv1.r13s1zni25.checked = false;
   document.formv1.r13s1zni20.checked = false;
   document.formv1.r13s1zni15.checked = false;
   document.formv1.r13s1zvy20.checked = false;
  }
  function zvy20s1()
  {
   document.formv1.r13s1zni25.checked = false;
   document.formv1.r13s1zni20.checked = false;
   document.formv1.r13s1zni15.checked = false;
   document.formv1.r13s1zvy10.checked = false;
  }
  function zvy10s2()
  {
   document.formv1.r13s2zni25.checked = false;
   document.formv1.r13s2zni20.checked = false;
   document.formv1.r13s2zni15.checked = false;
   document.formv1.r13s2zvy20.checked = false;
  }
  function zvy20s2()
  {
   document.formv1.r13s2zni25.checked = false;
   document.formv1.r13s2zni20.checked = false;
   document.formv1.r13s2zni15.checked = false;
   document.formv1.r13s2zvy10.checked = false;
  }
//bud alebo checkbox v riadku 15
  function zni50a()
  {
   document.formv1.r15s1zni50b.checked = false;
   document.formv1.r15s1zni50c.checked = false;
  }
  function zni50b()
  {
   document.formv1.r15s1zni50a.checked = false;
   document.formv1.r15s1zni50c.checked = false;
  }
  function zni50c()
  {
   document.formv1.r15s1zni50a.checked = false;
   document.formv1.r15s1zni50b.checked = false;
  }
//bud alebo v checkbox v ako vratit
  function cezucet()
  {
   document.formv1.post.checked = false;
  }
  function cezpostu()
  {
   document.formv1.ucet.checked = false;
  }

  function vypocetMes()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&pocetdni=1', '_self');
  }
  function vypocitajDan()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&vypocitajdan=1', '_self');
  }
  function vypocitajPredpoDan()
  {
   window.open('priznanie_dmv<?php echo $rokdmv; ?>.php?copern=20&strana=4&predpoklad=1', '_self');
  }
  function dajSadzbu()
  {
   window.open('priznanie_dmv<?php echo $rokdmv; ?>.php?copern=20&cislo_cpl=<?php echo $cislo_cpl;?>&dajsadzbu=1', '_self');
  }
  function dajVsetky()
  {
   window.open('priznanie_dmv<?php echo $rokdmv; ?>.php?copern=2020&cislo_cpl=0&dajsadzbu=1&dajvsetky=1', '_self');
  }
  function VytvorOznamZanik(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?cislo_oc=<?php echo $cislo_oc;?>&copern=70&drupoh=1&page=1&cislo_cpl='+ cislo_cpl + '&ukoncenie=1',
 '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes' )
  }
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=346&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function ZmazVzd(cpl, cislo_spz)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=316&cislo_cpl='+ cislo_cpl + '&cislo_spz='+ cislo_spz + '&uprav=0', '_self' )
  }
  function NoveVzd()
  {
   window.open('../ucto/priznanie_dmv<?php echo $rokdmv; ?>.php?copern=336&uprav=0', '_self' )
  }
  function DMVdoXML()
  {
   window.open('../ucto/priznaniedmv_xml2015.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

<?php if ( $copern == 20 ) { ?>
  function VyberZhasni(sadzba)
  {
   document.formv1.r12.value=sadzba;
   document.getElementById('sadzby').className='hidden';
   document.formv1.r12.focus();
   document.formv1.r12.select();
  }
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
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();"
          title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="Sadzby2015();"
          title="RoËnÈ sadzby dane" class="btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();"
          title="PouËenie na vyplnenie" class="btn-form-tool">
<?php if ( $strana == 5 ) { ?>
    <img src="../obr/ikony/calculator_blue_icon.png" onclick="dajVsetky();"
      title="Pre VäETKY VOZIDL¡ doplniù sadzbu dane do r. 12 podæa druhu vozidla,
             +nastaviù r.13 checkbox,
             +vypoËÌtaù poËet mesiacov r.19,
             +vypoËÌtaù r.14,16,18,20,21" class="btn-form-tool">
<?php                     } ?>
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="DMVdoXML();"
          title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacDMV();"
          title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
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
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str1.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 1.strana" class="form-background">

<span class="text-echo" style="top:223px; left:61px;"><?php if ( $fir_uctt03 == 999 ) echo "x"; ?></span>
<span class="text-echo" style="top:223px; left:222px;"><?php if ( $fir_uctt03 != 999 ) echo "x"; ?></span>
<input type="checkbox" name="zahos" value="1" style="top:229px; left:401px;"/>
<span class="text-echo" style="top:293px; left:56px;"><?php echo $fir_fdic;?></span>
<input type="text" name="dar" id="dar" disabled="disabled" class="nofill" style="width:195px; top:342px; left:51px;"/>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:290px; left:423px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:315px; left:423px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:340px; left:423px;"/>
<!-- Za zdanovacie obdobie -->
<input type="text" name="zoo" id="zoo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:232px; left:696px;"/>
<input type="text" name="zod" id="zod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:274px; left:696px;"/>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:343px; left:696px;"/>

<!-- I. ODDIEL -->
<!-- Udaje o FO -->
<div class="input-echo" style="width:359px; top:455px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:244px; top:455px; left:432px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:112px; top:455px; left:696px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:68px; top:455px; left:828px;"><?php echo $dtitz; ?></div>
<input type="text" name="fod" id="fod" style="width:842px; top:510px; left:51px;"/>
<!-- Udaje o PO -->
<div class="input-echo" style="width:842px; top:589px; left:52px;"><?php echo $fir_fnaz; ?></div>
<!-- Adresa -->
<div class="input-echo" style="width:635px; top:702px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:175px; top:702px; left:718px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:107px; top:758px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:451px; top:758px; left:178px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:758px; left:649px;"><?php echo $dstat; ?></div>
<div class="input-echo" style="width:290px; top:812px; left:52px;"><?php echo $dtel; ?></div>
<div class="input-echo" style="width:521px; top:812px; left:361px;"><?php echo $fir_fem1; ?></div>
<!-- Adresa organizacnej zlozky -->
<input type="text" name="zouli" id="zouli" style="width:635px; top:890px; left:51px;"/>
<input type="text" name="zocdm" id="zocdm" style="width:175px; top:890px; left:718px;"/>
<input type="text" name="zopsc" id="zopsc" style="width:107px; top:946px; left:51px;"/>
<input type="text" name="zomes" id="zomes" style="width:451px; top:946px; left:178px;"/>
<input type="text" name="zotel" id="zotel" style="width:290px; top:1001px; left:51px;"/>
<input type="text" name="zoema" id="zoema" style="width:522px; top:1001px; left:370px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str2.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 2.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:406px;"><?php echo $fir_fdic;?></span>

<!-- II. ODDIEL -->
<input type="checkbox" name="druh31" id="druh31" value="1" onclick="klik31();"
       style="top:157px; left:68px;"/>
<input type="checkbox" name="dedic" id="dedic" value="1" onclick="klik36();"
       style="top:183px; left:68px;"/>
<input type="checkbox" name="druh33" id="druh33" value="1" onclick="klik33();"
       style="top:208px; left:68px;"/>
<input type="checkbox" name="likvi" id="likvi" value="1" onclick="klik37();"
       style="top:157px; left:470px;"/>
<input type="checkbox" name="druh32" id="druh32" value="1" onclick="klik32();"
       style="top:183px; left:470px;"/>
<input type="checkbox" name="druh34" id="druh34" value="1" onclick="klik34();"
       style="top:208px; left:470px;"/>
<input type="text" name="d3prie" id="d3prie" style="width:359px; top:262px; left:51px;"/>
<input type="text" name="d3meno" id="d3meno" style="width:244px; top:262px; left:430px;"/>
<input type="text" name="d3titl" id="d3titl" style="width:111px; top:262px; left:695px;"/>
<input type="text" name="d3titz" id="d3titz" style="width:68px; top:262px; left:827px;"/>
<input type="text" name="rdc3" id="rdc3" style="width:129px; top:319px; left:51px;"/>
<input type="text" name="rdk3" id="rdk3" style="width:84px; top:319px; left:212px;"/>
<input type="text" name="dar3" id="dar3" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:319px; left:327px;"/>
<input type="text" name="dic3" id="dic3" style="width:221px; top:319px; left:568px;"/>
<input type="text" name="naz3" id="naz3" style="width:842px; top:374px; left:51px;"/>
<input type="text" name="d3uli" id="d3uli" style="width:635px; top:451px; left:51px;"/>
<input type="text" name="d3cdm" id="d3cdm" style="width:175px; top:451px; left:718px;"/>
<input type="text" name="d3psc" id="d3psc" style="width:107px; top:505px; left:51px;"/>
<input type="text" name="d3mes" id="d3mes" style="width:451px; top:505px; left:178px;"/>
<input type="text" name="xstat3" id="xstat3" style="width:245px; top:505px; left:648px;"/>
<input type="text" name="d3tel" id="d3tel" style="width:290px; top:562px; left:51px;"/>
<input type="text" name="d3fax" id="d3fax" style="width:522px; top:562px; left:370px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str3.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 3.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:458px;"><?php echo $fir_fdic; ?></span>
<!-- III. ODDIEL -->
<!-- 01 a 02 riadok -->
<input type="text" name="da1" id="da1" value="<?php echo $da1sk; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:196px; top:162px; left:381px;"/>
<input type="text" name="datz" id="datz" value="<?php echo $datzsk; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:196px; top:203px; left:381px;"/>
<input type="text" name="datk" id="datk" value="<?php echo $datksk; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:196px; top:244px; left:381px;"/>
<!-- 03 a 04 riadok -->
<select size="1" name="vzkat" id="vzkat" onchange="urobVzdru();"
        style="width:38px; top:285px; left:435px;">
 <option value="L">L - motorovÈ vozidlo, s menej ako 4 kolesami a 4-kolky,</option>
 <option value="M">M - motorovÈ vozidlo najmenej so 4 kolesami urËenÈ na dopravu osÙb,</option>
 <option value="N">N - motorovÈ vozidlo najmenej so 4 kolesami urËenÈ na dopravu n·kladov,</option>
 <option value="O">O - prÌpojnÈ nemotorovÈ vozidlo.</option>
 <option value="0"></option>
</select>
<select size="1" name="vzdru" id="vzdru" style="width:64px; top:285px; left:518px;">
 <option value="L1"></option>
 <option value="L2"></option>
 <option value="L3"></option>
 <option value="L4"></option>
 <option value="L5"></option>
 <option value="L6"></option>
 <option value="L7"></option>
 <option value="M1"></option>
 <option value="M2"></option>
 <option value="M3"></option>
 <option value="N1"></option>
 <option value="N2"></option>
 <option value="N3"></option>
 <option value="O1"></option>
 <option value="O2"></option>
 <option value="O3"></option>
 <option value="O4"></option>
 <option value="0"></option>
</select>
<script type="text/javascript">
  function urobVzdru()
  {
   var mySelect = document.getElementById('vzdru');
   for (var i=0, len=mySelect.options.length; i<len; i++)
   {
    mySelect.removeChild( mySelect.options[0] );
   }

  if ( document.formv1.vzkat.value == "L" )
  {
   var opt1 = document.createElement('option');
   opt1.appendChild( document.createTextNode('L1e - mal˝ motocykel (2-kolesovÈ vozidlo), objem valcov neprevyöuje 50 cm3') );
   opt1.value = 'L1';
   mySelect.appendChild(opt1);

   var opt2 = document.createElement('option');
   opt2.appendChild( document.createTextNode('L2e - mal˝ motocykel (3-kolesovÈ vozidlo), objem valcov neprevyöuje 50 cm3') );
   opt2.value = 'L2';
   mySelect.appendChild(opt2);

   var opt3 = document.createElement('option');
   opt3.appendChild( document.createTextNode('L3e - motocykel, 2-kolesovÈ vozidlo bez postran. motor. vozÌka, s objemom valcov v‰ËöÌ ako 50 cm3') );
   opt3.value = 'L3';
   mySelect.appendChild(opt3);

   var opt4 = document.createElement('option');
   opt4.appendChild( document.createTextNode('L4e - motocykel, 2-kolesovÈ vozidlo s postran. motor. vozÌkom, s objemom valcov v‰ËöÌ ako 50 cm3') );
   opt4.value = 'L4';
   mySelect.appendChild(opt4);

   var opt5 = document.createElement('option');
   opt5.appendChild( document.createTextNode('L5e - motorov· 3-kolka, vozidlo s 3 kolesami, s objemom valcov v‰ËöÌ ako 50 cm3') );
   opt5.value = 'L5';
   mySelect.appendChild(opt5);

   var opt6 = document.createElement('option');
   opt6.appendChild( document.createTextNode('L6e - æahk· 4-kolka s objemom valcov neprevyöuje 50 cm3') );
   opt6.value = 'L6';
   mySelect.appendChild(opt6);

   var opt7 = document.createElement('option');
   opt7.appendChild( document.createTextNode('L7e - ötvorkolka in·') );
   opt7.value = 'L7';
   mySelect.appendChild(opt7);
  }

  if ( document.formv1.vzkat.value == "M" )
  {
   var opt1 = document.createElement('option');
   opt1.appendChild( document.createTextNode('M1 - najviac 8 sedadiel okrem sedadla pre vodiËa') );
   opt1.value = 'M1';
   mySelect.appendChild(opt1);

   var opt2 = document.createElement('option');
   opt2.appendChild( document.createTextNode('M2 - viac ako 8 sedadiel okrem sedadla pre vodiËa, s prÌpust. celkovou hmotn. neprevyö. 5000 kg') );
   opt2.value = 'M2';
   mySelect.appendChild(opt2);

   var opt3 = document.createElement('option');
   opt3.appendChild( document.createTextNode('M3 - viac ako 8 sedadiel okrem sedadla pre vodiËa, s prÌpust. celkovou hmotn. vyööou ako 5000 kg') );
   opt3.value = 'M3';
   mySelect.appendChild(opt3);
  }

  if ( document.formv1.vzkat.value == "N" )
  {
   var opt1 = document.createElement('option');
   opt1.appendChild( document.createTextNode('N1 - s prÌpustnou celkovou hmotnosùou neprevyö. 3500 kg') );
   opt1.value = 'N1';
   mySelect.appendChild(opt1);

   var opt2 = document.createElement('option');
   opt2.appendChild( document.createTextNode('N2 - s prÌpustnou celkovou hmotnosùou vyööou ako 3500 kg, ale neprevyö. 12000 kg') );
   opt2.value = 'N2';
   mySelect.appendChild(opt2);

   var opt3 = document.createElement('option');
   opt3.appendChild( document.createTextNode('N3 - s prÌpustnou celkovou hmotnosùou vyööou ako 12000 kg') );
   opt3.value = 'N3';
   mySelect.appendChild(opt3);
  }

  if ( document.formv1.vzkat.value == "O" )
  {
   var opt1 = document.createElement('option');
   opt1.appendChild( document.createTextNode('O1 - s prÌpustnou celkovou hmotnosùou neprevyöuj˙cou 750 kg') );
   opt1.value = 'O1';
   mySelect.appendChild(opt1);

   var opt2 = document.createElement('option');
   opt2.appendChild( document.createTextNode('O2 - s prÌpustnou celkovou hmotnosùou vyööou ako 750 kg, ale neprevyö. 3500 kg') );
   opt2.value = 'O2';
   mySelect.appendChild(opt2);

   var opt3 = document.createElement('option');
   opt3.appendChild( document.createTextNode('O3 - s prÌpustnou celkovou hmotnosùou vyööou ako 3500 kg, ale neprevyö. 10000 kg') );
   opt3.value = 'O3';
   mySelect.appendChild(opt3);

   var opt4 = document.createElement('option');
   opt4.appendChild( document.createTextNode('O4 - s prÌpustnou celkovou hmotnosùou presahuj˙cou 10000 kg') );
   opt4.value = 'O4';
   mySelect.appendChild(opt4);
  }
  }
</script>

<!-- 05 riadok -->
<input type="text" name="vzspz" id="vzspz" value="<?php echo $vzspz; ?>"
       style="width:218px; top:327px; left:359px;"/>
<!-- 06 a 07 riadok -->
<input type="text" name="vzobm" id="vzobm" value="<?php echo $vzobm; ?>"
       style="width:82px; top:370px; left:368px;"/>
<input type="text" name="vzvyk" id="vzvyk" value="<?php echo $vzvyk; ?>"
       style="width:82px; top:370px; left:495px;"/>
<!-- 08 a 09 riadok -->
<input type="text" name="vzchm" id="vzchm" value="<?php echo $vzchm; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:106px; top:412px; left:344px;"/>
<input type="text" name="vznpr" id="vznpr" value="<?php echo $vznpr; ?>"
       style="width:15px; top:412px; left:560px;"/>
<!-- 10 riadok -->
<select size="1" name="dnvnk" id="dnvnk" style="top:453px; left:554px; z-index:100;">
 <option value="A">A</option>
 <option value="B">B</option>
 <option value="C">C</option>
 <option value="D">D</option>
 <option value="E">E</option>
 <option value="0"></option>
</select>
<img src="../obr/ikony/info_blue_icon.png" title="Druhy daÚovnÌkov podæa ß 3 z·k."
     onclick="document.getElementById('tooltip').className='unhidden tooltip-left';"
     class="btn-row-tool" style="top:455px; left:600px;">
<!-- napoveda k riadku 10 -->
<div id="tooltip" class="hidden tooltip-left" style="width:350px; top:453px; left:608px;">
<div class="tooltip-heading">
 <h3 class="toleft">DaÚovnÌk podæa ß3 z·k. a pÌsm.</h3>
 <img src="../obr/ikony/xmark4_blue_x16.png" onclick="document.getElementById('tooltip').className='hidden';"
      title="Zavrieù" class="toright">
</div>
<div class="tooltip-body">
 <ul>
 <li><strong>a)</strong>je ako drûiteæ vozidla zapÌsan· v dokladoch vozidla,</li>
 <li><strong>b)</strong>m· v doklade ako drûiteæa zapÌsan˙ organizaËn˙ zloûku,</li>
 <li><strong>c)</strong>pouûÌva vozidlo, v dokladoch ktorÈho je ako drûiteæ vozidla zapÌsan· osoba, ktor· zomrela, bola zruöen· alebo zanikla,</li>
 <li><strong>d)</strong>pouûÌva vozidlo, v dokladoch ktorÈho je ako drûiteæ vozidla zapÌsan· osoba, ktor· nepouûÌva vozidlo na podnikanie,</li>
 <li><strong>e)</strong>je zamestn·vateæom a vypl·ca zamestnancovi cestovnÈ n·hrady za pouûitie vozidla, ktorÈ sa nepouûÌva na podnikanie.</li>
 </ul>
</div>
</div> <!-- #tooltip -->

<!-- 11 riadok -->
<select size="1" name="oslbd" id="oslbd" style="top:494px; left:554px;">
 <option value="B">B</option>
 <option value="C">C</option>
 <option value="D">D</option>
 <option value="0"></option>
</select>

<!-- 12 riadok -->
<?php $r12bez=1*$r12; ?>
<input type="text" name="r12" id="r12" value="<?php echo $r12bez; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:79px; top:538px; left:288px;"/>
 <img src="../obr/ikony/info_blue_icon.png" title="Sadzby dane z motorov˝ch vozidiel"
      onclick="document.getElementById('sadzby').className='unhidden sadzby-area';"
      class="btn-row-tool" style="top:538px; left:380px;">
<input type="checkbox" name="r12doniz" value="1" style="top:542px; left:424px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="dajSadzbu();"
      title="Doplniù sadzbu do r. 12 podæa druhu vozidla, +nastaviù r.13 checkbox,
             +vypoËÌtaù poËet mesiacov r.19, +vypoËÌtaù r.14,16,18,20,21"
      class="btn-row-tool" style="top:539px; left:596px;">

<!-- rocne sadzby dane -->
<div id="sadzby" class="sadzby-area hidden" style="top:572px; left:172px;">
<div class="sadzby-area-heading">
 <h1 class="toleft">Sadzby dane podæa druhov vozidiel</h1>
 <img src='../obr/ikony/xmark4_blue_x16.png' title="Zavrieù"
      onclick="document.getElementById('sadzby').className='hidden sadzby-area';"
      class="toright">
</div>
<div class="sadzby-area-body">
<div class="toleft">
 <table class="sadzby" style="width:200px;">
 <caption><strong>OsobnÈ vozidl·</strong></caption>
 <tr class="zero-line">
  <td style="width:30%;"></td><td style="width:30%;"></td><td style="width:40%;"></td>
 </tr>
 <tr>
  <th colspan="2">Objem motora (cm3)</th><th rowspan="2">Sadzba<br>dane (Ä)</th>
 </tr>
 <tr>
  <th>nad</th><th>do(vr·t.)</th>
 </tr>
 <tr class="odd">
  <td></td><td>150</td><td><a href="#" onclick="VyberZhasni(50);">50</a></td>
 </tr>
 <tr>
  <td>150</td><td>900</td><td><a href="#" onclick="VyberZhasni(62);">62</a></td>
 </tr>
 <tr class="odd">
  <td>900</td><td>1200</td><td><a href="#" onclick="VyberZhasni(80);">80</a></td>
 </tr>
 <tr>
  <td>1200</td><td>1500</td><td><a href="#" onclick="VyberZhasni(115);">115</a></td>
 </tr>
 <tr class="odd">
  <td>1500</td><td>2000</td><td><a href="#" onclick="VyberZhasni(148);">148</a></td>
 </tr>
 <tr>
  <td>2000</td><td>3000</td><td><a href="#" onclick="VyberZhasni(180);">180</a></td>
 </tr>
 <tr class="odd">
  <td>3000</td><td></td><td><a href="#" onclick="VyberZhasni(218);">218</a></td>
 </tr>
 </table>
<br>
 <table class="sadzby" style="width:200px;">
 <caption><strong>Vozidl· L, M a N na elektrinu</strong></caption>
 <tr class="zero-line">
  <td style="width:60%;"></td><td style="width:40%;"></td>
 </tr>
 <tr>
  <th>V˝kon motora<br>(kW)</th><th>Sadzba<br>dane (Ä)</th>
 </tr>
 <tr class="odd">
  <td>nad 0</td><td><a href="#" onclick="VyberZhasni(0);">0</a></td>
 </tr>
 </table>
</div>

<div class="toleft">
<div class="sadzby-section-heading">⁄ûitkovÈ vozidl· a autobusy</div>
<!-- 1,2 napravy -->
 <table class="toleft sadzby" style="width:160px;">
 <caption>1, 2 n·pravy</caption>
 <tr class="zero-line">
  <td style="width:30%;"></td><td style="width:30%;"></td><td style="width:40%;"></td>
 </tr>
 <tr>
  <th colspan="2">Hmotnosù (t)</th><th rowspan="2">Sadzba<br>dane (Ä)</th>
 </tr>
 <tr>
  <th>nad</th><th>do(vr·t.)</th>
 </tr>
 <tr class="odd">
  <td></td><td>1</td><td><a href="#" onclick="VyberZhasni(74);">74</a></td>
 </tr>
 <tr>
  <td>1</td><td>2</td><td><a href="#" onclick="VyberZhasni(133);">133</a></td>
 </tr>
 <tr class="odd">
  <td>2</td><td>4</td><td><a href="#" onclick="VyberZhasni(212);">212</a></td>
 </tr>
 <tr>
  <td>4</td><td>6</td><td><a href="#" onclick="VyberZhasni(312);">312</a></td>
 </tr>
 <tr class="odd">
  <td>6</td><td>8</td><td><a href="#" onclick="VyberZhasni(417);">417</a></td>
 </tr>
 <tr>
  <td>8</td><td>10</td><td><a href="#" onclick="VyberZhasni(518);">518</a></td>
 </tr>
 <tr class="odd">
  <td>10</td><td>12</td><td><a href="#" onclick="VyberZhasni(620);">620</a></td>
 </tr>
 <tr>
  <td>12</td><td>14</td><td><a href="#" onclick="VyberZhasni(777);">777</a></td>
 </tr>
 <tr class="odd">
  <td>14</td><td>16</td><td><a href="#" onclick="VyberZhasni(933);">933</a></td>
 </tr>
 <tr>
  <td>16</td><td>18</td><td><a href="#" onclick="VyberZhasni(1089);">1089</a></td>
 </tr>
 <tr class="odd">
  <td>18</td><td>20</td><td><a href="#" onclick="VyberZhasni(1252);">1252</a></td>
 </tr>
 <tr>
  <td>20</td><td>22</td><td><a href="#" onclick="VyberZhasni(1452);">1452</a></td>
 </tr>
 <tr class="odd">
  <td>22</td><td>24</td><td><a href="#" onclick="VyberZhasni(1660);">1660</a></td>
 </tr>
 <tr>
  <td>24</td><td>26</td><td><a href="#" onclick="VyberZhasni(1862);">1862</a></td>
 </tr>
 <tr class="odd">
  <td>26</td><td>28</td><td><a href="#" onclick="VyberZhasni(2075);">2075</a></td>
 </tr>
 <tr>
  <td>28</td><td>30</td><td><a href="#" onclick="VyberZhasni(2269);">2269</a></td>
 </tr>
 <tr class="odd">
  <td>30</td><td></td><td><a href="#" onclick="VyberZhasni(2480);">2480</a></td>
 </tr>
 </table>
<!-- 3 napravy -->
 <table class="toleft sadzby" style="width:160px;">
 <caption>3 n·pravy</caption>
 <tr class="zero-line">
  <td style="width:30%;"></td><td style="width:30%;"></td><td style="width:40%;"></td>
 </tr>
 <tr>
  <th colspan="2">Hmotnosù (t)</th><th rowspan="2">Sadzba<br>dane (Ä)</th>
 </tr>
 <tr>
  <th>nad</th><th>do(vr·t.)</th>
 </tr>
 <tr class="odd">
  <td></td><td>15</td><td><a href="#" onclick="VyberZhasni(566);">566</a></td>
 </tr>
 <tr>
  <td>15</td><td>17</td><td><a href="#" onclick="VyberZhasni(673);">673</a></td>
 </tr>
 <tr class="odd">
  <td>17</td><td>19</td><td><a href="#" onclick="VyberZhasni(828);">828</a></td>
 </tr>
 <tr>
  <td>19</td><td>21</td><td><a href="#" onclick="VyberZhasni(982);">982</a></td>
 </tr>
 <tr class="odd">
  <td>21</td><td>23</td><td><a href="#" onclick="VyberZhasni(1144);">1144</a></td>
 </tr>
 <tr>
  <td>23</td><td>25</td><td><a href="#" onclick="VyberZhasni(1295);">1295</a></td>
 </tr>
 <tr class="odd">
  <td>25</td><td>27</td><td><a href="#" onclick="VyberZhasni(1452);">1452</a></td>
 </tr>
 <tr>
  <td>27</td><td>29</td><td><a href="#" onclick="VyberZhasni(1599);">1599</a></td>
 </tr>
 <tr class="odd">
  <td>29</td><td>31</td><td><a href="#" onclick="VyberZhasni(1755);">1755</a></td>
 </tr>
 <tr>
  <td>31</td><td>33</td><td><a href="#" onclick="VyberZhasni(1964);">1964</a></td>
 </tr>
 <tr class="odd">
  <td>33</td><td>35</td><td><a href="#" onclick="VyberZhasni(2172);">2172</a></td>
 </tr>
 <tr>
  <td>35</td><td>37</td><td><a href="#" onclick="VyberZhasni(2375);">2375</a></td>
 </tr>
 <tr class="odd">
  <td>37</td><td>40</td><td><a href="#" onclick="VyberZhasni(2582);">2582</a></td>
 </tr>
 <tr>
  <td>40</td><td></td><td><a href="#" onclick="VyberZhasni(2790);">2790</a></td>
 </tr>
 </table>
<!-- 4 napravy -->
 <table class="toleft sadzby" style="width:160px;">
 <caption>4 a viac n·prav</caption>
 <tr class="zero-line">
  <td style="width:30%;"></td><td style="width:30%;"></td><td style="width:40%;"></td>
 </tr>
 <tr>
  <th colspan="2">Hmotnosù (t)</th><th rowspan="2">Sadzba<br>dane (Ä)</th>
 </tr>
 <tr>
  <th>nad</th><th>do(vr·t.)</th>
 </tr>
 <tr class="odd">
  <td></td><td>23</td><td><a href="#" onclick="VyberZhasni(721);">721</a></td>
 </tr>
 <tr>
  <td>23</td><td>25</td><td><a href="#" onclick="VyberZhasni(877);">877</a></td>
 </tr>
 <tr class="odd">
  <td>25</td><td>27</td><td><a href="#" onclick="VyberZhasni(1033);">1033</a></td>
 </tr>
 <tr>
  <td>27</td><td>29</td><td><a href="#" onclick="VyberZhasni(1189);">1189</a></td>
 </tr>
 <tr class="odd">
  <td>29</td><td>31</td><td><a href="#" onclick="VyberZhasni(1337);">1337</a></td>
 </tr>
 <tr>
  <td>31</td><td>33</td><td><a href="#" onclick="VyberZhasni(1548);">1548</a></td>
 </tr>
 <tr class="odd">
  <td>33</td><td>35</td><td><a href="#" onclick="VyberZhasni(1755);">1755</a></td>
 </tr>
 <tr>
  <td>35</td><td>37</td><td><a href="#" onclick="VyberZhasni(1968);">1968</a></td>
 </tr>
 <tr class="odd">
  <td>37</td><td>40</td><td><a href="#" onclick="VyberZhasni(2172);">2172</a></td>
 </tr>
 <tr>
  <td>40</td><td></td><td><a href="#" onclick="VyberZhasni(2375);">2375</a></td>
 </tr>
 </table>
</div>
</div> <!-- .sadzby-area-body -->
</div> <!-- .sadzby-area -->

<!-- 13 riadok -->
<!-- znizenie sadzby -->
<input type="checkbox" name="r13s1zni25" id="r13s1zni25" value="1" onclick="zni25s1();"
       style="top:613px; left:303px;"/>
<input type="checkbox" name="r13s1zni20" id="r13s1zni20" value="1" onclick="zni20s1();"
       style="top:613px; left:343px;"/>
<input type="checkbox" name="r13s1zni15" id="r13s1zni15" value="1" onclick="zni15s1();"
       style="top:613px; left:384px;"/>
<input type="checkbox" name="r13s2zni25" id="r13s2zni25" value="1" onclick="zni25s2();"
       style="top:613px; left:460px;"/>
<input type="checkbox" name="r13s2zni20" id="r13s2zni20" value="1" onclick="zni20s2();"
       style="top:613px; left:500px;"/>
<input type="checkbox" name="r13s2zni15" id="r13s2zni15" value="1" onclick="zni15s2();"
       style="top:613px; left:540px;"/>
<!-- zvysenie sadzby -->
<input type="checkbox" name="r13s1zvy10" id="r13s1zvy10" value="1" onclick="zvy10s1();"
       style="top:652px; left:343px;"/>
<input type="checkbox" name="r13s1zvy20" id="r13s1zvy20" value="1" onclick="zvy20s1();"
       style="top:652px; left:384px;"/>
<input type="checkbox" name="r13s2zvy10" id="r13s2zvy10" value="1" onclick="zvy10s2();"
       style="top:652px; left:500px;"/>
<input type="checkbox" name="r13s2zvy20" id="r13s2zvy20" value="1" onclick="zvy20s2();"
       style="top:652px; left:540px;"/>
 <img src="../obr/ikony/info_blue_icon.png" title="PoËet mesiacov od prvej evidencie vozidla"
      onclick="document.getElementById('tooltip-r13').className='unhidden tooltip-left';"
      class="btn-row-tool" style="top:642px; left:600px;">

<!-- napoveda k riadku 13 -->
<div id="tooltip-r13" class="hidden tooltip-left" style="width:300px; top:605px; left:595px;">
<div class="tooltip-heading">
 <h3 class="toleft">PoËet mesiacov od prvej evidencie vozidla</h3>
 <img src="../obr/ikony/xmark4_blue_x16.png" onclick="document.getElementById('tooltip-r13').className='hidden';"
      title="Zavrieù" class="toright">
</div>
<div class="tooltip-body">
 <ul>
 <li>v janu·ri: <strong><?php echo $mesad2; ?></strong></li>
 <li>v decembri: <strong><?php echo $mesad1; ?></strong></li>
 </ul>
</div>
</div>

<!-- 14 riadok -->
<input type="text" name="r14s1" id="r14s1" value="<?php echo $r14s1; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:681px; left:282px;"/>
<input type="text" name="r14s2" id="r14s2" value="<?php echo $r14s2; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:681px; left:439px;"/>
<!-- 15 riadok -->
<input type="checkbox" name="r15s1zni50a" id="r15s1zni50a" value="1" onclick="zni50a();"
       style="top:723px; left:278px;"/>
<input type="checkbox" name="r15s1zni50b" id="r15s1zni50b" value="1" onclick="zni50b();"
       style="top:752px; left:278px;"/>
<input type="checkbox" name="r15s1zni50c" id="r15s1zni50c" value="1" onclick="zni50c();"
       style="top:775px; left:278px;"/>

<!-- 16 a 17 riadok -->
<input type="text" name="r16s1" id="r16s1" value="<?php echo $r16s1; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:806px; left:282px;"/>
<input type="text" name="r16s2" id="r16s2" value="<?php echo $r16s2; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:806px; left:439px;"/>
<input type="checkbox" name="r17kombi" value="1" style="top:850px; left:278px;"/>

<!-- 18 riadok -->
<input type="text" name="r18s1" id="r18s1" value="<?php echo $r18s1; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:884px; left:282px;"/>
<input type="text" name="r18s2" id="r18s2" value="<?php echo $r18s2; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:884px; left:439px;"/>
<!-- 19 riadok -->
<input type="text" name="r19s1mes" id="r19s1mes" value="<?php echo $r19s1mes; ?>"
       style="width:35px; top:926px; left:326px;"/>
<input type="text" name="r19s2mes" id="r19s2mes" value="<?php echo $r19s2mes; ?>"
       style="width:35px; top:926px; left:485px;"/>
<input type="text" name="r19s1dni" id="r19s1dni" value="<?php echo $r19s1dni; ?>"
       style="width:57px; top:966px; left:326px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocetMes();"
      title="VypoËÌtaù poËet mesiacov r.19, poËas ktor˝ch vozidlo podliehalo dani,
             +vypoËÌtaù r.14,16,18,20,21"
      class="btn-row-tool" style="top:928px; left:596px;">
<input type="text" name="r19s2dni" id="r19s2dni" value="<?php echo $r19s2dni; ?>"
       style="width:57px; top:966px; left:485px;"/>
<!-- 20 a 21 riadok -->
<input type="text" name="r20s1" id="r20s1" value="<?php echo $r20s1; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:1019px; left:282px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocitajDan();"
     title="VypoËÌtaù r.14,16,18,20,21" class="btn-row-tool" style="top:1019px; left:596px;">
<input type="text" name="r20s2" id="r20s2" value="<?php echo $r20s2; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:137px; top:1019px; left:439px;"/>
<input type="text" name="r21" id="r21" value="<?php echo $r21; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1075px; left:425px;"/>
<!-- 22 - 24 riadky -->
<input type="text" name="r22" id="r22" value="<?php echo $r22; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1136px; left:425px;"/>
<input type="text" name="r23" id="r23" value="<?php echo $r23; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1179px; left:425px;"/>
<input type="text" name="r24" id="r24" value="<?php echo $r24; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:172px; top:1220px; left:404px;"/>
<!-- bonus -->
<label for="vzzn" class="added-label" style="top:1270px; left:220px;">ZnaËka vozidla</label>
<input type="text" name="vzzn" id="vzzn" value="<?php echo $vzzn; ?>"
       style="width:360px; top:1263px; left:320px;"/>
<script type="text/javascript">
  document.formv1.vzkat.value = '<?php echo "$vzkat"; ?>';
  document.formv1.vzdru.value = '<?php echo "$vzdru"; ?>';
  document.formv1.dnvnk.value = '<?php echo "$dnvnk"; ?>';
  document.formv1.oslbd.value = '<?php echo "$oslbd"; ?>';
<?php if ( $r12doniz == 1 ) { ?> document.formv1.r12doniz.checked = "checked"; <?php } ?>
<?php if ( $r13s1zni25 == 1 ) { ?> document.formv1.r13s1zni25.checked = "checked"; <?php } ?>
<?php if ( $r13s1zni20 == 1 ) { ?> document.formv1.r13s1zni20.checked = "checked"; <?php } ?>
<?php if ( $r13s1zni15 == 1 ) { ?> document.formv1.r13s1zni15.checked = "checked"; <?php } ?>
<?php if ( $r13s2zni25 == 1 ) { ?> document.formv1.r13s2zni25.checked = "checked"; <?php } ?>
<?php if ( $r13s2zni20 == 1 ) { ?> document.formv1.r13s2zni20.checked = "checked"; <?php } ?>
<?php if ( $r13s2zni15 == 1 ) { ?> document.formv1.r13s2zni15.checked = "checked"; <?php } ?>
<?php if ( $r13s1zvy10 == 1 ) { ?> document.formv1.r13s1zvy10.checked = "checked"; <?php } ?>
<?php if ( $r13s1zvy20 == 1 ) { ?> document.formv1.r13s1zvy20.checked = "checked"; <?php } ?>
<?php if ( $r13s2zvy10 == 1 ) { ?> document.formv1.r13s2zvy10.checked = "checked"; <?php } ?>
<?php if ( $r13s2zvy20 == 1 ) { ?> document.formv1.r13s2zvy20.checked = "checked"; <?php } ?>
<?php if ( $r15s1zni50a == 1 ) { ?> document.formv1.r15s1zni50a.checked = "checked"; <?php } ?>
<?php if ( $r15s1zni50b == 1 ) { ?> document.formv1.r15s1zni50b.checked = "checked"; <?php } ?>
<?php if ( $r15s1zni50c == 1 ) { ?> document.formv1.r15s1zni50c.checked = "checked"; <?php } ?>
<?php if ( $r17kombi == 1 ) { ?> document.formv1.r17kombi.checked = "checked"; <?php } ?>
</script>
<?php                     } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str4.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 4.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:405px;"><?php echo $fir_fdic;?></span>

<!-- IV. ODDIEL -->
<input type="text" name="r35" id="r35" style="width:82px; top:149px; left:593px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:188px; left:503px;"/>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:229px; left:503px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:269px; left:503px;"/>
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:309px; left:503px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:349px; left:503px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocitajPredpoDan();"
     title="VypoËÌtaù predpokladan˙ daÚ" class="btn-row-tool" style="top:350px; left:763px;">
<input type="text" name="r41" id="r41" style="width:82px; top:389px; left:593px;"/>

<!-- V. ODDIEL -->
<input type="text" name="r42" id="r42" style="width:82px; top:469px; left:593px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:508px; left:503px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:547px; left:483px;"/>
<input type="text" name="r45" id="r45" style="width:82px; top:588px; left:593px;"/>

<!-- VI. ODDIEL -->
<input type="checkbox" name="zvra" value="1" style="top:673px; left:59px;"/>
<input type="checkbox" name="post" value="1" onclick="cezpostu();" style="top:723px; left:111px;"/>
<input type="checkbox" name="ucet" value="1" onclick="cezucet();" style="top:723px; left:266px;"/>
<div class="input-echo" style="width:381px; top:732px; left:393px;"><?php echo $fir_fuc1; ?></div>
<div class="input-echo" style="width:81px; top:732px; left:807px;"><?php echo $fir_fnm1; ?></div>
<div class="input-echo" style="width:773px; top:774px; left:117px;"><?php echo $fir_fib1; ?></div>
<input type="text" name="dvp" id="dvp" onkeyup="CiarkaNaBodku(this);"
       style="width:196px; top:835px; left:116px;"/>

<!-- VII. ODDIEL -->
<textarea name="pozn" id="pozn" style="width:838px; height:221px; top:929px; left:53px;"><?php echo $pozn; ?></textarea>
<input type="text" name="dvh" id="dvh" onkeyup="CiarkaNaBodku(this);"
       style="width:196px; top:1216px; left:116px;"/>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) {
//VYPIS ZOZNAMU VOZIDIEL
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv WHERE oc = 1 ORDER BY vzspz ";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <a href="#" onclick="NoveVzd();" title="Pridaù vozidlo" class="btn-item-new" >+ Vozidlo</a>
<table class="vozidla">
<caption>Zoznam vozidiel</caption>
<tr class="zero-line">
 <td style="width:12%;"></td><td style="width:29%;"></td><td style="width:4%;"></td>
 <td style="width:12%;"></td><td style="width:10%;"></td><td style="width:12%;"></td>
 <td style="width:9%;"></td><td style="width:12%;"></td>
</tr>
<tr>
 <th rowspan="2">E»V</th>
 <th rowspan="2" align="left">ZnaËka</th>
 <th rowspan="2">Katg.</th>
 <th>Prv·</th>
 <th colspan="2">DaÚov· povinnosù</th>
 <th rowspan="2" align="right">DaÚ</th>
 <th rowspan="2">&nbsp;</th>
</tr>
<tr>
 <th style="padding-bottom:1px;">evidencia</th>
 <th style="padding-bottom:1px;">Vznik</th>
 <th style="padding-bottom:1px;">Z·nik</th>
</tr>
<?php
$i=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
 {
$rsluz=mysql_fetch_object($sluz);
$cisloi=$i+1;
?>
<tr class="body"> 
 <td align="left"><?php echo $cisloi.". ".$rsluz->vzspz; ?></td>
 <td><?php echo $rsluz->vzzn; ?></td>
 <td align="center"><?php echo $rsluz->vzkat; ?></td>
 <td align="center">
<?php if ( SkDatum($rsluz->da1) == '00.00.0000' ) { ?>
 <img src="../obr/pozor.png" style="width:14px; height:14px;"
      title="Pozor, nie je vyplnen˝ d·tum prvej evidencie. Program nevypoËÌta spr·vne v˝öku dane">
<?php                                             } ?>
<?php echo SkDatum($rsluz->da1); ?>
 </td>
 <td align="center"><?php echo SkDatum($rsluz->datz); ?></td>
 <td align="center">
  <img src="../obr/ikony/list_blue_icon.png" onclick="VytvorOznamZanik(<?php echo $rsluz->cpl; ?>);"
       title="Vytvoriù ozn·menie o z·niku daÚovej povinnosti">
    <?php echo SkDatum($rsluz->datk); ?>
 </td>
 <td align="right" style=""><?php echo $rsluz->r21; ?></td>
 <td align="center">
  <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl; ?>);"
       title="Upraviù">&nbsp;&nbsp;&nbsp;
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl; ?>, '<?php echo $rsluz->vzspz; ?>');"
       title="Vymazaù">
 </td>
</tr>
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
<?php if ( $strana != 5 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
  }
//koniec uprav
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

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kriziky FO,PO a zahr.osoba
$pdf->SetY(45);
$fo="";
$po="x";
$zo="";
if ( $fir_uctt03 == 999 ) { $fo="x"; $po=""; }
if ( $hlavicka->zahos == 1 ) $zo="x";
$pdf->SetX(13);
$pdf->Cell(3,5,"$fo","$rmc",0,"C");
$pdf->SetX(48);
$pdf->Cell(4,5,"$po","$rmc",0,"C");
$pdf->SetX(89);
$pdf->Cell(4,7,"$zo","$rmc",0,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->SetY(61);
$pdf->Cell(86,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$riadne","$rmc",1,"L");
$pdf->SetY(67);
$pdf->Cell(86,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$opravne","$rmc",1,"L");
$pdf->SetY(73);
$pdf->Cell(86,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$dodat","$rmc",0,"L");

//za zdanovacie obdobie od
$pdf->SetY(48);
$text=SkDatum($hlavicka->zoo);
if ( $text =='00.00.0000' ) $text="01.01.".$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");
//za zdanovacie obdobie do
$pdf->SetY(57);
$text=SkDatum($hlavicka->zod);
if ( $text =='00.00.0000' ) $text="31.12.".$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

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
$pdf->Cell(146,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,-18," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//datum narodenia
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//priezvisko,meno a titul FO
$pdf->Cell(190,20," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$dtitl","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$dtitz","$rmc",1,"L");

//dodatok obchodneho mena FO
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//obchodne meno PO
$pdf->Cell(190,12," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
//ulica
$pdf->Cell(190,19," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");
//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$dpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
//stat
$text=$dstat;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");
//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$dtel;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");
//email/fax
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(115,6,"$fir_fem1","$rmc",1,"L");

//Adresa zahranicnej osoby
$pdf->Cell(190,12," ","$rmc1",1,"L");
$text=$hlavicka->zouli;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
//cislo
$text=$hlavicka->zocdm;
$textxx="111122";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");
//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->zopsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
//obec
$text=$hlavicka->zomes;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",1,"C");
//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->zotel;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");
//email / fax
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(115,7,"$hlavicka->zoema;","$rmc",1,"L");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,0," ","$rmc1",1,"L");
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
$pdf->Cell(81,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//II.ODDIEL splnomocneny zastupca
//druh splnomocnenia
$krz1="";
$krz2="";
$krz3="";
$krz4="";
$krz5="";
$krz6="";
$krz7="";
if ( $hlavicka->druh3 == 1 ) { $krz1="x"; }
if ( $hlavicka->druh3 == 2 ) { $krz2="x"; }
if ( $hlavicka->druh3 == 3 ) { $krz3="x"; }
if ( $hlavicka->druh3 == 4 ) { $krz4="x"; }
if ( $hlavicka->druh3 == 5 ) { $krz5="x"; }
if ( $hlavicka->druh3 == 6 ) { $krz6="x"; }
if ( $hlavicka->druh3 == 7 ) { $krz7="x"; }
$pdf->SetY(31);
$pdf->SetX(16);
$pdf->Cell(3,3,"$krz1","$rmc",0,"C");
$pdf->SetX(104);
$pdf->Cell(4,3,"$krz7","$rmc",1,"C");
$pdf->SetY(36);
$pdf->SetX(16);
$pdf->Cell(3,4,"$krz6","$rmc",0,"C");
$pdf->SetX(104);
$pdf->Cell(4,4,"$krz2","$rmc",1,"C");
$pdf->SetY(42);
$pdf->SetX(16);
$pdf->Cell(3,4,"$krz3","$rmc",0,"C");
$pdf->SetX(104);
$pdf->Cell(4,4,"$krz4","$rmc",1,"C");

//priezvisko3
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
//titul3
$text=$hlavicka->d3titl;
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(26,7,"$hlavicka->d3titl","$rmc",0,"L");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,7,"$hlavicka->d3titz","$rmc",1,"L");
//rodne cislo3
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
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
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");
//obchodne meno3
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
//trvaly pobyt3 FO alebo sÌdlo3 PO
//ulica3
$pdf->Cell(190,11," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");
//psc3
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->d3psc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");
//cislo telefonu3
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->d3tel;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"R");$pdf->Cell(2,7," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");
//cislo faxu3
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,7,"$hlavicka->d3fax","$rmc",1,"L");
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
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,1," ","$rmc1",1,"L");
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
$pdf->Cell(92,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");
                }

//VOZIDLO I.
$pdf->SetY(32);
$stlpx=60;
if ( $jv == 1 ) { $stlpx=130; }

//01datum prvej evidencie
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
$pdf->Cell(24,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//02datum vzniku povinnosti
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->Cell(24,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//02datum zaniku povinnosti
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavickav->datk);
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
$pdf->Cell(24,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//03kategoria vozidla
$pdf->Cell(195,3," ","$rmc1",1,"L");
$vzkatg=$hlavickav->vzkat;
$pdf->SetX($stlpx);
$pdf->Cell(36,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$vzkatg","$rmc",0,"C");
//04druh vozidla
$text=$hlavickav->vzdru;
if ( $hlavickav->vzkat == 'L' ) $text=$hlavickav->vzdru.'e';
if ( $hlavickav->vzkat == '' ) $vzdruh="";
$text=sprintf("% 3s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(14,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//05evidencne cislo
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->Cell(19,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//06objem motora
$pdf->Cell(195,4," ","$rmc1",1,"L");
$text=$hlavickav->vzobm;
if ( $text == 0 ) { $text=""; }
$textxx="900";
$text=sprintf("% 4s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->SetX($stlpx);
$pdf->Cell(21,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

//07vykon motora(kW)
$text=$hlavickav->vzvyk;
if ( $text == 0 ) { $text=""; }
$text=sprintf("% 4s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//08hmotnost vozidla(t)
$pdf->Cell(195,4," ","$rmc1",1,"L");
$text=100*$hlavickav->vzchm;
if ( $text == 0 ) { $text=""; }
$textxx="1200";
$text=sprintf("% 4s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->SetX($stlpx);
$pdf->Cell(16,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

//09pocet naprav
$text=100*$hlavickav->vznpr;
if ( $text == 0 ) { $text=""; }
$textxx="2";
$t01=substr($text,0,1);
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",1,"C");

//10danovnik ß3
$pdf->Cell(195,3," ","$rmc1",1,"L");
$pdf->SetX($stlpx);
$pdf->Cell(64,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$hlavickav->dnvnk","$rmc",1,"C");

//11oslobodenie ß4ods.1
$pdf->Cell(195,3," ","$rmc1",1,"L");
$pdf->SetX($stlpx);
$pdf->Cell(64,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$hlavickav->oslbd","$rmc",1,"C");

//12sadzba dane
$pdf->Cell(195,4," ","$rmc1",1,"L");
$hodx=1*$hlavickav->r12;
if ( $hodx == 0 ) $hodx="";
$hodxxx="121114";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->SetX($stlpx);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t04","$rmc",0,"C");
//
$krizik=" ";
if ( $hlavickav->r12doniz == 1 ) $krizik="x";
$pdf->Cell(12,3," ","$rmc1",0,"R");$pdf->Cell(4,5,"$krizik","$rmc",1,"L");

//13znizenie sadzby
$pdf->Cell(195,12," ","$rmc1",1,"L");
$zni25s1="";
$zni20s1="";
$zni15s1="";
$zni25s2="";
$zni20s2="";
$zni15s2="";
if ( $hlavickav->r13s1zni25 == 1 ) $zni25s1="x";
if ( $hlavickav->r13s1zni20 == 1 ) $zni20s1="x";
if ( $hlavickav->r13s1zni15 == 1 ) $zni15s1="x";
if ( $hlavickav->r13s2zni25 == 1 ) $zni25s2="x";
if ( $hlavickav->r13s2zni20 == 1 ) $zni20s2="x";
if ( $hlavickav->r13s2zni15 == 1 ) $zni15s2="x";
$pdf->SetX($stlpx);
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$zni25s1","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,3,"$zni20s1","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,3,"$zni15s1","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,3,"$zni25s2","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$zni20s2","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$zni15s2","$rmc",1,"C");

//13zvysenie sadzby
$pdf->Cell(195,6," ","$rmc1",1,"L");
$zvy10s1="";
$zvy20s1="";
$zvy10s2="";
$zvy20s2="";
if ( $hlavickav->r13s1zvy10 == 1 ) $zvy10s1="x";
if ( $hlavickav->r13s1zvy20 == 1 ) $zvy20s1="x";
if ( $hlavickav->r13s2zvy10 == 1 ) $zvy10s2="x";
if ( $hlavickav->r13s2zvy20 == 1 ) $zvy20s2="x";
$pdf->SetX($stlpx);
$pdf->Cell(17,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$zvy10s1","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,3,"$zvy20s1","$rmc",0,"C");
$pdf->Cell(22,6," ","$rmc1",0,"R");$pdf->Cell(4,3,"$zvy10s2","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$zvy20s2","$rmc",1,"C");

//14sadzba 1 dane
$pdf->Cell(195,4," ","$rmc1",1,"L");
$hodx=100*$hlavickav->r14s1;
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
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
//14sadzba 2 dane
$hodx=100*$hlavickav->r14s2;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//15znizenie sadzby50%
$pdf->Cell(195,3," ","$rmc1",1,"L");
$r15s1zni50a="";
$r15s1zni50b="";
$r15s1zni50c="";
if ( $hlavickav->r15s1zni50a == 1 ) $r15s1zni50a="x";
if ( $hlavickav->r15s1zni50b == 1 ) $r15s1zni50b="x";
if ( $hlavickav->r15s1zni50c == 1 ) $r15s1zni50c="x";
$pdf->SetX($stlpx);$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(3,4,"$r15s1zni50a","$rmc",1,"C");
$pdf->Cell(195,3," ","$rmc1",1,"L");
$pdf->SetX($stlpx);$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$r15s1zni50b","$rmc",1,"C");
$pdf->Cell(195,2," ","$rmc1",1,"L");
$pdf->SetX($stlpx);$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(3,3,"$r15s1zni50c","$rmc",1,"C");

//r16
$pdf->Cell(195,4," ","$rmc1",1,"L");
$hodx=100*$hlavickav->r16s1;
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
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
//
$hodx=100*$hlavickav->r16s2;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r17
$pdf->Cell(195,4," ","$rmc1",1,"L");
$krizik="";
if ( $hlavickav->r17kombi == 1 ) $krizik="x";
$pdf->SetX($stlpx);$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(3,4,"$krizik","$rmc",1,"C");

//r18
$pdf->Cell(195,4," ","$rmc1",1,"L");
$hodx=100*$hlavickav->r18s1;
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
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
//
$hodx=100*$hlavickav->r18s2;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//19pocet mesiacov s1
$pdf->Cell(195,4," ","$rmc1",1,"L");
$text=$hlavickav->r19s1mes;
if ( $text == 0 ) { $text=""; }
$textxx="900";
$text=sprintf("% 2s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->SetX($stlpx);
$pdf->Cell(12,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
//19pocet mesiacov s2
$text=$hlavickav->r19s2mes;
if ( $text == 0 ) { $text=""; }
$textxx="900";
$text=sprintf("% 2s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(26,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//19pocet dni s1
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=$hlavickav->r19s1dni;
if ( $text == 0 ) { $text=""; }
$text=sprintf("% 3s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->SetX($stlpx);
$pdf->Cell(12,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
//19pocet dni s2
$text=$hlavickav->r19s2dni;
if ( $text == 0 ) { $text=""; }
$text=sprintf("% 3s",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(21,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",1,"C");

//r20
$pdf->Cell(195,6," ","$rmc1",1,"L");
$hodx=100*$hlavickav->r20s1;
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
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
//
$hodx=100*$hlavickav->r20s2;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r21
$pdf->Cell(195,7," ","$rmc1",1,"L");
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
$pdf->Cell(34,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r22
$pdf->Cell(195,8," ","$rmc1",1,"L");
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
$pdf->Cell(34,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r23
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(34,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//r24
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->Cell(29,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

if ( $jv == 0 ) {
//cislo strany hore v prilohe
$tlachod=$stranav;
$tlachodxx="111";
  $pole = explode(".", $tlachod);
  $tlachod_c = $pole[0];
  $tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 4s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->SetY(11);
$pdf->SetX(30);
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//pocet stran hore v prilohe
$tlachod=$hlavickav->pos;
$tlachodxx="222";
  $pole = explode(".", $tlachod);
  $tlachod_c = $pole[0];
  $tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 4s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->Cell(7,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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
if (File_Exists ('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str4.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,0," ","$rmc1",1,"L");
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
$pdf->Cell(81,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//r35
$pdf->Cell(195,12," ","$rmc1",1,"L");
$hodx=$hlavicka->r35;
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r36
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r37
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r38
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r39
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r40
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r41
$pdf->Cell(195,3," ","$rmc1",1,"L");
$hodx=$hlavicka->r41;
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r42
$pdf->Cell(195,13," ","$rmc1",1,"L");
$hodx=$hlavicka->r42;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="6";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//r43
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r44
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//r45
$pdf->Cell(195,3," ","$rmc1",1,"L");
$hodx=$hlavicka->r45;
if ( $hlavicka->druh != 3 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$hodxx="5";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//VI.ODDIEL
//ziadam o vratenie preplatku
$pdf->Cell(190,13," ","$rmc1",1,"L");
$krizik=" ";
if ( $hlavicka->zvra == 1 ) $krizik="x";
$pdf->Cell(6,3," ","$rmc1",0,"R");$pdf->Cell(3,3,"$krizik","$rmc",1,"C");

//postovou poukazkou
$pdf->Cell(190,8," ","$rmc1",1,"L");
$krizik=" ";
if ( $hlavicka->post == 1 ) $krizik="x";
if ( $hlavicka->zvra == 0 ) $krizik=" ";
$pdf->Cell(17,3," ","$rmc1",0,"R");$pdf->Cell(3,4,"$krizik","$rmc",0,"C");

//na ucet
$krizik=" ";
if ( $hlavicka->ucet == 1 ) $krizik="x";
if ( $hlavicka->zvra == 0 ) $krizik=" ";
$pdf->Cell(31,3," ","$rmc1",0,"R");$pdf->Cell(4,4,"$krizik","$rmc",1,"C");

//cislo uctu
$pdf->Cell(190,-2," ","$rmc1",1,"L");
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
$t17=substr($text,16,1);
$pdf->Cell(79,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"L");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"R");

//kod banky
$text=$fir_fnm1;
if ( $hlavicka->zvra == 0 ) $text=" ";
if ( $hlavicka->ucet == 0 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//iban
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text=$fir_fib1;
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
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$t32=substr($text,31,1);
$t33=substr($text,32,1);
$t34=substr($text,33,1);
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t34","$rmc",1,"C");

//datum ziadosti
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//VII. ODDIEL POZNAMKY
$pdf->Cell(190,16," ","$rmc1",1,"L");
$text=$hlavicka->pozn;
$poleosob = explode("\r\n", $text);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }

//datum vyhlasenia
$pdf->SetY(273);
$text=SKDatum($hlavicka->dvh);
if ( $text =='00.00.0000' )
{
$text=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
}
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");
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
if (File_Exists ('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za rok
$pdf->Cell(190,31," ","$rmc1",1,"L");
$pdf->Cell(149,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$kli_vrok","$rmc",1,"C");

//druh priznania
$pdf->Cell(190,17," ","$rmc1",1,"L");
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->Cell(12,4," ","$rmc1",0,"C");$pdf->Cell(5,5,"$riadne","$rmc",1,"C");
$pdf->Cell(12,4," ","$rmc1",0,"C");$pdf->Cell(5,5,"$opravne","$rmc",1,"C");
$pdf->Cell(12,4," ","$rmc1",0,"C");$pdf->Cell(5,5,"$dodat","$rmc",1,"C");

//priezvisko,meno alebo obchodne meno
$pdf->Cell(190,21," ","$rmc1",1,"L");
if ( $fir_uctt03 != 999 ) { $dprie = "$fir_fnaz"; }
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(163,6,"$dmeno $dprie","$rmc",1,"L");

//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
//if( $text == 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(69,7,"$fir_fdic","$rmc",0,"L");

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
$pdf->Cell(40,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(6,6,"$t02","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(6,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc1",0,"C");$pdf->Cell(6,6,"$t05","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6,"$t07","$rmc",0,"C");$pdf->Cell(5,6,"$t08","$rmc",1,"C");

//trvaly pobyt z FOB alebo sidlo z udajov o firme PO
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(163,6,"$duli $dcdm","$rmc",1,"L");

//psc a nazov obce
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(30,6,"$dpsc","$rmc",0,"L");
$pdf->Cell(23,6," ","$rmc1",0,"L");$pdf->Cell(110,6,"$dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(46,6,"$dstat","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,13," ","$rmc1",1,"L");
$r36=$hlavicka->r36; if ( $r36 == 0 ) $r36="";
$r38=$hlavicka->r38; if ( $r38 == 0 ) $r38="";
$r39=$hlavicka->r39; if ( $r39 == 0 ) $r39="";
$r35=$hlavicka->r35; if ( $r35 == 0 ) $r35="";
$r41=$hlavicka->r41; if ( $r41 == 0 ) $r41="";
$pdf->Cell(66,5," ","$rmc1",0,"L");$pdf->Cell(107,6,"$r36","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc1",0,"L");$pdf->Cell(107,6,"$r38","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc1",0,"L");$pdf->Cell(107,6,"$r39","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc1",0,"L");$pdf->Cell(107,6,"$r35","$rmc",1,"R");
$pdf->Cell(66,5," ","$rmc1",0,"L");$pdf->Cell(107,6,"$r41","$rmc",1,"R");

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


$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmv".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$fod = $fir_riadok->fod;


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

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_oznamenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_oznamenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//sidlo DU
$pdf->Cell(190,20," ","$rmc1",1,"L");
$pdf->Cell(10,5," ","$rmc1",0,"C");$pdf->Cell(92,5,"$fir_uctt01","$rmc",0,"L");

//dic
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
$pdf->Cell(19,4," ","$rmc1",0,"R");
$pdf->Cell(4,4,"$A","$rmc",0,"C");$pdf->Cell(6,4,"$B","$rmc",0,"C");$pdf->Cell(4,4,"$C","$rmc",0,"C");
$pdf->Cell(6,4,"$D","$rmc",0,"C");$pdf->Cell(5,4,"$E","$rmc",0,"C");$pdf->Cell(5,4,"$F","$rmc",0,"C");
$pdf->Cell(5,4,"$G","$rmc",0,"C");$pdf->Cell(5,4,"$H","$rmc",0,"C");$pdf->Cell(5,4,"$I","$rmc",0,"C");
$pdf->Cell(5,4,"$J","$rmc",1,"C");

//priezvisko, meno, titul FO
$pdf->Cell(190,111," ","$rmc1",1,"L");
$pdf->Cell(27,6," ","$rmc1",0,"L");$pdf->Cell(62,5,"$dprie","$rmc",0,"L");
$pdf->Cell(9,6," ","$rmc1",0,"L");$pdf->Cell(29,5,"$dmeno","$rmc",0,"L");
$pdf->Cell(32,6," ","$rmc1",0,"L");$pdf->Cell(7,5,"$dtitl","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"L");$pdf->Cell(8,5,"$dtitz","$rmc",1,"L");
//dodatok mena FO
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $fir_uctt03 != 999 ) { $fod = ""; }
$pdf->Cell(52,6," ","$rmc1",0,"L");$pdf->Cell(123,5,"$fod","$rmc",1,"L"); 

//obch.meno
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(54,6," ","$rmc1",0,"L");$pdf->Cell(121,5,"$fir_fnaz","$rmc",1,"L");

//ulica a cislo
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(85,4,"$duli","$rmc",0,"L");
$pole = explode("/", $dcdm);
$dcdmp=1*$pole[0];
$dcdmz=1*$pole[1];
if( $dcdmz == 0 ) { $dcdmz=""; }
$pdf->Cell(37,6," ","$rmc1",0,"L");$pdf->Cell(15,4,"$dcdmp","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"L");$pdf->Cell(17,4,"$dcdmz","$rmc",1,"L");

//psc a obec
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(30,5,"$dpsc","$rmc",0,"L");
$pdf->Cell(18,6," ","$rmc1",0,"L");$pdf->Cell(107,5,"$dmes","$rmc",1,"L");

//oznamujem DU
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(55,5," ","$rmc1",0,"C");$pdf->Cell(47,5,"$fir_uctt01","$rmc",1,"L");
$zanik=SkDatum($hlavicka->datk);
$pdf->Cell(30,5," ","$rmc1",0,"C");$pdf->Cell(15,4,"$zanik","$rmc",1,"L");

//SPZ vozidla
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(19,5," ","$rmc1",0,"C");$pdf->Cell(33,5,"$hlavicka->vzspz","$rmc",1,"L");

//mesto a den oznamenia
$pdf->SetY(244);
$pdf->Cell(15,5," ","$rmc1",0,"C");$pdf->Cell(46,5,"$fir_fmes","$rmc",0,"L");
$datksk=SkDatum($hlavicka->datk);
$pdf->Cell(7,5," ","$rmc1",0,"C");$pdf->Cell(20,5,"$datksk","$rmc",1,"L");

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
if ( $predpoklad == 1 AND $kli_vrok >= 2015 )
     {

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dmvx$kli_uzid WHERE oc = 1 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
echo "<table width='100%' >";
echo "<tr><td colspan='10'>PREDPOKLADAN¡ DA“ na bud˙ci rok<td/></tr>";
echo "<tr><td width='10%' >SPZ</td><td width='10%' >1.evidencia </td><td width='5%' >kat.</td><td width='7%' >druh/zniz. </td><td width='5%' >ccm</td>";
echo "<td width='5%' >n·pr. </td><td width='10%' >hmotnosù </td><td width='8%' >sadzba </td><td width='14%' >25/20/15/10/20 </td>";
echo "<td width='7%' >mesiacov </td><td width='10%' >daÚ</td>";
echo "</tr>";
if( $pol > 0 )
          {

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$r49=1*$hlavicka->r49;

echo "<tr><td>".$hlavicka->vzspz."</td><td>".SkDatum($hlavicka->da1)."</td><td>".$hlavicka->vzkat."</td><td>".$hlavicka->vzdru."/".$hlavicka->r12doniz."</td><td>";
echo $hlavicka->vzobm."</td><td>".$hlavicka->vznpr."</td><td>".$hlavicka->vzchm."</td><td>".$hlavicka->r12."</td>";
echo "<td>1.s ".$hlavicka->r13s1zni25.$hlavicka->r13s1zni20.$hlavicka->r13s1zni15.$hlavicka->r13s1zvy10.$hlavicka->r13s1zvy20."/ 2.s ";
echo $hlavicka->r13s2zni25.$hlavicka->r13s2zni20.$hlavicka->r13s2zni15.$hlavicka->r13s2zvy10.$hlavicka->r13s2zvy20."</td>";
echo "<td>".$hlavicka->r19s1mes."/".$hlavicka->r19s2mes."</td><td>".$hlavicka->r21."</td><tr />";

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