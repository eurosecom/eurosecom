<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
//echo $cislo_oc;
//exit;

$ubytovani = 1*$_REQUEST['ubytovani'];

$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];

//drupoh 1podla abecedy, 2podla osc, 3podla izby, 10-ume,20prume,30konume,40datum

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


if( $drupoh == 10 )
  {

$denprvy=SqlDatum($h_datp);
$denposledny=SqlDatum($h_datk);

$denprvysk=$h_datp;
$denposlednysk=$h_datk;

  }


//predch.mesiac
if( $copern == 1001 )
  {
$h_datp = $_REQUEST['h_datpprev'];
$h_datk = $_REQUEST['h_datkprev'];

$denprvy=SqlDatum($h_datp);
$denposledny=SqlDatum($h_datk);

$denprvysk=$h_datp;
$denposlednysk=$h_datk;
$copern=1;
  }
//koniec predch.mesiac

//next.mesiac
if( $copern == 2001 )
  {
$h_datp = $_REQUEST['h_datpnext'];
$h_datk = $_REQUEST['h_datkprev'];

$denprvy=SqlDatum($h_datp);
$denposledny=SqlDatum($h_datk);

$denprvysk=$h_datp;
$denposlednysk=$h_datk;
$copern=1;
  }
//koniec next.mesiac

//mesiac a datumy vybera podla nastaveneho datumu prichodu

$ume=$kli_vume;
$sqltt = "SELECT * FROM kalendar WHERE dat = '$denprvy' ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ume=$riaddok->ume;
  }

$pole = explode(".", $ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

//prvy a posledny den
$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denprvy=$riaddok->dat;
  $denprvysk=SkDatum($riaddok->dat);
  }


$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat DESC";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denposledny=$riaddok->dat;
  $denposlednysk=SkDatum($riaddok->dat);
  }

if( $drupoh >= 10 ) { $ubytovani=1; }

//echo $denprvy;
//echo $denposledny;
//exit;

//minuly a nasledujuci mesiac nastav
$umeprev=$ume-1;
if( $umeprev < 1 ) { $umeprev=$ume; }
$umenext=$ume+1;
if( $umenext > 13 ) { $umenext=$ume; }

$sqltt = "SELECT * FROM kalendar WHERE ume = $umeprev ORDER BY dat ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denprev=$riaddok->dat;
  $denprevsk=SkDatum($riaddok->dat);
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = $umenext ORDER BY dat ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dennext=$riaddok->dat;
  $dennextsk=SkDatum($riaddok->dat);
  }



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Piškvorky</title>
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
<td>EuroSecom  -  Piškvorky dochádzka

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/ubttlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/ubttlac$kli_uzid.pdf"); }

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
   dok          DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(10,0) DEFAULT 0,
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
   dno          DECIMAL(10,0) DEFAULT 0,
   kon          INT(7) DEFAULT 0,
   dpd          DECIMAL(3,0) DEFAULT 0,
   dkd          DECIMAL(3,0) DEFAULT 0,

   d01          DECIMAL(4,0) DEFAULT 0,
   d02          DECIMAL(4,0) DEFAULT 0,
   d03          DECIMAL(4,0) DEFAULT 0,
   d04          DECIMAL(4,0) DEFAULT 0,
   d05          DECIMAL(4,0) DEFAULT 0,
   d06          DECIMAL(4,0) DEFAULT 0,
   d07          DECIMAL(4,0) DEFAULT 0,
   d08          DECIMAL(4,0) DEFAULT 0,
   d09          DECIMAL(4,0) DEFAULT 0,
   d10          DECIMAL(4,0) DEFAULT 0,
   d11          DECIMAL(4,0) DEFAULT 0,
   d12          DECIMAL(4,0) DEFAULT 0,
   d13          DECIMAL(4,0) DEFAULT 0,
   d14          DECIMAL(4,0) DEFAULT 0,
   d15          DECIMAL(4,0) DEFAULT 0,
   d16          DECIMAL(4,0) DEFAULT 0,
   d17          DECIMAL(4,0) DEFAULT 0,
   d18          DECIMAL(4,0) DEFAULT 0,
   d19          DECIMAL(4,0) DEFAULT 0,
   d20          DECIMAL(4,0) DEFAULT 0,
   d21          DECIMAL(4,0) DEFAULT 0,
   d22          DECIMAL(4,0) DEFAULT 0,
   d23          DECIMAL(4,0) DEFAULT 0,
   d24          DECIMAL(4,0) DEFAULT 0,
   d25          DECIMAL(4,0) DEFAULT 0,
   d26          DECIMAL(4,0) DEFAULT 0,
   d27          DECIMAL(4,0) DEFAULT 0,
   d28          DECIMAL(4,0) DEFAULT 0,
   d29          DECIMAL(4,0) DEFAULT 0,
   d30          DECIMAL(4,0) DEFAULT 0,
   d31          DECIMAL(4,0) DEFAULT 0,

   dt01          VARCHAR(4) NOT NULL,
   dt02          VARCHAR(4) NOT NULL,
   dt03          VARCHAR(4) NOT NULL,
   dt04          VARCHAR(4) NOT NULL,
   dt05          VARCHAR(4) NOT NULL,
   dt06          VARCHAR(4) NOT NULL,
   dt07          VARCHAR(4) NOT NULL,
   dt08          VARCHAR(4) NOT NULL,
   dt09          VARCHAR(4) NOT NULL,
   dt10          VARCHAR(4) NOT NULL,
   dt11          VARCHAR(4) NOT NULL,
   dt12          VARCHAR(4) NOT NULL,
   dt13          VARCHAR(4) NOT NULL,
   dt14          VARCHAR(4) NOT NULL,
   dt15          VARCHAR(4) NOT NULL,
   dt16          VARCHAR(4) NOT NULL,
   dt17          VARCHAR(4) NOT NULL,
   dt18          VARCHAR(4) NOT NULL,
   dt19          VARCHAR(4) NOT NULL,
   dt20          VARCHAR(4) NOT NULL,
   dt21          VARCHAR(4) NOT NULL,
   dt22          VARCHAR(4) NOT NULL,
   dt23          VARCHAR(4) NOT NULL,
   dt24          VARCHAR(4) NOT NULL,
   dt25          VARCHAR(4) NOT NULL,
   dt26          VARCHAR(4) NOT NULL,
   dt27          VARCHAR(4) NOT NULL,
   dt28          VARCHAR(4) NOT NULL,
   dt29          VARCHAR(4) NOT NULL,
   dt30          VARCHAR(4) NOT NULL,
   dt31          VARCHAR(4) NOT NULL
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
    }


