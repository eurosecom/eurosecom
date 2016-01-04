<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$mesiac=$kli_vmes;
$vyb_ump="1.".$kli_vrok; $vyb_umk=$kli_vmes.".".$kli_vrok; 

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/opu112/opu112_v16";
$jpg_popis="tlaËivo MesaËn˝ v˝kaz v obchode, pohostinstve ... OPU 1-12 ".$kli_vrok;

if ( $copern < 2 ) { $copern=2; };

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 AND $copern == 11 ) $strana=9999;
if ( $strana == 0 ) $strana=1;


// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$modul = 1*$_REQUEST['modul'];


//prepnute z uobrat.php modul 124 
if ( $modul == 124 )
{
$r124r01=0;$r124r02=0;$r124r03=0;$r124r04=0;$r124r99=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r124r01=$r124r01+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 343 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r124r02=$r124r02+$polozka->odl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 521 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r124r04=$r124r04+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE pom = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r124r03=$r124r03+1; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET ".
" mod124r01='$r124r01',mod124r02='$r124r02',mod124r03='$r124r03',mod124r04='$r124r04', ".
" mod124r99=mod124r01+mod124r02+mod124r03+mod124r04 ".
" WHERE umex = $kli_vume "; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET ".
" mod124r02='$fir_dph2'*mod124r01/100 ".
" WHERE umex = $kli_vume "; 
$upravene = mysql_query("$uprtxt");

//odpocitaj predchadzajuce
$kolko=$kli_vmes-1;
$ik=1;
while ($ik <= $kolko )  
  {
$umexx=$ik.".".$kli_vrok;

$sqtoz = "UPDATE F$kli_vxcf"."_statistika_opu112,F$kli_vxcf"."_statistika_opu112arch ".
" SET F$kli_vxcf"."_statistika_opu112.mod124r01=F$kli_vxcf"."_statistika_opu112.mod124r01-F$kli_vxcf"."_statistika_opu112arch.mod124r01, ".
" F$kli_vxcf"."_statistika_opu112.mod124r02=F$kli_vxcf"."_statistika_opu112.mod124r02-F$kli_vxcf"."_statistika_opu112arch.mod124r02, ".
" F$kli_vxcf"."_statistika_opu112.mod124r04=F$kli_vxcf"."_statistika_opu112.mod124r04-F$kli_vxcf"."_statistika_opu112arch.mod124r04  ".
" WHERE F$kli_vxcf"."_statistika_opu112arch.umex = $umexx AND F$kli_vxcf"."_statistika_opu112.umex = $kli_vume ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$ik=$ik+1;                   
  }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET mod124r99=mod124r01+mod124r02+mod124r03+mod124r04 WHERE umex = $kli_vume "; 
$upravene = mysql_query("$uprtxt"); 

}
//koniec odpocitaj modul 124 z uobrat.php


//pracovny subor 
$sql = "SELECT umex FROM F$kli_vxcf"."_statistika_opu112 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_opu112';
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_opu112arch';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_opu112
(
   umex         DECIMAL(7,4) DEFAULT 0,
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(80) NOT NULL,
   predajdni     DECIMAL(10,0) DEFAULT 0,
   mod2r01     DECIMAL(10,0) DEFAULT 0,
   mod2r02     DECIMAL(10,0) DEFAULT 0,
   mod124r01     DECIMAL(10,0) DEFAULT 0,
   mod124r02     DECIMAL(10,0) DEFAULT 0,
   mod124r03     DECIMAL(10,0) DEFAULT 0,
   mod124r04     DECIMAL(10,0) DEFAULT 0,
   mod124r99     DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_opu112;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_opu112'.$sqlt;
$vytvor = mysql_query("$vsql");
}
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_opu112 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu112 ADD aktivita VARCHAR(10) NOT NULL AFTER cinnost";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu112 ADD odoslane DATE NOT NULL AFTER aktivita";
$vysledek = mysql_query("$sql");
}
//koniec pracovny subor

$poslhh = "SELECT * FROM F$kli_vxcf"."_statistika_opu112 WHERE umex = $kli_vume ";
$posl = mysql_query("$poslhh"); 
$umesp = 1*mysql_num_rows($posl);

if ( $umesp == 0 )
{
$poslhh = "INSERT INTO F$kli_vxcf"."_statistika_opu112 ( umex ) VALUES ( $kli_vume ) ";
$posl = mysql_query("$poslhh"); 
}

