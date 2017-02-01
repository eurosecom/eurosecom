<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1;

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$vseobj = 1*$_REQUEST['vseobj'];
$vsezaico = 1*$_REQUEST['vsezaico'];
$icox = 1*$_REQUEST['icox'];

$hladaj_uce = 1*strip_tags($_REQUEST['hladaj_uce']);
if( $hladaj_uce == 0 ) $hladaj_uce=31100;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$somvprirskl=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$docasnemazanie=0;

//nacitaj stav
if ( $copern == 1001 )
    {
$ucet = 1*$_REQUEST['ucet'];
$datum = $_REQUEST['datum'];

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prchlknihas
(
   psys         INT,
   uce          VARCHAR(10),
   zos          DECIMAL(12,2)
);
prchlknihas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$datsql=SqlDatum($datum);

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 0,uce,(pmd-pda) FROM F$kli_vxcf"."_uctosnova WHERE uce = $ucet ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT ".
" 0,ucm,(F$kli_vxcf"."_uctpokuct.hod) FROM F$kli_vxcf"."_pokpri,F$kli_vxcf"."_uctpokuct ".
" WHERE F$kli_vxcf"."_pokpri.dok=F$kli_vxcf"."_uctpokuct.dok AND ucm = $ucet AND dat <= '$datsql' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT ".
" 0,ucd,-(F$kli_vxcf"."_uctpokuct.hod) FROM F$kli_vxcf"."_pokvyd,F$kli_vxcf"."_uctpokuct ".
" WHERE F$kli_vxcf"."_pokvyd.dok=F$kli_vxcf"."_uctpokuct.dok AND ucd = $ucet AND dat <= '$datsql' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prchlknihas$kli_uzid"." SELECT".
" 1,uce,SUM(zos) ".
" FROM F$kli_vxcf"."_prchlknihas$kli_uzid".
" WHERE uce = $ucet GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$zos=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_prchlknihas$kli_uzid WHERE psys = 1 "; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
$zos = 1*$riaddok->zos;
 }

$uprtxt = "UPDATE F$kli_vxcf"."_invpok SET ".
" invstav='$zos' WHERE xdok = $cislo_dok ";
$upravene = mysql_query("$uprtxt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
 
$copern=1;
    }
//koniec nacitaj stav


//prepocitaj do minci
if ( $copern == 1002 )
    {
$uprtxt = "UPDATE F$kli_vxcf"."_invpok SET ".
" ks500e='$ks500e', suma500e='$suma500e', ks200e='$ks200e', suma200e='$suma200e', ks100e='$ks100e', suma100e='$suma100e', ".
" ks50e='$ks50e', suma50e='$suma50e', ks20e='$ks20e', suma20e='$suma20e', ks10e='$ks10e', suma10e='$suma10e', ".
" ks5e='$ks5e', suma5e='$suma5e', ks2e='$ks2e', suma2e='$suma2e', ks1e='$ks1e', suma1e='$suma1e', ".
" ks50ec='$ks50ec', suma50ec='$suma50ec', ks20ec='$ks20ec', suma20ec='$suma20ec', ks10ec='$ks10ec', suma10ec='$suma10ec', ".
" ks5ec='$ks5ec', suma5ec='$suma5ec', ks2ec='$ks2ec', suma2ec='$suma2ec', ks1ec='$ks1ec', suma1ec='$suma1ec', ".
" sumaspolu='$sumaspolu' ". 
" WHERE xdok = $cislo_dok ";
$upravene = mysql_query("$uprtxt");


$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET suma1ec=floor(invstav), suma2ec=(invstav-suma1ec)*100 ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok SET suma20ec=0, suma10ec=0 ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks500e=floor(suma1ec/500), suma20ec=suma1ec-(ks500e*500) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks200e=floor(suma20ec/200), suma20ec=suma20ec-(ks200e*200) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks100e=floor(suma20ec/100), suma20ec=suma20ec-(ks100e*100) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks50e=floor(suma20ec/50), suma20ec=suma20ec-(ks50e*50) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks20e=floor(suma20ec/20), suma20ec=suma20ec-(ks20e*20) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks10e=floor(suma20ec/10), suma20ec=suma20ec-(ks10e*10) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks5e=floor(suma20ec/5), suma20ec=suma20ec-(ks5e*5) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks2e=floor(suma20ec/2), suma20ec=suma20ec-(ks2e*2) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks1e=floor(suma20ec/1), suma20ec=suma20ec-(ks1e*1) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks50ec=floor(suma2ec/50), suma10ec=suma2ec-(ks50ec*50) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks20ec=floor(suma10ec/20), suma10ec=suma10ec-(ks20ec*20) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks10ec=floor(suma10ec/10), suma10ec=suma10ec-(ks10ec*10) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks5ec=floor(suma10ec/5), suma10ec=suma10ec-(ks5ec*5) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks2ec=floor(suma10ec/2), suma10ec=suma10ec-(ks2ec*2) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_invpok".
" SET ks1ec=floor(suma10ec/1), suma10ec=suma10ec-(ks1ec*1) ".
" WHERE xdok = $cislo_dok ";
$oznac = mysql_query("$sqtoz");

$copern=1;
    }
