<?PHP
session_start();
$_SESSION['ucto_sys'] = 1;
$_SESSION['pocstav'] = 0;
?>

<HTML>
<?php

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$newmenu = 1*$_REQUEST['newmenu'];
if( $_SESSION['chrome'] == 0 ) { $newmenu = 0; }
if( $_SESSION['nieie'] == 1 ) { $newmenu = 1; }
$copern = 1*$_REQUEST['copern'];
$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'UCT';
$urov = 2000;
$cslm = 1;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite v�etky okn� v prehliada�i IE a prihl�ste sa znovu pros�m do IS, ak ste pou��vali Cestovn� pr�kazy"; exit; }
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
$dtb2 = include("oddel_dtb1.php");

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}

$firs = 1*$_REQUEST['firs'];
$umes = 1*$_REQUEST['umes'];

// zmena firmy
if ( $copern == 25 OR $copern == 23 )
     {

//ak zmena firmy nastav umes podla kli_vrok vo firme
if ( $copern == 23 )
     {
$sqlmax = mysql_query("SELECT * FROM $mysqldbfir.fir WHERE xcf=$firs");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $umes="1.".$riadmax->rok;
  }
     }

$query="START TRANSACTION;"; 
$trans = mysql_query($query);

$zmazane = mysql_query("DELETE FROM $mysqldbfir.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldbfir.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
if ( $ulozene )
{
$query="COMMIT;";
$trans = mysql_query($query);
}
if ( !$ulozene )
{
$query="ROLLBACK;";
$trans = mysql_query($query);
}
     }

$cit_nas = include("cis/citaj_nas.php");

$cook=0;
if( $cook == 1 )
    {
setcookie("kli_vxcf", $vyb_xcf, time() + (7 * 24 * 60 * 60));
setcookie("kli_nxcf", $vyb_naz, time() + (7 * 24 * 60 * 60));
setcookie("kli_vume", $vyb_ume, time() + (7 * 24 * 60 * 60));
setcookie("kli_vrok", $vyb_rok, time() + (7 * 24 * 60 * 60));
    }
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

  $kli_vduj=$_SESSION['kli_vduj'];

$dtb2 = include("oddel_dtb2.php");

//echo $vyb_rok;
//echo $mysqldbdata;
//exit;

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$cvybxcf=1*$vyb_xcf;
if( $cvybxcf > 0 )
          {
//len ak je vybrana firma
//echo "<br /><br /><br /><br /><br />idem";

$sql = "SELECT zmen FROM ".$mysqldbdata.".F$vyb_xcf"."_uctvsdh";
if( $copern == 1 OR $copern == 25 )
{
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok):
$kli_vxcf=$vyb_xcf;
  mysql_select_db($mysqldbdata);
$kalend = include("ucto/vtvuct.php");
endif;
}

$sql = "SELECT c01 FROM ".$mysqldbdata.".F$vyb_xcf"."_uctcrv2009";
$vysledok = mysql_query($sql);
if (!$vysledok){

if( $vyb_rok > 2008 AND $vyb_duj != 9 )
{
$sqlt = <<<uctcrv
(
   uce          VARCHAR(11),
   c01          INT
);
uctcrv;

$vsql = 'CREATE TABLE F'.$vyb_xcf.'_uctcrv2009'.$sqlt;
$vytvor = mysql_query("$vsql");

$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=crv+1 WHERE crv > 20"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=crv+1 WHERE crv > 46"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=crv+1 WHERE crv > 53"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=crv+1 WHERE crv > 58"; $oznac = mysql_query("$sqtoz");
}
               }


$sql = "SELECT c01 FROM ".$mysqldbdata.".F$vyb_xcf"."_uctcrs2009";
$vysledok = mysql_query($sql);
if (!$vysledok){

if( $vyb_rok > 2008 AND $vyb_duj != 9 )
{
$sqlt = <<<uctcrs
(
   uce          VARCHAR(11),
   c01          INT
);
uctcrs;

$vsql = 'CREATE TABLE F'.$vyb_xcf.'_uctcrs2009'.$sqlt;
$vytvor = mysql_query("$vsql");

$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs-1 WHERE crs > 1"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 61"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 63"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 71"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 92"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 119"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=crs+1 WHERE crs > 121"; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=72 WHERE LEFT(uce,3) = 353"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=118 WHERE LEFT(uce,3) = 231 OR LEFT(uce,3) = 232 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=117 WHERE LEFT(uce,3) = 461"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crs=115 WHERE LEFT(uce,3) = 241 OR LEFT(uce,3) = 249 "; $oznac = mysql_query("$sqtoz");
}
               }


