<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$copern = 1*$_REQUEST['copern'];
$sys = 'MZD';

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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

$sql = "ALTER TABLE F$kli_vxcf"."_mzdcisddp MODIFY iban VARCHAR(50) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdcisddp MODIFY pt3 VARCHAR(35) NOT NULL ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$cislo_cddp = strip_tags($_REQUEST['cislo_cddp']);
$h_cddp = strip_tags($_REQUEST['h_cddp']);
$h_nddp = strip_tags($_REQUEST['h_nddp']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_vsy = strip_tags($_REQUEST['h_vsy']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_pbic = strip_tags($_REQUEST['h_pbic']);



//uprava 
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE cddp = $cislo_cddp ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_cddp = $riadok->cddp;
$h_nddp = $riadok->nddp;
$h_uceb = $riadok->uceb;
$h_numb = $riadok->numb;
$h_vsy = $riadok->vsy;
$h_ksy = $riadok->ksy;
$h_ssy = $riadok->ssy;
$h_iban = $riadok->iban;
$h_pbic = $riadok->pt3;
  }
    }
//koniec copern=8 nacitanie

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v cisddp.php
// 6=vymazanie polozky potvrdene v cisddp.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_cddp = strip_tags($_REQUEST['cislo_cddp']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_cddp = AddSlashes($h_cddp);
$h_nddp = AddSlashes($h_nddp);
$h_uceb = AddSlashes($h_uceb);
$h_numb = AddSlashes($h_numb);
$h_vsy = AddSlashes($h_vsy);
$h_ksy = AddSlashes($h_ksy);
$h_ssy = AddSlashes($h_ssy);

$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);
$uloztt = "INSERT INTO F$kli_vxcf"."_mzdcisddp".
" ( cddp,nddp,uceb,numb,vsy,ksy,ssy,iban,pt3 )".
" VALUES ($h_cddp, '$h_nddp', '$h_uceb', '$h_numb', '$h_vsy', '$h_ksy', '$h_ssy', '$h_iban', '$h_pbic' ) "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA cddp:$h_cddp SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_mzdcisddp WHERE cddp='$cislo_cddp'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA cddp:$cislo_cddp BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {

$h_cddp = AddSlashes($h_cddp);
$h_nddp = AddSlashes($h_nddp);
$h_uceb = AddSlashes($h_uceb);
$h_numb = AddSlashes($h_numb);
$h_vsy = AddSlashes($h_vsy);
$h_ksy = AddSlashes($h_ksy);
$h_ssy = AddSlashes($h_ssy);
$h_iban = AddSlashes($h_iban);
$h_pbic = AddSlashes($h_pbic);

$cislo_cddp = strip_tags($_REQUEST['cislo_cddp']);
$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_mzdcisddp SET cddp='$h_cddp', nddp='$h_nddp', numb='$h_numb',
 uceb='$h_uceb', vsy='$h_vsy', ksy='$h_ksy', ssy='$h_ssy', iban='$h_iban', pt3='$h_pbic' WHERE cddp='$cislo_cddp'");  
$copern=1;
$cislo_cddp = $h_cddp;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA cddp:$cislo_cddp UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_cddp = strip_tags($_REQUEST['h_cddp']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_cddp = strip_tags($_REQUEST['cislo_cddp']);
  }


//echo $h_dar;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DDP</title>
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
    document.formhl1.hladaj_uceb.focus();
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
    document.formv1.h_cddp.value = '<?php echo "$h_cddp";?>';
    document.formv1.h_nddp.value = '<?php echo "$h_nddp";?>';
    document.formv1.h_uceb.value = '<?php echo "$h_uceb";?>';
    document.formv1.h_numb.value = '<?php echo "$h_numb";?>';
    document.formv1.h_vsy.value = '<?php echo "$h_vsy";?>';
    document.formv1.h_ksy.value = '<?php echo "$h_ksy";?>';
    document.formv1.h_ssy.value = '<?php echo "$h_ssy";?>';
    document.formv1.h_iban.value = '<?php echo "$h_iban";?>';
    document.formv1.h_pbic.value = '<?php echo "$h_pbic";?>';
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
    <?php if( $copern == 5 ) echo "document.formv1.h_cddp.focus();"; ?>
    <?php if( $copern == 5 ) echo "document.formv1.h_cddp.select();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nddp.focus();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_nddp.select();"; ?>
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_cddp.value == '' ) okvstup=0;
    if ( document.formv1.h_nddp.value == '' ) okvstup=0;

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
$pols = 10;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Zoznam DDP
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp ORDER BY cddp");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_uceb = strip_tags($_REQUEST['hladaj_uceb']);
$hladaj_nddp = strip_tags($_REQUEST['hladaj_nddp']);
$hladaj_vsy = strip_tags($_REQUEST['hladaj_vsy']);
$hladaj_cddp = strip_tags($_REQUEST['hladaj_cddp']);

