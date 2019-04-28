<HTML>
<?php

// celkovy zaciatok dokkurztu
       do
       {
$zmtz=1*$_REQUEST['zmtz'];

if( $zmtz == 1 )
  {
$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }
if( $zmtz == 0 )
  {
session_start(); 
$h5rtgh5 = include("../odpad2010/h5rtgh5.php");
$kli_uzid=1*$_SESSION['ez_id'];
if( $kli_uzid == 0 ) exit;
  }

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

if( $zmtz == 0 )
  {
$citwebs = include("../funkcie/citaj_webs.php");
$kli_vxcf=$webs_fir;
if( $kli_vxcf == 0 ) exit;
  }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$h_cvz = $_REQUEST['h_obj'];
//echo $h_cvz;
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//vymazanie vsetko
if ( $copern == 66 )
    {



    }
//koniec vymazania vsetko

$sql = "DROP TABLE F$kli_vxcf"."_kosiktext ";
//$vysledek = mysql_query("$sql");

$sql = "SELECT * FROM F".$kli_vxcf."_kosiktext";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sqlt = <<<paskovacka
(
   invt        VARCHAR(30) not null,
   itxt        TEXT not null
);
paskovacka;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_kosiktext'.$sqlt;
$vysledok = mysql_query($sql);
              }

$sql = "SELECT zdro FROM F".$kli_vxcf."_kosiktext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD nas1 DECIMAL(4,0) DEFAULT 0 AFTER itxt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD zdro DECIMAL(1,0) DEFAULT 0 AFTER nas1";
$vysledek = mysql_query("$sql");
               }

$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext MODIFY invt VARCHAR(30) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$sql = "SELECT pcen FROM F".$kli_vxcf."_kosiktext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD pnak VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD pcen DECIMAL(10,4) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext MODIFY pcen DECIMAL(10,4) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT cszp FROM F".$kli_vxcf."_kosiktext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD cszp VARCHAR(15) not null AFTER zdro";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT eobj FROM F".$kli_vxcf."_kosiktext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD akod DECIMAL(4,0) DEFAULT 0 AFTER pnak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD datd DATE NOT NULL AFTER pnak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_kosiktext ADD eobj DECIMAL(10,0) DEFAULT 0 AFTER pnak";
$vysledek = mysql_query("$sql");
               }

$ulozenx="";

//ulozenie
if ( $copern == 116 )
     {

$itxt = strip_tags($_REQUEST['itxt']);
$zdro = 1*strip_tags($_REQUEST['zdro']);
$pcen = 1*strip_tags($_REQUEST['pcen']);
$pnak = strip_tags($_REQUEST['pnak']);
$cszp = strip_tags($_REQUEST['cszp']);

$eobj = 1*strip_tags($_REQUEST['eobj']);
$akod = 1*strip_tags($_REQUEST['akod']);
$datd_sql = SqlDatum($_REQUEST['datd']);
$nas1 = 1*$_REQUEST['nas1'];

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_kosiktext ( invt, itxt, zdro ) VALUES ('$h_cvz', '$itxt', '$zdro' ); "); 

$ulozttt = "UPDATE F$kli_vxcf"."_kosiktext SET itxt='$itxt', zdro='$zdro', pcen='$pcen', pnak='$pnak', cszp='$cszp', ".
" eobj='$eobj', akod='$akod', datd='$datd_sql', nas1='$nas1' WHERE invt='$h_cvz' "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=1;
$ulozenx="Text uloûen˝";
    }
//koniec ulozenia




$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext ".
" WHERE invt = '$h_cvz' ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$itxt = $fir_riadok->itxt;
$eobj = 1*$fir_riadok->eobj;
$akod = 1*$fir_riadok->akod;
$nas1 = 1*$fir_riadok->nas1;
$zdro = 1*$fir_riadok->zdro;
$datd_sk = SkDatum($fir_riadok->datd);

mysql_free_result($fir_vysledok);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pozn·mka k objedn·vke</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">





<?php
//nova
  if ( $copern == 1 )
  { 
?>
    function ObnovUI()
    {

    document.forms.formv1.eobj.value="<?php echo $eobj;?>";
    document.forms.formv1.datd.value="<?php echo $datd_sk;?>";
<?php if ( $nas1 == 1 ) { ?>
    document.forms.formv1.nas1.checked = "checked";
<?php                   } ?>
    document.forms.formv1.zdro.value="<?php echo $zdro;?>";
    document.forms.formv1.akod.value="<?php echo $akod;?>";
    document.forms.formv1.eobj.focus();
    document.forms.formv1.eobj.select();


    }


<?php
//koniec nova
  }
?>

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Pozn·mka k objedn·vke ËÌslo <?php echo $h_cvz;?>
</td>
</tr>
</table>
<br />


<?php
if ( $copern == 1  )
     {
?>

<table class="fmenu" width="260px" >

<tr>
<FORM name="formv1" class="obyc" method="post" action="obj_text.php?page=1&copern=116&h_obj=<?php echo $h_cvz;?>&zmtz=<?php echo $zmtz;?>">

<td class="bmenu" colspan="10">
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù">
<?php echo $ulozenx; ?>
</tr>

<tr><td class="bmenu" colspan="10">
eshop OBJ: <input type='text' name='eobj' id='eobj' size='10' maxlenght='10' value="" > | 
mont·û: <input type="checkbox" name="nas1" value="1" />| 
stav: <input type='text' name='zdro' id='zdro' size='10' maxlenght='10' value="" > | 
doprava: <input type='text' name='akod' id='akod' size='10' maxlenght='10' value="" > | 
dodaù: <input type='text' name='datd' id='datd' size='10' maxlenght='10' value="" > | 
</td></tr>

<tr><td class="bmenu" colspan="10">
<textarea name="itxt" id="itxt" rows="34" cols="100" >
<?php echo $itxt; ?>
</textarea>
</td></tr>

</FORM>




<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokkurztu

       } while (false);
?>
</BODY>
</HTML>
