<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$cslm=101806;
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

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }

//ak neexistuje uctpohyby vytvor
if( $fir_uctx03 == 1 )
           {
//ak neexistuje uctpohyby tak ju vytvor
$sql = "SELECT * FROM F$kli_vxcf"."_uctpohyby";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }

$sql = "CREATE TABLE F".$kli_vxcf."_uctpohyby SELECT * FROM uctpohyby$nuctpoh ";
$vysledek = mysql_query("$sql");

}
          }
//koniec ak neexistuje uctpohyby vytvor


$sql = "ALTER TABLE $ductpoh"."uctpohyby$nuctpoh MODIFY cpoh int PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

if( $kli_vrok > 2011 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpohyby MODIFY cpoh int(11) PRIMARY KEY  ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F$kli_vxcf"."_uctpohybyxxx SELECT * FROM F$kli_vxcf"."_uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "TRUNCATE F$kli_vxcf"."_uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F$kli_vxcf"."_uctpohyby SELECT * FROM F$kli_vxcf"."_uctpohybyxxx GROUP BY cpoh ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctpohybyxxx ";
$vysledek = mysql_query("$sql");
}


if( $kli_vrok > 2011 )
{
$sql = "ALTER TABLE uctpohyby MODIFY cpoh int(11) PRIMARY KEY  ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F$kli_vxcf"."_uctpohybyxxx SELECT * FROM uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "TRUNCATE uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO uctpohyby SELECT * FROM F$kli_vxcf"."_uctpohybyxxx GROUP BY cpoh ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctpohybyxxx ";
$vysledek = mysql_query("$sql");
}

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v uctpoh.php
// 6=vymazanie polozky potvrdene v uctpoh.php
if ( $copern == 15 || $copern == 16 )
     {
$h_cpoh = strip_tags($_REQUEST['h_cpoh']);
$h_ucto = strip_tags($_REQUEST['h_ucto']);
$h_druh = strip_tags($_REQUEST['h_druh']);
$h_pohp = strip_tags($_REQUEST['h_pohp']);
$h_uzk2 = strip_tags($_REQUEST['h_uzk2']);
$h_udn2 = strip_tags($_REQUEST['h_udn2']);
$h_dzk2 = strip_tags($_REQUEST['h_dzk2']);
$h_uzk1 = strip_tags($_REQUEST['h_uzk1']);
$h_udn1 = strip_tags($_REQUEST['h_udn1']);
$h_ddn1 = strip_tags($_REQUEST['h_ddn1']);
$h_dzk1 = strip_tags($_REQUEST['h_dzk1']);
$h_uzk0 = strip_tags($_REQUEST['h_uzk0']);
$h_dzk0 = strip_tags($_REQUEST['h_dzk0']);
$h_hfak = strip_tags($_REQUEST['h_hfak']);
$h_hico = strip_tags($_REQUEST['h_hico']);
$h_hstr = strip_tags($_REQUEST['h_hstr']);
$h_hzak = strip_tags($_REQUEST['h_hzak']);
$cislo_cpoh = strip_tags($_REQUEST['cislo_cpoh']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = "INSERT INTO $ductpoh"."uctpohyby$nuctpoh ( cpoh,ucto,druh,pohp,uzk2,udn2,dzk2,hfak,hico,uzk1,udn1,dzk1,uzk0,dzk0,hstr,hzak,ddn1 ) ".
"VALUES ('$h_cpoh', '$h_ucto', '$h_druh', '$h_pohp', '$h_uzk2', '$h_udn2', '$h_dzk2', '$h_hfak', '$h_hico', ".
"'$h_uzk1', '$h_udn1', '$h_dzk1', '$h_uzk0', '$h_dzk0', '$h_hstr', '$h_hzak', '$h_ddn1' ); "; 
$ulozene = mysql_query("$ulozttt"); 

$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA cpoh:$h_cpoh SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM $ductpoh"."uctpohyby$nuctpoh WHERE cpoh='$cislo_cpoh'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA cpoh:$cislo_cpoh BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_cpoh = strip_tags($_REQUEST['h_cpoh']);
$h_ucto = strip_tags($_REQUEST['h_ucto']);
$h_druh = strip_tags($_REQUEST['h_druh']);
$h_pohp = strip_tags($_REQUEST['h_pohp']);
$h_uzk2 = strip_tags($_REQUEST['h_uzk2']);
$h_udn2 = strip_tags($_REQUEST['h_udn2']);
$h_dzk2 = strip_tags($_REQUEST['h_dzk2']);
$h_hfak = strip_tags($_REQUEST['h_hfak']);
$h_hico = strip_tags($_REQUEST['h_hico']);
$h_uzk1 = strip_tags($_REQUEST['h_uzk1']);
$h_udn1 = strip_tags($_REQUEST['h_udn1']);
$h_ddn1 = strip_tags($_REQUEST['h_ddn1']);
$h_dzk1 = strip_tags($_REQUEST['h_dzk1']);
$h_uzk0 = strip_tags($_REQUEST['h_uzk0']);
$h_dzk0 = strip_tags($_REQUEST['h_dzk0']);
$h_hstr = strip_tags($_REQUEST['h_hstr']);
$h_hzak = strip_tags($_REQUEST['h_hzak']);
$cislo_cpoh = strip_tags($_REQUEST['cislo_cpoh']);

$upravttt = "UPDATE $ductpoh"."uctpohyby$nuctpoh SET ucto='$h_ucto', druh='$h_druh', pohp='$h_pohp', uzk1='$h_uzk1', udn1='$h_udn1', dzk1='$h_dzk1',".
" uzk0='$h_uzk0', dzk0='$h_dzk0', hstr='$h_hstr', hzak='$h_hzak', ddn1='$h_ddn1', ".
" uzk2='$h_uzk2', udn2='$h_udn2', dzk2='$h_dzk2', hfak='$h_hfak', hico='$h_hico' WHERE cpoh='$cislo_cpoh'";  
$upravene = mysql_query("$upravttt");  

$copern=1;
$cislo_cpoh = $h_cpoh;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA cpoh:$cislo_cpoh UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_cpoh = strip_tags($_REQUEST['h_cpoh']);
$cislo_cpoh = strip_tags($_REQUEST['h_cpoh']);

$sqltt = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE cpoh = $cislo_cpoh ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_cpoh = $riadok->cpoh;
$h_ucto = $riadok->ucto;
$h_druh = $riadok->druh;
$h_pohp = $riadok->pohp;
$h_uzk2 = $riadok->uzk2;
$h_udn2 = $riadok->udn2;
$h_dzk2 = $riadok->dzk2;
$h_hfak = $riadok->hfak;
$h_hico = $riadok->hico;
$h_uzk1 = $riadok->uzk1;
$h_udn1 = $riadok->udn1;
$h_ddn1 = $riadok->ddn1;
$h_dzk1 = $riadok->dzk1;
$h_uzk0 = $riadok->uzk0;
$h_dzk0 = $riadok->dzk0;
$h_hstr = $riadok->hstr;
$h_hzak = $riadok->hzak;

  }
       }
