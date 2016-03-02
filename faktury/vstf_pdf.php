<HTML>
<?php

$zandroidu=1*$_REQUEST['zandroidu'];
$anduct=1*$_REQUEST['anduct'];
if( $zandroidu == 1 AND $anduct == 0 )
  {
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }
//$serverx="www.ala.sk/androideshop";

$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//user
if (isset($_REQUEST['userx'])) { $userx = $_REQUEST['userx']; }
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

if( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;

$druhid=0;
$cuid=0;
$sqldok = mysql_query("SELECT * FROM F".DB_FIR."_ezak WHERE ez_id = $usidxxx ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=10;
    }
$sqldok = mysql_query("SELECT * FROM F".DB_FIR."_ezak WHERE ez_id = $usidxxx AND ez_heslo = '$pswdxxx' ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cuid=1*$riaddok->cuid;
    $druhid=20;
    }
$sqldok = mysql_query("SELECT * FROM klienti WHERE id_klienta = $cuid AND all_prav > 20000 ORDER BY id_klienta DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=99;
    }
if( $druhid < 20 ) { exit; }

//echo $kli_uzid;
//echo $kli_vxcf;
  }

if( $zandroidu == 1 AND $anduct == 1 )
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

$cislo_dok=0;
//user
$userx=$userxplus;
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];
$cislo_dok=1*$poleu[12];

//echo $userhash."<br />";
//echo $userx."<br />";
//exit;

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";

//nastav databazu
$kli_vrok=1*$_REQUEST['rokx'];
$kli_vxcf=1*$_REQUEST['firx'];
$dbsed="../".$adrsxxx."/nastavdbase.php";
$sDat = include("$dbsed");
mysql_select_db($databaza);
//echo $databaza." rok".$kli_vrok." fir".$kli_vxcf;
//exit;
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";

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

$cislo_dok = $_REQUEST['cislo_dok'];
  }


if( $zandroidu == 0 )
  {
$sys = 'FAK';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }

if(!isset($kli_vxcf)) { $kli_vxcf = 1; }

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = $_REQUEST['cislo_dok'];
$hladaj_dok = $_REQUEST['hladaj_dok'];
$mini = 1*$_REQUEST['mini'];
$h_pocpol = 1*$_REQUEST['h_pocpol'];
if( $h_pocpol <= 0 ) $h_pocpol=20;
$h_pocpol1s=$h_pocpol-1;

$dodaci = 1*$_REQUEST['dodaci'];
$predfaktura = 1*$_REQUEST['predfaktura'];
$bezcen=1*$_REQUEST['bezcen'];

$sysx = $_REQUEST['sysx'];
$rozuct = $_REQUEST['rozuct'];

//0=SK,1=D,2=GB
$jazyk = 1*$_REQUEST['jazyk'];

//echo "rozuct ".$rozuct."sysx ".$sysx;
//exit;
?>
<?php

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");

$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//ak je specialna faktura chod na nu
if (File_Exists ("../dokumenty/FIR$kli_vxcf/odber_faktura.jpg") AND $drupoh == 1 AND $sysx != 'UCT' ) 
{ 
//echo "je spec fak";
?>
<script type="text/javascript">
  var okno = window.open("../faktury/vstf_pdf<?php echo $fir_fico; ?>.php?copern=1&sysx=<?php echo $sysx; ?>
&drupoh=<?php echo $drupoh; ?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>","_self");
</script>
<?php

exit;
}
//koniec ak je specialna faktura chod na nu

$textza=0; $textnadpol=0; $textpodpol=0;
if( $drupoh == 1 OR $drupoh == 11 ) {
$sqlttt = "SELECT pmd, omd, pdl FROM F$kli_vxcf"."_fakturaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $textza=1*$riaddok->pmd;
  $textnadpol=1*$riaddok->omd;
  $textpodpol=1*$riaddok->pdl;
  }
                   }

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid."_".$hhmm;

 $outfilexdel="../tmp/f*_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/f".$cislo_dok."_".$idx.".pdf";

if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$kli_vxcfskl=$kli_vxcf;
if( $drupoh == 1 )
{
$tabl = "fakodb";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakodb";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 11 )
{
$tabl = "fakdol";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakdol";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
$dodaci=1;
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 12 )
{
$tabl = "dopdol";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopdol";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
$dodaci=1;
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 2 )
{
$tabl = "fakdod";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakodb";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctdod";
}
if( $drupoh == 31 )
{
$tabl = "dopfak";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopfak";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
}
if( $drupoh == 21 )
{
$tabl = "fakvnp";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakvnp";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 22 )
{
$tabl = "dopvnp";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopvnp";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 52 )
{
$tabl = "dopprf";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopprf";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$ucto = "uctodb";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
$predfaktura=1;
}

//tlac viac faktur naraz aj s rozuctovanim
$podmdok="F$kli_vxcf"."_$tabl.dok = ".$cislo_dok;
$podmdok1="F$kli_vxcf"."_prcupoh".$kli_uzid.".dok = ".$cislo_dok;

$pole = explode("-", $hladaj_dok);
$doklad1=1*$pole[0];
$doklad2=1*$pole[1];
$viacnaraz=0;
if( $doklad1 > 0 AND $doklad2 > 0 ) 
{
$podmdok="F$kli_vxcf"."_$tabl.dok >= ".$doklad1." AND F$kli_vxcf"."_$tabl.dok <= ".$doklad2;
$podmdok1="F$kli_vxcf"."_prcupoh".$kli_uzid.".dok >= ".$doklad1." AND F$kli_vxcf"."_prcupoh".$kli_uzid.".dok <= ".$doklad2;
$viacnaraz=1;
}


//zaokruhlenie
if( $viacnaraz == 0 AND $mini == 0 AND $sysx != 'UCT' )
{
//echo "zaokruhlujem";
$sZao = include("../funkcie/zaokruhli_hod.php");
$sZad = include("../funkcie/zaokruhli_dph.php");

$sqlttt = "DROP TABLE F$kli_vxcf"."_faksluprc$kli_uzid  ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "CREATE TABLE F$kli_vxcf"."_faksluprc$kli_uzid SELECT * FROM F$kli_vxcf"."_fakslu WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F$kli_vxcf"."_faksluprc$kli_uzid ADD hodb DECIMAL(10,2) DEFAULT 0 AFTER datm ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_faksluprc$kli_uzid SET hodb=cep*mno ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "DROP TABLE F$kli_vxcf"."_sklfakprc$kli_uzid  ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "CREATE TABLE F$kli_vxcf"."_sklfakprc$kli_uzid SELECT * FROM F$kli_vxcfskl"."_sklfak WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F$kli_vxcf"."_sklfakprc$kli_uzid ADD hodb DECIMAL(10,2) DEFAULT 0 AFTER datm ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_sklfakprc$kli_uzid SET hodb=cep*mno ";
$sqldok = mysql_query("$sqlttt");
}

$lenstlpecbezdph=0;
if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk"  ) { $lenstlpecbezdph=1; } 
//if( $_SERVER['SERVER_NAME'] == "localhost"  ) { $lenstlpecbezdph=1; } 

$prepoc=0;
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 42 )
{
$prepoczk2=1;
if( $_SERVER['SERVER_NAME'] == "www.ala.sk" OR $_SERVER['SERVER_NAME'] == "www.smmgbely.sk"  ) { $prepoczk2=1; } 
if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $prepoczk2=1; } 
if( $_SERVER['SERVER_NAME'] == "www.eshoptest.sk" ) { $prepoczk2=1; } 
if( $_SERVER['SERVER_NAME'] == "www.eshopp3service.sk" ) { $prepoczk2=1; } 
if( $_SERVER['SERVER_NAME'] == "localhost" ) { $prepoczk2=1; } 
if( $viacnaraz == 1 ) { $prepoczk2=0; } 
if( $drupoh != 1 ) { $prepoczk2=0; } 
if( $sysx == 'UCT' ) { $prepoczk2=0; } 
if( $viacnaraz == 0 AND $mini == 0 AND $sysx != 'UCT' AND $drupoh == 1 AND $prepoczk2 == 1 )
     {
//echo "idem";
$prepoc=1;
$zaklad2s=0;
$sqlttt = "SELECT SUM(hodb) AS zaklad2s FROM F$kli_vxcf"."_faksluprc$kli_uzid WHERE dok = $cislo_dok AND dph = $fir_dph2 GROUP BY dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->zaklad2s;
  }
$zaklad2t=0;
$sqlttt = "SELECT SUM(hodb) AS zaklad2t FROM F$kli_vxcf"."_sklfakprc$kli_uzid WHERE dok = $cislo_dok AND dph = $fir_dph2 GROUP BY dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2t=1*$riaddok->zaklad2t;
  }
$zk2=0;
$sqlttt = "SELECT zk2 FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zk2=1*$riaddok->zk2;
  }

if( $kli_uzid == 171717171717 )
{
//echo $zaklad2s." ".$zaklad2t." ".$zk2;
//exit;
}
$rozdiel=$zk2-$zaklads2-$zakladt2;

$sqlttt = "UPDATE F$kli_vxcf"."_fakodb SET zk2=($zaklad2s+$zaklad2t)  WHERE dok = $cislo_dok ";
if( $rozdiel != 0 ) { $sqldok = mysql_query("$sqlttt"); }
     }

if( $viacnaraz == 0 AND $mini == 0 AND $sysx != 'UCT' )
     {
$zad = zaokruhli_dph("1", $kli_vxcf, $tabl, $cislo_dok, $vyb_rok);
$zao = zaokruhli_hod($fir_xfa02, $kli_vxcf, $tabl, $cislo_dok);
     }
}

$cituc="";
if ( $rozuct == 'ANO' ) $cituc=", zk0u,zk1u,zk2u,dn1u,dn2u,hodu";

$citzmen="";
if ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 2 ) { $citzmen=",zmen,mena,kurz,hodm,sz3,dav"; }

