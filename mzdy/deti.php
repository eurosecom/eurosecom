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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$zkun = strip_tags($_REQUEST['zkun']);
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$h_oc = strip_tags($_REQUEST['h_oc']);
$h_md = strip_tags($_REQUEST['h_md']);
$h_rcd = strip_tags($_REQUEST['h_rcd']);
$h_dr = strip_tags($_REQUEST['h_dr']);
$h_trx1 = strip_tags($_REQUEST['h_trx1']);

if( $copern == 101 ) { $cislo_oc = 1*$_SESSION['vyb_osc']; $copern=1; }


//uprava 
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzddeti WHERE cpl = $cislo_cpl ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_oc = $riadok->oc;
$h_md = $riadok->md;
$h_rcd = $riadok->rcd;
$h_dr = $riadok->dr;
$h_trx1 = $riadok->trx1;

$sk_dr = SkDatum($h_dr);
  }
    }
//koniec copern=8 nacitanie

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v deti.php
// 6=vymazanie polozky potvrdene v deti.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_dr = SqlDatum($h_dr);

$uloztt = "INSERT INTO F$kli_vxcf"."_mzddeti".
" ( oc,md,rcd,dr )".
" VALUES ($h_oc, '$h_md', '$h_rcd', '$h_dr' ) "; 
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
//echo "POLOéKA oc:$h_oc SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_mzddeti WHERE cpl='$cislo_cpl'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA oc:$cislo_oc BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {


$h_dr = SqlDatum($h_dr);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_mzddeti SET oc='$h_oc', md='$h_md', rcd='$h_rcd', dr='$h_dr' WHERE cpl='$cislo_cpl'");  
$copern=1;
$cislo_oc = $h_oc;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA oc:$cislo_oc UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_oc = strip_tags($_REQUEST['h_oc']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
  }


//echo $h_dar;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Deti</title>
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
    document.formv1.h_oc.value = '<?php echo "$h_oc";?>';
    document.formv1.h_md.value = '<?php echo "$h_md";?>';
    document.formv1.h_rcd.value = '<?php echo "$h_rcd";?>';
    document.formv1.h_dr.value = '<?php echo "$sk_dr";?>';
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
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
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
    <?php if( $copern == 5 ) echo "document.formv1.h_oc.focus();"; ?>
    <?php if( $copern == 5 ) echo "document.formv1.h_oc.select();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_oc.focus();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_oc.select();"; ?>
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_oc.value == '' ) okvstup=0;
    if ( document.formv1.h_md.value == '' ) okvstup=0;

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

