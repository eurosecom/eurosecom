<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
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

$tlacitkoenter=0;
if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 ) { $tlacitkoenter=1; }

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

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

if( $sekov == 1 AND $copern == 1 AND $kli_vxcf == 520 )
     {
$databaza="";

$sqlt = "DROP TABLE F".$kli_vxcf."_zakprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakpovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_zakpovodne SELECT * FROM F".$kli_vxcf."_zak WHERE zak >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_zakpovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_zakprenos SELECT * FROM ".$databaza."F235_zak WHERE zak >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_zakprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_zakprenos,F$kli_vxcf"."_zak SET plati=9".
" WHERE F$kli_vxcf"."_zakprenos.zak = F$kli_vxcf"."_zak.zak AND F$kli_vxcf"."_zakprenos.str = F$kli_vxcf"."_zak.str ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_zak WHERE zak >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zak SELECT ".
"str,zak,nza,sku,stv,dzk,uzk,datm FROM F$kli_vxcf"."_zakprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zak SELECT ".
"str,zak,nza,sku,stv,dzk,uzk,datm FROM F$kli_vxcf"."_zakpovodne ".
" WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakpovodne";
$vysledok = mysql_query("$sqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_zak WHERE str = 10 AND zak < 140000";
$dsql = mysql_query("$dsqlt");
     }

//import z ../import/FIR$kli_vxcf/CIS_ZAK.CSV
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/CIS_ZAK.CSV ?") )
         { window.close()  }
else
         { location.href='czak.php?copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/CIS_ZAK.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/CIS_ZAK.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/CIS_ZAK.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_str = $pole[0];
  $x_zak= $pole[1];
  $x_nza = $pole[2];
  $x_sku = $pole[3];
  $x_stv = $pole[4];
  $x_rez = $pole[5];
  $x_ned = 1*$pole[6];
  $x_kon = 1*$pole[7];
 
$c_str=1*$x_str;
$c_zak=1*$x_zak;

//if( $c_zak == 0 ) $x_zak=1;
if( $x_nza == '' ) $x_nza="Z·kazka ".$x_zak;
if( $polno == 0 ) { $x_rez=1; $x_ned=1; }

if( $c_str >= 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_zak ( str,zak,nza,sku,stv,dzk,uzk )".
" VALUES ( '$x_str', '$x_zak', '$x_nza', '$x_sku', '$x_stv', '$x_rez', '$x_ned' ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_zak!"." naimportovan· <br />";

fclose ($subor);

    }
//koniec nacitania stredisk



//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r z·kaziek ?") )
         { window.close()  }
else
         { location.href='czak.php?copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_zak';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_zak!"." vynulovan· <br />";
    }


// 5=ulozenie polozky do databazy nahratej v czak.php
// 6=vymazanie polozky potvrdene v czak.php
if ( $copern == 15 || $copern == 16 )
     {
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_nza = strip_tags($_REQUEST['h_nza']);
$h_sku = strip_tags($_REQUEST['h_sku']);
$h_stv = strip_tags($_REQUEST['h_stv']);
$h_dzk = strip_tags($_REQUEST['h_dzk']);
$h_uzk = strip_tags($_REQUEST['h_uzk']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
//ulozenie novej
if ( $copern == 15 )
    {
$sql = "ALTER TABLE F$kli_vxcf"."_zak  ADD PRIMARY KEY ( str, zak )";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zak  ADD UNIQUE ( str, zak )";
$vysledek = mysql_query("$sql");

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_zak ( str,zak,nza,sku,stv,dzk,uzk ) VALUES ($h_str, $h_zak, '$h_nza', $h_sku, $h_stv, $h_dzk, $h_uzk); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA  STR,ZAK = <?php echo $h_str; ?>,<?php echo $h_zak; ?> NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
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

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_zak WHERE str='$cislo_str' AND zak='$cislo_zak'"); 
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
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_nza = strip_tags($_REQUEST['h_nza']);
$h_sku = strip_tags($_REQUEST['h_sku']);
$h_stv = strip_tags($_REQUEST['h_stv']);
$h_dzk = strip_tags($_REQUEST['h_dzk']);
$h_uzk = strip_tags($_REQUEST['h_uzk']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_zak SET str='$h_str', zak='$h_zak', nza='$h_nza', sku='$h_sku', stv='$h_stv', dzk='$h_dzk', uzk='$h_uzk' WHERE str='$cislo_str' AND zak='$cislo_zak'");  
$copern=1;
$cislo_str = $h_str;
$cislo_zak = $h_zak;
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
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_nza = strip_tags($_REQUEST['h_nza']);
$h_sku = strip_tags($_REQUEST['h_sku']);
$h_stv = strip_tags($_REQUEST['h_stv']);
$h_dzk = strip_tags($_REQUEST['h_dzk']);
$h_uzk = strip_tags($_REQUEST['h_uzk']);
$cislo_str = strip_tags($_REQUEST['h_str']);
$cislo_zak = strip_tags($_REQUEST['h_zak']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>»ÌselnÌk z·kaziek</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">

//posuny Enter[[[[[[[[[[[


function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_zak.focus();
              }
                }

function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nza.focus();
              }
                }

function NzaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_sku.focus();
              }
                }

function SkuEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_stv.focus();
              }
                }

function StvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_dzk.focus();
              }
                }

function DzkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_uzk.focus();
              }
                }

function UzkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_zak.value == '' ) okvstup=0;
    if ( document.formv1.h_nza.value == '' ) okvstup=0;
    if ( document.formv1.h_dzk.value == '' ) okvstup=0;
    if ( document.formv1.h_uzk.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_zak.value == '' ) { document.formv1.h_zak.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nza.value == '' ) { document.formv1.h_nza.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_dzk.value == '' ) { document.formv1.h_dzk.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_uzk.value == '' ) { document.formv1.h_uzk.focus(); return (false); }
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

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nza.focus();
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
    document.formv1.h_str.value = <?php echo "$h_str";?>;
    document.formv1.h_zak.value = <?php echo "$h_zak";?>;
    document.formv1.h_nza.value = '<?php echo "$h_nza";?>';
    document.formv1.h_sku.value = <?php echo "$h_sku";?>;
    document.formv1.h_stv.value = <?php echo "$h_stv";?>;
    document.formv1.h_dzk.value = '<?php echo "$h_dzk";?>';
    document.formv1.h_uzk.value = '<?php echo "$h_uzk";?>';
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
//    WriteCookie ( 'pzak_str', document.formv1.h_str.value , 240);
//    WriteCookie ( 'pzak_zak', document.formv1.h_zak.value , 240);
//    WriteCookie ( 'pzak_nza', document.formv1.h_nza.value , 240);
//    WriteCookie ( 'pzak_sku', document.formv1.h_sku.value , 240);
//    WriteCookie ( 'pzak_stv', document.formv1.h_stv.value , 240);
//    WriteCookie ( 'pzak_dzk', document.formv1.h_dzk.value , 240);
//    WriteCookie ( 'pzak_uzk', document.formv1.h_uzk.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_str.value = (ReadCookie ( 'pzak_str', '1' ));
//    document.formv1.h_zak.value = (ReadCookie ( 'pzak_zak', '1' ));
//    document.formv1.h_nza.value = (ReadCookie ( 'pzak_nza', 'Nazov' ));
//    document.formv1.h_sku.value = (ReadCookie ( 'pzak_sku', '1' ));
//    document.formv1.h_stv.value = (ReadCookie ( 'pzak_stv', '1' ));
//    document.formv1.h_dzk.value = (ReadCookie ( 'pzak_dzk', '1' ));
//    document.formv1.h_uzk.value = (ReadCookie ( 'pzak_uzk', '1' ));

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
    document.formv1.h_str.focus();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_zak.value == '' ) okvstup=0;
    if ( document.formv1.h_nza.value == '' ) okvstup=0;
    if ( document.formv1.h_dzk.value == '' ) okvstup=0;
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
<td>EuroSecom  -  »ÌselnÌk z·kaziek
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak ORDER BY str,zak");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nza = strip_tags($_REQUEST['hladaj_nza']);
$hladaj_zak = strip_tags($_REQUEST['hladaj_zak']);
$hladaj_str = strip_tags($_REQUEST['hladaj_str']);

