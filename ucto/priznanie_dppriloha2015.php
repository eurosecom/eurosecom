<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
  do
  {
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
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
$rmc=1;
$rmc1=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15";
$jpg_popis="tla�ivo Da� z pr�jmov PO pre rok ".$kli_vrok;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$sql = "SELECT prcpr FROM F$kli_vxcf"."_uctpriznanie_dpprilpro ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctpriznanie_dpprilpro';
$vytvor = mysql_query("$vsql");

$sqlt = <<<priznaniepo
(
   prcpl  int not null auto_increment,
   prcpr  DECIMAL(10,0) DEFAULT 0,
   prpdzc DATE NOT NULL,
   prpzo1 DATE NOT NULL,
   prpzd1 DATE NOT NULL,
   prpvz1 DECIMAL(10,2) DEFAULT 0,
   prpod1 DECIMAL(10,2) DEFAULT 0,
   prpzo2 DATE NOT NULL,
   prpzd2 DATE NOT NULL,
   prpvz2 DECIMAL(10,2) DEFAULT 0,
   prpod2 DECIMAL(10,2) DEFAULT 0,
   prpzo3 DATE NOT NULL,
   prpzd3 DATE NOT NULL,
   prpvz3 DECIMAL(10,2) DEFAULT 0,
   prpod3 DECIMAL(10,2) DEFAULT 0,
   prpzo4 DATE NOT NULL,
   prpzd4 DATE NOT NULL,
   prpvz4 DECIMAL(10,2) DEFAULT 0,
   prpod4 DECIMAL(10,2) DEFAULT 0,
   prpzo5 DATE NOT NULL,
   prpzd5 DATE NOT NULL,
   prpvz5 DECIMAL(10,2) DEFAULT 0,
   prpod5 DECIMAL(10,2) DEFAULT 0,
   prpods DECIMAL(10,2) DEFAULT 0,
   prpodv DECIMAL(10,2) DEFAULT 0,
   prptxt TEXT NOT NULL,
   prpcp DECIMAL(4,0) DEFAULT 0,
   prppp DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(prcpl)
);
priznaniepo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriznanie_dpprilpro'.$sqlt;
$vytvor = mysql_query("$vsql");
echo $vsql;
}

$sql = "SELECT pcsum FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctpriznanie_dppriloha';
$vytvor = mysql_query("$vsql");

$sqlt = <<<priznaniepo
(
   p1cpl        int not null auto_increment,
   psys         INT DEFAULT 0,
   druh         INT DEFAULT 0,
   p1cis        DECIMAL(4,0) DEFAULT 0,
   pcsum        DECIMAL(10,2) DEFAULT 0,
   p1ico        DECIMAL(10,0) DEFAULT 0,
   p1sid        DECIMAL(4,0) DEFAULT 0,
   p1pfr        VARCHAR(60) NOT NULL,
   p1men        VARCHAR(60) NOT NULL,
   p1uli        VARCHAR(60) NOT NULL,
   p1cdm        VARCHAR(20) NOT NULL,
   p1psc        VARCHAR(10) NOT NULL,
   p1mes        VARCHAR(60) NOT NULL,
   ico          DECIMAL(8,0)  DEFAULT 0,
   PRIMARY KEY(p1cpl)
);
priznaniepo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriznanie_dppriloha'.$sqlt;
$vytvor = mysql_query("$vsql");
}

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$cislo_p1cpl = 1*strip_tags($_REQUEST['cislo_p1cpl']);
$cislo_prcpl = 1*strip_tags($_REQUEST['cislo_prcpl']);
$drupoh = 1*$_REQUEST['drupoh'];
$volapo = 1*$_REQUEST['volapo'];

