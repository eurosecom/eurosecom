<?PHP
//tymto sa spusta ponuka z ciselnika sluzieb

error_reporting(0);
session_start(); 
$h5rtgh5 = include("../odpad2010/h5rtgh5.php");

$prehliadac=$_SERVER['HTTP_USER_AGENT'];
//echo $prehliadac;
$pos = strpos($prehliadac, "MSIE");
if ($pos === false) {
    $msie=0;
} else {
    $msie=1;
}
$_SESSION['msie']=$msie;

$pos = strpos($prehliadac, "MSIE 10.0");
if ($pos === false) {
    $msie10=0;
} else {
    $msie10=1;
}
$_SESSION['ie10']=$msie10;

$pos = strpos($prehliadac, "rv:11.0");
if ($pos === false) {
    $msie11=0;
} else {
    $msie11=1;
}
if( $msie11 == 1 ) { $msie10=1; $_SESSION['ie10']=1; }


//Safari
$pos = strpos($prehliadac, "Safari");
if ($pos === false) {
    $safari=0;
} else {
    $safari=1;
}

//Chrome
$pos = strpos($prehliadac, "Chrome");
if ($pos === false) {
    $chrome=0;
} else {
    $chrome=1; $safari=0;
}
$_SESSION['chrome']=$chrome;

//Android
$pos = strpos($prehliadac, "Android");
if ($pos === false) {
    $android=0;
} else {
    $android=1; $safari=0;
}
$_SESSION['android']=$android;

//iPad
$pos = strpos($prehliadac, "iPad");
if ($pos === false) {
    $ipad=0;
} else {
    $ipad=1; $safari=0;
}
$_SESSION['ipad']=$ipad;

//iPhone
$pos = strpos($prehliadac, "iPhone");
if ($pos === false) {
    $iphone=0;
} else {
    $iphone=1;
    $ipad=1; $safari=0;
}
$_SESSION['iphone']=$iphone;
$_SESSION['safari']=$safari;
$pos = strpos($prehliadac, "Firefox");
if ($pos === false) {
    $firefox=0;
} else {
    $firefox=1;
}
$_SESSION['firefox']=$firefox;

$nespravnyprehliadac=0;
if( $msie == 0 AND $msie10 == 0 AND $chrome == 0 AND $safari == 0 AND $android == 0 AND $ipad == 0 AND $iphone == 0 AND $firefox == 0 ) { $nespravnyprehliadac=1; }


$copern = $_REQUEST['copern'];
$prihl=0;

$oldid=0;
if( $copern == 33 ) 
{
if( $_SESSION['ez_id'] > 999990000 ) { $oldid=1*$_SESSION['ez_id']; }

$overezak = include("../cis/overezak.php");

}

$ez_kto = $_SESSION['ez_kto'];
$ez_id = $_SESSION['ez_id'];
$prihl= $_SESSION['prihl'];

//odhlasenie
$odhlasenie = 1*$_REQUEST['odhlasenie'];
if( $odhlasenie == 1 ) 
{
    $_SESSION['prihl'] = 0;
    $_SESSION['ez_ico'] = 0;
    $_SESSION['set_ico'] = 0;
    $_SESSION['set_obdm'] = 0;
$prihl=0;
}

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

if( $_SERVER['SERVER_NAME'] == "www.ala.sk" ) { mysql_query("SET NAMES cp1250"); }

$sqlttt = "SELECT * FROM F".$_SESSION['eshop_fir']."_webslu ";
$sqldok = mysql_query("$sqlttt");
if(!$sqldok)
{
echo "Nastavte najprv parametre eshopovej webstr·nky v Skladov˝ch a materi·lov˝ch poloûk·ch.";
exit;

}

$eurosecom2015virtualnyserver=0;
if( file_exists("pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( file_exists("../pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( $eurosecom2015virtualnyserver == 1 ) { mysql_query("SET NAMES cp1250"); }

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
$cennik = 1*$_SESSION['ez_ccen'];

//pridel id nahodne neprihlasenemu autoreg=1
if( $_SESSION['ez_id'] == 999990001 ) 
{

$dnes0 = Date ("Y-m-d H:i:s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")));

$sqlttt = "DELETE FROM F$firxy"."_kosik WHERE xid > 999990001 AND xdatm < '$dnes0' ";
$sqldok = mysql_query("$sqlttt");

$nasiel=0;
while( $nasiel == 0 )
  {
$obrc=rand(999990002, 999995999);
$cpol=0;

$sqlttt = "SELECT * FROM F$firxy"."_kosik WHERE xid = $obrc ";
$sqldok = mysql_query("$sqlttt");
if( $sqldok ) { $cpol = 1*mysql_num_rows($sqldok); }
if( $cpol == 0 ) { $nasiel=1; }
  }

$cislo_dokladu=1;
$sqlttt = "SELECT * FROM F$firxy"."_kosik WHERE xid >= 0 ORDER BY xdok DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_dokladu=1*$riaddok->xdok+1; 
  }

$sqlttt = "INSERT INTO F$firxy"."_kosik ( xdok,xid, xcis ) VALUES ( $cislo_dokladu, $obrc, 0 ) ";
$sqldok = mysql_query("$sqlttt");

$_SESSION['ez_id']=$obrc;
}
//koniec pridel id nahodne neprihlasenemu autoreg=1

//po prihlaseni dodatocnom prepis kosik na nove id a stare kosiky vymaz
if( $oldid > 999990000 )
     {
$sqlttt = "DELETE FROM F$firxy"."_kosik WHERE xid = $ez_id  "; 
$sqldok = mysql_query("$sqlttt"); 

$sqlttt = "UPDATE F$firxy"."_kosik SET xid=$ez_id WHERE xid = $oldid "; 
$sqldok = mysql_query("$sqlttt"); 
     }

//nastav ico a obdm
$seticoobdm = 1*$_REQUEST['seticoobdm'];
if( $seticoobdm == 1 ) 
{
    $_SESSION['set_ico'] = 1*$_REQUEST['h_icoset'];
    $_SESSION['set_obdm'] = 1*$_REQUEST['h_odbmset'];

}

//setico > 0
$setico=1*$_SESSION['set_ico'];
$setobdm=1*$_SESSION['set_obdm'];
if( $setico > 0 OR $seticoobdm == 1 ) 
  {
$cennikpovodny=1*$cennik;
$sqlttt = "SELECT * FROM $kdewebs"."ezak WHERE ez_ico = $setico AND cxx1 = $setobdm ORDER BY ez_id DESC LIMIT 1 ";
$sqlttt = "SELECT * FROM $kdewebs"."ezak WHERE ez_ico = $setico ORDER BY ez_id DESC LIMIT 1 ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
    if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cennik=1*$riaddok->ccen;
    }
