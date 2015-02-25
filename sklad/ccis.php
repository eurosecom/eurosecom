<HTML>
<?php

// celkovy zaciatok dokumentu
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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v ccis.php
// 6=vymazanie polozky potvrdene v ccis.php
if ( $copern == 15 || $copern == 16 )
     {
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
//ulozenie novej
if ( $copern == 15 )
    {
$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( dph,cis,nat,natBD,cep,ced,mer,tl1 )
 VALUES ($h_dph, $h_cis, '$h_nat', '$h_natBD', $h_cep, $h_ced, '$h_mer', '$h_tl1'); "); 
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

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_sklcis WHERE cis='$cislo_cis'"); 
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
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);

$cislo_cis = strip_tags($_REQUEST['cislo_cis']);

$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklcis SET dph='$h_dph', cis='$h_cis', nat='$h_nat', natBD='$h_natBD',
 cep='$h_cep', ced='$h_ced', mer='$h_mer', tl1='$h_tl1', tl2='$h_tl2', tl3='$h_tl3' WHERE cis='$cislo_cis'");  
$copern=1;
$cislo_cis = $h_cis;
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
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);
$cislo_cis = strip_tags($_REQUEST['h_cis']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
  }



$povimp1=0;
if( $_SERVER['SERVER_NAME'] == "localhost" ) { $povimp1=1; }
//ploty skala
if( $_SERVER['SERVER_NAME'] == "www.educto.sk" AND $fir_fico == 46614478 ) { $povimp1=1; }

//echo "firfico".$fir_fico;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sklad-»ÌselnÌk materi·lu</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

var vyskawic = screen.height;
var sirkawic = screen.width-10;

//posuny Enter[[[[[[[[[[[


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
        document.forms.formv1.h_dph.focus();
              }
                }


function DphEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_cep.focus();
              }
                }

function CepEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { dann = 0.<?php echo $fir_dph2; ?>*document.forms.formv1.h_cep.value; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { dann = 0.<?php echo $fir_dph1; ?>*document.forms.formv1.h_cep.value; }
        if( document.forms.formv1.h_dph.value == 0 ) { dann = 0; }

        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.formv1.h_ced.value = (1*danz) + (1*document.forms.formv1.h_cep.value);
        sdphpred =  document.forms.formv1.h_ced.value;
        document.forms.formv1.h_ced.focus();
        document.forms.formv1.h_ced.select();
               }

                }

function CedEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        sdphpo =  document.forms.formv1.h_ced.value;
        sdphrz =  sdphpred - sdphpo;

    if( sdphrz <= 0.03 && sdphrz >= -0.03  )
        {
        if( document.forms.formv1.h_mer.value == "" ) document.forms.formv1.h_mer.value = 'ks';
        document.forms.formv1.h_mer.focus();
        document.forms.formv1.h_mer.select();
        }
    if( sdphrz > 0.03 || sdphrz < -0.03 )
        {
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph2; ?> ) { bezd = document.forms.formv1.h_ced.value / 1.<?php echo $fir_dph2; ?>; }
        if( document.forms.formv1.h_dph.value == <?php echo $fir_dph1; ?> ) { bezd = document.forms.formv1.h_ced.value / 1.<?php echo $fir_dph1; ?>; }
        if( document.forms.formv1.h_dph.value == 0 ) { bezd = document.forms.formv1.h_ced.value / 1; }

        bezd = bezd.toFixed(2);
        document.forms.formv1.h_cep.value = bezd;
        document.forms.formv1.h_cep.focus();
        document.forms.formv1.h_cep.select();
        }
               }
                 }


function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_dph.value == '' ) okvstup=0;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( document.formv1.h_cep.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_dph.value == '' ) { document.formv1.h_dph.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_cis.value == '' ) { document.formv1.h_cis.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nat.value == '' ) { document.formv1.h_nat.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_cep.value == '' ) { document.formv1.h_cep.focus(); return (false); }
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