if ( $copern == 20 AND $drupoh != 1 AND $drupoh != 2 AND $drupoh != 31 AND $drupoh != 11 AND $drupoh != 12 AND $drupoh != 52 AND $drupoh != 21 AND $drupoh != 22 )
{
$sqltt = "SELECT uce, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, DATE_FORMAt(daz, '%d.%m.%Y' ) AS daz,".
" DATE_FORMAt(das, '%d.%m.%Y' ) AS das, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, dol, prf, poz, F$kli_vxcf"."_$tabl.str, F$kli_vxcf"."_$tabl.zak,".
" DATE_FORMAt(F$kli_vxcf"."_$tabl.datm, '%d.%m.%Y' ) AS datm, TIME_FORMAt(F$kli_vxcf"."_$tabl.datm, '%H:%i' ) AS timm,".
" txp, txz, ksy, ssy, zk1, dn1, zk2, dn2, zk0, hod, zal, ruc, zao, obj, unk, dpr, sp1, sp2, poz, ".
" id, meno, priezvisko, F$kli_vxcf"."_ico.uli, F$kli_vxcf"."_ico.psc, F$kli_vxcf"."_ico.mes, uc1, nm1, ib1, ".
" F$kli_vxcf"."_ico.dic, F$kli_vxcf"."_ico.icd, strv, zakv, nza, F$kli_vxcf"."_ico.na2".$cituc.$citzmen.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$tabl.id=klienti.id_klienta".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_$tabl.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_$tabl.zak=F$kli_vxcf"."_zak.zak".
" WHERE $podmdok ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if ( $copern == 20 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) )
{
$sqltt = "SELECT uce, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, DATE_FORMAt(daz, '%d.%m.%Y' ) AS daz, dpr,".
" DATE_FORMAt(das, '%d.%m.%Y' ) AS das, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, dol, prf, poz, F$kli_vxcf"."_$tabl.str, F$kli_vxcf"."_$tabl.zak,".
" DATE_FORMAt(F$kli_vxcf"."_$tabl.datm, '%d.%m.%Y' ) AS datm, TIME_FORMAt(F$kli_vxcf"."_$tabl.datm, '%H:%i' ) AS timm,".
" txp, txz, ksy, ssy, zk1, dn1, zk2, dn2, zk0, hod, zal, ruc, zao, obj, unk, dpr, sp1, sp2, poz, ".
" id, meno, priezvisko, F$kli_vxcf"."_ico.uli, F$kli_vxcf"."_ico.psc, F$kli_vxcf"."_ico.mes,  F$kli_vxcf"."_icoodbm.odbm, onai, ona2, ouli, opsc, omes, ".
" F$kli_vxcf"."_ico.dic, F$kli_vxcf"."_ico.icd, strv, zakv, nza, F$kli_vxcf"."_ico.na2".$cituc.$citzmen.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$tabl.id=klienti.id_klienta".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_$tabl.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_$tabl.zak=F$kli_vxcf"."_zak.zak".
" LEFT JOIN F$kli_vxcf"."_icoodbm".
" ON F$kli_vxcf"."_$tabl.odbm=F$kli_vxcf"."_icoodbm.odbm AND F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_icoodbm.ico ".
" WHERE $podmdok ORDER BY dok".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");

//exit;
}

if ( $copern == 20 AND ( $drupoh == 21 OR $drupoh == 22 ) )
{
$sqltt = "SELECT uce, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, DATE_FORMAt(daz, '%d.%m.%Y' ) AS daz,".
" DATE_FORMAt(das, '%d.%m.%Y' ) AS das, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, dol, prf, poz, F$kli_vxcf"."_$tabl.str, F$kli_vxcf"."_$tabl.zak,".
" DATE_FORMAt(F$kli_vxcf"."_$tabl.datm, '%d.%m.%Y' ) AS datm, TIME_FORMAt(F$kli_vxcf"."_$tabl.datm, '%H:%i' ) AS timm,".
" txp, txz, ksy, ssy, zk1, dn1, zk2, dn2, zk0, hod, zal, ruc, zao, obj, unk, dpr, sp1, sp2,".
" id, meno, priezvisko, F$kli_vxcf"."_ico.uli, F$kli_vxcf"."_ico.psc, F$kli_vxcf"."_ico.mes, ".
" F$kli_vxcf"."_ico.dic, F$kli_vxcf"."_ico.icd, strv, zakv, nza, F$kli_vxcf"."_ico.na2".$cituc.$citzmen.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$tabl.id=klienti.id_klienta".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_$tabl.zak=F$kli_vxcf"."_zak.zak".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";

$sql = mysql_query("$sqltt");

//exit;
}

$j=0;
$ih=0;

$hlpol = mysql_num_rows($sql);

//zaciatok citania hlaviciek
while ($ih <= $hlpol )
{

  if (@$zaznam=mysql_data_seek($sql,$ih))
  {
  $hlavicka=mysql_fetch_object($sql);

//hlavicka
if( $j == 0 )
          {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

//logo
if( $mini == 0 AND $drupoh == 1 AND $rozuct != 'ANO' )
          {

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg'))
{
$rozmerhlv1="50"; $rozmerhlv2="50"; $rozmerhlv3="20"; $rozmerhlv4="20";

$sirka=0; $vyska=0; $zhora=0; $zlava=0; $logoano=0;
$sqlttt = "SELECT zdl,ico1,ico2,ico3,ico4 FROM F$kli_vxcf"."_fakturaset ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $logoano=1*$riaddok->zdl; $sirka=1*$riaddok->ico1; $vyska=1*$riaddok->ico2; $zlava=1*$riaddok->ico3; $zhora=1*$riaddok->ico4;
  }

if( $sirka > 0 AND $vyska > 0 AND $zhora > 0 AND $zlava > 0 ) { $rozmerhlv1=$zlava+""; $rozmerhlv2=$zhora+""; $rozmerhlv3=$sirka+""; $rozmerhlv4=$vyska+""; }

if( $logoano == 1 ) { $pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4); }
}
          }
//koniec logo

$chcemhlavicku=1;
if( $drupoh == 1  ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaodb.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 2  ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickadod.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 21 ) { $chcemhlavicku=0; }  
if( $drupoh == 22 ) { $chcemhlavicku=0; }
if( $drupoh == 52 ) { $chcemhlavicku=1; }

$niejehlavicka=1;
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') AND $chcemhlavicku == 1 )
{
$niejehlavicka=0;
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="180"; $rozmerhlv4="20"; 
if( $esoplast == 1 ) { $rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="180"; $rozmerhlv4="14";  }

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}

//ak zahranicna faktura
$fakturadanovy="F  A  K  T  Ú  R  A   -   Daòový doklad ";
$cislofak="Èíslo:";
$dodavatel="Dodávate¾";
$odberatel="Odberate¾";
$ico="IÈO:";
$dic="DIÈ:";
$icdph="IÈ DPH:";
$registrovany="Registrovaný";
$fakprevzal="Faktúru prevzal (meno,ÈOP,podpis)"; 
$bankovespojenie="Bankové spojenie dodávate¾a:";
$odberne="Odberné miesto:";
$vyhotovena="Dátum vyhotovenia: ";
$variabilny="Variabilný symbol: ";
$dodane="Dátum dodania: ";
if( $drupoh == 2 ) { $dodane="Dátum dodania - odpoètu: "; }
$konstantny="Konštantný symbol: ";
$splatna="Dátum splatnosti: ";
$specificky="Špecifický symbol: ";
$objednavkauni="Objednávka - UNIkód: ";
$dodacipredfak="Dod.list - Predfaktúra: ";
$strzakdok="STR - ZÁK - Doklad: ";
$doprava="Doprava: ";
$polozka="Položka"; 
$sadzbadph="DPH";
$jcenabezdph="J.CENAbDPH";
$jcenasdph="J.CENAsDPH";
$mnozstvo="Množstvo";
$mj="MJ";
$hodnotabezdph="HODN. bez DPH";
$hodnotasdph="HODN. s DPH";
if( $lenstlpecbezdph == 1 ) { $hodnotasdph="HODN. bez DPH"; $hodnotabezdph="           "; } 
$rozpisdph="Rozpis DPH";
$percentodph="% DPH";
$zakladdph="Základ";
$sumadph="Daò";
$spolusdph="Spolu";
$celkomhodnota="Celkom hodnota";
$vystavil="Vystavil(a):";
$cenapoloziek="ceny položiek v ";
$kurz="kurz";
$celkomvmene="Celkom hodnota"; 

if( $jazyk == 1 )
{
$fakturadanovy="Faktúra / Rechnung";
$cislofak="Èíslo / Nr.:";
$dodavatel="Dodávate¾ / Lieferant";
$odberatel="Odberate¾ / Abnehmer";
$ico="IÈO / ID-Nr:";
$dic="DIÈ";
$icdph="IÈDPH/UStID:";
$registrovany="Registrovaný / Handelregister/Gewerbenummer";
$fakprevzal="";
$bankovespojenie="Bankové spojenie dodávate¾a / Lieferant - Bank:";
$odberne="Odberné miesto / Entnahmestelle:";
$vyhotovena="D.vystav. / Ausstellungsdat.:";
$variabilny="Var. symbol / Variabelsym.:";
$dodane="D.dodania / Leistungsdat.:";
$konstantny="Konš. symbol / Konst. Sym.:";
$splatna="D.splatnosti / Fälligkeitsdat.:";
$specificky="Špec. symbol / Spec.Sym.:";
$objednavkauni="Objednávka / Bestellung:";
$dodacipredfak="Dodací-Predf./Lieferschein.:";
$strzakdok="STR - ZÁK - Doklad:";
$doprava="Doprava / Transport:";
$polozka="Artikel";
$sadzbadph="MwSt";
$jcenabezdph="E-Preis";
$jcenasdph="E-Preis+MwSt";
$mnozstvo="Menge";
$mj="Einheit";
$hodnotabezdph="Gesamtpreis";
$hodnotasdph="Gesamtpr.+MwSt";
$rozpisdph="";
$percentodph="% MwSt";
$zakladdph="Gesamt netto";
$sumadph="MwSt-Betrag";
$spolusdph="Gesamt brutto";
$celkomhodnota="Spolu na úhradu / Gesamt zahlungsbetrag";
$vystavil="Vystavil(a) / Ausgestellt von:";
$cenapoloziek="preises in ";
$kurz="kurz/der kurs"; 
$celkomvmene="Celkom hodnota/Gesamt";

}

if( $jazyk == 2 )
{
$fakturadanovy="Faktúra / Invoice";
$cislofak="Èíslo / No.";
$dodavatel="Dodávate¾ / Supplier";
$odberatel="Odberate¾ / Customer";
$ico="IÈO / ID #";
$dic="DIÈ";
$icdph="IÈDPH/VAT No.";
$registrovany="Registrovaný / Register";
$fakprevzal="";
$bankovespojenie="Bankové spojenie dodávate¾a / Supplier - Bank contact:";
$odberne="Odberné miesto / Place of delivery:";
$vyhotovena="D.vystav. / Issue date:";
$variabilny="Var. sym. / Var. symbol:";
$dodane="D.dodania / Shipment date:";
$konstantny="Konš.sym. / Const. symbol:";
$splatna="D.splatnosti / Due date:";
$specificky="Špec.symbol/Spec.Sym.:";
$objednavkauni="Objednávka / Order No.:";
$dodacipredfak="Dodací-Predf/Bill of delivery:";
$strzakdok="STR - ZÁK - Doklad:";
$doprava="Doprava / Ship Via:";
$polozka="Item";
$sadzbadph="VAT rate";
$jcenabezdph="Unit Cost";
$jcenasdph="Unit Cost+VAT";
$mnozstvo="Quantity";
$mj="Unit";
$hodnotabezdph="Sub-Total";
$hodnotasdph="Sub-Total+VAT";
$rozpisdph="Rozpis DPH";
$percentodph="%DPH / %VAT";
$zakladdph="Základ/Tax basis";
$sumadph="Daò / VAT";
$spolusdph="Spolu / Total";
$celkomhodnota="Spolu na úhradu / TOTAL PAYABLE";
$vystavil="Vystavil(a) / Execute by:";
$cenapoloziek="prices in ";
$kurz="kurz/rate of exchange"; 
$celkomvmene="Celkovo/Invoice Total";

}

//len odberatelske
if( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 21 OR $drupoh == 22 OR $drupoh == 52 )
     {
$pdf->SetY(30);

if( $mini == 0 )
          {
if( $dodaci == 0 AND $predfaktura == 0 AND $drupoh != 21 AND $drupoh != 22 )
  {
$pdf->Cell(90,6,"$fakturadanovy","1",0,"L");$pdf->Cell(45,6,"$cislofak","1",0,"R");$pdf->Cell(45,6,"$hlavicka->fak ","1",1,"L");
  }

if( $dodaci == 1 )
  {
$dodacicislo=1*$hlavicka->dol;
if( $dodacicislo == 0 ) $dodacicislo="9".$hlavicka->fak;
$pdf->Cell(90,6,"DODACÍ LIST  -  Nie je daòový doklad","1",0,"L");$pdf->Cell(45,6,"Èíslo:","1",0,"R");$pdf->Cell(45,6,"$dodacicislo ","1",1,"L");

$fakprevzal="";
  }

if( $drupoh == 21 OR $drupoh == 22 )
  {
$pdf->Cell(120,6,"VNÚTROPODNIKOVÁ FAKTÚRA  -  Nie je daòový doklad","1",0,"L");$pdf->Cell(30,6,"Èíslo:","1",0,"R");$pdf->Cell(30,6,"$hlavicka->fak ","1",1,"L");

$fakprevzal="";
  }

if( $predfaktura == 1 )
  {
$prfcislo=1*$hlavicka->prf;
if( $prfcislo == 0 ) $prfcislo="8".$hlavicka->fak;
$pdf->Cell(90,6,"PREDFAKTÚRA  -  Nie je daòový doklad","1",0,"L");$pdf->Cell(45,6,"Èíslo:","1",0,"R");$pdf->Cell(45,6,"$prfcislo ","1",1,"L");

$fakprevzal="PredFaktúru prevzal(meno,ÈOP,podpis)";
  }

if( $kli_uzid == 1717171717171717 )
  {
$hlavicka->ico=44811462;
$hlavicka->nai="BUSINESS RELATIONS s.r.o.";
$hlavicka->uli="Štefánikova 715";
$hlavicka->psc="90501";
$hlavicka->mes="Senica";
$hlavicka->dic="2022858728";
$hlavicka->icd="SK2022858728";
  }

$icoodber=$hlavicka->ico;
if( $hlavicka->ico == 313114 ) { $icoodber="00313114"; }

$pdf->Cell(180,3,"     ","0",1,"L");
$pdf->Cell(90,6,"$dodavatel","1",0,"L");$pdf->Cell(90,6,"$odberatel","1",1,"L");
$pdf->Cell(90,6,"$ico $fir_fico","0",0,"L");$pdf->Cell(90,6,"$ico $icoodber ","0",1,"L");
$pdf->Cell(90,6,"$fir_fnaz ","0",0,"L");

$nazov1r=$hlavicka->nai;
$nazov2r=$hlavicka->na2;
$dlzkana2=strlen($hlavicka->na2);
if( $dlzkana2 < 10 ) { $nazov1r=$hlavicka->nai.$hlavicka->na2; $nazov2r=""; }

$pdf->Cell(90,6,"$nazov1r ","0",1,"L");
if( $nazov2r != "" )
  {
$pdf->Cell(90,6,"          ","0",0,"L");$pdf->Cell(90,6,"$nazov2r ","0",1,"L");
  }

$pdf->Cell(90,6,"$fir_fuli $fir_fcdm","0",0,"L");$pdf->Cell(90,6,"$hlavicka->uli ","0",1,"L");
$pdf->Cell(90,6,"$fir_fpsc $fir_fmes","0",0,"L");$pdf->Cell(90,6,"$hlavicka->psc $hlavicka->mes","0",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");

if( $drupoh != 21 AND $drupoh != 22 ) {

$pdf->Cell(90,4,"$dic $fir_fdic $icdph $fir_ficd","0",0,"L");$pdf->Cell(90,4,"$dic $hlavicka->dic $icdph $hlavicka->icd","0",1,"L");
$pdf->Cell(90,4,"Tel: $fir_ftel Fax: $fir_ffax","0",0,"L");$pdf->Cell(90,4," ","0",1,"L");

$webtext="web: $fir_fwww email: $fir_fem1";
$dlzkaweb=strlen($webtext);
if( $dlzkaweb > 40 ) { $pdf->SetFont('arial','',8); }
if( $dlzkaweb > 45 ) { $pdf->SetFont('arial','',7); }
$pdf->Cell(90,4,"$webtext","0",0,"L");$pdf->Cell(90,4,"    ","0",1,"L");
$pdf->SetFont('arial','',10);

$registtext=$registrovany.": ".$fir_obreg;
$dlzkareg=strlen($registtext);
if( $dlzkareg > 40 ) { $pdf->SetFont('arial','',8); }
if( $dlzkareg > 45 ) { $pdf->SetFont('arial','',7); }
$pdf->Cell(90,4,"$registtext","0",0,"L");
$pdf->SetFont('arial','',10);

$pdf->Cell(90,4,"$fakprevzal","0",1,"L");
$pdf->Cell(180,1," ","T",1,"L");
//$pdf->Line(15, 90, 195, 90); 
//$pdf->SetY(92);
$pdf->Cell(180,4,"$bankovespojenie","0",1,"L");

$pdf->SetFont('arial','',9);
if( $fir_uc1fk == 1 )
{

$ibanoc=str_replace(" ","",$fir_fib1);
$ibanoc1 = substr($ibanoc,0,4);
$ibanoc2 = substr($ibanoc,4,4);
$ibanoc3 = substr($ibanoc,8,4);
$ibanoc4 = substr($ibanoc,12,4);
$ibanoc5 = substr($ibanoc,16,4);
$ibanoc6 = trim(substr($ibanoc,20,20));

$fir_fib1=$ibanoc1." ".$ibanoc2." ".$ibanoc3." ".$ibanoc4." ".$ibanoc5." ".$ibanoc6;


if( $fir_fsw1 == '' ) { $pdf->Cell(180,4,"IBAN: $fir_fib1 úèet: $fir_fuc1 / $fir_fnm1 $fir_fnb1","0",1,"L"); }
if( $fir_fsw1 != '' AND $jazyk == 0 ) { $pdf->Cell(180,4,"IBAN: $fir_fib1 SWIFT: $fir_fsw1 úèet: $fir_fuc1 / $fir_fnm1 $fir_fnb1 ","0",1,"L"); }

if( $jazyk    >  0  ) { $pdf->Cell(180,4,"IBAN: $fir_fib1 SWIFT: $fir_fsw1 $fir_fnb1 ","0",1,"L"); }
}

if( ( $fir_fuc2 != '' OR $fir_fib2 != '' ) AND $fir_uc2fk == 1 )
{

$ibanoc=str_replace(" ","",$fir_fib2);
$ibanoc1 = substr($ibanoc,0,4);
$ibanoc2 = substr($ibanoc,4,4);
$ibanoc3 = substr($ibanoc,8,4);
$ibanoc4 = substr($ibanoc,12,4);
$ibanoc5 = substr($ibanoc,16,4);
$ibanoc6 = trim(substr($ibanoc,20,20));

$fir_fib2=$ibanoc1." ".$ibanoc2." ".$ibanoc3." ".$ibanoc4." ".$ibanoc5." ".$ibanoc6;

if( $fir_fsw2 == '' ) { $pdf->Cell(180,4,"IBAN: $fir_fib2 úèet: $fir_fuc2 / $fir_fnm2 $fir_fnb2","0",1,"L"); }
if( $fir_fsw2 != '' AND $jazyk == 0 ) { $pdf->Cell(180,4,"IBAN: $fir_fib2 SWIFT: $fir_fsw2 úèet: $fir_fuc2 / $fir_fnm2 $fir_fnb2","0",1,"L"); }
if( $jazyk    >  0  ) { $pdf->Cell(180,4,"IBAN: $fir_fib2 SWIFT: $fir_fsw2 $fir_fnb2 ","0",1,"L"); }
}

if( ( $fir_fuc3 != '' OR $fir_fib3 != '' )  AND $fir_uc3fk == 1 )
{

$ibanoc=str_replace(" ","",$fir_fib3);
$ibanoc1 = substr($ibanoc,0,4);
$ibanoc2 = substr($ibanoc,4,4);
$ibanoc3 = substr($ibanoc,8,4);
$ibanoc4 = substr($ibanoc,12,4);
$ibanoc5 = substr($ibanoc,16,4);
$ibanoc6 = trim(substr($ibanoc,20,20));

$fir_fib3=$ibanoc1." ".$ibanoc2." ".$ibanoc3." ".$ibanoc4." ".$ibanoc5." ".$ibanoc6;

if( $fir_fsw3 == '' ) { $pdf->Cell(180,4,"IBAN: $fir_fib3 úèet: $fir_fuc3 / $fir_fnm3 $fir_fnb3","0",1,"L"); }
if( $fir_fsw3 != '' AND $jazyk == 0 ) { $pdf->Cell(180,4,"IBAN: $fir_fib3 SWIFT: $fir_fsw3 úèet: $fir_fuc3 / $fir_fnm3 $fir_fnb3","0",1,"L"); }
if( $jazyk    >  0  ) { $pdf->Cell(180,4,"IBAN: $fir_fib3 SWIFT: $fir_fsw3 $fir_fnb3 ","0",1,"L"); }
}

$pdf->SetFont('arial','',10);
$pdf->Cell(180,1,"","B",1,"L");
                    }
//koniec ak drupoh!=21,22

if( ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) AND $hlavicka->odbm > 0 )
{
$odbmtlac="$odberne $hlavicka->odbm, $hlavicka->onai$hlavicka->ona2, $hlavicka->ouli, $hlavicka->omes ";
$dlzkaodbm=1*strlen($odbmtlac);

if( $dlzkaodbm > 80 ) { $pdf->SetFont('arial','',8); }
$pdf->Cell(180,7,"$odbmtlac","B",1,"L");
$pdf->SetFont('arial','',9);
}
          }

if( $mini == 1 )
          {
if( $niejehlavicka == 1 )
  {
$pdf->Cell(90,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc ","0",0,"L");
$pdf->Cell(90,6,"IÈO: $fir_fico","0",1,"R");

$registtext="Registrovaný: ".$fir_obreg;
$dlzkareg=strlen($registtext);
if( $dlzkareg > 40 ) { $pdf->SetFont('arial','',8); }
if( $dlzkareg > 45 ) { $pdf->SetFont('arial','',7); }
$pdf->Cell(90,6,"$registtext","0",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"DIÈ: $fir_fdic, IÈDPH: $fir_ficd","0",1,"R");
  }

$pdf->Cell(90,6,"Ú è t o v n ý  d o k l a d ","1",0,"L");$pdf->Cell(45,6,"Èíslo:","1",0,"R");$pdf->Cell(45,6,"$hlavicka->dok ","1",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");
$pdf->Cell(0,6,"Odberate¾: IÈO: $hlavicka->ico, $hlavicka->nai, $hlavicka->uli, $hlavicka->mes, $hlavicka->psc, ièDPH $hlavicka->icd","0",1,"L");

if( $hlavicka->odbm > 0 )
{
$icd2="";
$sqlttt = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm WHERE ico = $hlavicka->ico AND odbm = $hlavicka->odbm ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icd2=", icDPH ".$riaddok->icd2;
  }
$odbmtlac="$odberne $hlavicka->odbm, $hlavicka->onai$hlavicka->ona2, $hlavicka->ouli, $hlavicka->omes ";
$dlzkaodbm=1*strlen($odbmtlac);

if( $dlzkaodbm > 80 ) { $pdf->SetFont('arial','',8); }
$pdf->Cell(180,7,"$odbmtlac","B",1,"L");
$pdf->SetFont('arial','',9);
}

          }

     }
//koniec len odberatelske

//len dodavatelske
if( $drupoh == 2  )
     {
$pdf->SetY(30);

if( $mini == 0 )
          {
$pdf->Cell(90,6,"Dodávate¾ská F  A  K  T  Ú  R  A  ","1",0,"L");$pdf->Cell(45,6,"Èíslo:","1",0,"R");$pdf->Cell(45,6,"$hlavicka->fak ","1",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");

$pdf->Cell(90,6,"Dodávate¾:","1",0,"L");$pdf->Cell(90,6,"Odberate¾:","1",1,"L");
$pdf->Cell(90,6,"IÈO: $hlavicka->ico","0",0,"L");$pdf->Cell(90,6,"IÈO: $fir_fico ","0",1,"L");
$pdf->Cell(90,6,"$hlavicka->nai ","0",0,"L");$pdf->Cell(90,6,"$fir_fnaz ","0",1,"L");
$pdf->Cell(90,6,"$hlavicka->uli","0",0,"L");$pdf->Cell(90,6,"$fir_fuli $fir_fcdm ","0",1,"L");
$pdf->Cell(90,6,"$hlavicka->psc $hlavicka->mes","0",0,"L");$pdf->Cell(90,6,"$fir_fpsc $fir_fmes","0",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");
$pdf->Cell(90,4,"DIÈ: $hlavicka->dic IÈDPH: $hlavicka->icd","0",0,"L");$pdf->Cell(90,4,"DIÈ: $fir_fdic IÈDPH: $fir_ficd","0",1,"L");

$pdf->Line(15, 90, 195, 90); 
$pdf->SetY(92);
$pdf->Cell(180,4,"Bankové spojenie dodávate¾a:","0",1,"L");
$pdf->Cell(180,4,"úèet: $hlavicka->uc1 / $hlavicka->nm1 IBAN: $hlavicka->ib1 ","0",1,"L");

$pdf->Cell(180,1,"","B",1,"L");

if( ( $drupoh == 2 ) AND $hlavicka->odbm > 0 )
{
$icd2="";
$sqlttt = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm WHERE ico = $hlavicka->ico AND odbm = $hlavicka->odbm ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icd2=", icDPH ".$riaddok->icd2;
  }

$odbmtlac="$odberne $hlavicka->odbm, $hlavicka->onai$hlavicka->ona2, $hlavicka->ouli, $hlavicka->omes, $hlavicka->opsc$icd2";
$dlzkaodbm=1*strlen($odbmtlac);

if( $dlzkaodbm > 80 ) { $pdf->SetFont('arial','',8); }
$pdf->Cell(180,7,"$odbmtlac","B",1,"L");
$pdf->SetFont('arial','',9);
}


          }

if( $mini == 1 )
          {
if( $niejehlavicka == 1 )
  {
$pdf->Cell(90,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc ","0",0,"L");
$pdf->Cell(90,6,"IÈO: $fir_fico","0",1,"R");

$registtext="Registrovaný: ".$fir_obreg;
$dlzkareg=strlen($registtext);
if( $dlzkareg > 40 ) { $pdf->SetFont('arial','',8); }
if( $dlzkareg > 45 ) { $pdf->SetFont('arial','',7); }
$pdf->Cell(90,6,"$registtext","0",0,"L");
$pdf->SetFont('arial','',10);

$pdf->Cell(90,6,"DIÈ: $fir_fdic, IÈDPH: $fir_ficd","0",1,"R");
  }
$pdf->Cell(90,6,"Ú è t o v n ý  d o k l a d","1",0,"L");$pdf->Cell(45,6,"Èíslo:","1",0,"R");$pdf->Cell(45,6,"$hlavicka->dok ","1",1,"L");
$pdf->Cell(180,3,"     ","0",1,"L");
$pdf->Cell(0,6,"Dodávate¾: IÈO: $hlavicka->ico, $hlavicka->nai, $hlavicka->uli, $hlavicka->mes, $hlavicka->psc, ièDPH $hlavicka->icd","0",1,"L");

if( $hlavicka->odbm > 0 )
{
$icd2="";
$sqlttt = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm WHERE ico = $hlavicka->ico AND odbm = $hlavicka->odbm ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icd2=", icDPH ".$riaddok->icd2;
  }

$odbmtlac="$odberne $hlavicka->odbm, $hlavicka->onai$hlavicka->ona2, $hlavicka->ouli, $hlavicka->omes, $hlavicka->opsc$icd2";
$dlzkaodbm=1*strlen($odbmtlac);

if( $dlzkaodbm > 80 ) { $pdf->SetFont('arial','',8); }
$pdf->Cell(180,7,"$odbmtlac","B",1,"L");
$pdf->SetFont('arial','',9);
}

          }

     }
//koniec len dodavatelske

$faktura=$hlavicka->fak;
$cislo_fak=$hlavicka->fak;
if( $hlavicka->fak == 0 ) $cislo_fak="";
$cislo_dol=$hlavicka->dol;
if( $hlavicka->dol == 0 ) $cislo_dol="";
$cislo_prf=$hlavicka->prf;
if( $hlavicka->prf == 0 ) $cislo_prf="";

$ajvsy=0;
if( ( $rozuct == 'ANO' ) AND $kli_vrok >= 2014 ) { $ajvsy=1; }
if( $ajvsy == 1 AND $mini == 0 AND  $rozuct == 'ANO' ) { $variabilny="è.Faktúry / VSY:"; $cislo_fak=$hlavicka->sz3." / ".$cislo_fak; }
if( $ajvsy == 1 AND $mini == 0 AND  $rozuct != 'ANO' ) {   }
$ajopravna=0;
$dlzkaoprav=strlen(trim($hlavicka->dav));
if( $dlzkaoprav > 5 AND $hlavicka->dav != "00.00.0000" AND $hlavicka->dav != "0000-00-00" ) { $ajopravna=1; }
if( $ajvsy == 1 AND $mini == 1 AND $ajopravna == 0 ) { $variabilny="è.Faktúry / VSY:"; $cislo_fak=$hlavicka->sz3." / ".$cislo_fak; }
if( $ajvsy == 1 AND $mini == 1 AND $ajopravna == 1 ) { $variabilny="è.Faktúry / VSY / Oprav.:"; $cislo_fak=$hlavicka->sz3." / ".$cislo_fak." / ".$hlavicka->dav; }
$pdf->Cell(180,1,"","0",1,"L");
$pdf->Cell(45,4,"$vyhotovena","0",0,"L");
$pdf->Cell(45,4,"$hlavicka->dat","0",0,"L");
$pdf->Cell(45,4,"$variabilny","0",0,"L");
if( $ajopravna == 1 ) { $pdf->SetFont('arial','',7); }
$pdf->Cell(45,4,"$cislo_fak","0",1,"L");
$pdf->SetFont('arial','',10);
 
$pdf->Cell(45,4,"$dodane","0",0,"L");
if( $drupoh != 2 ) { $pdf->Cell(45,4,"$hlavicka->daz","0",0,"L"); }
if( $drupoh == 2 ) 
{ 
$sqlttt = "SELECT sz4 FROM F$kli_vxcf"."_fakdod WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dao=SkDatum($riaddok->sz4);
  }
$pdf->Cell(45,4,"$dao - $hlavicka->daz","0",0,"L"); 
}
$pdf->Cell(45,4,"$konstantny","0",0,"L");
$pdf->Cell(45,4,"$hlavicka->ksy","0",1,"L");


$pdf->Cell(45,4,"$splatna","0",0,"L");
$pdf->Cell(45,4,"$hlavicka->das","0",0,"L");
$pdf->Cell(45,4,"$specificky","0",0,"L");
$pdf->Cell(45,4,"$hlavicka->ssy","0",1,"L");


if( $mini == 0 )
          {
$pdf->Cell(45,4,"$objednavkauni","0",0,"L");
$pdf->Cell(45,4,"$hlavicka->obj - $hlavicka->unk","0",0,"L");
$pdf->Cell(45,4,"$dodacipredfak","0",0,"L");
$pdf->Cell(45,4,"$cislo_dol - $cislo_prf","0",1,"L");

$pdf->Cell(45,4,"$strzakdok","0",0,"L");

$akydoklad=$hlavicka->dok;
if( $_SERVER['SERVER_NAME'] == "www.ala.sk" AND $kli_uzid == 17 ) { $akydoklad=$hlavicka->fak; } 

$pdf->Cell(45,4,"$hlavicka->str - $hlavicka->zak - $akydoklad","0",0,"L");
$pdf->Cell(30,4,"$doprava","0",0,"L");
$pdf->Cell(30,4,"$hlavicka->dpr","0",0,"L");
$opravna="Oprav.faktúra $hlavicka->dav";
if( trim($hlavicka->dav) == '' ) { $opravna=" "; }
$pdf->Cell(30,4,"$opravna","0",1,"R");

$zaknaz=0;
if( $_SERVER['SERVER_NAME'] == "www.montpetrolucto.sk"  ) { $zaknaz=1; }
if( $zaknaz == 1 ) 
   {
$zknaz="";
$sqlttt = "SELECT nza FROM F$kli_vxcf"."_zak WHERE zak = $hlavicka->zak ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zknaz=$riaddok->nza;
  }
$pdf->Cell(30,4,"$zknaz","0",1,"L");
   }
          }

if( $medo == 1 AND $drupoh == 1 )
{
$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,8,"Faktúrujeme Vám "," ",1,"L");
}

if( $hlavicka->txp != '' )
{
$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,1,""," ",1,"L");

$pole = explode("\r\n", $hlavicka->txp);

$ipole=1;
foreach( $pole as $hodnota ) {
//if( $ipole == 1 ) { $pdf->Cell(15,5,"Popis:","0",0,"R"); }
//if( $ipole != 1 ) { $pdf->Cell(15,5," ","0",0,"R"); }
if( $hodnota != '' ) { $pdf->Cell(70,5,"$hodnota","0",1,"L"); }
$ipole=$ipole+1;
}

}