//echo $cennikpovodny."".$cennik."".$seticoobdm;
//if( $cennikpovodny != $cennik AND $seticoobdm == 1 )
if( $seticoobdm == 1 )
 {
if( $cennik == 0 ) { $sqlttt = "UPDATE F$firxy"."_kosik,F$firxy"."_sklcis SET xcep=cep, xced=ced WHERE xid = $ez_id AND F$firxy"."_kosik.xcis=F$firxy"."_sklcis.cis "; }
if( $cennik == 1 ) { $sqlttt = "UPDATE F$firxy"."_kosik,F$firxy"."_sklcisudaje SET xcep=cep01, xced=ced01 WHERE xid = $ez_id AND F$firxy"."_kosik.xcis=F$firxy"."_sklcisudaje.xcis "; }
if( $cennik == 2 ) { $sqlttt = "UPDATE F$firxy"."_kosik,F$firxy"."_sklcisudaje SET xcep=cep02, xced=ced02 WHERE xid = $ez_id AND F$firxy"."_kosik.xcis=F$firxy"."_sklcisudaje.xcis "; }
if( $cennik == 3 ) { $sqlttt = "UPDATE F$firxy"."_kosik,F$firxy"."_sklcisudaje SET xcep=cep03, xced=ced03 WHERE xid = $ez_id AND F$firxy"."_kosik.xcis=F$firxy"."_sklcisudaje.xcis "; }
if( $cennik == 4 ) { $sqlttt = "UPDATE F$firxy"."_kosik,F$firxy"."_sklcisudaje SET xcep=cep04, xced=ced04 WHERE xid = $ez_id AND F$firxy"."_kosik.xcis=F$firxy"."_sklcisudaje.xcis "; }
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$firxy"."_kosik SET xhdb=xmno*xcep, xhdd=xmno*xced, xice=$setico, xodbm=$setobdm WHERE xid = $ez_id "; 
$sqldok = mysql_query("$sqlttt");
 }

  }
//koniec ak setico > 0

$akakat = 1*$_REQUEST['akakat'];

$sqlfir = "SELECT * FROM F$firxy"."_ufir WHERE udaje = 1";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$mena1 = $fir_riadok->mena1;
$mena2 = $fir_riadok->mena2;
$kurz12 = $fir_riadok->kurz12;

mysql_free_result($fir_vysledok);

if( $copern == 33 ) 
{
$copern = 1;
}

$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR$firxy/"."autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

//ponuka 1=sluzby z faktur,2=dopravne sluzby,3=tovar zo skladu
if( $ponuka == 1 ) 
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


$sql = "SELECT xodbm FROM F$firxy"."_kosik";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$firxy"."_kosikobj ADD xodbm decimal(10,0) DEFAULT 0 AFTER xice";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$firxy"."_kosik ADD xodbm decimal(10,0) DEFAULT 0 AFTER xice";
$vysledek = mysql_query("$sql");
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


//registracia
if( $copern == 1020 AND $autoreg == 1 ) 
{
$h_prie = strip_tags($_REQUEST['h_prie']);
$h_meno = strip_tags($_REQUEST['h_meno']);
$h_tel = strip_tags($_REQUEST['h_tel']);
$h_mail = strip_tags($_REQUEST['h_mail']);
$h_pozn = strip_tags($_REQUEST['h_pozn']);

$ulozene=0;
$spravny=0;
$dlzkaprie=strlen($h_prie);
$dlzkamail=strlen($h_mail);
if( $dlzkaprie > 3 AND $dlzkamail > 3 ) { $spravny=1; }

//vymysli meno a heslo
$meno=""; $heslo="";

function urobznak($xporadie,$xcislo)
    {
$cisloznaku=$xcislo;
if( $cisloznaku ==  1 ) { $znak="a"; }
if( $cisloznaku ==  2 ) { $znak="b"; }
if( $cisloznaku ==  3 ) { $znak="c"; }
if( $cisloznaku ==  4 ) { $znak="d"; }
if( $cisloznaku ==  5 ) { $znak="e"; }
if( $cisloznaku ==  6 ) { $znak="f"; }
if( $cisloznaku ==  7 ) { $znak="h"; }
if( $cisloznaku ==  8 ) { $znak="k"; }
if( $cisloznaku ==  9 ) { $znak="m"; }
if( $cisloznaku == 10 ) { $znak="n"; }
if( $cisloznaku == 11 ) { $znak="p"; }
if( $cisloznaku == 12 ) { $znak="s"; }
if( $cisloznaku == 13 ) { $znak="u"; }
if( $cisloznaku == 14 ) { $znak="v"; }
if( $cisloznaku == 15 ) { $znak="x"; }
if( $xporadie > 8 AND $xporadie < 11 )
  {
if( $cisloznaku ==  1 ) { $znak="1"; }
if( $cisloznaku ==  2 ) { $znak="2"; }
if( $cisloznaku ==  3 ) { $znak="3"; }
if( $cisloznaku ==  4 ) { $znak="4"; }
if( $cisloznaku ==  5 ) { $znak="5"; }
if( $cisloznaku ==  6 ) { $znak="6"; }
if( $cisloznaku ==  7 ) { $znak="7"; }
if( $cisloznaku ==  8 ) { $znak="8"; }
if( $cisloznaku ==  9 ) { $znak="9"; }
  }  
return $znak;
    }

$cznak=rand(1, 15);
$akyznak=urobznak(1,$cznak);
$meno=$meno.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(2,$cznak);
$meno=$meno.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(3,$cznak);
$meno=$meno.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(4,$cznak);
$meno=$meno.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(5,$cznak);
$meno=$meno.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(6,$cznak);
$meno=$meno.$akyznak;

$cznak=rand(1, 15);
$akyznak=urobznak(7,$cznak);
$heslo=$heslo.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(8,$cznak);
$heslo=$heslo.$akyznak;
$cznak=rand(1, 9);
$akyznak=urobznak(9,$cznak);
$heslo=$heslo.$akyznak;
$cznak=rand(1, 9);
$akyznak=urobznak(10,$cznak);
$heslo=$heslo.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(11,$cznak);
$heslo=$heslo.$akyznak;
$cznak=rand(1, 15);
$akyznak=urobznak(12,$cznak);
$heslo=$heslo.$akyznak;

//echo $meno." ".$heslo;
//exit;

$uzregistrovany=0;
$sqlttt = "SELECT * FROM $kdewebs"."ezak WHERE ez_ema LIKE '%$h_mail%' ORDER BY ez_id DESC LIMIT 1 ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uzregistrovany=1;
  $ez_id=1*$riaddok->ez_id;
  $h_kto=$riaddok->ez_kto;
  $meno=$riaddok->ez_meno;
  $heslo=$riaddok->ez_heslo;
  $h_mail=$riaddok->ez_ema;
  $ulozene=1;
  //echo "uz je ";
  }

//exit;


if( $uzregistrovany == 0 )
                    {

//ezak ez_id  ez_meno  ez_heslo  ez_ico  ez_tel  ez_ema  ez_kto  ccen  cskl  cxx2  cxx1  datm  
$h_kto=$h_meno." ".$h_prie;

$ttvv = "INSERT INTO $kdewebs"."ezak ( ez_meno, ez_heslo, ez_tel, ez_ema, ez_kto ) VALUES ".
" (  '$meno', '$heslo', '$h_tel', '$h_mail', '$h_kto' )";
if( $spravny == 1 ) { $ttqq = mysql_query("$ttvv"); }
if($ttqq) { $ulozene=1; }

                    }

