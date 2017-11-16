<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu OZNAMENIE ZRD 2016
do
{
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
$copern = $_REQUEST['copern'];
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;


//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/oznamenie_zrd/ozn4317a_v16";
$jpg_popis="tlaËivo Ozn·menie platiteæa dane o zrazenÌ a odvedenÌ dane vyberanej zr·ûkou OZN4317Av16".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

$cislo_xplat = 1*$_REQUEST['cislo_xplat'];
$strana = 1*$_REQUEST['strana'];

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$zaobdobie=1*$_REQUEST['h_stv'];
$zaobdobie=4;
$dajnew=1;

$sql = "SELECT konx7 FROM F$kli_vxcf"."_mzdoznameniezrd ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdoznameniezrd';
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdoznameniezrdpol';
$vytvor = mysql_query("$vsql");

$sqltv = <<<trexima
(
   cpl          int not null auto_increment,
   mdic         DECIMAL(10,0) DEFAULT 0,
   stvrt        DECIMAL(2,0) DEFAULT 0,
   xplat        DECIMAL(10,0) DEFAULT 0,
   zzul         VARCHAR(70) NOT NULL,
   zzcs         VARCHAR(20) NOT NULL,
   zzps         VARCHAR(10) NOT NULL,
   zzms         VARCHAR(70) NOT NULL,

   xdic         DECIMAL(10,0) DEFAULT 0,
   datd         DATE NOT NULL,
   xmfo         VARCHAR(70) NOT NULL,
   xpfo         VARCHAR(70) NOT NULL,
   xnpo         VARCHAR(70) NOT NULL,
   xuli         VARCHAR(70) NOT NULL,
   xcis         VARCHAR(20) NOT NULL,
   xpsc         VARCHAR(10) NOT NULL,
   xmes         VARCHAR(70) NOT NULL,

   prj          DECIMAL(10,2) DEFAULT 0,
   zrd          DECIMAL(10,2) DEFAULT 0,
   datum        DATE NOT NULL,
   kkx1         DECIMAL(13,6) DEFAULT 0,
   odvod        DECIMAL(10,2) DEFAULT 0,
   konx7        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
trexima;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdoznameniezrd'.$sqltv;
$vytvor = mysql_query("$vsql");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdoznameniezrdpol'.$sqltv;
$vytvor = mysql_query("$vsql");
}

$sql = "SELECT xtitulp FROM F$kli_vxcf"."_mzdoznameniezrd ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xtitulz VARCHAR(15) AFTER xmes ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xtitulp VARCHAR(15) AFTER xmes ";
$sqldok = mysql_query("$sqlfir");

$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD xtitulz VARCHAR(15) AFTER xmes ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD xtitulp VARCHAR(15) AFTER xmes ";
$sqldok = mysql_query("$sqlfir");
}
//v2016
$sql = "SELECT datvrat FROM F$kli_vxcf"."_mzdoznameniezrd ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD opravne DECIMAL(4,0) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD sruli VARCHAR(30) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD srcdm VARCHAR(10) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD srpsc VARCHAR(10) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD srmes VARCHAR(30) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r40 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r41 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r42 DECIMAL(10,0) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r43 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r44 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r45 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r46 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r47 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r48 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r49 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r50 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r51 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r52 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD vrat DECIMAL(4,0) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD post DECIMAL(4,0) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD ucet DECIMAL(4,0) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD datvrat DATE NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
}

$sql = "SELECT xspmes FROM F$kli_vxcf"."_mzdoznameniezrdpol ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xstat VARCHAR(15) AFTER xmes ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xspuli VARCHAR(30) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xspcdm VARCHAR(10) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xsppsc VARCHAR(10) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrdpol ADD xspmes VARCHAR(30) NOT NULL AFTER xmes";
$sqldok = mysql_query("$sqlfir");
}

$sql = "SELECT r23 FROM F$kli_vxcf"."_mzdoznameniezrdpol";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r20 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r21 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r21a DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r22 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "ALTER TABLE F$kli_vxcf"."_mzdoznameniezrd ADD r23 DECIMAL(10,2) DEFAULT 0 AFTER xmes";
$sqldok = mysql_query("$sqlfir");
}


$jezam=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $jezam=1;
    }
if( $jezam == 0 )
  {
$sqlfir = "INSERT INTO F$kli_vxcf"."_mzdoznameniezrd ( xplat, stvrt  ) VALUES ( '$cislo_xplat', '$zaobdobie' ) ";
$sqldok = mysql_query("$sqlfir");

  }


//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$cislo_xplat = 1*$_REQUEST['cislo_xplat'];
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];


//zapis upravene udaje
if ( $copern == 801 AND $strana == 1 )
     {
$mdic = strip_tags($_REQUEST['mdic']);
$opravne = strip_tags($_REQUEST['opravne']);
$sruli = strip_tags($_REQUEST['sruli']);
$srcdm = strip_tags($_REQUEST['srcdm']);
$srpsc = strip_tags($_REQUEST['srpsc']);
$srmes = strip_tags($_REQUEST['srmes']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET".
" mdic='$mdic', opravne='$opravne', sruli='$sruli', srcdm='$srcdm', srpsc='$srpsc', srmes='$srmes' ".
" WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
$uprav="NO";
$copern=101;
     }
//koniec zapis

if ( $copern == 801 AND $strana == 2 )
     {
$zzul = strip_tags($_REQUEST['zzul']);
$zzcs = strip_tags($_REQUEST['zzcs']);
$zzps = strip_tags($_REQUEST['zzps']);
$zzms = strip_tags($_REQUEST['zzms']);
$r20 = 1*strip_tags($_REQUEST['r20']);
$r21 = 1*strip_tags($_REQUEST['r21']);
$r21a = 1*strip_tags($_REQUEST['r21a']);
$r22 = 1*strip_tags($_REQUEST['r22']);
$r23 = 1*strip_tags($_REQUEST['r23']);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
$r40 = 1*strip_tags($_REQUEST['r40']);
$r41 = 1*strip_tags($_REQUEST['r41']);
$r42 = 1*strip_tags($_REQUEST['r42']);
$r43 = 1*strip_tags($_REQUEST['r43']);
$r44 = 1*strip_tags($_REQUEST['r44']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET".
" zzul='$zzul', zzps='$zzps', zzms='$zzms', zzcs='$zzcs', ".
" r20='$r20', r21='$r21', r21a='$r21a', r22='$r22', r23='$r23', datum='$datum_sql', ".
" r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44' ".
" WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
$uprav="NO";
$copern=101;
     }
//koniec zapis

if ( $copern == 801 AND $strana == 3 )
     {
$r45 = 1*strip_tags($_REQUEST['r45']);
$r46 = 1*strip_tags($_REQUEST['r46']);
$r47 = 1*strip_tags($_REQUEST['r47']);
$r48 = 1*strip_tags($_REQUEST['r48']);
$r49 = 1*strip_tags($_REQUEST['r49']);
$r50 = 1*strip_tags($_REQUEST['r50']);
$r51 = 1*strip_tags($_REQUEST['r51']);
$r52 = 1*strip_tags($_REQUEST['r52']);
$datd = strip_tags($_REQUEST['datd']);
$datd_sql=SqlDatum($datd);
$vrat = strip_tags($_REQUEST['vrat']);
$post = strip_tags($_REQUEST['post']);
$ucet = strip_tags($_REQUEST['ucet']);
$datvrat = strip_tags($_REQUEST['datvrat']);
$datvrat_sql=SqlDatum($datvrat);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET".
" r45='$r45', r46='$r46', r47='$r47', r48='$r48', r49='$r49', r50='$r50', r51='$r51', r52='$r52', ".
" datd='$datd_sql', vrat='$vrat', post='$post', ucet='$ucet', datvrat='$datvrat_sql' ".
" WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;
$uprav="NO";
$copern=101;
     }
//koniec zapis

//upravit polozku
if ( $copern == 801 AND $strana == 4 )
     {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$xdic = strip_tags($_REQUEST['xdic']);
$prj = 1*strip_tags($_REQUEST['prj']);
$xmfo = strip_tags($_REQUEST['xmfo']);
$xpfo = strip_tags($_REQUEST['xpfo']);
$xtitulp = strip_tags($_REQUEST['xtitulp']);
$xtitulz = strip_tags($_REQUEST['xtitulz']);
$xnpo = strip_tags($_REQUEST['xnpo']);
$xuli = strip_tags($_REQUEST['xuli']);
$xcis = strip_tags($_REQUEST['xcis']);
$xpsc = strip_tags($_REQUEST['xpsc']);
$xmes = strip_tags($_REQUEST['xmes']);
$xstat = strip_tags($_REQUEST['xstat']);
$xspuli = strip_tags($_REQUEST['xspuli']);
$xspcdm = strip_tags($_REQUEST['xspcdm']);
$xsppsc = strip_tags($_REQUEST['xsppsc']);
$xspcdm = strip_tags($_REQUEST['xspcdm']);
$xsppsc = strip_tags($_REQUEST['xsppsc']);
$xspmes = strip_tags($_REQUEST['xspmes']);

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrdpol SET".
" xdic='$xdic', prj='$prj', xmfo='$xmfo', xpfo='$xpfo', xtitulp='$xtitulp', xtitulz='$xtitulz', ".
" xnpo='$xnpo', xuli='$xuli', xcis='$xcis', xpsc='$xpsc', xmes='$xmes', xstat='$xstat', ".
" xspuli='$xspuli', xspcdm='$xspcdm', xsppsc='$xsppsc', xspmes='$xspmes' ".
" WHERE  cpl = $cislo_cpl ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET datd='$datd_sql' WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt");

$uprav="NO";
$copern=101;
$strana=4;
     }
//koniec upravit polozku

//vlozit novu polozku
if ( $copern == 801 AND $strana == 5 )
     {

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdoznameniezrdpol (xplat,stvrt) VALUES ('$cislo_xplat', '$zaobdobie' )";
$upravene = mysql_query("$uprtxt");

$cislo_cpl=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY cpl DESC";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cislo_cpl=1*$riaddok->cpl;
    }

$uprav="NO";
$copern=101;
$strana=4;
$dajnew=0;
if( $cislo_cpl > 0 ) { $strana=4; }

     }
