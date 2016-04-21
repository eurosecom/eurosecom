<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$cslm=400002;
$clsm = 920;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_skl = 1*$_REQUEST['cislo_skl'];

//copern=10 okamzity stav, 20-mesacny stav, 30=pociatocny stav

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

$reko = include("skl_rekonstrukcia.php");


////////////////////////////////////////////////////////datum pociatku a konca pohybov


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

$h_obdp = $kli_vmes;
$h_obdk = $kli_vmes;


$h_obdpume=$h_obdp.".".$kli_vrok;
$pole = explode(".", $h_obdpume);
$mesp_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';



$h_obdkume=$h_obdk.".".$kli_vrok;
$pole = explode(".", $h_obdkume);
$mesk_dph=$pole[0];
$rokk_dph=$pole[1];

$datk_dph=$rokk_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datk_dph', 0 )";
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

////////////////////////////////////////////////////////koniec datum pociatku a konca pohybov

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Priemerné ceny / nákupné ceny PDF</title>
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
<td>EuroSecom  -  Priemerné ceny / nákupné ceny PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   druh        DECIMAL(15,0),
   pox1        INT,
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         DECIMAL(15,0),
   skl         INT,
   poh         DECIMAL(5,0),
   ico         DECIMAL(15,0),
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   nkc         DECIMAL(10,4),
   hod         DECIMAL(10,0),
   vdj         DECIMAL(10,0),
   prj         DECIMAL(10,0),
   pcs         DECIMAL(10,0)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$datpoc=$kli_vrok."-01-01";
//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,0,'$datpoc',0,skl,poh,0,cis,mno,cen,0,'0','0','0',mno FROM F$kli_vxcf"."_sklpoc WHERE cis > 0 ORDER BY cis ";
$dsql = mysql_query("$dsqlt");


//prijem 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 0,0,0,0,dat,dok,skl,poh,ico,cis,mno,cen,0,'0','0',0,0 FROM F$kli_vxcf"."_sklpri WHERE cis > 0 ORDER BY cis ";
$dsql = mysql_query("$dsqlt");

//vyber najnovsiu nakupnu
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 1,0,0,0,dat,dok,skl,poh,ico,cis,mno,cen,0,'0','0',0,0 FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE cis > 0 ORDER BY dat DESC ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc$kli_uzid".
" SELECT 2,0,0,0,dat,dok,skl,poh,ico,cis,mno,cen,0,'0','0',0,0 FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE druh = 1 GROUP BY cis";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc$kli_uzid WHERE druh != 2 ";
$dsql = mysql_query("$dsqlt");




//vydaj 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,0,0,ume,dat,dok,skl,poh,ico,cis,mno,cen,0,'0',0,'0',0 FROM F$kli_vxcf"."_sklvyd WHERE cis > 0 AND dat <= '$datk_dph' AND dat >= '$datp_dph' ".
" ORDER BY cis,dok ";
$dsql = mysql_query("$dsqlt");

//faktury 
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprcd$kli_uzid".
" SELECT 0,0,0,ume,dat,dok,skl,poh,0,cis,mno,cen,0,'0',0,'0',0 FROM F$kli_vxcf"."_sklfak WHERE cis > 0 AND dat <= '$datk_dph' AND dat >= '$datp_dph' ".
" ORDER BY cis,dok ";
$dsql = mysql_query("$dsqlt");


//dopln.nak.cenu
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid,F$kli_vxcf"."_sklprc$kli_uzid SET F$kli_vxcf"."_sklprcd$kli_uzid.nkc=F$kli_vxcf"."_sklprc$kli_uzid.cen ".
" WHERE F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklprc$kli_uzid.cis ";
$dsql = mysql_query("$dsqlt");

//daj prec ak nie je nakupne
$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprcd$kli_uzid WHERE nkc <= 0 ";
$dsql = mysql_query("$dsqlt");

//rozdel do kategorii
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET hod=cen/nkc*100 ";
$dsql = mysql_query("$dsqlt");

//daj prec male rozdiely
$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprcd$kli_uzid WHERE hod <= 140 AND hod >= 60 ";
$dsql = mysql_query("$dsqlt");

//rozdel do kategorii
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET pcs=hod, prj=hod, vdj=hod WHERE hod != 0";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET vdj=hod, prj=0, pcs=0 WHERE hod <= 60 OR hod >= 140 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET prj=hod, vdj=0, pcs=0 WHERE hod <= 70 OR hod >= 170 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET pcs=hod, prj=0, vdj=0 WHERE hod <= 1 OR hod >= 200 ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt; exit;

$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET prj=prj-100 WHERE prj != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET vdj=vdj-100 WHERE vdj != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprcd$kli_uzid SET pcs=pcs-100 WHERE pcs != 0 ";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklprcd$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprcd$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE F$kli_vxcf"."_sklprcd$kli_uzid.cis > 0 ".
" ORDER BY F$kli_vxcf"."_sklprcd$kli_uzid.cis,dok ";


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


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
if ( $copern == 20 )  { $pdf->Cell(90,6,"Priemerné ceny / nákupné ceny od $datp_dph do $datk_dph    ","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',6);


$pdf->Cell(15,5,"SKL/Dok","1",0,"R");$pdf->Cell(20,5,"MAT","1",0,"R");$pdf->Cell(50,5,"Názov","1",0,"L");
$pdf->Cell(15,5,"Nákup.cena","1",0,"R");$pdf->Cell(10,5,"MJ","1",0,"L");
$pdf->Cell(15,5,"Množstvo","1",0,"R");$pdf->Cell(15,5,"Výdaj.cena","1",0,"R");$pdf->Cell(15,5,"rozdiel > 40%","1",0,"R");
$pdf->Cell(15,5,"rozdiel > 70%","1",0,"R");$pdf->Cell(0,5,"rozdiel > 100%","1",1,"R");

     }
//koniec hlavicky j=0




$okraje=0;
if( $zadod == 1 ) { $okraje="T"; }
if( $riadok->vdj == 0 ) { $riadok->vdj=""; }
if( $riadok->prj == 0 ) { $riadok->prj=""; }
if( $riadok->pcs == 0 ) { $riadok->pcs=""; }

$pdf->Cell(15,5,"$riadok->skl/ $riadok->dok","$okraje",0,"L");$pdf->Cell(20,5,"$riadok->cis","$okraje",0,"R");$pdf->Cell(50,5,"$riadok->nat","$okraje",0,"L");
$pdf->Cell(15,5,"$riadok->nkc","$okraje",0,"R");$pdf->Cell(10,5,"$riadok->mer","$okraje",0,"L");
$pdf->Cell(15,5,"$riadok->mno","$okraje",0,"R");$pdf->Cell(15,5,"$riadok->cen","$okraje",0,"R");$pdf->Cell(15,5,"$riadok->vdj","$okraje",0,"R");
$pdf->Cell(15,5,"$riadok->prj","$okraje",0,"R");$pdf->Cell(0,5,"$riadok->pcs","$okraje",1,"R");





}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }





$pdf->Output("../tmp/podklad.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcd'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprcdx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
