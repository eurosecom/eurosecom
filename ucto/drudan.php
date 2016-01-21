<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$cslm=101805;
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//nacitanie z minuleho roka 
    if ( $copern == 4055 )
    {
?>
<script type="text/javascript">
if ( !confirm ("Chcete naËÌtaù ËÌselnÌk z firmy Ë.<?php echo $fir_allx11; ?> minulÈho roka ?") )
         { window.close()  }
else
         { location.href='drudan.php?copern=4056&page=1&drupoh=<?php echo $drupoh; ?>' }
</script>
<?php
    }

    if ( $copern == 4056 )
    {

$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtbzx = include("../cis/oddel_dtbz1.php");


$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_uctdrdp ";
$dsql = mysql_query("$dsqlt");



$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdrdp SELECT * FROM ".$databaza."F$h_ycf"."_uctdrdp ";
$dsql = mysql_query("$dsqlt");


$copern=1;
    }
//koniec nacitanie z minuleho roka

if ( $copern == 1001 )
     {
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_e";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_e";
$vysledek = mysql_query("$sql");



$copern=1;
     }


// 5=ulozenie polozky do databazy nahratej v drudan.php
// 6=vymazanie polozky potvrdene v drudan.php
if ( $copern == 15 || $copern == 16 )
     {
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_nrd = strip_tags($_REQUEST['h_nrd']);
$h_szd = strip_tags($_REQUEST['h_szd']);
$h_crz = strip_tags($_REQUEST['h_crz']);
$h_crd = strip_tags($_REQUEST['h_crd']);
$h_crz1 = strip_tags($_REQUEST['h_crz1']);
$h_crd3 = strip_tags($_REQUEST['h_crd3']);
$h_crz3 = strip_tags($_REQUEST['h_crz3']);
$cislo_rdp = strip_tags($_REQUEST['cislo_rdp']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_uctdrdp ( rdp,nrd,szd,crz,crd,crz1,crd3,crz3 ) VALUES ($h_rdp, '$h_nrd', '$h_szd', '$h_crz', '$h_crd', '$h_crz1', '$h_crd3', '$h_crz3'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA rdp:$h_rdp SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_uctdrdp WHERE rdp='$cislo_rdp'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA rdp:$cislo_rdp BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_nrd = strip_tags($_REQUEST['h_nrd']);
$h_szd = strip_tags($_REQUEST['h_szd']);
$h_crz = strip_tags($_REQUEST['h_crz']);
$h_crd = strip_tags($_REQUEST['h_crd']);
$h_crz1 = strip_tags($_REQUEST['h_crz1']);
$h_crd3 = strip_tags($_REQUEST['h_crd3']);
$h_crz3 = strip_tags($_REQUEST['h_crz3']);
$cislo_rdp = strip_tags($_REQUEST['cislo_rdp']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_uctdrdp SET rdp='$h_rdp', nrd='$h_nrd', szd='$h_szd', crz='$h_crz', crd='$h_crd', crz1='$h_crz1', crd3='$h_crd3', crz3='$h_crz3' WHERE rdp='$cislo_rdp'");  
$copern=1;
$cislo_rdp = $h_rdp;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA rdp:$cislo_rdp UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_rdp = strip_tags($_REQUEST['h_rdp']);
$cislo_rdp = strip_tags($_REQUEST['h_rdp']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp = $cislo_rdp ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nrd = $riadok->nrd;
$h_szd = $riadok->szd;
$h_crz = $riadok->crz;
$h_crd = $riadok->crd;
$h_crz1 = $riadok->crz1;
$h_crd3 = $riadok->crd3;
$h_crz3 = $riadok->crz3;

  }
       }
//koniec uprava nacitanie

//6=uprava
if ( $copern == 6 )
  {
$cislo_rdp = strip_tags($_REQUEST['cislo_rdp']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Druhy dokladov DPH</title>
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
    document.formhl1.hladaj_nrd.focus();
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
    document.formv1.h_rdp.value = '<?php echo "$h_rdp";?>';
    document.formv1.h_nrd.value = '<?php echo "$h_nrd";?>';
    document.formv1.h_szd.value = '<?php echo "$h_szd";?>';
    document.formv1.h_crz.value = '<?php echo "$h_crz";?>';
    document.formv1.h_crd.value = '<?php echo "$h_crd";?>';
    document.formv1.h_crz1.value = '<?php echo "$h_crz1";?>';
    document.formv1.h_crd3.value = '<?php echo "$h_crd3";?>';
    document.formv1.h_crz3.value = '<?php echo "$h_crz3";?>';
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
    document.formv1.h_rdp.focus();
    document.formv1.h_rdp.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_rdp.value == '' ) okvstup=0;
    if ( document.formv1.h_nrd.value == '' ) okvstup=0;
    if ( document.formv1.h_szd.value == '' ) okvstup=0;
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
<td>EuroSecom  -  Druhy dokladov DPH

 <a href="#" onClick="window.open('drudan.php?copern=1001&drupoh=1&page=1','_self' );" >
<input type='image' src='../obr/ok.png' width=20 height=20 border=0 alt='Obnov DPH20% pre rok 2011 v druhoch dokladov a automatickom ˙ËtovanÌ'></a>

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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp ORDER BY rdp");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nrd = strip_tags($_REQUEST['hladaj_nrd']);
$hladaj_rdp = strip_tags($_REQUEST['hladaj_rdp']);

if ( $hladaj_nrd != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE ( nrd LIKE '%$hladaj_nrd%' ) ORDER BY rdp");
if ( $hladaj_rdp != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE ( rdp = '$hladaj_rdp' ) ORDER BY rdp");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE NOT ( rdp='$cislo_rdp' ) ORDER BY rdp");
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
<FORM name="formhl1" class="hmenu" method="post" action="drudan.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" >
<a href="#" onClick="window.open('drudan_pdf.php?copern=10&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='TlaË druhov daÚov˝ch dokladov vo form·te PDF' ></a>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" colspan="2">
<?php
if ( $kli_uzall > 25000 )
  {
?>

<img src='../obr/orig.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1516&page=1', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ötandartn˝ ËÌselnÌk druhov DPH z ../import/druhdph<?php echo $kli_vrok; ?>.csv" >
 - 
<img src='../obr/export.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=16&page=1', '_self');" 
width=20 height=15 border=0 title="Exportovaù ËÌselnÌk druhov DPH do s˙boru CSV" >
 - 
<img src='../obr/kos.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1816&page=1', '_self');" 
width=20 height=15 border=0 title="Vymazaù ËÌselnÌk druhov DPH" >
<?php
  }
?>

<img src='../obr/zoznam.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1516&page=1&dopln=1', '_self');" 
width=20 height=15 border=0 title="Doplniù ËÌselnÌk druhov DPH z ../import/druhdph<?php echo $kli_vrok; ?>dopln.csv" >

<img src='../obr/ziarovka.png' onclick="window.open('drudan.php?copern=4055&drupoh=<?php echo $drupoh; ?>', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ËÌselnÌk druhov DPH z firmy Ë. <?php echo $fir_allx11; ?> minulÈho roka" >
</td>

<td class="hmenu" >
 27,32<img src='../obr/zoznam.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1516&page=1&dopln=27', '_self');" 
width=20 height=15 border=0 title="Doplniù pauö·lny druh DPH 27 a druhy 32, 82 z ../import/druhdph<?php echo $kli_vrok; ?>dopln27.csv" >
</td>

</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_rdp" id="hladaj_rdp" size="15" value="<?php echo $hladaj_rdp;?>" />
<td class="hmenu"><input type="text" name="hladaj_nrd" id="hladaj_nrd" size="50" value="<?php echo $hladaj_nrd;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="drudan.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >RDP
<td class="hmenu" width="40%" >N·zov
<td class="hmenu" width="5%" >Sadzba
<td class="hmenu" width="10%" >»R Z·klad
<td class="hmenu" width="10%" >»R DaÚ
<td class="hmenu" width="5%" >JCD3k <img src='../obr/info.png' width=10 height=10 border=0 title='JCD z tretÌch krajÌn 0=nie,1=·no'>
<td class="hmenu" width="5%" >SZD <img src='../obr/info.png' width=10 height=10 border=0 title='Samozdanenie 0=nie,1=·no'>
<td class="hmenu" width="5%" >oddKV <img src='../obr/info.png' width=10 height=10 border=0 title='Oddiel KV DPH A1,A2...D2'>
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
<td class="fmenu" ><?php echo $riadok->rdp;?></td>
<td class="fmenu" ><?php echo $riadok->nrd;?></td>
<td class="fmenu" ><?php echo $riadok->szd;?></td>
<td class="fmenu" ><?php echo $riadok->crz;?></td>
<td class="fmenu" ><?php echo $riadok->crd;?></td>
<td class="fmenu" ><?php echo $riadok->crz1;?></td>
<td class="fmenu" ><?php echo $riadok->crz3;?></td>
<td class="fmenu" ><?php echo $riadok->crd3;?></td>
<td class="fmenu" ><a href='drudan.php?copern=8&page=<?php echo $page;?>&cislo_rdp=<?php echo $riadok->rdp;?>
&h_rdp=<?php echo $riadok->rdp;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='drudan.php?copern=6&page=<?php echo $page;?>&cislo_rdp=<?php echo $riadok->rdp;?>'>Zmaû</a></td>
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
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_nrd = strip_tags($_REQUEST['h_nrd']);
$h_szd = strip_tags($_REQUEST['h_szd']);
$h_crz = strip_tags($_REQUEST['h_crz']);
$h_crd = strip_tags($_REQUEST['h_crd']);
$h_crz1 = strip_tags($_REQUEST['h_crz1']);
$h_crd3 = strip_tags($_REQUEST['h_crd3']);
$h_crz3 = strip_tags($_REQUEST['h_crz3']);
$cislo_rdp = strip_tags($_REQUEST['cislo_rdp']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp='$cislo_rdp'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["rdp"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nrd"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["szd"];?></td>
<td class="fmenu" width="9%" ><?php echo $zaznam["crz"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["crd"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["crz1"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["crz3"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["crd3"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="drudan.php?page=<?php echo $page;?>&copern=16>&cislo_rdp=<?php echo $cislo_rdp;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="drudan.php?page=<?php echo $page;?>&copern=1" >
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
<span id="rdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 ⁄Ëet musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù celÈ ËÌslo </span>
<span id="Desat" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka rdp=<?php echo $h_rdp;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="drudan.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_rdp=$cislo_rdp"; } ?>
" >

<td class="fmenu"><input type="text" name="h_rdp" id="h_rdp" size="5" onclick="Fx.style.display='none';"
onchange="return intg(this,0,9999999,rdp,document.formv1.err_rdp)" 
 onkeyup="KontrolaCisla(this, rdp)" />
<INPUT type="hidden" name="err_rdp" value="0"></td>


<td class="fmenu"><input type="text" name="h_nrd" id="h_nrd" size="60" 
 /></td>

<td class="fmenu"><input type="text" name="h_szd" id="h_szd" size="5" 
onchange="return intg(this,0,999,Cele,document.formv1.err_szd)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_szd" value="0"></td>

<td class="fmenu"><input type="text" name="h_crz" id="h_crz" size="5" 
onchange="return intg(this,0,999,Cele,document.formv1.err_crz)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_crz" value="0"></td>

<td class="fmenu"><input type="text" name="h_crd" id="h_crd" size="5" 
onchange="return intg(this,0,999,Cele,document.formv1.err_crd)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_crd" value="0"></td>

<td class="fmenu"><input type="text" name="h_crz1" id="h_crz1" size="5" 
onchange="return intg(this,0,999,Cele,document.formv1.err_crz1)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_crz1" value="0"></td>

<td class="fmenu"><input type="text" name="h_crz3" id="h_crz3" size="5"  />

<td class="fmenu"><input type="text" name="h_crd3" id="h_crd3" size="5"  />
<INPUT type="hidden" name="err_crd3" value="0"></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="drudan.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka rdp=<?php echo $cislo_rdp;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka rdp=<?php echo $cislo_rdp;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="drudan.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_rdp=$hladaj_rdp&hladaj_nrd=$hladaj_nrd";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="drudan.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_rdp=$hladaj_rdp&hladaj_nrd=$hladaj_nrd";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="drudan.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="drudan.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