if( $mini == 0 )
          {
$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,1,"","0",1,"L");

if( $jazyk == 0 )
{
$pdf->SetFont('arial','',6);
$vcene="";
if( $hlavicka->zmen == 1 AND $hlavicka->dn2 == 0 ) { $vcene=" - $cenapoloziek".$hlavicka->mena; }
$pdf->Cell(72,5,"$polozka $vcene","0",0,"L");
$pdf->Cell(8,5,"$sadzbadph","0",0,"L");$pdf->Cell(4,5,"","0",0,"C");
$pdf->Cell(14,5,"$jcenabezdph","0",0,"R");$pdf->Cell(6,5,"","0",0,"C");
$pdf->Cell(15,5,"$jcenasdph","0",0,"R");$pdf->Cell(3,5,"","0",0,"C");
$pdf->Cell(13,5,"$mnozstvo","0",0,"R");$pdf->Cell(2,5,"","0",0,"C");
$pdf->Cell(6,5,"$mj","0",0,"L");$pdf->Cell(4,5,"","0",0,"C");
$pdf->Cell(16,5,"$hodnotabezdph","0",0,"R");$pdf->Cell(2,5,"","0",0,"C");
$pdf->Cell(15,5,"$hodnotasdph","0",1,"R");
$pdf->SetFont('arial','',9);
}
if( $jazyk == 1 )
{
$pdf->SetFont('arial','',6);
$vcene="";
if( $hlavicka->zmen == 1 AND $hlavicka->dn2 == 0 ) { $vcene=" - ceny položiek v ".$hlavicka->mena; }
$pdf->Cell(180,0,"","-1",1,"L");
$pdf->Cell(72,4,"Položka / $vcene","0",0,"L");
$pdf->Cell(8,4,"DPH /","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(14,4,"Cena/jed. /","0",0,"C");$pdf->Cell(6,4,"","0",0,"C");
$pdf->Cell(15,4,"J.cena sDPH/","0",0,"C");$pdf->Cell(3,4,"","0",0,"C");
$pdf->Cell(13,4,"Množstvo /","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(6,4,"MJ /","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(16,4,"HODN bDPH/","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(15,4,"HODN sDPH/","0",1,"C");

if( $hlavicka->zmen == 1 AND $hlavicka->dn2 == 0 ) { $vcene=" - $cenapoloziek".$hlavicka->mena; }
$pdf->Cell(180,-1,"","0",1,"L");
$pdf->Cell(72,4," $polozka $vcene","0",0,"L");
$pdf->Cell(8,4,"$sadzbadph","0",0,"L");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(14,4,"$jcenabezdph","0",0,"C");$pdf->Cell(6,4,"","0",0,"C");
$pdf->Cell(15,4,"$jcenasdph","0",0,"C");$pdf->Cell(3,4,"","0",0,"C");
$pdf->Cell(13,4,"$mnozstvo","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(6,4,"$mj","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(16,4,"$hodnotabezdph","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(15,4,"$hodnotasdph","0",1,"C");
$pdf->SetFont('arial','',9);
}
if( $jazyk == 2 )
{
$pdf->SetFont('arial','',6);
$vcene="";
if( $hlavicka->zmen == 1 AND $hlavicka->dn2 == 0 ) { $vcene=" - ceny položiek v ".$hlavicka->mena; }
$pdf->Cell(180,0,"","-1",1,"L");
$pdf->Cell(72,4,"Položka / $vcene","0",0,"L");
$pdf->Cell(8,4,"DPH /","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(14,4,"Cena/jed. /","0",0,"C");$pdf->Cell(6,4,"","0",0,"C");
$pdf->Cell(15,4,"J.cena sDPH/","0",0,"C");$pdf->Cell(3,4,"","0",0,"C");
$pdf->Cell(13,4,"Množstvo /","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(6,4,"MJ /","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(16,4,"HODN bDPH/","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(15,4,"HODN sDPH/","0",1,"C");

if( $hlavicka->zmen == 1 AND $hlavicka->dn2 == 0 ) { $vcene=" - $cenapoloziek".$hlavicka->mena; }
$pdf->Cell(180,-1,"","0",1,"L");
$pdf->Cell(72,4," $polozka $vcene","0",0,"L");
$pdf->Cell(8,4,"$sadzbadph","0",0,"L");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(14,4,"$jcenabezdph","0",0,"C");$pdf->Cell(6,4,"","0",0,"C");
$pdf->Cell(15,4,"$jcenasdph","0",0,"C");$pdf->Cell(3,4,"","0",0,"C");
$pdf->Cell(13,4,"$mnozstvo","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(6,4,"$mj","0",0,"C");$pdf->Cell(4,4,"","0",0,"C");
$pdf->Cell(16,4,"$hodnotabezdph","0",0,"C");$pdf->Cell(2,4,"","0",0,"C");
$pdf->Cell(15,4,"$hodnotasdph","0",1,"C");
$pdf->SetFont('arial','',9);
}

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,1,"","0",1,"L");
if( $kli_uzid == 171717171717171717171 )
  {
$pdf->Cell(72,5,"služby IT ","0",0,"L");
$pdf->Cell(8,5,"0","0",0,"L");$pdf->Cell(4,5,"","0",0,"C");
$pdf->Cell(14,5,"1225.7500","0",0,"R");$pdf->Cell(6,5,"","0",0,"C");
$pdf->Cell(15,5,"1225.7500","0",0,"R");$pdf->Cell(3,5,"","0",0,"C");
$pdf->Cell(13,5,"1","0",0,"R");$pdf->Cell(2,5,"","0",0,"C");
$pdf->Cell(6,5," ","0",0,"L");$pdf->Cell(4,5,"","0",0,"C");
$pdf->Cell(16,5,"1225.75","0",0,"R");$pdf->Cell(2,5,"","0",0,"C");
$pdf->Cell(15,5,"1225.75","0",1,"R");
  }
          }

$cislo_dokhl=$hlavicka->dok;

          }
//koniec hlavicka j=0

$js=0;
$stranast=1;
$novastrana=0;
//zaciatok vypisu tovaru
$ajhodb="";
$ajunk="";
if( $prepoczk2 == 1 )
{ 
$tabltovar="sklfakprc".$kli_uzid; $ajhodb=",hodb"; $kli_vxcfskl=$kli_vxcf;
}
if( $drupoh == 11 ) { $ajunk=",unk"; }
$ajpoz="";
if( $drupoh == 1  ) { $ajpoz=",poz"; }
if( $drupoh == 11 ) { $ajpoz=",poz"; }

$tovtt = "SELECT dok, cpl, F$kli_vxcfskl"."_$tabltovar.cis AS slu, F$kli_vxcfskl"."_$tabltovar.nat AS nsl, pop, F$kli_vxcfskl"."_$tabltovar.dph,".
" mno, F$kli_vxcfskl"."_$tabltovar.mer, F$kli_vxcfskl"."_$tabltovar.cep, F$kli_vxcfskl"."_$tabltovar.ced, F$kli_vxcfskl"."_sklcis.nat AS nso $ajhodb $ajunk $ajpoz". 
" FROM F$kli_vxcfskl"."_$tabltovar".
" LEFT JOIN F$kli_vxcfskl"."_sklcis".
" ON F$kli_vxcfskl"."_$tabltovar.cis=F$kli_vxcfskl"."_sklcis.cis".
" WHERE F$kli_vxcfskl"."_$tabltovar.dok = $cislo_dokhl ".
" ORDER BY cpl";
//echo $tovtt;

//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

//Ak je tovar
if( $jetovar == 1 AND $mini == 0 )
           {
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if(  $rtov->slu >= 0 AND $rtov->nsl != '' )
    {

if(  $rtov->poz != '' AND ( ( $textnadpol == 0 AND $textpodpol == 0 ) OR ( $textnadpol == 1 AND $textpodpol == 0 ) ) )
      {
$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"$rtov->poz","0",1,"L");
$js=$js+1;
      }


$mnozstvo=1*$rtov->mno;
if( $mnozstvo == 0 AND $drupoh == 11 ) { $mnozstvo=1*$rtov->unk; } 
$mnozstvo=sprintf("%0.3f", $mnozstvo);

$hodbdph = $rtov->cep*$mnozstvo;
if( $prepoczk2 == 1 )
{ 
$hodbdph = $rtov->hodb; 
}
$hodsdph = $rtov->ced*$mnozstvo;
$Cislo=$hodbdph+"";
$hdp=sprintf("%0.2f", $Cislo);
$Cislo=$hodsdph+"";
$hdd=sprintf("%0.2f", $Cislo);

if( $lenstlpecbezdph == 1 ) { $hdd=$hdp; $hdp=""; }

if( $bezcen == 1 ) { $hdd=""; $hdp=""; $rtov->ced=""; $rtov->cep=""; }
 
$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"$rtov->nsl","0",0,"L");$pdf->Cell(6,5,"$rtov->dph","0",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(19,5,"$rtov->cep","0",0,"R");$pdf->Cell(19,5,"$rtov->ced","0",0,"R");
$pdf->SetFont('arial','',9);

$merjed=$rtov->mer;
if( $merjed == '-' ) { $merjed=''; } 

$pdf->Cell(19,5,"$mnozstvo","0",0,"R");$pdf->Cell(6,5,"$merjed","0",0,"L");
$pdf->Cell(20,5,"$hdp","0",0,"R");
$pdf->Cell(19,5,"$hdd","0",1,"R");
$js=$js+1;
    }
if(  $rtov->slu == 0 AND $rtov->nsl == '' AND $rtov->pop != '' )
    {
$pdf->Cell(180,5,"$rtov->pop","0",1,"L");
$js=$js+1;
    }

if(  $rtov->poz != '' AND $textnadpol == 1 AND $textpodpol == 1 )
      {
$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"$rtov->poz","0",1,"L");
$js=$js+1;
      }

}
$i = $i + 1;

//nova strana
if( $js >= $h_pocpol AND $stranast == 1 ) { $novastrana=1; }
if( $js >= 40 AND $stranast > 1 ) { $novastranna=1; }
if( $novastrana == 1 ) 
{
$stranast=$stranast+1;
$pdf->Cell(180,2," ","0",1,"L");
$pdf->Cell(180,5,"Pokraèovanie faktúry na $stranast.strane","0",1,"L");

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->Cell(180,5,"$stranast.strana faktúry è. $faktura","0",1,"L");
$pdf->Cell(180,2," ","0",1,"L");

$js=0;
$novastrana=0;
}
//koniec nova strana

  }

           }
//koniec ak je tovar

//zaciatok vypisu sluzieb
$ajhodb="";
if( $prepoczk2 == 1 )
{ 
$tablsluzby="faksluprc".$kli_uzid; $ajhodb=",hodb"; 
}

$sluztt = "SELECT dok, cpl, F$kli_vxcf"."_$tablsluzby.slu, F$kli_vxcf"."_$tablsluzby.nsl, pop, pon, F$kli_vxcf"."_$tablsluzby.dph, nslp, ".
" mno, F$kli_vxcf"."_$tablsluzby.mer, F$kli_vxcf"."_$tablsluzby.cep, F$kli_vxcf"."_$tablsluzby.ced, F$kli_vxcf"."_$cissluzby.nsl AS nso $ajhodb". 
" FROM F$kli_vxcf"."_$tablsluzby".
" LEFT JOIN F$kli_vxcf"."_$cissluzby".
" ON F$kli_vxcf"."_$tablsluzby.slu=F$kli_vxcf"."_$cissluzby.slu".
" WHERE F$kli_vxcf"."_$tablsluzby.dok = $cislo_dokhl ".
" ORDER BY cpl";
//echo $sluztt;
//exit;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
if( $slpol > 0 ) $jesluzba=1;

//Ak je sluzba
if( $jesluzba == 1 AND $mini == 0 )
           {
$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);


if( $rsluz->nslp != '' AND $drupoh != 12 )
{
$pdf->Cell(0,5,"$rsluz->nslp","0",1,"L");
$js=$js+1;
}


if(  $rsluz->slu >= 0 AND $rsluz->nsl != '' )
    {

if(  $rsluz->pon != '' )
      {
$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"$rsluz->pon","0",1,"L");
$js=$js+1;
      }

$hodbdph = $rsluz->cep*$rsluz->mno;
if( $prepoczk2 == 1 )
{ 
$hodbdph = $rsluz->hodb; 
}
$hodsdph = $rsluz->ced*$rsluz->mno;
$Cislo=$hodbdph+"";
$hdp=sprintf("%0.2f", $Cislo);
$Cislo=$hodsdph+"";
$hdd=sprintf("%0.2f", $Cislo);

if( $lenstlpecbezdph == 1 ) { $hdd=$hdp; $hdp=""; } 

if( $bezcen == 1 ) { $hdd=""; $hdp=""; $rsluz->ced=""; $rsluz->cep=""; }

$dlzkapolozky=strlen($rsluz->nsl);

$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"$rsluz->nsl","0",0,"L");
if( $dlzkapolozky > 40 ) { $pdf->Cell(0,5," ","0",1,"L");$pdf->Cell(72,5," ","0",0,"L"); $js=$js+1; }
$pdf->Cell(6,5,"$rsluz->dph","0",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(19,5,"$rsluz->cep","0",0,"R");$pdf->Cell(19,5,"$rsluz->ced","0",0,"R");
$pdf->SetFont('arial','',9);

$merjed=$rsluz->mer;
if( $merjed == '-' ) { $merjed=''; } 

$pdf->Cell(19,5,"$rsluz->mno","0",0,"R");$pdf->Cell(6,5,"$merjed","0",0,"L");

$pdf->Cell(20,5,"$hdp","0",0,"R");
$pdf->Cell(19,5,"$hdd","0",1,"R");

$js=$js+1;
    }
if(  $rsluz->slu == 0 AND $rsluz->nsl == '' AND $rsluz->pop != '' )
    {
$pdf->Cell(180,5,"$rsluz->pop","0",1,"L");
$js=$js+1;
    }

}
$i = $i + 1;