//koniec vlozit novu polozku


//zmazat polozku
if ( $copern == 502 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE cpl = $cislo_cpl ";
$upravene = mysql_query("$uprtxt");

$copern=101;
$strana=5;
     }
//koniec zmazat polozku

// nacitaj sumu a dane
$nacitajsumu=0;
$vypocitajdan=0;
$nacitajsumu = $_REQUEST['nacitajsumu'];
$vypocitajdan = $_REQUEST['vypocitajdan'];
if( $nacitajsumu == 1 )
  {
$celprj=0;
$sqlfir = "SELECT SUM(prj) AS sumprj FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $celprj=1*$riaddok->sumprj;
    }

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r21=0, r21a=0, r22=0, r23=0, r41=0, r43=0, r49=0, r51=0, r52=0, r20=$celprj, kkx1=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r22=r20+r21 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");

$vypocitajdan=1;
  }
if( $vypocitajdan == 1 )
  {

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r22=0, r23=0, r41=0, r43=0, r49=0, r51=0, r52=0, kkx1=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r22=r20+r21 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r22=r20+r21, kkx1=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=r22*19 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1/100 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1-0.0049 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r23=kkx1 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");


  }
//koniec nacitaj sumu a dane


//dan po vynati prijmov zo zdrojov v zahranici
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r41=0, r43=0, r49=0, kkx1=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r41=r22-r40 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=r41*19 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1/100 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1-0.0049 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r43=kkx1, r49=kkx1 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r49=r43-r48 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r51=r49-r23-r50, r52=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r52=-r51 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r51 < 0 AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET r51=0 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie AND r51 < 0 AND r40 != 0 ";
$sqldok = mysql_query("$sqlfir");

//nacitaj
if ( $copern == 101 OR $copern == 40 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$opravne = $fir_riadok->opravne;
$sruli = $fir_riadok->sruli;
$srcdm = $fir_riadok->srcdm;
$srpsc = $fir_riadok->srpsc;
$srmes = $fir_riadok->srmes;
$r20 = $fir_riadok->r20;
$r21 = $fir_riadok->r21;
$r21a = $fir_riadok->r21a;
$r22 = $fir_riadok->r22;
$r23 = $fir_riadok->r23;
$r40 = $fir_riadok->r40;
$r41 = $fir_riadok->r41;
$r42 = $fir_riadok->r42;
$r43 = $fir_riadok->r43;
$r44 = $fir_riadok->r44;
$r45 = $fir_riadok->r45;
$r46 = $fir_riadok->r46;
$r47 = $fir_riadok->r47;
$r48 = $fir_riadok->r48;
$r49 = $fir_riadok->r49;
$r50 = $fir_riadok->r50;
$r51 = $fir_riadok->r51;
$r52 = $fir_riadok->r52;
$vrat = $fir_riadok->vrat;
$post = $fir_riadok->post;
$ucet = $fir_riadok->ucet;
$datvrat_sk = SkDatum($fir_riadok->datvrat);


//udaje o platitelovi - zamestnancovi
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_xplat ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$rdc = $fir_riadok->rdc;
$rdk = $fir_riadok->rdk;
$nar_sk = SkDatum($fir_riadok->dar);
$zuli = $fir_riadok->zuli;
$zmes = $fir_riadok->zmes;
$zpsc = $fir_riadok->zpsc;
$zcdm = $fir_riadok->zcdm;
$titulp = $fir_riadok->titl;

mysql_free_result($fir_vysledok);

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $cislo_xplat ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$titulz = $fir_riadok->ztitz;
$fir_fdicx = $fir_riadok->zdic;
$zstat = $fir_riadok->zstat;
$ziban = $fir_riadok->ziban;

mysql_free_result($fir_vysledok);

//udaje zdrav.zariadenie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$mdic = $fir_riadok->mdic;
$zzul = $fir_riadok->zzul;
$zzcs = $fir_riadok->zzcs;
$zzps = $fir_riadok->zzps;
$zzms = $fir_riadok->zzms;
$datum_sk = SkDatum($fir_riadok->datum);
$datd_sk = SkDatum($fir_riadok->datd);
$fir_fdicx=$mdic;

$prj = $fir_riadok->prj;
$zrd = $fir_riadok->zrd;

mysql_free_result($fir_vysledok);

if( $strana == 4 )
  {
//udaje priloha
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE cpl = $cislo_cpl ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$xmfo = $fir_riadok->xmfo;
$xpfo = $fir_riadok->xpfo;
$xnpo = $fir_riadok->xnpo;
$xdic = $fir_riadok->xdic;
$prj = $fir_riadok->prj;
$xuli = $fir_riadok->xuli;
$xcis = $fir_riadok->xcis;
$xpsc = $fir_riadok->xpsc;
$xmes = $fir_riadok->xmes;
$xtitulp = $fir_riadok->xtitulp;
$xtitulz = $fir_riadok->xtitulz;
$xstat = $fir_riadok->xstat;
$xspuli = $fir_riadok->xspuli;
$xspcdm = $fir_riadok->xspcdm;
$xsppsc = $fir_riadok->xsppsc;
$xspmes = $fir_riadok->xspmes;

mysql_free_result($fir_vysledok);
  }

//ak platitel pravnicka osoba
if( $cislo_xplat > 9999 )
  {
$fir_fdicx=$fir_fdic;
$mdic=$fir_fdic;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$meno = $fir_riadok->dmeno;
$prie = $fir_riadok->dprie;
$titulp = $fir_riadok->dtitl;
$titulz = $fir_riadok->dtitz;
$zuli = $fir_riadok->duli;
$zcdm = $fir_riadok->dcdm;
$zmes = $fir_riadok->dmes;
$zpsc = $fir_riadok->dpsc;

$fir_fnazovx = $fir_fnaz;

if ( $fir_uctt03 != 999 ) {
$meno=""; $prie=""; $titulp=""; $titulz="";
$fir_fnazx = $fir_fnaz;
$nar_sk="";
$zuli = $fir_fuli;
$zcdm = $fir_fcdm;
$zmes = $fir_fmes;
$zpsc = $fir_fpsc;
                          }

if ( $nar_sk == '00.00.0000' ) { $nar_sk=""; }


  }


$prilohy=0; $pocetdic=0; $pocetdic2=0; $pocetdic3=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie";
$sqldok = mysql_query("$sqlfir");
if ( $sqldok ) { $pocetdic = mysql_num_rows($sqldok); }

$pocetdic2=$pocetdic-1;
$pocetdic3=$pocetdic2/2;
$prilohy=ceil($pocetdic3);
if ( $prilohy < 0 ) { $prilohy=0; }
if ( $prilohy == -0 ) { $prilohy=0; }
     }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Ozn·menie ZRD</title>
