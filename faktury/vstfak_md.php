<!doctype html>
<html>
<?php
@session_start();

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'FAK';
$urov = 1100;
if( $copern == 10 ) $urov = 1000;
if( $copern == 155 OR $copern == 156 OR $copern == 167 OR $copern == 168 )
{
$sys = 'ALL';
$urov = 10000;
}
$drupoh = strip_tags($_REQUEST['drupoh']);
$regpok = 1*$_REQUEST['regpok'];
if( $drupoh == 31 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 OR $copern == 267 OR $copern == 268 )
{
$sys = 'DOP';
$urov = 2000;
if( $regpok == 1 ) { $sys = 'FAK'; }
}
$DOPRAVA = "DOPRAVA";
$vyroba = $_REQUEST['vyroba'];
if(!isset($vyroba)) $vyroba = 0;
if($vyroba == 1 ) $DOPRAVA = "V›ROBA";

$pocstav = $_REQUEST['pocstav'];
if(isset($pocstav)) { $_SESSION['pocstav'] = $pocstav; }
$pocstav=$_SESSION['pocstav'];

//echo $pocstav;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvfak = include("../faktury/vtvfak.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//datove struktury mes.vykaz dph
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha2new ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
echo "Def mesVykDPH";

$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct MODIFY unk VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban MODIFY unk VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp MODIFY unk VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctodb MODIFY unk VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdod MODIFY unk VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct MODIFY rdp DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban MODIFY rdp DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp MODIFY rdp DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctodb MODIFY rdp DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdod MODIFY rdp DECIMAL(4,0) DEFAULT 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_pokpri MODIFY sp4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd MODIFY sp4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp MODIFY sp4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh MODIFY sp4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb MODIFY sz4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY sz4 VARCHAR(20) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY crd3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY nrd VARCHAR(70) NOT NULL ";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2014 )
  {
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='B2' WHERE rdp >  10 AND rdp < 50 AND szd > 0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='A1' WHERE rdp >= 50 AND rdp < 99 AND szd > 0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='', crz3=1 WHERE rdp = 84 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='', crz3=1 WHERE rdp = 85 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='', crz3=1 WHERE rdp = 90 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='', crz3=1 WHERE rdp = 385 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='B1', crz3=1 WHERE rdp = 34 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='B1', crz3=1 WHERE rdp = 35 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='B1', crz3=1 WHERE rdp = 40 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='B1', crz3=1 WHERE rdp = 335 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='' WHERE rdp = 61 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='' WHERE rdp = 62 ";
$vysledek = mysql_query("$sql");
  }

$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");

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

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha2".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha2new".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykdpha2 ADD sumd DECIMAL(10,2) DEFAULT 0 AFTER merj ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykdpha2 ADD zkld DECIMAL(10,2) DEFAULT 0 AFTER merj ";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha3new ";
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

if( $kli_vrok == 2014 )
{
//prenos DPH nejde do priznania DPH
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crz=0 WHERE rdp = 361 OR rdp = 461";
$vysledek = mysql_query("$sql");
}

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha3new".$sqlt;
$vysledek = mysql_query("$sql");
}
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha4new ";
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

if( $kli_vrok == 2014 )
{
//JCD nejdu do KV DPH
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd3='' WHERE crz1 = 1 ";
$vysledek = mysql_query("$sql");
}

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha4new".$sqlt;
$vysledek = mysql_query("$sql");
}
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha6new ";
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
$sql = "ALTER TABLE F$kli_vxcf"."_dopfak MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dopfak MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

if( $sys == 'DOP' )
  {
$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha6new".$sqlt;
$vysledek = mysql_query("$sql");
  }
}
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
$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha8new ";
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

if( $kli_vrok == 2014 )
{
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crd=10 WHERE rdp = 385 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_uctdrdp SET crz=9 WHERE rdp = 335 ";
$vysledek = mysql_query("$sql");
}

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha8new".$sqlt;
$vysledek = mysql_query("$sql");
}

$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha91new ";
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
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha91new".$sqlt;
$vysledek = mysql_query("$sql");
}

$sql = "SELECT prx6 FROM F$kli_vxcf"."_uctvykdpha21new ";
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

$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY sz4 DATE NOT NULL ";
$vysledek = mysql_query("$sql");
if( $kli_vrok == 2014 ) {
$sql = "UPDATE F$kli_vxcf"."_fakdodpoc SET sz4=daz WHERE daz != '0000-00-00' ";
$vysledek = mysql_query("$sql");
                        }
$sql = "ALTER TABLE F$kli_vxcf"."_fakodbpoc MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY sz3 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakodbpoc MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY dav VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctvykdpha21new".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec datove struktury mes.vykaz dph

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//oprava ciselnika uctdrdp
if( $kli_vrok == 2015 )
{
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp = 25 ";
$sqldok = mysql_query("$sqlttt");
if(@$zaznam=mysql_data_seek($sqldok,0))
{
$riaddok=mysql_fetch_object($sqldok);
$crd3=$riaddok->crd3;

if ($crd3 != 'B2')
    {
$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");
$kli_vmcf=1*$fir_allx11;

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdrdp ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY crd3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY nrd VARCHAR(70) NOT NULL ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdrdp SELECT * FROM ".$databaza."F$kli_vmcf"."_uctdrdp ";
if( $kli_vmcf > 0 ) { $dsql = mysql_query("$dsqlt"); echo "Znovu prenos ËÌselnÌka druhov DPH z firmy ".$kli_vmcf; }
    }
}
}
//koniec oprava ciselnika uctdrdp



// druh pohybu 1=odber , 2=dodav , 11=dodacielisty , 12=dodacielisty doprava , 21=VNF, 22=VNFdoprava
$drupoh = strip_tags($_REQUEST['drupoh']);

$rozuct='NIE';
$sysx='INE';
$zmenauce=0;
if( $drupoh > 1000 AND $drupoh < 2000 )
{
$drupoh=$drupoh-1000;
$rozuct='ANO';
$sysx='UCT';
$zmenauce=1;
}
if( $drupoh > 2000 )
{
$drupoh=$drupoh-2000;
$rozuct='NEI';
$sysx='FAK';
$zmenauce=1;
}

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

$kli_vxcfskl=$kli_vxcf;
if( $drupoh == 1 )
{
$tabl = "fakodb";
$tablsluzby = "fakslu";
$cisdok = "fakodb";
$adrdok = "fakodber";
$zassluzby = "sluzbyzas";
if( $pocstav == 1 ) $tabl = "fakodbpoc";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}
if( $drupoh == 31 )
{
$tabl = "dopfak";
$tablsluzby = "dopslu";
$cisdok = "dopfak";
$adrdok = "dopfak";
$zassluzby = "dopsluzbyzas";
$rozuct='NIE';
$sysx='INE';
}
if( $drupoh == 11 )
{
$tabl = "fakdol";
$tablsluzby = "fakslu";
$cisdok = "fakdol";
$adrdok = "fakdol";
$zassluzby = "sluzbyzas";
$rozuct='NIE';
$sysx='INE';
}
if( $drupoh == 12 )
{
$tabl = "dopdol";
$tablsluzby = "dopslu";
$cisdok = "dopdol";
$adrdok = "dopdol";
$zassluzby = "dopsluzbyzas";
$rozuct='NIE';
$sysx='INE';
}
if( $drupoh == 21 )
{
$tabl = "fakvnp";
$tablsluzby = "fakslu";
$cisdok = "fakvnp";
$adrdok = "fakvnp";
$zassluzby = "sluzbyzas";
$rozuct='NIE';
$sysx='INE';
}
if( $drupoh == 22 )
{
$tabl = "dopvnp";
$tablsluzby = "dopslu";
$cisdok = "dopvnp";
$adrdok = "dopvnp";
$zassluzby = "dopsluzbyzas";
$rozuct='NIE';
$sysx='INE';
}
if( $drupoh == 42 )
{
$tabl = "dopreg";
$tablsluzby = "dopslu";
$cisdok = "dopreg";
$adrdok = "dopreg";
$zassluzby = "dopsluzbyzas";
$rozuct='NIE';
$sysx='INE';
if( $regpok == 1 )
  {
$tablsluzby = "fakslu";
  }
}
if( $drupoh == 52 )
{
$tabl = "dopprf";
$tablsluzby = "dopslu";
$cisdok = "fakprf";
$adrdok = "fakprf";
$zassluzby = "dopsluzbyzas";
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 2 )
{
$tabl = "fakdod";
$tablsluzby = "fakslu";
$cisdok = "fakdod";
$adrdok = "fakdodav";
$zassluzby = "sluzbyzas";
if( $pocstav == 1 ) $tabl = "fakdodpoc";
}

//z listy
$zmenajucet = 1*$_REQUEST['zmenajucet'];
if( $zmenajucet == 1 ) { $zmenauce=1; }


//nastavenie uctu
$hladaj_uce = $_REQUEST['hladaj_uce'];
//ak viac rad pre jednu analytiku
if( $fir_uctx14 == 1 AND ( $drupoh == 1 OR $drupoh == 2 ) AND $zmenauce == 0  )
{
$hladaj_uce = $_SESSION['nastavene_uce'];
}
$hladaj_ucex=$hladaj_uce;
//echo "uce".$hladaj_uce;

