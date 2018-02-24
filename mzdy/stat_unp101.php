<!doctype html>
<html>
<?php
//celkovy zaciatok
do
{
$sys = 'MZD';
$urov = 2000;
$drupoh = $_REQUEST['drupoh'];
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;

//.jpg source
$jpg_source="../dokumenty/statistika2016/unp101/unp101_v16";
$jpg_title="tlaËivo RoËn˝ v˝kaz o ˙pln˝ch n·kladoch pr·ce ⁄NP 1-01 pre rok $kli_vrok $strana.strana";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//vytvor tabulku v databaze
$sql = "SELECT konx8 FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_unp101';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(80) not null,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_unp101'.$sqlt;
$vytvor = mysql_query("$vsql");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_unp101 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}

$sql = "SELECT s2r099 FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r001 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r002 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r003 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r004 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r005 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r006 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r007 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r008 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r009 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r010 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r011 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r012 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r013 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s1r014 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r015 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r016 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r017 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r018 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r019 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r020 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r021 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r022 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r023 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r024 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r025 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r026 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r027 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r028 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r029 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r030 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r031 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r032 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r033 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r034 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r035 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r036 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r037 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r038 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r039 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r040 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r041 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r042 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r043 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r044 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r045 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r046 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r047 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r048 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r049 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r050 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r051 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r052 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r053 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r054 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r055 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r056 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r057 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r058 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r059 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r060 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r061 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r062 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r063 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r064 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r065 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r066 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r067 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r099 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT okres FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD okres DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_unp101 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD odoslane DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT xxxx FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r001 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r002 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r003 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r004 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r005 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s1r006 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 MODIFY s2r099 DECIMAL(10,1) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
}
//new 2016
$sql = "SELECT s2r068 FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD new2016 DECIMAL(2,0) DEFAULT 0 AFTER ico ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_unp101 ADD s2r068 DECIMAL(10,0) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
}
//koniec vytvor tabulku v databaze


//zapis do statistickej TABLE a prepni do stat zostavy
if ( $copern == 200 )
{
$h_mfir = 1*strip_tags($_REQUEST['h_mfir']);
$vyb_ume = strip_tags($_REQUEST['vyb_ume']);
$pole = explode(".", $vyb_ume);
$vyb_ump="1.".$pole[1];
$vyb_umk="12.".$pole[1];

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
   pocet        DECIMAL(10,0) DEFAULT 0,
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

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh, zena=SUBSTRING(rodc,3,2) ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

/////////////NACITANIE prac.uvazku standardneho
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
"dm,dni,hod,kc,0,uvap,0,$fir_fico".
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

$r01=0; $r01a=0; $r01b=0; $r01c=0; $r01d=0; $r01e=0; $r01f=0; $skrat=0;
        $r01g=0; $r01h=0; $r01i=0; $r01j=0; $r01k=0; $r01l=0;
$vyb_um1="01.".$kli_vrok;
$vyb_um3="03.".$kli_vrok;
$vyb_um5="05.".$kli_vrok;
$vyb_um7="07.".$kli_vrok;
$vyb_um9="09.".$kli_vrok;
$vyb_um12="12.".$kli_vrok;
$vyb_um2="02.".$kli_vrok;
$vyb_um4="04.".$kli_vrok;
$vyb_um6="06.".$kli_vrok;
$vyb_um8="08.".$kli_vrok;
$vyb_um10="10.".$kli_vrok;
$vyb_um11="11.".$kli_vrok;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 993 AND skrat = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $skrat=$skrat+1; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um1 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01a=$r01a+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um3 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01b=$r01b+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um5 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01c=$r01c+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um7 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01d=$r01d+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um9 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01e=$r01e+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01f=$r01f+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um2 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01g=$r01g+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um4 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01h=$r01h+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um6 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01i=$r01i+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um8 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01j=$r01j+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um10 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01k=$r01k+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = $vyb_um11 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01l=$r01l+$polozka->pocet; }
$i=$i+1;                   }


$r01=($r01a+$r01b+$r01c+$r01d+$r01e+$r01f+$r01g+$r01h+$r01i+$r01j+$r01k+$r01l)/12;
$r03=$skrat;

$r04=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+($polozka->pocet*$polozka->uvap); }
$i=$i+1;                   }


$r04=($r04)/12;

//hodiny a eur odpracovane

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdkun SET ".
" uvax=uva ".
" WHERE F$kli_vxcf"."_statprac.oc = F$kli_vxcf"."_mzdkun.oc";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET uvap=uvax/$uva_hod ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET skrat=1 WHERE uvap < 0.8 ";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 555,oc,ume,rodc,zena,pom,dhpom,pocet, ".
"dm,SUM(dni),SUM(hod),SUM(kc),0,0,skrat,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom,oc,dm";
$dsql = mysql_query("$dsqlt");

$r07=0; $r09=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->hod; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 ) AND skrat = 1 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09=$r09+$polozka->hod; }
$i=$i+1;                   }

//hodiny a eur platene

$r11=0; $r13=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ".
" ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 OR ( dm > 500 AND dm < 599 AND kc > 0 ) )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11=$r11+$polozka->hod; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ".
" ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 OR ( dm > 500 AND dm < 599 AND kc > 0 ) ) AND skrat = 1 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r13=$r13+$polozka->hod; }
$i=$i+1;                   }

$r15=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 100 AND dm < 199 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r15=$r15+$polozka->kc;  }
$i=$i+1;                   }

$r17=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 201 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r17=$r17+$polozka->kc;  }
$i=$i+1;                   }


$r18=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 300 AND dm < 399 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r18=$r18+$polozka->kc; }
$i=$i+1;                   }

$r20=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm = 301 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r20=$r20+$polozka->kc; }
$i=$i+1;                   }


$r21=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 200 AND dm < 299 AND dm != 201 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r21=$r21+$polozka->kc; }
$i=$i+1;                   }

$r23=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 400 AND dm < 499 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r23=$r23+$polozka->kc; }
$i=$i+1;                   }

$r25=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 500 AND dm < 599 AND dm != 529 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r25=$r25+$polozka->kc; }
$i=$i+1;                   }

$r27=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm = 506 OR dm = 507 OR dm = 508 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r27=$r27+$polozka->kc; }
$i=$i+1;                   }

$r29=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 510 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r29=$r29+$polozka->kc; }
$i=$i+1;                   }

$r31=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND dm = 209 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r31=$r31+$polozka->kc; }
$i=$i+1;                   }

//SP,ZP zamestnavatel

$r41=0; $r42=0; $r43=0; $r44=0; $r45=0; $r46=0; $r47=0; $r49=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdzalsum WHERE oc > 0 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql);
$r41=$r41+$polozka->ofir_sp; $r42=$r42+$polozka->ofir_ip; $r43=$r43+$polozka->ofir_up; $r44=$r44+$polozka->ofir_np; $r45=$r45+$polozka->ofir_zp;
$r46=$r46+$polozka->ofir_pn; $r47=$r47+$polozka->ofir_gf+$polozka->ofir_rf; $r49=$r49+$polozka->ddp_fir;
                                       }
$i=$i+1;                   }

$r51=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm = 130 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r51=$r51+$polozka->kc; }
$i=$i+1;                   }

$r52=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm = 803 OR dm = 804 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r52=$r52+$polozka->kc; }
$i=$i+1;                   }