if ( $drupoh == 10 )
    {

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,cplxb,dmxa,hodxb,daod,daod,dado,daod,dado,0,oc,oc,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''  ".
" FROM F$kli_vxcf"."_mzddochadzka ".
" WHERE daod >= '$denprvy' AND dado <= '$denposledny' ";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dni=(TO_DAYS(dak)-TO_DAYS(dap))+1 WHERE ico > 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dno=(TO_DAYS(dak)-TO_DAYS(dap))+1 WHERE ico = 1";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dpd=DATE_FORMAT(dap,'%e') WHERE dap >= '$denprvy' ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET dkd=DATE_FORMAT(dak,'%e') WHERE dak <= '$denposledny' ";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d01=ico WHERE dpd <= 01 AND  dkd >= 01 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d02=ico WHERE dpd <= 02 AND  dkd >= 02 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d03=ico WHERE dpd <= 03 AND  dkd >= 03 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d04=ico WHERE dpd <= 04 AND  dkd >= 04 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d05=ico WHERE dpd <= 05 AND  dkd >= 05 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d06=ico WHERE dpd <= 06 AND  dkd >= 06 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d07=ico WHERE dpd <= 07 AND  dkd >= 07 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d08=ico WHERE dpd <= 08 AND  dkd >= 08 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d09=ico WHERE dpd <= 09 AND  dkd >= 09 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d10=ico WHERE dpd <= 10 AND  dkd >= 10 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d11=ico WHERE dpd <= 11 AND  dkd >= 11 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d12=ico WHERE dpd <= 12 AND  dkd >= 12 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d13=ico WHERE dpd <= 13 AND  dkd >= 13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d14=ico WHERE dpd <= 14 AND  dkd >= 14 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d15=ico WHERE dpd <= 15 AND  dkd >= 15 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d16=ico WHERE dpd <= 16 AND  dkd >= 16 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d17=ico WHERE dpd <= 17 AND  dkd >= 17 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d18=ico WHERE dpd <= 18 AND  dkd >= 18 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d19=ico WHERE dpd <= 19 AND  dkd >= 19 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d20=ico WHERE dpd <= 20 AND  dkd >= 20 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d21=ico WHERE dpd <= 21 AND  dkd >= 21 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d22=ico WHERE dpd <= 22 AND  dkd >= 22 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d23=ico WHERE dpd <= 23 AND  dkd >= 23 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d24=ico WHERE dpd <= 24 AND  dkd >= 24 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d25=ico WHERE dpd <= 25 AND  dkd >= 25 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d26=ico WHERE dpd <= 26 AND  dkd >= 26 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d27=ico WHERE dpd <= 27 AND  dkd >= 27 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d28=ico WHERE dpd <= 28 AND  dkd >= 28 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d29=ico WHERE dpd <= 29 AND  dkd >= 29 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d30=ico WHERE dpd <= 30 AND  dkd >= 30 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid." SET d31=ico WHERE dpd <= 31 AND  dkd >= 31 "; $dsql = mysql_query("$dsqlt");

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprc201x'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$sqlttxx = "CREATE TABLE F".$kli_vxcf."_mzdprc201x".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdprcx".$kli_uzid." WHERE ico = 201 ";
$sqlxx = mysql_query("$sqlttxx");
$vsql = 'DELETE FROM F'.$kli_vxcf.'_mzdprcx'.$kli_uzid." WHERE ico = 201 ";
$vytvor = mysql_query("$vsql");

$generovacie=0;
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $generovacie=1; }
if( $_SERVER['SERVER_NAME'] == "www.eurolark.sk" ) { $generovacie=1; }

