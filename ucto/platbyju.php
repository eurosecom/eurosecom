<?php

$pdfand=200;
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
$jazyk=strtolower($poleu[13]);

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

$kli_vume=1*$_REQUEST['kli_vume'];
$kli_vduj=1*$_REQUEST['kli_vduj'];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$_REQUEST['h_dap']=$dnes;

$pdfand=1*$_REQUEST['pdfand'];
  }

if( $zandroidu == 0 )
  {
?>
<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=100420;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }


do
{

$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];
$chyby = 1*$_REQUEST['chyby'];
$zfak = 1*$_REQUEST['zfak'];

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$kli_brok=$kli_vrok+1;

$sqlt = "DROP TABLE F".$kli_vxcf."_platbyju".$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = <<<mzdprc
(
   ocx          INT(7) DEFAULT 0,
   prijmy          DECIMAL(10,2) DEFAULT 0,
   vydavky         DECIMAL(10,2) DEFAULT 0,
   poistne         DECIMAL(10,2) DEFAULT 0,
   zaklad          DECIMAL(10,2) DEFAULT 0,
   danprij         DECIMAL(10,2) DEFAULT 0,
   zaklaf          DECIMAL(10,2) DEFAULT 0,
   messp           DECIMAL(10,2) DEFAULT 0,
   meszp           DECIMAL(10,2) DEFAULT 0,
   celkspzp           DECIMAL(10,2) DEFAULT 0,
   konx         INT(7) DEFAULT 0
);
mzdprc;

$vsql = "CREATE TABLE F".$kli_vxcf."_platbyju".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$sql = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob ";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prijmy=$riaddok->t1p9;
  $vydavky=$riaddok->t1v9;
  $poistne=$riaddok->psp6;
  $zaklad=$riaddok->r78;
  $danprij=$riaddok->r92;

  }


$vsql = "INSERT INTO F".$kli_vxcf."_platbyju".$kli_uzid." (ocx, prijmy, vydavky, poistne ) VALUES ('1', '$prijmy', '$vydavky', '$poistne') ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=prijmy-vydavky WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=0 WHERE ocx = 1 AND zaklaf < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=zaklaf+poistne WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=zaklaf/12 WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");


$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET ".
" zaklad=$zaklad, ".
" danprij=$danprij ".
" WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");


if( $kli_vrok == 2014 )
  {
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=zaklaf/1.486 WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=402.50 WHERE ocx = 1 AND zaklaf < 402.50 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET zaklaf=4025 WHERE ocx = 1 AND zaklaf > 4025 ";
$vytvor = mysql_query("$vsql");
  }

$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET messp=zaklaf*35.15/100 WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET meszp=zaklaf*14/100 WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
$vsql = "UPDATE F".$kli_vxcf."_platbyju$kli_uzid SET celkspzp=messp+meszp WHERE ocx = 1 ";
$vytvor = mysql_query("$vsql");
?>
<?php
if( $zandroidu == 0 )
  { 
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Daò z pridanej hodnoty</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" >
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Platby dane z príjmu a odvodov do fondov SP a ZP pre budúci rok</td>
<td align="right">
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php
$sql = "SELECT * FROM F$kli_vxcf"."_platbyju$kli_uzid ";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);


?>


<table class="fmenu" width="100%" >
<tr><td class="bmenu" width="30%"></td><td class="bmenu" width="10%"><td class="bmenu" width="60%"></tr>

<tr>
<td class="bmenu" colspan="1">Prijmy <?php echo $kli_vrok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->prijmy; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Výdavky <?php echo $kli_vrok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->vydavky; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Základ dane</td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->zaklad; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Daò z príjmu <?php echo $kli_vrok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->danprij; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Zaplatené poistné <?php echo $kli_vrok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->poistne; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Mesaèný Vymeriavací základ odvodov do SP a ZP od 1.7.<?php echo $kli_brok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->zaklaf; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Mesaèné poistné 35,15% do SP od 1.7.<?php echo $kli_brok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->messp; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">Mesaèné poistné 14% do ZP od 1.7.<?php echo $kli_brok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->meszp; ?></td>
</tr>
<tr>
<td class="bmenu" colspan="1">CELKOM MESAÈNÉ POISTNÉ SP a ZP od 1.7.<?php echo $kli_brok; ?></td><td class="bmenu" colspan="1" align="right"><?php echo $riadok->celkspzp; ?></td>
</tr>
</table>

