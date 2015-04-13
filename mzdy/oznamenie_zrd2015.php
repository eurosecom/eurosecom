<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
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


//ulozit sumar strana
if ( $copern == 801 AND $strana == 1 )
     {
$mdic = strip_tags($_REQUEST['mdic']);
$zzul = strip_tags($_REQUEST['zzul']);
$zzcs = strip_tags($_REQUEST['zzcs']);
$zzps = strip_tags($_REQUEST['zzps']);
$zzms = strip_tags($_REQUEST['zzms']);
$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);


$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET datum='$datum_sql', zzul='$zzul', zzps='$zzps', zzms='$zzms', zzcs='$zzcs', mdic='$mdic' ".
" WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt"); 
//echo $uprtxt;
$uprav="NO";
$copern=101;
     }
//koniec ulozit sumar strana


//upravit polozku
if ( $copern == 801 AND $strana == 3 )
     {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$xdic = strip_tags($_REQUEST['xdic']);
$xmfo = strip_tags($_REQUEST['xmfo']);
$xpfo = strip_tags($_REQUEST['xpfo']);
$xnpo = strip_tags($_REQUEST['xnpo']);
$xuli = strip_tags($_REQUEST['xuli']);
$xcis = strip_tags($_REQUEST['xcis']);
$xpsc = strip_tags($_REQUEST['xpsc']);
$xmes = strip_tags($_REQUEST['xmes']);

$prj = 1*strip_tags($_REQUEST['prj']);
$datd = strip_tags($_REQUEST['datd']);
$datd_sql=SqlDatum($datd);


$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrdpol SET xdic='$xdic', xuli='$xuli', xcis='$xcis', xpsc='$xpsc', xmes='$xmes', ".
" xmfo='$xmfo', xpfo='$xpfo', xnpo='$xnpo', prj='$prj', datd='$datd_sql' ".
" WHERE  cpl = $cislo_cpl ";
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET datd='$datd_sql' WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$upravene = mysql_query("$uprtxt"); 

$uprav="NO";
$copern=101;
$strana=3;
     }
//koniec upravit polozku

//vlozit novu polozku
if ( $copern == 801 AND $strana == 2 )
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
$strana=2;
if( $cislo_cpl > 0 ) { $strana=3; }

     }
//koniec vlozit novu polozku


//zmazat polozku
if ( $copern == 502 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE cpl = $cislo_cpl ";
$upravene = mysql_query("$uprtxt"); 

$copern=101;
$strana=2;
     }
//koniec zmazat polozku


//nacitaj 
if ( $copern == 101 )
     {
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

mysql_free_result($fir_vysledok);

if( $strana == 3 ) 
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


if ( $fir_uctt03 != 999 ) {
$meno=""; $prie=""; $titulp=""; $titulz="";
$fir_fnazx = $fir_fnaz;
$nar_sk="";
$zuli = $fir_fuli;
$zcdm = $fir_fcdm;
$zmes = $fir_fmes;
$zpsc = $fir_fpsc;                          }

if( $nar_sk == '00.00.0000' ) { $nar_sk=""; }


  }


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


