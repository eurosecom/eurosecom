<!doctype html>
<HTML>
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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/fin204pod/fin2-04pod_v16";
$jpg_popis="FinanËn˝ v˝kaz o vybran˝ch ˙dajoch z aktÌv a z pasÌv podnikateæskÈho subjektu verejnej spr·vy FIN 2-04 za rok ".$kli_vrok;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=9999;

if ( $cislo_oc == 0 ) $cislo_oc=1;
if ( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if ( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if ( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if ( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }


$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//ak nie je generovanie daj standardne
$niejegen=0;
$sql = "SELECT * FROM F".$kli_vxcf."_genfin204pod ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$copern=1002;
$niejegen=1;
}
//koniec ak nie je generovanie daj standardne


//Tabulka generovania
if ( $copern == 1001 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandardnÈ generovanie v˝kazu FIN 2-04 POD ?") )
         { window.close()  }
else
         { location.href='vykaz_fin204pod_2016.php?copern=1002&page=1&drupoh=1' }
</script>
<?php
    }

    if ( $copern == 1002 )
    {

$sql = "DROP TABLE F$kli_vxcf"."_genfin204pod";
$vysledok = mysql_query("$sql");

$sqlt = <<<crf204nuj_no
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         INT,
   cpl01       INT,
   PRIMARY KEY(cpl)
);
crf204nuj_no;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_genfin204pod'.$sqlt;
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '012', '2' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '014', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '015', '2' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '072', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '073', '2' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '074', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '075', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '079', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '091', '2' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '051', '3' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '095', '3' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '013', '4' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '018', '4' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '019', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '073', '4' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '078', '4' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '079', '4' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '041', '5' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '093', '5' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '031', '7' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '025', '8' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '085', '8' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '092', '8' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '032', '9' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '021', '10' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '081', '10' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '022', '11' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '023', '11' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '082', '11' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '083', '11' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '052', '13' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '024', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '025', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '026', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '028', '14' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '029', '14' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '084', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '085', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '086', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '088', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '089', '14' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '042', '15' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '094', '15' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '061', '18' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '062', '18' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '063', '18' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '096', '18' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '065', '19' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '066', '20' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '067', '20' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '069', '20' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '053', '21' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '043', '21' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '069', '22' ); "; $ulozene = mysql_query("$sqult");
  
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '111', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '112', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '119', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '121', '23' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '122', '23' ); "; $ulozene = mysql_query("$sqult");  
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '123', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '124', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '131', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '132', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '139', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '191', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '192', '23' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '193', '23' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '194', '23' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '195', '23' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '196', '23' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '311', '25' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '391', '25' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '312', '26' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '314', '27' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '313', '28' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '375', '28' ); "; $ulozene = mysql_query("$sqult");  

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '346', '30' ); "; $ulozene = mysql_query("$sqult"); 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '347', '30' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '374', '31' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '373', '32' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '376', '32' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '358', '33' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '398', '33' ); "; $ulozene = mysql_query("$sqult");
 
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '351', '34' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '354', '34' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '355', '34' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '371', '34' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '315', '35' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '335', '35' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '378', '35' ); "; $ulozene = mysql_query("$sqult");


$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '211', '37' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '213', '37' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '221', '38' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '261', '38' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '251', '39' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '257', '39' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '291', '39' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '253', '40' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '255', '40' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '256', '40' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '259', '41' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '381', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '382', '42' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '385', '42' ); "; $ulozene = mysql_query("$sqult");


$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '323', '44' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '451', '44' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '459', '44' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '478', '46' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '322', '47' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '373', '48' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '377', '48' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '473', '49' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '321', '50' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '326', '50' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '476', '50' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '324', '53' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '475', '53' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '474', '56' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '331', '59' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '333', '59' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '336', '60' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '341', '60' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '342', '60' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '343', '60' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '345', '60' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '346', '61' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '348', '61' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '367', '62' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '368', '63' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '398', '63' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '325', '65' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '379', '65' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '472', '65' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '479', '65' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '461', '69' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '231', '70' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '232', '70' ); "; $ulozene = mysql_query("$sqult");

$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '241', '71' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '249', '72' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '383', '73' ); "; $ulozene = mysql_query("$sqult");
$sqult = "INSERT INTO F$kli_vxcf"."_genfin204pod ( uce,crs ) VALUES ( '384', '73' ); "; $ulozene = mysql_query("$sqult");

if ( $niejegen == 0 ) {
?>
<script type="text/javascript">
window.open('../ucto/fin_cis.php?copern=308&drupoh=87&page=1&sysx=UCT', '_self' );
</script>
<?php
exit;
                      }
$copern=20;
}
//koniec tabulky crf204pod_no


// znovu nacitaj
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
$r39 = 1*$_REQUEST['r39']; $rk39 = 1*$_REQUEST['rk39']; $rn39 = 1*$_REQUEST['rn39']; $rm39 = 1*$_REQUEST['rm39'];
$r40 = 1*$_REQUEST['r40']; $rk40 = 1*$_REQUEST['rk40']; $rn40 = 1*$_REQUEST['rn40']; $rm40 = 1*$_REQUEST['rm40'];
$r41 = 1*$_REQUEST['r41']; $rk41 = 1*$_REQUEST['rk41']; $rn41 = 1*$_REQUEST['rn41']; $rm41 = 1*$_REQUEST['rm41'];
$r42 = 1*$_REQUEST['r42']; $rk42 = 1*$_REQUEST['rk42']; $rn42 = 1*$_REQUEST['rn42']; $rm42 = 1*$_REQUEST['rm42'];
$r43 = 1*$_REQUEST['r43']; $rk43 = 1*$_REQUEST['rk43']; $rn43 = 1*$_REQUEST['rn43']; $rm43 = 1*$_REQUEST['rm43'];

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
  r38='$r38', rk38='$rk38', rn38='$rn38', rm38='$rm38',
  r39='$r39', rk39='$rk39', rn39='$rn39', rm39='$rm39',
  r40='$r40', rk40='$rk40', rn40='$rn40', rm40='$rm40',
  r41='$r41', rk41='$rk41', rn41='$rn41', rm41='$rm41',
  r42='$r42', rk42='$rk42', rn42='$rn42', rm42='$rm42',
  r43='$r43', rk43='$rk43', rn43='$rn43', rm43='$rm43' ".
" WHERE oc = $cislo_oc"; 
                    }

if ( $strana == 3 ) {
$r44 = 1*$_REQUEST['r44']; $rm44 = 1*$_REQUEST['rm44'];
$r45 = 1*$_REQUEST['r45']; $rm45 = 1*$_REQUEST['rm45'];
$r46 = 1*$_REQUEST['r46']; $rm46 = 1*$_REQUEST['rm46'];
$r47 = 1*$_REQUEST['r47']; $rm47 = 1*$_REQUEST['rm47'];
$r48 = 1*$_REQUEST['r48']; $rm48 = 1*$_REQUEST['rm48'];
$r49 = 1*$_REQUEST['r49']; $rm49 = 1*$_REQUEST['rm49'];
$r50 = 1*$_REQUEST['r50']; $rm50 = 1*$_REQUEST['rm50'];
$r51 = 1*$_REQUEST['r51']; $rm51 = 1*$_REQUEST['rm51'];
$r52 = 1*$_REQUEST['r52']; $rm52 = 1*$_REQUEST['rm52'];
$r53 = 1*$_REQUEST['r53']; $rm53 = 1*$_REQUEST['rm53'];
$r54 = 1*$_REQUEST['r54']; $rm54 = 1*$_REQUEST['rm54'];
$r55 = 1*$_REQUEST['r55']; $rm55 = 1*$_REQUEST['rm55'];
$r56 = 1*$_REQUEST['r56']; $rm56 = 1*$_REQUEST['rm56'];
$r57 = 1*$_REQUEST['r57']; $rm57 = 1*$_REQUEST['rm57'];
$r58 = 1*$_REQUEST['r58']; $rm58 = 1*$_REQUEST['rm58'];
$r59 = 1*$_REQUEST['r59']; $rm59 = 1*$_REQUEST['rm59'];
$r60 = 1*$_REQUEST['r60']; $rm60 = 1*$_REQUEST['rm60'];
$r61 = 1*$_REQUEST['r61']; $rm61 = 1*$_REQUEST['rm61'];
$r62 = 1*$_REQUEST['r62']; $rm62 = 1*$_REQUEST['rm62'];
$r63 = 1*$_REQUEST['r63']; $rm63 = 1*$_REQUEST['rm63'];
$r64 = 1*$_REQUEST['r64']; $rm64 = 1*$_REQUEST['rm64'];
$r65 = 1*$_REQUEST['r65']; $rm65 = 1*$_REQUEST['rm65'];
$r66 = 1*$_REQUEST['r66']; $rm66 = 1*$_REQUEST['rm66'];
$r67 = 1*$_REQUEST['r67']; $rm67 = 1*$_REQUEST['rm67'];
$r68 = 1*$_REQUEST['r68']; $rm68 = 1*$_REQUEST['rm68'];
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

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r44='$r44', rm44='$rm44', r45='$r45', rm45='$rm45', r46='$r46', rm46='$rm46',
  r47='$r47', rm47='$rm47', r48='$r48', rm48='$rm48', r49='$r49', rm49='$rm49',
  r50='$r50', rm50='$rm50', r51='$r51', rm51='$rm51', r52='$r52', rm52='$rm52',
  r53='$r53', rm53='$rm53', r54='$r54', rm54='$rm54', r55='$r55', rm55='$rm55',
  r56='$r56', rm56='$rm56', r57='$r57', rm57='$rm57', r58='$r58', rm58='$rm58',
  r59='$r59', rm59='$rm59', r60='$r60', rm60='$rm60', r61='$r61', rm61='$rm61',
  r62='$r62', rm62='$rm62', r63='$r63', rm63='$rm63', r64='$r64', rm64='$rm64',
  r65='$r65', rm65='$rm65', r66='$r66', rm66='$rm66', r67='$r67', rm67='$rm67',
  r68='$r68', rm68='$rm68', r69='$r69', rm69='$rm69', r70='$r70', rm70='$rm70',
  r70='$r70', rm70='$rm70', r71='$r71', rm71='$rm71', r72='$r72', rm72='$rm72',
  r73='$r73', rm73='$rm73', r74='$r74', rm74='$rm74', r75='$r75', rm75='$rm75',
  r76='$r76', rm76='$rm76', r77='$r77', rm77='$rm77', r78='$r78', rm78='$rm78',
  r79='$r79', rm79='$rm79' ".
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
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
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


$sql = "SELECT px08 FROM F".$kli_vxcf."_uctvykaz_fin204pod";
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
   px08         DECIMAL($pocdes) DEFAULT 0,
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
   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin204pod'.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec vytvorenie 


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
echo "NaËÌtavam hodnoty";

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" pmd,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" -pda,$cislo_oc,0,'','','0000-00-00',".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//exit;

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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume";
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykaz$kli_uzid"." SELECT".
" 0,$cislo_oc,0,'','','0000-00-00',".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
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

//exit;

//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 74 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk > 43 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 44 ) { 
$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rk$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rn$crdk=r$crdk-rk$crdk WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

                }

$sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=px08 WHERE rdk = $rdk ";
if( $rdk > 43 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctprcvykaz$kli_uzid SET rm$crdk=-px08 WHERE rdk = $rdk "; }
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
"SUM(r111),SUM(r112),SUM(r113),SUM(r114),SUM(r115),SUM(r116),SUM(r117),SUM(r118),".
"SUM(rk01),SUM(rk02),SUM(rk03),SUM(rk04),SUM(rk05),SUM(rk06),SUM(rk07),SUM(rk08),SUM(rk09),SUM(rk10),".
"SUM(rk11),SUM(rk12),SUM(rk13),SUM(rk14),SUM(rk15),SUM(rk16),SUM(rk17),SUM(rk18),SUM(rk19),SUM(rk20),".
"SUM(rk21),SUM(rk22),SUM(rk23),SUM(rk24),SUM(rk25),SUM(rk26),SUM(rk27),SUM(rk28),SUM(rk29),SUM(rk30),".
"SUM(rk31),SUM(rk32),SUM(rk33),SUM(rk34),SUM(rk35),SUM(rk36),SUM(rk37),SUM(rk38),SUM(rk39),SUM(rk40),".
"SUM(rk41),SUM(rk42),SUM(rk43),SUM(rk44),SUM(rk45),SUM(rk46),SUM(rk47),SUM(rk48),SUM(rk49),SUM(rk50),".
"SUM(rk51),SUM(rk52),SUM(rk53),SUM(rk54),SUM(rk55),SUM(rk56),SUM(rk57),SUM(rk58),SUM(rk59),SUM(rk60),".
"SUM(rk61),SUM(rk62),SUM(rk63),SUM(rk64),".
"SUM(rn01),SUM(rn02),SUM(rn03),SUM(rn04),SUM(rn05),SUM(rn06),SUM(rn07),SUM(rn08),SUM(rn09),SUM(rn10),".
"SUM(rn11),SUM(rn12),SUM(rn13),SUM(rn14),SUM(rn15),SUM(rn16),SUM(rn17),SUM(rn18),SUM(rn19),SUM(rn20),".
"SUM(rn21),SUM(rn22),SUM(rn23),SUM(rn24),SUM(rn25),SUM(rn26),SUM(rn27),SUM(rn28),SUM(rn29),SUM(rn30),".
"SUM(rn31),SUM(rn32),SUM(rn33),SUM(rn34),SUM(rn35),SUM(rn36),SUM(rn37),SUM(rn38),SUM(rn39),SUM(rn40),".
"SUM(rn41),SUM(rn42),SUM(rn43),SUM(rn44),SUM(rn45),SUM(rn46),SUM(rn47),SUM(rn48),SUM(rn49),SUM(rn50),".
"SUM(rn51),SUM(rn52),SUM(rn53),SUM(rn54),SUM(rn55),SUM(rn56),SUM(rn57),SUM(rn58),SUM(rn59),SUM(rn60),".
"SUM(rn61),SUM(rn62),SUM(rn63),SUM(rn64),".
"SUM(rm01),SUM(rm02),SUM(rm03),SUM(rm04),SUM(rm05),SUM(rm06),SUM(rm07),SUM(rm08),SUM(rm09),SUM(rm10),".
"SUM(rm11),SUM(rm12),SUM(rm13),SUM(rm14),SUM(rm15),SUM(rm16),SUM(rm17),SUM(rm18),SUM(rm19),SUM(rm20),".
"SUM(rm21),SUM(rm22),SUM(rm23),SUM(rm24),SUM(rm25),SUM(rm26),SUM(rm27),SUM(rm28),SUM(rm29),SUM(rm30),".
"SUM(rm31),SUM(rm32),SUM(rm33),SUM(rm34),SUM(rm35),SUM(rm36),SUM(rm37),SUM(rm38),SUM(rm39),SUM(rm40),".
"SUM(rm41),SUM(rm42),SUM(rm43),SUM(rm44),SUM(rm45),SUM(rm46),SUM(rm47),SUM(rm48),SUM(rm49),SUM(rm50),".
"SUM(rm51),SUM(rm52),SUM(rm53),SUM(rm54),SUM(rm55),SUM(rm56),SUM(rm57),SUM(rm58),SUM(rm59),SUM(rm60),".
"SUM(rm61),SUM(rm62),SUM(rm63),SUM(rm64),SUM(rm65),SUM(rm66),SUM(rm67),SUM(rm68),SUM(rm69),SUM(rm70),".
"SUM(rm71),SUM(rm72),SUM(rm73),SUM(rm74),SUM(rm75),SUM(rm76),SUM(rm77),SUM(rm78),SUM(rm79),SUM(rm80),".
"SUM(rm81),SUM(rm82),SUM(rm83),SUM(rm84),SUM(rm85),SUM(rm86),SUM(rm87),SUM(rm88),SUM(rm89),SUM(rm90),".
"SUM(rm91),SUM(rm92),".
"$fir_fico".
" FROM F$kli_vxcf"."_uctprcvykaz$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



$dsqlt = "UPDATE F$kli_vxcf"."_uctprcvykaz".$kli_uzid." ".
" SET r11=r11+r12, rk11=rk11+rk12, rn11=rn11+rn12  WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_uctprcvykaz".$kli_uzid." WHERE oc = $cislo_oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/////////////////////////////////koniec naCITAJ HODNOTY

//uloz 
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin204pod".
" SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." WHERE oc = $cislo_oc AND prx = 1 ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

  if ( $nasielvyplnene == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET okres='$xokres',  obec='$xobec'  WHERE oc = $cislo_oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

  }


}
//koniec pracovneho suboru pre rocne 

//vypocty
if( $copern == 10 OR $copern == 20 )
{

//vypocitaj riadky strana 2
$vsldat="uctprcvykaz";
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r01=r02+r03+r05, ".
"r06=r07+r08+r04+r09+r10+r11+r13+r14+r15+r16, ".
"r17=r18+r19+r20+r21+r22, ".
"r24=r25+r26+r27+r28+r29+r30+r31+r32+r33+r34+r35, ".
"r36=r37+r38+r39+r40+r41, ". 

"rk01=rk02+rk03+rk05, ".
"rk06=rk07+rk08+rk04+rk09+rk10+rk11+rk13+rk14+rk15+rk16, ".
"rk17=rk18+rk19+rk20+rk21+rk22, ".
"rk24=rk25+rk26+rk27+rk28+rk29+rk30+rk31+rk32+rk33+rk34+rk35, ".
"rk36=rk37+rk38+rk39+rk40+rk41, ".

"rn01=rn02+rn03+rn05, ".
"rn06=rn07+rn08+rn04+rn09+rn10+rn11+rn13+rn14+rn15+rn16, ".
"rn17=rn18+rn19+rn20+rn21+rn22, ".
"rn24=rn25+rn26+rn27+rn28+rn29+rn30+rn31+rn32+rn33+rn34+rn35, ".
"rn36=rn37+rn38+rn39+rn40+rn41, ".

"rm01=rm02+rm03+rm05, ".
"rm06=rm07+rm08+rm04+rm09+rm10+rm11+rm13+rm14+rm15+rm16, ".
"rm17=rm18+rm19+rm20+rm21+rm22, ".
"rm24=rm25+rm26+rm27+rm28+rm29+rm30+rm31+rm32+rm33+rm34+rm35, ".
"rm36=rm37+rm38+rm39+rm40+rm41 ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r43=r01+r06+r17+r23+r24+r36+r42, ".
"rk43=rk01+rk06+rk17+rk23+rk24+rk36+rk42, ".
"rn43=rn01+rn06+rn17+rn23+rn24+rn36+rn42, ".
"rm43=rm01+rm06+rm17+rm23+rm24+rm36+rm42  ".
" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

//vypocitaj riadky strana 3
$vsldat="uctprcvykaz";
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r45=r46+r47+r48+r49+r50+r53+r56+r59+r60+r61+r62+r63+r64+r65, ".
"r68=r69+r70+r71+r72, ".

"rm45=rm46+rm47+rm48+rm49+rm50+rm53+rm56+rm59+rm60+rm61+rm62+rm63+rm64+rm65, ".
"rm68=rm69+rm70+rm71+rm72  ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");

