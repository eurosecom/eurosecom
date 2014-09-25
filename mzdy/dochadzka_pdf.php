<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 100;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_oc = 1*$_REQUEST['cislo_oc'];



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

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_dochprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dochprc'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE ume=$kli_vume ";
$vytvor = mysql_query("$vsql");


$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD datnz TIMESTAMP(14) not null AFTER datn";
$vysledek = mysql_query("$sql");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dochádzka PDF</title>
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
<td>EuroSecom  -  Dochádzka PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/doch$kli_uzid.pdf")) { $soubor = unlink("../tmp/doch$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

if ( $copern == 10 )
  {
//sumar za oc pred a za
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET dmxb=15 ";
$dsql = mysql_query("$dsqlt");

//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  

//sumar za oc pred 5 a za 19
$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,19,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,cplxb,0 ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,10,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,cplxb,0 ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_dochprc$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc != 0 AND ume = $kli_vume ".
" ORDER BY F$kli_vxcf"."_dochprc$kli_uzid.oc,dmxb,daod,cplxb ";

//echo $sqltt;
//exit;
  }

if ( $copern == 20 )
  {
//sumar za dmxa pred a za
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET dmxb=25 ";
$dsql = mysql_query("$dsqlt");

//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  

//sumar za oc pred 5 a za 19
$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,29,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,cplxb,0 ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY dmxa".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,20,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,cplxb,0 ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY dmxa".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_dochprc$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE ume = $kli_vume ".
" ORDER BY dmxa,dmxb,F$kli_vxcf"."_dochprc$kli_uzid.oc,daod,cplxb ";
  }

if ( $copern == 30 )
  {
//sumar za oc pred a za
$dsqlt = "DELETE FROM F$kli_vxcf"."_dochprc$kli_uzid "." WHERE oc != $cislo_oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET dmxb=35 ";
$dsql = mysql_query("$dsqlt");

//zaokruhli prichod,odchod
$zaokruhlit=1; $druhzaok="celepolky";

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=datn WHERE dmxb=35 ";
$dsql = mysql_query("$dsqlt");
if( $zaokruhlit == 1 )
  {
if( $druhzaok == "celepolky" )
    {
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET xtxt=SUBSTRING(datn,15,2) WHERE dmxb=35 AND ( dmxa = 1 OR dmxa = 2 )";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:29:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '01' OR xtxt = '31' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:28:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '02' OR xtxt = '32' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:27:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '03' OR xtxt = '33' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:26:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '04' OR xtxt = '34' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:25:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '05' OR xtxt = '35' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:24:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '06' OR xtxt = '36' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:23:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '07' OR xtxt = '37' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:22:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '08' OR xtxt = '38' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:21:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '09' OR xtxt = '39' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:20:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '10' OR xtxt = '40' ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:19:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '11' OR xtxt = '41' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:18:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '12' OR xtxt = '42' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:17:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '13' OR xtxt = '43' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:16:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '14' OR xtxt = '44' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:15:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '15' OR xtxt = '45' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:14:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '16' OR xtxt = '46' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:13:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '17' OR xtxt = '47' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:12:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '18' OR xtxt = '48' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:11:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '19' OR xtxt = '49' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:10:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '20' OR xtxt = '50' ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:09:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '21' OR xtxt = '51' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:08:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '22' OR xtxt = '52' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:07:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '23' OR xtxt = '53' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:06:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '24' OR xtxt = '54' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:05:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '25' OR xtxt = '55' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:04:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '26' OR xtxt = '56' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:03:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '27' OR xtxt = '57' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:02:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '28' OR xtxt = '58' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=ADDTIME(datn,'00:01:00') WHERE dmxb=35 AND dmxa = 1 AND ( xtxt = '29' OR xtxt = '59' ) ";
$dsql = mysql_query("$dsqlt");

//odchod
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:01:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '01' OR xtxt = '31' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:02:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '02' OR xtxt = '32' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:03:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '03' OR xtxt = '33' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:04:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '04' OR xtxt = '34' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:05:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '05' OR xtxt = '35' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:06:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '06' OR xtxt = '36' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:07:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '07' OR xtxt = '37' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:08:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '08' OR xtxt = '38' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:09:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '09' OR xtxt = '39' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:10:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '10' OR xtxt = '40' ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:11:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '11' OR xtxt = '41' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:12:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '12' OR xtxt = '42' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:13:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '13' OR xtxt = '43' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:14:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '14' OR xtxt = '44' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:15:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '15' OR xtxt = '45' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:16:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '16' OR xtxt = '46' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:17:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '17' OR xtxt = '47' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:18:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '18' OR xtxt = '48' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:19:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '19' OR xtxt = '49' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:20:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '20' OR xtxt = '50' ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:21:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '21' OR xtxt = '51' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:22:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '22' OR xtxt = '52' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:23:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '23' OR xtxt = '53' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:24:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '24' OR xtxt = '54' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:25:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '25' OR xtxt = '55' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:26:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '26' OR xtxt = '56' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:27:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '27' OR xtxt = '57' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:28:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '28' OR xtxt = '58' ) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=SUBTIME(datn,'00:29:00') WHERE dmxb=35 AND dmxa = 2 AND ( xtxt = '29' OR xtxt = '59' ) ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET datnz=INSERT(datnz,18,2,'00') WHERE dmxb=35 AND ( dmxa = 1 OR dmxa = 2 )";
$dsql = mysql_query("$dsqlt");
//exit;
    }
  }
