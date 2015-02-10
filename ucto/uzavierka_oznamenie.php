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

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DROP TABLE F$kli_vxcf"."_uzavoznamenie ";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
     {
$datk = strip_tags($_REQUEST['datk']);
$datk_sql=SqlDatum($datk);
$datz = strip_tags($_REQUEST['datz']);
$datz_sql=SqlDatum($datz);
$dats = strip_tags($_REQUEST['dats']);
$dats_sql=SqlDatum($dats);
$obbod = strip_tags($_REQUEST['obbod']);
$obbdo = strip_tags($_REQUEST['obbdo']);
$obmod = strip_tags($_REQUEST['obmod']);
$obmdo = strip_tags($_REQUEST['obmdo']);
$druhuz = strip_tags($_REQUEST['druhuz']);
$druhuj = strip_tags($_REQUEST['druhuj']);

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_uzavoznamenie SET ".
" datk='$datk_sql', datz='$datz_sql', dats='$dats_sql', ".
" obbod='$obbod', obbdo='$obbdo', obmod='$obmod', obmdo='$obmdo', ".
" druhuz='$druhuz', druhuj='$druhuj' ".
" WHERE oc = $cislo_oc "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt"); 
//exit; 
//exit;
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
$sql = "SELECT konx FROM F$kli_vxcf"."_uzavoznamenie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   datk         DATE NOT NULL,
   datz         DATE NOT NULL,
   dats         DATE NOT NULL,
   obbod        DECIMAL(7,4) DEFAULT 0,
   obbdo        DECIMAL(7,4) DEFAULT 0,
   obmod        DECIMAL(7,4) DEFAULT 0,
   obmdo        DECIMAL(7,4) DEFAULT 0,
   druhuz       DECIMAL(2,0) DEFAULT 0,
   druhuj       DECIMAL(2,0) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0
);
mzdprc;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uzavoznamenie'.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uzavoznamenie ( oc ) VALUES ( '0' ) ";
$dsql = mysql_query("$dsqlt");
}

//verzia 2014
$sql = "SELECT new2014 FROM F$kli_vxcf"."_uzavoznamenie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uzavoznamenie ADD new2014 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavoznamenie WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavoznamenie WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");




//nacitaj obdobia z ufirdalsie
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

  $datbod_sql=$riadok->datbod; $pole = explode("-", $datbod_sql); $datbod_sql=$pole[1].".".$pole[0];
  $datbdo_sql=$riadok->datbdo; $pole = explode("-", $datbdo_sql); $datbdo_sql=$pole[1].".".$pole[0];
  $datmod_sql=$riadok->datmod; $pole = explode("-", $datmod_sql); $datmod_sql=$pole[1].".".$pole[0];
  $datmdo_sql=$riadok->datmdo; $pole = explode("-", $datmdo_sql); $datmdo_sql=$pole[1].".".$pole[0];
  $datuk_sql=$riadok->datk;

  }

if( $datuk_sql != '' AND $datuk_sql != '0000-00-00' ) 
    {
$sqlfir = "UPDATE F$kli_vxcf"."_uzavoznamenie SET ".
" datk='$datuk_sql', obbod='$datbod_sql', obbdo='$datbdo_sql', obmod='$datmod_sql', obmdo='$datmdo_sql' ".
" WHERE datk = '0000-00-00' ";
$fir_vysledok = mysql_query($sqlfir);
    }

if( $datuk_sql == '0000-00-00' ) 
    {
$datuk_sql=$kli_vrok."-12-31";
$datbod_sql="01.".$kli_vrok; $datbdo_sql="12.".$kli_vrok;
$kli_mrok=$kli_vrok-1;
$datmod_sql="01.".$kli_mrok; $datmdo_sql="12.".$kli_mrok;

$sqlfir = "UPDATE F$kli_vxcf"."_uzavoznamenie SET ".
" datk='$datuk_sql', obbod='$datbod_sql', obbdo='$datbdo_sql', obmod='$datmod_sql', obmdo='$datmdo_sql' ".
" WHERE datk = '0000-00-00' ";
$fir_vysledok = mysql_query($sqlfir);
    }


//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uzavoznamenie ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$datk_sk = SkDatum($fir_riadok->datk);
$datz_sk = SkDatum($fir_riadok->datz);
$dats_sk = SkDatum($fir_riadok->dats);
$obbod = $fir_riadok->obbod;
$obbdo = $fir_riadok->obbdo;
$obmod = $fir_riadok->obmod;
$obmdo = $fir_riadok->obmdo;
$druhuz = $fir_riadok->druhuz;
$druhuj = $fir_riadok->druhuj;


     }
