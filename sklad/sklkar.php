<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 1000;
$cslm=403100;
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
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];

$h_cis = $_REQUEST['h_cis'];
$h_nat = $_REQUEST['h_nat'];
$h_skl = $_REQUEST['h_skl'];

$citfir = include("../cis/citaj_fir.php");


//pozri do sklfak a oprav nulove cen
if( $fir_xsk04 == 1 ) {


$dsqlt = "DROP TABLE F$kli_vxcf"."_sklzaspriemer ";
$dsql = mysql_query("$dsqlt");

$kli_vxcfskl=$kli_vxcf;
$priemer = include("sklzaspriemer.php");


$sqlttxc = "SELECT * FROM F$kli_vxcf"."_sklfak WHERE cen = 0  ";
$tovxc = mysql_query("$sqlttxc");
$tvpolxc = mysql_num_rows($tovxc);


if( $kli_uzid > 0 )
 {

$sqlttx = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE tl3 = 1  ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
          
$ix=0;

  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);

$cenazprijmu=0;
$poslhh = "SELECT * FROM F$kli_vxcf"."_sklpri WHERE cis = $riadokx->cis ORDER BY dat DESC ";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $cenazprijmu = 1*$posled->cen;
  $cis = $posled->cis;
  }

$cenahranica1=0.4*$cenazprijmu; $cenahranica2=1.5*$cenazprijmu;
if( $_SERVER['SERVER_NAME'] == "www.mlynzahorie.sk" ) { $cenahranica1=0.9*$cenazprijmu; $cenahranica2=1.1*$cenazprijmu; }

if( $cenazprijmu > 0 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=$cenazprijmu WHERE cis = $riadokx->cis AND ( cen < $cenahranica1 OR cen > $cenahranica2 ) ";
$dsql = mysql_query("$dsqlt");
  }

}
$ix=$ix+1;
  }

 }
//koniec ak kliuzid > 0

$dsqlt = "UPDATE F$kli_vxcf"."_sklfak,F$kli_vxcf"."_sklzaspriemer SET F$kli_vxcf"."_sklfak.cen=F$kli_vxcf"."_sklzaspriemer.cen ".
" WHERE F$kli_vxcf"."_sklfak.cis=F$kli_vxcf"."_sklzaspriemer.cis AND F$kli_vxcf"."_sklfak.cen=0 ";
$dsql = mysql_query("$dsqlt");

if( $tvpolxc > 0 )
  {
$dsqlt = "DROP TABLE F$kli_vxcf"."_sklzaspriemer ";
$dsql = mysql_query("$dsqlt");

$kli_vxcfskl=$kli_vxcf;
$priemer = include("sklzaspriemer.php");
  }
                      }
//koniec pozri do sklfak a oprav nulove cen



//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprckar'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   drp         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   skl         INT,
   poh         INT,
   ico         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   vdj         DECIMAL(10,3),
   prj         DECIMAL(10,3)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprckar'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//poc.stav
$psume="1".$kli_vrok;
$psdat=$kli_vrok."-01-01";
//echo $psdat;

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 0,'$psume','$psdat',1,skl,1,0,cis,mno,cen,(mno),'0',(mno) FROM F$kli_vxcf"."_sklpoc WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 1,ume,dat,dok,skl,poh,ico,cis,mno,cen,(mno),'0',(mno) FROM F$kli_vxcf"."_sklpri WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 2,ume,dat,dok,skl,poh,ico,cis,mno,cen,-(mno),(mno),'0' FROM F$kli_vxcf"."_sklvyd WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 3,ume,dat,dok,skl,poh,ico,cis,mno,cen,-(mno),(mno),'0' FROM F$kli_vxcf"."_sklfak WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 4,ume,dat,dok,skl,poh,0,cis,mno,cen,-(mno),(mno),'0' FROM F$kli_vxcf"."_sklpre WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT 4,ume,dat,dok,sk2,poh,0,cis,mno,cen,(mno),'0',(mno) FROM F$kli_vxcf"."_sklpre WHERE cis > 0".
" ORDER BY skl,poh,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//group za skl,poh,cis,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprckar".$kli_uzid.
" SELECT drp,ume,dat,dok,skl,poh,ico,cis,mno,cen,SUM(zas),SUM(vdj),SUM(prj) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,poh,cis,cen,dat,dok".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Skladové karty</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="../ajax/skl_kar_xml.js"></script>
<script type="text/javascript" src="../ajax/skl_karta_xml.js"></script>

<script type="text/javascript">
//posuny Enter[[[[[[[[[[[



function SluEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if( document.forms.forms1.h_slu.value != ''  )
        {
        New.style.display="none";
        mySklkarelement.style.display='none';
        document.forms.forms1.h_nsl.value = '';
        volajSklkar();
        }      

        if( document.forms1.h_slu.value == "" ) {  document.forms1.h_nsl.focus(); }

              }
                }


function NslEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if(document.forms.forms1.h_nsl.value != '' )
        {
        New.style.display="none";
        mySklkarelement.style.display='none';
        document.forms1.h_slu.value = ""; 
        volajSklkar();
        }   

        if( document.forms1.h_nsl.value == "" ) { document.forms1.h_slu.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky sklkar
function vykonajSklkar(slu,nazov,dph,mer,cena,zas)
                {
        document.forms.forms1.h_slu.value = slu;
        document.forms.forms1.h_nsl.value = nazov;
        document.forms.forms1.h_cen.value = cena;
        mySklkarelement.style.display='none';
        document.forms.forms1.h_nsl.focus();
        document.forms.forms1.h_nsl.select();
        urobSklkar();
        mySklkarelement.style.display='';
                }


function Len1Sklkar()
                    {
        document.forms.forms1.h_nsl.focus();
        document.forms.forms1.h_nsl.select();
        urobSklkar();
        mySklkarelement.style.display='';
                    }

function Len0Sklkar()
                    {
        New.style.display="";
        document.forms.forms1.h_nsl.focus();
        document.forms.forms1.h_nsl.select();
                    }


function VyberVstup()
                {
        document.forms.forms1.h_nsl.focus();
        document.forms.forms1.h_nsl.select(); 
                }

function TlacJednejKarty()
                {

var h_skl = document.forms.forms1.h_skl.value;
var h_cis = document.forms.forms1.h_slu.value;
  var h_min = 0;
  if( document.formx1.h_min.checked ) h_min=1;

window.open('../sklad/sklkarta_pdf.php?copern=10&h_skl=' + h_skl + '&h_cis=' + h_cis + '&h_min=' + h_min + '&drupoh=<?php echo $drupoh; ?>', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }


function CisJednejKarty()
                {

var h_cis = document.forms.forms1.h_slu.value;

if( h_cis > 0 ) {
window.open('../sklad/ccis.php?copern=9&hladaj_cis=' + h_cis + '&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

                }


function TlacVsetkyKarty()
                {

var h_skl = document.forms.forms1.h_skl.value;
var h_cis = document.forms.forms1.h_slu.value;
  var h_min = 0;
  if( document.formx1.h_min.checked ) h_min=1;

window.open('../sklad/sklkarta_pdf.php?copern=20&h_skl=' + h_skl + '&h_cis=' + h_cis + '&h_min=' + h_min + '&drupoh=<?php echo $drupoh; ?>', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Skladové karty
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formuláry po zadaní hodnoty položky a stlaèení Enter program prejde na vstup ïalšej položky">

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="fmenu" width="100%" >
<FORM name="formx1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu" width="20%">
 <input type="checkbox" name="h_min" value="1" /> Minulý rok
</tr>
</FORM>

<tr>
<td class="hmenu" width="20%">Sklad
<td class="hmenu" width="10%">Èíslo materiálu
<td class="hmenu" width="30%">Názov materiálu

<input type='image' src='../obr/orig.png' width=15 height=15 border=0 title='Èíselník materiálu pre vybraný materiál'
 onclick="CisJednejKarty();" >
<td class="hmenu" width="10%">Nákupná cena
<td class="hmenu" width="30%">
<input type='image' src='../obr/tlac.png' width=15 height=15 border=0 title='Tlaè skladovej karty pre vybraný materiál'
 onclick="TlacJednejKarty();" >
<input type='image' src='../obr/tlac.png' width=20 height=20 border=0 title='Tlaè všetky skladové karty'
 onclick="TlacVsetkyKarty();" >

</tr>
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<?php
$sql = mysql_query("SELECT skl,nas FROM F$kli_vxcf"."_skl ORDER BY skl");
?>
<select size="1" name="h_skl" id="h_skl" >
<option value="" >Všetky sklady</option>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["skl"];?>" >
<?php 
$polmen = $zaznam["nas"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["skl"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>

<td class="hmenu"><input type="text" name="h_slu" id="h_slu" size="10" 
onclick=" mySklkarelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_cen.value = '';"
 onKeyDown="return SluEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nsl" id="h_nsl" size="50" value="<?php echo $h_nsl;?>" 
onclick="mySklkarelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_cen.value = '';"
 onKeyDown="return NslEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="0" onclick="mySklkarelement.style.display='none'; New.style.display='none'; volajSklkar();"
 title="H¾adaj zadané èíslo alebo názov materiálu" >


<td class="hmenu"><input type="text" name="h_cen" id="h_cen" size="50" disabled="disabled" /> 

</tr>

<td class="obyc" align="right"><INPUT type="reset" onclick="mySklkarelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_nsl.focus();"
 id="resetp" name="resetp" value="Vymaza" ></td>

</FORM>
</table>

<div id="mySklkarelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepoznám položku CIS v žiadnom sklade v celom èíselníku materiálu , h¾adajte pod¾a názvu</span>

<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
