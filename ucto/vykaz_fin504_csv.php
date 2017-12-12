<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

//od 1.1.2018 nová štruktúra CSV

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


$fir_ficox=$fir_fico;
if( $fir_fico < 100000 ) $fir_ficox="00".$fir_fico;
$mesiac="03";
$typorg="31";
$cislo_oc=1;

$cislo_oc = 1*$_REQUEST['cislo_oc'];
if( $cislo_oc == 1 ) { $mesiac="01"; }
if( $cislo_oc == 2 ) { $mesiac="02"; }
if( $cislo_oc == 3 ) { $mesiac="03"; }
if( $cislo_oc == 4 ) { $mesiac="04"; }
if( $cislo_oc == 5 ) { $mesiac="05"; }
if( $cislo_oc == 6 ) { $mesiac="06"; }
if( $cislo_oc == 7 ) { $mesiac="07"; }
if( $cislo_oc == 8 ) { $mesiac="08"; }
if( $cislo_oc == 9 ) { $mesiac="09"; }
if( $cislo_oc == 10 ) { $mesiac="10"; }
if( $cislo_oc == 11 ) { $mesiac="11"; }
if( $cislo_oc == 12 ) { $mesiac="12"; }

if( $fir_fico == 44551142 )
{
$fir_ficox="00310000";
$typorg="22";
}

$dat_bez = Date ("Ymdhi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$fico8=$fir_fico;
if( $fico8 < 999999 ) { $fico8="00".$fico8; }
$rokmes=$kli_vmes.$kli_vrok;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

//nazov
$nazsub="FIN5_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }


//////////////////////////////////////////////////////////// FIN 504

$soubor = fopen("../tmp/$nazsub", "a+");

$dotaz = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE oc >= 0 ORDER BY cpl";

$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;

$sumstlp4=0;
$sumstlp5=0;
$sumrs00003=0;
$sumrs00004=0;

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sumstlp4=$sumstlp4+$hlavicka->stlp4;
$sumstlp5=$sumstlp5+$hlavicka->stlp5;
$sumrs00003=$sumrs00003+$hlavicka->rs00003;
$sumrs00004=$sumrs00004+$hlavicka->rs00004;

//hlavicka
if( $i == 0 )
     {
$obdobie=$kli_vmes;
$dat_dat = Date ("Y-m-d-h-i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"hlavicka,1\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"ico\","."\"rok\","."\"mesiac\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"".$fico8."\","."\"".$kli_vrok."\","."\"".$kli_vmes."\""."\r\n";
  fwrite($soubor, $text);

  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"dlhove-nastroje,".$pol."\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"Sa\","."\"Sb\","."\"S1\","."\"S2\","."\"S3\","."\"S4\","."\"S5\","."\"S6\","."\"S7\""."\r\n";
  fwrite($soubor, $text);

     }

//polozky

$stlp1=$hlavicka->stlp1;
$pole = explode("-", $stlp1);
$stlp1x=$pole[0].$pole[1].$pole[2];

$stlp2=$hlavicka->stlp2;
$pole = explode("-", $stlp2);
$stlp2x=$pole[0].$pole[1].$pole[2];


  $text = "\"".$hlavicka->stlpa."\",\"".$hlavicka->stlpb."\",\"";
  $text = $text.$stlp1x."\",\"".$stlp2x."\",\"".$hlavicka->stlp3."\",\"".$hlavicka->stlp4."\",\"".$hlavicka->stlp5."\",\"";
  $text = $text.$hlavicka->rs00003."\",\"".$hlavicka->rs00004."\"";
  $text = $text."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
  }


//spolu
  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"dlhove-nastroje-spolu,1\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"S4\","."\"S5\","."\"S6\","."\"S7\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"".$sumstlp4."\",\"".$sumstlp5."\",\"";
  $text = $text.$sumrs00003."\",\"".$sumrs00004."\"";
  $text = $text."\r\n";

  fwrite($soubor, $text);



fclose($soubor);
//koniec nerozp.polozky


$sqlx = 'DROP TABLE vyddbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";
////////////////////////////////////////////////////////////KONIEC FIN 504



?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>CSV</title>
  <style type="text/css">
  </style>
<script type="text/javascript">   
</script>
</HEAD>
<BODY class="white">


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 5-04 CSV súbor FIN5.csv</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if( $copern == 1 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedený súbor na Váš lokálny disk a uložte ho s názvom FIN5.csv :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>
<br />
<br />
<?php
}
?>




<br /><br />
<?php
// celkovy koniec dokumentu



       } while (false);
?>
</BODY>
</HTML>