if ( $hladaj_vsy != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE ( tel LIKE '%$hladaj_vsy%' ) ORDER BY cddp");
if ( $hladaj_nddp != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE ( nddp LIKE '%$hladaj_nddp%' ) ORDER BY cddp");
if ( $hladaj_uceb != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE ( uceb LIKE '%$hladaj_uceb%' ) ORDER BY cddp");
if ( $hladaj_cddp != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE ( cddp = '$hladaj_cddp' ) ORDER BY cddp");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE cddp > 0 ORDER BY cddp");

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
<FORM name="formhl1" class="hmenu" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_cddp" id="hladaj_cddp" size="11" value="<?php echo $hladaj_cddp;?>" />
<td class="hmenu"><input type="text" name="hladaj_nddp" id="hladaj_nddp" size="20" value="<?php echo $hladaj_nddp;?>" /> 

<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >ËÌslo</td>
<td class="hmenu" width="30%" >n·zov</td>
<td class="hmenu" width="25%" >bankov˝ ˙Ëet</td>
<td class="hmenu" width="25%" >symboly platby</td>
<td class="hmenu" width="5%" >Uprav</td>
<td class="hmenu" width="5%" >Zmaû</td>

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
<td class="fmenu" ><?php echo $riadok->cddp;?></td>
<td class="fmenu" ><?php echo $riadok->nddp;?></td>
<td class="fmenu" ><?php echo $riadok->iban;?> /  <?php echo $riadok->uceb;?> /  <?php echo $riadok->numb;?></td>
<td class="fmenu" ><?php echo $riadok->vsy;?> / <?php echo $riadok->ksy;?> / <?php echo $riadok->ssy;?></td>
<td class="fmenu" width="5%" ><a href='cisddp.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_cddp=<?php echo $riadok->cddp;?>&h_cddp=<?php echo $riadok->cddp;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 title="⁄prava ˙dajov"></a></td>
<td class="fmenu" width="5%" ><a href='cisddp.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_cddp=<?php echo $riadok->cddp;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>
</table>
<table class="fmenu" width="100%" >
<tr><td><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td></tr>
</table>
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
$cislo_cddp = strip_tags($_REQUEST['cislo_cddp']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE cddp='$cislo_cddp'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu" width="100%" >
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%" ><?php echo $zaznam["cddp"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["nddp"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["uceb"];?> / <?php echo $zaznam["numb"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["vsy"];?> <?php echo $zaznam["ksy"];?>, <?php echo $zaznam["ssy"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_cddp=<?php echo $cislo_cddp;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_cddp;?> spr·vne uloûen·</span>
</tr>
<tr>
</table>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cddp=$cislo_cddp"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="hmenu" width="10%">»Ìslo:</td>
<td class="fmenu" width="15%">
<?php
if ( $copern == 5 )
     {
?>
<input type="text" name="h_cddp" id="h_cddp" 
onchange="return intg(this,1,9999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />*</td>
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
echo "   ".$h_cddp;
?>
<input type="hidden" name="h_cddp" id="h_cddp" /></td>
<?php
     }
?>
<td class="hmenu" width="10%">n·zov:</td>
<td class="fmenu" colspan="3">
<input type="text" name="h_nddp" id="h_nddp" size="50" onclick="Fx.style.display='none';" />*</td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="4">Bankov˝ ˙Ëet na ˙hradu poistnÈho:</td>
</tr>
<td class="hmenu" width="10%">ËÌslo ˙Ëtu:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_uceb" id="h_uceb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">num.kÛd:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_numb" id="h_numb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">IBAN:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_iban" id="h_iban" size="37" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">BIC(swift):</td>
<td class="fmenu" width="15%">
<input type="text" name="h_pbic" id="h_pbic" size="12" onclick="Fx.style.display='none';" /></td>
</tr>
<tr></tr>
<tr>
<td class="hmenu" colspan="4">Symboly platby:</td>
</tr>
<tr>
<td class="hmenu" >Variabiln˝:</td>
<td class="fmenu" >
<input type="text" name="h_vsy" id="h_vsy" /></td>
<td class="hmenu" >Konötantn˝:</td>
<td class="fmenu" >
<input type="text" name="h_ksy" id="h_ksy" /></td>
<td class="hmenu" width="10%">äpecifick˝:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_ssy" id="h_ssy" /></td>
</tr>

<tr></tr>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
 Poloûka OS»=<?php echo $cislo_cddp;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_cddp;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cddp=$hladaj_cddp&hladaj_uceb=$hladaj_uceb&hladaj_nddp=$hladaj_nddp&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cddp=$hladaj_cddp&hladaj_uceb=$hladaj_uceb&hladaj_nddp=$hladaj_nddp&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cisddp.php?sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cvod_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_uceb=$hladaj_uceb&hladaj_cddp=$hladaj_cddp";
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


$cislista = include("../mzdy/mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
