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
$rmc=1;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/dan_zo_zavislej2016/mesacny_prehlad/prehlad_v16";
$jpg_popis="tlaËivo MesaËn˝ prehæad o odveden˝ch a zrazen˝ch preddavkoch pre rok ".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$mesiac=$kli_vmes;
$vyb_ump="1.".$kli_vrok; $vyb_umk=$kli_vmes.".".$kli_vrok;

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");

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
if( $strana == 0 ) { $strana=2; }

$h_ucetdan="";
$sqlttt = "SELECT dohod FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE dohod > 0 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_ucetdan=1*$riaddok->dohod;
  }


//nacitaj danovy bonus a zpr
if ( $copern == 2001 )
{
$stvrtrokdb=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $kli_vume  ";
$sqldok = mysql_query("$sqlttt");
if (@$zaznam=mysql_data_seek($sqldok,0))
{
$riaddok=mysql_fetch_object($sqldok);
$stvrtrokdb=1*$riaddok->vbon;
}

$umex1="1.".$kli_vrok; $umex2="2.".$kli_vrok; $umex3="3.".$kli_vrok; 
if ( $stvrtrokdb == 2 ) { $umex1="4.".$kli_vrok; $umex2="5.".$kli_vrok; $umex3="6.".$kli_vrok;  }
if ( $stvrtrokdb == 3 ) { $umex1="7.".$kli_vrok; $umex2="8.".$kli_vrok; $umex3="9.".$kli_vrok;  }
if ( $stvrtrokdb == 4 ) { $umex1="10.".$kli_vrok; $umex2="11.".$kli_vrok; $umex3="12.".$kli_vrok;  }

$db01=0; $db02=0; $db03=0; $zp01=0; $zp02=0; $zp03=0; 
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $umex1  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $db01=1*$riaddok->rc1a;
  $zp01=1*$riaddok->rf1a;
  }
//echo $sqlttt; echo $db01;  echo $zp01;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $umex2  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $db02=1*$riaddok->rc1a;
  $zp02=1*$riaddok->rf1a;
  }

//echo $sqlttt; echo $db02;  echo $zp02;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $umex3  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $db03=1*$riaddok->rc1a;
  $zp03=1*$riaddok->rf1a;
  }

//echo $sqlttt; echo $db03;  echo $zp03;

$lenbon = 1*$_REQUEST['lenbon'];
if( $lenbon == 1 )
  {
$sqlttt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET sbon=$db01+$db02+$db03 WHERE umex = $kli_vume  ";
$sqldok = mysql_query("$sqlttt");
  }

$lenzpr = 1*$_REQUEST['lenzpr'];
if( $lenzpr == 1 )
  {
$sqlttt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET szpr=$zp01+$zp02+$zp03 WHERE umex = $kli_vume  ";
$sqldok = mysql_query("$sqlttt");
  }

$copern=20;
}
//koniec nacitaj danovy bonus 


// nacitaj sumu a datum zrazenia a odvodu dane z prijmu
if ( $copern == 220 )
     {
$h_ucetdan = 1*$_REQUEST['h_ucetdan'];

$uhr1=$kli_vmes;
$kli_vyprok1=$kli_vrok;

//datum zrazenia
$duhr1=$kli_vyprok1."-".$uhr1."-".$fir_mzdx06;

//datum odvedenia
$uhr1=$kli_vmes+1;
$kli_vyprok1=$kli_vrok;

if ( $kli_vmes == 12 ) { $uhr1=1; $kli_vyprok1=$kli_vrok+1; }

$suma_dan1=0;
$datum_dan1="0000-00-00";

$den1=$kli_vyprok1."-".$uhr1."-01";
$den31=$kli_vyprok1."-".$uhr1."-31";


$sqlttt = "SELECT dat,F$kli_vxcf"."_uctban.hod FROM F$kli_vxcf"."_banvyp,F$kli_vxcf"."_uctban ".
" WHERE F$kli_vxcf"."_banvyp.dok=F$kli_vxcf"."_uctban.dok AND dat >= '$den1' AND dat <= '$den31' AND ucm = $h_ucetdan ";
//echo $sqlttt;
//exit;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $suma_dan1=$riaddok->hod;
  $datum_dan1=$riaddok->dat;
  }


$uprtxt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET dohod=$h_ucetdan "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET ".
" r08ad='$datum_dan1', r01ad='$duhr1', r08a='$suma_dan1' ".
" WHERE  umex = $kli_vume "; 
$upravene = mysql_query("$uprtxt");
$copern=20;
     }
//koniec znovu nacitaj


// znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $kli_vume";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
$druh = 1*$_REQUEST['druh'];
$dopr = strip_tags($_REQUEST['dopr']);
$dopr_sql = SqlDatum($dopr);
$dap = strip_tags($_REQUEST['dap']);
$dap_sql = SqlDatum($dap);

$r00a = strip_tags($_REQUEST['r00a']);
$r01a = strip_tags($_REQUEST['r01a']);
$r01ad = strip_tags($_REQUEST['r01ad']);
$r01ad_sql = SqlDatum($r01ad);
$r02a = strip_tags($_REQUEST['r02a']);
$r03a = strip_tags($_REQUEST['r03a']);
$r04a = strip_tags($_REQUEST['r04a']);
$r05a = strip_tags($_REQUEST['r05a']);
$r06a = strip_tags($_REQUEST['r06a']);
$r07a = strip_tags($_REQUEST['r07a']);
$r08a = strip_tags($_REQUEST['r08a']);
$r08ad = strip_tags($_REQUEST['r08ad']);
$r08ad_sql = SqlDatum($r08ad);

$ra1a = strip_tags($_REQUEST['ra1a']);
$rb1a = strip_tags($_REQUEST['rb1a']);
$rc1a = strip_tags($_REQUEST['rc1a']);
$rd1a = strip_tags($_REQUEST['rd1a']);
$re1a = strip_tags($_REQUEST['re1a']);
$rf1a = strip_tags($_REQUEST['rf1a']);

$zbon = strip_tags($_REQUEST['zbon']);
$pbon = strip_tags($_REQUEST['pbon']);
$ubon = strip_tags($_REQUEST['ubon']);
$sbon = strip_tags($_REQUEST['sbon']);
$vbon = strip_tags($_REQUEST['vbon']);

$zzpr = strip_tags($_REQUEST['zzpr']);
$pzpr = strip_tags($_REQUEST['pzpr']);
$uzpr = strip_tags($_REQUEST['uzpr']);
$szpr = strip_tags($_REQUEST['szpr']);
$rzpr = strip_tags($_REQUEST['rzpr']);

//$pzam = strip_tags($_REQUEST['pzam']);
//$pstr = strip_tags($_REQUEST['pstr']);
$uprav="NO";

if ( $strana == 1 ) {

$mpprie = strip_tags($_REQUEST['mpprie']);
$mpmeno = strip_tags($_REQUEST['mpmeno']);

$uprmp = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" mpprie='$mpprie', mpmeno='$mpmeno' ".
" WHERE kkx >= 0 ";
$upravmp = mysql_query("$uprmp");
                    }


if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET ".
" druh='$druh', dopr='$dopr_sql', dap='$dap_sql' ".
" WHERE umex = $kli_vume";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET ".
" r01ad='$r01ad_sql', r08ad='$r08ad_sql', ".
" ra1a='$ra1a', rb1a='$rb1a', rc1a='$rc1a', rd1a='$rd1a', re1a='$re1a', rf1a='$rf1a', ".
" r00a='$r00a', r01a='$r01a', r02a='$r02a', r03a='$r03a', r04a='$r04a', ".
" r05a='$r05a', r06a='$r06a', r07a='$r07a', r08a='$r08a', ".
" zbon='$zbon', pbon='$pbon', ubon='$ubon', sbon='$sbon', vbon='$vbon', ".
" zzpr='$zzpr', pzpr='$pzpr', uzpr='$uzpr', szpr='$szpr', rzpr='$rzpr' ".
" WHERE umex = $kli_vume";
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

//Osoba podava mesacny prehlad MZDY
$sql = "SELECT mpstat FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpprie VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpmeno VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mptitl VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mptitz VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mprdc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpdar DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpdic VARCHAR(15) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpnaz VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mppfr VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpuli VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpcdm VARCHAR(15) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mppsc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpmes VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mptel VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpfax VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD mpstat VARCHAR(30) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}
//koniec Osoba podava mesacny prehlad MZDY

