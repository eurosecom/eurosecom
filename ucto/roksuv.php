<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 2000;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$vsetko = 1*$_REQUEST['vsetko'];
$ajtext = 1*$_REQUEST['ajtext'];

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
$strana=1;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$sql = "DROP TABLE F".$kli_vxcf."_prctopman".$kli_uzid;
$vysledok = mysql_query($sql);

$sqlt1 = <<<uctcrv
(
   cpl           int not null auto_increment,
   prx           DECIMAL(10,0) DEFAULT 0,
   ume           DECIMAL(7,4) DEFAULT 0,
   dat           DATE NOT NULL,
   uce           VARCHAR(11) NOT NULL,
   ucm           VARCHAR(11) NOT NULL,
   ucd           VARCHAR(11) NOT NULL,
   hod           DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(10,0) DEFAULT 0,
   rrd           VARCHAR(11) NOT NULL,
   ucet          VARCHAR(80) NOT NULL,
   ccx           DECIMAL(4,0) DEFAULT 0,
   ccy           DECIMAL(4,0) DEFAULT 0,
   jan           DECIMAL(10,2) DEFAULT 0,
   feb           DECIMAL(10,2) DEFAULT 0,
   mar           DECIMAL(10,2) DEFAULT 0,
   apr           DECIMAL(10,2) DEFAULT 0,
   maj           DECIMAL(10,2) DEFAULT 0,
   jun           DECIMAL(10,2) DEFAULT 0,
   jul           DECIMAL(10,2) DEFAULT 0,
   aug           DECIMAL(10,2) DEFAULT 0,
   sep           DECIMAL(10,2) DEFAULT 0,
   okt           DECIMAL(10,2) DEFAULT 0,
   nov           DECIMAL(10,2) DEFAULT 0,
   der           DECIMAL(10,2) DEFAULT 0,
   rok           DECIMAL(10,2) DEFAULT 0,
   konx4         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prctopman'.$kli_uzid.$sqlt1;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$h_obdp=1;
$h_obdk=$kli_vmes;

//daj cisla firiem
$firm1=0; $firm2=0; $firm3=0; $firm4=0; $firm5=$kli_vxcf;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm4=$fir_allx11; }

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

if( $firm4 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm4"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm3=$fir_allx11; }
}

if( $kli_vrok == 2012 ) { if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; } }
if( $kli_vrok == 2013 ) { if (File_Exists ("../pswd/oddelena2011db2012.php")) { $databaza=$mysqldb2011."."; } }
if( $kli_vrok == 2014 ) { if (File_Exists ("../pswd/oddelena2012db2013.php")) { $databaza=$mysqldb2012."."; } }

if( $firm3 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm3"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm2=$fir_allx11; }
}

if( $kli_vrok == 2013 ) { if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; } }
if( $kli_vrok == 2014 ) { if (File_Exists ("../pswd/oddelena2011db2012.php")) { $databaza=$mysqldb2011."."; } }

if( $firm2 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm2"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm1=$fir_allx11; }
}
//koniec daj cisla firiem



$lenjedenrok=1;

$rokm5=$kli_vrok;
$rokm4=$kli_vrok-1;
$rokm3=$kli_vrok-2;
$rokm2=$kli_vrok-3;
$rokm1=$kli_vrok-4;

$kli_vrokset5=$rokm5;
$kli_vrokset4=$rokm4;
$kli_vrokset3=$rokm3;
$kli_vrokset2=$rokm2;
$kli_vrokset1=$rokm1;


$xrok=$rokm5;
$kli_vxcfx=$firm5;


