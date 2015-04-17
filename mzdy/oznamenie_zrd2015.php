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

$xtitulp = strip_tags($_REQUEST['xtitulp']);
$xtitulz = strip_tags($_REQUEST['xtitulz']);

$prj = 1*strip_tags($_REQUEST['prj']);
$datd = strip_tags($_REQUEST['datd']);
$datd_sql=SqlDatum($datd);


$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznameniezrdpol SET xdic='$xdic', xuli='$xuli', xcis='$xcis', xpsc='$xpsc', xmes='$xmes', ".
" xmfo='$xmfo', xpfo='$xpfo', xnpo='$xnpo', prj='$prj', datd='$datd_sql', xtitulp='$xtitulp', xtitulz='$xtitulz' ".
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
$dajnew=0;
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
if ( $copern == 101 OR $copern == 40 )
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
$xtitulp = $fir_riadok->xtitulp;
$xtitulz = $fir_riadok->xtitulz;

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

//suma dane
$celprj=0;
$sqlfir = "SELECT SUM(prj) AS sumprj FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $celprj=1*$riaddok->sumprj;
    }

$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET prj=$celprj WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=prj*19 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1/100 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET kkx1=kkx1-0.0049 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
$sqlfir = "UPDATE F$kli_vxcf"."_mzdoznameniezrd SET zrd=kkx1 WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");

$r15=0; $r16=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $r15=$riaddok->prj;
    $r16=$riaddok->zrd;
    }

$prilohy=0; $pocetdic=0; $pocetdic2=0; $pocetdic3=0;
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie";
$sqldok = mysql_query("$sqlfir");
if ( $sqldok ) { $pocetdic = mysql_num_rows($sqldok); }

$pocetdic2=$pocetdic-2;
$pocetdic3=$pocetdic2/3;
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
   document.formv1.xtitulp.value = "<?php echo $xtitulp; ?>";
   document.formv1.xtitulz.value = "<?php echo $xtitulz; ?>";

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
   window.open('oznamenie_zrd2015.php?copern=40&cislo_xplat=<?php echo $cislo_xplat; ?>&h_stv=<?php echo $zaobdobie; ?>&strana=9999', '_blank');
  }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }
//zoznam drzitelov
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


  function kopyZar(ulica, cislo, psc, mesto)
  {
   document.formv1.zzul.value = ulica;
   document.formv1.zzcs.value = cislo;
   document.formv1.zzps.value = psc;
   document.formv1.zzms.value = mesto;
   dzdrzar.style.display='none';

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
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";

$source="../mzdy/oznamenie_zrd2015.php?subor=0&h_stv=".$zaobdobie."&cislo_xplat=".$cislo_xplat;
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=1', '_self');"
    class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=2', '_self');"
    class="<?php echo $clas2; ?> toleft">Zoznam drûiteæov</a>
<?php if ( $strana == 3 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=3', '_self');"
    class="<?php echo $clas3; ?> toleft">⁄prava drûiteæa</a>
<?php                     } ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=40&strana=1', '_blank');"
    class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 2 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php                     } ?>
</div>

