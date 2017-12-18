<!doctype html>
<html>
<?php
//celkovy zaciatok dokumentu Oznamenie daÚovnÌka o predÂûenÌ lehoty na podanie daÚovÈho priznania v. 2017
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
$rmc=1;
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
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana = 1; }

//.jpg source
$jpg_source="../dokumenty/dan_z_prijmov2017/ozn493/ozn493_v17";
$jpg_popis="tlaËivo Ozn·menie daÚovnÌka o predÂûenÌ lehoty na podanie daÚovÈho priznania pre rok ".$kli_vrok;

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DROP TABLE F$kli_vxcf"."_uzavozn493 ";
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

$uprtxt = "UPDATE F$kli_vxcf"."_uzavozn493 SET ".
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
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//vytvorenie tabulky
$sql = "SELECT konx FROM F$kli_vxcf"."_uzavozn493";
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
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uzavozn493'.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uzavozn493 ( oc ) VALUES ( '0' ) ";
$dsql = mysql_query("$dsqlt");
}

//verzia 2014
$sql = "SELECT new2014 FROM F$kli_vxcf"."_uzavozn493";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uzavozn493 ADD new2014 DECIMAL(4,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavozn493 WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavozn493 WHERE oc < 0 ";
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
$sqlfir = "UPDATE F$kli_vxcf"."_uzavozn493 SET ".
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

$sqlfir = "UPDATE F$kli_vxcf"."_uzavozn493 SET ".
" datk='$datuk_sql', obbod='$datbod_sql', obbdo='$datbdo_sql', obmod='$datmod_sql', obmdo='$datmdo_sql' ".
" WHERE datk = '0000-00-00' ";
$fir_vysledok = mysql_query($sqlfir);
    }


//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uzavozn493 ";

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
<head>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Uz·vierka ozn·menie 493</title>
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
</style>


</head>
<body id="white" onload="ObnovUI();">
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
   <td class="header">Ozn·menie daÚovnÌka o predÂûenÌ lehoty na podanie daÚovÈho priznania
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="FormPDF(9999);" title="Zobraziù v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="uzavierka_ozn493.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">

<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="FormPDF(2);" class="<?php echo $clas2; ?> toright">2</a>
  <a href="#" onclick="FormPDF(1);" class="<?php echo $clas1; ?> toright">1</a>
  <h6 class="toright">TlaËiù:</h6>
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" alt="<?php echo $jpg_popis; ?> 1.strana 208kB" class="form-background">

<input type="text" name="datk" id="datk" onkeyup="CiarkaNaBodku(this);" style="width:195px; top:112px; left:426px;"/>

<span class="text-echo" style="top:268px; left:57px;"><?php echo $fir_fdic; ?></span>
<?php
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
?>
<span class="text-echo" style="top:323px; left:57px;"><?php echo $ico; ?></span>
<input type="text" name="datz" id="datz" onkeyup="CiarkaNaBodku(this);"
       style="width:195px; top:262px; left:323px;"/>
<input type="text" name="dats" id="dats" onkeyup="CiarkaNaBodku(this);"
       style="width:195px; top:318px; left:323px;"/>
<input type="text" name="obbod" id="obbod" onkeyup="CiarkaNaBodku(this);"
       style="width:140px; top:260px; left:752px;"/>
<input type="text" name="obbdo" id="obbdo" onkeyup="CiarkaNaBodku(this);"
       style="width:140px; top:298px; left:752px;"/>
<input type="text" name="obmod" id="obmod" onkeyup="CiarkaNaBodku(this);"
       style="width:140px; top:338px; left:752px;"/>
<input type="text" name="obmdo" id="obmdo" onkeyup="CiarkaNaBodku(this);"
       style="width:140px; top:376px; left:752px;"/>
<input type="radio" id="druhuz0" name="druhuz" value="0" style="top:444px; left:67px;"/>
<input type="radio" id="druhuz1" name="druhuz" value="1" style="top:471px; left:67px;"/>
<input type="radio" id="druhuj0" name="druhuj" value="0" style="top:422px; left:417px;"/>
<input type="radio" id="druhuj1" name="druhuj" value="1" style="top:449px; left:417px;"/>
<input type="radio" id="druhuj2" name="druhuj" value="2" style="top:477px; left:417px;"/>
<input type="radio" id="druhuj3" name="druhuj" value="3" style="top:505px; left:417px;"/>

<!-- uctovna jednotka -->
<div class="input-echo" style="width:843px; top:563px; left:52px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:635px; top:726px; left:52px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:174px; top:726px; left:719px;"><?php echo $fir_fcdm; ?></div>
<div class="input-echo" style="width:110px; top:780px; left:52px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:703px; top:780px; left:191px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:290px; top:836px; left:52px;"><?php echo $fir_ftel; ?></div>
<div class="input-echo" style="width:290px; top:836px; left:372px;"><?php echo $fir_ffax; ?></div>
<div class="input-echo" style="width:843px; top:891px; left:52px;"><?php echo $fir_fem1; ?></div>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" alt="<?php echo $jpg_popis; ?> 2.strana 184kB" class="form-background">


