<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$mesiac=$kli_vmes;
$vyb_ump="1.".$kli_vrok; $vyb_umk=$kli_vmes.".".$kli_vrok;

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;
if ( $copern == 1 ) { $copern=2; };


//prepnute z uobrat.php modul 512 odpocitaj predchadzajuce mesiace
if ( $modul == 512 )
{
$r512r01=0;$r512r02=0;$r512r03=0;$r512r04=0;$r512r99=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r512r01=$r512r01+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 343 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r512r02=$r512r02+$polozka->odl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 521 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r512r04=$r512r04+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE pom = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r512r03=$r512r03+1; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET ".
" mod512r01='$r512r01',mod512r03='$r512r03',mod512r04='$r512r04' ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

//odpocitam minule archivovane
if( $mesiac > 1 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 1 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 2 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 2 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 3 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 3 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 4 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 4 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 5 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 5 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 6 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 6 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 7 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 7 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 8 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 8 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 9 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 9 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 10 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 10 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}
if( $mesiac > 11 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112,F$kli_vxcf"."_statistika_vts112arch SET ".
" F$kli_vxcf"."_statistika_vts112.mod512r01=F$kli_vxcf"."_statistika_vts112.mod512r01-F$kli_vxcf"."_statistika_vts112arch.mod512r01, ".
" F$kli_vxcf"."_statistika_vts112.mod512r04=F$kli_vxcf"."_statistika_vts112.mod512r04-F$kli_vxcf"."_statistika_vts112arch.mod512r04  ".
" WHERE F$kli_vxcf"."_statistika_vts112arch.psys = 11 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
}


if( $fir_uctx01 > 0 ) {
$xdph="0.".$fir_dph2;
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET ".
" mod512r02='$xdph'*mod512r01  WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt"); 
                      }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET ".
" mod512r99=mod512r01+mod512r02+mod512r03+mod512r04 WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$strana=2;
//exit;
}
//koniec odpocitaj modul 512 z uobrat.php


//pracovny subor statistika_vts112
$sql = "SELECT * FROM F$kli_vxcf"."_statistika_vts112 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_vts112';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_vts112
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(80) NOT NULL,
   mod512r01     DECIMAL(10,0) DEFAULT 0,
   mod512r02     DECIMAL(10,0) DEFAULT 0,
   mod512r03     DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statistika_vts112;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_vts112'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_vts112 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_vts112 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD mod2r02 VARCHAR(10) NOT NULL AFTER mod512r03";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD mod2r01 VARCHAR(10) NOT NULL AFTER mod512r03";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD mod512r04 DECIMAL(10,0) DEFAULT 0 AFTER mod512r03";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD aktivita VARCHAR(10) NOT NULL AFTER cinnost";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD mod512r99 DECIMAL(10,0) DEFAULT 0 AFTER mod512r04";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts112 ADD odoslane DATE AFTER aktivita";
$vysledek = mysql_query("$sql");
}
//koniec pracovny subor


//zapis upravene udaje
if ( $copern == 3 )
    {
$cinnost = strip_tags($_REQUEST['cinnost']);
$aktivita = strip_tags($_REQUEST['aktivita']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$mod512r01 = strip_tags($_REQUEST['mod512r01']);
$mod512r02 = strip_tags($_REQUEST['mod512r02']);
$mod512r03 = strip_tags($_REQUEST['mod512r03']);
$mod512r04 = strip_tags($_REQUEST['mod512r04']);
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);
$uprav="NO";
$odoslane_sql=SqlDatum($odoslane);

if( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET ".
" aktivita='$aktivita', odoslane='$odoslane_sql', cinnost='$cinnost' ".
" WHERE ico >= 0"; }

if( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET ".
" mod512r01='$mod512r01',mod512r02='$mod512r02',mod512r03='$mod512r03',mod512r04='$mod512r04', ".
" mod2r01='$mod2r01',mod2r02='$mod2r02', ".
" mod512r99=mod512r01+mod512r02+mod512r03+mod512r04 ".
" WHERE ico >= 0"; }

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=2;
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


//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_vts112 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$cinnost = $fir_riadok->cinnost;
$aktivita = $fir_riadok->aktivita;
$odoslane_sk = SkDatum($fir_riadok->odoslane);
$mod512r01 = $fir_riadok->mod512r01;
$mod512r02 = $fir_riadok->mod512r02;
$mod512r03 = $fir_riadok->mod512r03;
$mod512r04 = $fir_riadok->mod512r04;
$mod512r99 = $fir_riadok->mod512r99;
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;

mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//kod okresu z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v˝kaz VTS 1-12</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
a.archiv-link {
  float: left;
  padding: 6px 5px 5px 5px !important;
  color: #39f !important;
  font-weight: bold;
}
</style>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 2 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.cinnost.value = '<?php echo "$cinnost";?>';
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
   document.formv1.aktivita.value = '<?php echo "$aktivita";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
    document.formv1.mod512r01.value = '<?php echo "$mod512r01";?>';
    document.formv1.mod512r02.value = '<?php echo "$mod512r02";?>';
    document.formv1.mod512r03.value = '<?php echo "$mod512r03";?>';
    document.formv1.mod512r04.value = '<?php echo "$mod512r04";?>';
    document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
    document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php                     } ?>
    }
