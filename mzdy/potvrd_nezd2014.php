<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 10 ) $strana=9999;
if ( $strana == 0 ) $strana=1;


//ak nie je nacitany namiesto uprav nacitaj
if ( $copern == 20 )
{
$poldt=0;
$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd WHERE oc = $cislo_oc ";
$sqldt = mysql_query("$sqldttt");
if ($sqldt) { $poldt = mysql_num_rows($sqldt); }
if ( $poldt == 0 ) { $copern=26; }
}

//prac.subor a subor vytvorenych potvrdeni
$sql = "SELECT vpdo2 FROM F$kli_vxcf"."_mzdpotvrdenienezd ";
$sqldok = mysql_query("$sql");
if (!$sqldok)
{
$sqlt = <<<mzdprc
(
   ume          DECIMAL(7,4) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   urcity       DECIMAL(1,0) DEFAULT 0,
   starobny     DECIMAL(1,0) DEFAULT 0,
   predcas      DECIMAL(1,0) DEFAULT 0,
   invalid      DECIMAL(1,0) DEFAULT 0,
   preod1       DATE,
   predo1       DATE,
   predv1       VARCHAR(60),
   predni1      INT(7) DEFAULT 0,
   preod2       DATE,
   predo2       DATE,
   predv2       VARCHAR(60),
   predni2      INT(7) DEFAULT 0,
   preod3       DATE,
   predo3       DATE,
   predv3       VARCHAR(60),
   predni3      INT(7) DEFAULT 0,
   vylod1       DATE,
   vyldo1       DATE,
   vyldv1       VARCHAR(60),
   vyldni1      INT(7) DEFAULT 0,
   vylod2       DATE,
   vyldo2       DATE,
   vyldv2       VARCHAR(60),
   vyldni2      INT(7) DEFAULT 0,
   vylod3       DATE,
   vyldo3       DATE,
   vyldv3       VARCHAR(60),
   vyldni3      INT(7) DEFAULT 0,
   vylod4       DATE,
   vyldo4       DATE,
   vyldv4       VARCHAR(60),
   vyldni4      INT(7) DEFAULT 0,
   vylod5       DATE,
   vyldo5       DATE,
   vyldv5       VARCHAR(60),
   vyldni5      INT(7) DEFAULT 0,
   vyl2od1       DATE,
   vyl2do1       DATE,
   vyl2dv1       VARCHAR(60),
   vyl2dni1      INT(7) DEFAULT 0,
   vyl2od2       DATE,
   vyl2do2       DATE,
   vyl2dv2       VARCHAR(60),
   vyl2dni2      INT(7) DEFAULT 0,
   vyl2od3       DATE,
   vyl2do3       DATE,
   vyl2dv3       VARCHAR(60),
   vyl2dni3      INT(7) DEFAULT 0,
   vyl2od4       DATE,
   vyl2do4       DATE,
   vyl2dv4       VARCHAR(60),
   vyl2dni4      INT(7) DEFAULT 0,
   vyl2od5       DATE,
   vyl2do5       DATE,
   vyl2dv5       VARCHAR(60),
   vyl2dni5      INT(7) DEFAULT 0,
   vyl3od1       DATE,
   vyl3do1       DATE,
   vyl3dv1       VARCHAR(60),
   vyl3dni1      INT(7) DEFAULT 0,
   vyl3od2       DATE,
   vyl3do2       DATE,
   vyl3dv2       VARCHAR(60),
   vyl3dni2      INT(7) DEFAULT 0,
   vyl3od3       DATE,
   vyl3do3       DATE,
   vyl3dv3       VARCHAR(60),
   vyl3dni3      INT(7) DEFAULT 0,
   vyl3od4       DATE,
   vyl3do4       DATE,
   vyl3dv4       VARCHAR(60),
   vyl3dni4      INT(7) DEFAULT 0,
   vyl3od5       DATE,
   vyl3do5       DATE,
   vyl3dv5       VARCHAR(60),
   vyl3dni5      INT(7) DEFAULT 0,
   vymz         DECIMAL(10,2) DEFAULT 0,
   vz01         DECIMAL(10,2) DEFAULT 0,
   vz02         DECIMAL(10,2) DEFAULT 0,
   vz03         DECIMAL(10,2) DEFAULT 0,
   vz04         DECIMAL(10,2) DEFAULT 0,
   vz05         DECIMAL(10,2) DEFAULT 0,
   vz06         DECIMAL(10,2) DEFAULT 0,
   vz07         DECIMAL(10,2) DEFAULT 0,
   vz08         DECIMAL(10,2) DEFAULT 0,
   vz09         DECIMAL(10,2) DEFAULT 0,
   vz10         DECIMAL(10,2) DEFAULT 0,
   vz11         DECIMAL(10,2) DEFAULT 0,
   vz12         DECIMAL(10,2) DEFAULT 0,
   vz13         DECIMAL(10,2) DEFAULT 0,
   vo1b01         DECIMAL(10,2) DEFAULT 0,
   vo1b02         DECIMAL(10,2) DEFAULT 0,
   vo1b03         DECIMAL(10,2) DEFAULT 0,
   vo1b04         DECIMAL(10,2) DEFAULT 0,
   vo1b05         DECIMAL(10,2) DEFAULT 0,
   vo1b06         DECIMAL(10,2) DEFAULT 0,
   vo1b07         DECIMAL(10,2) DEFAULT 0,
   vo1b08         DECIMAL(10,2) DEFAULT 0,
   vo1b09         DECIMAL(10,2) DEFAULT 0,
   vo1b10         DECIMAL(10,2) DEFAULT 0,
   vo1b11         DECIMAL(10,2) DEFAULT 0,
   vo1b12         DECIMAL(10,2) DEFAULT 0,
   vo1b13         DECIMAL(10,2) DEFAULT 0,
   vo2b01         DECIMAL(10,2) DEFAULT 0,
   vo2b02         DECIMAL(10,2) DEFAULT 0,
   vo2b03         DECIMAL(10,2) DEFAULT 0,
   vo2b04         DECIMAL(10,2) DEFAULT 0,
   vo2b05         DECIMAL(10,2) DEFAULT 0,
   vo2b06         DECIMAL(10,2) DEFAULT 0,
   vo2b07         DECIMAL(10,2) DEFAULT 0,
   vo2b08         DECIMAL(10,2) DEFAULT 0,
   vo2b09         DECIMAL(10,2) DEFAULT 0,
   vo2b10         DECIMAL(10,2) DEFAULT 0,
   vo2b11         DECIMAL(10,2) DEFAULT 0,
   vo2b12         DECIMAL(10,2) DEFAULT 0,
   vo2b13         DECIMAL(10,2) DEFAULT 0,
   vo3b01         DECIMAL(10,2) DEFAULT 0,
   vo3b02         DECIMAL(10,2) DEFAULT 0,
   vo3b03         DECIMAL(10,2) DEFAULT 0,
   vo3b04         DECIMAL(10,2) DEFAULT 0,
   vo3b05         DECIMAL(10,2) DEFAULT 0,
   vo3b06         DECIMAL(10,2) DEFAULT 0,
   vo3b07         DECIMAL(10,2) DEFAULT 0,
   vo3b08         DECIMAL(10,2) DEFAULT 0,
   vo3b09         DECIMAL(10,2) DEFAULT 0,
   vo3b10         DECIMAL(10,2) DEFAULT 0,
   vo3b11         DECIMAL(10,2) DEFAULT 0,
   vo3b12         DECIMAL(10,2) DEFAULT 0,
   vo3b13         DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0,
   por1         DECIMAL(1,0) DEFAULT 0,
   vzv1         DECIMAL(10,2) DEFAULT 0,
   ost1         DECIMAL(10,2) DEFAULT 0,
   exe1         VARCHAR(60),
   prs1         VARCHAR(60),
   por2         DECIMAL(1,0) DEFAULT 0,
   vzv2         DECIMAL(10,2) DEFAULT 0,
   ost2         DECIMAL(10,2) DEFAULT 0,
   exe2         VARCHAR(60),
   prs2         VARCHAR(60),
   por3         DECIMAL(1,0) DEFAULT 0,
   vzv3         DECIMAL(10,2) DEFAULT 0,
   ost3         DECIMAL(10,2) DEFAULT 0,
   exe3         VARCHAR(60),
   prs3         VARCHAR(60),
   datum        DATE,
   pozn         VARCHAR(80),
   str2         TEXT,
   invaldo      DECIMAL(4,0) DEFAULT 0,
   datod        DATE,
   vpdo2        DATE NOT NULL,
   vpdo1        DATE NOT NULL,
   vpod2        DATE NOT NULL,
   vpod1        DATE NOT NULL,
   pcdo2        DATE NOT NULL,
   pcdo1        DATE NOT NULL,
   pcod2        DATE NOT NULL,
   pcod1        DATE NOT NULL,
   dohvp      DECIMAL(4,0) DEFAULT 0,
   dohpc      DECIMAL(4,0) DEFAULT 0,
   neurcity   DECIMAL(4,0) DEFAULT 0,
   pracp      DECIMAL(4,0) DEFAULT 0,
   vysdch     DECIMAL(4,0) DEFAULT 0,
   invalvs    DECIMAL(4,0) DEFAULT 0,
   invalok    DECIMAL(4,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdpotvrdenienezd'.$sqlt;
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pozn VARCHAR(80) AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD str2 TEXT AFTER pozn";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dni5 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dv5 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3do5 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3od5 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dni4 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dv4 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3do4 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3od4 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dni3 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dv3 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3do3 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3od3 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dni2 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dv2 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3do2 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3od2 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dni1 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3dv1 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3do1 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl3od1 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dni5 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dv5 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2do5 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2od5 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dni4 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dv4 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2do4 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2od4 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dni3 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dv3 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2do3 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2od3 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dni2 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dv2 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2do2 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2od2 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dni1 INT(7) DEFAULT 0 AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2dv1 VARCHAR(60) AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2do1 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vyl2od1 DATE AFTER vyldni5";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD datod DATE AFTER str2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD invaldo DECIMAL(4,0) AFTER str2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD invalok DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD invalvs DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vysdch DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pracp DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD neurcity DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD dohpc DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD dohvp DECIMAL(4,0) AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pcod1 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pcod2 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pcdo1 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD pcdo2 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vpod1 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vpod2 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vpdo1 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD vpdo2 DATE NOT NULL AFTER datod";
$vysledek = mysql_query("$sql");
}
//zmeny pre rok 2014
$sql = "SELECT matod1 FROM F".$kli_vxcf."_mzdpotvrdenienezd ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD new2014 DECIMAL(2,0) DEFAULT 0 AFTER invalok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matdo3 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matod3 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matdo2 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matod2 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matdo1 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD matod1 DATE NOT NULL AFTER new2014";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT ppdo1 FROM F".$kli_vxcf."_mzdpotvrdenienezd ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD ppod1 DATE NOT NULL AFTER matdo3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienezd ADD ppdo1 DATE NOT NULL AFTER matdo3";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenia 

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");

//nacitanie vym.zakladov bezny rok a dva dozadu
if ( $copern == 27 )
{
$obdobie = 1*$_REQUEST['obdobie'];
$h_ycf = 1*$_REQUEST['firmaxy'];

$kli_vrokxx=$kli_vrok;
if ( $obdobie == 2 ) { $kli_vrokxx=$kli_vrok-1; }
if ( $obdobie == 3 ) { $kli_vrokxx=$kli_vrok-2; }

$databaza="";
if ( $kli_vrokxx == 2011 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrokxx == 2012 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrokxx == 2013 ) { if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; } }
if ( $kli_vrokxx == 2014 ) { if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; } }

//zober data z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT 0,oc,0,doch,0,0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,".
"0,0,0,'','',0,0,0,'','',0,0,0,'','',".
"'0000-00-00','','',0,'0000-00-00', ".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',0,0,0,0,0,0,0, ".
"0,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00' ".
" FROM ".$databaza."F$h_ycf"."_mzdkun".
" WHERE ".$databaza."F$h_ycf"."_mzdkun.oc = $cislo_oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z mzdzalsum
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT ume,oc,0,0,0,0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"zzam_pn,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,".
"0,0,0,'','',0,0,0,'','',0,0,0,'','',".
"'0000-00-00','','',0,'0000-00-00', ".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',0,0,0,0,0,0,0, ".
"0,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00' ".
" FROM ".$databaza."F$h_ycf"."_mzdzalsum".
" WHERE ".$databaza."F$h_ycf"."_mzdzalsum.oc = $cislo_oc";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;

//rozdel min a zaklad do mesiacov
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz01=vymz, vz13=vymz WHERE ume = 01.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz02=vymz, vz13=vymz WHERE ume = 02.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz03=vymz, vz13=vymz WHERE ume = 03.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz04=vymz, vz13=vymz WHERE ume = 04.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz05=vymz, vz13=vymz WHERE ume = 05.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz06=vymz, vz13=vymz WHERE ume = 06.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz07=vymz, vz13=vymz WHERE ume = 07.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz08=vymz, vz13=vymz WHERE ume = 08.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz09=vymz, vz13=vymz WHERE ume = 09.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz10=vymz, vz13=vymz WHERE ume = 10.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz11=vymz, vz13=vymz WHERE ume = 11.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." SET vz12=vymz, vz13=vymz WHERE ume = 12.".$kli_vrokxx." ";
$dsql = mysql_query("$dsqlt");

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT ume,oc,0,0,0,0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"0,SUM(vz01),SUM(vz02),SUM(vz03),SUM(vz04),SUM(vz05),SUM(vz06),SUM(vz07),SUM(vz08),SUM(vz09),SUM(vz10),SUM(vz11),SUM(vz12),SUM(vz13),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"9,".
"0,0,0,'','',0,0,0,'','',0,0,0,'','',".
"'0000-00-00','','',0,'0000-00-00', ".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',0,0,0,0,0,0,0, ".
"0,'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00' ".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvyplx$kli_uzid WHERE konx = 1";
$oznac = mysql_query("$sqtoz");


if ( $obdobie == 1 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" SET F$kli_vxcf"."_mzdpotvrdenienezd.vz01=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz01, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz02=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz02, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz03=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz03, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz04=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz04, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz05=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz05, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz06=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz06, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz07=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz07, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz08=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz08, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz09=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz09, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz10=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz10, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz11=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz11, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz12=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz12, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vz13=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz13 ".
" WHERE F$kli_vxcf"."_mzdpotvrdenienezd.oc = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.oc";
   }

if ( $obdobie == 2 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" SET F$kli_vxcf"."_mzdpotvrdenienezd.vo1b01=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz01, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b02=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz02, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b03=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz03, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b04=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz04, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b05=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz05, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b06=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz06, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b07=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz07, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b08=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz08, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b09=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz09, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b10=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz10, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b11=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz11, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b12=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz12, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo1b13=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz13 ".
" WHERE F$kli_vxcf"."_mzdpotvrdenienezd.oc = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.oc";
   }

if ( $obdobie == 3 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd,F$kli_vxcf"."_mzdprcvyplx$kli_uzid".
" SET F$kli_vxcf"."_mzdpotvrdenienezd.vo2b01=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz01, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b02=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz02, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b03=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz03, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b04=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz04, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b05=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz05, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b06=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz06, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b07=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz07, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b08=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz08, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b09=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz09, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b10=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz10, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b11=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz11, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b12=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz12, ".
" F$kli_vxcf"."_mzdpotvrdenienezd.vo2b13=F$kli_vxcf"."_mzdprcvyplx$kli_uzid.vz13 ".
" WHERE F$kli_vxcf"."_mzdpotvrdenienezd.oc = F$kli_vxcf"."_mzdprcvyplx$kli_uzid.oc";
   }
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$copern=20;
$strana=2;
}
//koniec nacitanie vym.zakladov 


//znovu nacitaj
if ( $copern == 26 )
     {
$sql = "DELETE FROM F".$kli_vxcf."_mzdpotvrdenienezd WHERE oc = '$cislo_oc' ";
$vysledek = mysql_query("$sql");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = '$cislo_oc' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dan=$riaddok->dan;
  $dav=$riaddok->dav;
  }

$sql = "INSERT INTO F".$kli_vxcf."_mzdpotvrdenienezd ( oc, ppod1, ppdo1 ) VALUES  ( '$cislo_oc', '$dan', '$dav' ) ";
$vysledek = mysql_query("$sql");
//echo $sql;
//exit;

//nem.davky,nepl.volno,absencia napocitaj do vyl3od,vyl3do,vyl3dv1 az 5

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$databaza=""; $databazamin=""; $databazamin2=""; 
if( $kli_vrok == 2014 ) 
{ 
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databazamin=$mysqldb2013."."; }
if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databazamin2=$mysqldb2012."."; }  
}
if( $kli_vrok == 2015 ) 
{ 
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databazamin=$mysqldb2014."."; }
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databazamin2=$mysqldb2013."."; } 
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND F$kli_vxcf"."_mzdzalvy.dp != '0000-00-00' AND F$kli_vxcf"."_mzdzalvy.dm < 899 AND F$kli_vxcf"."_mzdzalvy.dm > 500 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$h_ycf=1*$fir_allx11;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM ".$databazamin."F$h_ycf"."_mzdzalvy".
" WHERE oc = $cislo_oc AND dp != '0000-00-00' AND dm < 899 AND dm > 500 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $h_ycf > 0 ) {
$sqlfir = "SELECT * FROM ".$databazamin."F$h_ycf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$h_ycf2 = 1*$fir_riadok->allx11;
if ( $h_ycf2 > 0 ) 
  { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM ".$databazamin2."F$h_ycf2"."_mzdzalvy".
" WHERE oc = $cislo_oc AND dp != '0000-00-00' AND dm < 899 AND dm > 500 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  }

                 }
//koniec ak h_ycf > 0


$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzdprcvyplnxx$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE oc = $cislo_oc ORDER BY oc,dp";

$sqldt = mysql_query("$sqldttt");
$poldt = mysql_num_rows($sqldt);

