<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

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

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$jedn = 1*$_REQUEST['jedn'];

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_zapoctovylist WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);
$neschop = strip_tags($_REQUEST['neschop']);
$vylod1 = strip_tags($_REQUEST['vylod1']);
$vyldo1 = strip_tags($_REQUEST['vyldo1']);
//$vyldv1 = strip_tags($_REQUEST['vyldv1']);
$vyldni1 = strip_tags($_REQUEST['vyldni1']);
$vylod2 = strip_tags($_REQUEST['vylod2']);
$vyldo2 = strip_tags($_REQUEST['vyldo2']);
//$vyldv2 = strip_tags($_REQUEST['vyldv2']);
$vyldni2 = strip_tags($_REQUEST['vyldni2']);
$vylod3 = strip_tags($_REQUEST['vylod3']);
$vyldo3 = strip_tags($_REQUEST['vyldo3']);
//$vyldv3 = strip_tags($_REQUEST['vyldv3']);
$vyldni3 = strip_tags($_REQUEST['vyldni3']);
$vylod4 = strip_tags($_REQUEST['vylod4']);
$vyldo4 = strip_tags($_REQUEST['vyldo4']);
//$vyldv4 = strip_tags($_REQUEST['vyldv4']);
$vyldni4 = strip_tags($_REQUEST['vyldni4']);
$vylod5 = strip_tags($_REQUEST['vylod5']);
$vyldo5 = strip_tags($_REQUEST['vyldo5']);
//$vyldv5 = strip_tags($_REQUEST['vyldv5']);
$vyldni5 = strip_tags($_REQUEST['vyldni5']);
$vyl2od1 = strip_tags($_REQUEST['vyl2od1']);
$vyl2do1 = strip_tags($_REQUEST['vyl2do1']);
//$vyl2dv1 = strip_tags($_REQUEST['vyl2dv1']);
$vyl2dni1 = strip_tags($_REQUEST['vyl2dni1']);
$vylod1_sql=SqlDatum($vylod1);
$vyldo1_sql=SqlDatum($vyldo1);
$vylod2_sql=SqlDatum($vylod2);
$vyldo2_sql=SqlDatum($vyldo2);
$vylod3_sql=SqlDatum($vylod3);
$vyldo3_sql=SqlDatum($vyldo3);
$vylod4_sql=SqlDatum($vylod4);
$vyldo4_sql=SqlDatum($vyldo4);
$vylod5_sql=SqlDatum($vylod5);
$vyldo5_sql=SqlDatum($vyldo5);
$vyl2od1_sql=SqlDatum($vyl2od1);
$vyl2do1_sql=SqlDatum($vyl2do1);
$rok = strip_tags($_REQUEST['rok']);
$roks = strip_tags($_REQUEST['roks']);
$dni = strip_tags($_REQUEST['dni']);
$dnis = strip_tags($_REQUEST['dnis']);
$dovod = strip_tags($_REQUEST['dovod']);

//$vyl2od2 = strip_tags($_REQUEST['vyl2od2']);
//$vyl2do2 = strip_tags($_REQUEST['vyl2do2']);
//$vyl2dv2 = strip_tags($_REQUEST['vyl2dv2']);
//$vyl2dni2 = strip_tags($_REQUEST['vyl2dni2']);
//$vyl2od3 = strip_tags($_REQUEST['vyl2od3']);
//$vyl2do3 = strip_tags($_REQUEST['vyl2do3']);
//$vyl2dv3 = strip_tags($_REQUEST['vyl2dv3']);
//$vyl2dni3 = strip_tags($_REQUEST['vyl2dni3']);
//$vyl2od4 = strip_tags($_REQUEST['vyl2od4']);
//$vyl2do4 = strip_tags($_REQUEST['vyl2do4']);
//$vyl2dv4 = strip_tags($_REQUEST['vyl2dv4']);
//$vyl2dni4 = strip_tags($_REQUEST['vyl2dni4']);
//$vyl2od5 = strip_tags($_REQUEST['vyl2od5']);
//$vyl2do5 = strip_tags($_REQUEST['vyl2do5']);
//$vyl2dv5 = strip_tags($_REQUEST['vyl2dv5']);
//$vyl2dni5 = strip_tags($_REQUEST['vyl2dni5']);
//$vyl3od1 = strip_tags($_REQUEST['vyl3od1']);
//$vyl3do1 = strip_tags($_REQUEST['vyl3do1']);
//$vyl3dv1 = strip_tags($_REQUEST['vyl3dv1']);
//$vyl3dni1 = strip_tags($_REQUEST['vyl3dni1']);
//$vyl3od2 = strip_tags($_REQUEST['vyl3od2']);
//$vyl3do2 = strip_tags($_REQUEST['vyl3do2']);
//$vyl3dv2 = strip_tags($_REQUEST['vyl3dv2']);
//$vyl3dni2 = strip_tags($_REQUEST['vyl3dni2']);
//$vyl3od3 = strip_tags($_REQUEST['vyl3od3']);
//$vyl3do3 = strip_tags($_REQUEST['vyl3do3']);
//$vyl3dv3 = strip_tags($_REQUEST['vyl3dv3']);
//$vyl3dni3 = strip_tags($_REQUEST['vyl3dni3']);
//$vyl3od4 = strip_tags($_REQUEST['vyl3od4']);
//$vyl3do4 = strip_tags($_REQUEST['vyl3do4']);
//$vyl3dv4 = strip_tags($_REQUEST['vyl3dv4']);
//$vyl3dni4 = strip_tags($_REQUEST['vyl3dni4']);
//$vyl3od5 = strip_tags($_REQUEST['vyl3od5']);
//$vyl3do5 = strip_tags($_REQUEST['vyl3do5']);
//$vyl3dv5 = strip_tags($_REQUEST['vyl3dv5']);
//$vyl3dni5 = strip_tags($_REQUEST['vyl3dni5']);
//$vyl2od2_sql=SqlDatum($vyl2od2);
//$vyl2do2_sql=SqlDatum($vyl2do2);
//$vyl2od3_sql=SqlDatum($vyl2od3);
//$vyl2do3_sql=SqlDatum($vyl2do3);
//$vyl2od4_sql=SqlDatum($vyl2od4);
//$vyl2do4_sql=SqlDatum($vyl2do4);
//$vyl2od5_sql=SqlDatum($vyl2od5);
//$vyl2do5_sql=SqlDatum($vyl2do5);
//$vyl3od1_sql=SqlDatum($vyl3od1);
//$vyl3do1_sql=SqlDatum($vyl3do1);
//$vyl3od2_sql=SqlDatum($vyl3od2);
//$vyl3do2_sql=SqlDatum($vyl3do2);
//$vyl3od3_sql=SqlDatum($vyl3od3);
//$vyl3do3_sql=SqlDatum($vyl3do3);
//$vyl3od4_sql=SqlDatum($vyl3od4);
//$vyl3do4_sql=SqlDatum($vyl3do4);
//$vyl3od5_sql=SqlDatum($vyl3od5);
//$vyl3do5_sql=SqlDatum($vyl3do5);

