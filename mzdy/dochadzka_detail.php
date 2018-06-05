<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 100;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];
$cislo_oc = $_REQUEST['cislo_oc'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$cit_nas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

//pocet dni v minulom mesiaci
$pocetdnim=31;
$kli_mmes=$kli_vmes-1;
$kli_mume=$kli_mmes.".".$kli_vrok;

if( $kli_vmes == 1 ) { $kli_rume=$kli_vrok-1; if( $kli_rume == 201 ) { $kli_rume="2010"; } $kli_mume="12.".$kli_rume; }

$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_mume ";
$sql = mysql_query("$sqltt");
$pocetdnim = mysql_num_rows($sql);
//echo $pocetdnim;
//echo $kli_mume;

//ktore dni su soboty
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden = 6 ORDER BY dat DESC";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sobota5=$riaddok->dat;
  }

$pole = explode("-", $sobota5);
$sob5=$pole[2];
$sob4=$sob5-7; if( $sob4 < 0 ) $sob4=0;
$sob3=$sob4-7; if( $sob3 < 0 ) $sob3=0;
$sob2=$sob3-7; if( $sob2 < 0 ) $sob2=0;
$sob1=$sob2-7; if( $sob1 < 0 ) $sob1=0;

//ktore dni su nedele
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden = 7 ORDER BY dat DESC";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nedela5=$riaddok->dat;
  }

$pole = explode("-", $nedela5);
$ned5=$pole[2];
$ned4=$ned5-7; if( $ned4 < 0 ) $ned4=0;
$ned3=$ned4-7; if( $ned3 < 0 ) $ned3=0;
$ned2=$ned3-7; if( $ned2 < 0 ) $ned2=0;
$ned1=$ned2-7; if( $ned1 < 0 ) $ned1=0;

//echo $ned5." ".$ned4." ".$ned3." ".$ned2." ".$ned1." ";

$aktcas = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  


//udaje o zamestnancovi
$sqlttz = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc  ";
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $prie=$riadok->prie;
  $meno=$riadok->meno;
  $pom=$riadok->pom;
  $uva=1*$riadok->uva;
  }

$nepret=1;
$uvatyp=8;
if( $uva >= 10 ) { $uvatyp=12; }


//uloz nastavenie priplatkov
if( $copern == 1069 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$dm_nad = 1*$_REQUEST['dm_nad'];
$dm_so = 1*$_REQUEST['dm_so'];
$dm_ne = 1*$_REQUEST['dm_ne'];
$dm_sv = 1*$_REQUEST['dm_sv'];
$dm_nc = 1*$_REQUEST['dm_nc'];

$den12_od=trim($_REQUEST['den12_od']);
$noc12_od=trim($_REQUEST['noc12_od']);
$rano8_od=trim($_REQUEST['rano8_od']);
$poob8_od=trim($_REQUEST['poob8_od']);
$nocn8_od=trim($_REQUEST['nocn8_od']);

$den12_od=str_replace(".", ":", $den12_od);
$noc12_od=str_replace(".", ":", $noc12_od);
$rano8_od=str_replace(".", ":", $rano8_od);
$poob8_od=str_replace(".", ":", $poob8_od);
$nocn8_od=str_replace(".", ":", $nocn8_od);

$rz24=1*trim($_REQUEST['rz24']);

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzkasetpripl ";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzkasetpripl ( dm_nad, dm_so, dm_ne, dm_sv, dm_nc, den12_od, noc12_od, rano8_od, poob8_od, nocn8_od, rz24 )".
" VALUES ( '$dm_nad', '$dm_so', '$dm_ne', '$dm_sv', '$dm_nc', '$den12_od', '$noc12_od', '$rano8_od', '$poob8_od', '$nocn8_od', '$rz24'  );"; 
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec uloz nastavenie

$sql = "SELECT den12_od FROM F".$kli_vxcf."_mzddochadzkasetpripl ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_mzddochadzkasetpripl ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   dm_nad           DECIMAL(5,0) DEFAULT 201,
   dm_so            DECIMAL(5,0) DEFAULT 202,
   dm_ne            DECIMAL(5,0) DEFAULT 203,
   dm_sv            DECIMAL(5,0) DEFAULT 204,
   dm_nc            DECIMAL(5,0) DEFAULT 223
);
uctcrv;

$vsql = "CREATE TABLE F".$kli_vxcf."_mzddochadzkasetpripl".$sqlt;
$vytvor = mysql_query("$vsql");

}

$sql = "SELECT den12_od FROM F".$kli_vxcf."_mzddochadzkasetpripl ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD nocn8_od VARCHAR(10) DEFAULT '22:00' AFTER dm_nc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD poob8_od VARCHAR(10) DEFAULT '14:00' AFTER dm_nc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD rano8_od VARCHAR(10) DEFAULT '06:00' AFTER dm_nc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD noc12_od VARCHAR(10) DEFAULT '18:00' AFTER dm_nc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD den12_od VARCHAR(10) DEFAULT '06:00' AFTER dm_nc";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT rz24 FROM F".$kli_vxcf."_mzddochadzkasetpripl ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkasetpripl ADD rz24 DECIMAL(2,0) DEFAULT 0 AFTER dm_nc";
$vysledek = mysql_query("$sql");
               }

$dm_nad=201; $dm_so=202; $dm_ne=203; $dm_sv=204; $dm_nc=223; $rz24=0; 
$den12_od="06:00"; $noc12_od="18:00"; $rano8_od="06:00"; $poob8_od="14:00"; $nocn8_od="22:00";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddochadzkasetpripl ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dm_nad=1*$riaddok->dm_nad;
  $dm_so=1*$riaddok->dm_so;
  $dm_ne=1*$riaddok->dm_ne;
  $dm_sv=1*$riaddok->dm_sv;
  $dm_nc=1*$riaddok->dm_nc;
  $den12_od=$riaddok->den12_od;
  $noc12_od=$riaddok->noc12_od;

  $rano8_od=$riaddok->rano8_od;
  $poob8_od=$riaddok->poob8_od;
  $nocn8_od=$riaddok->nocn8_od;

  $rz24=1*$riaddok->rz24;
  }


$pra=$rano8_od; $ppo=$poob8_od; $pno=$nocn8_od;
if( $uvatyp == 12 ) { $pra=$den12_od; $ppo=$noc12_od; $pno=$noc12_od; }

//uloz nastavenie mailov
if( $copern == 1059 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_mail = $_REQUEST['h_mail'];
$h_dovv = $_REQUEST['h_dovv'];
$h_mdov = $_REQUEST['h_mdov'];
$csv = 1*$_REQUEST['csv'];
$ndc = 1*$_REQUEST['ndc'];

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzkaset WHERE ocx = $cislo_oc  ";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzkaset ( ocx,mail,mdov,dovv,csv,ndc )".
" VALUES ( '$cislo_oc', '$h_mail', '$h_mdov', '$h_dovv', '$csv', '$ndc'  );"; 
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec uloz nastavenie


$csv=0; $ndc=0; $mail=""; $mdov=""; $dovv="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddochadzkaset WHERE ocx = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $csv=1*$riaddok->csv;
  $ndc=1*$riaddok->ndc;
  $mail=$riaddok->mail;
  $mdov=$riaddok->mdov;
  $dovv=$riaddok->dovv;
  }

