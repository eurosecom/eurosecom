<HTML>
<?php
$sys = 'DOP';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cvoz = $_REQUEST['cvoz'];
$vodic = $_REQUEST['vodic'];
$typ = $_REQUEST['typ'];

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$repoc = 1*$_REQUEST['repoc'];
if( $repoc == 1 ) 
{
echo "PrepoËÌtavam";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprcgg'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   pox         DECIMAL(10,0) DEFAULT 0,
   dok         DECIMAL(10,0) DEFAULT 0,
   kms         DECIMAL(10,0) DEFAULT 0,
   kmn         DECIMAL(10,0) DEFAULT 0,
   kon         DECIMAL(10,0) DEFAULT 0
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kjzprcgg'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kjzprcgg$kli_uzid SELECT 0,dok,kms,kmn,0 FROM F$kli_vxcf"."_dopstzp WHERE dok > 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_kjzprcgg$kli_uzid SELECT 1,dok,SUM(kms),SUM(kmn),0 FROM F$kli_vxcf"."_kjzprcgg$kli_uzid WHERE dok > 0 GROUP BY dok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprcgg$kli_uzid  WHERE pox = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh  SET kms=0, kmn=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh,F$kli_vxcf"."_kjzprcgg$kli_uzid ".
" SET F$kli_vxcf"."_dopstzh.kms=F$kli_vxcf"."_kjzprcgg$kli_uzid.kms, ".
" F$kli_vxcf"."_dopstzh.kmn=F$kli_vxcf"."_kjzprcgg$kli_uzid.kmn ".
" WHERE F$kli_vxcf"."_dopstzh.dok=F$kli_vxcf"."_kjzprcgg$kli_uzid.dok ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprcgg'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}

$tlacitkoenter=0;
if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 ) { $tlacitkoenter=1; }
if( $copern == 6 ) { $tlacitkoenter=0; }

$nacitajphm=0;
//nacitaj spotrebu z uctovnictva
if( $copern == 6818 OR $copern == 10 )
{
$priemernaspotrebax=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopvoz WHERE cvoz = '$cvoz' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $priemernaspotrebax=1*$riaddok->spbn;
  }
$cenaphmx=0;
$ucetphmx=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_doptextdop WHERE invt = '$cvoz' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cenaphmx=1*$riaddok->pcen;
  $ucetphmx=1*$riaddok->pnak;
  }

//echo "pr.spotreba".$priemernaspotrebax;
//echo "pr.cenaphm".$cenaphmx;
//echo "ucetphm".$ucetphmx;

$sql = 'DROP TABLE F'.$kli_vxcf.'_dopprac'.$kli_uzid;
$vysledek = mysql_query("$sql");

$sqlt = <<<dopslcesty
(
   ucmx         VARCHAR(10),
   hodx         DECIMAL(10,2)
);
dopslcesty;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dopprac'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$uctovanie="uctpokuct"; $doklad="pokvyd"; 
$dsqlt = "INSERT INTO F$kli_vxcf"."_dopprac$kli_uzid"." SELECT".
" ucm,F$kli_vxcf"."_$uctovanie.hod ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm = '$ucetphmx' AND ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

$uctovanie="uctban"; $doklad="banvyp"; 
$dsqlt = "INSERT INTO F$kli_vxcf"."_dopprac$kli_uzid"." SELECT".
" ucm,F$kli_vxcf"."_$uctovanie.hod ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm = '$ucetphmx' AND ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");


$phmeu1r=0; $phmeur2=0; $phmeur3=0; $phmeur=0;
if( $copern == 6818 AND $ucetphmx >= 21300 AND $cenaphmx > 0 )
    {
$sqldok = mysql_query("SELECT SUM(hodx) AS shod FROM F$kli_vxcf"."_dopprac$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $phm1eur=1*$riaddok->shod;
  }

$sql = 'DROP TABLE F'.$kli_vxcf.'_dopprac'.$kli_uzid;
$vysledek = mysql_query("$sql");

//echo $phm1eur;

$phmeur=$phm1eur+$phm2eur+$phm3eur;
$dsqlt = "UPDATE F$kli_vxcf"."_dopslcesty SET nahoda=($phmeur/$cenaphmx) "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dopslcesty SET nahoda=CEIL(nahoda) "; $dsql = mysql_query("$dsqlt");
//echo $dsqlt;
$spotlitre=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopslcesty ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $spotlitre=1*$riaddok->nahoda;
  }

if( $spotlitre > 0 ) { $nacitajphm=1; }
    }


if( $copern == 6818 ) { $copern=10; }
}
//koniec nacitaj spotrebu z uctovnictva

//vymaz knihu jazd
if( $copern == 1661 )
{
?>
<script type="text/javascript">
if( !confirm ("  Chcete vymazaù knihu j·zd za obdobie <?php echo $kli_vume; ?> pre vozidlo <?php echo $cvoz; ?> ? ") )
     { window.close()  }
else
     { location.href='kjazd.php?copern=1662&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>'  }
</script>
<?php
}
if ( $copern == 1662 )
{
//premenna
$generovane=$kli_vume."-".$cvoz;
$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh SET unk='$generovane' WHERE ume = $kli_vume AND cvoz = '$cvoz' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh,F$kli_vxcf"."_dopstzp ".
" SET xfak='$generovane' ".
" WHERE F$kli_vxcf"."_dopstzh.dok=F$kli_vxcf"."_dopstzp.dok AND unk = '$generovane' ";
$dsql = mysql_query("$dsqlt");

//vymaz doklady
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopstzh WHERE unk = '$generovane' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopstzp WHERE xfak = '$generovane' ";
$dsql = mysql_query("$dsqlt");

$copern=10;
}
//koniec vymaz knihu jazd

//generuj knihu jazd
if( $copern == 3818 )
{
$n_dok = 1*$_REQUEST['n_dok'];
$n_dok1 = 1*$_REQUEST['n_dok1'];
$n_dok2 = 1*$_REQUEST['n_dok2'];
$h_pskm = 1*$_REQUEST['h_pskm'];
$ajso = 1*$_REQUEST['ajso'];
$ajne = 1*$_REQUEST['ajne'];
$ajsv = 1*$_REQUEST['ajsv'];
$maxk = 1*$_REQUEST['maxk'];
$lenx = 1*$_REQUEST['lenx'];

?>
<script type="text/javascript">
if( !confirm ("  Chcete generovaù knihu j·zd za obdobie <?php echo $kli_vume; ?> pre vozidlo <?php echo $cvoz; ?> ?  \r      POZOR!!! \r Pred generovanÌm bude terajöia kniha j·zd za <?php echo $kli_vume; ?> pre toto vozidlo vymazan· .") )
     { window.close()  }
else
     { location.href='kjazd.php?copern=3819&n_dok=<?php echo $n_dok; ?>&n_dok1=<?php echo $n_dok1; ?>&n_dok2=<?php echo $n_dok2; ?>&ajso=<?php echo $ajso; ?>&ajsv=<?php echo $ajsv; ?>&ajne=<?php echo $ajne; ?>&maxk=<?php echo $maxk; ?>&lenx=<?php echo $lenx; ?>&h_pskm=<?php echo $h_pskm; ?>&drupoh=<?php echo $drupoh; ?>&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>'  }
</script>
<?php
}
if ( $copern == 3819 )
{

$n_dok = 1*$_REQUEST['n_dok'];
$n_dok1 = 1*$_REQUEST['n_dok1'];
$n_dok2 = 1*$_REQUEST['n_dok2'];
$h_pskm = 1*$_REQUEST['h_pskm'];
$ajso = 1*$_REQUEST['ajso'];
$ajne = 1*$_REQUEST['ajne'];
$ajsv = 1*$_REQUEST['ajsv'];
$maxk = 1*$_REQUEST['maxk'];
$lenx = 1*$_REQUEST['lenx'];
//echo $h_pskm;

//echo $ajso;

$sqty = "DELETE FROM F$kli_vxcf"."_dopgenkjzdset WHERE id = $kli_uzid  ";
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_dopgenkjzdset ( id,ubkm,tchk,sphm,ajso,ajne,ajsv,maxk,lenx )".
" VALUES ( '$kli_uzid', '$n_dok', '$n_dok1', '$n_dok2', '$ajso', '$ajne', '$ajsv', '$maxk', '$lenx'  );"; 
$ulozene = mysql_query("$sqty");

//ak je zadany konecny stav tachometra vypocitaj ubehnute celkom v mesiaci

if( $n_dok == 0 AND $n_dok1 > 0 ) { $n_dok=$n_dok1-$h_pskm; }

//ak je zadana spotreba v litroch vypocitaj ubehnute celkom v mesiaci
if( $n_dok == 0 AND $n_dok2 > 0 ) 
{
$priemernaspotreba=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopvoz WHERE cvoz = '$cvoz' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $priemernaspotreba=$riaddok->spbn;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_dopslcesty SET nahoda=($n_dok2/$priemernaspotreba )*100 "; $dsql = mysql_query("$dsqlt");
//echo $dsqlt;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopslcesty ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $n_dok=$riaddok->nahoda;
  }
}

//ak ziadne km daj 1000
if( $n_dok <= 0 ) $n_dok=1000;

//kolko dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   cktg        int PRIMARY KEY not null auto_increment,
   pox         DECIMAL(10,0) DEFAULT 0,
   pox1        DECIMAL(10,2) DEFAULT 0,
   dok         DECIMAL(10,0) DEFAULT 0,
   dat         DATE not null,
   cpj         DECIMAL(10,0) DEFAULT 0,
   kms         DECIMAL(10,0) DEFAULT 0,
   mstt        VARCHAR(50) not null,
   kon         DECIMAL(10,0) DEFAULT 0
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kjzprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kjzprcd'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vrok1=$pole[1];
$kli_vmes1=$pole[0];
$datumprvy=$kli_vrok1."-".$kli_vmes1."-01";