if( $spravny == 1 )           {

if( $uzregistrovany == 0 )
                    {

$sqlttt = "SELECT * FROM $kdewebs"."ezak WHERE ez_id > 0 ORDER BY ez_id DESC LIMIT 1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ez_id=1*$riaddok->ez_id;
  }

$ttvv = "UPDATE $kdewebs"."ezak SET ez_ico=$ez_id WHERE ez_id=$ez_id ";
$ttqq = mysql_query("$ttvv"); 

$sqult = "INSERT INTO F$firxy"."_ico ( ico,icd,dic,nai,na2,uli,mes,psc,tel,fax,em1,em2,em3,www,nm1,uc1,nm2,uc2,nm3,uc3,dns)".
" VALUES ( '$ez_id', '$x_icd', '$x_dic', '$h_kto', '$x_naz2', '$h_pozn', '$x_mes', '$x_psc', '$h_tel', '$x_fax', '$h_mail', '', '', '$x_www',".
" '0', '0', '$x_num2', '$x_ucb2', '$x_num3', '$x_ucb3', '1'".
"  );";
//echo $sqult;
$ulozene = mysql_query("$sqult"); 

                    }

$oldid=0;
if( $_SESSION['ez_id'] > 999990000 ) { $oldid=1*$_SESSION['ez_id']; }
//po registracii dodatocnej prepis kosik na nove id
if( $oldid > 999990000 )
     {
$sqlttt = "UPDATE F$firxy"."_kosik SET xid=$ez_id WHERE xid = $oldid "; 
$sqldok = mysql_query("$sqlttt"); 
     }
$_SESSION['ez_id']=$ez_id;
$_SESSION['ez_kto']=$h_kto;
$_SESSION['prihl']=1;

$ez_kto = $_SESSION['ez_kto'];
$ez_id = $_SESSION['ez_id'];
$prihl= $_SESSION['prihl'];

                                 }

$ukladalsom=1;
$copern = 1;
}
//registracia

//ake css
$akecss="styl_eshop_blue.css";
if( $webs_text5 == "fialovÈ" ) { $akecss="styl_eshop_magenta.css"; }
if( $webs_text5 == "Ëierne" ) { $akecss="styl_eshop_black.css"; }
if( $webs_text5 == "hnedÈ" ) { $akecss="styl_eshop_brown.css"; }
if( $webs_text5 == "tmavoruûovÈ" ) { $akecss="styl_eshop_darkpink.css"; }
if( $webs_text5 == "olivovozelenÈ" ) { $akecss="styl_eshop_olive.css"; }
if( $webs_text5 == "öedÈ" ) { $akecss="styl_eshop_grey.css"; }



if( $_SERVER['SERVER_NAME'] == "www.eshopp3service.sk" ) 
  { 

$sql = "ALTER TABLE F$firxy"."_sklcisudaje MODIFY xnat4 decimal(10,0) DEFAULT 0 ";
//$vysledek = mysql_query("$sql");

  }


