<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 3000;
$cslm=101802;
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

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v ddod.php
// 6=vymazanie polozky potvrdene v ddod.php
if ( $copern == 15 || $copern == 16 )
     {
$h_ddod = strip_tags($_REQUEST['h_ddod']);
$h_ndod = strip_tags($_REQUEST['h_ndod']);
$h_drdo = strip_tags($_REQUEST['h_drdo']);
$h_ucdo = strip_tags($_REQUEST['h_ucdo']);
$h_cfak = 1*$_REQUEST['h_cfak'];
if( $h_cfak == 0 ) { $h_cfak=1; }
$cislo_ddod = strip_tags($_REQUEST['cislo_ddod']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_ddod ( ddod,ndod,drdo,ucdo,cfak ) VALUES ($h_ddod, '$h_ndod', $h_drdo, '$h_ucdo', '$h_cfak'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLO�KA NEBOLA SPR�VNE ULO�EN� " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLO�KA ddod:$h_ddod SPR�VNE ULO�EN� ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_ddod WHERE ddod='$cislo_ddod'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLO�KA NEBOLA VYMAZAN� " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLO�KA ddod:$cislo_ddod BOLA VYMAZAN� ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_ddod = strip_tags($_REQUEST['h_ddod']);
$h_ndod = strip_tags($_REQUEST['h_ndod']);
$h_drdo = strip_tags($_REQUEST['h_drdo']);
$h_ucdo = strip_tags($_REQUEST['h_ucdo']);
$h_cfak = 1*$_REQUEST['h_cfak'];
if( $h_cfak == 0 ) { $h_cfak=1; }
$cislo_ddod = strip_tags($_REQUEST['cislo_ddod']);

$upravttt = "UPDATE F$kli_vxcf"."_ddod SET ddod='$h_ddod', ndod='$h_ndod', drdo='$h_drdo', ucdo='$h_ucdo', cfak='$h_cfak' WHERE ddod='$cislo_ddod'";  
$upravene = mysql_query("$upravttt");  
$copern=1;
$cislo_ddod = $h_ddod;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLO�KA NEBOLA UPRAVEN� " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLO�KA ddod:$cislo_ddod UPRAVEN� ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_ddod = strip_tags($_REQUEST['h_ddod']);
$h_ndod = strip_tags($_REQUEST['h_ndod']);
$h_drdo = strip_tags($_REQUEST['h_drdo']);
$h_ucdo = strip_tags($_REQUEST['h_ucdo']);
$h_cfak = strip_tags($_REQUEST['h_cfak']);
$cislo_ddod = strip_tags($_REQUEST['h_ddod']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_ddod = strip_tags($_REQUEST['cislo_ddod']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>�.DOD.fakt�r</title>
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
    document.formhl1.hladaj_ndod.focus();
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
    document.formv1.h_ddod.value = <?php echo "$h_ddod";?>;
    document.formv1.h_ndod.value = '<?php echo "$h_ndod";?>';
    document.formv1.h_drdo.value = <?php echo "$h_drdo";?>;
    document.formv1.h_ucdo.value = '<?php echo "$h_ucdo";?>';
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
//    WriteCookie ( 'stv_ddod', document.formv1.h_ddod.value , 240);
//    WriteCookie ( 'stv_ndod', document.formv1.h_ndod.value , 240);
//    WriteCookie ( 'stv_ucdo', document.formv1.h_ucdo.value , 240);
//    WriteCookie ( 'stv_drdo', document.formv1.h_drdo.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_ddod.value = (ReadCookie ( 'stv_ddod', '1' ));
//    document.formv1.h_ndod.value = (ReadCookie ( 'stv_ndod', 'nazov' ));
//    document.formv1.h_ucdo.value = (ReadCookie ( 'stv_ucdo', '11200' ));
//    document.formv1.h_drdo.value = (ReadCookie ( 'stv_drdo', '1' ));
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
    document.formv1.h_ddod.focus();
    document.formv1.h_ddod.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_ddod.value == '' ) okvstup=0;
    if ( document.formv1.h_ndod.value == '' ) okvstup=0;
    if ( document.formv1.h_drdo.value == '' ) okvstup=0;
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
<td>EuroSecom  -  Druhy dod�vate�sk�ch dokladov
<?php
  if ( $copern == 5 ) echo "- nov� polo�ka";
  if ( $copern == 8 ) echo "- �prava polo�ky";
  if ( $copern == 6 ) echo "- vymazanie polo�ky";
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod ORDER BY ddod");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_ndod = strip_tags($_REQUEST['hladaj_ndod']);
$hladaj_ddod = strip_tags($_REQUEST['hladaj_ddod']);

if ( $hladaj_ndod != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod WHERE ( ndod LIKE '%$hladaj_ndod%' ) ORDER BY ddod");
if ( $hladaj_ddod != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod WHERE ( ddod = '$hladaj_ddod' ) ORDER BY ddod");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod WHERE NOT ( ddod='$cislo_ddod' ) ORDER BY ddod");
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
<FORM name="formhl1" class="hmenu" method="post" action="ddod.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_ddod" id="hladaj_ddod" size="15" value="<?php echo $hladaj_ddod;?>" />
<td class="hmenu"><input type="text" name="hladaj_ndod" id="hladaj_ndod" size="50" value="<?php echo $hladaj_ndod;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="H�ada�" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="ddod.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="V�etko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">Druh<th class="hmenu">N�zov<th class="hmenu">Typ<th class="hmenu">Parametre
<th class="hmenu">CFAK
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="N�sleduj�ce ��slo dod�vate�sk�ho dokladu pri oddelenom ��slovan� dokladov , nastav� V�m ho V� spr�vca webu ">
<th class="hmenu">Uprav<th class="hmenu">Zma�
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
<td class="fmenu" width="10%" ><?php echo $riadok->ddod;?></td>
<td class="fmenu" width="50%" ><?php echo $riadok->ndod;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->drdo;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ucdo;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cfak;?></td>
<td class="fmenu" width="5%" ><a href='ddod.php?copern=8&page=<?php echo $page;?>&cislo_ddod=<?php echo $riadok->ddod;?>
&h_ddod=<?php echo $riadok->ddod;?>&h_drdo=<?php echo $riadok->drdo;?>&h_ndod=<?php echo $riadok->ndod;?>
&h_ucdo=<?php echo $riadok->ucdo;?>&h_cfak=<?php echo $riadok->cfak;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='ddod.php?copern=6&page=<?php echo $page;?>&cislo_ddod=<?php echo $riadok->ddod;?>'>Zma�</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
if ( $copern != 5 AND $copern != 8 AND $copern != 6 ) echo "</table>";
?>

<tr><?php echo "Strana:$page  Celkom polo�iek/str�n v celej tabulke:$cpol/$xstr ";?></tr>

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
$h_ddod = strip_tags($_REQUEST['h_ddod']);
$h_ndod = strip_tags($_REQUEST['h_ndod']);
$h_drdo = strip_tags($_REQUEST['h_drdo']);
$h_ucdo = strip_tags($_REQUEST['h_ucdo']);
$h_cfak = strip_tags($_REQUEST['h_cfak']);
$cislo_ddod = strip_tags($_REQUEST['cislo_ddod']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_ddod WHERE ddod='$cislo_ddod'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["ddod"];?></td>
<td class="fmenu" width="50%" ><?php echo $zaznam["ndod"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drdo"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ucdo"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cfak"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="ddod.php?page=<?php echo $page;?>&copern=16>&cislo_ddod=<?php echo $cislo_ddod;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymaza� polo�ku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="ddod.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymaza�" ></td>
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
 ��slo odber.fakt�ry mus� by� cel� kladn� ��slo v rozsahu 1 a� 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh mus� by� ��slo v rozsahu 1 a� 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter  mus� by� ��slo v rozsahu 1 a� 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Mus�te vyplni� v�etky polo�ky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Polo�ka ddod=<?php echo $h_ddod;?> spr�vne ulo�en�</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="ddod.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_ddod=$cislo_ddod"; } ?>
" >

<td class="fmenu"><input type="text" name="h_ddod" id="h_ddod" size="5" 
onchange="return intg(this,1,999999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />


<td class="fmenu"><input type="text" name="h_ndod" id="h_ndod" size="40" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drdo" id="h_drdo" size="5" 
onchange="return intg(this,1,9,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ucdo" id="h_ucdo" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_cfak" id="h_cfak" size="7" 
onchange="return intg(this,1,99999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� polo�ku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymaza� formul�r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="ddod.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
<?php
if ( $copern == 5 )
{
?>
<td class="obyc" align="right"><INPUT type="reset" onclick="Obnov_vstup();" id="obnovp" name="obnovp" value="Opakova� hodnoty" ></td>
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
 Zadajte ��slo strany - �daj mus� by� cel� kladn� ��slo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Polo�ka ddod=<?php echo $cislo_ddod;?> zmazan�</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Polo�ka ddod=<?php echo $cislo_ddod;?> upraven�</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="ddod.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ddod=$hladaj_ddod&hladaj_ndod=$hladaj_ndod";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predo�l� strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="ddod.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ddod=$hladaj_ddod&hladaj_ndod=$hladaj_ndod";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="�al�ia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="ddod.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejs� na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="ddod.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vlo�i� nov� polo�ku" >
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