//uprava druhov DPH od 1.1.2010 
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp2009 SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=crz+2 WHERE crz > 9 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crd=crd+2 WHERE crd > 10 ";
$vysledek = mysql_query("$sql");

     }

$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew_g";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew".$sqlt;
$vysledek = mysql_query("$sql");
}
//uprava druhov DPH od 1.1.2010


//oprava druhov DPH od 1.1.2010
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew_g";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew_f";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=0, crd=22 WHERE rdp = 30 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=0, crd=23 WHERE rdp = 29 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=11, crd=21 WHERE rdp = 37 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=7, crd=21 WHERE rdp = 39 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=0, crd=12 WHERE rdp = 87 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=0, crd=8 WHERE rdp = 89 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=1, crd=2 WHERE rdp = 60 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=3, crd=4 WHERE rdp = 59 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=16, crd=0 WHERE rdp = 51 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp SET crz=16, crd=0 WHERE rdp = 61 ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp WHERE rdp = 62 OR rdp = 63 ";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '62', 'Da� na v�stupe V�VOZ SLU�BY EU DPH00% ', '0', '16', '0', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '63', 'Da� na v�stupe V�VOZ TROJSTRANN� DPH00% ', '0', '16', '0', '0', '0' )";
$ttqq = mysql_query("$ttvv");
     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdphnew_g".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec oprava druhov DPH od 1.1.2010

//oprava uctova osnova od 1.1.2010
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctosnovanew_b";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctosnovanew_a";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2010 )
     {

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=0, crs=56 WHERE uce = 21100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=0, crs=57 WHERE uce = 22100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=0, crs=48 WHERE uce = 31100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=0, crs=106 WHERE uce = 32100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=9, crs=0 WHERE uce = 50100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=2, crs=0 WHERE uce = 50400 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=5, crs=0 WHERE uce = 60100 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctosnova SET crv=1, crs=0 WHERE uce = 60400 AND crv = 1 AND crs = 1 ";
$vysledek = mysql_query("$sql");
     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctosnovanew_b".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec oprava uctova osnova od 1.1.2010

//ak neexistuje uctpohyby2010 tak ju vytvor
$sql = "SELECT * FROM uctpohyby2010";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "CREATE TABLE uctpohyby2010 SELECT * FROM uctpohyby ";
$vysledek = mysql_query("$sql");

}
//koniec ak neexistuje uctpohyby2010 tak ju vytvor

//oprava druhov DPH od 1.1.2011
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdph11new_b";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdph11new_a";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2011 )
     {
$ttvv = "DELETE FROM ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp WHERE ( rdp = 25 OR rdp = 35 OR rdp = 34 OR rdp = 55 OR rdp = 65 OR rdp = 85 OR rdp = 84 OR rdp = 45 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '25', 'Da� na vstupe  TUZEMSKO DPH20%  ', '20', '0', '23', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '35', 'Da� na vstupe  DOVOZ EU DPH20% n�kup v EU  ', '20', '7', '21', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '34', 'Da� na vstupe  DOVOZ EU DPH20% slu�by v EU  ', '20', '11', '21', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '55', 'Da� na v�stupe TUZEMSKO DPH20% ', '20', '3', '4', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '65', 'Da� na v�stupe V�VOZ DPH20% ', '20', '3', '4', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '85', 'Da� na v�stupe DOVOZ EU DPH20% n�kup v EU ', '20', '0', '8', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '84', 'Da� na v�stupe DOVOZ EU DPH20% slu�by v EU ', '20', '0', '12', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO ".$mysqldbdata.".F$vyb_xcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '45', 'Da� na vstupe DOVOZ 3k DPH20%  ', '20', '0', '25', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");

     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctdph11new_b".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec oprava druhov DPH od 1.1.2011

