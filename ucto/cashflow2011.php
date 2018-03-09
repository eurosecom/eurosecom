<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$xml = 1*$_REQUEST['xml'];

$ktoracast = 1*$_REQUEST['ktoracast'];
//echo $ktoracast;
//$ktoracast = 6;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/cash_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/cash_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

//350=sirka obdlznika 0 znamena do konca , 15=vyska obdlznika , $riadok-text , "1"=border ano 0 nie
//parameter druhy zlava 1=kurzor prejde na zaciatok riadku,0 kurzor pokracuje na riadku,2 kurzor ide nad riadok
//L=zarovnanie left alebo C=center R=right
//$pdf->Cell(350,15,"$riadok","1",1,"L");
//$rest = substr("abcdef", 0, 4); // vrátí "abcd"



$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


if( $ktoracast == 1 OR $ktoracast == 0 )
     {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prccashs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prccashs
(
   prx          INT,
   dox          DECIMAL(10,0),
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   ico          DECIMAL(10,0),
   fak          DECIMAL(10,0),
   dph          DECIMAL(10,2),
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r22          DECIMAL(10,2),
   r23          DECIMAL(10,2),
   r24          DECIMAL(10,2),
   r25          DECIMAL(10,2),
   r26          DECIMAL(10,2),
   r27          DECIMAL(10,2),
   r28          DECIMAL(10,2),
   r29          DECIMAL(10,2),
   r30          DECIMAL(10,2),
   r31          DECIMAL(10,2),
   r32          DECIMAL(10,2),
   r33          DECIMAL(10,2),
   r34          DECIMAL(10,2),
   r35          DECIMAL(10,2),
   r36          DECIMAL(10,2),
   r37          DECIMAL(10,2),
   r38          DECIMAL(10,2),
   r39          DECIMAL(10,2),
   r40          DECIMAL(10,2),
   r41          DECIMAL(10,2),
   r42          DECIMAL(10,2),
   r43          DECIMAL(10,2),
   r44          DECIMAL(10,2),
   r45          DECIMAL(10,2),
   r46          DECIMAL(10,2),
   r47          DECIMAL(10,2),
   r48          DECIMAL(10,2),
   r49          DECIMAL(10,2),
   r50          DECIMAL(10,2),
   r51          DECIMAL(10,2),
   r52          DECIMAL(10,2),
   r53          DECIMAL(10,2),
   r54          DECIMAL(10,2),
   r55          DECIMAL(10,2),
   r56          DECIMAL(10,2),
   r57          DECIMAL(10,2),
   r58          DECIMAL(10,2),
   r59          DECIMAL(10,2),
   r60          DECIMAL(10,2),
   r61          DECIMAL(10,2),
   r62          DECIMAL(10,2),
   r63          DECIMAL(10,2),
   r64          DECIMAL(10,2),
   r65          DECIMAL(10,2),
   r66          DECIMAL(10,2),
   r67          DECIMAL(10,2),
   r68          DECIMAL(10,2),
   r69          DECIMAL(10,2),
   r70          DECIMAL(10,2),
   r71          DECIMAL(10,2),
   r72          DECIMAL(10,2),
   r73          DECIMAL(10,2),
   r74          DECIMAL(10,2),
   r75          DECIMAL(10,2),
   r76          DECIMAL(10,2),
   r77          DECIMAL(10,2),
   r78          DECIMAL(10,2),
   r79          DECIMAL(10,2),
   r80          DECIMAL(10,2),
   r81          DECIMAL(10,2),
   r82          DECIMAL(10,2),
   r83          DECIMAL(10,2),
   r84          DECIMAL(10,2),
   r85          DECIMAL(10,2),
   r86          DECIMAL(10,2),
   r87          DECIMAL(10,2),
   r88          DECIMAL(10,2),
   r89          DECIMAL(10,2),
   r90          DECIMAL(10,2),
   icx          INT
);
prccashs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prccashs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prccash1000ziss'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prccashs
(
   prx          INT,
   dox          DECIMAL(10,0),
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   ico          DECIMAL(10,0),
   fak          DECIMAL(10,0),
   dph          DECIMAL(10,2),
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,0),
   mdt          DECIMAL(10,0),
   dal          DECIMAL(10,0),
   r01          DECIMAL(10,0),
   r02          DECIMAL(10,0),
   r03          DECIMAL(10,0),
   r04          DECIMAL(10,0),
   r05          DECIMAL(10,0),
   r06          DECIMAL(10,0),
   r07          DECIMAL(10,0),
   r08          DECIMAL(10,0),
   r09          DECIMAL(10,0),
   r10          DECIMAL(10,0),
   r11          DECIMAL(10,0),
   r12          DECIMAL(10,0),
   r13          DECIMAL(10,0),
   r14          DECIMAL(10,0),
   r15          DECIMAL(10,0),
   r16          DECIMAL(10,0),
   r17          DECIMAL(10,0),
   r18          DECIMAL(10,0),
   r19          DECIMAL(10,0),
   r20          DECIMAL(10,0),
   r21          DECIMAL(10,0),
   r22          DECIMAL(10,0),
   r23          DECIMAL(10,0),
   r24          DECIMAL(10,0),
   r25          DECIMAL(10,0),
   r26          DECIMAL(10,0),
   r27          DECIMAL(10,0),
   r28          DECIMAL(10,0),
   r29          DECIMAL(10,0),
   r30          DECIMAL(10,0),
   r31          DECIMAL(10,0),
   r32          DECIMAL(10,0),
   r33          DECIMAL(10,0),
   r34          DECIMAL(10,0),
   r35          DECIMAL(10,0),
   r36          DECIMAL(10,0),
   r37          DECIMAL(10,0),
   r38          DECIMAL(10,0),
   r39          DECIMAL(10,0),
   r40          DECIMAL(10,0),
   r41          DECIMAL(10,0),
   r42          DECIMAL(10,0),
   r43          DECIMAL(10,0),
   r44          DECIMAL(10,0),
   r45          DECIMAL(10,0),
   r46          DECIMAL(10,0),
   r47          DECIMAL(10,0),
   r48          DECIMAL(10,0),
   r49          DECIMAL(10,0),
   r50          DECIMAL(10,0),
   r51          DECIMAL(10,0),
   r52          DECIMAL(10,0),
   r53          DECIMAL(10,0),
   r54          DECIMAL(10,0),
   r55          DECIMAL(10,0),
   r56          DECIMAL(10,0),
   r57          DECIMAL(10,0),
   r58          DECIMAL(10,0),
   r59          DECIMAL(10,0),
   r60          DECIMAL(10,0),
   r61          DECIMAL(10,0),
   r62          DECIMAL(10,0),
   r63          DECIMAL(10,0),
   r64          DECIMAL(10,0),
   r65          DECIMAL(10,0),
   r66          DECIMAL(10,0),
   r67          DECIMAL(10,0),
   r68          DECIMAL(10,0),
   r69          DECIMAL(10,0),
   r70          DECIMAL(10,0),
   r71          DECIMAL(10,0),
   r72          DECIMAL(10,0),
   r73          DECIMAL(10,0),
   r74          DECIMAL(10,0),
   r75          DECIMAL(10,0),
   r76          DECIMAL(10,0),
   r77          DECIMAL(10,0),
   r78          DECIMAL(10,0),
   r79          DECIMAL(10,0),
   r80          DECIMAL(10,0),
   r81          DECIMAL(10,0),
   r82          DECIMAL(10,0),
   r83          DECIMAL(10,0),
   r84          DECIMAL(10,0),
   r85          DECIMAL(10,0),
   r86          DECIMAL(10,0),
   r87          DECIMAL(10,0),
   r88          DECIMAL(10,0),
   r89          DECIMAL(10,0),
   r90          DECIMAL(10,0),
   icx          INT
);
prccashs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prccash1000ziss'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prccashs$kli_uzid"." SELECT".
" 1,0,0,uce,0,0,0,0,0,0,(pmd-pda),0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE LEFT(uce,1) = 2 ";
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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prccashs$kli_uzid"." SELECT".
" 0,F$kli_vxcf"."_$doklad.dok,0,ucm,ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ume <= $kli_vume AND ( LEFT(ucm,1) = 2 OR LEFT(ucd,1) = 2 ) ".
" GROUP BY ucm,ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prccashs$kli_uzid"." SELECT".
" 0,dok,0,ucm,ucd,ico,fak,0,0,0,SUM(hod),0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $kli_vume AND ( LEFT(ucm,1) = 2 OR LEFT(ucd,1) = 2 ) GROUP BY ucm,ucd  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");



}
$psys=$psys+1;
  }