$mzdkun="mzdkun";
if( $generovacie == 1 ) 
{
$mzdkun="mzdkunx".$kli_uzid;

$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "CREATE TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume AND stz = 1 AND pom = 1 ";
$sqlxx = mysql_query("$sqlttxx");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,99999999,0,'','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',0,oc,oc,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''  ".
" FROM F$kli_vxcf"."_$mzdkun ".
" WHERE oc > 0  ".
"";
$dsql = mysql_query("$dsqlt");

//exit;


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" SELECT 10,0,dok,0,uhr,dat,dap,dak,dap1,dak1,0,izba,oc,SUM(dni),SUM(dno),0,0,0, ".
" SUM(d01),SUM(d02),SUM(d03),SUM(d04),SUM(d05),SUM(d06),SUM(d07),SUM(d08),SUM(d09),SUM(d10), ".
" SUM(d11),SUM(d12),SUM(d13),SUM(d14),SUM(d15),SUM(d16),SUM(d17),SUM(d18),SUM(d19),SUM(d20), ".
" SUM(d21),SUM(d22),SUM(d23),SUM(d24),SUM(d25),SUM(d26),SUM(d27),SUM(d28),SUM(d29),SUM(d30),SUM(d31), ".
" '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''  ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE dok >= 0 GROUP BY izba".
"";
$dsql = mysql_query("$dsqlt");

    }

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");


$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox != 1 AND pox != 10 ";
$dsql = mysql_query("$dsqlt");

$s1=0; $s2=0; $s3=0; $s4=0; $s5=0; $s6=0; $s7=0; $s8=0; $s9=0; $s10=0; $s11=0; $s12=0; $s13=0; $s14=0; $s15=0; $s16=0; $s17=0; $s18=0; $s19=0; 
$s20=0; $s21=0; $s22=0; $s23=0; $s24=0; $s25=0; $s26=0; $s27=0; $s28=0; $s29=0; $s30=0; $s31=0;
$n1=0; $n2=0; $n3=0; $n4=0; $n5=0; $n6=0; $n7=0; $n8=0; $n9=0; $n10=0; $n11=0; $n12=0; $n13=0; $n14=0; $n15=0; $n16=0; $n17=0; $n18=0; $n19=0; 
$n20=0; $n21=0; $n22=0; $n23=0; $n24=0; $n25=0; $n26=0; $n27=0; $n28=0; $n29=0; $n30=0; $n31=0;

$dnn1=""; $dnn2=""; $dnn3=""; $dnn4=""; $dnn5=""; $dnn6=""; $dnn7=""; $dnn8=""; $dnn9=""; $dnn10=""; 
$dnn11=""; $dnn12=""; $dnn13=""; $dnn14=""; $dnn15=""; $dnn16=""; $dnn17=""; $dnn18=""; $dnn19=""; 
$dnn20=""; $dnn21=""; $dnn22=""; $dnn23=""; $dnn24=""; $dnn25=""; $dnn26=""; $dnn27=""; $dnn28=""; $dnn29=""; $dnn30=""; $dnn31="";

$dnr1=0; $dnr2=0; $dnr3=0; $dnr4=0; $dnr5=0; $dnr6=0; $dnr7=0; $dnr8=0; $dnr9=0; $dnr10=0; 
$dnr11=0; $dnr12=0; $dnr13=0; $dnr14=0; $dnr15=0; $dnr16=0; $dnr17=0; $dnr18=0; $dnr19=0; 
$dnr20=0; $dnr21=0; $dnr22=0; $dnr23=0; $dnr24=0; $dnr25=0; $dnr26=0; $dnr27=0; $dnr28=0; $dnr29=0; $dnr30=0; $dnr31=0;


