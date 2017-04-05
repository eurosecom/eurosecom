<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu UNP 101 2016
do
{
$sys = 'MZD';
$urov = 2000;
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/unp101/unp101_v16";
$jpg_popis="tlaËivo RoËn˝ v˝kaz o ˙pln˝ch n·kladoch pr·ce ⁄NP 1-01 ".$kli_vrok;


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

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
?>
<?php
//kod okresu, DRVLST z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  $drvlst=1*$riaddok->vlastnic;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
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
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 1 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.cinnost.value = '<?php echo "$cinnost";?>';
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
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

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../mzdy/stat_unp101.php?copern=11&strana=9999', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function UdajeFirma()
  {
   window.open('../cis/ufir.php?copern=1&drupoh=1',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../mzdy/stat_unp101.php?copern=200&drupoh=1&page=1&typ=PDF&cstat=101&vyb_ume=<?php echo $kli_vume; ?>&strana=<?php echo $strana; ?>&h_mfir=<?php echo $kli_vxcf; ?>', '_self');
  }
  function doXML()
  {
   window.open('stat_unp101xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 1  )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">RoËn˝ v˝kaz o ˙pln˝ch n·kladoch pr·ce</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMzdy();" title="NaËÌtaù ˙daje z miezd" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    <img src="../obr/ikony/upbox_blue_icon.png" onclick="doXML();" title="Export do XML" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="stat_unp101.php?copern=3&strana=<?php echo "$strana"; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="stat_unp101.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 272kB">
<?php
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
?>
<span class="text-echo" style="top:308px; left:252px; font-size:18px; letter-spacing:25px;">12</span>
<span class="text-echo" style="top:308px; left:321px; font-size:18px; letter-spacing:22px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:840px; left:54px;"><?php echo "$fir_fnaz $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:840px; left:815px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();"
     title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:838px; left:846px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:890px; left:54px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:903px; left:487px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:937px; left:54px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:932px; left:390px;"/>

<!-- modul 100231 -->
<?php $fir_sknacex=str_replace(".","",$fir_sknace); ?>
<span class="text-echo" style="top:1136px; left:403px;"><?php echo $fir_sknacex; ?></span>
<span class="text-echo" style="top:1136px; left:547px;"><?php echo $okres; ?></span>
<span class="text-echo" style="top:1136px; left:690px;"><?php echo $drvlst; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();"
      title="Nastaviù kÛd DRVLST" class="btn-row-tool" style="top:1134px; left:705px;">
<span class="text-echo" style="top:1136px; left:820px;"><?php echo $fir_uctt03; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UdajeFirma();"
      title="Nastaviù kÛd FORMA" class="btn-row-tool" style="top:1134px; left:852px;">
<input type="text" name="cinnost" id="cinnost" style="width:460px; top:1167px; left:435px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 273kB">

<!-- modul 378 -->
<!-- cast A -->
<input type="text" name="s1r001" id="s1r001" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:187px; left:700px;"/>
<input type="text" name="s1r002" id="s1r002" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:218px; left:700px;"/>
<input type="text" name="s1r003" id="s1r003" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:244px; left:700px;"/>
<input type="text" name="s1r004" id="s1r004" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:275px; left:700px;"/>
<input type="text" name="s1r005" id="s1r005" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:312px; left:700px;"/>
<input type="text" name="s1r006" id="s1r006" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:349px; left:700px;"/>
<!-- cast B -->
<input type="text" name="s1r007" id="s1r007" style="width:100px; top:395px; left:700px;"/>
<input type="text" name="s1r008" id="s1r008" style="width:100px; top:443px; left:700px;"/>
<input type="text" name="s1r009" id="s1r009" style="width:100px; top:480px; left:700px;"/>
<input type="text" name="s1r010" id="s1r010" style="width:100px; top:517px; left:700px;"/>
<!-- cast C -->
<input type="text" name="s1r011" id="s1r011" style="width:100px; top:555px; left:700px;"/>
<input type="text" name="s1r012" id="s1r012" style="width:100px; top:590px; left:700px;"/>
<input type="text" name="s1r013" id="s1r013" style="width:100px; top:627px; left:700px;"/>
<input type="text" name="s1r014" id="s1r014" style="width:100px; top:664px; left:700px;"/>
<!-- cast D -->
<input type="text" name="s2r015" id="s2r015" style="width:100px; top:700px; left:700px;"/>
<input type="text" name="s2r016" id="s2r016" style="width:100px; top:731px; left:700px;"/>
<input type="text" name="s2r017" id="s2r017" style="width:100px; top:757px; left:700px;"/>
<input type="text" name="s2r018" id="s2r018" style="width:100px; top:783px; left:700px;"/>
<input type="text" name="s2r019" id="s2r019" style="width:100px; top:809px; left:700px;"/>
<input type="text" name="s2r020" id="s2r020" style="width:100px; top:835px; left:700px;"/>
<input type="text" name="s2r021" id="s2r021" style="width:100px; top:860px; left:700px;"/>
<input type="text" name="s2r022" id="s2r022" style="width:100px; top:886px; left:700px;"/>
<input type="text" name="s2r023" id="s2r023" style="width:100px; top:912px; left:700px;"/>
<span class="text-echo" style="top:942px; right:144px;"><?php echo $s2r024; ?></span>
<input type="text" name="s2r025" id="s2r025" style="width:100px; top:964px; left:700px;"/>
<input type="text" name="s2r026" id="s2r026" style="width:100px; top:990px; left:700px;"/>
<input type="text" name="s2r027" id="s2r027" style="width:100px; top:1016px; left:700px;"/>
<input type="text" name="s2r028" id="s2r028" style="width:100px; top:1041px; left:700px;"/>
<input type="text" name="s2r029" id="s2r029" style="width:100px; top:1067px; left:700px;"/>
<input type="text" name="s2r030" id="s2r030" style="width:100px; top:1093px; left:700px;"/>
<input type="text" name="s2r031" id="s2r031" style="width:100px; top:1119px; left:700px;"/>
<input type="text" name="s2r032" id="s2r032" style="width:100px; top:1145px; left:700px;"/>
<input type="text" name="s2r033" id="s2r033" style="width:100px; top:1171px; left:700px;"/>
<input type="text" name="s2r034" id="s2r034" style="width:100px; top:1203px; left:700px;"/>
<input type="text" name="s2r035" id="s2r035" style="width:100px; top:1223px; left:700px;"/>
<input type="text" name="s2r036" id="s2r036" style="width:100px; top:1243px; left:700px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 257kB">

<!-- modul 378 pokrac. casti D -->

<input type="text" name="s2r037" id="s2r037" style="width:100px; top:184px; left:700px;"/>
<input type="text" name="s2r038" id="s2r038" style="width:100px; top:211px; left:700px;"/>
<span class="text-echo" style="top:247px; right:144px;"><?php echo $s2r039; ?></span>
<input type="text" name="s2r040" id="s2r040" style="width:100px; top:279px; left:700px;"/>
<input type="text" name="s2r041" id="s2r041" style="width:100px; top:310px; left:700px;"/>
<input type="text" name="s2r042" id="s2r042" style="width:100px; top:335px; left:700px;"/>
<input type="text" name="s2r043" id="s2r043" style="width:100px; top:361px; left:700px;"/>
<input type="text" name="s2r044" id="s2r044" style="width:100px; top:387px; left:700px;"/>
<input type="text" name="s2r045" id="s2r045" style="width:100px; top:413px; left:700px;"/>
<input type="text" name="s2r046" id="s2r046" style="width:100px; top:439px; left:700px;"/>
<input type="text" name="s2r047" id="s2r047" style="width:100px; top:465px; left:700px;"/>
<input type="text" name="s2r048" id="s2r048" style="width:100px; top:496px; left:700px;"/>
<input type="text" name="s2r049" id="s2r049" style="width:100px; top:527px; left:700px;"/>
<input type="text" name="s2r050" id="s2r050" style="width:100px; top:553px; left:700px;"/>
<input type="text" name="s2r051" id="s2r051" style="width:100px; top:579px; left:700px;"/>
<input type="text" name="s2r052" id="s2r052" style="width:100px; top:611px; left:700px;"/>
<input type="text" name="s2r053" id="s2r053" style="width:100px; top:642px; left:700px;"/>
<input type="text" name="s2r054" id="s2r054" style="width:100px; top:673px; left:700px;"/>
<input type="text" name="s2r055" id="s2r055" style="width:100px; top:710px; left:700px;"/>
<input type="text" name="s2r056" id="s2r056" style="width:100px; top:741px; left:700px;"/>
<input type="text" name="s2r057" id="s2r057" style="width:100px; top:766px; left:700px;"/>
<input type="text" name="s2r058" id="s2r058" style="width:100px; top:793px; left:700px;"/>
<input type="text" name="s2r059" id="s2r059" style="width:100px; top:824px; left:700px;"/>
<span class="text-echo" style="top:866px; right:144px;"><?php echo $s2r060; ?></span>
<input type="text" name="s2r061" id="s2r061" style="width:100px; top:891px; left:700px;"/>
<input type="text" name="s2r062" id="s2r062" style="width:100px; top:923px; left:700px;"/>
<input type="text" name="s2r063" id="s2r063" style="width:100px; top:955px; left:700px;"/>
<input type="text" name="s2r064" id="s2r064" style="width:100px; top:980px; left:700px;"/>
<span class="text-echo" style="top:1016px; right:144px;"><?php echo $s2r065; ?></span>
<input type="text" name="s2r066" id="s2r066" style="width:100px; top:1042px; left:700px;"/>
<span class="text-echo" style="top:1073px; right:144px;"><?php echo $s2r067; ?></span>
<input type="text" name="s2r068" id="s2r068" style="width:100px; top:1093px; left:700px;"/>
<span class="text-echo" style="top:1113px; right:144px;"><?php echo $s2r099; ?></span>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=1&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//koniec uprav
     }
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
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
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//Mesiac
$mesiacx=$mesiac;
if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$A="1";
$B="2";
$pdf->Cell(190,53," ","$rmc1",1,"L");
$pdf->Cell(43,5," ","$rmc1",0,"L");$pdf->Cell(7,8,"$A","$rmc",0,"C");$pdf->Cell(8,8,"$B","$rmc",0,"C");
//ICO
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(8,8,"$A","$rmc",0,"C");$pdf->Cell(7,8,"$B","$rmc",0,"C");
$pdf->Cell(7,8,"$C","$rmc",0,"C");$pdf->Cell(7,8,"$D","$rmc",0,"C");
$pdf->Cell(7,8,"$E","$rmc",0,"C");$pdf->Cell(7,8,"$F","$rmc",0,"C");
$pdf->Cell(7,8,"$G","$rmc",0,"C");$pdf->Cell(8,8,"$H","$rmc",1,"C");

//podnik a okres
$pdf->Cell(190,115," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,5,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(34,5,"$okres","$rmc",1,"C");

//VYPLNIL
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(74,6,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(44,11,"$fir_mzdt04","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(74,6,"$fir_fem1","$rmc",0,"L");
//Odoslane
$pdf->Cell(44,6,"$odoslane_sk","$rmc",1,"C");

//modul 100231
$pdf->Cell(195,37," ","$rmc1",1,"L");
$sknace=str_replace(".", "", $fir_sknace);
$pdf->Cell(69,5," ","$rmc1",0,"C");$pdf->Cell(30,9,"$sknace","$rmc",0,"C");
$pdf->Cell(30,9,"$okres","$rmc",0,"C");
$pdf->Cell(30,9,"$drvlst","$rmc",0,"C");
$pdf->Cell(30,9,"$fir_uctt03","$rmc",1,"C");
//cinnost
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(85,5," ","$rmc1",0,"L");$pdf->Cell(104,5,"$cinnost","$rmc",1,"L");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//modul 378
$pdf->Cell(195,26," ","$rmc1",1,"L");
//cast A
$s1r001=$hlavicka->s1r001;
if ( $hlavicka->s1r001 == 0 ) $s1r001="";
$text=$s1r001;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s1r002=$hlavicka->s1r002;
if ( $hlavicka->s1r002 == 0 ) $s1r002="";
$text=$s1r002;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s1r003=$hlavicka->s1r003;
if ( $hlavicka->s1r003 == 0 ) $s1r003="";
$text=$s1r003;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s1r004=$hlavicka->s1r004;
if ( $hlavicka->s1r004 == 0 ) $s1r004="";
$text=$s1r004;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s1r005=$hlavicka->s1r005;
if ( $hlavicka->s1r005 == 0 ) $s1r005="";
$text=$s1r005;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s1r006=$hlavicka->s1r006;
if ( $hlavicka->s1r006 == 0 ) $s1r006="";
$text=$s1r006;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");
//cast B
$s1r007=$hlavicka->s1r007;
if ( $hlavicka->s1r007 == 0 ) $s1r007="";
$text=$s1r007;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,13,"$text","$rmc",1,"R");

$s1r008=$hlavicka->s1r008;
if ( $hlavicka->s1r008 == 0 ) $s1r008="";
$text=$s1r008;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s1r009=$hlavicka->s1r009;
if ( $hlavicka->s1r009 == 0 ) $s1r009="";
$text=$s1r009;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s1r010=$hlavicka->s1r010;
if ( $hlavicka->s1r010 == 0 ) $s1r010="";
$text=$s1r010;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");
//cast C
$s1r011=$hlavicka->s1r011;
if ( $hlavicka->s1r011 == 0 ) $s1r011="";
$text=$s1r011;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s1r012=$hlavicka->s1r012;
if ( $hlavicka->s1r012 == 0 ) $s1r012="";
$text=$s1r012;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s1r013=$hlavicka->s1r013;
if ( $hlavicka->s1r013 == 0 ) $s1r013="";
$text=$s1r013;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s1r014=$hlavicka->s1r014;
if ( $hlavicka->s1r014 == 0 ) $s1r014="";
$text=$s1r014;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");
//cast D
$s2r015=$hlavicka->s2r015;
if ( $hlavicka->s2r015 == 0 ) $s2r015="";
$text=$s2r015;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s2r016=$hlavicka->s2r016;
if ( $hlavicka->s2r016 == 0 ) $s2r016="";
$text=$s2r016;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r017=$hlavicka->s2r017;
if ( $hlavicka->s2r017 == 0 ) $s2r017="";
$text=$s2r017;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r018=$hlavicka->s2r018;
if ( $hlavicka->s2r018 == 0 ) $s2r018="";
$text=$s2r018;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r019=$hlavicka->s2r019;
if ( $hlavicka->s2r019 == 0 ) $s2r019="";
$text=$s2r019;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r020=$hlavicka->s2r020;
if ( $hlavicka->s2r020 == 0 ) $s2r020="";
$text=$s2r020;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r021=$hlavicka->s2r021;
if ( $hlavicka->s2r021 == 0 ) $s2r021="";
$text=$s2r021;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r022=$hlavicka->s2r022;
if ( $hlavicka->s2r022 == 0 ) $s2r022="";
$text=$s2r022;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r023=$hlavicka->s2r023;
if ( $hlavicka->s2r023 == 0 ) $s2r023="";
$text=$s2r023;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r024=$hlavicka->s2r024;
if ( $hlavicka->s2r024 == 0 ) $s2r024="";
$text=$s2r024;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r025=$hlavicka->s2r025;
if ( $hlavicka->s2r025 == 0 ) $s2r025="";
$text=$s2r025;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r026=$hlavicka->s2r026;
if ( $hlavicka->s2r026 == 0 ) $s2r026="";
$text=$s2r026;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r027=$hlavicka->s2r027;
if ( $hlavicka->s2r027 == 0 ) $s2r027="";
$text=$s2r027;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r028=$hlavicka->s2r028;
if ( $hlavicka->s2r028 == 0 ) $s2r028="";
$text=$s2r028;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r029=$hlavicka->s2r029;
if ( $hlavicka->s2r029 == 0 ) $s2r029="";
$text=$s2r029;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r030=$hlavicka->s2r030;
if ( $hlavicka->s2r030 == 0 ) $s2r030="";
$text=$s2r030;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r031=$hlavicka->s2r031;
if ( $hlavicka->s2r031 == 0 ) $s2r031="";
$text=$s2r031;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r032=$hlavicka->s2r032;
if ( $hlavicka->s2r032 == 0 ) $s2r032="";
$text=$s2r032;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r033=$hlavicka->s2r033;
if ( $hlavicka->s2r033 == 0 ) $s2r033="";
$text=$s2r033;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r034=$hlavicka->s2r034;
if ( $hlavicka->s2r034 == 0 ) $s2r034="";
$text=$s2r034;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);
$pdf->Cell(195,12," ","$rmc1",1,"L");

//modul 378, cast D - pokracovanie
$s2r035=$hlavicka->s2r035;
if ( $hlavicka->s2r035 == 0 ) $s2r035="";
$text=$s2r035;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r036=$hlavicka->s2r036;
if ( $hlavicka->s2r036 == 0 ) $s2r036="";
$text=$s2r036;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r037=$hlavicka->s2r037;
if ( $hlavicka->s2r037 == 0 ) $s2r037="";
$text=$s2r037;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r038=$hlavicka->s2r038;
if ( $hlavicka->s2r038 == 0 ) $s2r038="";
$text=$s2r038;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r039=$hlavicka->s2r039;
if ( $hlavicka->s2r039 == 0 ) $s2r039="";
$text=$s2r039;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s2r040=$hlavicka->s2r040;
if ( $hlavicka->s2r040 == 0 ) $s2r040="";
$text=$s2r040;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r041=$hlavicka->s2r041;
if ( $hlavicka->s2r041 == 0 ) $s2r041="";
$text=$s2r041;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r042=$hlavicka->s2r042;
if ( $hlavicka->s2r042 == 0 ) $s2r042="";
$text=$s2r042;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r043=$hlavicka->s2r043;
if ( $hlavicka->s2r043 == 0 ) $s2r043="";
$text=$s2r043;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r044=$hlavicka->s2r044;
if ( $hlavicka->s2r044 == 0 ) $s2r044="";
$text=$s2r044;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r045=$hlavicka->s2r045;
if ( $hlavicka->s2r045 == 0 ) $s2r045="";
$text=$s2r045;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r046=$hlavicka->s2r046;
if ( $hlavicka->s2r046 == 0 ) $s2r046="";
$text=$s2r046;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r047=$hlavicka->s2r047;
if ( $hlavicka->s2r047 == 0 ) $s2r047="";
$text=$s2r047;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r048=$hlavicka->s2r048;
if ( $hlavicka->s2r048 == 0 ) $s2r048="";
$text=$s2r048;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r049=$hlavicka->s2r049;
if ( $hlavicka->s2r049 == 0 ) $s2r049="";
$text=$s2r049;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r050=$hlavicka->s2r050;
if ( $hlavicka->s2r050 == 0 ) $s2r050="";
$text=$s2r050;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r051=$hlavicka->s2r051;
if ( $hlavicka->s2r051 == 0 ) $s2r051="";
$text=$s2r051;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r052=$hlavicka->s2r052;
if ( $hlavicka->s2r052 == 0 ) $s2r052="";
$text=$s2r052;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r053=$hlavicka->s2r053;
if ( $hlavicka->s2r053 == 0 ) $s2r053="";
$text=$s2r053;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r054=$hlavicka->s2r054;
if ( $hlavicka->s2r054 == 0 ) $s2r054="";
$text=$s2r054;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r055=$hlavicka->s2r055;
if ( $hlavicka->s2r055 == 0 ) $s2r055="";
$text=$s2r055;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r056=$hlavicka->s2r056;
if ( $hlavicka->s2r056 == 0 ) $s2r056="";
$text=$s2r056;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r057=$hlavicka->s2r057;
if ( $hlavicka->s2r057 == 0 ) $s2r057="";
$text=$s2r057;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r058=$hlavicka->s2r058;
if ( $hlavicka->s2r058 == 0 ) $s2r058="";
$text=$s2r058;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r059=$hlavicka->s2r059;
if ( $hlavicka->s2r059 == 0 ) $s2r059="";
$text=$s2r059;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r060=$hlavicka->s2r060;
if ( $hlavicka->s2r060 == 0 ) $s2r060="";
$text=$s2r060;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s2r061=$hlavicka->s2r061;
if ( $hlavicka->s2r061 == 0 ) $s2r061="";
$text=$s2r061;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");
$s2r062=$hlavicka->s2r062;
if ( $hlavicka->s2r062 == 0 ) $s2r062="";
$text=$s2r062;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,8,"$text","$rmc",1,"R");

$s2r063=$hlavicka->s2r063;
if ( $hlavicka->s2r063 == 0 ) $s2r063="";
$text=$s2r063;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,7,"$text","$rmc",1,"R");

$s2r064=$hlavicka->s2r064;
if ( $hlavicka->s2r064 == 0 ) $s2r064="";
$text=$s2r064;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,5,"$text","$rmc",1,"R");

$s2r065=$hlavicka->s2r065;
if ( $hlavicka->s2r065 == 0 ) $s2r065="";
$text=$s2r065;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,9,"$text","$rmc",1,"R");

$s2r066=$hlavicka->s2r066;
if ( $hlavicka->s2r066 == 0 ) $s2r066="";
$text=$s2r066;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r067=$hlavicka->s2r067;
if ( $hlavicka->s2r067 == 0 ) $s2r067="";
$text=$s2r067;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");

$s2r099=$hlavicka->s2r099;
if ( $hlavicka->s2r099 == 0 ) $s2r099="";
$text=$s2r099;
$pdf->Cell(146,7," ","$rmc1",0,"L");$pdf->Cell(40,6,"$text","$rmc",1,"R");
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
</BODY>
</HTML>