<HTML>
<?php

$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {
error_reporting(0);
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }
//$serverx="www.ala.sk/androideshop";

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
$keyf=$poleu[8];

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

$anduct=1*$_REQUEST['anduct'];
if( $anduct == 1 )
  {
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

$cislo_dok = $_REQUEST['cislo_dok'];
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_pokvyd WHERE dok = $cislo_dok ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $_REQUEST['drupoh']=2;
    }
//echo $kli_uzid;
//echo $kli_vxcf;
  }

//CisloSlovom ("1 234 567,890", true, "-", "Muûsk˝") 
include("../funkcie/cislaslovom.php");

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }

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
$cislo_dok = $_REQUEST['cislo_dok'];
$hladaj_dok = $_REQUEST['hladaj_dok'];
$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
$drupoh = $_REQUEST['drupoh'];

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$sql = 'DROP TABLE F'.$kli_vxcf.'_prcudok'.$kli_uzid;
$vysledek = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_prcupoh'.$kli_uzid;
$vysledek = mysql_query("$sql");

$sqlt = <<<pokpri
(
   poxd        INT DEFAULT 0,
   uce         VARCHAR(10) NOT NULL,
   ume         FLOAT(8,4) DEFAULT 0,
   dat         DATE,
   dok         INT(8) DEFAULT 0,
   txp         TEXT,
   txz         TEXT,
   icod        INT(10) DEFAULT 0,
   kto         VARCHAR(80) NOT NULL,
   unkd        VARCHAR(15) NOT NULL,
   poz         VARCHAR(80) NOT NULL,
   zk0         DECIMAL(10,2)  DEFAULT 0,
   zk1         DECIMAL(10,2)  DEFAULT 0,
   zk2         DECIMAL(10,2)  DEFAULT 0,
   dn1         DECIMAL(10,2)  DEFAULT 0,
   dn2         DECIMAL(10,2)  DEFAULT 0,
   sp1         DECIMAL(10,2)  DEFAULT 0,
   sp2         DECIMAL(10,2)  DEFAULT 0,
   hodd         DECIMAL(10,2)  DEFAULT 0,
   zk0u         DECIMAL(10,2)  DEFAULT 0,
   zk1u         DECIMAL(10,2)  DEFAULT 0,
   zk2u         DECIMAL(10,2)  DEFAULT 0,
   dn1u         DECIMAL(10,2)  DEFAULT 0,
   dn2u         DECIMAL(10,2)  DEFAULT 0,
   sp1u         DECIMAL(10,2)  DEFAULT 0,
   sp2u         DECIMAL(10,2)  DEFAULT 0,
   hodu         DECIMAL(10,2)  DEFAULT 0,
   zmend         INT(1) DEFAULT 0,
   menad         VARCHAR(5) NOT NULL,
   kurzd         DECIMAL(10,4) DEFAULT 0,
   hodmd         DECIMAL(10,2) DEFAULT 0,
   idd          INT
);
pokpri;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_prcudok'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

if( $drupoh != 4 ) {

$sqlt = <<<pokpri
(
   pox         INT DEFAULT 0,
   dok         INT(8) DEFAULT 0,
   poh         INT DEFAULT 0,
   cpl         int DEFAULT 0,
   ucm         VARCHAR(10) NOT NULL,
   ucd         VARCHAR(10) NOT NULL,
   rdp         INT(2) DEFAULT 0,
   dph         INT(2) DEFAULT 0,
   hod         DECIMAL(10,2) DEFAULT 0,
   icp         INT(10) DEFAULT 0,
   fak         DECIMAL(10,0) DEFAULT 0,
   pop         VARCHAR(80) NOT NULL,
   str         INT DEFAULT 0,
   zak         INT DEFAULT 0,
   unk         VARCHAR(15) NOT NULL,
   zmen         INT(1) DEFAULT 0,
   mena         VARCHAR(5) NOT NULL,
   kurz         DECIMAL(10,4) DEFAULT 0,
   hodm         DECIMAL(10,2) DEFAULT 0,
   id          INT
);
pokpri;
                   }
if( $drupoh == 4 ) {

$sqlt = <<<pokpri
(
   pox         INT DEFAULT 0,
   dok         INT(8) DEFAULT 0,
   ddu         DATE,
   poh         INT DEFAULT 0,
   cpl         int DEFAULT 0,
   ucm         VARCHAR(10) NOT NULL,
   ucd         VARCHAR(10) NOT NULL,
   rdp         INT(2) DEFAULT 0,
   dph         INT(2) DEFAULT 0,
   hod         DECIMAL(10,2) DEFAULT 0,
   icp         INT(10) DEFAULT 0,
   fak         DECIMAL(10,0) DEFAULT 0,
   pop         VARCHAR(80) NOT NULL,
   str         INT DEFAULT 0,
   zak         INT DEFAULT 0,
   unk         VARCHAR(15) NOT NULL,
   zmen         INT(1) DEFAULT 0,
   mena         VARCHAR(5) NOT NULL,
   kurz         DECIMAL(10,4) DEFAULT 0,
   hodm         DECIMAL(10,2) DEFAULT 0,
   id          INT
);
pokpri;
                   }

