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


//////////////////////////////////////////////////////////// FIN 204nuj
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

$sqlt = <<<fin2adbf
(
FIN2NUJ.DBF
ICO CHARACTER 8 IÈO
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organizácie („31“ – nezisková inštitúcia)
RS00101 NUMERIC (15,2) údajová èas
RS00102 NUMERIC (15,2)
RS00103 NUMERIC (15,2)
RS00104 NUMERIC (15,2)
.
.
.
RS04001 NUMERIC (15,2)
RS04002 NUMERIC (15,2)
RS04003 NUMERIC (15,2)
RS04004 NUMERIC (15,2)
RS04105 NUMERIC (15,2)
RS04106 NUMERIC (15,2)
.
.
.
RS07405 NUMERIC (15,2)
RS07406 NUMERIC (15,2)
);
fin2adbf;

$sqlx = 'DROP TABLE fin2adbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin2adbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin2adbf!"."<br />";

$sqlt = <<<fin2adbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),
RS00101         DECIMAL(12,2),
RS00102         DECIMAL(12,2),
RS00103         DECIMAL(12,2),
RS00104         DECIMAL(12,2),
RS00201         DECIMAL(12,2),
RS00202         DECIMAL(12,2),
RS00203         DECIMAL(12,2),
RS00204         DECIMAL(12,2),
RS00301         DECIMAL(12,2),
RS00302         DECIMAL(12,2),
RS00303         DECIMAL(12,2),
RS00304         DECIMAL(12,2),
RS00401         DECIMAL(12,2),
RS00402         DECIMAL(12,2),
RS00403         DECIMAL(12,2),
RS00404         DECIMAL(12,2),
RS00501         DECIMAL(12,2),
RS00502         DECIMAL(12,2),
RS00503         DECIMAL(12,2),
RS00504         DECIMAL(12,2),
RS00601         DECIMAL(12,2),
RS00602         DECIMAL(12,2),
RS00603         DECIMAL(12,2),
RS00604         DECIMAL(12,2),
RS00701         DECIMAL(12,2),
RS00702         DECIMAL(12,2),
RS00703         DECIMAL(12,2),
RS00704         DECIMAL(12,2),
RS00801         DECIMAL(12,2),
RS00802         DECIMAL(12,2),
RS00803         DECIMAL(12,2),
RS00804         DECIMAL(12,2),
RS00901         DECIMAL(12,2),
RS00902         DECIMAL(12,2),
RS00903         DECIMAL(12,2),
RS00904         DECIMAL(12,2),
RS01001         DECIMAL(12,2),
RS01002         DECIMAL(12,2),
RS01003         DECIMAL(12,2),
RS01004         DECIMAL(12,2),
RS01101         DECIMAL(12,2),
RS01102         DECIMAL(12,2),
RS01103         DECIMAL(12,2),
RS01104         DECIMAL(12,2),
RS01201         DECIMAL(12,2),
RS01202         DECIMAL(12,2),
RS01203         DECIMAL(12,2),
RS01204         DECIMAL(12,2),
RS01301         DECIMAL(12,2),
RS01302         DECIMAL(12,2),
RS01303         DECIMAL(12,2),
RS01304         DECIMAL(12,2),
RS01401         DECIMAL(12,2),
RS01402         DECIMAL(12,2),
RS01403         DECIMAL(12,2),
RS01404         DECIMAL(12,2),
RS01501         DECIMAL(12,2),
RS01502         DECIMAL(12,2),
RS01503         DECIMAL(12,2),
RS01504         DECIMAL(12,2),
RS01601         DECIMAL(12,2),
RS01602         DECIMAL(12,2),
RS01603         DECIMAL(12,2),
RS01604         DECIMAL(12,2),
RS01701         DECIMAL(12,2),
RS01702         DECIMAL(12,2),
RS01703         DECIMAL(12,2),
RS01704         DECIMAL(12,2),
RS01801         DECIMAL(12,2),
RS01802         DECIMAL(12,2),
RS01803         DECIMAL(12,2),
RS01804         DECIMAL(12,2),
RS01901         DECIMAL(12,2),
RS01902         DECIMAL(12,2),
RS01903         DECIMAL(12,2),
RS01904         DECIMAL(12,2),
RS02001         DECIMAL(12,2),
RS02002         DECIMAL(12,2),
RS02003         DECIMAL(12,2),
RS02004         DECIMAL(12,2),
RS02101         DECIMAL(12,2),
RS02102         DECIMAL(12,2),
RS02103         DECIMAL(12,2),
RS02104         DECIMAL(12,2),
RS02201         DECIMAL(12,2),
RS02202         DECIMAL(12,2),
RS02203         DECIMAL(12,2),
RS02204         DECIMAL(12,2),
RS02301         DECIMAL(12,2),
RS02302         DECIMAL(12,2),
RS02303         DECIMAL(12,2),
RS02304         DECIMAL(12,2),
RS02401         DECIMAL(12,2),
RS02402         DECIMAL(12,2),
RS02403         DECIMAL(12,2),
RS02404         DECIMAL(12,2),
RS02501         DECIMAL(12,2),
RS02502         DECIMAL(12,2),
RS02503         DECIMAL(12,2),
RS02504         DECIMAL(12,2),
RS02601         DECIMAL(12,2),
RS02602         DECIMAL(12,2),
RS02603         DECIMAL(12,2),
RS02604         DECIMAL(12,2),
RS02701         DECIMAL(12,2),
RS02702         DECIMAL(12,2),
RS02703         DECIMAL(12,2),
RS02704         DECIMAL(12,2),
RS02801         DECIMAL(12,2),
RS02802         DECIMAL(12,2),
RS02803         DECIMAL(12,2),
RS02804         DECIMAL(12,2),
RS02901         DECIMAL(12,2),
RS02902         DECIMAL(12,2),
RS02903         DECIMAL(12,2),
RS02904         DECIMAL(12,2),
RS03001         DECIMAL(12,2),
RS03002         DECIMAL(12,2),
RS03003         DECIMAL(12,2),
RS03004         DECIMAL(12,2),
RS03101         DECIMAL(12,2),
RS03102         DECIMAL(12,2),
RS03103         DECIMAL(12,2),
RS03104         DECIMAL(12,2),
RS03201         DECIMAL(12,2),
RS03202         DECIMAL(12,2),
RS03203         DECIMAL(12,2),
RS03204         DECIMAL(12,2),
RS03301         DECIMAL(12,2),
RS03302         DECIMAL(12,2),
RS03303         DECIMAL(12,2),
RS03304         DECIMAL(12,2),
RS03401         DECIMAL(12,2),
RS03402         DECIMAL(12,2),
RS03403         DECIMAL(12,2),
RS03404         DECIMAL(12,2),
RS03501         DECIMAL(12,2),
RS03502         DECIMAL(12,2),
RS03503         DECIMAL(12,2),
RS03504         DECIMAL(12,2),
RS03601         DECIMAL(12,2),
RS03602         DECIMAL(12,2),
RS03603         DECIMAL(12,2),
RS03604         DECIMAL(12,2),
RS03701         DECIMAL(12,2),
RS03702         DECIMAL(12,2),
RS03703         DECIMAL(12,2),
RS03704         DECIMAL(12,2),
RS03801         DECIMAL(12,2),
RS03802         DECIMAL(12,2),
RS03803         DECIMAL(12,2),
RS03804         DECIMAL(12,2),
RS03901         DECIMAL(12,2),
RS03902         DECIMAL(12,2),
RS03903         DECIMAL(12,2),
RS03904         DECIMAL(12,2),
RS04001         DECIMAL(12,2),
RS04002         DECIMAL(12,2),
RS04003         DECIMAL(12,2),
RS04004         DECIMAL(12,2),