//zapis upravene udaje 
if ( $copern == 202 )
     {
$p1cis = strip_tags($_REQUEST['p1cis']);
$pcsum = strip_tags($_REQUEST['pcsum']);
$p1ico = strip_tags($_REQUEST['p1ico']);
$p1sid = strip_tags($_REQUEST['p1sid']);
$p1pfr = strip_tags($_REQUEST['p1pfr']);
$p1men = strip_tags($_REQUEST['p1men']);
$p1uli = strip_tags($_REQUEST['p1uli']);
$p1cdm = strip_tags($_REQUEST['p1cdm']);
$p1psc = strip_tags($_REQUEST['p1psc']);
$p1mes = strip_tags($_REQUEST['p1mes']);

$uprav="NO";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dppriloha SET ".
" p1cis='$p1cis', pcsum='$pcsum', ".
" p1ico='$p1ico', p1sid='$p1sid', p1pfr='$p1pfr', p1men='$p1men', p1uli='$p1uli', p1cdm='$p1cdm', ".
" p1psc='$p1psc', p1mes='$p1mes' ".
" WHERE p1cpl = $cislo_p1cpl "; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt");
$copern=201;
if (!$upravene):
?>
<script type="text/javascript"> alert( "�DAJE NEBOLI UPRAVEN� " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov 



//zapis upravene udaje proj
if ( $copern == 1202 )
     {
$prcpr = $_REQUEST['prcpr'];
$prpdzc = $_REQUEST['prpdzc'];
$prpdzcsql=Sqldatum($prpdzc);
$prpzo1 = $_REQUEST['prpzo1'];
$prpzo1sql=Sqldatum($prpzo1);
$prpzo2 = $_REQUEST['prpzo2'];
$prpzo2sql=Sqldatum($prpzo2);
$prpzo3 = $_REQUEST['prpzo3'];
$prpzo3sql=Sqldatum($prpzo3);
$prpzo4 = $_REQUEST['prpzo4'];
$prpzo4sql=Sqldatum($prpzo4);
$prpzo5 = $_REQUEST['prpzo5'];
$prpzo5sql=Sqldatum($prpzo5);
$prpzd1 = $_REQUEST['prpzd1'];
$prpzd1sql=Sqldatum($prpzd1);
$prpzd2 = $_REQUEST['prpzd2'];
$prpzd2sql=Sqldatum($prpzd2);
$prpzd3 = $_REQUEST['prpzd3'];
$prpzd3sql=Sqldatum($prpzd3);
$prpzd4 = $_REQUEST['prpzd4'];
$prpzd4sql=Sqldatum($prpzd4);
$prpzd5 = $_REQUEST['prpzd5'];
$prpzd5sql=Sqldatum($prpzd5);

$prpvz1 = 1*$_REQUEST['prpvz1'];
$prpvz2 = 1*$_REQUEST['prpvz2'];
$prpvz3 = 1*$_REQUEST['prpvz3'];
$prpvz4 = 1*$_REQUEST['prpvz4'];
$prpvz5 = 1*$_REQUEST['prpvz5'];

$prpod1 = 1*$_REQUEST['prpod1'];
$prpod2 = 1*$_REQUEST['prpod2'];
$prpod3 = 1*$_REQUEST['prpod3'];
$prpod4 = 1*$_REQUEST['prpod4'];
$prpod5 = 1*$_REQUEST['prpod5'];

$prptxt = strip_tags($_REQUEST['prptxt']);

$uprav="NO";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dpprilpro SET ".
" prpdzc='$prpdzcsql', prptxt='$prptxt', prcpr='$prcpr', ".
" prpzo1='$prpzo1sql', prpzo2='$prpzo2sql', prpzo3='$prpzo3sql', prpzo4='$prpzo4sql', prpzo5='$prpzo5sql', ".
" prpzd1='$prpzd1sql', prpzd2='$prpzd2sql', prpzd3='$prpzd3sql', prpzd4='$prpzd4sql', prpzd5='$prpzd5sql', ".
" prpvz1='$prpvz1', prpvz2='$prpvz2', prpvz3='$prpvz3', prpvz4='$prpvz4', prpvz5='$prpvz5', ".
" prpod1='$prpod1', prpod2='$prpod2', prpod3='$prpod3', prpod4='$prpod4', prpod5='$prpod5' ".
" WHERE prcpl = $cislo_prcpl "; 
echo $uprtxt;

$upravene = mysql_query("$uprtxt");
$copern=1201;
if (!$upravene):
?>
<script type="text/javascript"> alert( "�DAJE NEBOLI UPRAVEN� " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov proj 

//novy prijimatel
    if ( $copern == 336 )
    {

$p1cis=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cis DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $p1cis=$riaddok->p1cis+1;
 }


$sql = "INSERT INTO F".$kli_vxcf."_uctpriznanie_dppriloha (p1cpl) VALUES ( 0 ) ";
$vysledok = mysql_query($sql);

$cislo_p1cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_p1cpl=$riaddok->p1cpl;
 }


$pcsum = "0.00";
$p1ico = 0;
$p1sid = 0;
$copern=201;

    }
//koniec novy prijimatel

//novy projekt
    if ( $copern == 1336 )
    {

$p1cis=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpr > 0 ORDER BY prcpr DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $prcpr=$riaddok->prcpr+1;
 }


$sql = "INSERT INTO F".$kli_vxcf."_uctpriznanie_dpprilpro (prcpl) VALUES ( 0 ) ";
$vysledok = mysql_query($sql);

$cislo_prcpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl > 0 ORDER BY prcpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_prcpl=$riaddok->prcpl;
 }

$copern=1201;

    }
