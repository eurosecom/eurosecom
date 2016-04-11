<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

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
if( $cislo_oc == 2 ) { $mesiac="06"; }
if( $cislo_oc == 3 ) { $mesiac="09"; }
if( $cislo_oc == 4 ) { $mesiac="12"; }

if( $fir_fico == 44551142 )
{
$fir_ficox="00310000";
$typorg="22";
}




//////////////////////////////////////////////////////////// FIN 504
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {

//echo "idem dalej2";
$sqlt = <<<fin3adbf
(
FIN5.DBF
ICO CHARACTER 8 IÈO
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organizácie (“02“ – príspevková organizácia
“11“ – rozpoètová organizácia
“22“ – obec
“23“ – mesto
“31“ – nezisková inštitúcia
“51“ – obchodná spoloènos)
SYMBOL CHARACTER 6 symbol dlhového nástroja
MENA CHARACTER 3 kód meny
DAT_CERP DATE 8 dátum prvého dòa èerpania (RRRRMMDD)
DAT_SPLAT DATE 8 dátum splatnosti (RRRRMMDD)
UROK CHARACTER 1 typ úroku (“F“ – fixný, “V“ – variabilný)
RS00001 NUMERIC (15,2) nesplatená menovitá hodnota
RS00002 NUMERIC (15,2) z toho zahranièní veritelia
RS00003 NUMERIC (15,2) úroky
RS00004 NUMERIC (15,2) z toho zahranièní veritelia
);
fin3adbf;

/* Vytvoøíme spojení s SQL serverem a zvolíme databázi - nezapomeòte upravit tak, aby to odpovídalo Vašemu nastavení. */
//$spojeni = @mysql_connect("localhost");

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni)
{
  vypsat_zpravu("Nepodaøilo se pøipojit k databázi.");
  break;
}

//Taktéž upravte podle Vašeho nastavení:
@mysql_select_db($mysqldb, $spojeni);

//echo "idem dalej3";


$sqlx = 'DROP TABLE fin504dbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin504dbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin504dbf!"."<br />";

$sqlt = <<<fin504dbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),
SYMBOL          VARCHAR(4),
MENA            VARCHAR(3),
DAT_CERP        VARCHAR(12),
DAT_SPLAT       VARCHAR(12),
UROK            VARCHAR(1),
RS00001         DECIMAL(12,2),
RS00002         DECIMAL(12,2),
RS00003         DECIMAL(12,2),
RS00004         DECIMAL(12,2)
);
fin504dbf;

$sqlx = 'CREATE TABLE fin504dbf'.$sqlt;
$vysledx = mysql_query("$sqlx");



}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy
//cpl  px01  oc  druh  okres  obec  daz  stlpa  stlpb  stlp1  stlp2  stlp3  stlp4  stlp5  stlp6  

$dsqlt = "INSERT INTO fin504dbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" stlpa,stlpb,stlp1,stlp2,stlp3,stlp4,stlp5,rs00003,rs00004 ".
" FROM F$kli_vxcf"."_uctvykaz_fin504".
" WHERE oc >= 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE fin504dbf "." SET DAT_CERP=REPLACE(DAT_CERP, '-', '') ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE fin504dbf "." SET DAT_SPLAT=REPLACE(DAT_SPLAT, '-', '') ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO fin504dbf "." SELECT".
" ICO, DATROK, DATMES, TYPORG, '9', '', '', '', '', SUM(RS00001), SUM(RS00002), SUM(RS00003), SUM(RS00004) ".
" FROM fin504dbf GROUP BY ICO ";
$dsql = mysql_query("$dsqlt");


$sqltt = "SELECT * FROM fin504dbf ";
$sql = mysql_query("$sqltt");
$pol = 1*mysql_num_rows($sql);
if( $pol < 1 ) {

$dsqlt = "INSERT INTO fin504dbf ".
" ( ICO, DATROK, DATMES, TYPORG, SYMBOL, RS00001, RS00002, RS00003, RS00004 ) VALUES ".
" ( '$fir_ficox','$kli_vrok','$mesiac','$typorg', '9', 0, 0, 0, 0 ) ";
$dsql = mysql_query("$dsqlt");

}

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin504dbf ";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);
$polozky[] = array("SYMBOL", "C", 4);
$polozky[] = array("MENA", "C", 3);
$polozky[] = array("DAT_CERP", "D", 12);
$polozky[] = array("DAT_SPLAT", "D", 12);
$polozky[] = array("UROK", "C", 1);
$polozky[] = array("RS00001", "N", 15, 2);
$polozky[] = array("RS00002", "N", 15, 2);
$polozky[] = array("RS00003", "N", 15, 2);
$polozky[] = array("RS00004", "N", 15, 2);

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN5_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN5_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru = $outfilex;

//echo "idem dalej4";

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru, $polozky);
if (!$dbf_soubor)
{
  vypsat_zpravu("Nepodaøilo se vytvoøit DBF soubor.");
  break;
}

//echo "idem dalej5";

//Získáme výsledek SQL dotazu
$vysledek = mysql_query($dotaz, $spojeni);
if (!$vysledek)
{
  vypsat_zpravu("Zpracování SQL dotazu neprobìhlo úspìšnì.");
  break;
}

//exit;
//echo "idem dalej6";

/* Postupnì pøidáváme jednotlivé záznamy do DBF souboru */
while ($zaznam = @mysql_fetch_row($vysledek))
  dbase_add_record($dbf_soubor, $zaznam);

//Uzavøeme obì spojení
@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin504dbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 504


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DBF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
  
</script>
</HEAD>
<BODY class="white" onload="VyberVstup();">




<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 5-04 DBF</td>
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
Stiahnite si nižšie uvedený súbor na Váš lokálny disk, premenujte ho na FIN5.DBF a potom naèítajte na portál www.rissam.sk :
<br />
<br />
<a href="<?php echo $nazev_souboru; ?>"><?php echo $nazev_souboru; ?></a>
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
