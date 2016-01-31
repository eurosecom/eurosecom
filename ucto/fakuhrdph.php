<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
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

$citfir = include("../cis/citaj_fir.php");
//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_cpld = 1*$_REQUEST['cislo_cpld'];

//echo $copern;
//echo $cislo_cpld;

$h_dok = strip_tags($_REQUEST['h_dok']);
$h_dou = strip_tags($_REQUEST['h_dou']);
$h_dau = strip_tags($_REQUEST['h_dau']);
$h_dpp = strip_tags($_REQUEST['h_dpp']);
$h_hou = strip_tags($_REQUEST['h_hou']);
$h_hz2 = strip_tags($_REQUEST['h_hz2']);
$h_hd2 = strip_tags($_REQUEST['h_hd2']);
$h_hz1 = strip_tags($_REQUEST['h_hz1']);
$h_hd1 = strip_tags($_REQUEST['h_hd1']);
$h_dausql=SqlDatum($h_dau); 
$h_dppsql=SqlDatum($h_dpp); 

//datova tabulka
$sql = "SELECT dppx FROM F$kli_vxcf"."_uctfakuhrdph ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "DROP TABLE F".$kli_vxcf."_uctfakuhrdph ";
$vysledek = mysql_query("$sql");

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   dppx        DECIMAL(2,0) DEFAULT 0,
   prx7        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "CREATE TABLE F".$kli_vxcf."_uctfakuhrdph ".$sqlt;
$vysledek = mysql_query("$sql");

}
$sql = "SELECT dou FROM F$kli_vxcf"."_uctfakuhrdph ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hou DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hz1 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hd1 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hz2 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD hd2 DECIMAL(10,2) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dau DATE NOT NULL AFTER prx7 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dpp DATE NOT NULL AFTER prx7 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctfakuhrdph ADD dou DECIMAL(10,0) DEFAULT 0 AFTER prx7 ";
$vysledek = mysql_query("$sql");

}

//nacitaj uhrady
if ( $copern == 1001 OR $copern == 1002 )
    {


    }
//koniec nacitaj uhrady


//ulozenie novej
if ( $copern == 15 )
    {

$ulozttt = " INSERT INTO F$kli_vxcf"."_uctfakuhrdph ( dok,dppx,dou,dau,dpp,hou,hz1,hd1,hz2,hd2 ) ".
" VALUES ( '$cislo_dok', '$h_dppx', '$h_dou', '$h_dausql', '$h_dppsql', '$h_hou', '$h_hz1', '$h_hd1', '$h_hz2', '$h_hd2' ) "; 
$ulozene = mysql_query("$ulozttt"); 
echo $ulozttt;

$copern=1;

    }
//koniec ulozenia

//vymazanie a uprava
if ( $copern == 16 )
    {


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE cpld = $cislo_cpld ";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_dok = $riadok->dok;
$h_dou = $riadok->dou;
$h_dppx = $riadok->dppx;

$h_dok = $riadok->h_dok;
$h_dau = $riadok->h_dau;
$h_dpp = $riadok->h_dpp;
$h_hou = $riadok->h_hou;
$h_hz1 = $riadok->h_hz1;
$h_hd1 = $riadok->h_hd1;
$h_hz1 = $riadok->h_hz1;
$h_hd1 = $riadok->h_hd1;



$h_dausk=SkDatum($h_dau); 
$h_dppsk=SkDatum($h_dpp); 
  }

$zmazttt = "DELETE FROM F$kli_vxcf"."_uctfakuhrdph WHERE cpld='$cislo_cpld' "; 
$zmazane = mysql_query("$zmazttt");
//echo $zmazttt;
$copern=1;

    }
//koniec vymazanie a uprava


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Prijaté platby na faktúre</title>
  <style type="text/css">

  </style>
<script type="text/javascript">



    function ObnovUI()
    {
    document.formv1.h_cpld.value = '<?php echo "$h_cpld";?>';
    document.formv1.h_dok.value = '<?php echo "$cislo_dok";?>';
    document.formv1.h_dou.value = '<?php echo "$h_dou";?>';
    document.formv1.h_dppx.value = '<?php echo "$h_dppx";?>';
    document.formv1.h_dau.value = '<?php echo "$h_dausk";?>';
    document.formv1.h_dpp.value = '<?php echo "$h_dppsk";?>';
    document.formv1.h_hou.value = '<?php echo "$h_hou";?>';
    document.formv1.h_hz1.value = '<?php echo "$h_hz1";?>';
    document.formv1.h_hd1.value = '<?php echo "$h_hd1";?>';
    document.formv1.h_hz1.value = '<?php echo "$h_hz1";?>';
    document.formv1.h_hd1.value = '<?php echo "$h_hd1";?>';

    }

function zmazat(cpl)
                {

var n_cpl = cpl;
window.open('fakuhrdph.php?copern=16&cislo_cpld=' + n_cpl + '&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self' );
                }