if(!isset($hladaj_uce) OR $hladaj_uce == '')
{
if( $drupoh != 2 AND $drupoh != 42 )
{
//odberatelske faktury
if( $drupoh == 1 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 1 ) ORDER BY dodb"); }
//odberatelske faktury DOPRAVA
if( $drupoh == 31 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 11 ) ORDER BY dodb"); }
//dodacie listy
if( $drupoh == 11 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 2 ) ORDER BY dodb"); }
//dodacie listy DOPRAVA
if( $drupoh == 12 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 12 ) ORDER BY dodb"); }
//vnotrupodnikove faktury
if( $drupoh == 21 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 3 ) ORDER BY dodb"); }
//vnutropodnikove faktury DOPRAVA
if( $drupoh == 22 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 13 ) ORDER BY dodb"); }
//predfaktury DOPRAVA
if( $drupoh == 52 ) { $sqluce = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 14 ) ORDER BY dodb"); }
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dodb;
  }
}
//reg.pokladnica DOPRAVA
if( $drupoh == 42 )
{
$sqluce = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 9 ) ORDER BY dpok");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dpok;
  }
}
//dodavatelska faktura
if( $drupoh == 2 )
{
$sqluce = mysql_query("SELECT ddod,ndod FROM F$kli_vxcf"."_ddod WHERE ( drdo = 1 ) ORDER BY ucdo");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->ddod;
  }
}


}
//koniec nastavenia uctu


$uloz="NO";
$zmaz="NO";
$uprav="NO";