// Kontrola ces.cisla v rozsahu x az y  
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
    document.formv1.h_dph.value = <?php echo "$h_dph";?>;
    document.formv1.h_nat.value = '<?php echo "$h_nat";?>';
    document.formv1.h_cep.value = <?php echo "$h_cep";?>;
    document.formv1.h_ced.value = <?php echo "$h_ced";?>;
    document.formv1.h_mer.value = '<?php echo "$h_mer";?>';
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
//    WriteCookie ( 'pcis_dph', document.formv1.h_dph.value , 240);
//    WriteCookie ( 'pcis_cis', document.formv1.h_cis.value , 240);
//    WriteCookie ( 'pcis_nat', document.formv1.h_nat.value , 240);
//    WriteCookie ( 'pcis_mer', document.formv1.h_mer.value , 240);
//    WriteCookie ( 'pcis_cep', document.formv1.h_cep.value , 240);
//    WriteCookie ( 'pcis_ced', document.formv1.h_ced.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_dph.value = (ReadCookie ( 'pcis_dph', '1' ));
//    document.formv1.h_cis.value = (ReadCookie ( 'pcis_cis', '11' ));
//    document.formv1.h_nat.value = (ReadCookie ( 'pcis_nat', 'Nazov' ));
//    document.formv1.h_mer.value = (ReadCookie ( 'pcis_mer', 'm3' ));
//    document.formv1.h_cep.value = (ReadCookie ( 'pcis_cep', '1' ));
//    document.formv1.h_ced.value = (ReadCookie ( 'pcis_ced', '1' ));
    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

<?php
//nova
  if ( $copern == 5 OR $copern == 15 )
  {
?>
    function VyberVstup()
    {
    document.formv1.h_cis.focus();
    document.formv1.h_cis.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.h_ne3.disabled = true;
    document.formv1.uloz.disabled = true;
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
    }

<?php
  }
?>

<?php
//uprava
  if ( $copern == 8 OR $copern == 18 )
  {
?>
    function VyberVstup()
    {
    document.formv1.h_nat.focus();
    document.formv1.h_nat.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.h_ne3.disabled = true;
    document.formv1.h_cisx.disabled = true;
    document.formv1.uloz.disabled = true;
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
    }

<?php
  }
