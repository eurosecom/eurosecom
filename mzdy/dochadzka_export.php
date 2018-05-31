<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 2000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];

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

$zmenu = 1*$_REQUEST['zmenu'];
if( $zmenu == 1 )
{
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;
$_SESSION['kli_vduj'] = $vyb_duj;

$kli_vduj=$vyb_duj;
$kli_vxcf=$vyb_xcf;
$kli_nxcf=$vyb_naz;
$kli_vume=$vyb_ume;
$kli_vrok=$vyb_rok;
}

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

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


//udaje o priplatkoch
$dm_nad=201; $dm_so=202; $dm_ne=203; $dm_sv=204; $dm_nc=223; 
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
  }


//posli do mzdmes ak cislo_oc=0 tak vsetci
if( $copern == 26 )
{

$casovamzda=104;
$casovasadzba="sz4";
$nadcaspriplatok=201;
$sviatokpriplatok=204;
$obedy=926; 
$narokstrava=4;

$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
     {
?>
<script type="text/javascript">
alert ("POZOR !  Mzdy za obdobie <?php echo $kli_vume; ?> \r boli už spracované naostro ");
window.close();
</script>
<?php
exit;
     }

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$zdetailu = 1*$_REQUEST['zdetailu'];

$vsetci=0;
if( $cislo_oc == 0 ) $vsetci=1;

//cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  
//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  
if( $kli_vmes < 10 ) $kli_vmes="0".$kli_vmes;
$dok="9".$kli_vmes."99";

$podmoc="F$kli_vxcf"."_mzddochadzka.oc = ".$cislo_oc." AND ";
if( $vsetci == 1 ) $podmoc="";
$podm2oc="F$kli_vxcf"."_mzdmes.oc = ".$cislo_oc." AND ";
if( $vsetci == 1 ) $podm2oc="";


//ak je nemoc od 1. v mesiaci zisti kolko dni je v minulom mesiaci dokonca
$sql = "DROP TABLE F".$kli_vxcf."_mzddochadzka$kli_uzid ";
$vysledok = mysql_query($sql);

$vsql = "CREATE TABLE F".$kli_vxcf."_mzddochadzka$kli_uzid SELECT * FROM F".$kli_vxcf."_mzddochadzka ";
$vytvor = mysql_query("$vsql");

$vsql = "TRUNCATE TABLE F".$kli_vxcf."_mzddochadzka$kli_uzid ";
$vytvor = mysql_query("$vsql");

$daod1_sk="1.".$kli_vume;
$daod1_sql=SqlDatum($daod1_sk);

$dado31b_sk=$pocetdni.".".$kli_vume;
$dado31b_sql=SqlDatum($dado31b_sk);

$dado31_sk=$pocetdnim.".".$kli_mume;
$dado31_sql=SqlDatum($dado31_sk);

$vsql = "INSERT INTO F".$kli_vxcf."_mzddochadzka$kli_uzid SELECT * FROM F".$kli_vxcf."_mzddochadzka WHERE dmxa = 801 AND daod = '".$daod1_sql."' ";
$vytvor = mysql_query("$vsql");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddochadzka$kli_uzid,F$kli_vxcf"."_mzddochadzka SET ".
" F$kli_vxcf"."_mzddochadzka$kli_uzid.dnixb=F$kli_vxcf"."_mzddochadzka.dnixa ".
" WHERE F$kli_vxcf"."_mzddochadzka$kli_uzid.oc=F$kli_vxcf"."_mzddochadzka.oc ".
" AND F$kli_vxcf"."_mzddochadzka.dmxa = 801 AND F$kli_vxcf"."_mzddochadzka.dado = '".$dado31_sql."'";
//echo $dado31_sk;
//echo $sqtoz;
//exit;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddochadzka$kli_uzid SET ".
" dnixb=7  WHERE dnixb > 7 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzddochadzka,F$kli_vxcf"."_mzddochadzka$kli_uzid SET ".
" F$kli_vxcf"."_mzddochadzka.dnixb=F$kli_vxcf"."_mzddochadzka$kli_uzid.dnixb ".
" WHERE F$kli_vxcf"."_mzddochadzka.oc=F$kli_vxcf"."_mzddochadzka$kli_uzid.oc ".
" AND F$kli_vxcf"."_mzddochadzka.dmxa = 801 AND F$kli_vxcf"."_mzddochadzka.daod = '".$daod1_sql."' ";
$oznac = mysql_query("$sqtoz");

//koniec zistovania kolko dni nemoc v minulom


$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdmes WHERE $podm2oc ume = $kli_vume AND dok = $dok ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,dmxa,'0000-00-00','0000-00-00',dnixa,0,hodxb,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 506 OR dmxa = 518 OR dmxa = 520 OR dmxa = 502 OR dmxa = 503 OR dmxa = 510 )";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,dmxa,daod,dado,dnixa,0,0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 802 OR dmxa = 809  )";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,803,daod,dado,(dnixa-dnixb),0,0,0,0,0,0,0,0,0,0,dnixb,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 801  ) AND dnixa >= 1 AND dnixa <= 3 AND dnixb < 3";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,803,daod,dado,(3-dnixb),0,0,0,0,0,0,0,0,0,0,dnixb,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 801  ) AND dnixa > 3 AND dnixb < 3";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,804,daod,dado,(dnixa-3-dnixb),0,0,0,0,0,0,0,0,0,0,dnixb,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 801  ) AND dnixa >= 4 AND dnixa <= 7 AND dnixb < 7";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,804,daod,dado,(4-dnixb),0,0,0,0,0,0,0,0,0,0,dnixb,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 801  ) AND dnixa > 7 AND dnixb < 7";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,801,daod,dado,(dnixa+dnixb-7),0,0,0,0,0,0,0,0,0,0,dnixb,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzka WHERE $podmoc ume = $kli_vume AND ( dmxa = 801  ) AND dnixa > 7";
$ulozene = mysql_query("$sqty");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=znah, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 506 OR dm = 518 OR dm = 520 OR dm = 510 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=0, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 502 OR dm = 503 )";
$oznac = mysql_query("$sqtoz");