RS04105         DECIMAL(12,2),
RS04106         DECIMAL(12,2),

RS04205         DECIMAL(12,2),
RS04206         DECIMAL(12,2),

RS04305         DECIMAL(12,2),
RS04306         DECIMAL(12,2),

RS04405         DECIMAL(12,2),
RS04406         DECIMAL(12,2),
RS04505         DECIMAL(12,2),
RS04506         DECIMAL(12,2),
RS04605         DECIMAL(12,2),
RS04606         DECIMAL(12,2),
RS04705         DECIMAL(12,2),
RS04706         DECIMAL(12,2),
RS04805         DECIMAL(12,2),
RS04806         DECIMAL(12,2),
RS04905         DECIMAL(12,2),
RS04906         DECIMAL(12,2),
RS05005         DECIMAL(12,2),
RS05006         DECIMAL(12,2),
RS05105         DECIMAL(12,2),
RS05106         DECIMAL(12,2),
RS05205         DECIMAL(12,2),
RS05206         DECIMAL(12,2),
RS05305         DECIMAL(12,2),
RS05306         DECIMAL(12,2),
RS05405         DECIMAL(12,2),
RS05406         DECIMAL(12,2),
RS05505         DECIMAL(12,2),
RS05506         DECIMAL(12,2),
RS05605         DECIMAL(12,2),
RS05606         DECIMAL(12,2),
RS05705         DECIMAL(12,2),
RS05706         DECIMAL(12,2),
RS05805         DECIMAL(12,2),
RS05806         DECIMAL(12,2),
RS05905         DECIMAL(12,2),
RS05906         DECIMAL(12,2),
RS06005         DECIMAL(12,2),
RS06006         DECIMAL(12,2),
RS06105         DECIMAL(12,2),
RS06106         DECIMAL(12,2),
RS06205         DECIMAL(12,2),
RS06206         DECIMAL(12,2),
RS06305         DECIMAL(12,2),
RS06306         DECIMAL(12,2),
RS06405         DECIMAL(12,2),
RS06406         DECIMAL(12,2),
RS06505         DECIMAL(12,2),
RS06506         DECIMAL(12,2),
RS06605         DECIMAL(12,2),
RS06606         DECIMAL(12,2),
RS06705         DECIMAL(12,2),
RS06706         DECIMAL(12,2),
RS06805         DECIMAL(12,2),
RS06806         DECIMAL(12,2),
RS06905         DECIMAL(12,2),
RS06906         DECIMAL(12,2),
RS07005         DECIMAL(12,2),
RS07006         DECIMAL(12,2),

