<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 3000;
$cslm=101803;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvfak = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v dpok.php
// 6=vymazanie polozky potvrdene v dpok.php
if ( $copern == 15 || $copern == 16 )
     {
$h_dpok = strip_tags($_REQUEST['h_dpok']);
$h_npok = strip_tags($_REQUEST['h_npok']);
$h_drpk = strip_tags($_REQUEST['h_drpk']);
$h_ucpk = strip_tags($_REQUEST['h_ucpk']);
$h_cpri = 1*$_REQUEST['h_cpri'];
if( $h_cpri == 0 ) { $h_cpri=1; }
$h_cvyd = 1*$_REQUEST['h_cvyd'];
if( $h_cvyd == 0 ) { $h_cvyd=1; }
$cislo_dpok = strip_tags($_REQUEST['cislo_dpok']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = "INSERT INTO F$kli_vxcf"."_dpok ( dpok,npok,drpk,ucpk,cpri,cvyd ) ".
" VALUES ($h_dpok, '$h_npok', $h_drpk, '$h_ucpk', '$h_cpri', '$h_cvyd'); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA dpok:$h_dpok SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dpok WHERE dpok='$cislo_dpok'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA POK:$cislo_dpok BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_dpok = strip_tags($_REQUEST['h_dpok']);
$h_npok = strip_tags($_REQUEST['h_npok']);
$h_drpk = strip_tags($_REQUEST['h_drpk']);
$h_ucpk = strip_tags($_REQUEST['h_ucpk']);
$h_cpri = 1*$_REQUEST['h_cpri'];
if( $h_cpri == 0 ) { $h_cpri=1; }
$h_cvyd = 1*$_REQUEST['h_cvyd'];
if( $h_cvyd == 0 ) { $h_cvyd=1; }
$cislo_dpok = strip_tags($_REQUEST['cislo_dpok']);

$upravttt = "UPDATE F$kli_vxcf"."_dpok SET dpok='$h_dpok', npok='$h_npok', drpk='$h_drpk',".
" ucpk='$h_ucpk', cpri='$h_cpri', cvyd='$h_cvyd' WHERE dpok='$cislo_dpok'";  
$upravene = mysql_query("$upravttt"); 
$copern=1;
$cislo_dpok = $h_dpok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA dpok:$cislo_dpok UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_dpok = strip_tags($_REQUEST['h_dpok']);
$h_npok = strip_tags($_REQUEST['h_npok']);
$h_drpk = strip_tags($_REQUEST['h_drpk']);
$h_ucpk = strip_tags($_REQUEST['h_ucpk']);
$h_cpri = strip_tags($_REQUEST['h_cpri']);
$h_cvyd = strip_tags($_REQUEST['h_cvyd']);
$cislo_dpok = strip_tags($_REQUEST['h_dpok']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_dpok = strip_tags($_REQUEST['cislo_dpok']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>».pokladnÌc</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">


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
    document.formhl1.hladaj_npok.focus();
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
    document.formv1.h_dpok.value = <?php echo "$h_dpok";?>;
    document.formv1.h_npok.value = '<?php echo "$h_npok";?>';
    document.formv1.h_drpk.value = <?php echo "$h_drpk";?>;
    document.formv1.h_ucpk.value = '<?php echo "$h_ucpk";?>';
    document.formv1.h_cpri.value = '<?php echo "$h_cpri";?>';
    document.formv1.h_cvyd.value = '<?php echo "$h_cvyd";?>';
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
//    WriteCookie ( 'stv_dpok', document.formv1.h_dpok.value , 240);
//    WriteCookie ( 'stv_npok', document.formv1.h_npok.value , 240);
//    WriteCookie ( 'stv_ucpk', document.formv1.h_ucpk.value , 240);
//    WriteCookie ( 'stv_drpk', document.formv1.h_drpk.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_dpok.value = (ReadCookie ( 'stv_dpok', '1' ));
//    document.formv1.h_npok.value = (ReadCookie ( 'stv_npok', 'nazov' ));
//    document.formv1.h_ucpk.value = (ReadCookie ( 'stv_ucpk', '11200' ));
//    document.formv1.h_drpk.value = (ReadCookie ( 'stv_drpk', '1' ));
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
    document.formv1.h_dpok.focus();
    document.formv1.h_dpok.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_dpok.value == '' ) okvstup=0;
    if ( document.formv1.h_npok.value == '' ) okvstup=0;
    if ( document.formv1.h_drpk.value == '' ) okvstup=0;
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
//nasledujuca strana
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
<td>EuroSecom  -  Druhy pokladnÌc
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok ORDER BY dpok");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_npok = strip_tags($_REQUEST['hladaj_npok']);
$hladaj_dpok = strip_tags($_REQUEST['hladaj_dpok']);

if ( $hladaj_npok != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok WHERE ( npok LIKE '%$hladaj_npok%' ) ORDER BY dpok");
if ( $hladaj_dpok != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok WHERE ( dpok = '$hladaj_dpok' ) ORDER BY dpok");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok WHERE NOT ( dpok='$cislo_dpok' ) ORDER BY dpok");
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
<FORM name="formhl1" class="hmenu" method="post" action="dpok.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_dpok" id="hladaj_dpok" size="15" value="<?php echo $hladaj_dpok;?>" />
<td class="hmenu"><input type="text" name="hladaj_npok" id="hladaj_npok" size="50" value="<?php echo $hladaj_npok;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="dpok.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">Druh<th class="hmenu">N·zov
<th class="hmenu">Typ
 <img src='../obr/info.png' width=10 height=10 border=0
 title="Poloûka Typ pokladnice 1=˙Ëtovn· pokladnica, 2=platby fakt˙r a z·loh DOPRAVA, 9=registraËn· pokladnica DOPRAVA ">
<th class="hmenu">Parametre
<th class="hmenu">CPRI
 <img src='../obr/info.png' width=10 height=10 border=0
 title="N·sleduj˙ce ËÌslo prÌjmovÈho dokladu pri oddelenom ËÌslovanÌ dokladov , nastavÌ V·m ho V·ö spr·vca webu ">
<th class="hmenu">CVYD
 <img src='../obr/info.png' width=10 height=10 border=0
 title="N·sleduj˙ce ËÌslo v˝davkovÈho dokladu pri oddelenom ËÌslovanÌ dokladov , nastavÌ V·m ho V·ö spr·vca webu ">
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
<td class="fmenu" width="10%" ><?php echo $riadok->dpok;?></td>
<td class="fmenu" width="40%" ><?php echo $riadok->npok;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->drpk;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ucpk;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cpri;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cvyd;?></td>
<td class="fmenu" width="5%" ><a href='dpok.php?copern=8&page=<?php echo $page;?>&cislo_dpok=<?php echo $riadok->dpok;?>
&h_dpok=<?php echo $riadok->dpok;?>&h_drpk=<?php echo $riadok->drpk;?>&h_npok=<?php echo $riadok->npok;?>&h_cpri=<?php echo $riadok->cpri;?>
&h_ucpk=<?php echo $riadok->ucpk;?>&h_cvyd=<?php echo $riadok->cvyd;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='dpok.php?copern=6&page=<?php echo $page;?>&cislo_dpok=<?php echo $riadok->dpok;?>'>Zmaû</a></td>
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
$h_dpok = strip_tags($_REQUEST['h_dpok']);
$h_npok = strip_tags($_REQUEST['h_npok']);
$h_drpk = strip_tags($_REQUEST['h_drpk']);
$h_ucpk = strip_tags($_REQUEST['h_ucpk']);
$h_cpri = strip_tags($_REQUEST['h_cpri']);
$h_cvyd = strip_tags($_REQUEST['h_cvyd']);
$cislo_dpok = strip_tags($_REQUEST['cislo_dpok']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_dpok WHERE dpok='$cislo_dpok'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["dpok"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["npok"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drpk"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ucpk"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cpri"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cvyd"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="dpok.php?page=<?php echo $page;?>&copern=16>&cislo_dpok=<?php echo $cislo_dpok;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="dpok.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo odber.fakt˙ry musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parametre1 fakt˙ry musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parametre2 fakt˙ry musÌ byù ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka dpok=<?php echo $h_dpok;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="dpok.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_dpok=$cislo_dpok"; } ?>
" >

<td class="fmenu"><input type="text" name="h_dpok" id="h_dpok" size="5" 
onchange="return intg(this,1,999999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />


<td class="fmenu"><input type="text" name="h_npok" id="h_npok" size="40" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drpk" id="h_drpk" size="5" 
onchange="return intg(this,1,9,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ucpk" id="h_ucpk" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_cpri" id="h_cpri" size="7" 
onchange="return intg(this,1,99999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_cvyd" id="h_cvyd" size="7" 
onchange="return intg(this,1,99999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="dpok.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka dpok=<?php echo $cislo_dpok;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka dpok=<?php echo $cislo_dpok;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="dpok.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dpok=$hladaj_dpok&hladaj_npok=$hladaj_npok";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="dpok.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dpok=$hladaj_dpok&hladaj_npok=$hladaj_npok";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="dpok.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="dpok.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
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