//koniec novy projekt

//zmaz prijimatela
    if ( $copern == 206 )
    {
$sql = "DELETE FROM F".$kli_vxcf."_uctpriznanie_dppriloha WHERE p1cpl = $cislo_p1cpl ";
$vysledok = mysql_query($sql);

$copern=101;

    }
//koniec zmaz prijimatela

//zmaz projekt
    if ( $copern == 1206 )
    {
$sql = "DELETE FROM F".$kli_vxcf."_uctpriznanie_dpprilpro WHERE prcpl = $cislo_prcpl ";
$vysledok = mysql_query($sql);

$copern=1101;

    }
//koniec zmaz projekt


//nacitaj udaje 
if ( $copern == 203 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl = $cislo_p1cpl ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$p1cis = $fir_riadok->p1cis;
$pcsum = $fir_riadok->pcsum;
$p1ico = $fir_riadok->p1ico;
$p1sid = $fir_riadok->p1sid;
$p1pfr = $fir_riadok->p1pfr;
$p1men = $fir_riadok->p1men;
$p1uli = $fir_riadok->p1uli;
$p1cdm = $fir_riadok->p1cdm;
$p1psc = $fir_riadok->p1psc;
$p1mes = $fir_riadok->p1mes;

$copern=201;
                      }

if ( $copern == 1203 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl = $cislo_prcpl ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$prcpr = $fir_riadok->prcpr;
$prpcp = $fir_riadok->prpcp;
$prppp = $fir_riadok->prppp;
$prpdzc = $fir_riadok->prpdzc;
$prpdzcsk=Skdatum($prpdzc);
$prpzo1 = $fir_riadok->prpzo1;
$prpzo1sk=Skdatum($prpzo1);
$prpzo2 = $fir_riadok->prpzo2;
$prpzo2sk=Skdatum($prpzo2);
$prpzo3 = $fir_riadok->prpzo3;
$prpzo3sk=Skdatum($prpzo3);
$prpzo4 = $fir_riadok->prpzo4;
$prpzo4sk=Skdatum($prpzo4);
$prpzo5 = $fir_riadok->prpzo5;
$prpzo5sk=Skdatum($prpzo5);

$prpzd1 = $fir_riadok->prpzd1;
$prpzd1sk=Skdatum($prpzd1);
$prpzd2 = $fir_riadok->prpzd2;
$prpzd2sk=Skdatum($prpzd2);
$prpzd3 = $fir_riadok->prpzd3;
$prpzd3sk=Skdatum($prpzd3);
$prpzd4 = $fir_riadok->prpzd4;
$prpzd4sk=Skdatum($prpzd4);
$prpzd5 = $fir_riadok->prpzd5;
$prpzd5sk=Skdatum($prpzd5);

$prpvz1 = $fir_riadok->prpvz1;
$prpvz2 = $fir_riadok->prpvz2;
$prpvz3 = $fir_riadok->prpvz3;
$prpvz4 = $fir_riadok->prpvz4;
$prpvz5 = $fir_riadok->prpvz5;

$prpod1 = $fir_riadok->prpod1;
$prpod2 = $fir_riadok->prpod2;
$prpod3 = $fir_riadok->prpod3;
$prpod4 = $fir_riadok->prpod4;
$prpod5 = $fir_riadok->prpod5;

$prpods = $fir_riadok->prpods;
$prpodv = $fir_riadok->prpodv;
$prptxt = $fir_riadok->prptxt;

$copern=1201;
                      }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - pr�loha k DP</title>
