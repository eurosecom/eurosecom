<HTML>
<?php
//VYHODNOTENIE UHRAD ZA DEALEROV ALCHEM "CHEMIA" rok 2018
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$h_uce = $_REQUEST['h_uce'];
$h_obd = $_REQUEST['h_obd'];
$h_icox = 1*$_REQUEST['h_ico'];
$h_ico=0;
$cislo_fak = 1*$_REQUEST['cislo_fak'];
//ci tlacit len sumy za ico alebo aj polozky
$sumico = 1*$_REQUEST['sumico'];

$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

$pol = 1*$_REQUEST['pol'];
$dea = 1*$_REQUEST['dea'];
$h_deal = 1*$_REQUEST['h_deal'];
$uhr = 1*$_REQUEST['uhr'];
$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];

$vsetko=1;

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if (File_Exists ("../tmp/saldo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/saldo.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


////////////////////////////////////////////////////////datum pociatku a konca salda

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$h_obdcel=$h_obd.".".$kli_vrok;
$pole = explode(".", $h_obdcel);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

//exit;

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

////////////////////////////////////////////////////////koniec datum pociatku a konca salda


////////////////////////////////////////////////////////////nastavenia co brat vsetky/nesparovane , obdobie

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   pox1        INT,
   pox2        INT,
   pox         INT,
   drupoh      INT,
   uce         VARCHAR(10),
   puc         DECIMAL(10,0),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         DECIMAL(10,0),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         DECIMAL(10,0),
   hdp         DECIMAL(10,2),
   hdu         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   uhr         DECIMAL(10,2),
   zos         DECIMAL(10,2),
   dau         DATE,
   pox3        INT
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $copern == 12 ) { $h_obd=0; $vsetko=1; $drupoh=2; }

if( $copern == 14 ) { $h_obd=0; $vsetko=1; $drupoh=4; }

if ( $h_obd == 0 ) { $datpod = ""; }
if ( $h_obd == 100 ) { $datpod = "AND ( drupoh = 7 OR drupoh = 8 )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) OR ( dau <= '".$datk_dph."' AND dau != '0000-00-00' ) )"; }
if ( $uhr == 1 ) { 
$h_damp=SqlDatum($h_datp);
$h_damk=SqlDatum($h_datk);
$h_obd=1;
$vsetko=1;
$datpod ="AND ( ( dat != '0000-00-00' AND dat <= '".$h_damk."' ) OR ( dau >= '".$h_damp."' AND dau <= '".$h_damk."' ) )"; 
                 }

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,31100,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE uce = $h_uce OR uce = 31500 ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce = $h_uce ".$datpod." ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

                   }


//ak je vybrany dealer vymaz ostatnych
if( $h_deal > 0 ) {
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE ssy != $h_deal ";
$dsql = mysql_query("$dsqlt");
                  }


//zober vsetky
if ( $drupoh == 1 AND $vsetko == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,0,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE uce != 0 ".$datpod.
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

}
//koniec zober vsetky

//ikona CHEM  1. polrok 2018 agrochemikálie, osivá
//platia èísla faktúr 3285..., 3287..., 3284..., 3280.... a 428...


$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=99 ";
$dsql = mysql_query("$dsqlt");

//rok 2017
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=TO_DAYS(das)-TO_DAYS(dat) WHERE fak >= 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 32700001 AND fak <= 32709999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3279001 AND fak <= 3279999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3274001 AND fak <= 3274999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3277001 AND fak <= 3277999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3275001 AND fak <= 3275999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 427001 AND fak <= 427999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 827001 AND fak <= 827999 AND puc >= 180 ";
//$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=0 WHERE fak >= 0 ";
$oznac = mysql_query("$sqtoz");

//rok 2018
$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 32800001 AND fak <= 32809999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3289001 AND fak <= 3289999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3284001 AND fak <= 3284999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3287001 AND fak <= 3287999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 3285001 AND fak <= 3285999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 428001 AND fak <= 428999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 828001 AND fak <= 828999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak >= 5118000001 AND fak <= 5118999999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE pox1 != 0 ";
$dsql = mysql_query("$dsqlt");

