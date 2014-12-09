<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if (!isset($fort)) $fort = 1;

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

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie bude pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

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
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;

$prepoc = 1*$_REQUEST['prepoc'];
$nezdanitelna = 1*$_REQUEST['nezdanitelna'];
$zamestnanecka = 1*$_REQUEST['zamestnanecka'];
$namanzelku = 1*$_REQUEST['namanzelku'];
$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//nacitanie minuleho roka do FOA
  if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do FOA z firmy minulÈho roka ? ") )
     { window.close() }
else
     { location.href='priznanie_foa2014.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                    }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("oddel_dtbz1.php");

$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa,".$databaza."F$h_ycf"."_mzdpriznanie_foa SET ".
" F$kli_vxcf"."_mzdpriznanie_foa.dprie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dprie, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dmeno=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dmeno, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dtitl=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dtitl, ".
" F$kli_vxcf"."_mzdpriznanie_foa.duli=".$databaza."F$h_ycf"."_mzdpriznanie_foa.duli, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dcdm=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dcdm, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dpsc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dpsc, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dmes=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dmes, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dtel=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dtel, ".
" F$kli_vxcf"."_mzdpriznanie_foa.dfax=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dfax, ".

" F$kli_vxcf"."_mzdpriznanie_foa.d2uli=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2uli, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2cdm=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2cdm, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2psc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2psc, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2mes=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2mes, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2tel=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2tel, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2fax=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2fax, ".

" F$kli_vxcf"."_mzdpriznanie_foa.d3uli=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3uli, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3cdm=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3cdm, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3psc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3psc, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3mes=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3mes, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3tel=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3tel, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3fax=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3fax, ".

" F$kli_vxcf"."_mzdpriznanie_foa.zrdk=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zrdk, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zrdc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zrdc,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.zprie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zprie, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zmeno=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zmeno, ".
" F$kli_vxcf"."_mzdpriznanie_foa.ztitl=".$databaza."F$h_ycf"."_mzdpriznanie_foa.ztitl, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zuli=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zuli, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zcdm=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zcdm, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zpsc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zpsc, ".
" F$kli_vxcf"."_mzdpriznanie_foa.zmes=".$databaza."F$h_ycf"."_mzdpriznanie_foa.zmes, ".
" F$kli_vxcf"."_mzdpriznanie_foa.ztel=".$databaza."F$h_ycf"."_mzdpriznanie_foa.ztel, ".

" F$kli_vxcf"."_mzdpriznanie_foa.mprie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.mprie,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.mrod=".$databaza."F$h_ycf"."_mzdpriznanie_foa.mrod, ".
" F$kli_vxcf"."_mzdpriznanie_foa.mpri=".$databaza."F$h_ycf"."_mzdpriznanie_foa.mpri, ".
" F$kli_vxcf"."_mzdpriznanie_foa.mpom=".$databaza."F$h_ycf"."_mzdpriznanie_foa.mpom, ".

" F$kli_vxcf"."_mzdpriznanie_foa.d1prie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d1prie,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.d1rod=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d1rod, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2prie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2prie,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.d2rod=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d2rod, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3prie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3prie,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.d3rod=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d3rod, ".
" F$kli_vxcf"."_mzdpriznanie_foa.d4prie=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d4prie,  ".
" F$kli_vxcf"."_mzdpriznanie_foa.d4rod=".$databaza."F$h_ycf"."_mzdpriznanie_foa.d4rod, ".

" F$kli_vxcf"."_mzdpriznanie_foa.dar=".$databaza."F$h_ycf"."_mzdpriznanie_foa.dar, ".
" F$kli_vxcf"."_mzdpriznanie_foa.rdk=".$databaza."F$h_ycf"."_mzdpriznanie_foa.rdk, ".
" F$kli_vxcf"."_mzdpriznanie_foa.rdc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.rdc  ".
" WHERE F$kli_vxcf"."_mzdpriznanie_foa.oc=".$databaza."F$h_ycf"."_mzdpriznanie_foa.oc "; 

$upravene = mysql_query("$uprtxt"); 
echo $uprtxt;
$copern=20;
//koniec nacitania celeho minuleho roka do FOA
    }

//nacitaj z potvrdenia
    if ( $copern == 36 ) { ?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ˙daje do FOA z Potvrdenia o prÌjmoch FO zo z·vislej Ëinnosti ? ") )
         { window.close()  }
else
         { location.href='priznanie_foa2014.php?copern=3636&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>'  }
</script>
<?php                    }

    if ( $copern == 3636 )
    {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdpotvrdenieFO WHERE oc = $cislo_oc  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $r01=1*$riaddok->r01;
  $r03a=1*$riaddok->r03a;
  $r03b=1*$riaddok->r03b;
  $r03c=1*$riaddok->r09;
  $r05=1*$riaddok->r05;
  $r08=1*$riaddok->r08;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r32=$r01, r33=$r03a, r33a=$r03c, r33b=$r03b, r62=$r05, r57=$r08  WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
$copern=20;
$subor=0;
$vsetkyprepocty=1;
$prepoc=1;
$strana=2;
    }
//koniec nacitaj z potvrdenia

//znovu nacitaj
if ( $copern == 26 )
    {
//echo "citam";
$nasielvyplnene=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc  ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;
  $riaddok=mysql_fetch_object($sqldok);
  $xr00z2=1*$riaddok->r00z2;
  }
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
if ( $zupravy == 1 ) $copern=20;
$subor=1;
$vsetkyprepocty=1;
$prepoc=1;
    }
//koniec znovu nacitaj


//zapis upravene udaje
if ( $copern == 23 )
     {
$rdc = strip_tags($_REQUEST['rdc']);
$rdk = strip_tags($_REQUEST['rdk']);
$dar = $_REQUEST['dar'];
$darsql=SqlDatum($dar);
$druh = 1*$_REQUEST['druh'];
$ddp = $_REQUEST['ddp'];
$ddpsql=SqlDatum($ddp);
$dprie = strip_tags($_REQUEST['dprie']);
$dmeno = strip_tags($_REQUEST['dmeno']);
$dtitl = strip_tags($_REQUEST['dtitl']);
$dtitz = strip_tags($_REQUEST['dtitz']);
$duli = strip_tags($_REQUEST['duli']);
$dcdm = strip_tags($_REQUEST['dcdm']);
$dpsc = strip_tags($_REQUEST['dpsc']);
$dmes = strip_tags($_REQUEST['dmes']);
$xstat = strip_tags($_REQUEST['xstat']);
$nrz = 1*$_REQUEST['nrz'];
$d2uli = strip_tags($_REQUEST['d2uli']);
$d2cdm = strip_tags($_REQUEST['d2cdm']);
$d2psc = strip_tags($_REQUEST['d2psc']);
$d2mes = strip_tags($_REQUEST['d2mes']);
$zprie = strip_tags($_REQUEST['zprie']);
$zmeno = strip_tags($_REQUEST['zmeno']);
$ztitl = strip_tags($_REQUEST['ztitl']);
$ztitz = strip_tags($_REQUEST['ztitz']);
$zrdc = strip_tags($_REQUEST['zrdc']);
$zrdk = strip_tags($_REQUEST['zrdk']);
$zuli = strip_tags($_REQUEST['zuli']);
$zcdm = strip_tags($_REQUEST['zcdm']);
$zpsc = strip_tags($_REQUEST['zpsc']);
$zmes = strip_tags($_REQUEST['zmes']);
$zstat = strip_tags($_REQUEST['zstat']);
$dtel = strip_tags($_REQUEST['dtel']);
$dmailfax = strip_tags($_REQUEST['dmailfax']);
//$d2tel = strip_tags($_REQUEST['d2tel']);
//$d2fax = strip_tags($_REQUEST['d2fax']);
//$d3uli = strip_tags($_REQUEST['d3uli']);
//$d3cdm = strip_tags($_REQUEST['d3cdm']);
//$d3psc = strip_tags($_REQUEST['d3psc']);
//$d3mes = strip_tags($_REQUEST['d3mes']);
//$d3tel = strip_tags($_REQUEST['d3tel']);
//$d3fax = strip_tags($_REQUEST['d3fax']);
//$oznucet = 1*$_REQUEST['oznucet'];
//$ztel = strip_tags($_REQUEST['ztel']);

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" rdc='$rdc', rdk='$rdk', dar='$darsql', druh='$druh', ddp='$ddpsql', ".
" dprie='$dprie', dmeno='$dmeno', dtitl='$dtitl', dtitz='$dtitz', duli='$duli', dcdm='$dcdm', dpsc='$dpsc', dmes='$dmes', xstat='$xstat', nrz='$nrz', ".
" d2uli='$d2uli', d2cdm='$d2cdm', d2psc='$d2psc', d2mes='$d2mes', dtel='$dtel', dmailfax='$dmailfax', ".
" zprie='$zprie', zmeno='$zmeno', ztitl='$ztitl', ztitz='$ztitz', zrdc='$zrdc', zrdk='$zrdk', zuli='$zuli', zcdm='$zcdm', zpsc='$zpsc', zmes='$zmes', zstat='$zstat' ".
" WHERE oc = $cislo_oc";
                    }

$r27 = 1*$_REQUEST['r27'];
$r28 = 1*$_REQUEST['r28'];
//$r29 = $_REQUEST['r29'];
$mprie = strip_tags($_REQUEST['mprie']);
$mrod = strip_tags($_REQUEST['mrod']);
$mpri = 1*$_REQUEST['mpri'];
$mpom = 1*$_REQUEST['mpom'];
$d1prie = strip_tags($_REQUEST['d1prie']);
$d1rod = strip_tags($_REQUEST['d1rod']);
$d1pomc = 1*$_REQUEST['d1pomc'];
$d1pom1 = 1*$_REQUEST['d1pom1'];
$d1pom2 = 1*$_REQUEST['d1pom2'];
$d1pom3 = 1*$_REQUEST['d1pom3'];
$d1pom4 = 1*$_REQUEST['d1pom4'];
$d1pom5 = 1*$_REQUEST['d1pom5'];
$d1pom6 = 1*$_REQUEST['d1pom6'];
$d1pom7 = 1*$_REQUEST['d1pom7'];
$d1pom8 = 1*$_REQUEST['d1pom8'];
$d1pom9 = 1*$_REQUEST['d1pom9'];
$d1pom10 = 1*$_REQUEST['d1pom10'];
$d1pom11 = 1*$_REQUEST['d1pom11'];
$d1pom12 = 1*$_REQUEST['d1pom12'];
$d2prie = strip_tags($_REQUEST['d2prie']);
$d2rod = strip_tags($_REQUEST['d2rod']);
$d2pomc = 1*$_REQUEST['d2pomc'];
$d2pom1 = 1*$_REQUEST['d2pom1'];
$d2pom2 = 1*$_REQUEST['d2pom2'];
$d2pom3 = 1*$_REQUEST['d2pom3'];
$d2pom4 = 1*$_REQUEST['d2pom4'];
$d2pom5 = 1*$_REQUEST['d2pom5'];
$d2pom6 = 1*$_REQUEST['d2pom6'];
$d2pom7 = 1*$_REQUEST['d2pom7'];
$d2pom8 = 1*$_REQUEST['d2pom8'];
$d2pom9 = 1*$_REQUEST['d2pom9'];
$d2pom10 = 1*$_REQUEST['d2pom10'];
$d2pom11 = 1*$_REQUEST['d2pom11'];
$d2pom12 = 1*$_REQUEST['d2pom12'];
$d3prie = strip_tags($_REQUEST['d3prie']);
$d3rod = strip_tags($_REQUEST['d3rod']);
$d3pomc = 1*$_REQUEST['d3pomc'];
$d3pom1 = 1*$_REQUEST['d3pom1'];
$d3pom2 = 1*$_REQUEST['d3pom2'];
$d3pom3 = 1*$_REQUEST['d3pom3'];
$d3pom4 = 1*$_REQUEST['d3pom4'];
$d3pom5 = 1*$_REQUEST['d3pom5'];
$d3pom6 = 1*$_REQUEST['d3pom6'];
$d3pom7 = 1*$_REQUEST['d3pom7'];
$d3pom8 = 1*$_REQUEST['d3pom8'];
$d3pom9 = 1*$_REQUEST['d3pom9'];
$d3pom10 = 1*$_REQUEST['d3pom10'];
$d3pom11 = 1*$_REQUEST['d3pom11'];
$d3pom12 = 1*$_REQUEST['d3pom12'];
$d4prie = strip_tags($_REQUEST['d4prie']);
$d4rod = strip_tags($_REQUEST['d4rod']);
$d4pomc = 1*$_REQUEST['d4pomc'];
$d4pom1 = 1*$_REQUEST['d4pom1'];
$d4pom2 = 1*$_REQUEST['d4pom2'];
$d4pom3 = 1*$_REQUEST['d4pom3'];
$d4pom4 = 1*$_REQUEST['d4pom4'];
$d4pom5 = 1*$_REQUEST['d4pom5'];
$d4pom6 = 1*$_REQUEST['d4pom6'];
$d4pom7 = 1*$_REQUEST['d4pom7'];
$d4pom8 = 1*$_REQUEST['d4pom8'];
$d4pom9 = 1*$_REQUEST['d4pom9'];
$d4pom10 = 1*$_REQUEST['d4pom10'];
$d4pom11 = 1*$_REQUEST['d4pom11'];
$d4pom12 = 1*$_REQUEST['d4pom12'];
$det4 = 1*$_REQUEST['det4'];
$r32 = 1*$_REQUEST['r32'];
$r32a = 1*$_REQUEST['r32a'];
$r33a = 1*$_REQUEST['r33a'];
$r33b = 1*$_REQUEST['r33b'];
$r33 = 1*$_REQUEST['r33'];
$r34 = 1*$_REQUEST['r34'];
$r35 = 1*$_REQUEST['r35'];

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" r27='$r27', r28='$r28', mprie='$mprie', mrod='$mrod', mpri='$mpri', mpom='$mpom', ".
" d1prie='$d1prie', d1rod='$d1rod', d1pomc='$d1pomc', d1pom1='$d1pom1', d1pom2='$d1pom2', d1pom3='$d1pom3', d1pom4='$d1pom4', d1pom5='$d1pom5', ".
" d1pom6='$d1pom6', d1pom7='$d1pom7', d1pom8='$d1pom8', d1pom9='$d1pom9', d1pom10='$d1pom10', d1pom11='$d1pom11', d1pom12='$d1pom12', ".
" d2prie='$d2prie', d2rod='$d2rod', d2pomc='$d2pomc', d2pom1='$d2pom1', d2pom2='$d2pom2', d2pom3='$d2pom3', d2pom4='$d2pom4', d2pom5='$d2pom5', ".
" d2pom6='$d2pom6', d2pom7='$d2pom7', d2pom8='$d2pom8', d2pom9='$d2pom9', d2pom10='$d2pom10', d2pom11='$d2pom11', d2pom12='$d2pom12', ".
" d3prie='$d3prie', d3rod='$d3rod', d3pomc='$d3pomc', d3pom1='$d3pom1', d3pom2='$d3pom2', d3pom3='$d3pom3', d3pom4='$d3pom4', d3pom5='$d3pom5', ".
" d3pom6='$d3pom6', d3pom7='$d3pom7', d3pom8='$d3pom8', d3pom9='$d3pom9', d3pom10='$d3pom10', d3pom11='$d3pom11', d3pom12='$d3pom12', ".
" d4prie='$d4prie', d4rod='$d4rod', d4pomc='$d4pomc', d4pom1='$d4pom1', d4pom2='$d4pom2', d4pom3='$d4pom3', d4pom4='$d4pom4', d4pom5='$d4pom5', ".
" d4pom6='$d4pom6', d4pom7='$d4pom7', d4pom8='$d4pom8', d4pom9='$d4pom9', d4pom10='$d4pom10', d4pom11='$d4pom11', d4pom12='$d4pom12', det4='$det4', ".
" r32='$r32', r32a='$r32a', r33a='$r33a', r33b='$r33b', r33='$r33', r34='$r34', r35='$r35'  ".
" WHERE oc = $cislo_oc"; 
                    }