<style type="text/css">
div.wrap-prijimatelia {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.prijimatelia {
  width: 914px;
  margin: 5px auto;
}
table.prijimatelia caption {
  width: 100%;
  line-height: 40px;
}
table.prijimatelia caption h3 {
  font-size: 16px;
  font-weight: bold;
  text-align: left;
}
table.prijimatelia caption img {
  display: block;
  width: 18px;
  height: 18px;
  margin: 11px 0 0 5px;
  cursor: pointer;
}
table.prijimatelia thead td {
  height: 16px;
  line-height: 16px;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.prijimatelia tbody td {
  height: 30px;
  line-height: 30px;
  border-top: 2px solid #add8e6;
  font-size: 15px;
}
table.prijimatelia tbody img {
  width: 20px;
  height: 20px;
  vertical-align: text-bottom;
  cursor: pointer;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
</style>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana prij
  if ( $copern == 201 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.p1cis.value = '<?php echo "$p1cis";?>';
   document.formv1.pcsum.value = '<?php echo "$pcsum";?>';
   document.formv1.p1ico.value = '<?php echo "$p1ico";?>';
   document.formv1.p1sid.value = '<?php echo "$p1sid";?>';
   document.formv1.p1pfr.value = '<?php echo "$p1pfr";?>';
   document.formv1.p1men.value = '<?php echo "$p1men";?>';
   document.formv1.p1uli.value = '<?php echo "$p1uli";?>';
   document.formv1.p1cdm.value = '<?php echo "$p1cdm";?>';
   document.formv1.p1psc.value = '<?php echo "$p1psc";?>';
   document.formv1.p1mes.value = '<?php echo "$p1mes";?>';
  }
<?php
//koniec uprava
  }
?>

<?php
//uprava sadzby strana proj
  if ( $copern == 1201 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.prcpr.value = '<?php echo "$prcpr"; ?>';
   document.formv1.prpdzc.value = '<?php echo "$prpdzcsk"; ?>';

   document.formv1.prpzo1.value = '<?php echo "$prpzo1sk"; ?>';
   document.formv1.prpzo2.value = '<?php echo "$prpzo2sk"; ?>';
   document.formv1.prpzo3.value = '<?php echo "$prpzo3sk"; ?>';
   document.formv1.prpzo4.value = '<?php echo "$prpzo4sk"; ?>';
   document.formv1.prpzo5.value = '<?php echo "$prpzo5sk"; ?>';

   document.formv1.prpzd1.value = '<?php echo "$prpzd1sk"; ?>';
   document.formv1.prpzd2.value = '<?php echo "$prpzd2sk"; ?>';
   document.formv1.prpzd3.value = '<?php echo "$prpzd3sk"; ?>';
   document.formv1.prpzd4.value = '<?php echo "$prpzd4sk"; ?>';
   document.formv1.prpzd5.value = '<?php echo "$prpzd5sk"; ?>';

   document.formv1.prpvz1.value = '<?php echo "$prpvz1"; ?>';
   document.formv1.prpvz2.value = '<?php echo "$prpvz2"; ?>';
   document.formv1.prpvz3.value = '<?php echo "$prpvz3"; ?>';
   document.formv1.prpvz4.value = '<?php echo "$prpvz4"; ?>';
   document.formv1.prpvz5.value = '<?php echo "$prpvz5"; ?>';

   document.formv1.prpod1.value = '<?php echo "$prpod1"; ?>';
   document.formv1.prpod2.value = '<?php echo "$prpod2"; ?>';
   document.formv1.prpod3.value = '<?php echo "$prpod3"; ?>';
   document.formv1.prpod4.value = '<?php echo "$prpod4"; ?>';
   document.formv1.prpod5.value = '<?php echo "$prpod5"; ?>';
  }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 201 AND $copern != 1201 )
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
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function NovyPrmatel()
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=336&uprav=0&volapo=<?php echo $volapo; ?>', '_self')
  }
  function UpravPrmatel(p1cpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=203&uprav=0&cislo_p1cpl=' + p1cpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }
  function ZmazPrmatel(p1cpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=206&uprav=0&cislo_p1cpl=' + p1cpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }

  function NovyProj()
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=1336&uprav=0&volapo=<?php echo $volapo; ?>', '_self')
  }
  function UpravProj(prcpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=1203&uprav=0&cislo_prcpl=' + prcpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }
  function ZmazProj(prcpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=1206&uprav=0&cislo_prcpl=' + prcpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">

<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
<?php if ( $volapo == 0 ) { ?> <td class="header">Da� z pr�jmov FOB - pr�loha k IV. �asti</td> <?php } ?>
<?php if ( $volapo == 1 ) { ?> <td class="header">Da� z pr�jmov PO - pr�loha k IV. �asti</td> <?php } ?>
   <td>
    <div class="bar-btn-form-tool"></div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<?php
//zobraz udaje
if ( $copern != 11 )
     {
?>

<?php
$clas99="active";
$source="../ucto/priznanie_po2015.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0&volapo=".$volapo;
if ( $volapo == 0 ) { $source="../ucto/priznanie_fob2015.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0&volapo=".$volapo; }
?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas99; ?> toleft">P1</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=1101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas99; ?> toleft">P2</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=1011&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_blank')" class="<?php echo $clas99; ?> toright">P2</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=11&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_blank')" class="<?php echo $clas99; ?> toright">P1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=10', '_blank');" class="<?php echo $clas10; ?> toright">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=9', '_blank');" class="<?php echo $clas9; ?> toright">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=8', '_blank');" class="<?php echo $clas8; ?> toright">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=7', '_blank');" class="<?php echo $clas7; ?> toright">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">Tla�i�:</h6>

<?php
//VYPIS ZOZNAMU PRIJIMATELOV
if ( $copern == 101 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cis";
$sql = mysql_query("$sqltt");
//echo $sqltt;
//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
  while ($i <= $cpol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$riadok=mysql_fetch_object($sql);

if ( $i == 0 ) { ?>
<div class="wrap-prijimatelia">
 <table class="prijimatelia">
 <caption>
  <h3 class="toleft">Pr�loha k IV. �asti - �al�� prij�matelia</h3>
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NovyPrmatel();"
       title="Prida� prij�mate�a" class="toleft">
 </caption>
 <thead>
 <tr>
  <td width="5%" align="center">��slo</td>
  <td width="65%">N�zov - I�O / SID</td>
  <td width="15%" align="right">Suma</td>
  <td width="15%" align="center">&nbsp;</td>
 </tr>
 </thead>
<?php          }
if ( $riadok->p1cpl > 0 ) { ?>
 <tbody>
  <tr>
   <td align="center" style="font-weight:bold;"><?php echo $riadok->p1cis;?></td>
   <td><?php echo $riadok->p1men;?>, <?php echo $riadok->p1mes;?> - <?php echo $riadok->p1ico;?> / <?php echo $riadok->p1sid;?></td>
   <td align="right"><?php echo $riadok->pcsum;?></td>
   <td align="center">
    <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravPrmatel(<?php echo $riadok->p1cpl;?>);" title="Upravi� prij�mate�a">&nbsp;&nbsp;
    <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazPrmatel(<?php echo $riadok->p1cpl;?>);" title="Vymaza� prij�mate�a">
   </td>
  </tr>
 </tbody>
<?php
                          }
  }
$i = $i + 1;
  }
?>
 </table>
</div>
<?php
}
//koniec zoznam prij
?>

<?php
//VYPIS ZOZNAMU PROJEKTOV
if ( $copern == 1101 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpl > 0 ORDER BY prcpr";
$sql = mysql_query("$sqltt");
//echo $sqltt;
//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
  while ($i <= $cpol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$riadok=mysql_fetch_object($sql);

if ( $i == 0 ) { ?>
<div class="wrap-prijimatelia">
 <table class="prijimatelia">
 <caption>
  <h3 class="toleft">Pr�loha k IV. �asti - �al�� proj</h3>
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NovyProj();"
       title="Prida� proj" class="toleft">
 </caption>
 <thead>
 <tr>
  <td width="5%" align="center">pol.</td>
  <td width="65%">��slo projektu - popis</td>
  <td width="15%" align="right">Suma</td>
  <td width="15%" align="center">&nbsp;</td>
 </tr>
 </thead>
<?php          }
if ( $riadok->prcpl > 0 ) { ?>
 <tbody>
  <tr>
   <td align="center" style="font-weight:bold;"><?php echo $riadok->prcpl;?></td>
   <td><?php echo $riadok->prcpr;?>, <?php echo $riadok->prptxt;?> </td>
   <td align="right"><?php echo $riadok->prpods;?></td>
   <td align="center">
    <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravProj(<?php echo $riadok->prcpl;?>);" title="Upravi� proj">&nbsp;&nbsp;
    <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazProj(<?php echo $riadok->prcpl;?>);" title="Vymaza� proj">
   </td>
  </tr>
 </tbody>
<?php
                          }
  }
$i = $i + 1;
  }
?>
 </table>
</div>
<?php
}
//koniec zoznam proj
?>

