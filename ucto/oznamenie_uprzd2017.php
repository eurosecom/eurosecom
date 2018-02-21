<!doctype html>
<HTML>
<?php
do
{
$sys = 'UCT';
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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16";
$jpg_popis="tlaËivo Ozn·menie o vykonanÌ ˙pravy z·kladu dane pre rok ".$kli_vrok;

$rokdmv=2015;
if ( $kli_vrok > 2015 ) { $rokdmv=2015; }

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 9999;
$subor = $_REQUEST['subor'];
$elsubor = $_REQUEST['elsubor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
$zoznamaut=1;

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
if ( $strana == 5 ) { $_REQUEST['cislo_cpl']=0; }

$xml = 1*$_REQUEST['xml'];

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//nastav dic
    if ( $copern == 1001 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$icoset = 1*$_REQUEST['icoset'];

$sqlttt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $icoset ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $zodic=$riaddok->dic;
 $zonaz=$riaddok->nai;
 $zouli=$riaddok->uli;
 $zomes=$riaddok->mes;
 $zopsc=$riaddok->psc;
 $zostat="SR";
 }


$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" zodic='$zodic', zonaz='$zonaz', ".
" zouli='$zouli', zocdm='$zocdm', zopsc='$zopsc', zomes='$zomes', zostat='$zostat', ".
" zoulava30a='$zoulava30a', zoulava30b='$zoulava30b', suma='$suma', datum='$datumsql' ".
" WHERE oc = 1 AND cpl = $cislo_cpl ";

$upravene = mysql_query("$uprtxt");



$copern=20;
$strana=1;
$zoznamaut=0;
    }
//koniec nastav dic

//uprav vozidlo
    if ( $copern == 346 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$copern=20;
$strana=1;
$zoznamaut=0;
    }
//koniec uprav vozidlo

//nove
    if ( $copern == 336 )
    {
$sql = "INSERT INTO F".$kli_vxcf."_uctoznamenie_uprzd (oc,konx1) VALUES ( 1, 0 ) ";
$vysledok = mysql_query($sql);

$cislo_cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 ORDER BY cpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_cpl=$riaddok->cpl;
 }
$copern=20;
$strana=1;
$zoznamaut=0;
$_REQUEST['cislo_cpl']=$cislo_cpl;
    }
//koniec nove

//zmaz
    if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_dic = 1*$_REQUEST['cislo_dic'];
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù subjekt s diË <?php echo $cislo_dic; ?> ?") )
         { location.href='oznamenie_uprzd2017.php?cislo_oc=9999&drupoh=1&page=1&subor=0&copern=20&strana=5&cislo_cpl=<?php echo $cislo_cpl; ?>' }
else
         { location.href='oznamenie_uprzd2017.php?copern=3166&page=1&drupoh=1&cislo_cpl=<?php echo $cislo_cpl; ?>' }
</script>
<?php
exit;
    }

    if ( $copern == 3166 )
    {

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sql = "DELETE FROM F".$kli_vxcf."_uctoznamenie_uprzd WHERE cpl = $cislo_cpl ";
$vysledok = mysql_query($sql);

$copern=20;
$strana=5;
$zoznamaut=1;
    }
//zmaz vozidlo


//zapis upravene udaje
if ( $copern == 23 )
     {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

if ( $strana == 1 ) {
$obod = $_REQUEST['obod'];
$obodsql=SqlDatum($obod);
$obdo = $_REQUEST['obdo'];
$obdosql=SqlDatum($obdo);
$zodic = strip_tags($_REQUEST['zodic']);
$ulava30a = 1*$_REQUEST['ulava30a'];
$ulava30b = 1*$_REQUEST['ulava30b'];
$zoprie = trim(strip_tags($_REQUEST['zoprie']));
$zomeno = trim(strip_tags($_REQUEST['zomeno']));
$zotitl = trim(strip_tags($_REQUEST['zotitl']));
$zotitz = trim(strip_tags($_REQUEST['zotitz']));
$zonaz = trim(strip_tags($_REQUEST['zonaz']));

$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" obod='$obodsql', obdo='$obdosql', zodic='$zodic', ulava30a='$ulava30a', ulava30b='$ulava30b', zoprie='$zoprie', ".
" zomeno='$zomeno', zotitl='$zotitl', zotitz='$zotitz', zonaz='$zonaz' ".
" WHERE oc = 1 AND cpl = $cislo_cpl ";
                    }

if ( $strana == 2 ) {
$zouli = trim(strip_tags($_REQUEST['zouli']));
$zocdm = trim(strip_tags($_REQUEST['zocdm']));
$zopsc = trim(strip_tags($_REQUEST['zopsc']));
$zomes = trim(strip_tags($_REQUEST['zomes']));
$zostat = trim(strip_tags($_REQUEST['zostat']));
$zoulava30a = 1*$_REQUEST['zoulava30a'];
$zoulava30b = 1*$_REQUEST['zoulava30b'];
$suma = strip_tags($_REQUEST['suma']);
$datum = $_REQUEST['datum'];
$datumsql=SqlDatum($datum);

$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" zouli='$zouli', zocdm='$zocdm', zopsc='$zopsc', zomes='$zomes', zostat='$zostat', ".
" zoulava30a='$zoulava30a', zoulava30b='$zoulava30b', suma='$suma', datum='$datumsql' ".
" WHERE oc = 1 AND cpl = $cislo_cpl ";
                    }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$copern=20;
     }