if( $msie10 == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/<?php echo $akecss; ?>" type="text/css">
<title>EuroSecom - Webov· ponuka</title>

<script type="text/javascript">

    function ObnovUI()
    {

<?php
if ( $prihl == 1 AND $nespravnyprehliadac == 0 AND $firefox == 0 )
{
?>
vlozdokosika(0,0,0,0);
<?php
}
?>

<?php
if ( $nespravnyprehliadac == 1 )
{
?>
    myRobotmenu = document.getElementById("robotmenu");

    var htmlmenunac = "<table class='regmenu'>";

    htmlmenunac += "<tr><td width='23%'></td><td width='57%'></td><td width='20%'></td></tr>";


    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>"; 

    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>";

    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>"; 

    htmlmenunac += "<tr height='25'><td colspan='2' class='reghead tuko'>Pre spr·vnu funkciu programu pouûite prehliadaË IE, Chrome, Safari, Firefox</td>";
    htmlmenunac += "<td colspan='1' align='right'><a href=\"#\" onClick='zhasni_menurobot();' title='Zruöiù registr·ciu' class='regcancel'>Zavrieù";
    htmlmenunac += "<img src='../obr/zmazuplne.png' style='width:15; height:15; position:relative; top:3px; margin-left:4px;'></a></td></tr>";

    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>"; 

    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>"; 

    htmlmenunac += "<tr height='25'><td colspan='1' align='right' class='tuko'> </td>"; 
    htmlmenunac += "<td colspan='2'> </td></tr>"; 
                    
    htmlmenunac += "</table>";

    myRobotmenu.style.top = 200;
    myRobotmenu.style.left = 350;
    myRobotmenu.style.width = 600;
    myRobotmenu.innerHTML = htmlmenunac;
    robotmenu.style.display='';
<?php
}
?>

<?php
if( $hladanie == 1 ) 
{
?> 
<?php
if( $ponuka == 3 ) 
 {
?>
document.forms.formh2.hlad_txt.value = '<?php echo $hlad_txt; ?>';
<?php
 }
?>
<?php
}
?>
document.forms.formcn.cennik.value = '<?php echo $cennik; ?>';

<?php
if ( $prihl == 0 AND $autoreg == 0 )
{
?>
loginbox.style.display='block';
<?php
}
?>
    }


    function nakupnykosik()
    {

window.open('kosik_tlac.php?copern=1&drupoh=1&page=1&html=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
   
    }

    function refreskosik()
    {
<?php
if ( $prihl == 1 AND $nespravnyprehliadac == 0 )
{
?>
vlozdokosika(0,0,0,0);  
<?php
 }
?>
    }

    function vyberkat()
    {
    var katx=document.forms.formcn.hlad_kat01h.value;

window.open('webs.php?copern=9&akakat=' + katx + '&kkt=1',
 '_self', 'width=800, height=600, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
    }

    function vyberkatli(akeli)
    {
    var katx=akeli;

window.open('webs.php?copern=9&akakat=' + katx + '&kkt=1',
 '_self', 'width=800, height=600, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
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
<?php
if ( $prihl == 0 OR $autoreg == 1 AND $firefox == 0  )
{
?>
<script type="text/javascript" src="registruj.js"></script>
<?php
}
?>
<?php
if ( $prihl == 0 OR $autoreg == 1 AND $firefox == 1  )
{
?>
<script type="text/javascript">

function Zaregistruj()
                {

var prie = document.forms.enast.h_prie.value;
var meno = document.forms.enast.h_meno.value;
var tel = document.forms.enast.h_tel.value;
var mail = document.forms.enast.h_mail.value;
var pozn = document.forms.enast.h_pozn.value;
var vop = 0;
if( document.enast.vop.checked ) vop=1;

if( vop == 1 && prie != '' && mail != '' )
   {
window.open('webs.php?copern=1020&drupoh=1&h_prie=' + prie + '&h_meno=' + meno + '&h_tel=' + tel + '&h_mail=' + mail + '&h_pozn=' + pozn + '&page=1', '_self' );
   }
                }


function Registruj()
                {

    myRobotmenu = document.getElementById("robotmenu");

    var htmlmenunac = "<FORM name='enast' method='post' action='#' ><table class='regmenu'>";

    htmlmenunac += "<tr><td width='23%'></td><td width='57%'></td><td width='20%'></td></tr>";

    htmlmenunac += "<tr height='25'><td colspan='2' class='reghead tuko'>Nov˝ uûÌvateæ - registr·cia</td>";
    htmlmenunac += "<td colspan='1' align='right'><a href=\"#\" onClick='zhasni_menurobot();' title='Zruöiù registr·ciu' class='regcancel'>Zavrieù";
    htmlmenunac += "<img src='../obr/zmazuplne.png' style='width:15; height:15; position:relative; top:3px; margin-left:4px;'></a></td></tr>";
                    
    htmlmenunac += "<tr> ";

    htmlmenunac += "<td colspan='1' align='right'>Meno&nbsp;</td>"; 
    htmlmenunac += "<td colspan='2'><input type='text' name='h_meno' id='h_meno' style='width:120' maxlenght='20' value='' class='norm'></td></tr>";

    htmlmenunac += "<tr><td colspan='1' align='right' class='tuko'>Priezvisko&nbsp;</td>"; 
    htmlmenunac += "<td colspan='2'><input type='text' name='h_prie' id='h_prie' style='width:120' maxlenght='25' value='' class='povi'>&nbsp;<span class='pvn'>*</span></td></tr>"; 

    htmlmenunac += "<td colspan='1' align='right' class='tuko'>e-mail&nbsp;</td>"; 
    htmlmenunac += "<td colspan='2'><input type='text' name='h_mail' id='h_mail' style='width:240px;' maxlenght='40' value='' class='povi'>&nbsp;<span class='pvn'>*</span></td></tr>";

    htmlmenunac += "<tr><td colspan='1' align='right'>telefÛn&nbsp;</td>"; 
    htmlmenunac += "<td colspan='2'><input type='text' name='h_tel' id='h_tel' style='width:120' maxlenght='20' value='' class='norm'></td></tr>"; 

    htmlmenunac += "<tr><td colspan='1' align='right'>adresa&nbsp;</td>"; 
    htmlmenunac += "<td colspan='1'><input type='text' name='h_pozn' id='h_pozn' style='width:240px;' maxlenght='40' value='' class='norm'></td>"; 
    htmlmenunac += "<td rowspan='2' valign='top' colspan='1' align='right'><a href=\"#\" onclick=\"Zaregistruj();\" class='regbut'>Uloûiù</a></td></tr>";

    htmlmenunac += "<tr><td align='right' colspan='2' >&nbsp;<span class='pvn'><input type='checkbox' name='vop' value='1'></span>&nbsp;<i>s˙hlasÌm so <a href=\"#\" onclick=\"VOP();\" >Vöeobecn˝mi obchodn˝mi podmienkami</a></i>&nbsp;&nbsp;<span class='pvn'>*</span></td></tr>";
    
    htmlmenunac += "<tr style='height:30px;'><td colspan='2' align='right' >&nbsp;<span class='pvn'>*</span>&nbsp;<i>povinnÈ ˙daje pre registr·ciu</i></td><td>&nbsp;</td></tr>";



    htmlmenunac += "</table></FORM>";

  myRobotmenu.style.width = 600;
  myRobotmenu.innerHTML = htmlmenunac;
  robotmenu.style.display='';

                }

  function zhasni_menurobot()
  {                 
  robotmenu.style.display='none';
  } 

</script>
<?php
}
?>
<?php
if ( $prihl == 0 AND $autoreg == 0  )
{
?>
<script type="text/javascript">

    function Registruj(akeli)
    {

    }

</script>
<?php
}
?>

<?php
if ( $autoreg == 1  )
{
?>
<script type="text/javascript">

    function VOP()
    {
window.open('../dokumenty/FIR<?php echo $firxy; ?>/vseobpodmienky.pdf',
 '_blank', 'width=800, height=600, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
    }

</script>
<?php
}
?>

<?php
if ( $_SESSION['ez_ico'] == 99999999 AND $prihl == 1 )
{
?>
<script type="text/javascript" src="spr_ico_xml.js"></script>
<script type="text/javascript" src="spr_odbm_xml.js"></script>
<script type="text/javascript" src="set_odbm_xml.js"></script>
</script>
<?php
}
?>

</HEAD>
<BODY onload="ObnovUI();" onfocus="refreskosik()">

<?php
if ( $copern == 1 )
     {
?>
<div id="nastavfakx" style="cursor:hand; display:none; position:absolute; z-index:500; top:40px; left:52%; margin-left:1px;">
<table class='regmenu'>

<tr><td width='28%'></td><td width='52%'></td><td width='20%'></td></tr>

<tr height='25'><td colspan='2' class='reghead tuko'>V˝ber odberateæa</td>
<td colspan='1' align='right'><a href="#" onClick="nastavfakx.style.display='none';" title='Zruöiù registr·ciu' class='regcancel'>Zavrieù
<img src='../obr/zmazuplne.png' style='width:15px; height:15px; position:relative; top:3px; margin-left:4px;'></a></td></tr>
                    
<tr><FORM name='enasti' method='post' action='#'></tr>

<tr><td colspan='1' align='right' class='tuko'>I»O&nbsp;</td> 
<td colspan='2'>
<input type='text' name='h_ico' id='h_ico' style='width:100' maxlenght='10' value="" class='povi'>
<img src='../obr/eshop/find_icon.png' width='14' height='14' onclick='volajIcox();' title='Hæadaj I»O' class='odbfind'>
</td></tr>

<tr><td colspan='1' align='right'>OdbernÈ miesto&nbsp;</td> 
<td colspan='1'><input type='text' name='h_odbm' id='h_odbm' style='width:150' maxlenght='50' value="" class='norm'>
<img src='../obr/eshop/find_icon.png' width='14' height='14' onclick='volajODBMx();' title='Hæadaj ODBM' class='odbfind'></td>
<td rowspan='2' valign='top' colspan='1' align='right'>
<a href="#" onClick="ZapisIco(0);" class='regbut'>Nastaviù</a>
</td></tr>
    
<tr style='height:20px'><td colspan='1'></td><td valign='top' colspan='1'></td></tr>

</FORM></table>
</div>
<script type="text/javascript">

function NastavIco( doklad, icox, odbmx )
                {
  nastavfakx.style.display='';
  document.forms.enasti.h_ico.value=icox;
  document.forms.enasti.h_odbm.value=odbmx;
                }

function ZapisIco( premx )
                {

var ico = document.forms.enasti.h_ico.value;
var odbm = document.forms.enasti.h_odbm.value;

var premenna = premx;

window.open('webs.php?seticoobdm=1&ponuka=3&copern=1&h_icoset=' + ico + '&h_odbmset=' + odbm + '&page=1', '_self' );

                }


  function volajIcox()
  {                 
  if( document.forms.enasti.h_ico.value != '' ) { volajIco(); }
  }

  function volajODBMx()
  {                 
  if( document.forms.enasti.h_ico.value > 0 ) { volajODBM(); }
  }

</script>
<?php
     }
?>

<?php 
if( $copern == 1 OR $copern == 44 OR $copern == 9 )
{

// pocet poloziek na stranu
$pols = 10;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
$iks=0;

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

$podmktg=" pr1g != 99 ";
if( $autoreg == 0 AND $prihl == 0 ) { $podmktg=" pr1g != 98 AND pr1g != 99 "; }

$sqlt = "SELECT cis AS slu, nat AS nsl,mer,cep,ced,tl1,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,xdr2,pr1g,F$firxy"."_sklcisudaje.xnat4".
" FROM F$firxy"."_$tablsluzby ".
" LEFT JOIN F$firxy"."_sklcisudaje".
" ON F$firxy"."_$tablsluzby.cis=F$firxy"."_sklcisudaje.xcis".
" LEFT JOIN F$firxy"."_restktgtov".
" ON F$firxy"."_sklcisudaje.xdr2=F$firxy"."_restktgtov.cktg".
" WHERE $podmktg AND tl1 = 1 ORDER BY cktg,F$firxy"."_sklcisudaje.xnat4,cis";

$sql = mysql_query("$sqlt");
//echo "1".$sqlt;
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
$podmktg=" pr1g != 99 ";
if( $autoreg == 0 AND $prihl == 0 ) { $podmktg=" pr1g != 98 AND pr1g != 99 "; }

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
if( $akakat != 0 ) 
  {
$xvetva=0; $xhlavna=0;
$sqltttk = "SELECT * FROM F$firxy"."_restktgtov WHERE cktg = $akakat ORDER BY cktg LIMIT 1";
$sqldokk = mysql_query("$sqltttk");
 if (@$zaznam=mysql_data_seek($sqldokk,0))
 {
 $riaddokk=mysql_fetch_object($sqldokk);
 $xvetva=1*$riaddokk->pr2g;
 $xhlavna=1*$riaddokk->pr3g;
 }
$podm = " AND xdr2 = '".$akakat."'";  
if( $xvetva <= 1 AND $xhlavna > 0 ) { $podm = " AND ( xdr2 = '".$akakat."' OR pr3g = '".$xhlavna."' )"; }
  }
if( $hlad_txt != '' ) $podm = " AND nat LIKE '%".$hlad_txt."%'";

$sqlhh = "SELECT cis AS slu, nat AS nsl,mer,cep,ced,tl1,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,xdr2,pr1g,F$firxy"."_sklcisudaje.xnat4".
" FROM F$firxy"."_$tablsluzby ".
" LEFT JOIN F$firxy"."_sklcisudaje".
" ON F$firxy"."_$tablsluzby.cis=F$firxy"."_sklcisudaje.xcis".
" LEFT JOIN F$firxy"."_restktgtov".
" ON F$firxy"."_sklcisudaje.xdr2=F$firxy"."_restktgtov.cktg".
" WHERE $podmktg AND tl1 = 1 ".$podm." ORDER BY F$firxy"."_sklcisudaje.xnat4,cis";

}

//echo "2".$sqlhh;
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
if( $copern == 1 OR $copern == 9  )
{
?>
<span style="position:absolute; top:90px; left:50%;  z-index:3000;">
<div id="myIcoElement"></div> <!-- ponuka odberatelov v okne "Vyber odberatela" -->
</span>
<span style="position:absolute; top:130px; left:50%;  z-index:3000;">
<div id="myOdbmElement"></div> <!-- ponuka odbernych miest v okne "Vyber odberatela" -->
</span>

<table>
<tr>
<?php if( $copern != 44 ) { ?>
<td width="40%" valign="top">
<img src='../dokumenty/FIR<?php echo $firxy; ?>/hlavickaweb.jpg' class="firlogo">
<?php                     } ?>
</td>
<td width="25%" align="right"></td> <!-- moûno kontakt -->
<td width="35%" align="right" valign="top" style="color:#fff;">

<?php
if ( $prihl == 0 OR ( $autoreg == 1 AND $_SESSION['ez_id'] > 999990000 ) )
{
?>
<a href="#" onclick="loginbox.style.display='block';" class="login-textbtn">Prihl·senie</a>
<span class="tuko">|</span>
<?php if ( $autoreg == 0  ) { ?>
<a href="#" onclick="" title="O registr·ciu poûiadajte administr·tora" class="adminreg-textbtn">Registr·cia</a> 
<?php                       } ?>
<?php if ( $autoreg == 1  ) { ?>
 <a href="#" onclick="Registruj(0);" title="Registrovaù" class="reg-textbtn">Registr·cia</a>
<?php                       } ?>
 
<FORM name="form1" id="loginbox" method="post" action="webs.php?copern=33&page=1&ponuka=<?php echo $ponuka;?>">
 <div style="margin-top:2px;">
  <img src="../obr/eshop/person.png" title="Prihlasovacie meno" class="imglabel">
  <input type="text" name="wsxmn" id="wsxmn" class="loginvypln">
  <img src='../obr/zmazuplne.png' onclick="loginbox.style.display='none';" class="cancel-btn">
 </div>
 <div>
  <img src="../obr/eshop/password.png" title="Prihlasovacie heslo" class="imglabel">
  <input type="password" name="wsxhs" id="wsxhs" class="loginvypln">
 </div> 
 <INPUT type="submit" name="inputb" id="inputb" value="Prihl·siù" title="Prihl·siù" class="login-btn">
</FORM>

<?php
}
?>





<?php
if ( $prihl == 1 )
     {
?>
<div class="logged">
  <?php if( $_SESSION['ez_ico'] == 99999999 ) { ?>
<?php
$nai=""; $mes="";
$sqlfir = "SELECT * FROM F$firxy"."_ico WHERE ico = $setico ";
//echo $sqlfir;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $nai = $fir_riadok->nai; $mes = $fir_riadok->mes; }

$onai=""; $omes="";
$sqlfir = "SELECT * FROM F$firxy"."_icoodbm WHERE ico = $setico AND odbm = $setobdm ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $onai = $fir_riadok->onai; $omes = $fir_riadok->omes; }
?>
    <?php $vypisico=$setico; ?>
<div style="text-align:right; float:right; ">
  <a href="#" onclick="NastavIco(0,<?php echo $setico; ?>,<?php echo $setobdm; ?>);" title="<?php echo $nai." ".$mes; ?> V˝ber Odberateæa"><?php echo $vypisico; ?></a>
</div>
<div>
  <img src="../obr/eshop/prihlaseny.png" title="Prihl·sen˝" height="11" width="11">
  <a href="#" title="Odhl·siù" onclick="window.open('webs.php?odhlasenie=1&ponuka=<?php echo $ponuka;?>&copern=<?php echo $copern;?>&page=<?php echo $page;?>', '_self')"><?php echo "$ez_kto";?></a>
</div>
    <?php $vypisico=$setobdm; ?>
<div style="text-align:right; padding-top:1px;">
  <a href="#" onclick="NastavIco(0,<?php echo $setico; ?>,<?php echo $setobdm; ?>);" title="<?php echo $onai." ".$omes; ?> V˝ber Odberateæa"><?php echo $vypisico; ?></a>
</div>
  <?php                                       } ?>

  <?php if( $_SESSION['ez_ico'] != 99999999 AND $_SESSION['ez_id'] < 999990000 ) { ?>
<div style="position:relative; top:6px; margin-bottom:10px; " >
  <img src="../obr/eshop/prihlaseny.png" title="Prihl·sen˝" height="11" width="11">
  <a href="#" title="Odhl·siù" onclick="window.open('webs.php?odhlasenie=1&ponuka=<?php echo $ponuka;?>&copern=<?php echo $copern;?>&page=<?php echo $page;?>', '_self')"><?php echo "$ez_kto";?></a>
</div>
  <?php                                                                          } ?>
</div>

<div class="kosik-area">
<div class="kosik-info" id="myKosikdiv"></div>
<img src='../obr/eshop/kosik.png' onclick="nakupnykosik();" width=90 height=30 title="N·kupn˝ koöÌk" class="kosik">
</div>


</td>
</tr>
<?php
     }
?>

</table>
<?php
}
?>

</div>
</div>
<div id="robotmenu" style="display: none; position:absolute; z-index:1; top:10px; right:15%;">
zobrazene menu
</div>

<div id="wrap-content" >
<div id="content" >

<?php
if( $copern == 1 OR $copern == 9 )
{
?>
<div class="uvod-nadpis"><?php echo $webs_nadp1; ?></div>
<?php
}
?>

<?php
if( $copern == 1 OR $copern == 9 )
{
?>
<table>
<tr>
<td class="leftnav" width="20%" valign="top">
<div class="ktg">
<div class="ktg-head">KategÛrie</div>
<div class="ktg-menu">
<FORM name="formcn" method="post" action="#">
<?php
if( $ponuka == 3 )
{
?>
<div id="hlad_kat01h" class="ktg-box">
<?php $clasli="noactktg"; if( $akakat == 0 ) { $clasli="actktg"; } ?>
<li class="allktg" onclick="vyberkatli(0)";>
<img src="../obr/eshop/obnovit.png" title="Vöetky kategÛrie" height="30" width="30" style="position:relative; top:1px\9;">
</li>
<?php
$podmktg=" pr1g != 99 ";
if( $autoreg == 0 AND $prihl == 0 ) { $podmktg=" pr1g != 98 AND pr1g != 99 "; }
if( $akakat == 0 ) { $sqlxx = mysql_query("SELECT * FROM F$firxy"."_restktgtov WHERE $podmktg AND pr2g <= 1 ORDER BY pr3g,cktg "); }
if( $akakat >  0 ) { $sqlxx = mysql_query("SELECT * FROM F$firxy"."_restktgtov WHERE $podmktg AND ( pr2g <= 1 OR pr3g = $xhlavna ) ORDER BY pr3g,cktg "); }
?>
<?php while($zaznam=mysql_fetch_array($sqlxx)):?>
<?php $clasli="noactktg"; if( $akakat == $zaznam["cktg"] ) { $clasli="actktg"; } ?>
<li class="<?php echo $clasli; ?>" value="<?php echo $zaznam["cktg"];?>" onclick="vyberkatli(<?php echo $zaznam["cktg"];?>)"; >
<?php
$nazovktg=$zaznam["nktg"];
$dlzkanaz=strlen($nazovktg);
if( $dlzkanaz > 25 AND $akakat != $zaznam["cktg"] ) { $nazovktg=substr($nazovktg,0,24)."..."; }
if( $dlzkanaz > 21 AND $akakat == $zaznam["cktg"] ) { $nazovktg=substr($nazovktg,0,20)."..."; }
?>
<?php if( $zaznam["pr2g"] <= 1 ) { echo $nazovktg; } ?>
<?php if( $zaznam["pr2g"] >= 2 ) { echo " - ".$nazovktg; } ?>
</li>
<?php endwhile;?>
<INPUT type="hidden" name="hlad_kat02h" id="hlad_kat02h" value="0" />
<INPUT type="hidden" name="hlad_kat03h" id="hlad_kat03h" value="0" />
<INPUT type="hidden" name="hlad_kat04h" id="hlad_kat04h" value="0" />
</div>
<?php
}
?>
</div>
</div><br>

<div class="cennik">
<div class="cennik-head">CennÌk</div>
<div class="cennik-menu">
<select size="1" name="cennik" id="cennik">
<?php if( $cennik == 0 ) { ?><option value="0" >CennÌk 0</option><?php } ?>
<?php if( $cennik == 1 ) { ?><option value="1" >CennÌk 1</option><?php } ?>
<?php if( $cennik == 2 ) { ?><option value="2" >CennÌk 2</option><?php } ?>
<?php if( $cennik == 3 ) { ?><option value="3" >CennÌk 3</option><?php } ?>
<?php if( $cennik == 4 ) { ?><option value="4" >CennÌk 4</option><?php } ?>
</select>
</FORM>
</div>
</div>
<br>
</td>

<td width="80%" valign="top">
<FORM name="formh2" method="post" action="webs.php?copern=9&page=1&ponuka=<?php echo $ponuka;?>" >
<table style="margin-top:-8px;">
<tr>
<td width="45%" class="found" align="right">
<img src="../obr/eshop/najdene.png" title="N·jdenÈ poloûky" height="12" width="12">&nbsp;&nbsp;<span><?php echo "$cpol";?></span>&nbsp;poloû.&nbsp;na&nbsp;<span ><?php echo "$xstr";?></span>&nbsp;str.
</td>
<td width="55%" align="right">
<div class="findarea">
<?php
if( $ponuka == 3 )
{
?>

<input type="text" name="hlad_txt" id="hlad_txt" placeholder="hæadaj tovar" class="find-box" value="<?php echo $hlad_txt;?>" />
<INPUT type="submit" id="hlad1" name="hlad1" class="finder" value=" " title="Hæadaj">

<?php
}
?>
</FORM>
<FORM name="formh3" method="post" action="webs.php?copern=1&page=1&ponuka=<?php echo $ponuka;?>" >
<INPUT type="image" id="hlad2" name="hlad2" value="Obnoviù" src="../obr/eshop/obnovit.png" title="Obnoviù" class="obnovit">
</FORM>
</div>
</td>
</tr>
</table>

<FORM name="formcnxxx" method="post" action="#">
<table class="list-finding">
<tr>
<td width="10%"></td><td width="30%"></td><td width="20%"></td><td width="13%"></td><td width="12%"></td><td width="15%"></td>
</tr>
</FORM>
<thead>
<tr>
<th colspan="1">KÛd</th><th colspan="1">Popis</th><th colspan="1">N·hæad</th><th colspan="1">Cena</th><th colspan="1">Z·soba</th>
<td colspan="1" class="info-ceny" align="right">
<span>
<span class="puntik-bezdph">&nbsp;&nbsp;</span>&nbsp;bez DPH&nbsp;&nbsp;<span class="puntik-sdph" >&nbsp;&nbsp;</span>&nbsp;s DPH&nbsp;
</span>
</td>
</tr>
</thead>

<?php
if( $cpol == 0 )
{
?>
<tr>
<td class="nofinding" colspan="6" rowspan="2" align="center"><span>Nenaöiel som ûiadne poloûky vyhovuj˙ce zadan˝m podmienkam</span></td>
</tr>
<?php
}
?>
<tr>
<td colspan="6" height="5"></td>
</tr>
<FORM name="formks" method="post" action="#">
<?php
if( $cpol == 0 )
{
?>
<INPUT type="hidden"  name="ks0" id="ks0"  value="1" />
<?php
}
?>
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

<tbody>
<tr>
<td colspan="1" class="tovkod" align="center"><?php echo $riadok->slu;?></td>
<?php
if( $copern == 1 OR $copern == 9  )
{
?>
<td colspan="1" class="tovnazov">
<a href="#" onclick="window.open('webstov.php?copern=44&cislo_slu=<?php echo $riadok->slu;?>&ponuka=<?php echo $ponuka;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=no')">
<?php echo $riadok->nsl;?></a>
</td>

<td class="tovnahlad" align="center" colspan="1" rowspan="2">
<?php
$fotonavysku=1*$riadok->kat04h;
$fotovyska=53;
$fotosirka=80;
if( $webs_obr1s > 0 ) { $fotosirka=$webs_obr1s; }
if( $webs_obr1v > 0 ) { $fotovyska=$webs_obr1v; }

if( $fotonavysku == 1 ) 
{
$fotovyska=80; 
$fotosirka=53; 
if( $webs_obr1v > 0 ) { $fotosirka=$webs_obr1v; }
if( $webs_obr1s > 0 ) { $fotovyska=$webs_obr1s; }
}
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.pdf"))  
{
$jesub=1;
?>
<a href="#" onclick="window.open('webstov.php?copern=44&cislo_slu=<?php echo $riadok->slu;?>&ponuka=<?php echo $ponuka;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=no')">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.pdf'
 width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Viac inform·ciÌ" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href="#" onclick="window.open('webstov.php?copern=44&cislo_slu=<?php echo $riadok->slu;?>&ponuka=<?php echo $ponuka;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=no')">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.jpg'
 width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Viac inform·ciÌ" ></a>
<?php
} 
?>

<?php
if (File_Exists ("../dokumenty/FIR$firxy/$adrdok/d$riadok->slu.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href="#" onclick="window.open('webstov.php?copern=44&cislo_slu=<?php echo $riadok->slu;?>&ponuka=<?php echo $ponuka;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=no')">
<img src='../dokumenty/FIR<?php echo $firxy;?>/<?php echo $adrdok;?>/d<?php echo $riadok->slu;?>.png'
 width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Viac inform·ciÌ" ></a>
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
<a href="#" onclick="window.open('webstov.php?copern=44&cislo_slu=<?php echo $riadok->slu;?>&ponuka=<?php echo $ponuka;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=no')">
<img src='<?php echo $filename;?>'
 width=<?php echo $fotosirka; ?> height=<?php echo $fotovyska; ?> title="Viac inform·ciÌ" ></a>
<?php
    }
$iout=$iout+1;
         }
} 
?>

<?php
}
?>
</td>

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
$sqldoks = mysql_query("SELECT * FROM F$firxy"."_sklcisudaje WHERE xcis = $riadok->slu ");
   if (@$zaznam=mysql_data_seek($sqldok,0))
   {
   $riaddoks=mysql_fetch_object($sqldoks);
   if( $cennik == 1 ) { $cenap=1*$riaddoks->cep01; $cenad=1*$riaddoks->ced01; }
   if( $cennik == 2 ) { $cenap=1*$riaddoks->cep02; $cenad=1*$riaddoks->ced02; }
   if( $cennik == 3 ) { $cenap=1*$riaddoks->cep03; $cenad=1*$riaddoks->ced03; }
   if( $cennik == 4 ) { $cenap=1*$riaddoks->cep04; $cenad=1*$riaddoks->ced04; }
   }
     }
$cenad=sprintf("%0.2f", $cenad);
$cenap=sprintf("%0.2f", $cenap);
}
if( $prihl == 0 ) { $zasoba=0; }
?>
<td align="right" rowspan="2"><span style="font-size:12px;" class="cenabezdph" ><?php echo $cenap;?></span>&nbsp;<br>
<span style="padding:2px; font-size:13px;" class="cenasdph"><?php echo $cenad;?></span>&nbsp;</td>

<?php
if ( $prihl == 1 )  
{
?>
<td class="tovzasoba" rowspan="2" align="right"><?php echo $zasoba;?>&nbsp;<?php echo $riadok->mer;?>&nbsp;</td>
<td class="tovdokosika" rowspan="2">&nbsp;<input type="number" name="ks<?php echo $iks;?>" id="ks<?php echo $iks;?>" value="1" style="width:60px;" ><br>
<!-- <input type="text" name="ks<?php echo $iks;?>" id="ks<?php echo $iks;?>" value="1" > -->
<div class="button-dokosika" id="dokosa<?php echo $iks;?>">
<img src='../obr/eshop/dokosika_button.png' onclick="vlozdokosika(<?php echo $riadok->slu;?>,<?php echo $iks;?>,<?php echo $cenap;?>,<?php echo $cenad;?>);" width=84 height=30 title="Do koöÌka">
</div>
<?php
}
?>
</td>
</tr>
<tr>
<td valign="top" class="tovpopis" colspan="2" ><?php echo $riadok->webtx1;?></td>
</tr>
<tr>
<td colspan="6"><hr align="center" size="1" width="580"></td>
</tr>
</tbody>

<?php
       }
    }
$i = $i + 1;
$iks = $iks + 1;
  }
?>
</FORM>
</table>

<table class="pagination">
<tr>
<FORM name="formcnxxx2" method="post" action="#">
<td width="20%"></td>
<td align="center" width="60%">
<a class="npage" title="Predoöl· strana" href='webs.php?copern=<?php echo $copern;?>&page=<?php echo $ppage;?>&ponuka=<?php echo $ponuka;?>&hladanie=<?php echo $hladanie;?>
&hlad_kat01h=<?php echo $hlad_kat01h;?>&hlad_kat02h=<?php echo $hlad_kat02h;?>
&hlad_kat03h=<?php echo $hlad_kat03h;?>&hlad_kat04h=<?php echo $hlad_kat04h;?>&hlad_txt=<?php echo $hlad_txt;?>&akakat=<?php echo $akakat;?>
'>Predoöl·</a>
&nbsp;<span style="font-weight:bold;">|</span>&nbsp;
<a class="npage" title="œalöia strana" href='webs.php?copern=<?php echo $copern;?>&page=<?php echo $npage;?>&ponuka=<?php echo $ponuka;?>&hladanie=<?php echo $hladanie;?>
&hlad_kat01h=<?php echo $hlad_kat01h;?>&hlad_kat02h=<?php echo $hlad_kat02h;?>
&hlad_kat03h=<?php echo $hlad_kat03h;?>&hlad_kat04h=<?php echo $hlad_kat04h;?>&hlad_txt=<?php echo $hlad_txt;?>&akakat=<?php echo $akakat;?>
'>œalöia</a>
</td>
<td width="20%" align="right" class="cpage">Strana:&nbsp;<?php echo "<b>$page</b> z $xstr ";?>&nbsp;</td>
</FORM>
</tr>
</table>

</td>
</tr>
</table>
<?php
}
?>

