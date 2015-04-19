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


//////////////////////////////////////////////////////////// FIN 204pod
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


$sqlx = 'DROP TABLE fin2adbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin2adbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin2adbf!"."<br />";

$sqlt = <<<fin2adbf
(
okres           VARCHAR(3),
ico             VARCHAR(8),
kodob           VARCHAR(6),
datrok          VARCHAR(4),
datmes          VARCHAR(2),
typorg          VARCHAR(2),
rs00101         DECIMAL(12,2),
rs00102         DECIMAL(12,2),
rs00103         DECIMAL(12,2),
rs00104         DECIMAL(12,2),
rs00201         DECIMAL(12,2),
rs00202         DECIMAL(12,2),
rs00203         DECIMAL(12,2),
rs00204         DECIMAL(12,2),
rs00301         DECIMAL(12,2),
rs00302         DECIMAL(12,2),
rs00303         DECIMAL(12,2),
rs00304         DECIMAL(12,2),
rs00401         DECIMAL(12,2),
rs00402         DECIMAL(12,2),
rs00403         DECIMAL(12,2),
rs00404         DECIMAL(12,2),
rs00501         DECIMAL(12,2),
rs00502         DECIMAL(12,2),
rs00503         DECIMAL(12,2),
rs00504         DECIMAL(12,2),
rs00601         DECIMAL(12,2),
rs00602         DECIMAL(12,2),
rs00603         DECIMAL(12,2),
rs00604         DECIMAL(12,2),
rs00701         DECIMAL(12,2),
rs00702         DECIMAL(12,2),
rs00703         DECIMAL(12,2),
rs00704         DECIMAL(12,2),
rs00801         DECIMAL(12,2),
rs00802         DECIMAL(12,2),
rs00803         DECIMAL(12,2),
rs00804         DECIMAL(12,2),
rs00901         DECIMAL(12,2),
rs00902         DECIMAL(12,2),
rs00903         DECIMAL(12,2),
rs00904         DECIMAL(12,2),
rs01001         DECIMAL(12,2),
rs01002         DECIMAL(12,2),
rs01003         DECIMAL(12,2),
rs01004         DECIMAL(12,2),
rs01101         DECIMAL(12,2),
rs01102         DECIMAL(12,2),
rs01103         DECIMAL(12,2),
rs01104         DECIMAL(12,2),
rs01201         DECIMAL(12,2),
rs01202         DECIMAL(12,2),
rs01203         DECIMAL(12,2),
rs01204         DECIMAL(12,2),
rs01301         DECIMAL(12,2),
rs01302         DECIMAL(12,2),
rs01303         DECIMAL(12,2),
rs01304         DECIMAL(12,2),
rs01401         DECIMAL(12,2),
rs01402         DECIMAL(12,2),
rs01403         DECIMAL(12,2),
rs01404         DECIMAL(12,2),
rs01501         DECIMAL(12,2),
rs01502         DECIMAL(12,2),
rs01503         DECIMAL(12,2),
rs01504         DECIMAL(12,2),
rs01601         DECIMAL(12,2),
rs01602         DECIMAL(12,2),
rs01603         DECIMAL(12,2),
rs01604         DECIMAL(12,2),
rs01701         DECIMAL(12,2),
rs01702         DECIMAL(12,2),
rs01703         DECIMAL(12,2),
rs01704         DECIMAL(12,2),
rs01801         DECIMAL(12,2),
rs01802         DECIMAL(12,2),
rs01803         DECIMAL(12,2),
rs01804         DECIMAL(12,2),
rs01901         DECIMAL(12,2),
rs01902         DECIMAL(12,2),
rs01903         DECIMAL(12,2),
rs01904         DECIMAL(12,2),
rs02001         DECIMAL(12,2),
rs02002         DECIMAL(12,2),
rs02003         DECIMAL(12,2),
rs02004         DECIMAL(12,2),
rs02101         DECIMAL(12,2),
rs02102         DECIMAL(12,2),
rs02103         DECIMAL(12,2),
rs02104         DECIMAL(12,2),
rs02201         DECIMAL(12,2),
rs02202         DECIMAL(12,2),
rs02203         DECIMAL(12,2),
rs02204         DECIMAL(12,2),
rs02301         DECIMAL(12,2),
rs02302         DECIMAL(12,2),
rs02303         DECIMAL(12,2),
rs02304         DECIMAL(12,2),
rs02401         DECIMAL(12,2),
rs02402         DECIMAL(12,2),
rs02403         DECIMAL(12,2),
rs02404         DECIMAL(12,2),
rs02501         DECIMAL(12,2),
rs02502         DECIMAL(12,2),
rs02503         DECIMAL(12,2),
rs02504         DECIMAL(12,2),
rs02601         DECIMAL(12,2),
rs02602         DECIMAL(12,2),
rs02603         DECIMAL(12,2),
rs02604         DECIMAL(12,2),
rs02701         DECIMAL(12,2),
rs02702         DECIMAL(12,2),
rs02703         DECIMAL(12,2),
rs02704         DECIMAL(12,2),
rs02801         DECIMAL(12,2),
rs02802         DECIMAL(12,2),
rs02803         DECIMAL(12,2),
rs02804         DECIMAL(12,2),
rs02901         DECIMAL(12,2),
rs02902         DECIMAL(12,2),
rs02903         DECIMAL(12,2),
rs02904         DECIMAL(12,2),
rs03001         DECIMAL(12,2),
rs03002         DECIMAL(12,2),
rs03003         DECIMAL(12,2),
rs03004         DECIMAL(12,2),
rs03101         DECIMAL(12,2),
rs03102         DECIMAL(12,2),
rs03103         DECIMAL(12,2),
rs03104         DECIMAL(12,2),
rs03201         DECIMAL(12,2),
rs03202         DECIMAL(12,2),
rs03203         DECIMAL(12,2),
rs03204         DECIMAL(12,2),
rs03301         DECIMAL(12,2),
rs03302         DECIMAL(12,2),
rs03303         DECIMAL(12,2),
rs03304         DECIMAL(12,2),
rs03401         DECIMAL(12,2),
rs03402         DECIMAL(12,2),
rs03403         DECIMAL(12,2),
rs03404         DECIMAL(12,2),
rs03501         DECIMAL(12,2),
rs03502         DECIMAL(12,2),
rs03503         DECIMAL(12,2),
rs03504         DECIMAL(12,2),
rs03601         DECIMAL(12,2),
rs03602         DECIMAL(12,2),
rs03603         DECIMAL(12,2),
rs03604         DECIMAL(12,2),
rs03701         DECIMAL(12,2),
rs03702         DECIMAL(12,2),
rs03703         DECIMAL(12,2),
rs03704         DECIMAL(12,2),
rs03801         DECIMAL(12,2),
rs03802         DECIMAL(12,2),
rs03803         DECIMAL(12,2),
rs03804         DECIMAL(12,2),
rs03901         DECIMAL(12,2),
rs03902         DECIMAL(12,2),
rs03903         DECIMAL(12,2),
rs03904         DECIMAL(12,2),
rs04001         DECIMAL(12,2),
rs04002         DECIMAL(12,2),
rs04003         DECIMAL(12,2),
rs04004         DECIMAL(12,2),

rs04101         DECIMAL(12,2),
rs04102         DECIMAL(12,2),
rs04103         DECIMAL(12,2),
rs04104         DECIMAL(12,2),

rs04201         DECIMAL(12,2),
rs04202         DECIMAL(12,2),
rs04203         DECIMAL(12,2),
rs04204         DECIMAL(12,2),

rs04301         DECIMAL(12,2),
rs04302         DECIMAL(12,2),
rs04303         DECIMAL(12,2),
rs04304         DECIMAL(12,2),

rs04405         DECIMAL(12,2),
rs04406         DECIMAL(12,2),
rs04505         DECIMAL(12,2),
rs04506         DECIMAL(12,2),
rs04605         DECIMAL(12,2),
rs04606         DECIMAL(12,2),
rs04705         DECIMAL(12,2),
rs04706         DECIMAL(12,2),
rs04805         DECIMAL(12,2),
rs04806         DECIMAL(12,2),
rs04905         DECIMAL(12,2),
rs04906         DECIMAL(12,2),
rs05005         DECIMAL(12,2),
rs05006         DECIMAL(12,2),
rs05105         DECIMAL(12,2),
rs05106         DECIMAL(12,2),
rs05205         DECIMAL(12,2),
rs05206         DECIMAL(12,2),
rs05305         DECIMAL(12,2),
rs05306         DECIMAL(12,2),
rs05405         DECIMAL(12,2),
rs05406         DECIMAL(12,2),
rs05505         DECIMAL(12,2),
rs05506         DECIMAL(12,2),
rs05605         DECIMAL(12,2),
rs05606         DECIMAL(12,2),
rs05705         DECIMAL(12,2),
rs05706         DECIMAL(12,2),
rs05805         DECIMAL(12,2),
rs05806         DECIMAL(12,2),
rs05905         DECIMAL(12,2),
rs05906         DECIMAL(12,2),
rs06005         DECIMAL(12,2),
rs06006         DECIMAL(12,2),
rs06105         DECIMAL(12,2),
rs06106         DECIMAL(12,2),
rs06205         DECIMAL(12,2),
rs06206         DECIMAL(12,2),
rs06305         DECIMAL(12,2),
rs06306         DECIMAL(12,2),
rs06405         DECIMAL(12,2),
rs06406         DECIMAL(12,2),
rs06505         DECIMAL(12,2),
rs06506         DECIMAL(12,2),
rs06605         DECIMAL(12,2),
rs06606         DECIMAL(12,2),
rs06705         DECIMAL(12,2),
rs06706         DECIMAL(12,2),
rs06805         DECIMAL(12,2),
rs06806         DECIMAL(12,2),
rs06905         DECIMAL(12,2),
rs06906         DECIMAL(12,2),
rs07005         DECIMAL(12,2),
rs07006         DECIMAL(12,2),

rs07105         DECIMAL(12,2),
rs07106         DECIMAL(12,2),

rs07205         DECIMAL(12,2),
rs07206         DECIMAL(12,2),

rs07305         DECIMAL(12,2),
rs07306         DECIMAL(12,2),

rs07405         DECIMAL(12,2),
rs07406         DECIMAL(12,2)
);
fin2adbf;