<style type="text/css">
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  font-size: 18px;
  background-color: #fff;
  position: absolute;
}
div.wrap-vozidla {
  overflow: auto;
  width: 100%;
  background-color: #fff;
  min-height: 100px;
}
div.wrap-vozidla > div {
  overflow: auto;
  line-height: 40px;
  margin: 10px 0 0 45px;
}
div.wrap-vozidla img {
  display: inline-block;
  width: 18px;
  height: 18px;
  cursor: pointer;
}
table.vozidla {
  width: 850px;
  margin: 10px auto;
  overflow: auto;
}
table.vozidla thead th {
  height: 11px;
  padding: 5px 0 3px 0;
  font-size: 11px;
  font-weight: bold;
  color: #333;
  text-align: left;
  background-color: lightblue;
}
table.vozidla tbody td {
  height: 26px;
  line-height: 26px;
  border-top: 2px solid #add8e6;
  font-size: 15px;
}
table.vozidla tbody tr:hover {
  background-color: #f3f3f3;

}
table.vozidla tbody img {
  position: relative;
  top: 4px;
}
table.vozidla tfoot td {
  border-top: 2px solid #add8e6;
  font-size: 15px;
  height: 26px;
  line-height: 26px;
}
div.wrap-zariadenia {
  z-index: 500;
  overflow: auto;
  width: 400px;
  position: absolute;
  top: 711px;
  right: 5px;
  background-color: #ffff90;
  padding: 5px;
  border-right: 2px outset #c2c2c2;
  border-bottom: 2px outset #c2c2c2;
}
div.wrap-zariadenia img {
  cursor: pointer;
}
table.zariadenia {
  width: 100%;
  margin: 28px auto 0 auto;
}
table.zariadenia th {
  background-color: #add8e6;
  font-size: 11px;
  padding: 4px 0 2px 0;
  text-align: left;
}
table.zariadenia td {
  background-color: #fff;
  line-height: 25px;
  font-size: 13px;
  border-top: 3px solid #ffff90;
}
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
  function ObnovUI()
  {

<?php if ( $strana == 1 ) { ?>
   document.formv1.mdic.value = "<?php echo $mdic; ?>";
<?php if ( $opravne == 1 ) { ?> document.formv1.opravne.checked = 'true'; <?php } ?>
   document.formv1.sruli.value = "<?php echo $sruli; ?>";
   document.formv1.srcdm.value = "<?php echo $srcdm; ?>";
   document.formv1.srpsc.value = "<?php echo $srpsc; ?>";
   document.formv1.srmes.value = "<?php echo $srmes; ?>";
   document.formv1.uloz.disabled = true;
//   document.formv1.uloz1.disabled = true;
<?php                    } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.zzul.value = "<?php echo $zzul; ?>";
   document.formv1.zzcs.value = "<?php echo $zzcs; ?>";
   document.formv1.zzps.value = "<?php echo $zzps; ?>";
   document.formv1.zzms.value = "<?php echo $zzms; ?>";
   document.formv1.datum.value = "<?php echo $datum_sk; ?>";
   document.formv1.r20.value = "<?php echo $r20; ?>";
   document.formv1.r21.value = "<?php echo $r21; ?>";
   document.formv1.r21a.value = "<?php echo $r21a; ?>";
   document.formv1.r22.value = "<?php echo $r22; ?>";
   document.formv1.r23.value = "<?php echo $r23; ?>";
   document.formv1.r40.value = "<?php echo $r40; ?>";
   document.formv1.r41.value = "<?php echo $r41; ?>";
   document.formv1.r42.value = "<?php echo $r42; ?>";
   document.formv1.r43.value = "<?php echo $r43; ?>";
   document.formv1.r44.value = "<?php echo $r44; ?>";
   document.formv1.uloz.disabled = true;
//   document.formv1.uloz1.disabled = true;
<?php                    } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.r45.value = "<?php echo $r45; ?>";
   document.formv1.r46.value = "<?php echo $r46; ?>";
   document.formv1.r47.value = "<?php echo $r47; ?>";
   document.formv1.r48.value = "<?php echo $r48; ?>";
   document.formv1.r49.value = "<?php echo $r49; ?>";
   document.formv1.r50.value = "<?php echo $r50; ?>";
   document.formv1.r51.value = "<?php echo $r51; ?>";
   document.formv1.r52.value = "<?php echo $r52; ?>";
<?php if ( $vrat == 1 ) { ?> document.formv1.vrat.checked = 'true'; <?php } ?>
<?php if ( $post == 1 ) { ?> document.formv1.post.checked = 'true'; <?php } ?>
<?php if ( $ucet == 1 ) { ?> document.formv1.ucet.checked = 'true'; <?php } ?>
   document.formv1.datd.value = "<?php echo $datd_sk; ?>";
   document.formv1.datvrat.value = "<?php echo $datvrat_sk; ?>";
   document.formv1.uloz.disabled = true;
//   document.formv1.uloz1.disabled = true;
<?php                    } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.xdic.value = "<?php echo $xdic; ?>";
   document.formv1.xmfo.value = "<?php echo $xmfo; ?>";
   document.formv1.xpfo.value = "<?php echo $xpfo; ?>";
   document.formv1.xnpo.value = "<?php echo $xnpo; ?>";
   document.formv1.prj.value = "<?php echo $prj; ?>";
   document.formv1.xuli.value = "<?php echo $xuli; ?>";
   document.formv1.xcis.value = "<?php echo $xcis; ?>";
   document.formv1.xpsc.value = "<?php echo $xpsc; ?>";
   document.formv1.xmes.value = "<?php echo $xmes; ?>";
   document.formv1.xstat.value = "<?php echo $xstat; ?>";
   document.formv1.xtitulp.value = "<?php echo $xtitulp; ?>";
   document.formv1.xtitulz.value = "<?php echo $xtitulz; ?>";
   document.formv1.xspuli.value = "<?php echo $xspuli; ?>";
   document.formv1.xspcdm.value = "<?php echo $xspcdm; ?>";
   document.formv1.xsppsc.value = "<?php echo $xsppsc; ?>";
   document.formv1.xspmes.value = "<?php echo $xspmes; ?>";
   document.formv1.uloz.disabled = true;
   document.formv1.uloz1.disabled = true;
<?php                    } ?>

  }

  function InfoFRSR()
  {
   window.open('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_info.pdf', '_blank');
  }
  function TlacVykaz()
  {
   window.open('oznamenie_zrd2016.php?copern=40&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=9999', '_blank');
  }
  function nacitajSumu()
  {
   window.open('oznamenie_zrd2016.php?cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&copern=101&drupoh=1&strana=2&nacitajsumu=1', '_self');
  }
  function vypocitajDan()
  {
   window.open('oznamenie_zrd2016.php?cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&copern=101&drupoh=1&strana=2&vypocitajdan=1', '_self');
  }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

//bud alebo checkbox v v.oddiele
  function klikpost()
  {
   document.formv1.ucet.checked = false;
  }
  function klikucet()
  {
   document.formv1.post.checked = false;
  }

//zoznam drzitelov
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('oznamenie_zrd2016.php?copern=101&cislo_cpl='+ cislo_cpl + '&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=4', '_self' )
  }
  function ZmazVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('oznamenie_zrd2016.php?copern=502&cislo_cpl='+ cislo_cpl + '&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=5', '_self' )
  }
  function NoveVzd()
  {
   window.open('oznamenie_zrd2016.php?copern=801&strana=5&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>', '_self' )
  }


  function kopyZar(ulica, cislo, psc, mesto)
  {
   document.formv1.zzul.value = ulica;
   document.formv1.zzcs.value = cislo;
   document.formv1.zzps.value = psc;
   document.formv1.zzms.value = mesto;
   dzdrzar.style.display='none';

  }
  function kopyDrz(xdic, xmfo, xpfo, xnpo, xuli, xcis, xpsc, xmes, xtitulp, xtitulz )
  {
   document.formv1.xdic.value = xdic;
   document.formv1.xmfo.value = xmfo;
   document.formv1.xpfo.value = xpfo;
   document.formv1.xnpo.value = xnpo;
   document.formv1.xuli.value = xuli;
   document.formv1.xcis.value = xcis;
   document.formv1.xpsc.value = xpsc;
   document.formv1.xmes.value = xmes;
   document.formv1.xtitulp.value = xtitulp;
   document.formv1.xtitulz.value = xtitulz;

   ddrz.style.display='none';
  }

