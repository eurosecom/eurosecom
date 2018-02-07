<!doctype html>
<html>
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

//.jpg podklad
$jpg_source="../dokumenty/dan_z_prijmov2017/dpfob/dpfob_v17";
$jpg_title="tlaËivo DaÚ z prÌjmov FO typ B pre rok $kli_vrok $strana.strana";

$zablokovane=0;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie bude pripravenÈ v priebehu janu·ra 2018. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
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
         { location.href='priznanie_fob2017.php?copern=3156&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
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
//koniec copern=209 nastav sz9 = r35

//nacitaj prijmy a vydaje
$nacitajsz9=0;
if ( $copern == 209 )
{
$nacitajsz9=1;
$copern=20;

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" sz8=r35 ".
" WHERE oc >= 0 ";
$upravene = mysql_query("$uprtxt");

$strana=16;
}
//koniec copern=209 nastav sz9 = r35

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
$cinnost = trim(strip_tags($_REQUEST['cinnost']));
//$dprie = strip_tags($_REQUEST['dprie']);
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
$d2uli = trim(strip_tags($_REQUEST['d2uli']));
$d2cdm = trim(strip_tags($_REQUEST['d2cdm']));
$d2psc = trim(strip_tags($_REQUEST['d2psc']));
$d2mes = trim(strip_tags($_REQUEST['d2mes']));
//$d2tel = strip_tags($_REQUEST['d2tel']);
//$d2fax = strip_tags($_REQUEST['d2fax']);
//$oznucet = 1*$_REQUEST['oznucet'];
$zprie = trim(strip_tags($_REQUEST['zprie']));
$zmeno = trim(strip_tags($_REQUEST['zmeno']));
$ztitl = trim(strip_tags($_REQUEST['ztitl']));
$ztitz = trim(strip_tags($_REQUEST['ztitz']));
$zrdc = trim(strip_tags($_REQUEST['zrdc']));
$zrdk = trim(strip_tags($_REQUEST['zrdk']));
$zuli = trim(strip_tags($_REQUEST['zuli']));
$zcdm = trim(strip_tags($_REQUEST['zcdm']));
$zpsc = trim(strip_tags($_REQUEST['zpsc']));
$zmes = trim(strip_tags($_REQUEST['zmes']));
//$ztel = strip_tags($_REQUEST['ztel']);
$zstat = trim(strip_tags($_REQUEST['zstat']));
$dtel = str_replace(" ","",strip_tags($_REQUEST['dtel']));
$dmailfax = trim(strip_tags($_REQUEST['dmailfax']));
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
$mprie = trim(strip_tags($_REQUEST['mprie']));
$mrod = trim(strip_tags($_REQUEST['mrod']));
$mpri = 1*$_REQUEST['mpri'];
$mpom = 1*$_REQUEST['mpom'];
if ( $mpom > 12 ) { $mpom = 12; }
$d1prie = trim(strip_tags($_REQUEST['d1prie']));
$d1rod = trim(strip_tags($_REQUEST['d1rod']));
$d1pomc = 1*$_REQUEST['d1pomc'];
$d1pom1 = 1*$_REQUEST['d1pom1'];
$d1pom2 = 1*$_REQUEST['d1pom2'];
$d1pom3 = 1*$_REQUEST['d1pom3'];
$d1pom4 = 1*$_REQUEST['d1pom4'];
$d1pom5 = 1*$_REQUEST['d1pom5'];
$d1pom6 = 1*$_REQUEST['d1pom6'];
$d1pom7 = 1*$_REQUEST['d1pom7'];
$d1pom8 = 1*$_REQUEST['d1pom8'];
$d1pom9 = 1*$_REQUEST['d1pom9'];
$d1pom10 = 1*$_REQUEST['d1pom10'];
$d1pom11 = 1*$_REQUEST['d1pom11'];
$d1pom12 = 1*$_REQUEST['d1pom12'];
if ( $d1pomc == 1 ) { $d1pom1=0; $d1pom2=0; $d1pom3=0; $d1pom4=0; $d1pom5=0; $d1pom6=0; $d1pom7=0; $d1pom8=0; $d1pom9=0; $d1pom10=0; $d1pom11=0; $d1pom12=0; }
$d2prie = trim(strip_tags($_REQUEST['d2prie']));
$d2rod = trim(strip_tags($_REQUEST['d2rod']));
$d2pomc = 1*$_REQUEST['d2pomc'];
$d2pom1 = 1*$_REQUEST['d2pom1'];
$d2pom2 = 1*$_REQUEST['d2pom2'];
$d2pom3 = 1*$_REQUEST['d2pom3'];
$d2pom4 = 1*$_REQUEST['d2pom4'];
$d2pom5 = 1*$_REQUEST['d2pom5'];
$d2pom6 = 1*$_REQUEST['d2pom6'];
$d2pom7 = 1*$_REQUEST['d2pom7'];
$d2pom8 = 1*$_REQUEST['d2pom8'];
$d2pom9 = 1*$_REQUEST['d2pom9'];
$d2pom10 = 1*$_REQUEST['d2pom10'];
$d2pom11 = 1*$_REQUEST['d2pom11'];
$d2pom12 = 1*$_REQUEST['d2pom12'];
if ( $d2pomc == 1 ) { $d2pom1=0; $d2pom2=0; $d2pom3=0; $d2pom4=0; $d2pom5=0; $d2pom6=0; $d2pom7=0; $d2pom8=0; $d2pom9=0; $d2pom10=0; $d2pom11=0; $d2pom12=0; }
$d3prie = trim(strip_tags($_REQUEST['d3prie']));
$d3rod = trim(strip_tags($_REQUEST['d3rod']));
$d3pomc = 1*$_REQUEST['d3pomc'];
$d3pom1 = 1*$_REQUEST['d3pom1'];
$d3pom2 = 1*$_REQUEST['d3pom2'];
$d3pom3 = 1*$_REQUEST['d3pom3'];
$d3pom4 = 1*$_REQUEST['d3pom4'];
$d3pom5 = 1*$_REQUEST['d3pom5'];
$d3pom6 = 1*$_REQUEST['d3pom6'];
$d3pom7 = 1*$_REQUEST['d3pom7'];
$d3pom8 = 1*$_REQUEST['d3pom8'];
$d3pom9 = 1*$_REQUEST['d3pom9'];
$d3pom10 = 1*$_REQUEST['d3pom10'];
$d3pom11 = 1*$_REQUEST['d3pom11'];
$d3pom12 = 1*$_REQUEST['d3pom12'];
if ( $d3pomc == 1 ) { $d3pom1=0; $d3pom2=0; $d3pom3=0; $d3pom4=0; $d3pom5=0; $d3pom6=0; $d3pom7=0; $d3pom8=0; $d3pom9=0; $d3pom10=0; $d3pom11=0; $d3pom12=0; }
$d4prie = trim(strip_tags($_REQUEST['d4prie']));
$d4rod = trim(strip_tags($_REQUEST['d4rod']));
$d4pomc = 1*$_REQUEST['d4pomc'];
$d4pom1 = 1*$_REQUEST['d4pom1'];
$d4pom2 = 1*$_REQUEST['d4pom2'];
$d4pom3 = 1*$_REQUEST['d4pom3'];
$d4pom4 = 1*$_REQUEST['d4pom4'];
$d4pom5 = 1*$_REQUEST['d4pom5'];
$d4pom6 = 1*$_REQUEST['d4pom6'];
$d4pom7 = 1*$_REQUEST['d4pom7'];
$d4pom8 = 1*$_REQUEST['d4pom8'];
$d4pom9 = 1*$_REQUEST['d4pom9'];
$d4pom10 = 1*$_REQUEST['d4pom10'];
$d4pom11 = 1*$_REQUEST['d4pom11'];
$d4pom12 = 1*$_REQUEST['d4pom12'];
if ( $d4pomc == 1 ) { $d4pom1=0; $d4pom2=0; $d4pom3=0; $d4pom4=0; $d4pom5=0; $d4pom6=0; $d4pom7=0; $d4pom8=0; $d4pom9=0; $d4pom10=0; $d4pom11=0; $d4pom12=0; }
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
//$t1p10 = 1*$_REQUEST['t1p10'];
//$t1v10 = 1*$_REQUEST['t1v10'];
$t1p11 = 1*$_REQUEST['t1p11'];
$t1v11 = 1*$_REQUEST['t1v11'];
$t1p12 = 1*$_REQUEST['t1p12'];
$t1v12 = 1*$_REQUEST['t1v12'];
//$t1p13 = 1*$_REQUEST['t1p13'];
//$t1v13 = 1*$_REQUEST['t1v13'];
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

$t1ak1 = 1*$_REQUEST['t1ak1'];
$t1ak2 = 1*$_REQUEST['t1ak2'];

$uppr1 = 1*$_REQUEST['uppr1'];
$uppr3 = 1*$_REQUEST['uppr3'];
$uppr4 = 1*$_REQUEST['uppr4'];

$uvp61 = 1*$_REQUEST['uvp61'];
$uvp64 = 1*$_REQUEST['uvp64'];
//$uvp61m = 1*$_REQUEST['uvp61m'];
//if ( $uvp61m > 12 ) { $uvp61m = 12; }
//$uvp64m = 1*$_REQUEST['uvp64m'];
//if ( $uvp64m > 12 ) { $uvp64m = 12; }

$uos61 = 1*$_REQUEST['uos61'];
$uos64 = 1*$_REQUEST['uos64'];
$kos61 = 1*$_REQUEST['kos61'];
$kos64 = 1*$_REQUEST['kos64'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" uppr1='$uppr1', uppr3='$uppr3', uppr4='$uppr4', uvp61='$uvp61', uvp64='$uvp64', ".
" uos61='$uos61', uos64='$uos64', kos61='$kos61', kos64='$kos64', ".
" t1p1='$t1p1', t1p2='$t1p2', t1p3='$t1p3', t1p4='$t1p4', t1p5='$t1p5', t1p6='$t1p6',  ".
" t1p7='$t1p7', t1p8='$t1p8', t1p9='$t1p9', t1p11='$t1p11', t1p12='$t1p12', ".
" t1v1='$t1v1', t1v2='$t1v2', t1v3='$t1v3', t1v4='$t1v4', t1v5='$t1v5', t1v6='$t1v6', ".
" t1v7='$t1v7', t1v8='$t1v8', t1v9='$t1v9', t1v11='$t1v11', t1v12='$t1v12', ".
" perc0='$perc0', perc1='$perc1', perc3='$perc3', perc4='$perc4', psp6='$psp6', ".
" t1az1='$t1az1', t1az2='$t1az2', t1ak1='$t1ak1', t1ak2='$t1ak2' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 4 ) {
$t1az3 = 1*$_REQUEST['t1az3'];
$t1az4 = 1*$_REQUEST['t1az4'];
$t1az5 = 1*$_REQUEST['t1az5'];
$t1ak3 = 1*$_REQUEST['t1ak3'];
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
" t1az3='$t1az3', t1az4='$t1az4', t1az5='$t1az5', t1ak3='$t1ak3', t1ak4='$t1ak4', t1ak5='$t1ak5', r39pu='$r39pu', r40pu='$r40pu',".
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
//$t2p11 = 1*$_REQUEST['t2p11'];
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
//$t2v11 = 1*$_REQUEST['t2v11'];
$t2v12 = 1*$_REQUEST['t2v12'];
$r66 = 1*$_REQUEST['r66'];
$r67 = 1*$_REQUEST['r67'];
$r68 = 1*$_REQUEST['r68'];
$t3p1 = 1*$_REQUEST['t3p1'];
$t3p2 = 1*$_REQUEST['t3p2'];
$t3p3 = 1*$_REQUEST['t3p3'];
$t3v1 = 1*$_REQUEST['t3v1'];
$t3v2 = 1*$_REQUEST['t3v2'];
$t3v3 = 1*$_REQUEST['t3v3'];

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" t2p2='$t2p2', t2p3='$t2p3', t2p4='$t2p4', t2p5='$t2p5', t2p6='$t2p6', t2p7='$t2p7', ".
" t2p8='$t2p8', t2p9='$t2p9', t2p10='$t2p10', t2p12='$t2p12', t2p13='$t2p13', ".
" t2v2='$t2v2', t2v3='$t2v3', t2v4='$t2v4', t2v5='$t2v5', t2v6='$t2v6', t2v7='$t2v7',".
" t2v8='$t2v8', t2v9='$t2v9', t2v10='$t2v10', t2v12='$t2v12', ".
" r66='$r66', r67='$r67', r68='$r68', ".
" t3p1='$t3p1', t3p2='$t3p2', t3p3='$t3p3', ".
" t3v1='$t3v1', t3v2='$t3v2', t3v3='$t3v3' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 7 ) {

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
$t3p15 = 1*$_REQUEST['t3p15'];
$t3p16 = 1*$_REQUEST['t3p16'];

$t3v4 = 1*$_REQUEST['t3v4'];
$t3v5 = 1*$_REQUEST['t3v5'];
$t3v6 = 1*$_REQUEST['t3v6'];
$t3v7 = 1*$_REQUEST['t3v7'];
$t3v8 = 1*$_REQUEST['t3v8'];
$t3v9 = 1*$_REQUEST['t3v9'];
$t3v10 = 1*$_REQUEST['t3v10'];
$t3v11 = 1*$_REQUEST['t3v11'];
$t3v12 = 1*$_REQUEST['t3v12'];
$t3v13 = 1*$_REQUEST['t3v13'];
$t3v14 = 1*$_REQUEST['t3v14'];
$t3v15 = $_REQUEST['t3v15'];
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
" t3p4='$t3p4', t3p5='$t3p5', t3p6='$t3p6', t3p7='$t3p7', t3p8='$t3p8', t3p9='$t3p9', ".
" t3p10='$t3p10', t3p11='$t3p11', t3p12='$t3p12', t3p13='$t3p13', t3p14='$t3p14', t3p15='$t3p15', t3p16='$t3p16', ".
" t3v4='$t3v4', t3v5='$t3v5', t3v6='$t3v6', t3v7='$t3v7', t3v8='$t3v8', t3v9='$t3v9', ".
" t3v10='$t3v10', t3v11='$t3v11', t3v12='$t3v12', t3v13='$t3v13', t3v14='$t3v14', t3v15='$t3v15', ".
" r69='$r69', r70='$r70', r71='$r71' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 8 ) {
$r72 = 1*$_REQUEST['r72'];
$r73 = 1*$_REQUEST['r73'];
$r74 = 1*$_REQUEST['r74'];
$r75 = 1*$_REQUEST['r75'];
//$r76 = 1*$_REQUEST['r76'];
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
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r72='$r72', r73='$r73', r74='$r74', r75='$r75', r77='$r77', r78='$r78', r79='$r79', r80='$r80', r81='$r81', r82='$r82', r83='$r83', ".
" r84='$r84', r85='$r85', r86='$r86', r87='$r87', r88='$r88', r89='$r89', r90='$r90', r91='$r91', r92='$r92', r93='$r93', r94='$r94' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 9 ) {
$r95 = 1*$_REQUEST['r95'];
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
$r110 = 1*$_REQUEST['r110'];
$r111 = 1*$_REQUEST['r111'];
$r112 = 1*$_REQUEST['r112'];
$r113 = 1*$_REQUEST['r113'];
$r114 = 1*$_REQUEST['r114'];
$r115 = 1*$_REQUEST['r115'];
$r116 = 1*$_REQUEST['r116'];
$r117 = 1*$_REQUEST['r117'];
$r118 = 1*$_REQUEST['r118'];
$r119 = 1*$_REQUEST['r119'];
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r95='$r95', r96='$r96', r97='$r97', r98='$r98', r99='$r99', r100='$r100', ".
" r101='$r101', r102='$r102', r103='$r103', r104='$r104', r105='$r105', r106='$r106', ".
" r107='$r107', r108='$r108', r109='$r109', r110='$r110', r111='$r111', r112='$r112', ".
" r113='$r113', r114='$r114', r115='$r115', r116='$r116', r117='$r117', r118='$r118', r119='$r119' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 10 ) {
$r120 = 1*$_REQUEST['r120'];
$r121 = 1*$_REQUEST['r121'];
$r122 = 1*$_REQUEST['r122'];
$r123 = 1*$_REQUEST['r123'];
$r124 = 1*$_REQUEST['r124'];
$r125 = 1*$_REQUEST['r125'];
$r126 = 1*$_REQUEST['r126'];
$r127 = 1*$_REQUEST['r127'];
$sdnr = trim(strip_tags($_REQUEST['sdnr']));
$r129 = 1*$_REQUEST['r129'];
$r130 = 1*$_REQUEST['r130'];
//$udnr = $_REQUEST['udnr'];
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r120='$r120', r121='$r121', r122='$r122', r123='$r123', r124='$r124', r125='$r125', ".
" r126='$r126', r127='$r127', sdnr='$sdnr', r129='$r129', r130='$r130' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 11 ) {
$r131 = 1*$_REQUEST['r131'];
$ldnr = 1*$_REQUEST['ldnr'];
$nrzsprev = 1*$_REQUEST['nrzsprev'];
$upl50 = 1*$_REQUEST['upl50'];
$spl3d = 1*$_REQUEST['spl3d'];
$r134 = 1*$_REQUEST['r134'];
$pico = trim(strip_tags($_REQUEST['pico']));
$psid = trim(strip_tags($_REQUEST['psid']));
$pfor = trim(strip_tags($_REQUEST['pfor']));
$pmen = trim(strip_tags($_REQUEST['pmen']));
$puli = trim(strip_tags($_REQUEST['puli']));
$pcdm = trim(strip_tags($_REQUEST['pcdm']));
$ppsc = trim(strip_tags($_REQUEST['ppsc']));
$pmes = trim(strip_tags($_REQUEST['pmes']));
$zslu = 1*$_REQUEST['zslu'];
$uoso = 1*$_REQUEST['uoso'];
$pzks1 = trim(strip_tags($_REQUEST['pzks1']));
$pdrp1 = trim(strip_tags($_REQUEST['pdrp1']));
$pdro1 = trim(strip_tags($_REQUEST['pdro1']));
$pdrm1 = trim(strip_tags($_REQUEST['pdrm1']));
$pzpr1 = 1*$_REQUEST['pzpr1'];
$pzvd1 = 1*$_REQUEST['pzvd1'];
$pzthvd1 = 1*$_REQUEST['pzthvd1'];
$pzks2 = trim(strip_tags($_REQUEST['pzks2']));
$pdrp2 = trim(strip_tags($_REQUEST['pdrp2']));
$pdro2 = trim(strip_tags($_REQUEST['pdro2']));
$pdrm2 = trim(strip_tags($_REQUEST['pdrm2']));
$pzpr2 = 1*$_REQUEST['pzpr2'];
$pzvd2 = 1*$_REQUEST['pzvd2'];
$pzthvd2 = 1*$_REQUEST['pzthvd2'];
$pzks3 = trim(strip_tags($_REQUEST['pzks3']));
$pdrp3 = trim(strip_tags($_REQUEST['pdrp3']));
$pdro3 = trim(strip_tags($_REQUEST['pdro3']));
$pdrm3 = trim(strip_tags($_REQUEST['pdrm3']));
$pzpr3 = 1*$_REQUEST['pzpr3'];
$pzvd3 = 1*$_REQUEST['pzvd3'];
$pzthvd3 = 1*$_REQUEST['pzthvd3'];
$pzks4 = trim(strip_tags($_REQUEST['pzks4'])) ;
$pdrp4 = trim(strip_tags($_REQUEST['pdrp4']));
$pdro4 = trim(strip_tags($_REQUEST['pdro4']));
$pdrm4 = trim(strip_tags($_REQUEST['pdrm4']));
$pzpr4 = 1*$_REQUEST['pzpr4'];
$pzvd4 = 1*$_REQUEST['pzvd4'];
$pzthvd4 = 1*$_REQUEST['pzthvd4'];
$pzks5 = trim(strip_tags($_REQUEST['pzks5']));
$pdrp5 = trim(strip_tags($_REQUEST['pdrp5']));
$pdro5 = trim(strip_tags($_REQUEST['pdro5']));
$pdrm5 = trim(strip_tags($_REQUEST['pdrm5']));
$pzpr5 = 1*$_REQUEST['pzpr5'];
$pzvd5 = 1*$_REQUEST['pzvd5'];
$pzthvd5 = 1*$_REQUEST['pzthvd5'];
$pzks6 = trim(strip_tags($_REQUEST['pzks6']));
$pdrp6 = trim(strip_tags($_REQUEST['pdrp6']));
$pdro6 = trim(strip_tags($_REQUEST['pdro6']));
$pdrm6 = trim(strip_tags($_REQUEST['pdrm6']));
$pzpr6 = 1*$_REQUEST['pzpr6'];
$pzvd6 = 1*$_REQUEST['pzvd6'];
$pzthvd6 = 1*$_REQUEST['pzthvd6'];
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" r131='$r131', ldnr='$ldnr', nrzsprev='$nrzsprev', upl50='$upl50', spl3d='$spl3d', r134='$r134', ".
" pico='$pico', psid='$psid', pfor='$pfor', pmen='$pmen', puli='$puli', pcdm='$pcdm', ppsc='$ppsc', pmes='$pmes', ".
" zslu='$zslu', uoso='$uoso', ".
" pzks1='$pzks1', pdrp1='$pdrp1', pdro1='$pdro1', pdrm1='$pdrm1', pzpr1='$pzpr1', pzvd1='$pzvd1', pzthvd1='$pzthvd1', ".
" pzks2='$pzks2', pdrp2='$pdrp2', pdro2='$pdro2', pdrm2='$pdrm2', pzpr2='$pzpr2', pzvd2='$pzvd2', pzthvd2='$pzthvd2', ".
" pzks3='$pzks3', pdrp3='$pdrp3', pdro3='$pdro3', pdrm3='$pdrm3', pzpr3='$pzpr3', pzvd3='$pzvd3', pzthvd3='$pzthvd3', ".
" pzks4='$pzks4', pdrp4='$pdrp4', pdro4='$pdro4', pdrm4='$pdrm4', pzpr4='$pzpr4', pzvd4='$pzvd4', pzthvd4='$pzthvd4', ".
" pzks5='$pzks5', pdrp5='$pdrp5', pdro5='$pdro5', pdrm5='$pdrm5', pzpr5='$pzpr5', pzvd5='$pzvd5', pzthvd5='$pzthvd5', ".
" pzks6='$pzks6', pdrp6='$pdrp6', pdro6='$pdro6', pdrm6='$pdrm6', pzpr6='$pzpr6', pzvd6='$pzvd6', pzthvd6='$pzthvd6' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 12 ) {
$osob = trim(strip_tags($_REQUEST['osob']));
$pril = 1*$_REQUEST['pril']; if ( $pril < 2 ) { $pril=2; }
$dat = $_REQUEST['dat'];
$datsql=Sqldatum($dat);
$zdbo = 1*$_REQUEST['zdbo'];
//$zrbo = 1*$_REQUEST['zrbo'];
$zpre = 1*$_REQUEST['zpre'];
$post = 1*$_REQUEST['post'];
$ucet = 1*$_REQUEST['ucet'];
$diban = trim(strip_tags($_REQUEST['diban']));
//$dbic = strip_tags($_REQUEST['dbic']);
//$uceb = strip_tags($_REQUEST['uceb']);
//$numb = strip_tags($_REQUEST['numb']);
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
" osob='$osob', pril='$pril', dat='$datsql', ".
" zdbo='$zdbo', zpre='$zpre', post='$post', ucet='$ucet', diban='$diban', da2='$da2sql' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 13 ) {
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
$prptxt = trim(strip_tags($_REQUEST['prptxt']));
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ".
" prpdzc='$prpdzcsql', prptxt='$prptxt', ".
" prpzo1='$prpzo1sql', prpzo2='$prpzo2sql', prpzo3='$prpzo3sql', prpzo4='$prpzo4sql', prpzo5='$prpzo5sql', ".
" prpzd1='$prpzd1sql', prpzd2='$prpzd2sql', prpzd3='$prpzd3sql', prpzd4='$prpzd4sql', prpzd5='$prpzd5sql', ".
" prpvz1='$prpvz1', prpvz2='$prpvz2', prpvz3='$prpvz3', prpvz4='$prpvz4', prpvz5='$prpvz5', ".
" prpod1='$prpod1', prpod2='$prpod2', prpod3='$prpod3', prpod4='$prpod4', prpod5='$prpod5' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 14 ) {
$ozd1r01 = strip_tags($_REQUEST['ozd1r01']);
$ozd1r02 = strip_tags($_REQUEST['ozd1r02']);
$ozd1r03 = strip_tags($_REQUEST['ozd1r03']);
$ozd1r04 = strip_tags($_REQUEST['ozd1r04']);
$ozd2r04 = strip_tags($_REQUEST['ozd2r04']);
$ozd1r05 = strip_tags($_REQUEST['ozd1r05']);
$ozd2r05 = strip_tags($_REQUEST['ozd2r05']);
$ozd1r06 = strip_tags($_REQUEST['ozd1r06']);
$ozd2r06 = strip_tags($_REQUEST['ozd2r06']);
$ozdr07 = strip_tags($_REQUEST['ozdr07']);
$ozdr09 = strip_tags($_REQUEST['ozdr09']);
$ozdr10 = strip_tags($_REQUEST['ozdr10']);
$ozdr11 = strip_tags($_REQUEST['ozdr11']);
$ozdr12 = strip_tags($_REQUEST['ozdr12']);
$ozdr13 = strip_tags($_REQUEST['ozdr13']);
$ozdr14 = strip_tags($_REQUEST['ozdr14']);
$ozdr15 = strip_tags($_REQUEST['ozdr15']);
$ozdr16 = strip_tags($_REQUEST['ozdr16']);
$ozdr17 = strip_tags($_REQUEST['ozdr17']);
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET".
" ozd1r01='$ozd1r01', ozd1r02='$ozd1r02', ozd1r03='$ozd1r03', ".
" ozd1r04='$ozd1r04', ozd2r04='$ozd2r04', ozd1r05='$ozd1r05', ozd2r05='$ozd2r05', ozd1r06='$ozd1r06', ozd2r06='$ozd2r06', ".
" ozdr07='$ozdr07', ozdr09='$ozdr09', ozdr10='$ozdr10', ozdr11='$ozdr11', ".
" ozdr12='$ozdr12', ozdr13='$ozdr13', ozdr14='$ozdr14', ozdr15='$ozdr15', ozdr16='$ozdr16', ".
" ozdr17='$ozdr17' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 15 ) {
$ozdr18 = strip_tags($_REQUEST['ozdr18']);
$ozd1r19 = strip_tags($_REQUEST['ozd1r19']);
$ozd1r20 = strip_tags($_REQUEST['ozd1r20']);
$ozd1r21 = strip_tags($_REQUEST['ozd1r21']);
$ozd1r22 = strip_tags($_REQUEST['ozd1r22']);
$ozd2r22 = strip_tags($_REQUEST['ozd2r22']);
$ozd1r23 = strip_tags($_REQUEST['ozd1r23']);
$ozd2r23 = strip_tags($_REQUEST['ozd2r23']);
$ozd1r24 = strip_tags($_REQUEST['ozd1r24']);
$ozd2r24 = strip_tags($_REQUEST['ozd2r24']);
$ozdr25 = strip_tags($_REQUEST['ozdr25']);
$ozdr26 = strip_tags($_REQUEST['ozdr26']);
$ozdr27 = strip_tags($_REQUEST['ozdr27']);
$ozdr28 = strip_tags($_REQUEST['ozdr28']);
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET".
" ozdr18='$ozdr18', ozd1r19='$ozd1r19', ozd1r20='$ozd1r20', ozd1r21='$ozd1r21', ".
" ozd1r22='$ozd1r22', ozd2r22='$ozd2r22', ozd1r23='$ozd1r23', ozd2r23='$ozd2r23', ozd1r24='$ozd1r24', ozd2r24='$ozd2r24', ".
" ozdr25='$ozdr25', ozdr27='$ozdr27', ozdr28='$ozdr28' ".
" WHERE oc = $cislo_oc";
                     }

if ( $strana == 16 ) {
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
//$sz16 = 1*$_REQUEST['sz16'];
$vpdu = 1*$_REQUEST['vpdu'];
$szdat = $_REQUEST['szdat'];
$szdatsql=Sqldatum($szdat);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET".
" sz1p1='$sz1p1', sz1v1='$sz1v1', sz2='$sz2', sz3='$sz3', sz4='$sz4', sz5='$sz5', sz6='$sz6', sz7='$sz7', sz8='$sz8', sz9='$sz9', sz10='$sz10', ".
" sz11='$sz11', sz12='$sz12', sz13='$sz13', sz14='$sz14', sz15='$sz15', szdat='$szdatsql', vpdu='$vpdu' ".
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
   dar          DATE NOT NULL,
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
   dat          DATE NOT NULL,
   zdbo         DECIMAL(2,0) DEFAULT 0,
   zrbo         DECIMAL(2,0) DEFAULT 0,
   post         DECIMAL(2,0) DEFAULT 0,
   ucet         DECIMAL(2,0) DEFAULT 0,
   uceb         VARCHAR(30) NOT NULL,
   numb         VARCHAR(10) NOT NULL,
   da2          DATE NOT NULL,
   zpre         DECIMAL(2,0) DEFAULT 0,
   zprp         DECIMAL(2,0) DEFAULT 0,
   post2        DECIMAL(2,0) DEFAULT 0,
   ucet2        DECIMAL(2,0) DEFAULT 0,
   uceb2        VARCHAR(30) NOT NULL,
   numb2        VARCHAR(10) NOT NULL,
   da3          DATE NOT NULL,
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
//zmeny2013
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
//zmeny2014
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
//zmeny2015
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

//zmeny2016
$sql = "SELECT pdrm6 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r50 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD new2016 DECIMAL(2,0) DEFAULT 0 AFTER prpdzc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1p13 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t1v13 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p16 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3p17 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD t3v17 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r129 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r130 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r131 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD r134 DECIMAL(10,2) DEFAULT 0 AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm1 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm2 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm3 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm4 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm5 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD pdrm6 VARCHAR(3) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
}
//zmeny2017
$sql = "SELECT alla2017 FROM F".$kli_vxcf."_mzdpriznanie_fob";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY r51 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD new2017 DECIMAL(2,0) NOT NULL AFTER new2016";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r01 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r02 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r03 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r04 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r05 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r06 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr07 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr08 DECIMAL(2,0) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr09 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr10 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr11 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr12 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr13 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr14 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr15 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr16 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr17 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr18 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r19 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r20 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r21 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r22 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r22 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r23 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r23 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd1r24 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozd2r24 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr25 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr27 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD ozdr28 DECIMAL(10,2) DEFAULT 0 AFTER new2017";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob MODIFY pico DECIMAL(12,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_fob ADD alla2017 DECIMAL(2,0) NOT NULL AFTER new2017";
$vysledek = mysql_query("$sql");
}

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

//vsetky vypocty su upravene na rok 2017
//vypocty
//odstavene vypocty
//$prepocitaj=0;
$alertprepocet="";
if ( ( $copern == 10 OR $copern == 20 ) AND $prepocitaj == 1 )
{
$alertprepocet="!!! PrepoËÌtavam hodnoty v riadkoch !!!";

//str 2 zaklady dane zo zav.cinnosti 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r36=r34-r35 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//str 3 prijmy,vydavky z tabulky 1. 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1p10=t1p1+t1p2+t1p3+t1p4+t1p5+t1p6+t1p7+t1p8+t1p9 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1v10=t1v1+t1v2+t1v3+t1v4+t1v5+t1v6+t1v7+t1v8+t1v9 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1p13=t1p11+t1p12  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t1v13=t1v11+t1v12  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//str 4 zaklad dane, danova strata z podnikania 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r37=t1p10, r38=t1v10, r39=0, r40=0, r43=0, r44=0  WHERE oc = $cislo_oc ";
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

//str 5 2016
//str 5 uplatnenie danovych strat 2016
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r53=r45+r46+r47+r48+r49+r50 WHERE oc = $cislo_oc ";
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

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r58=t1p13, r59=t1v13, r60=0, r65=0 WHERE oc = $cislo_oc ";
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

//str 5,6 prijmy,vydavky z tabulky 2. 2017
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

//str 6,7 vypocet zakladu dane z ostatnych prijmov tabulka 3. 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3p17=t3p1+t3p2+t3p3+t3p4+t3p5+t3p6+t3p7+t3p8+t3p9+t3p10+t3p11+t3p12+t3p13+t3p14+t3p15+t3p16 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET t3v17=t3v1+t3v2+t3v3+t3v4+t3v5+t3v6+t3v7+t3v8+t3v9+t3v10+t3v11+t3v12+t3v13+t3p14+t3p15 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r69=t3p17, r70=t3v17, r71=r69-r70 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


//str 8 vypocet zakladu dane 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r72=r36+r57 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


if ( $miliondan == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//max.nezdanitelna cast na danovnika za 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r73=3803.33 WHERE oc = $cislo_oc  ";
$oznac = mysql_query("$sqtoz");

//milionarska dan 2017
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
//koniec max.nezdanitelna cast na danovnika za 2017

if ( $namanzelku == 1 )
     {
//nezdanitelna cast na manzelku 2017
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
//nezdanitelna na manzelku 2017


//str 8 vypocet zakladu dane 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=r73+r74+r75  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r77=r72  WHERE oc = $cislo_oc AND r77 > r72 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=r72-r77 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r78=0 WHERE oc = $cislo_oc AND r78 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r80=r78+r65+r71+r79 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r80=0 WHERE oc = $cislo_oc AND r80 < 0 ";
$oznac = mysql_query("$sqtoz");


//str 8 dan z prijmu 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=r80*19/100 WHERE oc = $cislo_oc AND r80 <= 35022.31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=(35022.31*19/100)+((r80-35022.31)*25/100) WHERE oc = $cislo_oc AND r80 > 35022.31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des2=des6*100, r81=floor(des2), r81=r81/100 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r81 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//str 8 dan po vynati prijmov 2017 dan zo zakladu na r83 nepocitam 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r83=r80-r82 WHERE oc = $cislo_oc AND r82 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r83=0 WHERE oc = $cislo_oc AND r83 < 0 ";
$oznac = mysql_query("$sqtoz");

//str 8 dan po zapocte 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r84-r89 WHERE oc = $cislo_oc AND r83 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r90=r81-r89 WHERE oc = $cislo_oc AND r83 = 0 ";
$oznac = mysql_query("$sqtoz");

//str 8 dan z osobitneho zakladu dane na r68 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des6=r68*19/100 WHERE oc = $cislo_oc AND r68 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET des2=des6*100, r91=floor(des2), r91=r91/100 WHERE oc = $cislo_oc AND r68 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r93=r68-r92 WHERE oc = $cislo_oc AND r68 > 0 AND r92 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r93=0 WHERE oc = $cislo_oc AND r68 > 0 AND r93 < 0 ";

//str 9 dan z osobitneho zakladu dane podla par.7 2017
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r100=r91-r99 WHERE oc = $cislo_oc AND r68 > 0 AND r91 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r100=r94-r99 WHERE oc = $cislo_oc AND r68 > 0 AND r94 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r104=r100-r103 WHERE oc = $cislo_oc AND r68 > 0 ";
$oznac = mysql_query("$sqtoz");


//str 9 dan celkom 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r105=r90+r104 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vynuluj zuctovanie bonusu
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r107=0, r109=0, r110=0, r111=0, r100=0  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//dan znizena o dan. bonusu 2017 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r107=r105-r106 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r107=0 WHERE oc = $cislo_oc AND r107 < 0 ";
$oznac = mysql_query("$sqtoz");

//vysporiadanie danoveho bonusu 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r109=r106-r108  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r109=0 WHERE oc = $cislo_oc AND r109 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r110=r109-r105  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r110=0 WHERE oc = $cislo_oc AND r110 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r111=r108-r106  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r111=0 WHERE oc = $cislo_oc AND r111 < 0 ";
$oznac = mysql_query("$sqtoz");

//zapl.dan z urok.prijmov 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r119=r102-r103  WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//str 10 dan na uhradu, preplatok 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r121=0, r120=r105-r106+r108+r110+r112-r113-r114-r115-r116-r117-r118-r119 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET r121=-r120, r120=0 WHERE oc = $cislo_oc AND r120 < 0 ";
$oznac = mysql_query("$sqtoz");


//Priloha 1 o projektoch 2017
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpods=prpod1+prpod2+prpod3+prpod4+prpod5 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpodv=prpods WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpcp=0, prppp=0 WHERE prpods = 0 AND oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET prpcp=1, prppp=1 WHERE prpods > 0 AND oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//Priloha 2 dividendy 2017 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ozd1r06=ozd1r01+ozd1r02+ozd1r03+ozd1r04+ozd1r05, ozd2r06=ozd2r04+ozd2r05 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET ozd1r24=ozd1r19+ozd1r20+ozd1r21+ozd1r22+ozd1r23, ozd2r24=ozd2r22+ozd2r23 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//Priloha 3 socialne a zdravotne poistenie 2017 
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

$dnessk = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

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
$t1p13 = $fir_riadok->t1p13;
$t1v13 = $fir_riadok->t1v13;
$perc0 = $fir_riadok->perc0;
$perc1 = $fir_riadok->perc1;
$perc3 = $fir_riadok->perc3;
$perc4 = $fir_riadok->perc4;
$psp6 = $fir_riadok->psp6;
$t1az1 = $fir_riadok->t1az1;
$t1az2 = $fir_riadok->t1az2;

$t1ak1 = $fir_riadok->t1ak1;
$t1ak2 = $fir_riadok->t1ak2;

$uppr1 = $fir_riadok->uppr1;
$uppr3 = $fir_riadok->uppr3;
$uppr4 = $fir_riadok->uppr4;

$uvp61 = $fir_riadok->uvp61;
$uvp64 = $fir_riadok->uvp64;

$uos61 = $fir_riadok->uos61;
$uos64 = $fir_riadok->uos64;
$kos61 = $fir_riadok->kos61;
$kos64 = $fir_riadok->kos64;

                    }

if ( $strana == 4 ) {
$t1az3 = $fir_riadok->t1az3;
$t1az4 = $fir_riadok->t1az4;
$t1az5 = $fir_riadok->t1az5;
$t1ak3 = $fir_riadok->t1ak3;
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
$t3p3 = $fir_riadok->t3p3;
$t3v1 = $fir_riadok->t3v1;
$t3v2 = $fir_riadok->t3v2;
$t3v3 = $fir_riadok->t3v3;
                    }

if ( $strana == 7 ) {

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
$t3p16 = $fir_riadok->t3p16;
$t3p17 = $fir_riadok->t3p17;

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
$t3v14 = $fir_riadok->t3v14;
$t3v15 = $fir_riadok->t3v15;
$t3v17 = $fir_riadok->t3v17;
$r69 = $fir_riadok->r69;
$r70 = $fir_riadok->r70;
$r71 = $fir_riadok->r71;
                    }

if ( $strana == 8 ) {
$r72 = $fir_riadok->r72;
$r73 = $fir_riadok->r73;
$r74 = $fir_riadok->r74;
$r75 = $fir_riadok->r75;
//$r76 = $fir_riadok->r76;
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
                    }

if ( $strana == 9 ) {
$r95 = $fir_riadok->r95;
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
$r110 = $fir_riadok->r110;
$r111 = $fir_riadok->r111;
$r112 = $fir_riadok->r112;
$r113 = $fir_riadok->r113;
$r114 = $fir_riadok->r114;
$r115 = $fir_riadok->r115;
$r116 = $fir_riadok->r116;
$r117 = $fir_riadok->r117;
$r118 = $fir_riadok->r118;
$r119 = $fir_riadok->r119;
                    }

if ( $strana == 10 ) {
$r120 = $fir_riadok->r120;
$r121 = $fir_riadok->r121;
$r122 = $fir_riadok->r122;
$r123 = $fir_riadok->r123;
$r124 = $fir_riadok->r124;
$r125 = $fir_riadok->r125;
$r126 = $fir_riadok->r126;
$r127 = $fir_riadok->r127;
$sdnr = $fir_riadok->sdnr;
$r129 = $fir_riadok->r129;
$r130 = $fir_riadok->r130;
                     }

if ( $strana == 11 ) {
$r131 = $fir_riadok->r131;
$ldnr = $fir_riadok->ldnr;
$nrzsprev = $fir_riadok->nrzsprev;
$upl50 = $fir_riadok->upl50;
$spl3d = $fir_riadok->spl3d;
$r134 = $fir_riadok->r134;
$pico = $fir_riadok->pico;
$psid = $fir_riadok->psid;
$pfor = $fir_riadok->pfor;
$pmen = $fir_riadok->pmen;
$puli = $fir_riadok->puli;
$pcdm = $fir_riadok->pcdm;
$ppsc = $fir_riadok->ppsc;
$pmes = $fir_riadok->pmes;
$zslu = $fir_riadok->zslu;
$uoso = $fir_riadok->uoso;
$pzks1 = $fir_riadok->pzks1;
$pdrp1 = $fir_riadok->pdrp1;
$pdro1 = $fir_riadok->pdro1;
$pdrm1 = $fir_riadok->pdrm1;
$pzpr1 = $fir_riadok->pzpr1;
$pzvd1 = $fir_riadok->pzvd1;
$pzthvd1 = $fir_riadok->pzthvd1;
$pzks2 = $fir_riadok->pzks2;
$pdrp2 = $fir_riadok->pdrp2;
$pdro2 = $fir_riadok->pdro2;
$pdrm2 = $fir_riadok->pdrm2;
$pzpr2 = $fir_riadok->pzpr2;
$pzvd2 = $fir_riadok->pzvd2;
$pzthvd2 = $fir_riadok->pzthvd2;
$pzks3 = $fir_riadok->pzks3;
$pdrp3 = $fir_riadok->pdrp3;
$pdro3 = $fir_riadok->pdro3;
$pdrm3 = $fir_riadok->pdrm3;
$pzpr3 = $fir_riadok->pzpr3;
$pzvd3 = $fir_riadok->pzvd3;
$pzthvd3 = $fir_riadok->pzthvd3;
$pzks4 = $fir_riadok->pzks4;
$pdrp4 = $fir_riadok->pdrp4;
$pdro4 = $fir_riadok->pdro4;
$pdrm4 = $fir_riadok->pdrm4;
$pzpr4 = $fir_riadok->pzpr4;
$pzvd4 = $fir_riadok->pzvd4;
$pzthvd4 = $fir_riadok->pzthvd4;
$pzks5 = $fir_riadok->pzks5;
$pdrp5 = $fir_riadok->pdrp5;
$pdro5 = $fir_riadok->pdro5;
$pdrm5 = $fir_riadok->pdrm5;
$pzpr5 = $fir_riadok->pzpr5;
$pzvd5 = $fir_riadok->pzvd5;
$pzthvd5 = $fir_riadok->pzthvd5;
$pzks6 = $fir_riadok->pzks6;
$pdrp6 = $fir_riadok->pdrp6;
$pdro6 = $fir_riadok->pdro6;
$pdrm6 = $fir_riadok->pdrm6;
$pzpr6 = $fir_riadok->pzpr6;
$pzvd6 = $fir_riadok->pzvd6;
$pzthvd6 = $fir_riadok->pzthvd6;
                     }

if ( $strana == 12 ) {
$osob = $fir_riadok->osob;
$pril = $fir_riadok->pril;
$dat = $fir_riadok->dat;
$datsk=Skdatum($dat);
if ( $datsk == '00.00.0000' )
{
//$datsk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
//$datsql=SqlDatum($datsk);
//$sqlx = "UPDATE F$kli_vxcf"."_mzdpriznanie_fob SET dat='$datsql' ";
//$vysledekx = mysql_query("$sqlx");
}
$zdbo = $fir_riadok->zdbo;
$zpre = $fir_riadok->zpre;
$post = $fir_riadok->post;
$ucet = $fir_riadok->ucet;
$diban = $fir_riadok->diban;
$da2 = $fir_riadok->da2;
$da2sk=Skdatum($da2);
                     }

if ( $strana == 13 ) {
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

if ( $strana == 14 ) {
$ozd1r01 = $fir_riadok->ozd1r01;
$ozd1r02 = $fir_riadok->ozd1r02;
$ozd1r03 = $fir_riadok->ozd1r03;
$ozd1r04 = $fir_riadok->ozd1r04;
$ozd2r04 = $fir_riadok->ozd2r04;
$ozd1r05 = $fir_riadok->ozd1r05;
$ozd2r05 = $fir_riadok->ozd2r05;
$ozd1r06 = $fir_riadok->ozd1r06;
$ozd2r06 = $fir_riadok->ozd2r06;
$ozdr07 = $fir_riadok->ozdr07;
$ozdr09 = $fir_riadok->ozdr09;
$ozdr10 = $fir_riadok->ozdr10;
$ozdr11 = $fir_riadok->ozdr11;
$ozdr12 = $fir_riadok->ozdr12;
$ozdr13 = $fir_riadok->ozdr13;
$ozdr14 = $fir_riadok->ozdr14;
$ozdr15 = $fir_riadok->ozdr15;
$ozdr16 = $fir_riadok->ozdr16;
$ozdr17 = $fir_riadok->ozdr17;
                     }

if ( $strana == 15 ) {
$ozdr18 = $fir_riadok->ozdr18;
$ozd1r19 = $fir_riadok->ozd1r19;
$ozd1r20 = $fir_riadok->ozd1r20;
$ozd1r21 = $fir_riadok->ozd1r21;
$ozd1r22 = $fir_riadok->ozd1r22;
$ozd2r22 = $fir_riadok->ozd2r22;
$ozd1r23 = $fir_riadok->ozd1r23;
$ozd2r23 = $fir_riadok->ozd2r23;
$ozd1r24 = $fir_riadok->ozd1r24;
$ozd2r24 = $fir_riadok->ozd2r24;
$ozdr25 = $fir_riadok->ozdr25;
$ozdr26 = $fir_riadok->ozdr26;
$ozdr27 = $fir_riadok->ozdr27;
$ozdr28 = $fir_riadok->ozdr28;
                     }

if ( $strana == 16 ) {
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
$szdat = $fir_riadok->szdat;
$szdatsk=Skdatum($szdat);
$vpdu = $fir_riadok->vpdu;
                     }
mysql_free_result($fir_vysledok);
     }
//koniec nacitania
?>
<head>
<meta charset="cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>DPFOB | EuroSecom</title>
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
.bg-white {
  background-color: white;
  border-radius: 2px;
}
.bg-white > p > a:hover {
  text-decoration: underline;
}
#upozornenie > h2 {
  line-height: 20px;
  margin-top: 25px;
  margin-bottom: 10px;
  overflow: auto;
}
#upozornenie > h2 > strong {
  font-size: 16px;
  font-weight: bold;
}
#upozornenie > ul > li {
  line-height: 18px;
  margin: 10px 0;
  font-size: 13px;
}
.red {
  border-left: 4px solid #f22613;
  text-indent: 8px;
}
.orange {
  border-left: 4px solid #f89406;
  text-indent: 8px;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 11px;
  position: relative;
  top: 5px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
.box-red {
  background-color: #f22613;
}
.box-orange {
  background-color: #f89406;
}
.header-section {
  padding-top: 5px;
}
</style>
</head>
<?php if( $zandroidu == 1 ) { ?>
<body class="white">
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
</body>
<?php                       } ?>

<?php if( $zandroidu == 0 ) { ?>
<body id="white" onload="ObnovUI();">
<?php                       } ?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DaÚ z prÌjmov FO typ B
<?php if ( $copern == 10 ) { ?>
    <span class="subheader">/ export xml</span>
<?php } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="FormPoucenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="FormXML();" title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="FormPDF(9999);" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<?php
//uprav udaje
if ( $copern == 20 )
    {
?>
<form name="formv1" method="post" action="priznanie_fob2017.php?copern=23&cislo_oc=<?php echo $cislo_oc; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
$clas6="noactive"; $clas7="noactive"; $clas8="noactive"; $clas9="noactive"; $clas10="noactive";
$clas11="noactive"; $clas12="noactive"; $clas13="noactive"; $clas14="noactive";
$clas15="noactive"; $clas16="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active";
if ( $strana == 11 ) $clas11="active"; if ( $strana == 12 ) $clas12="active";
if ( $strana == 13 ) $clas13="active"; if ( $strana == 14 ) $clas14="active";
if ( $strana == 15 ) $clas15="active"; if ( $strana == 16 ) $clas16="active";
//$source="../ucto/priznanie_fob2017.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
  <a href="#" onclick="editForm(6);" class="<?php echo $clas6; ?> toleft">6</a>
  <a href="#" onclick="editForm(7);" class="<?php echo $clas7; ?> toleft">7</a>
  <a href="#" onclick="editForm(8);" class="<?php echo $clas8; ?> toleft">8</a>
  <a href="#" onclick="editForm(9);" class="<?php echo $clas9; ?> toleft">9</a>
  <a href="#" onclick="editForm(10);" class="<?php echo $clas10; ?> toleft">10</a>
  <a href="#" onclick="editForm(11);" class="<?php echo $clas11; ?> toleft">11</a>
  <a href="#" onclick="editForm(12);" class="<?php echo $clas12; ?> toleft">12</a>
  <a href="#" onclick="editForm(13);" class="<?php echo $clas13; ?> toleft">P1</a>
  <a href="#" onclick="editForm(14);" class="<?php echo $clas14; ?> toleft">P2</a>
  <a href="#" onclick="editForm(15);" class="<?php echo $clas15; ?> toleft">P2</a>
  <a href="#" onclick="editForm(16);" class="<?php echo $clas16; ?> toleft">P3</a>

 <!--
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
 <h6 class="toright">TlaËiù:</h6> -->
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php
if ( $prepocitaj == 0 ) { $prepocitaj=1; }
?>
  <input type="checkbox" name="prepocitaj" value="1" class="btn-prepocet"/>
<?php if ( $prepocitaj == 1 ) { ?>
  <script type="text/javascript">document.formv1.prepocitaj.checked = "checked";</script>
<?php                         } ?>
  <h5 class="btn-prepocet-title">PrepoËÌtaù hodnoty</h5>
  <div class="alert-pocitam"><?php echo $alertprepocet; ?></div>
</div> <!-- .navbar -->

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:258px; left:57px;"><?php echo $fir_fdic; ?></span>
<input type="text" name="dar" id="dar" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:195px; top:308px; left:51px;"/>

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
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:307px; left:690px;"/>

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
<span class="text-echo" style="top:371px; left:170px;"><?php echo $sn1c; ?></span>
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
<input type="text" name="d2psc" id="d2psc" maxlength="5" style="width:107px; top:742px; left:51px;"/>
<input type="text" name="d2mes" id="d2mes" style="width:451px; top:742px; left:178px;"/>
<!-- II.ODDIEL -->
<input type="text" name="zprie" id="zprie" style="width:359px; top:850px; left:51px;"/>
<input type="text" name="zmeno" id="zmeno" style="width:244px; top:850px; left:430px;"/>
<input type="text" name="ztitl" id="ztitl" style="width:112px; top:850px; left:694px;"/>
<input type="text" name="ztitz" id="ztitz" style="width:66px; top:850px; left:827px;"/>
<input type="text" name="zrdc" id="zrdc" maxlength="6" style="width:129px; top:905px; left:51px;"/>
<input type="text" name="zrdk" id="zrdk" maxlength="4" style="width:84px; top:905px; left:212px;"/>
<input type="text" name="zuli" id="zuli" style="width:357px; top:905px; left:328px;"/>
<input type="text" name="zcdm" id="zcdm" style="width:175px; top:905px; left:718px;"/>
<input type="text" name="zpsc" id="zpsc" maxlength="5" style="width:107px; top:960px; left:51px;"/>
<input type="text" name="zmes" id="zmes" style="width:451px; top:960px; left:178px;"/>
<input type="text" name="zstat" id="zstat" style="width:245px; top:960px; left:648px;"/>
<!-- telefon a fax FO -->
<input type="text" name="dtel" id="dtel" style="width:289px; top:1022px; left:52px;"/>
<input type="text" name="dmailfax" id="dmailfax" style="width:519px; top:1022px; left:373px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- III.ODDIEL -->
<input type="checkbox" name="r29" value="1" style="top:285px; left:746px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:330px; left:701px;"/>
<input type="text" name="mprie" id="mprie" style="width:340px; top:419px; left:51px;"/>
<input type="text" name="mrod" id="mrod" style="width:240px; top:419px; left:413px;"/>
<input type="text" name="mpri" id="mpri" onkeyup="CiarkaNaBodku(this);" style="width:153px; top:419px; left:671px;"/>
<input type="text" name="mpom" id="mpom" style="width:38px; top:419px; left:850px;"/>
<!-- IV.ODDIEL -->
<!-- 1.riadok -->
<input type="text" name="d1prie" id="d1prie" style="width:243px; top:656px; left:47px;"/>
<input type="text" name="d1rod" id="d1rod" maxlength="10" style="width:240px; top:656px; left:304px;"/>
<input type="checkbox" name="d1pomc" value="1" style="top:667px; left:562px;"/>
<input type="checkbox" name="d1pom1" value="1" style="top:667px; left:598px;"/>
<input type="checkbox" name="d1pom2" value="1" style="top:667px; left:624px;"/>
<input type="checkbox" name="d1pom3" value="1" style="top:667px; left:649px;"/>
<input type="checkbox" name="d1pom4" value="1" style="top:667px; left:674px;"/>
<input type="checkbox" name="d1pom5" value="1" style="top:667px; left:699px;"/>
<input type="checkbox" name="d1pom6" value="1" style="top:667px; left:724px;"/>
<input type="checkbox" name="d1pom7" value="1" style="top:667px; left:750px;"/>
<input type="checkbox" name="d1pom8" value="1" style="top:667px; left:775px;"/>
<input type="checkbox" name="d1pom9" value="1" style="top:667px; left:800px;"/>
<input type="checkbox" name="d1pom10" value="1" style="top:667px; left:826px;"/>
<input type="checkbox" name="d1pom11" value="1" style="top:667px; left:851px;"/>
<input type="checkbox" name="d1pom12" value="1" style="top:667px; left:877px;"/>
<!-- 2.riadok -->
<input type="text" name="d2prie" id="d2prie" style="width:243px; top:700px; left:47px;"/>
<input type="text" name="d2rod" id="d2rod" style="width:240px; top:700px; left:304px;"/>
<input type="checkbox" name="d2pomc" value="1" style="top:711px; left:562px;"/>
<input type="checkbox" name="d2pom1" value="1" style="top:711px; left:598px;"/>
<input type="checkbox" name="d2pom2" value="1" style="top:711px; left:624px;"/>
<input type="checkbox" name="d2pom3" value="1" style="top:711px; left:649px;"/>
<input type="checkbox" name="d2pom4" value="1" style="top:711px; left:674px;"/>
<input type="checkbox" name="d2pom5" value="1" style="top:711px; left:699px;"/>
<input type="checkbox" name="d2pom6" value="1" style="top:711px; left:724px;"/>
<input type="checkbox" name="d2pom7" value="1" style="top:711px; left:750px;"/>
<input type="checkbox" name="d2pom8" value="1" style="top:711px; left:775px;"/>
<input type="checkbox" name="d2pom9" value="1" style="top:711px; left:800px;"/>
<input type="checkbox" name="d2pom10" value="1" style="top:711px; left:826px;"/>
<input type="checkbox" name="d2pom11" value="1" style="top:711px; left:851px;"/>
<input type="checkbox" name="d2pom12" value="1" style="top:711px; left:877px;"/>
<!-- 3.riadok -->
<input type="text" name="d3prie" id="d3prie" style="width:243px; top:745px; left:47px;"/>
<input type="text" name="d3rod" id="d3rod" style="width:240px; top:745px; left:304px;"/>
<input type="checkbox" name="d3pomc" value="1" style="top:756px; left:562px;"/>
<input type="checkbox" name="d3pom1" value="1" style="top:756px; left:598px;"/>
<input type="checkbox" name="d3pom2" value="1" style="top:756px; left:624px;"/>
<input type="checkbox" name="d3pom3" value="1" style="top:756px; left:649px;"/>
<input type="checkbox" name="d3pom4" value="1" style="top:756px; left:674px;"/>
<input type="checkbox" name="d3pom5" value="1" style="top:756px; left:699px;"/>
<input type="checkbox" name="d3pom6" value="1" style="top:756px; left:724px;"/>
<input type="checkbox" name="d3pom7" value="1" style="top:756px; left:750px;"/>
<input type="checkbox" name="d3pom8" value="1" style="top:756px; left:775px;"/>
<input type="checkbox" name="d3pom9" value="1" style="top:756px; left:800px;"/>
<input type="checkbox" name="d3pom10" value="1" style="top:756px; left:826px;"/>
<input type="checkbox" name="d3pom11" value="1" style="top:756px; left:851px;"/>
<input type="checkbox" name="d3pom12" value="1" style="top:756px; left:877px;"/>
<!-- 4.riadok -->
<input type="text" name="d4prie" id="d4prie" style="width:243px; top:790px; left:47px;"/>
<input type="text" name="d4rod" id="d4rod" style="width:240px; top:790px; left:304px;"/>
<input type="checkbox" name="d4pomc" value="1" style="top:800px; left:562px;"/>
<input type="checkbox" name="d4pom1" value="1" style="top:800px; left:598px;"/>
<input type="checkbox" name="d4pom2" value="1" style="top:800px; left:624px;"/>
<input type="checkbox" name="d4pom3" value="1" style="top:800px; left:649px;"/>
<input type="checkbox" name="d4pom4" value="1" style="top:800px; left:674px;"/>
<input type="checkbox" name="d4pom5" value="1" style="top:800px; left:699px;"/>
<input type="checkbox" name="d4pom6" value="1" style="top:800px; left:724px;"/>
<input type="checkbox" name="d4pom7" value="1" style="top:800px; left:750px;"/>
<input type="checkbox" name="d4pom8" value="1" style="top:800px; left:775px;"/>
<input type="checkbox" name="d4pom9" value="1" style="top:800px; left:800px;"/>
<input type="checkbox" name="d4pom10" value="1" style="top:800px; left:826px;"/>
<input type="checkbox" name="d4pom11" value="1" style="top:800px; left:851px;"/>
<input type="checkbox" name="d4pom12" value="1" style="top:800px; left:877px;"/>
<input type="checkbox" name="r33" value="1" style="top:828px; left:86px;"/>
<!-- V.ODDIEL -->
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1017px; left:501px;"/>
<input type="text" name="r34a" id="r34a" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1056px; left:501px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:1096px; left:568px;"/>
<div class="input-echo right" style="width:242px; top:1137px; left:501px;"><?php echo $r36; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1138px; left:780px;">
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_source; ?>_str3.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- VI.ODDIEL -->
<!-- Tabulka1 -->
<input type="text" name="t1p1" id="t1p1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:240px; left:410px;"/>
<input type="text" name="t1v1" id="t1v1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:240px; left:661px;"/>
<input type="text" name="t1p2" id="t1p2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:279px; left:410px;"/>
<input type="text" name="t1v2" id="t1v2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:279px; left:661px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajVHpredDanou();" title="NaËÌtaù prÌjmy, v˝davky a zaplatenÈ poistnÈ SP a ZP zo ûivnosti. Pred naËÌtanÌm spracujte V˝kaz o prÌjmoch a v˝davkoch za 12.<?php echo $kli_vrok; ?>" class="btn-row-tool" style="top:280px; left:910px;">
<input type="text" name="t1p3" id="t1p3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:318px; left:410px;"/>
<input type="text" name="t1v3" id="t1v3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:318px; left:661px;"/>
<input type="text" name="t1p4" id="t1p4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:359px; left:410px;"/>
<input type="text" name="t1v4" id="t1v4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:359px; left:661px;"/>
<input type="text" name="t1p5" id="t1p5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:402px; left:410px;"/>
<input type="text" name="t1v5" id="t1v5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:402px; left:661px;"/>
<input type="text" name="t1p6" id="t1p6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:444px; left:410px;"/>
<input type="text" name="t1v6" id="t1v6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:444px; left:661px;"/>
<input type="text" name="t1p7" id="t1p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:484px; left:410px;"/>
<input type="text" name="t1v7" id="t1v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:484px; left:661px;"/>
<input type="text" name="t1p8" id="t1p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:524px; left:410px;"/>
<input type="text" name="t1v8" id="t1v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:524px; left:661px;"/>
<input type="text" name="t1p9" id="t1p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:567px; left:410px;"/>
<input type="text" name="t1v9" id="t1v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:567px; left:661px;"/>
<div class="input-echo right" style="width:230px; top:610px; left:413px;"><?php echo $t1p10; ?>&nbsp;</div>
<div class="input-echo right" style="width:230px; top:610px; left:662px;"><?php echo $t1v10; ?>&nbsp;</div>
<input type="text" name="t1p11" id="t1p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:650px; left:410px;"/>
<input type="text" name="t1v11" id="t1v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:650px; left:661px;"/>
<input type="text" name="t1p12" id="t1p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:691px; left:410px;"/>
<input type="text" name="t1v12" id="t1v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:691px; left:661px;"/>
<div class="input-echo right" style="width:230px; top:732px; left:413px;"><?php echo $t1p13; ?>&nbsp;</div>
<div class="input-echo right" style="width:230px; top:732px; left:662px;"><?php echo $t1v13; ?>&nbsp;</div>
<!-- uplatnujem -->
<input type="checkbox" name="uppr1" value="1" style="top:830px; left:65px;"/>
<input type="checkbox" name="uppr3" value="1" style="top:830px; left:360px;"/>
<input type="checkbox" name="uppr4" value="1" style="top:830px; left:633px;"/>
<input type="checkbox" name="uvp61" value="1" style="top:883px; left:65px;"/>
<input type="checkbox" name="uvp64" value="1" style="top:918px; left:65px;"/>
<input type="text" name="psp6" id="psp6" onkeyup="CiarkaNaBodku(this);" style="width:175px; top:954px; left:556px;"/>
<input type="checkbox" name="uos61" value="1" style="top:1010px; left:65px;"/>
<input type="checkbox" name="uos64" value="1" style="top:1010px; left:441px;"/>
<input type="checkbox" name="kos61" value="1" style="top:1058px; left:65px;"/>
<input type="checkbox" name="kos64" value="1" style="top:1058px; left:441px;"/>
<!-- Tabulka1a -->
<input type="text" name="t1az1" id="t1az1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1173px; left:410px;"/>
<input type="text" name="t1ak1" id="t1ak1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1173px; left:660px;"/>
<input type="text" name="t1az2" id="t1az2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1212px; left:410px;"/>
<input type="text" name="t1ak2" id="t1ak2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1212px; left:660px;"/>
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<img src="<?php echo $jpg_source; ?>_str4.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- VI.ODDIEL pokracovanie -->
<!-- Tabulka1a pokracovanie -->
<input type="text" name="t1az3" id="t1az3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:114px; left:410px;"/>
<input type="text" name="t1ak3" id="t1ak3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:114px; left:660px;"/>
<input type="text" name="t1az4" id="t1az4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:154px; left:410px;"/>
<input type="text" name="t1ak4" id="t1ak4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:154px; left:660px;"/>
<input type="text" name="t1az5" id="t1az5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:193px; left:410px;"/>
<input type="text" name="t1ak5" id="t1ak5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:193px; left:660px;"/>
<!-- Tabulka1b -->
<input type="text" name="t1bz1" id="t1bz1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:298px; left:410px;"/>
<input type="text" name="t1bk1" id="t1bk1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:298px; left:660px;"/>
<input type="text" name="t1bz2" id="t1bz2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:339px; left:410px;"/>
<input type="text" name="t1bk2" id="t1bk2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:339px; left:660px;"/>
<div class="input-echo right" style="width:242px; top:734px; left:501px;"><?php echo $r37; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:734px; left:780px;">
<div class="input-echo right" style="width:242px; top:772px; left:501px;"><?php echo $r38; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:773px; left:780px;">
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:811px; left:500px;"/>
 <input type="text" name="r39pu" id="r39pu" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:811px; left:762px;"/>
 <img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:812px; left:913px;"
      title="Ak FO vedie podvojnÈ ˙ËtovnÌctvo vyplnÌ ZISK v tejto poloûke, nie v riadku 37,38,39,40 a tabuæku Ë. 1 v VI. oddiele na strane 3. nevypÂÚa.">
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:850px; left:500px;"/>
<input type="text" name="r40pu" id="r40pu" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:850px; left:762px;"/>
 <img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:852px; left:913px;"
      title="Ak FO vedie podvojnÈ ˙ËtovnÌctvo vyplnÌ STRATU v tejto poloûke, nie v riadku 37,38,39,40 a tabuæku Ë. 1 v VI. oddiele na strane 3. nevypÂÚa.">
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:896px; left:500px;"/>
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:942px; left:500px;"/>
<div class="input-echo right" style="width:242px; top:988px; left:501px;"><?php echo $r43; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:988px; left:780px;">
<div class="input-echo right" style="width:242px; top:1033px; left:501px;"><?php echo $r44; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1034px; left:780px;">
<!-- prehlad straty -->
<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1100px; left:507px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1140px; left:507px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1180px; left:507px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1220px; left:507px;"/>
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<img src="<?php echo $jpg_source; ?>_str5.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- VI.ODDIEL pokracovanie -->
<!-- prehlad straty pokracovanie -->
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:115px; left:507px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:155px; left:507px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:196px; left:507px;"/>
<input type="text" name="r52" id="r52" maxlength="4" style="width:80px; top:235px; left:381px;"/>
<div class="input-echo right" style="width:242px; top:277px; left:510px;"><?php echo $r53; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:277px; left:780px;">
<div class="input-echo right" style="width:242px; top:318px; left:510px;"><?php echo $r54; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:318px; left:780px;">
<div class="input-echo right" style="width:242px; top:393px; left:510px;"><?php echo $r55; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:394px; left:780px;">
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:466px; left:506px;"/>
<div class="input-echo right" style="width:242px; top:513px; left:510px;"><?php echo $r57; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:514px; left:780px;">
<div class="input-echo right" style="width:242px; top:565px; left:510px;"><?php echo $r58; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:566px; left:780px;">
<div class="input-echo right" style="width:242px; top:604px; left:510px;"><?php echo $r59; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:605px; left:780px;">
<div class="input-echo right" style="width:242px; top:643px; left:510px;"><?php echo $r60; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:643px; left:780px;">
<input type="text" name="r61" id="r61" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:681px; left:506px;"/>
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:721px; left:506px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:769px; left:506px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:814px; left:506px;"/>
<div class="input-echo right" style="width:242px; top:877px; left:510px;"><?php echo $r65; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:878px; left:780px;">
<!-- VII.ODDIEL -->
<!-- Tabulka2 -->
<input type="text" name="t2p1" id="t2p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1215px; left:410px;"/>
<input type="text" name="t2v1" id="t2v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:1215px; left:660px;"/>
<?php                     } ?>


<?php if ( $strana == 6 ) { ?>
<img src="<?php echo $jpg_source; ?>_str6.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- VII.ODDIEL pokracovanie -->
<!-- Tabulka2 -->
<input type="text" name="t2p2" id="t2p2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:134px; left:410px;"/>
<input type="text" name="t2v2" id="t2v2" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:134px; left:660px;"/>
<input type="text" name="t2p3" id="t2p3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:206px; left:410px;"/>
<input type="text" name="t2v3" id="t2v3" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:206px; left:660px;"/>
<input type="text" name="t2p4" id="t2p4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:257px; left:410px;"/>
<input type="text" name="t2v4" id="t2v4" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:257px; left:660px;"/>
<input type="text" name="t2p5" id="t2p5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:306px; left:410px;"/>
<input type="text" name="t2v5" id="t2v5" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:306px; left:660px;"/>
<input type="text" name="t2p6" id="t2p6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:357px; left:410px;"/>
<input type="text" name="t2v6" id="t2v6" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:357px; left:660px;"/>
<input type="text" name="t2p7" id="t2p7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:395px; left:410px;"/>
<input type="text" name="t2v7" id="t2v7" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:395px; left:660px;"/>
<input type="text" name="t2p8" id="t2p8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:435px; left:410px;"/>
<input type="text" name="t2v8" id="t2v8" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:435px; left:660px;"/>
<input type="text" name="t2p9" id="t2p9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:485px; left:410px;"/>
<input type="text" name="t2v9" id="t2v9" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:485px; left:660px;"/>
<input type="text" name="t2p10" id="t2p10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:534px; left:410px;"/>
<input type="text" name="t2v10" id="t2v10" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:534px; left:660px;"/>
<div class="input-echo right" style="width:230px; top:579px; left:410px;"><?php echo $t2p11; ?>&nbsp;</div>
<div class="input-echo right" style="width:230px; top:579px; left:660px;"><?php echo $t2v11; ?>&nbsp;</div>
<input type="text" name="t2p12" id="t2p12" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:629px; left:410px;"/>
<div class="input-echo right" style="width:242px; top:898px; left:484px;"><?php echo $r66; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:898px; left:780px;">
<div class="input-echo right" style="width:242px; top:936px; left:484px;"><?php echo $r67; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:936px; left:780px;">
<div class="input-echo right" style="width:242px; top:975px; left:484px;"><?php echo $r68; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:977px; left:780px;">
<!-- VIII.ODDIEL -->
<!-- Tabulka3 -->
<input type="text" name="t3p1" id="t3p1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1130px; left:411px;"/>
<input type="text" name="t3v1" id="t3v1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1130px; left:661px;"/>
<input type="text" name="t3p2" id="t3p2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1180px; left:411px;"/>
<input type="text" name="t3v2" id="t3v2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1180px; left:661px;"/>
<input type="text" name="t3p3" id="t3p3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1218px; left:411px;"/>
<input type="text" name="t3v3" id="t3v3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1218px; left:661px;"/>
<?php                     } ?>


<?php if ( $strana == 7 ) { ?>
<img src="<?php echo $jpg_source; ?>_str7.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- VIII.ODDIEL pokracovanie -->
<!-- Tabulka3 pokracovanie -->
<input type="text" name="t3p4" id="t3p4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:113px; left:411px;"/>
<input type="text" name="t3v4" id="t3v4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:113px; left:661px;"/>
<input type="text" name="t3p5" id="t3p5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:153px; left:411px;"/>
<input type="text" name="t3v5" id="t3v5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:153px; left:661px;"/>
<input type="text" name="t3p6" id="t3p6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:196px; left:411px;"/>
<input type="text" name="t3v6" id="t3v6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:196px; left:661px;"/>
<input type="text" name="t3p7" id="t3p7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:245px; left:411px;"/>
<input type="text" name="t3v7" id="t3v7" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:245px; left:661px;"/>
<input type="text" name="t3p8" id="t3p8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:290px; left:411px;"/>
<input type="text" name="t3v8" id="t3v8" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:290px; left:661px;"/>
<input type="text" name="t3p9" id="t3p9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:328px; left:411px;"/>
<input type="text" name="t3v9" id="t3v9" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:328px; left:661px;"/>
<input type="text" name="t3p10" id="t3p10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:368px; left:411px;"/>
<input type="text" name="t3v10" id="t3v10" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:368px; left:661px;"/>
<input type="text" name="t3p11" id="t3p11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:407px; left:411px;"/>
<input type="text" name="t3v11" id="t3v11" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:407px; left:661px;"/>
<input type="text" name="t3p12" id="t3p12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:450px; left:411px;"/>
<input type="text" name="t3v12" id="t3v12" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:450px; left:661px;"/>
<input type="text" name="t3p13" id="t3p13" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:494px; left:411px;"/>
<input type="text" name="t3v13" id="t3v13" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:494px; left:661px;"/>
<input type="text" name="t3p14" id="t3p14" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:538px; left:411px;"/>
<input type="text" name="t3v14" id="t3v14" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:538px; left:661px;"/>
<input type="text" name="t3p15" id="t3p15" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:582px; left:411px;"/>
<input type="text" name="t3v15" id="t3v15" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:582px; left:661px;"/>
<input type="text" name="t3p16" id="t3p16" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:626px; left:411px;"/>
<div class="input-echo right" style="width:230px; top:672px; left:413px;"><?php echo $t3p17; ?>&nbsp;</div>
<div class="input-echo right" style="width:230px; top:672px; left:662px;"><?php echo $t3v17; ?>&nbsp;</div>
<div class="input-echo right" style="width:242px; top:1085px; left:443px;"><?php echo $r69; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1085px; left:730px;">
<div class="input-echo right" style="width:242px; top:1125px; left:443px;"><?php echo $r70; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1125px; left:730px;">
<div class="input-echo right" style="width:242px; top:1165px; left:443px;"><?php echo $r71; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1165px; left:730px;">
<?php                     } ?>


<?php if ( $strana == 8 ) { ?>
<img src="<?php echo $jpg_source; ?>_str8.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- IX.ODDIEL -->
<div class="input-echo right" style="width:242px; top:152px; left:489px;"><?php echo $r72; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:153px; left:770px;">
<input type="text" name="r73" id="r73" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:195px; left:580px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocetOP();" title="VypoËÌtaù odpoËÌtateæn˙ poloûku na daÚovnÌka" class="btn-row-tool" style="top:196px; left:750px;">
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:234px; left:580px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="namanzelku();" title="VypoËÌtaù odpoËÌtateæn˙ poloûku na manûelku" class="btn-row-tool" style="top:235px; left:750px;">
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:272px; left:556px;"/>
<div class="input-echo right" style="width:242px; top:352px; left:489px;"><?php echo $r77; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:352px; left:770px;">
<div class="input-echo right" style="width:242px; top:391px; left:489px;"><?php echo $r78; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:391px; left:770px;">
<input type="text" name="r79" id="r79" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:428px; left:488px;"/>
<div class="input-echo right" style="width:242px; top:469px; left:489px;"><?php echo $r80; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:469px; left:770px;">
<input type="text" name="r81" id="r81" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:506px; left:488px;"/>
<input type="text" name="r82" id="r82" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:552px; left:470px;"/>
<div class="input-echo right" style="width:242px; top:607px; left:489px;"><?php echo $r83; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:607px; left:770px;">
<input type="text" name="r84" id="r84" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:660px; left:488px;"/>
<input type="text" name="r85" id="r85" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:706px; left:488px;"/>
<input type="text" name="r86" id="r86" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:756px; left:489px;"/>
<input type="text" name="r87" id="r87" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:810px; left:489px;"/>
<input type="text" name="r88" id="r88" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:857px; left:489px;"/>
<input type="text" name="r89" id="r89" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:899px; left:489px;"/>
<div class="input-echo right" style="width:242px; top:944px; left:489px;"><?php echo $r90; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:944px; left:770px;">
<div class="input-echo right" style="width:242px; top:988px; left:489px;"><?php echo $r91; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:989px; left:770px;">
<input type="text" name="r92" id="r92" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:1027px; left:470px;"/>
<div class="input-echo right" style="width:242px; top:1077px; left:489px;"><?php echo $r93; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1078px; left:770px;">
<input type="text" name="r94" id="r94" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1131px; left:489px;"/>

<?php                     } ?>


<?php if ( $strana == 9 ) { ?>
<img src="<?php echo $jpg_source; ?>_str9.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- IX.ODDIEL pokracovanie -->
<input type="text" name="r95" id="r95" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:117px; left:500px;"/>

<input type="text" name="r96" id="r96" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:169px; left:500px;"/>
<input type="text" name="r97" id="r97" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:219px; left:500px;"/>
<input type="text" name="r98" id="r98" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:261px; left:500px;"/>
<input type="text" name="r99" id="r99" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:303px; left:500px;"/>
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:348px; left:500px;"/>

<input type="text" name="r101" id="r101" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:402px; left:500px;"/>
<input type="text" name="r102" id="r102" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:460px; left:500px;"/>
<input type="text" name="r103" id="r103" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:522px; left:500px;"/>

<input type="text" name="r104" id="r104" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:581px; left:500px;"/>

<div class="input-echo right" style="width:242px; top:640px; left:500px;"><?php echo $r105; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:640px; left:770px;">
<input type="text" name="r106" id="r106" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:692px; left:592px;"/>
<div class="input-echo right" style="width:242px; top:732px; left:500px;"><?php echo $r107; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:732px; left:770px;">
<input type="text" name="r108" id="r108" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:770px; left:592px;"/>
<div class="input-echo right" style="width:242px; top:812px; left:500px;"><?php echo $r109; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:812px; left:770px;">
<div class="input-echo right" style="width:242px; top:853px; left:500px;"><?php echo $r110; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:853px; left:770px;">
<div class="input-echo right" style="width:242px; top:892px; left:500px;"><?php echo $r111; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:892px; left:770px;">
<input type="text" name="r112" id="r112" onkeyup="CiarkaNaBodku(this);" style="width:130px; top:931px; left:614px;"/>
<input type="text" name="r113" id="r113" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:971px; left:500px;"/>
<input type="text" name="r114" id="r114" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1017px; left:500px;"/>
<input type="text" name="r115" id="r115" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1062px; left:500px;"/>
<input type="text" name="r116" id="r116" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1101px; left:500px;"/>
<input type="text" name="r117" id="r117" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1141px; left:500px;"/>
<input type="text" name="r118" id="r118" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1181px; left:500px;"/>
<div class="input-echo right" style="width:242px; top:1222px; left:500px;"><?php echo $r119; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1222px; left:770px;">
<?php                     } ?>


<?php if ( $strana == 10 ) { ?>
<img src="<?php echo $jpg_source; ?>_str10.jpg" alt="<?php echo $jpg_title ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- IX.ODDIEL pokracovanie -->
<div class="input-echo right" style="width:242px; top:123px; left:500px;"><?php echo $r120; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:123px; left:770px;">
<div class="input-echo right" style="width:242px; top:177px; left:500px;"><?php echo $r121; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:177px; left:770px;">
<!-- X.ODDIEL -->
<input type="text" name="r122" id="r122" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:724px; left:648px;"/>
<input type="text" name="r123" id="r123" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:767px; left:628px;"/>
<input type="text" name="r124" id="r124" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:809px; left:628px;"/>
<input type="text" name="r125" id="r125" onkeyup="CiarkaNaBodku(this);" style="width:264px; top:866px; left:628px;"/>
<input type="text" name="r126" id="r126" onkeyup="CiarkaNaBodku(this);" style="width:153px; top:922px; left:739px;"/>
<input type="text" name="r127" id="r127" onkeyup="CiarkaNaBodku(this);" style="width:172px; top:966px; left:720px;"/>
<!-- XI.ODDIEL -->
<input type="text" name="sdnr" id="sdnr" style="width:842px; top:1089px; left:51px;"/>
<input type="text" name="r129" id="r129" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1129px; left:648px;"/>
<input type="text" name="r130" id="r130" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1168px; left:648px;"/>
<?php                      } ?>


<?php if ( $strana == 11 ) { ?>
<img src="<?php echo $jpg_source; ?>_str11.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- XI.ODDIEL pokracovanie -->
<input type="text" name="r131" id="r131" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:116px; left:648px;"/>
<input type="checkbox" name="ldnr" value="1" style="top:160px; left:413px;"/>
<input type="text" name="nrzsprev" id="nrzsprev" maxlength="2" style="width:37px; top:156px; left:855px;"/>
<!-- XII.ODDIEL -->
<input type="checkbox" name="upl50" value="1" onchange="KlikNeuplAno();" style="top:313px; left:59px;"/>
<input type="checkbox" name="spl3d" value="1" onchange="KlikNeuplNie();" style="top:313px; left:295px;"/>
<input type="text" name="r134" id="r134" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:355px; left:316px;"/>
<!-- Prijimatel -->
<input type="text" name="pico" id="pico" maxlength="8" style="width:175px; top:440px; left:51px;"/>
<input type="text" name="psid" id="psid" maxlength="4" style="width:83px; top:440px; left:258px;"/>
<input type="text" name="pfor" id="pfor" style="width:520px; top:440px; left:373px;"/>
<input type="text" name="pmen" id="pmen" style="width:842px; height:62px; top:494px; left:51px;"/>
<input type="text" name="puli" id="puli" style="width:635px; top:603px; left:51px;"/>
<input type="text" name="pcdm" id="pcdm" style="width:175px; top:603px; left:718px;"/>
<input type="text" name="ppsc" id="ppsc" maxlength="5" style="width:106px; top:657px; left:51px;"/>
<input type="text" name="pmes" id="pmes" style="width:703px; top:657px; left:190px;"/>
<input type="checkbox" name="zslu" value="1" style="top:700px; left:59px;"/>
<!-- XIII.ODDIEL -->
<input type="checkbox" name="uoso" value="1" style="top:834px; left:59px; z-index:100;"/>
<div style="z-index:10; position:absolute; top:832px; left:58px; background-color:#39f; width:22px; height:22px; border-radius:3px;">&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="ätatistick˝ ËÌselnÌk krajÌn" onclick="CisKrajin();" class="btn-row-tool" style="top:870px; left:7px;">
<input type="text" name="pzks1" id="pzks1" maxlength="3" style="width:59px; top:944px; left:51px;"/>
<input type="text" name="pdrp1" id="pdrp1" style="width:14px; top:944px; left:131px;"/>
<input type="text" name="pdro1" id="pdro1" style="width:14px; top:944px; left:164px;"/>
<input type="text" name="pdrm1" id="pdrm1" style="width:14px; top:944px; left:200px;"/>
<input type="text" name="pzpr1" id="pzpr1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:944px; left:234px;"/>
<input type="text" name="pzvd1" id="pzvd1" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:944px; left:483px;"/>
<input type="text" name="pzthvd1" id="pzthvd1" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:944px; left:731px;"/>
<input type="text" name="pzks2" id="pzks2" maxlength="3" style="width:59px; top:984px; left:51px;"/>
<input type="text" name="pdrp2" id="pdrp2" style="width:14px; top:984px; left:131px;"/>
<input type="text" name="pdro2" id="pdro2" style="width:14px; top:984px; left:164px;"/>
<input type="text" name="pdrm2" id="pdrm2" style="width:14px; top:984px; left:200px;"/>
<input type="text" name="pzpr2" id="pzpr2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:984px; left:234px;"/>
<input type="text" name="pzvd2" id="pzvd2" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:984px; left:483px;"/>
<input type="text" name="pzthvd2" id="pzthvd2" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:984px; left:731px;"/>
<input type="text" name="pzks3" id="pzks3" maxlength="3" style="width:59px; top:1024px; left:51px;"/>
<input type="text" name="pdrp3" id="pdrp3" style="width:14px; top:1024px; left:131px;"/>
<input type="text" name="pdro3" id="pdro3" style="width:14px; top:1024px; left:164px;"/>
<input type="text" name="pdrm3" id="pdrm3" style="width:14px; top:1024px; left:200px;"/>
<input type="text" name="pzpr3" id="pzpr3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1024px; left:234px;"/>
<input type="text" name="pzvd3" id="pzvd3" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1024px; left:483px;"/>
<input type="text" name="pzthvd3" id="pzthvd3" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:1024px; left:731px;"/>
<input type="text" name="pzks4" id="pzks4" maxlength="3" style="width:59px; top:1064px; left:51px;"/>
<input type="text" name="pdrp4" id="pdrp4" style="width:14px; top:1064px; left:131px;"/>
<input type="text" name="pdro4" id="pdro4" style="width:14px; top:1064px; left:164px;"/>
<input type="text" name="pdrm4" id="pdrm4" style="width:14px; top:1064px; left:200px;"/>
<input type="text" name="pzpr4" id="pzpr4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1064px; left:234px;"/>
<input type="text" name="pzvd4" id="pzvd4" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1064px; left:483px;"/>
<input type="text" name="pzthvd4" id="pzthvd4" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:1064px; left:731px;"/>
<input type="text" name="pzks5" id="pzks5" maxlength="3" style="width:59px; top:1104px; left:51px;"/>
<input type="text" name="pdrp5" id="pdrp5" style="width:14px; top:1104px; left:131px;"/>
<input type="text" name="pdro5" id="pdro5" style="width:14px; top:1104px; left:164px;"/>
<input type="text" name="pdrm5" id="pdrm5" style="width:14px; top:1104px; left:200px;"/>
<input type="text" name="pzpr5" id="pzpr5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1104px; left:234px;"/>
<input type="text" name="pzvd5" id="pzvd5" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1104px; left:483px;"/>
<input type="text" name="pzthvd5" id="pzthvd5" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:1104px; left:731px;"/>
<input type="text" name="pzks6" id="pzks6" maxlength="3" style="width:59px; top:1144px; left:51px;"/>
<input type="text" name="pdrp6" id="pdrp6" style="width:14px; top:1144px; left:131px;"/>
<input type="text" name="pdro6" id="pdro6" style="width:14px; top:1144px; left:164px;"/>
<input type="text" name="pdrm6" id="pdrm6" style="width:14px; top:1144px; left:200px;"/>
<input type="text" name="pzpr6" id="pzpr6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1144px; left:234px;"/>
<input type="text" name="pzvd6" id="pzvd6" onkeyup="CiarkaNaBodku(this);" style="width:232px; top:1144px; left:483px;"/>
<input type="text" name="pzthvd6" id="pzthvd6" onkeyup="CiarkaNaBodku(this);" style="width:163px; top:1144px; left:731px;"/>
<script>
  function KlikNeuplAno()
  {
   document.formv1.spl3d.checked = false;
  }
  function KlikNeuplNie()
  {
   document.formv1.upl50.checked = false;
  }
</script>
<?php                      } ?>


<?php if ( $strana == 12 ) { ?>
<img src="<?php echo $jpg_source; ?>_str12.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>

<!-- XIII.ODDIEL pokracovanie -->
<textarea name="osob" id="osob" style="width:838px; height:606px; top:213px; left:53px;"><?php echo $osob; ?></textarea>
<input type="text" name="pril" id="pril" maxlength="2" style="width:37px; top:858px; left:184px;" title="Minim·lny poËet prÌloh je 2, vr·tane PrÌlohy Ë.1 V˝zkum a v˝voj a PrÌlohy Ë.2 ⁄daje SP a ZP"/>
<input type="text" name="dat" id="dat" onclick="dajDnes();" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:195px; top:930px; left:277px;"/>

<!-- XIV.ODDIEL -->
<input type="checkbox" name="zdbo" value="1" style="top:1013px; left:59px;"/>
<input type="checkbox" name="zpre" value="1" style="top:1042px; left:59px;"/>
<input type="checkbox" name="post" value="1" onchange="klikpost();" style="top:1085px; left:116px;"/>
<input type="checkbox" name="ucet" value="1" onchange="klikucet();" style="top:1085px; left:323px;"/>
<input type="text" name="diban" id="diban" style="width:773px; top:1119px; left:116px;"/>
<input type="text" name="da2" id="da2" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:1206px; left:116px;"/>

<script>
  function klikpost()
  {
   document.formv1.ucet.checked = false;
  }
  function klikucet()
  {
   document.formv1.post.checked = false;
  }
</script>
<?php                      } ?>

<?php if ( $strana == 13 ) { ?>
<img src="<?php echo $jpg_source; ?>_str13.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- PRILOHA 1 -->
<div class="input-echo right" style="top:167px; left:269px; width:36px;"><?php echo $prpcp; ?>&nbsp;</div>
<div class="input-echo right" style="top:167px; left:338px; width:36px;"><?php echo $prppp; ?>&nbsp;</div>
<input type="text" name="prpdzc" id="prpdzc" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:166px; left:697px;"/>
<input type="text" name="prpzo1" id="prpzo1" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:254px; left:72px;"/>
<input type="text" name="prpzd1" id="prpzd1" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:293px; left:72px;"/>
<input type="text" name="prpvz1" id="prpvz1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:293px;"/>
<input type="text" name="prpod1" id="prpod1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:604px;"/>
<input type="text" name="prpzo2" id="prpzo2" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:333px; left:72px;"/>
<input type="text" name="prpzd2" id="prpzd2" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:370px; left:72px;"/>
<input type="text" name="prpvz2" id="prpvz2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:293px;"/>
<input type="text" name="prpod2" id="prpod2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:604px;"/>
<input type="text" name="prpzo3" id="prpzo3" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:410px; left:72px;"/>
<input type="text" name="prpzd3" id="prpzd3" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:448px; left:72px;"/>
<input type="text" name="prpvz3" id="prpvz3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:293px;"/>
<input type="text" name="prpod3" id="prpod3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:604px;"/>
<input type="text" name="prpzo4" id="prpzo4" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:488px; left:72px;"/>
<input type="text" name="prpzd4" id="prpzd4" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:526px; left:72px;"/>
<input type="text" name="prpvz4" id="prpvz4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:293px;"/>
<input type="text" name="prpod4" id="prpod4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:604px;"/>
<input type="text" name="prpzo5" id="prpzo5" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:566px; left:72px;"/>
<input type="text" name="prpzd5" id="prpzd5" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:604px; left:72px;"/>
<input type="text" name="prpvz5" id="prpvz5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:293px;"/>
<input type="text" name="prpod5" id="prpod5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:604px;"/>
<div class="input-echo right" style="width:290px; top:644px; left:604px;"><?php echo $prpods; ?>&nbsp;</div>
<textarea name="prptxt" id="prptxt" style="width:838px; height:400px; top:700px; left:53px;"><?php echo $prptxt; ?></textarea>
<div class="input-echo right" style="width:290px; top:1150px; left:604px;"><?php echo $prpodv; ?>&nbsp;</div>
<?php                      } ?>


<?php if ( $strana == 14 ) { ?>
<img src="<?php echo $jpg_source; ?>_str14.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- PRILOHA 2 -->
<input type="text" name="ozd1r01" id="ozd1r01" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:351px; left:410px;"/>
<input type="text" name="ozd1r02" id="ozd1r02" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:390px; left:410px;"/>
<input type="text" name="ozd1r03" id="ozd1r03" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:429px; left:410px;"/>
<input type="text" name="ozd1r04" id="ozd1r04" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:468px; left:410px;"/>
<input type="text" name="ozd2r04" id="ozd2r04" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:468px; left:661px;"/>
<input type="text" name="ozd1r05" id="ozd1r05" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:507px; left:410px;"/>
<input type="text" name="ozd2r05" id="ozd2r05" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:507px; left:661px;"/>
<div class="input-echo right" style="width:234px; top:546px; left:410px;"><?php echo $ozd1r06; ?>&nbsp;</div>
<div class="input-echo right" style="width:234px; top:546px; left:661px;"><?php echo $ozd2r06; ?>&nbsp;</div>

<input type="text" name="ozdr07" id="ozdr07" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:699px; left:557px;"/>

<input type="text" name="ozdr09" id="ozdr09" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:782px; left:557px;"/>
<input type="text" name="ozdr10" id="ozdr10" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:870px; left:557px;"/>
<input type="text" name="ozdr11" id="ozdr11" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:909px; left:560px;"/>
<input type="text" name="ozdr12" id="ozdr12" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:954px; left:560px;"/>

<input type="text" name="ozdr13" id="ozdr13" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1042px; left:557px;"/>
<input type="text" name="ozdr14" id="ozdr14" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1086px; left:557px;"/>

<input type="text" name="ozdr15" id="ozdr15" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1131px; left:560px;"/>
<input type="text" name="ozdr16" id="ozdr16" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1171px; left:560px;"/>
<input type="text" name="ozdr17" id="ozdr17" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:1210px; left:560px;"/>

<?php                      } ?>


<?php if ( $strana == 15 ) { ?>
<img src="<?php echo $jpg_source; ?>_str15.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- PRILOHA 2 pokracovanie -->
<input type="text" name="ozdr18" id="ozdr18" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:120px; left:557px;"/>
<input type="text" name="ozd1r19" id="ozd1r19" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:268px; left:410px;"/>
<input type="text" name="ozd1r20" id="ozd1r20" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:307px; left:410px;"/>
<input type="text" name="ozd1r21" id="ozd1r21" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:345px; left:410px;"/>
<input type="text" name="ozd1r22" id="ozd1r22" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:384px; left:410px;"/>
<input type="text" name="ozd2r22" id="ozd2r22" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:384px; left:661px;"/>
<input type="text" name="ozd1r23" id="ozd1r23" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:423px; left:410px;"/>
<input type="text" name="ozd2r23" id="ozd2r23" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:423px; left:661px;"/>
<div class="input-echo right" style="width:234px; top:463px; left:410px;"><?php echo $ozd1r24; ?>&nbsp;</div>
<div class="input-echo right" style="width:234px; top:463px; left:661px;"><?php echo $ozd2r24; ?>&nbsp;</div>

<input type="text" name="ozdr25" id="ozdr25" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:561px; left:560px;"/>
<input type="text" name="ozdr27" id="ozdr27" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:645px; left:560px;"/>
<input type="text" name="ozdr28" id="ozdr28" onkeyup="CiarkaNaBodku(this);" style="width:242px; top:705px; left:560px;"/>

<?php                      } ?>


<?php if ( $strana == 16 ) { ?>
<img src="<?php echo $jpg_source; ?>_str16.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- PRILOHA 3 -->
<input type="text" name="sz1p1" id="sz1p1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:211px; left:410px;"/>
<input type="text" name="sz1v1" id="sz1v1" onkeyup="CiarkaNaBodku(this);" style="width:233px; top:211px; left:660px;"/>
<input type="text" name="sz2" id="sz2" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:275px; left:517px;"/>
<input type="text" name="sz3" id="sz3" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:324px; left:517px;"/>
<input type="text" name="sz4" id="sz4" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:368px; left:517px;"/>
<input type="text" name="sz5" id="sz5" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:414px; left:517px;"/>
<div class="input-echo right" style="width:242px; top:469px; left:518px;"><?php echo $sz6; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:469px; left:830px;">
<div class="input-echo right" style="width:242px; top:532px; left:518px;"><?php echo $sz7; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:532px; left:830px;">
<input type="text" name="sz8" id="sz8" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:679px; left:532px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="NacitajSz9();" title="NaËÌtaù zaplatenÈ poistnÈ z riadka Ë. 35 na 2. strane" class="btn-row-tool" style="top:680px; left:750px;">
<input type="text" name="sz9" id="sz9" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:719px; left:532px;"/>
<input type="text" name="sz10" id="sz10" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:758px; left:532px;"/>
<input type="text" name="sz11" id="sz11" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:797px; left:532px;"/>
<input type="text" name="sz12" id="sz12" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:838px; left:532px;"/>
<input type="text" name="sz13" id="sz13" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:878px; left:532px;"/>
<input type="text" name="sz14" id="sz14" onkeyup="CiarkaNaBodku(this);" style="width:177px; top:921px; left:532px;"/>
<input type="checkbox" name="vpdu" value="1" style="top:1019px; left:60px;"/>
<input type="text" name="sz15" id="sz15" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1051px; left:517px;"/>
<input type="text" name="szdat" id="szdat" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:1122px; left:116px;"/>
<?php                      } ?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
  <a href="#" onclick="editForm(6);" class="<?php echo $clas6; ?> toleft">6</a>
  <a href="#" onclick="editForm(7);" class="<?php echo $clas7; ?> toleft">7</a>
  <a href="#" onclick="editForm(8);" class="<?php echo $clas8; ?> toleft">8</a>
  <a href="#" onclick="editForm(9);" class="<?php echo $clas9; ?> toleft">9</a>
  <a href="#" onclick="editForm(10);" class="<?php echo $clas10; ?> toleft">10</a>
  <a href="#" onclick="editForm(11);" class="<?php echo $clas11; ?> toleft">11</a>
  <a href="#" onclick="editForm(12);" class="<?php echo $clas12; ?> toleft">12</a>
  <a href="#" onclick="editForm(13);" class="<?php echo $clas13; ?> toleft">P1</a>
  <a href="#" onclick="editForm(14);" class="<?php echo $clas14; ?> toleft">P2</a>
  <a href="#" onclick="editForm(15);" class="<?php echo $clas15; ?> toleft">P2</a>
  <a href="#" onclick="editForm(16);" class="<?php echo $clas16; ?> toleft">P3</a>
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</form>

<?php
//mysql_free_result($vysledok);
    }
