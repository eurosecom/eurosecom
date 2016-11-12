<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

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
$copern=20;
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

$vm01 = strip_tags($_REQUEST['vm01']);
$vm02 = strip_tags($_REQUEST['vm02']);
$vm03 = strip_tags($_REQUEST['vm03']);
$vm04 = strip_tags($_REQUEST['vm04']);
$vm05 = strip_tags($_REQUEST['vm05']);
$vm06 = strip_tags($_REQUEST['vm06']);
$vm07 = strip_tags($_REQUEST['vm07']);
$vm08 = strip_tags($_REQUEST['vm08']);
$vm09 = strip_tags($_REQUEST['vm09']);
$vm10 = strip_tags($_REQUEST['vm10']);
$vm11 = strip_tags($_REQUEST['vm11']);
$vm12 = strip_tags($_REQUEST['vm12']);
$vmspolu = strip_tags($_REQUEST['vmspolu']);
$vp01 = strip_tags($_REQUEST['vp01']);
$vp02 = strip_tags($_REQUEST['vp02']);
$vp03 = strip_tags($_REQUEST['vp03']);
$vp04 = strip_tags($_REQUEST['vp04']);
$vp05 = strip_tags($_REQUEST['vp05']);
$vp06 = strip_tags($_REQUEST['vp06']);
$vp07 = strip_tags($_REQUEST['vp07']);
$vp08 = strip_tags($_REQUEST['vp08']);
$vp09 = strip_tags($_REQUEST['vp09']);
$vp10 = strip_tags($_REQUEST['vp10']);
$vp11 = strip_tags($_REQUEST['vp11']);
$vp12 = strip_tags($_REQUEST['vp12']);


$vzodhad = strip_tags($_REQUEST['vzodhad']);
$pozn = strip_tags($_REQUEST['pozn']);
$str2 = strip_tags($_REQUEST['str2']);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql = SqlDatum($_REQUEST['datum']);

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

" vm01='$vm01', vm02='$vm02', vm03='$vm03', vm04='$vm04', vm05='$vm05', vm06='$vm06', ".
" vm07='$vm07', vm08='$vm08', vm09='$vm09', vm10='$vm10', vm11='$vm11', vm12='$vm12', ".
" vp01='$vp01', vp02='$vp02', vp03='$vp03', vp04='$vp04', vp05='$vp05', vp06='$vp06', ".
" vp07='$vp07', vp08='$vp08', vp09='$vp09', vp10='$vp10', vp11='$vp11', vp12='$vp12', ".
" pozn='$pozn', str2='$str2', datum='$datum_sql' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  
$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
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
   vm01         DECIMAL(10,2) DEFAULT 0,
   vm02         DECIMAL(10,2) DEFAULT 0,
   vm03         DECIMAL(10,2) DEFAULT 0,
   vm04         DECIMAL(10,2) DEFAULT 0,
   vm05         DECIMAL(10,2) DEFAULT 0,
   vm06         DECIMAL(10,2) DEFAULT 0,
   vm07         DECIMAL(10,2) DEFAULT 0,
   vm08         DECIMAL(10,2) DEFAULT 0,
   vm09         DECIMAL(10,2) DEFAULT 0,
   vm10         DECIMAL(10,2) DEFAULT 0,
   vm11         DECIMAL(10,2) DEFAULT 0,
   vm12         DECIMAL(10,2) DEFAULT 0,
   vmspolu      DECIMAL(10,2) DEFAULT 0,
   vp01         DECIMAL(4,0) DEFAULT 0,
   vp02         DECIMAL(4,0) DEFAULT 0,
   vp03         DECIMAL(4,0) DEFAULT 0,
   vp04         DECIMAL(4,0) DEFAULT 0,
   vp05         DECIMAL(4,0) DEFAULT 0,
   vp06         DECIMAL(4,0) DEFAULT 0,
   vp07         DECIMAL(4,0) DEFAULT 0,
   vp08         DECIMAL(4,0) DEFAULT 0,
   vp09         DECIMAL(4,0) DEFAULT 0,
   vp10         DECIMAL(4,0) DEFAULT 0,
   vp11         DECIMAL(4,0) DEFAULT 0,
   vp12         DECIMAL(4,0) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0,
   pozn         VARCHAR(80),
   str2         TEXT,
   datum       DATE
);
mzdprc;

$sql = "SELECT vp12 FROM F$kli_vxcf"."_mzdpotvrdenienemd ";
$sqldok = mysql_query("$sql");
  if (!$sqldok)
  {

$sqltx = "DROP TABLE F".$kli_vxcf."_mzdpotvrdenienemd ";
$vysledok = mysql_query("$sqltx");

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdpotvrdenienemd ".$sqlt;
$vytvor = mysql_query("$vsql");
//echo $vsql;
  }

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

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
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','',''".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc = $cislo_oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z mzdzalsum 
$dan1=$kli_vrok."-01-01";
$dan365=$kli_vrok."-12-31";
$minuly=1;
$kli_mrok=$kli_vrok-1;
$kli_vmcf=$fir_allx11;


if ( $minuly == 0 ) { $kli_mrok=$kli_vrok; $kli_vmcf=$kli_vxcf; }

$databaza="";
$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }

