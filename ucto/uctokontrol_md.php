<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   er1          INT,
   psys         INT,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT,
   hod          DECIMAL(10,2),
   fak          DECIMAL(10,0),
   ico          DECIMAL(10,0),
   fic          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//pociatok a koniec mesiaca

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

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=1;
$mesk_dph=12;
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

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;

//koniec pociatok a koniec mesiaca


if( $copern == 40 )
{

////////////////////////////////////////////////////////////////kontrola nulovy ucet
$psys=11;
while ($psys <= 16 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 AND $kli_vduj != 9 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 AND $kli_vduj != 9 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys <= 14 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 1,$psys,ume,dat,F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.ico,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( ucm = 0 OR ucd = 0 ) ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
     }
if( $psys == 15 OR $psys == 16 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 1,$psys,ume,dat,F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.ico,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( ucm = 0 OR ucd = 0 ) ";

$dsql = mysql_query("$dsqlt");
     }


$psys=$psys+1;
  }

//exit;
//nastav eror ak je ucm=0 alebo ucd=0

if( $kli_vduj != 9 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE ucm = 0 OR ucd = 0";
$oznac = mysql_query("$sqtoz"); }

//echo $kli_vduj; exit;
if( $kli_vduj == 9 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE ( ucm = 0 OR ucd = 0 ) ";
$oznac = mysql_query("$sqtoz"); 

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE psys >= 14 ";
$oznac = mysql_query("$sqtoz"); 
                     }




//presun ak ucet=0 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


/////////////////////////////////////////////////////////kontrola viacnasobny vyskyt dokladu

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$psys=11;
while ($psys <= 16 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 1,$psys,ume,dat,F$kli_vxcf"."_$doklad.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE dok >= 0 ";

$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }

//exit;

//nastav eror ak je viac krat ico,fak
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" SUM(er1),psys,ume,dat,dok,hod,fak,ico,0 ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE dok >= 0 ".
" GROUP BY dok";

$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=3 WHERE er1 > 1";
$oznac = mysql_query("$sqtoz"); 


//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 AND er1 > 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//kontrola viacnasobny vyskyt ico,faktura

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ADD fkx VARCHAR(35) AFTER fak";
$vysledek = mysql_query("$sql");

$cslfak="0";
if( $kli_vrok >= 2014 ) { $cslfak="sz3"; }

$psys=15;
while ($psys <= 16 ) 
  {
//zober prijmove pokl
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys <= 16 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 1,$psys,ume,dat,F$kli_vxcf"."_$doklad.dok,F$kli_vxcf"."_$doklad.hod,F$kli_vxcf"."_$doklad.fak,$cslfak,F$kli_vxcf"."_$doklad.ico,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE dok >= 0 ";

$dsql = mysql_query("$dsqlt");

}

$psys=$psys+1;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET fkx=REPLACE(fkx, ' ', '') ";
$oznac = mysql_query("$sqtoz");

//nastav eror ak je viac krat ico,fak
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" SUM(er1),psys,ume,dat,dok,hod,fak,fkx,ico,0 ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE dok >= 0 ".
" GROUP BY ico,fak,fkx";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=2 WHERE er1 > 1";
$oznac = mysql_query("$sqtoz"); 

$sql = "ALTER TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid DROP fkx ";
$vysledek = mysql_query("$sql");

//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 AND er1 > 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//////////////////////////////////////////////////////kontrola datum mimo rozsah alebo nulove ume

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$pole = explode(".", $kli_vume);
$kli_ames=$pole[0];
$kli_arok=$pole[1];
$pocdat=$kli_arok."-01-01";
$kondat=$kli_arok."-12-31";