//uprava dni a hodiny nahrad ak nieje cely den hodiny su v mnz
$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=hod-(uva-mnz), dni=dni-(1-mnz/uva) ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 506 OR dm = 518 OR dm = 520 OR dm = 502 OR dm = 503 OR dm = 510 )";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=0, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 802 OR dm = 809 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=znem*0.25, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 803 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=znem*0.55, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 804 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
"hod=dni*uva, saz=0, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = 801 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=hod*saz ".
"WHERE $podm2oc dok = $dok AND ( dm = 506 OR dm = 518 OR dm = 520 OR dm = 510 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=dni*saz, dk=ADDDATE(dp, (dni-1-msx4)) ".
"WHERE $podm2oc dok = $dok AND ( dm = 803 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=dni*saz, dp=ADDDATE(dp, (3-msx4)) ".
"WHERE $podm2oc dok = $dok AND ( dm = 804 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"dk=ADDDATE(dp, (dni-1-msx4))  ".
"WHERE $podm2oc dok = $dok AND ( dm = 804 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"dp=ADDDATE(dp, (7-msx4))  ".
"WHERE $podm2oc dok = $dok AND ( dm = 801 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"msx4=0  ".
"WHERE $podm2oc dok = $dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"mnz=0  ".
"WHERE $podm2oc dok = $dok ";
$oznac = mysql_query("$sqtoz");

