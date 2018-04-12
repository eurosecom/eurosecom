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
$cislo_dok=1*$poleu[12];
$keyf=$poleu[8];

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

$newfntz=1*$_REQUEST['newfntz'];
if( $newfntz == 1 )
  {
$dajidk=0;
$sqldok = mysql_query("SELECT * FROM ".$databazaez."idxklizuid WHERE idxx = '".$keyf."' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $dajidk=$riaddok->kliuzid;
    }
$kli_uzid=$dajidk;

//$kli_uzid=17;

require_once("../androidfantozzi/setpdf_charset.php");
//pdf »åºæöËùû˝·Ì
  }

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
<html>
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

//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//tlac z archivu
if( $copern == 110 )
{
$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_dap = $_REQUEST['cislo_dap'];
$cislo_cpid = 1*$_REQUEST['cislo_cpid'];
$h_arch=0;
$h_drp=$cislo_druh;
$h_dap=$cislo_dap;

$kli_vume=$cislo_ume;
if( $cislo_stvrt == 1 ) { $kli_vume="1.".$kli_vrok; }
if( $cislo_stvrt == 2 ) { $kli_vume="4.".$kli_vrok; }
if( $cislo_stvrt == 3 ) { $kli_vume="7.".$kli_vrok; }
if( $cislo_stvrt == 4 ) { $kli_vume="10.".$kli_vrok; }
//echo $kli_vume;
}
//koniec nastav tlac z archivu

$zoznamzarchu=0;
//zoznam z archivu
if( $copern == 7020 )
{
$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_dap = "";
$cislo_cpid = 1*$_REQUEST['cislo_cpid'];
$rozdiel = 1*$_REQUEST['rozdiel'];
$h_arch=0;
$h_drp=$cislo_druh;
$h_dap="";
$fir_uctx01=1;

$kli_vume=$cislo_ume;
if( $cislo_stvrt == 1 ) { $kli_vume="1.".$kli_vrok; $fir_uctx01=2; }
if( $cislo_stvrt == 2 ) { $kli_vume="4.".$kli_vrok; $fir_uctx01=2; }
if( $cislo_stvrt == 3 ) { $kli_vume="7.".$kli_vrok; $fir_uctx01=2; }
if( $cislo_stvrt == 4 ) { $kli_vume="10.".$kli_vrok; $fir_uctx01=2; }
$zoznamzarchu=1;
$copern=20;
}
//koniec zoznam z archivu

if( $kli_vrok < 2012 )
{
?>
<script type="text/javascript">
  var okno = window.open("../ucto/prizdph.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&zdrd=<?php echo $zdrd; ?>
&h_drp=<?php echo $h_drp; ?>&h_dap=<?php echo $h_dap; ?>&h_arch=<?php echo $h_arch; ?>&chyby=<?php echo $chyby; ?>
&fir_uctx01=<?php echo $fir_uctx01; ?>&cislo_ume=<?php echo $cislo_ume; ?>&cislo_stvrt=<?php echo $cislo_stvrt; ?>
&cislo_druh=<?php echo $cislo_druh; ?>&cislo_dap=<?php echo $cislo_dap; ?>","_self");
</script>
<?php
exit;
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   er1          INT,
   er2          INT,
   er3          INT,
   er4          INT,
   zk0          DECIMAL(10,2),
   zk1          DECIMAL(10,2),
   zk2          DECIMAL(10,2),
   dn1          DECIMAL(10,2),
   dn2          DECIMAL(10,2),
   ume          FLOAT(8,4),
   dat          DATE,
   daz          DATE,
   psys         INT,
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   hod          DECIMAL(10,2),
   rdp          INT,
   rdk          INT,
   xrz          INT,
   xrd          INT,
   xsz          INT,
   ucm          VARCHAR(15),
   ucd          VARCHAR(15),
   ico          INT,
   fak          DECIMAL(10,0),
   dok          INT,
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r22          DECIMAL(10,2),
   r23          DECIMAL(10,2),
   r24          DECIMAL(10,2),
   r25          DECIMAL(10,2),
   r26          DECIMAL(10,2),
   r27          DECIMAL(10,2),
   r28          DECIMAL(10,2),
   r29          DECIMAL(10,2),
   r30          DECIMAL(10,2),
   r31          DECIMAL(10,2),
   r32          DECIMAL(10,2),
   r33          DECIMAL(10,2),
   r34          DECIMAL(10,2),
   r35          DECIMAL(10,2),
   r36          DECIMAL(10,2),
   r37          DECIMAL(10,2),
   r38          DECIMAL(10,2),
   fic          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   er1          INT,
   er2          INT,
   er3          INT,
   er4          INT,
   zk0          DECIMAL(10,2),
   zk1          DECIMAL(10,2),
   zk2          DECIMAL(10,2),
   dn1          DECIMAL(10,2),
   dn2          DECIMAL(10,2),
   ume          FLOAT(8,4),
   dat          DATE,
   daz          DATE,
   psys         INT,
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   hod          DECIMAL(10,2),
   rdp          INT,
   rdk          INT,
   xrz          INT,
   xrd          INT,
   xsz          INT,
   ucm          VARCHAR(15),
   ucd          VARCHAR(15),
   ico          INT,
   fak          DECIMAL(10,0),
   dok          INT,
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r22          DECIMAL(10,2),
   r23          DECIMAL(10,2),
   r24          DECIMAL(10,2),
   r25          DECIMAL(10,2),
   r26          DECIMAL(10,2),
   r27          DECIMAL(10,2),
   r28          DECIMAL(10,2),
   r29          DECIMAL(10,2),
   r30          DECIMAL(10,2),
   r31          DECIMAL(10,2),
   r32          DECIMAL(10,2),
   r33          DECIMAL(10,2),
   r34          DECIMAL(10,2),
   r35          DECIMAL(10,2),
   r36          DECIMAL(10,2),
   r37          DECIMAL(10,2),
   r38          DECIMAL(10,2),
   fic          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_archivdph';
//$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   ume          FLOAT(8,4),
   stvrtrok     INT,
   druh         INT,
   par79ods2    INT,
   dap          VARCHAR(10),
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r22          DECIMAL(10,2),
   r23          DECIMAL(10,2),
   r24          DECIMAL(10,2),
   r25          DECIMAL(10,2),
   r26          DECIMAL(10,2),
   r27          DECIMAL(10,2),
   r28          DECIMAL(10,2),
   r29          DECIMAL(10,2),
   r30          DECIMAL(10,2),
   r31          DECIMAL(10,2),
   r32          DECIMAL(10,2),
   r33          DECIMAL(10,2),
   r34          DECIMAL(10,2),
   r35          DECIMAL(10,2),
   r36          DECIMAL(10,2),
   fic          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_archivdph'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD koefmin DECIMAL(10,4) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD koefnew DECIMAL(10,4) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocall DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocupr DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocroz DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocall DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocupr DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocroz DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD druhykoef TEXT AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r19orig DECIMAL(10,2) DEFAULT 0 AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r18orig DECIMAL(10,2) DEFAULT 0 AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r37 DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r38 DECIMAL(10,2) AFTER r37";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD dad DATE NOT NULL AFTER fic";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD cpid INT AFTER druh";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD daid timestamp AFTER cpid";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph MODIFY cpid int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph MODIFY daid timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD cpop INT DEFAULT 0 AFTER daid";
$vysledek = mysql_query("$sql");

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$obddph="";
if( $fir_uctx01 == 2 ) {
$kli_mdph="";
if( $mesp_dph >= 1 AND $mesp_dph <= 3) { $mesp_dph=1; $mesk_dph=3; $obddph="1"; }
if( $mesp_dph >= 4 AND $mesp_dph <= 6) { $mesp_dph=4; $mesk_dph=6; $obddph="2"; }
if( $mesp_dph >= 7 AND $mesp_dph <= 9) { $mesp_dph=7; $mesk_dph=9; $obddph="3"; }
if( $mesp_dph >= 10 AND $mesp_dph <= 12) { $mesp_dph=10; $mesk_dph=12; $obddph="4"; }
                       }

if( $fir_uctx01 == 4 ) {
$kli_mdph="";
$mesp_dph=1; $mesk_dph=12; $obddph="5";
                       }

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;


////////////////////////////////////////////////len ked nie je tlac z archivu
if( $copern != 110 )
          {

$psys=11;
while ($psys <= 17 )
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober sklady
if( $psys == 17 ) { $uctovanie="uctskl"; $doklad="uctskl"; }

if( $psys <= 16 )
{
if( $psys <= 14 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,dat,$psys,0,0,0,0,0,0,0,0,0,0,".
"F$kli_vxcf"."_$uctovanie.hod,rdp,0,0,0,0,ucm,ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.dok,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( ( rdp > 1 ) OR ( rdp = 1 AND LEFT(ucm,3) = 343 ) OR ( rdp = 1 AND LEFT(ucd,3) = 343 ) )".
" AND ( ( rdp = 10 AND ucm = '343038' ) OR ( rdp = 10 AND ucm = '34338' ) OR ( rdp != 10 ) )".
" AND F$kli_vxcf"."_$doklad.dat >= '$datp_dph' AND F$kli_vxcf"."_$doklad.dat <= '$datk_dph' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
     }
if( $psys == 15 OR $psys == 16 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,$psys,0,0,0,0,0,0,0,0,0,0,".
"F$kli_vxcf"."_$uctovanie.hod,rdp,0,0,0,0,ucm,ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.dok,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( ( rdp > 1 AND rdp != 10 ) OR ( LEFT(ucd,3) = 343 OR LEFT(ucm,3) = 343 ) )".
" AND ( ( F$kli_vxcf"."_$doklad.dat >= '$datp_dph' AND F$kli_vxcf"."_$doklad.dat <= '$datk_dph' ) ".
" OR  ( F$kli_vxcf"."_$doklad.daz >= '$datp_dph' AND F$kli_vxcf"."_$doklad.daz <= '$datk_dph' ) )";
$dsql = mysql_query("$dsqlt");
     }


}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,dat,$psys,0,0,0,0,0,0,0,0,0,0,".
"F$kli_vxcf"."_$uctovanie.hod,rdp,0,0,0,0,ucm,ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.dok,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE ( ( rdp > 1 AND rdp != 10 ) OR ( LEFT(ucd,3) = 343 OR LEFT(ucm,3) = 343 ) )".
" AND ( F$kli_vxcf"."_$doklad.dat >= '$datp_dph' AND F$kli_vxcf"."_$doklad.dat <= '$datk_dph' ) ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//exit;

//ak je jednoduche daj prec uce 34399 rdp 1
if( $kli_vduj == 9 )
{

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE ( ucm = 34399 OR ucd = 34399 ) AND rdp = 1";
$oznac = mysql_query("$sqtoz");

//exit;

}

if( $fir_xvr05 != 2 AND $kli_vrok >= 2016 ) {
//tu musim upravit podla prijatych platieb ak dppx=1
//1. dam prec ak dppx=1 a nema uhrady v tomto obdobi
//2. nastavim daz na datum prijatia platby ak dppx=1 a ma uhrady v tomto obdobi ( pred tym suma uhrad )
//3. pridam dppx=1 ak daz je z minulych obdobi a nastavim daz na datum prijatia platby ( pred tym suma uhrad )

$sqltt = "DROP TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE prx7 = 0 AND dpp >= '$datp_dph' AND dpp <= '$datk_dph' ";
$sql = mysql_query("$sqltt");

//cpld	dok	druh	dppx	prx7	dou	dpp	dau	hd2	hz2	hd1	hz1	hou

$sqltt = "INSERT INTO F$kli_vxcf"."_uctfakuhrdphs$kli_uzid SELECT ".
" 0,dok,druh,dppx,9,dou,MAX(dpp),dau,SUM(hd2),SUM(hz2),SUM(hd1),SUM(hz1),SUM(hou) ".
" FROM F$kli_vxcf"."_uctfakuhrdphs$kli_uzid WHERE prx7 = 0 GROUP BY dok ";
$sql = mysql_query("$sqltt");

$sqltt = "DELETE FROM F$kli_vxcf"."_uctfakuhrdphs$kli_uzid WHERE prx7 != 9 ";
$sql = mysql_query("$sqltt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE prx7 = 1 ORDER BY dok";
//echo $sqltt."<br />";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i11=0;
  while ($i11 <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i11))
{
$hlavicka=mysql_fetch_object($sql);

//echo $hlavicka->dok."<br />";

$mapp=0; $druhpp=0; $hz2pp=0; $hd2pp=0; $hz1pp=0; $hd1pp=0;
$sqldot = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdphs$kli_uzid WHERE prx7 = 9 AND dok = $hlavicka->dok ORDER BY dok";
$sqldok = mysql_query("$sqldot");
$poldok = 1*mysql_num_rows($sqldok);
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $mapp=1;
  $druhpp=1*$riaddok->druh;
  $hz2pp=1*$riaddok->hz2;
  $hd2pp=1*$riaddok->hd2;
  $hz1pp=1*$riaddok->hz1;
  $hd1pp=1*$riaddok->hd1;
  $dpppp=$riaddok->dpp;
  }

//echo $hlavicka->dok." druh ".$druhpp." mapp ".$mapp." hz2 ".$hz2pp." hd2 ".$hd2pp."<br />";

if( $mapp == 0 )
  {
$sqlttd = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok ";
$sqld = mysql_query("$sqlttd");
  }



if( $mapp == 1 )
  {
$ume=$kli_vume;

if( $druhpp == 2 )
      {
$psysx=16;
$rdp=25; $rdp10=30;
//echo "idem druhpp 2"."<br />";

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctdod WHERE dok = $hlavicka->dok AND rdp = 25 AND LEFT(ucm,3) != 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $fak=1*$riaddok->fak;
  $ico=1*$riaddok->ico;
  $ucmz=$riaddok->ucm;
  $ucd=$riaddok->ucd;
  }
$sqldot = "SELECT * FROM F$kli_vxcf"."_uctdod WHERE dok = $hlavicka->dok AND rdp = 25 AND LEFT(ucm,3) = 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucmd=$riaddok->ucm;
  }

$sqlttd = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok AND rdp = $rdp ";
$sqld = mysql_query("$sqlttd");

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hz2pp', '$rdp', 0, 0, 0, 0, '$ucmz', '$ucd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hz2pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hd2pp', '$rdp', 0, 0, 0, 0, '$ucmd', '$ucd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hd2pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqlttd = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok AND rdp = $rdp10 ";
$sqld = mysql_query("$sqlttd");

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctdod WHERE dok = $hlavicka->dok AND rdp = 30 AND LEFT(ucm,3) != 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucmz=$riaddok->ucm;
  }

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctdod WHERE dok = $hlavicka->dok AND rdp = 30 AND LEFT(ucm,3) = 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucmd=$riaddok->ucm;
  }

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hz1pp', '$rdp10', 0, 0, 0, 0, '$ucmz', '$ucd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hz1pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hd1pp', '$rdp10', 0, 0, 0, 0, '$ucmd', '$ucd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hd1pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

      }
//koniec druhpp=2

if( $druhpp == 1 AND $fir_xvr05 == 1 )
      {
$psysx=15;
$rdp=55; $rdp10=60;
//echo "idem druhpp 1"."<br />";

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $hlavicka->dok AND rdp = 55 AND LEFT(ucd,3) != 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $fak=1*$riaddok->fak;
  $ico=1*$riaddok->ico;
  $ucdz=$riaddok->ucd;
  $ucm=$riaddok->ucm;
  }
$sqldot = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $hlavicka->dok AND rdp = 55 AND LEFT(ucd,3) = 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucdd=$riaddok->ucd;
  }

