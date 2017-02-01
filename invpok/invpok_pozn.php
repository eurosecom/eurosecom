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

$sql = "DROP TABLE F$kli_vxcf"."_dodavobjtext ";
//$vysledek = mysql_query("$sql");

$sql = "SELECT * FROM F".$kli_vxcf."_dodavobjtext";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sqlt = <<<paskovacka
(
   invt        VARCHAR(30) not null,
   itxt        TEXT not null
);
paskovacka;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dodavobjtext'.$sqlt;
$vysledok = mysql_query($sql);
              }

$sql = "SELECT zdro FROM F".$kli_vxcf."_dodavobjtext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext ADD nas1 DECIMAL(4,0) DEFAULT 0 AFTER itxt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext ADD zdro DECIMAL(1,0) DEFAULT 0 AFTER nas1";
$vysledek = mysql_query("$sql");
               }

$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext MODIFY invt VARCHAR(30) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$sql = "SELECT pcen FROM F".$kli_vxcf."_dodavobjtext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext ADD pnak VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext ADD pcen DECIMAL(10,4) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext MODIFY pcen DECIMAL(10,4) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT cszp FROM F".$kli_vxcf."_dodavobjtext ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_dodavobjtext ADD cszp VARCHAR(15) not null AFTER zdro";
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

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_dodavobjtext ( invt, itxt, zdro ) VALUES ('$h_cvz', '$itxt', '$zdro' ); "); 

$ulozttt = "UPDATE F$kli_vxcf"."_dodavobjtext SET itxt='$itxt', zdro='$zdro', pcen='$pcen', pnak='$pnak', cszp='$cszp' WHERE invt='$h_cvz' "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=1;
$ulozenx="Text uložený";
    }
//koniec ulozenia




$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext ".
" WHERE invt = '$h_cvz' ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$itxt = $fir_riadok->itxt;


mysql_free_result($fir_vysledok);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Poznámka k objednávke</title>
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
<td>EuroSecom  -  Poznámka k dodávate¾skej objednávke èíslo <?php echo $h_cvz;?>
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
<INPUT type="submit" id="uloz" name="uloz" value="Uloži">
<?php echo $ulozenx; ?>
</tr>


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