$sql = 'CREATE TABLE F'.$kli_vxcf.'_prcupoh'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$podmdok="dok = ".$cislo_dok;
$podmdok1="F$kli_vxcf"."_prcupoh".$kli_uzid.".dok = ".$cislo_dok;
//echo $podmdok;
//exit;

$viacdokladov=0;
$pole = explode("-", $hladaj_dok);
$doklad1=1*$pole[0];
$doklad2=1*$pole[1];
if( $doklad1 > 0 AND $doklad2 > 0 ) 
{
$viacdokladov=1;
$podmdok="dok >= ".$doklad1." AND dok <= ".$doklad2;
$podmdok1="F$kli_vxcf"."_prcupoh".$kli_uzid.".dok >= ".$doklad1." AND F$kli_vxcf"."_prcupoh".$kli_uzid.".dok <= ".$doklad2;
}

$uctpok="uctpok";
if( $rozuct == 'ANO' ) { $uctpok="uctpokuct"; }
if( $drupoh == 4 ) { $uctpok="uctban"; }
if( $drupoh == 5 ) { $uctpok="uctvsdp"; }



//samoopravna tlac zakladov, dph a celkom len DPH 20%
if( $viacdokladov == 0 AND $rozuct == "ANO" AND ( $drupoh == 1 OR $drupoh == 2 ) )
{ 

//echo "rozuct ".$rozuct;
//exit;
//andrej

$podmdph="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE szd = $fir_dph2 ";
$tov = mysql_query("$sqlttt");
$tvpol = mysql_num_rows($tov);
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

if( $i == 0 )
  {
$podmdph=$podmdph." rdp = ".$riadok->rdp;
  }else
  {
$podmdph=$podmdph." OR rdp = ".$riadok->rdp;
  }

}
$i = $i + 1;
  }
if( $podmdph != "" ) { $podmdph=" AND ( ".$podmdph." ) "; }

$zk2=0; $zk1=0; $zk0=0;
if( $drupoh == 1 )
     {
$sqlttt = "SELECT zk0, zk2, zk1, uce FROM F$kli_vxcf"."_pokpri WHERE dok = $cislo_dok ";
     }else
     {
$sqlttt = "SELECT zk0u, zk2u, dn2u, uce FROM F$kli_vxcf"."_pokvyd WHERE dok = $cislo_dok ";
     }
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zk2=1*$riaddok->zk2u;
  $zk0=1*$riaddok->zk0u;
  $dn2=1*$riaddok->dn2u;
  $ucepok=$riaddok->uce;
  }

//echo "idem";
$zaklad0s=0;
if( $drupoh == 1 )
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" AND ( rdp = 0 OR rdp = 1 OR rdp = 10 ) AND ucm = $ucepok GROUP BY dok ";
     }else
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" AND ( rdp = 0 OR rdp = 1 OR rdp = 10 ) AND ucd = $ucepok GROUP BY dok ";
     }
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad0s=1*$riaddok->hod;
  }


$zaklad2s=0;
if( $drupoh == 1 )
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" $podmdph AND LEFT(ucd,3) != 343 AND ucm = $ucepok GROUP BY dok ";
     }else
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" $podmdph AND LEFT(ucm,3) != 343 AND ucd = $ucepok GROUP BY dok ";
     }
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->hod;
  }

$dph2s=0;
if( $drupoh == 1 )
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" $podmdph AND LEFT(ucd,3) = 343 AND ucm = $ucepok GROUP BY dok ";
     }else
     {
$sqlttt = "SELECT SUM(hod) AS hod FROM F$kli_vxcf"."_uctpokuct WHERE dok = $cislo_dok ".
" $podmdph AND LEFT(ucm,3) = 343 AND ucd = $ucepok GROUP BY dok ";
     }
$sqldok = mysql_query("$sqlttt");
//echo $sqlttt;
//exit;
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dph2s=1*$riaddok->hod;
  }

$dph20poh=$zaklad2s+$dph2s+$zaklad0s;
$rozdiel=$zk2+dn2+$zk0-($zaklads2-$dph2s-$zaklad0s);
//echo "dph20poh ".$dph20poh."  rozdiel ".$rozdiel."  podmdph ".$podmdph."<br />";
//exit;

if( $rozdiel != 0 AND $dph20poh != 0 AND $podmdph != "" AND $drupoh == 1 )
 {
$sqlttt = "UPDATE F$kli_vxcf"."_pokpri SET zk2u=($zaklad2s), dn2u=($dph2s), zk0u=($zaklad0s) WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 

$sqlttt = "UPDATE F$kli_vxcf"."_pokpri SET hodu=zk0u+zk1u+zk2u+dn2u+dn1u, sp2u=zk2u+dn2u WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 

$sqlttt = "UPDATE F$kli_vxcf"."_pokpri SET hodu=zk0u+zk1u+zk2u+dn2u+dn1u, zk2=zk2u, dn2=dn2u, hod=hodu, sp2=sp2u WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 
//exit;
 }