RS07105         DECIMAL(12,2),
RS07106         DECIMAL(12,2),

RS07205         DECIMAL(12,2),
RS07206         DECIMAL(12,2),

RS07305         DECIMAL(12,2),
RS07306         DECIMAL(12,2),

RS07405         DECIMAL(12,2),
RS07406         DECIMAL(12,2)

);
fin2adbf;

$sqlx = 'CREATE TABLE fin2adbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO fin2adbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" r01,rk01,rn01,rm01,".
" r02,rk02,rn02,rm02,".
" r03,rk03,rn03,rm03,".
" r04,rk04,rn04,rm04,".
" r05,rk05,rn05,rm05,".
" r06,rk06,rn06,rm06,".
" r07,rk07,rn07,rm07,".
" r08,rk08,rn08,rm08,".
" r09,rk09,rn09,rm09,".
" r10,rk10,rn10,rm10,".
" r11,rk11,rn11,rm11,".
" r12,rk12,rn12,rm12,".
" r13,rk13,rn13,rm13,".
" r14,rk14,rn14,rm14,".
" r15,rk15,rn15,rm15,".
" r16,rk16,rn16,rm16,".
" r17,rk17,rn17,rm17,".
" r18,rk18,rn18,rm18,".
" r19,rk19,rn19,rm19,".
" r20,rk20,rn20,rm20,".
" r21,rk21,rn21,rm21,".
" r22,rk22,rn22,rm22,".
" r23,rk23,rn23,rm23,".
" r24,rk24,rn24,rm24,".
" r25,rk25,rn25,rm25,".
" r26,rk26,rn26,rm26,".
" r27,rk27,rn27,rm27,".
" r28,rk28,rn28,rm28,".
" r29,rk29,rn29,rm29,".
" r30,rk30,rn30,rm30,".
" r31,rk31,rn31,rm31,".
" r32,rk32,rn32,rm32,".
" r33,rk33,rn33,rm33,".
" r34,rk34,rn34,rm34,".
" r35,rk35,rn35,rm35,".
" r36,rk36,rn36,rm36,".
" r37,rk37,rn37,rm37,".
" r38,rk38,rn38,rm38,".
" r39,rk39,rn39,rm39,".
" r40,rk40,rn40,rm40,".
" r41,rm41,".
" r42,rm42,".
" r43,rm43,".
" r44,rm44,".
" r45,rm45,".
" r46,rm46,".
" r47,rm47,".
" r48,rm48,".
" r49,rm49,".
" r50,rm50,".
" r51,rm51,".
" r52,rm52,".
" r53,rm53,".
" r54,rm54,".
" r55,rm55,".
" r56,rm56,".
" r57,rm57,".
" r58,rm58,".
" r59,rm59,".
" r60,rm60,".
" r61,rm61,".
" r62,rm62, ".