//oprava Robotpohybov od 1.1.2011
$sql = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_uctrobot11new_b";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctrobot11new_a";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_rok == 2011 )
     {
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=25 WHERE dzk2 = 29 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=35 WHERE dzk2 = 39 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=34 WHERE dzk2 = 37 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=45 WHERE dzk2 = 49 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=55 WHERE dzk2 = 59 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=65 WHERE dzk2 = 69 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=85 WHERE dzk2 = 89 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE ".$mysqldbdata.".F$vyb_xcf"."_uctpohyby SET dzk2=84 WHERE dzk2 = 87 "; $ttqq = mysql_query("$ttvv");

$ttvv = "UPDATE uctpohyby SET dzk2=25 WHERE dzk2 = 29 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=35 WHERE dzk2 = 39 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=34 WHERE dzk2 = 37 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=45 WHERE dzk2 = 49 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=55 WHERE dzk2 = 59 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=65 WHERE dzk2 = 69 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=85 WHERE dzk2 = 89 "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE uctpohyby SET dzk2=84 WHERE dzk2 = 87 "; $ttqq = mysql_query("$ttvv");

     }

$sql = "CREATE TABLE ".$mysqldbdata.".F$vyb_xcf"."_uctrobot11new_b".$sqlt;
$vysledek = mysql_query("$sql");
}
//koniec oprava Robotpohybov od 1.1.2011

          }
//len ak je vybrana firma

