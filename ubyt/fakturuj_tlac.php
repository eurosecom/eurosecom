<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
$clsm = 930;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$podlaico = 1*$_REQUEST['podlaico'];
$ajceny = 1*$_REQUEST['ajceny'];
//echo $cislo_oc;
//exit;

$ubytovani = 1*$_REQUEST['ubytovani'];

$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];

//drupoh 10-fakturuj ume

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);

//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);


$denprvy=$kli_vrok."-".$kli_vmes."-01";
$denposledny=$kli_vrok."-".$kli_vmes."-".$pocetdni;

if( $drupoh >= 10 ) { $ubytovani=1; }

//ak medo tak od 28.2.2011 do 2.3.2011 su 2dni
if( $medo == 0 OR $medo == 1  ) {

$kli_pume=$kli_vume-1;
$kli_prok=$kli_vrok-1;
if( $kli_vmes == 1 ) { $kli_pume="12.".$kli_prok; }

$sqldok = mysql_query("SELECT * FROM kalendar WHERE ume = $kli_pume ORDER BY dat DESC");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denprvy=$riaddok->dat;
  }

                                 }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
<?php if( $copern == 1 ) { echo "Podklad pre fakturáciu PDF"; } ?>
</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
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


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  PDF zostava 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));


 $outfilexdel="../tmp/faktur_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/faktur_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }



   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

if ( $copern == 1 )
    {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          int,
   cpl          int,
   poi          DECIMAL(4,0) DEFAULT 0,
   ico          DECIMAL(10,0) DEFAULT 0,
   dnm          DECIMAL(10,0) DEFAULT 0,
   duh          DECIMAL(4,0) DEFAULT 0,
   dok          DECIMAL(10,0) DEFAULT 0,
   uhr          VARCHAR(15) NOT NULL,
   dat          DATE not null,
   dap          DATE not null,
   dak          DATE not null,
   dap1          DATE not null,
   dak1          DATE not null,
   ubyt         DECIMAL(10,0) DEFAULT 0,
   izba         DECIMAL(10,0) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   dni          DECIMAL(10,0) DEFAULT 0,
   kon          INT(7) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


if ( $ubytovani == 1 AND $drupoh <= 40 )
    {
//zober zo ubytdodh
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,0,0,ico,0,0,dok,unk,dat,dap,dak,dap,dak,0,cizb,chst,0,0 FROM F$kli_vxcf"."_ubytdodh".
" WHERE chst > 0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcu".$kli_uzid." ".
" SET dak='$denposledny' WHERE dak = '0000-00-00' ".
"";
$dsql = mysql_query("$dsqlt");


//dalsi hostia
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcv".$kli_uzid.
" SELECT 1,0,0,0,0,0,dok,'','0000-00-00','0000-00-00','0000-00-00',0,0,dhst,0,0 FROM F$kli_vxcf"."_ubytdalsihostia".
" WHERE dhst > 0 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcv".$kli_uzid.",F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SET F$kli_vxcf"."_mzdprcv".$kli_uzid.".dat=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dat, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".dap=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dap, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".izba=F$kli_vxcf"."_mzdprcu".$kli_uzid.".izba, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".uhr=F$kli_vxcf"."_mzdprcu".$kli_uzid.".uhr, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".ico=F$kli_vxcf"."_mzdprcu".$kli_uzid.".ico, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".dak=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dak  ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".dap1=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dap, ".
"     F$kli_vxcf"."_mzdprcv".$kli_uzid.".dak1=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dak  ".
" WHERE F$kli_vxcf"."_mzdprcv".$kli_uzid.".dok=F$kli_vxcf"."_mzdprcu".$kli_uzid.".dok ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,0,poi,ico,0,duh,dok,uhr,dat,dap,dak,dap1,dak1,0,izba,oc,0,0 FROM F$kli_vxcf"."_mzdprcv".$kli_uzid.
" WHERE oc > 0 ".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,poi,ico,0,duh,dok,uhr,dat,dap,dak,dap1,dak1,0,izba,oc,0,0 FROM F$kli_vxcf"."_mzdprcu".$kli_uzid.
" WHERE oc > 0 ".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SET dak=$denposledny WHERE dak = '0000-00-00' ".
"";
//echo $dsqlt;
//exit;
$dsql = mysql_query("$dsqlt");


//10-fakt ume

if( $drupoh == 10 )
  {
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE dap < '$denprvy' AND dak < '$denprvy' ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE dap > '$denposledny' ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE dak < '$denprvy' ";
$dsql = mysql_query("$dsqlt");
  }



$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SET dni=(TO_DAYS(dak)-TO_DAYS(dap)) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dak='$denposledny' WHERE dak > '$denposledny' ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dap='$denprvy' WHERE dap < '$denprvy' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SET dnm=(TO_DAYS(dak)-TO_DAYS(dap)) ".
"";
$dsql = mysql_query("$dsqlt");


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");
    }

if( $medo == 1 OR $medo == 0 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SET ubyt=106 WHERE izba < 100 ";
$dsql = mysql_query("$dsqlt");
  }

if ( $podlaico == 0 )
  {

//group ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,1,ico,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),0 FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 GROUP BY ubyt,ico".
"";
$dsql = mysql_query("$dsqlt");


//group ubyt
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 9,0,0,0,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),0 FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 AND poi = 0 GROUP BY ubyt".
"";
$dsql = mysql_query("$dsqlt");

  }

