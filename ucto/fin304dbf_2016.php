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


/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN3A1.DBF
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

$sqlt = <<<fin3adbf
(
FIN3A1.DBF
ICO CHARACTER 8 IÈO
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organizácie (“02“ – príspevková organizácia
“11“ – rozpoètová organizácia
“22“ – obec
“23“ – mesto
“31“ – nezisková inštitúcia
“51“ – obchodná spoloènos)
RS00101 NUMERIC (15,2) údajová èas
RS00102 NUMERIC (15,2)
RS00103 NUMERIC (15,2)
RS00104 NUMERIC (15,2)
RS00105 NUMERIC (15,2)
RS00106 NUMERIC (15,2)
RS00107 NUMERIC (15,2)
RS00108 NUMERIC (15,2)
RS00109 NUMERIC (15,2)
RS00110 NUMERIC (15,2)
.
.
.
RS02501 NUMERIC (15,2)
RS02502 NUMERIC (15,2)
RS02503 NUMERIC (15,2)
RS02504 NUMERIC (15,2)
RS02505 NUMERIC (15,2)
RS02506 NUMERIC (15,2)
RS02507 NUMERIC (15,2)
RS02508 NUMERIC (15,2)
RS02509 NUMERIC (15,2)
RS02510 NUMERIC (15,2)
);
fin3adbf;

$sqlx = 'DROP TABLE fin3adbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin3adbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin3adbf!"."<br />";

$sqlt = <<<fin3adbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),

RS00101         DECIMAL(12,2),
RS00102         DECIMAL(12,2),
RS00103         DECIMAL(12,2),
RS00104         DECIMAL(12,2),
RS00105         DECIMAL(12,2),
RS00106         DECIMAL(12,2),
RS00107         DECIMAL(12,2),
RS00108         DECIMAL(12,2),
RS00109         DECIMAL(12,2),
RS00110         DECIMAL(12,2),
RS00201         DECIMAL(12,2),
RS00202         DECIMAL(12,2),
RS00203         DECIMAL(12,2),
RS00204         DECIMAL(12,2),
RS00205         DECIMAL(12,2),
RS00206         DECIMAL(12,2),
RS00207         DECIMAL(12,2),
RS00208         DECIMAL(12,2),
RS00209         DECIMAL(12,2),
RS00210         DECIMAL(12,2),
RS00301         DECIMAL(12,2),
RS00302         DECIMAL(12,2),
RS00303         DECIMAL(12,2),
RS00304         DECIMAL(12,2),
RS00305         DECIMAL(12,2),
RS00306         DECIMAL(12,2),
RS00307         DECIMAL(12,2),
RS00308         DECIMAL(12,2),
RS00309         DECIMAL(12,2),
RS00310         DECIMAL(12,2),
RS00401         DECIMAL(12,2),
RS00402         DECIMAL(12,2),
RS00403         DECIMAL(12,2),
RS00404         DECIMAL(12,2),
RS00405         DECIMAL(12,2),
RS00406         DECIMAL(12,2),
RS00407         DECIMAL(12,2),
RS00408         DECIMAL(12,2),
RS00409         DECIMAL(12,2),
RS00410         DECIMAL(12,2),
RS00501         DECIMAL(12,2),
RS00502         DECIMAL(12,2),
RS00503         DECIMAL(12,2),
RS00504         DECIMAL(12,2),
RS00505         DECIMAL(12,2),
RS00506         DECIMAL(12,2),
RS00507         DECIMAL(12,2),
RS00508         DECIMAL(12,2),
RS00509         DECIMAL(12,2),
RS00510         DECIMAL(12,2),
RS00601         DECIMAL(12,2),
RS00602         DECIMAL(12,2),
RS00603         DECIMAL(12,2),
RS00604         DECIMAL(12,2),
RS00605         DECIMAL(12,2),
RS00606         DECIMAL(12,2),
RS00607         DECIMAL(12,2),
RS00608         DECIMAL(12,2),
RS00609         DECIMAL(12,2),
RS00610         DECIMAL(12,2),
RS00701         DECIMAL(12,2),
RS00702         DECIMAL(12,2),
RS00703         DECIMAL(12,2),
RS00704         DECIMAL(12,2),
RS00705         DECIMAL(12,2),
RS00706         DECIMAL(12,2),
RS00707         DECIMAL(12,2),
RS00708         DECIMAL(12,2),
RS00709         DECIMAL(12,2),
RS00710         DECIMAL(12,2),
RS00801         DECIMAL(12,2),
RS00802         DECIMAL(12,2),
RS00803         DECIMAL(12,2),
RS00804         DECIMAL(12,2),
RS00805         DECIMAL(12,2),
RS00806         DECIMAL(12,2),
RS00807         DECIMAL(12,2),
RS00808         DECIMAL(12,2),
RS00809         DECIMAL(12,2),
RS00810         DECIMAL(12,2),
RS00901         DECIMAL(12,2),
RS00902         DECIMAL(12,2),
RS00903         DECIMAL(12,2),
RS00904         DECIMAL(12,2),
RS00905         DECIMAL(12,2),
RS00906         DECIMAL(12,2),
RS00907         DECIMAL(12,2),
RS00908         DECIMAL(12,2),
RS00909         DECIMAL(12,2),
RS00910         DECIMAL(12,2),
RS01001         DECIMAL(12,2),
RS01002         DECIMAL(12,2),
RS01003         DECIMAL(12,2),
RS01004         DECIMAL(12,2),
RS01005         DECIMAL(12,2),
RS01006         DECIMAL(12,2),
RS01007         DECIMAL(12,2),
RS01008         DECIMAL(12,2),
RS01009         DECIMAL(12,2),
RS01010         DECIMAL(12,2),

