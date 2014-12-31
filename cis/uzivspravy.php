<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 5000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$databaza="";
$dtb2 = include("oddel_dtbz3.php");


$spravy="spravy";
$firspr = 1*$_REQUEST['firspr'];
if( $firspr == 1 ) { $spravy="F".$kli_vxcf."_uzivspravy"; }



//urob texty bez diakritiky
$xxdd=0;
if( $xxdd == 1 )
 {

$sqlttt = "SELECT * FROM ".$databaza."$spravy WHERE cpt > 0 ORDER BY cpt ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;


if( $cpol >= 1 )
               {

while ($i < $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);

$txxbez = StrTr($riadok->txx, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ndpbez = StrTr($riadok->ndp, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$poletxx = explode("<a", $txxbez);
$txxbezaa=$poletxx[0];


$dsqlt = "UPDATE ".$databaza."$spravy SET txxbez='$txxbezaa', ndpbez='$ndpbez' WHERE cpt = $riadok->cpt ";
echo $dsqlt;
$dsql = mysql_query("$dsqlt");

    }
$i=$i+1;
}

//if( $cpol >= 1 )
               }

 }
//koniec urob texty bez diakritiky

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//spravy pre uzivatelov
$sql = "SELECT ndp FROM ".$databaza."$spravy ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "DROP TABLE ".$databaza."$spravy";
$vysledek = mysql_query("$sql");

$sqlt = <<<vtvmzd
(
   cpt         int not null auto_increment,
   drh         DECIMAL(4,0) DEFAULT 0,
   prm         DECIMAL(4,0) DEFAULT 0,
   dat         DATE,
   ndp         VARCHAR(100),
   rd1         VARCHAR(100),
   rd2         VARCHAR(100),
   rd3         VARCHAR(100),
   rd4         VARCHAR(100),
   rd5         VARCHAR(100),
   rd6         VARCHAR(100),
   rd7         VARCHAR(100),
   txx         TEXT,
   PRIMARY KEY(cpt)
);
vtvmzd;

$sql = "CREATE TABLE ".$databaza."$spravy".$sqlt;
$vysledek = mysql_query("$sql");

}
//koniec spravy pre uzivatelov

$sql = "ALTER TABLE ".$databaza."$spravy MODIFY ndp VARCHAR(150) ";
$vysledek = mysql_query("$sql");

$sql = "SELECT ndpbez FROM ".$databaza."$spravy ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE ".$databaza."$spravy ADD txxbez TEXT AFTER txx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$databaza."$spravy ADD ndpbez VARCHAR(150) AFTER ndp";
$vysledek = mysql_query("$sql");

}


