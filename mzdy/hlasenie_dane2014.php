<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
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

$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Hl·senie bude pripravenÈ v priebehu febru·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = 1;
$h_drp = 1*$_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$mesn1=1;
$mesn2=2;
$mesn3=12;
$zrz1=99;
$zrz2=1;
$zrz3=2;

$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

// znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdrocnehlaseniedane WHERE oc > 0";
$oznac = mysql_query("$sqtoz");
$copern=20;
$subor=1;
     }
//koniec znovu nacitaj

$nacitanezmes=0;
// nacitaj hodnoty z prehladov mesacnych
$nerobim=0;
if ( $copern == 230 AND $nerobim == 0 )
     {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET ".
" r01a=0,  r01b=0, r02a=0, r03a=0, r05a=0, r06a=0, r08a=0, ra1a=0, rb1a=0, rc1a=0, ra1b=0, rb1b=0, rc1b=0 ".
" WHERE oc >= 0"; 
$upravene = mysql_query("$uprtxt"); 

$i=1;
$nacitanemesiace="NaËÌtanÈ mesiace = ";
   while ( $i <= 12 )
   {
$umxy=$i.".".$kli_vrok;
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane,F$kli_vxcf"."_mzdmesacnyprehladdane SET ".

" F$kli_vxcf"."_mzdrocnehlaseniedane.rc1b=F$kli_vxcf"."_mzdrocnehlaseniedane.rc1b+F$kli_vxcf"."_mzdmesacnyprehladdane.rf1a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.rb1b=F$kli_vxcf"."_mzdrocnehlaseniedane.rb1b+F$kli_vxcf"."_mzdmesacnyprehladdane.re1a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.ra1b=F$kli_vxcf"."_mzdrocnehlaseniedane.ra1b+F$kli_vxcf"."_mzdmesacnyprehladdane.rd1a,  ".

" F$kli_vxcf"."_mzdrocnehlaseniedane.rc1a=F$kli_vxcf"."_mzdrocnehlaseniedane.rc1a+F$kli_vxcf"."_mzdmesacnyprehladdane.rc1a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.rb1a=F$kli_vxcf"."_mzdrocnehlaseniedane.rb1a+F$kli_vxcf"."_mzdmesacnyprehladdane.rb1a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.ra1a=F$kli_vxcf"."_mzdrocnehlaseniedane.ra1a+F$kli_vxcf"."_mzdmesacnyprehladdane.ra1a,  ".

" F$kli_vxcf"."_mzdrocnehlaseniedane.r08a=F$kli_vxcf"."_mzdrocnehlaseniedane.r08a+F$kli_vxcf"."_mzdmesacnyprehladdane.r08a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.r06a=F$kli_vxcf"."_mzdrocnehlaseniedane.r06a+F$kli_vxcf"."_mzdmesacnyprehladdane.r06a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.r05a=F$kli_vxcf"."_mzdrocnehlaseniedane.r05a+F$kli_vxcf"."_mzdmesacnyprehladdane.r05a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.r03a=F$kli_vxcf"."_mzdrocnehlaseniedane.r03a+F$kli_vxcf"."_mzdmesacnyprehladdane.r03a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.r02a=F$kli_vxcf"."_mzdrocnehlaseniedane.r02a+F$kli_vxcf"."_mzdmesacnyprehladdane.r02a,  ".
" F$kli_vxcf"."_mzdrocnehlaseniedane.r01b=F$kli_vxcf"."_mzdrocnehlaseniedane.r01b+F$kli_vxcf"."_mzdmesacnyprehladdane.r01a,  ".

" F$kli_vxcf"."_mzdrocnehlaseniedane.r01a=F$kli_vxcf"."_mzdrocnehlaseniedane.r01a+F$kli_vxcf"."_mzdmesacnyprehladdane.r00a  ".
" WHERE F$kli_vxcf"."_mzdrocnehlaseniedane.oc=F$kli_vxcf"."_mzdrocnehlaseniedane.oc AND F$kli_vxcf"."_mzdmesacnyprehladdane.umex = $umxy "; 
$upravene = mysql_query("$uprtxt"); 

$pol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $umxy ";
$sql = mysql_query("$sqltt");
if ( $sql ) { $pol = mysql_num_rows($sql); }

if ( $pol == 1 ) { $nacitanemesiace=$nacitanemesiace." ".$i." "; }
$i=$i+1;
    }
$nacitanezmes=1;
$copern=20;
     }
//koniec znovu nacitaj z prehladov

//zapis upravene udaje
if ( $copern == 23 )
     {
$mz12 = 1*strip_tags($_REQUEST['druh']);
$r01bd = SqlDatum($_REQUEST['r01bd']);
$r01ad = SqlDatum($_REQUEST['r01ad']);
$r07ad = SqlDatum($_REQUEST['r07ad']);
$r07bd = SqlDatum($_REQUEST['r07bd']);
$str4 = strip_tags($_REQUEST['str4']);
$str5 = strip_tags($_REQUEST['str5']);
$zam4 = strip_tags($_REQUEST['zam4']);
$zam5 = strip_tags($_REQUEST['zam5']);
//$mesa = strip_tags($_REQUEST['mesa']);
//$mesb = strip_tags($_REQUEST['mesb']);
//$mesc = strip_tags($_REQUEST['mesc']);
//$mesd = strip_tags($_REQUEST['mesd']);
//$r01 = strip_tags($_REQUEST['r01']);
$oc = strip_tags($_REQUEST['oc']);
//$r02b = strip_tags($_REQUEST['r02b']);
//$r02c = strip_tags($_REQUEST['r02c']);
//$r03b = strip_tags($_REQUEST['r03b']);
//$r03c = strip_tags($_REQUEST['r03c']);
//$r04b = strip_tags($_REQUEST['r04b']);
//$r04c = strip_tags($_REQUEST['r04c']);
//$r05b = strip_tags($_REQUEST['r05b']);
//$r05c = strip_tags($_REQUEST['r05c']);
//$r06b = strip_tags($_REQUEST['r06b']);
//$r06c = strip_tags($_REQUEST['r06c']);
//$r07b = strip_tags($_REQUEST['r07b']);
//$r07c = strip_tags($_REQUEST['r07c']);
//$r08b = strip_tags($_REQUEST['r08b']);
//$r08c = strip_tags($_REQUEST['r08c']);
//$r09b = strip_tags($_REQUEST['r09b']);
//$r09c = strip_tags($_REQUEST['r09c']);
//$r10b = strip_tags($_REQUEST['r10b']);
//$r10c = strip_tags($_REQUEST['r10c']);
//$r11b = strip_tags($_REQUEST['r11b']);
//$r11c = strip_tags($_REQUEST['r11c']);
//$ra1c = strip_tags($_REQUEST['ra1c']);
//$rb1c = strip_tags($_REQUEST['rb1c']);
//$rc1c = strip_tags($_REQUEST['rc1c']);
//$rd1c = strip_tags($_REQUEST['rd1c']);
//$r13a = strip_tags($_REQUEST['r13a']);
//$r14a = strip_tags($_REQUEST['r14a']);
//$r15a = strip_tags($_REQUEST['r15a']);
//$r16a = strip_tags($_REQUEST['r16a']);
//$r17a = strip_tags($_REQUEST['r17a']);
//$tz2 = 1*strip_tags($_REQUEST['tz2']);
//$r01cd = SqlDatum($_REQUEST['r01cd']);
//$r07cd = SqlDatum($_REQUEST['r07cd']);
//$r08ad = SqlDatum($_REQUEST['r08ad']);
//$r08bd = SqlDatum($_REQUEST['r08bd']);
//$r08cd = SqlDatum($_REQUEST['r08cd']);
//$r11ad = SqlDatum($_REQUEST['r11ad']);
//$r11bd = SqlDatum($_REQUEST['r11bd']);
//$r11cd = SqlDatum($_REQUEST['r11cd']);

$zprie = strip_tags($_REQUEST['zprie']);
$zmeno = strip_tags($_REQUEST['zmeno']);
$ztitl = strip_tags($_REQUEST['ztitl']);
$ztitz = strip_tags($_REQUEST['ztitz']);
$zrdc = strip_tags($_REQUEST['zrdc']);
$zrdk = strip_tags($_REQUEST['zrdk']);
$zuli = strip_tags($_REQUEST['zuli']);
$zcdm = strip_tags($_REQUEST['zcdm']);
$zpsc = strip_tags($_REQUEST['zpsc']);
$zmes = strip_tags($_REQUEST['zmes']);
$zstat = strip_tags($_REQUEST['zstat']);
$ztel = strip_tags($_REQUEST['ztel']);
$zemfax = strip_tags($_REQUEST['zemfax']);
$r01a = strip_tags($_REQUEST['r01a']);
$r01b = strip_tags($_REQUEST['r01b']);
$r02a = strip_tags($_REQUEST['r02a']);
$r03a = strip_tags($_REQUEST['r03a']);
$r04a = strip_tags($_REQUEST['r04a']);
$r05a = strip_tags($_REQUEST['r05a']);
$r06a = strip_tags($_REQUEST['r06a']);
$r07a = strip_tags($_REQUEST['r07a']);
$r08a = strip_tags($_REQUEST['r08a']);
$r09a = strip_tags($_REQUEST['r09a']);
$r10a = strip_tags($_REQUEST['r10a']);
$r11a = strip_tags($_REQUEST['r11a']);
$r12a = strip_tags($_REQUEST['r12a']);
$ra1a = strip_tags($_REQUEST['ra1a']);
$rb1a = strip_tags($_REQUEST['rb1a']);
$rc1a = strip_tags($_REQUEST['rc1a']);
$ra1b = strip_tags($_REQUEST['ra1b']);
$rb1b = strip_tags($_REQUEST['rb1b']);
$rc1b = strip_tags($_REQUEST['rc1b']);
$mzc = 1*strip_tags($_REQUEST['mzc']);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET ".
" mz12='$mz12', r01bd='$r01bd', r01ad='$r01ad', r07ad='$r07ad', r07bd='$r07bd', ".
" str4='$str4', str5='$str5', zam4='$zam4', zam5='$zam5' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET ".
" zrdc='$zrdc', zrdk='$zrdk', zmeno='$zmeno', zprie='$zprie', ztitl='$ztitl', ztitz='$ztitz', zstat='$zstat',".
" zuli='$zuli', zcdm='$zcdm', zpsc='$zpsc', zmes='$zmes', ztel='$ztel', zemfax='$zemfax', ".
" r01a='$r01a', r01b='$r01b', r02a='$r02a', r03a='$r03a', r04a='$r04a', r05a='$r05a', r06a='$r06a', ".
" r07a='$r07a', r08a='$r08a', r09a='$r09a', r10a='$r10a', r11a='$r11a', r12a='$r12a', ".
" ra1a='$ra1a', rb1a='$rb1a', rc1a='$rc1a', ra1b='$ra1b', rb1b='$rb1b', rc1b='$rc1b', mzc='$mzc' ".
" WHERE oc = $cislo_oc";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  
//exit;
$copern=20;
     }
//koniec zapisu upravenych udajov