//generuj
if( $copern == 1079 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$den1 = 1*$_REQUEST['den1'];
$uvatypx = 1*$_REQUEST['uvatypx'];
$generx = 1*$_REQUEST['generx'];
?>
<script type="text/javascript">
if( !confirm ("Chcete generovaù doch·dzku zamestnanca <?php echo $cislo_oc; ?> ?") )
         {   var okno = window.open("../mzdy/dochadzka_detail.php?&copern=20&cislo_oc=<?php echo $cislo_oc; ?>","_self");  }
else
  var okno = window.open("../mzdy/dochadzka_detail.php?&copern=1179&cislo_oc=<?php echo $cislo_oc; ?>&den1=<?php echo $den1; ?>&uvatypx=<?php echo $uvatypx; ?>&generx=<?php echo $generx; ?>","_self");
</script>
<?php
exit;
}
if( $copern == 1179 )
{
$den1 = 1*$_REQUEST['den1'];
$uvatypx = 1*$_REQUEST['uvatypx'];
$generx = 1*$_REQUEST['generx'];

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxa = 1 ";
$ulozene = mysql_query("$sqty");

if( $uvatypx == 8 AND $generx == 801 ) { $cas=$rano8_od; $kolkyden=1; }
if( $uvatypx == 8 AND $generx == 802 ) { $cas=$poob8_od; $kolkyden=1; }
if( $uvatypx == 8 AND $generx == 803 ) { $cas=$nocn8_od; $kolkyden=1; }
if( $uvatypx == 8 AND $generx == 804 ) { $cas=0; $kolkyden=1; }
if( $uvatypx == 8 AND $generx == 811 ) { $cas=$rano8_od; $kolkyden=2; }
if( $uvatypx == 8 AND $generx == 812 ) { $cas=$poob8_od; $kolkyden=2; }
if( $uvatypx == 8 AND $generx == 813 ) { $cas=$nocn8_od; $kolkyden=2; }
if( $uvatypx == 8 AND $generx == 814 ) { $cas=0; $kolkyden=2; }

if( $uvatypx == 12 AND $generx == 1201 ) { $cas=$den12_od; $kolkyden=1; }
if( $uvatypx == 12 AND $generx == 1202 ) { $cas=$noc12_od; $kolkyden=1; }
if( $uvatypx == 12 AND $generx == 1203 ) { $cas=0; $kolkyden=1; }
if( $uvatypx == 12 AND $generx == 1204 ) { $cas=0; $kolkyden=2; }

$i=$den1;
  while ($i <= $pocetdni )
  {

$h_dod_sql=$kli_vrok."-".$kli_vmes."-".$i;
$h_datn=$h_dod_sql." ".$cas;

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '1', '0', '$h_dod_sql', '$h_dod_sql', '0', '0', '0', '$uva', '', '$h_datn' );"; 
//echo $sqty."<br />";
if( $cas != 0 ) { $ulozene = mysql_query("$sqty"); }

$kolkyden=$kolkyden+1;
if( $uvatypx == 8 AND $kolkyden == 3 AND $cas == $rano8_od ) { $cas=$poob8_od; $kolkyden=1; }
if( $uvatypx == 8 AND $kolkyden == 3 AND $cas == $poob8_od ) { $cas=$nocn8_od; $kolkyden=1; }
if( $uvatypx == 8 AND $kolkyden == 3 AND $cas == $nocn8_od ) { $cas=0; $kolkyden=1; }
if( $uvatypx == 8 AND $kolkyden == 3 AND $cas == 0 ) { $cas=$rano8_od; $kolkyden=1; }

if( $uvatypx == 12 AND $kolkyden == 2 AND $cas == $den12_od ) { $cas=$noc12_od; $kolkyden=1; }
if( $uvatypx == 12 AND $kolkyden == 2 AND $cas == $noc12_od ) { $cas=0; $kolkyden=1; }
if( $uvatypx == 12 AND $kolkyden == 2 AND $cas == 0 ) { $cas=0; $kolkyden=2; }
if( $uvatypx == 12 AND $kolkyden == 3 AND $cas == 0 ) { $cas=$den12_od; $kolkyden=1; }


  $i=$i+1;
  }



$copern=20;
}
//koniec generuj

//daj nepritomnost
if( $copern == 1021 OR $copern == 1022 OR $copern == 1023 OR $copern == 1024 OR $copern == 1026 OR $copern == 1027 OR $copern == 1028 OR $copern == 1029 OR $copern == 1031 )
{
if( $copern == 1021 ) { $h_dmxa=506; }
if( $copern == 1022 ) { $h_dmxa=801; }
if( $copern == 1023 ) { $h_dmxa=802; }
if( $copern == 1029 ) { $h_dmxa=809; }
if( $copern == 1024 ) { $h_dmxa=518; }
if( $copern == 1026 ) { $h_dmxa=503; }
if( $copern == 1027 ) { $h_dmxa=502; }
if( $copern == 1028 ) { $h_dmxa=520; }
if( $copern == 1031 ) { $h_dmxa=510; }

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
$h_hdo = 1*$_REQUEST['h_hdo'];
if( $h_hdo < 0 ) $h_hdo=8;
if( $h_hdo > 15 ) $h_hdo=8;

//echo $cislo_oc;

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND dmxa = $h_dmxa AND daod = '$h_dod_sql' ";
//echo $sqty;
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt )".
" VALUES ( '$kli_vume', '$cislo_oc', '$h_dmxa', '0', '$h_dod_sql', '$h_ddo_sql', '0', '0', '0', '$h_hdo', '' );"; 
$ulozene = mysql_query("$sqty");

//kolko dni su soboty a nedele od h_dod do h_ddo pri nahradach nemoc nie tam idu vsetky dni
$sobned=0;
if( $copern == 1021 OR $copern == 1024 OR $copern == 1026 OR $copern == 1027 OR $copern == 1028 OR $copern == 1031 )
{
$sqlttt = "SELECT * FROM kalendar WHERE ( akyden = 6 OR akyden = 7 ) AND dat >= '$h_dod_sql' AND dat <= '$h_ddo_sql' ";
$sqldok = mysql_query("$sqlttt");
$sobned = 1*mysql_num_rows($sqldok);

}
//koniec kolko dni su soboty a nedele od h_dod do h_ddo