RS01101         DECIMAL(12,2),
RS01102         DECIMAL(12,2),
RS01103         DECIMAL(12,2),
RS01104         DECIMAL(12,2),
RS01105         DECIMAL(12,2),
RS01106         DECIMAL(12,2),
RS01107         DECIMAL(12,2),
RS01108         DECIMAL(12,2),
RS01109         DECIMAL(12,2),
RS01110         DECIMAL(12,2),
RS01201         DECIMAL(12,2),
RS01202         DECIMAL(12,2),
RS01203         DECIMAL(12,2),
RS01204         DECIMAL(12,2),
RS01205         DECIMAL(12,2),
RS01206         DECIMAL(12,2),
RS01207         DECIMAL(12,2),
RS01208         DECIMAL(12,2),
RS01209         DECIMAL(12,2),
RS01210         DECIMAL(12,2),
RS01301         DECIMAL(12,2),
RS01302         DECIMAL(12,2),
RS01303         DECIMAL(12,2),
RS01304         DECIMAL(12,2),
RS01305         DECIMAL(12,2),
RS01306         DECIMAL(12,2),
RS01307         DECIMAL(12,2),
RS01308         DECIMAL(12,2),
RS01309         DECIMAL(12,2),
RS01310         DECIMAL(12,2),
RS01401         DECIMAL(12,2),
RS01402         DECIMAL(12,2),
RS01403         DECIMAL(12,2),
RS01404         DECIMAL(12,2),
RS01405         DECIMAL(12,2),
RS01406         DECIMAL(12,2),
RS01407         DECIMAL(12,2),
RS01408         DECIMAL(12,2),
RS01409         DECIMAL(12,2),
RS01410         DECIMAL(12,2),
RS01501         DECIMAL(12,2),
RS01502         DECIMAL(12,2),
RS01503         DECIMAL(12,2),
RS01504         DECIMAL(12,2),
RS01505         DECIMAL(12,2),
RS01506         DECIMAL(12,2),
RS01507         DECIMAL(12,2),
RS01508         DECIMAL(12,2),
RS01509         DECIMAL(12,2),
RS01510         DECIMAL(12,2),
RS01601         DECIMAL(12,2),
RS01602         DECIMAL(12,2),
RS01603         DECIMAL(12,2),
RS01604         DECIMAL(12,2),
RS01605         DECIMAL(12,2),
RS01606         DECIMAL(12,2),
RS01607         DECIMAL(12,2),
RS01608         DECIMAL(12,2),
RS01609         DECIMAL(12,2),
RS01610         DECIMAL(12,2),
RS01701         DECIMAL(12,2),
RS01702         DECIMAL(12,2),
RS01703         DECIMAL(12,2),
RS01704         DECIMAL(12,2),
RS01705         DECIMAL(12,2),
RS01706         DECIMAL(12,2),
RS01707         DECIMAL(12,2),
RS01708         DECIMAL(12,2),
RS01709         DECIMAL(12,2),
RS01710         DECIMAL(12,2),
RS01801         DECIMAL(12,2),
RS01802         DECIMAL(12,2),
RS01803         DECIMAL(12,2),
RS01804         DECIMAL(12,2),
RS01805         DECIMAL(12,2),
RS01806         DECIMAL(12,2),
RS01807         DECIMAL(12,2),
RS01808         DECIMAL(12,2),
RS01809         DECIMAL(12,2),
RS01810         DECIMAL(12,2),
RS01901         DECIMAL(12,2),
RS01902         DECIMAL(12,2),
RS01903         DECIMAL(12,2),
RS01904         DECIMAL(12,2),
RS01905         DECIMAL(12,2),
RS01906         DECIMAL(12,2),
RS01907         DECIMAL(12,2),
RS01908         DECIMAL(12,2),
RS01909         DECIMAL(12,2),
RS01910         DECIMAL(12,2),
RS02001         DECIMAL(12,2),
RS02002         DECIMAL(12,2),
RS02003         DECIMAL(12,2),
RS02004         DECIMAL(12,2),
RS02005         DECIMAL(12,2),
RS02006         DECIMAL(12,2),
RS02007         DECIMAL(12,2),
RS02008         DECIMAL(12,2),
RS02009         DECIMAL(12,2),
RS02010         DECIMAL(12,2),

RS02101         DECIMAL(12,2),
RS02102         DECIMAL(12,2),
RS02103         DECIMAL(12,2),
RS02104         DECIMAL(12,2),
RS02105         DECIMAL(12,2),
RS02106         DECIMAL(12,2),
RS02107         DECIMAL(12,2),
RS02108         DECIMAL(12,2),
RS02109         DECIMAL(12,2),
RS02110         DECIMAL(12,2),
RS02201         DECIMAL(12,2),
RS02202         DECIMAL(12,2),
RS02203         DECIMAL(12,2),
RS02204         DECIMAL(12,2),
RS02205         DECIMAL(12,2),
RS02206         DECIMAL(12,2),
RS02207         DECIMAL(12,2),
RS02208         DECIMAL(12,2),
RS02209         DECIMAL(12,2),
RS02210         DECIMAL(12,2),
RS02301         DECIMAL(12,2),
RS02302         DECIMAL(12,2),
RS02303         DECIMAL(12,2),
RS02304         DECIMAL(12,2),
RS02305         DECIMAL(12,2),
RS02306         DECIMAL(12,2),
RS02307         DECIMAL(12,2),
RS02308         DECIMAL(12,2),
RS02309         DECIMAL(12,2),
RS02310         DECIMAL(12,2),
RS02401         DECIMAL(12,2),
RS02402         DECIMAL(12,2),
RS02403         DECIMAL(12,2),
RS02404         DECIMAL(12,2),
RS02405         DECIMAL(12,2),
RS02406         DECIMAL(12,2),
RS02407         DECIMAL(12,2),
RS02408         DECIMAL(12,2),
RS02409         DECIMAL(12,2),
RS02410         DECIMAL(12,2),
RS02501         DECIMAL(12,2),
RS02502         DECIMAL(12,2),
RS02503         DECIMAL(12,2),
RS02504         DECIMAL(12,2),
RS02505         DECIMAL(12,2),
RS02506         DECIMAL(12,2),
RS02507         DECIMAL(12,2),
RS02508         DECIMAL(12,2),
RS02509         DECIMAL(12,2),
RS02510         DECIMAL(12,2)


);
fin3adbf;

$sqlx = 'CREATE TABLE fin3adbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia


//vloz vykaz do vytvorenej databazy riadky 1,6,8,13,18,20,25
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".

$dsqlt = "INSERT INTO fin3adbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".
"0,0,0,0,0,0,0,0,0,0,".
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".
"0,0,0,0,0,0,0,0,0,0,".
"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10) ".

" FROM F$kli_vxcf"."_uctvykaz_fin304".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin3adbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);