if( $rozdiel != 0 AND $dph20poh != 0 AND $podmdph != "" AND $drupoh == 2 )
 {
$sqlttt = "UPDATE F$kli_vxcf"."_pokvyd SET zk2u=($zaklad2s), dn2u=($dph2s), zk0u=($zaklad0s) WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 

$sqlttt = "UPDATE F$kli_vxcf"."_pokvyd SET hodu=zk0u+zk1u+zk2u+dn2u+dn1u, sp2u=zk2u+dn2u WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 

$sqlttt = "UPDATE F$kli_vxcf"."_pokvyd SET hodu=zk0u+zk1u+zk2u+dn2u+dn1u, zk2=zk2u, dn2=dn2u, hod=hodu, sp2=sp2u WHERE dok = $cislo_dok ";
//echo $sqlttt."<br />";
$sqldok = mysql_query("$sqlttt"); 
//exit;
 }




}
//koniec samoopravna tlac zakladov, dph a celkom len DPH 20%



if( $drupoh == 1 )
{
$tabl = "pokpri";
$cisdok = "pokpri";

if( $rozuct == 'ANO' ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0u,zk1u,zk2u,dn1u,dn2u,sp1u,sp2u,hodu,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_pokpri ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");
                       }

if( $rozuct != 'ANO' ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_pokpri ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");
                       }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,dok,poh,cpl,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_$uctpok ".
" WHERE $podmdok AND poh = 1".
"";
$dsql = mysql_query("$dsqlt");

$pocpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ";
$sql = mysql_query("$sqltt");
$pocpol = mysql_num_rows($sql);
if( $pocpol == 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,'$cislo_dok',0,0,'','',0,0,0,0,0,'',0,0,'',0,'',0,0,$kli_uzid FROM F$kli_vxcf"."_pokpri ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");

//exit;
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 8,dok,poh,cpl,ucm,ucd,rdp,dph,hod,icp,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 2 )
{
$tabl = "pokvyd";
$cisdok = "pokvyd";

if( $rozuct == 'ANO' ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0u,zk1u,zk2u,dn1u,dn2u,sp1u,sp2u,hodu,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_pokvyd ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");
                       }

if( $rozuct != 'ANO' ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_pokvyd ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");
                       }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,dok,poh,cpl,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_$uctpok ".
" WHERE $podmdok AND poh = 2".
"";
$dsql = mysql_query("$dsqlt");

$pocpol=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ";
$sql = mysql_query("$sqltt");
$pocpol = mysql_num_rows($sql);
if( $pocpol == 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,'$cislo_dok',0,0,'','',0,0,0,0,0,'',0,0,'',0,'',0,0,$kli_uzid FROM F$kli_vxcf"."_pokvyd ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");

//exit;
}


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 8,dok,poh,cpl,ucm,ucd,rdp,dph,hod,icp,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 3 )
{
$tabl = "doppokpri";
$cisdok = "xdp05";
$uctpok= "uctpok";

//uce  ume  dat  dok  doq  txp  txz  ico  kto  unk  poz  
//zk0  zk1  zk2  zk3  zk4  sz1  sz2  sz3  sz4  dn1  dn2  dn3  dn4  sp1  sp2  sp3  sp4  zk0u  zk1u  zk2u  dn1u  dn2u  sp0u  sp1u  sp2u  hodu  hod  
//id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,0,'',0,0,id FROM F$kli_vxcf"."_doppokpri ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");

//dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,dok,poh,cpl,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,0,'',0,0,id FROM F$kli_vxcf"."_$uctpok ".
" WHERE $podmdok AND poh = 3".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 8,dok,poh,cpl,ucm,ucd,rdp,dph,hod,icp,fak,pop,str,zak,unk,0,'',0,0,id FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 2 )
{
$tabl = "pokvyd";
$cisdok = "pokvyd";
}
if( $drupoh == 4 )
{
$tabl = "banvyp";
$cisdok = "uctx04";
$Odberatel = "V˝pis z ˙Ëtu";
}
if( $drupoh == 5 )
{
$tabl = "uctvsdh";
$cisdok = "uctx05";
$Odberatel = "Firma";
}

$uctpok="uctpok";
if( $rozuct == 'ANO' ) { $uctpok="uctpokuct"; }
if( $drupoh == 4 ) { $uctpok="uctban"; }
if( $drupoh == 5 ) { $uctpok="uctvsdp"; }

if( $drupoh == 4 )
{
$tabl = "banvyp";
$uctpok = "uctban";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0u,zk1u,zk2u,dn1u,dn2u,sp1u,sp2u,hodu,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_banvyp ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,dok,ddu,poh,cpl,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_uctban ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");


$sql = "ALTER TABLE F$kli_vxcf"."_prcupoh".$kli_uzid." ADD debet DECIMAL(10,2) DEFAULT 0 AFTER id";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcupoh".$kli_uzid." ADD kredit DECIMAL(10,2) DEFAULT 0 AFTER id";
$vysledek = mysql_query("$sql");


$dsqlt = "UPDATE F$kli_vxcf"."_prcupoh".$kli_uzid." SET kredit=hod WHERE LEFT(ucm,3) = 221 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcupoh".$kli_uzid." SET debet=hod WHERE LEFT(ucd,3) = 221 ";
$dsql = mysql_query("$dsqlt");

$uce231=0;
$sqldok = mysql_query("SELECT uce FROM F$kli_vxcf"."_banvyp WHERE dok = $cislo_dok");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uce231=1*$riaddok->uce;
  }

$h_uct3 = substr("$uce231", 0, 3);
if( $h_uct3 == 231 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_prcupoh".$kli_uzid." SET kredit=hod WHERE LEFT(ucm,3) = 231 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcupoh".$kli_uzid." SET debet=hod WHERE LEFT(ucd,3) = 231 ";
$dsql = mysql_query("$dsqlt");
  }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 8,dok,ddu,poh,cpl,ucm,ucd,rdp,dph,hod,icp,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id,SUM(kredit),SUM(debet) FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 5 )
{
$tabl = "uctvsdh";
$uctpok = "uctvsdp";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcudok".$kli_uzid.
" SELECT 0,uce,ume,dat,dok,txp,txz,ico,kto,unk,poz,".
"zk0,zk1,zk2,dn1,dn2,sp1,sp2,hod,zk0u,zk1u,zk2u,dn1u,dn2u,sp1u,sp2u,hodu,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_uctvsdh ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 0,dok,poh,cpl,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_uctvsdp ".
" WHERE $podmdok ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcupoh".$kli_uzid.
" SELECT 8,dok,poh,cpl,ucm,ucd,rdp,dph,SUM(hod),icp,fak,pop,str,zak,unk,zmen,mena,kurz,hodm,id FROM F$kli_vxcf"."_prcupoh".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");
}

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>TlaË-PDF</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 0 ) { echo "EuroSecom  -  Doklad <?php echo $cislo_dok;?> PDF form·t"; } ?> 
<?php if( $zandroidu == 1 ) { echo "Doklad PDF prebran˝, tlaËidlo Sp‰ù - do zoznamu dokladov"; } ?> 
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana Ë. &p z &P pata=prazdna
// na vysku okraje vl=15 vp=15 hr=15 dl=15 poloziek 43 

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid."_".$hhmm;

 $outfilexdel="../tmp/udok*_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/udok".$cislo_dok."_".$idx.".pdf";