//zapis do statistiky
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s1r001='$r01', s1r002='$r02', s1r003='$r03', s1r004='$r04', s1r005='$r05', s1r006='$r06', s1r007='$r07', s1r008='$r08', s1r009='$r09', ".
" s1r010='$r10', s1r011='$r11', s1r012='$r12', s1r013='$r13', s1r014='$r14', ".
" s2r015='$r15', s2r016='$r16', s2r017='$r17', s2r018='$r18', s2r019='$r19', s2r020='$r20', s2r021='$r21', s2r022='$r22', s2r023='$r23', ".
" s2r024='$r24', s2r025='$r25', s2r026='$r26', s2r027='$r27', s2r028='$r28', s2r029='$r29', s2r030='$r30', s2r031='$r31', s2r032='$r32', s2r033='$r33', ".
" s2r034='$r34', s2r035='$r35', s2r036='$r36', s2r037='$r37', s2r038='$r38', s2r039='$r39', s2r040='$r40', s2r041='$r41', s2r042='$r42', s2r043='$r43', ".
" s2r044='$r44', s2r045='$r45', s2r046='$r46', s2r047='$r47', s2r048='$r48', s2r049='$r49', s2r050='$r50', s2r051='$r51', s2r052='$r52', s2r053='$r53', ".
" s2r054='$r54', s2r055='$r55', s2r056='$r56', s2r057='$r57', s2r058='$r58', s2r059='$r59', s2r060='$r60', s2r061='$r61', s2r062='$r62', s2r063='$r63', ".
" s2r064='$r64', s2r065='$r65', s2r066='$r66', s2r067='$r67', s2r099='$r99', ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s1r002=s1r001-s1r003, s1r008=s1r007-s1r009, s1r012=s1r011-s1r013, ".
" s2r016=s2r015-s2r017, s2r019=s2r018-s2r020, ".
" s2r048=s2r049, s2r050=s2r051+s2r052, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//koniec vypoctov
//exit;

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");
?>
<script type="text/javascript">
 window.open('stat_unp101.php?copern=1&drupoh=1&page=1&strana=<?php echo $strana; ?>', '_self')
</script>
<?php
}
//koniec copern=200 nacitaj statistiku z miezd


//zapis upravene udaje
if ( $copern == 3 )
     {
$cinnost = strip_tags($_REQUEST['cinnost']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);
$s1r001 = strip_tags($_REQUEST['s1r001']);
$s1r002 = strip_tags($_REQUEST['s1r002']);
$s1r003 = strip_tags($_REQUEST['s1r003']);
$s1r004 = strip_tags($_REQUEST['s1r004']);
$s1r005 = strip_tags($_REQUEST['s1r005']);
$s1r006 = strip_tags($_REQUEST['s1r006']);
$s1r007 = strip_tags($_REQUEST['s1r007']);
$s1r008 = strip_tags($_REQUEST['s1r008']);
$s1r009 = strip_tags($_REQUEST['s1r009']);
$s1r010 = strip_tags($_REQUEST['s1r010']);
$s1r011 = strip_tags($_REQUEST['s1r011']);
$s1r012 = strip_tags($_REQUEST['s1r012']);
$s1r013 = strip_tags($_REQUEST['s1r013']);
$s1r014 = strip_tags($_REQUEST['s1r014']);
$s2r015 = strip_tags($_REQUEST['s2r015']);
$s2r016 = strip_tags($_REQUEST['s2r016']);
$s2r017 = strip_tags($_REQUEST['s2r017']);
$s2r018 = strip_tags($_REQUEST['s2r018']);
$s2r019 = strip_tags($_REQUEST['s2r019']);
$s2r020 = strip_tags($_REQUEST['s2r020']);
$s2r021 = strip_tags($_REQUEST['s2r021']);
$s2r022 = strip_tags($_REQUEST['s2r022']);
$s2r023 = strip_tags($_REQUEST['s2r023']);
$s2r024 = strip_tags($_REQUEST['s2r024']);
$s2r025 = strip_tags($_REQUEST['s2r025']);
$s2r026 = strip_tags($_REQUEST['s2r026']);
$s2r027 = strip_tags($_REQUEST['s2r027']);
$s2r028 = strip_tags($_REQUEST['s2r028']);
$s2r029 = strip_tags($_REQUEST['s2r029']);
$s2r030 = strip_tags($_REQUEST['s2r030']);
$s2r031 = strip_tags($_REQUEST['s2r031']);
$s2r032 = strip_tags($_REQUEST['s2r032']);
$s2r033 = strip_tags($_REQUEST['s2r033']);
$s2r034 = strip_tags($_REQUEST['s2r034']);
$s2r035 = strip_tags($_REQUEST['s2r035']);
$s2r036 = strip_tags($_REQUEST['s2r036']);
$s2r037 = strip_tags($_REQUEST['s2r037']);
$s2r038 = strip_tags($_REQUEST['s2r038']);
$s2r039 = strip_tags($_REQUEST['s2r039']);
$s2r040 = strip_tags($_REQUEST['s2r040']);
$s2r041 = strip_tags($_REQUEST['s2r041']);
$s2r042 = strip_tags($_REQUEST['s2r042']);
$s2r043 = strip_tags($_REQUEST['s2r043']);
$s2r044 = strip_tags($_REQUEST['s2r044']);
$s2r045 = strip_tags($_REQUEST['s2r045']);
$s2r046 = strip_tags($_REQUEST['s2r046']);
$s2r047 = strip_tags($_REQUEST['s2r047']);
$s2r048 = strip_tags($_REQUEST['s2r048']);
$s2r049 = strip_tags($_REQUEST['s2r049']);
$s2r050 = strip_tags($_REQUEST['s2r050']);
$s2r051 = strip_tags($_REQUEST['s2r051']);
$s2r052 = strip_tags($_REQUEST['s2r052']);
$s2r053 = strip_tags($_REQUEST['s2r053']);
$s2r054 = strip_tags($_REQUEST['s2r054']);
$s2r055 = strip_tags($_REQUEST['s2r055']);
$s2r056 = strip_tags($_REQUEST['s2r056']);
$s2r057 = strip_tags($_REQUEST['s2r057']);
$s2r058 = strip_tags($_REQUEST['s2r058']);
$s2r059 = strip_tags($_REQUEST['s2r059']);
$s2r060 = strip_tags($_REQUEST['s2r060']);
$s2r061 = strip_tags($_REQUEST['s2r061']);
$s2r062 = strip_tags($_REQUEST['s2r062']);
$s2r063 = strip_tags($_REQUEST['s2r063']);
$s2r064 = strip_tags($_REQUEST['s2r064']);
$s2r065 = strip_tags($_REQUEST['s2r065']);
$s2r066 = strip_tags($_REQUEST['s2r066']);
$s2r067 = strip_tags($_REQUEST['s2r067']);
$s2r068 = strip_tags($_REQUEST['s2r068']);
$s2r099 = strip_tags($_REQUEST['s2r099']);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" cinnost='$cinnost', odoslane='$odoslane_sql', ".
" konx8=0 ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s1r001='$s1r001', s1r002='$s1r002', s1r003='$s1r003', s1r004='$s1r004', ".
" s1r005='$s1r005', s1r006='$s1r006', s1r007='$s1r007', s1r008='$s1r008', ".
" s1r009='$s1r009', s1r010='$s1r010', s1r011='$s1r011', s1r012='$s1r012', ".
" s1r013='$s1r013', s1r014='$s1r014', s2r015='$s2r015', s2r016='$s2r016', ".
" s2r017='$s2r017', s2r018='$s2r018', s2r019='$s2r019', s2r020='$s2r020', ".
" s2r021='$s2r021', s2r022='$s2r022', s2r023='$s2r023', s2r024='$s2r024', ".
" s2r025='$s2r025', s2r026='$s2r026', s2r027='$s2r027', s2r028='$s2r028', ".
" s2r029='$s2r029', s2r030='$s2r030', s2r031='$s2r031', s2r032='$s2r032', ".
" s2r033='$s2r033', s2r034='$s2r034', s2r035='$s2r035', s2r036='$s2r036', ".
" konx8=0 ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r037='$s2r037', ".
" s2r038='$s2r038', s2r039='$s2r039', s2r040='$s2r040', s2r041='$s2r041', ".
" s2r042='$s2r042', s2r043='$s2r043', s2r044='$s2r044', s2r045='$s2r045', ".
" s2r046='$s2r046', s2r047='$s2r047', s2r048='$s2r048', s2r049='$s2r049', ".
" s2r050='$s2r050', s2r051='$s2r051', s2r052='$s2r052', s2r053='$s2r053', ".
" s2r054='$s2r054', s2r055='$s2r055', s2r056='$s2r056', s2r057='$s2r057', ".
" s2r058='$s2r058', s2r059='$s2r059', s2r060='$s2r060', s2r061='$s2r061', ".
" s2r062='$s2r062', s2r063='$s2r063', s2r064='$s2r064', s2r065='$s2r065', ".
" s2r066='$s2r066', s2r067='$s2r067', s2r068='$s2r068', s2r099='$s2r099', ".
" konx8=0 ".
" WHERE ico >= 0 ";
                    }
