<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
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

//.jpg podklad
$jpg_cesta="../dokumenty/dan_z_prijmov2015/vp_zavierka_v15";
$jpg_popis="formul·r VöeobecnÈ podanie k ⁄Z - PodnikateæskÈ subjekty v s˙stave p˙ pre rok ".$kli_vrok;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$jedn = 1*$_REQUEST['jedn'];
$kli_nezis = 1*$_REQUEST['kli_nezis'];

//datum vzniku UJ
$sql = "SELECT datvzn FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datvzn DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}

//dopln datumy uzavierky
if ( $copern == 1100 )
     {
$kli_mrok=$kli_vrok-1;
$obbod="01.".$kli_vrok; $obbdo="12.".$kli_vrok;
$obmod="01.".$kli_mrok; $obmdo="12.".$kli_mrok;
$datk_sql=$kli_vrok."-12-31";

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

  $datksql=$riadok->datk;
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);

  }

if( $datksql != '0000-00-00' ) { $datk_sql=$datksql; }
if( $datbodsk != '00.00.0000' ) { $polex = explode(".", $datbodsk); $obbod=$polex[1].".".$polex[2]; }
if( $datbdosk != '00.00.0000' ) { $polex = explode(".", $datbdosk); $obbdo=$polex[1].".".$polex[2]; }

if( $datmodsk != '00.00.0000' ) { $polex = explode(".", $datmodsk); $obmod=$polex[1].".".$polex[2]; }
if( $datmdosk != '00.00.0000' ) { $polex = explode(".", $datmdosk); $obmdo=$polex[1].".".$polex[2]; }

$sqlx = "UPDATE F$kli_vxcf"."_vseobpodanie SET obbod='$obbod', obbdo='$obbdo', obmod='$obmod', obmdo='$obmdo', datk='$datk_sql'  ";
//echo $sqlx;
$vysledekx = mysql_query("$sqlx");


$copern=20;
     }
//koniec dopln datumy uzavierky

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_vseobpodanie WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj

//zapis upravene udaje
if ( $copern == 23 )
     {
$evci1 = strip_tags($_REQUEST['evci1']);
$evci2 = strip_tags($_REQUEST['evci2']);
//$organ = strip_tags($_REQUEST['organ']);
$duozn = strip_tags($_REQUEST['duozn']);
//$oblast = strip_tags($_REQUEST['oblast']);
//$agenda = strip_tags($_REQUEST['agenda']);
$typpod = strip_tags($_REQUEST['typpod']);
$obbod = strip_tags($_REQUEST['obbod']);
$obbdo = strip_tags($_REQUEST['obbdo']);
$obmod = strip_tags($_REQUEST['obmod']);
$obmdo = strip_tags($_REQUEST['obmdo']);
$typuz = strip_tags($_REQUEST['typuz']);
$datk = strip_tags($_REQUEST['datk']);
$datk_sql=SqlDatum($datk);
$datz = strip_tags($_REQUEST['datz']);
$datz_sql=SqlDatum($datz);
$dats = strip_tags($_REQUEST['dats']);
$dats_sql=SqlDatum($dats);
//$jazyk = strip_tags($_REQUEST['jazyk']);
$typdok = strip_tags($_REQUEST['typdok']);
$datv = strip_tags($_REQUEST['datv']);
$datv_sql=SqlDatum($datv);
//$spopod = strip_tags($_REQUEST['spopod']);
$datp = strip_tags($_REQUEST['datp']);
$datp_sql=SqlDatum($datp);

$uprav="NO";
$uprmp = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" datvzn='$datv_sql' ".
" WHERE kkx >= 0 ";
$upravmp = mysql_query("$uprmp");

$uprtxt = "UPDATE F$kli_vxcf"."_vseobpodanie SET ".
" evci1='$evci1', evci2='$evci2', duozn='$duozn', ".
" typpod='$typpod', ".
" obbod='$obbod', obbdo='$obbdo', obmod='$obmod', obmdo='$obmdo', ".
" typuz='$typuz', datk='$datk_sql', datz='$datz_sql', dats='$dats_sql', ".
" datv='$datv_sql', typdok='$typdok', datp='$datp_sql' ".
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
$sql = "SELECT datp FROM F$kli_vxcf"."_vseobpodanie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = "DROP TABLE F".$kli_vxcf."_vseobpodanie";
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   evci1        VARCHAR(20) NOT NULL,
   evci2        VARCHAR(10) NOT NULL,
   organ        DECIMAL(2,0) DEFAULT 0,
   duozn        DECIMAL(2,0) DEFAULT 0,
   duprc        DECIMAL(2,0) DEFAULT 0,
   oblast       DECIMAL(2,0) DEFAULT 0,
   agenda       DECIMAL(2,0) DEFAULT 0,
   typpod       DECIMAL(2,0) DEFAULT 0,
   fopo         DECIMAL(2,0) DEFAULT 0,
   prnie        DECIMAL(2,0) DEFAULT 0,
   prsub        DECIMAL(2,0) DEFAULT 0,
   prano        DECIMAL(2,0) DEFAULT 0,
   textpo       TEXT NOT NULL,

   datk         DATE NOT NULL,
   datz         DATE NOT NULL,
   dats         DATE NOT NULL,
   obbod        DECIMAL(7,4) DEFAULT 0,
   obbdo        DECIMAL(7,4) DEFAULT 0,
   obmod        DECIMAL(7,4) DEFAULT 0,
   obmdo        DECIMAL(7,4) DEFAULT 0,
   druhuz       DECIMAL(2,0) DEFAULT 0,
   druhuj       DECIMAL(2,0) DEFAULT 0,

   datp         DATE NOT NULL,
   jazyk        DECIMAL(2,0) DEFAULT 0,
   typuz        DECIMAL(2,0) DEFAULT 0,
   datv         DATE NOT NULL,
   typdok       DECIMAL(2,0) DEFAULT 0,
   spopod       DECIMAL(2,0) DEFAULT 0,
   konx         DECIMAL(2,0) DEFAULT 0
);
mzdprc;
$vsql = "CREATE TABLE F".$kli_vxcf."_vseobpodanie".$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_vseobpodanie ( oc ) VALUES ( '0' ) ";
$dsql = mysql_query("$dsqlt");
}

//verzia 2014
$sql = "SELECT new2014 FROM F$kli_vxcf"."_vseobpodanie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_vseobpodanie ADD new2014 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_vseobpodanie WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_vseobpodanie WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");


//nacitaj udaje pre upravu
if ( $copern == 20 OR $copern == 10 )
     {
$sqlmp = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE kkx >= 0 ";
$fir_mp = mysql_query($sqlmp);
$fir_rmp=mysql_fetch_object($fir_mp);
$datv_sk = SkDatum($fir_rmp->datvzn);



$sqlfir = "SELECT * FROM F$kli_vxcf"."_vseobpodanie ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$evci1 = $fir_riadok->evci1;
$evci2 = $fir_riadok->evci2;
$duozn = $fir_riadok->duozn;
$typpod = $fir_riadok->typpod;
$obbod = $fir_riadok->obbod;
$obbdo = $fir_riadok->obbdo;
$obmod = $fir_riadok->obmod;
$obmdo = $fir_riadok->obmdo;
$typuz = $fir_riadok->typuz;
$datk_sk = SkDatum($fir_riadok->datk);
$datz_sk = SkDatum($fir_riadok->datz);
$dats_sk = SkDatum($fir_riadok->dats);
//$datv_sk = SkDatum($fir_riadok->datv);
$typdok = $fir_riadok->typdok;
$datp_sk = SkDatum($fir_riadok->datp);
if ( $datp_sk == '00.00.0000' ) 
{ 
$datp_sk=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$datp_sql=SqlDatum($datp_sk);
$sqlx = "UPDATE F$kli_vxcf"."_vseobpodanie SET datp='$datp_sql' ";
$vysledekx = mysql_query("$sqlx");
}

     }
//koniec nacitania

//6-miestne ico
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }

//sknace bez bodiek
$sknace=str_replace(".", "", $fir_sknace);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - VöeobecnÈ podanie</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}