if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$logoano=0;
$netlacucty=0;
if ( $copern == 20 AND $drupoh < 4 )
{
$sqlttt = "SELECT omd, zdl FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $netlacucty=1*$riaddok->omd;
  $logoano=1*$riaddok->zdl;
  }
}

if ( $copern == 20 AND $drupoh < 4 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcupoh".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_prcudok".$kli_uzid.
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".dok=F$kli_vxcf"."_prcudok".$kli_uzid.".dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcudok".$kli_uzid.".icod=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".id=klienti.id_klienta".
" WHERE $podmdok1 ".
" ORDER BY F$kli_vxcf"."_prcupoh".$kli_uzid.".dok,pox ".
"";

$sql = mysql_query("$sqltt");

//echo $sqltt;
//exit;
}

if ( $copern == 20 AND $drupoh == 4 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcupoh".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_prcudok".$kli_uzid.
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".dok=F$kli_vxcf"."_prcudok".$kli_uzid.".dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".icp=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".id=klienti.id_klienta".
" WHERE $podmdok1 ".
" ORDER BY F$kli_vxcf"."_prcupoh".$kli_uzid.".dok,pox,ddu,cpl ".
"";

//echo $sqltt;
//exit;
$sql = mysql_query("$sqltt");

}


if ( $copern == 20 AND $drupoh > 4 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcupoh".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_prcudok".$kli_uzid.
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".dok=F$kli_vxcf"."_prcudok".$kli_uzid.".dok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".icp=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_prcupoh".$kli_uzid.".id=klienti.id_klienta".
" WHERE $podmdok1 ".
" ORDER BY F$kli_vxcf"."_prcupoh".$kli_uzid.".dok,pox ".
"";

//echo $sqltt;
//exit;
$sql = mysql_query("$sqltt");

}


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i) OR $i == 0 )
{
$riadok=mysql_fetch_object($tov);

$dat_sk=SkDatum($riadok->dat);

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$chcemhlavicku=1;
if( $drupoh == 1 ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickapok.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 2 ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickapok.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 3 ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickapok.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 4 ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaban.nie")) { $chcemhlavicku=0; } } 
if( $drupoh == 5 ) { if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickavse.nie")) { $chcemhlavicku=0; } } 

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') AND $chcemhlavicku == 1 )
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',15,10,180,20);

$pdf->SetY(30);
}

//logo
if( $drupoh < 4 AND $logoano == 1 )
          {

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/poklogo.jpg'))
{
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="180"; $rozmerhlv4="20";

$sirka=0; $vyska=0; $zhora=0; $zlava=0; 
$sqlttt = "SELECT ico1,ico2,ico3,ico4 FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sirka=1*$riaddok->ico1; $vyska=1*$riaddok->ico2; $zlava=1*$riaddok->ico3; $zhora=1*$riaddok->ico4;
  }

if( $sirka > 0 AND $vyska > 0 AND $zhora > 0 AND $zlava > 0 ) { $rozmerhlv1=$zlava+""; $rozmerhlv2=$zhora+""; $rozmerhlv3=$sirka+""; $rozmerhlv4=$vyska+""; }

if( $logoano == 1 ) { $pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/poklogo.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4); }
if( $zhora <= 12 AND $sirka > 100 ) {
$posun=$zhora+$vyska;
$pdf->SetY($posun);
                                    }
}
          }
