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

//////////////////////////////////////////////////////////// FIN 112 prijnujpod.dbf
/* Zde za��n� "vlastn�" skript, cel� je uzav�en do cyklu do-while (false), co� p�i pou�it� p��kaz� break zna�n� usnadn� a zp�ehledn� zpracov�n� chybov�ch stav� */
do {

//echo "idem dalej2";

/* Vytvo��me spojen� s SQL serverem a zvol�me datab�zi - nezapome�te upravit tak, aby to odpov�dalo Va�emu nastaven�. */
//$spojeni = @mysql_connect("localhost");

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni)
{
  vypsat_zpravu("Nepoda�ilo se p�ipojit k datab�zi.");
  break;
}

//Takt� upravte podle Va�eho nastaven�:
@mysql_select_db($mysqldb, $spojeni);

//echo "idem dalej3";


$sqlt = <<<prijdbf
(
ICO CHARACTER 8 I�O
DATROK CHARACTER 4 rok vykazovacieho obdobia
DATMES CHARACTER 2 mesiac vykazovacieho obdobia
TYPORG CHARACTER 2 typ organiz�cie (�31� � neziskov� in�tit�cia
�51� � obchodn� spolo�nos�)
CAST CHARACTER 1 �as� (�1� � Pr�jmy rozpo�tu
�3� � Pr�jmy finan�n�ch oper�ci�)
ZDROJ CHARACTER 4 zdroj
TYPZD CHARACTER 1 typ zdroja (�M� � mimorozpo�tov� prostriedky
�R� � rozpo�tov� prostriedky)
POL CHARACTER 3 polo�ka
PODP CHARACTER 3 podpolo�ka
RS00001 NUMERIC (15,2) schv�len� rozpo�et
RS00002 NUMERIC (15,2) rozpo�et po zmen�ch
RS00003 NUMERIC (15,2) o�ak�van� skuto�nos�
RS00004 NUMERIC (15,2) skuto�nos�
);
prijdbf;


$sqlx = 'DROP TABLE prijdbf';
$vysledx = mysql_query("$sqlx");

$sqlx = "SELECT * FROM prijdbf";
$vysledx = mysql_query("$sqlx");
if (!$vysledx)
{
//echo "Vytvorit tabulku prijdbf!"."<br />";

$sqlt = <<<prijdbf
(
ico             VARCHAR(8),
datrok          VARCHAR(4),
datmes          VARCHAR(2),
typorg          VARCHAR(2),
cast            VARCHAR(1),
zdroj           VARCHAR(4),
typzd           VARCHAR(1),
pol             VARCHAR(3),
podp            VARCHAR(3),
rs00001         DECIMAL(12,2),
rs00002         DECIMAL(12,2),
rs00003         DECIMAL(12,2),
rs00004         DECIMAL(12,2)
);
prijdbf;

$sqlx = 'CREATE TABLE prijdbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" 1,zdroj,'R',xpolozka,podpolozka,schvaleny,zmeneny,predpoklad,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//cast 3ka nejde
$dsqlt = "INSERT INTO prijdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" 1,zdroj,'R',xpolozka,podpolozka,schvaleny,zmeneny,predpoklad,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 ORDER BY polozka";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

//vloz celkovy sucet do vytvorenej databazy

$dsqlt = "INSERT INTO prijdbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" druh,'9','R','','',SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost) ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 GROUP BY druh";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE prijdbf "." SET cast=4 WHERE cast = 3 ";
$dsql = mysql_query("$dsqlt");

/* P�iprav�me si SQL dotaz (v praxi bychom jej z�skali asi jinak...) */
$dotaz = "select * from prijdbf order by cast,zdroj,pol,podp ";


/* Vytvo��me pole, kter� odpov�daj� jednotliv�m polo�k�m */
$polozky[] = array("ICO", "C", 8);
$polozky[] = array("DATROK", "C", 4);
$polozky[] = array("DATMES", "C", 2);
$polozky[] = array("TYPORG", "C", 2);
$polozky[] = array("CAST", "C", 1);
$polozky[] = array("ZDROJ", "C", 4);
$polozky[] = array("TYPZD", "C", 1);
$polozky[] = array("POL", "C", 3);
$polozky[] = array("PODP", "C", 3);
$polozky[] = array("RS00001", "N", 15, 2);
$polozky[] = array("RS00002", "N", 15, 2);
$polozky[] = array("RS00003", "N", 15, 2);
$polozky[] = array("RS00004", "N", 15, 2);

