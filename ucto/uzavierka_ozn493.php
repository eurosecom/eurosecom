<!doctype html>
<html>
<?php
//celkovy zaciatok dokumentu Oznamenie daÚovnÌka o predÂûenÌ lehoty na podanie daÚovÈho priznania v. 2017
do
{
$sys = 'UCT';
$urov = 2000;
$copern = $_REQUEST['copern'];
//$tis = $_REQUEST['tis'];
//if (!isset($tis)) $tis = 0;

//echo $copern;

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

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$jedn = 1*$_REQUEST['jedn'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana = 1; }

//.jpg source
$jpg_source="../dokumenty/dan_z_prijmov2017/ozn493/ozn493_v17";
$jpg_title="tlaËivo Ozn·menie daÚovnÌka o predÂûenÌ lehoty na podanie daÚovÈho priznania pre rok ".$kli_vrok;

//znovu nacitaj
if ( $copern == 26 )
     {
$sqtoz = "DROP TABLE F$kli_vxcf"."_uzavozn493 ";
$oznac = mysql_query("$sqtoz");
$copern=10;
$subor=1;
     }
//koniec znovu nacitaj


//vytvorenie tabulky
$sql = "SELECT datvyp FROM F$kli_vxcf"."_uzavozn493";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sql = "DROP TABLE F$kli_vxcf"."_uzavozn493";
$vysledok = mysql_query("$sql");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   datopr       DATE NOT NULL,
   opr          DECIMAL(2,0) DEFAULT 0,
   drdc         VARCHAR(6) NOT NULL,
   drdk         VARCHAR(4) NOT NULL,
   ddar         DATE NOT NULL,
   sruli        VARCHAR(30) NOT NULL,
   srcdm        VARCHAR(10) NOT NULL,
   srpsc        VARCHAR(10) NOT NULL,
   srmes        VARCHAR(30) NOT NULL,
   predl3mes    DECIMAL(2,0) DEFAULT 0,
   predl6mes    DECIMAL(2,0) DEFAULT 0,
   datpredl     DATE NOT NULL,
   datvyp       DATE NOT NULL,
   konx         DECIMAL(1,0) DEFAULT 0
);
mzdprc;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uzavozn493'.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uzavozn493 ( oc ) VALUES ( '0' ) ";
$dsql = mysql_query("$dsqlt");
}

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvypl".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavozn493 WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_mzdprcvyplx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_uzavozn493 WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");


//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
$datopr = strip_tags($_REQUEST['datopr']);
$datopr_sql = SqlDatum($datopr);
$opr = 1*$_REQUEST['opr'];
$drdc = strip_tags($_REQUEST['drdc']);
$drdk = strip_tags($_REQUEST['drdk']);
$ddar = strip_tags($_REQUEST['ddar']);
$ddar_sql=SqlDatum($ddar);
$sruli = strip_tags($_REQUEST['sruli']);
$srcdm = strip_tags($_REQUEST['srcdm']);
$srpsc = strip_tags($_REQUEST['srpsc']);
$srmes = strip_tags($_REQUEST['srmes']);

$uprtxt = "UPDATE F$kli_vxcf"."_uzavozn493 SET ".
" datopr='$datopr_sql', opr='$opr', ".
" drdc='$drdc', drdk='$drdk', ddar='$ddar_sql', ".
" sruli='$sruli', srcdm='$srcdm', srpsc='$srpsc', srmes='$srmes' ".
" WHERE oc = $cislo_oc ";
                    }

if ( $strana == 2 ) {
$predl3mes = 1*$_REQUEST['predl3mes'];
$predl6mes = 1*$_REQUEST['predl6mes'];
$datpredl = strip_tags($_REQUEST['datpredl']);
$datpredl_sql = SqlDatum($datpredl);
$datvyp = strip_tags($_REQUEST['datvyp']);
$datvyp_sql = SqlDatum($datvyp);

$uprtxt = "UPDATE F$kli_vxcf"."_uzavozn493 SET ".
" predl3mes='$predl3mes', predl6mes='$predl6mes', datpredl='$datpredl_sql', datvyp='$datvyp_sql' ".
" WHERE oc = $cislo_oc ";
//echo $uprtxt;
                    }