" r63,rm63, ".
" r64,rm64, ".
" r65,rm65, ".
" r66,rm66, ".
" r67,rm67, ".
" r68,rm68, ".
" r69,rm69, ".
" r70,rm70, ".

" r71,rm71, ".
" r72,rm72, ".
" r73,rm73, ".
" r74,rm74 ".

" FROM F$kli_vxcf"."_uctvykaz_fin204no".
" WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin2adbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);
$polozky[] = array("RS00101", "N", 15, 2);
$polozky[] = array("RS00102", "N", 15, 2);
$polozky[] = array("RS00103", "N", 15, 2);
$polozky[] = array("RS00104", "N", 15, 2);
$polozky[] = array("RS00201", "N", 15, 2);
$polozky[] = array("RS00202", "N", 15, 2);
$polozky[] = array("RS00203", "N", 15, 2);
$polozky[] = array("RS00204", "N", 15, 2);
$polozky[] = array("RS00301", "N", 15, 2);
$polozky[] = array("RS00302", "N", 15, 2);
$polozky[] = array("RS00303", "N", 15, 2);
$polozky[] = array("RS00304", "N", 15, 2);
$polozky[] = array("RS00401", "N", 15, 2);
$polozky[] = array("RS00402", "N", 15, 2);
$polozky[] = array("RS00403", "N", 15, 2);
$polozky[] = array("RS00404", "N", 15, 2);
$polozky[] = array("RS00501", "N", 15, 2);
$polozky[] = array("RS00502", "N", 15, 2);
$polozky[] = array("RS00503", "N", 15, 2);
$polozky[] = array("RS00504", "N", 15, 2);
$polozky[] = array("RS00601", "N", 15, 2);
$polozky[] = array("RS00602", "N", 15, 2);
$polozky[] = array("RS00603", "N", 15, 2);
$polozky[] = array("RS00604", "N", 15, 2);
$polozky[] = array("RS00701", "N", 15, 2);
$polozky[] = array("RS00702", "N", 15, 2);
$polozky[] = array("RS00703", "N", 15, 2);
$polozky[] = array("RS00704", "N", 15, 2);
$polozky[] = array("RS00801", "N", 15, 2);
$polozky[] = array("RS00802", "N", 15, 2);
$polozky[] = array("RS00803", "N", 15, 2);
$polozky[] = array("RS00804", "N", 15, 2);
$polozky[] = array("RS00901", "N", 15, 2);
$polozky[] = array("RS00902", "N", 15, 2);
$polozky[] = array("RS00903", "N", 15, 2);
$polozky[] = array("RS00904", "N", 15, 2);
$polozky[] = array("RS01001", "N", 15, 2);
$polozky[] = array("RS01002", "N", 15, 2);
$polozky[] = array("RS01003", "N", 15, 2);
$polozky[] = array("RS01004", "N", 15, 2);
$polozky[] = array("RS01101", "N", 15, 2);
$polozky[] = array("RS01102", "N", 15, 2);
$polozky[] = array("RS01103", "N", 15, 2);
$polozky[] = array("RS01104", "N", 15, 2);
$polozky[] = array("RS01201", "N", 15, 2);
$polozky[] = array("RS01202", "N", 15, 2);
$polozky[] = array("RS01203", "N", 15, 2);
$polozky[] = array("RS01204", "N", 15, 2);
$polozky[] = array("RS01301", "N", 15, 2);
$polozky[] = array("RS01302", "N", 15, 2);
$polozky[] = array("RS01303", "N", 15, 2);
$polozky[] = array("RS01304", "N", 15, 2);
$polozky[] = array("RS01401", "N", 15, 2);
$polozky[] = array("RS01402", "N", 15, 2);
$polozky[] = array("RS01403", "N", 15, 2);
$polozky[] = array("RS01404", "N", 15, 2);
$polozky[] = array("RS01501", "N", 15, 2);
$polozky[] = array("RS01502", "N", 15, 2);
$polozky[] = array("RS01503", "N", 15, 2);
$polozky[] = array("RS01504", "N", 15, 2);
$polozky[] = array("RS01601", "N", 15, 2);
$polozky[] = array("RS01602", "N", 15, 2);
$polozky[] = array("RS01603", "N", 15, 2);
$polozky[] = array("RS01604", "N", 15, 2);
$polozky[] = array("RS01701", "N", 15, 2);
$polozky[] = array("RS01702", "N", 15, 2);
$polozky[] = array("RS01703", "N", 15, 2);
$polozky[] = array("RS01704", "N", 15, 2);
$polozky[] = array("RS01801", "N", 15, 2);
$polozky[] = array("RS01802", "N", 15, 2);
$polozky[] = array("RS01803", "N", 15, 2);
$polozky[] = array("RS01804", "N", 15, 2);
$polozky[] = array("RS01901", "N", 15, 2);
$polozky[] = array("RS01902", "N", 15, 2);
$polozky[] = array("RS01903", "N", 15, 2);
$polozky[] = array("RS01904", "N", 15, 2);
$polozky[] = array("RS02001", "N", 15, 2);
$polozky[] = array("RS02002", "N", 15, 2);
$polozky[] = array("RS02003", "N", 15, 2);
$polozky[] = array("RS02004", "N", 15, 2);
$polozky[] = array("RS02101", "N", 15, 2);
$polozky[] = array("RS02102", "N", 15, 2);
$polozky[] = array("RS02103", "N", 15, 2);
$polozky[] = array("RS02104", "N", 15, 2);
$polozky[] = array("RS02201", "N", 15, 2);
$polozky[] = array("RS02202", "N", 15, 2);
$polozky[] = array("RS02203", "N", 15, 2);
$polozky[] = array("RS02204", "N", 15, 2);
$polozky[] = array("RS02301", "N", 15, 2);
$polozky[] = array("RS02302", "N", 15, 2);
$polozky[] = array("RS02303", "N", 15, 2);
$polozky[] = array("RS02304", "N", 15, 2);
$polozky[] = array("RS02401", "N", 15, 2);
$polozky[] = array("RS02402", "N", 15, 2);
$polozky[] = array("RS02403", "N", 15, 2);
$polozky[] = array("RS02404", "N", 15, 2);
$polozky[] = array("RS02501", "N", 15, 2);
$polozky[] = array("RS02502", "N", 15, 2);
$polozky[] = array("RS02503", "N", 15, 2);
$polozky[] = array("RS02504", "N", 15, 2);
$polozky[] = array("RS02601", "N", 15, 2);
$polozky[] = array("RS02602", "N", 15, 2);
$polozky[] = array("RS02603", "N", 15, 2);
$polozky[] = array("RS02604", "N", 15, 2);
$polozky[] = array("RS02701", "N", 15, 2);
$polozky[] = array("RS02702", "N", 15, 2);
$polozky[] = array("RS02703", "N", 15, 2);
$polozky[] = array("RS02704", "N", 15, 2);
$polozky[] = array("RS02801", "N", 15, 2);
$polozky[] = array("RS02802", "N", 15, 2);
$polozky[] = array("RS02803", "N", 15, 2);
$polozky[] = array("RS02804", "N", 15, 2);
$polozky[] = array("RS02901", "N", 15, 2);
$polozky[] = array("RS02902", "N", 15, 2);
$polozky[] = array("RS02903", "N", 15, 2);
$polozky[] = array("RS02904", "N", 15, 2);
$polozky[] = array("RS03001", "N", 15, 2);
$polozky[] = array("RS03002", "N", 15, 2);
$polozky[] = array("RS03003", "N", 15, 2);
$polozky[] = array("RS03004", "N", 15, 2);
$polozky[] = array("RS03101", "N", 15, 2);
$polozky[] = array("RS03102", "N", 15, 2);
$polozky[] = array("RS03103", "N", 15, 2);
$polozky[] = array("RS03104", "N", 15, 2);
$polozky[] = array("RS03201", "N", 15, 2);
$polozky[] = array("RS03202", "N", 15, 2);
$polozky[] = array("RS03203", "N", 15, 2);
$polozky[] = array("RS03204", "N", 15, 2);
$polozky[] = array("RS03301", "N", 15, 2);
$polozky[] = array("RS03302", "N", 15, 2);
$polozky[] = array("RS03303", "N", 15, 2);
$polozky[] = array("RS03304", "N", 15, 2);
$polozky[] = array("RS03401", "N", 15, 2);
$polozky[] = array("RS03402", "N", 15, 2);
$polozky[] = array("RS03403", "N", 15, 2);
$polozky[] = array("RS03404", "N", 15, 2);
$polozky[] = array("RS03501", "N", 15, 2);
$polozky[] = array("RS03502", "N", 15, 2);
$polozky[] = array("RS03503", "N", 15, 2);
$polozky[] = array("RS03504", "N", 15, 2);
$polozky[] = array("RS03601", "N", 15, 2);
$polozky[] = array("RS03602", "N", 15, 2);
$polozky[] = array("RS03603", "N", 15, 2);
$polozky[] = array("RS03604", "N", 15, 2);
$polozky[] = array("RS03701", "N", 15, 2);
$polozky[] = array("RS03702", "N", 15, 2);
$polozky[] = array("RS03703", "N", 15, 2);
$polozky[] = array("RS03704", "N", 15, 2);
$polozky[] = array("RS03801", "N", 15, 2);
$polozky[] = array("RS03802", "N", 15, 2);
$polozky[] = array("RS03803", "N", 15, 2);
$polozky[] = array("RS03804", "N", 15, 2);
$polozky[] = array("RS03901", "N", 15, 2);
$polozky[] = array("RS03902", "N", 15, 2);
$polozky[] = array("RS03903", "N", 15, 2);
$polozky[] = array("RS03904", "N", 15, 2);
$polozky[] = array("RS04001", "N", 15, 2);
$polozky[] = array("RS04002", "N", 15, 2);
$polozky[] = array("RS04003", "N", 15, 2);
$polozky[] = array("RS04004", "N", 15, 2);