$polozky[] = array("RS00101", "N", 15, 2);
$polozky[] = array("RS00102", "N", 15, 2);
$polozky[] = array("RS00103", "N", 15, 2);
$polozky[] = array("RS00104", "N", 15, 2);
$polozky[] = array("RS00105", "N", 15, 2);
$polozky[] = array("RS00106", "N", 15, 2);
$polozky[] = array("RS00107", "N", 15, 2);
$polozky[] = array("RS00108", "N", 15, 2);
$polozky[] = array("RS00109", "N", 15, 2);
$polozky[] = array("RS00110", "N", 15, 2);
$polozky[] = array("RS00201", "N", 15, 2);
$polozky[] = array("RS00202", "N", 15, 2);
$polozky[] = array("RS00203", "N", 15, 2);
$polozky[] = array("RS00204", "N", 15, 2);
$polozky[] = array("RS00205", "N", 15, 2);
$polozky[] = array("RS00206", "N", 15, 2);
$polozky[] = array("RS00207", "N", 15, 2);
$polozky[] = array("RS00208", "N", 15, 2);
$polozky[] = array("RS00209", "N", 15, 2);
$polozky[] = array("RS00210", "N", 15, 2);
$polozky[] = array("RS00301", "N", 15, 2);
$polozky[] = array("RS00302", "N", 15, 2);
$polozky[] = array("RS00303", "N", 15, 2);
$polozky[] = array("RS00304", "N", 15, 2);
$polozky[] = array("RS00305", "N", 15, 2);
$polozky[] = array("RS00306", "N", 15, 2);
$polozky[] = array("RS00307", "N", 15, 2);
$polozky[] = array("RS00308", "N", 15, 2);
$polozky[] = array("RS00309", "N", 15, 2);
$polozky[] = array("RS00310", "N", 15, 2);
$polozky[] = array("RS00401", "N", 15, 2);
$polozky[] = array("RS00402", "N", 15, 2);
$polozky[] = array("RS00403", "N", 15, 2);
$polozky[] = array("RS00404", "N", 15, 2);
$polozky[] = array("RS00405", "N", 15, 2);
$polozky[] = array("RS00406", "N", 15, 2);
$polozky[] = array("RS00407", "N", 15, 2);
$polozky[] = array("RS00408", "N", 15, 2);
$polozky[] = array("RS00409", "N", 15, 2);
$polozky[] = array("RS00410", "N", 15, 2);
$polozky[] = array("RS00501", "N", 15, 2);
$polozky[] = array("RS00502", "N", 15, 2);
$polozky[] = array("RS00503", "N", 15, 2);
$polozky[] = array("RS00504", "N", 15, 2);
$polozky[] = array("RS00505", "N", 15, 2);
$polozky[] = array("RS00506", "N", 15, 2);
$polozky[] = array("RS00507", "N", 15, 2);
$polozky[] = array("RS00508", "N", 15, 2);
$polozky[] = array("RS00509", "N", 15, 2);
$polozky[] = array("RS00510", "N", 15, 2);
$polozky[] = array("RS00601", "N", 15, 2);
$polozky[] = array("RS00602", "N", 15, 2);
$polozky[] = array("RS00603", "N", 15, 2);
$polozky[] = array("RS00604", "N", 15, 2);
$polozky[] = array("RS00605", "N", 15, 2);
$polozky[] = array("RS00606", "N", 15, 2);
$polozky[] = array("RS00607", "N", 15, 2);
$polozky[] = array("RS00608", "N", 15, 2);
$polozky[] = array("RS00609", "N", 15, 2);
$polozky[] = array("RS00610", "N", 15, 2);
$polozky[] = array("RS00701", "N", 15, 2);
$polozky[] = array("RS00702", "N", 15, 2);
$polozky[] = array("RS00703", "N", 15, 2);
$polozky[] = array("RS00704", "N", 15, 2);
$polozky[] = array("RS00705", "N", 15, 2);
$polozky[] = array("RS00706", "N", 15, 2);
$polozky[] = array("RS00707", "N", 15, 2);
$polozky[] = array("RS00708", "N", 15, 2);
$polozky[] = array("RS00709", "N", 15, 2);
$polozky[] = array("RS00710", "N", 15, 2);
$polozky[] = array("RS00801", "N", 15, 2);
$polozky[] = array("RS00802", "N", 15, 2);
$polozky[] = array("RS00803", "N", 15, 2);
$polozky[] = array("RS00804", "N", 15, 2);
$polozky[] = array("RS00805", "N", 15, 2);
$polozky[] = array("RS00806", "N", 15, 2);
$polozky[] = array("RS00807", "N", 15, 2);
$polozky[] = array("RS00808", "N", 15, 2);
$polozky[] = array("RS00809", "N", 15, 2);
$polozky[] = array("RS00810", "N", 15, 2);
$polozky[] = array("RS00901", "N", 15, 2);
$polozky[] = array("RS00902", "N", 15, 2);
$polozky[] = array("RS00903", "N", 15, 2);
$polozky[] = array("RS00904", "N", 15, 2);
$polozky[] = array("RS00905", "N", 15, 2);
$polozky[] = array("RS00906", "N", 15, 2);
$polozky[] = array("RS00907", "N", 15, 2);
$polozky[] = array("RS00908", "N", 15, 2);
$polozky[] = array("RS00909", "N", 15, 2);
$polozky[] = array("RS00910", "N", 15, 2);
$polozky[] = array("RS01001", "N", 15, 2);
$polozky[] = array("RS01002", "N", 15, 2);
$polozky[] = array("RS01003", "N", 15, 2);
$polozky[] = array("RS01004", "N", 15, 2);
$polozky[] = array("RS01005", "N", 15, 2);
$polozky[] = array("RS01006", "N", 15, 2);
$polozky[] = array("RS01007", "N", 15, 2);
$polozky[] = array("RS01008", "N", 15, 2);
$polozky[] = array("RS01009", "N", 15, 2);
$polozky[] = array("RS01010", "N", 15, 2);