$uprav="NO";
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

//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uzavozn493 ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
if ( $strana == 1 ) {
//$obbod_sk = SkDatum($fir_riadok->obbod);
//$obbdo_sk = SkDatum($fir_riadok->obbdo);
$datopr_sk = SkDatum($fir_riadok->datopr);
$opr = $fir_riadok->opr;
$drdc = $fir_riadok->drdc;
$drdk = $fir_riadok->drdk;
$ddar_sk = SkDatum($fir_riadok->ddar);
$sruli = $fir_riadok->sruli;
$srcdm = $fir_riadok->srcdm;
$srpsc = $fir_riadok->srpsc;
$srmes = $fir_riadok->srmes;
                    }
if ( $strana == 2 ) {
$predl3mes = $fir_riadok->predl3mes;
$predl6mes = $fir_riadok->predl6mes;
$datpredl_sk = SkDatum($fir_riadok->datpredl);
$datvyp_sk = SkDatum($fir_riadok->datvyp);
                    }
     }
//koniec nacitania

//obdobia z ufirdalsie
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

//nacitaj uzavierka k datumu z ufirdalsie
$datksk="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
   if (@$zaznam=mysql_data_seek($sql,0))
   {
   $riadok=mysql_fetch_object($sql);
   $datksk=SkDatum($riadok->datk);
   }
if ( $datksk != '' AND $datksk != '00.00.0000' ) { $datk_sk=$datksk; }


//nacitaj uzavierka k datumu a obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
if( $datmodsk == '00.00.0000' ) { $datmodsk=""; $datmdosk=""; }
     }
  }//koniec blok okolo obdobi uzavierky

//FO z ufirdalsie
if ( $fir_uctt03 == 999 )
{
$sqlc = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE icox = 0";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$dprie = $riadokc->dprie;
$dmeno = $riadokc->dmeno;
$dtitl = $riadokc->dtitl;
$dtitz = $riadokc->dtitz;
$duli = $riadokc->duli;
$dcdm = $riadokc->dcdm;
$dpsc = $riadokc->dpsc;
$dmes = $riadokc->dmes;
$dstat = $riadokc->dstat;
//$dtel = $riadokc->dtel;
//$dfax = $riadokc->dfax;
     }
}
if ( $fir_uctt03 != 999 )
{
$dmeno=""; $dprie=""; $dtitl=""; $dtitz="";
$duli=$fir_fuli; $dcdm=$fir_fcdm; $dmes=$fir_fmes; $dpsc=$fir_fpsc;
$dstat="Slovensko";
//$dtel=$fir_ftel; $dfax=$fir_ffax;
}
$fir_uctt03tlac=$fir_uctt03;
if ( $fir_uctt03 == 999 )
{
$fir_fnaz="";
$datbodsk="";
$datbdosk="";
//2-miestny rok
$kli_vrokx2 = substr($kli_vrok,2,2);
}

//6-miestne ico
if ( $fir_uctt03 != 999 AND $fir_fdic == "" )
{
$ico=$fir_fico;
if ( $fir_fico < 1000000 ) { $ico="00".$fir_fico; }
}
//za obdobie nasekanie
$datbodskdni = substr($datbodsk,0,2);
$datbodskmes = substr($datbodsk,3,2);
$datbodskrok = substr($datbodsk,8,9);
$datbdoskdni = substr($datbdosk,0,2);
$datbdoskmes = substr($datbdosk,3,2);
$datbdoskrok = substr($datbdosk,8,9);

