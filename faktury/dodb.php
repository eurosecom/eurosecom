<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 3000;
$cslm=101801;
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
$vtvfak = include("../faktury/vtvfak.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v dodb.php
// 6=vymazanie polozky potvrdene v dodb.php
if ( $copern == 15 || $copern == 16 )
     {
$h_dodb = strip_tags($_REQUEST['h_dodb']);
$h_nodb = strip_tags($_REQUEST['h_nodb']);
$h_drod = strip_tags($_REQUEST['h_drod']);
$h_ucod = strip_tags($_REQUEST['h_ucod']);
$h_strv = strip_tags($_REQUEST['h_strv']);
$h_zakv = strip_tags($_REQUEST['h_zakv']);
$h_cfak = 1*$_REQUEST['h_cfak'];
if( $h_cfak == 0 ) { $h_cfak=1; }
$cislo_dodb = strip_tags($_REQUEST['cislo_dodb']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod,strv,zakv,cfak ) VALUES ($h_dodb, '$h_nodb', $h_drod, '$h_ucod', '$h_strv', '$h_zakv', '$h_cfak'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA DODB:$h_dodb SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dodb WHERE dodb='$cislo_dodb'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA dodb:$cislo_dodb BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_dodb = strip_tags($_REQUEST['h_dodb']);
$h_nodb = strip_tags($_REQUEST['h_nodb']);
$h_drod = strip_tags($_REQUEST['h_drod']);
$h_ucod = strip_tags($_REQUEST['h_ucod']);
$h_strv = strip_tags($_REQUEST['h_strv']);
$h_zakv = strip_tags($_REQUEST['h_zakv']);
$h_cfak = 1*$_REQUEST['h_cfak'];
if( $h_cfak == 0 ) { $h_cfak=1; }
$cislo_dodb = strip_tags($_REQUEST['cislo_dodb']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET dodb='$h_dodb', nodb='$h_nodb', drod='$h_drod', ucod='$h_ucod', strv='$h_strv', zakv='$h_zakv', cfak='$h_cfak' WHERE dodb='$cislo_dodb'");  
$copern=1;
$cislo_dodb = $h_dodb;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA DODB:$cislo_dodb UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_dodb = strip_tags($_REQUEST['h_dodb']);
$h_nodb = strip_tags($_REQUEST['h_nodb']);
$h_drod = strip_tags($_REQUEST['h_drod']);
$h_ucod = strip_tags($_REQUEST['h_ucod']);
$h_strv = strip_tags($_REQUEST['h_strv']);
$h_zakv = strip_tags($_REQUEST['h_zakv']);
$h_cfak = strip_tags($_REQUEST['h_cfak']);
$cislo_dodb = strip_tags($_REQUEST['h_dodb']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_dodb = strip_tags($_REQUEST['cislo_dodb']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>».ODB.fakt˙r</title>
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
    document.formhl1.hladaj_nodb.focus();
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
    document.formv1.h_dodb.value = <?php echo "$h_dodb";?>;
    document.formv1.h_nodb.value = '<?php echo "$h_nodb";?>';
    document.formv1.h_drod.value = <?php echo "$h_drod";?>;
    document.formv1.h_ucod.value = '<?php echo "$h_ucod";?>';
    document.formv1.h_strv.value = '<?php echo "$h_strv";?>';
    document.formv1.h_zakv.value = '<?php echo "$h_zakv";?>';
    document.formv1.h_cfak.value = '<?php echo "$h_cfak";?>';
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
//    WriteCookie ( 'stv_dodb', document.formv1.h_dodb.value , 240);
//    WriteCookie ( 'stv_nodb', document.formv1.h_nodb.value , 240);
//    WriteCookie ( 'stv_ucod', document.formv1.h_ucod.value , 240);
//    WriteCookie ( 'stv_drod', document.formv1.h_drod.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_dodb.value = (ReadCookie ( 'stv_dodb', '1' ));
//    document.formv1.h_nodb.value = (ReadCookie ( 'stv_nodb', 'nazov' ));
//    document.formv1.h_ucod.value = (ReadCookie ( 'stv_ucod', '11200' ));
//    document.formv1.h_drod.value = (ReadCookie ( 'stv_drod', '1' ));
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
    document.formv1.h_dodb.focus();
    document.formv1.h_dodb.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_dodb.value == '' ) okvstup=0;
    if ( document.formv1.h_nodb.value == '' ) okvstup=0;
    if ( document.formv1.h_drod.value == '' ) okvstup=0;
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
<td>EuroSecom  -  Druhy odberateæsk˝ch dokladov
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb ORDER BY dodb");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nodb = strip_tags($_REQUEST['hladaj_nodb']);
$hladaj_dodb = strip_tags($_REQUEST['hladaj_dodb']);

if ( $hladaj_nodb != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( nodb LIKE '%$hladaj_nodb%' ) ORDER BY dodb");
if ( $hladaj_dodb != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( dodb = '$hladaj_dodb' ) ORDER BY dodb");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE NOT ( dodb='$cislo_dodb' ) ORDER BY dodb");
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
<FORM name="formhl1" class="hmenu" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_dodb" id="hladaj_dodb" size="15" value="<?php echo $hladaj_dodb;?>" />
<td class="hmenu"><input type="text" name="hladaj_nodb" id="hladaj_nodb" size="50" value="<?php echo $hladaj_nodb;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
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
 alt="Poloûka Druh fakt˙ry 1=odberateæsk· fakt˙ra, 2=dodacÌ list, 3=vn˙tropodnikov· fakt˙ra,
 11=odber.fakt˙ra DOPRAVA, 12=dodacÌ list DOPRAVA, 13=vn˙tropodnikov· fakt˙ra DOPRAVA,
 14=predfakt˙ra DOPRAVA ">
<th class="hmenu">Parametre<th class="hmenu">VSTR<th class="hmenu">VZAK
<th class="hmenu">CFAK
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="N·sleduj˙ce ËÌslo odberateæskÈho dokladu ( fakt˙ry,dodacieho listu...) pri oddelenom ËÌslovanÌ dokladov , nastavÌ V·m ho V·ö spr·vca webu ">
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
<td class="fmenu" width="10%" ><?php echo $riadok->dodb;?></td>
<td class="fmenu" width="40%" ><?php echo $riadok->nodb;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->drod;?></td>
<td class="fmenu" width="9%" ><?php echo $riadok->ucod;?></td>
<td class="fmenu" width="7%" ><?php echo $riadok->strv;?></td>
<td class="fmenu" width="7%" ><?php echo $riadok->zakv;?></td>
<td class="fmenu" width="7%" ><?php echo $riadok->cfak;?></td>
<td class="fmenu" width="5%" ><a href='dodb.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_dodb=<?php echo $riadok->dodb;?>
&h_dodb=<?php echo $riadok->dodb;?>&h_drod=<?php echo $riadok->drod;?>&h_nodb=<?php echo $riadok->nodb;?>&h_ucod=<?php echo $riadok->ucod;?>
&h_strv=<?php echo $riadok->strv;?>&h_zakv=<?php echo $riadok->zakv;?>
&h_cfak=<?php echo $riadok->cfak;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='dodb.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_dodb=<?php echo $riadok->dodb;?>'>Zmaû</a></td>
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
$h_dodb = strip_tags($_REQUEST['h_dodb']);
$h_nodb = strip_tags($_REQUEST['h_nodb']);
$h_drod = strip_tags($_REQUEST['h_drod']);
$h_ucod = strip_tags($_REQUEST['h_ucod']);
$h_strv = strip_tags($_REQUEST['h_strv']);
$h_zakv = strip_tags($_REQUEST['h_zakv']);
$h_cfak = strip_tags($_REQUEST['h_cfak']);
$cislo_dodb = strip_tags($_REQUEST['cislo_dodb']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_dodb WHERE dodb='$cislo_dodb'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["dodb"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nodb"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drod"];?></td>
<td class="fmenu" width="9%" ><?php echo $zaznam["ucod"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["strv"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["zakv"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["cfak"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_dodb=<?php echo $cislo_dodb;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
 Druh musÌ byù ËÌslo v rozsahu 1 aû 99</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter  musÌ byù ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka DODB=<?php echo $h_dodb;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_dodb=$cislo_dodb"; } ?>
" >

<td class="fmenu"><input type="text" name="h_dodb" id="h_dodb" size="5" 
onchange="return intg(this,1,999999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />


<td class="fmenu"><input type="text" name="h_nodb" id="h_nodb" size="40" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drod" id="h_drod" size="5" 
onchange="return intg(this,1,99,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ucod" id="h_ucod" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_strv" id="h_strv" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_zakv" id="h_zakv" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_cfak" id="h_cfak" size="7" 
onchange="return intg(this,1,99999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
 Poloûka DODB=<?php echo $cislo_dodb;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka DODB=<?php echo $cislo_dodb;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dodb=$hladaj_dodb&hladaj_nodb=$hladaj_nodb";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dodb=$hladaj_dodb&hladaj_nodb=$hladaj_nodb";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="dodb.php?sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