//koniec zapisu upravenych udajov




//vytvorenie
$sql = "SELECT iu30a FROM F".$kli_vxcf."_uctoznamenie_uprzd";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctoznamenie_uprzd';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cpl           int not null auto_increment,
   oc            INT(7) DEFAULT 0,
   datum         DATE NOT NULL,
   ico           DECIMAL(10,0) DEFAULT 0,
   iu30a         DECIMAL(1,0) DEFAULT 0,
   iu30b         DECIMAL(1,0) DEFAULT 0,
   suma          DECIMAL(10,2) DEFAULT 0,

   konx          DECIMAL(10,0) DEFAULT 0,
   konx1         DECIMAL(10,0) DEFAULT 0,
   konx2         DECIMAL(10,0) DEFAULT 0,
   konx3         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctoznamenie_uprzd'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_uctoznamenie_uprzd (oc,konx1) VALUES ( 9999, 0 ) ";
$vysledok = mysql_query($sql);
}

$sql = "SELECT ulava30b FROM F".$kli_vxcf."_uctoznamenie_uprzd";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zodic DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zoprie VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zomeno VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zotitl VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zotitz VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zonaz VARCHAR(50) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zouli VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zocdm VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zopsc VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zomes VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zostat VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zoulava30a DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD zoulava30b DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD vypr VARCHAR(40) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD ulava30a DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD ulava30b DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT obdo FROM F".$kli_vxcf."_uctoznamenie_uprzd";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD obod DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD obdo DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd MODIFY suma DECIMAL(12,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenie
?>

<?php
//nacitaj udaje pre upravu
if ( $copern == 20 OR $copern == 110 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd".
" WHERE oc = 1 AND cpl = $cislo_cpl ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 OR $strana == 9999 ) {
$obod = $fir_riadok->obod;
$obodsk=SkDatum($obod);
if( $obodsk == '00.00.0000' ) { $obodsk="01.01.".$kli_vrok;}
$obdo = $fir_riadok->obdo;
$obdosk=SkDatum($obdo);
if( $obdosk == '00.00.0000' ) { $obdosk="31.12.".$kli_vrok;}
$zodic = $fir_riadok->zodic;
$ulava30a = $fir_riadok->ulava30a;
$ulava30b = $fir_riadok->ulava30b;
$zoprie = $fir_riadok->zoprie;
$zomeno = $fir_riadok->zomeno;
$zotitl = $fir_riadok->zotitl;
$zotitz = $fir_riadok->zotitz;
$zonaz = $fir_riadok->zonaz;
                    }

if ( $strana == 2 OR $strana == 9999) {
$zouli = $fir_riadok->zouli;
$zocdm = $fir_riadok->zocdm;
$zopsc = $fir_riadok->zopsc;
$zomes = $fir_riadok->zomes;
$zostat = $fir_riadok->zostat;
$zoulava30a = $fir_riadok->zoulava30a;
$zoulava30b = $fir_riadok->zoulava30b;
$suma = $fir_riadok->suma;
$datum = $fir_riadok->datum;
$datumsk=SkDatum($datum);
                    }


mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//udaje o FO z ufirdalsie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
$dtitz = "";
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dstat = "SK";
}
if ( $fir_uctt03 == 999 )
{
$fir_fnaz = "";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Ozn·menie o ˙prave ZD</title>
<style type="text/css">
tr.zero-line > td {
  border: 0 !important;
  height: 0 !important;
}
div.wrap-vozidla {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.vozidla {
  width: 900px;
  margin: 16px auto;
  background-color: ;
}
table.vozidla caption {
  height: 24px;
  font-weight: bold;
  font-size: 14px;
  text-align: left;
}
.btn-item-new {
  position: absolute;
  top: 34px;
  left: 170px;
  cursor: pointer;
  font-weight: bold;
  color: #fff;
  font-size: 10px;
  padding: 8px 12px 7px 12px;
  border-radius: 2px;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
  text-transform: uppercase;
  background-color: #1ccc66;
}
a.btn-item-new:hover {
  background-color: #1abd5f;
}

table.vozidla tr.body:hover {
  background-color: #f1faff;
}
table.vozidla th {
  height: 14px;
  vertical-align: middle;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.vozidla td {
  height: 28px;
  line-height: 28px;
  border-top: 2px solid #add8e6;
  font-size: 14px;
}
table.vozidla td img {
  width: 18px;
  height: 18px;
  vertical-align: text-bottom;
  cursor: pointer;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
.tooltip-body ul li {
  font-size: 13px;
  line-height: 20px;
}
.tooltip-body ul li strong {
  font-size: 14px;
}
#content > p {
  line-height: 22px;
  font-size: 14px;
}
#content > p > a {
  color: #00e;
}
#content > p > a:hover {
  text-decoration: underline;
}
#upozornenie > h2 {
  line-height: 20px;
  margin-top: 25px;
  margin-bottom: 10px;
  overflow: auto;
}
#upozornenie > h2 > strong {
  font-size: 16px;
  font-weight: bold;
}
#upozornenie > ul > li {
  line-height: 18px;
  margin: 10px 0;
  font-size: 13px;
}
.red {
  border-left: 4px solid #f22613;
  text-indent: 8px;
}
.orange {
  border-left: 4px solid #f89406;
  text-indent: 8px;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 11px;
  position: relative;
  top: 5px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
.box-red {
  background-color: #f22613;
}
.box-orange {
  background-color: #f89406;
}
.header-section {
  padding-top: 5px;
}
</style>
<script type="text/javascript">
//parameter okna
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

<?php
//uprava
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
   document.formv1.obod.value = '<?php echo "$obodsk"; ?>';
   document.formv1.obdo.value = '<?php echo "$obdosk";?>';
   document.formv1.zodic.value = '<?php echo "$zodic"; ?>';
<?php if ( $ulava30a == 1 ) { ?> document.formv1.ulava30a.checked = "checked"; <?php } ?>
<?php if ( $ulava30b == 1 ) { ?> document.formv1.ulava30b.checked = "checked"; <?php } ?>
   document.formv1.zoprie.value = '<?php echo "$zoprie"; ?>';
   document.formv1.zomeno.value = '<?php echo "$zomeno"; ?>';
   document.formv1.zotitl.value = '<?php echo "$zotitl"; ?>';
   document.formv1.zotitz.value = '<?php echo "$zotitz"; ?>';
   document.formv1.zonaz.value = '<?php echo "$zonaz"; ?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
   document.formv1.zouli.value = '<?php echo "$zouli"; ?>';
   document.formv1.zocdm.value = '<?php echo "$zocdm"; ?>';
   document.formv1.zopsc.value = '<?php echo "$zopsc"; ?>';
   document.formv1.zomes.value = '<?php echo "$zomes"; ?>';
   document.formv1.zostat.value = '<?php echo "$zostat"; ?>';
<?php if ( $zoulava30a == 1 ) { ?> document.formv1.zoulava30a.checked = "checked"; <?php } ?>
<?php if ( $zoulava30b == 1 ) { ?> document.formv1.zoulava30b.checked = "checked"; <?php } ?>
   document.formv1.suma.value = '<?php echo "$suma"; ?>';
   document.formv1.datum.value = '<?php echo "$datumsk"; ?>';
<?php                                        } ?>
   }