<?php                     } ?>

<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div><!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
//PDF
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
$sqltt = "SELECT * FROM F$kli_vxcf"."_uzavozn493 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

/*
	  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);
*/

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str1.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostavena k
$pdf->Cell(190,16," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->datk);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(86,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,28," ","$rmc1",1,"L");
$textxx="1234567890";
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$textxx="12345678";
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//datum zostavenia
$pdf->SetY(60);
$text=SkDatum($hlavicka->datz);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(64,6," ","$rcm1",0,"C");
$pdf->Cell(3,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t06","$rmc",1,"C");

//datum schvalenia
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=SkDatum($hlavicka->dats);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(64,6," ","$rcm1",0,"C");
$pdf->Cell(3,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$t06","$rmc",1,"C");

//za obdobie
//od
$pdf->SetY(60);
$text=$hlavicka->obbod;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obbod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$od1=substr($mesiac,0,1);
$od2=substr($mesiac,1,1);
$rok=$pole[1];
$rok1=substr($rok,2,1);
$rok2=substr($rok,3,1);
$pdf->Cell(158,5," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$od1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$od2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$rok1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$rok2","$rmc",1,"C");
//do
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->obbdo;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obbdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$od1=substr($mesiac,0,1);
$od2=substr($mesiac,1,1);
$rok=$pole[1];
$rok1=substr($rok,2,1);
$rok2=substr($rok,3,1);
$pdf->Cell(158,5," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$od1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$od2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$rok1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$rok2","$rmc",1,"C");

//predch.obdobie
//od
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$hlavicka->obmod;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obmod);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$od1=substr($mesiac,0,1);
$od2=substr($mesiac,1,1);
$rok=$pole[1];
$rok1=substr($rok,2,1);
$rok2=substr($rok,3,1);
$pdf->Cell(158,5," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$od1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$od2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$rok1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$rok2","$rmc",1,"C");
//do
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=$hlavicka->obmdo;
if ( $text == '00.0000' ) { $text=""; }
$pole = explode(".", $hlavicka->obmdo);
$mesiac=$pole[0];
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
$od1=substr($mesiac,0,1);
$od2=substr($mesiac,1,1);
$rok=$pole[1];
$rok1=substr($rok,2,1);
$rok2=substr($rok,3,1);
$pdf->Cell(158,5," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$od1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$od2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$rok1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$rok2","$rmc",1,"C");

//druh zavierky
$pdf->SetFont('arial','',10);
$riadna="x"; $mimoriadna="";
if ( $hlavicka->druhuz == 1 ) { $riadna=""; $mimoriadna="x"; }
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(8,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadna","$rmc",1,"C");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(8,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$mimoriadna","$rmc",1,"C");

//typ uct.jednotky
$poduj="x"; $muj=""; $noju=""; $nopu="";
if ( $hlavicka->druhuj == 1 ) { $poduj=""; $muj="x"; $noju=""; $nopu=""; }
if ( $hlavicka->druhuj == 2 ) { $poduj=""; $muj=""; $noju="x"; $nopu=""; }
if ( $hlavicka->druhuj == 3 ) { $poduj=""; $muj=""; $noju=""; $nopu="x"; }
$pdf->SetY(97);
$pdf->Cell(85,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$poduj","$rmc",1,"C");
$pdf->SetY(103);
$pdf->Cell(85,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$muj","$rmc",1,"C");
$pdf->SetY(109);
$pdf->Cell(85,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$noju","$rmc",1,"C");
$pdf->SetY(116);
$pdf->Cell(85,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$nopu","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//uct.jednotka
//nazov
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$fir_fnazr2="";
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,37,36);
$A=substr($fir_fnazr2,0,1);
$B=substr($fir_fnazr2,1,1);
$C=substr($fir_fnazr2,2,1);
$D=substr($fir_fnazr2,3,1);
$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);
$G=substr($fir_fnazr2,6,1);
$H=substr($fir_fnazr2,7,1);
$I=substr($fir_fnazr2,8,1);
$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);
$L=substr($fir_fnazr2,11,1);
$M=substr($fir_fnazr2,12,1);
$N=substr($fir_fnazr2,13,1);
$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);
$R=substr($fir_fnazr2,16,1);
$S=substr($fir_fnazr2,17,1);
$T=substr($fir_fnazr2,18,1);
$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);
$W=substr($fir_fnazr2,21,1);
$X=substr($fir_fnazr2,22,1);
$Y=substr($fir_fnazr2,23,1);
$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);
$B1=substr($fir_fnazr2,26,1);
$C1=substr($fir_fnazr2,27,1);
$D1=substr($fir_fnazr2,28,1);
$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);
$G1=substr($fir_fnazr2,31,1);
$H1=substr($fir_fnazr2,32,1);
$I1=substr($fir_fnazr2,33,1);
$J1=substr($fir_fnazr2,34,1);
$K1=substr($fir_fnazr2,35,1);
$L1=substr($fir_fnazr2,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Sidlo
//ulica
$pdf->Cell(190,22," ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$fir_fuli;
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");

//cislo
$textxx="111122";
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fpsc;
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
$text=$fir_fmes;
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
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$t01=substr($fir_ftel,0,1);
$t02=substr($fir_ftel,1,1);
$t03=substr($fir_ftel,2,1);
$t04=substr($fir_ftel,3,1);
$t05=substr($fir_ftel,4,1);
$t06=substr($fir_ftel,5,1);
$t07=substr($fir_ftel,6,1);
$t08=substr($fir_ftel,7,1);
$t09=substr($fir_ftel,8,1);
$t10=substr($fir_ftel,9,1);
$t11=substr($fir_ftel,10,1);
$t12=substr($fir_ftel,11,1);
$t13=substr($fir_ftel,12,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");

//cislo faxu
$t01=substr($fir_ffax,0,1);
$t02=substr($fir_ffax,1,1);
$t03=substr($fir_ffax,2,1);
$t04=substr($fir_ffax,3,1);
$t05=substr($fir_ffax,4,1);
$t06=substr($fir_ffax,5,1);
$t07=substr($fir_ffax,6,1);
$t08=substr($fir_ffax,7,1);
$t09=substr($fir_ffax,8,1);
$t10=substr($fir_ffax,9,1);
$t11=substr($fir_ffax,10,1);
$t12=substr($fir_ffax,11,1);
$t13=substr($fir_ffax,12,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",1,"C");

//email
$pdf->Cell(190,6," ","$rmc1",1,"L");
$fir_fulicis=$fir_fem1;
$A=substr($fir_fulicis,0,1);
$B=substr($fir_fulicis,1,1);
$C=substr($fir_fulicis,2,1);
$D=substr($fir_fulicis,3,1);
$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);
$G=substr($fir_fulicis,6,1);
$H=substr($fir_fulicis,7,1);
$I=substr($fir_fulicis,8,1);
$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);
$L=substr($fir_fulicis,11,1);
$M=substr($fir_fulicis,12,1);
$N=substr($fir_fulicis,13,1);
$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);
$R=substr($fir_fulicis,16,1);
$S=substr($fir_fulicis,17,1);
$T=substr($fir_fulicis,18,1);
$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);
$W=substr($fir_fulicis,21,1);
$X=substr($fir_fulicis,22,1);
$Y=substr($fir_fulicis,23,1);
$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);
$B1=substr($fir_fulicis,26,1);
$C1=substr($fir_fulicis,27,1);
$D1=substr($fir_fulicis,28,1);
$E1=substr($fir_fulicis,29,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");
                                       } //$strana == 1 OR $strana == 9999

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str2.jpg') AND $i == 0 )
{
$pdf->Image($jpg_source.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);





                                       } //$strana == 2 OR $strana == 9999
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
//$copern == 10
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