$vsldat="uctprcvykaz";
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
"r74=r44+r45+r68+r73, ".

"rm74=rm44+rm45+rm68+rm73  ".

" WHERE oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin204pod SET ".
" r51=r50-r52, r54=r53-r55, r57=r56-r58, r66=r65-r67  ".

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
}

if ( $strana == 3 )
{
$r44 = $fir_riadok->r44;
$rm44 = $fir_riadok->rm44;
$r45 = $fir_riadok->r45;
$rm45 = $fir_riadok->rm45;
$r46 = $fir_riadok->r46;
$rm46 = $fir_riadok->rm46;
$r47 = $fir_riadok->r47;
$rm47 = $fir_riadok->rm47;
$r48 = $fir_riadok->r48;
$rm48 = $fir_riadok->rm48;
$r49 = $fir_riadok->r49;
$rm49 = $fir_riadok->rm49;
$r50 = $fir_riadok->r50;
$rm50 = $fir_riadok->rm50;
$r51 = $fir_riadok->r51;
$rm51 = $fir_riadok->rm51;
$r52 = $fir_riadok->r52;
$rm52 = $fir_riadok->rm52;
$r53 = $fir_riadok->r53;
$rm53 = $fir_riadok->rm53;
$r54 = $fir_riadok->r54;
$rm54 = $fir_riadok->rm54;
$r55 = $fir_riadok->r55;
$rm55 = $fir_riadok->rm55;
$r56 = $fir_riadok->r56;
$rm56 = $fir_riadok->rm56;
$r57 = $fir_riadok->r57;
$rm57 = $fir_riadok->rm57;
$r58 = $fir_riadok->r58;
$rm58 = $fir_riadok->rm58;
$r59 = $fir_riadok->r59;
$rm59 = $fir_riadok->rm59;
$r60 = $fir_riadok->r60;
$rm60 = $fir_riadok->rm60;
$r61 = $fir_riadok->r61;
$rm61 = $fir_riadok->rm61;
$r62 = $fir_riadok->r62;
$rm62 = $fir_riadok->rm62;
$r63 = $fir_riadok->r63;
$rm63 = $fir_riadok->rm63;
$r64 = $fir_riadok->r64;
$rm64 = $fir_riadok->rm64;
$r65 = $fir_riadok->r65;
$rm65 = $fir_riadok->rm65;
$r66 = $fir_riadok->r66;
$rm66 = $fir_riadok->rm66;
$r67 = $fir_riadok->r67;
$rm67 = $fir_riadok->rm67;
$r68 = $fir_riadok->r68;
$rm68 = $fir_riadok->rm68;
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
}
mysql_free_result($fir_vysledok);
    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