//len ucm:0:3 210,211,213,221,261 alebo ucd ;
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid ".
" WHERE LEFT(ucm,2) != 21 AND LEFT(ucm,2) != 22 AND LEFT(ucm,2) != 26 ".
" AND LEFT(ucd,2) != 21 AND LEFT(ucd,2) != 22 AND LEFT(ucd,2) != 26 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid ".
" WHERE ( LEFT(ucm,2) = 21 OR LEFT(ucm,2) = 22 OR LEFT(ucm,2) = 26 ) ".
" AND ( LEFT(ucd,2) = 21 OR LEFT(ucd,2) = 22 OR LEFT(ucd,2) = 26 )";
$oznac = mysql_query("$sqtoz");

if( $alchem == 1 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid WHERE LEFT(ucm,5) = 21198 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid WHERE LEFT(ucd,5) = 21198 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid WHERE LEFT(uce,5) = 21198 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid WHERE LEFT(ucm,3) = 211 AND LEFT(ucd,3) = 211 ";
$oznac = mysql_query("$sqtoz");
}

if( $ktoracast > 0 ) { echo "Èas 1. ukonèená, zatvorte okno a pokraèujte ïalšou èasou"; exit; }
     }

if( $ktoracast == 2 OR $ktoracast == 0 )
     {
//odberatelske faktury
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET prx=311 WHERE LEFT(ucd,3) = 311 OR LEFT(ucd,3) = 315 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET dph=$fir_dph2*hod/100 WHERE prx=311 ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET hod=hod-dph WHERE prx=311 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$kli_vxcf"."_uctodb".
" SET uce=F$kli_vxcf"."_uctodb.ucd".
" WHERE F$kli_vxcf"."_prccashs$kli_uzid.ico=F$kli_vxcf"."_uctodb.ico AND F$kli_vxcf"."_prccashs$kli_uzid.fak=F$kli_vxcf"."_uctodb.fak ".
" AND LEFT(F$kli_vxcf"."_uctodb.ucd,3) != 343 AND prx = 311 ";
$oznac = mysql_query("$sqtoz");

if( $ktoracast > 0 ) { echo "Èas 2. ukonèená, zatvorte okno a pokraèujte ïalšou èasou"; exit; }
     }