if ( $podlaico == 1 )
  {

if( $ajceny == 1 )
  {
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcx".$kli_uzid." ADD sdph DECIMAL(10,2) DEFAULT 0 AFTER kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcx".$kli_uzid." ADD spolu DECIMAL(10,2) DEFAULT 0 AFTER kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcx".$kli_uzid." ADD cena DECIMAL(10,2) DEFAULT 0 AFTER kon";
$vysledek = mysql_query("$sql");

if( $medo >= 0 )
  {
if( $kli_vrok < 2012 OR ( $kli_vrok == 2012 AND $kli_vmes < 5 ) )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.58 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.75 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.33 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=7.50 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.67 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=25.42 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=4.58 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok > 2012 OR ( $kli_vrok == 2012 AND $kli_vmes >= 5 ) )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.42 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.58 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.17 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.33 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=7.50 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=26.25 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=5.42 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok > 2013 OR ( $kli_vrok == 2013 AND $kli_vmes >= 6 ) )
    {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.50 WHERE izba < 100 AND ico = 2147483647"; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok == 2014 )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.83 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.58 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.75 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=7.92 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=26.67 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=5.83 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.50 WHERE izba < 100 AND ico = 2147483647"; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok == 2015 )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=11.25 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.42 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.00 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.17 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.33 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=27.08 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=27.08 WHERE izba = 101 OR izba = 107 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.25 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.50 WHERE izba < 100 AND ico = 2147483647"; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok >= 2016 )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=11.67 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.84 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.42 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.59 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.75 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=27.50 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=27.50 WHERE izba = 101 OR izba = 107 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.67 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=6.67 WHERE izba < 100 AND ico = 2147483647"; $dsql = mysql_query("$dsqlt");
    }

if( $kli_vrok >= 2017 )
    {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=12.50 WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=11.67 WHERE dnm > 1 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=11.25 WHERE dnm > 6 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=10.42 WHERE dnm > 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=9.58 WHERE dnm >= $pocetdni "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=28.333 WHERE izba = 108 OR izba = 109 OR izba = 110 OR izba = 104 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=28.333 WHERE izba = 101 OR izba = 107 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=7.50 WHERE izba < 100 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=7.50 WHERE izba < 100 AND ico = 2147483647"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET cena=8.00 WHERE izba < 100 AND ico = 51413001 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET ico=51413002 WHERE izba > 100 AND ico = 51413001 "; $dsql = mysql_query("$dsqlt");
    }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET spolu=dnm*cena, sdph=(1+$fir_dph2)*spolu WHERE dnm > 0 "; $dsql = mysql_query("$dsqlt");

  }

//group ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,1,ico,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),0,0,SUM(spolu),SUM(sdph) FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 GROUP BY ico".
"";
$dsql = mysql_query("$dsqlt");

//group ubyt
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 9,0,0,ico,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),00,SUM(spolu),SUM(sdph) FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 AND poi = 0 GROUP BY ubyt,ico".
"";
$dsql = mysql_query("$dsqlt");


  }

if( $ajceny == 0 )
  {
//group ico
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,1,ico,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),0 FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 GROUP BY ico".
"";
$dsql = mysql_query("$dsqlt");

//group ubyt
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 9,0,0,ico,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',ubyt,0,oc,SUM(dni),0 FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 AND poi = 0 GROUP BY ubyt,ico".
"";
$dsql = mysql_query("$dsqlt");
  }


  }

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,0,0,0,SUM(dnm),0,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',999999,0,oc,SUM(dni),0 FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE pox = 1 AND poi = 0 GROUP BY kon".
"";
$dsql = mysql_query("$dsqlt");


    }