//ked nie vsetci posli aj casovu(platene sz4 z kun) a nadcasy
if( $vsetci == 0 )
    {
$csvmzda=0; $ajnadcas=0;
$sqldok = mysql_query("SELECT csv, ndc FROM F$kli_vxcf"."_mzddochadzkaset WHERE ocx = $cislo_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $csvmzda=1*$riaddok->csv;
  $ajnadcas=1*$riaddok->ndc;
  }
if( $csvmzda == 1 )
  {
$daod1=$kli_vrok."-".$kli_vmes."-01";

//cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  
//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  
//$casovamzda=104; $casovasadzba="sz4";

if( $casovamzda > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$daod1',ume,oc,'$casovamzda','0000-00-00','0000-00-00',odpracdni,odpracov,0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 39 ";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$casovasadzba, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $casovamzda )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=hod*saz ".
"WHERE $podm2oc dok = $dok AND ( dm = $casovamzda )";
$oznac = mysql_query("$sqtoz");

//obedy $obedy=926;
if( $obedy > 0 )
{
$sqlt = "DROP TABLE F".$kli_vxcf."_dochprc2x".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_dochprc2x".$kli_uzid." SELECT * FROM F".$kli_vxcf."_dochprc".$kli_uzid." WHERE ume < 0 ";
$vytvor = mysql_query("$vsql");

//dochprcsx
//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  datn  datnz  cplxb 
//ndczos  ndccer  ndcrok  odpracdni  nadcasov  odpracov  zosthod  neprithod  prachod  pracdni  minutyz  minutyd  hodinyz  hodinyd  polprc 

$sqty = "INSERT INTO F$kli_vxcf"."_dochprc2x$kli_uzid SELECT ".
" ume,oc,dmxa,dmxb,daod,dado,dnixa,dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,0, ".
" ndczos,ndccer,0,odpracdni,nadcasov,odpracov,zosthod,neprithod,prachod,pracdni,minutyz,minutyd,hodinyz,SUM(hodinyd),polprc ". 
" FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 35 AND dmxa = 2 GROUP BY oc,daod ";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$sqtoz = "UPDATE F$kli_vxcf"."_dochprc2x$kli_uzid SET ndcrok=1 WHERE hodinyd >= $narokstrava ";
$oznac = mysql_query("$sqtoz");

//mzdmes
//cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  
//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  

$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,'$obedy','0000-00-00','0000-00-00',0,0,SUM(ndcrok),0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_dochprc2x$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 35 GROUP BY oc ";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$sqlt = "DROP TABLE F".$kli_vxcf."_dochprc2x".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sadzba="0";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $obedy LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sadzba=1*$riaddok->sa;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$sadzba, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $obedy )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=mnz*saz ".
"WHERE $podm2oc dok = $dok AND ( dm = $obedy )";
$oznac = mysql_query("$sqtoz");
}


}

//priplatok.sv
//$sviatokpriplatok=204;

$sqtoz = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid,kalendar SET ".
"ndczos=akyden, ndcrok=svt ".
"WHERE F$kli_vxcf"."_dochprc$kli_uzid.daod=kalendar.dat AND dmxb = 35 AND dmxa = 2 ";
$oznac = mysql_query("$sqtoz");

if( $sviatokpriplatok > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,daod,ume,oc,'$sviatokpriplatok','0000-00-00','0000-00-00',0,hodinyd,0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 35 AND ndcrok = 1 ";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=50; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $sviatokpriplatok LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $sviatokpriplatok )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=hod*saz ".
"WHERE $podm2oc dok = $dok AND ( dm = $sviatokpriplatok )";
$oznac = mysql_query("$sqtoz");
}
  }
if( $ajnadcas == 1 )
  {
$daod1=$kli_vrok."-".$kli_vmes."-01";

//cpl  dok  dat  ume  oc  dm  dp  dk  dni  hod  mnz  saz  kc  str  zak  stj  msx1  msx2  msx3  msx4  pop  id  datm  
//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  
//$nadcaspriplatok=201;

if( $nadcaspriplatok > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$daod1',ume,oc,'$nadcaspriplatok','0000-00-00','0000-00-00',0,nadcasov,0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 39 AND nadcasov > 0 ";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=25; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $nadcaspriplatok LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $nadcaspriplatok )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET ".
"kc=hod*saz ".
"WHERE $podm2oc dok = $dok AND ( dm = $nadcaspriplatok )";
$oznac = mysql_query("$sqtoz");
}
  }
//koniec aj nadcas

if( $zdetailu == 1 )
{
//echo "idem"; 
//exit;

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

if( $dm_so > 0 AND $sumpsob > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$dado31b_sql','$kli_vume',oc,'$dm_so','0000-00-00','0000-00-00',0,'$sumpsob',0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=25; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $dm_so LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  if( $sadzbax == 40 ) { $sadzba=100; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $dm_so )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET kc=hod*saz WHERE $podm2oc dok = $dok AND ( dm = $dm_so )";
$oznac = mysql_query("$sqtoz");
}
//koniec dm sobota

if( $dm_ne > 0 AND $sumpned > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$dado31b_sql','$kli_vume',oc,'$dm_ne','0000-00-00','0000-00-00',0,'$sumpned',0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=25; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $dm_ne LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  if( $sadzbax == 40 ) { $sadzba=100; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $dm_ne )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET kc=hod*saz WHERE $podm2oc dok = $dok AND ( dm = $dm_ne )";
$oznac = mysql_query("$sqtoz");
}
//koniec dm nedela

if( $dm_sv > 0 AND $sumpsvt > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$dado31b_sql','$kli_vume',oc,'$dm_sv','0000-00-00','0000-00-00',0,'$sumpsvt',0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=25; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $dm_sv LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  if( $sadzbax == 40 ) { $sadzba=100; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $dm_sv )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET kc=hod*saz WHERE $podm2oc dok = $dok AND ( dm = $dm_sv )";
$oznac = mysql_query("$sqtoz");
}
//koniec dm sviatok

if( $dm_nc > 0 AND $sumpnoc > 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes SELECT ".
"0,$dok,'$dado31b_sql','$kli_vume',oc,'$dm_nc','0000-00-00','0000-00-00',0,'$sumpnoc',0,0,0,0,0,0,0,0,0,0,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_mzddochadzkap".$kli_uzid." WHERE oc = $cislo_oc AND dmxa = 1 GROUP BY oc";
//echo $sqty;
//exit;
$ulozene = mysql_query("$sqty");

$kolkox=25; $sadzba="znah";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn WHERE dm = $dm_nc LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kolkox=1*$riaddok->sa;
  $sadzbax=1*$riaddok->ko;
  $sax=1*$riaddok->sax;
  if( $sadzbax == 20 ) { $sadzba="znah"; }
  if( $sadzbax == 30 AND sax == 0 ) { $sadzba="sz0"; }
  if( $sadzbax == 30 AND sax == 1 ) { $sadzba="sz1"; }
  if( $sadzbax == 30 AND sax == 2 ) { $sadzba="sz2"; }
  if( $sadzbax == 30 AND sax == 3 ) { $sadzba="sz3"; }
  if( $sadzbax == 30 AND sax == 4 ) { $sadzba="sz4"; }
  if( $sadzbax == 40 ) { $sadzba=100; }
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes,F$kli_vxcf"."_mzdkun SET ".
" saz=$kolkox*$sadzba/100, str=stz, zak=zkz ".
"WHERE $podm2oc F$kli_vxcf"."_mzdmes.oc=F$kli_vxcf"."_mzdkun.oc AND F$kli_vxcf"."_mzdmes.dok = $dok AND ( dm = $dm_nc )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdmes SET kc=hod*saz WHERE $podm2oc dok = $dok AND ( dm = $dm_nc )";
$oznac = mysql_query("$sqtoz");
}
//koniec dm noc

//exit;


}
//koniec z detailu

    }
?>
<script type="text/javascript">
window.open('../mzdy/mes_mzdy.php?copern=101&drupoh=1&page=1&zkun=1&vyb_osc=<?php echo $cislo_oc; ?>',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
</script>
<?php
exit;
}
//koniec posli do mzdmes


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export do Miezd</title>
  <style type="text/css">


  </style>
<script type="text/javascript">

    
</script>

</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Export do Miezd
</td>
<td align="right">
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