</div>
</div>

<div id="wrap-footer">
<div id="footer">
<div class="foot-text" style="" ><?php if ( $copern == 1 OR $copern == 9 ) echo $webs_text2; ?></div>

<?php
$fir_fwww="";
$sqlttt = "SELECT * FROM F$firxy"."_ufir ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $fir_fico=$riaddok->fico;
  $fir_fdic=$riaddok->fdic;
  $fir_ficd=$riaddok->ficd;
  $fir_fwww=$riaddok->fwww;
  $fir_fnaz=$riaddok->fnaz;
  $fir_fuli=$riaddok->fuli; 
  $fir_fcdm=$riaddok->fcdm;
  $fir_fpsc=$riaddok->fpsc;
  $fir_fmes=$riaddok->fmes;
  $fir_ftel=$riaddok->ftel;
  $fir_fem1=$riaddok->fem1;
  $fir_fuc1=$riaddok->fuc1;
  $fir_fnm1=$riaddok->fnm1;
  $fir_fib1=$riaddok->fib1;
  $fir_obreg=$riaddok->obreg;
  }
?>

<div id="footlinks" style="padding-bottom:2px;">
<table class="foot-links">
<tr>
 <td width="50%">
<a href="http://<?php echo $fir_fwww;?>" target="_blank" title="Domovsk· str·nka"><?php echo $fir_fwww;?></a>
|
<img src="../obr/eshop/people_darkgray_btn.png" onclick="contactmenu.style.display='block'; footlinks.style.display='none';" title="KontaktnÈ ˙daje" style="cursor:pointer; width:30px; height:15px;">
 </td>
 <td width="50%" align="right">powered by <a href="http://www.edcom.sk" target="_blank" title="EDcom, s.r.o." style="font-weight:bold;">EDcom</a></td>