$psys=11;
while ($psys <= 17 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober uctskl
if( $psys == 17 ) { $uctovanie="uctskl"; $doklad="uctskl"; }

if( $psys < 15 OR $psys > 16 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 2,$psys,ume,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$doklad.dat < '$pocdat' OR F$kli_vxcf"."_$doklad.dat > '$kondat' OR ume = 0 OR ume IS NULL";
  }
if( $psys == 15 OR $psys == 16 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 2,$psys,ume,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$doklad.dat < '$pocdat' OR F$kli_vxcf"."_$doklad.dat > '$kondat' OR ume = 0 OR ume IS NULL OR ".
"  F$kli_vxcf"."_$doklad.daz < '$pocdat' OR F$kli_vxcf"."_$doklad.daz > '$kondat' ";
  }

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }

//exit;


$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=4 WHERE er1 > 1 AND ume != 0 ";
$oznac = mysql_query("$sqtoz"); 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=5 WHERE er1 > 1 AND ume = 0 ";
$oznac = mysql_query("$sqtoz"); 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=5 WHERE er1 > 1 AND ume IS NULL";
$oznac = mysql_query("$sqtoz");

//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 AND er1 > 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//koniec kontrola datum

//////////////////////////////////////////////////////kontrola druh dokladu strana madat,dal

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$pole = explode(".", $kli_vume);
$kli_ames=$pole[0];
$kli_arok=$pole[1];
$pocdat=$kli_arok."-01-01";
$kondat=$kli_arok."-12-31";

$podvstup="";
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE crd > 19 AND crd < 29 AND crz3 != 1 AND crd != 27 ORDER BY rdp";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) { $podvstup=$podvstup." rdp = ".$hlavicka->rdp; }
if( $i >  0 ) { $podvstup=$podvstup." OR rdp = ".$hlavicka->rdp; }

}
$i=$i+1;
  }
$podvystup="";
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE (( crd < 19 AND crd > 0 ) OR crd = 27 ) AND crz3 != 1 ORDER BY rdp";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) { $podvystup=$podvystup." rdp = ".$hlavicka->rdp; }
if( $i >  0 ) { $podvystup=$podvystup." OR rdp = ".$hlavicka->rdp; }

}
$i=$i+1;
  }