//koniec logo

$pdf->SetFont('arial','',10);
if ( $drupoh == 1 OR $drupoh == 3 )
{ 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(65,6,"P R Õ J M O V › pokladniËn˝ doklad: ","0",0,"L");$pdf->Cell(20,6,"$riadok->dok ","0",0,"L");$pdf->Cell(5,6,"  ","0",0,"L"); 
$pdf->Cell(45,6,"Zo dÚa: $dat_sk      Pokladnica: $riadok->uce  ","0",1,"L"); 

$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(90,6,"PrÌjemca:","LRTB",0,"L");$pdf->Cell(90,6,"Pl·tca: ","LRTB",1,"L"); 
}
if ( $drupoh == 2 )
{ 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(65,6,"V › D A V K O V › pokladniËn˝ doklad: ","0",0,"L");$pdf->Cell(20,6,"$riadok->dok ","0",0,"L");$pdf->Cell(5,6,"  ","0",0,"L"); 
$pdf->Cell(45,6,"Zo dÚa: $dat_sk      Pokladnica: $riadok->uce  ","0",1,"L"); 

$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(90,6,"Pl·tca:","LRTB",0,"L");$pdf->Cell(90,6,"PrÌjemca:","LRTB",1,"L"); 
}

if ( $drupoh == 4 AND $fir_allx15 != 1 )
{ 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(65,6,"B A N K O V › v˝pis: ","1",0,"L");$pdf->Cell(25,6,"$riadok->dok ","1",0,"L"); 
$pdf->Cell(0,6,"Zo dÚa: $dat_sk      Banka: $riadok->uce  ","1",1,"L"); 

$pdf->Cell(128,5,"⁄Ëel : $riadok->txp","0",0,"L");$pdf->Cell(50,5,"UNIkÛd: $riadok->unkd","0",1,"L");
$pdf->Cell(90,2," ","0",1,"L");

$ucm="UCM";
$ucd="UCD";
$pdf->Cell(0,2," ","B",1,"L");
$pdf->Cell(25,5,"$ucm","1",0,"L");$pdf->Cell(25,5,"$ucd","1",0,"L");$pdf->Cell(15,5,"RDP","1",0,"L");
$pdf->Cell(25,5,"FAK","1",0,"L");$pdf->Cell(25,5,"I»O","1",0,"L");$pdf->Cell(15,5,"STR","1",0,"L");$pdf->Cell(20,5,"Z¡K","1",0,"L");
$pdf->Cell(0,5,"Hodnota    ","1",1,"R");

}

if ( $drupoh == 4 AND $fir_allx15 == 1 )
{ 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(65,6,"B A N K O V › v˝pis: ","1",0,"L");$pdf->Cell(25,6,"$riadok->dok ","1",0,"L"); 
$pdf->Cell(0,6,"Zo dÚa: $dat_sk      Banka: $riadok->uce  ","1",1,"L"); 

$pdf->Cell(128,5,"⁄Ëel : $riadok->txp","0",0,"L");$pdf->Cell(50,5,"UNIkÛd: $riadok->unkd","0",1,"L");
$pdf->Cell(90,2," ","0",1,"L");

$ucm="UCM";
$ucd="UCD";
$pdf->Cell(0,2," ","B",1,"L");
$pdf->Cell(20,5,"D·tum","1",0,"L");$pdf->Cell(20,5,"$ucm","1",0,"L");$pdf->Cell(20,5,"$ucd","1",0,"L");$pdf->Cell(10,5,"RDP","1",0,"L");
$pdf->Cell(25,5,"FAK","1",0,"L");$pdf->Cell(20,5,"I»O","1",0,"L");$pdf->Cell(15,5,"STR","1",0,"L");$pdf->Cell(20,5,"Z¡K","1",0,"L");
$pdf->Cell(0,5,"Hodnota    ","1",1,"R");

}

if ( $drupoh == 5 )
{ 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(65,6,"V ä E O B E C N › intern˝ doklad: ","1",0,"L");$pdf->Cell(25,6,"$riadok->dok ","1",0,"L"); 
$pdf->Cell(0,6,"Zo dÚa: $dat_sk        ","1",1,"L"); 

$pdf->Cell(128,5,"⁄Ëel : $riadok->txp","0",0,"L");$pdf->Cell(50,5,"UNIkÛd: $riadok->unkd","0",1,"L");
$pdf->Cell(90,2," ","0",1,"L");

$ucm="UCM";
$ucd="UCD";
$pdf->Cell(0,2," ","B",1,"L");
$pdf->Cell(25,5,"$ucm","1",0,"L");$pdf->Cell(25,5,"$ucd","1",0,"L");$pdf->Cell(15,5,"RDP","1",0,"L");
$pdf->Cell(25,5,"FAK","1",0,"L");$pdf->Cell(25,5,"I»O","1",0,"L");$pdf->Cell(15,5,"STR","1",0,"L");$pdf->Cell(20,5,"Z¡K","1",0,"L");
$pdf->Cell(0,5,"Hodnota    ","1",1,"R");

}