function ZRDXML()
                {

window.open('../mzdy/oznamenie_zrdxml2016.php?cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<?php if( $copern != 40 ) { ?>
<BODY onload="ObnovUI();">
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">Ozn·menie o dani z nepeÚaûnÈho plnenia -
<?php
$nazovplat=$cislo_xplat." ".$oc." ".$meno." ".$prie;
if ( $cislo_xplat > 9999 ) { $nazovplat=$cislo_xplat." ".$fir_fnazovx; }
?>
  <span class="subheader"><?php echo $nazovplat; ?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="InfoFRSR();"
         title="Aktu·lna inform·cia od FinanËnÈho riaditeæstva SR" class="btn-form-tool">
    <img src="../obr/ikony/upbox_blue_icon.png" onclick="ZRDXML();" title="Export do XML" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php //echo "copern ".$copern." strana ".$strana; ?>
<div id="content">
<FORM name="formv1" method="post"
      action="oznamenie_zrd2016.php?copern=801&cislo_cpl=<?php echo $cislo_cpl; ?>&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active";

$source="../mzdy/oznamenie_zrd2016.php?subor=0&h_stv=".$zaobdobie."&cislo_xplat=".$cislo_xplat;
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Zoznam drûiteæov</a>
<?php if ( $strana == 4 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">⁄prava drûiteæa</a>
<?php } ?>

 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=40&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=40&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=40&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 5 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php                     } ?>
</div>

<?php if ( $copern == 101 AND $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 1.strana">

<!-- ZAHLAVIE -->
<input type="text" name="mdic" id="mdic" maxlength="10" style="width:220px; top:470px; left:52px;"/>
<?php
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
?>
<span class="text-echo" style="top:475px; left:441px;"><?php echo "$t01$t02"; ?></span>
<input type="checkbox" name="opravne" value="1" style="top:455px; left:510px;"/>

<!-- I.PLATITEL -->
<!-- FO -->
<div class="input-echo" style="width:357px; top:582px; left:52px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:241px; top:582px; left:432px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:111px; top:582px; left:693px;"><?php echo $titulp; ?></div>
<div class="input-echo" style="width:66px; top:582px; left:827px;"><?php echo $titulz; ?></div>
<div class="input-echo" style="width:196px; top:636px; left:52px;"><?php echo $nar_sk; ?></div>
<!-- PO -->
<?php if ( $fir_uctt03 != 999 AND $cislo_xplat > 9999 ) { ?>
<div class="input-echo" style="width:840px; top:712px; left:52px;"><?php echo $fir_fnazx; ?></div>
<?php                           } ?>
<!-- Adresa -->
<div class="input-echo" style="width:634px; top:827px; left:52px;"><?php echo $zuli; ?></div>
<div class="input-echo" style="width:173px; top:827px; left:720px;"><?php echo $zcdm; ?></div>
<div class="input-echo" style="width:105px; top:882px; left:52px;"><?php echo $zpsc; ?></div>
<div class="input-echo" style="width:450px; top:882px; left:179px;"><?php echo $zmes; ?></div>
<div class="input-echo" style="width:245px; top:882px; left:649px;"><?php echo $zstat; ?></div>
<!-- Adresa SR -->
<input type="text" name="sruli" id="sruli" style="width:634px; top:956px; left:52px;"/>
<input type="text" name="srcdm" id="srcdm" style="width:173px; top:956px; left:720px;"/>
<input type="text" name="srpsc" id="srpsc" maxlength="5" style="width:105px; top:1011px; left:52px;"/>
<input type="text" name="srmes" id="srmes" style="width:703px; top:1011px; left:190px;"/>
<?php                                        }
//koniec copern == 101, strana 1
?>

<?php if ( $copern == 101 AND $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 2.strana">
<span class="text-echo" style="top:76px; left:337px;"><?php echo $mdic; ?></span>

<!-- Adresa zdravotnickeho zariadenie -->
<input type="text" name="zzul" id="zzul" style="width:634px; top:151px; left:52px;"/>
<input type="text" name="zzcs" id="zzcs" style="width:173px; top:151px; left:719px;"/>
<input type="text" name="zzps" id="zzps" style="width:105px; top:208px; left:52px;"/>
<input type="text" name="zzms" id="zzms" style="width:701px; top:208px; left:191px;"/>
<img src="../obr/ikony/list_blue_icon.png" onclick="dzdrzar.style.display='block';" title="Zobraziù uloûenÈ adresy" style="width:32px; height:32px; position:absolute; top:112px; right:6px; cursor:pointer;">

<!-- II.ODDIEL -->
<input type="text" name="r20" id="r20" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:283px; left:572px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="nacitajSumu();" title="VypoËÌtaù riadok 20 na z·klade prÌlohy" style="width:32px; height:32px; position:absolute; top:280px; right:6px; cursor:pointer;">
<input type="text" name="r21" id="r21" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:322px; left:572px;"/>
<input type="text" name="r21a" id="r21a" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:366px; left:572px;"/>
<input type="text" name="r22" id="r22" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:411px; left:572px;"/>
<input type="text" name="r23" id="r23" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:450px; left:572px;"/>
<img src="../obr/ikony/calculator_blue_icon.png" onclick="vypocitajDan();" title="VypoËÌtaù daÚ na riadku 23" style="width:32px; height:32px; position:absolute; top:447px; right:6px; cursor:pointer;">
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:488px; left:596px;"/>

<!-- III.ODDIEL -->
<div style="position: absolute; top: 557px; left: 46px; width: 858px; height: 433px; background-color: white;">&nbsp;</div>
<a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=5', '_self');" style="position: absolute; top: 750px; left: 400px; width: auto; background-color: #39f; color: white; font-size: 14px; border-radius: 3px; line-height: 36px; padding: 0 16px; letter-spacing: 0.02em;">Prejsù na zoznam drûiteæov</a>

<!-- IV.ODDIEL -->
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:1054px; left:566px;"/>
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:1094px; left:566px;"/>
<input type="text" name="r42" id="r42" style="width:36px; top:1133px; left:681px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:1171px; left:566px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:1211px; left:566px;"/>
<?php                       }
//koniec copern == 101, strana 2
?>

<?php if ( $copern == 101 AND $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 3.strana">
<span class="text-echo" style="top:76px; left:337px;"><?php echo $mdic; ?></span>

<!-- IV.ODDIEL pokrac. -->
<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:115px; left:566px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:128px; top:154px; left:658px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:194px; left:566px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:233px; left:566px;"/>
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:273px; left:566px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:339px; left:566px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:378px; left:566px;"/>
<input type="text" name="r52" id="r52" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:418px; left:566px;"/>

<!-- Vypracoval -->
<div class="input-echo" style="width:310px; top:478px; left:52px;"><?php echo $fir_mzdt05; ?></div>
<input type="text" name="datd" id="datd" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:198px; top:477px; left:385px;"/>
<div class="input-echo" style="width:290px; top:478px; left:602px;"><?php echo $fir_mzdt04; ?></div>
<!-- Prilozene strany -->
<div class="input-echo" style="width:105px; top:518px; left:242px; text-align:right;"><?php echo $prilohy; ?>&nbsp;</div>

<!-- V.ODDIEL -->
<input type="checkbox" name="vrat" value="1" style="top:619px; left:59px;"/>
<input type="checkbox" name="post" value="1" onchange="klikpost();" style="top:639px; left:116px;"/>
<input type="checkbox" name="ucet" value="1" onchange="klikucet();" style="top:639px; left:323px;"/>
<img src="../obr/ikony/info_blue_icon.png" title="IBAN z ˙dajov o zamestnancovi sa zobrazÌ, ak je vyplnen˝ riadok 52" style="width:24px; height:24px; position:absolute; top:667px; left: 10px;">
<?php if ( $r52 == 0 ) { $ziban=""; } ?>
<span class="text-echo" style="top:672px; left:120px;"><?php echo $ziban; ?></span>
<input type="text" name="datvrat" id="datvrat" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:707px; left:116px;"/>
<?php                       }
//koniec copern == 101, strana 3
?>

<?php if ( $copern == 101 AND $strana == 4 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str4.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 4.strana">
<span class="text-echo" style="top:76px; left:337px;"><?php echo $mdic; ?></span>

<!-- strankovanie -->
<span class="text-echo" style="top:138px; left:108px; width: 111px; text-align: right;"></span>
<span class="text-echo" style="top:138px; left:245px; width: 111px; text-align: right;"></span>

<!-- DRZITEL  -->
<?php if ( $dajnew == 1 ) { ?>
<img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="Pridaù drûiteæa" style="position:absolute; top:213px; left:9px; width:24px; height:24px; cursor:pointer;">
<?php                     } ?>
<img src="../obr/ikony/copy5_blue_x32.png" title="KopÌrovaù ˙daje drûiteæa" onclick="ddrz.style.display='block'"
     style="width:32px; height:32px; position:absolute; top:213px; right:6px; cursor:pointer;">
<input type="text" name="xdic" id="xdic" style="width:220px; top:234px; left:52px;"/>
<input type="text" name="prj" id="prj" onkeyup="CiarkaNaBodku(this);" style="width:220px; top:226px; left:630px;"/>

<!-- FO -->
<input type="text" name="xpfo" id="xpfo" style="width:358px; top:291px; left:52px;"/>
<input type="text" name="xmfo" id="xmfo" style="width:244px; top:291px; left:431px;"/>
<input type="text" name="xtitulp" id="xtitulp" style="width:113px; top:291px; left:692px;"/>
<input type="text" name="xtitulz" id="xtitulz" style="width:67px; top:291px; left:827px;"/>
<!-- PO -->
<input type="text" name="xnpo" id="xnpo" style="width:842px; top:349px; left:52px;"/>
<!-- Adresa -->
<input type="text" name="xuli" id="xuli" style="width:634px; top:408px; left:52px;"/>
<input type="text" name="xcis" id="xcis" style="width:173px; top:408px; left:719px;"/>
<input type="text" name="xpsc" id="xpsc" style="width:105px; top:464px; left:52px;"/>
<input type="text" name="xmes" id="xmes" style="width:450px; top:464px; left:178px;"/>
<input type="text" name="xstat" id="xstat" style="width:242px; top:464px; left:650px;"/>
<!-- Adresa prevadzkarne -->
<input type="text" name="xspuli" id="xspuli" style="width:634px; top:523px; left:52px;"/>
<input type="text" name="xspcdm" id="xspcdm" style="width:173px; top:523px; left:719px;"/>
<input type="text" name="xsppsc" id="xsppsc" style="width:105px; top:576px; left:52px;"/>
<input type="text" name="xspmes" id="xspmes" style="width:714px; top:576px; left:178px;"/>

<div style="position: absolute; top: 623px; left: 46px; width: 858px; height: 396px; background-color: white;">&nbsp;</div>
<?php                       }
//koniec copern == 101, strana 4
?>

<?php if ( $copern == 101 AND $strana == 5 ) {
//ZOZNAM DRZITELOV
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY cpl";
$sluz = mysql_query("$sqltt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <div>
  <h2 class="toleft" style="font-size:18px;">Drûitelia a v˝öka nepeÚaûnÈho plnenia</h2>
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="Nov˝ drûiteæ" class="toleft" style="margin:10px 0 0 10px;">
 </div>
 <table class="vozidla">
 <thead>
 <tr>
  <th width="15%">&nbsp;DI»</th>
  <th width="45%">FO / PO</th>
  <th width="15%" style="text-align:right;">PrijatÈ peÚaûnÈ plnenie</th>
  <th width="25%">&nbsp;</th>
 </tr>
 </thead>
<?php
$i=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
 {
$rsluz=mysql_fetch_object($sluz);
?>
 <tbody>
 <tr>
  <td>&nbsp;<?php echo $rsluz->xdic;?></td>
  <td><?php echo $rsluz->xmfo." ".$rsluz->xpfo." ".$rsluz->xnpo;?></td>
  <td style="text-align:right;"><?php echo $rsluz->prj;?></td>
  <td>
   <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl;?>);"
        title="Vymazaù" class="toright" style="margin-right:80px;">
   <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl;?>);"
        title="Upraviù" class="toright" style="margin-right:20px;">
  </td>
 </tr>
 </tbody>
<?php
 }
$i=$i+1;
   }