//$copern==20
?>
<?php
//xml
if ( $copern == 10 )
     {

$zablokovane=0;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Export do XML DaÚovÈho priznania FOB 2017 bude pripraven˝ hneÔ po zverejnenÌ novÈho formul·ra na port·le DRSR. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

$hhmm = Date( "Hi", MkTime( date("H"),date("i"),date("s"),date("m"),date("d"),date("Y") ) );
//$idx=$kli_uzid.$hhmm;
$kli_nxcf10 = substr($kli_nxcf,0,10);
$kli_nxcf10=trim(str_replace(" ","",$kli_nxcf10));

$nazsub="../tmp/dpfob".$kli_vrok."_id".$kli_uzid."_".$kli_nxcf."_".$hhmm.".xml";

//prva strana

$outfilexdel="../tmp/dpfob".$kli_vrok."_id".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex=$nazsub;
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     $soubor = fopen("$nazsub", "a+");



//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);
  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$datumNarodenia=SkDatum($hlavicka->dar);
if ( $datumNarodenia == '00.00.0000' ) $datumNarodenia="";
  $text = "  <datumNarodenia><![CDATA[".$datumNarodenia."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$datumDDP=SkDatum($hlavicka->ddp);
if ( $datumDDP == '00.00.0000' ) $datumDDP="";
  $text = "   <datumDDP><![CDATA[".$datumDDP."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$fir_sknace=trim($fir_sknace);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
$cinnost=iconv("CP1250", "UTF-8", $hlavicka->cinnost);
  $text = "   <cinnost><![CDATA[".$cinnost."]]></cinnost>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

$priezvisko=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$dcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$dpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $dstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);