$i=1;
while( $i <= 31 )
     {
$datumx=$kli_vrok."-".$kli_vmes."-".$i;

$sqlttt = "SELECT * FROM kalendar WHERE dat = '$datumx' ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {

  $riaddok=mysql_fetch_object($sqldok);
  if( $riaddok->akyden == 6 AND $i == 1 ) { $s1=1; $dnn1="So"; $dnr1=1; }
  if( $riaddok->akyden == 7 AND $i == 1 ) { $n1=1; $dnn1="Ne"; $dnr1=1; }
  if( $riaddok->akyden == 6 AND $i == 2 ) { $s2=1; $dnn2="So"; $dnr2=1; }
  if( $riaddok->akyden == 7 AND $i == 2 ) { $n2=1; $dnn2="Ne"; $dnr2=1; }
  if( $riaddok->akyden == 6 AND $i == 3 ) { $s3=1; $dnn3="So"; $dnr3=1; }
  if( $riaddok->akyden == 7 AND $i == 3 ) { $n3=1; $dnn3="Ne"; $dnr3=1; }
  if( $riaddok->akyden == 6 AND $i == 4 ) { $s4=1; $dnn4="So"; $dnr4=1; }
  if( $riaddok->akyden == 7 AND $i == 4 ) { $n4=1; $dnn4="Ne"; $dnr4=1; }
  if( $riaddok->akyden == 6 AND $i == 5 ) { $s5=1; $dnn5="So"; $dnr5=1; }
  if( $riaddok->akyden == 7 AND $i == 5 ) { $n5=1; $dnn5="Ne"; $dnr5=1; }
  if( $riaddok->akyden == 6 AND $i == 6 ) { $s6=1; $dnn6="So"; $dnr6=1; }
  if( $riaddok->akyden == 7 AND $i == 6 ) { $n6=1; $dnn6="Ne"; $dnr6=1; }
  if( $riaddok->akyden == 6 AND $i == 7 ) { $s7=1; $dnn7="So"; $dnr7=1; }
  if( $riaddok->akyden == 7 AND $i == 7 ) { $n7=1; $dnn7="Ne"; $dnr7=1; }
  if( $riaddok->akyden == 6 AND $i == 8 ) { $s8=1; $dnn8="So"; $dnr8=1; }
  if( $riaddok->akyden == 7 AND $i == 8 ) { $n8=1; $dnn8="Ne"; $dnr8=1; }
  if( $riaddok->akyden == 6 AND $i == 9 ) { $s9=1; $dnn9="So"; $dnr9=1; }
  if( $riaddok->akyden == 7 AND $i == 9 ) { $n9=1; $dnn9="Ne"; $dnr9=1; }
  if( $riaddok->akyden == 6 AND $i == 10 ) { $s10=1; $dnn10="So"; $dnr10=1; }
  if( $riaddok->akyden == 7 AND $i == 10 ) { $n10=1; $dnn10="Ne"; $dnr10=1; }

  if( $riaddok->akyden == 6 AND $i == 11 ) { $s11=1; $dnn11="So"; $dnr11=1; }
  if( $riaddok->akyden == 7 AND $i == 11 ) { $n11=1; $dnn11="Ne"; $dnr11=1; }
  if( $riaddok->akyden == 6 AND $i == 12 ) { $s12=1; $dnn12="So"; $dnr12=1; }
  if( $riaddok->akyden == 7 AND $i == 12 ) { $n12=1; $dnn12="Ne"; $dnr12=1; }
  if( $riaddok->akyden == 6 AND $i == 13 ) { $s13=1; $dnn13="So"; $dnr13=1; }
  if( $riaddok->akyden == 7 AND $i == 13 ) { $n13=1; $dnn13="Ne"; $dnr13=1; }
  if( $riaddok->akyden == 6 AND $i == 14 ) { $s14=1; $dnn14="So"; $dnr14=1; }
  if( $riaddok->akyden == 7 AND $i == 14 ) { $n14=1; $dnn14="Ne"; $dnr14=1; }
  if( $riaddok->akyden == 6 AND $i == 15 ) { $s15=1; $dnn15="So"; $dnr15=1; }
  if( $riaddok->akyden == 7 AND $i == 15 ) { $n15=1; $dnn15="Ne"; $dnr15=1; }
  if( $riaddok->akyden == 6 AND $i == 16 ) { $s16=1; $dnn16="So"; $dnr16=1; }
  if( $riaddok->akyden == 7 AND $i == 16 ) { $n16=1; $dnn61="Ne"; $dnr16=1; }
  if( $riaddok->akyden == 6 AND $i == 17 ) { $s17=1; $dnn17="So"; $dnr17=1; }
  if( $riaddok->akyden == 7 AND $i == 17 ) { $n17=1; $dnn17="Ne"; $dnr17=1; }
  if( $riaddok->akyden == 6 AND $i == 18 ) { $s18=1; $dnn18="So"; $dnr18=1; }
  if( $riaddok->akyden == 7 AND $i == 18 ) { $n18=1; $dnn18="Ne"; $dnr18=1; }
  if( $riaddok->akyden == 6 AND $i == 19 ) { $s19=1; $dnn19="So"; $dnr19=1; }
  if( $riaddok->akyden == 7 AND $i == 19 ) { $n19=1; $dnn19="Ne"; $dnr19=1; }
  if( $riaddok->akyden == 6 AND $i == 20 ) { $s20=1; $dnn20="So"; $dnr20=1; }
  if( $riaddok->akyden == 7 AND $i == 20 ) { $n20=1; $dnn20="Ne"; $dnr20=1; }

  if( $riaddok->akyden == 6 AND $i == 21 ) { $s21=1; $dnn21="So"; $dnr21=1; }
  if( $riaddok->akyden == 7 AND $i == 21 ) { $n21=1; $dnn21="Ne"; $dnr21=1; }
  if( $riaddok->akyden == 6 AND $i == 22 ) { $s22=1; $dnn22="So"; $dnr22=1; }
  if( $riaddok->akyden == 7 AND $i == 22 ) { $n22=1; $dnn22="Ne"; $dnr22=1; }
  if( $riaddok->akyden == 6 AND $i == 23 ) { $s23=1; $dnn23="So"; $dnr23=1; }
  if( $riaddok->akyden == 7 AND $i == 23 ) { $n23=1; $dnn23="Ne"; $dnr23=1; }
  if( $riaddok->akyden == 6 AND $i == 24 ) { $s24=1; $dnn24="So"; $dnr24=1; }
  if( $riaddok->akyden == 7 AND $i == 24 ) { $n24=1; $dnn24="Ne"; $dnr24=1; }
  if( $riaddok->akyden == 6 AND $i == 25 ) { $s25=1; $dnn25="So"; $dnr25=1; }
  if( $riaddok->akyden == 7 AND $i == 25 ) { $n25=1; $dnn25="Ne"; $dnr25=1; }
  if( $riaddok->akyden == 6 AND $i == 26 ) { $s26=1; $dnn26="So"; $dnr26=1; }
  if( $riaddok->akyden == 7 AND $i == 26 ) { $n26=1; $dnn26="Ne"; $dnr26=1; }
  if( $riaddok->akyden == 6 AND $i == 27 ) { $s27=1; $dnn27="So"; $dnr27=1; }
  if( $riaddok->akyden == 7 AND $i == 27 ) { $n27=1; $dnn27="Ne"; $dnr27=1; }
  if( $riaddok->akyden == 6 AND $i == 28 ) { $s28=1; $dnn28="So"; $dnr28=1; }
  if( $riaddok->akyden == 7 AND $i == 28 ) { $n28=1; $dnn28="Ne"; $dnr28=1; }
  if( $riaddok->akyden == 6 AND $i == 29 ) { $s29=1; $dnn29="So"; $dnr29=1; }
  if( $riaddok->akyden == 7 AND $i == 29 ) { $n29=1; $dnn29="Ne"; $dnr29=1; }
  if( $riaddok->akyden == 6 AND $i == 30 ) { $s30=1; $dnn30="So"; $dnr30=1; }
  if( $riaddok->akyden == 7 AND $i == 30 ) { $n30=1; $dnn30="Ne"; $dnr30=1; }
  if( $riaddok->akyden == 6 AND $i == 31 ) { $s31=1; $dnn31="So"; $dnr31=1; }
  if( $riaddok->akyden == 7 AND $i == 31 ) { $n31=1; $dnn31="Ne"; $dnr31=1; }

  }