$r36 = 1*$_REQUEST['r36'];
$r37 = 1*$_REQUEST['r37'];
$r38 = 1*$_REQUEST['r38'];
$r39 = 1*$_REQUEST['r39'];
$r40 = 1*$_REQUEST['r40'];
$r41 = 1*$_REQUEST['r41'];
$r42 = 1*$_REQUEST['r42'];
$r43 = 1*$_REQUEST['r43'];
$r44 = 1*$_REQUEST['r44'];
$r45 = 1*$_REQUEST['r45'];
//$r45a = $_REQUEST['r45a'];
//$r45b = $_REQUEST['r45b'];
//$r45c = $_REQUEST['r45c'];
//$r45d = $_REQUEST['r45d'];
$r46 = 1*$_REQUEST['r46'];
$r47 = 1*$_REQUEST['r47'];
$r48 = 1*$_REQUEST['r48'];
$r49 = 1*$_REQUEST['r49'];
$r50 = 1*$_REQUEST['r50'];
$r51 = 1*$_REQUEST['r51'];
$r52 = 1*$_REQUEST['r52'];
$r53 = 1*$_REQUEST['r53'];
$r54 = 1*$_REQUEST['r54'];
$r55 = 1*$_REQUEST['r55'];
$r56 = 1*$_REQUEST['r56'];
$r57 = 1*$_REQUEST['r57'];
$r58 = 1*$_REQUEST['r58'];
$r59 = 1*$_REQUEST['r59'];
$r60 = 1*$_REQUEST['r60'];
$r61 = 1*$_REQUEST['r61'];

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" r36='$r36', r37='$r37', r38='$r38', r39='$r39', r40='$r40', r41='$r41', r42='$r42', r43='$r43', r44='$r44', r45='$r45', r46='$r46', r47='$r47', r48='$r48', r49='$r49', ".
" r50='$r50', r51='$r51', r52='$r52', r53='$r53', r54='$r54', r55='$r55', r56='$r56', r57='$r57', r58='$r58', r59='$r59', r60='$r60', r61='$r61' ".
" WHERE oc = $cislo_oc";
                    }

$r62 = 1*$_REQUEST['r62'];
$r63 = 1*$_REQUEST['r63'];
$r64 = 1*$_REQUEST['r64'];
$r65 = 1*$_REQUEST['r65'];
$r66 = 1*$_REQUEST['r66'];
$r67 = 1*$_REQUEST['r67'];
$r68 = 1*$_REQUEST['r68'];
$r69 = 1*$_REQUEST['r69'];
$r70 = 1*$_REQUEST['r70'];
$r71 = 1*$_REQUEST['r71'];
$r72 = 1*$_REQUEST['r72'];
$r73 = 1*$_REQUEST['r73'];
$r74 = 1*$_REQUEST['r74'];

if ( $strana == 4 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" r62='$r62', r63='$r63', r64='$r64', r65='$r65', ".
" r66='$r66', r67='$r67', r68='$r68', r69='$r69', r70='$r70', r71='$r71', r72='$r72', r73='$r73', r74='$r74' ".
" WHERE oc = $cislo_oc"; 
                    }

$upl50 = 1*$_REQUEST['upl50'];
$spln3 = 1*$_REQUEST['spln3'];
$r75 = 1*$_REQUEST['r75'];
$pico = strip_tags($_REQUEST['pico']);
$psid = strip_tags($_REQUEST['psid']);
$pfor = strip_tags($_REQUEST['pfor']);
$pmen = strip_tags($_REQUEST['pmen']);
$puli = strip_tags($_REQUEST['puli']);
$pcdm = strip_tags($_REQUEST['pcdm']);
$ppsc = strip_tags($_REQUEST['ppsc']);
$pmes = strip_tags($_REQUEST['pmes']);
$uoso = 1*$_REQUEST['uoso'];
$pzks1 = strip_tags($_REQUEST['pzks1']);
//$pzst1 = strip_tags($_REQUEST['pzst1']);
$pzpr1 = 1*$_REQUEST['pzpr1'];
$pzvd1 = 1*$_REQUEST['pzvd1'];
$pzks2 = strip_tags($_REQUEST['pzks2']);
//$pzst2 = strip_tags($_REQUEST['pzst2']);
$pzpr2 = 1*$_REQUEST['pzpr2'];
$pzvd2 = 1*$_REQUEST['pzvd2'];
$pzks3 = strip_tags($_REQUEST['pzks3']);
//$pzst3 = strip_tags($_REQUEST['pzst3']);
$pzpr3 = 1*$_REQUEST['pzpr3'];
$pzvd3 = 1*$_REQUEST['pzvd3'];
$osob = strip_tags($_REQUEST['osob']);

if ( $strana == 5 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" upl50='$upl50', spln3='$spln3', r75='$r75', ".
" pico='$pico', psid='$psid', pfor='$pfor', pmen='$pmen', puli='$puli', pcdm='$pcdm', ppsc='$ppsc', pmes='$pmes', ".
" uoso='$uoso', pzks1='$pzks1', pzpr1='$pzpr1', pzvd1='$pzvd1', pzks2='$pzks2', pzpr2='$pzpr2', pzvd2='$pzvd2', ".
" pzks3='$pzks3', pzpr3='$pzpr3', pzvd3='$pzvd3', osob='$osob' ".
" WHERE oc = $cislo_oc";
                    }

$sdnr = strip_tags($_REQUEST['sdnr']);
$udnr = 1*$_REQUEST['udnr'];
$pril = 1*$_REQUEST['pril'];
$dat = $_REQUEST['dat'];
$datsql=Sqldatum($dat);
$zdbo = 1*$_REQUEST['zdbo'];
//$zrbo = 1*$_REQUEST['zrbo'];
$zpre = 1*$_REQUEST['zpre'];
$zprp = 1*$_REQUEST['zprp'];
$post = 1*$_REQUEST['post'];
$ucet = 1*$_REQUEST['ucet'];
$diban = strip_tags($_REQUEST['diban']);
//$dbic = strip_tags($_REQUEST['dbic']);
$uceb = strip_tags($_REQUEST['uceb']);
$numb = strip_tags($_REQUEST['numb']);
$da2 = $_REQUEST['da2'];
$da2sql=Sqldatum($da2);
$pomv = strip_tags($_REQUEST['pomv']);
//$post2 = 1*$_REQUEST['post2'];
//$ucet2 = 1*$_REQUEST['ucet2'];
//$uceb2 = strip_tags($_REQUEST['uceb2']);
//$numb2 = strip_tags($_REQUEST['numb2']);
//$da3 = $_REQUEST['da3'];
//$da3sql=Sqldatum($da3);

if ( $strana == 6 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET ".
" sdnr='$sdnr', udnr='$udnr', pril='$pril', dat='$datsql', pomv='$pomv', ".
" zdbo='$zdbo', zpre='$zpre', zprp='$zprp', post='$post', ucet='$ucet', diban='$diban', uceb='$uceb', numb='$numb', da2='$da2sql' ".
" WHERE oc = $cislo_oc";
                    }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$nepoc = 1*$_REQUEST['nepoc'];
$vsetkyprepocty=1;
if ( $nepoc == 1 ) $vsetkyprepocty=0;

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

//prac.subor a subor vytvorenych rocnych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT r33 FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdpriznanie_foa';
$vysledok = mysql_query("$sqlt");
$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   rdc          VARCHAR(6) NOT NULL,
   rdk          VARCHAR(4) NOT NULL,
   dar          DATE,
   dprie        VARCHAR(30) NOT NULL,
   dmeno        VARCHAR(30) NOT NULL,
   dtitl        VARCHAR(30) NOT NULL,
   duli         VARCHAR(30) NOT NULL,
   dcdm         VARCHAR(30) NOT NULL,
   dpsc         VARCHAR(30) NOT NULL,
   dmes         VARCHAR(30) NOT NULL,
   dtel         VARCHAR(30) NOT NULL,
   dfax         VARCHAR(30) NOT NULL,
   d2uli         VARCHAR(30) NOT NULL,
   d2cdm         VARCHAR(30) NOT NULL,
   d2psc         VARCHAR(30) NOT NULL,
   d2mes         VARCHAR(30) NOT NULL,
   d2tel         VARCHAR(30) NOT NULL,
   d2fax         VARCHAR(30) NOT NULL,
   d3uli         VARCHAR(30) NOT NULL,
   d3cdm         VARCHAR(30) NOT NULL,
   d3psc         VARCHAR(30) NOT NULL,
   d3mes         VARCHAR(30) NOT NULL,
   d3tel         VARCHAR(30) NOT NULL,
   d3fax         VARCHAR(30) NOT NULL,
   konx1        DECIMAL(10,0) DEFAULT 0,
   zrdc          VARCHAR(6) NOT NULL,
   zrdk          VARCHAR(4) NOT NULL,
   zprie        VARCHAR(30) NOT NULL,
   zmeno        VARCHAR(30) NOT NULL,
   ztitl        VARCHAR(30) NOT NULL,
   zuli         VARCHAR(30) NOT NULL,
   zcdm         VARCHAR(30) NOT NULL,
   zpsc         VARCHAR(30) NOT NULL,
   zmes         VARCHAR(30) NOT NULL,
   ztel         VARCHAR(30) NOT NULL,
   r28          DECIMAL(2,0) DEFAULT 0,
   r29          DECIMAL(10,2) DEFAULT 0,
   r32          DECIMAL(10,2) DEFAULT 0,
   r33a         DECIMAL(10,2) DEFAULT 0,
   r33b         DECIMAL(10,2) DEFAULT 0,
   mprie          VARCHAR(30) NOT NULL,
   mrod           VARCHAR(10) NOT NULL,
   mpri           DECIMAL(10,2) DEFAULT 0,
   mpom           DECIMAL(10,0) DEFAULT 0,
   d1prie          VARCHAR(30) NOT NULL,
   d1rod           VARCHAR(10) NOT NULL,
   d1pomc          DECIMAL(2,0) DEFAULT 0,
   d1pom1          DECIMAL(2,0) DEFAULT 0,
   d1pom2          DECIMAL(2,0) DEFAULT 0,
   d1pom3          DECIMAL(2,0) DEFAULT 0,
   d1pom4          DECIMAL(2,0) DEFAULT 0,
   d1pom5          DECIMAL(2,0) DEFAULT 0,
   d1pom6          DECIMAL(2,0) DEFAULT 0,
   d1pom7          DECIMAL(2,0) DEFAULT 0,
   d1pom8          DECIMAL(2,0) DEFAULT 0,
   d1pom9          DECIMAL(2,0) DEFAULT 0,
   d1pom10         DECIMAL(2,0) DEFAULT 0,
   d1pom11         DECIMAL(2,0) DEFAULT 0,
   d1pom12         DECIMAL(2,0) DEFAULT 0,
   d2prie          VARCHAR(30) NOT NULL,
   d2rod           VARCHAR(10) NOT NULL,
   d2pomc          DECIMAL(2,0) DEFAULT 0,
   d2pom1          DECIMAL(2,0) DEFAULT 0,
   d2pom2          DECIMAL(2,0) DEFAULT 0,
   d2pom3          DECIMAL(2,0) DEFAULT 0,
   d2pom4          DECIMAL(2,0) DEFAULT 0,
   d2pom5          DECIMAL(2,0) DEFAULT 0,
   d2pom6          DECIMAL(2,0) DEFAULT 0,
   d2pom7          DECIMAL(2,0) DEFAULT 0,
   d2pom8          DECIMAL(2,0) DEFAULT 0,
   d2pom9          DECIMAL(2,0) DEFAULT 0,
   d2pom10         DECIMAL(2,0) DEFAULT 0,
   d2pom11         DECIMAL(2,0) DEFAULT 0,
   d2pom12         DECIMAL(2,0) DEFAULT 0,
   d3prie          VARCHAR(30) NOT NULL,
   d3rod           VARCHAR(10) NOT NULL,
   d3pomc          DECIMAL(2,0) DEFAULT 0,
   d3pom1          DECIMAL(2,0) DEFAULT 0,
   d3pom2          DECIMAL(2,0) DEFAULT 0,
   d3pom3          DECIMAL(2,0) DEFAULT 0,
   d3pom4          DECIMAL(2,0) DEFAULT 0,
   d3pom5          DECIMAL(2,0) DEFAULT 0,
   d3pom6          DECIMAL(2,0) DEFAULT 0,
   d3pom7          DECIMAL(2,0) DEFAULT 0,
   d3pom8          DECIMAL(2,0) DEFAULT 0,
   d3pom9          DECIMAL(2,0) DEFAULT 0,
   d3pom10         DECIMAL(2,0) DEFAULT 0,
   d3pom11         DECIMAL(2,0) DEFAULT 0,
   d3pom12         DECIMAL(2,0) DEFAULT 0,
   d4prie          VARCHAR(30) NOT NULL,
   d4rod           VARCHAR(10) NOT NULL,
   d4pomc          DECIMAL(2,0) DEFAULT 0,
   d4pom1          DECIMAL(2,0) DEFAULT 0,
   d4pom2          DECIMAL(2,0) DEFAULT 0,
   d4pom3          DECIMAL(2,0) DEFAULT 0,
   d4pom4          DECIMAL(2,0) DEFAULT 0,
   d4pom5          DECIMAL(2,0) DEFAULT 0,
   d4pom6          DECIMAL(2,0) DEFAULT 0,
   d4pom7          DECIMAL(2,0) DEFAULT 0,
   d4pom8          DECIMAL(2,0) DEFAULT 0,
   d4pom9          DECIMAL(2,0) DEFAULT 0,
   d4pom10         DECIMAL(2,0) DEFAULT 0,
   d4pom11         DECIMAL(2,0) DEFAULT 0,
   d4pom12         DECIMAL(2,0) DEFAULT 0,
   upl5d           DECIMAL(2,0) DEFAULT 0,
   r33          DECIMAL(10,2) DEFAULT 0,
   r34          DECIMAL(10,2) DEFAULT 0,
   r35          DECIMAL(10,2) DEFAULT 0,
   r36          DECIMAL(10,2) DEFAULT 0,
   r37          DECIMAL(10,2) DEFAULT 0,
   r38          DECIMAL(10,2) DEFAULT 0,
   r39          DECIMAL(10,2) DEFAULT 0,
   r40          DECIMAL(10,2) DEFAULT 0,
   r41          DECIMAL(10,2) DEFAULT 0,
   r42          DECIMAL(10,2) DEFAULT 0,
   r43          DECIMAL(10,2) DEFAULT 0,
   r44          DECIMAL(10,2) DEFAULT 0,
   r45          DECIMAL(10,2) DEFAULT 0,
   r46          DECIMAL(10,2) DEFAULT 0,
   r47          DECIMAL(10,2) DEFAULT 0,
   r48          DECIMAL(10,2) DEFAULT 0,
   r49          DECIMAL(10,2) DEFAULT 0,
   r50          DECIMAL(10,2) DEFAULT 0,
   r51          DECIMAL(10,2) DEFAULT 0,
   r52          DECIMAL(10,2) DEFAULT 0,
   r53          DECIMAL(10,2) DEFAULT 0,
   r54          DECIMAL(10,2) DEFAULT 0,
   r45a          DECIMAL(10,2) DEFAULT 0,
   r45b          DECIMAL(10,2) DEFAULT 0,
   r45c          DECIMAL(10,2) DEFAULT 0,
   r45d          DECIMAL(10,2) DEFAULT 0,
   r55          DECIMAL(10,2) DEFAULT 0,
   r56          DECIMAL(10,2) DEFAULT 0,
   r57          DECIMAL(10,2) DEFAULT 0,
   r58          DECIMAL(10,2) DEFAULT 0,
   r59          DECIMAL(10,2) DEFAULT 0,
   r60          DECIMAL(10,2) DEFAULT 0,
   r61          DECIMAL(10,2) DEFAULT 0,
   r62          DECIMAL(10,2) DEFAULT 0,
   r63          DECIMAL(10,2) DEFAULT 0,
   r64          DECIMAL(10,2) DEFAULT 0,
   r65          DECIMAL(10,2) DEFAULT 0,
   r66          DECIMAL(10,2) DEFAULT 0,
   r67          DECIMAL(10,2) DEFAULT 0,
   r68          DECIMAL(10,2) DEFAULT 0,
   r69          DECIMAL(10,2) DEFAULT 0,
   r70          DECIMAL(10,2) DEFAULT 0,
   pico         VARCHAR(10) NOT NULL,
   psid         VARCHAR(10) NOT NULL,
   pfor         VARCHAR(30) NOT NULL,
   pmen         VARCHAR(40) NOT NULL,
   upl50        DECIMAL(2,0) DEFAULT 0,
   puli         VARCHAR(30) NOT NULL,
   pcdm         VARCHAR(10) NOT NULL,
   pmes         VARCHAR(30) NOT NULL,
   ppsc         VARCHAR(10) NOT NULL,
   uoso         DECIMAL(2,0) DEFAULT 0,
   osob         TEXT,
   pril         DECIMAL(2,0) DEFAULT 0,
   dat          DATE,
   zdbo         DECIMAL(2,0) DEFAULT 0,
   zrbo         DECIMAL(2,0) DEFAULT 0,
   post         DECIMAL(2,0) DEFAULT 0,
   ucet         DECIMAL(2,0) DEFAULT 0,
   uceb         VARCHAR(30) NOT NULL,
   numb         VARCHAR(10) NOT NULL,
   da2          DATE,
   zpre         DECIMAL(2,0) DEFAULT 0,
   zprp         DECIMAL(2,0) DEFAULT 0,
   post2        DECIMAL(2,0) DEFAULT 0,
   ucet2        DECIMAL(2,0) DEFAULT 0,
   uceb2        VARCHAR(30) NOT NULL,
   numb2        VARCHAR(10) NOT NULL,
   da3          DATE,
   pomv         TEXT,
   px17          DECIMAL(10,2) DEFAULT 0,
   r71          DECIMAL(10,2) DEFAULT 0,
   r72          DECIMAL(10,2) DEFAULT 0,
   r73          DECIMAL(10,2) DEFAULT 0,
   r74          DECIMAL(10,2) DEFAULT 0,
   r75          DECIMAL(10,2) DEFAULT 0,
   r76          DECIMAL(10,2) DEFAULT 0,
   r77          DECIMAL(10,2) DEFAULT 0,
   sdnr          VARCHAR(40) NOT NULL,
   udnr          DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdpriznanie_foa'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie priznaniefoa

