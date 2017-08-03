<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 2900;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$pol = 1*$_REQUEST['pol'];

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

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export do CSV</title>
  <style type="text/css">

  </style>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Export do CSV

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU SALDOKONTA
if( $copern == 10 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="dolehotne_saldokonto";
$uctpol="prsaldodolcsv".$kli_uzid;
if( $pol == 1 ) 
  {
$nazsub="polehotne_saldokonto";
$uctpol="prsaldopolcsv".$kli_uzid;
  }

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/".$nazsub."_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/".$nazsub."_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazsub=$outfilex;
$soubor = fopen("$nazsub", "a+");

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE pox = 1 ".
" ORDER BY pox2,nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";

$sql = mysql_query("$sqltt");
$pocet = mysql_num_rows($sql);
//echo $sqltt."<br />";

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pocet )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//Fak/VS Vystavená Splatná po Doklad Firma Faktúra Uhradené Zostatok

$das_sk=SkDatum($hlavicka->das);
$dat_sk=SkDatum($hlavicka->dat);
$dau_sk=SkDatum($hlavicka->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk=$dau_sk;


$hod=$hlavicka->hod;
$ehod=str_replace(".",",",$hod);
$uhr=$hlavicka->uhr;
$euhr=str_replace(".",",",$uhr);
$zos=$hlavicka->zos;
$ezos=str_replace(".",",",$zos);

if( $i == 0 )
{
  $text = "ucet;faktura;vystavena;splatna;dni po splatnosti;doklad;ico;nazov;hodnota;uhradene;zostatok"."\r\n";
  fwrite($soubor, $text);
}

  $text = $hlavicka->uce.";".$hlavicka->fak.";".$dat_sk.";".$das_sk.";".$hlavicka->puc.";".$hlavicka->dok;

  $text = $text.";".$hlavicka->ico.";".$hlavicka->nai;

  $text = $text.";".$ehod.";".$euhr.";".$ezos."\r\n";

  fwrite($soubor, $text);

//echo $text."<br />";

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>


<?php



}
///////////////////////////////////////////////////KONIEC SUBORU PRE SALDO dol a pol
?>

<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
