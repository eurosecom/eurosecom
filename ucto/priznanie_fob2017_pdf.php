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

$zablokovane=1;
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


//ked idem z menu dan z prijmu neprepocita ale nasledne ked ulozim tak prepocita
if ( $prepocitaj == 101 ) { $prepocitaj=1; }


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
<div class="input-echo right" style="width:242px; top:756px; left:489px;"><?php echo $r86; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:756px; left:770px;">
<div class="input-echo right" style="width:242px; top:810px; left:489px;"><?php echo $r87; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:810px; left:770px;">
<div class="input-echo right" style="width:242px; top:857px; left:489px;"><?php echo $r88; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:857px; left:770px;">
<div class="input-echo right" style="width:242px; top:899px; left:489px;"><?php echo $r89; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:900px; left:770px;">
<div class="input-echo right" style="width:242px; top:944px; left:489px;"><?php echo $r90; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:944px; left:770px;">
<div class="input-echo right" style="width:242px; top:988px; left:489px;"><?php echo $r91; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:989px; left:770px;">
<input type="text" name="r92" id="r92" onkeyup="CiarkaNaBodku(this);" style="width:262px; top:1027px; left:470px;"/>
<div class="input-echo right" style="width:242px; top:1077px; left:489px;"><?php echo $r93; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1078px; left:770px;">
<div class="input-echo right" style="width:242px; top:1131px; left:489px;"><?php echo $r94; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1131px; left:770px;">
<?php                     } ?>


