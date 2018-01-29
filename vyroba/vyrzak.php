<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
$clsm = 210;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];

$citfir = include("../cis/citaj_fir.php");

if( $copern == 101 ) { $_SESSION['vyb_zak'] = 1*$_REQUEST['vyb_zak']; $copern=1; }

$vyb_zak = 1*$_SESSION['vyb_zak'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

if( $drupoh == 1 )
{
$uce=1;
$drpsk=2;
}

if( $drupoh == 2 )
{
$uce=0;
$drpsk=1;
}

//vytvorenie predfaktura,dodaci list,faktura
if( $copern == 5 )
{

if( $drupoh == 31 )
{
$tabl = "dopfak";
$tablsluzby = "dopslu";
$cisdok = "dopfak";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$ucedok=31160;
}

if( $drupoh == 12 )
{
$tabl = "dopdol";
$tablsluzby = "dopslu";
$cisdok = "dopdol";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$ucedok=99901;
}

if( $drupoh == 52 )
{
$tabl = "dopprf";
$tablsluzby = "dopslu";
$cisdok = "fakprf";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$ucedok=99903;
}


//nova faktura hlavicka

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_ufir");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
$maxdok=0;

$sql = mysql_query("SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ");

while($zaznam=mysql_fetch_array($sql)):

if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;

endwhile;

$cnewdok=1*$newdok;
if( $cnewdok == 0 ) $newdok=1;
$h_fak = $newdok;
$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$newdok'+1");  

$cisfak=$newdok; 

$cisprf = 1*$_REQUEST['prf'];

$cisdol = 1*$_REQUEST['dol'];

$zaloha = 1*$_REQUEST['huh'];

if( $drupoh == 12 ) { $cisfak=0; $cisdol=$newdok; $cisprf=0; }
if( $drupoh == 52 ) { $cisfak=0; $cisdol=0; $cisprf=$newdok; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrzakdopln ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_vyrzakdopln.ico=F$kli_vxcf"."_ico.ico".
" WHERE zak= '$vyb_zak' ";
$sql = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$zk2=0;
$dn2=0;
$hod=0;
$zk0=0;

$sluztt = "SELECT * FROM F$kli_vxcf"."_vyrzakpol ".
" LEFT JOIN F$kli_vxcf"."_dopsluzby".
" ON F$kli_vxcf"."_vyrzakpol.slu=F$kli_vxcf"."_dopsluzby.slu".
" WHERE zak = '$vyb_zak' ORDER BY F$kli_vxcf"."_vyrzakpol.slu";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

$szdph=1*$fir_dph2;
$sumadan2 = $szdph*$rsluz->cepv;

//echo $sumadan2." ";

$sumadan2 = $sumadan2/100;
$Cislo=$sumadan2+"";
$sumadan2=sprintf("%0.4f", $Cislo);

$sumadan2=1*$sumadan2;
$sdph = 1*$rsluz->cepv+1*$sumadan2;

$Cislo=$sdph+"";
$sdph=sprintf("%0.4f", $Cislo);

if( $riadok->bdph == 1 ) { $szdph=0; $sdph=$rsluz->cepv; }

//colny sadzobnik
$colsadz="";
$sqlcst = "SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE crcp = $rsluz->slu ";
//echo $sqlcst;
$sqlcsz = mysql_query("$sqlcst");
  if (@$zaznam=mysql_data_seek($sqlcsz,0))
  {
  $riadokcsz=mysql_fetch_object($sqlcsz);
  $colsadz=trim($riadokcsz->prcp);
  }

$zakico=0;
$sqlcst = "SELECT * FROM F$kli_vxcf"."_vyrzakdopln WHERE zak = $rsluz->zak ";
//echo $sqlcst;
$sqlcsz = mysql_query("$sqlcst");
  if (@$zaznam=mysql_data_seek($sqlcsz,0))
  {
  $riadokcsz=mysql_fetch_object($sqlcsz);  
  $zakico=$riadokcsz->ico;
  }

$icdph=0;
$sqlcst = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $zakico ";
//echo $sqlcst;
$sqlcsz = mysql_query("$sqlcst");
  if (@$zaznam=mysql_data_seek($sqlcsz,0))
  {
  $riadokcsz=mysql_fetch_object($sqlcsz);  
  $icdph=$riadokcsz->icd;
  }

$icdph2 = substr($icdph,0,2);
if( $icdph2 != 'sk' AND $icdph2 != 'SK' AND $icdph2 != 'sK' AND $icdph2 != 'Sk' ) { $colsadz=""; }

$textcsz="";
$colsadzc=1*$colsadz;
if( $colsadzc > 1 )
{

$textcsz="SCS ".$colsadz." - prenos daòovej povinnosti ";
$szdph=0;
$sdph=$rsluz->cepv;
$zk0=$zk0+($rsluz->cepv*$rsluz->mnov);
$hod=$hod+($sdph*$rsluz->mnov);

}

if( $colsadzc <= 1 AND $riadok->bdph == 0 )
{

$zk2=$zk2+($rsluz->cepv*$rsluz->mnov);
$hod=$hod+($sdph*$rsluz->mnov);

}

if( $colsadzc <= 1 AND $riadok->bdph == 1 )
{

$zk0=$zk0+($rsluz->cepv*$rsluz->mnov);
$hod=$hod+($sdph*$rsluz->mnov);

}

if( $rsluz->txpp != '' )
{
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tablsluzby ( dok,fak,dol,prf,slu,nsl,mer,pop,pon,dph,cep,ced,mno,id,pfak,cfak,dfak,xfak ) ".
" VALUES ( $newdok, '$cisfak', '$cisdol', '$cisprf', '0', '', '', '$rsluz->txpp', '', '0', '0', '0',".
" '0', $kli_uzid, '0', '0', '0', '' )";
$ulozene = mysql_query("$sqlhh");

}

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tablsluzby ( dok,fak,dol,prf,slu,nsl,mer,pop,pon,dph,cep,ced,mno,id,pfak,cfak,dfak,xfak ) ".
" VALUES ( $newdok, '$cisfak', '$cisdol', '$cisprf', '$rsluz->slu', '$rsluz->nsl', '$rsluz->mer', '', '$textcsz', '$szdph', '$rsluz->cepv', '$sdph',".
" '$rsluz->mnov', $kli_uzid, '0', '0', '0', '' )";
$ulozene = mysql_query("$sqlhh");


}
$i = $i + 1;
  }

$dn2=$hod-$zk2-$zk0;

$dat_dat = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d"),date("Y"))); 
$dat_das = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d")+$riadok->dns,date("Y"))); 
$pole = explode("-", $dat_dat);
$ume=$pole[1].".".$pole[0];
$zalp="";
$zalh="";
if( $drupoh == 31 ) { $zalp=",zal"; $zalh=",'".$zaloha."'"; }

if( $riadok->bdph == 0 ) {
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( odbm,ume,uce,dok,doq,fak,dol,prf,ico,dat,daz,das,zk0,zk1,zk2,dn1,dn2,hod,id,str,zak,obj,ksy,sp1,sp2,dpr".$zalp." ) ".
" VALUES ( '$riadok->odbm', $ume, $ucedok, $newdok, $newdok, '$cisfak', '$cisdol', '$cisprf', '$riadok->ico', '$dat_dat', '$dat_dat', '$dat_das',".
" '$zk0', '0', '$zk2', '0', '$dn2', '$hod', $kli_uzid, '$fir_dopstr', '$vyb_zak', '$riadok->obj', '0308', '0', '$hod', '$riadok->spzo'".$zalh." )";
$ulozene = mysql_query("$sqlhh"); 
                         }

if( $riadok->bdph == 1 ) {
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( odbm,ume,uce,dok,doq,fak,dol,prf,ico,dat,daz,das,zk0,zk1,zk2,dn1,dn2,hod,id,str,zak,obj,ksy,sp1,sp2,dpr".$zalp." ) ".
" VALUES ( '$riadok->odbm', $ume, $ucedok, $newdok, $newdok, '$cisfak', '$cisdol', '$cisprf', '$riadok->ico', '$dat_dat', '$dat_dat', '$dat_das',".
" '$zk0', '0', '$zk2', '0', '$dn2', '$hod', $kli_uzid, '$fir_dopstr', '$vyb_zak', '$riadok->obj', '0308', '0', '0', '$riadok->spzo'".$zalh." )";
$ulozene = mysql_query("$sqlhh"); 
                         }
//exit;
  }