$i=0;

  while ( $i <= 25 )
  {


$ix=$i;
if( $i > 0 ) { $ix=$i+1; }

$dsqlt = "UPDATE F$kli_vxcf"."_dopslcesty SET nahoda=RAND() "; $dsql = mysql_query("$dsqlt");

$nahoda=rand(1, 7);
$akasuma="kma";
if( $nahoda == 2 ) { $akasuma="kmb"; }
if( $nahoda == 3 ) { $akasuma="(kma+kmb)/2"; }
if( $nahoda == 4 ) { $akasuma="(2*kma+kmb)/3"; }
if( $nahoda == 5 ) { $akasuma="(kma+2*kmb)/3"; }
if( $nahoda == 6 ) { $akasuma="(3*kma+kmb)/4"; }
if( $nahoda == 7 ) { $akasuma="(kma+3*kmb)/4"; }

$kmapod="0";
if( $n_dok > 7000 AND $i <= 1 ) $kmapod="100";

//pohyby jeden vyber
$dsqlt = "INSERT INTO F$kli_vxcf"."_kjzprc$kli_uzid".
" SELECT 0,0,0,0,'0000-00-00',cpl,($akasuma),CONCAT(msta, ' - ', mstb),'$nahoda' FROM F$kli_vxcf"."_dopslcesty ".
" WHERE kma > $kmapod AND ( pcj >= $ix OR pcj = 0 OR pcj > 10 ) ORDER BY nahoda LIMIT 20 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

if( $maxk > 0 ) 
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE kms > $maxk ";
$dsql = mysql_query("$dsqlt");
}
if( $n_dok < 1001 ) 
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE kms > 100 ";
$dsql = mysql_query("$dsqlt");
}
//koniec jeden vyber


$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=cktg "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-$pocetdni WHERE pox1 > $pocetdni "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-$pocetdni WHERE pox1 > $pocetdni "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-$pocetdni WHERE pox1 > $pocetdni "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-$pocetdni WHERE pox1 > $pocetdni "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-$pocetdni WHERE pox1 > $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox1=pox1-1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET dat=ADDDATE('$datumprvy',pox1) "; $dsql = mysql_query("$dsqlt");

//vymaz soboty a nedele a sviatky
if( $ajso == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid,kalendar SET pox1=999 ".
" WHERE F$kli_vxcf"."_kjzprc$kli_uzid.dat=kalendar.dat AND akyden = 6 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE pox1 = 999 ";
$dsql = mysql_query("$dsqlt");
  }
if( $ajne == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid,kalendar SET pox1=999 ".
" WHERE F$kli_vxcf"."_kjzprc$kli_uzid.dat=kalendar.dat AND akyden = 7 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE pox1 = 999 ";
$dsql = mysql_query("$dsqlt");
  }
if( $ajsv == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid,kalendar SET pox1=999 ".
" WHERE F$kli_vxcf"."_kjzprc$kli_uzid.dat=kalendar.dat AND svt = 1 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE pox1 = 999 ";
$dsql = mysql_query("$dsqlt");
  }


//daj prec rovnake jazdy v jednom dni
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_kjzprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET kon=1 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kjzprcd$kli_uzid".
" SELECT 0,pox,pox1,cktg,dat,cpj,kms,mstt,SUM(kon) FROM F$kli_vxcf"."_kjzprc$kli_uzid ".
" WHERE kms > 0 GROUP BY dat,cpj ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprcd$kli_uzid WHERE kon < 2 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid,F$kli_vxcf"."_kjzprcd$kli_uzid SET F$kli_vxcf"."_kjzprc$kli_uzid.pox1=999 ".
" WHERE F$kli_vxcf"."_kjzprc$kli_uzid.dat=F$kli_vxcf"."_kjzprcd$kli_uzid.dat AND F$kli_vxcf"."_kjzprc$kli_uzid.cpj=F$kli_vxcf"."_kjzprcd$kli_uzid.cpj ".
" AND F$kli_vxcf"."_kjzprc$kli_uzid.cktg=F$kli_vxcf"."_kjzprcd$kli_uzid.dok"; 
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE pox1 = 999 "; $dsql = mysql_query("$dsqlt");

//exit;

//rozdiel
$skms=0;
$sqldok = mysql_query("SELECT SUM(kms) AS skms FROM F$kli_vxcf"."_kjzprc$kli_uzid GROUP BY pox");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $skms=$riaddok->skms;
  }

if( $skms > $n_dok ) { $i=26; }
//if( $skms < $n_dok AND $i == 25 ) { $i=20; }

$i = $i + 1;
  }

//vypocitaj rozdiel oproti n_dok a vymaz najblizsiu nizsiu
$rozdiel=1*($skms-$n_dok);
//echo $rozdiel;
if( $rozdiel > 0 )
      {

$iu=0;

  while ( $iu <= 30 )
  {

//echo "idem";

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_kjzprc$kli_uzid ORDER BY kms DESC");
  if (@$zaznam=mysql_data_seek($sqldok,$iu))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cktg=$riaddok->cktg;
  $kms=$riaddok->kms;
  }

//echo " ".$kms." < ".$rozdiel;

if( $kms < $rozdiel )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzprc$kli_uzid WHERE cktg = $cktg ";
$dsql = mysql_query("$dsqlt");

$sqldok = mysql_query("SELECT SUM(kms) AS skms FROM F$kli_vxcf"."_kjzprc$kli_uzid GROUP BY pox");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $skms=$riaddok->skms;
  }
$rozdiel=1*($skms-$n_dok);
//echo "robim".$rozdiel;
if( $rozdiel < 60 OR $rozdiel > 60 ) { $iu=30; }
}

$iu = $iu + 1;
  }
      }

if( $rozdiel < 60 OR $rozdiel > 60 ) 
  {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_kjzprc$kli_uzid ORDER BY kms DESC");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cktg=$riaddok->cktg;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET kms=kms-$rozdiel WHERE cktg = $cktg "; $dsql = mysql_query("$dsqlt");
//echo $dsqlt;
  }
//koniec rozdiel uprav

//premenna
$generovane=$kli_vume."-".$cvoz;
//echo $generovane;

//vymaz doklady
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopstzh WHERE unk = '$generovane' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopstzp WHERE xfak = '$generovane' ";
$dsql = mysql_query("$dsqlt");

//doklad
$skms=0;
$sqldok = mysql_query("SELECT dok FROM F$kli_vxcf"."_dopstzh ORDER BY dok DESC");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $newdok=$riaddok->dok+1;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET dok=$newdok+pox1 "; $dsql = mysql_query("$dsqlt");


//uloz do dopstzh a dopstzh
//dopstzh uce  ume  dat  dok  doq  stz  cvoz  cvop1  cvop2  oc  oczv  
//        nakp  spop  tonys  tonyp  dbnak  dbjaz  dbost  kms  kmn  pocj  unk  poz  id  datm  

//kjzprc  cktg  pox  pox1  dok  dat  cpj  kms  mstt  kon 

$dsqlt = "UPDATE F$kli_vxcf"."_kjzprc$kli_uzid SET pox=1 "; $dsql = mysql_query("$dsqlt");

//precitaj vodica
$vodic=1;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopvod WHERE cvoz = '$cvoz' ORDER BY oc");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $vodic=$riaddok->oc;
  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopstzh ".
" SELECT '','$kli_vume',dat,dok,dok,dok,'$cvoz','','','$vodic',0,".
" 0,0,0,0,0,0,0,SUM(kms),SUM(kms),SUM(pox),'$generovane','','$kli_uzid',now() FROM F$kli_vxcf"."_kjzprc$kli_uzid ".
" WHERE dok > 0 GROUP BY dok";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopstzp dok  cpl  ico  str  zak  pop  ptx  dpdop  tonys  tonyp  drnak  dbnak  odch  prich  dbjaz  drost  dbost  vlek  kms  kmn  pocj  
//        pfak  cfak  dfak  xfak  id  datm  


$dsqlt = "INSERT INTO F$kli_vxcf"."_dopstzp ".
" SELECT dok,0,'$fir_fico',0,0,'',mstt,0,0,0,0,0,0,0,0,0,0,0,kms,kms,1,".
" 0,0,0,'$generovane','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_kjzprc$kli_uzid ".
" WHERE dok > 0 ORDER BY dok";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kjzprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$copern=10;
}
//koniec generuj


//Tabulka dopslcesty
$sql = "SELECT * FROM F$kli_vxcf"."_dopslcesty";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_dopslcesty!"."<br />";

$sqlt = <<<dopslcesty
(
   cpl         int not null auto_increment,
   stat        VARCHAR(3),
   msta        VARCHAR(30),
   mstb        VARCHAR(30),
   kma         INT(6),
   kmb         INT(6),
   pcj         DECIMAL(5,2),
   id          INT,
   PRIMARY KEY(cpl)
);
dopslcesty;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dopslcesty'.$sqlt;
//echo 'CREATE TABLE F'.$kli_vxcf.'_dopslcesty'.$sqlt;

$vysledek = mysql_query("$sql");
if ($vysledek)
//      echo "Tabulka F$kli_vxcf"."_dopslcesty!"."vytvoren· <br />";

