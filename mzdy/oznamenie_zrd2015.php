<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'MZD';
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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

$cislo_xplat = 1*$_REQUEST['cislo_xplat'];

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$zaobdobie=1;
if ( $kli_vume > 3 ) { $zaobdobie=2; }
if ( $kli_vume > 6 ) { $zaobdobie=3; }
if ( $kli_vume > 9 ) { $zaobdobie=4; }



$sql = "SELECT odvodx7 FROM F$kli_vxcf"."_mzdoznameniezrd ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdoznameniezrd';
$vytvor = mysql_query("$vsql");

$sqltv = <<<trexima
(
   cpl          int not null auto_increment,
   xplat        DECIMAL(10,0) DEFAULT 0,
   datd         DATE NOT NULL,
   xico         DECIMAL(10,0) DEFAULT 0,
   prj          DECIMAL(10,2) DEFAULT 0,
   zrd          DECIMAL(10,2) DEFAULT 0,
   datum        DATE NOT NULL,
   odvodx7      DECIMAL(13,6) DEFAULT 0,
   odvod        DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);  
trexima;
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdoznameniezrd'.$sqltv;
$vytvor = mysql_query("$vsql");
}

//cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$cislo_xplat = 1*$_REQUEST['cislo_xplat'];
$h_oprav = 1*$_REQUEST['h_oprav'];


//vlozit polozku
if ( $copern == 801 )
     {
$cislo_xplat = 1*$_REQUEST['cislo_xplat'];
$xico = strip_tags($_REQUEST['xico']);

$prj = 1*strip_tags($_REQUEST['prj']);
$datd = strip_tags($_REQUEST['datd']);
$datum = strip_tags($_REQUEST['datum']);
$datd_sql=SqlDatum($datd);
$datum_sql=SqlDatum($datum);


$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdoznameniezrd (xplat,xico,datd,prj) VALUES ('$cislo_xplat', '$xico', '$datum_sql', '$prj' )";
if ( $xico > 0 ) { $upravene = mysql_query("$uprtxt"); }

$uprav="NO";
$copern=101;
     }
//koniec vlozit polozku


//zmazat polozku
if ( $copern == 502 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdoznameniezrd WHERE cpl = $cislo_cpl ";
$upravene = mysql_query("$uprtxt");  
$copern=101;
     }
//koniec zmazat polozku


//nacitaj 
if ( $copern == 101 )
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

mysql_free_result($fir_vysledok);

     }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Oznámenie ZRD</title>
<style type="text/css">
#content { background-color: white; }
div.uvolni-top-submit {
  position: absolute;
  top: 0;
  right: 0;
  width: 108px;
  height: 32px;
  text-align: right;
}
input.btn-top-formsave-noactive {
  width: 100px;
  height: 24px;
  margin-top: 4px;
  margin-right: 4px;
  cursor: pointer;
}
img.logozp {
  position: absolute;
  top: 30px;
  left: 40px;
}
table.poistenci {
  position: absolute;
  top: 792px;
  left: 45px;
  width: 890px;
  font-size: 14px;
}
table.poistenci td {
  height: 26px;
  line-height: 26px;
  border-bottom: 2px solid black; 
  text-align: right;
}
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
img.row-delete {
  position: relative;
  top: 4px;
  width: 18px;
  height: 18px;
}
div.ponuka-box {
  z-index: 1;
  position: absolute;
  left: 20px;
  overflow: auto;
  height: 350px;
  width: 530px;
}
div.ponuka-area {
  width: 508px;
  background-color: lightblue;
}
div.ponuka-area h2 {
  float: left;
  height: 26px;
  line-height: 26px;
  margin-top: 5px;
}
img.skry {
  float: right;
  position: relative;
  top: 4px;
  right: 4px;
  width: 20px;
  height: 20px;
  cursor: pointer;
}
table.ponuka {
  width: 500px;
  margin: 0 auto;
}
table.ponuka th {
  font-size: 11px;
  font-weight: normal;
  height: 16px;
  line-height: 16px;
}
table.ponuka td {
  height: 26px;
  line-height: 26px;
  font-size: 13px;
  background-color: white;
  border: 2px solid lightblue;
}
input.ok-btn {
  position: relative;
  top: 2px;
}
</style>

<script language="JavaScript" src="../js/cookies.js"></script>
<script type="text/javascript">
//preskakovanie ENTER-om

  function DividEnter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kód stlaèenej klávesy
   if ( k == 13 ){
        if ( document.formv1.zaklad.value == '' ) { document.formv1.zaklad.value = document.formv1.divid.value; }
        if ( document.formv1.zaklad.value == '0' ) { document.formv1.zaklad.value = document.formv1.divid.value; }
        if ( document.formv1.zaklad.value > 48300 ) { document.formv1.zaklad.value = 48300; }
        document.forms.formv1.zaklad.focus();
        document.forms.formv1.zaklad.select();
                 }
  }


  function ObnovUI()
  {

   document.formv1.uloz.disabled = true;
   document.formv1.uloz1.disabled = true;
  }

  function VysvetlVypln()
  {
   window.open('../dokumenty/zdravpoist/dividendy_ZPv14_vysvetlivky.pdf', '_blank');
  }

  function TlacVykaz()
  {
   window.open('oznamenie_zrd2015.php?copern=40&cislo_xplat=<?php echo $cislo_xplat; ?>&h_oprav=<?php echo $h_oprav; ?>', '_blank');
  }
  function ZmazRiadok(cpl)
  {
   window.open('oznamenie_zrd2015.php?copern=502&cislo_cpl=' + cpl + '&cislo_xplat=<?php echo $cislo_xplat;?>&drupoh=<?php echo $drupoh;?>&uprav=1', '_self');
  }

  function Povol_uloz()
  {
   var okvstup=1;
   if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
        else { document.formv1.uloz.disabled = true; return (false) ; }
  }
  function Povol_uloz1()
  {
   var okvstup=1;
   if ( okvstup == 1 ) { document.formv1.uloz1.disabled = false; return (true); }
        else { document.formv1.uloz1.disabled = true; return (false) ; }
  }