//zapis upravene udaje
if ( $copern == 3 )
     {
//$cinnost = strip_tags($_REQUEST['cinnost']);
$predajdni = strip_tags($_REQUEST['predajdni']);
$aktivita = strip_tags($_REQUEST['aktivita']);
$odoslane = strip_tags($_REQUEST['odoslane']);
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);
$mod124r01 = strip_tags($_REQUEST['mod124r01']);
$mod124r02 = strip_tags($_REQUEST['mod124r02']);
$mod124r03 = strip_tags($_REQUEST['mod124r03']);
$mod124r04 = strip_tags($_REQUEST['mod124r04']);
$odoslane_sql=SqlDatum($odoslane);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET ".
" odoslane='$odoslane_sql' ".
" WHERE ico >= 0 AND umex = $kli_vume ";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET ".
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu112 SET ".
" mod124r01='$mod124r01',mod124r02='$mod124r02',mod124r03='$mod124r03',mod124r04='$mod124r04', ".
" mod2r01='$mod2r01',mod2r02='$mod2r02', aktivita='$aktivita',  ".
" predajdni='$predajdni', mod124r99=mod124r01+mod124r02+mod124r03+mod124r04 ".
" WHERE ico >= 0 AND umex = $kli_vume ";
//echo $uprtxt;
" WHERE ico >= 0 AND umex = $kli_vume ";
                    }
$upravene = mysql_query("$uprtxt");
$copern=2;
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


//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_opu112 WHERE  umex =  $kli_vume ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$predajdni = $fir_riadok->predajdni;
$aktivita = $fir_riadok->aktivita;
$odoslane_sk = SkDatum($fir_riadok->odoslane);
$mod124r01 = $fir_riadok->mod124r01;
$mod124r02 = $fir_riadok->mod124r02;
$mod124r03 = $fir_riadok->mod124r03;
$mod124r04 = $fir_riadok->mod124r04;
$mod124r99 = $fir_riadok->mod124r99;
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;
mysql_free_result($fir_vysledok);
    }
//koniec nacitania
?>

<?php
//kod okresu z treximy
$okres="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximafir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $okres=$riaddok->uzemie;
  }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - v˝kaz OPU 1-12</title>
<style type="text/css">
img.btn-row-tool {
  width: 18px;
  height: 18px;
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
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 2 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
<?php                     } ?>
<?php if ( $strana == 2 ) { ?>
   document.formv1.predajdni.value = '<?php echo "$predajdni";?>';
   document.formv1.mod124r01.value = '<?php echo "$mod124r01";?>';
   document.formv1.mod124r02.value = '<?php echo "$mod124r02";?>';
   document.formv1.mod124r03.value = '<?php echo "$mod124r03";?>';
   document.formv1.mod124r04.value = '<?php echo "$mod124r04";?>';
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 2 AND $copern != 102 )
  { 
?>
  function ObnovUI()
  {
  }
<?php
//koniec uprava
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf', '_blank');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_opu112.php?copern=11&drupoh=1&page=1&typ=PDF', '_blank');
  }
  function UdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0',
'_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMod124()
  {
   window.open('../ucto/uobrat.php?copern=10&drupoh=1&page=1&typ=PDF&cstat=124&vyb_ume=<?php echo $vyb_umk; ?>', '_self');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 2 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">MesaËn˝ v˝kaz v obchode, pohostinstve a v ubytovanÌ OPU 1-12</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="MetodickÈ vysvetlivky k obsahu v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMod124();" title="NaËÌtaù ˙daje z obratovky" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="statistika_opu112.php?copern=3">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="statistika_opu112.php?drupoh=1&page=1";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=1&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=1&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 302kB">

<?php
$mesiacx=$mesiac;
if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
?>
<span class="text-echo" style="top:290px; left:289px; font-size:18px; letter-spacing:30px;"><?php echo $mesiacx; ?></span>
<span class="text-echo" style="top:290px; left:370px; font-size:18px; letter-spacing:34px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:823px; left:300px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:843px; left:300px;"><?php echo "$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:840px; left:840px;"><?php echo $okres; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="UdajeFirma();"
      title="Nastaviù kÛd okresu" class="btn-row-tool" style="top:838px; left:872px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:895px; left:55px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:910px; left:390px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:958px; left:55px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:956px; left:390px;"/>

<!-- modul 100307 -->
<span class="text-echo center" style="width:488px; top:1131px; left:412px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo center" style="width:488px; top:1158px; left:412px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo center" style="width:488px; top:1183px; left:412px;"><?php echo $fir_fem1; ?></span>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:830px; left:700px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:855px; left:700px;"/>

<!-- modul 100055 -->
<input type="text" name="predajdni" id="predajdni" style="width:100px; top:971px; left:700px;"/>

<!-- modul 124 -->
<input type="text" name="mod124r01" id="mod124r01" style="width:100px; top:1084px; left:700px;"/>
<input type="text" name="mod124r02" id="mod124r02" style="width:100px; top:1108px; left:700px;"/>
<input type="text" name="mod124r03" id="mod124r03" style="width:100px; top:1132px; left:700px;"/>
<input type="text" name="mod124r04" id="mod124r04" style="width:100px; top:1156px; left:700px;"/>
<span class="text-echo" style="top:1184px; right:145px;"><?php echo $mod124r99;?></span>



<?php                                        } ?>


