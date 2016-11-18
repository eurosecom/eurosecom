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

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/dpfob2016/dpfob_v16";
$jpg_popis="tlaËivo DaÚ z prÌjmov FO typ B pre rok ".$kli_vrok;

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
$rmc=1;
$rmc1=0;

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie bude pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }


//nacitanie minuleho roka do FOB
if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do FOB z firmy minulÈho roka ?") )
         { window.close() }
else
         { location.href='priznanie_fob2016.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                  }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

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
//$dmeno = strip_tags($_REQUEST['dmeno']);
//$dtitl = strip_tags($_REQUEST['dtitl']);
//$dtitz = strip_tags($_REQUEST['dtitz']);
//$duli = strip_tags($_REQUEST['duli']);
//$dcdm = strip_tags($_REQUEST['dcdm']);
//$dpsc = strip_tags($_REQUEST['dpsc']);
//$dmes = strip_tags($_REQUEST['dmes']);
//$xstat = strip_tags($_REQUEST['xstat']);
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
$t1ak1 = 1*$_REQUEST['t1ak1'];
$t1ak2 = 1*$_REQUEST['t1ak2'];
$t1ak3 = 1*$_REQUEST['t1ak3'];

$uppr1 = 1*$_REQUEST['uppr1'];
$uppr3 = 1*$_REQUEST['uppr3'];
$uppr4 = 1*$_REQUEST['uppr4'];

$uvp61 = 1*$_REQUEST['uvp61'];
$uvp64 = 1*$_REQUEST['uvp64'];
$uvp61m = 1*$_REQUEST['uvp61m'];
$uvp64m = 1*$_REQUEST['uvp64m'];

$uos61 = 1*$_REQUEST['uos61'];
$uos64 = 1*$_REQUEST['uos64'];
$kos61 = 1*$_REQUEST['kos61'];
$kos64 = 1*$_REQUEST['kos64'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" uppr1='$uppr1', uppr3='$uppr3', uppr4='$uppr4', uvp61='$uvp61', uvp64='$uvp64', uvp61m='$uvp61m', uvp64m='$uvp64m', ".
" uos61='$uos61', uos64='$uos64', kos61='$kos61', kos64='$kos64', ".
" t1p1='$t1p1', t1p2='$t1p2', t1p3='$t1p3', t1p4='$t1p4', t1p5='$t1p5', t1p6='$t1p6',  ".
" t1p7='$t1p7', t1p8='$t1p8', t1p9='$t1p9', t1p10='$t1p10', t1p11='$t1p11', t1p12='$t1p12', ".
" t1v1='$t1v1', t1v2='$t1v2', t1v3='$t1v3', t1v4='$t1v4', t1v5='$t1v5', t1v6='$t1v6', ".
" t1v7='$t1v7', t1v8='$t1v8', t1v9='$t1v9', t1v10='$t1v10', t1v11='$t1v11', t1v12='$t1v12', ".
" perc0='$perc0', perc1='$perc1', perc3='$perc3', perc4='$perc4', psp6='$psp6', ".
" t1az1='$t1az1', t1az2='$t1az2', t1az3='$t1az3', t1ak1='$t1ak1', t1ak2='$t1ak2', t1ak3='$t1ak3' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 4 ) {
$t1az4 = 1*$_REQUEST['t1az4'];
$t1az5 = 1*$_REQUEST['t1az5'];
$t1ak4 = 1*$_REQUEST['t1ak4'];
$t1ak5 = 1*$_REQUEST['t1ak5'];

$t1bz1 = 1*$_REQUEST['t1bz1'];
$t1bz2 = 1*$_REQUEST['t1bz2'];
$t1bk1 = 1*$_REQUEST['t1bk1'];
$t1bk2 = 1*$_REQUEST['t1bk2'];

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
$r39pu = 1*$_REQUEST['r39pu'];
$r40pu = 1*$_REQUEST['r40pu'];

$r41 = 1*$_REQUEST['r41'];
$r42 = 1*$_REQUEST['r42'];
$r43 = 1*$_REQUEST['r43'];
$r44 = 1*$_REQUEST['r44'];
$r45 = 1*$_REQUEST['r45'];
$r46 = 1*$_REQUEST['r46'];
$r47 = 1*$_REQUEST['r47'];
$r48 = 1*$_REQUEST['r48'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t1az4='$t1az4', t1az5='$t1az5', t1ak4='$t1ak4', t1ak5='$t1ak5', r39pu='$r39pu', r40pu='$r40pu',".
" t1bz1='$t1bz1', t1bz2='$t1bz2', t1bk1='$t1bk1', t1bk2='$t1bk2', ".
" t1cz1='$t1cz1', t1ck1='$t1ck1', t1cz2='$t1cz2', t1ck2='$t1ck2', t1cz3='$t1cz3', t1ck3='$t1ck3', t1cz4='$t1cz4', t1ck4='$t1ck4', t1cz5='$t1cz5', t1ck5='$t1ck5', ".
" r37='$r37', r38='$r38', r39='$r39', r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44', r45='$r45', r46='$r46', r47='$r47', r48='$r48'  ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 5 ) {
$r49 = 1*$_REQUEST['r49'];
$r50 = 1*$_REQUEST['r50'];
$r51 = 1*$_REQUEST['r51'];
$r52 = 1*$_REQUEST['r52'];
$r53 = 1*$_REQUEST['r53'];
$r54 = 1*$_REQUEST['r54'];
$r55 = 1*$_REQUEST['r55'];
$r56 = 1*$_REQUEST['r56'];
$r57 = 1*$_REQUEST['r57'];
$r58 = 1*$_REQUEST['r58'];
$r59 = 1*$_REQUEST['r59'];
$r60 = 1*$_REQUEST['r60'];
$r61 = 1*$_REQUEST['r61'];
$r62 = 1*$_REQUEST['r62'];
$r63 = 1*$_REQUEST['r63'];
$r64 = 1*$_REQUEST['r64'];
$r65 = 1*$_REQUEST['r65'];
$t2p1 = 1*$_REQUEST['t2p1'];
$t2v1 = 1*$_REQUEST['t2v1'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r49='$r49', r50='$r50', r51='$r51', r52='$r52', r53='$r53', r54='$r54', r55='$r55', ".
" r56='$r56', r57='$r57', r58='$r58', r59='$r59', r60='$r60', r61='$r61', r62='$r62', r63='$r63', r64='$r64', r65='$r65', ".
" t2p1='$t2p1', t2v1='$t2v1' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 6 ) {
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
$r66 = 1*$_REQUEST['r66'];
$r67 = 1*$_REQUEST['r67'];
$r68 = 1*$_REQUEST['r68'];
$t3p1 = 1*$_REQUEST['t3p1'];
$t3p2 = 1*$_REQUEST['t3p2'];
$t3v1 = 1*$_REQUEST['t3v1'];
$t3v2 = 1*$_REQUEST['t3v2'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t2p2='$t2p2', t2p3='$t2p3', t2p4='$t2p4', t2p5='$t2p5', t2p6='$t2p6', t2p7='$t2p7', ".
" t2p8='$t2p8', t2p9='$t2p9', t2p10='$t2p10', t2p11='$t2p11', t2p12='$t2p12', t2p13='$t2p13', ".
" t2v2='$t2v2', t2v3='$t2v3', t2v4='$t2v4', t2v5='$t2v5', t2v6='$t2v6', t2v7='$t2v7',".
" t2v8='$t2v8', t2v9='$t2v9', t2v10='$t2v10', t2v11='$t2v11', t2v12='$t2v12', ".
" r66='$r66', r67='$r67', r68='$r68', ".
" t3p1='$t3p1', t3p2='$t3p2', ".
" t3v1='$t3v1', t3v2='$t3v2' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 7 ) {
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
//$t3p15 = 1*$_REQUEST['t3p15'];
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
$t3v13 = $_REQUEST['t3v13'];
//$t3v14 = 1*$_REQUEST['t3v14'];
//$t3v15 = $_REQUEST['t3v15'];
//$rr59 = $_REQUEST['rr59'];
//$rr60 = $_REQUEST['rr60'];
//$rr61 = $_REQUEST['rr61'];
//$rr62 = $_REQUEST['rr62'];
//$rr63 = $_REQUEST['rr63'];
//$rr64 = $_REQUEST['rr64'];
//$rr65 = $_REQUEST['rr65'];
//$rr66 = $_REQUEST['rr66'];
//$rr67 = $_REQUEST['rr67'];
//$rr68 = $_REQUEST['rr68'];
//$rr69 = $_REQUEST['rr69'];
//$rr70 = $_REQUEST['rr70'];
$r69 = 1*$_REQUEST['r69'];
$r70 = 1*$_REQUEST['r70'];
$r71 = 1*$_REQUEST['r71'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t3p3='$t3p3', t3p4='$t3p4', t3p5='$t3p5', t3p6='$t3p6', t3p7='$t3p7', ".
" t3p8='$t3p8', t3p9='$t3p9', t3p10='$t3p10', t3p11='$t3p11', t3p12='$t3p12', t3p13='$t3p13', t3p14='$t3p14', ".
" t3v3='$t3v3', t3v4='$t3v4', t3v5='$t3v5', t3v6='$t3v6', t3v7='$t3v7', ".
" t3v8='$t3v8', t3v9='$t3v9', t3v10='$t3v10', t3v11='$t3v11', t3v12='$t3v12', t3v13='$t3v13', ".
" r69='$r69', r70='$r70', r71='$r71' ".
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
$r96 = 1*$_REQUEST['r96'];


$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r72='$r72', r73='$r73', r74='$r74', r75='$r75', r76='$r76', r77='$r77', r78='$r78', r79='$r79', r80='$r80', r81='$r81', r82='$r82', r83='$r83', ".
" r84='$r84', r85='$r85', r86='$r86', r87='$r87', r88='$r88', r89='$r89', r90='$r90', r91='$r91', r92='$r92', r93='$r93', r94='$r94', r95='$r95', r96='$r96'  ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 9 ) {
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
$r110 = 1*$_REQUEST['r110'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r97='$r97', r98='$r98', r99='$r99', r100='$r100', r101='$r101', r102='$r102', r103='$r103', ".
" r104='$r104', r105='$r105', r106='$r106', r107='$r107', r108='$r108', r109='$r109', r110='$r110' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 10 ) {

$r111 = 1*$_REQUEST['r111'];
$r112 = 1*$_REQUEST['r112'];
$r113 = 1*$_REQUEST['r113'];
$r114 = 1*$_REQUEST['r114'];
$r115 = 1*$_REQUEST['r115'];
$r116 = 1*$_REQUEST['r116'];
$r117 = 1*$_REQUEST['r117'];
$r118 = 1*$_REQUEST['r118'];
$r119 = 1*$_REQUEST['r119'];
$r120 = 1*$_REQUEST['r120'];
//$r121 = 1*$_REQUEST['r121'];
//$r122 = 1*$_REQUEST['r122'];
$sdnr = strip_tags($_REQUEST['sdnr']);
//$udnr = $_REQUEST['udnr'];
//$r124 = 1*$_REQUEST['r124'];
$ldnr = 1*$_REQUEST['ldnr'];
$nrzsprev = 1*$_REQUEST['nrzsprev'];
$upl50 = 1*$_REQUEST['upl50'];
$spl3d = 1*$_REQUEST['spl3d'];
$r123 = 1*$_REQUEST['r123'];
//$r127 = 1*$_REQUEST['r127'];
$pico = strip_tags($_REQUEST['pico']);
$psid = strip_tags($_REQUEST['psid']);
$pfor = strip_tags($_REQUEST['pfor']);
$pmen = strip_tags($_REQUEST['pmen']);
$puli = strip_tags($_REQUEST['puli']);
$pcdm = strip_tags($_REQUEST['pcdm']);
$ppsc = strip_tags($_REQUEST['ppsc']);
$pmes = strip_tags($_REQUEST['pmes']);
$zslu = 1*$_REQUEST['zslu'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r111='$r111', r112='$r112', r113='$r113', r114='$r114', r115='$r115', r116='$r116', r117='$r117', r118='$r118', r119='$r119', r120='$r120', ".
" sdnr='$sdnr', ldnr='$ldnr', nrzsprev='$nrzsprev', upl50='$upl50', spl3d='$spl3d', r120='$r120', r123='$r123', ".
" pico='$pico', psid='$psid', pfor='$pfor', pmen='$pmen', puli='$puli', pcdm='$pcdm', ppsc='$ppsc', pmes='$pmes', zslu='$zslu' ".
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
if( $pril < 2 ) { $pril=2; }
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
$prpdzc = $_REQUEST['prpdzc'];
$prpdzcsql=Sqldatum($prpdzc);
$prpzo1 = $_REQUEST['prpzo1'];
$prpzo1sql=Sqldatum($prpzo1);
$prpzo2 = $_REQUEST['prpzo2'];
$prpzo2sql=Sqldatum($prpzo2);
$prpzo3 = $_REQUEST['prpzo3'];
$prpzo3sql=Sqldatum($prpzo3);
$prpzo4 = $_REQUEST['prpzo4'];
$prpzo4sql=Sqldatum($prpzo4);
$prpzo5 = $_REQUEST['prpzo5'];
$prpzo5sql=Sqldatum($prpzo5);
$prpzd1 = $_REQUEST['prpzd1'];
$prpzd1sql=Sqldatum($prpzd1);
$prpzd2 = $_REQUEST['prpzd2'];
$prpzd2sql=Sqldatum($prpzd2);
$prpzd3 = $_REQUEST['prpzd3'];
$prpzd3sql=Sqldatum($prpzd3);
$prpzd4 = $_REQUEST['prpzd4'];
$prpzd4sql=Sqldatum($prpzd4);
$prpzd5 = $_REQUEST['prpzd5'];
$prpzd5sql=Sqldatum($prpzd5);

$prpvz1 = 1*$_REQUEST['prpvz1'];
$prpvz2 = 1*$_REQUEST['prpvz2'];
$prpvz3 = 1*$_REQUEST['prpvz3'];
$prpvz4 = 1*$_REQUEST['prpvz4'];
$prpvz5 = 1*$_REQUEST['prpvz5'];

$prpod1 = 1*$_REQUEST['prpod1'];
$prpod2 = 1*$_REQUEST['prpod2'];
$prpod3 = 1*$_REQUEST['prpod3'];
$prpod4 = 1*$_REQUEST['prpod4'];
$prpod5 = 1*$_REQUEST['prpod5'];

$prptxt = strip_tags($_REQUEST['prptxt']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" prpdzc='$prpdzcsql', prptxt='$prptxt', ".
" prpzo1='$prpzo1sql', prpzo2='$prpzo2sql', prpzo3='$prpzo3sql', prpzo4='$prpzo4sql', prpzo5='$prpzo5sql', ".
" prpzd1='$prpzd1sql', prpzd2='$prpzd2sql', prpzd3='$prpzd3sql', prpzd4='$prpzd4sql', prpzd5='$prpzd5sql', ".
" prpvz1='$prpvz1', prpvz2='$prpvz2', prpvz3='$prpvz3', prpvz4='$prpvz4', prpvz5='$prpvz5', ".
" prpod1='$prpod1', prpod2='$prpod2', prpod3='$prpod3', prpod4='$prpod4', prpod5='$prpod5' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 13 ) {
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
$vpdu = 1*$_REQUEST['vpdu'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" sz1p1='$sz1p1', sz1v1='$sz1v1', sz2='$sz2', sz3='$sz3', sz4='$sz4', sz5='$sz5', sz6='$sz6', sz7='$sz7', sz8='$sz8', sz9='$sz9', sz10='$sz10', ".
" sz11='$sz11', sz12='$sz12', sz13='$sz13', sz14='$sz14', sz15='$sz15', sz16='$sz16', szdat='$szdatsql', vpdu='$vpdu' ".
" WHERE oc = $cislo_oc";
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
//zmeny pre rok 2014
$sql = "SELECT r40pu FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD new2014 DECIMAL(2,0) NOT NULL AFTER sz11";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uppr1 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uppr3 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uppr4 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uvp61 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uvp64 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uvp61m DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uvp64m DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uos61 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD uos64 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD kos61 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD kos64 DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD vpdu DECIMAL(2,0) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r39pu DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r40pu DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");
}
//zmeny pre rok 2015
$sql = "SELECT t3v15 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
//priloha 1 o projektoch
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD new2015 DECIMAL(2,0) NOT NULL AFTER uppr1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpdzc DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzo1 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzd1 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpvz1 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpod1 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzo2 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzd2 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpvz2 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpod2 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzo3 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzd3 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpvz3 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpod3 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzo4 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzd4 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpvz4 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpod4 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzo5 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpzd5 DATE NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpvz5 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpod5 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpods DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpodv DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prptxt TEXT NOT NULL AFTER new2015";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prpcp DECIMAL(4,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD prppp DECIMAL(4,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");

//ostatne
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r50 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r51 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r52 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD zslu DECIMAL(2,0) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p15 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v15 DECIMAL(10,2) DEFAULT 0 AFTER new2015";
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

$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" ( druh,oc,dmeno,dprie,dtitl,rdc,rdk,dar,duli,dcdm,dpsc,dmes,dtel ) VALUES ".
" ( 1, '$cislo_oc', '', '', '', '', '', '', '', '', '', '', '' )";
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

//vsetky vypocty su upravene na rok 2015 
//vypocty
//odstavene vypocty
//$prepocitaj=0;
$alertprepocet="";
if ( ( $copern == 10 OR $copern == 20 ) AND $prepocitaj == 1 )
{
$alertprepocet="!!! PrepoËÌtavam hodnoty v riadkoch !!!";

//zaklady dane zo zav.cinnosti 2015 str2
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r36=r34-r35 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 1.(na str3) 2015
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
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r39=r37-r38+r39pu WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r40=-r39, r39=0 WHERE oc = $cislo_oc AND r39 < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r40=r40pu WHERE oc = $cislo_oc AND r39 = 0 AND r40pu > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r43=r39-r40+r41-r42 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r44=-r43, r43=0 WHERE oc = $cislo_oc AND r43 < 0";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 1.(na str4) 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r58=t1p12, r59=t1v12, r60=0, r65=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r60=r58-r59 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=r60+r61+r63-r64 WHERE oc = $cislo_oc AND r61 >= 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=r60 WHERE oc = $cislo_oc AND r65 < 0 AND r61 >= 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=r60+r62+r63-r64 WHERE oc = $cislo_oc AND r62 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r65=r60 WHERE oc = $cislo_oc AND r65 < 0 AND r62 > 0 ";
$oznac = mysql_query("$sqtoz");

//sucet danovych strat (na str 5) 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r53=r45+r46+r47+r48+r49 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r54=r53/4 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r55=r43-r54 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r55=0 WHERE oc = $cislo_oc AND r55 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r56=prpodv WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r57=r55-r56 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r57=0 WHERE oc = $cislo_oc AND r57 < 0 ";
$oznac = mysql_query("$sqtoz");

//prijmy,vydavky z tabulky 2.(na str 6) 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t2p11=t2p1+t2p2+t2p3+t2p4+t2p5+t2p6+t2p7+t2p8+t2p9+t2p10 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t2v11=t2v1+t2v2+t2v3+t2v4+t2v5+t2v6+t2v7+t2v8+t2v9+t2v10 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r66=t2p11, r67=t2v11, r68=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r68=r66-r67 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r68=0 WHERE oc = $cislo_oc AND r68 < 0";
$oznac = mysql_query("$sqtoz");

//vypocet zakladu dane z ostatnych prijmov tabulka 3.(na str.6,7) 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3p15=t3p1+t3p2+t3p3+t3p4+t3p5+t3p6+t3p7+t3p8+t3p9+t3p10+t3p11+t3p12+t3p13+t3p14 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3v15=t3v1+t3v2+t3v3+t3v4+t3v5+t3v6+t3v7+t3v8+t3v9+t3v10+t3v11+t3v12+t3v13 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r69=t3p15, r70=t3v15, r71=r69-r70 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


//vypocet zakladu dane str8 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r72=r36+r57 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


if ( $miliondan == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//max.nezdanitelna cast na danovnika za 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=3803.33 WHERE oc = $cislo_oc  ";
$oznac = mysql_query("$sqtoz");

//milionarska dan 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=8755.578-(r72/4) WHERE oc = $cislo_oc AND r72 > 19809.00 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, des2=ceil(des2), r73=des2/100  WHERE oc = $cislo_oc AND r72 > 19809.00 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=0 WHERE oc = $cislo_oc AND r74 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=0 WHERE oc = $cislo_oc AND r72 >= 35022.32 ";
$oznac = mysql_query("$sqtoz");
     }
//koniec max.nezdanitelna cast na danovnika za 2015

if ( $namanzelku == 1 )
     {
//nezdanitelna cast na manzelku 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=mpom*(3803.33-mpri)/12 WHERE oc = $cislo_oc AND r72 < 35022.32 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, des2=ceil(des2), r74=des2/100  WHERE oc = $cislo_oc AND r72 < 35022.32 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=mpom*(12558.906-(r72/4))/12 WHERE oc = $cislo_oc AND r72 >= 35022.32 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=des6-mpri WHERE oc = $cislo_oc AND r72 >= 35022.32 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, des2=ceil(des2), r74=des2/100  WHERE oc = $cislo_oc AND r72 >= 35022.32 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r74=0 WHERE oc = $cislo_oc AND r74 < 0 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r74=0 WHERE oc = $cislo_oc AND r72 >= 50235.63 ";
$oznac = mysql_query("$sqtoz");
     }
//nezdanitelna 2015


//vypocet zakladu dane (str 8) 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=r73+r74+r75+r76  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=r72  WHERE oc = $cislo_oc AND r77 > r72 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=r72-r77 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=0 WHERE oc = $cislo_oc AND r78 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r80=r78+r65+r68+r71+r79 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r80=0 WHERE oc = $cislo_oc AND r80 < 0 ";
$oznac = mysql_query("$sqtoz");


//dan z prijmu 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=r80*19/100 WHERE oc = $cislo_oc AND r80 <= 35022.31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=(35022.31*19/100)+((r80-35022.31)*25/100) WHERE oc = $cislo_oc AND r80 > 35022.31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob".
" SET des2=des6*100, r81=floor(des2), r81=r81/100 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r81 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan po vynati prijmov 2015 dan zo zakladu na r83 nepocitam
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r83=r80-r82 WHERE oc = $cislo_oc AND r82 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r83=0 WHERE oc = $cislo_oc AND r83 < 0 ";
$oznac = mysql_query("$sqtoz");

//dan po vynati prijmov a zapocte 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r84-r89 WHERE oc = $cislo_oc AND r83 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r81-r89 WHERE oc = $cislo_oc AND r83 = 0 ";
$oznac = mysql_query("$sqtoz");

//dan celkom 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r94=r90-r93 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vynuluj zuctovanie bonusu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r96=0, r98=0, r99=0, r100=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan znizena o dan. bonusu 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r96=r94-r95 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r96=0 WHERE oc = $cislo_oc AND r96 < 0 ";
$oznac = mysql_query("$sqtoz");

//vysporiadanie danoveho bonusu 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r98=r95-r97  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r98=0 WHERE oc = $cislo_oc AND r98 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r99=r98-r94  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r99=0 WHERE oc = $cislo_oc AND r99 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r100=r97-r95  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r100=0 WHERE oc = $cislo_oc AND r100 < 0 ";
$oznac = mysql_query("$sqtoz");

//zapl.dan z urok.prijmov 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r108=r92-r93  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan na uhradu, preplatok 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r110=0, r109=r94-r95+r97+r99+r101-r102-r103-r104-r105-r106-r107-r108 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r110=-r109, r109=0 WHERE oc = $cislo_oc AND r109 < 0 ";
$oznac = mysql_query("$sqtoz");


//str 12 Priloha 1 o projektoch 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpods=prpod1+prpod2+prpod3+prpod4+prpod5 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpodv=prpods WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpcp=0, prppp=0 WHERE prpods = 0 AND oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpcp=1, prppp=1 WHERE prpods > 0 AND oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//str13 Priloha 2 socialne a zdravotne poistenie 2015
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET sz2=sz1p1-sz1v1, sz3=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET sz3=-sz2, sz2=0  WHERE oc = $cislo_oc AND sz2 < 0";
$oznac = mysql_query("$sqtoz");
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


//FO - priezvisko,meno,tituly a trvaly pobyt z ufirdalsie
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok )
     {
$riadok=mysql_fetch_object($vysledok);
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
$dtelzu = $riadok->dtel; 
$dfaxzu = $riadok->dfax;
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
//$dprie = $fir_riadok->dprie;
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
//tuto musi brat dtel a dmailfax
$dtel = $fir_riadok->dtel;
$dmailfax = $fir_riadok->dmailfax;

if( $dtel == '' ) 
  {
$dtel=$dtelzu;
$sqlmpu = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET dtel='$dtelzu' ";
$fir_mpu = mysql_query($sqlmpu);
  }
if( $dmailfax == '' ) 
  {
$dmailfax=$dfaxzu;
$sqlmpu = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET dmailfax='$dfaxzu' ";
$fir_mpu = mysql_query($sqlmpu);
  }

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
$t1ak1 = $fir_riadok->t1ak1;
$t1ak2 = $fir_riadok->t1ak2;
$t1ak3 = $fir_riadok->t1ak3;

$uppr1 = $fir_riadok->uppr1;
$uppr3 = $fir_riadok->uppr3;
$uppr4 = $fir_riadok->uppr4;

$uvp61 = $fir_riadok->uvp61;
$uvp64 = $fir_riadok->uvp64;
$uvp61m = $fir_riadok->uvp61m;
$uvp64m = $fir_riadok->uvp64m;

$uos61 = $fir_riadok->uos61;
$uos64 = $fir_riadok->uos64;
$kos61 = $fir_riadok->kos61;
$kos64 = $fir_riadok->kos64;

                    }

if ( $strana == 4 ) {
$t1az4 = $fir_riadok->t1az4;
$t1az5 = $fir_riadok->t1az5;

$t1ak4 = $fir_riadok->t1ak4;
$t1ak5 = $fir_riadok->t1ak5;

$t1bz1 = $fir_riadok->t1bz1;
$t1bz2 = $fir_riadok->t1bz2;
$t1bk1 = $fir_riadok->t1bk1;
$t1bk2 = $fir_riadok->t1bk2;

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

$r39pu = $fir_riadok->r39pu;
$r40pu = $fir_riadok->r40pu;

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
$r53 = $fir_riadok->r53;
$r54 = $fir_riadok->r54;
$r55 = $fir_riadok->r55;
$r56 = $fir_riadok->r56;
$r57 = $fir_riadok->r57;
$r58 = $fir_riadok->r58;
$r59 = $fir_riadok->r59;
$r60 = $fir_riadok->r60;
$r61 = $fir_riadok->r61;
$r62 = $fir_riadok->r62;
$r63 = $fir_riadok->r63;
$r64 = $fir_riadok->r64;
$r65 = $fir_riadok->r65;
$t2p1 = $fir_riadok->t2p1;
$t2v1 = $fir_riadok->t2v1;

                    }

if ( $strana == 6 ) {
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
$r66 = $fir_riadok->r66;
$r67 = $fir_riadok->r67;
$r68 = $fir_riadok->r68;
$t3p1 = $fir_riadok->t3p1;
$t3p2 = $fir_riadok->t3p2;
$t3v1 = $fir_riadok->t3v1;
$t3v2 = $fir_riadok->t3v2;
                    }

if ( $strana == 7 ) {
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
$t3p15 = $fir_riadok->t3p15;
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
$t3v13 = $fir_riadok->t3v13;
$t3v15 = $fir_riadok->t3v15;
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
$r96 = $fir_riadok->r96;
                    }

if ( $strana == 9 ) {
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
$r110 = $fir_riadok->r110;
                    }

if ( $strana == 10 ) {

$r111 = $fir_riadok->r111;
$r112 = $fir_riadok->r112;
$r113 = $fir_riadok->r113;
$r114 = $fir_riadok->r114;
$r115 = $fir_riadok->r115;
$r116 = $fir_riadok->r116;
$r117 = $fir_riadok->r117;
$r118 = $fir_riadok->r118;
$r119 = $fir_riadok->r119;
$r120 = $fir_riadok->r120;
$sdnr = $fir_riadok->sdnr;
$ldnr = $fir_riadok->ldnr;
$nrzsprev = $fir_riadok->nrzsprev;
$upl50 = $fir_riadok->upl50;
$spld3d = $fir_riadok->spl3d;
$r123 = $fir_riadok->r123;
$pico = $fir_riadok->pico;
$psid = $fir_riadok->psid;
$pfor = $fir_riadok->pfor;
$pmen = $fir_riadok->pmen;
$puli = $fir_riadok->puli;
$pcdm = $fir_riadok->pcdm;
$ppsc = $fir_riadok->ppsc;
$pmes = $fir_riadok->pmes;
$zslu = $fir_riadok->zslu;
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
if ( $datsk == '00.00.0000' ) 
{ 
$datsk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$datsql=SqlDatum($datsk);
$sqlx = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET dat='$datsql' ";
$vysledekx = mysql_query("$sqlx");
}
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
$prpcp = $fir_riadok->prpcp;
$prppp = $fir_riadok->prppp;
$prpdzc = $fir_riadok->prpdzc;
$prpdzcsk=Skdatum($prpdzc);
$prpzo1 = $fir_riadok->prpzo1;
$prpzo1sk=Skdatum($prpzo1);
$prpzo2 = $fir_riadok->prpzo2;
$prpzo2sk=Skdatum($prpzo2);
$prpzo3 = $fir_riadok->prpzo3;
$prpzo3sk=Skdatum($prpzo3);
$prpzo4 = $fir_riadok->prpzo4;
$prpzo4sk=Skdatum($prpzo4);
$prpzo5 = $fir_riadok->prpzo5;
$prpzo5sk=Skdatum($prpzo5);

$prpzd1 = $fir_riadok->prpzd1;
$prpzd1sk=Skdatum($prpzd1);
$prpzd2 = $fir_riadok->prpzd2;
$prpzd2sk=Skdatum($prpzd2);
$prpzd3 = $fir_riadok->prpzd3;
$prpzd3sk=Skdatum($prpzd3);
$prpzd4 = $fir_riadok->prpzd4;
$prpzd4sk=Skdatum($prpzd4);
$prpzd5 = $fir_riadok->prpzd5;
$prpzd5sk=Skdatum($prpzd5);

$prpvz1 = $fir_riadok->prpvz1;
$prpvz2 = $fir_riadok->prpvz2;
$prpvz3 = $fir_riadok->prpvz3;
$prpvz4 = $fir_riadok->prpvz4;
$prpvz5 = $fir_riadok->prpvz5;

$prpod1 = $fir_riadok->prpod1;
$prpod2 = $fir_riadok->prpod2;
$prpod3 = $fir_riadok->prpod3;
$prpod4 = $fir_riadok->prpod4;
$prpod5 = $fir_riadok->prpod5;

$prpods = $fir_riadok->prpods;
$prpodv = $fir_riadok->prpodv;
$prptxt = $fir_riadok->prptxt;
                     }

if ( $strana == 13 ) {
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
$vpdu = $fir_riadok->vpdu;
                     }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z prÌjmov FOB</title>
<style>
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
</style>
<script type="text/javascript">
//parameter okna
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

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
<?php if ( $uppr1 == 1 ) { ?> document.formv1.uppr1.checked = "checked"; <?php } ?>
<?php if ( $uppr3 == 1 ) { ?> document.formv1.uppr3.checked = "checked"; <?php } ?>
<?php if ( $uppr4 == 1 ) { ?> document.formv1.uppr4.checked = "checked"; <?php } ?>
<?php if ( $uvp61 == 1 ) { ?> document.formv1.uvp61.checked = "checked"; <?php } ?>
<?php if ( $uvp64 == 1 ) { ?> document.formv1.uvp64.checked = "checked"; <?php } ?>
<?php if ( $uos61 == 1 ) { ?> document.formv1.uos61.checked = "checked"; <?php } ?>
<?php if ( $uos64 == 1 ) { ?> document.formv1.uos64.checked = "checked"; <?php } ?>
<?php if ( $kos61 == 1 ) { ?> document.formv1.kos61.checked = "checked"; <?php } ?>
<?php if ( $kos64 == 1 ) { ?> document.formv1.kos64.checked = "checked"; <?php } ?>

   document.formv1.uvp61m.value = '<?php echo "$uvp61m";?>';
   document.formv1.uvp64m.value = '<?php echo "$uvp64m";?>';

   document.formv1.psp6.value = '<?php echo "$psp6";?>';
   document.formv1.t1az1.value = '<?php echo "$t1az1";?>';
   document.formv1.t1az2.value = '<?php echo "$t1az2";?>';
   document.formv1.t1az3.value = '<?php echo "$t1az3";?>';

   document.formv1.t1ak1.value = '<?php echo "$t1ak1";?>';
   document.formv1.t1ak2.value = '<?php echo "$t1ak2";?>';
   document.formv1.t1ak3.value = '<?php echo "$t1ak3";?>';



<?php                                        } ?>

<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
   document.formv1.t1az4.value = '<?php echo "$t1az4";?>';
   document.formv1.t1az5.value = '<?php echo "$t1az5";?>';
   document.formv1.t1ak4.value = '<?php echo "$t1ak4";?>';
   document.formv1.t1ak5.value = '<?php echo "$t1ak5";?>';
   document.formv1.t1bz1.value = '<?php echo "$t1bz1";?>';
   document.formv1.t1bz2.value = '<?php echo "$t1bz2";?>';
   document.formv1.t1bk1.value = '<?php echo "$t1bk1";?>';
   document.formv1.t1bk2.value = '<?php echo "$t1bk2";?>';


   document.formv1.r37.value = '<?php echo "$r37";?>';
   document.formv1.r38.value = '<?php echo "$r38";?>';
   document.formv1.r39.value = '<?php echo "$r39";?>';
   document.formv1.r40.value = '<?php echo "$r40";?>';
   document.formv1.r39pu.value = '<?php echo "$r39pu";?>';
   document.formv1.r40pu.value = '<?php echo "$r40pu";?>';
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
   document.formv1.r53.value = '<?php echo "$r53";?>';
   document.formv1.r54.value = '<?php echo "$r54";?>';
   document.formv1.r55.value = '<?php echo "$r55";?>';
   document.formv1.r56.value = '<?php echo "$r56";?>';
   document.formv1.r57.value = '<?php echo "$r57";?>';
   document.formv1.r58.value = '<?php echo "$r58";?>';
   document.formv1.r59.value = '<?php echo "$r59";?>';
   document.formv1.r60.value = '<?php echo "$r60";?>';
   document.formv1.r61.value = '<?php echo "$r61";?>';
   document.formv1.r62.value = '<?php echo "$r62";?>';
   document.formv1.r63.value = '<?php echo "$r63";?>';
   document.formv1.r64.value = '<?php echo "$r64";?>';
   document.formv1.r65.value = '<?php echo "$r65";?>';

   document.formv1.t2p1.value = '<?php echo "$t2p1";?>';

   document.formv1.t2v1.value = '<?php echo "$t2v1";?>';

<?php                                        } ?>

<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
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
   document.formv1.r66.value = '<?php echo "$r66";?>';
   document.formv1.r67.value = '<?php echo "$r67";?>';
   document.formv1.r68.value = '<?php echo "$r68";?>';
   document.formv1.t3p1.value = '<?php echo "$t3p1";?>';
   document.formv1.t3p2.value = '<?php echo "$t3p2";?>';
   document.formv1.t3v1.value = '<?php echo "$t3v1";?>';
   document.formv1.t3v2.value = '<?php echo "$t3v2";?>';

<?php                                        } ?>

<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
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
   document.formv1.t3v13.value = '<?php echo "$t3v13";?>';
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
   document.formv1.r96.value = '<?php echo "$r96";?>';
<?php                                        } ?>

<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
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
   document.formv1.r110.value = '<?php echo "$r110";?>';
<?php                                        } ?>

<?php if ( $strana == 10 OR $strana == 9999 ) { ?>

   document.formv1.r111.value = '<?php echo "$r111";?>';
   document.formv1.r112.value = '<?php echo "$r112";?>';
   document.formv1.r113.value = '<?php echo "$r113";?>';
   document.formv1.r114.value = '<?php echo "$r114";?>';
   document.formv1.r115.value = '<?php echo "$r115";?>';
   document.formv1.sdnr.value = '<?php echo "$sdnr";?>';
   document.formv1.r116.value = '<?php echo "$r116";?>';
   document.formv1.r118.value = '<?php echo "$r118";?>';
   document.formv1.r119.value = '<?php echo "$r119";?>';
   document.formv1.r120.value = '<?php echo "$r120";?>';
<?php if ( $ldnr == 1 ) { ?> document.formv1.ldnr.checked = "checked"; <?php } ?>
   document.formv1.nrzsprev.value = '<?php echo "$nrzsprev";?>';
<?php if ( $upl50 == 1 ) { ?> document.formv1.upl50.checked = "checked"; <?php } ?>
<?php if ( $spl3d == 1 ) { ?> document.formv1.spl3d.checked = "checked"; <?php } ?>
   document.formv1.r123.value = '<?php echo "$r123";?>';
   document.formv1.pico.value = '<?php echo "$pico";?>';
   document.formv1.psid.value = '<?php echo "$psid";?>';
   document.formv1.pfor.value = '<?php echo "$pfor";?>';
   document.formv1.pmen.value = '<?php echo "$pmen";?>';
   document.formv1.puli.value = '<?php echo "$puli";?>';
   document.formv1.pcdm.value = '<?php echo "$pcdm";?>';
   document.formv1.ppsc.value = '<?php echo "$ppsc";?>';
   document.formv1.pmes.value = '<?php echo "$pmes";?>';
<?php if ( $zslu == 1 ) { ?> document.formv1.zslu.checked = "checked"; <?php } ?>
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
   document.formv1.pril.value = '<?php echo "$pril";?>';
   document.formv1.dat.value = '<?php echo "$datsk";?>';
<?php if ( $zdbo == 1 ) { ?> document.formv1.zdbo.checked = "checked"; <?php } ?>
<?php if ( $zpre == 1 ) { ?> document.formv1.zpre.checked = "checked"; <?php } ?>
   document.formv1.diban.value = '<?php echo "$diban";?>';
   document.formv1.uceb.value = '<?php echo "$uceb";?>';
   document.formv1.numb.value = '<?php echo "$numb";?>';
   document.formv1.da2.value = '<?php echo "$da2sk";?>';
<?php if ( $post == 1 ) { ?> document.formv1.post.checked = "checked"; <?php } ?>
<?php if ( $ucet == 1 ) { ?> document.formv1.ucet.checked = "checked"; <?php } ?>
<?php                                         } ?>

<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
   document.formv1.prpdzc.value = '<?php echo "$prpdzcsk"; ?>';

   document.formv1.prpzo1.value = '<?php echo "$prpzo1sk"; ?>';
   document.formv1.prpzo2.value = '<?php echo "$prpzo2sk"; ?>';
   document.formv1.prpzo3.value = '<?php echo "$prpzo3sk"; ?>';
   document.formv1.prpzo4.value = '<?php echo "$prpzo4sk"; ?>';
   document.formv1.prpzo5.value = '<?php echo "$prpzo5sk"; ?>';

   document.formv1.prpzd1.value = '<?php echo "$prpzd1sk"; ?>';
   document.formv1.prpzd2.value = '<?php echo "$prpzd2sk"; ?>';
   document.formv1.prpzd3.value = '<?php echo "$prpzd3sk"; ?>';
   document.formv1.prpzd4.value = '<?php echo "$prpzd4sk"; ?>';
   document.formv1.prpzd5.value = '<?php echo "$prpzd5sk"; ?>';

   document.formv1.prpvz1.value = '<?php echo "$prpvz1"; ?>';
   document.formv1.prpvz2.value = '<?php echo "$prpvz2"; ?>';
   document.formv1.prpvz3.value = '<?php echo "$prpvz3"; ?>';
   document.formv1.prpvz4.value = '<?php echo "$prpvz4"; ?>';
   document.formv1.prpvz5.value = '<?php echo "$prpvz5"; ?>';

   document.formv1.prpod1.value = '<?php echo "$prpod1"; ?>';
   document.formv1.prpod2.value = '<?php echo "$prpod2"; ?>';
   document.formv1.prpod3.value = '<?php echo "$prpod3"; ?>';
   document.formv1.prpod4.value = '<?php echo "$prpod4"; ?>';
   document.formv1.prpod5.value = '<?php echo "$prpod5"; ?>';


<?php                                         } ?>

<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
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
<?php if ( $vpdu == 1 ) { ?> document.formv1.vpdu.checked = "checked"; <?php } ?>
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

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function reNacitaj()
  {
   window.open('../ucto/priznanie_fob2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&prepocitaj=1', '_self');
  }
  function TlacFOB()
  {
   window.open('../ucto/priznanie_fob2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', param);
  }
  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_fob2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self');
  }
  function PoucVyplnenie()
  {
   window.open('<?php echo $jpg_cesta; ?>_poucenie.pdf', '_blank', param);
  }
  function vypocetOP()
  {
   window.open('priznanie_fob2016.php?copern=20&strana=<?php echo $strana; ?>&miliondan=1', '_self');
  }
  function namanzelku()
  {
   window.open('priznanie_fob2016.php?copern=20&strana=<?php echo $strana; ?>&namanzelku=1', '_self');
  }
  function NacitajVHpredDanou()
  {
   window.open('../ucto/priznanie_fob2016.php?strana=3&copern=200&drupoh=1&page=1&typ=PDF&dppo=1', '_self');
  }
  function UpravFO()
  {
   window.open('../cis/ufirdalsie.php?copern=402', '_blank');
  }
//bud alebo checkbox v xiv.oddiele
  function klikpost()
  {
   document.formv1.ucet.checked = false;
  }
  function klikucet()
  {
   document.formv1.post.checked = false;
  }
  function FOBdoXML()
  {
   window.open('../ucto/priznaniefob_xml2016.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1', '_blank', param);
  }
  function CisKrajin()
  {
   window.open('../cis/ciselnik_krajin.pdf', '_blank', param);
  }
</script>
</HEAD>
<?php if( $zandroidu == 1 ) { ?>
<BODY class="white">
<br />
<br />
<table width="100%" >
<tr>
<td>
<?php if( $zandroidu == 1 ) { echo "Zostava PDF prebran·, tlaËidlo Sp‰ù - do daÚov˝ch zost·v"; } ?>
</td>
<td align="right"> </td>
</tr>
</table>
<br />
</BODY>
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
   <td class="header">DaÚ z prÌjmov FO typ B</td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/reload_blue_icon.png" onclick="reNacitaj();" title="Znovu naËÌtaù hodnoty do priznania" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="FOBdoXML();" title="Export do XML" class="btn-form-tool"> 
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacFOB();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="priznanie_fob2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive"; $clas6="noactive"; $clas7="noactive";
$clas8="noactive"; $clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive"; $clas13="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active"; if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active"; if ( $strana == 11 ) $clas11="active";
if ( $strana == 12 ) $clas12="active"; if ( $strana == 13 ) $clas13="active"; if ( $strana == 14 ) $clas14="active";

$source="../ucto/priznanie_fob2016.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=13&prepocitaj=101', '_self');" class="<?php echo $clas13; ?> toleft">P1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=14&prepocitaj=101', '_self');" class="<?php echo $clas14; ?> toleft">P2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=14', '_blank');" class="<?php echo $clas14; ?> toright">P2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=13', '_blank');" class="<?php echo $clas13; ?> toright">P1</a>
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
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php
if ( $prepocitaj == 0 ) { $prepocitaj=1; }
?>
 <input type="checkbox" name="prepocitaj" value="1" class="btn-prepocet"/>
<?php if ( $prepocitaj == 1 ) { ?>
 <script type="text/javascript">document.formv1.prepocitaj.checked = "checked";</script>
<?php                         } ?>
 <h5 class="btn-prepocet-title">PrepoËÌtaù hodnoty</h5>
 <div class="alert-pocitam"><?php echo $alertprepocet; ?></div>
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str01.jpg" alt="<?php echo $jpg_popis; ?> 1.strana 222kB" class="form-background">
<span class="text-echo" style="top:258px; left:57px;"><?php echo $fir_fdic; ?></span>
<input type="text" name="dar" id="dar" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:308px; left:51px;"/>

<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:253px; left:440px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:278px; left:440px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:303px; left:440px;"/>
<?php
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
?>
<span class="text-echo" style="top:242px; left:835px;"><?php echo "$t01$t02"; ?></span>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:307px; left:690px;"/>

<?php
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
?>
<span class="text-echo" style="top:371px; left:57px;"><?php echo "$sn1a$sn2a"; ?></span>
<span class="text-echo" style="top:371px; left:114px;"><?php echo "$sn1b$sn2b"; ?></span>
<span class="text-echo" style="top:371px; left:170px;"><?php echo "$sn1c"; ?></span>
<input type="text" name="cinnost" id="cinnost" style="width:621px; height:46px; top:347px; left:267px;"/>

<!-- I.ODDIEL -->
<img src="../obr/ikony/pencil_blue_icon.png" title="Upraviù ˙daje FO"
 onclick="UpravFO();" class="btn-row-tool" style="top:408px; left:370px; width:16px; height:16px;">
<div class="input-echo" style="width:357px; top:457px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:243px; top:457px; left:431px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:113px; top:457px; left:694px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:66px; top:457px; left:828px;"><?php echo $dtitz; ?></div>
<!-- Adresa trvaleho pobytu -->
<div class="input-echo" style="width:634px; top:530px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:176px; top:530px; left:718px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:105px; top:583px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:449px; top:583px; left:179px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:583px; left:649px;"><?php echo $dstat; ?></div>
<!-- nerezident a prepojenie -->
<input type="checkbox" name="nrz" value="1" style="top:620px; left:538px;"/>
<input type="checkbox" name="prp" value="1" style="top:620px; left:848px;"/>
<!-- Adresa pobytu na uzemi SR -->
<input type="text" name="d2uli" id="d2uli" style="width:635px; top:690px; left:51px;"/>
<input type="text" name="d2cdm" id="d2cdm" style="width:175px; top:690px; left:718px;"/>
<input type="text" name="d2psc" id="d2psc" style="width:107px; top:742px; left:51px;"/>
<input type="text" name="d2mes" id="d2mes" style="width:451px; top:742px; left:178px;"/>

<!-- II.ODDIEL -->
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
<input type="text" name="dtel" id="dtel" style="width:289px; top:1022px; left:52px;"/>
<input type="text" name="dmailfax" id="dmailfax" style="width:519px; top:1022px; left:373px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str02.jpg" alt="<?php echo $jpg_popis; ?> 2.strana 244kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- III.ODDIEL -->
<input type="checkbox" name="r29" value="1" style="top:288px; left:746px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:334px; left:701px;"/>
<input type="text" name="mprie" id="mprie" style="width:340px; top:422px; left:51px;"/>
<input type="text" name="mrod" id="mrod" style="width:240px; top:422px; left:413px;"/>
<input type="text" name="mpri" id="mpri" onkeyup="CiarkaNaBodku(this);" style="width:153px; top:422px; left:671px;"/>
<input type="text" name="mpom" id="mpom" style="width:38px; top:422px; left:850px;"/>

<!-- IV.ODDIEL -->
<input type="text" name="d1prie" id="d1prie" style="width:243px; top:663px; left:47px;"/>
<input type="text" name="d1rod" id="d1rod" style="width:240px; top:663px; left:304px;"/>
<input type="checkbox" name="d1pomc" value="1" style="top:674px; left:562px;"/>
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
<input type="checkbox" name="d2pomc" value="1" style="top:718px; left:562px;"/>
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
<input type="checkbox" name="d3pomc" value="1" style="top:763px; left:562px;"/>
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
<input type="checkbox" name="d4pomc" value="1" style="top:807px; left:562px;"/>
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

<!-- V.ODDIEL -->
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1031px; left:501px;"/>
<input type="text" name="r34a" id="r34a" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1071px; left:501px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:1110px; left:568px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1150px; left:501px;"/>
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str03.jpg" alt="<?php echo $jpg_popis; ?> 1.strana 227kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VI.ODDIEL -->
<!-- Tabulka1 -->
<input type="text" name="t1p1" id="t1p1" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:240px; left:410px;"/>
<input type="text" name="t1v1" id="t1v1" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:240px; left:661px;"/>
<input type="text" name="t1p2" id="t1p2" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:279px; left:410px;"/>
<input type="text" name="t1v2" id="t1v2" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:279px; left:661px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajVHpredDanou();"
     title="NaËÌtaù prÌjmy, v˝davky a zaplatenÈ poistnÈ SP a ZP zo ûivnosti do tabuæky Ë.1 (VI.oddiel FOB 3. strana).
            MusÌte maù spracovan˝ V˝kaz o prÌjmoch a v˝davkoch za 12.2014"
     class="btn-row-tool" style="top:280px; left:910px;">
<input type="text" name="t1p3" id="t1p3" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:318px; left:410px;"/>
<input type="text" name="t1v3" id="t1v3" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:318px; left:661px;"/>
<input type="text" name="t1p4" id="t1p4" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:359px; left:410px;"/>
<input type="text" name="t1v4" id="t1v4" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:359px; left:661px;"/>
<input type="text" name="t1p5" id="t1p5" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:403px; left:410px;"/>
<input type="text" name="t1v5" id="t1v5" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:403px; left:661px;"/>
<input type="text" name="t1p6" id="t1p6" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:450px; left:410px;"/>
<input type="text" name="t1v6" id="t1v6" onkeyup="CiarkaNaBodku(this);"
       style="width:232px; top:450px; left:661px;"/>
<input type="text" name="t1p7" id="t1p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:490px; left:410px;"/>
<input type="text" name="t1v7" id="t1v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:490px; left:661px;"/>
<input type="text" name="t1p8" id="t1p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:530px; left:410px;"/>
<input type="text" name="t1v8" id="t1v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:530px; left:661px;"/>
<input type="text" name="t1p9" id="t1p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:570px; left:410px;"/>
<input type="text" name="t1v9" id="t1v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:570px; left:661px;"/>
<input type="text" name="t1p10" id="t1p10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:610px; left:410px;"/>
<input type="text" name="t1v10" id="t1v10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:610px; left:661px;"/>
<input type="text" name="t1p11" id="t1p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:651px; left:410px;"/>
<input type="text" name="t1v11" id="t1v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:651px; left:661px;"/>
<input type="text" name="t1p12" id="t1p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:692px; left:410px;"/>
<input type="text" name="t1v12" id="t1v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:692px; left:661px;"/>

<input type="checkbox" name="uppr1" value="1" style="top:786px; left:65px;"/>
<input type="checkbox" name="uppr3" value="1" style="top:786px; left:360px;"/>
<input type="checkbox" name="uppr4" value="1" style="top:786px; left:633px;"/>

<input type="checkbox" name="uvp61" value="1" style="top:838px; left:65px;"/>
<input type="text" name="uvp61m" id="uvp61m" style="width:37px; top:832px; left:390px;"/>
<input type="checkbox" name="uvp64" value="1" style="top:873px; left:65px;"/>
<input type="text" name="uvp64m" id="uvp64m" style="width:37px; top:870px; left:390px;"/>

<input type="text" name="psp6" id="psp6" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:910px; left:556px;"/>

<input type="checkbox" name="uos61" value="1" style="top:966px; left:65px;"/>
<input type="checkbox" name="uos64" value="1" style="top:966px; left:441px;"/>
<input type="checkbox" name="kos61" value="1" style="top:1017px; left:65px;"/>
<input type="checkbox" name="kos64" value="1" style="top:1017px; left:441px;"/>

<!-- Tabulka1a -->
<input type="text" name="t1az1" id="t1az1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1130px; left:410px;"/>
<input type="text" name="t1ak1" id="t1ak1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1130px; left:660px;"/>
<input type="text" name="t1az2" id="t1az2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1168px; left:410px;"/>
<input type="text" name="t1ak2" id="t1ak2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1168px; left:660px;"/>
<input type="text" name="t1az3" id="t1az3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1209px; left:410px;"/>
<input type="text" name="t1ak3" id="t1ak3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1209px; left:660px;"/>
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str04.jpg" alt="<?php echo $jpg_popis; ?> 1.strana 239kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VI.ODDIEL pokracovanie -->
<!-- Tabulka1a -->
<input type="text" name="t1az4" id="t1az4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:115px; left:410px;"/>
<input type="text" name="t1ak4" id="t1ak4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:115px; left:660px;"/>
<input type="text" name="t1az5" id="t1az5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:155px; left:410px;"/>
<input type="text" name="t1ak5" id="t1ak5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:155px; left:660px;"/>
<!-- Tabulka1b -->
<input type="text" name="t1bz1" id="t1bz1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:262px; left:410px;"/>
<input type="text" name="t1bk1" id="t1bk1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:262px; left:660px;"/>
<input type="text" name="t1bz2" id="t1bz2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:301px; left:410px;"/>
<input type="text" name="t1bk2" id="t1bk2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:301px; left:660px;"/>

<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:719px; left:500px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:758px; left:500px;"/>
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:797px; left:500px;"/>
 <input type="text" name="r39pu" id="r39pu" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:797px; left:762px;"/>
 <img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:799px; left:913px;"
      title="Ak FO vedie podvojnÈ ˙ËtovnÌctvo vyplnÌ ZISK v tejto poloûke, nie v riadku 37,38,39,40 a tabuæku Ë. 1 v VI. oddiele na strane 3. nevypÂÚa.">
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:836px; left:500px;"/>
<input type="text" name="r40pu" id="r40pu" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:836px; left:762px;"/>
 <img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:839px; left:913px;"
      title="Ak FO vedie podvojnÈ ˙ËtovnÌctvo vyplnÌ STRATU v tejto poloûke, nie v riadku 37,38,39,40 a tabuæku Ë. 1 v VI. oddiele na strane 3. nevypÂÚa.">

<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:881px; left:500px;"/>
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:927px; left:500px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:972px; left:500px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1017px; left:500px;"/>

<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1090px; left:507px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1130px; left:507px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1170px; left:507px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1210px; left:507px;"/>
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str05.jpg" alt="<?php echo $jpg_popis; ?> 5.strana 233kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VI.ODDIEL pokracovanie -->
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:115px; left:507px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:155px; left:381px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:196px; left:381px;"/>
<input type="text" name="r52" id="r52" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:235px; left:381px;"/>
<input type="text" name="r53" id="r53" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:277px; left:506px;"/>
<input type="text" name="r54" id="r54" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:317px; left:506px;"/>
<input type="text" name="r55" id="r55" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:392px; left:506px;"/>
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:466px; left:506px;"/>
<input type="text" name="r57" id="r57" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:512px; left:506px;"/>

<input type="text" name="r58" id="r58" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:564px; left:506px;"/>
<input type="text" name="r59" id="r59" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:603px; left:506px;"/>
<input type="text" name="r60" id="r60" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:643px; left:506px;"/>
<input type="text" name="r61" id="r61" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:681px; left:506px;"/>
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:721px; left:506px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:769px; left:506px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:814px; left:506px;"/>
<input type="text" name="r65" id="r65" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:876px; left:506px;"/>

<!-- VII.ODDIEL -->
<!-- Tabulka2 -->
<input type="text" name="t2p1" id="t2p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1215px; left:410px;"/>
<input type="text" name="t2v1" id="t2v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1215px; left:660px;"/>
<?php                     } ?>