<?php
//koniec uprava
  }
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

  function TlacDMV(cpl)
  {
   window.open('../ucto/oznamenie_uprzd2017.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999&cislo_cpl=' + cpl + '&tt=1', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function PoucVyplnenie()
  {
   window.open('<?php echo $jpg_cesta; ?>_poucenie.pdf', '_blank', param);
  }
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd2017.php?copern=346&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function ZmazVzd(cpl, cislo_dic)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd2017.php?copern=316&cislo_cpl='+ cislo_cpl + '&cislo_dic='+ cislo_dic + '&uprav=0', '_self' )
  }
  function NoveVzd()
  {
   window.open('../ucto/oznamenie_uprzd2017.php?copern=336&uprav=0', '_self' )
  }
  function DMVdoXML(cpl, cislo_dic)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd2017.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&cislo_cpl=' + cislo_cpl + '&cislo_dic=' + cislo_dic + '&elsubor=2&strana=9999',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
  if ( $copern == 20 )
  {
if( $strana == 5 ) { $cislo_cpl=0; }
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Ozn·menie o ˙prave z·kladu dane <?php echo $kli_vrok; ?></td>
   <td>
    <div class="bar-btn-form-tool">
<?php if ( $strana != 5 ) { ?>
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="DMVdoXML(<?php echo $cislo_cpl; ?>, '<?php echo $zodic; ?>');" title="Export do XML" class="btn-form-tool">
<?php } ?>
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();" title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacDMV(<?php echo $cislo_cpl; ?>);" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="oznamenie_uprzd2017.php?copern=23&cislo_oc=1&cislo_cpl=<?php echo $cislo_cpl;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active";

$source="../ucto/oznamenie_uprzd2017.php?cislo_oc=1&drupoh=1&page=1&subor=0&cislo_cpl=$cislo_cpl";
?>
<div class="navbar">
<?php if ( $strana != 5 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
<?php } ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Subjekty</a>
<?php if ( $strana != 5 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php } ?>
<?php if ( $strana != 5 ) { ?> <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave"> <?php } ?>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" alt="<?php echo $jpg_popis; ?> 1.strana" class="form-background">
<!-- hlavicka -->
<span class="text-echo" style="top:325px; left:57px;"><?php echo $fir_fdic; ?></span>
<!-- Za obdobie -->
<input type="text" name="obod" id="obod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:319px; left:404px;"/>
<input type="text" name="obdo" id="obdo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:319px; left:651px;"/>

<!-- I. ODDIEL -->
<!-- Udaje o FO -->
<div class="input-echo" style="width:359px; top:434px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:244px; top:434px; left:432px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:112px; top:434px; left:696px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:68px; top:434px; left:827px;"><?php echo $dtitz; ?></div>
<!-- Udaje o PO -->
<div class="input-echo" style="width:842px; top:512px; left:52px;"><?php echo $fir_fnaz; ?></div>
<!-- Adresa -->
<div class="input-echo" style="width:635px; top:628px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:175px; top:628px; left:718px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:107px; top:683px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:451px; top:683px; left:178px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:683px; left:649px;"><?php echo $dstat; ?></div>
<input type="checkbox" name="ulava30a" value="1" style="top:721px; left:54px;">
<input type="checkbox" name="ulava30b" value="1" style="top:743px; left:54px;">

<!-- II.ODDIEL -->
<input type="text" name="zodic" id="zodic" style="width:220px; top:823px; left:52px;" onclick="myIcoElement.style.display='none';"/>

<!-- FO -->
<input type="text" name="zoprie" id="zoprie" style="width:357px; top:901px; left:52px;"/>
<input type="text" name="zomeno" id="zomeno" style="width:243px; top:901px; left:431px;"/>
<input type="text" name="zotitl" id="zotitl" style="width:112px; top:901px; left:694px;"/>
<input type="text" name="zotitz" id="zotitz" style="width:66px; top:901px; left:827px;"/>
<!-- PO -->
<input type="text" name="zonaz" id="zonaz" style="width:840px; top:980px; left:52px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" alt="<?php echo $jpg_popis; ?> 2.strana" class="form-background">
<span class="text-echo" style="top:94px; left:310px;"><?php echo $fir_fdic;?></span>

<!-- II.ODDIEL pokracovanie -->
<!-- Adresa -->
<input type="text" name="zouli" id="zouli" style="width:635px; top:172px; left:51px;"/>
<input type="text" name="zocdm" id="zocdm" style="width:175px; top:172px; left:718px;"/>
<input type="text" name="zopsc" id="zopsc" style="width:107px; top:228px; left:51px;"/>
<input type="text" name="zomes" id="zomes" style="width:451px; top:228px; left:178px;"/>
<input type="text" name="zostat" id="zostat" style="width:243px; top:228px; left:650px;"/>
<input type="checkbox" name="zoulava30a" value="1" style="top:266px; left:54px;">
<input type="checkbox" name="zoulava30b" value="1" style="top:289px; left:54px;">
<!-- III.ODDIEL -->
<input type="text" name="suma" id="suma" onkeyup="CiarkaNaBodku(this);" style="width:288px; top:353px; left:478px;"/>
<!-- Vypracoval -->
<div class="input-echo" style="top:418px; left:53px; width:308px;"><?php echo $fir_mzdt05; ?></div>
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);" style="width:197px; top:417px; left:385px;"/>
<div class="input-echo" style="top:419px; left:603px; width:290px;"><?php echo $fir_mzdt04; ?></div>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) {
//VYPIS ZOZNAMU
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 ORDER BY zodic ";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <a href="#" onclick="NoveVzd();" title="Pridaù subjekt" class="btn-item-new" >+ Subjekt</a>
<table class="vozidla">
<caption>Zoznam subjektov</caption>
<tr class="zero-line">
 <td style="width:4%;"></td><td style="width:11%;"></td><td style="width:32%;"></td>
 <td style="width:23%;"></td><td style="width:10%;"></td><td style="width:20%;"></td>
</tr>
<tr>
 <th>#</th>
 <th align="left">DI»</th>
 <th align="left">N·zov</th>
 <th align="left">Obec</th>
 <th align="right">Suma ˙pravy</th>
 <th>&nbsp;</th>
</tr>
<?php
$i=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
 {
$rsluz=mysql_fetch_object($sluz);
$cisloi=$i+1;
?>
<tr class="body">
 <td align="center"><?php echo "$cisloi."; ?></td>
 <td><?php echo $rsluz->zodic; ?></td>
 <td><?php echo $rsluz->zonaz.$rsluz->zoprie." ".$rsluz->zomeno; ?></td>
 <td><?php echo $rsluz->zomes; ?></td>
 <td align="right"><?php echo $rsluz->suma; ?></td>
 <td align="right">
  <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl; ?>);" title="Upraviù">&nbsp;&nbsp;&nbsp;
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl; ?>, '<?php echo $rsluz->zodic; ?>');" title="Vymazaù">&nbsp;&nbsp;&nbsp;
  <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacDMV(<?php echo $rsluz->cpl; ?>);" title="Zobraziù v PDF">&nbsp;&nbsp;&nbsp;
  <img src="../obr/ikony/upbox_blue_icon.png" onclick="DMVdoXML(<?php echo $rsluz->cpl; ?>, '<?php echo $rsluz->zodic; ?>');" title="Export do XML">
&nbsp;&nbsp;&nbsp;</td>
</tr>
<?php
 }