//vypracoval
$zrobil = $fir_mzdt05; if ( $fir_mzdt05 == '' ) $zrobil=$kli_uzmeno." ".$kli_uzprie;
?>
<head>
<meta charset="cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>OZN493v17 | EuroSecom</title>
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
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="FormXML();" title="Export do XML" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="uzavierka_ozn493.php?copern=23&strana=<?php echo $strana; ?>&drupoh=1">
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
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:327px; left:57px;"><?php echo $fir_fdic; ?></span>
<span class="text-echo" style="top:332px; left:484px;"><?php echo $kli_vrokx2; ?></span>
<span class="text-echo" style="top:311px; left:701px;"><?php echo $datbodskdni; ?></span>
<span class="text-echo" style="top:311px; left:759px;"><?php echo $datbodskmes; ?></span>
<span class="text-echo" style="top:311px; left:860px;"><?php echo $datbodskrok; ?></span>
<span class="text-echo" style="top:349px; left:701px;"><?php echo $datbdoskdni; ?></span>
<span class="text-echo" style="top:349px; left:759px;"><?php echo $datbdoskmes; ?></span>
<span class="text-echo" style="top:349px; left:860px;"><?php echo $datbdoskrok; ?></span>
<input type="checkbox" name="opr" value="1" style="top:387px; left:180px;"/>
<input type="text" name="datopr" id="datopr" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:195px; top:385px; left:697px;"/>

<!-- fo -->
<div class="input-echo" style="width:360px; top:498px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:245px; top:498px; left:431px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:113px; top:498px; left:695px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:68px; top:498px; left:827px;"><?php echo $dtitz; ?></div>
<input type="text" name="drdc" id="drdc" maxlength="6" style="width:128px; top:552px; left:52px;"/>
<input type="text" name="drdk" id="drdk" maxlength="4" style="width:82px; top:552px; left:213px;"/>
<input type="text" name="ddar" id="ddar" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:552px; left:477px;"/>
<!-- po -->
<div class="input-echo" style="width:843px; top:630px; left:52px;"><?php echo $fir_fnaz; ?></div>
<span class="text-echo" style="top:764px; left:57px;"><?php echo $ico; ?></span>
<!-- adresa -->
<div class="input-echo" style="width:635px; top:835px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:174px; top:835px; left:720px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:106px; top:888px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:452px; top:888px; left:178px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:888px; left:649px;"><?php echo $dstat; ?></div>
<!-- adresa SR -->
<input type="text" name="sruli" id="sruli" style="width:634px; top:962px; left:52px;"/>
<input type="text" name="srcdm" id="srcdm" style="width:174px; top:962px; left:718px;"/>
<input type="text" name="srpsc" id="srpsc" maxlength="5" style="width:105px; top:1017px; left:52px;"/>
<input type="text" name="srmes" id="srmes" style="width:450px; top:1017px; left:178px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" alt="<?php echo $jpg_title; ?>" class="form-background">
<span class="text-echo" style="top:94px; left:308px;"><?php echo $fir_fdic; ?></span>
<input type="checkbox" name="predl3mes" value="1" onchange="klikpredl3mes();" style="top:172px; left:54px;"/>
<input type="checkbox" name="predl6mes" value="1" onchange="klikpredl6mes();" style="top:210px; left:54px;"/>
<input type="text" name="datpredl" id="datpredl" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:195px; top:190px; left:697px;"/>
<div class="input-echo" style="top:286px; left:52px;"><?php echo $zrobil; ?></div>
<input type="text" name="datvyp" id="datvyp" onkeyup="CiarkaNaBodku(this);" maxlength="10" style="width:196px; top:285px; left:386px;"/>
<div class="input-echo" style="width:290px; top:286px; left:604px;"><?php echo $fir_mzdt04; ?></div>
<?php                     } ?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <input type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>
</div><!-- #content -->
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

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

//dic
$pdf->Cell(190,58.5," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");

//fo-obdobie
$textxx="1234567890";
$text=$kli_vrokx2;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(45,6," ","$rmc1",0,"R");$pdf->Cell(4,8,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,8,"$t02","$rmc",0,"C");