$sql = "SELECT zamp FROM F$vyb_xcf"."_mzdmesacnyprehladdane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdmesacnyprehladdane';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdmesacnyprehladdaneoc';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   umex         DECIMAL(10,4) DEFAULT 0,
   r00a         DECIMAL(10,2) DEFAULT 0,
   r01a         DECIMAL(10,2) DEFAULT 0,
   r01ad        DATE,
   r02a         DECIMAL(10,2) DEFAULT 0,
   r03a         DECIMAL(10,2) DEFAULT 0,
   r04a         DECIMAL(10,2) DEFAULT 0,
   r05a         DECIMAL(10,2) DEFAULT 0,
   r06a         DECIMAL(10,2) DEFAULT 0,
   r07a         DECIMAL(10,2) DEFAULT 0,
   r08a         DECIMAL(10,2) DEFAULT 0,
   r08ad        DATE,
   ra1a         DECIMAL(10,2) DEFAULT 0,
   rb1a         DECIMAL(10,2) DEFAULT 0,
   rc1a         DECIMAL(10,2) DEFAULT 0,
   rd1a         DECIMAL(10,2) DEFAULT 0,
   re1a         DECIMAL(10,2) DEFAULT 0,
   rf1a         DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   zbon         DECIMAL(2,0) DEFAULT 0,
   pbon         DECIMAL(2,0) DEFAULT 0,
   ubon         DECIMAL(2,0) DEFAULT 0,
   sbon         DECIMAL(2,0) DEFAULT 0,
   vbon         DECIMAL(2,0) DEFAULT 0,
   zzpr         DECIMAL(2,0) DEFAULT 0,
   pzpr         DECIMAL(2,0) DEFAULT 0,
   uzpr         DECIMAL(2,0) DEFAULT 0,
   szpr         DECIMAL(2,0) DEFAULT 0,
   rzpr         DECIMAL(2,0) DEFAULT 0,
   pstr         DECIMAL(4,0) DEFAULT 0,
   pzam         DECIMAL(4,0) DEFAULT 0,
   dopr         DATE,
   konx1        DECIMAL(10,0) DEFAULT 0,
   dohod        DECIMAL(10,2) DEFAULT 0,
   socp         DECIMAL(10,2) DEFAULT 0,
   zdrp         DECIMAL(10,2) DEFAULT 0,
   nczd         DECIMAL(2,0) DEFAULT 0,
   rocz         DECIMAL(2,0) DEFAULT 0,
   bona         DECIMAL(2,0) DEFAULT 0,
   bonb         DECIMAL(2,0) DEFAULT 0,
   zamp         DECIMAL(2,0) DEFAULT 0,
   pdet         DECIMAL(2,0) DEFAULT 0
);
mzdprc;


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdmesacnyprehladdane'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane MODIFY sbon DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane MODIFY szpr DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane MODIFY bona DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane MODIFY bonb DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane MODIFY zamp DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdmesacnyprehladdaneoc SELECT * FROM F".$kli_vxcf."_mzdmesacnyprehladdane";
$vytvor = mysql_query("$vsql");
   }
//verzia 2014
$sql = "SELECT dap FROM F$vyb_xcf"."_mzdmesacnyprehladdane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane ADD druh DECIMAL(10,0) DEFAULT 0 AFTER pdet";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane ADD dap DATE AFTER pdet";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT dap FROM F$vyb_xcf"."_mzdmesacnyprehladdaneoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdaneoc ADD druh DECIMAL(10,0) DEFAULT 0 AFTER pdet";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdaneoc ADD dap DATE AFTER pdet";
$vysledek = mysql_query("$sql");
}
//verzia 2016
$sql = "SELECT ucet FROM F$vyb_xcf"."_mzdmesacnyprehladdane";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane ADD new2016 DECIMAL(2,0) DEFAULT 0 AFTER druh";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane ADD post DECIMAL(2,0) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmesacnyprehladdane ADD uce DECIMAL(2,0) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenia


$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdmesacnyprehladdane";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdmesacnyprehladdane";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");




$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $kli_vume";
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

$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid." ( oc,umex,konx  ) VALUES ( '$oc1', '$kli_vume', 1 )";
$ttqq = mysql_query("$ttvv");
//echo $ttvv;
//exit;

//zober data zo sum zaklad dane, preddavky, SP, ZP, odpoc NCZD v dohod
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,(zdan_dnp+pdan_zn1),odan_dnp,'0000-00-00',0,0,0,0,".
" 0,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" pdan_dnv,(ozam_np+ozam_sp+ozam_ip+ozam_pn),ozam_zp,0,0,0,0,0,0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcfmzdy"."_mzdzalsum ".
" WHERE ume = $kli_vume ".
"";
$dsql = mysql_query("$dsqlt");
//exit;

 
//zober z vy preplatok ZP 954 kc < 0 a pripocitaj k prijmu  NEVIEM ASI NIE ????
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,(-kc),0,'0000-00-00',0,0,0,0,".
" 0,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" 0,0,0,0,0,0,0,0,0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc > 0 AND dm = 954 AND kc < 0 AND ume = $kli_vume ".
"";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");


//uvidim co s nedoplatkom 954 kc > 0


//zober data z vy 903 RZ
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,0,0,'0000-00-00',kc,0,0,0,".
" 0,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" 0,0,0,0,0,0,0,0,0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE oc > 0 AND dm = 903 AND ume = $kli_vume ".
"";

$dsql = mysql_query("$dsqlt");



//zober data z vy 902 Bonus mesacny
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,0,0,'0000-00-00',0,0,0,kc,".
" 0,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" 0,0,0,0,0,(-kc),0,0,0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE oc > 0 AND dm = 902 AND ume = $kli_vume ".
"";

$dsql = mysql_query("$dsqlt");

//zober data z vy 952 Bonus z RZ
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,0,0,'0000-00-00',0,0,0,kc,".
" 0,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" 0,0,0,0,0,(-kc),(-kc),0,0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE oc > 0 AND dm = 952 AND ume = $kli_vume ".
"";

$dsql = mysql_query("$dsqlt");

//zober data z vy 953 Zam premia
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,ume,0,0,'0000-00-00',0,0,0,0,".
" kc,0,0,'0000-00-00', ".
" 0,0,0,0,0,0,".
" 1,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" 0,0,0,0,0,0,0,(-kc),0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcfmzdy"."_mzdzalvy".
" WHERE oc > 0 AND dm = 953 AND ume = $kli_vume ".
"";

$dsql = mysql_query("$dsqlt");


//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,umex,SUM(r00a),SUM(r01a),r01ad,SUM(r02a),SUM(r03a),SUM(r04a),SUM(r05a),".
" SUM(r06a),SUM(r07a),SUM(r08a),'0000-00-00', ".
" 0,0,0,0,0,0,".
" 0,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,0,'0000-00-00', ".
" 0, ".
" SUM(dohod),SUM(socp),SUM(zdrp),0,0,SUM(bona),SUM(bonb),SUM(zamp),0,'',0, ".
" 0,0,0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc > 0 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 1";
$oznac = mysql_query("$sqtoz");

//v dohod mam odpoc.polozku NCZD ak > 0 nczd=1
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET nczd=1 WHERE dohod > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET dohod=0 ";
$oznac = mysql_query("$sqtoz");

//pomer na dohodu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdzalkun".
" SET pdet=pom ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc=F$kli_vxcf"."_mzdzalkun.oc AND ume = $kli_vume ";
$oznac = mysql_query("$sqtoz");
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdpomer SET dohod=r00a ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.pdet = F$kli_vxcf"."_mzdpomer.pm AND pm_doh = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET pdet=0 ";
$oznac = mysql_query("$sqtoz");

//nastav pocet deti na bonus
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdzalkun".
" SET pdet=deti_dn ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc=F$kli_vxcf"."_mzdzalkun.oc AND ume = $kli_vume ";
$oznac = mysql_query("$sqtoz");

//rocne zuctovanie ano
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET rocz=1 WHERE r02a != 0 ";
$oznac = mysql_query("$sqtoz");


//uloz do mzdhlasenieDaneoc
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdmesacnyprehladdaneoc WHERE umex = $kli_vume ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmesacnyprehladdaneoc".
" SELECT oc,umex,SUM(r00a),SUM(r01a),r01ad,SUM(r02a),SUM(r03a),SUM(r04a),SUM(r05a),".
" SUM(r06a),SUM(r07a),SUM(r08a),'0000-00-00', ".
" 0,0,0,0,0,0,".
" 0,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,1,'0000-00-00', ".
" 0, ".
" dohod,SUM(socp),SUM(zdrp),nczd,rocz,SUM(bona),SUM(bonb),SUM(zamp),pdet,'',0 ".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//uloz do mzdhlasenieDane
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE umex = $kli_vume";
$oznac = mysql_query("$sqtoz");