//koniec uprava
?>


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

    function TlacCis()
    {

window.open('ccis_pdf.php?copern=20&drupoh=1&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }

    function TlacKat()
    {

window.open('ccis_katalog.php?copern=10&drupoh=1&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }

    function WebEshop()
    {

window.open('../faktury/cslu_web.php?copern=1&page=1', '_blank', 'width=950, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }

    function WebCis( cis )
    {

window.open('../faktury/cslu_web.php?copern=11&page=<?php echo $page;?>&cislo_slu=' + cis + '&ponuka=3', '_blank', 'width=950, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }

    function ExportXML()
    {

window.open('ccis_xml.php?copern=10&drupoh=1&page=1', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
    }


function importCeny()
                {
<?php  if( $povimp1 == 1 ) { ?>
window.open('nacitajcenycsv.php?copern=10&drupoh=1&page=1&zmtz=1', '_self' );
<?php                      } ?>
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
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Materi·lovÈ a tovarovÈ poloûky
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis ORDER BY cis");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nat = strip_tags($_REQUEST['hladaj_nat']);
$hladaj_cis = strip_tags($_REQUEST['hladaj_cis']);


if ( $hladaj_nat != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( nat LIKE '%$hladaj_nat%' ) ORDER BY cis");
if ( $hladaj_cis != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( cis = '$hladaj_cis' ) ORDER BY cis");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE NOT ( cis='$cislo_cis' ) ORDER BY cis");
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
<td class="hmenu" >
<img src='../obr/hladaj.png' width=20 height=12 border=0>
<a href='freecis.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1' target="_blank">
<img src='../obr/ziarovka.png' width=20 height=12 border=0 title="VoænÈ ËÌsla materi·lu"></a>
<td class="hmenu" >
<img src='../obr/tlac.png' onClick='TlacCis();' width=20 height=12 border=0 title="TlaË ËÌselnÌka " >

<img src='../obr/tlac.png' onClick='TlacKat();' width=20 height=12 border=0 title="TlaË katalÛgu tovaru podæa kategÛrie " >
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ><img src="../obr/import.png" onClick="importCeny();" width=20 height=12 border=0 title="Import predajn˝ch cien a minim·lnych poûadovan˝ch z·sob z CSV s˙boru" ></td>
<td class="hmenu" >
<img src='../obr/export.png' onClick='ExportXML();' width=20 height=12 border=0 title="Export katalÛgu tovaru, kategÛriÌ, ËÌselnÌka I»O, ODBM a reötauraËn˝ch stolov do XML" >
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ><a href='#' onclick='WebEshop();' >
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title="Vzhæad e-shopu"></a></td>
</tr>
<FORM name="formhl1" class="hmenu" method="post" action="ccis.php?page=1&copern=9" >
<tr>
<td class="hmenu"><input type="text" name="hladaj_cis" id="hladaj_cis" size="15" value="<?php echo $hladaj_cis;?>" />
<td class="hmenu"><input type="text" name="hladaj_nat" id="hladaj_nat" size="50" value="<?php echo $hladaj_nat;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="ccis.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">».materi·lu<th class="hmenu">N·zov materi·lu
<th class="hmenu">Sadzba DPH<th class="hmenu">PCena bez DPH<th class="hmenu">PCena s DPH<th class="hmenu">MJ
<th class="hmenu"><img src='../obr/info.png' width=12 height=12 border=0 title="T1 => zaökrtnutÈ bud˙ vo WEB ponuke">
<th class="hmenu">T2<th class="hmenu">T3<th class="hmenu">Obr·zky<th class="hmenu">Uprav<th class="hmenu">Zmaû
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
<td class="fmenu" width="10%" >
<a href="#" onClick="window.open('cis_udaje.php?copern=20&cislo_cis=<?php echo $riadok->cis;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="DoplÚuj˙ce ˙daje o materi·lovej, tovarovej poloûke" ></a>
<?php echo $riadok->cis;?>
</td>
<td class="fmenu" width="30%" >
<a href='#' onclick='WebCis(<?php echo $riadok->cis;?>);' >
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="DoplÚuj˙ce inform·cie o poloûke tovaru na WEB e-shop"></a>
<?php echo $riadok->nat;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->dph;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->cep;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ced;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->mer;?></td>
<td class="fmenu" width="2%" ><?php echo $riadok->tl1;?></td>
<td class="fmenu" width="2%" ><?php echo $riadok->tl2;?></td>
<td class="fmenu" width="2%" ><?php echo $riadok->tl3;?></td>
<td class="fmenu" width="10%" >
<?php
if( $copern != 6 AND $copern != 5 AND $copern != 8 )
{
?>
<a href='../faktury/vstf_s.php?copern=131&drupoh=1&page=1&cislo_dok=<?php echo $riadok->cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku A do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=132&drupoh=1&page=1&cislo_dok=<?php echo $riadok->cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku B do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=133&drupoh=1&page=1&cislo_dok=<?php echo $riadok->cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku C do datab·zy" ></a>
<a href='../faktury/vstf_s.php?copern=134&drupoh=1&page=1&cislo_dok=<?php echo $riadok->cis;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku D do datab·zy" ></a>
<?php
}
?>
</td>
<td class="fmenu" width="5%" ><a href='ccis.php?copern=8&page=<?php echo $page;?>&cislo_cis=<?php echo $riadok->cis;?>
&h_cis=<?php echo $riadok->cis;?>&h_dph=<?php echo $riadok->dph;?>&h_cep=<?php echo $riadok->cep;?>
&h_nat=<?php echo $riadok->nat;?>&h_ced=<?php echo $riadok->ced;?>&h_mer=<?php echo $riadok->mer;?>
&h_tl1=<?php echo $riadok->tl1;?>&h_tl2=<?php echo $riadok->tl2;?>&h_tl3=<?php echo $riadok->tl3;?>
'> <img src='../obr/uprav.png' width=20 height=20 border=0 title="Upraviù tovarov˙ poloûku" ></a></td>
<td class="fmenu" width="5%" ><a href='ccis.php?copern=1&page=<?php echo $page;?>&cislo_cis=<?php echo $riadok->cis;?>' disabled="disabled">Zmaû</a></td>
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
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);
$cislo_cis = strip_tags($_REQUEST['cislo_cis']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE cis='$cislo_cis'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["cis"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["nat"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["dph"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["cep"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ced"];?></td>
<td class="fmenu" width="4%" ><?php echo $zaznam["mer"];?></td>
<td class="fmenu" width="2%" ><?php echo $zaznam["tl1"];?></td>
<td class="fmenu" width="2%" ><?php echo $zaznam["tl2"];?></td>
<td class="fmenu" width="2%" ><?php echo $zaznam["tl3"];?></td>
<td class="fmenu" width="10%" ></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="ccis.php?page=<?php echo $page;?>&copern=16>&cislo_cis=<?php echo $cislo_cis;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="ccis.php?page=<?php echo $page;?>&copern=1" >
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
 Sadzba DPH musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 4</span>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo materi·lu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Predajn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0 aû 99999999</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Predajn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0 aû 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="ccis.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cis=$cislo_cis&"; } ?>
" >
<?php
if ( $copern == 5 )
     {
?>
<td class="fmenu"><input type="text" name="h_cis" id="h_cis" size="15" onKeyDown="return CisEnter(event.which)"
onchange="return intg(this,1,9999999999999,Cx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cx)" />
<?php
     }
?>

<?php
if ( $copern == 8 )
     {
?>
<td class="fmenu"><input type="text" name="h_cisx" id="h_cisx" size="15" value="<?php echo $cislo_cis;?>" 
onchange="return intg(this,1,9999999999999,Cx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cx)" />
<input type="hidden" name="h_cis" id="h_cis" value="<?php echo $cislo_cis;?>" />
<?php
     }
?>

<td class="fmenu"><input type="text" name="h_nat" id="h_nat" size="40" maxlength="40" onKeyDown="return NatEnter(event.which)"
onclick="Fx.style.display='none';" /></td>

<td class="fmenu">
<select size="1" name="h_dph" id="h_dph" onmouseover="Fx.style.display='none';" onKeyDown="return DphEnter(event.which)" >
<option value="<?php echo $fir_dph2;?>" >DPH Ë.2=<?php echo $fir_dph2;?>%</option>
<option value="<?php echo $fir_dph1;?>" >DPH Ë.1=<?php echo $fir_dph1;?>%</option>
<option value="00" >DPH     00%</option>
<option value="<?php echo $fir_dph3;?>" >DPH Ë.3=<?php echo $fir_dph3;?>%</option>
<option value="<?php echo $fir_dph4;?>" >DPH Ë.4=<?php echo $fir_dph4;?>%</option>
</td>

<td class="fmenu"><input type="text" name="h_cep" id="h_cep" size="12" onKeyDown="return CepEnter(event.which)"
onchange="return cele(this,0,99999999,Dx)" onclick="Fx.style.display='none';" onkeyup="CiarkaNaBodku(this);KontrolaDcisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ced" id="h_ced" size="12" onKeyDown="return CedEnter(event.which)"
onchange="return cele(this,0,99999999,Ex)" onclick="Fx.style.display='none';" onkeyup="CiarkaNaBodku(this);KontrolaDcisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="3" onClick="return Povol_uloz();" onKeyDown="return MerEnter(event.which)" />

<td class="fmenu"><input type="checkbox" name="h_tl1" value="1"/></td>
<td class="fmenu"><input type="checkbox" name="h_tl2" value="1"/></td>
<td class="fmenu"><input type="checkbox" name="h_tl3" value="1"/></td>

<?php
if ( $copern == 8 )
     {
?>
<?php
if ( $h_tl1 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl1.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $h_tl2 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl2.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $h_tl3 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_tl3.checked = "checked";
</script>
<?php
   }
?>
<?php
     }
?>
<td class="fmenu"><input type="text" name="h_ne3" id="h_ne3" size="3" /></td>
<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="3" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="ccis.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka CIS=<?php echo $cislo_cis;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $cislo_cis;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="ccis.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cis=$hladaj_cis&hladaj_nat=$hladaj_nat";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="ccis.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cis=$hladaj_cis&hladaj_nat=$hladaj_nat";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="ccis.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="ccis.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
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