//nova strana
if( $js >= $h_pocpol AND $stranast == 1 ) { $novastrana=1; }
if( $js >= 40 AND $stranast > 1 ) { $novastrana=1; }
if( $novastrana == 1 ) 
{
$stranast=$stranast+1;
$pdf->Cell(180,2," ","0",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(180,5,"Pokraèovanie faktúry na $stranast.strane","0",1,"L");

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->Cell(180,5,"$stranast.strana faktúry è. $faktura","0",1,"L");
$pdf->Cell(180,2," ","0",1,"L");

$js=0;
$novastrana=0;
}
//koniec nova strana

  }

           }
//koniec ak je sluzba

if( $hlavicka->txz != '' AND $textza == 1 AND $drupoh == 1 )
{
$pdf->Cell(180,2,""," ",1,"L");

$pole = explode("\r\n", $hlavicka->txz);

$ipole=1;
foreach( $pole as $hodnota ) {
$pdf->Cell(70,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
 }

}

$pdf->SetFont('arial','',10);
$aktpoz_y=$pdf->GetY();
$aktpoz_y=$aktpoz_y+2;
$pdf->Line(15, $aktpoz_y, 195, $aktpoz_y); 
$aktpoz_y=$aktpoz_y+2;
$pdf->SetY($aktpoz_y);

//rozpis dph len ak zmen!=1
if( ( $hlavicka->zmen != 1 AND $predfaktura == 0 AND $drupoh != 21 AND $drupoh != 22 AND $bezcen == 0 ) OR 
( $hlavicka->zmen == 1 AND $drupoh == 1 AND $hlavicka->dn2 != 0 ) ) {

if( $jazyk == 0 )
  {
$pdf->Cell(72,5,"$rozpisdph","0",0,"L");$pdf->Cell(15,5,"$percentodph","0",0,"R");
$pdf->Cell(31,5,"$zakladdph","0",0,"R");$pdf->Cell(31,5,"$sumadph","0",0,"R");$pdf->Cell(31,5,"$spolusdph","0",1,"R");
  }
if( $jazyk == 1 )
  {
$pdf->Cell(180,-1," ","0",1,"L");
$pdf->Cell(72,4,"Rozpis DPH","0",0,"L");$pdf->Cell(15,4,"% DPH /","0",0,"R");
$pdf->Cell(31,4,"Základ /","0",0,"R");$pdf->Cell(31,4,"Daò /","0",0,"R");$pdf->Cell(31,4,"Spolu /","0",1,"R");
$pdf->Cell(180,0," ","0",1,"L");
$pdf->Cell(72,4,"$rozpisdph","0",0,"L");$pdf->Cell(15,4,"$percentodph","0",0,"R");
$pdf->Cell(31,4,"$zakladdph","0",0,"R");$pdf->Cell(31,4,"$sumadph","0",0,"R");$pdf->Cell(31,4,"$spolusdph","0",1,"R");
  }
if( $jazyk == 2 )
  {
$pdf->Cell(72,5,"$rozpisdph","0",0,"L");$pdf->Cell(15,5,"$percentodph","0",0,"R");
$pdf->Cell(31,5,"$zakladdph","0",0,"R");$pdf->Cell(31,5,"$sumadph","0",0,"R");$pdf->Cell(31,5,"$spolusdph","0",1,"R");
  }

$aktpoz_y=$aktpoz_y+5;
if( $hlavicka->zk1 != 0 )
{
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"$fir_dph1","0",0,"R");
$pdf->Cell(31,5,"$hlavicka->zk1","0",0,"R");$pdf->Cell(31,5,"$hlavicka->dn1","0",0,"R");$pdf->Cell(31,5,"$hlavicka->sp1","0",1,"R");
$aktpoz_y=$aktpoz_y+5;
}
if( $hlavicka->zk2 != 0 )
{
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"$fir_dph2","0",0,"R");
$pdf->Cell(31,5,"$hlavicka->zk2","0",0,"R");$pdf->Cell(31,5,"$hlavicka->dn2","0",0,"R");$pdf->Cell(31,5,"$hlavicka->sp2","0",1,"R");
$aktpoz_y=$aktpoz_y+5;
}
if( $hlavicka->zk0 != 0 )
{
$pdf->Cell(72,5,"","0",0,"L");$pdf->Cell(15,5,"0","0",0,"R");
$pdf->Cell(31,5,"$hlavicka->zk0","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hlavicka->zk0","0",1,"R");
$aktpoz_y=$aktpoz_y+5;
}

