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


/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P1.DBF
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

$sqlt = <<<fin4pdbf
(
FIN4P1.DBF
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
RS00111 NUMERIC (15,2)
RS00112 NUMERIC (15,2)
RS00113 NUMERIC (15,2)
RS00114 NUMERIC (15,2)
RS00115 NUMERIC (15,2)
RS00116 NUMERIC (15,2)
RS00117 NUMERIC (15,2)
RS00118 NUMERIC (15,2)
RS00119 NUMERIC (15,2)
RS00120 NUMERIC (15,2)
RS00121 NUMERIC (15,2)
RS00122 NUMERIC (15,2)
RS00123 NUMERIC (15,2)
RS00124 NUMERIC (15,2)
RS00125 NUMERIC (15,2)
RS00126 NUMERIC (15,2)
.
.
.
RS00901 NUMERIC (15,2)
RS00902 NUMERIC (15,2)
RS00903 NUMERIC (15,2)
RS00904 NUMERIC (15,2)
RS00905 NUMERIC (15,2)
RS00906 NUMERIC (15,2)
RS00907 NUMERIC (15,2)
RS00908 NUMERIC (15,2)
RS00909 NUMERIC (15,2)
RS00910 NUMERIC (15,2)
RS00911 NUMERIC (15,2)
RS00912 NUMERIC (15,2)
RS00913 NUMERIC (15,2)
RS00914 NUMERIC (15,2)
RS00915 NUMERIC (15,2)
RS00916 NUMERIC (15,2)
RS00917 NUMERIC (15,2)
RS00918 NUMERIC (15,2)
RS00919 NUMERIC (15,2)
RS00920 NUMERIC (15,2)
RS00921 NUMERIC (15,2)
RS00922 NUMERIC (15,2)
RS00923 NUMERIC (15,2)
RS00924 NUMERIC (15,2)
RS00925 NUMERIC (15,2)
RS00926 NUMERIC (15,2)
);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
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
RS00111         DECIMAL(12,2),
RS00112         DECIMAL(12,2),
RS00113         DECIMAL(12,2),
RS00114         DECIMAL(12,2),
RS00115         DECIMAL(12,2),
RS00116         DECIMAL(12,2),
RS00117         DECIMAL(12,2),
RS00118         DECIMAL(12,2),
RS00119         DECIMAL(12,2),
RS00120         DECIMAL(12,2),
RS00121         DECIMAL(12,2),
RS00122         DECIMAL(12,2),
RS00123         DECIMAL(12,2),
RS00124         DECIMAL(12,2),
RS00125         DECIMAL(12,2),
RS00126         DECIMAL(12,2),

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
RS00211         DECIMAL(12,2),
RS00212         DECIMAL(12,2),
RS00213         DECIMAL(12,2),
RS00214         DECIMAL(12,2),
RS00215         DECIMAL(12,2),
RS00216         DECIMAL(12,2),
RS00217         DECIMAL(12,2),
RS00218         DECIMAL(12,2),
RS00219         DECIMAL(12,2),
RS00220         DECIMAL(12,2),
RS00221         DECIMAL(12,2),
RS00222         DECIMAL(12,2),
RS00223         DECIMAL(12,2),
RS00224         DECIMAL(12,2),
RS00225         DECIMAL(12,2),
RS00226         DECIMAL(12,2),

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
RS00311         DECIMAL(12,2),
RS00312         DECIMAL(12,2),
RS00313         DECIMAL(12,2),
RS00314         DECIMAL(12,2),
RS00315         DECIMAL(12,2),
RS00316         DECIMAL(12,2),
RS00317         DECIMAL(12,2),
RS00318         DECIMAL(12,2),
RS00319         DECIMAL(12,2),
RS00320         DECIMAL(12,2),
RS00321         DECIMAL(12,2),
RS00322         DECIMAL(12,2),
RS00323         DECIMAL(12,2),
RS00324         DECIMAL(12,2),
RS00325         DECIMAL(12,2),
RS00326         DECIMAL(12,2),

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
RS00411         DECIMAL(12,2),
RS00412         DECIMAL(12,2),
RS00413         DECIMAL(12,2),
RS00414         DECIMAL(12,2),
RS00415         DECIMAL(12,2),
RS00416         DECIMAL(12,2),
RS00417         DECIMAL(12,2),
RS00418         DECIMAL(12,2),
RS00419         DECIMAL(12,2),
RS00420         DECIMAL(12,2),
RS00421         DECIMAL(12,2),
RS00422         DECIMAL(12,2),
RS00423         DECIMAL(12,2),
RS00424         DECIMAL(12,2),
RS00425         DECIMAL(12,2),
RS00426         DECIMAL(12,2),

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
RS00511         DECIMAL(12,2),
RS00512         DECIMAL(12,2),
RS00513         DECIMAL(12,2),
RS00514         DECIMAL(12,2),
RS00515         DECIMAL(12,2),
RS00516         DECIMAL(12,2),
RS00517         DECIMAL(12,2),
RS00518         DECIMAL(12,2),
RS00519         DECIMAL(12,2),
RS00520         DECIMAL(12,2),
RS00521         DECIMAL(12,2),
RS00522         DECIMAL(12,2),
RS00523         DECIMAL(12,2),
RS00524         DECIMAL(12,2),
RS00525         DECIMAL(12,2),
RS00526         DECIMAL(12,2),

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
RS00611         DECIMAL(12,2),
RS00612         DECIMAL(12,2),
RS00613         DECIMAL(12,2),
RS00614         DECIMAL(12,2),
RS00615         DECIMAL(12,2),
RS00616         DECIMAL(12,2),
RS00617         DECIMAL(12,2),
RS00618         DECIMAL(12,2),
RS00619         DECIMAL(12,2),
RS00620         DECIMAL(12,2),
RS00621         DECIMAL(12,2),
RS00622         DECIMAL(12,2),
RS00623         DECIMAL(12,2),
RS00624         DECIMAL(12,2),
RS00625         DECIMAL(12,2),
RS00626         DECIMAL(12,2),

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
RS00711         DECIMAL(12,2),
RS00712         DECIMAL(12,2),
RS00713         DECIMAL(12,2),
RS00714         DECIMAL(12,2),
RS00715         DECIMAL(12,2),
RS00716         DECIMAL(12,2),
RS00717         DECIMAL(12,2),
RS00718         DECIMAL(12,2),
RS00719         DECIMAL(12,2),
RS00720         DECIMAL(12,2),
RS00721         DECIMAL(12,2),
RS00722         DECIMAL(12,2),
RS00723         DECIMAL(12,2),
RS00724         DECIMAL(12,2),
RS00725         DECIMAL(12,2),
RS00726         DECIMAL(12,2),

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
RS00811         DECIMAL(12,2),
RS00812         DECIMAL(12,2),
RS00813         DECIMAL(12,2),
RS00814         DECIMAL(12,2),
RS00815         DECIMAL(12,2),
RS00816         DECIMAL(12,2),
RS00817         DECIMAL(12,2),
RS00818         DECIMAL(12,2),
RS00819         DECIMAL(12,2),
RS00820         DECIMAL(12,2),
RS00821         DECIMAL(12,2),
RS00822         DECIMAL(12,2),
RS00823         DECIMAL(12,2),
RS00824         DECIMAL(12,2),
RS00825         DECIMAL(12,2),
RS00826         DECIMAL(12,2),

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
RS00911         DECIMAL(12,2),
RS00912         DECIMAL(12,2),
RS00913         DECIMAL(12,2),
RS00914         DECIMAL(12,2),
RS00915         DECIMAL(12,2),
RS00916         DECIMAL(12,2),
RS00917         DECIMAL(12,2),
RS00918         DECIMAL(12,2),
RS00919         DECIMAL(12,2),
RS00920         DECIMAL(12,2),
RS00921         DECIMAL(12,2),
RS00922         DECIMAL(12,2),
RS00923         DECIMAL(12,2),
RS00924         DECIMAL(12,2),
RS00925         DECIMAL(12,2),
RS00926         DECIMAL(12,2)



);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia


//vloz vykaz do vytvorenej databazy riadky 1,6,8
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

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
$polozky[] = array("RS00111", "N", 15, 2);
$polozky[] = array("RS00112", "N", 15, 2);
$polozky[] = array("RS00113", "N", 15, 2);
$polozky[] = array("RS00114", "N", 15, 2);
$polozky[] = array("RS00115", "N", 15, 2);
$polozky[] = array("RS00116", "N", 15, 2);
$polozky[] = array("RS00117", "N", 15, 2);
$polozky[] = array("RS00118", "N", 15, 2);
$polozky[] = array("RS00119", "N", 15, 2);
$polozky[] = array("RS00120", "N", 15, 2);
$polozky[] = array("RS00121", "N", 15, 2);
$polozky[] = array("RS00122", "N", 15, 2);
$polozky[] = array("RS00123", "N", 15, 2);
$polozky[] = array("RS00124", "N", 15, 2);
$polozky[] = array("RS00125", "N", 15, 2);
$polozky[] = array("RS00126", "N", 15, 2);

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
$polozky[] = array("RS00211", "N", 15, 2);
$polozky[] = array("RS00212", "N", 15, 2);
$polozky[] = array("RS00213", "N", 15, 2);
$polozky[] = array("RS00214", "N", 15, 2);
$polozky[] = array("RS00215", "N", 15, 2);
$polozky[] = array("RS00216", "N", 15, 2);
$polozky[] = array("RS00217", "N", 15, 2);
$polozky[] = array("RS00218", "N", 15, 2);
$polozky[] = array("RS00219", "N", 15, 2);
$polozky[] = array("RS00220", "N", 15, 2);
$polozky[] = array("RS00221", "N", 15, 2);
$polozky[] = array("RS00222", "N", 15, 2);
$polozky[] = array("RS00223", "N", 15, 2);
$polozky[] = array("RS00224", "N", 15, 2);
$polozky[] = array("RS00225", "N", 15, 2);
$polozky[] = array("RS00226", "N", 15, 2);

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
$polozky[] = array("RS00311", "N", 15, 2);
$polozky[] = array("RS00312", "N", 15, 2);
$polozky[] = array("RS00313", "N", 15, 2);
$polozky[] = array("RS00314", "N", 15, 2);
$polozky[] = array("RS00315", "N", 15, 2);
$polozky[] = array("RS00316", "N", 15, 2);
$polozky[] = array("RS00317", "N", 15, 2);
$polozky[] = array("RS00318", "N", 15, 2);
$polozky[] = array("RS00319", "N", 15, 2);
$polozky[] = array("RS00320", "N", 15, 2);
$polozky[] = array("RS00321", "N", 15, 2);
$polozky[] = array("RS00322", "N", 15, 2);
$polozky[] = array("RS00323", "N", 15, 2);
$polozky[] = array("RS00324", "N", 15, 2);
$polozky[] = array("RS00325", "N", 15, 2);
$polozky[] = array("RS00326", "N", 15, 2);

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
$polozky[] = array("RS00411", "N", 15, 2);
$polozky[] = array("RS00412", "N", 15, 2);
$polozky[] = array("RS00413", "N", 15, 2);
$polozky[] = array("RS00414", "N", 15, 2);
$polozky[] = array("RS00415", "N", 15, 2);
$polozky[] = array("RS00416", "N", 15, 2);
$polozky[] = array("RS00417", "N", 15, 2);
$polozky[] = array("RS00418", "N", 15, 2);
$polozky[] = array("RS00419", "N", 15, 2);
$polozky[] = array("RS00420", "N", 15, 2);
$polozky[] = array("RS00421", "N", 15, 2);
$polozky[] = array("RS00422", "N", 15, 2);
$polozky[] = array("RS00423", "N", 15, 2);
$polozky[] = array("RS00424", "N", 15, 2);
$polozky[] = array("RS00425", "N", 15, 2);
$polozky[] = array("RS00426", "N", 15, 2);

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
$polozky[] = array("RS00511", "N", 15, 2);
$polozky[] = array("RS00512", "N", 15, 2);
$polozky[] = array("RS00513", "N", 15, 2);
$polozky[] = array("RS00514", "N", 15, 2);
$polozky[] = array("RS00515", "N", 15, 2);
$polozky[] = array("RS00516", "N", 15, 2);
$polozky[] = array("RS00517", "N", 15, 2);
$polozky[] = array("RS00518", "N", 15, 2);
$polozky[] = array("RS00519", "N", 15, 2);
$polozky[] = array("RS00520", "N", 15, 2);
$polozky[] = array("RS00521", "N", 15, 2);
$polozky[] = array("RS00522", "N", 15, 2);
$polozky[] = array("RS00523", "N", 15, 2);
$polozky[] = array("RS00524", "N", 15, 2);
$polozky[] = array("RS00525", "N", 15, 2);
$polozky[] = array("RS00526", "N", 15, 2);

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
$polozky[] = array("RS00611", "N", 15, 2);
$polozky[] = array("RS00612", "N", 15, 2);
$polozky[] = array("RS00613", "N", 15, 2);
$polozky[] = array("RS00614", "N", 15, 2);
$polozky[] = array("RS00615", "N", 15, 2);
$polozky[] = array("RS00616", "N", 15, 2);
$polozky[] = array("RS00617", "N", 15, 2);
$polozky[] = array("RS00618", "N", 15, 2);
$polozky[] = array("RS00619", "N", 15, 2);
$polozky[] = array("RS00620", "N", 15, 2);
$polozky[] = array("RS00621", "N", 15, 2);
$polozky[] = array("RS00622", "N", 15, 2);
$polozky[] = array("RS00623", "N", 15, 2);
$polozky[] = array("RS00624", "N", 15, 2);
$polozky[] = array("RS00625", "N", 15, 2);
$polozky[] = array("RS00626", "N", 15, 2);

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
$polozky[] = array("RS00711", "N", 15, 2);
$polozky[] = array("RS00712", "N", 15, 2);
$polozky[] = array("RS00713", "N", 15, 2);
$polozky[] = array("RS00714", "N", 15, 2);
$polozky[] = array("RS00715", "N", 15, 2);
$polozky[] = array("RS00716", "N", 15, 2);
$polozky[] = array("RS00717", "N", 15, 2);
$polozky[] = array("RS00718", "N", 15, 2);
$polozky[] = array("RS00719", "N", 15, 2);
$polozky[] = array("RS00720", "N", 15, 2);
$polozky[] = array("RS00721", "N", 15, 2);
$polozky[] = array("RS00722", "N", 15, 2);
$polozky[] = array("RS00723", "N", 15, 2);
$polozky[] = array("RS00724", "N", 15, 2);
$polozky[] = array("RS00725", "N", 15, 2);
$polozky[] = array("RS00726", "N", 15, 2);

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
$polozky[] = array("RS00811", "N", 15, 2);
$polozky[] = array("RS00812", "N", 15, 2);
$polozky[] = array("RS00813", "N", 15, 2);
$polozky[] = array("RS00814", "N", 15, 2);
$polozky[] = array("RS00815", "N", 15, 2);
$polozky[] = array("RS00816", "N", 15, 2);
$polozky[] = array("RS00817", "N", 15, 2);
$polozky[] = array("RS00818", "N", 15, 2);
$polozky[] = array("RS00819", "N", 15, 2);
$polozky[] = array("RS00820", "N", 15, 2);
$polozky[] = array("RS00821", "N", 15, 2);
$polozky[] = array("RS00822", "N", 15, 2);
$polozky[] = array("RS00823", "N", 15, 2);
$polozky[] = array("RS00824", "N", 15, 2);
$polozky[] = array("RS00825", "N", 15, 2);
$polozky[] = array("RS00826", "N", 15, 2);

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
$polozky[] = array("RS00911", "N", 15, 2);
$polozky[] = array("RS00912", "N", 15, 2);
$polozky[] = array("RS00913", "N", 15, 2);
$polozky[] = array("RS00914", "N", 15, 2);
$polozky[] = array("RS00915", "N", 15, 2);
$polozky[] = array("RS00916", "N", 15, 2);
$polozky[] = array("RS00917", "N", 15, 2);
$polozky[] = array("RS00918", "N", 15, 2);
$polozky[] = array("RS00919", "N", 15, 2);
$polozky[] = array("RS00920", "N", 15, 2);
$polozky[] = array("RS00921", "N", 15, 2);
$polozky[] = array("RS00922", "N", 15, 2);
$polozky[] = array("RS00923", "N", 15, 2);
$polozky[] = array("RS00924", "N", 15, 2);
$polozky[] = array("RS00925", "N", 15, 2);
$polozky[] = array("RS00926", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P1_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P1_".$kli_uzid."_".$hhmmss.".dbf";
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P1.DBF


/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P2.DBF
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {


$sqlt = <<<fin4pdbf
(

);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


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
RS01011         DECIMAL(12,2),
RS01012         DECIMAL(12,2),
RS01013         DECIMAL(12,2),
RS01014         DECIMAL(12,2),
RS01015         DECIMAL(12,2),
RS01016         DECIMAL(12,2),
RS01017         DECIMAL(12,2),
RS01018         DECIMAL(12,2),
RS01019         DECIMAL(12,2),
RS01020         DECIMAL(12,2),
RS01021         DECIMAL(12,2),
RS01022         DECIMAL(12,2),
RS01023         DECIMAL(12,2),
RS01024         DECIMAL(12,2),
RS01025         DECIMAL(12,2),
RS01026         DECIMAL(12,2),

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
RS01111         DECIMAL(12,2),
RS01112         DECIMAL(12,2),
RS01113         DECIMAL(12,2),
RS01114         DECIMAL(12,2),
RS01115         DECIMAL(12,2),
RS01116         DECIMAL(12,2),
RS01117         DECIMAL(12,2),
RS01118         DECIMAL(12,2),
RS01119         DECIMAL(12,2),
RS01120         DECIMAL(12,2),
RS01121         DECIMAL(12,2),
RS01122         DECIMAL(12,2),
RS01123         DECIMAL(12,2),
RS01124         DECIMAL(12,2),
RS01125         DECIMAL(12,2),
RS01126         DECIMAL(12,2),

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
RS01211         DECIMAL(12,2),
RS01212         DECIMAL(12,2),
RS01213         DECIMAL(12,2),
RS01214         DECIMAL(12,2),
RS01215         DECIMAL(12,2),
RS01216         DECIMAL(12,2),
RS01217         DECIMAL(12,2),
RS01218         DECIMAL(12,2),
RS01219         DECIMAL(12,2),
RS01220         DECIMAL(12,2),
RS01221         DECIMAL(12,2),
RS01222         DECIMAL(12,2),
RS01223         DECIMAL(12,2),
RS01224         DECIMAL(12,2),
RS01225         DECIMAL(12,2),
RS01226         DECIMAL(12,2),

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
RS01311         DECIMAL(12,2),
RS01312         DECIMAL(12,2),
RS01313         DECIMAL(12,2),
RS01314         DECIMAL(12,2),
RS01315         DECIMAL(12,2),
RS01316         DECIMAL(12,2),
RS01317         DECIMAL(12,2),
RS01318         DECIMAL(12,2),
RS01319         DECIMAL(12,2),
RS01320         DECIMAL(12,2),
RS01321         DECIMAL(12,2),
RS01322         DECIMAL(12,2),
RS01323         DECIMAL(12,2),
RS01324         DECIMAL(12,2),
RS01325         DECIMAL(12,2),
RS01326         DECIMAL(12,2),

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
RS01411         DECIMAL(12,2),
RS01412         DECIMAL(12,2),
RS01413         DECIMAL(12,2),
RS01414         DECIMAL(12,2),
RS01415         DECIMAL(12,2),
RS01416         DECIMAL(12,2),
RS01417         DECIMAL(12,2),
RS01418         DECIMAL(12,2),
RS01419         DECIMAL(12,2),
RS01420         DECIMAL(12,2),
RS01421         DECIMAL(12,2),
RS01422         DECIMAL(12,2),
RS01423         DECIMAL(12,2),
RS01424         DECIMAL(12,2),
RS01425         DECIMAL(12,2),
RS01426         DECIMAL(12,2),

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
RS01511         DECIMAL(12,2),
RS01512         DECIMAL(12,2),
RS01513         DECIMAL(12,2),
RS01514         DECIMAL(12,2),
RS01515         DECIMAL(12,2),
RS01516         DECIMAL(12,2),
RS01517         DECIMAL(12,2),
RS01518         DECIMAL(12,2),
RS01519         DECIMAL(12,2),
RS01520         DECIMAL(12,2),
RS01521         DECIMAL(12,2),
RS01522         DECIMAL(12,2),
RS01523         DECIMAL(12,2),
RS01524         DECIMAL(12,2),
RS01525         DECIMAL(12,2),
RS01526         DECIMAL(12,2),

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
RS01611         DECIMAL(12,2),
RS01612         DECIMAL(12,2),
RS01613         DECIMAL(12,2),
RS01614         DECIMAL(12,2),
RS01615         DECIMAL(12,2),
RS01616         DECIMAL(12,2),
RS01617         DECIMAL(12,2),
RS01618         DECIMAL(12,2),
RS01619         DECIMAL(12,2),
RS01620         DECIMAL(12,2),
RS01621         DECIMAL(12,2),
RS01622         DECIMAL(12,2),
RS01623         DECIMAL(12,2),
RS01624         DECIMAL(12,2),
RS01625         DECIMAL(12,2),
RS01626         DECIMAL(12,2),

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
RS01711         DECIMAL(12,2),
RS01712         DECIMAL(12,2),
RS01713         DECIMAL(12,2),
RS01714         DECIMAL(12,2),
RS01715         DECIMAL(12,2),
RS01716         DECIMAL(12,2),
RS01717         DECIMAL(12,2),
RS01718         DECIMAL(12,2),
RS01719         DECIMAL(12,2),
RS01720         DECIMAL(12,2),
RS01721         DECIMAL(12,2),
RS01722         DECIMAL(12,2),
RS01723         DECIMAL(12,2),
RS01724         DECIMAL(12,2),
RS01725         DECIMAL(12,2),
RS01726         DECIMAL(12,2),

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
RS01811         DECIMAL(12,2),
RS01812         DECIMAL(12,2),
RS01813         DECIMAL(12,2),
RS01814         DECIMAL(12,2),
RS01815         DECIMAL(12,2),
RS01816         DECIMAL(12,2),
RS01817         DECIMAL(12,2),
RS01818         DECIMAL(12,2),
RS01819         DECIMAL(12,2),
RS01820         DECIMAL(12,2),
RS01821         DECIMAL(12,2),
RS01822         DECIMAL(12,2),
RS01823         DECIMAL(12,2),
RS01824         DECIMAL(12,2),
RS01825         DECIMAL(12,2),
RS01826         DECIMAL(12,2)

);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy riadky 13, 18
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky2[] = array("ICO", "C", 8);
$polozky2[] = array("DATROK", "C", 4);
$polozky2[] = array("DATMES", "C", 2);
$polozky2[] = array("TYPORG", "C", 2);


$polozky2[] = array("RS01001", "N", 15, 2);
$polozky2[] = array("RS01002", "N", 15, 2);
$polozky2[] = array("RS01003", "N", 15, 2);
$polozky2[] = array("RS01004", "N", 15, 2);
$polozky2[] = array("RS01005", "N", 15, 2);
$polozky2[] = array("RS01006", "N", 15, 2);
$polozky2[] = array("RS01007", "N", 15, 2);
$polozky2[] = array("RS01008", "N", 15, 2);
$polozky2[] = array("RS01009", "N", 15, 2);
$polozky2[] = array("RS01010", "N", 15, 2);
$polozky2[] = array("RS01011", "N", 15, 2);
$polozky2[] = array("RS01012", "N", 15, 2);
$polozky2[] = array("RS01013", "N", 15, 2);
$polozky2[] = array("RS01014", "N", 15, 2);
$polozky2[] = array("RS01015", "N", 15, 2);
$polozky2[] = array("RS01016", "N", 15, 2);
$polozky2[] = array("RS01017", "N", 15, 2);
$polozky2[] = array("RS01018", "N", 15, 2);
$polozky2[] = array("RS01019", "N", 15, 2);
$polozky2[] = array("RS01020", "N", 15, 2);
$polozky2[] = array("RS01021", "N", 15, 2);
$polozky2[] = array("RS01022", "N", 15, 2);
$polozky2[] = array("RS01023", "N", 15, 2);
$polozky2[] = array("RS01024", "N", 15, 2);
$polozky2[] = array("RS01025", "N", 15, 2);
$polozky2[] = array("RS01026", "N", 15, 2);

$polozky2[] = array("RS01101", "N", 15, 2);
$polozky2[] = array("RS01102", "N", 15, 2);
$polozky2[] = array("RS01103", "N", 15, 2);
$polozky2[] = array("RS01104", "N", 15, 2);
$polozky2[] = array("RS01105", "N", 15, 2);
$polozky2[] = array("RS01106", "N", 15, 2);
$polozky2[] = array("RS01107", "N", 15, 2);
$polozky2[] = array("RS01108", "N", 15, 2);
$polozky2[] = array("RS01109", "N", 15, 2);
$polozky2[] = array("RS01110", "N", 15, 2);
$polozky2[] = array("RS01111", "N", 15, 2);
$polozky2[] = array("RS01112", "N", 15, 2);
$polozky2[] = array("RS01113", "N", 15, 2);
$polozky2[] = array("RS01114", "N", 15, 2);
$polozky2[] = array("RS01115", "N", 15, 2);
$polozky2[] = array("RS01116", "N", 15, 2);
$polozky2[] = array("RS01117", "N", 15, 2);
$polozky2[] = array("RS01118", "N", 15, 2);
$polozky2[] = array("RS01119", "N", 15, 2);
$polozky2[] = array("RS01120", "N", 15, 2);
$polozky2[] = array("RS01121", "N", 15, 2);
$polozky2[] = array("RS01122", "N", 15, 2);
$polozky2[] = array("RS01123", "N", 15, 2);
$polozky2[] = array("RS01124", "N", 15, 2);
$polozky2[] = array("RS01125", "N", 15, 2);
$polozky2[] = array("RS01126", "N", 15, 2);

$polozky2[] = array("RS01201", "N", 15, 2);
$polozky2[] = array("RS01202", "N", 15, 2);
$polozky2[] = array("RS01203", "N", 15, 2);
$polozky2[] = array("RS01204", "N", 15, 2);
$polozky2[] = array("RS01205", "N", 15, 2);
$polozky2[] = array("RS01206", "N", 15, 2);
$polozky2[] = array("RS01207", "N", 15, 2);
$polozky2[] = array("RS01208", "N", 15, 2);
$polozky2[] = array("RS01209", "N", 15, 2);
$polozky2[] = array("RS01210", "N", 15, 2);
$polozky2[] = array("RS01211", "N", 15, 2);
$polozky2[] = array("RS01212", "N", 15, 2);
$polozky2[] = array("RS01213", "N", 15, 2);
$polozky2[] = array("RS01214", "N", 15, 2);
$polozky2[] = array("RS01215", "N", 15, 2);
$polozky2[] = array("RS01216", "N", 15, 2);
$polozky2[] = array("RS01217", "N", 15, 2);
$polozky2[] = array("RS01218", "N", 15, 2);
$polozky2[] = array("RS01219", "N", 15, 2);
$polozky2[] = array("RS01220", "N", 15, 2);
$polozky2[] = array("RS01221", "N", 15, 2);
$polozky2[] = array("RS01222", "N", 15, 2);
$polozky2[] = array("RS01223", "N", 15, 2);
$polozky2[] = array("RS01224", "N", 15, 2);
$polozky2[] = array("RS01225", "N", 15, 2);
$polozky2[] = array("RS01226", "N", 15, 2);

$polozky2[] = array("RS01301", "N", 15, 2);
$polozky2[] = array("RS01302", "N", 15, 2);
$polozky2[] = array("RS01303", "N", 15, 2);
$polozky2[] = array("RS01304", "N", 15, 2);
$polozky2[] = array("RS01305", "N", 15, 2);
$polozky2[] = array("RS01306", "N", 15, 2);
$polozky2[] = array("RS01307", "N", 15, 2);
$polozky2[] = array("RS01308", "N", 15, 2);
$polozky2[] = array("RS01309", "N", 15, 2);
$polozky2[] = array("RS01310", "N", 15, 2);
$polozky2[] = array("RS01311", "N", 15, 2);
$polozky2[] = array("RS01312", "N", 15, 2);
$polozky2[] = array("RS01313", "N", 15, 2);
$polozky2[] = array("RS01314", "N", 15, 2);
$polozky2[] = array("RS01315", "N", 15, 2);
$polozky2[] = array("RS01316", "N", 15, 2);
$polozky2[] = array("RS01317", "N", 15, 2);
$polozky2[] = array("RS01318", "N", 15, 2);
$polozky2[] = array("RS01319", "N", 15, 2);
$polozky2[] = array("RS01320", "N", 15, 2);
$polozky2[] = array("RS01321", "N", 15, 2);
$polozky2[] = array("RS01322", "N", 15, 2);
$polozky2[] = array("RS01323", "N", 15, 2);
$polozky2[] = array("RS01324", "N", 15, 2);
$polozky2[] = array("RS01325", "N", 15, 2);
$polozky2[] = array("RS01326", "N", 15, 2);

$polozky2[] = array("RS01401", "N", 15, 2);
$polozky2[] = array("RS01402", "N", 15, 2);
$polozky2[] = array("RS01403", "N", 15, 2);
$polozky2[] = array("RS01404", "N", 15, 2);
$polozky2[] = array("RS01405", "N", 15, 2);
$polozky2[] = array("RS01406", "N", 15, 2);
$polozky2[] = array("RS01407", "N", 15, 2);
$polozky2[] = array("RS01408", "N", 15, 2);
$polozky2[] = array("RS01409", "N", 15, 2);
$polozky2[] = array("RS01410", "N", 15, 2);
$polozky2[] = array("RS01411", "N", 15, 2);
$polozky2[] = array("RS01412", "N", 15, 2);
$polozky2[] = array("RS01413", "N", 15, 2);
$polozky2[] = array("RS01414", "N", 15, 2);
$polozky2[] = array("RS01415", "N", 15, 2);
$polozky2[] = array("RS01416", "N", 15, 2);
$polozky2[] = array("RS01417", "N", 15, 2);
$polozky2[] = array("RS01418", "N", 15, 2);
$polozky2[] = array("RS01419", "N", 15, 2);
$polozky2[] = array("RS01420", "N", 15, 2);
$polozky2[] = array("RS01421", "N", 15, 2);
$polozky2[] = array("RS01422", "N", 15, 2);
$polozky2[] = array("RS01423", "N", 15, 2);
$polozky2[] = array("RS01424", "N", 15, 2);
$polozky2[] = array("RS01425", "N", 15, 2);
$polozky2[] = array("RS01426", "N", 15, 2);

$polozky2[] = array("RS01501", "N", 15, 2);
$polozky2[] = array("RS01502", "N", 15, 2);
$polozky2[] = array("RS01503", "N", 15, 2);
$polozky2[] = array("RS01504", "N", 15, 2);
$polozky2[] = array("RS01505", "N", 15, 2);
$polozky2[] = array("RS01506", "N", 15, 2);
$polozky2[] = array("RS01507", "N", 15, 2);
$polozky2[] = array("RS01508", "N", 15, 2);
$polozky2[] = array("RS01509", "N", 15, 2);
$polozky2[] = array("RS01510", "N", 15, 2);
$polozky2[] = array("RS01511", "N", 15, 2);
$polozky2[] = array("RS01512", "N", 15, 2);
$polozky2[] = array("RS01513", "N", 15, 2);
$polozky2[] = array("RS01514", "N", 15, 2);
$polozky2[] = array("RS01515", "N", 15, 2);
$polozky2[] = array("RS01516", "N", 15, 2);
$polozky2[] = array("RS01517", "N", 15, 2);
$polozky2[] = array("RS01518", "N", 15, 2);
$polozky2[] = array("RS01519", "N", 15, 2);
$polozky2[] = array("RS01520", "N", 15, 2);
$polozky2[] = array("RS01521", "N", 15, 2);
$polozky2[] = array("RS01522", "N", 15, 2);
$polozky2[] = array("RS01523", "N", 15, 2);
$polozky2[] = array("RS01524", "N", 15, 2);
$polozky2[] = array("RS01525", "N", 15, 2);
$polozky2[] = array("RS01526", "N", 15, 2);

$polozky2[] = array("RS01601", "N", 15, 2);
$polozky2[] = array("RS01602", "N", 15, 2);
$polozky2[] = array("RS01603", "N", 15, 2);
$polozky2[] = array("RS01604", "N", 15, 2);
$polozky2[] = array("RS01605", "N", 15, 2);
$polozky2[] = array("RS01606", "N", 15, 2);
$polozky2[] = array("RS01607", "N", 15, 2);
$polozky2[] = array("RS01608", "N", 15, 2);
$polozky2[] = array("RS01609", "N", 15, 2);
$polozky2[] = array("RS01610", "N", 15, 2);
$polozky2[] = array("RS01611", "N", 15, 2);
$polozky2[] = array("RS01612", "N", 15, 2);
$polozky2[] = array("RS01613", "N", 15, 2);
$polozky2[] = array("RS01614", "N", 15, 2);
$polozky2[] = array("RS01615", "N", 15, 2);
$polozky2[] = array("RS01616", "N", 15, 2);
$polozky2[] = array("RS01617", "N", 15, 2);
$polozky2[] = array("RS01618", "N", 15, 2);
$polozky2[] = array("RS01619", "N", 15, 2);
$polozky2[] = array("RS01620", "N", 15, 2);
$polozky2[] = array("RS01621", "N", 15, 2);
$polozky2[] = array("RS01622", "N", 15, 2);
$polozky2[] = array("RS01623", "N", 15, 2);
$polozky2[] = array("RS01624", "N", 15, 2);
$polozky2[] = array("RS01625", "N", 15, 2);
$polozky2[] = array("RS01626", "N", 15, 2);

$polozky2[] = array("RS01701", "N", 15, 2);
$polozky2[] = array("RS01702", "N", 15, 2);
$polozky2[] = array("RS01703", "N", 15, 2);
$polozky2[] = array("RS01704", "N", 15, 2);
$polozky2[] = array("RS01705", "N", 15, 2);
$polozky2[] = array("RS01706", "N", 15, 2);
$polozky2[] = array("RS01707", "N", 15, 2);
$polozky2[] = array("RS01708", "N", 15, 2);
$polozky2[] = array("RS01709", "N", 15, 2);
$polozky2[] = array("RS01710", "N", 15, 2);
$polozky2[] = array("RS01711", "N", 15, 2);
$polozky2[] = array("RS01712", "N", 15, 2);
$polozky2[] = array("RS01713", "N", 15, 2);
$polozky2[] = array("RS01714", "N", 15, 2);
$polozky2[] = array("RS01715", "N", 15, 2);
$polozky2[] = array("RS01716", "N", 15, 2);
$polozky2[] = array("RS01717", "N", 15, 2);
$polozky2[] = array("RS01718", "N", 15, 2);
$polozky2[] = array("RS01719", "N", 15, 2);
$polozky2[] = array("RS01720", "N", 15, 2);
$polozky2[] = array("RS01721", "N", 15, 2);
$polozky2[] = array("RS01722", "N", 15, 2);
$polozky2[] = array("RS01723", "N", 15, 2);
$polozky2[] = array("RS01724", "N", 15, 2);
$polozky2[] = array("RS01725", "N", 15, 2);
$polozky2[] = array("RS01726", "N", 15, 2);

$polozky2[] = array("RS01801", "N", 15, 2);
$polozky2[] = array("RS01802", "N", 15, 2);
$polozky2[] = array("RS01803", "N", 15, 2);
$polozky2[] = array("RS01804", "N", 15, 2);
$polozky2[] = array("RS01805", "N", 15, 2);
$polozky2[] = array("RS01806", "N", 15, 2);
$polozky2[] = array("RS01807", "N", 15, 2);
$polozky2[] = array("RS01808", "N", 15, 2);
$polozky2[] = array("RS01809", "N", 15, 2);
$polozky2[] = array("RS01810", "N", 15, 2);
$polozky2[] = array("RS01811", "N", 15, 2);
$polozky2[] = array("RS01812", "N", 15, 2);
$polozky2[] = array("RS01813", "N", 15, 2);
$polozky2[] = array("RS01814", "N", 15, 2);
$polozky2[] = array("RS01815", "N", 15, 2);
$polozky2[] = array("RS01816", "N", 15, 2);
$polozky2[] = array("RS01817", "N", 15, 2);
$polozky2[] = array("RS01818", "N", 15, 2);
$polozky2[] = array("RS01819", "N", 15, 2);
$polozky2[] = array("RS01820", "N", 15, 2);
$polozky2[] = array("RS01821", "N", 15, 2);
$polozky2[] = array("RS01822", "N", 15, 2);
$polozky2[] = array("RS01823", "N", 15, 2);
$polozky2[] = array("RS01824", "N", 15, 2);
$polozky2[] = array("RS01825", "N", 15, 2);
$polozky2[] = array("RS01826", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P2_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P2_".$kli_uzid."_".$hhmmss.".dbf";
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru2"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P2.DBF

?> 

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P3.DBF
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {



$sqlt = <<<fin4pdbf
(

);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


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
RS01911         DECIMAL(12,2),
RS01912         DECIMAL(12,2),
RS01913         DECIMAL(12,2),
RS01914         DECIMAL(12,2),
RS01915         DECIMAL(12,2),
RS01916         DECIMAL(12,2),
RS01917         DECIMAL(12,2),
RS01918         DECIMAL(12,2),
RS01919         DECIMAL(12,2),
RS01920         DECIMAL(12,2),
RS01921         DECIMAL(12,2),
RS01922         DECIMAL(12,2),
RS01923         DECIMAL(12,2),
RS01924         DECIMAL(12,2),
RS01925         DECIMAL(12,2),
RS01926         DECIMAL(12,2),

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
RS02011         DECIMAL(12,2),
RS02012         DECIMAL(12,2),
RS02013         DECIMAL(12,2),
RS02014         DECIMAL(12,2),
RS02015         DECIMAL(12,2),
RS02016         DECIMAL(12,2),
RS02017         DECIMAL(12,2),
RS02018         DECIMAL(12,2),
RS02019         DECIMAL(12,2),
RS02020         DECIMAL(12,2),
RS02021         DECIMAL(12,2),
RS02022         DECIMAL(12,2),
RS02023         DECIMAL(12,2),
RS02024         DECIMAL(12,2),
RS02025         DECIMAL(12,2),
RS02026         DECIMAL(12,2),

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
RS02111         DECIMAL(12,2),
RS02112         DECIMAL(12,2),
RS02113         DECIMAL(12,2),
RS02114         DECIMAL(12,2),
RS02115         DECIMAL(12,2),
RS02116         DECIMAL(12,2),
RS02117         DECIMAL(12,2),
RS02118         DECIMAL(12,2),
RS02119         DECIMAL(12,2),
RS02120         DECIMAL(12,2),
RS02121         DECIMAL(12,2),
RS02122         DECIMAL(12,2),
RS02123         DECIMAL(12,2),
RS02124         DECIMAL(12,2),
RS02125         DECIMAL(12,2),
RS02126         DECIMAL(12,2),

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
RS02211         DECIMAL(12,2),
RS02212         DECIMAL(12,2),
RS02213         DECIMAL(12,2),
RS02214         DECIMAL(12,2),
RS02215         DECIMAL(12,2),
RS02216         DECIMAL(12,2),
RS02217         DECIMAL(12,2),
RS02218         DECIMAL(12,2),
RS02219         DECIMAL(12,2),
RS02220         DECIMAL(12,2),
RS02221         DECIMAL(12,2),
RS02222         DECIMAL(12,2),
RS02223         DECIMAL(12,2),
RS02224         DECIMAL(12,2),
RS02225         DECIMAL(12,2),
RS02226         DECIMAL(12,2),

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
RS02311         DECIMAL(12,2),
RS02312         DECIMAL(12,2),
RS02313         DECIMAL(12,2),
RS02314         DECIMAL(12,2),
RS02315         DECIMAL(12,2),
RS02316         DECIMAL(12,2),
RS02317         DECIMAL(12,2),
RS02318         DECIMAL(12,2),
RS02319         DECIMAL(12,2),
RS02320         DECIMAL(12,2),
RS02321         DECIMAL(12,2),
RS02322         DECIMAL(12,2),
RS02323         DECIMAL(12,2),
RS02324         DECIMAL(12,2),
RS02325         DECIMAL(12,2),
RS02326         DECIMAL(12,2),

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
RS02411         DECIMAL(12,2),
RS02412         DECIMAL(12,2),
RS02413         DECIMAL(12,2),
RS02414         DECIMAL(12,2),
RS02415         DECIMAL(12,2),
RS02416         DECIMAL(12,2),
RS02417         DECIMAL(12,2),
RS02418         DECIMAL(12,2),
RS02419         DECIMAL(12,2),
RS02420         DECIMAL(12,2),
RS02421         DECIMAL(12,2),
RS02422         DECIMAL(12,2),
RS02423         DECIMAL(12,2),
RS02424         DECIMAL(12,2),
RS02425         DECIMAL(12,2),
RS02426         DECIMAL(12,2),

RS02501         DECIMAL(12,2),
RS02502         DECIMAL(12,2),
RS02503         DECIMAL(12,2),
RS02504         DECIMAL(12,2),
RS02505         DECIMAL(12,2),
RS02506         DECIMAL(12,2),
RS02507         DECIMAL(12,2),
RS02508         DECIMAL(12,2),
RS02509         DECIMAL(12,2),
RS02510         DECIMAL(12,2),
RS02511         DECIMAL(12,2),
RS02512         DECIMAL(12,2),
RS02513         DECIMAL(12,2),
RS02514         DECIMAL(12,2),
RS02515         DECIMAL(12,2),
RS02516         DECIMAL(12,2),
RS02517         DECIMAL(12,2),
RS02518         DECIMAL(12,2),
RS02519         DECIMAL(12,2),
RS02520         DECIMAL(12,2),
RS02521         DECIMAL(12,2),
RS02522         DECIMAL(12,2),
RS02523         DECIMAL(12,2),
RS02524         DECIMAL(12,2),
RS02525         DECIMAL(12,2),
RS02526         DECIMAL(12,2),

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
RS02611         DECIMAL(12,2),
RS02612         DECIMAL(12,2),
RS02613         DECIMAL(12,2),
RS02614         DECIMAL(12,2),
RS02615         DECIMAL(12,2),
RS02616         DECIMAL(12,2),
RS02617         DECIMAL(12,2),
RS02618         DECIMAL(12,2),
RS02619         DECIMAL(12,2),
RS02620         DECIMAL(12,2),
RS02621         DECIMAL(12,2),
RS02622         DECIMAL(12,2),
RS02623         DECIMAL(12,2),
RS02624         DECIMAL(12,2),
RS02625         DECIMAL(12,2),
RS02626         DECIMAL(12,2),

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
RS02711         DECIMAL(12,2),
RS02712         DECIMAL(12,2),
RS02713         DECIMAL(12,2),
RS02714         DECIMAL(12,2),
RS02715         DECIMAL(12,2),
RS02716         DECIMAL(12,2),
RS02717         DECIMAL(12,2),
RS02718         DECIMAL(12,2),
RS02719         DECIMAL(12,2),
RS02720         DECIMAL(12,2),
RS02721         DECIMAL(12,2),
RS02722         DECIMAL(12,2),
RS02723         DECIMAL(12,2),
RS02724         DECIMAL(12,2),
RS02725         DECIMAL(12,2),
RS02726         DECIMAL(12,2)

);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy riadky 20 zvys 25 znis
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky3[] = array("ICO", "C", 8);
$polozky3[] = array("DATROK", "C", 4);
$polozky3[] = array("DATMES", "C", 2);
$polozky3[] = array("TYPORG", "C", 2);


$polozky3[] = array("RS01901", "N", 15, 2);
$polozky3[] = array("RS01902", "N", 15, 2);
$polozky3[] = array("RS01903", "N", 15, 2);
$polozky3[] = array("RS01904", "N", 15, 2);
$polozky3[] = array("RS01905", "N", 15, 2);
$polozky3[] = array("RS01906", "N", 15, 2);
$polozky3[] = array("RS01907", "N", 15, 2);
$polozky3[] = array("RS01908", "N", 15, 2);
$polozky3[] = array("RS01909", "N", 15, 2);
$polozky3[] = array("RS01910", "N", 15, 2);
$polozky3[] = array("RS01911", "N", 15, 2);
$polozky3[] = array("RS01912", "N", 15, 2);
$polozky3[] = array("RS01913", "N", 15, 2);
$polozky3[] = array("RS01914", "N", 15, 2);
$polozky3[] = array("RS01915", "N", 15, 2);
$polozky3[] = array("RS01916", "N", 15, 2);
$polozky3[] = array("RS01917", "N", 15, 2);
$polozky3[] = array("RS01918", "N", 15, 2);
$polozky3[] = array("RS01919", "N", 15, 2);
$polozky3[] = array("RS01920", "N", 15, 2);
$polozky3[] = array("RS01921", "N", 15, 2);
$polozky3[] = array("RS01922", "N", 15, 2);
$polozky3[] = array("RS01923", "N", 15, 2);
$polozky3[] = array("RS01924", "N", 15, 2);
$polozky3[] = array("RS01925", "N", 15, 2);
$polozky3[] = array("RS01926", "N", 15, 2);

$polozky3[] = array("RS02001", "N", 15, 2);
$polozky3[] = array("RS02002", "N", 15, 2);
$polozky3[] = array("RS02003", "N", 15, 2);
$polozky3[] = array("RS02004", "N", 15, 2);
$polozky3[] = array("RS02005", "N", 15, 2);
$polozky3[] = array("RS02006", "N", 15, 2);
$polozky3[] = array("RS02007", "N", 15, 2);
$polozky3[] = array("RS02008", "N", 15, 2);
$polozky3[] = array("RS02009", "N", 15, 2);
$polozky3[] = array("RS02010", "N", 15, 2);
$polozky3[] = array("RS02011", "N", 15, 2);
$polozky3[] = array("RS02012", "N", 15, 2);
$polozky3[] = array("RS02013", "N", 15, 2);
$polozky3[] = array("RS02014", "N", 15, 2);
$polozky3[] = array("RS02015", "N", 15, 2);
$polozky3[] = array("RS02016", "N", 15, 2);
$polozky3[] = array("RS02017", "N", 15, 2);
$polozky3[] = array("RS02018", "N", 15, 2);
$polozky3[] = array("RS02019", "N", 15, 2);
$polozky3[] = array("RS02020", "N", 15, 2);
$polozky3[] = array("RS02021", "N", 15, 2);
$polozky3[] = array("RS02022", "N", 15, 2);
$polozky3[] = array("RS02023", "N", 15, 2);
$polozky3[] = array("RS02024", "N", 15, 2);
$polozky3[] = array("RS02025", "N", 15, 2);
$polozky3[] = array("RS02026", "N", 15, 2);

$polozky3[] = array("RS02101", "N", 15, 2);
$polozky3[] = array("RS02102", "N", 15, 2);
$polozky3[] = array("RS02103", "N", 15, 2);
$polozky3[] = array("RS02104", "N", 15, 2);
$polozky3[] = array("RS02105", "N", 15, 2);
$polozky3[] = array("RS02106", "N", 15, 2);
$polozky3[] = array("RS02107", "N", 15, 2);
$polozky3[] = array("RS02108", "N", 15, 2);
$polozky3[] = array("RS02109", "N", 15, 2);
$polozky3[] = array("RS02110", "N", 15, 2);
$polozky3[] = array("RS02111", "N", 15, 2);
$polozky3[] = array("RS02112", "N", 15, 2);
$polozky3[] = array("RS02113", "N", 15, 2);
$polozky3[] = array("RS02114", "N", 15, 2);
$polozky3[] = array("RS02115", "N", 15, 2);
$polozky3[] = array("RS02116", "N", 15, 2);
$polozky3[] = array("RS02117", "N", 15, 2);
$polozky3[] = array("RS02118", "N", 15, 2);
$polozky3[] = array("RS02119", "N", 15, 2);
$polozky3[] = array("RS02120", "N", 15, 2);
$polozky3[] = array("RS02121", "N", 15, 2);
$polozky3[] = array("RS02122", "N", 15, 2);
$polozky3[] = array("RS02123", "N", 15, 2);
$polozky3[] = array("RS02124", "N", 15, 2);
$polozky3[] = array("RS02125", "N", 15, 2);
$polozky3[] = array("RS02126", "N", 15, 2);

$polozky3[] = array("RS02201", "N", 15, 2);
$polozky3[] = array("RS02202", "N", 15, 2);
$polozky3[] = array("RS02203", "N", 15, 2);
$polozky3[] = array("RS02204", "N", 15, 2);
$polozky3[] = array("RS02205", "N", 15, 2);
$polozky3[] = array("RS02206", "N", 15, 2);
$polozky3[] = array("RS02207", "N", 15, 2);
$polozky3[] = array("RS02208", "N", 15, 2);
$polozky3[] = array("RS02209", "N", 15, 2);
$polozky3[] = array("RS02210", "N", 15, 2);
$polozky3[] = array("RS02211", "N", 15, 2);
$polozky3[] = array("RS02212", "N", 15, 2);
$polozky3[] = array("RS02213", "N", 15, 2);
$polozky3[] = array("RS02214", "N", 15, 2);
$polozky3[] = array("RS02215", "N", 15, 2);
$polozky3[] = array("RS02216", "N", 15, 2);
$polozky3[] = array("RS02217", "N", 15, 2);
$polozky3[] = array("RS02218", "N", 15, 2);
$polozky3[] = array("RS02219", "N", 15, 2);
$polozky3[] = array("RS02220", "N", 15, 2);
$polozky3[] = array("RS02221", "N", 15, 2);
$polozky3[] = array("RS02222", "N", 15, 2);
$polozky3[] = array("RS02223", "N", 15, 2);
$polozky3[] = array("RS02224", "N", 15, 2);
$polozky3[] = array("RS02225", "N", 15, 2);
$polozky3[] = array("RS02226", "N", 15, 2);

$polozky3[] = array("RS02301", "N", 15, 2);
$polozky3[] = array("RS02302", "N", 15, 2);
$polozky3[] = array("RS02303", "N", 15, 2);
$polozky3[] = array("RS02304", "N", 15, 2);
$polozky3[] = array("RS02305", "N", 15, 2);
$polozky3[] = array("RS02306", "N", 15, 2);
$polozky3[] = array("RS02307", "N", 15, 2);
$polozky3[] = array("RS02308", "N", 15, 2);
$polozky3[] = array("RS02309", "N", 15, 2);
$polozky3[] = array("RS02310", "N", 15, 2);
$polozky3[] = array("RS02311", "N", 15, 2);
$polozky3[] = array("RS02312", "N", 15, 2);
$polozky3[] = array("RS02313", "N", 15, 2);
$polozky3[] = array("RS02314", "N", 15, 2);
$polozky3[] = array("RS02315", "N", 15, 2);
$polozky3[] = array("RS02316", "N", 15, 2);
$polozky3[] = array("RS02317", "N", 15, 2);
$polozky3[] = array("RS02318", "N", 15, 2);
$polozky3[] = array("RS02319", "N", 15, 2);
$polozky3[] = array("RS02320", "N", 15, 2);
$polozky3[] = array("RS02321", "N", 15, 2);
$polozky3[] = array("RS02322", "N", 15, 2);
$polozky3[] = array("RS02323", "N", 15, 2);
$polozky3[] = array("RS02324", "N", 15, 2);
$polozky3[] = array("RS02325", "N", 15, 2);
$polozky3[] = array("RS02326", "N", 15, 2);

$polozky3[] = array("RS02401", "N", 15, 2);
$polozky3[] = array("RS02402", "N", 15, 2);
$polozky3[] = array("RS02403", "N", 15, 2);
$polozky3[] = array("RS02404", "N", 15, 2);
$polozky3[] = array("RS02405", "N", 15, 2);
$polozky3[] = array("RS02406", "N", 15, 2);
$polozky3[] = array("RS02407", "N", 15, 2);
$polozky3[] = array("RS02408", "N", 15, 2);
$polozky3[] = array("RS02409", "N", 15, 2);
$polozky3[] = array("RS02410", "N", 15, 2);
$polozky3[] = array("RS02411", "N", 15, 2);
$polozky3[] = array("RS02412", "N", 15, 2);
$polozky3[] = array("RS02413", "N", 15, 2);
$polozky3[] = array("RS02414", "N", 15, 2);
$polozky3[] = array("RS02415", "N", 15, 2);
$polozky3[] = array("RS02416", "N", 15, 2);
$polozky3[] = array("RS02417", "N", 15, 2);
$polozky3[] = array("RS02418", "N", 15, 2);
$polozky3[] = array("RS02419", "N", 15, 2);
$polozky3[] = array("RS02420", "N", 15, 2);
$polozky3[] = array("RS02421", "N", 15, 2);
$polozky3[] = array("RS02422", "N", 15, 2);
$polozky3[] = array("RS02423", "N", 15, 2);
$polozky3[] = array("RS02424", "N", 15, 2);
$polozky3[] = array("RS02425", "N", 15, 2);
$polozky3[] = array("RS02426", "N", 15, 2);

$polozky3[] = array("RS02501", "N", 15, 2);
$polozky3[] = array("RS02502", "N", 15, 2);
$polozky3[] = array("RS02503", "N", 15, 2);
$polozky3[] = array("RS02504", "N", 15, 2);
$polozky3[] = array("RS02505", "N", 15, 2);
$polozky3[] = array("RS02506", "N", 15, 2);
$polozky3[] = array("RS02507", "N", 15, 2);
$polozky3[] = array("RS02508", "N", 15, 2);
$polozky3[] = array("RS02509", "N", 15, 2);
$polozky3[] = array("RS02510", "N", 15, 2);
$polozky3[] = array("RS02511", "N", 15, 2);
$polozky3[] = array("RS02512", "N", 15, 2);
$polozky3[] = array("RS02513", "N", 15, 2);
$polozky3[] = array("RS02514", "N", 15, 2);
$polozky3[] = array("RS02515", "N", 15, 2);
$polozky3[] = array("RS02516", "N", 15, 2);
$polozky3[] = array("RS02517", "N", 15, 2);
$polozky3[] = array("RS02518", "N", 15, 2);
$polozky3[] = array("RS02519", "N", 15, 2);
$polozky3[] = array("RS02520", "N", 15, 2);
$polozky3[] = array("RS02521", "N", 15, 2);
$polozky3[] = array("RS02522", "N", 15, 2);
$polozky3[] = array("RS02523", "N", 15, 2);
$polozky3[] = array("RS02524", "N", 15, 2);
$polozky3[] = array("RS02525", "N", 15, 2);
$polozky3[] = array("RS02526", "N", 15, 2);

$polozky3[] = array("RS02601", "N", 15, 2);
$polozky3[] = array("RS02602", "N", 15, 2);
$polozky3[] = array("RS02603", "N", 15, 2);
$polozky3[] = array("RS02604", "N", 15, 2);
$polozky3[] = array("RS02605", "N", 15, 2);
$polozky3[] = array("RS02606", "N", 15, 2);
$polozky3[] = array("RS02607", "N", 15, 2);
$polozky3[] = array("RS02608", "N", 15, 2);
$polozky3[] = array("RS02609", "N", 15, 2);
$polozky3[] = array("RS02610", "N", 15, 2);
$polozky3[] = array("RS02611", "N", 15, 2);
$polozky3[] = array("RS02612", "N", 15, 2);
$polozky3[] = array("RS02613", "N", 15, 2);
$polozky3[] = array("RS02614", "N", 15, 2);
$polozky3[] = array("RS02615", "N", 15, 2);
$polozky3[] = array("RS02616", "N", 15, 2);
$polozky3[] = array("RS02617", "N", 15, 2);
$polozky3[] = array("RS02618", "N", 15, 2);
$polozky3[] = array("RS02619", "N", 15, 2);
$polozky3[] = array("RS02620", "N", 15, 2);
$polozky3[] = array("RS02621", "N", 15, 2);
$polozky3[] = array("RS02622", "N", 15, 2);
$polozky3[] = array("RS02623", "N", 15, 2);
$polozky3[] = array("RS02624", "N", 15, 2);
$polozky3[] = array("RS02625", "N", 15, 2);
$polozky3[] = array("RS02626", "N", 15, 2);

$polozky3[] = array("RS02701", "N", 15, 2);
$polozky3[] = array("RS02702", "N", 15, 2);
$polozky3[] = array("RS02703", "N", 15, 2);
$polozky3[] = array("RS02704", "N", 15, 2);
$polozky3[] = array("RS02705", "N", 15, 2);
$polozky3[] = array("RS02706", "N", 15, 2);
$polozky3[] = array("RS02707", "N", 15, 2);
$polozky3[] = array("RS02708", "N", 15, 2);
$polozky3[] = array("RS02709", "N", 15, 2);
$polozky3[] = array("RS02710", "N", 15, 2);
$polozky3[] = array("RS02711", "N", 15, 2);
$polozky3[] = array("RS02712", "N", 15, 2);
$polozky3[] = array("RS02713", "N", 15, 2);
$polozky3[] = array("RS02714", "N", 15, 2);
$polozky3[] = array("RS02715", "N", 15, 2);
$polozky3[] = array("RS02716", "N", 15, 2);
$polozky3[] = array("RS02717", "N", 15, 2);
$polozky3[] = array("RS02718", "N", 15, 2);
$polozky3[] = array("RS02719", "N", 15, 2);
$polozky3[] = array("RS02720", "N", 15, 2);
$polozky3[] = array("RS02721", "N", 15, 2);
$polozky3[] = array("RS02722", "N", 15, 2);
$polozky3[] = array("RS02723", "N", 15, 2);
$polozky3[] = array("RS02724", "N", 15, 2);
$polozky3[] = array("RS02725", "N", 15, 2);
$polozky3[] = array("RS02726", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P3_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P3_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru3 = $outfilex;

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru3, $polozky3);
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru3"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P3.DBF
?> 

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P4.DBF
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {



$sqlt = <<<fin4pdbf
(

);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


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
RS02811         DECIMAL(12,2),
RS02812         DECIMAL(12,2),
RS02813         DECIMAL(12,2),
RS02814         DECIMAL(12,2),
RS02815         DECIMAL(12,2),
RS02816         DECIMAL(12,2),
RS02817         DECIMAL(12,2),
RS02818         DECIMAL(12,2),
RS02819         DECIMAL(12,2),
RS02820         DECIMAL(12,2),
RS02821         DECIMAL(12,2),
RS02822         DECIMAL(12,2),
RS02823         DECIMAL(12,2),
RS02824         DECIMAL(12,2),
RS02825         DECIMAL(12,2),
RS02826         DECIMAL(12,2),

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
RS02911         DECIMAL(12,2),
RS02912         DECIMAL(12,2),
RS02913         DECIMAL(12,2),
RS02914         DECIMAL(12,2),
RS02915         DECIMAL(12,2),
RS02916         DECIMAL(12,2),
RS02917         DECIMAL(12,2),
RS02918         DECIMAL(12,2),
RS02919         DECIMAL(12,2),
RS02920         DECIMAL(12,2),
RS02921         DECIMAL(12,2),
RS02922         DECIMAL(12,2),
RS02923         DECIMAL(12,2),
RS02924         DECIMAL(12,2),
RS02925         DECIMAL(12,2),
RS02926         DECIMAL(12,2),

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
RS03011         DECIMAL(12,2),
RS03012         DECIMAL(12,2),
RS03013         DECIMAL(12,2),
RS03014         DECIMAL(12,2),
RS03015         DECIMAL(12,2),
RS03016         DECIMAL(12,2),
RS03017         DECIMAL(12,2),
RS03018         DECIMAL(12,2),
RS03019         DECIMAL(12,2),
RS03020         DECIMAL(12,2),
RS03021         DECIMAL(12,2),
RS03022         DECIMAL(12,2),
RS03023         DECIMAL(12,2),
RS03024         DECIMAL(12,2),
RS03025         DECIMAL(12,2),
RS03026         DECIMAL(12,2),

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
RS03111         DECIMAL(12,2),
RS03112         DECIMAL(12,2),
RS03113         DECIMAL(12,2),
RS03114         DECIMAL(12,2),
RS03115         DECIMAL(12,2),
RS03116         DECIMAL(12,2),
RS03117         DECIMAL(12,2),
RS03118         DECIMAL(12,2),
RS03119         DECIMAL(12,2),
RS03120         DECIMAL(12,2),
RS03121         DECIMAL(12,2),
RS03122         DECIMAL(12,2),
RS03123         DECIMAL(12,2),
RS03124         DECIMAL(12,2),
RS03125         DECIMAL(12,2),
RS03126         DECIMAL(12,2),

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
RS03211         DECIMAL(12,2),
RS03212         DECIMAL(12,2),
RS03213         DECIMAL(12,2),
RS03214         DECIMAL(12,2),
RS03215         DECIMAL(12,2),
RS03216         DECIMAL(12,2),
RS03217         DECIMAL(12,2),
RS03218         DECIMAL(12,2),
RS03219         DECIMAL(12,2),
RS03220         DECIMAL(12,2),
RS03221         DECIMAL(12,2),
RS03222         DECIMAL(12,2),
RS03223         DECIMAL(12,2),
RS03224         DECIMAL(12,2),
RS03225         DECIMAL(12,2),
RS03226         DECIMAL(12,2),

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
RS03311         DECIMAL(12,2),
RS03312         DECIMAL(12,2),
RS03313         DECIMAL(12,2),
RS03314         DECIMAL(12,2),
RS03315         DECIMAL(12,2),
RS03316         DECIMAL(12,2),
RS03317         DECIMAL(12,2),
RS03318         DECIMAL(12,2),
RS03319         DECIMAL(12,2),
RS03320         DECIMAL(12,2),
RS03321         DECIMAL(12,2),
RS03322         DECIMAL(12,2),
RS03323         DECIMAL(12,2),
RS03324         DECIMAL(12,2),
RS03325         DECIMAL(12,2),
RS03326         DECIMAL(12,2),

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
RS03411         DECIMAL(12,2),
RS03412         DECIMAL(12,2),
RS03413         DECIMAL(12,2),
RS03414         DECIMAL(12,2),
RS03415         DECIMAL(12,2),
RS03416         DECIMAL(12,2),
RS03417         DECIMAL(12,2),
RS03418         DECIMAL(12,2),
RS03419         DECIMAL(12,2),
RS03420         DECIMAL(12,2),
RS03421         DECIMAL(12,2),
RS03422         DECIMAL(12,2),
RS03423         DECIMAL(12,2),
RS03424         DECIMAL(12,2),
RS03425         DECIMAL(12,2),
RS03426         DECIMAL(12,2),

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
RS03511         DECIMAL(12,2),
RS03512         DECIMAL(12,2),
RS03513         DECIMAL(12,2),
RS03514         DECIMAL(12,2),
RS03515         DECIMAL(12,2),
RS03516         DECIMAL(12,2),
RS03517         DECIMAL(12,2),
RS03518         DECIMAL(12,2),
RS03519         DECIMAL(12,2),
RS03520         DECIMAL(12,2),
RS03521         DECIMAL(12,2),
RS03522         DECIMAL(12,2),
RS03523         DECIMAL(12,2),
RS03524         DECIMAL(12,2),
RS03525         DECIMAL(12,2),
RS03526         DECIMAL(12,2),

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
RS03611         DECIMAL(12,2),
RS03612         DECIMAL(12,2),
RS03613         DECIMAL(12,2),
RS03614         DECIMAL(12,2),
RS03615         DECIMAL(12,2),
RS03616         DECIMAL(12,2),
RS03617         DECIMAL(12,2),
RS03618         DECIMAL(12,2),
RS03619         DECIMAL(12,2),
RS03620         DECIMAL(12,2),
RS03621         DECIMAL(12,2),
RS03622         DECIMAL(12,2),
RS03623         DECIMAL(12,2),
RS03624         DECIMAL(12,2),
RS03625         DECIMAL(12,2),
RS03626         DECIMAL(12,2)

);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy riadky 30 znis, 32 znis
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky4[] = array("ICO", "C", 8);
$polozky4[] = array("DATROK", "C", 4);
$polozky4[] = array("DATMES", "C", 2);
$polozky4[] = array("TYPORG", "C", 2);


$polozky4[] = array("RS02801", "N", 15, 2);
$polozky4[] = array("RS02802", "N", 15, 2);
$polozky4[] = array("RS02803", "N", 15, 2);
$polozky4[] = array("RS02804", "N", 15, 2);
$polozky4[] = array("RS02805", "N", 15, 2);
$polozky4[] = array("RS02806", "N", 15, 2);
$polozky4[] = array("RS02807", "N", 15, 2);
$polozky4[] = array("RS02808", "N", 15, 2);
$polozky4[] = array("RS02809", "N", 15, 2);
$polozky4[] = array("RS02810", "N", 15, 2);
$polozky4[] = array("RS02811", "N", 15, 2);
$polozky4[] = array("RS02812", "N", 15, 2);
$polozky4[] = array("RS02813", "N", 15, 2);
$polozky4[] = array("RS02814", "N", 15, 2);
$polozky4[] = array("RS02815", "N", 15, 2);
$polozky4[] = array("RS02816", "N", 15, 2);
$polozky4[] = array("RS02817", "N", 15, 2);
$polozky4[] = array("RS02818", "N", 15, 2);
$polozky4[] = array("RS02819", "N", 15, 2);
$polozky4[] = array("RS02820", "N", 15, 2);
$polozky4[] = array("RS02821", "N", 15, 2);
$polozky4[] = array("RS02822", "N", 15, 2);
$polozky4[] = array("RS02823", "N", 15, 2);
$polozky4[] = array("RS02824", "N", 15, 2);
$polozky4[] = array("RS02825", "N", 15, 2);
$polozky4[] = array("RS02826", "N", 15, 2);

$polozky4[] = array("RS02901", "N", 15, 2);
$polozky4[] = array("RS02902", "N", 15, 2);
$polozky4[] = array("RS02903", "N", 15, 2);
$polozky4[] = array("RS02904", "N", 15, 2);
$polozky4[] = array("RS02905", "N", 15, 2);
$polozky4[] = array("RS02906", "N", 15, 2);
$polozky4[] = array("RS02907", "N", 15, 2);
$polozky4[] = array("RS02908", "N", 15, 2);
$polozky4[] = array("RS02909", "N", 15, 2);
$polozky4[] = array("RS02910", "N", 15, 2);
$polozky4[] = array("RS02911", "N", 15, 2);
$polozky4[] = array("RS02912", "N", 15, 2);
$polozky4[] = array("RS02913", "N", 15, 2);
$polozky4[] = array("RS02914", "N", 15, 2);
$polozky4[] = array("RS02915", "N", 15, 2);
$polozky4[] = array("RS02916", "N", 15, 2);
$polozky4[] = array("RS02917", "N", 15, 2);
$polozky4[] = array("RS02918", "N", 15, 2);
$polozky4[] = array("RS02919", "N", 15, 2);
$polozky4[] = array("RS02920", "N", 15, 2);
$polozky4[] = array("RS02921", "N", 15, 2);
$polozky4[] = array("RS02922", "N", 15, 2);
$polozky4[] = array("RS02923", "N", 15, 2);
$polozky4[] = array("RS02924", "N", 15, 2);
$polozky4[] = array("RS02925", "N", 15, 2);
$polozky4[] = array("RS02926", "N", 15, 2);

$polozky4[] = array("RS03001", "N", 15, 2);
$polozky4[] = array("RS03002", "N", 15, 2);
$polozky4[] = array("RS03003", "N", 15, 2);
$polozky4[] = array("RS03004", "N", 15, 2);
$polozky4[] = array("RS03005", "N", 15, 2);
$polozky4[] = array("RS03006", "N", 15, 2);
$polozky4[] = array("RS03007", "N", 15, 2);
$polozky4[] = array("RS03008", "N", 15, 2);
$polozky4[] = array("RS03009", "N", 15, 2);
$polozky4[] = array("RS03010", "N", 15, 2);
$polozky4[] = array("RS03011", "N", 15, 2);
$polozky4[] = array("RS03012", "N", 15, 2);
$polozky4[] = array("RS03013", "N", 15, 2);
$polozky4[] = array("RS03014", "N", 15, 2);
$polozky4[] = array("RS03015", "N", 15, 2);
$polozky4[] = array("RS03016", "N", 15, 2);
$polozky4[] = array("RS03017", "N", 15, 2);
$polozky4[] = array("RS03018", "N", 15, 2);
$polozky4[] = array("RS03019", "N", 15, 2);
$polozky4[] = array("RS03020", "N", 15, 2);
$polozky4[] = array("RS03021", "N", 15, 2);
$polozky4[] = array("RS03022", "N", 15, 2);
$polozky4[] = array("RS03023", "N", 15, 2);
$polozky4[] = array("RS03024", "N", 15, 2);
$polozky4[] = array("RS03025", "N", 15, 2);
$polozky4[] = array("RS03026", "N", 15, 2);

$polozky4[] = array("RS03101", "N", 15, 2);
$polozky4[] = array("RS03102", "N", 15, 2);
$polozky4[] = array("RS03103", "N", 15, 2);
$polozky4[] = array("RS03104", "N", 15, 2);
$polozky4[] = array("RS03105", "N", 15, 2);
$polozky4[] = array("RS03106", "N", 15, 2);
$polozky4[] = array("RS03107", "N", 15, 2);
$polozky4[] = array("RS03108", "N", 15, 2);
$polozky4[] = array("RS03109", "N", 15, 2);
$polozky4[] = array("RS03110", "N", 15, 2);
$polozky4[] = array("RS03111", "N", 15, 2);
$polozky4[] = array("RS03112", "N", 15, 2);
$polozky4[] = array("RS03113", "N", 15, 2);
$polozky4[] = array("RS03114", "N", 15, 2);
$polozky4[] = array("RS03115", "N", 15, 2);
$polozky4[] = array("RS03116", "N", 15, 2);
$polozky4[] = array("RS03117", "N", 15, 2);
$polozky4[] = array("RS03118", "N", 15, 2);
$polozky4[] = array("RS03119", "N", 15, 2);
$polozky4[] = array("RS03120", "N", 15, 2);
$polozky4[] = array("RS03121", "N", 15, 2);
$polozky4[] = array("RS03122", "N", 15, 2);
$polozky4[] = array("RS03123", "N", 15, 2);
$polozky4[] = array("RS03124", "N", 15, 2);
$polozky4[] = array("RS03125", "N", 15, 2);
$polozky4[] = array("RS03126", "N", 15, 2);

$polozky4[] = array("RS03201", "N", 15, 2);
$polozky4[] = array("RS03202", "N", 15, 2);
$polozky4[] = array("RS03203", "N", 15, 2);
$polozky4[] = array("RS03204", "N", 15, 2);
$polozky4[] = array("RS03205", "N", 15, 2);
$polozky4[] = array("RS03206", "N", 15, 2);
$polozky4[] = array("RS03207", "N", 15, 2);
$polozky4[] = array("RS03208", "N", 15, 2);
$polozky4[] = array("RS03209", "N", 15, 2);
$polozky4[] = array("RS03210", "N", 15, 2);
$polozky4[] = array("RS03211", "N", 15, 2);
$polozky4[] = array("RS03212", "N", 15, 2);
$polozky4[] = array("RS03213", "N", 15, 2);
$polozky4[] = array("RS03214", "N", 15, 2);
$polozky4[] = array("RS03215", "N", 15, 2);
$polozky4[] = array("RS03216", "N", 15, 2);
$polozky4[] = array("RS03217", "N", 15, 2);
$polozky4[] = array("RS03218", "N", 15, 2);
$polozky4[] = array("RS03219", "N", 15, 2);
$polozky4[] = array("RS03220", "N", 15, 2);
$polozky4[] = array("RS03221", "N", 15, 2);
$polozky4[] = array("RS03222", "N", 15, 2);
$polozky4[] = array("RS03223", "N", 15, 2);
$polozky4[] = array("RS03224", "N", 15, 2);
$polozky4[] = array("RS03225", "N", 15, 2);
$polozky4[] = array("RS03226", "N", 15, 2);

$polozky4[] = array("RS03301", "N", 15, 2);
$polozky4[] = array("RS03302", "N", 15, 2);
$polozky4[] = array("RS03303", "N", 15, 2);
$polozky4[] = array("RS03304", "N", 15, 2);
$polozky4[] = array("RS03305", "N", 15, 2);
$polozky4[] = array("RS03306", "N", 15, 2);
$polozky4[] = array("RS03307", "N", 15, 2);
$polozky4[] = array("RS03308", "N", 15, 2);
$polozky4[] = array("RS03309", "N", 15, 2);
$polozky4[] = array("RS03310", "N", 15, 2);
$polozky4[] = array("RS03311", "N", 15, 2);
$polozky4[] = array("RS03312", "N", 15, 2);
$polozky4[] = array("RS03313", "N", 15, 2);
$polozky4[] = array("RS03314", "N", 15, 2);
$polozky4[] = array("RS03315", "N", 15, 2);
$polozky4[] = array("RS03316", "N", 15, 2);
$polozky4[] = array("RS03317", "N", 15, 2);
$polozky4[] = array("RS03318", "N", 15, 2);
$polozky4[] = array("RS03319", "N", 15, 2);
$polozky4[] = array("RS03320", "N", 15, 2);
$polozky4[] = array("RS03321", "N", 15, 2);
$polozky4[] = array("RS03322", "N", 15, 2);
$polozky4[] = array("RS03323", "N", 15, 2);
$polozky4[] = array("RS03324", "N", 15, 2);
$polozky4[] = array("RS03325", "N", 15, 2);
$polozky4[] = array("RS03326", "N", 15, 2);

$polozky4[] = array("RS03401", "N", 15, 2);
$polozky4[] = array("RS03402", "N", 15, 2);
$polozky4[] = array("RS03403", "N", 15, 2);
$polozky4[] = array("RS03404", "N", 15, 2);
$polozky4[] = array("RS03405", "N", 15, 2);
$polozky4[] = array("RS03406", "N", 15, 2);
$polozky4[] = array("RS03407", "N", 15, 2);
$polozky4[] = array("RS03408", "N", 15, 2);
$polozky4[] = array("RS03409", "N", 15, 2);
$polozky4[] = array("RS03410", "N", 15, 2);
$polozky4[] = array("RS03411", "N", 15, 2);
$polozky4[] = array("RS03412", "N", 15, 2);
$polozky4[] = array("RS03413", "N", 15, 2);
$polozky4[] = array("RS03414", "N", 15, 2);
$polozky4[] = array("RS03415", "N", 15, 2);
$polozky4[] = array("RS03416", "N", 15, 2);
$polozky4[] = array("RS03417", "N", 15, 2);
$polozky4[] = array("RS03418", "N", 15, 2);
$polozky4[] = array("RS03419", "N", 15, 2);
$polozky4[] = array("RS03420", "N", 15, 2);
$polozky4[] = array("RS03421", "N", 15, 2);
$polozky4[] = array("RS03422", "N", 15, 2);
$polozky4[] = array("RS03423", "N", 15, 2);
$polozky4[] = array("RS03424", "N", 15, 2);
$polozky4[] = array("RS03425", "N", 15, 2);
$polozky4[] = array("RS03426", "N", 15, 2);

$polozky4[] = array("RS03501", "N", 15, 2);
$polozky4[] = array("RS03502", "N", 15, 2);
$polozky4[] = array("RS03503", "N", 15, 2);
$polozky4[] = array("RS03504", "N", 15, 2);
$polozky4[] = array("RS03505", "N", 15, 2);
$polozky4[] = array("RS03506", "N", 15, 2);
$polozky4[] = array("RS03507", "N", 15, 2);
$polozky4[] = array("RS03508", "N", 15, 2);
$polozky4[] = array("RS03509", "N", 15, 2);
$polozky4[] = array("RS03510", "N", 15, 2);
$polozky4[] = array("RS03511", "N", 15, 2);
$polozky4[] = array("RS03512", "N", 15, 2);
$polozky4[] = array("RS03513", "N", 15, 2);
$polozky4[] = array("RS03514", "N", 15, 2);
$polozky4[] = array("RS03515", "N", 15, 2);
$polozky4[] = array("RS03516", "N", 15, 2);
$polozky4[] = array("RS03517", "N", 15, 2);
$polozky4[] = array("RS03518", "N", 15, 2);
$polozky4[] = array("RS03519", "N", 15, 2);
$polozky4[] = array("RS03520", "N", 15, 2);
$polozky4[] = array("RS03521", "N", 15, 2);
$polozky4[] = array("RS03522", "N", 15, 2);
$polozky4[] = array("RS03523", "N", 15, 2);
$polozky4[] = array("RS03524", "N", 15, 2);
$polozky4[] = array("RS03525", "N", 15, 2);
$polozky4[] = array("RS03526", "N", 15, 2);

$polozky4[] = array("RS03601", "N", 15, 2);
$polozky4[] = array("RS03602", "N", 15, 2);
$polozky4[] = array("RS03603", "N", 15, 2);
$polozky4[] = array("RS03604", "N", 15, 2);
$polozky4[] = array("RS03605", "N", 15, 2);
$polozky4[] = array("RS03606", "N", 15, 2);
$polozky4[] = array("RS03607", "N", 15, 2);
$polozky4[] = array("RS03608", "N", 15, 2);
$polozky4[] = array("RS03609", "N", 15, 2);
$polozky4[] = array("RS03610", "N", 15, 2);
$polozky4[] = array("RS03611", "N", 15, 2);
$polozky4[] = array("RS03612", "N", 15, 2);
$polozky4[] = array("RS03613", "N", 15, 2);
$polozky4[] = array("RS03614", "N", 15, 2);
$polozky4[] = array("RS03615", "N", 15, 2);
$polozky4[] = array("RS03616", "N", 15, 2);
$polozky4[] = array("RS03617", "N", 15, 2);
$polozky4[] = array("RS03618", "N", 15, 2);
$polozky4[] = array("RS03619", "N", 15, 2);
$polozky4[] = array("RS03620", "N", 15, 2);
$polozky4[] = array("RS03621", "N", 15, 2);
$polozky4[] = array("RS03622", "N", 15, 2);
$polozky4[] = array("RS03623", "N", 15, 2);
$polozky4[] = array("RS03624", "N", 15, 2);
$polozky4[] = array("RS03625", "N", 15, 2);
$polozky4[] = array("RS03626", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P4_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P4_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru4 = $outfilex;

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru4, $polozky4);
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru4"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P4.DBF
?> 

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P5.DBF
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {



$sqlt = <<<fin4pdbf
(

);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


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
RS03711         DECIMAL(12,2),
RS03712         DECIMAL(12,2),
RS03713         DECIMAL(12,2),
RS03714         DECIMAL(12,2),
RS03715         DECIMAL(12,2),
RS03716         DECIMAL(12,2),
RS03717         DECIMAL(12,2),
RS03718         DECIMAL(12,2),
RS03719         DECIMAL(12,2),
RS03720         DECIMAL(12,2),
RS03721         DECIMAL(12,2),
RS03722         DECIMAL(12,2),
RS03723         DECIMAL(12,2),
RS03724         DECIMAL(12,2),
RS03725         DECIMAL(12,2),
RS03726         DECIMAL(12,2),

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
RS03811         DECIMAL(12,2),
RS03812         DECIMAL(12,2),
RS03813         DECIMAL(12,2),
RS03814         DECIMAL(12,2),
RS03815         DECIMAL(12,2),
RS03816         DECIMAL(12,2),
RS03817         DECIMAL(12,2),
RS03818         DECIMAL(12,2),
RS03819         DECIMAL(12,2),
RS03820         DECIMAL(12,2),
RS03821         DECIMAL(12,2),
RS03822         DECIMAL(12,2),
RS03823         DECIMAL(12,2),
RS03824         DECIMAL(12,2),
RS03825         DECIMAL(12,2),
RS03826         DECIMAL(12,2),

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
RS03911         DECIMAL(12,2),
RS03912         DECIMAL(12,2),
RS03913         DECIMAL(12,2),
RS03914         DECIMAL(12,2),
RS03915         DECIMAL(12,2),
RS03916         DECIMAL(12,2),
RS03917         DECIMAL(12,2),
RS03918         DECIMAL(12,2),
RS03919         DECIMAL(12,2),
RS03920         DECIMAL(12,2),
RS03921         DECIMAL(12,2),
RS03922         DECIMAL(12,2),
RS03923         DECIMAL(12,2),
RS03924         DECIMAL(12,2),
RS03925         DECIMAL(12,2),
RS03926         DECIMAL(12,2),

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
RS04011         DECIMAL(12,2),
RS04012         DECIMAL(12,2),
RS04013         DECIMAL(12,2),
RS04014         DECIMAL(12,2),
RS04015         DECIMAL(12,2),
RS04016         DECIMAL(12,2),
RS04017         DECIMAL(12,2),
RS04018         DECIMAL(12,2),
RS04019         DECIMAL(12,2),
RS04020         DECIMAL(12,2),
RS04021         DECIMAL(12,2),
RS04022         DECIMAL(12,2),
RS04023         DECIMAL(12,2),
RS04024         DECIMAL(12,2),
RS04025         DECIMAL(12,2),
RS04026         DECIMAL(12,2),

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
RS04111         DECIMAL(12,2),
RS04112         DECIMAL(12,2),
RS04113         DECIMAL(12,2),
RS04114         DECIMAL(12,2),
RS04115         DECIMAL(12,2),
RS04116         DECIMAL(12,2),
RS04117         DECIMAL(12,2),
RS04118         DECIMAL(12,2),
RS04119         DECIMAL(12,2),
RS04120         DECIMAL(12,2),
RS04121         DECIMAL(12,2),
RS04122         DECIMAL(12,2),
RS04123         DECIMAL(12,2),
RS04124         DECIMAL(12,2),
RS04125         DECIMAL(12,2),
RS04126         DECIMAL(12,2),

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
RS04211         DECIMAL(12,2),
RS04212         DECIMAL(12,2),
RS04213         DECIMAL(12,2),
RS04214         DECIMAL(12,2),
RS04215         DECIMAL(12,2),
RS04216         DECIMAL(12,2),
RS04217         DECIMAL(12,2),
RS04218         DECIMAL(12,2),
RS04219         DECIMAL(12,2),
RS04220         DECIMAL(12,2),
RS04221         DECIMAL(12,2),
RS04222         DECIMAL(12,2),
RS04223         DECIMAL(12,2),
RS04224         DECIMAL(12,2),
RS04225         DECIMAL(12,2),
RS04226         DECIMAL(12,2),

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
RS04311         DECIMAL(12,2),
RS04312         DECIMAL(12,2),
RS04313         DECIMAL(12,2),
RS04314         DECIMAL(12,2),
RS04315         DECIMAL(12,2),
RS04316         DECIMAL(12,2),
RS04317         DECIMAL(12,2),
RS04318         DECIMAL(12,2),
RS04319         DECIMAL(12,2),
RS04320         DECIMAL(12,2),
RS04321         DECIMAL(12,2),
RS04322         DECIMAL(12,2),
RS04323         DECIMAL(12,2),
RS04324         DECIMAL(12,2),
RS04325         DECIMAL(12,2),
RS04326         DECIMAL(12,2),

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
RS04411         DECIMAL(12,2),
RS04412         DECIMAL(12,2),
RS04413         DECIMAL(12,2),
RS04414         DECIMAL(12,2),
RS04415         DECIMAL(12,2),
RS04416         DECIMAL(12,2),
RS04417         DECIMAL(12,2),
RS04418         DECIMAL(12,2),
RS04419         DECIMAL(12,2),
RS04420         DECIMAL(12,2),
RS04421         DECIMAL(12,2),
RS04422         DECIMAL(12,2),
RS04423         DECIMAL(12,2),
RS04424         DECIMAL(12,2),
RS04425         DECIMAL(12,2),
RS04426         DECIMAL(12,2),

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
RS04511         DECIMAL(12,2),
RS04512         DECIMAL(12,2),
RS04513         DECIMAL(12,2),
RS04514         DECIMAL(12,2),
RS04515         DECIMAL(12,2),
RS04516         DECIMAL(12,2),
RS04517         DECIMAL(12,2),
RS04518         DECIMAL(12,2),
RS04519         DECIMAL(12,2),
RS04520         DECIMAL(12,2),
RS04521         DECIMAL(12,2),
RS04522         DECIMAL(12,2),
RS04523         DECIMAL(12,2),
RS04524         DECIMAL(12,2),
RS04525         DECIMAL(12,2),
RS04526         DECIMAL(12,2)

);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy riadky 37 oces, 38 osts, 44 zoss
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky5[] = array("ICO", "C", 8);
$polozky5[] = array("DATROK", "C", 4);
$polozky5[] = array("DATMES", "C", 2);
$polozky5[] = array("TYPORG", "C", 2);


$polozky5[] = array("RS03701", "N", 15, 2);
$polozky5[] = array("RS03702", "N", 15, 2);
$polozky5[] = array("RS03703", "N", 15, 2);
$polozky5[] = array("RS03704", "N", 15, 2);
$polozky5[] = array("RS03705", "N", 15, 2);
$polozky5[] = array("RS03706", "N", 15, 2);
$polozky5[] = array("RS03707", "N", 15, 2);
$polozky5[] = array("RS03708", "N", 15, 2);
$polozky5[] = array("RS03709", "N", 15, 2);
$polozky5[] = array("RS03710", "N", 15, 2);
$polozky5[] = array("RS03711", "N", 15, 2);
$polozky5[] = array("RS03712", "N", 15, 2);
$polozky5[] = array("RS03713", "N", 15, 2);
$polozky5[] = array("RS03714", "N", 15, 2);
$polozky5[] = array("RS03715", "N", 15, 2);
$polozky5[] = array("RS03716", "N", 15, 2);
$polozky5[] = array("RS03717", "N", 15, 2);
$polozky5[] = array("RS03718", "N", 15, 2);
$polozky5[] = array("RS03719", "N", 15, 2);
$polozky5[] = array("RS03720", "N", 15, 2);
$polozky5[] = array("RS03721", "N", 15, 2);
$polozky5[] = array("RS03722", "N", 15, 2);
$polozky5[] = array("RS03723", "N", 15, 2);
$polozky5[] = array("RS03724", "N", 15, 2);
$polozky5[] = array("RS03725", "N", 15, 2);
$polozky5[] = array("RS03726", "N", 15, 2);

$polozky5[] = array("RS03801", "N", 15, 2);
$polozky5[] = array("RS03802", "N", 15, 2);
$polozky5[] = array("RS03803", "N", 15, 2);
$polozky5[] = array("RS03804", "N", 15, 2);
$polozky5[] = array("RS03805", "N", 15, 2);
$polozky5[] = array("RS03806", "N", 15, 2);
$polozky5[] = array("RS03807", "N", 15, 2);
$polozky5[] = array("RS03808", "N", 15, 2);
$polozky5[] = array("RS03809", "N", 15, 2);
$polozky5[] = array("RS03810", "N", 15, 2);
$polozky5[] = array("RS03811", "N", 15, 2);
$polozky5[] = array("RS03812", "N", 15, 2);
$polozky5[] = array("RS03813", "N", 15, 2);
$polozky5[] = array("RS03814", "N", 15, 2);
$polozky5[] = array("RS03815", "N", 15, 2);
$polozky5[] = array("RS03816", "N", 15, 2);
$polozky5[] = array("RS03817", "N", 15, 2);
$polozky5[] = array("RS03818", "N", 15, 2);
$polozky5[] = array("RS03819", "N", 15, 2);
$polozky5[] = array("RS03820", "N", 15, 2);
$polozky5[] = array("RS03821", "N", 15, 2);
$polozky5[] = array("RS03822", "N", 15, 2);
$polozky5[] = array("RS03823", "N", 15, 2);
$polozky5[] = array("RS03824", "N", 15, 2);
$polozky5[] = array("RS03825", "N", 15, 2);
$polozky5[] = array("RS03826", "N", 15, 2);

$polozky5[] = array("RS03901", "N", 15, 2);
$polozky5[] = array("RS03902", "N", 15, 2);
$polozky5[] = array("RS03903", "N", 15, 2);
$polozky5[] = array("RS03904", "N", 15, 2);
$polozky5[] = array("RS03905", "N", 15, 2);
$polozky5[] = array("RS03906", "N", 15, 2);
$polozky5[] = array("RS03907", "N", 15, 2);
$polozky5[] = array("RS03908", "N", 15, 2);
$polozky5[] = array("RS03909", "N", 15, 2);
$polozky5[] = array("RS03910", "N", 15, 2);
$polozky5[] = array("RS03911", "N", 15, 2);
$polozky5[] = array("RS03912", "N", 15, 2);
$polozky5[] = array("RS03913", "N", 15, 2);
$polozky5[] = array("RS03914", "N", 15, 2);
$polozky5[] = array("RS03915", "N", 15, 2);
$polozky5[] = array("RS03916", "N", 15, 2);
$polozky5[] = array("RS03917", "N", 15, 2);
$polozky5[] = array("RS03918", "N", 15, 2);
$polozky5[] = array("RS03919", "N", 15, 2);
$polozky5[] = array("RS03920", "N", 15, 2);
$polozky5[] = array("RS03921", "N", 15, 2);
$polozky5[] = array("RS03922", "N", 15, 2);
$polozky5[] = array("RS03923", "N", 15, 2);
$polozky5[] = array("RS03924", "N", 15, 2);
$polozky5[] = array("RS03925", "N", 15, 2);
$polozky5[] = array("RS03926", "N", 15, 2);

$polozky5[] = array("RS04001", "N", 15, 2);
$polozky5[] = array("RS04002", "N", 15, 2);
$polozky5[] = array("RS04003", "N", 15, 2);
$polozky5[] = array("RS04004", "N", 15, 2);
$polozky5[] = array("RS04005", "N", 15, 2);
$polozky5[] = array("RS04006", "N", 15, 2);
$polozky5[] = array("RS04007", "N", 15, 2);
$polozky5[] = array("RS04008", "N", 15, 2);
$polozky5[] = array("RS04009", "N", 15, 2);
$polozky5[] = array("RS04010", "N", 15, 2);
$polozky5[] = array("RS04011", "N", 15, 2);
$polozky5[] = array("RS04012", "N", 15, 2);
$polozky5[] = array("RS04013", "N", 15, 2);
$polozky5[] = array("RS04014", "N", 15, 2);
$polozky5[] = array("RS04015", "N", 15, 2);
$polozky5[] = array("RS04016", "N", 15, 2);
$polozky5[] = array("RS04017", "N", 15, 2);
$polozky5[] = array("RS04018", "N", 15, 2);
$polozky5[] = array("RS04019", "N", 15, 2);
$polozky5[] = array("RS04020", "N", 15, 2);
$polozky5[] = array("RS04021", "N", 15, 2);
$polozky5[] = array("RS04022", "N", 15, 2);
$polozky5[] = array("RS04023", "N", 15, 2);
$polozky5[] = array("RS04024", "N", 15, 2);
$polozky5[] = array("RS04025", "N", 15, 2);
$polozky5[] = array("RS04026", "N", 15, 2);

$polozky5[] = array("RS04101", "N", 15, 2);
$polozky5[] = array("RS04102", "N", 15, 2);
$polozky5[] = array("RS04103", "N", 15, 2);
$polozky5[] = array("RS04104", "N", 15, 2);
$polozky5[] = array("RS04105", "N", 15, 2);
$polozky5[] = array("RS04106", "N", 15, 2);
$polozky5[] = array("RS04107", "N", 15, 2);
$polozky5[] = array("RS04108", "N", 15, 2);
$polozky5[] = array("RS04109", "N", 15, 2);
$polozky5[] = array("RS04110", "N", 15, 2);
$polozky5[] = array("RS04111", "N", 15, 2);
$polozky5[] = array("RS04112", "N", 15, 2);
$polozky5[] = array("RS04113", "N", 15, 2);
$polozky5[] = array("RS04114", "N", 15, 2);
$polozky5[] = array("RS04115", "N", 15, 2);
$polozky5[] = array("RS04116", "N", 15, 2);
$polozky5[] = array("RS04117", "N", 15, 2);
$polozky5[] = array("RS04118", "N", 15, 2);
$polozky5[] = array("RS04119", "N", 15, 2);
$polozky5[] = array("RS04120", "N", 15, 2);
$polozky5[] = array("RS04121", "N", 15, 2);
$polozky5[] = array("RS04122", "N", 15, 2);
$polozky5[] = array("RS04123", "N", 15, 2);
$polozky5[] = array("RS04124", "N", 15, 2);
$polozky5[] = array("RS04125", "N", 15, 2);
$polozky5[] = array("RS04126", "N", 15, 2);

$polozky5[] = array("RS04201", "N", 15, 2);
$polozky5[] = array("RS04202", "N", 15, 2);
$polozky5[] = array("RS04203", "N", 15, 2);
$polozky5[] = array("RS04204", "N", 15, 2);
$polozky5[] = array("RS04205", "N", 15, 2);
$polozky5[] = array("RS04206", "N", 15, 2);
$polozky5[] = array("RS04207", "N", 15, 2);
$polozky5[] = array("RS04208", "N", 15, 2);
$polozky5[] = array("RS04209", "N", 15, 2);
$polozky5[] = array("RS04210", "N", 15, 2);
$polozky5[] = array("RS04211", "N", 15, 2);
$polozky5[] = array("RS04212", "N", 15, 2);
$polozky5[] = array("RS04213", "N", 15, 2);
$polozky5[] = array("RS04214", "N", 15, 2);
$polozky5[] = array("RS04215", "N", 15, 2);
$polozky5[] = array("RS04216", "N", 15, 2);
$polozky5[] = array("RS04217", "N", 15, 2);
$polozky5[] = array("RS04218", "N", 15, 2);
$polozky5[] = array("RS04219", "N", 15, 2);
$polozky5[] = array("RS04220", "N", 15, 2);
$polozky5[] = array("RS04221", "N", 15, 2);
$polozky5[] = array("RS04222", "N", 15, 2);
$polozky5[] = array("RS04223", "N", 15, 2);
$polozky5[] = array("RS04224", "N", 15, 2);
$polozky5[] = array("RS04225", "N", 15, 2);
$polozky5[] = array("RS04226", "N", 15, 2);

$polozky5[] = array("RS04301", "N", 15, 2);
$polozky5[] = array("RS04302", "N", 15, 2);
$polozky5[] = array("RS04303", "N", 15, 2);
$polozky5[] = array("RS04304", "N", 15, 2);
$polozky5[] = array("RS04305", "N", 15, 2);
$polozky5[] = array("RS04306", "N", 15, 2);
$polozky5[] = array("RS04307", "N", 15, 2);
$polozky5[] = array("RS04308", "N", 15, 2);
$polozky5[] = array("RS04309", "N", 15, 2);
$polozky5[] = array("RS04310", "N", 15, 2);
$polozky5[] = array("RS04311", "N", 15, 2);
$polozky5[] = array("RS04312", "N", 15, 2);
$polozky5[] = array("RS04313", "N", 15, 2);
$polozky5[] = array("RS04314", "N", 15, 2);
$polozky5[] = array("RS04315", "N", 15, 2);
$polozky5[] = array("RS04316", "N", 15, 2);
$polozky5[] = array("RS04317", "N", 15, 2);
$polozky5[] = array("RS04318", "N", 15, 2);
$polozky5[] = array("RS04319", "N", 15, 2);
$polozky5[] = array("RS04320", "N", 15, 2);
$polozky5[] = array("RS04321", "N", 15, 2);
$polozky5[] = array("RS04322", "N", 15, 2);
$polozky5[] = array("RS04323", "N", 15, 2);
$polozky5[] = array("RS04324", "N", 15, 2);
$polozky5[] = array("RS04325", "N", 15, 2);
$polozky5[] = array("RS04326", "N", 15, 2);

$polozky5[] = array("RS04401", "N", 15, 2);
$polozky5[] = array("RS04402", "N", 15, 2);
$polozky5[] = array("RS04403", "N", 15, 2);
$polozky5[] = array("RS04404", "N", 15, 2);
$polozky5[] = array("RS04405", "N", 15, 2);
$polozky5[] = array("RS04406", "N", 15, 2);
$polozky5[] = array("RS04407", "N", 15, 2);
$polozky5[] = array("RS04408", "N", 15, 2);
$polozky5[] = array("RS04409", "N", 15, 2);
$polozky5[] = array("RS04410", "N", 15, 2);
$polozky5[] = array("RS04411", "N", 15, 2);
$polozky5[] = array("RS04412", "N", 15, 2);
$polozky5[] = array("RS04413", "N", 15, 2);
$polozky5[] = array("RS04414", "N", 15, 2);
$polozky5[] = array("RS04415", "N", 15, 2);
$polozky5[] = array("RS04416", "N", 15, 2);
$polozky5[] = array("RS04417", "N", 15, 2);
$polozky5[] = array("RS04418", "N", 15, 2);
$polozky5[] = array("RS04419", "N", 15, 2);
$polozky5[] = array("RS04420", "N", 15, 2);
$polozky5[] = array("RS04421", "N", 15, 2);
$polozky5[] = array("RS04422", "N", 15, 2);
$polozky5[] = array("RS04423", "N", 15, 2);
$polozky5[] = array("RS04424", "N", 15, 2);
$polozky5[] = array("RS04425", "N", 15, 2);
$polozky5[] = array("RS04426", "N", 15, 2);

$polozky5[] = array("RS04501", "N", 15, 2);
$polozky5[] = array("RS04502", "N", 15, 2);
$polozky5[] = array("RS04503", "N", 15, 2);
$polozky5[] = array("RS04504", "N", 15, 2);
$polozky5[] = array("RS04505", "N", 15, 2);
$polozky5[] = array("RS04506", "N", 15, 2);
$polozky5[] = array("RS04507", "N", 15, 2);
$polozky5[] = array("RS04508", "N", 15, 2);
$polozky5[] = array("RS04509", "N", 15, 2);
$polozky5[] = array("RS04510", "N", 15, 2);
$polozky5[] = array("RS04511", "N", 15, 2);
$polozky5[] = array("RS04512", "N", 15, 2);
$polozky5[] = array("RS04513", "N", 15, 2);
$polozky5[] = array("RS04514", "N", 15, 2);
$polozky5[] = array("RS04515", "N", 15, 2);
$polozky5[] = array("RS04516", "N", 15, 2);
$polozky5[] = array("RS04517", "N", 15, 2);
$polozky5[] = array("RS04518", "N", 15, 2);
$polozky5[] = array("RS04519", "N", 15, 2);
$polozky5[] = array("RS04520", "N", 15, 2);
$polozky5[] = array("RS04521", "N", 15, 2);
$polozky5[] = array("RS04522", "N", 15, 2);
$polozky5[] = array("RS04523", "N", 15, 2);
$polozky5[] = array("RS04524", "N", 15, 2);
$polozky5[] = array("RS04525", "N", 15, 2);
$polozky5[] = array("RS04526", "N", 15, 2);

// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P5_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P5_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru5 = $outfilex;

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru5, $polozky5);
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru5"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P5.DBF
?> 

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P6.DBF
/* Zde zaèíná "vlastní" skript, celý je uzavøen do cyklu do-while (false), což pøi použití pøíkazù break znaènì usnadní a zpøehlední zpracování chybových stavù */
do {



$sqlt = <<<fin4pdbf
(

);
fin4pdbf;

$sqlx = 'DROP TABLE fin4pdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM fin4pdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku fin4pdbf!"."<br />";

$sqlt = <<<fin4pdbf
(
ICO             VARCHAR(8),
DATROK          VARCHAR(4),
DATMES          VARCHAR(2),
TYPORG          VARCHAR(2),


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
RS04611         DECIMAL(12,2),
RS04612         DECIMAL(12,2),
RS04613         DECIMAL(12,2),
RS04614         DECIMAL(12,2),
RS04615         DECIMAL(12,2),
RS04616         DECIMAL(12,2),
RS04617         DECIMAL(12,2),
RS04618         DECIMAL(12,2),
RS04619         DECIMAL(12,2),
RS04620         DECIMAL(12,2),
RS04621         DECIMAL(12,2),
RS04622         DECIMAL(12,2),
RS04623         DECIMAL(12,2),
RS04624         DECIMAL(12,2),
RS04625         DECIMAL(12,2),
RS04626         DECIMAL(12,2),

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
RS04711         DECIMAL(12,2),
RS04712         DECIMAL(12,2),
RS04713         DECIMAL(12,2),
RS04714         DECIMAL(12,2),
RS04715         DECIMAL(12,2),
RS04716         DECIMAL(12,2),
RS04717         DECIMAL(12,2),
RS04718         DECIMAL(12,2),
RS04719         DECIMAL(12,2),
RS04720         DECIMAL(12,2),
RS04721         DECIMAL(12,2),
RS04722         DECIMAL(12,2),
RS04723         DECIMAL(12,2),
RS04724         DECIMAL(12,2),
RS04725         DECIMAL(12,2),
RS04726         DECIMAL(12,2),

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
RS04811         DECIMAL(12,2),
RS04812         DECIMAL(12,2),
RS04813         DECIMAL(12,2),
RS04814         DECIMAL(12,2),
RS04815         DECIMAL(12,2),
RS04816         DECIMAL(12,2),
RS04817         DECIMAL(12,2),
RS04818         DECIMAL(12,2),
RS04819         DECIMAL(12,2),
RS04820         DECIMAL(12,2),
RS04821         DECIMAL(12,2),
RS04822         DECIMAL(12,2),
RS04823         DECIMAL(12,2),
RS04824         DECIMAL(12,2),
RS04825         DECIMAL(12,2),
RS04826         DECIMAL(12,2),

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
RS04911         DECIMAL(12,2),
RS04912         DECIMAL(12,2),
RS04913         DECIMAL(12,2),
RS04914         DECIMAL(12,2),
RS04915         DECIMAL(12,2),
RS04916         DECIMAL(12,2),
RS04917         DECIMAL(12,2),
RS04918         DECIMAL(12,2),
RS04919         DECIMAL(12,2),
RS04920         DECIMAL(12,2),
RS04921         DECIMAL(12,2),
RS04922         DECIMAL(12,2),
RS04923         DECIMAL(12,2),
RS04924         DECIMAL(12,2),
RS04925         DECIMAL(12,2),
RS04926         DECIMAL(12,2),

RS05001         DECIMAL(12,2),
RS05002         DECIMAL(12,2),
RS05003         DECIMAL(12,2),
RS05004         DECIMAL(12,2),
RS05005         DECIMAL(12,2),
RS05006         DECIMAL(12,2),
RS05007         DECIMAL(12,2),
RS05008         DECIMAL(12,2),
RS05009         DECIMAL(12,2),
RS05010         DECIMAL(12,2),
RS05011         DECIMAL(12,2),
RS05012         DECIMAL(12,2),
RS05013         DECIMAL(12,2),
RS05014         DECIMAL(12,2),
RS05015         DECIMAL(12,2),
RS05016         DECIMAL(12,2),
RS05017         DECIMAL(12,2),
RS05018         DECIMAL(12,2),
RS05019         DECIMAL(12,2),
RS05020         DECIMAL(12,2),
RS05021         DECIMAL(12,2),
RS05022         DECIMAL(12,2),
RS05023         DECIMAL(12,2),
RS05024         DECIMAL(12,2),
RS05025         DECIMAL(12,2),
RS05026         DECIMAL(12,2)


);
fin4pdbf;

$sqlx = 'CREATE TABLE fin4pdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy riadky 46 zos
//"SUM(pocs01),SUM(pocs02),SUM(pocs03),SUM(pocs04),SUM(pocs05),SUM(pocs06),SUM(pocs07),SUM(pocs08),SUM(pocs09),SUM(pocs10),SUM(pocs11),SUM(pocs12),".
//"SUM(zvys01),SUM(zvys02),SUM(zvys03),SUM(zvys04),SUM(zvys05),SUM(zvys06),SUM(zvys07),SUM(zvys08),SUM(zvys09),SUM(zvys10),SUM(zvys11),SUM(zvys12),".
//"SUM(znis01),SUM(znis02),SUM(znis03),SUM(znis04),SUM(znis05),SUM(znis06),SUM(znis07),SUM(znis08),SUM(znis09),SUM(znis10),SUM(znis11),SUM(znis12),".
//"SUM(oces01),SUM(oces02),SUM(oces03),SUM(oces04),SUM(oces05),SUM(oces06),SUM(oces07),SUM(oces08),SUM(oces09),SUM(oces10),SUM(oces11),SUM(oces12),".
//"SUM(osts01),SUM(osts02),SUM(osts03),SUM(osts04),SUM(osts05),SUM(osts06),SUM(osts07),SUM(osts08),SUM(osts09),SUM(osts10),SUM(osts11),SUM(osts12),".
//"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".

$dsqlt = "INSERT INTO fin4pdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".

"SUM(zoss01),SUM(zoss02),SUM(zoss03),SUM(zoss04),SUM(zoss05),SUM(zoss06),SUM(zoss07),SUM(zoss08),SUM(zoss09),SUM(zoss10),SUM(zoss11),SUM(zoss12),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".

" FROM F$kli_vxcf"."_uctvykaz_fin404".
" WHERE oc = $cislo_oc AND prx = 1 GROUP BY oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/* Pøipravíme si SQL dotaz (v praxi bychom jej získali asi jinak...) */
$dotaz = "select * from fin4pdbf";

/* Vytvoøíme pole, která odpovídají jednotlivým položkám */
$polozky6[] = array("ICO", "C", 8);
$polozky6[] = array("DATROK", "C", 4);
$polozky6[] = array("DATMES", "C", 2);
$polozky6[] = array("TYPORG", "C", 2);


$polozky6[] = array("RS04601", "N", 15, 2);
$polozky6[] = array("RS04602", "N", 15, 2);
$polozky6[] = array("RS04603", "N", 15, 2);
$polozky6[] = array("RS04604", "N", 15, 2);
$polozky6[] = array("RS04605", "N", 15, 2);
$polozky6[] = array("RS04606", "N", 15, 2);
$polozky6[] = array("RS04607", "N", 15, 2);
$polozky6[] = array("RS04608", "N", 15, 2);
$polozky6[] = array("RS04609", "N", 15, 2);
$polozky6[] = array("RS04610", "N", 15, 2);
$polozky6[] = array("RS04611", "N", 15, 2);
$polozky6[] = array("RS04612", "N", 15, 2);
$polozky6[] = array("RS04613", "N", 15, 2);
$polozky6[] = array("RS04614", "N", 15, 2);
$polozky6[] = array("RS04615", "N", 15, 2);
$polozky6[] = array("RS04616", "N", 15, 2);
$polozky6[] = array("RS04617", "N", 15, 2);
$polozky6[] = array("RS04618", "N", 15, 2);
$polozky6[] = array("RS04619", "N", 15, 2);
$polozky6[] = array("RS04620", "N", 15, 2);
$polozky6[] = array("RS04621", "N", 15, 2);
$polozky6[] = array("RS04622", "N", 15, 2);
$polozky6[] = array("RS04623", "N", 15, 2);
$polozky6[] = array("RS04624", "N", 15, 2);
$polozky6[] = array("RS04625", "N", 15, 2);
$polozky6[] = array("RS04626", "N", 15, 2);

$polozky6[] = array("RS04701", "N", 15, 2);
$polozky6[] = array("RS04702", "N", 15, 2);
$polozky6[] = array("RS04703", "N", 15, 2);
$polozky6[] = array("RS04704", "N", 15, 2);
$polozky6[] = array("RS04705", "N", 15, 2);
$polozky6[] = array("RS04706", "N", 15, 2);
$polozky6[] = array("RS04707", "N", 15, 2);
$polozky6[] = array("RS04708", "N", 15, 2);
$polozky6[] = array("RS04709", "N", 15, 2);
$polozky6[] = array("RS04710", "N", 15, 2);
$polozky6[] = array("RS04711", "N", 15, 2);
$polozky6[] = array("RS04712", "N", 15, 2);
$polozky6[] = array("RS04713", "N", 15, 2);
$polozky6[] = array("RS04714", "N", 15, 2);
$polozky6[] = array("RS04715", "N", 15, 2);
$polozky6[] = array("RS04716", "N", 15, 2);
$polozky6[] = array("RS04717", "N", 15, 2);
$polozky6[] = array("RS04718", "N", 15, 2);
$polozky6[] = array("RS04719", "N", 15, 2);
$polozky6[] = array("RS04720", "N", 15, 2);
$polozky6[] = array("RS04721", "N", 15, 2);
$polozky6[] = array("RS04722", "N", 15, 2);
$polozky6[] = array("RS04723", "N", 15, 2);
$polozky6[] = array("RS04724", "N", 15, 2);
$polozky6[] = array("RS04725", "N", 15, 2);
$polozky6[] = array("RS04726", "N", 15, 2);

$polozky6[] = array("RS04801", "N", 15, 2);
$polozky6[] = array("RS04802", "N", 15, 2);
$polozky6[] = array("RS04803", "N", 15, 2);
$polozky6[] = array("RS04804", "N", 15, 2);
$polozky6[] = array("RS04805", "N", 15, 2);
$polozky6[] = array("RS04806", "N", 15, 2);
$polozky6[] = array("RS04807", "N", 15, 2);
$polozky6[] = array("RS04808", "N", 15, 2);
$polozky6[] = array("RS04809", "N", 15, 2);
$polozky6[] = array("RS04810", "N", 15, 2);
$polozky6[] = array("RS04811", "N", 15, 2);
$polozky6[] = array("RS04812", "N", 15, 2);
$polozky6[] = array("RS04813", "N", 15, 2);
$polozky6[] = array("RS04814", "N", 15, 2);
$polozky6[] = array("RS04815", "N", 15, 2);
$polozky6[] = array("RS04816", "N", 15, 2);
$polozky6[] = array("RS04817", "N", 15, 2);
$polozky6[] = array("RS04818", "N", 15, 2);
$polozky6[] = array("RS04819", "N", 15, 2);
$polozky6[] = array("RS04820", "N", 15, 2);
$polozky6[] = array("RS04821", "N", 15, 2);
$polozky6[] = array("RS04822", "N", 15, 2);
$polozky6[] = array("RS04823", "N", 15, 2);
$polozky6[] = array("RS04824", "N", 15, 2);
$polozky6[] = array("RS04825", "N", 15, 2);
$polozky6[] = array("RS04826", "N", 15, 2);

$polozky6[] = array("RS04901", "N", 15, 2);
$polozky6[] = array("RS04902", "N", 15, 2);
$polozky6[] = array("RS04903", "N", 15, 2);
$polozky6[] = array("RS04904", "N", 15, 2);
$polozky6[] = array("RS04905", "N", 15, 2);
$polozky6[] = array("RS04906", "N", 15, 2);
$polozky6[] = array("RS04907", "N", 15, 2);
$polozky6[] = array("RS04908", "N", 15, 2);
$polozky6[] = array("RS04909", "N", 15, 2);
$polozky6[] = array("RS04910", "N", 15, 2);
$polozky6[] = array("RS04911", "N", 15, 2);
$polozky6[] = array("RS04912", "N", 15, 2);
$polozky6[] = array("RS04913", "N", 15, 2);
$polozky6[] = array("RS04914", "N", 15, 2);
$polozky6[] = array("RS04915", "N", 15, 2);
$polozky6[] = array("RS04916", "N", 15, 2);
$polozky6[] = array("RS04917", "N", 15, 2);
$polozky6[] = array("RS04918", "N", 15, 2);
$polozky6[] = array("RS04919", "N", 15, 2);
$polozky6[] = array("RS04920", "N", 15, 2);
$polozky6[] = array("RS04921", "N", 15, 2);
$polozky6[] = array("RS04922", "N", 15, 2);
$polozky6[] = array("RS04923", "N", 15, 2);
$polozky6[] = array("RS04924", "N", 15, 2);
$polozky6[] = array("RS04925", "N", 15, 2);
$polozky6[] = array("RS04926", "N", 15, 2);

$polozky6[] = array("RS05001", "N", 15, 2);
$polozky6[] = array("RS05002", "N", 15, 2);
$polozky6[] = array("RS05003", "N", 15, 2);
$polozky6[] = array("RS05004", "N", 15, 2);
$polozky6[] = array("RS05005", "N", 15, 2);
$polozky6[] = array("RS05006", "N", 15, 2);
$polozky6[] = array("RS05007", "N", 15, 2);
$polozky6[] = array("RS05008", "N", 15, 2);
$polozky6[] = array("RS05009", "N", 15, 2);
$polozky6[] = array("RS05010", "N", 15, 2);
$polozky6[] = array("RS05011", "N", 15, 2);
$polozky6[] = array("RS05012", "N", 15, 2);
$polozky6[] = array("RS05013", "N", 15, 2);
$polozky6[] = array("RS05014", "N", 15, 2);
$polozky6[] = array("RS05015", "N", 15, 2);
$polozky6[] = array("RS05016", "N", 15, 2);
$polozky6[] = array("RS05017", "N", 15, 2);
$polozky6[] = array("RS05018", "N", 15, 2);
$polozky6[] = array("RS05019", "N", 15, 2);
$polozky6[] = array("RS05020", "N", 15, 2);
$polozky6[] = array("RS05021", "N", 15, 2);
$polozky6[] = array("RS05022", "N", 15, 2);
$polozky6[] = array("RS05023", "N", 15, 2);
$polozky6[] = array("RS05024", "N", 15, 2);
$polozky6[] = array("RS05025", "N", 15, 2);
$polozky6[] = array("RS05026", "N", 15, 2);


// Získáme unikátní název DBF souboru


$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/FIN4P6_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/FIN4P6_".$kli_uzid."_".$hhmmss.".dbf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazev_souboru6 = $outfilex;

//Vytvoøíme DBF soubor
$dbf_soubor = dbase_create($nazev_souboru6, $polozky6);
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
//@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* Uživateli nabídneme soubor ke stažení - zašleme sadu pøíslušných hlavièek a následnì obsah celého souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=$nazev_souboru6"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec smažeme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE fin4pdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";


} while (false);
/////////////////////////////////////////////////////////////////////////////////////////////////////////FIN4P6.DBF
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
<td>EuroSecom  -  FIN 4-04 DBF</td>
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
Stiahnite si nižšie uvedené súbory na Váš lokálny disk, premenujte ich na FIN4P1.DBF, FIN4P2.DBF, FIN4P3.DBF, FIN4P4.DBF, FIN4P5.DBF a FIN4P6.DBF a potom naèítajte na portál www.rissam.sk :
<br />
<br />
<a href="<?php echo $nazev_souboru; ?>"><?php echo $nazev_souboru; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru2; ?>"><?php echo $nazev_souboru2; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru3; ?>"><?php echo $nazev_souboru3; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru4; ?>"><?php echo $nazev_souboru4; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru5; ?>"><?php echo $nazev_souboru5; ?></a>
<br />
<br />
<a href="<?php echo $nazev_souboru6; ?>"><?php echo $nazev_souboru6; ?></a>

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