//$por1 = strip_tags($_REQUEST['por1']);
//$vzv1 = strip_tags($_REQUEST['vzv1']);
//$vzd1 = strip_tags($_REQUEST['vzd1']);
//$vzz1 = strip_tags($_REQUEST['vzz1']);
//$ost1 = strip_tags($_REQUEST['ost1']);
//$osd1 = strip_tags($_REQUEST['osd1']);
//$osz1 = strip_tags($_REQUEST['osz1']);
//$exe1 = strip_tags($_REQUEST['exe1']);
//$prs1 = strip_tags($_REQUEST['prs1']);
//$por2 = strip_tags($_REQUEST['por2']);
//$vzv2 = strip_tags($_REQUEST['vzv2']);
//$vzd2 = strip_tags($_REQUEST['vzd2']);
//$vzz2 = strip_tags($_REQUEST['vzz2']);
//$ost2 = strip_tags($_REQUEST['ost2']);
//$osd2 = strip_tags($_REQUEST['osd2']);
//$osz2 = strip_tags($_REQUEST['osz2']);
//$exe2 = strip_tags($_REQUEST['exe2']);
//$prs2 = strip_tags($_REQUEST['prs2']);
//$por3 = strip_tags($_REQUEST['por3']);
//$vzv3 = strip_tags($_REQUEST['vzv3']);
//$vzd3 = strip_tags($_REQUEST['vzd3']);
//$vzz3 = strip_tags($_REQUEST['vzz3']);
//$ost3 = strip_tags($_REQUEST['ost3']);
//$osd3 = strip_tags($_REQUEST['osd3']);
//$osz3 = strip_tags($_REQUEST['osz3']);
//$exe3 = strip_tags($_REQUEST['exe3']);
//$prs3 = strip_tags($_REQUEST['prs3']);
//$pozn = strip_tags($_REQUEST['pozn']);
$str2 = strip_tags($_REQUEST['str2']);
//$kval = strip_tags($_REQUEST['kval']);
//$zps = strip_tags($_REQUEST['zps']);
//$poist = strip_tags($_REQUEST['poist']);
//$poisc = strip_tags($_REQUEST['poisc']);
//$poism = strip_tags($_REQUEST['poism']);
//$poisa = strip_tags($_REQUEST['poisa']);
//$poisk = strip_tags($_REQUEST['poisk']);
//$spor = strip_tags($_REQUEST['spor']);
//$osta = strip_tags($_REQUEST['osta']);
$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_zapoctovylist SET ".
" neschop='$neschop', ".
" vylod1='$vylod1_sql', vyldo1='$vyldo1_sql', ".
" vylod2='$vylod2_sql', vyldo2='$vyldo2_sql', ".
" vylod3='$vylod3_sql', vyldo3='$vyldo3_sql', ".
" vylod4='$vylod4_sql', vyldo4='$vyldo4_sql', ".
" vylod5='$vylod5_sql', vyldo5='$vyldo5_sql', ".
" vyl2od1='$vyl2od1_sql', vyl2do1='$vyl2do1_sql', ".
" rok='$rok', roks='$roks', dni='$dni', dnis='$dnis', dovod='$dovod', ".
" datum='$datum_sql', str2='$str2' ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//vytvorenie tabulky
$sql = "SELECT osta FROM F$vyb_xcf"."_zapoctovylist";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlt = <<<mzdprc
(
   ume          DECIMAL(7,4) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   datvys       DATE,
   datnas       DATE,
   datnar       DATE,
   dnipom       DECIMAL(5,0) DEFAULT 0,
   rokvys       DECIMAL(4,0) DEFAULT 0,
   roknas       DECIMAL(4,0) DEFAULT 0,
   vylod1       DATE,
   vyldo1       DATE,
   vyldv1       VARCHAR(60),
   vyldni1      INT(7) DEFAULT 0,
   vylod2       DATE,
   vyldo2       DATE,
   vyldv2       VARCHAR(60),
   vyldni2      INT(7) DEFAULT 0,
   vylod3       DATE,
   vyldo3       DATE,
   vyldv3       VARCHAR(60),
   vyldni3      INT(7) DEFAULT 0,
   vylod4       DATE,
   vyldo4       DATE,
   vyldv4       VARCHAR(60),
   vyldni4      INT(7) DEFAULT 0,
   vylod5       DATE,
   vyldo5       DATE,
   vyldv5       VARCHAR(60),
   vyldni5      INT(7) DEFAULT 0,
   vyl2od1       DATE,
   vyl2do1       DATE,
   vyl2dv1       VARCHAR(60),
   vyl2dni1      INT(7) DEFAULT 0,
   vyl2od2       DATE,
   vyl2do2       DATE,
   vyl2dv2       VARCHAR(60),
   vyl2dni2      INT(7) DEFAULT 0,
   vyl2od3       DATE,
   vyl2do3       DATE,
   vyl2dv3       VARCHAR(60),
   vyl2dni3      INT(7) DEFAULT 0,
   vyl2od4       DATE,
   vyl2do4       DATE,
   vyl2dv4       VARCHAR(60),
   vyl2dni4      INT(7) DEFAULT 0,
   vyl2od5       DATE,
   vyl2do5       DATE,
   vyl2dv5       VARCHAR(60),
   vyl2dni5      INT(7) DEFAULT 0,
   vyl3od1       DATE,
   vyl3do1       DATE,
   vyl3dv1       VARCHAR(60),
   vyl3dni1      INT(7) DEFAULT 0,
   vyl3od2       DATE,
   vyl3do2       DATE,
   vyl3dv2       VARCHAR(60),
   vyl3dni2      INT(7) DEFAULT 0,
   vyl3od3       DATE,
   vyl3do3       DATE,
   vyl3dv3       VARCHAR(60),
   vyl3dni3      INT(7) DEFAULT 0,
   vyl3od4       DATE,
   vyl3do4       DATE,
   vyl3dv4       VARCHAR(60),
   vyl3dni4      INT(7) DEFAULT 0,
   vyl3od5       DATE,
   vyl3do5       DATE,
   vyl3dv5       VARCHAR(60),
   vyl3dni5      INT(7) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0,
   por1         DECIMAL(1,0) DEFAULT 0,
   vzv1         DECIMAL(10,2) DEFAULT 0,
   vzd1         DECIMAL(10,2) DEFAULT 0,
   vzz1         DECIMAL(10,2) DEFAULT 0,
   ost1         DECIMAL(10,2) DEFAULT 0,
   osd1         DECIMAL(10,2) DEFAULT 0,
   osz1         DECIMAL(10,2) DEFAULT 0,
   exe1         VARCHAR(60),
   prs1         VARCHAR(60),
   por2         DECIMAL(1,0) DEFAULT 0,
   vzv2         DECIMAL(10,2) DEFAULT 0,
   vzd2         DECIMAL(10,2) DEFAULT 0,
   vzz2         DECIMAL(10,2) DEFAULT 0,
   ost2         DECIMAL(10,2) DEFAULT 0,
   osd2         DECIMAL(10,2) DEFAULT 0,
   osz2         DECIMAL(10,2) DEFAULT 0,
   exe2         VARCHAR(60),
   prs2         VARCHAR(60),
   por3         DECIMAL(1,0) DEFAULT 0,
   vzv3         DECIMAL(10,2) DEFAULT 0,
   vzd3         DECIMAL(10,2) DEFAULT 0,
   vzz3         DECIMAL(10,2) DEFAULT 0,
   ost3         DECIMAL(10,2) DEFAULT 0,
   osd3         DECIMAL(10,2) DEFAULT 0,
   osz3         DECIMAL(10,2) DEFAULT 0,
   exe3         VARCHAR(60),
   prs3         VARCHAR(60),
   datum        DATE,
   pozn         VARCHAR(80),
   str2         TEXT,
   rok          DECIMAL(4,0) DEFAULT 0,
   roks         VARCHAR(60),
   dni          DECIMAL(4,0) DEFAULT 0,
   dnis         VARCHAR(60),
   dovod        VARCHAR(80),
   kval         VARCHAR(80),
   zps          DECIMAL(1,0) DEFAULT 0,
   poist        DECIMAL(1,0) DEFAULT 0,
   poisc        VARCHAR(20),
   poism        DECIMAL(10,2) DEFAULT 0,
   poisa        VARCHAR(60),
   poisk        VARCHAR(10),
   spor         DECIMAL(1,0) DEFAULT 0,
   osta         VARCHAR(80)
);
mzdprc;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zapoctovylist'.$sqlt;
$vytvor = mysql_query("$vsql");
}

