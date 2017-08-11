<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$cislo_obdobie = 1*$_REQUEST['cislo_obdobie'];
if( $cislo_obdobie == 0 ) $cislo_obdobie = 1;


// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

// zmenit hodnotu
if ( $copern == 618 )
    {

$n_hod = 1*$_REQUEST['n_hod'];
$s_hod = 1*$_REQUEST['s_hod'];
$konx1 = 1*$_REQUEST['konx1'];
$dmx = 1*$_REQUEST['dmx'];

if( $konx1 == 30 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_mzdzalvy SET kc='$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok AND dm = $dmx ";
}
if( $konx1 == 20 )
{
$uprtx2 = "UPDATE F$kli_vxcf"."_mzdzalsum SET sum_hod=sum_hod-'$s_hod'+'$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok ";
if( $dmx >= 101 AND $dmx <= 599 ) { $upraven2 = mysql_query("$uprtx2"); }

$uprtxt = "UPDATE F$kli_vxcf"."_mzdzalvy SET hod='$n_hod', cel_hod='$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok AND dm = $dmx ";
}
if( $konx1 == 10 )
{
$uprtx2 = "UPDATE F$kli_vxcf"."_mzdzalsum SET sum_dni=sum_dni-'$s_hod'+'$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok ";
if( $dmx >= 101 AND $dmx <= 599 ) { $upraven2 = mysql_query("$uprtx2"); }

$uprtxt = "UPDATE F$kli_vxcf"."_mzdzalvy SET dni='$n_hod', cel_dni='$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok AND dm = $dmx ";
}

$upravene = mysql_query("$uprtxt"); 
//echo $uprtxt; 
//exit;


$copern=101;

?>
<script type="text/javascript">
  var okno = window.open("../mzdy/mzdevid.php?cislo_oc=<?php echo $cislo_oc; ?>&cislo_obdobie=<?php echo $cislo_obdobie; ?>&copern=10&drupoh=1&page=1&oprava=1","_self");
</script>
<?php
    }
//koniec zmenit hodnotu


// zmenit druh
if ( $copern == 718 )
    {

$n_hod = 1*$_REQUEST['n_hod'];
$konx1 = 1*$_REQUEST['konx1'];
$dmx = 1*$_REQUEST['dmx'];

if( $konx1 == 30 AND $n_hod > 0 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_mzdzalvy SET dm='$n_hod' WHERE oc = $cislo_oc AND ume = $cislo_obdobie."."$kli_vrok AND dm = $dmx ";
}


//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=101;


?>
<script type="text/javascript">
  var okno = window.open("../mzdy/mzdevid.php?cislo_oc=<?php echo $cislo_oc; ?>&cislo_obdobie=<?php echo $cislo_obdobie; ?>&copern=10&drupoh=1&page=1&oprava=1","_self");
</script>
<?php

    }
//koniec zmenit druh