<?php
//UPRAVA PRIJIMATELA
if ( $copern == 201 )
{
?>
<FORM name="formv1" method="post" action="priznanie_dppriloha2015.php?copern=202&cislo_p1cpl=<?php echo $cislo_p1cpl; ?>&volapo=<?php echo $volapo; ?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-top-formsave">
</div>
<?php if ( $volapo == 0 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str12.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 12.strana 240kB">
<?php                     } ?>
<?php if ( $volapo == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str12.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 12.strana 240kB">
<?php                     } ?>
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- PRILOHA k IV.casti -->
<input type="text" name="p1cis" id="p1cis" style="width:35px; top:154px; left:190px;"/>
<input type="text" name="pcsum" id="pcsum" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:209px; left:161px;"/>

<input type="text" name="p1ico" id="p1ico" style="width:175px; top:264px; left:51px;"/>
<input type="text" name="p1sid" id="p1sid" style="width:82px; top:264px; left:259px;"/>
<input type="text" name="p1pfr" id="p1pfr" style="width:519px; top:264px; left:374px;"/>
<input type="text" name="p1men" id="p1men" style="width:842px; top:316px; left:51px;"/>
<input type="text" name="p1uli" id="p1uli" style="width:635px; top:420px; left:51px;"/>
<input type="text" name="p1cdm" id="p1cdm" style="width:175px; top:420px; left:718px;"/>
<input type="text" name="p1psc" id="p1psc" style="width:107px; top:474px; left:51px;"/>
<input type="text" name="p1mes" id="p1mes" style="width:703px; top:474px; left:190px;"/>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas11; ?> toleft">pr�loha</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-bottom-formsave">
</div>
</FORM>
<?php
}
//koniec uprava jedneho
?>