while( $lenjedenrok <= 5 ) {

if( $lenjedenrok == 2 ) { $xrok=$rokm4; $kli_vxcfx=$firm4; }
if( $lenjedenrok == 3 ) { $xrok=$rokm3; $kli_vxcfx=$firm3; }
if( $lenjedenrok == 4 ) { $xrok=$rokm2; $kli_vxcfx=$firm2; }
if( $lenjedenrok == 5 ) { $xrok=$rokm1; $kli_vxcfx=$firm1; }

$kli_vrok=$xrok;

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$xrok;
$dtb2 = include("../cis/oddel_dtbz1.php");
$kli_vrok=$kli_vrokx;  


$mes_obdp=$h_obdp.".".$kli_vrok;
$mes_obdk=$h_obdk.".".$kli_vrok;


$sql = "DROP TABLE F".$kli_vxcf."_prctopmanx".$kli_uzid;
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   ume           DECIMAL(7,4) DEFAULT 0,
   dat           DATE NOT NULL,
   uce           VARCHAR(8) NOT NULL,
   ucd           VARCHAR(8) NOT NULL,
   hod           DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prctopmanx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$sql = "DROP TABLE F".$kli_vxcf."_prctopmany".$kli_uzid;
$vysledok = mysql_query($sql);

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prctopmany'.$kli_uzid.$sqlt1;
$vytvor = mysql_query("$vsql");

$umeps="1.".$xrok;
$datps=$xrok."-01-01";


$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmanx$kli_uzid"." SELECT".
" '$umeps','$datps',uce,0,(pmd-pda),0 ".
" FROM ".$databaza."F$kli_vxcfx"."_uctosnova ".
" WHERE pmd != 0 OR pda != 0 ";

//echo $dsqlt;
//exit;

//$dsql = mysql_query("$dsqlt");


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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmanx$kli_uzid"." SELECT".
" ume,dat,ucm,ucd,".$databaza."F$kli_vxcfx"."_$uctovanie.hod,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_$uctovanie,".$databaza."F$kli_vxcfx"."_$doklad".
" WHERE ".$databaza."F$kli_vxcfx"."_$uctovanie.dok=".$databaza."F$kli_vxcfx"."_$doklad.dok AND ( LEFT(ucm,1) < 5 OR LEFT(ucd,1) < 5 ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmanx$kli_uzid"." SELECT".
" ume,dat,ucm,ucd,hod,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_$uctovanie".
" WHERE ( LEFT(ucm,1) < 5 OR LEFT(ucd,1) < 5 ) ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }


//vloz stranu dal
$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmanx$kli_uzid"." SELECT".
" ume,dat,ucd,0,-(hod),0 ".
" FROM F$kli_vxcf"."_prctopmanx$kli_uzid".
" WHERE konx = 0 AND LEFT(ucd,1) < 5  ";
" ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prctopmanx$kli_uzid WHERE LEFT(uce,1) >= 5 ";
$oznac = mysql_query("$sqtoz");

//exit;

//vypocitaj ume,rok z dat
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmanx$kli_uzid SET ume=MONTH(dat)+(YEAR(dat)/10000), ccx=YEAR(dat) WHERE konx = 0";
$oznac = mysql_query("$sqtoz");


if( $h_obdp > 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prctopmanx$kli_uzid  WHERE ume < $mes_obdp ";
$dsql = mysql_query("$dsqlt");
}
if( $h_obdk < 12 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prctopmanx$kli_uzid  WHERE ume > $mes_obdk ";
$dsql = mysql_query("$dsqlt");
}


//sumar za ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopmany$kli_uzid "." SELECT".
" 0,1,ume,dat,uce,0,0,SUM(hod),0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 ".
" FROM F$kli_vxcf"."_prctopmanx$kli_uzid".
" WHERE konx = 0  ".
" GROUP BY uce ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET ccx=YEAR(dat) WHERE konx = 0";
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_prctopmany$kli_uzid WHERE prx != 1 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET hod=-hod WHERE LEFT(uce,1) = 6 ";
//echo $sqtoz."<br />";
$oznac = mysql_query("$sqtoz");


/////////////////////////////////////////////nastav rrd podla uce podmienka v ucttopman


$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET rrd=uce ";
//echo $sqtoz."<br />";
$oznac = mysql_query("$sqtoz");


/////////////////////////////////////////////koniec nastav rrd

//rozdel obdobie
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET jan=hod WHERE ccx = ".$kli_vrokset1." "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET feb=hod WHERE ccx = ".$kli_vrokset2." "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET mar=hod WHERE ccx = ".$kli_vrokset3." "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET apr=hod WHERE ccx = ".$kli_vrokset4." "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prctopmany$kli_uzid SET maj=hod WHERE ccx = ".$kli_vrokset5." "; $oznac = mysql_query("$sqtoz");


//sumar za rrd
$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopman$kli_uzid "." SELECT".
" 0,0,ume,dat,uce,ucm,ucd,SUM(hod),0, ".
" rrd,'',0,0,sum(jan),sum(feb),sum(mar),sum(apr),sum(maj),sum(jun),sum(jul),sum(aug),sum(sep),sum(okt),sum(nov),sum(der),0,0 ".
" FROM F$kli_vxcf"."_prctopmany$kli_uzid".
" WHERE rrd > 0  ".
" GROUP BY rrd ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$lenjedenrok=$lenjedenrok+1;
                           }
//koniec $lenjedenrok <= 5

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prctopman$kli_uzid "." SELECT".
" 0,1,ume,dat,uce,ucm,ucd,SUM(hod),0, ".
" rrd,'',0,0,sum(jan),sum(feb),sum(mar),sum(apr),sum(maj),sum(jun),sum(jul),sum(aug),sum(sep),sum(okt),sum(nov),sum(der),0,0 ".
" FROM F$kli_vxcf"."_prctopman$kli_uzid".
" WHERE rrd > 0  ".
" GROUP BY rrd ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prctopman$kli_uzid WHERE prx != 1";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_prctopman$kli_uzid SET rok=maj ";
$oznac = mysql_query("$sqtoz");