$upravene = mysql_query("$uprtxt");
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }


//vypocty
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r024=s2r015+s2r018+s2r021+s2r022+s2r023, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r040=s2r041+s2r042+s2r043+s2r044+s2r045+s2r046+s2r047, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r039=s2r024+s2r025+s2r030+s2r031+s2r032+s2r033+s2r038, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r060=s2r039+s2r040+s2r048+s2r050+s2r055+s2r056, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r065=s2r040+s2r048+s2r050+s2r055+s2r056+s2r061+s2r062+s2r063, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r067=s2r039+s2r065-s2r066, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET ".
" s2r099=s1r001+s1r002+s1r003+s1r004+s1r005+s1r006+s1r007+s1r008+s1r009+s1r010+s1r011+s1r012+s1r013+s1r014+s2r015+s2r016+s2r017+s2r018+s2r019+s2r020".
"+s2r021+s2r022+s2r023+s2r024+s2r025+s2r026+s2r027+s2r028+s2r029+s2r030".
"+s2r031+s2r032+s2r033+s2r034+s2r035+s2r036+s2r037+s2r038+s2r039+s2r040".
"+s2r041+s2r042+s2r043+s2r044+s2r045+s2r046+s2r047+s2r048+s2r049+s2r050".
"+s2r051+s2r052+s2r053+s2r054+s2r055+s2r056+s2r057+s2r058+s2r059+s2r060".
"+s2r061+s2r062+s2r063+s2r064+s2r065+s2r066+s2r067+s2r068, ".
" konx8=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//koniec vypocty

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_unp101 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$cinnost = $fir_riadok->cinnost;
$okres = $fir_riadok->okres;
$odoslane_sk = SkDatum($fir_riadok->odoslane);
$s1r001 = $fir_riadok->s1r001;
$s1r002 = $fir_riadok->s1r002;
$s1r003 = $fir_riadok->s1r003;
$s1r004 = $fir_riadok->s1r004;
$s1r005 = $fir_riadok->s1r005;
$s1r006 = $fir_riadok->s1r006;
$s1r007 = $fir_riadok->s1r007;
$s1r008 = $fir_riadok->s1r008;
$s1r009 = $fir_riadok->s1r009;
$s1r010 = $fir_riadok->s1r010;
$s1r011 = $fir_riadok->s1r011;
$s1r012 = $fir_riadok->s1r012;
$s1r013 = $fir_riadok->s1r013;
$s1r014 = $fir_riadok->s1r014;

$s2r015 = $fir_riadok->s2r015;
$s2r016 = $fir_riadok->s2r016;
$s2r017 = $fir_riadok->s2r017;
$s2r018 = $fir_riadok->s2r018;
$s2r019 = $fir_riadok->s2r019;
$s2r020 = $fir_riadok->s2r020;
$s2r021 = $fir_riadok->s2r021;
$s2r022 = $fir_riadok->s2r022;
$s2r023 = $fir_riadok->s2r023;
$s2r024 = $fir_riadok->s2r024;
$s2r025 = $fir_riadok->s2r025;
$s2r026 = $fir_riadok->s2r026;
$s2r027 = $fir_riadok->s2r027;
$s2r028 = $fir_riadok->s2r028;
$s2r029 = $fir_riadok->s2r029;
$s2r030 = $fir_riadok->s2r030;
$s2r031 = $fir_riadok->s2r031;
$s2r032 = $fir_riadok->s2r032;
$s2r033 = $fir_riadok->s2r033;
$s2r034 = $fir_riadok->s2r034;
$s2r035 = $fir_riadok->s2r035;
$s2r036 = $fir_riadok->s2r036;
$s2r037 = $fir_riadok->s2r037;
$s2r038 = $fir_riadok->s2r038;
$s2r039 = $fir_riadok->s2r039;
$s2r040 = $fir_riadok->s2r040;
$s2r041 = $fir_riadok->s2r041;
$s2r042 = $fir_riadok->s2r042;
$s2r043 = $fir_riadok->s2r043;
$s2r044 = $fir_riadok->s2r044;
$s2r045 = $fir_riadok->s2r045;
$s2r046 = $fir_riadok->s2r046;
$s2r047 = $fir_riadok->s2r047;
$s2r048 = $fir_riadok->s2r048;
$s2r049 = $fir_riadok->s2r049;
$s2r050 = $fir_riadok->s2r050;
$s2r051 = $fir_riadok->s2r051;
$s2r052 = $fir_riadok->s2r052;
$s2r053 = $fir_riadok->s2r053;
$s2r054 = $fir_riadok->s2r054;
$s2r055 = $fir_riadok->s2r055;
$s2r056 = $fir_riadok->s2r056;
$s2r057 = $fir_riadok->s2r057;
$s2r058 = $fir_riadok->s2r058;
$s2r059 = $fir_riadok->s2r059;
$s2r060 = $fir_riadok->s2r060;
$s2r061 = $fir_riadok->s2r061;
$s2r062 = $fir_riadok->s2r062;
$s2r063 = $fir_riadok->s2r063;
$s2r064 = $fir_riadok->s2r064;
$s2r065 = $fir_riadok->s2r065;
$s2r066 = $fir_riadok->s2r066;
$s2r067 = $fir_riadok->s2r067;
$s2r068 = $fir_riadok->s2r068;
$s2r099 = $fir_riadok->s2r099;
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//kod okresu, DRVLST z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  $drvlst=1*$riaddok->vlastnic;
  }

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//2-miestny rok
$kli_vrokx = substr($kli_vrok,2,2);