<?php if ( $copern == 101 AND $strana == 1 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str1.jpg"
     alt="tlaËivo Ozn·menie nepeÚaûnÈ plnenie 1.strana 243kB" class="form-background">

<!-- ZAHLAVIE -->
<input type="text" name="mdic" id="mdic" style="width:220px; top:340px; left:52px;"/>
<span class="text-echo" style="top:344px; left:723px;"><?php echo $zaobdobie; ?></span>
<span class="text-echo" style="top:344px; left:769px;"><?php echo $kli_vrok; ?></span>

<!-- PLATITEL -->
<!-- FO -->
<div class="input-echo" style="width:357px; top:452px; left:52px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:241px; top:452px; left:432px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:111px; top:452px; left:693px;"><?php echo $titulp; ?></div>
<div class="input-echo" style="width:66px; top:452px; left:827px;"><?php echo $titulz; ?></div>
<div class="input-echo" style="width:196px; top:505px; left:52px;"><?php echo $nar_sk; ?></div>
<!-- PO -->
<?php if ( $fir_uctt03 != 999 AND $cislo_xplat > 9999 ) { ?>
<div class="input-echo" style="width:840px; top:580px; left:52px;"><?php echo $fir_fnazx; ?></div>
<?php                           } ?>

<!-- Adresa -->
<div class="input-echo" style="width:634px; top:696px; left:52px;"><?php echo $zuli; ?></div>
<div class="input-echo" style="width:173px; top:696px; left:720px;"><?php echo $zcdm; ?></div>
<div class="input-echo" style="width:105px; top:750px; left:52px;"><?php echo $zpsc; ?></div>
<div class="input-echo" style="width:700px; top:750px; left:191px;"><?php echo $zmes; ?></div>

<!-- Adresa zdravotnickeho zariadenie -->
<input type="text" name="zzul" id="zzul" style="width:634px; top:823px; left:52px;"/>
<input type="text" name="zzcs" id="zzcs" style="width:173px; top:823px; left:719px;"/>
<input type="text" name="zzps" id="zzps" style="width:105px; top:879px; left:52px;"/>
<input type="text" name="zzms" id="zzms" style="width:701px; top:879px; left:191px;"/>
<img src="../obr/ikony/copy5_blue_x32.png" onclick="dzdrzar.style.display='block';"
     title="Zobraziù uloûenÈ adresy"
     style="width:32px; height:32px; position:absolute; top:780px; right:6px; cursor:pointer;">

<!-- Suhrnne udaje -->
<div class="input-echo" style="width:220px; top:943px; left:487px; text-align:right;"><?php echo $r15; ?></div>
<div class="input-echo" style="width:220px; top:982px; left:487px; text-align:right;"><?php echo $r16; ?></div>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);"
       style="width:196px; top:1020px; left:510px;"/>
<?php                                        }
//koniec copern == 101, strana 1
?>


