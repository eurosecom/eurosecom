<?php
$pdfand=200;
$zandroidu=1*$_REQUEST['zandroidu'];
if ( $zandroidu == 1 )
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
if ( $anduct == 1 )
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

if ( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }

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

if ( $druhid < 20 ) { exit; }
$kli_uzid=$cuid;
if ( $kli_uzid == 0 ) { exit; }

$kli_vume=1*$_REQUEST['kli_vume'];
$kli_vduj=1*$_REQUEST['kli_vduj'];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$_REQUEST['h_dap']=$dnes;

$pdfand=1*$_REQUEST['pdfand'];

$cislo_cpid=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_archivdph WHERE druh = 1 AND ume = $kli_vume ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cislo_cpid=$riaddok->cpid;
    }
$_REQUEST['cislo_cpid']=$cislo_cpid;

     }

if ( $zandroidu == 0 )
     {
?>
<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$cslm=100420;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
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
$xmlko=1*$_REQUEST['xmlko'];
$control=1*$_REQUEST['control'];
if( $control == 1 ) { $xmlko=1; }

if ( $zandroidu == 0 )
     {
require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
     }

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=1;

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

$dodatmanualxml = 1*$_REQUEST['dodatmanualxml'];
$dodatmanualpdf = 1*$_REQUEST['dodatmanualpdf'];
if( $dodatmanualxml == 0 AND $dodatmanualpdf == 0 ) {

$zoznamzarchu=0;
//zoznam z archivu
if ( $copern == 7020 )
{
$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_dap = "";
$cislo_cpid = 1*$_REQUEST['cislo_cpid'];
$cislo_cpop = 1*$_REQUEST['cislo_cpop'];
$rozdiel = 1*$_REQUEST['rozdiel'];
$h_arch=0;
$h_drp=$cislo_druh;
$h_dap="";
$fir_uctx01=1;

$kli_vume=$cislo_ume;
if ( $cislo_stvrt == 1 ) { $kli_vume="1.".$kli_vrok; $fir_uctx01=2; }
if ( $cislo_stvrt == 2 ) { $kli_vume="4.".$kli_vrok; $fir_uctx01=2; }
if ( $cislo_stvrt == 3 ) { $kli_vume="7.".$kli_vrok; $fir_uctx01=2; }
if ( $cislo_stvrt == 4 ) { $kli_vume="10.".$kli_vrok; $fir_uctx01=2; }
$zoznamzarchu=1;
$copern=20;
}
//koniec zoznam z archivu

//datum odpoctu v dodav
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha7new ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   kodt        VARCHAR(20) NOT NULL,
   dtov        VARCHAR(5) NOT NULL,
   mnot        DECIMAL(10,2) DEFAULT 0,
   merj        VARCHAR(5) NOT NULL,
   zkld        DECIMAL(10,2) DEFAULT 0,
   sumd        DECIMAL(10,2) DEFAULT 0,
   prx1        DECIMAL(4,0) DEFAULT 0,
   prx2        DECIMAL(4,0) DEFAULT 0,
   prx3        DECIMAL(4,0) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY sz4 DATE NOT NULL ";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2014 ) {
$sql = "UPDATE F$kli_vxcf"."_fakdod SET sz4=daz WHERE daz != '0000-00-00' ";
$vysledek = mysql_query("$sql");
                        }

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha7new".$sqlt;
$vysledek = mysql_query("$sql");
}
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha11new ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   kodt        VARCHAR(20) NOT NULL,
   dtov        VARCHAR(5) NOT NULL,
   mnot        DECIMAL(10,2) DEFAULT 0,
   merj        VARCHAR(5) NOT NULL,
   zkld        DECIMAL(10,2) DEFAULT 0,
   sumd        DECIMAL(10,2) DEFAULT 0,
   prx1        DECIMAL(4,0) DEFAULT 0,
   prx2        DECIMAL(4,0) DEFAULT 0,
   prx3        DECIMAL(4,0) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;
$sql = "ALTER TABLE F$kli_vxcf"."_archivdphkvdph MODIFY kvfak VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdphkvdph MODIFY kvpvf VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha11new".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec datum odpoctu v dodav

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   cpl          int not null auto_increment,
   kvdic        VARCHAR(20),
   cpid         INT,
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
   dok          DECIMAL(10,0),
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
   fic          INT,
   PRIMARY KEY(cpl)
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

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
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$obddph="";
if ( $fir_uctx01 == 2 ) {
$kli_mdph="";
if ( $mesp_dph >= 1 AND $mesp_dph <= 3) { $mesp_dph=1; $mesk_dph=3; $obddph="1"; }
if ( $mesp_dph >= 4 AND $mesp_dph <= 6) { $mesp_dph=4; $mesk_dph=6; $obddph="2"; }
if ( $mesp_dph >= 7 AND $mesp_dph <= 9) { $mesp_dph=7; $mesk_dph=9; $obddph="3"; }
if ( $mesp_dph >= 10 AND $mesp_dph <= 12) { $mesp_dph=10; $mesk_dph=12; $obddph="4"; }
                       }

if ( $fir_uctx01 == 4 ) {
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

$zarchivu=0;

if ( $copern == 20 )
{
//ak zoznam z archu
if ( $zoznamzarchu == 1 )
   {
//archzoznam er1  er2  er3  er4  zk0  zk1  zk2  dn1  dn2  ume  dat  daz  psys  r01  r02  r03  r04  r05  r06  r07  r08  r09  r10  
//hod  rdp  rdk  xrz  xrd  xsz  ucm  ucd  ico  fak  dok  r11  r12  r13  r14  r15  r16  r17  r18  r19  r20  r21  r22  
//r23  r24  r25  r26  r27  r28  r29  r30  r31  r32  r33  r34  r35  r36  r37  r38  fic  

//aktualny   er1  er2  er3  er4  zk0  zk1  zk2  dn1  dn2  ume  dat  daz  psys  r01  r02  r03  r04  r05  r06  r07  r08  r09  r10
//hod  rdp  rdk  xrz  xrd  xsz  ucm  ucd  ico  fak  dok  r11  r12  r13  r14  r15  r16  r17  r18  r19  r20  r21  r22  
//r23  r24  r25  r26  r27  r28  r29  r30  r31  r32  r33  r34  r35  r36  r37  r38  fic  

if ( $cislo_stvrt == 0 ) { $podmzarchu=" er1 = 0 AND daz >= '$datp_dph' AND daz <= '$datk_dph' "; }
if ( $cislo_stvrt > 0 ) { $podmzarchu=" er1 = $cislo_stvrt "; }

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,'',er4,0,0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
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

//exit;

//iny datum priznanie DPH a KVDPH
$sqlttx = "SELECT * FROM F$kli_vxcf"."_fakturasetdak WHERE dok > 0 ORDER BY dok";
$sqlx = mysql_query("$sqlttx");
if($sqlx)
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_fakturasetdak WHERE dok > 0 AND ( dak < '$datp_dph' OR dak > '$datk_dph' ) ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz."<br />";

}
$i = $i + 1;
  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_fakturasetdak WHERE dok > 0 AND dak >= '$datp_dph' AND dak <= '$datk_dph'  ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = $hlavicka->dok ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz."<br />";

$piddak=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_archivdphzoznam WHERE dok = $hlavicka->dok ORDER BY er4 DESC ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $piddak=1*$riaddok->er4;
  }

$sz4dat=$datp_dph;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok = $hlavicka->dok ORDER BY dok ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sz4dat=$riaddok->sz4;
  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,'','$cislo_cpid',99,0,0,0,0,0,0,0,0,ume,'$sz4dat','$hlavicka->dak',psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_archivdphzoznam ".
" WHERE dok = $hlavicka->dok AND er4 = $piddak ".
" GROUP BY rdk,dok,fak,ico,hod ".
"";
$dsql = mysql_query("$dsqlt");

}
$i = $i + 1;
  }

    }
//koniec iny datum priznanie DPH a KVDPH

$sql = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE daz < '$datp_dph' ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE daz > '$datk_dph' ";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0, daz=dat WHERE er1 = 99 ";
$oznac = mysql_query("$sqtoz");

//exit;

   }
//koniec ak zoznam z archu


//pridaj polozky KVDPH
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvcobr DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvmerj VARCHAR(20) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvmnot DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvdtov VARCHAR(20) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvkodt VARCHAR(20) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvodn DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvzkl DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvzdn DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvszd DECIMAL(4,0) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvsdn DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvzdn DECIMAL(10,2) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvpvf VARCHAR(30) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvfak VARCHAR(30) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvicd VARCHAR(20) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvodd VARCHAR(10) NOT NULL AFTER er1";
$vysledek = mysql_query("$sql");


//samozdaneniu DPH rdp 34,35... crz3=1 pripoj zaklad z 84,85...
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE crz3 = 1 AND crd < 19 ORDER BY rdp";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdp=rdp-50 WHERE rdp = $hlavicka->rdp AND ( rdk = 5 OR rdk = 7 OR rdk = 9 OR rdk = 11 OR rdk = 13 ) ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz."<br />";

//dobropis
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdp=rdp-50 WHERE rdp = $hlavicka->rdp AND rdk = 26 ";
$oznac = mysql_query("$sqtoz");

}
$i = $i + 1;
  }


//u prenesenej rdp 361,461 nastav dan.zaklad lebo nejde do priznania DPH
$aj361=1; $ajkoef=1;
if( $_SERVER['SERVER_NAME'] == "www.euroautovlas.sk" ) { $aj361=0; $ajkoef=0; }
if( $aj361 == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET rdk=16, r16=hod WHERE rdp = 361 OR rdp = 461 ";
$oznac = mysql_query("$sqtoz");
  }

//nastav oddiel KVDPH a sadzbu DPH
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid,F$kli_vxcf"."_uctdrdp SET kvodd=crd3, kvszd=szd ".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.rdp=F$kli_vxcf"."_uctdrdp.rdp ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvszd=20 WHERE rdp = 461 ";
$oznac = mysql_query("$sqtoz");

//nastav icdph POZOR ak ODBM > 0 a nastav dic
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphs".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphs$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys < 999 ORDER BY rdk,psys,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$icdtlac=trim($hlavicka->icd);
$dictlac=trim($hlavicka->dic);

$odbmx=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $hlavicka->dok AND odbm > 0 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odbm=1*$riaddok->odbm;
  $odbmx=1;
  }
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok = $hlavicka->dok AND odbm > 0 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odbm=1*$riaddok->odbm;
  $odbmx=1;
  }
if ( $odbmx > 0 )
     {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $hlavicka->ico AND odbm = $odbmx ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $icdtlac=trim($riaddok->icd2);
  }
     }

$icdtlac=str_replace(" ","",$icdtlac);
$dictlac=str_replace(" ","",$dictlac);
$icdtlac=strtoupper($icdtlac);
$dictlac=strtoupper($dictlac);

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvicd='$icdtlac', kvdic='$dictlac' WHERE dok = $hlavicka->dok ";
$oznac = mysql_query("$sqtoz");
}
$i = $i + 1;
  }

//ak je B2 a rdp < 50 a psys < 15 tzn stare druhy a pokladnica, banka, vseob = zjednodusena fak a daj B3
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='B3' WHERE rdp < 50 AND psys < 15 AND kvodd = 'B2' ";
$oznac = mysql_query("$sqtoz");

//ak je A1 a rdp < 99 a psys < 15 tzn stare druhy a pokladnica, banka, vseob = asi ERP a daj D1 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='D1' WHERE rdp < 99 AND psys < 15 AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");

//ak je A1 a rdp < 99 a psys = 17 tzn stare druhy a podsystem Sklad = asi ERP a daj D1. alchem prenasa zalohy
if( $alchem == 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='D1' WHERE rdp < 99 AND psys = 17 AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");
  }

//ak je A1 a icdph = '' aj dic = '' daj do D2 nepodnikatel vratane oprav
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='D2' WHERE kvicd = '' AND kvdic = '' AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");

//ak je A1 a icdph = '0' aj dic = '0' daj do D2 nepodnikatel vratane oprav
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='D2' WHERE kvicd = '0' AND kvdic = '' AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='D2' WHERE kvicd = '0' AND kvdic = '0' AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");

//ak je A1 a rdk 26,27 daj do C1 opravne 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='C1' WHERE ( rdk = 26 OR rdk = 27 ) AND kvodd = 'A1' ";
$oznac = mysql_query("$sqtoz");

//nastav cislo faktury POZOR ak textove znaky
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvfak=dok WHERE dok >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid,F$kli_vxcf"."_fakodb SET kvpvf=dav, kvfak=sz3 ".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.dok=F$kli_vxcf"."_fakodb.dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid,F$kli_vxcf"."_fakdod SET kvpvf=dav, kvfak=sz3 ".
" WHERE F$kli_vxcf"."_prcprizdphs$kli_uzid.dok=F$kli_vxcf"."_fakdod.dok ";
$oznac = mysql_query("$sqtoz");


