<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;

if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_minrok=$kli_vrok-1;
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
if ( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="4.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if ( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="7.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if ( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="10.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;

$dopoz = 1*$_REQUEST['dopoz'];
if ( $copern == 1 ) $dopoz=1;
//echo $copern;

//vytvor tabulku textov v databaze
$sql = "SELECT ico FROM F$kli_vxcf"."_poznamky_muj2014texty ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$vsql = 'DROP TABLE F'.$kli_vxcf.'_poznamky_muj2014texty';
$vytvor = mysql_query("$vsql");
     
$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   ozntxt       VARCHAR(10) not null,
   hdntxt       TEXT not null,
   prmx1        DECIMAL(10,0) DEFAULT 0,
   prmx2        DECIMAL(10,0) DEFAULT 0,
   prmx3        DECIMAL(10,0) DEFAULT 0,
   prmx4        DECIMAL(10,0) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_poznamky_muj2014texty'.$sqlt;
$vytvor = mysql_query("$vsql");

   }
$sql = "SELECT oldp FROM F$kli_vxcf"."_poznamky_muj2014texty ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldc2 VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldc1 VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldp VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");
   }
//koniec vytvor tabulku textov v databaze

//vytvor tabulku v databaze
$sql = "SELECT ico FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{   
   
$vsql = 'DROP TABLE F'.$kli_vxcf.'_poznamky_muj2014';
$vytvor = mysql_query("$vsql");
     
$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_poznamky_muj2014'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}

$sql = "SELECT gh46 FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def1<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gcd62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh11 VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh13 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh14 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh15 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh16 VARCHAR(30) NOT NULL AFTER konx"; 
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh21 VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh23 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh24 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh25 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh26 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh31 VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh33 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh34 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh35 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh36 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh41 VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh43 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh44 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh45 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD gh46 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m143c FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def2<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k71 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k72 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k81 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k82 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k91 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD k92 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l1ab62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD l2ab62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc71 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc72 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc81 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD lc82 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m11b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m12b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m13b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m11c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m12c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m13c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m21b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m22b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m23b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m21c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m22c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m23c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m31b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m32b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m33b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m31c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m32c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m33c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m41b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m42b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m43b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m41c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m42c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m43c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m51b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m52b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m53b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m51c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m52c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m53c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m61b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m62b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m63b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m61c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m62c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m63c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m71b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m72b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m73b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m71c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m72c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m73c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m81b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m82b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m83b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m81c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m82c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m83c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m91b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m92b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m93b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m91c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m92c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m93c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m101b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m102b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m103b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m101c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m102c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m103c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m111b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m112b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m113b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m111c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m112c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m113c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m121b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m122b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m123b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m121c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m122c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m123c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m131b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m132b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m133b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m131c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m132c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m133c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m141b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m142b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m143b DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m141c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m142c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD m143c DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT tlt307 FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def3<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt101 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt301 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt302 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt303 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt304 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt305 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt306 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD tlt307 DECIMAL(2,0) DEFAULT 1 AFTER konx";
$vysledek = mysql_query("$sql");
}
//koniec upravy 2014

//koniec vytvor tabulku v databaze