$sql = "SELECT oznucet FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD prp DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD zstat VARCHAR(30) NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD nrz DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD ddp DATE NOT NULL AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD det4 DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD oznucet DECIMAL(4,0) DEFAULT 0 AFTER des2";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT spln3 FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY pmen VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD des6 DECIMAL(12,6) DEFAULT 0 AFTER pomv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD des2 DECIMAL(12,2) DEFAULT 0 AFTER pomv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY r45b DECIMAL(2,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY r43 DECIMAL(4,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD r32a DECIMAL(10,2) DEFAULT 0 AFTER r32";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD spln3 DECIMAL(2,0) DEFAULT 0 AFTER upl50";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT xstat FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD xstat VARCHAR(30) NOT NULL AFTER druh";
$vysledek = mysql_query("$sql");
}

//zmeny pre rok 2013
$sql = "SELECT dbic FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD new2013 DECIMAL(2,0) NOT NULL AFTER udnr";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY r28 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY r43 DECIMAL(10,2) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa MODIFY r44 DECIMAL(3,0) DEFAULT 0";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzks3 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzst3 VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzpr3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzks2 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzst2 VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzpr2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzks1 VARCHAR(4) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzst1 VARCHAR(30) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzpr1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD r27 DECIMAL(2,0) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD ztitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD dtitz VARCHAR(10) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD dmailfax VARCHAR(50) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD diban VARCHAR(40) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD dbic VARCHAR(15) NOT NULL AFTER new2013";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT pzvd3 FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzvd1 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzvd2 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD pzvd3 DECIMAL(10,2) DEFAULT 0 AFTER new2013";
$vysledek = mysql_query("$sql");
}

//zmeny pre rok 2014
$sql = "SELECT r78 FROM F".$kli_vxcf."_mzdpriznanie_foa";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD new2014 DECIMAL(2,0) NOT NULL AFTER pzks3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdpriznanie_foa ADD r78 DECIMAL(10,2) DEFAULT 0 AFTER new2014";
$vysledek = mysql_query("$sql");

}

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;

//pre rocne vytvor pracovny subor
if ( $subor == 1 )
{
//zober data z kun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  $prie=$riaddok->prie;
  $titl=$riaddok->titl;
  $zuli=$riaddok->zuli;
  $zcdm=$riaddok->zcdm;
  $zpsc=$riaddok->zpsc;
  $zmes=$riaddok->zmes;
  $ztel=$riaddok->ztel;
  $rdc=$riaddok->rdc;
  $rdk=$riaddok->rdk;
  $dar=$riaddok->dar;
  }
$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" ( druh,oc,dmeno,dprie,dtitl,rdc,rdk,dar,duli,dcdm,dpsc,dmes,dtel  ) VALUES ".
" ( 1, '$cislo_oc', '$meno', '$prie', '$titl', '$rdc', '$rdk', '$dar', '$zuli', '$zcdm', '$zpsc', '$zmes', '$ztel'  )";
$ttqq = mysql_query("$ttvv");

//uloz do priznania
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdpriznanie_foa".
" SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  if ( $nasielvyplnene == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r00z2='$xr00z2', r00a2='$xr00a2', r04a2='$xr04a2', r04b='$xr04b', ".
" r04c2='$xr04c2', r04d='$xr04d', r04e='$xr04e', r11b='$xr11b', r14b='$xr14b', r15b='$xr15b', vyk='$xvyk'  WHERE oc = $cislo_oc ";
//echo $sqtoz;
//$oznac = mysql_query("$sqtoz");
  }
$prepoc=1;
$copern=20;
}
//koniec pracovneho suboru pre rocne 

//vypocty su aktualizovane vsetky na 2013
//$prepoc=0;
$alertprepocet="";
if ( ( $copern == 10 OR $copern == 20 ) AND $prepoc == 1 )
{
$alertprepocet="!!! PrepoËÌtavam hodnoty v riadkoch !!!";

//vypocitaj 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r34=r32-r33, r36=r34+r35 WHERE oc = $cislo_oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if ( $nezdanitelna == 1 )
   {
//nezdanitelna cast na danovnika 2013 nedam ju tam lebo sa neda vynulovat
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r37=3735.94 WHERE oc = $cislo_oc  ";
$oznac = mysql_query("$sqtoz");

//milionarska dan 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=8600.436-(r36/4) WHERE oc = $cislo_oc AND r36 > 19458 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa".
" SET des2=des6*100, des2=ceil(des2), r37=des2/100  WHERE oc = $cislo_oc AND r36 > 19458 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r37=0 WHERE oc = $cislo_oc AND r37 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r37=0 WHERE oc = $cislo_oc AND r36 >= 34401.75 ";
$oznac = mysql_query("$sqtoz");
   }

if ( $namanzelku == 1 )
   {
//nezdanitelna cast na manzelku 2013 nedam ju tam lebo sa neda vynulovat
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r38=3735.94-mpri WHERE oc = $cislo_oc AND r36 <= 34401.74 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=12336.372-(r36/4) WHERE oc = $cislo_oc AND r36 > 34401.74 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa".
" SET des2=des6*100, des2=ceil(des2), r38=des2/100  WHERE oc = $cislo_oc AND r36 > 34401.74 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r38=0 WHERE oc = $cislo_oc AND r38 < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r38=0 WHERE oc = $cislo_oc AND r36 >= 49345.49 ";
$oznac = mysql_query("$sqtoz");
   }

//nezdanitelne polozky 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r40=r37+r38+r39 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//zaklad po odpocitani 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r41=r36-r40 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r41=0 WHERE oc = $cislo_oc AND r41 < 0 ";
$oznac = mysql_query("$sqtoz");

//dan z prijmu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=0, des2=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=r41*19/100 WHERE oc = $cislo_oc AND r41 <= 34401.75 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=(34401.75*19/100)+((r41-34401.75)*25/100) WHERE oc = $cislo_oc AND r41 > 34401.75 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa".
" SET des2=des6*100, r42=floor(des2), r42=r42/100 WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r42=0 WHERE oc = $cislo_oc AND r32 <= 1867.97 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=r42 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//zamestnanecka premia 2013
if ( $zamestnanecka == 1 )
   {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=0, r45=0, des2=0, des6=0 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=r34 WHERE oc = $cislo_oc AND r44 > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=3509.76 WHERE oc = $cislo_oc AND r32 < 4052.40 AND r32 >= 2026.20 AND r44 > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=0 WHERE oc = $cislo_oc AND r32 < 2026.20 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r44=12 WHERE oc = $cislo_oc AND r44 > 12";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r44=0 WHERE oc = $cislo_oc AND r44 < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=((3735.94-r34)*0.19)*r44/12 WHERE oc = $cislo_oc AND r44 > 0 AND r32 >= 4052.40 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des6=42.98*r44/12 WHERE oc = $cislo_oc AND r44 > 0  AND r32 < 4052.40 AND r32 >= 2026.20 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET des2=des6*100, r45=ceil(des2), r45=r45/100 WHERE oc = $cislo_oc AND r44 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r45=0 WHERE oc = $cislo_oc AND r45 < 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r45=42.98 WHERE oc = $cislo_oc AND r45 > 42.98 AND r44 > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r45=0, r43=0 WHERE oc = $cislo_oc AND r44 = 0";
$oznac = mysql_query("$sqtoz");

//danovni prijem r32 < 2026.20 nema narok
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=0, r45=0 WHERE oc = $cislo_oc AND r32 < 2026.20 ";
$oznac = mysql_query("$sqtoz");

//danovnik zaklad dane r34 > 3735.94 nema narok lebo zam.premia=(r37-r43)*r44/12*0.19
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r43=0, r45=0 WHERE oc = $cislo_oc AND r43 >= r37  ";
$oznac = mysql_query("$sqtoz");
   }
//koniec zam.premia 2013

//vynate prijmy 2013 zo zdrojov v zahranici ak r47 > 0 to su vynate prijmy zo zahranicia 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r48=r41-r47 WHERE oc = $cislo_oc AND r47 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r48=0, r49=0 WHERE oc = $cislo_oc AND r47 <= 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r49=0 WHERE oc = $cislo_oc AND r47 = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=r49 WHERE oc = $cislo_oc AND r49 > 0 ";
$oznac = mysql_query("$sqtoz");

//dan uznana na zapocet 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=r42-r54 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=r49-r54 WHERE oc = $cislo_oc AND r49 > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=0 WHERE oc = $cislo_oc AND r55 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r55=0 WHERE oc = $cislo_oc AND r55 <= 16.60 AND r56 = 0 ";
$oznac = mysql_query("$sqtoz");

//dan po odpocitani danoveho bonusu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r57=r55-r56 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r57=0 WHERE oc = $cislo_oc AND r57 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r57=0 WHERE oc = $cislo_oc AND r57 <= 16.60 AND r56 = 0 ";
$oznac = mysql_query("$sqtoz");

//vysporiadanie danoveho bonusu 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r59=r56-r58 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r59=0 WHERE oc = $cislo_oc AND r59 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r60=r59-r55 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r60=0 WHERE oc = $cislo_oc AND r60 < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r61=r58-r56 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r61=0 WHERE oc = $cislo_oc AND r61 < 0 ";
$oznac = mysql_query("$sqtoz");

//dan na uhradu, preplatok 2013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r65=0, r64=r55-r56+r58+r60-r62-r63+r46 WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdpriznanie_foa SET r65=-r64, r64=0 WHERE oc = $cislo_oc AND r64 < 0 ";
$oznac = mysql_query("$sqtoz");
}
//koniec vypocty ak prepoc=1

//meno,priezvisko,titul
$sql = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->dmeno;
  $prie=$riaddok->dprie;
  $titl=$riaddok->dtitl;
  $hrdc=$riaddok->rdc;
  $hrdk=$riaddok->rdk;
  }

