<?php
//tymto sa spusta ponuka z ciselnika sluzieb

session_start(); 
$h5rtgh5 = include("../odpad2010/h5rtgh5.php");

$copern = $_REQUEST['copern'];
$prihl=0;

$ez_kto = $_SESSION['ez_kto'];
$ez_id = $_SESSION['ez_id'];
$prihl= $_SESSION['prihl'];
?>

<HTML>
<?php
       do
       {
if ( $copern !== 99 )
{

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}
if ( $_SERVER['SERVER_NAME'] == "www.ala.sk" ) { mysql_query("SET NAMES cp1250"); }
$citwebs = include("../funkcie/citaj_webs.php");

// cislo operacie
$copern = $_REQUEST['copern'];
$page = $_REQUEST['page'];
$ponuka = $_REQUEST['ponuka'];
$cislo_slu = $_REQUEST['cislo_slu'];
if(!isset($copern)) $copern = 1;
if(!isset($page)) $page = 1;
if(!isset($ponuka)) $ponuka = 3;
$firxy=$webs_fir;
if(!isset($firxy)) $firxy = 53;
$adrdok = "asluzby";
$bdrdok = "bsluzby";
$cdrdok = "csluzby";
$ddrdok = "dsluzby";
//echo 'cislo'.$cislo_slu;
//echo 'coper'.$copern;
$cennik = 1*$_SESSION['ez_ccen'];;

$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR$firxy/"."autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

$sqlfir = "SELECT * FROM F$firxy"."_ufir WHERE udaje = 1";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$mena1 = $fir_riadok->mena1;
$mena2 = $fir_riadok->mena2;
$kurz12 = $fir_riadok->kurz12;
$fir_fem3 = $fir_riadok->fem3;

mysql_free_result($fir_vysledok);

if ( $copern == 33 ) 
{
$copern = 1;
}

//ponuka 1=sluzby z faktur,2=dopravne sluzby,3=tovar zo skladu
if ( $ponuka == 1 ) 
{
$tablsluzby = sluzby;
}
if( $ponuka == 2 ) 
{
$tablsluzby = dopsluzby;
$adrdok = "adsluzby";
$bdrdok = "bdsluzby";
$cdrdok = "cdsluzby";
$ddrdok = "ddsluzby";
}
if( $ponuka == 3 ) 
{
$tablsluzby = sklcis;
$adrdok = "amaterial";
$bdrdok = "bmaterial";
$cdrdok = "cmaterial";
$ddrdok = "dmaterial";
}

$hlad_kat01h = strip_tags($_REQUEST['hlad_kat01h']);
$hlad_kat02h = strip_tags($_REQUEST['hlad_kat02h']);
$hlad_kat03h = strip_tags($_REQUEST['hlad_kat03h']);
$hlad_kat04h = strip_tags($_REQUEST['hlad_kat04h']);
$hlad_txt = strip_tags($_REQUEST['hlad_txt']);
$hladanie = 0;
if( $copern == 9 ) 
{
$hladanie = 1;
//$copern = 1;

//echo 'kat1'.$hlad_kat01h;
//echo 'kat2'.$hlad_kat02h;
//echo 'kat3'.$hlad_kat03h;
//echo 'kat4'.$hlad_kat04h;
}


$sql = "SELECT * FROM F$firxy"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
//echo "robim sklzaspriemer";

$sqlt = <<<sklzas
(
   prx         INT,
   skl         INT,
   cis         DECIMAL(15,0),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hop         DECIMAL(10,2)
);
sklzas;

$sql = 'CREATE TABLE F'.$firxy.'_sklzaspriemer'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$firxy"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,zas,(cen*zas) ".
" FROM F$firxy"."_sklzas ".
" WHERE cis >= 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$firxy"."_sklzaspriemer ".
" SELECT 1,skl,cis,MAX(cen),SUM(zas),SUM(hop) ".
" FROM F$firxy"."_sklzaspriemer ".
" WHERE cis >= 0 GROUP by skl,cis";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$firxy"."_sklzaspriemer WHERE prx = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$firxy"."_sklzaspriemer SET cen=hop/zas WHERE zas > 0 AND hop > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$firxy"."_sklzaspriemer SET cen=hop/zas WHERE zas < 0 AND hop < 0";
$dsql = mysql_query("$dsqlt");
     }

