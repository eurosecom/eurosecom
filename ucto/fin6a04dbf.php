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
$citfir = include("../cis/citaj_nas.php");
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

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204nuj WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $okres=1*$riaddok->okres;
  $obec=1*$riaddok->obec;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykfins6a04".$kli_uzid." WHERE prx = 1 ";
//echo $sqltt;
//exit;
$sqlx = mysql_query("$sqltt");
$pol = mysql_num_rows($sqlx);

$i=0;
  while ($i == 0 )
  {
  if (@$zaznam=mysql_data_seek($sqlx,$i))
{
$hlavicka=mysql_fetch_object($sqlx);

$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $r38="";

}
$i=$i+1;
    }

//echo $r01;
//exit;

$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; 
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_fin6a04 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
if($sqlpv) { $polpv = mysql_num_rows($sqlpv); }

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if ( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if ( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if ( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if ( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if ( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if ( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if ( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if ( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if ( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if ( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if ( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if ( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if ( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if ( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if ( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if ( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if ( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if ( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }
}
$ipv = $ipv + 1;
  }


//////////////////////////////////////////////////////////// FIN 6a04
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


$sqlx = 'DROP TABLE fin6a04dbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin6a04dbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin6a04dbf!"."<br />";

$sqlt = <<<fin6a04dbf
(
OKRES           VARCHAR(3),
ICO             VARCHAR(8),
KODOB           VARCHAR(6),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(22),
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
RS03702         DECIMAL(12,2)
);
fin6a04dbf;

$sqlx = 'CREATE TABLE fin6a04dbf'.$sqlt;
$vysledx = mysql_query("$sqlx");



}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy
//cpl  px01  oc  druh  okres  obec  daz  stlpa  stlpb  stlp1  stlp2  stlp3  stlp4  stlp5  stlp6  

$dsqlt = "INSERT INTO fin6a04dbf (okres, ico, kodob, datrok, datmes, typorg ) VALUES ( '$okres','$fir_ficox','$obec','$kli_vrok','$mesiac','$typorg' )";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE fin6a04dbf SET ".


" RS03701='$r37', RS03702='$rm37', ".
" RS03601='$r36', RS03602='$rm36', ".
" RS03501='$r35', RS03502='$rm35', ".
" RS03401='$r34', RS03402='$rm34', ".
" RS03301='$r33', RS03302='$rm33', ".
" RS03201='$r32', RS03202='$rm32', ".
" RS03101='$r31', RS03102='$rm31', ".

" RS03001='$r30', RS03002='$rm30', ".
" RS02901='$r29', RS02902='$rm29', ".
" RS02801='$r28', RS02802='$rm28', ".
" RS02701='$r27', RS02702='$rm27', ".
" RS02601='$r26', RS02602='$rm26', ".
" RS02501='$r25', RS02502='$rm25', ".
" RS02401='$r24', RS02402='$rm24', ".
" RS02301='$r23', RS02302='$rm23', ".
" RS02201='$r22', RS02202='$rm22', ".
" RS02101='$r21', RS02102='$rm21', ".

" RS02001='$r20', RS02002='$rm20', ".
" RS01901='$r19', RS01902='$rm19', ".
" RS01801='$r18', RS01802='$rm18', ".
" RS01701='$r17', RS01702='$rm17', ".
" RS01601='$r16', RS01602='$rm16', ".
" RS01501='$r15', RS01502='$rm15', ".
" RS01401='$r14', RS01402='$rm14', ".
" RS01301='$r13', RS01302='$rm13', ".
" RS01201='$r12', RS01202='$rm12', ".
" RS01101='$r11', RS01102='$rm11', ".

" RS01001='$r10', RS01002='$rm10', ".
" RS00901='$r09', RS00902='$rm09', ".
" RS00801='$r08', RS00802='$rm08', ".
" RS00701='$r07', RS00702='$rm07', ".
" RS00601='$r06', RS00602='$rm06', ".
" RS00501='$r05', RS00502='$rm05', ".
" RS00401='$r04', RS00402='$rm04', ".
" RS00301='$r03', RS00302='$rm03', ".
" RS00201='$r02', RS00202='$rm02', ".
" RS00101='$r01', RS00102='$rm01'  ";
$dsql = mysql_query("$dsqlt");

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin6a04dbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("OKRES", "C", 3);
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("KODOB", "C", 6);
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

// Získáme unikátní název DBF souboru
$nazev_souboru = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru = "../tmp/fin6a.dbf";
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
//header("Content-Disposition: attachment; filename=fin6a.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin6a04dbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 6a04






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
<td>EuroSecom  -  FIN 6a-04 DBF</td>
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
<a href="../tmp/fin6a.dbf">fin6a.dbf</a>

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