// Z�sk�me unik�tn� n�zev DBF souboru
$nazev_souboru = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru = "../tmp/prijnujpod.dbf";
//echo $nazev_souboru;

@unlink($nazev_souboru);

//echo "idem dalej4";

//Vytvo��me DBF soubor
$dbf_soubor = dbase_create($nazev_souboru, $polozky);
if (!$dbf_soubor)
{
  vypsat_zpravu("Nepoda�ilo se vytvo�it DBF soubor.");
  break;
}

//echo "idem dalej5";

//Z�sk�me v�sledek SQL dotazu
$vysledek = mysql_query($dotaz, $spojeni);
if (!$vysledek)
{
  vypsat_zpravu("Zpracov�n� SQL dotazu neprob�hlo �sp�n�.");
  break;
}

//exit;
//echo "idem dalej6";

/* Postupn� p�id�v�me jednotliv� z�znamy do DBF souboru */
while ($zaznam = @mysql_fetch_row($vysledek))
  dbase_add_record($dbf_soubor, $zaznam);

//Uzav�eme ob� spojen�
@mysql_close($spojeni);
@dbase_close($dbf_soubor);

/* U�ivateli nab�dneme soubor ke sta�en� - za�leme sadu p��slu�n�ch hlavi�ek a n�sledn� obsah cel�ho souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=prijnujpod.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru);

//Soubor nakonec sma�eme
//@unlink($nazev_souboru);

$sqlx = 'DROP TABLE prijdbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 112 prijnujpod.dbf


//////////////////////////////////////////////////////////// FIN 112 vydnujpod.dbf
/* Zde za��n� "vlastn�" skript, cel� je uzav�en do cyklu do-while (false), co� p�i pou�it� p��kaz� break zna�n� usnadn� a zp�ehledn� zpracov�n� chybov�ch stav� */
do {

//echo "idem dalej2";

/* Vytvo��me spojen� s SQL serverem a zvol�me datab�zi - nezapome�te upravit tak, aby to odpov�dalo Va�emu nastaven�. */
//$spojeni = @mysql_connect("localhost");

require_once("../pswd/password.php");
@$spojeni2 = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni2)
{
  vypsat_zpravu("Nepoda�ilo se p�ipojit k datab�zi.");
  break;
}

//Takt� upravte podle Va�eho nastaven�:
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
ico             VARCHAR(8),
datrok          VARCHAR(4),
datmes          VARCHAR(2),
typorg          VARCHAR(2),
cast            VARCHAR(1),
zdroj           VARCHAR(4),
typzd           VARCHAR(1),
odd             VARCHAR(2),
skup            VARCHAR(1),
trieda          VARCHAR(1),
podtr           VARCHAR(1),
pol             VARCHAR(3),
podp            VARCHAR(3),
rs00001         DECIMAL(12,2),
rs00002         DECIMAL(12,2),
rs00003         DECIMAL(12,2),
rs00004         DECIMAL(12,2)
);
vyddbf;

$sqlx = 'CREATE TABLE vyddbf'.$sqlt;
$vysledx = mysql_query("$sqlx");


}
//koniec vytvorenia

//vloz vykaz do vytvorenej databazy

$dsqlt = "INSERT INTO vyddbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" 2,zdroj,'R',xoddiel,skupina,trieda,podtrieda,xpolozka,podpolozka,schvaleny,zmeneny,predpoklad,skutocnost ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 ORDER BY polozka";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//cast 4ka nejde


//vloz celkovy sucet do vytvorenej databazy

$dsqlt = "INSERT INTO vyddbf "." SELECT".
" '$fir_ficox','$kli_vrok','$mesiac','$typorg',".
" druh,'9','R','','','','','','',SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost) ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 GROUP BY druh";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE vyddbf "." SET cast=1 WHERE cast = 2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE vyddbf "." SET cast=4 WHERE cast = 4 ";
//$dsql = mysql_query("$dsqlt");