$i=$i+1;
   }
?>
 </table>
</div>
<?php                                        } ?>

<div class="navbar">
<?php if ( $strana != 5 ) { ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <?php } ?>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Subjekty</a>
<?php if ( $strana != 5 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>


<?php if ( $strana == 1 ) { ?>
<script src="../jquery/jquery-3.1.1.min.js"></script>
<img src='../obr/ikony/searchl_blue_icon.png' id="buttjson" name="buttjson" title="Vyhæadaù DI»" style="width: 20px; height: 20px; position: absolute; top: 826px; left:290px; cursor: pointer;" >
<div id="myIcoElement"></div>
<style>
.div-ponuka {
  position: absolute;
  top: 854px;
  left: 52px;
  padding: 7px 20px;
  box-sizing: border-box;
  background-color: #fff;
  border-bottom: 1px solid #c4c4c4;
  border-left: 1px solid #d3d3d3;
  border-right: 1px solid #d3d3d3;
  border-top: 1px solid #d3d3d3;
  box-shadow: 0 1px 0 rgba(0,0,0,0.07);
  border-radius: 2px;
  overflow: auto;
  max-height: 450px;
}
.odb-ponuka tr {
  background-color: #fff;
  border-bottom: 1px solid lightblue;
  line-height: 26px;
}
.odb-ponuka tr:last-child {
  border-bottom: 0;
}
.odb-ponuka tr:first-child:hover {
  background-color: transparent;
}
.odb-ponuka tr:hover {
  background-color: #eee;
}
.odb-ponuka th {
  font-size: 11px;
  text-align: left;
  height: 14px;
  padding: 0 7px;
}
.odb-ponuka td {
  padding: 0 7px;
  font-size: 12px;
}
.odb-ponuka td img {
  cursor: pointer;
  display: inline-block;
  top: 4px;
  width: 18px;
  height: 18px;
  position: relative;
  top: 5px;
}
</style>
<script type="text/javascript">
  $("#buttjson").click(function( event )
  {
    $( "#myIcoElement" ).empty();
    $( "#myIcoElement" ).show( "fast", function()
       {
    // Animation complete.
       });
       event.preventDefault();
       var jsonAPI = "oznamenie_uprzd_jsonico.php";
       var zodic = $( "#zodic" ).val();
       if ($.trim($("#zodic").val()) != '')
       {
         $.getJSON(jsonAPI, {
           tags: "xxxxxx",
           prm1: zodic
          })
           .done(function (data)
           {
             $("<div id='divponuka' class='div-ponuka'></div>").appendTo("#myIcoElement");
             $("<table id='tableponuka' class='odb-ponuka'>" +
                "<tr>" +
                 "<th style=''>DI»</th>" +
                 "<th style=''>N·zov</th>" +
                 "<th style=''>Ulica</th>" +
                 "<th style=''>Mesto</th>" +
                 "<th style=''>PS»</th>" +
                 "<th style=''></th>" +
                "</tr>" +
               "</table>").appendTo("#divponuka");
             $.each(data.firmy, function (i, item) {
               $("<tr>" +
                  "<td>" + item.dic + "</td>" +
                  "<td>" + item.nai + "</td>" +
                  "<td>" + item.uli + "</td>" +
                  "<td>" + item.mes + "</td>" +
                  "<td>" + item.psc + "</td>" +
                  "<td><img src='../obr/ok.png' title='Vybraù' onclick=\"vykonajIco('" + item.ico + "','" + item.dic + "','" + item.nai + "','" + item.uli + "','" + item.mes + "','" + item.psc + "')\"></td>" +
                 "</tr>").appendTo("#tableponuka");
                 if (i === 300) { return false; } });
           });
         }
  });
</script>
<script type="text/javascript">


//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,dic,nazov,ulica,mesto,psc)
                {
document.forms.formv1.zodic.value = dic;
document.forms.formv1.zonaz.value = nazov;
document.forms.formv1.zodic.focus();
document.forms.formv1.zodic.select();
myIcoElement.style.display='none';

window.open('oznamenie_uprzd2017.php?copern=1001&icoset=' + ico + '&cislo_cpl=<?php echo $cislo_cpl; ?>', '_self' );


                }

</script>
<?php                    } ?>
</div> <!-- #content formul·r -->
<?php
//mysql_free_result($vysledok);
  }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC
