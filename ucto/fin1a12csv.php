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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

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

//////////////////////////////////////////////////////////// FIN 112p


$sqlx = 'DROP TABLE prijdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM prijdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku prijdbf!"."<br />";

$sqlt = <<<prijdbf
(
okres           VARCHAR(3),
ico             VARCHAR(8),
kodob           VARCHAR(6),
datrok          VARCHAR(4),
datmes          VARCHAR(2),
typorg          VARCHAR(2),
cast            VARCHAR(1),
zdroj           VARCHAR(4),
pol             VARCHAR(3),
podp            VARCHAR(3),
rs00001         DECIMAL(12,2),
rs00002         DECIMAL(12,2),
rs00003         DECIMAL(12,2)
);
prijdbf;

$sqlx = 'CREATE TABLE prijdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


$ttvv = "INSERT INTO prijdbf ( okres, ico, kodob, datrok, datmes, typorg, rs00101  ) ".
" VALUES ( '205', '00310000', '504831', '2010', '03', '22', '65932'  )";
//$ttqq = mysql_query("$ttvv");

}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
" 1,zdroj,xpolozka,podpolozka,schvaleny,zmeneny,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
" 3,zdroj,xpolozka,podpolozka,schvaleny,zmeneny,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 3 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


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

//rozp.polozky
$nazsub=$fico8."_PRI_N_".$kli_vrok."_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");

$dotaz = "select * from prijdbf where cast = 1 order by cast,zdroj,pol,podp ";


$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//hlavicka
if( $i == 0 )
     {
$obdobie=$kli_vmes;
$dat_dat = Date ("Y-m-d-h-i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));



//111;ORG;20131203120001;pocet_poloziek_tela;
//00327921;525359;2014;;


  $text = "113;ORG;".$dat_bez.";".$pol."\r\n";
  fwrite($soubor, $text);

  $text = $fico8.";".$hlavicka->kodob.";".$kli_vrok.";".$rokmes."\r\n";
  fwrite($soubor, $text);

     }

//polozky
//081;0041;212;003;73690,5;93939;333.33;444.44;;;

$hodrm1=""; $hodrp1=""; $hodrp2="";
$rs00001=$hlavicka->rs00001; $rs00001=str_replace(".",",",$rs00001);
$rs00002=$hlavicka->rs00002; $rs00002=str_replace(".",",",$rs00002);
$rs00003=$hlavicka->rs00003; $rs00003=str_replace(".",",",$rs00003);

  $text = "081;".$hlavicka->zdroj.";".$hlavicka->pol.";".$hlavicka->podp.";".$hodrm1.";".$rs00001.";".$hodrp1.";";
  $text = $text.$hodrp2.";".$rs00002.";".$rs00003;
  $text = $text."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
  }


fclose($soubor);
//koniec rozp.polozky

//nerozp.polozky
$nazsub2=$fico8."_PRI_NP_".$kli_vrok."_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub2")) { $soubor = unlink("../tmp/$nazsub2"); }

$soubor = fopen("../tmp/$nazsub2", "a+");

$dotaz = "select * from prijdbf where cast = 3 order by cast,zdroj,pol,podp ";


$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//hlavicka
if( $i == 0 )
     {
$obdobie=$kli_vmes;
$dat_dat = Date ("Y-m-d-h-i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));



//111;ORG;20131203120001;pocet_poloziek_tela;
//00327921;525359;2014;;


  $text = "133;ORG;".$dat_bez.";".$pol."\r\n";
  fwrite($soubor, $text);

  $text = $fico8.";".$hlavicka->kodob.";".$kli_vrok.";".$rokmes."\r\n";
  fwrite($soubor, $text);

     }

//polozky
//081;0041;212;003;73690,5;93939;333.33;444.44;;;

$hodrm1=""; $hodrp1=""; $hodrp2="";
$rs00003=$hlavicka->rs00003; $rs00003=str_replace(".",",",$rs00003);


  $text = "081;".$hlavicka->pol.";".$hlavicka->podp.";".$rs00003;
  $text = $text."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
  }


fclose($soubor);
//koniec nerozp.polozky

$sqlx = 'DROP TABLE prijdbf';
//$vysledx = mysql_query("$sqlx");


////////////////////////////////////////////////////////////KONIEC FIN 112p


//////////////////////////////////////////////////////////// FIN 112v

$sqlx = 'DROP TABLE vyddbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM vyddbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku vyddbf!"."<br />";

$sqlt = <<<vyddbf
(
okres           VARCHAR(3),
ico             VARCHAR(8),
kodob           VARCHAR(6),
datrok          VARCHAR(4),
datmes          VARCHAR(2),
typorg          VARCHAR(2),
cast            VARCHAR(1),
program         VARCHAR(6),
zdroj           VARCHAR(4),
odd             VARCHAR(2),
skup            VARCHAR(1),
trieda          VARCHAR(1),
podtr           VARCHAR(1),
pol             VARCHAR(3),
podp            VARCHAR(3),
rs00001         DECIMAL(12,2),
rs00002         DECIMAL(12,2),
rs00003         DECIMAL(12,2)
);
vyddbf;

