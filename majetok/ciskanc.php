<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'HIM';
$urov = 2000;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmaj";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmaj = include("../majetok/vtvmaj.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v ciskanc.php
// 6=vymazanie polozky potvrdene v ciskanc.php
if ( $copern == 15 || $copern == 16 )
     {
$h_kanc = strip_tags($_REQUEST['h_kanc']);
$h_nkan = strip_tags($_REQUEST['h_nkan']);
$h_ukan = strip_tags($_REQUEST['h_ukan']);
$h_pkan = strip_tags($_REQUEST['h_pkan']);
$cislo_kanc = strip_tags($_REQUEST['cislo_kanc']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_kancelarie ( kanc,nkan,ukan,pkan ) VALUES ('$h_kanc', '$h_nkan', $h_ukan, '$h_pkan'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA kanc:$h_kanc SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_kancelarie WHERE kanc='$cislo_kanc'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA kanc:$cislo_kanc BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_kanc = strip_tags($_REQUEST['h_kanc']);
$h_nkan = strip_tags($_REQUEST['h_nkan']);
$h_ukan = strip_tags($_REQUEST['h_ukan']);
$h_pkan = strip_tags($_REQUEST['h_pkan']);
$cislo_kanc = strip_tags($_REQUEST['cislo_kanc']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_kancelarie SET kanc='$h_kanc', nkan='$h_nkan', ukan='$h_ukan', pkan='$h_pkan' WHERE kanc='$cislo_kanc'");  
$copern=1;
$cislo_kanc = $h_kanc;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA kanc:$cislo_kanc UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_kanc = strip_tags($_REQUEST['h_kanc']);
$h_nkan = strip_tags($_REQUEST['h_nkan']);
$h_ukan = strip_tags($_REQUEST['h_ukan']);
$h_pkan = strip_tags($_REQUEST['h_pkan']);
$cislo_kanc = strip_tags($_REQUEST['h_kanc']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_kanc = strip_tags($_REQUEST['cislo_kanc']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Kancel·rie</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//posuny Enter[[[[[[[[[[[

function KancEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nkan.focus();
        document.forms.formv1.h_nkan.select();
              }
                }

function NkanEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_ukan.focus();
        document.forms.formv1.h_ukan.select();
              }
                }

function UkanEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_pkan.focus();
        document.forms.formv1.h_pkan.select();
              }
                }

function PkanEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_kanc.value == '' ) okvstup=0;
    if ( document.formv1.h_nkan.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_kanc.value == '' ) { document.formv1.h_kanc.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nkan.value == '' ) { document.formv1.h_nkan.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//koniec posunov enter

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
    document.formhl1.hladaj_nkan.focus();
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
    document.formv1.h_kanc.value = '<?php echo "$h_kanc";?>';
    document.formv1.h_nkan.value = '<?php echo "$h_nkan";?>';
    document.formv1.h_ukan.value = '<?php echo "$h_ukan";?>';
    document.formv1.h_pkan.value = '<?php echo "$h_pkan";?>';
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

    return (true);
    }

    function Obnov_vstup()
    {

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
    document.formv1.h_kanc.focus();
    document.formv1.h_kanc.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_kanc.value == '' ) okvstup=0;
    if ( document.formv1.h_nkan.value == '' ) okvstup=0;
    if ( document.formv1.h_ukan.value == '' ) okvstup=0;
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

    function TlacKanc()
    {

window.open('ciskanc_pdf.php?copern=20&drupoh=1&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }

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
<td>EuroSecom  -  Zoznam kancel·riÌ
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie ORDER BY kanc");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nkan = strip_tags($_REQUEST['hladaj_nkan']);
$hladaj_kanc = strip_tags($_REQUEST['hladaj_kanc']);

if ( $hladaj_nkan != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie WHERE ( nkan LIKE '%$hladaj_nkan%' ) ORDER BY kanc");
if ( $hladaj_kanc != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie WHERE ( kanc = '$hladaj_kanc' ) ORDER BY kanc");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie WHERE NOT ( kanc='$cislo_kanc' ) ORDER BY kanc");
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
<FORM name="formhl1" class="hmenu" method="post" action="ciskanc.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" ><img src='../obr/tlac.png' onClick='TlacKanc();' width=20 height=12 border=0 title="TlaË ËÌselnÌka kancel·riÌ" >
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_kanc" id="hladaj_kanc" size="15" value="<?php echo $hladaj_kanc;?>" />
<td class="hmenu"><input type="text" name="hladaj_nkan" id="hladaj_nkan" size="50" value="<?php echo $hladaj_nkan;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="ciskanc.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>


<tr>
<td class="hmenu" width="10%" >Kancel·ria
<td class="hmenu" width="30%" >Popis
<td class="hmenu" width="30%" >Parameter1
<td class="hmenu" width="20%" >Parameter2
<td class="hmenu" width="5%" >Uprav
<th class="hmenu" width="5%" >Zmaû
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
<td class="fmenu" ><?php echo $riadok->kanc;?></td>
<td class="fmenu" ><?php echo $riadok->nkan;?></td>
<td class="fmenu" ><?php echo $riadok->ukan;?></td>
<td class="fmenu" ><?php echo $riadok->pkan;?></td>
<td class="fmenu" ><a href='ciskanc.php?copern=8&page=<?php echo $page;?>&cislo_kanc=<?php echo $riadok->kanc;?>&h_ukan=<?php echo $riadok->ukan;?>&h_kanc=<?php echo $riadok->kanc;?>&h_nkan=<?php echo $riadok->nkan;?>&h_pkan=<?php echo $riadok->pkan;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" ><a href='ciskanc.php?copern=6&page=<?php echo $page;?>&cislo_kanc=<?php echo $riadok->kanc;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>
<?php
if ( $copern != 5 AND $copern != 8 )
  {
?>

<tr><td colspan="9"><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td></tr>

<?php
}
?>
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
$h_kanc = strip_tags($_REQUEST['h_kanc']);
$h_nkan = strip_tags($_REQUEST['h_nkan']);
$h_ukan = strip_tags($_REQUEST['h_ukan']);
$h_pkan = strip_tags($_REQUEST['h_pkan']);
$cislo_kanc = strip_tags($_REQUEST['cislo_kanc']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_kancelarie WHERE kanc='$cislo_kanc'";
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
<td class="fmenu" ><?php echo $zaznam["kanc"];?></td>
<td class="fmenu" ><?php echo $zaznam["nkan"];?></td>
<td class="fmenu" ><?php echo $zaznam["ukan"];?></td>
<td class="fmenu" ><?php echo $zaznam["pkan"];?></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="ciskanc.php?page=<?php echo $page;?>&copern=16>&cislo_kanc=<?php echo $cislo_kanc;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="ciskanc.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter1 musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter2 musÌ byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka kanc=<?php echo $h_kanc;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="ciskanc.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_kanc=$cislo_kanc"; } ?>
" >

<td class="fmenu"><input type="text" name="h_kanc" id="h_kanc" size="20" onclick="Fx.style.display='none';"
onKeyDown="return KancEnter(event.which)" />


<td class="fmenu"><input type="text" name="h_nkan" id="h_nkan" size="40" 
onclick="Fx.style.display='none';" onKeyDown="return NkanEnter(event.which)" /></td>

<td class="fmenu"><input type="text" name="h_ukan" id="h_ukan" size="5" 
onchange="return intg(this,1,9,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" onKeyDown="return UkanEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_pkan" id="h_pkan" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" onKeyDown="return PkanEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="ciskanc.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
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
 Poloûka kanc=<?php echo $cislo_kanc;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka kanc=<?php echo $cislo_kanc;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="ciskanc.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_kanc=$hladaj_kanc&hladaj_nkan=$hladaj_nkan";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="ciskanc.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_kanc=$hladaj_kanc&hladaj_nkan=$hladaj_nkan";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="ciskanc.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="ciskanc.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
$cislista = include("maj_lista.php");
       } while (false);
?>
</BODY>
</HTML>
