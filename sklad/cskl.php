<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$cslm=404100;
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
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v cskl.php
// 6=vymazanie polozky potvrdene v cskl.php
if ( $copern == 15 || $copern == 16 )
     {
$h_skk = strip_tags($_REQUEST['h_skk']);
$h_nas = strip_tags($_REQUEST['h_nas']);
$h_drs = strip_tags($_REQUEST['h_drs']);
$h_ucs = strip_tags($_REQUEST['h_ucs']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_skl ( skl,nas,drs,ucs ) VALUES ($h_skk, '$h_nas', $h_drs, '$h_ucs'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA SKL = <?php echo $h_skk; ?> NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA SKL:$h_skk SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_skl WHERE skl='$cislo_skl'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA SKL:$cislo_skl BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_skk = strip_tags($_REQUEST['h_skk']);
$h_nas = strip_tags($_REQUEST['h_nas']);
$h_drs = strip_tags($_REQUEST['h_drs']);
$h_ucs = strip_tags($_REQUEST['h_ucs']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_skl SET skl='$h_skk', nas='$h_nas', drs='$h_drs', ucs='$h_ucs' WHERE skl='$cislo_skl'");  
$copern=1;
$cislo_skl = $h_skk;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA SKL:$cislo_skl UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_skk = strip_tags($_REQUEST['h_skk']);
$h_nas = strip_tags($_REQUEST['h_nas']);
$h_drs = strip_tags($_REQUEST['h_drs']);
$h_ucs = strip_tags($_REQUEST['h_ucs']);
$cislo_skl = strip_tags($_REQUEST['h_skk']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>».skladov</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//posuny Enter[[[[[[[[[[[


function SklEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nas.focus();
              }
                }

function NasEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_drs.focus();
              }
                }

function DrsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_ucs.focus();
              }
                }

function UcsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_skk.value == '' ) okvstup=0;
    if ( document.formv1.h_nas.value == '' ) okvstup=0;
    if ( document.formv1.h_drs.value == '' ) okvstup=0;
    if ( document.formv1.h_ucs.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_skk.value == '' ) { document.formv1.h_skk.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nas.value == '' ) { document.formv1.h_nas.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_drs.value == '' ) { document.formv1.h_drs.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_ucs.value == '' ) { document.formv1.h_ucs.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//koniec posunov Enter

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nas.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    }

<?php
  }
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {

    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_skk.value = <?php echo "$h_skk";?>;
    document.formv1.h_nas.value = '<?php echo "$h_nas";?>';
    document.formv1.h_drs.value = <?php echo "$h_drs";?>;
    document.formv1.h_ucs.value = '<?php echo "$h_ucs";?>';
    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
//   Vstup.value = Vstup.value.replace ( ',','.' );
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

    function Zapis_COOK()
    {
//    WriteCookie ( 'skl_skk', document.formv1.h_skk.value , 240);
//    WriteCookie ( 'skl_nas', document.formv1.h_nas.value , 240);
//    WriteCookie ( 'skl_ucs', document.formv1.h_ucs.value , 240);
//    WriteCookie ( 'skl_drs', document.formv1.h_drs.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_skk.value = (ReadCookie ( 'skl_skk', '1' ));
//    document.formv1.h_nas.value = (ReadCookie ( 'skl_nas', 'nazov' ));
//    document.formv1.h_ucs.value = (ReadCookie ( 'skl_ucs', '11200' ));
//    document.formv1.h_drs.value = (ReadCookie ( 'skl_drs', '1' ));
    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    document.formv1.h_skk.focus();
    document.formv1.h_skk.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_skk.value == '' ) okvstup=0;
    if ( document.formv1.h_nas.value == '' ) okvstup=0;
    if ( document.formv1.h_drs.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
<?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    }

<?php
//koniec nova
  }
?>

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php 


// aktualna strana
$page = strip_tags($_REQUEST['page']);
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Sklady materi·lu a tovaru
 <img src='../obr/info.png' width=12 height=12 border=0 alt="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_skl ORDER BY skl");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nas = strip_tags($_REQUEST['hladaj_nas']);
$hladaj_skl = strip_tags($_REQUEST['hladaj_skl']);