if( $ktoracast == 3 OR $ktoracast == 0 )
     {

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$fir_allx11"."_uctodb".
" SET uce=F$fir_allx11"."_uctodb.ucd".
" WHERE F$kli_vxcf"."_prccashs$kli_uzid.ico=F$fir_allx11"."_uctodb.ico AND F$kli_vxcf"."_prccashs$kli_uzid.fak=F$fir_allx11"."_uctodb.fak ".
" AND LEFT(F$fir_allx11"."_uctodb.ucd,3) != 343 AND prx = 311 ";
$oznac = mysql_query("$sqtoz");

if( $ktoracast > 0 ) { echo "Èas 3. ukonèená, zatvorte okno a pokraèujte ïalšou èasou"; exit; }
     }

if( $ktoracast == 4 OR $ktoracast == 0 )
     {
//dodavatelske faktury
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET prx=321 WHERE LEFT(ucm,3) = 321 OR LEFT(ucm,3) = 379 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET dph=$fir_dph2*hod/100 WHERE prx=321 ";
//$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET hod=hod-dph WHERE prx=321 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$kli_vxcf"."_uctdod".
" SET uce=F$kli_vxcf"."_uctdod.ucm".
" WHERE F$kli_vxcf"."_prccashs$kli_uzid.ico=F$kli_vxcf"."_uctdod.ico AND F$kli_vxcf"."_prccashs$kli_uzid.fak=F$kli_vxcf"."_uctdod.fak ".
" AND LEFT(F$kli_vxcf"."_uctdod.ucm,3) != 343 AND prx = 321 ";
$oznac = mysql_query("$sqtoz");

if( $ktoracast > 0 ) { echo "Èas 4. ukonèená, zatvorte okno a pokraèujte ïalšou èasou"; exit; }
     }