$nerezident=$hlavicka->nrz;
  $text = "  <nerezident><![CDATA[".$nerezident."]]></nerezident>"."\r\n"; fwrite($soubor, $text);
$nerezident=$hlavicka->prp;
  $text = "  <prepojeniePar2><![CDATA[".$nerezident."]]></prepojeniePar2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->d2uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->d2cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->d2psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->d2mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->zprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->zmeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitl);
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $hlavicka->ztitz);
  $text = "   <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->zrdc.$hlavicka->zrdk;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->zcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->zpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->zstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$hlavicka->dtel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mail=iconv("CP1250", "UTF-8", $hlavicka->dmailfax);
  $text = "   <email><![CDATA[".$mail."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);


//telo
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r29;
  $text = "  <r29><![CDATA[".$riadok."]]></r29>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r30;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r30><![CDATA[".$riadok."]]></r30>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r31>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->mprie);
  $text = "   <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->mrod;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$vlastnePrijmy=$hlavicka->mpri;
if ( $hlavicka->mpri == 0 ) $vlastnePrijmy="";
  $text = "   <vlastnePrijmy><![CDATA[".$vlastnePrijmy."]]></vlastnePrijmy>"."\r\n"; fwrite($soubor, $text);
$pocetMesiacov=$hlavicka->mpom;
if ( $hlavicka->mpom == 0 ) $pocetMesiacov="";
  $text = "   <pocetMesiacov><![CDATA[".$pocetMesiacov."]]></pocetMesiacov>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r31>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r32>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d1prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d1rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d1pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d1pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d1pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d1pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d1pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d1pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d1pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d1pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d1pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d1pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d1pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d1pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d1pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d2prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d2rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d2pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d2pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d2pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d2pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d2pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d2pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d2pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d2pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d2pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d2pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d2pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d2pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d2pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d3rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d3pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d3pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d3pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d3pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d3pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d3pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d3pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d3pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d3pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d3pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d3pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d3pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d3pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d4prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d4rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d4pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d4pom1;
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d4pom2;
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d4pom3;
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d4pom4;
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d4pom5;
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d4pom6;
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d4pom7;
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d4pom8;
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d4pom9;
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d4pom10;
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d4pom11;
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d4pom12;
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r32>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33;
  $text = "  <r33viacAko4><![CDATA[".$riadok."]]></r33viacAko4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34><![CDATA[".$riadok."]]></r34>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34a><![CDATA[".$riadok."]]></r34a>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r35;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r35><![CDATA[".$riadok."]]></r35>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r36;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r36><![CDATA[".$riadok."]]></r36>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka1>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r13>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uppr1;
  $text = "  <vydavkyPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr3;
  $text = "  <vydavkyPar6ods11_ods3><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr4;
  $text = "  <vydavkyPar6ods11_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp61;
  $text = "  <vydavkyPar6ods10_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods1a2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp64;
  $text = "  <vydavkyPar6ods10_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->psp6;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPoistPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPoistPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uos61;
  $text = "  <uplatnujemPar17ods17_ods1a2><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uos64;
  $text = "  <uplatnujemPar17ods17_ods3a4><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->kos61;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods1a2><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->kos64;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods3a4><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka1a>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1a>"."\r\n"; fwrite($soubor, $text);