$polozky[] = array("RS04105", "N", 15, 2);
$polozky[] = array("RS04106", "N", 15, 2);

$polozky[] = array("RS04205", "N", 15, 2);
$polozky[] = array("RS04206", "N", 15, 2);

$polozky[] = array("RS04305", "N", 15, 2);
$polozky[] = array("RS04306", "N", 15, 2);

$polozky[] = array("RS04405", "N", 15, 2);
$polozky[] = array("RS04406", "N", 15, 2);
$polozky[] = array("RS04505", "N", 15, 2);
$polozky[] = array("RS04506", "N", 15, 2);
$polozky[] = array("RS04605", "N", 15, 2);
$polozky[] = array("RS04606", "N", 15, 2);
$polozky[] = array("RS04705", "N", 15, 2);
$polozky[] = array("RS04706", "N", 15, 2);
$polozky[] = array("RS04805", "N", 15, 2);
$polozky[] = array("RS04806", "N", 15, 2);
$polozky[] = array("RS04905", "N", 15, 2);
$polozky[] = array("RS04906", "N", 15, 2);
$polozky[] = array("RS05005", "N", 15, 2);
$polozky[] = array("RS05006", "N", 15, 2);
$polozky[] = array("RS05105", "N", 15, 2);
$polozky[] = array("RS05106", "N", 15, 2);
$polozky[] = array("RS05205", "N", 15, 2);
$polozky[] = array("RS05206", "N", 15, 2);
$polozky[] = array("RS05305", "N", 15, 2);
$polozky[] = array("RS05306", "N", 15, 2);
$polozky[] = array("RS05405", "N", 15, 2);
$polozky[] = array("RS05406", "N", 15, 2);
$polozky[] = array("RS05505", "N", 15, 2);
$polozky[] = array("RS05506", "N", 15, 2);
$polozky[] = array("RS05605", "N", 15, 2);
$polozky[] = array("RS05606", "N", 15, 2);
$polozky[] = array("RS05705", "N", 15, 2);
$polozky[] = array("RS05706", "N", 15, 2);
$polozky[] = array("RS05805", "N", 15, 2);
$polozky[] = array("RS05806", "N", 15, 2);
$polozky[] = array("RS05905", "N", 15, 2);
$polozky[] = array("RS05906", "N", 15, 2);
$polozky[] = array("RS06005", "N", 15, 2);
$polozky[] = array("RS06006", "N", 15, 2);
$polozky[] = array("RS06105", "N", 15, 2);
$polozky[] = array("RS06106", "N", 15, 2);
$polozky[] = array("RS06205", "N", 15, 2);
$polozky[] = array("RS06206", "N", 15, 2);