//verzia 2014
$sql = "SELECT dobatxt FROM F$vyb_xcf"."_zapoctovylist";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD roknas DECIMAL(4,0) DEFAULT 0 AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD rokvys DECIMAL(4,0) DEFAULT 0 AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD dnipom DECIMAL(5,0) DEFAULT 0 AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD datnar DATE AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD datnas DATE AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD datvys DATE AFTER oc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD rok2014 DECIMAL(4,0) DEFAULT 0 AFTER osta";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD neschop VARCHAR(30) NOT NULL AFTER rok2014";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zapoctovylist ADD dobatxt VARCHAR(150) NOT NULL AFTER rok2014";
$vysledek = mysql_query("$sql");
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_zapoctovylist WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_zapoctovylist WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_zapoctovylist WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if ( $subor == 1 )
{

//zober data z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT 0,oc,dav,dan,'0000-00-00',0,0,0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,'0000-00-00','0000-00-00','',0,".
"1,".
"0,0,0,0,0,0,0,'','',0,0,0,0,0,0,0,'','',0,0,0,0,0,0,0,'','',".
"'0000-00-00','','', ".
"0,'',0,'','','',0,0,'',0,'','',0,'', ".
"0,'','' ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc = $cislo_oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

//vypocitaj pocet rokov a dni
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datnas=$riaddok->datnas;
  $datvys=$riaddok->datvys;
  }

  $pole = explode("-", $datnas);
  $datnasrok = $pole[0];
  $datnasmes = $pole[1];
  $datnasden = $pole[2];