//import z ../import/dopdol.csv a dopslu.csv
    if (( $copern == 167 OR $copern == 168 OR $copern == 155 OR $copern == 156 ) AND ( $drupoh == 1 OR $drupoh == 2 ) AND $pocstav == 1 )
    {
    if( $kli_vduj != 9 ) { $uziv = include("../faktury/fakpoc_import.php"); }
    if( $kli_vduj == 9 ) { $uziv = include("../faktury/fakpoc_import_ju.php"); }
    }
    if ( $copern == 155 AND $drupoh == 12 )
    {
?>
<script type="text/javascript"> //dopyta, skult˙rniù
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/dopdol.csv ?") )
         { window.close()  }
else
         { location.href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=156&page=1&drupoh=12'  }
</script>
<?php
    }
    if ( $copern == 156 AND $drupoh == 12 )
    {
$copern=1;

if( file_exists("../import/dopdol.csv")) echo "S˙bor ../import/dopdol.csv existuje<br />";

$subor = fopen("../import/dopdol.csv", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_dol = $pole[0];
  $x_ico = $pole[1];
  $x_str = $pole[2];
  $x_zak = $pole[3];
  $x_dat = $pole[4];
  $x_zk2 = $pole[5];
  $x_dn2 = $pole[6];
  $x_sp2 = $pole[7];
  $x_uce = $pole[8];
  $x_kon = $pole[9];
  $x_dok = 59000 + $x_dol;
  $dat_sql = SqlDatum($x_dat);
  $pole = explode("-", $dat_sql);
  $x_ume = $pole[1].".".$pole[0];
  if( $x_str == '0' ) $x_str = $fir_dopstr;
  if( $x_zak == '0' ) $x_zak = $fir_dopzak;


$sqult = "INSERT INTO F$kli_vxcf"."_dopdol ( uce,dok,doq,dol,ico,str,zak,dat,daz,das,zk2,dn2,sp2,hod,id,".
"zk1,dn1,sp1,zk0,zao,zal,ruc,uhr,zk3,zk4,dn3,dn4,sz1,sz2,sz3,sz4,fak,prf,skl,poh,".
"obj,unk,dpr,ksy,ssy,poz,txz,txp,ume)".
" VALUES ( '$x_uce', '$x_dok', '$x_dok', '$x_dol', '$x_ico', '$x_str', '$x_zak', '$dat_sql', '$dat_sql', '$dat_sql',".
" '$x_zk2', '$x_dn2', '$x_sp2', '$x_sp2', '$kli_uzid',".
" '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',".
" '', '', '', '', '', '', '', '', '$x_ume' ".
");";

$ulozene = mysql_query("$sqult");
}
echo "Tabulka F$kli_vxcf"."_dopdol!"." naimportovan· <br />";
fclose ($subor);

if( file_exists("../import/dopslu.csv")) echo "S˙bor ../import/dopslu.csv existuje<br />";

$subor = fopen("../import/dopslu.csv", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_dol = $pole[0];
  $x_slu = $pole[1];
  $x_nsl = $pole[2];
  $x_cep = $pole[3];
  $x_ced = $pole[4];
  $x_mno = $pole[5];
  $x_uce = $pole[6];
  $x_cfak = $pole[7];
  $x_kon = $pole[8];

  $x_dok = 59000 + $x_dol;


$sqult = "INSERT INTO F$kli_vxcf"."_dopslu ( dok,dol,slu,nsl,cep,ced,mno,dph,id,".
"fak,prf,cen,pfak,cfak,dfak,pop,pon,mer,xfak)".
" VALUES ( '$x_dok', '$x_dol', '$x_slu', '$x_nsl', '$x_cep', '$x_ced', '$x_mno', '19', '$kli_uzid',".
" '0', '0', '0', '0', '$x_cfak', '0', '', '', '', '' ".
");";

$ulozene = mysql_query("$sqult");
}
echo "Tabulka F$kli_vxcf"."_dopslu!"." naimportovan· <br />";
fclose ($subor);
    }

//vymazanie vsetkych poloziek dodacie listy,pociatok odber dodav
    if ( $copern == 167 AND $drupoh == 12 )
    {
?>
<script type="text/javascript"> //dopyta, skult˙rniù
if( !confirm ("Chcete vymazaù vöetky poloûky \r dodacÌch listov ?") )
         { window.close()  }
else
         { location.href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=168&page=1&drupoh=12'  }
</script>
<?php
    }
    if ( $copern == 168 AND $drupoh == 12 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_dopdol';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_dopdol!"." vynulovan· <br />";
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_dopslu';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_dopslu!"." vynulovan· <br />";
    }
//koniec nahratia a vymazania databazy dopdol a dopslu


//vymazanie vsetkych poloziek VNF Doprava Agrostav
    if ( $copern == 267 )
    {
?>
<script type="text/javascript"> //dopyta, skult˙rniù
if( !confirm ("Chcete vymazaù vöetky poloûky \r vn˙tropodnikov˝ch fakt˙r za mesiac <?php echo $kli_vume; ?> ?") )
         { window.close()  }
else
         { location.href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=268&page=1&drupoh=22'  }
</script>
<?php
    }
    if ( $copern == 268 )
    {
$copern=1;
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dopvnp WHERE ( ume = $kli_vume AND poh = 99 )");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dopslu WHERE ( cfak = 99 AND dfak = 99 AND pfak = $kli_vmes )");

$sqtz = "UPDATE F$kli_vxcf"."_dopslu SET pfak=0, dfak=0,".
" cfak=0, xfak=''".
" WHERE ( xfak = $kli_vume AND cfak = 98 AND dfak = 98 AND pfak = 98 )";
$upravene = mysql_query("$sqtz");
$sqtz = "UPDATE F$kli_vxcf"."_dopstzp SET pfak=0, dfak=0,".
" cfak=0, xfak=''".
" WHERE ( xfak = $kli_vume AND cfak = 98 AND dfak = 98 AND pfak = 98 )";
$upravene = mysql_query("$sqtz");

//vratenie cisla dokladov z cx01
$dsqlt = "UPDATE F$kli_vxcf"."_dodb".
" SET cfak = cx01".
" WHERE drod = 13".
"";
$dsql = mysql_query("$dsqlt");

    }
//koniec nahratia a vymazania databazy dopvnp a dopslu z DOPRAVA Agrostav

// 16=vymazanie dokladu potvrdene v vstf_u.php ak nie je pociatocny stav
if ( $copern == 16 AND $pocstav != 1 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$cislo_fak = strip_tags($_REQUEST['cislo_fak']);

//odpocitat polozky z sklzas
$dsqlt = "SELECT skl,cis,cen,mno FROM F$kli_vxcfskl"."_sklfak WHERE dok='$cislo_dok' AND cis > 0 ";
$dsql = mysql_query("$dsqlt");

$pzaz = mysql_num_rows($dsql);

$i = 0;
   while ($i < $pzaz )
   {
  if (@$dzak=mysql_data_seek($dsql,$i))
  {

$driadok=mysql_fetch_object($dsql);
$sqtu = "UPDATE F$kli_vxcfskl"."_sklzas SET zas=zas+($driadok->mno) WHERE skl='$driadok->skl' AND cis='$driadok->cis' AND cen='$driadok->cen'";
$upravene = mysql_query("$sqtu");

  }
$i = $i + 1;
   }

//odpocitat polozky zo sluzbyzas
$dslqlt = "SELECT slu,cen,mno FROM F$kli_vxcf"."_$tablsluzby WHERE dok='$cislo_dok'";
$dslql = mysql_query("$dslqlt");

$pzlaz = mysql_num_rows($dslql);

$j = 0;
   while ($j < $pzlaz )
   {
  if (@$dzak=mysql_data_seek($dslql,$j))
  {

$dlriadok=mysql_fetch_object($dslql);


//pripisat do zasob
$x_skl=0;
$x_cen=0;
$x_slu=$dlriadok->slu;
$x_mno=$dlriadok->mno;
$sqltu = "UPDATE F$kli_vxcf"."_$zassluzby SET zas=zas+($x_mno) WHERE ( skl=$x_skl AND slu=$x_slu AND cen=$x_cen );";
//echo $sqltu;
$upravene = mysql_query("$sqltu");

  }
$j = $j + 1;
   }

//vymaz polozky faktury
if( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
$zmazane = mysql_query("DELETE FROM F$kli_vxcfskl"."_sklfak WHERE dok='$cislo_dok' ");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tablsluzby WHERE dok='$cislo_dok' ");
}

//vymaz polozky zauctovania
if( $drupoh == 1 ) { $zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_uctodb WHERE dok='$cislo_dok' ");
include("../ucto/saldo_zmaz_ok.php");
}
if( $drupoh == 2 ) { $zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_uctdod WHERE dok='$cislo_dok' ");
include("../ucto/saldo_zmaz_ok.php");
}

//odznac vyfakturovane pre dopravu v stazkach a dodakoch a odznac aj z kuchyne dodaky
if( $drupoh == 31 OR $drupoh == 42 OR $drupoh == 22 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_dopslu SET pfak='0', cfak='0',".
" dfak='0', xfak='' ".
" WHERE cfak = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_dopstzp SET pfak='0', cfak='0',".
" dfak='0', xfak='' ".
" WHERE cfak = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$kuchyna=0;
if (File_Exists ("../kuchyna/pouzivam_kuchynu.php"))
  {
$kuchyna=1;
$sqtoz = "UPDATE F$kli_vxcf"."_kuchdodp SET cfak='0', dfak='0' ".
" WHERE cfak = $cislo_dok ";
$oznac = mysql_query("$sqtoz");
  }
$ubyt=0;
if (File_Exists ("../ubyt/pouzivam_ubyt.php"))
  {
$ubyt=1;
$sqtoz = "UPDATE F$kli_vxcf"."_ubytdodp SET cfak='0', dfak='0' ".
" WHERE cfak = $cislo_dok ";
$oznac = mysql_query("$sqtoz");
  }
}

//vymazat zo zoznamu dokladov
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE dok='$cislo_dok' ");
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//uprav cislo v tabulke
if( $cisdokodd != 1 OR $drupoh == 42 )
        {
$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$cislo_dok' WHERE $cisdok > '$cislo_dok'");
        }
if( $cisdokodd == 1 AND $drupoh != 42 )
        {
$zhodaradu="";
if( $fir_uctx14 == 1 AND ( $drupoh == 1 OR $drupoh == 2 ) ) { $zhodaradu="LEFT(cfak,2) = LEFT($cislo_dok,2) AND "; }

 if( $drupoh == 1  ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE $zhodaradu cfak > '$cislo_dok' AND drod = 1 AND dodb = $hladaj_ucex"; }
 if( $drupoh == 31 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 11 AND dodb = $hladaj_uce"; }
 if( $drupoh == 11 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 2 AND dodb = $hladaj_uce"; }
 if( $drupoh == 12 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 12 AND dodb = $hladaj_uce"; }
 if( $drupoh == 21 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 3 AND dodb = $hladaj_uce"; }
 if( $drupoh == 22 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 13 AND dodb = $hladaj_uce"; }
 if( $drupoh == 52 ) { $upravttt = "UPDATE F$kli_vxcf"."_dodb SET cfak='$cislo_dok' WHERE cfak > '$cislo_dok' AND drod = 14 AND dodb = $hladaj_uce"; }
 if( $drupoh == 2  ) { $upravttt = "UPDATE F$kli_vxcf"."_ddod SET cfak='$cislo_dok' WHERE $zhodaradu cfak > '$cislo_dok' AND drdo = 1 AND ddod = $hladaj_ucex"; }

 $upravene = mysql_query("$upravttt");
        }
//uprav cislo cbl ak registracka
if( $drupoh == 42 )
{
$upravcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl='$cislo_fak' WHERE cbl > '$cislo_fak'");
}
//echo "POLOéKA DOK:$cislo_dok BOLA VYMAZAN¡ ";
endif;

     }
//koniec vymazania ak nie poc.stav

// 16=vymazanie dokladu potvrdene v vstf_u.php ak je pociatocny stav
if ( $copern == 16 AND $pocstav == 1 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$cislo_fak = strip_tags($_REQUEST['cislo_fak']);

//vymazat zo zoznamu dokladov
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE dok='$cislo_dok' ");
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania poc.stav

// 55=nova kopia dokladu potvrdene v vstf_u.php
if ( $copern == 55 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

//copern55zaloz novy doklad
$maxdok=0;
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_$tabl WHERE dok > 0 AND uce = $hladaj_uce ORDER BY dok DESC LIMIT 1";
//echo $sqldoktt;
$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxdok=$riaddok->dok;
  }
$newdok=1*$maxdok+1;

$h_fak = $newdok;

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( dok,doq,fak,id ) VALUES ( $newdok, $newdok, $newdok, $kli_uzid )";
//echo $sqlhh;
$ulozene = mysql_query("$sqlhh");

//copern55skopiruj donho udaje zahlavia
$faktt = "SELECT * FROM F$kli_vxcf"."_$tabl"." WHERE dok = $cislo_dok "." ORDER BY dok";
$dsql = mysql_query("$faktt");

  if (@$dzak=mysql_data_seek($dsql,0))
  {
$friadok=mysql_fetch_object($dsql);

 $uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$friadok->uce', dat='$friadok->dat', ume='$friadok->ume',".
" daz='$friadok->daz', das='$friadok->das', poh='$friadok->poh', skl='$friadok->skl', ico='$friadok->ico',".
" ksy='$friadok->ksy', ssy='$friadok->ssy',".
" poz='$friadok->poz', str='$friadok->str', zak='$friadok->zak', txp='$friadok->txp', txz='$friadok->txz',".
" dol='$friadok->dol', prf='$friadok->prf',".
" hod='$friadok->hod', zk0='$friadok->zk0', zk1='$friadok->zk1', zk2='$friadok->zk2', dn1='$friadok->dn1',".
" dn2='$friadok->dn2', sz1='$friadok->sz1', sz2='$friadok->sz2',".
" zk3='$friadok->zk3', zk4='$friadok->zk4', dn3='$friadok->dn3', dn4='$friadok->dn4', sz3='$friadok->sz3',".
" sz4='$friadok->sz4', sp1='$friadok->sp1', sp2='$friadok->sp2',".
" obj='$friadok->obj', unk='$friadok->unk', dpr='$friadok->dpr', zal='$friadok->zal'".
" WHERE id='$kli_uzid' AND dok='$newdok'";

$upravene = mysql_query("$uprt");
  }


//copern55skopiruj polozky do fakslu
$sluztt = "SELECT dok, fak, dol, prf, cpl, slu, nsl, pop, dph,".
" mno, mer, cep, ced".
" FROM F$kli_vxcf"."_fakslu".
" WHERE dok = $cislo_dok ".
" ORDER BY cpl";
$dsql = mysql_query("$sluztt");

$pzaz = mysql_num_rows($dsql);

$i = 0;
   while ($i < $pzaz )
   {
  if (@$dzak=mysql_data_seek($dsql,$i))
  {

$driadok=mysql_fetch_object($dsql);

$sqty = "INSERT INTO F$kli_vxcf"."_fakslu ( dok,fak,dol,prf,slu,nsl,pop,dph,cep,ced,mno,mer,id )".
" VALUES ('$newdok', '$newdok', '$driadok->dol', '$driadok->prf', '$driadok->slu', '$driadok->nsl', '$driadok->pop',".
" '$driadok->dph', '$driadok->cep', '$driadok->ced', '$driadok->mno', '$driadok->mer', '$kli_uzid' );";

//echo $sqty;
$kopia = mysql_query("$sqty");

  }
$i = $i + 1;
   }

$copern=1;
     }
//koniec novej kopie


// 416=vymazanie rozuctovania dokladu z fakrozuct.php
if ( $copern == 416  )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

if( $drupoh == 1 ) {
$upravttt = "UPDATE F$kli_vxcf"."_fakodb SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp0u=0, sp1u=0, sp2u=0, hodu=0 WHERE dok='$cislo_dok' ";
$upravene = mysql_query("$upravttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctodb WHERE dok='$cislo_dok' ";
$zmazane = mysql_query("$zmazttt");
                   }

if( $drupoh == 2 ) {
$upravttt = "UPDATE F$kli_vxcf"."_fakdod SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp0u=0, sp1u=0, sp2u=0, hodu=0 WHERE dok='$cislo_dok' ";
$upravene = mysql_query("$upravttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctdod WHERE dok='$cislo_dok' ";
$zmazane = mysql_query("$zmazttt");
                   }

include("../ucto/saldo_zmaz_ok.php");
$copern=1;

     }
//koniec vymazania rozuctovania

//echo "ucex ".$_SESSION['nastavene_uce'];

//month navigation
$zmenume=1*$zmenume;
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if ( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if ( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;
$odkaz="../faktury/vstfak_md.php?regpok=$regpok&vyroba=$vyroba&copern=1&drupoh=$drupoh&page=1&sysx=$sysx&hladaj_uce=$hladaj_uce&rozuct=$rozuct";
$odkaz64=urlencode($odkaz);








?>
<head>
  <meta charset="cp1250">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="../css/material.min.css">
  <link rel="stylesheet" href="../css/material_edit.css">
  <link rel="stylesheet" href="../css/material_list_layout.css">
  <title>
<?php
if ( $drupoh == 1 OR $drupoh == 31 ) echo "OdberateæskÈ fakt˙ry";
if ( $drupoh == 2 ) echo "Dod·vateæskÈ fakt˙ry";
if ( $drupoh == 11 OR $drupoh == 12 ) echo "Dodacie listy";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "Vn˙tropodnikovÈ fakt˙ry";
if ( $drupoh == 42 ) echo "RegistraËn· pokladnica";
if ( $drupoh == 52 ) echo "Predfakt˙ry";
?> | EuroSecom</title>
<style>
/* list layout */
.ui-list th:nth-child(1), .ui-list td:nth-child(1) {
  width: 6%;
  text-align: left;
}
.ui-list th:nth-child(2), .ui-list td:nth-child(2) {
  width: 20%;
  text-align: left;
}
.ui-list th:nth-child(3), .ui-list td:nth-child(3) {
  width: 8%;
  text-align: left;
}
.ui-list th:nth-child(4), .ui-list td:nth-child(4) {
  width: 25%;
  text-align: left;
}
.ui-list th:nth-child(5), .ui-list td:nth-child(5) {
  width: 10%;
  text-align: right;
}
.ui-list th:nth-child(6), .ui-list td:nth-child(6) {
  width: 16%;
  text-align: right;
}
.ui-list th:nth-child(7), .ui-list td:nth-child(7) {
  width: 15%;
  text-align: right;
  padding-right: 0;
}
.ui-list td:nth-child(1), .ui-list td:nth-child(5) {
  color: rgba(0,0,0,.54);
}













 /*dopyt, okno pÙjde preË*/
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
</style>
</head>
<body onload="ObnovUI(); VyberVstup();">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
<header class="mdl-layout__header mdl-layout__header--waterfall ui-header">
  <div class="mdl-layout__header-row ui-header-app-row">
    <span class="mdl-color-text--yellow-A100">EuroSecom</span>&nbsp;
    <span>
<?php
if ( $sysx == 'UCT' ) echo "⁄ËtovnÌctvo";
if ( $sysx == 'FAK' ) echo "Odbyt";
?>
    </span>
    <div class="mdl-layout-spacer"></div>
    <ul class="mdl-list clearfix ilogin">
<!-- firm + period -->
      <li class="mdl-list__item mdl-list__item--two-line toleft">
        <span class="mdl-list__item-primary-content right" style="padding-top: 4px;">
          <span class="mdl-color-text--white"><?php echo "<strong>$kli_vxcf</strong>&nbsp;&nbsp;$kli_nxcf"; ?></span>
          <span class="mdl-list__item-sub-title" style="font-size: 13px;"><?php echo $kli_vume; ?></span>
        </span>
      </li>
<!-- user -->
      <li class="mdl-list__item toleft" style="margin-left: 24px;">
        <span class="mdl-list__item-primary-content">
          <span id="user" class="mdl-list__item-avatar list-item-avatar mdl-color--indigo-400" style="margin-right: 0;"><?php echo $kli_uzid; ?></span>
        </span>
      </li>
    </ul>
      <span data-mdl-for="user" class="mdl-tooltip">Prihl·sen˝ uûÌvateæ:<br><?php echo "$kli_uzmeno $kli_uzprie / $kli_uzid"; ?></span>
  </div> <!-- .ui-header-app-row -->
<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
$citcbl='';
if( $drupoh == 42 ) $citcbl=", cbl";

if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 7 && $copern != 9 AND $copern != 10 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
  {
//[[[[[

$hladaj_ucex=$hladaj_uce;

//ak viac rad pre jednu analytiku
if( $fir_uctx14 == 1 AND ( $drupoh == 1 OR $drupoh == 2 ))
{
if( $drupoh == 1 )
     {
$sqluce = mysql_query("SELECT dodb,nodb,ucod FROM F$kli_vxcf"."_dodb WHERE ( dodb = $hladaj_uce ) ORDER BY dodb");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  //echo "idem";
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_ucex=$riaduce->ucod;
  }
     }
if( $drupoh == 2 )
     {
$sqluce = mysql_query("SELECT ddod,ndod,ucdo FROM F$kli_vxcf"."_ddod WHERE ( ddod = $hladaj_uce ) ORDER BY ddod");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  //echo "idem";
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_ucex=$riaduce->ucdo;
  }
     }
$_SESSION['nastavene_uce'] = $hladaj_uce;
}



$akeume=">= ".$kli_vume;
$hladaj_ucep="= ".$hladaj_ucex;
$order="dok";
if( $drupoh == 22 ) { $akeume="= ".$kli_vume; $hladaj_ucep=" > 0 "; }
if( $pocstav == 1 ) { $akeume="> 0 "; $order="F".$kli_vxcf."_".$tabl.".ume,dok";}
$chodu="";
if( $sysx == 'UCT' ) $chodu="hodu,poh,";
if( $drupoh == 42 ) $chodu="ruc,";

$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" fak, dol, prf, str, zak, hod,".$chodu." strv, zakv".$citcbl.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" WHERE ( F$kli_vxcf"."_$tabl.uce $hladaj_ucep AND F$kli_vxcf"."_$tabl.dok > 0 AND F$kli_vxcf"."_$tabl.ume $akeume )".
" OR isnull( F$kli_vxcf"."_$tabl.ume) ".
" OR isnull( F$kli_vxcf"."_$tabl.dat) OR isnull( F$kli_vxcf"."_$tabl.uce) OR F$kli_vxcf"."_$tabl.uce = ''".
" ORDER BY ".$order." DESC".
"";

//echo $sqltt;

$sql = mysql_query("$sqltt");

  }
// zobraz hladanie vo vsetkych prijemkach
if ( $copern == 9 )
  {

$hladaj_nai = strip_tags($_REQUEST['hladaj_nai']);
$hladaj_dok = strip_tags($_REQUEST['hladaj_dok']);
$hladaj_dat = strip_tags($_REQUEST['hladaj_dat']);
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);

if ( $hladaj_nai != "" ) {

$chlad_nai = 1*$hladaj_nai;

if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
$sqltx = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" fak, dol, prf, str, zak, hod,".$chodu." strv, zakv".$citcbl.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" WHERE F$kli_vxcf"."_$tabl.uce $hladaj_ucep AND ( F$kli_vxcf"."_ico.nai LIKE '%$hladaj_nai%' OR F$kli_vxcf"."_$tabl.ico = $chlad_nai ) ".
" ORDER BY dok DESC".
"";

}

$sql = mysql_query("$sqltx");

                        }

if ( $hladaj_dat != "" ) {

$chladaj_dat=1*$hladaj_dat;
if( $chladaj_dat == 1 OR $chladaj_dat == 2 OR $chladaj_dat == 3 OR $chladaj_dat == 4 OR $chladaj_dat == 5 OR $chladaj_dat == 6 OR $chladaj_dat == 7 OR $chladaj_dat == 8 OR $chladaj_dat == 9 OR $chladaj_dat == 10 OR $chladaj_dat == 11 OR $chladaj_dat == 12 )
{ $hladaj_dat=$chladaj_dat.".".$kli_vrok; }

    if( strlen($hladaj_dat) == 6 OR strlen($hladaj_dat) == 7 )
         {
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" fak, dol, prf, str, zak, hod,".$chodu." strv, zakv".$citcbl.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" WHERE F$kli_vxcf"."_$tabl.uce $hladaj_ucep AND F$kli_vxcf"."_$tabl.ume = $hladaj_dat ".
" ORDER BY dok DESC".
"";
         }

    if( strlen($hladaj_dat) != 6 AND strlen($hladaj_dat) != 7 )
         {
         $datsql = SqlDatum($hladaj_dat);
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" fak, dol, prf, str, zak, hod,".$chodu." strv, zakv".$citcbl.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dodb".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dodb.dodb".
" WHERE F$kli_vxcf"."_$tabl.uce $hladaj_ucep AND F$kli_vxcf"."_$tabl.dat = '$datsql' ".
" ORDER BY dok DESC".
"";

         }

$sql = mysql_query("$sqltt");
}

if ( $hladaj_dok != "" ) {

$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, ".
" fak, dol, prf, str, zak, hod,".$chodu." F$kli_vxcf"."_ico.nai ".$citcbl.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ".
" ( F$kli_vxcf"."_$tabl.dok = '$hladaj_dok' OR F$kli_vxcf"."_$tabl.fak = '$hladaj_dok' OR F$kli_vxcf"."_$tabl.dol = '$hladaj_dok' )".
" ORDER BY dok DESC".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}

  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;

// pocet poloziek na stranu
$pols = 15;
if( $copern == 9 ) $pols = 900;

// pocet stran
$xstr = 1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;

// aktualna strana
$page = strip_tags($_REQUEST['page']);
// predchadzajuca strana
$ppage = $page - 1;
// nasledujuca strana
$npage = $page + 1;

// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

$hdrupoh=$drupoh;
if ( $rozuct == 'ANO' ) $hdrupoh=1*1000+$drupoh;

//searching period
if( $hladaj_dat == '' ) $hladaj_dat=$kli_vume;
$pole = explode(".", $hladaj_dat);
$mesiac_dat=1*$pole[0];
$rok_dat=1*$pole[1];
$mesiac_dap=$mesiac_dat-1;
if( $mesiac_dap == 0 ) $mesiac_dap=1;
$mesiac_dan=$mesiac_dat+1;
if( $mesiac_dan > 12 ) $mesiac_dan=12;
$kli_pume=$mesiac_dap.".".$rok_dat;
$kli_nume=$mesiac_dan.".".$rok_dat;
?>
<script>
function gotoPage()
{
  var chodna = document.forma3.page_goto.value;
  window.open('vstfak_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=4&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&page=' + chodna + '', '_self');
}
function navPage(chodna)
{
  window.open('vstfak_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&page=' + chodna + '', '_self');
}
</script>
<form name="formhl1" method="post" action="vstfak_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $hdrupoh; ?>&page=1&copern=9&rozuct=<?php echo $rozuct;?>&sysx=<?php echo $sysx;?>&hladaj_uce=<?php echo $hladaj_uce; ?>">
  <div class="mdl-layout__header-row ui-header-page-row">
    <span id="header_title" class="mdl-layout-title mdl-color-text--white dropdown">
<?php
if ( $drupoh == 1 OR $drupoh == 31 ) echo "OdberateæskÈ fakt˙ry";
if ( $drupoh == 2 ) echo "Dod·vateæskÈ fakt˙ry";
if ( $drupoh == 11 OR $drupoh == 12 ) echo "Dodacie listy";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "Vn˙tropodnikovÈ fakt˙ry";
if ( $drupoh == 42 ) echo "RegistraËn· pokladnica";
if ( $drupoh == 52 ) echo "Predfakt˙ry";
?>
<?php if ( $pocstav == 1 ) echo " - PoËiatoËn˝ stav"; ?></span>

<?php if ( $drupoh != 2 AND $drupoh != 42 ) {
if( $drupoh == 1 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 1 ) ORDER BY dodb"); }
if( $drupoh == 31 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 11 ) ORDER BY dodb"); }
if( $drupoh == 11 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 2 ) ORDER BY dodb"); }
if( $drupoh == 12 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 12 ) ORDER BY dodb"); }
if( $drupoh == 21 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 3 ) ORDER BY dodb"); }
if( $drupoh == 22 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 13 ) ORDER BY dodb"); }
if( $drupoh == 52 ) { $sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 14 ) ORDER BY dodb"); }
?>
  <select name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce; ?>" onchange="dajuce();" autofocus class="mdl-shadow--2dp select-btn">
<?php while($zaznam=mysql_fetch_array($sqls)): ?>
    <option value="<?php echo $zaznam["dodb"]; ?>">
<?php
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam['dodb']." - ".$poltxt; ?></option>
<?php endwhile; ?>
  </select>
<?php                                       } ?>
<?php if ( $drupoh == 2 ) {
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod WHERE ( drdo = 1 ) ORDER BY ucdo");
?>
  <select name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce; ?>" onchange="dajuce();" autofocus class="mdl-shadow--2dp select-btn">
<?php while($zaznam=mysql_fetch_array($sqls)): ?>
    <option value="<?php echo $zaznam["ddod"]; ?>">
<?php
$polmen = $zaznam["ndod"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam['ddod']." - ".$poltxt; ?></option>
<?php endwhile; ?>
  </select>
<?php                     } ?>
<?php if ( $drupoh == 42 ) {
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok WHERE ( drpk = 9 ) ORDER BY dpok");
?>
  <select name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce; ?>" onchange="dajuce();" autofocus class="mdl-shadow--2dp select-btn">
<?php while($zaznam=mysql_fetch_array($sqls)):?>
    <option value="<?php echo $zaznam["dpok"];?>" >
<?php
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam['dpok']." - ".$poltxt; ?></option>
<?php endwhile;?>
  </select>
<?php                      } ?>
  <div style="width: 16px;">&nbsp;</div>

<!-- month nav -->
  <button type="button" id="month_prev" onclick="navMonth(1);" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-color--light-blue-600 period-nav-btn">
    <i class="material-icons">navigate_before</i>
  </button>
    <span class="mdl-tooltip" data-mdl-for="month_prev">Prejsù na <?php echo $kli_pume; ?></span>

  <button type="button" id="month_next" onclick="navMonth(2);" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-color--light-blue-600 period-nav-btn">
    <i class="material-icons">navigate_next</i>
  </button>
    <span class="mdl-tooltip" data-mdl-for="month_next">Prejsù na <?php echo $kli_dume; ?></span>

<div style="visibility: hidden;">
<input type="text" name="hladaj_dok" id="hladaj_dok" value="<?php echo $hladaj_dok; ?>"/>
<input type="text" name="hladaj_dat" id="hladaj_dat" value="<?php echo $hladaj_dat; ?>"/>
<input type="text" name="hladaj_nai" id="hladaj_nai" value="<?php echo $hladaj_nai; ?>"/>
<INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù">
<a href="#" onclick="ResetHladanie();" title="Obnoviù" class="reset">Obnoviù</a>
</div>
  <div class="mdl-layout-spacer"></div>
  <button type="button" id="new_item" onclick="newItem(); window.name = 'zoznam';" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored" style="margin-left: 24px;">
    <i class="material-icons">add</i>
  </button>
    <span class="mdl-tooltip" data-mdl-for="new_item">Vytvoriù nov˙ fakt˙ru</span>



  <button type="button" id="header_more_tool" class="mdl-button mdl-js-button mdl-button--icon" style="margin-left: 12px;">
    <i class="material-icons">more_vert</i>
  </button>
    <span data-mdl-for="header_more_tool" class="mdl-tooltip">œalöie akcie</span>
  </div> <!-- .ui-header-page-row -->
<div id="Okno"></div> <!-- dopyt, chcem daù preË -->
</form>
<form name="formp2" method="post" action="../faktury/vstfak_md.php?drupoh=<?php echo $drupoh;?>&page=1&copern=55">
  <div class="mdl-layout__header-row wrap-ui-list">
    <table class="ui-list-header ui-list ui-container">
    <tr>
      <th>⁄Ëet</th>
      <th>Doklad -
<?php
if ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 2 ) echo "Fakt˙ra";
if ( $drupoh == 11 OR $drupoh == 12 ) echo "DodacÌ list";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "VNF";
if ( $drupoh == 42 ) echo "ËÌslo v dni";
if ( $drupoh == 52 ) echo "Predfakt˙ra";
?>
      </th>
      <th>D·tum
        <button id="searchbtn" class="mdl-button mdl-js-button mdl-button--icon" style="width: 24px; height: 24px; min-width: 24px; position: absolute; left: auto; top: 2px;">
          <i class="material-icons md-18">search</i>
        </button>


<?php if ( $drupoh == 1 OR $drupoh == 31 ) { ?>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
  <img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>"></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>"></a>
<?php } ?>

<?php if ( $drupoh == 11 OR $drupoh == 12 ) { ?>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>
&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>
&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<?php  } ?>

<?php if ( $drupoh == 21 OR $drupoh == 22 ) { ?>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<?php  } ?>

<?php if ( $drupoh == 2 ) { ?>
<!-- <a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a> -->
<?php  } ?>

<?php if ( $drupoh == 42 ) { ?>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<?php } ?>

<?php if ( $drupoh == 52 ) { ?>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
<a href="#" onClick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=9&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<?php   } ?>
      </th>
      <th>
<?php
if ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) echo "Odberateæ";
if ( $drupoh == 2 ) echo "Dod·vateæ";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "Odberateæ S - Z";
?>
      </th>
      <th>
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) echo "Str - Z·k";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "Dod·vateæ Str - Z·k";
if ( $drupoh == 42 ) echo "DKP";
?>
      </th>
      <th>
<?php
if ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 2 )
     {
if ( $sysx == 'UCT' AND $pocstav != 1 ) echo "⁄ËtovanÈ /";
     }
?>
<span style="font-weight:normal;">Hodnota</span>
      </th>
      <th>
<?php
if ( $drupoh == 1 OR $drupoh == 31 )
{
?>
        <input type="checkbox" name="uhradp" value="1"  onmouseover="UkazSkryj('Uhradiù v hotovosti<br />vybranÈ doklady<br />zaökrtnite a OK');" onmouseout="Okno.style.display='none';" onclick="document.formp2.pokl.disabled = false;">
        <INPUT type="submit" id="pokl" name="pokl" value="OK" />
        <!-- <button class="mdl-button mdl-js-button mdl-button--accent">Button</button> -->
<?php
}
?>
<?php
if ( $drupoh == 11 )
{
?>
        <input type="checkbox" name="dodfak" value="1" >
        <img src='../obr/ok.png' width=15 height=15 border=0 onclick="dodacieFak();" title="Vyfakt˙rovaù vybranÈ dodacie listy na jednu fakt˙ru ( maxim·lne 10 riadkov ), ak s˙hlasÌte ûaökrtnite checkbox" >
<script type="text/javascript">
    function dodacieFak()
    {
    var dodfak = 0;
    if( document.formp2.dodfak.checked ) var dodfak=1;
    var h_t10 = 0;
    <?php if( $cpol > 0 ) { echo "if( document.formp2.h_tl0.checked ) var h_t10=document.formp2.h_tl0.value;"; } ?>
    var h_t11 = 0;
    <?php if( $cpol > 1 ) { echo "if( document.formp2.h_tl1.checked ) var h_t11=document.formp2.h_tl1.value;"; } ?>
    var h_t12 = 0;
    <?php if( $cpol > 2 ) { echo "if( document.formp2.h_tl2.checked ) var h_t12=document.formp2.h_tl2.value;"; } ?>
    var h_t13 = 0;
    <?php if( $cpol > 3 ) { echo "if( document.formp2.h_tl3.checked ) var h_t13=document.formp2.h_tl3.value;"; } ?>
    var h_t14 = 0;
    <?php if( $cpol > 4 ) { echo "if( document.formp2.h_tl4.checked ) var h_t14=document.formp2.h_tl4.value;"; } ?>
    var h_t15 = 0;
    <?php if( $cpol > 5 ) { echo "if( document.formp2.h_tl5.checked ) var h_t15=document.formp2.h_tl5.value;"; } ?>
    var h_t16 = 0;
    <?php if( $cpol > 6 ) { echo "if( document.formp2.h_tl6.checked ) var h_t16=document.formp2.h_tl6.value;"; } ?>
    var h_t17 = 0;
    <?php if( $cpol > 7 ) { echo "if( document.formp2.h_tl7.checked ) var h_t17=document.formp2.h_tl7.value;"; } ?>
    var h_t18 = 0;
    <?php if( $cpol > 8 ) { echo "if( document.formp2.h_tl8.checked ) var h_t18=document.formp2.h_tl8.value;"; } ?>
    var h_t19 = 0;
    <?php if( $cpol > 9 ) { echo "if( document.formp2.h_tl9.checked ) var h_t19=document.formp2.h_tl9.value;"; } ?>


    if( dodfak == 1 )
          {
    window.open('presundod_fak.php?&copern=20&drupoh=<?php echo $drupoh;?>&tl10=' + h_t10 + '&tl11=' + h_t11 + '&tl12=' + h_t12 + '&tl13=' + h_t13 + '&tl14=' + h_t14 + '&tl15=' + h_t15 + '&tl16=' + h_t16 + '&tl17=' + h_t17 + '&tl18=' + h_t18 + '&tl19=' + h_t19 + '&tt=1', '_self')
          }

    }
  </script>
<?php
}
?>
      </th>
    </tr>
    </table> <!-- .ui-list-header -->
  </div>
</header>

<main class="mdl-layout__content ui-content sticky-footer">
<div class="wrap-ui-list">
  <table class="ui-list-content ui-list ui-container">
<?php
   while ( $i <= $konc )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
  <tr class="ui-row-echo">
    <td><label><?php echo $riadok->uce; ?></label></td>
    <td>
<?php if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 )
      {
$uctminusdok=$riadok->hodu-$riadok->hod;
  if ( $sysx == 'UCT' AND $kli_vduj >= 0 AND $pocstav != 1 ) {
?>
      <button type="button" id="account<?php echo $riadok->dok; ?>" onclick="accountItem(); window.name = 'zoznam';" class="mdl-button mdl-js-button mdl-button--icon" style="margin: 0;">
        <i class="material-icons">menu</i>
      </button>
        <span data-mdl-for="account<?php echo $riadok->dok; ?>" class="mdl-tooltip">Roz˙Ëtovanie dokladu</span>
<?php   } ?>
      <label style="position: relative; top: 1px;"><?php echo $riadok->dok; ?> -</label>
      <label id="dokfak<?php echo $riadok->dok; ?>" onclick="ListaFakUct(<?php echo $riadok->fak; ?>);" class="text-link" style="position: relative; top: 1px;"><?php echo $riadok->fak; ?></label>
        <span data-mdl-for="dokfak<?php echo $riadok->dok; ?>" class="mdl-tooltip">Zobraziù doklady s ËÌslom fakt˙ry <?php echo $riadok->fak; ?></span>
<?php if ( $uctminusdok != 0 AND $riadok->hod != 0 AND $sysx == 'UCT' AND $kli_vduj >= 0 AND $pocstav != 1 ) { ?>
      <i id="account_alert" class="material-icons md-18 mdl-color-text--red-500 vacenter">priority_high</i>
        <span data-mdl-for="account_alert" class="mdl-tooltip">Doklad nie je spr·vne roz˙Ëtovan˝</span>
<?php                                                                                                        } ?>
<?php
      }
if ( $drupoh == 11 OR $drupoh == 12 ) echo "$riadok->dok - $riadok->dol";
if ( $drupoh == 52 ) echo "$riadok->dok - $riadok->prf";
?>
    </td>
    <td>
      <label><?php echo $riadok->dat; ?></label>
<?php if ( $drupoh == 42 ) { ?>
<a href="#" onclick="uzavierka(<?php echo $riadok->dok;?>)" title="Rozpis dennej uz·vierky z <?php echo $riadok->dat; ?>">uzavierka</a>
<?php                      } ?>
    </td>
    <td>
<?php if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 52 ) { ?>
      <label id="dokico<?php echo $riadok->dok; ?>" onclick="ListaIcoUct(<?php echo $riadok->ico; ?>);" class="text-link"><?php echo $riadok->ico; ?></label>
        <span data-mdl-for="dokico<?php echo $riadok->dok; ?>" class="mdl-tooltip">Zobraziù doklady s iËo <?php echo $riadok->ico; ?></span>
      <label><?php echo $riadok->nai; ?></label>
<?php } ?>
<?php if ( $drupoh == 21 OR $drupoh == 22 ) echo "$riadok->nai - $riadok->str - $riadok->zak"; ?>
<?php if ( $drupoh == 42 ) echo "$riadok->nai"; ?>
    </td>
    <td>
      <label>
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 52 ) echo "$riadok->str - $riadok->zak";
if ( $drupoh == 21 OR $drupoh == 22 ) echo "$riadok->strv - $riadok->zakv";
if ( $drupoh == 42 ) echo $riadok->txp;
?>
      </label>
    </td>
    <td>
      <label>
<?php if ( $sysx == 'UCT' AND $pocstav != 1 ) { echo "$riadok->hodu / "; } ?><span style="color: rgba(0,0,0,.54);"><?php echo $riadok->hod; ?></span>
      </label>
    </td>
    <td>
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 31 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 52 )
     {
?>
      <button type="button" id="view<?php echo $riadok->dok; ?>" onclick="viewItem(<?php echo $riadok->dok; ?>);" class="mdl-button mdl-js-button mdl-button--icon mdl-layout--large-screen-only">
        <i class="material-icons">print</i>
      </button>
        <span data-mdl-for="view<?php echo $riadok->dok; ?>" class="mdl-tooltip">Zobraziù v PDF</span>
<?php
     }
?>
<?php
$ukazzmaz=1;
if( $drupoh == 42 ) { $nezar = 1*$riadok->ruc; }
if( $drupoh == 42 AND $nezar != 0 ) { $ukazzmaz = 0; }
if( $drupoh == 42 AND $kli_uzid == 17 ) { $ukazzmaz = 1; }
if( $drupoh == 42 AND $kli_uzid == 114 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ukazzmaz = 1; }
if( $copern != 10 AND $ukazzmaz == 1  )
{
?>
      <button type="button" id="edit<?php echo $riadok->dok; ?>" onclick="editItem(<?php echo $riadok->dok; ?>); window.name = 'zoznam';" class="mdl-button mdl-js-button mdl-button--icon mdl-layout--large-screen-only">
        <i class="material-icons">edit</i>
      </button>
        <span data-mdl-for="edit<?php echo $riadok->dok; ?>" class="mdl-tooltip">Upraviù</span>
<?php
}
?>
<?php if( $drupoh == 42 )  { ?>
      <a href="#" onClick="window.open('../doprava/regpok_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&sysx=<?php echo $sysx; ?>&cislo_dok=<?php echo $riadok->dok;?>&regpok=<?php echo $regpok;?>', '_blank', frame);"><img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu " ></a>
<?php                                                 } ?>
      <button type="button" id="more<?php echo $riadok->dok; ?>" class="mdl-button mdl-js-button mdl-button--icon">
        <i class="material-icons">more_vert</i>
      </button>
        <span data-mdl-for="more<?php echo $riadok->dok; ?>" class="mdl-tooltip">œalöie akcie</span>
        <ul for="more<?php echo $riadok->dok; ?>" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect tool-more-menu">
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 11 OR $drupoh == 31 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 52 ) { ?>
          <li onclick="viewItem(<?php echo $riadok->dok; ?>);" class="mdl-menu__item mdl-layout--small-screen-only">
            <i class="material-icons">print</i>Zobraziù v PDF
          </li>
<?php } ?>
<?php
$ukazzmaz=1;
if( $drupoh == 42 ) { $nezar = 1*$riadok->ruc; }
if( $drupoh == 42 AND $nezar != 0 ) { $ukazzmaz = 0; }
if( $drupoh == 42 AND $kli_uzid == 17 ) { $ukazzmaz = 1; }
if( $drupoh == 42 AND $kli_uzid == 114 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ukazzmaz = 1; }
if( $copern != 10 AND $ukazzmaz == 1  )
{
?>
          <li onclick="editItem(<?php echo $riadok->dok; ?>); window.name = 'zoznam';" class="mdl-menu__item mdl-layout--small-screen-only">
            <i class="material-icons">edit</i>Upraviù
          </li>
<?php
}
?>
<?php if ( $copern != 10 AND $ukazzmaz == 1 AND $kli_nemazat != 1 ) { ?>
          <li onclick="removeItem(<?php echo $riadok->dok; ?>);" class="mdl-menu__item">
            <i class="material-icons">remove</i>Vymazaù
          </li>
<?php } ?>
<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.pdf"))
{
$jesub=1;
?>
          <li onclick="window.open('../dokumenty/FIR<?php echo $kli_vxcf; ?>/<?php echo $adrdok; ?>/d<?php echo $riadok->dok; ?>.pdf', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">picture_as_pdf</i>Zobraziù origin·l v PDF
          </li>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.jpg") AND $jesub == 0 )
{
$jesub=1;
?>
          <li onclick="window.open('../dokumenty/FIR<?php echo $kli_vxcf; ?>/<?php echo $adrdok; ?>/d<?php echo $riadok->dok; ?>.jpg', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">photo_library</i>Zobraziù origin·l v JPG
          </li>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.bmp") AND $jesub == 0 )
{
$jesub=1;
?>
          <li onclick="../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.bmp', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">photo_library</i>Zobraziù origin·l v BMP
          </li>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.gif") AND $jesub == 0 )
{
$jesub=1;
?>
          <li onclick="../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.gif', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">photo_library</i>Zobraziù origin·l v GIF
          </li>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.png") AND $jesub == 0 )
{
$jesub=1;
?>
          <li onclick="window.open('../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.png', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">photo_library</i>Zobraziù origin·l v PNG
          </li>
<?php
}
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/dd$riadok->dok.pdf"))
{
$jesub=1;
?>
          <li onclick="window.open('../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/dd<?php echo $riadok->dok;?>.pdf', '_blank', frame);" class="mdl-menu__item">
            <i class="material-icons">picture_as_pdf</i>Zobraziù origin·l v PDF
          </li>
<?php
}
?>
        </ul>
<?php if ( ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 31 ) AND $pocstav != 1 ) { ?>
      <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" style="padding: 0; width: 24px; position: relative; top: 1px;">
        <input type="checkbox" name="h_tl<?php echo $i; ?>" value="<?php echo $riadok->dok; ?>" class="mdl-checkbox__input">
      </label>
<?php                                                            } ?>
    </td>
  </tr>
<?php
  }
$i = $i + 1;
   }
?>
  </table> <!-- .ui-list-content -->
</form>
<form name="forma3" method="post" action="#">
  <div class="ui-list-footer ui-list ui-container">
    <span>= <?php echo $cpol; ?></span>
    <div class="mdl-layout-spacer"></div>
    <label for="page_goto" style="margin-right: 24px;">Strana
    <select name="page_goto" id="page_goto" onchange="gotoPage();" class="mdl-textfield__input">
<?php
$is = 1;
while ( $is <= $xstr )
{
?>
<option value="<?php echo $is; ?>"><?php echo $is; ?></option>
<?php
$is = $is + 1;
}
?>
    </select>/&nbsp;&nbsp;<?php echo $xstr; ?></label>
    <button type="button" id="page_prev" onclick="navPage(<?php echo $ppage; ?>);" class="mdl-button mdl-js-button mdl-button--icon">
      <i class="material-icons">navigate_before</i>
    </button>
      <span class="mdl-tooltip" data-mdl-for="page_prev">Prejsù na stranu <?php echo $ppage; ?></span>
    <button type="button" id="page_next" onclick="navPage(<?php echo $npage; ?>);" class="mdl-button mdl-js-button mdl-button--icon">
      <i class="material-icons">navigate_next</i>
    </button>
      <span class="mdl-tooltip" data-mdl-for="page_next">Prejsù na stranu <?php echo $npage; ?></span>
  </div> <!-- .ui-list-footer -->
</form>
</div> <!-- .wrap-ui-list -->
<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,7,9
?>



<span id="Zm" style="display:none; width:100%; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Doklad DOK=<?php echo $cislo_dok;?> vymazan˝</span>

<div class="mdl-layout-spacer"></div>
<footer class="mdl-mini-footer ui-container">
  <div class="mdl-mini-footer__left-section">
    <div class="mdl-logo mdl-color-text--grey-500">© 2017 EuroSecom</div>
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="News();" title="Novinky v EuroSecom" class="mdl-color-text--light-blue-500">Novinky</a></li>
    </ul>
  </div>
  <div class="mdl-mini-footer__right-section">
    <ul class="mdl-mini-footer__link-list">
      <li><a href="#" onclick="Edcom();" title="EuroSecom powered by EDcom" class="mdl-color-text--light-blue-500">EDcom</a></li>
    </ul>
  </div>
</footer>
</main>

<!-- empty state -->
<?php if ( $cpol == 0 ) { ?>
<div class="ui-no-item">
  <i class="material-icons mdl-color-text--grey-400 md-64">sentiment_dissatisfied</i>
  <div class="mdl-color-text--grey-500" style="padding-top: 32px;">éiadne poloûky</div>
</div>
<?php                   } ?>

<!-- header nav menu -->
<div style="position:fixed; left: 0px; top: -24px; z-index: 10;">
  <ul for="header_title" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
<?php if ( $drupoh == 1 OR $drupoh == 31 ) { ?>
    <li class="mdl-menu__item mdl-color-text--light-blue-600" onclick="OdberFa();">OdberateæskÈ fakt˙ry</li>
    <li class="mdl-menu__item" onclick="OdberUcty();">OdberateæskÈ ˙Ëty</li>
<?php } ?>
<?php if ( $drupoh == 2 ) { ?>
    <li class="mdl-menu__item mdl-color-text--light-blue-600" onclick="DodavFa();">Dod·vateæskÈ fakt˙ry</li>
    <li class="mdl-menu__item" onclick="DodavUcty();">Dod·vateæskÈ ˙Ëty</li>
<?php } ?>
  </ul>
</div>



<div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Title</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
      <a class="mdl-navigation__link" href="">Link</a>
    </nav>
  </div>

<!-- more header tools -->
<div style="position:fixed; right: 0; top: 0; z-index: 10;">
  <ul for="header_more_tool" class="mdl-menu mdl-menu--bottom-right mdl-js-menu tool-more-menu">
<?php if ( ( $drupoh == 1 OR $drupoh == 2 ) AND $pocstav != 1 ) { ?>
    <li onclick="listFaktury();" class="mdl-menu__item">
      <i class="material-icons">print</i>Zobraziù fakt˙ry za <strong><?php echo $kli_vume; ?></strong>
    </li>
<?php if ( $sysx == 'UCT' ) { ?>
    <li onclick="listFakturyUct();" class="mdl-menu__item mdl-menu__item--full-bleed-divider">
      <i class="material-icons">print</i>Zobraziù fakt˙ry s roz˙Ëtov. za <?php echo $kli_vume; ?>
    </li>
<?php                       } ?>
<?php } ?>
<?php if ( $drupoh == 1 AND $pocstav != 1 ) { ?>
    <li onclick="ExportFakturyCsv();" class="mdl-menu__item" >
      <i class="material-icons">file_upload</i>Exportovaù fakt˙ry <?php echo $kli_vume; ?> do CSV
    </li>
<?php                                       } ?>
<?php if ( $drupoh == 2 ) { ?>
    <li onclick="window.open('vstf_importorangexml.php?copern=1&drupoh=<?php echo $drupoh; ?>&page=1&cislo_uce=<?php echo $hladaj_uce; ?>', '_self');" class="mdl-menu__item">
      <i class="material-icons">file_download</i>NaËÌtaù Orange fakt˙ry
    </li>
    <li onclick="window.open('vstf_importfakxml.php?copern=1&drupoh=<?php echo $drupoh; ?>&page=1&cislo_uce=<?php echo $hladaj_uce; ?>', '_self');" class="mdl-menu__item">
      <i class="material-icons">file_download</i>NaËÌtaù fakt˙ry v XML
    </li>
<?php } ?>
<?php if ( ( $drupoh == 2 OR $drupoh == 1 OR $drupoh == 12 ) AND $pocstav == 1 AND $kli_uzall > 3000 ) { ?> <!-- dopyt, $drupoh zbytoËnÈ, alebo aj tam je poËiatoËn˝ stav -->
    <li class="mdl-menu__item" onclick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=167&page=1&drupoh=<?php echo $drupoh; ?>&pocstav=<?php echo $pocstav; ?>', '_self');">
      <i class="material-icons vacenter">cancel</i>Vöetky poloûky
    </li> <!-- dopyt, pred vymazanÌm op˝taù -->
    <li class="mdl-menu__item" onclick="window.open('../faktury/vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=155&page=1&drupoh=<?php echo $drupoh; ?>&pocstav=<?php echo $pocstav; ?>', '_self');">
      <i class="material-icons vacenter">file_download</i>⁄daje v TXT
    </li>
<?php      } ?>

<?php if ( $drupoh == 22 AND $fir_fico == '31419623' ) { ?>
    <li class="mdl-menu__item" onclick="window.open('../doprava/vnfpdf.php?copern=10&page=1&drupoh=22', '_blank', frame);">
      <i class="material-icons vacenter">print</i>Vn˙tropod. fakt. <?php echo $kli_vume; ?>
    </li>
    <li class="mdl-menu__item" onclick="window.open('vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=267&page=1&drupoh=22', '_self');">
      <i class="material-icons vacenter">cancel</i>Vn˙tropod. fakt. <?php echo $kli_vume; ?>
    </li> <!-- dopyt, pred vymazanÌm op˝taù -->
<?php } ?>

<?php
  if ( $drupoh == 42 )
  {
$ajmes=0;
?>
<a href="#" title="KÛpia poslednÈho pokladniËnÈho dokladu" onClick="window.open('../doprava/regpok_pdf.php?copern=490&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">kPD
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="KÛpia poslednÈho pokladniËnÈho dokladu" ></a>
<a href="#" title="KÛpia poslednej dennej uz·vierky" onClick="window.open('../doprava/regpok_pdf.php?copern=290&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">kDU
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="KÛpia poslednej dennej uz·vierky" ></a>
<?php if( $ajmes == 1 ) { ?>
<a href="#" title="KÛpia poslednej mesaËnej uz·vierky" onClick="window.open('../doprava/regpok.php?copern=390&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">kMU
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="KÛpia poslednej mesaËnej uz·vierky" ></a>
<?php                   } ?>
<a href="#" title="Nastavenie registraËnej pokladnice" onClick="window.open('../doprava/regpok.php?copern=1&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">Set
<img src='../obr/naradie.png' width=20 height=15 border=0 title="Nastavenie registraËnej pokladnice" ></a>


<a href="#" title="TlaË dennej uz·vierky" onClick="window.open('../doprava/regpok_pdf.php?copern=200&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">DU
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="TlaË dennej uz·vierky" ></a>
<?php if( $ajmes == 1 ) { ?>
<a href="#" title="TlaË mesaËnej uz·vierky" onClick="window.open('../doprava/regpok.php?copern=300&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">MU
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="TlaË mesaËnej uz·vierky" ></a>
<?php                   } ?>
<a href="#" title="TlaË priebeûnej uz·vierky" onClick="window.open('../doprava/regpok_pdf.php?copern=400&page=1&drupoh=42', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">PU
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="TlaË priebeûnej uz·vierky" ></a>
<?php
     }
?>
  </ul>
</div> <!-- more header tools -->




</div> <!-- .mdl-layout -->
<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami
     }







