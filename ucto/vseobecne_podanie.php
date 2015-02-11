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
$sqtoz = "DELETE FROM F$kli_vxcf"."_vseobpodanie WHERE oc = $cislo_oc";
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

$evci1 = strip_tags($_REQUEST['evci1']);
$evci2 = strip_tags($_REQUEST['evci2']);
$organ = strip_tags($_REQUEST['organ']);
$duozn = strip_tags($_REQUEST['duozn']);
$duprc = strip_tags($_REQUEST['duprc']);
$oblast = strip_tags($_REQUEST['oblast']);
$agenda = strip_tags($_REQUEST['agenda']);
$typpod = strip_tags($_REQUEST['typpod']);
$fopo = strip_tags($_REQUEST['fopo']);
$prnie = strip_tags($_REQUEST['prnie']);
$prsub = strip_tags($_REQUEST['prsub']);
$prano = strip_tags($_REQUEST['prano']);
$textpo = strip_tags($_REQUEST['textpo']);

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_vseobpodanie SET ".
" datk='$datk_sql', ".
" evci1='$evci1', evci2='$evci2', organ='$organ', duozn='$duozn', ".
" duprc='$duprc', oblast='$oblast', agenda='$agenda', typpod='$typpod', ".
" fopo='$fopo', prnie='$prnie', prsub='$prsub', prano='$prano', ".
" textpo='$textpo' ".
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
$sql = "SELECT textpo FROM F$kli_vxcf"."_vseobpodanie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_vseobpodanie";
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   datk         DATE NOT NULL,
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
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_vseobpodanie ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$datk_sk = SkDatum($fir_riadok->datk);

$evci1 = $fir_riadok->evci1;
$evci2 = $fir_riadok->evci2;
$organ = $fir_riadok->organ;
$duozn = $fir_riadok->duozn;
$duprc = $fir_riadok->duprc;
$oblast = $fir_riadok->oblast;
$agenda = $fir_riadok->agenda;
$typpod = $fir_riadok->typpod;
$fopo = $fir_riadok->fopo;
$prnie = $fir_riadok->prnie;
$prsub = $fir_riadok->prsub;
$prano = $fir_riadok->prano;
$textpo = $fir_riadok->textpo;

     }
//koniec nacitania


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Všeobecné podanie</title>
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
   document.formv1.evci1.value = '<?php echo "$evci1";?>';
   document.formv1.evci2.value = '<?php echo "$evci2";?>';
   document.formv1.organ.value = '<?php echo "$organ";?>';
   document.formv1.duozn.value = '<?php echo "$duozn";?>';
   document.formv1.duprc.value = '<?php echo "$duprc";?>';
   document.formv1.oblast.value = '<?php echo "$oblast";?>';
   document.formv1.agenda.value = '<?php echo "$agenda";?>';
   document.formv1.typpod.value = '<?php echo "$typpod";?>';
   document.formv1.fopo.value = '<?php echo "$fopo";?>';
   document.formv1.prnie.value = '<?php echo "$prnie";?>';
   document.formv1.prsub.value = '<?php echo "$prsub";?>';
   document.formv1.prano.value = '<?php echo "$prano";?>';


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


  function tlacVseob()
  {
   window.open('vseobecne_podanie.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>', '_blank');
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
   <td class="header">Všeobecné podanie - <span class="subheader"></span>
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacVseob();"
      title="Zobrazi v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="vseobecne_podanie.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave" style="top:4px;">

<div class="wrap-form-background">
<img src="../dokumenty/dan_z_prijmov2014/vseobecne_podanie.jpg"
 alt="tlaèivo Zápoètový list pre rok 2014 1.strana 174kB" class="form-background">

<!-- zamestnavatel -->
<span class="text-echo" style="top:80px; left:44px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:103px; left:44px;"><?php echo "$fir_fuli $fir_fcdm"; ?></span>
<span class="text-echo" style="top:126px; left:44px;"><?php echo $fir_fmes; ?></span>

<input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:558px; left:275px;"/>

<input type="text" name="evci1" id="evci1" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:588px; left:435px;"/>

<input type="text" name="evci2" id="evci2" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:593px; left:275px;"/>

<input type="text" name="organ" id="organ" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:608px; left:435px;"/>

<input type="text" name="duozn" id="duozn" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:275px;"/>

<input type="text" name="duprc" id="duprc" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:632px; left:435px;"/>

<input type="text" name="oblast" id="oblast" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:275px;"/>

<input type="text" name="agenda" id="agenda" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:657px; left:435px;"/>

<input type="text" name="typpod" id="typpod" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>

<input type="text" name="fopo" id="fopo" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>

<input type="text" name="prnie" id="prnie" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>

<input type="text" name="prsub" id="prsub" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>

<input type="text" name="prano" id="prano" onkeyup="CiarkaNaBodku(this);"
 style="width:80px; top:681px; left:275px;"/>

<textarea name="textpo" id="textpo" rows="10" cols="110" style="width:600px; overflow:auto;" ><?php echo $textpo; ?></textarea>


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
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(15);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/vseobecne_podanie.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/vseobecne_podanie.jpg',9,15,193,270);
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