if ( $hladaj_nza != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE ( nza LIKE '%$hladaj_nza%' ) ORDER BY str,zak");
if ( $hladaj_str != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE ( str = '$hladaj_str' ) ORDER BY str,zak");
if ( $hladaj_zak != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE ( zak = '$hladaj_zak' ) ORDER BY str,zak");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE NOT ( str='$cislo_str' AND zak='$cislo_zak' ) ORDER BY str,zak");
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
<FORM name="formhl1" class="hmenu" method="post" action="czak.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_str" id="hladaj_str" size="15" value="<?php echo $hladaj_str;?>" />
<td class="hmenu"><input type="text" name="hladaj_zak" id="hladaj_zak" size="15" value="<?php echo $hladaj_zak;?>" />
<td class="hmenu"><input type="text" name="hladaj_nza" id="hladaj_nza" size="50" value="<?php echo $hladaj_nza;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="czak.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
<?php
if ( $kli_uzall > 3000 )
  {
?>
<td class="hmenu" >
<td class="hmenu" >
<td class="hmenu" ><a href='czak.php?copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='czak.php?copern=55&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
  }
?>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">Stredisko<th class="hmenu">Z·kazka<th class="hmenu">N·zov z·kazky<th class="hmenu">SKU
<?php
if ( $polno == 0 AND $vyb_duj != 1 )
  {
?>
<th class="hmenu">STA<th class="hmenu">Druh<th class="hmenu">Param
<?php
  }
?>
<?php
if ( $polno == 1 AND $vyb_duj != 1 )
  {
//ur1=(sr*10)+cr
?>

<th class="hmenu">STA
<th class="hmenu">RÈûia
 <img src='../obr/info.png' width=12 height=12 border=0 title="Nastavenie rÈûie 0=nepoËÌtaj CR rÈûiu, 1=poËÌtaj rÈûiu CR, 2=rÈûijn· CR ZAK, 0x=nepoËÌtaj SR rÈûiu, 1x=poËÌtaj rÈûiu SR, 2x=rÈûijn· SR ZAK">

<th class="hmenu">Nedok
 <img src='../obr/info.png' width=12 height=12 border=0 title="Nastavenie nedokonËenej v˝roby 0=nepoËÌtaj NV, 1=poËÌtaj NV, 2=rozpusti NV">
<?php
  }
?>
<?php
if ( $vyb_duj == 1 )
  {
?>

<th class="hmenu">STA
<th class="hmenu">Druh
<th class="hmenu">»inn
 <img src='../obr/info.png' width=12 height=12 border=0 title="Nastavenie druhu Ëinnosti 0,1=hlavn· nezdaÚovan·, 2=podnikateæsk· zdaÚovan·">
<?php
  }
?>
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
<td class="fmenu" width="10%" ><?php echo $riadok->str;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->zak;?></td>
<td class="fmenu" width="40%" ><?php echo $riadok->nza;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->sku;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->stv;?></td>
<td class="fmenu" width="5%" ><?php echo $riadok->dzk;?></td>
<td class="fmenu" width="5%" ><?php echo $riadok->uzk;?></td>
<td class="fmenu" width="5%" ><a href='czak.php?copern=8&page=<?php echo $page;?>&cislo_str=<?php echo $riadok->str;?>&cislo_zak=<?php echo $riadok->zak;?>&h_zak=<?php echo $riadok->zak;?>&h_str=<?php echo $riadok->str;?>&h_nza=<?php echo $riadok->nza;?>&h_sku=<?php echo $riadok->sku;?>&h_stv=<?php echo $riadok->stv;?>&h_dzk=<?php echo $riadok->dzk;?>&h_uzk=<?php echo $riadok->uzk;?>'> <img src='../obr/uprav.png' title="Upraviù poloûku" width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='czak.php?copern=6&page=<?php echo $page;?>&cislo_str=<?php echo $riadok->str;?>&cislo_zak=<?php echo $riadok->zak;?>'>Zmaû</a></td>
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
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_nza = strip_tags($_REQUEST['h_nza']);
$h_sku = strip_tags($_REQUEST['h_sku']);
$h_stv = strip_tags($_REQUEST['h_stv']);
$h_dzk = strip_tags($_REQUEST['h_dzk']);
$h_uzk = strip_tags($_REQUEST['h_uzk']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_zak WHERE str='$cislo_str' AND zak='$cislo_zak'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["str"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["zak"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nza"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["sku"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["stv"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["dzk"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["uzk"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="czak.php?page=<?php echo $page;?>&copern=16>&cislo_str=<?php echo $cislo_str;?>&cislo_zak=<?php echo $cislo_zak;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="czak.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka STR=<?php echo $h_str;?> ZAK=<?php echo $h_zak;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="czak.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_str=$cislo_str&cislo_zak=$cislo_zak&"; } ?>
" >

<?php
$sql = mysql_query("SELECT str,nst FROM F$kli_vxcf"."_str ORDER BY str");
?>
<td class="fmenu">
<select size="1" name="h_str" id="h_str" onmouseover="Fx.style.display='none';" onKeyDown="return StrEnter(event.which)"  >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["str"];?>" >
<?php 
$polmen = $zaznam["nst"];
$poltxt = SubStr($polmen,0,15);
?>
<?php echo $zaznam["str"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
<?php  mysql_free_result($sql);?>
</td>


<td class="fmenu"><input type="text" name="h_zak" id="h_zak" size="8" 
onchange="return intg(this,0,99999999,Cx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cx)" 
 onKeyDown="return ZakEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_nza" id="h_nza" size="30" maxlength="30"
 onKeyDown="return NzaEnter(event.which)" onclick="Fx.style.display='none';" /></td>

<?php
$sql = mysql_query("SELECT sku,nsu FROM F$kli_vxcf"."_sku ORDER BY sku");
?>
<td class="fmenu">
<select size="1" name="h_sku" id="h_sku" onmouseover="Fx.style.display='none';" onKeyDown="return SkuEnter(event.which)"  >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["sku"];?>" >
<?php 
$polmen = $zaznam["nsu"];
$poltxt = SubStr($polmen,0,15);
?>
<?php echo $zaznam["sku"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
<?php  mysql_free_result($sql);?>
</td>

<?php
$sql = mysql_query("SELECT stv,nsv FROM F$kli_vxcf"."_stv ORDER BY stv");
?>
<td class="fmenu">
<select size="1" name="h_stv" id="h_stv" onmouseover="Fx.style.display='none';" onKeyDown="return StvEnter(event.which)"  >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["stv"];?>" >
<?php 
$polmen = $zaznam["nsv"];
$poltxt = SubStr($polmen,0,15);
?>
<?php echo $zaznam["stv"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
<?php  mysql_free_result($sql);?>
</td>

<td class="fmenu"><input type="text" name="h_dzk" id="h_dzk" size="5" 
 onKeyDown="return DzkEnter(event.which)" onchange="return intg(this,0,29,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_uzk" id="h_uzk" size="5" 
 onKeyDown="return UzkEnter(event.which)" onchange="return intg(this,0,9999999,Ex)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
<?php                           }  ?>
</td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="czak.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
<td class="obyc"><SPAN id="vypis">&nbsp;</SPAN></td>
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
 Poloûka STR=<?php echo $cislo_str;?> ZAK=<?php echo $cislo_zak;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka STR=<?php echo $cislo_str;?> zak=<?php echo $cislo_zak;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="czak.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_zak=$hladaj_zak&hladaj_nza=$hladaj_nza";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="czak.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_zak=$hladaj_zak&hladaj_nza=$hladaj_nza";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="czak.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="czak.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="czak_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_nza=$hladaj_nza&hladaj_str=$hladaj_str&hladaj_zak=$hladaj_zak";
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
