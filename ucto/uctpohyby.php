<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 1000;
//$cslm=310;
$cslm=103200;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];

$citfir = include("../cis/citaj_fir.php");

$dnesne = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
//echo $dnesne;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//datum pociatkov a konca mesiaca
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   dat01p          DATE,
   dat01k          DATE,
   dat02p          DATE,
   dat02k          DATE,
   dat03p          DATE,
   dat03k          DATE,
   dat04p          DATE,
   dat04k          DATE,
   dat05p          DATE,
   dat05k          DATE,
   dat06p          DATE,
   dat06k          DATE,
   dat07p          DATE,
   dat07k          DATE,
   dat08p          DATE,
   dat08k          DATE,
   dat09p          DATE,
   dat09k          DATE,
   dat10p          DATE,
   dat10k          DATE,
   dat11p          DATE,
   dat11k          DATE,
   dat12p          DATE,
   dat12k          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vyb_ume=$kli_vume;
$pole = explode(".", $vyb_ume);
$vyb_mume=$pole[0];
$vyb_rume=$pole[1];
if( $vyb_mume < 10 ) $vyb_mume="0".$vyb_mume;


$dat01p_ume=$vyb_rume.'-01-01';
$dat01k_ume=$vyb_rume.'-01-01';
$dat02p_ume=$vyb_rume.'-02-01';
$dat02k_ume=$vyb_rume.'-02-01';
$dat03p_ume=$vyb_rume.'-03-01';
$dat03k_ume=$vyb_rume.'-03-01';
$dat04p_ume=$vyb_rume.'-04-01';
$dat04k_ume=$vyb_rume.'-04-01';
$dat05p_ume=$vyb_rume.'-05-01';
$dat05k_ume=$vyb_rume.'-05-01';
$dat06p_ume=$vyb_rume.'-06-01';
$dat06k_ume=$vyb_rume.'-06-01';
$dat07p_ume=$vyb_rume.'-07-01';
$dat07k_ume=$vyb_rume.'-07-01';
$dat08p_ume=$vyb_rume.'-08-01';
$dat08k_ume=$vyb_rume.'-08-01';
$dat09p_ume=$vyb_rume.'-09-01';
$dat09k_ume=$vyb_rume.'-09-01';
$dat10p_ume=$vyb_rume.'-10-01';
$dat10k_ume=$vyb_rume.'-10-01';
$dat11p_ume=$vyb_rume.'-11-01';
$dat11k_ume=$vyb_rume.'-11-01';
$dat12p_ume=$vyb_rume.'-12-01';
$dat12k_ume=$vyb_rume.'-12-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid.
" ( dat01p,dat01k,dat02p,dat02k,dat03p,dat03k,dat04p,dat04k,dat05p,dat05k,dat06p,dat06k,".
"dat07p,dat07k,dat08p,dat08k,dat09p,dat09k,dat10p,dat10k,dat11p,dat11k,dat12p,dat12k,fic ) VALUES ".
" ( '$dat01p_ume', '$dat01k_ume', '$dat02p_ume', '$dat02k_ume', '$dat03p_ume', '$dat03k_ume', '$dat04p_ume', '$dat04k_ume',".
"   '$dat05p_ume', '$dat05k_ume', '$dat06p_ume', '$dat06k_ume', '$dat07p_ume', '$dat07k_ume', '$dat08p_ume', '$dat08k_ume',".
"   '$dat09p_ume', '$dat09k_ume', '$dat10p_ume', '$dat102k_ume', '$dat11p_ume', '$dat11k_ume', '$dat12p_ume', '$dat12k_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET dat01k=LAST_DAY('$dat01k_ume'), dat02k=LAST_DAY('$dat02k_ume'), dat03k=LAST_DAY('$dat03k_ume'), dat04k=LAST_DAY('$dat04k_ume'),".
"     dat05k=LAST_DAY('$dat05k_ume'), dat06k=LAST_DAY('$dat06k_ume'), dat07k=LAST_DAY('$dat07k_ume'), dat08k=LAST_DAY('$dat08k_ume'),".
"     dat09k=LAST_DAY('$dat09k_ume'), dat10k=LAST_DAY('$dat10k_ume'), dat11k=LAST_DAY('$dat11k_ume'),".
" dat12k=LAST_DAY('$dat12k_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $dat01p_ume=SkDatum($riadok->dat01p);
  $dat01k_ume=SkDatum($riadok->dat01k);
  $dat02p_ume=SkDatum($riadok->dat02p);
  $dat02k_ume=SkDatum($riadok->dat02k);
  $dat03p_ume=SkDatum($riadok->dat03p);
  $dat03k_ume=SkDatum($riadok->dat03k);
  $dat04p_ume=SkDatum($riadok->dat04p);
  $dat04k_ume=SkDatum($riadok->dat04k);
  $dat05p_ume=SkDatum($riadok->dat05p);
  $dat05k_ume=SkDatum($riadok->dat05k);
  $dat06p_ume=SkDatum($riadok->dat06p);
  $dat06k_ume=SkDatum($riadok->dat06k);
  $dat07p_ume=SkDatum($riadok->dat07p);
  $dat07k_ume=SkDatum($riadok->dat07k);
  $dat08p_ume=SkDatum($riadok->dat08p);
  $dat08k_ume=SkDatum($riadok->dat08k);
  $dat09p_ume=SkDatum($riadok->dat09p);
  $dat09k_ume=SkDatum($riadok->dat09k);
  $dat10p_ume=SkDatum($riadok->dat10p);
  $dat10k_ume=SkDatum($riadok->dat10k);
  $dat11p_ume=SkDatum($riadok->dat11p);
  $dat11k_ume=SkDatum($riadok->dat11k);
  $dat12p_ume=SkDatum($riadok->dat12p);
  $dat12k_ume=SkDatum($riadok->dat12k);
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>V˝pis ˙Ëtovn˝ch pohybov</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="sal_ucet_xml.js"></script>