$polozky[] = array("RS01101", "N", 15, 2);
$polozky[] = array("RS01102", "N", 15, 2);
$polozky[] = array("RS01103", "N", 15, 2);
$polozky[] = array("RS01104", "N", 15, 2);
$polozky[] = array("RS01105", "N", 15, 2);
$polozky[] = array("RS01106", "N", 15, 2);
$polozky[] = array("RS01107", "N", 15, 2);
$polozky[] = array("RS01108", "N", 15, 2);
$polozky[] = array("RS01109", "N", 15, 2);
$polozky[] = array("RS01110", "N", 15, 2);
$polozky[] = array("RS01201", "N", 15, 2);
$polozky[] = array("RS01202", "N", 15, 2);
$polozky[] = array("RS01203", "N", 15, 2);
$polozky[] = array("RS01204", "N", 15, 2);
$polozky[] = array("RS01205", "N", 15, 2);
$polozky[] = array("RS01206", "N", 15, 2);
$polozky[] = array("RS01207", "N", 15, 2);
$polozky[] = array("RS01208", "N", 15, 2);
$polozky[] = array("RS01209", "N", 15, 2);
$polozky[] = array("RS01210", "N", 15, 2);
$polozky[] = array("RS01301", "N", 15, 2);
$polozky[] = array("RS01302", "N", 15, 2);
$polozky[] = array("RS01303", "N", 15, 2);
$polozky[] = array("RS01304", "N", 15, 2);
$polozky[] = array("RS01305", "N", 15, 2);
$polozky[] = array("RS01306", "N", 15, 2);
$polozky[] = array("RS01307", "N", 15, 2);
$polozky[] = array("RS01308", "N", 15, 2);
$polozky[] = array("RS01309", "N", 15, 2);
$polozky[] = array("RS01310", "N", 15, 2);
$polozky[] = array("RS01401", "N", 15, 2);
$polozky[] = array("RS01402", "N", 15, 2);
$polozky[] = array("RS01403", "N", 15, 2);
$polozky[] = array("RS01404", "N", 15, 2);
$polozky[] = array("RS01405", "N", 15, 2);
$polozky[] = array("RS01406", "N", 15, 2);
$polozky[] = array("RS01407", "N", 15, 2);
$polozky[] = array("RS01408", "N", 15, 2);
$polozky[] = array("RS01409", "N", 15, 2);
$polozky[] = array("RS01410", "N", 15, 2);
$polozky[] = array("RS01501", "N", 15, 2);
$polozky[] = array("RS01502", "N", 15, 2);
$polozky[] = array("RS01503", "N", 15, 2);
$polozky[] = array("RS01504", "N", 15, 2);
$polozky[] = array("RS01505", "N", 15, 2);
$polozky[] = array("RS01506", "N", 15, 2);
$polozky[] = array("RS01507", "N", 15, 2);
$polozky[] = array("RS01508", "N", 15, 2);
$polozky[] = array("RS01509", "N", 15, 2);
$polozky[] = array("RS01510", "N", 15, 2);
$polozky[] = array("RS01601", "N", 15, 2);
$polozky[] = array("RS01602", "N", 15, 2);
$polozky[] = array("RS01603", "N", 15, 2);
$polozky[] = array("RS01604", "N", 15, 2);
$polozky[] = array("RS01605", "N", 15, 2);
$polozky[] = array("RS01606", "N", 15, 2);
$polozky[] = array("RS01607", "N", 15, 2);
$polozky[] = array("RS01608", "N", 15, 2);
$polozky[] = array("RS01609", "N", 15, 2);
$polozky[] = array("RS01610", "N", 15, 2);
$polozky[] = array("RS01701", "N", 15, 2);
$polozky[] = array("RS01702", "N", 15, 2);
$polozky[] = array("RS01703", "N", 15, 2);
$polozky[] = array("RS01704", "N", 15, 2);
$polozky[] = array("RS01705", "N", 15, 2);
$polozky[] = array("RS01706", "N", 15, 2);
$polozky[] = array("RS01707", "N", 15, 2);
$polozky[] = array("RS01708", "N", 15, 2);
$polozky[] = array("RS01709", "N", 15, 2);
$polozky[] = array("RS01710", "N", 15, 2);
$polozky[] = array("RS01801", "N", 15, 2);
$polozky[] = array("RS01802", "N", 15, 2);
$polozky[] = array("RS01803", "N", 15, 2);
$polozky[] = array("RS01804", "N", 15, 2);
$polozky[] = array("RS01805", "N", 15, 2);
$polozky[] = array("RS01806", "N", 15, 2);
$polozky[] = array("RS01807", "N", 15, 2);
$polozky[] = array("RS01808", "N", 15, 2);
$polozky[] = array("RS01809", "N", 15, 2);
$polozky[] = array("RS01810", "N", 15, 2);
$polozky[] = array("RS01901", "N", 15, 2);
$polozky[] = array("RS01902", "N", 15, 2);
$polozky[] = array("RS01903", "N", 15, 2);
$polozky[] = array("RS01904", "N", 15, 2);
$polozky[] = array("RS01905", "N", 15, 2);
$polozky[] = array("RS01906", "N", 15, 2);
$polozky[] = array("RS01907", "N", 15, 2);
$polozky[] = array("RS01908", "N", 15, 2);
$polozky[] = array("RS01909", "N", 15, 2);
$polozky[] = array("RS01910", "N", 15, 2);
$polozky[] = array("RS02001", "N", 15, 2);
$polozky[] = array("RS02002", "N", 15, 2);
$polozky[] = array("RS02003", "N", 15, 2);
$polozky[] = array("RS02004", "N", 15, 2);
$polozky[] = array("RS02005", "N", 15, 2);
$polozky[] = array("RS02006", "N", 15, 2);
$polozky[] = array("RS02007", "N", 15, 2);
$polozky[] = array("RS02008", "N", 15, 2);
$polozky[] = array("RS02009", "N", 15, 2);
$polozky[] = array("RS02010", "N", 15, 2);