<?php if ( $strana == 6 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str06.jpg" alt="<?php echo $jpg_popis; ?> 6.strana 231kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VII.ODDIEL pokracovanie -->
<!-- Tabulka2 -->
<input type="text" name="t2p2" id="t2p2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:136px; left:410px;"/>
<input type="text" name="t2v2" id="t2v2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:136px; left:660px;"/>
<input type="text" name="t2p3" id="t2p3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:208px; left:410px;"/>
<input type="text" name="t2v3" id="t2v3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:208px; left:660px;"/>
<input type="text" name="t2p4" id="t2p4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:259px; left:410px;"/>
<input type="text" name="t2v4" id="t2v4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:259px; left:660px;"/>
<input type="text" name="t2p5" id="t2p5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:308px; left:410px;"/>
<input type="text" name="t2v5" id="t2v5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:308px; left:660px;"/>
<input type="text" name="t2p6" id="t2p6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:359px; left:410px;"/>
<input type="text" name="t2v6" id="t2v6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:359px; left:660px;"/>
<input type="text" name="t2p7" id="t2p7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:398px; left:410px;"/>
<input type="text" name="t2v7" id="t2v7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:398px; left:660px;"/>
<input type="text" name="t2p8" id="t2p8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:437px; left:410px;"/>
<input type="text" name="t2v8" id="t2v8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:437px; left:660px;"/>
<input type="text" name="t2p9" id="t2p9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:487px; left:410px;"/>
<input type="text" name="t2v9" id="t2v9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:487px; left:660px;"/>
<input type="text" name="t2p10" id="t2p10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:536px; left:410px;"/>
<input type="text" name="t2v10" id="t2v10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:536px; left:660px;"/>
<input type="text" name="t2p11" id="t2p11" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:580px; left:410px;"/>
<input type="text" name="t2v11" id="t2v11" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:580px; left:660px;"/>
<input type="text" name="t2p12" id="t2p12" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:631px; left:410px;"/>

<input type="text" name="r66" id="r66" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:906px; left:482px;"/>
<input type="text" name="r67" id="r67" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:945px; left:482px;"/>
<input type="text" name="r68" id="r68" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:984px; left:482px;"/>

<!-- VII.ODDIEL -->
<!-- Tabulka3 -->
<input type="text" name="t3p1" id="t3p1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1168px; left:411px;"/>
<input type="text" name="t3v1" id="t3v1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1168px; left:661px;"/>
<input type="text" name="t3p2" id="t3p2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1218px; left:411px;"/>
<input type="text" name="t3v2" id="t3v2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1218px; left:661px;"/>
<?php                     } ?>