if( $hlavicka->zao != 0 )
{
$pdf->Cell(72,5,"Zaokrúhlenie","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hlavicka->zao","0",1,"R");
$aktpoz_y=$aktpoz_y+5;
}
$aktpoz_y=$aktpoz_y+2;
$pdf->Line(15, $aktpoz_y, 195, $aktpoz_y); 
$aktpoz_y=$aktpoz_y+2;

//koniec rozpisu ak zmen != 1 alebo dn2 != 0
                             }

if( $bezcen == 0 ) 
  {
$pdf->SetFont('arial','B',12);
if( $hlavicka->zmen == 1 ) $pdf->SetFont('arial','',10);
$pdf->SetY($aktpoz_y);
$pdf->Cell(72,5,"$celkomhodnota $mena1 ","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hlavicka->hod $mena1","0",1,"R");
  }
$aktpoz_y=$aktpoz_y+8;
$pdf->SetY($aktpoz_y);
if( $vyb_rok < 2009 ) $prepoc = $hlavicka->hod/$kurz12;
if( $vyb_rok > 2008 ) $prepoc = $hlavicka->hod*$kurz12;
$Cislo=$prepoc+"";
$sPrepoc=sprintf("%0.2f", $Cislo);

if( $mini == 0 AND $ajprepocetnask == 1 )
          {
$pdf->SetFont('arial','',10);
$pdf->Cell(72,5,"Info prepoèet na $mena2 konverzným kurzom $kurz12 Sk/Eur","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$sPrepoc $mena2","0",1,"R");
$aktpoz_y=$aktpoz_y+5;
          }