// celkovy koniec dokumentu
       } while (false);
?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<SCRIPT Language="JavaScript" Src="../js/cookies.js"></SCRIPT>
<script type="text/javascript">
//dimensions blank window
var frame = 'scrollbars=yes, resizable=yes, top=0, left=0, width=1080, height=900';

//month nav
  function navMonth(kam)
  {
    window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64; ?>&copern=' + kam + '', '_self');
  }
<?php if ( $kli_vmes == 1 ) { ?> document.getElementById('month_prev').disabled = true; <?php } ?>
<?php if ( $kli_vmes == 12 ) { ?> document.getElementById('month_next').disabled = true; <?php } ?>



























      function dajuce()
      {

  var ucet = document.formhl1.hladaj_uce.value;
<?php if( $sysx != 'UCT' ) { ?>
  window.open('vstfak_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_uce=' + ucet + '&drupoh=<?php echo 2*1000+$drupoh;?>&page=1&copern=1', '_self');
<?php                      } ?>
<?php if( $sysx == 'UCT' ) { ?>
  window.open('vstfak_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_uce=' + ucet + '&drupoh=<?php echo 1*1000+$drupoh;?>&page=1&copern=1', '_self');
<?php                      } ?>
      }


//funkcia na zobrazenie popisu
    function UkazSkryj (text) //dopyt, keÔ pÙjde preË tlaËÌtko tak aj toto
    {
<?php if( $_SESSION['nieie'] == 0 )  { ?>
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
<?php                                } ?>
    }