<?php if ( $strana == 7 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str07.jpg" alt="<?php echo $jpg_popis; ?> 7.strana 248kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VII.ODDIEL pokracovanie -->
<!-- Tabulka3 -->
<input type="text" name="t3p3" id="t3p3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:116px; left:411px;"/>
<input type="text" name="t3v3" id="t3v3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:116px; left:661px;"/>
<input type="text" name="t3p4" id="t3p4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:155px; left:411px;"/>
<input type="text" name="t3v4" id="t3v4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:155px; left:661px;"/>
<input type="text" name="t3p5" id="t3p5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:194px; left:411px;"/>
<input type="text" name="t3v5" id="t3v5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:194px; left:661px;"/>
<input type="text" name="t3p6" id="t3p6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:240px; left:411px;"/>
<input type="text" name="t3v6" id="t3v6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:240px; left:661px;"/>
<input type="text" name="t3p7" id="t3p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:290px; left:411px;"/>
<input type="text" name="t3v7" id="t3v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:290px; left:661px;"/>
<input type="text" name="t3p8" id="t3p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:336px; left:411px;"/>
<input type="text" name="t3v8" id="t3v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:336px; left:661px;"/>
<input type="text" name="t3p9" id="t3p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:375px; left:411px;"/>
<input type="text" name="t3v9" id="t3v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:375px; left:661px;"/>
<input type="text" name="t3p10" id="t3p10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:414px; left:411px;"/>
<input type="text" name="t3v10" id="t3v10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:414px; left:661px;"/>
<input type="text" name="t3p11" id="t3p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:466px; left:411px;"/>
<input type="text" name="t3v11" id="t3v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:466px; left:661px;"/>
<input type="text" name="t3p12" id="t3p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:525px; left:411px;"/>
<input type="text" name="t3v12" id="t3v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:525px; left:661px;"/>
<input type="text" name="t3p13" id="t3p13" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:570px; left:411px;"/>
<input type="text" name="t3v13" id="t3v13" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:570px; left:661px;"/>
<input type="text" name="t3p14" id="t3p14" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:613px; left:411px;"/>
<div class="input-echo right" style="width:230px; top:659px; left:413px;"><?php echo $t3p15; ?>&nbsp;</div>
<div class="input-echo right" style="width:230px; top:659px; left:662px;"><?php echo $t3v15; ?>&nbsp;</div>

<input type="text" name="r69" id="r69" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1124px; left:441px;"/>
<input type="text" name="r70" id="r70" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1164px; left:441px;"/>
<input type="text" name="r71" id="r71" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1203px; left:441px;"/>
<?php                     } ?>