if ( $newdelenie == 0 ) 
          {
if ( $minuly == 1 AND $kli_vrok > 2010 )
{
if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; }
}
if ( $minuly == 1 AND $kli_vrok > 2011 )
{
if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; }
}
if ( $minuly == 1 AND $kli_vrok > 2012 )
{
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; }
}
if ( $minuly == 1 AND $kli_vrok > 2013 )
{
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; }
}
if ( $minuly == 1 AND $kli_vrok > 2014 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}
if ( $minuly == 1 AND $kli_vrok > 2015 )
{
if ( File_Exists("../pswd/oddelena2015db2016.php") ) { $databaza=$mysqldb2015."."; }
}
          }

if ( $newdelenie == 1 ) 
          {
if ( $minuly == 1 )
  {

$dtb2 = include("../cis/oddel_dtbz1.php");

  }
          }


//echo "minuly ".$minuly." databaza ".$databaza;
//exit;


//bezny rok

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"zfir_np,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 01.$kli_vrok";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,zfir_np,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 02.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,zfir_np,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 03.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,zfir_np,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 04.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,zfir_np,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 05.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,zfir_np,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 06.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,zfir_np,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 07.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,zfir_np,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 08.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,zfir_np,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 09.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,zfir_np,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 10.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,zfir_np,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 11.$kli_vrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,zfir_np,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE F$kli_vxcf"."_mzdzalsum.oc = $cislo_oc AND ume = 12.$kli_vrok";
$dsql = mysql_query("$dsqlt");

//minuly rok

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"zfir_np,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 01.$kli_mrok";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,zfir_np,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 02.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,zfir_np,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 03.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,zfir_np,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 04.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,zfir_np,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 05.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,zfir_np,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 06.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,zfir_np,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 07.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,zfir_np,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 08.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,zfir_np,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 09.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,zfir_np,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 10.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,zfir_np,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
" FROM ".$databaza."F$kli_vmcf"."_mzdzalsum".
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalsum.oc = $cislo_oc AND ume = 11.$kli_mrok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT oc,0,0,'0000-00-00',".
"'0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','',".
"0,'','','',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,zfir_np,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','' ".
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
"SUM(vm01),SUM(vm02),SUM(vm03),SUM(vm04),SUM(vm05),SUM(vm06),SUM(vm07),SUM(vm08),SUM(vm09),SUM(vm10),SUM(vm11),SUM(vm12),SUM(vmspolu),".
"vp01,vp02,vp03,vp04,vp05,vp06,vp07,vp08,vp09,vp10,vp11,vp12,".
"2,'','','' ".
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

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo01=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo02=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo03=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo04=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo05=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo06=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo07=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo08=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo09=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo10=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo11=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vo12=$obdrok WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp01=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp02=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp03=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp04=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp05=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp06=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp07=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp08=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp09=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp10=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp11=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vp12=$obdrom WHERE oc >= 0 "; $oznac = mysql_query("$sqtoz");

//exit;

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
" WHERE ".$databaza."F$kli_vmcf"."_mzdzalvy.oc = $cislo_oc AND ".$databaza."F$kli_vmcf"."_mzdzalvy.dp != '0000-00-00' AND ( ( dm > 800 AND dm < 899 ) OR dm = 502 OR dm = 503 ) ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypln".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND F$kli_vxcf"."_mzdzalvy.dp != '0000-00-00' AND ( ( dm > 800 AND dm < 899 ) OR dm = 502 OR dm = 503 ) ".
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


if ( $uzjezaznam == 1 )
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

$datdnes = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d"),date("Y"))); 

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdpotvrdenienemd".
" SELECT oc,rdstav,uzemie,napprc,".
"preod1,predo1,predv1,preod2,predo2,predv2,preod3,predo3,predv3,preod4,predo4,predv4,".
"fe101,text51,text52,text53,".
"SUM(vz01),SUM(vz02),SUM(vz03),SUM(vz04),SUM(vz05),SUM(vz06),SUM(vz07),SUM(vz08),SUM(vz09),SUM(vz10),SUM(vz11),SUM(vz12),SUM(vzspolu),".
"vo01,vo02,vo03,vo04,vo05,vo06,vo07,vo08,vo09,vo10,vo11,vo12,SUM(vzodhad),".
"SUM(vm01),SUM(vm02),SUM(vm03),SUM(vm04),SUM(vm05),SUM(vm06),SUM(vm07),SUM(vm08),SUM(vm09),SUM(vm10),SUM(vm11),SUM(vm12),SUM(vmspolu),".
"vp01,vp02,vp03,vp04,vp05,vp06,vp07,vp08,vp09,vp10,vp11,vp12,".
"2,pozn,str2,'$datdnes'".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec pracovneho suboru pre potvrdenie 


//vypocty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienemd".
" SET vmspolu=vm01+vm02+vm03+vm04+vm05+vm06+vm07+vm08+vm09+vm10+vm11+vm12, ".
" vzspolu=vz01+vz02+vz03+vz04+vz05+vz06+vz07+vz08+vz09+vz10+vz11+vz12 ".
" WHERE oc >= 0 ";
$oznac = mysql_query("$sqtoz");

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

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
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$dar = $fir_riadok->dar;
$dar_sk=SkDatum($dar);
$adresa = $fir_riadok->zuli." ".$fir_riadok->zcdm.", ".$fir_riadok->zmes."  ".$fir_riadok->zpsc;
$zamestnavatel = $fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes." ".$fir_fpsc.", IÈZ: ".$cicz;
$dan = $fir_riadok->dan;
$dan_sk=SkDatum($dan);
$dav = $fir_riadok->dav;
$dav_sk=SkDatum($dav);

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

