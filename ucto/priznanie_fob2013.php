<!doctype html>
<HTML>
<?php
$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }

$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//userhash
$userhash = $_REQUEST['userhash'];

require_once('../androidfanti/MCrypt.php');
$mcrypt = new MCrypt();
//#Encrypt
//$encrypted = $mcrypt->encrypt("Text to encrypt");
$encrypted=$userhash;
#Decrypt
$userxplus = $mcrypt->decrypt($encrypted);

//user
$userx=$userxplus;
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];
$cislo_dok=1*$poleu[12];

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";

$anduct=1*$_REQUEST['anduct'];
if( $anduct == 1 )
  {
//nastav databazu
$kli_vrok=1*$_REQUEST['rokx'];
$kli_vxcf=1*$_REQUEST['firx'];
$dbsed="../".$adrsxxx."/nastavdbase.php";
$sDat = include("$dbsed");
mysql_select_db($databaza);
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";
  }

if( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }


$druhid=0;
$cuid=0;
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=10;
    $cuid=1*$riaddok->cuid;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx AND ez_heslo = '$pswdxxx' ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cuid=1*$riaddok->cuid;
    $druhid=20;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."klienti WHERE id_klienta = $cuid AND all_prav > 20000 ORDER BY id_klienta DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=99;
    }
if( $druhid < 20 ) { exit; }
$kli_uzid=$cuid;
if( $kli_uzid == 0 ) { exit; }


$_REQUEST['h_dap']="01.01.".$kli_vrok;
$_REQUEST['h_dak']="31.12.".$kli_vrok;
$_REQUEST['h_stp']=1;
$_REQUEST['h_stk']=999;
$_REQUEST['h_aky']=1;
$kli_vume=$_REQUEST['kli_vume'];
$_REQUEST['strana']=9999;

  }

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 3000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }
?>