<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
//    document.formhl1.hladaj_nai.focus();
<?php if ( $copern != 10 AND ( $drupoh == 1 OR $drupoh == 31 ) ) echo "document.formp2.pokl.disabled = true;"; ?>
    }

<?php
  }
//koniec hladania
?>

<?php
//hladanie
  if ( $copern == 9 )
  {
?>
    function VyberVstup()
    {
   document.forma3.page_goto.value = '<?php echo "$page"; ?>';
    }

    function ObnovUI()
    {
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
<?php if ( $copern != 10 AND ( $drupoh == 1 OR $drupoh == 31 ) ) echo "document.formp2.pokl.disabled = true;"; ?>
    }

<?php
  }
//koniec hladania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 10 )
  {
?>


    function VyberVstup()
    {
//   document.formhl1.hladaj_uce.focus();
   document.forma3.page_goto.value = '<?php echo "$page"; ?>';
    }

    function ObnovUI()
    {
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
<?php if ( $copern != 10 AND ( $drupoh == 1 OR $drupoh == 31 ) ) echo "document.formp2.pokl.disabled = true;"; ?>

//    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
//    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>

//empty state
<?php if ( $cpol == 0 ) { ?>
   document.querySelector('.ui-content > .wrap-ui-list').style.display='none';
<?php                   } ?>

//pagination
   document.forma3.page_goto.value = '<?php echo "$page"; ?>';
<?php if ( $page == 1 ) { ?>
   document.forma3.page_prev.disabled = true;
<?php } ?>
<?php if ( $page == $xstr ) { ?>
   document.forma3.page_next.disabled = true;
<?php } ?>

    }
<?php
  }
