<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

//od 1.1.2018 nov� �trukt�ra CSV FIN 404

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

//nazov
$nazsub="FIN4_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }


//////////////////////////////////////////////////////////// FIN 404



//urob csv
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$dat_bez = Date ("Ymdhi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$fico8=$fir_fico;
if( $fico8 < 999999 ) { $fico8="00".$fico8; }
$rokmes=$kli_vmes.$kli_vrok;

$soubor = fopen("../tmp/$nazsub", "a+");

$dotaz = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin304 WHERE F$kli_vxcf"."_uctvykaz_fin304.oc = $cislo_oc  ORDER BY oc";

$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;


$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//hlavicka pasiva

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

  $text = "\"vybrane-pasiva,50\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"R\","."\"S1\","."\"S2\","."\"S3\","."\"S4\","."\"S5\",".
"\"S6\","."\"S7\","."\"S8\","."\"S9\","."\"S10\",";

  $text = $text."\"S11\","."\"S12\","."\"S13\","."\"S14\","."\"S15\",".
"\"S16\","."\"S17\","."\"S18\","."\"S19\","."\"S20\",";

  $text = $text."\"S21\","."\"S22\","."\"S23\","."\"S24\","."\"S25\"";

  $text = $text."\r\n";


  fwrite($soubor, $text);


//polozky aktiva


  $text = "\"R1\",\"".$hlavicka->pocs01."\",\"".$hlavicka->pocs02."\",\"".$hlavicka->pocs03."\",\"".$hlavicka->pocs04.
"\",\"".$hlavicka->pocs05."\",\"".$hlavicka->pocs06."\",\"".$hlavicka->pocs07.
"\",\"".$hlavicka->pocs08."\",\"".$hlavicka->pocs09."\",\"".$hlavicka->pocs10."\",";

  $text = $text."\"".$hlavicka->pocs11."\",\"".$hlavicka->pocs12."\",\"".$hlavicka->pocs13."\",\"".$hlavicka->pocs14.
"\",\"".$hlavicka->pocs15."\",\"".$hlavicka->pocs16."\",\"".$hlavicka->pocs17.
"\",\"".$hlavicka->pocs18."\",\"".$hlavicka->pocs19."\",\"".$hlavicka->pocs20."\",";

  $text = $text."\"".$hlavicka->pocs21."\",\"".$hlavicka->pocs22."\",\"".$hlavicka->pocs23."\",\"".$hlavicka->pocs24.
"\",\"".$hlavicka->pocs25."\"";

  $text = $text."\r\n";

  fwrite($soubor, $text);




}
$i = $i + 1;
  }





fclose($soubor);
////////////////////////////////////////////////////////////KONIEC FIN 404


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
<td>EuroSecom  -  FIN 4-04 CSV s�bor FIN4.csv</td>
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
Stiahnite si ni��ie uveden� s�bor na V� lok�lny disk a ulo�te ho s n�zvom FIN4.csv :
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