// zapis upravene udaje strana 2
if ( $copern == 103 )
    {

$oc = strip_tags($_REQUEST['oc']);

$r01a = strip_tags($_REQUEST['r01a']);
$r01c = strip_tags($_REQUEST['r01c']);
$r01b = strip_tags($_REQUEST['r01b']);
$tz1 = strip_tags($_REQUEST['tz1']);
$ra1a = strip_tags($_REQUEST['ra1a']);

$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_mzdrocnehlaseniedaneoc SET ".
" r01a='$r01a', r01b='$r01b', r01c='$r01c', ra1a='$ra1a', tz1='$tz1' ".
" WHERE oc = $oc"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=101;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 2


//nacitaj udaje zamestnanca
if ( $copern > 100 )
    {

$oc = 1*strip_tags($_REQUEST['oc']);


$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdkun ".
" WHERE oc = $oc ORDER BY oc";

//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$prie = $fir_riadok->prie;
$meno = $fir_riadok->meno;


mysql_free_result($fir_vysledok);

    }
//koniec nacitania zamestnanca


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Oprava mzdovÈho listu</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

 div.strana {
  padding-left:8;
  font-weight:bold;
  background-color:#ffff90;
  cursor:pointer;
}

 div.nekliknute {
  padding-left:8;
  font-weight:normal;
  background-color:#ffff90;
  cursor:pointer;
}

 div.kliknute {
  padding-left:8;
  font-weight:bold;
  background-color:lightgreen;
  cursor:pointer;
}

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


<?php
//uprava sadzby strana 2
  if ( $copern == 102 )
  { 
?>
    function ObnovUI()
    {


    document.formv1.r01a.value = '<?php echo "$r01a";?>';
    document.formv1.r01c.value = '<?php echo "$r01c";?>';
    document.formv1.r01b.value = '<?php echo "$r01b";?>';
    document.formv1.tz1.value = '<?php echo "$tz1";?>';
    document.formv1.ra1a.value = '<?php echo "$ra1a";?>';


    }
<?php
//koniec uprava
  }
?>

<?php
//nie uprava
  if ( $copern != 2 AND $copern != 102 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>




</script>



</HEAD>
<BODY class="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Oprava mzdovÈho listu</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//zobraz nastavene udaje strana 2
if ( $copern == 101 OR $copern == 103 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>


<?php

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzddmn".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm=F$kli_vxcf"."_mzddmn.dm".
" WHERE F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc = $cislo_oc  ORDER BY konx1,F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".dm";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
$j = 0;
?>


<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$r01=$riadok->r01;
if( $riadok->r01 == 0 ) $r01="";
$r02=$riadok->r02;
if( $riadok->r02 == 0 ) $r02="";
$r03=$riadok->r03;
if( $riadok->r03 == 0 ) $r03="";
$r04=$riadok->r04;
if( $riadok->r04 == 0 ) $r04="";
$r05=$riadok->r05;
if( $riadok->r05 == 0 ) $r05="";
$r06=$riadok->r06;
if( $riadok->r06 == 0 ) $r06="";
$r07=$riadok->r07;
if( $riadok->r07 == 0 ) $r07="";
$r08=$riadok->r08;
if( $riadok->r08 == 0 ) $r08="";
$r09=$riadok->r09;
if( $riadok->r09 == 0 ) $r09="";
$r10=$riadok->r10;
if( $riadok->r10 == 0 ) $r10="";
$r11=$riadok->r11;
if( $riadok->r11 == 0 ) $r11="";
$r12=$riadok->r12;
if( $riadok->r12 == 0 ) $r12="";

if( $cislo_obdobie == 1 ) $hodnota=$r01;
if( $cislo_obdobie == 2 ) $hodnota=$r02;
if( $cislo_obdobie == 3 ) $hodnota=$r03;
if( $cislo_obdobie == 4 ) $hodnota=$r04;
if( $cislo_obdobie == 5 ) $hodnota=$r05;
if( $cislo_obdobie == 6 ) $hodnota=$r06;
if( $cislo_obdobie == 7 ) $hodnota=$r07;
if( $cislo_obdobie == 8 ) $hodnota=$r08;
if( $cislo_obdobie == 9 ) $hodnota=$r09;
if( $cislo_obdobie == 10 ) $hodnota=$r10;
if( $cislo_obdobie == 11 ) $hodnota=$r11;
if( $cislo_obdobie == 12 ) $hodnota=$r12;

//hlavicka
if( $j == 0 )
     {
?>


<tr><td class="hmenu" colspan="10" align="center" >MZDOV› LIST</td></tr>
<tr><td class="pvstuz" colspan="10" align="center" > </td></tr>
<tr><td class="hmenu" colspan="4" align="left" >Zamestnanec osË: <?php echo $riadok->oc;?> 
 <?php echo $riadok->titl;?> <?php echo $riadok->meno;?> <?php echo $riadok->prie;?>  Pracovn˝ pomer:<?php echo $riadok->pom;?></td>

<td class="hmenu" colspan="2" >
<?php
$novy=0;
if( $novy == 0 )
{
$prev_oc=$cislo_oc-1; 
$next_oc=$cislo_oc+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$ix=0;
while ($ix <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$ix))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if( $prev_oc <= 1 ) $nasieloc=1;
}
$ix=$ix+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1"); 
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }

if( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$ix=0;
while ($ix <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$ix))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $next_oc=$next_oc+1;
if( $next_oc >= 9999 ) $nasieloc=1;
}
$ix=$ix+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;
?>
<a href="#" onClick="window.open('../mzdy/mzdevid.php?cislo_oc=<?php echo $prev_oc;?>&copern=10&drupoh=1&page=1&oprava=1', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Zamestnanec osË <?php echo $prev_oc; ?>' ></a>
<a href="#" onClick="window.open('../mzdy/mzdevid.php?cislo_oc=<?php echo $next_oc;?>&copern=10&drupoh=1&page=1&oprava=1', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Zamestnanec osË <?php echo $next_oc; ?>' ></a>
<?php
}
//koniec novy=0
?>