$text = "  <tabulka1b>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1b>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r37;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r37><![CDATA[".$riadok."]]></r37>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r38;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r38><![CDATA[".$riadok."]]></r38>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r39;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r39><![CDATA[".$riadok."]]></r39>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r40;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r40><![CDATA[".$riadok."]]></r40>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r41;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r41><![CDATA[".$riadok."]]></r41>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r42;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r42><![CDATA[".$riadok."]]></r42>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r43;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r43><![CDATA[".$riadok."]]></r43>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r44;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r44><![CDATA[".$riadok."]]></r44>"."\r\n"; fwrite($soubor, $text);

//zmena 2015
$riadok=$hlavicka->r45;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r45>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2010</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r45>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r46;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r46>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2011</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r46>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r47;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r47>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2012</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r47>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r48;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r48>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2013</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r48>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r49;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r49>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2014</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r49>"."\r\n"; fwrite($soubor, $text);
//koniec zmena 2015

//rok2016
$riadok=$hlavicka->r50;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r50>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2015</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r50>"."\r\n"; fwrite($soubor, $text);

//rok2017
$riadok=$hlavicka->r51;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r51>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok>2016</rok>"."\r\n"; fwrite($soubor, $text);
  $text = "    <strata><![CDATA[".$riadok."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r51>"."\r\n"; fwrite($soubor, $text);