?>


  function listFaktury()
  {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
    var ucet = document.formhl1.hladaj_uce.value;
<?php if ( $drupoh == 1 ) { ?>
    window.open('../ucto/zozdok.php?copern=101&drupoh=1&page=1&cislo_uce=' + ucet + '&hladaj_dok=' + hladaj_dok + '&page=1', '_blank', frame);
<?php                     } ?>
<?php if ( $drupoh == 2 ) { ?>
    window.open('../ucto/zozdok.php?copern=102&drupoh=2&page=1&cislo_uce=' + ucet + '&hladaj_dok=' + hladaj_dok + '&page=1', '_blank', frame);
<?php                     } ?>
  }
  function listFakturyUct()
  {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
    var ucet = document.formhl1.hladaj_uce.value;
<?php if ( $drupoh == 1 ) { ?>
    window.open('../ucto/rozdok.php?copern=101&drupoh=1&page=1&cislo_uce=' + ucet + '&hladaj_dok=' + hladaj_dok + '&page=1&tlacitR=1', '_blank', frame);
<?php                     } ?>
<?php if ( $drupoh == 2 ) { ?>
    window.open('../ucto/rozdok.php?copern=102&drupoh=2&page=1&cislo_uce=' + ucet + '&hladaj_dok=' + hladaj_dok + '&page=1&tlacitR=1', '_blank', frame);
<?php                     } ?>
  }











  function viewItem(doklad)
  {
   var hladaj_dok = document.formhl1.hladaj_dok.value;
   var hladaj_dok = document.formhl1.hladaj_dok.value;
   var cislo_dok = doklad;
   window.open('vstf_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=<?php echo $drupoh; ?>&page=<?php echo $page; ?>&cislo_dok=' + cislo_dok + '&fff=1', '_blank', param);
  }

  function editItem(doklad)
  {
<?php if( $fir_xfa01 == 1 ) { ?>
   window.open('vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=' + doklad + '&h_fak=<?php echo $riadok->fak;?>&h_dol=<?php echo $riadok->dol;?>&h_prf=<?php echo $riadok->prf;?>', '_self');
<?php } ?>

<?php if( $fir_xfa01 == 2 ) { ?>
   window.open('vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT&cislo_dok=' + doklad + '&h_fak=<?php echo $riadok->fak;?>&h_dol=<?php echo $riadok->dol;?>&h_prf=<?php echo $riadok->prf;?>', '_self');
<?php } ?>
  }

      function removeItem(doklad)
      {
        var ucet = document.formhl1.hladaj_uce.value;
<?php if( $fir_xfa01 != 2 ) { ?>
  window.open("vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&cislo_dok=" + doklad + "&copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=" + ucet + "&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT", "_self");
<?php } ?>
<?php if( $fir_xfa01 == 2 ) { ?>
  window.open("vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&cislo_dok=" + doklad + "&copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=" + ucet + "&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT", "_self");
<?php } ?>

      }

  function newItem()
  {
   window.open('vstf_u_md.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=5&drupoh=<?php echo $drupoh; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&page=1', '_self'); //dopyt, "page=1" d·m preË
  }

  function accountItem()
  {
    window.open('../faktury/vstf_t.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh; ?>&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $riadok->dok; ?>&h_ico=<?php echo $riadok->ico; ?>&h_uce=<?php echo $riadok->uce; ?>&h_unk=<?php echo $riadok->unk; ?>&h_poh=<?php echo $riadok->poh; ?>', '_blank');
  }