//koniec pracovneho suboru zjednotenie

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox != 1 AND pox != 9 AND pox != 10 AND poi != 1 ";
$dsql = mysql_query("$dsqlt");

if ( $podlaico == 1 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SET pox=1, poi=0, cpl=1 WHERE pox=9 ";
$dsql = mysql_query("$dsqlt");

  }


if ( $copern == 1 AND $drupoh = 10 AND $podlaico == 0 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ubythostia".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".oc=F$kli_vxcf"."_ubythostia.oc".
" WHERE ( pox = 1 OR pox = 10 OR pox = 9 ) ORDER BY ubyt,pox,ico,poi,izba,F$kli_vxcf"."_mzdprcx".$kli_uzid.".oc,dap  ";
  }

if ( $copern == 1 AND $drupoh = 10 AND $podlaico == 1 )
  {

$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ubythostia".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".oc=F$kli_vxcf"."_ubythostia.oc".
" WHERE ( pox = 1 OR pox = 10 OR pox = 9 ) ORDER BY pox,ico,poi,cpl,izba,F$kli_vxcf"."_mzdprcx".$kli_uzid.".oc,dap  ";
  }


//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$dat_sk=SkDatum($riadok->dat);
$dap_sk=SkDatum($riadok->dap);
$dak_sk=SkDatum($riadok->dak);
if( $dap_sk == '00.00.0000' ) $dap_sk="";
if( $dak_sk == '00.00.0000' ) $dak_sk="";
$dap1_sk=SkDatum($riadok->dap1);
$dak1_sk=SkDatum($riadok->dak1);
if( $dap1_sk == '00.00.0000' ) $dap1_sk="";
if( $dak1_sk == '00.00.0000' ) $dak1_sk="";

//hlavicka strany
if ( $j == 0 )
     {

//urob novu stranu len ked nieje posledna
if( $riadok->pox != 10 )
   {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;
$podnadpis="celý zoznam";
if( $ubytovani == 1 ) { $podnadpis="len aktuálne ubytovaní"; }
$pdf->SetFont('arial','',10);

if ( $copern == 1 AND $drupoh == 10 )  { $pdf->Cell(90,6,"Podklad pre vyúètovanie ubytovania za mesiac $kli_vume ","LTB",0,"L"); }


$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',10);

$ubytnazov="Hotel";
if( $medo >= 0 AND $riadok->ubyt == 106 ) $ubytnazov="U106";

if ( $podlaico == 0 )  { $pdf->Cell(0,6,"$ubytnazov","0",1,"L"); }
$pdf->Cell(10,4,"èíslo","1",0,"R");$pdf->Cell(60,4,"Priezvisko Meno Titl.","1",0,"L");

if( $ubytovani == 1 ) { $pdf->Cell(15,4,"izba","1",0,"R"); }

$pdf->Cell(80,4,"Odberate¾","1",0,"L");

if( $ajceny == 0 )
{
$pdf->Cell(12,4,"MNocí","1",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4,"Príchod-Odchod","1",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"CNocí","1",0,"R"); }
if( $ubytovani == 1 ) { $pdf->Cell(30,4,"Dod/Uhr","1",0,"L"); }
$pdf->Cell(0,4," ","1",1,"L");
}

if( $ajceny == 1 )
{
if( $ubytovani == 1 ) { $pdf->Cell(40,4,"Príchod-Odchod","1",0,"L"); }
$pdf->Cell(15,4,"P.Nocí","1",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(20,4,"Cena/noc","1",0,"R"); }
if( $ubytovani == 1 ) { $pdf->Cell(30,4,"Celkom bez DPH","1",0,"R"); }
$pdf->Cell(0,4," ","1",1,"L");
}

$new=0;

//urob novu stranu len ked nieje posledna
   }

//urob novu stranu len ked nieje posledna
if( $riadok->pox == 10 )
   {
$pdf->Cell(0,4," ","0",1,"L");
//urob novu stranu len ked nieje posledna
   }

     }
//koniec hlavicky j=0

$ico=$riadok->ico;
if( $ico == 51413002 ) { $ico=51413001; }

$sqldo2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $ico ";
$sqldok = mysql_query("$sqldo2");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ico=$riaddok->ico;
  $nai=$riaddok->nai;
  $mes=$riaddok->mes;
  }
//echo $sqldo2;
//exit;


