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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$sql = "SELECT pcsum FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctpriznanie_dppriloha';
$vytvor = mysql_query("$vsql");

$sqlt = <<<priznaniepo
(
   p1cpl        int not null auto_increment,
   psys         INT DEFAULT 0,
   druh         INT DEFAULT 0,
   p1cis        DECIMAL(4,0) DEFAULT 0,
   pcsum        DECIMAL(10,2) DEFAULT 0,
   p1ico        DECIMAL(10,0) DEFAULT 0,
   p1sid        DECIMAL(4,0) DEFAULT 0,
   p1pfr        VARCHAR(60) NOT NULL,
   p1men        VARCHAR(60) NOT NULL,
   p1uli        VARCHAR(60) NOT NULL,
   p1cdm        VARCHAR(20) NOT NULL,
   p1psc        VARCHAR(10) NOT NULL,
   p1mes        VARCHAR(60) NOT NULL,
   ico          DECIMAL(8,0)  DEFAULT 0,
   PRIMARY KEY(p1cpl)
);
priznaniepo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriznanie_dppriloha'.$sqlt;
$vytvor = mysql_query("$vsql");
}

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$cislo_p1cpl = 1*strip_tags($_REQUEST['cislo_p1cpl']);
$drupoh = 1*$_REQUEST['drupoh'];
$volapo = 1*$_REQUEST['volapo'];

//zapis upravene udaje 
if ( $copern == 202 )
     {
$p1cis = strip_tags($_REQUEST['p1cis']);
$pcsum = strip_tags($_REQUEST['pcsum']);
$p1ico = strip_tags($_REQUEST['p1ico']);
$p1sid = strip_tags($_REQUEST['p1sid']);
$p1pfr = strip_tags($_REQUEST['p1pfr']);
$p1men = strip_tags($_REQUEST['p1men']);
$p1uli = strip_tags($_REQUEST['p1uli']);
$p1cdm = strip_tags($_REQUEST['p1cdm']);
$p1psc = strip_tags($_REQUEST['p1psc']);
$p1mes = strip_tags($_REQUEST['p1mes']);

$uprav="NO";
$uprtxt = "UPDATE F$kli_vxcf"."_uctpriznanie_dppriloha SET ".
" p1cis='$p1cis', pcsum='$pcsum', ".
" p1ico='$p1ico', p1sid='$p1sid', p1pfr='$p1pfr', p1men='$p1men', p1uli='$p1uli', p1cdm='$p1cdm', ".
" p1psc='$p1psc', p1mes='$p1mes' ".
" WHERE p1cpl = $cislo_p1cpl "; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt");
$copern=201;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov 

//nove vozidlo
    if ( $copern == 336 )
    {

$p1cis=1;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cis DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $p1cis=$riaddok->p1cis+1;
 }


$sql = "INSERT INTO F".$kli_vxcf."_uctpriznanie_dppriloha (p1cpl) VALUES ( 0 ) ";
$vysledok = mysql_query($sql);

$cislo_p1cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_p1cpl=$riaddok->p1cpl;
 }


$pcsum = "0.00";
$p1ico = 0;
$p1sid = 0;
$copern=201;

    }
//koniec nove vozidlo

//zmaz vozidlo
    if ( $copern == 206 )
    {
$sql = "DELETE FROM F".$kli_vxcf."_uctpriznanie_dppriloha WHERE p1cpl = $cislo_p1cpl ";
$vysledok = mysql_query($sql);

$copern=101;

    }
//koniec zmz vozidlo


//nacitaj udaje 
if ( $copern == 203 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl = $cislo_p1cpl ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$p1cis = $fir_riadok->p1cis;
$pcsum = $fir_riadok->pcsum;
$p1ico = $fir_riadok->p1ico;
$p1sid = $fir_riadok->p1sid;
$p1pfr = $fir_riadok->p1pfr;
$p1men = $fir_riadok->p1men;
$p1uli = $fir_riadok->p1uli;
$p1cdm = $fir_riadok->p1cdm;
$p1psc = $fir_riadok->p1psc;
$p1mes = $fir_riadok->p1mes;

$copern=201;
                      }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - prÌloha k DP</title>