<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=1&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=1&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 11 )
{
if ( File_Exists("../tmp/statistika.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/statistika.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_opu112 WHERE  umex =  $kli_vume  "."";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$mod2r01=$hlavicka->mod2r01;
if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02;
if ( $mod2r02 == 0 ) $mod2r02="";
$predajdni=$hlavicka->predajdni;
if ( $predajdni == 0 ) $predajdni="";
$mod124r01=$hlavicka->mod124r01;
if ( $mod124r01 == 0 ) $mod124r01="";
$mod124r02=$hlavicka->mod124r02;
if ( $mod124r02 == 0 ) $mod124r02="";
$mod124r03=$hlavicka->mod124r03;
if ( $mod124r03 == 0 ) $mod124r03="";
$mod124r04=$hlavicka->mod124r04;
if ( $mod124r04 == 0 ) $mod124r04="";

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/statistika2014/opu112/opu112v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu112/opu112v14_str1.jpg',0,0,210,297);
}

//OBDOBIA
$pdf->SetFont('arial','',15);
$pdf->Cell(190,27," ","$rmc1",1,"L");
$pdf->Cell(94,8," ","$rmc1",0,"L");$pdf->Cell(15,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',11);
$pdf->Cell(190,12," ","$rmc1",1,"L");
$R1=substr($kli_vrok,2,1);
$R2=substr($kli_vrok,3,1);
$mesiacx=$mesiac;
if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$A=substr($mesiacx,0,1);
$B=substr($mesiacx,1,1);
$pdf->Cell(30,5," ","$rmc1",0,"L");
$pdf->Cell(7,6,"$R1","$rmc",0,"C");$pdf->Cell(8,6,"$R2","$rmc",0,"C");$pdf->Cell(7,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");
//ico
$fir_ficx=$fir_fico;
$cfico=1*$fir_fico;
if ( $cfico < 999999 ) $fir_ficx="00".$fir_fico;
$A=substr($fir_ficx,0,1);
$B=substr($fir_ficx,1,1);
$C=substr($fir_ficx,2,1);
$D=substr($fir_ficx,3,1);
$E=substr($fir_ficx,4,1);
$F=substr($fir_ficx,5,1);
$G=substr($fir_ficx,6,1);
$H=substr($fir_ficx,7,1);
$pdf->Cell(7,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(7,6,"$D","$rmc",0,"C");
$pdf->Cell(7,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");$pdf->Cell(7,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,71," ","$rmc1",1,"L");
$pdf->Cell(55,4," ","$rmc1",0,"L");$pdf->Cell(98,4,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(152,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");
$pdf->Cell(37,6,"$okres","$rmc",1,"C");

//VYPLNIL
$pdf->Cell(195,5," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(73,6,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
$pdf->Cell(40,13,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,8,"$fir_fem1","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
//odoslane
$pdf->Cell(41,8,"$odoslane_sk","$rmc",1,"C");

//modul 2
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(67,5,"$mod2r01","$rmc",1,"C");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(67,6,"$mod2r02","$rmc",1,"C");

//modul 100055
$pdf->Cell(180,20," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(56,7,"$predajdni","$rmc",1,"C");

//modul 124
$pdf->Cell(195,20," ","$rmc1",1,"L");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$mod124r01","$rmc",1,"R");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$mod124r02","$rmc",1,"R");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$mod124r03","$rmc",1,"R");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$mod124r04","$rmc",1,"R");
$pdf->Cell(121,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$hlavicka->mod124r99","$rmc",1,"R");
}
$i = $i + 1;
  }
$pdf->Output("../tmp/statistika.$kli_uzid.pdf");

//archiv vykazu
$sql = "SELECT psys FROM F$kli_vxcf"."_statistika_opu112arch ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_statistika_opu112arch SELECT * FROM F".$kli_vxcf."_statistika_opu112 ";
$vysledek = mysql_query("$sql");
}
$sql = "DELETE FROM F".$kli_vxcf."_statistika_opu112arch WHERE umex = $kli_vume ";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_statistika_opu112arch SELECT * FROM F".$kli_vxcf."_statistika_opu112 WHERE umex =  $kli_vume ";
$vysledek = mysql_query("$sql");
?>
<script type="text/javascript">
  var okno = window.open("../tmp/statistika.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
//koniec vytlac

$cislista = include("uct_lista_norm.php");
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>