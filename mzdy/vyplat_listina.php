<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$ostre = 1*$_REQUEST['ostre'];

$zaloha = 1*$_REQUEST['zaloha'];

if( $copern == 2 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> neboli spracované naostro , \r urobte najprv ostré spracovanie !");
window.close();
</script>
<?php
exit;
}
    }


if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");


//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   sum_hot      DECIMAL(10,2) DEFAULT 0,
   hot_eur      DECIMAL(10,2) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   wmsx         INT(7) DEFAULT 0,
   jed_eur      DECIMAL(10,2) DEFAULT 0,
   des_eur      DECIMAL(10,2) DEFAULT 0,
   e1000        DECIMAL(10,0) DEFAULT 0,
   e500         DECIMAL(10,0) DEFAULT 0,
   e200         DECIMAL(10,0) DEFAULT 0,
   e100         DECIMAL(10,0) DEFAULT 0,
   e50          DECIMAL(10,0) DEFAULT 0,
   e20          DECIMAL(10,0) DEFAULT 0,
   e10          DECIMAL(10,0) DEFAULT 0,
   e5           DECIMAL(10,0) DEFAULT 0,
   e2           DECIMAL(10,0) DEFAULT 0,
   e1           DECIMAL(10,0) DEFAULT 0,
   c50          DECIMAL(10,0) DEFAULT 0,
   c20          DECIMAL(10,0) DEFAULT 0,
   c10          DECIMAL(10,0) DEFAULT 0,
   c5           DECIMAL(10,0) DEFAULT 0,
   c2           DECIMAL(10,0) DEFAULT 0,
   c1           DECIMAL(10,0) DEFAULT 0,
   ds6          DECIMAL(10,6) DEFAULT 0,
   ds2          DECIMAL(10,2) DEFAULT 0,
   ds0          DECIMAL(10,0) DEFAULT 0,
   qa           DECIMAL(10,0) DEFAULT 0,
   qj           DECIMAL(10,0) DEFAULT 0,
   konx2        DECIMAL(10,0) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober data dobierka