<?php if ( $copern == 101 AND $strana == 2 ) {
//ZOZNAM DRZITELOV
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY cpl";
$sluz = mysql_query("$sqltt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <div>
  <h2 class="toleft" style="font-size:18px;">Drûitelia a v˝öka nepeÚaûnÈho plnenia</h2>
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="Nov˝ drûiteæ"
       class="toleft" style="margin:10px 0 0 10px;">
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
//koniec copern == 101, strana 2
?>


<?php if ( $copern == 101 AND $strana == 3 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg"
     alt="tlaËivo Ozn·menie nepeÚaûnÈ plnenie 2.strana 221kB" class="form-background">
<span class="text-echo" style="top:93px; left:182px;"><?php echo $mdic; ?></span>
<span class="text-echo" style="top:93px; left:528px;"><?php echo $zaobdobie; ?></span>
<span class="text-echo" style="top:93px; left:574px;"><?php echo $kli_vrok; ?></span>

<!-- DRZITEL  -->
<input type="text" name="xdic" id="xdic" style="width:220px; top:186px; left:52px;"/>
<input type="text" name="prj" id="prj" onkeyup="CiarkaNaBodku(this);" 
       style="width:220px; top:178px; left:630px;"/>
<?php if ( $dajnew == 1 ) { ?>
<img src="../obr/ikony/plus_lgreen_icon.png" onclick="NoveVzd();" title="Pridaù drûiteæa"
     style="position:absolute; top:134px; left:9px; width:24px; height:24px; cursor:pointer;">
<?php                     } ?>
<img src="../obr/ikony/copy5_blue_x32.png" title="KopÌrovaù ˙daje drûiteæa"
     style="width:32px; height:32px; position:absolute; top:130px; right:6px; cursor:pointer;">
<!-- FO -->
<input type="text" name="xpfo" id="xpfo" style="width:358px; top:262px; left:52px;"/>
<input type="text" name="xmfo" id="xmfo" style="width:244px; top:262px; left:431px;"/>
<input type="text" name="xtitulp" id="xtitulp" style="width:113px; top:262px; left:692px;"/>
<input type="text" name="xtitulz" id="xtitulz" style="width:67px; top:262px; left:827px;"/>
<!-- PO -->
<input type="text" name="xnpo" id="xnpo" style="width:842px; top:337px; left:52px;"/>

<!-- Adresa -->
<input type="text" name="xuli" id="xuli" style="width:634px; top:412px; left:52px;"/>
<input type="text" name="xcis" id="xcis" style="width:173px; top:412px; left:719px;"/>
<input type="text" name="xpsc" id="xpsc" style="width:105px; top:467px; left:52px;"/>
<input type="text" name="xmes" id="xmes" style="width:701px; top:467px; left:191px;"/>

<!-- vyplnil a pocet priloh cez echo  -->
<!-- Vypracoval -->
<div class="input-echo" style="width:310px; top:919px; left:52px;"><?php echo $fir_mzdt05; ?></div>
<input type="text" name="datd" id="datd" onkeyup="CiarkaNaBodku(this);"
       style="width:198px; top:918px; left:385px;"/>
<div class="input-echo" style="width:290px; top:919px; left:602px;"><?php echo $fir_mzdt04; ?></div>
<!-- Prilozene strany -->
<div class="input-echo" style="width:105px; top:989px; left:172px; text-align:right;"><?php echo $prilohy; ?></div>

<?php                       }
//koniec copern == 101, strana 3
?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=1', '_self');"
    class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=2', '_self');"
    class="<?php echo $clas2; ?> toleft">Zoznam drûiteæov</a>
<?php if ( $strana == 3 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=101&strana=3', '_self');"
    class="<?php echo $clas3; ?> toleft">⁄prava drûiteæa</a>
<?php                     } ?>
<?php if ( $strana != 2 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>

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
if ( File_Exists("../tmp/priznaniedmv.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/priznaniedmv.$kli_uzid.pdf"); }
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
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,63," ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//za obdobie
$pdf->Cell(98,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$zaobdobie","$rmc",0,"C");
$text=$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//FO
//priezvisko
$pdf->Cell(190,19,"","$rmc1",1,"L");
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

//ADRESA ZARIADENIA
//ulica
$pdf->Cell(190,11,"","$rmc1",1,"L");
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
$pdf->Cell(190,7,"","$rmc1",1,"L");
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
//riadok 15
$pdf->Cell(190,9," ","$rmc1",1,"L");
$hodx=100*$r15;
//if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",1,"C");
//riadok 16
$pdf->Cell(190,2," ","$rmc1",1,"L");
$hodx=100*$r16;
//if ( $hodx == 0 ) $hodx="";
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
$pdf->Cell(100,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
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
$pdf->Cell(105,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$da1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da2","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da4","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$da8","$rmc",1,"C");
                                       } //koniec 1.strany
}
$i = $i + 1;
  }

if ( $strana == 2 OR $strana == 9999 ) {
$sqlttv = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic ";
$sqlv = mysql_query("$sqlttv");
$polv = mysql_num_rows($sqlv);
$iv=0;

  while ($iv <= 1 )
  {
  if (@$zaznam=mysql_data_seek($sqlv,$iv))
{
$hlavickav=mysql_fetch_object($sqlv);

if ( $iv == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(31,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//za obdobie
$pdf->Cell(27,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$zaobdobie","$rmc",0,"C");
$text=$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//1.DRZITEL
$pdf->SetY(32);
}
//2.DRZITEL
if ( $iv == 1 ) {
$pdf->SetY(111);
                }

//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavickav->xdic;
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
$pdf->Cell(190,13,"","$rmc1",1,"L");
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
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,11,"","$rmc1",1,"L");
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

if ( $iv == 1 ) {
               
//Vypracoval
$pdf->SetY(205);
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
$text=$fir_mzdt04;
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t13","$rmc",1,"C");
//prilohy
$pdf->Cell(190,9,"","$rmc1",1,"L");
$textx=$prilohy;
if ( $textx == 0 ) $textx="";
$text=sprintf("% 5s",$textx);
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(30,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",1,"C");
                }
$iv = $iv + 1;
  }
                                       } //koniec 2.strany

if ( $strana == 3 OR $strana == 9999 ) {
$stranav=0;
$sqlttv = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ORDER BY xdic LIMIT 2,100 ";
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
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str3.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(31,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//za obdobie
$pdf->Cell(27,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$zaobdobie","$rmc",0,"C");
$text=$kli_vrok;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",1,"C");

//strana
$pdf->Cell(190,5,"","$rmc1",1,"L");
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

if ( $jv == 0 ) {
//1.DRZITEL V PRILOHE
$pdf->SetY(42);
                }

if ( $jv == 1 ) {
//2.DRZITEL V PRILOHE
$pdf->SetY(121);
                }

if ( $jv == 2 ) {
//3.DRZITEL V PRILOHE
$pdf->SetY(200);
                }
//dic
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavickav->xdic;
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
$pdf->Cell(190,13,"","$rmc1",1,"L");
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
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(190,11,"","$rmc1",1,"L");
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
if ( $jv == 3 ) { $jv=0; }
  }
                                       } //koniec 3.strany

$pdf->Output("../tmp/priznaniedmv.$kli_uzid.pdf");


$pdf->Output("../tmp/oznamzrd$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/oznamzrd<?php echo $kli_uzid; ?>.pdf","_self");
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