if ( $hladaj_nas != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_skl WHERE ( nas LIKE '%$hladaj_nas%' ) ORDER BY skl");
if ( $hladaj_skl != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_skl WHERE ( skl = '$hladaj_skl' ) ORDER BY skl");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_skl WHERE NOT ( skl='$cislo_skl' ) ORDER BY skl");
  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="cskl.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_skl" id="hladaj_skl" size="15" value="<?php echo $hladaj_skl;?>" />
<td class="hmenu"><input type="text" name="hladaj_nas" id="hladaj_nas" size="50" value="<?php echo $hladaj_nas;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cskl.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">Sklad<th class="hmenu">N·zov skladu
<th class="hmenu">Druh skladu
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="Druh skladu 1=hlavnÈ, 2=staveniötnÈ sklady">
<th class="hmenu">⁄Ëet z·sob
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="Poloûku ⁄Ëet z·sob program pouûÌva pre ˙Ëtovanie M·Daù prÌjmu a Dal v˝daja , proti˙Ëet berie zo skladov˝ch pohybov.">
<th class="hmenu">Uprav<th class="hmenu">Zmaû
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" width="10%" ><?php echo $riadok->skl;?></td>
<td class="fmenu" width="60%" ><?php echo $riadok->nas;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->drs;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ucs;?></td>
<td class="fmenu" width="5%" ><a href='cskl.php?copern=8&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>&h_skk=<?php echo $riadok->skl;?>&h_drs=<?php echo $riadok->drs;?>&h_nas=<?php echo $riadok->nas;?>&h_ucs=<?php echo $riadok->ucs;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='cskl.php?copern=6&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
if ( $copern != 5 AND $copern != 8 AND $copern != 6 ) echo "</table>";
?>

<tr><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></tr>

<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>

<?php
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$h_skk = strip_tags($_REQUEST['h_skk']);
$h_nas = strip_tags($_REQUEST['h_nas']);
$h_drs = strip_tags($_REQUEST['h_drs']);
$h_ucs = strip_tags($_REQUEST['h_ucs']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_skl WHERE skl='$cislo_skl'";
$sql = mysql_query("$sqlp");
?>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%" ><?php echo $zaznam["skl"];?></td>
<td class="fmenu" width="60%" ><?php echo $zaznam["nas"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drs"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ucs"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cskl.php?page=<?php echo $page;?>&copern=16>&cislo_skl=<?php echo $cislo_skl;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cskl.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
//mysql_close();
mysql_free_result($sql);
  }
//koniec pre vymazanie
?>

<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
     {
?>
<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo skladu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh skladu musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 ⁄Ëet skladu musÌ byù ËÌslo v rozsahu 10000 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka SKL=<?php echo $h_skk;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="cskl.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_skl=$cislo_skl"; } ?>
" >

<td class="fmenu"><input type="text" name="h_skk" id="h_skk" size="5" 
 onKeyDown="return SklEnter(event.which)" onchange="return intg(this,1,99999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />


<td class="fmenu"><input type="text" name="h_nas" id="h_nas" size="40" 
 onKeyDown="return NasEnter(event.which)" onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drs" id="h_drs" size="5" 
 onKeyDown="return DrsEnter(event.which)" onchange="return intg(this,1,9,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ucs" id="h_ucs" size="5" 
 onKeyDown="return UcsEnter(event.which)" onchange="return intg(this,10000,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="cskl.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
<?php
if ( $copern == 5 )
{
?>
<td class="obyc" align="right"><INPUT type="reset" onclick="Obnov_vstup();" id="obnovp" name="obnovp" value="Opakovaù hodnoty" ></td>
<?php
}
?>
</tr>
</FORM>
</table>
<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka SKL=<?php echo $cislo_skl;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka SKL=<?php echo $cislo_skl;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="cskl.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_skl=$hladaj_skl&hladaj_nas=$hladaj_nas";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="cskl.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_skl=$hladaj_skl&hladaj_nas=$hladaj_nas";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="cskl.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cskl.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cskl_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_nas=$hladaj_nas&hladaj_skl=$hladaj_skl";
}
?>
" >
<INPUT type="submit" id="tlac" value="TlaËiù" >
</FORM>
</td>
</tr>
</table>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
