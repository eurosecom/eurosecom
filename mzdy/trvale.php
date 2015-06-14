<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$copern = 1*$_REQUEST['copern'];
$urov = 2000;
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

$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp ADD pbic VARCHAR(10) NOT NULL AFTER iban ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzaltrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");

// cislo operacie
$zkun = 1*$_REQUEST['zkun'];
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$h_oc = strip_tags($_REQUEST['h_oc']);
$h_dm = strip_tags($_REQUEST['h_dm']);
$h_kc = strip_tags($_REQUEST['h_kc']);
$h_mn = strip_tags($_REQUEST['h_mn']);
$h_trx1 = strip_tags($_REQUEST['h_trx1']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_vsy = strip_tags($_REQUEST['h_vsy']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);
$h_iban = strip_tags($_REQUEST['h_iban']);
$h_pbic = strip_tags($_REQUEST['h_pbic']);

if( $copern == 101 ) { $cislo_oc = 1*$_SESSION['vyb_osc']; $copern=1; }

$tlacitkoenter=0;
if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 ) { $tlacitkoenter=1; }


//uprava 
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdtrn WHERE cpl = $cislo_cpl ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_oc = $riadok->oc;
$h_dm = $riadok->dm;
$h_uceb = $riadok->uceb;
$h_numb = $riadok->numb;
$h_vsy = $riadok->vsy;
$h_ksy = $riadok->ksy;
$h_ssy = $riadok->ssy;
$h_iban = $riadok->trx4;
$h_pbic = $riadok->trx3;
$h_kc = $riadok->kc;
$h_mn = $riadok->mn;
$h_trx1 = $riadok->trx1;
  }
    }
//koniec copern=8 nacitanie

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v trvale.php
// 6=vymazanie polozky potvrdene v trvale.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);
$uloztt = "INSERT INTO F$kli_vxcf"."_mzdtrn".
" ( oc,dm,uceb,numb,vsy,ksy,ssy,kc,mn,trx1,trx4,trx3 )".
" VALUES ($h_oc, '$h_dm', '$h_uceb', '$h_numb', '$h_vsy', '$h_ksy', '$h_ssy', '$h_kc', '$h_mn', '$h_trx1', '$h_iban', '$h_pbic' ) "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

if( ( $h_dm == 101 OR $h_dm == 107 ) AND $h_trx1 == 1 ) { include("vypocet_sz4.php"); }

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

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_mzdtrn WHERE cpl='$cislo_cpl'"); 
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


$h_dar = SqlDatum($h_dar);
$h_dsk = SqlDatum($h_dsk);

$upravttt = "UPDATE F$kli_vxcf"."_mzdtrn SET oc='$h_oc', dm='$h_dm', numb='$h_numb',
 uceb='$h_uceb', vsy='$h_vsy', ksy='$h_ksy', ssy='$h_ssy', kc='$h_kc', mn='$h_mn', trx1='$h_trx1', trx4='$h_iban', trx3='$h_pbic' WHERE cpl='$cislo_cpl'";  
$upravene = mysql_query("$upravttt");
//echo $upravttt;

if( ( $h_dm == 101 OR $h_dm == 107 ) AND $h_trx1 == 1 ) { include("vypocet_sz4.php"); }

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
<title>TrvalÈ poloûky</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
      function UrobOnClick()
               {
               }

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
    document.formv1.h_dm.value = '<?php echo "$h_dm";?>';
    document.formv1.h_uceb.value = '<?php echo "$h_uceb";?>';
    document.formv1.h_numb.value = '<?php echo "$h_numb";?>';
    document.formv1.h_vsy.value = '<?php echo "$h_vsy";?>';
    document.formv1.h_ksy.value = '<?php echo "$h_ksy";?>';
    document.formv1.h_ssy.value = '<?php echo "$h_ssy";?>';
    document.formv1.h_iban.value = '<?php echo "$h_iban";?>';
    document.formv1.h_pbic.value = '<?php echo "$h_pbic";?>';
    document.formv1.h_kc.value = '<?php echo "$h_kc";?>';
    document.formv1.h_mn.value = '<?php echo "$h_mn";?>';
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
    <?php if( $zkun == 1 ) 
    {
    echo "document.formv1.h_oc.value='$cislo_oc';"; 
    echo "document.formv1.h_dm.select();";
    echo "document.formv1.h_dm.focus();";
    }
    ?>
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_oc.value == '' ) okvstup=0;
    if ( document.formv1.h_dm.value == '' ) okvstup=0;

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
if( $copern == 9 ) $pols=100;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  TrvalÈ mzdovÈ poloûky
 <a href="#" onClick="window.open('mesacnadavka_tlac.php?&copern=2&page=1','_blank','<?php echo $tlcswin; ?>')">