<style type="text/css">
div.wrap-prijimatelia {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.prijimatelia {
  width: 914px;
  margin: 5px auto;
}
table.prijimatelia caption {
  width: 100%;
  line-height: 40px;
}
table.prijimatelia caption h3 {
  font-size: 16px;
  font-weight: bold;
  text-align: left;
}
table.prijimatelia caption img {
  display: block;
  width: 18px;
  height: 18px;
  margin: 11px 0 0 5px;
  cursor: pointer;
}
table.prijimatelia thead td {
  height: 16px;
  line-height: 16px;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.prijimatelia tbody td {
  height: 30px;
  line-height: 30px;
  border-top: 2px solid #add8e6;
  font-size: 15px;
}
table.prijimatelia tbody img {
  width: 20px;
  height: 20px;
  vertical-align: text-bottom;
  cursor: pointer;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
</style>
<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 2
  if ( $copern == 201 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.p1cis.value = '<?php echo "$p1cis";?>';
   document.formv1.pcsum.value = '<?php echo "$pcsum";?>';
   document.formv1.p1ico.value = '<?php echo "$p1ico";?>';
   document.formv1.p1sid.value = '<?php echo "$p1sid";?>';
   document.formv1.p1pfr.value = '<?php echo "$p1pfr";?>';
   document.formv1.p1men.value = '<?php echo "$p1men";?>';
   document.formv1.p1uli.value = '<?php echo "$p1uli";?>';
   document.formv1.p1cdm.value = '<?php echo "$p1cdm";?>';
   document.formv1.p1psc.value = '<?php echo "$p1psc";?>';
   document.formv1.p1mes.value = '<?php echo "$p1mes";?>';
  }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 201 )
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
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function NovyPrmatel()
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=336&uprav=0&volapo=<?php echo $volapo; ?>', '_self')
  }
  function UpravPrmatel(p1cpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=203&uprav=0&cislo_p1cpl=' + p1cpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }
  function ZmazPrmatel(p1cpl)
  {
   window.open('../ucto/priznanie_dppriloha2015.php?copern=206&uprav=0&cislo_p1cpl=' + p1cpl + '&tt=1&volapo=<?php echo $volapo; ?>', '_self')
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">

<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
<?php if ( $volapo == 0 ) { ?> <td class="header">DaÚ z prÌjmov FOB - prÌloha k IV. Ëasti</td> <?php } ?>
<?php if ( $volapo == 1 ) { ?> <td class="header">DaÚ z prÌjmov PO - prÌloha k IV. Ëasti</td> <?php } ?>
   <td>
    <div class="bar-btn-form-tool"></div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<?php
//zobraz udaje
if ( $copern != 11 )
     {
?>
<FORM name="formv1" method="post" action="priznanie_dppriloha2015.php?copern=202&cislo_p1cpl=<?php echo $cislo_p1cpl; ?>&volapo=<?php echo $volapo; ?>">
<?php
$clas99="active";
$source="../ucto/priznanie_po2015.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0&volapo=".$volapo;
if ( $volapo == 0 ) { $source="../ucto/priznanie_fob2015.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0&volapo=".$volapo; }
?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=11', '_self');" class="<?php echo $clas11; ?> toleft">11</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas99; ?> toleft">prÌloha</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=11&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_blank')" class="<?php echo $clas99; ?> toright">prÌloha</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=11', '_blank');" class="<?php echo $clas11; ?> toright">11</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=10', '_blank');" class="<?php echo $clas10; ?> toright">10</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=9', '_blank');" class="<?php echo $clas9; ?> toright">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=8', '_blank');" class="<?php echo $clas8; ?> toright">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=7', '_blank');" class="<?php echo $clas7; ?> toright">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=6', '_blank');" class="<?php echo $clas6; ?> toright">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=5', '_blank');" class="<?php echo $clas5; ?> toright">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=4', '_blank');" class="<?php echo $clas4; ?> toright">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>

<?php
//VYPIS ZOZNAMU PRIJIMATELOV
if ( $copern == 101 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cpl > 0 ORDER BY p1cis";
$sql = mysql_query("$sqltt");
//echo $sqltt;
//celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
  while ($i <= $cpol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$riadok=mysql_fetch_object($sql);

if ( $i == 0 ) { ?>
<div class="wrap-prijimatelia">
 <table class="prijimatelia">
 <caption>
  <h3 class="toleft">PrÌloha k IV. Ëasti - œalöÌ prijÌmatelia</h3>
  <img src="../obr/ikony/plus_lgreen_icon.png" onclick="NovyPrmatel();"
       title="Pridaù prijÌmateæa" class="toleft">
 </caption>
 <thead>
 <tr>
  <td width="5%" align="center">ËÌslo</td>
  <td width="65%">N·zov - I»O / SID</td>
  <td width="15%" align="right">Suma</td>
  <td width="15%" align="center">&nbsp;</td>
 </tr>
 </thead>
<?php          }
if ( $riadok->p1cpl > 0 ) { ?>
 <tbody>
  <tr>
   <td align="center" style="font-weight:bold;"><?php echo $riadok->p1cis;?></td>
   <td><?php echo $riadok->p1men;?>, <?php echo $riadok->p1mes;?> - <?php echo $riadok->p1ico;?> / <?php echo $riadok->p1sid;?></td>
   <td align="right"><?php echo $riadok->pcsum;?></td>
   <td align="center">
    <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravPrmatel(<?php echo $riadok->p1cpl;?>);" title="Upraviù vozidlo">&nbsp;&nbsp;
    <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazPrmatel(<?php echo $riadok->p1cpl;?>);" title="Vymazaù vozidlo">
   </td>
  </tr>
 </tbody>
<?php
                          }
  }
$i = $i + 1;
  }
?>
 </table>
</div>
<?php
}
//koniec zoznam
?>