//zapis upravene udaje strana 1
if ( $copern == 3 AND $strana == 1 )
    {
$ac11 = strip_tags($_REQUEST['ac11']);       
$ac12 = strip_tags($_REQUEST['ac12']);       
$ac21 = strip_tags($_REQUEST['ac21']);       
$ac22 = strip_tags($_REQUEST['ac22']);       
$ac31 = strip_tags($_REQUEST['ac31']);       
$ac32 = strip_tags($_REQUEST['ac32']); 

$tlt101 = 1*$_REQUEST['tlt101'];
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" ac11='$ac11', ac12='$ac12', ac21='$ac21', ac22='$ac22', ac31='$ac31', ac32='$ac32', ".
" tlt101='$tlt101', ".
" konx=0 ".
" WHERE ico >= 0"; 
//echo $uprtxt;

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
//koniec zapisu upravenych udajov strana 1


//zapis upravene udaje strana 2
if ( $copern == 3 AND $strana == 2 )
    {
$uprav="NO";
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" konx=0 ".
" WHERE ico >= 0";  
//echo $uprtxt;
  
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
//koniec zapisu upravenych udajov strana 2

// zapis upravene udaje strana 3
if ( $copern == 3 AND $strana == 3 )
    {
$gcd11 = strip_tags($_REQUEST['gcd11']);
$gcd12 = strip_tags($_REQUEST['gcd12']);
$gcd21 = strip_tags($_REQUEST['gcd21']);
$gcd22 = strip_tags($_REQUEST['gcd22']);
$gcd31 = strip_tags($_REQUEST['gcd31']);
$gcd32 = strip_tags($_REQUEST['gcd32']);
$gcd41 = strip_tags($_REQUEST['gcd41']);
$gcd42 = strip_tags($_REQUEST['gcd42']);
$gcd51 = strip_tags($_REQUEST['gcd51']);
$gcd52 = strip_tags($_REQUEST['gcd52']);
$gcd61 = strip_tags($_REQUEST['gcd61']);
$gcd62 = strip_tags($_REQUEST['gcd62']);

$gh11 = strip_tags($_REQUEST['gh11']);
$gh12 = strip_tags($_REQUEST['gh12']);
$gh13 = strip_tags($_REQUEST['gh13']);
$gh14 = strip_tags($_REQUEST['gh14']);
$gh15 = strip_tags($_REQUEST['gh15']);
$gh16 = strip_tags($_REQUEST['gh16']);
$gh21 = strip_tags($_REQUEST['gh21']);
$gh22 = strip_tags($_REQUEST['gh22']);
$gh23 = strip_tags($_REQUEST['gh23']);
$gh24 = strip_tags($_REQUEST['gh24']);
$gh25 = strip_tags($_REQUEST['gh25']);
$gh26 = strip_tags($_REQUEST['gh26']);
$gh31 = strip_tags($_REQUEST['gh31']);
$gh32 = strip_tags($_REQUEST['gh32']);
$gh33 = strip_tags($_REQUEST['gh33']);
$gh34 = strip_tags($_REQUEST['gh34']);
$gh35 = strip_tags($_REQUEST['gh35']);
$gh36 = strip_tags($_REQUEST['gh36']);
$gh41 = strip_tags($_REQUEST['gh41']);
$gh42 = strip_tags($_REQUEST['gh42']);
$gh43 = strip_tags($_REQUEST['gh43']);
$gh44 = strip_tags($_REQUEST['gh44']);
$gh45 = strip_tags($_REQUEST['gh45']);
$gh46 = strip_tags($_REQUEST['gh46']);    

$tlt301 = 1*$_REQUEST['tlt301'];
$tlt302 = 1*$_REQUEST['tlt302'];
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd11='$gcd11', gcd12='$gcd12', gcd21='$gcd21', gcd22='$gcd22', ".
" gcd31='$gcd31', gcd32='$gcd32', gcd41='$gcd41', gcd42='$gcd42', ".
" gcd51='$gcd51', gcd52='$gcd52', gcd61='$gcd61', gcd62='$gcd62', ".
" gh11='$gh11', gh12='$gh12', gh13='$gh13', gh14='$gh14', gh15='$gh15', gh16='$gh16', ". 
" gh21='$gh21', gh22='$gh22', gh23='$gh23', gh24='$gh24', gh25='$gh25', gh26='$gh26', ". 
" gh31='$gh31', gh32='$gh32', gh33='$gh33', gh34='$gh34', gh35='$gh35', gh36='$gh36', ".
" gh41='$gh41', gh42='$gh42', gh43='$gh43', gh44='$gh44', gh45='$gh45', gh46='$gh46', ".
" tlt301='$tlt301', tlt302='$tlt302', ".
" konx=0 ".        
" WHERE ico >= 0";  
//echo $uprtxt;
  
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
//koniec zapisu upravenych udajov strana 3

// zapis upravene udaje strana 4
if ( $copern == 3 AND $strana == 4 )
    {
$m11b = strip_tags($_REQUEST['m11b']);
$m12b = strip_tags($_REQUEST['m12b']);
$m13b = strip_tags($_REQUEST['m13b']);
$m11c = strip_tags($_REQUEST['m11c']);
$m12c = strip_tags($_REQUEST['m12c']);
$m13c = strip_tags($_REQUEST['m13c']);
$m21b = strip_tags($_REQUEST['m21b']);
$m22b = strip_tags($_REQUEST['m22b']);
$m23b = strip_tags($_REQUEST['m23b']);
$m21c = strip_tags($_REQUEST['m21c']);
$m22c = strip_tags($_REQUEST['m22c']);
$m23c = strip_tags($_REQUEST['m23c']);
$m31b = strip_tags($_REQUEST['m31b']);
$m32b = strip_tags($_REQUEST['m32b']);
$m33b = strip_tags($_REQUEST['m33b']);
$m31c = strip_tags($_REQUEST['m31c']);
$m32c = strip_tags($_REQUEST['m32c']);
$m33c = strip_tags($_REQUEST['m33c']);
$m41b = strip_tags($_REQUEST['m41b']);
$m42b = strip_tags($_REQUEST['m42b']);
$m43b = strip_tags($_REQUEST['m43b']);
$m41c = strip_tags($_REQUEST['m41c']);
$m42c = strip_tags($_REQUEST['m42c']);
$m43c = strip_tags($_REQUEST['m43c']);
$m51b = strip_tags($_REQUEST['m51b']);
$m52b = strip_tags($_REQUEST['m52b']);
$m53b = strip_tags($_REQUEST['m53b']);
$m51c = strip_tags($_REQUEST['m51c']);
$m52c = strip_tags($_REQUEST['m52c']);
$m53c = strip_tags($_REQUEST['m53c']);
$m61b = strip_tags($_REQUEST['m61b']);
$m62b = strip_tags($_REQUEST['m62b']);
$m63b = strip_tags($_REQUEST['m63b']);
$m61c = strip_tags($_REQUEST['m61c']);
$m62c = strip_tags($_REQUEST['m62c']);
$m63c = strip_tags($_REQUEST['m63c']);
$m71b = strip_tags($_REQUEST['m71b']);
$m72b = strip_tags($_REQUEST['m72b']);
$m73b = strip_tags($_REQUEST['m73b']);
$m71c = strip_tags($_REQUEST['m71c']);
$m72c = strip_tags($_REQUEST['m72c']);
$m73c = strip_tags($_REQUEST['m73c']);
$m81b = strip_tags($_REQUEST['m81b']);
$m82b = strip_tags($_REQUEST['m82b']);
$m83b = strip_tags($_REQUEST['m83b']);
$m81c = strip_tags($_REQUEST['m81c']);
$m82c = strip_tags($_REQUEST['m82c']);
$m83c = strip_tags($_REQUEST['m83c']);
$m91b = strip_tags($_REQUEST['m91b']);
$m92b = strip_tags($_REQUEST['m92b']);
$m93b = strip_tags($_REQUEST['m93b']);
$m91c = strip_tags($_REQUEST['m91c']);
$m92c = strip_tags($_REQUEST['m92c']);
$m93c = strip_tags($_REQUEST['m93c']);
$m101b = strip_tags($_REQUEST['m101b']);
$m102b = strip_tags($_REQUEST['m102b']);
$m103b = strip_tags($_REQUEST['m103b']);
$m101c = strip_tags($_REQUEST['m101c']);
$m102c = strip_tags($_REQUEST['m102c']);
$m103c = strip_tags($_REQUEST['m103c']);
$m111b = strip_tags($_REQUEST['m111b']);
$m112b = strip_tags($_REQUEST['m112b']);
$m113b = strip_tags($_REQUEST['m113b']);
$m111c = strip_tags($_REQUEST['m111c']);
$m112c = strip_tags($_REQUEST['m112c']);
$m113c = strip_tags($_REQUEST['m113c']);
$m121b = strip_tags($_REQUEST['m121b']);
$m122b = strip_tags($_REQUEST['m122b']);
$m123b = strip_tags($_REQUEST['m123b']);
$m121c = strip_tags($_REQUEST['m121c']);
$m122c = strip_tags($_REQUEST['m122c']);
$m123c = strip_tags($_REQUEST['m123c']);
$m131b = strip_tags($_REQUEST['m131b']);
$m132b = strip_tags($_REQUEST['m132b']);
$m133b = strip_tags($_REQUEST['m133b']);
$m131c = strip_tags($_REQUEST['m131c']);
$m132c = strip_tags($_REQUEST['m132c']);
$m133c = strip_tags($_REQUEST['m133c']);
$m141b = strip_tags($_REQUEST['m141b']);
$m142b = strip_tags($_REQUEST['m142b']);
$m143b = strip_tags($_REQUEST['m143b']);
$m141c = strip_tags($_REQUEST['m141c']);
$m142c = strip_tags($_REQUEST['m142c']);
$m143c = strip_tags($_REQUEST['m143c']);    

$tlt303 = 1*$_REQUEST['tlt303'];
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" m11b='$m11b', m12b='$m12b', m13b='$m13b', m11c='$m11c', m12c='$m12c', ". 
" m13c='$m13c', m21b='$m21b', m22b='$m22b', m23b='$m23b', m21c='$m21c', ".
" m22c='$m22c', m23c='$m23c', m31b='$m31b', m32b='$m32b', m33b='$m33b', ".
" m31c='$m31c', m32c='$m32c', m33c='$m33c', m41b='$m41b', m42b='$m42b', ".
" m43b='$m43b', m41c='$m41c', m42c='$m42c', m43c='$m43c', m51b='$m51b', ".
" m52b='$m52b', m53b='$m53b', m51c='$m51c', m52c='$m52c', m53c='$m53c', ".
" m61b='$m61b', m62b='$m62b', m63b='$m63b', m61c='$m61c', m62c='$m62c', ".
" m63c='$m63c', m71b='$m71b', m72b='$m72b', m73b='$m73b', m71c='$m71c', ".
" m72c='$m72c', m73c='$m73c', ". 
" m81b='$m81b', m82b='$m82b', m83b='$m83b', m81c='$m81c', m82c='$m82c', m83c='$m83c', ". 
" m91b='$m91b', m92b='$m92b', m93b='$m93b', m91c='$m91c', m92c='$m92c', m93c='$m93c', ". 
" m101b='$m101b', m102b='$m102b', m103b='$m103b', m101c='$m101c', ".
" m102c='$m102c', m103c='$m103c', m111b='$m111b', m112b='$m112b', ".
" m113b='$m113b', m111c='$m111c', m112c='$m112c', m113c='$m113c', ".
" m121b='$m121b', m122b='$m122b', m123b='$m123b', m121c='$m121c', ".
" m122c='$m122c', m123c='$m123c', m131b='$m131b', m132b='$m132b', ".
" m133b='$m133b', m131c='$m131c', m132c='$m132c', m133c='$m133c', ".
" m141b='$m141b', m142b='$m142b', m143b='$m143b', m141c='$m141c', ".
" m142c='$m142c', m143c='$m143c', ". 
" tlt303='$tlt303', ".
" konx=0 ".        
" WHERE ico >= 0";  
  
//echo $uprtxt;
  
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
//koniec zapisu upravenych udajov strana 4

// zapis upravene udaje strana 5
if ( $copern == 3 AND $strana == 5 )
    {
$k11 = strip_tags($_REQUEST['k11']);
$k12 = strip_tags($_REQUEST['k12']);
$k21 = strip_tags($_REQUEST['k21']);
$k22 = strip_tags($_REQUEST['k22']);
$k31 = strip_tags($_REQUEST['k31']);
$k32 = strip_tags($_REQUEST['k32']);
$k41 = strip_tags($_REQUEST['k41']);
$k42 = strip_tags($_REQUEST['k42']);
$k51 = strip_tags($_REQUEST['k51']);
$k52 = strip_tags($_REQUEST['k52']);
$k61 = strip_tags($_REQUEST['k61']);
$k62 = strip_tags($_REQUEST['k62']);
$k71 = strip_tags($_REQUEST['k71']);
$k72 = strip_tags($_REQUEST['k72']);
$k81 = strip_tags($_REQUEST['k81']);
$k82 = strip_tags($_REQUEST['k82']);
$k91 = strip_tags($_REQUEST['k91']);
$k92 = strip_tags($_REQUEST['k92']);
$l1ab11 = strip_tags($_REQUEST['l1ab11']);
$l1ab12 = strip_tags($_REQUEST['l1ab12']);
$l1ab21 = strip_tags($_REQUEST['l1ab21']);
$l1ab22 = strip_tags($_REQUEST['l1ab22']);
$l1ab31 = strip_tags($_REQUEST['l1ab31']);
$l1ab32 = strip_tags($_REQUEST['l1ab32']);
$l1ab41 = strip_tags($_REQUEST['l1ab41']);
$l1ab42 = strip_tags($_REQUEST['l1ab42']);
$l1ab51 = strip_tags($_REQUEST['l1ab51']);
$l1ab52 = strip_tags($_REQUEST['l1ab52']);
$l1ab61 = strip_tags($_REQUEST['l1ab61']);
$l1ab62 = strip_tags($_REQUEST['l1ab62']);
$l2ab11 = strip_tags($_REQUEST['l2ab11']);
$l2ab12 = strip_tags($_REQUEST['l2ab12']);
$l2ab21 = strip_tags($_REQUEST['l2ab21']);
$l2ab22 = strip_tags($_REQUEST['l2ab22']);
$l2ab31 = strip_tags($_REQUEST['l2ab31']);
$l2ab32 = strip_tags($_REQUEST['l2ab32']);
$l2ab41 = strip_tags($_REQUEST['l2ab41']);
$l2ab42 = strip_tags($_REQUEST['l2ab42']);
$l2ab51 = strip_tags($_REQUEST['l2ab51']);
$l2ab52 = strip_tags($_REQUEST['l2ab52']);
$l2ab61 = strip_tags($_REQUEST['l2ab61']);
$l2ab62 = strip_tags($_REQUEST['l2ab62']);
$lc11 = strip_tags($_REQUEST['lc11']);
$lc12 = strip_tags($_REQUEST['lc12']);
$lc21 = strip_tags($_REQUEST['lc21']);
$lc22 = strip_tags($_REQUEST['lc22']);
$lc31 = strip_tags($_REQUEST['lc31']);
$lc32 = strip_tags($_REQUEST['lc32']);
$lc41 = strip_tags($_REQUEST['lc41']);
$lc42 = strip_tags($_REQUEST['lc42']);
$lc51 = strip_tags($_REQUEST['lc51']);
$lc52 = strip_tags($_REQUEST['lc52']);
$lc61 = strip_tags($_REQUEST['lc61']);
$lc62 = strip_tags($_REQUEST['lc62']);
$lc71 = strip_tags($_REQUEST['lc71']);
$lc72 = strip_tags($_REQUEST['lc72']);
$lc81 = strip_tags($_REQUEST['lc81']);
$lc82 = strip_tags($_REQUEST['lc82']);    

$tlt304 = 1*$_REQUEST['tlt304'];
$tlt305 = 1*$_REQUEST['tlt305'];
$tlt306 = 1*$_REQUEST['tlt306'];
$tlt307 = 1*$_REQUEST['tlt307'];
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" k11='$k11', k12='$k12', k21='$k21', k22='$k22', k31='$k31',
  k32='$k32', k41='$k41', k42='$k42', k51='$k51', k52='$k52',
  k61='$k61', k62='$k62', k71='$k71', k72='$k72', k81='$k81',
  k82='$k82', k91='$k91', k92='$k92', 
  l1ab11='$l1ab11', l1ab12='$l1ab12', l1ab21='$l1ab21',
  l1ab22='$l1ab22', l1ab31='$l1ab31', l1ab32='$l1ab32',
  l1ab41='$l1ab41', l1ab42='$l1ab42', l1ab51='$l1ab51', 
  l1ab52='$l1ab52', l1ab61='$l1ab61', l1ab62='$l1ab62',
  l2ab11='$l2ab11', l2ab12='$l2ab12', l2ab21='$l2ab21',
  l2ab22='$l2ab22', l2ab31='$l2ab31', l2ab32='$l2ab32',
  l2ab41='$l2ab41', l2ab42='$l2ab42', l2ab51='$l2ab51',
  l2ab52='$l2ab52', l2ab61='$l2ab61', l2ab62='$l2ab62',
  lc11='$lc11', lc12='$lc12', lc21='$lc21', lc22='$lc22',
  lc31='$lc31', lc32='$lc32', lc41='$lc41', lc42='$lc42',
  lc51='$lc51', lc52='$lc52', lc61='$lc61', lc62='$lc62',
  lc71='$lc71', lc72='$lc72', lc81='$lc81', lc82='$lc82', ".
" tlt304='$tlt304', tlt305='$tlt305', tlt306='$tlt306', tlt307='$tlt307', ".
" konx=0 ".        
" WHERE ico >= 0";  
//echo $uprtxt;
  
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
//koniec zapisu upravenych udajov strana 5

//prepocet kontrolnych cisiel
if( $copern == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd31=gcd11+gcd21,".
" gcd32=gcd12+gcd22,".
" gcd61=gcd41+gcd51,".
" gcd62=gcd42+gcd52 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");
   }
//koniec prepocet kontrolnych cisiel


//nacitaj udaje
if ( $copern >= 1 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$ac11 = $fir_riadok->ac11;
$ac12 = $fir_riadok->ac12;
$ac21 = $fir_riadok->ac21;
$ac22 = $fir_riadok->ac22;
$ac31 = $fir_riadok->ac31;
$ac32 = $fir_riadok->ac32;

$gcd11 = $fir_riadok->gcd11;
$gcd12 = $fir_riadok->gcd12;
$gcd21 = $fir_riadok->gcd21;
$gcd22 = $fir_riadok->gcd22;
$gcd31 = $fir_riadok->gcd31;
$gcd32 = $fir_riadok->gcd32;
$gcd41 = $fir_riadok->gcd41;
$gcd42 = $fir_riadok->gcd42;
$gcd51 = $fir_riadok->gcd51;
$gcd52 = $fir_riadok->gcd52;
$gcd61 = $fir_riadok->gcd61;
$gcd62 = $fir_riadok->gcd62;

$gh11 = $fir_riadok->gh11;
$gh12 = $fir_riadok->gh12;
$gh13 = $fir_riadok->gh13;
$gh14 = $fir_riadok->gh14;
$gh15 = $fir_riadok->gh15;
$gh16 = $fir_riadok->gh16;
$gh21 = $fir_riadok->gh21;
$gh22 = $fir_riadok->gh22;
$gh23 = $fir_riadok->gh23;
$gh24 = $fir_riadok->gh24;
$gh25 = $fir_riadok->gh25;
$gh26 = $fir_riadok->gh26;
$gh31 = $fir_riadok->gh31;
$gh32 = $fir_riadok->gh32;
$gh33 = $fir_riadok->gh33;
$gh34 = $fir_riadok->gh34;
$gh35 = $fir_riadok->gh35;
$gh36 = $fir_riadok->gh36;
$gh41 = $fir_riadok->gh41;
$gh42 = $fir_riadok->gh42;
$gh43 = $fir_riadok->gh43;
$gh44 = $fir_riadok->gh44;
$gh45 = $fir_riadok->gh45;
$gh46 = $fir_riadok->gh46;

$m11b = $fir_riadok->m11b;
$m12b = $fir_riadok->m12b;
$m13b = $fir_riadok->m13b;
$m11c = $fir_riadok->m11c;
$m12c = $fir_riadok->m12c;
$m13c = $fir_riadok->m13c;
$m21b = $fir_riadok->m21b;
$m22b = $fir_riadok->m22b;
$m23b = $fir_riadok->m23b;
$m21c = $fir_riadok->m21c;
$m22c = $fir_riadok->m22c;
$m23c = $fir_riadok->m23c;
$m31b = $fir_riadok->m31b;
$m32b = $fir_riadok->m32b;
$m33b = $fir_riadok->m33b;
$m31c = $fir_riadok->m31c;
$m32c = $fir_riadok->m32c;
$m33c = $fir_riadok->m33c;
$m41b = $fir_riadok->m41b;
$m42b = $fir_riadok->m42b;
$m43b = $fir_riadok->m43b;
$m41c = $fir_riadok->m41c;
$m42c = $fir_riadok->m42c;
$m43c = $fir_riadok->m43c;
$m51b = $fir_riadok->m51b;
$m52b = $fir_riadok->m52b;
$m53b = $fir_riadok->m53b;
$m51c = $fir_riadok->m51c;
$m52c = $fir_riadok->m52c;
$m53c = $fir_riadok->m53c;
$m61b = $fir_riadok->m61b;
$m62b = $fir_riadok->m62b;
$m63b = $fir_riadok->m63b;
$m61c = $fir_riadok->m61c;
$m62c = $fir_riadok->m62c;
$m63c = $fir_riadok->m63c;
$m71b = $fir_riadok->m71b;
$m72b = $fir_riadok->m72b;
$m73b = $fir_riadok->m73b;
$m71c = $fir_riadok->m71c;
$m72c = $fir_riadok->m72c;
$m73c = $fir_riadok->m73c;
$m81b = $fir_riadok->m81b;
$m82b = $fir_riadok->m82b;
$m83b = $fir_riadok->m83b;
$m81c = $fir_riadok->m81c;
$m82c = $fir_riadok->m82c;
$m83c = $fir_riadok->m83c;
$m91b = $fir_riadok->m91b;
$m92b = $fir_riadok->m92b;
$m93b = $fir_riadok->m93b;
$m91c = $fir_riadok->m91c;
$m92c = $fir_riadok->m92c;
$m93c = $fir_riadok->m93c;
$m101b = $fir_riadok->m101b;
$m102b = $fir_riadok->m102b;
$m103b = $fir_riadok->m103b;
$m101c = $fir_riadok->m101c;
$m102c = $fir_riadok->m102c;
$m103c = $fir_riadok->m103c;
$m111b = $fir_riadok->m111b;
$m112b = $fir_riadok->m112b;
$m113b = $fir_riadok->m113b;
$m111c = $fir_riadok->m111c;
$m112c = $fir_riadok->m112c;
$m113c = $fir_riadok->m113c;
$m121b = $fir_riadok->m121b;
$m122b = $fir_riadok->m122b;
$m123b = $fir_riadok->m123b;
$m121c = $fir_riadok->m121c;
$m122c = $fir_riadok->m122c;
$m123c = $fir_riadok->m123c;
$m131b = $fir_riadok->m131b;
$m132b = $fir_riadok->m132b;
$m133b = $fir_riadok->m133b;
$m131c = $fir_riadok->m131c;
$m132c = $fir_riadok->m132c;
$m133c = $fir_riadok->m133c;
$m141b = $fir_riadok->m141b;
$m142b = $fir_riadok->m142b;
$m143b = $fir_riadok->m143b;
$m141c = $fir_riadok->m141c;
$m142c = $fir_riadok->m142c;
$m143c = $fir_riadok->m143c;

$k11 = $fir_riadok->k11;
$k12 = $fir_riadok->k12;
$k21 = $fir_riadok->k21;
$k22 = $fir_riadok->k22;
$k31 = $fir_riadok->k31;
$k32 = $fir_riadok->k32;
$k41 = $fir_riadok->k41;
$k42 = $fir_riadok->k42;
$k51 = $fir_riadok->k51;
$k52 = $fir_riadok->k52;
$k61 = $fir_riadok->k61;
$k62 = $fir_riadok->k62;
$k71 = $fir_riadok->k71;
$k72 = $fir_riadok->k72;
$k81 = $fir_riadok->k81;
$k82 = $fir_riadok->k82;
$k91 = $fir_riadok->k91;
$k92 = $fir_riadok->k92;
$l1ab11 = $fir_riadok->l1ab11;
$l1ab12 = $fir_riadok->l1ab12;
$l1ab21 = $fir_riadok->l1ab21;
$l1ab22 = $fir_riadok->l1ab22;
$l1ab31 = $fir_riadok->l1ab31;
$l1ab32 = $fir_riadok->l1ab32;
$l1ab41 = $fir_riadok->l1ab41;
$l1ab42 = $fir_riadok->l1ab42;
$l1ab51 = $fir_riadok->l1ab51;
$l1ab52 = $fir_riadok->l1ab52;
$l1ab61 = $fir_riadok->l1ab61;
$l1ab62 = $fir_riadok->l1ab62;
$l2ab11 = $fir_riadok->l2ab11;                           
$l2ab12 = $fir_riadok->l2ab12;
$l2ab21 = $fir_riadok->l2ab21;
$l2ab22 = $fir_riadok->l2ab22;
$l2ab31 = $fir_riadok->l2ab31;
$l2ab32 = $fir_riadok->l2ab32;
$l2ab41 = $fir_riadok->l2ab41;
$l2ab42 = $fir_riadok->l2ab42;
$l2ab51 = $fir_riadok->l2ab51;
$l2ab52 = $fir_riadok->l2ab52;
$l2ab61 = $fir_riadok->l2ab61;
$l2ab62 = $fir_riadok->l2ab62;
$lc11 = $fir_riadok->lc11;
$lc12 = $fir_riadok->lc12;
$lc21 = $fir_riadok->lc21;
$lc22 = $fir_riadok->lc22;
$lc31 = $fir_riadok->lc31;
$lc32 = $fir_riadok->lc32;
$lc41 = $fir_riadok->lc41;
$lc42 = $fir_riadok->lc42;
$lc51 = $fir_riadok->lc51;
$lc52 = $fir_riadok->lc52;
$lc61 = $fir_riadok->lc61;
$lc62 = $fir_riadok->lc62;
$lc71 = $fir_riadok->lc71;
$lc72 = $fir_riadok->lc72;
$lc81 = $fir_riadok->lc81;
$lc82 = $fir_riadok->lc82;

$tlt101 = 1*$fir_riadok->tlt101;
$tlt301 = 1*$fir_riadok->tlt301;
$tlt302 = 1*$fir_riadok->tlt302;
$tlt303 = 1*$fir_riadok->tlt303;
$tlt304 = 1*$fir_riadok->tlt304;
$tlt305 = 1*$fir_riadok->tlt305;
$tlt306 = 1*$fir_riadok->tlt306;
$tlt307 = 1*$fir_riadok->tlt307;

mysql_free_result($fir_vysledok);
    }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>Pozn·mky k ˙Ët. z·vierke MUJ 2014</title>
<style>
div.form-background {
  overflow: hidden;
  width: 950px;
  background-color: #fff;
}
h1.section-header {
  height: 18px;
  margin-top: 18px;
  font-weight: bold;
  font-size: 18px;
  text-align: center;
}
h1.section-header > span, h2.section-subheader:before,
h2.section-subheader > span {
  color: #999;
}
h1.section-header > span {
  padding-right: 7px;
}
h2.section-subheader {
  height: 14px;
  font-size: 14px;
  margin: 15px 0 4px 20px;
}
h2.section-subheader:before {
  content:'ï';
}
h2.section-subheader > span {
  padding: 0 7px;
  font-weight: bold;
}
span.section-echo {
  display: inline-block;
  margin-left: 35px;
  padding: 7px 12px 5px 12px;
  border-left: 3px solid #39f;
  background-color: #ececec;
  font-size:12px;
}
span.section-echo > img, table.section-table thead img {
  display: inline-block;
  cursor: pointer;
}
span.section-echo > img {
  width: 16px;
  height: 16px;
  vertical-align: -3px;
  margin-left: 12px;
}
table.section-table {
  position: relative;
  top: 0;
  left: 0;
  margin: 0 0 15px 35px;
  border-left: 3px solid #39f;
}
table.section-table caption { /* dopyt, asi preË */
  text-transform: uppercase;
  font-size: 13px;
  text-align: left;
  padding-bottom: 3px;
}
table.section-table thead th {
  font-size: 11px;
  line-height: 20px;
  background-color: #dbdbdb;
}
table.section-table tbody th {
  font-size: 12px;
  text-indent: 5px;
  line-height: 24px;
  text-align: left;
  font-weight: normal;
  background-color: #ececec;
  border-top: 2px solid #dbdbdb;
}
table.section-table tbody td {
  background-color: #ececec;
  text-align:center;
  line-height: 24px;
  border-top: 2px solid #dbdbdb;
}
table.section-table tfoot td {
  height: 2px;
  background-color: #ececec;
}
table.section-table input[type=checkbox] {
  position: absolute;
  top: 2px;
  left: 5px;
}
table.section-table thead img {
  width: 14px;
  height: 14px;
  vertical-align: -4px;
}
table.section-table input[type=text] {
  position: static;
  width: 64px;
  font-size: 12px;
  line-height: 14px;
  height: 14px;
  padding: 1px 2px;
}
tr.head-line > td { /* urcenie sirky stlpcov */
  height: 0;
}
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
if ( $copern == 1 )
{
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.ac11.value = '<?php echo "$ac11";?>';
   document.formv1.ac12.value = '<?php echo "$ac12";?>';
   document.formv1.ac21.value = '<?php echo "$ac21";?>';
   document.formv1.ac22.value = '<?php echo "$ac22";?>';
   document.formv1.ac31.value = '<?php echo "$ac31";?>';
   document.formv1.ac32.value = '<?php echo "$ac32";?>';
<?php if ( $tlt101 == 1 ) { ?> document.formv1.tlt101.checked = "checked"; <?php } ?>
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.gcd11.value = '<?php echo "$gcd11";?>';
   document.formv1.gcd12.value = '<?php echo "$gcd12";?>';
   document.formv1.gcd21.value = '<?php echo "$gcd21";?>';
   document.formv1.gcd22.value = '<?php echo "$gcd22";?>';
   document.formv1.gcd31.value = '<?php echo "$gcd31";?>';
   document.formv1.gcd32.value = '<?php echo "$gcd32";?>';
   document.formv1.gcd41.value = '<?php echo "$gcd41";?>';
   document.formv1.gcd42.value = '<?php echo "$gcd42";?>';
   document.formv1.gcd51.value = '<?php echo "$gcd51";?>';
   document.formv1.gcd52.value = '<?php echo "$gcd52";?>';
   document.formv1.gcd61.value = '<?php echo "$gcd61";?>';
   document.formv1.gcd62.value = '<?php echo "$gcd62";?>';

   document.formv1.gh11.value = '<?php echo "$gh11";?>';
   document.formv1.gh12.value = '<?php echo "$gh12";?>';
   document.formv1.gh13.value = '<?php echo "$gh13";?>';
   document.formv1.gh14.value = '<?php echo "$gh14";?>';
   document.formv1.gh15.value = '<?php echo "$gh15";?>';
   document.formv1.gh16.value = '<?php echo "$gh16";?>';
   document.formv1.gh21.value = '<?php echo "$gh21";?>';
   document.formv1.gh22.value = '<?php echo "$gh22";?>';
   document.formv1.gh23.value = '<?php echo "$gh23";?>';
   document.formv1.gh24.value = '<?php echo "$gh24";?>';
   document.formv1.gh25.value = '<?php echo "$gh25";?>';
   document.formv1.gh26.value = '<?php echo "$gh26";?>';
   document.formv1.gh31.value = '<?php echo "$gh31";?>';
   document.formv1.gh32.value = '<?php echo "$gh32";?>';
   document.formv1.gh33.value = '<?php echo "$gh33";?>';
   document.formv1.gh34.value = '<?php echo "$gh34";?>';
   document.formv1.gh35.value = '<?php echo "$gh35";?>';
   document.formv1.gh36.value = '<?php echo "$gh36";?>';
   document.formv1.gh41.value = '<?php echo "$gh41";?>';
   document.formv1.gh42.value = '<?php echo "$gh42";?>';
   document.formv1.gh43.value = '<?php echo "$gh43";?>';
   document.formv1.gh44.value = '<?php echo "$gh44";?>';
   document.formv1.gh45.value = '<?php echo "$gh45";?>';
   document.formv1.gh46.value = '<?php echo "$gh46";?>';
<?php if ( $tlt301 == 1 ) { ?> document.formv1.tlt301.checked = "checked"; <?php } ?>
<?php if ( $tlt302 == 1 ) { ?> document.formv1.tlt302.checked = "checked"; <?php } ?>
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.m11b.value = '<?php echo "$m11b";?>';
   document.formv1.m12b.value = '<?php echo "$m12b";?>';
   document.formv1.m13b.value = '<?php echo "$m13b";?>';
   document.formv1.m11c.value = '<?php echo "$m11c";?>';
   document.formv1.m12c.value = '<?php echo "$m12c";?>';
   document.formv1.m13c.value = '<?php echo "$m13c";?>';
   document.formv1.m21b.value = '<?php echo "$m21b";?>';
   document.formv1.m22b.value = '<?php echo "$m22b";?>';
   document.formv1.m23b.value = '<?php echo "$m23b";?>';
   document.formv1.m21c.value = '<?php echo "$m21c";?>';
   document.formv1.m22c.value = '<?php echo "$m22c";?>';
   document.formv1.m23c.value = '<?php echo "$m23c";?>';
   document.formv1.m31b.value = '<?php echo "$m31b";?>';
   document.formv1.m32b.value = '<?php echo "$m32b";?>';
   document.formv1.m33b.value = '<?php echo "$m33b";?>';
   document.formv1.m31c.value = '<?php echo "$m31c";?>';
   document.formv1.m32c.value = '<?php echo "$m32c";?>';
   document.formv1.m33c.value = '<?php echo "$m33c";?>';
   document.formv1.m41b.value = '<?php echo "$m41b";?>';
   document.formv1.m42b.value = '<?php echo "$m42b";?>';
   document.formv1.m43b.value = '<?php echo "$m43b";?>';
   document.formv1.m41c.value = '<?php echo "$m41c";?>';
   document.formv1.m42c.value = '<?php echo "$m42c";?>';
   document.formv1.m43c.value = '<?php echo "$m43c";?>';
   document.formv1.m51b.value = '<?php echo "$m51b";?>';
   document.formv1.m52b.value = '<?php echo "$m52b";?>';
   document.formv1.m53b.value = '<?php echo "$m53b";?>';
   document.formv1.m51c.value = '<?php echo "$m51c";?>';
   document.formv1.m52c.value = '<?php echo "$m52c";?>';
   document.formv1.m53c.value = '<?php echo "$m53c";?>';
   document.formv1.m61b.value = '<?php echo "$m61b";?>';
   document.formv1.m62b.value = '<?php echo "$m62b";?>';
   document.formv1.m63b.value = '<?php echo "$m63b";?>';
   document.formv1.m61c.value = '<?php echo "$m61c";?>';
   document.formv1.m62c.value = '<?php echo "$m62c";?>';
   document.formv1.m63c.value = '<?php echo "$m63c";?>';
   document.formv1.m71b.value = '<?php echo "$m71b";?>';
   document.formv1.m72b.value = '<?php echo "$m72b";?>';
   document.formv1.m73b.value = '<?php echo "$m73b";?>';
   document.formv1.m71c.value = '<?php echo "$m71c";?>';
   document.formv1.m72c.value = '<?php echo "$m72c";?>';
   document.formv1.m73c.value = '<?php echo "$m73c";?>';
   document.formv1.m81b.value = '<?php echo "$m81b";?>';
   document.formv1.m82b.value = '<?php echo "$m82b";?>';
   document.formv1.m83b.value = '<?php echo "$m83b";?>';
   document.formv1.m81c.value = '<?php echo "$m81c";?>';
   document.formv1.m82c.value = '<?php echo "$m82c";?>';
   document.formv1.m83c.value = '<?php echo "$m83c";?>';
   document.formv1.m91b.value = '<?php echo "$m91b";?>';
   document.formv1.m92b.value = '<?php echo "$m92b";?>';
   document.formv1.m93b.value = '<?php echo "$m93b";?>';
   document.formv1.m91c.value = '<?php echo "$m91c";?>';
   document.formv1.m92c.value = '<?php echo "$m92c";?>';
   document.formv1.m93c.value = '<?php echo "$m93c";?>';
   document.formv1.m101b.value = '<?php echo "$m101b";?>';
   document.formv1.m102b.value = '<?php echo "$m102b";?>';
   document.formv1.m103b.value = '<?php echo "$m103b";?>';
   document.formv1.m101c.value = '<?php echo "$m101c";?>';
   document.formv1.m102c.value = '<?php echo "$m102c";?>';
   document.formv1.m103c.value = '<?php echo "$m103c";?>';
   document.formv1.m111b.value = '<?php echo "$m111b";?>';
   document.formv1.m112b.value = '<?php echo "$m112b";?>';
   document.formv1.m113b.value = '<?php echo "$m113b";?>';
   document.formv1.m111c.value = '<?php echo "$m111c";?>';
   document.formv1.m112c.value = '<?php echo "$m112c";?>';
   document.formv1.m113c.value = '<?php echo "$m113c";?>';
   document.formv1.m121b.value = '<?php echo "$m121b";?>';
   document.formv1.m122b.value = '<?php echo "$m122b";?>';
   document.formv1.m123b.value = '<?php echo "$m123b";?>';
   document.formv1.m121c.value = '<?php echo "$m121c";?>';
   document.formv1.m122c.value = '<?php echo "$m122c";?>';
   document.formv1.m123c.value = '<?php echo "$m123c";?>';
   document.formv1.m131b.value = '<?php echo "$m131b";?>';
   document.formv1.m132b.value = '<?php echo "$m132b";?>';
   document.formv1.m133b.value = '<?php echo "$m133b";?>';
   document.formv1.m131c.value = '<?php echo "$m131c";?>';
   document.formv1.m132c.value = '<?php echo "$m132c";?>';
   document.formv1.m133c.value = '<?php echo "$m133c";?>';
   document.formv1.m141b.value = '<?php echo "$m141b";?>';
   document.formv1.m142b.value = '<?php echo "$m142b";?>';
   document.formv1.m143b.value = '<?php echo "$m143b";?>';
   document.formv1.m141c.value = '<?php echo "$m141c";?>';
   document.formv1.m142c.value = '<?php echo "$m142c";?>';
   document.formv1.m143c.value = '<?php echo "$m143c";?>';
<?php if ( $tlt303 == 1 ) { ?> document.formv1.tlt303.checked = "checked"; <?php } ?>
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   document.formv1.k11.value = '<?php echo "$k11";?>';
   document.formv1.k12.value = '<?php echo "$k12";?>';
   document.formv1.k21.value = '<?php echo "$k21";?>';
   document.formv1.k22.value = '<?php echo "$k22";?>';
   document.formv1.k31.value = '<?php echo "$k31";?>';
   document.formv1.k32.value = '<?php echo "$k32";?>';
   document.formv1.k41.value = '<?php echo "$k41";?>';
   document.formv1.k42.value = '<?php echo "$k42";?>';
   document.formv1.k51.value = '<?php echo "$k51";?>';
   document.formv1.k52.value = '<?php echo "$k52";?>';
   document.formv1.k61.value = '<?php echo "$k61";?>';
   document.formv1.k62.value = '<?php echo "$k62";?>';
   document.formv1.k71.value = '<?php echo "$k71";?>';
   document.formv1.k72.value = '<?php echo "$k72";?>';
   document.formv1.k81.value = '<?php echo "$k81";?>';
   document.formv1.k82.value = '<?php echo "$k82";?>';
   document.formv1.k91.value = '<?php echo "$k91";?>';
   document.formv1.k92.value = '<?php echo "$k92";?>';
   document.formv1.l1ab11.value = '<?php echo "$l1ab11";?>';
   document.formv1.l1ab12.value = '<?php echo "$l1ab12";?>';
   document.formv1.l1ab21.value = '<?php echo "$l1ab21";?>';
   document.formv1.l1ab22.value = '<?php echo "$l1ab22";?>';
   document.formv1.l1ab31.value = '<?php echo "$l1ab31";?>';
   document.formv1.l1ab32.value = '<?php echo "$l1ab32";?>';
   document.formv1.l1ab41.value = '<?php echo "$l1ab41";?>';
   document.formv1.l1ab42.value = '<?php echo "$l1ab42";?>';
   document.formv1.l1ab51.value = '<?php echo "$l1ab51";?>';
   document.formv1.l1ab52.value = '<?php echo "$l1ab52";?>';
   document.formv1.l1ab61.value = '<?php echo "$l1ab61";?>';
   document.formv1.l1ab62.value = '<?php echo "$l1ab62";?>';
   document.formv1.l2ab11.value = '<?php echo "$l2ab11";?>';
   document.formv1.l2ab12.value = '<?php echo "$l2ab12";?>';
   document.formv1.l2ab21.value = '<?php echo "$l2ab21";?>';
   document.formv1.l2ab22.value = '<?php echo "$l2ab22";?>';
   document.formv1.l2ab31.value = '<?php echo "$l2ab31";?>';
   document.formv1.l2ab32.value = '<?php echo "$l2ab32";?>';
   document.formv1.l2ab41.value = '<?php echo "$l2ab41";?>';
   document.formv1.l2ab42.value = '<?php echo "$l2ab42";?>';
   document.formv1.l2ab51.value = '<?php echo "$l2ab51";?>';
   document.formv1.l2ab52.value = '<?php echo "$l2ab52";?>';
   document.formv1.l2ab61.value = '<?php echo "$l2ab61";?>';
   document.formv1.l2ab62.value = '<?php echo "$l2ab62";?>';
   document.formv1.lc11.value = '<?php echo "$lc11";?>';
   document.formv1.lc12.value = '<?php echo "$lc12";?>';
   document.formv1.lc21.value = '<?php echo "$lc21";?>';
   document.formv1.lc22.value = '<?php echo "$lc22";?>';
   document.formv1.lc31.value = '<?php echo "$lc31";?>';
   document.formv1.lc32.value = '<?php echo "$lc32";?>';
   document.formv1.lc41.value = '<?php echo "$lc41";?>';
   document.formv1.lc42.value = '<?php echo "$lc42";?>';
   document.formv1.lc51.value = '<?php echo "$lc51";?>';
   document.formv1.lc52.value = '<?php echo "$lc52";?>';
   document.formv1.lc61.value = '<?php echo "$lc61";?>';
   document.formv1.lc62.value = '<?php echo "$lc62";?>';
   document.formv1.lc71.value = '<?php echo "$lc71";?>';
   document.formv1.lc72.value = '<?php echo "$lc72";?>';
   document.formv1.lc81.value = '<?php echo "$lc81";?>';
   document.formv1.lc82.value = '<?php echo "$lc82";?>';
<?php if ( $tlt304 == 1 ) { ?> document.formv1.tlt304.checked = "checked"; <?php } ?>
<?php if ( $tlt305 == 1 ) { ?> document.formv1.tlt305.checked = "checked"; <?php } ?>
<?php if ( $tlt306 == 1 ) { ?> document.formv1.tlt306.checked = "checked"; <?php } ?>
<?php if ( $tlt307 == 1 ) { ?> document.formv1.tlt307.checked = "checked"; <?php } ?>
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

  function TlacPoznamkyMUJ2014()
  {
   window.open('../ucto/poznamky_muj2014tlac.php?cislo_oc=0&h_zos=&h_sch=&h_drp=1&copern=10&drupoh=1&page=9999&strana=9999&subor=0',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacPoznamkyMUJ2014bez1()
  {
   window.open('../ucto/poznamky_muj2014tlac.php?cislo_oc=0&h_zos=&h_sch=&h_drp=1&copern=10&drupoh=1&page=9999&strana=9999&subor=0&bez1=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function upravtext( oscx )
  {
   var h_osc = oscx;
   window.open('poznamky_muj2014texty.php?h_ozntxt=' + h_osc + '&copern=1&drupoh=1&page=1', '_blank', 'width=900, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes');
  }
  function minulyrok( strana )
  {
   window.open('../ucto/poznamky_muj2014nacitaj.php?copern=1999&stranax=' + strana + '&drupoh=1&page=1&dopoz=0&xxc=1', '_self' );
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//zobraz a uprav udaje
if ( $copern == 1 )
{
?>
<!-- zahlavie -->
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Pozn·mky k ˙Ëtovnej z·vierke MUJ 2014</td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacPoznamkyMUJ2014bez1();"
      title="Zobraziù vöetky - bez prvej strany - v PDF" class="btn-form-tool"
      style="width:16px; height:16px; margin-top:2px;">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacPoznamkyMUJ2014();"
      title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<?php
  function vypistextx($ktorytext, $mysqlhostx, $mysqluserx, $mysqlpasswdx, $mysqldbx, $kli_vxcf)
  {
  @$spojeni = mysql_connect($mysqlhostx, $mysqluserx, $mysqlpasswdx);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldbx);

$ozntext=$ktorytext;
$textvypis="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }
$dlzkatxt=strlen($textvypis);
$textvypis=substr($textvypis,0,60);
if ( $dlzkatxt > 60 ) { $textvypis=$textvypis."..."; }
     return $textvypis;
  }
?>
<div id="content">
<FORM name="formv1" method="post" action="poznamky_muj2014.php?copern=3&strana=<?php echo "$strana"; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active";
$source="../ucto/poznamky_muj2014.php?copern=1";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>
<div class="form-background">

<?php if ( $strana == 1 ) { ?>
<h1 class="section-header"><span>Ël.I</span>VöeobecnÈ ˙daje</h1>
<h2 class="section-subheader"><span>Ël.I.1</span>N·zov pr·vnickej osoby (PO) / meno a priezvisko fyzickej osoby (FO) a jej sÌdlo / adresa</h2>
<?php
$nazovsidlo=$fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$nazovsidlo=$fir_riadok->dmeno." ".$fir_riadok->dprie;
}
?>
<span class="section-echo"><?php echo $nazovsidlo; ?></span>

<h2 class="section-subheader"><span>Ël.I.2</span>⁄daje o konsolidovanom celku</h2>
<span class="section-echo">
<?php
$ozntext="A_text1";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.I.3</span>Priemern˝ prepoËÌtan˝ poËet zamestnancov</h2>
<table class="section-table" style="width:550px; margin-bottom:10px;">
<thead>
<tr>
 <td class="head-line" style="width:60%;"></td>
 <td class="head-line" style="width:20%;"></td>
 <td class="head-line" style="width:20%;"></td>
</tr>
<tr>
 <th>
  <input type="checkbox" name="tlt101" value="1" title="Zaradiù tabuæku do PDF"
   style=""/>
 </th>
 <th><?php echo $kli_vrok; ?></th>
 <th><?php echo $kli_minrok; ?>
  <img src="../obr/ikony/download_blue_icon.png" onclick="minulyrok(<?php echo $strana;?>)"
   title="NaËÌtaù hodnoty z Pozn·mok PO 2013">
 </th>
</tr>
</thead>
<tbody>
<tr>
 <th>Priemern˝ prepoËÌtan˝ poËet zamestnancov</th>
 <td><input type="text" name="ac11" id="ac11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="ac12" id="ac12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Stav zamestnancov ku dÚu zostavenia ⁄Z, z toho:</th>
 <td><input type="text" name="ac21" id="ac21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="ac22" id="ac22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>&nbsp;- poËet ved˙cich zamestnancov</th>
 <td><input type="text" name="ac31" id="ac31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="ac32" id="ac32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="3"></td></tr>
</tfoot>
</table>

<span class="section-echo" style="margin-bottom:15px;">
<?php
$ozntext="A_text2";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<h1 class="section-header"><span>Ël.II</span>Inform·cie o prijat˝ch postupoch</h1>
<h2 class="section-subheader"><span>Ël.II.1</span>NepretrûitÈ pokraËovanie v Ëinnosti</h2>
<span class="section-echo">
<?php
$ozntext="B_text1";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.II.2</span>SpÙsob oceÚovania jednotliv˝ch poloûiek majetku a z·v‰zkov</h2>
<span class="section-echo">
<?php
$ozntext="B_text2";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.II.3</span>SpÙsob zostavenia odpisovÈho pl·nu majetku</h2>
<span class="section-echo">
<?php
$ozntext="B_text3";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.II.4</span>Zmeny ˙Ëtovn˝ch z·sad a zmeny ˙Ëtovn˝ch metÛd</h2>
<span class="section-echo">
<?php
$ozntext="B_text4";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.II.5</span>Inform·cie o dot·ci·ch a ich oceÚovanie v ˙ËtovnÌctve</h2>
<span class="section-echo">
<?php
$ozntext="B_text5";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.II.6</span>Inform·cie o ˙ËtovanÌ v˝znamn˝ch opr·v ch˝b minul˝ch ˙Ëtovn˝ch obdobÌ v beûnom ˙Ëtovnom obdobÌ</h2>
<span class="section-echo" style="margin-bottom:15px;">
<?php
$ozntext="B_text6";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<h1 class="section-header"><span>Ël.III</span>Inform·cie, ktorÈ vysvetæuj˙ a dopÂÚaj˙ s˙vahu a v˝kaz ziskov a str·t</h1>
<h2 class="section-subheader"><span>Ël.III.1</span>Inform·cia o sume a dÙvodoch vzniku jednotliv˝ch poloûiek n·kladov alebo v˝nosov, ktorÈ maj˙ v˝nimoËn˝ rozsah</h2>
<span class="section-echo">
<?php
$ozntext="C_text1";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<h2 class="section-subheader"><span>Ël.III.2</span>Inform·cie o z·v‰zkoch</h2>
<span class="section-echo" style="margin-bottom:10px;">
<?php
$ozntext="C_text2";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<table class="section-table" style="width:550px;">
<thead>
<tr>
 <td class="head-line" style="width:64%;"></td>
 <td class="head-line" style="width:18%;"></td>
 <td class="head-line" style="width:18%;"></td>
</tr>
<tr>
 <th>
  <input type="checkbox" name="tlt301" value="1" title="Zaradiù tabuæku do PDF"/>
 </th>
 <th><?php echo $kli_vrok; ?></th>
 <th><?php echo $kli_minrok; ?>
  <img src="../obr/ikony/download_blue_icon.png" onclick="minulyrok(<?php echo $strana;?>)"
   title="NaËÌtaù hodnoty z Pozn·mok PO 2013">
 </th>
</tr>
</thead>
<tbody>
<tr>
 <th>Z·v‰zky po lehote splatnosti</th>
 <td><input type="text" name="gcd11" id="gcd11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd12" id="gcd12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Z·v‰zky so zostatkovou dobou splatnosti do 1 roka vr·tane</th>
 <td><input type="text" name="gcd21" id="gcd21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd22" id="gcd22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th><strong>Kr·tkodobÈ z·v‰zky spolu</strong></th>
 <td><input type="text" name="gcd31" id="gcd31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd32" id="gcd32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Z·v‰zky so zostatkovou dobou splatnosti 1 aû 5 rokov</th>
 <td><input type="text" name="gcd41" id="gcd41" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd42" id="gcd42" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Z·v‰zky so zostatkovou dobou splatnosti nad 5 rokov</th>
 <td><input type="text" name="gcd51" id="gcd51" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd52" id="gcd52" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th><strong>DlhodobÈ z·v‰zky spolu</strong></th>
 <td><input type="text" name="gcd61" id="gcd61" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gcd62" id="gcd62" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="3"></td></tr>
</tfoot>
</table>

<h2 class="section-subheader"><span>Ël.III.3</span>Inform·cie o vlastn˝ch akci·ch</h2>
<span class="section-echo" style="margin-bottom:10px;">
<?php
$ozntext="C_text3";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<table class="section-table" style="width:800px;">
<thead>
<tr>
 <td class="head-line" style="width:35%;"></td>
 <td class="head-line" style="width:15%;"></td>
 <td class="head-line" style="width:10%;"></td>
 <td class="head-line" style="width:15%;"></td>
 <td class="head-line" style="width:10%;"></td>
 <td class="head-line" style="width:15%;"></td>
</tr>
<tr>
 <th>
  <input type="checkbox" name="tlt302" value="1" title="Zaradiù tabuæku do PDF"/>
 N·zov akcie
 </th>
 <th>Menovit· hodnota</th>
 <th>PoËet</th>
 <th>Emisn˝ kurz</th>
 <th>⁄rok</th>
 <th>Splatnosù</th>
</tr>
</thead>
<tbody>
<tr>
 <td><input type="text" name="gh11" id="gh11" style="width:250px;"/></td>
 <td><input type="text" name="gh12" id="gh12" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh13" id="gh13" onkeyup="CiarkaNaBodku(this);" style="width:40px;"/></td>
 <td><input type="text" name="gh14" id="gh14" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh15" id="gh15" onkeyup="CiarkaNaBodku(this);" style="width:50px;"/></td>
 <td><input type="text" name="gh16" id="gh16"/></td>
</tr>
<tr>
 <td><input type="text" name="gh21" id="gh21" style="width:250px;"/></td>
 <td><input type="text" name="gh22" id="gh22" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh23" id="gh23" onkeyup="CiarkaNaBodku(this);" style="width:40px;"/></td>
 <td><input type="text" name="gh24" id="gh24" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh25" id="gh25" onkeyup="CiarkaNaBodku(this);" style="width:50px;"/></td>
 <td><input type="text" name="gh26" id="gh26"/></td>
</tr>
<tr>
 <td><input type="text" name="gh31" id="gh31" style="width:250px;"/></td>
 <td><input type="text" name="gh32" id="gh32" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh33" id="gh33" onkeyup="CiarkaNaBodku(this);" style="width:40px;"/></td>
 <td><input type="text" name="gh34" id="gh34" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh35" id="gh35" onkeyup="CiarkaNaBodku(this);" style="width:50px;"/></td>
 <td><input type="text" name="gh36" id="gh36"/></td>
</tr>
<tr>
 <td><input type="text" name="gh41" id="gh41" style="width:250px;"/></td>
 <td><input type="text" name="gh42" id="gh42" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh43" id="gh43" onkeyup="CiarkaNaBodku(this);" style="width:40px;"/></td>
 <td><input type="text" name="gh44" id="gh44" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="gh45" id="gh45" onkeyup="CiarkaNaBodku(this);" style="width:50px;"/></td>
 <td><input type="text" name="gh46" id="gh46"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="6"></td></tr>
</tfoot>
</table>
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<h1 class="section-header"><span>Ël.III</span>Inform·cie, ktorÈ vysvetæuj˙ a dopÂÚaj˙ s˙vahu a v˝kaz ziskov a str·t</h1>
<h2 class="section-subheader"><span>Ël.III.4</span>Inform·cie o org·noch ˙Ëtovnej jednotky</h2>
<span class="section-echo" style="margin-bottom:10px;">
<?php
$ozntext="C_text4";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<table class="section-table" style="width:800px;">
<thead>
<tr>
 <td class="head-line" style="width:22%;"></td>
 <td class="head-line" style="width:13%;"></td>
 <td class="head-line" style="width:13%;"></td>
 <td class="head-line" style="width:13%;"></td>
 <td class="head-line" style="width:13%;"></td>
 <td class="head-line" style="width:13%;"></td>
 <td class="head-line" style="width:13%;"></td>
</tr>
<tr>
 <th rowspan="5" style="border-right:2px solid #c2c2c2; vertical-align:middle;">Druh prÌjmu,<br>v˝hody
  <input type="checkbox" name="tlt303" value="1" title="Zaradiù tabuæku do PDF"/>
 </th>
 <th colspan="6" style="font-weight:normal;">Hodnota prÌjmu, v˝hody Ëlenov org·nov</th>
</tr>
<tr>
 <th colspan="3" style="border-right:2px solid #c2c2c2; border-bottom:2px solid #c2c2c2;
  border-top:1px solid #c2c2c2; color:#39f;"><strong>s˙Ëasn˝ch</strong></th>
 <th colspan="3" style="border-bottom:2px solid #c2c2c2; border-top:1px solid #c2c2c2; color:#39f;"><strong>b˝val˝ch</strong></th>
</tr>
<tr>
 <th>ötatut·rnych</th>
 <th>dozorn˝ch</th>
 <th style="border-right:2px solid #c2c2c2;">in˝ch</th>
 <th>ötatut·rnych</th>
 <th>dozorn˝ch</th>
 <th>in˝ch</th>
</tr>
<tr>
 <th colspan="3" style="border-top:2px solid #c2c2c2; border-bottom:1px solid #c2c2c2;
  border-right:2px solid #c2c2c2;"><?php echo $kli_vrok; ?></th>
 <th colspan="3" style="border-top:2px solid #c2c2c2; border-bottom:1px solid #c2c2c2;"><?php echo $kli_vrok; ?></th>
</tr>
<tr>
 <th colspan="3" style="border-right:2px solid #c2c2c2;"><?php echo $kli_minrok; ?>
  <img src="../obr/ikony/download_blue_icon.png" onclick="minulyrok(<?php echo $strana;?>)"
  title="NaËÌtaù hodnoty z Pozn·mok PO 2013">
 </th>
 <th colspan="3"><?php echo $kli_minrok; ?>
  <img src="../obr/ikony/download_blue_icon.png" onclick="minulyrok(<?php echo $strana;?>)"
  title="NaËÌtaù hodnoty z Pozn·mok PO 2013">
 </th>
</tr>
</thead>
<tbody>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">PeÚaûnÈ prÌjmy</th>
 <td><input type="text" name="m11b" id="m11b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m12b" id="m12b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m13b" id="m13b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m11c" id="m11c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m12c" id="m12c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m13c" id="m13c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m21b" id="m21b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m22b" id="m22b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m23b" id="m23b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m21c" id="m21c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m22c" id="m22c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m23c" id="m23c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">NepeÚaûnÈ prÌjmy</th>
 <td><input type="text" name="m31b" id="m31b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m32b" id="m32b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m33b" id="m33b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m31c" id="m31c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m32c" id="m32c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m33c" id="m33c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m41b" id="m41b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m42b" id="m42b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m43b" id="m43b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m41c" id="m41c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m42c" id="m42c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m43c" id="m43c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">PeÚaûnÈ preddavky</th>
 <td><input type="text" name="m51b" id="m51b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m52b" id="m52b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m53b" id="m53b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m51c" id="m51c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m52c" id="m52c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m53c" id="m53c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m61b" id="m61b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m62b" id="m62b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m63b" id="m63b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m61c" id="m61c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m62c" id="m62c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m63c" id="m63c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">NepeÚaûnÈ preddavky</th>
 <td><input type="text" name="m71b" id="m71b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m72b" id="m72b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m73b" id="m73b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m71c" id="m71c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m72c" id="m72c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m73c" id="m73c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m81b" id="m81b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m82b" id="m82b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m83b" id="m83b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m81c" id="m81c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m82c" id="m82c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m83c" id="m83c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">PoskytnutÈ ˙very</th>
 <td><input type="text" name="m91b" id="m91b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m92b" id="m92b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m93b" id="m93b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m91c" id="m91c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m92c" id="m92c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m93c" id="m93c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m101b" id="m101b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m102b" id="m102b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m103b" id="m103b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m101c" id="m101c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m102c" id="m102c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m103c" id="m103c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">PoskytnutÈ z·ruky</th>
 <td><input type="text" name="m111b" id="m111b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m112b" id="m112b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m113b" id="m113b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m111c" id="m111c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m112c" id="m112c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m113c" id="m113c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m121b" id="m121b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m122b" id="m122b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m123b" id="m123b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m121c" id="m121c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m122c" id="m122c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m123c" id="m123c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th rowspan="2" style="border-right:2px solid #dbdbdb; vertical-align:middle;">InÈ</th>
 <td><input type="text" name="m131b" id="m131b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m132b" id="m132b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m133b" id="m133b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m131c" id="m131c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m132c" id="m132c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m133c" id="m133c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <td><input type="text" name="m141b" id="m141b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m142b" id="m142b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="m143b" id="m143b" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m141c" id="m141c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m142c" id="m142c" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="m143c" id="m143c" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="7"></td></tr>
</tfoot>
</table>
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<h1 class="section-header"><span>Ël.III</span>Inform·cie, ktorÈ vysvetæuj˙ a dopÂÚaj˙ s˙vahu a v˝kaz ziskov a str·t</h1>
<h2 class="section-subheader"><span>Ël.III.5</span>Inform·cie o povinnostiach ˙Ëtovnej jednotky</h2>
<span class="section-echo" style="margin-bottom:15px;">
<?php
$ozntext="C_text5";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<table class="section-table" style="width:500px; margin-bottom:20px;">
<caption>Pods˙vahovÈ poloûky
 <input type="checkbox" name="tlt304" value="1" title="Zaradiù tabuæku do PDF"
  style="top:18px;"/>
</caption>
<thead>
<tr>
 <td class="head-line" style="width:60%;"></td>
 <td class="head-line" style="width:20%;"></td>
 <td class="head-line" style="width:20%;"></td>
</tr>
<tr>
 <th>N·zov poloûky</th>
 <th><?php echo $kli_vrok; ?></th>
 <th><?php echo $kli_minrok; ?>
 <img src="../obr/ikony/download_blue_icon.png" onclick="minulyrok(<?php echo $strana;?>)"
  title="NaËÌtaù hodnoty z Pozn·mok PO 2013">
 </th>
</tr>
</thead>
<tbody>
<tr>
 <th>Prenajat˝ majetok</th>
 <td><input type="text" name="k11" id="k11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k12" id="k12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Majetok v n·jme (operatÌvny pren·jom)</th>
 <td><input type="text" name="k21" id="k21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k22" id="k22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Majetok prijat˝ do ˙schovy</th>
 <td><input type="text" name="k31" id="k31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k32" id="k32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pohæad·vky z deriv·tov</th>
 <td><input type="text" name="k41" id="k41" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k42" id="k42" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Z·v‰zky z opciÌ deriv·tov</th>
 <td><input type="text" name="k51" id="k51" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k52" id="k52" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>OdpÌsanÈ pohæad·vky</th>
 <td><input type="text" name="k61" id="k61" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k62" id="k62" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pohæad·vky z leasingu</th>
 <td><input type="text" name="k71" id="k71" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k72" id="k72" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Z·v‰zky z leasingu</th>
 <td><input type="text" name="k81" id="k81" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k82" id="k82" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>InÈ poloûky</th>
 <td><input type="text" name="k91" id="k91" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="k92" id="k92" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="3"></td></tr>
</tfoot>
</table>

<table class="section-table toleft" style="width:420px; margin-bottom:10px;">
<caption>PodmienenÈ z·v‰zky - Tabuæka Ë. 1
 <input type="checkbox" name="tlt305" value="1" title="Zobraziù tabuæku v PDF"
  style="top:18px;"/>
</caption>
<thead>
<tr>
 <td class="head-line" style="width:50%;"></td>
 <td class="head-line" style="width:25%;"></td>
 <td class="head-line" style="width:25%;"></td>
</tr>
<tr>
 <th rowspan="2" style="vertical-align:middle; border-right:2px solid #c2c2c2;">Druh podmienenÈho z·v‰zku</th>
 <th colspan="2" style="border-bottom:2px solid #c2c2c2;"><?php echo $kli_vrok; ?></th>
</tr>
<tr>
 <th style="border-right:2px solid #c2c2c2;">Hodnota celkom</th>
 <th>Hodn. voËi spriaz. osob·m</th>
</tr>
</thead>
<tbody>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Zo s˙dnych rozhodnutÌ</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab11" id="l1ab11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab12" id="l1ab12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Z poskytnut˝ch z·ruk</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab21" id="l1ab21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab22" id="l1ab22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb; font-size:11px;">Zo vöeobec. z·v‰zn˝ch pr·v. predpisov</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab31" id="l1ab31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab32" id="l1ab32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Zo zmluvy o podriadenom z·v‰zku</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab41" id="l1ab41" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab42" id="l1ab42" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Z ruËenia</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab51" id="l1ab51" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab52" id="l1ab52" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">InÈ podmienenÈ z·v‰zky</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l1ab61" id="l1ab61" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l1ab62" id="l1ab62" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="3"></td></tr>
</tfoot>
</table>

<table class="section-table toleft" style="width:420px; margin-bottom:10px;">
<caption>PodmienenÈ z·v‰zky - Tabuæka Ë. 2
 <input type="checkbox" name="tlt306" value="1" title="Zobraziù tabuæku v PDF"
  style="top:18px;"/>
</caption>
<thead>
<tr>
 <td class="head-line" style="width:50%;"></td>
 <td class="head-line" style="width:25%;"></td>
 <td class="head-line" style="width:25%;"></td>
</tr>
<tr>
 <th rowspan="2" style="vertical-align:middle; border-right:2px solid #c2c2c2;">Druh podmienenÈho z·v‰zku</th>
 <th colspan="2" style="border-bottom:2px solid #c2c2c2;"><?php echo $kli_minrok; ?></th>
</tr>
<tr>
 <th style="border-right:2px solid #c2c2c2;">Hodnota celkom</th>
 <th>Hodn. voËi spriaz. osob·m</th>
</tr>
</thead>
<tbody>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Zo s˙dnych rozhodnutÌ</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab11" id="l2ab11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab12" id="l2ab12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Z poskytnut˝ch z·ruk</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab21" id="l2ab21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab22" id="l2ab22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb; font-size:11px;">Zo vöeobec. z·v‰zn˝ch pr·v. predpisov</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab31" id="l2ab31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab32" id="l2ab32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Zo zmluvy o podriadenom z·v‰zku</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab41" id="l2ab41" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab42" id="l2ab42" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">Z ruËenia</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab51" id="l2ab51" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab52" id="l2ab52" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th style="border-right:2px solid #dbdbdb;">InÈ podmienenÈ z·v‰zky</th>
 <td style="border-right:2px solid #dbdbdb;"><input type="text" name="l2ab61" id="l2ab61" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="l2ab62" id="l2ab62" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="3"></td></tr>
</tfoot>
</table>

<span class="section-echo" style="margin-bottom:20px;">
<?php
$ozntext="C_text6";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>

<table class="section-table" style="width:600px; margin-bottom:10px;">
<caption>Podmienen˝ majetok
 <input type="checkbox" name="tlt307" value="1" title="Zaradiù tabuæku do PDF"
  style="top:18px;"/>
</caption>
<thead>
<tr>
 <td class="head-line" style="width:60%;"></td>
 <td class="head-line" style="width:20%;"></td>
 <td class="head-line" style="width:20%;"></td>
</tr>
<tr>
 <th>Druh podmienenÈho majetku</th>
 <th><?php echo $kli_vrok; ?></th>
 <th><?php echo $kli_minrok; ?></th>
</tr>
</thead>
<tbody>
<tr>
 <th>Pr·va zo servisn˝ch zml˙v</th>
 <td><input type="text" name="lc11" id="lc11" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc12" id="lc12" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va z poistn˝ch zml˙v</th>
 <td><input type="text" name="lc21" id="lc21" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc22" id="lc22" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va z koncesion·rskych zml˙v</th>
 <td><input type="text" name="lc31" id="lc31" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc32" id="lc32" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va z licenËn˝ch zml˙v</th>
 <td><input type="text" name="lc41" id="lc41" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc42" id="lc42" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va z investov. prostried. zÌskan. oslobod. od dane z prÌj.</th>
 <td><input type="text" name="lc51" id="lc51" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc52" id="lc52" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va z privatiz·cie</th>
 <td><input type="text" name="lc61" id="lc61" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc62" id="lc62" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>Pr·va zo s˙dnych sporov</th>
 <td><input type="text" name="lc71" id="lc71" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc72" id="lc72" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
<tr>
 <th>InÈ pr·va</th>
 <td><input type="text" name="lc81" id="lc81" onkeyup="CiarkaNaBodku(this);"/></td>
 <td><input type="text" name="lc82" id="lc82" onkeyup="CiarkaNaBodku(this);"/></td>
</tr>
</tbody>
</table>

<span class="section-echo" style="margin-bottom:15px;">
<?php
$ozntext="C_text7";
$textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
echo $textvypis;
?>
<img src="../obr/ikony/pencil3_blue_x16.png" onclick="upravtext('<?php echo $ozntext; ?>')"
 title="Upraviù">
</span>
<?php                     } ?>

</div>
</FORM>
</div> <!-- koniec #content -->
<?php
//koniec zobraz a uprav udaje
}
?>

<?php
$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>