<img src='../obr/tlac.png' width=15 height=15 border=0 title='TlaË trval˝ch mzdov˝ch zloûiek za <?php echo $kli_vume; ?> podæa zamestnancov ' ></a>
 <a href="#" onClick="window.open('mesacnadavka_tlac.php?&copern=12&page=1','_blank','<?php echo $tlcswin; ?>')">
<img src='../obr/tlac.png' width=15 height=15 border=0 title='TlaË trval˝ch mzdov˝ch zloûiek za <?php echo $kli_vume; ?> podæa zloûiek mzdy ' ></a>

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
if( $zkun == 1 ) $podm_oc="AND F$kli_vxcf"."_mzdtrn.oc = ".$cislo_oc;


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
$stt = "SELECT cpl,F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm,kc,trx1,trx4,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdkun.prie, ".
" F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.vsy,F$kli_vxcf"."_mzdtrn.ksy,F$kli_vxcf"."_mzdtrn.ssy,trx3 ".
" FROM F$kli_vxcf"."_mzdtrn ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdtrn.dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdtrn.oc > 0 $podm_oc ORDER BY F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm";
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_uceb = strip_tags($_REQUEST['hladaj_uceb']);
$hladaj_dm = strip_tags($_REQUEST['hladaj_dm']);
$hladaj_vsy = strip_tags($_REQUEST['hladaj_vsy']);
$hladaj_oc = strip_tags($_REQUEST['hladaj_oc']);


if ( $hladaj_dm != "" ) $stt = "SELECT cpl,F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm,kc,trx1,trx4,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdkun.prie, ".
" F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.vsy,F$kli_vxcf"."_mzdtrn.ksy,F$kli_vxcf"."_mzdtrn.ssy,trx3 ".
" FROM F$kli_vxcf"."_mzdtrn ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdtrn.dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdtrn.dm = '$hladaj_dm' $podm_oc ORDER BY F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm";
if ( $hladaj_oc != "" ) $stt = "SELECT cpl,F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm,kc,trx1,trx4,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdkun.prie, ".
" F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.vsy,F$kli_vxcf"."_mzdtrn.ksy,F$kli_vxcf"."_mzdtrn.ssy,trx3 ".
" FROM F$kli_vxcf"."_mzdtrn ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdtrn.dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdtrn.oc = '$hladaj_oc' $podm_oc ORDER BY F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm";
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$stt = "SELECT cpl,F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm,kc,trx1,trx4,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdkun.prie, ".
" F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.vsy,F$kli_vxcf"."_mzdtrn.ksy,F$kli_vxcf"."_mzdtrn.ssy,trx3 ".
" FROM F$kli_vxcf"."_mzdtrn ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdtrn.dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdtrn.oc > 0 $podm_oc ORDER BY F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm";
  }