$sqlttd = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok AND rdp = $rdp ";
$sqld = mysql_query("$sqlttd");

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hz2pp', '$rdp', 0, 0, 0, 0, '$ucm', '$ucdz', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hz2pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hd2pp', '$rdp', 0, 0, 0, 0, '$ucm', '$ucdd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hd2pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $hlavicka->dok AND rdp = 60 AND LEFT(ucd,3) != 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucdz=$riaddok->ucd;
  }

$sqldot = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $hlavicka->dok AND rdp = 60 AND LEFT(ucd,3) = 343 ";
$sqldok = mysql_query("$sqldot");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucdd=$riaddok->ucd;
  }


$sqlttd = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok AND rdp = $rdp10 ";
$sqld = mysql_query("$sqlttd");

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hz1pp', '$rdp10', 0, 0, 0, 0, '$ucm', '$ucdz', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hz1pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

$sqltti = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" ( er1, er2, er3, er4, zk0, zk1, zk2, dn1, dn2, ume, dat, daz, psys, r01, r02, r03, r04, r05, r06, r07, r08, r09, r10, ".
" hod, rdp, rdk, xrz, xrd, xsz, ucm, ucd, ico, fak, dok, ".
" r11, r12, r13, r14, r15, r16, r17, r18, r19, r20, r21, r22, r23, r24, r25, r26, r27, r28, r29, r30, r31, r32, r33, r34, r35, r36, r37, r38, fic ) ".
" VALUES ( 0, 0, 0, 0, 0, 0, 0, 0, 0, '$ume', '$dpppp', '$dpppp', '$psysx', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".
" '$hd1pp', '$rdp10', 0, 0, 0, 0, '$ucm', '$ucdd', '$ico', '$fak', '$hlavicka->dok', ".
" 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$fir_fico' )";
//echo $sqltti."<br />";
if( $hd1pp != 0 ) {  $sqli = mysql_query("$sqltti"); }

      }
//koniec druhpp=1 AND $fir_xvr05 == 1

  }
//koniec mapp=1



//echo $hlavicka->dok." druh ".$druhpp." mapp ".$mapp." hz2 ".$hz2pp." hd2 ".$hd2pp."<br />";

}
$i11 = $i11 + 1;
  }
//exit;

$sqltt = "DROP TABLE F$kli_vxcf"."_uctfakuhrdphs".$kli_uzid." ";
$sql = mysql_query("$sqltt");

                                            }
//koniec dph po prijatej platbe
//exit;

//dovoz z 3k JCD, blok urob len ak su jcd crz1=1 v ciselniku drdp
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE crz1 = 1 AND ucd = $fir_uctx08 ";
//$sql = mysql_query("$sqltt");
$poljcd = mysql_num_rows($sql);
if( $fir_uctx07 == 1 )
     {

$sqlt = <<<uctmzd
(
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         DECIMAL(10,0),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctjcdarch'.$sqlt;
$ulozene = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctjcdarch MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");

//vymaz druhy jcd ak su
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid ,F$kli_vxcf"."_uctdrdp".
" SET xrz=999, xrd=999, xsz=999".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp AND F$kli_vxcf"."_uctdrdp.crz1 = 1 AND ucd = $fir_uctx08 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE ( xrz = 999 AND xrd = 999 AND xsz = 999 ) ";
$oznac = mysql_query("$sqtoz");

//daj jcd z dodavatelskych faktur od.pociatku roku ak su uhradene v tomto obdobi
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid"." SELECT".
" 0,0,0,0,0,0,0,0,0,0,'0000-00-00','0000-00-00',16,0,0,0,0,0,0,0,0,0,0,".
"hod,F$kli_vxcf"."_uctdod.rdp,0,0,0,0,ucm,ucd,ico,fak,dok,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_uctdod,F$kli_vxcf"."_uctdrdp".
" WHERE F$kli_vxcf"."_uctdod.rdp=F$kli_vxcf"."_uctdrdp.rdp AND F$kli_vxcf"."_uctdrdp.crz1 = 1 AND F$kli_vxcf"."_uctdod.ucd = $fir_uctx08 ";
$dsql = mysql_query("$dsqlt");


//daj prec JCD ak uz su v archive uplatnene
$umep_dph=$mesp_dph.".".$rokp_dph;

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid ,F$kli_vxcf"."_uctjcdarch".
" SET xrz=999, xrd=999, xsz=999".
" WHERE F$kli_vxcf"."_prcprizdphsy$kli_uzid.dok=F$kli_vxcf"."_uctjcdarch.dok AND F$kli_vxcf"."_uctjcdarch.ume < $umep_dph ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphsy$kli_uzid WHERE ( xrz = 999 AND xrd = 999 AND xsz = 999 ) ";
$oznac = mysql_query("$sqtoz");

//exit;

//dopln udaje z fakdod
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid ,F$kli_vxcf"."_fakdod".
" SET F$kli_vxcf"."_prcprizdphsy$kli_uzid.ume=F$kli_vxcf"."_fakdod.ume,".
"     F$kli_vxcf"."_prcprizdphsy$kli_uzid.dat=F$kli_vxcf"."_fakdod.dat,".
"     F$kli_vxcf"."_prcprizdphsy$kli_uzid.daz=F$kli_vxcf"."_fakdod.daz ".
" WHERE F$kli_vxcf"."_prcprizdphsy$kli_uzid.dok=F$kli_vxcf"."_fakdod.dok ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vyhodnot uhrady
$sqlt = "DROP TABLE F$kli_vxcf"."_prcprizdphuh".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   psys         INT,
   umh          FLOAT(8,4),
   duh          DATE,
   ico          INT,
   fak          DECIMAL(10,0),
   dok          INT,
   hou          DECIMAL(10,2),
   prx          INT
);
prcdatum;

$vsql = "CREATE TABLE F$kli_vxcf"."_prcprizdphuh".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphuh$kli_uzid"." SELECT ".
"4,0,'0000-00-00',ico,fak,dok,hod,0 ".
" FROM F$kli_vxcf"."_uctban".
" WHERE ( LEFT(ucd,3) = 211 OR LEFT(ucd,3) = 221 ) AND ucm = $fir_uctx08 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphuh$kli_uzid"." SELECT ".
"2,0,'0000-00-00',ico,fak,dok,hod,0 ".
" FROM F$kli_vxcf"."_uctpokuct".
" WHERE ( LEFT(ucd,3) = 211 OR LEFT(ucd,3) = 221 ) AND ucm = $fir_uctx08 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphuh$kli_uzid ,F$kli_vxcf"."_prcprizdphsy$kli_uzid".
" SET  F$kli_vxcf"."_prcprizdphuh$kli_uzid.prx=999 ".
" WHERE F$kli_vxcf"."_prcprizdphuh$kli_uzid.ico=F$kli_vxcf"."_prcprizdphsy$kli_uzid.ico AND ".
" F$kli_vxcf"."_prcprizdphuh$kli_uzid.fak=F$kli_vxcf"."_prcprizdphsy$kli_uzid.fak ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid WHERE prx != 999 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphuh$kli_uzid ,F$kli_vxcf"."_banvyp".
" SET umh=ume, duh=dat ".
" WHERE F$kli_vxcf"."_prcprizdphuh$kli_uzid.dok=F$kli_vxcf"."_banvyp.dok AND psys=4";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphuh$kli_uzid ,F$kli_vxcf"."_pokvyd".
" SET umh=ume, duh=dat ".
" WHERE F$kli_vxcf"."_prcprizdphuh$kli_uzid.dok=F$kli_vxcf"."_pokvyd.dok AND psys=2";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid WHERE duh > '$datk_dph' ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphuh$kli_uzid"." SELECT ".
"psys,MAX(umh),MAX(duh),ico,fak,dok,SUM(hou),9 ".
" FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid".
" WHERE hou != 0 ".
" GROUP by ico,fak ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid WHERE prx != 9 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid,F$kli_vxcf"."_prcprizdphuh$kli_uzid ".
" SET F$kli_vxcf"."_prcprizdphsy$kli_uzid.r01=hou, daz=duh ".
" WHERE F$kli_vxcf"."_prcprizdphsy$kli_uzid.ico=F$kli_vxcf"."_prcprizdphuh$kli_uzid.ico AND ".
" F$kli_vxcf"."_prcprizdphsy$kli_uzid.fak=F$kli_vxcf"."_prcprizdphuh$kli_uzid.fak ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphsy$kli_uzid".
" WHERE F$kli_vxcf"."_prcprizdphsy$kli_uzid.r01 >= F$kli_vxcf"."_prcprizdphsy$kli_uzid.hod";
$dsql = mysql_query("$dsqlt");

//exit;

//uloz jcd do archivu
if( $fir_uctx01 != 4 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctjcdarch WHERE ume = $umep_dph ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctjcdarch"." SELECT '$umep_dph','0000-00-00',dok,0,0,0,0,0,0,0,ico,fak,'',0,0,'',0,0 ".
" FROM F$kli_vxcf"."_prcprizdphsy$kli_uzid".
" WHERE F$kli_vxcf"."_prcprizdphsy$kli_uzid.r01 >= F$kli_vxcf"."_prcprizdphsy$kli_uzid.hod";
$dsql = mysql_query("$dsqlt");
     }
$sqtoz = "UPDATE F$kli_vxcf"."_uctjcdarch,F$kli_vxcf"."_prcprizdphuh$kli_uzid ".
" SET F$kli_vxcf"."_uctjcdarch.poh=F$kli_vxcf"."_prcprizdphuh$kli_uzid.dok ".
" WHERE F$kli_vxcf"."_uctjcdarch.ico=F$kli_vxcf"."_prcprizdphuh$kli_uzid.ico AND ".
" F$kli_vxcf"."_uctjcdarch.fak=F$kli_vxcf"."_prcprizdphuh$kli_uzid.fak ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphsy$kli_uzid WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r01=0 ";
$oznac = mysql_query("$sqtoz");

//echo "umep".$umep_dph;
//echo "datk".$datk_dph;
//exit;
     }
