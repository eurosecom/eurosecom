<!doctype html>
<html>
<?php
//celkovy zaciatok
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=9999;

//pagination
$total_strana=5;

//.jpg source
$jpg_source="../dokumenty/tlacivo2018/fin2-04/fin2-04_v18";
$jpg_title="Finanèný výkaz o vybraných údajoch z aktív a z pasív subjektu verejnej správy FIN 2-04 za rok $kli_vrok $strana.strana";

if ( $cislo_oc == 0 ) $cislo_oc=1;
if ( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if ( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if ( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if ( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }
$vsetkyprepocty=0;

//ak nie je generovanie daj standardne
$niejegen=0;
$sql = "SELECT g2018g FROM F".$kli_vxcf."_genfin204pod ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$copern=1001;
$niejegen=1;
}
//koniec ak nie je generovanie daj standardne


//Tabulka generovania
if ( $copern == 1001 )
{

$sql = "DROP TABLE F$kli_vxcf"."_genfin204pod";
$vysledok = mysql_query("$sql");

$sqlt = <<<crf204nuj_no
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         INT,
   cpl01       INT,
   g2018g      DECIMAL(2,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
crf204nuj_no;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin204pod'.$sqlt;
$vysledek = mysql_query("$sql");

//echo "idem nove gen";

//aktiva
//dnm
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '012', '2' ); "; $ulozene = mysql_query("$sqult");
//echo $sqult;
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '072', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '091', '2' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '013', '3' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '073', '3' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '014', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '074', '4' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '051', '5' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '095', '5' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '018', '6' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '019', '6' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '078', '6' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '079', '6' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '041', '7' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '093', '7' ); "; $ulozene = mysql_query("$sqult");

//dhm
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '031', '9' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '092', '9' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '025', '10' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '085', '10' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '032', '11' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '033', '11' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '021', '12' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '081', '12' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '022', '13' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '082', '13' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '024', '13' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '084', '13' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '023', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '083', '14' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '052', '15' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '025', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '026', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '028', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '029', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '085', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '086', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '088', '16' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '089', '16' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '042', '17' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '094', '17' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '097', '18' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '098', '18' ); "; $ulozene = mysql_query("$sqult");

//DFM
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '061', '20' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '062', '20' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '063', '20' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '096', '20' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '065', '21' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '066', '22' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '067', '22' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '069', '23' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '043', '24' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '053', '25' ); "; $ulozene = mysql_query("$sqult");

//zasoby
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '111', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '112', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '119', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '121', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '122', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '123', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '124', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '131', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '132', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '133', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '139', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '191', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '192', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '193', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '194', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '195', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '196', '26' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '395', '26' ); "; $ulozene = mysql_query("$sqult");

//pohladavky
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '311', '36' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '391', '36' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '312', '37' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '314', '38' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '313', '39' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '375', '39' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '336', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '341', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '342', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '343', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '345', '42' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '374', '43' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '376', '43' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '373', '44' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '358', '45' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '396', '45' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '358', '45' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '396', '45' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '315', '49' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '335', '49' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '378', '49' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '346', '51' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '348', '51' ); "; $ulozene = mysql_query("$sqult");

//financne ucty
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '211', '53' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '213', '53' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '221', '54' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '261', '54' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '251', '58' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '257', '58' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '291', '58' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '253', '59' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '255', '59' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '256', '59' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '257', '59' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '259', '60' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '381', '64' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '382', '64' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '385', '65' ); "; $ulozene = mysql_query("$sqult");

//pasiva
//vl.imanie
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '411', '70' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '491', '70' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '419', '70' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '353', '70' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '413', '71' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '417', '71' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '418', '71' ); "; $ulozene = mysql_query("$sqult");


$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '421', '72' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '422', '72' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '423', '72' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '427', '72' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '414', '74' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '415', '74' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '416', '74' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '428', '75' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '429', '75' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '431', '75' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '323', '76' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '451', '76' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '459', '76' ); "; $ulozene = mysql_query("$sqult");


//zavazky
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '478', '86' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '373', '87' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '377', '87' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '479', '87' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '321', '90' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '476', '90' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '475', '91' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '379', '92' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '474', '93' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '472', '95' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '471', '96' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '461', '99' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '322', '103' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '373', '104' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '377', '104' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '241', '105' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '473', '105' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '324', '108' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '331', '112' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '333', '112' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '336', '113' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '341', '113' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '342', '113' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '343', '113' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '345', '113' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '481', '113' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '346', '114' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '347', '114' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '367', '115' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '368', '116' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '398', '116' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '361', '117' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '364', '117' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '365', '117' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '366', '117' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '372', '117' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '471', '117' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '316', '121' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '325', '121' ); "; $ulozene = mysql_query("$sqult");

//uvery
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '231', '123' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '232', '123' ); "; $ulozene = mysql_query("$sqult");

//rozlis
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '383', '127' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '384', '128' ); "; $ulozene = mysql_query("$sqult");

//sumar za ucet=ak jeden ucet v dvoch riadkoch tak zober jeden
$sqult = "UPDATE F$kli_vxcf"."_genfin204pod SET cpl01=1 "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod SELECT 0,uce,crs,0,0 FROM F$kli_vxcf"."_genfin204pod GROUP BY uce "; $ulozene = mysql_query("$sqult");
$sqult = "DELETE FROM F$kli_vxcf"."_genfin204pod WHERE cpl01 != 0 "; $ulozene = mysql_query("$sqult");

$nacitajgen = 1*$_REQUEST['nacitajgen'];
if ( $nacitajgen == 1 ) {
?>
<script type="text/javascript">
window.open('../ucto/fin_cis.php?copern=308&drupoh=91&page=1&sysx=UCT', '_self');
</script>
<?php
exit;
                      }
$copern=20;
}
//koniec Tabulka generovania


//znovu nacitaj
if ( $copern == 26 )
    {
//echo "citam";
$nasielvyplnene=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xokres=1*$riaddok->okres;
  $xobec=1*$riaddok->obec;
  }

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");
$copern=20;
if( $zupravy == 1 ) $copern=20;
$subor=1;
$vsetkyprepocty=1;
    }
//koniec znovu nacitaj