<?php
do
{

if( $zandroidu == 0 )
  {
require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
  }

$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if (!isset($fort)) $fort = 1;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = 9999;
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;

$prepocitaj = 1*$_REQUEST['prepocitaj'];
$vsetkyprepocty=0;

$nezdanitelna = 1*$_REQUEST['nezdanitelna'];
$zamestnanecka = 1*$_REQUEST['zamestnanecka'];
$namanzelku = 1*$_REQUEST['namanzelku'];

$xml = 1*$_REQUEST['xml'];

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Da�ov� priznanie bude pripraven� v priebehu janu�ra 2014. Aktu�lne info n�jdete na vstupnej str�nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//nacitanie minuleho roka do FOB
if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete na��ta� �daje do FOB z firmy minul�ho roka ?") )
         { window.close() }
else
         { location.href='priznanie_fob2013.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                  }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
if ( $kli_vrok > 2010 ) { if (File_Exists("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok > 2011 ) { if (File_Exists("../pswd/oddelena2011db2012.php")) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrok > 2012 ) { if (File_Exists("../pswd/oddelena2012db2013.php")) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrok > 2013 ) { if (File_Exists("../pswd/oddelena2013db2014.php")) { $databaza=$mysqldb2013."."; } }

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob,".$databaza."F$h_ycf"."_mzdpriznanie_fob SET ".
" F$kli_vxcf"."_mzdpriznanie_fob.cinnost=".$databaza."F$h_ycf"."_mzdpriznanie_fob.cinnost, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dprie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dprie, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dmeno=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dmeno, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dtitl=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dtitl, ".
" F$kli_vxcf"."_mzdpriznanie_fob.duli=".$databaza."F$h_ycf"."_mzdpriznanie_fob.duli, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dcdm=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dcdm, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dpsc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dpsc, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dmes=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dmes, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dtel=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dtel, ".
" F$kli_vxcf"."_mzdpriznanie_fob.dfax=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dfax, ".

" F$kli_vxcf"."_mzdpriznanie_fob.d2uli=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2uli, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2cdm=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2cdm, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2psc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2psc, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2mes=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2mes, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2tel=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2tel, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2fax=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2fax, ".

" F$kli_vxcf"."_mzdpriznanie_fob.d3uli=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3uli, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3cdm=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3cdm, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3psc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3psc, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3mes=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3mes, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3tel=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3tel, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3fax=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3fax, ".

" F$kli_vxcf"."_mzdpriznanie_fob.zrdk=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zrdk, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zrdc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zrdc,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.zprie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zprie, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zmeno=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zmeno, ".
" F$kli_vxcf"."_mzdpriznanie_fob.ztitl=".$databaza."F$h_ycf"."_mzdpriznanie_fob.ztitl, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zuli=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zuli, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zcdm=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zcdm, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zpsc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zpsc, ".
" F$kli_vxcf"."_mzdpriznanie_fob.zmes=".$databaza."F$h_ycf"."_mzdpriznanie_fob.zmes, ".
" F$kli_vxcf"."_mzdpriznanie_fob.ztel=".$databaza."F$h_ycf"."_mzdpriznanie_fob.ztel, ".

" F$kli_vxcf"."_mzdpriznanie_fob.mprie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.mprie,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.mrod=".$databaza."F$h_ycf"."_mzdpriznanie_fob.mrod, ".
" F$kli_vxcf"."_mzdpriznanie_fob.mpri=".$databaza."F$h_ycf"."_mzdpriznanie_fob.mpri, ".
" F$kli_vxcf"."_mzdpriznanie_fob.mpom=".$databaza."F$h_ycf"."_mzdpriznanie_fob.mpom, ".

" F$kli_vxcf"."_mzdpriznanie_fob.d1prie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d1prie,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.d1rod=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d1rod, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2prie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2prie,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.d2rod=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d2rod, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3prie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3prie,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.d3rod=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d3rod, ".
" F$kli_vxcf"."_mzdpriznanie_fob.d4prie=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d4prie,  ".
" F$kli_vxcf"."_mzdpriznanie_fob.d4rod=".$databaza."F$h_ycf"."_mzdpriznanie_fob.d4rod, ".

" F$kli_vxcf"."_mzdpriznanie_fob.dar=".$databaza."F$h_ycf"."_mzdpriznanie_fob.dar, ".
" F$kli_vxcf"."_mzdpriznanie_fob.rdk=".$databaza."F$h_ycf"."_mzdpriznanie_fob.rdk, ".

" F$kli_vxcf"."_mzdpriznanie_fob.rdc=".$databaza."F$h_ycf"."_mzdpriznanie_fob.rdc  ".
" WHERE F$kli_vxcf"."_mzdpriznanie_fob.oc >= 0 "; 

$upravene = mysql_query("$uprtxt"); 
$copern=20;
//koniec nacitania celeho minuleho roka do FOB
    }


//nacitaj prijmy a vydaje
$nacitajpav=0;
if ( $copern == 200 )
{
$nacitajpav=1;
$copern=20;

}
//koniec copern=200 nacitaj prijmy a vydaje



//znovu nacitaj
if ( $copern == 26 ) { $copern=20; }

//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
//$rdc = strip_tags($_REQUEST['rdc']);
//$rdk = strip_tags($_REQUEST['rdk']);
$dar = $_REQUEST['dar'];
$darsql=SqlDatum($dar);
$druh = 1*$_REQUEST['druh'];
$ddp = $_REQUEST['ddp'];
$ddpsql=SqlDatum($ddp);
$cinnost = strip_tags($_REQUEST['cinnost']);
$dprie = strip_tags($_REQUEST['dprie']);
$dmeno = strip_tags($_REQUEST['dmeno']);
$dtitl = strip_tags($_REQUEST['dtitl']);
$dtitz = strip_tags($_REQUEST['dtitz']);
$duli = strip_tags($_REQUEST['duli']);
$dcdm = strip_tags($_REQUEST['dcdm']);
$dpsc = strip_tags($_REQUEST['dpsc']);
$dmes = strip_tags($_REQUEST['dmes']);
$xstat = strip_tags($_REQUEST['xstat']);
$nrz = 1*$_REQUEST['nrz'];
$prp = 1*$_REQUEST['prp'];
$d2uli = strip_tags($_REQUEST['d2uli']);
$d2cdm = strip_tags($_REQUEST['d2cdm']);
$d2psc = strip_tags($_REQUEST['d2psc']);
$d2mes = strip_tags($_REQUEST['d2mes']);
//$d2tel = strip_tags($_REQUEST['d2tel']);
//$d2fax = strip_tags($_REQUEST['d2fax']);
//$oznucet = 1*$_REQUEST['oznucet'];
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
//$ztel = strip_tags($_REQUEST['ztel']);
$zstat = strip_tags($_REQUEST['zstat']);
$dtel = strip_tags($_REQUEST['dtel']);
$dmailfax = strip_tags($_REQUEST['dmailfax']);
//$d3uli = strip_tags($_REQUEST['d3uli']);
//$d3cdm = strip_tags($_REQUEST['d3cdm']);
//$d3psc = strip_tags($_REQUEST['d3psc']);
//$d3mes = strip_tags($_REQUEST['d3mes']);
//$d3tel = strip_tags($_REQUEST['d3tel']);
//$d3fax = strip_tags($_REQUEST['d3fax']);
//$pruli = strip_tags($_REQUEST['pruli']);
//$prcdm = strip_tags($_REQUEST['prcdm']);
//$prpsc = strip_tags($_REQUEST['prpsc']);
//$prmes = strip_tags($_REQUEST['prmes']);
//$prtel = strip_tags($_REQUEST['prtel']);
//$prfax = strip_tags($_REQUEST['prfax']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" dar='$darsql', druh='$druh', ddp='$ddpsql', cinnost='$cinnost', ".
" dprie='$dprie', dmeno='$dmeno', dtitl='$dtitl', dtitz='$dtitz', duli='$duli', dcdm='$dcdm', dpsc='$dpsc', dmes='$dmes', xstat='$xstat', ".
" nrz='$nrz', prp='$prp', d2uli='$d2uli', d2cdm='$d2cdm', d2psc='$d2psc', d2mes='$d2mes', ".
" zprie='$zprie', zmeno='$zmeno', ztitl='$ztitl', ztitz='$ztitz', zrdc='$zrdc', zrdk='$zrdk', zuli='$zuli', zcdm='$zcdm', zpsc='$zpsc', zmes='$zmes', zstat='$zstat', ".
" dtel='$dtel', dmailfax='$dmailfax' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 2 ) {
$r29 = 1*$_REQUEST['r29'];
$r30 = 1*$_REQUEST['r30'];
$mprie = strip_tags($_REQUEST['mprie']);
$mrod = strip_tags($_REQUEST['mrod']);
$mpri = 1*$_REQUEST['mpri'];
$mpom = strip_tags($_REQUEST['mpom']);
$d1prie = strip_tags($_REQUEST['d1prie']);
$d1rod = strip_tags($_REQUEST['d1rod']);
$d1pomc = strip_tags($_REQUEST['d1pomc']);
$d1pom1 = strip_tags($_REQUEST['d1pom1']);
$d1pom2 = strip_tags($_REQUEST['d1pom2']);
$d1pom3 = strip_tags($_REQUEST['d1pom3']);
$d1pom4 = strip_tags($_REQUEST['d1pom4']);
$d1pom5 = strip_tags($_REQUEST['d1pom5']);
$d1pom6 = strip_tags($_REQUEST['d1pom6']);
$d1pom7 = strip_tags($_REQUEST['d1pom7']);
$d1pom8 = strip_tags($_REQUEST['d1pom8']);
$d1pom9 = strip_tags($_REQUEST['d1pom9']);
$d1pom10 = strip_tags($_REQUEST['d1pom10']);
$d1pom11 = strip_tags($_REQUEST['d1pom11']);
$d1pom12 = strip_tags($_REQUEST['d1pom12']);
$d2prie = strip_tags($_REQUEST['d2prie']);
$d2rod = strip_tags($_REQUEST['d2rod']);
$d2pomc = strip_tags($_REQUEST['d2pomc']);
$d2pom1 = strip_tags($_REQUEST['d2pom1']);
$d2pom2 = strip_tags($_REQUEST['d2pom2']);
$d2pom3 = strip_tags($_REQUEST['d2pom3']);
$d2pom4 = strip_tags($_REQUEST['d2pom4']);
$d2pom5 = strip_tags($_REQUEST['d2pom5']);
$d2pom6 = strip_tags($_REQUEST['d2pom6']);
$d2pom7 = strip_tags($_REQUEST['d2pom7']);
$d2pom8 = strip_tags($_REQUEST['d2pom8']);
$d2pom9 = strip_tags($_REQUEST['d2pom9']);
$d2pom10 = strip_tags($_REQUEST['d2pom10']);
$d2pom11 = strip_tags($_REQUEST['d2pom11']);
$d2pom12 = strip_tags($_REQUEST['d2pom12']);
$d3prie = strip_tags($_REQUEST['d3prie']);
$d3rod = strip_tags($_REQUEST['d3rod']);
$d3pomc = strip_tags($_REQUEST['d3pomc']);
$d3pom1 = strip_tags($_REQUEST['d3pom1']);
$d3pom2 = strip_tags($_REQUEST['d3pom2']);
$d3pom3 = strip_tags($_REQUEST['d3pom3']);
$d3pom4 = strip_tags($_REQUEST['d3pom4']);
$d3pom5 = strip_tags($_REQUEST['d3pom5']);
$d3pom6 = strip_tags($_REQUEST['d3pom6']);
$d3pom7 = strip_tags($_REQUEST['d3pom7']);
$d3pom8 = strip_tags($_REQUEST['d3pom8']);
$d3pom9 = strip_tags($_REQUEST['d3pom9']);
$d3pom10 = strip_tags($_REQUEST['d3pom10']);
$d3pom11 = strip_tags($_REQUEST['d3pom11']);
$d3pom12 = strip_tags($_REQUEST['d3pom12']);
$d4prie = strip_tags($_REQUEST['d4prie']);
$d4rod = strip_tags($_REQUEST['d4rod']);
$d4pomc = strip_tags($_REQUEST['d4pomc']);
$d4pom1 = strip_tags($_REQUEST['d4pom1']);
$d4pom2 = strip_tags($_REQUEST['d4pom2']);
$d4pom3 = strip_tags($_REQUEST['d4pom3']);
$d4pom4 = strip_tags($_REQUEST['d4pom4']);
$d4pom5 = strip_tags($_REQUEST['d4pom5']);
$d4pom6 = strip_tags($_REQUEST['d4pom6']);
$d4pom7 = strip_tags($_REQUEST['d4pom7']);
$d4pom8 = strip_tags($_REQUEST['d4pom8']);
$d4pom9 = strip_tags($_REQUEST['d4pom9']);
$d4pom10 = strip_tags($_REQUEST['d4pom10']);
$d4pom11 = strip_tags($_REQUEST['d4pom11']);
$d4pom12 = strip_tags($_REQUEST['d4pom12']);
$r33 = 1*$_REQUEST['r33'];
$r34 = 1*$_REQUEST['r34'];
$r34a = 1*$_REQUEST['r34a'];
$r35 = 1*$_REQUEST['r35'];
//$r35a = $_REQUEST['r35a'];
//$r35b = $_REQUEST['r35b'];
$r36 = 1*$_REQUEST['r36'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r29='$r29', r30='$r30', mprie='$mprie', mrod='$mrod', mpri='$mpri', mpom='$mpom', ".
" d1prie='$d1prie', d1rod='$d1rod', d1pomc='$d1pomc', d1pom1='$d1pom1', d1pom2='$d1pom2', d1pom3='$d1pom3', d1pom4='$d1pom4', d1pom5='$d1pom5', ".
" d1pom6='$d1pom6', d1pom7='$d1pom7', d1pom8='$d1pom8', d1pom9='$d1pom9', d1pom10='$d1pom10', d1pom11='$d1pom11', d1pom12='$d1pom12', ".
" d2prie='$d2prie', d2rod='$d2rod', d2pomc='$d2pomc', d2pom1='$d2pom1', d2pom2='$d2pom2', d2pom3='$d2pom3', d2pom4='$d2pom4', d2pom5='$d2pom5', ".
" d2pom6='$d2pom6', d2pom7='$d2pom7', d2pom8='$d2pom8', d2pom9='$d2pom9', d2pom10='$d2pom10', d2pom11='$d2pom11', d2pom12='$d2pom12', ".
" d3prie='$d3prie', d3rod='$d3rod', d3pomc='$d3pomc', d3pom1='$d3pom1', d3pom2='$d3pom2', d3pom3='$d3pom3', d3pom4='$d3pom4', d3pom5='$d3pom5', ".
" d3pom6='$d3pom6', d3pom7='$d3pom7', d3pom8='$d3pom8', d3pom9='$d3pom9', d3pom10='$d3pom10', d3pom11='$d3pom11', d3pom12='$d3pom12', ".
" d4prie='$d4prie', d4rod='$d4rod', d4pomc='$d4pomc', d4pom1='$d4pom1', d4pom2='$d4pom2', d4pom3='$d4pom3', d4pom4='$d4pom4', d4pom5='$d4pom5', ".
" d4pom6='$d4pom6', d4pom7='$d4pom7', d4pom8='$d4pom8', d4pom9='$d4pom9', d4pom10='$d4pom10', d4pom11='$d4pom11', d4pom12='$d4pom12', ".
" r33='$r33', r34='$r34', r34a='$r34a', r35='$r35', r36='$r36' ".
" WHERE oc = $cislo_oc"; 
                    }

if ( $strana == 3 ) {
$t1p1 = 1*$_REQUEST['t1p1'];
$t1v1 = 1*$_REQUEST['t1v1'];
$t1p2 = 1*$_REQUEST['t1p2'];
$t1v2 = 1*$_REQUEST['t1v2'];
$t1p3 = 1*$_REQUEST['t1p3'];
$t1v3 = 1*$_REQUEST['t1v3'];
$t1p4 = 1*$_REQUEST['t1p4'];
$t1v4 = 1*$_REQUEST['t1v4'];
$t1p5 = 1*$_REQUEST['t1p5'];
$t1v5 = 1*$_REQUEST['t1v5'];
$t1p6 = 1*$_REQUEST['t1p6'];
$t1v6 = 1*$_REQUEST['t1v6'];
$t1p7 = 1*$_REQUEST['t1p7'];
$t1v7 = 1*$_REQUEST['t1v7'];
$t1p8 = 1*$_REQUEST['t1p8'];
$t1v8 = 1*$_REQUEST['t1v8'];
$t1p9 = 1*$_REQUEST['t1p9'];
$t1v9 = 1*$_REQUEST['t1v9'];
$t1p10 = 1*$_REQUEST['t1p10'];
$t1v10 = 1*$_REQUEST['t1v10'];
$t1p11 = 1*$_REQUEST['t1p11'];
$t1v11 = 1*$_REQUEST['t1v11'];
$t1p12 = 1*$_REQUEST['t1p12'];
$t1v12 = 1*$_REQUEST['t1v12'];
$perc0 = 1*$_REQUEST['perc0'];
$perc1 = 1*$_REQUEST['perc1'];
//$perc2 = $_REQUEST['perc2'];
$perc3 = 1*$_REQUEST['perc3'];
$perc4 = 1*$_REQUEST['perc4'];
$psp6 = 1*$_REQUEST['psp6'];
//$pzp6 = $_REQUEST['pzp6'];
//$pzp63 = $_REQUEST['pzp63'];
//$pocmes = $_REQUEST['pocmes'];
//$percsum = $_REQUEST['percsum'];
$t1az1 = 1*$_REQUEST['t1az1'];
$t1az2 = 1*$_REQUEST['t1az2'];
$t1az3 = 1*$_REQUEST['t1az3'];
$t1az4 = 1*$_REQUEST['t1az4'];
$t1az5 = 1*$_REQUEST['t1az5'];
$t1ak1 = 1*$_REQUEST['t1ak1'];
$t1ak2 = 1*$_REQUEST['t1ak2'];
$t1ak3 = 1*$_REQUEST['t1ak3'];
$t1ak4 = 1*$_REQUEST['t1ak4'];
$t1ak5 = 1*$_REQUEST['t1ak5'];
$t1bz1 = 1*$_REQUEST['t1bz1'];
$t1bz2 = 1*$_REQUEST['t1bz2'];
$t1bk1 = 1*$_REQUEST['t1bk1'];
$t1bk2 = 1*$_REQUEST['t1bk2'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t1p1='$t1p1', t1p2='$t1p2', t1p3='$t1p3', t1p4='$t1p4', t1p5='$t1p5', t1p6='$t1p6',  ".
" t1p7='$t1p7', t1p8='$t1p8', t1p9='$t1p9', t1p10='$t1p10', t1p11='$t1p11', t1p12='$t1p12', ".
" t1v1='$t1v1', t1v2='$t1v2', t1v3='$t1v3', t1v4='$t1v4', t1v5='$t1v5', t1v6='$t1v6', ".
" t1v7='$t1v7', t1v8='$t1v8', t1v9='$t1v9', t1v10='$t1v10', t1v11='$t1v11', t1v12='$t1v12', ".
" perc0='$perc0', perc1='$perc1', perc3='$perc3', perc4='$perc4', psp6='$psp6', ".
" t1az1='$t1az1', t1az2='$t1az2', t1az3='$t1az3', t1az4='$t1az4', t1az5='$t1az5', t1ak1='$t1ak1', t1ak2='$t1ak2', t1ak3='$t1ak3', t1ak4='$t1ak4', t1ak5='$t1ak5', ".
" t1bz1='$t1bz1', t1bz2='$t1bz2', t1bk1='$t1bk1', t1bk2='$t1bk2' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 4 ) {
$t1cz1 = 1*$_REQUEST['t1cz1'];
$t1ck1 = 1*$_REQUEST['t1ck1'];
$t1cz2 = 1*$_REQUEST['t1cz2'];
$t1ck2 = 1*$_REQUEST['t1ck2'];
$t1cz3 = 1*$_REQUEST['t1cz3'];
$t1ck3 = 1*$_REQUEST['t1ck3'];
$t1cz4 = 1*$_REQUEST['t1cz4'];
$t1ck4 = 1*$_REQUEST['t1ck4'];
$t1cz5 = 1*$_REQUEST['t1cz5'];
$t1ck5 = 1*$_REQUEST['t1ck5'];
$r37 = 1*$_REQUEST['r37'];
$r38 = 1*$_REQUEST['r38'];
$r39 = 1*$_REQUEST['r39'];
$r40 = 1*$_REQUEST['r40'];
$r41 = 1*$_REQUEST['r41'];
$r42 = 1*$_REQUEST['r42'];
$r43 = 1*$_REQUEST['r43'];
$r44 = 1*$_REQUEST['r44'];
$r45 = 1*$_REQUEST['r45'];
$r46 = 1*$_REQUEST['r46'];
$r47 = 1*$_REQUEST['r47'];
$r48 = 1*$_REQUEST['r48'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t1cz1='$t1cz1', t1ck1='$t1ck1', t1cz2='$t1cz2', t1ck2='$t1ck2', t1cz3='$t1cz3', t1ck3='$t1ck3', t1cz4='$t1cz4', t1ck4='$t1ck4', t1cz5='$t1cz5', t1ck5='$t1ck5', ".
" r37='$r37', r38='$r38', r39='$r39', r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44', r45='$r45', r46='$r46', r47='$r47', r48='$r48' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 5 ) {
$r49 = 1*$_REQUEST['r49'];
$r50 = 1*$_REQUEST['r50'];
$r51 = 1*$_REQUEST['r51'];
$r52 = 1*$_REQUEST['r52'];
$t2p1 = 1*$_REQUEST['t2p1'];
$t2p2 = 1*$_REQUEST['t2p2'];
$t2p3 = 1*$_REQUEST['t2p3'];
$t2p4 = 1*$_REQUEST['t2p4'];
$t2p5 = 1*$_REQUEST['t2p5'];
$t2p6 = 1*$_REQUEST['t2p6'];
$t2p7 = 1*$_REQUEST['t2p7'];
$t2p8 = 1*$_REQUEST['t2p8'];
$t2p9 = 1*$_REQUEST['t2p9'];
$t2p10 = 1*$_REQUEST['t2p10'];
$t2p11 = 1*$_REQUEST['t2p11'];
$t2p12 = 1*$_REQUEST['t2p12'];
$t2p13 = 1*$_REQUEST['t2p13'];
$t2v1 = 1*$_REQUEST['t2v1'];
$t2v2 = 1*$_REQUEST['t2v2'];
$t2v3 = 1*$_REQUEST['t2v3'];
$t2v4 = 1*$_REQUEST['t2v4'];
$t2v5 = 1*$_REQUEST['t2v5'];
$t2v6 = 1*$_REQUEST['t2v6'];
$t2v7 = 1*$_REQUEST['t2v7'];
$t2v8 = 1*$_REQUEST['t2v8'];
$t2v9 = 1*$_REQUEST['t2v9'];
$t2v10 = 1*$_REQUEST['t2v10'];
$t2v11 = 1*$_REQUEST['t2v11'];
$t2v12 = 1*$_REQUEST['t2v12'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r49='$r49', r50='$r50', r51='$r51', r52='$r52', ".
" t2p1='$t2p1', t2p2='$t2p2', t2p3='$t2p3', t2p4='$t2p4', t2p5='$t2p5', t2p6='$t2p6', t2p7='$t2p7', ".
" t2p8='$t2p8', t2p9='$t2p9', t2p10='$t2p10', t2p11='$t2p11', t2p12='$t2p12', t2p13='$t2p13', ".
" t2v1='$t2v1', t2v2='$t2v2', t2v3='$t2v3', t2v4='$t2v4', t2v5='$t2v5', t2v6='$t2v6', t2v7='$t2v7', ".
" t2v8='$t2v8', t2v9='$t2v9', t2v10='$t2v10', t2v11='$t2v11', t2v12='$t2v12' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 6 ) {
$r53 = 1*$_REQUEST['r53'];
$r54 = 1*$_REQUEST['r54'];
$r55 = 1*$_REQUEST['r55'];
$t3p1 = 1*$_REQUEST['t3p1'];
$t3p2 = 1*$_REQUEST['t3p2'];
$t3p3 = 1*$_REQUEST['t3p3'];
$t3p4 = 1*$_REQUEST['t3p4'];
$t3p5 = 1*$_REQUEST['t3p5'];
$t3p6 = 1*$_REQUEST['t3p6'];
$t3p7 = 1*$_REQUEST['t3p7'];
$t3p8 = 1*$_REQUEST['t3p8'];
$t3p9 = 1*$_REQUEST['t3p9'];
$t3p10 = 1*$_REQUEST['t3p10'];
$t3p11 = 1*$_REQUEST['t3p11'];
$t3p12 = 1*$_REQUEST['t3p12'];
$t3p13 = 1*$_REQUEST['t3p13'];
$t3p14 = 1*$_REQUEST['t3p14'];
$t3v1 = 1*$_REQUEST['t3v1'];
$t3v2 = 1*$_REQUEST['t3v2'];
$t3v3 = 1*$_REQUEST['t3v3'];
$t3v4 = 1*$_REQUEST['t3v4'];
$t3v5 = 1*$_REQUEST['t3v5'];
$t3v6 = 1*$_REQUEST['t3v6'];
$t3v7 = 1*$_REQUEST['t3v7'];
$t3v8 = 1*$_REQUEST['t3v8'];
$t3v9 = 1*$_REQUEST['t3v9'];
$t3v10 = 1*$_REQUEST['t3v10'];
$t3v11 = 1*$_REQUEST['t3v11'];
$t3v12 = 1*$_REQUEST['t3v12'];
//$t3v13 = $_REQUEST['t3v13'];
$t3v14 = 1*$_REQUEST['t3v14'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r53='$r53', r54='$r54', r55='$r55', ".
" t3p1='$t3p1', t3p2='$t3p2', t3p3='$t3p3', t3p4='$t3p4', t3p5='$t3p5', t3p6='$t3p6', t3p7='$t3p7',".
" t3p8='$t3p8', t3p9='$t3p9', t3p10='$t3p10', t3p11='$t3p11', t3p12='$t3p12', t3p13='$t3p13', t3p14='$t3p14', ".
" t3v1='$t3v1', t3v2='$t3v2', t3v3='$t3v3', t3v4='$t3v4', t3v5='$t3v5', t3v6='$t3v6', t3v7='$t3v7',".
" t3v8='$t3v8', t3v9='$t3v9', t3v10='$t3v10', t3v11='$t3v11', t3v12='$t3v12', t3v14='$t3v14' ".
" WHERE oc = $cislo_oc"; 
                    }

if ( $strana == 7 ) {
$r56 = 1*$_REQUEST['r56'];
$r57 = 1*$_REQUEST['r57'];
$r58 = 1*$_REQUEST['r58'];
$r59 = 1*$_REQUEST['r59'];
$r60 = 1*$_REQUEST['r60'];
$r61 = 1*$_REQUEST['r61'];
$r62 = 1*$_REQUEST['r62'];
$r63 = 1*$_REQUEST['r63'];
$rr59 = $_REQUEST['rr59'];
$rr60 = $_REQUEST['rr60'];
$rr61 = $_REQUEST['rr61'];
$rr62 = $_REQUEST['rr62'];
$rr63 = $_REQUEST['rr63'];
//$rr64 = $_REQUEST['rr64'];
//$rr65 = $_REQUEST['rr65'];
//$rr66 = $_REQUEST['rr66'];
//$rr67 = $_REQUEST['rr67'];
//$rr68 = $_REQUEST['rr68'];
//$rr69 = $_REQUEST['rr69'];
//$rr70 = $_REQUEST['rr70'];
$r64 = 1*$_REQUEST['r64'];
$r65 = 1*$_REQUEST['r65'];
$r66 = 1*$_REQUEST['r66'];
$r67 = 1*$_REQUEST['r67'];
$r68 = 1*$_REQUEST['r68'];
$r69 = 1*$_REQUEST['r69'];
$r70 = 1*$_REQUEST['r70'];
$r71 = 1*$_REQUEST['r71'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r56='$r56', r57='$r57', r58='$r58', r59='$r59', r60='$r60', r61='$r61', r62='$r62', r63='$r63', rr59='$rr59', rr60='$rr60', rr61='$rr61', rr62='$rr62', ".
" rr63='$rr63', r64='$r64', r65='$r65', r66='$r66', r67='$r67', r68='$r68', r69='$r69', r70='$r70', r71='$r71' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 8 ) {
$r72 = 1*$_REQUEST['r72'];
$r73 = 1*$_REQUEST['r73'];
$r74 = 1*$_REQUEST['r74'];
$r75 = 1*$_REQUEST['r75'];
$r76 = 1*$_REQUEST['r76'];
$r77 = 1*$_REQUEST['r77'];
$r78 = 1*$_REQUEST['r78'];
$r79 = 1*$_REQUEST['r79'];
$r80 = 1*$_REQUEST['r80'];
$r81 = 1*$_REQUEST['r81'];
$r82 = 1*$_REQUEST['r82'];
$r83 = 1*$_REQUEST['r83'];
$r84 = 1*$_REQUEST['r84'];
$r85 = 1*$_REQUEST['r85'];
$r86 = 1*$_REQUEST['r86'];
$r87 = 1*$_REQUEST['r87'];
$r88 = 1*$_REQUEST['r88'];
$r89 = 1*$_REQUEST['r89'];
$r90 = 1*$_REQUEST['r90'];
$r91 = 1*$_REQUEST['r91'];
$r92 = 1*$_REQUEST['r92'];
$r93 = 1*$_REQUEST['r93'];
$r94 = 1*$_REQUEST['r94'];
$r95 = 1*$_REQUEST['r95'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r72='$r72', r73='$r73', r74='$r74', r75='$r75', r76='$r76', r77='$r77', r78='$r78', r79='$r79', r80='$r80', r81='$r81', r82='$r82', r83='$r83', ".
" r84='$r84', r85='$r85', r86='$r86', r87='$r87', r88='$r88', r89='$r89', r90='$r90', r91='$r91', r92='$r92', r93='$r93', r94='$r94', r95='$r95'  ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 9 ) {
$r96 = 1*$_REQUEST['r96'];
$r97 = 1*$_REQUEST['r97'];
$r98 = 1*$_REQUEST['r98'];
$r99 = 1*$_REQUEST['r99'];
$r100 = 1*$_REQUEST['r100'];
$r101 = 1*$_REQUEST['r101'];
$r102 = 1*$_REQUEST['r102'];
$r103 = 1*$_REQUEST['r103'];
$r104 = 1*$_REQUEST['r104'];
$r105 = 1*$_REQUEST['r105'];
$r106 = 1*$_REQUEST['r106'];
$r107 = 1*$_REQUEST['r107'];
$r108 = 1*$_REQUEST['r108'];
$r109 = 1*$_REQUEST['r109'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r96='$r96', r97='$r97', r98='$r98', r99='$r99', r100='$r100', r101='$r101', r102='$r102', r103='$r103', ".
" r104='$r104', r105='$r105', r106='$r106', r107='$r107', r108='$r108', r109='$r109' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 10 ) {
$r110 = 1*$_REQUEST['r110'];
$r111 = 1*$_REQUEST['r111'];
$r112 = 1*$_REQUEST['r112'];
$r113 = 1*$_REQUEST['r113'];
$r114 = 1*$_REQUEST['r114'];
$r115 = 1*$_REQUEST['r115'];
//$r116 = 1*$_REQUEST['r116'];
$r117 = 1*$_REQUEST['r117'];
//$r118 = 1*$_REQUEST['r118'];
//$r119 = 1*$_REQUEST['r119'];
//$r121 = 1*$_REQUEST['r121'];
//$r122 = 1*$_REQUEST['r122'];
$sdnr = strip_tags($_REQUEST['sdnr']);
//$udnr = $_REQUEST['udnr'];
//$r124 = 1*$_REQUEST['r124'];
$ldnr = 1*$_REQUEST['ldnr'];
$nrzsprev = 1*$_REQUEST['nrzsprev'];
$upl50 = 1*$_REQUEST['upl50'];
$spl3d = 1*$_REQUEST['spl3d'];
$r120 = 1*$_REQUEST['r120'];
//$r127 = 1*$_REQUEST['r127'];
$pico = strip_tags($_REQUEST['pico']);
$psid = strip_tags($_REQUEST['psid']);
$pfor = strip_tags($_REQUEST['pfor']);
$pmen = strip_tags($_REQUEST['pmen']);
$puli = strip_tags($_REQUEST['puli']);
$pcdm = strip_tags($_REQUEST['pcdm']);
$ppsc = strip_tags($_REQUEST['ppsc']);
$pmes = strip_tags($_REQUEST['pmes']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r110='$r110', r111='$r111', r112='$r112', r113='$r113', r114='$r114', r115='$r115', r117='$r117', ".
" sdnr='$sdnr', ldnr='$ldnr', nrzsprev='$nrzsprev', upl50='$upl50', spl3d='$spl3d', r120='$r120', ".
" pico='$pico', psid='$psid', pfor='$pfor', pmen='$pmen', puli='$puli', pcdm='$pcdm', ppsc='$ppsc', pmes='$pmes' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 11 ) {
$uoso = 1*$_REQUEST['uoso'];
$pzks1 = strip_tags($_REQUEST['pzks1']);
$pdrp1 = strip_tags($_REQUEST['pdrp1']);
$pdro1 = strip_tags($_REQUEST['pdro1']);
$pzpr1 = 1*$_REQUEST['pzpr1'];
$pzvd1 = 1*$_REQUEST['pzvd1'];
$pzthvd1 = 1*$_REQUEST['pzthvd1'];
$pzks2 = strip_tags($_REQUEST['pzks2']);
$pdrp2 = strip_tags($_REQUEST['pdrp2']);
$pdro2 = strip_tags($_REQUEST['pdro2']);
$pzpr2 = 1*$_REQUEST['pzpr2'];
$pzvd2 = 1*$_REQUEST['pzvd2'];
$pzthvd2 = 1*$_REQUEST['pzthvd2'];
$pzks3 = strip_tags($_REQUEST['pzks3']);
$pdrp3 = strip_tags($_REQUEST['pdrp3']);
$pdro3 = strip_tags($_REQUEST['pdro3']);
$pzpr3 = 1*$_REQUEST['pzpr3'];
$pzvd3 = 1*$_REQUEST['pzvd3'];
$pzthvd3 = 1*$_REQUEST['pzthvd3'];
$pzks4 = strip_tags($_REQUEST['pzks4']);
$pdrp4 = strip_tags($_REQUEST['pdrp4']);
$pdro4 = strip_tags($_REQUEST['pdro4']);
$pzpr4 = 1*$_REQUEST['pzpr4'];
$pzvd4 = 1*$_REQUEST['pzvd4'];
$pzthvd4 = 1*$_REQUEST['pzthvd4'];
$pzks5 = strip_tags($_REQUEST['pzks5']);
$pdrp5 = strip_tags($_REQUEST['pdrp5']);
$pdro5 = strip_tags($_REQUEST['pdro5']);
$pzpr5 = 1*$_REQUEST['pzpr5'];
$pzvd5 = 1*$_REQUEST['pzvd5'];
$pzthvd5 = 1*$_REQUEST['pzthvd5'];
$pzks6 = strip_tags($_REQUEST['pzks6']);
$pdrp6 = strip_tags($_REQUEST['pdrp6']);
$pdro6 = strip_tags($_REQUEST['pdro6']);
$pzpr6 = 1*$_REQUEST['pzpr6'];
$pzvd6 = 1*$_REQUEST['pzvd6'];
$pzthvd6 = 1*$_REQUEST['pzthvd6'];
$osob = strip_tags($_REQUEST['osob']);
$pril = 1*$_REQUEST['pril'];
$dat = $_REQUEST['dat'];
$datsql=Sqldatum($dat);
$zdbo = 1*$_REQUEST['zdbo'];
//$zrbo = 1*$_REQUEST['zrbo'];
$zpre = 1*$_REQUEST['zpre'];
$post = 1*$_REQUEST['post'];
$ucet = 1*$_REQUEST['ucet'];
$diban = strip_tags($_REQUEST['diban']);
//$dbic = strip_tags($_REQUEST['dbic']);
$uceb = strip_tags($_REQUEST['uceb']);
$numb = strip_tags($_REQUEST['numb']);
$da2 = $_REQUEST['da2'];
$da2sql=Sqldatum($da2);
//$zprp = 1*$_REQUEST['zprp'];
//$post2 = 1*$_REQUEST['post2'];
//$ucet2 = 1*$_REQUEST['ucet2'];
//$uceb2 = strip_tags($_REQUEST['uceb2']);
//$numb2 = strip_tags($_REQUEST['numb2']);
//$da3 = $_REQUEST['da3'];
//$da3sql=Sqldatum($da3);
//$pomv = $_REQUEST['pomv'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" pzks1='$pzks1', pdrp1='$pdrp1', pdro1='$pdro1', pzpr1='$pzpr1', pzvd1='$pzvd1', pzthvd1='$pzthvd1', ".
" pzks2='$pzks2', pdrp2='$pdrp2', pdro2='$pdro2', pzpr2='$pzpr2', pzvd2='$pzvd2', pzthvd2='$pzthvd2', ".
" pzks3='$pzks3', pdrp3='$pdrp3', pdro3='$pdro3', pzpr3='$pzpr3', pzvd3='$pzvd3', pzthvd3='$pzthvd3', ".
" pzks4='$pzks4', pdrp4='$pdrp4', pdro4='$pdro4', pzpr4='$pzpr4', pzvd4='$pzvd4', pzthvd4='$pzthvd4', ".
" pzks5='$pzks5', pdrp5='$pdrp5', pdro5='$pdro5', pzpr5='$pzpr5', pzvd5='$pzvd5', pzthvd5='$pzthvd5', ".
" pzks6='$pzks6', pdrp6='$pdrp6', pdro6='$pdro6', pzpr6='$pzpr6', pzvd6='$pzvd6', pzthvd6='$pzthvd6', ".
" uoso='$uoso', osob='$osob', pril='$pril', dat='$datsql', ".
" zdbo='$zdbo', zpre='$zpre', post='$post', ucet='$ucet', diban='$diban', uceb='$uceb', numb='$numb', da2='$da2sql' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 12 ) {
$sz1p1 = 1*$_REQUEST['sz1p1'];
$sz1v1 = 1*$_REQUEST['sz1v1'];
$sz2 = 1*$_REQUEST['sz2'];
$sz3 = 1*$_REQUEST['sz3'];
$sz4 = 1*$_REQUEST['sz4'];
$sz5 = 1*$_REQUEST['sz5'];
$sz6 = 1*$_REQUEST['sz6'];
$sz7 = 1*$_REQUEST['sz7'];
$sz8 = 1*$_REQUEST['sz8'];
$sz9 = 1*$_REQUEST['sz9'];
$sz10 = 1*$_REQUEST['sz10'];
$sz11 = 1*$_REQUEST['sz11'];
$sz12 = 1*$_REQUEST['sz12'];
$sz13 = 1*$_REQUEST['sz13'];
$sz14 = 1*$_REQUEST['sz14'];
$sz15 = 1*$_REQUEST['sz15'];
$sz16 = 1*$_REQUEST['sz16'];
$szdat = $_REQUEST['szdat'];
$szdatsql=Sqldatum($szdat);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" sz1p1='$sz1p1', sz1v1='$sz1v1', sz2='$sz2', sz3='$sz3', sz4='$sz4', sz5='$sz5', sz6='$sz6', sz7='$sz7', sz8='$sz8', sz9='$sz9', sz10='$sz10', ".
" sz11='$sz11', sz12='$sz12', sz13='$sz13', sz14='$sz14', sz15='$sz15', sz16='$sz16', szdat='$szdatsql' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 13 ) {
$pzs01 = 1*$_REQUEST['pzs01'];
$pzs02 = 1*$_REQUEST['pzs02'];
$pzd02 = 1*$_REQUEST['pzd02'];
$pzs03 = 1*$_REQUEST['pzs03'];
$pzd03 = 1*$_REQUEST['pzd03'];
$pzs04 = 1*$_REQUEST['pzs04'];
$pzd04 = 1*$_REQUEST['pzd04'];
$pzr05 = 1*$_REQUEST['pzr05'];
$pzr07 = 1*$_REQUEST['pzr07'];
$pzr08 = 1*$_REQUEST['pzr08'];
$pzr09 = 1*$_REQUEST['pzr09'];
$pzr10 = 1*$_REQUEST['pzr10'];
$pzr11 = 1*$_REQUEST['pzr11'];
$pzr12 = 1*$_REQUEST['pzr12'];
$pzr13 = 1*$_REQUEST['pzr13'];
$pzr14 = 1*$_REQUEST['pzr14'];
$pzr15 = 1*$_REQUEST['pzr15'];
$pzr16 = 1*$_REQUEST['pzr16'];
$pzdat = $_REQUEST['pzdat'];
$pzdatsql=Sqldatum($pzdat);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" pzs01='$pzs01', pzs02='$pzs02', pzd02='$pzd02', pzs03='$pzs03', pzd03='$pzd03', pzs04='$pzs04', pzd04='$pzd04', ".
" pzr05='$pzr05', pzr06='$pzr06', pzr07='$pzr07', pzr08='$pzr08', pzr09='$pzr09', pzr10='$pzr10', pzr11='$pzr11', ".
" pzr12='$pzr12', pzr13='$pzr13', pzr14='$pzr14', pzr15='$pzr15', pzr16='$pzr16', pzdat='$pzdatsql' ".
" WHERE oc = $cislo_oc";
                     }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "�DAJE NEBOLI UPRAVEN�" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//prac.subor a subor vytvorenych rocnych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT pocmes FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
     {
$sql = "SELECT oznucet FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdpriznanie_fob';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   cinnost      VARCHAR(80) NOT NULL,
   oznucet      INT DEFAULT 0,
   rdc          VARCHAR(6) NOT NULL,
   rdk          VARCHAR(4) NOT NULL,
   dar          DATE,
   dprie        VARCHAR(30) NOT NULL,
   dmeno        VARCHAR(30) NOT NULL,
   dtitl        VARCHAR(30) NOT NULL,
   duli         VARCHAR(30) NOT NULL,
   dcdm         VARCHAR(30) NOT NULL,
   dpsc         VARCHAR(30) NOT NULL,
   dmes         VARCHAR(30) NOT NULL,
   dtel         VARCHAR(30) NOT NULL,
   dfax         VARCHAR(30) NOT NULL,
   d2uli         VARCHAR(30) NOT NULL,
   d2cdm         VARCHAR(30) NOT NULL,
   d2psc         VARCHAR(30) NOT NULL,
   d2mes         VARCHAR(30) NOT NULL,
   d2tel         VARCHAR(30) NOT NULL,
   d2fax         VARCHAR(30) NOT NULL,
   d3uli         VARCHAR(30) NOT NULL,
   d3cdm         VARCHAR(30) NOT NULL,
   d3psc         VARCHAR(30) NOT NULL,
   d3mes         VARCHAR(30) NOT NULL,
   d3tel         VARCHAR(30) NOT NULL,
   d3fax         VARCHAR(30) NOT NULL,
   pruli         VARCHAR(35) NOT NULL,
   prcdm         VARCHAR(15) NOT NULL,
   prpsc         VARCHAR(10) NOT NULL,
   prmes         VARCHAR(35) NOT NULL,
   prtel         VARCHAR(20) NOT NULL,
   prfax         VARCHAR(20) NOT NULL,
   konx1        DECIMAL(10,0) DEFAULT 0,
   zrdc          VARCHAR(6) NOT NULL,
   zrdk          VARCHAR(4) NOT NULL,
   zprie        VARCHAR(30) NOT NULL,
   zmeno        VARCHAR(30) NOT NULL,
   ztitl        VARCHAR(30) NOT NULL,
   zuli         VARCHAR(30) NOT NULL,
   zcdm         VARCHAR(30) NOT NULL,
   zpsc         VARCHAR(30) NOT NULL,
   zmes         VARCHAR(30) NOT NULL,
   ztel         VARCHAR(30) NOT NULL,
   r28          DECIMAL(2,0) DEFAULT 0,
   r29          DECIMAL(2,0) DEFAULT 0,
   r32          DECIMAL(10,2) DEFAULT 0,
   r33a         DECIMAL(10,2) DEFAULT 0,
   r33b         DECIMAL(10,2) DEFAULT 0,
   mprie          VARCHAR(30) NOT NULL,
   mrod           VARCHAR(10) NOT NULL,
   mpri           DECIMAL(10,2) DEFAULT 0,
   mpom           DECIMAL(10,0) DEFAULT 0,
   d1prie          VARCHAR(30) NOT NULL,
   d1rod           VARCHAR(10) NOT NULL,
   d1pomc          DECIMAL(2,0) DEFAULT 0,
   d1pom1          DECIMAL(2,0) DEFAULT 0,
   d1pom2          DECIMAL(2,0) DEFAULT 0,
   d1pom3          DECIMAL(2,0) DEFAULT 0,
   d1pom4          DECIMAL(2,0) DEFAULT 0,
   d1pom5          DECIMAL(2,0) DEFAULT 0,
   d1pom6          DECIMAL(2,0) DEFAULT 0,
   d1pom7          DECIMAL(2,0) DEFAULT 0,
   d1pom8          DECIMAL(2,0) DEFAULT 0,
   d1pom9          DECIMAL(2,0) DEFAULT 0,
   d1pom10         DECIMAL(2,0) DEFAULT 0,
   d1pom11         DECIMAL(2,0) DEFAULT 0,
   d1pom12         DECIMAL(2,0) DEFAULT 0,
   d2prie          VARCHAR(30) NOT NULL,
   d2rod           VARCHAR(10) NOT NULL,
   d2pomc          DECIMAL(2,0) DEFAULT 0,
   d2pom1          DECIMAL(2,0) DEFAULT 0,
   d2pom2          DECIMAL(2,0) DEFAULT 0,
   d2pom3          DECIMAL(2,0) DEFAULT 0,
   d2pom4          DECIMAL(2,0) DEFAULT 0,
   d2pom5          DECIMAL(2,0) DEFAULT 0,
   d2pom6          DECIMAL(2,0) DEFAULT 0,
   d2pom7          DECIMAL(2,0) DEFAULT 0,
   d2pom8          DECIMAL(2,0) DEFAULT 0,
   d2pom9          DECIMAL(2,0) DEFAULT 0,
   d2pom10         DECIMAL(2,0) DEFAULT 0,
   d2pom11         DECIMAL(2,0) DEFAULT 0,
   d2pom12         DECIMAL(2,0) DEFAULT 0,
   d3prie          VARCHAR(30) NOT NULL,
   d3rod           VARCHAR(10) NOT NULL,
   d3pomc          DECIMAL(2,0) DEFAULT 0,
   d3pom1          DECIMAL(2,0) DEFAULT 0,
   d3pom2          DECIMAL(2,0) DEFAULT 0,
   d3pom3          DECIMAL(2,0) DEFAULT 0,
   d3pom4          DECIMAL(2,0) DEFAULT 0,
   d3pom5          DECIMAL(2,0) DEFAULT 0,
   d3pom6          DECIMAL(2,0) DEFAULT 0,
   d3pom7          DECIMAL(2,0) DEFAULT 0,
   d3pom8          DECIMAL(2,0) DEFAULT 0,
   d3pom9          DECIMAL(2,0) DEFAULT 0,
   d3pom10         DECIMAL(2,0) DEFAULT 0,
   d3pom11         DECIMAL(2,0) DEFAULT 0,
   d3pom12         DECIMAL(2,0) DEFAULT 0,
   d4prie          VARCHAR(30) NOT NULL,
   d4rod           VARCHAR(10) NOT NULL,
   d4pomc          DECIMAL(2,0) DEFAULT 0,
   d4pom1          DECIMAL(2,0) DEFAULT 0,
   d4pom2          DECIMAL(2,0) DEFAULT 0,
   d4pom3          DECIMAL(2,0) DEFAULT 0,
   d4pom4          DECIMAL(2,0) DEFAULT 0,
   d4pom5          DECIMAL(2,0) DEFAULT 0,
   d4pom6          DECIMAL(2,0) DEFAULT 0,
   d4pom7          DECIMAL(2,0) DEFAULT 0,
   d4pom8          DECIMAL(2,0) DEFAULT 0,
   d4pom9          DECIMAL(2,0) DEFAULT 0,
   d4pom10         DECIMAL(2,0) DEFAULT 0,
   d4pom11         DECIMAL(2,0) DEFAULT 0,
   d4pom12         DECIMAL(2,0) DEFAULT 0,
   upl5d           DECIMAL(2,0) DEFAULT 0,
   r34          DECIMAL(10,2) DEFAULT 0,
   r35          DECIMAL(10,2) DEFAULT 0,
   r36          DECIMAL(10,2) DEFAULT 0,
   r37          DECIMAL(10,2) DEFAULT 0,
   r38          DECIMAL(10,2) DEFAULT 0,
   r39          DECIMAL(10,2) DEFAULT 0,
   r40          DECIMAL(10,2) DEFAULT 0,
   r41          DECIMAL(10,2) DEFAULT 0,
   r42          DECIMAL(10,2) DEFAULT 0,
   r43          DECIMAL(10,2) DEFAULT 0,
   r44          DECIMAL(10,2) DEFAULT 0,
   r45          DECIMAL(10,2) DEFAULT 0,
   r46          DECIMAL(10,2) DEFAULT 0,
   r47          DECIMAL(10,2) DEFAULT 0,
   r48          DECIMAL(10,2) DEFAULT 0,
   r49          DECIMAL(10,2) DEFAULT 0,
   r50          DECIMAL(10,2) DEFAULT 0,
   r51          DECIMAL(10,2) DEFAULT 0,
   r52          DECIMAL(10,2) DEFAULT 0,
   r53          DECIMAL(10,2) DEFAULT 0,
   r54          DECIMAL(10,2) DEFAULT 0,
   r45a          DECIMAL(10,2) DEFAULT 0,
   r45b          DECIMAL(10,2) DEFAULT 0,
   r45c          DECIMAL(10,2) DEFAULT 0,
   r45d          DECIMAL(10,2) DEFAULT 0,
   r55          DECIMAL(10,2) DEFAULT 0,
   r56          DECIMAL(10,2) DEFAULT 0,
   r57          DECIMAL(10,2) DEFAULT 0,
   r58          DECIMAL(10,2) DEFAULT 0,
   r59          DECIMAL(10,2) DEFAULT 0,
   r60          DECIMAL(10,2) DEFAULT 0,
   r61          DECIMAL(10,2) DEFAULT 0,
   r62          DECIMAL(10,2) DEFAULT 0,
   r63          DECIMAL(10,2) DEFAULT 0,
   r64          DECIMAL(10,2) DEFAULT 0,
   r65          DECIMAL(10,2) DEFAULT 0,
   r66          DECIMAL(10,2) DEFAULT 0,
   r67          DECIMAL(10,2) DEFAULT 0,
   r68          DECIMAL(10,2) DEFAULT 0,
   r69          DECIMAL(10,2) DEFAULT 0,
   r70          DECIMAL(10,2) DEFAULT 0,
   pico         VARCHAR(10) NOT NULL,
   psid         VARCHAR(10) NOT NULL,
   pfor         VARCHAR(30) NOT NULL,
   pmen         VARCHAR(40) NOT NULL,
   upl50        DECIMAL(2,0) DEFAULT 0,
   puli         VARCHAR(30) NOT NULL,
   pcdm         VARCHAR(10) NOT NULL,
   pmes         VARCHAR(30) NOT NULL,
   ppsc         VARCHAR(10) NOT NULL,
   uoso         DECIMAL(2,0) DEFAULT 0,
   osob         TEXT,
   pril         DECIMAL(2,0) DEFAULT 0,
   dat          DATE,
   zdbo         DECIMAL(2,0) DEFAULT 0,
   zrbo         DECIMAL(2,0) DEFAULT 0,
   post         DECIMAL(2,0) DEFAULT 0,
   ucet         DECIMAL(2,0) DEFAULT 0,
   uceb         VARCHAR(30) NOT NULL,
   numb         VARCHAR(10) NOT NULL,
   da2          DATE,
   zpre         DECIMAL(2,0) DEFAULT 0,
   zprp         DECIMAL(2,0) DEFAULT 0,
   post2        DECIMAL(2,0) DEFAULT 0,
   ucet2        DECIMAL(2,0) DEFAULT 0,
   uceb2        VARCHAR(30) NOT NULL,
   numb2        VARCHAR(10) NOT NULL,
   da3          DATE,
   pomv         TEXT,
   px17          DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdpriznanie_fob'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie priznaniefob

$sql = "SELECT percsum FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY pmen VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD des6 DECIMAL(12,6) DEFAULT 0 AFTER pomv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD des2 DECIMAL(12,2) DEFAULT 0 AFTER pomv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r45b DECIMAL(2,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r29 DECIMAL(2,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r30 DECIMAL(10,2) DEFAULT 0 AFTER r29";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD perc1 DECIMAL(2,0) DEFAULT 0 AFTER r29";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD perc2 DECIMAL(2,0) DEFAULT 0 AFTER r29";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD percsum DECIMAL(10,2) DEFAULT 0 AFTER r29";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT t2p1 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT r112 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r113 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r112 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT t3p14 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v14 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v13 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v12 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p14 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p13 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p12 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p11 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT rr52 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr56 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr55 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr54 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr53 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr52 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT r111 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r70 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r71 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r72 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r73 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r74 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r75 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r76 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r77 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r78 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r79 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r80 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r81 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r82 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r83 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r84 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r85 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r86 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r87 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r88 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r89 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r90 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r91 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r92 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r93 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r94 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r95 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r96 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r97 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r98 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r99 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r100 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r101 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r102 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r103 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r104 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r105 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r106 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r107 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r108 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r109 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r110 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r111 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT xstat FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD xstat VARCHAR(30) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT sdnr FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sdnr VARCHAR(30) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD udnr DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ldnr DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT perc3 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD perc3 DECIMAL(2,0) DEFAULT 0 AFTER r29";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT pocmes FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r35b DECIMAL(10,2) DEFAULT 0 AFTER r35";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r35a DECIMAL(10,2) DEFAULT 0 AFTER r35";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzp63 DECIMAL(10,2) DEFAULT 0 AFTER t1v11";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzp6 DECIMAL(10,2) DEFAULT 0 AFTER t1v11";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD psp6 DECIMAL(10,2) DEFAULT 0 AFTER t1v11";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pocmes DECIMAL(4,0) DEFAULT 0 AFTER t1v11";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT r124 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r124 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r123 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r122 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r121 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r120 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r119 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r118 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r117 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r116 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r115 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r114 DECIMAL(10,2) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT rr59 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr65 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr64 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr63 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr62 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr61 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr60 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr59 DECIMAL(4,0) DEFAULT 0 AFTER r59";
$vysledek = mysql_query("$sql");
}
     }

$sql = "SELECT ddp FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prp DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD zstat VARCHAR(30) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r33 DECIMAL(4,0) DEFAULT 0 AFTER r113";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD nrz DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ddp DATE NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT prfax FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pruli VARCHAR(35) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prcdm VARCHAR(15) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpsc VARCHAR(10) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prmes VARCHAR(35) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prtel VARCHAR(20) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prfax VARCHAR(20) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT szdat FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r34a DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p12 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v12 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD perc4 DECIMAL(2,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD perc0 DECIMAL(2,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD nrzsprev DECIMAL(2,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD spl3d DECIMAL(2,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz1p1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz1v1 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz2 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz3 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz4 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz5 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz6 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz7 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz8 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz9 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz10 DECIMAL(10,2) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD szdat DATE NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
}

//zmeny pre rok 2013
$sql = "SELECT pzs01 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD new2013 DECIMAL(2,0) NOT NULL AFTER px17";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz11 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz12 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz13 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz14 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r127 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r126 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r125 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p13 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2p12 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v11 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v12 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t2v11 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1bk1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1bk2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1bz1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1bz2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ak1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ak2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ak3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ak4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ak5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1az1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1az2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1az3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1az4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1az5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr66 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr67 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr68 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr69 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD rr70 DECIMAL(4,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r35b DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r35a DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks4 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp4 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro4 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks3 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp3 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro3 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks2 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp2 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro2 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks1 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp1 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro1 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ztitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD dmailfax VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD diban VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD dbic VARCHAR(15) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzdat DATE NOT NULL AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr16 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr15 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr14 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr13 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr12 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr11 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr10 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr09 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr08 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr07 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr06 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzr05 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzd04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzd03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzd02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzs04 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzs03 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzs02 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzs01 DECIMAL(10,2) DEFAULT 0 AFTER dbic";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT dtitz FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD dtitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT sz16 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1cz1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ck1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1cz2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ck2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1cz3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ck3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1cz4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ck4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1cz5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1ck5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks5 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp5 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro5 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzks6 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrp6 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdro6 VARCHAR(3) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzpr6 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzvd6 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz15 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD sz16 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT pzthvd6 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd4 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd5 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pzthvd6 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
}
//koniec uprav def. tabulky

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre rocne vytvor pracovny subor
if ( $subor == 1 )
{
//zober data z kun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  $prie=$riaddok->prie;
  $titl=$riaddok->titl;
  $zuli=$riaddok->zuli;
  $zcdm=$riaddok->zcdm;
  $zpsc=$riaddok->zpsc;
  $zmes=$riaddok->zmes;
  $ztel=$riaddok->ztel;
  $rdc=$riaddok->rdc;
  $rdk=$riaddok->rdk;
  $dar=$riaddok->dar;
  }

$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" ( druh,oc,dmeno,dprie,dtitl,rdc,rdk,dar,duli,dcdm,dpsc,dmes,dtel ) VALUES ".
" ( 1, '$cislo_oc', '$meno', '$prie', '$titl', '$rdc', '$rdk', '$dar', '$zuli', '$zcdm', '$zpsc', '$zmes', '$ztel' )";
$ttqq = mysql_query("$ttvv");

//uloz do priznania
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdpriznanie_fob".
" SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  if ( $nasielvyplnene == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r00z2='$xr00z2', r00a2='$xr00a2', r04a2='$xr04a2', r04b='$xr04b', ".
" r04c2='$xr04c2', r04d='$xr04d', r04e='$xr04e', r11b='$xr11b', r14b='$xr14b', r15b='$xr15b', vyk='$xvyk'  WHERE oc = $cislo_oc ";
//echo $sqtoz;
//$oznac = mysql_query("$sqtoz");
  }
}
//koniec pracovneho suboru pre rocne 


//ak z androidu nacitaj prijmy a vydavky z vykazu o prijmoch a vydavkoch
if( $nacitajpav == 1 ) { $naccx=1; }
if( $zandroidu == 1 ) { $naccx=1; }
if( $naccx == 1 )
    {

$sql = "SELECT * FROM F$kli_vxcf"."_prcvprivyds".$kli_uzid." WHERE prx = 1 ";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prijmy=$riaddok->r04;
  $vydavky=$riaddok->r11;
  $poistne=$riaddok->r08;

  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1p2='$prijmy', t1v2='$vydavky', psp6='$poistne' WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


$prepocitaj=1;
    }
//koniec ak z androidu nacitaj prijmy a vydavky z vykazu o prijmoch a vydavkoch

$miliondan = 1*$_REQUEST['miliondan'];
if ( $miliondan == 1 ) { $prepocitaj=1; }
if ( $namanzelku == 1 ) { $prepocitaj=1; }

//vsetky vypocty su upravene na rok 2013
//vypocty
$alertprepocet="";
if ( ( $copern == 10 OR $copern == 20 ) AND $prepocitaj == 1 )
{
$alertprepocet="!!! Prepo��tavam hodnoty v riadkoch !!!";

//zaklady dane zo zav.cinnosti 2013 str2
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r36=r34-r35 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 1.(na str3) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1p9=t1p1+t1p2+t1p3+t1p4+t1p5+t1p6+t1p7+t1p8 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1v9=t1v1+t1v2+t1v3+t1v4+t1v5+t1v6+t1v7+t1v8 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1p12=t1p10+t1p11  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1v12=t1v10+t1v11  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r37=t1p9, r38=t1v9, r39=0, r40=0, r43=0, r44=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r39=r37-r38 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r40=-r39, r39=0 WHERE oc = $cislo_oc AND r39 < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r43=r39-r40+r41-r42 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r44=-r43, r43=0 WHERE oc = $cislo_oc AND r43 < 0";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 1.(na str3) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r45=t1p12, r46=t1v12, r47=0, r48=0, r51=0, r52=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r47=r45-r46, r48=0, r49=0, r52=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r48=r47, r49=0 WHERE oc = $cislo_oc AND r47 > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r49=r47, r48=0 WHERE oc = $cislo_oc AND r47 < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r52=r47+r50-r51 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r52=0 WHERE oc = $cislo_oc AND r52 < 0";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 2.(na str 5) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t2p12=t2p1+t2p2+t2p3+t2p4+t2p5+t2p6+t2p7+t2p8+t2p9+t2p10+t2p11 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t2v12=t2v1+t2v2+t2v3+t2v4+t2v5+t2v6+t2v7+t2v8+t2v9+t2v10+t2v11 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r53=t2p12, r54=t2v12, r55=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r55=r53-r54 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r55=0 WHERE oc = $cislo_oc AND r55 < 0";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 3.(na str6) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3p14=t3p1+t3p2+t3p3+t3p4+t3p5+t3p6+t3p7+t3p8+t3p9+t3p10+t3p11+t3p12+t3p13 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3v14=t3v1+t3v2+t3v3+t3v4+t3v5+t3v6+t3v7+t3v8+t3v9+t3v10+t3v11+t3v12 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r56=t3p14, r57=t3v14, r58=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r58=r56-r57 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//odpocet danovej straty (str 7) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r63=r59+r60+r61+r62 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vypocet zakladu dane str7 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=0, r66=0, r67=0, r68=0, r70=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=r43  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r66=r63+r64  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r66=r65  WHERE oc = $cislo_oc AND r66 > r65";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r67=r65-r66 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r68=r52+r55+r58 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r70=r68-r69 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//zaklad dane  a odpocitatelne (str 8) 2013 vypocitaj odpocitatelnu na danovnika a manzelku na kliknutie ( milionarska dan)
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r72=r36+r67  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

if ( $miliondan == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//max.nezdanitelna cast na danovnika za 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=3735.94 WHERE oc = $cislo_oc  ";
$oznac = mysql_query("$sqtoz");

//milionarska dan 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=8600.436-(r72/4) WHERE oc = $cislo_oc AND r72 > 19458 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, des2=ceil(des2), r73=des2/100  WHERE oc = $cislo_oc AND r72 > 19458 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=0 WHERE oc = $cislo_oc AND r73 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=0 WHERE oc = $cislo_oc AND r72 >= 34401.75 ";
$oznac = mysql_query("$sqtoz");
     }
//koniec max.nezdanitelna cast na danovnika za 2013

if ( $namanzelku == 1 )
     {
//nezdanitelna cast na manzelku 2013 nedam ju tam lebo sa neda vynulovat
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r74=3735.94-mpri WHERE oc = $cislo_oc AND r72 <= 34401.74 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=12336.372-(r72/4) WHERE oc = $cislo_oc AND r72 > 34401.74 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, des2=ceil(des2), r74=des2/100  WHERE oc = $cislo_oc AND r72 > 34401.74 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r74=0 WHERE oc = $cislo_oc AND r74 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r74=0 WHERE oc = $cislo_oc AND r72 >= 49345.49 ";
$oznac = mysql_query("$sqtoz");
     }
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r76=r73+r74+r75  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vypocet zakladu dane (str 8) 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=r72-r76 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=0 WHERE oc = $cislo_oc AND r77 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=r77+r70+r71 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=0 WHERE oc = $cislo_oc AND r78 < 0 ";
$oznac = mysql_query("$sqtoz");

//dan z prijmu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=r78*19/100 WHERE oc = $cislo_oc AND r78 <= 34401.75 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=(34401.75*19/100)+((r78-34401.75)*25/100) WHERE oc = $cislo_oc AND r78 > 34401.75 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, r79=floor(des2), r79=r79/100 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r88=r79 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan po vynati prijmov 2013 dan o zakladu na r81 nepocitam
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r81=r78-r80 WHERE oc = $cislo_oc AND r80 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r81=0 WHERE oc = $cislo_oc AND r81 < 0 ";
$oznac = mysql_query("$sqtoz");

//dan po vynati prijmov a zapocte 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r88=r82-r87 WHERE oc = $cislo_oc AND r81 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r88=r79-r87 WHERE oc = $cislo_oc AND r81 = 0 ";
$oznac = mysql_query("$sqtoz");

//dan celkom 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r92=r88-r91 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vynuluj zuctovanie bonusu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r94=0, r96=0, r97=0, r98=0, r106=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan znizena o dan. bonusu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r94=r92-r93 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r94=0 WHERE oc = $cislo_oc AND r94 < 0 ";
$oznac = mysql_query("$sqtoz");

//vysporiadanie danoveho bonusu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r96=r93-r95  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r96=0 WHERE oc = $cislo_oc AND r96 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r97=r96-r92  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r97=0 WHERE oc = $cislo_oc AND r97 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r98=r95-r93  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r98=0 WHERE oc = $cislo_oc AND r98 < 0 ";
$oznac = mysql_query("$sqtoz");

//zapl.dan z urok.prijmov 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r106=r90-r91  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan na uhradu, preplatok 2012
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r109=0, r108=r92-r93+r95+r97+r99-r100-r101-r102-r103-r104-r105-r106+r107 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r109=-r108, r108=0 WHERE oc = $cislo_oc AND r108 < 0 ";
$oznac = mysql_query("$sqtoz");

//str12 osobny asistenti 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET sz6=sz2-sz3+sz4-sz5, sz7=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET sz7=-sz6, sz6=0  WHERE oc = $cislo_oc AND sz6 < 0 ";
$oznac = mysql_query("$sqtoz");

$estenie=1;
if ( $estenie == 0 )
   {
   }
}
//koniec nove vypocty

//ked idem z menu dan z prijmu neprepocita ale nasledne ked ulozim tak prepocita
if ( $prepocitaj == 101 ) { $prepocitaj=1; }

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = $cislo_oc AND konx1 = 0 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$dar = $fir_riadok->dar;
$darsk=SkDatum($dar);
$druh = $fir_riadok->druh;
$ddp = $fir_riadok->ddp;
$ddpsk=SkDatum($ddp);
$cinnost = $fir_riadok->cinnost;
$dprie = $fir_riadok->dprie;
$dmeno = $fir_riadok->dmeno;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dpsc = $fir_riadok->dpsc;
$dmes = $fir_riadok->dmes;
$xstat = $fir_riadok->xstat;
$nrz = $fir_riadok->nrz;
$prp = $fir_riadok->prp;
$d2uli = $fir_riadok->d2uli;
$d2cdm = $fir_riadok->d2cdm;
$d2psc = $fir_riadok->d2psc;
$d2mes = $fir_riadok->d2mes;
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
$dtel = $fir_riadok->dtel;
$dmailfax = $fir_riadok->dmailfax;

if ( $strana == 2 ) {
$r29 = $fir_riadok->r29;
$r30 = $fir_riadok->r30;
$mprie = $fir_riadok->mprie;
$mrod = $fir_riadok->mrod;
$mpri = $fir_riadok->mpri;
$mpom = $fir_riadok->mpom;
$d1prie = $fir_riadok->d1prie;
$d1rod = $fir_riadok->d1rod;
$d1pomc = $fir_riadok->d1pomc;
$d1pom1 = $fir_riadok->d1pom1;
$d1pom2 = $fir_riadok->d1pom2;
$d1pom3 = $fir_riadok->d1pom3;
$d1pom4 = $fir_riadok->d1pom4;
$d1pom5 = $fir_riadok->d1pom5;
$d1pom6 = $fir_riadok->d1pom6;
$d1pom7 = $fir_riadok->d1pom7;
$d1pom8 = $fir_riadok->d1pom8;
$d1pom9 = $fir_riadok->d1pom9;
$d1pom10 = $fir_riadok->d1pom10;
$d1pom11 = $fir_riadok->d1pom11;
$d1pom12 = $fir_riadok->d1pom12;
$d2prie = $fir_riadok->d2prie;
$d2rod = $fir_riadok->d2rod;
$d2pomc = $fir_riadok->d2pomc;
$d2pom1 = $fir_riadok->d2pom1;
$d2pom2 = $fir_riadok->d2pom2;
$d2pom3 = $fir_riadok->d2pom3;
$d2pom4 = $fir_riadok->d2pom4;
$d2pom5 = $fir_riadok->d2pom5;
$d2pom6 = $fir_riadok->d2pom6;
$d2pom7 = $fir_riadok->d2pom7;
$d2pom8 = $fir_riadok->d2pom8;
$d2pom9 = $fir_riadok->d2pom9;
$d2pom10 = $fir_riadok->d2pom10;
$d2pom11 = $fir_riadok->d2pom11;
$d2pom12 = $fir_riadok->d2pom12;
$d3prie = $fir_riadok->d3prie;
$d3rod = $fir_riadok->d3rod;
$d3pomc = $fir_riadok->d3pomc;
$d3pom1 = $fir_riadok->d3pom1;
$d3pom2 = $fir_riadok->d3pom2;
$d3pom3 = $fir_riadok->d3pom3;
$d3pom4 = $fir_riadok->d3pom4;
$d3pom5 = $fir_riadok->d3pom5;
$d3pom6 = $fir_riadok->d3pom6;
$d3pom7 = $fir_riadok->d3pom7;
$d3pom8 = $fir_riadok->d3pom8;
$d3pom9 = $fir_riadok->d3pom9;
$d3pom10 = $fir_riadok->d3pom10;
$d3pom11 = $fir_riadok->d3pom11;
$d3pom12 = $fir_riadok->d3pom12;
$d4prie = $fir_riadok->d4prie;
$d4rod = $fir_riadok->d4rod;
$d4pomc = $fir_riadok->d4pomc;
$d4pom1 = $fir_riadok->d4pom1;
$d4pom2 = $fir_riadok->d4pom2;
$d4pom3 = $fir_riadok->d4pom3;
$d4pom4 = $fir_riadok->d4pom4;
$d4pom5 = $fir_riadok->d4pom5;
$d4pom6 = $fir_riadok->d4pom6;
$d4pom7 = $fir_riadok->d4pom7;
$d4pom8 = $fir_riadok->d4pom8;
$d4pom9 = $fir_riadok->d4pom9;
$d4pom10 = $fir_riadok->d4pom10;
$d4pom11 = $fir_riadok->d4pom11;
$d4pom12 = $fir_riadok->d4pom12;
$r33 = $fir_riadok->r33;
$r34 = $fir_riadok->r34;
$r34a = $fir_riadok->r34a;
$r35 = $fir_riadok->r35;
$r36 = $fir_riadok->r36;
                    }

if ( $strana == 3 ) {
$t1p1 = $fir_riadok->t1p1;
$t1v1 = $fir_riadok->t1v1;
$t1p2 = $fir_riadok->t1p2;
$t1v2 = $fir_riadok->t1v2;
$t1p3 = $fir_riadok->t1p3;
$t1v3 = $fir_riadok->t1v3;
$t1p4 = $fir_riadok->t1p4;
$t1v4 = $fir_riadok->t1v4;
$t1p5 = $fir_riadok->t1p5;
$t1v5 = $fir_riadok->t1v5;
$t1p6 = $fir_riadok->t1p6;
$t1v6 = $fir_riadok->t1v6;
$t1p7 = $fir_riadok->t1p7;
$t1v7 = $fir_riadok->t1v7;
$t1p8 = $fir_riadok->t1p8;
$t1v8 = $fir_riadok->t1v8;
$t1p9 = $fir_riadok->t1p9;
$t1v9 = $fir_riadok->t1v9;
$t1p10 = $fir_riadok->t1p10;
$t1v10 = $fir_riadok->t1v10;
$t1p11 = $fir_riadok->t1p11;
$t1v11 = $fir_riadok->t1v11;
$t1p12 = $fir_riadok->t1p12;
$t1v12 = $fir_riadok->t1v12;
$perc0 = $fir_riadok->perc0;
$perc1 = $fir_riadok->perc1;
$perc3 = $fir_riadok->perc3;
$perc4 = $fir_riadok->perc4;
$psp6 = $fir_riadok->psp6;
$t1az1 = $fir_riadok->t1az1;
$t1az2 = $fir_riadok->t1az2;
$t1az3 = $fir_riadok->t1az3;
$t1az4 = $fir_riadok->t1az4;
$t1az5 = $fir_riadok->t1az5;
$t1ak1 = $fir_riadok->t1ak1;
$t1ak2 = $fir_riadok->t1ak2;
$t1ak3 = $fir_riadok->t1ak3;
$t1ak4 = $fir_riadok->t1ak4;
$t1ak5 = $fir_riadok->t1ak5;
$t1bz1 = $fir_riadok->t1bz1;
$t1bz2 = $fir_riadok->t1bz2;
$t1bk1 = $fir_riadok->t1bk1;
$t1bk2 = $fir_riadok->t1bk2;
                    }

if ( $strana == 4 ) {
$t1cz1 = $fir_riadok->t1cz1;
$t1ck1 = $fir_riadok->t1ck1;
$t1cz2 = $fir_riadok->t1cz2;
$t1ck2 = $fir_riadok->t1ck2;
$t1cz3 = $fir_riadok->t1cz3;
$t1ck3 = $fir_riadok->t1ck3;
$t1cz4 = $fir_riadok->t1cz4;
$t1ck4 = $fir_riadok->t1ck4;
$t1cz5 = $fir_riadok->t1cz5;
$t1ck5 = $fir_riadok->t1ck5;
$r37 = $fir_riadok->r37;
$r38 = $fir_riadok->r38;
$r39 = $fir_riadok->r39;
$r40 = $fir_riadok->r40;
$r41 = $fir_riadok->r41;
$r42 = $fir_riadok->r42;
$r43 = $fir_riadok->r43;
$r44 = $fir_riadok->r44;
$r45 = $fir_riadok->r45;
$r46 = $fir_riadok->r46;
$r47 = $fir_riadok->r47;
$r48 = $fir_riadok->r48;
                    }

if ( $strana == 5 ) {
$r49 = $fir_riadok->r49;
$r50 = $fir_riadok->r50;
$r51 = $fir_riadok->r51;
$r52 = $fir_riadok->r52;
$t2p1 = $fir_riadok->t2p1;
$t2p2 = $fir_riadok->t2p2;
$t2p3 = $fir_riadok->t2p3;
$t2p4 = $fir_riadok->t2p4;
$t2p5 = $fir_riadok->t2p5;
$t2p6 = $fir_riadok->t2p6;
$t2p7 = $fir_riadok->t2p7;
$t2p8 = $fir_riadok->t2p8;
$t2p9 = $fir_riadok->t2p9;
$t2p10 = $fir_riadok->t2p10;
$t2p11 = $fir_riadok->t2p11;
$t2p12 = $fir_riadok->t2p12;
$t2p13 = $fir_riadok->t2p13;
$t2v1 = $fir_riadok->t2v1;
$t2v2 = $fir_riadok->t2v2;
$t2v3 = $fir_riadok->t2v3;
$t2v4 = $fir_riadok->t2v4;
$t2v5 = $fir_riadok->t2v5;
$t2v6 = $fir_riadok->t2v6;
$t2v7 = $fir_riadok->t2v7;
$t2v8 = $fir_riadok->t2v8;
$t2v9 = $fir_riadok->t2v9;
$t2v10 = $fir_riadok->t2v10;
$t2v11 = $fir_riadok->t2v11;
$t2v12 = $fir_riadok->t2v12;
                    }

if ( $strana == 6 ) {
$r53 = $fir_riadok->r53;
$r54 = $fir_riadok->r54;
$r55 = $fir_riadok->r55;
$t3p1 = $fir_riadok->t3p1;
$t3p2 = $fir_riadok->t3p2;
$t3p3 = $fir_riadok->t3p3;
$t3p4 = $fir_riadok->t3p4;
$t3p5 = $fir_riadok->t3p5;
$t3p6 = $fir_riadok->t3p6;
$t3p7 = $fir_riadok->t3p7;
$t3p8 = $fir_riadok->t3p8;
$t3p9 = $fir_riadok->t3p9;
$t3p10 = $fir_riadok->t3p10;
$t3p11 = $fir_riadok->t3p11;
$t3p12 = $fir_riadok->t3p12;
$t3p13 = $fir_riadok->t3p13;
$t3p14 = $fir_riadok->t3p14;
$t3v1 = $fir_riadok->t3v1;
$t3v2 = $fir_riadok->t3v2;
$t3v3 = $fir_riadok->t3v3;
$t3v4 = $fir_riadok->t3v4;
$t3v5 = $fir_riadok->t3v5;
$t3v6 = $fir_riadok->t3v6;
$t3v7 = $fir_riadok->t3v7;
$t3v8 = $fir_riadok->t3v8;
$t3v9 = $fir_riadok->t3v9;
$t3v10 = $fir_riadok->t3v10;
$t3v11 = $fir_riadok->t3v11;
$t3v12 = $fir_riadok->t3v12;
$t3v14 = $fir_riadok->t3v14;
                    }

if ( $strana == 7 ) {
$r56 = $fir_riadok->r56;
$r57 = $fir_riadok->r57;
$r58 = $fir_riadok->r58;
$r59 = $fir_riadok->r59;
$r60 = $fir_riadok->r60;
$r61 = $fir_riadok->r61;
$r62 = $fir_riadok->r62;
$r63 = $fir_riadok->r63;
$rr59 = $fir_riadok->rr59;
$rr60 = $fir_riadok->rr60;
$rr61 = $fir_riadok->rr61;
$rr62 = $fir_riadok->rr62;
$r64 = $fir_riadok->r64;
$r65 = $fir_riadok->r65;
$r66 = $fir_riadok->r66;
$r67 = $fir_riadok->r67;
$r68 = $fir_riadok->r68;
$r69 = $fir_riadok->r69;
$r70 = $fir_riadok->r70;
$r71 = $fir_riadok->r71;
                    }

if ( $strana == 8 ) {
$r72 = $fir_riadok->r72;
$r73 = $fir_riadok->r73;
$r74 = $fir_riadok->r74;
$r75 = $fir_riadok->r75;
$r76 = $fir_riadok->r76;
$r77 = $fir_riadok->r77;
$r78 = $fir_riadok->r78;
$r79 = $fir_riadok->r79;
$r80 = $fir_riadok->r80;
$r81 = $fir_riadok->r81;
$r82 = $fir_riadok->r82;
$r83 = $fir_riadok->r83;
$r84 = $fir_riadok->r84;
$r85 = $fir_riadok->r85;
$r86 = $fir_riadok->r86;
$r87 = $fir_riadok->r87;
$r88 = $fir_riadok->r88;
$r89 = $fir_riadok->r89;
$r90 = $fir_riadok->r90;
$r91 = $fir_riadok->r91;
$r92 = $fir_riadok->r92;
$r93 = $fir_riadok->r93;
$r94 = $fir_riadok->r94;
$r95 = $fir_riadok->r95;
                    }

if ( $strana == 9 ) {
$r96 = $fir_riadok->r96;
$r97 = $fir_riadok->r97;
$r98 = $fir_riadok->r98;
$r99 = $fir_riadok->r99;
$r100 = $fir_riadok->r100;
$r101 = $fir_riadok->r101;
$r102 = $fir_riadok->r102;
$r103 = $fir_riadok->r103;
$r104 = $fir_riadok->r104;
$r105 = $fir_riadok->r105;
$r106 = $fir_riadok->r106;
$r107 = $fir_riadok->r107;
$r108 = $fir_riadok->r108;
$r109 = $fir_riadok->r109;
                    }

if ( $strana == 10 ) {
$r110 = $fir_riadok->r110;
$r111 = $fir_riadok->r111;
$r112 = $fir_riadok->r112;
$r113 = $fir_riadok->r113;
$r114 = $fir_riadok->r114;
$r115 = $fir_riadok->r115;
$r117 = $fir_riadok->r117;
$sdnr = $fir_riadok->sdnr;
$ldnr = $fir_riadok->ldnr;
$nrzsprev = $fir_riadok->nrzsprev;
$upl50 = $fir_riadok->upl50;
$spld3d = $fir_riadok->spl3d;
$r120 = $fir_riadok->r120;
$pico = $fir_riadok->pico;
$psid = $fir_riadok->psid;
$pfor = $fir_riadok->pfor;
$pmen = $fir_riadok->pmen;
$puli = $fir_riadok->puli;
$pcdm = $fir_riadok->pcdm;
$ppsc = $fir_riadok->ppsc;
$pmes = $fir_riadok->pmes;
                     }

if ( $strana == 11 ) {
$uoso = $fir_riadok->uoso;
$pzks1 = $fir_riadok->pzks1;
$pdrp1 = $fir_riadok->pdrp1;
$pdro1 = $fir_riadok->pdro1;
$pzpr1 = $fir_riadok->pzpr1;
$pzvd1 = $fir_riadok->pzvd1;
$pzthvd1 = $fir_riadok->pzthvd1;
$pzks2 = $fir_riadok->pzks2;
$pdrp2 = $fir_riadok->pdrp2;
$pdro2 = $fir_riadok->pdro2;
$pzpr2 = $fir_riadok->pzpr2;
$pzvd2 = $fir_riadok->pzvd2;
$pzthvd2 = $fir_riadok->pzthvd2;
$pzks3 = $fir_riadok->pzks3;
$pdrp3 = $fir_riadok->pdrp3;
$pdro3 = $fir_riadok->pdro3;
$pzpr3 = $fir_riadok->pzpr3;
$pzvd3 = $fir_riadok->pzvd3;
$pzthvd3 = $fir_riadok->pzthvd3;
$pzks4 = $fir_riadok->pzks4;
$pdrp4 = $fir_riadok->pdrp4;
$pdro4 = $fir_riadok->pdro4;
$pzpr4 = $fir_riadok->pzpr4;
$pzvd4 = $fir_riadok->pzvd4;
$pzthvd4 = $fir_riadok->pzthvd4;
$pzks5 = $fir_riadok->pzks5;
$pdrp5 = $fir_riadok->pdrp5;
$pdro5 = $fir_riadok->pdro5;
$pzpr5 = $fir_riadok->pzpr5;
$pzvd5 = $fir_riadok->pzvd5;
$pzthvd5 = $fir_riadok->pzthvd5;
$pzks6 = $fir_riadok->pzks6;
$pdrp6 = $fir_riadok->pdrp6;
$pdro6 = $fir_riadok->pdro6;
$pzpr6 = $fir_riadok->pzpr6;
$pzvd6 = $fir_riadok->pzvd6;
$pzthvd6 = $fir_riadok->pzthvd6;
$osob = $fir_riadok->osob;
$pril = $fir_riadok->pril;
$dat = $fir_riadok->dat;
$datsk=Skdatum($dat);
$zdbo = $fir_riadok->zdbo;
$zpre = $fir_riadok->zpre;
$post = $fir_riadok->post;
$ucet = $fir_riadok->ucet;
$diban = $fir_riadok->diban;
$uceb = $fir_riadok->uceb;
$numb = $fir_riadok->numb;
$da2 = $fir_riadok->da2;
$da2sk=Skdatum($da2);
                     }

if ( $strana == 12 ) {
$sz1p1 = $fir_riadok->sz1p1;
$sz1v1 = $fir_riadok->sz1v1;
$sz2 = $fir_riadok->sz2;
$sz3 = $fir_riadok->sz3;
$sz4 = $fir_riadok->sz4;
$sz5 = $fir_riadok->sz5;
$sz6 = $fir_riadok->sz6;
$sz7 = $fir_riadok->sz7;
$sz8 = $fir_riadok->sz8;
$sz9 = $fir_riadok->sz9;
$sz10 = $fir_riadok->sz10;
$sz11 = $fir_riadok->sz11;
$sz12 = $fir_riadok->sz12;
$sz13 = $fir_riadok->sz13;
$sz14 = $fir_riadok->sz14;
$sz15 = $fir_riadok->sz15;
$sz16 = $fir_riadok->sz16;
$szdat = $fir_riadok->szdat;
$szdatsk=Skdatum($szdat);
                     }

if ( $strana == 13 ) {
$pzs01 = $fir_riadok->pzs01;
$pzs02 = $fir_riadok->pzs02;
$pzd02 = $fir_riadok->pzd02;
$pzs03 = $fir_riadok->pzs03;
$pzd03 = $fir_riadok->pzd03;
$pzs04 = $fir_riadok->pzs04;
$pzd04 = $fir_riadok->pzd04;
$pzr05 = $fir_riadok->pzr05;
$pzr07 = $fir_riadok->pzr07;
$pzr08 = $fir_riadok->pzr08;
$pzr09 = $fir_riadok->pzr09;
$pzr10 = $fir_riadok->pzr10;
$pzr11 = $fir_riadok->pzr11;
$pzr12 = $fir_riadok->pzr12;
$pzr13 = $fir_riadok->pzr13;
$pzr14 = $fir_riadok->pzr14;
$pzr15 = $fir_riadok->pzr15;
$pzr16 = $fir_riadok->pzr16;
$pzdat = $fir_riadok->pzdat;
$pzdatsk=Skdatum($pzdat);
                     }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Da� z pr�jmov FOB</title>
<script>
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
   document.formv1.dar.value = '<?php echo "$darsk";?>';
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.ddp.value = '<?php echo "$ddpsk";?>';
   document.formv1.cinnost.value = '<?php echo "$cinnost";?>';
   document.formv1.dprie.value = '<?php echo "$dprie";?>';
   document.formv1.dmeno.value = '<?php echo "$dmeno";?>';
   document.formv1.dtitl.value = '<?php echo "$dtitl";?>';
   document.formv1.dtitz.value = '<?php echo "$dtitz";?>';
   document.formv1.duli.value = '<?php echo "$duli";?>';
   document.formv1.dcdm.value = '<?php echo "$dcdm";?>';
   document.formv1.dpsc.value = '<?php echo "$dpsc";?>';
   document.formv1.dmes.value = '<?php echo "$dmes";?>';
   document.formv1.xstat.value = '<?php echo "$xstat";?>';
<?php if ( $nrz == 1 ) { ?> document.formv1.nrz.checked = "checked"; <?php } ?>
<?php if ( $prp == 1 ) { ?> document.formv1.prp.checked = "checked"; <?php } ?>
   document.formv1.d2uli.value = '<?php echo "$d2uli";?>';
   document.formv1.d2cdm.value = '<?php echo "$d2cdm";?>';
   document.formv1.d2psc.value = '<?php echo "$d2psc";?>';
   document.formv1.d2mes.value = '<?php echo "$d2mes";?>';
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
   document.formv1.dtel.value = '<?php echo "$dtel";?>';
   document.formv1.dmailfax.value = '<?php echo "$dmailfax";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.r30.value = '<?php echo "$r30";?>';
<?php if ( $r29 == 1 ) { ?> document.formv1.r29.checked = "checked"; <?php } ?>
   document.formv1.mprie.value = '<?php echo "$mprie";?>';
   document.formv1.mrod.value = '<?php echo "$mrod";?>';
   document.formv1.mpri.value = '<?php echo "$mpri";?>';
   document.formv1.mpom.value = '<?php echo "$mpom";?>';
   document.formv1.d1prie.value = '<?php echo "$d1prie";?>';
   document.formv1.d1rod.value = '<?php echo "$d1rod";?>';
<?php if ( $d1pomc == 1 ) { ?> document.formv1.d1pomc.checked = "checked"; <?php } ?>
<?php if ( $d1pom1 == 1 ) { ?> document.formv1.d1pom1.checked = "checked"; <?php } ?>
<?php if ( $d1pom2 == 1 ) { ?> document.formv1.d1pom2.checked = "checked"; <?php } ?>
<?php if ( $d1pom3 == 1 ) { ?> document.formv1.d1pom3.checked = "checked"; <?php } ?>
<?php if ( $d1pom4 == 1 ) { ?> document.formv1.d1pom4.checked = "checked"; <?php } ?>
<?php if ( $d1pom5 == 1 ) { ?> document.formv1.d1pom5.checked = "checked"; <?php } ?>
<?php if ( $d1pom6 == 1 ) { ?> document.formv1.d1pom6.checked = "checked"; <?php } ?>
<?php if ( $d1pom7 == 1 ) { ?> document.formv1.d1pom7.checked = "checked"; <?php } ?>
<?php if ( $d1pom8 == 1 ) { ?> document.formv1.d1pom8.checked = "checked"; <?php } ?>
<?php if ( $d1pom9 == 1 ) { ?> document.formv1.d1pom9.checked = "checked"; <?php } ?>
<?php if ( $d1pom10 == 1 ) { ?> document.formv1.d1pom10.checked = "checked"; <?php } ?>
<?php if ( $d1pom11 == 1 ) { ?> document.formv1.d1pom11.checked = "checked"; <?php } ?>
<?php if ( $d1pom12 == 1 ) { ?> document.formv1.d1pom12.checked = "checked"; <?php } ?>
   document.formv1.d2prie.value = '<?php echo "$d2prie";?>';
   document.formv1.d2rod.value = '<?php echo "$d2rod";?>';
<?php if ( $d2pomc == 1 ) { ?> document.formv1.d2pomc.checked = "checked"; <?php } ?>
<?php if ( $d2pom1 == 1 ) { ?> document.formv1.d2pom1.checked = "checked"; <?php } ?>
<?php if ( $d2pom2 == 1 ) { ?> document.formv1.d2pom2.checked = "checked"; <?php } ?>
<?php if ( $d2pom3 == 1 ) { ?> document.formv1.d2pom3.checked = "checked"; <?php } ?>
<?php if ( $d2pom4 == 1 ) { ?> document.formv1.d2pom4.checked = "checked"; <?php } ?>
<?php if ( $d2pom5 == 1 ) { ?> document.formv1.d2pom5.checked = "checked"; <?php } ?>
<?php if ( $d2pom6 == 1 ) { ?> document.formv1.d2pom6.checked = "checked"; <?php } ?>
<?php if ( $d2pom7 == 1 ) { ?> document.formv1.d2pom7.checked = "checked"; <?php } ?>
<?php if ( $d2pom8 == 1 ) { ?> document.formv1.d2pom8.checked = "checked"; <?php } ?>
<?php if ( $d2pom9 == 1 ) { ?> document.formv1.d2pom9.checked = "checked"; <?php } ?>
<?php if ( $d2pom10 == 1 ) { ?> document.formv1.d2pom10.checked = "checked"; <?php } ?>
<?php if ( $d2pom11 == 1 ) { ?> document.formv1.d2pom11.checked = "checked"; <?php } ?>
<?php if ( $d2pom12 == 1 ) { ?> document.formv1.d2pom12.checked = "checked"; <?php } ?>
   document.formv1.d3prie.value = '<?php echo "$d3prie";?>';
   document.formv1.d3rod.value = '<?php echo "$d3rod";?>';
<?php if ( $d3pomc == 1 ) { ?> document.formv1.d3pomc.checked = "checked"; <?php } ?>
<?php if ( $d3pom1 == 1 ) { ?> document.formv1.d3pom1.checked = "checked"; <?php } ?>
<?php if ( $d3pom2 == 1 ) { ?> document.formv1.d3pom2.checked = "checked"; <?php } ?>
<?php if ( $d3pom3 == 1 ) { ?> document.formv1.d3pom3.checked = "checked"; <?php } ?>
<?php if ( $d3pom4 == 1 ) { ?> document.formv1.d3pom4.checked = "checked"; <?php } ?>
<?php if ( $d3pom5 == 1 ) { ?> document.formv1.d3pom5.checked = "checked"; <?php } ?>
<?php if ( $d3pom6 == 1 ) { ?> document.formv1.d3pom6.checked = "checked"; <?php } ?>
<?php if ( $d3pom7 == 1 ) { ?> document.formv1.d3pom7.checked = "checked"; <?php } ?>
<?php if ( $d3pom8 == 1 ) { ?> document.formv1.d3pom8.checked = "checked"; <?php } ?>
<?php if ( $d3pom9 == 1 ) { ?> document.formv1.d3pom9.checked = "checked"; <?php } ?>
<?php if ( $d3pom10 == 1 ) { ?> document.formv1.d3pom10.checked = "checked"; <?php } ?>
<?php if ( $d3pom11 == 1 ) { ?> document.formv1.d3pom11.checked = "checked"; <?php } ?>
<?php if ( $d3pom12 == 1 ) { ?> document.formv1.d3pom12.checked = "checked"; <?php } ?>
   document.formv1.d4prie.value = '<?php echo "$d4prie";?>';
   document.formv1.d4rod.value = '<?php echo "$d4rod";?>';
<?php if ( $d4pomc == 1 ) { ?> document.formv1.d4pomc.checked = "checked"; <?php } ?>
<?php if ( $d4pom1 == 1 ) { ?> document.formv1.d4pom1.checked = "checked"; <?php } ?>
<?php if ( $d4pom2 == 1 ) { ?> document.formv1.d4pom2.checked = "checked"; <?php } ?>
<?php if ( $d4pom3 == 1 ) { ?> document.formv1.d4pom3.checked = "checked"; <?php } ?>
<?php if ( $d4pom4 == 1 ) { ?> document.formv1.d4pom4.checked = "checked"; <?php } ?>
<?php if ( $d4pom5 == 1 ) { ?> document.formv1.d4pom5.checked = "checked"; <?php } ?>
<?php if ( $d4pom6 == 1 ) { ?> document.formv1.d4pom6.checked = "checked"; <?php } ?>
<?php if ( $d4pom7 == 1 ) { ?> document.formv1.d4pom7.checked = "checked"; <?php } ?>
<?php if ( $d4pom8 == 1 ) { ?> document.formv1.d4pom8.checked = "checked"; <?php } ?>
<?php if ( $d4pom9 == 1 ) { ?> document.formv1.d4pom9.checked = "checked"; <?php } ?>
<?php if ( $d4pom10 == 1 ) { ?> document.formv1.d4pom10.checked = "checked"; <?php } ?>
<?php if ( $d4pom11 == 1 ) { ?> document.formv1.d4pom11.checked = "checked"; <?php } ?>
<?php if ( $d4pom12 == 1 ) { ?> document.formv1.d4pom12.checked = "checked"; <?php } ?>
<?php if ( $r33 == 1 ) { ?> document.formv1.r33.checked = "checked"; <?php } ?>
   document.formv1.r34.value = '<?php echo "$r34";?>';
   document.formv1.r34a.value = '<?php echo "$r34a";?>';
   document.formv1.r35.value = '<?php echo "$r35";?>';
   document.formv1.r36.value = '<?php echo "$r36";?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   document.formv1.t1p1.value = '<?php echo "$t1p1";?>';
   document.formv1.t1p2.value = '<?php echo "$t1p2";?>';
   document.formv1.t1p3.value = '<?php echo "$t1p3";?>';
   document.formv1.t1p4.value = '<?php echo "$t1p4";?>';
   document.formv1.t1p5.value = '<?php echo "$t1p5";?>';
   document.formv1.t1p6.value = '<?php echo "$t1p6";?>';
   document.formv1.t1p7.value = '<?php echo "$t1p7";?>';
   document.formv1.t1p8.value = '<?php echo "$t1p8";?>';
   document.formv1.t1p9.value = '<?php echo "$t1p9";?>';
   document.formv1.t1p10.value = '<?php echo "$t1p10";?>';
   document.formv1.t1p11.value = '<?php echo "$t1p11";?>';
   document.formv1.t1p12.value = '<?php echo "$t1p12";?>';
   document.formv1.t1v1.value = '<?php echo "$t1v1";?>';
   document.formv1.t1v2.value = '<?php echo "$t1v2";?>';
   document.formv1.t1v3.value = '<?php echo "$t1v3";?>';
   document.formv1.t1v4.value = '<?php echo "$t1v4";?>';
   document.formv1.t1v5.value = '<?php echo "$t1v5";?>';
   document.formv1.t1v6.value = '<?php echo "$t1v6";?>';
   document.formv1.t1v7.value = '<?php echo "$t1v7";?>';
   document.formv1.t1v8.value = '<?php echo "$t1v8";?>';
   document.formv1.t1v9.value = '<?php echo "$t1v9";?>';
   document.formv1.t1v10.value = '<?php echo "$t1v10";?>';
   document.formv1.t1v11.value = '<?php echo "$t1v11";?>';
   document.formv1.t1v12.value = '<?php echo "$t1v12";?>';
<?php if ( $perc0 == 1 ) { ?> document.formv1.perc0.checked = "checked"; <?php } ?>
<?php if ( $perc1 == 1 ) { ?> document.formv1.perc1.checked = "checked"; <?php } ?>
<?php if ( $perc3 == 1 ) { ?> document.formv1.perc3.checked = "checked"; <?php } ?>
<?php if ( $perc4 == 1 ) { ?> document.formv1.perc4.checked = "checked"; <?php } ?>
   document.formv1.psp6.value = '<?php echo "$psp6";?>';
   document.formv1.t1az1.value = '<?php echo "$t1az1";?>';
   document.formv1.t1az2.value = '<?php echo "$t1az2";?>';
   document.formv1.t1az3.value = '<?php echo "$t1az3";?>';
   document.formv1.t1az4.value = '<?php echo "$t1az4";?>';
   document.formv1.t1az5.value = '<?php echo "$t1az5";?>';
   document.formv1.t1ak1.value = '<?php echo "$t1ak1";?>';
   document.formv1.t1ak2.value = '<?php echo "$t1ak2";?>';
   document.formv1.t1ak3.value = '<?php echo "$t1ak3";?>';
   document.formv1.t1ak4.value = '<?php echo "$t1ak4";?>';
   document.formv1.t1ak5.value = '<?php echo "$t1ak5";?>';
   document.formv1.t1bz1.value = '<?php echo "$t1bz1";?>';
   document.formv1.t1bz2.value = '<?php echo "$t1bz2";?>';
   document.formv1.t1bk1.value = '<?php echo "$t1bk1";?>';
   document.formv1.t1bk2.value = '<?php echo "$t1bk2";?>';
<?php                                        } ?>

<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
   document.formv1.t1cz1.value = '<?php echo "$t1cz1";?>';
   document.formv1.t1ck1.value = '<?php echo "$t1ck1";?>';
   document.formv1.t1cz2.value = '<?php echo "$t1cz2";?>';
   document.formv1.t1ck2.value = '<?php echo "$t1ck2";?>';
   document.formv1.t1cz3.value = '<?php echo "$t1cz3";?>';
   document.formv1.t1ck3.value = '<?php echo "$t1ck3";?>';
   document.formv1.t1cz4.value = '<?php echo "$t1cz4";?>';
   document.formv1.t1ck4.value = '<?php echo "$t1ck4";?>';
   document.formv1.t1cz5.value = '<?php echo "$t1cz5";?>';
   document.formv1.t1ck5.value = '<?php echo "$t1ck5";?>';
   document.formv1.r37.value = '<?php echo "$r37";?>';
   document.formv1.r38.value = '<?php echo "$r38";?>';
   document.formv1.r39.value = '<?php echo "$r39";?>';
   document.formv1.r40.value = '<?php echo "$r40";?>';
   document.formv1.r41.value = '<?php echo "$r41";?>';
   document.formv1.r42.value = '<?php echo "$r42";?>';
   document.formv1.r43.value = '<?php echo "$r43";?>';
   document.formv1.r44.value = '<?php echo "$r44";?>';
   document.formv1.r45.value = '<?php echo "$r45";?>';
   document.formv1.r46.value = '<?php echo "$r46";?>';
   document.formv1.r47.value = '<?php echo "$r47";?>';
   document.formv1.r48.value = '<?php echo "$r48";?>';
<?php                                        } ?>

<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
   document.formv1.r49.value = '<?php echo "$r49";?>';
   document.formv1.r50.value = '<?php echo "$r50";?>';
   document.formv1.r51.value = '<?php echo "$r51";?>';
   document.formv1.r52.value = '<?php echo "$r52";?>';
   document.formv1.t2p1.value = '<?php echo "$t2p1";?>';
   document.formv1.t2p2.value = '<?php echo "$t2p2";?>';
   document.formv1.t2p3.value = '<?php echo "$t2p3";?>';
   document.formv1.t2p4.value = '<?php echo "$t2p4";?>';
   document.formv1.t2p5.value = '<?php echo "$t2p5";?>';
   document.formv1.t2p6.value = '<?php echo "$t2p6";?>';
   document.formv1.t2p7.value = '<?php echo "$t2p7";?>';
   document.formv1.t2p8.value = '<?php echo "$t2p8";?>';
   document.formv1.t2p9.value = '<?php echo "$t2p9";?>';
   document.formv1.t2p10.value = '<?php echo "$t2p10";?>';
   document.formv1.t2p11.value = '<?php echo "$t2p11";?>';
   document.formv1.t2p12.value = '<?php echo "$t2p12";?>';
   document.formv1.t2p13.value = '<?php echo "$t2p13";?>';
   document.formv1.t2v1.value = '<?php echo "$t2v1";?>';
   document.formv1.t2v2.value = '<?php echo "$t2v2";?>';
   document.formv1.t2v3.value = '<?php echo "$t2v3";?>';
   document.formv1.t2v4.value = '<?php echo "$t2v4";?>';
   document.formv1.t2v5.value = '<?php echo "$t2v5";?>';
   document.formv1.t2v6.value = '<?php echo "$t2v6";?>';
   document.formv1.t2v7.value = '<?php echo "$t2v7";?>';
   document.formv1.t2v8.value = '<?php echo "$t2v8";?>';
   document.formv1.t2v9.value = '<?php echo "$t2v9";?>';
   document.formv1.t2v10.value = '<?php echo "$t2v10";?>';
   document.formv1.t2v11.value = '<?php echo "$t2v11";?>';
   document.formv1.t2v12.value = '<?php echo "$t2v12";?>';
<?php                                        } ?>

<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
   document.formv1.r53.value = '<?php echo "$r53";?>';
   document.formv1.r54.value = '<?php echo "$r54";?>';
   document.formv1.r55.value = '<?php echo "$r55";?>';
   document.formv1.t3p1.value = '<?php echo "$t3p1";?>';
   document.formv1.t3p2.value = '<?php echo "$t3p2";?>';
   document.formv1.t3p3.value = '<?php echo "$t3p3";?>';
   document.formv1.t3p4.value = '<?php echo "$t3p4";?>';
   document.formv1.t3p5.value = '<?php echo "$t3p5";?>';
   document.formv1.t3p6.value = '<?php echo "$t3p6";?>';
   document.formv1.t3p7.value = '<?php echo "$t3p7";?>';
   document.formv1.t3p8.value = '<?php echo "$t3p8";?>';
   document.formv1.t3p9.value = '<?php echo "$t3p9";?>';
   document.formv1.t3p10.value = '<?php echo "$t3p10";?>';
   document.formv1.t3p11.value = '<?php echo "$t3p11";?>';
   document.formv1.t3p12.value = '<?php echo "$t3p12";?>';
   document.formv1.t3p13.value = '<?php echo "$t3p13";?>';
   document.formv1.t3p14.value = '<?php echo "$t3p14";?>';
   document.formv1.t3v1.value = '<?php echo "$t3v1";?>';
   document.formv1.t3v2.value = '<?php echo "$t3v2";?>';
   document.formv1.t3v3.value = '<?php echo "$t3v3";?>';
   document.formv1.t3v4.value = '<?php echo "$t3v4";?>';
   document.formv1.t3v5.value = '<?php echo "$t3v5";?>';
   document.formv1.t3v6.value = '<?php echo "$t3v6";?>';
   document.formv1.t3v7.value = '<?php echo "$t3v7";?>';
   document.formv1.t3v8.value = '<?php echo "$t3v8";?>';
   document.formv1.t3v9.value = '<?php echo "$t3v9";?>';
   document.formv1.t3v10.value = '<?php echo "$t3v10";?>';
   document.formv1.t3v11.value = '<?php echo "$t3v11";?>';
   document.formv1.t3v12.value = '<?php echo "$t3v12";?>';
   document.formv1.t3v14.value = '<?php echo "$t3v14";?>';
<?php                                        } ?>

<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
   document.formv1.r56.value = '<?php echo "$r56";?>';
   document.formv1.r57.value = '<?php echo "$r57";?>';
   document.formv1.r58.value = '<?php echo "$r58";?>';
   document.formv1.r59.value = '<?php echo "$r59";?>';
   document.formv1.r60.value = '<?php echo "$r60";?>';
   document.formv1.r61.value = '<?php echo "$r61";?>';
   document.formv1.r62.value = '<?php echo "$r62";?>';
   document.formv1.r63.value = '<?php echo "$r63";?>';
   document.formv1.rr59.value = '<?php echo "$rr59";?>';
   document.formv1.rr60.value = '<?php echo "$rr60";?>';
   document.formv1.rr61.value = '<?php echo "$rr61";?>';
   document.formv1.rr62.value = '<?php echo "$rr62";?>';
   document.formv1.r64.value = '<?php echo "$r64";?>';
   document.formv1.r65.value = '<?php echo "$r65";?>';
   document.formv1.r66.value = '<?php echo "$r66";?>';
   document.formv1.r67.value = '<?php echo "$r67";?>';
   document.formv1.r68.value = '<?php echo "$r68";?>';
   document.formv1.r69.value = '<?php echo "$r69";?>';
   document.formv1.r70.value = '<?php echo "$r70";?>';
   document.formv1.r64.value = '<?php echo "$r64";?>';
   document.formv1.r65.value = '<?php echo "$r65";?>';
   document.formv1.r66.value = '<?php echo "$r66";?>';
   document.formv1.r66.value = '<?php echo "$r66";?>';
   document.formv1.r67.value = '<?php echo "$r67";?>';
   document.formv1.r68.value = '<?php echo "$r68";?>';
   document.formv1.r69.value = '<?php echo "$r69";?>';
   document.formv1.r70.value = '<?php echo "$r70";?>';
   document.formv1.r71.value = '<?php echo "$r71";?>';
<?php                                        } ?>

<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
   document.formv1.r72.value = '<?php echo "$r72";?>';
   document.formv1.r73.value = '<?php echo "$r73";?>';
   document.formv1.r74.value = '<?php echo "$r74";?>';
   document.formv1.r75.value = '<?php echo "$r75";?>';
   document.formv1.r76.value = '<?php echo "$r76";?>';
   document.formv1.r77.value = '<?php echo "$r77";?>';
   document.formv1.r78.value = '<?php echo "$r78";?>';
   document.formv1.r79.value = '<?php echo "$r79";?>';
   document.formv1.r80.value = '<?php echo "$r80";?>';
   document.formv1.r81.value = '<?php echo "$r81";?>';
   document.formv1.r82.value = '<?php echo "$r82";?>';
   document.formv1.r83.value = '<?php echo "$r83";?>';
   document.formv1.r84.value = '<?php echo "$r84";?>';
   document.formv1.r85.value = '<?php echo "$r85";?>';
   document.formv1.r86.value = '<?php echo "$r86";?>';
   document.formv1.r87.value = '<?php echo "$r87";?>';
   document.formv1.r88.value = '<?php echo "$r88";?>';
   document.formv1.r89.value = '<?php echo "$r89";?>';
   document.formv1.r90.value = '<?php echo "$r90";?>';
   document.formv1.r91.value = '<?php echo "$r91";?>';
   document.formv1.r92.value = '<?php echo "$r92";?>';
   document.formv1.r93.value = '<?php echo "$r93";?>';
   document.formv1.r94.value = '<?php echo "$r94";?>';
   document.formv1.r95.value = '<?php echo "$r95";?>';
<?php                                        } ?>

<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
   document.formv1.r96.value = '<?php echo "$r96";?>';
   document.formv1.r97.value = '<?php echo "$r97";?>';
   document.formv1.r98.value = '<?php echo "$r98";?>';
   document.formv1.r99.value = '<?php echo "$r99";?>';
   document.formv1.r100.value = '<?php echo "$r100";?>';
   document.formv1.r101.value = '<?php echo "$r101";?>';
   document.formv1.r102.value = '<?php echo "$r102";?>';
   document.formv1.r103.value = '<?php echo "$r103";?>';
   document.formv1.r104.value = '<?php echo "$r104";?>';
   document.formv1.r105.value = '<?php echo "$r105";?>';
   document.formv1.r106.value = '<?php echo "$r106";?>';
   document.formv1.r107.value = '<?php echo "$r107";?>';
   document.formv1.r108.value = '<?php echo "$r108";?>';
   document.formv1.r109.value = '<?php echo "$r109";?>';
<?php                                        } ?>

<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
   document.formv1.r110.value = '<?php echo "$r110";?>';
   document.formv1.r111.value = '<?php echo "$r111";?>';
   document.formv1.r112.value = '<?php echo "$r112";?>';
   document.formv1.r113.value = '<?php echo "$r113";?>';
   document.formv1.r114.value = '<?php echo "$r114";?>';
   document.formv1.r115.value = '<?php echo "$r115";?>';
   document.formv1.sdnr.value = '<?php echo "$sdnr";?>';
   document.formv1.r117.value = '<?php echo "$r117";?>';
<?php if ( $ldnr == 1 ) { ?> document.formv1.ldnr.checked = "checked"; <?php } ?>
   document.formv1.nrzsprev.value = '<?php echo "$nrzsprev";?>';
<?php if ( $upl50 == 1 ) { ?> document.formv1.upl50.checked = "checked"; <?php } ?>
<?php if ( $spl3d == 1 ) { ?> document.formv1.spl3d.checked = "checked"; <?php } ?>
   document.formv1.r120.value = '<?php echo "$r120";?>';
   document.formv1.pico.value = '<?php echo "$pico";?>';
   document.formv1.psid.value = '<?php echo "$psid";?>';
   document.formv1.pfor.value = '<?php echo "$pfor";?>';
   document.formv1.pmen.value = '<?php echo "$pmen";?>';
   document.formv1.puli.value = '<?php echo "$puli";?>';
   document.formv1.pcdm.value = '<?php echo "$pcdm";?>';
   document.formv1.ppsc.value = '<?php echo "$ppsc";?>';
   document.formv1.pmes.value = '<?php echo "$pmes";?>';
<?php                                         } ?>

<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
<?php if ( $uoso == 1 ) { ?> document.formv1.uoso.checked = "checked"; <?php } ?>
   document.formv1.pzks1.value = '<?php echo "$pzks1";?>';
   document.formv1.pdrp1.value = '<?php echo "$pdrp1";?>';
   document.formv1.pdro1.value = '<?php echo "$pdro1";?>';
   document.formv1.pzpr1.value = '<?php echo "$pzpr1";?>';
   document.formv1.pzvd1.value = '<?php echo "$pzvd1";?>';
   document.formv1.pzthvd1.value = '<?php echo "$pzthvd1";?>';
   document.formv1.pzks2.value = '<?php echo "$pzks2";?>';
   document.formv1.pdrp2.value = '<?php echo "$pdrp2";?>';
   document.formv1.pdro2.value = '<?php echo "$pdro2";?>';
   document.formv1.pzpr2.value = '<?php echo "$pzpr2";?>';
   document.formv1.pzvd2.value = '<?php echo "$pzvd2";?>';
   document.formv1.pzthvd2.value = '<?php echo "$pzthvd2";?>';
   document.formv1.pzks3.value = '<?php echo "$pzks3";?>';
   document.formv1.pdrp3.value = '<?php echo "$pdrp3";?>';
   document.formv1.pdro3.value = '<?php echo "$pdro3";?>';
   document.formv1.pzpr3.value = '<?php echo "$pzpr3";?>';
   document.formv1.pzvd3.value = '<?php echo "$pzvd3";?>';
   document.formv1.pzthvd3.value = '<?php echo "$pzthvd3";?>';
   document.formv1.pzks4.value = '<?php echo "$pzks4";?>';
   document.formv1.pdrp4.value = '<?php echo "$pdrp4";?>';
   document.formv1.pdro4.value = '<?php echo "$pdro4";?>';
   document.formv1.pzpr4.value = '<?php echo "$pzpr4";?>';
   document.formv1.pzvd4.value = '<?php echo "$pzvd4";?>';
   document.formv1.pzthvd4.value = '<?php echo "$pzthvd4";?>';
   document.formv1.pzks5.value = '<?php echo "$pzks5";?>';
   document.formv1.pdrp5.value = '<?php echo "$pdrp5";?>';
   document.formv1.pdro5.value = '<?php echo "$pdro5";?>';
   document.formv1.pzpr5.value = '<?php echo "$pzpr5";?>';
   document.formv1.pzvd5.value = '<?php echo "$pzvd5";?>';
   document.formv1.pzthvd5.value = '<?php echo "$pzthvd5";?>';
   document.formv1.pzks6.value = '<?php echo "$pzks6";?>';
   document.formv1.pdrp6.value = '<?php echo "$pdrp6";?>';
   document.formv1.pdro6.value = '<?php echo "$pdro6";?>';
   document.formv1.pzpr6.value = '<?php echo "$pzpr6";?>';
   document.formv1.pzvd6.value = '<?php echo "$pzvd6";?>';
   document.formv1.pzthvd6.value = '<?php echo "$pzthvd6";?>';
   document.formv1.osob.value = '<?php echo "$osob";?>';
   document.formv1.pril.value = '<?php echo "$pril";?>';
   document.formv1.dat.value = '<?php echo "$datsk";?>';
<?php if ( $zdbo == 1 ) { ?> document.formv1.zdbo.checked = "checked"; <?php } ?>
<?php if ( $zpre == 1 ) { ?> document.formv1.zpre.checked = "checked"; <?php } ?>
   document.formv1.diban.value = '<?php echo "$diban";?>';
   document.formv1.uceb.value = '<?php echo "$uceb";?>';
   document.formv1.numb.value = '<?php echo "$numb";?>';
   document.formv1.da2.value = '<?php echo "$da2sk";?>';
<?php                                         } ?>

<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
   document.formv1.sz1p1.value = '<?php echo "$sz1p1";?>';
   document.formv1.sz1v1.value = '<?php echo "$sz1v1";?>';
   document.formv1.sz2.value = '<?php echo "$sz2";?>';
   document.formv1.sz3.value = '<?php echo "$sz3";?>';
   document.formv1.sz4.value = '<?php echo "$sz4";?>';
   document.formv1.sz5.value = '<?php echo "$sz5";?>';
   document.formv1.sz6.value = '<?php echo "$sz6";?>';
   document.formv1.sz7.value = '<?php echo "$sz7";?>';
   document.formv1.sz8.value = '<?php echo "$sz8";?>';
   document.formv1.sz9.value = '<?php echo "$sz9";?>';
   document.formv1.sz10.value = '<?php echo "$sz10";?>';
   document.formv1.sz11.value = '<?php echo "$sz11";?>';
   document.formv1.sz12.value = '<?php echo "$sz12";?>';
   document.formv1.sz13.value = '<?php echo "$sz13";?>';
   document.formv1.sz14.value = '<?php echo "$sz14";?>';
   document.formv1.sz15.value = '<?php echo "$sz15";?>';
   document.formv1.sz16.value = '<?php echo "$sz16";?>';
   document.formv1.szdat.value = '<?php echo "$szdatsk";?>';
<?php                                         } ?>

<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
   document.formv1.pzs01.value = '<?php echo "$pzs01";?>';
   document.formv1.pzs02.value = '<?php echo "$pzs02";?>';
   document.formv1.pzd02.value = '<?php echo "$pzd02";?>';
   document.formv1.pzs03.value = '<?php echo "$pzs03";?>';
   document.formv1.pzd03.value = '<?php echo "$pzd03";?>';
   document.formv1.pzs04.value = '<?php echo "$pzs04";?>';
   document.formv1.pzd04.value = '<?php echo "$pzd04";?>';
   document.formv1.pzr05.value = '<?php echo "$pzr05";?>';
   document.formv1.pzr07.value = '<?php echo "$pzr07";?>';
   document.formv1.pzr08.value = '<?php echo "$pzr08";?>';
   document.formv1.pzr09.value = '<?php echo "$pzr09";?>';
   document.formv1.pzr10.value = '<?php echo "$pzr10";?>';
   document.formv1.pzr11.value = '<?php echo "$pzr11";?>';
   document.formv1.pzr12.value = '<?php echo "$pzr12";?>';
   document.formv1.pzr13.value = '<?php echo "$pzr13";?>';
   document.formv1.pzr14.value = '<?php echo "$pzr14";?>';
   document.formv1.pzr15.value = '<?php echo "$pzr15";?>';
   document.formv1.pzr16.value = '<?php echo "$pzr16";?>';
   document.formv1.pzdat.value = '<?php echo "$pzdatsk";?>';
<?php                                         } ?>
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

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
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
			{text=text + "Rok nemoze byt v��� ako 2029.\r"; err=3 }
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


// Kontrola des.cisla celeho v rozsahu x az y  
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

  function reNacitaj()
  {
   window.open('../ucto/priznanie_fob2013.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&prepocitaj=1', '_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacFOB()
  {
   window.open('../ucto/priznanie_fob2013.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_fob2013.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_poucenie_na_vyplnenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function ZnovuPotvrdenie()
  {
   window.open('../ucto/priznanie_fob2013.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1&prepocitaj=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function vypocetOP()
  {
   window.open('priznanie_fob2013.php?copern=20&strana=<?php echo $strana; ?>&miliondan=1', '_self');
  }
  function namanzelku()
  {
   window.open('priznanie_fob2013.php?copern=20&strana=<?php echo $strana; ?>&namanzelku=1', '_self');
  }
  function NacitajVHpredDanou()
  {
   window.open('../ucto/priznanie_fob2013.php?strana=3&copern=200&drupoh=1&page=1&typ=PDF&dppo=1', '_self');
  }
</script>
</HEAD>
<?php if( $zandroidu == 1 ) { ?>
<BODY class="white" >
<br />
<br />
<table width="100%" >
<tr>
<td>
<?php if( $zandroidu == 1 ) { echo "Zostava PDF prebran�, tla�idlo Sp� - do da�ov�ch zost�v"; } ?> 
</td>
<td align="right"> </td>
</tr>
</table>
<br />
<?php                       } ?>
<?php if( $zandroidu == 0 ) { ?>
<BODY id="white" onload="ObnovUI();">
<?php                       } ?>
<?php if ( $copern == 20 )
    {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Da� z pr�jmov FO typ B</td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="Pou�enie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="Na��ta� �daje z minul�ho roka" class="btn-form-tool">
     <img src="../obr/ikony/reload_blue_icon.png" onclick="reNacitaj();" title="Znovu na��ta� hodnoty do priznania" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacFOB();" title="Zobrazi� v�etky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="priznanie_fob2013.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive"; $clas6="noactive"; $clas7="noactive";
$clas8="noactive"; $clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive"; $clas13="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active"; if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active"; if ( $strana == 11 ) $clas11="active";
if ( $strana == 12 ) $clas12="active"; if ( $strana == 13 ) $clas13="active";

$source="../ucto/priznanie_fob2013.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1&prepocitaj=101', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2&prepocitaj=101', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3&prepocitaj=101', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4&prepocitaj=101', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5&prepocitaj=101', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=6&prepocitaj=101', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=7&prepocitaj=101', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=8&prepocitaj=101', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=9&prepocitaj=101', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=10&prepocitaj=101', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=11&prepocitaj=101', '_self');" class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=12&prepocitaj=101', '_self');" class="<?php echo $clas12; ?> toleft">12</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=13&prepocitaj=101', '_self');" class="<?php echo $clas13; ?> toleft">13</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=13', '_blank');" class="<?php echo $clas13; ?> toright">13</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=12', '_blank');" class="<?php echo $clas12; ?> toright">12</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=11', '_blank');" class="<?php echo $clas11; ?> toright">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=10', '_blank');" class="<?php echo $clas10; ?> toright">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=9', '_blank');" class="<?php echo $clas9; ?> toright">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=8', '_blank');" class="<?php echo $clas8; ?> toright">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=7', '_blank');" class="<?php echo $clas7; ?> toright">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">Tla�i�:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-top-formsave">
<?php
if ( $prepocitaj == 0 ) { $prepocitaj=1; }
?>
 <input type="checkbox" name="prepocitaj" value="1" class="btn-prepocet"/>
<?php if ( $prepocitaj == 1 ) { ?>
 <script type="text/javascript">document.formv1.prepocitaj.checked = "checked";</script>
<?php                     } ?>
 <h5 class="btn-prepocet-title">Prepo��ta� hodnoty</h5>
 <div class="alert-pocitam"><?php echo "$alertprepocet";?></div>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str1.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 1.strana 282kB" class="form-background">

<div class="nofill input-echo" style="width:220px; top:253px; left:51px;"><?php echo $fir_fdic;?></div>
<input type="text" name="dar" id="dar" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:308px; left:51px;"/>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:252px; left:440px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:277px; left:440px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:302px; left:440px;"/>
<div class="nofill input-echo" style="width:81px; top:237px; left:784px;"><?php echo "$kli_vrok ";?></div>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:307px; left:690px;"/>
<input type="text" name="fir_sknace" id="fir_sknace" value="<?php echo $fir_sknace; ?>" disabled="disabled" class="nofill" style="width:128px; top:366px; left:51px;"/>
<input type="text" name="cinnost" id="cinnost" style="width:621px; height:46px; top:347px; left:267px;"/>

<!-- I. ODDIEL -->
<input type="text" name="dprie" id="dprie" style="width:359px; top:456px; left:51px;"/>
<input type="text" name="dmeno" id="dmeno" style="width:244px; top:456px; left:430px;"/>
<input type="text" name="dtitl" id="dtitl" style="width:112px; top:456px; left:694px;"/>
<input type="text" name="dtitz" id="dtitz" style="width:66px; top:456px; left:827px;"/>
<!-- Adresa trvaleho pobytu -->
<input type="text" name="duli" id="duli" style="width:635px; top:530px; left:51px;"/>
<input type="text" name="dcdm" id="dcdm" style="width:175px; top:530px; left:718px;"/>
<input type="text" name="dpsc" id="dpsc" style="width:107px; top:582px; left:51px;"/>
<input type="text" name="dmes" id="dmes" style="width:451px; top:582px; left:178px;"/>
<input type="text" name="xstat" id="xstat" style="width:245px; top:582px; left:648px;"/>
<input type="checkbox" name="nrz" value="1" style="top:620px; left:538px;"/>
<input type="checkbox" name="prp" value="1" style="top:620px; left:848px;"/>
<!-- Adresa pobytu na uzemi SR -->
<input type="text" name="d2uli" id="d2uli" style="width:635px; top:690px; left:51px;"/>
<input type="text" name="d2cdm" id="d2cdm" style="width:175px; top:690px; left:718px;"/>
<input type="text" name="d2psc" id="d2psc" style="width:107px; top:742px; left:51px;"/>
<input type="text" name="d2mes" id="d2mes" style="width:451px; top:742px; left:178px;"/>

<!-- II. ODDIEL -->
<input type="text" name="zprie" id="zprie" style="width:359px; top:850px; left:51px;"/>
<input type="text" name="zmeno" id="zmeno" style="width:244px; top:850px; left:430px;"/>
<input type="text" name="ztitl" id="ztitl" style="width:112px; top:850px; left:694px;"/>
<input type="text" name="ztitz" id="ztitz" style="width:66px; top:850px; left:827px;"/>
<input type="text" name="zrdc" id="zrdc" style="width:129px; top:905px; left:51px;"/>
<input type="text" name="zrdk" id="zrdk" style="width:84px; top:905px; left:212px;"/>
<input type="text" name="zuli" id="zuli" style="width:357px; top:905px; left:328px;"/>
<input type="text" name="zcdm" id="zcdm" style="width:175px; top:905px; left:718px;"/>
<input type="text" name="zpsc" id="zpsc" style="width:107px; top:960px; left:51px;"/>
<input type="text" name="zmes" id="zmes" style="width:451px; top:960px; left:178px;"/>
<input type="text" name="zstat" id="zstat" style="width:245px; top:960px; left:648px;"/>
<!-- telefon a fax FO -->
<input type="text" name="dtel" id="dtel" style="width:290px; top:1021px; left:51px;"/>
<input type="text" name="dmailfax" id="dmailfax" style="width:520px; top:1021px; left:373px;"/>

<!-- Miesto podnikania (ak sa l�i od miesta trval�ho pobytu) - ! Vyp��a� iba pri V�kaze o pr�jmoch a v�davkoch a pri V�kaze o majetku a z�v�zkov !
Ulica:<input type="text" name="pruli" id="pruli" size="30" />
��slo:<input type="text" name="prcdm" id="prcdm" size="10" />
PS�:<input type="text" name="prpsc" id="prpsc" size="10" />
Obec:<input type="text" name="prmes" id="prmes" size="30" />
Telef�n:<input type="text" name="prtel" id="prtel" size="30" />
Fax:<input type="text" name="prfax" id="prfax" size="30" /> --> <!-- dopyt, neviem, �i necha� alebo nie -->
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str2.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 2.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- III. ODDIEL -->
<input type="checkbox" name="r29" value="1" style="top:288px; left:745px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:334px; left:701px;"/>
<input type="text" name="mprie" id="mprie" style="width:340px; top:422px; left:51px;"/>
<input type="text" name="mrod" id="mrod" style="width:240px; top:422px; left:413px;"/>
<input type="text" name="mpri" id="mpri" onkeyup="CiarkaNaBodku(this);" style="width:153px; top:422px; left:671px;"/>
<input type="text" name="mpom" id="mpom" style="width:38px; top:422px; left:850px;"/>

<!-- IV. ODDIEL -->
<input type="text" name="d1prie" id="d1prie" style="width:243px; top:663px; left:47px;"/>
<input type="text" name="d1rod" id="d1rod" style="width:240px; top:663px; left:304px;"/>
<input type="checkbox" name="d1pomc" value="1" style="top:674px; left:561px;"/>
<input type="checkbox" name="d1pom1" value="1" style="top:674px; left:598px;"/>
<input type="checkbox" name="d1pom2" value="1" style="top:674px; left:623px;"/>
<input type="checkbox" name="d1pom3" value="1" style="top:674px; left:649px;"/>
<input type="checkbox" name="d1pom4" value="1" style="top:674px; left:674px;"/>
<input type="checkbox" name="d1pom5" value="1" style="top:674px; left:699px;"/>
<input type="checkbox" name="d1pom6" value="1" style="top:674px; left:724px;"/>
<input type="checkbox" name="d1pom7" value="1" style="top:674px; left:750px;"/>
<input type="checkbox" name="d1pom8" value="1" style="top:674px; left:775px;"/>
<input type="checkbox" name="d1pom9" value="1" style="top:674px; left:800px;"/>
<input type="checkbox" name="d1pom10" value="1" style="top:674px; left:826px;"/>
<input type="checkbox" name="d1pom11" value="1" style="top:674px; left:851px;"/>
<input type="checkbox" name="d1pom12" value="1" style="top:674px; left:877px;"/>

<input type="text" name="d2prie" id="d2prie" style="width:243px; top:707px; left:47px;"/>
<input type="text" name="d2rod" id="d2rod" style="width:240px; top:707px; left:304px;"/>
<input type="checkbox" name="d2pomc" value="1" style="top:718px; left:561px;"/>
<input type="checkbox" name="d2pom1" value="1" style="top:718px; left:598px;"/>
<input type="checkbox" name="d2pom2" value="1" style="top:718px; left:623px;"/>
<input type="checkbox" name="d2pom3" value="1" style="top:718px; left:649px;"/>
<input type="checkbox" name="d2pom4" value="1" style="top:718px; left:674px;"/>
<input type="checkbox" name="d2pom5" value="1" style="top:718px; left:699px;"/>
<input type="checkbox" name="d2pom6" value="1" style="top:718px; left:724px;"/>
<input type="checkbox" name="d2pom7" value="1" style="top:718px; left:750px;"/>
<input type="checkbox" name="d2pom8" value="1" style="top:718px; left:775px;"/>
<input type="checkbox" name="d2pom9" value="1" style="top:718px; left:800px;"/>
<input type="checkbox" name="d2pom10" value="1" style="top:718px; left:826px;"/>
<input type="checkbox" name="d2pom11" value="1" style="top:718px; left:851px;"/>
<input type="checkbox" name="d2pom12" value="1" style="top:718px; left:877px;"/>

<input type="text" name="d3prie" id="d3prie" style="width:243px; top:752px; left:47px;"/>
<input type="text" name="d3rod" id="d3rod" style="width:240px; top:752px; left:304px;"/>
<input type="checkbox" name="d3pomc" value="1" style="top:763px; left:561px;"/>
<input type="checkbox" name="d3pom1" value="1" style="top:763px; left:598px;"/>
<input type="checkbox" name="d3pom2" value="1" style="top:763px; left:623px;"/>
<input type="checkbox" name="d3pom3" value="1" style="top:763px; left:649px;"/>
<input type="checkbox" name="d3pom4" value="1" style="top:763px; left:674px;"/>
<input type="checkbox" name="d3pom5" value="1" style="top:763px; left:699px;"/>
<input type="checkbox" name="d3pom6" value="1" style="top:763px; left:724px;"/>
<input type="checkbox" name="d3pom7" value="1" style="top:763px; left:750px;"/>
<input type="checkbox" name="d3pom8" value="1" style="top:763px; left:775px;"/>
<input type="checkbox" name="d3pom9" value="1" style="top:763px; left:800px;"/>
<input type="checkbox" name="d3pom10" value="1" style="top:763px; left:826px;"/>
<input type="checkbox" name="d3pom11" value="1" style="top:763px; left:851px;"/>
<input type="checkbox" name="d3pom12" value="1" style="top:763px; left:877px;"/>

<input type="text" name="d4prie" id="d4prie" style="width:243px; top:797px; left:47px;"/>
<input type="text" name="d4rod" id="d4rod" style="width:240px; top:797px; left:304px;"/>
<input type="checkbox" name="d4pomc" value="1" style="top:807px; left:561px;"/>
<input type="checkbox" name="d4pom1" value="1" style="top:807px; left:598px;"/>
<input type="checkbox" name="d4pom2" value="1" style="top:807px; left:623px;"/>
<input type="checkbox" name="d4pom3" value="1" style="top:807px; left:649px;"/>
<input type="checkbox" name="d4pom4" value="1" style="top:807px; left:674px;"/>
<input type="checkbox" name="d4pom5" value="1" style="top:807px; left:699px;"/>
<input type="checkbox" name="d4pom6" value="1" style="top:807px; left:724px;"/>
<input type="checkbox" name="d4pom7" value="1" style="top:807px; left:750px;"/>
<input type="checkbox" name="d4pom8" value="1" style="top:807px; left:775px;"/>
<input type="checkbox" name="d4pom9" value="1" style="top:807px; left:800px;"/>
<input type="checkbox" name="d4pom10" value="1" style="top:807px; left:826px;"/>
<input type="checkbox" name="d4pom11" value="1" style="top:807px; left:851px;"/>
<input type="checkbox" name="d4pom12" value="1" style="top:807px; left:877px;"/>
<input type="checkbox" name="r33" value="1" style="top:836px; left:85px;"/>

<!-- V. ODDIEL -->
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1042px; left:501px;"/>
<input type="text" name="r34a" id="r34a" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1081px; left:501px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:1120px; left:568px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1160px; left:501px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str3.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 3.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- VI. ODDIEL -->
<!-- Tabulka 1 -->
<input type="text" name="t1p1" id="t1p1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:224px; left:410px;"/>
<input type="text" name="t1v1" id="t1v1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:224px; left:661px;"/>
<input type="text" name="t1p2" id="t1p2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:262px; left:410px;"/>
<input type="text" name="t1v2" id="t1v2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:262px; left:661px;"/>

 <img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajVHpredDanou();" title="Na��ta� pr�jmy,v�davky a zaplaten� poistn� SP a ZP zo �ivnosti do tabu�ky �.1 (VI.oddiel FOB 3. strana), mus�te ma� spracovan� V�kaz o pr�jmoch a v�davkoch za 12.2013" class="btn-row-tool" style="top:262px; left:910px;">

<input type="text" name="t1p3" id="t1p3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:302px; left:410px;"/>
<input type="text" name="t1v3" id="t1v3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:302px; left:661px;"/>
<input type="text" name="t1p4" id="t1p4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:343px; left:410px;"/>
<input type="text" name="t1v4" id="t1v4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:343px; left:661px;"/>
<input type="text" name="t1p5" id="t1p5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:388px; left:410px;"/>
<input type="text" name="t1v5" id="t1v5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:388px; left:661px;"/>
<input type="text" name="t1p6" id="t1p6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:434px; left:410px;"/>
<input type="text" name="t1v6" id="t1v6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:434px; left:661px;"/>
<input type="text" name="t1p7" id="t1p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:475px; left:410px;"/>
<input type="text" name="t1v7" id="t1v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:475px; left:661px;"/>
<input type="text" name="t1p8" id="t1p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:514px; left:410px;"/>
<input type="text" name="t1v8" id="t1v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:514px; left:661px;"/>
<input type="text" name="t1p9" id="t1p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:554px; left:410px;"/>
<input type="text" name="t1v9" id="t1v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:554px; left:661px;"/>
<input type="text" name="t1p10" id="t1p10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:595px; left:410px;"/>
<input type="text" name="t1v10" id="t1v10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:595px; left:661px;"/>
<input type="text" name="t1p11" id="t1p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:635px; left:410px;"/>
<input type="text" name="t1v11" id="t1v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:635px; left:661px;"/>
<input type="text" name="t1p12" id="t1p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:675px; left:410px;"/>
<input type="text" name="t1v12" id="t1v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:675px; left:661px;"/>
<input type="checkbox" name="perc3" value="1" style="top:770px; left:64px;"/>
<input type="checkbox" name="perc1" value="1" style="top:770px; left:478px;"/>
<input type="checkbox" name="perc4" value="1" style="top:796px; left:64px;"/>
<input type="checkbox" name="perc0" value="1" style="top:796px; left:478px;"/>
<!-- Tabulka 1a -->
<input type="text" name="psp6" id="psp6" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:827px; left:556px;"/>
<input type="text" name="t1az1" id="t1az1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:915px; left:410px;"/>
<input type="text" name="t1ak1" id="t1ak1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:915px; left:660px;"/>
<input type="text" name="t1az2" id="t1az2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:953px; left:410px;"/>
<input type="text" name="t1ak2" id="t1ak2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:953px; left:660px;"/>
<input type="text" name="t1az3" id="t1az3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:993px; left:410px;"/>
<input type="text" name="t1ak3" id="t1ak3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:993px; left:660px;"/>
<input type="text" name="t1az4" id="t1az4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1034px; left:410px;"/>
<input type="text" name="t1ak4" id="t1ak4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1034px; left:660px;"/>
<input type="text" name="t1az5" id="t1az5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1074px; left:410px;"/>
<input type="text" name="t1ak5" id="t1ak5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1074px; left:660px;"/>
<!-- Tabulka 1b -->
<input type="text" name="t1bz1" id="t1bz1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1179px; left:410px;"/>
<input type="text" name="t1bk1" id="t1bk1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1179px; left:660px;"/>
<input type="text" name="t1bz2" id="t1bz2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1220px; left:410px;"/>
<input type="text" name="t1bk2" id="t1bk2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1220px; left:660px;"/>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str4.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 4.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- VI. ODDIEL pokracovanie -->
<!-- Tabulka 1c -->
<input type="text" name="t1cz1" id="t1cz1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:156px; left:410px;"/>
<input type="text" name="t1ck1" id="t1ck1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:156px; left:660px;"/>
<input type="text" name="t1cz2" id="t1cz2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:196px; left:410px;"/>
<input type="text" name="t1ck2" id="t1ck2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:196px; left:660px;"/>
<input type="text" name="t1cz3" id="t1cz3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:236px; left:410px;"/>
<input type="text" name="t1ck3" id="t1ck3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:236px; left:660px;"/>
<input type="text" name="t1cz4" id="t1cz4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:276px; left:410px;"/>
<input type="text" name="t1ck4" id="t1ck4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:276px; left:660px;"/>
<input type="text" name="t1cz5" id="t1cz5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:317px; left:410px;"/>
<input type="text" name="t1ck5" id="t1ck5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:317px; left:660px;"/>

<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:771px; left:500px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:810px; left:500px;"/>
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:850px; left:500px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:889px; left:500px;"/>
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:928px; left:500px;"/>
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:967px; left:500px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1011px; left:500px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1056px; left:500px;"/>
<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1102px; left:500px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1141px; left:500px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1181px; left:500px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1220px; left:500px;"/>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str5.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 5.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- VI. ODDIEL pokracovanie -->
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:114px; left:500px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:153px; left:500px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:193px; left:500px;"/>
<input type="text" name="r52" id="r52" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:246px; left:500px;"/>

<!-- VII. ODDIEL -->
<!-- Tabulka 2 -->
<input type="text" name="t2p1" id="t2p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:520px; left:410px;"/>
<input type="text" name="t2v1" id="t2v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:520px; left:660px;"/>
<input type="text" name="t2p2" id="t2p2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:570px; left:410px;"/>
<input type="text" name="t2v2" id="t2v2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:570px; left:660px;"/>
<input type="text" name="t2p3" id="t2p3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:632px; left:410px;"/>
<input type="text" name="t2v3" id="t2v3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:632px; left:660px;"/>
<input type="text" name="t2p4" id="t2p4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:682px; left:410px;"/>
<input type="text" name="t2v4" id="t2v4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:682px; left:660px;"/>
<input type="text" name="t2p5" id="t2p5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:732px; left:410px;"/>
<input type="text" name="t2v5" id="t2v5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:732px; left:660px;"/>
<input type="text" name="t2p6" id="t2p6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:782px; left:410px;"/>
<input type="text" name="t2v6" id="t2v6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:782px; left:660px;"/>
<input type="text" name="t2p7" id="t2p7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:820px; left:410px;"/>
<input type="text" name="t2v7" id="t2v7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:820px; left:660px;"/>
<input type="text" name="t2p8" id="t2p8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:865px; left:410px;"/>
<input type="text" name="t2v8" id="t2v8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:865px; left:660px;"/>
<input type="text" name="t2p9" id="t2p9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:915px; left:410px;"/>
<input type="text" name="t2v9" id="t2v9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:915px; left:660px;"/>
<input type="text" name="t2p10" id="t2p10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:965px; left:410px;"/>
<input type="text" name="t2v10" id="t2v10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:965px; left:660px;"/>
<input type="text" name="t2p11" id="t2p11" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1015px; left:410px;"/>
<input type="text" name="t2v11" id="t2v11" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1015px; left:660px;"/>
<input type="text" name="t2p12" id="t2p12" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1060px; left:410px;"/>
<input type="text" name="t2v12" id="t2v12" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1060px; left:660px;"/>
<input type="text" name="t2p13" id="t2p13" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1110px; left:410px;"/>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str6.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 6.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- VII. ODDIEL pokracovanie -->
<input type="text" name="r53" id="r53" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:247px; left:482px;"/>
<input type="text" name="r54" id="r54" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:285px; left:482px;"/>
<input type="text" name="r55" id="r55" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:324px; left:482px;"/>

<!-- VIII. ODDIEL -->
<!-- Tabulka 3 -->
<input type="text" name="t3p1" id="t3p1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:486px; left:411px;"/>
<input type="text" name="t3v1" id="t3v1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:486px; left:661px;"/>
<input type="text" name="t3p2" id="t3p2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:535px; left:411px;"/>
<input type="text" name="t3v2" id="t3v2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:535px; left:661px;"/>
<input type="text" name="t3p3" id="t3p3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:575px; left:411px;"/>
<input type="text" name="t3v3" id="t3v3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:575px; left:661px;"/>
<input type="text" name="t3p4" id="t3p4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:613px; left:411px;"/>
<input type="text" name="t3v4" id="t3v4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:613px; left:661px;"/>
<input type="text" name="t3p5" id="t3p5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:652px; left:411px;"/>
<input type="text" name="t3v5" id="t3v5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:652px; left:661px;"/>
<input type="text" name="t3p6" id="t3p6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:697px; left:411px;"/>
<input type="text" name="t3v6" id="t3v6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:697px; left:661px;"/>
<input type="text" name="t3p7" id="t3p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:755px; left:411px;"/>
<input type="text" name="t3v7" id="t3v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:755px; left:661px;"/>
<input type="text" name="t3p8" id="t3p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:809px; left:411px;"/>
<input type="text" name="t3v8" id="t3v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:809px; left:661px;"/>
<input type="text" name="t3p9" id="t3p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:847px; left:411px;"/>
<input type="text" name="t3v9" id="t3v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:847px; left:661px;"/>
<input type="text" name="t3p10" id="t3p10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:886px; left:411px;"/>
<input type="text" name="t3v10" id="t3v10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:886px; left:661px;"/>
<input type="text" name="t3p11" id="t3p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:925px; left:411px;"/>
<input type="text" name="t3v11" id="t3v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:925px; left:661px;"/>
<input type="text" name="t3p12" id="t3p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:965px; left:411px;"/>
<input type="text" name="t3v12" id="t3v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:965px; left:661px;"/>
<input type="text" name="t3p13" id="t3p13" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1009px; left:411px;"/>
<input type="text" name="t3p14" id="t3p14" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1053px; left:411px;"/>
<input type="text" name="t3v14" id="t3v14" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1053px; left:661px;"/>
<?php                                        } ?>


<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str7.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 7.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- VIII. ODDIEL pokracovanie -->
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:336px; left:441px;"/>
<input type="text" name="r57" id="r57" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:375px; left:441px;"/>
<input type="text" name="r58" id="r58" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:415px; left:441px;"/>

<!-- IX. ODDIEL -->
<input type="text" name="rr59" id="rr59" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:514px; left:380px;"/>
<input type="text" name="r59" id="r59" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:514px; left:506px;"/>
<input type="text" name="rr60" id="rr60" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:555px; left:380px;"/>
<input type="text" name="r60" id="r60" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:555px; left:506px;"/>
<input type="text" name="rr61" id="rr61" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:595px; left:380px;"/>
<input type="text" name="r61" id="r61" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:595px; left:506px;"/>
<input type="text" name="rr62" id="rr62" onkeyup="CiarkaNaBodku(this);" style="width:82px; top:635px; left:380px;"/>
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:635px; left:506px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:675px; left:506px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:795px; left:506px;"/>
<input type="text" name="r65" id="r65" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:905px; left:506px;"/>
<input type="text" name="r66" id="r66" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:950px; left:506px;"/>
<input type="text" name="r67" id="r67" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:995px; left:506px;"/>
<input type="text" name="r68" id="r68" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1035px; left:506px;"/>
<input type="text" name="r69" id="r69" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1084px; left:506px;"/>
<input type="text" name="r70" id="r70" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1132px; left:506px;"/>
<input type="text" name="r71" id="r71" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1180px; left:506px;"/>
<?php                                        } ?>


<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str8.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 8.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- X. ODDIEL -->
<input type="text" name="r72" id="r72" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:152px; left:488px;"/>
<input type="text" name="r73" id="r73" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:196px; left:580px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocetOP();" title="Vypo��ta� odpo��tate�n� polo�ku na da�ovn�ka" class="btn-row-tool" style="top:200px; left:750px;">
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:235px; left:580px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="namanzelku();" title="Vypo��ta� odpo��tate�n� polo�ku na man�elku" class="btn-row-tool" style="top:230px; left:750px;"> <!-- dopyt, m� to tu by� -->
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:274px; left:556px;"/>
<input type="text" name="r76" id="r76" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:313px; left:556px;"/>
<input type="text" name="r77" id="r77" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:352px; left:488px;"/>
<input type="text" name="r78" id="r78" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:390px; left:488px;"/>
<input type="text" name="r79" id="r79" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:430px; left:488px;"/>
<input type="text" name="r80" id="r80" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:468px; left:470px;"/>
<input type="text" name="r81" id="r81" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:518px; left:488px;"/>
<input type="text" name="r82" id="r82" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:572px; left:488px;"/>
<input type="text" name="r83" id="r83" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:617px; left:488px;"/>
<input type="text" name="r84" id="r84" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:667px; left:488px;"/>
<input type="text" name="r85" id="r85" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:721px; left:603px;"/>
<input type="text" name="r86" id="r86" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:770px; left:488px;"/>
<input type="text" name="r87" id="r87" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:810px; left:488px;"/>
<input type="text" name="r88" id="r88" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:850px; left:488px;"/>
<input type="text" name="r89" id="r89" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:898px; left:488px;"/>
<input type="text" name="r90" id="r90" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:958px; left:488px;"/>
<input type="text" name="r91" id="r91" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1018px; left:488px;"/>
<input type="text" name="r92" id="r92" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1070px; left:488px;"/>
<input type="text" name="r93" id="r93" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:1109px; left:580px;"/>
<input type="text" name="r94" id="r94" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1148px; left:488px;"/>
<input type="text" name="r95" id="r95" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:1186px; left:580px;"/>
<?php                                        } ?>


<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str9.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 9.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- X. ODDIEL pokracovanie -->
<input type="text" name="r96" id="r96" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:116px; left:585px;"/>
<input type="text" name="r97" id="r97" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:157px; left:585px;"/>
<input type="text" name="r98" id="r98" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:196px; left:585px;"/>
<input type="text" name="r99" id="r99" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:237px; left:607px;"/>
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:275px; left:493px;"/>
<input type="text" name="r101" id="r101" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:320px; left:493px;"/>
<input type="text" name="r102" id="r102" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:364px; left:493px;"/>
<input type="text" name="r103" id="r103" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:403px; left:493px;"/>
<input type="text" name="r104" id="r104" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:442px; left:493px;"/>
<input type="text" name="r105" id="r105" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:482px; left:493px;"/>
<input type="text" name="r106" id="r106" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:520px; left:493px;"/>
<input type="text" name="r107" id="r107" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:569px; left:493px;"/>
<input type="text" name="r108" id="r108" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:620px; left:493px;"/>
<input type="text" name="r109" id="r109" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:668px; left:493px;"/>
<?php                                        } ?>


<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str10.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 10.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- XI. ODDIEL -->
<input type="text" name="r110" id="r110" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:154px; left:648px;"/>
<input type="text" name="r111" id="r111" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:197px; left:628px;"/>
<input type="text" name="r112" id="r112" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:239px; left:628px;"/>
<input type="text" name="r113" id="r113" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:295px; left:628px;"/>
<input type="text" name="r114" id="r114" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:346px; left:740px;"/>
<input type="text" name="r115" id="r115" onkeyup="CiarkaNaBodku(this);" style="width:172px; top:386px; left:720px;"/>

<!-- XII. ODDIEL -->
<input type="text" name="sdnr" id="sdnr" style="width:842px; top:526px; left:51px;"/>
<input type="text" name="r117" id="r117" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:566px; left:648px;"/>
<input type="checkbox" name="ldnr" value="1" style="top:610px; left:413px;"/>
<input type="text" name="nrzsprev" id="nrzsprev" style="width:38px; top:606px; left:855px;"/>

<!-- XIII. ODDIEL -->
<input type="checkbox" name="upl50" value="1" style="top:755px; left:59px;"/>
<input type="checkbox" name="spl3d" value="1" style="top:755px; left:294px;"/>
<input type="text" name="r120" id="r120" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:793px; left:316px;"/>
<!-- Prijimatel -->
<input type="text" name="pico" id="pico" style="width:175px; top:875px; left:51px;"/>
<input type="text" name="psid" id="psid" style="width:83px; top:875px; left:258px;"/>
<input type="text" name="pfor" id="pfor" style="width:520px; top:875px; left:373px;"/>
<input type="text" name="pmen" id="pmen" style="width:842px; top:929px; left:51px;"/>
<input type="text" name="puli" id="puli" style="width:635px; top:1038px; left:51px;"/>
<input type="text" name="pcdm" id="pcdm" style="width:175px; top:1038px; left:718px;"/>
<input type="text" name="ppsc" id="ppsc" style="width:106px; top:1092px; left:51px;"/>
<input type="text" name="pmes" id="pmes" style="width:703px; top:1092px; left:190px;"/>
<?php                                         } ?>


