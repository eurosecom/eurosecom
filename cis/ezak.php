<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 5000;
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

$firweb=0;
$sqlfir = "SELECT fir FROM F$kli_vxcf"."_webslu ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $firweb = 1*$fir_riadok->fir; }

$kdewebs="";
$firweb=1*$kli_vxcf;
if( $firweb > 0 ) { $kdewebs="F".$firweb."_"; }
$eshop_fir=1*$_SESSION['eshop_fir'];
if( $eshop_fir > 0 ) { $kdewebs="F".$eshop_fir."_"; }

if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $kdewebs=""; }

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$ez_id = strip_tags($_REQUEST['ez_id']);
$ez_meno = strip_tags($_REQUEST['ez_meno']);
$ez_heslo = strip_tags($_REQUEST['ez_heslo']);
$ez_ico = strip_tags($_REQUEST['ez_ico']);
$ez_tel = strip_tags($_REQUEST['ez_tel']);
$ez_ema = strip_tags($_REQUEST['ez_ema']);
$ez_kto = strip_tags($_REQUEST['ez_kto']);
$ccen = strip_tags($_REQUEST['ccen']);
$cskl = strip_tags($_REQUEST['cskl']);
$cskp = strip_tags($_REQUEST['cskp']);
$cskf = strip_tags($_REQUEST['cskf']);
$cuid = strip_tags($_REQUEST['cuid']);
$cxx1 = strip_tags($_REQUEST['cxx1']);
$imei = strip_tags($_REQUEST['imei']);

$sql = "ALTER TABLE F$kli_vxcf"."_ezak MODIFY ez_id int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ezak MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

//Tabulka ezak
$sql = "SELECT * FROM $kdewebs"."ezak";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Vytvorit tabulku ezak!"."<br />";
$sql = "
(
   ez_id       int not null auto_increment,
   ez_meno     VARCHAR(20),
   ez_heslo    VARCHAR(20),
   ez_ico      INT(10),
   ez_tel      VARCHAR(30),
   ez_ema      VARCHAR(30),
   ez_kto      VARCHAR(30),
   datm        TIMESTAMP(14),
   PRIMARY KEY(ez_id)
)";

$sqlttt="CREATE TABLE $kdewebs"."ezak ".$sql;
$vysledek = mysql_query("$sqlttt");
if ($vysledek)
      echo "Tabulka ezak vytvorena."."<br />";
}
//koniec tabulky ezak


//uprava ezak
$sql = "SELECT cuid FROM $kdewebs"."ezak ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE $kdewebs"."ezak ADD cxx1 DECIMAL(4,0) DEFAULT 0 AFTER ez_kto ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD cxx2 DECIMAL(4,0) DEFAULT 0 AFTER ez_kto ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD cskl DECIMAL(4,0) DEFAULT 0 AFTER ez_kto ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD ccen DECIMAL(4,0) DEFAULT 0 AFTER ez_kto ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD cskf DECIMAL(4,0) DEFAULT 0 AFTER cxx1 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD cskp DECIMAL(4,0) DEFAULT 0 AFTER cxx1 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD cuid DECIMAL(4,0) DEFAULT 0 AFTER cxx1 ";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT imei FROM $kdewebs"."ezak ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE $kdewebs"."ezak ADD gpsla VARCHAR(25) NOT NULL AFTER cxx2 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD gpslo VARCHAR(25) NOT NULL AFTER cxx2 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $kdewebs"."ezak ADD imei VARCHAR(25) NOT NULL AFTER cxx2 ";
$vysledek = mysql_query("$sql");
}
//koniec uprava tabulka ezak

