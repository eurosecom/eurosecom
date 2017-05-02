<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$clsm = 820;
$cslm=404200;
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
  <style type="text/css">

  </style>
<script type="text/javascript">

</script>
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
if (File_Exists ("../import/FIR$kli_vxcf/sluzbycis.csv")) { $soubor = unlink("../import/FIR$kli_vxcf/sluzbycis.csv"); }

  if (move_uploaded_file($_FILES['original']['tmp_name'], "../import/FIR$kli_vxcf/sluzbycis.csv")) 
  { 

$sqlttt = "DELETE FROM F$kli_vxcf"."_sluzby WHERE slu >= 0 ";
$ulozene = mysql_query("$sqlttt"); 

$i=0;

$subor = fopen("../import/FIR$kli_vxcf/sluzbycis.csv", "r");
while (! feof($subor))
{
  $i=$i+1;
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

//ID;položka;dph;cenabez;cenas;mj
//1011;produkcia;20;1;1,2;ks

//sluzby
//slu	nsl	nslp	nslz	mer	dph	cep	ced	
//tl1	tl2	tl3	labh1	labh2	kat01h	kat02h	kat03h	kat04h	webtx1	webtx2	datm


  $x_cis = 1*$pole[0];
  $x_nsl = $pole[1];

  $x_dph = $pole[2];
  $x_cep = $pole[3];
  $x_ced = $pole[4];
  $x_mer = $pole[5];

$ccis=1*$x_cis;


$x_ced=str_replace(",",".",$x_ced);
$x_cep=str_replace(",",".",$x_cep);

$x_nsl=str_replace("\"","",$x_nsl);

$sqlttt = "INSERT INTO F$kli_vxcf"."_sluzby ( slu, nsl, mer, dph, cep, ced ) VALUES ".
" ( '$x_cis', '$x_nsl', '$x_mer', '$x_dph', '$x_cep', '$x_ced' )";
if( $ccis > 0 ) { $ulozene = mysql_query("$sqlttt"); }


}
//koniec while

//labh1	labh2	kat01h	kat02h	kat03h	kat04h	webtx1	webtx2

$sqlttt = "UPDATE F$kli_vxcf"."_sluzby SET ".
" labh1='', labh2='', kat01h='', kat02h='', kat03h='', kat04h='', webtx1='', webtx2='' ";
$ulozene = mysql_query("$sqlttt"); 


?>
<script type="text/javascript" > 
var okno = window.open("cslu.php?copern=1&drupoh=1&page=1&zmtz=1","_self");
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