//koniec dovoz 3k JCD

//zober JCD z minuleho roka ulozene v uctdb_dokladov
if( $fir_uctx07 == 1 )
     {
$poles = explode(".", $kli_vume);
$kli_vmesj=1*$poles[0];
if( $kli_vmesj < 10 ) { $kli_vmesj="0".$kli_vmesj; }
$datx1=$kli_vrok."-".$kli_vmesj."-01";

$pdok="dph ".$kli_vmesj.".".$kli_vrok;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,0,0,0,0,0,0,0,0,'$kli_vume','$datx1','$datx1',16,0,0,0,0,0,0,0,0,0,0,".
"hod,rdp,0,0,0,0,ucm,ucd,ico,fak,dok,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_uctdb_dokladov ".
" WHERE ucd = $fir_uctx08 AND pdok = '$pdok' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

     }
//koniec zober JCD z minuleho roka ulozene v uctdb_dokladov
//exit;

//nastav crz,crd,szd podla rdp
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid ,F$kli_vxcf"."_uctdrdp".
" SET xrz=crz, xrd=crd, xsz=szd".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $poliklinikase == 0 )
{
//dopocitaj zaklad samozdanenia
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT ".
"er1,er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
"r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,".
"((hod/$fir_dph2)*100),(rdp+50),rdk,xrz,xrd,xsz,55555,ucd,ico,fak,dok,".
"r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,fic ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE xrz = 7 OR xrz = 9 OR xrz = 11 OR xrz = 13 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT ".
"er1,er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
"r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,".
"((hod/$fir_dph1)*100),(rdp+50),rdk,xrz,xrd,xsz,55555,ucd,ico,fak,dok,".
"r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,fic ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE xrz = 5 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}


if( $alchem == 1 )
{
//dopocitaj zaklad samozdanenia pre cesky pohyb 46druh na vstupe
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT ".
"er1,er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
"r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,".
"((hod/$fir_dph2)*100),(rdp+40),rdk,xrz,xrd,xsz,55555,ucd,ico,fak,dok,".
"r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,fic ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE rdp = 46 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//nastav rdk zaklad
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid ,F$kli_vxcf"."_uctdrdp".
" SET rdk=xrz".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp AND LEFT(ucm,3) != 343 AND LEFT(ucd,3) != 343 ";
$oznac = mysql_query("$sqtoz");

//nastav rdk dph
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid ,F$kli_vxcf"."_uctdrdp".
" SET rdk=xrd".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp AND ( LEFT(ucm,3) = 343 OR LEFT(ucd,3) = 343 )";
$oznac = mysql_query("$sqtoz");

//nastav rdk dph vratenie pri vyvoze riadok 30
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" SET rdk=30".
" WHERE ( ucm = 34338 AND rdp = 10 ) OR ( ucm = 343038 AND rdp = 10 )";
$oznac = mysql_query("$sqtoz");


//tu zistim ci ak hod < 0 dph je to dobropis dodavatelsky alebo len zuctovanie zalohy...
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE ( rdk = 20 OR rdk = 21 OR rdk = 22  OR rdk = 23 ) AND rdp != 34 AND hod < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r38=0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r38=hod WHERE ( rdk = 20 OR rdk = 21 OR rdk = 22  OR rdk = 23 ) AND rdp != 34 AND hod > 0 ";
$oznac = mysql_query("$sqtoz");

$vsql = "DROP TABLE F$kli_vxcf"."_dphprcx$kli_uzid ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<dphprc
(
   pox          DECIMAL(10,0) DEFAULT 0,
   pow          DECIMAL(10,0) DEFAULT 0,
   dok          DECIMAL(10,0) DEFAULT 0,
   hdph         DECIMAL(10,2) DEFAULT 0,
   kon          INT(7) DEFAULT 0
);
dphprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dphprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dphprcx$kli_uzid"." SELECT ".
"SUM(er1),SUM(r38),dok,SUM(hod),0 ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE ( rdk = 20 OR rdk = 21 OR rdk = 22  OR rdk = 23 ) AND rdp != 34 GROUP BY dok";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_dphprcx$kli_uzid WHERE pox=0 OR hdph > 0 OR pow > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid,F$kli_vxcf"."_dphprcx$kli_uzid SET er1=1 ".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.dok=F$kli_vxcf"."_dphprcx$kli_uzid.dok ";
$oznac = mysql_query("$sqtoz");

$vsql = 'DROP TABLE F'.$kli_vxcf.'_dphprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
//koniec tu zistim ci ak hod < 0 dph je to dobropis dodavatelsky alebo len zuctovanie zalohy...


//ak je dobropis moj dodavatelsky presun dph r20,21,22,23 do r28  ( okrem sluzieb zo zahranicia samozdanenie rdp 34,84 )
if( $chyby == 0 AND $copern != 40 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=28, hod=-hod WHERE ( rdk = 20 OR rdk = 22 ) AND rdp != 34 AND hod < 0 AND er1 = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=28, hod=-hod WHERE ( rdk = 21 OR rdk = 23 ) AND rdp != 34 AND hod < 0 AND er1 = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=28, hod=-hod WHERE ( rdk = 21 OR rdk = 23 ) AND rdp = 225 AND hod > 0 AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");
//exit;
                                    }




$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r38=0 ";
$oznac = mysql_query("$sqtoz");

//tu zistim ci ak hod < 0 dph je to dobropis odberatelsky alebo len zuctovanie zalohy...
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 ".
" WHERE ( xrd = 02 OR xrd = 04 OR xrd = 06 OR xrd = 08 OR xrd = 10 ) AND hod < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r38=hod ".
" WHERE ( xrd = 02 OR xrd = 04 OR xrd = 06 OR xrd = 08 OR xrd = 10 ) AND hod > 0 ";
$oznac = mysql_query("$sqtoz");

$vsql = "DROP TABLE F$kli_vxcf"."_dphprcx$kli_uzid ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<dphprc
(
   pox          DECIMAL(10,0) DEFAULT 0,
   pow          DECIMAL(10,0) DEFAULT 0,
   dok          DECIMAL(10,0) DEFAULT 0,
   hdph         DECIMAL(10,2) DEFAULT 0,
   kon          INT(7) DEFAULT 0
);
dphprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dphprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dphprcx$kli_uzid"." SELECT ".
"SUM(er1),SUM(r38),dok,SUM(hod),0 ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE ( xrd = 02 OR xrd = 04 OR xrd = 06 OR xrd = 08 OR xrd = 10 ) GROUP BY dok";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_dphprcx$kli_uzid WHERE pox=0 OR hdph > 0 OR pow > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid,F$kli_vxcf"."_dphprcx$kli_uzid SET er1=1 ".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.dok=F$kli_vxcf"."_dphprcx$kli_uzid.dok ";
$oznac = mysql_query("$sqtoz");

$vsql = 'DROP TABLE F'.$kli_vxcf.'_dphprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
//koniec tu zistim ci ak hod < 0 dph je to dobropis odberatelsky alebo len zuctovanie zalohy...


//ak je dobropis moj odberatelsky presun zaklad do r26 a dph do r27  ( okrem sluzieb zo zahranicia samozdanenie rdp 34,84 xrz=11,xrd=12 )
if( $chyby == 0 AND $copern != 40 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=26 ".
" WHERE ( xrz = 01 OR xrz = 03 OR xrz = 05 OR xrz = 07 OR xrz = 09 ) AND hod < 0 AND LEFT(ucd,3) != 343 AND er1 = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=27 ".
" WHERE ( xrd = 02 OR xrd = 04 OR xrd = 06 OR xrd = 08 OR xrd = 10 ) AND hod < 0 AND LEFT(ucd,3) = 343 AND er1 = 1 ";
$oznac = mysql_query("$sqtoz");
                                    }
if( $chyby == 0 AND $copern != 40 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=26 ".
" WHERE ( xrz = 01 OR xrz = 03 OR xrz = 05 OR xrz = 07 OR xrz = 09 ) AND ( rdp = 255 OR rdp = 260 ) AND hod > 0 AND LEFT(ucd,3) != 343 AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=27 ".
" WHERE ( xrd = 02 OR xrd = 04 OR xrd = 06 OR xrd = 08 OR xrd = 10 ) AND ( rdp = 255 OR rdp = 260 ) AND hod > 0 AND LEFT(ucd,3) = 343 AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");
                                    }
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r38=0 ";
$oznac = mysql_query("$sqtoz");

//rozdel do rdk

$rdk=1;
while ($rdk <= 38 )
  {
if( $rdk < 10 ) $sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r0$rdk=hod WHERE rdk=$rdk";
if( $rdk >= 10 ) $sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r$rdk=hod WHERE rdk=$rdk";
$oznac = mysql_query("$sqtoz");
$rdk=$rdk+1;
  }


//trojstranny rdp=63 daj aj do r36
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET r36=hod ".
" WHERE rdp = 63 AND xrz = 16 ";
$oznac = mysql_query("$sqtoz");

//suma za vsetko bez zaokruhlenia
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,999,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"0,0,0,0,0,0,'','',0,0,0,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE rdk > 0 AND ( daz >= '$datp_dph' AND daz <= '$datk_dph' )".
" GROUP BY fic".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//suma za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsx$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,999,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"0,0,0,0,0,0,'','',0,0,0,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys = 999".
" GROUP BY fic".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//prepocty
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsx$kli_uzid".
" SET r19=r02+r04+r06+r08+r10+r12+r14+r18, r15=r15+r16+r17, r20=r20+r22+r24, r21=r21+r23+r25, r31=r19-r21-r20-r29-r30+r27+r28-r30 ".
" WHERE psys = 999";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsx$kli_uzid".
" SET r32=0, r33=0, r34=r31 ".
" WHERE r31 >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsx$kli_uzid".
" SET r32=-r31, r33=0, r34=0 ".
" WHERE r31 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsx$kli_uzid".
" SET r31=0 ".
" WHERE r31 < 0 ";
$oznac = mysql_query("$sqtoz");


          }