</tr>
</table>
</div>

<div id="contactmenu" style="display:none; position:relative; top:-50px;">
<table class="contactbox" > 
<tr style="height:7px;">
 <td width="5%"></td><td width="35%"></td><td width="5%"></td><td width="25%"></td><td width="6%"></td><td width="19%"></td>
</tr>
<tr style="height:24px;">
 <td></td>
 <td colspan="4" style="letter-spacing:1px; font-size:16px; font-weight:bold;"><?php echo $fir_fnaz;?></td>
 <td align="right">
 <img src="../obr/eshop/cancel_white_btn.png" onclick="contactmenu.style.display='none'; footlinks.style.display='block';" title="Zavrieù"
  style="display:block; width:18px; height:18px; margin-right:12px; cursor:pointer;">
 </td>
</tr>
<tr>
 <th rowspan="2" valign="top"><img src="../obr/eshop/location_white_icon.png" title="SÌdlo firmy" style="width:15px; height:22px;"></th>
 <td style="border-right:2px solid #fff;"><?php echo $fir_fuli;?> <?php echo $fir_fcdm;?></td>
 <th><img src="../obr/eshop/mobile_white_icon.png" title="TelefÛnne ËÌslo" style="width:15px; height:15px;"></th>
 <td style="border-right:2px solid #fff;"><?php echo $fir_ftel;?></td>
 <th style="font-size:11px; text-align:right;">I»O</th>
 <td style="text-indent:5px;"><?php echo $fir_fico;?></td>