$riadok=$hlavicka->r52;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r52><![CDATA[".$riadok."]]></r52>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r53;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r53><![CDATA[".$riadok."]]></r53>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r54;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r54><![CDATA[".$riadok."]]></r54>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r55;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r55><![CDATA[".$riadok."]]></r55>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r56;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r56><![CDATA[".$riadok."]]></r56>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r57;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r57><![CDATA[".$riadok."]]></r57>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r58;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r58><![CDATA[".$riadok."]]></r58>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r59;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r59><![CDATA[".$riadok."]]></r59>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r60;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r60><![CDATA[".$riadok."]]></r60>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r61;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r61><![CDATA[".$riadok."]]></r61>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r62;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r62><![CDATA[".$riadok."]]></r62>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r63;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r63><![CDATA[".$riadok."]]></r63>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r64;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r64><![CDATA[".$riadok."]]></r64>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r65;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r65><![CDATA[".$riadok."]]></r65>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka2>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t2r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p1;
if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r5>"."\r\n"; fwrite($soubor, $text);

  $text = "  <t2r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r12>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r66;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r66><![CDATA[".$riadok."]]></r66>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r67;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r67><![CDATA[".$riadok."]]></r67>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r68;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r68><![CDATA[".$riadok."]]></r68>"."\r\n"; fwrite($soubor, $text);


  $text = "  <tabulka3>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t3r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r10>"."\r\n";   fwrite($soubor, $text);

  $text = "   <t3r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);;