$sqlx = 'CREATE TABLE fin2adbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


$ttvv = "INSERT INTO fin2adbf ( okres, ico, kodob, datrok, datmes, typorg, rs00101  ) ".
" VALUES ( '205', '00310000', '504831', '2010', '03', '22', '65932'  )";
//$ttqq = mysql_query("$ttvv");

}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO fin2adbf "." SELECT".
" okres,'$fir_ficox',obec,'$kli_vrok','$mesiac','$typorg',".
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
" r41,rk41,rn41,rm41,".
" r42,rk42,rn42,rm42,".
" r43,rk43,rn43,rm43,".
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
" r74,rm74  ".

" FROM F$kli_vxcf"."_uctvykaz_fin204pod".
" WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin2adbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("okres", "C", 3);
$polozky[] = array("ico", "C", 8);
$polozky[] = array("kodob", "C", 6);
$polozky[] = array("datrok", "C", 4);
$polozky[] = array("datmes", "C", 2);
$polozky[] = array("typorg", "C", 2);
$polozky[] = array("rs00101", "N", 15, 2);
$polozky[] = array("rs00102", "N", 15, 2);
$polozky[] = array("rs00103", "N", 15, 2);
$polozky[] = array("rs00104", "N", 15, 2);
$polozky[] = array("rs00201", "N", 15, 2);
$polozky[] = array("rs00202", "N", 15, 2);
$polozky[] = array("rs00203", "N", 15, 2);
$polozky[] = array("rs00204", "N", 15, 2);
$polozky[] = array("rs00301", "N", 15, 2);
$polozky[] = array("rs00302", "N", 15, 2);
$polozky[] = array("rs00303", "N", 15, 2);
$polozky[] = array("rs00304", "N", 15, 2);
$polozky[] = array("rs00401", "N", 15, 2);
$polozky[] = array("rs00402", "N", 15, 2);
$polozky[] = array("rs00403", "N", 15, 2);
$polozky[] = array("rs00404", "N", 15, 2);
$polozky[] = array("rs00501", "N", 15, 2);
$polozky[] = array("rs00502", "N", 15, 2);
$polozky[] = array("rs00503", "N", 15, 2);
$polozky[] = array("rs00504", "N", 15, 2);
$polozky[] = array("rs00601", "N", 15, 2);
$polozky[] = array("rs00602", "N", 15, 2);
$polozky[] = array("rs00603", "N", 15, 2);
$polozky[] = array("rs00604", "N", 15, 2);
$polozky[] = array("rs00701", "N", 15, 2);
$polozky[] = array("rs00702", "N", 15, 2);
$polozky[] = array("rs00703", "N", 15, 2);
$polozky[] = array("rs00704", "N", 15, 2);
$polozky[] = array("rs00801", "N", 15, 2);
$polozky[] = array("rs00802", "N", 15, 2);
$polozky[] = array("rs00803", "N", 15, 2);
$polozky[] = array("rs00804", "N", 15, 2);
$polozky[] = array("rs00901", "N", 15, 2);
$polozky[] = array("rs00902", "N", 15, 2);
$polozky[] = array("rs00903", "N", 15, 2);
$polozky[] = array("rs00904", "N", 15, 2);
$polozky[] = array("rs01001", "N", 15, 2);
$polozky[] = array("rs01002", "N", 15, 2);
$polozky[] = array("rs01003", "N", 15, 2);
$polozky[] = array("rs01004", "N", 15, 2);
$polozky[] = array("rs01101", "N", 15, 2);
$polozky[] = array("rs01102", "N", 15, 2);
$polozky[] = array("rs01103", "N", 15, 2);
$polozky[] = array("rs01104", "N", 15, 2);
$polozky[] = array("rs01201", "N", 15, 2);
$polozky[] = array("rs01202", "N", 15, 2);
$polozky[] = array("rs01203", "N", 15, 2);
$polozky[] = array("rs01204", "N", 15, 2);
$polozky[] = array("rs01301", "N", 15, 2);
$polozky[] = array("rs01302", "N", 15, 2);
$polozky[] = array("rs01303", "N", 15, 2);
$polozky[] = array("rs01304", "N", 15, 2);
$polozky[] = array("rs01401", "N", 15, 2);
$polozky[] = array("rs01402", "N", 15, 2);
$polozky[] = array("rs01403", "N", 15, 2);
$polozky[] = array("rs01404", "N", 15, 2);
$polozky[] = array("rs01501", "N", 15, 2);
$polozky[] = array("rs01502", "N", 15, 2);
$polozky[] = array("rs01503", "N", 15, 2);
$polozky[] = array("rs01504", "N", 15, 2);
$polozky[] = array("rs01601", "N", 15, 2);
$polozky[] = array("rs01602", "N", 15, 2);
$polozky[] = array("rs01603", "N", 15, 2);
$polozky[] = array("rs01604", "N", 15, 2);
$polozky[] = array("rs01701", "N", 15, 2);
$polozky[] = array("rs01702", "N", 15, 2);
$polozky[] = array("rs01703", "N", 15, 2);
$polozky[] = array("rs01704", "N", 15, 2);
$polozky[] = array("rs01801", "N", 15, 2);
$polozky[] = array("rs01802", "N", 15, 2);
$polozky[] = array("rs01803", "N", 15, 2);
$polozky[] = array("rs01804", "N", 15, 2);
$polozky[] = array("rs01901", "N", 15, 2);
$polozky[] = array("rs01902", "N", 15, 2);
$polozky[] = array("rs01903", "N", 15, 2);
$polozky[] = array("rs01904", "N", 15, 2);
$polozky[] = array("rs02001", "N", 15, 2);
$polozky[] = array("rs02002", "N", 15, 2);
$polozky[] = array("rs02003", "N", 15, 2);
$polozky[] = array("rs02004", "N", 15, 2);
$polozky[] = array("rs02101", "N", 15, 2);
$polozky[] = array("rs02102", "N", 15, 2);
$polozky[] = array("rs02103", "N", 15, 2);
$polozky[] = array("rs02104", "N", 15, 2);
$polozky[] = array("rs02201", "N", 15, 2);
$polozky[] = array("rs02202", "N", 15, 2);
$polozky[] = array("rs02203", "N", 15, 2);
$polozky[] = array("rs02204", "N", 15, 2);
$polozky[] = array("rs02301", "N", 15, 2);
$polozky[] = array("rs02302", "N", 15, 2);
$polozky[] = array("rs02303", "N", 15, 2);
$polozky[] = array("rs02304", "N", 15, 2);
$polozky[] = array("rs02401", "N", 15, 2);
$polozky[] = array("rs02402", "N", 15, 2);
$polozky[] = array("rs02403", "N", 15, 2);
$polozky[] = array("rs02404", "N", 15, 2);
$polozky[] = array("rs02501", "N", 15, 2);
$polozky[] = array("rs02502", "N", 15, 2);
$polozky[] = array("rs02503", "N", 15, 2);
$polozky[] = array("rs02504", "N", 15, 2);
$polozky[] = array("rs02601", "N", 15, 2);
$polozky[] = array("rs02602", "N", 15, 2);
$polozky[] = array("rs02603", "N", 15, 2);
$polozky[] = array("rs02604", "N", 15, 2);
$polozky[] = array("rs02701", "N", 15, 2);
$polozky[] = array("rs02702", "N", 15, 2);
$polozky[] = array("rs02703", "N", 15, 2);
$polozky[] = array("rs02704", "N", 15, 2);
$polozky[] = array("rs02801", "N", 15, 2);
$polozky[] = array("rs02802", "N", 15, 2);
$polozky[] = array("rs02803", "N", 15, 2);
$polozky[] = array("rs02804", "N", 15, 2);
$polozky[] = array("rs02901", "N", 15, 2);
$polozky[] = array("rs02902", "N", 15, 2);
$polozky[] = array("rs02903", "N", 15, 2);
$polozky[] = array("rs02904", "N", 15, 2);
$polozky[] = array("rs03001", "N", 15, 2);
$polozky[] = array("rs03002", "N", 15, 2);
$polozky[] = array("rs03003", "N", 15, 2);
$polozky[] = array("rs03004", "N", 15, 2);
$polozky[] = array("rs03101", "N", 15, 2);
$polozky[] = array("rs03102", "N", 15, 2);
$polozky[] = array("rs03103", "N", 15, 2);
$polozky[] = array("rs03104", "N", 15, 2);
$polozky[] = array("rs03201", "N", 15, 2);
$polozky[] = array("rs03202", "N", 15, 2);
$polozky[] = array("rs03203", "N", 15, 2);
$polozky[] = array("rs03204", "N", 15, 2);
$polozky[] = array("rs03301", "N", 15, 2);
$polozky[] = array("rs03302", "N", 15, 2);
$polozky[] = array("rs03303", "N", 15, 2);
$polozky[] = array("rs03304", "N", 15, 2);
$polozky[] = array("rs03401", "N", 15, 2);
$polozky[] = array("rs03402", "N", 15, 2);
$polozky[] = array("rs03403", "N", 15, 2);
$polozky[] = array("rs03404", "N", 15, 2);
$polozky[] = array("rs03501", "N", 15, 2);
$polozky[] = array("rs03502", "N", 15, 2);
$polozky[] = array("rs03503", "N", 15, 2);
$polozky[] = array("rs03504", "N", 15, 2);
$polozky[] = array("rs03601", "N", 15, 2);
$polozky[] = array("rs03602", "N", 15, 2);
$polozky[] = array("rs03603", "N", 15, 2);
$polozky[] = array("rs03604", "N", 15, 2);
$polozky[] = array("rs03701", "N", 15, 2);
$polozky[] = array("rs03702", "N", 15, 2);
$polozky[] = array("rs03703", "N", 15, 2);
$polozky[] = array("rs03704", "N", 15, 2);
$polozky[] = array("rs03801", "N", 15, 2);
$polozky[] = array("rs03802", "N", 15, 2);
$polozky[] = array("rs03803", "N", 15, 2);
$polozky[] = array("rs03804", "N", 15, 2);
$polozky[] = array("rs03901", "N", 15, 2);
$polozky[] = array("rs03902", "N", 15, 2);
$polozky[] = array("rs03903", "N", 15, 2);
$polozky[] = array("rs03904", "N", 15, 2);
$polozky[] = array("rs04001", "N", 15, 2);
$polozky[] = array("rs04002", "N", 15, 2);
$polozky[] = array("rs04003", "N", 15, 2);
$polozky[] = array("rs04004", "N", 15, 2);