function tlacDeti()
                    {
window.open('deti_pdf.php?copern=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
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
$pols = 10;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Deti
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
$podm_oc="";
if( $zkun == 1 ) $podm_oc="AND F$kli_vxcf"."_mzddeti.oc = ".$cislo_oc;


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
$stt = "SELECT * ".
" FROM F$kli_vxcf"."_mzddeti ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzddeti.oc > 0 $podm_oc ORDER BY F$kli_vxcf"."_mzddeti.oc";
  }
// zobraz hladanie
if ( $copern == 9 )
  {


$hladaj_md = strip_tags($_REQUEST['hladaj_md']);
$hladaj_oc = strip_tags($_REQUEST['hladaj_oc']);


if ( $hladaj_md != "" ) $stt = "SELECT * ".
" FROM F$kli_vxcf"."_mzddeti ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzddeti.dm = '$hladaj_dm' $podm_oc ORDER BY F$kli_vxcf"."_mzddeti.oc";
if ( $hladaj_oc != "" ) $stt = "SELECT * ".
" FROM F$kli_vxcf"."_mzddeti ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzddeti.oc = '$hladaj_oc' $podm_oc ORDER BY F$kli_vxcf"."_mzddeti.oc";
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$stt = "SELECT * ".
" FROM F$kli_vxcf"."_mzddeti ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzddeti.oc > 0 $podm_oc ORDER BY F$kli_vxcf"."_mzddeti.oc";
  }

// zobraz nova
if ( $copern == 5 )
  {
$stt = "SELECT * ".
" FROM F$kli_vxcf"."_mzddeti ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzddeti.oc > 0 $podm_oc ORDER BY md";
  }

$sql = mysql_query("$stt");

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
<FORM name="formhl1" class="hmenu" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" >
<a href="#" onclick="tlacDeti();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="TlaË zoznamu detÌ vöetk˝ch zamestnancov"></a>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_oc" id="hladaj_oc" size="11" value="<?php echo $hladaj_oc;?>" />
<td class="hmenu"><input type="text" name="hladaj_md" id="hladaj_md" size="20" value="<?php echo $hladaj_md;?>" /> 

<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="20%" >Os.ËÌslo</td>
<td class="hmenu" width="30%" >Meno dieùaùa</td>
<td class="hmenu" width="10%" >RodnÈ ËÌslo</td>
<td class="hmenu" width="30%" >D·tum narodenia</td>
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
<td class="fmenu" ><?php echo $riadok->oc;?> <?php echo $riadok->prie;?> <?php echo $riadok->meno;?></td>
<td class="fmenu" ><?php echo $riadok->md;?></td>
<td class="fmenu" ><?php echo $riadok->rcd;?></td>
<td class="fmenu" ><?php echo $riadok->dr;?></td>
<td class="fmenu" width="5%" ><a href='deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_cpl=<?php echo $riadok->cpl;?>&h_oc=<?php echo $riadok->oc;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 alt="⁄prava ˙dajov"></a></td>
<td class="fmenu" width="5%" ><a href='deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_cpl=<?php echo $riadok->cpl;?>'>Zmaû</a></td>
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
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_mzddeti WHERE cpl='$cislo_cpl'";
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
<td class="fmenu"  width="20%" ><?php echo $zaznam["oc"];?></td>
<td class="fmenu"  width="30%" ><?php echo $zaznam["md"];?></td>
<td class="fmenu"  width="10%" ><?php echo $zaznam["rcd"];?></td>
<td class="fmenu"  width="30%" ><?php echo $zaznam["dr"];?></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_cpl=<?php echo $cislo_cpl;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Dm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 DM musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<tr>
</table>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cpl=$cislo_cpl"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="hmenu" width="15%" align="right">Os.ËÌslo:</td>
<td class="fmenu" width="25%">
<input class="fmenu" type="text" name="h_oc" id="h_oc" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,9999,Cele,document.formv1.err_oc)" onkeyup="KontrolaCisla(this, Cele)"  />
*</td>
</tr>

<tr>
<td class="hmenu" align="right">Meno dieùaùa:</td>
<td class="fmenu" >
<input class="fmenu" type="text" name="h_md" id="h_md" size="25" maxlength="25" 
 onclick="UrobOnClick()" />
*</td>
</tr>

<tr>
<td class="hmenu" align="right">RodnÈ ËÌslo:</td>
<td class="fmenu" >
<input type="text" name="h_rcd" id="h_rcd" size="12" />
</td>

<tr>
<td class="hmenu" align="right">D·tum narodenia:</td>
<td class="fmenu" >
<input type="text" name="h_dr" id="h_dr" size="10" maxlength="10" />
</td>
</tr>

<tr></tr>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=1" >
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
 Poloûka OS»=<?php echo $cislo_oc;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_oc;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_oc=$hladaj_oc&hladaj_uceb=$hladaj_uceb&hladaj_dm=$hladaj_dm&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_oc=$hladaj_oc&hladaj_uceb=$hladaj_uceb&hladaj_dm=$hladaj_dm&hladaj_vsy=$hladaj_vsy";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="deti.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
echo "?copern=11&hladaj_uceb=$hladaj_uceb&hladaj_oc=$hladaj_oc";
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