//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT zam5 FROM F$vyb_xcf"."_mzdrocnehlaseniedane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdrocnehlaseniedane';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdrocnehlaseniedaneoc';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   mesa         DECIMAL(4,0) DEFAULT 0,
   mesb         DECIMAL(4,0) DEFAULT 0,
   mesc         DECIMAL(4,0) DEFAULT 0,
   mesd         DECIMAL(4,0) DEFAULT 0,
   r01ad        DATE,
   r01bd        DATE,
   r01cd        DATE,
   r01a         DECIMAL(10,2) DEFAULT 0,
   r01b         DECIMAL(10,2) DEFAULT 0,
   r01c         DECIMAL(10,2) DEFAULT 0,
   r02a         DECIMAL(10,2) DEFAULT 0,
   r02b         DECIMAL(10,2) DEFAULT 0,
   r02c         DECIMAL(10,2) DEFAULT 0,
   r03a         DECIMAL(10,2) DEFAULT 0,
   r03b         DECIMAL(10,2) DEFAULT 0,
   r03c         DECIMAL(10,2) DEFAULT 0,
   r04a         DECIMAL(10,2) DEFAULT 0,
   r04b         DECIMAL(10,2) DEFAULT 0,
   r04c         DECIMAL(10,2) DEFAULT 0,
   r05a         DECIMAL(10,2) DEFAULT 0,
   r05b         DECIMAL(10,2) DEFAULT 0,
   r05c         DECIMAL(10,2) DEFAULT 0,
   r06a         DECIMAL(10,2) DEFAULT 0,
   r06b         DECIMAL(10,2) DEFAULT 0,
   r06c         DECIMAL(10,2) DEFAULT 0,
   r07ad        DATE,
   r07bd        DATE,
   r07cd        DATE,
   r07a         DECIMAL(10,2) DEFAULT 0,
   r07b         DECIMAL(10,2) DEFAULT 0,
   r07c         DECIMAL(10,2) DEFAULT 0,
   r08ad        DATE,
   r08bd        DATE,
   r08cd        DATE,
   r08a         DECIMAL(10,2) DEFAULT 0,
   r08b         DECIMAL(10,2) DEFAULT 0,
   r08c         DECIMAL(10,2) DEFAULT 0,
   r09a         DECIMAL(10,2) DEFAULT 0,
   r09b         DECIMAL(10,2) DEFAULT 0,
   r09c         DECIMAL(10,2) DEFAULT 0,
   r10a         DECIMAL(10,2) DEFAULT 0,
   r10b         DECIMAL(10,2) DEFAULT 0,
   r10c         DECIMAL(10,2) DEFAULT 0,
   r11ad        DATE,
   r11bd        DATE,
   r11cd        DATE,
   r11a         DECIMAL(10,2) DEFAULT 0,
   r11b         DECIMAL(10,2) DEFAULT 0,
   r11c         DECIMAL(10,2) DEFAULT 0,
   ra1a         DECIMAL(10,2) DEFAULT 0,
   ra1b         DECIMAL(10,2) DEFAULT 0,
   ra1c         DECIMAL(10,2) DEFAULT 0,
   rb1a         DECIMAL(10,2) DEFAULT 0,
   rb1b         DECIMAL(10,2) DEFAULT 0,
   rb1c         DECIMAL(10,2) DEFAULT 0,
   rc1a         DECIMAL(10,2) DEFAULT 0,
   rc1b         DECIMAL(10,2) DEFAULT 0,
   rc1c         DECIMAL(10,2) DEFAULT 0,
   rd1c         DECIMAL(10,2) DEFAULT 0,
   r12a         DECIMAL(10,2) DEFAULT 0,
   r13a         DECIMAL(10,2) DEFAULT 0,
   r14a         DECIMAL(10,2) DEFAULT 0,
   r15a         DECIMAL(10,2) DEFAULT 0,
   r16a         DECIMAL(10,2) DEFAULT 0,
   r17a         DECIMAL(10,2) DEFAULT 0,
   tz1          VARCHAR(1),
   tz2          VARCHAR(1),
   tz3          VARCHAR(1),
   mzc          VARCHAR(1),
   mz01         VARCHAR(1),
   mz02         VARCHAR(1),
   mz03         VARCHAR(1),
   mz04         VARCHAR(1),
   mz05         VARCHAR(1),
   mz06         VARCHAR(1),
   mz07         VARCHAR(1),
   mz08         VARCHAR(1),
   mz09         VARCHAR(1),
   mz10         VARCHAR(1),
   mz11         VARCHAR(1),
   mz12         VARCHAR(1),
   cela         DECIMAL(10,2) DEFAULT 0,
   celb         DECIMAL(10,2) DEFAULT 0,
   celc         DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   str4         DECIMAL(4,0) DEFAULT 0,
   zam4         DECIMAL(4,0) DEFAULT 0,
   str5         DECIMAL(4,0) DEFAULT 0,
   zam5         DECIMAL(4,0) DEFAULT 0,
   doho         DECIMAL(10,2) DEFAULT 0,
   socp         DECIMAL(10,2) DEFAULT 0,
   zdrp         DECIMAL(10,2) DEFAULT 0,
   nzdh         DECIMAL(10,2) DEFAULT 0,
   pred         DECIMAL(2,0) DEFAULT 0,
   nzmh         DECIMAL(10,2) DEFAULT 0,
   nzmd         DECIMAL(2,0) DEFAULT 0,
   zmph         DECIMAL(10,2) DEFAULT 0,
   zmpm         DECIMAL(2,0) DEFAULT 0,
   dnbh         DECIMAL(10,2) DEFAULT 0,
   dnbm         DECIMAL(2,0) DEFAULT 0,
   rocz         DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdrocnehlaseniedane'.$sqlt;
$vytvor = mysql_query("$vsql");
   }
//koniec vytvorenia

$sql = "SELECT pdan FROM F$vyb_xcf"."_mzdrocnehlaseniedane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD pdan DECIMAL(10,2) DEFAULT 0 AFTER zdrp";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane MODIFY tz3 DECIMAL(2,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
   }

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdrocnehlaseniedaneoc SELECT * FROM F".$kli_vxcf."_mzdrocnehlaseniedane";
$vytvor = mysql_query("$vsql");

//new2013 hlasenie
$sql = "SELECT new2013 FROM F$vyb_xcf"."_mzdrocnehlaseniedane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD new2013 DECIMAL(2,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
   }

$sql = "SELECT zemfax FROM F$vyb_xcf"."_mzdrocnehlaseniedane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zprie VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zmeno VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD ztitl VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD ztitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zrdc VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zrdk VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zuli VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zcdm VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zpsc VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zmes VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zstat VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD ztel VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD zemfax VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
   }
//koniec new2013 hlasenie

//new2014 hlasenie
$sql = "SELECT new2014 FROM F$vyb_xcf"."_mzdrocnehlaseniedane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedane ADD new2014 DECIMAL(2,0) DEFAULT 0 AFTER zprie";
$vysledek = mysql_query("$sql");

   }
//koniec new2014 hlasenie

$sql = "SELECT pdan FROM F$vyb_xcf"."_mzdrocnehlaseniedaneoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD pdan DECIMAL(10,2) DEFAULT 0 AFTER zdrp";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc MODIFY tz3 DECIMAL(2,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
   }

//new2013 priloha
$sql = "SELECT new2013 FROM F$vyb_xcf"."_mzdrocnehlaseniedaneoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD new2013 DECIMAL(2,0) DEFAULT 0 AFTER konx1";
$vysledek = mysql_query("$sql");
   }
$sql = "SELECT ddssum FROM F$vyb_xcf"."_mzdrocnehlaseniedaneoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD ddsnzc DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD ddssum DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
   }
//koniec new2013 priloha

//new2014 priloha
$sql = "SELECT dds2nc FROM F$vyb_xcf"."_mzdrocnehlaseniedaneoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD new2014 DECIMAL(2,0) DEFAULT 0 AFTER ddsnzc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD prvypj DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdrocnehlaseniedaneoc ADD dds2nc DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

   }
//koniec new2014 priloha

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdrocnehlaseniedane";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdrocnehlaseniedane";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedane WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

$kli_vxcfmzdy=$_REQUEST['fmzdy'];


//pre potvrdenie vytvor pracovny subor
if ( $subor == 1 )
{
//vloz jeden prazdny
$oc1=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 AND pom != 9 ORDER BY oc";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $oc1=1*$riaddok->oc;
  }

$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcvypl".$kli_uzid." DROP new2014 ";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." ( oc,konx  ) VALUES ( '$oc1', '1' )";
$ttqq = mysql_query("$ttvv");
//echo $ttvv;
//exit;

//zober data zo sum preddavky a zaklad do r01a,r01b,r01c ksum2=9 to je stare sec_eko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',(zdan_dnp+pdan_zn1),odan_dnp,(zdan_dnp+pdan_zn1-pdan_fnd),".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalsum ".
" WHERE oc > 0 AND ksum2 != 9 ".
"";
$dsql = mysql_query("$dsqlt");

//zober preplatok ZP 954 z vy a odpocitaj z prijmu( nie nedoplatok ten je nizsie pripocita sa k zdravotnemu ZP) 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',(kc),0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc > 0 AND dm = 954 AND kc < 0 ".
"";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

//zober data z vy 903 RZ
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"kc,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE dm = 903 ".
"";
$dsql = mysql_query("$dsqlt");

//zober data z vy 902 Bonus
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"kc,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,-kc,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE dm = 902 ".
"";
$dsql = mysql_query("$dsqlt");

//zober data z kunzal 902 Bonus pocetmesiacov a pocet deti
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','',deti_dn,'',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,deti_dn,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalkun".
" WHERE deti_dn > 0 ".
"";
$dsql = mysql_query("$dsqlt");
//exit;

//zober data z vy 952 Bonus
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"kc,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE dm = 952 ".
"";
$dsql = mysql_query("$dsqlt");

//zober data z vy 953 Zam premia
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,kc,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE dm = 953 ".
"";
$dsql = mysql_query("$dsqlt");

//oc  mesa  mesb  mesc  mesd
//r01ad  r01bd  r01cd  r01a  r01b  r01c  
//r02a  r02b  r02c  r03a  r03b  r03c  r04a  r04b  r04c  
//r05a  r05b  r05c  r06a  r06b  r06c  r07ad  r07bd  r07cd  r07a  r07b  r07c  r08ad  r08bd  r08cd  r08a  r08b  r08c  r09a  r09b  r09c  
//r10a  r10b  r10c  r11ad  r11bd  r11cd  r11a  r11b  r11c  ra1a  ra1b  ra1c  rb1a  rb1b  rb1c  rc1a  rc1b  rc1c  rd1c  r12a  r13a  r14a  r15a  r16a  r17a  
//tz1  tz2  tz3  mzc  
//mz01  mz02  mz03  mz04  mz05  mz06  mz07  mz08  mz09  mz10  mz11  mz12  
//cela  celb  celc  konx  
//str4  zam4  str5  zam5  doho  socp  zdrp  pdan  nzdh  pred  nzmh  nzmd  zmph  zmpm  dnbh  dnbm  rocz  konx1  

//zober data z sum socialne a zdravotne poistenie
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,(ozam_np+ozam_sp+ozam_ip+ozam_pn),ozam_zp,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalsum".
" WHERE oc > 0 ".
"";
$dsql = mysql_query("$dsqlt");

//zober data z vy nedoplatok zrazeny ZP dm954 kc > 0 a pripocitaj k zdravotnemu poisteniu
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,kc,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc > 0 AND dm = 954 AND kc > 0 ".
"";
$dsql = mysql_query("$dsqlt");

//zober data z sum odpocitatelna na danovnika
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"0,0,0,0,0,0,0,0,0,".
"0,".
"0,0,0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,1,".
"0,0,0,0,0,0,0,1,pdan_dnv,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcfmzdy"."_mzdzalsum".
" WHERE pdan_dnv > 0 ".
"";
$dsql = mysql_query("$dsqlt");

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,0,0,".
"r01ad,r01bd,r01cd,sum(r01a),sum(r01b),sum(r01c),".
"sum(r02a),sum(r02b),sum(r02c),0,0,0,0,0,0,".
"sum(r05a),sum(r05b),sum(r05c),0,0,0,".
"'','','',0,0,0,".
"'','','',sum(r08a),sum(r08b),sum(r08c),".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"sum(ra1a),sum(ra1b),sum(ra1c),0,0,0,0,0,0,".
"0,".
"0,sum(r13a),0,0,0,0,".
"'','',MAX(tz3),'',".
"'','','','','','','','','','','','',".
"0,0,0,2,".
"0,0,0,0,0,SUM(socp),SUM(zdrp),SUM(pdan),SUM(nzdh),0,0,0,0,0,SUM(dnbh),SUM(dnbm),0,0,".
"0,'','','','','','','','','','','','','' ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 1";
$oznac = mysql_query("$sqtoz");
//exit;

//uloz do mzdhlasenieDaneoc
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc WHERE oc >= 0";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" SELECT oc,0,0,0,0,".
"r01ad,r01bd,r01cd,sum(r01a),sum(r01b),sum(r01c),".
"sum(r02a),sum(r02b),sum(r02c),0,0,0,0,0,0,".
"sum(r05a),sum(r05b),sum(r05c),0,0,0,".
"'','','',0,0,0,".
"'','','',sum(r08a),sum(r08b),sum(r08c),".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"-sum(ra1a),-sum(ra1b),0,0,0,0,0,0,0,".
"0,".
"0,sum(r13a),0,0,0,0,".
"'','',tz3,'',".
"'','','','','','','','','','','','',".
"0,0,0,2,".
"0,0,0,0,0,SUM(socp),SUM(zdrp),SUM(pdan),SUM(nzdh),0,0,0,0,0,SUM(dnbh),SUM(dnbm),0,0,".
"0,0,0, ".
"0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET r01c=0 WHERE r01c < 0 ";
$oznac = mysql_query("$sqtoz");


