<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 3000;
$cslm=101804;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvvyr = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v dban.php
// 6=vymazanie polozky potvrdene v dban.php
if ( $copern == 15 || $copern == 16 )
     {
$h_dban = strip_tags($_REQUEST['h_dban']);
$h_nban = strip_tags($_REQUEST['h_nban']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_twib = strip_tags($_REQUEST['h_twib']);
$h_parb = strip_tags($_REQUEST['h_parb']);
$h_cban = 1*$_REQUEST['h_cban'];
if( $h_cban == 0 ) { $h_cban=1; }
$cislo_dban = strip_tags($_REQUEST['cislo_dban']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = "INSERT INTO F$kli_vxcf"."_dban ( dban,nban,uceb,numb,iban,twib,parb,cban ) VALUES ".
"($h_dban, '$h_nban', '$h_uceb', '$h_numb', '$h_iban', '$h_twib', '$h_parb', '$h_cban'); "; 

$ulozene = mysql_query("$ulozttt"); 

$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA dban:$h_dban SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dban WHERE dban='$cislo_dban'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA dban:$cislo_dban BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_dban = strip_tags($_REQUEST['h_dban']);
$h_nban = strip_tags($_REQUEST['h_nban']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_twib = strip_tags($_REQUEST['h_twib']);
$h_parb = strip_tags($_REQUEST['h_parb']);
$h_cban = 1*$_REQUEST['h_cban'];
if( $h_cban == 0 ) { $h_cban=1; }
$cislo_dban = strip_tags($_REQUEST['cislo_dban']);

$upravttt = "UPDATE F$kli_vxcf"."_dban SET dban='$h_dban', nban='$h_nban', uceb='$h_uceb', numb='$h_numb',".
" iban='$h_iban', twib='$h_twib', parb='$h_parb', cban='$h_cban' WHERE dban='$cislo_dban'";  
$upravene = mysql_query("$upravttt");  

$copern=1;
$cislo_dban = $h_dban;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA dban:$cislo_dban UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_dban = strip_tags($_REQUEST['h_dban']);
$cislo_dban = strip_tags($_REQUEST['h_dban']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_dban WHERE dban = $cislo_dban ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nban = $riadok->nban;
$h_uceb = $riadok->uceb;
$h_numb = $riadok->numb;
$h_iban = $riadok->iban;
$h_twib = $riadok->twib;
$h_parb = $riadok->parb;
$h_cban = $riadok->cban;

  }
       }
//koniec uprava nacitanie

//6=uprava
if ( $copern == 6 )
  {
$cislo_dban = strip_tags($_REQUEST['cislo_dban']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>BankovÈ ˙Ëty</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">



// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         errflag.value = "0";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         errflag.value = "0";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nban.focus();
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
    document.formv1.h_dban.value = '<?php echo "$h_dban";?>';
    document.formv1.h_nban.value = '<?php echo "$h_nban";?>';
    document.formv1.h_uceb.value = '<?php echo "$h_uceb";?>';
    document.formv1.h_numb.value = '<?php echo "$h_numb";?>';
    document.formv1.h_iban.value = '<?php echo "$h_iban";?>';
    document.formv1.h_twib.value = '<?php echo "$h_twib";?>';
    document.formv1.h_parb.value = '<?php echo "$h_parb";?>';
    document.formv1.h_cban.value = '<?php echo "$h_cban";?>';
    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>

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
    document.formv1.h_dban.focus();
    document.formv1.h_dban.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_dban.value == '' ) okvstup=0;
    if ( document.formv1.h_nban.value == '' ) okvstup=0;
    if ( document.formv1.h_uceb.value == '' ) okvstup=0;
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
<td>EuroSecom  -  BankovÈ ˙Ëty
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dban ORDER BY dban");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nban = strip_tags($_REQUEST['hladaj_nban']);
$hladaj_dban = strip_tags($_REQUEST['hladaj_dban']);

if ( $hladaj_nban != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE ( nban LIKE '%$hladaj_nban%' ) ORDER BY dban");
if ( $hladaj_dban != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE ( dban = '$hladaj_dban' ) ORDER BY dban");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE NOT ( dban='$cislo_dban' ) ORDER BY dban");
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
<FORM name="formhl1" class="hmenu" method="post" action="dban.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_dban" id="hladaj_dban" size="15" value="<?php echo $hladaj_dban;?>" />
<td class="hmenu"><input type="text" name="hladaj_nban" id="hladaj_nban" size="50" value="<?php echo $hladaj_nban;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="dban.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >DRUH
<td class="hmenu" width="25%" >N·zov
<td class="hmenu" width="10%" >Bank.˙Ëet
<td class="hmenu" width="5%" >NUM
<td class="hmenu" width="20%" >IBAN
<td class="hmenu" width="10%" >SWIFT
<td class="hmenu" width="5%" >Parameter
<th class="hmenu">CBAN
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="N·sleduj˙ce ËÌslo bankovÈho v˝pisu pri oddelenom ËÌslovanÌ dokladov , nastavÌ V·m ho V·ö spr·vca webu ">
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
<td class="fmenu" ><?php echo $riadok->dban;?></td>
<td class="fmenu" ><?php echo $riadok->nban;?></td>
<td class="fmenu" ><?php echo $riadok->uceb;?></td>
<td class="fmenu" ><?php echo $riadok->numb;?></td>
<td class="fmenu" ><?php echo $riadok->iban;?></td>
<td class="fmenu" ><?php echo $riadok->twib;?></td>
<td class="fmenu" ><?php echo $riadok->parb;?></td>
<td class="fmenu" ><?php echo $riadok->cban;?></td>
<td class="fmenu" ><a href='dban.php?copern=8&page=<?php echo $page;?>&cislo_dban=<?php echo $riadok->dban;?>
&h_dban=<?php echo $riadok->dban;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='dban.php?copern=6&page=<?php echo $page;?>&cislo_dban=<?php echo $riadok->dban;?>'>Zmaû</a></td>
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
$h_dban = strip_tags($_REQUEST['h_dban']);
$h_nban = strip_tags($_REQUEST['h_nban']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_twib = strip_tags($_REQUEST['h_twib']);
$h_parb = strip_tags($_REQUEST['h_parb']);
$h_cban = strip_tags($_REQUEST['h_cban']);
$cislo_dban = strip_tags($_REQUEST['cislo_dban']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_dban WHERE dban='$cislo_dban'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["dban"];?></td>
<td class="fmenu" width="35%" ><?php echo $zaznam["nban"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["uceb"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["numb"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["iban"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["twib"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["parb"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["cban"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="dban.php?page=<?php echo $page;?>&copern=16>&cislo_dban=<?php echo $cislo_dban;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="dban.php?page=<?php echo $page;?>&copern=1" >
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
<span id="dban" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 ⁄Ëet musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù celÈ ËÌslo </span>
<span id="Desat" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù celÈ ËÌslo </span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka dban=<?php echo $h_dban;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="dban.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_dban=$cislo_dban"; } ?>
" >

<td class="fmenu"><input type="text" name="h_dban" id="h_dban" size="5" onclick="Fx.style.display='none';"
onchange="return intg(this,0,9999999,dban,document.formv1.err_dban)" 
 onkeyup="KontrolaCisla(this, dban)" />
<INPUT type="hidden" name="err_dban" value="0"></td>


<td class="fmenu"><input type="text" name="h_nban" id="h_nban" size="30" /></td>

<td class="fmenu"><input type="text" name="h_uceb" id="h_uceb" size="25" /></td>

<td class="fmenu"><input type="text" name="h_numb" id="h_numb" size="5" 
onchange="return intg(this,0,9999,Cele,document.formv1.err_numb)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_numb" value="0"></td>

<td class="fmenu"><input type="text" name="h_iban" id="h_iban" size="25" /></td>

<td class="fmenu"><input type="text" name="h_twib" id="h_twib" size="25" /></td>

<td class="fmenu"><input type="text" name="h_parb" id="h_parb" size="5" 
onchange="return intg(this,0,999,Cele,document.formv1.err_parb)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_parb" value="0"></td>

<td class="fmenu"><input type="text" name="h_cban" id="h_cban" size="7" 
onchange="return intg(this,1,99999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="dban.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka dban=<?php echo $cislo_dban;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka dban=<?php echo $cislo_dban;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="dban.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dban=$hladaj_dban&hladaj_nban=$hladaj_nban";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="dban.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dban=$hladaj_dban&hladaj_nban=$hladaj_nban";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="dban.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="dban.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