if( $ktoracast == 5 OR $ktoracast == 0 )
     {

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$fir_allx11"."_uctdod".
" SET uce=F$fir_allx11"."_uctdod.ucm".
" WHERE F$kli_vxcf"."_prccashs$kli_uzid.ico=F$fir_allx11"."_uctdod.ico AND F$kli_vxcf"."_prccashs$kli_uzid.fak=F$fir_allx11"."_uctdod.fak ".
" AND LEFT(F$fir_allx11"."_uctdod.ucm,3) != 343 AND prx = 321 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET ucd=uce WHERE prx=311 AND uce > 0";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET ucm=uce WHERE prx=321 AND uce > 0 AND LEFT(uce,3) != 213 ";
$oznac = mysql_query("$sqtoz");

//len ucm:0:3 210,211,213,221,261 alebo ucd aj po opravach dodav a odber;
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid ".
" WHERE LEFT(ucm,2) != 21 AND LEFT(ucm,2) != 22 AND LEFT(ucm,2) != 26 ".
" AND LEFT(ucd,2) != 21 AND LEFT(ucd,2) != 22 AND LEFT(ucd,2) != 26 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET uce=ucd ".
" WHERE LEFT(ucd,2) != 21 AND LEFT(ucd,2) != 22 AND LEFT(ucd,2) != 26 AND prx != 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET uce=ucm, hod=-hod  ".
" WHERE LEFT(ucm,2) != 21 AND LEFT(ucm,2) != 22 AND LEFT(ucm,2) != 26 AND prx != 1 ";
$oznac = mysql_query("$sqtoz");

if( $ktoracast > 0 ) { echo "Èas 5. ukonèená, zatvorte okno a pokraèujte ïalšou èasou"; exit; }
     }

if( $ktoracast == 6 OR $ktoracast == 0 )
     {
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccashs$kli_uzid WHERE prx = 99 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prccash1000ziss$kli_uzid WHERE prx = 99 ";
$oznac = mysql_query("$sqtoz");


//vytvor crsash_flow
$poslhh = "SELECT * FROM F$kli_vxcf"."_crcash_flow2011 WHERE crs > 0 ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
  {
$ttvv = "TRUNCATE F$kli_vxcf"."_crcash_flow2011 ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '604',  1 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '132',  2 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '504',  2 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '601',  3 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '602',  4 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '501',  5 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '502',  5 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '503',  5 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '511',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '512',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '513',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '514',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '515',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '516',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '517',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '518',  6 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '521',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '522',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '524',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '525',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '526',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '527',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '528',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '331',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '336',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '366',  7 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '343',  8 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '531',  8 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '532',  8 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '538',  8 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '661',  9 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '644', 15 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '645', 15 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '646', 15 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '647', 15 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '648', 15 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '568', 16 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '381', 16 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '662', 18 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '562', 19 )"; $ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '591', 23 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '341', 23 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '342', 23 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '041', 27 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '042', 28 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '043', 29 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '641', 30 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '665', 32 )"; $ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '461', 62 )"; $ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '311',  1 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '315',  1 )"; $ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '321',  2 )"; $ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 ( uce, crs ) VALUES ( '379',  2 )"; $ttqq = mysql_query("$ttvv");
  }
//koniec vytvor crsash_flow