<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str11.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 11.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- XIV. ODDIEL -->
<input type="checkbox" name="uoso" value="1" style="top:144px; left:58px;"/>
<input type="text" name="pzks1" id="pzks1" style="width:59px; top:301px; left:51px;"/>
<input type="text" name="pdrp1" id="pdrp1" style="width:14px; top:301px; left:146px;"/>
<input type="text" name="pdro1" id="pdro1" style="width:14px; top:301px; left:204px;"/>
<input type="text" name="pzpr1" id="pzpr1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:301px; left:234px;"/>
<input type="text" name="pzvd1" id="pzvd1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:301px; left:483px;"/>
<input type="text" name="pzthvd1" id="pzthvd1" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:301px; left:731px;"/>
<input type="text" name="pzks2" id="pzks2" style="width:59px; top:341px; left:51px;"/>
<input type="text" name="pdrp2" id="pdrp2" style="width:14px; top:341px; left:146px;"/>
<input type="text" name="pdro2" id="pdro2" style="width:14px; top:341px; left:204px;"/>
<input type="text" name="pzpr2" id="pzpr2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:341px; left:234px;"/>
<input type="text" name="pzvd2" id="pzvd2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:341px; left:483px;"/>
<input type="text" name="pzthvd2" id="pzthvd2" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:341px; left:731px;"/>
<input type="text" name="pzks3" id="pzks3" style="width:59px; top:381px; left:51px;"/>
<input type="text" name="pdrp3" id="pdrp3" style="width:14px; top:381px; left:146px;"/>
<input type="text" name="pdro3" id="pdro3" style="width:14px; top:381px; left:204px;"/>
<input type="text" name="pzpr3" id="pzpr3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:381px; left:234px;"/>
<input type="text" name="pzvd3" id="pzvd3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:381px; left:483px;"/>
<input type="text" name="pzthvd3" id="pzthvd3" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:381px; left:731px;"/>
<input type="text" name="pzks4" id="pzks4" style="width:59px; top:421px; left:51px;"/>
<input type="text" name="pdrp4" id="pdrp4" style="width:14px; top:421px; left:146px;"/>
<input type="text" name="pdro4" id="pdro4" style="width:14px; top:421px; left:204px;"/>
<input type="text" name="pzpr4" id="pzpr4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:421px; left:234px;"/>
<input type="text" name="pzvd4" id="pzvd4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:421px; left:483px;"/>
<input type="text" name="pzthvd4" id="pzthvd4" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:421px; left:731px;"/>
<input type="text" name="pzks5" id="pzks5" style="width:59px; top:461px; left:51px;"/>
<input type="text" name="pdrp5" id="pdrp5" style="width:14px; top:461px; left:146px;"/>
<input type="text" name="pdro5" id="pdro5" style="width:14px; top:461px; left:204px;"/>
<input type="text" name="pzpr5" id="pzpr5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:461px; left:234px;"/>
<input type="text" name="pzvd5" id="pzvd5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:461px; left:483px;"/>
<input type="text" name="pzthvd5" id="pzthvd5" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:461px; left:731px;"/>
<input type="text" name="pzks6" id="pzks6" style="width:59px; top:501px; left:51px;"/>
<input type="text" name="pdrp6" id="pdrp6" style="width:14px; top:501px; left:146px;"/>
<input type="text" name="pdro6" id="pdro6" style="width:14px; top:501px; left:204px;"/>
<input type="text" name="pzpr6" id="pzpr6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:501px; left:234px;"/>
<input type="text" name="pzvd6" id="pzvd6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:501px; left:483px;"/>
<input type="text" name="pzthvd6" id="pzthvd6" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:501px; left:731px;"/>