<?php if ( $strana == 8 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str08.jpg" alt="<?php echo $jpg_popis; ?> 8.strana 219kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- IX. ODDIEL -->
<input type="text" name="r72" id="r72" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:148px; left:488px;"/>
<input type="text" name="r73" id="r73" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:193px; left:580px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocetOP();"
      title="VypoËÌtaù odpoËÌtateæn˙ poloûku na daÚovnÌka" class="btn-row-tool"
      style="top:195px; left:750px;">
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:232px; left:580px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="namanzelku();"
      title="VypoËÌtaù odpoËÌtateæn˙ poloûku na manûelku" class="btn-row-tool"
      style="top:233px; left:750px;">
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:270px; left:556px;"/>
<input type="text" name="r76" id="r76" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:310px; left:556px;"/>
<input type="text" name="r77" id="r77" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:349px; left:556px;"/>
<input type="text" name="r78" id="r78" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:387px; left:488px;"/>
<input type="text" name="r79" id="r79" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:426px; left:488px;"/>
<input type="text" name="r80" id="r80" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:465px; left:488px;"/>
<input type="text" name="r81" id="r81" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:505px; left:488px;"/>
<input type="text" name="r82" id="r82" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:544px; left:470px;"/>
<input type="text" name="r83" id="r83" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:593px; left:488px;"/>
<input type="text" name="r84" id="r84" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:648px; left:488px;"/>
<input type="text" name="r85" id="r85" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:692px; left:488px;"/>
<input type="text" name="r86" id="r86" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:742px; left:488px;"/>
<input type="text" name="r87" id="r87" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:797px; left:603px;"/>
<input type="text" name="r88" id="r88" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:844px; left:488px;"/>
<input type="text" name="r89" id="r89" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:885px; left:488px;"/>
<input type="text" name="r90" id="r90" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:924px; left:488px;"/>
<input type="text" name="r91" id="r91" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:973px; left:488px;"/>
<input type="text" name="r92" id="r92" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1032px; left:488px;"/>
<input type="text" name="r93" id="r93" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1093px; left:488px;"/>
<input type="text" name="r94" id="r94" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1145px; left:488px;"/>
<input type="text" name="r95" id="r95" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:1184px; left:580px;"/>
<input type="text" name="r96" id="r96" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1223px; left:488px;"/>
<?php                     } ?>