//prepocitaj do minci


//zapis upravenu hlavicku
if ( $copern == 11 )
    {
$invdat = strip_tags($_REQUEST['invdat']);
$invdatsql = SqlDatum($invdat);
$invucet = strip_tags($_REQUEST['invucet']);
$invmulz = strip_tags($_REQUEST['invmulz']);
$invdatzac = strip_tags($_REQUEST['invdatzac']);
$invdatzacsql = SqlDatum($invdatzac);
$invdatskc = strip_tags($_REQUEST['invdatskc']);
$invdatskcsql = SqlDatum($invdatskc);
$invohz = strip_tags($_REQUEST['invohz']);
$invozv = strip_tags($_REQUEST['invozv']);
$invstav = strip_tags($_REQUEST['invstav']);
                                            
$ks500e = strip_tags($_REQUEST['ks500e']);
$suma500e = strip_tags($_REQUEST['suma500e']);
$ks200e = strip_tags($_REQUEST['ks200e']);
$suma200e = strip_tags($_REQUEST['suma200e']);
$ks100e = strip_tags($_REQUEST['ks100e']);
$suma100e = strip_tags($_REQUEST['suma100e']);
$ks50e = strip_tags($_REQUEST['ks50e']);
$suma50e = strip_tags($_REQUEST['suma50e']);
$ks20e = strip_tags($_REQUEST['ks20e']);
$suma20e = strip_tags($_REQUEST['suma20e']);
$ks10e = strip_tags($_REQUEST['ks10e']);
$suma10e = strip_tags($_REQUEST['suma10e']);
$ks5e = strip_tags($_REQUEST['ks5e']);
$suma5e = strip_tags($_REQUEST['suma5e']);
$ks2e = strip_tags($_REQUEST['ks2e']);
$suma2e = strip_tags($_REQUEST['suma2e']);
$ks1e = strip_tags($_REQUEST['ks1e']);
$suma1e = strip_tags($_REQUEST['suma1e']);
$ks50ec = strip_tags($_REQUEST['ks50ec']);
$suma50ec = strip_tags($_REQUEST['suma50ec']);
$ks20ec = strip_tags($_REQUEST['ks20ec']);
$suma20ec = strip_tags($_REQUEST['suma20ec']);
$ks10ec = strip_tags($_REQUEST['ks10ec']);
$suma10ec = strip_tags($_REQUEST['suma10ec']);
$ks5ec = strip_tags($_REQUEST['ks5ec']);
$suma5ec = strip_tags($_REQUEST['suma5ec']);
$ks2ec = strip_tags($_REQUEST['ks2ec']);
$suma2ec = strip_tags($_REQUEST['suma2ec']);
$ks1ec = strip_tags($_REQUEST['ks1ec']);
$suma1ec = strip_tags($_REQUEST['suma1ec']);
$sumaspolu = strip_tags($_REQUEST['sumaspolu']);
$invrozdiel = strip_tags($_REQUEST['invrozdiel']);
$invpozn = strip_tags($_REQUEST['invpozn']);

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_invpok SET ".
" invdat='$invdatsql', invucet='$invucet', invmulz='$invmulz', ".
" invdatzac='$invdatzacsql', invdatskc='$invdatskcsql', ".
" invohz='$invohz', invozv='$invozv', invstav='$invstav', ".
" ks500e='$ks500e', suma500e='$suma500e', ks200e='$ks200e', suma200e='$suma200e', ks100e='$ks100e', suma100e='$suma100e', ".
" ks50e='$ks50e', suma50e='$suma50e', ks20e='$ks20e', suma20e='$suma20e', ks10e='$ks10e', suma10e='$suma10e', ".
" ks5e='$ks5e', suma5e='$suma5e', ks2e='$ks2e', suma2e='$suma2e', ks1e='$ks1e', suma1e='$suma1e', ".
" ks50ec='$ks50ec', suma50ec='$suma50ec', ks20ec='$ks20ec', suma20ec='$suma20ec', ks10ec='$ks10ec', suma10ec='$suma10ec', ".
" ks5ec='$ks5ec', suma5ec='$suma5ec', ks2ec='$ks2ec', suma2ec='$suma2ec', ks1ec='$ks1ec', suma1ec='$suma1ec', ".
" sumaspolu='$sumaspolu', invrozdiel='$invrozdiel', invpozn='$invpozn' ". 
" WHERE xdok = $cislo_dok ";

$upravene = mysql_query("$uprtxt");
  
//echo $uprtxt;
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenu hlavicku 

//prepocet nominalnej hodn. a pocet kusov
$uprtxt = "UPDATE F$kli_vxcf"."_invpok SET ".
" suma500e=500*ks500e, suma200e=200*ks200e, suma100e=100*ks100e, suma50e=50*ks50e, suma20e=20*ks20e, suma10e=10*ks10e, suma5e=5*ks5e, ".
" suma2e=2*ks2e, suma1e=1*ks1e, suma50ec=0.50*ks50ec, suma20ec=0.20*ks20ec, suma10ec=0.10*ks10ec, suma5ec=0.05*ks5ec, suma2ec=0.02*ks2ec, suma1ec=0.01*ks1ec, ".
" sumaspolu=suma500e+suma200e+suma100e+suma50e+suma20e+suma10e+suma5e+suma2e+suma1e+suma50ec+suma20ec+suma10ec+suma5ec+suma2ec+suma1ec, ".
" invrozdiel=sumaspolu-invstav ".
" WHERE xdok = $cislo_dok "; 
$upravene = mysql_query("$uprtxt");


//nacitaj udaje
if ( $copern == 1 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_invpok WHERE xdok = $cislo_dok ORDER BY xdatm DESC";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);    

//echo $sqlfir;

$invdat = $fir_riadok->invdat;
$invdatsk = SkDatum($invdat);
$invucet = $fir_riadok->invucet;
$invmulz = $fir_riadok->invmulz;
$invdatzac = $fir_riadok->invdatzac;
$invdatzacsk = SkDatum($invdatzac);
$invdatskc = $fir_riadok->invdatskc;
$invdatskcsk = SkDatum($invdatskc);
$invohz = $fir_riadok->invohz;
$invozv = $fir_riadok->invozv;

$invstav = $fir_riadok->invstav;
$ks500e = $fir_riadok->ks500e;
$suma500e = $fir_riadok->suma500e;
$ks200e = $fir_riadok->ks200e;
$suma200e = $fir_riadok->suma200e;
$ks100e = $fir_riadok->ks100e;
$suma100e = $fir_riadok->suma100e;
$ks50e = $fir_riadok->ks50e;
$suma50e = $fir_riadok->suma50e;
$ks20e = $fir_riadok->ks20e;
$suma20e = $fir_riadok->suma20e;
$ks10e = $fir_riadok->ks10e;
$suma10e = $fir_riadok->suma10e;
$ks5e = $fir_riadok->ks5e;
$suma5e = $fir_riadok->suma5e;
$ks2e = $fir_riadok->ks2e;
$suma2e = $fir_riadok->suma2e;
$ks1e = $fir_riadok->ks1e;
$suma1e = $fir_riadok->suma1e;
$ks50ec = $fir_riadok->ks50ec;
$suma50ec = $fir_riadok->suma50ec;
$ks20ec = $fir_riadok->ks20ec;
$suma20ec = $fir_riadok->suma20ec;
$ks10ec = $fir_riadok->ks10ec;
$suma10ec = $fir_riadok->suma10ec;
$ks5ec = $fir_riadok->ks5ec;
$suma5ec = $fir_riadok->suma5ec;
$ks2ec = $fir_riadok->ks2ec;
$suma2ec = $fir_riadok->suma2ec;
$ks1ec = $fir_riadok->ks1ec;
$suma1ec = $fir_riadok->suma1ec;
$sumaspolu = $fir_riadok->sumaspolu;
$invrozdiel = $fir_riadok->invrozdiel;
$invpozn = $fir_riadok->invpozn;

//echo $xdatvsk;

mysql_free_result($fir_vysledok);
    }
//koniec nacitania
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pokladnièná inventúra</title>
<style type="text/css">
img { border:none; }
a.btn-prepni {
  font-size: 14px;
  text-decoration: none;
  color: white;
  padding: 3px 15px;  
  background-color: #ABD159;  
  border: 1px solid #86A83D;
  font-family: Helvetica, Geneva, Verdana, sans-serif;
  position: relative;
  top: -3px;
}
input.fill { padding-left: 1px; }
input.nofill { padding: 1px 0 1px 2px; }
table.hlava {
  width: 100%;
  background-color: lightblue;
  border-collapse: collapse;
  font-size: 13px;
  margin-top: 7px;
}
table.skutok td {
  text-align: center;
  border: 2px solid #FFFF90;                
}
table.skutok input {
  text-align: right;
  padding: 1px 3px 0 0;
  font-size: 12px;
  width: 90%; 
}
input { font-size: 12px; }
</style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
function ZmazPolozku(plu, dok)
                {
var plux = plu;
var dokx = dok;
window.open('invpok_u.php?copern=6101&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazPolozkuUplne(plu, dok)
                {
var plux = plu;
var dokx = dok;
window.open('invpok_u.php?copern=6002&drupoh=1&page=1&plux='+ plux + '&cislo_dok='+ dokx + '&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function SpatZoznam()
                {
window.open('../invpok/invpok.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacINV(plu)
                {
var plux = plu;
window.open('invpok_t.php?copern=1&drupoh=1&page=1&cislo_dok=' + plux + '&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function NovaOBJ()
                {
window.open('invpok.php?copern=7701&drupoh=1&page=1&plux=0&ffd=0&zmtz=<?php echo $zmtz; ?>', '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function invDatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invucet.focus();
        document.forms.formv1.invucet.select();
              }
                }

function invUcetEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invmulz.focus();
        document.forms.formv1.invmulz.select();
              }
                }

function invMulzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invdatzac.focus();
        document.forms.formv1.invdatzac.select();
              }
                }

function invDatzacEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invdatskc.focus();
        document.forms.formv1.invdatskc.select();
              }
                }

function invDatskcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invohz.focus();
        document.forms.formv1.invohz.select();
              }
                }

function invOhzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invozv.focus();
        document.forms.formv1.invozv.select();
              }
                }

function invOzvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.invstav.focus();
        document.forms.formv1.invstav.select();
              }
                }

function invStavEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks500e.focus();
        document.forms.formv1.ks500e.select();
              }
                }

function invKs500eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks200e.focus();
        document.forms.formv1.ks200e.select();
              }
                }

function invKs200eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks100e.focus();
        document.forms.formv1.ks100e.select();
              }
                }

function invKs100eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks50e.focus();
        document.forms.formv1.ks50e.select();
              }
                }

function invKs50eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks20e.focus();
        document.forms.formv1.ks20e.select();
              }
                }

function invKs20eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks10e.focus();
        document.forms.formv1.ks10e.select();
              }
                }

function invKs10eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks5e.focus();
        document.forms.formv1.ks5e.select();
              }
                }

function invKs5eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks2e.focus();
        document.forms.formv1.ks2e.select();
              }
                }

function invKs2eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks1e.focus();
        document.forms.formv1.ks1e.select();
              }
                }

function invKs1eEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks50ec.focus();
        document.forms.formv1.ks50ec.select();
              }
                }

function invKs50ecEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks20ec.focus();
        document.forms.formv1.ks20ec.select();
              }
                }

function invKs20ecEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks10ec.focus();
        document.forms.formv1.ks10ec.select();
              }
                }