<textarea name="osob" id="osob" style="width:838px; height:247px; top:551px; left:53px;"><?php echo $osob; ?></textarea>
<input type="text" name="pril" id="pril" style="width:37px; top:832px; left:184px;"/>
<input type="text" name="dat" id="dat" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:905px; left:277px;"/>

<!-- XV. ODDIEL -->
<input type="checkbox" name="zdbo" value="1" style="top:987px; left:59px;"/>
<input type="checkbox" name="zpre" value="1" style="top:1016px; left:59px;"/>
<input type="checkbox" name="post" value="1" onchange="klikpost();" style="top:1060px; left:116px;"/>
<script type="text/javascript">
  function klikpost()
  {
   document.formv1.ucet.checked = false;
  }
  function klikucet()
  {
   document.formv1.post.checked = false;
  }
</script>
<?php if ( $post == 1 ) { ?>
 <script type="text/javascript">document.formv1.post.checked = "checked";</script>
<?php                   } ?>
<input type="checkbox" name="ucet" value="1" onchange="klikucet();" style="top:1060px; left:323px;"/>
<?php if ( $ucet == 1 ) { ?>
 <script type="text/javascript">document.formv1.ucet.checked = "checked";</script>
<?php                   } ?>

<input type="text" name="diban" id="diban" style="width:773px; top:1094px; left:116px;"/>
<input type="text" name="uceb" id="uceb" style="width:381px; top:1146px; left:59px;"/>
<input type="text" name="numb" id="numb" style="width:81px; top:1146px; left:483px;"/>
<input type="text" name="da2" id="da2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1206px; left:116px;"/>
<?php                                         } ?>