if ( $copern == 10 )
{
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/oznuprzd_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/oznuprzd_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 AND cpl = $cislo_cpl ORDER BY zodic ";
if( $cislo_cpl == 0 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 AND cpl > 0 ORDER BY zodic "; }

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

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,58," ","$rmc1",1,"L");
$text="1234567890";
$text=$fir_fdic;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");

//za zdanovacie obdobie
$text=SkDatum($hlavicka->obod);
//if ( $text =='00.00.0000' ) $text="01.01.".$kli_vrok;
//$text="01.01.2016";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(27,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$text=SkDatum($hlavicka->obdo);
//if ( $text =='00.00.0000' ) $text="31.12.".$kli_vrok;
//$text="31.12.2016";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(11,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//I.ODDIEL
//priezvisko,meno a titul FO
$pdf->Cell(190,20," ","$rmc1",1,"L");
$A=substr($dprie,0,1);
$B=substr($dprie,1,1);
$C=substr($dprie,2,1);
$D=substr($dprie,3,1);
$E=substr($dprie,4,1);
$F=substr($dprie,5,1);
$G=substr($dprie,6,1);
$H=substr($dprie,7,1);
$I=substr($dprie,8,1);
$J=substr($dprie,9,1);
$K=substr($dprie,10,1);
$L=substr($dprie,11,1);
$M=substr($dprie,12,1);
$N=substr($dprie,13,1);
$O=substr($dprie,14,1);
$P=substr($dprie,15,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$A=substr($dmeno,0,1);
$B=substr($dmeno,1,1);
$C=substr($dmeno,2,1);
$D=substr($dmeno,3,1);
$E=substr($dmeno,4,1);
$F=substr($dmeno,5,1);
$G=substr($dmeno,6,1);
$H=substr($dmeno,7,1);
$I=substr($dmeno,8,1);
$J=substr($dmeno,9,1);
$K=substr($dmeno,10,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$dtitl","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$dtitz","$rmc",1,"L");
//obchodne meno PO
$pdf->Cell(190,12.5," ","$rmc1",1,"L");
if ( $fir_uctt03 == 999 ) $fir_fnaz="";
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
//ulica
$pdf->Cell(190,19," ","$rmc1",1,"L");
$text=$duli;
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
//cislo
$text=$dcdm;
$textxx="111122";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");
//psc
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$dpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
//obec
$text=$dmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
//stat
$text=$dstat;
$textxx="SK";
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");
//Ulava
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->ulava30a == 1 ) { $text="x"; }
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text","$rmc",1,"C");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->ulava30b == 1 ) { $text="x"; }
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text","$rmc",1,"C");

//II.ODDIEL
//dic ZO
$pdf->Cell(190,16," ","$rmc1",1,"L");
$text="1234567890";
$text=$hlavicka->zodic;
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
//priezvisko,meno a tituly ZO
$pdf->Cell(190,17," ","$rmc1",1,"L");
$A=substr($hlavicka->zoprie,0,1);
$B=substr($hlavicka->zoprie,1,1);
$C=substr($hlavicka->zoprie,2,1);
$D=substr($hlavicka->zoprie,3,1);
$E=substr($hlavicka->zoprie,4,1);
$F=substr($hlavicka->zoprie,5,1);
$G=substr($hlavicka->zoprie,6,1);
$H=substr($hlavicka->zoprie,7,1);
$I=substr($hlavicka->zoprie,8,1);
$J=substr($hlavicka->zoprie,9,1);
$K=substr($hlavicka->zoprie,10,1);
$L=substr($hlavicka->zoprie,11,1);
$M=substr($hlavicka->zoprie,12,1);
$N=substr($hlavicka->zoprie,13,1);
$O=substr($hlavicka->zoprie,14,1);
$P=substr($hlavicka->zoprie,15,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$A=substr($hlavicka->zomeno,0,1);
$B=substr($hlavicka->zomeno,1,1);
$C=substr($hlavicka->zomeno,2,1);
$D=substr($hlavicka->zomeno,3,1);
$E=substr($hlavicka->zomeno,4,1);
$F=substr($hlavicka->zomeno,5,1);
$G=substr($hlavicka->zomeno,6,1);
$H=substr($hlavicka->zomeno,7,1);
$I=substr($hlavicka->zomeno,8,1);
$J=substr($hlavicka->zomeno,9,1);
$K=substr($hlavicka->zomeno,10,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$hlavicka->zotitl","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$hlavicka->zotitz","$rmc",1,"L");
//obchodne meno ZO
$pdf->Cell(190,12.5," ","$rmc1",1,"L");
if ( $fir_uctt03 == 999 ) $fir_fnaz="";
$A=substr($hlavicka->zonaz,0,1);
$B=substr($hlavicka->zonaz,1,1);
$C=substr($hlavicka->zonaz,2,1);
$D=substr($hlavicka->zonaz,3,1);
$E=substr($hlavicka->zonaz,4,1);
$F=substr($hlavicka->zonaz,5,1);
$G=substr($hlavicka->zonaz,6,1);
$H=substr($hlavicka->zonaz,7,1);
$I=substr($hlavicka->zonaz,8,1);
$J=substr($hlavicka->zonaz,9,1);
$K=substr($hlavicka->zonaz,10,1);
$L=substr($hlavicka->zonaz,11,1);
$M=substr($hlavicka->zonaz,12,1);
$N=substr($hlavicka->zonaz,13,1);
$O=substr($hlavicka->zonaz,14,1);
$P=substr($hlavicka->zonaz,15,1);
$R=substr($hlavicka->zonaz,16,1);
$S=substr($hlavicka->zonaz,17,1);
$T=substr($hlavicka->zonaz,18,1);
$U=substr($hlavicka->zonaz,19,1);
$V=substr($hlavicka->zonaz,20,1);
$W=substr($hlavicka->zonaz,21,1);
$X=substr($hlavicka->zonaz,22,1);
$Y=substr($hlavicka->zonaz,23,1);
$Z=substr($hlavicka->zonaz,24,1);
$A1=substr($hlavicka->zonaz,25,1);
$B1=substr($hlavicka->zonaz,26,1);
$C1=substr($hlavicka->zonaz,27,1);
$D1=substr($hlavicka->zonaz,28,1);
$E1=substr($hlavicka->zonaz,29,1);
$F1=substr($hlavicka->zonaz,30,1);
$G1=substr($hlavicka->zonaz,31,1);
$H1=substr($hlavicka->zonaz,32,1);
$I1=substr($hlavicka->zonaz,33,1);
$J1=substr($hlavicka->zonaz,34,1);
$K1=substr($hlavicka->zonaz,35,1);
$L1=substr($hlavicka->zonaz,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,5," ","$rmc1",1,"L");
$textxx="0123456789";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
//if( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
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
$pdf->Cell(60,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

//II.ODDIEL pokracovanie
//ulica ZO
$pdf->Cell(190,12," ","$rmc1",1,"L");
$text=$hlavicka->zouli;
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t14","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t15","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t16","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t17","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t18","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t19","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t20","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t21","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t22","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t23","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t24","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t25","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t26","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t27","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t28","$rmc",0,"C");
//cislo ZO
$text=$hlavicka->zocdm;
$textxx="111122";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",1,"C");
//psc ZO
$pdf->Cell(190,6," ","$rmc1",1,"L");
$text=$hlavicka->zopsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
//obec ZO
$text=$hlavicka->zomes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(2,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
//stat ZO
$text=$hlavicka->zostat;
$textxx="SK";
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");
//Ulava ZO
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zoulava30a == 1 ) { $text="x"; }
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text","$rmc",1,"C");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=" ";
if ( $hlavicka->zoulava30b == 1 ) { $text="x"; }
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(3,3,"$text","$rmc",1,"C");

//III.ODDIEL
//suma upravy
$pdf->Cell(190,12," ","$rmc1",1,"L");
$hodx=100*$hlavicka->suma;
if ( $hodx == 0 ) $hodx="";
$text=sprintf('% 12s',$hodx);
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
$pdf->Cell(97,6," ","$rmc1",0,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",1,"C");

//Vypracoval
$pdf->Cell(190,8.5," ","$rmc1",1,"L");
$text=$fir_mzdt05;
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(69,6,"$text","$rmc",0,"L");

//Dna
$text=SKDatum($hlavicka->datum);
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t03","$rmc",0,"L");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"L");
$pdf->Cell(14,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t05","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"R");

//Telefon
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
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"R");$pdf->Cell(2,7," ","$rmc1",0,"L");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",1,"C");
                                       } //koniec 2.strany


}
$i = $i + 1;
  }
$pdf->Output("$outfilex");


?>
<script type="text/javascript"> var okno = window.open("<?php echo $outfilex; ?>","_self"); </script>
<?php


}
//koniec copern 10 VYTLAC
?>


<?php
//XML SUBOR elsubor=2
if ( $copern == 110 AND $elsubor == 2  )
     {
$cislo_dic = 1*$_REQUEST['cislo_dic'];
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Ozn·menie o ˙prave ZD / Export XML - <span class="subheader"><?php echo $cislo_dic." ".$zonaz.$zoprie." ".$zomeno; ?></span></td>
   <td></td>
  </tr>
 </table>
</div>
<?php

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$idx=$kli_uzid.$hhmm;

$nazsub="OZNAMENIEv176_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;

//FO - priezvisko,meno,tituly a trvaly pobyt z ufirdalsie
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok )
     {
$riadok=mysql_fetch_object($vysledok);
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
//$dtel = $riadok->dtel;
     }

//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");

//rok2016
$sqlt = <<<mzdprc
(

);
mzdprc;


//hlavicka
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 AND cpl = $cislo_cpl ORDER BY zodic ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);
  $text = "<hlavicka>"."\r\n"; fwrite($soubor, $text);