<script type="text/javascript">
//dimensions blank
var blank_param = 'scrollbars=yes, resizable=yes, top=0, left=0, width=1080, height=900';

<?php
//uprava
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.datk.value = '<?php echo "$datk_sk";?>';
   document.formv1.datz.value = '<?php echo "$datz_sk";?>';
   document.formv1.dats.value = '<?php echo "$dats_sk";?>';
   document.formv1.obbod.value = '<?php echo "$obbod";?>';
   document.formv1.obbdo.value = '<?php echo "$obbdo";?>';
   document.formv1.obmod.value = '<?php echo "$obmod";?>';
   document.formv1.obmdo.value = '<?php echo "$obmdo";?>';
<?php if ( $druhuz == 0 ) { ?> document.formv1.druhuz0.checked = 'true'; <?php } ?>
<?php if ( $druhuz == 1 ) { ?> document.formv1.druhuz1.checked = 'true'; <?php } ?>
<?php if ( $druhuj == 0 ) { ?> document.formv1.druhuj0.checked = 'true'; <?php } ?>
<?php if ( $druhuj == 1 ) { ?> document.formv1.druhuj1.checked = 'true'; <?php } ?>
<?php if ( $druhuj == 2 ) { ?> document.formv1.druhuj2.checked = 'true'; <?php } ?>
<?php if ( $druhuj == 3 ) { ?> document.formv1.druhuj3.checked = 'true'; <?php } ?>
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>

<?php                     } ?>
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
  function editForm(strana)
  {
    window.open('uzavierka_ozn493.php?copern=20&strana=' + strana + '&drupoh=1', '_self');
  }
  function FormPDF(strana)
  {
    window.open('uzavierka_ozn493.php?copern=10&strana=' + strana + '&drupoh=1', '_blank', blank_param);
  }
</script>
</body>
</html>