//koniec zaokruhlenia casu

//vypocitaj kolko odrobil od prichodu po odchod
$sqlttx = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc = $cislo_oc AND ume = $kli_vume AND ( dmxa = 1 OR dmxa = 2 ) ".
" ORDER BY oc,daod,datn,cplxb ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
$ix=0;           
$prichod=0;
  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);

if( $riadokx->dmxa == 1 ) { $prichod=1; $kedyprichod=$riadokx->datnz; }
if( $riadokx->dmxa == 2 AND $prichod == 1 )  
    { 
$prichod=0; 

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET polprc=UNIX_TIMESTAMP(datnz)-UNIX_TIMESTAMP('$kedyprichod') WHERE cplxb = $riadokx->cplxb "; 
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
    }

}
$ix = $ix + 1;
  }

//exit;

$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD hodinyd DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD hodinyz DECIMAL(10,0) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD minutyd DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD minutyz DECIMAL(10,0) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET hodinyd=polprc/3600 WHERE dmxb = 35 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET hodinyz=FLOOR(hodinyd) WHERE dmxb = 35 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET minutyd=(polprc-(hodinyz*3600))/60 WHERE dmxb = 35 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET minutyz=FLOOR(minutyd) WHERE dmxb = 35 "; 
$dsql = mysql_query("$dsqlt");


$sqlfir = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden < 6 AND svt = 0 ";
$tovk = mysql_query("$sqlfir");
$pracdni = 1*mysql_num_rows($tovk);


//exit;

//sumar za oc pred 5 a za 19
$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,39,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,0,0,0,SUM(hodinyz),0,SUM(minutyz) ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dochprc$kli_uzid "." SELECT".
" ume,oc,dmxa,30,daod,dado,SUM(dnixa),dnixb,hodxa,hodxb,xtxt,datm,datn,datnz,0,0,0,SUM(hodinyz),0,SUM(minutyz) ".
" FROM F$kli_vxcf"."_dochprc$kli_uzid".
" WHERE ume = $kli_vume".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_dochprc$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc = $cislo_oc AND ume = $kli_vume ".
" ORDER BY F$kli_vxcf"."_dochprc$kli_uzid.oc,dmxb,daod,cplxb ";
  }


//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
if ( $copern == 10 )  { $pdf->Cell(90,6,"Dochádzka $kli_vume - pod¾a zamestnancov ","LTB",0,"L"); }
if ( $copern == 20 )  { $pdf->Cell(90,6,"Dochádzka $kli_vume - pod¾a položiek","LTB",0,"L"); }
if ( $copern == 30 )  { $pdf->Cell(90,6,"Dochádzka $kli_vume zamestnanec osè.$riadok->oc - $riadok->prie $riadok->meno","LTB",0,"L"); }

$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);

if( $copern == 10 )
{
$pdf->Cell(80,5,"Popis","1",0,"L");
$pdf->Cell(20,5,"Od","1",0,"L");$pdf->Cell(20,5,"Do","1",0,"L");
$pdf->Cell(20,5,"Dni","1",0,"R");$pdf->Cell(20,5,"Hodiny","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");
}
if( $copern == 20 )
{
$pdf->Cell(10,5,"osè","1",0,"R");$pdf->Cell(80,5,"Priezvisko meno","1",0,"L");
$pdf->Cell(20,5,"Od","1",0,"L");$pdf->Cell(20,5,"Do","1",0,"L");
$pdf->Cell(20,5,"Dni","1",0,"R");$pdf->Cell(20,5,"Hodiny","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");
}
if( $copern == 30 )
{
$pdf->Cell(80,5,"Popis","1",0,"L");
$pdf->Cell(20,5,"Od","1",0,"L");$pdf->Cell(20,5,"Do","1",0,"L");
$pdf->Cell(20,5,"Dni","1",0,"R");$pdf->Cell(20,5,"Hodiny","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");
}

     }