//nastav crv podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$kli_vxcf"."_crcash_flow2011".
" SET rdk=F$kli_vxcf"."_crcash_flow2011.crs".
" WHERE LEFT(F$kli_vxcf"."_prccashs$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crcash_flow2011.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid,F$kli_vxcf"."_crcash_flow2011".
" SET rdk=F$kli_vxcf"."_crcash_flow2011.crs".
" WHERE F$kli_vxcf"."_prccashs$kli_uzid.uce = F$kli_vxcf"."_crcash_flow2011.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET rdk=77 WHERE prx=1 ";
$oznac = mysql_query("$sqtoz");



//rozdel do riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r01=hod WHERE rdk =  1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r02=hod WHERE rdk =  2 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r03=hod WHERE rdk =  3 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r04=hod WHERE rdk =  4 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r05=hod WHERE rdk =  5 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r06=hod WHERE rdk =  6 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r07=hod WHERE rdk =  7 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r08=hod WHERE rdk =  8 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r09=hod WHERE rdk =  9 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r10=hod WHERE rdk = 10 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r11=hod WHERE rdk = 11 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r12=hod WHERE rdk = 12 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r13=hod WHERE rdk = 13 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r14=hod WHERE rdk = 14 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r15=hod WHERE rdk = 15 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r16=hod WHERE rdk = 16 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r17=hod WHERE rdk = 17 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r18=hod WHERE rdk = 18 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r19=hod WHERE rdk = 19 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r20=hod WHERE rdk = 20 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r21=hod WHERE rdk = 21 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r22=hod WHERE rdk = 22 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r23=hod WHERE rdk = 23 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r24=hod WHERE rdk = 24 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r25=hod WHERE rdk = 25 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r26=hod WHERE rdk = 26 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r27=hod WHERE rdk = 27 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r28=hod WHERE rdk = 28 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r29=hod WHERE rdk = 29 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r30=hod WHERE rdk = 30 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r31=hod WHERE rdk = 31 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r32=hod WHERE rdk = 32 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r33=hod WHERE rdk = 33 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r34=hod WHERE rdk = 34 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r35=hod WHERE rdk = 35 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r36=hod WHERE rdk = 36 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r37=hod WHERE rdk = 37 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r38=hod WHERE rdk = 38 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r39=hod WHERE rdk = 39 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r40=hod WHERE rdk = 40 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r41=hod WHERE rdk = 41 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r42=hod WHERE rdk = 42 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r43=hod WHERE rdk = 43 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r44=hod WHERE rdk = 44 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r45=hod WHERE rdk = 45 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r46=hod WHERE rdk = 46 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r47=hod WHERE rdk = 47 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r48=hod WHERE rdk = 48 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r49=hod WHERE rdk = 49 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r50=hod WHERE rdk = 50 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r51=hod WHERE rdk = 51 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r52=hod WHERE rdk = 52 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r53=hod WHERE rdk = 53 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r54=hod WHERE rdk = 54 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r55=hod WHERE rdk = 55 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r56=hod WHERE rdk = 56 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r57=hod WHERE rdk = 57 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r58=hod WHERE rdk = 58 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r59=hod WHERE rdk = 59 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r60=hod WHERE rdk = 60 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r61=hod WHERE rdk = 61 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r62=hod WHERE rdk = 62 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r63=hod WHERE rdk = 63 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r64=hod WHERE rdk = 64 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r65=hod WHERE rdk = 65 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r66=hod WHERE rdk = 66 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r67=hod WHERE rdk = 67 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r68=hod WHERE rdk = 68 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r69=hod WHERE rdk = 69 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r70=hod WHERE rdk = 70 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r71=hod WHERE rdk = 71 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r72=hod WHERE rdk = 72 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r73=hod WHERE rdk = 73 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r74=hod WHERE rdk = 74 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r75=hod WHERE rdk = 75 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r76=hod WHERE rdk = 76 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r77=hod WHERE rdk = 77 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r78=hod WHERE rdk = 78 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r79=hod WHERE rdk = 79 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prccashs$kli_uzid SET r80=hod WHERE rdk = 80 "; $oznac = mysql_query("$sqtoz");