if( $datvys == '0000-00-00' ) $datvys=$datnas;
  $pole = explode("-", $datvys);
  $datvysrok = $pole[0];
  $datvysmes = $pole[1];
  $datvysden = $pole[2];

$rokroz=$datvysrok-$datnasrok;
if( $rozrok < 0 ) $rozrok=0;
$datnarrok=$datnasrok+$rokroz;
$datnar=$datnarrok."-".$datnasmes."-".$datnasden;
$datnamrok=$datvysrok-1;
$datnam=$datnamrok."-".$datnasmes."-".$datnasden;
//echo $datnam." ".$datnar;
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET datnar='$datnar', datvys=ADDDATE('$datvys',1), rok=$rokroz, datum=now() WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET dni=TO_DAYS(datvys)-TO_DAYS('$datnar') WHERE oc = $cislo_oc AND datnar <= datvys"; 
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET rok=rok-1, dni=TO_DAYS(datvys)-TO_DAYS('$datnam') WHERE oc = $cislo_oc AND datnar > datvys"; 
$oznac = mysql_query("$sqtoz");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rok=1*$riaddok->rok;
  $dni=1*$riaddok->dni;
  }

if ( $rok == 0 ) $roks="nula rokov ";
if ( $rok == 1 ) $roks="jeden rok ";
if ( $rok == 2 ) $roks="dva roky ";
if ( $rok == 3 ) $roks="tri roky ";
if ( $rok == 4 ) $roks="ötyri roky ";
if ( $rok == 5 ) $roks="p‰ù rokov ";
if ( $rok == 6 ) $roks="öesù ";
if ( $rok == 7 ) $roks="sedem ";
if ( $rok == 8 ) $roks="osem ";
if ( $rok == 9 ) $roks="dev‰ù ";
if ( $rok == 10 ) $roks="desaù ";
if ( $rok == 11 ) $roks="jeden·sù ";
if ( $rok == 12 ) $roks="dvan·sù ";
if ( $rok == 13 ) $roks="trin·sù ";
if ( $rok == 14 ) $roks="ötrn·sù ";
if ( $rok == 15 ) $roks="p‰tn·sù ";
if ( $rok == 16 ) $roks="öestn·sù ";
if ( $rok == 17 ) $roks="sedemn·sù ";
if ( $rok == 18 ) $roks="osemn·sù ";
if ( $rok == 19 ) $roks="dev‰tn·sù ";
if ( $rok == 20 ) $roks="dvadsaù ";
if ( $rok == 21 ) $roks="dvadsaùjeden ";
if ( $rok == 22 ) $roks="dvadsaùdva ";
if ( $rok == 23 ) $roks="dvadsaùtri ";
if ( $rok == 24 ) $roks="dvadsaùötyri ";
if ( $rok == 25 ) $roks="dvadsaùp‰ù ";
if ( $rok == 26 ) $roks="dvadsaùöesù ";
if ( $rok == 27 ) $roks="dvadsaùsedem ";
if ( $rok == 28 ) $roks="dvadsaùosem ";
if ( $rok == 29 ) $roks="dvadsaùdev‰ù ";
if ( $rok > 5 ) $roks=$roks."rokov ";

if ( $dni == 0 ) $dnis="nula dnÌ";
if ( $dni == 1 ) $dnis="jeden deÚ ";
if ( $dni == 2 ) $dnis="dva dni ";
if ( $dni == 3 ) $dnis="tri dni ";
if ( $dni == 4 ) $dnis="ötyri dni ";
if ( $dni == 5 ) $dnis="p‰ù dnÌ ";
if ( $dni == 6 ) $dnis="öesù ";
if ( $dni == 7 ) $dnis="sedem ";
if ( $dni == 8 ) $dnis="osem ";
if ( $dni == 9 ) $dnis="dev‰ù ";
if ( $dni == 10 ) $dnis="desaù ";
if ( $dni == 11 ) $dnis="jeden·sù ";
if ( $dni == 12 ) $dnis="dvan·sù ";
if ( $dni == 13 ) $dnis="trin·sù ";
if ( $dni == 14 ) $dnis="ötrn·sù ";
if ( $dni == 15 ) $dnis="p‰tn·sù ";
if ( $dni == 16 ) $dnis="öestn·sù ";
if ( $dni == 17 ) $dnis="sedemn·sù ";
if ( $dni == 18 ) $dnis="osemn·sù ";
if ( $dni == 19 ) $dnis="dev‰tn·sù ";

$x1119=0;
if ( $dni >= 20 AND $dni <= 99 )
{
$stovky=0;
$desiatky=substr($dni,0,1);
$jednotky=substr($dni,1,1);
}
if ( $dni >= 100 AND $dni <= 400 )
{
$stovky=substr($dni,0,1);
$desiatky=substr($dni,1,1);
$jednotky=substr($dni,2,1);
$od11do19=substr($dni,1,2);
if ( $od11do19 >= 11 AND $od11do19 <= 19 ) $x1119=1;
}

