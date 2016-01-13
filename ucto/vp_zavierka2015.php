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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$jedn = 1*$_REQUEST['jedn'];
$kli_vduj = 1*$_REQUEST['kli_vduj'];

//datum vzniku UJ
$sql = "SELECT datvzn FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD datvzn DATE NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}

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
$organ = strip_tags($_REQUEST['organ']);
$duozn = strip_tags($_REQUEST['duozn']);
$oblast = strip_tags($_REQUEST['oblast']);
$agenda = strip_tags($_REQUEST['agenda']);
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
$jazyk = strip_tags($_REQUEST['jazyk']);
$datv = strip_tags($_REQUEST['datv']);
$datv_sql=SqlDatum($datv);
$typdok = strip_tags($_REQUEST['typdok']);
$spopod = strip_tags($_REQUEST['spopod']);
$datp = strip_tags($_REQUEST['datp']);
$datp_sql=SqlDatum($datp);

$uprav="NO";

$uprmp = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" datvzn='$datv_sql' ".
" WHERE kkx >= 0 ";
$upravmp = mysql_query("$uprmp");

$uprtxt = "UPDATE F$kli_vxcf"."_vseobpodanie SET ".
" evci1='$evci1', evci2='$evci2', organ='$organ', duozn='$duozn', ".
" oblast='$oblast', agenda='$agenda', typpod='$typpod', ".
" obbod='$obbod', obbdo='$obbdo', obmod='$obmod', obmdo='$obmdo', ".
" typuz='$typuz', datk='$datk_sql', datz='$datz_sql', dats='$dats_sql', ".
" jazyk='$jazyk', datv='$datv_sql', typdok='$typdok', spopod='$spopod', datp='$datp_sql' ".
" WHERE oc = $cislo_oc";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
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
$organ = $fir_riadok->organ;
$duozn = $fir_riadok->duozn;
$oblast = $fir_riadok->oblast;
$agenda = $fir_riadok->agenda;
$typpod = $fir_riadok->typpod;
$obbod = $fir_riadok->obbod;
$obbdo = $fir_riadok->obbdo;
$obmod = $fir_riadok->obmod;
$obmdo = $fir_riadok->obmdo;
$typuz = $fir_riadok->typuz;
$datk_sk = SkDatum($fir_riadok->datk);
$datz_sk = SkDatum($fir_riadok->datz);
$dats_sk = SkDatum($fir_riadok->dats);
$jazyk = $fir_riadok->jazyk;
//$datv_sk = SkDatum($fir_riadok->datv);
$typdok = $fir_riadok->typdok;
$spopod = $fir_riadok->spopod;
$datp_sk = SkDatum($fir_riadok->datp);
     }
//koniec nacitania