$sql = "ALTER TABLE F$kli_vxcf"."_dopslcesty ENGINE InnoDB";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_dopslcesty ( stat,msta,mstb,kma,kmb,pcj,id )".
" VALUES ( 'SK', 'Senica', 'TrenËÌn', '82', '85', '2', '2' )";
$ttqq = mysql_query("$ttvv");
}
$sql = "ALTER TABLE F$kli_vxcf"."_dopslcesty ADD nahoda DECIMAL(10,4) DEFAULT 0 AFTER id ";
$vysledek = mysql_query("$sql");
//koniec tabulky dopslcesty

//zmazanie polozky
if( $copern == 1018 )
           {

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_kms = 1*$_REQUEST['cislo_kms'];
$cislo_nph = 1*$_REQUEST['cislo_nph'];
$cislo_sph = 1*$_REQUEST['cislo_sph'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopstzp WHERE cpl = $cislo_cpl ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh SET kms=kms-$cislo_kms, nakp=nakp-$cislo_nph, spop=spop-$cislo_sph  WHERE dok = $cislo_dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$copern=10;
           }
//koniec zmazanie polozky

//uprava polozky
$upravit=0;
$cplstz=0;
//zapis polozky
if( $copern == 3618 )
{
$oprava = $_REQUEST['oprava'];
if( $oprava == 1 )
 {
$cplstz = 1*$_REQUEST['cplstz'];
$upravit=1;
 }

$n_dat = $_REQUEST['n_dat'];
$n_dok = 1*$_REQUEST['n_dok'];
$n_kms = 1*$_REQUEST['n_kms'];
$n_kmu = 1*$_REQUEST['n_kmu'];
$n_nph = 1*$_REQUEST['n_nph'];
$n_sph = 1*$_REQUEST['n_sph'];
$n_pop = $_REQUEST['n_pop'];
$h_tachom = 1*$_REQUEST['h_tachom'];

//echo $h_tachom;
//exit;

if( $n_kms > 0 AND $n_kmu == 0 ) { $n_kmu=$n_kms-$h_tachom;  }
if( $n_kmu < 0 ) { $n_kmu=0;  }

$niejestz=1;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopstzh WHERE dok=$n_dok ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $n_dat=$riaddok->dat;
  $niejestz=0;
  }
if( $n_dok <= 0 ) { $niejestz=1; }


//ak nie je doklad zaloz novy
if( $niejestz == 1 )
{
//echo "nieje stz";

$newdok=1;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopstzh WHERE dok >= 0 ORDER BY dok DESC LIMIT 1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $newdok=$riaddok->dok+1;
  }
if( $newdok <= 0 ) { $newdok=1; }

$pole = explode(".", $n_dat);
$n_datden=$pole[0];
$n_datmes=$pole[1];
$datumstz=$kli_vrok."-".$n_datmes."-".$n_datden;

$cvodica=0;
$sqldtt = "SELECT * FROM F$kli_vxcf"."_dopvod WHERE cvoz = '$cvoz' ";
$sqldov = mysql_query("$sqldtt");
//echo $sqldtt;
  if (@$zaznam=mysql_data_seek($sqldov,0))
  {
  $riaddov=mysql_fetch_object($sqldov);
  $cvodica=$riaddov->oc;
  }

$sqlhh = "INSERT INTO F$kli_vxcf"."_dopstzh ( ume,dok,doq,stz,dat,cvoz,oc,id,tonys,tonyp,dbnak,dbjaz,dbost,kms,kmn,pocj,uce,cvop1,cvop2,oczv,nakp,spop,unk,poz )".
" VALUES ( '$kli_vume', $newdok, $newdok, $newdok, '$datumstz', '$cvoz', '$cvodica', $kli_uzid, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', 0, 0, 0, '', '' )";
//echo $sqlhh;
$ulozene = mysql_query("$sqlhh");

$n_dok=$newdok;
}

$pocetpol=1;
if( $upravit == 1 ) { $pocetpol=0; }

$dsqlt = "UPDATE F$kli_vxcf"."_dopstzh SET kms=kms+$n_kmu, nakp=$n_nph, spop=$n_sph, pocj=pocj+$pocetpol  WHERE dok = $n_dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt"); 

if( $upravit == 0 AND $n_kmu > 0 ) {
$sqty = "INSERT INTO F$kli_vxcf"."_dopstzp ( dok,ico,str,zak,dpdop,tonys,tonyp,drnak,dbnak,odch,prich,".
" dbjaz,drost,dbost,vlek,kms,kmn,pocj,pop,ptx,dfak,cfak,pfak,id )".
" VALUES ('$n_dok', '$fir_fico', '$h_str', '$h_zak', '$h_dpdop', '$h_tonys', '$h_tonyp', '$h_drnak', '$h_dbnak',".
" '$h_odch', '$h_prich', '$h_dbjaz', '$h_drost', '$h_dbost', '$h_vlek', '$n_kmu', '$h_kmn', '1',".
" '$h_pop','$n_pop', 0, 0, 0, '$kli_uzid' );"; 
                    }
if( $upravit == 1 ) {
$sqty = "UPDATE F$kli_vxcf"."_dopstzp SET ".
" kms='$n_kmu', ptx='$n_pop' ".
" WHERE cpl = $cplstz "; 
                    }

$ulozene = mysql_query("$sqty"); 

$copern=10;
}
//koniec zapis polozky


//zobrazenie vozidiel
if( $copern == 1 OR $copern == 11 )
           {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazds'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsw'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prckjazds
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   stz         INT(8),
   cvoz        VARCHAR(15),
   oc          INT(8),
   nakp        DECIMAL(10,2),
   spop        DECIMAL(10,2),
   kms         INT(4),
   pocj        INT(3),
   tchm        INT(6),
   pdru        INT(3),
   ppox        INT(3),
   dpdop       INT(8),
   pop         VARCHAR(80),
   akydex      INT(3),
   svx         INT(3),
   cplx         DECIMAL(10,0)
);
prckjazds;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prckjazds'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prckjazdsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prckjazdsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prckjazdsz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prckjazdsw'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$dat_poc=$kli_vrok."-01-01";
$ume_poc="01.".$kli_vrok;


//zober pociatocny stav phm a km
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazds$kli_uzid"." SELECT".
" 0,'0','$dat_poc',0,0,cvoz,0,phml,0,0,0,spmn4,1,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_dopvoz".
" WHERE dvoz = 6";
$dsql = mysql_query("$dsqlt");


//zober pohyby zo stzh
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazds$kli_uzid"." SELECT".
" 0,ume,dat,dok,stz,F$kli_vxcf"."_dopstzh.cvoz,F$kli_vxcf"."_dopstzh.oc,nakp,spop,kms,pocj,kms,1,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_dopstzh,F$kli_vxcf"."_dopvoz".
" WHERE ume <= $kli_vume AND F$kli_vxcf"."_dopvoz.dvoz = 6 AND F$kli_vxcf"."_dopstzh.cvoz=F$kli_vxcf"."_dopvoz.cvoz ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//za kazdy den s kalendara pre kazde auto z dopvoz ak nie je uz pohyb az do polozkoviteho
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsy$kli_uzid".
" SELECT 0,ume,dat,0,0,cvoz,0,0,0,0,0,0,1,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_dopvoz,kalendar WHERE dvoz=6 AND ume = $kli_vume ".
" ORDER BY cvoz,dat".
"";
$dsql = mysql_query("$dsqlt");


//sumar za vozidla
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsx$kli_uzid "." SELECT".
" 0,ume,dat,dok,stz,cvoz,oc,SUM(nakp),SUM(spop),SUM(kms),SUM(pocj),SUM(tchm),1,1,dpdop,pop,akydex,svx,0".
" FROM F$kli_vxcf"."_prckjazds$kli_uzid".
" WHERE ppox = 1".
" GROUP BY cvoz".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//koniec copern=1
           }

//zobrazenie poloziek za jedno vozidlo
if( $copern == 11 OR $copern == 10 OR $copern == 21 OR $copern == 20 )
           {
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prckjazdsz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prckjazdsw'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
if( $copern == 11 ) $copern=10;
if( $copern == 21 ) $copern=20;
           }