//koniec uprava nacitanie

//6=uprava
if ( $copern == 6 )
  {
$cislo_cpoh = strip_tags($_REQUEST['cislo_cpoh']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄ËtovnÈ pohyby</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;


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
    document.formhl1.hladaj_ucto.focus();
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
    document.formv1.h_cpoh.value = '<?php echo "$h_cpoh";?>';
    document.formv1.h_ucto.value = '<?php echo "$h_ucto";?>';
    document.formv1.h_druh.value = '<?php echo "$h_druh";?>';
    document.formv1.h_pohp.value = '<?php echo "$h_pohp";?>';
    document.formv1.h_uzk2.value = '<?php echo "$h_uzk2";?>';
    document.formv1.h_udn2.value = '<?php echo "$h_udn2";?>';
    document.formv1.h_dzk2.value = '<?php echo "$h_dzk2";?>';
    document.formv1.h_hfak.value = '<?php echo "$h_hfak";?>';
    document.formv1.h_hico.value = '<?php echo "$h_hico";?>';
    document.formv1.h_uzk1.value = '<?php echo "$h_uzk1";?>';
    document.formv1.h_udn1.value = '<?php echo "$h_udn1";?>';
    document.formv1.h_ddn1.value = '<?php echo "$h_ddn1";?>';
    document.formv1.h_dzk1.value = '<?php echo "$h_dzk1";?>';
    document.formv1.h_uzk0.value = '<?php echo "$h_uzk0";?>';
    document.formv1.h_dzk0.value = '<?php echo "$h_dzk0";?>';
    document.formv1.h_hstr.value = '<?php echo "$h_hstr";?>';
    document.formv1.h_hzak.value = '<?php echo "$h_hzak";?>';
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
    document.formv1.h_cpoh.focus();
    document.formv1.h_cpoh.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_cpoh.value == '' ) okvstup=0;
    if ( document.formv1.h_pohp.value == '' ) okvstup=0;
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
$pols = 6;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  ⁄ËtovnÈ pohyby 
<?php if( $fir_uctx03 == 0 ) { echo " SpoloËne pre vöetky firmy"; } ?>
<?php if( $fir_uctx03 == 1 ) { echo " Samostatne pre firmu"; } ?>
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
$sql = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh ORDER BY cpoh");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_druh = strip_tags($_REQUEST['hladaj_druh']);
$hladaj_ucto = strip_tags($_REQUEST['hladaj_ucto']);
$hladaj_pohp = strip_tags($_REQUEST['hladaj_pohp']);

if ( $hladaj_druh != "" ) $sql = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ( druh = '$hladaj_druh' ) ORDER BY cpoh");
if ( $hladaj_ucto != "" ) $sql = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ( ucto = '$hladaj_ucto' ) ORDER BY cpoh");
if ( $hladaj_pohp != "" ) $sql = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ( pohp LIKE '%$hladaj_ucto%' ) ORDER BY cpoh");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE NOT ( cpoh='$cislo_cpoh' ) ORDER BY cpoh");
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
<FORM name="formhl1" class="hmenu" method="post" action="uctpoh.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<?php
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }
if ( $kli_uzall > 25000 AND $fir_uctx03 == 1 )
  {
?>
<td class="hmenu" colspan="2">
<img src='../obr/orig.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1515&page=1', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ötandartn˝ ËÌselnÌk ⁄Ëtovn˝ch pohybov z ../import/uctautpoh<?php echo $kli_vrok; ?><?php echo $jejednoduche; ?>.csv" >
 - 
<img src='../obr/export.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=15&page=1', '_self');" 
width=20 height=15 border=0 title="Exportovaù ËÌselnÌk druhov DPH do s˙boru CSV" >
 - 
