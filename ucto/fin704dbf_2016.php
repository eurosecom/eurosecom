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


//////////////////////////////////////////////////////////// FIN 704
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

$sqlt = <<<fin7dbf
(
FIN7.DBF
ICO CHARACTER 8 IÈO
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organizácie „31“ – nezisková inštitúcia
“51“ – obchodná spoloènos)
RS00101 NUMERIC (15,2) údajová èas
RS00102 NUMERIC (15,2)
.
.
.
RS03801 NUMERIC (15,2)
RS03802 NUMERIC (15,2)
);
fin7dbf;

$sqlx = 'DROP TABLE fin7dbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin7dbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin7dbf!"."<br />";

$sqlt = <<<fin7dbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),

RS00101         DECIMAL(12,2),
RS00102         DECIMAL(12,2),
RS00201         DECIMAL(12,2),
RS00202         DECIMAL(12,2),
RS00301         DECIMAL(12,2),
RS00302         DECIMAL(12,2),
RS00401         DECIMAL(12,2),
RS00402         DECIMAL(12,2),
RS00501         DECIMAL(12,2),
RS00502         DECIMAL(12,2),
RS00601         DECIMAL(12,2),
RS00602         DECIMAL(12,2),
RS00701         DECIMAL(12,2),
RS00702         DECIMAL(12,2),
RS00801         DECIMAL(12,2),
RS00802         DECIMAL(12,2),
RS00901         DECIMAL(12,2),
RS00902         DECIMAL(12,2),

RS01001         DECIMAL(12,2),
RS01002         DECIMAL(12,2),
RS01101         DECIMAL(12,2),
RS01102         DECIMAL(12,2),
RS01201         DECIMAL(12,2),
RS01202         DECIMAL(12,2),
RS01301         DECIMAL(12,2),
RS01302         DECIMAL(12,2),
RS01401         DECIMAL(12,2),
RS01402         DECIMAL(12,2),
RS01501         DECIMAL(12,2),
RS01502         DECIMAL(12,2),
RS01601         DECIMAL(12,2),
RS01602         DECIMAL(12,2),
RS01701         DECIMAL(12,2),
RS01702         DECIMAL(12,2),
RS01801         DECIMAL(12,2),
RS01802         DECIMAL(12,2),
RS01901         DECIMAL(12,2),
RS01902         DECIMAL(12,2),

RS02001         DECIMAL(12,2),
RS02002         DECIMAL(12,2),
RS02101         DECIMAL(12,2),
RS02102         DECIMAL(12,2),
RS02201         DECIMAL(12,2),
RS02202         DECIMAL(12,2),
RS02301         DECIMAL(12,2),
RS02302         DECIMAL(12,2),
RS02401         DECIMAL(12,2),
RS02402         DECIMAL(12,2),
RS02501         DECIMAL(12,2),
RS02502         DECIMAL(12,2),
RS02601         DECIMAL(12,2),
RS02602         DECIMAL(12,2),
RS02701         DECIMAL(12,2),
RS02702         DECIMAL(12,2),
RS02801         DECIMAL(12,2),
RS02802         DECIMAL(12,2),
RS02901         DECIMAL(12,2),
RS02902         DECIMAL(12,2),


RS03001         DECIMAL(12,2),
RS03002         DECIMAL(12,2),
RS03101         DECIMAL(12,2),
RS03102         DECIMAL(12,2),
RS03201         DECIMAL(12,2),
RS03202         DECIMAL(12,2),
RS03301         DECIMAL(12,2),
RS03302         DECIMAL(12,2),
RS03401         DECIMAL(12,2),
RS03402         DECIMAL(12,2),
RS03501         DECIMAL(12,2),
RS03502         DECIMAL(12,2),
RS03601         DECIMAL(12,2),
RS03602         DECIMAL(12,2),
RS03701         DECIMAL(12,2),
RS03702         DECIMAL(12,2),
RS03801         DECIMAL(12,2),
RS03802         DECIMAL(12,2)


);
fin7dbf;

$sqlx = 'CREATE TABLE fin7dbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO fin7dbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" r01,rm01,".
" r02,rm02,".
" r03,rm03,".
" r04,rm04,".
" r05,rm05,".
" r06,rm06,".
" r07,rm07,".
" r08,rm08,".
" r09,rm09,".

" r10,rm10,".
" r11,rm11,".
" r12,rm12,".
" r13,rm13,".
" r14,rm14,".
" r15,rm15,".
" r16,rm16,".
" r17,rm17,".
" r18,rm18,".
" r19,rm19,".

" r20,rm20,".
" r21,rm21,".
" r22,rm22,".
" r23,rm23,".
" r24,rm24,".
" r25,rm25,".
" r26,rm26,".
" r27,rm27,".
" r28,rm28,".
" r29,rm29,".

" r30,rm30,".
" r31,rm31,".
" r32,rm32,".
" r33,rm33,".
" r34,rm34,".
" r35,rm35,".
" r36,rm36,".
" r37,rm37,".
" r38,rm38 ".


" FROM F$kli_vxcf"."_uctvykaz_fin704".
" WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin7dbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);