if( $copern == 10 OR $copern == 20 )
           {

//zober pohyby v mesiaci za vozidlo $cvoz z dopstzp bez nak,spo phm
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsz$kli_uzid".
" SELECT 0,ume,dat,F$kli_vxcf"."_dopstzp.dok,stz,cvoz,oc,0,0,F$kli_vxcf"."_dopstzp.kms,".
"F$kli_vxcf"."_dopstzp.pocj,F$kli_vxcf"."_dopstzp.kms,1,1,dpdop,ptx,0,0,F$kli_vxcf"."_dopstzp.cpl".
" FROM F$kli_vxcf"."_dopstzp,F$kli_vxcf"."_dopstzh WHERE F$kli_vxcf"."_dopstzp.dok = F$kli_vxcf"."_dopstzh.dok AND ume = $kli_vume AND cvoz = '$cvoz'".
" ORDER BY cvoz,dat".
"";
$dsql = mysql_query("$dsqlt");

//zober nak,spo phm v mesiaci za vozidlo $cvoz z dopstzh
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsz$kli_uzid".
" SELECT 0,ume,dat,dok,stz,cvoz,oc,nakp,spop,0,".
"0,0,0,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_dopstzh WHERE ume = $kli_vume AND cvoz = '$cvoz' AND ( nakp != 0 OR spop != 0 OR kms = 0 )".
" ORDER BY cvoz,dat".
"";
$dsql = mysql_query("$dsqlt");

//pridaj pociatocny stav mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsz$kli_uzid "." SELECT".
" 0,ume,dat,dok,stz,cvoz,oc,SUM(nakp),SUM(spop),SUM(kms),SUM(pocj),SUM(tchm),1,1,dpdop,pop,akydex,svx,0".
" FROM F$kli_vxcf"."_prckjazds$kli_uzid".
" WHERE ume < $kli_vume AND cvoz = '$cvoz' ".
" GROUP BY cvoz".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//pridaj datumy kde nie su pohyby
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsw$kli_uzid".
" SELECT 0,ume,dat,0,0,cvoz,0,0,0,0,0,0,1,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_prckjazdsy$kli_uzid ".
" WHERE F$kli_vxcf"."_prckjazdsy$kli_uzid.cvoz = '$cvoz' ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prckjazdsw$kli_uzid,F$kli_vxcf"."_prckjazdsz$kli_uzid".
" SET F$kli_vxcf"."_prckjazdsw$kli_uzid.ppox = 9".
" WHERE F$kli_vxcf"."_prckjazdsw$kli_uzid.dat=F$kli_vxcf"."_prckjazdsz$kli_uzid.dat ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsz$kli_uzid".
" SELECT 0,ume,dat,0,0,cvoz,0,0,0,0,0,0,1,1,0,'',0,0,0".
" FROM F$kli_vxcf"."_prckjazdsw$kli_uzid ".
" WHERE ppox = 1 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//az po tadeto je pridavanie datumov


//nastav akydex a svx
$dsqlt = "UPDATE F$kli_vxcf"."_prckjazdsz$kli_uzid,kalendar".
" SET F$kli_vxcf"."_prckjazdsz$kli_uzid.akydex=kalendar.akyden, F$kli_vxcf"."_prckjazdsz$kli_uzid.svx=kalendar.svt".
" WHERE F$kli_vxcf"."_prckjazdsz$kli_uzid.dat=kalendar.dat ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar vsetko = celkom
$dsqlt = "INSERT INTO F$kli_vxcf"."_prckjazdsz$kli_uzid "." SELECT".
" 0,ume,dat,dok,stz,cvoz,oc,SUM(nakp),SUM(spop),SUM(kms),SUM(pocj),SUM(tchm),9,9,dpdop,pop,akydex,svx,0".
" FROM F$kli_vxcf"."_prckjazdsz$kli_uzid".
" WHERE ppox = 1 AND ume = $kli_vume".
" GROUP BY ppox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

           }

if( $copern == 10 )
           {

$sql = "SELECT maxk FROM F".$kli_vxcf."_dopgenkjzdset ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_dopgenkjzdset ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   id            DECIMAL(5,0) DEFAULT 0,
   ubkm          DECIMAL(10,0) DEFAULT 0,
   tchk          DECIMAL(10,0) DEFAULT 0,
   sphm          DECIMAL(10,0) DEFAULT 0,
   ajso          DECIMAL(10,0) DEFAULT 0,
   ajne          DECIMAL(10,0) DEFAULT 0,
   ajsv          DECIMAL(10,0) DEFAULT 0,
   maxk          DECIMAL(10,0) DEFAULT 0,
   lenx          DECIMAL(10,0) DEFAULT 0
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dopgenkjzdset'.$sqlt;
$vytvor = mysql_query("$vsql");
               }

$skms=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopgenkjzdset WHERE id = $kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ubkm=1*$riaddok->ubkm;
  $tchk=1*$riaddok->tchk;
  $sphm=1*$riaddok->sphm;
  $ajso=1*$riaddok->ajso;
  $ajne=1*$riaddok->ajne;
  $ajsv=1*$riaddok->ajsv;
  $maxk=1*$riaddok->maxk;
  $lenx=1*$riaddok->lenx;
  }

//echo"ubkm".$ubkm;
            }
//koniec copern 1 alebo 11

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=9'); }
?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Kniha j·zd</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:15px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:15px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:15px; }
td.hvstup  { background-color:#ffffff; color:black; font-weight:normal;
                  height:12px; font-size:15px; }

 div.strana {
  padding-left:8;
  font-weight:bold;
  background-color:#ffff90;
  cursor:pointer;
}

 div.nekliknute {
  padding-left:8;
  font-weight:normal;
  background-color:#ffff90;
  cursor:pointer;
}

 div.kliknute {
  padding-left:8;
  font-weight:bold;
  background-color:lightgreen;
  cursor:pointer;
}

  </style>

<?php if( $copern == 10 ) { ?>
<script type="text/javascript" src="dop_ces_newxml.js"></script>
<?php                     } ?>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