$polozky[] = array("RS02101", "N", 15, 2);
$polozky[] = array("RS02102", "N", 15, 2);
$polozky[] = array("RS02103", "N", 15, 2);
$polozky[] = array("RS02104", "N", 15, 2);
$polozky[] = array("RS02105", "N", 15, 2);
$polozky[] = array("RS02106", "N", 15, 2);
$polozky[] = array("RS02107", "N", 15, 2);
$polozky[] = array("RS02108", "N", 15, 2);
$polozky[] = array("RS02109", "N", 15, 2);
$polozky[] = array("RS02110", "N", 15, 2);
$polozky[] = array("RS02201", "N", 15, 2);
$polozky[] = array("RS02202", "N", 15, 2);
$polozky[] = array("RS02203", "N", 15, 2);
$polozky[] = array("RS02204", "N", 15, 2);
$polozky[] = array("RS02205", "N", 15, 2);
$polozky[] = array("RS02206", "N", 15, 2);
$polozky[] = array("RS02207", "N", 15, 2);
$polozky[] = array("RS02208", "N", 15, 2);
$polozky[] = array("RS02209", "N", 15, 2);
$polozky[] = array("RS02210", "N", 15, 2);
$polozky[] = array("RS02301", "N", 15, 2);
$polozky[] = array("RS02302", "N", 15, 2);
$polozky[] = array("RS02303", "N", 15, 2);
$polozky[] = array("RS02304", "N", 15, 2);
$polozky[] = array("RS02305", "N", 15, 2);
$polozky[] = array("RS02306", "N", 15, 2);
$polozky[] = array("RS02307", "N", 15, 2);
$polozky[] = array("RS02308", "N", 15, 2);
$polozky[] = array("RS02309", "N", 15, 2);
$polozky[] = array("RS02310", "N", 15, 2);
$polozky[] = array("RS02401", "N", 15, 2);
$polozky[] = array("RS02402", "N", 15, 2);
$polozky[] = array("RS02403", "N", 15, 2);
$polozky[] = array("RS02404", "N", 15, 2);
$polozky[] = array("RS02405", "N", 15, 2);
$polozky[] = array("RS02406", "N", 15, 2);
$polozky[] = array("RS02407", "N", 15, 2);
$polozky[] = array("RS02408", "N", 15, 2);
$polozky[] = array("RS02409", "N", 15, 2);
$polozky[] = array("RS02410", "N", 15, 2);
$polozky[] = array("RS02501", "N", 15, 2);
$polozky[] = array("RS02502", "N", 15, 2);
$polozky[] = array("RS02503", "N", 15, 2);
$polozky[] = array("RS02504", "N", 15, 2);
$polozky[] = array("RS02505", "N", 15, 2);
$polozky[] = array("RS02506", "N", 15, 2);
$polozky[] = array("RS02507", "N", 15, 2);
$polozky[] = array("RS02508", "N", 15, 2);
$polozky[] = array("RS02509", "N", 15, 2);
$polozky[] = array("RS02510", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN3A1_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN3A1_".$kli_uzid."_".$hhmmss.".dbf";
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

$sqlx = 'DROP TABLE fin3adbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN3A1.DBF


/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN3A2.DBF
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

$sqlt = <<<fin3adbf
(
FIN3A2.DBF
ICO CHARACTER 8 IÈO
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organizácie (“02“ – príspevková organizácia
“11“ – rozpoètová organizácia
“22“ – obec
“23“ – mesto
“31“ – nezisková inštitúcia
“51“ – obchodná spoloènos)
RS02601 NUMERIC (15,2) údajová èas
RS02602 NUMERIC (15,2)
RS02603 NUMERIC (15,2)
RS02604 NUMERIC (15,2)
RS02605 NUMERIC (15,2)
RS02606 NUMERIC (15,2)
RS02607 NUMERIC (15,2)
RS02608 NUMERIC (15,2)
RS02609 NUMERIC (15,2)
RS02610 NUMERIC (15,2)
.
.
.
RS05001 NUMERIC (15,2)
RS05002 NUMERIC (15,2)
RS05003 NUMERIC (15,2)
RS05004 NUMERIC (15,2)
RS05005 NUMERIC (15,2)
RS05006 NUMERIC (15,2)
RS05007 NUMERIC (15,2)
RS05008 NUMERIC (15,2)
RS05009 NUMERIC (15,2)
RS05010 NUMERIC (15,2)
);
fin3adbf;

$sqlx = 'DROP TABLE fin3adbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin3adbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin3adbf!"."<br />";

$sqlt = <<<fin3adbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


RS02601         DECIMAL(12,2),
RS02602         DECIMAL(12,2),
RS02603         DECIMAL(12,2),
RS02604         DECIMAL(12,2),
RS02605         DECIMAL(12,2),
RS02606         DECIMAL(12,2),
RS02607         DECIMAL(12,2),
RS02608         DECIMAL(12,2),
RS02609         DECIMAL(12,2),
RS02610         DECIMAL(12,2),
RS02701         DECIMAL(12,2),
RS02702         DECIMAL(12,2),
RS02703         DECIMAL(12,2),
RS02704         DECIMAL(12,2),
RS02705         DECIMAL(12,2),
RS02706         DECIMAL(12,2),
RS02707         DECIMAL(12,2),
RS02708         DECIMAL(12,2),
RS02709         DECIMAL(12,2),
RS02710         DECIMAL(12,2),
RS02801         DECIMAL(12,2),
RS02802         DECIMAL(12,2),
RS02803         DECIMAL(12,2),
RS02804         DECIMAL(12,2),
RS02805         DECIMAL(12,2),
RS02806         DECIMAL(12,2),
RS02807         DECIMAL(12,2),
RS02808         DECIMAL(12,2),
RS02809         DECIMAL(12,2),
RS02810         DECIMAL(12,2),
RS02901         DECIMAL(12,2),
RS02902         DECIMAL(12,2),
RS02903         DECIMAL(12,2),
RS02904         DECIMAL(12,2),
RS02905         DECIMAL(12,2),
RS02906         DECIMAL(12,2),
RS02907         DECIMAL(12,2),
RS02908         DECIMAL(12,2),
RS02909         DECIMAL(12,2),
RS02910         DECIMAL(12,2),
RS03001         DECIMAL(12,2),
RS03002         DECIMAL(12,2),
RS03003         DECIMAL(12,2),
RS03004         DECIMAL(12,2),
RS03005         DECIMAL(12,2),
RS03006         DECIMAL(12,2),
RS03007         DECIMAL(12,2),
RS03008         DECIMAL(12,2),
RS03009         DECIMAL(12,2),
RS03010         DECIMAL(12,2),

RS03101         DECIMAL(12,2),
RS03102         DECIMAL(12,2),
RS03103         DECIMAL(12,2),
RS03104         DECIMAL(12,2),
RS03105         DECIMAL(12,2),
RS03106         DECIMAL(12,2),
RS03107         DECIMAL(12,2),
RS03108         DECIMAL(12,2),
RS03109         DECIMAL(12,2),
RS03110         DECIMAL(12,2),
RS03201         DECIMAL(12,2),
RS03202         DECIMAL(12,2),
RS03203         DECIMAL(12,2),
RS03204         DECIMAL(12,2),
RS03205         DECIMAL(12,2),
RS03206         DECIMAL(12,2),
RS03207         DECIMAL(12,2),
RS03208         DECIMAL(12,2),
RS03209         DECIMAL(12,2),
RS03210         DECIMAL(12,2),
RS03301         DECIMAL(12,2),
RS03302         DECIMAL(12,2),
RS03303         DECIMAL(12,2),
RS03304         DECIMAL(12,2),
RS03305         DECIMAL(12,2),
RS03306         DECIMAL(12,2),
RS03307         DECIMAL(12,2),
RS03308         DECIMAL(12,2),
RS03309         DECIMAL(12,2),
RS03310         DECIMAL(12,2),
RS03401         DECIMAL(12,2),
RS03402         DECIMAL(12,2),
RS03403         DECIMAL(12,2),
RS03404         DECIMAL(12,2),
RS03405         DECIMAL(12,2),
RS03406         DECIMAL(12,2),
RS03407         DECIMAL(12,2),
RS03408         DECIMAL(12,2),
RS03409         DECIMAL(12,2),
RS03410         DECIMAL(12,2),
RS03501         DECIMAL(12,2),
RS03502         DECIMAL(12,2),
RS03503         DECIMAL(12,2),
RS03504         DECIMAL(12,2),
RS03505         DECIMAL(12,2),
RS03506         DECIMAL(12,2),
RS03507         DECIMAL(12,2),
RS03508         DECIMAL(12,2),
RS03509         DECIMAL(12,2),
RS03510         DECIMAL(12,2),
RS03601         DECIMAL(12,2),
RS03602         DECIMAL(12,2),
RS03603         DECIMAL(12,2),
RS03604         DECIMAL(12,2),
RS03605         DECIMAL(12,2),
RS03606         DECIMAL(12,2),
RS03607         DECIMAL(12,2),
RS03608         DECIMAL(12,2),
RS03609         DECIMAL(12,2),
RS03610         DECIMAL(12,2),
RS03701         DECIMAL(12,2),
RS03702         DECIMAL(12,2),
RS03703         DECIMAL(12,2),
RS03704         DECIMAL(12,2),
RS03705         DECIMAL(12,2),
RS03706         DECIMAL(12,2),
RS03707         DECIMAL(12,2),
RS03708         DECIMAL(12,2),
RS03709         DECIMAL(12,2),
RS03710         DECIMAL(12,2),
RS03801         DECIMAL(12,2),
RS03802         DECIMAL(12,2),
RS03803         DECIMAL(12,2),
RS03804         DECIMAL(12,2),
RS03805         DECIMAL(12,2),
RS03806         DECIMAL(12,2),
RS03807         DECIMAL(12,2),
RS03808         DECIMAL(12,2),
RS03809         DECIMAL(12,2),
RS03810         DECIMAL(12,2),
RS03901         DECIMAL(12,2),
RS03902         DECIMAL(12,2),
RS03903         DECIMAL(12,2),
RS03904         DECIMAL(12,2),
RS03905         DECIMAL(12,2),
RS03906         DECIMAL(12,2),
RS03907         DECIMAL(12,2),
RS03908         DECIMAL(12,2),
RS03909         DECIMAL(12,2),
RS03910         DECIMAL(12,2),
RS04001         DECIMAL(12,2),
RS04002         DECIMAL(12,2),
RS04003         DECIMAL(12,2),
RS04004         DECIMAL(12,2),
RS04005         DECIMAL(12,2),
RS04006         DECIMAL(12,2),
RS04007         DECIMAL(12,2),
RS04008         DECIMAL(12,2),
RS04009         DECIMAL(12,2),
RS04010         DECIMAL(12,2),

RS04101         DECIMAL(12,2),
RS04102         DECIMAL(12,2),
RS04103         DECIMAL(12,2),
RS04104         DECIMAL(12,2),
RS04105         DECIMAL(12,2),
RS04106         DECIMAL(12,2),
RS04107         DECIMAL(12,2),
RS04108         DECIMAL(12,2),
RS04109         DECIMAL(12,2),
RS04110         DECIMAL(12,2),
RS04201         DECIMAL(12,2),
RS04202         DECIMAL(12,2),
RS04203         DECIMAL(12,2),
RS04204         DECIMAL(12,2),
RS04205         DECIMAL(12,2),
RS04206         DECIMAL(12,2),
RS04207         DECIMAL(12,2),
RS04208         DECIMAL(12,2),
RS04209         DECIMAL(12,2),
RS04210         DECIMAL(12,2),
RS04301         DECIMAL(12,2),
RS04302         DECIMAL(12,2),
RS04303         DECIMAL(12,2),
RS04304         DECIMAL(12,2),
RS04305         DECIMAL(12,2),
RS04306         DECIMAL(12,2),
RS04307         DECIMAL(12,2),
RS04308         DECIMAL(12,2),
RS04309         DECIMAL(12,2),
RS04310         DECIMAL(12,2),
RS04401         DECIMAL(12,2),
RS04402         DECIMAL(12,2),
RS04403         DECIMAL(12,2),
RS04404         DECIMAL(12,2),
RS04405         DECIMAL(12,2),
RS04406         DECIMAL(12,2),
RS04407         DECIMAL(12,2),
RS04408         DECIMAL(12,2),
RS04409         DECIMAL(12,2),
RS04410         DECIMAL(12,2),
RS04501         DECIMAL(12,2),
RS04502         DECIMAL(12,2),
RS04503         DECIMAL(12,2),
RS04504         DECIMAL(12,2),
RS04505         DECIMAL(12,2),
RS04506         DECIMAL(12,2),
RS04507         DECIMAL(12,2),
RS04508         DECIMAL(12,2),
RS04509         DECIMAL(12,2),
RS04510         DECIMAL(12,2),
RS04601         DECIMAL(12,2),
RS04602         DECIMAL(12,2),
RS04603         DECIMAL(12,2),
RS04604         DECIMAL(12,2),
RS04605         DECIMAL(12,2),
RS04606         DECIMAL(12,2),
RS04607         DECIMAL(12,2),
RS04608         DECIMAL(12,2),
RS04609         DECIMAL(12,2),
RS04610         DECIMAL(12,2),
RS04701         DECIMAL(12,2),
RS04702         DECIMAL(12,2),
RS04703         DECIMAL(12,2),
RS04704         DECIMAL(12,2),
RS04705         DECIMAL(12,2),
RS04706         DECIMAL(12,2),
RS04707         DECIMAL(12,2),
RS04708         DECIMAL(12,2),
RS04709         DECIMAL(12,2),
RS04710         DECIMAL(12,2),
RS04801         DECIMAL(12,2),
RS04802         DECIMAL(12,2),
RS04803         DECIMAL(12,2),
RS04804         DECIMAL(12,2),
RS04805         DECIMAL(12,2),
RS04806         DECIMAL(12,2),
RS04807         DECIMAL(12,2),
RS04808         DECIMAL(12,2),
RS04809         DECIMAL(12,2),
RS04810         DECIMAL(12,2),
RS04901         DECIMAL(12,2),
RS04902         DECIMAL(12,2),
RS04903         DECIMAL(12,2),
RS04904         DECIMAL(12,2),
RS04905         DECIMAL(12,2),
RS04906         DECIMAL(12,2),
RS04907         DECIMAL(12,2),
RS04908         DECIMAL(12,2),
RS04909         DECIMAL(12,2),
RS04910         DECIMAL(12,2),
RS05001         DECIMAL(12,2),
RS05002         DECIMAL(12,2),
RS05003         DECIMAL(12,2),
RS05004         DECIMAL(12,2),
RS05005         DECIMAL(12,2),
RS05006         DECIMAL(12,2),
RS05007         DECIMAL(12,2),
RS05008         DECIMAL(12,2),
RS05009         DECIMAL(12,2),
RS05010         DECIMAL(12,2)

);
fin3adbf;