//koniec hlavicky j=0


$nassklad = $riadok->nas;
$pocstavCelkom = $pocstavCelkom + $riadok->pcs;
$Cislo=$pocstavCelkom+"";
$sPocstavCelkom=sprintf("%0.2f", $Cislo);

$prijemCelkom = $prijemCelkom + $riadok->prj;
$Cislo=$prijemCelkom+"";
$sPrijemCelkom=sprintf("%0.2f", $Cislo);


//koniec celkom zaciatok riadku

$pocstav = $riadok->pcs;
$Cislo=$pocstav+"";
$sPocstav=sprintf("%0.2f", $Cislo);

$daod_sk=SkDatum($riadok->daod);
$dado_sk=SkDatum($riadok->dado);

$tdmxa="Dovolenka";
if( $riadok->dmxa == 510 ) $tdmxa="Sviatok";
if( $riadok->dmxa == 502 ) $tdmxa="Vo¾no";
if( $riadok->dmxa == 518 ) $tdmxa="Lekár";
if( $riadok->dmxa == 520 ) $tdmxa="Iné";
if( $riadok->dmxa == 801 ) $tdmxa="Nemoc";
if( $riadok->dmxa == 802 ) $tdmxa="Ošetrovné";
if( $riadok->dmxa == 809 ) $tdmxa="Materská dovolenka";
if( $riadok->dmxa == 503 ) $tdmxa="Absencia";

if( $riadok->dmxa == 1 ) 
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb = $riadok->cplxb  ";
//echo $sqlfir;
//exit;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $datumt = $fir_riadok->datn; }

if( $copern == 20 ) { $datumt=""; }

$tdmxa="Príchod do práce ".$datumt;
}
if( $riadok->dmxa == 2 ) 
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb = $riadok->cplxb  ";
//echo $sqlfir;
//exit;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $datumt = $fir_riadok->datn; }

if( $copern == 20 ) { $datumt=""; }

$sqlttt = "SELECT * FROM kalendar WHERE dat = '$fir_riadok->daod' ";
//echo $sqlttt;
//exit;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=$riaddok->akyden;
  $sviatok=1*$riaddok->svt;
  }

$denx="Po";
if( $akyden == 2 ) {$denx="Ut";} if( $akyden == 3 ) {$denx="St";} if( $akyden == 4 ) {$denx="Št";}
if( $akyden == 5 ) {$denx="Pi";} if( $akyden == 6 ) {$denx="So";} if( $akyden == 7 ) {$denx="Ne";}
if( $sviatok == 1 ) {$denx=$denx.",Sv";}

if( $copern == 20 ) { $denx=""; }

$tdmxa="Odchod z práce   ".$datumt." ".$denx;
}


if( $riadok->dmxb == 10 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5,"osè.$riadok->oc - $riadok->prie $riadok->meno","LRTB",1,"L");

}


if( $riadok->dmxb == 15 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(80,5,"$riadok->dmxa $tdmxa","1",0,"L");
$pdf->Cell(20,5,"$daod_sk","1",0,"L");$pdf->Cell(20,5,"$dado_sk","1",0,"L");
$pdf->Cell(20,5,"$riadok->dnixa","1",0,"R");$pdf->Cell(20,5,"$riadok->hodxb","1",0,"R");
$pdf->Cell(0,5,"  ","1",1,"R");

}



if( $riadok->dmxb == 19 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5," ","0",1,"L");

}


if( $riadok->dmxb == 20 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5,"$riadok->dmxa $tdmxa","LRTB",1,"L");

}


if( $riadok->dmxb == 25 )
{

$pdf->SetFont('arial','',8);
$ajcas="";
if( $riadok->dmxa == 1 OR $riadok->dmxa == 2 ) 
  {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE cplxb = $riadok->cplxb  ";
//echo $sqlfir;
//exit;
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $ajcas = $fir_riadok->datn; }
  }

$ipx=$riadok->xtxt;
if( $riadok->dmxa > 2 ) { $ipx=""; }