<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str12.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 12.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- PRILOHA 1 -->
<input type="text" name="sz1p1" id="sz1p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:225px; left:410px;"/>
<input type="text" name="sz1v1" id="sz1v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:225px; left:660px;"/>
<input type="text" name="sz2" id="sz2" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:289px; left:517px;"/>
<input type="text" name="sz3" id="sz3" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:338px; left:517px;"/>
<input type="text" name="sz4" id="sz4" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:378px; left:517px;"/>
<input type="text" name="sz5" id="sz5" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:418px; left:517px;"/>
<input type="text" name="sz6" id="sz6" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:471px; left:517px;"/>
<input type="text" name="sz7" id="sz7" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:533px; left:517px;"/>
<input type="text" name="sz8" id="sz8" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:701px; left:517px;"/>
<input type="text" name="sz9" id="sz9" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:756px; left:517px;"/>
<input type="text" name="sz10" id="sz10" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:836px; left:532px;"/>
<input type="text" name="sz11" id="sz11" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:877px; left:532px;"/>
<input type="text" name="sz12" id="sz12" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:916px; left:532px;"/>
<input type="text" name="sz13" id="sz13" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:956px; left:532px;"/>
<input type="text" name="sz14" id="sz14" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:996px; left:532px;"/>
<input type="text" name="sz15" id="sz15" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:1036px; left:532px;"/>
<input type="text" name="sz16" id="sz16" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:1082px; left:532px;"/>