if ( $stovky == 0 ) $dnis=" ";
if ( $stovky == 1 ) $dnis="sto";
if ( $stovky == 2 ) $dnis="dvesto";
if ( $stovky == 3 ) $dnis="tristo";
if ( $stovky == 4 ) $dnis="ötyristo";

if ( $desiatky == 0 ) $dnis=$dnis."";
if ( $desiatky == 1 AND $x1119 == 0 ) $dnis=$dnis."desaù";
if ( $desiatky == 2 ) $dnis=$dnis."dvadsaù";
if ( $desiatky == 3 ) $dnis=$dnis."tridsaù";
if ( $desiatky == 4 ) $dnis=$dnis."ötyridsaù";
if ( $desiatky == 5 ) $dnis=$dnis."p‰ùdesiat";
if ( $desiatky == 6 ) $dnis=$dnis."öesùdesiat";
if ( $desiatky == 7 ) $dnis=$dnis."sedemdesiat";
if ( $desiatky == 8 ) $dnis=$dnis."osemdesiat";
if ( $desiatky == 9 ) $dnis=$dnis."dev‰ùdesiat";

if ( $x1119 == 0 )
{
if ( $jednotky == 0 ) $dnis=$dnis."";
if ( $jednotky == 1 ) $dnis=$dnis."jeden";
if ( $jednotky == 2 ) $dnis=$dnis."dva";
if ( $jednotky == 3 ) $dnis=$dnis."tri";
if ( $jednotky == 4 ) $dnis=$dnis."ötyri";
if ( $jednotky == 5 ) $dnis=$dnis."p‰ù";
if ( $jednotky == 6 ) $dnis=$dnis."öesù";
if ( $jednotky == 7 ) $dnis=$dnis."sedem";
if ( $jednotky == 8 ) $dnis=$dnis."osem";
if ( $jednotky == 9 ) $dnis=$dnis."dev‰ù";
}
if ( $x1119 == 1 )
{
if ( $od11do19 == 11 ) $dnis=$dnis."jeden·sù ";
if ( $od11do19 == 12 ) $dnis=$dnis."dvan·sù ";
if ( $od11do19 == 13 ) $dnis=$dnis."trin·sù ";
if ( $od11do19 == 14 ) $dnis=$dnis."ötrn·sù ";
if ( $od11do19 == 15 ) $dnis=$dnis."p‰tn·sù ";
if ( $od11do19 == 16 ) $dnis=$dnis."öestn·sù ";
if ( $od11do19 == 17 ) $dnis=$dnis."sedemn·sù ";
if ( $od11do19 == 18 ) $dnis=$dnis."osemn·sù ";
if ( $od11do19 == 19 ) $dnis=$dnis."dev‰tn·sù ";
}

if ( $dni > 5 ) $dnis=$dnis." dnÌ ";
$dnis="a ".$dnis;

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET roks='$roks', dnis='$dnis' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");

//nastav obdobie
$obdrok=$kli_vrok-2000;
$obdrom=$kli_vrok-2001;


//nem.davky,nepl.volno,absencia napocitaj do vylod,vyldo,vyldv1 az 4
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid;
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

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.
" SELECT oc,".
" dok,dat,ume,dm,dp,dk,dni,hod,mnz,saz,kc,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE F$kli_vxcf"."_mzdzalvy.oc = $cislo_oc AND F$kli_vxcf"."_mzdzalvy.dp != '0000-00-00' AND ( dm = 801 OR dm = 802 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqldttt = "SELECT * FROM F$kli_vxcf"."_mzdprcvyplnxx$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvyplnxx".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
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


if ( $idt == 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vylod1='$poloz->dp', vyldo1='$poloz->dk', vyldv1='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vylod2='$poloz->dp', vyldo2='$poloz->dk', vyldv2='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 2 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vylod3='$poloz->dp', vyldo3='$poloz->dk', vyldv3='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 3 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vylod4='$poloz->dp', vyldo4='$poloz->dk', vyldv4='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}
if ( $idt == 4 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET vylod5='$poloz->dp', vyldo5='$poloz->dk', vyldv5='$poloz->nzdm' WHERE oc = $cislo_oc "; 
$oznac = mysql_query("$sqtoz");
}

}
$idt = $idt + 1;
  }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplnxx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
//nem.davky,nepl.volno,absencia koniec napocitania 


//uloz do zapoctoveho listu
$sqtoz = "DELETE FROM F$kli_vxcf"."_zapoctovylist WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zapoctovylist".
" SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
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

//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_zapoctovylist".
" SET ".
" vyldni1=TO_DAYS(vyldo1)-TO_DAYS(vylod1)+1, vyldni2=TO_DAYS(vyldo2)-TO_DAYS(vylod2)+1, vyldni3=TO_DAYS(vyldo3)-TO_DAYS(vylod3)+1, ".
" vyldni4=TO_DAYS(vyldo4)-TO_DAYS(vylod4)+1, vyldni5=TO_DAYS(vyldo5)-TO_DAYS(vylod5)+1, ".
" vyl2dni1=TO_DAYS(vyl2do1)-TO_DAYS(vyl2od1)+1, vyl2dni2=TO_DAYS(vyl2do2)-TO_DAYS(vyl2od2)+1, vyl2dni3=TO_DAYS(vyl2do3)-TO_DAYS(vyl2od3)+1, ".
" vyl2dni4=TO_DAYS(vyl2do4)-TO_DAYS(vyl2od4)+1, vyl2dni5=TO_DAYS(vyl2do5)-TO_DAYS(vyl2od5)+1, ".
" vyl3dni1=TO_DAYS(vyl3do1)-TO_DAYS(vyl3od1)+1, vyl3dni2=TO_DAYS(vyl3do2)-TO_DAYS(vyl3od2)+1, vyl3dni3=TO_DAYS(vyl3do3)-TO_DAYS(vyl3od3)+1, ".
" vyl3dni4=TO_DAYS(vyl3do4)-TO_DAYS(vyl3od4)+1, vyl3dni5=TO_DAYS(vyl3do5)-TO_DAYS(vyl3od5)+1 ".
" WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
?>