//co urobi po potvrdeni ok z tabulky ces
function vykonajCes(msta,mstb,kma,kmb,cpl,polozka)
                {


         if( polozka == 1 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 2 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 3 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 4 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 5 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 6 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 7 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 8 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 9 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 10 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }


         if( polozka == 11 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 12 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 13 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 14 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 15 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 16 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 17 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 18 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 19 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 20 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }

         if( polozka == 21 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 22 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 23 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 24 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 25 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 26 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 27 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 28 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 29 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 30 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }

         if( polozka == 31 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 32 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 33 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 34 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 35 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 36 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 37 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 38 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 39 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 40 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }

         if( polozka == 41 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 42 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 43 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 44 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 45 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 46 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 47 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 48 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 49 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 50 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }

         if( polozka == 51 ) {
         if(document.forms.fhosnew1.n_kms.value == '' ){ document.forms.fhosnew1.n_kms.value = 0; }
         document.forms.fhosnew1.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew1.n_kmu.value = kma;
         myCesElement1.style.display='none';
         document.forms.fhosnew1.n_kmu.focus();
         document.forms.fhosnew1.n_kmu.select();
                            }

         if( polozka == 52 ) {
         if(document.forms.fhosnew2.n_kms.value == '' ){ document.forms.fhosnew2.n_kms.value = 0; }
         document.forms.fhosnew2.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew2.n_kmu.value = kma;
         myCesElement2.style.display='none';
         document.forms.fhosnew2.n_kmu.focus();
         document.forms.fhosnew2.n_kmu.select();
                            }

         if( polozka == 53 ) {
         if(document.forms.fhosnew3.n_kms.value == '' ){ document.forms.fhosnew3.n_kms.value = 0; }
         document.forms.fhosnew3.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew3.n_kmu.value = kma;
         myCesElement3.style.display='none';
         document.forms.fhosnew3.n_kmu.focus();
         document.forms.fhosnew3.n_kmu.select();
                            }

         if( polozka == 54 ) {
         if(document.forms.fhosnew4.n_kms.value == '' ){ document.forms.fhosnew4.n_kms.value = 0; }
         document.forms.fhosnew4.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew4.n_kmu.value = kma;
         myCesElement4.style.display='none';
         document.forms.fhosnew4.n_kmu.focus();
         document.forms.fhosnew4.n_kmu.select();
                            }

         if( polozka == 55 ) {
         if(document.forms.fhosnew5.n_kms.value == '' ){ document.forms.fhosnew5.n_kms.value = 0; }
         document.forms.fhosnew5.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew5.n_kmu.value = kma;
         myCesElement5.style.display='none';
         document.forms.fhosnew5.n_kmu.focus();
         document.forms.fhosnew5.n_kmu.select();
                            }

         if( polozka == 56 ) {
         if(document.forms.fhosnew6.n_kms.value == '' ){ document.forms.fhosnew6.n_kms.value = 0; }
         document.forms.fhosnew6.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew6.n_kmu.value = kma;
         myCesElement6.style.display='none';
         document.forms.fhosnew6.n_kmu.focus();
         document.forms.fhosnew6.n_kmu.select();
                            }

         if( polozka == 57 ) {
         if(document.forms.fhosnew7.n_kms.value == '' ){ document.forms.fhosnew7.n_kms.value = 0; }
         document.forms.fhosnew7.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew7.n_kmu.value = kma;
         myCesElement7.style.display='none';
         document.forms.fhosnew7.n_kmu.focus();
         document.forms.fhosnew7.n_kmu.select();
                            }

         if( polozka == 58 ) {
         if(document.forms.fhosnew8.n_kms.value == '' ){ document.forms.fhosnew8.n_kms.value = 0; }
         document.forms.fhosnew8.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew8.n_kmu.value = kma;
         myCesElement8.style.display='none';
         document.forms.fhosnew8.n_kmu.focus();
         document.forms.fhosnew8.n_kmu.select();
                            }

         if( polozka == 59 ) {
         if(document.forms.fhosnew9.n_kms.value == '' ){ document.forms.fhosnew9.n_kms.value = 0; }
         document.forms.fhosnew9.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew9.n_kmu.value = kma;
         myCesElement9.style.display='none';
         document.forms.fhosnew9.n_kmu.focus();
         document.forms.fhosnew9.n_kmu.select();
                            }

         if( polozka == 60 ) {
         if(document.forms.fhosnew10.n_kms.value == '' ){ document.forms.fhosnew10.n_kms.value = 0; }
         document.forms.fhosnew10.n_pop.value = msta + " - "+ mstb;
         document.forms.fhosnew10.n_kmu.value = kma;
         myCesElement10.style.display='none';
         document.forms.fhosnew10.n_kmu.focus();
         document.forms.fhosnew10.n_kmu.select();
                            }


                }





  function ZmazCpl( cpl, doklad, klmt, nphm, sphm )
  { 

window.open('kjazd.php?cislo_cpl=' + cpl + '&cislo_dok=' + doklad + '&cislo_kms=' + klmt + '&cislo_nph=' + nphm + '&cislo_sph=' + sphm + '&copern=1018&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>',
 '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
    }

  function bcxokl(oc )
  { 
var h_oc=oc;
  var h_dod = document.forms.fkoef.h_dod.value;
  var h_ddo = document.forms.fkoef.h_ddo.value;
  var h_hdo = document.forms.fkoef.h_hdo.value;

window.open('../mzdy/dochadzka_listkypdf.php?cislo_oc=' + h_oc + '&h_dod=' + h_dod + '&h_ddo=' + h_ddo + '&h_hdo=' + h_hdo + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

  }

<?php if( $nacitajphm == 1 ) { $sphm=$spotlitre; $ubkm=""; $tchk=""; } ?>

function RozniGeneruj()
                {

  myGener = document.getElementById("Generovanie");
  var htmlgen = " ";

  htmlgen += "<FORM name='fhosgen' class='obyc' method='post' action='#' ><table class='ponuka' width='100%' ><tr>";

  htmlgen += "<td width='50%' >Generovanie knihy j·zd za <?php echo $kli_vume; ?></td>";
  htmlgen += "<td width='50%' align='right'> SP<?php echo $priemernaspotrebax; ?> l/100km, CN<?php echo $cenaphmx; ?> eur/l, UC<?php echo $ucetphmx; ?> ";
  htmlgen += " <img border=1 src='../obr/zmazuplne.png' style='width:20; height:15;' title='Zhasni menu a negeneruj knihu j·zd' ";
  htmlgen += " onClick=\"ZhasniGeneruj();\"></tr>";
  htmlgen += "<tr><td class='ponuka' colspan='1' >UbehnutÈ kilometre v mesiaci:</td>";
  htmlgen += "<td class='ponuka' colspan='1' ><input class='hvstup' type='text' name='n_dok' id='n_dok' size='10' onkeyup='CiarkaNaBodku(this)' value='<?php echo $ubkm; ?>'/> [km]</td></tr>";

  htmlgen += "<tr><td class='ponuka' colspan='1' >Stav tachometra na konci mesiaca:</td>";
  htmlgen += "<td class='ponuka' colspan='1' ><input class='hvstup' type='text' name='n_dok1' id='n_dok1' size='10' onkeyup='CiarkaNaBodku(this)' value='<?php echo $tchk; ?>' /> [km]</td></tr>";

  htmlgen += "<tr><td class='ponuka' colspan='1' >Spotreba PHM v mesiaci:</td>";
  htmlgen += "<td class='ponuka' colspan='1' ><input class='hvstup' type='text' name='n_dok2' id='n_dok2' size='10' onkeyup='CiarkaNaBodku(this)' value='<?php echo $sphm; ?>' /> [litre]";
  htmlgen += " <img border=1 src='../obr/vlozit.png' style='width:20; height:15;' title='NaËÌtaù spotrebu z ˙ËtovnÌctva' ";
  htmlgen += " onClick=\"NacitajLitre();\">NaËÌtaù<?php if( $nacitajphm == 1 ) { echo  '- NaËÌtanÈ '.$phmeur.' Eur'; } ?></td></tr>";

  htmlgen += "<tr><td class='ponuka' colspan='2' >Soboty<input type='checkbox' name='ajso' value='1' />";
  htmlgen += " Nedele<input type='checkbox' name='ajne' value='1' />";
  htmlgen += " Sviatky<input type='checkbox' name='ajsv' value='1' />";
  htmlgen += "<tr><td class='ponuka' colspan='2' >Len pouûitÈ cesty<input type='checkbox' name='lenx' value='1' />";
  htmlgen += " Max.dÂûka jednej cesty<input class='hvstup' type='text' name='maxk' id='maxk' size='10' onkeyup='CiarkaNaBodku(this)' value='<?php echo $maxk; ?>' /> [km]";
  htmlgen += "</td></tr>";


  htmlgen += "<tr><td colspan='2' align='right'>";
  htmlgen += " Generovaù <img border=1 src='../obr/ok.png' style='width:20; height:15;' title='Generuj knihu j·zd' ";
  htmlgen += " onClick=\"UlozGeneruj();\"></td></tr>";

  htmlgen += "</table></FORM>";


  myGener.innerHTML = htmlgen;
  Generovanie.style.display='';

<?php if ( $ajso == 1 ) {?>document.fhosgen.ajso.checked = 'checked';<?php } ?>
<?php if ( $ajsv == 1 ) {?>document.fhosgen.ajsv.checked = 'checked';<?php } ?>
<?php if ( $ajne == 1 ) {?>document.fhosgen.ajne.checked = 'checked';<?php } ?>
<?php if ( $lenx == 1 ) {?>document.fhosgen.lenx.checked = 'checked';<?php } ?>

  document.forms.fhosgen.n_dok.focus();
  document.forms.fhosgen.n_dok.select();


                }


function NacitajLitre()
                {

window.open('kjazd.php?copern=6818&drupoh=<?php echo $drupoh; ?>&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>', '_self' );

                }

function UlozGeneruj()
                {

var n_dok = document.forms.fhosgen.n_dok.value;
var n_dok1 = document.forms.fhosgen.n_dok1.value;
var n_dok2 = document.forms.fhosgen.n_dok2.value;
var pskm = document.forms.pockm.pockm.value;
var maxk = document.forms.fhosgen.maxk.value;
  var ajso = 0;
  if( document.fhosgen.ajso.checked ) ajso=1;
  var ajne = 0;
  if( document.fhosgen.ajne.checked ) ajne=1;
  var ajsv = 0;
  if( document.fhosgen.ajsv.checked ) ajsv=1;
  var lenx = 0;
  if( document.fhosgen.lenx.checked ) lenx=1;

window.open('kjazd.php?copern=3818&n_dok=' + n_dok + '&h_pskm=' + pskm + '&n_dok1=' + n_dok1 + '&n_dok2=' + n_dok2 + '&ajso=' + ajso + '&ajsv=' + ajsv + '&ajne=' + ajne + '&lenx=' + lenx + '&maxk=' + maxk + '&drupoh=<?php echo $drupoh; ?>&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>', '_self' );

                }

function ZhasniGeneruj()
                {

  myGener = document.getElementById("Generovanie");
  var htmlgen = "";
  myGener.innerHTML = htmlgen;
  Generovanie.style.display='none';
                }

    function textVoz( cvzx )
    {

var h_cvz = cvzx;

window.open('../doprava/dop_text.php?h_cvz=' + h_cvz + '&copern=1&drupoh=<?php echo $drupoh;?>&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }

function HelpKJazd()
                {

window.open('help_kniha_jazd.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
   
</script>
</HEAD>
<BODY class="white" <?php if( $nacitajphm == 1 ) { echo "onload='RozniGeneruj();'"; } ?> >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Doprava - Kniha j·zd</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//zobrazenie vozidiel
if( $copern == 1 )
           {
?>

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" colspan="4"><?php echo "Kniha j·zd za $kli_vume v˝ber vozidla"; ?>

<a href="#" onClick="window.open('kjazd.php?copern=1&drupoh=1&page=1&typ=HTML&repoc=1', '_self','<?php echo $uliscwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=1 title='PrepoËet upravenej knihy j·zd' ></a>PrepoËet

</td>
<td class="bmenu" colspan="3" align="right">

HELP<img src='../obr/info.png' width=20 height=20 border=0 onClick="HelpKJazd();" alt='Help - Kniha j·zd' >

Cesty<img src='../obr/auta/auto3.jpg' onClick="window.open('dopslcesty.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )" width=20 height=15 border=1 title='SluûobnÈ cesty' >

<?php echo "FIR$kli_vxcf $kli_nxcf"; ?></td>

</tr>

<tr>
<td class="bmenu" width="14%" >&nbsp;</td>
<td class="bmenu" width="26%" >Vozidlo</td>
<td class="bmenu" width="11%" align="right">Tachometer[km] T</td>
<td class="bmenu" width="11%" align="right">UbehnutÈ km U</td>
<td class="bmenu" width="11%" align="right">N·kup PHM[l] N</td>
<td class="bmenu" width="11%" align="right">Spotreba PHM[l] S</td>
<td class="bmenu" width="20%" align="right"> </td>
</tr>

<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_prckjazdsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_dopvoz".
" ON F$kli_vxcf"."_prckjazdsx$kli_uzid.cvoz=F$kli_vxcf"."_dopvoz.cvoz".
" WHERE ppox > 0 ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$strana=1;
$tchms=0;

  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
$page=1;
?>

<tr>
<td class="bmenu" >
<a href="#" onClick="window.open('kjazd.php?copern=20&drupoh=1&page=1&typ=PDF&cvoz=<?php echo $polozka->cvoz; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=1 title='VytlaËiù vo form·te PDF' ></a>TlaË
<a href="#" onClick="window.open('kjazd.php?copern=10&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $polozka->cvoz; ?>', '_self'  )">
<img src='../obr/zoznam.png' width=20 height=15 border=1 title='Zobrazenie a ˙prava knihy j·zd' ></a>Uprav
</td>
<td class="hvstup" >
<a href="#" onClick="window.open('kjazd.php?copern=10&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $polozka->cvoz; ?>', '_self'  )">
<?php echo $polozka->cvoz; ?> <?php echo $polozka->pvoz; ?></a></td>
<td class="hvstup" align="right"><?php echo $polozka->tchm; ?>

<img src='../obr/orig.png' width=20 height=15 border=1 onclick="textVoz('<?php echo $polozka->cvoz;?>')" title="DoplÚuj˙ce ˙daje o vozidle" >Dop

</td>
<td class="hvstup" align="right"><?php echo $polozka->kms; ?></td>
<td class="hvstup" align="right"><?php echo $polozka->nakp; ?></td>
<td class="hvstup" align="right"><?php echo $polozka->spop; ?></td>

<td class="hvstup" align="left">

<a href='cvoz.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_cvoz=<?php echo $polozka->cvoz;?>&h_cvoz=<?php echo $polozka->cvoz;?>
&h_pvoz=<?php echo $polozka->pvoz;?>&h_tpvz=<?php echo $polozka->tpvz;?>&h_tvoz=<?php echo $polozka->tvoz;?>&h_dvoz=<?php echo $polozka->dvoz;?>
&h_dphm=<?php echo $polozka->dphm;?>&h_uzhm=<?php echo $polozka->uzhm;?>&h_cpdv=<?php echo $polozka->cpdv;?>
&h_cmtr=<?php echo $polozka->cmtr;?>&h_phml=<?php echo $polozka->phml;?>&h_spmn4=<?php echo $polozka->spmn4;?>
&h_phms=<?php echo $polozka->phms;?>&h_vstr=<?php echo $polozka->vstr;?>
&h_vzak=<?php echo $polozka->vzak;?>&h_sdph=<?php echo $polozka->sdph;?>
'>
 <img src='../obr/uprav.png' width=20 height=15 border=1 title="⁄prava ˙dajov o vozidle" ></a>Voz


<a href='cvoz.php?sys=<?php echo $sys; ?>&copern=87&page=<?php echo $page;?>&cislo_cvoz=<?php echo $polozka->cvoz;?>&h_cvoz=<?php echo $polozka->cvoz;?>
&h_cnsn=<?php echo $polozka->cnsn;?>&h_cnsnv=<?php echo $polozka->cnsnv;?>&h_cnbn=<?php echo $polozka->cnbn;?>&h_cnbnv=<?php echo $polozka->cnbnv;?>
&h_cnak0=<?php echo $polozka->cnak0;?>&h_cnak1=<?php echo $polozka->cnak1;?>&h_cnak2=<?php echo $polozka->cnak2;?>&h_cnak3=<?php echo $polozka->cnak3;?>
&h_ccak0=<?php echo $polozka->ccak0;?>&h_ccak1=<?php echo $polozka->ccak1;?>&h_ccak2=<?php echo $polozka->ccak2;?>&h_ccak3=<?php echo $polozka->ccak3;?>
&h_ccak4=<?php echo $polozka->ccak4;?>&h_ccak5=<?php echo $polozka->ccak5;?>
&h_cnmn0=<?php echo $polozka->cnmn0;?>&h_cnmn1=<?php echo $polozka->cnmn1;?>&h_cnmn2=<?php echo $polozka->cnmn2;?>&h_cnmn3=<?php echo $polozka->cnmn3;?>
'>
 <img src='../obr/ziarovka.png' width=20 height=15 border=1 title="CennÌk vozidla" ></a>Cen

<a href='cvoz.php?sys=<?php echo $sys; ?>&copern=97&page=<?php echo $page;?>&cislo_cvoz=<?php echo $polozka->cvoz;?>&h_cvoz=<?php echo $polozka->cvoz;?>
&h_spsn=<?php echo $polozka->spsn;?>&h_spsnv=<?php echo $polozka->spsnv;?>&h_spbn=<?php echo $polozka->spbn;?>&h_spbnv=<?php echo $polozka->spbnv;?>
&h_snak0=<?php echo $polozka->snak0;?>&h_snak1=<?php echo $polozka->snak1;?>&h_snak2=<?php echo $polozka->snak2;?>&h_snak3=<?php echo $polozka->snak3;?>
&h_scak0=<?php echo $polozka->scak0;?>&h_scak1=<?php echo $polozka->scak1;?>&h_scak2=<?php echo $polozka->scak2;?>&h_scak3=<?php echo $polozka->scak3;?>
&h_spmn0=<?php echo $polozka->spmn0;?>&h_spmn1=<?php echo $polozka->spmn1;?>&h_spmn2=<?php echo $polozka->spmn2;?>&h_spmn3=<?php echo $polozka->spmn3;?>
'>
 <img src='../obr/ziarovka.png' width=20 height=15 border=1 title="Normovan· spotreba vozidla" ></a>Spo
</tr>

<?php
}
$i = $i + 1;
  }
?>

</table>

<?php

if( $kli_vmes == 12 )
     {
$sqlt = <<<sklprc
(
   cvozx       VARCHAR(50) not null,
   druhx       DECIMAL(10,0) DEFAULT 0,
   tchmx       DECIMAL(10,0) DEFAULT 0
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kjzstavtch'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//druhx=1osobne,2=nakladne
$dsqlt = "DELETE FROM F$kli_vxcf"."_kjzstavtch$kli_uzid WHERE druhx = 1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kjzstavtch$kli_uzid".
" SELECT cvoz,1,tchm FROM F$kli_vxcf"."_prckjazdsx$kli_uzid".
" WHERE tchm >= 0  ";
$dsql = mysql_query("$dsqlt");

     }

           }
//koniec copern=1 vyber vozidiel
?>

<?php
//riadkova kniha jazd za jedno vozidlo
if( $copern == 10 OR $copern == 20 )
           {
?>

<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_prckjazdsz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_dopvoz".
" ON F$kli_vxcf"."_prckjazdsz$kli_uzid.cvoz=F$kli_vxcf"."_dopvoz.cvoz".
" LEFT JOIN F$kli_vxcf"."_dopvod".
" ON F$kli_vxcf"."_prckjazdsz$kli_uzid.oc=F$kli_vxcf"."_dopvod.oc".
" WHERE F$kli_vxcf"."_prckjazdsz$kli_uzid.cvoz = '$cvoz' ".
" ORDER BY F$kli_vxcf"."_prckjazdsz$kli_uzid.cvoz,ppox,dat,stz,cplx,pdru";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$k=0; //zaciatok knihy nedaj prevedene
$par=0; //parne nedam biele ale sede
$strana=0;

  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

//vodic
if( $polozka->oc != '' AND $polozka->oc != 0 ) $vodic=$polozka->oc;
//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok4=$rok;
  $rok=$rok-2000;

  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
  $datsk10 = sprintf("%02d.%02d.%04d", $den, $mes, $rok4);

if( $polozka->ume <= $kli_vume AND $polozka->ppox == 1 )
  {
$tchms = $tchms + $polozka->tchm;
$Cislo=$tchms+"";
$Stchms=sprintf("%0.0f", $Cislo);

$phmz = $polozka->nakp - $polozka->spop;
$phms = $phms + $polozka->nakp - $polozka->spop;
$Cislo=$phms+"";
$Sphms=sprintf("%0.2f", $Cislo);

$Skms=$polozka->kms;
if( $polozka->kms == 0 ) $Skms="";
$Snakp=$polozka->nakp;
if( $polozka->nakp == 0 ) $Snakp="";
$Sspop=$polozka->spop;
if( $polozka->spop == 0 ) $Sspop="";
  }

if( $i == 0 )
{
?>

<?php
if( $typ == 'HTML' )
       {
?>


<div id="Generovanie" style="cursor: hand; display: none; position: absolute; z-index: 800; top: 160; left: 300; width:600; height:400;"></div>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="4"><?php echo "Kniha j·zd za $kli_vume - vozidlo $cvoz $polozka->pvoz "; ?>
<a href="#" onClick="window.open('kjazd.php?copern=21&drupoh=1&page=1&typ=PDF&cvoz=<?php echo $cvoz; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=1 title='VytlaËiù vo form·te PDF' ></a>
PrepoËet<a href="#" onClick="window.open('kjazd.php?copern=11&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>', '_self','<?php echo $uliscwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=1 title='PrepoËet upravenej knihy j·zd' ></a>

DEL<a href="#" onClick="window.open('kjazd.php?copern=1661&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>', '_self')">
<img src='../obr/zmaz.png' width=20 height=15 border=1 title='Vymazaù knihu j·zd vozidla <?php echo $cvoz; ?> za <?php echo $kli_vume; ?> ' ></a>


Dop<img src='../obr/orig.png' width=20 height=15 border=1 onclick="textVoz('<?php echo $cvoz;?>')" title="DoplÚuj˙ce ˙daje o vozidle" >

</td>
<td class="bmenu" colspan="5" align="right">

All<a href="#" onClick="window.open('kjazd.php?copern=1&drupoh=1&page=1&typ=HTML', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=1 title='Nasp‰ù do knihy j·zd za vöetky vozidl·' ></a>

Cesty<img src='../obr/auta/auto3.jpg' onClick="window.open('dopslcesty.php?copern=1&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )" width=20 height=15 border=1 title='SluûobnÈ cesty' >

Gen<img src='../obr/naradie.png' onClick="RozniGeneruj();" width=20 height=15 border=1 title='Generovanie knihy j·zd' >

<?php echo "FIR$kli_vxcf $kli_nxcf"; ?></td>
</tr>
<tr>
<td class="bmenu" width="10%" >D·tum</td>
<td class="bmenu" width="13%" >Doklad</td>
<td class="bmenu" width="27%" >Pozn·mka</td>
<td class="hvstup_tzlte" width="8%" align="right">Tachometer[km] T</td>
<td class="bmenu" width="8%" align="right">UbehnutÈ Km U</td>
<td class="bmenu" width="8%" align="right">N·kup PHM [l] N</td>
<td class="bmenu" width="8%" align="right">Spotreba PHM[l] S</td>
<td class="hvstup_tzlte" width="8%" align="right">Zostatok PHM litre</td>
<td class="bmenu" width="8%" align="right">Druh dopravy</td>
</tr>
<?php
//koniec typ html
       }
?>

<?php
if( $typ == 'PDF' )
       {
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/kjazd_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/kjazd_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//koniec typ pdf
       }
?>

<?php
//koniec ak i=0
}
?>

<?php
//j=0 zaciatok strany
if ( $j == 0 )
      {
if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$strana=$strana+1;

$pdf->Cell(110,5,"Kniha j·zd za $kli_vume vozidlo $cvoz $polozka->pvoz","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',7);

$pdf->Cell(20,4,"D·tum","1",0,"L");$pdf->Cell(20,4,"Doklad","1",0,"L");$pdf->Cell(87,4,"Pozn·mka","1",0,"L");

$pdf->Cell(25,4,"Tachometer stav","1",0,"R");$pdf->Cell(25,4,"UbehnutÈ Km","1",0,"R");
$pdf->Cell(25,4,"N·kup PHM litre","1",0,"R");$pdf->Cell(25,4,"Spotreba PHM litre","1",0,"R");$pdf->Cell(15,4,"Druh dop.","1",0,"R");
$pdf->Cell(35,4,"Podpis","1",1,"L");

}
//koniec typ=pdf
      }
//koniec j=0 zaciatok strany
?>

<?php
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
?>

<?php
if( $polozka->ume < $kli_vume )
  {
?>
<?php
if( $typ == 'HTML' )
       {
$pskm=$polozka->tchm;
?>
<tr>

<FORM name='pockm' class='obyc' method='post' action='#' >
<INPUT type='hidden' name='pockm' value='<?php echo $pskm; ?>' ></td>
</FORM>

<td class="<?php echo $hvstup; ?>" >&nbsp;</td>
<td class="<?php echo $hvstup; ?>" >&nbsp;</td>
<td class="<?php echo $hvstup; ?>" >PoËiatoËn˝ stav mesiaca</td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->tchm; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->kms; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->nakp; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->spop; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $Sphms; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"></td>
</tr>
<?php
//koniec typ html
       }
?>
<?php
if( $typ == 'PDF' )
{
$pdf->SetFont('arial','',10);

$pdf->Cell(20,4," ","1",0,"L");$pdf->Cell(20,4," ","1",0,"L");$pdf->Cell(87,4,"PoËiatoËn˝ stav mesiaca","1",0,"L");

$pdf->Cell(25,4,"$polozka->tchm","1",0,"R");$pdf->Cell(25,4,"$polozka->kms","1",0,"R");
$pdf->Cell(25,4,"$polozka->nakp","1",0,"R");$pdf->Cell(25,4,"$polozka->spop","1",0,"R");$pdf->Cell(15,4," ","1",0,"R");
$pdf->Cell(35,4," ","1",1,"L");
}
//koniec typ=pdf
?>
<?php
  }
?>

<?php
if( $polozka->ume == $kli_vume AND $polozka->ppox == 1 )
  {
?>
<?php
if( $typ == 'HTML' )
       {
?>
<tr>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?>&nbsp;
<?php if( $polozka->akydex == 1 ) echo "<span style='background-color:white; color:black;'>Po</span>"; ?>
<?php if( $polozka->akydex == 2 ) echo "<span style='background-color:white; color:black;'>⁄t</span>"; ?>
<?php if( $polozka->akydex == 3 ) echo "<span style='background-color:white; color:black;'>St</span>"; ?>
<?php if( $polozka->akydex == 4 ) echo "<span style='background-color:white; color:black;'>ät</span>"; ?>
<?php if( $polozka->akydex == 5 ) echo "<span style='background-color:white; color:black;'>Pi</span>"; ?>
<?php if( $polozka->akydex == 6 ) echo "<span style='background-color:blue; color:black;'>So</span>"; ?>
<?php if( $polozka->akydex == 7 ) echo "<span style='background-color:red; color:black;'>Ne</span>"; ?>
<?php if( $polozka->svx == 1 ) echo "<span style='background-color:yellow; color:black;'> SV </span>"; ?>
</td>
<td class="<?php echo $hvstup; ?>" >

<?php 
$stchmsx=1*$Stchms;
if( $stchmsx == 0 ) { $stchmsx="0"; } 
?>

<?php
$novevloz=1;
if( $novevloz == 0 )
  {
?>
<img src='../obr/vlozit.png' onClick="VlozSTZ(0, <?php echo $i; ?>, <?php echo $polozka->dok;?>, '<?php echo $datsk;?>', '<?php echo $stchmsx;?>', 0 );" width=20 height=15 border=1 title='Vloûiù nov˝ z·znam do <?php echo $datsk; ?>' >Ins
<?php
  }
?>
<?php
if( $novevloz == 1 )
  {
?>
<img src='../obr/vlozit.png' onClick="nastavdakx<?php echo $i;?>.style.display=''; novaSTZ<?php echo $i;?>();" width=20 height=15 border=1 title='Vloûiù nov˝ z·znam do <?php echo $datsk; ?>' >Ins
<?php
  }
?>



<?php
if( $polozka->stz != 0 )
 {
?>
<a href="#" onClick="window.open('vstd_t.php?copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=1 title="TlaË dokladu <?php echo $polozka->dok;?>" ></a>
<?php
//koniec typ html
 }
?>

<?php
if( $polozka->stz != 0 )
 {
?>
Dok<a href="#" onClick="window.open('vstd_u.php?copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&dvoz=$cvoz&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<?php echo $polozka->stz; ?></a>

<?php
//koniec typ html
 }
?>

<?php
if( $polozka->stz == 0 )
 {
?>
<a href="#" onClick="window.open('vstd_u.php?copern=5&drupoh=1&page=1&vodic=<?php echo $vodic;?>
&cvoz=<?php echo $cvoz;?>&datum=<?php echo $datsk10;?>&kjazd=1', '_blank',
 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
New</a>
<?php
//koniec typ html
 }
?>



</td>
<td class="<?php echo $hvstup; ?>" >

<?php
if( $polozka->stz != 0 )
 {
 
$klmt=1*$Skms;
$nphm=1*$Snakp;
$sphm=1*$Sspop;
if( $klmt == 0 ) { $klmt="0"; } 
if( $nphm == 0 ) { $nphm="0"; } 
if( $sphm == 0 ) { $sphm="0"; } 
?>
<img src='../obr/zmazuplne.png' onClick="ZmazCpl(<?php echo $polozka->cplx; ?>, <?php echo $polozka->dok;?>, <?php echo $klmt;?>, <?php echo $nphm;?>, <?php echo $sphm;?>);" 
 width=20 height=15 border=1 title='Zmazaù poloûku z dokladu <?php echo $polozka->dok;?>' >

<?php
//koniec typ html
 }
?>

<?php echo $polozka->pop; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $Stchms; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $Skms; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $Snakp; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $Sspop; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $Sphms; ?></td>
<td class="<?php echo $hvstup; ?>" align="right">
<?php
if( $polozka->stz != 0 )
 {
?>
<img src='../obr/uprav.png' onClick="nastavdakx<?php echo $i;?>.style.display=''; opravitSTZ<?php echo $i;?>();" width=20 height=15 border=1 title='Upraviù z·znam <?php echo $datsk; ?>' >
<?php
//koniec typ html
 }
?>
<?php echo $polozka->dpdop; ?>

</td>
</tr>



<?php if( $i > 0 )        { ?>
<?php
$newdoklad=1*$polozka->stz;
if( $newdoklad == 0 ) { $newdoklad == ""; }
?>
<tr>
<td colspan="9">
<div id="nastavdakx<?php echo $i;?>" style="display:none;" >
<table>
<tr>
<FORM name='fhosnew<?php echo $i;?>' class='obyc' method='post' action='#' >
<td class='hvstup_zlte' width='6%'><?php echo $datsk;?></td>
<td class='hvstup_zlte' width='10%' ><img border=1 src='../obr/zmazuplne.png' style='width:20; height:15;' title='Zhasni poloûku' onClick="nastavdakx<?php echo $i;?>.style.display='none'; myCesElement<?php echo $i;?>.style.display='none';">
<input class='hvstup' type='text' name='n_dok' id='n_dok' size='10' onKeyDown='return Dok<?php echo $i;?>Enter(event.which)' onkeyup='CiarkaNaBodku(this)' value='<?php echo $newdoklad;?>' /></td>

<td class='bmenu' width='30%' >

 <img border=1 src='../obr/hladaj.png' style='width:20; height:15;' title='Hæadaù sluûobn˙ cestu' 
 onClick="myCesElement<?php echo $i;?>.style.display=''; volajCes(2,<?php echo $i;?>);">
 P<input class='hvstup' type='text' name='n_pop' id='n_pop' size='40' onKeyDown='return Pop<?php echo $i;?>Enter(event.which)' value='' /></td>

 <td class='bmenu' width='9%' align='right' >
 T<input class='hvstup' type='text' name='n_kms' id='n_kms' size='8' onKeyDown='return Kms<?php echo $i;?>Enter(event.which, <?php echo $Stchms; ?>)' onkeyup='CiarkaNaBodku(this)' value='' /></td>

 <td class='bmenu' width='9%' align='right' >
 U<input class='hvstup' type='text' name='n_kmu' id='n_kmu' size='8' onKeyDown='return Kmu<?php echo $i;?>Enter(event.which, <?php echo $Stchms; ?>)' onkeyup='CiarkaNaBodku(this)' value='' /></td>

 <td class='bmenu' width='9%' align='right' >
 N<input class='hvstup' type='text' name='n_nph' id='n_nph' size='8' onKeyDown='return Nph<?php echo $i;?>Enter(event.which)' onkeyup='CiarkaNaBodku(this)' value='' /></td>

 <td class='bmenu' width='9%' align='right' >
 S<input class='hvstup' type='text' name='n_sph' id='n_sph' size='8' onKeyDown='return Sph<?php echo $i;?>Enter(event.which)' onkeyup='CiarkaNaBodku(this)' value='' /></td>

 <td class='bmenu' width='9%' >
 <img border=1 src='../obr/ok.png' style='width:20; height:15;' title='Uloûiù poloûku' onClick="UlozSTZ<?php echo $i;?>('<?php echo $polozka->cplx; ?>', '<?php echo $polozka->dok;?>,','<?php echo $datsk;?>');"></td>

 <td class='bmenu' width='8%' ><INPUT type='hidden' name='h_cpl' value='<?php echo $polozka->cplx; ?>' >
 <INPUT type='hidden' name='h_tachom' value='<?php echo $Stchms; ?>' ></td>
 <INPUT type='hidden' name='h_datum' value='<?php echo $datsk;?>' ></td>
 <INPUT type='hidden' name='oprava' value='0' ></td>
</FORM>
</tr>
</table>
</div>
</td>
</tr>
<script type="text/javascript">

function Dok<?php echo $i;?>Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhosnew<?php echo $i;?>.n_pop.focus();
        document.forms.fhosnew<?php echo $i;?>.n_pop.select();
              } 
                }

function Pop<?php echo $i;?>Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhosnew<?php echo $i;?>.n_kms.value == '' ){ document.forms.fhosnew<?php echo $i;?>.n_kms.value = 0; }

        if(document.forms.fhosnew<?php echo $i;?>.n_pop.value != '' ){
        myCesElement.style.display='none';
        volajCes(1);
                                                     }
        if(document.forms.fhosnew<?php echo $i;?>.n_pop.value == '' ){
        document.forms.fhosnew<?php echo $i;?>.n_kms.focus();
        document.forms.fhosnew<?php echo $i;?>.n_kms.select();
                                                     }
              } 
                }


function Kms<?php echo $i;?>Enter(e ,tachom )
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhosnew<?php echo $i;?>.n_kmu.value == '' ){ document.forms.fhosnew<?php echo $i;?>.n_kmu.value = 0; }
        if(document.forms.fhosnew<?php echo $i;?>.n_kms.value > 0 ){ document.forms.fhosnew<?php echo $i;?>.n_kmu.value = 1*document.forms.fhosnew<?php echo $i;?>.n_kms.value - 1*tachom; }
        document.forms.fhosnew<?php echo $i;?>.n_kmu.focus();
        document.forms.fhosnew<?php echo $i;?>.n_kmu.select();
              } 
                }

function Kmu<?php echo $i;?>Enter(e ,tachom )
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhosnew<?php echo $i;?>.n_nph.value == '' ){ document.forms.fhosnew<?php echo $i;?>.n_nph.value = 0; }
        if(document.forms.fhosnew<?php echo $i;?>.n_kmu.value > 0 ){ document.forms.fhosnew<?php echo $i;?>.n_kms.value = 1*tachom + 1*document.forms.fhosnew<?php echo $i;?>.n_kmu.value; }
        document.forms.fhosnew<?php echo $i;?>.n_nph.focus();
        document.forms.fhosnew<?php echo $i;?>.n_nph.select();
              } 
                }

