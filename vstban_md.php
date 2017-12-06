<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'UCT';
$urov = 1100;
$cslm=101300;
if( $copern == 10 ) $urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
//echo "nemazat=".$kli_nemazat;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvuct = include("../ucto/vtvuct.php");
endif;

$sql = "SELECT ddu FROM F$kli_vxcf"."_uctban";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD ddu DATE NOT NULL AFTER dok ";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" SET ddu=dat WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ";
$oznac = mysql_query("$sqtoz");

               }

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

// druh pohybu 1=odber , 2=dodav
$drupoh = strip_tags($_REQUEST['drupoh']);

if( $autovalas == 1 AND $drupoh >= 1 AND $drupoh <= 2 AND ( $kli_uzid == 53 OR $kli_uzid == 54 ) ) $nemazat=0;

//nastavenie uctu
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
if(!isset($hladaj_uce) OR $hladaj_uce == '')
{
if( $drupoh == 1 OR $drupoh == 2 )
{
$sqluce = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 1 ) ORDER BY dpok");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dpok;
  }
}
if( $drupoh == 3 )
{
$sqluce = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 2 ) ORDER BY dpok");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dpok;
  }
}
if( $drupoh == 4 )
{
$sqluce = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dban;
  }
}
if( $drupoh == 5 )
{
  $hladaj_uce=1;
}

}
//koniec nastavenia uctu


if( $drupoh == 1 )
{
$tabl = "pokpri";
$cisdok = "pokpri";
$adrdok = "pokprijem";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 2 )
{
$tabl = "pokvyd";
$cisdok = "pokvyd";
$adrdok = "pokvydaj";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 3 )
{
$tabl = "doppokpri";
$cisdok = "xdp05";
$adrdok = "doppokprijem";
$uctpol = "uctpok";
$uctpoh = "uctpokuct";
}
if( $drupoh == 4 )
{
$tabl = "banvyp";
$cisdok = "uctx04";
$adrdok = "banvyp";
$uctpol = "uctban";
$uctpoh = "uctban";
}
if( $drupoh == 5 )
{
$tabl = "uctvsdh";
$cisdok = "uctx05";
if( $hladaj_uce == 2 ) $cisdok = "uctx13";
$adrdok = "vsdh";
$uctpol = "uctvsdp";
$uctpoh = "uctvsdp";
}

$uloz="NO";
$zmaz="NO";
$uprav="NO";