$datvymaz="2018-07-01";
if( $h_obd ==  9 ) { $datvymaz="2018-10-01"; }
if( $h_obd == 12 ) { $datvymaz="2019-01-01"; }

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE dat >= '$datvymaz' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE das < '2018-01-01' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 31328962 ) OR ( ico = 36219975 ) OR ( ico = 17333130 ) ".
"  OR ( ico = 156582 ) OR ( ico = 30414351 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 31676901 ) OR ( ico = 31692346 ) OR ( ico = 31586724 ) ".
"  OR ( ico = 61 ) OR ( ico = 30873576 ) OR ( ico = 31349463 ) OR ( ico = 31103391 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 17328560 ) OR ( ico = 203840 ) OR ( ico = 31187757 ) ".
"  OR ( ico = 31413315 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 34100377 ) OR ( ico = 35681098 ) OR ( ico = 35681098 ) ".
"  OR ( ico = 360982 ) OR ( ico = 31363831 ) OR ( ico = 31352332 ) OR ( ico = 31752314 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 36526894 ) ".
"  OR ( ico = 32585926 ) OR ( ico = 30804981 ) OR ( ico = 31397719 ) OR ( ico = 36184187 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 31562736 ) OR ( ico = 33516243 ) OR ( ico = 31729533 ) ".
"  OR ( ico = 33559775 ) OR ( ico = 31419631 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 34099344 ) OR ( ico = 31412459 ) OR ( ico = 17548511 ) ".
"  OR ( ico = 35770961 ) OR ( ico = 677990 ) OR ( ico = 31443265 ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ( ico = 35728833 ) OR ( ico = 194794 ) OR ( ico = 31602193 ) ";
$dsql = mysql_query("$dsqlt");


//ak je zadane ico vymaz ostatne
if ( $h_icox > 0  )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ico != $h_icox ";
$dsql = mysql_query("$dsqlt");
}
////////////////////////////////////////////////////////////koniec nastavenia co brat

////////////////////////////////////////////////////////////uhradove doklady

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   udru         INT,
   uuce         VARCHAR(10),
   upuc         VARCHAR(10),
   uduh         DATE,
   udok         INT(8),
   uico         INT(10),
   ufak         DECIMAL(10,0),
   uhdu         DECIMAL(10,2),
   udas         DATE,
   upos         DECIMAL(10,0),
   ussy         DECIMAL(10,0),
   uodk         DECIMAL(2,0),
   uzdp         DECIMAL(2,0),
   uzcl         DECIMAL(2,0),
   upx1         DECIMAL(2,0),
   upx2         DECIMAL(2,0),
   uhod         DECIMAL(10,2),
   udph         DECIMAL(10,2),
   uuhr         DECIMAL(10,2),
   roz1         DECIMAL(10,2),
   roz2         DECIMAL(10,2),
   roz3         DECIMAL(10,2),
   udat         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$psys=11;
while ($psys <= 14 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }

if( $psys <= 14 )
{


$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,31100,ucm,dat,F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,F$kli_vxcf"."_$uctovanie.hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucd = $h_uce OR ucd = 31500 ) ";
$dsql = mysql_query("$dsqlt");

}

$psys=$psys+1;

  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,31100,ucm,dat,dok,ico,fak,hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_uctsklsaldo".
" WHERE ucd = $h_uce OR ucd = 31500 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_pruhrady$kli_uzid".
" SELECT 0,31100,ucm,dat,dok,ico,fak,hod,'0000-00-00',0,0 ".
" ,0,0,0,0,0,0,0,0,0,0,0,'0000-00-00' FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE ucd = $h_uce OR ucd = 31500 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "DELETE FROM F$kli_vxcf"."_pruhrady$kli_uzid WHERE uduh >= '$datvymaz' ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid,F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SET F$kli_vxcf"."_pruhrady$kli_uzid.udas=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.das, udru=99, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.ussy=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.ssy, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.uuhr=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uhr, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.udat=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.dat, ".
"     F$kli_vxcf"."_pruhrady$kli_uzid.uhod=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.hod ".
" WHERE F$kli_vxcf"."_pruhrady$kli_uzid.uuce=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce ".
" AND F$kli_vxcf"."_pruhrady$kli_uzid.uico=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.ico ".
" AND F$kli_vxcf"."_pruhrady$kli_uzid.ufak=F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.fak ".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_pruhrady$kli_uzid WHERE udru != 99 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET upos=TO_DAYS(uduh)-TO_DAYS(udas) ";
$oznac = mysql_query("$sqtoz");