<?php
//UPRAVA PROJEKTU
if ( $copern == 1201 )
{
?>
<FORM name="formv1" method="post" action="priznanie_dppriloha2015.php?copern=1202&cislo_prcpl=<?php echo $cislo_prcpl; ?>&volapo=<?php echo $volapo; ?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-top-formsave">
</div>
<?php if ( $volapo == 0 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str11.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 12.strana 240kB">
<?php                     } ?>
<?php if ( $volapo == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str11.jpg" class="form-background" alt="<?php echo $jpg_popis; ?> 12.strana 240kB">
<?php                     } ?>
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<input type="text" name="prcpr" id="prcpr" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:167px; left:269px;"/>
<div class="input-echo right" style="top:167px; left:338px; width:36px;"><?php echo $prppp; ?>&nbsp;</div>
<input type="text" name="prpdzc" id="prpdzc" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:166px; left:697px;"/>

<input type="text" name="prpzo1" id="prpzo1" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:254px; left:72px;"/>
<input type="text" name="prpzd1" id="prpzd1" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:293px; left:72px;"/>
<input type="text" name="prpvz1" id="prpvz1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:293px;"/>
<input type="text" name="prpod1" id="prpod1" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:254px; left:604px;"/>

<input type="text" name="prpzo2" id="prpzo2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:333px; left:72px;"/>
<input type="text" name="prpzd2" id="prpzd2" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:370px; left:72px;"/>
<input type="text" name="prpvz2" id="prpvz2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:293px;"/>
<input type="text" name="prpod2" id="prpod2" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:333px; left:604px;"/>

<input type="text" name="prpzo3" id="prpzo3" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:410px; left:72px;"/>
<input type="text" name="prpzd3" id="prpzd3" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:448px; left:72px;"/>
<input type="text" name="prpvz3" id="prpvz3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:293px;"/>
<input type="text" name="prpod3" id="prpod3" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:410px; left:604px;"/>

<input type="text" name="prpzo4" id="prpzo4" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:488px; left:72px;"/>
<input type="text" name="prpzd4" id="prpzd4" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:526px; left:72px;"/>
<input type="text" name="prpvz4" id="prpvz4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:293px;"/>
<input type="text" name="prpod4" id="prpod4" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:488px; left:604px;"/>

<input type="text" name="prpzo5" id="prpzo5" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:566px; left:72px;"/>
<input type="text" name="prpzd5" id="prpzd5" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:604px; left:72px;"/>
<input type="text" name="prpvz5" id="prpvz5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:293px;"/>
<input type="text" name="prpod5" id="prpod5" onkeyup="CiarkaNaBodku(this);" style="width:289px; top:566px; left:604px;"/>

<div class="input-echo right" style="width:290px; top:644px; left:604px;"><?php echo $prpods; ?>&nbsp;</div>
<textarea name="prptxt" id="prptxt" style="width:838px; height:400px; top:700px; left:53px;"><?php echo $prptxt; ?></textarea>
<div class="input-echo right" style="width:290px; top:1150px; left:604px;"><?php echo $prpodv; ?>&nbsp;</div>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas11; ?> toleft">pr�loha</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-bottom-formsave">
</div>
</FORM>
<?php
}
//koniec uprava proj
?>

