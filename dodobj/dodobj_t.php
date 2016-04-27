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
$noprice = 1*$_REQUEST['noprice'];

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
<title>Objednávka</title>
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
<td>EuroSecom  -  Dodávateľská objednávka</td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/dodobj_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/dodobj_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
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

if( $fir_fico == '46614478' )
  {
$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcx$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 "; 
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcu$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 "; 
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F".$kli_vxcf."_mzdprcx$kli_uzid MODIFY xced decimal(10,4) DEFAULT 0 "; 
$sqldok = mysql_query("$sqlttt");
  }

$tlacobj = 1*$_REQUEST['tlacobj'];


//zober z objednavok
$podmdok=" xdok = ".$cislo_dok." ";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx2,xsx3,xcpo,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_dodavobj ".
" WHERE $podmdok AND xsx2 != 9 ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;


//group vsetko
$podmgrp=" xdok";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,xdok,xice,0,xsx2,0,xcpl,xcis,xnat,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm,SUM(xskm),SUM(xobm),SUM(xrzd),SUM(xpsk)  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY $podmgrp".
"";
$dsql = mysql_query("$dsqlt");

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( xdok > 0 ) ORDER BY pox,xcpl ";
  }

$sqlttt = "SELECT * FROM F$kli_vxcf"."_dodavobj WHERE xdok = $cislo_dok ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
$xdatv = $riaddok->xdatv;
$xdatvsk = SkDatum($xdatv);
$xdatd = $riaddok->xdatd;
$xdatdsk = SkDatum($xdatd);
//$xice=$riaddok->xice;
 $xdop=$riaddok->xdop;
//$xstav=$riaddok->xstav;
 $xplat=$riaddok->xplat;
 }


//echo $sqltt;
//exit;

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

if( $i == 0 )
  {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;
$www = $fir_riadok->www; 

$sqlfir = "SELECT * FROM ezak WHERE ez_id = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;
$icox=$riadok->xice;

if( $icoezak == 99999999 ) { $odbx=1*$riadok->xodbm; }
  }

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$chcemhlavicku=0;
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') ) { $chcemhlavicku=1; }
if ( $html == 0 )
          {
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') AND $chcemhlavicku == 1 )
{
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="185"; $rozmerhlv4="20"; 

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}
          }
$pdf->SetFont('arial','',9);