$skutku=substr($datum,0,6);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>V˝kaz FIN 2-04 POD</title>
<style type="text/css">
img.btn-row-tool {
  width: 20px;
  height: 20px;
}
form input[type=text] {
  height: 14px;
  line-height: 14px;
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

</style>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.daz.value = '<?php echo $daz_sk;?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
//   document.formv1.r01.value = '<?php echo $r01;?>';
//   document.formv1.rk01.value = '<?php echo $rk01;?>';
//   document.formv1.rn01.value = '<?php echo $rn01;?>';
//   document.formv1.rm01.value = '<?php echo $rm01;?>';
   document.formv1.r02.value = '<?php echo $r02;?>';
   document.formv1.rk02.value = '<?php echo $rk02;?>';
   document.formv1.rn02.value = '<?php echo $rn02;?>';
   document.formv1.rm02.value = '<?php echo $rm02;?>';
   document.formv1.r03.value = '<?php echo $r03;?>';
   document.formv1.rk03.value = '<?php echo $rk03;?>';
   document.formv1.rn03.value = '<?php echo $rn03;?>';
   document.formv1.rm03.value = '<?php echo $rm03;?>';
   document.formv1.r04.value = '<?php echo $r04;?>';
   document.formv1.rk04.value = '<?php echo $rk04;?>';
   document.formv1.rn04.value = '<?php echo $rn04;?>';
   document.formv1.rm04.value = '<?php echo $rm04;?>';
   document.formv1.r05.value = '<?php echo $r05;?>';
   document.formv1.rk05.value = '<?php echo $rk05;?>';
   document.formv1.rn05.value = '<?php echo $rn05;?>';
   document.formv1.rm05.value = '<?php echo $rm05;?>';
//   document.formv1.r06.value = '<?php echo $r06;?>';
//   document.formv1.rk06.value = '<?php echo $rk06;?>';
//   document.formv1.rn06.value = '<?php echo $rn06;?>';
//   document.formv1.rm06.value = '<?php echo $rm06;?>';
   document.formv1.r07.value = '<?php echo $r07;?>';
   document.formv1.rk07.value = '<?php echo $rk07;?>';
   document.formv1.rn07.value = '<?php echo $rn07;?>';
   document.formv1.rm07.value = '<?php echo $rm07;?>';
   document.formv1.r08.value = '<?php echo $r08;?>';
   document.formv1.rk08.value = '<?php echo $rk08;?>';
   document.formv1.rn08.value = '<?php echo $rn08;?>';
   document.formv1.rm08.value = '<?php echo $rm08;?>';
   document.formv1.r09.value = '<?php echo $r09;?>';
   document.formv1.rk09.value = '<?php echo $rk09;?>';
   document.formv1.rn09.value = '<?php echo $rn09;?>';
   document.formv1.rm09.value = '<?php echo $rm09;?>';
   document.formv1.r10.value = '<?php echo $r10;?>';
   document.formv1.rk10.value = '<?php echo $rk10;?>';
   document.formv1.rn10.value = '<?php echo $rn10;?>';
   document.formv1.rm10.value = '<?php echo $rm10;?>';
   document.formv1.r11.value = '<?php echo $r11;?>';
   document.formv1.rk11.value = '<?php echo $rk11;?>';
   document.formv1.rn11.value = '<?php echo $rn11;?>';
   document.formv1.rm11.value = '<?php echo $rm11;?>';
   document.formv1.r12.value = '<?php echo $r12;?>';
   document.formv1.rk12.value = '<?php echo $rk12;?>';
   document.formv1.rn12.value = '<?php echo $rn12;?>';
   document.formv1.rm12.value = '<?php echo $rm12;?>';
   document.formv1.r13.value = '<?php echo $r13;?>';
   document.formv1.rk13.value = '<?php echo $rk13;?>';
   document.formv1.rn13.value = '<?php echo $rn13;?>';
   document.formv1.rm13.value = '<?php echo $rm13;?>';
   document.formv1.r14.value = '<?php echo $r14;?>';
   document.formv1.rk14.value = '<?php echo $rk14;?>';
   document.formv1.rn14.value = '<?php echo $rn14;?>';
   document.formv1.rm14.value = '<?php echo $rm14;?>';
   document.formv1.r15.value = '<?php echo $r15;?>';
   document.formv1.rk15.value = '<?php echo $rk15;?>';
   document.formv1.rn15.value = '<?php echo $rn15;?>';
   document.formv1.rm15.value = '<?php echo $rm15;?>';
   document.formv1.r16.value = '<?php echo $r16;?>';
   document.formv1.rk16.value = '<?php echo $rk16;?>';
   document.formv1.rn16.value = '<?php echo $rn16;?>';
   document.formv1.rm16.value = '<?php echo $rm16;?>';
//   document.formv1.r17.value = '<?php echo $r17;?>';
//   document.formv1.rk17.value = '<?php echo $rk17;?>';
//   document.formv1.rn17.value = '<?php echo $rn17;?>';
//   document.formv1.rm17.value = '<?php echo $rm17;?>';
   document.formv1.r18.value = '<?php echo $r18;?>';
   document.formv1.rk18.value = '<?php echo $rk18;?>';
   document.formv1.rn18.value = '<?php echo $rn18;?>';
   document.formv1.rm18.value = '<?php echo $rm18;?>';
   document.formv1.r19.value = '<?php echo $r19;?>';
   document.formv1.rk19.value = '<?php echo $rk19;?>';
   document.formv1.rn19.value = '<?php echo $rn19;?>';
   document.formv1.rm19.value = '<?php echo $rm19;?>';
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
//   document.formv1.r24.value = '<?php echo $r24;?>';
//   document.formv1.rk24.value = '<?php echo $rk24;?>';
//   document.formv1.rn24.value = '<?php echo $rn24;?>';
//   document.formv1.rm24.value = '<?php echo $rm24;?>';
   document.formv1.r25.value = '<?php echo $r25;?>';
   document.formv1.rk25.value = '<?php echo $rk25;?>';
   document.formv1.rn25.value = '<?php echo $rn25;?>';
   document.formv1.rm25.value = '<?php echo $rm25;?>';
   document.formv1.r26.value = '<?php echo $r26;?>';
   document.formv1.rk26.value = '<?php echo $rk26;?>';
   document.formv1.rn26.value = '<?php echo $rn26;?>';
   document.formv1.rm26.value = '<?php echo $rm26;?>';
   document.formv1.r27.value = '<?php echo $r27;?>';
   document.formv1.rk27.value = '<?php echo $rk27;?>';
   document.formv1.rn27.value = '<?php echo $rn27;?>';
   document.formv1.rm27.value = '<?php echo $rm27;?>';
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
   document.formv1.r35.value = '<?php echo $r35;?>';
   document.formv1.rk35.value = '<?php echo $rk35;?>';
   document.formv1.rn35.value = '<?php echo $rn35;?>';
   document.formv1.rm35.value = '<?php echo $rm35;?>';
//   document.formv1.r36.value = '<?php echo $r36;?>';
//   document.formv1.rk36.value = '<?php echo $rk36;?>';
//   document.formv1.rn36.value = '<?php echo $rn36;?>';
//   document.formv1.rm36.value = '<?php echo $rm36;?>';
   document.formv1.r37.value = '<?php echo $r37;?>';
   document.formv1.rk37.value = '<?php echo $rk37;?>';
   document.formv1.rn37.value = '<?php echo $rn37;?>';
   document.formv1.rm37.value = '<?php echo $rm37;?>';
   document.formv1.r38.value = '<?php echo $r38;?>';
   document.formv1.rk38.value = '<?php echo $rk38;?>';
   document.formv1.rn38.value = '<?php echo $rn38;?>';
   document.formv1.rm38.value = '<?php echo $rm38;?>';
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
//   document.formv1.r43.value = '<?php echo $r43;?>';
//   document.formv1.rk43.value = '<?php echo $rk43;?>';
//   document.formv1.rn43.value = '<?php echo $rn43;?>';
//   document.formv1.rm43.value = '<?php echo $rm43;?>';
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
//   document.formv1.r44.value = '<?php echo $r44;?>';
//   document.formv1.rm44.value = '<?php echo $rm44;?>';
   document.formv1.r45.value = '<?php echo $r45;?>';
   document.formv1.rm45.value = '<?php echo $rm45;?>';
   document.formv1.r46.value = '<?php echo $r46;?>';
   document.formv1.rm46.value = '<?php echo $rm46;?>';
   document.formv1.r47.value = '<?php echo $r47;?>';
   document.formv1.rm47.value = '<?php echo $rm47;?>';
   document.formv1.r48.value = '<?php echo $r48;?>';
   document.formv1.rm48.value = '<?php echo $rm48;?>';
   document.formv1.r49.value = '<?php echo $r49;?>';
   document.formv1.rm49.value = '<?php echo $rm49;?>';
//   document.formv1.r50.value = '<?php echo $r50;?>';
//   document.formv1.rm50.value = '<?php echo $rm50;?>';
   document.formv1.r51.value = '<?php echo $r51;?>';
   document.formv1.rm51.value = '<?php echo $rm51;?>';
   document.formv1.r52.value = '<?php echo $r52;?>';
   document.formv1.rm52.value = '<?php echo $rm52;?>';
   document.formv1.r53.value = '<?php echo $r53;?>';
   document.formv1.rm53.value = '<?php echo $rm53;?>';
   document.formv1.r54.value = '<?php echo $r54;?>';
   document.formv1.rm54.value = '<?php echo $rm54;?>';
   document.formv1.r55.value = '<?php echo $r55;?>';
   document.formv1.rm55.value = '<?php echo $rm55;?>';
   document.formv1.r56.value = '<?php echo $r56;?>';
   document.formv1.rm56.value = '<?php echo $rm56;?>';
   document.formv1.r57.value = '<?php echo $r57;?>';
   document.formv1.rm57.value = '<?php echo $rm57;?>';
   document.formv1.r58.value = '<?php echo $r58;?>';
   document.formv1.rm58.value = '<?php echo $rm58;?>';
   document.formv1.r59.value = '<?php echo $r59;?>';
   document.formv1.rm59.value = '<?php echo $rm59;?>';
   document.formv1.r60.value = '<?php echo $r60;?>';
   document.formv1.rm60.value = '<?php echo $rm60;?>';
   document.formv1.r61.value = '<?php echo $r61;?>';
   document.formv1.rm61.value = '<?php echo $rm61;?>';
   document.formv1.r62.value = '<?php echo $r62;?>';
   document.formv1.rm62.value = '<?php echo $rm62;?>';
   document.formv1.r63.value = '<?php echo $r63;?>';
   document.formv1.rm63.value = '<?php echo $rm63;?>';
   document.formv1.r64.value = '<?php echo $r64;?>';
   document.formv1.rm64.value = '<?php echo $rm64;?>';
   document.formv1.r65.value = '<?php echo $r65;?>';
   document.formv1.rm65.value = '<?php echo $rm65;?>';
   document.formv1.r66.value = '<?php echo $r66;?>';
   document.formv1.rm66.value = '<?php echo $rm66;?>';
   document.formv1.r67.value = '<?php echo $r67;?>';
   document.formv1.rm67.value = '<?php echo $rm67;?>';
   document.formv1.r68.value = '<?php echo $r68;?>';
   document.formv1.rm68.value = '<?php echo $rm68;?>';
   document.formv1.r69.value = '<?php echo $r69;?>';
   document.formv1.rm69.value = '<?php echo $rm69;?>';
   document.formv1.r70.value = '<?php echo $r70;?>';
   document.formv1.rm70.value = '<?php echo $rm70;?>';
   document.formv1.r71.value = '<?php echo $r71;?>';
   document.formv1.rm71.value = '<?php echo $rm71;?>';
   document.formv1.r72.value = '<?php echo $r72;?>';
   document.formv1.rm72.value = '<?php echo $rm72;?>';
//   document.formv1.r73.value = '<?php echo $r73;?>';
//   document.formv1.rm73.value = '<?php echo $rm73;?>';
   document.formv1.r74.value = '<?php echo $r74;?>';
   document.formv1.rm74.value = '<?php echo $rm74;?>';
   document.formv1.r75.value = '<?php echo $r75;?>';
   document.formv1.rm75.value = '<?php echo $rm75;?>';
   document.formv1.r76.value = '<?php echo $r76;?>';
   document.formv1.rm76.value = '<?php echo $rm76;?>';
   document.formv1.r77.value = '<?php echo $r77;?>';
   document.formv1.rm77.value = '<?php echo $rm77;?>';
   document.formv1.r78.value = '<?php echo $r78;?>';
   document.formv1.rm78.value = '<?php echo $rm78;?>';
//   document.formv1.r79.value = '<?php echo $r79;?>';
//   document.formv1.rm79.value = '<?php echo $rm79;?>';
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


  function Generuj()
  { 
   window.open('../ucto/fin_cis.php?copern=308&drupoh=91&page=1', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_vysvetlivky.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz() //dopyt, daù do pÙvodnÈho stavu, pravdepodobne cislo_oc s˙visÌ so ötvrùrok
  {
   window.open('vykaz_fin204pod_2016.php?copern=10&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); //dopyt, m· v˝znam cislo_oc,page,subor
  }
  function Nacitaj()
  {
   window.open('vykaz_fin204pod_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); //dopyt, m· v˝znam cislo_oc,page,subor
  }

</script>
</HEAD> <!-- dopyt, nezabudn˙ù na export do dbf skontrolovaù -->
<BODY onload="ObnovUI();">
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
  <td class="header">FIN 2-04 VybranÈ aktÌva a pasÌva podnikateæskÈho subjektu za
   <span style="color:#39f;"><?php echo "$cislo_oc. ötvrùrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
<a href="#" onClick="Generuj();"><img src='../obr/zoznam.png' width=15 height=15 title="Nastaviù generovanie"></a> <!-- dopyt, daù do zoznamu zost·v -->
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie v˝kazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="Nacitaj();" title="NaËÌtaù ˙daje" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<?php if ( $strana < 1 OR $strana > 3 ) $strana=1; ?>

<div id="content">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin204pod_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active";
$source="vykaz_fin204pod_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3', '_self');" class="<?php echo $clas3; ?> toleft">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a> <!-- dopyt, asi daù aj cislo_oc Ëo je asi ötrvrùok -->
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a> <!-- dopyt, nakoniec zruöiù tlaËiù po stran·ch -->
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

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
<input type="text" name="daz" id="daz" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:966px; left:236px; height:22px; line-height:22px; font-size:14px; padding-left:4px;"/>
<?php                     } //koniec 1.strana ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 265kB">
<span class="text-echo" style="top:143px; left:666px; font-size:14px;"><?php echo $skutku; ?></span>

<!-- 4.1.Vybrane aktiva -->
<!-- 1.DnHM -->
<span class="text-echo" style="top:233px; right:339px; font-size:12px;"><?php echo $r01; ?></span>
<span class="text-echo" style="top:233px; right:262px; font-size:12px;"><?php echo $rk01; ?></span>
<span class="text-echo" style="top:233px; right:185px; font-size:12px;"><?php echo $rn01; ?></span>
<span class="text-echo" style="top:233px; right:50px; font-size:12px;"><?php echo $rm01; ?></span>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:254px; left:541px;"/>
<input type="text" name="rk02" id="rk02" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:254px; left:618px;"/>
<input type="text" name="rn02" id="rn02" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:254px; left:695px;"/>
<input type="text" name="rm02" id="rm02" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:254px; left:773px;"/>
<input type="text" name="r03" id="r03" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:279px; left:541px;"/>
<input type="text" name="rk03" id="rk03" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:279px; left:618px;"/>
<input type="text" name="rn03" id="rn03" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:279px; left:695px;"/>
<input type="text" name="rm03" id="rm03" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:279px; left:773px;"/>
<input type="text" name="r04" id="r04" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:304px; left:541px;"/>
<input type="text" name="rk04" id="rk04" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:304px; left:618px;"/>
<input type="text" name="rn04" id="rn04" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:304px; left:695px;"/>
<input type="text" name="rm04" id="rm04" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:304px; left:773px;"/>
<input type="text" name="r05" id="r05" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:329px; left:541px;"/>
<input type="text" name="rk05" id="rk05" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:329px; left:618px;"/>
<input type="text" name="rn05" id="rn05" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:329px; left:695px;"/>
<input type="text" name="rm05" id="rm05" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:329px; left:773px;"/>
<!-- 6.DHM -->
<span class="text-echo" style="top:358px; right:339px; font-size:12px;"><?php echo $r06; ?></span>
<span class="text-echo" style="top:358px; right:262px; font-size:12px;"><?php echo $rk06; ?></span>
<span class="text-echo" style="top:358px; right:185px; font-size:12px;"><?php echo $rn06; ?></span>
<span class="text-echo" style="top:358px; right:50px; font-size:12px;"><?php echo $rm06; ?></span>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:379px; left:541px;"/>
<input type="text" name="rk07" id="rk07" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:379px; left:618px;"/>
<input type="text" name="rn07" id="rn07" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:379px; left:695px;"/>
<input type="text" name="rm07" id="rm07" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:379px; left:773px;"/>
<input type="text" name="r08" id="r08" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:403px; left:541px;"/>
<input type="text" name="rk08" id="rk08" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:403px; left:618px;"/>
<input type="text" name="rn08" id="rn08" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:403px; left:695px;"/>
<input type="text" name="rm08" id="rm08" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:403px; left:773px;"/>
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:428px; left:541px;"/>
<input type="text" name="rk09" id="rk09" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:428px; left:618px;"/>
<input type="text" name="rn09" id="rn09" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:428px; left:695px;"/>
<input type="text" name="rm09" id="rm09" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:428px; left:773px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:453px; left:541px;"/>
<input type="text" name="rk10" id="rk10" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:453px; left:618px;"/>
<input type="text" name="rn10" id="rn10" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:453px; left:695px;"/>
<input type="text" name="rm10" id="rm10" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:453px; left:773px;"/>
<input type="text" name="r11" id="r11" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:478px; left:541px;"/>
<input type="text" name="rk11" id="rk11" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:478px; left:618px;"/>
<input type="text" name="rn11" id="rn11" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:478px; left:695px;"/>
<input type="text" name="rm11" id="rm11" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:478px; left:773px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:503px; left:541px;"/>
<input type="text" name="rk12" id="rk12" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:503px; left:618px;"/>
<input type="text" name="rn12" id="rn12" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:503px; left:695px;"/>
<input type="text" name="rm12" id="rm12" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:503px; left:773px;"/>
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:528px; left:541px;"/>
<input type="text" name="rk13" id="rk13" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:528px; left:618px;"/>
<input type="text" name="rn13" id="rn13" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:528px; left:695px;"/>
<input type="text" name="rm13" id="rm13" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:528px; left:773px;"/>
<input type="text" name="r14" id="r14" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:553px; left:541px;"/>
<input type="text" name="rk14" id="rk14" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:553px; left:618px;"/>
<input type="text" name="rn14" id="rn14" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:553px; left:695px;"/>
<input type="text" name="rm14" id="rm14" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:553px; left:773px;"/>
<input type="text" name="r15" id="r15" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:577px; left:541px;"/>
<input type="text" name="rk15" id="rk15" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:577px; left:618px;"/>
<input type="text" name="rn15" id="rn15" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:577px; left:695px;"/>
<input type="text" name="rm15" id="rm15" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:577px; left:773px;"/>
<input type="text" name="r16" id="r16" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:602px; left:541px;"/>
<input type="text" name="rk16" id="rk16" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:602px; left:618px;"/>
<input type="text" name="rn16" id="rn16" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:602px; left:695px;"/>
<input type="text" name="rm16" id="rm16" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:602px; left:773px;"/>
<!-- 17.DFM -->
<span class="text-echo" style="top:631px; right:339px; font-size:12px;"><?php echo $r17; ?></span>
<span class="text-echo" style="top:631px; right:262px; font-size:12px;"><?php echo $rk17; ?></span>
<span class="text-echo" style="top:631px; right:185px; font-size:12px;"><?php echo $rn17; ?></span>
<span class="text-echo" style="top:631px; right:50px; font-size:12px;"><?php echo $rm17; ?></span>
<input type="text" name="r18" id="r18" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:652px; left:541px;"/>
<input type="text" name="rk18" id="rk18" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:652px; left:618px;"/>
<input type="text" name="rn18" id="rn18" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:652px; left:695px;"/>
<input type="text" name="rm18" id="rm18" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:652px; left:773px;"/>
<input type="text" name="r19" id="r19" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:677px; left:541px;"/>
<input type="text" name="rk19" id="rk19" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:677px; left:618px;"/>
<input type="text" name="rn19" id="rn19" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:677px; left:695px;"/>
<input type="text" name="rm19" id="rm19" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:677px; left:773px;"/>
<input type="text" name="r20" id="r20" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:702px; left:541px;"/>
<input type="text" name="rk20" id="rk20" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:702px; left:618px;"/>
<input type="text" name="rn20" id="rn20" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:702px; left:695px;"/>
<input type="text" name="rm20" id="rm20" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:702px; left:773px;"/>
<input type="text" name="r21" id="r21" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:727px; left:541px;"/>
<input type="text" name="rk21" id="rk21" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:727px; left:618px;"/>
<input type="text" name="rn21" id="rn21" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:727px; left:695px;"/>
<input type="text" name="rm21" id="rm21" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:727px; left:773px;"/>
<input type="text" name="r22" id="r22" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:752px; left:541px;"/>
<input type="text" name="rk22" id="rk22" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:752px; left:618px;"/>
<input type="text" name="rn22" id="rn22" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:752px; left:695px;"/>
<input type="text" name="rm22" id="rm22" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:752px; left:773px;"/>
<!-- 23.ZASOBY -->
<input type="text" name="r23" id="r23" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:777px; left:541px;"/>
<input type="text" name="rk23" id="rk23" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:777px; left:618px;"/>
<input type="text" name="rn23" id="rn23" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:777px; left:695px;"/>
<input type="text" name="rm23" id="rm23" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:777px; left:773px;"/>
<!-- 24.POHLADAVKY -->
<span class="text-echo" style="top:805px; right:339px; font-size:12px;"><?php echo $r24; ?></span>
<span class="text-echo" style="top:805px; right:262px; font-size:12px;"><?php echo $rk24; ?></span>
<span class="text-echo" style="top:805px; right:185px; font-size:12px;"><?php echo $rn24; ?></span>
<span class="text-echo" style="top:805px; right:50px; font-size:12px;"><?php echo $rm24; ?></span>
<input type="text" name="r25" id="r25" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:826px; left:541px;"/>
<input type="text" name="rk25" id="rk25" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:826px; left:618px;"/>
<input type="text" name="rn25" id="rn25" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:826px; left:695px;"/>
<input type="text" name="rm25" id="rm25" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:826px; left:773px;"/>
<input type="text" name="r26" id="r26" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:851px; left:541px;"/>
<input type="text" name="rk26" id="rk26" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:851px; left:618px;"/>
<input type="text" name="rn26" id="rn26" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:851px; left:695px;"/>
<input type="text" name="rm26" id="rm26" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:851px; left:773px;"/>
<input type="text" name="r27" id="r27" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:876px; left:541px;"/>
<input type="text" name="rk27" id="rk27" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:876px; left:618px;"/>
<input type="text" name="rn27" id="rn27" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:876px; left:695px;"/>
<input type="text" name="rm27" id="rm27" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:876px; left:773px;"/>
<input type="text" name="r28" id="r28" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:901px; left:541px;"/>
<input type="text" name="rk28" id="rk28" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:901px; left:618px;"/>
<input type="text" name="rn28" id="rn28" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:901px; left:695px;"/>
<input type="text" name="rm28" id="rm28" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:901px; left:773px;"/>
<input type="text" name="r29" id="r29" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:925px; left:541px;"/>
<input type="text" name="rk29" id="rk29" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:925px; left:618px;"/>
<input type="text" name="rn29" id="rn29" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:925px; left:695px;"/>
<input type="text" name="rm29" id="rm29" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:925px; left:773px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:951px; left:541px;"/>
<input type="text" name="rk30" id="rk30" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:951px; left:618px;"/>
<input type="text" name="rn30" id="rn30" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:951px; left:695px;"/>
<input type="text" name="rm30" id="rm30" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:951px; left:773px;"/>
<input type="text" name="r31" id="r31" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:976px; left:541px;"/>
<input type="text" name="rk31" id="rk31" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:976px; left:618px;"/>
<input type="text" name="rn31" id="rn31" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:976px; left:695px;"/>
<input type="text" name="rm31" id="rm31" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:976px; left:773px;"/>
<input type="text" name="r32" id="r32" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1000px; left:541px;"/>
<input type="text" name="rk32" id="rk32" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1000px; left:618px;"/>
<input type="text" name="rn32" id="rn32" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1000px; left:695px;"/>
<input type="text" name="rm32" id="rm32" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1000px; left:773px;"/>
<input type="text" name="r33" id="r33" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1025px; left:541px;"/>
<input type="text" name="rk33" id="rk33" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1025px; left:618px;"/>
<input type="text" name="rn33" id="rn33" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1025px; left:695px;"/>
<input type="text" name="rm33" id="rm33" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1025px; left:773px;"/>
<input type="text" name="r34" id="r34" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1052px; left:541px;"/>
<input type="text" name="rk34" id="rk34" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1052px; left:618px;"/>
<input type="text" name="rn34" id="rn34" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1052px; left:695px;"/>
<input type="text" name="rm34" id="rm34" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1052px; left:773px;"/>
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1079px; left:541px;"/>
<input type="text" name="rk35" id="rk35" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1079px; left:618px;"/>
<input type="text" name="rn35" id="rn35" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1079px; left:695px;"/>
<input type="text" name="rm35" id="rm35" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1079px; left:773px;"/>
<!-- 36.FU -->
<span class="text-echo" style="top:1108px; right:339px; font-size:12px;"><?php echo $r36; ?></span>
<span class="text-echo" style="top:1108px; right:262px; font-size:12px;"><?php echo $rk36; ?></span>
<span class="text-echo" style="top:1108px; right:185px; font-size:12px;"><?php echo $rn36; ?></span>
<span class="text-echo" style="top:1108px; right:50px; font-size:12px;"><?php echo $rm36; ?></span>
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1129px; left:541px;"/>
<input type="text" name="rk37" id="rk37" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1129px; left:618px;"/>
<input type="text" name="rn37" id="rn37" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1129px; left:695px;"/>
<input type="text" name="rm37" id="rm37" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1129px; left:773px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1154px; left:541px;"/>
<input type="text" name="rk38" id="rk38" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1154px; left:618px;"/>
<input type="text" name="rn38" id="rn38" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1154px; left:695px;"/>
<input type="text" name="rm38" id="rm38" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1154px; left:773px;"/>
<input type="text" name="r39" id="r39" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1179px; left:541px;"/>
<input type="text" name="rk39" id="rk39" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1179px; left:618px;"/>
<input type="text" name="rn39" id="rn39" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1179px; left:695px;"/>
<input type="text" name="rm39" id="rm39" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1179px; left:773px;"/>
<input type="text" name="r40" id="r40" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1203px; left:541px;"/>
<input type="text" name="rk40" id="rk40" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1203px; left:618px;"/>
<input type="text" name="rn40" id="rn40" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1203px; left:695px;"/>
<input type="text" name="rm40" id="rm40" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1203px; left:773px;"/>
<input type="text" name="r41" id="r41" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1228px; left:541px;"/>
<input type="text" name="rk41" id="rk41" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1228px; left:618px;"/>
<input type="text" name="rn41" id="rn41" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1228px; left:695px;"/>
<input type="text" name="rm41" id="rm41" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1228px; left:773px;"/>
<!-- 42.CAS.ROZLISENIE -->
<input type="text" name="r42" id="r42" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1253px; left:541px;"/>
<input type="text" name="rk42" id="rk42" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1253px; left:618px;"/>
<input type="text" name="rn42" id="rn42" onkeyup="CiarkaNaBodku(this);" style="width:67px; top:1253px; left:695px;"/>
<input type="text" name="rm42" id="rm42" onkeyup="CiarkaNaBodku(this);" style="width:125px; top:1253px; left:773px;"/>
<!-- 43.AKTIVA SPOLU -->
<span class="text-echo" style="top:1282px; right:339px; font-size:12px;"><?php echo $r43; ?></span>
<span class="text-echo" style="top:1282px; right:262px; font-size:12px;"><?php echo $rk43; ?></span>
<span class="text-echo" style="top:1282px; right:185px; font-size:12px;"><?php echo $rn43; ?></span>
<span class="text-echo" style="top:1282px; right:50px; font-size:12px;"><?php echo $rm43; ?></span>
<!-- dopyt, skontrolovaù v˝poËty -->
<?php                     } //koniec 2.strana ?>

<?php if ( $strana == 3 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 265kB">
<span class="text-echo" style="top:95px; left:672px; font-size:14px;"><?php echo $skutku; ?></span>

<!-- 4.2.Vybrane pasiva -->
<!-- 44.VI -->
<span class="text-echo" style="top:168px; right:186px; font-size:14px;"><?php echo $r44; ?></span>
<span class="text-echo" style="top:168px; right:50px; font-size:14px;"><?php echo $rm44; ?></span>
<input type="text" name="r45" id="r45" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:191px; left:600px;"/>
<input type="text" name="rm45" id="rm45" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:191px; left:785px;"/>
<input type="text" name="r46" id="r46" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:218px; left:600px;"/>
<input type="text" name="rm46" id="rm46" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:218px; left:785px;"/>
<input type="text" name="r47" id="r47" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:245px; left:600px;"/>
<input type="text" name="rm47" id="rm47" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:245px; left:785px;"/>
<input type="text" name="r48" id="r48" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:270px; left:600px;"/>
<input type="text" name="rm48" id="rm48" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:270px; left:785px;"/>
<!-- 49.REZERVY -->
<input type="text" name="r49" id="r49" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:294px; left:600px;"/>
<input type="text" name="rm49" id="rm49" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:294px; left:785px;"/>
<!-- 50.ZAVAZKY -->
<span class="text-echo" style="top:321px; right:186px; font-size:14px;"><?php echo $r50; ?></span>
<span class="text-echo" style="top:321px; right:50px; font-size:14px;"><?php echo $rm50; ?></span>
<input type="text" name="r51" id="r51" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:344px; left:600px;"/>
<input type="text" name="rm51" id="rm51" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:344px; left:785px;"/>
<input type="text" name="r52" id="r52" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:369px; left:600px;"/>
<input type="text" name="rm52" id="rm52" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:369px; left:785px;"/>
<input type="text" name="r53" id="r53" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:394px; left:600px;"/>
<input type="text" name="rm53" id="rm53" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:394px; left:785px;"/>
<input type="text" name="r54" id="r54" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:418px; left:600px;"/>
<input type="text" name="rm54" id="rm54" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:418px; left:785px;"/>
<input type="text" name="r55" id="r55" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:444px; left:600px;"/>
<input type="text" name="rm55" id="rm55" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:444px; left:785px;"/>
<input type="text" name="r56" id="r56" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:468px; left:600px;"/>
<input type="text" name="rm56" id="rm56" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:468px; left:785px;"/>
<input type="text" name="r57" id="r57" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:493px; left:600px;"/>
<input type="text" name="rm57" id="rm57" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:493px; left:785px;"/>
<input type="text" name="r58" id="r58" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:518px; left:600px;"/>
<input type="text" name="rm58" id="rm58" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:518px; left:785px;"/>
<input type="text" name="r59" id="r59" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:543px; left:600px;"/>
<input type="text" name="rm59" id="rm59" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:543px; left:785px;"/>
<input type="text" name="r60" id="r60" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:568px; left:600px;"/>
<input type="text" name="rm60" id="rm60" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:568px; left:785px;"/>
<input type="text" name="r61" id="r61" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:593px; left:600px;"/>
<input type="text" name="rm61" id="rm61" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:593px; left:785px;"/>
<input type="text" name="r62" id="r62" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:618px; left:600px;"/>
<input type="text" name="rm62" id="rm62" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:618px; left:785px;"/>
<input type="text" name="r63" id="r63" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:642px; left:600px;"/>
<input type="text" name="rm63" id="rm63" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:642px; left:785px;"/>
<input type="text" name="r64" id="r64" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:667px; left:600px;"/>
<input type="text" name="rm64" id="rm64" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:667px; left:785px;"/>
<input type="text" name="r65" id="r65" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:694px; left:600px;"/>
<input type="text" name="rm65" id="rm65" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:694px; left:785px;"/>
<input type="text" name="r66" id="r66" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:721px; left:600px;"/>
<input type="text" name="rm66" id="rm66" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:721px; left:785px;"/>
<input type="text" name="r67" id="r67" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:746px; left:600px;"/>
<input type="text" name="rm67" id="rm67" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:746px; left:785px;"/>
<input type="text" name="r68" id="r68" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:771px; left:600px;"/>
<input type="text" name="rm68" id="rm68" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:771px; left:785px;"/>
<input type="text" name="r69" id="r69" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:798px; left:600px;"/>
<input type="text" name="rm69" id="rm69" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:798px; left:785px;"/>
<input type="text" name="r70" id="r70" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:827px; left:600px;"/>
<input type="text" name="rm70" id="rm70" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:827px; left:785px;"/>
<input type="text" name="r71" id="r71" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:854px; left:600px;"/>
<input type="text" name="rm71" id="rm71" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:854px; left:785px;"/>
<input type="text" name="r72" id="r72" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:879px; left:600px;"/>
<input type="text" name="rm72" id="rm72" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:879px; left:785px;"/>
<!-- 73.BANK.UVERY -->
<span class="text-echo" style="top:906px; right:186px; font-size:14px;"><?php echo $r73; ?></span>
<span class="text-echo" style="top:906px; right:50px; font-size:14px;"><?php echo $rm73; ?></span>
<input type="text" name="r74" id="r74" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:929px; left:600px;"/>
<input type="text" name="rm74" id="rm74" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:929px; left:785px;"/>
<input type="text" name="r75" id="r75" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:956px; left:600px;"/>
<input type="text" name="rm75" id="rm75" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:956px; left:785px;"/>
<input type="text" name="r76" id="r76" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:983px; left:600px;"/>
<input type="text" name="rm76" id="rm76" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:983px; left:785px;"/>
<input type="text" name="r77" id="r77" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1007px; left:600px;"/>
<input type="text" name="rm77" id="rm77" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1007px; left:785px;"/>
<!-- 78.CAS.ROZLISENIE -->
<input type="text" name="r78" id="r78" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1032px; left:600px;"/>
<input type="text" name="rm78" id="rm78" onkeyup="CiarkaNaBodku(this);" style="width:100px; top:1032px; left:785px;"/>
<!-- 79.PASIVA SPOLU -->
<span class="text-echo" style="top:1059px; right:186px; font-size:14px;"><?php echo $r79; ?></span>
<span class="text-echo" style="top:1059px; right:50px; font-size:14px;"><?php echo $rm79; ?></span>
<!-- dopyt, preveriù v˝poËty -->
<?php                     } //koniec 3.strana ?>




<!-- dopyt, pridaù navbar -->
<!-- dopyt, aktualizovaù export do dbf -->
<!-- dopyt, generovanie daù do zoznamu tlaËÌv, odtiaæto vyhodiù -->
</FORM>
</div> <!-- #content -->
<?php
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC
if( $copern == 10 )
{
if ( File_Exists("../tmp/vykazfin.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykazfin.$kli_uzid.pdf"); }
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

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
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
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
$text=$fir_fico;
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
$text="»˝0123456789abcdefghijklmnoprstuv";
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
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->Cell(195,17," ","$rmc1",1,"L");
$pdf->Cell(136,3," ","$rmc1",0,"R");$pdf->Cell(10,4,"$skutku","$rmc",1,"C");

//VYBRANE AKTIVA 
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
$r39=$hlavicka->r39; if ( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40; if ( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41; if ( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42; if ( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43; if ( $hlavicka->r43 == 0 ) $r43="";

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
$rk39=$hlavicka->rk39; if ( $hlavicka->rk39 == 0 ) $rk39="";
$rk40=$hlavicka->rk40; if ( $hlavicka->rk40 == 0 ) $rk40="";
$rk41=$hlavicka->rk41; if ( $hlavicka->rk41 == 0 ) $rk41="";
$rk42=$hlavicka->rk42; if ( $hlavicka->rk42 == 0 ) $rk42="";
$rk43=$hlavicka->rk43; if ( $hlavicka->rk43 == 0 ) $rk43="";

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
$rn39=$hlavicka->rn39; if ( $hlavicka->rn39 == 0 ) $rn39="";
$rn40=$hlavicka->rn40; if ( $hlavicka->rn40 == 0 ) $rn40="";
$rn41=$hlavicka->rn41; if ( $hlavicka->rn41 == 0 ) $rn41="";
$rn42=$hlavicka->rn42; if ( $hlavicka->rn42 == 0 ) $rn42="";
$rn43=$hlavicka->rn43; if ( $hlavicka->rn43 == 0 ) $rn43="";

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
$rm39=$hlavicka->rm39; if ( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40; if ( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41; if ( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42; if ( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43; if ( $hlavicka->rm43 == 0 ) $rm43="";
$pdf->Cell(195,15," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r01","$rmc",0,"R");$pdf->Cell(17,6,"$rk01","$rmc",0,"R");
$pdf->Cell(17,6,"$rn01","$rmc",0,"R");$pdf->Cell(30,6,"$rm01","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r02","$rmc",0,"R");$pdf->Cell(17,6,"$rk02","$rmc",0,"R");
$pdf->Cell(17,6,"$rn02","$rmc",0,"R");$pdf->Cell(30,6,"$rm02","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r03","$rmc",0,"R");$pdf->Cell(17,5,"$rk03","$rmc",0,"R");
$pdf->Cell(17,5,"$rn03","$rmc",0,"R");$pdf->Cell(30,5,"$rm03","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r04","$rmc",0,"R");$pdf->Cell(17,6,"$rk04","$rmc",0,"R");
$pdf->Cell(17,6,"$rn04","$rmc",0,"R");$pdf->Cell(30,6,"$rm04","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r05","$rmc",0,"R");$pdf->Cell(17,6,"$rk05","$rmc",0,"R");
$pdf->Cell(17,6,"$rn05","$rmc",0,"R");$pdf->Cell(30,6,"$rm05","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r06","$rmc",0,"R");$pdf->Cell(17,5,"$rk06","$rmc",0,"R");
$pdf->Cell(17,5,"$rn06","$rmc",0,"R");$pdf->Cell(30,5,"$rm06","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r07","$rmc",0,"R");$pdf->Cell(17,6,"$rk07","$rmc",0,"R");
$pdf->Cell(17,6,"$rn07","$rmc",0,"R");$pdf->Cell(30,6,"$rm07","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r08","$rmc",0,"R");$pdf->Cell(17,6,"$rk08","$rmc",0,"R");
$pdf->Cell(17,6,"$rn08","$rmc",0,"R");$pdf->Cell(30,6,"$rm08","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r09","$rmc",0,"R");$pdf->Cell(17,6,"$rk09","$rmc",0,"R");
$pdf->Cell(17,6,"$rn09","$rmc",0,"R");$pdf->Cell(30,6,"$rm09","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r10","$rmc",0,"R");$pdf->Cell(17,6,"$rk10","$rmc",0,"R");
$pdf->Cell(17,6,"$rn10","$rmc",0,"R");$pdf->Cell(30,6,"$rm10","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r11","$rmc",0,"R");$pdf->Cell(17,6,"$rk11","$rmc",0,"R");
$pdf->Cell(17,6,"$rn11","$rmc",0,"R");$pdf->Cell(30,6,"$rm11","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r12","$rmc",0,"R");$pdf->Cell(17,5,"$rk12","$rmc",0,"R");
$pdf->Cell(17,5,"$rn12","$rmc",0,"R");$pdf->Cell(30,5,"$rm12","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r13","$rmc",0,"R");$pdf->Cell(17,6,"$rk13","$rmc",0,"R");
$pdf->Cell(17,6,"$rn13","$rmc",0,"R");$pdf->Cell(30,6,"$rm13","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r14","$rmc",0,"R");$pdf->Cell(17,5,"$rk14","$rmc",0,"R");
$pdf->Cell(17,5,"$rn14","$rmc",0,"R");$pdf->Cell(30,5,"$rm14","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r15","$rmc",0,"R");$pdf->Cell(17,6,"$rk15","$rmc",0,"R");
$pdf->Cell(17,6,"$rn15","$rmc",0,"R");$pdf->Cell(30,6,"$rm15","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r16","$rmc",0,"R");$pdf->Cell(17,6,"$rk16","$rmc",0,"R");
$pdf->Cell(17,6,"$rn16","$rmc",0,"R");$pdf->Cell(30,6,"$rm16","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r17","$rmc",0,"R");$pdf->Cell(17,5,"$rk17","$rmc",0,"R");
$pdf->Cell(17,5,"$rn17","$rmc",0,"R");$pdf->Cell(30,5,"$rm17","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r18","$rmc",0,"R");$pdf->Cell(17,6,"$rk18","$rmc",0,"R");
$pdf->Cell(17,6,"$rn18","$rmc",0,"R");$pdf->Cell(30,6,"$rm18","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r19","$rmc",0,"R");$pdf->Cell(17,6,"$rk19","$rmc",0,"R");
$pdf->Cell(17,6,"$rn19","$rmc",0,"R");$pdf->Cell(30,6,"$rm19","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r20","$rmc",0,"R");$pdf->Cell(17,5,"$rk20","$rmc",0,"R");
$pdf->Cell(17,5,"$rn20","$rmc",0,"R");$pdf->Cell(30,5,"$rm20","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r21","$rmc",0,"R");$pdf->Cell(17,6,"$rk21","$rmc",0,"R");
$pdf->Cell(17,6,"$rn21","$rmc",0,"R");$pdf->Cell(30,6,"$rm21","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r22","$rmc",0,"R");$pdf->Cell(17,6,"$rk22","$rmc",0,"R");
$pdf->Cell(17,6,"$rn22","$rmc",0,"R");$pdf->Cell(30,6,"$rm22","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r23","$rmc",0,"R");$pdf->Cell(17,5,"$rk23","$rmc",0,"R");
$pdf->Cell(17,5,"$rn23","$rmc",0,"R");$pdf->Cell(30,5,"$rm23","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r24","$rmc",0,"R");$pdf->Cell(17,6,"$rk24","$rmc",0,"R");
$pdf->Cell(17,6,"$rn24","$rmc",0,"R");$pdf->Cell(30,6,"$rm24","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r25","$rmc",0,"R");$pdf->Cell(17,6,"$rk25","$rmc",0,"R");
$pdf->Cell(17,6,"$rn25","$rmc",0,"R");$pdf->Cell(30,6,"$rm25","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r26","$rmc",0,"R");$pdf->Cell(17,5,"$rk26","$rmc",0,"R");
$pdf->Cell(17,5,"$rn26","$rmc",0,"R");$pdf->Cell(30,5,"$rm26","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r27","$rmc",0,"R");$pdf->Cell(17,6,"$rk27","$rmc",0,"R");
$pdf->Cell(17,6,"$rn27","$rmc",0,"R");$pdf->Cell(30,6,"$rm27","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r28","$rmc",0,"R");$pdf->Cell(17,6,"$rk28","$rmc",0,"R");
$pdf->Cell(17,6,"$rn28","$rmc",0,"R");$pdf->Cell(30,6,"$rm28","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r29","$rmc",0,"R");$pdf->Cell(17,6,"$rk29","$rmc",0,"R");
$pdf->Cell(17,6,"$rn29","$rmc",0,"R");$pdf->Cell(30,6,"$rm29","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r30","$rmc",0,"R");$pdf->Cell(17,5,"$rk30","$rmc",0,"R");
$pdf->Cell(17,5,"$rn30","$rmc",0,"R");$pdf->Cell(30,5,"$rm30","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r31","$rmc",0,"R");$pdf->Cell(17,6,"$rk31","$rmc",0,"R");
$pdf->Cell(17,6,"$rn31","$rmc",0,"R");$pdf->Cell(30,6,"$rm31","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r32","$rmc",0,"R");$pdf->Cell(17,6,"$rk32","$rmc",0,"R");
$pdf->Cell(17,6,"$rn32","$rmc",0,"R");$pdf->Cell(30,6,"$rm32","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r33","$rmc",0,"R");$pdf->Cell(17,5,"$rk33","$rmc",0,"R");
$pdf->Cell(17,5,"$rn33","$rmc",0,"R");$pdf->Cell(30,5,"$rm33","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,7,"$r34","$rmc",0,"R");$pdf->Cell(17,7,"$rk34","$rmc",0,"R");
$pdf->Cell(17,7,"$rn34","$rmc",0,"R");$pdf->Cell(30,7,"$rm34","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r35","$rmc",0,"R");$pdf->Cell(17,6,"$rk35","$rmc",0,"R");
$pdf->Cell(17,6,"$rn35","$rmc",0,"R");$pdf->Cell(30,6,"$rm35","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r36","$rmc",0,"R");$pdf->Cell(17,5,"$rk36","$rmc",0,"R");
$pdf->Cell(17,5,"$rn36","$rmc",0,"R");$pdf->Cell(30,5,"$rm36","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r37","$rmc",0,"R");$pdf->Cell(17,6,"$rk37","$rmc",0,"R");
$pdf->Cell(17,6,"$rn37","$rmc",0,"R");$pdf->Cell(30,6,"$rm37","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r38","$rmc",0,"R");$pdf->Cell(17,5,"$rk38","$rmc",0,"R");
$pdf->Cell(17,5,"$rn38","$rmc",0,"R");$pdf->Cell(30,5,"$rm38","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r39","$rmc",0,"R");$pdf->Cell(17,6,"$rk39","$rmc",0,"R");
$pdf->Cell(17,6,"$rn39","$rmc",0,"R");$pdf->Cell(30,6,"$rm39","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r40","$rmc",0,"R");$pdf->Cell(17,6,"$rk40","$rmc",0,"R");
$pdf->Cell(17,6,"$rn40","$rmc",0,"R");$pdf->Cell(30,6,"$rm40","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r41","$rmc",0,"R");$pdf->Cell(17,6,"$rk41","$rmc",0,"R");
$pdf->Cell(17,6,"$rn41","$rmc",0,"R");$pdf->Cell(30,6,"$rm41","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,5,"$r42","$rmc",0,"R");$pdf->Cell(17,5,"$rk42","$rmc",0,"R");
$pdf->Cell(17,5,"$rn42","$rmc",0,"R");$pdf->Cell(30,5,"$rm42","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");
$pdf->Cell(17,6,"$r43","$rmc",0,"R");$pdf->Cell(17,6,"$rk43","$rmc",0,"R");
$pdf->Cell(17,6,"$rn43","$rmc",0,"R");$pdf->Cell(30,6,"$rm43","$rmc",1,"R");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str3.jpg') )
{
$pdf->Image($jpg_cesta.'_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//zostatok k
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(137,4," ","$rmc1",0,"R");$pdf->Cell(10,4,"$skutku","$rmc",1,"C");

//VYBRANE PASIVA
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
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r44","$rmc",0,"R");$pdf->Cell(30,6,"$rm44","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r45","$rmc",0,"R");$pdf->Cell(30,5,"$rm45","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,7,"$r46","$rmc",0,"R");$pdf->Cell(30,7,"$rm46","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r47","$rmc",0,"R");$pdf->Cell(30,6,"$rm47","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r48","$rmc",0,"R");$pdf->Cell(30,6,"$rm48","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r49","$rmc",0,"R");$pdf->Cell(30,5,"$rm49","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r50","$rmc",0,"R");$pdf->Cell(30,6,"$rm50","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r51","$rmc",0,"R");$pdf->Cell(30,6,"$rm51","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r52","$rmc",0,"R");$pdf->Cell(30,5,"$rm52","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r53","$rmc",0,"R");$pdf->Cell(30,6,"$rm53","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r54","$rmc",0,"R");$pdf->Cell(30,6,"$rm54","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r55","$rmc",0,"R");$pdf->Cell(30,5,"$rm55","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r56","$rmc",0,"R");$pdf->Cell(30,6,"$rm56","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r57","$rmc",0,"R");$pdf->Cell(30,6,"$rm57","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r58","$rmc",0,"R");$pdf->Cell(30,5,"$rm58","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r59","$rmc",0,"R");$pdf->Cell(30,6,"$rm59","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r60","$rmc",0,"R");$pdf->Cell(30,6,"$rm60","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r61","$rmc",0,"R");$pdf->Cell(30,5,"$rm61","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r62","$rmc",0,"R");$pdf->Cell(30,6,"$rm62","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r63","$rmc",0,"R");$pdf->Cell(30,6,"$rm63","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r64","$rmc",0,"R");$pdf->Cell(30,6,"$rm64","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r65","$rmc",0,"R");$pdf->Cell(30,6,"$rm65","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r66","$rmc",0,"R");$pdf->Cell(30,6,"$rm66","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r67","$rmc",0,"R");$pdf->Cell(30,6,"$rm67","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r68","$rmc",0,"R");$pdf->Cell(30,5,"$rm68","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r69","$rmc",0,"R");$pdf->Cell(30,6,"$rm69","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,7,"$r70","$rmc",0,"R");$pdf->Cell(30,7,"$rm70","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r71","$rmc",0,"R");$pdf->Cell(30,6,"$rm71","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r72","$rmc",0,"R");$pdf->Cell(30,6,"$rm72","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,5,"$r73","$rmc",0,"R");$pdf->Cell(30,5,"$rm73","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r74","$rmc",0,"R");$pdf->Cell(30,6,"$rm74","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r75","$rmc",0,"R");$pdf->Cell(30,6,"$rm75","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r76","$rmc",0,"R");$pdf->Cell(30,6,"$rm76","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r77","$rmc",0,"R");$pdf->Cell(30,6,"$rm77","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r78","$rmc",0,"R");$pdf->Cell(30,6,"$rm78","$rmc",1,"R");
$pdf->Cell(109,4," ","$rmc1",0,"C");$pdf->Cell(51,6,"$r79","$rmc",0,"R");$pdf->Cell(30,6,"$rm79","$rmc",1,"R");
                                          }
}
$i = $i + 1;
  }
$pdf->Output("../tmp/vykazfin.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 
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
</BODY>
</HTML>