//6-miestne ico
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Všeobecné podanie</title>
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
   document.formv1.organ.value = '<?php echo "$organ";?>';
   document.formv1.duozn.value = '<?php echo "$duozn";?>';
   document.formv1.oblast.value = '<?php echo "$oblast";?>';
   document.formv1.agenda.value = '<?php echo "$agenda";?>';
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
<?php if ( $jazyk == 0 ) { ?> document.formv1.jazyk0.checked = 'true'; <?php } ?>
<?php if ( $jazyk == 1 ) { ?> document.formv1.jazyk1.checked = 'true'; <?php } ?>
   document.formv1.datv.value = '<?php echo "$datv_sk";?>';
   document.formv1.typdok.value = '<?php echo "$typdok";?>';
   document.formv1.spopod.value = '<?php echo "$spopod";?>';
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
   window.open('../dokumenty/dan_z_prijmov2015/vppod_v15_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function tlacVseob()
  {
   window.open('vp_zavierka2015.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&kli_vduj=<?php echo $kli_vduj; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

  function VseobdoXML()
  {
   window.open('../ucto/vp_zavierka2015xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&kli_vduj=<?php echo $kli_vduj; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
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
   <td class="header">Všeobecné podanie <span class="subheader">k úètovnej závierke</span>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="VseobdoXML();" title="Export do XML" class="btn-form-tool"> 
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();"
          title="Pouèenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacVseob();"
          title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="vp_zavierka2015.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&kli_vduj=<?php echo $kli_vduj; ?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloi zmeny" class="btn-top-formsave" style="top:4px;">

<img src="../dokumenty/dan_z_prijmov2015/vppod_v15.jpg"
     alt="formulár Všeobecné podanie k ÚZ - Podnikate¾ské subjekty úètujúce v sústave podvojného úètovníctva 204kB"
     class="form-background">

<input type="text" name="evci1" id="evci1" style="width:177px; top:100px; left:361px;"/>
<input type="text" name="evci2" id="evci2" onkeyup="CiarkaNaBodku(this);"
 style="width:85px; top:100px; left:588px;"/>

<!-- Adresat podania -->
<div class="input-echo" style="top:173px; left:248px;">Daòovı úrad</div>

<!--
 <select name="organ" id="organ" size="1" style="width:274px; top:174px; left:248px;">
 <option value="0"></option>
 <option value="1">Daòovı úrad</option>
</select>
--> <!-- dopyt, zruši všade -->
<select name="duozn" id="duozn" size="1" style="width:274px; top:205px; left:248px;"> <!-- dopyt, predpåòa z ufur -->
 <option value="0"></option>
 <option value="1">Banská Bystrica</option>
 <option value="2">Bratislava</option>
 <option value="3">Košice</option>
 <option value="4">Nitra</option>
 <option value="5">pre vybrané daòové subjekty</option>
 <option value="6">Prešov</option>
 <option value="7">Trenèín</option>
 <option value="8">Trnava</option>
 <option value="9">ilina</option>
</select>
<div class="input-echo" style="top:248px; left:248px;">Úètovné dokumenty</div>

<!--
 <select name="oblast" id="oblast" size="1" style="width:274px; top:248px; left:248px;">
 <option value="0"></option>
 <option value="1">Úètovné dokumenty</option>
</select>
--> <!-- dopyt, zruši -->
<!--
 <select name="agenda" id="agenda" size="1" style="width:612px; top:279px; left:248px;">
 <option value="0"></option>
 <option value="1">Úètovné vıkazy pre podnikate¾ské subjetky úètujúce v sústave podvojného úètovníctva</option>
</select>
--> <!-- dopyt, zruši -->
<div class="input-echo" style="top:279px; left:248px;">Podnikate¾skı subjekt úètujúci v sústave podvojného úètovníctva</div>
<select name="typpod" id="typpod" size="1" style="width:612px; top:310px; left:248px;">
 <option value="0"></option>
 <option value="1">Podnikate¾skı subjekt úètujúci v sústave podvojného úètovníctva</option>
 <option value="2">Mikro úètovná jednotka</option>
</select>

<!-- obdobia --> <!-- dopyt, bude ikona na naèítanie zo závierky -->
<input type="text" name="obbod" id="obbod" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:369px; left:250px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->
<input type="text" name="obbdo" id="obbdo" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:399px; left:250px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->
<input type="text" name="obmod" id="obmod" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:369px; left:689px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->
<input type="text" name="obmdo" id="obmdo" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:399px; left:689px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->

<!-- uctovna zavierka -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Úètovnej závierky"
     onclick=";" style="top:442px; left:18px;" class="btn-row-tool"> <!-- dopyt, rozchodi -->

<span class="text-echo" style="top:476px; left:139px;">x</span>
<input type="radio" id="typuz0" name="typuz" value="0" style="top:474px; left:349px;"/>
<input type="radio" id="typuz1" name="typuz" value="1" style="top:501px; left:349px;"/>
<input type="radio" id="typuz2" name="typuz" value="2" style="top:527px; left:349px;"/>
<input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);"
       style="width:131px; top:498px; left:687px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->
<input type="text" name="datz" id="datz" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:566px; left:250px;"/> <!-- dopyt, budeme predplòa pod¾a závierky, -->
<input type="text" name="dats" id="dats" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:566px; left:689px;"/> <!-- dopyt, budeme predplòa pod¾a závierky -->

<!-- jazyk podania -->
<input type="radio" id="jazyk0" name="jazyk" value="0" style="top:645px; left:132px;"/> <!-- dopyt, natvrdo slovenèina -->
<input type="radio" id="jazyk1" name="jazyk" value="1" style="top:671px; left:132px;"/>

<!-- uctovna jednotka -->
<div class="input-echo" style="top:751px; left:182px;"><?php echo $ico; ?></div>
<div class="input-echo" style="top:751px; left:385px;"><?php echo $fir_fdic; ?></div>
<input type="text" name="datv" id="datv" onkeyup="CiarkaNaBodku(this);"
       style="width:131px; top:751px; left:687px;"/> <!-- dopyt, toto by som doplnil do údajov o firme, máme aj v poznámkach -->
<div class="input-echo" style="top:783px; left:688px;"><?php echo $fir_sknace; ?></div> <!-- dopyt, preveri v xml èi s bodkami alebo nie -->
<div class="input-echo" style="top:830px; left:70px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="top:879px; left:70px;"><?php echo $fir_obreg; ?></div>
<div class="input-echo" style="top:923px; left:182px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="top:923px; left:543px;"><?php echo $fir_fcdm; ?></div>
<div class="input-echo" style="top:953px; left:182px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="top:953px; left:543px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="top:984px; left:182px;"><?php echo $fir_ftel; ?></div>
<div class="input-echo" style="top:984px; left:543px;"><?php echo $fir_fem1; ?></div>

<!-- prilohy -->
<select name="typdok" id="typdok" size="1" style="width:274px; top:1067px; left:248px;">
 <option value="0"></option>
 <option value="1">Správa audítora</option>
 <option value="2">Vıroèná správa</option>
 <option value="3">Roèná finanèná správa emitenta</option>
</select>
<!--
<select name="spopod" id="spopod" size="1" style="width:274px; top:1098px; left:248px;">
 <option value="0"></option>
 <option value="1">Elektronicky - súèas podania</option>
</select>
--> <!-- dopyt, zruši -->
<div class="input-echo" style="top:1098px; left:248px;">Elektronicky - súèas podania</div>
<input type="text" name="datp" id="datp" onkeyup="CiarkaNaBodku(this);"
       style="width:127px; top:1157px; left:250px;"/> <!-- dopyt, predpåòa aktuálny dátum -->

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

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2015/vppod_v15.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2015/vppod_v15.jpg',0,0,210,297);
}
$pdf->SetY(10);

//cislo dokumentu
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(70,5," ","$rmc1",0,"L");$pdf->Cell(40,5,"$hlavicka->evci1","$rmc",0,"L");
$pdf->Cell(10,5," ","$rmc1",0,"L");$pdf->Cell(20,5,"$hlavicka->evci2","$rmc",1,"L");

//adresat podania
$pdf->Cell(190,12," ","$rmc1",1,"L");
if ( $hlavicka->organ == 0 ) { $organ=""; }
if ( $hlavicka->organ == 1 ) { $organ="Daòovı úrad"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$organ","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $hlavicka->duozn == 0 ) { $duozn=""; }
if ( $hlavicka->duozn == 1 ) { $duozn="Banská Bystrica"; }
if ( $hlavicka->duozn == 2 ) { $duozn="Bratislava"; }
if ( $hlavicka->duozn == 3 ) { $duozn="Košice"; }
if ( $hlavicka->duozn == 4 ) { $duozn="Nitra"; }
if ( $hlavicka->duozn == 5 ) { $duozn="pre vybrané daòové subjekty"; }
if ( $hlavicka->duozn == 6 ) { $duozn="Prešov"; }
if ( $hlavicka->duozn == 7 ) { $duozn="Trenèín"; }
if ( $hlavicka->duozn == 8 ) { $duozn="Trnava"; }
if ( $hlavicka->duozn == 9 ) { $duozn="ilina"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$duozn","$rmc",1,"L");
$pdf->Cell(190,5," ","$rmc1",1,"L");
if ( $hlavicka->oblast == 0 ) { $oblast=""; }
if ( $hlavicka->oblast == 1 ) { $oblast="Úètovné dokumenty"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$oblast","$rmc",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $hlavicka->agenda == 0 ) { $agenda=""; }
if ( $hlavicka->agenda == 1 ) { $agenda="Úètovné vıkazy pre podnikate¾ské subjetky úètujúce v sústave podvojného úètovníctva"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(135,5,"$agenda","$rmc",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(190,2," ","$rmc1",1,"L");
if ( $hlavicka->typpod == 0 ) { $typpod=""; }
if ( $hlavicka->typpod == 1 ) { $typpod="Podnikate¾skı subjekt úètujúci v sústave podvojného úètovníctva"; }
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
$pdf->Cell(190,12," ","$rmc1",1,"L");
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
$pdf->SetY(114);
$text=SkDatum($hlavicka->datk);
if ( $text == '00.00.0000' ) { $text=""; }
$pdf->Cell(142,6," ","$rcm1",0,"C");$pdf->Cell(30,5,"$text","$rmc",1,"L");

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
$pdf->Cell(190,13," ","$rmc1",1,"L");
$slovencina="x"; $ine="";
if ( $hlavicka->jazyk == 1 ) { $slovencina=""; $ine="x"; }
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$slovencina","$rmc",1,"C");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$ine","$rmc",1,"C");

//uctovna jednotka
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(30,3," ","$rmc1",0,"C");$pdf->Cell(25,5,"$ico","$rmc",0,"L");
$pdf->Cell(20,3," ","$rmc1",0,"C");$pdf->Cell(25,5,"$fir_fdic","$rmc",0,"L");
$vznikuj=$datv_sk;
if ( $vznikuj == '00.00.0000' ) { $vznikuj=""; }
$pdf->Cell(42,5," ","$rmc1",0,"R");$pdf->Cell(30,5,"$vznikuj","$rmc",1,"L");
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(142,5," ","$rmc1",0,"R");$pdf->Cell(30,5,"$fir_sknace","$rmc",1,"L");
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
if ( $hlavicka->typdok == 1 ) { $typdok="Správa audítora"; }
if ( $hlavicka->typdok == 2 ) { $typdok="Vıroèná správa"; }
if ( $hlavicka->typdok == 3 ) { $typdok="Roèná finanèná správa emitenta"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,6,"$typdok","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
if ( $hlavicka->spopod == 0 ) { $spopod=""; }
if ( $hlavicka->spopod == 1 ) { $spopod="Elektronicky - súèas podania"; }
$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(60,6,"$spopod","$rmc",1,"L");

//datum podania
$pdf->Cell(190,7," ","$rmc1",1,"L");
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