<?php if ( $strana == 9 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str09.jpg" alt="<?php echo $jpg_popis; ?> 9.strana 213kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- IX.ODDIEL pokracovanie -->
<input type="text" name="r97" id="r97" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:116px; left:585px;"/>
<input type="text" name="r98" id="r98" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:157px; left:585px;"/>
<input type="text" name="r99" id="r99" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:196px; left:585px;"/>
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:236px; left:585px;"/>
<input type="text" name="r101" id="r101" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:275px; left:607px;"/>
<input type="text" name="r102" id="r102" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:316px; left:493px;"/>
<input type="text" name="r103" id="r103" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:360px; left:493px;"/>
<input type="text" name="r104" id="r104" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:404px; left:493px;"/>
<input type="text" name="r105" id="r105" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:443px; left:493px;"/>
<input type="text" name="r106" id="r106" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:481px; left:493px;"/>
<input type="text" name="r107" id="r107" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:521px; left:493px;"/>
<input type="text" name="r108" id="r108" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:561px; left:493px;"/>
<input type="text" name="r109" id="r109" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:606px; left:493px;"/>
<input type="text" name="r110" id="r110" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:657px; left:493px;"/>
<?php                     } ?>


<?php if ( $strana == 10 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str10.jpg" alt="<?php echo $jpg_popis; ?> 10.strana 243kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- X.ODDIEL -->
<input type="text" name="r111" id="r111" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:147px; left:648px;"/>
<input type="text" name="r112" id="r112" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:191px; left:628px;"/>
<input type="text" name="r113" id="r113" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:233px; left:628px;"/>
<input type="text" name="r114" id="r114" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:289px; left:628px;"/>
<input type="text" name="r115" id="r115" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:345px; left:740px;"/>
<input type="text" name="r116" id="r116" onkeyup="CiarkaNaBodku(this);" style="width:172px; top:390px; left:720px;"/>

<!-- XI.ODDIEL -->
<input type="text" name="sdnr" id="sdnr" style="width:842px; top:510px; left:51px;"/>
<input type="text" name="r118" id="r118" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:549px; left:648px;"/>
<input type="text" name="r119" id="r119" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:589px; left:648px;"/>
<input type="text" name="r120" id="r120" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:626px; left:648px;"/>
<input type="checkbox" name="ldnr" value="1" style="top:671px; left:413px;"/>
<input type="text" name="nrzsprev" id="nrzsprev" style="width:38px; top:666px; left:855px;"/>

<!-- XII.ODDIEL -->
<input type="checkbox" name="upl50" value="1" style="top:797px; left:59px;"/>
<input type="checkbox" name="spl3d" value="1" style="top:797px; left:295px;"/>
<input type="text" name="r123" id="r123" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:838px; left:316px;"/>
<!-- Prijimatel -->
<input type="text" name="pico" id="pico" style="width:175px; top:923px; left:51px;"/>
<input type="text" name="psid" id="psid" style="width:83px; top:923px; left:258px;"/>
<input type="text" name="pfor" id="pfor" style="width:520px; top:923px; left:373px;"/>
<input type="text" name="pmen" id="pmen" style="width:842px; top:977px; left:51px;"/>
<input type="text" name="puli" id="puli" style="width:635px; top:1087px; left:51px;"/>
<input type="text" name="pcdm" id="pcdm" style="width:175px; top:1087px; left:718px;"/>
<input type="text" name="ppsc" id="ppsc" style="width:106px; top:1140px; left:51px;"/>
<input type="text" name="pmes" id="pmes" style="width:703px; top:1140px; left:190px;"/>
<input type="checkbox" name="zslu" value="1" style="top:1183px; left:59px;"/>
<?php                      } ?>