//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
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
  <td class="header">Oznámenie ZRD</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="VysvetlVypln();" title="Vysvetlivky" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>


<div id="content">
<?php if ( $copern == 101 ) { ?>

<FORM name="formv1" method="post"
 action="oznamenie_zrd2015.php?copern=801&cislo_xplat=<?php echo $cislo_xplat; ?>">
<div id="uvolni" onmouseover="return Povol_uloz();" class="uvolni-top-submit">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny"
  class="btn-top-formsave-noactive">
</div>
<img src="../dokumenty/dan_z_prijmov2015/oznamenie_zrd/oznamenie_o_zrd_str1.jpg" alt="tlaèivo Oznámenie ZRD 15kB" class="form-background">

<!-- ZAHLAVIE -->


<span class="text-echo" style="top:323px; left:142px;"><?php echo $zaobdobie; ?> <?php echo $kli_vrok; ?></span>

<!-- PLATITEL FO vzdy -->
<span class="text-echo" style="top:408px; left:155px;"><?php echo $meno." ".$prie." ".$dar;?></span>

<!-- ADRESA PLATITEL FO vzdy z udajov o zamestnancovi -->
<span class="text-echo" style="top:658px; left:155px;"><?php echo $zuli." ".$zmes;?></span>

<!-- ADRESA ZDRAVOTNICKEHO ZARIADEIA z udajov o firme -->
<span class="text-echo" style="top:758px; left:155px;"><?php echo $fir_fnaz." ".$fir_fmes;?></span>

<!-- PRIJMY dat niekde na spodok stranky tak ako vo forme Zdravotné poistenie z vyplatených dividend -->
<table class="poistenci">
<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_mzdoznameniezrd.xico=F$kli_vxcf"."_ico.ico".
" WHERE xplat = $cislo_xplat ORDER BY cpl";
$sql = mysql_query("$sqltt");
//echo $sqltt;
// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
  while ($i <= $cpol )
  {
if (@$zaznam=mysql_data_seek($sql,$i))
{
$riadok=mysql_fetch_object($sql);
?>
<tr>
 <td style="width:75px; text-align:center;"><?php echo $i+1;?>.</td>
 <td style="width:362px; text-align:left;">&nbsp;<strong><?php echo $riadok->xico;?></strong>
  <?php echo "$riadok->nai $riadok->mes"; ?>
 </td>
 <td style="width:133px;"><?php echo $riadok->datd;?>&nbsp;</td>
 <td style="width:145px;"><?php echo $riadok->prj;?>&nbsp;</td>
 <td style="width:145px;"> &nbsp;</td>
 <th style="width:30px;">
  <img src="../obr/ikony/xmark_lred_icon.png" title="Zmaza riadok"
   onclick="ZmazRiadok(<?php echo $riadok->cpl;?>)" class="row-delete">
 </th>
</tr>
<?php
}
$i = $i + 1;
  }
?>
</table>
<?php
$topx=798+$cpol*28;
$topx0=802+$cpol*28;
$topx1=830+$cpol*28;
$topx2=840+$cpol*28;
?>
<img src="../obr/ikony/searchl_blue_icon.png" onclick="myKVDPH.style.display='';" title="H¾ada držite¾a"
 class="btn-row-tool" style="top:<?php echo $topx0;?>px; left:70px;">
<input type="text" name="xico" id="xico" onkeydown="return OcEnter(event.which)"
 style="width:82px; top:<?php echo $topx;?>px; left:82px;" title="ico drzitela"/>
<input type="text" name="nai" id="nai" readonly="readonly"
 style="width:295px; top:<?php echo $topx;?>px; left:178px;"/>
<input type="text" name="datd" id="datd" title="datum" onkeyup="CiarkaNaBodku(this);"
 onkeydown=""
 style="width:110px; top:<?php echo $topx;?>px; left:490px;"/>
<input type="text" name="prj" id="prj" title="vyska prijmu" onkeyup="CiarkaNaBodku(this);"
 onkeydown=""
 style="width:120px; top:<?php echo $topx;?>px; left:625px;"/>

<div id="uvolni1" onmouseover="return Povol_uloz1();"
 style="position:absolute; right:44px; top:<?php echo $topx1;?>px;">
 <INPUT type="submit" id="uloz1" name="uloz1" value="Uloži" onmouseover="return Povol_uloz1();">
</div>
</FORM>
<div id="myKVDPH" class="ponuka-box" style="top:<?php echo $topx2;?>px;"></div>

<?php                       }
//koniec copern == 101
?>
</div> <!-- koniec #content -->