<script type="text/javascript">
var sirkawin = screen.width-10;
var vyskawin = screen.height-10;

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

//posuny Enter[[[[[[[[[[[



function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_uce.value != ''  )
        {
        New.style.display="none";
        myUcetelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajUcet();
        }      

        if( document.forms1.h_uce.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }


function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.forms1.h_nai.value != '' )
        {
        New.style.display="none";
        myUcetelement.style.display='none';
        document.forms1.h_uce.value = ""; 
        volajUcet();
        }   

        if( document.forms1.h_nai.value == "" ) { document.forms1.h_ico.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky Ucet
function vykonajUcet(ucet,nai,mes,prm1,prm2,prm3,prm4)
                {
        document.forms.forms1.h_uce.value = ucet;
        document.forms.forms1.h_nai.value = nai;
        document.forms.forms1.h_mes.value = mes;
        myUcetelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                }


function Len1Ucet()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        myUcetelement.style.display='none';
                    }

function Len0Ucet()
                    {
        New.style.display="";
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                    }


function VyberVstup()
                {
        document.forms.forms1.h_datp.value='<?php echo $dat01p_ume;?>';
        document.forms.forms1.h_datk.value='<?php echo $dat12k_ume;?>';
        document.forms.forms1.h_uce.focus();
        document.forms.forms1.h_uce.select(); 
                }

function TlacIco()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_icoxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function SumaIco()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_icoxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML&sico=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NumaIco()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_icoxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML&sico=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function FumaIco()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_icoxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML&sico=3',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacFak()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_fakxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDat()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_datxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacPolozky()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_polxxl.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=31&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDoklad()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_dokxxl.php?uctpohyby=1&cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=40&drupoh=11&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacInventura()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;