<?php if ( $strana == 11 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str11.jpg" alt="<?php echo $jpg_popis; ?> 11.strana 197kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- XIII.ODDIEL -->
<input type="checkbox" name="uoso" value="1" style="top:144px; left:58px; z-index:100;"/>
<div style="z-index:10; position:absolute; top:142px; left:57px; background-color:#39f; width:22px; height:22px; border-radius:3px;">&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="ätatistick˝ ËÌselnÌk krajÌn"
     onclick="CisKrajin();" class="btn-row-tool" style="top:218px; left:7px;">
<input type="text" name="pzks1" id="pzks1" style="width:59px; top:218px; left:51px;"/>
<input type="text" name="pdrp1" id="pdrp1" style="width:14px; top:218px; left:146px;"/>
<input type="text" name="pdro1" id="pdro1" style="width:14px; top:218px; left:204px;"/>
<input type="text" name="pzpr1" id="pzpr1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:218px; left:234px;"/>
<input type="text" name="pzvd1" id="pzvd1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:218px; left:483px;"/>
<input type="text" name="pzthvd1" id="pzthvd1" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:218px; left:731px;"/>
<input type="text" name="pzks2" id="pzks2" style="width:59px; top:257px; left:51px;"/>
<input type="text" name="pdrp2" id="pdrp2" style="width:14px; top:257px; left:146px;"/>
<input type="text" name="pdro2" id="pdro2" style="width:14px; top:257px; left:204px;"/>
<input type="text" name="pzpr2" id="pzpr2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:257px; left:234px;"/>
<input type="text" name="pzvd2" id="pzvd2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:257px; left:483px;"/>
<input type="text" name="pzthvd2" id="pzthvd2" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:257px; left:731px;"/>
<input type="text" name="pzks3" id="pzks3" style="width:59px; top:297px; left:51px;"/>
<input type="text" name="pdrp3" id="pdrp3" style="width:14px; top:297px; left:146px;"/>
<input type="text" name="pdro3" id="pdro3" style="width:14px; top:297px; left:204px;"/>
<input type="text" name="pzpr3" id="pzpr3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:297px; left:234px;"/>
<input type="text" name="pzvd3" id="pzvd3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:297px; left:483px;"/>
<input type="text" name="pzthvd3" id="pzthvd3" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:297px; left:731px;"/>
<input type="text" name="pzks4" id="pzks4" style="width:59px; top:337px; left:51px;"/>
<input type="text" name="pdrp4" id="pdrp4" style="width:14px; top:337px; left:146px;"/>
<input type="text" name="pdro4" id="pdro4" style="width:14px; top:337px; left:204px;"/>
<input type="text" name="pzpr4" id="pzpr4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:337px; left:234px;"/>
<input type="text" name="pzvd4" id="pzvd4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:337px; left:483px;"/>
<input type="text" name="pzthvd4" id="pzthvd4" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:337px; left:731px;"/>
<input type="text" name="pzks5" id="pzks5" style="width:59px; top:377px; left:51px;"/>
<input type="text" name="pdrp5" id="pdrp5" style="width:14px; top:377px; left:146px;"/>
<input type="text" name="pdro5" id="pdro5" style="width:14px; top:377px; left:204px;"/>
<input type="text" name="pzpr5" id="pzpr5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:377px; left:234px;"/>
<input type="text" name="pzvd5" id="pzvd5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:377px; left:483px;"/>
<input type="text" name="pzthvd5" id="pzthvd5" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:377px; left:731px;"/>
<input type="text" name="pzks6" id="pzks6" style="width:59px; top:417px; left:51px;"/>
<input type="text" name="pdrp6" id="pdrp6" style="width:14px; top:417px; left:146px;"/>
<input type="text" name="pdro6" id="pdro6" style="width:14px; top:417px; left:204px;"/>
<input type="text" name="pzpr6" id="pzpr6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:417px; left:234px;"/>
<input type="text" name="pzvd6" id="pzvd6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:417px; left:483px;"/>
<input type="text" name="pzthvd6" id="pzthvd6" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:417px; left:731px;"/>
<textarea name="osob" id="osob" style="width:838px; height:234px; top:564px; left:53px;"><?php echo $osob; ?></textarea>

<input type="text" name="pril" id="pril" style="width:37px; top:832px; left:184px;" title="Minim·lny poËet prÌloh je 2, vr·tane PrÌlohy Ë.1 V˝zkum a v˝voj a PrÌlohy Ë.2 ⁄daje SP a ZP"/>
<input type="text" name="dat" id="dat" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:905px; left:277px;"/>

<!-- XIV.ODDIEL -->
<input type="checkbox" name="zdbo" value="1" style="top:987px; left:59px;"/>
<input type="checkbox" name="zpre" value="1" style="top:1016px; left:59px;"/>
<input type="checkbox" name="post" value="1" onchange="klikpost();" style="top:1060px; left:116px;"/>
<input type="checkbox" name="ucet" value="1" onchange="klikucet();" style="top:1060px; left:323px;"/>
<input type="text" name="diban" id="diban" style="width:773px; top:1094px; left:116px;"/>
<input type="text" name="uceb" id="uceb" style="width:381px; top:1146px; left:59px;"/>
<input type="text" name="numb" id="numb" style="width:81px; top:1146px; left:483px;"/>
<input type="text" name="da2" id="da2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1206px; left:116px;"/>
<?php                      } ?>


<?php if ( $strana == 12 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str12.jpg" alt="<?php echo $jpg_popis; ?> 12.strana 168kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>


<?php                      } ?>

<?php if ( $strana == 13 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str13.jpg" alt="<?php echo $jpg_popis; ?> 13.strana 155kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- PRILOHA 1 -->
<div class="input-echo right" style="top:167px; left:269px; width:36px;"><?php echo $prpcp; ?>&nbsp;</div>
<div class="input-echo right" style="top:167px; left:338px; width:36px;"><?php echo $prppp; ?>&nbsp;</div>
<input type="text" name="prpdzc" id="prpdzc" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:166px; left:697px;"/>

<input type="text" name="prpzo1" id="prpzo1" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:254px; left:72px;"/>
<input type="text" name="prpzd1" id="prpzd1" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:293px; left:72px;"/>
<input type="text" name="prpvz1" id="prpvz1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:293px;"/>
<input type="text" name="prpod1" id="prpod1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:604px;"/>

<input type="text" name="prpzo2" id="prpzo2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:333px; left:72px;"/>
<input type="text" name="prpzd2" id="prpzd2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:370px; left:72px;"/>
<input type="text" name="prpvz2" id="prpvz2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:293px;"/>
<input type="text" name="prpod2" id="prpod2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:604px;"/>

<input type="text" name="prpzo3" id="prpzo3" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:410px; left:72px;"/>
<input type="text" name="prpzd3" id="prpzd3" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:448px; left:72px;"/>
<input type="text" name="prpvz3" id="prpvz3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:293px;"/>
<input type="text" name="prpod3" id="prpod3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:604px;"/>

<input type="text" name="prpzo4" id="prpzo4" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:488px; left:72px;"/>
<input type="text" name="prpzd4" id="prpzd4" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:526px; left:72px;"/>
<input type="text" name="prpvz4" id="prpvz4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:293px;"/>
<input type="text" name="prpod4" id="prpod4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:604px;"/>

<input type="text" name="prpzo5" id="prpzo5" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:566px; left:72px;"/>
<input type="text" name="prpzd5" id="prpzd5" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:604px; left:72px;"/>
<input type="text" name="prpvz5" id="prpvz5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:293px;"/>
<input type="text" name="prpod5" id="prpod5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:604px;"/>

<div class="input-echo right" style="width:290px; top:644px; left:604px;"><?php echo $prpods; ?>&nbsp;</div>
<textarea name="prptxt" id="prptxt" style="width:838px; height:400px; top:700px; left:53px;"><?php echo $prptxt; ?></textarea>
<div class="input-echo right" style="width:290px; top:1150px; left:604px;"><?php echo $prpodv; ?>&nbsp;</div>
<?php                      } ?>