if( $hlavicka->zmen == 1 AND $vyb_rok < 2009 )
{
$pdf->SetFont('arial','B',12);
$pdf->Cell(72,5,"Celkom hodnota v $hlavicka->mena kurz $hlavicka->kurz $mena1/1$hlavicka->mena","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hlavicka->hodm $hlavicka->mena","0",1,"R");
}
if( $hlavicka->zmen == 1 AND $vyb_rok > 2008 )
{
$aktpoz_y=$pdf->GetY();
$aktpoz_y=$aktpoz_y+2;
$pdf->Line(15, $aktpoz_y, 195, $aktpoz_y); 
$aktpoz_y=$aktpoz_y+2;
$pdf->SetY($aktpoz_y);

//toto funguje ak polozky su v EUR s dph a nakoniec dame cudziu menu
$hodmxx=$hlavicka->hodm;
if($hlavicka->zmen == 1 AND $drupoh == 1 AND $hlavicka->dn2 != 0 )
  {
$hodmxx=$hlavicka->hod*$hlavicka->kurz;
$sqlttt = "UPDATE F$kli_vxcf"."_fakodb SET hodm=$hodmxx WHERE dok = $hlavicka->dok ";
$sqldok = mysql_query("$sqlttt");

  }

$pdf->SetFont('arial','B',12);
$pdf->Cell(72,5,"Celkom hodnota v $hlavicka->mena kurz $hlavicka->kurz $hlavicka->mena/1$mena1","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hodmxx $hlavicka->mena","0",1,"R");

}
$pdf->SetFont('arial','',10);

