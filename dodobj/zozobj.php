<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1;

$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;


// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Objednávky</title>
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
<tr><td>EuroSecom - Dodávateľske objednávky</td></tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/mzdtlac$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdtlac$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xcpl         int(10) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14),
   xskm         decimal(10,3) DEFAULT 0,
   xobm         decimal(10,3) DEFAULT 0,
   xrzd         decimal(10,3) DEFAULT 0,
   xpsk         decimal(10,3) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$tlacobj = 1*$_REQUEST['tlacobj'];


//zober z objednavok
$podmdok=" xdok >= 0 ";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 0,xdok,xice,xodbm,xsx2,xsx3,xcpo,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_dodavobj ".
" WHERE $podmdok AND xsx2 != 9 ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;

//group vsetko
$podmgrp=" xdok";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,0,xsx2,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,SUM(xskm),SUM(xobm),SUM(xrzd),SUM(xpsk)  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY $podmgrp".
"";
$dsql = mysql_query("$dsqlt");

//group vsetko
$podmgrp=" pox";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,0,xice,0,xsx2,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,SUM(xskm),SUM(xobm),SUM(xrzd),SUM(xpsk)  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 AND pox = 0 GROUP BY $podmgrp".
"";
$dsql = mysql_query("$dsqlt");


$sqltt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE pox = 0 ";
$tov = mysql_query("$sqltt");


if ( $drupoh == 1 AND $copern = 1 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE ( xdok >= 0 ) ORDER BY pox,xdok ";
  }

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

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$strana=$strana+1;

$pdf->SetFont('arial','',12);
$pdf->Cell(190,6,"Dodávateľské objednávky","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(0,6,"FIR$kli_vxcf $kli_nxcf / strana: $strana","RTB",1,"R");

$pdf->Cell(277,3,"                          ","$rmc",1,"L");
$pdf->Cell(25,5,"Číslo","B",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(100,5,"Dodávateľ","B",0,"L");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(40,5,"D. vyst. - dodania","B",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(30,5,"Stav","B",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(40,5,"Suma","B",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(37,5,"Vystavil","B",1,"C");
$pdf->Cell(277,2,"                          ","$rmc",1,"L");
     }
//koniec hlavicky j=0


if( $riadok->pox == 1 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;
$www = $fir_riadok->www; 

$sqlfir = "SELECT * FROM ezak WHERE cuid = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto;   

$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $riadok->xdok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$stav = $fir_riadok->xstav; 
$datv = $fir_riadok->xdatv;
$skdatv = SkDatum($datv);
$datd = $fir_riadok->xdatd;   
$skdatd = SkDatum($datd); 


$pdf->SetFont('arial','',10);
$pdf->Cell(25,5," $riadok->xdok","$rmc",0,"L");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(100,5,"$ico - $nai $na2","$rmc",0,"L");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->SetFont('arial','',9);
$pdf->Cell(40,5,"$skdatv - $skdatd","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(30,5,"$stav","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->SetFont('arial','',10);
$pdf->Cell(40,5,"$riadok->xhdd ","0",0,"R");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->SetFont('arial','',8);
$pdf->Cell(37,5," $ekto","$rmc",1,"L");
$pdf->Cell(277,1,"                          ","$rmc",1,"L");
}


if( $riadok->pox == 10 )
{
$pdf->SetFont('arial','',10);
$pdf->Cell(277,1,"                          ","$rmc",1,"L");
$pdf->Cell(199,8,"SPOLU","T",0,"L");$pdf->Cell(1,5," ","$rmc",0,"L");

$pdf->SetFont('arial','B',12);
$pdf->Cell(40,8,"$riadok->xhdd ","T",0,"R");$pdf->Cell(37,5," ","$rmc",1,"L");

}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;

  }


$pdf->Output("../tmp/mzdtlac.$kli_uzid.pdf"); 



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdtlac.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
       
<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