$riadok=$hlavicka->t3v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r13>"."\r\n"; fwrite($soubor, $text);

//zmena 2015
  $text = "   <t3r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r14>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v15;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r15>"."\r\n"; fwrite($soubor, $text);
//koniec zmena 2015

  $text = "   <t3r16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p16;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r16>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t3r17>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v17;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r17>"."\r\n"; fwrite($soubor, $text);

  $text = "  </tabulka3>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r69;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r69><![CDATA[".$riadok."]]></r69>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r70;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r70><![CDATA[".$riadok."]]></r70>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r71;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r71><![CDATA[".$riadok."]]></r71>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r72;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r72><![CDATA[".$riadok."]]></r72>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r73;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r73><![CDATA[".$riadok."]]></r73>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r74;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r74><![CDATA[".$riadok."]]></r74>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r75;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r75><![CDATA[".$riadok."]]></r75>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r76;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r76><![CDATA[".$riadok."]]></r76>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r77;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r77><![CDATA[".$riadok."]]></r77>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r78;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r78><![CDATA[".$riadok."]]></r78>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r79;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r79><![CDATA[".$riadok."]]></r79>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r80;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r80><![CDATA[".$riadok."]]></r80>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r81;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r81><![CDATA[".$riadok."]]></r81>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r82;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r82><![CDATA[".$riadok."]]></r82>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r83;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r83><![CDATA[".$riadok."]]></r83>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r84;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r84><![CDATA[".$riadok."]]></r84>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r85;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r85><![CDATA[".$riadok."]]></r85>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r86;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r86><![CDATA[".$riadok."]]></r86>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r87;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r87><![CDATA[".$riadok."]]></r87>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r88;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r88><![CDATA[".$riadok."]]></r88>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r89;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r89><![CDATA[".$riadok."]]></r89>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r90;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r90><![CDATA[".$riadok."]]></r90>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r91;
//if ( $riadok == 0 ) $riadok="";
  $text = "  <r91><![CDATA[".$riadok."]]></r91>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r92;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r92><![CDATA[".$riadok."]]></r92>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r93;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r93><![CDATA[".$riadok."]]></r93>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r94;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r94><![CDATA[".$riadok."]]></r94>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r95;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r95><![CDATA[".$riadok."]]></r95>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r96;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r96><![CDATA[".$riadok."]]></r96>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r97;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r97><![CDATA[".$riadok."]]></r97>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r98;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r98><![CDATA[".$riadok."]]></r98>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r99;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r99><![CDATA[".$riadok."]]></r99>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r100;
//if ( $riadok == 0 ) $riadok="";
  $text = "  <r100><![CDATA[".$riadok."]]></r100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r101;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r101><![CDATA[".$riadok."]]></r101>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r102;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r102><![CDATA[".$riadok."]]></r102>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r103;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r103><![CDATA[".$riadok."]]></r103>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r104;
//if ( $riadok == 0 ) $riadok="";
  $text = "  <r104><![CDATA[".$riadok."]]></r104>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r105;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r105><![CDATA[".$riadok."]]></r105>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r106;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r106><![CDATA[".$riadok."]]></r106>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r107;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r107><![CDATA[".$riadok."]]></r107>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r108;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r108><![CDATA[".$riadok."]]></r108>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r109;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r109><![CDATA[".$riadok."]]></r109>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r110><![CDATA[".$riadok."]]></r110>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r111;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r111><![CDATA[".$riadok."]]></r111>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r112;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r112><![CDATA[".$riadok."]]></r112>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r113;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r113><![CDATA[".$riadok."]]></r113>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r114;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r114><![CDATA[".$riadok."]]></r114>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r115;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r115><![CDATA[".$riadok."]]></r115>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r116;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r116><![CDATA[".$riadok."]]></r116>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r117;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r117><![CDATA[".$riadok."]]></r117>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r118;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r118><![CDATA[".$riadok."]]></r118>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r119;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r119><![CDATA[".$riadok."]]></r119>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r120;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r120><![CDATA[".$riadok."]]></r120>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r121;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r121><![CDATA[".$riadok."]]></r121>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r122;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r122><![CDATA[".$riadok."]]></r122>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r123;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r123><![CDATA[".$riadok."]]></r123>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r124;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r124><![CDATA[".$riadok."]]></r124>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r125;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r125><![CDATA[".$riadok."]]></r125>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r126;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r126><![CDATA[".$riadok."]]></r126>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r127;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r127><![CDATA[".$riadok."]]></r127>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r128;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r128><![CDATA[".$riadok."]]></r128>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r129;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r129><![CDATA[".$riadok."]]></r129>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r130;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r130><![CDATA[".$riadok."]]></r130>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r131;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r131><![CDATA[".$riadok."]]></r131>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r132;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r132><![CDATA[".$riadok."]]></r132>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r133;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r133><![CDATA[".$riadok."]]></r133>"."\r\n"; fwrite($soubor, $text);


$neuplatnujem=$hlavicka->upl50;
  $text = "  <neuplatnujem><![CDATA[".$neuplatnujem."]]></neuplatnujem>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->spl3d;
  $text = "  <splnam3per><![CDATA[".$riadok."]]></splnam3per>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r134;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r134><![CDATA[".$riadok."]]></r134>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r135>"."\r\n"; fwrite($soubor, $text);
$pico=$hlavicka->pico;
if ( $pico == 0 ) $pico="";
  $text = "   <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);

$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->pfor);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchMeno>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pmen);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n";   fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->puli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->pcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->ppsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->pmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
//new2015
$riadok=$hlavicka->zslu;
  $text = "    <suhlasZaslUdaje><![CDATA[".$riadok."]]></suhlasZaslUdaje>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r135>"."\r\n"; fwrite($soubor, $text);


  $text = "  <osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);
$uvadza=$hlavicka->uoso;
  $text = "   <uvadza><![CDATA[".$uvadza."]]></uvadza>"."\r\n"; fwrite($soubor, $text);
  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks1);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp1);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro1);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks2);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp2);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro2);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks3);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp3);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro3);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks4);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp4);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro4);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks5);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp5);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro5);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks6);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp6);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro6);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

$zaznamy=iconv("CP1250", "UTF-8", $hlavicka->osob);
  $text = "   <zaznamy><![CDATA[".$zaznamy."]]></zaznamy>"."\r\n"; fwrite($soubor, $text);
  $text = "  </osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pril;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r136><![CDATA[".$riadok."]]></r136>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->dat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "  <datumVyhlasenia><![CDATA[".$datum."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);
$vyplatbonus=$hlavicka->zdbo;
  $text = "   <vyplatitDanovyBonus><![CDATA[".$vyplatbonus."]]></vyplatitDanovyBonus>"."\r\n"; fwrite($soubor, $text);
$vratpreplatok=$hlavicka->zpre;
  $text = "   <vratitDanPreplatok><![CDATA[".$vratpreplatok."]]></vratitDanPreplatok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n";   fwrite($soubor, $text);
$poukazka=$hlavicka->post;
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->ucet;
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);
  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban=$hlavicka->diban;
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

$pole = explode("-", $hlavicka->uceb);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if ( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }
if ( $ucet == 0 ) $predcislieUctu="";
  //$text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);
if ( $ucet == 0 ) $cisloUctu="";
  //$text = "    <cisloUctu><![CDATA[".$cisloUctu."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky=$hlavicka->numb;
if ( $ucet == 0 ) $kodBanky="";
  //$text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->da2);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);


//priloha nova v roku 2017 <prilPodielyNaZisku> Andrejko pridaj sem
  $text = "  <prilPodielyNaZisku>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r01; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr1><![CDATA[".$riadok."]]></pr1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r02; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr2><![CDATA[".$riadok."]]></pr2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r03; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr3><![CDATA[".$riadok."]]></pr3>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r04; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr4>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r05; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr5>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r06; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr07; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr7><![CDATA[".$riadok."]]></pr7>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr8>7</pr8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr09; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr9><![CDATA[".$riadok."]]></pr9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr10; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr10><![CDATA[".$riadok."]]></pr10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr11; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr11><![CDATA[".$riadok."]]></pr11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr12; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr12><![CDATA[".$riadok."]]></pr12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr13; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr13><![CDATA[".$riadok."]]></pr13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr14; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr14><![CDATA[".$riadok."]]></pr14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr15; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr15><![CDATA[".$riadok."]]></pr15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr16; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr16><![CDATA[".$riadok."]]></pr16>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr17; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr17><![CDATA[".$riadok."]]></pr17>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->ozdr18; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr18><![CDATA[".$riadok."]]></pr18>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r19; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr19><![CDATA[".$riadok."]]></pr19>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r20; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr20><![CDATA[".$riadok."]]></pr20>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r21; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr21><![CDATA[".$riadok."]]></pr21>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr22>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r22; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r22; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr22>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr23>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r23; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r23; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr23>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr24>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd1r24; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozd2r24; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     	<s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "     </pr24>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr25; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr25><![CDATA[".$riadok."]]></pr25>"."\r\n"; fwrite($soubor, $text);
  $text = "     <pr26>35</pr26>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr27; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr27><![CDATA[".$riadok."]]></pr27>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ozdr28; if ( $riadok == 0 ) { $riadok=""; }
  $text = "     <pr28><![CDATA[".$riadok."]]></pr28>"."\r\n"; fwrite($soubor, $text);
  $text = "  </prilPodielyNaZisku>"."\r\n"; fwrite($soubor, $text);


//pridana priloha proj 2015
  $text = "  <prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);

$riadok=1;
if ( $hlavicka->prpods == 0 ) $riadok="0";
  $text = "    <projektCislo><![CDATA[".$riadok."]]></projektCislo>"."\r\n"; fwrite($soubor, $text);
$riadok=1;
if ( $hlavicka->prpods == 0 ) $riadok="0";
  $text = "    <pocetProjektov><![CDATA[".$riadok."]]></pocetProjektov>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpdzc);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <datumRealizacie><![CDATA[".$riadok."]]></datumRealizacie>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r01>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd1);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r01>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r02>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd2);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r02>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r03>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd3);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r03>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r04>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd4);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r04>"."\r\n"; fwrite($soubor, $text);

  $text = "   <r05>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzo5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieOd><![CDATA[".$riadok."]]></zdanObdobieOd>"."\r\n"; fwrite($soubor, $text);
$riadok=SkDatum($hlavicka->prpzd5);
if ( $riadok == '00.00.0000' ) $riadok="";
  $text = "    <zdanObdobieDo><![CDATA[".$riadok."]]></zdanObdobieDo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpvz5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <narok><![CDATA[".$riadok."]]></narok>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpod5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <odpocitanaCast><![CDATA[".$riadok."]]></odpocitanaCast>"."\r\n"; fwrite($soubor, $text);
  $text = "   </r05>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->prpods;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r06><![CDATA[".$riadok."]]></r06>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->prptxt);
  $text = "    <ciele><![CDATA[".$riadok."]]></ciele>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->prpodv;
if ( $riadok == 0 ) $riadok="";
  $text = "    <r07><![CDATA[".$riadok."]]></r07>"."\r\n"; fwrite($soubor, $text);

  $text = "  </prilPar30cOdpocetVydavkov>"."\r\n"; fwrite($soubor, $text);
//koniec pridana priloha proj 2015


//priloha soc. a zdrav.poistenie
  $text = "  <socZdravPoistenie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <pr1>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->sz1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </pr1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz2;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr2><![CDATA[".$riadok."]]></pr2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz3;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr3><![CDATA[".$riadok."]]></pr3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz4;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr4><![CDATA[".$riadok."]]></pr4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz5;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr5><![CDATA[".$riadok."]]></pr5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz6;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr6><![CDATA[".$riadok."]]></pr6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz7;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr7><![CDATA[".$riadok."]]></pr7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz8;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr8><![CDATA[".$riadok."]]></pr8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz9;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr9><![CDATA[".$riadok."]]></pr9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr10><![CDATA[".$riadok."]]></pr10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr11><![CDATA[".$riadok."]]></pr11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr12><![CDATA[".$riadok."]]></pr12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr13><![CDATA[".$riadok."]]></pr13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr14><![CDATA[".$riadok."]]></pr14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr15><![CDATA[".$riadok."]]></pr15>"."\r\n"; fwrite($soubor, $text);

$vediempu=$hlavicka->vpdu;
  $text = "   <priPrimoch6ods1a2VediemPU><![CDATA[".$vediempu."]]></priPrimoch6ods1a2VediemPU>"."\r\n"; fwrite($soubor, $text);