//suma zakladu a dane 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn=hod WHERE rdk = 1 OR rdk = 3 OR rdk = 5 OR rdk = 7 OR rdk = 9 OR rdk = 11 ".
" OR rdk = 13 OR rdk = 15 OR rdk = 16 OR rdk = 17 OR rdk = 26 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvsdn=hod WHERE rdk = 2 OR rdk = 4 OR rdk = 6 OR rdk = 8 OR rdk = 10 OR rdk = 12 OR rdk = 14 OR rdk = 27 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn=hod WHERE rdk = 0 AND xrz = 0 AND ".
" ( xrd = 21 OR xrd = 22 OR xrd = 23 OR xrd = 24 OR xrd = 25 OR xrd = 28 ) ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvsdn=hod WHERE rdk = 20 OR rdk = 21 OR rdk = 22 OR rdk = 23 OR rdk = 24 OR rdk = 25 OR rdk = 28 ";
$oznac = mysql_query("$sqtoz");

//drd ktore idu len do KVDPH a nie do priznania DPH rdk=100
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn=hod WHERE rdk = 0 AND xrz = 0 AND xrd = 100 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvsdn=hod WHERE rdk = 100";
$oznac = mysql_query("$sqtoz");

//exit;

//JCD DPH rdp 34,35... crz1=1 vypocitaj zaklad NAKONIEC JCD NEJDU DO KV DPH
if( $fir_uctx07 == 1001 ) { 
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE crz1 = 1 ORDER BY rdp";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$poddph2="0.".$fir_dph2;

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn=(kvsdn/$poddph2) WHERE rdp = $hlavicka->rdp ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz."<br />";


}
$i = $i + 1;
  }
                        }
//exit;

//suma zakladu a dane POZOR dodav dobropisy r28 daj sumu dane -
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvsdn=-hod WHERE rdk = 28 AND hod > 0";
$oznac = mysql_query("$sqtoz");

//ak je B1,B2 kvsdn < 0 alebo kvzdn < 0 daj do C2 opravne a je vyplnene kvpvf 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodd='C2' WHERE ( kvsdn < 0 OR kvzdn < 0 ) AND ( kvodd = 'B1' OR kvodd = 'B2' ) AND kvpvf != '' ";
$oznac = mysql_query("$sqtoz");


//dopln tovar do A2
if( $aj361 == 1 )
          {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphs".$kli_uzid." WHERE kvodd = 'A2' AND er1 = 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "SELECT * FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok = $hlavicka->dok ORDER BY dok,kodt,dtov ";
$sqlx = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqlx);

$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix) OR $ix == 0 )
{
$hlavickax=mysql_fetch_object($sqlx);

//cpld	dok	kodt	dtov	mnot	merj	zkld	sumd	prx1	prx2

//kvicd	kvfak	kvpvf	kvsdn	kvszd	kvzdn
$kodtov4=substr($hlavickax->kodt,0,4);

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,kvdic,cpid,9,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,'$hlavickax->zkld',0,'$kodtov4','$hlavickax->dtov','$hlavickax->mnot','$hlavickax->merj',0,0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'A2' AND er1 = 0 AND cpl = $hlavicka->cpl ".
" GROUP BY cpl ".
"";
$dsql = mysql_query("$dsqlt");
}
$ix = $ix + 1;
  }

}
$i = $i + 1;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE kvodd = 'A2' AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 WHERE kvodd = 'A2' AND er1 = 9 ";
$oznac = mysql_query("$sqtoz");

//koniec if( aj361 == 1 )
          }
//koniec dopln tovar do A2

//dopln tovar do C1
if( $aj361 == 1 )
          {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphs".$kli_uzid." WHERE kvodd = 'C1' AND er1 = 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqlttx = "SELECT * FROM F$kli_vxcf"."_uctvykdpha2 WHERE dok = $hlavicka->dok ORDER BY dok,kodt,dtov ";
$sqlx = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqlx);

$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix) OR $ix == 0 )
{
$hlavickax=mysql_fetch_object($sqlx);

//cpld	dok	kodt	dtov	mnot	merj	zkld	sumd	prx1	prx2

//kvicd	kvfak	kvpvf	kvsdn	kvszd	kvzdn
$kodtov4=substr($hlavickax->kodt,0,4);

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid "." SELECT".
" 0,kvdic,cpid,9,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,'$hlavickax->zkld',0,'$kodtov4','$hlavickax->dtov','$hlavickax->mnot','$hlavickax->merj',0,0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'C1' AND er1 = 0 AND cpl = $hlavicka->cpl ".
" GROUP BY cpl ".
"";
$dsql = mysql_query("$dsqlt");
}
$ix = $ix + 1;
  }
}
$i = $i + 1;
  }
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE kvodd = 'C1' AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=0 WHERE kvodd = 'C1' AND er1 = 9 ";
$oznac = mysql_query("$sqtoz");

//koniec if( aj361 == 1 )
          }
//koniec dopln tovar do C1


//odpocitana dan u dodavatelskych
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodn=kvsdn WHERE er1 = 0 ";
$oznac = mysql_query("$sqtoz");


//znizenie odpocitanej ak koeficient
$koefmin=0; $druhykoef="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_archivdph WHERE cpid = $cislo_cpid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $koefmin=1*$riadok->koefmin;
  $druhykoef=trim($riadok->druhykoef);
  }

if( $koefmin >= 0 AND $koefmin < 1 AND $druhykoef != '' AND $ajkoef == 1 )
    {  
$pole = explode(",", $druhykoef);

$podmrdp="";

$cislo=1*$pole[0];
if( $cislo > 0 ) $podmrdp=$podmrdp." ( rdp = $pole[0] ";
$cislo=1*$pole[1];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[1] ";
$cislo=1*$pole[2];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[2] ";
$cislo=1*$pole[3];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[3] ";
$cislo=1*$pole[4];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[4] ";
$cislo=1*$pole[5];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[5] ";
$cislo=1*$pole[6];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[6] ";
$cislo=1*$pole[7];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[7] ";

$podmrdp=$podmrdp." ) ";

//echo "podm ".$podmrdp." koef ".$koefmin;

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodn=$koefmin*kvsdn WHERE er1 = 0 AND $podmrdp ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;
    }
//koniec znizenie odpocitanej ak koeficient


//nulovanie odpocitanej ak rdk=100
$sqlttx = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE crd = 100 ORDER BY rdp ";
$sqlx = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqlx);
$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix) OR $ix == 0 )
{
$hlavickax=mysql_fetch_object($sqlx);


$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvodn=0*kvsdn WHERE rdp = $hlavickax->rdp ";
$oznac = mysql_query("$sqtoz");
}
$ix = $ix + 1;
  }
//koniec nulovanie odpocitanej ak rdk=100
//exit;

//celkova suma obratov
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvcobr=kvsdn+kvzdn WHERE er1 = 0 ";
$oznac = mysql_query("$sqtoz");

//vyssia sadzba dane
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvsdn20 DECIMAL(10,2) NOT NULL AFTER r38";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvzdn20 DECIMAL(10,2) NOT NULL AFTER r38";
$vysledek = mysql_query("$sql");
//znizena sadzba dane
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvsdn10 DECIMAL(10,2) NOT NULL AFTER r38";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD kvzdn10 DECIMAL(10,2) NOT NULL AFTER r38";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn20=kvzdn, kvsdn20=kvsdn WHERE er1 = 0 AND kvszd = $fir_dph2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET kvzdn10=kvzdn, kvsdn10=kvsdn WHERE er1 = 0 AND kvszd != $fir_dph2 ";
$oznac = mysql_query("$sqtoz");

//v oddiele B1,B2,C1 oprav datum dodania ak sz4 != daz AND sz4 != 0000-00-00 andrejko
$sqltt = "SELECT * FROM F$kli_vxcf"."_fakdod WHERE sz4 != daz AND sz4 != '0000-00-00' AND daz >= '$datp_dph' AND daz <= '$datk_dph' ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET daz='$hlavicka->sz4' WHERE dok = $hlavicka->dok ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz."<br />";

}
$i = $i + 1;
  }
//exit;

//koniec v oddiele B1,B2,C1 oprav datum dodania ak sz4 != daz AND sz4 != 0000-00-00 andrejko

//presun do tlacovej tabulky
$sqtoz = "DROP TABLE F$kli_vxcf"."_prcprizdphst$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT * FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE er1 = 99 ";
$oznac = mysql_query("$sqtoz");


$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphst$kli_uzid MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,9,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'A1' OR kvodd = 'B1' OR kvodd = 'B2' OR kvodd = 'C2' ".
" GROUP BY kvodd,dok,kvszd ".
"";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,9,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'A2' OR ( kvodd = 'C1' AND kvmnot != 0 ) ".
" GROUP BY dok,cpl ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,0,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'B3' OR kvodd = 'D1' OR kvodd = 'D2' ".
" GROUP BY dok ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,9,0,0,0,0,0,ume,dat,daz,psys,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ".
" WHERE kvodd = 'C1' AND kvmnot = 0 ".
" GROUP BY dok ".
"";
$dsql = mysql_query("$dsqlt");

//suma za oddiel
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,0,0,0,0,0,0,ume,dat,daz,30,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,999999999,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphst$kli_uzid ".
" WHERE dok >= 0 AND kvodd != 'B3' AND kvodd != 'D1' AND kvodd != 'D2' ".
" GROUP BY kvodd ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid "." SELECT".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,SUM(kvsdn),kvszd,SUM(kvzdn),SUM(kvzkl),SUM(kvodn),kvkodt,kvdtov,SUM(kvmnot),kvmerj,SUM(kvcobr),0,0,9,0,0,0,0,0,ume,dat,daz,30,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(hod),rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,999999999,".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(kvzdn10),SUM(kvsdn10),SUM(kvzdn20),SUM(kvsdn20),".
"fic".
" FROM F$kli_vxcf"."_prcprizdphst$kli_uzid ".
" WHERE dok >= 0 AND ( kvodd = 'B3' OR kvodd = 'D1' OR kvodd = 'D2' ) ".
" GROUP BY kvodd ".
"";
$dsql = mysql_query("$dsqlt");                                                   

//tlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphst".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphst$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE psys < 999 ".
" ORDER BY kvodd,dok,kvszd";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}
//koniec copern=20

//koniec dodatmanualxml == 0 a dodatmanualpdf == 0  {
                                                    }

if( $dodatmanualxml == 1 ) { $xmlko=1; $control=0; }	
?>

<?php
if ( $zandroidu == 0 OR $pdfand == 1 )
     {
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Kontroln˝ v˝kaz DPH</title>
<script type="text/javascript">

function KvControl()
                {
window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&xmlko=1&control=1&cislo_cpid=<?php echo $cislo_cpid; ?>&cislo_ume=<?php echo $cislo_ume; ?>&cislo_druh=<?php echo $cislo_druh; ?>&cislo_stvrt=<?php echo $cislo_stvrt; ?>&rozdiel=0',
 '_self' );
                }

