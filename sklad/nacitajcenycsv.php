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
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>



<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



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
if (File_Exists ("../import/FIR$kli_vxcf/pracimport.csv")) { $soubor = unlink("../import/FIR$kli_vxcf/pracimport.csv"); }

  if (move_uploaded_file($_FILES['original']['tmp_name'], "../import/FIR$kli_vxcf/pracimport.csv")) 
  { 

//sem pojde nacitanie csv do tabulky kosikobj
$polozka=1;

$i=0;

$subor = fopen("../import/FIR$kli_vxcf/pracimport.csv", "r");
while (! feof($subor))
{
  $i=$i+1;
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

//cis;cep;minmno;%dph
//1001;10,797287731;25;20
//1002;12,283145114;50;10


//polozka
if( $polozka == 1 )
          {
  $x_cis = 1*$pole[0];
  $x_ced = $pole[1];
  $x_min = $pole[2];
  $x_dph = $pole[3];

$x_ced=str_replace(",",".",$x_ced);
$x_min=str_replace(",",".",$x_min);

$sqlttt = "UPDATE F$kli_vxcf"."_sklcis SET ced='$x_ced' WHERE cis = $x_cis ";
if( $x_cis > 0 ) { $ulozene = mysql_query("$sqlttt"); }

if( $_SERVER['SERVER_NAME'] == "www.biomeat.sk" ) 
  {

$sqlttt = "UPDATE F$kli_vxcf"."_sklcis SET dph='$x_dph' WHERE cis = $x_cis ";
if( $x_cis > 0 ) { $ulozene = mysql_query("$sqlttt"); } 

  }


$sqlttt = "UPDATE F$kli_vxcf"."_sklcis SET cep=ced/(1+(dph/100)) WHERE cis = $x_cis ";
if( $x_cis > 0 ) { $ulozene = mysql_query("$sqlttt"); }


//$sqlttt = "UPDATE F$kli_vxcf"."_sklcis SET ced=ROUND( ced, 2 ) WHERE cis = $x_cis ";
//if( $x_cis > 0 ) { $ulozene = mysql_query("$sqlttt"); }

$sqlttt = "UPDATE F$kli_vxcf"."_sklcisudaje SET cxc01='$x_min' WHERE xcis = $x_cis ";
if( $x_cis > 0 ) { $ulozene = mysql_query("$sqlttt"); }

          }
//koniec polozka


}
//koniec while


?>
<script type="text/javascript" > 
var okno = window.open("ccis.php?copern=1&drupoh=1&page=1&zmtz=1","_self");
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