$polozky[] = array("RS00101", "N", 15, 2);
$polozky[] = array("RS00102", "N", 15, 2);
$polozky[] = array("RS00201", "N", 15, 2);
$polozky[] = array("RS00202", "N", 15, 2);
$polozky[] = array("RS00301", "N", 15, 2);
$polozky[] = array("RS00302", "N", 15, 2);
$polozky[] = array("RS00401", "N", 15, 2);
$polozky[] = array("RS00402", "N", 15, 2);
$polozky[] = array("RS00501", "N", 15, 2);
$polozky[] = array("RS00502", "N", 15, 2);
$polozky[] = array("RS00601", "N", 15, 2);
$polozky[] = array("RS00602", "N", 15, 2);
$polozky[] = array("RS00701", "N", 15, 2);
$polozky[] = array("RS00702", "N", 15, 2);
$polozky[] = array("RS00801", "N", 15, 2);
$polozky[] = array("RS00802", "N", 15, 2);
$polozky[] = array("RS00901", "N", 15, 2);
$polozky[] = array("RS00902", "N", 15, 2);

$polozky[] = array("RS01001", "N", 15, 2);
$polozky[] = array("RS01002", "N", 15, 2);
$polozky[] = array("RS01101", "N", 15, 2);
$polozky[] = array("RS01102", "N", 15, 2);
$polozky[] = array("RS01201", "N", 15, 2);
$polozky[] = array("RS01202", "N", 15, 2);
$polozky[] = array("RS01301", "N", 15, 2);
$polozky[] = array("RS01302", "N", 15, 2);
$polozky[] = array("RS01401", "N", 15, 2);
$polozky[] = array("RS01402", "N", 15, 2);
$polozky[] = array("RS01501", "N", 15, 2);
$polozky[] = array("RS01502", "N", 15, 2);
$polozky[] = array("RS01601", "N", 15, 2);
$polozky[] = array("RS01602", "N", 15, 2);
$polozky[] = array("RS01701", "N", 15, 2);
$polozky[] = array("RS01702", "N", 15, 2);
$polozky[] = array("RS01801", "N", 15, 2);
$polozky[] = array("RS01802", "N", 15, 2);
$polozky[] = array("RS01901", "N", 15, 2);
$polozky[] = array("RS01902", "N", 15, 2);

$polozky[] = array("RS02001", "N", 15, 2);
$polozky[] = array("RS02002", "N", 15, 2);
$polozky[] = array("RS02101", "N", 15, 2);
$polozky[] = array("RS02102", "N", 15, 2);
$polozky[] = array("RS02201", "N", 15, 2);
$polozky[] = array("RS02202", "N", 15, 2);
$polozky[] = array("RS02301", "N", 15, 2);
$polozky[] = array("RS02302", "N", 15, 2);
$polozky[] = array("RS02401", "N", 15, 2);
$polozky[] = array("RS02402", "N", 15, 2);
$polozky[] = array("RS02501", "N", 15, 2);
$polozky[] = array("RS02502", "N", 15, 2);
$polozky[] = array("RS02601", "N", 15, 2);
$polozky[] = array("RS02602", "N", 15, 2);
$polozky[] = array("RS02701", "N", 15, 2);
$polozky[] = array("RS02702", "N", 15, 2);
$polozky[] = array("RS02801", "N", 15, 2);
$polozky[] = array("RS02802", "N", 15, 2);
$polozky[] = array("RS02901", "N", 15, 2);
$polozky[] = array("RS02902", "N", 15, 2);

$polozky[] = array("RS03001", "N", 15, 2);
$polozky[] = array("RS03002", "N", 15, 2);
$polozky[] = array("RS03101", "N", 15, 2);
$polozky[] = array("RS03102", "N", 15, 2);
$polozky[] = array("RS03201", "N", 15, 2);
$polozky[] = array("RS03202", "N", 15, 2);
$polozky[] = array("RS03301", "N", 15, 2);
$polozky[] = array("RS03302", "N", 15, 2);
$polozky[] = array("RS03401", "N", 15, 2);
$polozky[] = array("RS03402", "N", 15, 2);
$polozky[] = array("RS03501", "N", 15, 2);
$polozky[] = array("RS03502", "N", 15, 2);
$polozky[] = array("RS03601", "N", 15, 2);
$polozky[] = array("RS03602", "N", 15, 2);
$polozky[] = array("RS03701", "N", 15, 2);
$polozky[] = array("RS03702", "N", 15, 2);
$polozky[] = array("RS03801", "N", 15, 2);
$polozky[] = array("RS03802", "N", 15, 2);


// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN7_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN7_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru = $outfilex;

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

$sqlx = 'DROP TABLE fin7dbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 704






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
<td>EuroSecom  -  FIN 7-04 DBF</td>
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
Stiahnite si nižšie uvedený súbor na Váš lokálny disk, premenujte ho na FIN7.DBF a potom naèítajte na portál www.rissam.sk :
<br />
<br />
<a href="<?php echo $nazev_souboru; ?>"><?php echo $nazev_souboru; ?></a>


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