<?php
//UPRAVA PRIJIMATELA
if ( $copern == 201 )
{
?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>
<?php if ( $volapo == 0 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg" alt="tlaËivo DaÚ z prÌjmov PO pre rok 2014 12.strana 282kB" class="form-background">
<?php                     } ?>
<?php if ( $volapo == 1 ) { ?>
<img src="../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg" alt="tlaËivo DaÚ z prÌjmov PO pre rok 2014 12.strana 282kB" class="form-background">
<?php                     } ?>
<span class="text-echo" style="top:75px; left:337px;"><?php echo $fir_fdic; ?></span>

<!-- PRILOHA k IV.casti -->
<input type="text" name="p1cis" id="p1cis" style="width:35px; top:154px; left:190px;"/>
<input type="text" name="pcsum" id="pcsum" onkeyup="CiarkaNaBodku(this);" style="width:266px; top:209px; left:161px;"/>

<input type="text" name="p1ico" id="p1ico" style="width:175px; top:264px; left:51px;"/>
<input type="text" name="p1sid" id="p1sid" style="width:82px; top:264px; left:259px;"/>
<input type="text" name="p1pfr" id="p1pfr" style="width:519px; top:264px; left:374px;"/>
<input type="text" name="p1men" id="p1men" style="width:842px; top:316px; left:51px;"/>
<input type="text" name="p1uli" id="p1uli" style="width:635px; top:420px; left:51px;"/>
<input type="text" name="p1cdm" id="p1cdm" style="width:175px; top:420px; left:718px;"/>
<input type="text" name="p1psc" id="p1psc" style="width:107px; top:474px; left:51px;"/>
<input type="text" name="p1mes" id="p1mes" style="width:703px; top:474px; left:190px;"/>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=4', '_self');" class="<?php echo $clas4; ?> toleft">4</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">5</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=6', '_self');" class="<?php echo $clas6; ?> toleft">6</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=7', '_self');" class="<?php echo $clas7; ?> toleft">7</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=8', '_self');" class="<?php echo $clas8; ?> toleft">8</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=9', '_self');" class="<?php echo $clas9; ?> toleft">9</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=10', '_self');" class="<?php echo $clas10; ?> toleft">10</a>
 <a href="#" onclick="window.open('priznanie_dppriloha2015.php?copern=101&drupoh=1&page=1&volapo=<?php echo $volapo; ?>', '_self')" class="<?php echo $clas11; ?> toleft">prÌloha</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</div>
</FORM>
<?php
}
//koniec uprava jedneho
     }
//koniec zobrazenia udajov 
?>
</div> <!-- koniec #content -->

<?php
//zostava PDF
if ( $copern == 11 )
     {
if ( File_Exists("../tmp/dppriloha.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/dppriloha.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac prilohu
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_dppriloha WHERE p1cis > 0 ORDER BY p1cis";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$strana=0;
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$hlavicka=mysql_fetch_object($sql);

if ( $j == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(6);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/dppo2014/dppo_v14_str12.jpg',0,0,210,298);
}
$strana=$strana+1;
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);
$pdf->Cell(67,5," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(3,5,"$B","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",1,"C");
               } //koniec j=0


//suradnice Y 1., 2. a 3. polozky
if ( $j == 0 ) { $pozy=30; }
if ( $j == 1 ) { $pozy=116; }
if ( $j == 2 ) { $pozy=201; }

$pdf->SetY($pozy); 

//PRIJIMATEL
//cislo
$text=sprintf('% 2s',$hlavicka->p1cis);
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(36,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",1,"C");

//suma
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$hodx=100*$hlavicka->pcsum;
if ( $hodx == 0 ) $hodx="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $hodx=""; }
$text=sprintf('% 11s',$hodx);
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
$pdf->Cell(30,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$K","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$hlavicka->p1ico;
if ( $text == 0 ) $text="";
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
if ( $hlavicka->p1ico < 1000000 ) { $text="00".$hlavicka->p1ico; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");

//sid
$text=$hlavicka->p1sid;
if ( $text == 0 ) { $text=""; }
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");

//pravna forma
$text=$hlavicka->p1pfr;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(6,6," ","$rmc1",0,"L");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",1,"C");

//obchodne meno
$pdf->Cell(190,5," ","$rmc1",1,"L");
$text=$hlavicka->p1men;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//ulica
$pdf->Cell(190,18,"                          ","$rmc1",1,"L");
$text=$hlavicka->p1uli;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");

//cislo
$text=$hlavicka->p1cdm;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$F=substr($text,5,1);
$G=substr($text,6,1);
$H=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");

//psc
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text=$hlavicka->p1psc;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
$A=substr($text,0,1);
$B=substr($text,1,1);
$C=substr($text,2,1);
$D=substr($text,3,1);
$E=substr($text,4,1);
$pdf->Cell(5,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");

//obec
$text=$hlavicka->p1mes;
if ( $druh == 3 OR $hlavicka->pzano == 1 ) { $text=""; }
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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$F1","$rmc",1,"C");
  }
$i = $i + 1;
$j = $j + 1;
if ( $j == 3 ) $j=0;
  }


$pdf->Output("../tmp/dppriloha.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/dppriloha.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php

//koniec tlac prilohy copern=11
     }
?>


<?php
//celkovy koniec dokumentu
  } while (false);
?>
</BODY>
</HTML>