?>
 <tfoot>
 <tr>
  <td colspan="2">&nbsp;SPOLU </td>
  <td style="text-align:right;"><strong><?php echo $r15;?></strong></td>
  <td>&nbsp;</td>
 </tr>
 </tfoot>
 </table>
</div>
<?php                                        }
//koniec copern == 101, strana 5
?>


<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=1', '_self');"
    class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=5', '_self');"
    class="<?php echo $clas5; ?> toleft">Zoznam drûiteæov</a>
<?php if ( $strana == 4 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=4', '_self');"
    class="<?php echo $clas4; ?> toleft">⁄prava drûiteæa</a>
<?php                     } ?>
<?php if ( $strana != 5 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>

<?php
//drzitel
if ( $copern == 101 AND $strana == 3  )
     {
$sqltt = "DROP TABLE F$kli_vxcf"."_mzdoznameniezrdpolx$kli_uzid ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzdoznameniezrdpolx".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xdic > 0 ";
$sql = mysql_query("$sqltt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpolx$kli_uzid WHERE xmes != '' GROUP BY xdic,xnpo,xmfo,xnpo,xuli,xmes ";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
?>
<div id="ddrz" class="wrap-zariadenia" style="display:none; width:600px; top:178px;">
 <h4 style="font-size:15px; float:left; line-height:20px; position:relative; top:3px;">&nbsp;Drûitelia</h4>
 <img src="../obr/ikony/turnoff_blue_icon.png" onclick="ddrz.style.display='none';"
      title="Skryù" style="width:20px; height:20px; float:right;
                           position:absolute; top:7px; right:8px;">
 <table class="zariadenia">
 <tr>
  <th style="width:62%;">&nbsp;&nbsp;DiË N·zov</th>
  <th style="width:38%;">Mesto</th>
 </tr>
<?php
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
 <tr>
  <td>&nbsp;&nbsp;<?php echo "$riadok->xdic $riadok->xnpo $riadok->xmfo $riadok->xpfo"; ?></td>
  <td><?php echo $riadok->xmes; ?>&nbsp;
   <img src="../obr/ikony/copy5_blue_x32.png" title="KopÌrovaù drûiteæa"
onclick="kopyDrz('<?php echo $riadok->xdic; ?>','<?php echo $riadok->xmfo; ?>','<?php echo $riadok->xpfo; ?>','<?php echo $riadok->xnpo; ?>','<?php echo $riadok->xuli; ?>','<?php echo $riadok->xcis; ?>','<?php echo $riadok->xpsc; ?>','<?php echo $riadok->xmes; ?>','<?php echo $riadok->xtitulp; ?>','<?php echo $riadok->xtitulz; ?>')"
style="width:22px; height:22px; position:relative; top:4px;">
  </td>
 </tr>
<?php
  }
$i=$i+1;
   }
?>
 </table>
</div> <!-- .wrap-zariadenia -->
<?php
     }
//koniec drzitel
?>