window.open('../ucto/uctpohyby_invxxl.php?uctpohyby=1&cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + 
 '&h_datk=' + h_datk + '&h_datp=' + h_datp + '&copern=40&drupoh=11&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Celyrok()
                {
document.forms.forms1.h_obdp.value=0;
document.forms.forms1.h_obdk.value=0;
document.forms.forms1.h_datp.value='<?php echo $dat01p_ume;?>';
document.forms.forms1.h_datk.value='<?php echo $dat12k_ume;?>';
                }

function Stvrtrok1()
                {
document.forms.forms1.h_obdp.value=1;
document.forms.forms1.h_obdk.value=3;
document.forms.forms1.h_datp.value='<?php echo $dat01p_ume;?>';
document.forms.forms1.h_datk.value='<?php echo $dat03k_ume;?>';
                }

function Stvrtrok2()
                {
document.forms.forms1.h_obdp.value=4;
document.forms.forms1.h_obdk.value=6;
document.forms.forms1.h_datp.value='<?php echo $dat04p_ume;?>';
document.forms.forms1.h_datk.value='<?php echo $dat06k_ume;?>';
                }

function Stvrtrok3()
                {
document.forms.forms1.h_obdp.value=7;
document.forms.forms1.h_obdk.value=9;
document.forms.forms1.h_datp.value='<?php echo $dat07p_ume;?>';
document.forms.forms1.h_datk.value='<?php echo $dat09k_ume;?>';
                }

function Stvrtrok4()
                {
document.forms.forms1.h_obdp.value=10;
document.forms.forms1.h_obdk.value=12;
document.forms.forms1.h_datp.value='<?php echo $dat10p_ume;?>';
document.forms.forms1.h_datk.value='<?php echo $dat12k_ume;?>';
                }


function Vynuluj()
                {
myUcetelement.style.display='none';
New.style.display='none';
document.forms.forms1.h_uce.value='';
document.forms.forms1.h_nai.value='';
document.forms.forms1.h_nai.focus();
                }

function Dnesne()
                {
document.forms.forms1.h_obdp.value=0;
document.forms.forms1.h_obdk.value=0;
document.forms.forms1.h_datp.value='<?php echo $dnesne;?>';
document.forms.forms1.h_datk.value='<?php echo $dnesne;?>';
                }

  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  V˝pis ˙Ëtovn˝ch pohybov</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="fmenu" width="100%" >

<tr>
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="25%">
<td class="hmenu" width="10%">
<td class="hmenu" width="25%">
<a href="#" onClick="SumaIco();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O aj sumy za I»O' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O aj sumy za I»O'>SICO </a>
<a href="#" onClick="NumaIco();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O aj sumy za I»O len nenulovÈ' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O aj sumy za I»O len nenulovÈ'>NICO </a>
<a href="#" onClick="FumaIco();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O,fakt˙ry aj sumy za I»O len nenulovÈ I»O,fakt˙ra' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O,fakt˙ry aj sumy za I»O len nenulovÈ I»O,fakt˙ra'>NICF </a>

</tr>

<tr>
<td class="hmenu" width="10%">Odbobie od
<td class="hmenu" width="10%">Obdobie do
<td class="hmenu" width="10%">⁄Ëet
<td class="hmenu" width="25%">N·zov
<td class="hmenu" width="10%">NepouûitÈ
<td class="hmenu" width="25%">
<a href="#" onClick="TlacPolozky();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky' title='JednotlivÈ ˙ËtovnÈ poloûky'>POL </a>
<a href="#" onClick="TlacDoklad();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='Pohyby sumarizovanÈ za doklad ' title='Pohyby sumarizovanÈ za doklad '>DOK </a>
<a href="#" onClick="TlacFak();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa fakt˙ry' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa fakt˙ry'>FKT </a>
<a href="#" onClick="TlacIco();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa I»O'>ICO </a>
<a href="#" onClick="TlacDat();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 alt='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa d·tumu' title='JednotlivÈ ˙ËtovnÈ poloûky zoradenÈ podæa d·tumu'>DAT </a>
<a href="#" onClick="TlacInventura();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 title='Pohyby sumarizovanÈ za doklad a invent˙rny zostatok'>INV </a>

</tr>

<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<select size="1" name="h_obdp" id="h_obdp" >
<option value="0" >Vöetko</option>
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>

<td class="hmenu">
<select size="1" name="h_obdk" id="h_obdk" >
<option value="0" >Vöetko</option>
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

<td class="hmenu"><input type="text" name="h_uce" id="h_uce" size="10" 
onclick=" myUcetelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_mes.value = '';"
 onKeyDown="return UceEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nai" id="h_nai" size="50" value="<?php echo $h_nai;?>" 
onclick="myUcetelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_mes.value = '';
 document.forms.forms1.h_nai.select();"
 onKeyDown="return NaiEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="1" onclick="myUcetelement.style.display='none'; New.style.display='none'; volajUcet();" 
alt="Hæadaj zadanÈ ËÌslo alebo n·zov ˙Ëtu" title="Hæadaj zadanÈ ËÌslo alebo n·zov ˙Ëtu" >

<td class="hmenu"><input type="text" name="h_mes" id="h_mes" size="25" disabled="disabled" /> 

</tr>

<tr>
<td class="hmenu"><input type="text" name="h_datp" id="h_datp" size="10" maxlength="10" />
<td class="hmenu"><input type="text" name="h_datk" id="h_datk" size="10" maxlength="10" />
<td class="hmenu" colspan="3">
ätvrùrok 
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok1();">1.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok2();">2.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok3();">3.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok4();">4.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Celyrok();">Cel˝ rok</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Dnesne();">Dnes</a>&nbsp;&nbsp;
<td class="obyc" align="right">
<img src='../obr/hladaj.png' border="1" onclick="Vynuluj(); Celyrok();" 
alt="Vynulovaù formul·r" title="Vynulovaù formul·r" >
NovÈ hæadanie</button></td>
</tr>

</FORM>
</table>

<div id="myUcetelement"></div>
<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som ˙Ëet podæa zadan˝ch podmienok, sk˙ste znovu</span>


<?php

// celkovy koniec dokumentu

$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