//uloz do mzdhlasenieDane
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdrocnehlaseniedane WHERE oc >= 0";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdrocnehlaseniedane".
" SELECT 1,SUM(mesa),SUM(mesb),SUM(mesc),SUM(mesd),".
"r01ad,r01bd,r01cd,sum(r01a),sum(r01b),sum(r01c),".
"sum(r02a),sum(r02b),sum(r02c),0,0,0,0,0,0,".
"sum(r05a),sum(r05b),sum(r05c),0,0,0,".
"'','','',0,0,0,".
"'','','',sum(r08a),sum(r08b),sum(r08c),".
"0,0,0,0,0,0,".
"'','','',0,0,0,".
"sum(ra1a),sum(ra1b),sum(ra1c),0,0,0,0,0,0,".
"0,".
"0,sum(r13a),0,0,0,0,".
"'','','','',".
"'','','','','','','','','','','','',".
"0,0,0,2,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,'','','','','','','','','','','','','', ".
"0 ".
" FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" GROUP BY konx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//vypocitaj riadky

//ak nie su preddavky vynuluj RZ vratenie
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r02a=0 WHERE oc > 0 AND r02a < 0 AND r01b = 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//uhrn riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r04a=r01b+r02a+r03a WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET rb1a=0, rc1a=0, ra1c=0, rb1b=0, rc1b=0, rb1c=0  WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

//rozdel danovy bonus a zam.premiu

//db,zp z preddavkov
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r05a=ra1a WHERE oc > 0 AND ra1a <= r04a AND r04a > 0"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r05a=r04a WHERE oc > 0 AND ra1a > r04a "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET celc=r04a-r05a WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r06a=ra1b WHERE oc > 0 AND ra1b <= celc AND celc > 0"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r06a=celc WHERE oc > 0 AND ra1b > celc AND celc > 0"; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET rb1a=r05a WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET rc1a=ra1a-rb1a WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET rb1b=r06a WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET rc1b=ra1b-rb1b WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

//odvedene
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r08a=r04a-r05a-r06a WHERE oc > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r08a=0 WHERE oc > 0 AND r08a < 0";
$oznac = mysql_query("$sqtoz");

//priznany a vyplateny DB a ZP minus
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r05a=-r05a, r06a=-r06a WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

//koniec

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET celc=0 "; 
$oznac = mysql_query("$sqtoz");

//prace na dohodu?
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET celc=0 WHERE oc > 0 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"celc=pom ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdpomer SET ".
"doho=pm_doh ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.celc=F$kli_vxcf"."_mzdpomer.pm ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET doho=r01a WHERE doho = 1 "; 
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET celc=0 "; 
$oznac = mysql_query("$sqtoz");
//exit;

//zuctovane v mesiacoch podla kun
$danx=$kli_vrok."-01-01";
$davx=$kli_vrok."-12-31";

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=1, mz02=1, mz03=1, mz04=1, mz05=1, mz06=1, mz07=1, mz08=1, mz09=1, mz10=1, mz11=1, mz12=1 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=1, mz02=1, mz03=1, mz04=1, mz05=1, mz06=1, mz07=1, mz08=1, mz09=1, mz10=1, mz11=1, mz12=1 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan < '$danx' AND ( dav > '$davx' OR dav = '0000-00-00' )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-01-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-02-29' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-03-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-04-30' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-05-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-06-30' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-07-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-08-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-09-30' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-10-31' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
"mz01=0, mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dan > '$kli_vrok-11-30' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//vystup

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz02=0, mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-01-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz03=0, mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-02-29' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz04=0, mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-03-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz05=0, mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-04-30' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz06=0, mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-05-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz07=0, mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-06-30' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz08=0, mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-07-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz09=0, mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-08-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz10=0, mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-09-30' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz11=0, mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-10-31' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdkun SET ".
" mz12=0  ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc AND dav <= '$kli_vrok-11-30' AND dav != '0000-00-00' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//uplatnuje nczd na danovnika
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET pred=0  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET pred=1 WHERE nzdh > 0  ";
$oznac = mysql_query("$sqtoz");

//vykonane rocne podla rocneho zuctovania a zober udaje z RZ
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET tz1=0  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc,F$kli_vxcf"."_mzdrocnedane SET ".
" tz1=1, rocz=r15-r16,  ".

" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.dnbh=F$kli_vxcf"."_mzdrocnedane.r10, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.zmpm=F$kli_vxcf"."_mzdrocnedane.r08, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.ra1b=F$kli_vxcf"."_mzdrocnedane.r09, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.nzmh=F$kli_vxcf"."_mzdrocnedane.r04b, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.r01b=F$kli_vxcf"."_mzdrocnedane.r14, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.nzdh=F$kli_vxcf"."_mzdrocnedane.r04a, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.zdrp=F$kli_vxcf"."_mzdrocnedane.r00c, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.socp=F$kli_vxcf"."_mzdrocnedane.r00b, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.doho=F$kli_vxcf"."_mzdrocnedane.r00d, ".
" F$kli_vxcf"."_mzdrocnehlaseniedaneoc.r01a=F$kli_vxcf"."_mzdrocnedane.r00 ".
"WHERE F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdrocnedane.oc AND vyk = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
}
//koniec pracovneho suboru pre potvrdenie 

//VYPOCTY
//pocet zamestnancov IV.prilohy nevykonal RZ
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET mesa=1   ";
$oznac = mysql_query("$sqtoz");

$zam4=0;
$sqldok = mysql_query("SELECT SUM(mesa) AS mesasum FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc WHERE tz1 != 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zam4=1*$riaddok->mesasum;
  }

//pocet zamestnancov V.prilohy vykonal RZ
$zam5=0;
$sqldok = mysql_query("SELECT SUM(mesa) AS mesasum FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc WHERE tz1 = 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zam5=1*$riaddok->mesasum;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET zam4=$zam4, zam5=$zam5  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET str4=ceil(zam4/2), str5=ceil(zam5/2)  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET str4=1 WHERE str4 < 1  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET str5=1 WHERE str5 < 1  ";
$oznac = mysql_query("$sqtoz");

//vypocitaj riadky
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r04a=r01b+r02a+r03a WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//odvodova povinnost
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r07a=r04a+r05a+r06a WHERE oc > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET r07a=0 WHERE oc > 0 AND r07a < 0";
$oznac = mysql_query("$sqtoz");


//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET".
" r09a=r08a-r07a, r10a=0  WHERE oc > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedane SET".
" r10a=-(r08a-r07a), r09a=0  WHERE oc > 0 AND r09a < 0";
$oznac = mysql_query("$sqtoz");


//nacitaj udaje pre upravu
if ( $copern == 20 OR $copern == 10 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedane".
" WHERE F$kli_vxcf"."_mzdrocnehlaseniedane.oc = $cislo_oc AND konx = 2 ORDER BY konx ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$zrobil = $fir_mzdt05;
if ( $fir_mzdt05='' ) $zrobil=$kli_uzmeno." ".$kli_uzprie;
$oc = $fir_riadok->oc;
$druh = 1*$fir_riadok->mz12;
$r01bd = SkDatum($fir_riadok->r01bd);
$r01ad = SkDatum($fir_riadok->r01ad);
$r07ad = SkDatum($fir_riadok->r07ad);
$r07bd = SkDatum($fir_riadok->r07bd);
$str4 = $fir_riadok->str4;
$str5 = $fir_riadok->str5;
$zam4 = $fir_riadok->zam4;
$zam5 = $fir_riadok->zam5;

$zprie = $fir_riadok->zprie;
$zmeno = $fir_riadok->zmeno;
$ztitl = $fir_riadok->ztitl;
$ztitz = $fir_riadok->ztitz;
$zrdc = $fir_riadok->zrdc;
$zrdk = $fir_riadok->zrdk;
$zuli = $fir_riadok->zuli;
$zcdm = $fir_riadok->zcdm;
$zpsc = $fir_riadok->zpsc;
$zmes = $fir_riadok->zmes;
$zstat = $fir_riadok->zstat;
$ztel = $fir_riadok->ztel;
$zemfax = $fir_riadok->zemfax;
$r01a = $fir_riadok->r01a;
$r01b = $fir_riadok->r01b;
$r02a = $fir_riadok->r02a;
$r03a = $fir_riadok->r03a;
$r04a = $fir_riadok->r04a;
$r05a = $fir_riadok->r05a;
$r06a = $fir_riadok->r06a;
$r07a = $fir_riadok->r07a;
$r08a = $fir_riadok->r08a;
$r09a = $fir_riadok->r09a;
$r10a = $fir_riadok->r10a;
$r11a = $fir_riadok->r11a;
$r12a = $fir_riadok->r12a;
$ra1a = $fir_riadok->ra1a;
$rb1a = $fir_riadok->rb1a;
$rc1a = $fir_riadok->rc1a;
$ra1b = $fir_riadok->ra1b;
$rb1b = $fir_riadok->rb1b;
$rc1b = $fir_riadok->rc1b;
$mzc = 1*$fir_riadok->mzc;
mysql_free_result($fir_vysledok);

//priezvisko,meno,titul FO a nazov,forma PO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
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
$xstat = "Slovensko";
if ( $fir_uctt03 != 999 ) {
$dmeno=""; $dprie=""; $dtitl=""; $dtitz="";
$duli=$fir_fuli; $dcdm=$fir_fcdm; $dmes=$fir_fmes; $dpsc=$fir_fpsc;
$zamestnavatel=$fir_fnaz;
                          }
if ( $fir_uctt03 == 999 ) {
$fir_fnaz=""; $fir_uctt03="";
$zamestnavatel=$dmeno." ".$dprie." ".$dtitl;
                          }
     }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Hl·senie dane</title>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
if ( $copern == 20 )
{
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.r01bd.value = '<?php echo "$r01bd";?>';
   document.formv1.r01ad.value = '<?php echo "$r01ad";?>';
   document.formv1.r07ad.value = '<?php echo "$r07ad";?>';
   document.formv1.r07bd.value = '<?php echo "$r07bd";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.zprie.value = '<?php echo "$zprie";?>';
   document.formv1.zmeno.value = '<?php echo "$zmeno";?>';
   document.formv1.ztitl.value = '<?php echo "$ztitl";?>';
   document.formv1.ztitz.value = '<?php echo "$ztitz";?>';
   document.formv1.zrdc.value = '<?php echo "$zrdc";?>';
   document.formv1.zrdk.value = '<?php echo "$zrdk";?>';
   document.formv1.zuli.value = '<?php echo "$zuli";?>';
   document.formv1.zcdm.value = '<?php echo "$zcdm";?>';
   document.formv1.zpsc.value = '<?php echo "$zpsc";?>';
   document.formv1.zmes.value = '<?php echo "$zmes";?>';
   document.formv1.zstat.value = '<?php echo "$zstat";?>';
   document.formv1.ztel.value = '<?php echo "$ztel";?>';
   document.formv1.zemfax.value = '<?php echo "$zemfax";?>';
   document.formv1.r01a.value = '<?php echo "$r01a";?>';
   document.formv1.r01b.value = '<?php echo "$r01b";?>';
   document.formv1.r02a.value = '<?php echo "$r02a";?>';
   document.formv1.r03a.value = '<?php echo "$r03a";?>';
   document.formv1.r04a.value = '<?php echo "$r04a";?>';
   document.formv1.r05a.value = '<?php echo "$r05a";?>';
   document.formv1.r06a.value = '<?php echo "$r06a";?>';
   document.formv1.r07a.value = '<?php echo "$r07a";?>';
   document.formv1.r08a.value = '<?php echo "$r08a";?>';
   document.formv1.r09a.value = '<?php echo "$r09a";?>';
   document.formv1.r10a.value = '<?php echo "$r10a";?>';
   document.formv1.r11a.value = '<?php echo "$r11a";?>';
   document.formv1.r12a.value = '<?php echo "$r12a";?>';
   document.formv1.ra1a.value = '<?php echo "$ra1a";?>';
   document.formv1.rb1a.value = '<?php echo "$rb1a";?>';
   document.formv1.rc1a.value = '<?php echo "$rc1a";?>';
   document.formv1.ra1b.value = '<?php echo "$ra1b";?>';
   document.formv1.rb1b.value = '<?php echo "$rb1b";?>';
   document.formv1.rc1b.value = '<?php echo "$rc1b";?>';
<?php if ( $mzc == 1 ) { ?> document.formv1.mzc.checked = "checked"; <?php } ?>
<?php                     } ?>
  }