//koniec nacitania


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Uzávierka oznámenie</title>
<style type="text/css">
div.navbar {
  overflow: auto;
  width: 100%;
  background-color: #add8e6;
}
img.form-background {
  display: block;
  width: 930px;
  height: 1240px;
  margin: 50px 0 0 25px;
}
div.wrap-form-background {
  overflow: hidden;
  width: 950px;
  height: 1300px;
  background-color: #fff;
}
form input[type=text] {
  position: absolute;
  height: 18px;
  line-height: 18px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
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
   document.formv1.datk.value = '<?php echo "$datk_sk";?>';
   document.formv1.datz.value = '<?php echo "$datz_sk";?>';
   document.formv1.dats.value = '<?php echo "$dats_sk";?>';
   document.formv1.obbod.value = '<?php echo "$obbod";?>';
   document.formv1.obbdo.value = '<?php echo "$obbdo";?>';
   document.formv1.obmod.value = '<?php echo "$obmod";?>';
   document.formv1.obmdo.value = '<?php echo "$obmdo";?>';
   document.formv1.druhuz.value = '<?php echo "$druhuz";?>';
   document.formv1.druhuj.value = '<?php echo "$druhuj";?>';

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


  function tlacUzOz()
  {
   window.open('uzavierka_oznamenie.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>', '_blank');
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
   <td class="header">Uzávierka oznámenie - <span class="subheader"></span>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacUzOz();"
      title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="uzavierka_oznamenie.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave" style="top:4px;">

<div class="wrap-form-background">
<img src="../dokumenty/dan_z_prijmov2014/oznamenie_schvalenia_uzavierky.jpg"
 alt="tlaèivo Zápoètový list pre rok 2014 1.strana 174kB" class="form-background">

<!-- zamestnavatel -->
<span class="text-echo" style="top:80px; left:44px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:103px; left:44px;"><?php echo "$fir_fuli $fir_fcdm"; ?></span>
<span class="text-echo" style="top:126px; left:44px;"><?php echo $fir_fmes; ?></span>


<input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:558px; left:275px;"/>

<input type="text" name="datz" id="datz" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:588px; left:435px;"/>

<input type="text" name="dats" id="dats" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:593px; left:275px;"/>

<input type="text" name="obbod" id="obbod" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:608px; left:435px;"/>

<input type="text" name="obbdo" id="obbdo" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:275px;"/>

<input type="text" name="obmod" id="obmod" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:435px;"/>

<input type="text" name="obmdo" id="obmdo" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:275px;"/>

<input type="text" name="druhuz" id="druhuz" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:435px;"/>

<input type="text" name="druhuj" id="druhuj" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>
</div> <!-- koniec wrap-form-background -->
</FORM>
</div> <!-- koniec #content -->
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_uzavoznamenie ";

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
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/oznamenie_schvalenia_uzavierky.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/oznamenie_schvalenia_uzavierky.jpg',9,15,193,270);
}

//v dna
$pdf->Cell(190,5," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
$pole = explode(".", $datum);
$datum1=$pole[0];
$datum2=$pole[1];
$datum3=$pole[2];
$pole = explode("20", $datum3);
$datum3=$pole[1];
$pdf->Cell(60,5," ","$rmc1",0,"L");
$pdf->Cell(88,5,"$fir_fmes    ","$rmc",0,"R");$pdf->Cell(6,4," ","$rmc1",0,"L");
$pdf->Cell(18,5,"$datum1.$datum2.","$rmc",0,"R");$pdf->Cell(5,4," ","$rmc1",0,"L");
$pdf->Cell(10,5,"$datum3","$rmc",1,"L");

//zamestnavatel
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fuli $fir_fcdm","$rmc",1,"L");
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(85,4,"$fir_fmes","$rmc",1,"L");

//zamestnanec
$dar=SkDatum($hlavicka->dar);
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"L");
$pdf->Cell(124,5,"$hlavicka->titl $hlavicka->meno $hlavicka->prie","$rmc",0,"L");
$pdf->Cell(7,4," ","$rmc1",0,"L");$pdf->Cell(20,5,"$dar","$rmc",1,"L");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","0",0,"L");$pdf->Cell(124,5,"$hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","$rmc",1,"L");
//doba zamestnania
$dan=SkDatum($hlavicka->dan);
$dav=SkDatum($hlavicka->dav);
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(53,4," ","$rmc1",0,"L");$pdf->Cell(70,5,"$dan","$rmc",0,"L");
$pdf->Cell(6,4," ","$rmc1",0,"L");$pdf->Cell(60,5,"$dav","$rmc",1,"L");

//I.cast
$pdf->Cell(190,19," ","$rmc1",1,"L");
$pdf->Cell(59,4," ","$rmc1",0,"L");$pdf->Cell(75,6,"$hlavicka->neschop","$rmc",1,"L");
//obdobia vylucene
$vylod1=SkDatum($hlavicka->vylod1); if ( $vylod1 == "00.00.0000" ) $vylod1="";
$vyldo1=SkDatum($hlavicka->vyldo1); if ( $vyldo1 == "00.00.0000" ) $vyldo1="";
$vylod2=SkDatum($hlavicka->vylod2); if ( $vylod2 == "00.00.0000" ) $vylod2="";
$vyldo2=SkDatum($hlavicka->vyldo2); if ( $vyldo2 == "00.00.0000" ) $vyldo2="";
$vylod3=SkDatum($hlavicka->vylod3); if ( $vylod3 == "00.00.0000" ) $vylod3="";
$vyldo3=SkDatum($hlavicka->vyldo3); if ( $vyldo3 == "00.00.0000" ) $vyldo3="";
$vylod4=SkDatum($hlavicka->vylod4); if ( $vylod4 == "00.00.0000" ) $vylod4="";
$vyldo4=SkDatum($hlavicka->vyldo4); if ( $vyldo4 == "00.00.0000" ) $vyldo4="";
$vylod5=SkDatum($hlavicka->vylod5); if ( $vylod5 == "00.00.0000" ) $vylod5="";
$vyldo5=SkDatum($hlavicka->vyldo5); if ( $vyldo5 == "00.00.0000" ) $vyldo5="";
$vyl2od1=SkDatum($hlavicka->vyl2od1); if( $vyl2od1 == "00.00.0000" ) $vyl2od1="";
$vyl2do1=SkDatum($hlavicka->vyl2do1); if( $vyl2do1 == "00.00.0000" ) $vyl2do1="";
$vyldni1=$hlavicka->vyldni1; if ( $vyldni1 == 0 ) $vyldni1="";
$vyldni2=$hlavicka->vyldni2; if ( $vyldni2 == 0 ) $vyldni2="";
$vyldni3=$hlavicka->vyldni3; if ( $vyldni3 == 0 ) $vyldni3="";
$vyldni4=$hlavicka->vyldni4; if ( $vyldni4 == 0 ) $vyldni4="";
$vyldni5=$hlavicka->vyldni5; if ( $vyldni5 == 0 ) $vyldni5="";
$vyl2dni1=$hlavicka->vyl2dni1; if ( $vyl2dni1 == 0 ) $vyl2dni1="";
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod1","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo1","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni1","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod2","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo2","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni2","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod3","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo3","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni3","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,6,"$vylod4","$rmc",0,"C");$pdf->Cell(34,6,"$vyldo4","$rmc",0,"C");
$pdf->Cell(33,6,"$vyldni4","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vylod5","$rmc",0,"C");$pdf->Cell(34,5,"$vyldo5","$rmc",0,"C");
$pdf->Cell(33,5,"$vyldni5","$rmc",1,"C");
$pdf->Cell(46,4," ","$rmc1",0,"L");
$pdf->Cell(32,5,"$vyl2od1","$rmc",0,"C");$pdf->Cell(34,5,"$vyl2do1","$rmc",0,"C");
$pdf->Cell(33,5,"$vyl2dni1","$rmc",1,"C");
//zapocitana doba
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pdf->Cell(114,4," ","$rmc1",0,"L");$pdf->Cell(22,4,"$hlavicka->rok","$rmc",0,"L");
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(20,4,"$hlavicka->dni","$rmc",1,"L");
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(17,4," ","$rmc1",0,"L");$pdf->Cell(140,5,"$hlavicka->roks $hlavicka->dnis","$rmc",1,"L");
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(170,4,"$hlavicka->dovod","$rmc",1,"L");

//poznamka
$pdf->Cell(190,2," ","$rmc1",1,"L");
$poleosob = explode("\r\n", $hlavicka->str2);
if ( $poleosob[0] != '' )
     {
$ipole=1;
foreach( $poleosob as $hodnota ) {
$pdf->Cell(4,5," ","$rmc1",0,"L");$pdf->Cell(186,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
     }


//odtlacok zamestnavatela
$pdf->SetY(285);
$pdf->Cell(130,5,"","$rmc1",0,"R");$pdf->Cell(0,8,"Odtlaèok peèiatky a podpis","T",1,"C");
$pdf->Cell(130,5,"","$rmc1",0,"R");$pdf->Cell(0,3,"zamestnávate¾a","$rmc1",1,"C");


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