//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa".
" WHERE oc = $cislo_oc AND konx1 = 0 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$rdc = $fir_riadok->rdc;
$rdk = $fir_riadok->rdk;
$dar = $fir_riadok->dar;
$darsk=SkDatum($dar);
$druh = $fir_riadok->druh;
$ddp = $fir_riadok->ddp;
$ddpsk=SkDatum($ddp);
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dpsc = $fir_riadok->dpsc;
$dmes = $fir_riadok->dmes;
$xstat = $fir_riadok->xstat;
$nrz = $fir_riadok->nrz;
$d2uli = $fir_riadok->d2uli;
$d2cdm = $fir_riadok->d2cdm;
$d2psc = $fir_riadok->d2psc;
$d2mes = $fir_riadok->d2mes;
$zprie = $fir_riadok->zprie;
$zmeno = $fir_riadok->zmeno;
$ztitl = $fir_riadok->ztitl;
$ztitz = $fir_riadok->ztitz;
$zrdc = $fir_riadok->zrdc;
$zrdk = $fir_riadok->zrdk;
$zuli = $fir_riadok->zuli;
$zcdm = $fir_riadok->zcdm;
$zpsc = $fir_riadok->zpsc;
$zmes = $fir_riadok->zmes;
$zstat = $fir_riadok->zstat;
$dtel = $fir_riadok->dtel;
$dmailfax = $fir_riadok->dmailfax;

if ( $strana == 2 ) {
$r27 = $fir_riadok->r27;
$r28 = $fir_riadok->r28;
$mprie = strip_tags($fir_riadok->mprie);
$mrod = strip_tags($fir_riadok->mrod);
$mpri = $fir_riadok->mpri;
$mpom = $fir_riadok->mpom;
$d1prie = strip_tags($fir_riadok->d1prie);
$d1rod = strip_tags($fir_riadok->d1rod);
$d1pomc = strip_tags($fir_riadok->d1pomc);
$d1pom1 = strip_tags($fir_riadok->d1pom1);
$d1pom2 = strip_tags($fir_riadok->d1pom2);
$d1pom3 = strip_tags($fir_riadok->d1pom3);
$d1pom4 = strip_tags($fir_riadok->d1pom4);
$d1pom5 = strip_tags($fir_riadok->d1pom5);
$d1pom6 = strip_tags($fir_riadok->d1pom6);
$d1pom7 = strip_tags($fir_riadok->d1pom7);
$d1pom8 = strip_tags($fir_riadok->d1pom8);
$d1pom9 = strip_tags($fir_riadok->d1pom9);
$d1pom10 = strip_tags($fir_riadok->d1pom10);
$d1pom11 = strip_tags($fir_riadok->d1pom11);
$d1pom12 = strip_tags($fir_riadok->d1pom12);
$d2prie = strip_tags($fir_riadok->d2prie);
$d2rod = strip_tags($fir_riadok->d2rod);
$d2pomc = strip_tags($fir_riadok->d2pomc);
$d2pom1 = strip_tags($fir_riadok->d2pom1);
$d2pom2 = strip_tags($fir_riadok->d2pom2);
$d2pom3 = strip_tags($fir_riadok->d2pom3);
$d2pom4 = strip_tags($fir_riadok->d2pom4);
$d2pom5 = strip_tags($fir_riadok->d2pom5);
$d2pom6 = strip_tags($fir_riadok->d2pom6);
$d2pom7 = strip_tags($fir_riadok->d2pom7);
$d2pom8 = strip_tags($fir_riadok->d2pom8);
$d2pom9 = strip_tags($fir_riadok->d2pom9);
$d2pom10 = strip_tags($fir_riadok->d2pom10);
$d2pom11 = strip_tags($fir_riadok->d2pom11);
$d2pom12 = strip_tags($fir_riadok->d2pom12);
$d3prie = strip_tags($fir_riadok->d3prie);
$d3rod = strip_tags($fir_riadok->d3rod);
$d3pomc = strip_tags($fir_riadok->d3pomc);
$d3pom1 = strip_tags($fir_riadok->d3pom1);
$d3pom2 = strip_tags($fir_riadok->d3pom2);
$d3pom3 = strip_tags($fir_riadok->d3pom3);
$d3pom4 = strip_tags($fir_riadok->d3pom4);
$d3pom5 = strip_tags($fir_riadok->d3pom5);
$d3pom6 = strip_tags($fir_riadok->d3pom6);
$d3pom7 = strip_tags($fir_riadok->d3pom7);
$d3pom8 = strip_tags($fir_riadok->d3pom8);
$d3pom9 = strip_tags($fir_riadok->d3pom9);
$d3pom10 = strip_tags($fir_riadok->d3pom10);
$d3pom11 = strip_tags($fir_riadok->d3pom11);
$d3pom12 = strip_tags($fir_riadok->d3pom12);
$d4prie = strip_tags($fir_riadok->d4prie);
$d4rod = strip_tags($fir_riadok->d4rod);
$d4pomc = strip_tags($fir_riadok->d4pomc);
$d4pom1 = strip_tags($fir_riadok->d4pom1);
$d4pom2 = strip_tags($fir_riadok->d4pom2);
$d4pom3 = strip_tags($fir_riadok->d4pom3);
$d4pom4 = strip_tags($fir_riadok->d4pom4);
$d4pom5 = strip_tags($fir_riadok->d4pom5);
$d4pom6 = strip_tags($fir_riadok->d4pom6);
$d4pom7 = strip_tags($fir_riadok->d4pom7);
$d4pom8 = strip_tags($fir_riadok->d4pom8);
$d4pom9 = strip_tags($fir_riadok->d4pom9);
$d4pom10 = strip_tags($fir_riadok->d4pom10);
$d4pom11 = strip_tags($fir_riadok->d4pom11);
$d4pom12 = strip_tags($fir_riadok->d4pom12);
$det4 = $fir_riadok->det4;
$r32 = $fir_riadok->r32;
$r32a = $fir_riadok->r32a;
$r33a = $fir_riadok->r33a;
$r33b = $fir_riadok->r33b;
$r33 = $fir_riadok->r33;
$r34 = $fir_riadok->r34;
$r35 = $fir_riadok->r35;
                    }

if ( $strana == 3 ) {
$r36 = $fir_riadok->r36;
$r37 = $fir_riadok->r37;
$r38 = $fir_riadok->r38;
$r39 = $fir_riadok->r39;
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
$r53 = $fir_riadok->r53;
$r54 = $fir_riadok->r54;
$r55 = $fir_riadok->r55;
$r56 = $fir_riadok->r56;
$r57 = $fir_riadok->r57;
$r58 = $fir_riadok->r58;
$r59 = $fir_riadok->r59;
$r60 = $fir_riadok->r60;
$r61 = $fir_riadok->r61;
                    }

if ( $strana == 4 ) {
$r62 = $fir_riadok->r62;
$r63 = $fir_riadok->r63;
$r64 = $fir_riadok->r64;
$r65 = $fir_riadok->r65;
$r66 = $fir_riadok->r66;
$r67 = $fir_riadok->r67;
$r68 = $fir_riadok->r68;
$r69 = $fir_riadok->r69;
$r70 = $fir_riadok->r70;
$r71 = $fir_riadok->r71;
$r72 = $fir_riadok->r72;
$r73 = $fir_riadok->r73;
$r74 = $fir_riadok->r74;
                    }

if ( $strana == 5 ) {
$upl50 = $fir_riadok->upl50;
$spln3 = $fir_riadok->spln3;
$r75 = $fir_riadok->r75;
$pico = $fir_riadok->pico;
$psid = $fir_riadok->psid;
$pfor = $fir_riadok->pfor;
$pmen = $fir_riadok->pmen;
$puli = $fir_riadok->puli;
$pcdm = $fir_riadok->pcdm;
$ppsc = $fir_riadok->ppsc;
$pmes = $fir_riadok->pmes;
$uoso = $fir_riadok->uoso;
$pzks1 = $fir_riadok->pzks1;
$pzpr1 = $fir_riadok->pzpr1;
$pzvd1 = $fir_riadok->pzvd1;
$pzks2 = $fir_riadok->pzks2;
$pzpr2 = $fir_riadok->pzpr2;
$pzvd2 = $fir_riadok->pzvd2;
$pzks3 = $fir_riadok->pzks3;
$pzpr3 = $fir_riadok->pzpr3;
$pzvd3 = $fir_riadok->pzvd3;
$osob = $fir_riadok->osob;
                    }

if ( $strana == 6 ) {
$sdnr = $fir_riadok->sdnr;
$udnr = $fir_riadok->udnr;
$pril = $fir_riadok->pril;
$dat = $fir_riadok->dat;
$datsk=Skdatum($dat);
$zdbo = $fir_riadok->zdbo;
$zpre = $fir_riadok->zpre;
$zprp = $fir_riadok->zprp;
$post = $fir_riadok->post;
$ucet = $fir_riadok->ucet;
$diban = $fir_riadok->diban;
$uceb = $fir_riadok->uceb;
$numb = $fir_riadok->numb;
$da2 = $fir_riadok->da2;
$da2sk=Skdatum($da2);
$pomv = $fir_riadok->pomv;
}
mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//osobne cislo prepinanie
$prepoc=1;
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
while ( $i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
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
//koniec novy=0
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z prÌjmov FOA</title>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby
if ( $copern == 20 )
{
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
   document.formv1.rdc.value = '<?php echo "$rdc";?>';
   document.formv1.rdk.value = '<?php echo "$rdk";?>';
   document.formv1.dar.value = '<?php echo "$darsk";?>';
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
   document.formv1.ddp.value = '<?php echo "$ddpsk";?>';
   document.formv1.dprie.value = '<?php echo "$dprie";?>';
   document.formv1.dmeno.value = '<?php echo "$dmeno";?>';
   document.formv1.dtitl.value = '<?php echo "$dtitl";?>';
   document.formv1.dtitz.value = '<?php echo "$dtitz";?>';
   document.formv1.duli.value = '<?php echo "$duli";?>';
   document.formv1.dcdm.value = '<?php echo "$dcdm";?>';
   document.formv1.dpsc.value = '<?php echo "$dpsc";?>';
   document.formv1.dmes.value = '<?php echo "$dmes";?>';
   document.formv1.xstat.value = '<?php echo "$xstat";?>';
<?php if ( $nrz == 1 ) { ?> document.formv1.nrz.checked = "checked"; <?php } ?>
   document.formv1.d2uli.value = '<?php echo "$d2uli";?>';
   document.formv1.d2cdm.value = '<?php echo "$d2cdm";?>';
   document.formv1.d2psc.value = '<?php echo "$d2psc";?>';
   document.formv1.d2mes.value = '<?php echo "$d2mes";?>';
   document.formv1.zprie.value = '<?php echo "$zprie";?>';
   document.formv1.zmeno.value = '<?php echo "$zmeno";?>';
   document.formv1.ztitl.value = '<?php echo "$ztitl";?>';
   document.formv1.ztitz.value = '<?php echo "$ztitz";?>';
   document.formv1.zrdc.value = '<?php echo "$zrdc";?>';
   document.formv1.zrdk.value = '<?php echo "$zrdk";?>';
   document.formv1.zuli.value = '<?php echo "$zuli";?>';
   document.formv1.zcdm.value = '<?php echo "$zcdm";?>';
   document.formv1.zpsc.value = '<?php echo "$zpsc";?>';
   document.formv1.zmes.value = '<?php echo "$zmes";?>';
   document.formv1.zstat.value = '<?php echo "$zstat";?>';
   document.formv1.dtel.value = '<?php echo "$dtel";?>';
   document.formv1.dmailfax.value = '<?php echo "$dmailfax";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.r28.value = '<?php echo "$r28";?>';
<?php if ( $r27 == 1 ) { ?> document.formv1.r27.checked = "checked"; <?php } ?>
   document.formv1.mprie.value = '<?php echo "$mprie";?>';
   document.formv1.mrod.value = '<?php echo "$mrod";?>';
   document.formv1.mpri.value = '<?php echo "$mpri";?>';
   document.formv1.mpom.value = '<?php echo "$mpom";?>';
   document.formv1.d1prie.value = '<?php echo "$d1prie";?>';
   document.formv1.d1rod.value = '<?php echo "$d1rod";?>';
<?php if ( $d1pomc == 1 ) { ?> document.formv1.d1pomc.checked = "checked"; <?php } ?>
<?php if ( $d1pom1 == 1 ) { ?> document.formv1.d1pom1.checked = "checked"; <?php } ?>
<?php if ( $d1pom2 == 1 ) { ?> document.formv1.d1pom2.checked = "checked"; <?php } ?>
<?php if ( $d1pom3 == 1 ) { ?> document.formv1.d1pom3.checked = "checked"; <?php } ?>
<?php if ( $d1pom4 == 1 ) { ?> document.formv1.d1pom4.checked = "checked"; <?php } ?>
<?php if ( $d1pom5 == 1 ) { ?> document.formv1.d1pom5.checked = "checked"; <?php } ?>
<?php if ( $d1pom6 == 1 ) { ?> document.formv1.d1pom6.checked = "checked"; <?php } ?>
<?php if ( $d1pom7 == 1 ) { ?> document.formv1.d1pom7.checked = "checked"; <?php } ?>
<?php if ( $d1pom8 == 1 ) { ?> document.formv1.d1pom8.checked = "checked"; <?php } ?>
<?php if ( $d1pom9 == 1 ) { ?> document.formv1.d1pom9.checked = "checked"; <?php } ?>
<?php if ( $d1pom10 == 1 ) { ?> document.formv1.d1pom10.checked = "checked"; <?php } ?>
<?php if ( $d1pom11 == 1 ) { ?> document.formv1.d1pom11.checked = "checked"; <?php } ?>
<?php if ( $d1pom12 == 1 ) { ?> document.formv1.d1pom12.checked = "checked"; <?php } ?>
   document.formv1.d2prie.value = '<?php echo "$d2prie";?>';
   document.formv1.d2rod.value = '<?php echo "$d2rod";?>';
<?php if ( $d2pomc == 1 ) { ?> document.formv1.d2pomc.checked = "checked"; <?php } ?>
<?php if ( $d2pom1 == 1 ) { ?> document.formv1.d2pom1.checked = "checked"; <?php } ?>
<?php if ( $d2pom2 == 1 ) { ?> document.formv1.d2pom2.checked = "checked"; <?php } ?>
<?php if ( $d2pom3 == 1 ) { ?> document.formv1.d2pom3.checked = "checked"; <?php } ?>
<?php if ( $d2pom4 == 1 ) { ?> document.formv1.d2pom4.checked = "checked"; <?php } ?>
<?php if ( $d2pom5 == 1 ) { ?> document.formv1.d2pom5.checked = "checked"; <?php } ?>
<?php if ( $d2pom6 == 1 ) { ?> document.formv1.d2pom6.checked = "checked"; <?php } ?>
<?php if ( $d2pom7 == 1 ) { ?> document.formv1.d2pom7.checked = "checked"; <?php } ?>
<?php if ( $d2pom8 == 1 ) { ?> document.formv1.d2pom8.checked = "checked"; <?php } ?>
<?php if ( $d2pom9 == 1 ) { ?> document.formv1.d2pom9.checked = "checked"; <?php } ?>
<?php if ( $d2pom10 == 1 ) { ?> document.formv1.d2pom10.checked = "checked"; <?php } ?>
<?php if ( $d2pom11 == 1 ) { ?> document.formv1.d2pom11.checked = "checked"; <?php } ?>
<?php if ( $d2pom12 == 1 ) { ?> document.formv1.d2pom12.checked = "checked"; <?php } ?>
   document.formv1.d3prie.value = '<?php echo "$d3prie";?>';
   document.formv1.d3rod.value = '<?php echo "$d3rod";?>';
<?php if ( $d3pomc == 1 ) { ?> document.formv1.d3pomc.checked = "checked"; <?php } ?>
<?php if ( $d3pom1 == 1 ) { ?> document.formv1.d3pom1.checked = "checked"; <?php } ?>
<?php if ( $d3pom2 == 1 ) { ?> document.formv1.d3pom2.checked = "checked"; <?php } ?>
<?php if ( $d3pom3 == 1 ) { ?> document.formv1.d3pom3.checked = "checked"; <?php } ?>
<?php if ( $d3pom4 == 1 ) { ?> document.formv1.d3pom4.checked = "checked"; <?php } ?>
<?php if ( $d3pom5 == 1 ) { ?> document.formv1.d3pom5.checked = "checked"; <?php } ?>
<?php if ( $d3pom6 == 1 ) { ?> document.formv1.d3pom6.checked = "checked"; <?php } ?>
<?php if ( $d3pom7 == 1 ) { ?> document.formv1.d3pom7.checked = "checked"; <?php } ?>
<?php if ( $d3pom8 == 1 ) { ?> document.formv1.d3pom8.checked = "checked"; <?php } ?>
<?php if ( $d3pom9 == 1 ) { ?> document.formv1.d3pom9.checked = "checked"; <?php } ?>
<?php if ( $d3pom10 == 1 ) { ?> document.formv1.d3pom10.checked = "checked"; <?php } ?>
<?php if ( $d3pom11 == 1 ) { ?> document.formv1.d3pom11.checked = "checked"; <?php } ?>
<?php if ( $d3pom12 == 1 ) { ?> document.formv1.d3pom12.checked = "checked"; <?php } ?>
   document.formv1.d4prie.value = '<?php echo "$d4prie";?>';
   document.formv1.d4rod.value = '<?php echo "$d4rod";?>';
<?php if ( $d4pomc == 1 ) { ?> document.formv1.d4pomc.checked = "checked"; <?php } ?>
<?php if ( $d4pom1 == 1 ) { ?> document.formv1.d4pom1.checked = "checked"; <?php } ?>
<?php if ( $d4pom2 == 1 ) { ?> document.formv1.d4pom2.checked = "checked"; <?php } ?>
<?php if ( $d4pom3 == 1 ) { ?> document.formv1.d4pom3.checked = "checked"; <?php } ?>
<?php if ( $d4pom4 == 1 ) { ?> document.formv1.d4pom4.checked = "checked"; <?php } ?>
<?php if ( $d4pom5 == 1 ) { ?> document.formv1.d4pom5.checked = "checked"; <?php } ?>
<?php if ( $d4pom6 == 1 ) { ?> document.formv1.d4pom6.checked = "checked"; <?php } ?>
<?php if ( $d4pom7 == 1 ) { ?> document.formv1.d4pom7.checked = "checked"; <?php } ?>
<?php if ( $d4pom8 == 1 ) { ?> document.formv1.d4pom8.checked = "checked"; <?php } ?>
<?php if ( $d4pom9 == 1 ) { ?> document.formv1.d4pom9.checked = "checked"; <?php } ?>
<?php if ( $d4pom10 == 1 ) { ?> document.formv1.d4pom10.checked = "checked"; <?php } ?>
<?php if ( $d4pom11 == 1 ) { ?> document.formv1.d4pom11.checked = "checked"; <?php } ?>
<?php if ( $d4pom12 == 1 ) { ?> document.formv1.d4pom12.checked = "checked"; <?php } ?>
<?php if ( $det4 == 1 ) { ?> document.formv1.det4.checked = "checked"; <?php } ?>
   document.formv1.r32.value = '<?php echo "$r32";?>';
   document.formv1.r32a.value = '<?php echo "$r32a";?>';
   document.formv1.r33a.value = '<?php echo "$r33a";?>';
   document.formv1.r33b.value = '<?php echo "$r33b";?>';
   document.formv1.r33.value = '<?php echo "$r33";?>';
   document.formv1.r34.value = '<?php echo "$r34";?>';
   document.formv1.r35.value = '<?php echo "$r35";?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   document.formv1.r36.value = '<?php echo "$r36";?>';
   document.formv1.r37.value = '<?php echo "$r37";?>';
   document.formv1.r38.value = '<?php echo "$r38";?>';
   document.formv1.r39.value = '<?php echo "$r39";?>';
   document.formv1.r40.value = '<?php echo "$r40";?>';
   document.formv1.r41.value = '<?php echo "$r41";?>';
   document.formv1.r42.value = '<?php echo "$r42";?>';
   document.formv1.r43.value = '<?php echo "$r43";?>';
   document.formv1.r44.value = '<?php echo "$r44";?>';
   document.formv1.r45.value = '<?php echo "$r45";?>';
   document.formv1.r46.value = '<?php echo "$r46";?>';
   document.formv1.r47.value = '<?php echo "$r47";?>';
   document.formv1.r48.value = '<?php echo "$r48";?>';
   document.formv1.r49.value = '<?php echo "$r49";?>';
   document.formv1.r50.value = '<?php echo "$r50";?>';
   document.formv1.r51.value = '<?php echo "$r51";?>';
   document.formv1.r52.value = '<?php echo "$r52";?>';
   document.formv1.r53.value = '<?php echo "$r53";?>';
   document.formv1.r54.value = '<?php echo "$r54";?>';
   document.formv1.r55.value = '<?php echo "$r55";?>';
   document.formv1.r56.value = '<?php echo "$r56";?>';
   document.formv1.r57.value = '<?php echo "$r57";?>';
   document.formv1.r58.value = '<?php echo "$r58";?>';
   document.formv1.r59.value = '<?php echo "$r59";?>';
   document.formv1.r60.value = '<?php echo "$r60";?>';
   document.formv1.r61.value = '<?php echo "$r61";?>';
<?php                                        } ?>

<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
   document.formv1.r62.value = '<?php echo "$r62";?>';
   document.formv1.r63.value = '<?php echo "$r63";?>';
   document.formv1.r64.value = '<?php echo "$r64";?>';
   document.formv1.r65.value = '<?php echo "$r65";?>';
   document.formv1.r66.value = '<?php echo "$r66";?>';
   document.formv1.r67.value = '<?php echo "$r67";?>';
   document.formv1.r68.value = '<?php echo "$r68";?>';
   document.formv1.r69.value = '<?php echo "$r69";?>';
   document.formv1.r70.value = '<?php echo "$r70";?>';
   document.formv1.r71.value = '<?php echo "$r71";?>';
   document.formv1.r72.value = '<?php echo "$r72";?>';
   document.formv1.r73.value = '<?php echo "$r73";?>';
   document.formv1.r74.value = '<?php echo "$r74";?>';
<?php                                        } ?>