// 5=ulozenie polozky do databazy nahratej v uzivspravy.php
// 6=vymazanie polozky potvrdene v uzivspravy.php
if ( $copern == 15 || $copern == 16 )
     {
$h_cpt = strip_tags($_REQUEST['h_cpt']);
//$h_txx = htmlspecialchars($_REQUEST['h_txx']);
$h_txx = $_REQUEST['h_txx'];
//$h_txx64=urlencode($h_txx);
$h_drh = strip_tags($_REQUEST['h_drh']);
$h_prm = strip_tags($_REQUEST['h_prm']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_datsql=SqlDatum($h_dat);
$h_ndp = strip_tags($_REQUEST['h_ndp']);
$h_rd1 = strip_tags($_REQUEST['h_rd1']);
$h_rd2 = strip_tags($_REQUEST['h_rd2']);
$h_rd3 = strip_tags($_REQUEST['h_rd3']);
$h_rd4 = strip_tags($_REQUEST['h_rd4']);
$h_rd5 = strip_tags($_REQUEST['h_rd5']);
$h_rd6 = strip_tags($_REQUEST['h_rd6']);

$cislo_cpt = strip_tags($_REQUEST['cislo_cpt']);
//ulozenie novej
if ( $copern == 15 )
    {
$txxbez = StrTr($h_txx, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ndpbez = StrTr($h_ndp, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$poletxx = explode("<a", $txxbez);
$txxbezaa=$poletxx[0];

$ulozttt = "INSERT INTO ".$databaza."$spravy ( ndp,ndpbez,rd1,rd2,rd3,rd4,rd5,rd6,drh,dat,txx,txxbez ) VALUES ".
" ( '$h_ndp','$ndpbez', '$h_rd1', '$h_rd2', '$h_rd3', '$h_rd4', '$h_rd5', '$h_rd6', $h_drh, '$h_datsql', '$h_txx', '$txxbezaa' ); "; 

$ulozene = mysql_query("$ulozttt"); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA cpt:$h_cpt SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM ".$databaza."$spravy WHERE cpt='$cislo_cpt'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA cpt:$cislo_cpt BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$h_cpt = strip_tags($_REQUEST['h_cpt']);
//$h_txx = htmlspecialchars($_REQUEST['h_txx']);
//$h_txx64=urlencode($h_txx);
$h_txx = $_REQUEST['h_txx'];
$h_drh = strip_tags($_REQUEST['h_drh']);
$h_prm = strip_tags($_REQUEST['h_prm']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_datsql=SqlDatum($h_dat);
$h_ndp = strip_tags($_REQUEST['h_ndp']);
$h_rd1 = strip_tags($_REQUEST['h_rd1']);
$h_rd2 = strip_tags($_REQUEST['h_rd2']);
$h_rd3 = strip_tags($_REQUEST['h_rd3']);
$h_rd4 = strip_tags($_REQUEST['h_rd4']);
$h_rd5 = strip_tags($_REQUEST['h_rd5']);
$h_rd6 = strip_tags($_REQUEST['h_rd6']);

$cislo_cpt = strip_tags($_REQUEST['cislo_cpt']);

$txxbez = StrTr($h_txx, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ndpbez = StrTr($h_ndp, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$upravene = mysql_query("UPDATE ".$databaza."$spravy SET  ndp='$h_ndp', drh='$h_drh', ".
" rd1='$h_rd1', rd2='$h_rd2', rd3='$h_rd3', rd4='$h_rd4', rd5='$h_rd5', rd6='$h_rd6', dat='$h_datsql', txx='$h_txx', txxbez='$txxbez', ndpbez='$ndpbez' WHERE cpt='$cislo_cpt'");  
$copern=1;
$cislo_cpt = $h_cpt;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA cpt:$cislo_cpt UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_cpt = strip_tags($_REQUEST['h_cpt']);
$cislo_cpt = strip_tags($_REQUEST['h_cpt']);

$sqltt = "SELECT * FROM ".$databaza."$spravy WHERE cpt = $cislo_cpt ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_cpt = $riadok->cpt;
$h_ndp = $riadok->ndp;
$h_rd1 = $riadok->rd1;
$h_rd2 = $riadok->rd2;
$h_rd3 = $riadok->rd3;
$h_rd4 = $riadok->rd4;
$h_rd5 = $riadok->rd5;
$h_rd6 = $riadok->rd6;
$h_drh = $riadok->drh;
$h_prm = $riadok->prm;
$h_datsk = SkDatum($riadok->dat);
$h_txx = $riadok->txx;
  }
       }
//koniec uprava nacitanie

//6=uprava
if ( $copern == 6 )
  {
$cislo_cpt = strip_tags($_REQUEST['cislo_cpt']);
  }



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Spr·vy</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">


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
    document.formhl1.hladaj_txx.focus();
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
    document.formv1.h_drh.value = '<?php echo "$h_drh";?>';
    document.formv1.h_ndp.value = '<?php echo "$h_ndp";?>';
    document.formv1.h_dat.value = '<?php echo "$h_datsk";?>';

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
    document.formv1.h_txx.focus();
    document.formv1.h_txx.select();

    <?php if( $_SESSION['ipad'] == 0 AND $_SESSION['iphone'] == 0 AND $_SESSION['android'] == 0  ) { echo "document.formv1.uloz.disabled = true;"; } ?>

    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_txx.value == '' ) okvstup=0;
    if ( document.formv1.h_drh.value == '' ) okvstup=0;
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
<td>EuroSecom  -  
<?php if( $firspr == 0 ) { echo "Spr·vy pre uûÌvateæov, tipy, triky"; } ?>
<?php if( $firspr == 1 ) { echo "FiremnÈ novinky, spr·vy pre uûÌvateæov"; } ?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sqlttt = "SELECT * FROM ".$databaza."$spravy ORDER BY dat DESC";
if( $copern == 5 OR $copern == 8 ) { $sqlttt = "SELECT * FROM ".$databaza."$spravy ORDER BY dat DESC limit 3"; }
//echo $sqlttt;
//echo $copern;
$sql = mysql_query("$sqlttt");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_txx = strip_tags($_REQUEST['hladaj_txx']);
$hladaj_cpt = strip_tags($_REQUEST['hladaj_cpt']);

if ( $hladaj_txx != "" ) $sql = mysql_query("SELECT * FROM ".$databaza."$spravy WHERE ( ndp LIKE '%$hladaj_txx%' ) ORDER BY dat DESC");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM ".$databaza."$spravy WHERE NOT ( cpt='$cislo_cpt' ) ORDER BY dat DESC limit 3");
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
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="5%" >
<th class="hmenu" width="5%" >
</tr>

<tr>
<FORM name="formhl1" class="hmenu" method="post" action="uzivspravy.php?page=1&copern=9&firspr=<?php echo $firspr; ?>" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu" colspan="4"><input type="text" name="hladaj_txx" id="hladaj_txx" size="80" value="<?php echo $hladaj_txx;?>" /> 
<td class="obyc" align="left" colspan="1"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="uzivspravy.php?page=1&copern=1&firspr=<?php echo $firspr; ?>" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<td class="hmenu" colspan="1">D·tum
<td class="hmenu" colspan="1">Druh
 <img src='../obr/info.png' width=10 height=10 border=0
 alt="Poloûka Druh 1=All, 2=Ucto, 
 3=Mzdy, 4=HIM, 5=ostatnÈ 
 ">
<td class="hmenu" colspan="6">Nadpis
<td class="hmenu" colspan="1">Uprav
<td class="hmenu" colspan="1">Zmaû
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
<td class="fmenu" colspan="1"><?php echo $riadok->dat;?></td>
<td class="fmenu" colspan="1"><?php echo $riadok->drh;?></td>
<td class="fmenu" colspan="6"> Ë.<?php echo $riadok->cpt;?> - <?php echo $riadok->ndp;?></td>

<td class="fmenu" colspan="1"><a href='uzivspravy.php?copern=8&page=<?php echo $page;?>&cislo_cpt=<?php echo $riadok->cpt;?>
&h_cpt=<?php echo $riadok->cpt;?>&firspr=<?php echo $firspr; ?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" colspan="1"><a href='uzivspravy.php?copern=6&page=<?php echo $page;?>&cislo_cpt=<?php echo $riadok->cpt;?>
&firspr=<?php echo $firspr; ?>'>Zmaû</a></td>
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
$h_cpt = strip_tags($_REQUEST['h_cpt']);
$h_txx = strip_tags($_REQUEST['h_txx']);
$h_drh = strip_tags($_REQUEST['h_drh']);
$h_prm = strip_tags($_REQUEST['h_prm']);

$cislo_cpt = strip_tags($_REQUEST['cislo_cpt']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM ".$databaza."$spravy WHERE cpt='$cislo_cpt'";
$sql = mysql_query("$sqlp");
?>
<tr>
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="5%" >
<th class="hmenu" width="5%" >
</tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" colspan="1"><?php echo $zaznam["dat"];?></td>
<td class="fmenu" colspan="1"><?php echo $zaznam["drh"];?></td>
<td class="fmenu" colspan="6"> Ë.<?php echo $zaznam["cpt"];?> - <?php echo $zaznam["ndp"];?></td>


<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="uzivspravy.php?page=<?php echo $page;?>&copern=16>&cislo_cpt=<?php echo $cislo_cpt;?>
&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>&firspr=<?php echo $firspr; ?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="uzivspravy.php?page=<?php echo $page;?>&copern=1&firspr=<?php echo $firspr; ?>" >
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
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="10%" >
<td class="hmenu" width="5%" >
<th class="hmenu" width="5%" >
</tr>

<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù celÈ ËÌslo </span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka cpt=<?php echo $h_cpt;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="uzivspravy.php?page=<?php echo $page;?>&firspr=<?php echo $firspr; ?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cpt=$cislo_cpt"; } ?>
" >


<td class="fmenu" colspan="1"><input type="text" name="h_dat" id="h_dat" size="10" onclick="Fx.style.display='none';" /></td>

<td class="fmenu" colspan="1"><input type="text" name="h_drh" id="h_drh" size="5" onclick="Fx.style.display='none';" /></td>

<td class="fmenu" colspan="7"> Ë.<?php echo $cislo_cpt;?> - <input type="text" name="h_ndp" id="h_ndp" size="100" onclick="Fx.style.display='none';" />

</tr>

<tr>
<td class="fmenu" colspan="8">
<?php
if( $copern == 8 AND $firspr == 1 )
{
?>
1<a href='uzivspravy_s.php?copern=331&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku JPG,PNG Ë.1 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
2<a href='uzivspravy_s.php?copern=332&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku JPG,PNG Ë.2 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
3<a href='uzivspravy_s.php?copern=333&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku JPG,PNG Ë.3 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
4<a href='uzivspravy_s.php?copern=334&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku JPG,PNG Ë.4 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
5<a href='uzivspravy_s.php?copern=335&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obr·zku JPG,PNG Ë.5 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
1<a href='uzivspravy_s.php?copern=431&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/pdf.png' width=15 height=10 border=0 title="Uloûenie dokumentu PDF1 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
2<a href='uzivspravy_s.php?copern=432&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/pdf.png' width=15 height=10 border=0 title="Uloûenie dokumentu PDF2 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
3<a href='uzivspravy_s.php?copern=433&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/pdf.png' width=15 height=10 border=0 title="Uloûenie dokumentu PDF3 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
4<a href='uzivspravy_s.php?copern=434&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/pdf.png' width=15 height=10 border=0 title="Uloûenie dokumentu PDF4 do datab·zy" ></a>
&nbsp;&nbsp;&nbsp;
5<a href='uzivspravy_s.php?copern=435&drupoh=1&page=1&cislo_dok=<?php echo $cislo_cpt;?>' target="_blank"><img src='../obr/pdf.png' width=15 height=10 border=0 title="Uloûenie dokumentu PDF5 do datab·zy" ></a>

<?php
}
?>

<textarea name="h_txx" id="h_txx" rows="15" cols="100" onclick="Fx.style.display='none';">
<?php if( $copern == 8 )
{
?>
<?php echo $h_txx; ?>
<?php
}
?>
</textarea>
</td>
</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="uzivspravy.php?page=<?php echo $page;?>&copern=1&firspr=<?php echo $firspr; ?>" >
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
 Poloûka cpt=<?php echo $cislo_cpt;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka cpt=<?php echo $cislo_cpt;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="uzivspravy.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cpt=$hladaj_cpt&hladaj_txx=$hladaj_txx";
}
?>
&page=<?php echo $ppage;?>&firspr=<?php echo $firspr; ?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="uzivspravy.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_cpt=$hladaj_cpt&hladaj_txx=$hladaj_txx";
}
?>
&page=<?php echo $npage;?>&firspr=<?php echo $firspr; ?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="uzivspravy.php?copern=4&firspr=<?php echo $firspr; ?>" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="uzivspravy.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>&firspr=<?php echo $firspr; ?>" >
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
?>

<?php

//echo htmlspecialchars_decode(urldecode($h_txx)); 

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