<?php if ( $strana == 9 ) { ?>
<img src="<?php echo $jpg_source; ?>_str9.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:74px; left:401px;"><?php echo $fir_fdic; ?></span>
<!-- IX.ODDIEL pokracovanie -->
<input type="text" name="r95" id="r95" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:117px; left:500px;"/>
<div class="input-echo right" style="width:242px; top:169px; left:500px;"><?php echo $r96; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:169px; left:770px;">
<div class="input-echo right" style="width:242px; top:219px; left:500px;"><?php echo $r97; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:219px; left:770px;">
<div class="input-echo right" style="width:242px; top:261px; left:500px;"><?php echo $r98; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:261px; left:770px;">
<div class="input-echo right" style="width:242px; top:303px; left:500px;"><?php echo $r99; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:303px; left:770px;">
<div class="input-echo right" style="width:242px; top:348px; left:500px;"><?php echo $r100; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:348px; left:770px;">
<input type="text" name="r101" id="r101" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:402px; left:500px;"/>
<input type="text" name="r102" id="r102" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:460px; left:500px;"/>
<input type="text" name="r103" id="r103" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:522px; left:500px;"/>
<div class="input-echo right" style="width:242px; top:581px; left:500px;"><?php echo $r104; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:581px; left:770px;">
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
<input type="text" name="dat" id="dat" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:195px; top:930px; left:277px;"/>

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
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:546px; left:913px;">
<div class="input-echo right" style="width:244px; top:699px; left:557px;"><?php echo $ozdr07; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:699px; left:830px;">
<input type="text" name="ozdr08" id="ozdr08" maxlength="1" style="width:13px; top:737px; left:695px;"/>
<div class="input-echo right" style="width:244px; top:782px; left:557px;"><?php echo $ozdr09; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:783px; left:830px;">
<input type="text" name="ozdr10" id="ozdr10" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:870px; left:557px;"/>
<div class="input-echo right" style="width:242px; top:909px; left:560px;"><?php echo $ozdr11; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:909px; left:830px;">
<div class="input-echo right" style="width:242px; top:954px; left:560px;"><?php echo $ozdr12; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:954px; left:830px;">
<input type="text" name="ozdr13" id="ozdr13" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1042px; left:557px;"/>
<input type="text" name="ozdr14" id="ozdr14" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:1086px; left:557px;"/>
<div class="input-echo right" style="width:242px; top:1131px; left:560px;"><?php echo $ozdr15; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1131px; left:830px;">
<div class="input-echo right" style="width:242px; top:1171px; left:560px;"><?php echo $ozdr16; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1172px; left:830px;">
<div class="input-echo right" style="width:242px; top:1210px; left:560px;"><?php echo $ozdr17; ?>&nbsp;</div>
<img src="../obr/ikony/info_blue_icon.png" title="Hodnota sa zobrazÌ po prepoËÌtanÌ a uloûenÌ zmien na strane" class="btn-row-tool" style="top:1211px; left:830px;">
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
<input type="text" name="ozd1r24" id="ozd1r24" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:462px; left:410px;"/>
<input type="text" name="ozd2r24" id="ozd2r24" onkeyup="CiarkaNaBodku(this);" style="width:234px; top:462px; left:661px;"/>
<input type="text" name="ozdr25" id="ozdr25" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:560px; left:557px;"/>
<input type="text" name="ozdr27" id="ozdr27" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:644px; left:557px;"/>
<input type="text" name="ozdr28" id="ozdr28" onkeyup="CiarkaNaBodku(this);" style="width:244px; top:705px; left:557px;"/>
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
<input type="text" name="sz6" id="sz6" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:468px; left:517px;"/>
<input type="text" name="sz7" id="sz7" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:530px; left:517px;"/>
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
</div><!-- #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav udaje


//PDF
if ( $copern == 10 )
{
//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/priznaniefob_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/priznaniefob_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }


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
$pdf->SetLeftMargin(10); //dopyt, menil som okraj, takûe vöetky strany skontrolovaù rozmery tlaËe
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str1.jpg') )
{
$pdf->Image($jpg_source.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,43," ","$rmc1",1,"L");
$text="1234567890";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$text=SkDatum($hlavicka->ddp);
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str2.jpg') )
{
$pdf->Image($jpg_source.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$pdf->Cell(195,42," ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->r29 == 0 ) $text=" ";
$pdf->Cell(157,5," ","$rmc1",0,"L");$pdf->Cell(5,5,"$text","$rmc",1,"C");

//polozka30
$pdf->Cell(195,6," ","$rmc1",1,"L");
$text="1234567";
$hodx=100*$hlavicka->r30;
if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(195,48," ","$rmc1",1,"L");
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
$pdf->SetY(147);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d1pom1 == 1 ) $t01="x";
if ( $hlavicka->d1pom2 == 1 ) $t02="x";
if ( $hlavicka->d1pom3 == 1 ) $t03="x";
if ( $hlavicka->d1pom4 == 1 ) $t04="x";
if ( $hlavicka->d1pom5 == 1 ) $t05="x";
if ( $hlavicka->d1pom6 == 1 ) $t06="x";
if ( $hlavicka->d1pom7 == 1 ) $t07="x";
if ( $hlavicka->d1pom8 == 1 ) $t08="x";
if ( $hlavicka->d1pom9 == 1 ) $t09="x";
if ( $hlavicka->d1pom10 == 1 ) $t10="x";
if ( $hlavicka->d1pom11 == 1 ) $t11="x";
if ( $hlavicka->d1pom12 == 1 ) $t12="x";
if ( $hlavicka->d1pomc == 1 ) $tc="x";
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$t12","$rmc",1,"R");

//priezvisko a meno2
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->SetY(158);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d2pom1 == 1 ) $t01="x";
if ( $hlavicka->d2pom2 == 1 ) $t02="x";
if ( $hlavicka->d2pom3 == 1 ) $t03="x";
if ( $hlavicka->d2pom4 == 1 ) $t04="x";
if ( $hlavicka->d2pom5 == 1 ) $t05="x";
if ( $hlavicka->d2pom6 == 1 ) $t06="x";
if ( $hlavicka->d2pom7 == 1 ) $t07="x";
if ( $hlavicka->d2pom8 == 1 ) $t08="x";
if ( $hlavicka->d2pom9 == 1 ) $t09="x";
if ( $hlavicka->d2pom10 == 1 ) $t10="x";
if ( $hlavicka->d2pom11 == 1 ) $t11="x";
if ( $hlavicka->d2pom12 == 1 ) $t12="x";
if ( $hlavicka->d2pomc == 1 ) $tc="x";
$pdf->Cell(117,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$tc","$rmc",0,"C");
$pdf->Cell(5,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t01","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t02","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t03","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t04","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t05","$rmc",0,"L");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t06","$rmc",0,"C");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t07","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t08","$rmc",0,"C");
$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t09","$rmc",0,"C");$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$t10","$rmc",0,"R");
$pdf->Cell(2,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t11","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$t12","$rmc",1,"R");

//priezvisko a meno3
$pdf->Cell(195,4," ","$rmc1",1,"L");
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
$pdf->SetY(167);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d3pom1 == 1 ) $t01="x";
if ( $hlavicka->d3pom2 == 1 ) $t02="x";
if ( $hlavicka->d3pom3 == 1 ) $t03="x";
if ( $hlavicka->d3pom4 == 1 ) $t04="x";
if ( $hlavicka->d3pom5 == 1 ) $t05="x";
if ( $hlavicka->d3pom6 == 1 ) $t06="x";
if ( $hlavicka->d3pom7 == 1 ) $t07="x";
if ( $hlavicka->d3pom8 == 1 ) $t08="x";
if ( $hlavicka->d3pom9 == 1 ) $t09="x";
if ( $hlavicka->d3pom10 == 1 ) $t10="x";
if ( $hlavicka->d3pom11 == 1 ) $t11="x";
if ( $hlavicka->d3pom12 == 1 ) $t12="x";
if ( $hlavicka->d3pomc == 1 ) $tc="x";
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
$pdf->SetY(178);
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d4pom1 == 1 ) $t01="x";
if ( $hlavicka->d4pom2 == 1 ) $t02="x";
if ( $hlavicka->d4pom3 == 1 ) $t03="x";
if ( $hlavicka->d4pom4 == 1 ) $t04="x";
if ( $hlavicka->d4pom5 == 1 ) $t05="x";
if ( $hlavicka->d4pom6 == 1 ) $t06="x";
if ( $hlavicka->d4pom7 == 1 ) $t07="x";
if ( $hlavicka->d4pom8 == 1 ) $t08="x";
if ( $hlavicka->d4pom9 == 1 ) $t09="x";
if ( $hlavicka->d4pom10 == 1 ) $t10="x";
if ( $hlavicka->d4pom11 == 1 ) $t11="x";
if ( $hlavicka->d4pom12 == 1 ) $t12="x";
if ( $hlavicka->d4pomc == 1 ) $tc="x";
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
$pdf->Cell(190,40," ","$rmc1",1,"L");
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str3.jpg') )
{
$pdf->Image($jpg_source.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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

//VI.ODDIEL
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
//
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
//
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
//
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
//
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
//
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
//
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
//
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
//
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
//
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
//
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
//
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
//
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

//13.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t1p13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$hodx=100*$hlavicka->t1v13;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$pdf->Cell(190,17," ","$rmc1",1,"L");
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
$pdf->SetY(195);
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
$pdf->SetY(204);
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
//
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
//
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
                                       } //koniec 3.strany

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str4.jpg') )
{
$pdf->Image($jpg_source.'_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
//3.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
//
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

//4.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(190,85," ","$rmc1",1,"L");
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
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str5.jpg') )
{
$pdf->Image($jpg_source.'_str5.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str6.jpg') )
{
$pdf->Image($jpg_source.'_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(190,56," ","$rmc1",1,"L");
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
$pdf->Cell(190,29," ","$rmc1",1,"L");
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
$pdf->Cell(190,6," ","$rmc1",1,"L");
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

//3.riadok
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
                                       } //koniec 6.strany

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str7.jpg') )
{
$pdf->Image($jpg_source.'_str7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
//4.riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
//
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
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
//
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",1,"C");

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

//16riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p16;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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

//17riadok
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->t3p17;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$hodx=100*$hlavicka->t3v17;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
$pdf->Cell(190,94," ","$rmc1",1,"L");
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str8.jpg') )
{
$pdf->Image($jpg_source.'_str8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r92;
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

//polozka93
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
                                       } //koniec 8.strany

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str9.jpg') )
{
$pdf->Image($jpg_source.'_str9.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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

//polozka95
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r95;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka96
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka97
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka100
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka101
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka102
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka103
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka104
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka105
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka106
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka109
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r109;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka110
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka111
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r111;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka112
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r112;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka113
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r113;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka114
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r114;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka115
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r115;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka116
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r116;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka117
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r117;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka118
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r118;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka119
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r119;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");
                                       } //koniec 9.strany

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str10.jpg') )
{
$pdf->Image($jpg_source.'_str10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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

//IX.ODDIEL pokracovanie
//polozka120
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r120;
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
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka121
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r121;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(103,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//X.ODDIEL
//polozka122
$pdf->Cell(190,131," ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r122;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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

//polozka123
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r123;
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka124
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r124;
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka125
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r125;
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
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"L");

//polozka126
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r126;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 6s",$hodx);
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

//polozka127
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r127;
if ( $hodx == 0 ) $hodx="";
$znamienko="";
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 6s",$hodx);
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
//128stat rezidencie
$pdf->Cell(190,22," ","$rmc1",1,"L");
$text=$hlavicka->sdnr;
$t01=substr($text,0,1);
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

//polozka129
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r129;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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

//polozka130
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r130;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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
                                        } //koniec 10.strany

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str11.jpg') )
{
$pdf->Image($jpg_source.'_str11.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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

//polozka131
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r131;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
$t01=substr($text,0,1);
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

//polozka132
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->ldnr == 0 ) $text="";
$pdf->Cell(84,4," ","$rmc1",0,"R");$pdf->Cell(3,4,"$text","$rmc",0,"C");

//polozka133
$text="+0123456789";
$hodx=$hlavicka->nrzsprev;
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(94,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//XII.ODDIEL
//krizik neuplatnujem a splnam 3%
$pdf->Cell(190,29," ","$rmc1",1,"L");
$text="x"; if ( $hlavicka->upl50 == 0 ) $text=" ";
$text3="x"; if ( $hlavicka->spl3d == 0 ) $text3=" ";
$pdf->Cell(6,4," ","$rmc1",0,"R");$pdf->Cell(3,4,"$text","$rmc",0,"C");$pdf->Cell(49,4," ","$rmc1",0,"C");$pdf->Cell(3,4,"$text3","$rmc",1,"C");

//polozka134
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="01234567";
$hodx=100*$hlavicka->r134;
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

//135Prijimatel
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
$pdf->Cell(195,6," ","$rmc1",1,"L");
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
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zslu == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$text","$rmc",1,"C");

//XIII. ODDIEL
//uvadzam
$pdf->Cell(190,23," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->uoso == 1 ) $text="x";
$pdf->Cell(5,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//prijmy a vydavky nerezidenta
//kod statu1
$pdf->Cell(190,19," ","$rmc1",1,"L");
$text=$hlavicka->pzks1;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");
//druh prijmu1
$text1=$hlavicka->pdrp1;
$text2=$hlavicka->pdro1;
$text3=$hlavicka->pdrm1;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
$text3=$hlavicka->pdrm2;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
$text3=$hlavicka->pdrm3;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
$text3=$hlavicka->pdrm4;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
$text3=$hlavicka->pdrm5;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
$text3=$hlavicka->pdrm6;
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$text1","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$text3","$rmc",0,"C");
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
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
                                        } //koniec 11.strany

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str12.jpg') )
{
$pdf->Image($jpg_source.'_str12.jpg',0,0,210,297);
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

//osobitne zaznamy
$pdf->Cell(190,26," ","$rmc1",1,"L");
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
$pdf->SetY(191);
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
if ( $text == '00.00.0000' ) { $text="";}
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
$text1=" "; if ( $hlavicka->zdbo == 1 ) $text1="x";
$text3=" "; if ( $hlavicka->zpre == 1 ) $text3="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text1","$rmc",1,"R");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text3","$rmc",1,"R");

//postovou poukazkou ci na ucet
$pdf->Cell(190,5," ","$rmc1",1,"L");
$textp=" "; if ( $hlavicka->post == 1 ) $textp="x";
$textb=" "; if ( $hlavicka->ucet == 1 ) $textb="x";
$pdf->Cell(18,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textp","$rmc",0,"L");$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$textb","$rmc",1,"L");

//iban
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text=$hlavicka->diban;
$t01=substr($text,0,1);
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

//datum
$pdf->Cell(190,14," ","$rmc1",1,"L");
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
                                        } //koniec 12.strany

if ( $strana == 13 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str13.jpg') )
{
$pdf->Image($jpg_source.'_str13.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
                                        } //koniec 13.strany

if ( $strana == 14 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str14.jpg') )
{
$pdf->Image($jpg_source.'_str14.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic / rodne cislo
$pdf->Cell(195,1," ","$rmc1",1,"L");
$text="0123456789";
$text=$fir_fdic;
$t01=substr($text,0,1);
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
                                        } //koniec 14.strany

if ( $strana == 15 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str15.jpg') )
{
$pdf->Image($jpg_source.'_str15.jpg',0,0,210,297);
}
$pdf->SetY(10);


                                        } //koniec 15.strany



if ( $strana == 16 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str16.jpg') )
{
$pdf->Image($jpg_source.'_str16.jpg',0,0,210,297);
}
$pdf->SetY(10);


                                        } //koniec 16.strany
  }
$i = $i + 1;
  }
$pdf->Output("$outfilex");

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
if ( File_Exists($jpg_source.'_potvrdenie.jpg') )
{
$pdf->Image($jpg_source.'_potvrdenie.jpg',0,0,210,297);
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
$r68=$hlavicka->r68; if ( $r68 == 0 ) $r68="";
$r80=$hlavicka->r80; if ( $r80 == 0 ) $r80="";
$r105=$hlavicka->r105; if ( $r105 == 0 ) $r105="";
$r120=$hlavicka->r120; if ( $r120 == 0 ) { $r120=""; }
$r121=$hlavicka->r121; if ( $r121 == 0 ) { $r121=""; }
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r68","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,5,"$r80","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,5,"$r105","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,6,"$r120","$rmc",1,"R");
$pdf->Cell(190,0," ","$rmc1",1,"L");
$pdf->Cell(125,6," ","$rmc1",0,"L");$pdf->Cell(51,5,"$r121","$rmc",1,"R");

$pdf->Output("../tmp/potvrdfob$kli_vxcf.$kli_uzid.pdf");
                     } //koniec pdf potvrdenie
//exit;
?>

<?php if ( $xml == 0 ) { ?>
<script type="text/javascript"> var okno = window.open("<?php echo $outfilex; ?>","_self"); </script>
<?php                  } ?>

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
//   document.formv1.r86.value = '<?php echo $r86; ?>';
//   document.formv1.r87.value = '<?php echo $r87; ?>';
//   document.formv1.r88.value = '<?php echo $r88; ?>';
//   document.formv1.r89.value = '<?php echo $r89; ?>';
//   document.formv1.r90.value = '<?php echo $r90; ?>';
//   document.formv1.r91.value = '<?php echo $r91; ?>';
   document.formv1.r92.value = '<?php echo $r92; ?>';
//   document.formv1.r93.value = '<?php echo $r93; ?>';
//   document.formv1.r94.value = '<?php echo $r94; ?>';
<?php                                        } ?>

<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
   document.formv1.r95.value = '<?php echo $r95; ?>';
//   document.formv1.r96.value = '<?php echo $r96; ?>';
//   document.formv1.r97.value = '<?php echo $r97; ?>';
//   document.formv1.r98.value = '<?php echo $r98; ?>';
//   document.formv1.r99.value = '<?php echo $r99; ?>';
//   document.formv1.r100.value = '<?php echo $r100; ?>';
   document.formv1.r101.value = '<?php echo $r101; ?>';
   document.formv1.r102.value = '<?php echo $r102; ?>';
   document.formv1.r103.value = '<?php echo $r103; ?>';
//   document.formv1.r104.value = '<?php echo $r104; ?>';
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
   document.formv1.ozdr08.value = '<?php echo $ozdr08; ?>';
   document.formv1.ozdr10.value = '<?php echo $ozdr10; ?>';
//   document.formv1.ozdr11.value = '<?php echo $ozdr11; ?>';
//   document.formv1.ozdr12.value = '<?php echo $ozdr12; ?>';
   document.formv1.ozdr13.value = '<?php echo $ozdr13; ?>';
   document.formv1.ozdr14.value = '<?php echo $ozdr14; ?>';
//   document.formv1.ozdr15.value = '<?php echo $ozdr15; ?>';
//   document.formv1.ozdr16.value = '<?php echo $ozdr16; ?>';
//   document.formv1.ozdr17.value = '<?php echo $ozdr17; ?>';
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
   document.formv1.ozd1r24.value = '<?php echo $ozd1r24; ?>';
   document.formv1.ozd2r24.value = '<?php echo $ozd2r24; ?>';
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
   document.formv1.sz6.value = '<?php echo $sz6; ?>';
   document.formv1.sz7.value = '<?php echo $sz7; ?>';
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
    window.open('priznanie_fob2017.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=10&strana=' + strana + '&drupoh=1&subor=0', '_blank', blank_param);
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
   window.open('../ucto/priznanie_fob2017.php?strana=14&copern=209&drupoh=1&typ=PDF&dppo=1', '_self');
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
   window.open('../ucto/priznaniefob_xml2017.php?copern=110&sysx=UCT&drupoh=1&uprav=1', '_blank', blank_param);
  }
  function CisKrajin()
  {
   window.open('../cis/ciselnik_krajin.pdf', '_blank', blank_param);
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