//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
//$okres = strip_tags($_REQUEST['okres']);
//$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" daz='$daz_sql' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 2 ) {
$r01 = 1*$_REQUEST['r01']; $rk01 = 1*$_REQUEST['rk01']; $rn01 = 1*$_REQUEST['rn01']; $rm01 = 1*$_REQUEST['rm01'];
$r02 = 1*$_REQUEST['r02']; $rk02 = 1*$_REQUEST['rk02']; $rn02 = 1*$_REQUEST['rn02']; $rm02 = 1*$_REQUEST['rm02'];
$r03 = 1*$_REQUEST['r03']; $rk03 = 1*$_REQUEST['rk03']; $rn03 = 1*$_REQUEST['rn03']; $rm03 = 1*$_REQUEST['rm03'];
$r04 = 1*$_REQUEST['r04']; $rk04 = 1*$_REQUEST['rk04']; $rn04 = 1*$_REQUEST['rn04']; $rm04 = 1*$_REQUEST['rm04'];
$r05 = 1*$_REQUEST['r05']; $rk05 = 1*$_REQUEST['rk05']; $rn05 = 1*$_REQUEST['rn05']; $rm05 = 1*$_REQUEST['rm05'];
$r06 = 1*$_REQUEST['r06']; $rk06 = 1*$_REQUEST['rk06']; $rn06 = 1*$_REQUEST['rn06']; $rm06 = 1*$_REQUEST['rm06'];
$r07 = 1*$_REQUEST['r07']; $rk07 = 1*$_REQUEST['rk07']; $rn07 = 1*$_REQUEST['rn07']; $rm07 = 1*$_REQUEST['rm07'];
$r08 = 1*$_REQUEST['r08']; $rk08 = 1*$_REQUEST['rk08']; $rn08 = 1*$_REQUEST['rn08']; $rm08 = 1*$_REQUEST['rm08'];
$r09 = 1*$_REQUEST['r09']; $rk09 = 1*$_REQUEST['rk09']; $rn09 = 1*$_REQUEST['rn09']; $rm09 = 1*$_REQUEST['rm09'];
$r10 = 1*$_REQUEST['r10']; $rk10 = 1*$_REQUEST['rk10']; $rn10 = 1*$_REQUEST['rn10']; $rm10 = 1*$_REQUEST['rm10'];
$r11 = 1*$_REQUEST['r11']; $rk11 = 1*$_REQUEST['rk11']; $rn11 = 1*$_REQUEST['rn11']; $rm11 = 1*$_REQUEST['rm11'];
$r12 = 1*$_REQUEST['r12']; $rk12 = 1*$_REQUEST['rk12']; $rn12 = 1*$_REQUEST['rn12']; $rm12 = 1*$_REQUEST['rm12'];
$r13 = 1*$_REQUEST['r13']; $rk13 = 1*$_REQUEST['rk13']; $rn13 = 1*$_REQUEST['rn13']; $rm13 = 1*$_REQUEST['rm13'];
$r14 = 1*$_REQUEST['r14']; $rk14 = 1*$_REQUEST['rk14']; $rn14 = 1*$_REQUEST['rn14']; $rm14 = 1*$_REQUEST['rm14'];
$r15 = 1*$_REQUEST['r15']; $rk15 = 1*$_REQUEST['rk15']; $rn15 = 1*$_REQUEST['rn15']; $rm15 = 1*$_REQUEST['rm15'];
$r16 = 1*$_REQUEST['r16']; $rk16 = 1*$_REQUEST['rk16']; $rn16 = 1*$_REQUEST['rn16']; $rm16 = 1*$_REQUEST['rm16'];
$r17 = 1*$_REQUEST['r17']; $rk17 = 1*$_REQUEST['rk17']; $rn17 = 1*$_REQUEST['rn17']; $rm17 = 1*$_REQUEST['rm17'];
$r18 = 1*$_REQUEST['r18']; $rk18 = 1*$_REQUEST['rk18']; $rn18 = 1*$_REQUEST['rn18']; $rm18 = 1*$_REQUEST['rm18'];
$r19 = 1*$_REQUEST['r19']; $rk19 = 1*$_REQUEST['rk19']; $rn19 = 1*$_REQUEST['rn19']; $rm19 = 1*$_REQUEST['rm19'];
$r20 = 1*$_REQUEST['r20']; $rk20 = 1*$_REQUEST['rk20']; $rn20 = 1*$_REQUEST['rn20']; $rm20 = 1*$_REQUEST['rm20'];
$r21 = 1*$_REQUEST['r21']; $rk21 = 1*$_REQUEST['rk21']; $rn21 = 1*$_REQUEST['rn21']; $rm21 = 1*$_REQUEST['rm21'];
$r22 = 1*$_REQUEST['r22']; $rk22 = 1*$_REQUEST['rk22']; $rn22 = 1*$_REQUEST['rn22']; $rm22 = 1*$_REQUEST['rm22'];
$r23 = 1*$_REQUEST['r23']; $rk23 = 1*$_REQUEST['rk23']; $rn23 = 1*$_REQUEST['rn23']; $rm23 = 1*$_REQUEST['rm23'];
$r24 = 1*$_REQUEST['r24']; $rk24 = 1*$_REQUEST['rk24']; $rn24 = 1*$_REQUEST['rn24']; $rm24 = 1*$_REQUEST['rm24'];
$r25 = 1*$_REQUEST['r25']; $rk25 = 1*$_REQUEST['rk25']; $rn25 = 1*$_REQUEST['rn25']; $rm25 = 1*$_REQUEST['rm25'];
$r26 = 1*$_REQUEST['r26']; $rk26 = 1*$_REQUEST['rk26']; $rn26 = 1*$_REQUEST['rn26']; $rm26 = 1*$_REQUEST['rm26'];
$r27 = 1*$_REQUEST['r27']; $rk27 = 1*$_REQUEST['rk27']; $rn27 = 1*$_REQUEST['rn27']; $rm27 = 1*$_REQUEST['rm27'];
$r28 = 1*$_REQUEST['r28']; $rk28 = 1*$_REQUEST['rk28']; $rn28 = 1*$_REQUEST['rn28']; $rm28 = 1*$_REQUEST['rm28'];
$r29 = 1*$_REQUEST['r29']; $rk29 = 1*$_REQUEST['rk29']; $rn29 = 1*$_REQUEST['rn29']; $rm29 = 1*$_REQUEST['rm29'];
$r30 = 1*$_REQUEST['r30']; $rk30 = 1*$_REQUEST['rk30']; $rn30 = 1*$_REQUEST['rn30']; $rm30 = 1*$_REQUEST['rm30'];
$r31 = 1*$_REQUEST['r31']; $rk31 = 1*$_REQUEST['rk31']; $rn31 = 1*$_REQUEST['rn31']; $rm31 = 1*$_REQUEST['rm31'];
$r32 = 1*$_REQUEST['r32']; $rk32 = 1*$_REQUEST['rk32']; $rn32 = 1*$_REQUEST['rn32']; $rm32 = 1*$_REQUEST['rm32'];
$r33 = 1*$_REQUEST['r33']; $rk33 = 1*$_REQUEST['rk33']; $rn33 = 1*$_REQUEST['rn33']; $rm33 = 1*$_REQUEST['rm33'];
$r34 = 1*$_REQUEST['r34']; $rk34 = 1*$_REQUEST['rk34']; $rn34 = 1*$_REQUEST['rn34']; $rm34 = 1*$_REQUEST['rm34'];
$r35 = 1*$_REQUEST['r35']; $rk35 = 1*$_REQUEST['rk35']; $rn35 = 1*$_REQUEST['rn35']; $rm35 = 1*$_REQUEST['rm35'];
$r36 = 1*$_REQUEST['r36']; $rk36 = 1*$_REQUEST['rk36']; $rn36 = 1*$_REQUEST['rn36']; $rm36 = 1*$_REQUEST['rm36'];
$r37 = 1*$_REQUEST['r37']; $rk37 = 1*$_REQUEST['rk37']; $rn37 = 1*$_REQUEST['rn37']; $rm37 = 1*$_REQUEST['rm37'];
$r38 = 1*$_REQUEST['r38']; $rk38 = 1*$_REQUEST['rk38']; $rn38 = 1*$_REQUEST['rn38']; $rm38 = 1*$_REQUEST['rm38'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r01='$r01', rk01='$rk01', rn01='$rn01', rm01='$rm01',
  r02='$r02', rk02='$rk02', rn02='$rn02', rm02='$rm02',
  r03='$r03', rk03='$rk03', rn03='$rn03', rm03='$rm03',
  r04='$r04', rk04='$rk04', rn04='$rn04', rm04='$rm04',
  r05='$r05', rk05='$rk05', rn05='$rn05', rm05='$rm05',
  r06='$r06', rk06='$rk06', rn06='$rn06', rm06='$rm06',
  r07='$r07', rk07='$rk07', rn07='$rn07', rm07='$rm07',
  r08='$r08', rk08='$rk08', rn08='$rn08', rm08='$rm08',
  r09='$r09', rk09='$rk09', rn09='$rn09', rm09='$rm09',
  r10='$r10', rk10='$rk10', rn10='$rn10', rm10='$rm10',
  r11='$r11', rk11='$rk11', rn11='$rn11', rm11='$rm11',
  r12='$r12', rk12='$rk12', rn12='$rn12', rm12='$rm12',
  r13='$r13', rk13='$rk13', rn13='$rn13', rm13='$rm13',
  r14='$r14', rk14='$rk14', rn14='$rn14', rm14='$rm14',
  r15='$r15', rk15='$rk15', rn15='$rn15', rm15='$rm15',
  r16='$r16', rk16='$rk16', rn16='$rn16', rm16='$rm16',
  r17='$r17', rk17='$rk17', rn17='$rn17', rm17='$rm17',
  r18='$r18', rk18='$rk18', rn18='$rn18', rm18='$rm18',
  r19='$r19', rk19='$rk19', rn19='$rn19', rm19='$rm19',
  r20='$r20', rk20='$rk20', rn20='$rn20', rm20='$rm20',
  r21='$r21', rk21='$rk21', rn21='$rn21', rm21='$rm21',
  r22='$r22', rk22='$rk22', rn22='$rn22', rm22='$rm22',
  r23='$r23', rk23='$rk23', rn23='$rn23', rm23='$rm23',
  r24='$r24', rk24='$rk24', rn24='$rn24', rm24='$rm24',
  r25='$r25', rk25='$rk25', rn25='$rn25', rm25='$rm25',
  r26='$r26', rk26='$rk26', rn26='$rn26', rm26='$rm26',
  r27='$r27', rk27='$rk27', rn27='$rn27', rm27='$rm27',
  r28='$r28', rk28='$rk28', rn28='$rn28', rm28='$rm28',
  r29='$r29', rk29='$rk29', rn29='$rn29', rm29='$rm29',
  r30='$r30', rk30='$rk30', rn30='$rn30', rm30='$rm30',
  r31='$r31', rk31='$rk31', rn31='$rn31', rm31='$rm31',
  r32='$r32', rk32='$rk32', rn32='$rn32', rm32='$rm32',
  r33='$r33', rk33='$rk33', rn33='$rn33', rm33='$rm33',
  r34='$r34', rk34='$rk34', rn34='$rn34', rm34='$rm34',
  r35='$r35', rk35='$rk35', rn35='$rn35', rm35='$rm35',
  r36='$r36', rk36='$rk36', rn36='$rn36', rm36='$rm36',
  r37='$r37', rk37='$rk37', rn37='$rn37', rm37='$rm37',
  r38='$r38', rk38='$rk38', rn38='$rn38', rm38='$rm38' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 3 ) {
$r39 = 1*$_REQUEST['r39']; $rk39 = 1*$_REQUEST['rk39']; $rn39 = 1*$_REQUEST['rn39']; $rm39 = 1*$_REQUEST['rm39'];
$r40 = 1*$_REQUEST['r40']; $rk40 = 1*$_REQUEST['rk40']; $rn40 = 1*$_REQUEST['rn40']; $rm40 = 1*$_REQUEST['rm40'];
$r41 = 1*$_REQUEST['r41']; $rk41 = 1*$_REQUEST['rk41']; $rn41 = 1*$_REQUEST['rn41']; $rm41 = 1*$_REQUEST['rm41'];
$r42 = 1*$_REQUEST['r42']; $rk42 = 1*$_REQUEST['rk42']; $rn42 = 1*$_REQUEST['rn42']; $rm42 = 1*$_REQUEST['rm42'];
$r43 = 1*$_REQUEST['r43']; $rk43 = 1*$_REQUEST['rk43']; $rn43 = 1*$_REQUEST['rn43']; $rm43 = 1*$_REQUEST['rm43'];
$r44 = 1*$_REQUEST['r44']; $rk44 = 1*$_REQUEST['rk44']; $rn44 = 1*$_REQUEST['rn44']; $rm44 = 1*$_REQUEST['rm44'];
$r45 = 1*$_REQUEST['r45']; $rk45 = 1*$_REQUEST['rk45']; $rn45 = 1*$_REQUEST['rn45']; $rm45 = 1*$_REQUEST['rm45'];
$r46 = 1*$_REQUEST['r46']; $rk46 = 1*$_REQUEST['rk46']; $rn46 = 1*$_REQUEST['rn46']; $rm46 = 1*$_REQUEST['rm46'];
$r47 = 1*$_REQUEST['r47']; $rk47 = 1*$_REQUEST['rk47']; $rn47 = 1*$_REQUEST['rn47']; $rm47 = 1*$_REQUEST['rm47'];
$r48 = 1*$_REQUEST['r48']; $rk48 = 1*$_REQUEST['rk48']; $rn48 = 1*$_REQUEST['rn48']; $rm48 = 1*$_REQUEST['rm48'];
$r49 = 1*$_REQUEST['r49']; $rk49 = 1*$_REQUEST['rk49']; $rn49 = 1*$_REQUEST['rn49']; $rm49 = 1*$_REQUEST['rm49'];
$r50 = 1*$_REQUEST['r50']; $rk50 = 1*$_REQUEST['rk50']; $rn50 = 1*$_REQUEST['rn50']; $rm50 = 1*$_REQUEST['rm50'];
$r51 = 1*$_REQUEST['r51']; $rk51 = 1*$_REQUEST['rk51']; $rn51 = 1*$_REQUEST['rn51']; $rm51 = 1*$_REQUEST['rm51'];
$r52 = 1*$_REQUEST['r52']; $rk52 = 1*$_REQUEST['rk52']; $rn52 = 1*$_REQUEST['rn52']; $rm52 = 1*$_REQUEST['rm52'];
$r53 = 1*$_REQUEST['r53']; $rk53 = 1*$_REQUEST['rk53']; $rn53 = 1*$_REQUEST['rn53']; $rm53 = 1*$_REQUEST['rm53'];
$r54 = 1*$_REQUEST['r54']; $rk54 = 1*$_REQUEST['rk54']; $rn54 = 1*$_REQUEST['rn54']; $rm54 = 1*$_REQUEST['rm54'];
$r55 = 1*$_REQUEST['r55']; $rk55 = 1*$_REQUEST['rk55']; $rn55 = 1*$_REQUEST['rn55']; $rm55 = 1*$_REQUEST['rm55'];
$r56 = 1*$_REQUEST['r56']; $rk56 = 1*$_REQUEST['rk56']; $rn56 = 1*$_REQUEST['rn56']; $rm56 = 1*$_REQUEST['rm56'];
$r57 = 1*$_REQUEST['r57']; $rk57 = 1*$_REQUEST['rk57']; $rn57 = 1*$_REQUEST['rn57']; $rm57 = 1*$_REQUEST['rm57'];
$r58 = 1*$_REQUEST['r58']; $rk58 = 1*$_REQUEST['rk58']; $rn58 = 1*$_REQUEST['rn58']; $rm58 = 1*$_REQUEST['rm58'];
$r59 = 1*$_REQUEST['r59']; $rk59 = 1*$_REQUEST['rk59']; $rn59 = 1*$_REQUEST['rn59']; $rm59 = 1*$_REQUEST['rm59'];
$r60 = 1*$_REQUEST['r60']; $rk60 = 1*$_REQUEST['rk60']; $rn60 = 1*$_REQUEST['rn60']; $rm60 = 1*$_REQUEST['rm60'];
$r61 = 1*$_REQUEST['r61']; $rk61 = 1*$_REQUEST['rk61']; $rn61 = 1*$_REQUEST['rn61']; $rm61 = 1*$_REQUEST['rm61'];
$r62 = 1*$_REQUEST['r62']; $rk62 = 1*$_REQUEST['rk62']; $rn62 = 1*$_REQUEST['rn62']; $rm62 = 1*$_REQUEST['rm62'];
$r63 = 1*$_REQUEST['r63']; $rk63 = 1*$_REQUEST['rk63']; $rn63 = 1*$_REQUEST['rn63']; $rm63 = 1*$_REQUEST['rm63'];
$r64 = 1*$_REQUEST['r64']; $rk64 = 1*$_REQUEST['rk64']; $rn64 = 1*$_REQUEST['rn64']; $rm64 = 1*$_REQUEST['rm64'];
$r65 = 1*$_REQUEST['r65']; $rk65 = 1*$_REQUEST['rk65']; $rn65 = 1*$_REQUEST['rn65']; $rm65 = 1*$_REQUEST['rm65'];
$r66 = 1*$_REQUEST['r66']; $rk66 = 1*$_REQUEST['rk66']; $rn66 = 1*$_REQUEST['rn66']; $rm66 = 1*$_REQUEST['rm66'];
$r67 = 1*$_REQUEST['r67']; $rk67 = 1*$_REQUEST['rk67']; $rn67 = 1*$_REQUEST['rn67']; $rm67 = 1*$_REQUEST['rm67'];
$r68 = 1*$_REQUEST['r68']; $rk68 = 1*$_REQUEST['rk68']; $rn68 = 1*$_REQUEST['rn68']; $rm68 = 1*$_REQUEST['rm68'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r39='$r39', rk39='$rk39', rn39='$rn39', rm39='$rm39',
  r40='$r40', rk40='$rk40', rn40='$rn40', rm40='$rm40',
  r41='$r41', rk41='$rk41', rn41='$rn41', rm41='$rm41',
  r42='$r42', rk42='$rk42', rn42='$rn42', rm42='$rm42',
  r43='$r43', rk43='$rk43', rn43='$rn43', rm43='$rm43',
  r44='$r44', rk44='$rk44', rn44='$rn44', rm44='$rm44',
  r45='$r45', rk45='$rk45', rn45='$rn45', rm45='$rm45',
  r46='$r46', rk46='$rk46', rn46='$rn46', rm46='$rm46',
  r47='$r47', rk47='$rk47', rn47='$rn47', rm47='$rm47',
  r48='$r48', rk48='$rk48', rn48='$rn48', rm48='$rm48',
  r49='$r49', rk49='$rk49', rn49='$rn49', rm49='$rm49',
  r50='$r50', rk50='$rk50', rn50='$rn50', rm50='$rm50',
  r51='$r51', rk51='$rk51', rn51='$rn51', rm51='$rm51',
  r52='$r52', rk52='$rk52', rn52='$rn52', rm52='$rm52',
  r53='$r53', rk53='$rk53', rn53='$rn53', rm53='$rm53',
  r54='$r54', rk54='$rk54', rn54='$rn54', rm54='$rm54',
  r55='$r55', rk55='$rk55', rn55='$rn55', rm55='$rm55',
  r56='$r56', rk56='$rk56', rn56='$rn56', rm56='$rm56',
  r57='$r57', rk57='$rk57', rn57='$rn57', rm57='$rm57',
  r58='$r58', rk58='$rk58', rn58='$rn58', rm58='$rm58',
  r59='$r59', rk59='$rk59', rn59='$rn59', rm59='$rm59',
  r60='$r60', rk60='$rk60', rn60='$rn60', rm60='$rm60',
  r61='$r61', rk61='$rk61', rn61='$rn61', rm61='$rm61',
  r62='$r62', rk62='$rk62', rn62='$rn62', rm62='$rm62',
  r63='$r63', rk63='$rk63', rn63='$rn63', rm63='$rm63',
  r64='$r64', rk64='$rk64', rn64='$rn64', rm64='$rm64',
  r65='$r65', rk65='$rk65', rn65='$rn65', rm65='$rm65',
  r66='$r66', rk66='$rk66', rn66='$rn66', rm66='$rm66',
  r67='$r67', rk67='$rk67', rn67='$rn67', rm67='$rm67',
  r68='$r68', rk68='$rk68', rn68='$rn68', rm68='$rm68' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 4 ) {
$r69 = 1*$_REQUEST['r69']; $rm69 = 1*$_REQUEST['rm69'];
$r70 = 1*$_REQUEST['r70']; $rm70 = 1*$_REQUEST['rm70'];
$r71 = 1*$_REQUEST['r71']; $rm71 = 1*$_REQUEST['rm71'];
$r72 = 1*$_REQUEST['r72']; $rm72 = 1*$_REQUEST['rm72'];
$r73 = 1*$_REQUEST['r73']; $rm73 = 1*$_REQUEST['rm73'];
$r74 = 1*$_REQUEST['r74']; $rm74 = 1*$_REQUEST['rm74'];
$r75 = 1*$_REQUEST['r75']; $rm75 = 1*$_REQUEST['rm75'];
$r76 = 1*$_REQUEST['r76']; $rm76 = 1*$_REQUEST['rm76'];
$r77 = 1*$_REQUEST['r77']; $rm77 = 1*$_REQUEST['rm77'];
$r78 = 1*$_REQUEST['r78']; $rm78 = 1*$_REQUEST['rm78'];
$r79 = 1*$_REQUEST['r79']; $rm79 = 1*$_REQUEST['rm79'];
$r80 = 1*$_REQUEST['r80']; $rm80 = 1*$_REQUEST['rm80'];
$r81 = 1*$_REQUEST['r81']; $rm81 = 1*$_REQUEST['rm81'];
$r82 = 1*$_REQUEST['r82']; $rm82 = 1*$_REQUEST['rm82'];
$r83 = 1*$_REQUEST['r83']; $rm83 = 1*$_REQUEST['rm83'];
$r84 = 1*$_REQUEST['r84']; $rm84 = 1*$_REQUEST['rm84'];
$r85 = 1*$_REQUEST['r85']; $rm85 = 1*$_REQUEST['rm85'];
$r86 = 1*$_REQUEST['r86']; $rm86 = 1*$_REQUEST['rm86'];
$r87 = 1*$_REQUEST['r87']; $rm87 = 1*$_REQUEST['rm87'];
$r88 = 1*$_REQUEST['r88']; $rm88 = 1*$_REQUEST['rm88'];
$r89 = 1*$_REQUEST['r89']; $rm89 = 1*$_REQUEST['rm89'];
$r90 = 1*$_REQUEST['r90']; $rm90 = 1*$_REQUEST['rm90'];
$r91 = 1*$_REQUEST['r91']; $rm91 = 1*$_REQUEST['rm91'];
$r92 = 1*$_REQUEST['r92']; $rm92 = 1*$_REQUEST['rm92'];
$r93 = 1*$_REQUEST['r93']; $rm93 = 1*$_REQUEST['rm93'];
$r94 = 1*$_REQUEST['r94']; $rm94 = 1*$_REQUEST['rm94'];
$r95 = 1*$_REQUEST['r95']; $rm95 = 1*$_REQUEST['rm95'];
$r96 = 1*$_REQUEST['r96']; $rm96 = 1*$_REQUEST['rm96'];
$r97 = 1*$_REQUEST['r97']; $rm97 = 1*$_REQUEST['rm97'];
$r98 = 1*$_REQUEST['r98']; $rm98 = 1*$_REQUEST['rm98'];
$r99 = 1*$_REQUEST['r99']; $rm99 = 1*$_REQUEST['rm99'];
$r100 = 1*$_REQUEST['r100']; $rm100 = 1*$_REQUEST['rm100'];
$r101 = 1*$_REQUEST['r101']; $rm101 = 1*$_REQUEST['rm101'];
$r102 = 1*$_REQUEST['r102']; $rm102 = 1*$_REQUEST['rm102'];
$r103 = 1*$_REQUEST['r103']; $rm103 = 1*$_REQUEST['rm103'];
$r104 = 1*$_REQUEST['r104']; $rm104 = 1*$_REQUEST['rm104'];
$r105 = 1*$_REQUEST['r105']; $rm105 = 1*$_REQUEST['rm105'];
$r106 = 1*$_REQUEST['r106']; $rm106 = 1*$_REQUEST['rm106'];
$r107 = 1*$_REQUEST['r107']; $rm107 = 1*$_REQUEST['rm107'];
$r108 = 1*$_REQUEST['r108']; $rm108 = 1*$_REQUEST['rm108'];
$r109 = 1*$_REQUEST['r109']; $rm109 = 1*$_REQUEST['rm109'];
$r110 = 1*$_REQUEST['r110']; $rm110 = 1*$_REQUEST['rm110'];
$r111 = 1*$_REQUEST['r111']; $rm111 = 1*$_REQUEST['rm111'];
$r112 = 1*$_REQUEST['r112']; $rm112 = 1*$_REQUEST['rm112'];
$r113 = 1*$_REQUEST['r113']; $rm113 = 1*$_REQUEST['rm113'];

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r69='$r69', rm69='$rm69',
  r70='$r70', rm70='$rm70', r70='$r70', rm70='$rm70',
  r71='$r71', rm71='$rm71', r72='$r72', rm72='$rm72',
  r73='$r73', rm73='$rm73', r74='$r74', rm74='$rm74',
  r75='$r75', rm75='$rm75', r76='$r76', rm76='$rm76',
  r77='$r77', rm77='$rm77', r78='$r78', rm78='$rm78',
  r79='$r79', rm79='$rm79',
  r80='$r80', rm80='$rm80', r80='$r80', rm80='$rm80',
  r81='$r81', rm81='$rm81', r82='$r82', rm82='$rm82',
  r83='$r83', rm83='$rm83', r84='$r84', rm84='$rm84',
  r85='$r85', rm85='$rm85', r86='$r86', rm86='$rm86',
  r87='$r87', rm87='$rm87', r88='$r88', rm88='$rm88',
  r89='$r89', rm89='$rm89',
  r90='$r90', rm90='$rm90', r90='$r90', rm90='$rm90',
  r91='$r91', rm91='$rm91', r92='$r92', rm92='$rm92',
  r93='$r93', rm93='$rm93', r94='$r94', rm94='$rm94',
  r95='$r95', rm95='$rm95', r96='$r96', rm96='$rm96',
  r97='$r97', rm97='$rm97', r98='$r98', rm98='$rm98',
  r99='$r99', rm99='$rm99',
  r100='$r100', rm100='$rm100', r100='$r100', rm100='$rm100',
  r101='$r101', rm101='$rm101', r102='$r102', rm102='$rm102',
  r103='$r103', rm103='$rm103', r104='$r104', rm104='$rm104',
  r105='$r105', rm105='$rm105', r106='$r106', rm106='$rm106',
  r107='$r107', rm107='$rm107', r108='$r108', rm108='$rm108',
  r109='$r109', rm109='$rm109',
  r110='$r110', rm110='$rm110', r110='$r110', rm110='$rm110',
  r111='$r111', rm111='$rm111', r112='$r112', rm112='$rm112',
  r113='$r113', rm113='$rm113' ".
" WHERE oc = $cislo_oc";
                    }

if ( $strana == 5 ) {
$r114 = 1*$_REQUEST['r114']; $rm114 = 1*$_REQUEST['rm114'];
$r115 = 1*$_REQUEST['r115']; $rm115 = 1*$_REQUEST['rm115'];
$r116 = 1*$_REQUEST['r116']; $rm116 = 1*$_REQUEST['rm116'];
$r117 = 1*$_REQUEST['r117']; $rm117 = 1*$_REQUEST['rm117'];
$r118 = 1*$_REQUEST['r118']; $rm118 = 1*$_REQUEST['rm118'];
$r119 = 1*$_REQUEST['r119']; $rm119 = 1*$_REQUEST['rm119'];
$r120 = 1*$_REQUEST['r120']; $rm120 = 1*$_REQUEST['rm120'];
$r121 = 1*$_REQUEST['r121']; $rm121 = 1*$_REQUEST['rm121'];
$r122 = 1*$_REQUEST['r122']; $rm122 = 1*$_REQUEST['rm122'];
$r123 = 1*$_REQUEST['r123']; $rm123 = 1*$_REQUEST['rm123'];
$r124 = 1*$_REQUEST['r124']; $rm124 = 1*$_REQUEST['rm124'];
$r125 = 1*$_REQUEST['r125']; $rm125 = 1*$_REQUEST['rm125'];
$r126 = 1*$_REQUEST['r126']; $rm126 = 1*$_REQUEST['rm126'];
$r127 = 1*$_REQUEST['r127']; $rm127 = 1*$_REQUEST['rm127'];
$r128 = 1*$_REQUEST['r128']; $rm128 = 1*$_REQUEST['rm128'];
$r129 = 1*$_REQUEST['r129']; $rm129 = 1*$_REQUEST['rm129'];
$r130 = 1*$_REQUEST['r130']; $rm130 = 1*$_REQUEST['rm130'];
$r131 = 1*$_REQUEST['r131']; $rm131 = 1*$_REQUEST['rm131'];
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r114='$r114', rm114='$rm114', r115='$r115', rm115='$rm115',
  r116='$r116', rm116='$rm116', r117='$r117', rm117='$rm117',
  r118='$r118', rm118='$rm118', r119='$r119', rm119='$rm119',
  r120='$r120', rm120='$rm120', r120='$r120', rm120='$rm120',
  r121='$r121', rm121='$rm121', r122='$r122', rm122='$rm122',
  r123='$r123', rm123='$rm123', r124='$r124', rm124='$rm124',
  r125='$r125', rm125='$rm125', r126='$r126', rm126='$rm126',
  r127='$r127', rm127='$rm127', r128='$r128', rm128='$rm128',
  r129='$r129', rm129='$rm129',
  r130='$r130', rm130='$rm130', r130='$r130', rm130='$rm130',
  r131='$r131', rm131='$rm131' ".
" WHERE oc = $cislo_oc";
                    }
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$nepoc = 1*$_REQUEST['nepoc'];
$vsetkyprepocty=1;
if( $nepoc == 1 ) $vsetkyprepocty=0;

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov

//prac.subor a subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sql = "SELECT px09 FROM F".$kli_vxcf."_uctvykaz_fin204pod";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin204pod';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin204podd2';
//$vysledok = mysql_query("$sqlt");


$pocdes="10,2";
$sqlt = <<<mzdprc
(
   px09         DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   okres        VARCHAR(11),
   obec         VARCHAR(11),
   daz          DATE,
   kor          INT,
   prx          INT,
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   rdk          INT,
   prv          INT,
   hod          DECIMAL($pocdes),
   mdt          DECIMAL($pocdes),
   dal          DECIMAL($pocdes),
   r01          DECIMAL($pocdes),
   r02          DECIMAL($pocdes),
   r03          DECIMAL($pocdes),
   r04          DECIMAL($pocdes),
   r05          DECIMAL($pocdes),
   r06          DECIMAL($pocdes),
   r07          DECIMAL($pocdes),
   r08          DECIMAL($pocdes),
   r09          DECIMAL($pocdes),
   r10          DECIMAL($pocdes),
   r11          DECIMAL($pocdes),
   r12          DECIMAL($pocdes),
   r13          DECIMAL($pocdes),
   r14          DECIMAL($pocdes),
   r15          DECIMAL($pocdes),
   r16          DECIMAL($pocdes),
   r17          DECIMAL($pocdes),
   r18          DECIMAL($pocdes),
   r19          DECIMAL($pocdes),
   r20          DECIMAL($pocdes),
   r21          DECIMAL($pocdes),
   r22          DECIMAL($pocdes),
   r23          DECIMAL($pocdes),
   r24          DECIMAL($pocdes),
   r25          DECIMAL($pocdes),
   r26          DECIMAL($pocdes),
   r27          DECIMAL($pocdes),
   r28          DECIMAL($pocdes),
   r29          DECIMAL($pocdes),
   r30          DECIMAL($pocdes),
   r31          DECIMAL($pocdes),
   r32          DECIMAL($pocdes),
   r33          DECIMAL($pocdes),
   r34          DECIMAL($pocdes),
   r35          DECIMAL($pocdes),
   r36          DECIMAL($pocdes),
   r37          DECIMAL($pocdes),
   r38          DECIMAL($pocdes),
   r39          DECIMAL($pocdes),
   r40          DECIMAL($pocdes),
   r41          DECIMAL($pocdes),
   r42          DECIMAL($pocdes),
   r43          DECIMAL($pocdes),
   r44          DECIMAL($pocdes),
   r45          DECIMAL($pocdes),
   r46          DECIMAL($pocdes),
   r47          DECIMAL($pocdes),
   r48          DECIMAL($pocdes),
   r49          DECIMAL($pocdes),
   r50          DECIMAL($pocdes),
   r51          DECIMAL($pocdes),
   r52          DECIMAL($pocdes),
   r53          DECIMAL($pocdes),
   r54          DECIMAL($pocdes),
   r55          DECIMAL($pocdes),
   r56          DECIMAL($pocdes),
   r57          DECIMAL($pocdes),
   r58          DECIMAL($pocdes),
   r59          DECIMAL($pocdes),
   r60          DECIMAL($pocdes),
   r61          DECIMAL($pocdes),
   r62          DECIMAL($pocdes),
   r63          DECIMAL($pocdes),
   r64          DECIMAL($pocdes),
   r65          DECIMAL($pocdes),
   r66          DECIMAL($pocdes),
   r67          DECIMAL($pocdes),
   r68          DECIMAL($pocdes),
   r69          DECIMAL($pocdes),
   r70          DECIMAL($pocdes),
   r71          DECIMAL($pocdes),
   r72          DECIMAL($pocdes),
   r73          DECIMAL($pocdes),
   r74          DECIMAL($pocdes),
   r75          DECIMAL($pocdes),
   r76          DECIMAL($pocdes),
   r77          DECIMAL($pocdes),
   r78          DECIMAL($pocdes),
   r79          DECIMAL($pocdes),
   r80          DECIMAL($pocdes),
   r81          DECIMAL($pocdes),
   r82          DECIMAL($pocdes),
   r83          DECIMAL($pocdes),
   r84          DECIMAL($pocdes),
   r85          DECIMAL($pocdes),
   r86          DECIMAL($pocdes),
   r87          DECIMAL($pocdes),
   r88          DECIMAL($pocdes),
   r89          DECIMAL($pocdes),
   r90          DECIMAL($pocdes),
   r91          DECIMAL($pocdes),
   r92          DECIMAL($pocdes),
   r93          DECIMAL($pocdes),
   r94          DECIMAL($pocdes),
   r95          DECIMAL($pocdes),
   r96          DECIMAL($pocdes),
   r97          DECIMAL($pocdes),
   r98          DECIMAL($pocdes),
   r99          DECIMAL($pocdes),
   r100         DECIMAL($pocdes),
   r101         DECIMAL($pocdes),
   r102         DECIMAL($pocdes),
   r103         DECIMAL($pocdes),
   r104         DECIMAL($pocdes),
   r105         DECIMAL($pocdes),
   r106         DECIMAL($pocdes),
   r107         DECIMAL($pocdes),
   r108         DECIMAL($pocdes),
   r109         DECIMAL($pocdes),
   r110         DECIMAL($pocdes),
   r111         DECIMAL($pocdes),
   r112         DECIMAL($pocdes),
   r113         DECIMAL($pocdes),
   r114         DECIMAL($pocdes),
   r115         DECIMAL($pocdes),
   r116         DECIMAL($pocdes),
   r117         DECIMAL($pocdes),
   r118         DECIMAL($pocdes),
   r119          DECIMAL($pocdes),
   r120          DECIMAL($pocdes),
   r121          DECIMAL($pocdes),
   r122          DECIMAL($pocdes),
   r123          DECIMAL($pocdes),
   r124          DECIMAL($pocdes),
   r125          DECIMAL($pocdes),
   r126          DECIMAL($pocdes),
   r127          DECIMAL($pocdes),
   r128          DECIMAL($pocdes),
   r129          DECIMAL($pocdes),
   r130          DECIMAL($pocdes),
   r131          DECIMAL($pocdes),

   rk01          DECIMAL($pocdes),
   rk02          DECIMAL($pocdes),
   rk03          DECIMAL($pocdes),
   rk04          DECIMAL($pocdes),
   rk05          DECIMAL($pocdes),
   rk06          DECIMAL($pocdes),
   rk07          DECIMAL($pocdes),
   rk08          DECIMAL($pocdes),
   rk09          DECIMAL($pocdes),
   rk10          DECIMAL($pocdes),
   rk11          DECIMAL($pocdes),
   rk12          DECIMAL($pocdes),
   rk13          DECIMAL($pocdes),
   rk14          DECIMAL($pocdes),
   rk15          DECIMAL($pocdes),
   rk16          DECIMAL($pocdes),
   rk17          DECIMAL($pocdes),
   rk18          DECIMAL($pocdes),
   rk19          DECIMAL($pocdes),
   rk20          DECIMAL($pocdes),
   rk21          DECIMAL($pocdes),
   rk22          DECIMAL($pocdes),
   rk23          DECIMAL($pocdes),
   rk24          DECIMAL($pocdes),
   rk25          DECIMAL($pocdes),
   rk26          DECIMAL($pocdes),
   rk27          DECIMAL($pocdes),
   rk28          DECIMAL($pocdes),
   rk29          DECIMAL($pocdes),
   rk30          DECIMAL($pocdes),
   rk31          DECIMAL($pocdes),
   rk32          DECIMAL($pocdes),
   rk33          DECIMAL($pocdes),
   rk34          DECIMAL($pocdes),
   rk35          DECIMAL($pocdes),
   rk36          DECIMAL($pocdes),
   rk37          DECIMAL($pocdes),
   rk38          DECIMAL($pocdes),
   rk39          DECIMAL($pocdes),
   rk40          DECIMAL($pocdes),
   rk41          DECIMAL($pocdes),
   rk42          DECIMAL($pocdes),
   rk43          DECIMAL($pocdes),
   rk44          DECIMAL($pocdes),
   rk45          DECIMAL($pocdes),
   rk46          DECIMAL($pocdes),
   rk47          DECIMAL($pocdes),
   rk48          DECIMAL($pocdes),
   rk49          DECIMAL($pocdes),
   rk50          DECIMAL($pocdes),
   rk51          DECIMAL($pocdes),
   rk52          DECIMAL($pocdes),
   rk53          DECIMAL($pocdes),
   rk54          DECIMAL($pocdes),
   rk55          DECIMAL($pocdes),
   rk56          DECIMAL($pocdes),
   rk57          DECIMAL($pocdes),
   rk58          DECIMAL($pocdes),
   rk59          DECIMAL($pocdes),
   rk60          DECIMAL($pocdes),
   rk61          DECIMAL($pocdes),
   rk62          DECIMAL($pocdes),
   rk63          DECIMAL($pocdes),
   rk64          DECIMAL($pocdes),
   rk65          DECIMAL($pocdes),
   rk66          DECIMAL($pocdes),
   rk67          DECIMAL($pocdes),
   rk68          DECIMAL($pocdes),
   rk69          DECIMAL($pocdes),

   rn01          DECIMAL($pocdes),
   rn02          DECIMAL($pocdes),
   rn03          DECIMAL($pocdes),
   rn04          DECIMAL($pocdes),
   rn05          DECIMAL($pocdes),
   rn06          DECIMAL($pocdes),
   rn07          DECIMAL($pocdes),
   rn08          DECIMAL($pocdes),
   rn09          DECIMAL($pocdes),
   rn10          DECIMAL($pocdes),
   rn11          DECIMAL($pocdes),
   rn12          DECIMAL($pocdes),
   rn13          DECIMAL($pocdes),
   rn14          DECIMAL($pocdes),
   rn15          DECIMAL($pocdes),
   rn16          DECIMAL($pocdes),
   rn17          DECIMAL($pocdes),
   rn18          DECIMAL($pocdes),
   rn19          DECIMAL($pocdes),
   rn20          DECIMAL($pocdes),
   rn21          DECIMAL($pocdes),
   rn22          DECIMAL($pocdes),
   rn23          DECIMAL($pocdes),
   rn24          DECIMAL($pocdes),
   rn25          DECIMAL($pocdes),
   rn26          DECIMAL($pocdes),
   rn27          DECIMAL($pocdes),
   rn28          DECIMAL($pocdes),
   rn29          DECIMAL($pocdes),
   rn30          DECIMAL($pocdes),
   rn31          DECIMAL($pocdes),
   rn32          DECIMAL($pocdes),
   rn33          DECIMAL($pocdes),
   rn34          DECIMAL($pocdes),
   rn35          DECIMAL($pocdes),
   rn36          DECIMAL($pocdes),
   rn37          DECIMAL($pocdes),
   rn38          DECIMAL($pocdes),
   rn39          DECIMAL($pocdes),
   rn40          DECIMAL($pocdes),
   rn41          DECIMAL($pocdes),
   rn42          DECIMAL($pocdes),
   rn43          DECIMAL($pocdes),
   rn44          DECIMAL($pocdes),
   rn45          DECIMAL($pocdes),
   rn46          DECIMAL($pocdes),
   rn47          DECIMAL($pocdes),
   rn48          DECIMAL($pocdes),
   rn49          DECIMAL($pocdes),
   rn50          DECIMAL($pocdes),
   rn51          DECIMAL($pocdes),
   rn52          DECIMAL($pocdes),
   rn53          DECIMAL($pocdes),
   rn54          DECIMAL($pocdes),
   rn55          DECIMAL($pocdes),
   rn56          DECIMAL($pocdes),
   rn57          DECIMAL($pocdes),
   rn58          DECIMAL($pocdes),
   rn59          DECIMAL($pocdes),
   rn60          DECIMAL($pocdes),
   rn61          DECIMAL($pocdes),
   rn62          DECIMAL($pocdes),
   rn63          DECIMAL($pocdes),
   rn64          DECIMAL($pocdes),
   rn65          DECIMAL($pocdes),
   rn66          DECIMAL($pocdes),
   rn67          DECIMAL($pocdes),
   rn68          DECIMAL($pocdes),
   rn69          DECIMAL($pocdes),

   rm01          DECIMAL($pocdes),
   rm02          DECIMAL($pocdes),
   rm03          DECIMAL($pocdes),
   rm04          DECIMAL($pocdes),
   rm05          DECIMAL($pocdes),
   rm06          DECIMAL($pocdes),
   rm07          DECIMAL($pocdes),
   rm08          DECIMAL($pocdes),
   rm09          DECIMAL($pocdes),
   rm10          DECIMAL($pocdes),
   rm11          DECIMAL($pocdes),
   rm12          DECIMAL($pocdes),
   rm13          DECIMAL($pocdes),
   rm14          DECIMAL($pocdes),
   rm15          DECIMAL($pocdes),
   rm16          DECIMAL($pocdes),
   rm17          DECIMAL($pocdes),
   rm18          DECIMAL($pocdes),
   rm19          DECIMAL($pocdes),
   rm20          DECIMAL($pocdes),
   rm21          DECIMAL($pocdes),
   rm22          DECIMAL($pocdes),
   rm23          DECIMAL($pocdes),
   rm24          DECIMAL($pocdes),
   rm25          DECIMAL($pocdes),
   rm26          DECIMAL($pocdes),
   rm27          DECIMAL($pocdes),
   rm28          DECIMAL($pocdes),
   rm29          DECIMAL($pocdes),
   rm30          DECIMAL($pocdes),
   rm31          DECIMAL($pocdes),
   rm32          DECIMAL($pocdes),
   rm33          DECIMAL($pocdes),
   rm34          DECIMAL($pocdes),
   rm35          DECIMAL($pocdes),
   rm36          DECIMAL($pocdes),
   rm37          DECIMAL($pocdes),
   rm38          DECIMAL($pocdes),
   rm39          DECIMAL($pocdes),
   rm40          DECIMAL($pocdes),
   rm41          DECIMAL($pocdes),
   rm42          DECIMAL($pocdes),
   rm43          DECIMAL($pocdes),
   rm44          DECIMAL($pocdes),
   rm45          DECIMAL($pocdes),
   rm46          DECIMAL($pocdes),
   rm47          DECIMAL($pocdes),
   rm48          DECIMAL($pocdes),
   rm49          DECIMAL($pocdes),
   rm50          DECIMAL($pocdes),
   rm51          DECIMAL($pocdes),
   rm52          DECIMAL($pocdes),
   rm53          DECIMAL($pocdes),
   rm54          DECIMAL($pocdes),
   rm55          DECIMAL($pocdes),
   rm56          DECIMAL($pocdes),
   rm57          DECIMAL($pocdes),
   rm58          DECIMAL($pocdes),
   rm59          DECIMAL($pocdes),
   rm60          DECIMAL($pocdes),
   rm61          DECIMAL($pocdes),
   rm62          DECIMAL($pocdes),
   rm63          DECIMAL($pocdes),
   rm64          DECIMAL($pocdes),
   rm65          DECIMAL($pocdes),
   rm66          DECIMAL($pocdes),
   rm67          DECIMAL($pocdes),
   rm68          DECIMAL($pocdes),
   rm69          DECIMAL($pocdes),
   rm70          DECIMAL($pocdes),
   rm71          DECIMAL($pocdes),
   rm72          DECIMAL($pocdes),
   rm73          DECIMAL($pocdes),
   rm74          DECIMAL($pocdes),
   rm75          DECIMAL($pocdes),
   rm76          DECIMAL($pocdes),
   rm77          DECIMAL($pocdes),
   rm78          DECIMAL($pocdes),
   rm79          DECIMAL($pocdes),
   rm80          DECIMAL($pocdes),
   rm81          DECIMAL($pocdes),
   rm82          DECIMAL($pocdes),
   rm83          DECIMAL($pocdes),
   rm84          DECIMAL($pocdes),
   rm85          DECIMAL($pocdes),
   rm86          DECIMAL($pocdes),
   rm87          DECIMAL($pocdes),
   rm88          DECIMAL($pocdes),
   rm89          DECIMAL($pocdes),
   rm90          DECIMAL($pocdes),
   rm91          DECIMAL($pocdes),
   rm92          DECIMAL($pocdes),
   rm93          DECIMAL($pocdes),
   rm94          DECIMAL($pocdes),
   rm95          DECIMAL($pocdes),
   rm96          DECIMAL($pocdes),
   rm97          DECIMAL($pocdes),
   rm98          DECIMAL($pocdes),
   rm99          DECIMAL($pocdes),
   rm100          DECIMAL($pocdes),
   rm101          DECIMAL($pocdes),
   rm102          DECIMAL($pocdes),
   rm103          DECIMAL($pocdes),
   rm104          DECIMAL($pocdes),
   rm105          DECIMAL($pocdes),
   rm106          DECIMAL($pocdes),
   rm107          DECIMAL($pocdes),
   rm108          DECIMAL($pocdes),
   rm109          DECIMAL($pocdes),
   rm110          DECIMAL($pocdes),
   rm111          DECIMAL($pocdes),
   rm112          DECIMAL($pocdes),
   rm113          DECIMAL($pocdes),
   rm114          DECIMAL($pocdes),
   rm115          DECIMAL($pocdes),
   rm116          DECIMAL($pocdes),
   rm117          DECIMAL($pocdes),
   rm118          DECIMAL($pocdes),
   rm119          DECIMAL($pocdes),
   rm120          DECIMAL($pocdes),
   rm121          DECIMAL($pocdes),
   rm122          DECIMAL($pocdes),
   rm123          DECIMAL($pocdes),
   rm124          DECIMAL($pocdes),
   rm125          DECIMAL($pocdes),
   rm126          DECIMAL($pocdes),
   rm127          DECIMAL($pocdes),
   rm128          DECIMAL($pocdes),
   rm129          DECIMAL($pocdes),
   rm130          DECIMAL($pocdes),
   rm131          DECIMAL($pocdes),
   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin204pod'.$sqlt;
$vytvor = mysql_query("$vsql");
}


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
//exit;


$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if ( $jepotvrd == 0 ) $subor=1;


$nacitavamhodnoty=0;
//vytvor pracovny subor
if ( $subor == 1 )
{

//zober data z kun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  }

$ttvv = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid ".
" ( oc   ) VALUES ".
" ( '$cislo_oc' )";
//$ttqq = mysql_query("$ttvv");

/////////////////////////////////nacitaj hodnoty z ucta do suboru
$nacitavamhodnoty=1;


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" pmd,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$kli_vmcf=$fir_allx11;
$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$psys=1;
while ($psys <= 9 )
  {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
"0,0,ucm,ucm,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" ".$databaza."F$kli_vmcf"."_$uctovanie.hod,$cislo_oc,0,'','','0000-00-00',".
"0,0,ucm,ucm,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM ".$databaza."F$kli_vmcf"."_$uctovanie,".$databaza."F$kli_vmcf"."_$doklad".
" WHERE ".$databaza."F$kli_vmcf"."_$uctovanie.dok=".$databaza."F$kli_vmcf"."_$doklad.dok AND ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 6 ) ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -(".$databaza."F$kli_vmcf"."_$uctovanie.hod),$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM ".$databaza."F$kli_vmcf"."_$uctovanie,".$databaza."F$kli_vmcf"."_$doklad".
" WHERE ".$databaza."F$kli_vmcf"."_$uctovanie.dok=".$databaza."F$kli_vmcf"."_$doklad.dok AND ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 6 ) ";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" SUM(hod),$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucm,ucm,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM ".$databaza."F$kli_vmcf"."_$uctovanie".
" WHERE ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 6 ) GROUP BY ".$databaza."F$kli_vmcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -SUM(hod),$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".

"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM ".$databaza."F$kli_vmcf"."_$uctovanie".
" WHERE ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 6 ) GROUP BY ".$databaza."F$kli_vmcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin204pod".
" SET rdk=F$kli_vxcf"."_genfin204pod.crs".
" WHERE LEFT(F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_genfin204pod.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid,F$kli_vxcf"."_genfin204pod".
" SET rdk=F$kli_vxcf"."_genfin204pod.crs".
" WHERE F$kli_vxcf"."_uctprcvykaz$kli_uzid.uce = F$kli_vxcf"."_genfin204pod.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;


//korekcia
$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" SET kor=1".
" WHERE LEFT(uce,3) = 071 OR LEFT(uce,3) = 072 OR LEFT(uce,3) = 073 OR LEFT(uce,3) = 074 OR LEFT(uce,3) = 075 OR LEFT(uce,3) = 076 OR LEFT(uce,3) = 079 ".
" OR LEFT(uce,3) = 081 OR LEFT(uce,3) = 082 OR LEFT(uce,3) = 083 OR LEFT(uce,3) = 084 OR LEFT(uce,3) = 085 OR LEFT(uce,3) = 086 ".
" OR LEFT(uce,3) = 088 OR LEFT(uce,3) = 089 ".
" OR LEFT(uce,3) = 091 OR LEFT(uce,3) = 092 OR LEFT(uce,3) = 093 OR LEFT(uce,3) = 094 OR LEFT(uce,3) = 095 OR LEFT(uce,3) = 096 OR LEFT(uce,3) = 098 ".
" OR LEFT(uce,3) = 191 OR LEFT(uce,3) = 192 OR LEFT(uce,3) = 193 OR LEFT(uce,3) = 194 OR LEFT(uce,3) = 195 OR LEFT(uce,3) = 196 ".
" OR LEFT(uce,3) = 197 OR LEFT(uce,3) = 198 OR LEFT(uce,3) = 199 ".
" OR LEFT(uce,3) = 291 OR LEFT(uce,3) = 391 ".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//HV
$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rdk=75 WHERE LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 ";
$oznac = mysql_query("$sqtoz");



//vypis negenerovane pohyby
$vsql = "DROP TABLE F".$kli_vxcf."_prcfinneg".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$vsql = "CREATE TABLE F".$kli_vxcf."_prcfinneg".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid WHERE rdk = 0 ";
$vytvor = mysql_query("$vsql");

$vsql = "DELETE FROM F".$kli_vxcf."_prcfinneg".$kli_uzid." WHERE LEFT(uce,1) = 7 ";
$vytvor = mysql_query("$vsql");
$vsql = "DELETE FROM F".$kli_vxcf."_prcfinneg".$kli_uzid." WHERE LEFT(uce,1) = 8 ";
$vytvor = mysql_query("$vsql");
$vsql = "DELETE FROM F".$kli_vxcf."_prcfinneg".$kli_uzid." WHERE LEFT(uce,1) = 9 ";
$vytvor = mysql_query("$vsql");


//generovane sumarne riadky
$vsql = "INSERT INTO F".$kli_vxcf."_prcfinneg".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid ".
" WHERE ( rdk = 1 OR rdk = 8 OR rdk = 19 OR rdk = 27 OR rdk = 35 OR rdk = 52 OR ".
" rdk = 61 OR rdk = 68 OR rdk = 69 OR rdk = 77 OR rdk = 85 OR rdk = 98 OR rdk = 102 OR rdk = 122 OR rdk = 126 OR rdk = 131 ) ";
$vytvor = mysql_query("$vsql");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcfinneg$kli_uzid WHERE rdk >= 0 GROUP BY uce ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

if( $pol > 0 )
          {

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $hlavicka->rdk == 0 ) { echo "Negenerovaný úèet ".$hlavicka->uce." / èíslo riadku ".$hlavicka->rdk."<br />"; }
if( $hlavicka->rdk != 0 ) { echo "Pravdepodobne generovanie v sumárnom riadku, úèet ".$hlavicka->uce." / èíslo riadku ".$hlavicka->rdk."<br />"; }

}
$i = $i + 1;

  }

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcfinneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");
exit;
          }