<?php if ( $agrostav == 1 OR $_SERVER['SERVER_NAME'] == "localhost" )  { ?>
    function VytlacPokl(doklad)
    {
    var cislo_dok = doklad;
    window.open('pokldok_pdf.php?cislo_dok=' + cislo_dok + '&fff=1', '_blank', frame);
    }
<?php                        } ?>

<?php if ( $drupoh == 42 )  { ?>
    function uzavierka(doklad)
    {
    var cislo_dok = doklad;
    window.open('../doprava/regpok_rozpis.php?cislo_dok=' + cislo_dok + '&fff=1&regpok=<?php echo $regpok;?>', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }
<?php                       } ?>


function ExportFakturyCsv()
                {

window.open('../faktury/int_fakt.php?copern=55&page=1&h_sys=85&h_obdp=<?php echo $kli_vmes; ?>&drupoh=1&uprav=1&docsv=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }


//header title nav
  function OdberFa()
  {
    window.open('../faktury/vstfak_md.php?copern=1&drupoh=1001&page=1&pocstav=0', '_self');
  }
  function DodavFa()
  {
    window.open('../faktury/vstfak_md.php?copern=1&drupoh=1002&page=1&pocstav=0', '_self');
  }
  function OdberUcty()
  {
    window.open('../faktury/dodb_md.php?copern=1&page=1', '_self');
  }
  function DodavUcty()
  {
    window.open('../faktury/ddod_md.php?copern=1&page=1', '_self');
  }


  function ListaFakUct(faktura)
  {
   var h_fak = faktura;
   window.open('../ucto/hladaj_fakicotlac.php?&h_fak=' + h_fak + '&h_datp=01.01.1990&h_datk=31.12.2050&copern=31&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
  function ListaIcoUct(ico)
  {
   var h_ico = ico;
   window.open('../ucto/hladaj_fakicotlac.php?&h_ico=' + h_ico + '&h_datp=01.01.1990&h_datk=31.12.2050&copern=31&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


  </script>
</body>
</html>