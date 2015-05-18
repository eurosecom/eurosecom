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

//////////////////////////////////////////////////////////// FIN 1a12p
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

//vloz celkovy sucet do vytvorenej databazy

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
" druh,'9','','',SUM(schvaleny),SUM(zmeneny),SUM(skutocnost) ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE ( druh = 1 OR druh = 3 ) GROUP BY druh";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vloz sucet za polozku do vytvorenej databazy

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
" druh,zdroj,xpolozka,'',SUM(schvaleny),SUM(zmeneny),SUM(skutocnost) ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE ( druh = 1 OR druh = 3 ) GROUP BY druh,zdroj,xpolozka";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE prijdbf "." SET cast=4 WHERE cast = 3 ";
$dsql = mysql_query("$dsqlt");

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from prijdbf order by cast,zdroj,pol,podp ";


/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("OKRES", "C", 3);
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("KODOB", "C", 6);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);
$polozky[] = array("CAST", "C", 1);
$polozky[] = array("ZDROJ", "C", 4);
$polozky[] = array("POL", "C", 3);
$polozky[] = array("PODP", "C", 3);
$polozky[] = array("RS00001", "N", 15, 2);
$polozky[] = array("RS00002", "N", 15, 2);
$polozky[] = array("RS00003", "N", 15, 2);

// Získáme unikátní název DBF souboru
$nazev_souboru = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru = "../tmp/fin1aprij.dbf";
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
//header("Content-Disposition: attachment; filename=fin1aprij.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE prijdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 1a12p


//////////////////////////////////////////////////////////// FIN 1a12v
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {

//echo "idem dalej2";

/* Vytvoøíme spojení s SQL serverem a zvolíme databázi - nezapomeòte upravit tak, aby to odpovídalo Vašemu nastavení. */
//$spojeni = @mysql_connect("localhost");

require_once("../pswd/password.php");
@$spojeni2 = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni2)
{
  vypsat_zpravu("Nepodaøilo se pøipojit k databázi.");
  break;
}

//Taktéž upravte podle Vašeho nastavení:
@mysql_select_db($mysqldb, $spojeni2);

//echo "idem dalej3";

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

//vloz celkovy sucet do vytvorenej databazy

$dsqlt = "INSERT INTO vyddbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
"druh,'9','','','','','','','',SUM(schvaleny),SUM(zmeneny),SUM(skutocnost) ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE ( druh = 2 OR druh = 4 ) GROUP BY druh";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE vyddbf "." SET cast=1 WHERE cast = 2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE vyddbf "." SET cast=4 WHERE cast = 4 ";
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz2 = "select * from vyddbf order by cast,program,zdroj,odd,skup,trieda,podtr,pol,podp ";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky2[] = array("OKRES", "C", 3);
$polozky2[] = array("ICO", "C", 8);
$polozky2[] = array("KODOB", "C", 6);
$polozky2[] = array("DATROK", "C", 4);
$polozky2[] = array("DATMES", "C", 2);
$polozky2[] = array("TYPORG", "C", 2);
$polozky2[] = array("CAST", "C", 1);
$polozky2[] = array("PROGRAM", "C", 6);
$polozky2[] = array("ZDROJ", "C", 4);
$polozky2[] = array("ODD", "C", 2);
$polozky2[] = array("SKUP", "C", 1);
$polozky2[] = array("TRIEDA", "C", 1);
$polozky2[] = array("PODTR", "C", 1);
$polozky2[] = array("POL", "C", 3);
$polozky2[] = array("PODP", "C", 3);
$polozky2[] = array("RS00001", "N", 15, 2);
$polozky2[] = array("RS00002", "N", 15, 2);
$polozky2[] = array("RS00003", "N", 15, 2);


// Získáme unikátní název DBF souboru
$nazev_souboru2 = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru2 = "../tmp/fin1avyd.dbf";
//echo $nazev_souboru2;

@unlink($nazev_souboru2);

//echo "idem dalej4";

//Vytvoøíme DBF soubor
$dbf_soubor2 = @dbase_create($nazev_souboru2, $polozky2);
if (!$dbf_soubor2)
{
  vypsat_zpravu("Nepodaøilo se vytvoøit DBF soubor.");
  break;
}

//echo "idem dalej5";

//Získáme výsledek SQL dotazu
$vysledek = mysql_query($dotaz2, $spojeni2);
if (!$vysledek)
{
  vypsat_zpravu("Zpracování SQL dotazu neprobìhlo úspìšnì.");
  break;
}

//exit;
//echo "idem dalej6";

/* Postupnì pøidáváme jednotlivé záznamy do DBF souboru */
while ($zaznam = @mysql_fetch_row($vysledek))
  dbase_add_record($dbf_soubor2, $zaznam);

//Uzavøeme obì spojení
@mysql_close($spojeni2);
@dbase_close($dbf_soubor2);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=fin1avyd.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru2);

//Soubor nakonec smažeme
//@unlink($nazev_souboru2);

$sqlx = 'DROP TABLE vyddbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 1a12v



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
<td>EuroSecom  -  FIN 1a-12 DBF</td>
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
<a href="../tmp/fin1aprij.dbf">fin1aprij.dbf</a>
<br />
<br />
<a href="../tmp/fin1avyd.dbf">fin1avyd.dbf</a>

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