$i=$i+1;
     }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=1*$riaddok->uva_hod;
  }

$ix=1;
  while ($ix <= 31 )
  {
$ix2=$ix;
if( $ix < 10 ) { $ix2="0".$ix; }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2=''  WHERE d$ix2 = 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='$uva_hod'  WHERE d$ix2 = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='D' WHERE d$ix2 = 506 ";
$oznac = mysql_query("$sqtoz"); 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='N' WHERE d$ix2 = 801 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='O' WHERE d$ix2 = 802 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='M' WHERE d$ix2 = 809 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='V' WHERE d$ix2 = 502 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='A' WHERE d$ix2 = 503 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='S' WHERE d$ix2 = 510 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='L' WHERE d$ix2 = 518 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt$ix2='I' WHERE d$ix2 = 520 ";
$oznac = mysql_query("$sqtoz");
$ix=$ix+1;
  }

$kli_vmesx=$kli_vmes;
if( $kli_vmes < 10 ) { $kli_vmesx="0".$kli_vmes; }

$klivrm00=$kli_vrok."-".$kli_vmesx."-00";
$klivrm01=$kli_vrok."-".$kli_vmesx."-01";
$klivrm02=$kli_vrok."-".$kli_vmesx."-02";
$klivrm03=$kli_vrok."-".$kli_vmesx."-03";
$klivrm04=$kli_vrok."-".$kli_vmesx."-04";
$klivrm05=$kli_vrok."-".$kli_vmesx."-05";
$klivrm06=$kli_vrok."-".$kli_vmesx."-06";
$klivrm07=$kli_vrok."-".$kli_vmesx."-07";
$klivrm08=$kli_vrok."-".$kli_vmesx."-08";
$klivrm09=$kli_vrok."-".$kli_vmesx."-09";