<img src='../obr/kos.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1815&page=1', '_self');" 
width=20 height=15 border=0 title="Vymazaù ËÌselnÌk ⁄Ëtovn˝ch pohybov" >
<?php
  }
?>
</tr>
<tr>
<td class="hmenu"></td>
<td class="hmenu"><input type="text" name="hladaj_ucto" id="hladaj_ucto" size="2" value="<?php echo $hladaj_ucto;?>" />
<td class="hmenu"><input type="text" name="hladaj_druh" id="hladaj_druh" size="2" value="<?php echo $hladaj_druh;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_pohp" id="hladaj_pohp" size="10" value="<?php echo $hladaj_pohp;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="uctpoh.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
<td class="hmenu"></td>
<td class="hmenu">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=11&page=1', '_blank','<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄prava a nahr·vanie Vzorov˝ch ˙Ëtovn˝ch DOKladov = VzorDOK' ></a>
</td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="5%" >Ucto
<td class="hmenu" width="5%" >Druh
<td class="hmenu" width="25%" >Popis
<td class="hmenu" width="6%" >Dzk2,1,0
<td class="hmenu" width="7%" >Uzk2,1,0
<td class="hmenu" width="7%" >Udn2,1
<td class="hmenu" width="10%" >HFK/STR
<td class="hmenu" width="10%" >HI»/ZAK
<td class="hmenu" width="5%" >Uprav
<th class="hmenu" width="10%" >Zmaû
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
<td class="fmenu" rowspan="3"><?php echo $riadok->cpoh;?></td>
<td class="fmenu" rowspan="3"><?php echo $riadok->ucto;?></td>
<td class="fmenu" rowspan="3"><?php echo $riadok->druh;?></td>
<td class="fmenu" rowspan="3"><?php echo $riadok->pohp;?></td>
<td class="fmenu" >2 <?php echo $riadok->dzk2;?></td>
<td class="fmenu" ><?php echo $riadok->uzk2;?></td>
<td class="fmenu" ><?php echo $riadok->udn2;?></td>
<td class="fmenu" ><?php echo $riadok->hfak;?></td>
<td class="fmenu" ><?php echo $riadok->hico;?></td>
<td class="fmenu" rowspan="3"><a href='uctpoh.php?copern=8&page=<?php echo $page;?>&cislo_cpoh=<?php echo $riadok->cpoh;?>
&h_cpoh=<?php echo $riadok->cpoh;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" rowspan="3"><a href='uctpoh.php?copern=6&page=<?php echo $page;?>&cislo_cpoh=<?php echo $riadok->cpoh;?>'>Zmaû</a></td>
</tr>
<tr>
<td class="fmenu" >1 <?php echo $riadok->dzk1;?></td>
<td class="fmenu" ><?php echo $riadok->uzk1;?></td>
<td class="fmenu" ><?php echo $riadok->udn1;?></td>
<td class="fmenu" ><?php echo $riadok->hstr;?></td>
<td class="fmenu" ><?php echo $riadok->hzak;?></td>
</tr>
<tr>
<td class="fmenu" >0 <?php echo $riadok->dzk0;?></td>
<td class="fmenu" ><?php echo $riadok->uzk0;?></td>
<td class="fmenu" > </td>
<td class="fmenu" colspan="2">VzorDOK: <?php echo $riadok->ddn1;?></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>
<?php
if ( $copern != 5 AND $copern != 8 )
  {
?>

<tr><td colspan="9"><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td></tr>

<?php
}
?>
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
$h_cpoh = strip_tags($_REQUEST['h_cpoh']);
$h_ucto = strip_tags($_REQUEST['h_ucto']);
$h_druh = strip_tags($_REQUEST['h_druh']);
$h_pohp = strip_tags($_REQUEST['h_pohp']);
$h_uzk2 = strip_tags($_REQUEST['h_uzk2']);
$h_udn2 = strip_tags($_REQUEST['h_udn2']);
$h_dzk2 = strip_tags($_REQUEST['h_dzk2']);
$h_hfak = strip_tags($_REQUEST['h_hfak']);
$h_hico = strip_tags($_REQUEST['h_hico']);
$h_uzk1 = strip_tags($_REQUEST['h_uzk1']);
$h_udn1 = strip_tags($_REQUEST['h_udn1']);
$h_ddn1 = strip_tags($_REQUEST['h_ddn1']);
$h_dzk1 = strip_tags($_REQUEST['h_dzk1']);
$h_uzk0 = strip_tags($_REQUEST['h_uzk0']);
$h_dzk0 = strip_tags($_REQUEST['h_dzk0']);
$h_hstr = strip_tags($_REQUEST['h_hstr']);
$h_hzak = strip_tags($_REQUEST['h_hzak']);
$cislo_cpoh = strip_tags($_REQUEST['cislo_cpoh']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE cpoh='$cislo_cpoh'";
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
<td class="fmenu" ><?php echo $zaznam["cpoh"];?></td>
<td class="fmenu" ><?php echo $zaznam["ucto"];?></td>
<td class="fmenu" ><?php echo $zaznam["druh"];?></td>
<td class="fmenu" ><?php echo $zaznam["pohp"];?></td>
<td class="fmenu" ><?php echo $zaznam["dzk2"];?></td>
<td class="fmenu" ><?php echo $zaznam["uzk2"];?></td>
<td class="fmenu" ><?php echo $zaznam["udn2"];?></td>
<td class="fmenu" ><?php echo $zaznam["hfak"];?></td>
<td class="fmenu" ><?php echo $zaznam["hico"];?></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="uctpoh.php?page=<?php echo $page;?>&copern=16>&cislo_cpoh=<?php echo $cislo_cpoh;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="uctpoh.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka cpoh=<?php echo $h_cpoh;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="uctpoh.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cpoh=$cislo_cpoh"; } ?>
" >