$polozky[] = array("RS06305", "N", 15, 2);
$polozky[] = array("RS06306", "N", 15, 2);
$polozky[] = array("RS06405", "N", 15, 2);
$polozky[] = array("RS06406", "N", 15, 2);
$polozky[] = array("RS06505", "N", 15, 2);
$polozky[] = array("RS06506", "N", 15, 2);
$polozky[] = array("RS06605", "N", 15, 2);
$polozky[] = array("RS06606", "N", 15, 2);
$polozky[] = array("RS06705", "N", 15, 2);
$polozky[] = array("RS06706", "N", 15, 2);
$polozky[] = array("RS06805", "N", 15, 2);
$polozky[] = array("RS06806", "N", 15, 2);
$polozky[] = array("RS06905", "N", 15, 2);
$polozky[] = array("RS06906", "N", 15, 2);
$polozky[] = array("RS07005", "N", 15, 2);
$polozky[] = array("RS07006", "N", 15, 2);

$polozky[] = array("RS07105", "N", 15, 2);
$polozky[] = array("RS07106", "N", 15, 2);

$polozky[] = array("RS07205", "N", 15, 2);
$polozky[] = array("RS07206", "N", 15, 2);

$polozky[] = array("RS07305", "N", 15, 2);
$polozky[] = array("RS07306", "N", 15, 2);

$polozky[] = array("RS07405", "N", 15, 2);
$polozky[] = array("RS07406", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN2NUJ_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN2NUJ_".$kli_uzid."_".$hhmmss.".dbf";
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

$sqlx = 'DROP TABLE fin2adbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 204nuj






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
<td>EuroSecom  -  FIN 2-04 POD DBF</td>
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
Stiahnite si nižšie uvedený súbor na Váš lokálny disk, premenujte ho na FIN2NUJ.DBF a potom naèítajte na portál www.rissam.sk :
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