table.poistenci {
  position: absolute;
  top: 792px;
  left: 45px;
  width: 890px;
  font-size: 14px;
}
table.poistenci td {
  height: 26px;
  line-height: 26px;
  border-bottom: 2px solid black; 
  text-align: right;
}
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
img.row-delete {
  position: relative;
  top: 4px;
  width: 18px;
  height: 18px;
}
div.ponuka-box {
  z-index: 1;
  position: absolute;
  left: 20px;
  overflow: auto;
  height: 350px;
  width: 530px;
}
div.ponuka-area {
  width: 508px;
  background-color: lightblue;
}
div.ponuka-area h2 {
  float: left;
  height: 26px;
  line-height: 26px;
  margin-top: 5px;
}
img.skry {
  float: right;
  position: relative;
  top: 4px;
  right: 4px;
  width: 20px;
  height: 20px;
  cursor: pointer;
}
table.ponuka {
  width: 500px;
  margin: 0 auto;
}
table.ponuka th {
  font-size: 11px;
  font-weight: normal;
  height: 16px;
  line-height: 16px;
}
table.ponuka td {
  height: 26px;
  line-height: 26px;
  font-size: 13px;
  background-color: white;
  border: 2px solid lightblue;
}
input.ok-btn {
  position: relative;
  top: 2px;
}
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//preskakovanie ENTER-om




  function ObnovUI()
  {

<?php if( $strana == 1 ) { ?>


   document.formv1.mdic.value = "<?php echo $mdic; ?>";
   document.formv1.zzul.value = "<?php echo $zzul; ?>";
   document.formv1.zzcs.value = "<?php echo $zzcs; ?>";
   document.formv1.zzps.value = "<?php echo $zzps; ?>";
   document.formv1.zzms.value = "<?php echo $zzms; ?>";
   document.formv1.datum.value = "<?php echo $datum_sk; ?>";

   document.formv1.uloz.disabled = true;
   document.formv1.uloz1.disabled = true;

<?php                    } ?>

<?php if( $strana == 3 ) { ?>

   document.formv1.xdic.value = "<?php echo $xdic; ?>";
   document.formv1.xmfo.value = "<?php echo $xmfo; ?>";
   document.formv1.xpfo.value = "<?php echo $xpfo; ?>";
   document.formv1.xnpo.value = "<?php echo $xnpo; ?>";
   document.formv1.prj.value = "<?php echo $prj; ?>";
   document.formv1.datd.value = "<?php echo $datd_sk; ?>";

   document.formv1.xuli.value = "<?php echo $xuli; ?>";
   document.formv1.xcis.value = "<?php echo $xcis; ?>";
   document.formv1.xpsc.value = "<?php echo $xpsc; ?>";
   document.formv1.xmes.value = "<?php echo $xmes; ?>";

   document.formv1.uloz.disabled = true;
   document.formv1.uloz1.disabled = true;

<?php                    } ?>

  }

  function VysvetlVypln()
  {
   window.open('../dokumenty/zdravpoist/dividendy_ZPv14_vysvetlivky.pdf', '_blank');
  }

  function TlacVykaz()
  {
   window.open('oznamenie_zrd2015.php?copern=40&cislo_xplat=<?php echo $cislo_xplat; ?>&h_oprav=<?php echo $h_oprav; ?>', '_blank');
  }


  function Povol_uloz()
  {
   var okvstup=1;
   if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
        else { document.formv1.uloz.disabled = true; return (false) ; }
  }
  function Povol_uloz1()
  {
   var okvstup=1;
   if ( okvstup == 1 ) { document.formv1.uloz1.disabled = false; return (true); }
        else { document.formv1.uloz1.disabled = true; return (false) ; }
  }


//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('oznamenie_zrd2015.php?copern=101&cislo_cpl='+ cislo_cpl + '&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=3', '_self' )
  }
  function ZmazVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('oznamenie_zrd2015.php?copern=502&cislo_cpl='+ cislo_cpl + '&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=2', '_self' )
  }
  function NoveVzd()
  {
   window.open('oznamenie_zrd2015.php?copern=801&strana=2&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>', '_self' )
  }

</script>
</HEAD>
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
$nazovplat=$oc." ".$meno." ".$prie;
if( $cislo_xplat > 9999 ) { $nazovplat=$fir_fnazx; }
?>
  <span class="subheader"><?php echo $nazovplat; ?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="VysvetlVypln();" title="Vysvetlivky" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>


<div id="content">
<FORM name="formv1" method="post"
      action="oznamenie_zrd2015.php?copern=801&cislo_cpl=<?php echo $cislo_cpl; ?>&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";

$source="../mzdy/oznamenie_zrd2015.php?subor=0&h_stv=".$zaobdobie."&cislo_xplat=".$cislo_xplat;
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=1', '_self');"
    class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=2', '_self');"
    class="<?php echo $clas2; ?> toleft">Drûitelia</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 2 ) { ?>
<div id="uvolni" onmouseover="return Povol_uloz();" class="uvolni-top-submit">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny"
  class="btn-top-formsave-noactive">
</div>
<?php                     } ?>
</div>