$psys=11;
while ($psys <= 17 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys == 11 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 6,$psys,0,'',F$kli_vxcf"."_$uctovanie.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE poh = 1 AND ( $podvstup ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
                  }

if( $psys == 12 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 6,$psys,0,'',F$kli_vxcf"."_$uctovanie.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE poh = 2 AND ( $podvystup ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
                  }

if( $psys == 15 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 6,$psys,0,'',F$kli_vxcf"."_$uctovanie.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE dok >= 0 AND ( $podvstup ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
                  }

if( $psys == 16 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 6,$psys,0,'',F$kli_vxcf"."_$uctovanie.dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE dok >= 0 AND ( $podvystup ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
                  }



$psys=$psys+1;
  }

//exit;

//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE psys > 0 AND er1 > 1";
$dsql = mysql_query("$dsqlt");
//koniec kontrola druh dokladu strana madat,dal

////////////////////////////////////////////////////////////kontrola rozuctovanie odberatelskych
if( $kli_vduj != 9 )     {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphsoo
(
   er1          INT,
   psys         INT,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT,
   hou          DECIMAL(10,2),
   fak          DECIMAL(10,0),
   ico          INT,
   hoc          DECIMAL(10,2),
   fic          INT
);
prcprizdphsoo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$psys=15;
while ($psys <= 16 ) 
  {

//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys <= 16 )
{

if( $psys == 15 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 1,$psys,0,'0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.ico,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE ( LEFT(ucm,3) = 311 OR LEFT(ucm,3) = 315 ) ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 1,$psys,0,'0000-00-00',F$kli_vxcf"."_$doklad.dok,0,F$kli_vxcf"."_$doklad.fak,F$kli_vxcf"."_$doklad.ico,F$kli_vxcf"."_$doklad.hodu,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 315 ) ";
$dsql = mysql_query("$dsqlt");
     }

if( $psys == 16 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 1,$psys,0,'0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.fak,F$kli_vxcf"."_$uctovanie.ico,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE ( LEFT(ucd,3) = 321 OR LEFT(ucd,3) = 325 ) ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 1,$psys,0,'0000-00-00',F$kli_vxcf"."_$doklad.dok,0,F$kli_vxcf"."_$doklad.fak,F$kli_vxcf"."_$doklad.ico,F$kli_vxcf"."_$doklad.hodu,0 ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 325 ) ";
$dsql = mysql_query("$dsqlt");
     }

}

$psys=$psys+1;
  }

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 99,psys,ume,dat,dok,SUM(hou),fak,ico,SUM(hoc),0 ".
" FROM F$kli_vxcf"."_prcprizdphsoo$kli_uzid".
" WHERE dok >= 0 ".
" GROUP BY dok";
$dsql = mysql_query("$dsqlt");

//vymaz ak sa rovna hou != hoc
$dsqlt = "DELETE FROM F$kli_vxcf"."_prcprizdphsoo$kli_uzid  WHERE hou = hoc ";
$dsql = mysql_query("$dsqlt");


//presun ak hou != hoc do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT 99,psys,ume,dat,dok,hoc,fak,ico,fic ".
" FROM F$kli_vxcf"."_prcprizdphsoo$kli_uzid".
" WHERE er1 = 99  ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
//koniec kontrola rozuctovanie odberatelskych

                         }
////////////////////////////////////////////////////////////kontrola  v JU vydajovy pohyb v prijme a opacne
if( $kli_vduj == 9 )     {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphsoo
(
   er1          INT(10) DEFAULT 0,
   psys         INT(10) DEFAULT 0,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT(10) DEFAULT 0,
   ucm          VARCHAR(10) NOT NULL,
   ucd          VARCHAR(10) NOT NULL,
   dum          DECIMAL(10,0) DEFAULT 0,
   dud          DECIMAL(10,0) DEFAULT 0,
   dupm         DECIMAL(10,0) DEFAULT 0,
   dupd         DECIMAL(10,0) DEFAULT 0,
   fic          INT(10) DEFAULT 0
);
prcprizdphsoo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$psys=11;
while ($psys <= 13 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober uctskl
if( $psys == 17 ) { $uctovanie="uctskl"; $doklad="uctskl"; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 0,$psys,0,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,ucm,ucd,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_$doklad,F$kli_vxcf"."_$uctovanie".
" WHERE F$kli_vxcf"."_$doklad.dok=F$kli_vxcf"."_$uctovanie.dok ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }


//exit;

//dopln druh pohybu 1=prijem,2=vydavok
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET dum=prm1 WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucm=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET dud=prm1 WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucd=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=98 WHERE ( LEFT(ucm,3) = 211 OR LEFT(ucm,3) = 221 ) AND ( LEFT(ucd,3) != 343 OR LEFT(ucd,3) != 261 ) AND dud = 2  ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=97 WHERE ( LEFT(ucd,3) = 211 OR LEFT(ucd,3) = 221 ) AND ( LEFT(ucm,3) != 343 OR LEFT(ucm,3) != 261 ) AND dum = 1  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET dupm=F$kli_vxcf"."_uctosnova.uce WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucm=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET dupd=F$kli_vxcf"."_uctosnova.uce WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucd=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=96 WHERE dupm = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=96 WHERE dupd = 0 ";
$oznac = mysql_query("$sqtoz");

//presun do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT er1,psys,ume,dat,dok,0,0,0,0 ".
" FROM F$kli_vxcf"."_prcprizdphsoo$kli_uzid".
" WHERE er1 = 98 OR er1 = 97 OR er1 = 96 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//if( $kli_vduj == 9 )     {
                           }
//koniec kontrola v JU vydajovy pohyb v prijme a opacne


////////////////////////////////////////////////////////////kontrola v PU ucet nie je v osnove
if( $kli_vduj != 9 )     {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphsoo
(
   er1          INT(10) DEFAULT 0,
   psys         INT(10) DEFAULT 0,
   dok          INT(10) DEFAULT 0,
   ucm          VARCHAR(10) NOT NULL,
   ucd          VARCHAR(10) NOT NULL,
   jeucm        INT(10) DEFAULT 0,
   jeucd        INT(10) DEFAULT 0,
   fic          INT(10) DEFAULT 0
);
prcprizdphsoo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$psys=11;
while ($psys <= 19 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 15 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober uctskl
if( $psys == 17 ) { $uctovanie="uctskl"; $doklad="uctskl"; }
//zober uctmzd
if( $psys == 18 ) { $uctovanie="uctmzd"; $doklad="uctmzd"; }
//zober uctmaj
if( $psys == 19 ) { $uctovanie="uctmaj"; $doklad="uctmaj"; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsoo$kli_uzid"." SELECT".
" 0,$psys,dok,ucm,ucd,0,0,0 ".
" FROM F$kli_vxcf"."_$uctovanie ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }



$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET jeucm=1 WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucm=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid,F$kli_vxcf"."_uctosnova ".
" SET jeucd=1 WHERE F$kli_vxcf"."_prcprizdphsoo$kli_uzid.ucd=F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=95 WHERE jeucm = 0 AND ucm > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphsoo$kli_uzid  ".
" SET er1=95 WHERE jeucd = 0 AND ucd > 0 ";
$oznac = mysql_query("$sqtoz");

//presun do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT er1,psys,0,'0000-00-00',dok,ucd,ucm,0,0 ".
" FROM F$kli_vxcf"."_prcprizdphsoo$kli_uzid".
" WHERE er1 = 95 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsoo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//if( $kli_vduj != 9 )     {
                           }
//koniec kontrola v PU ucet nie je v osnove

////////////////////////////////////////////////////////////////////tlac vsetky chyby

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE er1 > 0 ORDER BY er1,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Úètovné kontroly</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" >

<?php

if (File_Exists ("../tmp/prizdph$kli_vume.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prizdph$kli_vume.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


if( $copern == 40 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {

//hlavicka
if ( $j == 0 )
{



if( $copern == 40 AND $drupoh == 1) //html;
   {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="5"><?php echo "Úètovné kontroly - Chybové hlásenia "; ?>
<a href="#" onClick="window.open('../ucto/ucto_kontrol.php?copern=40&drupoh=2&page=1', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="Chybové hlásenia Úèto tlaè vo formáte PDF" ></a>
<a href="#" onClick="window.open('../ucto/ucto_kontrol.php?copern=40&drupoh=1&page=1', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Chybové hlásenia Úèto prepoèet po úpravách dokladov" ></a>
</td>
<td class="bmenu" colspan="5" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="10%">Úè.mes.</td>
<td class="bmenu" width="15%">Dátum</td>
<td class="bmenu" width="15%">Doklad</td>
<td class="bmenu" width="10%" align="right">Hodnota</td>
<td class="bmenu" width="10%" align="right">Faktúra</td>
<td class="bmenu" width="40%">IÈO</td>
</tr>
<?php
   }

if( $copern == 40 AND $drupoh == 2) //pdf chybove;
   {

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(15);
$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(130,5,"Úètovné kontroly - Chybové hlásenia ","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(15,4,"Úè.mes.","1",0,"R");$pdf->Cell(30,4,"Dátum","1",0,"L");$pdf->Cell(25,4,"Doklad","1",0,"R");
$pdf->Cell(20,4,"Hodnota","1",0,"R");
$pdf->Cell(20,4,"Faktúra","1",0,"R");$pdf->Cell(0,4,"IÈO","1",1,"L");
   }

}
//koniec hlavicka j=0

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$faknul=$hlavicka->fak;
if( $hlavicka->fak == 0 ) $faknul="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->daz, 3);
  $rok=$rok-2000;
  $dazsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);


if( $copern == 40 AND $drupoh == 1 )
   {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
if( $hlavicka->er1 > 0 ) { $hvstup="hvstup_bred"; }
?>

<?php if( $hlavicka->er1 == 1 ) { ?>
<tr><td class="hvstup" colspan="4" >V zaúètovaní dokladu je nulový úèet/pohyb</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 2 ) { ?>
<tr><td class="hvstup" colspan="4" >Viacnásobný výskyt kombinácie IÈO,Faktúra</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 3 ) { ?>
<tr><td class="hvstup" colspan="4" >Viacnásobný výskyt èísla dokladu</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 4 ) { ?>
<tr><td class="hvstup" colspan="4" >Dátum mimo rozsah úètovného roka</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 5 ) { ?>
<tr><td class="hvstup" colspan="4" >Úètovné obdobie 00.0000 ???</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 6 ) { ?>
<tr><td class="hvstup" colspan="4" >Druh dokladu DPH ???</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 95 ) { $hod=1*$hlavicka->hod; ?>
<tr><td class="hvstup" colspan="4" >PU úèet <?php echo $hlavicka->fak."/".$hod; ?> nie je v úètovej osnove</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 96 ) { ?>
<tr><td class="hvstup" colspan="4" >JU pohyb nie je v èíselníku pohybov</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 97 ) { ?>
<tr><td class="hvstup" colspan="4" >JU príjmový pohyb vo výdavku financií</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 98 ) { ?>
<tr><td class="hvstup" colspan="4" >JU výdavkový pohyb v príjme financií</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 99 ) { ?>
<tr><td class="hvstup" colspan="4" >Rozdiel hodnota fakúry - zaúètovanie dokladu</td></tr>
<?php                           } ?>

<tr>
<?php
if(  $hlavicka->psys != 0 )
{
?>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ume; ?> <?php echo $hlavicka->rdk; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>" >
<?php if( $hlavicka->psys == 11 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybraného pokladnièného príjmového dokladu" ></a>
<a href="#" onClick="window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybraného pokladnièného príjmového dokladu" ></a>
<?php 
  } ?>
<?php if( $hlavicka->psys == 12 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybraného pokladnièného výdavkového dokladu" ></a>
<a href="#" onClick="window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybraného pokladnièného výdavkového dokladu" ></a>
<?php 
  } ?>
<?php if( $hlavicka->psys == 13 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybraného bankového výpisu " ></a>
<a href="#" onClick="window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybraného bankového výpisu " ></a>
<?php 
  } ?>
<?php if( $hlavicka->psys == 14 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybraného všeobecného úètovného dokladu" ></a>
<a href="#" onClick="window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybraného všeobecného úètovného dokladu" ></a>
<?php 
  } ?>


<?php if( $hlavicka->psys == 15 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_u.php?sysx=UCT&rozuct=ANO&copern=7&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybranej odberate¾skej faktúry" ></a>
<?php 
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_pdf.php?sysx=UCT&mini=1&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybranej odberate¾skej faktúry" ></a>
<?php 
  } ?>
<?php if( $hlavicka->psys == 16 )
  { ?>
<?php if( $kli_vduj >= 0 )
      { ?>
<a href="#" onClick="window.open('../faktury/vstf_u.php?sysx=UCT&rozuct=ANO&copern=7&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Úprava vybranej dodávate¾skej faktúry" ></a>
<?php 
      } ?>
<a href="#" onClick="window.open('../faktury/vstf_pdf.php?sysx=UCT&mini=1&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="Tlaè vybranej dodávate¾skej faktúry" ></a>
<?php 
  } ?>

<?php echo $hlavicka->dok; ?></td>

<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->hod; ?></td>

<td class="<?php echo $hvstup; ?>" align="right"><?php echo $faknul; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ico; ?> <?php echo $hlavicka->nai; ?></td>
<?php
}
?>

</tr>
<?php
   }
//koniec copern=40 html


}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

//nebudem strankovat if( $j == 27 ) $j=0;

  }
//koniec hlavicky


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