span.text-echo {
  font-size: 16px;
  letter-spacing: 13px;
}
div.input-echo {
  font-size: 15px;
/*   background-color: #fff; */
  position: absolute;
  font-weight: bold;
}
form input[type=text] {
  position: absolute;
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
form select {
  height: 24px;
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
   document.formv1.evci1.value = '<?php echo "$evci1";?>';
   document.formv1.evci2.value = '<?php echo "$evci2";?>';
   document.formv1.duozn.value = '<?php echo "$duozn";?>';
   document.formv1.typpod.value = '<?php echo "$typpod";?>';
   document.formv1.obbod.value = '<?php echo "$obbod";?>';
   document.formv1.obbdo.value = '<?php echo "$obbdo";?>';
   document.formv1.obmod.value = '<?php echo "$obmod";?>';
   document.formv1.obmdo.value = '<?php echo "$obmdo";?>';
<?php if ( $typuz == 0 ) { ?> document.formv1.typuz0.checked = 'true'; <?php } ?>
<?php if ( $typuz == 1 ) { ?> document.formv1.typuz1.checked = 'true'; <?php } ?>
<?php if ( $typuz == 2 ) { ?> document.formv1.typuz2.checked = 'true'; <?php } ?>
   document.formv1.datk.value = '<?php echo "$datk_sk";?>';
   document.formv1.datz.value = '<?php echo "$datz_sk";?>';
   document.formv1.dats.value = '<?php echo "$dats_sk";?>';
   document.formv1.datv.value = '<?php echo "$datv_sk";?>';
   document.formv1.typdok.value = '<?php echo "$typdok";?>';
   document.formv1.datp.value = '<?php echo "$datp_sk";?>';
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

  function PoucVyplnenie()
  {
   window.open('<?php echo $jpg_cesta; ?>_poucenie.pdf',
'_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function tlacVseob()
  {
   window.open('vp_zavierka2015.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&kli_nezis=<?php echo $kli_nezis; ?>',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function VseobdoXML()
  {
   window.open('../ucto/vp_zavierka2015xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&kli_nezis=<?php echo $kli_nezis; ?>',
'_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function datumUzav()
  {
   window.open('../ucto/vp_zavierka2015.php?copern=1100&page=1&sysx=UCT&drupoh=1&uprav=1&kli_nezis=<?php echo $kli_nezis; ?>','_self' );
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
   <td class="header">VöeobecnÈ podanie <span class="subheader">k ˙Ëtovnej z·vierke</span>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="VseobdoXML();" title="Export do XML" class="btn-form-tool"> 
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();"
          title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacVseob();"
          title="Zobraziù v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="vp_zavierka2015.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&kli_nezis=<?php echo $kli_nezis; ?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave" style="top:4px;">
<img src="<?php echo $jpg_cesta; ?>.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 204kB">

<input type="text" name="evci1" id="evci1" style="width:177px; top:100px; left:361px;"/>
<input type="text" name="evci2" id="evci2" onkeyup="CiarkaNaBodku(this);"
       style="width:86px; top:100px; left:588px;"/>
<!-- Adresat podania -->
<div class="input-echo" style="top:174px; left:248px;">DaÚov˝ ˙rad</div>
<select name="duozn" id="duozn" size="1" style="width:274px; top:205px; left:248px;"> <!-- dopyt, predpÂÚaù z ufir -->
 <option value="0"></option>
 <option value="1">Bansk· Bystrica</option>
 <option value="2">Bratislava</option>
 <option value="3">Koöice</option>
 <option value="4">Nitra</option>
 <option value="5">Preöov</option>
 <option value="6">TrenËÌn</option>
 <option value="7">Trnava</option>
 <option value="8">éilina</option>
 <option value="9">pre vybranÈ daÚovÈ subjekty</option>
</select>
<div class="input-echo" style="top:249px; left:248px;">⁄ËtovnÈ dokumenty</div>
<div class="input-echo" style="top:279px; left:248px;">
<?php
if ( $kli_nezis == 0 ) { echo "⁄ËtovnÈ v˝kazy pre podnikateæskÈ subjekty ˙Ëtuj˙ce v s˙stave podvojnÈho ˙ËtovnÌctva"; }
if ( $kli_nezis == 1 ) { echo "⁄ËtovnÈ v˝kazy pre neziskovÈ organiz·cie ˙Ëtuj˙ce v s˙stave podvojnÈho ˙ËtovnÌctva"; }
?>
</div>
<select name="typpod" id="typpod" size="1" style="width:612px; top:310px; left:248px;">
 <option value="0"></option>
<?php if ( $kli_nezis == 0 ) { ?>
 <option value="1">Podnikateæsk˝ subjekt ˙Ëtuj˙ci v s˙stave podvojnÈho ˙ËtovnÌctva</option>
 <option value="2">Mikro ˙Ëtovn· jednotka</option>
<?php                       } ?>
<?php if ( $kli_nezis == 1 ) { ?>
 <option value="3">Neziskov· organiz·cia ˙Ëtuj˙ca v s˙stave podvojnÈho ˙ËtovnÌctva</option>
<?php                       } ?>
</select>

<!-- obdobia -->
<input type="text" name="obbod" id="obbod" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:370px; left:251px;"/> <!-- dopyt, budeme predplÚaù podæa z·vierky -->
<input type="text" name="obbdo" id="obbdo" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:401px; left:251px;"/> <!-- dopyt, budeme predplÚaù podæa z·vierky -->
<input type="text" name="obmod" id="obmod" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:370px; left:690px;"/> <!-- dopyt, budeme predplÚaù podæa z·vierky -->
<input type="text" name="obmdo" id="obmdo" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:401px; left:690px;"/> <!-- dopyt, budeme predplÚaù podæa z·vierky -->

<!-- uctovna zavierka -->
<img src="../obr/ikony/download_blue_icon.png" title="NaËÌtaù obdobia a d·tum k z ⁄Ëtovnej z·vierky"
     onclick="datumUzav();" style="top:442px; left:18px;" class="btn-row-tool"> <!-- dopyt, rozchodiù -->
<span class="text-echo" style="top:476px; left:139px;">x</span>
<input type="radio" id="typuz0" name="typuz" value="0" style="top:475px; left:349px;"/>
<input type="radio" id="typuz1" name="typuz" value="1" style="top:501px; left:349px;"/>
<?php if ( $kli_nezis == 0 ) { ?>
<input type="radio" id="typuz2" name="typuz" value="2" style="top:527px; left:349px;"/>
<?php                       } ?>
<input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);"
       style="width:131px; top:498px; left:687px;"/> 
<input type="text" name="datz" id="datz" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:567px; left:251px;"/> 
<input type="text" name="dats" id="dats" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:567px; left:690px;"/> 

<!-- jazyk podania -->
<span class="text-echo" style="top:647px; left:139px;">x</span>

<!-- uctovna jednotka -->
<div class="input-echo" style="top:752px; left:182px;"><?php echo $ico; ?></div>
<div class="input-echo" style="top:752px; left:385px;"><?php echo $fir_fdic; ?></div>
<input type="text" name="datv" id="datv" onkeyup="CiarkaNaBodku(this);"
       style="width:131px; top:751px; left:687px;"/>
<div class="input-echo" style="top:782px; left:688px;"><?php echo $sknace; ?></div>
<div class="input-echo" style="top:831px; left:69px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="top:879px; left:69px;"><?php echo $fir_obreg; ?></div>
<div class="input-echo" style="top:923px; left:182px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="top:923px; left:543px;"><?php echo $fir_fcdm; ?></div>
<div class="input-echo" style="top:953px; left:182px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="top:953px; left:543px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="top:984px; left:182px;"><?php echo $fir_ftel; ?></div>
<div class="input-echo" style="top:984px; left:543px;"><?php echo $fir_fem1; ?></div>

<!-- prilohy -->
<select name="typdok" id="typdok" size="1" style="width:274px; top:1067px; left:248px;">
 <option value="0"></option>
 <option value="1">Spr·va audÌtora</option>
 <option value="2">V˝roËn· spr·va</option>
<?php if ( $kli_nezis == 0 ) { ?>
 <option value="3">RoËn· finanËn· spr·va emitenta</option>
<?php                       } ?>
</select>
<div class="input-echo" style="top:1099px; left:248px;">Elektronicky - s˙Ëasù podania</div>
<input type="text" name="datp" id="datp" onkeyup="CiarkaNaBodku(this);"
       style="width:126px; top:1157px; left:251px;"/> <!-- dopyt, predpÂÚaù aktu·lny d·tum -->

</FORM>
</div> <!-- #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC 
if ( $copern == 10 )
{
if ( File_Exists("../tmp/uzoznamenie.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/uzoznamenie.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_vseobpodanie ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'.jpg') AND $i == 0 )
{
$pdf->Image($jpg_cesta.'.jpg',0,0,210,297);
}
$pdf->SetY(10);

//cislo dokumentu
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(70,5," ","$rmc1",0,"L");$pdf->Cell(40,6,"$hlavicka->evci1","$rmc",0,"L");
$pdf->Cell(10,5," ","$rmc1",0,"L");$pdf->Cell(20,6,"$hlavicka->evci2","$rmc",1,"L");

//adresat podania
$pdf->Cell(190,11.5," ","$rmc1",1,"L");
$organ="DaÚov˝ ˙rad";
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$organ","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $hlavicka->duozn == 0 ) { $duozn=""; }
if ( $hlavicka->duozn == 1 ) { $duozn="Bansk· Bystrica"; }
if ( $hlavicka->duozn == 2 ) { $duozn="Bratislava"; }
if ( $hlavicka->duozn == 3 ) { $duozn="Koöice"; }
if ( $hlavicka->duozn == 4 ) { $duozn="Nitra"; }
if ( $hlavicka->duozn == 5 ) { $duozn="Preöov"; }
if ( $hlavicka->duozn == 6 ) { $duozn="TrenËÌn"; }
if ( $hlavicka->duozn == 7 ) { $duozn="Trnava"; }
if ( $hlavicka->duozn == 8 ) { $duozn="éilina"; }
if ( $hlavicka->duozn == 9 ) { $duozn="pre vybranÈ daÚovÈ subjekty"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$duozn","$rmc",1,"L");
$pdf->Cell(190,5," ","$rmc1",1,"L");
$oblast="⁄ËtovnÈ dokumenty";
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$oblast","$rmc",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $kli_nezis == 0 ) { $agenda="⁄ËtovnÈ v˝kazy pre podnikateæskÈ subjekty ˙Ëtuj˙ce v s˙stave podvojnÈho ˙ËtovnÌctva"; }
if ( $kli_nezis == 1 ) { $agenda="⁄ËtovnÈ v˝kazy pre neziskovÈ organiz·cie ˙Ëtuj˙ce v s˙stave podvojnÈho ˙ËtovnÌctva"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(135,5,"$agenda","$rmc",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $hlavicka->typpod == 1 ) { $typpod="Podnikateæsk˝ subjekt ˙Ëtuj˙ci v s˙stave podvojnÈho ˙ËtovnÌctva"; }
if ( $hlavicka->typpod == 2 ) { $typpod="Mikro ˙Ëtovn· jednotka"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(135,5,"$typpod","$rmc",1,"L");

//obdobia
//od
$pdf->Cell(190,8," ","$rmc1",1,"L");
$text=$hlavicka->obbod;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obbod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
$pdf->Cell(45,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$mesiac.$rok","$rmc",0,"C");
//
$text=$hlavicka->obmod;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obmod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$mesiac.$rok","$rmc",1,"C");
//do
$pdf->Cell(190,1," ","$rmc1",1,"L");
$text=$hlavicka->obbdo;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obbdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
$pdf->Cell(45,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$mesiac.$rok","$rmc",0,"C");
//
$text=$hlavicka->obmdo;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obmdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$rok=$pole[1];
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$mesiac.$rok","$rmc",1,"C");

//uctovna zavierka
$pdf->Cell(190,11.5," ","$rmc1",1,"L");
$individualna="x";
$pdf->Cell(20,5," ","$rmc1",0,"R");$pdf->Cell(3,3,"$individualna","$rmc",1,"C");
//
$riadna="x"; $mimoriadna=""; $priebezna="";
if ( $hlavicka->typuz == 1 ) { $riadna=""; $mimoriadna="x"; $priebezna=""; }
if ( $hlavicka->typuz == 2 ) { $riadna=""; $mimoriadna=""; $priebezna="x"; }
$pdf->SetY(109);
$pdf->Cell(68,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadna","$rmc",1,"C");
$pdf->SetY(115);
$pdf->Cell(68,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$mimoriadna","$rmc",1,"C");
$pdf->SetY(121);
$pdf->Cell(68,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$priebezna","$rmc",1,"C");
//zostavene k
$pdf->SetY(114.5);
$text=SkDatum($hlavicka->datk);
if ( $text == '00.00.0000' ) { $text=""; }
$pdf->Cell(142,6," ","$rcm1",0,"C");$pdf->Cell(30,5,"$text","$rmc",1,"C");
//zostavena dna
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->datz);
if ( $text == '00.00.0000' ) { $text=""; }
$pdf->Cell(45,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"C");
//schvalena dna
$text=SkDatum($hlavicka->dats);
if ( $text == '00.00.0000' ) { $text=""; }
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$text","$rmc",1,"C");

//jazyk podania
$pdf->Cell(190,12.5," ","$rmc1",1,"L");
$slovencina="x";
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$slovencina","$rmc",1,"C");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(3,3," ","$rmc",1,"C");

//uctovna jednotka
$pdf->Cell(190,15.5," ","$rmc1",1,"L");
$pdf->Cell(30,3," ","$rmc1",0,"C");$pdf->Cell(25,5,"$ico","$rmc",0,"L");
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(25,5,"$fir_fdic","$rmc",0,"L");
$vznikuj=$datv_sk;
if ( $vznikuj == '00.00.0000' ) { $vznikuj=""; }
$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(30,5,"$vznikuj","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(142,5," ","$rmc1",0,"R");$pdf->Cell(30,5,"$sknace","$rmc",1,"L");
$pdf->Cell(190,5.5," ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(175,6,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(5,5," ","$rmc1",0,"R");$pdf->Cell(175,6,"$fir_obreg","$rmc",1,"L");
//sidlo
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(30,5," ","$rmc1",0,"R");$pdf->Cell(50,6,"$fir_fuli","$rmc",0,"L");
$pdf->Cell(30,5," ","$rmc1",0,"R");$pdf->Cell(25,6,"$fir_fcdm","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(30,5," ","$rmc1",0,"R");$pdf->Cell(25,6,"$fir_fpsc","$rmc",0,"L");
$pdf->Cell(55,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$fir_fmes","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(30,5," ","$rmc1",0,"R");$pdf->Cell(25,6,"$fir_ftel","$rmc",0,"L");
$pdf->Cell(55,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$fir_fem1","$rmc",1,"L");

//prilohy
$pdf->Cell(190,13," ","$rmc1",1,"L");
if ( $hlavicka->typdok == 0 ) { $typdok=""; }
if ( $hlavicka->typdok == 1 ) { $typdok="Spr·va audÌtora"; }
if ( $hlavicka->typdok == 2 ) { $typdok="V˝roËn· spr·va"; }
if ( $hlavicka->typdok == 3 ) { $typdok="RoËn· finanËn· spr·va emitenta"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,6,"$typdok","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$spopod="Elektronicky - s˙Ëasù podania";
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,6,"$spopod","$rmc",1,"L");

//datum podania
$pdf->Cell(190,7.5," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->datp);
if ( $text == '00.00.0000' ) { $text=""; }
$pdf->Cell(45,5," ","$rmc1",0,"R");$pdf->Cell(30,6,"$text","$rmc",0,"C");

}
$i = $i + 1;
  }
$pdf->Output("../tmp/uzoznamenie.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/uzoznamenie.<?php echo $kli_uzid; ?>.pdf","_self");
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
} while (false);
?>
</BODY>
</HTML>