$polozky[] = array("rs04101", "N", 15, 2);
$polozky[] = array("rs04102", "N", 15, 2);
$polozky[] = array("rs04103", "N", 15, 2);
$polozky[] = array("rs04104", "N", 15, 2);

$polozky[] = array("rs04201", "N", 15, 2);
$polozky[] = array("rs04202", "N", 15, 2);
$polozky[] = array("rs04203", "N", 15, 2);
$polozky[] = array("rs04204", "N", 15, 2);

$polozky[] = array("rs04301", "N", 15, 2);
$polozky[] = array("rs04302", "N", 15, 2);
$polozky[] = array("rs04303", "N", 15, 2);
$polozky[] = array("rs04304", "N", 15, 2);

$polozky[] = array("rs04405", "N", 15, 2);
$polozky[] = array("rs04406", "N", 15, 2);
$polozky[] = array("rs04505", "N", 15, 2);
$polozky[] = array("rs04506", "N", 15, 2);
$polozky[] = array("rs04605", "N", 15, 2);
$polozky[] = array("rs04606", "N", 15, 2);
$polozky[] = array("rs04705", "N", 15, 2);
$polozky[] = array("rs04706", "N", 15, 2);
$polozky[] = array("rs04805", "N", 15, 2);
$polozky[] = array("rs04806", "N", 15, 2);
$polozky[] = array("rs04905", "N", 15, 2);
$polozky[] = array("rs04906", "N", 15, 2);
$polozky[] = array("rs05005", "N", 15, 2);
$polozky[] = array("rs05006", "N", 15, 2);
$polozky[] = array("rs05105", "N", 15, 2);
$polozky[] = array("rs05106", "N", 15, 2);
$polozky[] = array("rs05205", "N", 15, 2);
$polozky[] = array("rs05206", "N", 15, 2);
$polozky[] = array("rs05305", "N", 15, 2);
$polozky[] = array("rs05306", "N", 15, 2);
$polozky[] = array("rs05405", "N", 15, 2);
$polozky[] = array("rs05406", "N", 15, 2);
$polozky[] = array("rs05505", "N", 15, 2);
$polozky[] = array("rs05506", "N", 15, 2);
$polozky[] = array("rs05605", "N", 15, 2);
$polozky[] = array("rs05606", "N", 15, 2);
$polozky[] = array("rs05705", "N", 15, 2);
$polozky[] = array("rs05706", "N", 15, 2);
$polozky[] = array("rs05805", "N", 15, 2);
$polozky[] = array("rs05806", "N", 15, 2);
$polozky[] = array("rs05905", "N", 15, 2);
$polozky[] = array("rs05906", "N", 15, 2);
$polozky[] = array("rs06005", "N", 15, 2);
$polozky[] = array("rs06006", "N", 15, 2);
$polozky[] = array("rs06105", "N", 15, 2);
$polozky[] = array("rs06106", "N", 15, 2);
$polozky[] = array("rs06205", "N", 15, 2);
$polozky[] = array("rs06206", "N", 15, 2);