//RRD	UCET	CCX	CCY	JAN	FEB	MAR	APR	MAJ	JUN	JUL	AUG	SEPT	OKT	NOV	DEC	ROK


?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Medziroèné súvahové úèty</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


    
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Medziroèné súvahové úèty

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
///////////////////////////////////////////////////VYTLACENIE
if( $copern == 10 )
{

if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');



$sqltt = "SELECT * FROM F$kli_vxcf"."_prctopman$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prctopman$kli_uzid".".rrd=F$kli_vxcf"."_uctosnova.uce".
" WHERE prx >= 0 ORDER BY prx,rrd ";
//echo $sqltt;



$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$strana=0;
$i=0;
$j=0;
$crrd=3;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);
$pdf->Cell(90,6,"Medziroèný stav súvahových úètov za mesiace $h_obdp. až $h_obdk. ","LTB",0,"L"); 
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',10);


$pdf->Cell(35,6,"Úèet","1",0,"L");
$pdf->Cell(35,6,"$kli_vrokset1","1",0,"R");$pdf->Cell(35,6,"$kli_vrokset2","1",0,"R");$pdf->Cell(35,6,"$kli_vrokset3","1",0,"R");
$pdf->Cell(35,6,"$kli_vrokset4","1",0,"R");$pdf->Cell(35,6,"$kli_vrokset5","1",0,"R");
$pdf->Cell(0,6,"Zostatok","1",1,"R");

     }
//koniec hlavicky j=0




$xjan=$hlavicka->jan; $jan=str_replace(".",",",$xjan); if( $xjan == 0 ) $xjan="";
$xfeb=$hlavicka->feb; $feb=str_replace(".",",",$xfeb); if( $xfeb == 0 ) $xfeb="";
$xmar=$hlavicka->mar; $mar=str_replace(".",",",$xmar); if( $xmar == 0 ) $xmar="";
$xapr=$hlavicka->apr; $apr=str_replace(".",",",$xapr); if( $xapr == 0 ) $xapr="";
$xmaj=$hlavicka->maj; $maj=str_replace(".",",",$xmaj); if( $xmaj == 0 ) $xmaj="";
$xjun=$hlavicka->jun; $jun=str_replace(".",",",$xjun); if( $xjun == 0 ) $xjun="";
$xjul=$hlavicka->jul; $jul=str_replace(".",",",$xjul); if( $xjul == 0 ) $xjul="";
$xaug=$hlavicka->aug; $aug=str_replace(".",",",$xaug); if( $xaug == 0 ) $xaug="";
$xsep=$hlavicka->sep; $sep=str_replace(".",",",$xsep); if( $xsep == 0 ) $xsep="";
$xokt=$hlavicka->okt; $okt=str_replace(".",",",$xokt); if( $xokt == 0 ) $xokt="";
$xnov=$hlavicka->nov; $nov=str_replace(".",",",$xnov); if( $xnov == 0 ) $xnov="";
$xder=$hlavicka->der; $der=str_replace(".",",",$xder); if( $xder == 0 ) $xder="";
$xrok=$hlavicka->rok; $rok=str_replace(".",",",$xrok); if( $xrok == 0 ) $xrok="";

//RRD	UCET	CCX	CCY	JAN	FEB	MAR	APR	MAJ	JUN	JUL	AUG	SEPT	OKT	NOV	DEC	ROK

if( $hlavicka->prx == 1 OR $hlavicka->prx == 11 )
{
$pdf->SetFont('arial','',9);

if( $ajtext == 1 )
  {
$pdf->Cell(0,6,"$hlavicka->nuc","0",1,"L");
$j=$j+1;
  }

$pdf->Cell(35,6,"$hlavicka->rrd","0",0,"L");
$pdf->Cell(35,6,"$xjan","0",0,"R");$pdf->Cell(35,6,"$xfeb","0",0,"R");$pdf->Cell(35,6,"$xmar","0",0,"R");
$pdf->Cell(35,6,"$xapr","0",0,"R");$pdf->Cell(35,6,"$xmaj","0",0,"R");
$pdf->Cell(0,6,"$xrok","0",1,"R");

}


}
$i = $i + 1;
$j = $j + 1;
if( $j > 25 ) $j=0;
  }



$pdf->Output("../tmp/podklad.$kli_uzid.pdf");



?>



<?php

$sql = "DROP TABLE F".$kli_vxcf."_prctopman".$kli_uzid;
$vysledok = mysql_query($sql);
$sql = "DROP TABLE F".$kli_vxcf."_prctopmany".$kli_uzid;
$vysledok = mysql_query($sql);

$sql = "DROP TABLE F".$kli_vxcf."_prctopmanx".$kli_uzid;
$vysledok = mysql_query($sql);

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php


}
///////////////////////////////////////////////////KONIEC TLAC
?>





<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