function invKs10ecEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks5ec.focus();
        document.forms.formv1.ks5ec.select();
              }
                }

function invKs5ecEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks2ec.focus();
        document.forms.formv1.ks2ec.select();
              }
                }

function invKs2ecEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
        document.forms.formv1.ks1ec.focus();
        document.forms.formv1.ks1ec.select();
              }
                }

//function invKs1ecEnter(e)
//                {
//  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
//  if(k == 13 ){
//        document.forms.formv1.invpozn.focus();
//        document.forms.formv1.invpozn.select();
//              }
//                }

function xHddEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 13 ){
              document.forms.formv1.submit(); return (true);
              }
                }

function CiarkaNaBodku(Vstup, e)
    {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy
  if(k == 188 ){
               Vstup.value=Vstup.value.replace(",","."); 
               }
    }
</script>

<script type="text/javascript">
<?php
//uprava hlavicka
  if ( $copern == 1 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.invdat.value = '<?php echo "$invdat";?>';
    document.formv1.invdat.value = '<?php echo "$invdatsk";?>';
    document.formv1.invucet.value = '<?php echo "$invucet";?>';
    document.formv1.invmulz.value = '<?php echo "$invmulz";?>';
    document.formv1.invdatzac.value = '<?php echo "$invdatzac";?>';
    document.formv1.invdatzac.value = '<?php echo "$invdatzacsk";?>';
    document.formv1.invdatskc.value = '<?php echo "$invdatskc";?>';
    document.formv1.invdatskc.value = '<?php echo "$invdatskcsk";?>';
    document.formv1.invohz.value = '<?php echo "$invohz";?>';
    document.formv1.invozv.value = '<?php echo "$invozv";?>';
    document.formv1.invstav.value = '<?php echo "$invstav";?>';
    document.formv1.ks500e.value = '<?php echo "$ks500e";?>';
    document.formv1.suma500e.value = '<?php echo "$suma500e";?>';
    document.formv1.ks200e.value = '<?php echo "$ks200e";?>';
    document.formv1.suma200e.value = '<?php echo "$suma200e";?>';
    document.formv1.ks100e.value = '<?php echo "$ks100e";?>';
    document.formv1.suma100e.value = '<?php echo "$suma100e";?>';
    document.formv1.ks50e.value = '<?php echo "$ks50e";?>';
    document.formv1.suma50e.value = '<?php echo "$suma50e";?>';
    document.formv1.ks20e.value = '<?php echo "$ks20e";?>';
    document.formv1.suma20e.value = '<?php echo "$suma20e";?>';
    document.formv1.ks10e.value = '<?php echo "$ks10e";?>';
    document.formv1.suma10e.value = '<?php echo "$suma10e";?>';
    document.formv1.ks5e.value = '<?php echo "$ks5e";?>';
    document.formv1.suma5e.value = '<?php echo "$suma5e";?>';
    document.formv1.ks2e.value = '<?php echo "$ks2e";?>';
    document.formv1.suma2e.value = '<?php echo "$suma2e";?>';
    document.formv1.ks1e.value = '<?php echo "$ks1e";?>';
    document.formv1.suma1e.value = '<?php echo "$suma1e";?>';
    document.formv1.ks50ec.value = '<?php echo "$ks50ec";?>';
    document.formv1.suma50ec.value = '<?php echo "$suma50ec";?>';
    document.formv1.ks20ec.value = '<?php echo "$ks20ec";?>';
    document.formv1.suma20ec.value = '<?php echo "$suma20ec";?>';
    document.formv1.ks10ec.value = '<?php echo "$ks10ec";?>';
    document.formv1.suma10ec.value = '<?php echo "$suma10ec";?>';
    document.formv1.ks5ec.value = '<?php echo "$ks5ec";?>';
    document.formv1.suma5ec.value = '<?php echo "$suma5ec";?>';
    document.formv1.ks2ec.value = '<?php echo "$ks2ec";?>';
    document.formv1.suma2ec.value = '<?php echo "$suma2ec";?>';
    document.formv1.ks1ec.value = '<?php echo "$ks1ec";?>';
    document.formv1.suma1ec.value = '<?php echo "$suma1ec";?>';
    document.formv1.sumaspolu.value = '<?php echo "$sumaspolu";?>';
    document.formv1.invrozdiel.value = '<?php echo "$invrozdiel";?>';
//  document.formv1.invpozn.value = '<?php echo "$invpozn";?>';
    document.formv1.uloz.disabled = true;
    document.formv1.invdat.focus();
    document.formv1.invdat.select();
    }