//koniec vypis negenerovane pohyby



//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 131 )
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk > 68 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 69 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rk$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rn$crdk=r$crdk-rk$crdk WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

                }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=px09 WHERE rdk = $rdk ";
if( $rdk > 68 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=-px09 WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

$rdk=$rdk+1;
  }



//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid "." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(r39),SUM(r40),".
"SUM(r41),SUM(r42),SUM(r43),SUM(r44),SUM(r45),SUM(r46),SUM(r47),SUM(r48),SUM(r49),SUM(r50),".
"SUM(r51),SUM(r52),SUM(r53),SUM(r54),SUM(r55),SUM(r56),SUM(r57),SUM(r58),SUM(r59),SUM(r60),".
"SUM(r61),SUM(r62),SUM(r63),SUM(r64),SUM(r65),SUM(r66),SUM(r67),SUM(r68),SUM(r69),SUM(r70),".
"SUM(r71),SUM(r72),SUM(r73),SUM(r74),SUM(r75),SUM(r76),SUM(r77),SUM(r78),SUM(r79),SUM(r80),".
"SUM(r81),SUM(r82),SUM(r83),SUM(r84),SUM(r85),SUM(r86),SUM(r87),SUM(r88),SUM(r89),SUM(r90),".
"SUM(r91),SUM(r92),SUM(r93),SUM(r94),SUM(r95),SUM(r96),SUM(r97),SUM(r98),SUM(r99),SUM(r100),".
"SUM(r101),SUM(r102),SUM(r103),SUM(r104),SUM(r105),SUM(r106),SUM(r107),SUM(r108),SUM(r109),SUM(r110),".
"SUM(r111),SUM(r112),SUM(r113),SUM(r114),SUM(r115),SUM(r116),SUM(r117),SUM(r118),SUM(r119),SUM(r120),".
"SUM(r121),SUM(r122),SUM(r123),SUM(r124),SUM(r125),SUM(r126),SUM(r127),SUM(r128),SUM(r129),SUM(r130),SUM(r131),".

"SUM(rk01),SUM(rk02),SUM(rk03),SUM(rk04),SUM(rk05),SUM(rk06),SUM(rk07),SUM(rk08),SUM(rk09),SUM(rk10),".
"SUM(rk11),SUM(rk12),SUM(rk13),SUM(rk14),SUM(rk15),SUM(rk16),SUM(rk17),SUM(rk18),SUM(rk19),SUM(rk20),".
"SUM(rk21),SUM(rk22),SUM(rk23),SUM(rk24),SUM(rk25),SUM(rk26),SUM(rk27),SUM(rk28),SUM(rk29),SUM(rk30),".
"SUM(rk31),SUM(rk32),SUM(rk33),SUM(rk34),SUM(rk35),SUM(rk36),SUM(rk37),SUM(rk38),SUM(rk39),SUM(rk40),".
"SUM(rk41),SUM(rk42),SUM(rk43),SUM(rk44),SUM(rk45),SUM(rk46),SUM(rk47),SUM(rk48),SUM(rk49),SUM(rk50),".
"SUM(rk51),SUM(rk52),SUM(rk53),SUM(rk54),SUM(rk55),SUM(rk56),SUM(rk57),SUM(rk58),SUM(rk59),SUM(rk60),".
"SUM(rk61),SUM(rk62),SUM(rk63),SUM(rk64),SUM(rk65),SUM(rk66),SUM(rk67),SUM(rk68),SUM(rk69),".

"SUM(rn01),SUM(rn02),SUM(rn03),SUM(rn04),SUM(rn05),SUM(rn06),SUM(rn07),SUM(rn08),SUM(rn09),SUM(rn10),".
"SUM(rn11),SUM(rn12),SUM(rn13),SUM(rn14),SUM(rn15),SUM(rn16),SUM(rn17),SUM(rn18),SUM(rn19),SUM(rn20),".
"SUM(rn21),SUM(rn22),SUM(rn23),SUM(rn24),SUM(rn25),SUM(rn26),SUM(rn27),SUM(rn28),SUM(rn29),SUM(rn30),".
"SUM(rn31),SUM(rn32),SUM(rn33),SUM(rn34),SUM(rn35),SUM(rn36),SUM(rn37),SUM(rn38),SUM(rn39),SUM(rn40),".
"SUM(rn41),SUM(rn42),SUM(rn43),SUM(rn44),SUM(rn45),SUM(rn46),SUM(rn47),SUM(rn48),SUM(rn49),SUM(rn50),".
"SUM(rn51),SUM(rn52),SUM(rn53),SUM(rn54),SUM(rn55),SUM(rn56),SUM(rn57),SUM(rn58),SUM(rn59),SUM(rn60),".
"SUM(rn61),SUM(rn62),SUM(rn63),SUM(rn64),SUM(rn65),SUM(rn66),SUM(rn67),SUM(rn68),SUM(rn69),".

"SUM(rm01),SUM(rm02),SUM(rm03),SUM(rm04),SUM(rm05),SUM(rm06),SUM(rm07),SUM(rm08),SUM(rm09),SUM(rm10),".
"SUM(rm11),SUM(rm12),SUM(rm13),SUM(rm14),SUM(rm15),SUM(rm16),SUM(rm17),SUM(rm18),SUM(rm19),SUM(rm20),".
"SUM(rm21),SUM(rm22),SUM(rm23),SUM(rm24),SUM(rm25),SUM(rm26),SUM(rm27),SUM(rm28),SUM(rm29),SUM(rm30),".
"SUM(rm31),SUM(rm32),SUM(rm33),SUM(rm34),SUM(rm35),SUM(rm36),SUM(rm37),SUM(rm38),SUM(rm39),SUM(rm40),".
"SUM(rm41),SUM(rm42),SUM(rm43),SUM(rm44),SUM(rm45),SUM(rm46),SUM(rm47),SUM(rm48),SUM(rm49),SUM(rm50),".
"SUM(rm51),SUM(rm52),SUM(rm53),SUM(rm54),SUM(rm55),SUM(rm56),SUM(rm57),SUM(rm58),SUM(rm59),SUM(rm60),".
"SUM(rm61),SUM(rm62),SUM(rm63),SUM(rm64),SUM(rm65),SUM(rm66),SUM(rm67),SUM(rm68),SUM(rm69),SUM(rm70),".
"SUM(rm71),SUM(rm72),SUM(rm73),SUM(rm74),SUM(rm75),SUM(rm76),SUM(rm77),SUM(rm78),SUM(rm79),SUM(rm80),".
"SUM(rm81),SUM(rm82),SUM(rm83),SUM(rm84),SUM(rm85),SUM(rm86),SUM(rm87),SUM(rm88),SUM(rm89),SUM(rm90),".
"SUM(rm91),SUM(rm92),SUM(rm93),SUM(rm94),SUM(rm95),SUM(rm96),SUM(rm97),SUM(rm98),SUM(rm99),SUM(rm100),".
"SUM(rm101),SUM(rm102),SUM(rm103),SUM(rm104),SUM(rm105),SUM(rm106),SUM(rm107),SUM(rm108),SUM(rm109),SUM(rm110),".
"SUM(rm111),SUM(rm112),SUM(rm113),SUM(rm114),SUM(rm115),SUM(rm116),SUM(rm117),SUM(rm118),SUM(rm119),SUM(rm120),".
"SUM(rm121),SUM(rm122),SUM(rm123),SUM(rm124),SUM(rm125),SUM(rm126),SUM(rm127),SUM(rm128),SUM(rm129),SUM(rm130),SUM(rm131),".
"$fir_fico".
" FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

/////////////////////////////////koniec naCITAJ HODNOTY

//uloz
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin204pod".
" SELECT * FROM F$kli_vxcf"."_uctprcvykaz".$kli_uzid." WHERE oc = $cislo_oc AND prx = 1 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;


}
//koniec pracovneho suboru pre rocne

//vypocty
if( $copern == 10 OR $copern == 20 )
{

//vypocitaj riadky aktiva
$vsldat="uctprcvykaz";
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r01=r02+r03+r04+r05+r06+r07, ".
"r08=r09+r10+r11+r12+r13+r14+r15+r16+r17+r18, ".
"r19=r20+r21+r22+r23+r24+r25, ".
"r27=r28+r29+r30+r31+r32+r33+r34, ".

"rk01=rk02+rk03+rk04+rk05+rk06+rk07, ".
"rk08=rk09+rk10+rk11+rk12+rk13+rk14+rk15+rk16+rk17+rk18, ".
"rk19=rk20+rk21+rk22+rk23+rk24+rk25, ".
"rk27=rk28+rk29+rk30+rk31+rk32+rk33+rk34, ".

"rn01=rn02+rn03+rn04+rn05+rn06+rn07, ".
"rn08=rn09+rn10+rn11+rn12+rn13+rn14+rn15+rn16+rn17+rn18, ".
"rn19=rn20+rn21+rn22+rn23+rn24+rn25, ".
"rn27=rn28+rn29+rn30+rn31+rn32+rn33+rn34, ".


"rm01=rm02+rm03+rm04+rm05+rm06+rm07, ".
"rm08=rm09+rm10+rm11+rm12+rm13+rm14+rm15+rm16+rm17+rm18, ".
"rm19=rm20+rm21+rm22+rm23+rm24+rm25, ".
"rm27=rm28+rm29+rm30+rm31+rm32+rm33+rm34 ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r35=r36+r37+r38+r39+r40+r41+r42+r43+r44+r45+r46+r47+r48+r49+r50+r51, ".
"r52=r53+r54+r55+r56+r57+r58+r59+r60, ".
"r61=r62+r63, ".

"rk35=rk36+rk37+rk38+rk39+rk40+rk41+rk42+rk43+rk44+rk45+rk46+rk47+rk48+rk49+rk50+rk51, ".
"rk52=rk53+rk54+rk55+rk56+rk57+rk58+rk59+rk60, ".
"rk61=rk62+rk63, ".

"rn35=rn36+rn37+rn38+rn39+rn40+rn41+rn42+rn43+rn44+rn45+rn46+rn47+rn48+rn49+rn50+rn51, ".
"rn52=rn53+rn54+rn55+rn56+rn57+rn58+rn59+rn60, ".
"rn61=rn62+rn63, ".

"rm35=rm36+rm37+rm38+rm39+rm40+rm41+rm42+rm43+rm44+rm45+rm46+rm47+rm48+rm49+rm50+rm51, ".
"rm52=rm53+rm54+rm55+rm56+rm57+rm58+rm59+rm60, ".
"rm61=rm62+rm63 ".
" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r68=r01+r08+r19+r26+r27+r35+r52+r61+r64+r65+r66+r67, ".

"rk68=rk01+rk08+rk19+rk26+rk27+rk35+rk52+rk61+rk64+rk65+rk66+rk67, ".

"rn68=rn01+rn08+rn19+rn26+rn27+rn35+rn52+rn61+rn64+rn65+rn66+rn67, ".

"rm68=rm01+rm08+rm19+rm26+rm27+rm35+rm52+rm61+rm64+rm65+rm66+rm67 ".
" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vypocitaj riadky pasiva

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r69=r70+r71+r72+r73+r74+r75, ".
"r77=r78+r79+r80+r81+r82+r83+r84, ".
"r85=r86+r87+r88+r89+r90+r91+r92+r93+r94+r95+r96+r97, ".
"r98=r99+r100+r101, ".
"r102=r103+r104+r105+r106+r107+r108+r109+r110+r111+r112+r113+r114+r115+r116+r117+r118+r119+r120+r121, ".
"r122=r123+r124+r125, ".
"r126=r127+r128, ".

"rm69=rm70+rm71+rm72+rm73+rm74+rm75, ".
"rm77=rm78+rm79+rm80+rm81+rm82+rm83+rm84, ".
"rm85=rm86+rm87+rm88+rm89+rm90+rm91+rm92+rm93+rm94+rm95+rm96+rm97, ".
"rm98=rm99+rm100+rm101, ".
"rm102=rm103+rm104+rm105+rm106+rm107+rm108+rm109+rm110+rm111+rm112+rm113+rm114+rm115+rm116+rm117+rm118+rm119+rm120+rm121, ".
"rm122=rm123+rm124+rm125, ".
"rm126=rm127+rm128 ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r131=r69+r76+r77+r85+r98+r102+r122+r126+r129+r130, ".

"rm131=rm69+rm76+rm77+rm85+rm98+rm102+rm122+rm126+rm129+rm130 ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


}
//koniec vypocty


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 OR $strana == 9999 )
{
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);
}