//cleaning
$datdnessql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$jeclean=0;
$poslhh = "SELECT * FROM ".$mysqldbdata.".cleaningtmp WHERE dat='$datdnessql' ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $jeclean = 1*mysql_num_rows($posl); }
if( $jeclean == 0 )
{
$copernx="alibaba40";
//echo "idem";
$clean = include("funkcie/subory.php");
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Finan�n� ��tovn�ctvo Hl.menu</title>
<style type="text/css">
  a:link, a:visited {text-decoration: none; color: black;}
  a:hover {text-decoration: underline; background-color: #ffff90; }
<?php if( $newmenu == 0 ) { ?>
  @import url(css/skryvanemenu.css);
<?php                     } ?>
</style>
<?php if( $newmenu == 0 ) { ?>
<script type="text/javascript" src="js/cskryvanemenu.js" > </script>
<?php                     } ?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-90;

<?php if( $newmenu == 0 ) { ?>

  // PRVE MENU
  var M1 = new CSkryvaneMenu("M1", 350);
  M1.NovaPolozka
  ( "Kniha odberate�sk�ch fakt�r",
    "OtvorOdber()",
    "Kniha odberate�sk�ch fakt�r, vytvorenie novej , oprava, vymazanie ulo�enej"
  );
  M1.NovaPolozka
  ( "Kniha dod�vate�sk�ch fakt�r",
    "OtvorDodav()",
    "Kniha dod�vate�sk�ch fakt�r"
  );
  M1.NovaPolozka
  ( "Pr�jmov� pokladni�n� doklad",
    "Otvorppri()",
    "Pr�jmov� pokladni�n� doklad - �hrada odberate�skej fakt�ry"
  );
  M1.NovaPolozka
  ( "V�davkov� pokladni�n� doklad",
    "Otvorpvyd()",
    "V�davkov� pokladni�n� doklad - �hrada dod�vate�skej fakt�ry"
  );
  M1.NovaPolozka
  ( "Bankov� v�pis",
    "Otvorbank()",
    "Bankov� v�pis - nahr�vanie"
  );
  M1.NovaPolozka
  ( "V�eobecn� ��tovn� doklady",
    "Otvorvseo()",
    "V�eobecn� ��tovn� doklady - nahr�vanie"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 350);
  M2.NovaPolozka
  ( "Vytvorenie mesa�n�ch ��tovn�ch zost�v",
    "meszos()",
    "Vytvorenie mesa�n�ch ��tovn�ch zost�v - V�kaz ziskov, S�vaha, Obratov� predvaha, Zostavy DPH...."
  );
  M2.NovaPolozka
  ( "�tatistika a v�kazn�ctvo",
    "sttzos()",
    "Vytvorenie �tatistick�ch, �tvr�ro�n�ch a ro�n�ch v�kazov a preh�adov...."
  );
  M2.NovaPolozka
  ( "Preh�ady a �pravy d�t z podsyst�mov",
    "oprsys()",
    "Preh�ady, �pravy a mazanie d�t prenesen�ch automatick�m ��tovan�m z podsyst�mov...."
  );
  M2.NovaPolozka
  ( "Priznanie k dani z pr�jmov",
    "danprij()",
    "Vytvorenie priznania k dani z pr�jmov a pr�loh k priznaniu...."
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 350);
  M3.NovaPolozka
  ( "Odberate�sk� a dod�vate�sk� Saldokonto",
    "saldo()",
    "Zoznamy odberate�sk�ch a dod�vate�sk�ch fakt�r a �hrad za I�O, ��et, obdobie...."
  );
  M3.NovaPolozka
  ( "V�pis ��tovn�ch pohybov",
    "uctpohyby()",
    "V�pis ��tovn�ch pohybov za syntetick� alebo analytick� ��ty"
  );
  M3.NovaPolozka
  ( "Preh�ad�vanie dokladov",
    "hladaj_doklad()",
    "Vyh�ad�vanie v dokladoch pod�a textu, ��sla ��tu, fakt�ry, I�O, d�tumu, strediska, z�kazky......"
  );
  M3.NovaPolozka
  ( "��ty veden� v cudz�ch men�ch",
    "Cudzie()",
    "Pokladnice,Bankov� ��ty,Poh�ad�vky,Z�v�zky a �al�ie ��ty veden� v cudz�ch men�ch...."
  );
  M3.NovaPolozka
  ( "Upomienka, pen�le odberate�sk�ch fakt�r",
    "Upomienka()",
    "Vytvorenie PDF alebo e-mailovej upomienky alebo penaliz�cie odberate�sk�ch fakt�r nezaplaten�ch po lehote splatnosti"
  );
  M3.NovaPolozka
  ( "Pr�kaz na �hradu dod�v.fakt�r",
    "Priku()",
    "Pr�kaz na �hradu dod�vate�sk�ch fakt�r"
  );
  M3.NovaPolozka
  ( "Ru�n� sp�rovanie a opravy saldokonta",
    "Rucnespar()",
    "Ru�n� sp�rovanie fakt�r a �hrad, ktor� nemaj� rovnak� var.symbol a in� opravy saldokonta"
  );
  M3.NovaPolozka
  ( "Vz�jomn� z�po�et odber. a dodav. fakt�r",
    "Vzajomny()",
    "Vytvorenie vz�jomn�ho z�po�tu odber. a dodav. fakt�r"
  );
  M3.NovaPolozka
  ( "Post�penie poh�ad�vok a z�v�zkov",
    "Faktoring()",
    "Vytvorenie a za��tovanie faktoringovej zmluvy odber. a dod�v. fakt�r"
  );
  M3.NovaPolozka
  ( "Zoznamy dokladov",
    "prhdok()",
    "Zoznamy za��tovan�ch pokladni�n�ch dokladov,bankov�ch v�pisov,v�eobecn�ch ��tovn�ch dokladov,odberate�sk�ch a dod�vate�sk�ch fakt�r...."
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 350);
  M4.NovaPolozka
  ( "Parametre programu Finan�n� ��tovn�ctvo",
    "OtvorUfir91()",
    "Parametre programu Finan�n� ��tovn�ctvo"
  );
  M4.NovaPolozka
  ( "��tov� osnova",
    "Uctosn()",
    "��tov� osnova - nahr�vanie a �pravy"
  );
  M4.NovaPolozka
  ( "Druhy da�ov�ch dokladov DPH",
    "Drudan()",
    "Druhy da�ov�ch dokladov DPH - nahr�vanie a �pravy"
  );
  M4.NovaPolozka
  ( "Druhy odberate�sk�ch dokladov",
    "OtvorDodb()",
    "Druhy odberate�sk�ch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy dod�vate�sk�ch dokladov",
    "OtvorDdod()",
    "Druhy dod�vate�sk�ch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy pokladn�c",
    "OtvorDpok()",
    "Druhy pokladn�c"
  );
  M4.NovaPolozka
  ( "Druhy bankov�ch ��tov",
    "OtvorDban()",
    "Druhy bankov�ch ��tov"
  );
  M4.NovaPolozka
  ( "Po�iato�n� stav Odberate�sk�ch fakt�r",
    "PocOdber()",
    "Po�iato�n� stav Odberate�sk�ch fakt�r"
  );
  M4.NovaPolozka
  ( "Po�iato�n� stav Dod�vate�sk�ch fakt�r",
    "PocDodav()",
    "Po�iato�n� stav Dod�vate�sk�ch fakt�r"
  );
  M4.NovaPolozka
  ( "Po�iato�n� stav �hrad",
    "PocUhrad()",
    "Po�iato�n� stav �hrad"
  );
  M4.classMenu = "menu2";
  M4.classPolozka = "polozka2";
  M4.classApolozka = "Apolozka2";
//  M4.x=605;// M1.y=100;

  // PIATE MENU
  var M5 = new CSkryvaneMenu("M5", 150);
  M5.NovaPolozka
  ( "�daje o firme",
    "OtvorUfir1()",
    "�daje o firme"
  );
  M5.NovaPolozka
  ( "��seln�k I�O",
    "OtvorCico()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k stred�sk",
    "OtvorCstr()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k z�kaziek",
    "OtvorCzak()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k skup�n",
    "OtvorCsku()",
    "��seln�k skupn"
  );
  M5.NovaPolozka
  ( "��seln�k stavieb",
    "OtvorCsta()",
    "��seln�k stavieb"
  );
  M5.NovaPolozka
  ( "E-z�kazn�ci",
    "Ezakaznik()",
    "Registr�cia e-z�kazn�kov"
  );
  M5.NovaPolozka
  ( "Z�lohovanie d�t",
    "ZalDat()",
    "Z�lohovanie d�t na m�dium "
  );
  M5.NovaPolozka
  ( "Prenos po�.stavu",
    "PrenosPoc()",
    "Prenos po�iato�n�ho stavu ��tovn�ctva "
  );
  M5.classMenu = "menu2";
  M5.classPolozka = "polozka2";
  M5.classApolozka = "Apolozka2";
//  M5.x=800;// M1.y=100;

<?php                     } ?>


   // Priklad funkce volane z menu
  function Funkciazmenu()
  {
    alert ("Hl�si sa slu�ba z menu");
  }


  function OtvorCstr()
  { 
  var okno = window.open("../cis/cstr.php?copern=1&page=1","_blank");
  }


  function OtvorCsku()
  { 
  var okno = window.open("../cis/csku.php?copern=1&page=1","_blank");
  }


  function OtvorCsta()
  { 
  var okno = window.open("../cis/csta.php?copern=1&page=1","_blank");
  }

  function OtvorCzak()
  { 
  var okno = window.open("../cis/czak.php?copern=1&page=1","_blank");
  }

  function OtvorUfir1()
  { 
  var okno = window.open("../cis/ufir.php?copern=1","_blank");
  }

  function OtvorUfir91()
  { 
  var okno = window.open("../cis/ufir.php?copern=91","_blank");
  }

  function OtvorCico()
  { 
  var okno = window.open("../cis/cico.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZmnPrih()
  { 
  var okno = window.open("../cis/zmnprih.php?copern=1&page=1","_blank");
  }

  function ZalDat()
  { 
  var okno = window.open("../cis/zaldat_ucto.php?copern=101&page=1","_blank");
  }

  function ObnDat()
  { 
  var okno = window.open("../cis/obndat.php?copern=1&page=1","_blank");
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=10&drupoh=1&page=1&upozorni2011=1&upozorni2012=1&upozorni2013=1","_blank",'<?php echo $parwin; ?>');
  }

//[[[[[[[ body ucto

  function OtvorOdber()
  { 
  var okno = window.open('../faktury/vstfak.php?copern=1&drupoh=1001&page=1&pocstav=0','_blank','<?php echo $parwin; ?>');
  }

  function OtvorDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=1002&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorppri()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorpvyd()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=2&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorbank()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=4&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorvseo()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=5&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function prhdok()
  { 
  var okno = window.open("../ucto/prhdok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function saldo()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=0","_blank",'<?php echo $parwin; ?>');
  }

  function Upomienka()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=1","_blank",'<?php echo $parwin; ?>');
  }

  function Rucnespar()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=9","_blank",'<?php echo $parwin; ?>');
  }

  function Vzajomny()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=8","_blank",'<?php echo $parwin; ?>');
  }

  function Faktoring()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=6","_blank",'<?php echo $parwin; ?>');
  }

  function uctpohyby()
  { 
  var okno = window.open("../ucto/uctpohyby.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function hladaj_doklad()
  { 
  var okno = window.open("../ucto/hladaj_dok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Cudzie()
  { 
  var okno = window.open("../ucto/cudzie.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function oprsys()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function meszos()
  { 
  var okno = window.open("../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function danprij()
  { 
  var okno = window.open("../ucto/danprij.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function sttzos()
  { 
  var okno = window.open("../ucto/statzos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Imvykzis()
  { 
  var okno = window.open("../ucto/import.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Uctosn()
  { 
  var okno = window.open("../ucto/uctosn.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Drudan()
  { 
  var okno = window.open("../ucto/drudan.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorDodb()
  { 
  var okno = window.open("../faktury/dodb.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDdod()
  { 
  var okno = window.open("../faktury/ddod.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDpok()
  { 
  var okno = window.open("../ucto/dpok.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDban()
  { 
  var okno = window.open("../ucto/dban.php?copern=1&drupoh=1&page=1","_blank");
  }

  function Priku()
  { 
  var okno = window.open("../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function PocOdber()
  { 
  var okno = window.open('../faktury/vstfak.php?copern=1&drupoh=1001&page=1&pocstav=1','_blank','<?php echo $parwin; ?>');
  }

  function PocDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=1002&page=1&pocstav=1","_blank",'<?php echo $parwin; ?>');
  }

  function PocUhrad()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=8&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ukazrobot()
  { 
  <?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  }

  function zobraz_robotmenu()
  { 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  }

    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 112;
    var leftrobotmenu = 100;
    var widthrobotmenu = 400;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dodb WHERE drod = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceodb=$riadok->dodb;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=1&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceodb; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� odberate�sk� fakt�ru ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_ddod WHERE drdo = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $ucedod=$riadok->ddod;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=2&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucedod; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� dod�vate�sk� fakt�ru ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dpok WHERE drpk = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $ucepok=$riadok->dpok;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=1&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucepok; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� pr�jmov� pokladni�n� doklad ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=2&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucepok; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� v�davkov� pokladni�n� doklad ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dban WHERE dban > 0");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceban=$riadok->dban;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=4&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceban; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� bankov� v�pis ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=5&page=1&rozuct=ANO&sysx=UCT', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� v�eobecn� ��tovn� doklad ?</a>";
    htmlmenu += "</td></tr>";

<?php if( $kli_vduj == 9 ) { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� Pe�a�n� denn�k ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vprivyd.php?copern=10&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� V�kaz o pr�jmoch a v�davkoch ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vmajzav.php?copern=10&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� V�kaz o majetku a z�v�zkoch ?</a>";
    htmlmenu += "</td></tr>";

<?php                      } ?>

<?php if( $kli_vduj != 9 ) { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� ��tovn� denn�k ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vykzis.php?copern=10&drupoh=1&page=1&tis=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� V�kaz ziskov a str�t �� POD 2-01 verzia UVPOD2v07_2 ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/suvaha.php?copern=10&drupoh=1&page=1&tis=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� S�vahu �� POD 1-01 verzia UVPOD1v07_1 ?</a>";
    htmlmenu += "</td></tr>";

<?php                      } ?>


    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/prizdph<?php echo $vyb_rok; ?>.php?copern=10&drupoh=1&page=1fir_uctx01=0&h_drp=1&h_dap=&h_arch=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytla�i� Da�ov� priznanie Da� z pridanej hodnoty ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
    htmlmenu += "Chcete skontrolova� ";
    htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/prizdph<?php echo $vyb_rok; ?>.php?copern=40&drupoh=1&page=1&chyby=1', '_blank','<?php echo $tlcswin; ?>' )\">";
    htmlmenu += "DPH </a> , ";
    htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/ucto_kontrol.php?copern=40&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">";
    htmlmenu += "��tovanie </a> nahrat�ch dokladov ?";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../cis/stiahni_ecb.php?copern=1010', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete stiahnu� kurzov� l�stok ECB na dnes ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../cis/stiahni_ecb.php?copern=1010&dni90=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete stiahnu� kurzov� l�stok ECB 90dn� sp� ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "</table>";  

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Finan�n� ��tovn�ctvo
<?php if( $vyb_duj == 0 ) { echo " PU"; } ?>
<?php if( $vyb_duj == 9 ) { echo " JU"; } ?>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid  ";?></span></td>
</tr>
</table>
<table class="pmenu" width="100%" style="border:none;" >
<tr>
<td width="60%" >
<a href='podvojneu.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width="15" height="10" title="Zmena ��tovnej jednotky" border="0"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='podvojneu.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width="15" height="10" border="0" title="Zmena ��tovn�ho obdobia">
��tovn� obdobie:</a>
<?php echo "$vyb_ume";?>
</td>
</tr>
</table>

<?php 
$klepnutie=".Klepnuti";
if( $newmenu == 1 ) 
{ 
?>
<script type="text/javascript">

  function MZvyrazni(Obj)
                {

  Obj.className = "pmenuz";

                }

  function MNeZvyrazni(Obj)
                {

  Obj.className = "pmenu";

                }

  function M1KlikNaMenu()  {   progmenu1.style.display='';  }
  function M1ZhasniMenu()  {   progmenu1.style.display='none';  }
  function M2KlikNaMenu()  {   progmenu2.style.display='';  }
  function M2ZhasniMenu()  {   progmenu2.style.display='none';  }
  function M3KlikNaMenu()  {   progmenu3.style.display='';  }
  function M3ZhasniMenu()  {   progmenu3.style.display='none';  }
  function M4KlikNaMenu()  {   progmenu4.style.display='';  }
  function M4ZhasniMenu()  {   progmenu4.style.display='none';  }
  function M5KlikNaMenu()  {   progmenu5.style.display='';  }
  function M5ZhasniMenu()  {   progmenu5.style.display='none';  }
</script>

<?php //OBRAZKOVE MENU ?>

<table class="pmenu" width="100%" style="position:relative; top:3px; border:none; background-color:white;" >
<tr>
<td width='18%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d�t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='Mesa�n� spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform�cie a v�stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a slu�by' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='��seln�ky a �dr�ba' ></a></center>
</td>
</tr>
</table>


<div id="progmenu1" style="cursor:hand; display:none; position:absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup d�t</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r1.jpg' style='width:98%; height:20;' alt='Kniha odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r2.jpg' style='width:98%; height:20;' alt='Kniha dod�vate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorppri();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r3.jpg' style='width:98%; height:20;' alt='Pr�jmov� pokladni�n� doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorpvyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r4.jpg' style='width:98%; height:20;' alt='V�davkov� pokladni�n� doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorbank();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r5.jpg' style='width:98%; height:20;' alt='Bankov� v�pis' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorvseo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r6.jpg' style='width:98%; height:20;' alt='V�eobecn� ��tovn� doklady' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu Mesa�n� spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="meszos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r1.jpg' style='width:98%; height:20;' alt='Vytvorenie mesa�n�ch ��tovn�ch zost�v' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="sttzos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r2.jpg' style='width:98%; height:20;' alt='�tatistika a v�kazn�ctvo' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="oprsys();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r3.jpg' style='width:98%; height:20;' alt='Preh�ady a �pravy d�t z podsyst�mov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="danprij();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r4.jpg' style='width:98%; height:20;' alt='Priznanie k dani z pr�jmov' ></a></center></td></tr>



</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Inform�cie a v�stupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="saldo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r1.jpg' style='width:98%; height:20;' alt='Odberate�sk� a dod�vate�sk� Saldokonto' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="uctpohyby();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r2.jpg' style='width:98%; height:20;' alt='V�pis ��tovn�ch pohybov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="hladaj_doklad();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r3.jpg' style='width:98%; height:20;' alt='Preh�ad�vanie dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Cudzie();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r4.jpg' style='width:98%; height:20;' alt='��ty veden� v cudz�ch men�ch' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Upomienka();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r5.jpg' style='width:98%; height:20;' alt='Upomienka, pen�le odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Priku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r6.jpg' style='width:98%; height:20;' alt='Pr�kaz na �hradu dod�v.fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Rucnespar();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r7.jpg' style='width:98%; height:20;' alt='Ru�n� sp�rovanie a opravy saldokonta' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Vzajomny();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r8.jpg' style='width:98%; height:20;' alt='Vz�jomn� z�po�et odber. a dodav. fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Faktoring();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r9.jpg' style='width:98%; height:20;' alt='Post�penie poh�ad�vok a z�v�zkov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="prhdok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r10.jpg' style='width:98%; height:20;' alt='Zoznamy dokladov' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a slu�by</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir91();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Finan�n� ��tovn�ctvo' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Uctosn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r2.jpg' style='width:98%; height:20;' alt='��tov� osnova' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Drudan();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r3.jpg' style='width:98%; height:20;' alt='Druhy da�ov�ch dokladov DPH' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r4.jpg' style='width:98%; height:20;' alt='Druhy odberate�sk�ch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDdod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r5.jpg' style='width:98%; height:20;' alt='Druhy dod�vate�sk�ch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDpok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r6.jpg' style='width:98%; height:20;' alt='Druhy pokladn�c' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDban();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r7.jpg' style='width:98%; height:20;' alt='Druhy bankov�ch ��tov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r8.jpg' style='width:98%; height:20;' alt='Po�iato�n� stav Odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r9.jpg' style='width:98%; height:20;' alt='Po�iato�n� stav Dod�vate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocUhrad();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r10.jpg' style='width:98%; height:20;' alt='Po�iato�n� stav �hrad' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu ��seln�ky a �dr�ba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r1.jpg' style='width:98%; height:20;' alt='�daje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r2.jpg' style='width:98%; height:20;' alt='��seln�k I�O' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r3.jpg' style='width:98%; height:20;' alt='��seln�k stred�sk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r4.jpg' style='width:98%; height:20;' alt='��seln�k z�kaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r5.jpg' style='width:98%; height:20;' alt='��seln�k skup�n' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r6.jpg' style='width:98%; height:20;' alt='��seln�k stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r7.jpg' style='width:98%; height:20;' alt='E-z�kazn�ci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="ZalDat();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r9.jpg' style='width:98%; height:20;' alt='Z�lohovanie d�t' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos po�.stavu' ></a></center></td></tr>


</FORM>
</table>
</div>



<?php
} 
?>

<?php
if( $newmenu == 0 ) 
{ 
?>
<span style="position:absolute; top:70; ">
<table class="pmenu" width="100%" border=1 >
<tr>
<span onclick="M1.Klepnuti(); return false; ">
<td width="20%" ><center>Vstup d�t</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Mesa�n� spracovanie</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false;  ">
<td width="20%" ><center>Inform�cie a v�stupy</center></td>
</span>

<span  onclick="M4.Klepnuti(); return false; ">
<td width="20%" ><center>Nastavenia a slu�by</center></td>
</span>

<span  onclick="M5.Klepnuti(); return false; ">
<td width="20%" ><center>��seln�ky a �dr�ba</center></td>
</span>
</tr>
</table>
</span>
<?php
} 
?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php 
// zmena ume
if ( $copern == 23 OR $copern == 24 )
     {
?>
<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="podvojneu.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="12" name="umes" id="umes" >

<option value="01.<?php echo $vyb_rok;?>" selected='selected'
 >01.<?php echo $vyb_rok;?></option>
<option value="02.<?php echo $vyb_rok;?>"
 >02.<?php echo $vyb_rok;?></option>
<option value="03.<?php echo $vyb_rok;?>"
 >03.<?php echo $vyb_rok;?></option>
<option value="04.<?php echo $vyb_rok;?>"
 >04.<?php echo $vyb_rok;?></option>
<option value="05.<?php echo $vyb_rok;?>"
 >05.<?php echo $vyb_rok;?></option>
<option value="06.<?php echo $vyb_rok;?>"
 >06.<?php echo $vyb_rok;?></option>
<option value="07.<?php echo $vyb_rok;?>"
 >07.<?php echo $vyb_rok;?></option>
<option value="08.<?php echo $vyb_rok;?>"
 >08.<?php echo $vyb_rok;?></option>
<option value="09.<?php echo $vyb_rok;?>"
 >09.<?php echo $vyb_rok;?></option>
<option value="10.<?php echo $vyb_rok;?>"
 >10.<?php echo $vyb_rok;?></option>
<option value="11.<?php echo $vyb_rok;?>"
 >11.<?php echo $vyb_rok;?></option>
<option value="12.<?php echo $vyb_rok;?>"
 >12.<?php echo $vyb_rok;?></option>

</td>
</tr>
<tr>
<INPUT type="hidden" id="firs" name="firs" value="<?php echo $vyb_xcf;?>" >
<td class="obyc"><INPUT type="submit" id="umev" name="umev" value="Vybra� ��tovn� obdobie" ></td>
</tr>
</FORM>
</table>
</span>
<?php
     }
//toto je koniec zmeny ume


if ( $copern == 22 )
     {
$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";

if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("cis/vybuzfir.php"); }

$sql = mysql_query("SELECT xcf,naz FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="podvojneu.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="10" name="firs" id="firs" >
<?php while($zaznam=mysql_fetch_array($sql)):?>

<option value="<?php echo $zaznam["xcf"];?>"
<?php

if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";
$umes1="1.".$zaznam["rok"]
?>
 ><?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?></option>

<?php endwhile;?>
</td>
</tr>
<tr>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $umes1;?>" >
<td class="obyc"><INPUT type="submit" id="firv" name="firv" value="Vybra� ��tovn� jednotku" ></td>
</tr>
</FORM>
</table>
</span>

<?php
mysql_close();
mysql_free_result($sql);

// toto je koniec zmeny firmy 
     }

$akyrobot = include("akyrobot.php");
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr� de� , ja som V� EkoRobot , ak m�te ot�zku alebo nejak� �elanie kliknite na m�a pros�m 1x my�ou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<?php

$robot=1;
$absolut=1;
$zmenume=1; $odkaz="../podvojneu.php?copern=1&newmenu=$newmenu";
$cislista = include("ucto/uct_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