<?php
//koniec uprava
  }
?>

function NacitajStav()
                {
    var ucet = document.formv1.invucet.value;
    var datum = document.formv1.invdat.value;

window.open('invpok_u.php?copern=1001&ucet='+ ucet + '&datum=' + datum + '&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_self' );
                }

function PrepocitajMince()
                {
window.open('invpok_u.php?copern=1002&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&ffd=0&tlacobj=1&zmtz=<?php echo $zmtz; ?>', '_self' );
                }

</script>
</HEAD>

<BODY class="white" onload="ObnovUI();">
<table class="h2" width="100%" style="margin-bottom:0;" >
<tr>
<td align="left">EuroSecom - Inventúrny súpis pokladne</td>
<td align="right"><span class="login"><?php echo "$kli_vxcf-$kli_nxcf | $kli_uzmeno $kli_uzprie/$kli_uzid ";?></span></td>
</tr>
</table>

<?php
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_invpok".
" WHERE xdok = $cislo_dok ORDER BY xdatm ";

//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$skdatum=SkDatum($riadok->xdatm);
?>

<?php
//prva polozka
if ( $j == 0 )
        {
?>

<?php
//formular vyplnatelny
if ( $copern == 1 )
     {
?>
<FORM name="formv1" method="post" action="invpok_u.php?copern=11&cislo_dok=<?php echo $cislo_dok; ?>" style="background-color:white; display:inline;" >

<table class="hlava">
<tr>
<td width="10%"></td><td width="20%"></td><td width="20%"></td><td width="20%"></td><td width="30%" style="background-color:white;"></td>
</tr>
<tr>
<td align="right"><strong>Èíslo</strong>&nbsp;</td> 
<td>
<input type="text" name="cislo_dok" id="cislo_dok" value="<?php echo $cislo_dok; ?>" size="5" maxlength="10" disabled="disabled" class="nofill" />
</td>
<td align="right"><strong>Dátum</strong>&nbsp;</td>
<td>
<input type="text" name="invdat" id="invdat" class="fill" size="10" maxlength="10" onKeyDown="return invDatEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />&nbsp;&nbsp;
<img onclick="TlacINV(<?php echo $cislo_dok; ?>);" src='../obr/tlac.png' width=20 height=15 title='Tlaèi inventúru'>
</td>
<td class="fmenu" align="right">
<a href="#" onclick="SpatZoznam();" class="btn-prepni" ><img src="../obr/back_white.png" alt="Spä na zoznam inventúr" title="Spä na zoznam inventúr" height="16" width="16" style="vertical-align:middle;">&nbsp;Zoznam</a>
</td>
</tr>

<tr>
<td align="right"><strong>Pokladòa</strong>&nbsp;</td>
<td>
<input type="text" name="invucet" id="invucet" class="fill" size="10" maxlength="6" onKeyDown="return invUcetEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
</td>
<td align="right"><strong>Miesto uloženia</strong>&nbsp;</td>
<td colspan="2">
<input type="text" name="invmulz" id="invmulz" class="fill" size="30" onKeyDown="return invMulzEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
</td>
</tr>

<tr>
<td align="right"><strong>Deò</strong> zaèatia&nbsp;</td>  
<td>
<input type="text" name="invdatzac" id="invdatzac" class="fill" size="10" maxlength="10" onKeyDown="return invDatzacEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
</td>
<td align="right">
<strong>Osoba</strong> hmotne zodpovedná&nbsp;
</td>
<td colspan="2" >
<input type="text" name="invohz" id="invohz" class="fill" size="30" onKeyDown="return invOhzEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
</td>
</tr>
  
<tr>
<td align="right">skonèenia&nbsp;</td>
<td>
<input type="text" name="invdatskc" id="invdatskc" class="fill" size="10" maxlength="10" onKeyDown="return invDatskcEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
<strong>inventúry</strong>
</td>
<td align="right">Zodpovedná za vykonanie&nbsp;</td>
<td colspan="2">
<input type="text" name="invozv" id="invozv" class="fill" size="30" onKeyDown="return invOzvEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
<strong>inventúry</strong>
</td>
</tr>

<tr><td colspan="5" style="height:5px; background-color:white;"></td></tr>
<tr><td colspan="5" style="height:5px; background-color:lightblue;"></td></tr>

<tr>
<td align="right"><strong>Stav pokladne:</strong>&nbsp;</td>
<td class="pvstuz">
<input type="text" name="invstav" id="invstav" class="fill" style="text-align:right; padding-right:3px;" size="15" onKeyDown="return invStavEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" />
&nbsp;
<img src="../obr/orig.png" onclick="NacitajStav();" title="Naèíta stav z úètovníctva" height="15" width="15">
&nbsp;&nbsp;
<img src="../obr/ziarovka.png" onclick="PrepocitajMince();" title="Prepoèíta skutoèný stav pokladne" height="15" width="15">
&nbsp;&nbsp;
<img src="../obr/pozor.png" title="Pred naèítaním alebo prepoèítaním nastavte úèet a dátum a uložte hodnoty" height="15" width="15">
</td>
<td colspan="2" >
<table style="font-size:11px; border-collapse:collapse;" width="100%"> 
<tr>
<th width="30%">Nominálna hodn.</th><th width="30%">Poèet kusov</th><th width="40%">Suma</th>
</tr>
</table>
</td>
<td align="right">&nbsp;</td>
</tr>

<tr>
<td align="right" rowspan="16" valign="top" ><strong>Skutoèný stav:</strong>&nbsp;</td>
<td rowspan="16" valign="bottom">&nbsp;</td>
<td colspan="2" rowspan="16" align="center">
<table class="skutok" width="100%" style="font-size:12px; border-collapse:collapse;" >
<tr>
<th width="30%">500</th>
<td width="30%"><input type="text" name="ks500e" id="ks500e" onKeyDown="return invKs500eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td width="40%"><input type="text" name="suma500e" id="suma500e" value="<?php echo $suma500e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>200</th>
<td><input type="text" name="ks200e" id="ks200e" onKeyDown="return invKs200eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma200e" id="suma200e" value="<?php echo $suma200e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>100</th>
<td><input type="text" name="ks100e" id="ks100e" onKeyDown="return invKs100eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma100e" id="suma100e" value="<?php echo $suma100e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>50</th>
<td><input type="text" name="ks50e" id="ks50e" onKeyDown="return invKs50eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma50e" id="suma50e" value="<?php echo $suma50e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>20</th>
<td><input type="text" name="ks20e" id="ks20e" onKeyDown="return invKs20eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma20e" id="suma20e" value="<?php echo $suma20e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>10</th>
<td><input type="text" name="ks10e" id="ks10e" onKeyDown="return invKs10eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma10e" id="suma10e" value="<?php echo $suma10e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>5</th>
<td><input type="text" name="ks5e" id="ks5e" onKeyDown="return invKs5eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma5e" id="suma5e" value="<?php echo $suma5e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>2</th>
<td><input type="text" name="ks2e" id="ks2e" onKeyDown="return invKs2eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma2e" id="suma2e" value="<?php echo $suma2e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>1</th>
<td><input type="text" name="ks1e" id="ks1e" onKeyDown="return invKs1eEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma1e" id="suma1e" value="<?php echo $suma1e; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,50</th>
<td><input type="text" name="ks50ec" id="ks50ec" onKeyDown="return invKs50ecEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma50ec" id="suma50ec" value="<?php echo $suma50ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,20</th>
<td><input type="text" name="ks20ec" id="ks20ec" onKeyDown="return invKs20ecEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma20ec" id="suma20ec" value="<?php echo $suma20ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,10</th>
<td><input type="text" name="ks10ec" id="ks10ec" onKeyDown="return invKs10ecEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma10ec" id="suma10ec" value="<?php echo $suma10ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,05</th>
<td><input type="text" name="ks5ec" id="ks5ec" onKeyDown="return invKs5ecEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma5ec" id="suma5ec" value="<?php echo $suma5ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,02</th>
<td><input type="text" name="ks2ec" id="ks2ec" onKeyDown="return invKs2ecEnter(event.which);" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma2ec" id="suma2ec" value="<?php echo $suma2ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>0,01</th>
<td><input type="text" name="ks1ec" id="ks1ec" onkeyup="CiarkaNaBodku(this, event.which);" /></td>
<td><input type="text" name="suma1ec" id="suma1ec" value="<?php echo $suma1ec; ?>" disabled="disabled" /></td>
</tr>
<tr>
<th>Spolu</th><th></th>
<td class="pvstuz">
<input type="text" name="sumaspolu" id="sumaspolu" disabled="disabled" />
</td>
</tr>
</table>
</td>
<td rowspan="16" >&nbsp;</td>
</tr>
</table>

<table width="100%" style="border-collapse:collapse; font-size:12px; background-color:lightblue;">
<tr>
<td width="10%" align="right"><strong>Rozdiel:</strong>&nbsp;</td>
<td class="pvstuz" width="20%">
<input type="text" name="invrozdiel" id="invrozdiel" size="15" class="nofill" style="text-align:right; padding-right:3px;" value="<?php echo $invrozdiel; ?>" disabled="disabled" />
</td><td width="70%"></td>
</tr>
<tr><td colspan="3" style="height:3px;" ></td></tr>
</table>

<div style="display:none;">Poznámky:<textarea name="invpozn" id="invpozn"></textarea></div>

<div style="margin-top:3px; text-align:left;">
<INPUT type="submit" id="uloz" name="uloz" value="Uloži inventúru" style="font-size:14px;" > <!-- po uložení hodí do zoznamu -->
<SPAN id="uvolni" onmouseover="document.formv1.uloz.disabled = false;">&nbsp;</SPAN>
</div>
<table>
<tr>
<td>
</td>
</tr>
</table>
</FORM>

<?php
//koniec hlavicka vyplnatelna copern=1   
     }
?>

<?php
        }
//koniec hlavicky j=0
?>


<?php
}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