////////////////////////////////////////////////koniec len ked nie je tlac z archivu

$zarchivu=0;

////////////////////////////////////////////////len ked je tlac z archivu
if( $copern == 110 )
          {

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsx$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,$cislo_ume,0,0,999,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"0,0,0,0,0,0,'','',0,0,par79ods2,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"$fir_fico".
" FROM F$kli_vxcf"."_archivdph".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_archivdph WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $dadod=$riadok->dad;
  }



if( $cislo_stvrt > 0 ) { $obddph=$cislo_stvrt; $kli_mdph=""; }
$copern=10;
$zarchivu=1;
          }
////////////////////////////////////////////////koniec len ked je tlac z archivu


if( $copern == 10 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsx".$kli_uzid." WHERE fic > 0 "."";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}
if( $copern == 20 OR $copern == 30 )
{
//ak zoznam z archu
if( $zoznamzarchu == 1 )
  {
//archzoznam er1  er2  er3  er4  zk0  zk1  zk2  dn1  dn2  ume  dat  daz  psys  r01  r02  r03  r04  r05  r06  r07  r08  r09  r10
//hod  rdp  rdk  xrz  xrd  xsz  ucm  ucd  ico  fak  dok  r11  r12  r13  r14  r15  r16  r17  r18  r19  r20  r21  r22
//r23  r24  r25  r26  r27  r28  r29  r30  r31  r32  r33  r34  r35  r36  r37  r38  fic

//aktualny   er1  er2  er3  er4  zk0  zk1  zk2  dn1  dn2  ume  dat  daz  psys  r01  r02  r03  r04  r05  r06  r07  r08  r09  r10
//hod  rdp  rdk  xrz  xrd  xsz  ucm  ucd  ico  fak  dok  r11  r12  r13  r14  r15  r16  r17  r18  r19  r20  r21  r22
//r23  r24  r25  r26  r27  r28  r29  r30  r31  r32  r33  r34  r35  r36  r37  r38  fic

if( $cislo_stvrt == 0 ) { $podmzarchu=" er1 = 0 AND ume = $cislo_ume "; }
if( $cislo_stvrt > 0 ) { $podmzarchu=" er1 = $cislo_stvrt "; }

if( $rozdiel == 0 ) {
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_archivdphzoznam ".
" WHERE $podmzarchu AND er4 = $cislo_cpid ".
" GROUP BY rdk,dok,fak,ico,hod ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
                    }

if( $rozdiel == 1 ) {
$sqtoz = "DROP TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid SELECT * FROM F$kli_vxcf"."_archivdphzoznam WHERE $podmzarchu AND er4 = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid SET er2=0 WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid,F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" SET F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.er2=9 ".
" WHERE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.rdk=F$kli_vxcf"."_prcprizdphs$kli_uzid.rdk AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.dok=F$kli_vxcf"."_prcprizdphs$kli_uzid.dok AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.fak=F$kli_vxcf"."_prcprizdphs$kli_uzid.fak AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.ico=F$kli_vxcf"."_prcprizdphs$kli_uzid.ico AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.hod=F$kli_vxcf"."_prcprizdphs$kli_uzid.hod  ";

$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_archivdphzoznam2x$kli_uzid ".
" WHERE $podmzarchu AND er2 = 0 ".
" GROUP BY rdk,dok,fak,ico,hod ".
"";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DROP TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid ";
$oznac = mysql_query("$sqtoz");
                    }

if( $rozdiel == 2 ) {
$sqtoz = "DROP TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid SELECT * FROM F$kli_vxcf"."_archivdphzoznam WHERE $podmzarchu AND er4 = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=0 WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid,F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" SET F$kli_vxcf"."_prcprizdphs$kli_uzid.er2=9 ".
" WHERE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.rdk=F$kli_vxcf"."_prcprizdphs$kli_uzid.rdk AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.dok=F$kli_vxcf"."_prcprizdphs$kli_uzid.dok AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.fak=F$kli_vxcf"."_prcprizdphs$kli_uzid.fak AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.ico=F$kli_vxcf"."_prcprizdphs$kli_uzid.ico AND ".
"       F$kli_vxcf"."_archivdphzoznam2x$kli_uzid.hod=F$kli_vxcf"."_prcprizdphs$kli_uzid.hod  ";

$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE er2 = 9 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DROP TABLE F$kli_vxcf"."_archivdphzoznam2x$kli_uzid ";
$oznac = mysql_query("$sqtoz");
                    }

  }
//koniec ak zoznam z archu

//suma za riadok psys=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,0,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),0,rdk,0,0,0,'','',0,0,0,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE rdk > 0 AND ( daz >= '$datp_dph' AND daz <= '$datk_dph' )".
" GROUP BY rdk".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//tuto pridam sumu za druh v riadku zoznm psys=998
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,0,0,0,0,0,0,0,0,ume,dat,daz,998,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,0,0,0,'','',0,0,0,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys != 0 AND rdk > 0 AND ( daz >= '$datp_dph' AND daz <= '$datk_dph' )".
" GROUP BY rdk,rdp".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphs".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphs$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys < 999 AND rdk > 0  AND ( daz >= '$datp_dph' AND daz <= '$datk_dph' ) ".
" ORDER BY rdk,psys,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

if( $copern == 40 )
{
//nastav eror ak nesedi ucm,ucd 343 a rdp?? , ak nesedi dat a daz vynuluj sumy a upozorni
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE LEFT(ucm,3) = 343 AND rdp >  50 AND rdp <  99 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE LEFT(ucm,3) = 343 AND rdp > 150 AND rdp < 199 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE LEFT(ucm,3) = 343 AND rdp > 250 AND rdp < 299 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE LEFT(ucm,3) = 343 AND rdp > 350 AND rdp < 399 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE LEFT(ucm,3) = 343 AND rdp > 450 AND rdp < 499 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=1 WHERE LEFT(ucd,3) = 343 AND rdp >  11 AND rdp <  50";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=1 WHERE LEFT(ucd,3) = 343 AND rdp > 111 AND rdp < 150";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=1 WHERE LEFT(ucd,3) = 343 AND rdp > 211 AND rdp < 250";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=1 WHERE LEFT(ucd,3) = 343 AND rdp > 311 AND rdp < 350";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er2=1 WHERE LEFT(ucd,3) = 343 AND rdp > 411 AND rdp < 450";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er3=1 WHERE daz < '$datp_dph' OR daz > '$datk_dph'";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er3=1 WHERE dat < '$datp_dph' OR dat > '$datk_dph'";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er4=1 WHERE ( LEFT(ucd,3) = 343 AND rdp = 1 ) OR ( LEFT(ucm,3) = 343 AND rdp = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE ( LEFT(ucm,3) = 343 OR LEFT(ucm,3) = 343 ) AND xsz = 0 AND rdp != 11 ";
$oznac = mysql_query("$sqtoz");

//nastav zk0
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET zk0=hod WHERE xsz = 0 AND rdp > 1 ";
$oznac = mysql_query("$sqtoz");

//nastav zk1
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET zk1=hod WHERE xsz = $fir_dph1 AND LEFT(ucm,3) != 343 AND LEFT(ucd,3) != 343 ";
$oznac = mysql_query("$sqtoz");

//nastav zk2
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET zk2=hod WHERE ( xsz = 19 OR xsz = $fir_dph2 ) AND LEFT(ucm,3) != 343 AND LEFT(ucd,3) != 343 ";
$oznac = mysql_query("$sqtoz");

//nastav dn1
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dn1=hod WHERE xsz = $fir_dph1 AND ( LEFT(ucm,3) = 343 OR LEFT(ucd,3) = 343 )";
$oznac = mysql_query("$sqtoz");

//nastav dn1
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dn2=hod WHERE ( xsz = 19 OR xsz = $fir_dph2 ) AND ( LEFT(ucm,3) = 343 OR LEFT(ucd,3) = 343 )";
$oznac = mysql_query("$sqtoz");

if( $chyby == 1 AND $poliklinikase == 0 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dn1=0, dn2=0 WHERE ( rdk = 8 OR rdk = 10 OR rdk = 12 OR rdk = 14 ) ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dn1=0 WHERE ( rdk = 6 ) ";
$oznac = mysql_query("$sqtoz");
                  }

if( $chyby == 1 AND $alchem == 1 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dn1=0, dn2=0 WHERE rdp = 46 ";
$oznac = mysql_query("$sqtoz");
                  }

//suma doklad
if( $zdrd < 10 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT".
" SUM(er1),SUM(er2),SUM(er3),SUM(er4),SUM(zk0),SUM(zk1),SUM(zk2),SUM(dn1),SUM(dn2),ume,dat,daz,psys,0,0,0,0,0,0,0,0,0,0,".
"hod,rdp,rdk,xrz,xrd,xsz,'','',ico,fak,dok,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys < 999 AND psys > 0 ".
" GROUP BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
                  }

//nastav eror ak nesedi dph=sadzba*zaklad/100 plus,minus 5centov
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid SET r01=$fir_dph2*zk2/100, r02=r01-dn2 WHERE dok > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid SET er3=1 WHERE r02 < -0.05 OR r02 > 0.05";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid SET r11=$fir_dph1*zk1/100, r12=r11-dn1 WHERE dok > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsy$kli_uzid SET er3=1 WHERE r12 < -0.05 OR r12 > 0.05";
$oznac = mysql_query("$sqtoz");

if( $chyby == 0 AND $zdrd == 0 AND $zfak == 0 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys > 0 ORDER BY dok";
//echo $sqltt;
                  }

if( $chyby == 0 AND $zfak >= 10 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys > 0 ORDER BY fak,dok";
//echo $sqltt;
                  }

if( $chyby == 0 AND $zdrd >= 10 ) {
//suma doklad,druh
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT".
" SUM(er1),SUM(er2),SUM(er3),SUM(er4),SUM(zk0),SUM(zk1),SUM(zk2),SUM(dn1),SUM(dn2),ume,dat,daz,psys,0,0,0,0,0,0,0,0,0,0,".
"hod,rdp,rdk,xrz,xrd,xsz,'','',ico,fak,dok,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys < 999 AND psys > 0 ".
" GROUP BY dok,rdp".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//suma druh
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT".
" 0,0,0,0,SUM(zk0),SUM(zk1),SUM(zk2),SUM(dn1),SUM(dn2),ume,dat,daz,9999,0,0,0,0,0,0,0,0,0,0,".
"hod,rdp,rdk,xrz,xrd,xsz,'','',0,0,999999999,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys < 999 AND psys > 0 ".
" GROUP BY rdp".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys > 0 ORDER BY rdp,dok";
//echo $sqltt;
                  }

if( $chyby == 1 ) {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys > 0 AND ( er1 > 0 OR er2 > 0 OR er3 > 0 OR er4 > 0 ) ORDER BY dok";
//echo $sqltt;
                  }

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

?>
<?php
if( $zandroidu == 0 OR $pdfand == 1 )
  {
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DaÚ z pridanej hodnoty</title>
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
</head>
<body class="white" >
<?php if( $pdfand == 1    ) { ?>
<table class="h2" width="100%" >
<tr>
<td>Zostava PDF prebran·, tlaËidlo Sp‰ù - do daÚov˝ch zost·v</td>
<td align="right"></td>
</tr>
</table>
<br />
<?php                       } ?>
<?php
  }
?>
<?php
//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//.jpg podklad
$jpg_source="../dokumenty/tlacivo2018/dph/dph_v18";
$jpg_title="tlaËivo DaÚovÈ priznanie pre daÚ z pridanej hodnoty pre rok $kli_vrok $strana.strana";

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/prizdph".$kli_vume."_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/prizdph".$kli_vume."_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $copern != 10 AND $copern != 20 AND $copern != 40 )
{
$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}

if( $copern == 20 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}

//1.strana dph
if( $copern == 10 )
   {
$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//echo $mesp_dph;
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//icdph
$pdf->Cell(190,38.5," ","$rmc1",1,"L");
$text=$fir_ficd;
$A=substr($text,2,1);
$B=substr($text,3,1);
$C=substr($text,4,1);
$D=substr($text,5,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$I=substr($text,10,1);
$J=substr($text,11,1);
$pdf->Cell(14,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//dic
$pdf->Cell(190,6.5," ","$rmc1",1,"L");
$text=$fir_fdicp;
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
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//danovy_urad
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$fir_uctt01;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(62,6.5,"$text","$rmc",1,"L");

//nevznikla_dan
$sqltt1 = "SELECT * FROM F$kli_vxcf"."_prcprizdphsx".$kli_uzid." WHERE fic > 0 "."";
$nicnebolo="x";
$sqldok = mysql_query("$sqltt1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $riadok19=$riaddok->r19;   $riadok20=$riaddok->r20;  $riadok21=$riaddok->r21;  $riadok31=$riaddok->r31;  $riadok32=$riaddok->r32;
  $riadok15=$riaddok->r15;   $riadok16=$riaddok->r16;  $riadok17=$riaddok->r17;
  if( $riadok19 != 0 OR $riadok20 != 0 OR $riadok21 != 0 OR $riadok31 != 0 OR $riadok32 != 0 OR $riadok15 != 0 OR $riadok16 != 0  OR $riadok17 != 0 ) $nicnebolo=" ";
  }
$pdf->Cell(190,7.5," ","$rmc1",1,"L");
$pdf->Cell(57,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$nicnebolo","$rmc",1,"C");

//druh_priznania
$riadne="x";
$opravne="x";
$dodatocne="x";
if ( $h_drp == 1 ) { $opravne=""; $dodatocne=""; $dat_dodatocne=""; }
if ( $h_drp == 2 ) { $riadne=""; $dodatocne=""; $dat_dodatocne=""; }
if ( $h_drp == 3 ) { $riadne=""; $opravne=""; $dat_dodatocne=$h_dap; }
$pdf->SetY(47.5);
$pdf->Cell(69,3," ","$rmc1",0,"R");$pdf->Cell(3.5,3,"$riadne","$rmc",1,"C");
$pdf->Cell(190,2.5," ","$rmc1",1,"L");
$pdf->Cell(69,3," ","$rmc1",0,"R");$pdf->Cell(3.5,3,"$opravne","$rmc",1,"C");
$pdf->Cell(190,2.5," ","$rmc1",1,"L");
$pdf->Cell(69,3," ","$rmc1",0,"R");$pdf->Cell(3.5,3,"$dodatocne","$rmc",1,"C");

//dodatocne_datum
$text="";
if ( $h_drp == 3 AND $zarchivu == 1 ) { $text=SkDatum($dadod); }
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->SetY(56.5);
$pdf->Cell(94,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da5","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da6","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//obdobie
$A1=substr($kli_mdph,0,1);
$B1=substr($kli_mdph,1,1);
$obddphx=$obddph; if ( $obddphx == 5 ) { $obddphx=""; }
$A2=substr($kli_rdph,0,1);
$B2=substr($kli_rdph,1,1);
$C2=substr($kli_rdph,2,1);
$D2=substr($kli_rdph,3,1);
$pdf->SetY(52);
$pdf->Cell(141,5," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(4,6,"$obddphx","$rmc",0,"C");
$pdf->Cell(7,5," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A2","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B2","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C2","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D2","$rmc",1,"L");

//platitel
$sqlfird = "SELECT * FROM F$kli_vxcf"."_archivdphdalsie WHERE  cpid = $cislo_cpid ";
$fir_vysledokd = mysql_query($sqlfird);
$fir_riadokd=mysql_fetch_object($fir_vysledokd);
$xplc=1*$fir_riadokd->xplc;
mysql_free_result($fir_vysledokd);

$plat1="x"; $plat2=" "; $plat3=" "; $plat4=" "; $plat5=" "; $plat6=" ";
if ( $xplc == 2 ) { $plat1=" "; $plat2="x"; $plat3=" "; $plat4=" "; $plat5=" "; $plat6=" "; }
if ( $xplc == 3 ) { $plat1=" "; $plat2=" "; $plat3="x"; $plat4=" "; $plat5=" "; $plat6=" "; }
if ( $xplc == 4 ) { $plat1=" "; $plat2=" "; $plat3=" "; $plat4="x"; $plat5=" "; $plat6=" "; }
if ( $xplc == 5 ) { $plat1=" "; $plat2=" "; $plat3=" "; $plat4=" "; $plat5="x"; $plat6=" "; }
if ( $xplc == 6 ) { $plat1=" "; $plat2=" "; $plat3=" "; $plat4=" "; $plat5=" "; $plat6="x"; }
$pdf->SetY(65);
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat1","$rmc",1,"C");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat2","$rmc",1,"C");
$pdf->Cell(190,2.5," ","$rmc1",1,"L");
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat3","$rmc",1,"C");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat4","$rmc",1,"C");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat5","$rmc",1,"C");
$pdf->Cell(190,2.5," ","$rmc1",1,"L");
$pdf->Cell(69,2," ","$rmc1",0,"L");$pdf->Cell(3.5,3,"$plat6","$rmc",1,"C");

//nazov
$pdf->Cell(190,9," ","$rmc1",1,"L");
$text=$fir_fnaz;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
//nazov_2.riadok
$pdf->Cell(190,2," ","$rmc1",1,"L");
$M1=substr($text,37,1);
$N1=substr($text,38,1);
$O1=substr($text,39,1);
$P1=substr($text,40,1);
$R1=substr($text,41,1);
$S1=substr($text,42,1);
$T1=substr($text,43,1);
$U1=substr($text,44,1);
$V1=substr($text,45,1);
$W1=substr($text,46,1);
$X1=substr($text,47,1);
$Y1=substr($text,48,1);
$Z1=substr($text,49,1);
$A2=substr($text,50,1);
$B2=substr($text,51,1);
$C2=substr($text,52,1);
$D2=substr($text,53,1);
$E2=substr($text,54,1);
$F2=substr($text,55,1);
$G2=substr($text,56,1);
$H2=substr($text,57,1);
$I2=substr($text,58,1);
$J2=substr($text,59,1);
$K2=substr($text,60,1);
$L2=substr($text,61,1);
$M2=substr($text,62,1);
$N2=substr($text,63,1);
$O2=substr($text,64,1);
$P2=substr($text,65,1);
$R2=substr($text,66,1);
$S2=substr($text,67,1);
$T2=substr($text,68,1);
$U2=substr($text,69,1);
$V2=substr($text,70,1);
$W2=substr($text,71,1);
$X2=substr($text,72,1);
$Y2=substr($text,73,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$M1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$W1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$M2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$U2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X2","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y2","$rmc",1,"C");
//nazov_3.riadok

//adresa_ulica
$pdf->Cell(190,20," ","$rmc1",1,"L");
$text=$fir_fuli;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
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
//adresa_cislo
$text=$fir_fcdm;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//adresa_psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fpsc;
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//adresa_obec
$text=$fir_fmes;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$E1=substr($text,30,1);
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");
//telefon
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_ftel;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//email
$text=$fir_fem1;
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(116,5,"$text","$rmc",1,"L");

//opravneny
$pdf->Cell(190,8," ","$rmc1",1,"L");
$text=$fir_uctt05;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$N=substr($text,13,1);
$O=substr($text,14,1);
$P=substr($text,15,1);
$R=substr($text,16,1);
$S=substr($text,17,1);
$T=substr($text,18,1);
$U=substr($text,19,1);
$V=substr($text,20,1);
$W=substr($text,21,1);
$X=substr($text,22,1);
$Y=substr($text,23,1);
$Z=substr($text,24,1);
$A1=substr($text,25,1);
$B1=substr($text,26,1);
$C1=substr($text,27,1);
$D1=substr($text,28,1);
$E1=substr($text,29,1);
$F1=substr($text,30,1);
$G1=substr($text,31,1);
$H1=substr($text,32,1);
$I1=substr($text,33,1);
$J1=substr($text,34,1);
$K1=substr($text,35,1);
$L1=substr($text,36,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
//opravneny_telefon
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_uctt04;
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
$K=substr($text,10,1);
$L=substr($text,11,1);
$M=substr($text,12,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//opravneny_email
$text="";
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(116,5,"$text","$rmc",1,"L");

//datum
$pdf->Cell(190,26," ","$rmc1",1,"L");
$text=$h_dap;
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(2,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da5","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da6","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");
   } //$copern==10

if ( $copern == 40 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
//hlavicka
if ( $j == 0 )
{
//2.strana dph
if ( $copern == 10 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//icdph
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text=$fir_ficd;
$A=substr($text,2,1);
$B=substr($text,3,1);
$C=substr($text,4,1);
$D=substr($text,5,1);
$E=substr($text,6,1);
$F=substr($text,7,1);
$G=substr($text,8,1);
$H=substr($text,9,1);
$I=substr($text,10,1);
$J=substr($text,11,1);
$pdf->Cell(36,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");

//dic
$text=$fir_fdicp;
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
$pdf->Cell(5.5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");
$pdf->Cell(190,6," ","$rmc1",1,"L");
     } //$copern==10

if ( $copern == 20 )
   {
if( $j == 0 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(15);
$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(95,5,"DaÚ z pridanej hodnoty - Zoznam dokladov za $kli_vume","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

if( $rozdiel == 1 ) { $pdf->Cell(0,5,"Doklady, ktorÈ s˙ navyöe v zozname archivovanom oproti aktu·lnemu.","0",1,"L"); }
if( $rozdiel == 2 ) { $pdf->Cell(0,5,"Doklady, ktorÈ ch˝baj˙ v zozname archivovanom oproti aktu·lnemu.","0",1,"L"); }

$pdf->Cell(15,4,"⁄Ë.mes.","1",0,"R");$pdf->Cell(20,4,"Zdan.pln.","1",0,"R");$pdf->Cell(25,4,"Doklad","1",0,"L");
$pdf->Cell(25,4,"riadok - DRD","1",0,"L");$pdf->Cell(20,4,"Suma","1",0,"R");$pdf->Cell(25,4,"Fakt˙ra","1",0,"R");
$pdf->Cell(0,4,"I»O I»DPH N·zov","1",1,"L");
}
   }

if( ( $copern == 30 OR $copern == 40 ) AND $drupoh == 1 AND $i == 0 )
          {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="20%">
RDK<a href="#" onClick="window.open('../ucto/prizdph2014.php?&copern=30&drupoh=1&page=1&typ=HTML&fir_uctx01=<?php echo $fir_uctx01; ?>', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te HTML" ></a>
<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=20&drupoh=1&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po riadkoch DPH vo form·te PDF" ></a>

<td class="bmenu" width="20%">
DOK<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=1&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te HTML" ></a>
<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=2&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po dokladoch DPH vo form·te PDF" ></a>

<td class="bmenu" width="20%">
DRD<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=1&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>&zdrd=10', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te HTML" ></a>
<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=2&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>&zdrd=11', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt="VytlaËiù Zoznam dokladov po druhoch DPH vo form·te PDF" ></a>

<td class="bmenu" width="20%">
CHB<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=1&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>&chyby=1', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt="VytlaËiù ChybovÈ hl·senia DPH vo form·te HTML" ></a>
<a href="#" onClick="window.open('../ucto/prizdph2014.php?copern=40&drupoh=2&page=1&fir_uctx01=<?php echo $fir_uctx01; ?>&chyby=1', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt="VytlaËiù ChybovÈ hl·senia DPH tlaË vo form·te PDF" ></a>
</td>

<td class="bmenu" width="20%">

</tr>
</table>
<?php
          }


if( $copern == 30 )
   {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="5"><?php echo "DaÚ z pridanej hodnoty - Zoznam dokladov $kli_vume "; ?>
<td class="bmenu" colspan="2" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="6%">⁄Ë.mes.</td>
<td class="bmenu" width="14%">Vyst. / Zdan.pln.</td>
<td class="bmenu" width="10%">Doklad</td>
<td class="bmenu" width="5%">riadok - DRD</td>
<td class="hvstup_zlte" width="15%" align="right">Suma</td>
<td class="bmenu" width="10%" align="right">Fakt˙ra</td>
<td class="bmenu" width="40%">I»O</td>
</tr>
<?php
   }

if( $copern == 40 AND $drupoh == 1) //html;
   {
?>
<table class="vstup" width="100%" >
<tr>
<?php if( $chyby == 0 ) { ?>
<td class="bmenu" colspan="5"><?php echo "DaÚ z pridanej hodnoty - Zoznam dokladov $kli_vume "; ?></td>
<?php                  } ?>
<?php if( $chyby == 1 ) { ?>
<td class="bmenu" colspan="5"><?php echo "DaÚ z pridanej hodnoty - ChybovÈ hl·senia $kli_vume "; ?></td>
<?php                  } ?>


<td class="bmenu" colspan="5" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="6%">⁄Ë.mes.</td>
<td class="bmenu" width="14%">Vyst. / Zdan.pln.</td>
<td class="bmenu" width="8%">Doklad</td>
<td class="bmenu" width="7%" align="right">Z·klad 0</td>
<td class="bmenu" width="8%" align="right">Z·klad 10</td>
<td class="bmenu" width="7%" align="right">DaÚ 10</td>
<td class="bmenu" width="8%" align="right">Z·klad <?php echo $fir_dph2; ?></td>
<td class="bmenu" width="7%" align="right">DaÚ <?php echo $fir_dph2; ?></td>
<td class="bmenu" width="8%" align="right">Fakt˙ra</td>
<td class="bmenu" width="31%">I»O</td>
</tr>
<?php
   }

if( $copern == 40 AND $drupoh == 2) //pdf chybove;
   {

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(15);
$pdf->SetY(10);
$pdf->SetFont('arial','',10);

if( $chyby == 0 ) { $pdf->Cell(130,5,"DaÚ z pridanej hodnoty - Zoznam dokladov $kli_vume","LTB",0,"L"); }
if( $chyby == 1 ) { $pdf->Cell(130,5,"DaÚ z pridanej hodnoty - ChybovÈ hl·senia $kli_vume","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(15,4,"⁄Ë.mes.","1",0,"R");$pdf->Cell(27,4,"Zdan.pln.","1",0,"L");$pdf->Cell(23,4,"Doklad","1",0,"R");
$pdf->Cell(19,4,"Z·klad 0","1",0,"R");
$pdf->Cell(20,4,"Z·klad 10","1",0,"R");$pdf->Cell(19,4,"DaÚ 10","1",0,"R");
$pdf->Cell(20,4,"Z·klad $fir_dph2","1",0,"R");$pdf->Cell(19,4,"DaÚ $fir_dph2","1",0,"R");
$pdf->Cell(25,4,"Fakt˙ra","1",0,"R");$pdf->Cell(0,4,"I»O I»DPH","1",1,"L");
   }

}
//koniec hlavicka j=0

  if ( @$zaznam=mysql_data_seek($sql,$i) )
{
$hlavicka=mysql_fetch_object($sql);

$faknul=$hlavicka->fak;
if ( $hlavicka->fak == 0 ) $faknul="";

//8-miestny slovensky datum
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->daz, 3);
  $rok=$rok-2000;
  $dazsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

if ( $copern == 10 )
     {
if ( $i != 10 AND $i != 20 AND $i != 38 AND $i != 48 )
$h_r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $h_r01="";
$h_r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $h_r02="";
$h_r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $h_r03="";
$h_r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $h_r04="";
$h_r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $h_r05="";
$h_r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $h_r06="";
$h_r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $h_r07="";
$h_r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $h_r08="";
$h_r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $h_r09="";
$h_r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $h_r10="";
$h_r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $h_r11="";
$h_r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $h_r12="";
$h_r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $h_r13="";
$h_r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $h_r14="";
$h_r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $h_r15="";
$h_r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $h_r16="";
$h_r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $h_r17="";
$h_r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $h_r18="";
$h_r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $h_r19="";
$h_r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $h_r20="";
$h_r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $h_r21="";
$h_r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $h_r22="";
$h_r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $h_r23="";
$h_r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $h_r24="";
$h_r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $h_r25="";
$h_r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $h_r26="";
$h_r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $h_r27="";
$h_r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $h_r28="";
$h_r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $h_r29="";
$h_r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $h_r30="";
$h_r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $h_r31="";
$h_r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $h_r32="";
$h_r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $h_r33="";
$h_r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $h_r34="";
$h_r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $h_r35="";
$h_r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $h_r36="";
$h_r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $h_r37="";
$h_r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $h_r38="";
if ( $hlavicka->r38 == 0 AND $h_drp == 3 ) $h_r38="0.00";
if ( $hlavicka->r37 == 0 AND $h_drp == 3 ) $h_r37="0.00";

$pdf->SetFont('arial','',12);
//r01
$pdf->Cell(190,1," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r01);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r02
$h_rxx=sprintf("% 12s",$h_r02);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r03
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r03);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r04
$h_rxx=sprintf("% 12s",$h_r04);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r05
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r05);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r06
$h_rxx=sprintf("% 12s",$h_r06);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r07
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r07);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r08
$h_rxx=sprintf("% 12s",$h_r08);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r09
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r09);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r10
$h_rxx=sprintf("% 12s",$h_r10);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r11
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r11);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r12
$h_rxx=sprintf("% 12s",$h_r12);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r13
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r13);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r14
$h_rxx=sprintf("% 12s",$h_r14);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r15
$pdf->Cell(190,2," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r15);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",1,"C");
//r16
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r16);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",1,"C");
//r17
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r17);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(61.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",1,"C");
//r18
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r18);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r19
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r19);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r20
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r20);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r21
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r21);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r22
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r22);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r23
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r23);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r24
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r24);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r25
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r25);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r26
$pdf->Cell(190,3.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 13s",$h_r26);
$znamienko=" ";
if ( $hlavicka->r26 < 0 ) { $znamienko="-"; $h_rxx=str_replace("-"," ",$h_rxx); }
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(57,6,"","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(1.5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
//r27
$h_rxx=sprintf("% 12s",$h_r27);
$znamienko=" ";
if ( $hlavicka->r27 < 0 ) { $znamienko="-"; $h_rxx=str_replace("-"," ",$h_rxx); }
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(2.5,6,"","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r28
$pdf->Cell(190,3.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r28);
$znamienko=" ";
if ( $hlavicka->r28 < 0 ) { $znamienko="-"; $h_rxx=str_replace("-"," ",$h_rxx); }
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(126.5,6,"","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r29
$pdf->Cell(190,3," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r29);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r30
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r30);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r31
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r31);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//splnenie_par79ods2
$pdf->Cell(190,3," ","$rmc1",1,"R");
$par79ods2=$hlavicka->dok;
if ( $par79ods2 == 1  ) { $par79ods2t="x"; }
if ( $par79ods2 == 0  ) { $par79ods2t=" "; }
if ( $mesp_dph < 4 AND $rokp_dph < 2010 ) { $par79ods2t=" "; }
$pdf->Cell(47.5,6,"","$rmc1",0,"R");$pdf->Cell(3,3,"$par79ods2t","$rmc",0,"C");
//r32
$h_rxx=sprintf("% 12s",$h_r32);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(81,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r33
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r33);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r34
$pdf->Cell(190,2.5," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r34);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(131.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r35
$pdf->Cell(190,7," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r35);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(66.5,6,"","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//r36
$h_rxx=sprintf("% 12s",$h_r36);
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(7.5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");
//r37
$pdf->Cell(190,9," ","$rmc1",1,"R");
$h_rxx=sprintf("% 12s",$h_r37);
$znamienko=" ";
if ( $hlavicka->r37 < 0 ) { $znamienko="-"; $h_rxx=str_replace("-"," ",$h_rxx); }
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$M=substr($h_rxx,12,1);
$pdf->Cell(57,6,"","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(1.5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
//r38
$h_rxx=sprintf("% 12s",$h_r38);
$h_r38="135465";
$znamienko=" ";
if ( $hlavicka->r38 < 0 ) { $znamienko="-"; $h_rxx=str_replace("-"," ",$h_rxx); }
$A=substr($h_rxx,0,1);
$B=substr($h_rxx,1,1);
$C=substr($h_rxx,2,1);
$D=substr($h_rxx,3,1);
$E=substr($h_rxx,4,1);
$F=substr($h_rxx,5,1);
$G=substr($h_rxx,6,1);
$H=substr($h_rxx,7,1);
$I=substr($h_rxx,8,1);
$J=substr($h_rxx,9,1);
$K=substr($h_rxx,10,1);
$L=substr($h_rxx,11,1);
$pdf->Cell(8,6,"","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(1.5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4.5,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");


//zaarchivuj F$kli_vxcf"."_prcprizdphsx".$kli_uzid
if( $h_arch == 1 AND $zarchivu == 0 )
{
$umearch=$kli_mdph.".".$kli_rdph;

if( $h_drp == 1 )
  {
if( $fir_uctx01 < 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE ume = $umearch AND druh = $h_drp "; }
if( $fir_uctx01 == 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE stvrtrok = $obddph AND druh = $h_drp "; }
if( $fir_uctx01 == 4 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE stvrtrok = $obddph AND druh = $h_drp "; }
$dsql = mysql_query("$dsqlt");
  }

$h_dad=SqlDatum($h_dap);

$dsqlt = "INSERT INTO F$kli_vxcf"."_archivdph "." SELECT".
" '$umearch','$obddph','$h_drp',0,now(),0,0,'$h_dap',".
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"SUM(r20),SUM(r21),'',0,0,0,0,0,0,0,0,".
"fic,'$h_dad'".
" FROM F$kli_vxcf"."_prcprizdphsx$kli_uzid".
" WHERE fic > 0".
" GROUP BY fic".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$cpid=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_archivdph WHERE cpid >= 0 ORDER BY cpid DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cpid=1*$riaddok->cpid;
    }

//ak mesacna dph zaarchivuj aj zoznam
if( $fir_uctx01 == 1 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er4='$cpid', er3=$h_drp ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_archivdphzoznam "." SELECT *  FROM F$kli_vxcf"."_prcprizdphs$kli_uzid  WHERE fic < 0 ";
$dsql = mysql_query("$dsqlt");
if( $h_drp == 1 )
  {
$dsqlt = "DELETE FROM F$kli_vxcf"."_archivdphzoznam "." WHERE ume = $kli_vume AND er3 = 1 AND er4 != $cpid ";
$dsql = mysql_query("$dsqlt");
  }
$dsqlt = "INSERT INTO F$kli_vxcf"."_archivdphzoznam "." SELECT *  FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE psys != 999 ";
$dsql = mysql_query("$dsqlt");

//toto som pridal kvoli dat a daz iny mesiac aby nemazal inak dalsi riadny za 5.2014 zmazal aj ume 5.2014(napr dat 1.5.2014) doklady z 04.2014 dphzoznamu
$dsqlt = "UPDATE F$kli_vxcf"."_archivdphzoznam SET ume='$kli_vume' WHERE er4 = $cpid ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er3=0, er4=0 ";
$dsql = mysql_query("$dsqlt");
  }

//ak stvrtrocna dph zaarchivuj aj zoznam
if( $fir_uctx01 == 2 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er4='$cpid', er3=$h_drp ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_archivdphzoznam "." SELECT *  FROM F$kli_vxcf"."_prcprizdphs$kli_uzid  WHERE fic < 0 ";
$dsql = mysql_query("$dsqlt");
if( $h_drp == 1 )
  {
$dsqlt = "DELETE FROM F$kli_vxcf"."_archivdphzoznam "." WHERE er1 = $obddph AND er3 = 1 AND er4 != $cpid ";
$dsql = mysql_query("$dsqlt");
  }
$dsqlt = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1='$obddph' ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_archivdphzoznam "." SELECT *  FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE psys != 999 ";
$dsql = mysql_query("$dsqlt");

//toto som pridal kvoli dat a daz iny mesiac aby nemazal inak dalsi riadny za 5.2014 zmazal aj ume 5.2014(napr dat 1.5.2014) doklady z 04.2014 dphzoznamu
$dsqlt = "UPDATE F$kli_vxcf"."_archivdphzoznam SET er1='$obddph' WHERE er4 = $cpid ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0, er4=0, er3=0 ";
$dsql = mysql_query("$dsqlt");
  }

}
//koniec archivacie

     } //$copern==10


//echo $copern;
$icdtlac=$hlavicka->icd;
if( $copern == 20 OR $copern == 30 OR $copern == 40 )
      {
$odbmx=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $hlavicka->dok AND odbm > 0 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odbm=1*$riaddok->odbm;
  $odbmx=1*$riaddok->odbm;
  }
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok = $hlavicka->dok AND odbm > 0 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odbm=1*$riaddok->odbm;
  $odbmx=1*$riaddok->odbm;
  }
if( $odbmx > 0 )
    {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $hlavicka->ico AND odbm = $odbmx ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icdtlac=$riaddok->icd2;
  }
    }

      }
//koniec icd podla odbm

if( $copern == 30 )
   {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
?>
<tr>
<?php
if(  $hlavicka->psys != 0 AND $hlavicka->psys != 998 )
{
?>
<td class="<?php echo $hvstup; ?>" width="6%"><?php echo $hlavicka->ume; ?></td>
<td class="<?php echo $hvstup; ?>" width="14%"><?php echo $datsk; ?> / <?php echo $dazsk; ?></td>
<td class="<?php echo $hvstup; ?>" width="10%">
<?php if( $hlavicka->psys == 11 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 12 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 13 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 14 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 15 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<?php
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 16 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<?php
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 17 )
  { ?>
SKL
<?php
  } ?>

<?php echo $hlavicka->dok; ?></td>
<td class="<?php echo $hvstup; ?>" width="10%"><?php echo $hlavicka->rdk; ?> - <?php echo $hlavicka->rdp; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->hod; ?></td>
<td class="<?php echo $hvstup; ?>" width="10%" align="right"><?php echo $faknul; ?></td>
<td class="<?php echo $hvstup; ?>" width="40%"><?php echo $hlavicka->ico; ?> <?php echo $icdtlac; ?> <?php echo $hlavicka->nai; ?></td>
<?php
}
?>
<?php
if(  $hlavicka->psys == 0 )
{
?>
<td class="hvstup_tzlte" width="10%" colspan="4" align="right">Celkom riadok <?php echo $hlavicka->rdk; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->hod; ?></td>
<td class="hvstup_tzlte" width="10%"  colspan="2"></td>
<?php
}
?>
<?php
if(  $hlavicka->psys == 998 )
{
?>
<td class="hvstup_zlte" width="10%" colspan="4" align="left">Celkom druh <?php echo $hlavicka->rdp; ?> v riadku <?php echo $hlavicka->rdk; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->hod; ?></td>
<td class="hvstup_zlte" width="10%"  colspan="2"></td>
<?php
}
?>
</tr>

<?php
  if( $hlavicka->psys == 16 AND $fir_uctx07 == 1 AND ( $hlavicka->rdk == 24 OR $hlavicka->rdk == 25 ) )
          {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid WHERE ico=$hlavicka->ico AND fak=$hlavicka->fak ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $doku=$riaddok->dok;
  $datu=SkDatum($riaddok->duh);
  $hodu=$riaddok->hou;
  }
?>
<tr>
<td class="<?php echo $hvstup; ?>" colspan="10"><?php echo "UhradenÈ ".$datu." doklad ".$doku." suma ".$hodu."Ä"; ?></td>
</tr>
<?php
          }
?>

<?php
   }
//koniec copern=30

if( $copern == 20 )
   {
if(  $hlavicka->psys == 0 )
{
$pdf->Cell(85,4,"Celkom riadok $hlavicka->rdk","1",0,"R");$pdf->Cell(20,4,"$hlavicka->hod","1",0,"R");$pdf->Cell(0,4," ","1",1,"L");
}
if(  $hlavicka->psys == 998 )
{
$pdf->Cell(85,4,"Celkom za druh $hlavicka->rdp v riadku $hlavicka->rdk","T",0,"L");$pdf->Cell(20,4,"$hlavicka->hod","T",0,"R");$pdf->Cell(0,4," ","$rmc",1,"L");
}
if(  $hlavicka->psys != 0 AND $hlavicka->psys != 998 )
{

$pdf->Cell(15,4,"$hlavicka->ume","$rmc",0,"R");$pdf->Cell(20,4,"$dazsk","$rmc",0,"R");$pdf->Cell(25,4,"$hlavicka->dok","$rmc",0,"L");
$pdf->Cell(25,4,"$hlavicka->rdk - $hlavicka->rdp","$rmc",0,"L");$pdf->Cell(20,4,"$hlavicka->hod","$rmc",0,"R");$pdf->Cell(25,4,"$faknul","$rmc",0,"R");
$pdf->Cell(0,4,"$hlavicka->ico $icdtlac $hlavicka->nai","$rmc",1,"L");

  if( $hlavicka->psys == 16 AND $fir_uctx07 == 1 AND ( $hlavicka->rdk == 24 OR $hlavicka->rdk == 25 ) )
          {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcprizdphuh$kli_uzid WHERE ico=$hlavicka->ico AND fak=$hlavicka->fak ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $doku=$riaddok->dok;
  $datu=SkDatum($riaddok->duh);
  $hodu=$riaddok->hou;
  }
$pdf->Cell(0,4,"UhradenÈ $datu doklad $doku suma $hodu Ä","$rmc",1,"L");
$j = $j + 1;
          }
}
   }
//koniec copern=20

if( $copern == 40 AND $drupoh == 1 )
   {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
if( $hlavicka->er1 > 0 OR $hlavicka->er2 > 0 OR $hlavicka->er3 > 0 OR $hlavicka->er4 > 0 ) { $hvstup="hvstup_bred"; }
?>
<tr>
<?php
if(  $hlavicka->psys != 0 AND $hlavicka->psys != 9999 )
{
?>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ume; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?> / <?php echo $dazsk; ?> - <?php echo $hlavicka->rdp; ?></td>
<td class="<?php echo $hvstup; ?>" >
<?php if( $hlavicka->psys == 11 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 12 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 13 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 14 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 15 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<?php
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php
  } ?>
<?php if( $hlavicka->psys == 16 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<?php
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php
  } ?>

<?php echo $hlavicka->dok; ?></td>

<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->zk0; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->zk1; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->dn1; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->zk2; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->dn2; ?></td>

<td class="<?php echo $hvstup; ?>" align="right"><?php echo $faknul; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ico; ?> <?php echo $hlavicka->nai; ?></td>
<?php
}
?>

<?php
if( $hlavicka->psys == 9999 )
{
?>
<td class="hvstup_tzlte" colspan="3" >CELKOM za druh DPH <?php echo $hlavicka->rdp; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->zk0; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->zk1; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->dn1; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->zk2; ?></td>
<td class="hvstup_tzlte" width="10%" align="right"><?php echo $hlavicka->dn2; ?></td>

<td class="hvstup_tzlte" align="right"> </td>
<td class="hvstup_tzlte" > </td>
<?php
}
?>
</tr>
<?php
   }
//koniec copern=40 html

if( $copern == 40 AND $drupoh == 2) //pdf ;
   {
$h_zk0=$hlavicka->zk0;
if( $hlavicka->zk0 == 0 ) $h_zk0="";
$h_zk1=$hlavicka->zk1;
if( $hlavicka->zk1 == 0 ) $h_zk1="";
$h_dn1=$hlavicka->dn1;
if( $hlavicka->dn1 == 0 ) $h_dn1="";
$h_zk2=$hlavicka->zk2;
if( $hlavicka->zk2 == 0 ) $h_zk2="";
$h_dn2=$hlavicka->dn2;
if( $hlavicka->dn2 == 0 ) $h_dn2="";
$h_fak=$hlavicka->fak;
if( $hlavicka->fak == 0 ) $h_fak="";

if( $hlavicka->psys != 9999 )
 {
$pdf->Cell(15,4,"$hlavicka->ume","$rmc",0,"R");$pdf->Cell(27,4,"$dazsk - $hlavicka->rdp","$rmc",0,"L");$pdf->Cell(23,4,"$hlavicka->dok","$rmc",0,"R");
$pdf->Cell(19,4,"$h_zk0","$rmc",0,"R");
$pdf->Cell(20,4,"$h_zk1","$rmc",0,"R");$pdf->Cell(19,4,"$h_dn1","$rmc",0,"R");
$pdf->Cell(20,4,"$h_zk2","$rmc",0,"R");$pdf->Cell(19,4,"$h_dn2","$rmc",0,"R");
$pdf->Cell(25,4,"$h_fak","$rmc",0,"R");
$pdf->SetFont('arial','',9);
$pdf->Cell(0,4,"$hlavicka->ico $icdtlac $hlavicka->nai","$rmc",1,"L");
$pdf->SetFont('arial','',10);
 }

if( $hlavicka->psys == 9999 )
 {
$pdf->Cell(65,4,"CELKOM za druh DPH $hlavicka->rdp","1",0,"R");
$pdf->Cell(19,4,"$h_zk0","1",0,"R");
$pdf->Cell(20,4,"$h_zk1","1",0,"R");$pdf->Cell(19,4,"$h_dn1","1",0,"R");
$pdf->Cell(20,4,"$h_zk2","1",0,"R");$pdf->Cell(19,4,"$h_dn2","1",0,"R");
$pdf->Cell(25,4," ","1",0,"R");$pdf->Cell(0,4," ","$rmc",1,"L");
 }
   }

}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

if( $copern == 20 )
   {
//zoznam po riadkoch strankuj
if( $j > 40 ) { $j=0; $strana=$strana+1; }
   }

if( $copern == 40 )
   {
//zoznam po dokladoch,druhoch strankuj
if( $j > 40 ) { $j=0; $strana=$strana+1; }
   }

  }
//koniec hlavicky


if( $copern == 10 OR $copern == 20 OR ( $copern == 40 AND $drupoh == 2 ) )
{

$pdf->Output("$outfilex");


//arch nul
if( $copern == 10 )
   {

//zaarchivuj ak je nulove priznanie DPH
if( $h_arch == 1 AND $zarchivu == 0 AND $nicnebolo == 'x' )
{
$umearch=$kli_mdph.".".$kli_rdph;

if( $fir_uctx01 < 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE ume = $umearch AND druh = $h_drp "; }
if( $fir_uctx01 == 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE stvrtrok = $obddph AND druh = $h_drp "; }
if( $fir_uctx01 == 4 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE stvrtrok = $obddph AND druh = $h_drp "; }
$dsql = mysql_query("$dsqlt");

$h_dad=SqlDatum($h_dap);

//echo "xxx".$nicnebolo;

$dsqlt = "INSERT INTO F$kli_vxcf"."_archivdph ".
"(ume,stvrtrok,druh,daid,par79ods2,dap,".
"r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,".
"r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,".
"r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,".
"r31,r32,r33,r34,r35,r36,r37 )".
" VALUES ( '$umearch','$obddph','$h_drp', now(), 0,'$h_dap',".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0 )";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
}

   }
//koniec arch nul


//odozva do androidu
if( $pdfand == 0 )
{

$platitdph=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcprizdphsx".$kli_uzid." WHERE psys > 0 ORDER BY rdp,dok");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $platitdph=$riaddok->r31-$riaddok->r32;
    $r02=$riaddok->r02;
    $r04=$riaddok->r04;
    $r06=$riaddok->r06;
    $r08=$riaddok->r08;
    $r10=$riaddok->r10;
    $r12=$riaddok->r12;
    $r14=$riaddok->r14;

    $r18=$riaddok->r18;
    $r19=$riaddok->r19;
    $r20=$riaddok->r20;
    $r21=$riaddok->r21;
    $r22=$riaddok->r22;
    $r23=$riaddok->r23;
    $r24=$riaddok->r24;
    $r25=$riaddok->r25;

    $r27=$riaddok->r27;
    $r28=$riaddok->r28;
    $r29=$riaddok->r29;
    $r30=$riaddok->r30;
    $r31=$riaddok->r31;
    $r32=$riaddok->r32;
    $r33=$riaddok->r33;
    $r34=$riaddok->r34;

    }

	$response = array();
	$response["products"] = array();
	$i=1;
	while( $i < 24 )
        {
        $product = array();
	$price=0; $pid="";

        if( $i ==  1 ) { $name="DaÚ$fir_dph1 % Dodanie tovaru a sluûby podæa ß8 a 9 z·kona"; $price=$r02; $pid = "r02";}
        if( $i ==  2 ) { $name="DaÚ$fir_dph2 % Dodanie tovaru a sluûby podæa ß8 a 9 z·kona"; $price=$r04; $pid = "r04";}
        if( $i ==  3 ) { $name="DaÚ$fir_dph1 % Nadobudnutie tovaru v tuzemsku podæa ß11 a 11a z·kona"; $price=$r06; $pid = "r06";}
        if( $i ==  4 ) { $name="DaÚ$fir_dph2 % Nadobudnutie tovaru v tuzemsku podæa ß11 a 11a z·kona"; $price=$r08; $pid = "r08";}
        if( $i ==  5 ) { $name="Tovary a sluûby, pri ktor˝ch prÌjemca platÌ daÚ podæa ß69 ods.3 z·kona"; $price=$r10; $pid = "r10";}
        if( $i ==  6 ) { $name="Sluûby, pri ktor˝ch prÌjemca platÌ daÚ podæa ß9 ods.2 a 9 aû 12 z·kona"; $price=$r12; $pid = "r12";}
        if( $i ==  7 ) { $name="Tovary, pri ktor˝ch druh˝ odberateæ platÌ daÚ podæa ß69 ods.7 z·kona"; $price=$r14; $pid = "r14";}

        if( $i ==  8 ) { $name="DaÚov· povinnosù pri zruöenÌ registr·cie podæa ß61 z·kona"; $price=$r18; $pid = "r18";}
        if( $i ==  9 ) { $name="DA“ CELKOM"; $price=$r19; $pid = "r19";}
        if( $i == 10 ) { $name="DaÚ$fir_dph1 % OdpoËÌtanie dane celkom podæa ß49 aû 54a z·kona"; $price=$r20; $pid = "r20";}
        if( $i == 11 ) { $name="DaÚ$fir_dph2 % OdpoËÌtanie dane celkom podæa ß49 aû 54a z·kona"; $price=$r21; $pid = "r21";}
        if( $i == 12 ) { $name="DaÚ$fir_dph1 % podæa ß51 ods.1 pÌsm. a) z·kona"; $price=$r22; $pid = "r22";}
        if( $i == 13 ) { $name="DaÚ$fir_dph2 % podæa ß51 ods.1 pÌsm. a) z·kona"; $price=$r23; $pid = "r23";}
        if( $i == 14 ) { $name="DaÚ$fir_dph1 % podæa ß51 ods.1 pÌsm. d) z·kona"; $price=$r24; $pid = "r24";}
        if( $i == 15 ) { $name="DaÚ$fir_dph2 % podæa ß51 ods.1 pÌsm. d) z·kona"; $price=$r25; $pid = "r25";}

        if( $i == 16 ) { $name="Rozdiel v z·klade dane a v dani po oprave podæa ß25 ods.1 aû 3 z·kona"; $price=$r27; $pid = "r27";}
        if( $i == 17 ) { $name="Oprava odpoËÌtane dane podæa ß53 z·kona"; $price=$r28; $pid = "r28";}
        if( $i == 18 ) { $name="OdpoËÌtanie dane pri registr·cii platiteæa dane podæa ß55 z·kona"; $price=$r29; $pid = "r29";}


        if( $i == 19 ) { $name="Vr·tenie dane cestuj˙cim pri v˝voze tovaru podæa ß60 z·kona"; $price=$r30; $pid = "r30";}
        if( $i == 20 ) { $name="VLASTN¡ DA“OV¡ POVINNOSç"; $price=$r31; $pid = "r31";}
        if( $i == 21 ) { $name="NADMERN› ODPO»ET"; $price=$r32; $pid = "r32";}
        if( $i == 22 ) { $name="Nadnern˝ odpoËet odpoËÌtan˝ od vlastnej daÚovej povinnosti podæa ß79 z·kona"; $price=$r33; $pid = "r33";}
        if( $i == 23 ) { $name="VLASTN¡ DA“OV¡ POVINNOSç NA ⁄HRADU"; $price=$r34; $pid = "r34";}


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



//otvor priznanie
if( $zandroidu == 0 OR $pdfand == 1 )
  {
?>
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
  }
}

if( $copern == 30 )
   {
?>
</table>
<?php
   }


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F$kli_vxcf"."_prcprizdphuh".$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
<?php
if( $zandroidu == 0 OR $pdfand == 1 )
  {
?>
</body>
</html>
<?php
  }
?>