<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<?php if ( $upl50 == 1 ) { ?> document.formv1.upl50.checked = "checked"; <?php } ?>
<?php if ( $spln3 == 1 ) { ?> document.formv1.spln3.checked = "checked"; <?php } ?>
   document.formv1.r75.value = '<?php echo "$r75";?>';
   document.formv1.pico.value = '<?php echo "$pico";?>';
   document.formv1.psid.value = '<?php echo "$psid";?>';
   document.formv1.pfor.value = '<?php echo "$pfor";?>';
   document.formv1.pmen.value = '<?php echo "$pmen";?>';
   document.formv1.puli.value = '<?php echo "$puli";?>';
   document.formv1.pcdm.value = '<?php echo "$pcdm";?>';
   document.formv1.ppsc.value = '<?php echo "$ppsc";?>';
   document.formv1.pmes.value = '<?php echo "$pmes";?>';
<?php if ( $uoso == 1 ) { ?> document.formv1.uoso.checked = "checked"; <?php } ?>
   document.formv1.pzks1.value = '<?php echo "$pzks1";?>';
   document.formv1.pzpr1.value = '<?php echo "$pzpr1";?>';
   document.formv1.pzvd1.value = '<?php echo "$pzvd1";?>';
   document.formv1.pzks2.value = '<?php echo "$pzks2";?>';
   document.formv1.pzpr2.value = '<?php echo "$pzpr2";?>';
   document.formv1.pzvd2.value = '<?php echo "$pzvd2";?>';
   document.formv1.pzks3.value = '<?php echo "$pzks3";?>';
   document.formv1.pzpr3.value = '<?php echo "$pzpr3";?>';
   document.formv1.pzvd3.value = '<?php echo "$pzvd3";?>';
   document.formv1.osob.value = '<?php echo "$osob";?>';
<?php                                        } ?>

<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
   document.formv1.sdnr.value = '<?php echo "$sdnr";?>';
   document.formv1.udnr.value = '<?php echo "$udnr";?>';
   document.formv1.pril.value = '<?php echo "$pril";?>';
   document.formv1.dat.value = '<?php echo "$datsk";?>';
<?php if ( $zdbo == 1 ) { ?> document.formv1.zdbo.checked = "checked"; <?php } ?>
<?php if ( $zpre == 1 ) { ?> document.formv1.zpre.checked = "checked"; <?php } ?>
<?php if ( $zprp == 1 ) { ?> document.formv1.zprp.checked = "checked"; <?php } ?>
   document.formv1.diban.value = '<?php echo "$diban";?>';
   document.formv1.uceb.value = '<?php echo "$uceb";?>';
   document.formv1.numb.value = '<?php echo "$numb";?>';
   document.formv1.da2.value = '<?php echo "$da2sk";?>';
   document.formv1.pomv.value = '<?php echo "$pomv";?>';
<?php                                        } ?>
  }
<?php
}
//koniec uprava
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>