// zobraz nova
if ( $copern == 5 )
  {
$stt = "SELECT cpl,F$kli_vxcf"."_mzdtrn.oc,F$kli_vxcf"."_mzdtrn.dm,kc,trx1,trx4,F$kli_vxcf"."_mzdtrn.uceb,F$kli_vxcf"."_mzddmn.nzdm,F$kli_vxcf"."_mzdkun.prie, ".
" F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdtrn.numb,F$kli_vxcf"."_mzdtrn.vsy,F$kli_vxcf"."_mzdtrn.ksy,F$kli_vxcf"."_mzdtrn.ssy,trx3 ".
" FROM F$kli_vxcf"."_mzdtrn ".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdtrn.dm=F$kli_vxcf"."_mzddmn.dm".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdtrn.oc > 0 $podm_oc ORDER BY F$kli_vxcf"."_mzdtrn.datm";
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
<FORM name="formhl1" class="hmenu" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_oc" id="hladaj_oc" size="11" value="<?php echo $hladaj_oc;?>" />
<td class="hmenu"><input type="text" name="hladaj_dm" id="hladaj_dm" size="20" value="<?php echo $hladaj_dm;?>" /> 

<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="20%" >Os.ËÌslo</td>
<td class="hmenu" width="30%" >DM</td>
<td class="hmenu" width="10%" ><?php echo $mena1;?></td>
<td class="hmenu" width="30%" >IBAN BIC / Banka / Num / Vsy / Ksy / Ssy</td>
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
<td class="fmenu" ><?php echo $riadok->dm;?> <?php echo $riadok->nzdm;?></td>
<td class="fmenu" ><?php echo $riadok->kc;?></td>
<td class="fmenu" ><?php echo $riadok->trx4;?> <?php echo $riadok->trx3;?> / <?php echo $riadok->uceb;?> / <?php echo $riadok->numb;?> / <?php echo $riadok->vsy;?> / <?php echo $riadok->ksy;?> / <?php echo $riadok->ssy;?></td>
<td class="fmenu" width="5%" ><a href='trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_cpl=<?php echo $riadok->cpl;?>&h_oc=<?php echo $riadok->oc;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 title="⁄prava ˙dajov"></a></td>
<td class="fmenu" width="5%" ><a href='trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_cpl=<?php echo $riadok->cpl;?>'>Zmaû</a></td>
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

$sqlp = "SELECT * FROM F$kli_vxcf"."_mzdtrn WHERE cpl='$cislo_cpl'";
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
<td class="fmenu"  width="30%" ><?php echo $zaznam["dm"];?></td>
<td class="fmenu"  width="10%" ><?php echo $zaznam["kc"];?></td>
<td class="fmenu"  width="30%" ><?php echo $zaznam["uceb"];?> / <?php echo $zaznam["numb"];?> / <?php echo $zaznam["vsy"];?> <?php echo $zaznam["ksy"];?>, <?php echo $zaznam["ssy"];?></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_cpl=<?php echo $cislo_cpl;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
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
<FORM name="formv1" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cpl=$cislo_cpl"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="hmenu" width="10%" align="right">Os.ËÌslo:</td>
<td class="fmenu" width="10%">
<input class="fmenu" type="text" name="h_oc" id="h_oc" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,9999,Cele,document.formv1.err_dm)" onkeyup="KontrolaCisla(this, Cele)"  />
*</td>

<td class="hmenu" width="10%" align="right">DM:</td>
<td class="fmenu" width="10%">
<input class="fmenu" type="text" name="h_dm" id="h_dm" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,9999,Cele,document.formv1.err_dm)" onkeyup="KontrolaCisla(this, Cele)"  />
*</td>

<td class="hmenu" width="10%" align="right"><?php echo $mena1;?>:</td>
<td class="fmenu" width="10%">
<input type="text" name="h_kc" id="h_kc" size="12"
 onkeyup="KontrolaDcisla(this, Desc)" />
*</td>


<td class="hmenu" width="10%" align="right">PR
 <img src='../obr/info.png' width=12 height=12 border=0 title="Zaökrtnut· poloûka znamen· , ûe dni a hodiny tejto trvalej mzdovej zloûky 
sa vypoËÌtj˙ z fondu mesaËnÈho pracovnÈho Ëasu , znÌûenÈho o neodpracovan˝ Ëas ( nemoc, n·hrady prac.Ëasu ... )">
 <input type="checkbox" name="h_trx1" value="1"  /><?php if ( $h_trx1 == 1 ) { ?>
<script type="text/javascript">
document.formv1.h_trx1.checked = "checked";
</script> <?php                                                                } ?>
</td>

<td class="hmenu" width="10%" align="right">%PrÈmiÌ:
 <img src='../obr/info.png' width=12 height=12 border=0 title="Ak zad·te hodnotu napr. 20.00 na dm=101, program automaticky k vypoËÌtanej
mzde na dm=101 vypoËÌta 20% prÈmiÌ na dm=301">
</td>
<td class="fmenu" width="10%">
<input type="text" name="h_mn" id="h_mn" size="12"
 onkeyup="KontrolaDcisla(this, Desc)" />
</td>

</tr>
<tr></tr>



<tr>
<td class="hmenu" colspan="4">Bankov˝ ˙Ëet na ˙hradu zr·ûky:</td>
</tr>
<td class="hmenu" width="10%">ËÌslo ˙Ëtu:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_uceb" id="h_uceb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">num.kÛd:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_numb" id="h_numb" onclick="Fx.style.display='none';" /></td>
<td class="hmenu" width="10%">IBAN:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_iban" id="h_iban" size="34" onclick="Fx.style.display='none';" /></td>
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
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
<?php                           }  ?>
</td>
<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&page=1&copern=1" >
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
<FORM name="forma2" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&
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
<FORM name="forma1" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&
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
<FORM name="forma3" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="trvale.php?cislo_oc=<?php echo $cislo_oc; ?>&zkun=<?php echo $zkun; ?>&sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
