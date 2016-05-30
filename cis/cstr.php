<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 2000;
$cslm=101903;
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
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";


//import z ../import/FIR$kli_vxcf/CIS_STR.CSV
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/CIS_STR.CSV ?") )
         { window.close()  }
else
         { location.href='cstr.php?copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/CIS_STR.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/CIS_STR.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/CIS_STR.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_str = $pole[0];
  $x_nst = $pole[1];
  $x_kon = $pole[2];

 
$c_str=1*$x_str;
if( $x_nst == '' ) $x_nst="Stredisko ".$x_str;

if( $c_str > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_str ( str,nst,dst,ust )".
" VALUES ( '$x_str', '$x_nst', 1, 1 ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_str!"." naimportovan· <br />";

fclose ($subor);


if( file_exists("../import/FIR$kli_vxcf/CIS_STA.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/CIS_STA.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/CIS_STA.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_sta = $pole[0];
  $x_nzst = $pole[1];
  $x_kon = $pole[2];

 
$c_sta=1*$x_sta;
if( $x_nzst == '' ) $x_nzst="Stavba ".$x_sta;

if( $c_sta > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_stv ( stv,nsv,dsv,usv )".
" VALUES ( '$x_sta', '$x_nzst', 1, 1 ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_sta!"." naimportovan· <br />";

fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/CIS_SKU.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/CIS_SKU.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/CIS_SKU.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_sku = $pole[0];
  $x_nzsk = $pole[1];
  $x_kon = $pole[2];

 
$c_sku=1*$x_sku;
if( $x_nzsk == '' ) $x_nzsk="Skupina ".$x_sku;

if( $c_sku > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_sku ( sku,nsu,dsu,usu )".
" VALUES ( '$x_sku', '$x_nzsk', 1, 1 ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_sku!"." naimportovan· <br />";

fclose ($subor);

    }
//koniec nacitania stredisk,skupin,stavieb



//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r stredÌsk ?") )
         { window.close()  }
else
         { location.href='cstr.php?copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_str';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_str!"." vynulovan· <br />";
    }



// 5=ulozenie polozky do databazy nahratej v cstr.php
// 6=vymazanie polozky potvrdene v cstr.php
if ( $copern == 15 || $copern == 16 )
     {
$h_str = strip_tags($_REQUEST['h_str']);
$h_nst = strip_tags($_REQUEST['h_nst']);
$h_dst = strip_tags($_REQUEST['h_dst']);
$h_ust = strip_tags($_REQUEST['h_ust']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
//ulozenie novej
if ( $copern == 15 )
    {
$sql = "ALTER TABLE F$kli_vxcf"."_str  ADD PRIMARY KEY ( str )";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_str  ADD UNIQUE ( str )";
$vysledek = mysql_query("$sql");

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_str ( str,nst,dst,ust ) VALUES ($h_str, '$h_nst', $h_dst, '$h_ust'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA STR:$h_str SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_str WHERE str='$cislo_str'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA STR:$cislo_str BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_str = strip_tags($_REQUEST['h_str']);
$h_nst = strip_tags($_REQUEST['h_nst']);
$h_dst = strip_tags($_REQUEST['h_dst']);
$h_ust = strip_tags($_REQUEST['h_ust']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_str SET str='$h_str', nst='$h_nst', dst='$h_dst', ust='$h_ust' WHERE str='$cislo_str'");  
$copern=1;
$cislo_str = $h_str;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA STR:$cislo_str UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$h_str = strip_tags($_REQUEST['h_str']);
$h_nst = strip_tags($_REQUEST['h_nst']);
$h_dst = strip_tags($_REQUEST['h_dst']);
$h_ust = strip_tags($_REQUEST['h_ust']);
$cislo_str = strip_tags($_REQUEST['h_str']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_str = strip_tags($_REQUEST['cislo_str']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>».stredÌsk</title>
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
    document.formhl1.hladaj_nst.focus();
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
    document.formv1.h_nst.value = '<?php echo "$h_nst";?>';
    document.formv1.h_dst.value = <?php echo "$h_dst";?>;
    document.formv1.h_ust.value = '<?php echo "$h_ust";?>';
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
//    WriteCookie ( 'str_str', document.formv1.h_str.value , 240);
//    WriteCookie ( 'str_nst', document.formv1.h_nst.value , 240);
//    WriteCookie ( 'str_ust', document.formv1.h_ust.value , 240);
//    WriteCookie ( 'str_dst', document.formv1.h_dst.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_str.value = (ReadCookie ( 'str_str', '1' ));
//    document.formv1.h_nst.value = (ReadCookie ( 'str_nst', 'nazov' ));
//    document.formv1.h_ust.value = (ReadCookie ( 'str_ust', '11200' ));
//    document.formv1.h_dst.value = (ReadCookie ( 'str_dst', '1' ));
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
    document.formv1.h_str.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_str.value == '' ) okvstup=0;
    if ( document.formv1.h_nst.value == '' ) okvstup=0;
    if ( document.formv1.h_dst.value == '' ) okvstup=0;
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
<td>EuroSecom  -  »ÌselnÌk stredÌsk
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
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_str ORDER BY str");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nst = strip_tags($_REQUEST['hladaj_nst']);
$hladaj_str = strip_tags($_REQUEST['hladaj_str']);

if ( $hladaj_nst != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_str WHERE ( nst LIKE '%$hladaj_nst%' ) ORDER BY str");
if ( $hladaj_str != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_str WHERE ( str = '$hladaj_str' ) ORDER BY str");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_str WHERE NOT ( str='$cislo_str' ) ORDER BY str");
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
<FORM name="formhl1" class="hmenu" method="post" action="cstr.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_str" id="hladaj_str" size="15" value="<?php echo $hladaj_str;?>" />
<td class="hmenu"><input type="text" name="hladaj_nst" id="hladaj_nst" size="50" value="<?php echo $hladaj_nst;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cstr.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>

<?php
if ( $kli_uzall > 3000 )
  {
?>
<td class="hmenu" ><a href='cstr.php?copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='cstr.php?copern=55&page=1'>
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
<th class="hmenu">Stredisko<th class="hmenu">N·zov strediska<th class="hmenu">Druh strediska<th class="hmenu">Parametre
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
<td class="fmenu" width="60%" ><?php echo $riadok->nst;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->dst;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->ust;?></td>
<td class="fmenu" width="5%" ><a href='cstr.php?copern=8&page=<?php echo $page;?>&cislo_str=<?php echo $riadok->str;?>&h_str=<?php echo $riadok->str;?>&h_dst=<?php echo $riadok->dst;?>&h_nst=<?php echo $riadok->nst;?>&h_ust=<?php echo $riadok->ust;?>'> <img src='../obr/uprav.png' title="Upraviù poloûku" width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='cstr.php?copern=6&page=<?php echo $page;?>&cislo_str=<?php echo $riadok->str;?>'>Zmaû</a></td>
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
$h_nst = strip_tags($_REQUEST['h_nst']);
$h_dst = strip_tags($_REQUEST['h_dst']);
$h_ust = strip_tags($_REQUEST['h_ust']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_str WHERE str='$cislo_str'";
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
<td class="fmenu" width="60%" ><?php echo $zaznam["nst"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["dst"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["ust"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cstr.php?page=<?php echo $page;?>&copern=16>&cislo_str=<?php echo $cislo_str;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cstr.php?page=<?php echo $page;?>&copern=1" >
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
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh strediska musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parametre strediska musia byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka STR=<?php echo $h_str;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="cstr.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_str=$cislo_str"; } ?>
" >

<td class="fmenu"><input type="text" name="h_str" id="h_str" size="5" 
onchange="return intg(this,0,99999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />


<td class="fmenu"><input type="text" name="h_nst" id="h_nst" size="40" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_dst" id="h_dst" size="5" 
onchange="return intg(this,1,9,Dx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Dx)" />

<td class="fmenu"><input type="text" name="h_ust" id="h_ust" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

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
<FORM name="formv4" class="obyc" method="post" action="cstr.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka STR=<?php echo $cislo_str;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka STR=<?php echo $cislo_str;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="cstr.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_nst=$hladaj_nst";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="cstr.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_nst=$hladaj_nst";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="cstr.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cstr.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cstr_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_nst=$hladaj_nst&hladaj_str=$hladaj_str";
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