<?php if ( $copern == 101 AND $strana == 1 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str1.jpg"
     alt="tlaËivo Ozn·menie nepeÚaûnÈ plnenie 1.strana 243kB" class="form-background">

<!-- ZAHLAVIE -->

<input type="text" name="mdic" id="mdic" title="mdic" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:100px; top:344px; left:56px;"/>
<span class="text-echo" style="top:344px; left:723px;"><?php echo $zaobdobie; ?></span> <!-- dopyt, nie je funkËnÈ -->
<span class="text-echo" style="top:344px; left:769px;"><?php echo $kli_vrok; ?></span>

<!-- PLATITEL FO --> <!-- dopyt, nezd· sa mi, ûe vûdy FO, keÔ na 2.strane dole mÙûe byù aj poskytovateæ zdrv.starostlivosti -->
<div class="input-echo" style="width:357px; top:452px; left:52px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:241px; top:452px; left:432px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:111px; top:452px; left:693px;"><?php echo $titulp; ?></div> 
<div class="input-echo" style="width:66px; top:452px; left:827px;"><?php echo $titulz; ?></div> 
<div class="input-echo" style="width:196px; top:505px; left:52px;"><?php echo $nar_sk; ?></div>

<!-- PLATITEL PO nazov z ufir--> <!-- dopyt, nezd· sa mi, ûe vûdy FO, keÔ na 2.strane dole mÙûe byù aj poskytovateæ zdrv.starostlivosti -->
<div class="input-echo" style="width:357px; top:590px; left:52px;"><?php echo $fir_fnazx; ?></div>

<!-- ADRESA vzdy z udajov o zamestnancovi -->
<div class="input-echo" style="width:634px; top:696px; left:52px;"><?php echo $zuli; ?></div>
<div class="input-echo" style="width:173px; top:696px; left:720px;"><?php echo $zcdm; ?></div> 
<div class="input-echo" style="width:105px; top:750px; left:52px;"><?php echo $zpsc; ?></div> 
<div class="input-echo" style="width:700px; top:750px; left:191px;"><?php echo $zmes; ?></div>


<!-- ADRESA ZDRAVOTNICKEHO ZARIADENIA  -->


<input type="text" name="zzul" id="zzul" title="zzul" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:1100px; left:200px;"/> <!-- musia byt inputy -->

<input type="text" name="zzcs" id="zzcs" title="zzcs" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:1140px; left:200px;"/> <!-- musia byt inputy  -->

<input type="text" name="zzps" id="zzps" title="zzps" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:1180px; left:200px;"/> <!-- musia byt inputy  -->

<input type="text" name="zzms" id="zzms" title="zzms" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:1220px; left:200px;"/> <!-- musia byt inputy  -->

<!-- Suhrnne udaje -->
<div class="input-echo" style="width:220px; top:943px; left:487px;"><?php echo $r15; ?></div> <!-- dopyt, nie je funkËnÈ -->
<div class="input-echo" style="width:220px; top:982px; left:487px;"><?php echo $r16; ?></div> <!-- dopyt, nie je funkËnÈ -->
<input type="text" name="datum" id="datum" title="datum" onkeyup="CiarkaNaBodku(this);" onkeydown=""
       style="width:196px; top:1020px; left:510px;"/>




<?php                                        }
//koniec copern == 101, strana 1
?>


<?php if ( $copern == 101 AND $strana == 2 ) {

//VYPIS ZOZNAMU VOZIDIEL
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY cpl";

$sluz = mysql_query("$sqltt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <table class="vozidla">
 <caption>Zoznam 
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="NovÈ vozidlo">
 </caption>
 <thead>
  <tr>
   <td width="10%">DIC</td>
   <td width="35%">FO/PO</td>
   <td width="30%">prijem</td>
   <td width="10%">&nbsp;</td>
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
   <td><?php echo $rsluz->xdic;?></td>
   <td><?php echo $rsluz->xmfo." ".$rsluz->xpfo." ".$rsluz->xnpo;?></td>
   <td><?php echo $rsluz->prj;?></td>

   <td align="center">
    <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl;?>);" title="Upraviù ">&nbsp;&nbsp;
    <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl;?>);" title="Vymazaù ">
   </td>
  </tr>
 </tbody>
<?php
 }
$i=$i+1;
   }
?>
 </table>
</div>
<?php                                        }
//koniec copern == 101, strana 2
?>


<?php if ( $copern == 101 AND $strana == 3 ) { ?>




<img src="../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg"
     alt="tlaËivo Ozn·menie nepeÚaûnÈ plnenie 2.strana 221kB" class="form-background">



<!-- DRZITEL  -->

<input type="text" name="xdic" id="xdic" title="xdic" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:200px; left:200px;"/>

<input type="text" name="prj" id="prj" title="prj" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:200px; left:500px;"/>

<input type="text" name="xmfo" id="xmfo" title="xmfo" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:240px; left:200px;"/>

<input type="text" name="xpfo" id="xpfo" title="xpfo" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:280px; left:200px;"/>

<input type="text" name="xnpo" id="xnpo" title="xnpo" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:320px; left:200px;"/>

<input type="text" name="xuli" id="xuli" title="xuli" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:360px; left:200px;"/>

<input type="text" name="xcis" id="xcis" title="xcis" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:400px; left:200px;"/>

<input type="text" name="xpsc" id="xpsc" title="xpsc" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:440px; left:200px;"/>

<input type="text" name="xmes" id="xmes" title="xmes" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:480px; left:200px;"/>

<!-- vyplnil a pocet priloh cez echo  -->

<input type="text" name="datd" id="datd" title="datum" onkeyup="CiarkaNaBodku(this);" onkeydown=""
 style="width:110px; top:520px; left:200px;"/>




<?php                       }
//koniec copern == 101, strana 3
?>

</FORM>
</div> <!-- koniec #content -->


<?php
///////////////////////////////////////////////////VYTLAC oznamenie
if ( $copern == 40 )
{


}
///////////////////////////////////////////////////KONIEC TLAC oznamenie copern=40
?>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>