<?php
//zdrav.zariadenia
if ( $copern == 101 AND $strana == 1  )
     {
$sqltt = "DROP TABLE F$kli_vxcf"."_mzdoznameniezrdx$kli_uzid ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzdoznameniezrdx".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ";
$sql = mysql_query("$sqltt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdx$kli_uzid WHERE zzms != '' GROUP BY zzms, zzul, zzcs ";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;
?>
<div id="dzdrzar" class="wrap-zariadenia" style="display:none;">
 <h4 style="font-size:15px; float:left; line-height:20px; position:relative; top:3px;">&nbsp;Adresy zdravotnÌckych zariadenÌ</h4>
 <img src="../obr/ikony/turnoff_blue_icon.png" onclick="dzdrzar.style.display='none';"
      title="Skryù" style="width:20px; height:20px; float:right;
                           position:absolute; top:7px; right:8px;">
 <table class="zariadenia">
 <tr>
  <th style="width:55%;">&nbsp;&nbsp;Ulica ËÌslo</th>
  <th style="width:45%;">Mesto</th>
 </tr>
<?php
   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
 <tr>
  <td>&nbsp;&nbsp;<?php echo "$riadok->zzul $riadok->zzcs"; ?></td>
  <td><?php echo $riadok->zzms; ?>&nbsp;
   <img src="../obr/ikony/copy5_blue_x32.png" title="KopÌrovaù adresu zariadenia"
onclick="kopyZar('<?php echo $riadok->zzul; ?>','<?php echo $riadok->zzcs; ?>','<?php echo $riadok->zzps; ?>','<?php echo $riadok->zzms; ?>')"
style="width:22px; height:22px; position:relative; top:4px;">
  </td>
 </tr>
<?php
  }
$i=$i+1;
   }
?>
 </table>
</div> <!-- .wrap-zariadenia -->
<script type="text/javascript">

</script>
<?php
     }
//koniec zdrav.zariadenia
?>
</div> <!-- koniec #content -->


<?php //koniec ak copern != 40 ?>
<?php                     } ?>