</tr>
<tr>
 <td style="text-align:left; border-right:2px solid #fff;"><?php echo $fir_fpsc;?>&nbsp;&nbsp;<?php echo $fir_fmes;?></td>
 <th><img src="../obr/eshop/zavinac_white_icon.png" title="Email" style="width:15px; height:15px;"></th>
 <td style="border-right:2px solid #fff;"><?php echo $fir_fem1;?></td>
 <th style="font-size:11px; text-align:right;">DI»</th>
 <td style="text-indent:5px;"><?php echo $fir_fdic;?></td>
</tr>
<tr>
 <th></th>
 <td style="border-right:2px solid #fff;">Slovensko</td> <!-- dopyt, neskÙr rieöiù cez premenn˙ -->
 <th><img src="../obr/eshop/globe_white_icon.png" title="Web str·nka" style="width:15px; height:15px;"></th>
 <td style="border-right:2px solid #fff;"><?php echo $fir_fwww;?></td>
 <th style="font-size:11px; text-align:right;">I»DPH</th>
 <td style="text-indent:5px;" ><?php echo $fir_ficd;?></td>
</tr>
<tr>
 <td colspan="6" height="5px"></td>
</tr>
<tr>
 <th><img src="../obr/eshop/banknote_white_icon.png" title="Bankov˝ ˙Ëet" style="width:21px; height:15px;"></th>
 <td><?php echo $fir_fuc1;?> / <?php echo $fir_fnm1;?></td>
 <th></th>
 <td colspan="3"><?php echo $fir_obreg;?></td>