$datumx=SqlDatum($h_dap);

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmesacnyprehladdane".
" SELECT oc,umex,SUM(r00a),SUM(r01a),r01ad,SUM(r02a),SUM(r03a),SUM(r04a),SUM(r05a),".
" SUM(r06a),SUM(r07a),SUM(r08a),'0000-00-00', ".
" 0,0,0,0,0,0,".
" 0,".
" 0,0,0,0,0, ".
" 0,0,0,0,0, ".
" 0,SUM(pzam),'0000-00-00', ".
" 0, ".
" 0,SUM(socp),SUM(zdrp),0,0,SUM(bona),SUM(bonb),SUM(zamp),0,'$datumx','$h_drp', ".
" 0,0,0 ".
" FROM F$kli_vxcf"."_mzdmesacnyprehladdaneoc WHERE umex = $kli_vume ".
" GROUP BY konx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET pstr=(pzam/4+0.49) WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r04a=r01a+r02a+r03a WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r04a=0, r02a=-r01a, r03a=0 WHERE umex = $kli_vume AND r04a < 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r07a=r04a+r05a+r06a WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET ra1a=-r05a, rd1a=-r06a WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//rozdelenie bonusu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET rb1a=ra1a, rc1a=0  WHERE ra1a <= r04a AND umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET rb1a=r04a, rc1a=ra1a-rb1a  WHERE ra1a > r04a AND umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//rozdelenie zam.premie
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET socp=r04a-rb1a  WHERE umex = $kli_vume";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET socp=0  WHERE socp < 0 AND umex = $kli_vume";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET re1a=rd1a, rf1a=0  WHERE rd1a <= socp AND umex = $kli_vume ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET re1a=socp, rf1a=rd1a-re1a  WHERE rd1a > socp AND umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET socp=0  WHERE umex = $kli_vume";
$oznac = mysql_query("$sqtoz");

//ak je zaporna odvodova vynuluj
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r07a=0, r05a=-rb1a, r06a=-re1a WHERE r07a < 0 AND umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//na konci stvrtroka 3,6,9,12 spocitaj rozdiel DB a ZPR a uplatni vyrovnanie TOTO SOM ZRUSIL MUSI NAPOCITAT UZIVATEL
$nerobtoto=1;
if ( $nerobtoto == 0 AND ( $kli_vmes == 3 OR $kli_vmes == 6 OR $kli_vmes == 9 OR $kli_vmes == 12 ) )
     {
if ( $kli_vmes ==  3 ) { $podmume=" umex >= 1.".$kli_vrok." AND umex <= 3.".$kli_vrok." "; $strtrokx=1; }
if ( $kli_vmes ==  6 ) { $podmume=" umex >= 4.".$kli_vrok." AND umex <= 6.".$kli_vrok." "; $strtrokx=2; }
if ( $kli_vmes ==  9 ) { $podmume=" umex >= 7.".$kli_vrok." AND umex <= 9.".$kli_vrok." "; $strtrokx=3; }
if ( $kli_vmes == 12 ) { $podmume=" umex >= 10.".$kli_vrok." AND umex <= 12.".$kli_vrok." "; $strtrokx=4; }
$sqlttt = "SELECT SUM(rc1a) AS sumrc1a, SUM(rf1a) AS sumrf1a  FROM F$kli_vxcf"."_mzdmesacnyprehladdane WHERE $podmume GROUP BY oc ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sumrc1a=1*$riaddok->sumrc1a;
  $sumrf1a=1*$riaddok->sumrf1a;
  }
$rzpr=$kli_vrok-2001;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET sbon='$sumrc1a', ubon=1, zbon=1, vbon='$strtrokx'  WHERE umex = $kli_vume";
if( $sumrc1a > 0 ) { $oznac = mysql_query("$sqtoz"); }
//echo $sqtoz;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET szpr='$sumrf1a', uzpr=1, zzpr=1, rzpr='$rzpr'  WHERE umex = $kli_vume";
if( $sumrf1a > 0 ) { $oznac = mysql_query("$sqtoz"); }
//echo $sqtoz;
     }

}
//koniec pracovneho suboru pre potvrdenie 



//vypocitaj riadky

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r04a=r01a+r02a+r03a WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r04a=0 WHERE umex = $kli_vume AND r04a < 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r07a=r04a+r05a+r06a WHERE umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak je zaporna odvodova vynuluj
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmesacnyprehladdane SET r07a=0, r05a=-rb1a, r06a=-re1a WHERE r07a < 0 AND umex = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//koniec vypocitaj riadky