$pdf->Cell(10,5,"$riadok->oc","1",0,"R");$pdf->Cell(80,5,"$riadok->prie $riadok->meno $ajcas $ipx","1",0,"L");
$pdf->Cell(20,5,"$daod_sk","1",0,"L");$pdf->Cell(20,5,"$dado_sk","1",0,"L");
$pdf->Cell(20,5,"$riadok->dnixa","1",0,"R");$pdf->Cell(20,5,"$riadok->hodxb","1",0,"R");
$pdf->Cell(0,5," ","1",1,"R");

}



if( $riadok->dmxb == 29 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5," ","0",1,"L");

}



if( $riadok->dmxb == 30 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5,"osè.$riadok->oc - $riadok->prie $riadok->meno","LRTB",1,"L");

}


if( $riadok->dmxb == 35 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(80,5,"$riadok->dmxa $tdmxa ","1",0,"L");
$pdf->Cell(20,5,"$daod_sk","1",0,"L");$pdf->Cell(20,5,"$dado_sk","1",0,"L");
$pdf->Cell(20,5,"$riadok->dnixa","1",0,"R");$pdf->Cell(20,5,"$riadok->hodxb","1",0,"R");
$pocsek=$riadok->hodinyz."h ".$riadok->minutyz."min";
if( $riadok->dmxa != 2 ) { $pocsek=""; }
$pdf->Cell(0,5,"$pocsek ","1",1,"R");

}



if( $riadok->dmxb == 39 )
{

$pdf->SetFont('arial','',8);

$pdf->Cell(0,5," ","0",1,"L");

}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }

$csvmzda=0;
$sqldok = mysql_query("SELECT csv FROM F$kli_vxcf"."_mzddochadzkaset WHERE ocx = $riadok->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $csvmzda=1*$riaddok->csv;
  }

if( $copern == 30 AND $csvmzda == 1 )
  {

$uva_hod=8;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=1*$riaddok->uva_hod;
  }

$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD pracdni DECIMAL(10,0) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD prachod DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD neprithod DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD zosthod DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD odpracov DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD nadcasov DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD odpracdni DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD ndcrok DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD ndccer DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dochprc$kli_uzid ADD ndczos DECIMAL(10,2) DEFAULT 0 AFTER cplxb";
$vysledek = mysql_query("$sql");

//xxx hodiny nepritomnosti
//daj prec sviatky a so,ne z nemocenskej
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET hodxb=$uva_hod WHERE dmxb = 35 AND dmxa > 800  "; 
$dsql = mysql_query("$dsqlt");

$sqlttx = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc = $cislo_oc AND ume = $kli_vume AND dmxb = 35 AND dmxa > 800  ".
" ORDER BY oc,daod,cplxb ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
$ix=0;           
$prichod=0;
  while ($ix <= $tvpolx )
  {

  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);

$odpocetdni=0;
$sqlfir = "SELECT * FROM kalendar WHERE dat >= '$riadokx->daod' AND dat <= '$riadokx->dado' AND ( akyden > 5 OR svt = 1 ) ";
$tovk = mysql_query("$sqlfir");
$odpocetdni = 1*mysql_num_rows($tovk);

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET dnixa=dnixa-$odpocetdni WHERE cplxb = $riadokx->cplxb "; 
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}
$ix = $ix + 1;
  }

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET polprc=hodxb*dnixa WHERE dmxb = 35 AND dmxa > 2 "; 
$dsql = mysql_query("$dsqlt");

$neprithod=0;
$sqldok = mysql_query("SELECT SUM(polprc) AS neprit FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE dmxb = 35 AND dmxa > 2 AND dmxa != 510 GROUP BY dmxb ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $neprithod=1*$riaddok->neprit;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET pracdni=$pracdni WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET prachod=pracdni*$uva_hod WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET neprithod=$neprithod WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET zosthod=prachod-neprithod WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");

$odpracovane=0; 
$sqldok = mysql_query("SELECT SUM(polprc) AS odprac FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE dmxb = 35 AND dmxa = 2 GROUP BY dmxb ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odpracovane=1*$riaddok->odprac/3600;
  }
$odpracovanedni=0;
$sqlttx = "SELECT SUM(polprc) AS odpracdni FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE dmxb = 35 AND dmxa = 2 GROUP BY daod ";
$tovx = mysql_query("$sqlttx");
$tvpolx = mysql_num_rows($tovx);
$ix=0;           
  while ($ix <= $tvpolx )
  {
  if (@$zaznam=mysql_data_seek($tovx,$ix))
{
$riadokx=mysql_fetch_object($tovx);
  $odpracovanedni=$odpracovanedni+1;
}
$ix = $ix + 1;
  }