//po-obdobie-od
$pdf->SetY(64.5);
$text=$datbodsk;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(144,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//po-obdobie-do
$pdf->Cell(190,3," ","$rmc1",1,"L");
$text=$datbdosk;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(144,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//opravne
$pdf->Cell(190,10," ","$rmc1",1,"L");
$text="x"; if ( $hlavicka->opr == 0 ) $text=" ";
$pdf->Cell(30,7," ","$rmc1",0,"C");$pdf->Cell(4,3,"$text","$rmc",0,"C");
//opravne-datum
$text=SkDatum($hlavicka->datopr);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(110,6," ","$rcm1",0,"C");
$pdf->Cell(4,5,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t06","$rmc",1,"C");

//fo-priezvisko
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
//fo-meno
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
//fo-titulpred-titulza
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$dtitl","$rmc",0,"L");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(15,6,"$dtitz","$rmc",1,"L");
//fo-rodnecislo
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->drdc.$hlavicka->drdk;
$textxx="1234567890";
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
//fo-datumnarodenia
$text=SkDatum($hlavicka->ddar);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,6,1);
$t06=substr($text,7,1);
$t07=substr($text,8,1);
$t08=substr($text,9,1);
$pdf->Cell(39,6," ","$rcm1",0,"C");
$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//po-nazov
$pdf->Cell(190,11," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
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
//po-nazov-r2
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
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
//ico
$pdf->SetY(168);
$textxx="12345678";
$text=$ico;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//adresa-ulica
$pdf->Cell(190,11.5," ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$duli;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
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
//adresa-ulica-cislo
$textxx="111122";
$text=$dcdm;
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
//adresa-psc
$pdf->Cell(190,6.5," ","$rmc1",1,"L");
$text=$dpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
//adresa-obec
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
//adresa-stat
$text=$dstat;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",1,"C");

//sr-adresa-ulica
$pdf->Cell(190,11," ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$hlavicka->sruli;
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
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
//sr-adresa-ulica-cislo
$textxx="111122";
$text=$hlavicka->srcdm;
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
//sr-adresa-psc
$pdf->Cell(190,6.5," ","$rmc1",1,"L");
$text=$hlavicka->srpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");
//adresa-obec
$text=$hlavicka->srmes;
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
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",1,"C");
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

//dic
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(57,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//predlzenie-3mes
$pdf->Cell(190,13," ","$rmc1",1,"L");
$text="x"; if ( $hlavicka->predl3mes == 0 ) $text=" ";
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,4,"$text","$rmc",1,"C");
//predlzenie-6mes
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text="x"; if ( $hlavicka->predl6mes == 0 ) $text=" ";
$pdf->Cell(2,7," ","$rmc1",0,"C");$pdf->Cell(4,4,"$text","$rmc",1,"C");
//predlzenie-datum
$pdf->SetY(39);
$text=SkDatum($hlavicka->datpredl);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(144,6," ","$rcm1",0,"C");
$pdf->Cell(4,5,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t06","$rmc",1,"C");

//vypracoval
$pdf->Cell(190,16.5," ","$rmc1",1,"L");
$textxx="1234567890";
$text=$zrobil;
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(70,5,"$text","$rmc",0,"L");
//vypracoval-dna
$text=SkDatum($hlavicka->datvyp);
if ( $text == '00.00.0000' ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rcm1",0,"C");
$pdf->Cell(4,5,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,5,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t06","$rmc",0,"C");
//vypracoval-tel
$t01=substr($fir_mzdt04,0,1);
$t02=substr($fir_mzdt04,1,1);
$t03=substr($fir_mzdt04,2,1);
$t04=substr($fir_mzdt04,3,1);
$t05=substr($fir_mzdt04,4,1);
$t06=substr($fir_mzdt04,5,1);
$t07=substr($fir_mzdt04,6,1);
$t08=substr($fir_mzdt04,7,1);
$t09=substr($fir_mzdt04,8,1);
$t10=substr($fir_mzdt04,9,1);
$t11=substr($fir_mzdt04,10,1);
$t12=substr($fir_mzdt04,11,1);
$t13=substr($fir_mzdt04,12,1);
$pdf->Cell(3,7," ","$rmc1",0,"C");$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,5,"$t13","$rmc",1,"C");
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

<?php
//xml
if ( $copern == 40 )
     {
$hhmm = Date( "Hi", MkTime( date("H"),date("i"),date("s"),date("m"),date("d"),date("Y") ) );
//$idx=$kli_uzid.$hhmm;
$kli_nxcf10 = substr($kli_nxcf,0,10);
$kli_nxcf10=trim(str_replace(" ","",$kli_nxcf10));

$nazsub="../tmp/ozn493".$kli_vrok."_id".$kli_uzid."_".$kli_nxcf."_".$hhmm.".xml";

//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
     $soubor = fopen("../tmp/$nazsub", "a+");


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_uzavozn493 ";
//echo $sqltt;
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
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"ozn493_2017.xsd\">"."\r\n"; 
  fwrite($soubor, $text);

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
if ( $fir_uctt03 != 999 ) { $rok=""; }
  $text = "   <zaRok><![CDATA[".$rok."]]></zaRok>"."\r\n"; fwrite($soubor, $text);

  $text = "   <datumOd><![CDATA[".$datbodsk."]]></datumOd>"."\r\n"; fwrite($soubor, $text);
  $text = "   <datumDo><![CDATA[".$datbdosk."]]></datumDo>"."\r\n"; fwrite($soubor, $text);

$dovoddoplnenia=1*$hlavicka->opr;

  $text = "   <dovodDoplnenia><![CDATA[".$dovoddoplnenia."]]></dovodDoplnenia>"."\r\n"; fwrite($soubor, $text);

$datopr=SkDatum($hlavicka->datopr);
if( $datopr == '' ) $datopr="";

  $text = "   <datumPovodne><![CDATA[".$datopr."]]></datumPovodne>"."\r\n"; fwrite($soubor, $text);


  $text = " <fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <titulPred><![CDATA[".$titul."]]></titulPred>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
  $text = "  <rodneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "   <rcPredLom><![CDATA[".$rcpred."]]></rcPredLom>"."\r\n"; fwrite($soubor, $text);
  $text = "   <rcZaLom><![CDATA[".$rcza."]]></rcZaLom>"."\r\n"; fwrite($soubor, $text);
  $text = "  </rodneCislo>"."\r\n"; fwrite($soubor, $text);
  $text = "  <datumNarodenia><![CDATA[".$datnar."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);
  $text = " </fyzickaOsoba>"."\r\n"; fwrite($soubor, $text);


  $text = " <pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);
  $text = " <obchodneMeno>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "  <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "  <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "  <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = " </obchodneMeno>"."\r\n"; fwrite($soubor, $text);
  $text = " <ico></ico>"."\r\n"; fwrite($soubor, $text);
  $text = " </pravnickaOsoba>"."\r\n"; fwrite($soubor, $text);

//sidlo PO alebo trvale FO
if ( $fir_uctt03 == 999 ) 
{

$fir_fuli=$duli;
$fir_fcdm=$dcdm;
$fir_fpsc=$dpsc;
$fir_fmes=$dmes;
$fir_fstat=$dstat;
}

  $text = "  <sidlo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=iconv("CP1250", "UTF-8", $fir_fcdm);
  $text = "   <supisneOrientacneCislo><![CDATA[".$cislo."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
$fir_fpsc = str_replace(" ","",$fir_fpsc);
$psc=iconv("CP1250", "UTF-8", $fir_fpsc);
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$fir_fstat="Slovensko";
$stat=iconv("CP1250", "UTF-8", $fir_fstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaSr>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->sruli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=iconv("CP1250", "UTF-8", $hlavicka->srcdm);
  $text = "   <supisneOrientacneCislo><![CDATA[".$cislo."]]></supisneOrientacneCislo>"."\r\n"; fwrite($soubor, $text);
$srpsc = str_replace(" ","",$hlavicka->srpsc);
$psc=iconv("CP1250", "UTF-8", $srpsc);
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->srmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$srstat="Slovensko";
$stat=iconv("CP1250", "UTF-8", $srstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaSr>"."\r\n"; fwrite($soubor, $text);


$predl3mes=1*$hlavicka->predl3mes;
$predl6mes=1*$hlavicka->predl6mes;
  $text = "  <novaLehota>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predlzenie493a><![CDATA[".$predl3mes."]]></predlzenie493a>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predlzenie493b><![CDATA[".$predl6mes."]]></predlzenie493b>"."\r\n"; fwrite($soubor, $text);

$datpredl=SkDatum($hlavicka->datpredl);

  $text = "   <datumLehota><![CDATA[".$datpredl."]]></datumLehota>"."\r\n"; fwrite($soubor, $text);
  $text = "  </novaLehota>"."\r\n"; fwrite($soubor, $text);

$zrobil = $fir_mzdt05; if ( $fir_mzdt05 == '' ) $zrobil=$kli_uzmeno." ".$kli_uzprie;

$zrobil=iconv("CP1250", "UTF-8", $zrobil);
$telefon=iconv("CP1250", "UTF-8", $fir_mzdt04);


  $text = "  <vypracoval>"."\r\n"; fwrite($soubor, $text);
  $text = "   <vypr><![CDATA[".$zrobil."]]></vypr>"."\r\n"; fwrite($soubor, $text);

$dna=SkDatum($hlavicka->datvyp);

  $text = "   <dna><![CDATA[".$dna."]]></dna>"."\r\n"; fwrite($soubor, $text);

  $text = "   <telefon><![CDATA[".$telefon."]]></telefon>"."\r\n"; fwrite($soubor, $text);
  $text = "  </vypracoval>"."\r\n"; fwrite($soubor, $text);


$podpis=1;
  $text = "   <podpis><![CDATA[".$podpis."]]></podpis>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>
<div class="bg-white" style="padding: 16px 24px;">
  <p style="line-height: 1.3;">Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a naËÌtajte ho na str·nku <a href="https://www.financnasprava.sk/sk/titulna-stranka" target="_blank" title="Str·nka FinanËnej spr·vy">FinanËnej spr·vy</a> alebo do aplik·cie eDane:
  </p>
  <p style="line-height: 40px;"><a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a></p>
</div>
<?php
//mysql_free_result($vysledok);
     }
//$copern == 40
//koniec xml
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
<?php if ( $opr == 1 ) { ?> document.formv1.opr.checked = 'true'; <?php } ?>
    document.formv1.datopr.value = '<?php echo "$datopr_sk"; ?>';
    document.formv1.drdc.value = '<?php echo "$drdc"; ?>';
    document.formv1.drdk.value = '<?php echo "$drdk"; ?>';
    document.formv1.ddar.value = '<?php echo "$ddar_sk"; ?>';
    document.formv1.sruli.value = '<?php echo "$sruli"; ?>';
    document.formv1.srcdm.value = '<?php echo "$srcdm"; ?>';
    document.formv1.srpsc.value = '<?php echo "$srpsc"; ?>';
    document.formv1.srmes.value = '<?php echo "$srmes"; ?>';
<?php                     } ?>
<?php if ( $strana == 2 ) { ?>
<?php if ( $predl3mes == 1 ) { ?> document.formv1.predl3mes.checked = 'true'; <?php } ?>
<?php if ( $predl6mes == 1 ) { ?> document.formv1.predl6mes.checked = 'true'; <?php } ?>
    document.formv1.datpredl.value = '<?php echo "$datpredl_sk"; ?>';
    document.formv1.datvyp.value = '<?php echo "$datvyp_sk"; ?>';
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

//predlzenie 3mes vs. 6mes
  function klikpredl3mes()
  {
   document.formv1.predl6mes.checked = false;
  }
  function klikpredl6mes()
  {
   document.formv1.predl3mes.checked = false;
  }

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

  function FormXML()
  {
   window.open('uzavierka_ozn493.php?copern=40&drupoh=1', '_blank', blank_param);
  }
</script>
</body>
</html>