<input type="text" name="szdat" id="szdat" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1180px; left:115px;"/>
<?php                                         } ?>


<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str13.jpg" alt="tla�ivo Da� z pr�jmov FO typ B pre rok 2013 13.strana 282kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo $fir_fdic; ?>" disabled="disabled" class="nofill" style="width:220px; top:68px; left:397px;"/>

<!-- PRILOHA 2 -->
<input type="text" name="pzs01" id="pzs01" onkeyup="CiarkaNaBodku(this);" style="width:280px; top:233px; left:340px;"/>
<input type="text" name="pzs02" id="pzs02" onkeyup="CiarkaNaBodku(this);" style="width:280px; top:313px; left:340px;"/>
<input type="text" name="pzd02" id="pzd02" onkeyup="CiarkaNaBodku(this);" style="width:255px; top:313px; left:638px;"/>
<input type="text" name="pzs03" id="pzs03" onkeyup="CiarkaNaBodku(this);" style="width:280px; top:402px; left:340px;"/>
<input type="text" name="pzd03" id="pzd03" onkeyup="CiarkaNaBodku(this);" style="width:255px; top:402px; left:638px;"/>
<input type="text" name="pzs04" id="pzs04" onkeyup="CiarkaNaBodku(this);" style="width:280px; top:479px; left:340px;"/>
<input type="text" name="pzd04" id="pzd04" onkeyup="CiarkaNaBodku(this);" style="width:255px; top:479px; left:638px;"/>
<input type="text" name="pzr05" id="pzr05" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:572px; left:470px;"/>
<input type="text" name="pzr07" id="pzr07" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:652px; left:470px;"/>
<input type="text" name="pzr08" id="pzr08" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:720px; left:470px;"/>
<input type="text" name="pzr09" id="pzr09" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:760px; left:470px;"/>
<input type="text" name="pzr10" id="pzr10" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:807px; left:470px;"/>
<input type="text" name="pzr11" id="pzr11" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:902px; left:470px;"/>
<input type="text" name="pzr12" id="pzr12" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:977px; left:470px;"/>
<input type="text" name="pzr13" id="pzr13" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:1030px; left:631px;"/>
<input type="text" name="pzr14" id="pzr14" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1075px; left:470px;"/>
<input type="text" name="pzr15" id="pzr15" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1121px; left:470px;"/>
<input type="text" name="pzr16" id="pzr16" onkeyup="CiarkaNaBodku(this);" style="width:290px; top:1174px; left:470px;"/>
<input type="text" name="pzdat" id="pzdat" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1234px; left:139px;"/>
<?php                                         } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1&prepocitaj=101', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2&prepocitaj=101', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3&prepocitaj=101', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4&prepocitaj=101', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5&prepocitaj=101', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=6&prepocitaj=101', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=7&prepocitaj=101', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=8&prepocitaj=101', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=9&prepocitaj=101', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=10&prepocitaj=101', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=11&prepocitaj=101', '_self');" class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=12&prepocitaj=101', '_self');" class="<?php echo $clas12; ?> toleft">12</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=13&prepocitaj=101', '_self');" class="<?php echo $clas13; ?> toleft">13</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav udaje


