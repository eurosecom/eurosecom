<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 1000;
//$cslm=310;
$cslm=103300;
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
<title>Prehæad·vanie dokladov</title>
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


//  Oprav ciarku na bodku u desatinnych cisiel
    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
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
        document.forms.forms1.h_ucm.value = ucet;
        document.forms.forms1.h_ucd.value = ucet;
        document.forms.forms1.h_nai.value = nai;
        myUcetelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                }


function Len1Ucet()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        document.forms.forms1.h_ucm.value = document.forms.forms1.h_uce.value;
        document.forms.forms1.h_ucd.value = document.forms.forms1.h_uce.value;
        document.forms.forms1.h_udo.value = document.forms.forms1.h_uce.value;
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

function TlacPolozky()
                {
var h_uce = document.forms.forms1.h_uce.value;
var h_ucm = document.forms.forms1.h_ucm.value;
var h_ucd = document.forms.forms1.h_ucd.value;
var cislo_udo = document.forms.forms1.h_udo.value;
var h_obdp = document.forms.forms1.h_obdp.value;
var h_obdk = document.forms.forms1.h_obdk.value;
var h_datp = document.forms.forms1.h_datp.value;
var h_datk = document.forms.forms1.h_datk.value;
var h_ico = document.forms.forms1.h_ico.value;
var h_fak = document.forms.forms1.h_fak.value;
var h_dok = document.forms.forms1.h_dok.value;
var h_txt = document.forms.forms1.h_txt.value;
var h_hop = document.forms.forms1.h_hop.value;
var h_hok = document.forms.forms1.h_hok.value;
var h_hoc = document.forms.forms1.h_hoc.value;
var h_do2 = document.forms.forms1.h_do2.value;
var h_hoco = document.forms.forms1.h_hoco.value;
var h_hocd = document.forms.forms1.h_hocd.value;
var h_rdp = document.forms.forms1.h_rdp.value;
var h_str = document.forms.forms1.h_str.value;
var h_zak = document.forms.forms1.h_zak.value;
var h_sys = 0;

if( h_uce != '' || h_ucm != '' || h_ucd != '' || h_obdp != 0 || h_obdk != 0 || h_ico != '' || h_fak != '' || cislo_udo != '' || h_str != '' ||
 h_dok != '' || h_do2 != '' || h_txt != '' || h_hop != '' || h_hok != '' || h_hoco != ''  || h_hocd != ''  || h_rdp != '' || h_zak != '' || h_hoc != ''  ) {

window.open('../ucto/hladaj_doktlac.php?cislo_uce=' + h_uce + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + '&h_datk=' + h_datk + '&h_datp=' + h_datp + 
 '&cislo_ucm=' + h_ucm + '&cislo_ucd=' + h_ucd + '&h_ico=' + h_ico + '&h_fak=' + h_fak + '&h_dok=' + h_dok +  '&h_do2=' + h_do2 + '&h_txt=' + h_txt +
'&h_hop=' + h_hop + '&h_hok=' + h_hok + '&h_hoco=' + h_hoco + '&h_hocd=' + h_hocd + '&h_rdp=' + h_rdp + '&cislo_udo=' + cislo_udo + '&h_str=' + h_str +
'&h_zak=' + h_zak + '&h_sys=' + h_sys + '&h_hoc=' + h_hoc + '&copern=31&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                                                 }
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
document.forms.forms1.h_ucm.value='';
document.forms.forms1.h_ucd.value='';
document.forms.forms1.h_udo.value='';
document.forms.forms1.h_ico.value='';
document.forms.forms1.h_fak.value='';
document.forms.forms1.h_dok.value='';
document.forms.forms1.h_do2.value='';
document.forms.forms1.h_txt.value='';
document.forms.forms1.h_nic.value='';
document.forms.forms1.h_nai.value='';
document.forms.forms1.h_hop.value='';
document.forms.forms1.h_hok.value='';
document.forms.forms1.h_hoco.value='';
document.forms.forms1.h_hocd.value='';
document.forms.forms1.h_rdp.value='';
document.forms.forms1.h_str.value='';
document.forms.forms1.h_hoc.value='';

document.forms.forms1.h_nai.focus();


                }



  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Prehæad·vanie dokladov</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%">Odbobie od
<td class="hmenu" width="10%">Obdobie do
<td class="hmenu" width="10%" align="right">D·tum od
<td class="hmenu" width="10%">D·tum do
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
<a href="#" onClick="TlacPolozky();" >
<input type='image' src='../obr/hladaj.png' width=20 height=20 border=0 title='VypÌö jednotlivÈ ˙ËtovnÈ poloûky'>HºADAJ </a>
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


<td class="hmenu" align="right"><input type="text" name="h_datp" id="h_datp" size="10" maxlength="10" />
<td class="hmenu"><input type="text" name="h_datk" id="h_datk" size="10" maxlength="10" />
<td class="hmenu" colspan="2">
 ätvrùrok 
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok1();">1.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok2();">2.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok3();">3.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Stvrtrok4();">4.</a>&nbsp;&nbsp;
&nbsp;&nbsp;<a href="#" onClick="Celyrok();">Cel˝ rok</a>&nbsp;&nbsp;

</tr>

<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">Doklad od <input type="text" name="h_dok" id="h_dok" size="10" 
onclick="New.style.display='none'; " />

<td class="hmenu" colspan="2" align="left"><input type="text" name="h_do2" id="h_do2" size="10" 
onclick="New.style.display='none'; " /> Doklad do

</tr>


<tr>
<td class="hmenu">


<td class="hmenu" colspan="2" align="right">Text

<td class="hmenu" colspan="4" align="left"><input type="text" name="h_txt" id="h_txt" size="50" value="<?php echo $h_txt;?>" 
onclick="New.style.display='none';" />

</tr>


<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">⁄Ëet od <input type="text" name="h_uce" id="h_uce" size="10" 
onclick=" myUcetelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return UceEnter(event.which)"/>

<td class="hmenu" colspan="3"><input type="text" name="h_nai" id="h_nai" size="50" value="<?php echo $h_nai;?>" 
onclick="myUcetelement.style.display='none'; New.style.display='none';  document.forms.forms1.h_nai.select();" 
 onKeyDown="return NaiEnter(event.which)" />  

<img src='../obr/hladaj.png' border="1" onclick="myUcetelement.style.display='none'; New.style.display='none'; volajUcet();" title="Hæadaj zadanÈ ËÌslo alebo n·zov ˙Ëtu" >

<td class="hmenu" colspan="2" align="left"> ⁄Ëet Do <input type="text" name="h_udo" id="h_udo" size="10" 
onclick=" myUcdtelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_udo.value='';" /> 

</tr>


<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">⁄Ëet M·Daù <input type="text" name="h_ucm" id="h_ucm" size="10" 
onclick=" myUcmtelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_ucm.value='';"/>

<td class="hmenu" colspan="2" align="left"><input type="text" name="h_ucd" id="h_ucd" size="10" 
onclick=" myUcdtelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_ucd.value='';" /> ⁄Ëet Dal 


<td class="obyc" colspan="4" align="right">
<img src='../obr/hladaj.png' border="1" onclick="Vynuluj(); Celyrok();" title="NovÈ hæadanie" >
NovÈ hæadanie

</tr>


<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">Hodnota od <input type="text" name="h_hop" id="h_hop" size="10" onkeyup="CiarkaNaBodku(this)"
onclick=" New.style.display='none'; " />

<td class="hmenu" colspan="2" align="left"><input type="text" name="h_hok" id="h_hok" size="10" onkeyup="CiarkaNaBodku(this)"
onclick=" New.style.display='none'; " /> Hodnota do
 <img src='../obr/info.png' width=15 height=15 border=0 title="Hodnota jednej ˙Ëtovnej poloûky z dokladu (DPH,Z·klad DPH...)">

<td class="hmenu" colspan="3" align="left">
<td class="hmenu" colspan="2" align="right">Hodnota cudej meny<input type="text" name="h_hoc" id="h_hoc" size="10" onkeyup="CiarkaNaBodku(this)"
onclick=" New.style.display='none'; " />

</tr>

<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">Celkom od <input type="text" name="h_hoco" id="h_hoco" size="10" onkeyup="CiarkaNaBodku(this)"
onclick=" New.style.display='none'; " />

<td class="hmenu" colspan="4" align="left"><input type="text" name="h_hocd" id="h_hocd" size="10" onkeyup="CiarkaNaBodku(this)"
onclick=" New.style.display='none'; " /> Celkom do
 <img src='../obr/info.png' width=15 height=15 border=0 title="Celkov· hodnota dokladu ">

<td class="hmenu" colspan="4" align="right">STR 
 <img src='../obr/info.png' width=15 height=15 border=0 title="N·kladovÈ stredisko">
 <input type="text" name="h_str" id="h_str" size="10" 
onclick=" myFakelement.style.display='none'; New.style.display='none'; "/>
 Z¡K 
 <img src='../obr/info.png' width=15 height=15 border=0 title="N·kladov· z·kazka">
 <input type="text" name="h_zak" id="h_zak" size="10" 
onclick=" myFakelement.style.display='none'; New.style.display='none'; "/>
</tr>


<tr>
<td class="hmenu">

<td class="hmenu" colspan="2" align="right">I»O <input type="text" name="h_ico" id="h_ico" size="10" 
onclick=" myIcoelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return IcoEnter(event.which)"/>

<td class="hmenu" colspan="3"><input type="text" name="h_nic" id="h_nic" size="50" value="<?php echo $h_nic;?>" 
onclick="myIcoelement.style.display='none'; New.style.display='none';  document.forms.forms1.h_nic.select();"
 onKeyDown="return NicEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="1" onclick="myIcoelement.style.display='none'; New.style.display='none'; volajIco();" title="Hæadaj zadanÈ ËÌslo alebo n·zov I»O" >

<td class="hmenu" colspan="2" align="left">Fakt˙ra <input type="text" name="h_fak" id="h_fak" size="10" 
onclick=" myFakelement.style.display='none'; New.style.display='none'; "/>

<td class="hmenu" colspan="3" align="right">DRD
 <img src='../obr/info.png' width=15 height=15 border=0 title="Druh dokladu DPH">
 <input type="text" name="h_rdp" id="h_rdp" size="10" />

</tr>


</FORM>
</table>

<div id="myUcetelement"></div>
<div id="myUcmtelement"></div>
<div id="myUcdtelement"></div>
<div id="myIcoelement"></div>
<div id="myFakelement"></div>

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
