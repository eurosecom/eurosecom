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
OKRES           VARCHAR(3),
ICO             VARCHAR(8),
KODOB           VARCHAR(6),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),
SYMBOL          VARCHAR(4),
MENA            VARCHAR(3),
DAT_CERP        VARCHAR(8),
DAT_SPLAT       VARCHAR(8),
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
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
" stlpa,stlpb,stlp1,stlp2,stlp3,stlp4,stlp5,rs00003,rs00004  ".
" FROM F$kli_vxcf"."_uctvykaz_fin504".
" WHERE oc = $cislo_oc AND ( stlp4 != 0 OR stlp5 != 0 OR stlpa = '9' ) ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin504dbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("OKRES", "C", 3);
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("KODOB", "C", 6);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);
$polozky[] = array("SYMBOL", "C", 4);
$polozky[] = array("MENA", "C", 3);
$polozky[] = array("DAT_CERP", "C", 8);
$polozky[] = array("DAT_SPLAT", "C", 8);
$polozky[] = array("UROK", "C", 1);
$polozky[] = array("RS00001", "N", 15, 2);
$polozky[] = array("RS00002", "N", 15, 2);
$polozky[] = array("RS00003", "N", 15, 2);
$polozky[] = array("RS00004", "N", 15, 2);

// Získáme unikátní název DBF souboru
$nazev_souboru = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru = "../tmp/fin5.dbf";
//echo $nazev_souboru;

@unlink($nazev_souboru);

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
//header("Content-Disposition: attachment; filename=fin5.dbf"); 
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
Stiahnite si nižšie uvedené súbory na Váš lokálny disk  :
<br />
<br />
<a href="../tmp/fin5.dbf">fin5.dbf</a>

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