$datum=SKDatum($hlavicka->szdat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </socZdravPoistenie>"."\r\n";   fwrite($soubor, $text);

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
<div class="bg-white" style="padding: 16px 24px;">
  <p style="line-height: 1.3;">Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a naËÌtajte ho na str·nku <a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Str·nka FinanËnej spr·vy">FinanËnej spr·vy</a> alebo do aplik·cie eDane:
  </p>
  <p style="line-height: 40px;"><a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a></p>
<?php
//xml expor alerts
$upozorni1=0; $upozorni2=0; $upozorni10=0; $upozorni11=0; $upozorni12=0;
?>
<div id="upozornenie" style="display:none;">
<h2>
<strong class="toleft">Upozornenie</strong>
<dl class="toright legend-area">
 <dt class="toleft box-red"></dt><dd class="toleft">kritickÈ</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logickÈ</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( $hlavicka->fdic == "0" AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Nie je vyplnenÈ <strong>DI»</strong> daÚovnÌka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->dar != '0000-00-00' AND $hlavicka->fdic != "0" )
{
$upozorni1=1;
echo "S˙Ëasne vyplnenÈ <strong>diË</strong> aj <strong>d·tum narodenia</strong> daÚovnÌka.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->nrz == 1 AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>nerezidentovi</strong> (bod 12) nie je vyplnen˝ jeho <strong>d·tum narodenia</strong> v bode 2.";
}
?>
</li>
<li class="red">
<?php if ( $hlavicka->druh == 3 AND $hlavicka->ddp == '0000-00-00' )
{
$upozorni1=1;
echo "Pri <strong>dodatoËnom</strong> daÚovom priznanÌ <strong> nie je vyplnen˝ d·tum</strong> zistenia skutoËnosti na podanie dodatoËnÈho priznania.";
}
?>
</li>
<li class="red">
<?php if ( ( $hlavicka->druh == 1 OR $hlavicka->druh == 2 ) AND $hlavicka->ddp != '0000-00-00' )
{
$upozorni1=1;
echo "Vyplnen˝ <strong>d·tum</strong> zistenia skutoËnosti na podanie dodatoËnÈho priznania, ale <strong>nie je</strong> vybratÈ dodatoËnÈ daÚovÈ priznanie.";
}
?>
</li>
<li class="red">
<?php if ( $dprie == "" OR $dmeno == "" )
{
$upozorni1=1;
echo "Nie je vyplnenÈ <strong>priezvisko alebo meno</strong> daÚovnÌka.";
}
?>
</li>
<li class="orange">
<?php if ( $dcdm == "" OR $dpsc == "" OR $dmes == "" OR $dstat == "" ) {
$upozorni1=1;
echo "Nie je vyplnen· cel· <strong>adresa trvalÈho pobytu</strong> daÚovnÌka.";
} ?>
</li>
</ul>
<ul id="alertpage2" style="display:none;">
<li class="header-section">STRANA 2</li>
<li class="orange">
<?php if ( $hlavicka->r29 == 0 AND $hlavicka->r30 != 0 )
{
$upozorni2=1;
echo "Vyplnen· <strong>˙hrnn· suma dÙchodku</strong> v bode 30, avöak nie je zaökrtnutÈ <strong>poberanie dÙchodku</strong> v bode 29.";
}
?>
</li>
</ul>
<ul id="alertpage10" style="display:none;">
<li class="header-section">STRANA 10</li>
<li class="orange">
<?php if ( $hlavicka->druh != 3 AND ( $hlavicka->r122 != 0 OR $hlavicka->r123 != 0 OR $hlavicka->r124 != 0 OR $hlavicka->r125 != 0 OR $hlavicka->r126 != 0 OR $hlavicka->r127 != 0 ) )
{
$upozorni10=1;
echo "VyplnenÈ riadky <strong>X.oddielu</strong>, ale <strong>nie je</strong> vybratÈ dodatoËnÈ daÚovÈ priznanie na 1.strane.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->sdnr != "" OR $hlavicka->r129 != 0 OR $hlavicka->r130 != 0 ) )
{
$upozorni10=1;
echo "V <strong>XI.oddiele</strong> vyplnenÈ <strong>˙daje nerezidenta</strong>, ale nie je vybrat˝ nerezident <strong>v bode 12 na 1.strane</strong>.";
}
?>
</li>
</ul>
<ul id="alertpage11" style="display:none;">
<li class="header-section">STRANA 11</li>
<li class="orange">
<?php if ( $hlavicka->nrz == 0 AND ( $hlavicka->r131 != 0 OR $hlavicka->ldnr != 0 OR $hlavicka->nrzsprev != 0 ) )
{
$upozorni11=1;
echo "V <strong>XI.oddiele</strong> vyplnenÈ <strong>˙daje nerezidenta</strong>, ale nie je vybrat˝ nerezident <strong>v bode 12 na 1.strane</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND $hlavicka->r134 != 0 )
{
$upozorni11=1;
echo "<strong>NeuplatÚujem postup</strong> podæa ß 50 z·kona a z·roveÚ poukazujem sumu v <strong>bode 134</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->upl50 == 1 AND ( $hlavicka->pico != 0 OR $hlavicka->psid != 0 OR $hlavicka->pfor != "" OR $hlavicka->pmen != "" OR $hlavicka->puli != "" OR $hlavicka->pcdm != "" OR $hlavicka->ppsc != "" OR $hlavicka->pmes != "" ) )
{
$upozorni11=1;
echo "<strong>NeuplatÚujem postup</strong> podæa ß 50 z·kona a z·roveÚ s˙ vyplnenÈ <strong>˙daje o prijÌmateæovi</strong> v bode 134.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r134 != 0 AND $hlavicka->upl50 == 0 AND ( $hlavicka->pico == 0 OR $hlavicka->psid == 0 OR $hlavicka->pfor == "" OR $hlavicka->pmen == "" ) )
{
$upozorni11=1;
echo "Nie s˙ vyplnenÈ <strong>˙daje o prÌjimateæovi</strong> v bode 135.";
}
?>
</li>
</ul>
<ul id="alertpage12" style="display:none;">
<li class="header-section">STRANA 12</li>
<li class="orange">
<?php if ( $hlavicka->uoso == 0 AND $hlavicka->osob != "" )
{
$upozorni12=1;
echo "VyplnenÈ <strong>osobitnÈ z·znamy</strong>, ale <strong>nie je vybratÈ uv·dzam</strong> osobitnÈ z·znamy na strane 11.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->dat == '0000-00-00' )
{
$upozorni12=1;
echo "Nie je vyplnen˝ <strong>d·tum vyhl·senia</strong> daÚovÈho priznania.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE dat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>D·tum vyhl·senia</strong> nemÙûe byù vyööÌ ako aktu·lny d·tum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 ) AND ( $hlavicka->post == 1 OR $hlavicka->ucet == 1 OR $hlavicka->diban != "" OR $hlavicka->da2 != '0000-00-00' ) )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele neûiadam</strong> o vyplatenie / vr·tenie, ale s˙ vyplnenÈ hodnoty s˙visiace s vyplatenÌm / vr·tenÌm(napr. spÙsob, iban alebo d·tum).";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->da2 == '0000-00-00' )
{
$upozorni12=1;
echo "V <strong>XIV.oddiele ûiadam</strong> o vyplatenie / vr·tenie, ale nie je vyplnen˝ <strong>d·tum</strong> vyplatenia / vr·tenia.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE da2 <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>D·tum ûiadosti o vr·tenie</strong> nemÙûe byù vyööÌ ako aktu·lny d·tum.";
}
?>
</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE dat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni12=1;
echo "<strong>D·tum ûiadosti o vr·tenie</strong> nemÙûe byù vyööÌ ako aktu·lny d·tum.";
}
?>
</li>
<li class="orange">
<?php if ( ( $hlavicka->zdbo == 1 OR $hlavicka->zpre == 1 ) AND $hlavicka->ucet == 1 AND $hlavicka->diban == "" ) {
$upozorni6=1;
echo "V <strong>XIV.oddiele ûiadam</strong> o vyplatenie / vr·tenie na ˙Ëet, ale nie je vyplnen˝ <strong>IBAN</strong> ˙Ëtu na vyplatenie / vr·tenie.";
} ?>
</li>
</ul>

<ul id="alertpage14" style="display:none;">
<li class="header-section">STRANA 14 - PRÕLOHA 2</li>
<li class="orange">
<?php
$wrongdat=1;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob WHERE szdat <= '$dat_datsql' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $wrongdat=0;
  }
if ( $wrongdat == 1 )
{
$upozorni14=1;
echo "<strong>D·tum v prÌlohe 2</strong> nemÙûe byù vyööÌ ako aktu·lny d·tum.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->sz9 != 0 AND $hlavicka->szdat == '0000-00-00' )
{
$upozorni14=1;
echo "Je vyplnen˝ riadok 9, ale ch˝ba vyplnen˝ <strong>d·tum</strong>.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->r35 != $hlavicka->sz8 )
{
$upozorni14=1;
echo "Riadok 35 zo strany 2 sa musÌ rovnaù <strong>riadku 8</strong> v PrÌlohe 3 priznania o SP a ZP.";
}
?>
</li>
<li class="orange">
<?php if ( $hlavicka->psp6 != ( $hlavicka->sz12 + $hlavicka->sz14 ) )
{
$upozorni14=1;
echo "Hodnota v riadku \"preuk·zateænÈ zaplatenÈ poistnÈ\" na strane 3 sa musÌ rovnaù <strong>riadok 12 + 14</strong> v PrÌlohe 2 priznania.";
}
?>
</li>
</ul>
</div><!-- #upozornenie -->
</div><!-- .bg-white -->

<script type="text/javascript">
<?php
if ( $upozorni1 == 1 OR $upozorni2 == 1 OR $upozorni10 == 1 OR $upozorni11 == 1 OR $upozorni12 == 1 OR $upozorni14 == 1 )
     { echo "upozornenie.style.display='block';"; }
if ( $upozorni1 == 1 ) { echo "alertpage1.style.display='block';"; }
if ( $upozorni2 == 1 ) { echo "alertpage2.style.display='block';"; }
if ( $upozorni10 == 1 ) { echo "alertpage10.style.display='block';"; }
if ( $upozorni11 == 1 ) { echo "alertpage11.style.display='block';"; }
if ( $upozorni12 == 1 ) { echo "alertpage12.style.display='block';"; }
if ( $upozorni14 == 1 ) { echo "alertpage14.style.display='block';"; }
?>
</script>
<?php
//mysql_free_result($vysledok);
     }
//koniec xml

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>
</div><!-- #content -->
<?php
//celkovy koniec dokumentu
$cislista = include("uct_lista_norm.php");
} while (false);
?>
<script type="text/javascript">
//parameter okna
var blank_param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

<?php
//uprava sadzby
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
   document.formv1.dar.value = '<?php echo $darsk; ?>';
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.ddp.value = '<?php echo $ddpsk; ?>';
   document.formv1.cinnost.value = '<?php echo $cinnost; ?>';
<?php if ( $nrz == 1 ) { ?> document.formv1.nrz.checked = "checked"; <?php } ?>
<?php if ( $prp == 1 ) { ?> document.formv1.prp.checked = "checked"; <?php } ?>
   document.formv1.d2uli.value = '<?php echo $d2uli; ?>';
   document.formv1.d2cdm.value = '<?php echo $d2cdm; ?>';
   document.formv1.d2psc.value = '<?php echo $d2psc; ?>';
   document.formv1.d2mes.value = '<?php echo $d2mes; ?>';
   document.formv1.zprie.value = '<?php echo $zprie; ?>';
   document.formv1.zmeno.value = '<?php echo $zmeno; ?>';
   document.formv1.ztitl.value = '<?php echo $ztitl; ?>';
   document.formv1.ztitz.value = '<?php echo $ztitz; ?>';
   document.formv1.zrdc.value = '<?php echo $zrdc; ?>';
   document.formv1.zrdk.value = '<?php echo $zrdk; ?>';
   document.formv1.zuli.value = '<?php echo $zuli; ?>';
   document.formv1.zcdm.value = '<?php echo $zcdm; ?>';
   document.formv1.zpsc.value = '<?php echo $zpsc; ?>';
   document.formv1.zmes.value = '<?php echo $zmes; ?>';
   document.formv1.zstat.value = '<?php echo $zstat; ?>';
   document.formv1.dtel.value = '<?php echo $dtel; ?>';
   document.formv1.dmailfax.value = '<?php echo $dmailfax; ?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.r30.value = '<?php echo $r30; ?>';
<?php if ( $r29 == 1 ) { ?> document.formv1.r29.checked = "checked"; <?php } ?>
   document.formv1.mprie.value = '<?php echo $mprie; ?>';
   document.formv1.mrod.value = '<?php echo $mrod; ?>';
   document.formv1.mpri.value = '<?php echo $mpri; ?>';
   document.formv1.mpom.value = '<?php echo $mpom; ?>';
   document.formv1.d1prie.value = '<?php echo $d1prie; ?>';
   document.formv1.d1rod.value = '<?php echo $d1rod; ?>';
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
   document.formv1.d2prie.value = '<?php echo $d2prie; ?>';
   document.formv1.d2rod.value = '<?php echo $d2rod; ?>';
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
   document.formv1.d3prie.value = '<?php echo $d3prie; ?>';
   document.formv1.d3rod.value = '<?php echo $d3rod; ?>';
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
   document.formv1.d4prie.value = '<?php echo $d4prie; ?>';
   document.formv1.d4rod.value = '<?php echo $d4rod; ?>';
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
   document.formv1.r34.value = '<?php echo $r34; ?>';
   document.formv1.r34a.value = '<?php echo $r34a; ?>';
   document.formv1.r35.value = '<?php echo $r35; ?>';
//   document.formv1.r36.value = '<?php echo $r36; ?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   document.formv1.t1p1.value = '<?php echo $t1p1; ?>';
   document.formv1.t1p2.value = '<?php echo $t1p2; ?>';
   document.formv1.t1p3.value = '<?php echo $t1p3; ?>';
   document.formv1.t1p4.value = '<?php echo $t1p4; ?>';
   document.formv1.t1p5.value = '<?php echo $t1p5; ?>';
   document.formv1.t1p6.value = '<?php echo $t1p6; ?>';
   document.formv1.t1p7.value = '<?php echo $t1p7; ?>';
   document.formv1.t1p8.value = '<?php echo $t1p8; ?>';
   document.formv1.t1p9.value = '<?php echo $t1p9; ?>';
   document.formv1.t1p11.value = '<?php echo $t1p11; ?>';
   document.formv1.t1p12.value = '<?php echo $t1p12; ?>';
   document.formv1.t1v1.value = '<?php echo $t1v1; ?>';
   document.formv1.t1v2.value = '<?php echo $t1v2; ?>';
   document.formv1.t1v3.value = '<?php echo $t1v3; ?>';
   document.formv1.t1v4.value = '<?php echo $t1v4; ?>';
   document.formv1.t1v5.value = '<?php echo $t1v5; ?>';
   document.formv1.t1v6.value = '<?php echo $t1v6; ?>';
   document.formv1.t1v7.value = '<?php echo $t1v7; ?>';
   document.formv1.t1v8.value = '<?php echo $t1v8; ?>';
   document.formv1.t1v9.value = '<?php echo $t1v9; ?>';
   document.formv1.t1v11.value = '<?php echo $t1v11; ?>';
   document.formv1.t1v12.value = '<?php echo $t1v12; ?>';
<?php if ( $uppr1 == 1 ) { ?> document.formv1.uppr1.checked = "checked"; <?php } ?>
<?php if ( $uppr3 == 1 ) { ?> document.formv1.uppr3.checked = "checked"; <?php } ?>
<?php if ( $uppr4 == 1 ) { ?> document.formv1.uppr4.checked = "checked"; <?php } ?>
<?php if ( $uvp61 == 1 ) { ?> document.formv1.uvp61.checked = "checked"; <?php } ?>
<?php if ( $uvp64 == 1 ) { ?> document.formv1.uvp64.checked = "checked"; <?php } ?>
<?php if ( $uos61 == 1 ) { ?> document.formv1.uos61.checked = "checked"; <?php } ?>
<?php if ( $uos64 == 1 ) { ?> document.formv1.uos64.checked = "checked"; <?php } ?>
<?php if ( $kos61 == 1 ) { ?> document.formv1.kos61.checked = "checked"; <?php } ?>
<?php if ( $kos64 == 1 ) { ?> document.formv1.kos64.checked = "checked"; <?php } ?>

   document.formv1.psp6.value = '<?php echo $psp6; ?>';
   document.formv1.t1az1.value = '<?php echo $t1az1; ?>';
   document.formv1.t1az2.value = '<?php echo $t1az2; ?>';

   document.formv1.t1ak1.value = '<?php echo $t1ak1; ?>';
   document.formv1.t1ak2.value = '<?php echo $t1ak2; ?>';
<?php                                        } ?>

<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
   document.formv1.t1az3.value = '<?php echo $t1az3; ?>';
   document.formv1.t1az4.value = '<?php echo $t1az4; ?>';
   document.formv1.t1az5.value = '<?php echo $t1az5; ?>';
   document.formv1.t1ak3.value = '<?php echo $t1ak3; ?>';
   document.formv1.t1ak4.value = '<?php echo $t1ak4; ?>';
   document.formv1.t1ak5.value = '<?php echo $t1ak5; ?>';
   document.formv1.t1bz1.value = '<?php echo $t1bz1; ?>';
   document.formv1.t1bz2.value = '<?php echo $t1bz2; ?>';
   document.formv1.t1bk1.value = '<?php echo $t1bk1; ?>';
   document.formv1.t1bk2.value = '<?php echo $t1bk2; ?>';
//   document.formv1.r37.value = '<?php echo $r37; ?>';
//   document.formv1.r38.value = '<?php echo $r38; ?>';
   document.formv1.r39.value = '<?php echo $r39; ?>';
   document.formv1.r40.value = '<?php echo $r40; ?>';
   document.formv1.r39pu.value = '<?php echo $r39pu; ?>';
   document.formv1.r40pu.value = '<?php echo $r40pu; ?>';
   document.formv1.r41.value = '<?php echo $r41; ?>';
   document.formv1.r42.value = '<?php echo $r42; ?>';
//   document.formv1.r43.value = '<?php echo $r43; ?>';
//   document.formv1.r44.value = '<?php echo $r44; ?>';
   document.formv1.r45.value = '<?php echo $r45; ?>';
   document.formv1.r46.value = '<?php echo $r46; ?>';
   document.formv1.r47.value = '<?php echo $r47; ?>';
   document.formv1.r48.value = '<?php echo $r48; ?>';

<?php                                        } ?>

<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
   document.formv1.r49.value = '<?php echo $r49; ?>';
   document.formv1.r50.value = '<?php echo $r50; ?>';
   document.formv1.r51.value = '<?php echo $r51; ?>';
   document.formv1.r52.value = '<?php echo $r52; ?>';
//   document.formv1.r53.value = '<?php echo $r53; ?>';
//   document.formv1.r54.value = '<?php echo $r54; ?>';
//   document.formv1.r55.value = '<?php echo $r55; ?>';
   document.formv1.r56.value = '<?php echo $r56; ?>';
//   document.formv1.r57.value = '<?php echo $r57; ?>';
//   document.formv1.r58.value = '<?php echo $r58; ?>';
//   document.formv1.r59.value = '<?php echo $r59; ?>';
//   document.formv1.r60.value = '<?php echo $r60; ?>';
   document.formv1.r61.value = '<?php echo $r61; ?>';
   document.formv1.r62.value = '<?php echo $r62; ?>';
   document.formv1.r63.value = '<?php echo $r63; ?>';
   document.formv1.r64.value = '<?php echo $r64; ?>';
//   document.formv1.r65.value = '<?php echo $r65; ?>';

   document.formv1.t2p1.value = '<?php echo $t2p1; ?>';

   document.formv1.t2v1.value = '<?php echo $t2v1; ?>';

<?php                                        } ?>

<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
   document.formv1.t2p2.value = '<?php echo $t2p2; ?>';
   document.formv1.t2p3.value = '<?php echo $t2p3; ?>';
   document.formv1.t2p4.value = '<?php echo $t2p4; ?>';
   document.formv1.t2p5.value = '<?php echo $t2p5; ?>';
   document.formv1.t2p6.value = '<?php echo $t2p6; ?>';
   document.formv1.t2p7.value = '<?php echo $t2p7; ?>';
   document.formv1.t2p8.value = '<?php echo $t2p8; ?>';
   document.formv1.t2p9.value = '<?php echo $t2p9; ?>';
   document.formv1.t2p10.value = '<?php echo $t2p10; ?>';
   document.formv1.t2p12.value = '<?php echo $t2p12; ?>';
   document.formv1.t2v2.value = '<?php echo $t2v2; ?>';
   document.formv1.t2v3.value = '<?php echo $t2v3; ?>';
   document.formv1.t2v4.value = '<?php echo $t2v4; ?>';
   document.formv1.t2v5.value = '<?php echo $t2v5; ?>';
   document.formv1.t2v6.value = '<?php echo $t2v6; ?>';
   document.formv1.t2v7.value = '<?php echo $t2v7; ?>';
   document.formv1.t2v8.value = '<?php echo $t2v8; ?>';
   document.formv1.t2v9.value = '<?php echo $t2v9; ?>';
   document.formv1.t2v10.value = '<?php echo $t2v10; ?>';
//   document.formv1.r66.value = '<?php echo $r66; ?>';
//   document.formv1.r67.value = '<?php echo $r67; ?>';
//   document.formv1.r68.value = '<?php echo $r68; ?>';
   document.formv1.t3p1.value = '<?php echo $t3p1; ?>';
   document.formv1.t3p2.value = '<?php echo $t3p2; ?>';
   document.formv1.t3p3.value = '<?php echo $t3p3; ?>';
   document.formv1.t3v1.value = '<?php echo $t3v1; ?>';
   document.formv1.t3v2.value = '<?php echo $t3v2; ?>';
   document.formv1.t3v3.value = '<?php echo $t3v3; ?>';
<?php                                        } ?>