$dic=$fir_fdic;
  $text = " <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);

  $text = " <zaObdobie>"."\r\n"; fwrite($soubor, $text);
$hodnota=SkDatum($hlavicka->obod);
//if ( $hodnota == '00.00.0000' ) { $hodnota="01.01.".$kli_vrok; }
  $text = "  <datumOd><![CDATA[".$hodnota."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
$hodnota=SkDatum($hlavicka->obdo);
//if ( $hodnota == '00.00.0000' ) { $hodnota="31.12.".$kli_vrok; }
  $text = "  <datumDo><![CDATA[".$hodnota."]]></datumDo>"."\r\n"; fwrite($soubor, $text);
  $text = " </zaObdobie>"."\r\n"; fwrite($soubor, $text);

//udaje o FO z ufirdalsie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dstat = "SK";
}
//I.ODDIEL
  $text = " <fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <priezvisko><![CDATA[".$hodnota."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <meno><![CDATA[".$hodnota."]]></meno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <titulPred><![CDATA[".$hodnota."]]></titulPred>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <titulZa><![CDATA[".$hodnota."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
  $text = " </fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);
  $text = "  <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $fir_fnaz);
if ( $fir_uctt03 == 999 ) { $hodnota=""; }
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$hodnota="";
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = " </pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <sidlo>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $duli);
  $text = "  <ulica><![CDATA[".$hodnota."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$hodnota=$dcdm;
  $text = "  <supisneOrientacneCislo><![CDATA[".$hodnota."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$dpsc;
  $text = "  <psc><![CDATA[".$hodnota."]]></psc>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dmes);
  $text = "  <obec><![CDATA[".$hodnota."]]></obec>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $dstat);
  $text = "  <stat><![CDATA[".$hodnota."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = " </sidlo>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavicka->ulava30a;
  $text = " <ulava30a><![CDATA[".$hodnota."]]></ulava30a>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavicka->ulava30b;
  $text = " <ulava30b><![CDATA[".$hodnota."]]></ulava30b>"."\r\n"; fwrite($soubor, $text);
  $text = "</hlavicka>"."\r\n"; fwrite($soubor, $text);