<?php
//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_zapoctovylist".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_zapoctovylist.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_zapoctovylist.oc = $cislo_oc ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$datum = $fir_riadok->datum;
$datum_sk=SkDatum($datum);
$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;
$dar = SkDatum($fir_riadok->dar);
$uli = $fir_riadok->zuli;
$cdm = $fir_riadok->zcdm;
$psc = $fir_riadok->zpsc;
$mes = $fir_riadok->zmes;
$dan = SkDatum($fir_riadok->dan);
$dav = SkDatum($fir_riadok->dav);
$neschop = $fir_riadok->neschop;
$vylod1 = $fir_riadok->vylod1;
$vyldo1 = $fir_riadok->vyldo1;
$vyldni1 = $fir_riadok->vyldni1;
$vylod2 = $fir_riadok->vylod2;
$vyldo2 = $fir_riadok->vyldo2;
$vyldni2 = $fir_riadok->vyldni2;
$vylod3 = $fir_riadok->vylod3;
$vyldo3 = $fir_riadok->vyldo3;
$vyldni3 = $fir_riadok->vyldni3;
$vylod4 = $fir_riadok->vylod4;
$vyldo4 = $fir_riadok->vyldo4;
$vyldni4 = $fir_riadok->vyldni4;
$vylod5 = $fir_riadok->vylod5;
$vyldo5 = $fir_riadok->vyldo5;
$vyldni5 = $fir_riadok->vyldni5;
$vyl2od1 = $fir_riadok->vyl2od1;
$vyl2do1 = $fir_riadok->vyl2do1;
$vyl2dni1 = $fir_riadok->vyl2dni1;
$rok = $fir_riadok->rok;
$roks = $fir_riadok->roks;
$dni = $fir_riadok->dni;
$dnis = $fir_riadok->dnis;
$dovod = $fir_riadok->dovod;
$str2 = $fir_riadok->str2;
mysql_free_result($fir_vysledok);


$vylod1_sk=SkDatum($vylod1);
$vyldo1_sk=SkDatum($vyldo1);
$vylod2_sk=SkDatum($vylod2);
$vyldo2_sk=SkDatum($vyldo2);
$vylod3_sk=SkDatum($vylod3);
$vyldo3_sk=SkDatum($vyldo3);
$vylod4_sk=SkDatum($vylod4);
$vyldo4_sk=SkDatum($vyldo4);
$vylod5_sk=SkDatum($vylod5);
$vyldo5_sk=SkDatum($vyldo5);

$vyl2od1_sk=SkDatum($vyl2od1);
$vyl2do1_sk=SkDatum($vyl2do1);
$vyl2od2_sk=SkDatum($vyl2od2);
$vyl2do2_sk=SkDatum($vyl2do2);
$vyl2od3_sk=SkDatum($vyl2od3);
$vyl2do3_sk=SkDatum($vyl2do3);
$vyl2od4_sk=SkDatum($vyl2od4);
$vyl2do4_sk=SkDatum($vyl2do4);
$vyl2od5_sk=SkDatum($vyl2od5);
$vyl2do5_sk=SkDatum($vyl2do5);

$vyl3od1_sk=SkDatum($vyl3od1);
$vyl3do1_sk=SkDatum($vyl3do1);
$vyl3od2_sk=SkDatum($vyl3od2);
$vyl3do2_sk=SkDatum($vyl3do2);
$vyl3od3_sk=SkDatum($vyl3od3);
$vyl3do3_sk=SkDatum($vyl3do3);
$vyl3od4_sk=SkDatum($vyl3od4);
$vyl3do4_sk=SkDatum($vyl3do4);
$vyl3od5_sk=SkDatum($vyl3od5);
$vyl3do5_sk=SkDatum($vyl3do5);
     }