$polozky[] = array("rs06305", "N", 15, 2);
$polozky[] = array("rs06306", "N", 15, 2);
$polozky[] = array("rs06405", "N", 15, 2);
$polozky[] = array("rs06406", "N", 15, 2);
$polozky[] = array("rs06505", "N", 15, 2);
$polozky[] = array("rs06506", "N", 15, 2);
$polozky[] = array("rs06605", "N", 15, 2);
$polozky[] = array("rs06606", "N", 15, 2);
$polozky[] = array("rs06705", "N", 15, 2);
$polozky[] = array("rs06706", "N", 15, 2);
$polozky[] = array("rs06805", "N", 15, 2);
$polozky[] = array("rs06806", "N", 15, 2);
$polozky[] = array("rs06905", "N", 15, 2);
$polozky[] = array("rs06906", "N", 15, 2);
$polozky[] = array("rs07005", "N", 15, 2);
$polozky[] = array("rs07006", "N", 15, 2);

$polozky[] = array("rs07105", "N", 15, 2);
$polozky[] = array("rs07106", "N", 15, 2);

$polozky[] = array("rs07205", "N", 15, 2);
$polozky[] = array("rs07206", "N", 15, 2);

$polozky[] = array("rs07305", "N", 15, 2);
$polozky[] = array("rs07306", "N", 15, 2);

$polozky[] = array("rs07405", "N", 15, 2);
$polozky[] = array("rs07406", "N", 15, 2);

// Získáme unikátní název DBF souboru
$nazev_souboru = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru = "../tmp/fin2pod.dbf";
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
//header("Content-Disposition: attachment; filename=fin2pod.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin2adbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 204pod






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
Stiahnite si nižšie uvedený súbor na Váš lokálny disk  :
<br />
<br />
<a href="../tmp/fin2pod.dbf">fin2pod.dbf</a>


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