if ( $strana == 2 )
{
$r01 = $fir_riadok->r01;
$rk01 = $fir_riadok->rk01;
$rn01 = $fir_riadok->rn01;
$rm01 = $fir_riadok->rm01;
$r02 = $fir_riadok->r02;
$rk02 = $fir_riadok->rk02;
$rn02 = $fir_riadok->rn02;
$rm02 = $fir_riadok->rm02;
$r03 = $fir_riadok->r03;
$rk03 = $fir_riadok->rk03;
$rn03 = $fir_riadok->rn03;
$rm03 = $fir_riadok->rm03;
$r04 = $fir_riadok->r04;
$rk04 = $fir_riadok->rk04;
$rn04 = $fir_riadok->rn04;
$rm04 = $fir_riadok->rm04;
$r05 = $fir_riadok->r05;
$rk05 = $fir_riadok->rk05;
$rn05 = $fir_riadok->rn05;
$rm05 = $fir_riadok->rm05;
$r06 = $fir_riadok->r06;
$rk06 = $fir_riadok->rk06;
$rn06 = $fir_riadok->rn06;
$rm06 = $fir_riadok->rm06;
$r07 = $fir_riadok->r07;
$rk07 = $fir_riadok->rk07;
$rn07 = $fir_riadok->rn07;
$rm07 = $fir_riadok->rm07;
$r08 = $fir_riadok->r08;
$rk08 = $fir_riadok->rk08;
$rn08 = $fir_riadok->rn08;
$rm08 = $fir_riadok->rm08;
$r09 = $fir_riadok->r09;
$rk09 = $fir_riadok->rk09;
$rn09 = $fir_riadok->rn09;
$rm09 = $fir_riadok->rm09;
$r10 = $fir_riadok->r10;
$rk10 = $fir_riadok->rk10;
$rn10 = $fir_riadok->rn10;
$rm10 = $fir_riadok->rm10;
$r11 = $fir_riadok->r11;
$rk11 = $fir_riadok->rk11;
$rn11 = $fir_riadok->rn11;
$rm11 = $fir_riadok->rm11;
$r12 = $fir_riadok->r12;
$rk12 = $fir_riadok->rk12;
$rn12 = $fir_riadok->rn12;
$rm12 = $fir_riadok->rm12;
$r13 = $fir_riadok->r13;
$rk13 = $fir_riadok->rk13;
$rn13 = $fir_riadok->rn13;
$rm13 = $fir_riadok->rm13;
$r14 = $fir_riadok->r14;
$rk14 = $fir_riadok->rk14;
$rn14 = $fir_riadok->rn14;
$rm14 = $fir_riadok->rm14;
$r15 = $fir_riadok->r15;
$rk15 = $fir_riadok->rk15;
$rn15 = $fir_riadok->rn15;
$rm15 = $fir_riadok->rm15;
$r16 = $fir_riadok->r16;
$rk16 = $fir_riadok->rk16;
$rn16 = $fir_riadok->rn16;
$rm16 = $fir_riadok->rm16;
$r17 = $fir_riadok->r17;
$rk17 = $fir_riadok->rk17;
$rn17 = $fir_riadok->rn17;
$rm17 = $fir_riadok->rm17;
$r18 = $fir_riadok->r18;
$rk18 = $fir_riadok->rk18;
$rn18 = $fir_riadok->rn18;
$rm18 = $fir_riadok->rm18;
$r19 = $fir_riadok->r19;
$rk19 = $fir_riadok->rk19;
$rn19 = $fir_riadok->rn19;
$rm19 = $fir_riadok->rm19;
$r20 = $fir_riadok->r20;
$rk20 = $fir_riadok->rk20;
$rn20 = $fir_riadok->rn20;
$rm20 = $fir_riadok->rm20;
$r21 = $fir_riadok->r21;
$rk21 = $fir_riadok->rk21;
$rn21 = $fir_riadok->rn21;
$rm21 = $fir_riadok->rm21;
$r22 = $fir_riadok->r22;
$rk22 = $fir_riadok->rk22;
$rn22 = $fir_riadok->rn22;
$rm22 = $fir_riadok->rm22;
$r23 = $fir_riadok->r23;
$rk23 = $fir_riadok->rk23;
$rn23 = $fir_riadok->rn23;
$rm23 = $fir_riadok->rm23;
$r24 = $fir_riadok->r24;
$rk24 = $fir_riadok->rk24;
$rn24 = $fir_riadok->rn24;
$rm24 = $fir_riadok->rm24;
$r25 = $fir_riadok->r25;
$rk25 = $fir_riadok->rk25;
$rn25 = $fir_riadok->rn25;
$rm25 = $fir_riadok->rm25;
$r26 = $fir_riadok->r26;
$rk26 = $fir_riadok->rk26;
$rn26 = $fir_riadok->rn26;
$rm26 = $fir_riadok->rm26;
$r27 = $fir_riadok->r27;
$rk27 = $fir_riadok->rk27;
$rn27 = $fir_riadok->rn27;
$rm27 = $fir_riadok->rm27;
$r28 = $fir_riadok->r28;
$rk28 = $fir_riadok->rk28;
$rn28 = $fir_riadok->rn28;
$rm28 = $fir_riadok->rm28;
$r29 = $fir_riadok->r29;
$rk29 = $fir_riadok->rk29;
$rn29 = $fir_riadok->rn29;
$rm29 = $fir_riadok->rm29;
$r30 = $fir_riadok->r30;
$rk30 = $fir_riadok->rk30;
$rn30 = $fir_riadok->rn30;
$rm30 = $fir_riadok->rm30;
$r31 = $fir_riadok->r31;
$rk31 = $fir_riadok->rk31;
$rn31 = $fir_riadok->rn31;
$rm31 = $fir_riadok->rm31;
$r32 = $fir_riadok->r32;
$rk32 = $fir_riadok->rk32;
$rn32 = $fir_riadok->rn32;
$rm32 = $fir_riadok->rm32;
$r33 = $fir_riadok->r33;
$rk33 = $fir_riadok->rk33;
$rn33 = $fir_riadok->rn33;
$rm33 = $fir_riadok->rm33;
$r34 = $fir_riadok->r34;
$rk34 = $fir_riadok->rk34;
$rn34 = $fir_riadok->rn34;
$rm34 = $fir_riadok->rm34;
$r35 = $fir_riadok->r35;
$rk35 = $fir_riadok->rk35;
$rn35 = $fir_riadok->rn35;
$rm35 = $fir_riadok->rm35;
$r36 = $fir_riadok->r36;
$rk36 = $fir_riadok->rk36;
$rn36 = $fir_riadok->rn36;
$rm36 = $fir_riadok->rm36;
$r37 = $fir_riadok->r37;
$rk37 = $fir_riadok->rk37;
$rn37 = $fir_riadok->rn37;
$rm37 = $fir_riadok->rm37;
$r38 = $fir_riadok->r38;
$rk38 = $fir_riadok->rk38;
$rn38 = $fir_riadok->rn38;
$rm38 = $fir_riadok->rm38;
}
if ( $strana == 3 )
{
$r39 = $fir_riadok->r39;
$rk39 = $fir_riadok->rk39;
$rn39 = $fir_riadok->rn39;
$rm39 = $fir_riadok->rm39;
$r40 = $fir_riadok->r40;
$rk40 = $fir_riadok->rk40;
$rn40 = $fir_riadok->rn40;
$rm40 = $fir_riadok->rm40;
$r41 = $fir_riadok->r41;
$rk41 = $fir_riadok->rk41;
$rn41 = $fir_riadok->rn41;
$rm41 = $fir_riadok->rm41;
$r42 = $fir_riadok->r42;
$rk42 = $fir_riadok->rk42;
$rn42 = $fir_riadok->rn42;
$rm42 = $fir_riadok->rm42;
$r43 = $fir_riadok->r43;
$rk43 = $fir_riadok->rk43;
$rn43 = $fir_riadok->rn43;
$rm43 = $fir_riadok->rm43;
$r44 = $fir_riadok->r44;
$rk44 = $fir_riadok->rk44;
$rn44 = $fir_riadok->rn44;
$rm44 = $fir_riadok->rm44;
$r45 = $fir_riadok->r45;
$rk45 = $fir_riadok->rk45;
$rn45 = $fir_riadok->rn45;
$rm45 = $fir_riadok->rm45;
$r46 = $fir_riadok->r46;
$rk46 = $fir_riadok->rk46;
$rn46 = $fir_riadok->rn46;
$rm46 = $fir_riadok->rm46;
$r47 = $fir_riadok->r47;
$rk47 = $fir_riadok->rk47;
$rn47 = $fir_riadok->rn47;
$rm47 = $fir_riadok->rm47;
$r48 = $fir_riadok->r48;
$rk48 = $fir_riadok->rk48;
$rn48 = $fir_riadok->rn48;
$rm48 = $fir_riadok->rm48;
$r49 = $fir_riadok->r49;
$rk49 = $fir_riadok->rk49;
$rn49 = $fir_riadok->rn49;
$rm49 = $fir_riadok->rm49;
$r50 = $fir_riadok->r50;
$rk50 = $fir_riadok->rk50;
$rn50 = $fir_riadok->rn50;
$rm50 = $fir_riadok->rm50;
$r51 = $fir_riadok->r51;
$rk51 = $fir_riadok->rk51;
$rn51 = $fir_riadok->rn51;
$rm51 = $fir_riadok->rm51;
$r52 = $fir_riadok->r52;
$rk52 = $fir_riadok->rk52;
$rn52 = $fir_riadok->rn52;
$rm52 = $fir_riadok->rm52;
$r53 = $fir_riadok->r53;
$rk53 = $fir_riadok->rk53;
$rn53 = $fir_riadok->rn53;
$rm53 = $fir_riadok->rm53;
$r54 = $fir_riadok->r54;
$rk54 = $fir_riadok->rk54;
$rn54 = $fir_riadok->rn54;
$rm54 = $fir_riadok->rm54;
$r55 = $fir_riadok->r55;
$rk55 = $fir_riadok->rk55;
$rn55 = $fir_riadok->rn55;
$rm55 = $fir_riadok->rm55;
$r55 = $fir_riadok->r55;
$rk55 = $fir_riadok->rk55;
$rn55 = $fir_riadok->rn55;
$rm55 = $fir_riadok->rm55;
$r56 = $fir_riadok->r56;
$rk56 = $fir_riadok->rk56;
$rn56 = $fir_riadok->rn56;
$rm56 = $fir_riadok->rm56;
$r57 = $fir_riadok->r57;
$rk57 = $fir_riadok->rk57;
$rn57 = $fir_riadok->rn57;
$rm57 = $fir_riadok->rm57;
$r58 = $fir_riadok->r58;
$rk58 = $fir_riadok->rk58;
$rn58 = $fir_riadok->rn58;
$rm58 = $fir_riadok->rm58;
$r59 = $fir_riadok->r59;
$rk59 = $fir_riadok->rk59;
$rn59 = $fir_riadok->rn59;
$rm59 = $fir_riadok->rm59;
$r60 = $fir_riadok->r60;
$rk60 = $fir_riadok->rk60;
$rn60 = $fir_riadok->rn60;
$rm60 = $fir_riadok->rm60;
$r61 = $fir_riadok->r61;
$rk61 = $fir_riadok->rk61;
$rn61 = $fir_riadok->rn61;
$rm61 = $fir_riadok->rm61;
$r62 = $fir_riadok->r62;
$rk62 = $fir_riadok->rk62;
$rn62 = $fir_riadok->rn62;
$rm62 = $fir_riadok->rm62;
$r63 = $fir_riadok->r63;
$rk63 = $fir_riadok->rk63;
$rn63 = $fir_riadok->rn63;
$rm63 = $fir_riadok->rm63;
$r64 = $fir_riadok->r64;
$rk64 = $fir_riadok->rk64;
$rn64 = $fir_riadok->rn64;
$rm64 = $fir_riadok->rm64;
$r66 = $fir_riadok->r66;
$rk66 = $fir_riadok->rk66;
$rn66 = $fir_riadok->rn66;
$rm66 = $fir_riadok->rm66;
$r65 = $fir_riadok->r65;
$rk65 = $fir_riadok->rk65;
$rn65 = $fir_riadok->rn65;
$rm65 = $fir_riadok->rm65;
$r66 = $fir_riadok->r66;
$rk66 = $fir_riadok->rk66;
$rn66 = $fir_riadok->rn66;
$rm66 = $fir_riadok->rm66;
$r67 = $fir_riadok->r67;
$rk67 = $fir_riadok->rk67;
$rn67 = $fir_riadok->rn67;
$rm67 = $fir_riadok->rm67;
$r68 = $fir_riadok->r68;
$rk68 = $fir_riadok->rk68;
$rn68 = $fir_riadok->rn68;
$rm68 = $fir_riadok->rm68;
}
if ( $strana == 4 )
{
$r69 = $fir_riadok->r69;
$rm69 = $fir_riadok->rm69;
$r70 = $fir_riadok->r70;
$rm70 = $fir_riadok->rm70;
$r71 = $fir_riadok->r71;
$rm71 = $fir_riadok->rm71;
$r72 = $fir_riadok->r72;
$rm72 = $fir_riadok->rm72;
$r73 = $fir_riadok->r73;
$rm73 = $fir_riadok->rm73;
$r74 = $fir_riadok->r74;
$rm74 = $fir_riadok->rm74;
$r75 = $fir_riadok->r75;
$rm75 = $fir_riadok->rm75;
$r76 = $fir_riadok->r76;
$rm76 = $fir_riadok->rm76;
$r77 = $fir_riadok->r77;
$rm77 = $fir_riadok->rm77;
$r78 = $fir_riadok->r78;
$rm78 = $fir_riadok->rm78;
$r79 = $fir_riadok->r79;
$rm79 = $fir_riadok->rm79;
$r80 = $fir_riadok->r80;
$rm80 = $fir_riadok->rm80;
$r81 = $fir_riadok->r81;
$rm81 = $fir_riadok->rm81;
$r82 = $fir_riadok->r82;
$rm82 = $fir_riadok->rm82;
$r83 = $fir_riadok->r83;
$rm83 = $fir_riadok->rm83;
$r84 = $fir_riadok->r84;
$rm84 = $fir_riadok->rm84;
$r85 = $fir_riadok->r85;
$rm85 = $fir_riadok->rm85;
$r86 = $fir_riadok->r86;
$rm86 = $fir_riadok->rm86;
$r87 = $fir_riadok->r87;
$rm87 = $fir_riadok->rm87;
$r88 = $fir_riadok->r88;
$rm88 = $fir_riadok->rm88;
$r88 = $fir_riadok->r88;
$rm88 = $fir_riadok->rm88;
$r89 = $fir_riadok->r89;
$rm89 = $fir_riadok->rm89;
$r90 = $fir_riadok->r90;
$rm90 = $fir_riadok->rm90;
$r91 = $fir_riadok->r91;
$rm91 = $fir_riadok->rm91;
$r92 = $fir_riadok->r92;
$rm92 = $fir_riadok->rm92;
$r93 = $fir_riadok->r93;
$rm93 = $fir_riadok->rm93;
$r94 = $fir_riadok->r94;
$rm94 = $fir_riadok->rm94;
$r95 = $fir_riadok->r95;
$rm95 = $fir_riadok->rm95;
$r96 = $fir_riadok->r96;
$rm96 = $fir_riadok->rm96;
$r97 = $fir_riadok->r97;
$rm97 = $fir_riadok->rm97;
$r98 = $fir_riadok->r98;
$rm98 = $fir_riadok->rm98;
$r99 = $fir_riadok->r99;
$rm99 = $fir_riadok->rm99;
$r98 = $fir_riadok->r98;
$rm98 = $fir_riadok->rm98;
$r99 = $fir_riadok->r99;
$rm99 = $fir_riadok->rm99;
$r100 = $fir_riadok->r100;
$rm100 = $fir_riadok->rm100;
$r101 = $fir_riadok->r101;
$rm101 = $fir_riadok->rm101;
$r102 = $fir_riadok->r102;
$rm102 = $fir_riadok->rm102;
$r103 = $fir_riadok->r103;
$rm103 = $fir_riadok->rm103;
$r104 = $fir_riadok->r104;
$rm104 = $fir_riadok->rm104;
$r105 = $fir_riadok->r105;
$rm105 = $fir_riadok->rm105;
$r106 = $fir_riadok->r106;
$rm106 = $fir_riadok->rm106;
$r107 = $fir_riadok->r107;
$rm107 = $fir_riadok->rm107;
$r108 = $fir_riadok->r108;
$rm108 = $fir_riadok->rm108;
$r109 = $fir_riadok->r109;
$rm109 = $fir_riadok->rm109;
$r110 = $fir_riadok->r110;
$rm110 = $fir_riadok->rm110;
$r111 = $fir_riadok->r111;
$rm111 = $fir_riadok->rm111;
$r112 = $fir_riadok->r112;
$rm112 = $fir_riadok->rm112;
$r113 = $fir_riadok->r113;
$rm113 = $fir_riadok->rm113;
}
if ( $strana == 5 )
{
$r114 = $fir_riadok->r114;
$rm114 = $fir_riadok->rm114;
$r115 = $fir_riadok->r115;
$rm115 = $fir_riadok->rm115;
$r116 = $fir_riadok->r116;
$rm116 = $fir_riadok->rm116;
$r117 = $fir_riadok->r117;
$rm117 = $fir_riadok->rm117;
$r118 = $fir_riadok->r118;
$rm118 = $fir_riadok->rm118;
$r119 = $fir_riadok->r119;
$rm119 = $fir_riadok->rm119;
$r120 = $fir_riadok->r120;
$rm120 = $fir_riadok->rm120;
$r121 = $fir_riadok->r121;
$rm121 = $fir_riadok->rm121;
$r122 = $fir_riadok->r122;
$rm122 = $fir_riadok->rm122;
$r123 = $fir_riadok->r123;
$rm123 = $fir_riadok->rm123;
$r124 = $fir_riadok->r124;
$rm124 = $fir_riadok->rm124;
$r125 = $fir_riadok->r125;
$rm125 = $fir_riadok->rm125;
$r126 = $fir_riadok->r126;
$rm126 = $fir_riadok->rm126;
$r127 = $fir_riadok->r127;
$rm127 = $fir_riadok->rm127;
$r128 = $fir_riadok->r128;
$rm128 = $fir_riadok->rm128;
$r129 = $fir_riadok->r129;
$rm129 = $fir_riadok->rm129;
$r130 = $fir_riadok->r130;
$rm130 = $fir_riadok->rm130;
$r131 = $fir_riadok->r131;
$rm131 = $fir_riadok->rm131;
}
mysql_free_result($fir_vysledok);
    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
$skutku=substr($datum,0,6);
?>
<head>
<meta charset="cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>výkaz FIN 2-04 | EuroSecom</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  height: 16px;
  line-height: 16px;
  padding-left: 2px;
  border: 1px solid #39f;
  font-size: 12px;
}
div.input-echo {
  position: absolute;
  font-size: 16px;
  background-color: #fff;
  font-weight: bold;
}
img.btn-form-tool {
  margin: 0 8px;
}
.btn-text {
  border: 0;
  box-sizing: border-box;
  color: #39f;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  height: 28px;
  line-height: 28px;
  padding: 0 6px;
  text-align: center;
  text-transform: uppercase;
  /*vertical-align: middle;*/
  background-color: transparent;
  border-radius: 2px;
}
.btn-text:hover {
  background-color: rgba(158,158,158,.2);
}
.ukaz {
  background-color: red !important;
}
</style>
</head>
<body onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">FIN 2-04 Finanèný výkaz o vybraných údajoch z aktív a pasív za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok"; ?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="FormMetod();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
<?php if ( $kli_vrok < 2018 ) { ?>
    <button type="button" onclick="DbfFin204pod16();" title="Export do DBF" class="btn-text toright" style="position: relative; top: -4px;">DBF</button>
<?php } ?>
<?php if ( $kli_vrok >= 2017 ) { ?>
    <button type="button" onclick="CsvFin204pod16()" title="Export do CSV" class="btn-text toright" style="position: relative; top: -4px;">CSV</button>
<?php } ?>
    <img src="../obr/ikony/download_blue_icon.png" onclick="Nacitaj();" title="Naèíta údaje" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="FormPDF(9999);" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<?php // if ( $strana < 1 OR $strana > 3 ) $strana=1; ?>
<div id="content">
<form name="formv1" method="post" action="../ucto/vykaz_fin204pod_2018.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active";
//$source="vykaz_fin204pod_2018.php";
?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
<?php
//$alertnacitaj=""; dopyt, nakoniec zruši zaremovanie
//if ( $nacitavamhodnoty == 1 ) { $alertnacitaj="!!! Údaje sú naèítané !!!"; }
?>
 <div class="alert-pocitam"><?php echo $alertnacitaj; ?></div>
 <input type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_source; ?>_str1.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">