$pdf->SetFont('arial','',9);

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
{ 
$pdf->Cell(90,5,"I»O: $fir_fico","LR",0,"L");$pdf->Cell(90,5,"I»O: $riadok->icod","LR",1,"L");
$pdf->Cell(90,5,"$fir_fnaz","LR",0,"L");$pdf->Cell(90,5,"$riadok->nai $riadok->na2","LR",1,"L");
$pdf->Cell(90,5,"$fir_fuli $fir_fcdm","LR",0,"L");$pdf->Cell(90,5,"$riadok->uli","LR",1,"L");
$pdf->Cell(90,5,"$fir_fpsc $fir_fmes","LR",0,"L");$pdf->Cell(90,5,"$riadok->psc $riadok->mes","LR",1,"L");
$pdf->Cell(90,3," ","LR",0,"L");$pdf->Cell(90,3," ","LR",1,"L");
$pdf->Cell(90,5,"DI»: $fir_fdic I»DPH: $fir_ficd","LR",0,"L");$pdf->Cell(90,5,"DI»: $riadok->dic I»DPH: $riadok->icd","LR",1,"L");
$pdf->Cell(90,5,"Registrovan˝: $fir_obreg ","LRB",0,"L");

if ( $drupoh == 1 ) { $pdf->Cell(90,5,"PrijatÈ od: $riadok->kto","LRB",1,"L"); }
if ( $drupoh == 2 ) { $pdf->Cell(90,5,"VyplatenÈ komu: $riadok->kto","LRB",1,"L"); }
if ( $drupoh == 3 ) { $pdf->Cell(90,5,"PrijatÈ od: $riadok->kto","LRB",1,"L"); }
$pdf->Cell(90,2," ","0",1,"L");

if ( $riadok->zmend == 1 ) { 

$pdf->Cell(130,5,"Doklad zaplaten˝ v cudzej mene kurz $riadok->kurzd $riadok->menad /1Eur  ","0",0,"L");
$pdf->Cell(50,5,"$riadok->hodmd $riadok->menad ","0",1,"R");
$pdf->Cell(90,2," ","0",1,"L");
                            }


$pdf->Cell(130,5,"⁄Ëel platby: $riadok->txp","0",0,"L");$pdf->Cell(50,5,"UNIkÛd: $riadok->unkd","0",1,"L");
$pdf->Cell(90,2," ","0",1,"L");

$ucm="UCM";
$ucd="UCD";
if( $kli_vduj == 9 AND $drupoh == 2 ) { $ucm="Druh v˝davku"; $ucd="Pokladnica Ë."; } 
if( $kli_vduj == 9 AND $drupoh == 1 ) { $ucd="Druh prÌjmu"; $ucm="Pokladnica Ë."; } 

if ( $netlacucty == 0 ) {
$pdf->Cell(25,5,"$ucm","1",0,"L");$pdf->Cell(25,5,"$ucd","1",0,"L");$pdf->Cell(15,5,"RDP","1",0,"L");
$pdf->Cell(25,5,"FAK","1",0,"L");$pdf->Cell(25,5,"I»O","1",0,"L");$pdf->Cell(15,5,"STR","1",0,"L");$pdf->Cell(20,5,"Z¡K","1",0,"L");
$pdf->Cell(30,5,"Hodnota","1",1,"R");
                        }
}

$new=0;
     }
//koniec hlavicky j=0



if( $riadok->pox == 0 )
{

$pdf->SetFont('arial','',9);

$zostatok=$zostatok+$riadok->zas;
$zostatokeur=$zostatokeur+$riadok->zoseur;

$Cislo=$zostatok+"";
$szostatok=sprintf("%0.3f", $Cislo);
$Cislo=$zostatokeur+"";
$szostatokeur=sprintf("%0.2f", $Cislo);

$prj=$riadok->prj;
if( $riadok->prj == 0 ) $prj="";
$vdj=$riadok->vdj;
if( $riadok->vdj == 0 ) $vdj="";

if( $new == 1 ) { $new=0; }

$ucm=$riadok->ucm;
if( $ucm == 0 ) $ucm="";
$ucd=$riadok->ucd;
if( $ucd == 0 ) $ucd="";

if( $riadok->hod != 0 )
  {

if ( $drupoh != 4 OR $fir_allx15 != 1 )
{
if ( $netlacucty == 0 ) {
$pdf->Cell(25,5,"$ucm","0",0,"L");$pdf->Cell(25,5,"$ucd","0",0,"L");$pdf->Cell(15,5,"$riadok->rdp","0",0,"L");
$pdf->Cell(25,5,"$riadok->fak","0",0,"L");$pdf->Cell(25,5,"$riadok->icp","0",0,"L");$pdf->Cell(15,5,"$riadok->str","0",0,"L");
$pdf->Cell(20,5,"$riadok->zak","0",0,"L");$pdf->Cell(30,5,"$riadok->hod","0",1,"R");

//rozpoctova.klasifikacia
if( $fir_allx14 == 1 )
   {
$rozpkls=0;
$sqlddt = "SELECT uce, crs FROM F$kli_vxcf"."_crf104nuj_no WHERE uce = $ucm OR uce = $ucd ";
$sqldok = mysql_query("$sqlddt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozpkls=1*$riaddok->crs;
  }
if( $rozpkls > 0 ) { $pdf->SetFont('arial','',7); $pdf->Cell(30,2,"RozpoËtov· klasifik·cia $rozpkls","0",1,"L"); $pdf->SetFont('arial','',9);  }
   }
                        }
}
if ( $drupoh == 4 AND $fir_allx15 == 1 )
{
$ddusk=SkDatum($riadok->ddu);
if ( $netlacucty == 0 ) {
$pdf->Cell(20,5,"$ddusk","0",0,"L");$pdf->Cell(20,5,"$ucm","0",0,"L");$pdf->Cell(20,5,"$ucd","0",0,"L");$pdf->Cell(10,5,"$riadok->rdp","0",0,"L");
$pdf->Cell(25,5,"$riadok->fak","0",0,"L");$pdf->Cell(20,5,"$riadok->icp","0",0,"L");$pdf->Cell(15,5,"$riadok->str","0",0,"L");
$pdf->Cell(20,5,"$riadok->zak","0",0,"L");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");
                        }
}
  }

if( $riadok->pop != '' AND ( $drupoh == 5 ) )
  {
$pdf->Cell(0,5,"$riadok->pop","0",1,"L");
  }

}