$klivrm10=$kli_vrok."-".$kli_vmesx."-10";
$klivrm11=$kli_vrok."-".$kli_vmesx."-11";
$klivrm12=$kli_vrok."-".$kli_vmesx."-12";
$klivrm13=$kli_vrok."-".$kli_vmesx."-13";
$klivrm14=$kli_vrok."-".$kli_vmesx."-14";
$klivrm15=$kli_vrok."-".$kli_vmesx."-15";
$klivrm16=$kli_vrok."-".$kli_vmesx."-16";
$klivrm17=$kli_vrok."-".$kli_vmesx."-17";
$klivrm18=$kli_vrok."-".$kli_vmesx."-18";
$klivrm19=$kli_vrok."-".$kli_vmesx."-19";

$klivrm20=$kli_vrok."-".$kli_vmesx."-20";
$klivrm21=$kli_vrok."-".$kli_vmesx."-21";
$klivrm22=$kli_vrok."-".$kli_vmesx."-22";
$klivrm23=$kli_vrok."-".$kli_vmesx."-23";
$klivrm24=$kli_vrok."-".$kli_vmesx."-24";
$klivrm25=$kli_vrok."-".$kli_vmesx."-25";
$klivrm26=$kli_vrok."-".$kli_vmesx."-26";
$klivrm27=$kli_vrok."-".$kli_vmesx."-27";
$klivrm28=$kli_vrok."-".$kli_vmesx."-28";
$klivrm29=$kli_vrok."-".$kli_vmesx."-29";

$klivrm30=$kli_vrok."-".$kli_vmesx."-30";
$klivrm31=$kli_vrok."-".$kli_vmesx."-31";
//echo $klivrm08;
//exit;