<span class="text-echo" style="top:153px; left:403px;"><?php echo $datum; ?></span>
<span class="text-echo" style="top:271px; left:141px;">x</span>
<span class="text-echo" style="top:516px; left:141px; letter-spacing:13.5px;"><?php echo $fir_ficox; ?></span>
<span class="text-echo" style="top:516px; left:342px; letter-spacing:14px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:516px; left:409px; letter-spacing:13.5px;"><?php echo $kli_vrok; ?></span>
<div class="input-echo" style="width:687px; top:574px; left:135px; height:40px; line-height:40px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:687px; top:655px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_uctt02; ?></div>
<div class="input-echo" style="width:687px; top:735.5px; left:135px; height:39.5px; line-height:39.5px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:105px; top:816.5px; left:135px; height:19px; line-height:19px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:553px; top:816.5px; left:269px; height:39.5px; line-height:39.5px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:687px; top:898px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_fem1; ?></div>
<input type="text" name="daz" id="daz" onkeyup="CiarkaNaBodku(this);" style="width:80px; top:966px; left:236px; height:22px; line-height:22px; font-size:14px; padding-left:4px;"/>
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_source; ?>_str2.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:185px; left:666px; font-size:14px;"><?php echo $skutku; ?></span>
<!-- aktiva -->
<span class="text-echo" style="top:305px; right:345px; font-size:12px;"><?php echo $r01; ?></span>
<span class="text-echo" style="top:305px; right:264px; font-size:12px;"><?php echo $rk01; ?></span>
<span class="text-echo" style="top:305px; right:182px; font-size:12px;"><?php echo $rn01; ?></span>
<span class="text-echo" style="top:305px; right:50px; font-size:12px;"><?php echo $rm01; ?></span>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:326px; left:530px;"/>
<input type="text" name="rk02" id="rk02" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:326px; left:611px;"/>
<input type="text" name="rn02" id="rn02" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:326px; left:693px;"/>
<input type="text" name="rm02" id="rm02" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:326px; left:773px;"/>
<input type="text" name="r03" id="r03" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:350px; left:530px;"/>
<input type="text" name="rk03" id="rk03" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:350px; left:611px;"/>
<input type="text" name="rn03" id="rn03" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:350px; left:693px;"/>
<input type="text" name="rm03" id="rm03" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:350px; left:773px;"/>
<input type="text" name="r04" id="r04" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:375px; left:530px;"/>
<input type="text" name="rk04" id="rk04" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:375px; left:611px;"/>
<input type="text" name="rn04" id="rn04" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:375px; left:693px;"/>
<input type="text" name="rm04" id="rm04" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:375px; left:774px;"/>
<input type="text" name="r05" id="r05" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:400px; left:530px;"/>
<input type="text" name="rk05" id="rk05" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:400px; left:611px;"/>
<input type="text" name="rn05" id="rn05" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:400px; left:693px;"/>
<input type="text" name="rm05" id="rm05" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:400px; left:774px;"/>
<input type="text" name="r06" id="r06" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:425px; left:530px;"/>
<input type="text" name="rk06" id="rk06" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:425px; left:611px;"/>
<input type="text" name="rn06" id="rn06" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:425px; left:693px;"/>
<input type="text" name="rm06" id="rm06" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:425px; left:774px;"/>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:450px; left:530px;"/>
<input type="text" name="rk07" id="rk07" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:450px; left:611px;"/>
<input type="text" name="rn07" id="rn07" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:450px; left:693px;"/>
<input type="text" name="rm07" id="rm07" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:450px; left:774px;"/>
<span class="text-echo" style="top:480px; right:345px; font-size:12px;"><?php echo $r08; ?></span>
<span class="text-echo" style="top:480px; right:264px; font-size:12px;"><?php echo $rk08; ?></span>
<span class="text-echo" style="top:480px; right:182px; font-size:12px;"><?php echo $rn08; ?></span>
<span class="text-echo" style="top:480px; right:50px; font-size:12px;"><?php echo $rm08; ?></span>
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:530px;"/>
<input type="text" name="rk09" id="rk09" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:611px;"/>
<input type="text" name="rn09" id="rn09" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:693px;"/>
<input type="text" name="rm09" id="rm09" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:499px; left:774px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:530px;"/>
<input type="text" name="rk10" id="rk10" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:611px;"/>
<input type="text" name="rn10" id="rn10" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:693px;"/>
<input type="text" name="rm10" id="rm10" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:524px; left:774px;"/>
<input type="text" name="r11" id="r11" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:530px;"/>
<input type="text" name="rk11" id="rk11" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:611px;"/>
<input type="text" name="rn11" id="rn11" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:693px;"/>
<input type="text" name="rm11" id="rm11" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:549px; left:774px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:574px; left:530px;"/>
<input type="text" name="rk12" id="rk12" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:574px; left:611px;"/>
<input type="text" name="rn12" id="rn12" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:574px; left:693px;"/>
<input type="text" name="rm12" id="rm12" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:574px; left:774px;"/>
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:599px; left:530px;"/>
<input type="text" name="rk13" id="rk13" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:599px; left:611px;"/>
<input type="text" name="rn13" id="rn13" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:599px; left:693px;"/>
<input type="text" name="rm13" id="rm13" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:599px; left:774px;"/>
<input type="text" name="r14" id="r14" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:624px; left:530px;"/>
<input type="text" name="rk14" id="rk14" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:624px; left:611px;"/>
<input type="text" name="rn14" id="rn14" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:624px; left:693px;"/>
<input type="text" name="rm14" id="rm14" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:624px; left:774px;"/>
<input type="text" name="r15" id="r15" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:649px; left:530px;"/>
<input type="text" name="rk15" id="rk15" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:649px; left:611px;"/>
<input type="text" name="rn15" id="rn15" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:649px; left:693px;"/>
<input type="text" name="rm15" id="rm15" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:649px; left:774px;"/>
<input type="text" name="r16" id="r16" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:676px; left:530px;"/>
<input type="text" name="rk16" id="rk16" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:676px; left:611px;"/>
<input type="text" name="rn16" id="rn16" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:676px; left:693px;"/>
<input type="text" name="rm16" id="rm16" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:676px; left:774px;"/>
<input type="text" name="r17" id="r17" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:703px; left:530px;"/>
<input type="text" name="rk17" id="rk17" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:703px; left:611px;"/>
<input type="text" name="rn17" id="rn17" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:703px; left:693px;"/>
<input type="text" name="rm17" id="rm17" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:703px; left:774px;"/>
<input type="text" name="r18" id="r18" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:727px; left:530px;"/>
<input type="text" name="rk18" id="rk18" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:727px; left:611px;"/>
<input type="text" name="rn18" id="rn18" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:727px; left:693px;"/>
<input type="text" name="rm18" id="rm18" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:727px; left:774px;"/>
<span class="text-echo" style="top:758px; right:345px; font-size:12px;"><?php echo $r19; ?></span>
<span class="text-echo" style="top:758px; right:264px; font-size:12px;"><?php echo $rk19; ?></span>
<span class="text-echo" style="top:758px; right:182px; font-size:12px;"><?php echo $rn19; ?></span>
<span class="text-echo" style="top:758px; right:50px; font-size:12px;"><?php echo $rm19; ?></span>
<input type="text" name="r20" id="r20" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:777px; left:530px;"/>
<input type="text" name="rk20" id="rk20" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:777px; left:611px;"/>
<input type="text" name="rn20" id="rn20" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:777px; left:693px;"/>
<input type="text" name="rm20" id="rm20" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:777px; left:774px;"/>
<input type="text" name="r21" id="r21" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:802px; left:530px;"/>
<input type="text" name="rk21" id="rk21" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:802px; left:611px;"/>
<input type="text" name="rn21" id="rn21" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:802px; left:693px;"/>
<input type="text" name="rm21" id="rm21" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:802px; left:774px;"/>
<input type="text" name="r22" id="r22" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:827px; left:530px;"/>
<input type="text" name="rk22" id="rk22" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:827px; left:611px;"/>
<input type="text" name="rn22" id="rn22" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:827px; left:693px;"/>
<input type="text" name="rm22" id="rm22" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:827px; left:774px;"/>
<input type="text" name="r23" id="r23" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:852px; left:530px;"/>
<input type="text" name="rk23" id="rk23" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:852px; left:611px;"/>
<input type="text" name="rn23" id="rn23" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:852px; left:693px;"/>
<input type="text" name="rm23" id="rm23" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:852px; left:774px;"/>
<input type="text" name="r24" id="r274" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:877px; left:530px;"/>
<input type="text" name="rk24" id="rk24" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:877px; left:611px;"/>
<input type="text" name="rn24" id="rn24" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:877px; left:693px;"/>
<input type="text" name="rm24" id="rm24" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:877px; left:774px;"/>
<input type="text" name="r25" id="r25" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:902px; left:530px;"/>
<input type="text" name="rk25" id="rk25" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:902px; left:611px;"/>
<input type="text" name="rn25" id="rn25" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:902px; left:693px;"/>
<input type="text" name="rm25" id="rm25" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:902px; left:774px;"/>
<input type="text" name="r26" id="r26" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:926px; left:530px;"/>
<input type="text" name="rk26" id="rk26" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:926px; left:611px;"/>
<input type="text" name="rn26" id="rn26" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:926px; left:693px;"/>
<input type="text" name="rm26" id="rm26" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:926px; left:774px;"/>
<span class="text-echo" style="top:957px; right:345px; font-size:12px;"><?php echo $r27; ?></span>
<span class="text-echo" style="top:957px; right:264px; font-size:12px;"><?php echo $rk27; ?></span>
<span class="text-echo" style="top:957px; right:182px; font-size:12px;"><?php echo $rn27; ?></span>
<span class="text-echo" style="top:957px; right:50px; font-size:12px;"><?php echo $rm27; ?></span>
<input type="text" name="r28" id="r28" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:976px; left:530px;"/>
<input type="text" name="rk28" id="rk28" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:976px; left:611px;"/>
<input type="text" name="rn28" id="rn28" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:976px; left:693px;"/>
<input type="text" name="rm28" id="rm28" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:976px; left:774px;"/>
<input type="text" name="r29" id="r29" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1001px; left:530px;"/>
<input type="text" name="rk29" id="rk29" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1001px; left:611px;"/>
<input type="text" name="rn29" id="rn29" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1001px; left:693px;"/>
<input type="text" name="rm29" id="rm29" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1001px; left:774px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1026px; left:530px;"/>
<input type="text" name="rk30" id="rk30" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1026px; left:611px;"/>
<input type="text" name="rn30" id="rn30" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1026px; left:693px;"/>
<input type="text" name="rm30" id="rm30" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1026px; left:774px;"/>
<input type="text" name="r31" id="r31" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1051px; left:530px;"/>
<input type="text" name="rk31" id="rk31" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1051px; left:611px;"/>
<input type="text" name="rn31" id="rn31" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1051px; left:693px;"/>
<input type="text" name="rm31" id="rm31" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1051px; left:774px;"/>
<input type="text" name="r32" id="r32" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1076px; left:530px;"/>
<input type="text" name="rk32" id="rk32" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1076px; left:611px;"/>
<input type="text" name="rn32" id="rn32" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1076px; left:693px;"/>
<input type="text" name="rm32" id="rm32" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1076px; left:774px;"/>
<input type="text" name="r33" id="r33" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1101px; left:530px;"/>
<input type="text" name="rk33" id="rk33" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1101px; left:611px;"/>
<input type="text" name="rn33" id="rn33" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1101px; left:693px;"/>
<input type="text" name="rm33" id="rm33" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1101px; left:774px;"/>
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1125px; left:530px;"/>
<input type="text" name="rk34" id="rk34" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1125px; left:611px;"/>
<input type="text" name="rn34" id="rn34" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1125px; left:693px;"/>
<input type="text" name="rm34" id="rm34" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1125px; left:774px;"/>
<span class="text-echo" style="top:1156px; right:345px; font-size:12px;"><?php echo $r35; ?></span>
<span class="text-echo" style="top:1156px; right:264px; font-size:12px;"><?php echo $rk35; ?></span>
<span class="text-echo" style="top:1156px; right:182px; font-size:12px;"><?php echo $rn35; ?></span>
<span class="text-echo" style="top:1156px; right:50px; font-size:12px;"><?php echo $rm35; ?></span>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1175px; left:530px;"/>
<input type="text" name="rk36" id="rk36" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1175px; left:611px;"/>
<input type="text" name="rn36" id="rn36" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1175px; left:693px;"/>
<input type="text" name="rm36" id="rm36" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1175px; left:774px;"/>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1200px; left:530px;"/>
<input type="text" name="rk37" id="rk37" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1200px; left:611px;"/>
<input type="text" name="rn37" id="rn37" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1200px; left:693px;"/>
<input type="text" name="rm37" id="rm37" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1200px; left:774px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1225px; left:530px;"/>
<input type="text" name="rk38" id="rk38" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1225px; left:611px;"/>
<input type="text" name="rn38" id="rn38" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:1225px; left:693px;"/>
<input type="text" name="rm38" id="rm38" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:1225px; left:774px;"/>
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_source; ?>_str3.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<!-- aktiva pokrac. -->
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:93px; left:530px;"/>
<input type="text" name="rk39" id="rk39" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:93px; left:611px;"/>
<input type="text" name="rn39" id="rn39" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:93px; left:693px;"/>
<input type="text" name="rm39" id="rm39" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:93px; left:774px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:118px; left:530px;"/>
<input type="text" name="rk40" id="rk40" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:118px; left:611px;"/>
<input type="text" name="rn40" id="rn40" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:118px; left:693px;"/>
<input type="text" name="rm40" id="rm40" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:118px; left:774px;"/>
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:142px; left:530px;"/>
<input type="text" name="rk41" id="rk41" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:142px; left:611px;"/>
<input type="text" name="rn41" id="rn41" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:142px; left:693px;"/>
<input type="text" name="rm41" id="rm41" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:142px; left:774px;"/>
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:167px; left:530px;"/>
<input type="text" name="rk42" id="rk42" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:167px; left:611px;"/>
<input type="text" name="rn42" id="rn42" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:167px; left:693px;"/>
<input type="text" name="rm42" id="rm42" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:167px; left:774px;"/>
<input type="text" name="r43" id="r43" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:192px; left:530px;"/>
<input type="text" name="rk43" id="rk43" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:192px; left:611px;"/>
<input type="text" name="rn43" id="rn43" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:192px; left:693px;"/>
<input type="text" name="rm43" id="rm43" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:192px; left:774px;"/>
<input type="text" name="r44" id="r44" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:217px; left:530px;"/>
<input type="text" name="rk44" id="rk44" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:217px; left:611px;"/>
<input type="text" name="rn44" id="rn44" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:217px; left:693px;"/>
<input type="text" name="rm44" id="rm44" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:217px; left:774px;"/>
<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:244px; left:530px;"/>
<input type="text" name="rk45" id="rk45" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:244px; left:611px;"/>
<input type="text" name="rn45" id="rn45" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:244px; left:693px;"/>
<input type="text" name="rm45" id="rm45" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:244px; left:774px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:271px; left:530px;"/>
<input type="text" name="rk46" id="rk46" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:271px; left:611px;"/>
<input type="text" name="rn46" id="rn46" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:271px; left:693px;"/>
<input type="text" name="rm46" id="rm46" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:271px; left:774px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:296px; left:530px;"/>
<input type="text" name="rk47" id="rk47" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:296px; left:611px;"/>
<input type="text" name="rn47" id="rn47" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:296px; left:693px;"/>
<input type="text" name="rm47" id="rm47" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:296px; left:774px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:320px; left:530px;"/>
<input type="text" name="rk48" id="rk48" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:320px; left:611px;"/>
<input type="text" name="rn48" id="rn48" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:320px; left:693px;"/>
<input type="text" name="rm48" id="rm48" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:320px; left:774px;"/>
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:345px; left:530px;"/>
<input type="text" name="rk49" id="rk49" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:345px; left:611px;"/>
<input type="text" name="rn49" id="rn49" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:345px; left:693px;"/>
<input type="text" name="rm49" id="rm49" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:345px; left:774px;"/>
<input type="text" name="r50" id="r50" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:370px; left:530px;"/>
<input type="text" name="rk50" id="rk50" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:370px; left:611px;"/>
<input type="text" name="rn50" id="rn50" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:370px; left:693px;"/>
<input type="text" name="rm50" id="rm50" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:370px; left:774px;"/>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:397px; left:530px;"/>
<input type="text" name="rk51" id="rk51" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:397px; left:611px;"/>
<input type="text" name="rn51" id="rn51" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:397px; left:693px;"/>
<input type="text" name="rm51" id="rm51" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:397px; left:774px;"/>
<span class="text-echo" style="top:430px; right:345px; font-size:12px;"><?php echo $r52; ?></span>
<span class="text-echo" style="top:430px; right:264px; font-size:12px;"><?php echo $rk52; ?></span>
<span class="text-echo" style="top:430px; right:182px; font-size:12px;"><?php echo $rn52; ?></span>
<span class="text-echo" style="top:430px; right:50px; font-size:12px;"><?php echo $rm52; ?></span>
<input type="text" name="r53" id="r53" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:449px; left:530px;"/>
<input type="text" name="rk53" id="rk53" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:449px; left:611px;"/>
<input type="text" name="rn53" id="rn53" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:449px; left:693px;"/>
<input type="text" name="rm53" id="rm53" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:449px; left:774px;"/>
<input type="text" name="r54" id="r54" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:474px; left:530px;"/>
<input type="text" name="rk54" id="rk54" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:474px; left:611px;"/>
<input type="text" name="rn54" id="rn54" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:474px; left:693px;"/>
<input type="text" name="rm54" id="rm54" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:474px; left:774px;"/>
<input type="text" name="r55" id="r55" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:530px;"/>
<input type="text" name="rk55" id="rk55" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:611px;"/>
<input type="text" name="rn55" id="rn55" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:499px; left:693px;"/>
<input type="text" name="rm55" id="rm55" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:499px; left:774px;"/>
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:530px;"/>
<input type="text" name="rk56" id="rk56" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:611px;"/>
<input type="text" name="rn56" id="rn56" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:524px; left:693px;"/>
<input type="text" name="rm56" id="rm56" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:524px; left:774px;"/>
<input type="text" name="r57" id="r57" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:530px;"/>
<input type="text" name="rk57" id="rk57" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:611px;"/>
<input type="text" name="rn57" id="rn57" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:549px; left:693px;"/>
<input type="text" name="rm57" id="rm57" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:549px; left:774px;"/>
<input type="text" name="r58" id="r58" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:573px; left:530px;"/>
<input type="text" name="rk58" id="rk58" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:573px; left:611px;"/>
<input type="text" name="rn58" id="rn58" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:573px; left:693px;"/>
<input type="text" name="rm58" id="rm58" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:573px; left:774px;"/>
<input type="text" name="r59" id="r59" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:598px; left:530px;"/>
<input type="text" name="rk59" id="rk59" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:598px; left:611px;"/>
<input type="text" name="rn59" id="rn59" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:598px; left:693px;"/>
<input type="text" name="rm59" id="rm59" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:598px; left:774px;"/>
<input type="text" name="r60" id="r60" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:623px; left:530px;"/>
<input type="text" name="rk60" id="rk60" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:623px; left:611px;"/>
<input type="text" name="rn60" id="rn60" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:623px; left:693px;"/>
<input type="text" name="rm60" id="rm60" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:623px; left:774px;"/>
<span class="text-echo" style="top:653px; right:345px; font-size:12px;"><?php echo $r61; ?></span>
<span class="text-echo" style="top:653px; right:264px; font-size:12px;"><?php echo $rk61; ?></span>
<span class="text-echo" style="top:653px; right:182px; font-size:12px;"><?php echo $rn62; ?></span>
<span class="text-echo" style="top:653px; right:50px; font-size:12px;"><?php echo $rm62; ?></span>
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:673px; left:530px;"/>
<input type="text" name="rk62" id="rk62" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:673px; left:611px;"/>
<input type="text" name="rn62" id="rn62" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:673px; left:693px;"/>
<input type="text" name="rm62" id="rm62" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:673px; left:774px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:698px; left:530px;"/>
<input type="text" name="rk63" id="rk63" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:698px; left:611px;"/>
<input type="text" name="rn63" id="rn63" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:698px; left:693px;"/>
<input type="text" name="rm63" id="rm63" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:698px; left:774px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:723px; left:530px;"/>
<input type="text" name="rk64" id="rk64" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:723px; left:611px;"/>
<input type="text" name="rn64" id="rn64" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:723px; left:693px;"/>
<input type="text" name="rm64" id="rm64" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:723px; left:774px;"/>
<input type="text" name="r65" id="r65" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:747px; left:530px;"/>
<input type="text" name="rk65" id="rk65" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:747px; left:611px;"/>
<input type="text" name="rn65" id="rn65" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:747px; left:693px;"/>
<input type="text" name="rm65" id="rm65" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:747px; left:774px;"/>
<input type="text" name="r66" id="r66" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:772px; left:530px;"/>
<input type="text" name="rk66" id="rk66" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:772px; left:611px;"/>
<input type="text" name="rn66" id="rn66" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:772px; left:693px;"/>
<input type="text" name="rm66" id="rm66" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:772px; left:774px;"/>
<input type="text" name="r67" id="r67" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:797px; left:530px;"/>
<input type="text" name="rk67" id="rk67" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:797px; left:611px;"/>
<input type="text" name="rn67" id="rn67" onkeyup="CiarkaNaBodku(this);" style="width:71px; top:797px; left:693px;"/>
<input type="text" name="rm67" id="rm67" onkeyup="CiarkaNaBodku(this);" style="width:124px; top:797px; left:774px;"/>
<span class="text-echo" style="top:827px; right:345px; font-size:12px;"><?php echo $r68; ?></span>
<span class="text-echo" style="top:827px; right:264px; font-size:12px;"><?php echo $rk68; ?></span>
<span class="text-echo" style="top:827px; right:182px; font-size:12px;"><?php echo $rn68; ?></span>
<span class="text-echo" style="top:827px; right:50px; font-size:12px;"><?php echo $rm68; ?></span>
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
<img src="<?php echo $jpg_source; ?>_str4.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<span class="text-echo" style="top:96px; left:650px; font-size:14px;"><?php echo $skutku; ?></span>
<!-- pasiva -->
<span class="text-echo" style="top:163px; right:250px; font-size:14px;"><?php echo $r69; ?></span>
<span class="text-echo" style="top:163px; right:70px; font-size:14px;"><?php echo $rm69; ?></span>
<input type="text" name="r70" id="r70" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:185px; left:580px;"/>
<input type="text" name="rm70" id="rm70" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:185px; left:760px;"/>
<input type="text" name="r71" id="r71" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:210px; left:580px;"/>
<input type="text" name="rm71" id="rm71" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:210px; left:760px;"/>
<input type="text" name="r72" id="r72" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:235px; left:580px;"/>
<input type="text" name="rm72" id="rm72" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:235px; left:760px;"/>
<input type="text" name="r73" id="r73" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:260px; left:580px;"/>
<input type="text" name="rm73" id="rm73" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:260px; left:760px;"/>
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:285px; left:580px;"/>
<input type="text" name="rm74" id="rm74" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:285px; left:760px;"/>
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:309px; left:580px;"/>
<input type="text" name="rm75" id="rm75" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:309px; left:760px;"/>
<input type="text" name="r76" id="r76" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:334px; left:580px;"/>
<input type="text" name="rm76" id="rm76" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:334px; left:760px;"/>
<span class="text-echo" style="top:363px; right:250px; font-size:14px;"><?php echo $r77; ?></span>
<span class="text-echo" style="top:363px; right:70px; font-size:14px;"><?php echo $rm77; ?></span>
<input type="text" name="r78" id="r78" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:384px; left:580px;"/>
<input type="text" name="rm78" id="rm78" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:384px; left:760px;"/>
<input type="text" name="r79" id="r79" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:409px; left:580px;"/>
<input type="text" name="rm79" id="rm79" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:409px; left:760px;"/>
<input type="text" name="r80" id="r80" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:434px; left:580px;"/>
<input type="text" name="rm80" id="rm80" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:434px; left:760px;"/>
<input type="text" name="r81" id="r81" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:458px; left:580px;"/>
<input type="text" name="rm81" id="rm81" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:458px; left:760px;"/>
<input type="text" name="r82" id="r82" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:483px; left:580px;"/>
<input type="text" name="rm82" id="rm82" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:483px; left:760px;"/>
<input type="text" name="r83" id="r83" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:508px; left:580px;"/>
<input type="text" name="rm83" id="rm83" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:508px; left:760px;"/>
<input type="text" name="r84" id="r84" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:533px; left:580px;"/>
<input type="text" name="rm84" id="rm84" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:533px; left:760px;"/>
<span class="text-echo" style="top:561px; right:250px; font-size:14px;"><?php echo $r85; ?></span>
<span class="text-echo" style="top:561px; right:70px; font-size:14px;"><?php echo $rm85; ?></span>
<input type="text" name="r86" id="r86" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:582px; left:580px;"/>
<input type="text" name="rm86" id="rm86" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:582px; left:760px;"/>
<input type="text" name="r87" id="r87" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:608px; left:580px;"/>
<input type="text" name="rm87" id="rm87" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:608px; left:760px;"/>
<input type="text" name="r88" id="r88" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:632px; left:580px;"/>
<input type="text" name="rm88" id="rm88" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:632px; left:760px;"/>
<input type="text" name="r89" id="r89" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:657px; left:580px;"/>
<input type="text" name="rm89" id="rm89" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:657px; left:760px;"/>
<input type="text" name="r90" id="r90" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:682px; left:580px;"/>
<input type="text" name="rm90" id="rm90" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:682px; left:760px;"/>
<input type="text" name="r91" id="r91" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:707px; left:580px;"/>
<input type="text" name="rm91" id="rm91" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:707px; left:760px;"/>
<input type="text" name="r92" id="r92" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:732px; left:580px;"/>
<input type="text" name="rm92" id="rm92" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:732px; left:760px;"/>
<input type="text" name="r93" id="r93" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:756px; left:580px;"/>
<input type="text" name="rm93" id="rm93" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:756px; left:760px;"/>
<input type="text" name="r94" id="r94" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:781px; left:580px;"/>
<input type="text" name="rm94" id="rm94" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:781px; left:760px;"/>
<input type="text" name="r95" id="r95" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:807px; left:580px;"/>
<input type="text" name="rm95" id="rm95" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:807px; left:760px;"/>
<input type="text" name="r96" id="r96" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:831px; left:580px;"/>
<input type="text" name="rm96" id="rm96" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:831px; left:760px;"/>
<input type="text" name="r97" id="r97" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:856px; left:580px;"/>
<input type="text" name="rm97" id="rm97" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:856px; left:760px;"/>
<span class="text-echo" style="top:884px; right:250px; font-size:14px;"><?php echo $r98; ?></span>
<span class="text-echo" style="top:884px; right:70px; font-size:14px;"><?php echo $rm98; ?></span>
<input type="text" name="r99" id="r99" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:906px; left:580px;"/>
<input type="text" name="rm99" id="rm99" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:906px; left:760px;"/>
<input type="text" name="r100" id="r100" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:931px; left:580px;"/>
<input type="text" name="rm100" id="rm100" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:931px; left:760px;"/>
<input type="text" name="r101" id="r8101" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:956px; left:580px;"/>
<input type="text" name="rm101" id="rm8101" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:956px; left:760px;"/>
<span class="text-echo" style="top:984px; right:250px; font-size:14px;"><?php echo $r102; ?></span>
<span class="text-echo" style="top:984px; right:70px; font-size:14px;"><?php echo $rm102; ?></span>
<input type="text" name="r103" id="r103" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1005px; left:580px;"/>
<input type="text" name="rm103" id="rm103" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1005px; left:760px;"/>
<input type="text" name="r104" id="r104" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1030px; left:580px;"/>
<input type="text" name="rm104" id="rm104" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1030px; left:760px;"/>
<input type="text" name="r105" id="r105" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1055px; left:580px;"/>
<input type="text" name="rm105" id="rm105" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1055px; left:760px;"/>
<input type="text" name="r106" id="r106" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1080px; left:580px;"/>
<input type="text" name="rm106" id="rm106" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1080px; left:760px;"/>
<input type="text" name="r107" id="r107" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1105px; left:580px;"/>
<input type="text" name="rm107" id="rm107" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1105px; left:760px;"/>
<input type="text" name="r108" id="r108" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1130px; left:580px;"/>
<input type="text" name="rm108" id="rm108" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1130px; left:760px;"/>
<input type="text" name="r109" id="r109" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1155px; left:580px;"/>
<input type="text" name="rm109" id="rm109" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1155px; left:760px;"/>
<input type="text" name="r110" id="r110" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1179px; left:580px;"/>
<input type="text" name="rm110" id="rm110" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1179px; left:760px;"/>
<input type="text" name="r111" id="r111" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1204px; left:580px;"/>
<input type="text" name="rm111" id="rm111" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1204px; left:760px;"/>
<input type="text" name="r112" id="r112" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1229px; left:580px;"/>
<input type="text" name="rm112" id="rm112" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1229px; left:760px;"/>
<input type="text" name="r113" id="r113" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1254px; left:580px;"/>
<input type="text" name="rm113" id="rm113" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1254px; left:760px;"/>
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
<img src="<?php echo $jpg_source; ?>_str5.jpg" class="form-background" alt="<?php echo $jpg_title; ?>">
<!-- pasiva pokrac. -->
<input type="text" name="r114" id="r114" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:93px; left:580px;"/>
<input type="text" name="rm114" id="rm114" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:93px; left:760px;"/>
<input type="text" name="r115" id="r115" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:118px; left:580px;"/>
<input type="text" name="rm115" id="rm115" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:118px; left:760px;"/>
<input type="text" name="r116" id="r116" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:144px; left:580px;"/>
<input type="text" name="rm116" id="rm116" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:144px; left:760px;"/>
<input type="text" name="r117" id="r117" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:171px; left:580px;"/>
<input type="text" name="rm117" id="rm117" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:171px; left:760px;"/>
<input type="text" name="r118" id="r118" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:196px; left:580px;"/>
<input type="text" name="rm118" id="rm118" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:196px; left:760px;"/>
<input type="text" name="r119" id="r119" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:221px; left:580px;"/>
<input type="text" name="rm119" id="rm119" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:221px; left:760px;"/>
<input type="text" name="r120" id="r120" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:246px; left:580px;"/>
<input type="text" name="rm120" id="rm120" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:246px; left:760px;"/>
<input type="text" name="r121" id="r121" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:271px; left:580px;"/>
<input type="text" name="rm121" id="rm121" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:271px; left:760px;"/>
<span class="text-echo" style="top:299px; right:250px; font-size:14px;"><?php echo $r122; ?></span>
<span class="text-echo" style="top:299px; right:70px; font-size:14px;"><?php echo $rm122; ?></span>
<input type="text" name="r123" id="r123" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:321px; left:580px;"/>
<input type="text" name="rm123" id="rm123" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:321px; left:760px;"/>
<input type="text" name="r124" id="r124" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:345px; left:580px;"/>
<input type="text" name="rm124" id="rm124" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:345px; left:760px;"/>
<input type="text" name="r125" id="r125" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:370px; left:580px;"/>
<input type="text" name="rm125" id="rm125" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:370px; left:760px;"/>
<span class="text-echo" style="top:399px; right:250px; font-size:14px;"><?php echo $r126; ?></span>
<span class="text-echo" style="top:399px; right:70px; font-size:14px;"><?php echo $rm126; ?></span>
<input type="text" name="r127" id="r127" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:420px; left:580px;"/>
<input type="text" name="rm127" id="rm127" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:420px; left:760px;"/>
<input type="text" name="r128" id="r128" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:445px; left:580px;"/>
<input type="text" name="rm128" id="rm128" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:445px; left:760px;"/>
<input type="text" name="r129" id="r129" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:470px; left:580px;"/>
<input type="text" name="rm129" id="rm129" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:470px; left:760px;"/>
<input type="text" name="r130" id="r130" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:495px; left:580px;"/>
<input type="text" name="rm130" id="rm130" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:495px; left:760px;"/>
<span class="text-echo" style="top:523px; right:250px; font-size:14px;"><?php echo $r131; ?></span>
<span class="text-echo" style="top:523px; right:70px; font-size:14px;"><?php echo $rm131; ?></span>
<?php                     } ?>
<div class="navbar">
  <a href="#" onclick="editForm(1);" class="<?php echo $clas1; ?> toleft">1</a>
  <a href="#" onclick="editForm(2);" class="<?php echo $clas2; ?> toleft">2</a>
  <a href="#" onclick="editForm(3);" class="<?php echo $clas3; ?> toleft">3</a>
  <a href="#" onclick="editForm(4);" class="<?php echo $clas4; ?> toleft">4</a>
  <a href="#" onclick="editForm(5);" class="<?php echo $clas5; ?> toleft">5</a>
  <input type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-bottom-formsave">
</div>
</form>
</div><!-- #content -->
<?php
     }
//koniec uprav
?>