//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prccashs$kli_uzid "." SELECT".
" 99,dox,uce,ucm,ucd,0,0,0,rdk,prv,hod,mdt,dal,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),".
"SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(r39),SUM(r40),".
"SUM(r41),SUM(r42),SUM(r43),SUM(r44),SUM(r45),SUM(r46),SUM(r47),SUM(r48),SUM(r49),SUM(r50),".
"SUM(r51),SUM(r52),SUM(r53),SUM(r54),SUM(r55),SUM(r56),SUM(r57),SUM(r58),SUM(r59),SUM(r60),".
"SUM(r61),SUM(r62),SUM(r63),SUM(r64),SUM(r65),SUM(r66),SUM(r67),SUM(r68),SUM(r69),SUM(r70),".
"SUM(r71),SUM(r72),SUM(r73),SUM(r74),SUM(r75),SUM(r76),SUM(r77),SUM(r78),SUM(r79),SUM(r80),".
" 0,0,0,0,0,0,0,0,0,0,".
"1".
" FROM F$kli_vxcf"."_prccashs$kli_uzid".
" WHERE rdk > 0".
" GROUP BY icx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//exit;

//ak na tisic
if( $tis > 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prccash1000ziss$kli_uzid "." SELECT".
" 99,dox,uce,ucm,ucd,0,0,0,rdk,prv,hod,mdt,dal,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),".
"SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(r39),SUM(r40),".
"SUM(r41),SUM(r42),SUM(r43),SUM(r44),SUM(r45),SUM(r46),SUM(r47),SUM(r48),SUM(r49),SUM(r50),".
"SUM(r51),SUM(r52),SUM(r53),SUM(r54),SUM(r55),SUM(r56),SUM(r57),SUM(r58),SUM(r59),SUM(r60),".
"SUM(r61),SUM(r62),SUM(r63),SUM(r64),SUM(r65),SUM(r66),SUM(r67),SUM(r68),SUM(r69),SUM(r70),".
"SUM(r71),SUM(r72),SUM(r73),SUM(r74),SUM(r75),SUM(r76),SUM(r77),SUM(r78),SUM(r79),SUM(r80),".
" 0,0,0,0,0,0,0,0,0,0,".
"1".
" FROM F$kli_vxcf"."_prccashs$kli_uzid".
" WHERE prx = 99".
" GROUP BY icx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
}
//koniec ak 1000ky

//vypocitaj riadky
$vsldat="prccashs";
if( $tis > 0 ) { $vsldat="prccash1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r17=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16, ".
"r22=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16+r18+r19+r20+r21, ".
"r26=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16+r18+r19+r20+r21+r23+r24+r25, ".
"r47=r28+r29+r30+r31+r32+r33+r34+r35+r36+r37+r38+r39+r40+r41+r42+r43+r44+r45+r46, ".
"r49=r50+r51+r52+r53+r54+r55+r56+r57, ".
"r58=r59+r60+r61+r62+r63+r64+r65+r66+r67, ".
"r75=r49+r58+r68+r69+r70+r71+r72+r73+r74, ".
"r76=r26+r47+r75, ".
"r78=r77+r76, r80=r78+r79 ".
" WHERE prx = 99  ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");



//exit;

//poc.stav
$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpoccash2011_stl'.$sqlt;
$ulozene = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpoccash2011_stl1000';
$ulozene = mysql_query("$sql");
$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpoccash2011_stt';
$ulozene = mysql_query("$sql");

