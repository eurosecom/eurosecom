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
$rmc=1;
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
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrdpol WHERE xplat = $cislo_xplat AND stvrt = $zaobdobie ";
$sqldok = mysql_query("$sqlfir");
if( $sqldok ) { $pocetdic = mysql_num_rows($sqldok); }

$pocetdic2=$pocetdic-2;
$pocetdic3=$pocetdic2/3;
$prilohy=ceil($pocetdic3);
if ( $prilohy < 0 ) { $prilohy=0; }



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
  border: 0px solid black;
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

  function VysvetlVypln()
  {
   window.open('../dokumenty/zdravpoist/dividendy_ZPv14_vysvetlivky.pdf', '_blank');
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
$nazovplat=$cislo_xplat." ".$oc." ".$meno." ".$prie;
if( $cislo_xplat > 9999 ) { $nazovplat=$cislo_xplat." ".$fir_fnazovx; }
?>
  <span class="subheader"><?php echo $nazovplat; ?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
<!--     <img src="../obr/ikony/info_blue_icon.png" onclick="VysvetlVypln();" title="Vysvetlivky" class="btn-form-tool"> dopyt, zatiaæ nie -->
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
<div class="input-echo" style="width:357px; top:452px; left:52px;"><?php echo $meno; ?></div>
<div class="input-echo" style="width:241px; top:452px; left:432px;"><?php echo $prie; ?></div>
<div class="input-echo" style="width:111px; top:452px; left:693px;"><?php echo $titulp; ?></div>
<div class="input-echo" style="width:66px; top:452px; left:827px;"><?php echo $titulz; ?></div>
<div class="input-echo" style="width:196px; top:505px; left:52px;"><?php echo $nar_sk; ?></div>
<!-- PO -->
<?php if ( $fir_uctt03 != 999 AND $cislo_xplat > 9999 ) { ?> <!-- dopyt, podmienku, aby nezobrazil pri vybratej firmy z RZ_dane.php -->
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
  <th width="12%">&nbsp;DI»</th>
  <th width="45%">FO / PO</th>
  <th width="15%" style="text-align:right;">PrijatÈ peÚaûnÈ plnenie</th>
  <th width="28%">&nbsp;</th>
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
<!-- FO -->
<input type="text" name="xpfo" id="xpfo" style="width:358px; top:262px; left:52px;"/>
<input type="text" name="xmfo" id="xmfo" style="width:244px; top:262px; left:431px;"/>
<input type="text" name="xtitulp" id="xtitulp" style="width:113px; top:262px; left:692px;"/> <!-- dopyt, nie je funkËnÈ -->
<input type="text" name="xtitulz" id="xtitulz" style="width:67px; top:262px; left:827px;"/> <!-- dopyt, nie je funkËnÈ -->
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
<div class="input-echo" style="width:105px; top:989px; left:172px;"><?php echo $prilohy; ?></div>

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
</div> <!-- koniec #content -->


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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");





























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

//1.drzitel
if ( $iv == 0 )  {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/oznamenie_zrd/ozn43a_v15_str2.jpg',0,0,210,297);
}
//toto je pociatocna vyska 1.drzitela na strane
$pdf->SetY(40);
$pdf->Cell(20,7," ","$rmc1",0,"R");$pdf->Cell(50,7,"$hlavickav->xdic","$rmc",1,"L");


//tuto budu tlace 1.drzitela


                 }

//2.drzitel
if ( $iv == 1 )  {
//toto je pociatocna vyska 2.drzitela na strane
$pdf->SetY(120);
$pdf->Cell(20,7," ","$rmc1",0,"R");$pdf->Cell(50,7,"$hlavickav->xdic","$rmc",1,"L");



//tuto budu tlace 2.drzitela


                 }
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
  if (@$zaznam=mysql_data_seek($sqlv,$iv) OR $polv == 0 )
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
//toto je pociatocna vyska 1.drzitela na strane
$pdf->SetY(40);
$pdf->Cell(20,7," ","$rmc1",0,"R");$pdf->Cell(50,7,"$hlavickav->xdic","$rmc",1,"L");


//tuto budu tlace 1.drzitela


                 }

if ( $jv == 1 )  {
//toto je pociatocna vyska 2.drzitela na strane
$pdf->SetY(140);
$pdf->Cell(20,7," ","$rmc1",0,"R");$pdf->Cell(50,7,"$hlavickav->xdic","$rmc",1,"L");


//tuto budu tlace 2.drzitela


                 }

if ( $jv == 2 )  {
//toto je pociatocna vyska 3.drzitela na strane
$pdf->SetY(200);
$pdf->Cell(20,7," ","$rmc1",0,"R");$pdf->Cell(50,7,"$hlavickav->xdic","$rmc",1,"L");


//tuto budu tlace 3.drzitela


                 }


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