$idt=0;
  while ($idt <= $poldt )
  {
  if (@$zaznam=mysql_data_seek($sqldt,$idt))
 {
$poloz=mysql_fetch_object($sqldt);

$dp_sk=SkDatum($poloz->dp);
$dk_sk=SkDatum($poloz->dk);

if ( $idt == 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vylod1='$poloz->dp', vyldo1='$poloz->dk', vyldv1='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vylod2='$poloz->dp', vyldo2='$poloz->dk', vyldv2='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 2 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vylod3='$poloz->dp', vyldo3='$poloz->dk', vyldv3='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 3 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vylod4='$poloz->dp', vyldo4='$poloz->dk', vyldv4='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 4 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vylod5='$poloz->dp', vyldo5='$poloz->dk', vyldv5='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 5 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl2od1='$poloz->dp', vyl2do1='$poloz->dk', vyl2dv1='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 6 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl2od2='$poloz->dp', vyl2do2='$poloz->dk', vyl2dv2='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 7 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl2od3='$poloz->dp', vyl2do3='$poloz->dk', vyl2dv3='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 8 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl2od4='$poloz->dp', vyl2do4='$poloz->dk', vyl2dv4='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 9 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl2od5='$poloz->dp', vyl2do5='$poloz->dk', vyl2dv5='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 10 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl3od1='$poloz->dp', vyl3do1='$poloz->dk', vyl3dv1='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 11 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl3od2='$poloz->dp', vyl3do2='$poloz->dk', vyl3dv2='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 12 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl3od3='$poloz->dp', vyl3do3='$poloz->dk', vyl3dv3='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 13 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl3od4='$poloz->dp', vyl3do4='$poloz->dk', vyl3dv4='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 14 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET vyl3od5='$poloz->dp', vyl3do5='$poloz->dk', vyl3dv5='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
 }
$idt = $idt + 1;
  }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

$copern=20;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
$pracp = strip_tags($_REQUEST['pracp']);
$urcity = strip_tags($_REQUEST['urcity']);
$neurcity = strip_tags($_REQUEST['neurcity']);

$dohpc = strip_tags($_REQUEST['dohpc']);
$pcod1 = strip_tags($_REQUEST['pcod1']);
$pcod1_sql=SqlDatum($pcod1);
$pcdo1 = strip_tags($_REQUEST['pcdo1']);
$pcdo1_sql=SqlDatum($pcdo1);
$pcod2 = strip_tags($_REQUEST['pcod2']);
$pcod2_sql=SqlDatum($pcod2);
$pcdo2 = strip_tags($_REQUEST['pcdo2']);
$pcdo2_sql=SqlDatum($pcdo2);

$dohvp = strip_tags($_REQUEST['dohvp']);
$vpod1 = strip_tags($_REQUEST['vpod1']);
$vpod1_sql=SqlDatum($vpod1);
$vpdo1 = strip_tags($_REQUEST['vpdo1']);
$vpdo1_sql=SqlDatum($vpdo1);
$vpod2 = strip_tags($_REQUEST['vpod2']);
$vpod2_sql=SqlDatum($vpod2);
$vpdo2 = strip_tags($_REQUEST['vpdo2']);
$vpdo2_sql=SqlDatum($vpdo2);

$datod = strip_tags($_REQUEST['datod']);
$datod_sql=SqlDatum($datod);
$starobny = strip_tags($_REQUEST['starobny']);
$predcas = strip_tags($_REQUEST['predcas']);
$invalid = strip_tags($_REQUEST['invalid']);
$invaldo = strip_tags($_REQUEST['invaldo']);
$invalok = strip_tags($_REQUEST['invalok']);
$invalvs = strip_tags($_REQUEST['invalvs']);
$vysdch = strip_tags($_REQUEST['vysdch']);

$preod1 = strip_tags($_REQUEST['preod1']);
$preod1_sql=SqlDatum($preod1);
$predo1 = strip_tags($_REQUEST['predo1']);
$predo1_sql=SqlDatum($predo1);
$predv1 = strip_tags($_REQUEST['predv1']);
$predni1 = strip_tags($_REQUEST['predni1']);
$preod2 = strip_tags($_REQUEST['preod2']);
$preod2_sql=SqlDatum($preod2);
$predo2 = strip_tags($_REQUEST['predo2']);
$predo2_sql=SqlDatum($predo2);
$predv2 = strip_tags($_REQUEST['predv2']);
$predni2 = strip_tags($_REQUEST['predni2']);
$preod3 = strip_tags($_REQUEST['preod3']);
$preod3_sql=SqlDatum($preod3);
$predo3 = strip_tags($_REQUEST['predo3']);
$predo3_sql=SqlDatum($predo3);
$predv3 = strip_tags($_REQUEST['predv3']);
$predni3 = strip_tags($_REQUEST['predni3']);

$vyldv1 = strip_tags($_REQUEST['vyldv1']);
$vylod1 = strip_tags($_REQUEST['vylod1']);
$vylod1_sql=SqlDatum($vylod1);
$vyldo1 = strip_tags($_REQUEST['vyldo1']);
$vyldo1_sql=SqlDatum($vyldo1);
$vyldni1 = strip_tags($_REQUEST['vyldni1']);

$vyldv2 = strip_tags($_REQUEST['vyldv2']);
$vylod2 = strip_tags($_REQUEST['vylod2']);
$vylod2_sql=SqlDatum($vylod2);
$vyldo2 = strip_tags($_REQUEST['vyldo2']);
$vyldo2_sql=SqlDatum($vyldo2);
$vyldni2 = strip_tags($_REQUEST['vyldni2']);

$vyldv3 = strip_tags($_REQUEST['vyldv3']);
$vylod3 = strip_tags($_REQUEST['vylod3']);
$vylod3_sql=SqlDatum($vylod3);
$vyldo3 = strip_tags($_REQUEST['vyldo3']);
$vyldo3_sql=SqlDatum($vyldo3);
$vyldni3 = strip_tags($_REQUEST['vyldni3']);

$vyldv4 = strip_tags($_REQUEST['vyldv4']);
$vylod4 = strip_tags($_REQUEST['vylod4']);
$vylod4_sql=SqlDatum($vylod4);
$vyldo4 = strip_tags($_REQUEST['vyldo4']);
$vyldo4_sql=SqlDatum($vyldo4);
$vyldni4 = strip_tags($_REQUEST['vyldni4']);

$ppod1 = strip_tags($_REQUEST['ppod1']);
$ppod1_sql=SqlDatum($ppod1);

$ppdo1 = strip_tags($_REQUEST['ppdo1']);
$ppdo1_sql=SqlDatum($ppdo1);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET ".
" pracp='$pracp', urcity='$urcity', neurcity='$neurcity', ppod1='$ppod1_sql', ppdo1='$ppdo1_sql', ".
" dohpc='$dohpc', pcod1='$pcod1_sql', pcdo1='$pcdo1_sql', pcod2='$pcod2_sql', pcdo2='$pcdo2_sql', ".  
" dohvp='$dohvp', vpod1='$vpod1_sql', vpdo1='$vpdo1_sql', vpod2='$vpod2_sql', vpdo2='$vpdo2_sql', datod='$datod_sql', ".
" starobny='$starobny', predcas='$predcas', invalid='$invalid', invaldo='$invaldo', invalok='$invalok', invalvs='$invalvs', vysdch='$vysdch', ".
" preod1='$preod1_sql', predo1='$predo1_sql', predv1='$predv1', ".
" preod2='$preod2_sql', predo2='$predo2_sql', predv2='$predv2', ".
" preod3='$preod3_sql', predo3='$predo3_sql', predv3='$predv3', ".
" vyldv1='$vyldv1', vylod1='$vylod1_sql', vyldo1='$vyldo1_sql', ".
" vyldv2='$vyldv2', vylod2='$vylod2_sql', vyldo2='$vyldo2_sql', ".
" vyldv3='$vyldv3', vylod3='$vylod3_sql', vyldo3='$vyldo3_sql', ".
" vylod4='$vylod4_sql', vyldo4='$vyldo4_sql', vyldv4='$vyldv4' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  
                    }

if ( $strana == 2 )
{
$matod1sql = SqlDatum($_REQUEST['matod1']);
$matdo1sql = SqlDatum($_REQUEST['matdo1']);
$matod2sql = SqlDatum($_REQUEST['matod2']);
$matdo2sql = SqlDatum($_REQUEST['matdo2']);
$matod3sql = SqlDatum($_REQUEST['matod3']);
$matdo3sql = SqlDatum($_REQUEST['matdo3']);

$vz01 = strip_tags($_REQUEST['vz01']);
$vz02 = strip_tags($_REQUEST['vz02']);
$vz03 = strip_tags($_REQUEST['vz03']);
$vz04 = strip_tags($_REQUEST['vz04']);
$vz05 = strip_tags($_REQUEST['vz05']);
$vz06 = strip_tags($_REQUEST['vz06']);
$vz07 = strip_tags($_REQUEST['vz07']);
$vz08 = strip_tags($_REQUEST['vz08']);
$vz09 = strip_tags($_REQUEST['vz09']);
$vz10 = strip_tags($_REQUEST['vz10']);
$vz11 = strip_tags($_REQUEST['vz11']);
$vz12 = strip_tags($_REQUEST['vz12']);
$vz13 = strip_tags($_REQUEST['vz13']);

$vo1b01 = strip_tags($_REQUEST['vo1b01']);
$vo1b02 = strip_tags($_REQUEST['vo1b02']);
$vo1b03 = strip_tags($_REQUEST['vo1b03']);
$vo1b04 = strip_tags($_REQUEST['vo1b04']);
$vo1b05 = strip_tags($_REQUEST['vo1b05']);
$vo1b06 = strip_tags($_REQUEST['vo1b06']);
$vo1b07 = strip_tags($_REQUEST['vo1b07']);
$vo1b08 = strip_tags($_REQUEST['vo1b08']);
$vo1b09 = strip_tags($_REQUEST['vo1b09']);
$vo1b10 = strip_tags($_REQUEST['vo1b10']);
$vo1b11 = strip_tags($_REQUEST['vo1b11']);
$vo1b12 = strip_tags($_REQUEST['vo1b12']);
$vo1b13 = strip_tags($_REQUEST['vo1b13']);

$vo2b01 = strip_tags($_REQUEST['vo2b01']);
$vo2b02 = strip_tags($_REQUEST['vo2b02']);
$vo2b03 = strip_tags($_REQUEST['vo2b03']);
$vo2b04 = strip_tags($_REQUEST['vo2b04']);
$vo2b05 = strip_tags($_REQUEST['vo2b05']);
$vo2b06 = strip_tags($_REQUEST['vo2b06']);
$vo2b07 = strip_tags($_REQUEST['vo2b07']);
$vo2b08 = strip_tags($_REQUEST['vo2b08']);
$vo2b09 = strip_tags($_REQUEST['vo2b09']);
$vo2b10 = strip_tags($_REQUEST['vo2b10']);
$vo2b11 = strip_tags($_REQUEST['vo2b11']);
$vo2b12 = strip_tags($_REQUEST['vo2b12']);
$vo2b13 = strip_tags($_REQUEST['vo2b13']);

$vo3b01 = strip_tags($_REQUEST['vo3b01']);
$vo3b02 = strip_tags($_REQUEST['vo3b02']);
$vo3b03 = strip_tags($_REQUEST['vo3b03']);
$vo3b04 = strip_tags($_REQUEST['vo3b04']);
$vo3b05 = strip_tags($_REQUEST['vo3b05']);
$vo3b06 = strip_tags($_REQUEST['vo3b06']);
$vo3b07 = strip_tags($_REQUEST['vo3b07']);
$vo3b08 = strip_tags($_REQUEST['vo3b08']);
$vo3b09 = strip_tags($_REQUEST['vo3b09']);
$vo3b10 = strip_tags($_REQUEST['vo3b10']);
$vo3b11 = strip_tags($_REQUEST['vo3b11']);
$vo3b12 = strip_tags($_REQUEST['vo3b12']);
$vo3b13 = strip_tags($_REQUEST['vo3b13']);

$por1 = strip_tags($_REQUEST['por1']);
$vzv1 = strip_tags($_REQUEST['vzv1']);
$ost1 = strip_tags($_REQUEST['ost1']);
$exe1 = strip_tags($_REQUEST['exe1']);
$prs1 = strip_tags($_REQUEST['prs1']);
$por2 = strip_tags($_REQUEST['por2']);
$vzv2 = strip_tags($_REQUEST['vzv2']);
$ost2 = strip_tags($_REQUEST['ost2']);
$exe2 = strip_tags($_REQUEST['exe2']);
$prs2 = strip_tags($_REQUEST['prs2']);
$por3 = strip_tags($_REQUEST['por3']);
$vzv3 = strip_tags($_REQUEST['vzv3']);
$ost3 = strip_tags($_REQUEST['ost3']);
$exe3 = strip_tags($_REQUEST['exe3']);
$prs3 = strip_tags($_REQUEST['prs3']);

$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET ".
" matod1='$matod1sql', matdo1='$matdo1sql', matod2='$matod2sql', matdo2='$matdo2sql', matod3='$matod3sql', matdo3='$matdo3sql', ".
" vz01='$vz01', vz02='$vz02', vz03='$vz03', vz04='$vz04', vz05='$vz05', vz06='$vz06', ".
" vz07='$vz07', vz08='$vz08', vz09='$vz09', vz10='$vz10', vz11='$vz11', vz12='$vz12', vz13='$vz13', ".
" vo1b01='$vo1b01', vo1b02='$vo1b02', vo1b03='$vo1b03', vo1b04='$vo1b04', vo1b05='$vo1b05', vo1b06='$vo1b06', ".
" vo1b07='$vo1b07', vo1b08='$vo1b08', vo1b09='$vo1b09', vo1b10='$vo1b10', vo1b11='$vo1b11', vo1b12='$vo1b12', vo1b13='$vo1b13', ".
" vo2b01='$vo2b01', vo2b02='$vo2b02', vo2b03='$vo2b03', vo2b04='$vo2b04', vo2b05='$vo2b05', vo2b06='$vo2b06', ".
" vo2b07='$vo2b07', vo2b08='$vo2b08', vo2b09='$vo2b09', vo2b10='$vo2b10', vo2b11='$vo2b11', vo2b12='$vo2b12', vo2b13='$vo2b13', ".
" vo3b01='$vo3b01', vo3b02='$vo3b02', vo3b03='$vo3b03', vo3b04='$vo3b04', vo3b05='$vo3b05', vo3b06='$vo3b06', ".
" vo3b07='$vo3b07', vo3b08='$vo3b08', vo3b09='$vo3b09', vo3b10='$vo3b10', vo3b11='$vo3b11', vo3b12='$vo3b12', vo3b13='$vo3b13', ".
" por1='$por1', vzv1='$vzv1', ost1='$ost1', exe1='$exe1', prs1='$prs1', ".
" por2='$por2', vzv2='$vzv2', ost2='$ost2', exe2='$exe2', prs2='$prs2', ".
" por3='$por3', vzv3='$vzv3', ost3='$ost3', exe3='$exe3', prs3='$prs3', ".
" datum='$datum_sql' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  
}

if ( $strana == 3 )
{
$vyldv5 = strip_tags($_REQUEST['vyldv5']);
$vylod5 = strip_tags($_REQUEST['vylod5']);
$vylod5_sql=SqlDatum($vylod5);
$vyldo5 = strip_tags($_REQUEST['vyldo5']);
$vyldo5_sql=SqlDatum($vyldo5);
$vyldni5 = strip_tags($_REQUEST['vyldni5']);

$vyl2dv1 = strip_tags($_REQUEST['vyl2dv1']);
$vyl2od1 = strip_tags($_REQUEST['vyl2od1']);
$vyl2od1_sql=SqlDatum($vyl2od1);
$vyl2do1 = strip_tags($_REQUEST['vyl2do1']);
$vyl2do1_sql=SqlDatum($vyl2do1);
$vyl2dni1 = strip_tags($_REQUEST['vyl2dni1']);

$vyl2dv2 = strip_tags($_REQUEST['vyl2dv2']);
$vyl2od2 = strip_tags($_REQUEST['vyl2od2']);
$vyl2od2_sql=SqlDatum($vyl2od2);
$vyl2do2 = strip_tags($_REQUEST['vyl2do2']);
$vyl2do2_sql=SqlDatum($vyl2do2);
$vyl2dni2 = strip_tags($_REQUEST['vyl2dni2']);

$vyl2dv3 = strip_tags($_REQUEST['vyl2dv3']);
$vyl2od3 = strip_tags($_REQUEST['vyl2od3']);
$vyl2od3_sql=SqlDatum($vyl2od3);
$vyl2do3 = strip_tags($_REQUEST['vyl2do3']);
$vyl2do3_sql=SqlDatum($vyl2do3);
$vyl2dni3 = strip_tags($_REQUEST['vyl2dni3']);

$vyl2dv4 = strip_tags($_REQUEST['vyl2dv4']);
$vyl2od4 = strip_tags($_REQUEST['vyl2od4']);
$vyl2od4_sql=SqlDatum($vyl2od4);
$vyl2do4 = strip_tags($_REQUEST['vyl2do4']);
$vyl2do4_sql=SqlDatum($vyl2do4);
$vyl2dni4 = strip_tags($_REQUEST['vyl2dni4']);

$vyl2dv5 = strip_tags($_REQUEST['vyl2dv5']);
$vyl2od5 = strip_tags($_REQUEST['vyl2od5']);
$vyl2od5_sql=SqlDatum($vyl2od5);
$vyl2do5 = strip_tags($_REQUEST['vyl2do5']);
$vyl2do5_sql=SqlDatum($vyl2do5);
$vyl2dni5 = strip_tags($_REQUEST['vyl2dni5']);

$vyl3dv1 = strip_tags($_REQUEST['vyl3dv1']);
$vyl3od1 = strip_tags($_REQUEST['vyl3od1']);
$vyl3od1_sql=SqlDatum($vyl3od1);
$vyl3do1 = strip_tags($_REQUEST['vyl3do1']);
$vyl3do1_sql=SqlDatum($vyl3do1);
$vyl3dni1 = strip_tags($_REQUEST['vyl3dni1']);

$vyl3dv2 = strip_tags($_REQUEST['vyl3dv2']);
$vyl3od2 = strip_tags($_REQUEST['vyl3od2']);
$vyl3od2_sql=SqlDatum($vyl3od2);
$vyl3do2 = strip_tags($_REQUEST['vyl3do2']);
$vyl3do2_sql=SqlDatum($vyl3do2);
$vyl3dni2 = strip_tags($_REQUEST['vyl3dni2']);

$vyl3dv3 = strip_tags($_REQUEST['vyl3dv3']);
$vyl3od3 = strip_tags($_REQUEST['vyl3od3']);
$vyl3od3_sql=SqlDatum($vyl3od3);
$vyl3do3 = strip_tags($_REQUEST['vyl3do3']);
$vyl3do3_sql=SqlDatum($vyl3do3);
$vyl3dni3 = strip_tags($_REQUEST['vyl3dni3']);

$vyl3dv4 = strip_tags($_REQUEST['vyl3dv4']);
$vyl3od4 = strip_tags($_REQUEST['vyl3od4']);
$vyl3od4_sql=SqlDatum($vyl3od4);
$vyl3do4 = strip_tags($_REQUEST['vyl3do4']);
$vyl3do4_sql=SqlDatum($vyl3do4);
$vyl3dni4 = strip_tags($_REQUEST['vyl3dni4']);

$vyl3dv5 = strip_tags($_REQUEST['vyl3dv5']);
$vyl3od5 = strip_tags($_REQUEST['vyl3od5']);
$vyl3od5_sql=SqlDatum($vyl3od5);
$vyl3do5 = strip_tags($_REQUEST['vyl3do5']);
$vyl3do5_sql=SqlDatum($vyl3do5);
$vyl3dni5 = strip_tags($_REQUEST['vyl3dni5']);

$str2 = strip_tags($_REQUEST['str2']);
//$pozn = strip_tags($_REQUEST['pozn']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd SET ".
" vylod5='$vylod5_sql', vyldo5='$vyldo5_sql', vyldv5='$vyldv5', ".
" vyl2od1='$vyl2od1_sql', vyl2do1='$vyl2do1_sql', vyl2dv1='$vyl2dv1', ".
" vyl2od2='$vyl2od2_sql', vyl2do2='$vyl2do2_sql', vyl2dv2='$vyl2dv2', ".
" vyl2od3='$vyl2od3_sql', vyl2do3='$vyl2do3_sql', vyl2dv3='$vyl2dv3', ".
" vyl2od4='$vyl2od4_sql', vyl2do4='$vyl2do4_sql', vyl2dv4='$vyl2dv4', ".
" vyl2od5='$vyl2od5_sql', vyl2do5='$vyl2do5_sql', vyl2dv5='$vyl2dv5', ".
" vyl3od1='$vyl3od1_sql', vyl3do1='$vyl3do1_sql', vyl3dv1='$vyl3dv1', ".
" vyl3od2='$vyl3od2_sql', vyl3do2='$vyl3do2_sql', vyl3dv2='$vyl3dv2', ".
" vyl3od3='$vyl3od3_sql', vyl3do3='$vyl3do3_sql', vyl3dv3='$vyl3dv3', ".
" vyl3od4='$vyl3od4_sql', vyl3do4='$vyl3do4_sql', vyl3dv4='$vyl3dv4', ".
" vyl3od5='$vyl3od5_sql', vyl3do5='$vyl3do5_sql', vyl3dv5='$vyl3dv5', ".
" str2='$str2' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt"); 
}

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


/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }
?>