/////////////////////////////////////////////////VYTLAC ROCNE
if ( $copern == 10 )
{
if ( File_Exists ("../tmp/priznaniefob.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/priznaniefob.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE F$kli_vxcf"."_mzdpriznanie_fob.oc = $cislo_oc AND konx1 = 0 ORDER BY oc";

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
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,43,"                          ","$rmc1",1,"L");
$text="1234567890";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//datum narodenia
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="01012010";
$text=SKDatum($hlavicka->dar);
if ( $text =='00.00.0000' OR $hlavicka->nrz == 0 ) $text="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->SetY(53);
$pdf->Cell(90,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadne","$rmc",1,"L");
$pdf->SetY(59);
$pdf->Cell(90,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$opravne","$rmc",1,"L");
$pdf->SetY(64);
$pdf->Cell(90,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$dodat","$rmc",0,"L");

//za rok
$pdf->SetY(49);
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
$pdf->Cell(175,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",1,"C");

//datum dodatocneho
$pdf->SetY(65);
$text="";
if ( $hlavicka->druh == 3 ) $text=SkDatum($hlavicka->ddp);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(145,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//sknace
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
//$sn2c=substr($sknacec,1,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1c","$rmc",1,"C");//$pdf->Cell(4,6,"$sn2c","$rmc",0,"C");

//cinnost
$pdf->SetY(74);
$pdf->Cell(51,6," ","$rmc1",0,"C");$pdf->Cell(139,11,"$hlavicka->cinnost","$rmc",1,"L");

//priezvisko FO
$pdf->Cell(190,14,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOP";
$text=$hlavicka->dprie;
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//meno FO
$pdf->Cell(3,7,"                          ","$rmc1",0,"L");
$text="ABCDEFGHIJK";
$text=$hlavicka->dmeno;
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
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//titul pred a za FO
$pdf->Cell(4,7,"                          ","$rmc1",0,"L");
$pdf->Cell(26,6,"$hlavicka->dtitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->dtitz","$rmc",1,"C");

//Adresa trvaleho pobytu
//ulica
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->duli;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t28","$rmc",0,"C");

//cislo
$text="ABCDEFGH";
$text=$hlavicka->dcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->dpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text="ABCDEFGHIJKLMNOPRSTU";
$text=$hlavicka->dmes;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");

//stat
$text=$hlavicka->xstat;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t11","$rmc",1,"C");

//nerezident
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$nrzx=" ";
if ( $hlavicka->nrz == 1 ) { $nrzx="x"; }
$pdf->Cell(111,6," ","$rmc1",0,"C");$pdf->Cell(4,3,"$nrzx","$rmc",0,"C");

//prepojenie
$prpx=" ";
if ( $hlavicka->prp == 1 ) { $prpx="x"; }
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$prpx","$rmc",1,"C");

//Adresa pobytu na uzemi SR
//ulica2
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->d2uli;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
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
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo2
$text="01234567";
$text=$hlavicka->d2cdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t08","$rmc",1,"C");

//psc2
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->d2psc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec2
$text="ABCDEFGHIJKLMNOPRSTU";
$text=$hlavicka->d2mes;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",1,"C");

//Zastupca
//priezvisko
$pdf->Cell(195,18,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOP";
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"R");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//meno
$pdf->Cell(3,7,"                          ","$rmc1",0,"L");
$text="ABCDEFGHIJK";
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
$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//titul pred a za zastupcu
$pdf->Cell(4,7,"                          ","$rmc1",0,"L");
$pdf->Cell(26,6,"$hlavicka->ztitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->ztitz","$rmc",1,"C");

//rodne cislo
$pdf->Cell(195,6,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");

//ulica
$text="ABCDEFGHIJKLMNOP";
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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//cislo
$text="ABCDEFGH";
$text=$hlavicka->zcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(195,6,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->zpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t02","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"L");

//obec
$text="ABCDEFGHIJKLMNO";
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
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");

//stat
$text="ABCDEFGHIJK";
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
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//cislo telefonu FO
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="12345678910";
$text=$hlavicka->dtel;
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
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");

//email/fax FO
$text="12345678910";
$text=$hlavicka->dmailfax;
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,6,"$text","$rmc",1,"L");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka29
$pdf->Cell(195,43,"                          ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->r29 == 0 ) $text=" ";
$pdf->Cell(158,5," ","$rmc1",0,"L");$pdf->Cell(3,5,"$text","$rmc",1,"C");

//polozka30
$pdf->Cell(195,6,"                          ","$rmc1",1,"L");
$text="1234567";
$hodx=100*$hlavicka->r30;
if ( $hodx == 0 OR $hlavicka->r29 == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(147,7," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",1,"C");

//Manzelka
//priezvisko a meno
$pdf->Cell(195,14,"                          ","$rmc1",1,"L");
$text=$hlavicka->mprie;
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(76,6,"$text","$rmc",0,"L");

//rodne cislo
$text="0123456789";
$text=$hlavicka->mrod;
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
$pdf->Cell(4,7," ","$rmc1",0,"L");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//vlastne prijmy
$text="012345";
$hodx=100*$hlavicka->mpri;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//pocet mesiacov
$text="01";
$hodx=$hlavicka->mpom;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//32Danovy bonus
//priezvisko a meno1
$pdf->Cell(195,48,"                          ","$rmc1",1,"L");
$text=$hlavicka->d1prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(56,7,"$text","$rmc",0,"L");

//rodne cislo1
$text="0123456789";
$text=$hlavicka->d1rod;
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch1
$pdf->SetY(149);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d1pom1 == 1 ) $t01="x"; if ( $hlavicka->d1pom2 == 1 ) $t02="x"; if ( $hlavicka->d1pom3 == 1 ) $t03="x";
if ( $hlavicka->d1pom4 == 1 ) $t04="x"; if ( $hlavicka->d1pom5 == 1 ) $t05="x"; if ( $hlavicka->d1pom6 == 1 ) $t06="x";
if ( $hlavicka->d1pom7 == 1 ) $t07="x"; if ( $hlavicka->d1pom8 == 1 ) $t08="x"; if ( $hlavicka->d1pom9 == 1 ) $t09="x";
if ( $hlavicka->d1pom10 == 1 ) $t10="x"; if ( $hlavicka->d1pom11 == 1 ) $t11="x"; if ( $hlavicka->d1pom12 == 1 ) $t12="x";
if ( $hlavicka->d1pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t12","$rmc",1,"R");

//priezvisko a meno2
$pdf->Cell(195,5,"                          ","$rmc1",1,"L");
$text=$hlavicka->d2prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(56,7,"$text","$rmc",0,"L");

//rodne cislo2
$text=$hlavicka->d2rod;
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch2
$pdf->SetY(159);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d2pom1 == 1 ) $t01="x"; if ( $hlavicka->d2pom2 == 1 ) $t02="x"; if ( $hlavicka->d2pom3 == 1 ) $t03="x";
if ( $hlavicka->d2pom4 == 1 ) $t04="x"; if ( $hlavicka->d2pom5 == 1 ) $t05="x"; if ( $hlavicka->d2pom6 == 1 ) $t06="x";
if ( $hlavicka->d2pom7 == 1 ) $t07="x"; if ( $hlavicka->d2pom8 == 1 ) $t08="x"; if ( $hlavicka->d2pom9 == 1 ) $t09="x";
if ( $hlavicka->d2pom10 == 1 ) $t10="x"; if ( $hlavicka->d2pom11 == 1 ) $t11="x"; if ( $hlavicka->d2pom12 == 1 ) $t12="x";
if ( $hlavicka->d2pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t12","$rmc",1,"R");

//priezvisko a meno3
$pdf->Cell(195,5,"                          ","$rmc1",1,"L");
$text=$hlavicka->d3prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(56,7,"$text","$rmc",0,"L");

//rodne cislo3
$text="0123456789";
$text=$hlavicka->d3rod;
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch3
$pdf->SetY(169);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d3pom1 == 1 ) $t01="x"; if ( $hlavicka->d3pom2 == 1 ) $t02="x"; if ( $hlavicka->d3pom3 == 1 ) $t03="x";
if ( $hlavicka->d3pom4 == 1 ) $t04="x"; if ( $hlavicka->d3pom5 == 1 ) $t05="x"; if ( $hlavicka->d3pom6 == 1 ) $t06="x";
if ( $hlavicka->d3pom7 == 1 ) $t07="x"; if ( $hlavicka->d3pom8 == 1 ) $t08="x"; if ( $hlavicka->d3pom9 == 1 ) $t09="x";
if ( $hlavicka->d3pom10 == 1 ) $t10="x"; if ( $hlavicka->d3pom11 == 1 ) $t11="x"; if ( $hlavicka->d3pom12 == 1 ) $t12="x";
if ( $hlavicka->d3pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t12","$rmc",1,"R");

//priezvisko a meno4
$pdf->Cell(195,5,"                          ","$rmc1",1,"L");
$text=$hlavicka->d4prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(56,7,"$text","$rmc",0,"L");

//rodne cislo3
$text="0123456789";
$text=$hlavicka->d4rod;
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch4
$pdf->SetY(180);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d4pom1 == 1 ) $t01="x"; if ( $hlavicka->d4pom2 == 1 ) $t02="x"; if ( $hlavicka->d4pom3 == 1 ) $t03="x";
if ( $hlavicka->d4pom4 == 1 ) $t04="x"; if ( $hlavicka->d4pom5 == 1 ) $t05="x"; if ( $hlavicka->d4pom6 == 1 ) $t06="x";
if ( $hlavicka->d4pom7 == 1 ) $t07="x"; if ( $hlavicka->d4pom8 == 1 ) $t08="x"; if ( $hlavicka->d4pom9 == 1 ) $t09="x";
if ( $hlavicka->d4pom10 == 1 ) $t10="x"; if ( $hlavicka->d4pom11 == 1 ) $t11="x"; if ( $hlavicka->d4pom12 == 1 ) $t12="x";
if ( $hlavicka->d4pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t12","$rmc",1,"R");

//polozka33
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->r33 == 1 ) $text="x";
$pdf->Cell(12,3," ","$rmc1",0,"R");$pdf->Cell(3,4,"$text","$rmc",1,"R");

//polozka34
$pdf->Cell(190,43,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r34;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka34a
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r34a;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka35
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r35;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//polozka36
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r36;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//VI. ODDIEL
//tab.1
//1.riadok
$pdf->Cell(190,29,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//6.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1v12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//kriziky perc3, perc1, perc4 a perc0
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$kriz3=" ";
if ( $hlavicka->perc3 == 1 ) $kriz3="x";
$kriz1=" ";
if ( $hlavicka->perc1 == 1 ) $kriz1="x";
$kriz4=" ";
if ( $hlavicka->perc4 == 1 ) $kriz4="x";
$kriz0=" ";
if ( $hlavicka->perc0 == 1 ) $kriz0="x";
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz3","$rmc",0,"C");$pdf->Cell(88,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz1","$rmc",1,"L");
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz4","$rmc",0,"C");$pdf->Cell(88,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz0","$rmc",1,"L");

//polozka psp6
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->psp6;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//tab.1a
//1.riadok
$pdf->Cell(190,14,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1az1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ak1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1az2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ak2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1az3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ak3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1az4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ak4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1az5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ak5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");


//tab.1b
//1.riadok
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1bz1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1bk1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1bz2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1bk2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");
                                       } //koniec 3.strany

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str4.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"R");

//tab.1c
//1.riadok
$pdf->Cell(190,14,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1cz1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ck1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1cz2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ck2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1cz3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ck3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1cz4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ck4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1cz5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

$text="0123456789";
$hodx=100*$hlavicka->t1ck5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka37
$pdf->Cell(190,98,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r37;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka38
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r38;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka39
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r39;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka40
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r40;
if ( $hodx < 0 ) $hodx=-$hodx;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka41
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r41;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka42
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r42;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka43
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r43;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka44
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r44;
if ( $hodx < 0 ) $hodx=-$hodx;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka45
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r45;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka46
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r46;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka47
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r47;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka48
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r48;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 4.strany

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str5.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str5.jpg',0,0,210,297);
}
$pdf->SetY(9);

//dic / rodne cislo
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka49
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r49;
if ( $hodx == 0 ) $hodx="";
if ( $hodx < 0 ) $hodx=-$hodx;
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka50
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r50;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka51
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r51;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka52
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r52;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//VII. ODDIEL
//tab.2
//1.riadok
$pdf->Cell(190,57,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//2.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//3.riadok
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//4.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//5.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//6.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123y56789";
$hodx=100*$hlavicka->t2p6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//7.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//8.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//9.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//10.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//11.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//12.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t2v12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//13.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t2p13;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
                                       } //koniec 5.strany

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str6.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka53
$pdf->Cell(190,34,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r53;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka54
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r54;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka55
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r55;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//VIII. ODDIEL
//tab.3
//1.riadok
$pdf->Cell(190,31,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//6.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v7;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v10;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v11;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,2,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v12;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//13.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p13;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//14.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p14;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->t3v14;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");
                                       } //koniec 6.strany

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str7.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka56
$pdf->Cell(190,55,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r56;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka57
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r57;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka58
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r58;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//IX. ODDIEL
//polozka59
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$text="0123";
$hodx=$hlavicka->rr59;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

$text="0123456789";
$hodx=100*$hlavicka->r59;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka60
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123";
$hodx=$hlavicka->rr60;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

$text="0123456789";
$hodx=100*$hlavicka->r60;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka61
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123";
$hodx=$hlavicka->rr61;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

$text="0123456789";
$hodx=100*$hlavicka->r61;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka62
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123";
$hodx=$hlavicka->rr62;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");

$text="0123456789";
$hodx=100*$hlavicka->r62;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka63
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r63;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka64
$pdf->Cell(190,22,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r64;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka65
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r65;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka66
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r66;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka67
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r67;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka68
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r68;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka69
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r69;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka70
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r70;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka71
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r71;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 7.strany

if ( $strana == 8 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str8.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//X. ODDIEL
//polozka72
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r72;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka73
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r73;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka74
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r74;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka75
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r75;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka76
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r76;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka77
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r77;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka78
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r78;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka79
$pdf->Cell(190,2,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r79;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka80
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r80;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka81
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r81;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka82
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r82;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka83
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r83;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka84
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="01234";
$hodx=100*$hlavicka->r84;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka85
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r85;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka86
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r86;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka87
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r87;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka88
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r88;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka89
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r89;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka90
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r90;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka91
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r91;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka92
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r92;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka93
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r93;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka94
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r94;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka95
$pdf->Cell(190,2,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r95;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 8.strany

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str9.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str9.jpg',0,0,210,297);
}
$pdf->SetY(9);

//dic / rodne cislo
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"L");

//polozka96
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r96;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka97
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r97;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka98
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="01234";
$hodx=100*$hlavicka->r98;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka99
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r99;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka100
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r100;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka101
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r101;
if ( $hodx == 0 ) $hodx="000";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka102
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r102;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka103
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r103;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka104
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r104;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka105
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r105;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka106
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r106;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka107
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r107;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka108
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r108;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka109
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r109;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$znamienko="";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 9.strany

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if (File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str10.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka110
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r110;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; }
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka111
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r111;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; $znamienko=""; }
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka112
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r112;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; $znamienko=""; }
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka113
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r113;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; $znamienko=""; }
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka114
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r114;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; $znamienko=""; }
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka115
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r115;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 6s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; $znamienko=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//XII. ODDIEL
//116stat danovej rezidencie
$pdf->Cell(190,26,"                          ","$rmc1",1,"L");
$text=$hlavicka->sdnr;
if ( $hlavicka->nrz == 0 ) $text="";
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");

//polozka117
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r117;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->nrz == 0 ) $text="";
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka118
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->nrz == 0 OR $hlavicka->ldnr == 0 ) $text="";
$pdf->Cell(84,4," ","$rmc1",0,"R");$pdf->Cell(3,4,"$text","$rmc",0,"C");

//polozka119
$text="+0123456789";
$hodx=$hlavicka->nrzsprev;
$text=sprintf("% 2s",$hodx);
if ( $hlavicka->nrz == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(94,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//XIII. ODDIEL
//krizik neuplatnujem a splnam 3%
$pdf->Cell(190,28,"                          ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->upl50 == 0 ) $text=" ";
$text3="x";
if ( $hlavicka->spl3d == 0 ) $text3=" ";
$pdf->Cell(6,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$text","$rmc",0,"C");$pdf->Cell(49,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text3","$rmc",1,"C");

//polozka120
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="01234567";
$hodx=100*$hlavicka->r120;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 8s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(62,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"L");

//Prijimatel
//ico/sid
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="0123456789ab";
$text=$hlavicka->pico;
$text1=$hlavicka->psid;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text1,0,1);
$t10=substr($text1,1,1);
$t11=substr($text1,2,1);
$t12=substr($text1,3,1);
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");

//pravna forma
$text="0123456789akciovsy��mng";
$text=$hlavicka->pfor;
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
$pdf->Cell(6,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t23","$rmc",1,"C");

//obchodne meno
$pdf->Cell(195,6,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZW+-1234567890";
$text=$hlavicka->pmen;
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");
//
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZW+-1234567890";
$text="";
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");

//ulica
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->puli;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");

//cislo
$text="ABCDEFGH";
$text=$hlavicka->pcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->ppsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234567";
$text=$hlavicka->pmes;
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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t29","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t30","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t31","$rmc",1,"C");
                                        } //koniec 10.strany

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str11.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str11.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//XIV. ODDIEL
//uvadzam
$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->uoso == 1 ) $text="x";
$pdf->Cell(5,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//prijmy a vydavky nerezidenta
//kod statu1
$pdf->Cell(190,33,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks1;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu1
$text1=$hlavicka->pdrp1;
$text2=$hlavicka->pdro1;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy1
$text="0123456789";
$hodx=100*$hlavicka->pzpr1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky1
$text="0123456789";
$hodx=100*$hlavicka->pzvd1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky1
$text="0123456";
$hodx=100*$hlavicka->pzthvd1;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu2
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks2;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu2
$text1=$hlavicka->pdrp2;
$text2=$hlavicka->pdro2;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy2
$text="0123456789";
$hodx=100*$hlavicka->pzpr2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky2
$text="0123456789";
$hodx=100*$hlavicka->pzvd2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky2
$text="0123456";
$hodx=100*$hlavicka->pzthvd2;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu3
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks3;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu3
$text1=$hlavicka->pdrp3;
$text2=$hlavicka->pdro3;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy3
$text="0123456789";
$hodx=100*$hlavicka->pzpr3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky3
$text="0123456789";
$hodx=100*$hlavicka->pzvd3;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky3
$text="0123456";
$hodx=100*$hlavicka->pzthvd3;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu4
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks4;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu4
$text1=$hlavicka->pdrp4;
$text2=$hlavicka->pdro4;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy4
$text="0123456789";
$hodx=100*$hlavicka->pzpr4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky4
$text="0123456789";
$hodx=100*$hlavicka->pzvd4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky4
$text="0123456";
$hodx=100*$hlavicka->pzthvd4;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu5
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks5;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu5
$text1=$hlavicka->pdrp5;
$text2=$hlavicka->pdro5;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy5
$text="0123456789";
$hodx=100*$hlavicka->pzpr5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky5
$text="0123456789";
$hodx=100*$hlavicka->pzvd5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky5
$text="0123456";
$hodx=100*$hlavicka->pzthvd5;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu6
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks6;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//druh prijmu6
$text1=$hlavicka->pdrp6;
$text2=$hlavicka->pdro6;
$pdf->Cell(6,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(9,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"R");

//prijmy6
$text="0123456789";
$hodx=100*$hlavicka->pzpr6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky6
$text="0123456789";
$hodx=100*$hlavicka->pzvd6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//z toho vydavky6
$text="0123456";
$hodx=100*$hlavicka->pzthvd6;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//osobitne zaznamy
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
if ( $hlavicka->uoso != 1 ) $hlavicka->osob=" ";
$poleosob = explode("\r\n", $hlavicka->osob);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,8,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }

//pocet priloh
$pdf->SetY(185);
$hodx=$hlavicka->pril;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(33,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"R");

//datum vyhlasenia
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$text="012345";
$text=SKDatum($hlavicka->dat);
if ( $text =='00.00.0000' ) $text="";
$pole = explode(".", $text);
$rokx="".substr($pole[2],2,2);
$text=$pole[0].$pole[1].$rokx;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(53,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(4,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(13,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",1,"C");

//XV. ODDIEL
//ziadam o
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text1=" ";
if ( $hlavicka->zdbo == 1 ) $text1="x";
$text3=" ";
if ( $hlavicka->zpre == 1 ) $text3="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text1","$rmc",1,"R");
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text3","$rmc",1,"R");

//postovou poukazkou ci na ucet
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$textp=" ";
if ( $hlavicka->post == 1 ) $textp="x";
$textb=" ";
if ( $hlavicka->ucet == 1 ) $textb="x";
$pdf->Cell(18,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textp","$rmc",0,"L");$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textb","$rmc",1,"L");

//iban
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->ucet == 1 ) $text=$hlavicka->diban;
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",1,"C");

//cislo uctu
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="SK0123456789+-ab";
$text=$hlavicka->uceb;
if ( $hlavicka->ucet == 0 ) $text="";
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t11","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t17","$rmc",0,"R");

//kod banky
$text="0123";
$text=$hlavicka->numb;
if ( $hlavicka->ucet == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"L");

//datum
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="123456";
$text=SKDatum($hlavicka->da2);
if ( $text =='00.00.0000' ) $text="";
$pole = explode(".", $text);
$rokx="".substr($pole[2],2,2);
$text=$pole[0].$pole[1].$rokx;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");
                                        } //koniec 11.strany

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str12.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str12.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//PRILOHA 1
//1.riadok
$pdf->Cell(190,29,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz1p1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->sz1v1;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//2.riadok
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz2;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz3;
if ( $hodx == 0 ) $hodx="";
if ( $hodx < 0 ) { $hodx=-$hodx; }
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz4;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz5;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//6.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz6;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz7;
if ( $hodx == 0 ) $hodx="";
if ( $hodx < 0 ) { $hodx=-$hodx; }
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,32,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz8;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz9;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz10;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz11;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz12;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//13.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//14.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz14;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//15.riadok
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz15;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//16.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz16;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//datum
$pdf->Cell(190,17,"                          ","$rmc1",1,"L");
$text="01012010";
$text=SKDatum($hlavicka->szdat);
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");
                                        } //koniec 12.strany

if ( $strana == 13 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str13.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_str13.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//PRILOHA 2
//1.riadok
$pdf->Cell(190,31,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzs01;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(67,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzs02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(67,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->pzd02;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 11s",$hodx);
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");

//3.riadok
$pdf->Cell(190,15,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzs03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(67,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->pzd03;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 11s",$hodx);
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");

//4.riadok
$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzs04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(67,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");

$text="0123456789";
$hodx=100*$hlavicka->pzd04;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 11s",$hodx);
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");

//5.riadok
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr05;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr07;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr08;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr09;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr10;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr11;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr12;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//13.riadok
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//14.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr14;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//15.riadok
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr15;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//16.riadok
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->pzr16;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 12s",$hodx);
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
$pdf->Cell(96,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"R");

//datum
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="01012010";
$text=SKDatum($hlavicka->pzdat);
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
$pdf->Cell(23,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");
                                        } //koniec 13.strany
  }
$i = $i + 1;
  }
$pdf->Output("../tmp/priznaniefob.$kli_uzid.pdf");

//potvrdenie o podani
if ( $copern == 10 ) {
if ( File_Exists("../tmp/potvrdfob$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdfob$kli_vume.$kli_uzid.pdf"); }
     $sirka_vyska="210,320";
     $velkost_strany = explode(",", $sirka_vyska);
     $pdf=new FPDF("P","mm", $velkost_strany );

$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',12);

if ( File_Exists('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dpfob2013/FOBv13_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za rok
$pdf->Cell(190,25,"                          ","$rmc1",1,"L");
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(35,6,"$kli_vrok","$rmc",1,"C");

//priezvisko
$pdf->Cell(190,29,"                          ","$rmc1",1,"L");
$text=$hlavicka->dprie;
$pdf->Cell(14,7," ","$rmc1",0,"L");$pdf->Cell(141,6,"$text","$rmc",1,"L");

//meno
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text=$hlavicka->dmeno;
$pdf->Cell(14,7," ","$rmc1",0,"R");$pdf->Cell(46,7,"$text","$rmc",0,"L");

//dic
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
if ( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
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
$pdf->Cell(25,8," ","$rmc1",0,"R");$pdf->Cell(7,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");$pdf->Cell(7,7,"$C","$rmc",0,"C");
$pdf->Cell(7,7,"$D","$rmc",0,"C");$pdf->Cell(7,7,"$E","$rmc",0,"C");$pdf->Cell(7,7,"$F","$rmc",0,"C");$pdf->Cell(7,7,"$G","$rmc",0,"C");
$pdf->Cell(7,7,"$H","$rmc",0,"C");$pdf->Cell(7,7,"$I","$rmc",0,"C");$pdf->Cell(7,7,"$J","$rmc",1,"C");

//ulica
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(141,7,"$hlavicka->duli $hlavicka->dcdm","$rmc",1,"L");

//psc a nazov
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(26,5,"$hlavicka->dpsc","$rmc",0,"L");$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(95,5,"$hlavicka->dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(46,7,"$hlavicka->xstat","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$r78=$hlavicka->r78; if ( $r78 == 0 ) $r78="";
$r92=$hlavicka->r92; if ( $r92 == 0 ) $r92="";
$r108=$hlavicka->r108;
$r109=$hlavicka->r109;
if ( $r108 == 0 ) { $r108=""; }
if ( $r109 == 0 ) { $r109=""; }
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r78","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r92","$rmc",1,"R");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r108","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r109","$rmc",1,"R");

$pdf->Output("../tmp/potvrdfob$kli_vxcf.$kli_uzid.pdf");
                     } //koniec potvrdenia o podani

//exit;
?>

<?php if( $xml == 0 ) { ?>
<script type="text/javascript"> var okno = window.open("../tmp/priznaniefob.<?php echo $kli_uzid; ?>.pdf","_self"); </script>
<?php                 } ?>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO


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