//ake css
$akecss="styl_eshop_blue.css";
if( $webs_text5 == "fialové" ) { $akecss="styl_eshop_magenta.css"; }
if( $webs_text5 == "èierne" ) { $akecss="styl_eshop_black.css"; }
if( $webs_text5 == "hnedé" ) { $akecss="styl_eshop_brown.css"; }
if( $webs_text5 == "tmavoružové" ) { $akecss="styl_eshop_darkpink.css"; }
if( $webs_text5 == "olivovozelené" ) { $akecss="styl_eshop_olive.css"; }
if( $webs_text5 == "šedé" ) { $akecss="styl_eshop_grey.css"; }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link rel="stylesheet" href="../css/<?php echo $akecss; ?>" type="text/css">
<title>EuroSecom Eshop - Produkt info</title>

<script type="text/javascript">

    function ObnovUI()
    {

    }


    function nakupnykosik()
    {

window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&html=1',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
   
    }

</script>
<?php
if ( $prihl == 1 )
{
?>
<script type="text/javascript" src="dokosika.js"></script>
<?php
}
?>

</HEAD>
<BODY onload="ObnovUI();" >

<?php 
if( $copern == 1 OR $copern == 44 OR $copern == 9 )
{

// pocet poloziek na stranu
$pols = 5;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

if( $ponuka == 1 OR $ponuka == 2 )
{
if( $copern == 1 AND $hladanie != 1 ) $sql = mysql_query("SELECT * FROM F$firxy"."_$tablsluzby WHERE ( tl1 = 1 ) ORDER BY slu");
if( $copern == 44 ) $sql = mysql_query("SELECT * FROM F$firxy"."_$tablsluzby WHERE slu = $cislo_slu ");
}

if( $ponuka == 3 )
{
if( $copern == 1 AND $hladanie != 1 )
     {
$sqlt = "SELECT cis AS slu, nat AS nsl,mer,cep,ced,tl1,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2".
" FROM F$firxy"."_$tablsluzby WHERE ( tl1 = 1 ) ORDER BY cis";
$sql = mysql_query("$sqlt");
//echo $sqlt;
     }
if( $copern == 44 )
     {
$sqlt = "SELECT cis AS slu, nat AS nsl,mer,cep,ced,tl1,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2".
" FROM F$firxy"."_$tablsluzby WHERE cis = $cislo_slu";
$sql = mysql_query("$sqlt");
     }
//exit;
}

if( $hladanie == 1 ) 
{
$podm="";
if( $hlad_kat01h != 00 ) $podm = " AND kat01h = '".$hlad_kat01h."'";
if( $hlad_kat02h != 00 ) $podm = $podm." AND kat02h = '".$hlad_kat02h."'";
if( $hlad_kat03h != 00 ) $podm = $podm." AND kat03h = '".$hlad_kat03h."'";
if( $hlad_kat04h != 00 ) $podm = $podm." AND kat04h = '".$hlad_kat04h."'";

//echo $podm;
if( $ponuka == 1 OR $ponuka == 2 )
{
$sqlhh = "SELECT * FROM F$firxy"."_$tablsluzby WHERE tl1 = 1 ".$podm." ORDER BY slu";
}
if( $ponuka == 3 )
{
if( $hlad_kat01h != 00 ) $podm = " AND xdr2 = '".$hlad_kat01h."'";
if( $hlad_txt != '' ) $podm = " AND nat LIKE '%".$hlad_txt."%'";

$sqlhh = "SELECT cis AS slu, nat AS nsl,mer,cep,ced,tl1,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,xdr2".
" FROM F$firxy"."_$tablsluzby ".
" LEFT JOIN F$firxy"."_sklcisudaje".
" ON F$firxy"."_$tablsluzby.cis=F$firxy"."_sklcisudaje.xcis".
" WHERE tl1 = 1 ".$podm." ORDER BY cis";

}

//echo $sqlhh;
$sql = mysql_query("$sqlhh");
}
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
// nasledujuca strana
$npage =  $page + 1;
if( $npage > $xstr ) $npage=$xstr;
// predchadzajuca strana
$ppage =  $page - 1;
if( $ppage < 1 ) $ppage=1;

}
?>

<div id="wrap-header">
<div id="header">

<?php
if( $copern == 1 OR $copern == 9 OR $copern == 44 )
{
?>
<FORM name="formcn" method="post" action="#">
<table>
<tr>
<td width="50%" height="50"></td>
<td width="20%" height="50" align="right"></td>
<?php
if( $prihl == 1 )
{
?>
<td width="30%" valign="top" align="right" height="40">
<div class="logged" style="top:2px; width:314px; border-bottom:none;" >

<?php
if( $_SESSION['ez_id'] < 999990000 )
 {
?>
<img src="../obr/eshop/prihlaseny.png" title="Prihlásený" height="12" width="12">&nbsp;&nbsp;<?php echo "$ez_kto";?>
<?php
 }
?>
</div>

<div class="kosik-area1">
<div class="kosik-info1" id="myKosikdiv"></div>
<img src='../obr/eshop/kosik.png' onclick="nakupnykosik();" width=90 height=30 title="Nákupný košík" class="kosik">
</div>
<?php
}
?>

</td>
</tr>
</table>
</FORM>
<?php
}
?>