<?php
//vypocet dni sucet vymeriavacich zakladov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienezd".
" SET vz13=vz01+vz02+vz03+vz04+vz05+vz06+vz07+vz08+vz09+vz10+vz11+vz12, ".
" predni1=TO_DAYS(predo1)-TO_DAYS(preod1)+1, predni2=TO_DAYS(predo2)-TO_DAYS(preod2)+1, predni3=TO_DAYS(predo3)-TO_DAYS(preod3)+1, ".
" vyldni1=TO_DAYS(vyldo1)-TO_DAYS(vylod1)+1, vyldni2=TO_DAYS(vyldo2)-TO_DAYS(vylod2)+1, vyldni3=TO_DAYS(vyldo3)-TO_DAYS(vylod3)+1, ".
" vyldni4=TO_DAYS(vyldo4)-TO_DAYS(vylod4)+1, vyldni5=TO_DAYS(vyldo5)-TO_DAYS(vylod5)+1, ".
" vyl2dni1=TO_DAYS(vyl2do1)-TO_DAYS(vyl2od1)+1, vyl2dni2=TO_DAYS(vyl2do2)-TO_DAYS(vyl2od2)+1, vyl2dni3=TO_DAYS(vyl2do3)-TO_DAYS(vyl2od3)+1, ".
" vyl2dni4=TO_DAYS(vyl2do4)-TO_DAYS(vyl2od4)+1, vyl2dni5=TO_DAYS(vyl2do5)-TO_DAYS(vyl2od5)+1, ".
" vyl3dni1=TO_DAYS(vyl3do1)-TO_DAYS(vyl3od1)+1, vyl3dni2=TO_DAYS(vyl3do2)-TO_DAYS(vyl3od2)+1, vyl3dni3=TO_DAYS(vyl3do3)-TO_DAYS(vyl3od3)+1, ".
" vyl3dni4=TO_DAYS(vyl3do4)-TO_DAYS(vyl3od4)+1, vyl3dni5=TO_DAYS(vyl3do5)-TO_DAYS(vyl3od5)+1, ".
" vo1b13=vo1b01+vo1b02+vo1b03+vo1b04+vo1b05+vo1b06+vo1b07+vo1b08+vo1b09+vo1b10+vo1b11+vo1b12, ".
" vo2b13=vo2b01+vo2b02+vo2b03+vo2b04+vo2b05+vo2b06+vo2b07+vo2b08+vo2b09+vo2b10+vo2b11+vo2b12, ".
" vo3b13=vo3b01+vo3b02+vo3b03+vo3b04+vo3b05+vo3b06+vo3b07+vo3b08+vo3b09+vo3b10+vo3b11+vo3b12 ".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
?>

<?php
//nacitaj udaje pre upravu
if ( $copern == 20 OR $copern == 10 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdpotvrdenienezd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdpotvrdenienezd.oc = $cislo_oc ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;

$nzamestnav = $fir_fnaz;
$icozamestnav = $fir_fico;
$fir_fadresa = $fir_fuli." ".$fir_fcdm.","."  ".$fir_fpsc." ".$fir_fmes;

$nzmc = $fir_riadok->titl." ".$fir_riadok->meno." ".$fir_riadok->prie;
$rczmc = $fir_riadok->rdc." / ".$fir_riadok->rdk;
$bzmc = $fir_riadok->zuli." ".$fir_riadok->zcdm.", ".$fir_riadok->zmes." ".$fir_riadok->zpsc;

$pracp = $fir_riadok->pracp;
$zacpomer = SkDatum($fir_riadok->dan); 
$konpomer = SkDatum($fir_riadok->dav);
$urcity = $fir_riadok->urcity;
$neurcity = $fir_riadok->neurcity;

$ppod1 = $fir_riadok->ppod1;
$ppod1_sk=SkDatum($ppod1);
$ppdo1 = $fir_riadok->ppdo1;
$ppdo1_sk=SkDatum($ppdo1);

$dohpc = $fir_riadok->dohpc;
$pcod1 = $fir_riadok->pcod1;
$pcod1_sk=SkDatum($pcod1);
$pcdo1 = $fir_riadok->pcdo1;
$pcdo1_sk=SkDatum($pcdo1);
$pcod2 = $fir_riadok->pcod2;
$pcod2_sk=SkDatum($pcod2);
$pcdo2 = $fir_riadok->pcdo2;
$pcdo2_sk=SkDatum($pcdo2);

$dohvp = $fir_riadok->dohvp;
$vpod1 = $fir_riadok->vpod1;
$vpod1_sk=SkDatum($vpod1);
$vpdo1 = $fir_riadok->vpdo1;
$vpdo1_sk=SkDatum($vpdo1);
$vpod2 = $fir_riadok->vpod2;
$vpod2_sk=SkDatum($vpod2);
$vpdo2 = $fir_riadok->vpdo2;
$vpdo2_sk=SkDatum($vpdo2);

$datod = $fir_riadok->datod;
$datod_sk=SkDatum($datod);
$starobny = $fir_riadok->starobny;
$predcas = $fir_riadok->predcas;
$invalid = $fir_riadok->invalid;
$invaldo = $fir_riadok->invaldo;
$invalok = $fir_riadok->invalok;
$invalvs = $fir_riadok->invalvs;
$vysdch = $fir_riadok->vysdch;

$predv1 = $fir_riadok->predv1;
$preod1 = $fir_riadok->preod1;
$preod1_sk=SkDatum($preod1);
$predo1 = $fir_riadok->predo1;
$predo1_sk=SkDatum($predo1);
$predni1 = $fir_riadok->predni1;
$predv2 = $fir_riadok->predv2;
$preod2 = $fir_riadok->preod2;
$preod2_sk=SkDatum($preod2);
$predo2 = $fir_riadok->predo2;
$predo2_sk=SkDatum($predo2);
$predni2 = $fir_riadok->predni2;
$predv3 = $fir_riadok->predv3;
$preod3 = $fir_riadok->preod3;
$preod3_sk=SkDatum($preod3);
$predo3 = $fir_riadok->predo3;
$predo3_sk=SkDatum($predo3);
$predni3 = $fir_riadok->predni3;

$vyldv1 = $fir_riadok->vyldv1;
$vylod1 = $fir_riadok->vylod1;
$vylod1_sk=SkDatum($vylod1);
$vyldo1 = $fir_riadok->vyldo1;
$vyldo1_sk=SkDatum($vyldo1);
$vyldni1 = $fir_riadok->vyldni1;

$vyldv2 = $fir_riadok->vyldv2;
$vylod2 = $fir_riadok->vylod2;
$vylod2_sk=SkDatum($vylod2);
$vyldo2 = $fir_riadok->vyldo2;
$vyldo2_sk=SkDatum($vyldo2);
$vyldni2 = $fir_riadok->vyldni2;

$vyldv3 = $fir_riadok->vyldv3;
$vylod3 = $fir_riadok->vylod3;
$vylod3_sk=SkDatum($vylod3);
$vyldo3 = $fir_riadok->vyldo3;
$vyldo3_sk=SkDatum($vyldo3);
$vyldni3 = $fir_riadok->vyldni3;

$vyldv4 = $fir_riadok->vyldv4;
$vylod4 = $fir_riadok->vylod4;
$vylod4_sk=SkDatum($vylod4);
$vyldo4 = $fir_riadok->vyldo4;
$vyldo4_sk=SkDatum($vyldo4);
$vyldni4 = $fir_riadok->vyldni4;

$matod1sk = SkDatum($fir_riadok->matod1);
$matdo1sk = SkDatum($fir_riadok->matdo1);
$matod2sk = SkDatum($fir_riadok->matod2);
$matdo2sk = SkDatum($fir_riadok->matdo2);
$matod3sk = SkDatum($fir_riadok->matod3);
$matdo3sk = SkDatum($fir_riadok->matdo3);

$matod1 = $fir_riadok->matod1;
$matdo1 = $fir_riadok->matdo1;
$matod2 = $fir_riadok->matod2;
$matdo2 = $fir_riadok->matdo2;
$matod3 = $fir_riadok->matod3;
$matdo3 = $fir_riadok->matdo3;

$vz01 = $fir_riadok->vz01;
$vz02 = $fir_riadok->vz02;
$vz03 = $fir_riadok->vz03;
$vz04 = $fir_riadok->vz04;
$vz05 = $fir_riadok->vz05;
$vz06 = $fir_riadok->vz06;
$vz07 = $fir_riadok->vz07;
$vz08 = $fir_riadok->vz08;
$vz09 = $fir_riadok->vz09;
$vz10 = $fir_riadok->vz10;
$vz11 = $fir_riadok->vz11;
$vz12 = $fir_riadok->vz12;
$vz13 = $fir_riadok->vz13;

$vo1b01 = $fir_riadok->vo1b01;
$vo1b02 = $fir_riadok->vo1b02;
$vo1b03 = $fir_riadok->vo1b03;
$vo1b04 = $fir_riadok->vo1b04;
$vo1b05 = $fir_riadok->vo1b05;
$vo1b06 = $fir_riadok->vo1b06;
$vo1b07 = $fir_riadok->vo1b07;
$vo1b08 = $fir_riadok->vo1b08;
$vo1b09 = $fir_riadok->vo1b09;
$vo1b10 = $fir_riadok->vo1b10;
$vo1b11 = $fir_riadok->vo1b11;
$vo1b12 = $fir_riadok->vo1b12;
$vo1b13 = $fir_riadok->vo1b13;

$vo2b01 = $fir_riadok->vo2b01;
$vo2b02 = $fir_riadok->vo2b02;
$vo2b03 = $fir_riadok->vo2b03;
$vo2b04 = $fir_riadok->vo2b04;
$vo2b05 = $fir_riadok->vo2b05;
$vo2b06 = $fir_riadok->vo2b06;
$vo2b07 = $fir_riadok->vo2b07;
$vo2b08 = $fir_riadok->vo2b08;
$vo2b09 = $fir_riadok->vo2b09;
$vo2b10 = $fir_riadok->vo2b10;
$vo2b11 = $fir_riadok->vo2b11;
$vo2b12 = $fir_riadok->vo2b12;
$vo2b13 = $fir_riadok->vo2b13;

$vo3b01 = $fir_riadok->vo3b01;
$vo3b02 = $fir_riadok->vo3b02;
$vo3b03 = $fir_riadok->vo3b03;
$vo3b04 = $fir_riadok->vo3b04;
$vo3b05 = $fir_riadok->vo3b05;
$vo3b06 = $fir_riadok->vo3b06;
$vo3b07 = $fir_riadok->vo3b07;
$vo3b08 = $fir_riadok->vo3b08;
$vo3b09 = $fir_riadok->vo3b09;
$vo3b10 = $fir_riadok->vo3b10;
$vo3b11 = $fir_riadok->vo3b11;
$vo3b12 = $fir_riadok->vo3b12;
$vo3b13 = $fir_riadok->vo3b13;

$por1 = $fir_riadok->por1;
$vzv1 = $fir_riadok->vzv1;
$ost1 = $fir_riadok->ost1;
$exe1 = $fir_riadok->exe1;
$prs1 = $fir_riadok->prs1;
$por2 = $fir_riadok->por2;
$vzv2 = $fir_riadok->vzv2;
$ost2 = $fir_riadok->ost2;
$exe2 = $fir_riadok->exe2;
$prs2 = $fir_riadok->prs2;
$por3 = $fir_riadok->por3;
$vzv3 = $fir_riadok->vzv3;
$ost3 = $fir_riadok->ost3;
$exe3 = $fir_riadok->exe3;
$prs3 = $fir_riadok->prs3;

$datum = $fir_riadok->datum;
$datum_sk=SkDatum($datum);

$vyldv5 = $fir_riadok->vyldv5;
$vylod5 = $fir_riadok->vylod5;
$vylod5_sk=SkDatum($vylod5);
$vyldo5 = $fir_riadok->vyldo5;
$vyldo5_sk=SkDatum($vyldo5);
$vyldni5 = $fir_riadok->vyldni5;

$vyl2dv1 = $fir_riadok->vyl2dv1;
$vyl2od1 = $fir_riadok->vyl2od1;
$vyl2od1_sk=SkDatum($vyl2od1);
$vyl2do1 = $fir_riadok->vyl2do1;
$vyl2do1_sk=SkDatum($vyl2do1);
$vyl2dni1 = $fir_riadok->vyl2dni1;

$vyl2dv2 = $fir_riadok->vyl2dv2;
$vyl2od2 = $fir_riadok->vyl2od2;
$vyl2od2_sk=SkDatum($vyl2od2);
$vyl2do2 = $fir_riadok->vyl2do2;
$vyl2do2_sk=SkDatum($vyl2do2);
$vyl2dni2 = $fir_riadok->vyl2dni2;

$vyl2dv3 = $fir_riadok->vyl2dv3;
$vyl2od3 = $fir_riadok->vyl2od3;
$vyl2od3_sk=SkDatum($vyl2od3);
$vyl2do3 = $fir_riadok->vyl2do3;
$vyl2do3_sk=SkDatum($vyl2do3);
$vyl2dni3 = $fir_riadok->vyl2dni3;

$vyl2dv4 = $fir_riadok->vyl2dv4;
$vyl2od4 = $fir_riadok->vyl2od4;
$vyl2od4_sk=SkDatum($vyl2od4);
$vyl2do4 = $fir_riadok->vyl2do4;
$vyl2do4_sk=SkDatum($vyl2do4);
$vyl2dni4 = $fir_riadok->vyl2dni4;

$vyl2dv5 = $fir_riadok->vyl2dv5;
$vyl2od5 = $fir_riadok->vyl2od5;
$vyl2od5_sk=SkDatum($vyl2od5);
$vyl2do5 = $fir_riadok->vyl2do5;
$vyl2do5_sk=SkDatum($vyl2do5);
$vyl2dni5 = $fir_riadok->vyl2dni5;

$vyl3dv1 = $fir_riadok->vyl3dv1;
$vyl3od1 = $fir_riadok->vyl3od1;
$vyl3od1_sk=SkDatum($vyl3od1);
$vyl3do1 = $fir_riadok->vyl3do1;
$vyl3do1_sk=SkDatum($vyl3do1);
$vyl3dni1 = $fir_riadok->vyl3dni1;

$vyl3dv2 = $fir_riadok->vyl3dv2;
$vyl3od2 = $fir_riadok->vyl3od2;
$vyl3od2_sk=SkDatum($vyl3od2);
$vyl3do2 = $fir_riadok->vyl3do2;
$vyl3do2_sk=SkDatum($vyl3do2);
$vyl3dni2 = $fir_riadok->vyl3dni2;

$vyl3dv3 = $fir_riadok->vyl3dv3;
$vyl3od3 = $fir_riadok->vyl3od3;
$vyl3od3_sk=SkDatum($vyl3od3);
$vyl3do3 = $fir_riadok->vyl3do3;
$vyl3do3_sk=SkDatum($vyl3do3);
$vyl3dni3 = $fir_riadok->vyl3dni3;

$vyl3dv4 = $fir_riadok->vyl3dv4;
$vyl3od4 = $fir_riadok->vyl3od4;
$vyl3od4_sk=SkDatum($vyl3od4);
$vyl3do4 = $fir_riadok->vyl3do4;
$vyl3do4_sk=SkDatum($vyl3do4);
$vyl3dni4 = $fir_riadok->vyl3dni4;

$vyl3dv5 = $fir_riadok->vyl3dv5;
$vyl3od5 = $fir_riadok->vyl3od5;
$vyl3od5_sk=SkDatum($vyl3od5);
$vyl3do5 = $fir_riadok->vyl3do5;
$vyl3do5_sk=SkDatum($vyl3do5);
$vyl3dni5 = $fir_riadok->vyl3dni5;

//$pozn = $fir_riadok->pozn;
$str2 = $fir_riadok->str2;

mysql_free_result($fir_vysledok);
     }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=1*$riaddok->cicz;
  }
//koniec nacitania


$sqlt = "DROP TABLE prcdatum$kli_uzid ";
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   matod1          DATE,
   matdo1          DATE,
   matdni1         DECIMAL(4,0) DEFAULT 0,
   matod2          DATE,
   matdo2          DATE,
   matdni2         DECIMAL(4,0) DEFAULT 0,
   matod3          DATE,
   matdo3          DATE,
   matdni3         DECIMAL(4,0) DEFAULT 0,
   fic          INT
);
prcdatum;

$vsql = "CREATE TABLE prcdatum".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO prcdatum$kli_uzid (matod1,matdo1,matdni1,matod2,matdo2,matdni2,matod3,matdo3,matdni3) ".
" VALUES ( '$matod1', '$matdo1', 0,  '$matod2', '$matdo2', 0,  '$matod3', '$matdo3', 0  ) ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE prcdatum$kli_uzid SET ".
" matdni1=TO_DAYS(matdo1)-TO_DAYS(matod1)+1, ".
" matdni2=TO_DAYS(matdo2)-TO_DAYS(matod2)+1, ".
" matdni3=TO_DAYS(matdo3)-TO_DAYS(matod3)+1  ";
$vytvor = mysql_query("$vsql");

$sqldok = mysql_query("SELECT * FROM prcdatum$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $matdni1=1*$riaddok->matdni1;
  $matdni2=1*$riaddok->matdni2;
  $matdni3=1*$riaddok->matdni3;
  }
//koniec vypocet poctu kalendarnych dni

$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if ( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }

if ( $next_oc > $maxoc ) $next_oc=$maxoc;
$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $next_oc=$next_oc+1;
if ( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;

if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
}
//koniec novy=0
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Potvrdenie na d·vku v nezamestnanosti</title>
<style type="text/css">
form input[type=text] {
  position: absolute;
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
img.btn-row-tool {
  width: 25px;
  height: 20px;
}
table.vylucene {
  position: absolute;
  top: 70px;
  left: 95px;
  width: 760px;
}
table.vylucene caption {
  margin-bottom: 10px;
  margin-left: -15px;
  text-align: left;
  font-size: 12px;
  font-weight: bold;
}
table.vylucene th {
  height: 18px;
  line-height: 18px;
  font-size: 11px;
  font-weight: normal;
}
table.vylucene td {
  height: 28px;
  line-height: 28px;
  font-size: 14px;
}
div.info-simple {
  position: absolute;
  bottom: 26px;
  left: 49px;
  font-size:14px;
}
div.info-dopl {
  position: absolute;
  top: 450px;
  left: 95px;
}
div.info-dopl > h3 {
  margin-bottom: 10px;
  margin-left: -15px;
  font-weight: bold;
  font-size: 12px;
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
<?php if ( $pracp == 1 ) { ?> document.formv1.pracp.checked = "checked"; <?php } ?>
<?php if ( $urcity == 1 ) { ?> document.formv1.urcity.checked = "checked"; <?php } ?>
<?php if ( $neurcity == 1 ) { ?> document.formv1.neurcity.checked = "checked"; <?php } ?>
<?php if ( $dohpc == 1 ) { ?> document.formv1.dohpc.checked = "checked"; <?php } ?>
<?php if ( $dohvp == 1 ) { ?> document.formv1.dohvp.checked = "checked"; <?php } ?>
<?php if ( $starobny == 1 ) { ?> document.formv1.starobny.checked = "checked"; <?php } ?>
<?php if ( $invalok == 1 ) { ?> document.formv1.invalok.checked = "checked"; <?php } ?>
<?php if ( $predcas == 1 ) { ?> document.formv1.predcas.checked = "checked"; <?php } ?>
<?php if ( $invalvs == 1 ) { ?> document.formv1.invalvs.checked = "checked"; <?php } ?>
<?php if ( $invalid == 1 ) { ?> document.formv1.invalid.checked = "checked"; <?php } ?>
<?php if ( $vysdch == 1 ) { ?> document.formv1.vysdch.checked = "checked"; <?php } ?>
<?php if ( $invaldo == 1 ) { ?> document.formv1.invaldo.checked = "checked"; <?php } ?>
   document.formv1.ppod1.value = '<?php echo "$ppod1_sk";?>';
   document.formv1.ppdo1.value = '<?php echo "$ppdo1_sk";?>';
   document.formv1.pcod1.value = '<?php echo "$pcod1_sk";?>';
   document.formv1.pcdo1.value = '<?php echo "$pcdo1_sk";?>';
   document.formv1.pcod2.value = '<?php echo "$pcod2_sk";?>';
   document.formv1.pcdo2.value = '<?php echo "$pcdo2_sk";?>';
   document.formv1.vpod1.value = '<?php echo "$vpod1_sk";?>';
   document.formv1.vpdo1.value = '<?php echo "$vpdo1_sk";?>';
   document.formv1.vpod2.value = '<?php echo "$vpod2_sk";?>';
   document.formv1.vpdo2.value = '<?php echo "$vpdo2_sk";?>';
   document.formv1.datod.value = '<?php echo "$datod_sk";?>';
   document.formv1.predv1.value = '<?php echo "$predv1";?>';
   document.formv1.preod1.value = '<?php echo "$preod1_sk";?>';
   document.formv1.predo1.value = '<?php echo "$predo1_sk";?>';
   document.formv1.predv2.value = '<?php echo "$predv2";?>';
   document.formv1.preod2.value = '<?php echo "$preod2_sk";?>';
   document.formv1.predo2.value = '<?php echo "$predo2_sk";?>';
   document.formv1.predv3.value = '<?php echo "$predv3";?>';
   document.formv1.preod3.value = '<?php echo "$preod3_sk";?>';
   document.formv1.predo3.value = '<?php echo "$predo3_sk";?>';
   document.formv1.vyldv1.value = '<?php echo "$vyldv1";?>';
   document.formv1.vylod1.value = '<?php echo "$vylod1_sk";?>';
   document.formv1.vyldo1.value = '<?php echo "$vyldo1_sk";?>';
   document.formv1.vyldv2.value = '<?php echo "$vyldv2";?>';
   document.formv1.vylod2.value = '<?php echo "$vylod2_sk";?>';
   document.formv1.vyldo2.value = '<?php echo "$vyldo2_sk";?>';
   document.formv1.vyldv3.value = '<?php echo "$vyldv3";?>';
   document.formv1.vylod3.value = '<?php echo "$vylod3_sk";?>';
   document.formv1.vyldo3.value = '<?php echo "$vyldo3_sk";?>';
   document.formv1.vyldv4.value = '<?php echo "$vyldv4";?>';
   document.formv1.vylod4.value = '<?php echo "$vylod4_sk";?>';
   document.formv1.vyldo4.value = '<?php echo "$vyldo4_sk";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.matod1.value = '<?php echo "$matod1sk";?>';
   document.formv1.matdo1.value = '<?php echo "$matdo1sk";?>';
   document.formv1.matod2.value = '<?php echo "$matod2sk";?>';
   document.formv1.matdo2.value = '<?php echo "$matdo2sk";?>';
   document.formv1.matod3.value = '<?php echo "$matod3sk";?>';
   document.formv1.matdo3.value = '<?php echo "$matdo3sk";?>';
   document.formv1.vz01.value = '<?php echo "$vz01";?>';
   document.formv1.vz02.value = '<?php echo "$vz02";?>';
   document.formv1.vz03.value = '<?php echo "$vz03";?>';
   document.formv1.vz04.value = '<?php echo "$vz04";?>';
   document.formv1.vz05.value = '<?php echo "$vz05";?>';
   document.formv1.vz06.value = '<?php echo "$vz06";?>';
   document.formv1.vz07.value = '<?php echo "$vz07";?>';
   document.formv1.vz08.value = '<?php echo "$vz08";?>';
   document.formv1.vz09.value = '<?php echo "$vz09";?>';
   document.formv1.vz10.value = '<?php echo "$vz10";?>';
   document.formv1.vz11.value = '<?php echo "$vz11";?>';
   document.formv1.vz12.value = '<?php echo "$vz12";?>';
   document.formv1.vo1b01.value = '<?php echo "$vo1b01";?>';
   document.formv1.vo1b02.value = '<?php echo "$vo1b02";?>';
   document.formv1.vo1b03.value = '<?php echo "$vo1b03";?>';
   document.formv1.vo1b04.value = '<?php echo "$vo1b04";?>';
   document.formv1.vo1b05.value = '<?php echo "$vo1b05";?>';
   document.formv1.vo1b06.value = '<?php echo "$vo1b06";?>';
   document.formv1.vo1b07.value = '<?php echo "$vo1b07";?>';
   document.formv1.vo1b08.value = '<?php echo "$vo1b08";?>';
   document.formv1.vo1b09.value = '<?php echo "$vo1b09";?>';
   document.formv1.vo1b10.value = '<?php echo "$vo1b10";?>';
   document.formv1.vo1b11.value = '<?php echo "$vo1b11";?>';
   document.formv1.vo1b12.value = '<?php echo "$vo1b12";?>';
   document.formv1.vo2b01.value = '<?php echo "$vo2b01";?>';
   document.formv1.vo2b02.value = '<?php echo "$vo2b02";?>';
   document.formv1.vo2b03.value = '<?php echo "$vo2b03";?>';
   document.formv1.vo2b04.value = '<?php echo "$vo2b04";?>';
   document.formv1.vo2b05.value = '<?php echo "$vo2b05";?>';
   document.formv1.vo2b06.value = '<?php echo "$vo2b06";?>';
   document.formv1.vo2b07.value = '<?php echo "$vo2b07";?>';
   document.formv1.vo2b08.value = '<?php echo "$vo2b08";?>';
   document.formv1.vo2b09.value = '<?php echo "$vo2b09";?>';
   document.formv1.vo2b10.value = '<?php echo "$vo2b10";?>';
   document.formv1.vo2b11.value = '<?php echo "$vo2b11";?>';
   document.formv1.vo2b12.value = '<?php echo "$vo2b12";?>';
   document.formv1.por1.value = '<?php echo "$por1";?>';
   document.formv1.vzv1.value = '<?php echo "$vzv1";?>';
   document.formv1.ost1.value = '<?php echo "$ost1";?>';
   document.formv1.exe1.value = '<?php echo "$exe1";?>';
   document.formv1.prs1.value = '<?php echo "$prs1";?>';
   document.formv1.por2.value = '<?php echo "$por2";?>';
   document.formv1.vzv2.value = '<?php echo "$vzv2";?>';
   document.formv1.ost2.value = '<?php echo "$ost2";?>';
   document.formv1.exe2.value = '<?php echo "$exe2";?>';
   document.formv1.prs2.value = '<?php echo "$prs2";?>';
   document.formv1.por3.value = '<?php echo "$por3";?>';
   document.formv1.vzv3.value = '<?php echo "$vzv3";?>';
   document.formv1.ost3.value = '<?php echo "$ost3";?>';
   document.formv1.exe3.value = '<?php echo "$exe3";?>';
   document.formv1.prs3.value = '<?php echo "$prs3";?>';
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   document.formv1.vyldv5.value = '<?php echo "$vyldv5";?>';
   document.formv1.vylod5.value = '<?php echo "$vylod5_sk";?>';
   document.formv1.vyldo5.value = '<?php echo "$vyldo5_sk";?>';
   document.formv1.vyl2dv1.value = '<?php echo "$vyl2dv1";?>';
   document.formv1.vyl2od1.value = '<?php echo "$vyl2od1_sk";?>';
   document.formv1.vyl2do1.value = '<?php echo "$vyl2do1_sk";?>';
   document.formv1.vyl2dv2.value = '<?php echo "$vyl2dv2";?>';
   document.formv1.vyl2od2.value = '<?php echo "$vyl2od2_sk";?>';
   document.formv1.vyl2do2.value = '<?php echo "$vyl2do2_sk";?>';
   document.formv1.vyl2dv3.value = '<?php echo "$vyl2dv3";?>';
   document.formv1.vyl2od3.value = '<?php echo "$vyl2od3_sk";?>';
   document.formv1.vyl2do3.value = '<?php echo "$vyl2do3_sk";?>';
   document.formv1.vyl2dv4.value = '<?php echo "$vyl2dv4";?>';
   document.formv1.vyl2od4.value = '<?php echo "$vyl2od4_sk";?>';
   document.formv1.vyl2do4.value = '<?php echo "$vyl2do4_sk";?>';
   document.formv1.vyl2dv5.value = '<?php echo "$vyl2dv5";?>';
   document.formv1.vyl2od5.value = '<?php echo "$vyl2od5_sk";?>';
   document.formv1.vyl2do5.value = '<?php echo "$vyl2do5_sk";?>';
   document.formv1.vyl3dv1.value = '<?php echo "$vyl3dv1";?>';
   document.formv1.vyl3od1.value = '<?php echo "$vyl3od1_sk";?>';
   document.formv1.vyl3do1.value = '<?php echo "$vyl3do1_sk";?>';
   document.formv1.vyl3dv2.value = '<?php echo "$vyl3dv2";?>';
   document.formv1.vyl3od2.value = '<?php echo "$vyl3od2_sk";?>';
   document.formv1.vyl3do2.value = '<?php echo "$vyl3do2_sk";?>';
   document.formv1.vyl3dv3.value = '<?php echo "$vyl3dv3";?>';
   document.formv1.vyl3od3.value = '<?php echo "$vyl3od3_sk";?>';
   document.formv1.vyl3do3.value = '<?php echo "$vyl3do3_sk";?>';
   document.formv1.vyl3dv4.value = '<?php echo "$vyl3dv4";?>';
   document.formv1.vyl3od4.value = '<?php echo "$vyl3od4_sk";?>';
   document.formv1.vyl3do4.value = '<?php echo "$vyl3do4_sk";?>';
   document.formv1.vyl3dv5.value = '<?php echo "$vyl3dv5";?>';
   document.formv1.vyl3od5.value = '<?php echo "$vyl3od5_sk";?>';
   document.formv1.vyl3do5.value = '<?php echo "$vyl3do5_sk";?>';
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

  function prevOC()
  {
   window.open('potvrd_nezd2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('potvrd_nezd2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function TlacZiadostRZ()
  {
   window.open('../mzdy/potvrd_nezd2014.php?copern=10&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>', '_blank', 'width=900, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function klikurcity()
  {
   document.formv1.neurcity.checked = false;
  }
  function klikneurcity()
  {
   document.formv1.urcity.checked = false;
  }
  function klikstarobny()
  {
   document.formv1.invalok.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.vysdch.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikinvalok()
  {
   document.formv1.starobny.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.vysdch.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikpredcas()
  {
   document.formv1.starobny.checked = false;
   document.formv1.invalok.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.vysdch.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikinvalvs()
  {
   document.formv1.starobny.checked = false;
   document.formv1.invalok.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.vysdch.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikinvalid()
  {
   document.formv1.starobny.checked = false;
   document.formv1.invalok.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.vysdch.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikvysdch()
  {
   document.formv1.starobny.checked = false;
   document.formv1.invalok.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.invaldo.checked = false;
  }
  function klikinvaldo()
  {
   document.formv1.starobny.checked = false;
   document.formv1.invalok.checked = false;
   document.formv1.predcas.checked = false;
   document.formv1.invalvs.checked = false;
   document.formv1.invalid.checked = false;
   document.formv1.vysdch.checked = false;
  }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//upravy udaje
if ( $copern == 20 )
    {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
   <td class="header">Potvrdenie na d·vku v nezamestnanosti - <span class="subheader"><?php echo "$oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacZiadostRZ();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="potvrd_nezd2014.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo "$strana";?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
$source="potvrd_nezd2014.php?cislo_oc=".$cislo_oc."";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">(3) pokraË.</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">(3) pokraË.</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str1.jpg" alt="tlaËivo Potvrdenie zamestn·vateæa na d·vku v nezamestnanosti pre rok 2014 1.strana 284kB" class="form-background">

<!-- ZAMESTNAVATEL -->
<span class="text-echo" style="width:435px; top:185px; left:180px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="width:112px; top:185px; left:643px;">&nbsp;<?php echo $fir_fico; ?></span>
<span class="text-echo" style="width:105px; top:185px; left:780px;"><?php echo $cicz; ?></span>
<span class="text-echo" style="width:528px; top:220px; left:90px;"><?php echo $fir_fadresa; ?></span>
<span class="text-echo" style="width:154px; top:220px; left:733px;"><?php echo $fir_sknace; ?></span>

<!-- ZAMESTNANEC -->
<span class="text-echo" style="width:490px; top:271px; left:136px;"><?php echo $nzmc; ?></span>
<span class="text-echo" style="width:193px; top:271px; left:705px;"><?php echo $rczmc; ?></span>
<span class="text-echo" style="width:590px; top:295px; left:128px;"><?php echo $bzmc; ?></span>

<!-- PRACOVNY POMER -->
<input type="checkbox" name="pracp" value="1" style="top:325px; left:46px;"/>
<input type="text" name="ppod1" id="ppod1" value="<?php echo $ppod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:322px; left:490px;"/>
<input type="text" name="ppdo1" id="ppdo1" value="<?php echo $ppdo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:322px; left:706px;"/>
<input type="checkbox" name="urcity" value="1" onchange="klikurcity();" style="top:351px; left:621px;"/>
<input type="checkbox" name="neurcity" value="1" onchange="klikneurcity();" style="top:351px; left:830px;"/>
<!-- DOHODA PRACOV.CIN -->
<input type="checkbox" name="dohpc" value="1" style="top:378px; left:46px;"/>
<input type="text" name="pcod1" id="pcod1" value="<?php echo $pcod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:401px; left:489px;"/>
<input type="text" name="pcdo1" id="pcdo1" value="<?php echo $pcdo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:401px; left:705px;"/>
<input type="text" name="pcod2" id="pcod2" value="<?php echo $pcod2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:428px; left:488px;"/>
<input type="text" name="pcdo2" id="pcdo2" value="<?php echo $pcdo2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:428px; left:705px;"/>
<!-- DOHODA VYK.PRACA -->
<input type="checkbox" name="dohvp" value="1" style="top:461px; left:46px;"/>
<input type="text" name="vpod1" id="vpod1" value="<?php echo $vpod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:489px; left:488px;"/>
<input type="text" name="vpdo1" id="vpdo1" value="<?php echo $vpdo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:489px; left:705px;"/>
<input type="text" name="vpod2" id="vpod2" value="<?php echo $vpod2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:520px; left:488px;"/>
<input type="text" name="vpdo2" id="vpdo2" value="<?php echo $vpdo2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:520px; left:705px;"/>

<!-- bod (1) -->
<input type="text" name="datod" id="datod" value="<?php echo $datod; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:548px; left:473px;"/>
<input type="checkbox" name="starobny" value="1" onclick="klikstarobny();" style="top:578px; left:78px;"/>
<input type="checkbox" name="invalok" value="1" onclick="klikinvalok();" style="top:578px; left:498px;"/>
<input type="checkbox" name="predcas" value="1" onclick="klikpredcas();" style="top:607px; left:78px;"/>
<input type="checkbox" name="invalvs" value="1" onclick="klikinvalvs();" style="top:607px; left:498px;"/>
<input type="checkbox" name="invalid" value="1" onclick="klikinvalid();" style="top:634px; left:78px;"/>
<input type="checkbox" name="vysdch" value="1" onclick="klikvysdch();" style="top:634px; left:498px;"/>
<input type="checkbox" name="invaldo" value="1" onclick="klikinvaldo();" style="top:676px; left:78px;"/>

<!-- bod (2) -->
<input type="text" name="predv1" id="predv1" value="<?php echo $predv1; ?>" style="width:320px; top:925px; left:46px;"/>
<input type="text" name="preod1" id="preod1" value="<?php echo $preod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:925px; left:399px;"/>
<input type="text" name="predo1" id="predo1" value="<?php echo $predo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:925px; left:621px;"/>
<span class="text-echo" style="width:50px; top:929px; left:850px;"><?php echo $predni1; ?></span>
<input type="text" name="predv2" id="predv2" value="<?php echo $predv2; ?>" style="width:320px; top:953px; left:46px;"/>
<input type="text" name="preod2" id="preod2" value="<?php echo $preod2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:953px; left:399px;"/>
<input type="text" name="predo2" id="predo2" value="<?php echo $predo2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:953px; left:621px;"/>
<span class="text-echo" style="width:50px; top:957px; left:850px;"><?php echo $predni2; ?></span>
<input type="text" name="predv3" id="predv3" value="<?php echo $predv3; ?>" style="width:320px; top:981px; left:46px;"/>
<input type="text" name="preod3" id="preod3" value="<?php echo $preod3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:981px; left:399px;"/>
<input type="text" name="predo3" id="predo3" value="<?php echo $predo3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:981px; left:621px;"/>
<span class="text-echo" style="width:50px; top:986px; left:850px;"><?php echo $predni3; ?></span>

<!-- bod (3) -->
<input type="text" name="vyldv1" id="vyldv1" value="<?php echo $vyldv1; ?>" style="width:325px; top:1137px; left:46px;"/>
<input type="text" name="vylod1" id="vylod1" value="<?php echo $vylod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:1137px; left:404px;"/>
<input type="text" name="vyldo1" id="vyldo1" value="<?php echo $vyldo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:1137px; left:626px;"/>
<span class="text-echo" style="width:50px; top:1141px; left:855px;"><?php echo $vyldni1; ?></span>
<input type="text" name="vyldv2" id="vyldv2" value="<?php echo $vyldv2; ?>" style="width:325px; top:1165px; left:46px;"/>
<input type="text" name="vylod2" id="vylod2" value="<?php echo $vylod2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:1165px; left:404px;"/>
<input type="text" name="vyldo2" id="vyldo2" value="<?php echo $vyldo2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:1165px; left:626px;"/>
<span class="text-echo" style="width:50px; top:1169px; left:855px;"><?php echo $vyldni2; ?></span>
<input type="text" name="vyldv3" id="vyldv3" value="<?php echo $vyldv3; ?>" style="width:325px; top:1193px; left:46px;"/>
<input type="text" name="vylod3" id="vylod3" value="<?php echo $vylod3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:1193px; left:404px;"/>
<input type="text" name="vyldo3" id="vyldo3" value="<?php echo $vyldo3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:1193px; left:626px;"/>
<span class="text-echo" style="width:50px; top:1197px; left:855px;"><?php echo $vyldni3; ?></span>
<input type="text" name="vyldv4" id="vyldv4" value="<?php echo $vyldv4; ?>" style="width:325px; top:1221px; left:46px;"/>
<input type="text" name="vylod4" id="vylod4" value="<?php echo $vylod4; ?>" onkeyup="CiarkaNaBodku(this);" style="width:187px; top:1221px; left:404px;"/>
<input type="text" name="vyldo4" id="vyldo4" value="<?php echo $vyldo4; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:1221px; left:626px;"/>
<span class="text-echo" style="width:50px; top:1225px; left:855px;"><?php echo $vyldni4; ?></span>

<div class="info-simple">œalöie obdobia n·jdete na (3) pokraË.</div>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str2.jpg" alt="tlaËivo Potvrdenie zamestn·vateæa na d·vku v nezamestnanosti pre rok 2014 2.strana 284kB" class="form-background">

<!-- bod (4) -->
<input type="text" name="matod1" id="matod1" value="<?php echo $matod1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:104px; left:405px;"/>
<input type="text" name="matdo1" id="matdo1" value="<?php echo $matdo1; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:104px; left:622px;"/>
<span class="text-echo" style="width:50px; top:108px; left:855px;"><?php echo $matdni1; ?></span>
<input type="text" name="matod2" id="matod2" value="<?php echo $matod2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:134px; left:405px;"/>
<input type="text" name="matdo2" id="matdo2" value="<?php echo $matdo2; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:134px; left:622px;"/>
<span class="text-echo" style="width:50px; top:138px; left:855px;"><?php echo $matdni2; ?></span>
<input type="text" name="matod3" id="matod3" value="<?php echo $matod3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:165px; left:405px;"/>
<input type="text" name="matdo3" id="matdo3" value="<?php echo $matdo3; ?>" onkeyup="CiarkaNaBodku(this);" style="width:186px; top:165px; left:622px;"/>
<span class="text-echo" style="width:50px; top:169px; left:855px;"><?php echo $matdni3; ?></span>

<?php
$obdobie=$kli_vrok;
$obdobie1b=$kli_vrok-1;
$obdobie2b=$kli_vrok-2;

$firm1=$kli_vxcf; $firm2=0; $firm3=0;   

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm2=$fir_allx11; }

$databaza="";
if ( $kli_vrok == 2013 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrok == 2014 ) { if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; } }
if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; } }

if ( $firm2 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm2"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm3=$fir_allx11; }
}
//echo $firm1." ".$firm2." ".$firm3." ";
?>

<!-- bod (5) -->
<span class="text-echo" style="width:48px; top:309px; left:319px;"><?php echo $obdobie2b; ?></span>
<?php if ( $firm2 > 0 ) { ?>
 <img src="../obr/ikony/download_blue_icon.png" onclick="window.open('potvrd_nezd2014.php?copern=27&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&obdobie=3&firmaxy=<?php echo $firm3; ?>', '_self')"
  title="NaËÌtaù vymeriavacie z·klady z firmy Ë. <?php echo $firm3; ?>" class="btn-row-tool" style="top:303px; left:361px;">
<?php                   } ?>
<span class="text-echo" style="width:48px; top:309px; left:552px;"><?php echo $obdobie1b; ?></span>
<?php if ( $firm2 > 0 ) { ?>
 <img src="../obr/ikony/download_blue_icon.png" onclick="window.open('potvrd_nezd2014.php?copern=27&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&obdobie=2&firmaxy=<?php echo $firm2; ?>', '_self')"
  title="NaËÌtaù vymeriavacie z·klady z firmy Ë. <?php echo $firm2; ?>" class="btn-row-tool" style="top:303px; left:594px;">
<?php                   } ?>
<span class="text-echo" style="width:48px; top:309px; left:784px;"><?php echo $obdobie; ?></span>
 <img src="../obr/ikony/download_blue_icon.png"
  onclick="window.open('potvrd_nezd2014.php?copern=27&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&obdobie=1&firmaxy=<?php echo $kli_vxcf; ?>', '_self')"
  title="NaËÌtaù vymeriavacie z·klady z firmy Ë. <?php echo $firm1; ?>" class="btn-row-tool" style="top:303px; left:826px;">
<!-- januar -->
<input type="text" name="vo2b01" id="vo2b01" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:331px; left:275px;"/>
<input type="text" name="vo1b01" id="vo1b01" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:331px; left:508px;"/>
<input type="text" name="vz01" id="vz01" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:331px; left:740px;"/>
<!-- februar -->
<input type="text" name="vo2b02" id="vo2b02" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:363px; left:275px;"/>
<input type="text" name="vo1b02" id="vo1b02" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:363px; left:508px;"/>
<input type="text" name="vz02" id="vz02" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:363px; left:740px;"/>
<!-- marec -->
<input type="text" name="vo2b03" id="vo2b03" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:395px; left:275px;"/>
<input type="text" name="vo1b03" id="vo1b03" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:395px; left:508px;"/>
<input type="text" name="vz03" id="vz03" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:395px; left:740px;"/>
<!-- april -->
<input type="text" name="vo2b04" id="vo2b04" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:428px; left:275px;"/>
<input type="text" name="vo1b04" id="vo1b04" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:428px; left:508px;"/>
<input type="text" name="vz04" id="vz04" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:428px; left:740px;"/>
<!-- maj -->
<input type="text" name="vo2b05" id="vo2b05" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:460px; left:275px;"/>
<input type="text" name="vo1b05" id="vo1b05" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:460px; left:508px;"/>
<input type="text" name="vz05" id="vz05" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:460px; left:740px;"/>
<!-- jun -->
<input type="text" name="vo2b06" id="vo2b06" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:492px; left:275px;"/>
<input type="text" name="vo1b06" id="vo1b06" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:492px; left:508px;"/>
<input type="text" name="vz06" id="vz06" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:492px; left:740px;"/>
<!-- jul -->
<input type="text" name="vo2b07" id="vo2b07" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:524px; left:275px;"/>
<input type="text" name="vo1b07" id="vo1b07" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:524px; left:508px;"/>
<input type="text" name="vz07" id="vz07" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:524px; left:740px;"/>
<!-- august -->
<input type="text" name="vo2b08" id="vo2b08" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:555px; left:275px;"/>
<input type="text" name="vo1b08" id="vo1b08" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:555px; left:508px;"/>
<input type="text" name="vz08" id="vz08" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:555px; left:740px;"/>
<!-- september -->
<input type="text" name="vo2b09" id="vo2b09" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:587px; left:275px;"/>
<input type="text" name="vo1b09" id="vo1b09" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:587px; left:508px;"/>
<input type="text" name="vz09" id="vz09" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:587px; left:740px;"/>
<!-- oktober -->
<input type="text" name="vo2b10" id="vo2b10" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:618px; left:275px;"/>
<input type="text" name="vo1b10" id="vo1b10" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:618px; left:508px;"/>
<input type="text" name="vz10" id="vz10" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:618px; left:740px;"/>
<!-- november -->
<input type="text" name="vo2b11" id="vo2b11" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:650px; left:275px;"/>
<input type="text" name="vo1b11" id="vo1b11" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:650px; left:508px;"/>
<input type="text" name="vz11" id="vz11" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:650px; left:740px;"/>
<!-- december -->
<input type="text" name="vo2b12" id="vo2b12" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:682px; left:275px;"/>
<input type="text" name="vo1b12" id="vo1b12" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:682px; left:508px;"/>
<input type="text" name="vz12" id="vz12" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:682px; left:740px;"/>
<!-- SPOLU -->
<span class="text-echo" style="width:100px; top:719px; left:275px;">&nbsp;<?php echo $vo2b13; ?></span>
<span class="text-echo" style="width:100px; top:719px; left:508px;">&nbsp;<?php echo $vo1b13; ?></span>
<span class="text-echo" style="width:100px; top:719px; left:740px;">&nbsp;<?php echo $vz13; ?></span>

<!-- Zrazky zo mzdy -->
<input type="text" name="por1" id="por1" style="width:39px; top:786px; left:40px;"/>
<input type="text" name="vzv1" id="vzv1" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:786px; left:92px;"/>
<input type="text" name="ost1" id="ost1" onkeyup="CiarkaNaBodku(this);" style="width:159px; top:786px; left:230px;"/>
<input type="text" name="exe1" id="exe1" style="width:230px; top:786px; left:402px;"/>
<input type="text" name="prs1" id="prs1" style="width:251px; top:786px; left:645px;"/>
<input type="text" name="por2" id="por2" style="width:39px; top:815px; left:40px;"/>
<input type="text" name="vzv2" id="vzv2" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:815px; left:92px;"/>
<input type="text" name="ost2" id="ost2" onkeyup="CiarkaNaBodku(this);" style="width:159px; top:815px; left:230px;"/>
<input type="text" name="exe2" id="exe2" style="width:230px; top:815px; left:402px;"/>
<input type="text" name="prs2" id="prs2" style="width:251px; top:815px; left:645px;"/>
<input type="text" name="por3" id="por3" style="width:39px; top:844px; left:40px;"/>
<input type="text" name="vzv3" id="vzv3" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:844px; left:92px;"/>
<input type="text" name="ost3" id="ost3" onkeyup="CiarkaNaBodku(this);" style="width:159px; top:844px; left:230px;"/>
<input type="text" name="exe3" id="exe3" style="width:230px; top:844px; left:402px;"/>
<input type="text" name="prs3" id="prs3" style="width:251px; top:844px; left:645px;"/>

<!-- Zodpovedny -->
<span class="text-echo" style="width:849px; top:999px; left:46px; text-align:center;"><?php echo "$fir_mzdt05 - $fir_mzdt04"; ?></span>

<!-- Vyhlasujem -->
<span class="text-echo" style="width:166px; top:1100px; left:44px; text-align:center; font-size:13px;"><?php echo $fir_fmes; ?></span>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1094px; left:243px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 ) { ?>
<img src="../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str3.jpg" alt="tlaËivo Potvrdenie zamestn·vateæa na d·vku v nezamestnanosti pre rok 2014 3.strana 16kB" class="form-background">

<table class="vylucene">
<caption>POKRA»OVANIE (3) UveÔte obdobia vyl˙Ëenia povinosti platiù poistnÈ na poistenie v nezamestnanosti v zmysle ß 140 z·kona:</caption>
<tr>
 <th width="48%">DÙvod</th><th width="18%"></th><th width="18%"></th><th width="16%">PoËet kalend. dnÌ</th>
</tr>
<tr>
 <td><input type="text" name="vyldv5" id="vyldv5" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vylod5" id="vylod5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyldo5" id="vyldo5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyldni5; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl2dv1" id="vyl2dv1" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl2od1" id="vyl2od1" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl2do1" id="vyl2do1" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl2dni1; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl2dv2" id="vyl2dv2" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl2od2" id="vyl2od2" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl2do2" id="vyl2do2" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl2dni2; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl2dv3" id="vyl2dv3" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl2od3" id="vyl2od3" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl2do3" id="vyl2do3" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl2dni3; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl2dv4" id="vyl2dv4" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl2od4" id="vyl2od4" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl2do4" id="vyl2do4" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl2dni4; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl2dv5" id="vyl2dv5" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl2od5" id="vyl2od5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl2do5" id="vyl2do5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl2dni5; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl3dv1" id="vyl3dv1" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl3od1" id="vyl3od1" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl3do1" id="vyl3do1" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl3dni1; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl3dv2" id="vyl3dv2" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl3od2" id="vyl3od2" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl3do2" id="vyl3do2" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl3dni2; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl3dv3" id="vyl3dv3" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl3od3" id="vyl3od3" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl3do3" id="vyl3do3" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl3dni3; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl3dv4" id="vyl3dv4" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl3od4" id="vyl3od4" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl3do4" id="vyl3do4" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl3dni4; ?></td>
</tr>
<tr>
 <td><input type="text" name="vyl3dv5" id="vyl3dv5" style="width:325px;"/></td>
 <td>od&nbsp;<input type="text" name="vyl3od5" id="vyl3od5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td>do&nbsp;<input type="text" name="vyl3do5" id="vyl3do5" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/></td>
 <td style="text-align:center;"><?php echo $vyl3dni5; ?></td>
</tr>
</table>

<div class="info-dopl">
 <h3>DoplÚuj˙ce inform·cie</h3>
 <textarea name="str2" id="str2" rows="10" cols="110" style="width:600px; overflow:auto;" ><?php echo $str2; ?></textarea>
</div>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">(3) pokraË.</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>
</div> <!-- koniec #content -->

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC POTVRDENIE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/potvrdenieFO.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdenieFO.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdpotvrdenienezd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdpotvrdenienezd.oc = $cislo_oc ORDER BY konx,prie,meno";

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
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str1.jpg',0,0,210,297);
}

//ZAMESTNAVATEL
$pdf->Cell(190,26," ","$rmc1",1,"L");
$pdf->Cell(31,4," ","$rmc1",0,"L");$pdf->Cell(97,5,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(24,5,"$fir_fico","$rmc",0,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(24,5,"$cicz","$rmc",1,"L");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(11,4," ","$rmc1",0,"L");$pdf->Cell(117,5,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");$pdf->Cell(26,4," ","$rmc1",0,"L");
$pdf->Cell(34,5,"$fir_sknace","$rmc",1,"L");

//ZAMESTNANEC
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(22,4," ","$rmc1",0,"L");$pdf->Cell(108,5,"$hlavicka->titl $hlavicka->meno $hlavicka->prie","$rmc",0,"L");$pdf->Cell(17,4," ","$rmc1",0,"L");
$pdf->Cell(43,5,"$tlacrd","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"L");$pdf->Cell(122,4,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","$rmc",1,"L");

//PRACOVNY POMER
$pracovny=" ";
if ( $hlavicka->pracp == 1 ) { $pracovny="X"; }
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$pracovny","$rmc",0,"C");$pdf->Cell(94,4," ","$rmc1",0,"L");
//od
$dan=SkDatum($hlavicka->ppod1);
if ( $dan == "00.00.0000" ) $dan="";
$pole = explode(".", $dan);
$dana=$pole[0];
$dan1a=substr($dana,0,1);
$dan2a=substr($dana,1,1);
$danb=$pole[1];
$dan1b=substr($danb,0,1);
$dan2b=substr($danb,1,1);
$danc=$pole[2];
$dan1c=substr($danc,0,1);
$dan2c=substr($danc,1,1);
$dan3c=substr($danc,2,1);
$dan4c=substr($danc,3,1);
$pdf->Cell(5,4,"$dan1a","$rmc",0,"L");$pdf->Cell(4,4,"$dan2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$dan1b","$rmc",0,"L");$pdf->Cell(5,4,"$dan2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$dan1c","$rmc",0,"L");$pdf->Cell(5,4,"$dan2c","$rmc",0,"L");$pdf->Cell(5,4,"$dan3c","$rmc",0,"L");$pdf->Cell(4,4,"$dan4c","$rmc",0,"C");
//do
$dav=SkDatum($hlavicka->ppdo1);
if ( $dav == "00.00.0000" ) $dav="";
$pole = explode(".", $dav);
$dava=$pole[0];
$dav1a=substr($dava,0,1);
$dav2a=substr($dava,1,1);
$davb=$pole[1];
$dav1b=substr($davb,0,1);
$dav2b=substr($davb,1,1);
$davc=$pole[2];
$dav1c=substr($davc,0,1);
$dav2c=substr($davc,1,1);
$dav3c=substr($davc,2,1);
$dav4c=substr($davc,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$dav1a","$rmc",0,"L");$pdf->Cell(5,4,"$dav2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$dav1b","$rmc",0,"C");$pdf->Cell(5,4,"$dav2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$dav1c","$rmc",0,"L");$pdf->Cell(5,4,"$dav2c","$rmc",0,"C");$pdf->Cell(5,4,"$dav3c","$rmc",0,"C");$pdf->Cell(5,4,"$dav4c","$rmc",1,"C");
//na dobu
$urcity=" ";
$neurcity=" ";
if ( $hlavicka->urcity == 1 ) { $urcity="X"; }
if ( $hlavicka->neurcity == 1 ) { $neurcity="X"; }
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(129,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$urcity","$rmc",0,"C");$pdf->Cell(41,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$neurcity","$rmc",1,"C");

//DOHODA PRACOV.CIN
$pdf->Cell(190,2," ","$rmc1",1,"L");
$dohpc=" ";
if ( $hlavicka->dohpc == 1 ) { $dohpc="X"; }
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$dohpc","$rmc",1,"C");
//od1
$pdf->Cell(190,2," ","$rmc1",1,"L");
$datm=SkDatum($hlavicka->pcod1);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(101,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(4,4,"$doco2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"L");$pdf->Cell(5,4,"$doco2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"L");$pdf->Cell(5,4,"$doco3c","$rmc",0,"L");$pdf->Cell(4,4,"$doco4c","$rmc",0,"C");
//do1
$datm=SkDatum($hlavicka->pcdo1);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(5,4,"$doco2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"C");$pdf->Cell(5,4,"$doco2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"C");$pdf->Cell(5,4,"$doco3c","$rmc",0,"C");$pdf->Cell(5,4,"$doco4c","$rmc",1,"C");
//od2
$pdf->Cell(190,2," ","$rmc1",1,"L");
$datm=SkDatum($hlavicka->pcod2);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(101,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(4,4,"$doco2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"L");$pdf->Cell(5,4,"$doco2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"L");$pdf->Cell(5,4,"$doco3c","$rmc",0,"L");$pdf->Cell(4,4,"$doco4c","$rmc",0,"C");
//do2
$datm=SkDatum($hlavicka->pcdo2);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(5,4,"$doco2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"C");$pdf->Cell(5,4,"$doco2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"C");
$pdf->Cell(5,4,"$doco3c","$rmc",0,"C");$pdf->Cell(5,4,"$doco4c","$rmc",1,"C");

//DOHODA VYK.PRACA
$pdf->Cell(190,3," ","$rmc1",1,"L");
$dohvp=" ";
if ( $hlavicka->dohvp == 1 ) { $dohvp="X"; }
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$dohvp","$rmc",1,"C");
//od1
$pdf->Cell(190,3," ","$rmc1",1,"L");
$datm=SkDatum($hlavicka->vpod1);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(101,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(4,4,"$doco2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"L");$pdf->Cell(5,4,"$doco2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"L");$pdf->Cell(5,4,"$doco3c","$rmc",0,"L");$pdf->Cell(4,4,"$doco4c","$rmc",0,"C");
//do1
$datm=SkDatum($hlavicka->vpdo1);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(5,4,"$doco2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"C");$pdf->Cell(5,4,"$doco2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"C");$pdf->Cell(5,4,"$doco3c","$rmc",0,"C");$pdf->Cell(5,4,"$doco4c","$rmc",1,"C");
//od2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$datm=SkDatum($hlavicka->vpod2);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(101,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(4,4,"$doco2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"L");$pdf->Cell(5,4,"$doco2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"L");$pdf->Cell(5,4,"$doco3c","$rmc",0,"L");$pdf->Cell(4,4,"$doco4c","$rmc",0,"L");
//do2
$datm=SkDatum($hlavicka->vpdo2);
if ( $datm == "00.00.0000" ) $datm="";
$pole = explode(".", $datm);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1a","$rmc",0,"L");$pdf->Cell(5,4,"$doco2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$doco1b","$rmc",0,"C");$pdf->Cell(5,4,"$doco2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$doco1c","$rmc",0,"L");$pdf->Cell(5,4,"$doco2c","$rmc",0,"C");$pdf->Cell(5,4,"$doco3c","$rmc",0,"C");$pdf->Cell(5,4,"$doco4c","$rmc",1,"C");

//(1) PvN sa nevztahuje od
$pdf->Cell(190,2," ","$rmc1",1,"L");
$datod=SkDatum($hlavicka->datod);
if ( $datod == "00.00.0000" ) $datod="";
$pole = explode(".", $datod);
$docoa=$pole[0];
$doco1a=substr($docoa,0,1);
$doco2a=substr($docoa,1,1);
$docob=$pole[1];
$doco1b=substr($docob,0,1);
$doco2b=substr($docob,1,1);
$dococ=$pole[2];
$doco1c=substr($dococ,0,1);
$doco2c=substr($dococ,1,1);
$doco3c=substr($dococ,2,1);
$doco4c=substr($dococ,3,1);
$pdf->Cell(97,4," ","$rmc1",0,"L");
$pdf->Cell(4,5,"$doco1a","$rmc",0,"L");$pdf->Cell(5,5,"$doco2a","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,5,"$doco1b","$rmc",0,"L");$pdf->Cell(5,5,"$doco2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,5,"$doco1c","$rmc",0,"C");$pdf->Cell(5,5,"$doco2c","$rmc",0,"C");$pdf->Cell(5,5,"$doco3c","$rmc",0,"C");$pdf->Cell(5,5,"$doco4c","$rmc",1,"C");
//(1) bol priznany
$pdf->Cell(190,2," ","$rmc1",1,"L");
$starobny=" ";
$predcas=" ";
$invalid=" ";
$invaldo=" ";
$invalok=" ";
$invalvs=" ";
$vysdch=" ";
if ( $hlavicka->starobny == 1 ) { $starobny="X"; }
if ( $hlavicka->predcas == 1 ) { $predcas="X"; }
if ( $hlavicka->invalid == 1 ) { $invalid="X"; }
if ( $hlavicka->invaldo == 1 ) { $invaldo="X"; }
if ( $hlavicka->invalok == 1 ) { $invalok="X"; }
if ( $hlavicka->invalvs == 1 ) { $invalvs="X"; }
if ( $hlavicka->vysdch == 1 ) { $vysdch="X"; }
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$starobny","$rmc",0,"L");$pdf->Cell(88,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$invalok","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$predcas","$rmc",0,"L");$pdf->Cell(88,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$invalvs","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(5,5,"$invalid","$rmc",0,"L");$pdf->Cell(88,4," ","$rmc1",0,"L");$pdf->Cell(5,5,"$vysdch","$rmc",1,"L");
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(9,4," ","$rmc1",0,"L");$pdf->Cell(5,4,"$invaldo","$rmc",1,"L");

//(2) prerusene PvN
//dovod 1
$pdf->Cell(190,54," ","$rmc1",1,"L");
$predv1=$hlavicka->predv1;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(72,4,"$predv1","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od1
$preod1=SkDatum($hlavicka->preod1);
if ( $preod1 == "00.00.0000" ) $preod1="";
$pole = explode(".", $preod1);
$preoda=$pole[0];
$preod1a=substr($preoda,0,1);
$preod2a=substr($preoda,1,1);
$preodb=$pole[1];
$preod1b=substr($preodb,0,1);
$preod2b=substr($preodb,1,1);
$preodc=$pole[2];
$preod1c=substr($preodc,0,1);
$preod2c=substr($preodc,1,1);
$preod3c=substr($preodc,2,1);
$preod4c=substr($preodc,3,1);
$pdf->Cell(5,4,"$preod1a","$rmc",0,"C");$pdf->Cell(5,4,"$preod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1b","$rmc",0,"R");$pdf->Cell(5,4,"$preod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1c","$rmc",0,"L");$pdf->Cell(5,4,"$preod2c","$rmc",0,"L");
$pdf->Cell(5,4,"$preod3c","$rmc",0,"L");$pdf->Cell(5,4,"$preod4c","$rmc",0,"L");
//do1
$predo1=SkDatum($hlavicka->predo1);
if ( $predo1 == "00.00.0000" ) $predo1="";
$pole = explode(".", $predo1);
$predoa=$pole[0];
$predo1a=substr($predoa,0,1);
$predo2a=substr($predoa,1,1);
$predob=$pole[1];
$predo1b=substr($predob,0,1);
$predo2b=substr($predob,1,1);
$predoc=$pole[2];
$predo1c=substr($predoc,0,1);
$predo2c=substr($predoc,1,1);
$predo3c=substr($predoc,2,1);
$predo4c=substr($predoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1a","$rmc",0,"L");$pdf->Cell(4,4,"$predo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1b","$rmc",0,"L");$pdf->Cell(5,4,"$predo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1c","$rmc",0,"L");$pdf->Cell(5,4,"$predo2c","$rmc",0,"L");$pdf->Cell(5,4,"$predo3c","$rmc",0,"L");$pdf->Cell(5,4,"$predo4c","$rmc",0,"L");
//dni 1
$predni1=$hlavicka->predni1;
if ( $predni1 == 0 ) $predni1="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(17,4,"$predni1 ","$rmc",1,"R");
//dovod 2
$pdf->Cell(190,2," ","$rmc1",1,"L");
$predv2=$hlavicka->predv2;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(72,4,"$predv2","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 2
$preod2=SkDatum($hlavicka->preod2);
if ( $preod2 == "00.00.0000" ) $preod2="";
$pole = explode(".", $preod2);
$preoda=$pole[0];
$preod1a=substr($preoda,0,1);
$preod2a=substr($preoda,1,1);
$preodb=$pole[1];
$preod1b=substr($preodb,0,1);
$preod2b=substr($preodb,1,1);
$preodc=$pole[2];
$preod1c=substr($preodc,0,1);
$preod2c=substr($preodc,1,1);
$preod3c=substr($preodc,2,1);
$preod4c=substr($preodc,3,1);
$pdf->Cell(5,4,"$preod1a","$rmc",0,"C");$pdf->Cell(5,4,"$preod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1b","$rmc",0,"R");$pdf->Cell(5,4,"$preod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1c","$rmc",0,"L");$pdf->Cell(5,4,"$preod2c","$rmc",0,"L");$pdf->Cell(5,4,"$preod3c","$rmc",0,"L");$pdf->Cell(5,4,"$preod4c","$rmc",0,"L");
//do 2
$predo2=SkDatum($hlavicka->predo2);
if ( $predo2 == "00.00.0000" ) $predo2="";
$pole = explode(".", $predo2);
$predoa=$pole[0];
$predo1a=substr($predoa,0,1);
$predo2a=substr($predoa,1,1);
$predob=$pole[1];
$predo1b=substr($predob,0,1);
$predo2b=substr($predob,1,1);
$predoc=$pole[2];
$predo1c=substr($predoc,0,1);
$predo2c=substr($predoc,1,1);
$predo3c=substr($predoc,2,1);
$predo4c=substr($predoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1a","$rmc",0,"L");$pdf->Cell(4,4,"$predo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1b","$rmc",0,"L");$pdf->Cell(5,4,"$predo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1c","$rmc",0,"L");$pdf->Cell(5,4,"$predo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$predo3c","$rmc",0,"L");$pdf->Cell(5,4,"$predo4c","$rmc",0,"L");
//dni 2
$predni2=$hlavicka->predni2;
if ( $predni2 == 0 ) $predni2="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(17,4,"$predni2 ","$rmc",1,"R");
//dovod 3
$pdf->Cell(190,2," ","$rmc1",1,"L");
$predv3=$hlavicka->predv3;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(72,4,"$predv3","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 3
$preod3=SkDatum($hlavicka->preod3);
if ( $preod3 == "00.00.0000" ) $preod3="";
$pole = explode(".", $preod3);
$preoda=$pole[0];
$preod1a=substr($preoda,0,1);
$preod2a=substr($preoda,1,1);
$preodb=$pole[1];
$preod1b=substr($preodb,0,1);
$preod2b=substr($preodb,1,1);
$preodc=$pole[2];
$preod1c=substr($preodc,0,1);
$preod2c=substr($preodc,1,1);
$preod3c=substr($preodc,2,1);
$preod4c=substr($preodc,3,1);
$pdf->Cell(5,4,"$preod1a","$rmc",0,"C");$pdf->Cell(5,4,"$preod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1b","$rmc",0,"R");$pdf->Cell(5,4,"$preod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$preod1c","$rmc",0,"L");$pdf->Cell(5,4,"$preod2c","$rmc",0,"L");
$pdf->Cell(5,4,"$preod3c","$rmc",0,"L");$pdf->Cell(5,4,"$preod4c","$rmc",0,"L");
//do 3
$predo3=SkDatum($hlavicka->predo3);
if ( $predo3 == "00.00.0000" ) $predo3="";
$pole = explode(".", $predo3);
$predoa=$pole[0];
$predo1a=substr($predoa,0,1);
$predo2a=substr($predoa,1,1);
$predob=$pole[1];
$predo1b=substr($predob,0,1);
$predo2b=substr($predob,1,1);
$predoc=$pole[2];
$predo1c=substr($predoc,0,1);
$predo2c=substr($predoc,1,1);
$predo3c=substr($predoc,2,1);
$predo4c=substr($predoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1a","$rmc",0,"L");$pdf->Cell(4,4,"$predo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1b","$rmc",0,"L");$pdf->Cell(5,4,"$predo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$predo1c","$rmc",0,"L");$pdf->Cell(5,4,"$predo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$predo3c","$rmc",0,"L");$pdf->Cell(5,4,"$predo4c","$rmc",0,"L");
//dni 3
$predni3=$hlavicka->predni3;
if ( $predni3 == 0 ) $predni3="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(17,4,"$predni3 ","$rmc",1,"R");

//(3) PvN vylucene
//dovod 1
$pdf->Cell(190,32," ","$rmc1",1,"L");
$vyldv1=$hlavicka->vyldv1;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(73,4,"$vyldv1","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 1
$vylod1=SkDatum($hlavicka->vylod1);
if ( $vylod1 == "00.00.0000" ) $vylod1="";
$pole = explode(".", $vylod1);
$vyloda=$pole[0];
$vylod1a=substr($vyloda,0,1);
$vylod2a=substr($vyloda,1,1);
$vylodb=$pole[1];
$vylod1b=substr($vylodb,0,1);
$vylod2b=substr($vylodb,1,1);
$vylodc=$pole[2];
$vylod1c=substr($vylodc,0,1);
$vylod2c=substr($vylodc,1,1);
$vylod3c=substr($vylodc,2,1);
$vylod4c=substr($vylodc,3,1);
$pdf->Cell(5,4,"$vylod1a","$rmc",0,"C");$pdf->Cell(5,4,"$vylod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1b","$rmc",0,"R");$pdf->Cell(5,4,"$vylod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod2c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod3c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod4c","$rmc",0,"L");
//do 1
$vyldo1=SkDatum($hlavicka->vyldo1);
if ( $vyldo1 == "00.00.0000" ) $vyldo1="";
$pole = explode(".", $vyldo1);
$vyldoa=$pole[0];
$vyldo1a=substr($vyldoa,0,1);
$vyldo2a=substr($vyldoa,1,1);
$vyldob=$pole[1];
$vyldo1b=substr($vyldob,0,1);
$vyldo2b=substr($vyldob,1,1);
$vyldoc=$pole[2];
$vyldo1c=substr($vyldoc,0,1);
$vyldo2c=substr($vyldoc,1,1);
$vyldo3c=substr($vyldoc,2,1);
$vyldo4c=substr($vyldoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1a","$rmc",0,"L");$pdf->Cell(4,4,"$vyldo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1b","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$vyldo3c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo4c","$rmc",0,"L");
//dni 1
$vyldni1=$hlavicka->vyldni1;
if ( $vyldni1 == 0 ) $vyldni1="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vyldni1","$rmc",1,"R");
//dovod 2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$vyldv2=$hlavicka->vyldv2;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(73,4,"$vyldv2","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 2
$vylod2=SkDatum($hlavicka->vylod2);
if ( $vylod2 == "00.00.0000" ) $vylod2="";
$pole = explode(".", $vylod2);
$vyloda=$pole[0];
$vylod1a=substr($vyloda,0,1);
$vylod2a=substr($vyloda,1,1);
$vylodb=$pole[1];
$vylod1b=substr($vylodb,0,1);
$vylod2b=substr($vylodb,1,1);
$vylodc=$pole[2];
$vylod1c=substr($vylodc,0,1);
$vylod2c=substr($vylodc,1,1);
$vylod3c=substr($vylodc,2,1);
$vylod4c=substr($vylodc,3,1);
$pdf->Cell(5,4,"$vylod1a","$rmc",0,"C");$pdf->Cell(5,4,"$vylod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1b","$rmc",0,"R");$pdf->Cell(5,4,"$vylod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod2c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod3c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod4c","$rmc",0,"L");
//do 2
$vyldo2=SkDatum($hlavicka->vyldo2);
if ( $vyldo2 == "00.00.0000" ) $vyldo2="";
$pole = explode(".", $vyldo2);
$vyldoa=$pole[0];
$vyldo1a=substr($vyldoa,0,1);
$vyldo2a=substr($vyldoa,1,1);
$vyldob=$pole[1];
$vyldo1b=substr($vyldob,0,1);
$vyldo2b=substr($vyldob,1,1);
$vyldoc=$pole[2];
$vyldo1c=substr($vyldoc,0,1);
$vyldo2c=substr($vyldoc,1,1);
$vyldo3c=substr($vyldoc,2,1);
$vyldo4c=substr($vyldoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1a","$rmc",0,"L");$pdf->Cell(4,4,"$vyldo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1b","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$vyldo3c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo4c","$rmc",0,"L");
//dni 2
$vyldni2=$hlavicka->vyldni2;
if( $vyldni2 == 0 ) $vyldni2="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vyldni2","$rmc",1,"R");
//dovod 3
$pdf->Cell(190,2," ","$rmc1",1,"L");
$vyldv3=$hlavicka->vyldv3;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(73,4,"$vyldv3","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 3
$vylod3=SkDatum($hlavicka->vylod3);
if ( $vylod3 == "00.00.0000" ) $vylod3="";
$pole = explode(".", $vylod3);
$vyloda=$pole[0];
$vylod1a=substr($vyloda,0,1);
$vylod2a=substr($vyloda,1,1);
$vylodb=$pole[1];
$vylod1b=substr($vylodb,0,1);
$vylod2b=substr($vylodb,1,1);
$vylodc=$pole[2];
$vylod1c=substr($vylodc,0,1);
$vylod2c=substr($vylodc,1,1);
$vylod3c=substr($vylodc,2,1);
$vylod4c=substr($vylodc,3,1);
$pdf->Cell(5,4,"$vylod1a","$rmc",0,"C");$pdf->Cell(5,4,"$vylod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1b","$rmc",0,"R");$pdf->Cell(5,4,"$vylod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod2c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod3c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod4c","$rmc",0,"L");
//do 3
$vyldo3=SkDatum($hlavicka->vyldo3);
if ( $vyldo3 == "00.00.0000" ) $vyldo3="";
$pole = explode(".", $vyldo3);
$vyldoa=$pole[0];
$vyldo1a=substr($vyldoa,0,1);
$vyldo2a=substr($vyldoa,1,1);
$vyldob=$pole[1];
$vyldo1b=substr($vyldob,0,1);
$vyldo2b=substr($vyldob,1,1);
$vyldoc=$pole[2];
$vyldo1c=substr($vyldoc,0,1);
$vyldo2c=substr($vyldoc,1,1);
$vyldo3c=substr($vyldoc,2,1);
$vyldo4c=substr($vyldoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1a","$rmc",0,"L");$pdf->Cell(4,4,"$vyldo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1b","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$vyldo3c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo4c","$rmc",0,"L");
//dni 3
$vyldni3=$hlavicka->vyldni3;
if ( $vyldni3 == 0 ) $vyldni3="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vyldni3","$rmc",1,"R");
//dovod 4
$pdf->Cell(190,2," ","$rmc1",1,"L");
$vyldv4=$hlavicka->vyldv4;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(73,4,"$vyldv4","$rmc",0,"L");$pdf->Cell(6,4," ","$rmc1",0,"L");
//od 4
$vylod4=SkDatum($hlavicka->vylod4);
if ( $vylod4 == "00.00.0000" ) $vylod4="";
$pole = explode(".", $vylod4);
$vyloda=$pole[0];
$vylod1a=substr($vyloda,0,1);
$vylod2a=substr($vyloda,1,1);
$vylodb=$pole[1];
$vylod1b=substr($vylodb,0,1);
$vylod2b=substr($vylodb,1,1);
$vylodc=$pole[2];
$vylod1c=substr($vylodc,0,1);
$vylod2c=substr($vylodc,1,1);
$vylod3c=substr($vylodc,2,1);
$vylod4c=substr($vylodc,3,1);
$pdf->Cell(5,4,"$vylod1a","$rmc",0,"C");$pdf->Cell(5,4,"$vylod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1b","$rmc",0,"R");$pdf->Cell(5,4,"$vylod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vylod1c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod2c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod3c","$rmc",0,"L");$pdf->Cell(5,4,"$vylod4c","$rmc",0,"L");
//do 4
$vyldo4=SkDatum($hlavicka->vyldo4);
if ( $vyldo4 == "00.00.0000" ) $vyldo4="";
$pole = explode(".", $vyldo4);
$vyldoa=$pole[0];
$vyldo1a=substr($vyldoa,0,1);
$vyldo2a=substr($vyldoa,1,1);
$vyldob=$pole[1];
$vyldo1b=substr($vyldob,0,1);
$vyldo2b=substr($vyldob,1,1);
$vyldoc=$pole[2];
$vyldo1c=substr($vyldoc,0,1);
$vyldo2c=substr($vyldoc,1,1);
$vyldo3c=substr($vyldoc,2,1);
$vyldo4c=substr($vyldoc,3,1);
$pdf->Cell(7,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1a","$rmc",0,"L");$pdf->Cell(4,4,"$vyldo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1b","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$vyldo1c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$vyldo3c","$rmc",0,"L");$pdf->Cell(5,4,"$vyldo4c","$rmc",0,"L");
//dni 4
$vyldni4=$hlavicka->vyldni4;
if ( $vyldni4 == 0 ) $vyldni4="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vyldni4","$rmc",1,"R");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/davka_vnezamestnanosti2014/PVN_potvrd_davka14_str2.jpg',0,0,210,297);
}

//ked som tam toto nemal tak ked som tlacil samostatne 2.stranu tak bolposunuta spolu OK ???? to uz sme kedysi riesili
$pdf->SetY(15);

//(4) obdobia materskej
//od 1
$pdf->Cell(190,4," ","$rmc1",1,"L");
$matod1=SkDatum($hlavicka->matod1);
if ( $matod1 == "00.00.0000" ) $matod1="";
$pole = explode(".", $matod1);
$matoda=$pole[0];
$matod1a=substr($matoda,0,1);
$matod2a=substr($matoda,1,1);
$matodb=$pole[1];
$matod1b=substr($matodb,0,1);
$matod2b=substr($matodb,1,1);
$matodc=$pole[2];
$matod1c=substr($matodc,0,1);
$matod2c=substr($matodc,1,1);
$matod3c=substr($matodc,2,1);
$matod4c=substr($matodc,3,1);
$pdf->Cell(81,4," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$matod1a","$rmc",0,"C");$pdf->Cell(5,4,"$matod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1b","$rmc",0,"R");$pdf->Cell(5,4,"$matod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1c","$rmc",0,"L");$pdf->Cell(5,4,"$matod2c","$rmc",0,"L");$pdf->Cell(5,4,"$matod3c","$rmc",0,"L");$pdf->Cell(5,4,"$matod4c","$rmc",0,"L");
//do 1
$matdo1=SkDatum($hlavicka->matdo1);
if ( $matdo1 == "00.00.0000" ) $matdo1="";
$pole = explode(".", $matdo1);
$matdoa=$pole[0];
$matdo1a=substr($matdoa,0,1);
$matdo2a=substr($matdoa,1,1);
$matdob=$pole[1];
$matdo1b=substr($matdob,0,1);
$matdo2b=substr($matdob,1,1);
$matdoc=$pole[2];
$matdo1c=substr($matdoc,0,1);
$matdo2c=substr($matdoc,1,1);
$matdo3c=substr($matdoc,2,1);
$matdo4c=substr($matdoc,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1a","$rmc",0,"L");$pdf->Cell(4,4,"$matdo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1b","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$matdo3c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo4c","$rmc",0,"L");
//dni 1
if ( $matdni1 == 0 ) $matdni1="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$matdni1","$rmc",1,"R");
//od 2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$matod2=SkDatum($hlavicka->matod2);
if ( $matod2 == "00.00.0000" ) $matod2="";
$pole = explode(".", $matod2);
$matoda=$pole[0];
$matod1a=substr($matoda,0,1);
$matod2a=substr($matoda,1,1);
$matodb=$pole[1];
$matod1b=substr($matodb,0,1);
$matod2b=substr($matodb,1,1);
$matodc=$pole[2];
$matod1c=substr($matodc,0,1);
$matod2c=substr($matodc,1,1);
$matod3c=substr($matodc,2,1);
$matod4c=substr($matodc,3,1);
$pdf->Cell(81,4," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$matod1a","$rmc",0,"C");$pdf->Cell(5,4,"$matod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1b","$rmc",0,"R");$pdf->Cell(5,4,"$matod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1c","$rmc",0,"L");$pdf->Cell(5,4,"$matod2c","$rmc",0,"L");$pdf->Cell(5,4,"$matod3c","$rmc",0,"L");$pdf->Cell(5,4,"$matod4c","$rmc",0,"L");
//do 2
$matdo2=SkDatum($hlavicka->matdo2);
if ( $matdo2 == "00.00.0000" ) $matdo2="";
$pole = explode(".", $matdo2);
$matdoa=$pole[0];
$matdo1a=substr($matdoa,0,1);
$matdo2a=substr($matdoa,1,1);
$matdob=$pole[1];
$matdo1b=substr($matdob,0,1);
$matdo2b=substr($matdob,1,1);
$matdoc=$pole[2];
$matdo1c=substr($matdoc,0,1);
$matdo2c=substr($matdoc,1,1);
$matdo3c=substr($matdoc,2,1);
$matdo4c=substr($matdoc,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1a","$rmc",0,"L");$pdf->Cell(4,4,"$matdo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1b","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$matdo3c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo4c","$rmc",0,"L");
//dni 2
if ( $matdni2 == 0 ) $matdni2="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$matdni2","$rmc",1,"R");
//od 3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$matod3=SkDatum($hlavicka->matod3);
if ( $matod3 == "00.00.0000" ) $matod3="";
$pole = explode(".", $matod3);
$matoda=$pole[0];
$matod1a=substr($matoda,0,1);
$matod2a=substr($matoda,1,1);
$matodb=$pole[1];
$matod1b=substr($matodb,0,1);
$matod2b=substr($matodb,1,1);
$matodc=$pole[2];
$matod1c=substr($matodc,0,1);
$matod2c=substr($matodc,1,1);
$matod3c=substr($matodc,2,1);
$matod4c=substr($matodc,3,1);
$pdf->Cell(81,4," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$matod1a","$rmc",0,"C");$pdf->Cell(5,4,"$matod2a","$rmc",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1b","$rmc",0,"R");$pdf->Cell(5,4,"$matod2b","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matod1c","$rmc",0,"L");$pdf->Cell(5,4,"$matod2c","$rmc",0,"L");$pdf->Cell(5,4,"$matod3c","$rmc",0,"L");$pdf->Cell(5,4,"$matod4c","$rmc",0,"L");
//do 3
$matdo3=SkDatum($hlavicka->matdo3);
if ( $matdo3 == "00.00.0000" ) $matdo3="";
$pole = explode(".", $matdo3);
$matdoa=$pole[0];
$matdo1a=substr($matdoa,0,1);
$matdo2a=substr($matdoa,1,1);
$matdob=$pole[1];
$matdo1b=substr($matdob,0,1);
$matdo2b=substr($matdob,1,1);
$matdoc=$pole[2];
$matdo1c=substr($matdoc,0,1);
$matdo2c=substr($matdoc,1,1);
$matdo3c=substr($matdoc,2,1);
$matdo4c=substr($matdoc,3,1);
$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1a","$rmc",0,"L");$pdf->Cell(4,4,"$matdo2a","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1b","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2b","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(5,4,"$matdo1c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo2c","$rmc",0,"L");
$pdf->Cell(5,4,"$matdo3c","$rmc",0,"L");$pdf->Cell(5,4,"$matdo4c","$rmc",0,"L");
//dni 3
if ( $matdni3 == 0 ) $matdni3="";
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(18,4,"$matdni3","$rmc",1,"R");

//(5) VYMER.ZAKLADY
//roky
$pdf->Cell(190,28," ","$rmc1",1,"L");
$obdobie=$kli_vrok;
$obdobie1b=$kli_vrok-1;
$obdobie2b=$kli_vrok-2;
$pdf->Cell(62,6,"","$rmc1",0,"L");$pdf->Cell(12,4,"$obdobie2b","$rmc",0,"C");$pdf->Cell(39,6,"","$rmc1",0,"L");$pdf->Cell(12,4,"$obdobie1b","$rmc",0,"C");
$pdf->Cell(40,7,"","$rmc1",0,"L");$pdf->Cell(11,4,"$obdobie","$rmc",1,"C");
//prehlad
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b01","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b01","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz01","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b02","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b02","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz02","$rmc",1,"R");
$pdf->Cell(190,2," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b03","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b03","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz03","$rmc",1,"R");
$pdf->Cell(190,2," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b04","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b04","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz04","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b05","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b05","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz05","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b06","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b06","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz06","$rmc",1,"R");
$pdf->Cell(190,2," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b07","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b07","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz07","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b08","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b08","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz08","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b09","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b09","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz09","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b10","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b10","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz10","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b11","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b11","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz11","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b12","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b12","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz12","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"R");
$pdf->Cell(39,6," ","$rmc1",0,"R");
$pdf->Cell(50,6,"$hlavicka->vo2b13","$rmc",0,"R");$pdf->Cell(53,6,"$hlavicka->vo1b13","$rmc",0,"R");$pdf->Cell(50,6,"$hlavicka->vz13","$rmc",1,"R");

//zrazky zo mzdy
$pdf->Cell(190,11," ","$rmc1",1,"L");
$por1=$hlavicka->por1;
if ( $hlavicka->por1 == 0 ) $por1="";
$vzv1=$hlavicka->vzv1;
if ( $hlavicka->vzv1 == 0 ) $vzv1="";
$ost1=$hlavicka->ost1;
if ( $hlavicka->ost1 == 0 ) $ost1="";
$por2=$hlavicka->por2;
if ( $hlavicka->por2 == 0 ) $por2="";
$vzv2=$hlavicka->vzv2;
if ( $hlavicka->vzv2 == 0 ) $vzv2="";
$ost2=$hlavicka->ost2;
if ( $hlavicka->ost2 == 0 ) $ost2="";
$por3=$hlavicka->por3;
if ( $hlavicka->por3 == 0 ) $por3="";
$vzv3=$hlavicka->vzv3;
if ( $hlavicka->vzv3 == 0 ) $vzv3="";
$ost3=$hlavicka->ost3;
if ( $hlavicka->ost3 == 0 ) $ost3="";
$pdf->Cell(11,6,"$por1","$rmc",0,"C");$pdf->Cell(31,6,"$vzv1","$rmc",0,"R");$pdf->Cell(38,6,"$ost1","$rmc",0,"R");
$pdf->Cell(54,6,"$hlavicka->exe1","$rmc",0,"L");$pdf->Cell(58,6,"$hlavicka->prs1","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(11,6,"$por2","$rmc",0,"C");$pdf->Cell(31,6,"$vzv2","$rmc",0,"R");$pdf->Cell(38,6,"$ost2","$rmc",0,"R");
$pdf->Cell(54,6,"$hlavicka->exe2","$rmc",0,"L");$pdf->Cell(58,6,"$hlavicka->prs2","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(11,6,"$por3","$rmc",0,"C");$pdf->Cell(31,6,"$vzv3","$rmc",0,"R");$pdf->Cell(38,6,"$ost3","$rmc",0,"R");
$pdf->Cell(54,6,"$hlavicka->exe3","$rmc",0,"L");$pdf->Cell(58,6,"$hlavicka->prs3","$rmc",1,"L");

//Zodpovedny
$pdf->Cell(190,29," ","$rmc1",1,"L");
$pdf->Cell(192,4,"$fir_mzdt05 - tel. $fir_mzdt04","$rmc",1,"C");

//Vyhlasujem
$pdf->SetFont('arial','',8);
$pdf->Cell(190,18," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == "00.00.0000" ) $datum="";
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(37,5,"$fir_fmes","$rmc",0,"C");$pdf->Cell(6,4," ","$rmc",0,"L");$pdf->Cell(20,5,"$datum","$rmc",1,"L");
                                       }

if ( $strana == 3 ) {
$polestr2 = explode("\r\n", $hlavicka->str2);
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//POKRACOVANIE(3) PvN vylucene
$pdf->SetY(10);
$pdf->SetFont('arial','',11);
$pdf->Cell(170,5,"Potvrdenie zamestn·vateæa na ˙Ëely n·roku na d·vku v nezamestnanosti - prÌloha","$rmc",0,"L");$pdf->Cell(20,5,"strana 3","$rmc",1,"R");

//zamestnavatel
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(30,5,"Zamestn·vateæ:","$rmc1",0,"L");$pdf->Cell(160,5,"I»O: $fir_fico ","$rmc",1,"L");
$pdf->Cell(30,5," ","$rmc1",0,"L");$pdf->Cell(160,5,"N·zov a adresa: $fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");
//zamestnanec
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(30,5,"Zamestnanec:","$rmc1",0,"L");$pdf->Cell(160,5,"Rod.ËÌslo: $hlavicka->rdc $hlavicka->rdk","$rmc",1,"L");
$pdf->Cell(30,5," ","$rmc1",0,"L");$pdf->Cell(160,5,"Meno a priezvisko: $hlavicka->meno $hlavicka->prie","$rmc",1,"L");

//(3) PvN vylucene - pokracov.
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(190,5,"pokraËov. zo str. 1 - (3) UveÔte obdobia vyl˙Ëenia povinnosti platiù poistnÈ na poistenie v nezamestnanosti v zmysle ß 140 z·kona","$rmc",1,"L");
$pdf->SetFont('arial','',6);
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(85,4,"DÙvod","$rmc",0,"C");$pdf->Cell(80,4,"od - do","$rmc",0,"C");$pdf->Cell(25,4,"kal.dni","$rmc",1,"C");
$pdf->SetFont('arial','',8);
//dovod 5
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyldv5=$hlavicka->vyldv5;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyldv5","$rmc",0,"L");
//od 5
$vylod5=SkDatum($hlavicka->vylod5);
if ( $vylod5 == "00.00.0000" ) $vylod5="";
$pole = explode(".", $vylod5);
$vyloda=$pole[0];
$vylod1a=substr($vyloda,0,1);
$vylod2a=substr($vyloda,1,1);
$vylodb=$pole[1];
$vylod1b=substr($vylodb,0,1);
$vylod2b=substr($vylodb,1,1);
$vylodc=$pole[2];
$vylod1c=substr($vylodc,0,1);
$vylod2c=substr($vylodc,1,1);
$vylod3c=substr($vylodc,2,1);
$vylod4c=substr($vylodc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vylod1a","1",0,"C");$pdf->Cell(4,4,"$vylod2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vylod1b","1",0,"C");$pdf->Cell(4,4,"$vylod2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vylod1c","1",0,"C");$pdf->Cell(4,4,"$vylod2c","1",0,"C");$pdf->Cell(4,4,"$vylod3c","1",0,"C");$pdf->Cell(4,4,"$vylod4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 5
$vyldo5=SkDatum($hlavicka->vyldo5);
if ( $vyldo5 == "00.00.0000" ) $vyldo5="";
$pole = explode(".", $vyldo5);
$vyldoa=$pole[0];
$vyldo1a=substr($vyldoa,0,1);
$vyldo2a=substr($vyldoa,1,1);
$vyldob=$pole[1];
$vyldo1b=substr($vyldob,0,1);
$vyldo2b=substr($vyldob,1,1);
$vyldoc=$pole[2];
$vyldo1c=substr($vyldoc,0,1);
$vyldo2c=substr($vyldoc,1,1);
$vyldo3c=substr($vyldoc,2,1);
$vyldo4c=substr($vyldoc,3,1);
$pdf->Cell(4,4,"$vyldo1a","1",0,"C");$pdf->Cell(4,4,"$vyldo2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyldo1b","1",0,"C");$pdf->Cell(4,4,"$vyldo2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyldo1c","1",0,"C");$pdf->Cell(4,4,"$vyldo2c","1",0,"C");$pdf->Cell(4,4,"$vyldo3c","1",0,"C");$pdf->Cell(4,4,"$vyldo4c","1",0,"C");
//dni 5
$vyldni5=$hlavicka->vyldni5;
if ( $vyldni5 == 0 ) $vyldni5="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyldni5","$rmc",1,"R");

//dovod 6
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl2dv1=$hlavicka->vyl2dv1;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl2dv1","$rmc",0,"L");
//od 6
$vyl2od1=SkDatum($hlavicka->vyl2od1);
if ( $vyl2od1 == "00.00.0000" ) $vyl2od1="";
$pole = explode(".", $vyl2od1);
$vyl2oda=$pole[0];
$vyl2od1a=substr($vyl2oda,0,1);
$vyl2od2a=substr($vyl2oda,1,1);
$vyl2odb=$pole[1];
$vyl2od1b=substr($vyl2odb,0,1);
$vyl2od2b=substr($vyl2odb,1,1);
$vyl2odc=$pole[2];
$vyl2od1c=substr($vyl2odc,0,1);
$vyl2od2c=substr($vyl2odc,1,1);
$vyl2od3c=substr($vyl2odc,2,1);
$vyl2od4c=substr($vyl2odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1a","1",0,"C");$pdf->Cell(4,4,"$vyl2od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1b","1",0,"C");$pdf->Cell(4,4,"$vyl2od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1c","1",0,"C");$pdf->Cell(4,4,"$vyl2od2c","1",0,"C");$pdf->Cell(4,4,"$vyl2od3c","1",0,"C");$pdf->Cell(4,4,"$vyl2od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 6
$vyl2do1=SkDatum($hlavicka->vyl2do1);
if ( $vyl2do1 == "00.00.0000" ) $vyl2do1="";
$pole = explode(".", $vyl2do1);
$vyl2doa=$pole[0];
$vyl2do1a=substr($vyl2doa,0,1);
$vyl2do2a=substr($vyl2doa,1,1);
$vyl2dob=$pole[1];
$vyl2do1b=substr($vyl2dob,0,1);
$vyl2do2b=substr($vyl2dob,1,1);
$vyl2doc=$pole[2];
$vyl2do1c=substr($vyl2doc,0,1);
$vyl2do2c=substr($vyl2doc,1,1);
$vyl2do3c=substr($vyl2doc,2,1);
$vyl2do4c=substr($vyl2doc,3,1);
$pdf->Cell(4,4,"$vyl2do1a","1",0,"C");$pdf->Cell(4,4,"$vyl2do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1b","1",0,"C");$pdf->Cell(4,4,"$vyl2do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1c","1",0,"C");$pdf->Cell(4,4,"$vyl2do2c","1",0,"C");$pdf->Cell(4,4,"$vyl2do3c","1",0,"C");$pdf->Cell(4,4,"$vyl2do4c","1",0,"C");
//dni 6
$vyl2dni1=$hlavicka->vyl2dni1;
if ( $vyl2dni1 == 0 ) $vyl2dni1="";
$pdf->Cell(3,4," ","$rmc1",0,"C");$pdf->Cell(16,4,"$vyl2dni1","$rmc",1,"R");

//dovod 7
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl2dv2=$hlavicka->vyl2dv2;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl2dv2","$rmc",0,"L");
//od 7
$vyl2od2=SkDatum($hlavicka->vyl2od2);
if ( $vyl2od2 == "00.00.0000" ) $vyl2od2="";
$pole = explode(".", $vyl2od2);
$vyl2oda=$pole[0];
$vyl2od1a=substr($vyl2oda,0,1);
$vyl2od2a=substr($vyl2oda,1,1);
$vyl2odb=$pole[1];
$vyl2od1b=substr($vyl2odb,0,1);
$vyl2od2b=substr($vyl2odb,1,1);
$vyl2odc=$pole[2];
$vyl2od1c=substr($vyl2odc,0,1);
$vyl2od2c=substr($vyl2odc,1,1);
$vyl2od3c=substr($vyl2odc,2,1);
$vyl2od4c=substr($vyl2odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1a","1",0,"C");$pdf->Cell(4,4,"$vyl2od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1b","1",0,"C");$pdf->Cell(4,4,"$vyl2od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1c","1",0,"C");$pdf->Cell(4,4,"$vyl2od2c","1",0,"C");$pdf->Cell(4,4,"$vyl2od3c","1",0,"C");$pdf->Cell(4,4,"$vyl2od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 7
$vyl2do2=SkDatum($hlavicka->vyl2do2);
if ( $vyl2do2 == "00.00.0000" ) $vyl2do2="";
$pole = explode(".", $vyl2do2);
$vyl2doa=$pole[0];
$vyl2do1a=substr($vyl2doa,0,1);
$vyl2do2a=substr($vyl2doa,1,1);
$vyl2dob=$pole[1];
$vyl2do1b=substr($vyl2dob,0,1);
$vyl2do2b=substr($vyl2dob,1,1);
$vyl2doc=$pole[2];
$vyl2do1c=substr($vyl2doc,0,1);
$vyl2do2c=substr($vyl2doc,1,1);
$vyl2do3c=substr($vyl2doc,2,1);
$vyl2do4c=substr($vyl2doc,3,1);
$pdf->Cell(4,4,"$vyl2do1a","1",0,"C");$pdf->Cell(4,4,"$vyl2do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1b","1",0,"C");$pdf->Cell(4,4,"$vyl2do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1c","1",0,"C");$pdf->Cell(4,4,"$vyl2do2c","1",0,"C");
$pdf->Cell(4,4,"$vyl2do3c","1",0,"C");$pdf->Cell(4,4,"$vyl2do4c","1",0,"C");
//dni 7
$vyl2dni2=$hlavicka->vyl2dni2;
if ( $vyl2dni2 == 0 ) $vyl2dni2="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl2dni2","$rmc",1,"R");

//dovod 8
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl2dv3=$hlavicka->vyl2dv3;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl2dv3","$rmc",0,"L");
//od 8
$vyl2od3=SkDatum($hlavicka->vyl2od3);
if ( $vyl2od3 == "00.00.0000" ) $vyl2od3="";
$pole = explode(".", $vyl2od3);
$vyl2oda=$pole[0];
$vyl2od1a=substr($vyl2oda,0,1);
$vyl2od2a=substr($vyl2oda,1,1);
$vyl2odb=$pole[1];
$vyl2od1b=substr($vyl2odb,0,1);
$vyl2od2b=substr($vyl2odb,1,1);
$vyl2odc=$pole[2];
$vyl2od1c=substr($vyl2odc,0,1);
$vyl2od2c=substr($vyl2odc,1,1);
$vyl2od3c=substr($vyl2odc,2,1);
$vyl2od4c=substr($vyl2odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1a","1",0,"C");$pdf->Cell(4,4,"$vyl2od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1b","1",0,"C");$pdf->Cell(4,4,"$vyl2od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1c","1",0,"C");$pdf->Cell(4,4,"$vyl2od2c","1",0,"C");$pdf->Cell(4,4,"$vyl2od3c","1",0,"C");$pdf->Cell(4,4,"$vyl2od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 8
$vyl2do3=SkDatum($hlavicka->vyl2do3);
if ( $vyl2do3 == "00.00.0000" ) $vyl2do3="";
$pole = explode(".", $vyl2do3);
$vyl2doa=$pole[0];
$vyl2do1a=substr($vyl2doa,0,1);
$vyl2do2a=substr($vyl2doa,1,1);
$vyl2dob=$pole[1];
$vyl2do1b=substr($vyl2dob,0,1);
$vyl2do2b=substr($vyl2dob,1,1);
$vyl2doc=$pole[2];
$vyl2do1c=substr($vyl2doc,0,1);
$vyl2do2c=substr($vyl2doc,1,1);
$vyl2do3c=substr($vyl2doc,2,1);
$vyl2do4c=substr($vyl2doc,3,1);
$pdf->Cell(4,4,"$vyl2do1a","1",0,"C");$pdf->Cell(4,4,"$vyl2do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1b","1",0,"C");$pdf->Cell(4,4,"$vyl2do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1c","1",0,"C");$pdf->Cell(4,4,"$vyl2do2c","1",0,"C");$pdf->Cell(4,4,"$vyl2do3c","1",0,"C");$pdf->Cell(4,4,"$vyl2do4c","1",0,"C");
//dni 8
$vyl2dni3=$hlavicka->vyl2dni3;
if ( $vyl2dni3 == 0 ) $vyl2dni3="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl2dni3","$rmc",1,"R");

//dovod 9
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl2dv4=$hlavicka->vyl2dv4;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl2dv4","$rmc",0,"L");
//od 9
$vyl2od4=SkDatum($hlavicka->vyl2od4);
if ( $vyl2od4 == "00.00.0000" ) $vyl2od4="";
$pole = explode(".", $vyl2od4);
$vyl2oda=$pole[0];
$vyl2od1a=substr($vyl2oda,0,1);
$vyl2od2a=substr($vyl2oda,1,1);
$vyl2odb=$pole[1];
$vyl2od1b=substr($vyl2odb,0,1);
$vyl2od2b=substr($vyl2odb,1,1);
$vyl2odc=$pole[2];
$vyl2od1c=substr($vyl2odc,0,1);
$vyl2od2c=substr($vyl2odc,1,1);
$vyl2od3c=substr($vyl2odc,2,1);
$vyl2od4c=substr($vyl2odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1a","1",0,"C");$pdf->Cell(4,4,"$vyl2od2a","1",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1b","1",0,"L");$pdf->Cell(4,4,"$vyl2od2b","1",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1c","1",0,"C");$pdf->Cell(4,4,"$vyl2od2c","1",0,"C");$pdf->Cell(4,4,"$vyl2od3c","1",0,"C");$pdf->Cell(4,4,"$vyl2od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 9
$vyl2do4=SkDatum($hlavicka->vyl2do4);
if ( $vyl2do4 == "00.00.0000" ) $vyl2do4="";
$pole = explode(".", $vyl2do4);
$vyl2doa=$pole[0];
$vyl2do1a=substr($vyl2doa,0,1);
$vyl2do2a=substr($vyl2doa,1,1);
$vyl2dob=$pole[1];
$vyl2do1b=substr($vyl2dob,0,1);
$vyl2do2b=substr($vyl2dob,1,1);
$vyl2doc=$pole[2];
$vyl2do1c=substr($vyl2doc,0,1);
$vyl2do2c=substr($vyl2doc,1,1);
$vyl2do3c=substr($vyl2doc,2,1);
$vyl2do4c=substr($vyl2doc,3,1);
$pdf->Cell(4,4,"$vyl2do1a","1",0,"C");$pdf->Cell(4,4,"$vyl2do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1b","1",0,"C");$pdf->Cell(4,4,"$vyl2do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1c","1",0,"C");$pdf->Cell(4,4,"$vyl2do2c","1",0,"C");$pdf->Cell(4,4,"$vyl2do3c","1",0,"C");$pdf->Cell(4,4,"$vyl2do4c","1",0,"C");
//dni 9
$vyl2dni4=$hlavicka->vyl2dni4;
if ( $vyl2dni4 == 0 ) $vyl2dni4="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl2dni4","$rmc",1,"R");

//dovod 10
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl2dv5=$hlavicka->vyl2dv5;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl2dv5","$rmc",0,"L");
//od 10
$vyl2od5=SkDatum($hlavicka->vyl2od5);
if ( $vyl2od5 == "00.00.0000" ) $vyl2od5="";
$pole = explode(".", $vyl2od5);
$vyl2oda=$pole[0];
$vyl2od1a=substr($vyl2oda,0,1);
$vyl2od2a=substr($vyl2oda,1,1);
$vyl2odb=$pole[1];
$vyl2od1b=substr($vyl2odb,0,1);
$vyl2od2b=substr($vyl2odb,1,1);
$vyl2odc=$pole[2];
$vyl2od1c=substr($vyl2odc,0,1);
$vyl2od2c=substr($vyl2odc,1,1);
$vyl2od3c=substr($vyl2odc,2,1);
$vyl2od4c=substr($vyl2odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1a","1",0,"C");$pdf->Cell(4,4,"$vyl2od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1b","1",0,"C");$pdf->Cell(4,4,"$vyl2od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2od1c","1",0,"C");$pdf->Cell(4,4,"$vyl2od2c","1",0,"C");$pdf->Cell(4,4,"$vyl2od3c","1",0,"C");$pdf->Cell(4,4,"$vyl2od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 10
$vyl2do5=SkDatum($hlavicka->vyl2do5);
if ( $vyl2do5 == "00.00.0000" ) $vyl2do5="";
$pole = explode(".", $vyl2do5);
$vyl2doa=$pole[0];
$vyl2do1a=substr($vyl2doa,0,1);
$vyl2do2a=substr($vyl2doa,1,1);
$vyl2dob=$pole[1];
$vyl2do1b=substr($vyl2dob,0,1);
$vyl2do2b=substr($vyl2dob,1,1);
$vyl2doc=$pole[2];
$vyl2do1c=substr($vyl2doc,0,1);
$vyl2do2c=substr($vyl2doc,1,1);
$vyl2do3c=substr($vyl2doc,2,1);
$vyl2do4c=substr($vyl2doc,3,1);
$pdf->Cell(4,4,"$vyl2do1a","1",0,"C");$pdf->Cell(4,4,"$vyl2do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1b","1",0,"C");$pdf->Cell(4,4,"$vyl2do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl2do1c","1",0,"C");$pdf->Cell(4,4,"$vyl2do2c","1",0,"C");$pdf->Cell(4,4,"$vyl2do3c","1",0,"C");$pdf->Cell(4,4,"$vyl2do4c","1",0,"C");
//dni 10
$vyl2dni5=$hlavicka->vyl2dni5;
if ( $vyl2dni5 == 0 ) $vyl2dni5="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl2dni5","$rmc",1,"R");

//dovod 11
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl3dv1=$hlavicka->vyl3dv1;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl3dv1","$rmc",0,"L");
//od 11
$vyl3od1=SkDatum($hlavicka->vyl3od1);
if ( $vyl3od1 == "00.00.0000" ) $vyl3od1="";
$pole = explode(".", $vyl3od1);
$vyl3oda=$pole[0];
$vyl3od1a=substr($vyl3oda,0,1);
$vyl3od2a=substr($vyl3oda,1,1);
$vyl3odb=$pole[1];
$vyl3od1b=substr($vyl3odb,0,1);
$vyl3od2b=substr($vyl3odb,1,1);
$vyl3odc=$pole[2];
$vyl3od1c=substr($vyl3odc,0,1);
$vyl3od2c=substr($vyl3odc,1,1);
$vyl3od3c=substr($vyl3odc,2,1);
$vyl3od4c=substr($vyl3odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1a","1",0,"C");$pdf->Cell(4,4,"$vyl3od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1b","1",0,"C");$pdf->Cell(4,4,"$vyl3od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1c","1",0,"C");$pdf->Cell(4,4,"$vyl3od2c","1",0,"C");$pdf->Cell(4,4,"$vyl3od3c","1",0,"C");$pdf->Cell(4,4,"$vyl3od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 11
$vyl3do1=SkDatum($hlavicka->vyl3do1);
if ( $vyl3do1 == "00.00.0000" ) $vyl3do1="";
$pole = explode(".", $vyl3do1);
$vyl3doa=$pole[0];
$vyl3do1a=substr($vyl3doa,0,1);
$vyl3do2a=substr($vyl3doa,1,1);
$vyl3dob=$pole[1];
$vyl3do1b=substr($vyl3dob,0,1);
$vyl3do2b=substr($vyl3dob,1,1);
$vyl3doc=$pole[2];
$vyl3do1c=substr($vyl3doc,0,1);
$vyl3do2c=substr($vyl3doc,1,1);
$vyl3do3c=substr($vyl3doc,2,1);
$vyl3do4c=substr($vyl3doc,3,1);
$pdf->Cell(4,4,"$vyl3do1a","1",0,"C");$pdf->Cell(4,4,"$vyl3do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1b","1",0,"C");$pdf->Cell(4,4,"$vyl3do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1c","1",0,"C");$pdf->Cell(4,4,"$vyl3do2c","1",0,"C");$pdf->Cell(4,4,"$vyl3do3c","1",0,"C");$pdf->Cell(4,4,"$vyl3do4c","1",0,"C");
//dni 11
$vyl3dni1=$hlavicka->vyl3dni1;
if ( $vyl3dni1 == 0 ) $vyl3dni1="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl3dni1","$rmc",1,"R");

//dovod 12
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl3dv2=$hlavicka->vyl3dv2;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl3dv2","$rmc",0,"L");
//od 12
$vyl3od2=SkDatum($hlavicka->vyl3od2);
if ( $vyl3od2 == "00.00.0000" ) $vyl3od2="";
$pole = explode(".", $vyl3od2);
$vyl3oda=$pole[0];
$vyl3od1a=substr($vyl3oda,0,1);
$vyl3od2a=substr($vyl3oda,1,1);
$vyl3odb=$pole[1];
$vyl3od1b=substr($vyl3odb,0,1);
$vyl3od2b=substr($vyl3odb,1,1);
$vyl3odc=$pole[2];
$vyl3od1c=substr($vyl3odc,0,1);
$vyl3od2c=substr($vyl3odc,1,1);
$vyl3od3c=substr($vyl3odc,2,1);
$vyl3od4c=substr($vyl3odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1a","1",0,"C");$pdf->Cell(4,4,"$vyl3od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1b","1",0,"C");$pdf->Cell(4,4,"$vyl3od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1c","1",0,"C");$pdf->Cell(4,4,"$vyl3od2c","1",0,"C");$pdf->Cell(4,4,"$vyl3od3c","1",0,"C");$pdf->Cell(4,4,"$vyl3od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 12
$vyl3do2=SkDatum($hlavicka->vyl3do2);
if ( $vyl3do2 == "00.00.0000" ) $vyl3do2="";
$pole = explode(".", $vyl3do2);
$vyl3doa=$pole[0];
$vyl3do1a=substr($vyl3doa,0,1);
$vyl3do2a=substr($vyl3doa,1,1);
$vyl3dob=$pole[1];
$vyl3do1b=substr($vyl3dob,0,1);
$vyl3do2b=substr($vyl3dob,1,1);
$vyl3doc=$pole[2];
$vyl3do1c=substr($vyl3doc,0,1);
$vyl3do2c=substr($vyl3doc,1,1);
$vyl3do3c=substr($vyl3doc,2,1);
$vyl3do4c=substr($vyl3doc,3,1);
$pdf->Cell(4,4,"$vyl3do1a","1",0,"C");$pdf->Cell(4,4,"$vyl3do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1b","1",0,"C");$pdf->Cell(4,4,"$vyl3do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1c","1",0,"C");$pdf->Cell(4,4,"$vyl3do2c","1",0,"C");$pdf->Cell(4,4,"$vyl3do3c","1",0,"C");$pdf->Cell(4,4,"$vyl3do4c","1",0,"C");
//dni 12
$vyl3dni2=$hlavicka->vyl3dni2;
if ( $vyl3dni2 == 0 ) $vyl3dni2="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl3dni2","$rmc",1,"R");

//dovod 13
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl3dv3=$hlavicka->vyl3dv3;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl3dv3","$rmc",0,"L");
//od 13
$vyl3od3=SkDatum($hlavicka->vyl3od3);
if ( $vyl3od3 == "00.00.0000" ) $vyl3od3="";
$pole = explode(".", $vyl3od3);
$vyl3oda=$pole[0];
$vyl3od1a=substr($vyl3oda,0,1);
$vyl3od2a=substr($vyl3oda,1,1);
$vyl3odb=$pole[1];
$vyl3od1b=substr($vyl3odb,0,1);
$vyl3od2b=substr($vyl3odb,1,1);
$vyl3odc=$pole[2];
$vyl3od1c=substr($vyl3odc,0,1);
$vyl3od2c=substr($vyl3odc,1,1);
$vyl3od3c=substr($vyl3odc,2,1);
$vyl3od4c=substr($vyl3odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1a","1",0,"C");$pdf->Cell(4,4,"$vyl3od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1b","1",0,"C");$pdf->Cell(4,4,"$vyl3od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1c","1",0,"C");$pdf->Cell(4,4,"$vyl3od2c","1",0,"C");$pdf->Cell(4,4,"$vyl3od3c","1",0,"C");$pdf->Cell(4,4,"$vyl3od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 13
$vyl3do3=SkDatum($hlavicka->vyl3do3);
if ( $vyl3do3 == "00.00.0000" ) $vyl3do3="";
$pole = explode(".", $vyl3do3);
$vyl3doa=$pole[0];
$vyl3do1a=substr($vyl3doa,0,1);
$vyl3do2a=substr($vyl3doa,1,1);
$vyl3dob=$pole[1];
$vyl3do1b=substr($vyl3dob,0,1);
$vyl3do2b=substr($vyl3dob,1,1);
$vyl3doc=$pole[2];
$vyl3do1c=substr($vyl3doc,0,1);
$vyl3do2c=substr($vyl3doc,1,1);
$vyl3do3c=substr($vyl3doc,2,1);
$vyl3do4c=substr($vyl3doc,3,1);
$pdf->Cell(4,4,"$vyl3do1a","1",0,"C");$pdf->Cell(4,4,"$vyl3do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1b","1",0,"C");$pdf->Cell(4,4,"$vyl3do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1c","1",0,"C");$pdf->Cell(4,4,"$vyl3do2c","1",0,"C");$pdf->Cell(4,4,"$vyl3do3c","1",0,"C");$pdf->Cell(4,4,"$vyl3do4c","1",0,"C");
//dni 13
$vyl3dni3=$hlavicka->vyl3dni3;
if ( $vyl3dni3 == 0 ) $vyl3dni3="";
$pdf->Cell(3,4," ","$rmc",0,"L");$pdf->Cell(16,4,"$vyl3dni3","$rmc",1,"R");

//dovod 14
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl3dv4=$hlavicka->vyl3dv4;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl3dv4","$rmc",0,"L");
//od 14
$vyl3od4=SkDatum($hlavicka->vyl3od4);
if ( $vyl3od4 == "00.00.0000" ) $vyl3od4="";
$pole = explode(".", $vyl3od4);
$vyl3oda=$pole[0];
$vyl3od1a=substr($vyl3oda,0,1);
$vyl3od2a=substr($vyl3oda,1,1);
$vyl3odb=$pole[1];
$vyl3od1b=substr($vyl3odb,0,1);
$vyl3od2b=substr($vyl3odb,1,1);
$vyl3odc=$pole[2];
$vyl3od1c=substr($vyl3odc,0,1);
$vyl3od2c=substr($vyl3odc,1,1);
$vyl3od3c=substr($vyl3odc,2,1);
$vyl3od4c=substr($vyl3odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1a","1",0,"C");$pdf->Cell(4,4,"$vyl3od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1b","1",0,"C");$pdf->Cell(4,4,"$vyl3od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1c","1",0,"C");$pdf->Cell(4,4,"$vyl3od2c","1",0,"C");$pdf->Cell(4,4,"$vyl3od3c","1",0,"C");$pdf->Cell(4,4,"$vyl3od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 14
$vyl3do4=SkDatum($hlavicka->vyl3do4);
if ( $vyl3do4 == "00.00.0000" ) $vyl3do4="";
$pole = explode(".", $vyl3do4);
$vyl3doa=$pole[0];
$vyl3do1a=substr($vyl3doa,0,1);
$vyl3do2a=substr($vyl3doa,1,1);
$vyl3dob=$pole[1];
$vyl3do1b=substr($vyl3dob,0,1);
$vyl3do2b=substr($vyl3dob,1,1);
$vyl3doc=$pole[2];
$vyl3do1c=substr($vyl3doc,0,1);
$vyl3do2c=substr($vyl3doc,1,1);
$vyl3do3c=substr($vyl3doc,2,1);
$vyl3do4c=substr($vyl3doc,3,1);
$pdf->Cell(4,4,"$vyl3do1a","1",0,"C");$pdf->Cell(4,4,"$vyl3do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1b","1",0,"C");$pdf->Cell(4,4,"$vyl3do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1c","1",0,"C");$pdf->Cell(4,4,"$vyl3do2c","1",0,"C");$pdf->Cell(4,4,"$vyl3do3c","1",0,"C");$pdf->Cell(4,4,"$vyl3do4c","1",0,"C");
//dni 14
$vyl3dni4=$hlavicka->vyl3dni4;
if ( $vyl3dni4 == 0 ) $vyl3dni4="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl3dni4","$rmc",1,"R");

//dovod 15
$pdf->Cell(190,1," ","$rmc1",1,"L");
$vyl3dv5=$hlavicka->vyl3dv5;
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(83,4,"$vyl3dv5","$rmc",0,"L");
//od 15
$vyl3od5=SkDatum($hlavicka->vyl3od5);
if ( $vyl3od5 == "00.00.0000" ) $vyl3od5="";
$pole = explode(".", $vyl3od5);
$vyl3oda=$pole[0];
$vyl3od1a=substr($vyl3oda,0,1);
$vyl3od2a=substr($vyl3oda,1,1);
$vyl3odb=$pole[1];
$vyl3od1b=substr($vyl3odb,0,1);
$vyl3od2b=substr($vyl3odb,1,1);
$vyl3odc=$pole[2];
$vyl3od1c=substr($vyl3odc,0,1);
$vyl3od2c=substr($vyl3odc,1,1);
$vyl3od3c=substr($vyl3odc,2,1);
$vyl3od4c=substr($vyl3odc,3,1);
$pdf->Cell(3,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1a","1",0,"C");$pdf->Cell(4,4,"$vyl3od2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1b","1",0,"C");$pdf->Cell(4,4,"$vyl3od2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3od1c","1",0,"C");$pdf->Cell(4,4,"$vyl3od2c","1",0,"C");$pdf->Cell(4,4,"$vyl3od3c","1",0,"C");$pdf->Cell(4,4,"$vyl3od4c","1",0,"C");
$pdf->Cell(6,4,"-","$rmc1",0,"C");
//do 15
$vyl3do5=SkDatum($hlavicka->vyl3do5);
if ( $vyl3do5 == "00.00.0000" ) $vyl3do5="";
$pole = explode(".", $vyl3do5);
$vyl3doa=$pole[0];
$vyl3do1a=substr($vyl3doa,0,1);
$vyl3do2a=substr($vyl3doa,1,1);
$vyl3dob=$pole[1];
$vyl3do1b=substr($vyl3dob,0,1);
$vyl3do2b=substr($vyl3dob,1,1);
$vyl3doc=$pole[2];
$vyl3do1c=substr($vyl3doc,0,1);
$vyl3do2c=substr($vyl3doc,1,1);
$vyl3do3c=substr($vyl3doc,2,1);
$vyl3do4c=substr($vyl3doc,3,1);
$pdf->Cell(4,4,"$vyl3do1a","1",0,"C");$pdf->Cell(4,4,"$vyl3do2a","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1b","1",0,"C");$pdf->Cell(4,4,"$vyl3do2b","1",0,"C");$pdf->Cell(1,4," ","$rmc1",0,"L");
$pdf->Cell(4,4,"$vyl3do1c","1",0,"C");$pdf->Cell(4,4,"$vyl3do2c","1",0,"C");$pdf->Cell(4,4,"$vyl3do3c","1",0,"C");$pdf->Cell(4,4,"$vyl3do4c","1",0,"C");
//dni 15
$vyl3dni5=$hlavicka->vyl3dni5;
if ( $vyl3dni5 == 0 ) $vyl3dni5="";
$pdf->Cell(3,4," ","$rmc1",0,"L");$pdf->Cell(16,4,"$vyl3dni5","$rmc",1,"R");

//doplnujuci text
$pdf->Cell(190,10," ","$rmc1",1,"L");
$ipole=1;
foreach( $polestr2 as $hodnota )
{
$pdf->Cell(190,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
}
$pdf->Cell(190,2," ","$rmc1",1,"L");

//Vyhlasujem 2
$pdf->SetY(244);
$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(37,5,"$fir_fmes","$rmc",0,"C");
$datum=SkDatum($hlavicka->datum);
if ( $datum == "00.00.0000" ) $datum="";
$pdf->Cell(6,5,"dÚa","$rmc1",0,"C");$pdf->Cell(20,5,"$datum","$rmc",1,"L");
$pdf->Cell(110,5,"","$rmc1",0,"R");$pdf->Cell(75,5,"podpis a odtlaËok peËiatky zamestn·vateæa","T",0,"C");
$pdf->Cell(5,4," ","$rmc1",1,"L");
                    }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/potvrdenieFO.$kli_uzid.pdf");
?>

<script type="text/javascript">
 var okno = window.open("../tmp/potvrdenieFO.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>