//sknace bez bodiek
$sknace=str_replace(".", "", $fir_sknace);
?>
<head>
<meta charset="cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v˝kaz ⁄NP 1-01</title>
<style type="text/css">
img.btn-row-tool {
  width: 18px;
  height: 18px;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
.bg-white {
  background-color: white;
  border-radius: 2px;
}
</style>
</head>
<body onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern != 11 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">RoËn˝ v˝kaz o ˙pln˝ch n·kladoch pr·ce
<?php if ( $copern == 110 ) { ?><span class="subheader">/ export xml</span><?php } ?>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="FormMetod();" title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
<?php if ( $copern != 110 ) { ?>
    <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMzdy();" title="NaËÌtaù ˙daje z miezd" class="btn-form-tool">
    <img src="../obr/ikony/upbox_blue_icon.png" onclick="FormXML();" title="Export do XML" class="btn-form-tool">
<?php } ?>
    <img src="../obr/ikony/printer_blue_icon.png" onclick="FormPDF(9999);" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<div id="content">
<?php
//uprav udaje
if ( $copern == 1 )
     {
?>
<form name="formv1" method="post" action="stat_unp101.php?copern=3&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="stat_unp101.php";
?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
<!-- hidden
  <a href="#" onclick="FormPDF(3);" class="<?php echo $clas3; ?> toright">3</a>
  <a href="#" onclick="FormPDF(2);" class="<?php echo $clas2; ?> toright">2</a>
  <a href="#" onclick="FormPDF(1);" class="<?php echo $clas1; ?> toright">1</a>
  <h6 class="toright">TlaËiù:</h6>
-->
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:216px; left:480px; font-size:24px; letter-spacing:0.02em;"><?php echo $kli_vrok; ?></span>
<span class="text-echo" style="top:319px; left:196px; font-size:18px; letter-spacing:24px;"><?php echo $kli_vrokx; ?></span>
<span class="text-echo" style="top:319px; left:263px; font-size:18px; letter-spacing:25px;">12</span>
<span class="text-echo" style="top:319px; left:332px; font-size:18px; letter-spacing:24px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:840px; left:54px;"><?php echo "$fir_fnaz $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:840px; left:815px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:838px; left:846px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:930px; left:54px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:930px; left:400px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:975px; left:54px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:975px; left:400px;"/>

<!-- modul 100231 -->
<span class="text-echo" style="top:1160px; left:403px;"><?php echo $sknace; ?></span>
<span class="text-echo" style="top:1160px; left:547px;"><?php echo $okres; ?></span>
<span class="text-echo" style="top:1160px; left:690px;"><?php echo $drvlst; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastaviù kÛd DRVLST" class="btn-row-tool" style="top:1160px; left:705px;">
<span class="text-echo" style="top:1160px; left:820px;"><?php echo $fir_uctt03; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="UdajeFirma();" title="Nastaviù kÛd FORMA" class="btn-row-tool" style="top:1160px; left:852px;">
<input type="text" name="cinnost" id="cinnost" style="width:460px; top:1190px; left:435px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<!-- modul 378 -->
<!-- cast A -->
<input type="text" name="s1r001" id="s1r001" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:185px; left:700px;"/>
<input type="text" name="s1r002" id="s1r002" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:216px; left:700px;"/>
<input type="text" name="s1r003" id="s1r003" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:242px; left:700px;"/>
<input type="text" name="s1r004" id="s1r004" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:275px; left:700px;"/>
<input type="text" name="s1r005" id="s1r005" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:311px; left:700px;"/>
<input type="text" name="s1r006" id="s1r006" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:347px; left:700px;"/>
<!-- cast B -->
<input type="text" name="s1r007" id="s1r007" style="width:100px; top:393px; left:700px;"/>
<input type="text" name="s1r008" id="s1r008" style="width:100px; top:438px; left:700px;"/>
<input type="text" name="s1r009" id="s1r009" style="width:100px; top:475px; left:700px;"/>
<input type="text" name="s1r010" id="s1r010" style="width:100px; top:512px; left:700px;"/>
<!-- cast C -->
<input type="text" name="s1r011" id="s1r011" style="width:100px; top:548px; left:700px;"/>
<input type="text" name="s1r012" id="s1r012" style="width:100px; top:579px; left:700px;"/>
<input type="text" name="s1r013" id="s1r013" style="width:100px; top:605px; left:700px;"/>
<input type="text" name="s1r014" id="s1r014" style="width:100px; top:637px; left:700px;"/>
<!-- cast D -->
<input type="text" name="s2r015" id="s2r015" style="width:100px; top:673px; left:700px;"/>
<input type="text" name="s2r016" id="s2r016" style="width:100px; top:704px; left:700px;"/>
<input type="text" name="s2r017" id="s2r017" style="width:100px; top:731px; left:700px;"/>
<input type="text" name="s2r018" id="s2r018" style="width:100px; top:756px; left:700px;"/>
<input type="text" name="s2r019" id="s2r019" style="width:100px; top:782px; left:700px;"/>
<input type="text" name="s2r020" id="s2r020" style="width:100px; top:808px; left:700px;"/>
<input type="text" name="s2r021" id="s2r021" style="width:100px; top:834px; left:700px;"/>
<input type="text" name="s2r022" id="s2r022" style="width:100px; top:859px; left:700px;"/>
<input type="text" name="s2r023" id="s2r023" style="width:100px; top:886px; left:700px;"/>
<span class="text-echo" style="top:916px; right:144px;"><?php echo $s2r024; ?></span>
<input type="text" name="s2r025" id="s2r025" style="width:100px; top:937px; left:700px;"/>
<input type="text" name="s2r026" id="s2r026" style="width:100px; top:963px; left:700px;"/>
<input type="text" name="s2r027" id="s2r027" style="width:100px; top:989px; left:700px;"/>
<input type="text" name="s2r028" id="s2r028" style="width:100px; top:1015px; left:700px;"/>
<input type="text" name="s2r029" id="s2r029" style="width:100px; top:1041px; left:700px;"/>
<input type="text" name="s2r030" id="s2r030" style="width:100px; top:1067px; left:700px;"/>
<input type="text" name="s2r031" id="s2r031" style="width:100px; top:1092px; left:700px;"/>
<input type="text" name="s2r032" id="s2r032" style="width:100px; top:1118px; left:700px;"/>
<input type="text" name="s2r033" id="s2r033" style="width:100px; top:1144px; left:700px;"/>
<input type="text" name="s2r034" id="s2r034" style="width:100px; top:1170px; left:700px;"/>
<input type="text" name="s2r035" id="s2r035" style="width:100px; top:1202px; left:700px;"/>
<input type="text" name="s2r036" id="s2r036" style="width:100px; top:1233px; left:700px;"/>
<?php                                        } ?>

<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_source; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<!-- modul 378 cast D pokrac. -->
<input type="text" name="s2r037" id="s2r037" style="width:100px; top:140px; left:700px;"/>
<input type="text" name="s2r038" id="s2r038" style="width:100px; top:166px; left:700px;"/>
<span class="text-echo" style="top:202px; right:144px;"><?php echo $s2r039; ?></span>
<input type="text" name="s2r040" id="s2r040" style="width:100px; top:234px; left:700px;"/>
<input type="text" name="s2r041" id="s2r041" style="width:100px; top:265px; left:700px;"/>
<input type="text" name="s2r042" id="s2r042" style="width:100px; top:290px; left:700px;"/>
<input type="text" name="s2r043" id="s2r043" style="width:100px; top:316px; left:700px;"/>
<input type="text" name="s2r044" id="s2r044" style="width:100px; top:342px; left:700px;"/>
<input type="text" name="s2r045" id="s2r045" style="width:100px; top:368px; left:700px;"/>
<input type="text" name="s2r046" id="s2r046" style="width:100px; top:394px; left:700px;"/>
<input type="text" name="s2r047" id="s2r047" style="width:100px; top:420px; left:700px;"/>
<input type="text" name="s2r048" id="s2r048" style="width:100px; top:451px; left:700px;"/>
<input type="text" name="s2r049" id="s2r049" style="width:100px; top:482px; left:700px;"/>
<input type="text" name="s2r050" id="s2r050" style="width:100px; top:508px; left:700px;"/>
<input type="text" name="s2r051" id="s2r051" style="width:100px; top:534px; left:700px;"/>
<input type="text" name="s2r052" id="s2r052" style="width:100px; top:565px; left:700px;"/>
<input type="text" name="s2r053" id="s2r053" style="width:100px; top:597px; left:700px;"/>
<input type="text" name="s2r054" id="s2r054" style="width:100px; top:628px; left:700px;"/>
<input type="text" name="s2r055" id="s2r055" style="width:100px; top:665px; left:700px;"/>
<input type="text" name="s2r056" id="s2r056" style="width:100px; top:696px; left:700px;"/>
<input type="text" name="s2r057" id="s2r057" style="width:100px; top:722px; left:700px;"/>
<input type="text" name="s2r058" id="s2r058" style="width:100px; top:748px; left:700px;"/>
<input type="text" name="s2r059" id="s2r059" style="width:100px; top:773px; left:700px;"/>
<span class="text-echo" style="top:810px; right:144px;"><?php echo $s2r060; ?></span>
<input type="text" name="s2r061" id="s2r061" style="width:100px; top:836px; left:700px;"/>
<input type="text" name="s2r062" id="s2r062" style="width:100px; top:867px; left:700px;"/>
<input type="text" name="s2r063" id="s2r063" style="width:100px; top:898px; left:700px;"/>
<input type="text" name="s2r064" id="s2r064" style="width:100px; top:924px; left:700px;"/>
<span class="text-echo" style="top:960px; right:144px;"><?php echo $s2r065; ?></span>
<input type="text" name="s2r066" id="s2r066" style="width:100px; top:987px; left:700px;"/>
<span class="text-echo" style="top:1018px; right:144px;"><?php echo $s2r067; ?></span>
<input type="text" name="s2r068" id="s2r068" style="width:100px; top:1044px; left:700px;"/>
<span class="text-echo" style="top:1080px; right:144px;"><?php echo $s2r099; ?></span>
<?php                                        } ?>