<?php
//pdf
if ( $copern == 10 )
{

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/vykfin_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/vykfin_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod".
" WHERE F$kli_vxcf"."_uctvykaz_fin204pod.oc = $cislo_oc  ORDER BY oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str1.jpg') )
{
$pdf->Image($jpg_source.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//obdobie k
$text=$datum;
$pdf->Cell(195,19," ","$rmc1",1,"L");
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(22,4,"$text","$rmc",1,"C");

//druh vykazu krizik
$text="x";
$pdf->Cell(195,24," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//ico
$text=$fir_ficox;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(195,52," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",1,"C");

//nazov subjektu
$text=$fir_fnaz;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=substr($fir_fnaz,31,30);;
//$text="Èý0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pravna forma
$text=$fir_uctt02;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//ulica a cislo
$text=$fir_fuli." ".$fir_fcdm;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,13.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//psc
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");
//obec
$text=$fir_fmes;
$textx="123456789abcdefghijklmnov";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");
//
$text=" ";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(49,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");

//email
$text=$fir_fem1;
$textx="0123456789abcdefghijklmnoprstuv";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//datum zostavenia
$daz= SkDatum($hlavicka->daz);
if ( $daz == '00.00.0000' ) $daz="";
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(40,5," ","$rmc1",0,"C");$pdf->Cell(22,4,"$daz","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str2.jpg') )
{
$pdf->Image($jpg_source.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->SetFont('arial','',8);
$pdf->Cell(195,27," ","$rmc1",1,"L");
$pdf->Cell(136,3," ","$rmc1",0,"R");$pdf->Cell(10,3,"$skutku","$rmc",1,"C");
$pdf->SetFont('arial','',10);

//aktiva
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
$rk01=$hlavicka->rk01; if ( $hlavicka->rk01 == 0 ) $rk01="";
$rk02=$hlavicka->rk02; if ( $hlavicka->rk02 == 0 ) $rk02="";
$rk03=$hlavicka->rk03; if ( $hlavicka->rk03 == 0 ) $rk03="";
$rk04=$hlavicka->rk04; if ( $hlavicka->rk04 == 0 ) $rk04="";
$rk05=$hlavicka->rk05; if ( $hlavicka->rk05 == 0 ) $rk05="";
$rk06=$hlavicka->rk06; if ( $hlavicka->rk06 == 0 ) $rk06="";
$rk07=$hlavicka->rk07; if ( $hlavicka->rk07 == 0 ) $rk07="";
$rk08=$hlavicka->rk08; if ( $hlavicka->rk08 == 0 ) $rk08="";
$rk09=$hlavicka->rk09; if ( $hlavicka->rk09 == 0 ) $rk09="";
$rk10=$hlavicka->rk10; if ( $hlavicka->rk10 == 0 ) $rk10="";
$rk11=$hlavicka->rk11; if ( $hlavicka->rk11 == 0 ) $rk11="";
$rk12=$hlavicka->rk12; if ( $hlavicka->rk12 == 0 ) $rk12="";
$rk13=$hlavicka->rk13; if ( $hlavicka->rk13 == 0 ) $rk13="";
$rk14=$hlavicka->rk14; if ( $hlavicka->rk14 == 0 ) $rk14="";
$rk15=$hlavicka->rk15; if ( $hlavicka->rk15 == 0 ) $rk15="";
$rk16=$hlavicka->rk16; if ( $hlavicka->rk16 == 0 ) $rk16="";
$rk17=$hlavicka->rk17; if ( $hlavicka->rk17 == 0 ) $rk17="";
$rk18=$hlavicka->rk18; if ( $hlavicka->rk18 == 0 ) $rk18="";
$rk19=$hlavicka->rk19; if ( $hlavicka->rk19 == 0 ) $rk19="";
$rk20=$hlavicka->rk20; if ( $hlavicka->rk20 == 0 ) $rk20="";
$rk21=$hlavicka->rk21; if ( $hlavicka->rk21 == 0 ) $rk21="";
$rk22=$hlavicka->rk22; if ( $hlavicka->rk22 == 0 ) $rk22="";
$rk23=$hlavicka->rk23; if ( $hlavicka->rk23 == 0 ) $rk23="";
$rk24=$hlavicka->rk24; if ( $hlavicka->rk24 == 0 ) $rk24="";
$rk25=$hlavicka->rk25; if ( $hlavicka->rk25 == 0 ) $rk25="";
$rk26=$hlavicka->rk26; if ( $hlavicka->rk26 == 0 ) $rk26="";
$rk27=$hlavicka->rk27; if ( $hlavicka->rk27 == 0 ) $rk27="";
$rk28=$hlavicka->rk28; if ( $hlavicka->rk28 == 0 ) $rk28="";
$rk29=$hlavicka->rk29; if ( $hlavicka->rk29 == 0 ) $rk29="";
$rk30=$hlavicka->rk30; if ( $hlavicka->rk30 == 0 ) $rk30="";
$rk31=$hlavicka->rk31; if ( $hlavicka->rk31 == 0 ) $rk31="";
$rk32=$hlavicka->rk32; if ( $hlavicka->rk32 == 0 ) $rk32="";
$rk33=$hlavicka->rk33; if ( $hlavicka->rk33 == 0 ) $rk33="";
$rk34=$hlavicka->rk34; if ( $hlavicka->rk34 == 0 ) $rk34="";
$rk35=$hlavicka->rk35; if ( $hlavicka->rk35 == 0 ) $rk35="";
$rk36=$hlavicka->rk36; if ( $hlavicka->rk36 == 0 ) $rk36="";
$rk37=$hlavicka->rk37; if ( $hlavicka->rk37 == 0 ) $rk37="";
$rk38=$hlavicka->rk38; if ( $hlavicka->rk38 == 0 ) $rk38="";
$rn01=$hlavicka->rn01; if ( $hlavicka->rn01 == 0 ) $rn01="";
$rn02=$hlavicka->rn02; if ( $hlavicka->rn02 == 0 ) $rn02="";
$rn03=$hlavicka->rn03; if ( $hlavicka->rn03 == 0 ) $rn03="";
$rn04=$hlavicka->rn04; if ( $hlavicka->rn04 == 0 ) $rn04="";
$rn05=$hlavicka->rn05; if ( $hlavicka->rn05 == 0 ) $rn05="";
$rn06=$hlavicka->rn06; if ( $hlavicka->rn06 == 0 ) $rn06="";
$rn07=$hlavicka->rn07; if ( $hlavicka->rn07 == 0 ) $rn07="";
$rn08=$hlavicka->rn08; if ( $hlavicka->rn08 == 0 ) $rn08="";
$rn09=$hlavicka->rn09; if ( $hlavicka->rn09 == 0 ) $rn09="";
$rn10=$hlavicka->rn10; if ( $hlavicka->rn10 == 0 ) $rn10="";
$rn11=$hlavicka->rn11; if ( $hlavicka->rn11 == 0 ) $rn11="";
$rn12=$hlavicka->rn12; if ( $hlavicka->rn12 == 0 ) $rn12="";
$rn13=$hlavicka->rn13; if ( $hlavicka->rn13 == 0 ) $rn13="";
$rn14=$hlavicka->rn14; if ( $hlavicka->rn14 == 0 ) $rn14="";
$rn15=$hlavicka->rn15; if ( $hlavicka->rn15 == 0 ) $rn15="";
$rn16=$hlavicka->rn16; if ( $hlavicka->rn16 == 0 ) $rn16="";
$rn17=$hlavicka->rn17; if ( $hlavicka->rn17 == 0 ) $rn17="";
$rn18=$hlavicka->rn18; if ( $hlavicka->rn18 == 0 ) $rn18="";
$rn19=$hlavicka->rn19; if ( $hlavicka->rn19 == 0 ) $rn19="";
$rn20=$hlavicka->rn20; if ( $hlavicka->rn20 == 0 ) $rn20="";
$rn21=$hlavicka->rn21; if ( $hlavicka->rn21 == 0 ) $rn21="";
$rn22=$hlavicka->rn22; if ( $hlavicka->rn22 == 0 ) $rn22="";
$rn23=$hlavicka->rn23; if ( $hlavicka->rn23 == 0 ) $rn23="";
$rn24=$hlavicka->rn24; if ( $hlavicka->rn24 == 0 ) $rn24="";
$rn25=$hlavicka->rn25; if ( $hlavicka->rn25 == 0 ) $rn25="";
$rn26=$hlavicka->rn26; if ( $hlavicka->rn26 == 0 ) $rn26="";
$rn27=$hlavicka->rn27; if ( $hlavicka->rn27 == 0 ) $rn27="";
$rn28=$hlavicka->rn28; if ( $hlavicka->rn28 == 0 ) $rn28="";
$rn29=$hlavicka->rn29; if ( $hlavicka->rn29 == 0 ) $rn29="";
$rn30=$hlavicka->rn30; if ( $hlavicka->rn30 == 0 ) $rn30="";
$rn31=$hlavicka->rn31; if ( $hlavicka->rn31 == 0 ) $rn31="";
$rn32=$hlavicka->rn32; if ( $hlavicka->rn32 == 0 ) $rn32="";
$rn33=$hlavicka->rn33; if ( $hlavicka->rn33 == 0 ) $rn33="";
$rn34=$hlavicka->rn34; if ( $hlavicka->rn34 == 0 ) $rn34="";
$rn35=$hlavicka->rn35; if ( $hlavicka->rn35 == 0 ) $rn35="";
$rn36=$hlavicka->rn36; if ( $hlavicka->rn36 == 0 ) $rn36="";
$rn37=$hlavicka->rn37; if ( $hlavicka->rn37 == 0 ) $rn37="";
$rn38=$hlavicka->rn38; if ( $hlavicka->rn38 == 0 ) $rn38="";
$rm01=$hlavicka->rm01; if ( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02; if ( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03; if ( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04; if ( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05; if ( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06; if ( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07; if ( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08; if ( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09; if ( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10; if ( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11; if ( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12; if ( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13; if ( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14; if ( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15; if ( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16; if ( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17; if ( $hlavicka->rm17 == 0 ) $rm17="";
$rm18=$hlavicka->rm18; if ( $hlavicka->rm18 == 0 ) $rm18="";
$rm19=$hlavicka->rm19; if ( $hlavicka->rm19 == 0 ) $rm19="";
$rm20=$hlavicka->rm20; if ( $hlavicka->rm20 == 0 ) $rm20="";
$rm21=$hlavicka->rm21; if ( $hlavicka->rm21 == 0 ) $rm21="";
$rm22=$hlavicka->rm22; if ( $hlavicka->rm22 == 0 ) $rm22="";
$rm23=$hlavicka->rm23; if ( $hlavicka->rm23 == 0 ) $rm23="";
$rm24=$hlavicka->rm24; if ( $hlavicka->rm24 == 0 ) $rm24="";
$rm25=$hlavicka->rm25; if ( $hlavicka->rm25 == 0 ) $rm25="";
$rm26=$hlavicka->rm26; if ( $hlavicka->rm26 == 0 ) $rm26="";
$rm27=$hlavicka->rm27; if ( $hlavicka->rm27 == 0 ) $rm27="";
$rm28=$hlavicka->rm28; if ( $hlavicka->rm28 == 0 ) $rm28="";
$rm29=$hlavicka->rm29; if ( $hlavicka->rm29 == 0 ) $rm29="";
$rm30=$hlavicka->rm30; if ( $hlavicka->rm30 == 0 ) $rm30="";
$rm31=$hlavicka->rm31; if ( $hlavicka->rm31 == 0 ) $rm31="";
$rm32=$hlavicka->rm32; if ( $hlavicka->rm32 == 0 ) $rm32="";
$rm33=$hlavicka->rm33; if ( $hlavicka->rm33 == 0 ) $rm33="";
$rm34=$hlavicka->rm34; if ( $hlavicka->rm34 == 0 ) $rm34="";
$rm35=$hlavicka->rm35; if ( $hlavicka->rm35 == 0 ) $rm35="";
$rm36=$hlavicka->rm36; if ( $hlavicka->rm36 == 0 ) $rm36="";
$rm37=$hlavicka->rm37; if ( $hlavicka->rm37 == 0 ) $rm37="";
$rm38=$hlavicka->rm38; if ( $hlavicka->rm38 == 0 ) $rm38="";
$pdf->Cell(195,23," ","$rmc1",1,"L");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r01","$rmc",0,"R");$pdf->Cell(18,6,"$rk01","$rmc",0,"R");
$pdf->Cell(18,6,"$rn01","$rmc",0,"R");$pdf->Cell(30,6,"$rm01","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r02","$rmc",0,"R");$pdf->Cell(18,6,"$rk02","$rmc",0,"R");
$pdf->Cell(18,6,"$rn02","$rmc",0,"R");$pdf->Cell(30,6,"$rm02","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r03","$rmc",0,"R");$pdf->Cell(18,5,"$rk03","$rmc",0,"R");
$pdf->Cell(18,5,"$rn03","$rmc",0,"R");$pdf->Cell(30,5,"$rm03","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r04","$rmc",0,"R");$pdf->Cell(18,6,"$rk04","$rmc",0,"R");
$pdf->Cell(18,6,"$rn04","$rmc",0,"R");$pdf->Cell(30,6,"$rm04","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r05","$rmc",0,"R");$pdf->Cell(18,6,"$rk05","$rmc",0,"R");
$pdf->Cell(18,6,"$rn05","$rmc",0,"R");$pdf->Cell(30,6,"$rm05","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r06","$rmc",0,"R");$pdf->Cell(18,5,"$rk06","$rmc",0,"R");
$pdf->Cell(18,5,"$rn06","$rmc",0,"R");$pdf->Cell(30,5,"$rm06","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r07","$rmc",0,"R");$pdf->Cell(18,6,"$rk07","$rmc",0,"R");
$pdf->Cell(18,6,"$rn07","$rmc",0,"R");$pdf->Cell(30,6,"$rm07","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r08","$rmc",0,"R");$pdf->Cell(18,6,"$rk08","$rmc",0,"R");
$pdf->Cell(18,6,"$rn08","$rmc",0,"R");$pdf->Cell(30,6,"$rm08","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r09","$rmc",0,"R");$pdf->Cell(18,5,"$rk09","$rmc",0,"R");
$pdf->Cell(18,5,"$rn09","$rmc",0,"R");$pdf->Cell(30,5,"$rm09","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r10","$rmc",0,"R");$pdf->Cell(18,6,"$rk10","$rmc",0,"R");
$pdf->Cell(18,6,"$rn10","$rmc",0,"R");$pdf->Cell(30,6,"$rm10","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r11","$rmc",0,"R");$pdf->Cell(18,6,"$rk11","$rmc",0,"R");
$pdf->Cell(18,6,"$rn11","$rmc",0,"R");$pdf->Cell(30,6,"$rm11","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r12","$rmc",0,"R");$pdf->Cell(18,5,"$rk12","$rmc",0,"R");
$pdf->Cell(18,5,"$rn12","$rmc",0,"R");$pdf->Cell(30,5,"$rm12","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r13","$rmc",0,"R");$pdf->Cell(18,6,"$rk13","$rmc",0,"R");
$pdf->Cell(18,6,"$rn13","$rmc",0,"R");$pdf->Cell(30,6,"$rm13","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r14","$rmc",0,"R");$pdf->Cell(18,5,"$rk14","$rmc",0,"R");
$pdf->Cell(18,5,"$rn14","$rmc",0,"R");$pdf->Cell(30,5,"$rm14","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r15","$rmc",0,"R");$pdf->Cell(18,6,"$rk15","$rmc",0,"R");
$pdf->Cell(18,6,"$rn15","$rmc",0,"R");$pdf->Cell(30,6,"$rm15","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,7,"$r16","$rmc",0,"R");$pdf->Cell(18,7,"$rk16","$rmc",0,"R");
$pdf->Cell(18,7,"$rn16","$rmc",0,"R");$pdf->Cell(30,7,"$rm16","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r17","$rmc",0,"R");$pdf->Cell(18,5,"$rk17","$rmc",0,"R");
$pdf->Cell(18,5,"$rn17","$rmc",0,"R");$pdf->Cell(30,5,"$rm17","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r18","$rmc",0,"R");$pdf->Cell(18,6,"$rk18","$rmc",0,"R");
$pdf->Cell(18,6,"$rn18","$rmc",0,"R");$pdf->Cell(30,6,"$rm18","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r19","$rmc",0,"R");$pdf->Cell(18,6,"$rk19","$rmc",0,"R");
$pdf->Cell(18,6,"$rn19","$rmc",0,"R");$pdf->Cell(30,6,"$rm19","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r20","$rmc",0,"R");$pdf->Cell(18,5,"$rk20","$rmc",0,"R");
$pdf->Cell(18,5,"$rn20","$rmc",0,"R");$pdf->Cell(30,5,"$rm20","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r21","$rmc",0,"R");$pdf->Cell(18,6,"$rk21","$rmc",0,"R");
$pdf->Cell(18,6,"$rn21","$rmc",0,"R");$pdf->Cell(30,6,"$rm21","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r22","$rmc",0,"R");$pdf->Cell(18,6,"$rk22","$rmc",0,"R");
$pdf->Cell(18,6,"$rn22","$rmc",0,"R");$pdf->Cell(30,6,"$rm22","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r23","$rmc",0,"R");$pdf->Cell(18,5,"$rk23","$rmc",0,"R");
$pdf->Cell(18,5,"$rn23","$rmc",0,"R");$pdf->Cell(30,5,"$rm23","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r24","$rmc",0,"R");$pdf->Cell(18,6,"$rk24","$rmc",0,"R");
$pdf->Cell(18,6,"$rn24","$rmc",0,"R");$pdf->Cell(30,6,"$rm24","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r25","$rmc",0,"R");$pdf->Cell(18,6,"$rk25","$rmc",0,"R");
$pdf->Cell(18,6,"$rn25","$rmc",0,"R");$pdf->Cell(30,6,"$rm25","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r26","$rmc",0,"R");$pdf->Cell(18,5,"$rk26","$rmc",0,"R");
$pdf->Cell(18,5,"$rn26","$rmc",0,"R");$pdf->Cell(30,5,"$rm26","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r27","$rmc",0,"R");$pdf->Cell(18,6,"$rk27","$rmc",0,"R");
$pdf->Cell(18,6,"$rn27","$rmc",0,"R");$pdf->Cell(30,6,"$rm27","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r28","$rmc",0,"R");$pdf->Cell(18,6,"$rk28","$rmc",0,"R");
$pdf->Cell(18,6,"$rn28","$rmc",0,"R");$pdf->Cell(30,6,"$rm28","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r29","$rmc",0,"R");$pdf->Cell(18,6,"$rk29","$rmc",0,"R");
$pdf->Cell(18,6,"$rn29","$rmc",0,"R");$pdf->Cell(30,6,"$rm29","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r30","$rmc",0,"R");$pdf->Cell(18,5,"$rk30","$rmc",0,"R");
$pdf->Cell(18,5,"$rn30","$rmc",0,"R");$pdf->Cell(30,5,"$rm30","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r31","$rmc",0,"R");$pdf->Cell(18,6,"$rk31","$rmc",0,"R");
$pdf->Cell(18,6,"$rn31","$rmc",0,"R");$pdf->Cell(30,6,"$rm31","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r32","$rmc",0,"R");$pdf->Cell(18,6,"$rk32","$rmc",0,"R");
$pdf->Cell(18,6,"$rn32","$rmc",0,"R");$pdf->Cell(30,6,"$rm32","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r33","$rmc",0,"R");$pdf->Cell(18,5,"$rk33","$rmc",0,"R");
$pdf->Cell(18,5,"$rn33","$rmc",0,"R");$pdf->Cell(30,5,"$rm33","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r34","$rmc",0,"R");$pdf->Cell(18,6,"$rk34","$rmc",0,"R");
$pdf->Cell(18,6,"$rn34","$rmc",0,"R");$pdf->Cell(30,6,"$rm34","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r35","$rmc",0,"R");$pdf->Cell(18,6,"$rk35","$rmc",0,"R");
$pdf->Cell(18,6,"$rn35","$rmc",0,"R");$pdf->Cell(30,6,"$rm35","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r36","$rmc",0,"R");$pdf->Cell(18,5,"$rk36","$rmc",0,"R");
$pdf->Cell(18,5,"$rn36","$rmc",0,"R");$pdf->Cell(30,5,"$rm36","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r37","$rmc",0,"R");$pdf->Cell(18,6,"$rk37","$rmc",0,"R");
$pdf->Cell(18,6,"$rn37","$rmc",0,"R");$pdf->Cell(30,6,"$rm37","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r38","$rmc",0,"R");$pdf->Cell(18,5,"$rk38","$rmc",0,"R");
$pdf->Cell(18,5,"$rn38","$rmc",0,"R");$pdf->Cell(30,5,"$rm38","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(180);
$pdf->Cell(20,6,"2/$total_strana","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str3.jpg') )
{
$pdf->Image($jpg_source.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//aktiva pokrac.
$r39=$hlavicka->r39; if ( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40; if ( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41; if ( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42; if ( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43; if ( $hlavicka->r43 == 0 ) $r43="";
$r44=$hlavicka->r44; if ( $hlavicka->r44 == 0 ) $r44="";
$r45=$hlavicka->r45; if ( $hlavicka->r45 == 0 ) $r45="";
$r46=$hlavicka->r46; if ( $hlavicka->r46 == 0 ) $r46="";
$r47=$hlavicka->r47; if ( $hlavicka->r47 == 0 ) $r47="";
$r48=$hlavicka->r48; if ( $hlavicka->r48 == 0 ) $r48="";
$r49=$hlavicka->r49; if ( $hlavicka->r49 == 0 ) $r49="";
$r50=$hlavicka->r50; if ( $hlavicka->r50 == 0 ) $r50="";
$r51=$hlavicka->r51; if ( $hlavicka->r51 == 0 ) $r51="";
$r52=$hlavicka->r52; if ( $hlavicka->r52 == 0 ) $r52="";
$r53=$hlavicka->r53; if ( $hlavicka->r53 == 0 ) $r53="";
$r54=$hlavicka->r54; if ( $hlavicka->r54 == 0 ) $r54="";
$r55=$hlavicka->r55; if ( $hlavicka->r55 == 0 ) $r55="";
$r56=$hlavicka->r56; if ( $hlavicka->r56 == 0 ) $r56="";
$r57=$hlavicka->r57; if ( $hlavicka->r57 == 0 ) $r57="";
$r58=$hlavicka->r58; if ( $hlavicka->r58 == 0 ) $r58="";
$r59=$hlavicka->r59; if ( $hlavicka->r59 == 0 ) $r59="";
$r60=$hlavicka->r60; if ( $hlavicka->r60 == 0 ) $r60="";
$r61=$hlavicka->r61; if ( $hlavicka->r61 == 0 ) $r61="";
$r62=$hlavicka->r62; if ( $hlavicka->r62 == 0 ) $r62="";
$r63=$hlavicka->r63; if ( $hlavicka->r63 == 0 ) $r63="";
$r64=$hlavicka->r64; if ( $hlavicka->r64 == 0 ) $r64="";
$r65=$hlavicka->r65; if ( $hlavicka->r65 == 0 ) $r65="";
$r66=$hlavicka->r66; if ( $hlavicka->r66 == 0 ) $r66="";
$r67=$hlavicka->r67; if ( $hlavicka->r67 == 0 ) $r67="";
$r68=$hlavicka->r68; if ( $hlavicka->r68 == 0 ) $r68="";
$rk39=$hlavicka->rk39; if ( $hlavicka->rk39 == 0 ) $rk39="";
$rk40=$hlavicka->rk40; if ( $hlavicka->rk40 == 0 ) $rk40="";
$rk41=$hlavicka->rk41; if ( $hlavicka->rk41 == 0 ) $rk41="";
$rk42=$hlavicka->rk42; if ( $hlavicka->rk42 == 0 ) $rk42="";
$rk43=$hlavicka->rk43; if ( $hlavicka->rk43 == 0 ) $rk43="";
$rk44=$hlavicka->rk44; if ( $hlavicka->rk44 == 0 ) $rk44="";
$rk45=$hlavicka->rk45; if ( $hlavicka->rk45 == 0 ) $rk45="";
$rk46=$hlavicka->rk46; if ( $hlavicka->rk46 == 0 ) $rk46="";
$rk47=$hlavicka->rk47; if ( $hlavicka->rk47 == 0 ) $rk47="";
$rk48=$hlavicka->rk48; if ( $hlavicka->rk48 == 0 ) $rk48="";
$rk49=$hlavicka->rk49; if ( $hlavicka->rk49 == 0 ) $rk49="";
$rk50=$hlavicka->rk50; if ( $hlavicka->rk50 == 0 ) $rk50="";
$rk51=$hlavicka->rk51; if ( $hlavicka->rk51 == 0 ) $rk51="";
$rk52=$hlavicka->rk52; if ( $hlavicka->rk52 == 0 ) $rk52="";
$rk53=$hlavicka->rk53; if ( $hlavicka->rk53 == 0 ) $rk53="";
$rk54=$hlavicka->rk54; if ( $hlavicka->rk54 == 0 ) $rk54="";
$rk55=$hlavicka->rk55; if ( $hlavicka->rk55 == 0 ) $rk55="";
$rk56=$hlavicka->rk56; if ( $hlavicka->rk56 == 0 ) $rk56="";
$rk57=$hlavicka->rk57; if ( $hlavicka->rk57 == 0 ) $rk57="";
$rk58=$hlavicka->rk58; if ( $hlavicka->rk58 == 0 ) $rk58="";
$rk59=$hlavicka->rk59; if ( $hlavicka->rk59 == 0 ) $rk59="";
$rk60=$hlavicka->rk60; if ( $hlavicka->rk60 == 0 ) $rk60="";
$rk61=$hlavicka->rk61; if ( $hlavicka->rk61 == 0 ) $rk61="";
$rk62=$hlavicka->rk62; if ( $hlavicka->rk62 == 0 ) $rk62="";
$rk63=$hlavicka->rk63; if ( $hlavicka->rk63 == 0 ) $rk63="";
$rk64=$hlavicka->rk64; if ( $hlavicka->rk64 == 0 ) $rk64="";
$rk65=$hlavicka->rk65; if ( $hlavicka->rk65 == 0 ) $rk65="";
$rk66=$hlavicka->rk66; if ( $hlavicka->rk66 == 0 ) $rk66="";
$rk67=$hlavicka->rk67; if ( $hlavicka->rk67 == 0 ) $rk67="";
$rk68=$hlavicka->rk68; if ( $hlavicka->rk68 == 0 ) $rk68="";
$rn39=$hlavicka->rn39; if ( $hlavicka->rn39 == 0 ) $rn39="";
$rn40=$hlavicka->rn40; if ( $hlavicka->rn40 == 0 ) $rn40="";
$rn41=$hlavicka->rn41; if ( $hlavicka->rn41 == 0 ) $rn41="";
$rn42=$hlavicka->rn42; if ( $hlavicka->rn42 == 0 ) $rn42="";
$rn43=$hlavicka->rn43; if ( $hlavicka->rn43 == 0 ) $rn43="";
$rn44=$hlavicka->rn44; if ( $hlavicka->rn44 == 0 ) $rn44="";
$rn45=$hlavicka->rn45; if ( $hlavicka->rn45 == 0 ) $rn45="";
$rn46=$hlavicka->rn46; if ( $hlavicka->rn46 == 0 ) $rn46="";
$rn47=$hlavicka->rn47; if ( $hlavicka->rn47 == 0 ) $rn47="";
$rn48=$hlavicka->rn48; if ( $hlavicka->rn48 == 0 ) $rn48="";
$rn49=$hlavicka->rn49; if ( $hlavicka->rn49 == 0 ) $rn49="";
$rn50=$hlavicka->rn50; if ( $hlavicka->rn50 == 0 ) $rn50="";
$rn51=$hlavicka->rn51; if ( $hlavicka->rn51 == 0 ) $rn51="";
$rn52=$hlavicka->rn52; if ( $hlavicka->rn52 == 0 ) $rn52="";
$rn53=$hlavicka->rn53; if ( $hlavicka->rn53 == 0 ) $rn53="";
$rn54=$hlavicka->rn54; if ( $hlavicka->rn54 == 0 ) $rn54="";
$rn55=$hlavicka->rn55; if ( $hlavicka->rn55 == 0 ) $rn55="";
$rn56=$hlavicka->rn56; if ( $hlavicka->rn56 == 0 ) $rn56="";
$rn57=$hlavicka->rn57; if ( $hlavicka->rn57 == 0 ) $rn57="";
$rn58=$hlavicka->rn58; if ( $hlavicka->rn58 == 0 ) $rn58="";
$rn59=$hlavicka->rn59; if ( $hlavicka->rn59 == 0 ) $rn59="";
$rn60=$hlavicka->rn60; if ( $hlavicka->rn60 == 0 ) $rn60="";
$rn61=$hlavicka->rn61; if ( $hlavicka->rn61 == 0 ) $rn61="";
$rn62=$hlavicka->rn62; if ( $hlavicka->rn62 == 0 ) $rn62="";
$rn63=$hlavicka->rn63; if ( $hlavicka->rn63 == 0 ) $rn63="";
$rn64=$hlavicka->rn64; if ( $hlavicka->rn64 == 0 ) $rn64="";
$rn65=$hlavicka->rn65; if ( $hlavicka->rn65 == 0 ) $rn65="";
$rn66=$hlavicka->rn66; if ( $hlavicka->rn66 == 0 ) $rn66="";
$rn67=$hlavicka->rn67; if ( $hlavicka->rn67 == 0 ) $rn67="";
$rn68=$hlavicka->rn68; if ( $hlavicka->rn68 == 0 ) $rn68="";
$rm39=$hlavicka->rm39; if ( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40; if ( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41; if ( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42; if ( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43; if ( $hlavicka->rm43 == 0 ) $rm43="";
$rm44=$hlavicka->rm44; if ( $hlavicka->rm44 == 0 ) $rm44="";
$rm45=$hlavicka->rm45; if ( $hlavicka->rm45 == 0 ) $rm45="";
$rm46=$hlavicka->rm46; if ( $hlavicka->rm46 == 0 ) $rm46="";
$rm47=$hlavicka->rm47; if ( $hlavicka->rm47 == 0 ) $rm47="";
$rm48=$hlavicka->rm48; if ( $hlavicka->rm48 == 0 ) $rm48="";
$rm49=$hlavicka->rm49; if ( $hlavicka->rm49 == 0 ) $rm49="";
$rm50=$hlavicka->rm50; if ( $hlavicka->rm50 == 0 ) $rm50="";
$rm51=$hlavicka->rm51; if ( $hlavicka->rm51 == 0 ) $rm51="";
$rm52=$hlavicka->rm52; if ( $hlavicka->rm52 == 0 ) $rm52="";
$rm53=$hlavicka->rm53; if ( $hlavicka->rm53 == 0 ) $rm53="";
$rm54=$hlavicka->rm54; if ( $hlavicka->rm54 == 0 ) $rm54="";
$rm55=$hlavicka->rm55; if ( $hlavicka->rm55 == 0 ) $rm55="";
$rm56=$hlavicka->rm56; if ( $hlavicka->rm56 == 0 ) $rm56="";
$rm57=$hlavicka->rm57; if ( $hlavicka->rm57 == 0 ) $rm57="";
$rm58=$hlavicka->rm58; if ( $hlavicka->rm58 == 0 ) $rm58="";
$rm59=$hlavicka->rm59; if ( $hlavicka->rm59 == 0 ) $rm59="";
$rm60=$hlavicka->rm60; if ( $hlavicka->rm60 == 0 ) $rm60="";
$rm61=$hlavicka->rm61; if ( $hlavicka->rm61 == 0 ) $rm61="";
$rm62=$hlavicka->rm62; if ( $hlavicka->rm62 == 0 ) $rm62="";
$rm63=$hlavicka->rm63; if ( $hlavicka->rm63 == 0 ) $rm63="";
$rm64=$hlavicka->rm64; if ( $hlavicka->rm64 == 0 ) $rm64="";
$rm65=$hlavicka->rm65; if ( $hlavicka->rm65 == 0 ) $rm65="";
$rm66=$hlavicka->rm66; if ( $hlavicka->rm66 == 0 ) $rm66="";
$rm67=$hlavicka->rm67; if ( $hlavicka->rm67 == 0 ) $rm67="";
$rm68=$hlavicka->rm68; if ( $hlavicka->rm68 == 0 ) $rm68="";
$pdf->Cell(195,5," ","$rmc1",1,"L");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r39","$rmc",0,"R");$pdf->Cell(18,6,"$rk39","$rmc",0,"R");
$pdf->Cell(18,6,"$rn39","$rmc",0,"R");$pdf->Cell(30,6,"$rm39","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r40","$rmc",0,"R");$pdf->Cell(18,6,"$rk40","$rmc",0,"R");
$pdf->Cell(18,6,"$rn40","$rmc",0,"R");$pdf->Cell(30,6,"$rm40","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r41","$rmc",0,"R");$pdf->Cell(18,6,"$rk41","$rmc",0,"R");
$pdf->Cell(18,6,"$rn41","$rmc",0,"R");$pdf->Cell(30,6,"$rm41","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r42","$rmc",0,"R");$pdf->Cell(18,5,"$rk42","$rmc",0,"R");
$pdf->Cell(18,5,"$rn42","$rmc",0,"R");$pdf->Cell(30,5,"$rm42","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r43","$rmc",0,"R");$pdf->Cell(18,6,"$rk43","$rmc",0,"R");
$pdf->Cell(18,6,"$rn43","$rmc",0,"R");$pdf->Cell(30,6,"$rm43","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r44","$rmc",0,"R");$pdf->Cell(18,6,"$rk44","$rmc",0,"R");
$pdf->Cell(18,6,"$rn44","$rmc",0,"R");$pdf->Cell(30,6,"$rm44","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r45","$rmc",0,"R");$pdf->Cell(18,6,"$rk45","$rmc",0,"R");
$pdf->Cell(18,6,"$rn45","$rmc",0,"R");$pdf->Cell(30,6,"$rm45","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r46","$rmc",0,"R");$pdf->Cell(18,6,"$rk46","$rmc",0,"R");
$pdf->Cell(18,6,"$rn46","$rmc",0,"R");$pdf->Cell(30,6,"$rm46","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r47","$rmc",0,"R");$pdf->Cell(18,6,"$rk47","$rmc",0,"R");
$pdf->Cell(18,6,"$rn47","$rmc",0,"R");$pdf->Cell(30,6,"$rm47","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r48","$rmc",0,"R");$pdf->Cell(18,6,"$rk48","$rmc",0,"R");
$pdf->Cell(18,6,"$rn48","$rmc",0,"R");$pdf->Cell(30,6,"$rm48","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r49","$rmc",0,"R");$pdf->Cell(18,5,"$rk49","$rmc",0,"R");
$pdf->Cell(18,5,"$rn49","$rmc",0,"R");$pdf->Cell(30,5,"$rm49","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r50","$rmc",0,"R");$pdf->Cell(18,6,"$rk50","$rmc",0,"R");
$pdf->Cell(18,6,"$rn50","$rmc",0,"R");$pdf->Cell(30,6,"$rm50","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r51","$rmc",0,"R");$pdf->Cell(18,6,"$rk51","$rmc",0,"R");
$pdf->Cell(18,6,"$rn51","$rmc",0,"R");$pdf->Cell(30,6,"$rm51","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r52","$rmc",0,"R");$pdf->Cell(18,6,"$rk52","$rmc",0,"R");
$pdf->Cell(18,6,"$rn52","$rmc",0,"R");$pdf->Cell(30,6,"$rm52","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r53","$rmc",0,"R");$pdf->Cell(18,6,"$rk53","$rmc",0,"R");
$pdf->Cell(18,6,"$rn53","$rmc",0,"R");$pdf->Cell(30,6,"$rm53","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r54","$rmc",0,"R");$pdf->Cell(18,6,"$rk54","$rmc",0,"R");
$pdf->Cell(18,6,"$rn54","$rmc",0,"R");$pdf->Cell(30,6,"$rm54","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r55","$rmc",0,"R");$pdf->Cell(18,5,"$rk55","$rmc",0,"R");
$pdf->Cell(18,5,"$rn55","$rmc",0,"R");$pdf->Cell(30,5,"$rm55","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r56","$rmc",0,"R");$pdf->Cell(18,6,"$rk56","$rmc",0,"R");
$pdf->Cell(18,6,"$rn56","$rmc",0,"R");$pdf->Cell(30,6,"$rm56","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r57","$rmc",0,"R");$pdf->Cell(18,6,"$rk57","$rmc",0,"R");
$pdf->Cell(18,6,"$rn57","$rmc",0,"R");$pdf->Cell(30,6,"$rm57","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r58","$rmc",0,"R");$pdf->Cell(18,6,"$rk58","$rmc",0,"R");
$pdf->Cell(18,6,"$rn58","$rmc",0,"R");$pdf->Cell(30,6,"$rm58","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r59","$rmc",0,"R");$pdf->Cell(18,5,"$rk59","$rmc",0,"R");
$pdf->Cell(18,5,"$rn59","$rmc",0,"R");$pdf->Cell(30,5,"$rm59","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r60","$rmc",0,"R");$pdf->Cell(18,6,"$rk60","$rmc",0,"R");
$pdf->Cell(18,6,"$rn60","$rmc",0,"R");$pdf->Cell(30,6,"$rm60","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r61","$rmc",0,"R");$pdf->Cell(18,6,"$rk61","$rmc",0,"R");
$pdf->Cell(18,6,"$rn61","$rmc",0,"R");$pdf->Cell(30,6,"$rm61","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r62","$rmc",0,"R");$pdf->Cell(18,5,"$rk62","$rmc",0,"R");
$pdf->Cell(18,5,"$rn62","$rmc",0,"R");$pdf->Cell(30,5,"$rm62","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r63","$rmc",0,"R");$pdf->Cell(18,6,"$rk63","$rmc",0,"R");
$pdf->Cell(18,6,"$rn63","$rmc",0,"R");$pdf->Cell(30,6,"$rm63","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r64","$rmc",0,"R");$pdf->Cell(18,5,"$rk64","$rmc",0,"R");
$pdf->Cell(18,5,"$rn64","$rmc",0,"R");$pdf->Cell(30,5,"$rm64","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r65","$rmc",0,"R");$pdf->Cell(18,6,"$rk65","$rmc",0,"R");
$pdf->Cell(18,6,"$rn65","$rmc",0,"R");$pdf->Cell(30,6,"$rm65","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r66","$rmc",0,"R");$pdf->Cell(18,6,"$rk66","$rmc",0,"R");
$pdf->Cell(18,6,"$rn66","$rmc",0,"R");$pdf->Cell(30,6,"$rm66","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r67","$rmc",0,"R");$pdf->Cell(18,5,"$rk67","$rmc",0,"R");
$pdf->Cell(18,5,"$rn67","$rmc",0,"R");$pdf->Cell(30,5,"$rm67","$rmc",1,"R");
$pdf->Cell(107,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r68","$rmc",0,"R");$pdf->Cell(18,6,"$rk68","$rmc",0,"R");
$pdf->Cell(18,6,"$rn68","$rmc",0,"R");$pdf->Cell(30,6,"$rm68","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(180);
$pdf->Cell(20,6,"3/$total_strana","$rmc",1,"R");
                                       }

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str4.jpg') )
{
$pdf->Image($jpg_source.'_str4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->SetFont('arial','',8);
$pdf->Cell(195,7," ","$rmc1",1,"L");
$pdf->Cell(134,3," ","$rmc1",0,"R");$pdf->Cell(10,3,"$skutku","$rmc",1,"C");
$pdf->SetFont('arial','',10);

$r69=$hlavicka->r69; if ( $hlavicka->r69 == 0 ) $r69="";
$r70=$hlavicka->r70; if ( $hlavicka->r70 == 0 ) $r70="";
$r71=$hlavicka->r71; if ( $hlavicka->r71 == 0 ) $r71="";
$r72=$hlavicka->r72; if ( $hlavicka->r72 == 0 ) $r72="";
$r73=$hlavicka->r73; if ( $hlavicka->r73 == 0 ) $r73="";
$r74=$hlavicka->r74; if ( $hlavicka->r74 == 0 ) $r74="";
$r75=$hlavicka->r75; if ( $hlavicka->r75 == 0 ) $r75="";
$r76=$hlavicka->r76; if ( $hlavicka->r76 == 0 ) $r76="";
$r77=$hlavicka->r77; if ( $hlavicka->r77 == 0 ) $r77="";
$r78=$hlavicka->r78; if ( $hlavicka->r78 == 0 ) $r78="";
$r79=$hlavicka->r79; if ( $hlavicka->r79 == 0 ) $r79="";
$r80=$hlavicka->r80; if ( $hlavicka->r80 == 0 ) $r80="";
$r81=$hlavicka->r81; if ( $hlavicka->r81 == 0 ) $r81="";
$r82=$hlavicka->r82; if ( $hlavicka->r82 == 0 ) $r82="";
$r83=$hlavicka->r83; if ( $hlavicka->r83 == 0 ) $r83="";
$r84=$hlavicka->r84; if ( $hlavicka->r84 == 0 ) $r84="";
$r85=$hlavicka->r85; if ( $hlavicka->r85 == 0 ) $r85="";
$r86=$hlavicka->r86; if ( $hlavicka->r86 == 0 ) $r86="";
$r87=$hlavicka->r87; if ( $hlavicka->r87 == 0 ) $r87="";
$r88=$hlavicka->r88; if ( $hlavicka->r88 == 0 ) $r88="";
$r89=$hlavicka->r89; if ( $hlavicka->r89 == 0 ) $r89="";
$r90=$hlavicka->r90; if ( $hlavicka->r90 == 0 ) $r90="";
$r91=$hlavicka->r91; if ( $hlavicka->r91 == 0 ) $r91="";
$r92=$hlavicka->r92; if ( $hlavicka->r92 == 0 ) $r92="";
$r93=$hlavicka->r93; if ( $hlavicka->r93 == 0 ) $r93="";
$r94=$hlavicka->r94; if ( $hlavicka->r94 == 0 ) $r94="";
$r95=$hlavicka->r95; if ( $hlavicka->r95 == 0 ) $r95="";
$r96=$hlavicka->r96; if ( $hlavicka->r96 == 0 ) $r96="";
$r97=$hlavicka->r97; if ( $hlavicka->r97 == 0 ) $r97="";
$r98=$hlavicka->r98; if ( $hlavicka->r98 == 0 ) $r98="";
$r99=$hlavicka->r99; if ( $hlavicka->r99 == 0 ) $r99="";
$r100=$hlavicka->r100; if ( $hlavicka->r100 == 0 ) $r100="";
$r101=$hlavicka->r101; if ( $hlavicka->r101 == 0 ) $r101="";
$r102=$hlavicka->r102; if ( $hlavicka->r102 == 0 ) $r102="";
$r103=$hlavicka->r103; if ( $hlavicka->r103 == 0 ) $r103="";
$r104=$hlavicka->r104; if ( $hlavicka->r104 == 0 ) $r104="";
$r105=$hlavicka->r105; if ( $hlavicka->r105 == 0 ) $r105="";
$r106=$hlavicka->r106; if ( $hlavicka->r106 == 0 ) $r106="";
$r107=$hlavicka->r107; if ( $hlavicka->r107 == 0 ) $r107="";
$r108=$hlavicka->r108; if ( $hlavicka->r108 == 0 ) $r108="";
$r109=$hlavicka->r109; if ( $hlavicka->r109 == 0 ) $r109="";
$r110=$hlavicka->r110; if ( $hlavicka->r110 == 0 ) $r110="";
$r111=$hlavicka->r111; if ( $hlavicka->r111 == 0 ) $r111="";
$r112=$hlavicka->r112; if ( $hlavicka->r112 == 0 ) $r112="";
$r113=$hlavicka->r113; if ( $hlavicka->r113 == 0 ) $r113="";
$rm69=$hlavicka->rm69; if ( $hlavicka->rm69 == 0 ) $rm69="";
$rm70=$hlavicka->rm70; if ( $hlavicka->rm70 == 0 ) $rm70="";
$rm71=$hlavicka->rm71; if ( $hlavicka->rm71 == 0 ) $rm71="";
$rm72=$hlavicka->rm72; if ( $hlavicka->rm72 == 0 ) $rm72="";
$rm73=$hlavicka->rm73; if ( $hlavicka->rm73 == 0 ) $rm73="";
$rm74=$hlavicka->rm74; if ( $hlavicka->rm74 == 0 ) $rm74="";
$rm75=$hlavicka->rm75; if ( $hlavicka->rm75 == 0 ) $rm75="";
$rm76=$hlavicka->rm76; if ( $hlavicka->rm76 == 0 ) $rm76="";
$rm77=$hlavicka->rm77; if ( $hlavicka->rm77 == 0 ) $rm77="";
$rm78=$hlavicka->rm78; if ( $hlavicka->rm78 == 0 ) $rm78="";
$rm79=$hlavicka->rm79; if ( $hlavicka->rm79 == 0 ) $rm79="";
$rm80=$hlavicka->rm80; if ( $hlavicka->rm80 == 0 ) $rm80="";
$rm81=$hlavicka->rm81; if ( $hlavicka->rm81 == 0 ) $rm81="";
$rm82=$hlavicka->rm82; if ( $hlavicka->rm82 == 0 ) $rm82="";
$rm83=$hlavicka->rm83; if ( $hlavicka->rm83 == 0 ) $rm83="";
$rm84=$hlavicka->rm84; if ( $hlavicka->rm84 == 0 ) $rm84="";
$rm85=$hlavicka->rm85; if ( $hlavicka->rm85 == 0 ) $rm85="";
$rm86=$hlavicka->rm86; if ( $hlavicka->rm86 == 0 ) $rm86="";
$rm87=$hlavicka->rm87; if ( $hlavicka->rm87 == 0 ) $rm87="";
$rm88=$hlavicka->rm88; if ( $hlavicka->rm88 == 0 ) $rm88="";
$rm89=$hlavicka->rm89; if ( $hlavicka->rm89 == 0 ) $rm89="";
$rm90=$hlavicka->rm90; if ( $hlavicka->rm90 == 0 ) $rm90="";
$rm91=$hlavicka->rm91; if ( $hlavicka->rm91 == 0 ) $rm91="";
$rm92=$hlavicka->rm92; if ( $hlavicka->rm92 == 0 ) $rm92="";
$rm93=$hlavicka->rm93; if ( $hlavicka->rm93 == 0 ) $rm93="";
$rm94=$hlavicka->rm94; if ( $hlavicka->rm94 == 0 ) $rm94="";
$rm95=$hlavicka->rm95; if ( $hlavicka->rm95 == 0 ) $rm95="";
$rm96=$hlavicka->rm96; if ( $hlavicka->rm96 == 0 ) $rm96="";
$rm97=$hlavicka->rm97; if ( $hlavicka->rm97 == 0 ) $rm97="";
$rm98=$hlavicka->rm98; if ( $hlavicka->rm98 == 0 ) $rm98="";
$rm99=$hlavicka->rm99; if ( $hlavicka->rm99 == 0 ) $rm99="";
$rm100=$hlavicka->rm100; if ( $hlavicka->rm100 == 0 ) $rm100="";
$rm101=$hlavicka->rm101; if ( $hlavicka->rm101 == 0 ) $rm101="";
$rm102=$hlavicka->rm102; if ( $hlavicka->rm102 == 0 ) $rm102="";
$rm103=$hlavicka->rm103; if ( $hlavicka->rm103 == 0 ) $rm103="";
$rm104=$hlavicka->rm104; if ( $hlavicka->rm104 == 0 ) $rm104="";
$rm105=$hlavicka->rm105; if ( $hlavicka->rm105 == 0 ) $rm105="";
$rm106=$hlavicka->rm106; if ( $hlavicka->rm106 == 0 ) $rm106="";
$rm107=$hlavicka->rm107; if ( $hlavicka->rm107 == 0 ) $rm107="";
$rm108=$hlavicka->rm108; if ( $hlavicka->rm108 == 0 ) $rm108="";
$rm109=$hlavicka->rm109; if ( $hlavicka->rm109 == 0 ) $rm109="";
$rm110=$hlavicka->rm110; if ( $hlavicka->rm110 == 0 ) $rm110="";
$rm111=$hlavicka->rm111; if ( $hlavicka->rm111 == 0 ) $rm111="";
$rm112=$hlavicka->rm112; if ( $hlavicka->rm112 == 0 ) $rm112="";
$rm113=$hlavicka->rm113; if ( $hlavicka->rm113 == 0 ) $rm113="";
$pdf->Cell(195,11," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r69","$rmc",0,"R");$pdf->Cell(39,6,"$rm69","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r70","$rmc",0,"R");$pdf->Cell(39,5,"$rm70","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r71","$rmc",0,"R");$pdf->Cell(39,6,"$rm71","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r72","$rmc",0,"R");$pdf->Cell(39,6,"$rm72","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r73","$rmc",0,"R");$pdf->Cell(39,5,"$rm73","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r74","$rmc",0,"R");$pdf->Cell(39,6,"$rm74","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r75","$rmc",0,"R");$pdf->Cell(39,6,"$rm75","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r76","$rmc",0,"R");$pdf->Cell(39,6,"$rm76","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r77","$rmc",0,"R");$pdf->Cell(39,5,"$rm77","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r78","$rmc",0,"R");$pdf->Cell(39,6,"$rm78","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r79","$rmc",0,"R");$pdf->Cell(39,6,"$rm79","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r80","$rmc",0,"R");$pdf->Cell(39,5,"$rm80","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r81","$rmc",0,"R");$pdf->Cell(39,6,"$rm81","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r82","$rmc",0,"R");$pdf->Cell(39,6,"$rm82","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r83","$rmc",0,"R");$pdf->Cell(39,5,"$rm83","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r84","$rmc",0,"R");$pdf->Cell(39,6,"$rm84","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r85","$rmc",0,"R");$pdf->Cell(39,6,"$rm85","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r86","$rmc",0,"R");$pdf->Cell(39,6,"$rm86","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r87","$rmc",0,"R");$pdf->Cell(39,5,"$rm87","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r88","$rmc",0,"R");$pdf->Cell(39,6,"$rm88","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r89","$rmc",0,"R");$pdf->Cell(39,5,"$rm89","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r90","$rmc",0,"R");$pdf->Cell(39,6,"$rm90","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r91","$rmc",0,"R");$pdf->Cell(39,6,"$rm91","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r92","$rmc",0,"R");$pdf->Cell(39,6,"$rm92","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r93","$rmc",0,"R");$pdf->Cell(39,5,"$rm93","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r94","$rmc",0,"R");$pdf->Cell(39,6,"$rm94","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r95","$rmc",0,"R");$pdf->Cell(39,5,"$rm95","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r96","$rmc",0,"R");$pdf->Cell(39,6,"$rm96","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r97","$rmc",0,"R");$pdf->Cell(39,6,"$rm97","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r98","$rmc",0,"R");$pdf->Cell(39,5,"$rm98","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r99","$rmc",0,"R");$pdf->Cell(39,6,"$rm99","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r100","$rmc",0,"R");$pdf->Cell(39,5,"$rm100","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r101","$rmc",0,"R");$pdf->Cell(39,6,"$rm101","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r102","$rmc",0,"R");$pdf->Cell(39,6,"$rm102","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r103","$rmc",0,"R");$pdf->Cell(39,5,"$rm103","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r104","$rmc",0,"R");$pdf->Cell(39,6,"$rm104","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r105","$rmc",0,"R");$pdf->Cell(39,6,"$rm105","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r106","$rmc",0,"R");$pdf->Cell(39,6,"$rm106","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r107","$rmc",0,"R");$pdf->Cell(39,6,"$rm107","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r108","$rmc",0,"R");$pdf->Cell(39,5,"$rm108","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r109","$rmc",0,"R");$pdf->Cell(39,6,"$rm109","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r110","$rmc",0,"R");$pdf->Cell(39,6,"$rm110","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r111","$rmc",0,"R");$pdf->Cell(39,6,"$rm111","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r112","$rmc",0,"R");$pdf->Cell(39,5,"$rm112","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r113","$rmc",0,"R");$pdf->Cell(39,5,"$rm113","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(180);
$pdf->Cell(20,6,"4/$total_strana","$rmc",1,"R");
                                       }

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_source.'_str5.jpg') )
{
$pdf->Image($jpg_source.'_str5.jpg',0,0,210,297);
}
$pdf->SetY(10);

//pasiva pokrac.
$r114=$hlavicka->r114; if ( $hlavicka->r114 == 0 ) $r114="";
$r115=$hlavicka->r115; if ( $hlavicka->r115 == 0 ) $r115="";
$r116=$hlavicka->r116; if ( $hlavicka->r116 == 0 ) $r116="";
$r117=$hlavicka->r117; if ( $hlavicka->r117 == 0 ) $r117="";
$r118=$hlavicka->r118; if ( $hlavicka->r118 == 0 ) $r118="";
$r119=$hlavicka->r119; if ( $hlavicka->r119 == 0 ) $r119="";
$r120=$hlavicka->r120; if ( $hlavicka->r120 == 0 ) $r120="";
$r121=$hlavicka->r121; if ( $hlavicka->r121 == 0 ) $r121="";
$r122=$hlavicka->r122; if ( $hlavicka->r122 == 0 ) $r122="";
$r123=$hlavicka->r123; if ( $hlavicka->r123 == 0 ) $r123="";
$r124=$hlavicka->r124; if ( $hlavicka->r124 == 0 ) $r124="";
$r125=$hlavicka->r125; if ( $hlavicka->r125 == 0 ) $r125="";
$r126=$hlavicka->r126; if ( $hlavicka->r126 == 0 ) $r126="";
$r127=$hlavicka->r127; if ( $hlavicka->r127 == 0 ) $r127="";
$r128=$hlavicka->r128; if ( $hlavicka->r128 == 0 ) $r128="";
$r129=$hlavicka->r129; if ( $hlavicka->r129 == 0 ) $r129="";
$r130=$hlavicka->r130; if ( $hlavicka->r130 == 0 ) $r130="";
$r131=$hlavicka->r131; if ( $hlavicka->r131 == 0 ) $r131="";
$rm114=$hlavicka->rm114; if ( $hlavicka->rm114 == 0 ) $rm114="";
$rm115=$hlavicka->rm115; if ( $hlavicka->rm115 == 0 ) $rm115="";
$rm116=$hlavicka->rm116; if ( $hlavicka->rm116 == 0 ) $rm116="";
$rm117=$hlavicka->rm117; if ( $hlavicka->rm117 == 0 ) $rm117="";
$rm118=$hlavicka->rm118; if ( $hlavicka->rm118 == 0 ) $rm118="";
$rm119=$hlavicka->rm119; if ( $hlavicka->rm119 == 0 ) $rm119="";
$rm120=$hlavicka->rm120; if ( $hlavicka->rm120 == 0 ) $rm120="";
$rm121=$hlavicka->rm121; if ( $hlavicka->rm121 == 0 ) $rm121="";
$rm122=$hlavicka->rm122; if ( $hlavicka->rm122 == 0 ) $rm122="";
$rm123=$hlavicka->rm123; if ( $hlavicka->rm123 == 0 ) $rm123="";
$rm124=$hlavicka->rm124; if ( $hlavicka->rm124 == 0 ) $rm124="";
$rm125=$hlavicka->rm125; if ( $hlavicka->rm125 == 0 ) $rm125="";
$rm126=$hlavicka->rm126; if ( $hlavicka->rm126 == 0 ) $rm126="";
$rm127=$hlavicka->rm127; if ( $hlavicka->rm127 == 0 ) $rm127="";
$rm128=$hlavicka->rm128; if ( $hlavicka->rm128 == 0 ) $rm128="";
$rm129=$hlavicka->rm129; if ( $hlavicka->rm129 == 0 ) $rm129="";
$rm130=$hlavicka->rm130; if ( $hlavicka->rm130 == 0 ) $rm130="";
$rm131=$hlavicka->rm131; if ( $hlavicka->rm131 == 0 ) $rm131="";
$pdf->Cell(195,5," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r114","$rmc",0,"R");$pdf->Cell(39,6,"$rm114","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r115","$rmc",0,"R");$pdf->Cell(39,6,"$rm115","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r116","$rmc",0,"R");$pdf->Cell(39,6,"$rm116","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r117","$rmc",0,"R");$pdf->Cell(39,6,"$rm117","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r118","$rmc",0,"R");$pdf->Cell(39,6,"$rm118","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r119","$rmc",0,"R");$pdf->Cell(39,6,"$rm119","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r120","$rmc",0,"R");$pdf->Cell(39,5,"$rm120","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r121","$rmc",0,"R");$pdf->Cell(39,6,"$rm121","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r122","$rmc",0,"R");$pdf->Cell(39,6,"$rm122","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r123","$rmc",0,"R");$pdf->Cell(39,5,"$rm123","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r124","$rmc",0,"R");$pdf->Cell(39,6,"$rm124","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r125","$rmc",0,"R");$pdf->Cell(39,6,"$rm125","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r126","$rmc",0,"R");$pdf->Cell(39,6,"$rm126","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r127","$rmc",0,"R");$pdf->Cell(39,6,"$rm127","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r128","$rmc",0,"R");$pdf->Cell(39,5,"$rm128","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r129","$rmc",0,"R");$pdf->Cell(39,6,"$rm129","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,5,"$r130","$rmc",0,"R");$pdf->Cell(39,5,"$rm130","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(41,6,"$r131","$rmc",0,"R");$pdf->Cell(39,6,"$rm131","$rmc",1,"R");

//pagination
$pdf->SetY(292);
$pdf->SetX(180);
$pdf->Cell(20,6,"5/$total_strana","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
$pdf->Output("$outfilex");
?>
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
}
//koniec pdf
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec
$cislista = include("uct_lista_norm.php");
} while (false);
?>
<script type="text/javascript">
//parameter okna
var blank_param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

<?php
//uprava sadzby
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.daz.value = '<?php echo $daz_sk; ?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   // document.formv1.r01.value = '<?php echo $r01; ?>';
   // document.formv1.rk01.value = '<?php echo $rk01; ?>';
   // document.formv1.rn01.value = '<?php echo $rn01; ?>';
   // document.formv1.rm01.value = '<?php echo $rm01; ?>';
   document.formv1.r02.value = '<?php echo $r02; ?>';
   document.formv1.rk02.value = '<?php echo $rk02; ?>';
   document.formv1.rn02.value = '<?php echo $rn02; ?>';
   document.formv1.rm02.value = '<?php echo $rm02; ?>';
   document.formv1.r03.value = '<?php echo $r03; ?>';
   document.formv1.rk03.value = '<?php echo $rk03; ?>';
   document.formv1.rn03.value = '<?php echo $rn03; ?>';
   document.formv1.rm03.value = '<?php echo $rm03; ?>';
   document.formv1.r04.value = '<?php echo $r04; ?>';
   document.formv1.rk04.value = '<?php echo $rk04; ?>';
   document.formv1.rn04.value = '<?php echo $rn04; ?>';
   document.formv1.rm04.value = '<?php echo $rm04; ?>';
   document.formv1.r05.value = '<?php echo $r05; ?>';
   document.formv1.rk05.value = '<?php echo $rk05; ?>';
   document.formv1.rn05.value = '<?php echo $rn05; ?>';
   document.formv1.rm05.value = '<?php echo $rm05; ?>';
   document.formv1.r06.value = '<?php echo $r06; ?>';
   document.formv1.rk06.value = '<?php echo $rk06; ?>';
   document.formv1.rn06.value = '<?php echo $rn06; ?>';
   document.formv1.rm06.value = '<?php echo $rm06; ?>';
   document.formv1.r07.value = '<?php echo $r07; ?>';
   document.formv1.rk07.value = '<?php echo $rk07; ?>';
   document.formv1.rn07.value = '<?php echo $rn07; ?>';
   document.formv1.rm07.value = '<?php echo $rm07; ?>';
   // document.formv1.r08.value = '<?php echo $r08; ?>';
   // document.formv1.rk08.value = '<?php echo $rk08; ?>';
   // document.formv1.rn08.value = '<?php echo $rn08; ?>';
   // document.formv1.rm08.value = '<?php echo $rm08; ?>';
   document.formv1.r09.value = '<?php echo $r09; ?>';
   document.formv1.rk09.value = '<?php echo $rk09; ?>';
   document.formv1.rn09.value = '<?php echo $rn09; ?>';
   document.formv1.rm09.value = '<?php echo $rm09; ?>';
   document.formv1.r10.value = '<?php echo $r10; ?>';
   document.formv1.rk10.value = '<?php echo $rk10; ?>';
   document.formv1.rn10.value = '<?php echo $rn10; ?>';
   document.formv1.rm10.value = '<?php echo $rm10; ?>';
   document.formv1.r11.value = '<?php echo $r11; ?>';
   document.formv1.rk11.value = '<?php echo $rk11; ?>';
   document.formv1.rn11.value = '<?php echo $rn11; ?>';
   document.formv1.rm11.value = '<?php echo $rm11; ?>';
   document.formv1.r12.value = '<?php echo $r12; ?>';
   document.formv1.rk12.value = '<?php echo $rk12; ?>';
   document.formv1.rn12.value = '<?php echo $rn12; ?>';
   document.formv1.rm12.value = '<?php echo $rm12; ?>';
   document.formv1.r13.value = '<?php echo $r13; ?>';
   document.formv1.rk13.value = '<?php echo $rk13; ?>';
   document.formv1.rn13.value = '<?php echo $rn13; ?>';
   document.formv1.rm13.value = '<?php echo $rm13; ?>';
   document.formv1.r14.value = '<?php echo $r14; ?>';
   document.formv1.rk14.value = '<?php echo $rk14; ?>';
   document.formv1.rn14.value = '<?php echo $rn14; ?>';
   document.formv1.rm14.value = '<?php echo $rm14; ?>';
   document.formv1.r15.value = '<?php echo $r15; ?>';
   document.formv1.rk15.value = '<?php echo $rk15; ?>';
   document.formv1.rn15.value = '<?php echo $rn15; ?>';
   document.formv1.rm15.value = '<?php echo $rm15; ?>';
   document.formv1.r16.value = '<?php echo $r16; ?>';
   document.formv1.rk16.value = '<?php echo $rk16; ?>';
   document.formv1.rn16.value = '<?php echo $rn16; ?>';
   document.formv1.rm16.value = '<?php echo $rm16; ?>';
   document.formv1.r17.value = '<?php echo $r17; ?>';
   document.formv1.rk17.value = '<?php echo $rk17; ?>';
   document.formv1.rn17.value = '<?php echo $rn17; ?>';
   document.formv1.rm17.value = '<?php echo $rm17; ?>';
   document.formv1.r18.value = '<?php echo $r18;?>';
   document.formv1.rk18.value = '<?php echo $rk18;?>';
   document.formv1.rn18.value = '<?php echo $rn18;?>';
   document.formv1.rm18.value = '<?php echo $rm18;?>';
   // document.formv1.r19.value = '<?php echo $r19;?>';
   // document.formv1.rk19.value = '<?php echo $rk19;?>';
   // document.formv1.rn19.value = '<?php echo $rn19;?>';
   // document.formv1.rm19.value = '<?php echo $rm19;?>';
   document.formv1.r20.value = '<?php echo $r20;?>';
   document.formv1.rk20.value = '<?php echo $rk20;?>';
   document.formv1.rn20.value = '<?php echo $rn20;?>';
   document.formv1.rm20.value = '<?php echo $rm20;?>';
   document.formv1.r21.value = '<?php echo $r21;?>';
   document.formv1.rk21.value = '<?php echo $rk21;?>';
   document.formv1.rn21.value = '<?php echo $rn21;?>';
   document.formv1.rm21.value = '<?php echo $rm21;?>';
   document.formv1.r22.value = '<?php echo $r22;?>';
   document.formv1.rk22.value = '<?php echo $rk22;?>';
   document.formv1.rn22.value = '<?php echo $rn22;?>';
   document.formv1.rm22.value = '<?php echo $rm22;?>';
   document.formv1.r23.value = '<?php echo $r23;?>';
   document.formv1.rk23.value = '<?php echo $rk23;?>';
   document.formv1.rn23.value = '<?php echo $rn23;?>';
   document.formv1.rm23.value = '<?php echo $rm23;?>';
   document.formv1.r24.value = '<?php echo $r24;?>';
   document.formv1.rk24.value = '<?php echo $rk24;?>';
   document.formv1.rn24.value = '<?php echo $rn24;?>';
   document.formv1.rm24.value = '<?php echo $rm24;?>';
   document.formv1.r25.value = '<?php echo $r25;?>';
   document.formv1.rk25.value = '<?php echo $rk25;?>';
   document.formv1.rn25.value = '<?php echo $rn25;?>';
   document.formv1.rm25.value = '<?php echo $rm25;?>';
   document.formv1.r26.value = '<?php echo $r26;?>';
   document.formv1.rk26.value = '<?php echo $rk26;?>';
   document.formv1.rn26.value = '<?php echo $rn26;?>';
   document.formv1.rm26.value = '<?php echo $rm26;?>';
   // document.formv1.r27.value = '<?php echo $r27;?>';
   // document.formv1.rk27.value = '<?php echo $rk27;?>';
   // document.formv1.rn27.value = '<?php echo $rn27;?>';
   // document.formv1.rm27.value = '<?php echo $rm27;?>';
   document.formv1.r28.value = '<?php echo $r28;?>';
   document.formv1.rk28.value = '<?php echo $rk28;?>';
   document.formv1.rn28.value = '<?php echo $rn28;?>';
   document.formv1.rm28.value = '<?php echo $rm28;?>';
   document.formv1.r29.value = '<?php echo $r29;?>';
   document.formv1.rk29.value = '<?php echo $rk29;?>';
   document.formv1.rn29.value = '<?php echo $rn29;?>';
   document.formv1.rm29.value = '<?php echo $rm29;?>';
   document.formv1.r30.value = '<?php echo $r30;?>';
   document.formv1.rk30.value = '<?php echo $rk30;?>';
   document.formv1.rn30.value = '<?php echo $rn30;?>';
   document.formv1.rm30.value = '<?php echo $rm30;?>';
   document.formv1.r31.value = '<?php echo $r31;?>';
   document.formv1.rk31.value = '<?php echo $rk31;?>';
   document.formv1.rn31.value = '<?php echo $rn31;?>';
   document.formv1.rm31.value = '<?php echo $rm31;?>';
   document.formv1.r32.value = '<?php echo $r32;?>';
   document.formv1.rk32.value = '<?php echo $rk32;?>';
   document.formv1.rn32.value = '<?php echo $rn32;?>';
   document.formv1.rm32.value = '<?php echo $rm32;?>';
   document.formv1.r33.value = '<?php echo $r33;?>';
   document.formv1.rk33.value = '<?php echo $rk33;?>';
   document.formv1.rn33.value = '<?php echo $rn33;?>';
   document.formv1.rm33.value = '<?php echo $rm33;?>';
   document.formv1.r34.value = '<?php echo $r34;?>';
   document.formv1.rk34.value = '<?php echo $rk34;?>';
   document.formv1.rn34.value = '<?php echo $rn34;?>';
   document.formv1.rm34.value = '<?php echo $rm34;?>';
   // document.formv1.r35.value = '<?php echo $r35;?>';
   // document.formv1.rk35.value = '<?php echo $rk35;?>';
   // document.formv1.rn35.value = '<?php echo $rn35;?>';
   // document.formv1.rm35.value = '<?php echo $rm35;?>';
   document.formv1.r36.value = '<?php echo $r36;?>';
   document.formv1.rk36.value = '<?php echo $rk36;?>';
   document.formv1.rn36.value = '<?php echo $rn36;?>';
   document.formv1.rm36.value = '<?php echo $rm36;?>';
   document.formv1.r37.value = '<?php echo $r37;?>';
   document.formv1.rk37.value = '<?php echo $rk37;?>';
   document.formv1.rn37.value = '<?php echo $rn37;?>';
   document.formv1.rm37.value = '<?php echo $rm37;?>';
   document.formv1.r38.value = '<?php echo $r38;?>';
   document.formv1.rk38.value = '<?php echo $rk38;?>';
   document.formv1.rn38.value = '<?php echo $rn38;?>';
   document.formv1.rm38.value = '<?php echo $rm38;?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.r39.value = '<?php echo $r39;?>';
   document.formv1.rk39.value = '<?php echo $rk39;?>';
   document.formv1.rn39.value = '<?php echo $rn39;?>';
   document.formv1.rm39.value = '<?php echo $rm39;?>';
   document.formv1.r40.value = '<?php echo $r40;?>';
   document.formv1.rk40.value = '<?php echo $rk40;?>';
   document.formv1.rn40.value = '<?php echo $rn40;?>';
   document.formv1.rm40.value = '<?php echo $rm40;?>';
   document.formv1.r41.value = '<?php echo $r41;?>';
   document.formv1.rk41.value = '<?php echo $rk41;?>';
   document.formv1.rn41.value = '<?php echo $rn41;?>';
   document.formv1.rm41.value = '<?php echo $rm41;?>';
   document.formv1.r42.value = '<?php echo $r42;?>';
   document.formv1.rk42.value = '<?php echo $rk42;?>';
   document.formv1.rn42.value = '<?php echo $rn42;?>';
   document.formv1.rm42.value = '<?php echo $rm42;?>';
   document.formv1.r43.value = '<?php echo $r43;?>';
   document.formv1.rk43.value = '<?php echo $rk43;?>';
   document.formv1.rn43.value = '<?php echo $rn43;?>';
   document.formv1.rm43.value = '<?php echo $rm43;?>';
   document.formv1.r44.value = '<?php echo $r44;?>';
   document.formv1.rk44.value = '<?php echo $rk44;?>';
   document.formv1.rn44.value = '<?php echo $rn44;?>';
   document.formv1.rm44.value = '<?php echo $rm44;?>';
   document.formv1.r45.value = '<?php echo $r45;?>';
   document.formv1.rk45.value = '<?php echo $rk45;?>';
   document.formv1.rn45.value = '<?php echo $rn45;?>';
   document.formv1.rm45.value = '<?php echo $rm45;?>';
   document.formv1.r46.value = '<?php echo $r46;?>';
   document.formv1.rk46.value = '<?php echo $rk46;?>';
   document.formv1.rn46.value = '<?php echo $rn46;?>';
   document.formv1.rm46.value = '<?php echo $rm46;?>';
   document.formv1.r47.value = '<?php echo $r47;?>';
   document.formv1.rk47.value = '<?php echo $rk47;?>';
   document.formv1.rn47.value = '<?php echo $rn47;?>';
   document.formv1.rm47.value = '<?php echo $rm47;?>';
   document.formv1.r48.value = '<?php echo $r48;?>';
   document.formv1.rk48.value = '<?php echo $rk48;?>';
   document.formv1.rn48.value = '<?php echo $rn48;?>';
   document.formv1.rm48.value = '<?php echo $rm48;?>';
   document.formv1.r49.value = '<?php echo $r49;?>';
   document.formv1.rk49.value = '<?php echo $rk49;?>';
   document.formv1.rn49.value = '<?php echo $rn49;?>';
   document.formv1.rm49.value = '<?php echo $rm49;?>';
   document.formv1.r50.value = '<?php echo $r50;?>';
   document.formv1.rk50.value = '<?php echo $rk50;?>';
   document.formv1.rn50.value = '<?php echo $rn50;?>';
   document.formv1.rm50.value = '<?php echo $rm50;?>';
   document.formv1.r51.value = '<?php echo $r51;?>';
   document.formv1.rk51.value = '<?php echo $rk51;?>';
   document.formv1.rn51.value = '<?php echo $rn51;?>';
   document.formv1.rm51.value = '<?php echo $rm51;?>';
   // document.formv1.r52.value = '<?php echo $r52;?>';
   // document.formv1.rk52.value = '<?php echo $rk52;?>';
   // document.formv1.rn52.value = '<?php echo $rn52;?>';
   // document.formv1.rm52.value = '<?php echo $rm52;?>';
   document.formv1.r53.value = '<?php echo $r53;?>';
   document.formv1.rk53.value = '<?php echo $rk53;?>';
   document.formv1.rn53.value = '<?php echo $rn53;?>';
   document.formv1.rm53.value = '<?php echo $rm53;?>';
   document.formv1.r54.value = '<?php echo $r54;?>';
   document.formv1.rk54.value = '<?php echo $rk54;?>';
   document.formv1.rn54.value = '<?php echo $rn54;?>';
   document.formv1.rm54.value = '<?php echo $rm54;?>';
   document.formv1.r55.value = '<?php echo $r55;?>';
   document.formv1.rk55.value = '<?php echo $rk55;?>';
   document.formv1.rn55.value = '<?php echo $rn55;?>';
   document.formv1.rm55.value = '<?php echo $rm55;?>';
   document.formv1.r55.value = '<?php echo $r55;?>';
   document.formv1.rk55.value = '<?php echo $rk55;?>';
   document.formv1.rn55.value = '<?php echo $rn55;?>';
   document.formv1.rm55.value = '<?php echo $rm55;?>';
   document.formv1.r56.value = '<?php echo $r56;?>';
   document.formv1.rk56.value = '<?php echo $rk56;?>';
   document.formv1.rn56.value = '<?php echo $rn56;?>';
   document.formv1.rm56.value = '<?php echo $rm56;?>';
   document.formv1.r57.value = '<?php echo $r57;?>';
   document.formv1.rk57.value = '<?php echo $rk57;?>';
   document.formv1.rn57.value = '<?php echo $rn57;?>';
   document.formv1.rm57.value = '<?php echo $rm57;?>';
   document.formv1.r58.value = '<?php echo $r58;?>';
   document.formv1.rk58.value = '<?php echo $rk58;?>';
   document.formv1.rn58.value = '<?php echo $rn58;?>';
   document.formv1.rm58.value = '<?php echo $rm58;?>';
   document.formv1.r59.value = '<?php echo $r59;?>';
   document.formv1.rk59.value = '<?php echo $rk59;?>';
   document.formv1.rn59.value = '<?php echo $rn59;?>';
   document.formv1.rm59.value = '<?php echo $rm59;?>';
   document.formv1.r60.value = '<?php echo $r60;?>';
   document.formv1.rk60.value = '<?php echo $rk60;?>';
   document.formv1.rn60.value = '<?php echo $rn60;?>';
   document.formv1.rm60.value = '<?php echo $rm60;?>';
   // document.formv1.r61.value = '<?php echo $r61;?>';
   // document.formv1.rk61.value = '<?php echo $rk61;?>';
   // document.formv1.rn61.value = '<?php echo $rn61;?>';
   // document.formv1.rm61.value = '<?php echo $rm61;?>';
   document.formv1.r62.value = '<?php echo $r62;?>';
   document.formv1.rk62.value = '<?php echo $rk62;?>';
   document.formv1.rn62.value = '<?php echo $rn62;?>';
   document.formv1.rm62.value = '<?php echo $rm62;?>';
   document.formv1.r63.value = '<?php echo $r63;?>';
   document.formv1.rk63.value = '<?php echo $rk63;?>';
   document.formv1.rn63.value = '<?php echo $rn63;?>';
   document.formv1.rm63.value = '<?php echo $rm63;?>';
   document.formv1.r64.value = '<?php echo $r64;?>';
   document.formv1.rk64.value = '<?php echo $rk64;?>';
   document.formv1.rn64.value = '<?php echo $rn64;?>';
   document.formv1.rm64.value = '<?php echo $rm64;?>';
   document.formv1.r65.value = '<?php echo $r65;?>';
   document.formv1.rk65.value = '<?php echo $rk65;?>';
   document.formv1.rn65.value = '<?php echo $rn65;?>';
   document.formv1.rm65.value = '<?php echo $rm65;?>';
   document.formv1.r66.value = '<?php echo $r66;?>';
   document.formv1.rk66.value = '<?php echo $rk66;?>';
   document.formv1.rn66.value = '<?php echo $rn66;?>';
   document.formv1.rm66.value = '<?php echo $rm66;?>';
   document.formv1.r67.value = '<?php echo $r67;?>';
   document.formv1.rk67.value = '<?php echo $rk67;?>';
   document.formv1.rn67.value = '<?php echo $rn67;?>';
   document.formv1.rm67.value = '<?php echo $rm67;?>';
   // document.formv1.r68.value = '<?php echo $r68;?>';
   // document.formv1.rk68.value = '<?php echo $rk68;?>';
   // document.formv1.rn68.value = '<?php echo $rn68;?>';
   // document.formv1.rm68.value = '<?php echo $rm68;?>';
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   // document.formv1.r69.value = '<?php echo $r69;?>';
   // document.formv1.rm69.value = '<?php echo $rm69;?>';
   document.formv1.r70.value = '<?php echo $r70;?>';
   document.formv1.rm70.value = '<?php echo $rm70;?>';
   document.formv1.r71.value = '<?php echo $r71;?>';
   document.formv1.rm71.value = '<?php echo $rm71;?>';
   document.formv1.r72.value = '<?php echo $r72;?>';
   document.formv1.rm72.value = '<?php echo $rm72;?>';
   document.formv1.r73.value = '<?php echo $r73;?>';
   document.formv1.rm73.value = '<?php echo $rm73;?>';
   document.formv1.r74.value = '<?php echo $r74;?>';
   document.formv1.rm74.value = '<?php echo $rm74;?>';
   document.formv1.r75.value = '<?php echo $r75;?>';
   document.formv1.rm75.value = '<?php echo $rm75;?>';
   document.formv1.r76.value = '<?php echo $r76;?>';
   document.formv1.rm76.value = '<?php echo $rm76;?>';
   // document.formv1.r77.value = '<?php echo $r77;?>';
   // document.formv1.rm77.value = '<?php echo $rm77;?>';
   document.formv1.r78.value = '<?php echo $r78;?>';
   document.formv1.rm78.value = '<?php echo $rm78;?>';
   document.formv1.r79.value = '<?php echo $r79;?>';
   document.formv1.rm79.value = '<?php echo $rm79;?>';
   document.formv1.r80.value = '<?php echo $r80;?>';
   document.formv1.rm80.value = '<?php echo $rm80;?>';
   document.formv1.r81.value = '<?php echo $r81;?>';
   document.formv1.rm81.value = '<?php echo $rm81;?>';
   document.formv1.r82.value = '<?php echo $r82;?>';
   document.formv1.rm82.value = '<?php echo $rm82;?>';
   document.formv1.r83.value = '<?php echo $r83;?>';
   document.formv1.rm83.value = '<?php echo $rm83;?>';
   document.formv1.r84.value = '<?php echo $r84;?>';
   document.formv1.rm84.value = '<?php echo $rm84;?>';
   // document.formv1.r85.value = '<?php echo $r85;?>';
   // document.formv1.rm85.value = '<?php echo $rm85;?>';
   document.formv1.r86.value = '<?php echo $r86;?>';
   document.formv1.rm86.value = '<?php echo $rm86;?>';
   document.formv1.r87.value = '<?php echo $r87;?>';
   document.formv1.rm87.value = '<?php echo $rm87;?>';
   document.formv1.r88.value = '<?php echo $r88;?>';
   document.formv1.rm88.value = '<?php echo $rm88;?>';
   document.formv1.r89.value = '<?php echo $r89;?>';
   document.formv1.rm89.value = '<?php echo $rm89;?>';
   document.formv1.r90.value = '<?php echo $r90;?>';
   document.formv1.rm90.value = '<?php echo $rm90;?>';
   document.formv1.r91.value = '<?php echo $r91;?>';
   document.formv1.rm91.value = '<?php echo $rm91;?>';
   document.formv1.r92.value = '<?php echo $r92;?>';
   document.formv1.rm92.value = '<?php echo $rm92;?>';
   document.formv1.r93.value = '<?php echo $r93;?>';
   document.formv1.rm93.value = '<?php echo $rm93;?>';
   document.formv1.r94.value = '<?php echo $r94;?>';
   document.formv1.rm94.value = '<?php echo $rm94;?>';
   document.formv1.r95.value = '<?php echo $r95;?>';
   document.formv1.rm95.value = '<?php echo $rm95;?>';
   document.formv1.r96.value = '<?php echo $r96;?>';
   document.formv1.rm96.value = '<?php echo $rm96;?>';
   document.formv1.r97.value = '<?php echo $r97;?>';
   document.formv1.rm97.value = '<?php echo $rm97;?>';
   // document.formv1.r98.value = '<?php echo $r98;?>';
   // document.formv1.rm98.value = '<?php echo $rm98;?>';
   document.formv1.r99.value = '<?php echo $r99;?>';
   document.formv1.rm99.value = '<?php echo $rm99;?>';
   document.formv1.r100.value = '<?php echo $r100;?>';
   document.formv1.rm100.value = '<?php echo $rm100;?>';
   document.formv1.r101.value = '<?php echo $r101;?>';
   document.formv1.rm101.value = '<?php echo $rm101;?>';
   // document.formv1.r102.value = '<?php echo $r102;?>';
   // document.formv1.rm102.value = '<?php echo $rm102;?>';
   document.formv1.r103.value = '<?php echo $r103;?>';
   document.formv1.rm103.value = '<?php echo $rm103;?>';
   document.formv1.r104.value = '<?php echo $r104;?>';
   document.formv1.rm104.value = '<?php echo $rm104;?>';
   document.formv1.r105.value = '<?php echo $r105;?>';
   document.formv1.rm105.value = '<?php echo $rm105;?>';
   document.formv1.r106.value = '<?php echo $r106;?>';
   document.formv1.rm106.value = '<?php echo $rm106;?>';
   document.formv1.r107.value = '<?php echo $r107;?>';
   document.formv1.rm107.value = '<?php echo $rm107;?>';
   document.formv1.r108.value = '<?php echo $r108;?>';
   document.formv1.rm108.value = '<?php echo $rm108;?>';
   document.formv1.r109.value = '<?php echo $r109;?>';
   document.formv1.rm109.value = '<?php echo $rm109;?>';
   document.formv1.r110.value = '<?php echo $r110;?>';
   document.formv1.rm110.value = '<?php echo $rm110;?>';
   document.formv1.r111.value = '<?php echo $r111;?>';
   document.formv1.rm111.value = '<?php echo $rm111;?>';
   document.formv1.r112.value = '<?php echo $r112;?>';
   document.formv1.rm112.value = '<?php echo $rm112;?>';
   document.formv1.r113.value = '<?php echo $r113;?>';
   document.formv1.rm113.value = '<?php echo $rm113;?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   document.formv1.r114.value = '<?php echo $r114;?>';
   document.formv1.rm114.value = '<?php echo $rm114;?>';
   document.formv1.r115.value = '<?php echo $r115;?>';
   document.formv1.rm115.value = '<?php echo $rm115;?>';
   document.formv1.r116.value = '<?php echo $r116;?>';
   document.formv1.rm116.value = '<?php echo $rm116;?>';
   document.formv1.r117.value = '<?php echo $r117;?>';
   document.formv1.rm117.value = '<?php echo $rm117;?>';
   document.formv1.r118.value = '<?php echo $r118;?>';
   document.formv1.rm118.value = '<?php echo $rm118;?>';
   document.formv1.r119.value = '<?php echo $r119;?>';
   document.formv1.rm119.value = '<?php echo $rm119;?>';
   document.formv1.r120.value = '<?php echo $r120;?>';
   document.formv1.rm120.value = '<?php echo $rm120;?>';
   document.formv1.r121.value = '<?php echo $r121;?>';
   document.formv1.rm121.value = '<?php echo $rm121;?>';
   // document.formv1.r122.value = '<?php echo $r122;?>';
   // document.formv1.rm122.value = '<?php echo $rm122;?>';
   document.formv1.r123.value = '<?php echo $r123;?>';
   document.formv1.rm123.value = '<?php echo $rm123;?>';
   document.formv1.r124.value = '<?php echo $r124;?>';
   document.formv1.rm124.value = '<?php echo $rm124;?>';
   document.formv1.r125.value = '<?php echo $r125;?>';
   document.formv1.rm125.value = '<?php echo $rm125;?>';
   // document.formv1.r126.value = '<?php echo $r126;?>';
   // document.formv1.rm126.value = '<?php echo $rm126;?>';
   document.formv1.r127.value = '<?php echo $r127;?>';
   document.formv1.rm127.value = '<?php echo $rm127;?>';
   document.formv1.r128.value = '<?php echo $r128;?>';
   document.formv1.rm128.value = '<?php echo $rm128;?>';
   document.formv1.r129.value = '<?php echo $r129;?>';
   document.formv1.rm129.value = '<?php echo $rm129;?>';
   document.formv1.r130.value = '<?php echo $r130;?>';
   document.formv1.rm130.value = '<?php echo $rm130;?>';
   // document.formv1.r131.value = '<?php echo $r131;?>';
   // document.formv1.rm131.value = '<?php echo $rm131;?>';
<?php                     } ?>
    }
<?php
//koniec uprava
  }
?>
<?php
  if ( $copern != 20 )
  {
?>
  function ObnovUI()
  {
  }
<?php
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
    if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function FormMetod()
  {
    window.open('<?php echo $jpg_source; ?>_vysvetlivky.pdf', '_blank', blank_param);
  }


  function editForm(strana)
  {
    window.open('vykaz_fin204pod_2018.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=20&strana=' + strana + '', '_self');
  }
  function FormPDF(strana)
  {
    window.open('vykaz_fin204pod_2018.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=10&strana=' + strana + '', '_blank', blank_param);
  }
  function Nacitaj()
  {
   window.open('vykaz_fin204pod_2018.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=26&drupoh=1&page=1&subor=0&strana=1', '_self');
  }

function DbfFin204pod16()
                {
window.open('fin204poddbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0', '_blank', blank_param);
                }

function CsvFin204pod16()
                {

window.open('vykaz_fin204pod_csv.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0', '_blank', blank_param);
                }

</script>
</body>
</html>