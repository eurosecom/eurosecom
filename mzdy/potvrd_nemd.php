<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

// znovu nacitaj
if ( $copern == 26 )
    {
$uzjezaznam=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienemd WHERE oc = ".$cislo_oc;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $vz01_08=$riaddok->vz01;
  $vz02_08=$riaddok->vz02;
  $vz03_08=$riaddok->vz03;
  $vz04_08=$riaddok->vz04;
  $vz05_08=$riaddok->vz05;
  $vz06_08=$riaddok->vz06;
  $vz07_08=$riaddok->vz07;
  $vz08_08=$riaddok->vz08;
  $vz09_08=$riaddok->vz09;
  $vz10_08=$riaddok->vz10;
  $vz11_08=$riaddok->vz11;
  $vz12_08=$riaddok->vz12;
  $rdstav_08=$riaddok->rdstav;
  $uzemie_08=$riaddok->uzemie;
  $fe101_08=$riaddok->fe101;
  $text51_08=$riaddok->text51;
  $text52_08=$riaddok->text52;
  $text53_08=$riaddok->text53;
  $vzodhad_08=$riaddok->vzodhad;
  $pozn_08=$riaddok->pozn;
  $str2_08=$riaddok->str2;
$uzjezaznam=1;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdpotvrdenienemd WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
    }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
    {

$rdstav = strip_tags($_REQUEST['rdstav']);
$uzemie = strip_tags($_REQUEST['uzemie']);
$napprc = strip_tags($_REQUEST['napprc']);
$preod1 = strip_tags($_REQUEST['preod1']);
$predo1 = strip_tags($_REQUEST['predo1']);
$predv1 = strip_tags($_REQUEST['predv1']);
$preod2 = strip_tags($_REQUEST['preod2']);
$predo2 = strip_tags($_REQUEST['predo2']);
$predv2 = strip_tags($_REQUEST['predv2']);
$preod3 = strip_tags($_REQUEST['preod3']);
$predo3 = strip_tags($_REQUEST['predo3']);
$predv3 = strip_tags($_REQUEST['predv3']);
$preod4 = strip_tags($_REQUEST['preod4']);
$predo4 = strip_tags($_REQUEST['predo4']);
$predv4 = strip_tags($_REQUEST['predv4']);
$fe101 = strip_tags($_REQUEST['fe101']);
$text51 = strip_tags($_REQUEST['text51']);
$text52 = strip_tags($_REQUEST['text52']);
$text53 = strip_tags($_REQUEST['text53']);
$vz01 = strip_tags($_REQUEST['vz01']);
$vz02 = strip_tags($_REQUEST['vz02']);
$vz03 = strip_tags($_REQUEST['vz03']);
$vz04 = strip_tags($_REQUEST['vz04']);
$vz05 = strip_tags($_REQUEST['vz05']);
$vz06 = strip_tags($_REQUEST['vz06']);
$vz07 = strip_tags($_REQUEST['vz07']);
$vz08 = strip_tags($_REQUEST['vz08']);
$vz09 = strip_tags($_REQUEST['vz09']);
$vz10 = strip_tags($_REQUEST['vz10']);
$vz11 = strip_tags($_REQUEST['vz11']);
$vz12 = strip_tags($_REQUEST['vz12']);
$vzspolu = strip_tags($_REQUEST['vzspolu']);
$vo01 = strip_tags($_REQUEST['vo01']);
$vo02 = strip_tags($_REQUEST['vo02']);
$vo03 = strip_tags($_REQUEST['vo03']);
$vo04 = strip_tags($_REQUEST['vo04']);
$vo05 = strip_tags($_REQUEST['vo05']);
$vo06 = strip_tags($_REQUEST['vo06']);
$vo07 = strip_tags($_REQUEST['vo07']);
$vo08 = strip_tags($_REQUEST['vo08']);
$vo09 = strip_tags($_REQUEST['vo09']);
$vo10 = strip_tags($_REQUEST['vo10']);
$vo11 = strip_tags($_REQUEST['vo11']);
$vo12 = strip_tags($_REQUEST['vo12']);
$vzodhad = strip_tags($_REQUEST['vzodhad']);
$pozn = strip_tags($_REQUEST['pozn']);
$str2 = strip_tags($_REQUEST['str2']);

$uprav="NO";

$napprc_sql=SqlDatum($napprc);

$preod1_sql=SqlDatum($preod1);
$predo1_sql=SqlDatum($predo1);
$preod2_sql=SqlDatum($preod2);
$predo2_sql=SqlDatum($predo2);
$preod3_sql=SqlDatum($preod3);
$predo3_sql=SqlDatum($predo3);
$preod4_sql=SqlDatum($preod4);
$predo4_sql=SqlDatum($predo4);


$uprtxt = "UPDATE F$kli_vxcf"."_mzdpotvrdenienemd SET ".
" rdstav='$rdstav', uzemie='$uzemie', napprc='$napprc_sql',  ".
" preod1='$preod1_sql', predo1='$predo1_sql', predv1='$predv1', ".
" preod2='$preod2_sql', predo2='$predo2_sql', predv2='$predv2', ".
" preod3='$preod3_sql', predo3='$predo3_sql', predv3='$predv3', ".
" preod4='$preod4_sql', predo4='$predo4_sql', predv4='$predv4', ".
" fe101='$fe101', text51='$text51', text52='$text52', text53='$text53',".
" vz01='$vz01', vz02='$vz02', vz03='$vz03', vz04='$vz04', vz05='$vz05', vz06='$vz06', ".
" vz07='$vz07', vz08='$vz08', vz09='$vz09', vz10='$vz10', vz11='$vz11', vz12='$vz12', vzodhad='$vzodhad', ".
" vo01='$vo01', vo02='$vo02', vo03='$vo03', vo04='$vo04', vo05='$vo05', vo06='$vo06', ".
" vo07='$vo07', vo08='$vo08', vo09='$vo09', vo10='$vo10', vo11='$vo11', vo12='$vo12', ".
" pozn='$pozn', str2='$str2' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  
$copern=10;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov


//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   rdstav       DECIMAL(1,0) DEFAULT 0,
   uzemie       DECIMAL(1,0) DEFAULT 0,
   napprc       DATE,
   preod1       DATE,
   predo1       DATE,
   predv1       VARCHAR(60),
   preod2       DATE,
   predo2       DATE,
   predv2       VARCHAR(60),
   preod3       DATE,
   predo3       DATE,
   predv3       VARCHAR(60),
   preod4       DATE,
   predo4       DATE,
   predv4       VARCHAR(60),
   fe101        DECIMAL(1,0) DEFAULT 0,
   text51       VARCHAR(100),
   text52       VARCHAR(100),
   text53       VARCHAR(100),
   vz01         DECIMAL(10,2) DEFAULT 0,
   vz02         DECIMAL(10,2) DEFAULT 0,
   vz03         DECIMAL(10,2) DEFAULT 0,
   vz04         DECIMAL(10,2) DEFAULT 0,
   vz05         DECIMAL(10,2) DEFAULT 0,
   vz06         DECIMAL(10,2) DEFAULT 0,
   vz07         DECIMAL(10,2) DEFAULT 0,
   vz08         DECIMAL(10,2) DEFAULT 0,
   vz09         DECIMAL(10,2) DEFAULT 0,
   vz10         DECIMAL(10,2) DEFAULT 0,
   vz11         DECIMAL(10,2) DEFAULT 0,
   vz12         DECIMAL(10,2) DEFAULT 0,
   vzspolu      DECIMAL(10,2) DEFAULT 0,
   vo01         DECIMAL(4,0) DEFAULT 0,
   vo02         DECIMAL(4,0) DEFAULT 0,
   vo03         DECIMAL(4,0) DEFAULT 0,
   vo04         DECIMAL(4,0) DEFAULT 0,
   vo05         DECIMAL(4,0) DEFAULT 0,
   vo06         DECIMAL(4,0) DEFAULT 0,
   vo07         DECIMAL(4,0) DEFAULT 0,
   vo08         DECIMAL(4,0) DEFAULT 0,
   vo09         DECIMAL(4,0) DEFAULT 0,
   vo10         DECIMAL(4,0) DEFAULT 0,
   vo11         DECIMAL(4,0) DEFAULT 0,
   vo12         DECIMAL(4,0) DEFAULT 0,
   vzodhad      DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0,
   pozn         VARCHAR(80),
   str2         TEXT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdpotvrdenienemd'.$sqlt;
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienemd ADD pozn VARCHAR(80) AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienemd ADD str2 TEXT AFTER pozn";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpotvrdenienemd ADD vzspolu DECIMAL(10,2) AFTER vz12";
$vysledek = mysql_query("$sql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienemd WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if( $subor == 1 )
{

//zober data z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc = $cislo_oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z mzdzalsum 
//z firmy minuleho roka ak nenastupil tento rok DORIESIT //////////////////////////////////////////////////////////////////////////////
//z firmy tohto roka ak nastupil tento rok 
$dan1=$kli_vrok."-01-01";
$dan365=$kli_vrok."-12-31";
$minuly=1;
$kli_mrok=$kli_vrok-1;
$kli_vmcf=$fir_allx11;

//ak robil v minulom treba prejst do 2009 a nacitat
//ak zacalrobit v tomto nacita z 2010

$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc AND dan >= '$dan1' AND dan <= '$dan365' ";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $minuly=0;
  }

if( $minuly == 0 ) { $kli_mrok=$kli_vrok; $kli_vmcf=$kli_vxcf; }

$databaza="";
if( $minuly == 1 AND $kli_vrok > 2010 )
{
if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; }
}

//echo $minuly;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"zfir_np,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 01.$kli_mrok";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,zfir_np,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 02.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,zfir_np,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 03.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,zfir_np,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 04.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,zfir_np,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 05.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,zfir_np,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 06.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,zfir_np,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 07.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,zfir_np,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 08.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,zfir_np,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 09.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,zfir_np,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 10.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,zfir_np,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 11.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,zfir_np,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'',''".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 12.$kli_mrok";
$dsql = mysql_query("$dsqlt");

//sumarizuj za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,napprc,".
"preod1,predo1,predv1,preod2,predo2,predv2,preod3,predo3,predv3,preod4,predo4,predv4,".
"fe101,text51,text52,text53,".
"SUM(vz01),SUM(vz02),SUM(vz03),SUM(vz04),SUM(vz05),SUM(vz06),SUM(vz07),SUM(vz08),SUM(vz09),SUM(vz10),SUM(vz11),SUM(vz12),SUM(vzspolu),".
"vo01,vo02,vo03,vo04,vo05,vo06,vo07,vo08,vo09,vo10,vo11,vo12,SUM(vzodhad),".
"2,'',''".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE konx = 1";
$oznac = mysql_query("$sqtoz");

//nastav obdobie
$obdrok=$kli_vrok-2000;
$obdrom=$kli_vrok-2001;
if( $minuly == 0 ) { $obdrom=$kli_vrok-2000; }
if( $minuly == 1 ) { $obdrok=$kli_vrok-2001; }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET vo01=$obdrom,vo02=$obdrom,vo03=$obdrom,vo04=$obdrom,vo05=$obdrom,vo06=$obdrom,vo07=$obdrom,vo08=$obdrom,".
" vo09=$obdrom,vo10=$obdrom,vo11=$obdrom,vo12=$obdrom WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo01=$obdrok WHERE oc >= 0 AND vz01 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo02=$obdrok WHERE oc >= 0 AND vz02 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo03=$obdrok WHERE oc >= 0 AND vz03 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo04=$obdrok WHERE oc >= 0 AND vz04 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo05=$obdrok WHERE oc >= 0 AND vz05 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo06=$obdrok WHERE oc >= 0 AND vz06 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo07=$obdrok WHERE oc >= 0 AND vz07 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo08=$obdrok WHERE oc >= 0 AND vz08 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo09=$obdrok WHERE oc >= 0 AND vz09 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo10=$obdrok WHERE oc >= 0 AND vz10 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo11=$obdrok WHERE oc >= 0 AND vz11 > 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo12=$obdrok WHERE oc >= 0 AND vz12 > 0"; $oznac = mysql_query("$sqtoz");

//nem.davky,nepl.volno,absencia napocitaj do preod,predo,predv1 az 4

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypln'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypln'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypln".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalvy".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalvy.oc = $cislo_oc AND ".$databaza."F$kli_vmcf"."_mzdzalvy.dp != '0000-00-00'".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypln$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvypln".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE oc = $cislo_oc ORDER BY oc,dp";

$sqldt = mysql_query("$sqldttt");
$poldt = mysql_num_rows($sqldt);

$idt=0;
  while ($idt <= $poldt )
  {
  if (@$zaznam=mysql_data_seek($sqldt,$idt))
{
$poloz=mysql_fetch_object($sqldt);

$dp_sk=SkDatum($poloz->dp);
$dk_sk=SkDatum($poloz->dk);


if( $idt == 0 ) 
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET preod1='$poloz->dp', predo1='$poloz->dk', predv1='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if( $idt == 1 ) 
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET preod2='$poloz->dp', predo2='$poloz->dk', predv2='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if( $idt == 2 ) 
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET preod3='$poloz->dp', predo3='$poloz->dk', predv3='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if( $idt == 3 ) 
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET preod4='$poloz->dp', predo4='$poloz->dk', predv4='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}


}
$idt = $idt + 1;

  }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypln'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
//nem.davky,nepl.volno,absencia koniec napocitania 

//ak existuje v mzdpotvrdenienemd uz zaznam precitane z neho udaje v copern=26 hore dopln do noveho

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo01=$obdrom, vz01=$vz01_08 WHERE oc >= 0 AND vz01 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo02=$obdrom, vz02=$vz02_08 WHERE oc >= 0 AND vz02 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo03=$obdrom, vz03=$vz03_08 WHERE oc >= 0 AND vz03 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo04=$obdrom, vz04=$vz04_08 WHERE oc >= 0 AND vz04 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo05=$obdrom, vz05=$vz05_08 WHERE oc >= 0 AND vz05 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo06=$obdrom, vz06=$vz06_08 WHERE oc >= 0 AND vz06 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo07=$obdrom, vz07=$vz07_08 WHERE oc >= 0 AND vz07 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo08=$obdrom, vz08=$vz08_08 WHERE oc >= 0 AND vz08 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo09=$obdrom, vz09=$vz09_08 WHERE oc >= 0 AND vz09 = 0"; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo10=$obdrom, vz10=$vz10_08 WHERE oc >= 0 AND vz10 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo11=$obdrom, vz11=$vz11_08 WHERE oc >= 0 AND vz11 = 0"; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo12=$obdrom, vz12=$vz12_08 WHERE oc >= 0 AND vz12 = 0"; $oznac = mysql_query("$sqtoz");

if( $uzjezaznam == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" SET rdstav='$rdstav_08', uzemie='$uzemie_08', fe101='$fe101_08', text51='$text51_08', text52='$text52_08', text53='$text53_08', ".
" pozn='$pozn_08', str2='$str2_08' ".
" WHERE oc >= 0 "; 

$oznac = mysql_query("$sqtoz");
}


//uloz do mzdpotvrdenienemd
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdpotvrdenienemd WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdpotvrdenienemd".
" SELECT oc,rdstav,uzemie,napprc,".
"preod1,predo1,predv1,preod2,predo2,predv2,preod3,predo3,predv3,preod4,predo4,predv4,".
"fe101,text51,text52,text53,".
"SUM(vz01),SUM(vz02),SUM(vz03),SUM(vz04),SUM(vz05),SUM(vz06),SUM(vz07),SUM(vz08),SUM(vz09),SUM(vz10),SUM(vz11),SUM(vz12),SUM(vzspolu),".
"vo01,vo02,vo03,vo04,vo05,vo06,vo07,vo08,vo09,vo10,vo11,vo12,SUM(vzodhad),".
"2,pozn,str2".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec pracovneho suboru pre potvrdenie 

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

/////////////////////////////////////////////////VYTLAC POTVRDENIE
if( $copern == 10 )
{

//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienemd".
" SET vzspolu=vz01+vz02+vz03+vz04+vz05+vz06+vz07+vz08+vz09+vz10+vz11+vz12 WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");



if (File_Exists ("../tmp/potvrdenieFO.$kli_uzid.pdf")) { $soubor = unlink("../tmp/potvrdenieFO.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienemd".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdpotvrdenienemd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdpotvrdenienemd.oc = $cislo_oc AND konx = 2 ORDER BY konx,prie,meno";


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

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/mzdy_potvrdenia/narok_na_NemD2011.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/mzdy_potvrdenia/narok_na_NemD2011.jpg',10,13,195,286); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',8);
$obdobie=$kli_vrok;

$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";

$dar=SkDatum($hlavicka->dar);
$dan=SkDatum($hlavicka->dan);
$dav=SkDatum($hlavicka->dav);
if( $dav == "00.00.0000" ) $dav="";
$napprc=SkDatum($hlavicka->napprc);
if( $napprc == "00.00.0000" ) $napprc="";


$pdf->Cell(190,17,"                          ","0",1,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(30,4,"$hlavicka->rdc $hlavicka->rdk","0",1,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(30,4,"$hlavicka->meno","0",0,"L");$pdf->Cell(45,4," ","0",0,"L");$pdf->Cell(30,4,"$hlavicka->prie","0",1,"L");
$pdf->Cell(35,3," ","0",0,"L");$pdf->Cell(30,3,"$dar","0",0,"L");$pdf->Cell(35,3," ","0",0,"L");


if( $hlavicka->rdstav == 0 ) { $pdf->Cell(30,3,"slobodn˝/slobodn·","0",1,"L"); }
if( $hlavicka->rdstav == 1 ) { $pdf->Cell(30,3,"ûenat˝/vydat·","0",1,"L"); }
if( $hlavicka->rdstav == 2 ) { $pdf->Cell(30,3,"vdovec/vdova","0",1,"L"); }
if( $hlavicka->rdstav == 3 ) { $pdf->Cell(30,3,"rozveden˝/rozveden·","0",1,"L"); }

$pdf->Cell(65,4," ","0",0,"L");$pdf->Cell(80,4,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","0",1,"L");

$pdf->Cell(65,4," ","0",0,"L");$pdf->Cell(80,4,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","0",1,"L");
$pdf->Cell(65,4," ","0",0,"L");$pdf->Cell(80,4,"I»Z: $cicz","0",1,"L");


$pdf->Cell(50,4," ","0",0,"L");
if( $hlavicka->uzemie == 0 ) { $pdf->Cell(40,4,"na ˙zemÌ SR","0",1,"L"); }
if( $hlavicka->uzemie == 1 ) { $pdf->Cell(40,4,"mimo ˙zemia SR","0",1,"L"); }
if( $hlavicka->uzemie == 2 ) { $pdf->Cell(40,4,"na ˙zemÌ SR aj mimo ˙zemia SR","0",1,"L"); }

$pdf->Cell(150,2," ","0",1,"L");
$pdf->Cell(60,4," ","0",0,"L");$pdf->Cell(20,4,"$dan","0",0,"L");$pdf->Cell(60,4," ","0",0,"L");$pdf->Cell(20,4,"$dav","0",1,"L");

$pdf->Cell(150,2," ","0",1,"L");
$pdf->Cell(70,4," ","0",0,"L");$pdf->Cell(20,4,"$napprc","0",1,"L");

//obdobia neplatenia
$preod1=SkDatum($hlavicka->preod1);
if( $preod1 == "00.00.0000" ) $preod1="";
$predo1=SkDatum($hlavicka->predo1);
if( $predo1 == "00.00.0000" ) $predo1="";
$predv1=$hlavicka->predv1;
$preod2=SkDatum($hlavicka->preod2);
if( $preod2 == "00.00.0000" ) $preod2="";
$predo2=SkDatum($hlavicka->predo2);
if( $predo2 == "00.00.0000" ) $predo2="";
$predv2=$hlavicka->predv2;
$preod3=SkDatum($hlavicka->preod3);
if( $preod3 == "00.00.0000" ) $preod3="";
$predo3=SkDatum($hlavicka->predo3);
if( $predo3 == "00.00.0000" ) $predo3="";
$predv3=$hlavicka->predv3;
$preod4=SkDatum($hlavicka->preod4);
if( $preod4 == "00.00.0000" ) $preod4="";
$predo4=SkDatum($hlavicka->predo4);
if( $predo4 == "00.00.0000" ) $predo4="";
$predv4=$hlavicka->predv4;


$pdf->Cell(150,9," ","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(20,4,"$preod1","0",0,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(20,4,"$predo1","0",0,"L");
$pdf->Cell(28,4," ","0",0,"L");$pdf->Cell(80,4,"$predv1","0",1,"L");

$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(20,4,"$preod2","0",0,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(20,4,"$predo2","0",0,"L");
$pdf->Cell(28,4," ","0",0,"L");$pdf->Cell(80,4,"$predv2","0",1,"L");

$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(20,4,"$preod3","0",0,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(20,4,"$predo3","0",0,"L");
$pdf->Cell(28,4," ","0",0,"L");$pdf->Cell(80,4,"$predv3","0",1,"L");

$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(20,4,"$preod4","0",0,"L");
$pdf->Cell(25,4," ","0",0,"L");$pdf->Cell(20,4,"$predo4","0",0,"L");
$pdf->Cell(28,4," ","0",0,"L");$pdf->Cell(80,4,"$predv4","0",1,"L");

$pdf->Cell(150,2," ","0",1,"L");
$pdf->Cell(55,4," ","0",0,"L");
if( $hlavicka->fe101 == 0 ) { $pdf->Cell(40,4,"nebola","0",1,"L"); }
if( $hlavicka->fe101 == 1 ) { $pdf->Cell(40,4,"bola","0",1,"L"); }

$pdf->Cell(150,13," ","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(170,4,"$hlavicka->text51","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(170,4,"$hlavicka->text52","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(170,4,"$hlavicka->text53","0",1,"L");


//vym.zaklady
$vo01=$hlavicka->vo01; if( $vo01 < 10 ) $vo01="0".$vo01;
$vo02=$hlavicka->vo02; if( $vo02 < 10 ) $vo02="0".$vo02;
$vo03=$hlavicka->vo03; if( $vo03 < 10 ) $vo03="0".$vo03;
$vo04=$hlavicka->vo04; if( $vo04 < 10 ) $vo04="0".$vo04;
$vo05=$hlavicka->vo05; if( $vo05 < 10 ) $vo05="0".$vo05;
$vo06=$hlavicka->vo06; if( $vo06 < 10 ) $vo06="0".$vo06;
$vo07=$hlavicka->vo07; if( $vo07 < 10 ) $vo07="0".$vo07;
$vo08=$hlavicka->vo08; if( $vo08 < 10 ) $vo08="0".$vo08;
$vo09=$hlavicka->vo09; if( $vo09 < 10 ) $vo09="0".$vo09;
$vo10=$hlavicka->vo10; if( $vo10 < 10 ) $vo10="0".$vo10;
$vo11=$hlavicka->vo11; if( $vo11 < 10 ) $vo11="0".$vo11;
$vo12=$hlavicka->vo12; if( $vo12 < 10 ) $vo12="0".$vo12;


$pdf->SetFont('arial','',9);
$pdf->Cell(150,34," ","0",1,"L");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo01","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz01","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo02","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz02","0",1,"R");
$pdf->Cell(21,6," ","0",0,"L");$pdf->Cell(11,6,"$vo03","0",0,"L");$pdf->Cell(17,6,"$hlavicka->vz03","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo04","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz04","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo05","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz05","0",1,"R");
$pdf->Cell(21,6," ","0",0,"L");$pdf->Cell(11,6,"$vo06","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz06","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo07","0",0,"L");$pdf->Cell(17,6,"$hlavicka->vz07","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo08","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz08","0",1,"R");
$pdf->Cell(21,6," ","0",0,"L");$pdf->Cell(11,6,"$vo09","0",0,"L");$pdf->Cell(17,6,"$hlavicka->vz09","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo10","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz10","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo11","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz11","0",1,"R");
$pdf->Cell(21,5," ","0",0,"L");$pdf->Cell(11,5,"$vo12","0",0,"L");$pdf->Cell(17,5,"$hlavicka->vz12","0",1,"R");

$pdf->Cell(21,6," ","0",0,"L");$pdf->Cell(11,6," ","0",0,"L");$pdf->Cell(17,6,"$hlavicka->vzspolu","0",1,"R");
$pdf->SetFont('arial','',8);

$vzodhad=$hlavicka->vzodhad;
if( $vzodhad == 0 ) $vzodhad="";


$pdf->Cell(150,19," ","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(20,4,"$vzodhad","0",1,"R");


$pdf->Cell(150,12," ","0",1,"L");
$pdf->Cell(10,4," ","0",0,"L");$pdf->Cell(160,4,"$fir_mzdt05 tel. $fir_mzdt04","0",1,"L");




if( $copern == 10 ) $pozn=$hlavicka->pozn;

$pdf->Cell(190,20,"                          ","0",1,"L");
$pdf->Cell(130,5,"$pozn","0",1,"L");


}
$i = $i + 1;

  }



$pole = explode("\r\n", $hlavicka->str2);

if( $pole[0] != '' )
{

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$pdf->SetY(10);
$pdf->SetFont('arial','',8);


$ipole=1;
foreach( $pole as $hodnota ) {
if( $ipole == 1 ) 
{ $pdf->Cell(150,5,"Potvrdenie zamestn·vateæa o zamestnancovi na ˙Ëely uplatnenia n·roku na nemocensk˙ d·vku","B",0,"L");
  $pdf->Cell(0,5," 2.strana","B",1,"R");
  $pdf->Cell(0,5,"  ","0",1,"R");
}
if( $ipole == 1 ) { $pdf->Cell(150,5,"Rod.ËÌslo: $hlavicka->rdc $hlavicka->rdk Meno,priezvisko: $hlavicka->meno $hlavicka->prie","0",1,"L"); $pdf->Cell(0,5,"  ","0",1,"R");}
$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,20,"  ","0",1,"R");
$pdf->Cell(145,5,"","0",0,"R");$pdf->Cell(0,5,"","B",1,"R");
$pdf->Cell(145,5,"","0",0,"R");$pdf->Cell(0,5,"peËiatka,podpis zamestn·vateæa","0",1,"C");
}



$pdf->Output("../tmp/potvrdenieFO.$kli_uzid.pdf");


?>

<script type="text/javascript">
  var okno = window.open("../tmp/potvrdenieFO.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA POTVRDENIA FO


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienemd".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdpotvrdenienemd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdpotvrdenienemd.oc = $cislo_oc AND konx = 2 ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;

$rdstav = $fir_riadok->rdstav;
$uzemie = $fir_riadok->uzemie;
$napprc = SkDatum($fir_riadok->napprc);
$preod1 = SkDatum($fir_riadok->preod1);
$predo1 = SkDatum($fir_riadok->predo1);
$predv1 = $fir_riadok->predv1;
$preod2 = SkDatum($fir_riadok->preod2);
$predo2 = SkDatum($fir_riadok->predo2);
$predv2 = $fir_riadok->predv2;
$preod3 = SkDatum($fir_riadok->preod3);
$predo3 = SkDatum($fir_riadok->predo3);
$predv3 = $fir_riadok->predv3;
$preod4 = SkDatum($fir_riadok->preod4);
$predo4 = SkDatum($fir_riadok->predo4);
$predv4 = $fir_riadok->predv4;
$fe101 = $fir_riadok->fe101;
$text51 = $fir_riadok->text51;
$text52 = $fir_riadok->text52;
$text53 = $fir_riadok->text53;
$vz01 = $fir_riadok->vz01;
$vz02 = $fir_riadok->vz02;
$vz03 = $fir_riadok->vz03;
$vz04 = $fir_riadok->vz04;
$vz05 = $fir_riadok->vz05;
$vz06 = $fir_riadok->vz06;
$vz07 = $fir_riadok->vz07;
$vz08 = $fir_riadok->vz08;
$vz09 = $fir_riadok->vz09;
$vz10 = $fir_riadok->vz10;
$vz11 = $fir_riadok->vz11;
$vz12 = $fir_riadok->vz12;
$vzspolu = $fir_riadok->vzspolu;
$vo01 = $fir_riadok->vo01;
$vo02 = $fir_riadok->vo02;
$vo03 = $fir_riadok->vo03;
$vo04 = $fir_riadok->vo04;
$vo05 = $fir_riadok->vo05;
$vo06 = $fir_riadok->vo06;
$vo07 = $fir_riadok->vo07;
$vo08 = $fir_riadok->vo08;
$vo09 = $fir_riadok->vo09;
$vo10 = $fir_riadok->vo10;
$vo11 = $fir_riadok->vo11;
$vo12 = $fir_riadok->vo12;
$vzodhad = $fir_riadok->vzodhad;
$pozn = $fir_riadok->pozn;
$str2 = $fir_riadok->str2;


mysql_free_result($fir_vysledok);

    }
//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Potvrdenie zamestn·vateæa o zamestnancovi na ˙Ëely uplatnenia n·roku na nemocensk˙ d·vku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 20 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.rdstav.value = '<?php echo "$rdstav";?>';
    document.formv1.uzemie.value = '<?php echo "$uzemie";?>';
    document.formv1.napprc.value = '<?php echo "$napprc";?>';
    document.formv1.preod1.value = '<?php echo "$preod1";?>';
    document.formv1.predo1.value = '<?php echo "$predo1";?>';
    document.formv1.predv1.value = '<?php echo "$predv1";?>';
    document.formv1.preod2.value = '<?php echo "$preod2";?>';
    document.formv1.predo2.value = '<?php echo "$predo2";?>';
    document.formv1.predv2.value = '<?php echo "$predv2";?>';
    document.formv1.preod3.value = '<?php echo "$preod3";?>';
    document.formv1.predo3.value = '<?php echo "$predo3";?>';
    document.formv1.predv3.value = '<?php echo "$predv3";?>';
    document.formv1.preod4.value = '<?php echo "$preod4";?>';
    document.formv1.predo4.value = '<?php echo "$predo4";?>';
    document.formv1.predv4.value = '<?php echo "$predv4";?>';
    document.formv1.fe101.value = '<?php echo "$fe101";?>';
    document.formv1.text51.value = '<?php echo "$text51";?>';
    document.formv1.text52.value = '<?php echo "$text52";?>';
    document.formv1.text53.value = '<?php echo "$text53";?>';
    document.formv1.vz01.value = '<?php echo "$vz01";?>';
    document.formv1.vz02.value = '<?php echo "$vz02";?>';
    document.formv1.vz03.value = '<?php echo "$vz03";?>';
    document.formv1.vz04.value = '<?php echo "$vz04";?>';
    document.formv1.vz05.value = '<?php echo "$vz05";?>';
    document.formv1.vz06.value = '<?php echo "$vz06";?>';
    document.formv1.vz07.value = '<?php echo "$vz07";?>';
    document.formv1.vz08.value = '<?php echo "$vz08";?>';
    document.formv1.vz09.value = '<?php echo "$vz09";?>';
    document.formv1.vz10.value = '<?php echo "$vz10";?>';
    document.formv1.vz11.value = '<?php echo "$vz11";?>';
    document.formv1.vz12.value = '<?php echo "$vz12";?>';
    document.formv1.vo01.value = '<?php echo "$vo01";?>';
    document.formv1.vo02.value = '<?php echo "$vo02";?>';
    document.formv1.vo03.value = '<?php echo "$vo03";?>';
    document.formv1.vo04.value = '<?php echo "$vo04";?>';
    document.formv1.vo05.value = '<?php echo "$vo05";?>';
    document.formv1.vo06.value = '<?php echo "$vo06";?>';
    document.formv1.vo07.value = '<?php echo "$vo07";?>';
    document.formv1.vo08.value = '<?php echo "$vo08";?>';
    document.formv1.vo09.value = '<?php echo "$vo09";?>';
    document.formv1.vo10.value = '<?php echo "$vo10";?>';
    document.formv1.vo11.value = '<?php echo "$vo11";?>';
    document.formv1.vo12.value = '<?php echo "$vo12";?>';
    document.formv1.vzodhad.value = '<?php echo "$vzodhad";?>';
    document.formv1.pozn.value = '<?php echo "$pozn";?>';

    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
  }
?>

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


function ZnovuPotvrdenie()
                {
window.open('../mzdy/potvrd_fo.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
   
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Potvrdenie zamestn·vateæa o zamestnancovi na ˙Ëely uplatnenia n·roku na nemocensk˙ d·vku

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>


<?php if( $copern == 20 ) { ?>

<table class="h2" width="100%" >
<tr>
<td align="left"><?php echo "Os.ËÌslo: $oc $meno $prie ";?>
<a href="#" onClick="ZnovuPotvrdenie();">
<img src='../obr/orig.png' width=20 height=15 border=0 alt='Znovu naËÌtaù hodnoty do potvrdenia z miezd' ></a>
</td>
</tr>
</table>


<?php                     } ?>


<?php
//upravy  udaje strana 1
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="potvrd_nemd.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="4">Rodinn˝ stav</td>
<td class="fmenu" colspan="2">
<select size="1" name="rdstav" id="rdstav"  >
<option value="0" >slobodn˝/slobodn·</option>
<option value="1" >ûenat˝/vydat·</option>
<option value="2" >vdovec/vdova</option>
<option value="3" >rozveden˝/rozveden·</option>
</td>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù a tlaËiù"></td>
</tr>

<tr><td class="bmenu" colspan="4">Zamestnanec vykon·va pr·cu na</td>
<td class="fmenu" colspan="2">
<select size="1" name="uzemie" id="uzemie"  >
<option value="0" >˙zemÌ SR</option>
<option value="1" >mimo ˙zemia SR</option>
<option value="2" >na ˙zemÌ SR aj mimo ˙zemia SR</option>
</td>
</tr>

<tr><td class="bmenu" colspan="4">Zamestnanec naposledy pracoval dÚa</td>
<td class="fmenu" colspan="2"><input type="text" name="napprc" id="napprc" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr><td class="bmenu" colspan="4">Preruöenie povinnÈho nemocenskÈho poistenia</td>
<td class="fmenu" colspan="1">od <input type="text" name="preod1" id="preod1" size="10" /></td>
<td class="fmenu" colspan="1">do <input type="text" name="predo1" id="predo1" size="10" /></td>
<td class="bmenu" colspan="4">dÙvod <input type="text" name="predv1" id="predv1" size="50" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="fmenu" colspan="1">od <input type="text" name="preod2" id="preod2" size="10" /></td>
<td class="fmenu" colspan="1">do <input type="text" name="predo2" id="predo2" size="10" /></td>
<td class="bmenu" colspan="4">dÙvod <input type="text" name="predv2" id="predv2" size="50" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="fmenu" colspan="1">od <input type="text" name="preod3" id="preod3" size="10" /></td>
<td class="fmenu" colspan="1">do <input type="text" name="predo3" id="predo3" size="10" /></td>
<td class="bmenu" colspan="4">dÙvod <input type="text" name="predv3" id="predv3" size="50" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="fmenu" colspan="1">od <input type="text" name="preod4" id="preod4" size="10" /></td>
<td class="fmenu" colspan="1">do <input type="text" name="predo4" id="predo4" size="10" /></td>
<td class="bmenu" colspan="4">dÙvod <input type="text" name="predv4" id="predv4" size="50" /></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr><td class="bmenu" colspan="4">PoboËke Soci·lnej poisùovne </td>
<td class="bmenu" colspan="4">
<select size="1" name="fe101" id="fe101"  >
<option value="0" >nebola</option>
<option value="1" >bola</option></select> podan· ûiadosù o vystavenie formul·ra E-101
</td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>


<tr><td class="bmenu" colspan="10">Zamestnanec v RO Ëerpal rodiËovsk˙ dovolenku, vypl·calo sa mu rehabilitaËnÈ alebo rekvalifikaËnÈ,
 mal neprÌtomnosù z dÙvodu ˙Ëasti na ötrajku</td></tr>
<tr><td class="bmenu" colspan="10"><input type="text" name="text51" id="text51" size="100" /></td></tr>
<tr><td class="bmenu" colspan="10"><input type="text" name="text52" id="text52" size="100" /></td></tr>
<tr><td class="bmenu" colspan="10"><input type="text" name="text53" id="text53" size="100" /></td></tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr><td class="bmenu" colspan="3">Vymeriavacie z·klady na nemocenskÈ poistenie</td>
<td class="bmenu" colspan="1" align="right">janu·r</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo01" id="vo01" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz01" id="vz01" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">febru·r</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo02" id="vo02" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz02" id="vz02" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">marec</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo03" id="vo03" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz03" id="vz03" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">aprÌl</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo04" id="vo04" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz04" id="vz04" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">m·j</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo05" id="vo05" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz05" id="vz05" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">j˙n</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo06" id="vo06" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz06" id="vz06" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">j˙l</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo07" id="vo07" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz07" id="vz07" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">august</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo08" id="vo08" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz08" id="vz08" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">september</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo09" id="vo09" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz09" id="vz09" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">oktÛber</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo10" id="vo10" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz10" id="vz10" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">november</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo11" id="vo11" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz11" id="vz11" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="3"> </td>
<td class="bmenu" colspan="1" align="right">december</td>
<td class="fmenu" colspan="1">rok <input type="text" name="vo12" id="vo12" size="4" /></td>
<td class="fmenu" colspan="2">VZ <input type="text" name="vz12" id="vz12" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr><td class="bmenu" colspan="10">VymeriavacÌ z·klad, z ktorÈho by sa platilo poistnÈ na NP za kalend·rny mesiac, v ktorom vznikol
dÙvod na poskytnutie nemocenskej d·vky ( uvedie sa v prÌpade, ak zamestnanec nemal v RO vymeriavacÌ z·klad )</td>
</tr>
<tr><td class="fmenu" colspan="2">VZ <input type="text" name="vzodhad" id="vzodhad" size="10" /></td></tr>

<tr><td class="bmenu" colspan="10">Pozn·mka</td></tr>
<tr><td class="bmenu" colspan="10"><input type="text" name="pozn" id="pozn" size="100" /></td></tr>

<tr><td class="bmenu" colspan="10">DoplÚuj˙ce inform·cie na 2.stranu potvrdenia</td></tr>
<tr><td class="bmenu" colspan="10">
<textarea name="str2" id="str2" rows="8" cols="100" >
<?php echo $str2; ?>
</textarea>
</td></tr>

</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 1
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