$uloz="NO";
$zmaz="NO";
$uprav="NO";
// 5=ulozenie polozky do databazy nahratej v ezak.php
// 6=vymazanie polozky potvrdene v ezak.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_ezid = strip_tags($_REQUEST['cislo_ezid']);
//ulozenie novej
if ( $copern == 15 )
    {

$uloztt = "INSERT INTO $kdewebs"."ezak".
" ( ez_meno,ez_heslo,ez_ico,ez_tel,ez_ema,ez_kto )".
" VALUES ( '$ez_meno', '$ez_heslo', '$ez_ico', '$ez_tel', '$ez_ema', ".
"  '$ez_kto' ) "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$ulozttt = "UPDATE $kdewebs"."ezak SET ez_id=ez_id+1000 WHERE ez_id < 1000 ";
$ulozttx = mysql_query("$ulozttt"); 

$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA ID SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazttt = "DELETE FROM $kdewebs"."ezak WHERE ez_id='$cislo_ezid'"; 
$zmazane = mysql_query("$zmazttt"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA ID BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$cislo_ezid = strip_tags($_REQUEST['cislo_ezid']);

$upravttt = "UPDATE $kdewebs"."ezak SET ez_meno='$ez_meno', ez_heslo='$ez_heslo',
 ez_ico='$ez_ico', ez_ema='$ez_ema', ez_kto='$ez_kto', ez_tel='$ez_tel', ccen='$ccen', cskl='$cskl', cskp='$cskp', cskf='$cskf', cuid='$cuid', cxx1='$cxx1'
 , imei='$imei' WHERE ez_id='$cislo_ezid'";
  
$upravene = mysql_query("$upravttt"); 

$copern=1;
$cislo_ezid = $ez_id;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA ez_id:$cislo_ezid UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_ezid = strip_tags($_REQUEST['ez_id']);
  }
//6=uprava
if ( $copern == 6 )
  {
$cislo_ezid = strip_tags($_REQUEST['cislo_ezid']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>E-z·kaznÌci</title>
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
    document.formhl1.hladaj_ezkto.focus();
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
    document.formv1.ez_id.value = <?php echo "$ez_id";?>;
    document.formv1.ez_meno.value = '<?php echo "$ez_meno";?>';
    document.formv1.ez_heslo.value = '<?php echo "$ez_heslo";?>';
    document.formv1.ez_ico.value = '<?php echo "$ez_ico";?>';
    document.formv1.ez_ema.value = '<?php echo "$ez_ema";?>';
    document.formv1.ez_kto.value = '<?php echo "$ez_kto";?>';
    document.formv1.ez_tel.value = '<?php echo "$ez_tel";?>';
    document.formv1.ccen.value = '<?php echo "$ccen";?>';
    document.formv1.cskl.value = '<?php echo "$cskl";?>';
    document.formv1.cskp.value = '<?php echo "$cskp";?>';
    document.formv1.cskf.value = '<?php echo "$cskf";?>';
    document.formv1.cuid.value = '<?php echo "$cuid";?>';
    document.formv1.cxx1.value = '<?php echo "$cxx1";?>';
    document.formv1.imei.value = '<?php echo "$imei";?>';
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
    document.formv1.ez_kto.focus();
    document.formv1.ez_kto.select();
    document.formv1.ez_id.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.ez_tel.value == '' ) okvstup=0;
    if ( document.formv1.ez_ema.value == '' ) okvstup=0;
    if ( document.formv1.ez_meno.value == '' ) okvstup=0;
    if ( document.formv1.ez_heslo.value == '' ) okvstup=0;
    if ( document.formv1.ez_kto.value == '' ) okvstup=0;
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
$pols = 5;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  »ÌselnÌk E-z·kaznÌkov
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>

</td>
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
$sql = mysql_query("SELECT * FROM $kdewebs"."ezak ORDER BY ez_id");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_ezkto = strip_tags($_REQUEST['hladaj_ezkto']);
$hladaj_eztel = strip_tags($_REQUEST['hladaj_eztel']);
$hladaj_ezema = strip_tags($_REQUEST['hladaj_ezema']);
$hladaj_ezid = strip_tags($_REQUEST['hladaj_ezid']);

if ( $hladaj_ezema != "" ) $sql = mysql_query("SELECT * FROM $kdewebs"."ezak WHERE ( ez_ema LIKE '%$hladaj_ezema%' ) ORDER BY ez_id");
if ( $hladaj_eztel != "" ) $sql = mysql_query("SELECT * FROM $kdewebs"."ezak WHERE ( ez_tel LIKE '%$hladaj_eztel%' ) ORDER BY ez_id");
if ( $hladaj_ezkto != "" ) $sql = mysql_query("SELECT * FROM $kdewebs"."ezak WHERE ( ez_kto LIKE '%$hladaj_ezkto%' ) ORDER BY ez_id");
if ( $hladaj_ezid != "" ) $sql = mysql_query("SELECT * FROM $kdewebs"."ezak WHERE ( ez_id = '$hladaj_ezid' ) ORDER BY ez_id");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM $kdewebs"."ezak WHERE NOT ( ez_id='$cislo_ezid' ) ORDER BY ez_id");
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
<FORM name="formhl1" class="hmenu" method="post" action="ezak.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_ezid" id="hladaj_ezid" size="11" value="<?php echo $hladaj_ezid;?>" />
<td class="hmenu"><input type="text" name="hladaj_ezkto" id="hladaj_ezkto" size="30" value="<?php echo $hladaj_ezkto;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_eztel" id="hladaj_eztel" size="30" value="<?php echo $hladaj_eztel;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_ezema" id="hladaj_ezema" size="30" value="<?php echo $hladaj_ezema;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="ezak.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">ID<th class="hmenu">CelÈ meno<th class="hmenu">TelefÛn<th class="hmenu">Email
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
<td class="fmenu" width="10%" ><?php echo $riadok->ez_id;?></td>
<td class="fmenu" width="30%" ><?php echo $riadok->ez_kto;?></td>
<td class="fmenu" width="25%" ><?php echo $riadok->ez_tel;?></td>
<td class="fmenu" width="25%" ><?php echo $riadok->ez_ema;?></td>
<td class="fmenu" width="5%" ><a href='ezak.php?copern=8&page=<?php echo $page;?>&cislo_ezid=<?php echo $riadok->ez_id;?>
&ez_id=<?php echo $riadok->ez_id;?>&ez_meno=<?php echo $riadok->ez_meno;?>&ez_heslo=<?php echo $riadok->ez_heslo;?>
&ez_ico=<?php echo $riadok->ez_ico;?>&ez_ema=<?php echo $riadok->ez_ema;?>&ez_kto=<?php echo $riadok->ez_kto;?>
&ez_tel=<?php echo $riadok->ez_tel;?>&ccen=<?php echo $riadok->ccen;?>&cskl=<?php echo $riadok->cskl;?>
&cskp=<?php echo $riadok->cskp;?>&cskf=<?php echo $riadok->cskf;?>&cuid=<?php echo $riadok->cuid;?>&cxx1=<?php echo $riadok->cxx1;?>
&imei=<?php echo $riadok->imei;?>'>
 <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='ezak.php?copern=6&page=<?php echo $page;?>&cislo_ezid=<?php echo $riadok->ez_id;?>'>Zmaû</a></td>
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
$cislo_ezid = strip_tags($_REQUEST['cislo_ezid']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM $kdewebs"."ezak WHERE ez_id='$cislo_ezid'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["ez_id"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["ez_kto"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["ez_tel"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["ez_ema"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="ezak.php?page=<?php echo $page;?>&copern=16>&cislo_ezid=<?php echo $cislo_ezid;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="ezak.php?page=<?php echo $page;?>&copern=1" >
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
 »Ìslo musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo  musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parametre I»O musia byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka ID spr·vne uloûen·</span>
</tr>
<tr>

<FORM name="formv1" class="obyc" method="post" action="ezak.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_ezid=$cislo_ezid"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">
<input type="text" name="ez_id" id="ez_id" 
onchange="return intg(this,1,99999999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />*</td>

<td class="fmenu" width="30%">
<input type="text" name="ez_kto" id="ez_kto" />*</td>

<td class="fmenu" width="25%">
<input type="text" name="ez_tel" id="ez_tel" />*</td>

<td class="fmenu" width="25%">
<input type="text" name="ez_ema" id="ez_ema" />*</td>

<td class="fmenu" width="5%"></td>
<td class="fmenu" width="5%"></td>
<tr></tr>
<tr>
<td class="fmenu">LogMeno:</td>
<td class="fmenu">LogHeslo:</td>
<td class="fmenu">I»O / Odb.miesto:</td>
<td class="fmenu">Ë.UûÌvateæa ID:</td>
</tr>

<tr>
<td class="fmenu"><input type="text" name="ez_meno" id="ez_meno" />*</td>
<td class="fmenu"><input type="text" name="ez_heslo" id="ez_heslo" />*</td>
<td class="fmenu"><input type="text" name="ez_ico" id="ez_ico" /> / <input type="text" name="cxx1" id="cxx1" /> </td>
<td class="fmenu"><input type="text" name="cuid" id="cuid" /></td>
</tr>
<tr></tr>

<tr></tr>
<tr>
<td class="fmenu">Ë.CennÌka:</td>
<td class="fmenu">Ë.Hl.skladu:</td>
<td class="fmenu">Ë.Pr.skladu/Firma</td>
<td class="fmenu">IMEI termin·lu</td>
</tr>

<tr>
<td class="fmenu"><input type="text" name="ccen" id="ccen" /></td>
<td class="fmenu"><input type="text" name="cskl" id="cskl" /></td>
<td class="fmenu"><input type="text" name="cskp" id="cskp" /> / <input type="text" name="cskf" id="cskf" /></td>
<td class="fmenu"><input type="text" name="imei" id="imei" /></td>
</tr>
<tr></tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="ezak.php?page=<?php echo $page;?>&copern=1" >
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
 Poloûka ID zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka ID upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="ezak.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ezid=$hladaj_ezid&hladaj_ezkto=$hladaj_ezkto&hladaj_eztel=$hladaj_eztel&hladaj_ezema=$hladaj_ezema";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="ezak.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ezid=$hladaj_ezid&hladaj_ezkto=$hladaj_ezkto&hladaj_eztel=$hladaj_eztel&hladaj_ezema=$hladaj_ezema";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="ezak.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="ezak.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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
       } while (false);
?>
</BODY>
</HTML>