if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 409 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 )) 
{
$sqtoz = "UPDATE vyddbf SET odd='0', skup='7', trieda='2', podtr='2' WHERE zdroj != 9 ";
$oznac = mysql_query("$sqtoz");
}


//exit;

/* P�iprav�me si SQL dotaz (v praxi bychom jej z�skali asi jinak...) */
$dotaz2 = "select * from vyddbf order by cast,zdroj,odd,skup,trieda,podtr,pol,podp ";

/* Vytvo��me pole, kter� odpov�daj� jednotliv�m polo�k�m */
$polozky2[] = array("ICO", "C", 8);
$polozky2[] = array("DATROK", "C", 4);
$polozky2[] = array("DATMES", "C", 2);
$polozky2[] = array("TYPORG", "C", 2);
$polozky2[] = array("CAST", "C", 1);
$polozky2[] = array("ZDROJ", "C", 4);
$polozky2[] = array("TYPZD", "C", 1);
$polozky2[] = array("ODD", "C", 2);
$polozky2[] = array("SKUP", "C", 1);
$polozky2[] = array("TRIEDA", "C", 1);
$polozky2[] = array("PODTR", "C", 1);
$polozky2[] = array("POL", "C", 3);
$polozky2[] = array("PODP", "C", 3);
$polozky2[] = array("RS00001", "N", 15, 2);
$polozky2[] = array("RS00002", "N", 15, 2);
$polozky2[] = array("RS00003", "N", 15, 2);
$polozky2[] = array("RS00004", "N", 15, 2);

// Z�sk�me unik�tn� n�zev DBF souboru
$nazev_souboru2 = "../tmp/".uniqid("soubor", true) . ".dbf";
$nazev_souboru2 = "../tmp/vydnujpod.dbf";
//echo $nazev_souboru2;

@unlink($nazev_souboru2);

//echo "idem dalej4";

//Vytvo��me DBF soubor
$dbf_soubor2 = @dbase_create($nazev_souboru2, $polozky2);
if (!$dbf_soubor2)
{
  vypsat_zpravu("Nepoda�ilo se vytvo�it DBF soubor.");
  break;
}

//echo "idem dalej5";

//Z�sk�me v�sledek SQL dotazu
$vysledek = mysql_query($dotaz2, $spojeni2);
if (!$vysledek)
{
  vypsat_zpravu("Zpracov�n� SQL dotazu neprob�hlo �sp�n�.");
  break;
}

//exit;
//echo "idem dalej6";

/* Postupn� p�id�v�me jednotliv� z�znamy do DBF souboru */
while ($zaznam = @mysql_fetch_row($vysledek))
  dbase_add_record($dbf_soubor2, $zaznam);

//Uzav�eme ob� spojen�
@mysql_close($spojeni2);
@dbase_close($dbf_soubor2);

/* U�ivateli nab�dneme soubor ke sta�en� - za�leme sadu p��slu�n�ch hlavi�ek a n�sledn� obsah cel�ho souboru */
//header("Content-Type: application/dbf");
//header("Content-Disposition: attachment; filename=vydnujpod.dbf"); 
//header("Content-Description: PHP Generated Data");
//@readfile($nazev_souboru2);

//Soubor nakonec sma�eme
//@unlink($nazev_souboru2);

$sqlx = 'DROP TABLE vyddbf';
//$vysledx = mysql_query("$sqlx");

//echo "idem dalejkon";

} while (false);
////////////////////////////////////////////////////////////KONIEC FIN 112 vydnujpod.dbf



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


    
</script>
</HEAD>
<BODY class="white" onload="VyberVstup();">




<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 1-12 NUJPOD DBF</td>
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
Stiahnite si ni��ie uveden� s�bory na V� lok�lny disk  :
<br />
<br />
<a href="../tmp/prijnujpod.dbf">prijnujpod.dbf</a>
<br />
<br />
<a href="../tmp/vydnujpod.dbf">vydnujpod.dbf</a>

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