<?php
     }
//koniec zobrazenia udajov 
?>
</div> <!-- koniec #content -->

<?php
//zostava PDF PRIJ
if ( $copern == 11 )
     {
if ( File_Exists("../tmp/dppriloha.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/dppriloha.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac prilohu
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cis > 0 ORDER BY p1cis";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$strana=0;
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$hlavicka=mysql_fetch_object($sql);

if ( $j == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(6);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg',0,0,210,298);
}
$strana=$strana+1;
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(3,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");
               } //koniec j=0


//suradnice Y 1., 2. a 3. polozky
if ( $j == 0 ) { $pozy=30; }
if ( $j == 1 ) { $pozy=116; }
if ( $j == 2 ) { $pozy=201; }

$pdf->SetY($pozy); 

//PRIJIMATEL
//cislo
$text=sprintf('% 2s',$hlavicka->p1cis);
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(36,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//suma
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->pcsum;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf('% 11s',$hodx);
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
$pdf->Cell(30,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$K","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->p1ico;
if ( $text == 0 ) $text="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
if ( $hlavicka->p1ico < 1000000 ) { $text="00".$hlavicka->p1ico; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");

//sid
$text=$hlavicka->p1sid;
if ( $text == 0 ) { $text=""; }
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");

//pravna forma
$text=$hlavicka->p1pfr;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(6,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",1,"C");

//obchodne meno
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text=$hlavicka->p1men;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//ulica
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$text=$hlavicka->p1uli;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");

//cislo
$text=$hlavicka->p1cdm;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");

//psc
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text=$hlavicka->p1psc;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//obec
$text=$hlavicka->p1mes;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$F1","$rmc",1,"C");
  }
$i = $i + 1;
$j = $j + 1;
if ( $j == 3 ) $j=0;
  }


$pdf->Output("../tmp/dppriloha.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/dppriloha.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

//koniec tlac prijimatelov copern=11
     }
?>

<?php
//zostava PDF PROJ
if ( $copern == 1011 )
     {
if ( File_Exists("../tmp/dppriloha.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/dppriloha.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac prilohu
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dpprilpro WHERE prcpr > 0 ORDER BY prcpr ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$strana=0;
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$hlavicka=mysql_fetch_object($sql);


$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(6);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15_str11.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/dppo2015/dppo_v15_str11.jpg',0,0,210,298);
}
$strana=$strana+1;
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(3,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");

  }

$i=$i+1;
  }


$pdf->Output("../tmp/dppriloha.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/dppriloha.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

//koniec tlac projektov copern=1011
     }
?>


<?php
//celkovy koniec dokumentu
  } while (false);
?>
</BODY>
</HTML>