$vm01 = $fir_riadok->vm01;
$vm02 = $fir_riadok->vm02;
$vm03 = $fir_riadok->vm03;
$vm04 = $fir_riadok->vm04;
$vm05 = $fir_riadok->vm05;
$vm06 = $fir_riadok->vm06;
$vm07 = $fir_riadok->vm07;
$vm08 = $fir_riadok->vm08;
$vm09 = $fir_riadok->vm09;
$vm10 = $fir_riadok->vm10;
$vm11 = $fir_riadok->vm11;
$vm12 = $fir_riadok->vm12;
$vmspolu = $fir_riadok->vmspolu;
$vp01 = $fir_riadok->vp01;
$vp02 = $fir_riadok->vp02;
$vp03 = $fir_riadok->vp03;
$vp04 = $fir_riadok->vp04;
$vp05 = $fir_riadok->vp05;
$vp06 = $fir_riadok->vp06;
$vp07 = $fir_riadok->vp07;
$vp08 = $fir_riadok->vp08;
$vp09 = $fir_riadok->vp09;
$vp10 = $fir_riadok->vp10;
$vp11 = $fir_riadok->vp11;
$vp12 = $fir_riadok->vp12;

$vzodhad = $fir_riadok->vzodhad;
$pozn = $fir_riadok->pozn;
$str2 = $fir_riadok->str2;
$datum = SkDatum($fir_riadok->datum);

mysql_free_result($fir_vysledok);
    }