//koniec nacitania

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
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Z·poËtov˝ list</title>
<style type="text/css">
div.navbar {
  overflow: auto;
  width: 100%;
  background-color: #add8e6;
}
img.form-background {
  display: block;
  width: 930px;
  height: 1240px;
  margin: 50px 0 0 25px;
}
div.wrap-form-background {
  overflow: hidden;
  width: 950px;
  height: 1300px;
  background-color: #fff;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
</style>

<script type="text/javascript">
<?php
//uprava
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.datum.value = '<?php echo "$datum_sk";?>';
   document.formv1.neschop.value = '<?php echo "$neschop";?>';
   document.formv1.vylod1.value = '<?php echo "$vylod1_sk";?>';
   document.formv1.vyldo1.value = '<?php echo "$vyldo1_sk";?>';
   document.formv1.vylod2.value = '<?php echo "$vylod2_sk";?>';
   document.formv1.vyldo2.value = '<?php echo "$vyldo2_sk";?>';
   document.formv1.vylod3.value = '<?php echo "$vylod3_sk";?>';
   document.formv1.vyldo3.value = '<?php echo "$vyldo3_sk";?>';
   document.formv1.vylod4.value = '<?php echo "$vylod4_sk";?>';
   document.formv1.vyldo4.value = '<?php echo "$vyldo4_sk";?>';
   document.formv1.vylod5.value = '<?php echo "$vylod5_sk";?>';
   document.formv1.vyldo5.value = '<?php echo "$vyldo5_sk";?>';
   document.formv1.vyl2od1.value = '<?php echo "$vyl2od1_sk";?>';
   document.formv1.vyl2do1.value = '<?php echo "$vyl2do1_sk";?>';
   document.formv1.rok.value = '<?php echo "$rok";?>';
   document.formv1.roks.value = '<?php echo "$roks";?>';
   document.formv1.dni.value = '<?php echo "$dni";?>';
   document.formv1.dnis.value = '<?php echo "$dnis";?>';
   document.formv1.dovod.value = '<?php echo "$dovod";?>';
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

  function prevOC()
  {
   window.open('zapoctovy_list2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('zapoctovy_list2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function tlacZapoctovy()
  {
   window.open('zapoctovy_list2014.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>', '_blank');
  }
</script>
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
   <td class="header">Z·poËtov˝ list - <span class="subheader"><?php echo "$oc $meno $prie";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacZapoctovy();"
      title="Zobraziù v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="zapoctovy_list2014.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave" style="top:4px;">

<div class="wrap-form-background">
<img src="../dokumenty/mzdy_potvrdenia/zapoctovy_list_v14.jpg"
 alt="tlaËivo Z·poËtov˝ list pre rok 2014 1.strana 174kB" class="form-background">

<!-- v dna -->
<span class="text-echo" style="top:55px; right:230px;"><?php echo $fir_fmes; ?></span>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);"
 style="width:98px; top:52px; left:768px;"/>
<!-- zamestnavatel -->
<span class="text-echo" style="top:80px; left:44px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:103px; left:44px;"><?php echo "$fir_fuli $fir_fcdm"; ?></span>
<span class="text-echo" style="top:126px; left:44px;"><?php echo $fir_fmes; ?></span>

<!-- zamestnanec -->
<span class="text-echo" style="top:215px; left:117px;"><?php echo "$titl $meno $prie"; ?></span>
<span class="text-echo" style="top:215px; left:752px;"><?php echo $dar; ?></span>
<span class="text-echo" style="top:265px; left:97px;"><?php echo "$uli $cdm, $psc  $mes"; ?></span>
<span class="text-echo" style="top:316px; left:275px;"><?php echo $dan; ?></span>
<span class="text-echo" style="top:316px; left:645px;"><?php echo $dav; ?></span>

<!-- I.cast -->
<input type="text" name="neschop" id="neschop" style="width:344px; top:425px; left:310px;"/>
<input type="text" name="vylod1" id="vylod1" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:558px; left:275px;"/>
<input type="text" name="vyldo1" id="vyldo1" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:558px; left:435px;"/>
<span class="text-echo" style="width:157px; top:562px; left:559px; text-align:center;"><?php echo $vyldni1; ?></span>
<input type="text" name="vylod2" id="vylod2" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:583px; left:275px;"/>
<input type="text" name="vyldo2" id="vyldo2" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:583px; left:435px;"/>
<span class="text-echo" style="width:157px; top:587px; left:559px; text-align:center;"><?php echo $vyldni2; ?></span>
<input type="text" name="vylod3" id="vylod3" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:608px; left:275px;"/>
<input type="text" name="vyldo3" id="vyldo3" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:608px; left:435px;"/>
<span class="text-echo" style="width:157px; top:612px; left:559px; text-align:center;"><?php echo $vyldni3; ?></span>
<input type="text" name="vylod4" id="vylod4" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:275px;"/>
<input type="text" name="vyldo4" id="vyldo4" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:435px;"/>
<span class="text-echo" style="width:157px; top:636px; left:559px; text-align:center;"><?php echo $vyldni4; ?></span>
<input type="text" name="vylod5" id="vylod5" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:275px;"/>
<input type="text" name="vyldo5" id="vyldo5" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:435px;"/>
<span class="text-echo" style="width:157px; top:661px; left:559px; text-align:center;"><?php echo $vyldni5; ?></span>
<input type="text" name="vyl2od1" id="vyl2od1" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>
<input type="text" name="vyl2do1" id="vyl2do1" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:435px;"/>
<span class="text-echo" style="width:157px; top:685px; left:559px; text-align:center;"><?php echo $vyl2dni1; ?></span>
<span class="text-echo" style="top:715px; left:240px; font-size:12px;">œalöie obdobia mÙûete nahraù cez pozn·mku (niûie uveden·).</span>

<!-- II.cast -->
<input type="text" name="rok" id="rok" style="width:92px; top:803px; left:572px;"/>
<input type="text" name="dni" id="dni" style="width:92px; top:803px; left:725px;"/>
<!-- slovami -->
<input type="text" name="roks" id="roks" style="width:150px; top:854px; left:108px;"/>
<input type="text" name="dnis" id="dnis" style="width:337px; top:854px; left:270px;"/>
<!-- dovod -->
<input type="text" name="dovod" id="dovod" style="width:860px; top:902px; left:43px;"/>

<!-- poznamka -->
<label for="str2" style="position:absolute; top:955px; left:43px; font-size:12px; font-weight:bold;">Pozn·mka</label>
<textarea name="str2" id="str2" style="position:absolute; top:970px; left:43px; width:500px; height:180px;"><?php echo $str2; ?></textarea>

</div> <!-- koniec wrap-form-background -->
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC ZAPOCTOVY
if ( $copern == 10 )
{
if ( File_Exists("../tmp/zapoctovy.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/zapoctovy.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_zapoctovylist".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_zapoctovylist.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_zapoctovylist.oc = $cislo_oc ORDER BY konx,prie,meno";

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
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/mzdy_potvrdenia/zapoctovy_list_v14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/zapoctovy_list_v14.jpg',9,15,193,270);
}

//v dna
$pdf->Cell(190,5," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
$pole = explode(".", $datum);
$datum1=$pole[0];
$datum2=$pole[1];
$datum3=$pole[2];
$pole = explode("20", $datum3);
$datum3=$pole[1];
$pdf->Cell(60,5," ","$rmc1",0,"L");
$pdf->Cell(88,5,"$fir_fmes    ","$rmc",0,"R");$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(18,5,"$datum1.$datum2.","$rmc",0,"R");$pdf->Cell(5,4," ","$rmc1",0,"L");
$pdf->Cell(10,5,"$datum3","$rmc",1,"L");

//zamestnavatel
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fuli $fir_fcdm","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fmes","$rmc",1,"L");

//zamestnanec
$dar=SkDatum($hlavicka->dar);
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"L");
$pdf->Cell(124,5,"$hlavicka->titl $hlavicka->meno $hlavicka->prie","$rmc",0,"L");
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(20,5,"$dar","$rmc",1,"L");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","0",0,"L");$pdf->Cell(124,5,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","$rmc",1,"L");
//doba zamestnania
$dan=SkDatum($hlavicka->dan);
$dav=SkDatum($hlavicka->dav);
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(53,4," ","$rmc1",0,"L");$pdf->Cell(70,5,"$dan","$rmc",0,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(60,5,"$dav","$rmc",1,"L");

//I.cast
$pdf->Cell(190,19," ","$rmc1",1,"L");
$pdf->Cell(59,4," ","$rmc1",0,"L");$pdf->Cell(75,6,"$hlavicka->neschop","$rmc",1,"L");
//obdobia vylucene
$vylod1=SkDatum($hlavicka->vylod1); if ( $vylod1 == "00.00.0000" ) $vylod1="";
$vyldo1=SkDatum($hlavicka->vyldo1); if ( $vyldo1 == "00.00.0000" ) $vyldo1="";
$vylod2=SkDatum($hlavicka->vylod2); if ( $vylod2 == "00.00.0000" ) $vylod2="";
$vyldo2=SkDatum($hlavicka->vyldo2); if ( $vyldo2 == "00.00.0000" ) $vyldo2="";
$vylod3=SkDatum($hlavicka->vylod3); if ( $vylod3 == "00.00.0000" ) $vylod3="";
$vyldo3=SkDatum($hlavicka->vyldo3); if ( $vyldo3 == "00.00.0000" ) $vyldo3="";
$vylod4=SkDatum($hlavicka->vylod4); if ( $vylod4 == "00.00.0000" ) $vylod4="";
$vyldo4=SkDatum($hlavicka->vyldo4); if ( $vyldo4 == "00.00.0000" ) $vyldo4="";
$vylod5=SkDatum($hlavicka->vylod5); if ( $vylod5 == "00.00.0000" ) $vylod5="";
$vyldo5=SkDatum($hlavicka->vyldo5); if ( $vyldo5 == "00.00.0000" ) $vyldo5="";
$vyl2od1=SkDatum($hlavicka->vyl2od1); if( $vyl2od1 == "00.00.0000" ) $vyl2od1="";
$vyl2do1=SkDatum($hlavicka->vyl2do1); if( $vyl2do1 == "00.00.0000" ) $vyl2do1="";
$vyldni1=$hlavicka->vyldni1; if ( $vyldni1 == 0 ) $vyldni1="";
$vyldni2=$hlavicka->vyldni2; if ( $vyldni2 == 0 ) $vyldni2="";
$vyldni3=$hlavicka->vyldni3; if ( $vyldni3 == 0 ) $vyldni3="";
$vyldni4=$hlavicka->vyldni4; if ( $vyldni4 == 0 ) $vyldni4="";
$vyldni5=$hlavicka->vyldni5; if ( $vyldni5 == 0 ) $vyldni5="";
$vyl2dni1=$hlavicka->vyl2dni1; if ( $vyl2dni1 == 0 ) $vyl2dni1="";
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod1","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo1","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni1","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod2","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo2","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni2","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod3","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo3","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni3","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,6,"$vylod4","$rmc",0,"C");$pdf->Cell(34,6,"$vyldo4","$rmc",0,"C");
$pdf->Cell(33,6,"$vyldni4","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod5","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo5","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni5","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vyl2od1","$rmc",0,"C");$pdf->Cell(34,5,"$vyl2do1","$rmc",0,"C");
$pdf->Cell(33,5,"$vyl2dni1","$rmc",1,"C");
//zapocitana doba
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pdf->Cell(114,4," ","$rmc1",0,"L");$pdf->Cell(22,4,"$hlavicka->rok","$rmc",0,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,4,"$hlavicka->dni","$rmc",1,"L");
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(140,5,"$hlavicka->roks $hlavicka->dnis","$rmc",1,"L");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(170,4,"$hlavicka->dovod","$rmc",1,"L");

//poznamka


//odtlacok zamestnavatela
$pdf->SetY(285);
$pdf->Cell(130,5,"","$rmc1",0,"R");$pdf->Cell(0,8,"OdtlaËok peËiatky a podpis","T",1,"C");
$pdf->Cell(130,5,"","$rmc1",0,"R");$pdf->Cell(0,3,"zamestn·vateæa","$rmc1",1,"C");


}
$i = $i + 1;
  }
$pdf->Output("../tmp/zapoctovy.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/zapoctovy.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
//koniec vytlac
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