<?php if ( $strana == 7 OR $strana == 9999 ) { ?>

   document.formv1.t3p4.value = '<?php echo $t3p4; ?>';
   document.formv1.t3p5.value = '<?php echo $t3p5; ?>';
   document.formv1.t3p6.value = '<?php echo $t3p6; ?>';
   document.formv1.t3p7.value = '<?php echo $t3p7; ?>';
   document.formv1.t3p8.value = '<?php echo $t3p8; ?>';
   document.formv1.t3p9.value = '<?php echo $t3p9; ?>';
   document.formv1.t3p10.value = '<?php echo $t3p10; ?>';
   document.formv1.t3p11.value = '<?php echo $t3p11; ?>';
   document.formv1.t3p12.value = '<?php echo $t3p12; ?>';
   document.formv1.t3p13.value = '<?php echo $t3p13; ?>';
   document.formv1.t3p14.value = '<?php echo $t3p14; ?>';
   document.formv1.t3p15.value = '<?php echo $t3p15; ?>';
   document.formv1.t3p16.value = '<?php echo $t3p16; ?>';

   document.formv1.t3v4.value = '<?php echo $t3v4; ?>';
   document.formv1.t3v5.value = '<?php echo $t3v5; ?>';
   document.formv1.t3v6.value = '<?php echo $t3v6; ?>';
   document.formv1.t3v7.value = '<?php echo $t3v7; ?>';
   document.formv1.t3v8.value = '<?php echo $t3v8; ?>';
   document.formv1.t3v9.value = '<?php echo $t3v9; ?>';
   document.formv1.t3v10.value = '<?php echo $t3v10; ?>';
   document.formv1.t3v11.value = '<?php echo $t3v11; ?>';
   document.formv1.t3v12.value = '<?php echo $t3v12; ?>';
   document.formv1.t3v13.value = '<?php echo $t3v13; ?>';
   document.formv1.t3v14.value = '<?php echo $t3v14; ?>';
   document.formv1.t3v15.value = '<?php echo $t3v15; ?>';
//   document.formv1.r69.value = '<?php echo $r69; ?>';
//   document.formv1.r70.value = '<?php echo $r70; ?>';
//   document.formv1.r71.value = '<?php echo $r71; ?>';
<?php                                        } ?>

<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
//   document.formv1.r72.value = '<?php echo $r72; ?>';
   document.formv1.r73.value = '<?php echo $r73; ?>';
   document.formv1.r74.value = '<?php echo $r74; ?>';
   document.formv1.r75.value = '<?php echo $r75; ?>';
//   document.formv1.r77.value = '<?php echo $r77; ?>';
//   document.formv1.r78.value = '<?php echo $r78; ?>';
   document.formv1.r79.value = '<?php echo $r79; ?>';
//   document.formv1.r80.value = '<?php echo $r80; ?>';
   document.formv1.r81.value = '<?php echo $r81; ?>';
   document.formv1.r82.value = '<?php echo $r82; ?>';
//   document.formv1.r83.value = '<?php echo $r83; ?>';
   document.formv1.r84.value = '<?php echo $r84; ?>';
   document.formv1.r85.value = '<?php echo $r85; ?>';
   document.formv1.r86.value = '<?php echo $r86; ?>';
   document.formv1.r87.value = '<?php echo $r87; ?>';
   document.formv1.r88.value = '<?php echo $r88; ?>';
   document.formv1.r89.value = '<?php echo $r89; ?>';
//   document.formv1.r90.value = '<?php echo $r90; ?>';
//   document.formv1.r91.value = '<?php echo $r91; ?>';
   document.formv1.r92.value = '<?php echo $r92; ?>';
//   document.formv1.r93.value = '<?php echo $r93; ?>';
   document.formv1.r94.value = '<?php echo $r94; ?>';
<?php                                        } ?>

<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
   document.formv1.r95.value = '<?php echo $r95; ?>';
   document.formv1.r96.value = '<?php echo $r96; ?>';
   document.formv1.r97.value = '<?php echo $r97; ?>';
   document.formv1.r98.value = '<?php echo $r98; ?>';
   document.formv1.r99.value = '<?php echo $r99; ?>';
   document.formv1.r100.value = '<?php echo $r100; ?>';
   document.formv1.r101.value = '<?php echo $r101; ?>';
   document.formv1.r102.value = '<?php echo $r102; ?>';
   document.formv1.r103.value = '<?php echo $r103; ?>';
   document.formv1.r104.value = '<?php echo $r104; ?>';
//   document.formv1.r105.value = '<?php echo $r105; ?>';
   document.formv1.r106.value = '<?php echo $r106; ?>';
//   document.formv1.r107.value = '<?php echo $r107; ?>';
   document.formv1.r108.value = '<?php echo $r108; ?>';
//   document.formv1.r109.value = '<?php echo $r109; ?>';
//   document.formv1.r110.value = '<?php echo $r110; ?>';
//   document.formv1.r111.value = '<?php echo $r111; ?>';
   document.formv1.r112.value = '<?php echo $r112; ?>';
   document.formv1.r113.value = '<?php echo $r113; ?>';
   document.formv1.r114.value = '<?php echo $r114; ?>';
   document.formv1.r115.value = '<?php echo $r115; ?>';
   document.formv1.r116.value = '<?php echo $r116; ?>';
   document.formv1.r117.value = '<?php echo $r117; ?>';
   document.formv1.r118.value = '<?php echo $r118; ?>';
//   document.formv1.r119.value = '<?php echo $r119; ?>';
<?php                                        } ?>

<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
//   document.formv1.r120.value = '<?php echo $r120; ?>';
//   document.formv1.r121.value = '<?php echo $r121; ?>';
   document.formv1.r122.value = '<?php echo $r122; ?>';
   document.formv1.r123.value = '<?php echo $r123; ?>';
   document.formv1.r124.value = '<?php echo $r124; ?>';
   document.formv1.r125.value = '<?php echo $r125; ?>';
   document.formv1.r126.value = '<?php echo $r126; ?>';
   document.formv1.r127.value = '<?php echo $r127; ?>';
   document.formv1.sdnr.value = '<?php echo $sdnr; ?>';
   document.formv1.r129.value = '<?php echo $r129; ?>';
   document.formv1.r130.value = '<?php echo $r130; ?>';
<?php                                         } ?>

<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
   document.formv1.r131.value = '<?php echo $r131; ?>';
<?php if ( $ldnr == 1 ) { ?> document.formv1.ldnr.checked = "checked"; <?php } ?>
   document.formv1.nrzsprev.value = '<?php echo "$nrzsprev"; ?>';
//<?php if ( $upl50 == 1 ) { ?> document.formv1.upl50.checked = "checked"; <?php } ?>
//<?php if ( $spl3d == 1 ) { ?> document.formv1.spl3d.checked = "checked"; <?php } ?>

<?php if ( $upl50 == 1 ) { echo "document.formv1.upl50.checked='checked';"; } ?>
<?php if ( $spl3d == 1 ) { echo "document.formv1.spl3d.checked='checked';"; } ?>

   document.formv1.r134.value = '<?php echo $r134; ?>';
   document.formv1.pico.value = '<?php echo $pico; ?>';
   document.formv1.psid.value = '<?php echo $psid; ?>';
   document.formv1.pfor.value = '<?php echo $pfor; ?>';
   document.formv1.pmen.value = '<?php echo $pmen; ?>';
   document.formv1.puli.value = '<?php echo $puli; ?>';
   document.formv1.pcdm.value = '<?php echo $pcdm; ?>';
   document.formv1.ppsc.value = '<?php echo $ppsc; ?>';
   document.formv1.pmes.value = '<?php echo $pmes; ?>';
<?php if ( $zslu == 1 ) { ?> document.formv1.zslu.checked = "checked"; <?php } ?>
<?php if ( $uoso == 1 ) { ?> document.formv1.uoso.checked = "checked"; <?php } ?>
   document.formv1.pzks1.value = '<?php echo $pzks1; ?>';
   document.formv1.pdrp1.value = '<?php echo $pdrp1; ?>';
   document.formv1.pdro1.value = '<?php echo $pdro1; ?>';
   document.formv1.pdrm1.value = '<?php echo $pdrm1; ?>';
   document.formv1.pzpr1.value = '<?php echo $pzpr1; ?>';
   document.formv1.pzvd1.value = '<?php echo $pzvd1; ?>';
   document.formv1.pzthvd1.value = '<?php echo $pzthvd1; ?>';
   document.formv1.pzks2.value = '<?php echo $pzks2; ?>';
   document.formv1.pdrp2.value = '<?php echo $pdrp2; ?>';
   document.formv1.pdro2.value = '<?php echo $pdro2; ?>';
   document.formv1.pdrm2.value = '<?php echo $pdrm2; ?>';
   document.formv1.pzpr2.value = '<?php echo $pzpr2; ?>';
   document.formv1.pzvd2.value = '<?php echo $pzvd2; ?>';
   document.formv1.pzthvd2.value = '<?php echo $pzthvd2; ?>';
   document.formv1.pzks3.value = '<?php echo $pzks3; ?>';
   document.formv1.pdrp3.value = '<?php echo $pdrp3; ?>';
   document.formv1.pdro3.value = '<?php echo $pdro3; ?>';
   document.formv1.pdrm3.value = '<?php echo $pdrm3; ?>';
   document.formv1.pzpr3.value = '<?php echo $pzpr3; ?>';
   document.formv1.pzvd3.value = '<?php echo $pzvd3; ?>';
   document.formv1.pzthvd3.value = '<?php echo $pzthvd3; ?>';
   document.formv1.pzks4.value = '<?php echo $pzks4; ?>';
   document.formv1.pdrp4.value = '<?php echo $pdrp4; ?>';
   document.formv1.pdro4.value = '<?php echo $pdro4; ?>';
   document.formv1.pdrm4.value = '<?php echo $pdrm4; ?>';
   document.formv1.pzpr4.value = '<?php echo $pzpr4; ?>';
   document.formv1.pzvd4.value = '<?php echo $pzvd4; ?>';
   document.formv1.pzthvd4.value = '<?php echo $pzthvd4; ?>';
   document.formv1.pzks5.value = '<?php echo $pzks5; ?>';
   document.formv1.pdrp5.value = '<?php echo $pdrp5; ?>';
   document.formv1.pdro5.value = '<?php echo $pdro5; ?>';
   document.formv1.pdrm5.value = '<?php echo $pdrm5; ?>';
   document.formv1.pzpr5.value = '<?php echo $pzpr5; ?>';
   document.formv1.pzvd5.value = '<?php echo $pzvd5; ?>';
   document.formv1.pzthvd5.value = '<?php echo $pzthvd5; ?>';
   document.formv1.pzks6.value = '<?php echo $pzks6; ?>';
   document.formv1.pdrp6.value = '<?php echo $pdrp6; ?>';
   document.formv1.pdro6.value = '<?php echo $pdro6; ?>';
   document.formv1.pdrm6.value = '<?php echo $pdrm6; ?>';
   document.formv1.pzpr6.value = '<?php echo $pzpr6; ?>';
   document.formv1.pzvd6.value = '<?php echo $pzvd6; ?>';
   document.formv1.pzthvd6.value = '<?php echo $pzthvd6; ?>';
<?php                                         } ?>

<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
   document.formv1.pril.value = '<?php echo $pril; ?>';
   document.formv1.dat.value = '<?php echo $datsk; ?>';
<?php if ( $zdbo == 1 ) { ?> document.formv1.zdbo.checked = "checked"; <?php } ?>
<?php if ( $zpre == 1 ) { ?> document.formv1.zpre.checked = "checked"; <?php } ?>
<?php if ( $post == 1 ) { ?> document.formv1.post.checked = "checked"; <?php } ?>
<?php if ( $ucet == 1 ) { ?> document.formv1.ucet.checked = "checked"; <?php } ?>
   document.formv1.diban.value = '<?php echo $diban; ?>';
   document.formv1.da2.value = '<?php echo $da2sk; ?>';
<?php                                         } ?>

<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
   document.formv1.prpdzc.value = '<?php echo $prpdzcsk; ?>';

   document.formv1.prpzo1.value = '<?php echo $prpzo1sk; ?>';
   document.formv1.prpzo2.value = '<?php echo $prpzo2sk; ?>';
   document.formv1.prpzo3.value = '<?php echo $prpzo3sk; ?>';
   document.formv1.prpzo4.value = '<?php echo $prpzo4sk; ?>';
   document.formv1.prpzo5.value = '<?php echo $prpzo5sk; ?>';

   document.formv1.prpzd1.value = '<?php echo $prpzd1sk; ?>';
   document.formv1.prpzd2.value = '<?php echo $prpzd2sk; ?>';
   document.formv1.prpzd3.value = '<?php echo $prpzd3sk; ?>';
   document.formv1.prpzd4.value = '<?php echo $prpzd4sk; ?>';
   document.formv1.prpzd5.value = '<?php echo $prpzd5sk; ?>';

   document.formv1.prpvz1.value = '<?php echo $prpvz1; ?>';
   document.formv1.prpvz2.value = '<?php echo $prpvz2; ?>';
   document.formv1.prpvz3.value = '<?php echo $prpvz3; ?>';
   document.formv1.prpvz4.value = '<?php echo $prpvz4; ?>';
   document.formv1.prpvz5.value = '<?php echo $prpvz5; ?>';

   document.formv1.prpod1.value = '<?php echo $prpod1; ?>';
   document.formv1.prpod2.value = '<?php echo $prpod2; ?>';
   document.formv1.prpod3.value = '<?php echo $prpod3; ?>';
   document.formv1.prpod4.value = '<?php echo $prpod4; ?>';
   document.formv1.prpod5.value = '<?php echo $prpod5; ?>';
<?php                                         } ?>

<?php if ( $strana == 14 OR $strana == 9999 ) { ?>
   document.formv1.ozd1r01.value = '<?php echo $ozd1r01; ?>';
   document.formv1.ozd1r02.value = '<?php echo $ozd1r02; ?>';
   document.formv1.ozd1r03.value = '<?php echo $ozd1r03; ?>';
   document.formv1.ozd1r04.value = '<?php echo $ozd1r04; ?>';
   document.formv1.ozd2r04.value = '<?php echo $ozd2r04; ?>';
   document.formv1.ozd1r05.value = '<?php echo $ozd1r05; ?>';
   document.formv1.ozd2r05.value = '<?php echo $ozd2r05; ?>';
   document.formv1.ozdr07.value = '<?php echo $ozdr07; ?>';
   document.formv1.ozdr09.value = '<?php echo $ozdr09; ?>';
   document.formv1.ozdr10.value = '<?php echo $ozdr10; ?>';
   document.formv1.ozdr11.value = '<?php echo $ozdr11; ?>';
   document.formv1.ozdr12.value = '<?php echo $ozdr12; ?>';
   document.formv1.ozdr13.value = '<?php echo $ozdr13; ?>';
   document.formv1.ozdr14.value = '<?php echo $ozdr14; ?>';
   document.formv1.ozdr15.value = '<?php echo $ozdr15; ?>';
   document.formv1.ozdr16.value = '<?php echo $ozdr16; ?>';
   document.formv1.ozdr17.value = '<?php echo $ozdr17; ?>';
<?php                                         } ?>

<?php if ( $strana == 15 OR $strana == 9999 ) { ?>
   document.formv1.ozdr18.value = '<?php echo $ozdr18; ?>';
   document.formv1.ozd1r19.value = '<?php echo $ozd1r19; ?>';
   document.formv1.ozd1r20.value = '<?php echo $ozd1r20; ?>';
   document.formv1.ozd1r21.value = '<?php echo $ozd1r21; ?>';
   document.formv1.ozd1r22.value = '<?php echo $ozd1r22; ?>';
   document.formv1.ozd2r22.value = '<?php echo $ozd2r22; ?>';
   document.formv1.ozd1r23.value = '<?php echo $ozd1r23; ?>';
   document.formv1.ozd2r23.value = '<?php echo $ozd2r23; ?>';
//   document.formv1.ozd1r24.value = '<?php echo $ozd1r24; ?>';
//   document.formv1.ozd2r24.value = '<?php echo $ozd2r24; ?>';
   document.formv1.ozdr25.value = '<?php echo $ozdr25; ?>';
   document.formv1.ozdr27.value = '<?php echo $ozdr27; ?>';
   document.formv1.ozdr28.value = '<?php echo $ozdr28; ?>';
<?php                                         } ?>


<?php if ( $strana == 16 OR $strana == 9999 ) { ?>
   document.formv1.sz1p1.value = '<?php echo $sz1p1; ?>';
   document.formv1.sz1v1.value = '<?php echo $sz1v1; ?>';
   document.formv1.sz2.value = '<?php echo $sz2; ?>';
   document.formv1.sz3.value = '<?php echo $sz3; ?>';
   document.formv1.sz4.value = '<?php echo $sz4; ?>';
   document.formv1.sz5.value = '<?php echo $sz5; ?>';
//   document.formv1.sz6.value = '<?php echo $sz6; ?>';
//   document.formv1.sz7.value = '<?php echo $sz7; ?>';
   document.formv1.sz8.value = '<?php echo $sz8; ?>';
   document.formv1.sz9.value = '<?php echo $sz9; ?>';
   document.formv1.sz10.value = '<?php echo $sz10; ?>';
   document.formv1.sz11.value = '<?php echo $sz11; ?>';
   document.formv1.sz12.value = '<?php echo $sz12; ?>';
   document.formv1.sz13.value = '<?php echo $sz13; ?>';
   document.formv1.sz14.value = '<?php echo $sz14; ?>';
   document.formv1.sz15.value = '<?php echo $sz15; ?>';
   document.formv1.szdat.value = '<?php echo $szdatsk; ?>';
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



  function FormPDF(strana)
  {
    window.open('priznanie_fob2017_pdf.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=11&strana=' + strana + '&drupoh=1&subor=0', '_blank', blank_param);
  }
  function editForm(strana)
  {
    window.open('priznanie_fob2017.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=20&prepocitaj=101&strana=' + strana + '&drupoh=1&subor=0', '_self');
  }



  function NacitajMinRok()
  {
   window.open('../ucto/priznanie_fob2017.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1', '_self');
  }
  function FormPoucenie()
  {
   window.open('<?php echo $jpg_source; ?>_poucenie.pdf', '_blank', blank_param);
  }
  function vypocetOP()
  {
   window.open('priznanie_fob2017.php?copern=20&strana=<?php echo $strana; ?>&miliondan=1', '_self');
  }
  function namanzelku()
  {
   window.open('priznanie_fob2017.php?copern=20&strana=<?php echo $strana; ?>&namanzelku=1', '_self');
  }
  function NacitajVHpredDanou()
  {
   window.open('../ucto/priznanie_fob2017.php?strana=3&copern=200&drupoh=1&typ=PDF&dppo=1', '_self');
  }
  function NacitajSz9()
  {
   window.open('../ucto/priznanie_fob2017.php?strana=15&copern=209&drupoh=1&typ=PDF&dppo=1', '_self');
   //dopyt, preveriù Ëi funguje
  }
  function UpravFO()
  {
   window.open('../cis/ufirdalsie.php?copern=402', '_blank');
  }
//bud alebo checkbox v xiv.oddiele
//dopyt, vraziù na konkrÈtnu stranu


  function FormXML()
  {
   window.open('priznanie_fob2017.php?copern=10&drupoh=1', '_blank', blank_param);
  }
  function CisKrajin()
  {
   window.open('../cis/ciselnik_krajin.pdf', '_blank', blank_param);
  }
  function dajDnes()
  {
  if( document.formv1.dat.value == '00.00.0000' ) { document.formv1.dat.value = '<?php echo $dnessk; ?>' }
  if( document.formv1.dat.value == '' ) { document.formv1.dat.value = '<?php echo $dnessk; ?>' }
  }


</script>
</body>
</html>
<!--
Todo
- pridaù xml Ëasù
- pdf Ëasù zvl·öù
- zistiù echo bunky
- iËo/sid v prijÌmateæoch poËkaù na .xml
 -->