<?php
}
//koniec uprava
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

  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/hlaseniedane/HLASENIEv13_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function CitajMzlist()
  { 
   window.open('../mzdy/hlasenie_dane2014.php?h_drp=<?php echo $h_drp; ?>&h_dap=<?php echo $h_dap; ?>&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>', '_blank');
  }
  function CitajPrehlad()
  { 
   window.open('../mzdy/hlasenie_dane2014.php?h_drp=<?php echo $h_drp; ?>&h_dap=<?php echo $h_dap; ?>&copern=230&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>', '_blank');
  }

<?php $dnessk = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?> 
  function TlacRocHlasenie2013()
  {
   window.open('../mzdy/hlasenie_dane2014.php?h_drp=1&h_dap=<?php echo $dnessk; ?>&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=9999', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
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
  <td class="header">Hl·senie o vy˙ËtovanÌ dane</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="CitajPrehlad();" title="NaËÌtaù ˙daje z mesaËn˝ch PREHºADOV" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="CitajMzlist();" title="NaËÌtaù ˙daje z MZDOV›CH LISTOV" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacRocHlasenie2013();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php if ( $nacitanezmes == 1 ) { echo $nacitanemesiace; } ?>
<div id="content">
<FORM name="formv1" method="post" action="hlasenie_dane2014.php?copern=23&drupoh=1&cislo_oc=1&fmzdy=<?php echo $kli_vxcfmzdy; ?>&h_dap=<?php echo $h_dap; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="../mzdy/hlasenie_dane2014.php?drupoh=1&page=1&subor=0";
?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_daneoc2014.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=63&page=1&subor=0', '_self');" class="<?php echo $clas3; ?> toleft">prÌloha</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_dane2014.php?h_drp=&h_dap=&copern=10&drupoh=2&page=1&subor=0', '_blank');" class="<?php echo $clas3; ?> toright">prÌloha</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str1.jpg" alt="tlaËivo Hl·senie o vy˙ËtovanÌ dane pre rok 2013 1.strana 243kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:329px; left:52px;"/>
<input type="text" name="fir_uctt01" id="fir_uctt01" value="<?php echo $fir_uctt01; ?>" disabled="disabled" class="nofill" style="width:312px; top:382px; left:52px;"/>

<!-- Druh hlasenia -->
<input type="radio" id="druh1" name="druh" value="1" style="top:329px; left:463px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:356px; left:463px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:383px; left:463px;"/>

<input type="text" name="vrok" id="vrok" value="<?php echo $kli_vrok;?>" disabled="disabled" class="nofill center" style="width:84px; top:305px; left:785px; padding:1px 0;"/>
<input type="text" name="r01bd" id="r01bd" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:382px; left:691px;"/>
<!-- FO -->
<input type="text" name="dprie" id="dprie" value="<?php echo $dprie; ?>" disabled="disabled" class="nofill" style="width:357px; top:475px; left:52px;"/>
<input type="text" name="dmeno" id="dmeno" value="<?php echo $dmeno; ?>" disabled="disabled" class="nofill" style="width:244px; top:475px; left:430px;"/>
<input type="text" name="dtitl" id="dtitl" value="<?php echo $dtitl; ?>" disabled="disabled" class="nofill" style="width:111px; top:475px; left:695px;"/>
<input type="text" name="dtitz" id="dtitz" value="<?php echo $dtitz; ?>" disabled="disabled" class="nofill" style="width:66px; top:475px; left:827px;"/>
<!-- PO -->
<input type="text" name="obchm" id="obchm" value="<?php echo $fir_fnaz; ?>" disabled="disabled" class="nofill" style="width:725px; top:569px; left:52px;"/>
<input type="text" name="pfor" id="pfor" value="<?php echo $fir_uctt03; ?>" disabled="disabled" class="nofill" style="width:59px; top:569px; left:822px;"/>
<!-- Sidlo PO alebo pobyt FO -->
<input type="text" name="duli" id="duli" value="<?php echo $duli; ?>" disabled="disabled" class="nofill" style="width:634px; top:659px; left:51px;"/>
<input type="text" name="dcdm" id="dcdm" value="<?php echo $dcdm; ?>" disabled="disabled" class="nofill" style="width:173px; top:659px; left:719px;"/>
<input type="text" name="dpsc" id="dpsc" value="<?php echo $dpsc; ?>" disabled="disabled" class="nofill" style="width:107px; top:715px; left:51px;"/>
<input type="text" name="dmes" id="dmes" value="<?php echo $dmes; ?>" disabled="disabled" class="nofill" style="width:450px; top:715px; left:178px;"/>
<input type="text" name="xstat" id="xstat" value="<?php echo $xstat; ?>" disabled="disabled" class="nofill" style="width:243px; top:715px; left:649px;"/>
<input type="text" name="tel" id="tel" value="<?php echo $fir_ftel; ?>" disabled="disabled" class="nofill" style="width:289px; top:776px; left:51px;"/>
<input type="text" name="email" id="email" value="<?php echo $fir_fem1; ?>" disabled="disabled" class="nofill" style="width:518px; top:776px; left:374px;"/>
<!-- Vykonane -->
<input type="text" name="r01ad" id="r01ad" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:824px; left:691px;"/>
<!-- Vypracoval -->
<input type="text" name="zrobil" id="zrobil" value="<?php echo $zrobil; ?>" disabled="disabled" class="nofill" style="width:309px; top:885px; left:51px;"/>
<input type="text" name="r07ad" id="r07ad" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:885px; left:386px;"/>
<input type="text" name="zrobtel" id="zrobtel" value="<?php echo $fir_mzdt04; ?>" disabled="disabled" class="nofill" style="width:289px; top:885px; left:603px;"/>
<!-- Vyhlasujem -->
<input type="text" name="r07bd" id="r07bd" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:930px; left:696px;"/>
<input type="text" name="str4" id="str4" value="<?php echo $str4; ?>" disabled="disabled" class="nofill" style="width:82px; top:971px; left:213px;"/>
<input type="text" name="str5" id="str5" value="<?php echo $str5; ?>" disabled="disabled" class="nofill" style="width:82px; top:971px; left:340px;"/>
<input type="text" name="zam4" id="zam4" value="<?php echo $zam4; ?>" disabled="disabled" class="nofill" style="width:105px; top:1012px; left:190px;"/>
<input type="text" name="zam5" id="zam5" value="<?php echo $zam5; ?>" disabled="disabled" class="nofill" style="width:105px; top:1012px; left:316px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str2.jpg" alt="tlaËivo Hl·senie o vy˙ËtovanÌ dane pre rok 2013 2.strana 243kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:219px; top:69px; left:367px;"/>

<!-- ZASTUPCA -->
<input type="text" name="zprie" id="zprie" style="width:359px; top:160px; left:51px;"/>
<input type="text" name="zmeno" id="zmeno" style="width:244px; top:160px; left:430px;"/>
<input type="text" name="ztitl" id="ztitl" style="width:112px; top:160px; left:694px;"/>
<input type="text" name="ztitz" id="ztitz" style="width:66px; top:160px; left:827px;"/>
<input type="text" name="zrdc" id="zrdc" style="width:129px; top:215px; left:51px;"/>
<input type="text" name="zrdk" id="zrdk" style="width:84px; top:215px; left:212px;"/>
<input type="text" name="zuli" id="zuli" style="width:357px; top:215px; left:328px;"/>
<input type="text" name="zcdm" id="zcdm" style="width:175px; top:215px; left:718px;"/>
<input type="text" name="zpsc" id="zpsc" style="width:107px; top:270px; left:51px;"/>
<input type="text" name="zmes" id="zmes" style="width:451px; top:270px; left:178px;"/>
<input type="text" name="zstat" id="zstat" style="width:245px; top:270px; left:648px;"/>
<input type="text" name="ztel" id="ztel" style="width:289px; top:330px; left:51px;"/>
<input type="text" name="zemfax" id="zemfax" style="width:519px; top:330px; left:374px;"/>
<!-- CAST I. -->
<input type="text" name="r01a" id="r01a" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:420px; left:498px;"/>
<input type="text" name="r01b" id="r01b" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:510px; left:498px;"/>
<input type="text" name="r02a" id="r02a" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:550px; left:498px;"/>
<input type="text" name="r03a" id="r03a" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:590px; left:498px;"/>
<input type="text" name="r04a" id="r04a" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:629px; left:498px;"/>
<input type="text" name="r05a" id="r05a" onkeyup="CiarkaNaBodku(this);" style="width:239px; top:675px; left:547px;"/>
<input type="text" name="r06a" id="r06a" onkeyup="CiarkaNaBodku(this);" style="width:239px; top:725px; left:547px;"/>
<input type="text" name="r07a" id="r07a" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:768px; left:498px;"/>
<input type="text" name="r08a" id="r08a" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:806px; left:520px;"/>
<input type="text" name="r09a" id="r09a" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:846px; left:520px;"/>
<input type="text" name="r10a" id="r10a" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:885px; left:520px;"/>
<!-- CAST II. -->
<input type="text" name="r11a" id="r11a" onkeyup="CiarkaNaBodku(this);" style="width:285px; top:960px; left:501px;"/>
<input type="text" name="r12a" id="r12a" onkeyup="CiarkaNaBodku(this);" style="width:285px; top:1000px; left:501px;"/>
<!-- CAST III. -->
<input type="text" name="ra1a" id="ra1a" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1075px; left:238px;"/>
<input type="text" name="rb1a" id="rb1a" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1122px; left:238px;"/>
<input type="text" name="rc1a" id="rc1a" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1187px; left:238px;"/>
<input type="text" name="ra1b" id="ra1b" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1075px; left:669px;"/>
<input type="text" name="rb1b" id="rb1b" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1122px; left:669px;"/>
<input type="text" name="rc1b" id="rc1b" onkeyup="CiarkaNaBodku(this);" style="width:221px; top:1187px; left:669px;"/>

<input type="checkbox" name="mzc" value="1" style="top:1254px; left:360px;"/>
<?php if ( $copern == 10 AND $drupoh == 3 ) { ?>
<a href="../tmp/<?php echo $banka; ?>.txt" style="position:absolute; top:70px; left:100px;">../tmp/<?php echo $banka; ?>.txt</a>
<?php                                       } ?> <!-- dopyt, mÈdium nedokonËenÈ -->

<?php                                        } ?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('../mzdy/hlasenie_daneoc2014.php?cislo_oc=9999&copern=101&drupoh=1&fmzdy=63&page=1&subor=0', '_self');" class="<?php echo $clas3; ?> toleft">prÌloha</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
}
//koniec uprav udaje
?>


<?php
/////////////////////////////////////////////////VYTLAC HLASENIE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/hlasenieDane.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/hlasenieDane.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//tlac hlasenia
if ( $drupoh == 1 )
     {
//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedane".
" WHERE oc = $cislo_oc AND konx = 2 ORDER BY konx";

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
$pdf->SetLeftMargin(7);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str1.jpg',0,0,210,297);
}

//dic
$pdf->Cell(190,60," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//danovy urad
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(70,6,"$fir_uctt01","$rmc",1,"L");

//druh hlasenia
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->mz12 == 2 ) { $riadne=""; $opravne="x"; $dodatocne=""; }
if ( $hlavicka->mz12 == 3 ) { $riadne=""; $opravne=""; $dodatocne="x"; }
$pdf->SetY(70);
$pdf->Cell(96,5," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadne","$rmc",1,"C");
$pdf->SetY(76);
$pdf->Cell(96,5," ","$rmc1",0,"C");$pdf->Cell(3,3,"$opravne","$rmc",1,"C");
$pdf->SetY(82);
$pdf->Cell(96,5," ","$rmc1",0,"C");$pdf->Cell(3,4,"$dodatocne","$rmc",1,"C");

//za rok
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
$pdf->SetY(64);
$pdf->Cell(176,6," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t02","$rmc",1,"C");