<?php if ( $strana == 14 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str14.jpg" alt="<?php echo $jpg_popis; ?> 14.strana 240kB" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- PRILOHA 2 -->
<input type="text" name="sz1p1" id="sz1p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:211px; left:410px;"/>
<input type="text" name="sz1v1" id="sz1v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:211px; left:660px;"/>
<input type="text" name="sz2" id="sz2" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:275px; left:517px;"/>
<input type="text" name="sz3" id="sz3" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:324px; left:517px;"/>
<input type="text" name="sz4" id="sz4" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:368px; left:517px;"/>
<input type="text" name="sz5" id="sz5" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:414px; left:517px;"/>
<input type="text" name="sz6" id="sz6" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:468px; left:517px;"/>
<input type="text" name="sz7" id="sz7" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:530px; left:517px;"/>
<input type="text" name="sz8" id="sz8" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:687px; left:517px;"/>
<input type="text" name="sz9" id="sz9" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:762px; left:532px;"/>
<input type="text" name="sz10" id="sz10" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:802px; left:532px;"/>
<input type="text" name="sz11" id="sz11" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:841px; left:532px;"/>
<input type="text" name="sz12" id="sz12" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:881px; left:532px;"/>
<input type="text" name="sz13" id="sz13" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:921px; left:532px;"/>
<input type="text" name="sz14" id="sz14" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:961px; left:532px;"/>
<input type="text" name="sz15" id="sz15" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:1005px; left:532px;"/>
<input type="checkbox" name="vpdu" value="1" style="top:1102px; left:60px;"/>
<input type="text" name="sz16" id="sz16" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1131px; left:516px;"/>
<input type="text" name="szdat" id="szdat" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:1200px; left:116px;"/>
<?php                      } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1&prepocitaj=101', '_self');"
    class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2&prepocitaj=101', '_self');"
    class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3&prepocitaj=101', '_self');"
    class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4&prepocitaj=101', '_self');"
    class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5&prepocitaj=101', '_self');"
    class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=6&prepocitaj=101', '_self');"
    class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=7&prepocitaj=101', '_self');"
    class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=8&prepocitaj=101', '_self');"
    class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=9&prepocitaj=101', '_self');"
    class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=10&prepocitaj=101', '_self');"
    class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=11&prepocitaj=101', '_self');"
    class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=12&prepocitaj=101', '_self');"
    class="<?php echo $clas12; ?> toleft">P1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=13&prepocitaj=101', '_self');"
    class="<?php echo $clas13; ?> toleft">P2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav udaje


//pdf priznanie
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
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,43," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//datum narodenia
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodat=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodat="x"; }
$pdf->SetY(53);
$pdf->Cell(89,3," ","$rmc1",0,"C");$pdf->Cell(5,3,"$riadne","$rmc",1,"C");
$pdf->SetY(58);
$pdf->Cell(89,3," ","$rmc1",0,"C");$pdf->Cell(5,4,"$opravne","$rmc",1,"C");
$pdf->SetY(64);
$pdf->Cell(89,3," ","$rmc1",0,"C");$pdf->Cell(5,4,"$dodat","$rmc",0,"C");