//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC()
  {
   window.open('priznanie_foa2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self');
  }
  function nextOC()
  {
   window.open('priznanie_foa2014.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self');
  }
  function ZnovuPotvrdenie()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacFOA()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2014/dpfoa2014/FOAv13_poucenie_na_vyplnenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajPriPred()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=36&drupoh=1&page=1&subor=0&strana=9999', '_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function reNacitajMzdy()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0', '_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function UpravZamestnanca()
  {
   window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function DetiZamestnanca()
  {
   window.open('../mzdy/deti.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $cislo_oc;?>', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function TlacMzdovyList()
  {
   window.open('../mzdy/mzdevid.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1', '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes');
  }
  function nezdanitelna()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=3&strana=3&subor=0&nezdanitelna=1&prepoc=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function zamestnanecka()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=3&strana=3&subor=0&zamestnanecka=1&prepoc=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function namanzelku()
  {
   window.open('../mzdy/priznanie_foa2014.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=3&strana=3&subor=0&namanzelku=1&prepoc=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">DaÚ z prÌjmov FO typ A - <span class="subheader"><?php echo "$oc $meno $prie ";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC();" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC();" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();" title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/downbox_blue_icon.png" onclick="NacitajPriPred();" title="NaËÌtaù prÌjem a preddavky z potvrdenia" class="btn-form-tool">
     <img src="../obr/ikony/reload_blue_icon.png" onclick="reNacitajMzdy();" title="Znovu naËÌtaù hodnoty z miezd" class="btn-form-tool">
     <img src="../obr/ikony/usertwo_blue_icon.png" onclick="DetiZamestnanca();" title="Deti zamestnanca" class="btn-form-tool">
     <img src="../obr/ikony/user_blue_icon.png" onclick="UpravZamestnanca();" title="Upraviù ˙daje o zamestnancovi" class="btn-form-tool">
     <img src="../obr/ikony/list_blue_icon.png" onclick="TlacMzdovyList();" title="Zobraziù mzdov˝ list v PDF" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacFOA();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="priznanie_foa2014.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive"; $clas6="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";

$source="../mzdy/priznanie_foa2014.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">

 <input type="checkbox" name="prepoc" value="1" class="btn-prepocet"/>
<?php if ( $prepoc == 1 ) { ?>
 <script type="text/javascript">document.formv1.prepoc.checked = "checked";</script>
<?php                     } ?>
 <h5 class="btn-prepocet-title">PrepoËÌtaù hodnoty</h5>
 <div class="alert-pocitam"><?php echo "$alertprepocet";?></div>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str1.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2014 1.strana 282kB" class="form-background">

<input type="text" name="rdc" id="rdc" style="width:129px; top:261px; left:51px;"/><input type="text" name="rdk" id="rdk" style="width:82px; top:261px; left:213px;"/>
<input type="text" name="dar" id="dar" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:318px; left:51px;"/>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:264px; left:440px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:289px; left:440px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:314px; left:440px;"/>
<div class="nofill input-echo" style="width:81px; top:246px; left:784px;"><?php echo "$kli_vrok ";?></div>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:318px; left:690px;"/>

<!-- I. ODDIEL -->
<input type="text" name="dprie" id="dprie" style="width:359px; top:410px; left:51px;"/>
<input type="text" name="dmeno" id="dmeno" style="width:244px; top:410px; left:430px;"/>
<input type="text" name="dtitl" id="dtitl" style="width:112px; top:410px; left:694px;"/>
<input type="text" name="dtitz" id="dtitz" style="width:66px; top:410px; left:827px;"/>
<!-- Adresa trvaleho pobytu -->
<input type="text" name="duli" id="duli" style="width:635px; top:483px; left:51px;"/>
<input type="text" name="dcdm" id="dcdm" style="width:175px; top:483px; left:718px;"/>
<input type="text" name="dpsc" id="dpsc" style="width:107px; top:538px; left:51px;"/>
<input type="text" name="dmes" id="dmes" style="width:451px; top:538px; left:178px;"/>
<input type="text" name="xstat" id="xstat" style="width:245px; top:538px; left:648px;"/>
<!-- nerezident -->
<input type="checkbox" name="nrz" value="1" style="top:576px; left:647px;"/>
<!-- Adresa pobytu na uzemi SR -->
<input type="text" name="d2uli" id="d2uli" style="width:635px; top:643px; left:51px;"/>
<input type="text" name="d2cdm" id="d2cdm" style="width:175px; top:643px; left:718px;"/>
<input type="text" name="d2psc" id="d2psc" style="width:107px; top:698px; left:51px;"/>
<input type="text" name="d2mes" id="d2mes" style="width:451px; top:698px; left:178px;"/>

<!-- II. ODDIEL -->
<input type="text" name="zprie" id="zprie" style="width:359px; top:806px; left:51px;"/>
<input type="text" name="zmeno" id="zmeno" style="width:244px; top:806px; left:430px;"/>
<input type="text" name="ztitl" id="ztitl" style="width:112px; top:806px; left:694px;"/>
<input type="text" name="ztitz" id="ztitz" style="width:66px; top:806px; left:827px;"/>
<input type="text" name="zrdc" id="zrdc" style="width:129px; top:860px; left:51px;"/>
<input type="text" name="zrdk" id="zrdk" style="width:84px; top:860px; left:212px;"/>
<input type="text" name="zuli" id="zuli" style="width:357px; top:860px; left:328px;"/>
<input type="text" name="zcdm" id="zcdm" style="width:175px; top:860px; left:718px;"/>
<input type="text" name="zpsc" id="zpsc" style="width:107px; top:915px; left:51px;"/>
<input type="text" name="zmes" id="zmes" style="width:451px; top:915px; left:178px;"/>
<input type="text" name="zstat" id="zstat" style="width:245px; top:915px; left:648px;"/>
<!-- telefon a fax FO -->
<input type="text" name="dtel" id="dtel" style="width:290px; top:977px; left:51px;"/>
<input type="text" name="dmailfax" id="dmailfax" style="width:520px; top:977px; left:373px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<?php $tlacrdk="$hrdc / $hrdk"; if ( $tlacrdk == "0 / " ) { $tlacrdk=""; } ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str2.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2014 2.strana 250kB" class="form-background">
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo "$tlacrdk"; ?>" disabled="disabled" class="nofill" style="width:242px; top:68px; left:357px;"/>

<!-- III. ODDIEL -->
<input type="checkbox" name="r27" value="1" style="top:242px; left:695px;"/>
<input type="text" name="r28" id="r28" onkeyup="CiarkaNaBodku(this);" style="width:174px; top:288px; left:650px;"/>
<input type="text" name="mprie" id="mprie" style="width:340px; top:376px; left:51px;"/>
<input type="text" name="mrod" id="mrod" style="width:240px; top:376px; left:413px;"/>
<input type="text" name="mpri" id="mpri" onkeyup="CiarkaNaBodku(this);" style="width:153px; top:376px; left:671px;"/>
<input type="text" name="mpom" id="mpom" style="width:38px; top:376px; left:850px;"/>

<!-- IV. ODDIEL -->
<input type="text" name="d1prie" id="d1prie" style="width:243px; top:574px; left:47px;"/>
<input type="text" name="d1rod" id="d1rod" style="width:240px; top:574px; left:304px;"/>
<input type="checkbox" name="d1pomc" value="1" style="top:585px; left:561px;"/>
<input type="checkbox" name="d1pom1" value="1" style="top:585px; left:598px;"/>
<input type="checkbox" name="d1pom2" value="1" style="top:585px; left:623px;"/>
<input type="checkbox" name="d1pom3" value="1" style="top:585px; left:649px;"/>
<input type="checkbox" name="d1pom4" value="1" style="top:585px; left:674px;"/>
<input type="checkbox" name="d1pom5" value="1" style="top:585px; left:699px;"/>
<input type="checkbox" name="d1pom6" value="1" style="top:585px; left:724px;"/>
<input type="checkbox" name="d1pom7" value="1" style="top:585px; left:750px;"/>
<input type="checkbox" name="d1pom8" value="1" style="top:585px; left:775px;"/>
<input type="checkbox" name="d1pom9" value="1" style="top:585px; left:800px;"/>
<input type="checkbox" name="d1pom10" value="1" style="top:585px; left:826px;"/>
<input type="checkbox" name="d1pom11" value="1" style="top:585px; left:851px;"/>
<input type="checkbox" name="d1pom12" value="1" style="top:585px; left:877px;"/>

<input type="text" name="d2prie" id="d2prie" style="width:243px; top:619px; left:47px;"/>
<input type="text" name="d2rod" id="d2rod" style="width:240px; top:619px; left:304px;"/>
<input type="checkbox" name="d2pomc" value="1" style="top:630px; left:561px;"/>
<input type="checkbox" name="d2pom1" value="1" style="top:630px; left:598px;"/>
<input type="checkbox" name="d2pom2" value="1" style="top:630px; left:623px;"/>
<input type="checkbox" name="d2pom3" value="1" style="top:630px; left:649px;"/>
<input type="checkbox" name="d2pom4" value="1" style="top:630px; left:674px;"/>
<input type="checkbox" name="d2pom5" value="1" style="top:630px; left:699px;"/>
<input type="checkbox" name="d2pom6" value="1" style="top:630px; left:724px;"/>
<input type="checkbox" name="d2pom7" value="1" style="top:630px; left:750px;"/>
<input type="checkbox" name="d2pom8" value="1" style="top:630px; left:775px;"/>
<input type="checkbox" name="d2pom9" value="1" style="top:630px; left:800px;"/>
<input type="checkbox" name="d2pom10" value="1" style="top:630px; left:826px;"/>
<input type="checkbox" name="d2pom11" value="1" style="top:630px; left:851px;"/>
<input type="checkbox" name="d2pom12" value="1" style="top:630px; left:877px;"/>

<input type="text" name="d3prie" id="d3prie" style="width:243px; top:663px; left:47px;"/>
<input type="text" name="d3rod" id="d3rod" style="width:240px; top:663px; left:304px;"/>
<input type="checkbox" name="d3pomc" value="1" style="top:674px; left:561px;"/>
<input type="checkbox" name="d3pom1" value="1" style="top:674px; left:598px;"/>
<input type="checkbox" name="d3pom2" value="1" style="top:674px; left:623px;"/>
<input type="checkbox" name="d3pom3" value="1" style="top:674px; left:649px;"/>
<input type="checkbox" name="d3pom4" value="1" style="top:674px; left:674px;"/>
<input type="checkbox" name="d3pom5" value="1" style="top:674px; left:699px;"/>
<input type="checkbox" name="d3pom6" value="1" style="top:674px; left:724px;"/>
<input type="checkbox" name="d3pom7" value="1" style="top:674px; left:750px;"/>
<input type="checkbox" name="d3pom8" value="1" style="top:674px; left:775px;"/>
<input type="checkbox" name="d3pom9" value="1" style="top:674px; left:800px;"/>
<input type="checkbox" name="d3pom10" value="1" style="top:674px; left:826px;"/>
<input type="checkbox" name="d3pom11" value="1" style="top:674px; left:851px;"/>
<input type="checkbox" name="d3pom12" value="1" style="top:674px; left:877px;"/>

<input type="text" name="d4prie" id="d4prie" style="width:243px; top:708px; left:47px;"/>
<input type="text" name="d4rod" id="d4rod" style="width:240px; top:708px; left:304px;"/>
<input type="checkbox" name="d4pomc" value="1" style="top:719px; left:561px;"/>
<input type="checkbox" name="d4pom1" value="1" style="top:719px; left:598px;"/>
<input type="checkbox" name="d4pom2" value="1" style="top:719px; left:623px;"/>
<input type="checkbox" name="d4pom3" value="1" style="top:719px; left:649px;"/>
<input type="checkbox" name="d4pom4" value="1" style="top:719px; left:674px;"/>
<input type="checkbox" name="d4pom5" value="1" style="top:719px; left:699px;"/>
<input type="checkbox" name="d4pom6" value="1" style="top:719px; left:724px;"/>
<input type="checkbox" name="d4pom7" value="1" style="top:719px; left:750px;"/>
<input type="checkbox" name="d4pom8" value="1" style="top:719px; left:775px;"/>
<input type="checkbox" name="d4pom9" value="1" style="top:719px; left:800px;"/>
<input type="checkbox" name="d4pom10" value="1" style="top:719px; left:826px;"/>
<input type="checkbox" name="d4pom11" value="1" style="top:719px; left:851px;"/>
<input type="checkbox" name="d4pom12" value="1" style="top:719px; left:877px;"/>
<input type="checkbox" name="det4" value="1" style="top:748px; left:85px;"/>

<!-- V. ODDIEL -->
<input type="text" name="r32" id="r32" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:941px; left:482px;"/>
<input type="text" name="r32a" id="r32a" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:981px; left:482px;"/>
<input type="text" name="r33" id="r33" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:1020px; left:551px;"/>
<input type="text" name="r33a" id="r33a" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:1060px; left:551px;"/>
<input type="text" name="r33b" id="r33b" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:1100px; left:551px;"/>
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:1140px; left:482px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:176px; top:1185px; left:551px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str3.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2013 3.strana 250kB" class="form-background">
<?php $tlacrdk="$hrdc / $hrdk"; if ( $tlacrdk == "0 / " ) { $tlacrdk=""; } ?>
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo "$tlacrdk"; ?>" disabled="disabled" class="nofill" style="width:242px; top:68px; left:357px;"/>

<!-- VI. ODDIEL -->
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:153px; left:477px;"/>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:193px; left:569px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="nezdanitelna();" title="Doplniù odpoËet na daÚovnÌka a zohæadniù milion·rsku daÚ" class="btn-row-tool" style="top:194px; left:736px;">
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:232px; left:569px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="namanzelku();" title="Doplniù odpoËet na manûelku a zohæadniù milion·rsku daÚ" class="btn-row-tool" style="top:233px; left:736px;">
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:272px; left:569px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:311px; left:569px;"/>
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:174px; top:352px; left:546px;"/>
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:395px; left:477px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:440px; left:477px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:483px; left:569px;"/>
<input type="text" name="r45" id="r45" style="width:35px; top:527px; left:616px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:567px; left:591px;"/>
 <img src="../obr/ikony/calculator_blue_icon.png" onclick="zamestnanecka();" title="Doplniù zamestnaneck˙ prÈmiu"
  class="btn-row-tool" style="top:568px; left:736px;">
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:608px; left:591px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:647px; left:477px;"/>
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:696px; left:477px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:748px; left:477px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:791px; left:477px;"/>
<input type="text" name="r52" id="r52" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:835px; left:477px;"/>
<input type="text" name="r53" id="r53" onkeyup="CiarkaNaBodku(this);" style="width:129px; top:879px; left:591px;"/>
<input type="text" name="r54" id="r54" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:923px; left:477px;"/>
<input type="text" name="r55" id="r55" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:970px; left:477px;"/>
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1009px; left:477px;"/>
<input type="text" name="r57" id="r57" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1047px; left:569px;"/>
<input type="text" name="r58" id="r58" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:1087px; left:477px;"/>
<input type="text" name="r59" id="r59" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1128px; left:569px;"/>
<input type="text" name="r60" id="r60" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1168px; left:569px;"/>
<input type="text" name="r61" id="r61" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1208px; left:569px;"/>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str4.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2014 4.strana 250kB" class="form-background">
<?php $tlacrdk="$hrdc / $hrdk"; if ( $tlacrdk == "0 / " ) { $tlacrdk=""; } ?>
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo "$tlacrdk"; ?>" disabled="disabled" class="nofill" style="width:242px; top:68px; left:357px;"/>

<!-- VI. ODDIEL pokracovanie -->
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:117px; left:569px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:157px; left:477px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:197px; left:477px;"/>
<input type="text" name="r65" id="r65" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:242px; left:477px;"/>
<input type="text" name="r66" id="r66" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:292px; left:477px;"/>

<!-- VII. ODDIEL -->
<input type="text" name="r67" id="r67" onkeyup="CiarkaNaBodku(this);" style="width:243px; top:740px; left:541px;"/>
<input type="text" name="r68" id="r68" onkeyup="CiarkaNaBodku(this);" style="width:265px; top:794px; left:519px;"/>
<input type="text" name="r69" id="r69" onkeyup="CiarkaNaBodku(this);" style="width:265px; top:843px; left:519px;"/>
<input type="text" name="r70" id="r70" onkeyup="CiarkaNaBodku(this);" style="width:265px; top:924px; left:519px;"/>
<input type="text" name="r71" id="r71" onkeyup="CiarkaNaBodku(this);" style="width:152px; top:1010px; left:632px;"/>
<input type="text" name="r72" id="r72" onkeyup="CiarkaNaBodku(this);" style="width:173px; top:1064px; left:611px;"/>
<input type="text" name="r73" id="r73" onkeyup="CiarkaNaBodku(this);" style="width:131px; top:1110px; left:653px;"/>
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:151px; top:1155px; left:633px;"/>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str5.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2014 5.strana 250kB" class="form-background">
<?php $tlacrdk="$hrdc / $hrdk"; if( $tlacrdk == "0 / " ) { $tlacrdk=""; } ?>
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo "$tlacrdk"; ?>" disabled="disabled" class="nofill" style="width:242px; top:68px; left:357px;"/>

<!-- VIII. ODDIEL -->
<input type="checkbox" name="upl50" value="1" style="top:160px; left:59px;"/>
<input type="checkbox" name="spln3" value="1" style="top:160px; left:294px;"/>
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:203px; left:316px;"/>
<!-- Prijimatel -->
<input type="text" name="pico" id="pico" style="width:175px; top:285px; left:51px;"/>
<input type="text" name="psid" id="psid" style="width:83px; top:285px; left:258px;"/>
<input type="text" name="pfor" id="pfor" style="width:520px; top:285px; left:373px;"/>
<input type="text" name="pmen" id="pmen" style="width:842px; top:339px; left:51px;"/>
<input type="text" name="puli" id="puli" style="width:635px; top:449px; left:51px;"/>
<input type="text" name="pcdm" id="pcdm" style="width:175px; top:449px; left:718px;"/>
<input type="text" name="ppsc" id="ppsc" style="width:106px; top:500px; left:51px;"/>
<input type="text" name="pmes" id="pmes" style="width:703px; top:500px; left:190px;"/>

<!-- IX. ODDIEL -->
<input type="checkbox" name="uoso" value="1" style="top:615px; left:58px;"/>
<input type="text" name="pzks1" id="pzks1" style="width:61px; top:718px; left:51px;"/>
<input type="text" name="pzpr1" id="pzpr1" onkeyup="CiarkaNaBodku(this);" style="width:231px; top:718px; left:135px;"/>
<input type="text" name="pzvd1" id="pzvd1" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:718px; left:389px;"/>
<input type="text" name="pzks2" id="pzks2" style="width:61px; top:758px; left:51px;"/>
<input type="text" name="pzpr2" id="pzpr2" onkeyup="CiarkaNaBodku(this);" style="width:231px; top:758px; left:135px;"/>
<input type="text" name="pzvd2" id="pzvd2" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:758px; left:389px;"/>
<input type="text" name="pzks3" id="pzks3" style="width:61px; top:799px; left:51px;"/>
<input type="text" name="pzpr3" id="pzpr3" onkeyup="CiarkaNaBodku(this);" style="width:231px; top:799px; left:135px;"/>
<input type="text" name="pzvd3" id="pzvd3" onkeyup="CiarkaNaBodku(this);" style="width:162px; top:799px; left:389px;"/>
<textarea name="osob" id="osob" style="width:838px; height:351px; top:879px; left:53px;"><?php echo $osob; ?></textarea>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str6.jpg" alt="tlaËivo DaÚ z prÌjmov FO typ A pre rok 2014 6.strana 250kB" class="form-background">
<?php $tlacrdk="$hrdc / $hrdk"; if ( $tlacrdk == "0 / " ) { $tlacrdk=""; } ?>
<input type="text" name="fir_fdic" id="fir_fdic" value="<?php echo "$tlacrdk"; ?>" disabled="disabled" class="nofill" style="width:242px; top:68px; left:357px;"/>

<!-- X. ODDIEL -->
<input type="text" name="sdnr" id="sdnr" style="width:842px; top:176px; left:51px;"/>
<input type="text" name="udnr" id="udnr" onkeyup="CiarkaNaBodku(this);" style="width:245px; top:217px; left:648px;"/>
<input type="text" name="pril" id="pril" style="width:35px; top:311px; left:179px;"/>
<input type="text" name="dat" id="dat" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:383px; left:277px;"/>

<!-- XI. ODDIEL -->
<input type="checkbox" name="zdbo" value="1" style="top:496px; left:59px;"/>
<input type="checkbox" name="zpre" value="1" style="top:529px; left:59px;"/>
<input type="checkbox" name="zprp" value="1" style="top:563px; left:59px;"/>
<input type="checkbox" name="post" value="1" onchange="klikpost();" style="top:602px; left:116px;"/>
<script type="text/javascript">
  function klikpost()
  {
   document.formv1.ucet.checked = false;
  }
  function klikucet()
  {
   document.formv1.post.checked = false;
  }
</script>
<?php if ( $post == 1 ) { ?>
 <script type="text/javascript">document.formv1.post.checked = "checked";</script>
<?php                   } ?>
<input type="checkbox" name="ucet" value="1" onchange="klikucet();" style="top:602px; left:323px;"/>
<?php if ( $ucet == 1 ) { ?>
 <script type="text/javascript">document.formv1.ucet.checked = "checked";</script>
<?php                   } ?>

<input type="text" name="diban" id="diban" style="width:773px; top:634px; left:116px;"/>
<input type="text" name="uceb" id="uceb" style="width:381px; top:688px; left:59px;"/>
<input type="text" name="numb" id="numb" style="width:81px; top:688px; left:482px;"/>
<input type="text" name="da2" id="da2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:748px; left:116px;"/>

<!-- XII. ODDIEL -->
<textarea name="pomv" id="pomv" style="width:838px; height:373px; top:862px; left:53px;"><?php echo $pomv; ?></textarea>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav udaje
?>


<?php
/////////////////////////////////////////////////VYTLAC ROCNE
if ( $copern == 10 )
{
if ( File_Exists("../tmp/priznaniefoa.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/priznaniefoa.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa".
" WHERE F$kli_vxcf"."_mzdpriznanie_foa.oc = $cislo_oc AND konx1 = 0 ORDER BY oc";

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
$dat_dat = SkDatum($hlavicka->da21 );
if ( $dat_dat == '0000-00-00' ) $dat_dat="";

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//rodne cislo
$pdf->Cell(190,45," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//datum narodenia
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text="01012010";
$text=SKDatum($hlavicka->dar);
if ( $text =='00.00.0000' OR $hlavicka->nrz == 0 ) $text="";
$pole = explode(".", $text);
$text=$pole[0].$pole[1].$pole[2];
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//druh priznania
$riadne="x"; $opravne=""; $dodat="";
if ( $hlavicka->druh == 2 ) { $riadne=""; $opravne="x"; $dodatocne=""; }
if ( $hlavicka->druh == 3 ) { $riadne=""; $opravne=""; $dodatocne="x"; }
$pdf->SetY(56);
$pdf->Cell(90,5," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadne","$rmc",1,"L");
$pdf->SetY(61);
$pdf->Cell(90,5," ","$rmc1",0,"C");$pdf->Cell(3,4,"$opravne","$rmc",1,"L");
$pdf->SetY(66);
$pdf->Cell(90,5," ","$rmc1",0,"C");$pdf->Cell(3,5,"$dodatocne","$rmc",1,"L");

//za rok
$rokp=$kli_vrok;
$t01=substr($rokp,2,1);
$t02=substr($rokp,3,1);
$pdf->SetY(51);
$pdf->Cell(175,6," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",1,"L");

//datum dodatocneho
$pdf->SetY(68);
$text="";
if ( $hlavicka->druh == 3 ) $text=SkDatum($hlavicka->ddp);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(145,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//priezvisko FO
$pdf->Cell(190,15,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOP";
$text=$hlavicka->dprie;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");

//meno FO
$pdf->Cell(3,6,"                          ","$rmc1",0,"L");
$text="ABCDEFGHIJK";
$text=$hlavicka->dmeno;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t11","$rmc",0,"C");

//titul pred a za FO
$pdf->Cell(4,6,"                          ","$rmc1",0,"L");
$pdf->Cell(26,6,"$hlavicka->dtitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->dtitz","$rmc",1,"C");

//Adresa trvaleho pobytu
//ulica
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->duli;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo
$text="ABCDEFGH";
$text=$hlavicka->dcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->dpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec
$text="ABCDEFGHIJKLMNOPRSTU";
$text=$hlavicka->dmes;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");

//stat
$pdf->Cell(4,6,"                          ","$rmc1",0,"L");
$text=$hlavicka->xstat;
if ( $text == '' ) $text="SR";
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
$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");
$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//nerezident
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$nrzx=" ";
if ( $hlavicka->nrz == 1 ) { $nrzx="x"; }
$pdf->Cell(120,6," ","$rmc1",0,"C");$pdf->Cell(4,3,"$nrzx","$rmc",1,"C");

//Adresa pobytu na uzemi
//ulica2
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->d2uli;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");

//cislo2
$text="01234567";
$text=$hlavicka->d2cdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc2
$pdf->Cell(191,5,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->d2psc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec2
$text="ABCDEFGHIJKLMNOPRSTU";
$text=$hlavicka->d2mes;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",1,"C");

//ZASTUPCA
//priezvisko
$pdf->Cell(195,18,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOP";
$text=$hlavicka->zprie;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");

//meno
$pdf->Cell(3,6,"                          ","$rmc1",0,"L");
$text="ABCDEFGHIJK";
$text=$hlavicka->zmeno;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t11","$rmc",0,"C");

//titul pred a za
$pdf->Cell(4,6,"                          ","$rmc1",0,"L");
$text="ABCDEFGHI";
$pdf->Cell(26,6,"$hlavicka->ztitl","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(16,6,"$hlavicka->ztitz","$rmc",1,"C");

//rodne cislo
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->zrdc.$hlavicka->zrdk;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");

//ulica
$text="ABCDEFGHIJKLMNOP";
$text=$hlavicka->zuli;
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
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");

//cislo
$text="ABCDEFGHIJKLMNOP";
$text=$hlavicka->zcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->zpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");

//obec
$text="ABCDEFGHIJKLMNO";
$text=$hlavicka->zmes;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");

//stat
$text="ABCDEFGHIJK";
$text=$hlavicka->zstat;
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
$pdf->Cell(4,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//cislo telefonu FO
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="12345678910";
$text=$hlavicka->dtel;
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
$pdf->Cell(3,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t13","$rmc",0,"C");

//email/fax FO
$text="12345678910";
$text=$hlavicka->dmailfax;
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(115,7,"$text","$rmc",1,"L");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//rodne cislo / dic
$pdf->Cell(195,0,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(71,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//III. ODDIEL
//27 poberanie dochodkov
$pdf->Cell(195,33,"                          ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->r27 == 0 ) $text=" ";
$pdf->Cell(157,7," ","$rmc1",0,"L");$pdf->Cell(4,4,"$text","$rmc",1,"C");

//28 uhr. suma dochodkov
$pdf->Cell(195,7,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r28;
if ( $hlavicka->r27 == 0 ) $hodx="";
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(147,7," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(7,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",1,"C");

//29 priezvisko manzelky
$pdf->Cell(195,13,"                          ","$rmc1",1,"L");
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(76,6,"$hlavicka->mprie","$rmc",0,"L");

//rodne cislo manzelky
$text="0123456789";
$text=$hlavicka->mrod;
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
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//vlastne prijmy manzelky
$text="012345";
$hodx=100*$hlavicka->mpri;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//29 pocet mesiacov
$hodx="01";
$hodx=$hlavicka->mpom;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//IV. ODDIEL - danovy bonus
//dieta 1 priezvisko
$pdf->Cell(195,39,"                          ","$rmc1",1,"L");
$text=$hlavicka->d1prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(55,6,"$text","$rmc",0,"L");

//rodne cislo 1
$pdf->Cell(2,6,"                          ","$rmc1",0,"L");
$text="0123456789";
$text=$hlavicka->d1rod;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//v mesiacoch 1
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d1pom1 == 1 ) $t01="x";
if ( $hlavicka->d1pom2 == 1 ) $t02="x";
if ( $hlavicka->d1pom3 == 1 ) $t03="x";
if ( $hlavicka->d1pom4 == 1 ) $t04="x";
if ( $hlavicka->d1pom5 == 1 ) $t05="x";
if ( $hlavicka->d1pom6 == 1 ) $t06="x";
if ( $hlavicka->d1pom7 == 1 ) $t07="x";
if ( $hlavicka->d1pom8 == 1 ) $t08="x";
if ( $hlavicka->d1pom9 == 1 ) $t09="x";
if ( $hlavicka->d1pom10 == 1 ) $t10="x";
if ( $hlavicka->d1pom11 == 1 ) $t11="x";
if ( $hlavicka->d1pom12 == 1 ) $t12="x";
if ( $hlavicka->d1pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(3,9,"$tc","$rmc",0,"C");
$pdf->Cell(5,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t01","$rmc",0,"C");$pdf->Cell(2,19," ","$rmc1",0,"C");$pdf->Cell(4,9,"$t02","$rmc",0,"C");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t03","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t04","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t05","$rmc",0,"L");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t06","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t07","$rmc",0,"C");$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t08","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t09","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t10","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t11","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t12","$rmc",1,"R");

//dieta 2 priezvisko
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text=$hlavicka->d2prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(55,6,"$text","$rmc",0,"L");

//rodne cislo 2
$pdf->Cell(2,7,"                          ","$rmc1",0,"L");
$text="0123456789";
$text=$hlavicka->d2rod;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//v mesiacoch 2
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d2pom1 == 1 ) $t01="x";
if ( $hlavicka->d2pom2 == 1 ) $t02="x";
if ( $hlavicka->d2pom3 == 1 ) $t03="x";
if ( $hlavicka->d2pom4 == 1 ) $t04="x";
if ( $hlavicka->d2pom5 == 1 ) $t05="x";
if ( $hlavicka->d2pom6 == 1 ) $t06="x";
if ( $hlavicka->d2pom7 == 1 ) $t07="x";
if ( $hlavicka->d2pom8 == 1 ) $t08="x";
if ( $hlavicka->d2pom9 == 1 ) $t09="x";
if ( $hlavicka->d2pom10 == 1 ) $t10="x";
if ( $hlavicka->d2pom11 == 1 ) $t11="x";
if ( $hlavicka->d2pom12 == 1 ) $t12="x";
if ( $hlavicka->d2pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(3,9,"$tc","$rmc",0,"C");
$pdf->Cell(5,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t01","$rmc",0,"C");$pdf->Cell(2,19," ","$rmc1",0,"C");$pdf->Cell(4,9,"$t02","$rmc",0,"C");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t03","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t04","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t05","$rmc",0,"L");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t06","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t07","$rmc",0,"C");$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t08","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t09","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t10","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t11","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t12","$rmc",1,"R");

//dieta 3 priezvisko
$pdf->Cell(195,1,"                          ","$rmc1",1,"L");
$text=$hlavicka->d3prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(55,6,"$text","$rmc",0,"L");

//rodne cislo 3
$pdf->Cell(2,8,"                          ","$rmc1",0,"L");
$text="0123456789";
$text=$hlavicka->d3rod;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//v mesiacoch 3
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d3pom1 == 1 ) $t01="x";
if ( $hlavicka->d3pom2 == 1 ) $t02="x";
if ( $hlavicka->d3pom3 == 1 ) $t03="x";
if ( $hlavicka->d3pom4 == 1 ) $t04="x";
if ( $hlavicka->d3pom5 == 1 ) $t05="x";
if ( $hlavicka->d3pom6 == 1 ) $t06="x";
if ( $hlavicka->d3pom7 == 1 ) $t07="x";
if ( $hlavicka->d3pom8 == 1 ) $t08="x";
if ( $hlavicka->d3pom9 == 1 ) $t09="x";
if ( $hlavicka->d3pom10 == 1 ) $t10="x";
if ( $hlavicka->d3pom11 == 1 ) $t11="x";
if ( $hlavicka->d3pom12 == 1 ) $t12="x";
if ( $hlavicka->d3pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(3,9,"$tc","$rmc",0,"C");
$pdf->Cell(5,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t01","$rmc",0,"C");$pdf->Cell(2,19," ","$rmc1",0,"C");$pdf->Cell(4,9,"$t02","$rmc",0,"C");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t03","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t04","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t05","$rmc",0,"L");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t06","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t07","$rmc",0,"C");$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t08","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t09","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t10","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t11","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,9,"$t12","$rmc",1,"R");

//dieta 4 priezvisko
$pdf->Cell(195,2,"                          ","$rmc1",1,"L");
$text=$hlavicka->d4prie;
$pdf->Cell(2,7," ","$rmc1",0,"R");$pdf->Cell(55,6,"$text","$rmc",0,"L");

//rodne cislo 4
$pdf->Cell(2,8,"                          ","$rmc1",0,"L");
$text="0123456789";
$text=$hlavicka->d4rod;
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
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//v mesiacoch 4
$tc=" "; $t01=""; $t02=""; $t03=""; $t04=""; $t05=""; $t06=""; $t07=""; $t08=""; $t09=""; $t10=""; $t11=""; $t12="";
if ( $hlavicka->d4pom1 == 1 ) $t01="x";
if ( $hlavicka->d4pom2 == 1 ) $t02="x";
if ( $hlavicka->d4pom3 == 1 ) $t03="x";
if ( $hlavicka->d4pom4 == 1 ) $t04="x";
if ( $hlavicka->d4pom5 == 1 ) $t05="x";
if ( $hlavicka->d4pom6 == 1 ) $t06="x";
if ( $hlavicka->d4pom7 == 1 ) $t07="x";
if ( $hlavicka->d4pom8 == 1 ) $t08="x";
if ( $hlavicka->d4pom9 == 1 ) $t09="x";
if ( $hlavicka->d4pom10 == 1 ) $t10="x";
if ( $hlavicka->d4pom11 == 1 ) $t11="x";
if ( $hlavicka->d4pom12 == 1 ) $t12="x";
if ( $hlavicka->d4pomc == 1 ) { $tc="x"; $t01=" "; $t02=" "; $t03=" "; $t04=" "; $t05=" "; $t06=" "; $t07=" "; $t08=" "; $t09=" "; $t10=" "; $t11=" "; $t12=" "; }
$pdf->Cell(4,6," ","$rmc1",0,"L");$pdf->Cell(3,8,"$tc","$rmc",0,"C");
$pdf->Cell(5,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t01","$rmc",0,"C");$pdf->Cell(2,19," ","$rmc1",0,"C");$pdf->Cell(4,8,"$t02","$rmc",0,"C");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t03","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t04","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t05","$rmc",0,"L");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t06","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t07","$rmc",0,"C");$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t08","$rmc",0,"C");
$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t09","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t10","$rmc",0,"R");
$pdf->Cell(2,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t11","$rmc",0,"C");$pdf->Cell(3,9," ","$rmc1",0,"C");$pdf->Cell(3,8,"$t12","$rmc",1,"R");

//31 uplatnujem 4 deti
$pdf->Cell(197,0,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->det4 == 1 ) $text="x";
$pdf->Cell(11,5," ","$rmc1",0,"R");$pdf->Cell(4,5,"$text","$rmc",1,"C");

//V. ODDIEL
//polozka32
$pdf->Cell(195,40,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r32;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka32a)
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r32a;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka33
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r33;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka33a)
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r33a;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka33b)
$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r33b;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka34
$pdf->Cell(192,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r34;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka35
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456";
$hodx=100*$hlavicka->r35;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(99,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//rodne cislo / dic
$pdf->Cell(190,0,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(71,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//VI. ODDIEL
//polozka36
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r36;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka37
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r37;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka38
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r38;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka39
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r39;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka40
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r40;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(113,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"R");

//polozka41
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r41;
if ( $hodx == 0 ) $hodx="000";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka42
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="01234";
$hodx=100*$hlavicka->r42;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka43
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r43;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka44
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$hodx=$hlavicka->r44;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(128,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"L");

//polozka45
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="01234";
$hodx=100*$hlavicka->r45;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"R");

//polozka46
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r46;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"L");

//polozka47
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r47;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka48
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r48;
if( $hodx == 0 ) $hodx="000";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka49
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r49;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka50
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r50;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka51
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="01234";
$hodx=100*$hlavicka->r51;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka52
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r52;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 5s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(123,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"L");

//polozka53
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r53;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka54
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r54;
if ( $hodx == 0 ) $hodx=" ";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka55
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r55;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka56
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r56;
if ( $hodx == 0 ) $hodx=" ";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka57
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r57;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka58
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r58;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka59
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r59;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka60
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r60;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka61
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r61;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 6s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(118,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");
                                       } //koniec 3.strany

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str4.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//rodne cislo / dic
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(71,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//polozka62
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r62;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka63
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r63;
$text=sprintf("% 10s",$hodx);
if ( $text == 0 ) $text="";
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka64
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r64;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka65
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r65;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(98,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//VII. ODDIEL
//polozka66
$pdf->Cell(190,81,"                          ","$rmc1",1,"L");
$text="0123456789";
$hodx=100*$hlavicka->r66;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; }
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
$pdf->Cell(112,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//polozka67
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="+0123456789";
$hodx=100*$hlavicka->r67;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; $znamienko=" "; }
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
$text=$znamienko.$text;
if ( $hlavicka->druh != 3 ) { $text = ""; }
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
$pdf->Cell(107,6," ","$rmc1",0,"R");$pdf->Cell(3,7,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"R");

//polozka68
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="+0123456789";
$hodx=100*$hlavicka->r68;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; $znamienko=" "; }
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
$text=$znamienko.$text;
if ( $hlavicka->druh != 3 ) { $text = ""; }
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
$pdf->Cell(107,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"R");

//polozka69
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text="012345";
$hodx=100*$hlavicka->r69;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; $znamienko=" "; }
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 10s",$hodx);
$text=$znamienko.$text;
if ( $hlavicka->druh != 3 ) { $text = ""; }
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
$pdf->Cell(107,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$t01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"R");

//polozka70
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r70;
if ( $hodx == 0 ) { $hodx="";  }
$text=sprintf("% 6s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(132,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka71
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r71;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; $znamienko=" "; }
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 6s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; $znamienko=" "; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(127,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//polozka72
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r72;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; }
$text=sprintf("% 5s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"C");

//polozka73
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="-012345";
$hodx=100*$hlavicka->r73;
$znamienko="+";
if ( $hodx == 0 ) { $hodx=""; $znamienko=" "; }
if ( $hodx < 0 ) { $hodx=-$hodx; $znamienko="-"; }
$text=sprintf("% 5s",$hodx);
if ( $hlavicka->druh != 3 ) { $text = ""; $znamienko=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(132,6," ","$rmc1",0,"R");$pdf->Cell(3,6,"$znamienko","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",1,"L");
                                       } //koniec 4.strany

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str5.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str5.jpg',0,0,210,297);
}
$pdf->SetY(8);

//rodne cislo / dic
$pdf->Cell(190,2,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(71,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//VIII. ODDIEL
//krizik neuplatnujem postup
$pdf->Cell(191,13,"                          ","$rmc1",1,"L");
$text="x";
if ( $hlavicka->upl50 == 0 ) $text=" ";
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text","$rmc",0,"C");

//krizik splnam 3%
$text="x";
if ( $hlavicka->spln3 == 0 ) $text=" ";
$pdf->Cell(48,6," ","$rmc1",0,"R");$pdf->Cell(5,4,"$text","$rmc",1,"C");

//polozka74
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$text="01234567";
$hodx=100*$hlavicka->r74;
if ( $hodx == 0 ) $hodx="";
if ( $hlavicka->upl50 == 1 ) $hodx="";
if ( $hlavicka->druh == 3 ) $hodx="";
$text=sprintf("% 8s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(62,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"L");

//Prijimatel
//75ico/sid
$pdf->Cell(195,13,"                          ","$rmc1",1,"L");
$text="0123456789xy";
$text=$hlavicka->pico;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$text=$hlavicka->psid;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
$t09=substr($text,0,1);
$t10=substr($text,1,1);
$t11=substr($text,2,1);
$t12=substr($text,3,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");

//75pravna forma
$text="ABCDEFGHIJKLMNOPRSTUVXY";
$text=$hlavicka->pfor;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
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
$pdf->Cell(7,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",1,"C");

//75obchodne meno
$pdf->Cell(195,6,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZW+-1234567890";
$text=$hlavicka->pmen;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t37","$rmc",1,"C");

$pdf->Cell(195,3,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZW+-1234567890";
$text="";
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t37","$rmc",1,"C");

//75ulica
$pdf->Cell(195,10,"                          ","$rmc1",1,"L");
$text="ABCDEFGHIJKLMNOPRSTUVXYZW+-1";
$text=$hlavicka->puli;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");

//75cislo
$pdf->Cell(2,7,"                          ","$rmc1",0,"L");
$text="12345678";
$text=$hlavicka->pcdm;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//75psc
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="12345";
$text=$hlavicka->ppsc;
$text=str_replace(" ","",$text);
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//75obec
$text="ABCDEFGHIJKLMNOPRSTUVXY12345678";
$text=$hlavicka->pmes;
if ( $hlavicka->upl50 == 1 ) $text="";
if ( $hlavicka->druh == 3 ) $text="";
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
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//IX. ODDIEL
//krizik uvadzam osobitne zaznamy
$pdf->Cell(190,20,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->uoso == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//prijmy rezidenta
//kod statu 1
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks1;
if ( $hlavicka->nrz != 1 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//prijmy 1
$text="0123456789";
$hodx=100*$hlavicka->pzpr1;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky1
$text="0123456789";
$hodx=100*$hlavicka->pzvd1;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu 2
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks2;
if ( $hlavicka->nrz != 1 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//prijmy 2
$text="0123456789";
$hodx=100*$hlavicka->pzpr2;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky2
$text="0123456789";
$hodx=100*$hlavicka->pzvd2;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//kod statu 3
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text=$hlavicka->pzks3;
if ( $hlavicka->nrz != 1 ) $text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(3,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"R");

//prijmy 3
$text="0123456789";
$hodx=100*$hlavicka->pzpr3;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");

//vydavky3
$text="0123456789";
$hodx=100*$hlavicka->pzvd3;
if ( $hodx == 0 OR $hlavicka->nrz != 1 ) $hodx="";
$text=sprintf("% 7s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",1,"C");

//IX. ODDIEL
//osobitne zaznamy
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
if ( $hlavicka->uoso == 0 ) $hlavicka->osob="";
$poleosob = explode("\r\n", $hlavicka->osob);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }
                                       } //koniec 5.strany

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str6.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/dpfoa_v14_str6.jpg',0,0,210,297);
}
$pdf->SetY(10);

//rodne cislo / dic
$pdf->Cell(185,0,"                          ","$rmc1",1,"L");
$text="0123456789";
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(71,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//X. ODDIEL
//76 stat danovej rezidencie
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$text=$hlavicka->sdnr;
if ( $hlavicka->nrz == 0 ) $text="";
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
$t35=substr($text,34,1);
$t36=substr($text,35,1);
$t37=substr($text,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t35","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t36","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t37","$rmc",1,"C");

//polozka77
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$text="+0123456789";
$hodx=100*$hlavicka->udnr;
if ( $hodx == 0 OR $hlavicka->nrz == 0 ) $hodx="";
$text=sprintf("% 10s",$hodx);
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
$pdf->Cell(136,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"R");

//78pocet priloh
$pdf->Cell(190,16,"                          ","$rmc1",1,"L");
$text="12";
$hodx=$hlavicka->pril;
if ( $hodx == 0 ) $hodx="";
$text=sprintf("% 2s",$hodx);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(32,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"L");

//datum vyhlasujem
$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$text="123456";
$text=SKDatum($hlavicka->dat);
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
$pdf->Cell(53,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//XI.ODDIEL
//krizik ziadam o dan bonus
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zdbo == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text","$rmc",1,"C");

//krizik ziadam zam.premia
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zpre == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//krizik ziadam vrat. preplatku
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zprp == 1 ) $text="x";
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$text","$rmc",1,"C");

if ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 AND $hlavicka->zprp == 0 )
{
$hlavicka->ucet="0";
$hlavicka->post="0";
$hlavicka->da2="";
}
//postovou poukazkou ci na ucet
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$textp=" ";
if ( $hlavicka->post == 1 ) $textp="x";
$textb=" ";
if ( $hlavicka->ucet == 1 ) $textb="x";
$pdf->Cell(18,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$textp","$rmc",0,"L");$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(4,4,"$textb","$rmc",1,"L");

//iban
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->ucet == 1 ) $text=$hlavicka->diban;
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t32","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t33","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t34","$rmc",1,"C");

//cislo uctu
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text="SK0123456789+-ab";
$text=$hlavicka->uceb;
if ( $hlavicka->ucet == 0 ) $text="";
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t09","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t11","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"L");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t17","$rmc",0,"R");

//kod banky
$text="0123";
$text=$hlavicka->numb;
if ( $hlavicka->ucet == 0 ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"L");

//datum2
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$text="123456";
$text=SKDatum($hlavicka->da2);
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
$pdf->Cell(18,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"R");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"R");

//XII. ODDIEL
//pomocne vypocty
$pdf->Cell(190,20,"                          ","$rmc1",1,"L");
$polepomv = explode("\r\n", $hlavicka->pomv);
if ( $polepomv[0] != '' )
     {
$ipole=1;
foreach( $polepomv as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }
                                       } //koniec 6.strany
  }
$i = $i + 1;
  }
$pdf->Output("../tmp/priznaniefoa.$kli_uzid.pdf");

//potvrdenie o podani
if ( $copern == 10 )
     {
if ( File_Exists("../tmp/potvrdfoa$kli_vume.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdfoa$kli_vume.$kli_uzid.pdf"); }
$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );

$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(13);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dpfoa2014/FOAv13_potvrdenie.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dpfoa2014/FOAv13_potvrdenie.jpg',0,0,210,297);
}
$pdf->SetY(10);

//za rok
$pdf->Cell(190,25,"                          ","$rmc1",1,"L");
$pdf->Cell(82,6," ","$rmc1",0,"C");$pdf->Cell(34,6,"$kli_vrok","$rmc",1,"C");

//priezvisko
$pdf->Cell(190,30,"                          ","$rmc1",1,"L");
$text=$hlavicka->dprie;
$pdf->Cell(11,7," ","$rmc1",0,"L");$pdf->Cell(141,6,"$text","$rmc",1,"L");

//meno
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text=$hlavicka->dmeno;
$pdf->Cell(11,7," ","$rmc1",0,"R");$pdf->Cell(46,7,"$text","$rmc",0,"L");

//rodne cislo
$text=$hlavicka->rdc.$hlavicka->rdk;
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
$pdf->Cell(25,8," ","$rmc1",0,"R");$pdf->Cell(7,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");$pdf->Cell(7,7,"$C","$rmc",0,"C");
$pdf->Cell(7,7,"$D","$rmc",0,"C");$pdf->Cell(7,7,"$E","$rmc",0,"C");$pdf->Cell(7,7,"$F","$rmc",0,"C");$pdf->Cell(7,7,"$G","$rmc",0,"C");
$pdf->Cell(7,7,"$H","$rmc",0,"C");$pdf->Cell(7,7,"$I","$rmc",0,"C");$pdf->Cell(7,7,"$J","$rmc",1,"C");

//ulica
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(141,7,"$hlavicka->duli $hlavicka->dcdm","$rmc",1,"L");

//psc a obec
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(26,5,"$hlavicka->dpsc","$rmc",0,"L");$pdf->Cell(20,6," ","$rmc1",0,"L");$pdf->Cell(95,5,"$hlavicka->dmes","$rmc",1,"L");

//stat
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$pdf->Cell(11,6," ","$rmc1",0,"L");$pdf->Cell(46,6,"SR","$rmc",1,"L");

//udaje o danovom priznani
$pdf->Cell(190,30,"                          ","$rmc1",1,"L");
$r40=$hlavicka->r40; if ( $r40 == 0 ) $r40="";
$r44=$hlavicka->r44; if ( $r44 == 0 ) $r44="";
$r63=$hlavicka->r63;
$r64=$hlavicka->r64;
if ( $r63 == 0 AND $r64 == 0 ) { $r63="0"; $r64=""; }
if ( $r63 != 0 AND $r64 == 0 ) { $r64=""; }
if ( $r63 == 0 AND $r64 != 0 ) { $r63=""; }
$pdf->Cell(122,6," ","$rmc1",0,"L");$pdf->Cell(50,6,"$r40","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(122,6," ","$rmc1",0,"L");$pdf->Cell(50,6,"$r44","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(122,6," ","$rmc1",0,"L");$pdf->Cell(50,6,"$r63","$rmc",1,"R");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(122,6," ","$rmc1",0,"L");$pdf->Cell(50,7,"$r64","$rmc",1,"R");

$pdf->Output("../tmp/potvrdfoa$kli_vxcf.$kli_uzid.pdf");
     }
//koniec potvrdenia o podani
?>

<script type="text/javascript">
  var okno = window.open("../tmp/priznaniefoa.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>

<?php
$cislista = include("mzd_lista_norm.php");
} while (false);
// celkovy koniec dokumentu
?>
</BODY>
</HTML>