?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?vyroba=1&copern=8&drupoh=<?php echo $drupoh; ?>&page=1&hladaj_uce=<?php echo $ucedok; ?>&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $newdok; ?>', '_self' )

</SCRIPT>
<?php
}
//koniec vytvorenia predfaktura,dodaci list,faktura 

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Výrobné operácie ZÁKazky</title>
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

<script type="text/javascript" src="vyr_vyberzak_xml.js"></script>
<script type="text/javascript" src="vyr_ukazzak_xml.js"></script>
<script type="text/javascript" src="vyr_ukazveop_xml.js"></script>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

//funkcia na nastavenie Uce 
    function nastavUce()
    {
        var jehodnota = document.forms.forms1.h_uce.value;
//        if( jehodnota == 1 ) {  document.forms1.h_uce.value = 0; }
//        if( jehodnota == 0 ) {  document.forms1.h_uce.value = 1; }
    }

//funkcia na reset nastavenie Uce 
    function resetStav()
    {
//    document.forms1.h_uce.value = 1;
    }

//posuny Enter[[[[[[[[[[[



function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if( document.forms.forms1.h_ico.value != ''  )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajteSaldo();
        }      

        if( document.forms1.h_ico.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }


function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if(document.forms.forms1.h_nai.value != '' )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms1.h_ico.value = ""; 
        volajteSaldo();
        }   

        if( document.forms1.h_nai.value == "" ) { document.forms1.h_ico.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky Saldo
function vykonajSaldo(zak,nza,obj,prm1,prm2,prm3,prm4)
                {
        document.forms.forms1.h_ico.value = zak;
        document.forms.forms1.h_nai.value = nza;
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobVyrSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                }


function Len1Saldo()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobVyrSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                    }