//datum dodatocneho
$pdf->SetY(82);
$text="";
if ( $hlavicka->mz12 == 3 ) $text=SkDatum($hlavicka->r01bd);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(146,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//FO
$pdf->Cell(190,15," ","$rmc1",1,"L");
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
$R=substr($dprie,16,1);
$M=substr($dprie,17,1);
$S=substr($dprie,18,1);
$T=substr($dprie,19,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
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
$L=substr($dmeno,11,1);
$M=substr($dmeno,12,1);
$N=substr($dmeno,13,1);
$O=substr($dmeno,14,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");

$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(26,6,"$dtitl","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$dtitz","$rmc",1,"L");

//PO
$pdf->Cell(190,16," ","$rmc1",1,"L");
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
$G1=substr($fir_fnaz,32,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");

$A=substr($fir_uctt03,0,1);
$B=substr($fir_uctt03,1,1);
$C=substr($fir_uctt03,2,1);
$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",1,"C");

//ulica
$pdf->Cell(190,14," ","$rmc1",1,"L");
$A=substr($duli,0,1);
$B=substr($duli,1,1);
$C=substr($duli,2,1);
$D=substr($duli,3,1);
$E=substr($duli,4,1);
$F=substr($duli,5,1);
$G=substr($duli,6,1);
$H=substr($duli,7,1);
$I=substr($duli,8,1);
$J=substr($duli,9,1);
$K=substr($duli,10,1);
$L=substr($duli,11,1);
$M=substr($duli,12,1);
$N=substr($duli,13,1);
$O=substr($duli,14,1);
$P=substr($duli,15,1);
$R=substr($duli,16,1);
$S=substr($duli,17,1);
$T=substr($duli,18,1);
$U=substr($duli,19,1);
$V=substr($duli,20,1);
$W=substr($duli,21,1);
$X=substr($duli,22,1);
$Y=substr($duli,23,1);
$Z=substr($duli,24,1);
$A1=substr($duli,25,1);
$B1=substr($duli,26,1);
$C1=substr($duli,27,1);
$D1=substr($duli,28,1);
$E1=substr($duli,29,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");

//cislo
$A=substr($dcdm,0,1);
$B=substr($dcdm,1,1);
$C=substr($dcdm,2,1);
$D=substr($dcdm,3,1);
$E=substr($dcdm,4,1);
$F=substr($dcdm,5,1);
$G=substr($dcdm,6,1);
$H=substr($dcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$dpsc=str_replace(" ","",$dpsc);
$A=substr($dpsc,0,1);
$B=substr($dpsc,1,1);
$C=substr($dpsc,2,1);
$D=substr($dpsc,3,1);
$E=substr($dpsc,4,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//obec
$A=substr($dmes,0,1);
$B=substr($dmes,1,1);
$C=substr($dmes,2,1);
$D=substr($dmes,3,1);
$E=substr($dmes,4,1);
$F=substr($dmes,5,1);
$G=substr($dmes,6,1);
$H=substr($dmes,7,1);
$I=substr($dmes,8,1);
$J=substr($dmes,9,1);
$K=substr($dmes,10,1);
$L=substr($dmes,11,1);
$M=substr($dmes,12,1);
$N=substr($dmes,13,1);
$O=substr($dmes,14,1);
$P=substr($dmes,15,1);
$R=substr($dmes,16,1);
$S=substr($dmes,17,1);
$T=substr($dmes,18,1);
$U=substr($dmes,19,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");

//stat
$A=substr($xstat,0,1);
$B=substr($xstat,1,1);
$C=substr($xstat,2,1);
$D=substr($xstat,3,1);
$E=substr($xstat,4,1);
$F=substr($xstat,5,1);
$G=substr($xstat,6,1);
$H=substr($xstat,7,1);
$I=substr($xstat,8,1);
$J=substr($xstat,9,1);
$K=substr($xstat,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//telefon
$pdf->Cell(190,8," ","$rmc1",1,"L");
$A=substr($fir_ftel,0,1);
$B=substr($fir_ftel,1,1);
$C=substr($fir_ftel,2,1);
$D=substr($fir_ftel,3,1);
$E=substr($fir_ftel,4,1);
$F=substr($fir_ftel,5,1);
$G=substr($fir_ftel,6,1);
$H=substr($fir_ftel,7,1);
$I=substr($fir_ftel,8,1);
$J=substr($fir_ftel,9,1);
$K=substr($fir_ftel,10,1);
$L=substr($fir_ftel,11,1);
$M=substr($fir_ftel,12,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");

//email
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(115,6,"$fir_fem1","$rmc",1,"L");

//datum vykonania RZ
$pdf->Cell(190,5," ","$rmc1",1,"L");
$h_drz=SkDatum($hlavicka->r01ad);
if ( $h_drz == '00.00.0000' ) $h_drz="";
$da1=substr($h_drz,0,1);
$da2=substr($h_drz,1,1);
$da3=substr($h_drz,3,1);
$da4=substr($h_drz,4,1);
$da5=substr($h_drz,6,1);
$da6=substr($h_drz,7,1);
$da7=substr($h_drz,8,1);
$da8=substr($h_drz,9,1);
$pdf->Cell(146,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//vypracoval
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(69,6,"$zrobil","$rmc",0,"L");

$text="";
$text=SkDatum($hlavicka->r07ad);
if ( $text == '00.00.0000' ) $text="";
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",0,"C");

$A=substr($fir_mzdt04,0,1);
$B=substr($fir_mzdt04,1,1);
$C=substr($fir_mzdt04,2,1);
$D=substr($fir_mzdt04,3,1);
$E=substr($fir_mzdt04,4,1);
$F=substr($fir_mzdt04,5,1);
$G=substr($fir_mzdt04,6,1);
$H=substr($fir_mzdt04,7,1);
$I=substr($fir_mzdt04,8,1);
$J=substr($fir_mzdt04,9,1);
$K=substr($fir_mzdt04,10,1);
$L=substr($fir_mzdt04,11,1);
$M=substr($fir_mzdt04,12,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",1,"C");

//datum vyhlasujem
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="";
$text=SkDatum($hlavicka->r07bd);
if ( $text == '00.00.0000' ) { $text=""; }
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(147,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//pocet stran v casti IV.
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=1*$hlavicka->str4;
if ( $text == 0 ) { $text=""; }
$hriadok=sprintf('% 4s',$text);
$A=substr($hriadok,0,1);
$B=substr($hriadok,1,1);
$C=substr($hriadok,2,1);
$D=substr($hriadok,3,1);
$pdf->Cell(40,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//pocet stran v casti V.
$text=1*$hlavicka->str5;
if ( $text == 0 ) { $text=""; }
$hriadok=sprintf('% 4s',$text);
$A=substr($hriadok,0,1);
$B=substr($hriadok,1,1);
$C=substr($hriadok,2,1);
$D=substr($hriadok,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//pocet zamestnancov v casti IV.
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text=1*$hlavicka->zam4;
//if ( $text == 0 ) { $text=""; }
$hriadok=sprintf('% 5s',$text);
$A=substr($hriadok,0,1);
$B=substr($hriadok,1,1);
$C=substr($hriadok,2,1);
$D=substr($hriadok,3,1);
$E=substr($hriadok,4,1);
$pdf->Cell(35,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//pocet zamestnancov v casti V.
$text=1*$hlavicka->zam5;
//if ( $text == 0 ) { $text=""; }
$hriadok=sprintf('% 5s',$text);
$A=substr($hriadok,0,1);
$B=substr($hriadok,1,1);
$C=substr($hriadok,2,1);
$D=substr($hriadok,3,1);
$E=substr($hriadok,4,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",1,"C");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(12);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str2.jpg',0,0,210,297);
}

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(69,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//ZASTUPCA
//priezvisko
$pdf->Cell(195,14," ","$rmc1",1,"L");
$text=$hlavicka->zprie;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t12","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");

//meno
$text=$hlavicka->zmeno;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t11","$rmc",0,"C");

//titul pred a za
$pdf->Cell(4,6,"                          ","$rmc1",0,"L");
$text="ABCDEFGHI";
$pdf->Cell(26,6,"$hlavicka->ztitl","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->ztitz","$rmc",1,"L");

//rodne cislo
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text=$hlavicka->zrdc.$hlavicka->zrdk;
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
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");

//ulica
$text=$hlavicka->zuli;
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
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//cislo
$text=$hlavicka->zcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->zpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec
$text=$hlavicka->zmes;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");

//stat
$text=$hlavicka->zstat;
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
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//telefon
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->ztel;
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
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(5,7,"$t13","$rmc",0,"C");

//email
$text=$hlavicka->zemfax;
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,7,"$text","$rmc",1,"L");

//CAST I.
//riadok 0
$pdf->Cell(190,14," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 1
$pdf->Cell(190,14," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01b;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 2
$pdf->Cell(190,4," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r02a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 3
$pdf->Cell(190,2," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r03a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r04a;
//if( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 5
$pdf->Cell(190,5," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r05a;
if ( $tlachod < 0 ) { $znamienko="-"; $tlachod=-$tlachod; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 6
$pdf->Cell(190,5," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r06a;
if ( $tlachod < 0 ) { $znamienko="-"; $tlachod=-$tlachod; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 7
$pdf->Cell(190,4," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r07a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 8
$pdf->Cell(190,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r08a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 9
$pdf->Cell(190,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r09a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 10
$pdf->Cell(190,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r10a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//CAST II.
//riadok 11
$pdf->Cell(190,11," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r11a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 OR $hlavicka->mz12 != 3 ) { $znamienko = ""; $tlachod = ""; }
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 12
$pdf->Cell(190,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r12a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 OR $hlavicka->mz12 != 3 ) { $znamienko = ""; $tlachod = ""; }
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 11s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$K=substr($tlachod_c,10,1);
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//CAST III.
//suma A
$pdf->Cell(190,11," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->ra1a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");

//suma D
$znamienko="";
$tlachod=100*$hlavicka->ra1b;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(45,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",1,"C");

//suma B
$pdf->Cell(190,5," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->rb1a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");

//suma E
$znamienko="";
$tlachod=100*$hlavicka->rb1b;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(45,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",1,"C");

//suma C
$pdf->Cell(190,9," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->rc1a;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");

//suma F
$znamienko="";
$tlachod=100*$hlavicka->rc1b;
if ( $tlachod < 0 ) { $tlachod=-1*$tlachod; $znamienko="-"; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell(45,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",1,"C");

//krizik medium
$pdf->Cell(190,10," ","$rmc1",1,"L");
$ajmedium="x";
if ( $hlavicka->mzc == 0 ) $ajmedium=" ";
$pdf->Cell(68,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$ajmedium","$rmc",1,"C");
                                       } //koniec 2.strany
}
$i = $i + 1;
  }
$pdf->Output("../tmp/hlasenieDane.$kli_uzid.pdf");
     }

//tlac prilohy
if ( $drupoh == 2 )
     {
if ( File_Exists("../tmp/hlasenieDanepril.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/hlasenieDanepril.$kli_uzid.pdf"); }

//pocet stran
$pocstran4=1; $pocstran5=1;
$sqldok = mysql_query("SELECT str4, str5 FROM F$kli_vxcf"."_mzdrocnehlaseniedane");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pocstran4=1*$riaddok->str4;
  $pocstran5=1*$riaddok->str5;
  }

//vytlac prilohu IV.cast = nevykonal RZ
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdkun.oc > 0 AND tz1 != 1 ORDER BY F$kli_vxcf"."_mzdkun.oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$suvprilohe4=0;
if( $pol > 0 ) { $suvprilohe4=1; }

$i=0;
$j=0;
$strana=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
{
$hlavicka=mysql_fetch_object($sql);

//zahlavie casti IV.
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(6);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str3.jpg') AND $j == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str3.jpg',0,0,210,297);
}
$strana=$strana+1;

//CAST IV.
//cislo strany
$pdf->Cell(190,1," ","$rmc1",1,"L");
$tlachod=$strana;
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 4s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->Cell(36,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//pocet stran
if ( $pocstran4 == 0 ) { $pocstran4=1; }
$tlachod=$pocstran4;
$tlachod_c=sprintf("% 4s",$tlachod);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//dic
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
     }
//koniec j=0
if ( $j == 0 ) { $pozy=36; $pozx=37; }
if ( $j == 1 ) { $pozy=36; $pozx=116; }
$pdf->SetY($pozy);

//Slovak verzus cudzinec
$zstak="703"; $zstat="Slovensko";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  $zstak=1*$riaddok->zstak;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }
if ( $zstak == 0 ) { $zstak="703"; }
if( $suvprilohe4 == 0 ) { $zstat=""; $zstak="";  }
//rodne cislo
$tlachod=$hlavicka->rdc;
//if ( $zstak != 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$tlachod=$hlavicka->rdk;
//if ( $zstak != 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//datum narodenia
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=SkDatum($hlavicka->dar);
if ( $tlachod == '00.00.0000' ) $tlachod="";
if ( $zstak == 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//priezvisko
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$hlavicka->prie;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $hlavicka->oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zuli=$riaddok->zuli;
  $zpsc=$riaddok->zpsc;
  $zcdm=$riaddok->zcdm;
  $zmes=$riaddok->zmes;
  }

//meno
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$hlavicka->meno;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//ulica
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zuli;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//cislo
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zcdm;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");

//psc
$tlachod=$zpsc;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",1,"C");

//obec
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zmes;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//stat
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zstat;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");

//kod statu
$tlachod=$zstak;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",1,"C");

//r3 uhrn prijmov
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01a;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 10s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//r3 prijmy z dohod
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->doho;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 10s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//r4 zuctovane mesiace
$pdf->Cell(30,5," ","$rmc1",1,"L");
$obd112="x";
$obd1="x"; $obd2="x"; $obd3="x"; $obd4="x"; $obd5="x"; $obd6="x"; $obd7="x"; $obd8="x"; $obd9="x"; $obd10="x"; $obd11="x"; $obd12="x";
if ( $hlavicka->mz01 == 1 AND $hlavicka->mz02 == 1 AND $hlavicka->mz03 == 1 AND $hlavicka->mz04 == 1 AND $hlavicka->mz05 == 1 AND $hlavicka->mz06 == 1 AND $hlavicka->mz07 == 1 AND $hlavicka->mz08 == 1 AND $hlavicka->mz09 == 1 AND $hlavicka->mz10 == 1 AND $hlavicka->mz11 == 1 AND $hlavicka->mz12 == 1 )
{
$obd112="x";
$obd1=""; $obd2=""; $obd3=""; $obd4=""; $obd5=""; $obd6=""; $obd7=""; $obd8=""; $obd9=""; $obd10=""; $obd11=""; $obd12="";
}
if ( $hlavicka->mz01 != 1 ) { $obd112=" "; $obd1=" "; }
if ( $hlavicka->mz02 != 1 ) { $obd112=" "; $obd2=" "; }
if ( $hlavicka->mz03 != 1 ) { $obd112=" "; $obd3=" "; }
if ( $hlavicka->mz04 != 1 ) { $obd112=" "; $obd4=" "; }
if ( $hlavicka->mz05 != 1 ) { $obd112=" "; $obd5=" "; }
if ( $hlavicka->mz06 != 1 ) { $obd112=" "; $obd6=" "; }
if ( $hlavicka->mz07 != 1 ) { $obd112=" "; $obd7=" "; }
if ( $hlavicka->mz08 != 1 ) { $obd112=" "; $obd8=" "; }
if ( $hlavicka->mz09 != 1 ) { $obd112=" "; $obd9=" "; }
if ( $hlavicka->mz10 != 1 ) { $obd112=" "; $obd10=" "; }
if ( $hlavicka->mz11 != 1 ) { $obd112=" "; $obd11=" "; }
if ( $hlavicka->mz12 != 1 ) { $obd112=" "; $obd12=" "; }
if ( $hlavicka->mz01 == 0 AND $hlavicka->mz02 == 0 AND $hlavicka->mz03 == 0 AND $hlavicka->mz04 == 0 AND $hlavicka->mz05 == 0 AND $hlavicka->mz06 == 0 AND $hlavicka->mz07 == 0 AND $hlavicka->mz08 == 0 AND $hlavicka->mz09 == 0 AND $hlavicka->mz10 == 0 AND $hlavicka->mz11 == 0 AND $hlavicka->mz12 == 0 )
{
$obd112="x";
}
if( $suvprilohe4 == 0 ) { $obd112=" ";  }
$pdf->Cell($pozx,4," ","$rmc1",0,"R");$pdf->Cell(2,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd112","$rmc",0,"C");$pdf->Cell(5,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd1","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd2","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd3","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd4","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd5","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd6","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd7","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd8","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd9","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd10","$rmc",0,"C");$pdf->Cell(3,4," ","$rmc1",0,"C");
$pdf->Cell(3,3,"$obd11","$rmc",0,"C");$pdf->Cell(2,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$obd12","$rmc",1,"C");

//r5 socialne poistenie
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->socp;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 7s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");

//r5 zdravotne poistenie
$znamienko="";
$tlachod=100*$hlavicka->zdrp;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 7s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",1,"C");

//r6 preddavky na dan
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01b;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//r7 danovy bonus
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->dnbh;
if ( $hlavicka->dnbh < 0 ) { $znamienko="-"; $tlachod=-$tlachod; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 6s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");

//r7 pocet deti
$tlachod=1*$hlavicka->tz3;
if ( $tlachod == 0 OR $hlavicka->dnbh == 0 ) $tlachod="";
$tlachod=sprintf("% 2s",$tlachod);
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$pdf->Cell(25,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");

//r8 nczd na danovnika
$pdf->Cell(30,3," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->pred == 1 ) $text="x";
$pdf->Cell($pozx,4," ","$rmc1",0,"R");$pdf->Cell(19,3," ","$rmc1",0,"C");$pdf->Cell(3,5,"$text","$rmc",0,"C");

//r8 pocet mesiacov nczd
$znamienko="";
$tlachod=1*$hlavicka->pdan;
if ( $tlachod == 0 OR $hlavicka->pred == 0 ) $tlachod="";
$tlachod=sprintf("% 2s",$tlachod);
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$pdf->Cell(43,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");

//r9 prispevok na sds
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->ddssum;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 7s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",1,"C");
}
$i = $i + 1;
$j = $j + 1;
if ( $j == 2 ) $j=0;
  }

//vymaz pred dalsou prilohou
$hlavicka->oc=0;
$zstat="";
$zstak="";
$zuli="";
$zpsc="";
$zcdm="";
$zmes="";
$suvprilohe5=0;

//vytlac prilohu V.cast = vykonal RZ
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdkun.oc > 0 AND tz1 = 1 ORDER BY F$kli_vxcf"."_mzdkun.oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
if( $pol > 0 ) { $suvprilohe5=1; }

$i=0;
$j=0;
$strana=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
{
$hlavicka=mysql_fetch_object($sql);

//zahlavie casti V.
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(6);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str4.jpg') AND $j == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlasenie_v14_str4.jpg',0,0,210,297);
}
$strana=$strana+1;

//CAST V.
//cislo strany
$pdf->Cell(190,1," ","$rmc1",1,"L");
$tlachod=$strana;
$tlachod_c=sprintf("% 4s",$tlachod);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->Cell(36,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//pocet stran
if ( $pocstran5 == 0 ) { $pocstran5=1; }
$tlachod=$pocstran5;
$tlachod_c=sprintf("% 4s",$tlachod);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");

//dic
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
     }
//koniec j=0
if ( $j == 0 ) { $pozy=33; $pozx=37; }
if ( $j == 1 ) { $pozy=33; $pozx=116; }
$pdf->SetY($pozy);

$zstak="703"; $zstat="Slovensko";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $hlavicka->oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zstat=$riaddok->zstat;
  $zstak=1*$riaddok->zstak;
  }
if ( $zstat == '' ) { $zstat="Slovensko"; }
if ( $zstak == 0 ) { $zstak="703"; }
if( $suvprilohe5 == 0 ) { $zstat=""; $zstak="";  }

//rodne cislo
$tlachod=$hlavicka->rdc;
//if ( $zstak != 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$tlachod=$hlavicka->rdk;
//if ( $zstak != 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

//datum narodenia
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=SkDatum($hlavicka->dar);
if ( $tlachod == '00.00.0000' ) $tlachod="";
if ( $zstak == 703 ) { $tlachod=""; }
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//priezvisko
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$hlavicka->prie;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $hlavicka->oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zuli=$riaddok->zuli;
  $zpsc=$riaddok->zpsc;
  $zcdm=$riaddok->zcdm;
  $zmes=$riaddok->zmes;
  }

//meno
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$hlavicka->meno;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//ulica
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zuli;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//cislo
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zcdm;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");

//psc
$tlachod=$zpsc;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",1,"C");

//obec
$pdf->Cell(30,2," ","$rmc1",1,"L");
$tlachod=$zmes;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$L=substr($tlachod,11,1);
$M=substr($tlachod,12,1);
$N=substr($tlachod,13,1);
$O=substr($tlachod,14,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",1,"C");

//stat
$pdf->Cell(30,3," ","$rmc1",1,"L");
$tlachod=$zstat;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$D=substr($tlachod,3,1);
$E=substr($tlachod,4,1);
$F=substr($tlachod,5,1);
$G=substr($tlachod,6,1);
$H=substr($tlachod,7,1);
$I=substr($tlachod,8,1);
$J=substr($tlachod,9,1);
$K=substr($tlachod,10,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");

//kod statu
$tlachod=$zstak;
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",1,"C");

//r3 uhrn prijmov
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01a;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 10s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//r3 prijmy z dohod
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->doho;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 10s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//r4 socialne poistenie
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->socp;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 7s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");

//r4 zdravotne poistenie
$znamienko="";
$tlachod=100*$hlavicka->zdrp;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 7s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",1,"C");

//r5 nczd na danovnika
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->nzdh;
if ( $tlachod == 0 ) $tlachod="";
if ( $hlavicka->ra1b > 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 6s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",1,"C");

//r6 preddavky na dan
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->r01b;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 9s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//r7 nczd na manzelku
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->nzmh;
if ( $tlachod == 0 ) $tlachod="";
if ( $hlavicka->ra1b > 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 6s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");

//r7 pocet deti
$znamienko="";
$tlachod=1*$hlavicka->tz3;
if ( $tlachod == 0 OR $hlavicka->dnbh == 0 ) $tlachod="";
$tlachod=sprintf("% 2s",$tlachod);
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$pdf->Cell(27,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");

//r8 nczd na SDS
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->ddsnzc;
if ( $tlachod == 0 ) $tlachod="";
//if ( $hlavicka->ra1b > 0 ) $tlachod=""; dopyt, neviem, Ëi je
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 6s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",1,"C");

//r9 zam.premia
$pdf->Cell(30,5," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->ra1b;
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 5s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(10,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//r9 mesiace naroku
$tlachod=$hlavicka->zmpm;
if ( $tlachod == 0 OR $hlavicka->ra1b == 0 ) $tlachod="";
$tlachod=sprintf("% 2s",$tlachod);
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$pdf->Cell(27,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");

//r10 danovy bonus
$pdf->Cell(30,3," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->dnbh;
if ( $hlavicka->dnbh < 0 ) { $znamienko="-"; $tlachod=-$tlachod; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 6s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");

//r10 pocet mesiacov
$tlachod=$hlavicka->dnbm;
if ( $tlachod == 0 OR $hlavicka->dnbh == 0 ) $tlachod="";
$tlachod=sprintf("% 3s",$tlachod);
$A=substr($tlachod,0,1);
$B=substr($tlachod,1,1);
$C=substr($tlachod,2,1);
$pdf->Cell(22,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",1,"C");

//r11 nedo/pre-platok RZ
$pdf->Cell(30,4," ","$rmc1",1,"L");
$znamienko="";
$tlachod=100*$hlavicka->rocz;
if ( $hlavicka->rocz < 0 ) { $znamienko="-"; $tlachod=-$tlachod; }
if ( $tlachod == 0 ) $tlachod="";
$pole = explode(".", $tlachod);
$tlachod_c = $pole[0];
$tlachod_d = substr($pole[1],0,2);
$tlachod_c=sprintf("% 10s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$I=substr($tlachod_c,8,1);
$J=substr($tlachod_c,9,1);
$pdf->Cell($pozx,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
}
$i = $i + 1;
$j = $j + 1;
if ( $j == 2 ) $j=0;
  }
$pdf->Output("../tmp/hlasenieDanepril.$kli_uzid.pdf");
//koniec formular prilohy if ( $drupoh == 2 )
     }
$pril5 = 1*$_REQUEST['pril5'];

//el. priloha V.
if ( $drupoh == 3 AND $pril5 == 1 )
     {
//pocet stran
$pocstran=1;
$sqldok = mysql_query("SELECT str5 FROM F$kli_vxcf"."_mzdrocnehlaseniedane");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pocstran=$riaddok->str5;
  }
//nazov R501dic201301.txt

$banka="R501".$fir_fdic.$kli_vrok."01";
if ( File_Exists("../tmp/$banka.txt") ) { $soubor = unlink("../tmp/$banka.txt"); }
$soubor = fopen("../tmp/$banka.txt", "a+");

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$pole = explode(".", $dnes);
$datden=$pole[0];
$datmes=$pole[1];
$datrok=$pole[2];
$denmes="".$datden.$datmes;

$sqlt = <<<mzdprc
(
Tento textov˝ s˙bor musÌ byù typu Ëist˝ text, t.j. smie obsahovaù iba pÌsmen·, cifry a znaky bodka, Ëiarka, pomlËka (mÌnus) alebo medzera. JednotlivÈ riadky musia byù oddelenÈ oddeæovaËmi riadkov.
Prv˝ riadok s˙boru musÌ obsahovaù nasledovnÈ inform·cie o platiteæovi dane (zamestn·vateæovi) v danej forme a rozsahu:
ï	Typ hl·senia ñ 1. znak (R pre riadne RH alebo O pre opravnÈ RH alebo D pre dodatoËnÈ RH)
ï	5 ñ 2. znak, identifik·tor, ûe ide o ˙daje k V. Ëasti hl·senia
ï	PoradovÈ ËÌslo hl·senia v r·mci danÈho typu a zdaÚovacieho obdobia ñ 3. a 4. znak (2 cifry)
ï	DI» ñ 5. aû 14. znak (10 cifier)
ï	Rok zdaÚovacieho obdobia, za ktorÈ je podanÈ hl·senie ñ 15. aû 18. znak (4 cifry)
ï	D·tum zistenia skutoËnosti na podanie dodatoËnÈho hl·senia ñ 19. aû 28. znak (v tvare DD.MM.RRRR) ñ Tento d·tum sa vypÂÚa iba pri dodatoËn˝ch hl·seniach, pre riadne a opravnÈ hl·senia sa uvedie 10 znakov medzera.
ï	ObchodnÈ meno u pr·vnick˝ch osÙb alebo priezvisko a meno oddelenÈ medzerou u fyzick˝ch osÙb ñ 29. aû 172. znak (144 pÌsmen, cifier alebo medzier)
Kaûd˝ ÔalöÌ riadok s˙boru musÌ obsahovaù nasledovnÈ inform·cie o zamestnancovi v danej forme a rozsahu:
ï	RodnÈ ËÌslo ñ 1. aû 10. znak (10 cifier bez lomÌtka pre zamestnancov naroden˝ch od roku 1954 vr·tane, 9 cifier bez lomÌtka doplnen˝ch 1 znakom medzera na konci pre zamestnancov naroden˝ch do roku 1953 vr·tane)
ï	D·tum narodenia v tvare DDMMRRRR - 11. aû 18. znak (8 cifier DDMMRRRR, ak ide o cudzieho öt·tneho prÌsluönÌka, alebo 8 medzier)
ï	Priezvisko ñ 19. aû 33. znak (15 pÌsmen alebo medzier)
ï	KrstnÈ meno ñ 34. aû 48. znak (15 pÌsmen alebo medzier)
ï	⁄hrn zdaniteæn˝ch prÌjmov podæa ß 5 vyplaten˝ch vöetk˝mi zamestn·vateæmi v prÌsluönom zdaÚovacom obdobÌ dane v mene EURO ñ 49. aû 59. znak (11 znakov,  tvar poloûky : 8 cifier, desatinn· bodka,  2 cifry  alebo  11 medzier)
ï	PrÌjmy plyn˙ce na z·klade dohody  v mene EURO ñ 60. aû 70. znak (11 znakov,  tvar poloûky : 8 cifier, desatinn· bodka,  2 cifry  alebo  11 medzier)
ï	Soci·lne poistenie v mene EURO ñ 71. aû 78. znak (8 znakov,  tvar poloûky : 5 cifier, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	ZdravotnÈ poistenie v mene EURO ñ 79. aû 86. znak (8 znakov,  tvar poloûky : 5 cifier, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	N»ZD na daÚovnÌka v EURO ñ 87. aû 93. znak  (7 znakov, tvar poloûky : 4 cifry, desatinn· bodka,  2 cifry  alebo  7 medzier)
ï	ZrazenÈ preddavky na daÚ v mene EURO ñ 94. aû 103. znak (10 znakov, tvar poloûky: 7 cifier, desatinn· bodka,  2 cifry  alebo  10 medzier)
ï	N»ZD na manûela/manûelku v EURO ñ 104. aû 110. znak  (7 znakov, tvar poloûky : 4 cifry, desatinn· bodka,  2 cifry  alebo  7 medzier)
ï	PoËet detÌ ñ 111. aû 112. znak (2 cifry alebo  2 medzery)

ï	Suma vyplatenej zam. prÈmie v mene EURO ñ 113. aû 118. znak (6 znakov, tvar poloûky :  3 cifry, desatinn· bodka,  2 cifry  alebo  6 medzier)
ï	PoËet mesiacov na vznik n·roku ñ 119. aû 120. znak (2 cifry alebo  2 medzery)

ï	DaÚov˝ bonus v mene EURO ñ 121. aû 128. znak (8 znakov, tvar poloûky : znamienko,  4 cifry, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	PoËet mesiacov ñ 129. aû 131. znak (3 cifry alebo  3 medzery)

ï	Nedoplatok alebo preplatok ñ 132. aû 143. znak  (12  znakov, tvar poloûky : znamienko,  8 cifier, desatinn· bodka,  2 cifry  alebo  12 medzier)
);
mzdprc;

//urob subor
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdkun.oc > 0 AND tz1 = 1 ORDER BY F$kli_vxcf"."_mzdkun.oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$strana=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//strana 1
if( $j == 0 )
    {
$obchmeno=$fir_fnaz."                                                                                                                                            ";
$obchmeno=substr($obchmeno,0,144);

  $text = "R501".$fir_fdic.$kli_vrok."          ".$obchmeno."\r\n";
  fwrite($soubor, $text);

$j=1;
    }
//koniec j=0



$rodnec=$hlavicka->rdc.$hlavicka->rdk."            ";
$rodnec=substr($rodnec,0,10);

$datnarx=SkDatum($hlavicka->dar);
$datnar8=str_replace(".","",$datnarx);

$prie15=$hlavicka->prie."                 ";
$prie15=substr($prie15,0,15);

$meno15=$hlavicka->meno."                 ";
$meno15=substr($meno15,0,15);


  $text = $rodnec.$datnar8.$prie15.$meno15;


$prij11=sprintf("% 11s",$hlavicka->r01a);
$prij11=substr($prij11,0,11);

$doho11=sprintf("% 11s",$hlavicka->doho);
$doho11=substr($doho11,0,11);

$socp8=sprintf("% 8s",$hlavicka->socp);
$socp8=substr($socp8,0,8);

$zdrp8=sprintf("% 8s",$hlavicka->zdrp);
$zdrp8=substr($zdrp8,0,8);


  $text = $text.$prij11.$doho11.$socp8.$zdrp8;


//sem dopln nczd 7znakov
$nzdh7=sprintf("% 7s",$hlavicka->nzdh);
$nzdh7=substr($nzdh7,0,7);

$pred10=sprintf("% 10s",$hlavicka->r01b);
$pred10=substr($pred10,0,10);

//sem dopln nczd na manzelku 7znakov
$nzmh7=sprintf("% 7s",$hlavicka->nzmh);
$nzmh7=substr($nzmh7,0,7);

$dbdet2=sprintf("% 2s",$hlavicka->tz3);
$dbdet2=substr($dbdet2,0,2);

//sem dopln zam.premia 6znakov
$zamp6=sprintf("% 6s",$hlavicka->ra1b);
$zamp6=substr($zamp6,0,6);

//sem dopln pocet mesiacov zp 2znaky
$zamm2=sprintf("% 2s",$hlavicka->zmpm);
$zamm2=substr($zamm2,0,2);

$bonus8=sprintf("% 8s",$hlavicka->dnbh);
$bonus8=substr($bonus8,0,8);

//sem dopln pocet mesiacov db 3znaky
$dnbm3=sprintf("% 3s",$hlavicka->dnbm);
$dnbm3=substr($dnbm3,0,3);

//sem dopln rocz 12znakov
$rocz12=sprintf("% 12s",$hlavicka->rocz);
$rocz12=substr($rocz12,0,12);

  $text = $text.$nzdh7.$pred10.$nzmh7.$dbdet2.$zamp6.$zamm2.$bonus8.$dnbm3.$rocz12."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }

fclose($soubor);

//koniec el. prilohy V. if( $drupoh == 3 AND $pril5 == 1 )
     }


//el. priloha IV.
if ( $drupoh == 3 AND $pril5 == 0 )
     {
//pocet stran
$pocstran=1;
$sqldok = mysql_query("SELECT str4 FROM F$kli_vxcf"."_mzdrocnehlaseniedane");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pocstran=$riaddok->str4;
  }

//nazov R401dic201301.txt

$banka="R401".$fir_fdic.$kli_vrok."01";
if (File_Exists ("../tmp/$banka.txt")) { $soubor = unlink("../tmp/$banka.txt"); }
$soubor = fopen("../tmp/$banka.txt", "a+");

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$pole = explode(".", $dnes);
$datden=$pole[0];
$datmes=$pole[1];
$datrok=$pole[2];
$denmes="".$datden.$datmes;

$sqlt = <<<mzdprc
(
Tento textov˝ s˙bor musÌ byù typu Ëist˝ text, t.j. smie obsahovaù iba pÌsmen·, cifry a znaky bodka, Ëiarka, pomlËka (mÌnus) alebo medzera. JednotlivÈ riadky musia byù oddelenÈ oddeæovaËmi riadkov.
Prv˝ riadok s˙boru musÌ obsahovaù nasledovnÈ inform·cie o platiteæovi dane (zamestn·vateæovi) v danej forme a rozsahu:
ï	Typ hl·senia ñ 1. znak (R pre riadne RH alebo O pre opravnÈ RH alebo D pre dodatoËnÈ RH)
ï	4 ñ 2. znak, identifik·tor, ûe ide o ˙daje k IV. Ëasti hl·senia
ï	PoradovÈ ËÌslo hl·senia v r·mci danÈho typu a zdaÚovacieho obdobia ñ 3. a 4. znak (2 cifry)
ï	DI» ñ 5. aû 14. znak (10 cifier)
ï	Rok zdaÚovacieho obdobia, za ktorÈ je podanÈ hl·senie ñ 15. aû 18. znak (4 cifry)
ï	D·tum zistenia skutoËnosti na podanie dodatoËnÈho hl·senia ñ 19. aû 28. znak (v tvare DD.MM.RRRR) ñ Tento d·tum sa vypÂÚa iba pri dodatoËn˝ch hl·seniach, pre riadne a opravnÈ hl·senia sa uvedie 10 znakov medzera.
ï	ObchodnÈ meno u pr·vnick˝ch osÙb alebo priezvisko a meno oddelenÈ medzerou u fyzick˝ch osÙb ñ 29. aû 172. znak (144 pÌsmen, cifier alebo medzier)
Kaûd˝ ÔalöÌ riadok s˙boru musÌ obsahovaù nasledovnÈ inform·cie o zamestnancovi v danej forme a rozsahu:
ï	RodnÈ ËÌslo ñ 1. aû 10. znak (10 cifier bez lomÌtka pre zamestnancov naroden˝ch od roku 1954 vr·tane, 9 cifier bez lomÌtka doplnen˝ch 1 znakom medzera na konci pre zamestnancov naroden˝ch do roku 1953 vr·tane)
ï	D·tum narodenia v tvare DDMMRRRR - 11. aû 18. znak (8 cifier DDMMRRRR, ˙daj sa vypÂÚa iba ak ide o cudzieho öt·tneho prÌsluönÌka  alebo 8 medzier)
ï	Priezvisko ñ 19. aû 33. znak (15 pÌsmen alebo medzier)
ï	KrstnÈ meno ñ 34. aû 48. znak (15 pÌsmen alebo medzier)
ï	⁄hrn prÌjmov vyplaten˝ch platiteæom dane, ktor˝ pod·va prehæad v mene EURO ñ 49. aû 59. znak (11 znakov,  tvar poloûky : 8 cifier, desatinn· bodka,  2 cifry  alebo  11 medzier)
ï	PrÌjmy plyn˙ce na z·klade dohody  v mene EURO ñ 60. aû 70. znak (11 znakov,  tvar poloûky : 8 cifier, desatinn· bodka,  2 cifry  alebo  11 medzier)
ï	Z˙ËtovanÈ v mesiacoch ñ 71. aû 96. znak (26 cifier, medzier, Ëiarok alebo pomlËiek)
ï	Soci·lne poistenie v mene EURO ñ 97. aû 104. znak (8 znakov,  tvar poloûky : 5 cifier, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	ZdravotnÈ poistenie v mene EURO ñ 105. aû 112. znak (8 znakov,  tvar poloûky : 5 cifier, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	ZrazenÈ preddavky na daÚ v mene EURO ñ 113. aû 122. znak (10 znakov, tvar poloûky: 7 cifier, desatinn· bodka,  2 cifry  alebo  10 medzier)
ï	DaÚov˝ bonus v mene EURO ñ 123. aû 130. znak (8 znakov, tvar poloûky : znamienko, 4 cifry, desatinn· bodka,  2 cifry  alebo  8 medzier)
ï	PoËet detÌ ñ 131. aû 132. znak (2 cifry alebo  2 medzery)

ï	UplatÚuje sa N»ZD na daÚovnÌka ñ 133. znak  (1  pÌsmeno  ÑAì alebo medzera)
ï	PoËet mesiacov ñ 134. aû 135. znak (2 cifry alebo  2 medzery)
Vöetky ˙daje musia spÂÚaù pokyny uvedenÈ v pouËenÌ na vyplnenie prehæadu.
Pri spracovanÌ mÈdia sa vykon·vaj˙ nasledovnÈ kontroly:
rodnÈ ËÌslo zamestnanca (kontrola sa bude vykon·vaù, len ak bude uvedenÈ R», ak bude uveden˝ d·tum narodenia, kontrola sa nebude prev·dzaù).
ï	KorektnÈ rodnÈ ËÌslo (do roku 1953 vr·tane dÂûky 9 doplnenÈ 1 medzerou na konci, od roku 1954 vr·tane dÂûky 10)

d·tum narodenia
ï	Iba medzery, cifry od 0 po 9, ak je vyplnenÈ, tak musÌ byù dÂûka 8 cifier
ï	V tvare DDMMRRR, t.z. pred dÚami 1 ñ 9 musÌ byù 0, pred mesiacmi 1-9 musÌ byù 0, napr. d·tum narodenia 5. aprÌl 1955 bude v tvare 05041955
	˙hrn prÌjmov
ï	Iba medzery,  cifry od 0 po 9 a desatinn· bodka,
ï	Ak je  suma vyplnen· -  kontrola na desatinnÈ miesta

prÌjmy plyn˙ce na z·klade dohody
ï	Iba medzery,  cifry od 0 po 9 a desatinn· bodka,
ï	Ak je  suma vyplnen· -  kontrola na desatinnÈ miesta, (kladn· suma musÌ byù menöia, alebo rovn· ako suma uveden· na r. ˙hrn prÌjmov)

	z˙ËtovanÈ v mesiacoch
ï	Zaökrt·vacie polÌËka - pri kaûdom zamestnancovi musÌ byù zaökrtnutÈ buÔ 1-12 alebo konkrÈtne mesiace

	soci·lne a zdravotnÈ poistenie
ï	Iba medzery,  cifry od 0 po 9 a desatinn· bodka,
ï	Ak je  suma vyplnen· -  kontrola na desatinnÈ miesta
	zrazenÈ preddavky
ï	Iba medzery,  cifry od 0 po 9 a desatinn· bodka,
ï	Ak je  suma vyplnen· - . kontrola na desatinnÈ miesta (kladn· suma musÌ byù menöia ako suma uveden· na r. ˙hrn prÌjmov)
	 daÚov˝ bonus
ï	Iba medzery,  cifry od 0 po 9 a desatinn· bodka,
ï	Ak je  suma vyplnen· - . kontrola na desatinnÈ miesta, maxim. suma <= sume roËnÈho bonusu na 1 dieùa  (249.24 EUR) x poËet detÌ na r. 7

	poËet detÌ
ï	Iba medzery a cifry od 0 po 9, ak je  poËet rÙzny od 0, musÌ byù rÙzna od nuly aj poloûka daÚov˝ bonus

	Uplatnenie N»ZD -  zaökrt·vacie polÌËko
ï	iba pÌsmeno A alebo medzera ( ak je uvedenÈ pÌsmeno A, musÌ byù vyplnen˝ t.j. rÙzny od 0 aj poËet  mesiacov za ktorÈ je uplatnen· N»ZD)

	PoËet mesiacov
ï	iba medzery a cifry od 0 po 9 ( ak je  poËet mesiacov rÙzny od 0, musÌ byù uvedenÈ aj pÌsmeno   A pri uplatnenÌ N»ZD).
);
mzdprc;


//urob subor
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnehlaseniedaneoc".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnehlaseniedaneoc.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdkun.oc > 0 AND tz1 = 0 ORDER BY F$kli_vxcf"."_mzdkun.oc";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$strana=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//strana 1

if( $j == 0 )
     {
$obchmeno=$fir_fnaz."                                                                                                                                            ";
$obchmeno=substr($obchmeno,0,144);

  $text = "R401".$fir_fdic.$kli_vrok."          ".$obchmeno."\r\n";
  fwrite($soubor, $text);

$j=1;
     }
//koniec j=0



$rodnec=$hlavicka->rdc.$hlavicka->rdk."            ";
$rodnec=substr($rodnec,0,10);

$datnarx=SkDatum($hlavicka->dar);
$datnar8=str_replace(".","",$datnarx);

$prie15=$hlavicka->prie."                 ";
$prie15=substr($prie15,0,15);

$meno15=$hlavicka->meno."                 ";
$meno15=substr($meno15,0,15);


  $text = $rodnec.$datnar8.$prie15.$meno15;


$prij11=sprintf("% 11s",$hlavicka->r01a);
$prij11=substr($prij11,0,11);

$doho11=sprintf("% 11s",$hlavicka->doho);
$doho11=substr($doho11,0,11);

//zuctovane v mesiacoch
$obd112="";
$pociatok=0;

if ( $hlavicka->mz01 == 1 ) { $obd112=$obd112."1"; $pociatok=1; }
if ( $hlavicka->mz02 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."2"; $pociatok=1; }
if ( $hlavicka->mz03 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."3"; $pociatok=1; }
if ( $hlavicka->mz04 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."4"; $pociatok=1; }
if ( $hlavicka->mz05 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."5"; $pociatok=1; }
if ( $hlavicka->mz06 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."6"; $pociatok=1; }
if ( $hlavicka->mz07 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."7"; $pociatok=1; }
if ( $hlavicka->mz08 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."8"; $pociatok=1; }
if ( $hlavicka->mz09 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."9"; $pociatok=1; }
if ( $hlavicka->mz10 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."10"; $pociatok=1; }
if ( $hlavicka->mz11 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."11"; $pociatok=1; }
if ( $hlavicka->mz12 == 1 ) { if ( $pociatok == 1 ) { $obd112=$obd112.","; } $obd112=$obd112."12"; $pociatok=1; }

if ( $hlavicka->mz01 == 1 AND $hlavicka->mz02 == 1 AND $hlavicka->mz03 == 1 AND $hlavicka->mz04 == 1 AND $hlavicka->mz05 == 1 AND $hlavicka->mz06 == 1 AND $hlavicka->mz07 == 1 AND $hlavicka->mz08 == 1 AND $hlavicka->mz09 == 1 AND $hlavicka->mz10 == 1 AND $hlavicka->mz11 == 1 AND $hlavicka->mz12 == 1 )
{
$obd112="1-12";
}

if ( $hlavicka->mzc == 1 )
{
$obd112="1-12";
}


$zuct26=$obd112."                                                    ";
$zuct26=substr($zuct26,0,26);


  $text = $text.$prij11.$doho11.$zuct26;


$socp8=sprintf("% 8s",$hlavicka->socp);
$socp8=substr($socp8,0,8);

$zdrp8=sprintf("% 8s",$hlavicka->zdrp);
$zdrp8=substr($zdrp8,0,8);

$pred10=sprintf("% 10s",$hlavicka->r01b);
$pred10=substr($pred10,0,10);

$bonus8=sprintf("% 8s",$hlavicka->dnbh);
$bonus8=substr($bonus8,0,8);

$dbdet2=sprintf("% 2s",$hlavicka->dnbm);
$dbdet2=substr($dbdet2,0,2);

$unczd=" ";
if( $hlavicka->pred == 1 ) { $unczd="A"; }

$pdan=1*$hlavicka->pdan;
$mnczd2=sprintf("% 2s",$pdan);
$mnczd2=substr($mnczd2,0,2);

  $text = $text.$socp8.$zdrp8.$pred10.$bonus8.$dbdet2.$unczd.$mnczd2."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
//koniec el. prilohy IV. if( $drupoh == 3 AND $pril5 == 0 )
     }


//vytlac potvrdenie o podani
if ( $copern == 10 AND $drupoh == 1 )
     {
if ( File_Exists("../tmp/potvrdrocnehlasenie$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdrocnehlasenie$kli_vume.$kli_uzid.pdf"); }

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',11);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlaseniev14_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dan_zo_zavislej2014/hlasenie_dane/hlaseniev14_potvrdenie.jpg',0,0,210,297);
}

//za rok
$pdf->Cell(190,46," ","$rmc1",1,"L");
$pdf->Cell(155,6," ","$rmc1",0,"C");$pdf->Cell(21,6,"$kli_vrok","$rmc",1,"C");

//druh hlasenia
$pdf->Cell(190,5," ","$rmc1",1,"L");
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->mz12 == 2 ) { $riadne=""; $opravne="x"; $dodatocne=""; }
if ( $hlavicka->mz12 == 3 ) { $riadne=""; $opravne=""; $dodatocne="x"; }
$pdf->Cell(47,6," ","$rmc1",0,"L");$pdf->Cell(9,6,"$riadne","$rmc",1,"C");
$pdf->Cell(47,5," ","$rmc1",0,"L");$pdf->Cell(9,5,"$opravne","$rmc",1,"C");
$pdf->Cell(47,5," ","$rmc1",0,"L");$pdf->Cell(9,5,"$dodatocne","$rmc",1,"C");

//zamestnavatel
$pdf->Cell(190,29," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(163,6,"$zamestnavatel","$rmc",1,"L");

//dic
$pdf->Cell(190,10," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(7,5,"$A","$rmc",0,"C");$pdf->Cell(7,5,"$B","$rmc",0,"C");$pdf->Cell(7,5,"$C","$rmc",0,"C");
$pdf->Cell(7,5,"$D","$rmc",0,"C");$pdf->Cell(7,5,"$E","$rmc",0,"C");$pdf->Cell(7,5,"$F","$rmc",0,"C");$pdf->Cell(7,5,"$G","$rmc",0,"C");
$pdf->Cell(8,5,"$H","$rmc",0,"C");$pdf->Cell(7,5,"$I","$rmc",0,"C");$pdf->Cell(7,5,"$J","$rmc",1,"C");

//sidlo
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(163,7,"$duli $dcdm","$rmc",1,"L");

//psc a obec
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(42,7,"$dpsc","$rmc",0,"L");$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(111,7,"$dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(42,6,"$xstat","$rmc",1,"L");

//datum vyhotovenia
$pdf->Cell(190,22," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->r07ad);
if ( $text == '00.00.0000' ) $text="";
$pdf->Cell(20,5," ","$rmc1",0,"L");$pdf->Cell(47,7,"$text","$rmc",1,"C");

$pdf->Output("../tmp/potvrdrocnehlasenie$kli_vxcf.$kli_uzid.pdf");
     }
//koniec potvrdenia o podani


if ( $drupoh == 1 ) { ?>
<script type="text/javascript"> var okno = window.open("../tmp/hlasenieDane.<?php echo $kli_uzid; ?>.pdf","_self"); </script>
<?php               }

if ( $drupoh == 2 ) { ?>
<script type="text/javascript"> var okno = window.open("../tmp/hlasenieDanepril.<?php echo $kli_uzid; ?>.pdf","_self"); </script>
<?php               }
/////////////////////////////////////////KONIEC VYTLACENIA HLASENIA, PRILOHY
}
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>

<?php
$cislista = include("mzd_lista_norm.php");
} while (false);
//celkovy koniec dokumentu
?>
</BODY>
</HTML>