//rozdel uhrady do druhov

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udph=$fir_dph2*uhod/120, roz1=udph-uuhr, roz2=uhod-uuhr, roz3=TO_DAYS(udas)-TO_DAYS(udat) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET uzdp=1 WHERE roz1 < 0.02 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET uzcl=1 WHERE roz2 < 0.02 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET uodk=1 WHERE roz3 > 31 ";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211 puc1- 21190/21198 qf:2(cele uhradene) <= 5 drh1 0 pospl1 <= 0 odkl 0 & puc1 21199,39500 ;
//drh1=1
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=1 ".
" WHERE ( LEFT(upuc,3) = 211 AND upuc < 21190 AND upuc > 21198 AND uzcl = 1 AND upos <= 0 AND uodk = 0 ) OR ( upuc = 21199 OR upuc = 39500 )";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211,221 qf:2 <= 5 drh1 0 pospl1 <= 20 odkl 0 ;
//drh1=2
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=2 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzcl = 1 AND upos <= 20 AND uodk = 0 ";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211,221 qe:2(uhradena dan) <= 5 drh1 0 pospl1 <= 20 odkl 0 ;
//drh1=3
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=3 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos <= 20 AND uodk = 0 AND uzcl = 0 ";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211,221 drh1 0 odkl 1 pospl1 <= 365 ;
//drh1=4
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=4 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND upos <= 365 AND uodk = 1 ";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211,221 qe:2 <= 5 drh1 0 pospl1 21/30 ;
//drh1=5
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=5 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 21 AND upos <= 30 ";
$oznac = mysql_query("$sqtoz");

//puc1:0:3 211,221 qe:2 <= 5 drh1 0 pospl1 31/60 ;
//drh1=6
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=6 ".
" WHERE udru = 99 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND uzdp = 1 AND upos >= 31 AND upos <= 60 ";
$oznac = mysql_query("$sqtoz");

//fak 3292001/3292999,3296000/3296999,3298000/3298999 drh1 1 ;
//drh1=7
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=7 ".
" WHERE udru = 1 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 OR LEFT(upuc,3) = 395 ) AND ".
" ( ( ufak > 3292001 AND ufak < 3292999 ) OR ( ufak > 3296001 AND ufak < 3296999 ) OR ( ufak > 3298001 AND ufak < 3298999 ) )";
$oznac = mysql_query("$sqtoz");

//fak 3292001/3292999,3296000/3296999,3298000/3298999 drh1- 0,1,2,3,7 ;
//drh1=8
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=7 ".
" WHERE udru > 3 AND udru < 7 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 OR LEFT(upuc,3) = 395 ) AND ".
" ( ( ufak > 3292001 AND ufak < 3292999 ) OR ( ufak > 3296001 AND ufak < 3296999 ) OR ( ufak > 3298001 AND ufak < 3298999 ) )";
$oznac = mysql_query("$sqtoz");

//fak >= 5118000001 AND fak <= 5118999999 
//drh1=4
$sqtoz = "UPDATE F$kli_vxcf"."_pruhrady$kli_uzid SET udru=4 ".
" WHERE udru > 0 AND ( LEFT(upuc,3) = 211 OR LEFT(upuc,3) = 221 ) AND upos <= 365 AND ufak > 5118000001 AND ufak < 5118999999 ";
$oznac = mysql_query("$sqtoz");

///////////////////////////////////////////////////////////koniec rozdelenia do druhov


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = SqlDatum($h_dsp);
if( $dnes == '0000-00-00' ) $dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");


$nulovazostava=1;


//////////////////////////////////////////////////////////////uprava ak za vsetky ico daj sucty polehotne,dolehotne
if ( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,991,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce,ssy,ico";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1,0,995,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY ssy";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,1,999,drupoh,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE pox = 1 ".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
$sumico=0;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0

//vloz uhradove doklady
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,20,uuce,upos,0,uduh,uduh,uduh,udok,uico,ufak,".
"'',udru,ussy,0,0,uhdu,0,0,uduh,1".
" FROM F$kli_vxcf"."_pruhrady$kli_uzid".
" WHERE uuce = $h_uce ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

if ( $h_deal > 0  )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE pox = 999 ";
$dsql = mysql_query("$dsqlt");
}