//II.ODDIEL
  $text = "<zavislaOsoba>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zodic;
  $text = " <dic><![CDATA[".$hodnota."]]></dic>"."\r\n"; fwrite($soubor, $text);
  $text = " <fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zoprie);
  $text = "  <priezvisko><![CDATA[".$hodnota."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zomeno);
  $text = "  <meno><![CDATA[".$hodnota."]]></meno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zotitl);
  $text = "  <titulPred><![CDATA[".$hodnota."]]></titulPred>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zotitz);
  $text = "  <titulZa><![CDATA[".$hodnota."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
  $text = " </fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);
  $text = "  <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zonaz);
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$hodnota="";
  $text = "   <riadok><![CDATA[".$hodnota."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = " </pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);

  $text = " <sidlo>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zouli);
  $text = "  <ulica><![CDATA[".$hodnota."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zocdm;
  $text = "  <supisneOrientacneCislo><![CDATA[".$hodnota."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->zopsc;
  $text = "  <psc><![CDATA[".$hodnota."]]></psc>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zomes);
  $text = "  <obec><![CDATA[".$hodnota."]]></obec>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $hlavicka->zostat);
  $text = "  <stat><![CDATA[".$hodnota."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = " </sidlo>"."\r\n"; fwrite($soubor, $text);

$hodnota=1*$hlavicka->zoulava30a;
  $text = " <ulava30a><![CDATA[".$hodnota."]]></ulava30a>"."\r\n"; fwrite($soubor, $text);