if ( $chcemhlavicku == 0 )
{
//text namiesto loga
$pdf->Cell(185,0,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',14);
$pdf->Cell(185,6,"$fir_fnaz","$rmc",1,"C");
$pdf->SetFont('arial','',12);
$pdf->Cell(185,5,"$fir_fuli $fir_fcdm,  $fir_fpsc $fir_fmes","$rmc",1,"C");
$pdf->SetFont('arial','',10);
$pdf->Cell(185,5,"IČO: $fir_fico       DIČ: $fir_fdic       IČ DPH: $fir_ficd","$rmc",1,"C");
$pdf->Cell(185,5,"$fir_ftel       $fir_fem1       $fir_fwww","$rmc",1,"C");
$pdf->Cell(185,4,"                          ","$rmc",1,"L");
}

$posun=$rozmerhlv2+$rozmerhlv4+5;
if( $chcemhlavicku == 1 ) { $pdf->SetY($posun); }

$pdf->SetFont('arial','',14);
$pdf->Cell(185,6,"Objednávka č. $riadok->xdok ","$rmc",1,"L");
$pdf->Cell(185,3,"                          ","$rmc",1,"L");




//hlavicka objednavky
$pdf->SetFont('arial','U',10);
$pdf->Cell(1,6,"","$rmc",0,"L");$pdf->Cell(69,6,"Dátumy","$rmc",0,"L");$pdf->Cell(11,6,"","$rmc",0,"L");$pdf->Cell(104,6,"Dodávateľ","$rmc",1,"L");
$pdf->SetFont('arial','B',9);
$pdf->Cell(1,5,"","$rmc",0,"L");$pdf->Cell(30,5,"Dátum vystavenia:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(39,5,"$xdatvsk","$rmc",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");$pdf->Cell(104,5,"$nai $na2","$rmc",1,"L");
$pdf->SetFont('arial','B',9);
$pdf->Cell(1,5,"","$rmc",0,"L");$pdf->Cell(30,5,"Dátum dodania:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(39,5,"$xdatdsk","$rmc",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");$pdf->Cell(104,5,"$uli,  $psc $mes","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");
$pdf->Cell(104,5,"IČO: $ico       DIČ: $dic       IČ DPH: $icd","$rmc",1,"L");
$pdf->SetFont('arial','B',9);
$pdf->Cell(1,5,"","$rmc",0,"L");$pdf->Cell(30,5,"Spôsob platby:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(39,5,"$xplat","$rmc",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");$pdf->Cell(104,5,"","$rmc",1,"L");
$pdf->SetFont('arial','B',9);
$pdf->Cell(1,5,"","$rmc",0,"L");$pdf->Cell(30,5,"Spôsob dopravy:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(39,5,"$xdop","$rmc",0,"L");$pdf->Cell(11,5," ","$rmc",0,"L");
$pdf->SetFont('arial','B',9);
$pdf->Cell(14,5,"Kontakt:","$rmc",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(90,5,"$tel   $em1   $www","$rmc",1,"L");

//zahlavie poloziek
$pdf->Cell(185,15,"                          ","$rmc",1,"L");
$pdf->SetFont('arial','',14);
$pdf->Cell(185,15,"Objednávame si u Vás:","$rmc",1,"L");

$pdf->SetFont('arial','',8);
$pdf->SetLineWidth(0.3);
$pdf->Cell(1,4,"","B",0,"L");$pdf->Cell(115,4,"Položka","B",0,"L");$pdf->Cell(25,4,"Jednotková cena","B",0,"R");$pdf->Cell(20,4,"Množstvo","B",0,"R");
$pdf->Cell(24,4,"Hodnota","B",1,"R");
$pdf->Cell(185,1,"                          ","$rmc",1,"L");

if( $odbx > 0 ) { //toto asi preč
$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $icox AND odbm = $odbx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes; 
                }
     }
//koniec hlavicky j=0


if( $riadok->pox == 1 AND $drupoh == 1 )
{
$pdf->SetFont('arial','',9);

$nat=$riadok->nat;
$xcis=1*$riadok->xcis;

if( $xcis == 0 AND $riadok->xsx3 == 0 ) { $nat=$riadok->xnat; $xcis=0; }

if( $riadok->xsx3 == 1 )
  {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sluzby WHERE slu = $xcis ORDER BY slu LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $natx=$riadok->nsl;
 $xcisx=$riadok->slu;
 }
$nat=$natx;
$xcis=$xcisx;

if( $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }
  }

$xcistlac=$xcis;
if( $xcis == 0 ) { $xcistlac=""; }

$cenatlac=$riadok->xced;
if( $riadok->xced == 0 ) { $cenatlac=""; }
if( $noprice == 1 ) { $cenatlac="_ . _"; }
$mnotlac=$riadok->xmno;
if( $riadok->xmno == 0 ) { $mnotlac=""; }
$hodnotatlac=$riadok->xhdd;
if( $riadok->xhdd == 0 ) { $hodnotatlac=""; }
if( $noprice == 1 ) { $hodnotatlac="_ . _"; }

$pdf->Cell(1,5,"","$rmc",0,"L");$pdf->Cell(115,5,"$xcistlac $nat","$rmc",0,"L");$pdf->Cell(25,5,"$cenatlac","0",0,"R");$pdf->Cell(20,5,"$mnotlac","0",0,"R");
$pdf->Cell(24,5,"$hodnotatlac","0",1,"R");
}
if( $riadok->pox == 10 AND $drupoh == 1 )
{
$pdf->Cell(185,1,"                          ","$rmc",1,"L");
$pdf->Cell(185,2," ","T",1,"R");
$pdf->SetFont('arial','',12);
$pdf->Cell(140,7,"Celkom","$rmc",0,"L");
$pdf->SetFont('arial','B',12);

$celkomeur=$riadok->xhdd." EUR";
if( $noprice == 1 ) { $celkomeur="_ . _ EUR"; }

$pdf->Cell(45,7,"$celkomeur","0",1,"R");
$pdf->Cell(140,1," ","$rmc",0,"L");$pdf->Cell(45,1," ","T",1,"R");
$pdf->Cell(140,1," ","$rmc",0,"L");$pdf->Cell(45,1," ","T",1,"R");

$sqlfir = "SELECT * FROM ezak WHERE cuid = $kli_uzid ";
$fir_vysledok = mysql_query($sqlfir);
 if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }


$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;
$icox=$riadok->xice;


$pdf->SetFont('arial','B',10);
$pdf->Cell(185,20,"                          ","$rmc",1,"L");
$pdf->Cell(20,5,"Tel:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(60,5,"$etel","$rmc",1,"L");
$pdf->SetFont('arial','B',10);

$pdf->Cell(185,1,"                          ","$rmc",1,"L");
$pdf->Cell(20,5,"Email:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(80,5,"$email","$rmc",1,"L");
$pdf->SetFont('arial','B',10);

$pdf->Cell(185,1,"                          ","$rmc",1,"L");
$pdf->Cell(20,5,"Vystavil:","$rmc",0,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(80,5,"$ekto","$rmc",1,"L");
$pdf->Cell(185,1,"                          ","$rmc",1,"L");
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }

$pdf->SetLineWidth(0.5);
$pdf->Line(15,32,200,32);

//obdlzniky do hlavicky



$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_dodavobjtext WHERE invt = $riadok->xdok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }

$polestr2 = explode("\r\n", $poznx);

if( $polestr2[0] != ''  )
    {
$ipole=1;
foreach( $polestr2 as $hodnota ) {

if( $ipole == 1 ) { $pdf->Cell(150,2," ","$rmc",1,"L"); $pdf->Cell(150,5,"Poznámka:","$rmc",1,"L"); }

$pdf->Cell(150,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
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
       
<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