//tuto pripocitaj jednu hodinu  dm201 z _mzdprc201x do dt1-31
$sqltto = "SELECT * FROM F$kli_vxcf"."_mzdprc201x$kli_uzid WHERE ico = 201 ORDER BY oc,dat ";
$sqlo = mysql_query("$sqltto");
$polo = mysql_num_rows($sqlo);
$io=0;
  while ( $io < $polo )
  {

  if (@$zaznam=mysql_data_seek($sqlo,$io))
{
$hlavickao=mysql_fetch_object($sqlo);

if( $hlavickao->dat == "$klivrm01" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt01=dt01+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm02" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt02=dt02+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm03" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt03=dt03+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm04" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt04=dt04+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm05" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt05=dt05+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm06" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt06=dt06+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm07" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt07=dt07+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm08" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt08=dt08+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm09" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt09=dt09+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm10" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt10=dt10+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm11" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt11=dt11+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm12" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt12=dt12+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm13" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt13=dt13+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm14" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt14=dt14+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }

if( $hlavickao->dat == "$klivrm15" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt15=dt15+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm16" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt16=dt16+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm17" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt17=dt17+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm18" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt18=dt18+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm19" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt19=dt19+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm20" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt20=dt20+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm21" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt21=dt21+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm22" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt22=dt22+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm23" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt23=dt23+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm24" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt24=dt24+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm25" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt25=dt25+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm26" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt26=dt26+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm27" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt27=dt27+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm28" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt28=dt28+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm29" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt29=dt29+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm30" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt30=dt30+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }
if( $hlavickao->dat == "$klivrm31" )
   {
$uprtxt = "UPDATE F$kli_vxcf"."_mzdprcx$kli_uzid SET dt31=dt31+$hlavickao->uhr WHERE pox = 10 AND F$kli_vxcf"."_mzdprcx$kli_uzid.oc = $hlavickao->oc "; 
$upravene = mysql_query("$uprtxt");
   }

}
$io=$io+1;

  }
//koniec pripocitaj hodiny dm201
//exit;

if ( $copern == 1 AND $drupoh == 10 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" WHERE pox = 10 ORDER BY izba,pox,dap,dak,dok ";
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

$netlacobjadod=1;

//hlavicka strany
if ( $j == 0 )
     {

//urob novu stranu len ked nieje posledna
if( $riadok->pox == 10 )
   {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;
$podnadpis="celý zoznam";
$pdf->SetFont('arial','',10);

$pdf->Cell(150,5,"Evidencia mesaènej dochádzky od $denprvysk do $denposlednysk ","0",0,"L"); 

$odkaz="../mzdy/dochadzkames_pdf.php?copern=1001&drupoh=10&page=1&subor=0&h_datpprev=".$denprevsk."&h_datk=";
$odkazn="../mzdy/dochadzkames_pdf.php?copern=2001&drupoh=10&page=1&subor=0&h_datpnext=".$dennextsk."&h_datk=";

if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/mzdy/dochadzkames_pdf.php?copern=1001&drupoh=10&page=1&subor=0&h_datpprev=".$denprevsk."&h_datk=";
$odkazn=$_SERVER['SERVER_NAME']."/mzdy/dochadzkames_pdf.php?copern=2001&drupoh=10&page=1&subor=0&h_datpnext=".$dennextsk."&h_datk=";
                               }



$pdf->Cell(0,5," ","0",1,"L"); 
$pdf->SetFont('arial','',7);
$pdf->Cell(50,3," ","0",0,"L");
if( $s1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn1","$dnr1",0,"C"); if( $n1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn2","$dnr2",0,"C"); if( $n2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn3","$dnr3",0,"C"); if( $n3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn4","$dnr4",0,"C"); if( $n4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn5","$dnr5",0,"C"); if( $n5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn6","$dnr6",0,"C"); if( $n6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn7","$dnr7",0,"C"); if( $n7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn8","$dnr8",0,"C"); if( $n8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn9","$dnr9",0,"C"); if( $n9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn10","$dnr10",0,"C"); if( $n10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn11","$dnr11",0,"C"); if( $n11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn12","$dnr12",0,"C"); if( $n12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn13","$dnr13",0,"C"); if( $n13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn14","$dnr14",0,"C"); if( $n14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn15","$dnr15",0,"C"); if( $n15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn16","$dnr16",0,"C"); if( $n16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn17","$dnr17",0,"C"); if( $n17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn18","$dnr18",0,"C"); if( $n18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn19","$dnr19",0,"C"); if( $n19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn20","$dnr20",0,"C"); if( $n20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn21","$dnr21",0,"C"); if( $n21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn22","$dnr22",0,"C"); if( $n22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn23","$dnr23",0,"C"); if( $n23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn24","$dnr24",0,"C"); if( $n24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn25","$dnr25",0,"C"); if( $n25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn26","$dnr26",0,"C"); if( $n26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn27","$dnr27",0,"C"); if( $n27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn28","$dnr28",0,"C"); if( $n28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn29","$dnr29",0,"C"); if( $n29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn30","$dnr30",0,"C"); if( $n30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,3,"$dnn31","$dnr31",0,"C"); if( $n31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }

$pdf->Cell(0,3,"  ","0",1,"R");

$pdf->SetFont('arial','',10);


if( $netlacobjadod == 0 )
     {
$pdf->Cell(15,4,"izba","1",0,"R");
$pdf->Cell(28,4,"Príchod","1",0,"L");$pdf->Cell(28,4,"Odchod","1",0,"L"); 
$pdf->Cell(10,4,"Nocí","1",0,"R");  
$pdf->Cell(60,4,"Priezvisko Meno Titl. èíslo","1",0,"L");
$pdf->Cell(30,4,"è.Obj/Dod","1",0,"R");
$pdf->Cell(0,4,"Firma","1",1,"L");
     }

$pdf->SetFont('arial','',7);
$pdf->Cell(50,5,"Zamestnanec ","1",0,"L");


$dnx1="0";

if( $s1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 1.","1",0,"R"); if( $n1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 2.","1",0,"R"); if( $n2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 3.","1",0,"R"); if( $n3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 4.","1",0,"R"); if( $n4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 5.","1",0,"R"); if( $n5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 6.","1",0,"R"); if( $n6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 7.","1",0,"R"); if( $n7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 8.","1",0,"R"); if( $n8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5," 9.","1",0,"R"); if( $n9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"10.","1",0,"R"); if( $n10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"11.","1",0,"R"); if( $n11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"12.","1",0,"R"); if( $n12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"13.","1",0,"R"); if( $n13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"14.","1",0,"R"); if( $n14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"15.","1",0,"R"); if( $n15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"16.","1",0,"R"); if( $n16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"17.","1",0,"R"); if( $n17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"18.","1",0,"R"); if( $n18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"19.","1",0,"R"); if( $n19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"20.","1",0,"R"); if( $n20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"21.","1",0,"R"); if( $n21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"22.","1",0,"R"); if( $n22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"23.","1",0,"R"); if( $n23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"24.","1",0,"R"); if( $n24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"25.","1",0,"R"); if( $n25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"26.","1",0,"R"); if( $n26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"27.","1",0,"R"); if( $n27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"28.","1",0,"R"); if( $n28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }

if( $pocetdni > 28 ) 
  {
if( $s29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"29.","1",0,"R"); if( $n29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }
if( $pocetdni > 29 ) 
  {
if( $s30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"30.","1",0,"R"); if( $n30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }
if( $pocetdni > 30 ) 
  {
if( $s31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"31.","1",0,"R"); if( $n31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }
$pdf->Cell(11,5,"Neodp.","1",0,"R");$pdf->Cell(11,5,"Odprac.","1",1,"R");

$pdf->SetFont('arial','',10);

$new=0;

//urob novu stranu len ked nieje posledna
   }

//urob novu stranu len ked nieje posledna
if( $riadok->pox != 10 )
   {
$pdf->Cell(0,4," ","0",1,"L");
//urob novu stranu len ked nieje posledna
   }

     }
//koniec hlavicky j=0





if( $riadok->pox == 10 )
{


$pdf->SetFont('arial','',8);

$pdf->Cell(0,1," ","0",1,"L");

$meno=""; $prie=""; $titl="";
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc = $riadok->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;
  $prie=$riaddok->prie;
  $titl=$riaddok->titl;
  }

$pdf->Cell(10,5,"$riadok->oc","1",0,"R");$pdf->Cell(40,5,"$prie $meno $titl ","1",0,"L");

$pdf->SetFont('arial','',10);
if( $s1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt01","1",0,"C"); if( $n1 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt02","1",0,"C"); if( $n2 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt03","1",0,"C"); if( $n3 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt04","1",0,"C"); if( $n4 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt05","1",0,"C"); if( $n5 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt06","1",0,"C"); if( $n6 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt07","1",0,"C"); if( $n7 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt08","1",0,"C"); if( $n8 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt09","1",0,"C"); if( $n9 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt10","1",0,"C"); if( $n10 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt11","1",0,"C"); if( $n11 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt12","1",0,"C"); if( $n12 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt13","1",0,"C"); if( $n13 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt14","1",0,"C"); if( $n14 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt15","1",0,"C"); if( $n15 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt16","1",0,"C"); if( $n16 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt17","1",0,"C"); if( $n17 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt18","1",0,"C"); if( $n18 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt19","1",0,"C"); if( $n19 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt20","1",0,"C"); if( $n20 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt21","1",0,"C"); if( $n21 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt22","1",0,"C"); if( $n22 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt23","1",0,"C"); if( $n23 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt24","1",0,"C"); if( $n24 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt25","1",0,"C"); if( $n25 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt26","1",0,"C"); if( $n26 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt27","1",0,"C"); if( $n27 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $s28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt28","1",0,"C"); if( $n28 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
if( $pocetdni > 28 ) 
  {
if( $s29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt29","1",0,"C"); if( $n29 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }
if( $pocetdni > 29 ) 
  {
if( $s30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt30","1",0,"C"); if( $n30 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }
if( $pocetdni > 30 ) 
  {
if( $s31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); } $pdf->Cell(6,5,"$riadok->dt31","1",0,"C"); if( $n31 == 1 ) { $pdf->Cell(1,5," ","0",0,"R"); }
  }

$neodpr=1*$riadok->dni; if( $neodpr == 0 ) { $neodpr=""; }
$odprac=1*$riadok->dno; if( $odprac == 0 ) { $odprac=""; }
$pdf->Cell(11,5,"$neodpr","1",0,"R");$pdf->Cell(11,5,"$odprac","1",1,"R");
}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 25 ) $j=0;

  }
$pdf->SetFont('arial','',7);
$pdf->Cell(10,1," ","0",1,"R");$pdf->Cell(0,5,"D=dovolenka, S=sviatok, L-lekár, O=ošetrovné, A=absencia, V=neplatené vo¾no, M=materská, N=nemoc, I=iné","0",1,"L");

$pdf->Output("../tmp/ubttlac.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/ubttlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