//exit;

///////////////////////////////////////////////////////////////////////////////pre vsetky ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico == 0 )
{

$strana=0;
//zaciatok vypisu tovaru


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_dealeri".
" ON F$kli_vxcf"."_$uctpol.ssy=F$kli_vxcf"."_dealeri.deal".
" WHERE uce = $h_uce ".
" ORDER BY pox2,ssy,pox1,nai,F$kli_vxcf"."_$uctpol.ico,pox,fak,pox3";

//echo $tovtt;
//exit;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;


//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);


if ( $j == 0 )
      {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(90,5,"Vyhodnotenie úhrad faktúr CHÉMIA za dealerov","0",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","0",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Všetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="Poèiatoèný stav";

$pdf->SetFont('arial','',8);


$pdf->Cell(20,4,"Úèet: $h_uce","0",0,"L");
$pdf->Cell(25,4,"Obdobie: $h_obdn","0",0,"L");
if( $dea > 0 ) { $pdf->Cell(20,4,"Dealer: $rtov->ssy $rtov->ndea","0",0,"L"); }
$pdf->Cell(0,4," ","0",1,"L");

$pdf->Cell(6,4,"D","B",0,"L");
$pdf->Cell(20,4,"Fak/VS","B",0,"R");
$pdf->Cell(17,4,"Splatná","B",0,"L");$pdf->Cell(17,4,"Zaplatená","B",0,"L");$pdf->Cell(18,4,"Doklad","B",0,"R");
$pdf->Cell(47,4,"Firma  ","B",0,"L");
$pdf->Cell(20,4,"Faktúra","B",0,"R");$pdf->Cell(20,4,"Uhradené","B",0,"R");$pdf->Cell(0,4,"Zostatok","B",1,"R");


      }
//koniec j=0



$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$pospl=$rtov->puc;
//if( $pospl == 0 ) $pospl="";
if( $pospl == '' ) $pospl="0";

//sumare napocet
if( $rtov->pox == 1 AND $rtov->pox3 == 0 )
           {
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhrad = $uhrad + $rtov->uhr;
$Cislo=$uhrad+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);
           }

if( $rtov->pox == 1 )
           {
if( $rtov->pox3 == 0 )
{
$pdf->Cell(6,4," ","0",0,"L");
$pdf->Cell(20,5,"$rtov->fak","0",0,"R");
$pdf->Cell(17,5,"$das_sk","0",0,"L");$pdf->Cell(17,4,"$dau_sk","0",0,"L");$pdf->Cell(18,4,"$rtov->dok","0",0,"R");
$pdf->Cell(47,5,"$rtov->nai","0",0,"L");
$pdf->Cell(20,5,"$rtov->hod","0",0,"R");$pdf->Cell(20,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");
}

if( $rtov->pox3 == 1 )
           {
$pdf->Cell(6,4,"$rtov->ksy","0",0,"L");$pdf->Cell(20,5,"$rtov->fak","0",0,"R");$pdf->Cell(17,4," ","0",0,"L");
$pdf->Cell(17,4,"$dat_sk","0",0,"L");$pdf->Cell(17,4,"$rtov->dok","0",0,"R");
$pdf->Cell(66,4,"Po splatnosti $pospl dní","0",0,"L");$pdf->Cell(20,5,"$rtov->hod","0",1,"R");
           }

if( $rtov->pox3 == 1) { 
     $druhuhr=1*$rtov->ksy;

     if( $druhuhr == 1 ) $stlp1=$stlp1+$rtov->hod;
     if( $druhuhr == 2 ) $stlp2=$stlp2+$rtov->hod;
     if( $druhuhr == 3 ) $stlp3=$stlp3+$rtov->hod;
     if( $druhuhr == 4 ) $stlp4=$stlp4+$rtov->hod;
     if( $druhuhr == 5 ) $stlp5=$stlp5+$rtov->hod;
     if( $druhuhr == 6 ) $stlp6=$stlp6+$rtov->hod;
     if( $druhuhr == 7 ) $stlp7=$stlp7+$rtov->hod;
     if( $druhuhr == 8 ) $stlp8=$stlp8+$rtov->hod;
     if( $druhuhr == 9 ) $stlp9=$stlp9+$rtov->hod;
     if( $druhuhr == 99 ) $stlp10=$stlp10+$rtov->hod;
     if( $druhuhr != '' ) $stlp11=$stlp11+$rtov->hod;

     if( $druhuhr == 1 ) $prem1=$prem1+$rtov->hdp;
     if( $druhuhr == 2 ) $prem2=$prem2+$rtov->hdp;
     if( $druhuhr == 3 ) $prem3=$prem3+$rtov->hdp;
     if( $druhuhr == 4 ) $prem4=$prem4+$rtov->hdp;
     if( $druhuhr == 5 ) $prem5=$prem5+$rtov->hdp;
     if( $druhuhr == 6 ) $prem6=$prem6+$rtov->hdp;
     if( $druhuhr == 7 ) $prem7=$prem7+$rtov->hdp;
     if( $druhuhr == 8 ) $prem8=$prem8+$rtov->hdp;
     if( $druhuhr == 9 ) $prem9=$prem9+$rtov->hdp;
     if( $druhuhr == 99 ) $prem10=$prem10+$rtov->hdp;
     if( $druhuhr != '' ) $prem11=$prem11+$rtov->hdp;
                  }

           }

if( $rtov->pox == 991 )
           {
if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"spolu za IÈO:","T",0,"L");$pdf->Cell(100,4,"$rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1," ","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"spolu za IÈO:","T",0,"L");$pdf->Cell(100,4,"$rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1," ","0",1,"L");
}
           }

if( $rtov->pox == 995 )
           {
if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU DEALER $rtov->ssy $rtov->ndea ","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}

$prem1=2*$stlp1/100;
$prem2=1*$stlp2/100;
$prem3=0.25*$stlp3/100;
$prem4=0.5*$stlp4/100;
$prem5=-1*$stlp5/100;
$prem6=-2*$stlp6/100;
$prem7=1*$stlp7/100;
$prem8=-1*$stlp8/100;
$prem9=0;

$prem11=$prem1+$prem2+$prem3+$prem4+$prem5+$prem6+$prem7+$prem8+$prem9;

$Cislo=$stlp1+"";
$Sstlp1=sprintf("%0.2f", $Cislo);
$Cislo=$prem1+"";
$Sprem1=sprintf("%0.2f", $Cislo);

$Cislo=$stlp2+"";
$Sstlp2=sprintf("%0.2f", $Cislo);
$Cislo=$prem2+"";
$Sprem2=sprintf("%0.2f", $Cislo);

$Cislo=$stlp3+"";
$Sstlp3=sprintf("%0.2f", $Cislo);
$Cislo=$prem3+"";
$Sprem3=sprintf("%0.2f", $Cislo);

$Cislo=$stlp4+"";
$Sstlp4=sprintf("%0.2f", $Cislo);
$Cislo=$prem4+"";
$Sprem4=sprintf("%0.2f", $Cislo);

$Cislo=$stlp5+"";
$Sstlp5=sprintf("%0.2f", $Cislo);
$Cislo=$prem5+"";
$Sprem5=sprintf("%0.2f", $Cislo);

$Cislo=$stlp6+"";
$Sstlp6=sprintf("%0.2f", $Cislo);
$Cislo=$prem6+"";
$Sprem6=sprintf("%0.2f", $Cislo);

$Cislo=$stlp7+"";
$Sstlp7=sprintf("%0.2f", $Cislo);
$Cislo=$prem7+"";
$Sprem7=sprintf("%0.2f", $Cislo);

$Cislo=$stlp8+"";
$Sstlp8=sprintf("%0.2f", $Cislo);
$Cislo=$prem8+"";
$Sprem8=sprintf("%0.2f", $Cislo);

$Cislo=$stlp10+"";
$Sstlp10=sprintf("%0.2f", $Cislo);
$Cislo=$prem10+"";
$Sprem10=sprintf("%0.2f", $Cislo);

$Cislo=$stlp11+"";
$Sstlp11=sprintf("%0.2f", $Cislo);
$Cislo=$prem11+"";
$Sprem11=sprintf("%0.2f", $Cislo);

$pdf->Cell(100,4," ","0",1,"L");
$pdf->Cell(60,4,"Druh","B",0,"L");$pdf->Cell(15,4,"%prem","B",0,"R");$pdf->Cell(40,4,"Uhradené","B",0,"R");$pdf->Cell(40,4,"Prémia","B",1,"R");

$pdf->Cell(60,4,"01 Predfaktúry, hotovos","T",0,"L");$pdf->Cell(15,4,"2.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp1","0",0,"R");$pdf->Cell(40,4,"$Sprem1","0",1,"R");
$pdf->Cell(60,4,"02 Zaplatená celé","T",0,"L");$pdf->Cell(15,4,"1.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp2","T",0,"R");$pdf->Cell(40,4,"$Sprem2","T",1,"R");
$pdf->Cell(60,4,"03 Zaplatená len DPH","T",0,"L");$pdf->Cell(15,4,"0.25","B",0,"R");$pdf->Cell(40,4,"$Sstlp3","T",0,"R");$pdf->Cell(40,4,"$Sprem3","T",1,"R");
$pdf->Cell(60,4,"04 Zaplatená odkladová celá","T",0,"L");$pdf->Cell(15,4,"0.50","B",0,"R");$pdf->Cell(40,4,"$Sstlp4","T",0,"R");$pdf->Cell(40,4,"$Sprem4","T",1,"R");
$pdf->Cell(60,4,"05 Zaplatená do 30dní","T",0,"L");$pdf->Cell(15,4,"-1.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp5","T",0,"R");$pdf->Cell(40,4,"$Sprem5","T",1,"R");
$pdf->Cell(60,4,"06 Zaplatená do 60dní","T",0,"L");$pdf->Cell(15,4,"-2.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp6","T",0,"R");$pdf->Cell(40,4,"$Sprem6","T",1,"R");
$pdf->Cell(60,4,"07 Priemyselné predf.,hotovos","T",0,"L");$pdf->Cell(15,4,"1.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp7","T",0,"R");$pdf->Cell(40,4,"$Sprem7","T",1,"R");
$pdf->Cell(60,4,"08 Priemyselné ostatné","T",0,"L");$pdf->Cell(15,4,"-1.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp8","T",0,"R");$pdf->Cell(40,4,"$Sprem8","T",1,"R");
$pdf->Cell(60,4,"10 Ostatné","T",0,"L");$pdf->Cell(15,4,"0.00","B",0,"R");$pdf->Cell(40,4,"$Sstlp10","T",0,"R");$pdf->Cell(40,4,"$Sprem10","T",1,"R");

$pdf->Cell(60,4,"Spolu","T",0,"L");$pdf->Cell(15,4," ","T",0,"R");$pdf->Cell(40,4,"$Sstlp11","T",0,"R");$pdf->Cell(40,4,"$Sprem11","T",1,"R");


$stlp1=0; $stlp2=0; $stlp3=0; $stlp4=0; $stlp5=0; $stlp6=0; $stlp7=0; $stlp8=0; $stlp9=0; $stlp10=0; $stlp11=0; 
$prem1=0; $prem2=0; $prem3=0; $prem4=0; $prem5=0; $prem6=0; $prem7=0; $prem8=0; $prem9=0; $prem10=0; $prem11=0; 
$j=-1;
           }


if( $rtov->pox == 999 )
           {
if( $sumico == 0 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU všetky IÈO:","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 AND $uhr == 0 )
{
$pdf->Cell(25,4,"SPOLU všetky IÈO:","T",0,"L");$pdf->Cell(100,4," ","T",0,"L");
$pdf->Cell(20,4,"$rtov->hod","T",0,"R");$pdf->Cell(20,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}

           }

$rtovpox=$rtov->pox;
}
$i = $i + 1;
$j = $j + 1; 
if( $j >= 54 ) { $j=0; }
  }

           }
//koniec ak je tovar




}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec pre vsetky ICO








if( $nulovazostava == 1 )
{
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 0 ) { $pdf->Cell(90,5,"Saldokonto dolehotné","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 1 ) { $pdf->Cell(90,5,"Saldokonto polehotné","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(105,4,"Prázdna zostava","0",1,"R");

}



$pdf->Output("../tmp/saldo.$kli_uzid.pdf")


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/saldo.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Saldo PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Saldokonto PDF formát</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_pruhrady'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
}

?>


<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
