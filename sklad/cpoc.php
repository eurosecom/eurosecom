<HTML>
<?php

//celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
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
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$vybr = strip_tags($_REQUEST['vybr']);
$vybr_skl = strip_tags($_REQUEST['vybr_skl']);
$vybr_cis = strip_tags($_REQUEST['vybr_cis']);
$vybr_nat = strip_tags($_REQUEST['vybr_nat']);
$vybr_mer = strip_tags($_REQUEST['vybr_mer']);
$hlad = strip_tags($_REQUEST['hlad']);
$hlad_skl = strip_tags($_REQUEST['h_skl']);
$hlad_cis = strip_tags($_REQUEST['h_cis']);
$hlad_nat = strip_tags($_REQUEST['h_nat']);

$citfir = include("../cis/citaj_fir.php");

//import z ../import/sklpoc.txt
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/sklpoc.csv ?") )
         { window.close()  }
else
         { location.href='cpoc.php?copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/SKLPOC.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/SKLPOC.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/SKLPOC.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_skl = $pole[0];
  $x_cis = $pole[1];
  $x_nat = $pole[2];
  $x_cen = $pole[3];
  $x_mno = $pole[4];
  $x_mer = $pole[5];
  $x_jkp = $pole[6];
  $x_ean = $pole[7];
  $x_kon = $pole[8];

//uprava samsport nacitanie zo zostavy
  $x_skl = 1;
  $x_cis = 1*$pole[0];
  $x_nat = trim($pole[1]);
  $x_cen = trim($pole[4]);
  $x_mno = trim($pole[3]);
  $x_mer = trim($pole[2]);
  $x_jkp = "";
  $x_ean = "";
  $x_kon = "";

  $xc_mno = 1*$x_mno;
  $xc_ean = 1*$x_ean;

$x_nat=strtolower($x_nat);

$x_natBD = StrTr($x_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( cis,nat,natBD,mer,dph,cep,ced )
 VALUES ($x_cis, '$x_nat', '$x_natBD', '$x_mer', '20', 0, 0); "); 

if( $xc_mno != 0 )
  {
$ulozttt = "INSERT INTO F$kli_vxcf"."_sklpoc ( skl,cis,cen,mno ) VALUES ($x_skl, $x_cis, $x_cen, $x_mno ); "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
  }

$sqult = "INSERT INTO F$kli_vxcf"."_sklcisudaje (xcis, xdr2,xtxt,xtxt2,xtxt3,xtxt4,xtxt5,xnat ) VALUES ( '$x_cis', '', '', '', '', '', '', '$x_ean'  );";
$ulozene = mysql_query("$sqult");  
$sqult = "UPDATE F$kli_vxcf"."_sklcisudaje SET xnat='$x_ean' WHERE xcis = $x_cis ";
$ulozene = mysql_query("$sqult");

}

echo "Tabulka F$kli_vxcf"."_sklpoc!"." naimportovan· <br />";

fclose ($subor);


    }

//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r poËiatoËnÈho stavu skladov a ËÌselnÌka materi·lov˝ch poloûiek ?") )
         { window.close()  }
else
         { location.href='cpoc.php?copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklpoc';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_sklpoc!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklcis';
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklcisudaje';
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklzas';
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklzaspriemer';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_sklcis!"." vynulovan· <br />";

    }


if ( $hlad == 'ANO' AND $copern == 15) $copern=5;
//echo "CISh=$hlad_cis hlad=$hlad CISv=$vybr_cis vybr=$vybr";


$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v cpoc.php
// 6=vymazanie polozky potvrdene v cpoc.php
if ( $copern == 15 || $copern == 16 )
     {
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
$cislo_cen = strip_tags($_REQUEST['cislo_cen']);
//ulozenie novej
if ( $copern == 15 )
    {
$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( cis,nat,natBD,mer,dph,cep,ced ) VALUES ($h_cis, '$h_nat', '$h_natBD', '$h_mer', '$fir_dph2', 0, 0); "); 
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklpoc ( skl,cis,cen,mno ) VALUES ($h_skl, $h_cis, $h_cen, $h_mno ); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA CIS:$h_cis SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_sklpoc WHERE skl='$cislo_skl' AND cis='$cislo_cis' AND cen=$cislo_cen"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA CIS:$cislo_cis BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
$cislo_cen = strip_tags($_REQUEST['cislo_cen']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklpoc SET skl='$h_skl', cis='$h_cis', cen='$h_cen', mno='$h_mno' WHERE skl='$cislo_skl' AND cis='$cislo_cis' AND cen=$cislo_cen");  
$copern=1;
$cislo_skl = $h_skl;
$cislo_cis = $h_cis;
$cislo_cen = $h_cen;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA CIS:$cislo_cis UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$cislo_skl = strip_tags($_REQUEST['h_skl']);
$cislo_cis = strip_tags($_REQUEST['h_cis']);
$cislo_cen = strip_tags($_REQUEST['h_cen']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
$cislo_cen = strip_tags($_REQUEST['cislo_cen']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sklad-PoËiatoËn˝ stav</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//posuny Enter[[[[[[[[[[[


function SklEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_cis.focus();
              }
                }

function CisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nat.focus();
              }
                }

function NatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_cen.focus();
              }
                }

function CenEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_mno.focus();
              }
                }

function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_mer.focus();
              }
                }


function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_skl.value == '' ) okvstup=0;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( document.formv1.h_cen.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_skl.value == '' ) { document.formv1.h_skl.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_cis.value == '' ) { document.formv1.h_cis.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nat.value == '' ) { document.formv1.h_nat.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_cen.value == '' ) { document.formv1.h_cen.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//koniec posunov Enter

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
    document.formhl1.hladaj_nat.focus();
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
    document.formv1.h_skl.value = <?php echo "$h_skl";?>;
    document.formv1.h_cis.value = <?php echo "$h_cis";?>;
    document.formv1.h_nat.value = '<?php echo "$h_nat";?>';
    document.formv1.h_cen.value = <?php echo "$h_cen";?>;
    document.formv1.h_mno.value = <?php echo "$h_mno";?>;
    document.formv1.h_mer.value = '<?php echo "$h_mer";?>';
    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 )
  {
?>

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    New.style.display="none";
    }

    function Hlad()
    {
    document.formv1.hlad.value = 'ANO';
    }

    function NeHlad()
    {
    document.formv1.hlad.value = 'NIE';
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
//   Vstup.value = Vstup.value.replace ( ',','.' );
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

    function Zapis_COOK()
    {
//    WriteCookie ( 'pskl_skl', document.formv1.h_skl.value , 240);
//    WriteCookie ( 'pskl_cis', document.formv1.h_cis.value , 240);
//    WriteCookie ( 'pskl_nat', document.formv1.h_nat.value , 240);
//    WriteCookie ( 'pskl_mer', document.formv1.h_mer.value , 240);
//    WriteCookie ( 'pskl_cen', document.formv1.h_cen.value , 240);
//    WriteCookie ( 'pskl_mno', document.formv1.h_mno.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_skl.value = (ReadCookie ( 'pskl_skl', '1' ));
//    document.formv1.h_cis.value = (ReadCookie ( 'pskl_cis', '11' ));
//    document.formv1.h_nat.value = (ReadCookie ( 'pskl_nat', 'Nazov' ));
//    document.formv1.h_mer.value = (ReadCookie ( 'pskl_mer', 'm3' ));
//    document.formv1.h_cen.value = (ReadCookie ( 'pskl_cen', '1' ));
//    document.formv1.h_mno.value = (ReadCookie ( 'pskl_mno', '1' ));
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
<?php if( $hlad != 'ANO' )
{
?>
    document.formv1.h_cis.focus();
    document.formv1.h_cis.select();
<?php
}
?>
<?php if( $vybr == 'ANO' )
{
 echo "document.formv1.h_cen.focus();";
 echo "document.formv1.h_cen.select();";
 echo "document.formv1.h_nat.disabled = true;";
}
?>
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( document.formv1.h_cen.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
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
<?php if( $vybr == 'ANO' )
{
 echo "document.formv1.h_skl.value = '$vybr_skl';";
 echo "document.formv1.h_cis.value = '$vybr_cis';";
 echo "document.formv1.h_nat.value = '$vybr_nat';";
 echo "document.formv1.h_mer.value = '$vybr_mer';";
}
?>
<?php if( $hlad == 'ANO' )
{
 echo "document.formv1.h_skl.value = '$hlad_skl';";
}
?>
    }

<?php
//koniec nova
  }
?>

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
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  PoËiatoËn˝ stav skladov
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
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
$sql = mysql_query("SELECT skl, F$kli_vxcf"."_sklpoc.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer".
" FROM F$kli_vxcf"."_sklpoc".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklpoc.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE skl > 0 ".
"");

  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nat = strip_tags($_REQUEST['hladaj_nat']);
$hladaj_cis = strip_tags($_REQUEST['hladaj_cis']);
$hladaj_skl = strip_tags($_REQUEST['hladaj_skl']);

if ( $hladaj_nat != "" ) 
{
$sql = mysql_query("SELECT skl, F$kli_vxcf"."_sklpoc.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer".
" FROM F$kli_vxcf"."_sklpoc".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklpoc.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE F$kli_vxcf"."_sklcis.nat LIKE '%$hladaj_nat%' ".
"");
}

if ( $hladaj_skl != "" ) 
{ 
$sql = mysql_query("SELECT skl, F$kli_vxcf"."_sklpoc.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer".
" FROM F$kli_vxcf"."_sklpoc".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklpoc.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE skl = '$hladaj_skl' ".
"");
}

if ( $hladaj_cis != "" ) 
{
$sql = mysql_query("SELECT skl, F$kli_vxcf"."_sklpoc.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer".
" FROM F$kli_vxcf"."_sklpoc".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklpoc.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE F$kli_vxcf"."_sklcis.cis = '$hladaj_cis' ".
"");
}


}
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklpoc WHERE NOT ( skl='$cislo_skl' AND cis='$cislo_cis' AND cen=$cislo_cen ) ORDER BY cis");
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
<FORM name="formhl1" class="hmenu" method="post" action="cpoc.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=15 border=0 title="Vyhæad·vanie">
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ><a href='cpoc.php?copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='cpoc.php?copern=55&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_skl" id="hladaj_skl" size="15" value="<?php echo $hladaj_skl;?>" />
<td class="hmenu"><input type="text" name="hladaj_cis" id="hladaj_cis" size="15" value="<?php echo $hladaj_cis;?>" />
<td class="hmenu"><input type="text" name="hladaj_nat" id="hladaj_nat" size="50" value="<?php echo $hladaj_nat;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cpoc.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">Sklad<th class="hmenu">».materi·lu<th class="hmenu">N·zov materi·lu<th class="hmenu">Cena<th class="hmenu">Mnoûstvo<th class="hmenu">MJ<th class="hmenu">Uprav<th class="hmenu">Zmaû
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
  if ($riadok->cis != 0 )
       {
?>
<tr>
<td class="fmenu" width="10%" ><?php echo $riadok->skl;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cis;?></td>
<td class="fmenu" width="40%" ><?php echo $riadok->nat;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cen;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->mno;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->mer;?></td>
<td class="fmenu" width="5%" ><a href='cpoc.php?copern=8&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>
&cislo_cis=<?php echo $riadok->cis;?>&cislo_cen=<?php echo $riadok->cen;?>&h_cis=<?php echo $riadok->cis;?>
&h_skl=<?php echo $riadok->skl;?>&h_cen=<?php echo $riadok->cen;?>&h_nat=<?php echo $riadok->nat;?>
&h_mno=<?php echo $riadok->mno;?>&h_mer=<?php echo $riadok->mer;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0 title="⁄prava vybranej poloûky" ></a></td>
<td class="fmenu" width="5%" ><a href='cpoc.php?copern=6&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>
&cislo_cis=<?php echo $riadok->cis;?>&cislo_cen=<?php echo $riadok->cen;?>'>Zmaû</a></td>
</tr>
<?php
       }
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
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
$cislo_cen = strip_tags($_REQUEST['cislo_cen']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_sklpoc WHERE skl='$cislo_skl' AND cis='$cislo_cis' AND cen=$cislo_cen";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["skl"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cis"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nat"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cen"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["mno"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["mer"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cpoc.php?page=<?php echo $page;?>&copern=16>&vybr=NIE&cislo_skl=<?php echo $cislo_skl;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cpoc.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo skladu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo materi·lu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 N·kupn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Mnoûstvo materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0.001 aû 999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> SKL=<?php echo $h_skl;?> CEN=<?php echo $h_cen;?> spr·vne uloûen·</span>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nov· poloûka CIS=<?php echo $hlad_cis;?> , zadajte n·zov aj MJ</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="cpoc.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_skl=$cislo_skl&cislo_cis=$cislo_cis&cislo_cen=$cislo_cen&"; } ?>
" >

<?php
$sql = mysql_query("SELECT skl,nas FROM F$kli_vxcf"."_skl ORDER BY skl");
?>

<td class="fmenu">
<select size="1" name="h_skl" id="h_skl" onmouseover="Fx.style.display='none';" onKeyDown="return SklEnter(event.which)">
<?php while($zaznam=mysql_fetch_array($sql)):?>

<option value="<?php echo $zaznam["skl"];?>" >
<?php 
$polmen = $zaznam["nas"];
$poltxt = SubStr($polmen,0,15);
?>

<?php echo $zaznam["skl"];?> - <?php echo $poltxt;?></option>

<?php endwhile;?>
</td>


<td class="fmenu"><input type="text" name="h_cis" id="h_cis" size="15" 
onchange="return intg(this,1,9999999999999,Cx)" onclick="ZhasniSP()" onkeyup="KontrolaCisla(this, Cx)" onKeyDown="return CisEnter(event.which)" />

<td class="fmenu">

<input type="hidden" name="hlad" id="hlad" value="NIE" />
<input type="text" name="h_nat" id="h_nat" size="40" onclick="ZhasniSP()" onKeyDown="return NatEnter(event.which)" />
</td>

<td class="fmenu"><input type="text" name="h_cen" id="h_cen" size="15" onKeyDown="return CenEnter(event.which)"
onchange="return cele(this,0.0001,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="CiarkaNaBodku(this);KontrolaDcisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_mno" id="h_mno" size="15" onKeyDown="return MnoEnter(event.which)"
onchange="return cele(this,-999999,999999,Ex)" onclick="Fx.style.display='none';" onkeyup="CiarkaNaBodku(this);KontrolaDcisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="5" onClick="return Povol_uloz();" onKeyDown="return MerEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<?php
//[[[[[[ hladanie polozky ponuka
if ( $hlad == 'ANO' AND $copern == 5) 
{
if ( $hlad_nat != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( nat LIKE '%$hlad_nat%' ) ORDER BY cis");
if ( $hlad_cis != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( cis = '$hlad_cis' ) ORDER BY cis");
if ( $hlad_cis == "" AND $hlad_nat == "") $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( cis = 99999999999999 ) ORDER BY cis");
$vpol = mysql_num_rows($sql);

//ak vpol = 1
if ( $vpol == 1 )
 {
  if (@$zaznam=mysql_data_seek($sql,0))
    {
  $riadok=mysql_fetch_object($sql);
    }
?>
<script type="text/javascript">
document.formv1.h_cis.value = "<?php echo $riadok->cis;?>";
document.formv1.h_nat.value = "<?php echo $riadok->nat;?>";
document.formv1.h_mer.value = "<?php echo $riadok->mer;?>";
document.formv1.h_nat.disabled = true;
document.formv1.h_cen.focus();
document.formv1.h_cen.select();
</script>
<?php
 }
//koniec ak vpol = 1

//ak vpol = 0
if ( $vpol == 0 )
 {
  if ( $hlad_cis != "" )
   {
?>
<script type="text/javascript">
document.formv1.h_cis.value = "<?php echo $hlad_cis;?>";
document.formv1.h_nat.disabled = false;
New.style.display="";
document.formv1.h_nat.focus();
document.formv1.h_nat.select();
</script>
<?php
   }
  if ( $hlad_cis == "" )
   {
?>
<script type="text/javascript">
document.formv1.h_nat.value = "<?php echo $hlad_nat;?>";
New.style.display="none";
document.formv1.h_nat.focus();
document.formv1.h_nat.select();
</script>
<?php
   }
 }
//koniec ak vpol = 0


//ak vpol > 1
if ( $vpol > 1 )
 {
?>

<script type="text/javascript">
document.formv1.h_cis.value = '<?php echo $hlad_cis;?>';
document.formv1.h_nat.value = '<?php echo $hlad_nat;?>';
document.formv1.h_mer.value = '<?php echo $hlad_mer;?>';
document.formv1.h_cis.focus();
document.formv1.h_cis.select();
</script>

<?php
$j=0;

while ($j <= $vpol )
  {
  if (@$zaznam=mysql_data_seek($sql,$j))
    {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<tr><td><span></span></td>
<td class="fmenu"><?php echo $riadok->cis;?></td>
<td class="fmenu">

<a href='cpoc.php?copern=5&page=<?php echo $page;?>&vybr=ANO&hlad=NIE&vybr_cis=<?php echo $riadok->cis;?>&vybr_nat=<?php echo $riadok->nat;?>
&vybr_mer=<?php echo $riadok->mer;?>&vybr_skl=<?php echo $hlad_skl;?>'>
 <img src='../obr/vlozit.png' width=20 height=20 border=0 title="Vyber a vloû t˙to poloûku"></a>


<?php echo $riadok->nat;?>
</td>
<td><span></span></td>
<td><span></span></td>
<td class="fmenu"><?php echo $riadok->mer;?></td>

</tr>
<?php
    }
$j = $j + 1;
  }

 }
//koniec ak vpol > 1
}
//koniec hladanie polozky ponuka
?>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td></td>
<td class="obyc" align="right"></td>
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
 Poloûka CIS=<?php echo $cislo_cis;?> SKL=<?php echo $cislo_skl;?> CEN=<?php echo $cislo_cen;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $cislo_cis;?> SKL=<?php echo $cislo_skl;?> CEN=<?php echo $cislo_cen;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="cpoc.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_skl=$hladaj_skl&hladaj_cis=$hladaj_cis&hladaj_nat=$hladaj_nat";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="cpoc.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_skl=$hladaj_skl&hladaj_cis=$hladaj_cis&hladaj_nat=$hladaj_nat";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="cpoc.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cpoc.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="../sklad/sklzas_pdf.php?copern=30" >
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

$cislista = include("skl_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