$hodnota=1*$hlavicka->zoulava30b;
  $text = " <ulava30b><![CDATA[".$hodnota."]]></ulava30b>"."\r\n"; fwrite($soubor, $text);
  $text = "</zavislaOsoba>"."\r\n"; fwrite($soubor, $text);

//III.ODDIEL
  $text = " <upravaZakladu>"."\r\n"; fwrite($soubor, $text);
$hodnota=$hlavicka->suma;
if ( $hodnota == 0 ) $hodnota="";
  $text = "  <suma><![CDATA[".$hodnota."]]></suma>"."\r\n"; fwrite($soubor, $text);
  $text = " </upravaZakladu>"."\r\n"; fwrite($soubor, $text);

  $text = " <vypracoval>"."\r\n"; fwrite($soubor, $text);
$hodnota=iconv("CP1250", "UTF-8", $fir_mzdt05);
  $text = "  <vypracoval><![CDATA[".$hodnota."]]></vypracoval>"."\r\n"; fwrite($soubor, $text);

$hodnota=SkDatum($hlavicka->datum);
  $text = "  <dna><![CDATA[".$hodnota."]]></dna>"."\r\n"; fwrite($soubor, $text);
$hodnota=$fir_mzdt04;
  $text = "  <telefon><![CDATA[".$hodnota."]]></telefon>"."\r\n"; fwrite($soubor, $text);
$hodnota="1";
  $text = "  <podpis><![CDATA[".$hodnota."]]></podpis>"."\r\n"; fwrite($soubor, $text);
  $text = " </vypracoval>"."\r\n"; fwrite($soubor, $text);

  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div id="content" style="box-sizing: border-box; background-color: white; padding: 30px 25px;">
<?php if ( $elsubor == 2 ) { ?>
<p>Stiahnite si niûöie uveden˝ s˙bor <strong>.xml</strong> do V·öho poËÌtaËa a naËÌtajte ho na
<a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Str·nka FinanËnej spr·vy">www.financnasprava.sk</a> alebo do aplik·cie eDane:
</p>
<p>
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
</p>
<?php                      } ?>

<?php
/////////////////////////////////////////////////////////////////////UPOZORNENIE
$upozorni1=0; $upozorni2=0;
?>
<div id="upozornenie" style="display:none;">
<h2>
<strong class="toleft">Upozornenie</strong>
<dl class="toright legend-area">
 <dt class="toleft box-red"></dt><dd class="toleft">kritickÈ</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logickÈ</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<?php if ( $hlavicka->obod == '0000-00-00' OR $hlavicka->obdo == '0000-00-00' )
{
?>
<li class="red">
<?php
$upozorni1=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnenÈ <strong>za zdaÚovacie obdobie</strong> ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( $hlavicka->zodic == '0' )
{
?>
<li class="red">
<?php
$upozorni1=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnenÈ <strong>diË</strong> z·vislej osoby v II.oddiele ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( trim($hlavicka->zoprie) == '' AND trim($hlavicka->zomeno) == '' AND trim($hlavicka->zonaz) == '' )
{
?>
<li class="red">
<?php
$upozorni1=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnenÈ <strong>priezvisko, meno alebo n·zov</strong> z·vislej osoby v II.oddiele ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( $hlavicka->zoprie != '' AND $hlavicka->zomeno != ''  AND $hlavicka->zonaz != '' )
{
?>
<li class="red">
<?php
$upozorni1=1;
echo "Subjekt s diË $hlavicka->zodic m· s˙Ëasne vyplnenÈ <strong>priezvisko, meno a n·zov</strong> z·vislej osoby v II.oddiele ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( $hlavicka->zonaz == '' AND (( $hlavicka->zoprie != '' AND $hlavicka->zomeno == '' ) OR 
 ( $hlavicka->zoprie == '' AND $hlavicka->zomeno != '' )) )
{
?>
<li class="red">
<?php
$upozorni1=1;
echo "Subjekt s diË $hlavicka->zodic pri fyzickej osobe musÌte vyplniù <strong>priezvisko aj meno</strong> z·vislej osoby v II.oddiele ozn·menia.";
?>
</li>
<?php
}
?>
</ul>

<ul id="alertpage2" style="display:none;">
<li class="header-section">STRANA 2</li>
<?php if ( $hlavicka->zomes == '' )
{
?>
<li class="red">
<?php
$upozorni2=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnen˙ poloûku <strong>obec</strong> v adrese z·vislej osoby v II.oddiele ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( $hlavicka->suma == 0 )
{
?>
<li class="red">
<?php
$upozorni2=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnen˙ <strong>sumu ˙pravy z·kladu dane</strong> v III. oddiele ozn·menia.";
?>
</li>
<?php
}
?>
<?php if ( $hlavicka->datum == '0000-00-00' )
{
?>
<li class="red">
<?php
$upozorni2=1;
echo "Subjekt s diË $hlavicka->zodic nem· vyplnen˝ <strong>d·tum vypracovania</strong> ozn·menia.";
?>
</li>
<?php
}
?>
</ul>
</div> <!-- #upozornenie -->

<script type="text/javascript">
<?php
if ( $upozorni1 == 1 OR $upozorni2 == 1 ) { echo "upozornenie.style.display='block';"; }
if ( $upozorni1 == 1 ) { echo "alertpage1.style.display='block';"; }
if ( $upozorni2 == 1 ) { echo "alertpage2.style.display='block';"; }
?>
</script>

</div> <!-- #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec XML SUBOR copern=110
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>