$sqty = "UPDATE F$kli_vxcf"."_mzddochadzka SET dnixa=TO_DAYS(dado)-TO_DAYS(daod)+1-$sobned WHERE oc = $cislo_oc AND dmxa = $h_dmxa AND daod = '$h_dod_sql' ";
//echo $sqty;
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec daj nepritomnost

//vycisti
if( $copern == 1025 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
//echo $cislo_oc;

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

$sqltt = "DROP TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_mzddochadzka$kli_uzid SET polprc=UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(datm) ";
$sql = mysql_query("$sqltt");
$akostara=190;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka$kli_uzid WHERE oc = $cislo_oc AND daod = '$h_dod_sql' AND dmxa > 2 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akostara=1*$riaddok->polprc;
  }


if( $akostara > 180 AND $kli_uzall < 100000 AND $kli_xuzmzd < 50000 ) { echo "NemÙûete mazaù poloûku staröiu ako 3 min˙ty. Obr·ùte sa na administr·tora. "; exit; }

$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND daod = '$h_dod_sql' AND dmxa > 2 ";
//echo $sqty;
$ulozene = mysql_query("$sqty");


$copern=20;
}
//koniec vycisti

$bolprichod=0;
$bolodchod=0;
//prichod,odchod
if( $copern == 1051 OR $copern == 1052 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
$h_hdo = 1*$_REQUEST['h_hdo'];
$zmena = 1*$_REQUEST['zmena'];
$h_zac = $_REQUEST['h_zac'];
$h_zac=str_replace(".", ":", $h_zac);

$ipadx=$_SERVER["REMOTE_ADDR"];

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));  
$dnessql=SqlDatum($dnes);

$dnestim = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);

//if( $h_dod_sql != $dnessql ) { echo "Vyberte spr·vny d·tum - Dnes je ".$dnes." a nie ".$h_dod; exit; }

if( $copern == 1051 ) { $h_dmxa=1; $bolprichod=1; $prichodch="PrÌchod osË.".$cislo_oc." ".$dnestim; }
if( $copern == 1052 ) { $h_dmxa=2; $bolodchod=1; $prichodch="Odchod osË.".$cislo_oc." ".$dnestim; }


if( $uvatyp ==  8 AND $zmena == 1 ) { $h_datn=$h_ddo_sql." ".$rano8_od; }
if( $uvatyp ==  8 AND $zmena == 2 ) { $h_datn=$h_ddo_sql." ".$poob8_od; }
if( $uvatyp ==  8 AND $zmena == 3 ) { $h_datn=$h_ddo_sql." ".$nocn8_od; }

if( $uvatyp == 12 AND $zmena == 1 ) { $h_datn=$h_ddo_sql." ".$den12_od; }
if( $uvatyp == 12 AND $zmena == 3 ) { $h_datn=$h_ddo_sql." ".$noc12_od; }
$h_datn=$h_ddo_sql." ".$h_zac;

$sqty = "INSERT INTO F$kli_vxcf"."_mzddochadzka ( ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datn )".
" VALUES ( '$kli_vume', '$cislo_oc', '$h_dmxa', '0', '$h_dod_sql', '$h_ddo_sql', '0', '0', '0', '$h_hdo', '$ipadx', '$h_datn' );"; 

//echo $sqty;
$ulozene = mysql_query("$sqty");

$copern=20;
}
//koniec prichod,odchod

//vymaz zaznamy
if( $copern == 116 )
{

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$daodzmaz = trim($_REQUEST['daodzmaz']);
$daodzmazsk=Skdatum($daodzmaz);
$textdat="dÚa ".$daodzmazsk." ";
if( $daodzmaz == "" ) { $textdat="v obdobÌ ".$kli_vume;}
?>

<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky z·znamy zamestnanca <?php echo $cislo_oc; ?> <?php echo $textdat; ?> ?") )
         {   var okno = window.open("../mzdy/dochadzka_detail.php?&copern=20&cislo_oc=<?php echo $cislo_oc; ?>","_self");  }
else
  var okno = window.open("../mzdy/dochadzka_detail.php?&copern=1116&cislo_oc=<?php echo $cislo_oc; ?>&daodzmaz=<?php echo $daodzmaz; ?>","_self");
</script>

<?php
exit;
}

if( $copern == 1116 )
{
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$daodzmaz = $_REQUEST['daodzmaz'];

if( $daodzmaz == "" ) { 
$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND ume = $kli_vume ";
$ulozene = mysql_query("$sqty");
                      }

if( $daodzmaz != "" ) { 
$sqty = "DELETE FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND ume = $kli_vume AND daod = '$daodzmaz' ";
$ulozene = mysql_query("$sqty");
                      }

$copern=20;
}
//koniec vycisti


if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Doch·dzkov˝ systÈm</title>
  <style type="text/css">