</div>
</div>

<div id="wrap-content">
<div id="content">

<?php
if( $copern == 44 )
{
?>

<FORM name="formks" method="post" action="#">
<table>

<?php
  while ($i <= $konc )
  {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
$riadok=mysql_fetch_object($sql);
  if ($riadok->slu != 0 )
       {
$code_nsl = URLEncode($riadok->nsl);
$code_mer = URLEncode($riadok->mer);
?>
<div class="infotov-header"><?php echo $riadok->nsl;?></div>
<?php


if( $prihl >= 0 )
{
$zasoba=0;
$sqldok = mysql_query("SELECT SUM(zas) AS zasoba FROM F$firxy"."_sklzaspriemer WHERE cis = $riadok->slu ");
   if (@$zaznam=mysql_data_seek($sqldok,0))
   {
   $riaddok=mysql_fetch_object($sqldok);
   $zasoba=1*$riaddok->zasoba;
   }

$cislotov=1*$riadok->slu;
$sumaobj=0;
$sqlfir = "SELECT SUM(xmno) AS xmnos FROM F$firxy"."_kosikobj WHERE xfak = 0 AND xcis = $cislotov ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$sumaobj = 1*$fir_riadok->xmnos; 
$zasoba=1*($zasoba-$sumaobj);

if( $autoreg == 1 AND $zasoba <= 0 ) { $zasoba=10; }

$cenap=$riadok->cep;
$cenad=$riadok->ced;

if( $cennik > 0 ) 
    {
$sqlttts = "SELECT * FROM F$firxy"."_sklcisudaje WHERE xcis = $cislotov ";
//echo $sqlttts;
$sqldoks = mysql_query("$sqlttts");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddoks=mysql_fetch_object($sqldoks);
  if( $cennik == 1 ) { $cenap=1*$riaddoks->cep01; $cenad=1*$riaddoks->ced01; }
  if( $cennik == 2 ) { $cenap=1*$riaddoks->cep02; $cenad=1*$riaddoks->ced02; }
  if( $cennik == 3 ) { $cenap=1*$riaddoks->cep03; $cenad=1*$riaddoks->ced03; }
  if( $cennik == 4 ) { $cenap=1*$riaddoks->cep04; $cenad=1*$riaddoks->ced04; }
  }
    }
$cenap=sprintf("%0.2f", $cenap);
$cenad=sprintf("%0.2f", $cenad);
}
if( $prihl == 0 ) { $zasoba=0; }
?>

<table width="60%" class="infotov">
<tr>
<td width="14%"></td><td width="13%"></td><td width="13%"></td><td width="25%"></td><td width="35%"></td>
</tr>
<tr height="25px">
<td valign="top">&nbsp;<span class="tov-def">Kód</span>&nbsp;<span class="tov-value"><?php echo $riadok->slu;?></span></td>
<td align="right"><span class="tov-def">Cena bez DPH</span></td>
<td align="right">
<?php
if( $prihl == 0 ) { $zasoba=0; }  
{
?>
<span class="tov-value"><?php echo $cenap;?></span>
<?php
}
?>
</td>
<td valign="top" align="center" ><span class="tov-def">Zásoba</span>&nbsp;
<?php
if ( $prihl == 1 )  
{
?>
<span class="tov-value"><?php echo $zasoba;?>&nbsp;<?php echo $riadok->mer;?></span>
<?php
}
?>
</td>
<td class="podkos" rowspan="3" align="center" valign="top">
<?php
if ( $prihl == 1 )  
{
?>
<input type="number" style="width:60px;" name="ks<?php echo $i;?>" id="ks<?php echo $i;?>" value="1" class="tov-mnovkosiku">&nbsp;<span style="vertical-align:middle;"><?php echo $riadok->mer;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
<div class="button-dokosika" id="dokosa0">
<img src='../obr/eshop/dokosika_button_big.png' onclick="vlozdokosika(<?php echo $riadok->slu;?>,<?php echo $i;?>,<?php echo $cenap;?>,<?php echo $cenad;?>);" width=120 height=36 title="Pridaj do košíka" class="tov-dokosika" >
</div>
<?php
}
?>
</td>
</tr>
<tr>
<td></td>
<td align="right"><span class="tov-def">s DPH</span></td>
<td align="right">
<?php
if( $prihl == 0 ) { $zasoba=0; }  
{
?>
<span style="color:#FFF; background-color:#12B473; font-weight:bold; padding:2px;"><?php echo $cenad;?></span>
</td>
<?php
}
?>
<td colspan="1"></td>
</tr>
<tr height="15px">
<td colspan="4"></td>
</tr>
</table>

<table>
<tr>
<td width="70%">
<table class="prmprodukt">
<caption class="prmprodk"><span class="prmprodukt" >Parametre produktu</span></caption>
<tr height="8">
<td class="cwhite" width="25%"></td><td class="cwhite" width="25%"></td><td class="cwhite" width="25%"></td><td class="cwhite" width="25%"></td>
</tr>
<tr height="25px">
<td colspan="2">&nbsp;<span class="tov-def"><?php echo $webs_labp1;?>:</span>&nbsp;<span class="tov-value" ><?php echo $riadok->labh1;?></span></td>
<td colspan="2"><span class="tov-def"><?php echo $webs_labp2;?>:</span>&nbsp;<span class="tov-value" ><?php echo $riadok->labh2;?></span></td>
</tr>
<tr height="10px">
<td colspan="4"></td>
</tr>
<tr>
<td colspan="1" align="center"><span class="tov-def"><?php echo $webs_kat01p;?></span></td>
<td colspan="1" align="center"><span class="tov-def"><?php echo $webs_kat02p;?></span></td>
<td colspan="1" align="center"><span class="tov-def"><?php echo $webs_kat03p;?></span></td>
<td colspan="1" align="center"><span class="tov-def"><?php echo $webs_kat04pno;?></span></td>
</tr>
<tr height="18px">
<td colspan="1" align="center" class="tov-value" style="padding-bottom:8px;" >
<?php if( $riadok->kat01h == 1 ) echo $webs_kat01h01; ?>
<?php if( $riadok->kat01h == 2 ) echo $webs_kat01h02; ?>
<?php if( $riadok->kat01h == 3 ) echo $webs_kat01h03; ?>
<?php if( $riadok->kat01h == 4 ) echo $webs_kat01h04; ?>
<?php if( $riadok->kat01h == 5 ) echo $webs_kat01h05; ?>
<?php if( $riadok->kat01h == 6 ) echo $webs_kat01h06; ?>
<?php if( $riadok->kat01h == 7 ) echo $webs_kat01h07; ?>
<?php if( $riadok->kat01h == 8 ) echo $webs_kat01h08; ?>
<?php if( $riadok->kat01h == 9 ) echo $webs_kat01h09; ?>
<?php if( $riadok->kat01h == 10 ) echo $webs_kat01h10; ?>
</td>
<td colspan="1" align="center" class="tov-value" style="padding-bottom:8px;">
<?php if( $riadok->kat02h == 1 ) echo $webs_kat02h01; ?>
<?php if( $riadok->kat02h == 2 ) echo $webs_kat02h02; ?>
<?php if( $riadok->kat02h == 3 ) echo $webs_kat02h03; ?>
<?php if( $riadok->kat02h == 4 ) echo $webs_kat02h04; ?>
<?php if( $riadok->kat02h == 5 ) echo $webs_kat02h05; ?>
<?php if( $riadok->kat02h == 6 ) echo $webs_kat02h06; ?>
<?php if( $riadok->kat02h == 7 ) echo $webs_kat02h07; ?>
<?php if( $riadok->kat02h == 8 ) echo $webs_kat02h08; ?>
<?php if( $riadok->kat02h == 9 ) echo $webs_kat02h09; ?>
<?php if( $riadok->kat02h == 10 ) echo $webs_kat02h10; ?>
</td>
<td colspan="1" align="center" class="tov-value" style="padding-bottom:8px;">
<?php if( $riadok->kat03h == 1 ) echo $webs_kat03h01; ?>
<?php if( $riadok->kat03h == 2 ) echo $webs_kat03h02; ?>
<?php if( $riadok->kat03h == 3 ) echo $webs_kat03h03; ?>
<?php if( $riadok->kat03h == 4 ) echo $webs_kat03h04; ?>
<?php if( $riadok->kat03h == 5 ) echo $webs_kat03h05; ?>
<?php if( $riadok->kat03h == 6 ) echo $webs_kat03h06; ?>
<?php if( $riadok->kat03h == 7 ) echo $webs_kat03h07; ?>
<?php if( $riadok->kat03h == 8 ) echo $webs_kat03h08; ?>
<?php if( $riadok->kat03h == 9 ) echo $webs_kat03h09; ?>
<?php if( $riadok->kat03h == 10 ) echo $webs_kat03h10; ?>
</td>
<td colspan="1" align="center" class="tov-value" style="padding-bottom:8px;">
<?php if( $riadok->kat04h == 1 ) echo $webs_kat04h01no; ?>
<?php if( $riadok->kat04h == 2 ) echo $webs_kat04h02no; ?>
<?php if( $riadok->kat04h == 3 ) echo $webs_kat04h03no; ?>
<?php if( $riadok->kat04h == 4 ) echo $webs_kat04h04no; ?>
<?php if( $riadok->kat04h == 5 ) echo $webs_kat04h05no; ?>
<?php if( $riadok->kat04h == 6 ) echo $webs_kat04h06no; ?>
<?php if( $riadok->kat04h == 7 ) echo $webs_kat04h07no; ?>
<?php if( $riadok->kat04h == 8 ) echo $webs_kat04h08no; ?>
<?php if( $riadok->kat04h == 9 ) echo $webs_kat04h09no; ?>
<?php if( $riadok->kat04h == 10 ) echo $webs_kat04h10no; ?>
</td>
</tr>
</table>
</td>

<td rowspan="2" valign="top" width="30%">
<table class="imgprodukt">
<tr>
<td align="center">
<?php
$fotonavysku=1*$riadok->kat04h;
$fotovyska=100;
$fotosirka=150;
if( $webs_obr2s > 0 ) { $fotosirka=$webs_obr2s; }
if( $webs_obr2v > 0 ) { $fotovyska=$webs_obr2v; }

if( $fotonavysku == 1 ) 
{
$fotovyska=150; 
$fotosirka=100; 
if( $webs_obr2v > 0 ) { $fotosirka=$webs_obr2v; }
if( $webs_obr2s > 0 ) { $fotovyska=$webs_obr2s; }
}

//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/a<?php echo $tablsluzby;?>/d<?php echo $riadok->slu;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/a<?php echo $tablsluzby;?>/d<?php echo $riadok->slu;?>.pdf' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.jpg' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>

<?php
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.png' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.png' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>

<?php
if ( $jesub == 0 )  
{
$outfilex="../dokumenty/FIR".$firxy."/".$adrdok."/d".$riadok->slu."_*.*";
$iout=0;
foreach (glob("$outfilex") as $filename) {
//unlink($filename);
//echo $filename;
if( $iout == 0 )
    {
$jesub=1;
?>
<a href='<?php echo $filename;?>' target="_blank">
<img src='<?php echo $filename;?>' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
    }
$iout=$iout+1;
         }
} 
?>

<br>

<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.pdf' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$bdrdok/d$riadok->slu.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.jpg' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$bdrdok/d$riadok->slu.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.png' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $bdrdok;?>/d<?php echo $riadok->slu;?>.png' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>

<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$firxy/$cdrdok/d$riadok->slu.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.pdf' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$cdrdok/d$riadok->slu.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.jpg' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$cdrdok/d$riadok->slu.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.png' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $cdrdok;?>/d<?php echo $riadok->slu;?>.png' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>

<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.pdf' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.jpg' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.png' target="_blank">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.png' width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Väèší obrázok"></a>
<?php
} 
?>

</td>
</tr>
</table>
</td>
</tr>

<tr>
<td width="70%">
<div class="popprodukt-head"><span class="popprodh">Popis produktu</span></div>
<div>
<a href="
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.avi"))  
{
?>
../dokumenty/FIR<?php echo $firxy;?>/<?php echo $ddrdok;?>/d<?php echo $riadok->slu;?>.avi
<?php
} 
?>
<?php
if (!File_Exists ("../dokumenty/FIR$firxy/$ddrdok/d$riadok->slu.avi"))  
{
?>
#
<?php
} 
?>
" class="video"><img src="../obr/eshop/viewvideo_button.png" title="Videoukážka produktu" height="35" width="35"></a>
</div>
<div class="popprodukt-text">
<textarea rows="15" cols="65" readonly="readonly"><?php echo $riadok->webtx2; ?></textarea>
</div>
</td>
</tr>
</table>

<?php
       }
    }
$i = $i + 1;
  }
?>
</table>
</FORM>
<?php
}
?>

</div>
</div>

<?php
// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
