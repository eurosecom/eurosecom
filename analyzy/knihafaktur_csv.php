<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 2900;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$vsetko = 1*$_REQUEST['vsetko'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
$strana=1;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";




?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export Kniha faktúr</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;



    
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Export  Kniha faktúr do CSV

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU 
if( $copern == 10 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="knihafaktur";

if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");



$sqltt = "SELECT * FROM F$kli_vxcf"."_fakodb".
" WHERE dok > 0 ORDER BY dok ";
//echo $sqltt;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$crrd=3;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//nazov
$nazico="";
$sqlico = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $hlavicka->ico ";
$vysico = mysql_query($sqlico);
if ( $vysico ) {
$riadok=mysql_fetch_object($vysico);
$nazico = $riadok->nai;
               }

if( $i == 0 )
{

  $text = "uc.mesiac;datum;splatna;c.dokladu;ucet;ico;nazov;c.faktury;hodnota"."\r\n";
  fwrite($soubor, $text);
}


$hodnota=$hlavicka->hod;
$hodnotaex=str_replace(".",",",$hodnota);

  $text = $hlavicka->ume.";".$hlavicka->dat.";".$hlavicka->das.";".$hlavicka->dok.";";

  $text = $text.$hlavicka->uce.";".$hlavicka->ico.";".$nazico.";".$hlavicka->fak.";".$hodnotaex."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_fakdod".
" WHERE dok > 0 ORDER BY dok ";
//echo $sqltt;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0;
$crrd=3;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//nazov
$nazico="";
$sqlico = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $hlavicka->ico ";
$vysico = mysql_query($sqlico);
if ( $vysico ) {
$riadok=mysql_fetch_object($vysico);
$nazico = $riadok->nai;
               }


$hodnota=$hlavicka->hod;
$hodnotaex=str_replace(".",",",$hodnota);


  $text = $hlavicka->ume.";".$hlavicka->dat.";".$hlavicka->das.";".$hlavicka->dok.";";

  $text = $text.$hlavicka->uce.";".$hlavicka->ico.";".$nazico.";".$hlavicka->fak.";".$hodnotaex."\r\n";
  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);

?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>

<br />
<br />


<?php



}
///////////////////////////////////////////////////KONIEC SUBORU
?>




<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