<td class="fmenu" rowspan="3"><input type="text" name="h_cpoh" id="h_cpoh" size="5" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,9999999,Cele,document.formv1.err_cpoh)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_cpoh" value="0"></td>

<td class="fmenu" rowspan="3">
<select size="1" name="h_ucto" id="h_ucto" onmouseover="Fx.style.display='none';"  >
<option value="0" >0=PU</option>
<option value="9" >9=JU</option>
</select>

<td class="fmenu" rowspan="3">
<select size="1" name="h_druh" id="h_druh" onmouseover="Fx.style.display='none';"  >
<option value="1" >1=POKL-P</option>
<option value="2" >2=POKL-V</option>
<option value="4" >4=BANK</option>
<option value="5" >5=VäEOB</option>
<option value="11" >11=ODBER</option>
<option value="12" >12=DODAV</option>
<option value="21" >21=POKL-P vzor</option>
<option value="22" >22=POKL-V vzor</option>
</select>

<td class="fmenu" rowspan="3"><input type="text" name="h_pohp" id="h_pohp" size="46" maxlength="50"
 /></td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp > 0 ORDER BY rdp");
?>2
<select class="hvstup" size="1" name="h_dzk2" id="h_dzk2" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["rdp"];?>" >
<?php echo $zaznam["rdp"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce != '' ORDER BY uce");
?>
<select class="hvstup" size="1" name="h_uzk2" id="h_uzk2" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["uce"];?>" >
<?php echo $zaznam["uce"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce != '' ORDER BY uce");
?>
<select class="hvstup" size="1" name="h_udn2" id="h_udn2" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["uce"];?>" >
<?php echo $zaznam["uce"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu"><input type="text" name="h_hfak" id="h_hfak" size="5" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,9999999,Cele,document.formv1.err_hfak)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_hfak" value="0"></td>

<td class="fmenu"><input type="text" name="h_hico" id="h_hico" size="5" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,999999,Cele,document.formv1.err_hico)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_hico" value="0"></td>

<td class="fmenu" rowspan="3"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu" rowspan="3"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>
</tr>

<tr>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp > 0 ORDER BY rdp");
?>1
<select class="hvstup" size="1" name="h_dzk1" id="h_dzk1" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["rdp"];?>" >
<?php echo $zaznam["rdp"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce != '' ORDER BY uce");
?>
<select class="hvstup" size="1" name="h_uzk1" id="h_uzk1" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["uce"];?>" >
<?php echo $zaznam["uce"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce != '' ORDER BY uce");
?>
<select class="hvstup" size="1" name="h_udn1" id="h_udn1" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["uce"];?>" >
<?php echo $zaznam["uce"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu"><input type="text" name="h_hstr" id="h_hstr" size="5" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,9999999,Cele,document.formv1.err_hstr)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_hstr" value="0"></td>

<td class="fmenu"><input type="text" name="h_hzak" id="h_hzak" size="5" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,999999,Cele,document.formv1.err_hzak)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_hzak" value="0"></td>

</tr>

<tr>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE rdp > 0 ORDER BY rdp");
?>0
<select class="hvstup" size="1" name="h_dzk0" id="h_dzk0" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["rdp"];?>" >
<?php echo $zaznam["rdp"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce != '' ORDER BY uce");
?>
<select class="hvstup" size="1" name="h_uzk0" id="h_uzk0" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["uce"];?>" >
<?php echo $zaznam["uce"];?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" colspan="1"> </td>
<td class="fmenu" colspan="2">VzorDOK: <input type="text" name="h_ddn1" id="h_ddn1" size="8" onclick="Fx.style.display='none';" 
onchange="return intg(this,0,99999999,Cele,document.formv1.err_ddn1)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_ddn1" value="0"></td>
</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="uctpoh.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
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
 Poloûka cpoh=<?php echo $cislo_cpoh;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka cpoh=<?php echo $cislo_cpoh;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="uctpoh.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ucto=$hladaj_ucto&hladaj_druh=$hladaj_druh&hladaj_pohp=$hladaj_pohp";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="uctpoh.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ucto=$hladaj_ucto&hladaj_druh=$hladaj_druh&hladaj_pohp=$hladaj_pohp";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="uctpoh.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="uctpoh.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