function Nph<?php echo $i;?>Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhosnew<?php echo $i;?>.n_sph.value == '' ){ document.forms.fhosnew<?php echo $i;?>.n_sph.value = 0; }
        document.forms.fhosnew<?php echo $i;?>.n_sph.focus();
        document.forms.fhosnew<?php echo $i;?>.n_sph.select();
              } 
                }

function Sph<?php echo $i;?>Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.fhosnew<?php echo $i;?>.n_sph.focus();
        document.forms.fhosnew<?php echo $i;?>.n_sph.select();
        if(document.forms.fhosnew<?php echo $i;?>.n_kmu.value > 0 ){ UlozSTZsph(); }
              }
                }

function UlozSTZ<?php echo $i;?>(cpl,doklad, datum)
                {

var n_dok = document.forms.fhosnew<?php echo $i;?>.n_dok.value;
var n_pop = document.forms.fhosnew<?php echo $i;?>.n_pop.value;
var n_kms = document.forms.fhosnew<?php echo $i;?>.n_kms.value;
var n_kmu = document.forms.fhosnew<?php echo $i;?>.n_kmu.value;
var n_nph = document.forms.fhosnew<?php echo $i;?>.n_nph.value;
var n_sph = document.forms.fhosnew<?php echo $i;?>.n_sph.value;
var h_tachom = document.forms.fhosnew<?php echo $i;?>.h_tachom.value;
var oprava = document.forms.fhosnew<?php echo $i;?>.oprava.value;

window.open('kjazd.php?copern=3618&oprava=' + oprava + '&cplstz=' + cpl + '&h_tachom=' + h_tachom + '&n_dat=' + datum + '&n_dok=' + n_dok + '&n_pop=' + n_pop + '&n_kms=' + n_kms + '&n_kmu=' + n_kmu + '&n_nph=' + n_nph + '&n_sph=' + n_sph + '&drupoh=<?php echo $drupoh; ?>&drupoh=1&page=1&typ=HTML&cvoz=<?php echo $cvoz; ?>', '_self' );

                }