<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</form>
<?php
//koniec uprav
     }
?>
<?php
//xml
if ( $copern == 110 )
     {
?>
<?php
$hhmm = Date( "Hi", MkTime( date("H"),date("i"),date("s"),date("m"),date("d"),date("Y") ) );
//$idx=$kli_uzid.$hhmm;
$kli_nxcf10 = substr($kli_nxcf,0,10);
$kli_nxcf10=trim(str_replace(" ","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace(".","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace(",","",$kli_nxcf10));
$kli_nxcf10=trim(str_replace("-","",$kli_nxcf10));
$kli_nxcf10 = StrTr($kli_nxcf10, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$nazsub="../tmp/unp101_".$kli_vrok."_id".$kli_uzid."_".$kli_nxcf10."_".$hhmm.".xml";

$outfilexdel="../tmp/unp101_".$kli_vrok."_id".$kli_uzid."_*.*";
foreach ( glob("$outfilexdel" ) as $filename) { unlink($filename); }
$outfilex=$nazsub;
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<!--Sample XML file generated by XMLSpy v2008 rel. 2 (http://www.altova.com)-->
<unp xsi:schemaLocation="http://www.trexima.sk/xsd/unp/1 unp.xsd" xmlns="http://www.trexima.sk/xsd/unp/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <subor>
    <zistovanie>⁄NP 1-01</zistovanie>
    <obdobie>2016</obdobie>
    <sw_firma>Nazov vasej firmy</sw_firma>
    <program>Nazov programu</program>
    <verzia>1.0</verzia>
  </subor>
  <respondent>
    <ico>99999999</ico>
    <nazov>Testovacia firma 1000</nazov>
    <ul_cis>DrobnÈho 29/3431</ul_cis>
    <obec>Bratislava - mestsk· Ëasù D˙bravka</obec>
    <psc>84407</psc>
    <PF>30</PF>
    <PFP>29</PFP>
    <PFS>1</PFS>
    <PP>29</PP>
    <PU>0</PU>
    <PUP>0</PUP>
    <T>45201</T>
    <TP>44679</TP>
    <TS>522</TS>
    <TU>0</TU>
    <TCP>45201</TCP>
    <TPP>44679</TPP>
    <TSP>522</TSP>
    <TUP>0</TUP>
    <MZ>199689</MZ>
    <MR>199689</MR>
    <MN>0</MN>
    <MOC>8050</MOC>
    <MOM>8050</MOM>
    <MOD>0</MOD>
    <MP>0</MP>
    <MA>0</MA>
    <MO>0</MO>
    <MZDY>207739</MZDY>
    <N>26464</N>
    <NV>0</NV>
    <ND>20126</ND>
    <NP>2688</NP>
    <NS>3650</NS>
    <SP>0</SP>
    <PH>0</PH>
    <PLZ>0</PLZ>
    <OPN>0</OPN>
    <VV>0</VV>
    <FV>0</FV>
    <FB>0</FB>
    <PPA>0</PPA>
    <OU>0</OU>
    <PNPS>234203</PNPS>
    <PZP>69126</PZP>
    <PDP>32979</PDP>
    <PIP>6610</PIP>
    <PUS>1886</PUS>
    <PNP>3096</PNP>
    <PZDP>21802</PZDP>
    <PPN>2171</PPN>
    <PGP>582</PGP>
    <DSP>60</DSP>
    <DDP>60</DDP>
    <SD>1920</SD>
    <ODS>607</ODS>
    <NPN>1313</NPN>
    <DMV>0</DMV>
    <DZ>0</DZ>
    <NUC>0</NUC>
    <SVS>0</SVS>
    <ST>0</ST>
    <OPZ>0</OPZ>
    <PSO>0</PSO>
    <NSVP>314054</NSVP>
    <NSZ>92</NSZ>
    <PSS>0</PSS>
    <ONN>0</ONN>
    <NBZ>0</NBZ>
    <NNPS>79943</NNPS>
    <SVP>0</SVP>
    <CNP>314146</CNP>
    <ZZS>0</ZZS>
  </respondent>
</unp>
);
mzdprc;
$soubor = fopen("$nazsub", "a+");

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_unp101 WHERE ico=0 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
//$obdobie=$kli_vmes;
//$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
{
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<unp xsi:schemaLocation=\"http://www.trexima.sk/xsd/unp/1 unp.xsd\" xmlns=\"http://www.trexima.sk/xsd/unp/1\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">"."\r\n"; fwrite($soubor, $text);
  $text = "<subor>"."\r\n"; fwrite($soubor, $text);
$zistovanie=iconv("CP1250", "UTF-8", "⁄NP 1-01");
  $text = "  <zistovanie>".$zistovanie."</zistovanie>"."\r\n"; fwrite($soubor, $text);
  $text = "  <obdobie>".$kli_vrok."</obdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  <sw_firma>Coex s.r.o.</sw_firma>"."\r\n"; fwrite($soubor, $text);
  $text = "  <program>EuroSecom</program>"."\r\n"; fwrite($soubor, $text);
  $text = "  <verzia>2017_04</verzia>"."\r\n"; fwrite($soubor, $text);
  $text = "</subor>"."\r\n"; fwrite($soubor, $text);
  $text = "<respondent>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ico>".$fir_fico."</ico>"."\r\n"; fwrite($soubor, $text);
$nazov=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "  <nazov>".$nazov."</nazov>"."\r\n"; fwrite($soubor, $text);
$ulcis=iconv("CP1250", "UTF-8", $fir_fuli."".$fir_fcdm);
  $text = "  <ul_cis>".$ulcis."</ul_cis>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "  <obec>".$obec."</obec>"."\r\n"; fwrite($soubor, $text);
$psc = str_replace(" ","",$fir_fpsc);
$psc=iconv("CP1250", "UTF-8", $psc);
  $text = "  <psc>".$psc."</psc>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PF>".$s1r001."</PF>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PFP>".$s1r002."</PFP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PFS>".$s1r003."</PFS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PP>".$s1r004."</PP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PU>".$s1r005."</PU>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PUP>".$s1r006."</PUP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <T>".$s1r007."</T>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TP>".$s1r008."</TP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TS>".$s1r009."</TS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TU>".$s1r010."</TU>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TCP>".$s1r011."</TCP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TPP>".$s1r012."</TPP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TSP>".$s1r013."</TSP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <TUP>".$s1r014."</TUP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MZ>".$s2r015."</MZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MR>".$s2r016."</MR>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MN>".$s2r017."</MN>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MOC>".$s2r018."</MOC>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MOM>".$s2r019."</MOM>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MOD>".$s2r020."</MOD>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MP>".$s2r021."</MP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MA>".$s2r022."</MA>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MO>".$s2r023."</MO>"."\r\n"; fwrite($soubor, $text);
  $text = "  <MZDY>".$s2r024."</MZDY>"."\r\n"; fwrite($soubor, $text);
  $text = "  <N>".$s2r025."</N>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NV>".$s2r026."</NV>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ND>".$s2r027."</ND>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NP>".$s2r028."</NP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NS>".$s2r029."</NS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <SP>".$s2r030."</SP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PH>".$s2r031."</PH>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PLZ>".$s2r032."</PLZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <OPN>".$s2r033."</OPN>"."\r\n"; fwrite($soubor, $text);
  $text = "  <VV>".$s2r034."</VV>"."\r\n"; fwrite($soubor, $text);
  $text = "  <FV>".$s2r035."</FV>"."\r\n"; fwrite($soubor, $text);
  $text = "  <FB>".$s2r036."</FB>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PPA>".$s2r037."</PPA>"."\r\n"; fwrite($soubor, $text);
  $text = "  <OU>".$s2r038."</OU>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PNPS>".$s2r039."</PNPS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PZP>".$s2r040."</PZP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PDP>".$s2r041."</PDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PIP>".$s2r042."</PIP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PUS>".$s2r043."</PUS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PNP>".$s2r044."</PNP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PZDP>".$s2r045."</PZDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PPN>".$s2r046."</PPN>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PGP>".$s2r047."</PGP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <DSP>".$s2r048."</DSP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <DDP>".$s2r049."</DDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <SD>".$s2r050."</SD>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ODS>".$s2r051."</ODS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NPN>".$s2r052."</NPN>"."\r\n"; fwrite($soubor, $text);
  $text = "  <DMV>".$s2r053."</DMV>"."\r\n"; fwrite($soubor, $text);
  $text = "  <DZ>".$s2r054."</DZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NUC>".$s2r055."</NUC>"."\r\n"; fwrite($soubor, $text);
  $text = "  <SVS>".$s2r056."</SVS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ST>".$s2r057."</ST>"."\r\n"; fwrite($soubor, $text);
  $text = "  <OPZ>".$s2r058."</OPZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PSO>".$s2r059."</PSO>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NSVP>".$s2r060."</NSVP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NSZ>".$s2r061."</NSZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <PSS>".$s2r062."</PSS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ONN>".$s2r063."</ONN>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NBZ>".$s2r064."</NBZ>"."\r\n"; fwrite($soubor, $text);
  $text = "  <NNPS>".$s2r065."</NNPS>"."\r\n"; fwrite($soubor, $text);
  $text = "  <SVP>".$s2r066."</SVP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <CNP>".$s2r067."</CNP>"."\r\n"; fwrite($soubor, $text);
  $text = "  <ZZS>".$s2r068."</ZZS>"."\r\n"; fwrite($soubor, $text);
  $text = "</respondent>"."\r\n"; fwrite($soubor, $text);
  $text = "</unp>"."\r\n"; fwrite($soubor, $text);
}
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div class="bg-white" style="padding: 16px 24px;">
  <p style="line-height: 32px;">Stiahnite si niûöie uveden˝ s˙bor <strong>.xml</strong> do V·öho poËÌtaËa a naËÌtajte ho na str·nku
    <a href="https://zbery.trexima.sk" target="_blank" title="Str·nka Trexima">https://zbery.trexima.sk</a>:
  </p>
  <p style="line-height: 48px;">
    <a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>
  </p>
</div>
<?php
  } //$copern==110
?>
</div><!-- #content -->
<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>
<?php
  } //$copern!=11
?>
<?php
//pdf
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//ramcek fpdf 1=zap,0=vyp
$rmc=1;
$rmc1=0;

//vytlac
$sqltt = "UPDATE F$kli_vxcf"."_statistika_unp101 SET psys=$stvrtrok ";
$sql = mysql_query("$sqltt");
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_unp101 WHERE ico >= 0 "."";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//tlac strana 1
if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za rok
$pdf->SetFont('arial','',16);
$pdf->Cell(190,33.5," ","$rmc1",1,"L");
$pdf->Cell(95,6," ","$rmc1",0,"L");$pdf->Cell(16,7,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//rok
$pdf->Cell(190,15," ","$rmc1",1,"L");
$text=$kli_vrokx;
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(31,6," ","$rmc1",0,"L");
$pdf->Cell(7,8,"$A","$rmc",0,"C");$pdf->Cell(8,8,"$B","$rmc",0,"C");
//Mesiac
$text="12";
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(7,8,"$A","$rmc",0,"C");$pdf->Cell(8,8,"$B","$rmc",0,"C");
//ico
$text=$fir_ficox;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(7,8,"$A","$rmc",0,"C");$pdf->Cell(8,8,"$B","$rmc",0,"C");
$pdf->Cell(7,8,"$C","$rmc",0,"C");$pdf->Cell(8,8,"$D","$rmc",0,"C");
$pdf->Cell(7,8,"$E","$rmc",0,"C");$pdf->Cell(8,8,"$F","$rmc",0,"C");
$pdf->Cell(7,8,"$G","$rmc",0,"C");$pdf->Cell(8,8,"$H","$rmc",1,"C");

//podnik a okres
$pdf->Cell(190,114," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,5,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(34,5,"$okres","$rmc",1,"C");

//VYPLNIL
$pdf->Cell(199,13.5," ","$rmc1",1,"L");
$pdf->Cell(1,6," ","$rmc1",0,"L");$pdf->Cell(74,6,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(20,6,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(199,5," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(74,6,"$fir_fem1","$rmc",0,"L");
//Odoslane
$pdf->Cell(25,6,"$odoslane_sk","$rmc",1,"L");

//modul 100231
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(69,5," ","$rmc1",0,"C");$pdf->Cell(30,9,"$sknace","$rmc",0,"C");
$pdf->Cell(30,9,"$okres","$rmc",0,"C");
$pdf->Cell(30,9,"$drvlst","$rmc",0,"C");
$pdf->Cell(30,9,"$fir_uctt03","$rmc",1,"C");
//cinnost
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(85,5," ","$rmc1",0,"L");$pdf->Cell(104,5,"$cinnost","$rmc",1,"L");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 378
$pdf->Cell(195,25.5," ","$rmc1",1,"L");
//cast A
if ( $s1r001 == 0 ) $s1r001="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r001","$rmc",1,"R");
if ( $s1r002 == 0 ) $s1r002="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s1r002","$rmc",1,"R");
if ( $s1r003 == 0 ) $s1r003="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s1r003","$rmc",1,"R");
if ( $s1r004 == 0 ) $s1r004="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r004","$rmc",1,"R");
if ( $s1r005 == 0 ) $s1r005="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,9,"$s1r005","$rmc",1,"R");
if ( $s1r006 == 0 ) $s1r006="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r006","$rmc",1,"R");
if ( $s1r007 == 0 ) $s1r007="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,13,"$s1r007","$rmc",1,"R");
if ( $s1r008 == 0 ) $s1r008="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r008","$rmc",1,"R");
if ( $s1r009 == 0 ) $s1r009="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r009","$rmc",1,"R");
if ( $s1r010 == 0 ) $s1r010="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,9,"$s1r010","$rmc",1,"R");
if ( $s1r011 == 0 ) $s1r011="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r011","$rmc",1,"R");
if ( $s1r012 == 0 ) $s1r012="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s1r012","$rmc",1,"R");
if ( $s1r013 == 0 ) $s1r013="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s1r013","$rmc",1,"R");
if ( $s1r014 == 0 ) $s1r014="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s1r014","$rmc",1,"R");
if ( $s2r015 == 0 ) $s2r015="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,9,"$s2r015","$rmc",1,"R");
if ( $s2r016 == 0 ) $s2r016="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r016","$rmc",1,"R");
if ( $s2r017 == 0 ) $s2r017="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r017","$rmc",1,"R");
if ( $s2r018 == 0 ) $s2r018="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r018","$rmc",1,"R");
if ( $s2r019 == 0 ) $s2r019="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r019","$rmc",1,"R");
if ( $s2r020 == 0 ) $s2r020="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r020","$rmc",1,"R");
if ( $s2r021 == 0 ) $s2r021="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,5,"$s2r021","$rmc",1,"R");
if ( $s2r022 == 0 ) $s2r022="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r022","$rmc",1,"R");
if ( $s2r023 == 0 ) $s2r023="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r023","$rmc",1,"R");
if ( $s2r024 == 0 ) $s2r024="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r024","$rmc",1,"R");
if ( $s2r025 == 0 ) $s2r025="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r025","$rmc",1,"R");
if ( $s2r026 == 0 ) $s2r026="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r026","$rmc",1,"R");
if ( $s2r027 == 0 ) $s2r027="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r027","$rmc",1,"R");
if ( $s2r028 == 0 ) $s2r028="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r028","$rmc",1,"R");
if ( $s2r029 == 0 ) $s2r029="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r029","$rmc",1,"R");
if ( $s2r030 == 0 ) $s2r030="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r030","$rmc",1,"R");
if ( $s2r031 == 0 ) $s2r031="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,5,"$s2r031","$rmc",1,"R");
if ( $s2r032 == 0 ) $s2r032="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r032","$rmc",1,"R");
if ( $s2r033 == 0 ) $s2r033="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r033","$rmc",1,"R");
if ( $s2r034 == 0 ) $s2r034="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r034","$rmc",1,"R");
if ( $s2r035 == 0 ) $s2r035="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r035","$rmc",1,"R");
if ( $s2r036 == 0 ) $s2r036="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r036","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(178);
$pdf->Cell(20,6,"2/3","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str3.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);
//modul 378, cast D - pokracovanie
$pdf->Cell(195,16," ","$rmc1",1,"L");
if ( $s2r037 == 0 ) $s2r037="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r037","$rmc",1,"R");
if ( $s2r038 == 0 ) $s2r038="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r038","$rmc",1,"R");
if ( $s2r039 == 0 ) $s2r039="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r039","$rmc",1,"R");
if ( $s2r040 == 0 ) $s2r040="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,9,"$s2r040","$rmc",1,"R");
if ( $s2r041 == 0 ) $s2r041="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r041","$rmc",1,"R");
if ( $s2r042 == 0 ) $s2r042="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r042","$rmc",1,"R");
if ( $s2r043 == 0 ) $s2r043="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r043","$rmc",1,"R");
if ( $s2r044 == 0 ) $s2r044="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,5,"$s2r044","$rmc",1,"R");
if ( $s2r045 == 0 ) $s2r045="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r045","$rmc",1,"R");
if ( $s2r046 == 0 ) $s2r046="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r046","$rmc",1,"R");
if ( $s2r047 == 0 ) $s2r047="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r047","$rmc",1,"R");
if ( $s2r048 == 0 ) $s2r048="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r048","$rmc",1,"R");
if ( $s2r049 == 0 ) $s2r049="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r049","$rmc",1,"R");
if ( $s2r050 == 0 ) $s2r050="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r050","$rmc",1,"R");
if ( $s2r051 == 0 ) $s2r051="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r051","$rmc",1,"R");
if ( $s2r052 == 0 ) $s2r052="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r052","$rmc",1,"R");
if ( $s2r053 == 0 ) $s2r053="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,7,"$s2r053","$rmc",1,"R");
if ( $s2r054 == 0 ) $s2r054="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r054","$rmc",1,"R");
if ( $s2r055 == 0 ) $s2r055="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r055","$rmc",1,"R");
if ( $s2r056 == 0 ) $s2r056="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r056","$rmc",1,"R");
if ( $s2r057 == 0 ) $s2r057="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r057","$rmc",1,"R");
if ( $s2r058 == 0 ) $s2r058="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r058","$rmc",1,"R");
if ( $s2r059 == 0 ) $s2r059="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r059","$rmc",1,"R");
if ( $s2r060 == 0 ) $s2r060="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r060","$rmc",1,"R");
if ( $s2r061 == 0 ) $s2r061="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r061","$rmc",1,"R");
if ( $s2r062 == 0 ) $s2r062="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,9,"$s2r062","$rmc",1,"R");
if ( $s2r063 == 0 ) $s2r063="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r063","$rmc",1,"R");
if ( $s2r064 == 0 ) $s2r064="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r064","$rmc",1,"R");
if ( $s2r065 == 0 ) $s2r065="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r065","$rmc",1,"R");
if ( $s2r066 == 0 ) $s2r066="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r066","$rmc",1,"R");
if ( $s2r067 == 0 ) $s2r067="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r067","$rmc",1,"R");
if ( $s2r068 == 0 ) $s2r068="";
$pdf->Cell(146,4," ","$rmc1",0,"L");$pdf->Cell(40,8,"$s2r068","$rmc",1,"R");
if ( $s2r099 == 0 ) $s2r099="";
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$s2r099","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(178);
$pdf->Cell(20,6,"3/3","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
$sql = "SELECT okres FROM F$kli_vxcf"."_statistika_unp101arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_unp101arch';
$vytvor = mysql_query("$vsql");
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_unp101arch SELECT * FROM F".$kli_vxcf."_statistika_unp101 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_unp101arch WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_statistika_unp101arch SELECT * FROM F".$kli_vxcf."_statistika_unp101 WHERE psys=$stvrtrok";
$vysledek = mysql_query("$sql");
?>
<script type="text/javascript">
 var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac copern=11
?>
<?php
$cislista = include("mzd_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//parameter okna
var blank_param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

<?php
//uprava
  if ( $copern == 1 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.cinnost.value = '<?php echo $cinnost;?>';
   document.formv1.odoslane.value = '<?php echo $odoslane_sk;?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.s1r001.value = '<?php echo "$s1r001";?>';
   document.formv1.s1r002.value = '<?php echo "$s1r002";?>';
   document.formv1.s1r003.value = '<?php echo "$s1r003";?>';
   document.formv1.s1r004.value = '<?php echo "$s1r004";?>';
   document.formv1.s1r005.value = '<?php echo "$s1r005";?>';
   document.formv1.s1r006.value = '<?php echo "$s1r006";?>';
   document.formv1.s1r007.value = '<?php echo "$s1r007";?>';
   document.formv1.s1r008.value = '<?php echo "$s1r008";?>';
   document.formv1.s1r009.value = '<?php echo "$s1r009";?>';
   document.formv1.s1r010.value = '<?php echo "$s1r010";?>';
   document.formv1.s1r011.value = '<?php echo "$s1r011";?>';
   document.formv1.s1r012.value = '<?php echo "$s1r012";?>';
   document.formv1.s1r013.value = '<?php echo "$s1r013";?>';
   document.formv1.s1r014.value = '<?php echo "$s1r014";?>';
   document.formv1.s2r015.value = '<?php echo "$s2r015";?>';
   document.formv1.s2r016.value = '<?php echo "$s2r016";?>';
   document.formv1.s2r017.value = '<?php echo "$s2r017";?>';
   document.formv1.s2r018.value = '<?php echo "$s2r018";?>';
   document.formv1.s2r019.value = '<?php echo "$s2r019";?>';
   document.formv1.s2r020.value = '<?php echo "$s2r020";?>';
   document.formv1.s2r021.value = '<?php echo "$s2r021";?>';
   document.formv1.s2r022.value = '<?php echo "$s2r022";?>';
   document.formv1.s2r023.value = '<?php echo "$s2r023";?>';
 //document.formv1.s2r024.value = '<?php echo "$s2r024";?>';
   document.formv1.s2r025.value = '<?php echo "$s2r025";?>';
   document.formv1.s2r026.value = '<?php echo "$s2r026";?>';
   document.formv1.s2r027.value = '<?php echo "$s2r027";?>';
   document.formv1.s2r028.value = '<?php echo "$s2r028";?>';
   document.formv1.s2r029.value = '<?php echo "$s2r029";?>';
   document.formv1.s2r030.value = '<?php echo "$s2r030";?>';
   document.formv1.s2r031.value = '<?php echo "$s2r031";?>';
   document.formv1.s2r032.value = '<?php echo "$s2r032";?>';
   document.formv1.s2r033.value = '<?php echo "$s2r033";?>';
   document.formv1.s2r034.value = '<?php echo "$s2r034";?>';
   document.formv1.s2r035.value = '<?php echo "$s2r035";?>';
   document.formv1.s2r036.value = '<?php echo "$s2r036";?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>

   document.formv1.s2r037.value = '<?php echo "$s2r037";?>';
   document.formv1.s2r038.value = '<?php echo "$s2r038";?>';
 //document.formv1.s2r039.value = '<?php echo "$s2r039";?>';
   document.formv1.s2r040.value = '<?php echo "$s2r040";?>';
   document.formv1.s2r041.value = '<?php echo "$s2r041";?>';
   document.formv1.s2r042.value = '<?php echo "$s2r042";?>';
   document.formv1.s2r043.value = '<?php echo "$s2r043";?>';
   document.formv1.s2r044.value = '<?php echo "$s2r044";?>';
   document.formv1.s2r045.value = '<?php echo "$s2r045";?>';
   document.formv1.s2r046.value = '<?php echo "$s2r046";?>';
   document.formv1.s2r047.value = '<?php echo "$s2r047";?>';
   document.formv1.s2r048.value = '<?php echo "$s2r048";?>';
   document.formv1.s2r049.value = '<?php echo "$s2r049";?>';
   document.formv1.s2r050.value = '<?php echo "$s2r050";?>';
   document.formv1.s2r051.value = '<?php echo "$s2r051";?>';
   document.formv1.s2r052.value = '<?php echo "$s2r052";?>';
   document.formv1.s2r053.value = '<?php echo "$s2r053";?>';
   document.formv1.s2r054.value = '<?php echo "$s2r054";?>';
   document.formv1.s2r055.value = '<?php echo "$s2r055";?>';
   document.formv1.s2r056.value = '<?php echo "$s2r056";?>';
   document.formv1.s2r057.value = '<?php echo "$s2r057";?>';
   document.formv1.s2r058.value = '<?php echo "$s2r058";?>';
   document.formv1.s2r059.value = '<?php echo "$s2r059";?>';
 //document.formv1.s2r060.value = '<?php echo "$s2r060";?>';
   document.formv1.s2r061.value = '<?php echo "$s2r061";?>';
   document.formv1.s2r062.value = '<?php echo "$s2r062";?>';
   document.formv1.s2r063.value = '<?php echo "$s2r063";?>';
   document.formv1.s2r064.value = '<?php echo "$s2r064";?>';
 //document.formv1.s2r065.value = '<?php echo "$s2r065";?>';
   document.formv1.s2r066.value = '<?php echo "$s2r066";?>';
 //document.formv1.s2r067.value = '<?php echo "$s2r067";?>';
   document.formv1.s2r068.value = '<?php echo "$s2r068";?>';
 //document.formv1.s2r099.value = '<?php echo "$s2r099";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>
<?php
  if ( $copern != 1 )
  {
?>
  function ObnovUI()
  {
  }
<?php
  }
?>


//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
    if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }
  function FormMetod()
  {
<?php if ( $kli_vrok == 2016 ) { ?>
    window.open('<?php echo $jpg_source; ?>_metodika.pdf', '_blank', blank_param);
<?php } ?>
<?php if ( $kli_vrok > 2016 ) { ?>
    window.open('../dokumenty/statistika2017/unp101/unp101_v17_metodika.pdf', '_blank', blank_param);
<?php } ?>
  }
  function editForm(strana)
  {
    window.open('stat_unp101.php?copern=1&strana=' + strana + '', '_self');
  }
  function FormPDF(strana)
  {
    window.open('stat_unp101.php?copern=11&strana=' + strana + '', '_blank', blank_param);
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', blank_param);
  }
  function UdajeFirma()
  {
   window.open('../cis/ufir.php?copern=1&drupoh=1', '_blank', blank_param);
  }
  function NacitajMzdy()
  {
   window.open('stat_unp101.php?copern=200&drupoh=1&page=1&typ=PDF&cstat=101&vyb_ume=<?php echo $kli_vume; ?>&strana=<?php echo $strana; ?>&h_mfir=<?php echo $kli_vxcf; ?>', '_self');
  }
  function FormXML()
  {
   window.open('stat_unp101.php?copern=110&drupoh=1', '_blank', blank_param);
  }
</script>
</body>
</html>