$sqlx = 'CREATE TABLE vyddbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


$ttvv = "INSERT INTO vyddbf ( okres, ico, kodob, datrok, datmes, typorg, rs00101  ) ".
" VALUES ( '205', '00310000', '504831', '2010', '03', '22', '65932'  )";
//$ttqq = mysql_query("$ttvv");

}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO vyddbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
"1,program,zdroj,xoddiel,skupina,trieda,podtrieda,xpolozka,podpolozka,schvaleny,zmeneny,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO vyddbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
"4,program,zdroj,xoddiel,skupina,trieda,podtrieda,xpolozka,podpolozka,schvaleny,zmeneny,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 4 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//rozp.polozky
$nazsub3=$fico8."_VYD_N_".$kli_vrok."_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub3")) { $soubor = unlink("../tmp/$nazsub3"); }

$soubor = fopen("../tmp/$nazsub3", "a+");

$dotaz = "select * from vyddbf where cast = 1 order by cast,zdroj,pol,podp ";


$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//hlavicka
if( $i == 0 )
     {
$obdobie=$kli_vmes;
$dat_dat = Date ("Y-m-d-h-i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));



//111;ORG;20131203120001;pocet_poloziek_tela;
//00327921;525359;2014;;


  $text = "123;ORG;".$dat_bez.";".$pol."\r\n";
  fwrite($soubor, $text);

  $text = $fico8.";".$hlavicka->kodob.";".$kli_vrok.";".$rokmes."\r\n";
  fwrite($soubor, $text);

     }

//polozky
//081;0041;212;003;73690,5;93939;333.33;444.44;;;

$hodrm1=""; $hodrp1=""; $hodrp2="";
$rs00001=$hlavicka->rs00001; $rs00001=str_replace(".",",",$rs00001);
$rs00002=$hlavicka->rs00002; $rs00002=str_replace(".",",",$rs00002);
$rs00003=$hlavicka->rs00003; $rs00003=str_replace(".",",",$rs00003);

$podprog=""; $projekt="";

  $text = "081;".$hlavicka->zdroj.";".$hlavicka->pol.";".$hlavicka->podp.";";
  $text = $text.$hlavicka->program.";".$podprog.";".$projekt.";";
  $text = $text.$hlavicka->odd.";".$hlavicka->skup.";".$hlavicka->trieda.";".$hlavicka->podtr.";";
  $text = $text.$hodrm1.";".$rs00001.";".$hodrp1.";";
  $text = $text.$hodrp2.";".$rs00002.";".$rs00003;
  $text = $text."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
  }


fclose($soubor);
//koniec rozp.polozky

//nerozp.polozky
$nazsub4=$fico8."_VYD_NP_".$kli_vrok."_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub4")) { $soubor = unlink("../tmp/$nazsub4"); }

$soubor = fopen("../tmp/$nazsub4", "a+");

$dotaz = "select * from vyddbf where cast = 4 order by cast,zdroj,pol,podp,odd,skup,trieda,podtr ";


$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//hlavicka
if( $i == 0 )
     {
$obdobie=$kli_vmes;
$dat_dat = Date ("Y-m-d-h-i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));



//111;ORG;20131203120001;pocet_poloziek_tela;
//00327921;525359;2014;;


  $text = "143;ORG;".$dat_bez.";".$pol."\r\n";
  fwrite($soubor, $text);

  $text = $fico8.";".$hlavicka->kodob.";".$kli_vrok.";".$rokmes."\r\n";
  fwrite($soubor, $text);

     }

//polozky
//081;0041;212;003;73690,5;93939;333.33;444.44;;;

$hodrm1=""; $hodrp1=""; $hodrp2="";
$rs00003=$hlavicka->rs00003; $rs00003=str_replace(".",",",$rs00003);


  $text = "081;".$hlavicka->pol.";".$hlavicka->podp.";".$hlavicka->odd.";".$hlavicka->skup.";".$hlavicka->trieda.";".$hlavicka->podtr.";".$rs00003;
  $text = $text."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
  }


fclose($soubor);
//koniec nerozp.polozky


$sqlx = 'DROP TABLE vyddbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";
////////////////////////////////////////////////////////////KONIEC FIN 112v



?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DBF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;



function VyberVstup()
                {

                }


function TlacPrehlad()
                {
var h_oc = document.forms.formp2.h_oc.value;
var h_fmzdy = document.forms.formp2.h_fmzdy.value;

window.open('../mzdy/prehlad_dane.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&fmzdy=' + h_fmzdy + '&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


    
</script>
</HEAD>
<BODY class="white" onload="VyberVstup();">




<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 1a-12 CSV</td>
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
Stiahnite si nižšie uvedené súbory na Váš lokálny disk  :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">Rozpoètované príjmy <?php echo $nazsub; ?></a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub2; ?>">Nerozpoètované prímy <?php echo $nazsub2; ?></a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub3; ?>">Rozpoètované výdavky <?php echo $nazsub3; ?></a>
<br />
<br />
<a href="../tmp/<?php echo $nazsub4; ?>">Nerozpoètované výdavky <?php echo $nazsub4; ?></a>
<br />
<br />

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