<?php
  }
?>
<?php



//odozva do androidu
if( $zandroidu == 1 )
{

$platitdph=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_platbyju".$kli_uzid." ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $platitdph=$riaddok->r31-$riaddok->r32;
    $r02=$riaddok->prijmy;
    $r04=$riaddok->vydavky;
    $r06=$riaddok->zaklad;
    $r08=$riaddok->danprij;
    $r10=$riaddok->poistne;
    $r12=$riaddok->zaklaf;
    $r14=$riaddok->messp;
    $r18=$riaddok->meszp;
    $r19=$riaddok->celkspzp;


    }

	$response = array();
	$response["products"] = array();
	$i=1;
	while( $i < 10 )
        {
        $product = array();
	$price=0; $pid="";

        if( $i ==  1 ) { $name="Prijmy $kli_vrok"; $price=$r02; $pid = "01.";}
        if( $i ==  2 ) { $name="Výdavky $kli_vrok"; $price=$r04; $pid = "02.";}
        if( $i ==  3 ) { $name="Základ dane"; $price=$r06; $pid = "03.";}
        if( $i ==  4 ) { $name="Daò z príjmu $kli_vrok"; $price=$r08; $pid = "04.";}
        if( $i ==  5 ) { $name="Zaplatené poistné $kli_vrok"; $price=$r10; $pid = "05.";}
        if( $i ==  6 ) { $name="Mesaèný Vymeriavací základ odvodov do SP a ZP od 1.7.$kli_brok"; $price=$r12; $pid = "06.";}
        if( $i ==  7 ) { $name="Mesaèné poistné 35,15% do SP od 1.7.$kli_brok"; $price=$r14; $pid = "07.";}
        if( $i ==  8 ) { $name="Mesaèné poistné 14% do ZP od 1.7.$kli_brok"; $price=$r18; $pid = "08.";}
        if( $i ==  9 ) { $name="CELKOM MESAÈNÉ POISTNÉ SP a ZP od 1.7.$kli_brok"; $price=$r19; $pid = "09.";}

	if( $jazyk != 'sk' )
            {
        if( $i ==  1 ) { $name="Incom $kli_vrok"; $price=$r02; $pid = "01.";}
        if( $i ==  2 ) { $name="Expense $kli_vrok"; $price=$r04; $pid = "02.";}
        if( $i ==  3 ) { $name="Tax base"; $price=$r06; $pid = "03.";}
        if( $i ==  4 ) { $name="Income tax $kli_vrok"; $price=$r08; $pid = "04.";}
        if( $i ==  5 ) { $name="Social and health insurance paid $kli_vrok"; $price=$r10; $pid = "05.";}
        if( $i ==  6 ) { $name="Monthly Basis of assessment for social and health insurance paid from 1.7.$kli_brok"; $price=$r12; $pid = "06.";}
        if( $i ==  7 ) { $name="Monthly social insurance 35,15% from 1.7.$kli_brok"; $price=$r14; $pid = "07.";}
        if( $i ==  8 ) { $name="Monthly health insurance 14% from 1.7.$kli_brok"; $price=$r18; $pid = "08.";}
        if( $i ==  9 ) { $name="MONTHLY HEALTH and SOCIAL INSURANCE from 1.7.$kli_brok"; $price=$r19; $pid = "09.";}
            }


        $name = iconv("CP1250", "UTF-8", $name);

	$product["pid"] = $pid;	
	$product["name"] = $name;
        $product["price"] = $price;
        $product["dat"] = "";
        $product["minplu"] = $platitdph;
	$product["kliuzid"] = $kli_uzid;
        $product["poh"] = 1;
        array_push($response["products"], $product);
	$i=$i+1;
	}

    	// success
    	$response["success"] = 1;
 
    	// echoing JSON response
    	echo json_encode($response);

exit;
}
//odozva do androidu




// celkovy koniec dokumentu
       } while (false);
?>
<?php
if( $zandroidu == 0 )
  { 
?>
</BODY>
</HTML>
<?php
  }
?>