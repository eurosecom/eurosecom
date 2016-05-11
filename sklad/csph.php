<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 3000;
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

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v csph.php
// 6=vymazanie polozky potvrdene v csph.php
if ( $copern == 15 || $copern == 16 )
     {
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_drp = strip_tags($_REQUEST['h_drp']);
$h_nph = strip_tags($_REQUEST['h_nph']);
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_pph = strip_tags($_REQUEST['h_pph']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcph ( poh,drp,nph,ucm,ucd,pph ) VALUES ($h_poh, $h_drp, '$h_nph', $h_ucm, $h_ucd, $h_pph); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_sklcph WHERE poh='$cislo_poh'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_drp = strip_tags($_REQUEST['h_drp']);
$h_nph = strip_tags($_REQUEST['h_nph']);
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_pph = strip_tags($_REQUEST['h_pph']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklcph SET poh='$h_poh', drp='$h_drp', nph='$h_nph', ucm='$h_ucm', ucd='$h_ucd', pph='$h_pph' WHERE poh='$cislo_poh'");  
$copern=1;
$cislo_poh = $h_poh;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_drp = strip_tags($_REQUEST['h_drp']);
$h_nph = strip_tags($_REQUEST['h_nph']);
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_pph = strip_tags($_REQUEST['h_pph']);
$cislo_poh = strip_tags($_REQUEST['h_poh']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
  }

$zver=0;
if (File_Exists ("../zver.php")) 
{ 
$zver=1;
}

if( $zver == 1 )
{
$poslhh = "SELECT * FROM F$kli_vxcf"."_sklcph WHERE poh = 6 ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
  {
$ttvv = "TRUNCATE F$kli_vxcf"."_sklcph ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '2', 'MAT PrÌjem z fakt˙r', 1, '112000', '111000', 1 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '3', 'MAT PrÌjem v hotovosti', 1, '112000', '111000', 1 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '5', 'MAT Presun', 5, '112000', '112000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '6', 'MAT Produkcia hl.v˝robok', 2, '123000', '613000', 1 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '7', 'MAT Produkcia vedl.v˝robok', 2, '123000', '613000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '9', 'MAT Predaj', 6, '542000', '112000', 1 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '10', 'MAT V˝daj', 6, '501000', '112000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '20', 'ZVR N·kup zvierat', 2, '124000', '111100', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '22', 'ZVR Narodenie zvierat', 2, '124000', '614220', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '42', 'ZVR Preradenie zvierat prÌjem', 2, '124000', '395030', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '23', 'ZVR PrÌrastok hmotnosti zvierat', 2, '124000', '614230', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '50', 'ZVR Predaj zvierat', 7, '614500', '124000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '51', 'ZVR Predaj Ëlenom', 7, '614500', '124000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '70', 'ZVR Mank· a Ëkody zvierat', 7, '614700', '124000', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '82', 'ZVR Preradenie zvierat v˝daj', 7, '124000', '395030', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '92', 'ZVR K‡mne dni zvierat', 2, '0', '0', 1 )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_sklcph ( poh,nph,drp,ucm,ucd,pph ) VALUES ( '75', 'ZVR Preradenie zvierat do z·kl.st·da', 7, '395030', '124000', 1 )";
$ttqq = mysql_query("$ttvv");
  }
}
//koniec ak zver=1


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>»ÌselnÌk skladov˝ch pohybov</title>
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
    document.formhl1.hladaj_nph.focus();
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
    document.formv1.h_poh.value = <?php echo "$h_poh";?>;
    document.formv1.h_drp.value = <?php echo "$h_drp";?>;
    document.formv1.h_nph.value = '<?php echo "$h_nph";?>';
    document.formv1.h_ucm.value = <?php echo "$h_ucm";?>;
    document.formv1.h_ucd.value = <?php echo "$h_ucd";?>;
    document.formv1.h_pph.value = '<?php echo "$h_pph";?>';
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
//    WriteCookie ( 'pcph_poh', document.formv1.h_poh.value , 240);
//    WriteCookie ( 'pcph_drp', document.formv1.h_drp.value , 240);
//    WriteCookie ( 'pcph_nph', document.formv1.h_nph.value , 240);
//    WriteCookie ( 'pcph_ucm', document.formv1.h_ucm.value , 240);
//    WriteCookie ( 'pcph_ucd', document.formv1.h_ucd.value , 240);
//    WriteCookie ( 'pcph_pph', document.formv1.h_pph.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_poh.value = (ReadCookie ( 'pcph_poh', '1' ));
//    document.formv1.h_drp.value = (ReadCookie ( 'pcph_drp', '1' ));
//    document.formv1.h_nph.value = (ReadCookie ( 'pcph_nph', 'Nazov' ));
//    document.formv1.h_ucm.value = (ReadCookie ( 'pcph_ucm', '1' ));
//    document.formv1.h_ucd.value = (ReadCookie ( 'pcph_ucd', '1' ));
//    document.formv1.h_pph.value = (ReadCookie ( 'pcph_pph', '1' ));

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
    document.formv1.h_poh.focus();
    document.formv1.h_poh.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_drp.value == '' ) okvstup=0;
    if ( document.formv1.h_nph.value == '' ) okvstup=0;
    if ( document.formv1.h_pph.value == '' ) okvstup=0;
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
<td>EuroSecom  -  »ÌselnÌk skladov˝ch pohybov
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph ORDER BY poh");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nph = strip_tags($_REQUEST['hladaj_nph']);
$hladaj_poh = strip_tags($_REQUEST['hladaj_poh']);

if ( $hladaj_nph != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph WHERE ( nph LIKE '%$hladaj_nph%' ) ORDER BY poh");
if ( $hladaj_poh != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph WHERE ( poh = '$hladaj_poh' ) ORDER BY poh");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph WHERE NOT ( poh='$cislo_poh' ) ORDER BY poh");
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
<FORM name="formhl1" class="hmenu" method="post" action="csph.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_poh" id="hladaj_poh" size="15" value="<?php echo $hladaj_poh;?>" />
<td class="hmenu"><input type="text" name="hladaj_nph" id="hladaj_nph" size="50" value="<?php echo $hladaj_nph;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="csph.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">»Ìslo pohybu<th class="hmenu">N·zov pohybu
<th class="hmenu">Druh
 <img src='../obr/info.png' width=10 height=10 border=0
 title="Poloûka Druh pohybu znamen· 1 aû 4=prÌjmovÈ pohyby , 5=presun , 6 aû 9=v˝dajovÈ pohyby.">
<th class="hmenu">UCM
 <img src='../obr/info.png' width=10 height=10 border=0
 title="Poloûku UCM program pouûÌva pre ˙Ëtovanie M·Daù v˝daja , proti˙Ëet berie z ËÌselnÌka skladov.">
<th class="hmenu">UCD
 <img src='../obr/info.png' width=10 height=10 border=0
 title="Poloûku UCD program pouûÌva pre ˙Ëtovanie Dal prÌjmu , proti˙Ëet berie z ËÌselnÌka skladov.">
<th class="hmenu">Parametre
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
<td class="fmenu" width="10%" ><?php echo $riadok->poh;?></td>
<td class="fmenu" width="40%" ><?php echo $riadok->nph;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->drp;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ucm;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ucd;?></td>
<td class="fmenu" width="5%" ><?php echo $riadok->pph;?></td>
<td class="fmenu" width="5%" ><a href='csph.php?copern=8&page=<?php echo $page;?>&cislo_poh=<?php echo $riadok->poh;?>&h_drp=<?php echo $riadok->drp;?>&h_poh=<?php echo $riadok->poh;?>&h_nph=<?php echo $riadok->nph;?>&h_ucm=<?php echo $riadok->ucm;?>&h_ucd=<?php echo $riadok->ucd;?>&h_pph=<?php echo $riadok->pph;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='csph.php?copern=6&page=<?php echo $page;?>&cislo_poh=<?php echo $riadok->poh;?>'>Zmaû</a></td>
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
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_drp = strip_tags($_REQUEST['h_drp']);
$h_nph = strip_tags($_REQUEST['h_nph']);
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_pph = strip_tags($_REQUEST['h_pph']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_sklcph WHERE poh='$cislo_poh'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["poh"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nph"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drp"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ucm"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ucd"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["pph"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="csph.php?page=<?php echo $page;?>&copern=16>&cislo_poh=<?php echo $cislo_poh;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="csph.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo pohybu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999</span>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh pohybu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9 prÌjem=1aû4,5=presun,v˝daj=6aû9</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 ⁄Ëet musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka POH=<?php echo $h_poh;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="csph.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_poh=$cislo_poh&"; } ?>
" >


<td class="fmenu"><input type="text" name="h_poh" id="h_poh" size="8" 
onchange="return intg(this,1,999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />

<td class="fmenu"><input type="text" name="h_nph" id="h_nph" size="30" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drp" id="h_drp" size="8" 
onchange="return intg(this,1,9,Cx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cx)" />

<td class="fmenu"><input type="text" name="h_ucm" id="h_ucm" size="5" 
onchange="return intg(this,0,9999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />


<td class="fmenu"><input type="text" name="h_ucd" id="h_ucd" size="5" 
onchange="return intg(this,0,9999999,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_pph" id="h_pph" size="5" 
onchange="return intg(this,1,9999999,Ex)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="csph.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka POH=<?php echo $cislo_poh;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka POH=<?php echo $cislo_poh;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="csph.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_poh=$hladaj_poh&hladaj_nph=$hladaj_nph";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="csph.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_poh=$hladaj_poh&hladaj_nph=$hladaj_nph";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="csph.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="csph.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="csph_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_nph=$hladaj_nph&hladaj_poh=$hladaj_poh";
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