//nacitaj udaje pre upravu
if ( $copern == 20 OR $copern == 10 )
     {
$sqlmp = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE kkx >= 0 ";
$fir_mp = mysql_query($sqlmp);
$fir_rmp=mysql_fetch_object($fir_mp);
$mpprie = $fir_rmp->mpprie;
$mpmeno = $fir_rmp->mpmeno;

//echo $mpprie;


$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane".
" WHERE umex = $kli_vume";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$oc = $fir_riadok->oc;
$ume = $fir_riadok->umex;

$druh = $fir_riadok->druh;
$dopr_sk = SkDatum($fir_riadok->dopr);
$dap_sk = SkDatum($fir_riadok->dap);
$zrobil = $fir_mzdt05;
if ( $fir_mzdt05='' ) $zrobil=$kli_uzmeno." ".$kli_uzprie;

$r00a = $fir_riadok->r00a;
$r01a = $fir_riadok->r01a;
//$r01ad = $fir_riadok->r01ad;
$r02a = $fir_riadok->r02a;
$r03a = $fir_riadok->r03a;
$r04a = $fir_riadok->r04a;
$r05a = $fir_riadok->r05a;
$r06a = $fir_riadok->r06a;
$r07a = $fir_riadok->r07a;
$r08a = $fir_riadok->r08a;
//$r08ad = $fir_riadok->r08ad;

$ra1a = $fir_riadok->ra1a;
$rb1a = $fir_riadok->rb1a;
$rc1a = $fir_riadok->rc1a;
$rd1a = $fir_riadok->rd1a;
$re1a = $fir_riadok->re1a;
$rf1a = $fir_riadok->rf1a;

$zbon = $fir_riadok->zbon;
$pbon = $fir_riadok->pbon;
$ubon = $fir_riadok->ubon;
$sbon = $fir_riadok->sbon;
$vbon = $fir_riadok->vbon;

$zzpr = $fir_riadok->zzpr;
$pzpr = $fir_riadok->pzpr;
$uzpr = $fir_riadok->uzpr;
$szpr = $fir_riadok->szpr;
$rzpr = $fir_riadok->rzpr;

$r01ad_sk = SkDatum($fir_riadok->r01ad);
$r08ad_sk = SkDatum($fir_riadok->r08ad);
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//FO-Priezvisko,Meno,Titul a trvaly pobyt z ufirdalsie
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
if ( $kli_vrok >= 2014 )
   {
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$dprie = $riadokc->dprie;
$dmeno = $riadokc->dmeno;
$dtitl = $riadokc->dtitl;
$dtitz = $riadokc->dtitz;
$duli = $riadokc->duli;
$dcdm = $riadokc->dcdm;
$dpsc = $riadokc->dpsc;
$dmes = $riadokc->dmes;
$dstat = $riadokc->dstat; //dopyt, otestovaù
$dtel = $riadokc->dtel;
//$dfax = $riadokc->dfax;
     }
   }
}
if ( $fir_uctt03 != 999 )
{
$dmeno=""; $dprie=""; $dtitl=""; $dtitz="";
$duli=$fir_fuli; $dcdm=$fir_fcdm; $dmes=$fir_fmes; $dpsc=$fir_fpsc;
$dtel=$fir_ftel; $dfax=$fir_ffax; $dstat="Slovensko";
}
$fir_uctt03tlac=$fir_uctt03;
if ( $fir_uctt03 == 999 )
{
$fir_fnaz=""; $fir_uctt03tlac="";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Prehæad dane mesaËn˝</title>
<style type="text/css">
span.text-echo {
  font-size: 20px;
  letter-spacing: 12px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form.odved-area { /* dopyt, preveriù */
  display: none;
  position: absolute;
  top: 565px;
  right: 6px;
}
form.odved-area > img {
  position: relative;
  top: 2px;
  left: 262px;
  width: 18px;
  height: 18px;
  background-color: lightblue;
  padding: 5px 5px 0 5px;
  cursor: pointer;
}
table.odved-box {
  width: 290px;
  font-size: 13px;
}
table.odved-box td {
  height: 26px;
  line-height: 26px;
  background-color: lightblue;
}
table.odved-box td > input {
  width: 65px;
  height: 18px;
  line-height: 18px;
  margin-top: 3px;
  margin-left: 5px;
  font-size: 13px;
}
div.content-xml { /* dopyt, preveriù */
  position: relative;
  width: 950px;
  height: 100px;
  margin: 20px auto;
  background-color:white;
  font-size:15px;
}
div.content-xml > p {
  margin: 0 20px;
  padding: 15px 0;
}
div.content-xml > a {
  display: block;
  margin: 20px 20px 10px 20px;
}
div.content-xml > a:hover { text-decoration: underline; }
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
   document.formv1.dopr.value = '<?php echo "$dopr_sk";?>';
   document.formv1.dap.value = '<?php echo "$dap_sk";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.r00a.value = '<?php echo "$r00a";?>';
   document.formv1.r01a.value = '<?php echo "$r01a";?>';
   document.formv1.r01ad.value = '<?php echo "$r01ad_sk";?>';
   document.formv1.r02a.value = '<?php echo "$r02a";?>';
   document.formv1.r03a.value = '<?php echo "$r03a";?>';
//   document.formv1.r04a.value = '<?php echo "$r04a";?>';
   document.formv1.r05a.value = '<?php echo "$r05a";?>';
   document.formv1.r06a.value = '<?php echo "$r06a";?>';
//   document.formv1.r07a.value = '<?php echo "$r07a";?>';
   document.formv1.r08a.value = '<?php echo "$r08a";?>';
   document.formv1.r08ad.value = '<?php echo "$r08ad_sk";?>';
   document.formv1.ra1a.value = '<?php echo "$ra1a";?>';
   document.formv1.rb1a.value = '<?php echo "$rb1a";?>';
   document.formv1.rc1a.value = '<?php echo "$rc1a";?>';
   document.formv1.rd1a.value = '<?php echo "$rd1a";?>';
   document.formv1.re1a.value = '<?php echo "$re1a";?>';
   document.formv1.rf1a.value = '<?php echo "$rf1a";?>';
   document.formv1.vbon.value = '<?php echo "$vbon";?>';
   document.formv1.rzpr.value = '<?php echo "$rzpr";?>';
   document.formv1.sbon.value = '<?php echo "$sbon";?>';
   document.formv1.szpr.value = '<?php echo "$szpr";?>';
 //document.formv1.pstr.value = '<?php echo "$pstr";?>';
 //document.formv1.pzam.value = '<?php echo "$pzam";?>';
<?php if ( $zbon == 1 ) { ?> document.formv1.zbon.checked = "checked"; <?php } ?>
<?php if ( $pbon == 1 ) { ?> document.formv1.pbon.checked = "checked"; <?php } ?>
<?php if ( $ubon == 1 ) { ?> document.formv1.ubon.checked = "checked"; <?php } ?>
<?php if ( $zzpr == 1 ) { ?> document.formv1.zzpr.checked = "checked"; <?php } ?>
<?php if ( $pzpr == 1 ) { ?> document.formv1.pzpr.checked = "checked"; <?php } ?>
<?php if ( $uzpr == 1 ) { ?> document.formv1.uzpr.checked = "checked"; <?php } ?>
<?php                                        } ?>
  }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 20 )
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
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2016/dan_zo_zavislej2016/mesacny_prehlad/prehlad_v16_poucenie.pdf', '_blank');
  }
  function OdvodDane()
  { 
   var h_ucetdan = document.forms.fkoef.h_ucetdan.value;
   window.open('../mzdy/prehladdane_mesacny2016.php?copern=220&cislo_oc=<?php echo $cislo_oc; ?>&h_ucetdan=' + h_ucetdan + '&drupoh=1&uprav=1', '_self');
  }
  function CitajMzlist()
  { 
   window.open('../mzdy/prehladdane_mesacny2016.php?h_drp=<?php echo $h_drp; ?>&h_dap=<?php echo $h_dap; ?>&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>', '_self');
  }
  function TlacPrehlad(strana)
  {
   window.open('../mzdy/prehladdane_mesacny2016.php?h_drp=1&h_dap=<?php echo $h_dap; ?>&copern=10&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>&strana=' + strana + '&tt=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravFO()
  {
   window.open('../cis/ufirdalsie.php?copern=402', '_blank');
  }
  function NacitajDanBonus()
  {
   window.open('../mzdy/prehladdane_mesacny2016.php?copern=2001&drupoh=1&page=1&subor=0&lenbon=1', '_self');
  }
  function NacitajZamPremia()
  {
   window.open('../mzdy/prehladdane_mesacny2016.php?copern=2001&drupoh=1&page=1&subor=0&lenzpr=1', '_self');
  }
  function XMLPrehlad()
  {
   window.open('../mzdy/prehladdane_mesacny2016.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">mesaËn˝ Prehæad o preddavkoch na daÚ</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">

    <img src="../obr/ikony/upbox_blue_icon.png" onclick="XMLPrehlad();" title="Export do XML" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="CitajMzlist();"
     title="NaËÌtaù ˙daje z MZDOV›CH LISTOV" style="top:235px; left:388px;" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacPrehlad(9999);"
     title="Zobraziù v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="prehladdane_mesacny2016.php?copern=23&drupoh=1
 &cislo_oc=1&fmzdy=<?php echo $kli_vxcfmzdy; ?>&h_dap=<?php echo $h_dap; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="prehladdane_mesacny2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="TlacPrehlad(2);" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="TlacPrehlad(1);" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 283kB">
<?php
$kli_vrokx = substr($kli_vrok,2,2);
$mesiacx=$mesiac; if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
?>
<!-- danove -->
<span class="text-echo" style="top:314px; left:56px;"><?php echo $fir_fdic; ?></span>
<span class="text-echo" style="top:367px; left:56px; letter-spacing:0;"><?php echo $fir_uctt01; ?></span>
<!-- Druh prehladu -->
<input type="radio" id="druh1" name="druh" value="1" style="top:318px; left:419px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:346px; left:419px;"/>
<!-- obdobia -->
<span class="text-echo" style="top:299px; left:711px;"><?php echo $mesiacx; ?></span>
<span class="text-echo" style="top:299px; left:855px;"><?php echo $kli_vrokx; ?></span>
<input type="text" name="dopr" id="dopr" onkeyup="CiarkaNaBodku(this);"
       style="width:195px; top:360px; left:628px;"/>

<!-- FO -->
<img src="../obr/ikony/pencil_blue_icon.png" title="Upraviù ˙daje FO"
 onclick="UpravFO();" class="btn-row-tool" style="top:423px; left:130px;">
<div class="input-echo" style="width:360px; top:447px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:245px; top:447px; left:431px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:113px; top:447px; left:695px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:68px; top:447px; left:827px;"><?php echo $dtitz; ?></div>
<!-- PO -->
<div class="input-echo" style="width:727px; top:519px; left:52px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:60px; top:519px; left:822px;"><?php echo $fir_uctt03tlac; ?></div> <!-- dopyt, netlaËiù, keÔ bude fo -->
<!-- Sidlo PO alebo pobyt FO -->
<div class="input-echo" style="width:635px; top:593px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:174px; top:593px; left:720px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:106px; top:649px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:452px; top:649px; left:178px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:649px; left:649px;"><?php echo $dstat; ?></div> <!-- dopyt, rozbehaù -->

<!-- Podava -->
<!-- dopyt, vöetko novÈ -->



<!-- tel a email -->
<div class="input-echo" style="width:290px; top:1017px; left:52px;"><?php echo $dtel; ?></div>
<div class="input-echo" style="width:520px; top:1017px; left:374px;"><?php echo $fir_fem1; ?></div>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 260kB">
<span class="text-echo" style="top:75px; left:390px;"><?php echo $fir_fdic; ?></span>

<!-- I.cast -->
<input type="text" name="r00a" id="r00a" onkeyup="CiarkaNaBodku(this);"
       style="width:255px; top:163px; left:638px;"/>
<input type="text" name="r01ad" id="r01ad" onkeyup="CiarkaNaBodku(this);"
       style="width:198px; top:211px; left:442px;"/>
<input type="text" name="r01a" id="r01a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:211px; left:661px;"/>
<input type="text" name="r02a" id="r02a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:255px; left:661px;"/>
<input type="text" name="r03a" id="r03a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:300px; left:661px;"/>
<div class="input-echo right" style="width:233px; top:345px; left:661px;"><?php echo $r04a; ?>&nbsp;</div>
<input type="text" name="r05a" id="r05a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:397px; left:661px;"/>
<input type="text" name="r06a" id="r06a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:459px; left:661px;"/>
<div class="input-echo right" style="width:233px; top:512px; left:661px;"><?php echo $r07a; ?>&nbsp;</div>
<input type="text" name="r08ad" id="r08ad" onkeyup="CiarkaNaBodku(this);"
       style="width:198px; top:556px; left:442px;"/>
<input type="text" name="r08a" id="r08a" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:556px; left:661px;"/>
<img src="../obr/ikony/downbox_blue_icon.png" title="Preniesù z ˙ËtovnÌctva"
     onclick="odvedarea.style.display='block';" class="btn-row-tool"
     style="width:25px; height:25px; top:558px; right:13px;">

<!-- II.cast -->
<input type="text" name="ra1a" id="ra1a" onkeyup="CiarkaNaBodku(this);"
       style="width:186px; top:657px; left:708px;"/>
<input type="text" name="rb1a" id="rb1a" onkeyup="CiarkaNaBodku(this);"
       style="width:208px; top:697px; left:686px;"/>
<input type="text" name="rc1a" id="rc1a" onkeyup="CiarkaNaBodku(this);"
       style="width:208px; top:737px; left:686px;"/>
<input type="text" name="rd1a" id="rd1a" onkeyup="CiarkaNaBodku(this);"
       style="width:186px; top:778px; left:708px;"/>
<input type="text" name="re1a" id="re1a" onkeyup="CiarkaNaBodku(this);"
       style="width:208px; top:818px; left:686px;"/>
<input type="text" name="rf1a" id="rf1a" onkeyup="CiarkaNaBodku(this);"
       style="width:208px; top:857px; left:686px;"/>

<!-- III.cast -->
<input type="checkbox" name="zbon" value="1" style="top:944px; left:59px;"/>
<input type="text" name="sbon" id="sbon" onkeyup="CiarkaNaBodku(this);"
       style="width:186px; top:940px; left:702px;"/>
<input type="checkbox" name="zzpr" value="1" style="top:982px; left:59px;"/>
<input type="text" name="szpr" id="szpr" onkeyup="CiarkaNaBodku(this);"
       style="width:186px; top:979px; left:702px;"/>

<input type="text" name="vbon" id="vbon" style="width:15px; top:995px; left:852px;"/>
<script>
  function klikpbon()
  {
   document.formv1.ubon.checked = false;
  }
  function klikubon()
  {
   document.formv1.pbon.checked = false;
  }
</script>
<input type="checkbox" name="pbon" onchange="klikpbon();" value="1" style="top:1034px; left:49px;"/>
<input type="checkbox" name="ubon" onchange="klikubon();" value="1" style="top:1062px; left:49px;"/>
<img src="../obr/ikony/download_blue_icon.png" onclick="NacitajDanBonus();"
 title="NaËÌtaù daÚov˝ bonus vyplaten˝ z prostriedkov zamestnanca ( II.Ëasù riadok C ) z prehæadov za <?php echo $vbon; ?>.ötvrùrok"
 style="top:1028px; left:220px;" class="btn-row-tool">

<img src="../obr/ikony/info_blue_icon.png" title="Firemn˝ ˙Ëet Ë. 1"
 class="btn-row-tool" style="top:1030px; left:467px; cursor:default;">
<span class="text-echo" style="top:1056px; left:403px; letter-spacing:12.3px;"><?php echo $fir_fuc1; ?></span>
<span class="text-echo" style="top:1056px; left:809px; letter-spacing:12.3px;"><?php echo $fir_fnm1; ?></span>

<!-- IV. cast -->

<input type="text" name="rzpr" id="rzpr" maxlength="2"
 style="width:37px; top:1141px; left:725px;"/>
<script>
  function klikpzpr()
  {
   document.formv1.uzpr.checked = false;
  }
  function klikuzpr()
  {
   document.formv1.pzpr.checked = false;
  }
</script>
<input type="checkbox" name="pzpr" onchange="klikpzpr();" value="1" style="top:1172px; left:49px;"/>
<input type="checkbox" name="uzpr" onchange="klikuzpr();" value="1" style="top:1200px; left:49px;"/>
<img src="../obr/ikony/download_blue_icon.png" onclick="NacitajZamPremia();"
 title="NaËÌtaù zamestnaneck˙ prÈmiu za rok 20<?php echo $rzpr; ?> vyplaten˙ z prostriedkov zamestnanca ( II.Ëasù riadok F ) z prehæadov za <?php echo $vbon; ?>.ötvrùrok"
  style="top:1167px; left:220px;" class="btn-row-tool">

<img src="../obr/ikony/info_blue_icon.png" title="Firemn˝ ˙Ëet Ë. 1"
 class="btn-row-tool" style="top:1168px; left:467px; cursor:default;">
<span class="text-echo" style="top:1195px; left:403px; letter-spacing:12.3px;"><?php echo $fir_fuc1; ?></span>
<span class="text-echo" style="top:1195px; left:809px; letter-spacing:12.3px;"><?php echo $fir_fnm1; ?></span>

<!-- Vypracoval -->
<!-- <span class="text-echo" style="top:865px; left:47px; letter-spacing:0;"><?php echo $zrobil; ?></span> -->
<?php
$pole = explode("/", $fir_mzdt04);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
?>
<!-- <span class="text-echo" style="top:935px; left:71px;"><?php echo $tel_pred; ?></span> -->
<!-- <span class="text-echo" style="top:935px; left:167px;"><?php echo $tel_za; ?></span> -->
<!--
 <input type="text" name="dap" id="dap" onkeyup="CiarkaNaBodku(this);"
 style="width:204px; top:979px; left:43px;"/>
-->

<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave"
  style="top:0px;">
</div>
</FORM>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<FORM name='fkoef' id="odvedarea" method='post' action='#' class="odved-area"> <!-- dopyt, Ëo je toto? -->
 <img src="../obr/ikony/turnoff_blue_icon.png" title="Zavrieù"
  onclick="odvedarea.style.display='none';">
 <table class="odved-box">
 <tr>
  <td style="width:190px;">&nbsp;
   Z ˙Ëtu<input type='text' name='h_ucetdan' id='h_ucetdan' value='<?php echo $h_ucetdan; ?>'
          maxlenght='6'>
  </td>
  <td style="width:100px; font-size:11px;">(napr. 34210)</td>
 </tr>
 <tr>
  <td colspan="2" align="center">
   <a href="#" onclick="OdvodDane();">naËÌtaù d·tum a sumu zrazen˝ch preddavkov</a>
  </td>
 </tr>
 </table>
</FORM>
<?php                                        } ?>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC PREHLAD,POTVRDENIE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/mesprehdane.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/mesprehdane.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//formular prehlad
if ( $drupoh == 1 )
     {
//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane".
" WHERE umex = $kli_vume ORDER BY konx";

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

if ( File_Exists('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/PREHLADv13_v1_4-1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/PREHLADv13_v1_4-1.jpg',7,6,198,285);
}

//dic
$pdf->Cell(190,60,"","$rmc1",1,"L");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//danovy urad
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(70,6,"$fir_uctt01","$rmc",1,"L");

//druh prehladu
$druh=$hlavicka->druh;
$riadne="x"; $opravne="";
if ( $druh == 2 ) { $riadne=""; $opravne="x"; }
$pdf->SetY(72);
$pdf->Cell(86,5," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadne","$rmc",1,"C");
$pdf->SetY(78);
$pdf->Cell(86,5," ","$rmc1",0,"C");$pdf->Cell(3,4,"$opravne","$rmc",1,"C");

//zdanovacie obdobie
$kli_vmesx=1*$kli_vmes;
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$A=substr($kli_vmesx,0,1);
$B=substr($kli_vmesx,1,1);
$C1=substr($kli_vrok,2,1);
$D1=substr($kli_vrok,3,1);
$pdf->SetY(67);
$pdf->Cell(149,58," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(23,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",1,"L");

//datum opravne
$text="";
if ( $hlavicka->druh == 2 ) $text=SkDatum($hlavicka->dopr);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->SetY(82);
$pdf->Cell(132,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//FO
//priezvisko FO
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
$pdf->Cell(190,16,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//meno FO
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
//tituly FO
$A=substr($dtitl,0,1);
$B=substr($dtitl,1,1);
$C=substr($dtitl,2,1);
$D=substr($dtitl,3,1);
$E=substr($dtitl,4,1);
$F=substr($dtitl,5,1);
$G=substr($dtitl,6,1);
$H=substr($dtitl,7,1);
$I=substr($dtitl,8,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//PO
//nazov PO
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
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
//pravna forma PO
$Apf=substr($fir_uctt03tlac,0,1);
$Bpf=substr($fir_uctt03tlac,1,1);
$Cpf=substr($fir_uctt03tlac,2,1);
$pdf->Cell(8,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$Apf","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Bpf","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Cpf","$rmc",1,"C");

//Sidlo(PO) alebo Pobyt(FO)
//ulica
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
$pdf->Cell(190,15,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$A=substr($dcdm,0,1);
$B=substr($dcdm,1,1);
$C=substr($dcdm,2,1);
$D=substr($dcdm,3,1);
$E=substr($dcdm,4,1);
$F=substr($dcdm,5,1);
$G=substr($dcdm,6,1);
$H=substr($dcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$dpsc=str_replace(" ","",$dpsc);
$A=substr($dpsc,0,1);
$B=substr($dpsc,1,1);
$C=substr($dpsc,2,1);
$D=substr($dpsc,3,1);
$E=substr($dpsc,4,1);
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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
$V=substr($dmes,20,1);
$W=substr($dmes,21,1);
$X=substr($dmes,22,1);
$Y=substr($dmes,23,1);
$Z=substr($dmes,24,1);
$A1=substr($dmes,25,1);
$B1=substr($dmes,26,1);
$C1=substr($dmes,27,1);
$D1=substr($dmes,28,1);
$E1=substr($dmes,29,1);
$F1=substr($dmes,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");
//telefon
$pole = explode("/", $dtel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
$A=substr($tel_pred,0,1);
$B=substr($tel_pred,1,1);
$C=substr($tel_pred,2,1);
$pdf->Cell(190,6,"","$rmc1",1,"L");
$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$A=substr($tel_za,0,1);
$B=substr($tel_za,1,1);
$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);
$E=substr($tel_za,4,1);
$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);
$H=substr($tel_za,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
//fax
$pole = explode("/", $dfax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
$A=substr($fax_pred,0,1);
$B=substr($fax_pred,1,1);
$C=substr($fax_pred,2,1);
$pdf->Cell(11,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$A=substr($fax_za,0,1);
$B=substr($fax_za,1,1);
$C=substr($fax_za,2,1);
$D=substr($fax_za,3,1);
$E=substr($fax_za,4,1);
$F=substr($fax_za,5,1);
$G=substr($fax_za,6,1);
$H=substr($fax_za,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");

//vyhotovil
$pdf->Cell(190,11,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(78,6,"$zrobil","$rmc",1,"L");
//telefon
$pole = explode("/", $fir_mzdt04);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
$A=substr($tel_pred,0,1);
$B=substr($tel_pred,1,1);
$C=substr($tel_pred,2,1);
$pdf->Cell(190,11," ","$rmc1",1,"C");
$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$A=substr($tel_za,0,1);
$B=substr($tel_za,1,1);
$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);
$E=substr($tel_za,4,1);
$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);
$H=substr($tel_za,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//datum
$pdf->Cell(190,5,"","$rmc1",1,"L");
$text=SkDatum($hlavicka->dap);
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(12);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/PREHLADv13_v1_4-2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/PREHLADv13_v1_4-2.jpg',8,7,202,284);
}

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
$pdf->Cell(190,1,"","$rmc1",1,"L");
$pdf->Cell(74,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//I.CAST
//riadok 0
$tlachod_c=100*$hlavicka->r00a;
if ( $tlachod_c == 0 ) $tlachod_c="";
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
$pdf->Cell(190,16,"","$rmc1",1,"L");
$pdf->Cell(129,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//riadok 1
$pdf->Cell(190,5,"","$rmc1",1,"L");
$tlachod=SkDatum($hlavicka->r01ad);
if ( $tlachod == '00.00.0000' ) $tlachod="";
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
$pdf->Cell(86,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
//
$tlachod_c=100*$hlavicka->r01a;
if ( $tlachod_c == 0 ) $tlachod_c="";
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//riadok 2
$tlachod_c=100*$hlavicka->r02a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(134,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 3
$tlachod_c=100*$hlavicka->r03a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(134,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 4
$tlachod_c=100*$hlavicka->r04a;
if ( $tlachod_c == 0 ) $tlachod_c="";
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 5
$tlachod_c=100*$hlavicka->r05a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
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
$pdf->Cell(190,6,"","$rmc1",1,"L");
$pdf->Cell(134,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 6
$tlachod_c=100*$hlavicka->r06a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
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
$pdf->Cell(190,8,"","$rmc1",1,"L");
$pdf->Cell(134,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 7
$tlachod_c=100*$hlavicka->r07a;
if ( $tlachod_c == 0 ) $tlachod_c="";
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//riadok 8
$tlachod=SkDatum($hlavicka->r08ad);
if ( $tlachod == '00.00.0000' ) $tlachod="";
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
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(86,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
//
$tlachod_c=100*$hlavicka->r08a;
if ( $tlachod_c == 0 ) $tlachod_c="";
if ( $tlachod_c < 10 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
if ( $tlachod_c < 100 AND $tlachod_c != 0 ) { $tlachod_c="0".$tlachod_c; }
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//II.CAST
//riadok A
$tlachod_c=100*$hlavicka->ra1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,19,"","$rmc1",1,"L");
$pdf->Cell(144,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//riadok B
$tlachod_c=100*$hlavicka->rb1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//riadok C
$tlachod_c=100*$hlavicka->rc1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//riadok D
$tlachod_c=100*$hlavicka->rd1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(144,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//riadok E
$tlachod_c=100*$hlavicka->re1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//riadok F
$tlachod_c=100*$hlavicka->rf1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
$znamienko="";
if ( $tlachod_c < 0 ) { $tlachod_c=str_replace("-","",$tlachod_c); $znamienko="-"; }
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"R");$pdf->Cell(4,7,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");

//III.CAST
//ziadame bonus
$krizikbonus1="x";
$krizikbonus2="x";
$krizikbonus3="x";
if ( $hlavicka->zbon == 0 ) { $krizikbonus1=" "; }
if ( $hlavicka->pbon == 0 OR $hlavicka->zbon == 0 ) { $krizikbonus2=" "; }
if ( $hlavicka->ubon == 0 OR $hlavicka->zbon == 0 ) { $krizikbonus3=" "; }
$pdf->Cell(190,16,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizikbonus1","$rmc",1,"C");
$pdf->Cell(190,5,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,4,"$krizikbonus2","$rmc",1,"C");
$pdf->Cell(190,3,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizikbonus3","$rmc",1,"C");
//stvrtrok bonus
$tlachod_c=$hlavicka->vbon;
if ( $tlachod_c == 0 OR $hlavicka->zbon == 0 ) $tlachod_c="";
$pdf->SetY(220);
$pdf->SetX(188);
$pdf->Cell(4,6,"$tlachod_c","$rmc",1,"C");
//suma bonus
$tlachod_c=100*$hlavicka->sbon;
if ( $tlachod_c == 0 OR $hlavicka->zbon == 0 ) $tlachod_c="";
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,7,"","$rmc1",1,"C");
$pdf->Cell(29,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
//ucet bonus
$fir_fuc1x=$fir_fuc1;
$fir_fnm1x=$fir_fnm1;
if ( $hlavicka->ubon == 0 OR $hlavicka->zbon == 0 ) { $fir_fuc1x=""; $fir_fnm1x=""; }
$A=substr($fir_fuc1x,0,1);
$B=substr($fir_fuc1x,1,1);
$C=substr($fir_fuc1x,2,1);
$D=substr($fir_fuc1x,3,1);
$E=substr($fir_fuc1x,4,1);
$F=substr($fir_fuc1x,5,1);
$G=substr($fir_fuc1x,6,1);
$H=substr($fir_fuc1x,7,1);
$I=substr($fir_fuc1x,8,1);
$J=substr($fir_fuc1x,9,1);
$K=substr($fir_fuc1x,10,1);
$L=substr($fir_fuc1x,11,1);
$M=substr($fir_fuc1x,12,1);
$N=substr($fir_fuc1x,13,1);
$O=substr($fir_fuc1x,14,1);
$P=substr($fir_fuc1x,15,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//kod banky bonus
$A=substr($fir_fnm1x,0,1);
$B=substr($fir_fnm1x,1,1);
$C=substr($fir_fnm1x,2,1);
$D=substr($fir_fnm1x,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"L");

//IV.CAST
//ziadame zam.premia
$krizikpremia1="x";
$krizikpremia2="x";
$krizikpremia3="x";
if ( $hlavicka->zzpr == 0 ) { $krizikpremia1=" "; }
if ( $hlavicka->pzpr == 0 OR $hlavicka->zzpr == 0 ) { $krizikpremia2=" "; }
if ( $hlavicka->uzpr == 0 OR $hlavicka->zzpr == 0 ) { $krizikpremia3=" "; }
$pdf->Cell(190,14,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizikpremia1","$rmc",1,"C");
$pdf->Cell(190,4,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizikpremia2","$rmc",1,"C");
$pdf->Cell(190,3,"","$rmc1",1,"L");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizikpremia3","$rmc",1,"C");
//rok zam.premia
$tlachod_c=$hlavicka->rzpr;
if ( $tlachod_c == 0 OR $hlavicka->zzpr == 0 ) $tlachod_c="";
$tlachod_c=sprintf("% 2s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$pdf->SetY(253);
$pdf->Cell(148,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");
//suma zam.premia
$tlachod_c=100*$hlavicka->szpr;
if ( $tlachod_c == 0 OR $hlavicka->zzpr == 0 ) $tlachod_c="";
$tlachod_c=sprintf("% 8s",$tlachod_c);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$C=substr($tlachod_c,2,1);
$D=substr($tlachod_c,3,1);
$E=substr($tlachod_c,4,1);
$F=substr($tlachod_c,5,1);
$G=substr($tlachod_c,6,1);
$H=substr($tlachod_c,7,1);
$pdf->Cell(190,5,"","$rmc1",1,"C");
$pdf->Cell(29,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
//ucet zam.premia
$fir_fuc1x=$fir_fuc1;
$fir_fnm1x=$fir_fnm1;
if ( $hlavicka->uzpr == 0 OR $hlavicka->zzpr == 0 ) { $fir_fuc1x=""; $fir_fnm1x=""; }
$A=substr($fir_fuc1x,0,1);
$B=substr($fir_fuc1x,1,1);
$C=substr($fir_fuc1x,2,1);
$D=substr($fir_fuc1x,3,1);
$E=substr($fir_fuc1x,4,1);
$F=substr($fir_fuc1x,5,1);
$G=substr($fir_fuc1x,6,1);
$H=substr($fir_fuc1x,7,1);
$I=substr($fir_fuc1x,8,1);
$J=substr($fir_fuc1x,9,1);
$K=substr($fir_fuc1x,10,1);
$L=substr($fir_fuc1x,11,1);
$M=substr($fir_fuc1x,12,1);
$N=substr($fir_fuc1x,13,1);
$O=substr($fir_fuc1x,14,1);
$P=substr($fir_fuc1x,15,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//kod banky zam.premia
$A=substr($fir_fnm1x,0,1);
$B=substr($fir_fnm1x,1,1);
$C=substr($fir_fnm1x,2,1);
$D=substr($fir_fnm1x,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"L");
                                       }

}
$i = $i + 1;
  }
$pdf->Output("../tmp/mesprehdane.$kli_uzid.pdf");
//koniec formular prehlad if ( $drupoh == 1 )
     }


//potvrdenie o podani
if ( $copern == 10 AND $drupoh == 1 )
     {
if ( File_Exists("../tmp/potvrdmesprehdane$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdmesprehdane$kli_vume.$kli_uzid.pdf"); }
$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );

$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/Potvrdene_o_prevzati_prehladu.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/mesacny_prehlad/Potvrdene_o_prevzati_prehladu.jpg',24,23,166,249);
}

//mesiac a rok
$kli_vmesx=1*$kli_vmes;
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$pdf->Cell(190,45,"","$rmc1",1,"L");
$pdf->Cell(88,6," ","$rmc1",0,"C");$pdf->Cell(28,6,"$kli_vmesx","$rmc",1,"C");
$pdf->Cell(190,2,"","$rmc1",1,"L");
$pdf->Cell(148,8," ","$rmc1",0,"C");$pdf->Cell(25,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',11);

$fnaz=$fir_fnaz;
if ( $fir_uctt03 == 999 )
{
$fnaz=$dprie." ".$dmeno." ".$dtitl." ".$dtitz;
}
//nazov
$pdf->Cell(190,21," ","$rmc1",1,"L");
$pdf->Cell(11,5," ","$rmc1",0,"L");$pdf->Cell(163,7,"$fnaz","$rmc",1,"L");

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
$pdf->Cell(190,9,"","$rmc1",1,"L");
$pdf->Cell(82,5," ","$rmc1",0,"L");$pdf->Cell(16,5," ","$rmc",0,"R");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(7,6,"$B","$rmc",0,"C");
$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(7,6,"$D","$rmc",0,"C");
$pdf->Cell(8,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");
$pdf->Cell(7,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",0,"C");
$pdf->Cell(8,6,"$I","$rmc",0,"C");$pdf->Cell(7,6,"$J","$rmc",1,"C");

//pobyt(FO) sidlo(PO)
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(11,5," ","$rmc1",0,"L");$pdf->Cell(163,7,"$duli $dcdm","$rmc",1,"L");
//psc obec
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(11,5," ","$rmc1",0,"L");$pdf->Cell(33,5,"$dpsc","$rmc",0,"L");
$pdf->Cell(19,5," ","$rmc1",0,"L");$pdf->Cell(111,5,"$dmes","$rmc",1,"L");
//stat nevyplnam
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(11,5," ","$rmc1",0,"L");$pdf->Cell(52,5,"SK","$rmc",1,"L");

//UDAJE O PREHLADE
//druh prehladu
$riadne="x";
$opravne="x";
if ( $h_drp == 1 ) { $opravne=""; }
if ( $h_drp == 2 ) { $riadne=""; }
$pdf->Cell(190,20," ","$rmc1",1,"L");
$pdf->Cell(60,5," ","$rmc1",0,"L");$pdf->Cell(7,5,"$riadne","$rmc",1,"C");
$pdf->Cell(60,5," ","$rmc1",0,"L");$pdf->Cell(7,5,"$opravne","$rmc",1,"C");
//datum vyhotovenia
$pdf->Cell(117,5," ","$rmc1",0,"L");$pdf->Cell(57,6,"$h_dap","$rmc",1,"C");
//suma bonusu
$sbon=$hlavicka->sbon;
if ( $sbon == 0 ) $sbon="";
$pdf->Cell(117,5," ","$rmc1",0,"L");$pdf->Cell(57,5,"$sbon","$rmc",1,"R");
//suma zam.premie
$szpr=$hlavicka->szpr;
if ( $szpr == 0 ) $szpr="";
$pdf->Cell(117,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$szpr","$rmc",1,"R");

$pdf->Output("../tmp/potvrdmesprehdane$kli_vxcf.$kli_uzid.pdf");
     }
//koniec potvrdenia o podani

if ( $drupoh == 1 )
     {
?>
<script type="text/javascript">
 var okno = window.open("../tmp/mesprehdane.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
     }
//koniec vytlac
}
?>


<?php
///////////////////////////////////////////////////XML SUBOR copern 110
if ( $copern == 110 )
     {
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;
$nazsub="PREHLAD_mesiac_".$kli_vmes."_id".$idx.".xml";

if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");

//prehlad 2013
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"	xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<dic>0123456789</dic>
		<danovyUrad>Koöice</danovyUrad>
		<druhPrehladu>
			<riadny>0</riadny>
			<opravny>1</opravny>
		</druhPrehladu>
		<zdanovacieObdobie>
			<mesiac>1</mesiac>
			<rok>2013</rok>
		</zdanovacieObdobie>
		<datumZisteniaOP>1.1.2013</datumZisteniaOP>
		<fo>
			<priezvisko>Priezvisko</priezvisko>
			<meno>Meno</meno>
			<titul>Mgr.</titul>
		</fo>
		<po>
			<obchodneMeno>ObchodnÈ meno</obchodneMeno>
			<pravnaForma>123</pravnaForma>
		</po>
		<sidlo>
			<ulica>Ulica</ulica>
			<cislo>10</cislo>
			<psc>12345</psc>
			<obec>Obec</obec>
			<tel>
				<predcislie>0011</predcislie>
				<cislo>23456789</cislo>
			</tel>
			<fax>
				<predcislie>9988</predcislie>
				<cislo>76543210</cislo>
			</fax>
		</sidlo>
		<vyhotovil>
			<meno>Vyhotovil</meno>
			<tel>
				<predcislie>0022</predcislie>
				<cislo>33234567</cislo>
			</tel>
			<datumVyhotovenia>11.1.2013</datumVyhotovenia>
		</vyhotovil>
	</hlavicka>
	<telo>
		<cast1>
		  <r00>100.00</r00>
			<r01>
				<datum>01.01.2011</datum>
				<suma>101.01</suma>
			</r01>
			<r02>102.02</r02>
			<r03>103.03</r03>
			<r04>104.04</r04>
			<r05>105.05</r05>
			<r06>106.06</r06>
			<r07>107.07</r07>
			<r08>
				<datum>01.08.2011</datum>
				<suma>108.08</suma>
			</r08>
		</cast1>
		<cast2>
			<rA>2101.01</rA>
			<rB>2102.02</rB>
			<rC>2103.03</rC>
			<rD>2104.04</rD>
			<rE>2105.05</rE>
			<rF>2106.06</rF>
		</cast2>
		<cast3>
			<poukazat>1</poukazat>
			<stvrtrok>2</stvrtrok>
			<sposobPlatby>
				<poukazka>1</poukazka>
				<ucet>1</ucet>
			</sposobPlatby>
			<suma>300.00</suma>
			<bankovyUcet>
				<cisloUctu>302202202</cisloUctu>
				<kodBanky>3200</kodBanky>
			</bankovyUcet>
		</cast3>
		<cast4>
			<poukazat>1</poukazat>
			<rok>2012</rok>
			<sposobPlatby>
				<poukazka>1</poukazka>
				<ucet>1</ucet>
			</sposobPlatby>
			<suma>400.00</suma>
			<bankovyUcet>
				<cisloUctu>402202202</cisloUctu>
				<kodBanky>4200</kodBanky>
			</bankovyUcet>
		</cast4>
	</telo>
</dokument>

);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdmesacnyprehladdane".
" WHERE umex = $kli_vume ORDER BY konx";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
   {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);
  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = "  <dic><![CDATA[".$fir_fdic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$fir_uctt01 = iconv("CP1250", "UTF-8", $fir_uctt01);
  $text = "  <danovyUrad><![CDATA[".$fir_uctt01."]]></danovyUrad>"."\r\n"; fwrite($soubor, $text);

$h_drp = 1*$hlavicka->druh;
  $text = "  <druhPrehladu>"."\r\n";   fwrite($soubor, $text);
$riadne="0";
if ( $h_drp == 1 ) $riadne="1";
$opravne="0";
if ( $h_drp == 2 ) $opravne="1";
  $text = "   <riadny><![CDATA[".$riadne."]]></riadny>"."\r\n";  fwrite($soubor, $text);
  $text = "   <opravny><![CDATA[".$opravne."]]></opravny>"."\r\n";  fwrite($soubor, $text);
  $text = "  </druhPrehladu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
  $pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
if ( $kli_vmes < 10 ) { $kli_vmes="0".$kli_vmes; }
  $text = "   <mesiac><![CDATA[".$kli_vmes."]]></mesiac> "."\r\n"; fwrite($soubor, $text);
  $text = "   <rok><![CDATA[".$kli_vrok."]]></rok> "."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

$dat_opravne="";
if ( $h_drp == 2 ) { $dat_opravne=SkDatum($hlavicka->dopr); }
  $text = "  <datumZisteniaOP><![CDATA[".$dat_opravne."]]></datumZisteniaOP>"."\r\n"; fwrite($soubor, $text);
   
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dprie = $fir_riadok->dprie;
$dmeno = $fir_riadok->dmeno;
$dtitl = $fir_riadok->dtitl;

if ( $kli_vrok >= 2014 )
   {
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$dprie = $riadokc->dprie;
$dmeno = $riadokc->dmeno;
$dtitl = $riadokc->dtitl;
$dtitz = $riadokc->dtitz;
     }
   }
}
$dprie = iconv("CP1250", "UTF-8", $dprie);
$dmeno = iconv("CP1250", "UTF-8", $dmeno);
$dtitl = iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <fo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <priezvisko><![CDATA[".$dprie."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
  $text = "   <meno><![CDATA[".$dmeno."]]></meno>"."\r\n"; fwrite($soubor, $text);
  $text = "   <titul><![CDATA[".$dtitl."]]></titul>"."\r\n"; fwrite($soubor, $text);
  $text = "  </fo>"."\r\n"; fwrite($soubor, $text);

$fir_uctt03x=$fir_uctt03;
if ( $fir_uctt03 == 999 ) $fir_fnaz="";
if ( $fir_uctt03 == 999 ) $fir_uctt03x="";
  $text = "  <po>"."\r\n"; fwrite($soubor, $text);
$fir_fnaz = iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "   <obchodneMeno><![CDATA[".$fir_fnaz."]]></obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = "   <pravnaForma><![CDATA[".$fir_uctt03x."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "  </po>"."\r\n"; fwrite($soubor, $text);

//fyzicka osoba - sidlo - ulica, cislo
if ( $fir_uctt03 == 999 )
{
if ( $kli_vrok >= 2014 )
   {
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);

$fir_fuli = $riadokc->duli;
$fir_fpsc = $riadokc->dpsc;
$fir_fmes = $riadokc->dmes;
$fir_fcdm = $riadokc->dcdm;
$fir_ftel = $riadokc->dtel;
$fir_ffax = $riadokc->dfax;
     }
   }
}
  $text = "   <sidlo>"."\r\n"; fwrite($soubor, $text);
$fir_fuli = iconv("CP1250", "UTF-8", $fir_fuli);
$fir_fmes = iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <ulica><![CDATA[".$fir_fuli."]]></ulica>"."\r\n"; fwrite($soubor, $text);
  $text = "   <cislo><![CDATA[".$fir_fcdm."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <psc><![CDATA[".$fir_fpsc."]]></psc>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obec><![CDATA[".$fir_fmes."]]></obec>"."\r\n"; fwrite($soubor, $text);

$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
  $text = "   <tel>"."\r\n"; fwrite($soubor, $text);
  $text = "    <predcislie><![CDATA[".$tel_pred."]]></predcislie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <cislo><![CDATA[".$tel_za."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tel>"."\r\n"; fwrite($soubor, $text);
$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
  $text = "   <fax>"."\r\n"; fwrite($soubor, $text);
  $text = "    <predcislie><![CDATA[".$fax_pred."]]></predcislie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <cislo><![CDATA[".$fax_za."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   </fax>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

  $text = "  <vyhotovil>"."\r\n"; fwrite($soubor, $text);

$fir_mzdt05 = iconv("CP1250", "UTF-8", $fir_mzdt05);
  $text = "   <meno><![CDATA[".$fir_mzdt05."]]></meno>"."\r\n"; fwrite($soubor, $text);
$pole = explode("/", $fir_mzdt04);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
  $text = "   <tel>"."\r\n"; fwrite($soubor, $text);
  $text = "    <predcislie><![CDATA[".$tel_pred."]]></predcislie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <cislo><![CDATA[".$tel_za."]]></cislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   </tel>"."\r\n"; fwrite($soubor, $text);

$h_dap = SkDatum($hlavicka->dap);
  $text = "   <datumVyhotovenia><![CDATA[".$h_dap."]]></datumVyhotovenia>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vyhotovil>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = " <telo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <cast1>"."\r\n"; fwrite($soubor, $text);

$tlachod_c=$hlavicka->r00a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r00><![CDATA[".$tlachod_c."]]></r00>"."\r\n"; fwrite($soubor, $text);
  
  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$tlachod=SkDatum($hlavicka->r01ad);
if ( $tlachod == '00.00.0000' ) $tlachod="";
  $text = "    <datum><![CDATA[".$tlachod."]]></datum>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r01a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "    <suma><![CDATA[".$tlachod_c."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

$tlachod_c=$hlavicka->r02a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r02><![CDATA[".$tlachod_c."]]></r02>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r03a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r03><![CDATA[".$tlachod_c."]]></r03>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r04a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r04><![CDATA[".$tlachod_c."]]></r04>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r05a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r05><![CDATA[".$tlachod_c."]]></r05>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r06a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r06><![CDATA[".$tlachod_c."]]></r06>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r07a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <r07><![CDATA[".$tlachod_c."]]></r07>"."\r\n"; fwrite($soubor, $text);
  
  $text = "   <r08>"."\r\n"; fwrite($soubor, $text);
$tlachod=SkDatum($hlavicka->r08ad);
if ( $tlachod == '00.00.0000' ) $tlachod="";
  $text = "    <datum><![CDATA[".$tlachod."]]></datum>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->r08a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "    <suma><![CDATA[".$tlachod_c."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r08>"."\r\n"; fwrite($soubor, $text);
    
  $text = "  </cast1>"."\r\n"; fwrite($soubor, $text);
  $text = "  <cast2>"."\r\n"; fwrite($soubor, $text);

$tlachod_c=$hlavicka->ra1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rA><![CDATA[".$tlachod_c."]]></rA>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->rb1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rB><![CDATA[".$tlachod_c."]]></rB>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->rc1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rC><![CDATA[".$tlachod_c."]]></rC>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->rd1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rD><![CDATA[".$tlachod_c."]]></rD>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->re1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rE><![CDATA[".$tlachod_c."]]></rE>"."\r\n"; fwrite($soubor, $text);
$tlachod_c=$hlavicka->rf1a;
if ( $tlachod_c == 0 ) $tlachod_c="";
  $text = "   <rF><![CDATA[".$tlachod_c."]]></rF>"."\r\n"; fwrite($soubor, $text);

  $text = "  </cast2>"."\r\n"; fwrite($soubor, $text);
  $text = "  <cast3>"."\r\n"; fwrite($soubor, $text);

$zbon=1*$hlavicka->zbon;
  $text = "   <poukazat><![CDATA[".$zbon."]]></poukazat>"."\r\n"; fwrite($soubor, $text);

$vbon=1*$hlavicka->vbon;
if ( $vbon == 0 ) $vbon="";
  $text = "   <stvrtrok><![CDATA[".$vbon."]]></stvrtrok>"."\r\n"; fwrite($soubor, $text);

  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
$pbon=1*$hlavicka->pbon;
  $text = "    <poukazka><![CDATA[".$pbon."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ubon=1*$hlavicka->ubon;
  $text = "    <ucet><![CDATA[".$ubon."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n";   fwrite($soubor, $text);

$sbon=$hlavicka->sbon;
if ( $sbon == 0 ) $sbon="";
  $text = "   <suma><![CDATA[".$sbon."]]></suma>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$fir_fuc1x=$fir_fuc1;
$fir_fnm1x=$fir_fnm1;
if ( $ubon != 1 ) { $fir_fuc1x=""; $fir_fnm1x=""; }
  $text = "    <cisloUctu><![CDATA[".$fir_fuc1x."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
  $text = "    <kodBanky><![CDATA[".$fir_fnm1x."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

  $text = "  </cast3>"."\r\n"; fwrite($soubor, $text);
  $text = "  <cast4>"."\r\n"; fwrite($soubor, $text);

$zzpr=1*$hlavicka->zzpr;
  $text = "   <poukazat><![CDATA[".$zzpr."]]></poukazat>"."\r\n"; fwrite($soubor, $text);

$rzpr=2000+$hlavicka->rzpr;
if ( $hlavicka->rzpr == 0 ) $rzpr="";
  $text = "   <rok><![CDATA[".$rzpr."]]></rok>"."\r\n"; fwrite($soubor, $text);

  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
$pzpr=1*$hlavicka->pzpr;
  $text = "    <poukazka><![CDATA[".$pzpr."]]></poukazka>"."\r\n";   fwrite($soubor, $text);
$uzpr=1*$hlavicka->uzpr;
  $text = "    <ucet><![CDATA[".$uzpr."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

$szpr=$hlavicka->szpr;
if ( $szpr == 0 ) $szpr="";
  $text = "   <suma><![CDATA[".$szpr."]]></suma>"."\r\n"; fwrite($soubor, $text);
  
  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$fir_fuc1x=$fir_fuc1;
$fir_fnm1x=$fir_fnm1;
if ( $uzpr != 1 ) { $fir_fuc1x=""; $fir_fnm1x=""; }
  $text = "    <cisloUctu><![CDATA[".$fir_fuc1x."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
  $text = "    <kodBanky><![CDATA[".$fir_fnm1x."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

  $text = "  </cast4>"."\r\n"; fwrite($soubor, $text);
  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
   }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">mesaËn˝ Prehæad o preddavkoch na daÚ - export do XML</td>
  <td></td>
 </tr>
 </table>
</div>
<div class="content-xml">
<p>Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a
   naËÌtajte na www.drsr.sk alebo do aplik·cie eDane:</p>
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
</div>
<?php
     }
//koniec XML SUBOR copern 110
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>