if( $riadok->pox == 8 )
{
$pdf->SetFont('arial','',9);

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
     { 
$pdf->Cell(90,2," ","0",1,"L");

$pdf->Cell(90,5,"Roz˙Ëtovanie dokladu - Rozpis DPH","LT",0,"L");$pdf->Cell(15,5,"%DPH","T",0,"R");
$pdf->Cell(25,5,"Z·klad","T",0,"R");$pdf->Cell(25,5,"DaÚ","T",0,"R");$pdf->Cell(25,5,"Spolu","RT",1,"R");
if( $riadok->zk0u != 0 ) {
$pdf->Cell(90,5," ","L",0,"L");$pdf->Cell(15,5,"0","0",0,"R");
$pdf->Cell(25,5,"$riadok->zk0u","0",0,"R");$pdf->Cell(25,5," ","0",0,"R");$pdf->Cell(25,5,"$riadok->zk0u","R",1,"R");
                         }
if( $riadok->zk1u != 0 ) {
$pdf->Cell(90,5," ","L",0,"L");$pdf->Cell(15,5,"$fir_dph1","0",0,"R");
$pdf->Cell(25,5,"$riadok->zk1u","0",0,"R");$pdf->Cell(25,5,"$riadok->dn1u","0",0,"R");$pdf->Cell(25,5,"$riadok->sp1u","R",1,"R");
                         }
if( $riadok->zk2u != 0 ) {
$pdf->Cell(90,5," ","L",0,"L");$pdf->Cell(15,5,"$fir_dph2","0",0,"R");
$pdf->Cell(25,5,"$riadok->zk2u","0",0,"R");$pdf->Cell(25,5,"$riadok->dn2u","0",0,"R");$pdf->Cell(25,5,"$riadok->sp2u","R",1,"R");
                         }

$pdf->Cell(180,2," ","LRB",1,"L");
$pdf->Cell(180,2," ","0",1,"L");
     }

if ( $drupoh == 5 )
     { 
$pdf->Cell(90,1," ","0",1,"L");

$pdf->Cell(90,5,"Celkom s˙Ëet za doklad","T",0,"L");$pdf->Cell(90,5,"$riadok->hod","T",1,"R");
$pdf->Cell(180,1," ","0",1,"L");
     }

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
     { 
$hodnota = $riadok->hodu;
$celkom = $riadok->hodu;

$prepoc = $celkom * $kurz12;
$zaloha = $riadok->zal;
$uhradit = $celkom-$zaloha;
$Cislo=$hodnota+"";
$sHodnota=sprintf("%0.2f", $Cislo);
$Cislo=$celkom+"";
$sCelkom=sprintf("%0.2f", $Cislo);
$Cislo=$prepoc+"";
$sPrepoc=sprintf("%0.2f", $Cislo);

$minusove=0;
$sCelkomslovo=$sCelkom;
$znamienko="";
if( $hodnota < 0 ) { $minusove=1; $sCelkomslovo=-$sCelkom; $sCelkomslovo=sprintf("%0.2f", $sCelkomslovo); $znamienko="mÌnus"; }


$sSlovom=CisloSlovom ($sCelkomslovo, false, " ", "Zensky");

$pdf->SetFont('arial','',10);
$pdf->Cell(150,6,"Celkom zaplatenÈ (slovom): $znamienko $sSlovom $com1p $mena1 ","1",0,"L");
$pdf->Cell(30,6,"$sCelkom $mena1","1",1,"R");

if( $ajprepocetnask == 1 )
   {
$pdf->SetFont('arial','',9);
$pdf->Cell(150,6,"Info prepoËet na $mena2 konverzn˝m kurzom $kurz12 Sk/Eur","1",0,"L");
$pdf->Cell(30,6,"$sPrepoc $mena2","1",1,"R");
   }

$pdf->Cell(180,2," ","0",1,"L");

$schval=""; $schvpp=0; $schvvp=0;
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$schval = $riadokc->schval;
$schvpp = 1*$riadokc->schvpp;
$schvvp = 1*$riadokc->schvvp;
     }
if( ( $drupoh == 1 OR $drupoh == 3 ) AND $schvpp == 0 ) { $schval=""; }
if( $drupoh == 2 AND $schvvp == 0 ) { $schval=""; }

$pdf->SetFont('arial','',9);
$pdf->Cell(90,5,"Schv·lil: $schval","LT",0,"L");$pdf->Cell(90,5,"Podpis prÌjemcu,peËiatka:","TR",1,"L");
$pdf->Cell(90,5," ","L",0,"L");$pdf->Cell(90,5," ","R",1,"L");
$pdf->Cell(90,5," ","LB",0,"L");$pdf->Cell(90,5," ","RB",1,"L");
     }