<?php
///////////////////////////////////////////////////VYTLAC oznamenie
if ( $copern == 40 )
{
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


 $outfilexdel="../tmp/oznzrd_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/oznzrd_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i == 0 )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,92," ","$rmc1",1,"L");
$text="1234567890";
$text=$mdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//za obdobie
$pdf->Cell(34,6," ","$rmc1",0,"C");
$text=$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
//$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
//$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//opravne
$pdf->SetY(99);
$text=" "; if ( $hlavicka->opravne == 1 ) $text="x";
$pdf->Cell(105,5," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//FO
//priezvisko
$pdf->Cell(190,26,"","$rmc1",1,"L");
$A=substr($prie,0,1);
$B=substr($prie,1,1);
$C=substr($prie,2,1);
$D=substr($prie,3,1);
$E=substr($prie,4,1);
$F=substr($prie,5,1);
$G=substr($prie,6,1);
$H=substr($prie,7,1);
$I=substr($prie,8,1);
$J=substr($prie,9,1);
$K=substr($prie,10,1);
$L=substr($prie,11,1);
$M=substr($prie,12,1);
$N=substr($prie,13,1);
$O=substr($prie,14,1);
$P=substr($prie,15,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//meno
$A=substr($meno,0,1);
$B=substr($meno,1,1);
$C=substr($meno,2,1);
$D=substr($meno,3,1);
$E=substr($meno,4,1);
$F=substr($meno,5,1);
$G=substr($meno,6,1);
$H=substr($meno,7,1);
$I=substr($meno,8,1);
$J=substr($meno,9,1);
$K=substr($meno,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
//tituly
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(26,6,"$titulp","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$titulz","$rmc",1,"L");
//datum narodenia
$pdf->Cell(190,6,"","$rmc1",1,"L");
$text=$nar_sk;
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da5=substr($text,6,1);
$da6=substr($text,7,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da5","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da6","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//PO
//nazov
$pdf->Cell(190,11," ","$rmc1",1,"L");
$A=substr($fir_fnazx,0,1);
$B=substr($fir_fnazx,1,1);
$C=substr($fir_fnazx,2,1);
$D=substr($fir_fnazx,3,1);
$E=substr($fir_fnazx,4,1);
$F=substr($fir_fnazx,5,1);
$G=substr($fir_fnazx,6,1);
$H=substr($fir_fnazx,7,1);
$I=substr($fir_fnazx,8,1);
$J=substr($fir_fnazx,9,1);
$K=substr($fir_fnazx,10,1);
$L=substr($fir_fnazx,11,1);
$M=substr($fir_fnazx,12,1);
$N=substr($fir_fnazx,13,1);
$O=substr($fir_fnazx,14,1);
$P=substr($fir_fnazx,15,1);
$R=substr($fir_fnazx,16,1);
$S=substr($fir_fnazx,17,1);
$T=substr($fir_fnazx,18,1);
$U=substr($fir_fnazx,19,1);
$V=substr($fir_fnazx,20,1);
$W=substr($fir_fnazx,21,1);
$X=substr($fir_fnazx,22,1);
$Y=substr($fir_fnazx,23,1);
$Z=substr($fir_fnazx,24,1);
$A1=substr($fir_fnazx,25,1);
$B1=substr($fir_fnazx,26,1);
$C1=substr($fir_fnazx,27,1);
$D1=substr($fir_fnazx,28,1);
$E1=substr($fir_fnazx,29,1);
$F1=substr($fir_fnazx,30,1);
$G1=substr($fir_fnazx,31,1);
$H1=substr($fir_fnazx,32,1);
$I1=substr($fir_fnazx,33,1);
$J1=substr($fir_fnazx,34,1);
$K1=substr($fir_fnazx,35,1);
$L1=substr($fir_fnazx,36,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$A=substr($fir_fnazx1,0,1);
$B=substr($fir_fnazx1,1,1);
$C=substr($fir_fnazx1,2,1);
$D=substr($fir_fnazx1,3,1);
$E=substr($fir_fnazx1,4,1);
$F=substr($fir_fnazx1,5,1);
$G=substr($fir_fnazx1,6,1);
$H=substr($fir_fnazx1,7,1);
$I=substr($fir_fnazx1,8,1);
$J=substr($fir_fnazx1,9,1);
$K=substr($fir_fnazx1,10,1);
$L=substr($fir_fnazx1,11,1);
$M=substr($fir_fnazx1,12,1);
$N=substr($fir_fnazx1,13,1);
$O=substr($fir_fnazx1,14,1);
$P=substr($fir_fnazx1,15,1);
$R=substr($fir_fnazx1,16,1);
$S=substr($fir_fnazx1,17,1);
$T=substr($fir_fnazx1,18,1);
$U=substr($fir_fnazx1,19,1);
$V=substr($fir_fnazx1,20,1);
$W=substr($fir_fnazx1,21,1);
$X=substr($fir_fnazx1,22,1);
$Y=substr($fir_fnazx1,23,1);
$Z=substr($fir_fnazx1,24,1);
$A1=substr($fir_fnazx1,25,1);
$B1=substr($fir_fnazx1,26,1);
$C1=substr($fir_fnazx1,27,1);
$D1=substr($fir_fnazx1,28,1);
$E1=substr($fir_fnazx1,29,1);
$F1=substr($fir_fnazx1,30,1);
$G1=substr($fir_fnazx1,31,1);
$H1=substr($fir_fnazx1,32,1);
$I1=substr($fir_fnazx1,33,1);
$J1=substr($fir_fnazx1,34,1);
$K1=substr($fir_fnazx1,35,1);
$L1=substr($fir_fnazx1,36,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//ADRESA
//ulica
$pdf->Cell(190,11,"","$rmc1",1,"L");
$A=substr($zuli,0,1);
$B=substr($zuli,1,1);
$C=substr($zuli,2,1);
$D=substr($zuli,3,1);
$E=substr($zuli,4,1);
$F=substr($zuli,5,1);
$G=substr($zuli,6,1);
$H=substr($zuli,7,1);
$I=substr($zuli,8,1);
$J=substr($zuli,9,1);
$K=substr($zuli,10,1);
$L=substr($zuli,11,1);
$M=substr($zuli,12,1);
$N=substr($zuli,13,1);
$O=substr($zuli,14,1);
$P=substr($zuli,15,1);
$R=substr($zuli,16,1);
$S=substr($zuli,17,1);
$T=substr($zuli,18,1);
$U=substr($zuli,19,1);
$V=substr($zuli,20,1);
$W=substr($zuli,21,1);
$X=substr($zuli,22,1);
$Y=substr($zuli,23,1);
$Z=substr($zuli,24,1);
$A1=substr($zuli,25,1);
$B1=substr($zuli,26,1);
$C1=substr($zuli,27,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$A=substr($zcdm,0,1);
$B=substr($zcdm,1,1);
$C=substr($zcdm,2,1);
$D=substr($zcdm,3,1);
$E=substr($zcdm,4,1);
$F=substr($zcdm,5,1);
$G=substr($zcdm,6,1);
$H=substr($zcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$zpsc=str_replace(" ","",$zpsc);
$A=substr($zpsc,0,1);
$B=substr($zpsc,1,1);
$C=substr($zpsc,2,1);
$D=substr($zpsc,3,1);
$E=substr($zpsc,4,1);
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$A=substr($zmes,0,1);
$B=substr($zmes,1,1);
$C=substr($zmes,2,1);
$D=substr($zmes,3,1);
$E=substr($zmes,4,1);
$F=substr($zmes,5,1);
$G=substr($zmes,6,1);
$H=substr($zmes,7,1);
$I=substr($zmes,8,1);
$J=substr($zmes,9,1);
$K=substr($zmes,10,1);
$L=substr($zmes,11,1);
$M=substr($zmes,12,1);
$N=substr($zmes,13,1);
$O=substr($zmes,14,1);
$P=substr($zmes,15,1);
$R=substr($zmes,16,1);
$S=substr($zmes,17,1);
$T=substr($zmes,18,1);
$U=substr($zmes,19,1);
$V=substr($zmes,20,1);
$W=substr($zmes,21,1);
$X=substr($zmes,22,1);
$Y=substr($zmes,23,1);
$Z=substr($zmes,24,1);
$A1=substr($zmes,25,1);
$B1=substr($zmes,26,1);
$C1=substr($zmes,27,1);
$D1=substr($zmes,28,1);
$E1=substr($zmes,29,1);
$F1=substr($zmes,30,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
//stat
$A=substr($zstat,0,1);
$B=substr($zstat,1,1);
$C=substr($zstat,2,1);
$D=substr($zstat,3,1);
$E=substr($zstat,4,1);
$F=substr($zstat,5,1);
$G=substr($zstat,6,1);
$H=substr($zstat,7,1);
$I=substr($zstat,8,1);
$J=substr($zstat,9,1);
$K=substr($zstat,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");

//ADRESA SR
//ulica
$pdf->Cell(190,11,"","$rmc1",1,"L");
$A=substr($sruli,0,1);
$B=substr($sruli,1,1);
$C=substr($sruli,2,1);
$D=substr($sruli,3,1);
$E=substr($sruli,4,1);
$F=substr($sruli,5,1);
$G=substr($sruli,6,1);
$H=substr($sruli,7,1);
$I=substr($sruli,8,1);
$J=substr($sruli,9,1);
$K=substr($sruli,10,1);
$L=substr($sruli,11,1);
$M=substr($sruli,12,1);
$N=substr($sruli,13,1);
$O=substr($sruli,14,1);
$P=substr($sruli,15,1);
$R=substr($sruli,16,1);
$S=substr($sruli,17,1);
$T=substr($sruli,18,1);
$U=substr($sruli,19,1);
$V=substr($sruli,20,1);
$W=substr($sruli,21,1);
$X=substr($sruli,22,1);
$Y=substr($sruli,23,1);
$Z=substr($sruli,24,1);
$A1=substr($sruli,25,1);
$B1=substr($sruli,26,1);
$C1=substr($sruli,27,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$A=substr($srcdm,0,1);
$B=substr($srcdm,1,1);
$C=substr($srcdm,2,1);
$D=substr($srcdm,3,1);
$E=substr($srcdm,4,1);
$F=substr($srcdm,5,1);
$G=substr($srcdm,6,1);
$H=substr($srcdm,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$zzps=str_replace(" ","",$srpsc);
$A=substr($zzps,0,1);
$B=substr($zzps,1,1);
$C=substr($zzps,2,1);
$D=substr($zzps,3,1);
$E=substr($zzps,4,1);
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$A=substr($srmes,0,1);
$B=substr($srmes,1,1);
$C=substr($srmes,2,1);
$D=substr($srmes,3,1);
$E=substr($srmes,4,1);
$F=substr($srmes,5,1);
$G=substr($srmes,6,1);
$H=substr($srmes,7,1);
$I=substr($srmes,8,1);
$J=substr($srmes,9,1);
$K=substr($srmes,10,1);
$L=substr($srmes,11,1);
$M=substr($srmes,12,1);
$N=substr($srmes,13,1);
$O=substr($srmes,14,1);
$P=substr($srmes,15,1);
$R=substr($srmes,16,1);
$S=substr($srmes,17,1);
$T=substr($srmes,18,1);
$U=substr($srmes,19,1);
$V=substr($srmes,20,1);
$W=substr($srmes,21,1);
$X=substr($srmes,22,1);
$Y=substr($srmes,23,1);
$Z=substr($srmes,24,1);
$A1=substr($srmes,25,1);
$B1=substr($srmes,26,1);
$C1=substr($srmes,27,1);
$D1=substr($srmes,28,1);
$E1=substr($srmes,29,1);
$F1=substr($srmes,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");
                                       } //koniec 1.strany


if ( $strana == 2 OR $strana == 9999 ) {
$sqlttv = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic LIMIT 1 ";
$sqlv = mysql_query("$sqlttv");
$polv = mysql_num_rows($sqlv);
$iv=0;

  while ($iv <= 1 )
  {
  if (@$zaznam=mysql_data_seek($sqlv,$iv) OR $iv == 0 )
{
$hlavickav=mysql_fetch_object($sqlv);

if ( $iv == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="1234567890";
$text=$mdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(66,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ADRESA ZARIADENIA
//ulica
$pdf->Cell(190,14,"","$rmc1",1,"L");
$A=substr($zzul,0,1);
$B=substr($zzul,1,1);
$C=substr($zzul,2,1);
$D=substr($zzul,3,1);
$E=substr($zzul,4,1);
$F=substr($zzul,5,1);
$G=substr($zzul,6,1);
$H=substr($zzul,7,1);
$I=substr($zzul,8,1);
$J=substr($zzul,9,1);
$K=substr($zzul,10,1);
$L=substr($zzul,11,1);
$M=substr($zzul,12,1);
$N=substr($zzul,13,1);
$O=substr($zzul,14,1);
$P=substr($zzul,15,1);
$R=substr($zzul,16,1);
$S=substr($zzul,17,1);
$T=substr($zzul,18,1);
$U=substr($zzul,19,1);
$V=substr($zzul,20,1);
$W=substr($zzul,21,1);
$X=substr($zzul,22,1);
$Y=substr($zzul,23,1);
$Z=substr($zzul,24,1);
$A1=substr($zzul,25,1);
$B1=substr($zzul,26,1);
$C1=substr($zzul,27,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$A=substr($zzcs,0,1);
$B=substr($zzcs,1,1);
$C=substr($zzcs,2,1);
$D=substr($zzcs,3,1);
$E=substr($zzcs,4,1);
$F=substr($zzcs,5,1);
$G=substr($zzcs,6,1);
$H=substr($zzcs,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$zzps=str_replace(" ","",$zzps);
$A=substr($zzps,0,1);
$B=substr($zzps,1,1);
$C=substr($zzps,2,1);
$D=substr($zzps,3,1);
$E=substr($zzps,4,1);
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$A=substr($zzms,0,1);
$B=substr($zzms,1,1);
$C=substr($zzms,2,1);
$D=substr($zzms,3,1);
$E=substr($zzms,4,1);
$F=substr($zzms,5,1);
$G=substr($zzms,6,1);
$H=substr($zzms,7,1);
$I=substr($zzms,8,1);
$J=substr($zzms,9,1);
$K=substr($zzms,10,1);
$L=substr($zzms,11,1);
$M=substr($zzms,12,1);
$N=substr($zzms,13,1);
$O=substr($zzms,14,1);
$P=substr($zzms,15,1);
$R=substr($zzms,16,1);
$S=substr($zzms,17,1);
$T=substr($zzms,18,1);
$U=substr($zzms,19,1);
$V=substr($zzms,20,1);
$W=substr($zzms,21,1);
$X=substr($zzms,22,1);
$Y=substr($zzms,23,1);
$Z=substr($zzms,24,1);
$A1=substr($zzms,25,1);
$B1=substr($zzms,26,1);
$C1=substr($zzms,27,1);
$D1=substr($zzms,28,1);
$E1=substr($zzms,29,1);
$F1=substr($zzms,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");

//SUHRNNE UDAJE
//riadok 20
$pdf->Cell(190,11," ","$rmc1",1,"L");
$hodx=100*$r20;
//if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
//$text="12456789";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 21
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r21;
//if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
//$text="12456789";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 21a
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$r21a;
//if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
//$text="123456789";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 22
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$r22;
//if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
//$text="12456789";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 23
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r23;
//if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
//$text="123456789";
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(119,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//datum odvedenia
$pdf->Cell(190,3,"","$rmc1",1,"L");
$text=SkDatum($hlavicka->datum);
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(124,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//III.ODDIEL = 1.drzitel
$pdf->SetY(121);
}

//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavickav->xdic;
if( $text == 0 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//vyska plnenia
$pdf->Cell(190,-2," ","$rmc1",1,"L");
$hodx=100*$hlavickav->prj;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//FO
//priezvisko
$pdf->Cell(190,9,"","$rmc1",1,"L");
$text=$hlavickav->xpfo;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//meno
$text=$hlavickav->xmfo;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
//tituly
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(26,6,"$hlavickav->xtitulp","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$hlavickav->xtitulz","$rmc",1,"L");
//datum narodenia
$pdf->Cell(190,6,"","$rmc1",1,"L");
//PO
//nazov
$pdf->Cell(190,1," ","$rmc1",1,"L");
$text=$hlavickav->xnpo;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//ADRESA
//ulica
$pdf->Cell(190,8,"","$rmc1",1,"L");
$text=$hlavickav->xuli;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavickav->xcis;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$text=$hlavickav->xpsc;
$text=str_replace(" ","",$text);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavickav->xmes;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
//stat
$A=substr($xstat,0,1);
$B=substr($xstat,1,1);
$C=substr($xstat,2,1);
$D=substr($xstat,3,1);
$E=substr($xstat,4,1);
$F=substr($xstat,5,1);
$G=substr($xstat,6,1);
$H=substr($xstat,7,1);
$I=substr($xstat,8,1);
$J=substr($xstat,9,1);
$K=substr($xstat,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
//PREVADZKAREN
//ulica
$pdf->Cell(190,7,"","$rmc1",1,"L");
$text=$hlavickav->xspuli;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavickav->xspcdm;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$text=$hlavickav->xsppsc;
$text=str_replace(" ","",$text);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(190,6,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavickav->xspmes;
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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");

//IV.ODDIEL
//riadok 40
$pdf->Cell(190,24," ","$rmc1",1,"L");
$hodx=100*$r40;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 41
$pdf->Cell(190,4," ","$rmc1",1,"L");
$hodx=100*$r41;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 42
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=$r42;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(143,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",1,"C");
//riadok 43
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r43;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 41
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r44;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
                }
$iv = $iv + 1;
  }
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {

$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$text="1234567890";
$text=$mdic;
if ( $text == 0 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(66,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//IV.ODDIEL pokrac.
//riadok 45
$pdf->Cell(190,10," ","$rmc1",1,"L");
$hodx=100*$r45;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 46
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r46;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 47
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r47;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 48
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r48;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 49
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r49;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 50
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$r50;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 51
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r51;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 52
$pdf->Cell(190,3," ","$rmc1",1,"L");
$hodx=100*$r52;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");

//Vypracoval
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(69,6,"$fir_mzdt05","$rmc",0,"L");
//dna
$text=SkDatum($hlavicka->datd);
$da1=substr($text,0,1);
$da2=substr($text,1,1);
$da3=substr($text,3,1);
$da4=substr($text,4,1);
$da7=substr($text,8,1);
$da8=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",0,"C");
//telefon
$text=str_replace("/","",$fir_mzdt04);
$t01=substr($text,0,1);
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t13","$rmc",1,"C");
//prilohy
$pdf->Cell(190,3,"","$rmc1",1,"L");
$textx=$prilohy;
if ( $textx == 0 ) $textx="";
$text=sprintf("% 5s",$textx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(45,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",1,"C");

//V.ODDIEL
//vratenie
$text=" "; if ( $hlavicka->vrat == 1 ) $text="x";
$pdf->Cell(190,17," ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text","$rmc",1,"C");
//postovou poukazkou / na ucet
$pdf->Cell(190,1," ","$rmc1",1,"L");
$textp=" "; if ( $hlavicka->post == 1 ) $textp="x";
$textb=" "; if ( $hlavicka->ucet == 1 ) $textb="x";
$pdf->Cell(18,5," ","$rmc1",0,"R");$pdf->Cell(4,3,"$textp","$rmc",0,"C");$pdf->Cell(42,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$textb","$rmc",1,"C");
//iban
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$ziban;
if ( $hlavicka->r52 == 0 ) $text="";
$t01=substr($text,0,1);
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
$pdf->Cell(190,4," ","$rmc1",1,"L");
$text="123456";
$text=SKDatum($hlavicka->datvrat);
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
                                       } //koniec 3.strany

}
$i = $i + 1;
  }

if ( $strana == 4 OR $strana == 9999 ) {
$stranav=0;
$sqlttv = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic LIMIT 1,100 ";
$sqlv = mysql_query("$sqlttv");
$polv = mysql_num_rows($sqlv);
//echo $polv;
//exit;
$iv=0;
$jv=0; //zaciatok strany ak by som chcel strankovat

  while ($iv <= $polv )
  {
  if (@$zaznam=mysql_data_seek($sqlv,$iv))
{
$hlavickav=mysql_fetch_object($sqlv);

if ( $jv == 0 ) {
$stranav=$stranav+1;
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str4.jpg') )
{
$pdf->Image($jpg_cesta.'_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text="1234567890";
$text=$mdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(66,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//strana
$pdf->Cell(190,9,"","$rmc1",1,"L");
$textx=$stranav;
$text=sprintf("% 5s",$textx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(15,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//pocet stran
$textx=$prilohy;
$text=sprintf("% 5s",$textx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",1,"C");
                }

//1.DRZITEL V PRILOHE
if ( $jv == 0 ) { $pdf->SetY(42); }
//2.DRZITEL V PRILOHE
if ( $jv == 1 ) { $pdf->SetY(136); }

//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavickav->xdic;
if( $text == 0 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//vyska plnenia
$pdf->Cell(190,-2," ","$rmc1",1,"L");
$hodx=100*$hlavickav->prj;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 9s",$hodx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$I=substr($text,8,1);
$pdf->Cell(131,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//FO
//priezvisko
$pdf->Cell(190,9,"","$rmc1",1,"L");
$text=$hlavickav->xpfo;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//meno
$text=$hlavickav->xmfo;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
//tituly
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(26,6,"$hlavickav->xtitulp","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$hlavickav->xtitulz","$rmc",1,"L");
//datum narodenia
$pdf->Cell(190,6,"","$rmc1",1,"L");
//PO
//nazov
$pdf->Cell(190,1," ","$rmc1",1,"L");
$text=$hlavickav->xnpo;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");
//ADRESA
//ulica
$pdf->Cell(190,8,"","$rmc1",1,"L");
$text=$hlavickav->xuli;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavickav->xcis;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$text=$hlavickav->xpsc;
$text=str_replace(" ","",$text);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(190,7,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavickav->xmes;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
//stat
$A=substr($xstat,0,1);
$B=substr($xstat,1,1);
$C=substr($xstat,2,1);
$D=substr($xstat,3,1);
$E=substr($xstat,4,1);
$F=substr($xstat,5,1);
$G=substr($xstat,6,1);
$H=substr($xstat,7,1);
$I=substr($xstat,8,1);
$J=substr($xstat,9,1);
$K=substr($xstat,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
//PREVADZKAREN
//ulica
$pdf->Cell(190,7,"","$rmc1",1,"L");
$text=$hlavickav->xspuli;
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
//cislo
$text=$hlavickav->xspcdm;
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",1,"C");
//psc
$text=$hlavickav->xsppsc;
$text=str_replace(" ","",$text);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(190,6,"","$rmc1",1,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
//obec
$text=$hlavickav->xspmes;
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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",1,"C");

}
$iv = $iv + 1;
$jv = $jv + 1;
if ( $jv == 2 ) { $jv=0; }
  }
                                       } //koniec 4.strany
$pdf->Output("$outfilex");


?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
}
///////////////////////////////////////////////////KONIEC TLAC oznamenie copern=40
?>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>