function TovarFak()
                {
        window.open('fakuhrdph.php?copern=1001&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
                }
function TovarFakAll()
                {
        window.open('fakuhrdph.php?copern=1002&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>', '_self'); 
                }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Úhrady dokladu èíslo <?php echo $cislo_dok; ?> pre Odpoèet a uplatnenie DPH a po prijatí platby</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//nastavenie datumu do kvdph
if ( $copern >= 1 )
     {
$textdpp=0;
$sql = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $textdpp=$riadok->dppx;
  }
?>
<div id="nastavdppx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie Odpoètu a uplatnenia DPH a po prijatí platby</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavdppx.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastdpp' method='post' action='#' >
<td class='ponuka' colspan='5'> 
 Odpoèet a uplatnenie DPH a po prijatí platby <input type="checkbox" name="dppx" value="1" />
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NacitajDpp();" title='Ulo nastavenie Odpoètu a uplatnenia DPH a po prijatí platby' > 
<?php if ( $textdpp == 1 )       { ?>
 <script type="text/javascript">document.enastdpp.dppx.checked = "checked";</script>
<?php                            } ?>
</td></tr> 
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NacitajDpp()
                {
var dppx = 0;
if( document.enastdpp.dppx.checked ) dppx=1;

window.open('../faktury/fak_setulozdpp.php?cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&dppx=' + dppx + '&copern=901', '_self' );
                }

</script>
<?php
     }
?>


<?php

// toto je cast na zobrazenie tabulky
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 0 ORDER BY cpld";
$sql = mysql_query("$sqltt");
$cpol = mysql_num_rows($sql);
$i=0;
?>

<table class="fmenu" width="100%" >

<tr>
<td class="hmenu" width="8%" >è.p.

<?php
//echo $copern;
if ( $kli_vrok >= 2016 )
     {
$textdpp=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznamdok=mysql_data_seek($sqldok,0))
  {
  $riadokdok=mysql_fetch_object($sqldok);
  $textdpp=$riadokdok->dppx;
  }
?>
<img src='../obr/icon_calendar.png' onClick="nastavdppx.style.display=''; volajDppset(<?php echo $kli_uzid;?>);" width=12 height=12 border=0 title="Odpoèet a uplatnenie DPH a po prijatí platby 0=nie, 1=áno" ></a>
<?php echo $textdpp; ?>
</td>
<?php
     }
?>

<td class="hmenu" width="8%" >Doklad

<td class="hmenu" width="10%" >Úhr.dok.
<td class="hmenu" width="8%" >Dat.úhr.
<td class="hmenu" width="8%" >Dat.DPH
<td class="hmenu" width="8%" >Uhradené
<td class="hmenu" width="8%" >ZK2
<td class="hmenu" width="8%" >DN2
<td class="hmenu" width="8%" >ZK1
<td class="hmenu" width="8%" >DN1
<td class="hmenu" width="5%" >Zma/Uprav
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);


$h_dauskx=SkDatum($riadok->dau); 
$h_dppskx=SkDatum($riadok->dpp);

?>
<tr>
<td class="fmenu" ><?php echo $riadok->cpld;?></td>
<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->dou;?></td>
<td class="fmenu" ><?php echo $h_dauskx;?></td>
<td class="fmenu" ><?php echo $h_dppskx;?></td>
<td class="fmenu" ><?php echo $riadok->hou;?></td>
<td class="fmenu" ><?php echo $riadok->hz2;?></td>
<td class="fmenu" ><?php echo $riadok->hd2;?></td>
<td class="fmenu" ><?php echo $riadok->hz1;?></td>
<td class="fmenu" ><?php echo $riadok->hd1;?></td>
<td class="fmenu" >
<img border=1 src="../obr/zmaz.png" style="width:15; height:15;" onclick="zmazat(<?php echo $riadok->cpld;?>);" title="Zmaza" >
</td>

</tr>
<?php
  }
$i = $i + 1;
   }
?>
<tr>
<FORM name="formv1" class="obyc" method="post" action="faktovdph.php?cislo_dok=<?php echo $cislo_dok; ?>&page=<?php echo $page;?>&copern=15&drupoh=<?php echo $drupoh; ?>" >

<td class="fmenu"><input type="text" name="h_cpld" id="h_cpld" size="6" /></td>
<td class="fmenu"><input type="text" name="h_dok" id="h_dok" size="8"  /></td>

<td class="fmenu"><input type="text" name="h_dou" id="h_dou" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_dau" id="h_dau" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_dpp" id="h_dpp" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_hou" id="h_hou" size="10"  /></td>

<td class="fmenu"><input type="text" name="h_hz2" id="h_hz2" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_hd2" id="h_hd2" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_hz1" id="h_hz1" size="10"  /></td>
<td class="fmenu"><input type="text" name="h_hd1" id="h_hd1" size="10"  /></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi poloku" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
</table>

<br />
<a href="#" title="xxx" onclick="TovarFak();" >Naèíta úhrady do faktúry è.<?php echo $cislo_dok; ?> z obdobia <?php echo $kli_vume; ?></a>
<br />
<br />
<a href="#" title="xxx" onclick="TovarFakAll();" >Naèíta úhrady do všetkıch faktúr z obdobia <?php echo $kli_vume; ?></a>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