if( $hlavicka->zal != 0 )
{
$pdf->SetFont('arial','',10);
$pdf->Cell(72,5,"Zaplatená záloha ","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$hlavicka->zal $mena1","0",1,"R");

$uhradit = 1*$hlavicka->hod-1*$hlavicka->zal;
$Cislo=$uhradit+"";
$sUhradit=sprintf("%0.2f", $Cislo);

$pdf->Cell(72,5,"K úhrade zostáva ","0",0,"L");$pdf->Cell(15,5," ","0",0,"R");
$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5," ","0",0,"R");$pdf->Cell(31,5,"$sUhradit $mena1","0",1,"R");

if( $hlavicka->ruc != 0 ) 
   {
$zaklzal=-1*$hlavicka->zal; $zakldph=-1*$hlavicka->ruc; $zaklzak=1*($zaklzal-$zakldph);
$zaklzaks=sprintf("%0.2f", $zaklzak); $zakldphs=sprintf("%0.2f", $zakldph); $zaklzals=sprintf("%0.2f", $zaklzal);

$zoszal=$hlavicka->hod-$hlavicka->zal; $zosdph=$hlavicka->dn2-$hlavicka->ruc; $zoszak=$zoszal-$zosdph;
$zoszaks=sprintf("%0.2f", $zoszak); $zosdphs=sprintf("%0.2f", $zosdph); $zoszals=sprintf("%0.2f", $zoszal);

$pdf->SetFont('arial','',8);
$pdf->Cell(60,2," ","0",1,"L");
$pdf->Cell(60,5,"Vyúètovanie DPH $fir_dph2% na faktúre $cislo_dok po odpoèítaní zálohy","0",1,"L");
$pdf->Cell(10,5," ","0",0,"L");$pdf->Cell(30,5,"Základ DPH","0",0,"R");$pdf->Cell(30,5,"Daò","0",0,"R");$pdf->Cell(30,5,"Spolu","0",1,"R");
$pdf->Cell(10,5,"faktúra","0",0,"L");$pdf->Cell(30,5,"$hlavicka->zk2","0",0,"R");$pdf->Cell(30,5,"$hlavicka->dn2","0",0,"R");$pdf->Cell(30,5,"$hlavicka->sp2","0",1,"R");
$pdf->Cell(10,5,"záloha","0",0,"L");$pdf->Cell(30,5,"$zaklzaks","0",0,"R");$pdf->Cell(30,5,"$zakldphs","0",0,"R");$pdf->Cell(30,5,"$zaklzals","0",1,"R");
$pdf->Cell(10,5,"zostatok","0",0,"L");$pdf->Cell(30,5,"$zoszaks","0",0,"R");$pdf->Cell(30,5,"$zosdphs","0",0,"R");$pdf->Cell(30,5,"$zoszals","0",1,"R");

$pdf->SetFont('arial','',10);
   }

$aktpoz_y=$aktpoz_y+5;
}