function Len0Saldo()
                    {
        New.style.display="";
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                    }


function VyberVstup()
                {
       spatico = '';
       spatnai = ''; 
       <?php if( $vyb_zak > 0 )  echo "document.forms.forms1.h_ico.value = '$vyb_zak'; volajSaldo();"; ?>
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select(); 
                }

function EkoVyr()
                {

window.open('../vyroba/vyrzak.php?copern=1&drupoh=<?php echo $drpsk;?>&page=1&kanc=1&vyb_zak=<?php echo $vyb_zak;?>', '_self', '<?php echo $tlcvwin; ?>' );

                }


function Dalsi()
                {
        var nowzak = document.forms.forms1.h_ico.value;
        var nextzak = 1*nowzak + 1;
        document.forms.forms1.h_ico.value = nextzak;
        document.forms.forms1.h_nai.value = '';
        mySaldoelement.style.display='none';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
        urobVyrSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                }

function Minul()
                {
        var nowzak = document.forms.forms1.h_ico.value;
        var prevzak = 1*nowzak - 1;
        document.forms.forms1.h_ico.value = prevzak;
        document.forms.forms1.h_nai.value = '';
        mySaldoelement.style.display='none';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
        urobVyrSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                }

    function TlacSumar(zakazka)
    {
window.open('../vyroba/model_prace.php?vyroba=1&copern=1&drupoh=1&vyb_zak=' + zakazka + '&page=1&sumar=1', '_blank', '<?php echo $tlcswin; ?>' )
    }

    function TlacPrace(zakazka)
    {
window.open('../vyroba/model_prace.php?vyroba=1&copern=1&drupoh=1&vyb_zak=' + zakazka + '&page=1&sumar=0', '_blank', '<?php echo $tlcswin; ?>' )
    }

    function TlacMat(zakazka)
    {
window.open('../vyroba/model_mat.php?vyroba=1&copern=1&drupoh=1&vyb_zak=' + zakazka + '&page=1', '_blank', '<?php echo $tlcswin; ?>' )
    }