</tr>
<tr><td class="pvstuz" colspan="10" align="center" > </td></tr>
<tr>
<td class="hmenu" colspan="3" >Obdobie: </td>
<td class="hmenu" colspan="1" align="right" ><?php echo $cislo_obdobie;?>.<?php echo $kli_vrok;?>
<td class="hmenu" colspan="2" >

<?php
$prev_obd=$cislo_obdobie-1; 
$next_obd=$cislo_obdobie+1;

if( $prev_obd == 0 ) $prev_obd=12;
if( $next_obd >= 12 ) $next_obd=1;

?>

<a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=<?php echo $prev_obd;?>', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Obdobie <?php echo $prev_obd; ?>.<?php echo $kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=<?php echo $next_obd;?>', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Obdobie <?php echo $next_obd; ?>.<?php echo $kli_vrok; ?>' ></a>

<td class="hmenu" colspan="4" >
 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 1</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=2', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 2</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=3', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 3</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=4', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 4</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=5', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 5</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=6', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 6</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=7', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 7</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=8', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 8</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=9', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 9</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=10', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 10</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=11', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 11</a> 

 <a href="#" onClick="window.open('mzdlist_oprava.php?copern=101&cislo_oc=<?php echo $riadok->oc;?>&cislo_obdobie=12', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"> 12</a> 






</tr>
<tr><td class="pvstuz" colspan="10" align="center" > </td></tr>

<tr>
<td class="hmenu" colspan="3" >Poloûka</td>
<td class="hmenu" colspan="1" align="right" >Hodnota</td>
<td class="hmenu" colspan="6" > </td>
</tr>

<?php
     }
//koniec hlavicka

$nazovdm=$riadok->dm." ".$riadok->nzdm;
$nazovdms = substr($nazovdm,0,60);
$xdm=$riadok->dm;

//konx1=10 dni, 20 hodiny, 30 eur

if( $riadok->dmx == 10001 ) { $nazovdm="Celkom dni"; }
if( $riadok->dmx == 10101 ) { $nazovdm="Celkom hodiny"; }

if( $riadok->dmx >= 100 AND $riadok->dmx < 10000 ) { $nazovdm="$nazovdms"; }


if( $riadok->dmx == 11110 ) { $nazovdm="Hrub· mzda"; }
if( $riadok->dmx == 11120 ) { $nazovdm="V˝plata v hotovosti"; }
if( $riadok->dmx == 11130 ) { $nazovdm="V˝plata cez banku"; }
if( $riadok->dmx == 11140 ) { $nazovdm="»iastkov˝ z·kl.dane"; }
if( $riadok->dmx == 11141 ) { $nazovdm="OdpoËet na daÚovnÌka"; }
if( $riadok->dmx == 11150 ) { $nazovdm="»ist· mzda"; }
if( $riadok->dmx == 11160 ) { $nazovdm="Celkov· cena pr·ce"; }
if( $riadok->dmx == 11170 ) { $nazovdm="Odvod DDP zamtel"; }


if( $riadok->dmx == 20101 ) { $nazovdm="Z·klad ZP"; }
if( $riadok->dmx == 20102 ) { $nazovdm="Odvod ZP zamnec"; }
if( $riadok->dmx == 20201 ) { $nazovdm="Z·klad NP"; }
if( $riadok->dmx == 20202 ) { $nazovdm="Odvod NP zamnec"; }
if( $riadok->dmx == 20301 ) { $nazovdm="Z·klad SP"; }
if( $riadok->dmx == 20302 ) { $nazovdm="Odvod SP zamnec"; }
if( $riadok->dmx == 20401 ) { $nazovdm="Z·klad IP"; }
if( $riadok->dmx == 20402 ) { $nazovdm="Odvod IP zamnec"; }
if( $riadok->dmx == 20501 ) { $nazovdm="Z·klad PvN"; }
if( $riadok->dmx == 20502 ) { $nazovdm="Odvod PvN zamnec"; }


if( $riadok->dmx == 30110 ) { $nazovdm="Priemer na n·hrady Ä/hodinu"; }
if( $riadok->dmx == 30120 ) { $nazovdm="Priemer na v˝platu nemoc.n·hrad Ä/deÚ"; }

if( $riadok->dmx == 40110 ) { $nazovdm="Pracovn˝ pomer"; }
if( $riadok->dmx == 40120 ) { $nazovdm="Zdravotn· poisùovÚa"; }

$hodnotaold=$hodnota;
if( $hodnotaold == '' ) $hodnotaold=0;
?>