if( $riadok->pox == 1 AND $riadok->poi == 0 AND $riadok->cpl == 0 )
{

$pdf->SetFont('arial','',10);

$pdf->Cell(10,4,"$riadok->oc","0",0,"R");$pdf->Cell(60,4,"$riadok->prie $riadok->meno $riadok->titl","0",0,"L");

if( $ubytovani == 1 ) { $pdf->Cell(15,4,"$riadok->izba","0",0,"R"); }
$pdf->SetFont('arial','',8);
$pdf->Cell(80,4,"$ico, $nai, $mes","0",0,"L");
$pdf->SetFont('arial','',10);

if( $ajceny == 0 )
  {
$pdf->Cell(12,4,"$riadok->dnm","0",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4,"$dap1_sk - $dak1_sk","0",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"$riadok->dni","0",0,"R"); }
if( $ubytovani == 1 ) { $pdf->Cell(30,4,"$riadok->dok/$riadok->uhr","0",0,"L"); }
$pdf->Cell(0,4," ","0",1,"L");
  }
if( $ajceny == 1 )
  {

if( $ubytovani == 1 ) { $pdf->Cell(40,4,"$dap1_sk - $dak1_sk","0",0,"L"); }
$pdf->Cell(15,4,"$riadok->dnm","0",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(20,4,"$riadok->cena","0",0,"R"); }
if( $ubytovani == 1 ) { $pdf->Cell(30,4,"$riadok->spolu","0",0,"R"); }
$pdf->Cell(0,4," ","0",1,"L");
  }
}

if( $riadok->pox == 1 AND $riadok->poi == 0 AND $riadok->cpl == 1 AND $ajceny == 0  )
{
$ubytnazov="Hotel";
if( $medo >= 0 AND $riadok->ubyt == 106 ) $ubytnazov="U106";

$pdf->Cell(70,4,"SPOLU $ubytnazov pre odberate¾a $riadok->ico, $riadok->nai","T",0,"L");

if( $ubytovani == 1 ) { $pdf->Cell(15,4," ","T",0,"R"); }

$pdf->Cell(80,4," ","T",0,"L");
$pdf->Cell(12,4,"$riadok->dnm","T",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4," ","T",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"$riadok->dni","T",0,"R"); }
$pdf->Cell(0,4," ","T",1,"L");

}


if( $riadok->pox == 1 AND $riadok->poi == 1 )
{

$pdf->Cell(70,4,"SPOLU odberate¾ $co, $nai","T",0,"L");

if( $ubytovani == 1 ) { $pdf->Cell(15,4," ","T",0,"R"); }


if( $ajceny == 0 )
  {
$pdf->Cell(80,4," ","T",0,"L");
$pdf->Cell(12,4,"$riadok->dnm","T",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4," ","T",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"$riadok->dni","T",0,"R"); }
$pdf->Cell(0,4," ","T",1,"L");
  }
if( $ajceny == 1 )
  {
$pdf->Cell(120,4," ","T",0,"L");
$pdf->Cell(15,4,"$riadok->dnm","T",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(20,4,"Spolu bez DPH","T",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(30,4,"$riadok->spolu","T",0,"R"); }
$pdf->Cell(0,4," ","0",1,"L");


  }

if( $podlaico == 1 ) { $j=-1; }
}


if( $riadok->pox == 9 AND $ubytovani == 1 AND $ajceny == 0 )
{
$ubytnazov="Hotel";
if( $medo >= 0 AND $riadok->ubyt == 106 ) $ubytnazov="U106";

$pdf->Cell(70,4,"SPOLU $ubytnazov","T",0,"L");

if( $ubytovani == 1 ) { $pdf->Cell(15,4," ","T",0,"R"); }

$pdf->Cell(80,4," ","T",0,"L");
$pdf->Cell(12,4,"$riadok->dnm","T",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4," ","T",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"$riadok->dni","T",0,"R"); }
$pdf->Cell(0,4," ","T",1,"L");
if( $podlaico == 0 ) { $j=-1; }
}


if( $riadok->pox == 10 AND $ubytovani == 1 AND $ajceny == 0 )
{

$pdf->Cell(70,4,"SPOLU všetko","1",0,"R");

if( $ubytovani == 1 ) { $pdf->Cell(15,4," ","1",0,"R"); }

$pdf->Cell(80,4," ","1",0,"L");
$pdf->Cell(12,4,"$riadok->dnm","1",0,"R");
if( $ubytovani == 1 ) { $pdf->Cell(43,4," ","1",0,"L"); }
if( $ubytovani == 1 ) { $pdf->Cell(12,4,"$riadok->dni","1",0,"R"); }
$pdf->Cell(0,4," ","1",1,"L");

}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 38 ) $j=0;

  }



$pdf->Output("$outfilex");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