function opravitSTZ<?php echo $i;?>()
                {

document.forms.fhosnew<?php echo $i;?>.n_pop.value = '<?php echo $polozka->pop; ?>';
document.forms.fhosnew<?php echo $i;?>.n_kms.value = '';
document.forms.fhosnew<?php echo $i;?>.n_kms.disabled = true;
document.forms.fhosnew<?php echo $i;?>.n_kmu.value = '<?php echo $polozka->kms; ?>';
document.forms.fhosnew<?php echo $i;?>.n_nph.value = '<?php echo $polozka->nph; ?>';
document.forms.fhosnew<?php echo $i;?>.n_sph.value = '<?php echo $polozka->sph; ?>';
document.forms.fhosnew<?php echo $i;?>.oprava.value = '1';


                }

function novaSTZ<?php echo $i;?>()
                {

document.forms.fhosnew<?php echo $i;?>.n_pop.value = '';
document.forms.fhosnew<?php echo $i;?>.n_kms.value = '';
document.forms.fhosnew<?php echo $i;?>.n_kms.disabled = false;
document.forms.fhosnew<?php echo $i;?>.n_kmu.value = '';
document.forms.fhosnew<?php echo $i;?>.n_nph.value = '';
document.forms.fhosnew<?php echo $i;?>.n_sph.value = '';
document.forms.fhosnew<?php echo $i;?>.oprava.value = '0';


                }