td.hvstup_zelene  { background-color:lightgreen; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bzelene  { background-color:lightgreen; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_modre  { background-color:lightblue; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

td.hvstup_sede { background-color:gray; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_hnede { background-color:brown; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_cervene { background-color:red; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_orange { background-color:orange; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_pink { background-color:pink; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_magenta { background-color:magenta; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


//dochadzka
function GenDoch()
                {

window.open('../mzdy/dochadzka_gen.php?copern=1&drupoh=3&page=1', '_self' );
                }

function TlacMesDoch()
                {

window.open('../mzdy/dochadzkames_pdf.php?cislo_oc=0&copern=1&drupoh=10&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDoch()
                {

window.open('../mzdy/dochadzka_pdf.php?cislo_oc=0&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDochNep()
                {

window.open('../mzdy/dochadzka_pdf.php?cislo_oc=0&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravDoch()
                {

window.open('../mzdy/dochadzka_detail.php?cislo_oc=0&copern=20&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdosliDoch()
                {

window.open('../mzdy/dochadzka_export.php?cislo_oc=0&copern=26&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function TlacDochOC( h_oc )
                {

window.open('../mzdy/dochadzka_detailpdf.php?cislo_oc=' + h_oc + '&copern=30&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravDochOC( h_oc )
                {

window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdosliDochOC( h_oc )
                {

window.open('../mzdy/dochadzka_export.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0&zdetailu=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazDochDat(daodzmaz)
                {

window.open('../mzdy/dochadzka_detail.php?cislo_oc=<?php echo $cislo_oc; ?>&daodzmaz=' + daodzmaz + '&copern=116&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazDoch()
                {

window.open('../mzdy/dochadzka_detail.php?cislo_oc=<?php echo $cislo_oc; ?>&daodzmaz=&copern=116&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  function DochadzkaEdi(h_oc)
  { 

  window.open('../mzdy/dochadzka_edi.php?cislo_oc=' + h_oc + '&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=600, height=800, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
    
  function Prionload()
  { 
<?php if( $bolprichod == 1 OR $bolodchod == 1 ) { ?> 
  prichodch.style.display='';
<?php                                           } ?> 
  }

</script>

</HEAD>
<BODY class="white" onload="Prionload();"  >

<?php
//echo $copern;
if ( $copern == 1 OR $copern == 20 )
     {
?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:140;">
<table  class='ponuka' width='100%'><tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr><td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="document.forms.fhiden.ocold.value=0; nastavfakx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm 

 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_dovolenka();" title='Dovolenkov˝ lÌstok' >
 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_lekar();" title='Priepustka lek·rovi, ˙rad...' >
 <img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick="tlac_volno();" title='éiadosù o pracovnÈ voæno' >
</td>

<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="document.forms.fhiden.ocold.value=0; nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  

<tr><FORM name='fkoef' method='post' action='#' >
<td colspan='8' align="left">Zamestnanec osË <input type='text' readonly name='h_oscx' id='h_oscx' size='10' maxlenght='10' value="" readonly="readonly" >
<input type='text' readonly name='h_priex' id='h_priex size='20' maxlenght='20' value="" >
<td colspan='2' align='right'></td></tr>  


<tr><td class='ponuka' colspan='10'>D·tum od 
<input type='text' readonly name='h_dod' id='h_dod' size='10' maxlenght='10' value="" > D·tum do 
<input type='text' readonly name='h_ddo' id='h_ddo' size='10' maxlenght='10' value="" > 
Hodiny  <img src='../obr/info.png' width=12 height=12 border=0 title='Hodiny'> 

<input type='text' name='h_hdo' id='h_hdo' size='10' maxlenght='10' value="" > 
</td></tr>

<tr style="height: 60px">

<td colspan='1' class='ponuka' align='center' ><span onClick="PrichodRano();"> PrÌchod r·no</span>
<input type='text' name='h_pra' id='h_pra' size='5' maxlenght='5' value="<?php echo $pra;?>" >
</td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' ><span onClick="PrichodPoobede();"> PrÌchod odpoludnia</span>
<input type='text' name='h_ppo' id='h_ppo' size='5' maxlenght='5' value="<?php echo $ppo;?>" >
</td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' ><span onClick="PrichodNoc();"> PrÌchod noc</span>
<input type='text' name='h_pno' id='h_pno' size='5' maxlenght='5' value="<?php echo $pno;?>" >
</td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' onClick="DajSviatok();"> Sviatok S </td>

<td colspan='1' align='center'>  </td>

<td colspan='1' class='ponuka' align='center' onClick="DajDovolenku();"> Dovolenka D </td>

</tr>


<tr style="height: 60px">


<td colspan='1' align='center' onClick="DajLekar();"> N·vöteva lek·ra L</td>

<td colspan='1' class='ponuka' align='center' onClick="DajOsetr();"> OöetrovnÈ O</td>

<td colspan='1' align='center' onClick="DajNemoc();"> Nemoc N</td>

<td colspan='1' class='ponuka' align='center' onClick="DajAbsenciu();"> Absencia A</td>

<td colspan='1' align='center' onClick="DajNeplatene();"> NeplatenÈ voæno V</td>

<td colspan='1' class='ponuka' align='center' onClick="DajIne();"> InÈ I</td>

<td colspan='1' align='center' onClick="DajMatersku();"> Matersk· M</td>

</tr>

</FORM></table>
</div>
<script type="text/javascript">


  function zobraz_robotmenu(oc, menoprie, riadok, datod, datdo, uvazok)
                {
  nastavfakx.style.display='';

    var toprobotmenu = 120+riadok*22;
    var leftrobotmenu = 400;
    var widthrobotmenu = 600;

    var h_ocold = document.forms.fhiden.ocold.value;
    var h_oc = oc;
    var zmenaoc = 0;
    if( h_oc != h_ocold ) zmenaoc=1;
    if( zmenaoc == 0 ) { var datodx = document.forms.fhiden.datodold.value; }
    if( zmenaoc == 1 ) { var datodx = datod; }


    document.forms.fkoef.h_oscx.value=h_oc;
    document.forms.fkoef.h_priex.value=menoprie;

    document.forms.fkoef.h_dod.value=datodx;
    document.forms.fkoef.h_ddo.value=datdo;
    document.forms.fkoef.h_hdo.value=uvazok;

    document.forms.fhiden.ocold.value=h_oc;
    document.forms.fhiden.datodold.value=datodx;

  myRobotmenu = document.getElementById("nastavfakx");
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobotmenu.style.width = widthrobotmenu;

                }

  function tlac_dovolenka()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_lekar()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=2&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_volno()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=3&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

  function tlac_ine()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=4&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }


  function DajIne()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1028&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajAbsenciu()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1026&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajNeplatene()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1027&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }


  function DajDovolenku()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1021&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajSviatok()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1031&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajNemoc()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1022&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajOsetr()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1023&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajMatersku()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1029&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function DajLekar()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1024&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Vycisti()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1025&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Prichod()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1051&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function PrichodRano()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;
  var h_zac = document.forms.fkoef.h_pra.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_zac=' + h_zac + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1051&drupoh=1&page=1&subor=0&zmena=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function PrichodPoobede()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;
  var h_zac = document.forms.fkoef.h_ppo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_zac=' + h_zac + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1051&drupoh=1&page=1&subor=0&zmena=2',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function PrichodNoc()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;
  var h_zac = document.forms.fkoef.h_pno.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_zac=' + h_zac + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=1051&drupoh=1&page=1&subor=0&zmena=3',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Odchod()
  { 
  var h_oc = document.forms.fkoef.h_oscx.value;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&copern=1052&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

</script>

<div id="nastavmailx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr><td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavmailx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm - Nastavenie </td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavmailx.style.display='none';" title='Zhasni menu' >
</td></tr>  

<tr><FORM name='fkoef2' method='post' action='#' >
<td colspan='8' align="left">Zamestnanec osË <input type='text' readonly name='h_oscx' id='h_oscx' size='10' maxlenght='10' value="" readonly="readonly" >
<input type='text' readonly name='h_priex' id='h_priex size='20' maxlenght='20' value="" >
<td colspan='2' align='right'></td></tr>  


<tr><td class='ponuka' colspan='2'>Kam mailovaù 
<td class='ponuka' colspan='8'><input type='text' name='h_mail' id='h_mail' size='80' maxlenght='80' value="" > 
</td></tr>

<tr><td class='ponuka' colspan='2'>Miesto pobytu 
<td class='ponuka' colspan='8'><input type='text' name='h_mdov' id='h_mdov' size='80' maxlenght='80' value="" >
</td></tr>
<tr><td class='ponuka' colspan='2'>DÙvod voæna, priepustky 
<td class='ponuka' colspan='8'><input type='text' name='h_dovv' id='h_dovv' size='80' maxlenght='80' value="" > 
</td></tr>

<tr><td class='ponuka' colspan='10'>  | Ëasov· mzda <input type='checkbox' name='csv' value='1' > | nadËasy <input type='checkbox' name='ndc' value='1' > </td></tr>

<tr><td colspan='10'> <img border=0 src="../obr/ok.png" style="width:15; height:15;" onClick="uloz_upravmail();" title='Uloûiù nastavenie' >  


</td></tr>

<tr><td></td></FORM></tr></table> 

</div>
<script type="text/javascript">
  function zobraz_upravmail(oc, menoprie, riadok, mail, dovv, mdov, csv, ndc)
  { 
  nastavmailx.style.display='';

    var toprobotmenu2 = 120+riadok*22;
    var leftrobotmenu2 = 400;
    var widthrobotmenu2 = 600;
    var h_oc = oc;
    var h_menoprie = menoprie;
    var komumail = mail;
    var dovodvolna = dovv;
    var miestodov = mdov;

    if( csv == 1 ) { document.fkoef2.csv.checked = 'checked'; }
    if( ndc == 1 ) { document.fkoef2.ndc.checked = 'checked'; }
    document.forms.fkoef2.h_oscx.value=oc;
    document.forms.fkoef2.h_priex.value=menoprie;
    document.forms.fkoef2.h_mail.value=mail;
    document.forms.fkoef2.h_mdov.value=mdov;
    document.forms.fkoef2.h_dovv.value=dovv;


  myRobotmenu2 = document.getElementById("nastavmailx");
  myRobotmenu2.style.top = toprobotmenu2;
  myRobotmenu2.style.left = leftrobotmenu2;
  myRobotmenu2.style.width = widthrobotmenu2;

  }

  function uloz_upravmail()
  { 

  var h_oc = document.forms.fkoef2.h_oscx.value;
  var h_mail = document.forms.fkoef2.h_mail.value;
  var h_dovv = document.forms.fkoef2.h_dovv.value;
  var h_mdov = document.forms.fkoef2.h_mdov.value;
  var csv = 0;
  if( document.fkoef2.csv.checked ) csv=1;
  var ndc = 0;
  if( document.fkoef2.ndc.checked ) ndc=1;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + h_oc + '&h_mail=' + h_mail + '&h_dovv=' + h_dovv + '&h_mdov=' + h_mdov + '&csv=' + csv + '&ndc=' + ndc + '&copern=1059&drupoh=1&page=1&subor=0', '_self');
  }

</script>


<div id="nastavpriplx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr>
<td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavpriplx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm - Nastavenie prÌplatkov</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavpriplx.style.display='none';" title='Zhasni menu' >
</td></tr>  

<tr>
<FORM name='fkoef3' method='post' action='#' >
<td colspan='10' 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>DM prÌplatok za nadËas
<td class='ponuka' colspan='6'><input type='text' name='dm_nad' id='dm_nad' size='8' maxlenght='4' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>DM prÌplatok za sobotu
<td class='ponuka' colspan='6'><input type='text' name='dm_so' id='dm_so' size='8' maxlenght='4' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>DM prÌplatok za nedelu
<td class='ponuka' colspan='6'><input type='text' name='dm_ne' id='dm_ne' size='8' maxlenght='4' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>DM prÌplatok za sviatok
<td class='ponuka' colspan='6'><input type='text' name='dm_sv' id='dm_sv' size='8' maxlenght='4' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>DM prÌplatok za noc
<td class='ponuka' colspan='6'><input type='text' name='dm_nc' id='dm_nc' size='8' maxlenght='4' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>Rozdelovanie So, Ne, Sv
<td class='ponuka' colspan='6'><input type='checkbox' name='rz24' value='1' > nezaökrtnutÈ=od rannej zmeny do konca noËnej zmeny, zaökrtnutÈ=od r·na 00 hod. do noci 24.00 hod. s rozdelenÌm noËnej zmeny
</td></tr>

<tr>
<td class='ponuka' colspan='4'>ZaËiatok dennej zmeny 12 hod.˙v‰zok
<td class='ponuka' colspan='6'><input type='text' name='den12_od' id='den12_od' size='8' maxlenght='6' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>ZaËiatok noËnej zmeny 12 hod.˙v‰zok
<td class='ponuka' colspan='6'><input type='text' name='noc12_od' id='noc12_od' size='8' maxlenght='6' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>ZaËiatok rannej zmeny 8 hod.˙v‰zok
<td class='ponuka' colspan='6'><input type='text' name='rano8_od' id='rano8_od' size='8' maxlenght='6' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>ZaËiatok poobednej zmeny 8 hod.˙v‰zok
<td class='ponuka' colspan='6'><input type='text' name='poob8_od' id='poob8_od' size='8' maxlenght='6' value="" > 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>ZaËiatok noËnej zmeny 8 hod.˙v‰zok
<td class='ponuka' colspan='6'><input type='text' name='nocn8_od' id='nocn8_od' size='8' maxlenght='6' value="" > 
</td></tr>

<tr><td colspan='10'> <img border=0 src="../obr/ok.png" style="width:15; height:15;" onClick="uloz_upravpripl();" title='Uloûiù nastavenie' >  


</td></tr>

<tr><td></td></FORM></tr></table> 

</div>
<script type="text/javascript">
  function zobraz_upravpripl(dm_nad, dm_so, dm_ne, dm_sv, dm_nc, den12_od, noc12_od, rano8_od, poob8_od, nocn8_od, rz24)
  { 
  nastavpriplx.style.display='';

    var toprobotmenu3 = 120;
    var leftrobotmenu3 = 400;
    var widthrobotmenu3 = 600;

    document.forms.fkoef3.dm_nad.value=dm_nad;
    document.forms.fkoef3.dm_so.value=dm_so;
    document.forms.fkoef3.dm_ne.value=dm_ne;
    document.forms.fkoef3.dm_sv.value=dm_sv;
    document.forms.fkoef3.dm_nc.value=dm_nc;

    document.forms.fkoef3.den12_od.value=den12_od;
    document.forms.fkoef3.noc12_od.value=noc12_od;
    document.forms.fkoef3.rano8_od.value=rano8_od;
    document.forms.fkoef3.poob8_od.value=poob8_od;
    document.forms.fkoef3.nocn8_od.value=nocn8_od;

    if( rz24 == 1 ) { document.fkoef3.rz24.checked = 'checked'; }


  myRobotmenu3 = document.getElementById("nastavpriplx");
  myRobotmenu3.style.top = toprobotmenu3;
  myRobotmenu3.style.left = leftrobotmenu3;
  myRobotmenu3.style.width = widthrobotmenu3;

  }

  function uloz_upravpripl()
  { 

  var dm_nad = document.forms.fkoef3.dm_nad.value;
  var dm_so = document.forms.fkoef3.dm_so.value;
  var dm_ne = document.forms.fkoef3.dm_ne.value;
  var dm_sv = document.forms.fkoef3.dm_sv.value;
  var dm_nc = document.forms.fkoef3.dm_nc.value;

  var den12_od = document.forms.fkoef3.den12_od.value;
  var noc12_od = document.forms.fkoef3.noc12_od.value;
  var rano8_od = document.forms.fkoef3.rano8_od.value;
  var poob8_od = document.forms.fkoef3.poob8_od.value;
  var nocn8_od = document.forms.fkoef3.nocn8_od.value;

  var rz24 = 0;
  if( document.fkoef3.rz24.checked ) rz24=1;

  window.open('../mzdy/dochadzka_detail.php?cislo_oc=<?php echo $cislo_oc;?>&dm_nad=' +dm_nad + '&dm_so=' + dm_so 
+ '&dm_ne=' + dm_ne + '&dm_sv=' + dm_sv + '&dm_nc=' + dm_nc + '&rz24=' + rz24 
+ '&den12_od=' + den12_od + '&noc12_od=' + noc12_od + '&rano8_od=' + rano8_od + '&poob8_od=' + poob8_od + '&nocn8_od=' + nocn8_od
+ '&copern=1069&drupoh=1&page=1&subor=0', '_self');


  }

</script>



<div id="nastavgenerx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 200; width:600; height:100;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td>
<td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td><td width='10%'> </td></tr>  


<tr>
<td colspan='8'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavgenerx.style.display='none';" title='Zhasni menu' >  
Menu EkoRobot - Doch·dzkov˝ systÈm - Generovanie R=rann·, O=odpoludÚajöia, N=noËn·, -=voæno</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="nastavgenerx.style.display='none';" title='Zhasni menu' >
</td></tr>  

<tr>
<FORM name='fkoef4' method='post' action='#' >
<td colspan='10' 
</td></tr>

<tr>
<td class='ponuka' colspan='4'>Generovaù od dÚa
<td class='ponuka' colspan='6'><input type='text' name='den1' id='den1' size='8' maxlenght='4' value="1" > 
</td></tr>

<?php
if ( $uvatyp == 8 )
     {
?>

<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 801);">Generovaù R R O O N N - - </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 802);">Generovaù O O N N - - R R </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 803);">Generovaù N N - - R R O O </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 804);">Generovaù - - R R O O N N </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 811);">Generovaù R O O N N - - R </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 812);">Generovaù O N N - - R R O </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 813);">Generovaù N - - R R O O N </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(8, 814);">Generovaù - R R O O N N - </a></td></tr>
<?php
     }
?>

<?php
if ( $uvatyp == 12 )
     {
?>

<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(12, 1201);">Generovaù R O - - R O - - </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(12, 1202);">Generovaù O - - R O - - R </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(12, 1203);">Generovaù - - R O - - R O </a></td></tr>
<tr><td class='ponuka' colspan='10'  ><a href="#" onClick="uloz_upravgener(12, 1204);">Generovaù - R O - - R O - </a></td></tr>
<?php
     }
?>
<tr><td></td></FORM></tr></table> 

</div>
<script type="text/javascript">
  function zobraz_upravgener()
  { 
  nastavgenerx.style.display='';

    var toprobotmenu4 = 120;
    var leftrobotmenu4 = 400;
    var widthrobotmenu4 = 600;



  myRobotmenu4 = document.getElementById("nastavgenerx");
  myRobotmenu4.style.top = toprobotmenu4;
  myRobotmenu4.style.left = leftrobotmenu4;
  myRobotmenu4.style.width = widthrobotmenu4;

  }

  function uloz_upravgener(uvatypx, generx)
  { 

  var den1 = document.forms.fkoef4.den1.value;


  window.open('../mzdy/dochadzka_detail.php?cislo_oc=<?php echo $cislo_oc;?>&den1=' + den1 + '&uvatypx=' + uvatypx + '&generx=' + generx + '&copern=1079&drupoh=1&page=1&subor=0', '_self');


  }

</script>


<?php
     }
?>



<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Doch·dzkov˝ systÈm zamestnanec <?php echo " osË $cislo_oc $prie $meno ";?>

<img src='../obr/naradie.png'  width=15 height=15 border=1 onClick="zobraz_upravmail(<?php echo $cislo_oc;?>, '<?php echo $prie; ?> <?php echo $meno; ?>', '0', '<?php echo $mail;?>', '<?php echo $dovv;?>', '<?php echo $mdov;?>', '<?php echo $csv;?>', '<?php echo $ndc;?>');" width=15 height=15 border=0 title='Nastaviù mailovÈ ˙daje zamestnanca Ë.<?php echo $cislo_oc;?>' >

<img src='../obr/hodiny.jpg'  width=15 height=15 border=1 onClick="window.open('../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0','_self')" title="Zoznam vöetk˝ch zamestnancov">

</td>
<td align="right">
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

//mzddochadzka ume	oc	dmxa	dmxb	daod	dado	dnixa	dnixb	hodxa	hodxb	xtxt	datm	datn	cplxb	polprc	keyf

$sqltt = "DROP TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzddochadzka".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE ume < 0 ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka".$kli_uzid." ADD svt int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzka".$kli_uzid." ADD akyden int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");


$sqltt = "INSERT INTO F$kli_vxcf"."_mzddochadzka".$kli_uzid." SELECT ".
" ume, '$cislo_oc', 0, 0, dat, dat,  0, 0, 0, 0, '', now(), now(), 0, 0, '', akyden, svt FROM kalendar WHERE ume = $kli_vume ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$sqltt = "DROP TABLE F$kli_vxcf"."_mzddochadzkap".$kli_uzid." ";
$sql = mysql_query("$sqltt");

$sqltt = "CREATE TABLE F$kli_vxcf"."_mzddochadzkap".$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE ume  = $kli_vume AND oc = $cislo_oc ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD svt int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD akyden int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD svt2 int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD akyden2 int(11) DEFAULT 0 AFTER keyf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD daod2 DATE AFTER keyf";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD tomid DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD rozd2 DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD rozd1 DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD pnoc DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD psvt DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD pned DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD psob DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." ADD pndc DECIMAL(10,2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");

//vypocet priplatkov
//andrejko
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid.",kalendar ".
" SET F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".akyden=kalendar.akyden, ".
"     F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".svt=kalendar.svt  ".
" WHERE dmxa = 1 AND F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".daod=kalendar.dat ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET datm=timestamp(daod + 1) WHERE dmxa = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET daod2=datm WHERE dmxa = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid.",kalendar ".
" SET F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".akyden2=kalendar.akyden, ".
"     F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".svt2=kalendar.svt  ".
" WHERE dmxa = 1 AND F".$kli_vxcf."_mzddochadzkap".$kli_uzid.".daod2=kalendar.dat ";
$vysledek = mysql_query("$sql");

//echo $rz24;
if( $rz24 == 0 )
  {

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET akyden2=akyden, svt2=svt  WHERE dmxa = 1 ";
$vysledek = mysql_query("$sql");

  }

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET ".
" tomid=time_to_sec(timediff(datm, datn )) / 3600 WHERE dmxa = 1 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET rozd1=hodxb WHERE dmxa = 1 AND hodxb <= tomid ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET rozd1=tomid, rozd2=hodxb-tomid WHERE dmxa = 1 AND hodxb > tomid ";
$vysledek = mysql_query("$sql");


$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psob=rozd1 WHERE dmxa = 1 AND akyden = 6 AND svt = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pned=rozd1 WHERE dmxa = 1 AND akyden = 7 AND svt = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psvt=rozd1 WHERE dmxa = 1 AND svt = 1 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pnoc=rozd2+2 WHERE dmxa = 1 AND rozd2 > 0 AND rozd2 <= 6 AND rozd1 >= 2 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pnoc=rozd2+rozd1 WHERE dmxa = 1 AND rozd2 > 0 AND rozd2 <= 6 AND rozd1 < 2 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pnoc=6+2 WHERE dmxa = 1 AND rozd2 > 0 AND rozd2 > 6 AND rozd1 >= 2 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pnoc=6+rozd1 WHERE dmxa = 1 AND rozd2 > 0 AND rozd2 > 6 AND rozd1 < 2 ";
$vysledek = mysql_query("$sql");

if( $rz24 == 1 )
  {
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psob=rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND akyden2 = 6 AND svt2 = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pned=rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND akyden2 = 7 AND svt2 = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psvt=rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND svt2 = 1 ";
$vysledek = mysql_query("$sql");
  }

if( $rz24 == 0 )
  {
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psob=psob+rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND akyden2 = 6 AND svt2 = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET pned=pned+rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND akyden2 = 7 AND svt2 = 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_mzddochadzkap".$kli_uzid." SET psvt=psvt+rozd2 WHERE rozd2 > 0 AND dmxa = 1 AND svt2 = 1 ";
$vysledek = mysql_query("$sql");
  }

//koniec vypocet priplatkov

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddochadzka$kli_uzid ".
" WHERE oc = $cislo_oc AND ume = $kli_vume ORDER BY oc,daod ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = 1*mysql_num_rows($sql);
//echo $pol;

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {

?>
<div id="myRdpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>

<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<div id="robotmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<table class="vstup" width="100%" >
<tr>

<td class="bmenu" colspan="1">
Obdobie: <?php echo $kli_vume;?>
<a href="#" onClick="TlacDochOC(<?php echo $cislo_oc;?>);">
<img src='../obr/tlac.png' width=15 height=15 border=1 title='VytlaËiù doch·dzku zamestnanca Ë.<?php echo $cislo_oc;?> vo form·te PDF' ></a>
</td>

<td class="bmenu" colspan="1">
</td>

<td class="bmenu" colspan="5">
⁄v‰zok <?php echo $uva;?> hod. na deÚ. 
<?php if( $uvatyp == 8 )  { ?>
Nepretrûit· prev·dzka typ <?php echo $uvatyp;?> r·no <?php echo $rano8_od;?> - odpoludnia <?php echo $poob8_od;?> - noc <?php echo $nocn8_od;?> 
<?php                     } ?>
<?php if( $uvatyp == 12)  { ?>
Nepretrûit· prev·dzka typ <?php echo $uvatyp;?> deÚ <?php echo $den12_od;?> - noc <?php echo $noc12_od;?>
<?php                     } ?>

<img src='../obr/naradie.png'  width=15 height=15 border=1 onClick="zobraz_upravpripl('<?php echo $dm_nad;?>', '<?php echo $dm_so;?>'
, '<?php echo $dm_ne;?>', '<?php echo $dm_sv;?>', '<?php echo $dm_nc;?>', '<?php echo $den12_od;?>', '<?php echo $noc12_od;?>'
, '<?php echo $rano8_od;?>', '<?php echo $poob8_od;?>', '<?php echo $nocn8_od;?>', '<?php echo $rz24;?>' );" width=15 height=15 border=0 title='Nastaviù druhy prÌplatkov' >

</td>

<td class="bmenu" colspan="1" align="right">
<a href="#" onClick="ZmazDoch();">
<img src='../obr/zmazuplne.png' width=20 height=15 border=0 title='Zmazaù z·znamy zamestnanca Ë.<?php echo $cislo_oc;?> v obdobÌ <?php echo $kli_vume;?>' ></a>
</td>

</tr>

<tr>
<td class="bmenu" width="10%">d·tum 
<a href="#" onClick="OdosliDochOC(<?php echo $cislo_oc;?>);">
<img src='../obr/orig.png' width=15 height=15 border=1 title='NaËÌtaù hodnoty do mesaËn˝ch miezd zamestnanca Ë.<?php echo $cislo_oc;?> - mÙûete opakovaù viackr·t' ></a>

</td>
<td class="bmenu" width="20%">odpracovanÈ hod.
<img src='../obr/vlozit.png'  width=15 height=15 border=1 onClick="zobraz_upravgener();" width=15 height=15 border=0 title='Generovaù doch·dzku pre zamestnanca Ë.<?php echo $cislo_oc;?>' >

</td>
<td class="bmenu" width="40%">NeprÌtomnosti</td>
<td class="bmenu" width="6%" align="right">Nad <?php echo $dm_nad;?></td>
<td class="bmenu" width="6%" align="right">So <?php echo $dm_so;?></td>
<td class="bmenu" width="6%" align="right">Ne <?php echo $dm_ne;?></td>
<td class="bmenu" width="6%" align="right">Sv <?php echo $dm_sv;?></td>
<td class="bmenu" width="6%" align="right">Noc <?php echo $dm_nc;?></td>
</tr>

<?php
      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->daod, 3);
  $rok=$rok-2000;
  $daodsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

  list ($datum, $cas) = split ('[ ]', $polozka->daod, 2);

$hvstup="hvstup";

$farbaden="hmenu";
$textden="Po";
if( $polozka->akyden == 1 ) { $farbaden="bmenu"; $textden="Po"; } 
if( $polozka->akyden == 2 ) { $farbaden="bmenu"; $textden="⁄t"; } 
if( $polozka->akyden == 3 ) { $farbaden="bmenu"; $textden="St"; } 
if( $polozka->akyden == 4 ) { $farbaden="bmenu"; $textden="ät"; } 
if( $polozka->akyden == 5 ) { $farbaden="bmenu"; $textden="Pi"; } 


if( $polozka->akyden == 6 ) { $farbaden="hvstup_bzelene"; $textden="So"; } 
if( $polozka->akyden == 7 ) { $farbaden="hvstup_bred"; $textden="Ne"; }   
if( $polozka->svt == 1 ) { $farbaden="hvstup_bred"; $textden="Sv ".$textden; } 


?>



<tr>

<?php 
$riadok=$i + 1;
$kli_den=$riadok.".".$kli_vume; 
$kli_den_sql=$kli_vrok."-".$kli_vmes."-".$riadok; 
?>

<td class="<?php echo $farbaden; ?>" align="right">
<?php echo $textden." ".$daodsk; ?>
</td>

<td class="<?php echo $hvstup; ?>" align="right">

<?php
$polozkax->psob=0; $polozkax->pned=0; $polozkax->psvt=0; $polozkax->pnoc=0; 

$sqlttx = "SELECT * FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND ume = $kli_vume AND daod = '$kli_den_sql' AND dmxa = 1 ORDER BY oc,daod ";
//echo $sqlttx;
$sqlx = mysql_query("$sqlttx");
$polx = 1*mysql_num_rows($sqlx);
if( $polx > 0 )
          {
$ix=0;
  while ($ix <= $polx )
  {
  if (@$zaznamx=mysql_data_seek($sqlx,$ix))
{
$polozkax=mysql_fetch_object($sqlx);



  list ($datum, $cas) = split ('[ ]', $polozkax->datn, 2);
  list ($cashod, $casmin, $cassek) = split ('[:]', $cas, 3);
  $cashodmin = sprintf("%02d:%02d", $cashod, $casmin);

?>

zaË. <?php echo $cashodmin;?> - <?php echo $polozkax->hodxb;?> hod.

<?php
}
$ix = $ix + 1;
  }

//if( $polx > 0 )
          }
?>

<img src='../obr/vlozit.png' width=15 height=15 onClick="zobraz_robotmenu(<?php echo $polozka->oc;?>, '<?php echo $prie; ?> <?php echo $meno; ?>',
 <?php echo $riadok;?>, '<?php echo $kli_den;?>', '<?php echo $kli_den;?>', '<?php echo $uva;?>');" border=1 title='Voûiù pracovn˙ zmenu pre zamestnanca Ë.<?php echo $polozka->oc;?> ' >

</td>

<td class="<?php echo $hvstup; ?>">
&nbsp&nbsp&nbsp
<a href="#" onClick="ZmazDochDat('<?php echo $polozka->daod;?>');">
<img src='../obr/zmazuplne.png' width=20 height=15 border=0 title='Zmazaù z·znamy dÚa <?php echo $daodsk;?> zamestnanca <?php echo $cislo_oc;?>' ></a>

<?php
$sqlttx2 = "SELECT * FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND ume = $kli_vume AND daod = '$kli_den_sql' AND dmxa >= 500 ORDER BY oc,daod,dmxa ";
//echo $sqlttx2;
$sqlx2 = mysql_query("$sqlttx2");
$polx2 = 1*mysql_num_rows($sqlx2);
if( $polx2 > 0 )
          {
$ix2=0;
  while ($ix2 <= $polx2 )
  {
  if (@$zaznamx=mysql_data_seek($sqlx2,$ix2))
{
$polozkax2=mysql_fetch_object($sqlx2);



  list ($datum, $cas) = split ('[ ]', $polozkax2->datn, 2);
  list ($cashod, $casmin, $cassek) = split ('[:]', $cas, 3);
  $cashodmin = sprintf("%02d:%02d", $cashod, $casmin);

?>

&nbsp&nbsp&nbsp DM <?php echo $polozkax2->dmxa;?> - <?php echo $polozkax2->hodxb;?> hod.

<?php
}
$ix2 = $ix2 + 1;
  }
//if( $polx2 > 0 )
          }
?>


</td>

<td class="<?php echo $hvstup; ?>" align="right">
</td>

<td class="<?php echo $hvstup; ?>" align="right">
<?php
$psob=$polozkax->psob;
if( $psob == 0 ) { $psob=""; }
?>
<?php echo $psob;?> 
</td>

<td class="<?php echo $hvstup; ?>" align="right">
<?php
$pned=$polozkax->pned;
if( $pned == 0 ) { $pned=""; }
?>
<?php echo $pned;?> 
</td>

<td class="<?php echo $hvstup; ?>" align="right">
<?php
$psvt=$polozkax->psvt;
if( $psvt == 0 ) { $psvt=""; }
?>
<?php echo $psvt;?> 
</td>

<td class="<?php echo $hvstup; ?>" align="right">
<?php
$pnoc=$polozkax->pnoc;
if( $pnoc == 0 ) { $pnoc=""; }
?>
<?php echo $pnoc;?> 
</td>

</tr>



<?php
}


$i = $i + 1;
$j = $j + 1;
  }

//koniec poloziek

?>



<?php
$sumhod=0; $sumpndc=0; $sumpsob=0; $sumpned=0; $sumpsvt=0; $sumpnoc=0;
$sqlttz = "SELECT oc, dmxa, SUM(hodxb) AS sumhodxb, SUM(pndc) AS sumpndc, SUM(psob) AS sumpsob, SUM(pned) AS sumpned, SUM(psvt) AS sumpsvt, ".
" SUM(pnoc) AS sumpnoc FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc ";
//echo $sqlttz;
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $sumhod=$riadok->sumhodxb;
  $sumpndc=$riadok->sumpndc;
  $sumpsob=$riadok->sumpsob;
  $sumpned=$riadok->sumpned;
  $sumpsvt=$riadok->sumpsvt;
  $sumpnoc=$riadok->sumpnoc;

  }

$sumnep=0;
$sqlttz = "SELECT oc, dmxa, SUM(hodxb) AS sumhodxb FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa >= 500 GROUP BY oc ";
//echo $sqlttz;
$sqlz = mysql_query("$sqlttz"); 
  if (@$zaznam=mysql_data_seek($sqlz,0))
  {
  $riadok=mysql_fetch_object($sqlz);
  $sumnep=$riadok->sumhodxb;

  }

?>

<tr>
<td align="right">
Celkom
</td>

<td align="right">
 odpracovanÈ <?php echo $sumhod; ?> hod.
</td>

<td align="left">
 - n·hrady <?php echo $sumnep; ?> hod.
</td>

<td align="right"><?php echo $sumpndc; ?>
</td>

<td align="right"><?php echo $sumpsob; ?>
</td>

<td align="right"><?php echo $sumpned; ?>
</td>

<td align="right"><?php echo $sumpsvt; ?>
</td>

<td align="right"><?php echo $sumpnoc; ?>
</td>

</tr>

<tr>
<td align="left" colspan="7">
Fond pracovnÈho Ëasu 
</td>

</table>
<br /><br />

<table>
<tr>
<FORM name='fhiden' method='post' action='#' >
<input type='hidden' name='ocold' id='ocold' value='0' >
<input type='hidden' name='datodold' id='datodold' value='0' >
</FORM></tr></table> 

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$zmenume=1; $odkaz="../mzdy/dochadzka_detail.php?copern=1&drupoh=1&page=1&subor=0";
$cislista = include("mzd_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