<?php
///////////////////////////////////////////////////VYTLAC VYKAZ
if ( $copern == 40 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if ( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

if ( File_Exists ("../tmp/d590s.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/d590s.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//nacitanie cisla platitela
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_xplat ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznameniezrd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl >= 0 AND xplat = $cislo_xplat ";
//echo $sqltt;
//exit;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//za obdobie
$pole = explode(".", $hlavicka->ume);
if ( $pole[0] < 10 ) { $pole[0]="0".$pole[0]; }
$zaobdobie=$pole[1].$pole[0];

//druh vykazu
$h_oprav = 1*$_REQUEST['h_oprav'];
$druh="N";
if ( $h_oprav == 1  ) { $druh="O"; }
if ( $h_oprav == 2  ) { $druh="A"; }

$sdiv=0; $szak=0; $sodv=0;
$sqldoks = mysql_query("SELECT SUM(divid) AS sdiv, SUM(zaklad) AS szak, SUM(odvod) AS sodv FROM F$kli_vxcf"."_mzdoznameniezrd WHERE xplat = $cislo_xplat GROUP BY xplat");
  if (@$zaznam=mysql_data_seek($sqldoks,0))
  {
  $riaddok=mysql_fetch_object($sqldoks);
  $sdiv=$riaddok->sdiv;
  $szak=$riaddok->szak;
  $sodv=$riaddok->sodv;
  }

///////////////////////////////////////////VSEOBECNA ZP
if ( $cislo_xplat >= 2500 AND $cislo_xplat <= 2599 ) {
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/zdravpoist/zp2508/dividendy_vszpv14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/zp2508/dividendy_vszpv14.jpg',0,0,210,297);
}

//kod poistovne
$pdf->Cell(190,2," ","$rmc1",1,"L");
$text=substr($cislo_xplat,2,2);
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(178,6," ","$rmc1",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",1,"C");

//cislo platitela
$pdf->Cell(190,14," ","$rmc1",1,"L");
$text=$platitel;
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
$pdf->Cell(146,6," ","$rmc1",0,"R");
$pdf->Cell(4,4,"$A","$rmc",0,"C");$pdf->Cell(4,4,"$B","$rmc",0,"C");$pdf->Cell(4,4,"$C","$rmc",0,"C");$pdf->Cell(4,4,"$D","$rmc",0,"C");
$pdf->Cell(4,4,"$E","$rmc",0,"C");$pdf->Cell(4,4,"$F","$rmc",0,"C");$pdf->Cell(4,4,"$G","$rmc",0,"C");$pdf->Cell(4,4,"$H","$rmc",0,"C");
$pdf->Cell(4,4,"$I","$rmc",0,"C");$pdf->Cell(5,4,"$J","$rmc",1,"C");

//druh vykazu
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(181,6," ","$rmc1",0,"R");$pdf->Cell(6,6,"$druh","$rmc",1,"C");

//Za obdobie
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(20,6," ","$rmc1",0,"R");$pdf->Cell(20,7,"$zaobdobie","$rmc",1,"L");

//PLATITEL
//Obchodne meno
$pdf->Cell(190,6," ","$rmc1",1,"L");
$pdf->Cell(26,6," ","$rmc1",0,"R");$pdf->Cell(160,6,"$fir_fnaz","$rmc",1,"L");
//DIC
$pdf->Cell(190,2," ","$rmc1",1,"L");
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
$pdf->Cell(15,6," ","$rmc1",0,"R");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",0,"C");
$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");
//ICO
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
$pdf->Cell(36,6," ","$rmc1",0,"R");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",1,"C");
//Obec
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(23,6," ","$rmc1",0,"R");$pdf->Cell(82,7,"$fir_fmes","$rmc",0,"L");
//Ulica
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(72,7,"$fir_fuli","$rmc",1,"L");
//Supisne cislo
$pdf->Cell(190,1," ","$rmc1",1,"L");
$pdf->Cell(32,6," ","$rmc1",0,"R");$pdf->Cell(29,6,"$fir_fcdm","$rmc",0,"L");$pdf->Cell(21,6," ","$rmc1",0,"R");$pdf->Cell(23,6," ","$rmc",0,"L");
//PSC
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");
//Stat
$pdf->Cell(13,6," ","$rmc1",0,"R");$pdf->Cell(37,6,"SR","$rmc",1,"L");
//IBAN
$pdf->Cell(190,2," ","$rmc1",1,"L");
$A=substr($fir_fib1,0,1);
$B=substr($fir_fib1,1,1);
$C=substr($fir_fib1,2,1);
$D=substr($fir_fib1,3,1);
$E=substr($fir_fib1,4,1);
$F=substr($fir_fib1,5,1);
$G=substr($fir_fib1,6,1);
$H=substr($fir_fib1,7,1);
$I=substr($fir_fib1,8,1);
$J=substr($fir_fib1,9,1);
$K=substr($fir_fib1,10,1);
$L=substr($fir_fib1,11,1);
$M=substr($fir_fib1,12,1);
$N=substr($fir_fib1,13,1);
$O=substr($fir_fib1,14,1);
$P=substr($fir_fib1,15,1);
$R=substr($fir_fib1,16,1);
$S=substr($fir_fib1,17,1);
$T=substr($fir_fib1,18,1);
$U=substr($fir_fib1,19,1);
$V=substr($fir_fib1,20,1);
$W=substr($fir_fib1,21,1);
$X=substr($fir_fib1,22,1);
$Y=substr($fir_fib1,23,1);
$pdf->Cell(60,6," ","$rmc1",0,"R");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",0,"C");
$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(4,5,"$J","$rmc",0,"C");$pdf->Cell(4,5,"$K","$rmc",0,"C");$pdf->Cell(4,5,"$L","$rmc",0,"C");
$pdf->Cell(4,5,"$M","$rmc",0,"C");$pdf->Cell(4,5,"$N","$rmc",0,"C");$pdf->Cell(5,5,"$O","$rmc",0,"C");$pdf->Cell(4,5,"$P","$rmc",0,"C");
$pdf->Cell(4,5,"$R","$rmc",0,"C");$pdf->Cell(4,5,"$S","$rmc",0,"C");$pdf->Cell(4,5,"$T","$rmc",0,"C");$pdf->Cell(4,5,"$U","$rmc",0,"C");
$pdf->Cell(5,5,"$V","$rmc",0,"C");$pdf->Cell(4,5,"$W","$rmc",0,"C");$pdf->Cell(4,5,"$X","$rmc",0,"C");$pdf->Cell(5,5,"$Y","$rmc",1,"C");

//PREDDAVKY
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(48,6,"$pol","$rmc",1,"R");
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(48,6,"$sdiv","$rmc",1,"R");
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(48,6,"$szak","$rmc",1,"R");
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(48,6,"14%","$rmc",1,"R");
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(48,6,"$sodv","$rmc",1,"R");
$datd=SkDatum($hlavicka->datd);
$pdf->Cell(137,6," ","$rmc1",0,"R");$pdf->Cell(49,6,"$datd","$rmc",1,"C");
//Vyplnil
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"R");$pdf->Cell(34,6,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(28,6,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(33,6,"$fir_ffax","$rmc",0,"L");
$pdf->Cell(10,6," ","$rmc1",0,"R");$pdf->Cell(50,6,"$fir_fem1","$rmc",1,"L");

//POISTENEC 1
$pdf->Cell(190,16," ","$rmc1",1,"L");
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznameniezrd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl >= 0 AND xplat = $cislo_xplat ORDER BY F$kli_vxcf"."_mzdoznameniezrd.oc";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $divid1=$riaddok->divid;
  $zaklad1=$riaddok->zaklad;
  $odvod1=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc1 $rdk1 $prie1 $meno1","$rmc",0,"L");
$pdf->Cell(30,6,"$divid1","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad1","$rmc",0,"R");$pdf->Cell(30,6,"$odvod1","$rmc",1,"R");

//POISTENEC 2
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $divid2=$riaddok->divid;
  $zaklad2=$riaddok->zaklad;
  $odvod2=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc2 $rdk2 $prie2 $meno2","$rmc",0,"L");
$pdf->Cell(30,6,"$divid2","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad2","$rmc",0,"R");$pdf->Cell(30,6,"$odvod2","$rmc",1,"R");

//POISTENEC 3
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $divid3=$riaddok->divid;
  $zaklad3=$riaddok->zaklad;
  $odvod3=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc3 $rdk3 $prie3 $meno3","$rmc",0,"L");
$pdf->Cell(30,6,"$divid3","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad3","$rmc",0,"R");$pdf->Cell(30,6,"$odvod3","$rmc",1,"R");

//POISTENEC 4
  if (@$zaznam=mysql_data_seek($sqldok,3))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie4=$riaddok->prie;
  $meno4=$riaddok->meno;
  $rdc4=$riaddok->rdc;
  $rdk4=$riaddok->rdk;
  $divid4=$riaddok->divid;
  $zaklad4=$riaddok->zaklad;
  $odvod4=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc4 $rdk4 $prie4 $meno4","$rmc",0,"L");
$pdf->Cell(30,6,"$divid4","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad4","$rmc",0,"R");$pdf->Cell(30,6,"$odvod4","$rmc",1,"R");

//POISTENEC 5
  if (@$zaznam=mysql_data_seek($sqldok,4))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie5=$riaddok->prie;
  $meno5=$riaddok->meno;
  $rdc5=$riaddok->rdc;
  $rdk5=$riaddok->rdk;
  $divid5=$riaddok->divid;
  $zaklad5=$riaddok->zaklad;
  $odvod5=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc5 $rdk5 $prie5 $meno5","$rmc",0,"L");
$pdf->Cell(30,6,"$divid5","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad5","$rmc",0,"R");$pdf->Cell(30,6,"$odvod5","$rmc",1,"R");

//POISTENEC 6
  if (@$zaznam=mysql_data_seek($sqldok,5))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie6=$riaddok->prie;
  $meno6=$riaddok->meno;
  $rdc6=$riaddok->rdc;
  $rdk6=$riaddok->rdk;
  $divid6=$riaddok->divid;
  $zaklad6=$riaddok->zaklad;
  $odvod6=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc6 $rdk6 $prie6 $meno6","$rmc",0,"L");
$pdf->Cell(30,6,"$divid6","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad6","$rmc",0,"R");$pdf->Cell(30,6,"$odvod6","$rmc",1,"R");

//POISTENEC 7
  if (@$zaznam=mysql_data_seek($sqldok,6))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie7=$riaddok->prie;
  $meno7=$riaddok->meno;
  $rdc7=$riaddok->rdc;
  $rdk7=$riaddok->rdk;
  $divid7=$riaddok->divid;
  $zaklad7=$riaddok->zaklad;
  $odvod7=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc7 $rdk7 $prie7 $meno7","$rmc",0,"L");
$pdf->Cell(30,6,"$divid7","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad7","$rmc",0,"R");$pdf->Cell(30,6,"$odvod7","$rmc",1,"R");

//POISTENEC 8
  if (@$zaznam=mysql_data_seek($sqldok,7))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie8=$riaddok->prie;
  $meno8=$riaddok->meno;
  $rdc8=$riaddok->rdc;
  $rdk8=$riaddok->rdk;
  $divid8=$riaddok->divid;
  $zaklad8=$riaddok->zaklad;
  $odvod8=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,7,"$rdc8 $rdk8 $prie8 $meno8","$rmc",0,"L");
$pdf->Cell(30,7,"$divid8","$rmc",0,"R");$pdf->Cell(30,7,"$zaklad8","$rmc",0,"R");$pdf->Cell(30,7,"$odvod8","$rmc",1,"R");

//POISTENEC 9
  if (@$zaznam=mysql_data_seek($sqldok,8))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie9=$riaddok->prie;
  $meno9=$riaddok->meno;
  $rdc9=$riaddok->rdc;
  $rdk9=$riaddok->rdk;
  $divid9=$riaddok->divid;
  $zaklad9=$riaddok->zaklad;
  $odvod9=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc9 $rdk9 $prie9 $meno9","$rmc",0,"L");
$pdf->Cell(30,6,"$divid9","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad9","$rmc",0,"R");$pdf->Cell(30,6,"$odvod9","$rmc",1,"R");

//POISTENEC 10
  if (@$zaznam=mysql_data_seek($sqldok,9))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie10=$riaddok->prie;
  $meno10=$riaddok->meno;
  $rdc10=$riaddok->rdc;
  $rdk10=$riaddok->rdk;
  $divid10=$riaddok->divid;
  $zaklad10=$riaddok->zaklad;
  $odvod10=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc10 $rdk10 $prie10 $meno10","$rmc",0,"L");
$pdf->Cell(30,6,"$divid10","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad10","$rmc",0,"R");$pdf->Cell(30,6,"$odvod10","$rmc",1,"R");

//POISTENEC 11
  if (@$zaznam=mysql_data_seek($sqldok,10))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie11=$riaddok->prie;
  $meno11=$riaddok->meno;
  $rdc11=$riaddok->rdc;
  $rdk11=$riaddok->rdk;
  $divid11=$riaddok->divid;
  $zaklad11=$riaddok->zaklad;
  $odvod11=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc11 $rdk11 $prie11 $meno11","$rmc",0,"L");
$pdf->Cell(30,6,"$divid11","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad11","$rmc",0,"R");$pdf->Cell(30,6,"$odvod11","$rmc",1,"R");

//POISTENEC 12
  if (@$zaznam=mysql_data_seek($sqldok,11))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie12=$riaddok->prie;
  $meno12=$riaddok->meno;
  $rdc12=$riaddok->rdc;
  $rdk12=$riaddok->rdk;
  $divid12=$riaddok->divid;
  $zaklad12=$riaddok->zaklad;
  $odvod12=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc12 $rdk12 $prie12 $meno12","$rmc",0,"L");
$pdf->Cell(30,6,"$divid12","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad12","$rmc",0,"R");$pdf->Cell(30,6,"$odvod12","$rmc",1,"R");

//POISTENEC 13
  if (@$zaznam=mysql_data_seek($sqldok,12))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie13=$riaddok->prie;
  $meno13=$riaddok->meno;
  $rdc13=$riaddok->rdc;
  $rdk13=$riaddok->rdk;
  $divid13=$riaddok->divid;
  $zaklad13=$riaddok->zaklad;
  $odvod13=$riaddok->odvod;
  }
$pdf->Cell(24,6," ","$rmc1",0,"R");$pdf->Cell(73,6,"$rdc13 $rdk13 $prie13 $meno13","$rmc",0,"L");
$pdf->Cell(30,6,"$divid13","$rmc",0,"R");$pdf->Cell(30,6,"$zaklad13","$rmc",0,"R");$pdf->Cell(30,6,"$odvod13","$rmc",1,"R");

//Datum
$pdf->Cell(190,32," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
$A=substr($datum,0,1);
$B=substr($datum,1,1);
$C=substr($datum,3,1);
$D=substr($datum,4,1);
$E=substr($datum,6,1);
$F=substr($datum,7,1);
$G=substr($datum,8,1);
$H=substr($datum,9,1);
$pdf->Cell(19,6," ","$rmc1",0,"R");
$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(4,5,"$D","$rmc",0,"C");
$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(4,5,"$H","$rmc",1,"C");
     } //koniec j=0
                                                   } //koniec VSEOBECNA ZP

///////////////////////////////////////////DOVERA ZP
if ( $cislo_xplat >= 2400 AND $cislo_xplat <= 2499 ) {
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/zdravpoist/dovera2010/dividendy_doverazpv14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/dovera2010/dividendy_doverazpv14.jpg',0,0,210,297);
}

//kod poistovne
$pdf->Cell(190,0," ","$rmc1",1,"L");
$text=substr($cislo_xplat,2,2);
$A=substr($text,0,1);
$B=substr($text,1,1);
$pdf->Cell(109,6," ","$rmc1",0,"R");$pdf->Cell(5,4,"$A","$rmc",0,"C");$pdf->Cell(5,4,"$B","$rmc",0,"C");

//cislo platitela
$A=substr($platitel,0,1);
$B=substr($platitel,1,1);
$C=substr($platitel,2,1);
$D=substr($platitel,3,1);
$E=substr($platitel,4,1);
$F=substr($platitel,5,1);
$G=substr($platitel,6,1);
$H=substr($platitel,7,1);
$I=substr($platitel,8,1);
$J=substr($platitel,9,1);
$pdf->Cell(22,6," ","$rmc1",0,"R");
$pdf->Cell(5,4,"$A","$rmc",0,"C");$pdf->Cell(5,4,"$B","$rmc",0,"C");$pdf->Cell(5,4,"$C","$rmc",0,"C");$pdf->Cell(5,4,"$D","$rmc",0,"C");
$pdf->Cell(5,4,"$E","$rmc",0,"C");$pdf->Cell(5,4,"$F","$rmc",0,"C");$pdf->Cell(5,4,"$G","$rmc",0,"C");$pdf->Cell(5,4,"$H","$rmc",0,"C");
$pdf->Cell(5,4,"$I","$rmc",0,"C");$pdf->Cell(5,4,"$J","$rmc",1,"C");

//druh vykazu
$pdf->Cell(190,43," ","$rmc1",1,"L");
$pdf->Cell(35,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$druh","$rmc",0,"C");

//Za obdobie
$A=substr($zaobdobie,0,4);
$B=substr($zaobdobie,4,2);
$pdf->Cell(128,6," ","$rmc1",0,"R");$pdf->Cell(23,5,"$A   $B","$rmc",1,"C");

//PLATITEL
//Obchodne meno
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pdf->Cell(32,6," ","$rmc1",0,"R");$pdf->Cell(159,11,"$fir_fnaz","$rmc",1,"L");

//DIC
$pdf->Cell(190,4," ","$rmc1",1,"L");
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
$pdf->Cell(19,6," ","$rmc1",0,"R");
$pdf->Cell(5,5,"0","$rmc",0,"C");$pdf->Cell(5,5,"0","$rmc",0,"C");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(5,5,"$D","$rmc",0,"C");
$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",0,"C");
$pdf->Cell(5,5,"$I","$rmc",0,"C");$pdf->Cell(5,5,"$J","$rmc",0,"C");
//ICO
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
$pdf->Cell(16,6," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(5,5,"$D","$rmc",0,"C");
$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",1,"C");
//Obec
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(90,6.5,"$fir_fmes","$rmc",0,"L");
//Ulica
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(81,6.5,"$fir_fuli","$rmc",1,"L");
//Supisne cislo
$pdf->Cell(190,2.5," ","$rmc1",1,"L");
$pdf->Cell(16,6," ","$rmc1",0,"R");$pdf->Cell(32,6,"$fir_fcdm","$rmc",0,"L");$pdf->Cell(19,6," ","$rmc1",0,"R");$pdf->Cell(32,6," ","$rmc",0,"L");
//PSC
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");
//Stat
$pdf->Cell(10,6," ","$rmc1",0,"R");$pdf->Cell(46,6,"SR","$rmc",1,"L");
//IBAN
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(64,6," ","$rmc1",0,"R");$pdf->Cell(127,5,"$fir_fib1","$rmc",1,"L");

//PREDDAVKY
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(39,5,"$pol","$rmc",1,"R");
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(39,5,"$sdiv","$rmc",1,"R");
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(39,5,"$szak","$rmc",1,"R");
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(39,5," ","$rmc",1,"R");
$pdf->Cell(151,6," ","$rmc1",0,"R");$pdf->Cell(39,5,"$sodv","$rmc",1,"R");
$datd=SkDatum($hlavicka->datd);
$A=substr($datd,0,1);
$B=substr($datd,1,1);
$C=substr($datd,3,1);
$D=substr($datd,4,1);
$E=substr($datd,6,1);
$F=substr($datd,7,1);
$G=substr($datd,8,1);
$H=substr($datd,9,1);
$pdf->Cell(151,6," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(5,5,"$D","$rmc",0,"C");
$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",1,"C");

//POISTENEC 1
$pdf->Cell(190,23," ","$rmc1",1,"L");
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznameniezrd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl >= 0 AND xplat = $cislo_xplat ORDER BY F$kli_vxcf"."_mzdoznameniezrd.oc";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $divid1=$riaddok->divid;
  $zaklad1=$riaddok->zaklad;
  $odvod1=$riaddok->odvod;
  }
$pdf->Cell(17,6,"1.","$rmc",0,"C");
$pdf->Cell(69,6,"$rdc1 $rdk1 $prie1 $meno1","$rmc",0,"L");
$pdf->Cell(35,6,"$divid1","$rmc",0,"R");$pdf->Cell(35,6,"$zaklad1","$rmc",0,"R");$pdf->Cell(35,6,"$odvod1","$rmc",1,"R");

//POISTENEC 2
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $divid2=$riaddok->divid;
  $zaklad2=$riaddok->zaklad;
  $odvod2=$riaddok->odvod;
  }
$pdf->Cell(17,4,"2.","$rmc",0,"C");
$pdf->Cell(69,4,"$rdc2 $rdk2 $prie2 $meno2","$rmc",0,"L");
$pdf->Cell(35,4,"$divid2","$rmc",0,"R");$pdf->Cell(35,4,"$zaklad2","$rmc",0,"R");$pdf->Cell(35,4,"$odvod2","$rmc",1,"R");

//POISTENEC 3
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $divid3=$riaddok->divid;
  $zaklad3=$riaddok->zaklad;
  $odvod3=$riaddok->odvod;
  }
$pdf->Cell(17,6,"3.","$rmc",0,"C");
$pdf->Cell(69,6,"$rdc3 $rdk3 $prie3 $meno3","$rmc",0,"L");
$pdf->Cell(35,6,"$divid3","$rmc",0,"R");$pdf->Cell(35,6,"$zaklad3","$rmc",0,"R");$pdf->Cell(35,6,"$odvod3","$rmc",1,"R");

//Vyplnil
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(10,6," ","$rmc1",0,"R");$pdf->Cell(48,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(20,6," ","$rmc1",0,"R");$pdf->Cell(48,5,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(17,6," ","$rmc1",0,"R");$pdf->Cell(48,5,"$fir_ffax","$rmc",1,"L");
$pdf->Cell(190,4," ","$rmc1",1,"L");
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(117,6,"$fir_fem1","$rmc",1,"L");

//Datum
$pdf->Cell(190,45," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
$A=substr($datum,0,1);
$B=substr($datum,1,1);
$C=substr($datum,3,1);
$D=substr($datum,4,1);
$E=substr($datum,6,1);
$F=substr($datum,7,1);
$G=substr($datum,8,1);
$H=substr($datum,9,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(5,5,"$D","$rmc",0,"C");
$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(5,5,"$H","$rmc",1,"C");
     } //koniec j=0
                                                   } //koniec DOVERA ZP

///////////////////////////////////////////UNION ZP
if ( $cislo_xplat >= 2700 AND $cislo_xplat <= 2799 ) {
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/zdravpoist/zp2708/dividendy_unionzpv14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/zdravpoist/zp2708/dividendy_unionzpv14.jpg',0,0,210,297);
}

//cislo platitela
$pdf->Cell(190,27," ","$rmc1",1,"L");
$text=$platitel;
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
$pdf->Cell(149,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//druh vykazu
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(186,6," ","$rmc1",0,"R");$pdf->Cell(6,6,"$druh","$rmc",1,"C");

//Za obdobie
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(183,6,"$zaobdobie","$rmc",1,"L");

//PLATITEL
//Obchodne meno
$pdf->Cell(190,11," ","$rmc1",1,"L");
$pdf->Cell(14,6," ","$rmc1",0,"R");$pdf->Cell(178,7,"$fir_fnaz","$rmc",1,"L");
//DIC
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(90,7,"$fir_fdic","$rmc",0,"L");
//ICO
$pdf->Cell(4,6," ","$rmc1",0,"R");$pdf->Cell(95,7,"$fir_fico","$rmc",1,"L");
//Obec
$pdf->Cell(10,6," ","$rmc1",0,"R");$pdf->Cell(47,8,"$fir_fmes","$rmc",0,"L");
//Ulica
$pdf->Cell(7,6," ","$rmc1",0,"R");$pdf->Cell(39,8,"$fir_fuli","$rmc",0,"L");
//Supisne cislo
$pdf->Cell(12,6," ","$rmc1",0,"R");$pdf->Cell(77,8,"$fir_fcdm","$rmc",1,"L");
$pdf->Cell(20,6," ","$rmc1",0,"R");$pdf->Cell(37,8," ","$rmc",0,"L");
//PSC
$A=substr($fir_fpsc,0,1);
$B=substr($fir_fpsc,1,1);
$C=substr($fir_fpsc,2,1);
$D=substr($fir_fpsc,3,1);
$E=substr($fir_fpsc,4,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(40,8,"$fir_fpsc","$rmc",0,"L");
//Stat
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(84,8,"SR","$rmc",1,"L");
//IBAN
$pdf->Cell(37,6," ","$rmc1",0,"R");$pdf->Cell(155,11,"$fir_fib1","$rmc",1,"L");

//PREDDAVKY
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(95,8,"$pol","$rmc",1,"R");
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(95,8,"$sdiv","$rmc",1,"R");
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(95,8,"$szak","$rmc",1,"R");
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(95,9,"14%","$rmc",1,"R");
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(95,8,"$sodv","$rmc",1,"R");
$datd=SkDatum($hlavicka->datd);
$pdf->Cell(95,6," ","$rmc1",0,"R");$pdf->Cell(97,8,"$datd","$rmc",1,"C");
//Vyplnil
$pdf->Cell(190,5," ","$rmc1",1,"L");
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(40,10,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(40,10,"$fir_mzdt04","$rmc",0,"L");
$pdf->Cell(5,6," ","$rmc1",0,"R");$pdf->Cell(44,10,"$fir_ffax","$rmc",0,"L");
$pdf->Cell(8,6," ","$rmc1",0,"R");$pdf->Cell(41,10,"$fir_fem1","$rmc",1,"L");

//POISTENEC 1
$pdf->Cell(190,12," ","$rmc1",1,"L");
$sqldoktt = "SELECT * FROM F$kli_vxcf"."_mzdoznameniezrd ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznameniezrd.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl >= 0 AND xplat = $cislo_xplat ORDER BY F$kli_vxcf"."_mzdoznameniezrd.oc";

$sqldok = mysql_query("$sqldoktt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie1=$riaddok->prie;
  $meno1=$riaddok->meno;
  $rdc1=$riaddok->rdc;
  $rdk1=$riaddok->rdk;
  $divid1=$riaddok->divid;
  $zaklad1=$riaddok->zaklad;
  $odvod1=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,7,"$rdc1 $rdk1 $prie1 $meno1","$rmc",0,"L");
$pdf->Cell(40,7,"$divid1","$rmc",0,"R");$pdf->Cell(40,7,"$zaklad1","$rmc",0,"R");$pdf->Cell(49,7,"$odvod1","$rmc",1,"R");

//POISTENEC 2
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie2=$riaddok->prie;
  $meno2=$riaddok->meno;
  $rdc2=$riaddok->rdc;
  $rdk2=$riaddok->rdk;
  $divid2=$riaddok->divid;
  $zaklad2=$riaddok->zaklad;
  $odvod2=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,7,"$rdc2 $rdk2 $prie2 $meno2","$rmc",0,"L");
$pdf->Cell(40,7,"$divid2","$rmc",0,"R");$pdf->Cell(40,7,"$zaklad2","$rmc",0,"R");$pdf->Cell(49,7,"$odvod2","$rmc",1,"R");

//POISTENEC 3
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie3=$riaddok->prie;
  $meno3=$riaddok->meno;
  $rdc3=$riaddok->rdc;
  $rdk3=$riaddok->rdk;
  $divid3=$riaddok->divid;
  $zaklad3=$riaddok->zaklad;
  $odvod3=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,8,"$rdc3 $rdk3 $prie3 $meno3","$rmc",0,"L");
$pdf->Cell(40,8,"$divid3","$rmc",0,"R");$pdf->Cell(40,8,"$zaklad3","$rmc",0,"R");$pdf->Cell(49,8,"$odvod3","$rmc",1,"R");

//POISTENEC 4
  if (@$zaznam=mysql_data_seek($sqldok,3))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie4=$riaddok->prie;
  $meno4=$riaddok->meno;
  $rdc4=$riaddok->rdc;
  $rdk4=$riaddok->rdk;
  $divid4=$riaddok->divid;
  $zaklad4=$riaddok->zaklad;
  $odvod4=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,8,"$rdc4 $rdk4 $prie4 $meno4","$rmc",0,"L");
$pdf->Cell(40,8,"$divid4","$rmc",0,"R");$pdf->Cell(40,8,"$zaklad4","$rmc",0,"R");$pdf->Cell(49,8,"$odvod4","$rmc",1,"R");

//POISTENEC 5
  if (@$zaznam=mysql_data_seek($sqldok,4))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie5=$riaddok->prie;
  $meno5=$riaddok->meno;
  $rdc5=$riaddok->rdc;
  $rdk5=$riaddok->rdk;
  $divid5=$riaddok->divid;
  $zaklad5=$riaddok->zaklad;
  $odvod5=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,6,"$rdc5 $rdk5 $prie5 $meno5","$rmc",0,"L");
$pdf->Cell(40,6,"$divid5","$rmc",0,"R");$pdf->Cell(40,6,"$zaklad5","$rmc",0,"R");$pdf->Cell(49,6,"$odvod5","$rmc",1,"R");

//POISTENEC 6
  if (@$zaznam=mysql_data_seek($sqldok,5))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie6=$riaddok->prie;
  $meno6=$riaddok->meno;
  $rdc6=$riaddok->rdc;
  $rdk6=$riaddok->rdk;
  $divid6=$riaddok->divid;
  $zaklad6=$riaddok->zaklad;
  $odvod6=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,8,"$rdc6 $rdk6 $prie6 $meno6","$rmc",0,"L");
$pdf->Cell(40,8,"$divid6","$rmc",0,"R");$pdf->Cell(40,8,"$zaklad6","$rmc",0,"R");$pdf->Cell(49,8,"$odvod6","$rmc",1,"R");

//POISTENEC 7
  if (@$zaznam=mysql_data_seek($sqldok,6))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $prie7=$riaddok->prie;
  $meno7=$riaddok->meno;
  $rdc7=$riaddok->rdc;
  $rdk7=$riaddok->rdk;
  $divid7=$riaddok->divid;
  $zaklad7=$riaddok->zaklad;
  $odvod7=$riaddok->odvod;
  }
$pdf->Cell(9,6," ","$rmc1",0,"R");$pdf->Cell(54,7,"$rdc7 $rdk7 $prie7 $meno7","$rmc",0,"L");
$pdf->Cell(40,7,"$divid7","$rmc",0,"R");$pdf->Cell(40,7,"$zaklad7","$rmc",0,"R");$pdf->Cell(49,7,"$odvod7","$rmc",1,"R");

//Datum
$datum=SkDatum($hlavicka->datum);
$pdf->Cell(190,21," ","$rmc1",1,"L");
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(20,4,"$datum","$rmc",1,"L");
     } //koniec j=0
                                                   } //koniec UNION ZP
}
$i = $i + 1;
$j = $j + 1;
  }
$pdf->Output("../tmp/d590s.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/d590s.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
///////////////////////////////////////////////////KONIEC TLAC VYKAZ copern=40
?>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>