$sqlx = 'CREATE TABLE fin3adbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia


//vloz vykaz do vytvorenej databazy riadky 30,32,37,38,39,44,45
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".

$dsqlt = "INSERT INTO fin3adbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".
"0,0,0,0,0,0,0,0,0,0,".
"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),".
"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),".
"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".

"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".
"0,0,0,0,0,0,0,0,0,0,".
"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),".

"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin304".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin3adbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky2[] = array("ICO", "C", 8);
$polozky2[] = array("DATROK", "C", 4);
$polozky2[] = array("DATMES", "C", 2);
$polozky2[] = array("TYPORG", "C", 2);


$polozky2[] = array("RS02601", "N", 15, 2);
$polozky2[] = array("RS02602", "N", 15, 2);
$polozky2[] = array("RS02603", "N", 15, 2);
$polozky2[] = array("RS02604", "N", 15, 2);
$polozky2[] = array("RS02605", "N", 15, 2);
$polozky2[] = array("RS02606", "N", 15, 2);
$polozky2[] = array("RS02607", "N", 15, 2);
$polozky2[] = array("RS02608", "N", 15, 2);
$polozky2[] = array("RS02609", "N", 15, 2);
$polozky2[] = array("RS02610", "N", 15, 2);
$polozky2[] = array("RS02701", "N", 15, 2);
$polozky2[] = array("RS02702", "N", 15, 2);
$polozky2[] = array("RS02703", "N", 15, 2);
$polozky2[] = array("RS02704", "N", 15, 2);
$polozky2[] = array("RS02705", "N", 15, 2);
$polozky2[] = array("RS02706", "N", 15, 2);
$polozky2[] = array("RS02707", "N", 15, 2);
$polozky2[] = array("RS02708", "N", 15, 2);
$polozky2[] = array("RS02709", "N", 15, 2);
$polozky2[] = array("RS02710", "N", 15, 2);
$polozky2[] = array("RS02801", "N", 15, 2);
$polozky2[] = array("RS02802", "N", 15, 2);
$polozky2[] = array("RS02803", "N", 15, 2);
$polozky2[] = array("RS02804", "N", 15, 2);
$polozky2[] = array("RS02805", "N", 15, 2);
$polozky2[] = array("RS02806", "N", 15, 2);
$polozky2[] = array("RS02807", "N", 15, 2);
$polozky2[] = array("RS02808", "N", 15, 2);
$polozky2[] = array("RS02809", "N", 15, 2);
$polozky2[] = array("RS02810", "N", 15, 2);
$polozky2[] = array("RS02901", "N", 15, 2);
$polozky2[] = array("RS02902", "N", 15, 2);
$polozky2[] = array("RS02903", "N", 15, 2);
$polozky2[] = array("RS02904", "N", 15, 2);
$polozky2[] = array("RS02905", "N", 15, 2);
$polozky2[] = array("RS02906", "N", 15, 2);
$polozky2[] = array("RS02907", "N", 15, 2);
$polozky2[] = array("RS02908", "N", 15, 2);
$polozky2[] = array("RS02909", "N", 15, 2);
$polozky2[] = array("RS02910", "N", 15, 2);
$polozky2[] = array("RS03001", "N", 15, 2);
$polozky2[] = array("RS03002", "N", 15, 2);
$polozky2[] = array("RS03003", "N", 15, 2);
$polozky2[] = array("RS03004", "N", 15, 2);
$polozky2[] = array("RS03005", "N", 15, 2);
$polozky2[] = array("RS03006", "N", 15, 2);
$polozky2[] = array("RS03007", "N", 15, 2);
$polozky2[] = array("RS03008", "N", 15, 2);
$polozky2[] = array("RS03009", "N", 15, 2);
$polozky2[] = array("RS03010", "N", 15, 2);