$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET odpracov=$odpracovane, odpracdni=$odpracovanedni WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET nadcasov=odpracov-zosthod WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET nadcasov=0 WHERE dmxb = 39 AND nadcasov < 0 "; 
$dsql = mysql_query("$dsqlt");

//saldo nadcasov
$nadcasrok=0; 
$sqldok = mysql_query("SELECT SUM(nadcasy) AS nadcasrok FROM F$kli_vxcf"."_mzddochadzkanadcasy WHERE oc = $cislo_oc AND ume < $kli_vume GROUP BY oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nadcasrok=1*$riaddok->nadcasrok;
  }
$nadcascer=0; 
$sqldok = mysql_query("SELECT SUM(hod) AS nadcascer FROM F$kli_vxcf"."_mzdzalvy WHERE oc = $cislo_oc AND ume < $kli_vume AND dm = 201 GROUP BY oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nadcascer=1*$riaddok->nadcascer;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET ndcrok=$nadcasrok, ndccer=$nadcascer WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid SET ndczos=ndcrok-ndccer WHERE dmxb = 39 "; 
$dsql = mysql_query("$dsqlt");

//vytlac
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE dmxb = 39 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pracdni=1*$riaddok->pracdni;
  $prachod=1*$riaddok->prachod;
  $neprithod=1*$riaddok->neprithod;
  $zosthod=1*$riaddok->zosthod;
  $odpracov=1*$riaddok->odpracov;
  $odpracdni=1*$riaddok->odpracdni;
  $nadcasov=1*$riaddok->nadcasov;
  $ndcrok=$riaddok->ndcrok;
  $ndccer=$riaddok->ndccer;
  $ndczos=$riaddok->ndczos;
  }

$pdf->Cell(20,5," ","0",1,"L");
$pdf->Cell(60,5,"Pracovné dni (bez sviatkov)","1",0,"L");$pdf->Cell(40,5,"$pracdni","1",1,"R");
$pdf->Cell(60,5,"Fond pracovného èasu FPÈ","1",0,"L");$pdf->Cell(40,5,"$prachod","1",1,"R");
$pdf->Cell(60,5,"Neprítomnos v hodinách","1",0,"L");$pdf->Cell(40,5,"$neprithod","1",1,"R");
$pdf->Cell(60,5,"FPÈ - Neprítomnos v hodinách","1",0,"L");$pdf->Cell(40,5,"$zosthod","1",1,"R");
$pdf->Cell(60,5,"Odpracované dni","1",0,"L");$pdf->Cell(40,5,"$odpracdni","1",1,"R");
$pdf->Cell(60,5,"Odpracované hodiny","1",0,"L");$pdf->Cell(40,5,"$odpracov","1",1,"R");
$pdf->Cell(60,5,"Nadèasové hodiny v $kli_vume","1",0,"L");$pdf->Cell(40,5,"$nadcasov","1",1,"R");
$pdf->Cell(60,5," ","0",1,"R");
$pdf->Cell(60,5,"Stav pred $kli_vume ","1",1,"L");
$pdf->Cell(60,5,"Nadèasové hodiny odpracované","1",0,"L");$pdf->Cell(40,5,"$ndcrok","1",1,"R");
$pdf->Cell(60,5,"Nadèasové hodiny èerpanné","1",0,"L");$pdf->Cell(40,5,"$ndccer","1",1,"R");
$pdf->Cell(60,5,"Nadèasové hodiny zostatok","1",0,"L");$pdf->Cell(40,5,"$ndczos","1",1,"R");

$sql = "SELECT nadcasy FROM F".$kli_vxcf."_mzddochadzkanadcasy ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE F".$kli_vxcf."_mzddochadzkanadcasy ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   ume           DECIMAL(7,4) DEFAULT 0,
   oc            DECIMAL(5,0) DEFAULT 0,
   nadcasy       DECIMAL(7,2) DEFAULT 0,
   datm          TIMESTAMP(14)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzddochadzkanadcasy'.$sqlt;
$vytvor = mysql_query("$vsql");
               }

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddochadzkanadcasy WHERE oc = $cislo_oc AND ume = $kli_vume "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddochadzkanadcasy ".
" SELECT ume,oc,nadcasov,now() FROM F$kli_vxcf"."_dochprc$kli_uzid WHERE oc = $cislo_oc AND ume = $kli_vume AND dmxb = 39 "; 
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;
  }

$pdf->Output("../tmp/doch.$kli_uzid.pdf");


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/doch.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