<FORM name='formnew' class='obyc' method='post' action='#' >

<?php

//UpravHod(0,3,1,23.00,10,101);

//UpravDmx(4,3,1,800.00,30,101);

?>

<tr>
<td class="fmenu" colspan="3" >
<?php if( $riadok->konx1 == 30 AND $riadok->dmx <= 999 ) { ?>
<div class='nekliknute' id='DM<?php echo $i; ?>' >
 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravNewDmx<?php echo $i; ?>();" 
 title='Upraviù druh poloûky' >
<?php                            } ?>
<?php echo $nazovdm;?>
<?php if( $riadok->konx1 == 30 AND $riadok->dmx <= 999 ) { ?>
</div>

<div class='kliknute' id='DMK<?php echo $i; ?>' style="display: none;">
 <img src='../obr/ok.png' width=15 height=12 border=1 
 onClick="UlozNewDmx<?php echo $i; ?>();" 
 title='Uloûiù druh poloûky' >
<input class='hvstup' type='text' name='n_hod<?php echo $i; ?>' id='n_hod<?php echo $i; ?>' size='8' onkeyup='CiarkaNaBodku(this)' value='<?php echo $xdm;?>' />

<?php                            } ?>

<?php if( $riadok->konx1 == 30 AND $riadok->dmx <= 999 ) { ?>
</div>
<?php                            } ?>

</td>

<td class="fmenu" align="right" >
<?php if( $riadok->konx1 <= 20 AND $riadok->dmx <= 999 ) { ?>
<div class='nekliknute' id='ZP<?php echo $i; ?>' >
<?php                            } ?>
<?php echo $hodnota;?>
<?php if( $riadok->konx1 <= 20 AND $riadok->dmx <= 999 ) { ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravNewHod<?php echo $i; ?>();" 
 title='Upraviù hodnotu poloûky' >
</div>

<div class='kliknute' id='ZPK<?php echo $i; ?>' style="display: none;">
<?php                            } ?>

<?php if( $riadok->konx1 <= 20 AND $riadok->dmx <= 999 ) { ?>
<input class='hvstup' type='text' name='n_hod<?php echo $i; ?>' id='n_hod<?php echo $i; ?>' size='8' onkeyup='CiarkaNaBodku(this)' value='<?php echo $hodnota;?>' />

 <img src='../obr/ok.png' width=15 height=12 border=1 
 onClick="UlozNewHod<?php echo $i; ?>();" 
 title='Uloûiù hodnotu poloûky' >
</div>
<?php                            } ?>

</td>
<td class="hmenu" align="right" > </td>


</tr>
<script type="text/javascript">

function UpravNewHod<?php echo $i; ?>()
                {
ZP<?php echo $i; ?>.style.display='none';
ZPK<?php echo $i; ?>.style.display='';

                }

function UlozNewHod<?php echo $i; ?>()
                {

var n_hod = document.forms.formnew.n_hod<?php echo $i; ?>.value;

window.open('mzdlist_oprava.php?copern=618&cislo_oc=<?php echo $cislo_oc;?>&cislo_obdobie=<?php echo $cislo_obdobie;?>&s_hod=<?php echo $hodnota;?>&n_hod=' + n_hod + '&konx1=<?php echo $riadok->konx1;?>&dmx=<?php echo $riadok->dmx;?>&drupoh=1', '_self' );

                }

function UpravNewDmx<?php echo $i; ?>()
                {
DM<?php echo $i; ?>.style.display='none';
DMK<?php echo $i; ?>.style.display='';


                }

function UlozNewDmx<?php echo $i; ?>()
                {

var n_hod = document.forms.formnew.n_hod<?php echo $i; ?>.value;

window.open('mzdlist_oprava.php?copern=718&cislo_oc=<?php echo $cislo_oc;?>&cislo_obdobie=<?php echo $cislo_obdobie;?>&s_hod=<?php echo $hodnota;?>&n_hod=' + n_hod + '&konx1=<?php echo $riadok->konx1;?>&dmx=<?php echo $riadok->dmx;?>&drupoh=1', '_self' );


                }

</script>

<?php
  }
$i = $i + 1;
$j = $j + 1;
   }
?>

<tr>
<td class="bmenu" colspan="10" > </td>
</tr>

</FORM>
</table>
<?php
    }
//koniec zobrazenia udajov strana 2
?>






<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<?php
$vsql = 'DROP TABLE F'.$kli_vxcf.'_treximaprac';
$vytvor = mysql_query("$vsql");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