<?php
//koniec uprava
  }
?>


<?php
//nie uprava
  if ( $copern != 2 AND $copern != 102 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('../dokumenty/statistika2014/vts112/vts112v14_metod_pokyny.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_vts112.php?copern=11&drupoh=1&page=1&typ=PDF', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMod512()
  {
   window.open('../ucto/uobrat.php?h_mfir=<?php echo $kli_vxcf; ?>&copern=200&drupoh=1&page=1&typ=PDF&cstat=512&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
  function zarch( mesiac )
  {
   window.open('../ucto/statistika_vts112.php?copern=11&drupoh=1&page=1&typ=PDF&zarchivu=1&mesarch=' + mesiac +  '&xxx=1', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 2 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">MesaËn˝ v˝kaz vo vybran˝ch trhov˝ch sluûb·ch</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="statistika_vts112.php?copern=3&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="statistika_vts112.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=2&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=2&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <h6 class="toleft" style="margin-left:500px; padding-right:5px;">ArchÌv:</h6>
<?php
$tvpol=0;
$sqltt = "SELECT * FROM F".$kli_vxcf."_statistika_vts112arch WHERE psys >= 1 ";
$tov = mysql_query("$sqltt");
if ( $tov) { $tvpol = mysql_num_rows($tov); }
$i=0;
  while ( $i < $tvpol )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
if ( $i == 0 ) { echo " "; }
echo "<a href='#' onclick='zarch(".$rtov->psys.")' title='KÛpia v˝kazu z archÌvu za ".$rtov->psys.".mesiac'
       class='archiv-link' style=''>".$rtov->psys."</a>";
}
$i=$i+1;
   }
?>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/vts112/vts112v14_str1.jpg"
 alt="tlaËivo MesaËn˝ v˝kaz vo vybran˝ch trhov˝ch sluûb·ch VTS 1-12 1.strana 124kB" class="form-background">
<?php
$kli_vrokx = substr($kli_vrok,2,2);
$mesiacx=$mesiac; if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
?>
<span class="text-echo" style="top:211px; left:475px; font-size:24px;"><?php echo $kli_vrok; ?></span>
<span class="text-echo" style="top:305px; left:195px; font-size:18px; letter-spacing:24px;"><?php echo $kli_vrokx; ?></span>
<span class="text-echo" style="top:305px; left:263px; font-size:18px; letter-spacing:24px;"><?php echo $mesiacx; ?></span>
<span class="text-echo" style="top:305px; left:333px; font-size:18px; letter-spacing:27px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:729px; left:295px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:751px; left:53px;"><?php echo "$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:751px; left:820px;"><?php echo $okres; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();"
  title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:749px; left:850px;">
<input type="text" name="cinnost" id="cinnost" style="width:500px; top:806px; left:53px;"/>

<!-- Vyplnil -->
<span class="text-echo" style="top:865px; left:53px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:885px; left:385px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:945px; left:53px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:944px; left:387px;"/>

<!-- modul 100155 -->
<input type="text" name="aktivita" id="aktivita" style="width:50px; top:1125px; left:807px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/vts112/vts112v14_str2.jpg"
 alt="tlaËivo MesaËn˝ v˝kaz vo vybran˝ch trhov˝ch sluûb·ch VTS 1-12 2.strana 268kB" class="form-background">

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:166px; left:680px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:191px; left:680px;"/>

<!-- modul 512 -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù ˙daje z V˝sledovky"
 onclick="NacitajMod512();" style="top:262px; left:386px;" class="btn-row-tool">
<input type="text" name="mod512r01" id="mod512r01" style="width:100px; top:351px; left:680px;"/>
<input type="text" name="mod512r02" id="mod512r02" style="width:100px; top:377px; left:680px;"/>
<input type="text" name="mod512r03" id="mod512r03" style="width:100px; top:404px; left:680px;"/>
<input type="text" name="mod512r04" id="mod512r04" style="width:100px; top:430px; left:680px;"/>
<span class="text-echo" style="top:460px; right:165px;"><?php echo $mod512r99; ?></span>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=2&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=2&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$zarchivu = 1*strip_tags($_REQUEST['zarchivu']);
$mesarch = 1*strip_tags($_REQUEST['mesarch']);

//vytlac
if ( $zarchivu == 0 )
     {
$sqltt = "UPDATE F$kli_vxcf"."_statistika_vts112 SET psys=$mesiac "; 
$sql = mysql_query("$sqltt");
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_vts112 WHERE ico >= 0 ";
     }

if ( $zarchivu == 1 )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_vts112arch WHERE psys = $mesarch "; 
$mesiac=$mesarch;
$psys=$mesarch;
     }

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts112/vts112v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts112/vts112v14_str1.jpg',0,0,210,297);
}

//OBDOBIA
$pdf->SetFont('arial','',15);
$pdf->Cell(190,33," ","$rmc1",1,"L");
$pdf->Cell(94,8," ","$rmc1",0,"L");$pdf->Cell(15,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',11);
$pdf->Cell(190,14," ","$rmc1",1,"L");
$R1=substr($kli_vrok,2,1);
$R2=substr($kli_vrok,3,1);
$pdf->Cell(31,5," ","$rmc1",0,"L");
$pdf->Cell(7,7,"$R1","$rmc",0,"C");$pdf->Cell(8,7,"$R2","$rmc",0,"C");
$mesiacx=$mesiac;
if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$A=substr($mesiacx,0,1);
$B=substr($mesiacx,1,1);
$pdf->Cell(7,7,"$A","$rmc",0,"C");$pdf->Cell(8,7,"$B","$rmc",0,"C");
//ico
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(8,7,"$B","$rmc",0,"C");$pdf->Cell(8,7,"$C","$rmc",0,"C");$pdf->Cell(8,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(8,7,"$F","$rmc",0,"C");$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(9,7,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,91," ","$rmc1",1,"L");
$pdf->Cell(55,4," ","$rmc1",0,"L");$pdf->Cell(99,4,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,7,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,7,"$okres","$rmc",1,"C");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,7,"$hlavicka->cinnost","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,7," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(60,7,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(43,12,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,7,"$fir_fem1","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
//odoslane
$pdf->Cell(43,7,"$odoslane_sk","$rmc",1,"C");

//modul 100155
$pdf->Cell(195,34," ","$rmc1",1,"L");
$pdf->Cell(159,5," ","$rmc1",0,"L");$pdf->Cell(30,7,"$hlavicka->aktivita","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts112/vts112v14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts112/vts112v14_str2.jpg',0,0,210,297);
}

//modul 2
$mod2r01=$hlavicka->mod2r01;
if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02;
if ( $mod2r02 == 0 ) $mod2r02="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r01","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r02","$rmc",1,"C");

//modul 512
$mod512r01=$hlavicka->mod512r01;
if( $mod512r01 == 0 ) $mod512r01="";
$mod512r02=$hlavicka->mod512r02;
if( $mod512r02 == 0 ) $mod512r02="";
$mod512r03=$hlavicka->mod512r03;
if( $mod512r03 == 0 ) $mod512r03="";
$mod512r04=$hlavicka->mod512r04;
if( $mod512r04 == 0 ) $mod512r04="";
$mod512r99=$hlavicka->mod512r99;
//if( $mod512r99 == 0 ) $mod512r99="";
$pdf->Cell(190,30," ","$rmc1",1,"L");
$pdf->Cell(118,6," ","$rmc1",0,"L");$pdf->Cell(65,7,"$mod512r01","$rmc",1,"R");
$pdf->Cell(118,6," ","$rmc1",0,"L");$pdf->Cell(65,6,"$mod512r02","$rmc",1,"R");
$pdf->Cell(118,7," ","$rmc1",0,"L");$pdf->Cell(65,6,"$mod512r03","$rmc",1,"R");
$pdf->Cell(118,6," ","$rmc1",0,"L");$pdf->Cell(65,6,"$mod512r04","$rmc",1,"R");
$pdf->Cell(118,6," ","$rmc1",0,"L");$pdf->Cell(65,6,"$mod512r99","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
if ( $zarchivu == 0 )
     {
$sql = "SELECT psys FROM F$kli_vxcf"."_statistika_vts112arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_vts112arch SELECT * FROM F".$kli_vxcf."_statistika_vts112 WHERE psys=99 ";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_vts112arch WHERE psys=$mesiac";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_statistika_vts112arch SELECT * FROM F".$kli_vxcf."_statistika_vts112 WHERE psys=$mesiac";
$vysledek = mysql_query("$sql");
     }
?>
<script type="text/javascript">
 var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac


$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>