// 16=vymazanie dokladu potvrdene v vspk_u.php
if ( $copern == 16 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpol WHERE dok='$cislo_dok' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpoh WHERE dok='$cislo_dok' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE dok='$cislo_dok' "); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";

if( ( $cisdokodd != 1 AND $cislo_dok > 1 ) OR $drupoh == 5 )
        {
$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$cislo_dok' WHERE $cisdok > '$cislo_dok'"); 
        }
if( $cisdokodd == 1 AND $drupoh != 5 )
        {

 if( $drupoh == 1 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 2 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cvyd='$cislo_dok' WHERE cvyd > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 3 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 2 AND dpok = $hladaj_uce"; }
 if( $drupoh == 4 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dban SET cban='$cislo_dok' WHERE cban > '$cislo_dok' AND dban = $hladaj_uce"; }
 //echo $upravtt;
 $upravene = mysql_query("$upravttt");
        }

//ak jedna rada pokladne zapis aj v druhom druhu dokladu prij.vyd
if( $pvpokljed == 1 AND $drupoh >= 1 AND $drupoh <= 2 )
{  
 if( $drupoh == 2 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cpri='$cislo_dok' WHERE cpri > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }
 if( $drupoh == 1 AND $cislo_dok > 1 ) { $upravttt = "UPDATE F$kli_vxcf"."_dpok SET cvyd='$cislo_dok' WHERE cvyd > '$cislo_dok' AND drpk = 1 AND dpok = $hladaj_uce"; }

 $upravene = mysql_query("$upravttt");
}
//koniec ak jedna rada pokladne zapis aj v druhom druhu dokladu prij.vyd

//echo "POLOéKA DOK:$cislo_dok BOLA VYMAZAN¡ ";
endif;

//pre vacsiu rychlost nemazem pracovny ak vymazavam doklad include("../ucto/saldo_zmaz_uhr.php");
     }
//koniec vymazania


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zoznam dokladov</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

      function dajuce() 
      { 

  var ucet = document.formhl1.hladaj_uce.value;
<?php if( $sysx != 'UCT' ) { ?>
  var okno = window.open("vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=" + ucet + "&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
<?php if( $sysx == 'UCT' ) { ?>
  var okno = window.open("vstpok.php?sysx=UCT&hladaj_uce=" + ucet + "&rozuct=ANO&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
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

// Kontrola des.cisla v rozsahu x az y  
      function cele(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (b>=x && b<=y) return true; 
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
    document.formhl1.hladaj_nai.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//hladanie
  if ( $copern == 9 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
    }

<?php
  }
//koniec hladania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 10 )
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
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>





<?php if( $_SESSION['nieie'] >= 0 )  { ?>

    function VytlacPokl(doklad)
    {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
    var cislo_dok = doklad;
    window.open('vspk_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }


    function PoklKniha()
    {

    var ucet = document.formhl1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function MesPoklKniha()
    {

    var ucet = document.formhl1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=0&rozuct=<?php echo $rozuct; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }


    function DnesPoklKniha()
    {

<?php $dnesne = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); ?>

window.open('../ucto/uctpohyby_dokxxl.php?uctpohyby=1&cislo_uce=<?php echo $hladaj_uce; ?>&h_obdk=0&h_obdp=0&h_datk=<?php echo $dnesne; ?>&h_datp=<?php echo $dnesne; ?>&copern=40&drupoh=11&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
    }


<?php if ( $drupoh == 1 )  { ?>
    function ZoznamPokl()
    {
    var ucet = document.formhl1.hladaj_uce.value;
    window.open('../ucto/zozdok.php?copern=103&drupoh=1&page=1&cislo_uce=' + ucet + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }
<?php  } ?>

<?php if ( $drupoh == 2 )  { ?>
    function ZoznamPokl()
    {
    var ucet = document.formhl1.hladaj_uce.value;
    window.open('../ucto/zozdok.php?copern=104&drupoh=2&page=1&cislo_uce=' + ucet + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }
<?php  } ?>

<?php                                } ?>



    function Precisluj()
    {
    var hladaj_dok = document.formhl1.hladaj_dok.value;
if( hladaj_dok == 2010 || hladaj_dok == 2011 )
  {    
window.open('../ucto/precisluj_pok.php?cislo_uce=<?php echo $hladaj_uce; ?>&copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&kontrola=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
    }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

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
if( $copern == 9 ) $pols = 900;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  PrÌjmovÈ pokladniËnÈ doklady"; ?>
<?php if( $drupoh == 2 ) echo "<td>EuroSecom  -  V˝davkovÈ pokladniËnÈ doklady"; ?>
<?php if( $drupoh == 3 ) echo "<td>EuroSecom  -  PrÌjmovÈ pokladniËnÈ doklady"; ?>
<?php if( $drupoh == 4 ) echo "<td>EuroSecom  -  BankovÈ v˝pisy"; ?>
<?php if( $drupoh == 5 ) echo "<td>EuroSecom  -  VöeobecnÈ ˙ËtovnÈ doklady"; ?>
<?php if( $sysx == 'UCT' ) echo " - roz˙Ëtovanie"; ?>
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
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 7 && $copern != 9 AND $copern != 10 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
  {
//[[[[[

$sql = mysql_query("SELECT ume, uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dok > 0 AND F$kli_vxcf"."_$tabl.ume >= $kli_vume )".
" OR ( isnull( F$kli_vxcf"."_$tabl.ume) AND F$kli_vxcf"."_$tabl.uce = $hladaj_uce ) ".
" OR ( isnull( F$kli_vxcf"."_$tabl.dat) AND F$kli_vxcf"."_$tabl.uce = $hladaj_uce ) OR isnull( F$kli_vxcf"."_$tabl.uce) OR  F$kli_vxcf"."_$tabl.uce = '' ". 
" GROUP BY dok ORDER BY dok DESC".
"");

  }
// zobraz hladanie vo vsetkych prijemkach
if ( $copern == 9 )
  {

$hladaj_nai = strip_tags($_REQUEST['hladaj_nai']);
$hladaj_dok = strip_tags($_REQUEST['hladaj_dok']);
$hladaj_dat = strip_tags($_REQUEST['hladaj_dat']);
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
$hladaj_txp = strip_tags($_REQUEST['hladaj_txp']);

if ( $hladaj_txp != "" ) {

$sqltx = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND txp LIKE '%$hladaj_txp%' ".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltx");

                        }


if ( $hladaj_nai != "" ) {

$hladaj_ico = 1*$hladaj_nai;

$sqltx = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND ( F$kli_vxcf"."_ico.nai LIKE '%$hladaj_nai%' OR F$kli_vxcf"."_ico.ico = $hladaj_ico )".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltx");

                        }


if ( $hladaj_dat != "" ) {

$chladaj_dat=1*$hladaj_dat;
if( $chladaj_dat == 1 OR $chladaj_dat == 2 OR $chladaj_dat == 3 OR $chladaj_dat == 4 OR $chladaj_dat == 5 OR $chladaj_dat == 6 OR $chladaj_dat == 7 OR $chladaj_dat == 8 OR $chladaj_dat == 9 OR $chladaj_dat == 10 OR $chladaj_dat == 11 OR $chladaj_dat == 12 ) 
{ $hladaj_dat=$chladaj_dat.".".$kli_vrok; }

    if( strlen($hladaj_dat) == 6 OR strlen($hladaj_dat) == 7 )
         {
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.ume = $hladaj_dat ".
" ORDER BY dok DESC".
"";
         }  

    if( strlen($hladaj_dat) != 6 AND strlen($hladaj_dat) != 7 )
         {
         $datsql = SqlDatum($hladaj_dat);
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dat = '$datsql' ".
" ORDER BY dok DESC".
"";

         } 

//echo $sqltt;
$sql = mysql_query("$sqltt");
}

if ( $hladaj_dok != "" ) {

$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai,".
" kto, txp, hod, hodu, unk, zk0u, zk1u, zk2u ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dok = '$hladaj_dok' ".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltt");
}

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
<FORM name="formhl1" class="hmenu" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=15 height=10 border=0 alt="Vyhæad·vanie" title="Vyhæad·vanie" >
<td class="hmenu" >
<?php
if( $kli_uzall >= 20000 AND $sys == 'UCT' AND $drupoh != 3 AND $drupoh != 4 )
  {
?>
<a href="#" onClick="Precisluj();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="PreËÌslovanie dokladov podæa d·tumu za˙Ëtovania ( 2010/2011 ) " title="PreËÌslovanie dokladov podæa d·tumu za˙Ëtovania ( 2010/2011 ) " ></a>
<?php
  }
?>
</tr>
<tr>
<?php
if( $drupoh == 1 OR $drupoh == 2 )
{
$sqls = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 1 ) ORDER BY dpok");
?>
<td class="hmenu">
<select class="hvstup" size="1" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>"  
 onchange="dajuce();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dpok"];?>" >
<?php 
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dpok"];?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 3 )
{
$sqls = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 2 ) ORDER BY dpok");
?>
<td class="hmenu">
<select class="hvstup" size="1" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>"  
 onchange="dajuce();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dpok"];?>" >
<?php 
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dpok"];?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 4 )
{
$sqls = mysql_query("SELECT dban,nban,uceb FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
?>
<td class="hmenu">
<select class="hvstup" size="1" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>"  
 onchange="dajuce();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dban"];?>" >
<?php 
$polmen = $zaznam["nban"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dban"];?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 5 )
{
?>
<td class="hmenu">
<select class="hvstup" size="1" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>"  
 onchange="dajuce();" >
<option value="1" >1</option>
<option value="2" >2</option>
</select>
</td>
<?php
}
?>

<td class="hmenu"><input type="text" name="hladaj_dok" id="hladaj_dok" size="8" value="<?php echo $hladaj_dok;?>" />
<td class="hmenu"><input type="text" name="hladaj_dat" id="hladaj_dat" size="8" value="<?php echo $hladaj_dat;?>" onkeyup="CiarkaNaBodku(this);"/>
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 5 )
{
?>
<td class="hmenu"><input type="text" name="hladaj_nai" id="hladaj_nai" size="30" value="<?php echo $hladaj_nai;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_txp" id="hladaj_txp" size="30" value="<?php echo $hladaj_txp;?>" /> 
<?php
}
?>
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" align="left" colspan="2"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>

<?php
if ( $drupoh == 1 OR $drupoh == 2 )
{
?>
<td class="hmenu">
<a href="#" onClick="PoklKniha();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="PokladniËn· kniha cel˝ rok" title="PokladniËn· kniha cel˝ rok" ></a>
<a href="#" onClick="MesPoklKniha();">
<img src='../obr/orig.png' width=15 height=15 border=0 alt="PokladniËn· kniha za vybran˝ ˙Ëtovn˝ mesiac" title="PokladniËn· kniha za vybran˝ ˙Ëtovn˝ mesiac" ></a>
</td>
<td class="hmenu">
<a href="#" onClick="DnesPoklKniha();">
<img src='../obr/orig.png' width=15 height=15 border=0 alt="PokladniËn· kniha za dneön˝ deÚ" title="PokladniËn· kniha za dneön˝ deÚ" ></a>
<a href="#" onClick="ZoznamPokl();">
<img src='../obr/pdf.png' width=15 height=15 border=0 alt="Zoznam pokladniËn˝ch dokladov za vybran˝ ˙Ëtovn˝ mesiac PDF" title="Zoznam pokladniËn˝ch dokladov za vybran˝ ˙Ëtovn˝ mesiac PDF" ></a>
</td>
<?php
}
?>
<?php
if ( $drupoh == 4 )
{
?>
<td class="hmenu">
<a href="#" onClick="PoklKniha();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="Zostatok bankovÈho ˙Ëtu" title="Zostatok bankovÈho ˙Ëtu" ></a>
</td>
<?php
}
?>

</tr>
</FORM>
<?php
     }
?>

<tr>
<?php
if( $hladaj_dat == '' ) $hladaj_dat=$kli_vume;
$pole = explode(".", $hladaj_dat);
$mesiac_dat=1*$pole[0];
$rok_dat=1*$pole[1];
$mesiac_dap=$mesiac_dat-1;
if( $mesiac_dap == 0 ) $mesiac_dap=1;
$mesiac_dan=$mesiac_dat+1;
if( $mesiac_dan > 12 ) $mesiac_dan=12;
$kli_pume=$mesiac_dap.".".$rok_dat;
$kli_nume=$mesiac_dan.".".$rok_dat;
  if ( $drupoh == 1 OR $drupoh == 3 )
  {
?>
<th class="hmenu">⁄Ëet

<?php
  $ajinvpok=0;
  if (File_Exists ("../invpok/index.php")) { $ajinvpok=1; }
  if( $ajinvpok == 1 )   { ?>
<img src='../obr/orig.png' width=15 height=15 border=0 title="Invent˙ra pokladne"  onclick="window.open('../invpok/invpok.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );" ></a>

<?php                    } ?>


<th class="hmenu">Doklad
<th class="hmenu"><a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
DAT/UME
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<th class="hmenu">PrijatÈ od<th class="hmenu">⁄Ëel
<th class="hmenu"><?php if( $sysx == 'UCT' ){ echo "⁄ËtovanÈ/"; } ?>Hodnota
<th class="hmenu">TlaË<th class="hmenu">Uprav<th class="hmenu">Zmaû<th class="hmenu">Orig
<?php
  }
?>
<?php
  if ( $drupoh == 2 )
  {
?>
<th class="hmenu">⁄Ëet

<?php
  $ajinvpok=0;
  if (File_Exists ("../ucto/invpok/index.php")) { $ajinvpok=1; }
  if( $ajinvpok == 1 )   { ?>
<img src='../obr/orig.png' width=15 height=15 border=0 title="Invent˙ra pokladne"  onclick="window.open('../ucto/invpok/invpok.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );" ></a>

<?php                    } ?>

<th class="hmenu">Doklad
<th class="hmenu"><a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
DAT/UME
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<th class="hmenu">VyplatenÈ komu<th class="hmenu">⁄Ëel
<th class="hmenu"><?php if( $sysx == 'UCT' ){ echo "⁄ËtovanÈ/"; } ?>Hodnota
<th class="hmenu">TlaË<th class="hmenu">Uprav<th class="hmenu">Zmaû<th class="hmenu">Orig
<?php
  }
?>
<?php
  if ( $drupoh == 4 )
  {
?>
<th class="hmenu">⁄Ëet<th class="hmenu">Doklad
<th class="hmenu"><a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
DAT/UME
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<th class="hmenu">Vklady<th class="hmenu">V˝bery
<th class="hmenu">Rozdiel
<th class="hmenu">TlaË<th class="hmenu">Uprav<th class="hmenu">Zmaû<th class="hmenu">Orig
<?php
  }
?>
<?php
  if ( $drupoh == 5 )
  {
?>
<th class="hmenu">Druh<th class="hmenu">Doklad
<th class="hmenu"><a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_pume; ?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_pume; ?>" title="Doklady za mesiac <?php echo $kli_pume; ?>" ></a>
DAT/UME
<a href="#" onClick="window.open('../ucto/vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=9&page=1&drupoh=<?php echo $drupoh; ?>&hladaj_dat=<?php echo $kli_nume; ?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt="Doklady za mesiac <?php echo $kli_nume; ?>" title="Doklady za mesiac <?php echo $kli_nume; ?>" ></a>
<th class="hmenu">Firma<th class="hmenu">⁄Ëel
<th class="hmenu">Hodnota
<th class="hmenu">TlaË<th class="hmenu">Uprav<th class="hmenu">Zmaû<th class="hmenu">Orig
<?php
  }
?>
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
<td class="fmenu" width="7%" ><?php echo $riadok->uce;?></td>
<td class="fmenu" width="8%" >
<?php
$uctminusdok=$riadok->hodu-$riadok->hod;
  if ( $sysx == 'UCT' )
  {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/zoznam.png' width=15 height=12 border=0 alt="Roz˙Ëtovanie dokladu" title="Roz˙Ëtovanie dokladu" ></a>
<?php
  }
?>
<?php echo $riadok->dok;?>
<?php if( $uctminusdok < 0 AND $riadok->hod != 0 AND $sysx == 'UCT' AND $drupoh < 4 ) echo " <img src='../obr/pozor.png' width=12 height=12 border=0 alt='Doklad nie je spr·vne roz˙Ëtovan˝' title='Doklad nie je spr·vne roz˙Ëtovan˝' >"; ?>
</td>
<td class="fmenu" width="8%" ><?php echo $riadok->dat;?></td>
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
{
?>
<td class="fmenu" width="25%" ><?php echo $riadok->ico;?> <?php echo $riadok->nai;?> <?php echo $riadok->kto;?></td>
<td class="fmenu" width="23%" ><?php echo $riadok->txp;?></td>
<td class="fmenu" width="12%" align="right"><?php if( $sysx == 'UCT' ) { echo $riadok->hodu.' / '; } ?><?php echo $riadok->hod;?></td>
<?php
}
?>
<?php
if( $drupoh == 4 )
{
?>
<td class="fmenu" width="25%" align="right"><?php echo $riadok->zk0u;?></td>
<td class="fmenu" width="23%" align="right"><?php echo $riadok->zk1u;?></td>
<td class="fmenu" width="12%" align="right"><?php echo $riadok->zk2u;?></td>
<?php
}
?>
<?php
if( $drupoh == 5 )
{
?>
<td class="fmenu" width="25%" ><?php echo $riadok->ico;?> <?php echo $riadok->nai;?></td>
<td class="fmenu" width="23%" ><?php echo $riadok->txp;?></td>
<td class="fmenu" width="12%" align="right"><?php echo $riadok->hodu;?></td>
<?php
}
?>
<?php
$tlaclenpdf=1;
if( $kli_vrok < 2014 ) { $tlaclenpdf=0; }
if( $_SESSION['nieie'] == 1 ) { $tlaclenpdf=1; }
?>
<td class="fmenu" width="5%" >
<?php if( $tlaclenpdf == 0 )  { ?>
<a href="#" onClick="window.open('vspk_t.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu HTML" ></a>
<?php                                } ?>
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
{
?>
<a href="#" onClick="VytlacPokl(<?php echo $riadok->dok;?>);">
<img src='../obr/pdf.png' width=15 height=10 border=0 alt="TlaË vybranÈho dokladu PDF" title="TlaË vybranÈho dokladu PDF" ></a>
<?php
}
?>
<?php
if( $drupoh == 4 OR $drupoh == 5 )
{
?>
<a href="#" onClick="VytlacPokl(<?php echo $riadok->dok;?>);">
<img src='../obr/pdf.png' width=15 height=10 border=0 alt="TlaË vybranÈho dokladu PDF" title="TlaË vybranÈho dokladu PDF" ></a>
<?php
}
?>
</td>
<td class="fmenu" width="4%" >
<?php
if( $copern != 10 AND $drupoh != 4 AND $drupoh != 5  )
{
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=NIE&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 alt="⁄prava vybranÈho dokladu" title="⁄prava vybranÈho dokladu" ></a></td>
<?php
}
?>
<td class="fmenu" width="4%" >
<?php
if( $copern != 10 AND $kli_nemazat != 1 )
{
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranÈho dokladu" title="Vymazanie vybranÈho dokladu" ></a></td></a>
<?php
}
?>
</td>
<td class="fmenu" width="4%" >
<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.pdf' target="_blank">
<img src='../obr/pdf.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.jpg' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.bmp") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.bmp' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.gif' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.png' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 alt="Zobrazenie origin·lu  dokladu" title="Zobrazenie origin·lu dokladu" ></a>
<?php
} 
?></td>
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
//koniec 1,2,3,4,7,9

//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Doklad DOK=<?php echo $cislo_dok;?> vymazan˝</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $xstr;?>" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1" >
<INPUT type="submit" name="npol" id="npol" value="Nov˝ doklad" >
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
if( $copern == 1 ) { 
$zmenume=1; 
$odkaz="../ucto/vstpok.php?copern=1&drupoh=$drupoh&page=1&sysx=$sysx&hladaj_uce=$hladaj_uce&rozuct=$rozuct"; 
                   }
//echo $odkaz;

$cislista = include("uct_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