$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,0),
   rm01         DECIMAL(10,0),
   rm02         DECIMAL(10,0),
   rm03         DECIMAL(10,0),
   rm04         DECIMAL(10,0),
   rm05         DECIMAL(10,0),
   rm06         DECIMAL(10,0),
   rm07         DECIMAL(10,0),
   rm08         DECIMAL(10,0),
   rm09         DECIMAL(10,0),
   rm10         DECIMAL(10,0),
   rm11         DECIMAL(10,0),
   rm12         DECIMAL(10,0),
   rm13         DECIMAL(10,0),
   rm14         DECIMAL(10,0),
   rm15         DECIMAL(10,0),
   rm16         DECIMAL(10,0),
   rm17         DECIMAL(10,0),
   rm18         DECIMAL(10,0),
   rm19         DECIMAL(10,0),
   rm20         DECIMAL(10,0),
   rm21         DECIMAL(10,0),
   rm22         DECIMAL(10,0),
   rm23         DECIMAL(10,0),
   rm24         DECIMAL(10,0),
   rm25         DECIMAL(10,0),
   rm26         DECIMAL(10,0),
   rm27         DECIMAL(10,0),
   rm28         DECIMAL(10,0),
   rm29         DECIMAL(10,0),
   rm30         DECIMAL(10,0),
   rm31         DECIMAL(10,0),
   rm32         DECIMAL(10,0),
   rm33         DECIMAL(10,0),
   rm34         DECIMAL(10,0),
   rm35         DECIMAL(10,0),
   rm36         DECIMAL(10,0),
   rm37         DECIMAL(10,0),
   rm38         DECIMAL(10,0),
   rm39         DECIMAL(10,0),
   rm40         DECIMAL(10,0),
   rm41         DECIMAL(10,0),
   rm42         DECIMAL(10,0),
   rm43         DECIMAL(10,0),
   rm44         DECIMAL(10,0),
   rm45         DECIMAL(10,0),
   rm46         DECIMAL(10,0),
   rm47         DECIMAL(10,0),
   rm48         DECIMAL(10,0),
   rm49         DECIMAL(10,0),
   rm50         DECIMAL(10,0),
   rm51         DECIMAL(10,0),
   rm52         DECIMAL(10,0),
   rm53         DECIMAL(10,0),
   rm54         DECIMAL(10,0),
   rm55         DECIMAL(10,0),
   rm56         DECIMAL(10,0),
   rm57         DECIMAL(10,0),
   rm58         DECIMAL(10,0),
   rm59         DECIMAL(10,0),
   rm60         DECIMAL(10,0),
   rm61         DECIMAL(10,0),
   rm62         DECIMAL(10,0),
   rm63         DECIMAL(10,0),
   rm64         DECIMAL(10,0),
   rm65         DECIMAL(10,0),
   rm66         DECIMAL(10,0),
   rm67         DECIMAL(10,0),
   rm68         DECIMAL(10,0),
   rm69         DECIMAL(10,0),
   rm70         DECIMAL(10,0),
   rm71         DECIMAL(10,0),
   rm72         DECIMAL(10,0),
   rm73         DECIMAL(10,0),
   rm74         DECIMAL(10,0),
   rm75         DECIMAL(10,0),
   rm76         DECIMAL(10,0),
   rm77         DECIMAL(10,0),
   rm78         DECIMAL(10,0),
   rm79         DECIMAL(10,0),
   rm80         DECIMAL(10,0),
   rm81         DECIMAL(10,0),
   rm82         DECIMAL(10,0),
   rm83         DECIMAL(10,0),
   rm84         DECIMAL(10,0),
   rm85         DECIMAL(10,0),
   rm86         DECIMAL(10,0),
   rm87         DECIMAL(10,0),
   rm88         DECIMAL(10,0),
   rm89         DECIMAL(10,0),
   rm90         DECIMAL(10,0),
   rm91         DECIMAL(10,0),
   rm92         DECIMAL(10,0),
   rm93         DECIMAL(10,0),
   rm94         DECIMAL(10,0),
   rm95         DECIMAL(10,0),
   rm96         DECIMAL(10,0),
   rm97         DECIMAL(10,0),
   rm98         DECIMAL(10,0),
   rm99         DECIMAL(10,0),
   rm100         DECIMAL(10,0),
   rm101         DECIMAL(10,0),
   rm102         DECIMAL(10,0),
   rm103         DECIMAL(10,0),
   rm104         DECIMAL(10,0),
   rm105         DECIMAL(10,0),
   rm106         DECIMAL(10,0),
   rm107         DECIMAL(10,0),
   rm108         DECIMAL(10,0),
   rm109         DECIMAL(10,0),
   rm110         DECIMAL(10,0),
   rm111         DECIMAL(10,0),
   rm112         DECIMAL(10,0),
   rm113         DECIMAL(10,0),
   rm114         DECIMAL(10,0),
   rm115         DECIMAL(10,0),
   rm116         DECIMAL(10,0),
   rm117         DECIMAL(10,0),
   rm118         DECIMAL(10,0),
   rm119         DECIMAL(10,0),
   rm120         DECIMAL(10,0),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpoccash2011_stt'.$sqlt;