if( $zaloha == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum_hot,hot_eur,oc,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,".
" 0,0".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND sum_hot != 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//zober data zaloha
if( $zaloha == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,(kc*30.1260),oc,0,0,0,".
" 0,0,0,0,0,0,0,0,0,0,".
" 0,0,0,0,0,0,".
" 0,0,0,0,0,".
" 0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND kc != 0 AND ( dm = 929 OR dm = 930 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_$mzdkun".
" SET wmsx=wms".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_$mzdkun.oc";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET jed_eur=floor(sum_hot), des_eur=(sum_hot-jed_eur)*100, ".
" konx=0 ".
" WHERE oc >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET qa=jed_eur, qj=0, e1000=(qa-500)/1000, qj=qa-(e1000*1000), ".
" konx=0 ".
" WHERE oc >= 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e500=(qj-250)/500, qj=qj-(e500*500), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e200=(qj-100)/200, qj=qj-(e200*200), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e100=(qj-50)/100, qj=qj-(e100*100), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e50=(qj-25)/50, qj=qj-(e50*50), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e20=(qj-10)/20, qj=qj-(e20*20), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e10=(qj-5)/10, qj=qj-(e10*10), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e5=(qj-2)/5, qj=qj-(e5*5), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e2=(qj-1)/2, qj=qj-(e2*2), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET e1=qj, ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

//centy mincovka
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET qa=des_eur, qj=0, konx=0 ".
" WHERE oc >= 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c50=(qa-25)/50, qj=qa-(c50*50), ".
" konx=0 ".
" WHERE oc >= 0 AND qa > 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c20=(qj-10)/20, qj=qj-(c20*20), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c10=(qj-5)/10, qj=qj-(c10*10), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c5=(qj-2)/5, qj=qj-(c5*5), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c2=(qj-1)/2, qj=qj-(c2*2), ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET c1=qj, ".
" konx=0 ".
" WHERE oc >= 0 AND qj > 0 ";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT sum(sum_hot),sum(hot_eur),0,0,0,0,".
" sum(e1000),sum(e500),sum(e200),sum(e100),sum(e50),sum(e20),sum(e10),sum(e5),sum(e2),sum(e1),".
" sum(c50),sum(c20),sum(c10),sum(c5),sum(c2),sum(c1),".
" 0,0,0,0,0,".
" 8,9".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc > 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT sum(sum_hot),sum(hot_eur),0,wmsx,0,0,".
" sum(e1000),sum(e500),sum(e200),sum(e100),sum(e50),sum(e20),sum(e10),sum(e5),sum(e2),sum(e1),".
" sum(c50),sum(c20),sum(c10),sum(c5),sum(c2),sum(c1),".
" 0,0,0,0,0,".
" 8,0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc > 0".
" GROUP BY wmsx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum_hot,hot_eur,0,wmsx,0,0,".
" e1000,e500,e200,e100,e50,e20,e10,e5,e2,e1,".
" c50,c20,c10,c5,c2,c1,".
" 0,0,0,0,0,".
" konx2,konx".
" FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" WHERE oc >= 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Výplatná listina</title>
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
<td>EuroSecom  -  Výplatná listina 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdvyp$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdvyp$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcvypl".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc >= 0 ORDER BY konx,wmsx,konx2,prie".
"";
//echo $sqltt;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$h_dao = SkDatum($rtov->dao);
$h_e1000=$rtov->e1000;
if( $rtov->e1000 == 0 ) $h_e1000="";
$h_e500=$rtov->e500;
if( $rtov->e500 == 0 ) $h_e500="";
$h_e200=$rtov->e200;
if( $rtov->e200 == 0 ) $h_e200="";
$h_e100=$rtov->e100;
if( $rtov->e100 == 0 ) $h_e100="";
$h_e50=$rtov->e50;
if( $rtov->e50 == 0 ) $h_e50="";
$h_e20=$rtov->e20;
if( $rtov->e20 == 0 ) $h_e20="";
$h_e10=$rtov->e10;
if( $rtov->e10 == 0 ) $h_e10="";
$h_e5=$rtov->e5;
if( $rtov->e5 == 0 ) $h_e5="";
$h_e2=$rtov->e2;
if( $rtov->e2 == 0 ) $h_e2="";
$h_e1=$rtov->e1;
if( $rtov->e1 == 0 ) $h_e1="";
$h_c50=$rtov->c50;
if( $rtov->c50 == 0 ) $h_c50="";
$h_c20=$rtov->c20;
if( $rtov->c20 == 0 ) $h_c20="";
$h_c10=$rtov->c10;
if( $rtov->c10 == 0 ) $h_c10="";
$h_c5=$rtov->c5;
if( $rtov->c5 == 0 ) $h_c5="";
$h_c2=$rtov->c2;
if( $rtov->c2 == 0 ) $h_c2="";
$h_c1=$rtov->c1;
if( $rtov->c1 == 0 ) $h_c1="";


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 


$pdf->SetFont('arial','',7);
$pdf->Cell(258,6,"Konverzný kurz 30.1260Sk/€","0",1,"R");
$pdf->SetFont('arial','',10);

if( $zaloha == 0 ) { $pdf->Cell(129,6,"Výplatná listina a mincovka DOBIERKA $kli_vume","LTB",0,"L"); }
if( $zaloha == 1 ) { $pdf->Cell(129,6,"Výplatná listina a mincovka ZÁLOHA $kli_vume","LTB",0,"L"); }
$pdf->Cell(129,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',7);

$pdf->Cell(8,6," ","1",0,"R");$pdf->Cell(8,6,"500€","1",0,"R");$pdf->Cell(8,6,"200€","1",0,"R");
$pdf->Cell(8,6,"100€","1",0,"R");$pdf->Cell(8,6,"50€","1",0,"R");$pdf->Cell(8,6,"20€","1",0,"R");$pdf->Cell(8,6,"10€","1",0,"R");
$pdf->Cell(8,6,"5€","1",0,"R");$pdf->Cell(8,6,"2€","1",0,"R");$pdf->Cell(8,6,"1€","1",0,"R");
$pdf->Cell(8,6,"50c","1",0,"R");$pdf->Cell(8,6,"20c","1",0,"R");$pdf->Cell(8,6,"10c","1",0,"R");
$pdf->Cell(8,6,"5c","1",0,"R");$pdf->Cell(8,6,"2c","1",0,"R");$pdf->Cell(8,6,"1c","1",0,"R");

$pdf->SetFont('arial','',9);

$pdf->Cell(50,6,"Meno","1",0,"L");$pdf->Cell(20,6,"(Info Sk)","1",0,"L");$pdf->Cell(30,6,"Vyplatené v €","1",0,"R");$pdf->Cell(30,6,"Podpis","1",1,"L");


     }
//koniec hlavicky j=0


if( $rtov->konx == 0 AND $rtov->konx2 == 0 )
{
$pdf->SetFont('arial','',8);

$pdf->Cell(8,7,"$h_e1000","B",0,"R");$pdf->Cell(8,7,"$h_e500","B",0,"R");$pdf->Cell(8,7,"$h_e200","B",0,"R");
$pdf->Cell(8,7,"$h_e100","B",0,"R");$pdf->Cell(8,7,"$h_e50","B",0,"R");$pdf->Cell(8,7,"$h_e20","B",0,"R");$pdf->Cell(8,7,"$h_e10","B",0,"R");
$pdf->Cell(8,7,"$h_e5","B",0,"R");$pdf->Cell(8,7,"$h_e2","B",0,"R");$pdf->Cell(8,7,"$h_e1","BR",0,"R");
$pdf->Cell(8,7,"$h_c50","B",0,"R");$pdf->Cell(8,7,"$h_c20","B",0,"R");$pdf->Cell(8,7,"$h_c10","B",0,"R");
$pdf->Cell(8,7,"$h_c5","B",0,"R");$pdf->Cell(8,7,"$h_c2","B",0,"R");$pdf->Cell(8,7,"$h_c1","B",0,"R");

$pdf->SetFont('arial','',10);

$pdf->Cell(50,7,"$rtov->prie $rtov->meno $rtov->titl","B",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,7,"($rtov->hot_eur)","B",0,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(30,7,"$rtov->sum_hot","B",0,"R");
$pdf->SetFont('arial','',10);
$pdf->Cell(30,7,"","B",1,"R");
}

if( $rtov->konx2 != 0 AND $rtov->konx == 0 )
{
$pdf->Cell(50,2,"","0",1,"L");
$pdf->SetFont('arial','',8);

$e1000=$rtov->e1000;
if( $e1000 == 0 ) { $e1000=""; }

$pdf->Cell(8,7,"$e1000","BT",0,"R");$pdf->Cell(8,7,"$rtov->e500","BT",0,"R");$pdf->Cell(8,7,"$rtov->e200","BT",0,"R");
$pdf->Cell(8,7,"$rtov->e100","BT",0,"R");$pdf->Cell(8,7,"$rtov->e50","BT",0,"R");$pdf->Cell(8,7,"$rtov->e20","BT",0,"R");$pdf->Cell(8,7,"$rtov->e10","BT",0,"R");
$pdf->Cell(8,7,"$rtov->e5","BT",0,"R");$pdf->Cell(8,7,"$rtov->e2","BT",0,"R");$pdf->Cell(8,7,"$rtov->e1","BTR",0,"R");
$pdf->Cell(8,7,"$rtov->c50","BT",0,"R");$pdf->Cell(8,7,"$rtov->c20","BT",0,"R");$pdf->Cell(8,7,"$rtov->c10","BT",0,"R");
$pdf->Cell(8,7,"$rtov->c5","BT",0,"R");$pdf->Cell(8,7,"$rtov->c2","BT",0,"R");$pdf->Cell(8,7,"$rtov->c1","BT",0,"R");

$pdf->SetFont('arial','',10);

$pdf->Cell(50,7,"SPOLU výpl.miesto $rtov->wmsx","BT",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,7," ","BT",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(30,7,"$rtov->sum_hot","BT",0,"R");
$pdf->Cell(30,7,"","BT",1,"R");

}


if( $rtov->konx != 0 )
{
$pdf->Cell(50,2,"","0",1,"L");
$pdf->SetFont('arial','',8);

$e1000=$rtov->e1000;
if( $e1000 == 0 ) { $e1000=""; }

$pdf->Cell(8,7,"$e1000","BT",0,"R");$pdf->Cell(8,7,"$rtov->e500","BT",0,"R");$pdf->Cell(8,7,"$rtov->e200","BT",0,"R");
$pdf->Cell(8,7,"$rtov->e100","BT",0,"R");$pdf->Cell(8,7,"$rtov->e50","BT",0,"R");$pdf->Cell(8,7,"$rtov->e20","BT",0,"R");$pdf->Cell(8,7,"$rtov->e10","BT",0,"R");
$pdf->Cell(8,7,"$rtov->e5","BT",0,"R");$pdf->Cell(8,7,"$rtov->e2","BT",0,"R");$pdf->Cell(8,7,"$rtov->e1","BTR",0,"R");
$pdf->Cell(8,7,"$rtov->c50","BT",0,"R");$pdf->Cell(8,7,"$rtov->c20","BT",0,"R");$pdf->Cell(8,7,"$rtov->c10","BT",0,"R");
$pdf->Cell(8,7,"$rtov->c5","BT",0,"R");$pdf->Cell(8,7,"$rtov->c2","BT",0,"R");$pdf->Cell(8,7,"$rtov->c1","BT",0,"R");

$pdf->SetFont('arial','',10);

$pdf->Cell(50,7,"SPOLU všetko","BT",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(20,7," ","BT",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(30,7,"$rtov->sum_hot","BT",0,"R");
$pdf->Cell(30,7,"","BT",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if( $rtov->konx2 != 0 AND $rtov->konx == 0 ) { $j=0; $strana=$strana+1; }
  }


$pdf->Output("../tmp/mzdvyp.$kli_uzid.pdf");



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdvyp.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