</tr>
<tr>
 <th></th>
 <td><?php echo $fir_fib1;?></td>
 <td colspan="4"></td>
</tr>
<tr>
 <td colspan="6" height="5px"></td>
</tr>
</table>
</div>

</div>
</div>


<?php
if ( $ukladalsom == 1 AND $spravny == 1 )
{
//odosli meno a heslo
$predmet="E-SHOP zaregistrovany.";
$predmet = StrTr($predmet, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$riadok1="Vazeny zakaznik, "."\n";
$riadok2="Vase pristupove udaje pre nas e-shop su"."\n"."\n";
$riadok3="meno> ".$meno."   heslo> ".$heslo."\n";

$sprava=$riadok1.$riadok2.$riadok3;
$sprava = StrTr($sprava, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$emailkomu=$h_mail;

if(mail("$emailkomu;$fir_fem3","$predmet","$sprava","From: $fir_fem3"))
{
//echo "mail(".$emailkomu." ".$fir_fem3." ".$predmet." ".$sprava." From: ".$fir_fem3.")";
}
//koniec odosli mail

?>
<script type="text/javascript">
alert (" œakujeme za Vaöu registr·ciu . Ste prihl·sen˝, mÙûete pokraËovaù v n·kupe. \r PrÌstupovÈ meno a heslo V·m poöleme na mailov˙ adresu <?php echo $h_mail;?> .");
</script>
<?php
exit;
}
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