function Naspat()
                {
        document.forms.forms1.h_ico.value= spatico;
        document.forms.forms1.h_nai.value= spatnai; 
        volajSaldo();
                }

function volajteSaldo()
                {
        spatico = document.forms.forms1.h_ico.value;
        spatnai = document.forms.forms1.h_nai.value; 
        volajSaldo();
                }

    function VytlacFakt(doklad)
    {
    var hladaj_dok = "";
    var hladaj_dok = "";
    var cislo_dok = doklad;
    window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=31&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )

    }

    function VytlacPredFakt(doklad)
    {
    var hladaj_dok = "";
    var hladaj_dok = "";
    var cislo_dok = doklad;
    window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=52&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )

    }

    function ChatZakSelf(zakazka)
    {
    window.open('chatvyroba.php?vyroba=1&copern=1&drupoh=1&cislo_zak=' + zakazka + '&page=1', '_self', '<?php echo $tlcswin; ?>' )
    }


  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<?php
if( $drupoh == 1 )
{
$drptxt="Ekonomické operácie";
?>
<td>EuroSecom  -  Výrobné operácie na zákazke
<?php
}
?>
<?php
if( $drupoh == 2 )
{
$drptxt="Výrobné operácie";
?>
<td>EuroSecom  -  Ekonomické operácie na zákazke
<?php
}
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if( $copern == 1 )
          {
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%">VYR/EKO
<td class="hmenu" width="20%" align="right"><div id="cislo">Zákazka</div>
<td class="hmenu" width="25%"><div id="nazov">Názov/Objednávka</div>
<td class="hmenu" width="10%" align="right">
</td>
<td class="hmenu" width="15%" align="right">
</td>
<td class="hmenu" width="10%" align="right">
</td>
<td class="hmenu" width="5%" align="right">
</td>
<td class="hmenu" width="5%" align="right">
</td>
</tr>
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<a href="#" onClick="EkoVyr()">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Zobrazi <?php echo $drptxt;?>' ></a>

<a href="#" onClick="ChatZakSelf(<?php echo $vyb_zak;?>)">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='CHAT zákazky' ></a>

<input type="hidden" name="h_uce" id="h_uce" value="<?php echo $uce; ?>"  onclick="nastavUce();" />

<td class="hmenu" align="right">
<img src='../obr/prev.png' onclick="return Minul();" border="0" width="15" height="15" title="Predošlá zákazka " >
<img src='../obr/next.png' onclick="return Dalsi();" border="0" width="15" height="15" title="Ïalšia zákazka " >
<input type="text" name="h_ico" id="h_ico" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return IcoEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nai" id="h_nai" size="40" value="<?php echo $h_nai;?>" 
onclick="mySaldoelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return NaiEnter(event.which)" /> 

<img src='../obr/hladaj.png' onclick="mySaldoelement.style.display='none'; New.style.display='none'; volajteSaldo();" border="0" title="H¾adaj zadané èíslo alebo názov zákazky" >


<td class="obyc" align="right">
<INPUT type="reset" 
 onclick="mySaldoelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_nai.focus(); resetStav();"
 id="resetp" name="resetp" value="Nové h¾adanie" ></td>

<td class="hmenu">
<td class="hmenu">
<td class="hmenu">
<a href="#" onClick="Naspat()">
<img src='../obr/spat.png' width=15 height=15 border=0 title='Naspä do ponuky zákaziek' ></a>

</FORM>
</table>

<div id="mySaldoelement"></div>
<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenašiel som zákazku pod¾a zadaných podmienok, skúste znovu</span>

<?php
          }
//koniec copern=1
?>



<?php


// celkovy koniec dokumentu
$cislista = include("vyr_lista.php");
       } while (false);
?>
</BODY>
</HTML>