function OverIcdph()
                {
        window.open('http://ec.europa.eu/taxation_customs/vies/', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

function OverIcdphSK()
                {
        window.open('https://www.financnasprava.sk/sk/elektronicke-sluzby/verejne-sluzby/zoznamy/detail/_72414cdf-8eb7-478d-9ac2-a275008b40a0', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 

                }
</script>
</HEAD>
<BODY class="white">
<?php if ( $pdfand == 1 ) { ?>
<table class="h2" width="100%" >
 <tr>
  <td>Zostava PDF prebran·, tlaËidlo Sp‰ù - do daÚov˝ch zost·v</td>
  <td align="right"></td>
 </tr>
</table>
<br />
<?php                     } ?>
<?php
     }
?>

<?php if ( $xmlko == 1 AND $control == 0 ) { ?>
<table class="h2" width="100%">
 <tr>
  <td>EuroSecom  -  Kontroln˝ v˝kaz DPH - export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
 </tr>
</table>
<?php                    } ?>
<?php if ( $xmlko == 1 AND $control == 1 ) { ?>
<table class="h2" width="100%">
 <tr>
  <td>EuroSecom  -  Kontroln˝ v˝kaz DPH - kontrola

<img src='../obr/ok.png' onClick="KvControl();" width=20 height=15 border=0 title="Znovu naËÌtaù kontrolu">


</td>
  <td align="right" class"fmenu">
<a href="#" onclick="OverIcdph();" >Overovanie I» DPH E⁄</a>
<a href="#" onclick="OverIcdphSK();" >Overovanie I» DPH SK</a>
</td>
 </tr>
</table>
<?php                    } ?>

<?php
//tlac do PDF
if ( $xmlko == 0 )
{
if ( File_Exists("../tmp/kontroldph$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/kontroldph$kli_vume.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

if ( $copern == 20 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->SetFont('arial','',8);
}

$strana=0;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//hlavicka j=0
if ( $j == 0 )
{
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,0);
$strana=$strana+1;
$pdf->SetY(200);
$obdobievypis=$cislo_ume;
if( $cislo_stvrt == 1 ) { $obdobievypis="I. $kli_vrok"; }
if( $cislo_stvrt == 2 ) { $obdobievypis="II. $kli_vrok"; }
if( $cislo_stvrt == 3 ) { $obdobievypis="III. $kli_vrok"; }
if( $cislo_stvrt == 4 ) { $obdobievypis="IV. $kli_vrok"; }

if ( $cislo_cpop == 0 ) {
$pdf->Cell(100,4,"Strana $strana","$rmc",0,"L");$pdf->Cell(77,4,"id $cislo_cpid","$rmc",0,"C");
$pdf->Cell(100,4,"$obdobievypis","$rmc",1,"R"); //dopyt, oöetriù aby d·val buÔ mesiac Ëi ötvrùrok a pri ötvrùroku rÌmske
                        }
if ( $cislo_cpop >  0 ) {
$pdf->Cell(100,4,"Strana $strana","$rmc",0,"L");
$pdf->Cell(77,4,"id $cislo_cpid dodatoËn˝ k id $cislo_cpop","$rmc",0,"C");
$pdf->Cell(100,4,"$obdobievypis","$rmc",1,"R"); //dopyt, oöetriù aby d·val buÔ mesiac Ëi ötvrùrok a pri ötvrùroku rÌmske
                        }
$pdf->SetY(6);
$pdf->SetFillColor(217,217,217);

if ( $hlavicka->kvodd == "A1" ) {
$texta="⁄daje z vyhotovenej fakt˙ry o dodanÌ tovarov a sluûieb";
$texta1="⁄daje z vyhotovenej fakt˙ry o dodanÌ tovarov a sluûieb, ktor˙ bol platiteæ dane povinn˝ vyhotoviù podæa ß 71 aû 75 z·kona, pri ktor˝ch je osobou povinnou platiù daÚ (okrem zjednoduöenej fakt˙ry a
        fakt˙ry o dodanÌ plnenÌ osloboden˝ch od dane)";
$texta1s1p1="IdentifikaËnÈ ËÌslo pre daÚ";
$texta1s1p2="odberateæa";
$texta1s2="PoradovÈ ËÌslo fakt˙ry";
$texta1s3p1="D·tum dodania tovaru";
$texta1s3p2="alebo sluûby alebo d·tum";
$texta1s3p3="prijatia platby";
$texta1s4="Z·klad dane v eur·ch";
$texta1s5="Suma dane v eur·ch";
$texta1s6="Sadzba dane";
$texta1s7p1="KÛd opravy";
$texta1s7p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4,"A. $texta","$rmc1",1,"L");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->MultiCell(277,4,"A.1. $texta1","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(40,3.5," ","LT",0,"C");$pdf->Cell(40,3.5," ","LT",0,"C");$pdf->Cell(40,3.5,"$texta1s3p1","LT",0,"C");$pdf->Cell(40,3.5," ","LT",0,"C");
$pdf->Cell(40,3.5," ","LT",0,"C");$pdf->Cell(40,3.5," ","LT",0,"C");$pdf->Cell(37,3.5," ","LTR",1,"C");
$pdf->Cell(40,3.5,"$texta1s1p1","L",0,"C");$pdf->Cell(40,3.5,"$texta1s2","L",0,"C");$pdf->Cell(40,3.5,"$texta1s3p2","L",0,"C");$pdf->Cell(40,3.5,"$texta1s4","L",0,"C");
$pdf->Cell(40,3.5,"$texta1s5","L",0,"C");$pdf->Cell(40,3.5,"$texta1s6 ","L",0,"C");$pdf->Cell(37,3.5,"$texta1s7p1","LR",1,"C");
$pdf->Cell(40,3.5,"$texta1s1p2","L",0,"C");$pdf->Cell(40,3.5," ","L",0,"C");$pdf->Cell(40,3.5,"$texta1s3p3","L",0,"C");$pdf->Cell(40,3.5," ","L",0,"C");
$pdf->Cell(40,3.5," ","L",0,"C");$pdf->Cell(40,3.5,"%","L",0,"C");$pdf->Cell(37,3.5,"$texta1s7p2","LR",1,"C");
$pdf->Cell(40,4,"1","$rmc1",0,"C",true);$pdf->Cell(40,4,"2","$rmc1",0,"C",true);$pdf->Cell(40,4,"3","$rmc1",0,"C",true);$pdf->Cell(40,4,"4","$rmc1",0,"C",true);
$pdf->Cell(40,4,"5","$rmc1",0,"C",true);$pdf->Cell(40,4,"6","$rmc1",0,"C",true);$pdf->Cell(37,4,"7","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "A2" ) {
$texta2="⁄daje z vyhotovenej fakt˙ry o dodanÌ tovarov, ktor˙ bol platiteæ dane povinn˝ vyhotoviù podæa ß 71 aû 75 z·kona, pri ktor˝ch je osobou povinnou platiù daÚ prÌjemca plnenia podæa ß 69 ods. 12 pÌsm. f) aû i) z·kona";
$texta2s1p1="IdentifikaËnÈ ËÌslo";
$texta2s1p2="pre daÚ odberateæa";
$texta2s2p1="PoradovÈ ËÌslo";
$texta2s2p2="fakt˙ry";
$texta2s3p1="D·tum dodania";
$texta2s3p2="tovaru alebo d·tum";
$texta2s3p3="prijatia platby";
$texta2s4p1="Z·klad dane";
$texta2s4p2="v eur·ch";
$texta2s5p1="»Ìseln˝ kÛd tovaru podæa";
$texta2s5p2="SpoloËnÈho colnÈho sadzobnÌka";
$texta2s5p3="[len tovar podæa ß 69";
$texta2s5p4="ods. 12 pÌsm. f) a g) z·kona]";
$texta2s6p1="Druh tovaru";
$texta2s6p2="[len tovar podæa ß";
$texta2s6p3="69 ods. 12 pÌsm. h) a";
$texta2s6p4="i) z·kona]";
$texta2s7p1="Mnoûstvo tovaru";
$texta2s7p2="[tovar podæa ß 69";
$texta2s7p3="ods. 12 pÌsm. f)";
$texta2s7p4="aû i) z·kona]";
$texta2s8="Mern· jednotka";
$texta2s9p1="KÛd opravy";
$texta2s9p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4.5," ","$rmc",1,"L");
$pdf->MultiCell(277,4,"A.2. $texta2","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(31,3.5," ","LT",0,"C");$pdf->Cell(31,3.5," ","LT",0,"C");$pdf->Cell(27,3.5," ","LT",0,"C");$pdf->Cell(31,3.5," ","LT",0,"C");
$pdf->Cell(46,3.5,"$texta2s5p1","LT",0,"C");$pdf->Cell(31,3.5,"$texta2s6p1","LT",0,"C");$pdf->Cell(31,3.5,"$texta2s7p1","LT",0,"C");$pdf->Cell(25,3.5," ","LT",0,"C");
$pdf->Cell(24,3.5," ","LTR",1,"C");
$pdf->Cell(31,3.5,"$texta2s1p1","L",0,"C");$pdf->Cell(31,3.5,"$texta2s2p1","L",0,"C");$pdf->Cell(27,3.5,"$texta2s3p1","L",0,"C");$pdf->Cell(31,3.5,"$texta2s4p1","L",0,"C");
$pdf->Cell(46,3.5,"$texta2s5p2","L",0,"C");$pdf->Cell(31,3.5,"$texta2s6p2","L",0,"C");$pdf->Cell(31,3.5,"$texta2s7p2","L",0,"C");$pdf->Cell(25,3.5," ","L",0,"C");
$pdf->Cell(24,3.5,"$texta2s9p1","LR",1,"C");
$pdf->Cell(31,3.5,"$texta2s1p2","L",0,"C");$pdf->Cell(31,3.5,"$texta2s2p2","L",0,"C");$pdf->Cell(27,3.5,"$texta2s3p2","L",0,"C");$pdf->Cell(31,3.5,"$texta2s4p2","L",0,"C");
$pdf->Cell(46,3.5,"$texta2s5p3","L",0,"C");$pdf->Cell(31,3.5,"$texta2s6p3","L",0,"C");$pdf->Cell(31,3.5,"$texta2s7p3","L",0,"C");$pdf->Cell(25,3.5,"$texta2s8","L",0,"C");
$pdf->Cell(24,3.5,"$texta2s9p2","LR",1,"C");
$pdf->Cell(31,3.5,"","L",0,"C");$pdf->Cell(31,3.5," ","L",0,"C");$pdf->Cell(27,3.5,"$texta2s3p3","L",0,"C");$pdf->Cell(31,3.5," ","L",0,"C");
$pdf->Cell(46,3.5,"$texta2s5p4","L",0,"C");$pdf->Cell(31,3.5,"$texta2s6p4","L",0,"C");$pdf->Cell(31,3.5,"$texta2s7p4","L",0,"C");$pdf->Cell(25,3.5,"","L",0,"C");
$pdf->Cell(24,3.5,"","LR",1,"C");
$pdf->Cell(31,4,"1","$rmc1",0,"C",true);$pdf->Cell(31,4,"2","$rmc1",0,"C",true);$pdf->Cell(27,4,"3","$rmc1",0,"C",true);$pdf->Cell(31,4,"4","$rmc1",0,"C",true);
$pdf->Cell(46,4,"5","$rmc1",0,"C",true);$pdf->Cell(31,4,"6","$rmc1",0,"C",true);$pdf->Cell(31,4,"7","$rmc1",0,"C",true);$pdf->Cell(25,4,"8","$rmc1",0,"C",true);
$pdf->Cell(24,4,"9","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "B1" ) {
$textb="⁄daje z prijatej fakt˙ry o dodanÌ tovarov a sluûieb";
$textb1="⁄daje z prijatej fakt˙ry, pri ktorej je osobou povinnou platiù daÚ prÌjemca plnenia podæa ß 69 ods. 2, 3, 6, 7 a 9 aû 12 z·kona (okrem fakt˙ry o dodanÌ plnenÌ osloboden˝ch od dane)";
$textb1s1p1="IdentifikaËnÈ ËÌslo";
$textb1s1p2="pre daÚ dod·vateæa";
$textb1s2p1="PoradovÈ ËÌslo fakt˙ry";
$textb1s2p2="alebo ËÌseln·";
$textb1s2p3="identifik·cia dokladu";
$textb1s3p1="D·tum dodania tovaru";
$textb1s3p2="alebo sluûby alebo";
$textb1s3p3="d·tum prijatia platby";
$textb1s4="Z·klad dane v eur·ch";
$textb1s5="Suma dane v eur·ch";
$textb1s6p1="Sadzba dane";
$textb1s6p2="%";
$textb1s7p1="V˝öka odpoËÌtanej";
$textb1s7p2="dane v eur·ch";
$textb1s8p1="KÛd opravy";
$textb1s8p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4,"B. $textb","$rmc1",1,"L");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->MultiCell(277,4,"B.1. $textb1","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7,"$textb1s2p1","LT",0,"C");$pdf->Cell(35,4.7,"$textb1s3p1","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(32,4.7," ","LTR",1,"C");
$pdf->Cell(35,4.6,"$textb1s1p1","L",0,"C");$pdf->Cell(35,4.6,"$textb1s2p2","L",0,"C");$pdf->Cell(35,4.6,"$textb1s3p2","L",0,"C");$pdf->Cell(35,4.6,"$textb1s4","L",0,"C");
$pdf->Cell(35,4.6,"$textb1s5","L",0,"C");$pdf->Cell(35,4.6,"$textb1s6p1","L",0,"C");$pdf->Cell(35,4.6,"$textb1s7p1","L",0,"C");$pdf->Cell(32,4.6,"$textb1s8p1","LR",1,"C");
$pdf->Cell(35,4.7,"$textb1s1p2","L",0,"C");$pdf->Cell(35,4.7,"$textb1s2p3","L",0,"C");$pdf->Cell(35,4.7,"$textb1s3p3","L",0,"C");$pdf->Cell(35,4.7," ","L",0,"C");
$pdf->Cell(35,4.7," ","L",0,"C");$pdf->Cell(35,4.7,"$textb1s6p2","L",0,"C");$pdf->Cell(35,4.7,"$textb1s7p2","L",0,"C");$pdf->Cell(32,4.7,"$textb1s8p2","LR",1,"C");
$pdf->Cell(35,4,"1","$rmc1",0,"C",true);$pdf->Cell(35,4,"2","$rmc1",0,"C",true);$pdf->Cell(35,4,"3","$rmc1",0,"C",true);$pdf->Cell(35,4,"4","$rmc1",0,"C",true);
$pdf->Cell(35,4,"5","$rmc1",0,"C",true);$pdf->Cell(35,4,"6","$rmc1",0,"C",true);$pdf->Cell(35,4,"7","$rmc1",0,"C",true);$pdf->Cell(32,4,"8","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if( $hlavicka->kvodd == "B2" ) {
$textb2="⁄daje z prijatej fakt˙ry, z ktorej prÌjemca plnenia uplatÚuje odpoËÌtanie dane a ktor˙ vyhotovil platiteæ dane, ktor˝ je osobou povinnou platiù daÚ podæa ß 69 ods. 1 z·kona";
$textb2s1p1="IdentifikaËnÈ ËÌslo";
$textb2s1p2="pre daÚ dod·vateæa";
$textb2s2="PoradovÈ ËÌslo fakt˙ry";
$textb2s3p1="D·tum dodania tovaru";
$textb2s3p2="alebo sluûby alebo";
$textb2s3p3="d·tum prijatia platby";
$textb2s4="Z·klad dane v eur·ch";
$textb2s5="Suma dane v eur·ch";
$textb2s6p1="Sadzba dane";
$textb2s6p2="%";
$textb2s7p1="V˝öka odpoËÌtanej";
$textb2s7p2="dane v eur·ch";
$textb2s8p1="KÛd opravy";
$textb2s8p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4.5," ","$rmc",1,"L");
$pdf->MultiCell(277,4,"B.2. $textb2","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7,"$textb2s3p1","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(32,4.7," ","LTR",1,"C");
$pdf->Cell(35,4.6,"$textb2s1p1","L",0,"C");$pdf->Cell(35,4.6,"$textb2s2","L",0,"C");$pdf->Cell(35,4.6,"$textb2s3p2","L",0,"C");$pdf->Cell(35,4.6,"$textb2s4","L",0,"C");
$pdf->Cell(35,4.6,"$textb2s5","L",0,"C");$pdf->Cell(35,4.6,"$textb2s6p1","L",0,"C");$pdf->Cell(35,4.6,"$textb2s7p1","L",0,"C");$pdf->Cell(32,4.6,"$textb2s8p1","LR",1,"C");
$pdf->Cell(35,4.7,"$textb2s1p2","L",0,"C");$pdf->Cell(35,4.7," ","L",0,"C");$pdf->Cell(35,4.7,"$textb2s3p3","L",0,"C");$pdf->Cell(35,4.7," ","L",0,"C");
$pdf->Cell(35,4.7," ","L",0,"C");$pdf->Cell(35,4.7,"$textb2s6p2","L",0,"C");$pdf->Cell(35,4.7,"$textb2s7p2","L",0,"C");$pdf->Cell(32,4.7,"$textb2s8p2","LR",1,"C");
$pdf->Cell(35,4,"1","$rmc1",0,"C",true);$pdf->Cell(35,4,"2","$rmc1",0,"C",true);$pdf->Cell(35,4,"3","$rmc1",0,"C",true);$pdf->Cell(35,4,"4","$rmc1",0,"C",true);
$pdf->Cell(35,4,"5","$rmc1",0,"C",true);$pdf->Cell(35,4,"6","$rmc1",0,"C",true);$pdf->Cell(35,4,"7","$rmc1",0,"C",true);$pdf->Cell(32,4,"8","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "B3" ) {
$textb3="⁄daje zo vöetk˝ch prijat˝ch zjednoduöen˝ch fakt˙r podæa ß 74 ods. 3 pÌsm. a) aû c) z·kona, z ktor˝ch prÌjemca plnenia uplatÚuje odpoËÌtanie dane";
$textb3s1p1="Celkov· suma z·kladov dane";
$textb3s1p2="v eur·ch";
$textb3s2p1="Celkov· suma dane";
$textb3s2p2="v eur·ch";
$textb3s3p1="Celkov· suma odpoËÌtanej dane";
$textb3s3p2="v eur·ch";
$textb3s4p1="KÛd opravy";
$textb3s4p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4.5," ","$rmc",1,"L");
$pdf->MultiCell(277,4,"B.3. $textb3","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(70,3.5," ","LT",0,"C");$pdf->Cell(70,3.5," ","LT",0,"C");$pdf->Cell(70,3.5," ","LT",0,"C");$pdf->Cell(67,3.5," ","LTR",1,"C");
$pdf->Cell(70,3.5,"$textb3s1p1","L",0,"C");$pdf->Cell(70,3.5,"$textb3s2p1","L",0,"C");$pdf->Cell(70,3.5,"$textb3s3p1","L",0,"C");$pdf->Cell(67,3.5,"$textb3s4p1","LR",1,"C");
$pdf->Cell(70,3.5,"$textb3s1p2","L",0,"C");$pdf->Cell(70,3.5,"$textb3s2p2","L",0,"C");$pdf->Cell(70,3.5,"$textb3s3p2","L",0,"C");$pdf->Cell(67,3.5,"$textb3s4p2","LR",1,"C");
$pdf->Cell(70,3.5," ","L",0,"C");$pdf->Cell(70,3.5," ","L",0,"C");$pdf->Cell(70,3.5," ","L",0,"C");$pdf->Cell(67,3.5," ","LR",1,"C");
$pdf->Cell(70,4,"1","$rmc1",0,"C",true);$pdf->Cell(70,4,"2","$rmc1",0,"C",true);$pdf->Cell(70,4,"3","$rmc1",0,"C",true);$pdf->Cell(67,4,"4","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "C1" ) {
$textc="⁄daje z fakt˙ry podæa ß 71 ods. 2 z·kona, ktor· menÌ pÙvodn˙ fakt˙ru (Ôalej len Ñopravn· fakt˙raì)";
$textc1="⁄daje z vyhotovenej opravnej fakt˙ry";
$textc1s1p1="IdentifikaËnÈ";
$textc1s1p2="ËÌslo pre daÚ";
$textc1s1p3="odberateæa";
$textc1s2p1="PoradovÈ ËÌslo";
$textc1s2p2="opravnej";
$textc1s2p3="fakt˙ry";
$textc1s3p1="PoradovÈ ËÌslo";
$textc1s3p2="pÙvodnej";
$textc1s3p3="vyhotovenej";
$textc1s3p4="fakt˙ry";
$textc1s4p1="Rozdiel z·kladu";
$textc1s4p2="dane v eur·ch";
$textc1s5p1="Rozdiel sumy";
$textc1s5p2="dane v eur·ch";
$textc1s6p1="Sadzba";
$textc1s6p2="dane";
$textc1s6p3="%";
$textc1s7p1="»Ìseln˝ kÛd tovaru podæa";
$textc1s7p2="SpoloËnÈho colnÈho sadzobnÌka";
$textc1s7p3="[len tovar podæa ß 69 ods. 12";
$textc1s7p4="pÌsm. f) a g) z·kona]";
$textc1s8p1="Druh tovaru";
$textc1s8p2="[len tovar podæa";
$textc1s8p3="ß 69 ods. 12 pÌsm.";
$textc1s8p4="h) a i) z·kona]";
$textc1s9p1="Rozdiel mnoûstva";
$textc1s9p2="tovaru [tovar podæa";
$textc1s9p3="ß 69 ods. 12 pÌsm.";
$textc1s9p4="f) aû i) z·kona]";
$textc1s10="Mern· jednotka";
$textc1s11p1="KÛd opravy";
$textc1s11p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4,"C. $textc","$rmc1",1,"L");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->MultiCell(277,4,"C.1. $textc1","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(30,3.5," ","LT",0,"C");$pdf->Cell(24,3.5," ","LT",0,"C");$pdf->Cell(24,3.5,"$textc1s3p1","LT",0,"C");$pdf->Cell(23,3.5," ","LT",0,"C");
$pdf->Cell(23,3.5," ","LT",0,"C");$pdf->Cell(12,3.5," ","LT",0,"C");$pdf->Cell(44,3.5,"$textc1s7p1","LT",0,"C");$pdf->Cell(27,3.5,"$textc1s8p1","LT",0,"C");
$pdf->Cell(28,3.5,"$textc1s9p1","LT",0,"C");$pdf->Cell(22,3.5," ","LT",0,"C");$pdf->Cell(20,3.5," ","LTR",1,"C");
$pdf->Cell(30,3.5,"$textc1s1p1","L",0,"C");$pdf->Cell(24,3.5,"$textc1s2p1","L",0,"C");$pdf->Cell(24,3.5,"$textc1s3p2","L",0,"C");$pdf->Cell(23,3.5,"$textc1s4p1","L",0,"C");
$pdf->Cell(23,3.5,"$textc1s5p1","L",0,"C");$pdf->Cell(12,3.5,"$textc1s6p1","L",0,"C");$pdf->Cell(44,3.5,"$textc1s7p2","L",0,"C");$pdf->Cell(27,3.5,"$textc1s8p2","L",0,"C");
$pdf->Cell(28,3.5,"$textc1s9p2","L",0,"C");$pdf->Cell(22,3.5," ","L",0,"C");$pdf->Cell(20,3.5,"$textc1s11p1","LR",1,"C");
$pdf->Cell(30,3.5,"$textc1s1p2","L",0,"C");$pdf->Cell(24,3.5,"$textc1s2p2","L",0,"C");$pdf->Cell(24,3.5,"$textc1s3p3","L",0,"C");$pdf->Cell(23,3.5,"$textc1s4p2","L",0,"C");
$pdf->Cell(23,3.5,"$textc1s5p2","L",0,"C");$pdf->Cell(12,3.5,"$textc1s6p2","L",0,"C");$pdf->Cell(44,3.5,"$textc1s7p3","L",0,"C");$pdf->Cell(27,3.5,"$textc1s8p3","L",0,"C");
$pdf->Cell(28,3.5,"$textc1s9p3","L",0,"C");$pdf->Cell(22,3.5,"$textc1s10","L",0,"C");$pdf->Cell(20,3.5,"$textc1s11p2","LR",1,"C");
$pdf->Cell(30,3.5,"$textc1s1p3","L",0,"C");$pdf->Cell(24,3.5,"$textc1s2p3","L",0,"C");$pdf->Cell(24,3.5,"$textc1s3p4","L",0,"C");$pdf->Cell(23,3.5," ","L",0,"C");
$pdf->Cell(23,3.5,"","L",0,"C");$pdf->Cell(12,3.5,"$textc1s6p3","L",0,"C");$pdf->Cell(44,3.5,"$textc1s7p4","L",0,"C");$pdf->Cell(27,3.5,"$textc1s8p4","L",0,"C");
$pdf->Cell(28,3.5,"$textc1s9p4","L",0,"C");$pdf->Cell(22,3.5," ","L",0,"C");$pdf->Cell(20,3.5," ","LR",1,"C");
$pdf->Cell(30,4,"1","$rmc1",0,"C",true);$pdf->Cell(24,4,"2","$rmc1",0,"C",true);$pdf->Cell(24,4,"3","$rmc1",0,"C",true);$pdf->Cell(23,4,"4","$rmc1",0,"C",true);
$pdf->Cell(23,4,"5","$rmc1",0,"C",true);$pdf->Cell(12,4,"6","$rmc1",0,"C",true);$pdf->Cell(44,4,"7","$rmc1",0,"C",true);$pdf->Cell(27,4,"8","$rmc1",0,"C",true);
$pdf->Cell(28,4,"9","$rmc1",0,"C",true);$pdf->Cell(22,4,"10","$rmc1",0,"C",true);$pdf->Cell(20,4,"11","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "C2" ) {
$textc2="⁄daje z prijatej opravnej fakt˙ry";
$textc2s1p1="IdentifikaËnÈ ËÌslo";
$textc2s1p2="pre daÚ dod·vateæa";
$textc2s2p1="PoradovÈ ËÌslo";
$textc2s2p2="opravnej fakt˙ry";
$textc2s3p1="PoradovÈ ËÌslo";
$textc2s3p2="pÙvodnej prijatej";
$textc2s3p3="fakt˙ry";
$textc2s4p1="Rozdiel z·kladu dane";
$textc2s4p2="v eur·ch";
$textc2s5p1="Rozdiel sumy dane";
$textc2s5p2="v eur·ch";
$textc2s6p1="Sadzba dane";
$textc2s6p2="%";
$textc2s7p1="Rozdiel v sume";
$textc2s7p2="odpoËÌtanej dane";
$textc2s7p3="v eur·ch";
$textc2s8p1="KÛd opravy";
$textc2s8p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4.5," ","$rmc",1,"L");
$pdf->MultiCell(277,4,"C.2. $textc2","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7,"$textc2s3p1","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");
$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7," ","LT",0,"C");$pdf->Cell(35,4.7,"$textc2s7p1","LT",0,"C");$pdf->Cell(32,4.7," ","LTR",1,"C");
$pdf->Cell(35,4.6,"$textc2s1p1","L",0,"C");$pdf->Cell(35,4.6,"$textc2s2p1","L",0,"C");$pdf->Cell(35,4.6,"$textc2s3p2","L",0,"C");$pdf->Cell(35,4.6,"$textc2s4p1","L",0,"C");
$pdf->Cell(35,4.6,"$textc2s5p1","L",0,"C");$pdf->Cell(35,4.6,"$textc2s6p1","L",0,"C");$pdf->Cell(35,4.6,"$textc2s7p2","L",0,"C");$pdf->Cell(32,4.6,"$textc2s8p1","LR",1,"C");
$pdf->Cell(35,4.7,"$textc2s1p2","L",0,"C");$pdf->Cell(35,4.7,"$textc2s2p2","L",0,"C");$pdf->Cell(35,4.7,"$textc2s3p3","L",0,"C");$pdf->Cell(35,4.7,"$textc2s4p2","L",0,"C");
$pdf->Cell(35,4.7,"$textc2s5p2","L",0,"C");$pdf->Cell(35,4.7,"$textc2s6p2","L",0,"C");$pdf->Cell(35,4.7,"$textc2s7p3","L",0,"C");$pdf->Cell(32,4.7,"$textc2s8p2","LR",1,"C");
$pdf->Cell(35,4,"1","$rmc1",0,"C",true);$pdf->Cell(35,4,"2","$rmc1",0,"C",true);$pdf->Cell(35,4,"3","$rmc1",0,"C",true);$pdf->Cell(35,4,"4","$rmc1",0,"C",true);
$pdf->Cell(35,4,"5","$rmc1",0,"C",true);$pdf->Cell(35,4,"6","$rmc1",0,"C",true);$pdf->Cell(35,4,"7","$rmc1",0,"C",true);$pdf->Cell(32,4,"8","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "D1" ) {
$textd="⁄daje o dodanÌ tovarov a sluûieb in˝ch ako uveden˝ch v Ëasti A., z ktor˝ch je platiteæ dane osobou povinnou platiù daÚ";
$textd1="⁄daje o obratoch evidovan˝ch vöetk˝mi elektronick˝mi registraËn˝mi pokladnicami";
$textd1s1p1="Celkov· suma obratov v eur·ch";
$textd1s1p2="evidovan˝ch vöetk˝mi";
$textd1s1p3="elektronick˝mi registraËn˝mi";
$textd1s1p4="pokladnicami";
$textd1s2p1="Celkov· suma z·kladov dane";
$textd1s2p2="vr·tane opr·v v eur·ch";
$textd1s2p3="(z·kladn· sadzba)";
$textd1s3p1="Celkov· suma dane v eur·ch";
$textd1s3p2="(z·kladn· sadzba)";
$textd1s4p1="Celkov· suma z·kladov dane";
$textd1s4p2="vr·tane opr·v v eur·ch";
$textd1s4p3="(znÌûen· sadzba)";
$textd1s5p1="Celkov· suma dane v eur·ch";
$textd1s5p2="(znÌûen· sadzba)";
$textd1s6p1="KÛd opravy";
$textd1s6p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4,"D. $textd","$rmc1",1,"L");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->MultiCell(277,4,"D.1. $textd1","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(51,3.5,"$textd1s1p1","LT",0,"C");$pdf->Cell(46,3.5," ","LT",0,"C");$pdf->Cell(46,3.5," ","LT",0,"C");$pdf->Cell(46,3.5," ","LT",0,"C");
$pdf->Cell(46,3.5," ","LT",0,"C");$pdf->Cell(42,3.5," ","LTR",1,"C");
$pdf->Cell(51,3.5,"$textd1s1p2","L",0,"C");$pdf->Cell(46,3.5,"$textd1s2p1","L",0,"C");$pdf->Cell(46,3.5,"$textd1s3p1","L",0,"C");$pdf->Cell(46,3.5,"$textd1s4p1","L",0,"C");
$pdf->Cell(46,3.5,"$textd1s5p1","L",0,"C");$pdf->Cell(42,3.5,"$textd1s6p1","LR",1,"C");
$pdf->Cell(51,3.5,"$textd1s1p3","L",0,"C");$pdf->Cell(46,3.5,"$textd1s2p2","L",0,"C");$pdf->Cell(46,3.5,"$textd1s3p2","L",0,"C");$pdf->Cell(46,3.5,"$textd1s4p2","L",0,"C");
$pdf->Cell(46,3.5,"$textd1s5p2","L",0,"C");$pdf->Cell(42,3.5,"$textd1s6p2","LR",1,"C");
$pdf->Cell(51,3.5,"$textd1s1p4","L",0,"C");$pdf->Cell(46,3.5," ","L",0,"C");$pdf->Cell(46,3.5,"$textd1s3p3","L",0,"C");$pdf->Cell(46,3.5," ","L",0,"C");
$pdf->Cell(46,3.5," ","L",0,"C");$pdf->Cell(42,3.5," ","LR",1,"C");
$pdf->Cell(51,4,"1","$rmc1",0,"C",true);$pdf->Cell(46,4,"2","$rmc1",0,"C",true);$pdf->Cell(46,4,"3","$rmc1",0,"C",true);$pdf->Cell(46,4,"4","$rmc1",0,"C",true);
$pdf->Cell(46,4,"5","$rmc1",0,"C",true);$pdf->Cell(42,4,"6","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }

if ( $hlavicka->kvodd == "D2" ) {
$textd2="⁄daje o dodanÌ tovarov a sluûieb, ktorÈ sa neeviduj˙ elektronickou registraËnou pokladnicou";
$textd2s1p1="Celkov· suma z·kladov dane vr·tane";
$textd2s1p2="opr·v v eur·ch";
$textd2s1p3="(z·kladn· sadzba)";
$textd2s2p1="Celkov· suma dane v eur·ch";
$textd2s2p2="(z·kladn· sadzba)";
$textd2s3p1="Celkov· suma z·kladov dane vr·tane";
$textd2s3p2="opr·v v eur·ch";
$textd2s3p3="(znÌûen· sadzba)";
$textd2s4p1="Celkov· suma dane v eur·ch";
$textd2s4p2="(znÌûen· sadzba)";
$textd2s5p1="KÛd opravy";
$textd2s5p2="(ËÌslo dokladu)";
$pdf->SetY(6);
$pdf->Cell(277,4.5," ","$rmc",1,"L");
$pdf->MultiCell(277,4,"D.2. $textd2","$rmc1",1,"C");
$pdf->Cell(190,0.5,"     ","$rmc",1,"L");
$pdf->Cell(56,4.7,"$textd2s1p1","LT",0,"C");$pdf->Cell(56,4.7," ","LT",0,"C");$pdf->Cell(56,4.7,"$textd2s3p1","LT",0,"C");$pdf->Cell(56,4.7," ","LT",0,"C");
$pdf->Cell(53,4.7," ","LTR",1,"C");
$pdf->Cell(56,4.6,"$textd2s1p2","L",0,"C");$pdf->Cell(56,4.6,"$textd2s2p1","L",0,"C");$pdf->Cell(56,4.6,"$textd2s3p2","L",0,"C");$pdf->Cell(56,4.6,"$textd2s4p1","L",0,"C");
$pdf->Cell(53,4.6,"$textd2s5p1","LR",1,"C");
$pdf->Cell(56,4.7,"$textd2s1p3","L",0,"C");$pdf->Cell(56,4.7,"$textd2s2p2","L",0,"C");$pdf->Cell(56,4.7,"$textd2s3p3","L",0,"C");$pdf->Cell(56,4.7,"$textd2s4p2","L",0,"C");
$pdf->Cell(53,4.7,"$textd2s5p2","LR",1,"C");
$pdf->Cell(56,4,"1","$rmc1",0,"C",true);$pdf->Cell(56,4,"2","$rmc1",0,"C",true);$pdf->Cell(56,4,"3","$rmc1",0,"C",true);$pdf->Cell(56,4,"4","$rmc1",0,"C",true);
$pdf->Cell(53,4,"5","$rmc1",1,"C",true);
$pdf->Cell(190,0.5,"     ","0",1,"L");
                                }
}
//koniec hlavicka j=0

  list ($rok, $mes, $den) = split ('[-]', $hlavicka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->daz, 3);
  $rok=$rok-2000;
  $dazsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

$icdtlac=$hlavicka->kvicd;

//telo sekcii
if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "A1" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(32,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(40,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(40,4,"$dazsk","$rmc",0,"C");
$pdf->Cell(38,4,"$hlavicka->kvzdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(38,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(40,4,"$hlavicka->kvszd","$rmc",0,"C");
$pdf->Cell(37,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "A1" ) {
$rmc="TB";
$pdf->Cell(8,4," ","0",0,"R");$pdf->Cell(152,4,"SPOLU DPH","$rmc",0,"R");$pdf->Cell(38,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"R");
$dpha1=$hlavicka->kvodn;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "A2" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(23,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(31,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(27,4,"$dazsk","$rmc",0,"C");
$pdf->Cell(29,4,"$hlavicka->kvzkl","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(46,4,"$hlavicka->kvkodt","$rmc",0,"C");
$pdf->Cell(31,4,"$hlavicka->kvdtov","$rmc",0,"C");
$pdf->Cell(29,4,"$hlavicka->kvmnot","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(25,4,"$hlavicka->kvmerj","$rmc",0,"C");
$pdf->Cell(24,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "B1" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(27,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(35,4,"$dazsk","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvzdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(33,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvszd","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(32,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "B1" ) {
$rmc="TB";
$pdf->Cell(8,4," ","0",0,"R");$pdf->Cell(202,4,"SPOLU DPH","$rmc",0,"R");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"L");
$dphb1=$hlavicka->kvodn;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "B2" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(27,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(35,4,"$dazsk","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvzdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(33,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvszd","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(32,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "B2" ) {
$rmc="TB";
$pdf->Cell(8,4," ","0",0,"R");$pdf->Cell(202,4,"SPOLU DPH","$rmc",0,"R");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"L");
$dphb2=$hlavicka->kvodn;
$pdf->Cell(0,4," ","0",1,"R");
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "B3" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(62,4,"$hlavicka->kvzdn","$rmc",0,"R");
$pdf->Cell(68,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(68,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(67,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "B3" ) {
$rmc="TB";
$pdf->Cell(22,4,"SPOLU do XML","$rmc",0,"L");$pdf->Cell(48,4,"$hlavicka->kvzdn","$rmc",0,"R");
$pdf->Cell(68,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(68,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"L");
$dphb3=$hlavicka->kvodn;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "C1" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(22,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(24,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(24,4,"$hlavicka->kvpvf","$rmc",0,"C");
$kvmerj=trim($hlavicka->kvmerj);
if ( $kvmerj == "" ) { $pdf->Cell(23,4,"$hlavicka->kvzdn","$rmc",0,"R"); }
if ( $kvmerj != "" ) { $pdf->Cell(23,4,"$hlavicka->kvzkl","$rmc",0,"R"); }
$pdf->Cell(23,4,"$hlavicka->kvsdn","$rmc",0,"R");
$pdf->Cell(12,4,"$hlavicka->kvszd","$rmc",0,"C");
$pdf->Cell(44,4,"$hlavicka->kvkodt","$rmc",0,"C");
$pdf->Cell(27,4,"$hlavicka->kvdtov","$rmc",0,"C");
$pdf->Cell(26,4,"$hlavicka->kvmnot","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(22,4,"$hlavicka->kvmerj","$rmc",0,"C");
$pdf->Cell(20,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "C1" ) {
$rmc="TB";
$pdf->Cell(8,4," ","0",0,"R");$pdf->Cell(93,4,"SPOLU DPH","$rmc",0,"R");
$pdf->Cell(23,4,"$hlavicka->kvsdn","$rmc",0,"R");
$dphc1=$hlavicka->kvsdn;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "C2" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(27,4,"$hlavicka->kvicd","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvfak","$rmc",0,"C");
$pdf->Cell(35,4,"$hlavicka->kvpvf","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvzdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(33,4,"$hlavicka->kvsdn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(35,4,"$hlavicka->kvszd","$rmc",0,"C");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"L");
$pdf->Cell(32,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "C2" ) {
$rmc="TB";
$pdf->Cell(8,4," ","0",0,"R");$pdf->Cell(202,4,"SPOLU DPH","$rmc",0,"R");
$pdf->Cell(33,4,"$hlavicka->kvodn","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"L");
$dphc2=$hlavicka->kvodn;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "D1" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(43,4,"$hlavicka->kvcobr","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvzdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvsdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvzdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvsdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(42,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "D1" ) {
$rmc="TB";
$pdf->Cell(22,4,"SPOLU do XML","$rmc",0,"L");$pdf->Cell(29,4,"$hlavicka->kvcobr","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvzdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvsdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvzdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(44,4,"$hlavicka->kvsdn10","$rmc",0,"R");$pdf->Cell(2,4," ","0",0,"R");
$dphd1s20=$hlavicka->kvsdn20;
$dphd1s10=$hlavicka->kvsdn10;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }

if ( $hlavicka->psys < 30 AND $hlavicka->kvodd == "D2" ) {
$pdf->Cell(8,4,"$hlavicka->kvodd","$rmc",0,"L");$pdf->Cell(48,4,"$hlavicka->kvzdn20","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvsdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvzdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvsdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(53,4,"$hlavicka->dok","$rmc",1,"C");
                                                         }

if ( $hlavicka->psys == 30 AND $hlavicka->kvodd == "D2" ) {
$rmc="TB";
$pdf->Cell(22,4,"SPOLU do XML","$rmc",0,"L");$pdf->Cell(34,4,"$hlavicka->kvzdn20","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvsdn20","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvzdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$rmc",0,"R");
$pdf->Cell(54,4,"$hlavicka->kvsdn10","$rmc",0,"R");$pdf->Cell(2,4," ","$0",0,"R");
$dphd2s20=$hlavicka->kvsdn20;
$dphd2s10=$hlavicka->kvsdn10;
$pdf->Cell(0,4," ","0",1,"R"); //dopyt, Ëo je toto
$rmc=0;
                                                          }
}
$i = $i + 1;
if ( $hlavicka->psys != 30 ) { $j = $j + 1; }
if ( $hlavicka->psys == 30 ) { $j = 0; }
if ( $j > 37 ) { $j=0; }
  }
//koniec while

//sumar sekcii
$spoludph= $dpha1-$dphb2-$dphb3+$dphc1-$dphc2+$dphd1s20+$dphd1s10+$dphd2s20+$dphd2s10;
$pdf->Cell(190,4," ","0",1,"R");
$pdf->Cell(20,4,"Spolu DPH","0",0,"L");$pdf->Cell(30,4,"A1","0",0,"L");$pdf->Cell(40,4,"$dpha1","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"B1 samozdanenie +/-","0",0,"L");$pdf->Cell(40,4,"$dphb1","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"B2","0",0,"L");$pdf->Cell(40,4,"$dphb2","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"B3","0",0,"L");$pdf->Cell(40,4,"$dphb3","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"C1","0",0,"L");$pdf->Cell(40,4,"$dphc1","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"C2","0",0,"L");$pdf->Cell(40,4,"$dphc2","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"D1 $fir_dph2 %","0",0,"L");$pdf->Cell(40,4,"$dphd1s20","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"D1 $fir_dph1 %","0",0,"L");$pdf->Cell(40,4,"$dphd1s10","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"D2 $fir_dph2 %","0",0,"L");$pdf->Cell(40,4,"$dphd2s20","0",1,"R");
$pdf->Cell(20,4,"         ","0",0,"L");$pdf->Cell(30,4,"D2 $fir_dph1 %","0",0,"L");$pdf->Cell(40,4,"$dphd2s10","0",1,"R");
$pdf->Cell(50,4,"DPH","1",0,"L");$pdf->Cell(40,4,"$spoludph","1",1,"R");

if ( $copern == 20 )
{
$pdf->Output("../tmp/kontroldph$kli_vume.$kli_uzid.pdf");

//otvor priznanie
if ( $zandroidu == 0 OR $pdfand == 1 ) { ?>
<script type="text/javascript">
  var okno = window.open("../tmp/kontroldph<?php echo $kli_vume; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php                                  }
}
//koniec ak $xmlko == 0
}

//vytvor xml
if ( $xmlko == 1 AND $control == 0 )
{
$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;
$nazsub="KV_DPH_".$kli_vrok."_".$cislo_ume."_id".$idx.".xml";
if( $cislo_stvrt > 0 ) { $nazsub="KV_DPH_".$kli_vrok."_stvrtrok_".$cislo_stvrt."_id".$idx.".xml";  }

if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");

$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<KVDPH xmlns="https://ekr.financnasprava.sk/Formulare/XSD/kv_dph_2014.xsd">
<Identifikacia>
<IcDphPlatitela>SK3333333333</IcDphPlatitela>
<Druh>R</Druh>
<Obdobie>
<Rok>2014</Rok>
<Mesiac>1</Mesiac>
</Obdobie>
<Nazov>Firma XY, S.R.O.</Nazov>
<Stat>Slovensko</Stat>
<Obec>Koöice</Obec>
<PSC>04011</PSC>
<Ulica>PlzeÚsk·</Ulica>
<Cislo>100</Cislo>
<Tel>055/123456</Tel>
<Email></Email>
</Identifikacia>
<Transakcie>
<A1 Odb="SK1234567890" F="1400785" Den="2014-01-17" Z="826786.49" D="165357.30" S="20"/>
<A1 Odb="SK1234567890" F="1400785" Den="2014-01-17" Z="131027.96" D="13102.80" S="10"/>
<A1 F="1404389" Den="2014-01-12" Z="967674.15" D="193534.83" S="20"/>
<A1 Odb="SK2222222222" F="1402495" Den="2014-01-20" Z="839841.29" D="167968.26" S="20"/>
<A2 Odb="SK4444444444" F="4360/2014" Den="2014-01-28" Z="281370.07" TK="7201" Mn="597.67" MJ="t"/>
<A2 Odb="SK4444444444" F="4360/2014" Den="2014-01-28" Z="5478.50" TK="7202" Mn="72.30" MJ="t"/>
<A2 Odb="SK4545454545" F="782/2014" Den="2014-01-04" Z="8278.61" TD="IO" Mn="27" MJ="ks"/>
<B1 Dod="SK5555555555" F="25/2014" Den="2014-01-16" Z="9098.26" D="1819.65" S="20" O="1819.65"/>
<B1 Dod="CZ1212121212" F="2297/2014" Den="2014-01-08" Z="1444.39" D="288.88" S="20" O="288.88"/>
<B1 F="1030/2014" Den="2014-01-22" Z="925031.35" D="185006.27" S="20" O="68535.89"/>
<B2 Dod="SK6666666666" F="14-19" Den="2014-01-04" Z="784512.96" D="156902.59" S="20" O="12853.22"/>
<B2 Dod="SK2222222222" F="14-19" Den="2014-01-04" Z="912190.15" D="91219.02" S="10" O="29949.28"/>
<B2 Dod="SK7777777777" F="1403816" Den="2014-01-26" Z="639619.16" D="63961.92" S="10" O="63961.92"/>
<B2 Dod="SK7777777777" F="1403816" Den="2014-01-26" Z="637470.05" D="127494.01" S="20" O="0.00"/>
<B3 Z="88664.96" D="17732.99" O="1000.00"/>
<C1 FO="1401967" FP="1745/2014" ZR="45050.44" DR="9010.09" S="20"/>
<C1 FO="1401737" FP="850/2014" ZR="25689.22" DR="5137.84" S="20"/>
<C1 FO="1401737" FP="850/2014" ZR="26162.74" DR="2616.27" S="10"/>
<C1 FO="2663/2014" FP="1402070" ZR="37321.94" DR="7464.39" S="20"/>
<C1 Odb="SK8888888888" FO="4525/2014" FP="1401183" ZR="489763.12" TK="7226" Mn="5537.93" MJ="kg"/>
<C2 Dod="SK8787878787" FO="1401783" FP="2060/2014" ZR="115977.43" DR="23195.49" S="20" OR="0.00"/>
<C2 Dod="SK7575757575" FO="1402573" FP="3322/2014" ZR="130620.90" DR="13062.09" S="10" OR="0.00"/>
<C2 Dod="SK7575757575" FO="1402573" FP="3322/2014" ZR="343031.55" DR="68606.31" S="20" OR="0.00"/>
<D1 SumaObratov="416457.90" Z="145950.27" D="29190.05" ZZn="219379.62" DZn="21937.96"/>
<D2 Z="548639.02" D="109727.80" ZZn="504904.42" DZn="50490.44"/>
</Transakcie>
</KVDPH>
);
mzdprc;

//zaverecne upravy pred archom
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvfak=REPLACE(kvfak, ' ', '') WHERE kvfak != '' ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvpvf=REPLACE(kvpvf, ' ', '') WHERE kvpvf != '' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvdic='', kvicd='', kvfak=''  WHERE kvodd = 'B3' OR kvodd = 'D1' OR kvodd = 'D2' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvpvf='' WHERE kvodd != 'C1' AND kvodd != 'C2' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvkodt='', kvdtov='', kvmnot=0, kvmerj='' WHERE kvodd != 'A2' AND kvodd != 'C1' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvzdn10=0, kvsdn10=0, kvzdn20=0, kvsdn20=0 WHERE kvodd != 'D1' AND kvodd != 'D2' ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET kvcobr=0 WHERE kvodd != 'D1' ";
$oznac = mysql_query("$sqtoz");

//kvdic	cpid	er1	kvodd	kvicd	kvfak	kvpvf	kvsdn	kvszd	kvzdn	kvzkl	kvodn	kvkodt	kvdtov	kvmnot	kvmerj	kvcobr


//tuto uloz do archivkvdph
if( $dodatmanualxml == 0 ) 
   {
$dsqlt = "CREATE TABLE F$kli_vxcf"."_archivdphkvdph SELECT * FROM F$kli_vxcf"."_prcprizdphst$kli_uzid ";
$oznac = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_archivdphkvdph WHERE cpid = $cislo_cpid ";
$oznac = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_archivdphkvdph SELECT * FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE er4 = 9 ";
$oznac = mysql_query("$dsqlt");

//ak dodatocny a cislo_cpop > 0 odpocitaj minule
//echo " druh ".$cislo_druh." cpop ".$cislo_cpop;
$ajkopr=0;
if( $cislo_druh == 3 AND $cislo_cpop > 0 ) { $ajkopr=1; }
if( $cislo_druh == 3 AND $cislo_cpop > 0 )
{
//KOpr="1" zrus povodny riadok
//KOpr="2" daj novy riadok
$sqtoz = "DROP TABLE F$kli_vxcf"."_prcprizdphsp$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcprizdphsp$kli_uzid SELECT * FROM F$kli_vxcf"."_archivdphkvdph WHERE cpid = $cislo_cpop ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE er4 != 9 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=2 ";
$oznac = mysql_query("$sqtoz");

//kvdic	cpid	er1	kvodd	kvicd	kvfak	kvpvf	kvsdn	kvszd	kvzdn	kvzkl	kvodn	kvkodt	kvdtov	kvmnot	kvmerj	kvcobr

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid,F$kli_vxcf"."_prcprizdphsp$kli_uzid ".
" SET F$kli_vxcf"."_prcprizdphst$kli_uzid.er1=0 ".
" WHERE F$kli_vxcf"."_prcprizdphst$kli_uzid.kvodd=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvodd ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvicd=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvicd ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvfak=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvfak ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvpvf=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvpvf ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvszd=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvszd ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvzdn=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvzdn ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvzkl=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvzkl ".
" AND   F$kli_vxcf"."_prcprizdphst$kli_uzid.kvodn=F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvodn  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsp$kli_uzid SET er1=1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsp$kli_uzid,F$kli_vxcf"."_prcprizdphst$kli_uzid ".
" SET F$kli_vxcf"."_prcprizdphsp$kli_uzid.er1=0 ".
" WHERE F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvodd=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvodd ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvicd=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvicd ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvfak=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvfak ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvpvf=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvpvf ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvszd=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvszd ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvzdn=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvzdn ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvzkl=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvzkl ".
" AND   F$kli_vxcf"."_prcprizdphsp$kli_uzid.kvodn=F$kli_vxcf"."_prcprizdphst$kli_uzid.kvodn  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE er1 != 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT ".
" 0,kvdic,cpid,er1,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,kvzkl,kvodn,kvkodt,kvdtov,kvmnot,kvmerj,kvcobr,er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
" r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,hod,rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,".
" r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,kvzdn10,kvsdn10,kvzdn20,kvsdn20,fic ".
" FROM F$kli_vxcf"."_prcprizdphsp$kli_uzid WHERE F$kli_vxcf"."_prcprizdphsp$kli_uzid.er1 = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcprizdphsp$kli_uzid ";
$oznac = mysql_query("$sqtoz");

//if( $kli_vxcf == 4001 ) { exit; }
}

//koniec ak dodatmanualxml=0
   }
if( $dodatmanualxml == 1 )
   {
$sqtoz = "DROP TABLE F$kli_vxcf"."_prcprizdphst$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT * FROM F$kli_vxcf"."_archivdphkvdph WHERE cpid < 0 ";
$oznac = mysql_query("$sqtoz");

$sqlfir = "SELECT * FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd = 'XXX' ";
$fir_vysledok = mysql_query($sqlfir);
if($fir_vysledok)
{
$fir_riadok=mysql_fetch_object($fir_vysledok);

$ajkopr=1;
$cislo_druh=3;
$cislo_ume = $fir_riadok->ume;
$cislo_stvrt = $fir_riadok->er2;
$xpov = $fir_riadok->er3;
$xdod = $fir_riadok->er4;
$ddosk = SkDatum($fir_riadok->dat);
}

$sqtoz = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT ".
" 0,kvdic,cpid,er1,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,kvzkl,kvodn,kvkodt,kvdtov,kvmnot,kvmerj,kvcobr,er2,er3,9,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
" r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,hod,rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,".
" r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,kvzdn10,kvsdn10,kvzdn20,kvsdn20,fic ".
" FROM F$kli_vxcf"."_archivdphkvdphmanual WHERE kvodd != 'XXX' ";
$oznac = mysql_query("$sqtoz");

   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphst".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphst$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE er4 = 9 ".
" ORDER BY kvodd,dok,kvszd";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<KVDPH xmlns=\"https://ekr.financnasprava.sk/Formulare/XSD/kv_dph_2014.xsd\">"."\r\n"; fwrite($soubor, $text);

  $text = " <Identifikacia>"."\r\n"; fwrite($soubor, $text);
$icd=iconv("CP1250", "UTF-8", $fir_ficd);
$icd=trim($icd);
  $text = "  <IcDphPlatitela><![CDATA[".$icd."]]></IcDphPlatitela>"."\r\n"; fwrite($soubor, $text);
$druh="R";
if ( $cislo_druh == 2 ) { $druh="O"; }
if ( $cislo_druh == 3 ) { $druh="D"; }
  $text = "  <Druh><![CDATA[".$druh."]]></Druh>"."\r\n"; fwrite($soubor, $text);

  $text = "  <Obdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <Rok><![CDATA[".$rok."]]></Rok>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $cislo_ume);
$cislo_vmes=$pole[0];
$cislo_vrok=$pole[1];
$mesiac=$cislo_vmes;
$stvrtrok=$cislo_stvrt;

if( $stvrtrok > 0 ) { $cislo_ume=0; }

  if( $cislo_ume > 0 ) {
  if( $mesiac == 0 ) { $mesiac=""; }
  $text = "   <Mesiac><![CDATA[".$mesiac."]]></Mesiac>"."\r\n"; fwrite($soubor, $text);
                       }
$stvrtrok=$cislo_stvrt;
  if( $cislo_stvrt > 0 ) {
  if( $stvrtrok == 0 ) { $stvrtrok=""; }
  $text = "   <Stvrtrok><![CDATA[".$stvrtrok."]]></Stvrtrok>"."\r\n"; fwrite($soubor, $text);
                         }
  $text = "  </Obdobie>"."\r\n"; fwrite($soubor, $text);

$nazov=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "  <Nazov><![CDATA[".$nazov."]]></Nazov>"."\r\n"; fwrite($soubor, $text);
$stat="Slovensko";
  $text = "  <Stat><![CDATA[".$stat."]]></Stat>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "  <Obec><![CDATA[".$obec."]]></Obec>"."\r\n"; fwrite($soubor, $text);
$psc=$fir_fpsc;
  $text = "  <PSC><![CDATA[".$psc."]]></PSC>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "  <Ulica><![CDATA[".$ulica."]]></Ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$fir_fcdm;
  $text = "  <Cislo><![CDATA[".$cislo."]]></Cislo>"."\r\n"; fwrite($soubor, $text);
$telefon=$fir_ftel;
  $text = "  <Tel><![CDATA[".$telefon."]]></Tel>"."\r\n"; fwrite($soubor, $text);
$email=$fir_fem1;
  $text = "  <Email><![CDATA[".$email."]]></Email>"."\r\n"; fwrite($soubor, $text);
  $text = " </Identifikacia>"."\r\n"; fwrite($soubor, $text);

  $text = " <Transakcie>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0

//<A1 Odb="SK1234567890" F="1400785" Den="2014-01-17" Z="826786.49" D="165357.30" S="20"/>
//<A1 Odb="SK1234567890" F="1400785" Den="2014-01-17" Z="131027.96" D="13102.80" S="10"/>
//<A1 F="1404389" Den="2014-01-12" Z="967674.15" D="193534.83" S="20"/>
//<A1 Odb="SK2222222222" F="1402495" Den="2014-01-20" Z="839841.29" D="167968.26" S="20"/>

$kopr=1*$hlavicka->er1;

$hlavicka->kvicd=iconv("CP1250", "UTF-8", $hlavicka->kvicd);
$hlavicka->kvfak=iconv("CP1250", "UTF-8", $hlavicka->kvfak);

if ( $hlavicka->kvodd == "A1" )
   {
  $text = "  <A1 ";
if ( trim($hlavicka->kvicd) != "" ) { $text = $text." Odb=\"".$hlavicka->kvicd."\" "; }
  $text = $text." F=\"".$hlavicka->kvfak."\" Den=\"".$hlavicka->daz."\" ";
  $text = $text." Z=\"".$hlavicka->kvzdn."\" D=\"".$hlavicka->kvsdn."\" S=\"".$hlavicka->kvszd."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
   }

//<A2 Odb="SK4444444444" F="4360/2014" Den="2014-01-28" Z="281370.07" TK="7201" Mn="597.67" MJ="t"/>
//<A2 Odb="SK4444444444" F="4360/2014" Den="2014-01-28" Z="5478.50" TK="7202" Mn="72.30" MJ="t"/>
//<A2 Odb="SK4545454545" F="782/2014" Den="2014-01-04" Z="8278.61" TD="IO" Mn="27" MJ="ks"/>

if ( $hlavicka->kvodd == "A2" )
   {
  $text = "  <A2 Odb=\"".$hlavicka->kvicd."\" F=\"".$hlavicka->kvfak."\" Den=\"".$hlavicka->daz."\" Z=\"".$hlavicka->kvzkl."\" ";
if ( trim($hlavicka->kvkodt) != "" ) { $text = $text." TK=\"".$hlavicka->kvkodt."\" "; }
if ( trim($hlavicka->kvdtov) != "" ) { $text = $text." TD=\"".$hlavicka->kvdtov."\" "; }

  $text = $text." Mn=\"".$hlavicka->kvmnot."\" MJ=\"".$hlavicka->kvmerj."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
   }

//<B1 Dod="SK5555555555" F="25/2014" Den="2014-01-16" Z="9098.26" D="1819.65" S="20" O="1819.65"/>
//<B1 Dod="CZ1212121212" F="2297/2014" Den="2014-01-08" Z="1444.39" D="288.88" S="20" O="288.88"/>
//<B1 F="1030/2014" Den="2014-01-22" Z="925031.35" D="185006.27" S="20" O="68535.89"/>

if( $hlavicka->kvodd == "B1" )
  {

  $text = "  <B1 ";
if( trim($hlavicka->kvicd) != "" )  { $text = $text." Dod=\"".$hlavicka->kvicd."\" "; }
  $text = $text." F=\"".$hlavicka->kvfak."\" Den=\"".$hlavicka->daz."\" Z=\"".$hlavicka->kvzdn."\" ";
  $text = $text."D=\"".$hlavicka->kvsdn."\" S=\"".$hlavicka->kvszd."\" O=\"".$hlavicka->kvodn."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }

//<B2 Dod="SK6666666666" F="14-19" Den="2014-01-04" Z="784512.96" D="156902.59" S="20" O="12853.22"/>
//<B2 Dod="SK2222222222" F="14-19" Den="2014-01-04" Z="912190.15" D="91219.02" S="10" O="29949.28"/>
//<B2 Dod="SK7777777777" F="1403816" Den="2014-01-26" Z="639619.16" D="63961.92" S="10" O="63961.92"/>
//<B2 Dod="SK7777777777" F="1403816" Den="2014-01-26" Z="637470.05" D="127494.01" S="20" O="0.00"/>

if( $hlavicka->kvodd == "B2" )
  {

  $text = "  <B2 Dod=\"".$hlavicka->kvicd."\" F=\"".$hlavicka->kvfak."\" Den=\"".$hlavicka->daz."\" Z=\"".$hlavicka->kvzdn."\" ";
  $text = $text."D=\"".$hlavicka->kvsdn."\" S=\"".$hlavicka->kvszd."\" O=\"".$hlavicka->kvodn."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }

//<B3 Z="88664.96" D="17732.99" O="1000.00"/>

if( $hlavicka->kvodd == "B3" )
  {

  $text = "  <B3 Z=\"".$hlavicka->kvzdn."\" D=\"".$hlavicka->kvsdn."\" O=\"".$hlavicka->kvodn."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }

//<C1 FO="1401967" FP="1745/2014" ZR="45050.44" DR="9010.09" S="20"/>
//<C1 FO="1401737" FP="850/2014" ZR="25689.22" DR="5137.84" S="20"/>
//<C1 FO="1401737" FP="850/2014" ZR="26162.74" DR="2616.27" S="10"/>
//<C1 FO="2663/2014" FP="1402070" ZR="37321.94" DR="7464.39" S="20"/>
//<C1 Odb="SK8888888888" FO="4525/2014" FP="1401183" ZR="489763.12" TK="7226" Mn="5537.93" MJ="kg"/>

if( $hlavicka->kvodd == "C1" )
  {

  $text = "  <C1 ";
if( trim($hlavicka->kvicd) != "" )  { $text = $text." Odb=\"".$hlavicka->kvicd."\" "; }
  $text = $text." FO=\"".$hlavicka->kvfak."\" FP=\"".$hlavicka->kvpvf."\" ";
if( $hlavicka->kvkodt == "" AND $hlavicka->kvdtov == "" )  { $text = $text."  ZR=\"".$hlavicka->kvzdn."\" DR=\"".$hlavicka->kvsdn."\" S=\"".$hlavicka->kvszd."\" "; }

if( trim($hlavicka->kvkodt) != "" )  { $text = $text." ZR=\"".$hlavicka->kvzkl."\" TK=\"".$hlavicka->kvkodt."\" Mn=\"".$hlavicka->kvmnot."\" MJ=\"".$hlavicka->kvmerj."\" "; }
if( trim($hlavicka->kvdtov) != "" )  { $text = $text." ZR=\"".$hlavicka->kvzkl."\" TD=\"".$hlavicka->kvdtov."\" Mn=\"".$hlavicka->kvmnot."\" MJ=\"".$hlavicka->kvmerj."\" "; }

  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }

//<C2 Dod="SK8787878787" FO="1401783" FP="2060/2014" ZR="115977.43" DR="23195.49" S="20" OR="0.00"/>
//<C2 Dod="SK7575757575" FO="1402573" FP="3322/2014" ZR="130620.90" DR="13062.09" S="10" OR="0.00"/>
//<C2 Dod="SK7575757575" FO="1402573" FP="3322/2014" ZR="343031.55" DR="68606.31" S="20" OR="0.00"/>

if( $hlavicka->kvodd == "C2" )
  {

  $text = "  <C2 Dod=\"".$hlavicka->kvicd."\" FO=\"".$hlavicka->kvfak."\" FP=\"".$hlavicka->kvpvf."\"  ZR=\"".$hlavicka->kvzdn."\" ";
  $text = $text." DR=\"".$hlavicka->kvsdn."\" S=\"".$hlavicka->kvszd."\" OR=\"".$hlavicka->kvodn."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }

  }

//<D1 SumaObratov="416457.90" Z="145950.27" D="29190.05" ZZn="219379.62" DZn="21937.96"/>

if( $hlavicka->kvodd == "D1" )
  {

  $text = "  <D1 SumaObratov=\"".$hlavicka->kvcobr."\" Z=\"".$hlavicka->kvzdn20."\" D=\"".$hlavicka->kvsdn20."\" ZZn=\"".$hlavicka->kvzdn10."\" DZn=\"".$hlavicka->kvsdn10."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }


//<D2 Z="548639.02" D="109727.80" ZZn="504904.42" DZn="50490.44"/>

if( $hlavicka->kvodd == "D2" )
  {

  $text = "  <D2 Z=\"".$hlavicka->kvzdn20."\" D=\"".$hlavicka->kvsdn20."\" ZZn=\"".$hlavicka->kvzdn10."\" DZn=\"".$hlavicka->kvsdn10."\" ";
  if( $ajkopr == 0 ) { $text=$text." />"."\r\n"; fwrite($soubor, $text); }
  if( $ajkopr == 1 ) { $text=$text." KOpr=\"".$kopr."\" />"."\r\n"; fwrite($soubor, $text); }
  }




}
$i = $i + 1;
$j = $j + 1;
  }
  $text = " </Transakcie>"."\r\n"; fwrite($soubor, $text);
  $text = "</KVDPH>"."\r\n"; fwrite($soubor, $text);

fclose($soubor);

$poslidomanual=1*$_REQUEST['poslidomanual'];
if( $poslidomanual == 0 ) {
?>
<br />
<br />
Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a naËÌtajte na www.drsr.sk alebo do aplik·cie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<?php
                          }
if( $poslidomanual == 1 ) {

$sqtoz = "INSERT INTO F$kli_vxcf"."_archivdphkvdphmanual SELECT ".
" 0,kvdic,cpid,er1,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,kvzkl,kvodn,kvkodt,kvdtov,kvmnot,kvmerj,kvcobr,er2,er3,9,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,".
" r01,r02,r03,r04,r05,r06,r07,r08,r09,r10,hod,rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,r11,r12,r13,r14,r15,r16,r17,r18,r19,r20,".
" r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31,r32,r33,r34,r35,r36,r37,r38,kvzdn10,kvsdn10,kvzdn20,kvsdn20,fic ".
" FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE kvodd != '' ";
$oznac = mysql_query("$sqtoz");
?>
<script type="text/javascript">
  var okno = window.open("kontrolnydph2014_manual.php?copern=1&drupoh=1&page=1&typ=PDF&xmlko=0&control=1&rozdiel=0&xume=<?php echo $cislo_ume; ?>&xstv=<?php echo $cislo_stvrt; ?>&xdod=<?php echo $cislo_cpid; ?>&xx=1","_self");
</script>
<?php
                          }


//koniec ak $xmlko == 1 AND $control == 0
}
//kontrola KVDPH
if ( $xmlko == 1 AND $control == 1 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE psys = 30 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=0, fic=0 ";
$oznac = mysql_query("$sqtoz");

//skontroluj icdph 
$sqlttx = "SELECT * FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE ".
" ( kvodd = 'A1' OR kvodd = 'A2' OR kvodd = 'B1'  OR kvodd = 'B2' OR kvodd = 'C1'  OR kvodd = 'C2' ) AND er4 = 9 ORDER BY dok ";
$sqlx = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqlx);

$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix))
{
$hlavickax=mysql_fetch_object($sqlx);

$icdcel=$hlavickax->kvicd;
$icdciss=substr($icdcel,2,15);
$icdcis=1*$icdciss;
$akeico=1*$hlavickax->ico;

$jeicd=0;
$sqlttt = "SELECT * FROM zozicdph01 WHERE xicd = $icdcis ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jeicd=1;
  }
if( $icdcis == 0 AND $icdcel == '' ) { $jeicd=1; }

$overok=0;
if( $jeicd == 0 )
    {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_icorozsirenie WHERE ico = $akeico ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $overok=1*$riaddok->pico1;
  }
if( $overok == 1 ) { $jeicd=1; }
    }

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=1 WHERE cpl = $hlavickax->cpl ";
if( $jeicd == 0 ) { $oznac = mysql_query("$sqtoz"); }

}
$ix = $ix + 1;
  }

//opravna faktura nema povodne cislo
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=2 WHERE ( kvodd = 'C1' OR kvodd = 'C2' ) AND kvpvf = '' ";
$oznac = mysql_query("$sqtoz");

//faktura s prenosom z A2 nema rozpis tovaru
$sqtoz = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT ".
" 0,kvdic,cpid,0,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,SUM(kvzkl),kvodn,kvkodt,kvdtov,kvmnot,kvmerj,kvcobr, ".
" er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,r01,r02,r03,r04,r05,r06, ".
" r07,r08,r09,r10,hod,rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,r11,r12,r13, ".
" r14,r15,r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31, ".
" r32,r33,r34,r35,r36,r37,r38,kvzdn10,kvsdn10,kvzdn20,kvsdn20,1 FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE kvodd = 'A2' GROUP BY dok ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=3, fic=0 WHERE kvodd = 'A2' AND fic = 1 AND kvzkl != kvzdn ";
$oznac = mysql_query("$sqtoz");

//Dodav.fakt˙ra s DPH z oddielu B1,B2, nie je iËDPH
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=4 WHERE ( kvodd = 'B1' OR kvodd = 'B2' ) AND psys = 16 AND kvicd = '' AND er1 = 0 ";
$oznac = mysql_query("$sqtoz");

//odber.faktura nema icdph ani dic presla z A1 do D2
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=5 WHERE kvodd = 'D2' AND kvicd = '' AND kvdic = '' AND psys = 15 ";
$oznac = mysql_query("$sqtoz");

//opravna faktura nema povodne cislo
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=6 WHERE ".
" ( kvodd = 'A1' OR kvodd = 'A2' OR  kvodd = 'B1' OR kvodd = 'B2' OR  kvodd = 'C1' OR kvodd = 'C2') AND kvfak = '' ";
$oznac = mysql_query("$sqtoz");

//opravna faktura je v oddiely A1,A2,B1,B2
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=7 WHERE ( kvodd = 'A1' OR kvodd = 'A2' OR kvodd = 'B1' OR kvodd = 'B2' ) AND ( kvsdn < 0 OR kvzdn < 0 ) ";
$oznac = mysql_query("$sqtoz");

//sebefakturacia ICDPH z ufir = icddp
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=8 WHERE ( kvodd = 'A1' OR kvodd = 'A2' OR kvodd = 'B1'  OR kvodd = 'B2' OR kvodd = 'C1'  OR kvodd = 'C2' ) ".
" AND kvicd != '' AND kvicd = '$fir_ficd' ";
$oznac = mysql_query("$sqtoz");

$dad0101=$kli_vrok."-01-01";
$dad3112=$kli_vrok."-12-31";
//datum dodania ????? mimo rozsah roka
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphst$kli_uzid SET er1=9 WHERE ( kvodd = 'A1' OR kvodd = 'A2' OR kvodd = 'B1'  OR kvodd = 'B2' ) ".
" AND ( daz < '$dad0101' OR daz > '$dad3112' ) ";
$oznac = mysql_query("$sqtoz");

//rozhranie jednotlivych er1
//cpl	kvdic	cpid	er1	kvodd	kvicd	kvfak	kvpvf	kvsdn	kvszd	kvzdn	kvzkl	kvodn	kvkodt	kvdtov	kvmnot	kvmerj	kvcobr	
//er2	er3	er4	zk0	zk1	zk2	dn1	dn2	ume	dat	daz	psys	r01	r02	r03	r04	r05	r06	
//r07	r08	r09	r10	hod	rdp	rdk	xrz	xrd	xsz	ucm	ucd	ico	fak	dok	r11	r12	r13	
//r14	r15	r16	r17	r18	r19	r20	r21	r22	r23	r24	r25	r26	r27	r28	r29	r30	r31	
//r32	r33	r34	r35	r36	r37	r38	kvzdn10	kvsdn10	kvzdn20	kvsdn20	fic

$sqtoz = "INSERT INTO F$kli_vxcf"."_prcprizdphst$kli_uzid SELECT ".
" 0,kvdic,cpid,er1,kvodd,kvicd,kvfak,kvpvf,kvsdn,kvszd,kvzdn,kvzkl,kvodn,kvkodt,kvdtov,kvmnot,kvmerj,kvcobr, ".
" er2,er3,er4,zk0,zk1,zk2,dn1,dn2,ume,dat,daz,psys,r01,r02,r03,r04,r05,r06, ".
" r07,r08,r09,r10,hod,rdp,rdk,xrz,xrd,xsz,ucm,ucd,ico,fak,dok,r11,r12,r13, ".
" r14,r15,r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,r31, ".
" r32,r33,r34,r35,r36,r37,r38,kvzdn10,kvsdn10,kvzdn20,kvsdn20,999 FROM F$kli_vxcf"."_prcprizdphst$kli_uzid WHERE er1 > 0 GROUP BY er1 ";
$oznac = mysql_query("$sqtoz");



$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphst".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphst$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE er1 > 0 ".
" ORDER BY er1,fic,kvodd,dok ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $j == 0 ) {
?>
<table class="vstup" width="100%" >
<tr>
<?php if( $hlavicka->er1 == 1  ) { ?>
<td class="bmenu" colspan="7">Fakt˙ry z oddielu A1,A2,B1,B2,C1,C2 nenaöiel som SK iËDPH</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 2  ) { ?>
<td class="bmenu" colspan="7">Opravn· fakt˙ra z oddielu C1,C2 nem· ËÌslo pÙvodnej fakt˙ry</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 3  ) { ?>
<td class="bmenu" colspan="7">Fakt˙ra s prenosom daÚovej povinnosti z oddielu A2 nem· rozpis tovaru</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 4  ) { ?>
<td class="bmenu" colspan="7">Dodav.fakt˙ra s DPH z oddielu B1,B2, nie je iËDPH !!!</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 5  ) { ?>
<td class="bmenu" colspan="7">Odber.fakt˙ra preöla do oddielu D2, nie je iËDPH ani DI» UPOZORNENIE !!!</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 6  ) { ?>
<td class="bmenu" colspan="7">Fakt˙ra z oddielu A1,A2,B1,B2,C1,C2 nem· ËÌslo fakt˙ry</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 7  ) { ?>
<td class="bmenu" colspan="7">Opravn· fakt˙ra je v oddiely A1,A2,B1,B2</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 8  ) { ?>
<td class="bmenu" colspan="7">Fakt˙ry z oddielu A1,A2,B1,B2,C1,C2 maj˙ Vaöe iËDPH</td>
<?php                            } ?>
<?php if( $hlavicka->er1 == 9  ) { ?>
<td class="bmenu" colspan="7">D·tum dodania pri fakt˙re mimo ˙Ëtovn˝ rok ?!?</td>
<?php                            } ?>
<td class="bmenu" colspan="1" align="right"></td>
</tr>

<tr>
<td class="bmenu" width="5%">Oddiel</td>
<td class="hvstup_zlte" align="right" width="2%"> </td>
<td class="hvstup_zlte" align="right" width="10%">Doklad</td>
<td class="hvstup_zlte" align="right" width="10%">IËDPH</td>
<td class="bmenu" align="right" width="10%">IËo</td>
<td class="bmenu" align="left">Firma</td>
<td class="hvstup_zlte" align="right" width="10%">Z·klad</td>
<td class="hvstup_zlte" align="right" width="10%">DPH</td>
</tr>

<?php
              }
//koniec j=0

if( $hlavicka->fic == 0 ) {
?>
<tr>
<td class="fmenu" ><?php echo $hlavicka->kvodd; ?></td>
<td class="fmenu" align="right">
<?php if( $hlavicka->psys == 15 ) { ?>
<img src='../obr/orig.png' onClick="window.open('../faktury/vstf_u.php?copern=8&drupoh=1&page=1&hladaj_uce=&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $hlavicka->dok; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' );" width=20 height=15 border=0 title="Upraviù z·hlavie odberateæskej fakt˙ry">
<?php                             } ?>
<?php if( $hlavicka->psys == 16 ) { ?>
<img src='../obr/orig.png' onClick="window.open('../faktury/vstf_u.php?copern=8&drupoh=2&page=1&hladaj_uce=&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $hlavicka->dok; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' );" width=20 height=15 border=0 title="Upraviù z·hlavie dod·vateæskej fakt˙ry" >
<?php                             } ?>

</td>
<td class="fmenu" align="right">
<?php echo $hlavicka->dok; ?>

<?php if( $hlavicka->psys == 15 ) { ?>
<img src='../obr/zoznam.png' onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $hlavicka->dok; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' );" width=20 height=15 border=0 title="Upraviù roz˙Ëtovanie odberateæskej fakt˙ry">
<?php                             } ?>
<?php if( $hlavicka->psys == 16 ) { ?>
<img src='../obr/zoznam.png' onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $hlavicka->dok; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' );" width=20 height=15 border=0 title="Upraviù roz˙Ëtovanie dod·vateæskej fakt˙ry" >
<?php                             } ?>

</td>

<td class="fmenu" align="right"><?php echo $hlavicka->kvicd; ?></td>
<td class="fmenu" align="right"><?php echo $hlavicka->ico; ?>
<img src='../obr/uprav.png' onClick="window.open('../cis/cico.php?copern=88&page=1&cislo_ico=<?php echo $hlavicka->ico; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' );" width=20 height=15 border=0 title="Upraviù ËÌselnÌk I»O">

</td>
<td class="fmenu" align="left"><?php echo $hlavicka->nai; ?></td>
<td class="fmenu" align="right"><?php echo $hlavicka->kvzdn; ?></td>
<td class="fmenu" align="right"><?php echo $hlavicka->kvsdn; ?></td>
</tr>


<?php
                          }
//koniec fic=0


}
$i = $i + 1;
$j = $j + 1;
if( $hlavicka->fic == 999 ) {
$j=0;
?>
</table>
<br />
<?php
                          }



  }

}
//koniec ak $xmlko == 1 AND $control == 1

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F$kli_vxcf"."_prcprizdphuh".$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
<?php
if ( $zandroidu == 0 OR $pdfand == 1 )
     {
?>
</BODY>
</HTML>
<?php
     }
?>