if( $hlavicka->txz != '' AND ( $textza == 0 OR $drupoh != 1 ) )
{
$pdf->Cell(180,2,""," ",1,"L");

$pole = explode("\r\n", $hlavicka->txz);

$ipole=1;
foreach( $pole as $hodnota ) {
$pdf->Cell(70,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
 }

}


//zaciatok vypisu uctovania

$ucttt = "SELECT * ".
" FROM F$kli_vxcf"."_$ucto".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$ucto.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$ucto.dok = $cislo_dokhl ".
" ORDER BY cpl";
//echo $ucttt;

//exit;
$jeucto=0;
$uct = mysql_query("$ucttt");
$ucpol = mysql_num_rows($uct);
if( $ucpol > 0 ) $jeucto=1;

//Ak je uctovanie
if( $jeucto == 1 AND $rozuct == 'ANO' )
           {
$i=0;
  while ($i <= $ucpol )
  {

  if (@$zaznam=mysql_data_seek($uct,$i))
{
$ruct=mysql_fetch_object($uct);

if( $i == 0 )
     {
$pdf->SetFont('arial','',12);
$pdf->Cell(130,5," ","0",1,"R");
$pdf->Cell(148,5,"Úètovný predpis dokladu $cislo_dokhl","0",1,"L");
$pdf->SetFont('arial','',10);

if( $drupoh == 2 AND $mini == 1 ) {
$dak_set=""; $jedak=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakturasetdak WHERE dok = $hlavicka->dok ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dak_set=SkDatum($riaddok->dak);
  $jedak=1;
  }
if( $jedak == 1 ) { $pdf->Cell(45,4,"Zaradené do KV DPH: $dak_set","0",1,"L"); }

                                  }


$pdf->Cell(18,5,"MáDa","1",0,"L");$pdf->Cell(18,5,"Dal","1",0,"L");
$pdf->Cell(10,5,"RDP","1",0,"L");$pdf->Cell(20,5,"IÈO","1",0,"R");
$pdf->Cell(22,5,"Faktúra","1",0,"R");$pdf->Cell(15,5,"STR","1",0,"R");
$pdf->Cell(20,5,"ZÁK","1",0,"R");$pdf->Cell(25,5,"Hodnota","1",1,"R");

     }


$pdf->SetFont('arial','',10);
$pdf->Cell(18,5,"$ruct->ucm","0",0,"L");$pdf->Cell(18,5,"$ruct->ucd","0",0,"L");
$pdf->Cell(10,5,"$ruct->rdp","0",0,"L");$pdf->Cell(20,5,"$ruct->ico","0",0,"R");
$pdf->Cell(22,5,"$ruct->fak","0",0,"R");$pdf->Cell(15,5,"$ruct->str","0",0,"R");
$pdf->Cell(20,5,"$ruct->zak","0",0,"R");$pdf->Cell(25,5,"$ruct->hod","0",1,"R");

//rozpoctova.klasifikacia
if( $fir_allx14 == 1 )
   {
$rozpkls=0;
$sqlddt = "SELECT uce, crs FROM F$kli_vxcf"."_crf104nuj_no WHERE uce = $ruct->ucm OR uce = $ruct->ucd ";
$sqldok = mysql_query("$sqlddt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozpkls=1*$riaddok->crs;
  }
if( $rozpkls > 0 ) { $pdf->SetFont('arial','',7); $pdf->Cell(30,2,"Rozpoètová klasifikácia $rozpkls","0",1,"L"); $pdf->SetFont('arial','',10);  }
   }


}
$i = $i + 1;
  }

if( $mini == 1 )
          {
$pdf->SetFont('arial','',10);
if( $drupoh == 1 )
  {
$pdf->Cell(30,5," ","0",1,"L");
$pdf->Cell(90,5,"Zaúètoval: $hlavicka->meno $hlavicka->priezvisko","1",0,"L");
$pdf->Cell(90,5,"Schválil:","1",1,"L");
  }
if( $drupoh == 2 )
  {
$pdf->Cell(30,5," ","0",1,"L");
$pdf->Cell(60,5,"Zaúètoval: $hlavicka->meno $hlavicka->priezvisko","1",0,"L");
$pdf->Cell(60,5,"Schválil:","1",0,"L");
$pdf->Cell(60,5,"Súhlasím s úhradou:","1",1,"L");
  }
$pdf->Cell(30,5," ","0",1,"L");
$pdf->Cell(30,8,"$hlavicka->poz","0",1,"L");
          }

           }
//koniec ak je uctovanie

$razitko = 1*$_REQUEST['h_razitko'];
if( $mini == 0 AND $razitko == 1 )
          {
$pocetpoloziek=$slpol+$tvpol;

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/razitko'.$kli_uzid.'.jpg'))
{
$rozmerhlv1="110"; $rozmerhlv2="250"; $rozmerhlv3="40"; $rozmerhlv4="20";

if( $pocetpoloziek < 16 AND $pocetpoloziek <= $h_pocpol1s ) { $rozmerhlv2="240"; $rozmerhlv1="110"; }
if( $pocetpoloziek < 10 AND $pocetpoloziek <= $h_pocpol1s ) { $rozmerhlv2="220"; $rozmerhlv1="140"; }
if( $pocetpoloziek < 5 AND $pocetpoloziek <= $h_pocpol1s ) { $rozmerhlv2="200"; $rozmerhlv1="140"; }

if( $pocetpoloziek > $h_pocpol1s ) { $rozmerhlv2="250"; $rozmerhlv1="110"; }

$mpol1=42; $mpol2=37; $mpol3=29; $mpol4=24;
$mpol1=$h_pocpol+22; $mpol2=$h_pocpol+17; $mpol3=$h_pocpol+9; $mpol4=$h_pocpol+4;

if( $pocetpoloziek < $mpol1 AND $pocetpoloziek > $h_pocpol1s ) { $rozmerhlv2="200"; $rozmerhlv1="110"; }
if( $pocetpoloziek < $mpol2 AND $pocetpoloziek > $h_pocpol1s ) { $rozmerhlv2="170"; $rozmerhlv1="110"; }
if( $pocetpoloziek < $mpol3 AND $pocetpoloziek > $h_pocpol1s ) { $rozmerhlv2="150"; $rozmerhlv1="140"; }
if( $pocetpoloziek < $mpol4 AND $pocetpoloziek > $h_pocpol1s ) { $rozmerhlv2="130"; $rozmerhlv1="140"; }

$sirka=0; $vyska=0; $zhora=0; $zlava=0;
$sqlttt = "SELECT ucm1,ucm2,ucm3,ucm4 FROM F$kli_vxcf"."_fakturaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sirka=1*$riaddok->ucm1; $vyska=1*$riaddok->ucm2; $zlava=1*$riaddok->ucm3; $zhora=1*$riaddok->ucm4;
  }
//echo $sirka.$vyska.$zhora.$zlava;
//exit;

if( $sirka > 0 AND $vyska > 0 AND $zhora > 0 AND $zlava > 0 ) { $rozmerhlv1=$zlava+""; $rozmerhlv2=$zhora+""; $rozmerhlv3=$sirka+""; $rozmerhlv4=$vyska+""; }

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/razitko'.$kli_uzid.'.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}
          }

if( $mini == 0 )
          {
$koniec=270;

if( $dodaci == 1 )
  {
$pdf->SetY(260);
$pdf->Cell(84,6,"Tovar za odberate¾a prevzal(meno,podpis,peèiatka):","0",0,"L");$pdf->Cell(70,6," ","B",1,"L");
  }

$podpis=0;
if( $poliklinikase == 1 ) { $podpis=1;}
if( $dodaci == 1 ) { $podpis=0;} 
if( $podpis == 1 )
  {
$pdf->SetY(230);
$pdf->Cell(90,5,"","0",0,"L");$pdf->Cell(53,5,"Ing.Alena Kovaèièová, riadite¾ka","T",1,"L");
  }

$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec); 
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"$vystavil $hlavicka->meno $hlavicka->priezvisko / $hlavicka->id ","0",1,"L");
          }


//tabulka financna kontrola vs
$tlacover=0;
if( $fir_fico == 36268399 AND $mini == 1 ) 
 { 
$tlacover=1;
$meno1="Ing. Gabriela Kováèová";
$meno2="Drahoslava Jureòová"; 
 }

if ( $tlacover == 1 )
{
$pdf->SetY(245);
//1.osoba
$pdf->SetFont('arial','',8);
$pdf->Cell(130,5,"  Finanènú operáciu  je  -  nie je  možné vykona a pokraèova v nej","1",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(65,5,"Vykonal:  $meno1","0",0,"L");
$pdf->Cell(35,5,"Dátum  $dat_sk","0",0,"L");
$pdf->Cell(30,5,"Podpis","0",1,"L");
//2.osoba
$pdf->SetFont('arial','',8);
$pdf->Cell(130,5,"  Finanènú operáciu  je  -  nie je  možné vykona a pokraèova v nej","1",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(65,5,"Vykonal:  $meno2","0",0,"L");
$pdf->Cell(35,5,"Dátum  $dat_sk","0",0,"L");
$pdf->Cell(30,5,"Podpis","0",1,"L");
//vecna spravnost
$pdf->SetFont('arial','',7);
$pdf->Cell(190,1," ","0",1,"L");
$pdf->Cell(65,5,"a) Vecnú správnos overil:  $meno1","TL",0,"L");
$pdf->Cell(35,5,"Dátum  $dat_sk","T",0,"L");
$pdf->Cell(30,5,"Podpis","TR",1,"L");
//formalna spravnost
$pdf->Cell(65,5,"b) Formálnu správnos overil:  $meno2","TBL",0,"L");
$pdf->Cell(35,5,"Dátum  $dat_sk","TB",0,"L");
$pdf->Cell(30,5,"Podpis","TRB",1,"L");

}
//koniec tabulka financna kontrola vs

  }
//koniec hlavicky

$ih = $ih + 1;
$j=0;
}
//koniec while citania hlaviciek


$sqlttt = "DROP TABLE F$kli_vxcf"."_faksluprc$kli_uzid  ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "DROP TABLE F$kli_vxcf"."_sklfakprc$kli_uzid  ";
$sqldok = mysql_query("$sqlttt");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Faktúra PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 

$pdf->Output("$outfilex");
?>

<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 0 ) { echo "EuroSecom  -  Faktúra <?php echo $cislo_dok;?> PDF formát"; } ?> 
<?php if( $zandroidu == 1 ) { echo "Doklad PDF prebraný, tlaèidlo Spä - do zoznamu objednávok"; } ?> 
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php 

$kontrolubyt = 1*$_REQUEST['kontrolubyt'];
$kontrolkuch = 1*$_REQUEST['kontrolkuch'];
if( $kontrolubyt == 1 OR $kontrolkuch == 1 )
     {
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopslu WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopfak WHERE dok = $cislo_dok ";
$dsql = mysql_query("$dsqlt");
     }
?>

<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