$polozky2[] = array("RS03101", "N", 15, 2);
$polozky2[] = array("RS03102", "N", 15, 2);
$polozky2[] = array("RS03103", "N", 15, 2);
$polozky2[] = array("RS03104", "N", 15, 2);
$polozky2[] = array("RS03105", "N", 15, 2);
$polozky2[] = array("RS03106", "N", 15, 2);
$polozky2[] = array("RS03107", "N", 15, 2);
$polozky2[] = array("RS03108", "N", 15, 2);
$polozky2[] = array("RS03109", "N", 15, 2);
$polozky2[] = array("RS03110", "N", 15, 2);
$polozky2[] = array("RS03201", "N", 15, 2);
$polozky2[] = array("RS03202", "N", 15, 2);
$polozky2[] = array("RS03203", "N", 15, 2);
$polozky2[] = array("RS03204", "N", 15, 2);
$polozky2[] = array("RS03205", "N", 15, 2);
$polozky2[] = array("RS03206", "N", 15, 2);
$polozky2[] = array("RS03207", "N", 15, 2);
$polozky2[] = array("RS03208", "N", 15, 2);
$polozky2[] = array("RS03209", "N", 15, 2);
$polozky2[] = array("RS03210", "N", 15, 2);
$polozky2[] = array("RS03301", "N", 15, 2);
$polozky2[] = array("RS03302", "N", 15, 2);
$polozky2[] = array("RS03303", "N", 15, 2);
$polozky2[] = array("RS03304", "N", 15, 2);
$polozky2[] = array("RS03305", "N", 15, 2);
$polozky2[] = array("RS03306", "N", 15, 2);
$polozky2[] = array("RS03307", "N", 15, 2);
$polozky2[] = array("RS03308", "N", 15, 2);
$polozky2[] = array("RS03309", "N", 15, 2);
$polozky2[] = array("RS03310", "N", 15, 2);
$polozky2[] = array("RS03401", "N", 15, 2);
$polozky2[] = array("RS03402", "N", 15, 2);
$polozky2[] = array("RS03403", "N", 15, 2);
$polozky2[] = array("RS03404", "N", 15, 2);
$polozky2[] = array("RS03405", "N", 15, 2);
$polozky2[] = array("RS03406", "N", 15, 2);
$polozky2[] = array("RS03407", "N", 15, 2);
$polozky2[] = array("RS03408", "N", 15, 2);
$polozky2[] = array("RS03409", "N", 15, 2);
$polozky2[] = array("RS03410", "N", 15, 2);
$polozky2[] = array("RS03501", "N", 15, 2);
$polozky2[] = array("RS03502", "N", 15, 2);
$polozky2[] = array("RS03503", "N", 15, 2);
$polozky2[] = array("RS03504", "N", 15, 2);
$polozky2[] = array("RS03505", "N", 15, 2);
$polozky2[] = array("RS03506", "N", 15, 2);
$polozky2[] = array("RS03507", "N", 15, 2);
$polozky2[] = array("RS03508", "N", 15, 2);
$polozky2[] = array("RS03509", "N", 15, 2);
$polozky2[] = array("RS03510", "N", 15, 2);
$polozky2[] = array("RS03601", "N", 15, 2);
$polozky2[] = array("RS03602", "N", 15, 2);
$polozky2[] = array("RS03603", "N", 15, 2);
$polozky2[] = array("RS03604", "N", 15, 2);
$polozky2[] = array("RS03605", "N", 15, 2);
$polozky2[] = array("RS03606", "N", 15, 2);
$polozky2[] = array("RS03607", "N", 15, 2);
$polozky2[] = array("RS03608", "N", 15, 2);
$polozky2[] = array("RS03609", "N", 15, 2);
$polozky2[] = array("RS03610", "N", 15, 2);
$polozky2[] = array("RS03701", "N", 15, 2);
$polozky2[] = array("RS03702", "N", 15, 2);
$polozky2[] = array("RS03703", "N", 15, 2);
$polozky2[] = array("RS03704", "N", 15, 2);
$polozky2[] = array("RS03705", "N", 15, 2);
$polozky2[] = array("RS03706", "N", 15, 2);
$polozky2[] = array("RS03707", "N", 15, 2);
$polozky2[] = array("RS03708", "N", 15, 2);
$polozky2[] = array("RS03709", "N", 15, 2);
$polozky2[] = array("RS03710", "N", 15, 2);
$polozky2[] = array("RS03801", "N", 15, 2);
$polozky2[] = array("RS03802", "N", 15, 2);
$polozky2[] = array("RS03803", "N", 15, 2);
$polozky2[] = array("RS03804", "N", 15, 2);
$polozky2[] = array("RS03805", "N", 15, 2);
$polozky2[] = array("RS03806", "N", 15, 2);
$polozky2[] = array("RS03807", "N", 15, 2);
$polozky2[] = array("RS03808", "N", 15, 2);
$polozky2[] = array("RS03809", "N", 15, 2);
$polozky2[] = array("RS03810", "N", 15, 2);
$polozky2[] = array("RS03901", "N", 15, 2);
$polozky2[] = array("RS03902", "N", 15, 2);
$polozky2[] = array("RS03903", "N", 15, 2);
$polozky2[] = array("RS03904", "N", 15, 2);
$polozky2[] = array("RS03905", "N", 15, 2);
$polozky2[] = array("RS03906", "N", 15, 2);
$polozky2[] = array("RS03907", "N", 15, 2);
$polozky2[] = array("RS03908", "N", 15, 2);
$polozky2[] = array("RS03909", "N", 15, 2);
$polozky2[] = array("RS03910", "N", 15, 2);