//koniec nacitania


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Potvrdenie na nárok nemocenskej dávky</title>
<style type="text/css">
form input[type=text] {
  position: absolute;
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
form select {
  position: absolute;
  height: 20px;
  border: 1px solid #39f;
}
</style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava
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

   document.formv1.vm01.value = '<?php echo "$vm01";?>';
   document.formv1.vm02.value = '<?php echo "$vm02";?>';
   document.formv1.vm03.value = '<?php echo "$vm03";?>';
   document.formv1.vm04.value = '<?php echo "$vm04";?>';
   document.formv1.vm05.value = '<?php echo "$vm05";?>';
   document.formv1.vm06.value = '<?php echo "$vm06";?>';
   document.formv1.vm07.value = '<?php echo "$vm07";?>';
   document.formv1.vm08.value = '<?php echo "$vm08";?>';
   document.formv1.vm09.value = '<?php echo "$vm09";?>';
   document.formv1.vm10.value = '<?php echo "$vm10";?>';
   document.formv1.vm11.value = '<?php echo "$vm11";?>';
   document.formv1.vm12.value = '<?php echo "$vm12";?>';
   document.formv1.vp01.value = '<?php echo "$vp01";?>';
   document.formv1.vp02.value = '<?php echo "$vp02";?>';
   document.formv1.vp03.value = '<?php echo "$vp03";?>';
   document.formv1.vp04.value = '<?php echo "$vp04";?>';
   document.formv1.vp05.value = '<?php echo "$vp05";?>';
   document.formv1.vp06.value = '<?php echo "$vp06";?>';
   document.formv1.vp07.value = '<?php echo "$vp07";?>';
   document.formv1.vp08.value = '<?php echo "$vp08";?>';
   document.formv1.vp09.value = '<?php echo "$vp09";?>';
   document.formv1.vp10.value = '<?php echo "$vp10";?>';
   document.formv1.vp11.value = '<?php echo "$vp11";?>';
   document.formv1.vp12.value = '<?php echo "$vp12";?>';


   document.formv1.vzodhad.value = '<?php echo "$vzodhad";?>';
   document.formv1.pozn.value = '<?php echo "$pozn";?>';
   document.formv1.datum.value = '<?php echo "$datum";?>';
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

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC(prevoc)
  {
   window.open('potvrd_nemd.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + prevoc + '', '_self');
  }
  function nextOC(nextoc)
  {
   window.open('potvrd_nemd.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + nextoc + '', '_self');
  }

  function NavodVyplnenie()
  {
   window.open('../dokumenty/mzdy_potvrdenia/narok_nemocenska_v15/narok_nemocenska_v15_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function ZnovuPotvrdenie()
  {
  window.open('potvrd_nemd.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1', '_self');
  }
  function tlacpdf(oc)
  {
   window.open('potvrd_nemd.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=' + oc + '&xx=1', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }   
</script>

<?php
//osobne cislo prepinanie
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
$nasieloc=0;
$i=0;
while ( $i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if ( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }
if ( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $next_oc=$next_oc+1;
if ( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
}
?>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
    {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
   <td class="header">Potvrdenie nároku na nemocenskú dávku - <span class="subheader"><?php echo "$oc $meno $prie"; ?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC(<?php echo $prev_oc; ?>);" title="Os.è. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC(<?php echo $next_oc; ?>);" title="Os.è. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="NavodVyplnenie();" title="Pouèenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="ZnovuPotvrdenie();" title="Naèíta údaje" class="btn-form-tool"> <!-- dopyt, preveri -->
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacpdf(<?php echo $cislo_oc; ?>);"
      title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="potvrd_nemd.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave" style="top:4px;">
<img src="../dokumenty/mzdy_potvrdenia/narok_nemocenska_v15/narok_nemocenska_v15_form.jpg"
 alt="tlaèivo Potvrdenie zamestnávate¾a o zamestnancovi na úèely uplatnenia nároku na nemocenskú dávku 232kB" class="form-background">

<!-- zamestnavatel -->
<span class="text-echo" style="top:190px; left:50px;"><?php echo $zamestnavatel; ?></span>

<!-- zamestnanec -->
<span class="text-echo" style="top:85px; left:132px;"><?php echo $rodne; ?></span>
<span class="text-echo" style="top:105px; left:85px;"><?php echo $meno; ?></span>
<span class="text-echo" style="top:105px; left:425px;"><?php echo $prie; ?></span>
<span class="text-echo" style="top:130px; left:160px;"><?php echo $dar_sk; ?></span>
<select size="1" name="rdstav" id="rdstav" style="top:128px; left:440px;">
 <option value="0">slobodný/slobodná</option>
 <option value="1">ženatý/vydatá</option>
 <option value="2">vdovec/vdova</option>
 <option value="3">rozvedený/rozvedená</option>
</select>
<span class="text-echo" style="top:171px; left:290px;"><?php echo $adresa; ?></span>
<select size="1" name="uzemie" id="uzemie" style="top:210px; left:240px;">
 <option value="0">na území SR</option>
 <option value="1">mimo územia SR</option>
 <option value="2">na území aj mimo územia SR</option>
</select>

<!-- bod 1. -->
<span class="text-echo" style="top:238px; left:630px;"><?php echo $dan_sk; ?></span>
<span class="text-echo" style="top:259px; left:570px;"><?php echo $dav_sk; ?></span>

<!-- bod 2. -->
<input type="text" name="napprc" id="napprc" onkeyup="CiarkaNaBodku(this);"
 style="top:284px; left:310px; width:80px;"/>

<!-- bod 3. -->
<input type="text" name="preod1" id="preod1" onkeyup="CiarkaNaBodku(this);"
 style="top:350px; left:70px; width:80px;"/>
<input type="text" name="predo1" id="predo1" onkeyup="CiarkaNaBodku(this);"
 style="top:350px; left:270px; width:80px;"/>
<input type="text" name="predv1" id="predv1" style="top:350px; left:470px; width:400px;"/>
<input type="text" name="preod2" id="preod2" onkeyup="CiarkaNaBodku(this);"
 style="top:376px; left:70px; width:80px;"/>
<input type="text" name="predo2" id="predo2" onkeyup="CiarkaNaBodku(this);"
 style="top:376px; left:270px; width:80px;"/>
<input type="text" name="predv2" id="predv2" style="top:376px; left:470px; width:400px;"/>
<input type="text" name="preod3" id="preod3" onkeyup="CiarkaNaBodku(this);"
 style="top:402px; left:70px; width:80px;"/>
<input type="text" name="predo3" id="predo3" onkeyup="CiarkaNaBodku(this);"
 style="top:402px; left:270px; width:80px;"/>
<input type="text" name="predv3" id="predv3" style="top:402px; left:470px; width:400px;"/>

<input type="text" name="preod4" id="preod4" onkeyup="CiarkaNaBodku(this);"
 style="top:427px; left:70px; width:80px;"/>
<input type="text" name="predo4" id="predo4" onkeyup="CiarkaNaBodku(this);"
 style="top:427px; left:270px; width:80px;"/>
<input type="text" name="predv4" id="predv4" style="top:427px; left:470px; width:400px;"/>

<!-- bod 4. -->
<select size="1" name="fe101" id="fe101" style="top:458px; left:250px;">
 <option value="0">nebola</option>
 <option value="1">bola</option>
</select>

<!-- bod 5. -->
<input type="text" name="text51" id="text51" style="top:533px; left:47px; width:800px;"/>
<input type="text" name="text52" id="text52" style="top:560px; left:47px; width:800px;"/>
<input type="text" name="text53" id="text53" style="top:587px; left:47px; width:800px;"/>

<!-- bod 6. -->
<input type="text" name="vo01" id="vo01" style="top:712px; left:132px; width:36px;"/>
<input type="text" name="vz01" id="vz01" onkeyup="CiarkaNaBodku(this);"
       style="top:712px; left:190px; width:90px;"/>
<input type="text" name="vo02" id="vo02" style="top:739px; left:132px; width:36px;"/>
<input type="text" name="vz02" id="vz02" onkeyup="CiarkaNaBodku(this);"
       style="top:739px; left:190px; width:90px;"/>
<input type="text" name="vo03" id="vo03" style="top:765px; left:132px; width:36px;"/>
<input type="text" name="vz03" id="vz03" onkeyup="CiarkaNaBodku(this);"
 style="top:765px; left:190px; width:90px;"/>
<input type="text" name="vo04" id="vo04" style="top:791px; left:132px; width:36px;"/>
<input type="text" name="vz04" id="vz04" onkeyup="CiarkaNaBodku(this);"
 style="top:791px; left:190px; width:90px;"/>
<input type="text" name="vo05" id="vo05" style="top:817px; left:132px; width:36px;"/>
<input type="text" name="vz05" id="vz05" onkeyup="CiarkaNaBodku(this);"
       style="top:817px; left:190px; width:90px;"/>
<input type="text" name="vo06" id="vo06" style="top:844px; left:132px; width:36px;"/>
<input type="text" name="vz06" id="vz06" onkeyup="CiarkaNaBodku(this);"
       style="top:844px; left:190px; width:90px;"/>
<input type="text" name="vo07" id="vo07" style="top:870px; left:132px; width:36px;"/>
<input type="text" name="vz07" id="vz07" onkeyup="CiarkaNaBodku(this);"
 style="top:870px; left:190px; width:90px;"/>
<input type="text" name="vo08" id="vo08" style="top:896px; left:132px; width:36px;"/>
<input type="text" name="vz08" id="vz08" onkeyup="CiarkaNaBodku(this);"
       style="top:896px; left:190px; width:90px;"/>
<input type="text" name="vo09" id="vo09" style="top:922px; left:132px; width:36px;"/>
<input type="text" name="vz09" id="vz09" onkeyup="CiarkaNaBodku(this);"
       style="top:922px; left:190px; width:90px;"/>
<input type="text" name="vo10" id="vo10" style="top:948px; left:132px; width:36px;"/>
<input type="text" name="vz10" id="vz10" onkeyup="CiarkaNaBodku(this);"
 style="top:948px; left:190px; width:90px;"/>
<input type="text" name="vo11" id="vo11" style="top:975px; left:132px; width:36px;"/>
<input type="text" name="vz11" id="vz11" onkeyup="CiarkaNaBodku(this);"
       style="top:975px; left:190px; width:90px;"/>
<input type="text" name="vo12" id="vo12" style="top:1001px; left:132px; width:36px;"/>
<input type="text" name="vz12" id="vz12" onkeyup="CiarkaNaBodku(this);"
       style="top:1001px; left:190px; width:90px;"/>
<span class="text-echo" style="top:1033px; right:665px;"><?php echo $vzspolu; ?></span>

<!-- bod 6. minuly -->
<input type="text" name="vp01" id="vp01" style="top:712px; left:385px; width:36px;"/>
<input type="text" name="vm01" id="vm01" onkeyup="CiarkaNaBodku(this);"
       style="top:712px; left:445px; width:90px;"/>
<input type="text" name="vp02" id="vp02" style="top:739px; left:385px; width:36px;"/>
<input type="text" name="vm02" id="vm02" onkeyup="CiarkaNaBodku(this);"
       style="top:739px; left:445px; width:90px;"/>
<input type="text" name="vp03" id="vp03" style="top:765px; left:385px; width:36px;"/>
<input type="text" name="vm03" id="vm03" onkeyup="CiarkaNaBodku(this);"
       style="top:765px; left:445px; width:90px;"/>
<input type="text" name="vp04" id="vp04" style="top:791px; left:385px; width:36px;"/>
<input type="text" name="vm04" id="vm04" onkeyup="CiarkaNaBodku(this);"
       style="top:791px; left:445px; width:90px;"/>
<input type="text" name="vp05" id="vp05" style="top:817px; left:385px; width:36px;"/>
<input type="text" name="vm05" id="vm05" onkeyup="CiarkaNaBodku(this);"
       style="top:817px; left:445px; width:90px;"/>
<input type="text" name="vp06" id="vp06" style="top:844px; left:385px; width:36px;"/>
<input type="text" name="vm06" id="vm06" onkeyup="CiarkaNaBodku(this);"
       style="top:844px; left:445px; width:90px;"/>
<input type="text" name="vp07" id="vp07" style="top:870px; left:385px; width:36px;"/>
<input type="text" name="vm07" id="vm07" onkeyup="CiarkaNaBodku(this);"
       style="top:870px; left:445px; width:90px;"/>
<input type="text" name="vp08" id="vp08" style="top:896px; left:385px; width:36px;"/>
<input type="text" name="vm08" id="vm08" onkeyup="CiarkaNaBodku(this);"
       style="top:896px; left:445px; width:90px;"/>
<input type="text" name="vp09" id="vp09" style="top:922px; left:385px; width:36px;"/>
<input type="text" name="vm09" id="vm09" onkeyup="CiarkaNaBodku(this);"
       style="top:922px; left:445px; width:90px;"/>
<input type="text" name="vp10" id="vp10" style="top:948px; left:385px; width:36px;"/>
<input type="text" name="vm10" id="vm10" onkeyup="CiarkaNaBodku(this);"
       style="top:948px; left:445px; width:90px;"/>
<input type="text" name="vp11" id="vp11" style="top:975px; left:385px; width:36px;"/>
<input type="text" name="vm11" id="vm11" onkeyup="CiarkaNaBodku(this);"
       style="top:975px; left:445px; width:90px;"/>
<input type="text" name="vp12" id="vp12" style="top:1001px; left:385px; width:36px;"/>
<input type="text" name="vm12" id="vm12" onkeyup="CiarkaNaBodku(this);"
 style="top:1001px; left:445px; width:90px;"/>
<span class="text-echo" style="top:1033px; right:410px;"><?php echo $vmspolu; ?></span> <!-- dopyt, nepoèíta -->

<!-- bod 7. -->
<input type="text" name="vzodhad" id="vzodhad" onkeyup="CiarkaNaBodku(this);"
       style="top:1122px; left:50px; width:90px;"/>

<!-- bod 8. -->
<span class="text-echo" style="top:1201px; left:65px; font-size:15px;"><?php echo "$fir_mzdt05 tel. $fir_mzdt04"; ?></span>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);"
       style="top:1225px; left:93px; width:80px;"/>

<!-- poznamka -->
<label for="pozn" style="position:absolute; top:1276px; left:190px; font-size:12px; font-weight:bold;">Poznámka</label>
<input type="text" name="pozn" id="pozn" style="top:1268px; right:8px; width:680px;"/>

<!-- dopl.info na 2.stranu -->
<label for="str2" style="position:absolute; top:645px; left:615px; font-size:12px; font-weight:bold;">Dopl. info na 2. stranu</label>
<textarea name="str2" id="str2" style="top:660px; left:615px; width:300px; height:400px;"><?php echo $str2; ?></textarea>
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC POTVRDENIE
if ( $copern == 10 )
{

//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpotvrdenienemd".
" SET vzspolu=vz01+vz02+vz03+vz04+vz05+vz06+vz07+vz08+vz09+vz10+vz11+vz12 WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if ( File_Exists("../tmp/potvrdenieFO.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdenieFO.$kli_uzid.pdf"); }
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
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/mzdy_potvrdenia/narok_nemocenska_v15/narok_nemocenska_v15.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/narok_nemocenska_v15/narok_nemocenska_v15.jpg',0,0,210,297);
}
$pdf->SetY(10);
$pdf->SetFont('arial','',9);

//zamestnanec
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(25,4," ","$rmc1",0,"L");$pdf->Cell(25,4,"$hlavicka->rdc $hlavicka->rdk","$rmc",1,"L");
$pdf->Cell(15,4," ","$rmc1",0,"L");$pdf->Cell(58,4,"$hlavicka->meno","$rmc",0,"L");
$pdf->Cell(16,4," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->prie","$rmc",1,"L");
$dar=SkDatum($hlavicka->dar);
$pdf->Cell(30,3," ","$rmc1",0,"L");$pdf->Cell(43,3,"$dar","$rmc",0,"L");$pdf->Cell(19,3," ","$rmc1",0,"L");
if ( $hlavicka->rdstav == 0 ) { $pdf->Cell(30,3,"slobodný/slobodná","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 1 ) { $pdf->Cell(30,3,"ženatý/vydatá","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 2 ) { $pdf->Cell(68,3,"vdovec/vdova","$rmc",1,"L"); }
if ( $hlavicka->rdstav == 3 ) { $pdf->Cell(30,3,"rozvedený/rozvedená","$rmc",1,"L"); }
$pdf->Cell(59,4," ","$rmc1",0,"L");$pdf->Cell(104,4,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(59,4," ","$rmc1",0,"L");$pdf->Cell(104,4,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");
$pdf->Cell(59,4," ","$rmc1",0,"L");$pdf->Cell(80,3,"IÈZ: $cicz","$rmc",1,"L");
$pdf->Cell(48,4," ","$rmc1",0,"L");
if ( $hlavicka->uzemie == 0 )
{
$pdf->Cell(21,4," ","$rmc",0,"L");$pdf->Cell(77,4,"----------------------------------------------------------------------","$rmc1",1,"L");
}
if ( $hlavicka->uzemie == 1 )
{
$pdf->Cell(22,4,"-------------------","$rmc1",0,"L");$pdf->Cell(26,4," ","$rmc",0,"L");$pdf->Cell(50,4,"---------------------------------------------","$rmc1",1,"L");
}
if ( $hlavicka->uzemie == 2 )
{
$pdf->Cell(22,4,"-------------------","$rmc1",0,"L");$pdf->Cell(27,4,"----------------------","$rmc1",0,"L");$pdf->Cell(49,4," ","$rmc",1,"L");
}

//bod 1.
$dan=SkDatum($hlavicka->dan);
$dav=SkDatum($hlavicka->dav); if ( $dav == "00.00.0000" ) $dav="";
$pdf->Cell(150,2," ","$rmc1",1,"L");
$pdf->Cell(139,4," ","$rmc1",0,"L");$pdf->Cell(20,4,"$dan","$rmc",1,"L");
$pdf->Cell(121,4," ","$rmc1",0,"L");$pdf->Cell(20,3,"$dav","$rmc",1,"L");

//bod 2.
$napprc=SkDatum($hlavicka->napprc); if ( $napprc == "00.00.0000" ) $napprc="";
$pdf->Cell(150,2," ","$rmc1",1,"L");
$pdf->Cell(64,4," ","$rmc1",0,"L");$pdf->Cell(20,4,"$napprc","$rmc",1,"L");

//bod 3.
$pdf->SetFont('arial','',8);
$preod1=SkDatum($hlavicka->preod1); if ( $preod1 == "00.00.0000" ) $preod1="";
$predo1=SkDatum($hlavicka->predo1); if ( $predo1 == "00.00.0000" ) $predo1="";
$predv1=$hlavicka->predv1;
$preod2=SkDatum($hlavicka->preod2); if ( $preod2 == "00.00.0000" ) $preod2="";
$predo2=SkDatum($hlavicka->predo2); if ( $predo2 == "00.00.0000" ) $predo2="";
$predv2=$hlavicka->predv2;
$preod3=SkDatum($hlavicka->preod3); if ( $preod3 == "00.00.0000" ) $preod3="";
$predo3=SkDatum($hlavicka->predo3); if ( $predo3 == "00.00.0000" ) $predo3="";
$predv3=$hlavicka->predv3;
$preod4=SkDatum($hlavicka->preod4); if ( $preod4 == "00.00.0000" ) $preod4="";
$predo4=SkDatum($hlavicka->predo4); if ( $predo4 == "00.00.0000" ) $predo4="";
$predv4=$hlavicka->predv4;
$pdf->Cell(150,9," ","$rmc1",1,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,5,"$preod1","$rmc",0,"L");
$pdf->Cell(25,4," ","$rmc1",0,"L");$pdf->Cell(20,5,"$predo1","$rmc",0,"L");
$pdf->Cell(23,4," ","$rmc1",0,"L");$pdf->Cell(64,5,"$predv1","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,2.5,"$preod2","$rmc",0,"L");
$pdf->Cell(25,4," ","$rmc1",0,"L");$pdf->Cell(20,2.5,"$predo2","$rmc",0,"L");
$pdf->Cell(23,4," ","$rmc1",0,"L");$pdf->Cell(64,2.5,"$predv2","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,4.5,"$preod3","$rmc",0,"L");
$pdf->Cell(25,4," ","$rmc1",0,"L");$pdf->Cell(20,4.5,"$predo3","$rmc",0,"L");
$pdf->Cell(23,4," ","$rmc1",0,"L");$pdf->Cell(64,4.5,"$predv3","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,3.5,"$preod4","$rmc",0,"L");
$pdf->Cell(25,4," ","$rmc1",0,"L");$pdf->Cell(20,3.5,"$predo4","$rmc",0,"L");
$pdf->Cell(23,4," ","$rmc1",0,"L");$pdf->Cell(64,3.5,"$predv4","$rmc",1,"L");
$pdf->SetFont('arial','',9);

//bod 4.
$pdf->Cell(150,2," ","$rmc1",1,"L");
$pdf->Cell(50,4," ","$rmc1",0,"L");
if ( $hlavicka->fe101 == 0 )
{
$pdf->Cell(40,4,"-------","$rmc1",1,"L");
}
if ( $hlavicka->fe101 == 1 )
{
$pdf->Cell(9,4," ","$rmc",0,"L");$pdf->Cell(20,4,"-----------","$rmc1",1,"L");
}

//bod 5.
$pdf->Cell(150,12.5," ","$rmc1",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(156,4,"$hlavicka->text51","$rmc",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(156,4.5,"$hlavicka->text52","$rmc",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(156,3.5,"$hlavicka->text53","$rmc",1,"L");

//bod 6.
$vo01=$hlavicka->vo01; 
$vo02=$hlavicka->vo02; 
$vo03=$hlavicka->vo03; 
$vo04=$hlavicka->vo04; 
$vo05=$hlavicka->vo05; 
$vo06=$hlavicka->vo06; 
$vo07=$hlavicka->vo07; 
$vo08=$hlavicka->vo08; 
$vo09=$hlavicka->vo09; 
$vo10=$hlavicka->vo10; 
$vo11=$hlavicka->vo11; 
$vo12=$hlavicka->vo12; 
$vp01=$hlavicka->vp01;
$vp02=$hlavicka->vp02;
$vp03=$hlavicka->vp03;
$vp04=$hlavicka->vp04;
$vp05=$hlavicka->vp05;
$vp06=$hlavicka->vp06;
$vp07=$hlavicka->vp07;
$vp08=$hlavicka->vp08;
$vp09=$hlavicka->vp09;
$vp10=$hlavicka->vp10;
$vp11=$hlavicka->vp11;
$vp12=$hlavicka->vp12;
$pdf->Cell(150,20," ","$rmc1",1,"L");
$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(18,6,"$vo01","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vz01","$rmc",0,"R");
$pdf->Cell(13,5," ","$rmc1",0,"L");$pdf->Cell(18,6,"$vp01","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vm01","$rmc",1,"R");

$pdf->Cell(19,5," ","$rmc1",0,"L");$pdf->Cell(17,5,"$vo02","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz02","$rmc",0,"R");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(17,5,"$vp02","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm02","$rmc",1,"R");

$pdf->Cell(17,6," ","$rmc1",0,"L");$pdf->Cell(19,5,"$vo03","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz03","$rmc",0,"R");
$pdf->Cell(12,6," ","$rmc1",0,"L");$pdf->Cell(19,5,"$vp03","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm03","$rmc",1,"R");

$pdf->Cell(15,5," ","$rmc1",0,"L");$pdf->Cell(21,5,"$vo04","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz04","$rmc",0,"R");
$pdf->Cell(10,5," ","$rmc1",0,"L");$pdf->Cell(21,5,"$vp04","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm04","$rmc",1,"R");

$pdf->Cell(13,5," ","$rmc1",0,"L");$pdf->Cell(23,5,"$vo05","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz05","$rmc",0,"R");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(23,5,"$vp05","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm05","$rmc",1,"R");

$pdf->Cell(13,6," ","$rmc1",0,"L");$pdf->Cell(23,5,"$vo06","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz06","$rmc",0,"R");
$pdf->Cell(8,6," ","$rmc1",0,"L");$pdf->Cell(23,5,"$vp06","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm06","$rmc",1,"R");

$pdf->Cell(12,5," ","$rmc1",0,"L");$pdf->Cell(24,6,"$vo07","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vz07","$rmc",0,"R");
$pdf->Cell(7,5," ","$rmc1",0,"L");$pdf->Cell(24,6,"$vp07","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vm07","$rmc",1,"R");

$pdf->Cell(18,5," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vo08","$rmc",0,"L");$pdf->Cell(29,4,"$hlavicka->vz08","$rmc",0,"R");
$pdf->Cell(13,5," ","$rmc1",0,"L");$pdf->Cell(18,4,"$vp08","$rmc",0,"L");$pdf->Cell(29,4,"$hlavicka->vm08","$rmc",1,"R");

$pdf->Cell(23,6," ","$rmc1",0,"L");$pdf->Cell(13,6,"$vo09","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vz09","$rmc",0,"R");
$pdf->Cell(19,6," ","$rmc1",0,"L");$pdf->Cell(12,6,"$vp09","$rmc",0,"L");$pdf->Cell(29,6,"$hlavicka->vm09","$rmc",1,"R");

$pdf->Cell(19,5," ","$rmc1",0,"L");$pdf->Cell(17,5,"$vo10","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz10","$rmc",0,"R");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(17,5,"$vp10","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm10","$rmc",1,"R");

$pdf->Cell(22,5," ","$rmc1",0,"L");$pdf->Cell(14,5,"$vo11","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz11","$rmc",0,"R");
$pdf->Cell(17,5," ","$rmc1",0,"L");$pdf->Cell(14,5,"$vp11","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm11","$rmc",1,"R");

$pdf->Cell(22,5," ","$rmc1",0,"L");$pdf->Cell(14,5,"$vo12","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vz12","$rmc",0,"R");
$pdf->Cell(17,5," ","$rmc1",0,"L");$pdf->Cell(14,5,"$vp12","$rmc",0,"L");$pdf->Cell(29,5,"$hlavicka->vm12","$rmc",1,"R");

$pdf->Cell(36,6," ","$rmc1",0,"L");$pdf->Cell(29,5,"$hlavicka->vzspolu","$rmc",0,"R");
$pdf->Cell(31,6," ","$rmc1",0,"L");$pdf->Cell(29,5,"$hlavicka->vmspolu","$rmc",1,"R");

//bod 7.
$vzodhad=$hlavicka->vzodhad; if ( $vzodhad == 0 ) $vzodhad="";
$pdf->Cell(150,18," ","$rmc1",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(32,5,"$vzodhad","$rmc",1,"L");

//bod 8.
$pdf->Cell(190,10.5," ","$rmc1",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(155,5,"$fir_mzdt05 tel. $fir_mzdt04","$rmc",1,"L");

//datum
$datumsk=SkDatum($hlavicka->datum);
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(78,4," ","$rmc1",0,"L");$pdf->Cell(18,5,"$datumsk","$rmc",1,"L");

//poznamka
if ( $copern == 10 ) $pozn=$hlavicka->pozn;
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(174,5,"$pozn","$rmc",1,"L");
}
$i = $i + 1;
  }

//dopl.info na 2.strane
$pole = explode("\r\n", $hlavicka->str2);
if ( $pole[0] != '' )
{
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

$pdf->SetY(10);
$pdf->SetFont('arial','',9);

$ipole=1;
foreach( $pole as $hodnota ) {
if ( $ipole == 1 )
{ $pdf->Cell(150,5,"Potvrdenie zamestnávate¾a o zamestnancovi na úèely uplatnenia nároku na nemocenskú dávku","B",0,"L");
  $pdf->Cell(0,5,"2.strana","B",1,"R");
}
if ( $ipole == 1 )
{
$pdf->Cell(190,8," ","$rmc1",1,"R");
$pdf->Cell(22,5,"Zamestnanec","B",1,"C");
$pdf->Cell(150,6,"Rod.èíslo: $hlavicka->rdc $hlavicka->rdk   Meno,priezvisko: $hlavicka->meno $hlavicka->prie","$rmc",1,"L");
$pdf->Cell(190,8," ","$rmc1",1,"R");
}
$pdf->Cell(180,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                             }
$pdf->Cell(190,50," ","$rmc1",1,"R");
$pdf->Cell(20,5,"$datumsk","$rmc",0,"C");
$pdf->Cell(115,6,"","$rmc1",0,"R");$pdf->Cell(45,7,"peèiatka a podpis","T",1,"C");
$pdf->Cell(135,6,"","$rmc1",0,"R");$pdf->Cell(45,2,"zamestnávate¾a","0",1,"C");
}

$pdf->Output("../tmp/potvrdenieFO.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/potvrdenieFO.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA POTVRDENIA
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>