</script>
<tr>
<td colspan="9">
<div id="myCesElement<?php echo $i;?>" style="display:none;" >
<table>
<tr>
<td class="9">dfsfdfsdff</td>
</tr>
</table>
</div>
</td>
</tr>

<?php                      } ?>

<?php
//koniec typ html
       }
?>
<?php
if( $typ == 'PDF' )
{
$pdf->SetFont('arial','',10);
$dokstz=$polozka->stz;
if( $dokstz == 0 ) $dokstz="";

$pdf->Cell(20,4,"$datsk","1",0,"L");$pdf->Cell(20,4,"$dokstz","1",0,"L");$pdf->Cell(87,4,"$polozka->pop","1",0,"L");

$pdf->Cell(25,4,"$Stchms","1",0,"R");$pdf->Cell(25,4,"$Skms","1",0,"R");
$pdf->Cell(25,4,"$Snakp","1",0,"R");$pdf->Cell(25,4,"$Sspop","1",0,"R");$pdf->Cell(15,4,"$polozka->dpdop","1",0,"R");
$pdf->Cell(35,4,"$polozka->prie","1",1,"L");
}
//koniec typ=pdf
?>
<?php
  }
?>

<?php
if( $polozka->ume == $kli_vume AND $polozka->ppox == 9 )
  {
?>
<?php
if( $typ == 'HTML' )
       {
?>
<tr>
<td class="hvstup_zlte" >&nbsp;</td>
<td class="hvstup_zlte" >&nbsp;</td>
<td class="hvstup_zlte" >Celkom za mesiac</td>
<td class="hvstup_tzlte" align="right"><?php echo $Stchms; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->kms; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->nakp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->spop; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $Sphms; ?></td>
<td class="hvstup_zlte" align="right"></td>
</tr>
<?php
//koniec typ html
       }
?>
<?php
if( $typ == 'PDF' )
{
$pdf->SetFont('arial','',10);

$pdf->Cell(20,4," ","1",0,"L");$pdf->Cell(20,4," ","1",0,"L");$pdf->Cell(87,4,"Celkom za mesiac","1",0,"L");

$pdf->Cell(25,4,"$Stchms","1",0,"R");$pdf->Cell(25,4,"$polozka->kms","1",0,"R");
$pdf->Cell(25,4,"$polozka->nakp","1",0,"R");$pdf->Cell(25,4,"$polozka->spop","1",0,"R");$pdf->Cell(15,4," ","1",0,"R");
$pdf->Cell(35,4," ","1",1,"L");
}
//koniec typ=pdf
?>
<?php
  }
?>


<?php
}
$i = $i + 1;
$j = $j + 1;

if( $typ == 'PDF' AND $j >= 42 ) { $j=0; }

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

  }
?>

<?php
if( $typ == 'HTML' )
       {
?>
</table>
<?php
//koniec typ html
       }
?>

<?php

           }
//koniec copern=10 kniha za jedno vozidlo
?>




<br /><br />
<?php
// celkovy koniec dokumentu

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazds'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsy'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsz'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prckjazdsw'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

if( $typ == 'PDF' )
{
$pdf->Output("$outfilex");
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
}
$copernx=$copern;
if( $copern == 10 ) $copernx=11;
$zmenume=1; $odkaz="../doprava/kjazd.php?copern=$copernx&drupoh=$drupoh&page=1&typ=HTML&cvoz=$cvoz";
$cislista = include("dop_lista.php");

       } while (false);
?>
</BODY>
</HTML>