$polozky2[] = array("RS04001", "N", 15, 2);
$polozky2[] = array("RS04002", "N", 15, 2);
$polozky2[] = array("RS04003", "N", 15, 2);
$polozky2[] = array("RS04004", "N", 15, 2);
$polozky2[] = array("RS04005", "N", 15, 2);
$polozky2[] = array("RS04006", "N", 15, 2);
$polozky2[] = array("RS04007", "N", 15, 2);
$polozky2[] = array("RS04008", "N", 15, 2);
$polozky2[] = array("RS04009", "N", 15, 2);
$polozky2[] = array("RS04010", "N", 15, 2);
$polozky2[] = array("RS04101", "N", 15, 2);
$polozky2[] = array("RS04102", "N", 15, 2);
$polozky2[] = array("RS04103", "N", 15, 2);
$polozky2[] = array("RS04104", "N", 15, 2);
$polozky2[] = array("RS04105", "N", 15, 2);
$polozky2[] = array("RS04106", "N", 15, 2);
$polozky2[] = array("RS04107", "N", 15, 2);
$polozky2[] = array("RS04108", "N", 15, 2);
$polozky2[] = array("RS04109", "N", 15, 2);
$polozky2[] = array("RS04110", "N", 15, 2);
$polozky2[] = array("RS04201", "N", 15, 2);
$polozky2[] = array("RS04202", "N", 15, 2);
$polozky2[] = array("RS04203", "N", 15, 2);
$polozky2[] = array("RS04204", "N", 15, 2);
$polozky2[] = array("RS04205", "N", 15, 2);
$polozky2[] = array("RS04206", "N", 15, 2);
$polozky2[] = array("RS04207", "N", 15, 2);
$polozky2[] = array("RS04208", "N", 15, 2);
$polozky2[] = array("RS04209", "N", 15, 2);
$polozky2[] = array("RS04210", "N", 15, 2);
$polozky2[] = array("RS04301", "N", 15, 2);
$polozky2[] = array("RS04302", "N", 15, 2);
$polozky2[] = array("RS04303", "N", 15, 2);
$polozky2[] = array("RS04304", "N", 15, 2);
$polozky2[] = array("RS04305", "N", 15, 2);
$polozky2[] = array("RS04306", "N", 15, 2);
$polozky2[] = array("RS04307", "N", 15, 2);
$polozky2[] = array("RS04308", "N", 15, 2);
$polozky2[] = array("RS04309", "N", 15, 2);
$polozky2[] = array("RS04310", "N", 15, 2);
$polozky2[] = array("RS04401", "N", 15, 2);
$polozky2[] = array("RS04402", "N", 15, 2);
$polozky2[] = array("RS04403", "N", 15, 2);
$polozky2[] = array("RS04404", "N", 15, 2);
$polozky2[] = array("RS04405", "N", 15, 2);
$polozky2[] = array("RS04406", "N", 15, 2);
$polozky2[] = array("RS04407", "N", 15, 2);
$polozky2[] = array("RS04408", "N", 15, 2);
$polozky2[] = array("RS04409", "N", 15, 2);
$polozky2[] = array("RS04410", "N", 15, 2);
$polozky2[] = array("RS04501", "N", 15, 2);
$polozky2[] = array("RS04502", "N", 15, 2);
$polozky2[] = array("RS04503", "N", 15, 2);
$polozky2[] = array("RS04504", "N", 15, 2);
$polozky2[] = array("RS04505", "N", 15, 2);
$polozky2[] = array("RS04506", "N", 15, 2);
$polozky2[] = array("RS04507", "N", 15, 2);
$polozky2[] = array("RS04508", "N", 15, 2);
$polozky2[] = array("RS04509", "N", 15, 2);
$polozky2[] = array("RS04510", "N", 15, 2);
$polozky2[] = array("RS04601", "N", 15, 2);
$polozky2[] = array("RS04602", "N", 15, 2);
$polozky2[] = array("RS04603", "N", 15, 2);
$polozky2[] = array("RS04604", "N", 15, 2);
$polozky2[] = array("RS04605", "N", 15, 2);
$polozky2[] = array("RS04606", "N", 15, 2);
$polozky2[] = array("RS04607", "N", 15, 2);
$polozky2[] = array("RS04608", "N", 15, 2);
$polozky2[] = array("RS04609", "N", 15, 2);
$polozky2[] = array("RS04610", "N", 15, 2);
$polozky2[] = array("RS04701", "N", 15, 2);
$polozky2[] = array("RS04702", "N", 15, 2);
$polozky2[] = array("RS04703", "N", 15, 2);
$polozky2[] = array("RS04704", "N", 15, 2);
$polozky2[] = array("RS04705", "N", 15, 2);
$polozky2[] = array("RS04706", "N", 15, 2);
$polozky2[] = array("RS04707", "N", 15, 2);
$polozky2[] = array("RS04708", "N", 15, 2);
$polozky2[] = array("RS04709", "N", 15, 2);
$polozky2[] = array("RS04710", "N", 15, 2);
$polozky2[] = array("RS04801", "N", 15, 2);
$polozky2[] = array("RS04802", "N", 15, 2);
$polozky2[] = array("RS04803", "N", 15, 2);
$polozky2[] = array("RS04804", "N", 15, 2);
$polozky2[] = array("RS04805", "N", 15, 2);
$polozky2[] = array("RS04806", "N", 15, 2);
$polozky2[] = array("RS04807", "N", 15, 2);
$polozky2[] = array("RS04808", "N", 15, 2);
$polozky2[] = array("RS04809", "N", 15, 2);
$polozky2[] = array("RS04810", "N", 15, 2);
$polozky2[] = array("RS04901", "N", 15, 2);
$polozky2[] = array("RS04902", "N", 15, 2);
$polozky2[] = array("RS04903", "N", 15, 2);
$polozky2[] = array("RS04904", "N", 15, 2);
$polozky2[] = array("RS04905", "N", 15, 2);
$polozky2[] = array("RS04906", "N", 15, 2);
$polozky2[] = array("RS04907", "N", 15, 2);
$polozky2[] = array("RS04908", "N", 15, 2);
$polozky2[] = array("RS04909", "N", 15, 2);
$polozky2[] = array("RS04910", "N", 15, 2);
$polozky2[] = array("RS05001", "N", 15, 2);
$polozky2[] = array("RS05002", "N", 15, 2);
$polozky2[] = array("RS05003", "N", 15, 2);
$polozky2[] = array("RS05004", "N", 15, 2);
$polozky2[] = array("RS05005", "N", 15, 2);
$polozky2[] = array("RS05006", "N", 15, 2);
$polozky2[] = array("RS05007", "N", 15, 2);
$polozky2[] = array("RS05008", "N", 15, 2);
$polozky2[] = array("RS05009", "N", 15, 2);
$polozky2[] = array("RS05010", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN3A2_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN3A2_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru2 = $outfilex;

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru2, $polozky2);
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
//header("Content-Disposition: attachment; filename=$nazev_souboru2"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin3adbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN3A2.DBF

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
<BODY class="white" >




<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 3-04 DBF</td>
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
Stiahnite si nižšie uvedené súbory na Váš lokálny disk, premenujte ich na FIN3A1.DBF a FIN3A2.DBF a potom naèítajte na portál www.rissam.sk :
<br />
<br />
<a href="<?php echo $nazev_souboru; ?>"><?php echo $nazev_souboru; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru2; ?>"><?php echo $nazev_souboru2; ?></a>

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
