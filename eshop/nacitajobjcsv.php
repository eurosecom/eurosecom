<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$odeslano = 1*$_REQUEST['odeslano'];

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

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title> </title>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php 

if ( $odeslano == 1 )
{ 
if (File_Exists ("../import/FIR$kli_vxcf/objednavka.csv")) { $soubor = unlink("../import/FIR$kli_vxcf/objednavka.csv"); }

  if (move_uploaded_file($_FILES['original']['tmp_name'], "../import/FIR$kli_vxcf/objednavka.csv")) 
  { 

//sem pojde nacitanie csv do tabulky kosikobj
$hlavicka=1;
$polozka=0;
$poznamka=0;

$i=0;

$subor = fopen("../import/FIR$kli_vxcf/objednavka.csv", "r");
while (! feof($subor))
{
  $i=$i+1;
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

//15;44551142;2;211;

//hlavicka
if( $hlavicka == 1 )
          {
  $x_obj = $pole[0];
  $x_ico = $pole[1];
  $x_odbm = $pole[2];
  $x_id = $pole[3];
  $xnat="Externá objednávka č.".$x_obj;

$sqult = "UPDATE F$kli_vxcf"."_kosikobj SET xice='$x_ico', xodbm='$x_odbm', xnat='$xnat' WHERE xdok = $cislo_dok ";
$ulozene = mysql_query("$sqult"); 

$poznamkatext=$xnat."\r";
          }
//koniec hlavicka

//4805;1;caffe espreso;1.17;1.40;tovaru ;2;0;0;20
//4200;2001;instalation OS;17.00;20.40;sluĹľba ;3;1;0;20
//2951;9999;free item text;2;2.4;free ;4;1;0;20
//poznamka;
//aaaaaa
//bbbbb

//polozka
if( $polozka == 1 )
          {
  $x_cpl = $pole[0];
  $x_cis = $pole[1];
  $x_nat = $pole[2];
  $x_cep = $pole[3];
  $x_ced = $pole[4];
  //poznamka iban
  $x_xdx3 = $pole[5];
  $x_mno = $pole[6];
  //druh cennika 0=tovar,1=sluzby dcex
  $x_xsx3 = $pole[7];
  //zmena ceny zcen
  $x_xsx2 = $pole[8];
  $x_dph = $pole[9];

$x_hdb=$x_mno*$x_cep;
$x_hdd=$x_mno*$x_ced;

$sqlttt = "INSERT INTO F$kli_vxcf"."_kosikobj ".
" ( xdok,  xice, xodbm, xcpl, xcis, xnat, xdph, xcep, xced, xmno, xhdb, xhdd, xid, xdatm, xsx3, xsx2, xdx3 ) ".
" VALUES ( '$cislo_dok', '$x_ico', '$x_odbm', '$x_cpl', '$x_cis', '$x_nat', '$x_dph', '$x_cep', ".
" '$x_ced', '$x_mno', '$x_hdb', '$x_hdd', '$x_id', now(), '$x_xsx3', ".
" '$x_xsx2', '$x_xdx3' )  ";

if( $x_cpl != 'poznamka' ) { $ulozene = mysql_query("$sqlttt"); }
          }
//koniec polozka

//poznamka
if( $poznamka == 1 )
          {
  $xtext = $pole[0];

$poznamkatext=$poznamkatext.$xtext;
          }
//koniec poznamka

if( $hlavicka == 1 ) { $hlavicka=0; $polozka=1; }
if( $polozka == 1 AND $x_cpl == 'poznamka' ) { $polozka=0; $poznamka=1; }
}
//koniec while

$sqlttt= "DELETE FROM F$kli_vxcf"."_kosiktext WHERE invt = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");

$sqlttt= "INSERT INTO F$kli_vxcf"."_kosiktext (invt, itxt) VALUES ('$cislo_dok', '$poznamkatext' ) ";
$sqldok = mysql_query("$sqlttt");

?>
<script type="text/javascript" > 
var okno = window.open("../eshop/obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&zmtz=1","_self");
</script>
<?php
  }
//koniec ak upload
}
//koniec if odeslano=1

if ( $odeslano == 0 )
{ 
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?cislo_dok=<?php echo $cislo_dok; ?>
&drupoh=<?php echo $drupoh; ?>&copern=<?php echo $copern; ?>&odeslano=1"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >Súbor:</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=2097152> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 2 MB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="Odoslať"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
}


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