if( $drupoh == 4 )
  {
$pdf->Cell(30,5," ","0",1,"L");
$pdf->Cell(60,5,"Spolu kredit: $riadok->kredit","1",0,"L");
$pdf->Cell(60,5,"Spolu debet: $riadok->debet","1",0,"L");
$pdf->Cell(0,5," ","1",1,"L");
  }


if( $drupoh == 5 )
  {
$pdf->Cell(30,5," ","0",1,"L");
$pdf->Cell(60,5,"Za˙Ëtoval: $hlavicka->meno $hlavicka->priezvisko","1",0,"L");
$pdf->Cell(60,5,"Schv·lil:","1",0,"L");
$pdf->Cell(0,5," ","1",1,"L");
  }

$pdf->SetFont('arial','',7);
$pdf->Cell(180,5,"Vystavil(a): $riadok->meno $riadok->priezvisko / $riadok->id","0",1,"L");


$zostatok=0;
$zostatokeur=0;
$new=1;
$pdf->Cell(0,5," ","0",1,"R");
$j=-1;
}



$razitko = 1*$_REQUEST['h_razitko'];

if( $razitko == 1 AND $drupoh < 4 )
          {
$pocetpoloziek=$slpol+$tvpol;

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/pokrazitko'.$kli_uzid.'.jpg'))
{
$rozmerhlv1="155"; $rozmerhlv2="130"; $rozmerhlv3="40"; $rozmerhlv4="20";

$sirka=0; $vyska=0; $zhora=0; $zlava=0;
$sqlttt = "SELECT ucm1,ucm2,ucm3,ucm4 FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sirka=1*$riaddok->ucm1; $vyska=1*$riaddok->ucm2; $zlava=1*$riaddok->ucm3; $zhora=1*$riaddok->ucm4;
  }
//echo $sirka.$vyska.$zhora.$zlava;
//exit;

if( $sirka > 0 AND $vyska > 0 AND $zhora > 0 AND $zlava > 0 ) { $rozmerhlv1=$zlava+""; $rozmerhlv2=$zhora+""; $rozmerhlv3=$sirka+""; $rozmerhlv4=$vyska+""; }

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/pokrazitko'.$kli_uzid.'.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}
          }




if( $riadok->pox == 9 )
{

$pdf->SetFont('arial','',9);


$j=$j+1;
}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 46 ) $j=0;

  }

//tabulka financna kontrola vs
$tlacover=0;
if( $fir_fico == 36268399 AND $kli_vrok >= 2016 ) 
 { 
$tlacover=1;
$meno1="Ing. Gabriela Kov·Ëov·";
$meno2="Drahoslava JureÚov·"; 
 }

if ( $tlacover == 1 )
{
$pdf->SetY(245);
//1.osoba
$pdf->SetFont('arial','',8);
$pdf->Cell(130,5,"  FinanËn˙ oper·ciu  je  -  nie je  moûnÈ vykonaù a pokraËovaù v nej","1",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(65,5,"Vykonal:  $meno1","0",0,"L");
$pdf->Cell(35,5,"D·tum  $dat_sk","0",0,"L");
$pdf->Cell(30,5,"Podpis","0",1,"L");
//2.osoba
$pdf->SetFont('arial','',8);
$pdf->Cell(130,5,"  FinanËn˙ oper·ciu  je  -  nie je  moûnÈ vykonaù a pokraËovaù v nej","1",1,"L");
$pdf->SetFont('arial','',7);
$pdf->Cell(65,5,"Vykonal:  $meno2","0",0,"L");
$pdf->Cell(35,5,"D·tum  $dat_sk","0",0,"L");
$pdf->Cell(30,5,"Podpis","0",1,"L");
//vecna spravnost
$pdf->SetFont('arial','',7);
$pdf->Cell(190,1," ","0",1,"L");
$pdf->Cell(65,5,"a) Vecn˙ spr·vnosù overil:  $meno1","TL",0,"L");
$pdf->Cell(35,5,"D·tum  $dat_sk","T",0,"L");
$pdf->Cell(30,5,"Podpis","TR",1,"L");
//formalna spravnost
$pdf->Cell(65,5,"b) Form·lnu spr·vnosù overil:  $meno2","TBL",0,"L");
$pdf->Cell(35,5,"D·tum  $dat_sk","TB",0,"L");
$pdf->Cell(30,5,"Podpis","TRB",1,"L");

}

$pdf->Output("$outfilex");

$sql = 'DROP TABLE F'.$kli_vxcf.'_prcudok'.$kli_uzid;
//$vysledek = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_prcupoh'.$kli_uzid;
//$vysledek = mysql_query("$sql");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>


<?php
mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>