//za rok
$pdf->SetY(49);
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
$pdf->Cell(175,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t02","$rmc",1,"C");

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
$pdf->Cell(145,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//sknace
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1c","$rmc",1,"C");//$pdf->Cell(4,6,"$sn2c","$rmc",0,"C");

//cinnost
$pdf->SetY(74);
$pdf->Cell(51,6," ","$rmc1",0,"C");$pdf->Cell(139,11,"$hlavicka->cinnost","$rmc",1,"L");

//priezvisko FO
$pdf->Cell(190,14," ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOP";
$text=$dprie;
$t01=substr($text,0,1);
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//meno FO
$pdf->Cell(3,7," ","$rmc1",0,"L");
$text="ABCDEFGHIJK";
$text=$dmeno;
$t01=substr($text,0,1);
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
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//titul pred a za FO
$pdf->Cell(4,7," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$dtitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$dtitz","$rmc",1,"C");

//Adresa trvaleho pobytu
//ulica
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$duli;
$t01=substr($text,0,1);
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
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t28","$rmc",0,"C");

//cislo
$text="ABCDEFGH";
$text=$dcdm;
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
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="12345";
$text=$dpsc;
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
$text="ABCDEFGHIJKLMNOPRSTU";
$text=$dmes;
$t01=substr($text,0,1);
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");

//stat
$text=$dstat;
$t01=substr($text,0,1);
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",1,"C");

//nerezident
$pdf->Cell(190,3," ","$rmc1",1,"L");
$nrzx=" ";
if ( $hlavicka->nrz == 1 ) { $nrzx="x"; }
$pdf->Cell(111,6," ","$rmc1",0,"C");$pdf->Cell(4,3,"$nrzx","$rmc",0,"C");

//prepojenie
$prpx=" ";
if ( $hlavicka->prp == 1 ) { $prpx="x"; }
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$prpx","$rmc",1,"C");

//Adresa pobytu na uzemi SR
//ulica2
$pdf->Cell(190,12," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t08","$rmc",1,"C");

//psc2
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->d2psc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",1,"C");

//Zastupca
//priezvisko
$pdf->Cell(195,18," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//meno
$pdf->Cell(3,7," ","$rmc1",0,"L");
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
$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//titul pred a za zastupcu
$pdf->Cell(4,7," ","$rmc1",0,"L");
$pdf->Cell(26,6,"$hlavicka->ztitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->ztitz","$rmc",1,"C");

//rodne cislo
$pdf->Cell(195,6," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(195,6," ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->zpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"L");

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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");

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
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//telefon FO
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");

//email FO
$text="12345678910";
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,6,"$hlavicka->dmailfax","$rmc",1,"L");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka29
$pdf->Cell(195,43," ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->r29 == 0 ) $text=" ";
$pdf->Cell(157,5," ","$rmc1",0,"L");$pdf->Cell(4,5,"$text","$rmc",1,"C");

//polozka30
$pdf->Cell(195,6," ","$rmc1",1,"L");
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
$pdf->Cell(147,7," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",1,"C");

//Manzelka
//priezvisko a meno
$pdf->Cell(195,14," ","$rmc1",1,"L");
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
$pdf->Cell(4,7," ","$rmc1",0,"L");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//pocet mesiacov
$text="01";
$hodx=$hlavicka->mpom;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

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
$pdf->Cell(195,5," ","$rmc1",1,"L");
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

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
$pdf->Cell(195,5," ","$rmc1",1,"L");
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch3
$pdf->SetY(169);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d3pom1 == 1 ) $t01="x"; if ( $hlavicka->d3pom2 == 1 ) $t02="x"; if ( $hlavicka->d3pom3 == 1 ) $t03="x";
if ( $hlavicka->d3pom4 == 1 ) $t04="x"; if ( $hlavicka->d3pom5 == 1 ) $t05="x"; if ( $hlavicka->d3pom6 == 1 ) $t06="x";
if ( $hlavicka->d3pom7 == 1 ) $t07="x"; if ( $hlavicka->d3pom8 == 1 ) $t08="x"; if ( $hlavicka->d3pom9 == 1 ) $t09="x";
if ( $hlavicka->d3pom10 == 1 ) $t10="x"; if ( $hlavicka->d3pom11 == 1 ) $t11="x"; if ( $hlavicka->d3pom12 == 1 ) $t12="x";
if ( $hlavicka->d3pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t12","$rmc",1,"R");

//priezvisko a meno4
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->Cell(1,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");

//v mesiacoch4
$pdf->SetY(180);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d4pom1 == 1 ) $t01="x"; if ( $hlavicka->d4pom2 == 1 ) $t02="x"; if ( $hlavicka->d4pom3 == 1 ) $t03="x";
if ( $hlavicka->d4pom4 == 1 ) $t04="x"; if ( $hlavicka->d4pom5 == 1 ) $t05="x"; if ( $hlavicka->d4pom6 == 1 ) $t06="x";
if ( $hlavicka->d4pom7 == 1 ) $t07="x"; if ( $hlavicka->d4pom8 == 1 ) $t08="x"; if ( $hlavicka->d4pom9 == 1 ) $t09="x";
if ( $hlavicka->d4pom10 == 1 ) $t10="x"; if ( $hlavicka->d4pom11 == 1 ) $t11="x"; if ( $hlavicka->d4pom12 == 1 ) $t12="x";
if ( $hlavicka->d4pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,2,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,2,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,2,"$t12","$rmc",1,"R");

//polozka33
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->r33 == 1 ) $text="x";
$pdf->Cell(12,3," ","$rmc1",0,"R");$pdf->Cell(3,5,"$text","$rmc",1,"R");

//polozka34
$pdf->Cell(190,41," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka34a
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka35
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",1,"C");

//polozka36
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//VI. ODDIEL
//tab.1
//1.riadok
$pdf->Cell(190,33," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//6.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//uplatnujem preukazatelne vydavky
$pdf->Cell(190,16," ","$rmc1",1,"L");
$kriz1=" "; if ( $hlavicka->uppr1 == 1 ) $kriz1="x";
$kriz2=" "; if ( $hlavicka->uppr3 == 1 ) $kriz2="x";
$kriz3=" "; if ( $hlavicka->uppr4 == 1 ) $kriz3="x";
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz1","$rmc",0,"C");
$pdf->Cell(62,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz2","$rmc",0,"L");
$pdf->Cell(56,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz3","$rmc",1,"L");

//uplatnujem vydavky percentom
//riadok 1
$pdf->Cell(190,9," ","$rmc1",1,"L");
$kriz4=" "; if ( $hlavicka->uvp61 == 1 ) $kriz4="x";
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz4","$rmc",0,"C");
//pocet mesiacov
$text="0123456";
$hodx=$hlavicka->uvp61m;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->SetY(185);
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"L");
//riadok 2
$pdf->Cell(190,4," ","$rmc1",1,"L");
$kriz5=" "; if ( $hlavicka->uvp64 == 1 ) $kriz5="x";
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz5","$rmc",0,"C");
//pocet mesiacov
$text="0123456";
$hodx=$hlavicka->uvp64m;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->SetY(194);
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"L");

//zaplatene poistne
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//kriziky kurzove rozdiely
$pdf->Cell(190,7," ","$rmc1",1,"L");
$kriz6=" "; if ( $hlavicka->uos61 == 1 ) $kriz6="x";
$kriz7=" "; if ( $hlavicka->uos64 == 1 ) $kriz7="x";
$pdf->Cell(7,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$kriz6","$rmc",0,"C");
$pdf->Cell(80,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz7","$rmc",1,"L");
$pdf->Cell(190,8," ","$rmc1",1,"L");
$kriz8=" "; if ( $hlavicka->kos61 == 1 ) $kriz8="x";
$kriz9=" "; if ( $hlavicka->kos64 == 1 ) $kriz9="x";
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(3,3,"$kriz8","$rmc",0,"C");
$pdf->Cell(80,4," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kriz9","$rmc",1,"L");

//tab.1a
//1.riadok
$pdf->Cell(190,23," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");
                                       } //koniec 3.strany

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str4.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"R");

//VI.ODDIEL pokracovanie
//tab.1a pokracovanie
//4.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");


//tab.1b
//1.riadok
$pdf->Cell(190,18," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//2.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");


//polozka37
$pdf->Cell(190,89," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka38
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka39
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka40
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka41
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka42
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka43
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka44
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(102,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka45
$pdf->Cell(190,11," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka46
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka47
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka48
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 4.strany

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str5.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str5.jpg',0,0,210,297);
}
$pdf->SetY(9);

//dic / rodne cislo
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//polozka49
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka50
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r50;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//polozka51
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r51;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//polozka52
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r52;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 4s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(76,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//polozka53
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka54
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka55
$pdf->Cell(190,11," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r55;
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka56
$pdf->Cell(190,12," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka57
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka58
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka59
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka60
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka61
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka62
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka63
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka64
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka65
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(104,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//VII. ODDIEL
//tab.2
//1.riadok
$pdf->Cell(190,70," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");
                                       } //koniec 5.strany

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str6.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//VII. ODDIEL
//tab.2 pokracovanie
//2.riadok
$pdf->Cell(190,9," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//3.riadok
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//4.riadok
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//5.riadok
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//6.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//7.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//8.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//9.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//10.riadok
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//11.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//12.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka66
$pdf->Cell(190,57," ","$rmc1",1,"L");
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka67
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka68
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//VIII. ODDIEL
//tab.3
//1.riadok
$pdf->Cell(190,36," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//2.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");
                                       } //koniec 6.strany

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str7.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t10","$rmc",1,"C");

//VIII. ODDIEL
//tab.3 pokracovanie
//3.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//4.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//5.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");

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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//6.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//7.riadok
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//8.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//9.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//10.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//11.riadok
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//12.riadok
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//13.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
$text="0123456789";
$hodx=100*$hlavicka->t3v13;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//14.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//15riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p15;
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
$text="0123456789";
$hodx=100*$hlavicka->t3v15;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//polozka69
$pdf->Cell(190,100," ","$rmc1",1,"L");
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka70
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka71
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(90,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 7.strany

if ( $strana == 8 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str8.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//IX. ODDIEL
//polozka72
$pdf->Cell(190,12," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka73
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r73;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(120,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//polozka74
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r74;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(120,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//polozka75
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r75;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(115,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//polozka76
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r76;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(115,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//polozka77
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r77;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(115,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//polozka78
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka79
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r79;
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka80
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r80;
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka81
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka82
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r82;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka83
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka84
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka85
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r85;
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka86
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r86;
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka87
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r87;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(126,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"R");

//polozka88
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka89
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r89;
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka90
$pdf->Cell(190,2," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka91
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka92
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka93
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka94
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka95
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r95;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(120,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"L");

//polozka96
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 8.strany

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str9.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str9.jpg',0,0,210,297);
}
$pdf->SetY(9);

//dic / rodne cislo
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"L");

//polozka97
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka98
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka99
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r99;
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka100
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r100;
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka101
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r101;
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka102
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka103
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka104
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka105
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka106
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka107
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka108
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka109
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r109;
if ( $hodx == 0 ) $hodx="";
if ( $hodx == 0 AND $hlavicka->r110 == 0 ) $hodx="000";
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka110
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r110;
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
$pdf->Cell(101,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 9.strany

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str10.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//X.ODDIEL
//polozka111
$pdf->Cell(190,12," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r111;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka112
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="012345";
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka113
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka114
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r114;
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka115
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(155,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//polozka116
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r116;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//XI. ODDIEL
//117stat rezidencie
$pdf->Cell(190,22," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");

//polozka118
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r118;
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka119
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r119;
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka20
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r120;
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
$pdf->Cell(135,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka121
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->nrz == 0 OR $hlavicka->ldnr == 0 ) $text="";
$pdf->Cell(84,4," ","$rmc1",0,"R");$pdf->Cell(3,4,"$text","$rmc",0,"C");

//polozka122
$text="+0123456789";
$hodx=$hlavicka->nrzsprev;
$text=sprintf("% 2s",$hodx);
if ( $hlavicka->nrz == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(94,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//XII. ODDIEL
//krizik neuplatnujem a splnam 3%
$pdf->Cell(190,23," ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->upl50 == 0 ) $text=" ";
$text3="x";
if ( $hlavicka->spl3d == 0 ) $text3=" ";
$pdf->Cell(6,4," ","$rmc1",0,"R");$pdf->Cell(3,3,"$text","$rmc",0,"C");$pdf->Cell(49,4," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text3","$rmc",1,"C");

//polozka123
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="01234567";
$hodx=100*$hlavicka->r123;
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
$pdf->Cell(62,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"L");

//122Prijimatel
//ico/sid
$pdf->Cell(190,13," ","$rmc1",1,"L");
$text="0123456789ab";
$text=$hlavicka->pico;
if ( $hlavicka->pico < 1000000 AND $hlavicka->pico > 1 ) { $text="00".$hlavicka->pico; }
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
$pdf->Cell(3,7," ","$rmc1",0,"R");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");

//pravna forma
$text="0123456789akciovsyù˙mng";
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
$pdf->Cell(6,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t23","$rmc",1,"C");

//obchodne meno
$pdf->Cell(195,5," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");

//ulica
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->ppsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t29","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t30","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t31","$rmc",1,"C");

//suhlasim udaje
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zslu == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text","$rmc",1,"C");
                                        } //koniec 10.strany

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str11.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str11.jpg',0,0,210,297);
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//XIII. ODDIEL
//uvadzam
$pdf->Cell(190,11," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->uoso == 1 ) $text="x";
$pdf->Cell(5,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//prijmy a vydavky nerezidenta
//kod statu1
$pdf->Cell(190,14," ","$rmc1",1,"L");
$text=$hlavicka->pzks1;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->pzks2;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu3
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->pzks3;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu4
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->pzks4;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->pzks5;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu6
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->pzks6;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//osobitne zaznamy
$pdf->Cell(190,27," ","$rmc1",1,"L");
//if ( $hlavicka->uoso != 1 ) $hlavicka->osob=" ";
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
$pdf->Cell(33,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"R");

//datum vyhlasenia
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text="012345";
$text=SKDatum($hlavicka->dat);
if ( $text == '00.00.0000' ) { $text=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));} 
$pole = explode(".", $text);
$rokx="".substr($pole[2],2,2);
$text=$pole[0].$pole[1].$rokx;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(53,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(13,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",1,"C");

//XIV. ODDIEL
//ziadam o
$pdf->Cell(190,12," ","$rmc1",1,"L");
$text1=" ";
if ( $hlavicka->zdbo == 1 ) $text1="x";
$text3=" ";
if ( $hlavicka->zpre == 1 ) $text3="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text1","$rmc",1,"R");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text3","$rmc",1,"R");

//postovou poukazkou ci na ucet
$pdf->Cell(190,5," ","$rmc1",1,"L");
$textp=" ";
if ( $hlavicka->post == 1 ) $textp="x";
$textb=" ";
if ( $hlavicka->ucet == 1 ) $textb="x";
$pdf->Cell(18,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textp","$rmc",0,"L");$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textb","$rmc",1,"L");

//iban
$pdf->Cell(190,4," ","$rmc1",1,"L");
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

//cislo uctu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="SK0123456789+-ab";
$text=$hlavicka->uceb;
if ( $hlavicka->ucet == 0 ) $text="";
$pole = explode("-", $text);
$textp=$pole[0];
$textu=$pole[1];
if( $textu == '' ) { $textu=$textp; $textp=""; }
$t01=substr($textp,0,1);
$t02=substr($textp,1,1);
$t03=substr($textp,2,1);
$t04=substr($textp,3,1);
$t05=substr($textp,4,1);
$t06=substr($textp,5,1);
$t07=substr($textp,6,1);
$t08=substr($textu,0,1);
$t09=substr($textu,1,1);
$t10=substr($textu,2,1);
$t11=substr($textu,3,1);
$t12=substr($textu,4,1);
$t13=substr($textu,5,1);
$t14=substr($textu,6,1);
$t15=substr($textu,7,1);
$t16=substr($textu,8,1);
$t17=substr($textu,9,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t11","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t17","$rmc",0,"R");

//kod banky
$text="0123";
$text=$hlavicka->numb;
if ( $hlavicka->ucet == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"L");

//datum
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");
                                        } //koniec 11.strany

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str12.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str12.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//PRILOHA 1
//projekt cislo
$pdf->Cell(195,16," ","$rmc1",1,"L");
$tlachod=$hlavicka->prpcp;
$tlachod_c=sprintf("% 2s",$tlachod);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$pdf->Cell(51,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");

//pocet projektov
$tlachod=$hlavicka->prppp;
$tlachodxx="222";
$tlachod_c=sprintf("% 2s",$tlachod);
$A=substr($tlachod_c,0,1);
$B=substr($tlachod_c,1,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");

//zaciatok projektu
$text=SKDatum($hlavicka->prpdzc);
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
$pdf->Cell(71,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//riadok1
$pdf->Cell(195,14," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzo1);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpvz1;
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpod1;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzd1);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok2
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzo2);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpvz2;
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpod2;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzd2);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok3
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzo3);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpvz3;
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpod3;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzd3);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok4
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzo4);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpvz4;
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpod4;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzd4);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//riadok5
$pdf->Cell(195,2," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzo5);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpvz5;
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
//
$text="0123456789";
$hodx=100*$hlavicka->prpod5;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
//
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text=SKDatum($hlavicka->prpzd5);
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
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//spolu
$pdf->Cell(195,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->prpods;
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
$pdf->Cell(126,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");

//ciele projektu
$pdf->Cell(190,7," ","$rmc1",1,"L");
$poleprptxt = explode("\r\n", $hlavicka->prptxt);
if ( $poleprptxt[0] != '' )
     {
$ipole=1;
foreach( $poleprptxt as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,8,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }

//spolu vsetky projekty
$pdf->SetY(258);
$text="0123456789";
$hodx=100*$hlavicka->prpodv;
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
$pdf->Cell(126,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",1,"C");
                                        } //koniec 12.strany

if ( $strana == 13 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str13.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_str13.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
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
$pdf->Cell(80,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//PRILOHA 2
//1.riadok
$pdf->Cell(190,26," ","$rmc1",1,"L");
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
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

//2.riadok
$pdf->Cell(190,9," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//3.riadok
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//4.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//5.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//6.riadok
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//7.riadok
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//8.riadok
$pdf->Cell(190,30," ","$rmc1",1,"L");
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//9.riadok
$pdf->Cell(190,11," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz9;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//10.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//11.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//12.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//13.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//14.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//15.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(110,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//vediem podvojne
$pdf->Cell(190,17," ","$rmc1",1,"L");
$text1=" "; if ( $hlavicka->vpdu == 1 ) $text1="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(5,3,"$text1","$rmc",1,"R");

//16.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->sz16;
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
$pdf->Cell(106,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//datum
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");





                                        } //koniec 13.strany
  }
$i = $i + 1;
  }
$pdf->Output("../tmp/priznaniefob.$kli_uzid.pdf");

//pdf potvrdenie
if ( $copern == 10 ) {
if ( File_Exists("../tmp/potvrdfob$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdfob$kli_vume.$kli_uzid.pdf"); }
     $sirka_vyska="210,320";
     $velkost_strany = explode(",", $sirka_vyska);
     $pdf=new FPDF("P","mm", $velkost_strany );

$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',12);

if ( File_Exists('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dpfob2015/dpfob_v15_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za rok
$pdf->Cell(190,25," ","$rmc1",1,"L");
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(35,6,"$kli_vrok","$rmc",1,"C");

//priezvisko
$pdf->Cell(190,30," ","$rmc1",1,"L");
$text=$dprie;
$pdf->Cell(14,7," ","$rmc1",0,"L");$pdf->Cell(141,6,"$text","$rmc",1,"L");

//meno
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=$dmeno;
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
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(141,7,"$duli $dcdm","$rmc",1,"L");

//psc a nazov
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(26,6,"$dpsc","$rmc",0,"L");$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(95,6,"$dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"L");$pdf->Cell(46,8,"$dstat","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,13," ","$rmc1",1,"L");
$r80=$hlavicka->r80; if ( $r80 == 0 ) $r80="";
$r94=$hlavicka->r94; if ( $r94 == 0 ) $r94="";
$r109=$hlavicka->r109; if ( $r109 == 0 ) { $r109=""; }
$r110=$hlavicka->r110; if ( $r110 == 0 ) { $r110=""; }
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r80","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,5,"$r94","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,5,"$r109","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r110","$rmc",1,"R");

$pdf->Output("../tmp/potvrdfob$kli_vxcf.$kli_uzid.pdf");
                     } //koniec pdf potvrdenie
//exit;
?>

<?php if( $xml == 0 ) { ?>
<script type="text/javascript"> var okno = window.open("../tmp/priznaniefob.<?php echo $kli_uzid; ?>.pdf","_self"); </script>
<?php                 } ?>

<?php
}
//koniec pdf priznanie


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