$ulozene = mysql_query("$sql");

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prccashs".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpoccash2011_stl".
" ON F$kli_vxcf"."_prccashs$kli_uzid.icx=F$kli_vxcf"."_uctpoccash2011_stl.fic".
" WHERE prx = 99  "."";

 
if( $tis > 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpoccash2011_stt SELECT ".
"dok,hod,".
"rm01,rm02,rm03,rm04,rm05,rm06,rm07,rm08,rm09,rm10,".
"rm11,rm12,rm13,rm14,rm15,rm16,rm17,rm18,rm19,rm20,".
"rm21,rm22,rm23,rm24,rm25,rm26,rm27,rm28,rm29,rm30,".
"rm31,rm32,rm33,rm34,rm35,rm36,rm37,rm38,rm39,rm40,".
"rm41,rm42,rm43,rm44,rm45,rm46,rm47,rm48,rm49,rm50,".
"rm51,rm52,rm53,rm54,rm55,rm56,rm57,rm58,rm59,rm60,".
"rm61,rm62,rm63,rm64,rm65,rm66,rm67,rm68,rm69,rm70,".
"rm71,rm72,rm73,rm74,rm75,rm76,rm77,rm78,rm79,rm80,".
"rm81,rm82,rm83,rm84,rm85,rm86,rm87,rm88,rm89,rm90,".
"rm91,rm92,rm93,rm94,rm95,rm96,rm97,rm98,rm99,rm100,".
"rm101,rm102,rm103,rm104,rm105,rm106,rm107,rm108,rm109,rm110,".
"rm111,rm112,rm113,rm114,rm115,rm116,rm117,rm118,rm119,rm120,".
"fic".
" FROM F$kli_vxcf"."_uctpoccash2011_stl".
"";

$dsql = mysql_query("$dsqlt");

if( $alchem == 1 AND $kli_vxcf == 533 )
 {
$sqtoz = "UPDATE F$kli_vxcf"."_prccash1000ziss$kli_uzid ".
" SET r78=1941768, r79=- 393, r80=1941375, r01=27475704, r17=3055682, r22=2930202, r26=2864480, r76=1708791   "; 
$oznac = mysql_query("$sqtoz");
 }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prccash1000ziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpoccash2011_stt".
" ON F$kli_vxcf"."_prccash1000ziss$kli_uzid.icx=F$kli_vxcf"."_uctpoccash2011_stt.fic".
" WHERE prx = 99 ".""; 

}

$citfir = include("cashflow2011_pdf.php");


//vypis negenerovane pohyby
$sqltt = "SELECT * FROM F$kli_vxcf"."_prccashs".$kli_uzid.
" WHERE prx != 99 AND ( rdk = 0 OR rdk = 17 OR rdk = 22 OR rdk = 26 OR rdk = 27 OR rdk = 47 OR rdk = 48 OR rdk = 49 OR rdk = 58 ) AND LEFT(uce,3) != 211 GROUP BY uce"."";

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

if( $i == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
              }
$pdf->Cell(60,6,"Negenerované alebo nesprávne","$rmc",0,"L");$pdf->Cell(25,6,"$hlavicka->uce / rdk$hlavicka->rdk","$rmc",0,"L");$pdf->Cell(25,6,"dok$hlavicka->dok","$rmc",1,"L");

}
$i = $i + 1;

  }

          }
//koniec if( $pol > 0 )




$pdf->Output("$outfilex");

$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];

if( $ktoracast == 0 )
  {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prccashs'.$kli_uzid;
if( $analyzy == 0 AND $tis == 5 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prccash'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prccash1000ziss'.$kli_uzid;
if( $analyzy == 0 AND $tis == 5 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
  }

     }
//koniec casti 6
?> 


<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>CASH FLOW PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >


?>




<?php
//koniec el.komunikacie

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
