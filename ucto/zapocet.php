<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//vytlacit zapocet

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = $_REQUEST['cislo_dok'];
$cislo_fak = $_REQUEST['cislo_fak'];
$cislo_ico = $_REQUEST['cislo_ico'];
$h_uce = $_REQUEST['h_uce'];
$posem = 1*$_REQUEST['posem'];
$h_pen = 1*$_REQUEST['h_pen'];
$h_ppe = 1*$_REQUEST['h_ppe'];
$vseob = 1*$_REQUEST['vseob'];

//echo $h_pen." ppe".$h_ppe;
//exit;

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$ekorobot=0;
if( $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" )
{
$ekorobot=1;
}


$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$sqltt = "DROP TABLE F".$kli_vxcf."_prcvzp".$kli_uzid;
$sql = mysql_query("$sqltt");

$sqlt = <<<uctskl
(
   dat         DATE,
   dasx         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   hodx         DECIMAL(10,2),
   hoz         DECIMAL(10,2),
   ico         INT(10),
   fak         DECIMAL(10,0)
);
uctskl;

$sqltt = "CREATE TABLE F".$kli_vxcf."_prcvzp".$kli_uzid.$sqlt;
$sql = mysql_query("$sqltt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvzp".$kli_uzid.
" SELECT F$kli_vxcf"."_uctvsdh.dat,'0000-00-00',F$kli_vxcf"."_uctvsdp.dok,0,0,ucm,ucd,".
"0,F$kli_vxcf"."_uctvsdp.hod,F$kli_vxcf"."_uctvsdp.ico,F$kli_vxcf"."_uctvsdp.fak ".
" FROM F$kli_vxcf"."_uctvsdh,F$kli_vxcf"."_uctvsdp ".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND F$kli_vxcf"."_uctvsdp.dok=$vseob ".
" ORDER BY ucd".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid." SET poh=1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid." SET poh=992 WHERE LEFT(ucm,3) = 321";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid." SET poh=992 WHERE LEFT(ucm,3) = 325";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid.",F$kli_vxcf"."_fakodb SET ".
" hodx=hod, dasx=das ".
" WHERE F$kli_vxcf"."_prcvzp".$kli_uzid.".ico=F$kli_vxcf"."_fakodb.ico AND F$kli_vxcf"."_prcvzp".$kli_uzid.".fak=F$kli_vxcf"."_fakodb.fak ".
" AND F$kli_vxcf"."_prcvzp".$kli_uzid.".poh=1 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid.",F$kli_vxcf"."_fakdod SET ".
" hodx=hod, dasx=das ".
" WHERE F$kli_vxcf"."_prcvzp".$kli_uzid.".ico=F$kli_vxcf"."_fakdod.ico AND F$kli_vxcf"."_prcvzp".$kli_uzid.".fak=F$kli_vxcf"."_fakdod.fak ".
" AND F$kli_vxcf"."_prcvzp".$kli_uzid.".poh=992 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid.",F$kli_vxcf"."_fakodbpoc SET ".
" hodx=hod, dasx=das ".
" WHERE F$kli_vxcf"."_prcvzp".$kli_uzid.".ico=F$kli_vxcf"."_fakodbpoc.ico AND F$kli_vxcf"."_prcvzp".$kli_uzid.".fak=F$kli_vxcf"."_fakodbpoc.fak ".
" AND F$kli_vxcf"."_prcvzp".$kli_uzid.".poh=1 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcvzp".$kli_uzid.",F$kli_vxcf"."_fakdodpoc SET ".
" hodx=hod, dasx=das ".
" WHERE F$kli_vxcf"."_prcvzp".$kli_uzid.".ico=F$kli_vxcf"."_fakdodpoc.ico AND F$kli_vxcf"."_prcvzp".$kli_uzid.".fak=F$kli_vxcf"."_fakdodpoc.fak ".
" AND F$kli_vxcf"."_prcvzp".$kli_uzid.".poh=992 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvzp".$kli_uzid.
" SELECT dat,dasx,0,991,0,0,0,SUM(hodx),SUM(hoz),0,0 FROM F$kli_vxcf"."_prcvzp".$kli_uzid." WHERE poh = 1 GROUP BY poh";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvzp".$kli_uzid.
" SELECT dat,dasx,0,997,0,0,0,0,SUM(hoz),0,0 FROM F$kli_vxcf"."_prcvzp".$kli_uzid." WHERE poh = 992 GROUP BY poh";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvzp".$kli_uzid.
" SELECT dat,dasx,0,1997,0,0,0,-(SUM(hodx)),-(SUM(hoz)),0,0 FROM F$kli_vxcf"."_prcvzp".$kli_uzid." WHERE poh = 992 GROUP BY poh";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvzp".$kli_uzid.
" SELECT dat,dasx,0,999,0,0,0,SUM(hodx),SUM(hoz),0,0 FROM F$kli_vxcf"."_prcvzp".$kli_uzid." WHERE poh = 991 OR poh = 1997 GROUP BY dok";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcvzp".$kli_uzid." WHERE poh=1997 ";
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/upom$cislo_dok.$kli_uzid.pdf")) { $soubor = unlink("../tmp/upom$cislo_dok.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sety=10;
$pdf->SetY($sety);



//zaciatok vypisu poloziek
$tabl="fakodb";
$uctpol="prcvzp".$kli_uzid;

$dnes_sql=SqlDatum($dnes);

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh WHERE dok=$vseob");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datum=$riaddok->dat;
  }
$datum_sk=SkDatum($datum);

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE poh >= 0 ".
" ORDER BY poh,F$kli_vxcf"."_$uctpol.fak";
//echo $tovtt;

//exit;

//////////////////////////////////////////////////////ak nie je email
if ( $posem != 1 )
          {

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
$koniec=$tvpol-1;
if( $tvpol > 0 ) $jetovar=1;
$jednapolozka=0;
if( $tvpol == 1 ) $jednapolozka=1;

//Ak su polozky
if( $jetovar == 1 )
           {
$j=0;
$i=0;
$suzavazky=0;
$koniecpohladavky=0;
$zaciatokzavazky=1;

  while ($i <= $koniec )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == "00.00.0000" ) $dat_sk="";
$dasx_sk=SkDatum($rtov->dasx);
if( $dasx_sk == "00.00.0000" ) $dasx_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

if( $j == 0 )
    {
$celkomstrana=0;

//register a zastupena protistrana
$regproti="";
$zasproti="";
$jepozn=0;
$rozsirenieico="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_icorozsirenie WHERE ico = $rtov->ico ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozsirenieico=$riaddok->pozn;
  $jepozn=1;
  }

$pole = explode("\r", $rozsirenieico );

if( $jepozn != 0 )
{

$ipole=1;
foreach( $pole as $hodnota ) {

$hodnota=str_replace("\n","",$hodnota);

$hodnota9=substr($hodnota,0,9);
$hodnota10=substr($hodnota,0,10);

//echo $hodnota." ".$hodnota10."<br />"; 

if( $hodnota10 == "zastúpená:" ) { $zasproti=trim(substr($hodnota,10,30)); }
if( $hodnota9 == "Register:" ) { $regproti=trim(substr($hodnota,9,60)); }

$ipole=$ipole+1;
                             }
//exit;
}
//koniec register a zastupena protistrana



if( $i > 0 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);

$sety=10;
$pdf->SetY($sety);
}


$pdf->SetFont('arial','',12);

if( $h_pen != 1 )
     {
$pdf->Cell(180,6,"D o h o d a ","0",1,"C");
$pdf->Cell(180,6,"o vzájomnom zapoèítaní poh¾adávok a záväzkov","0",1,"C");
$pdf->Cell(180,6,"v zmysle § 364 Obchodného zákonníka a násl.","0",1,"C");

$pdf->SetFont('arial','',10);

$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(180,5,"$fir_fmes dòa: $datum_sk     ","0",1,"L");

$pdf->Cell(180,2,"     ","0",1,"L");

$pdf->Cell(180,5,"Zmluvné strany:","0",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");

$pdf->Cell(90,6,"$fir_fnaz          ","0",0,"L");$pdf->Cell(180,6,"$rtov->nai $rtov->na2","0",1,"L");
$pdf->Cell(90,6,"$fir_fuli $fir_fcdm","0",0,"L");$pdf->Cell(180,6,"$rtov->uli","0",1,"L");
$pdf->Cell(90,6,"$fir_fpsc $fir_fmes","0",0,"L");$pdf->Cell(180,6,"$rtov->psc $rtov->mes","0",1,"L");
$pdf->Cell(180,2,"     ","0",1,"L");
$pdf->Cell(90,6,"IÈO: $fir_fico          ","0",0,"L");$pdf->Cell(180,6,"IÈO: $rtov->ico","0",1,"L");
if( $ekorobot == 1 ) { $pdf->Cell(90,6,"DIÈ: $fir_fdic          ","0",0,"L");$pdf->Cell(180,6,"DIÈ: $rtov->dic","0",1,"L"); }
$pdf->Cell(180,5,"     ","0",1,"L");
$pdf->Cell(90,6,"zastúpená: $fir_uctt05","0",0,"L");$pdf->Cell(180,6,"zastúpená: $zasproti","0",1,"L");
$pdf->SetFont('arial','',9);$pdf->Cell(90,6,"Register: $fir_obreg","0",0,"L");$pdf->Cell(180,6,"Register: $regproti","0",1,"L");
$pdf->SetFont('arial','',10);

$rtovnai=$rtov->nai;
     }


//pred polozkami
if( $h_pen != 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_vzpp=$riaddok->vzpp;
  $h_vzpz=$riaddok->vzpz;
  }

$pole = explode("\r", $h_vzpp);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,2,"  ","0",1,"R");
}
     }
//koniec zapocet pred polozkami


$pdf->Cell(30,6,"POH¼ADÁVKY","B",0,"L");
$pdf->Cell(30,6,"Faktúra","B",0,"R");$pdf->Cell(30,6,"Splatná","B",0,"L");$pdf->Cell(10,6," ","B",0,"L");
$pdf->Cell(30,6,"Hodnota faktúry","B",0,"R");
$pdf->Cell(40,6,"Suma k zápoètu Eur","B",1,"R");

}
//koniec if j=0


if( $rtov->poh == 1 )
     {
$pdf->Cell(30,6," ","0",0,"R");$pdf->Cell(30,6,"$rtov->fak","0",0,"R");$pdf->Cell(30,6,"$dasx_sk","0",0,"L");$pdf->Cell(10,6," ","0",0,"L");
$pdf->Cell(30,6,"$rtov->hodx","0",0,"R");
$pdf->Cell(40,6,"$rtov->hoz","0",1,"R");
     }

if( $rtov->poh == 991 )
     {
$pdf->Cell(100,6,"SPOLU poh¾adávky k zápoètu: ","T",0,"L");
$pdf->Cell(30,6," ","T",0,"R");$pdf->Cell(40,6,"$rtov->hoz","T",1,"R");
$koniecpohladavky=1;
     }

if( $rtov->poh == 992 )
     {

if( $zaciatokzavazky == 1 )
          {
$pdf->Cell(0,2,"  ","0",1,"R");

$pdf->Cell(30,6,"ZÁVäZKY","B",0,"L");
$pdf->Cell(30,6,"Faktúra","B",0,"R");$pdf->Cell(30,6,"Splatná","B",0,"L");$pdf->Cell(10,6," ","B",0,"L");
$pdf->Cell(30,6,"Hodnota faktúry","B",0,"R");
$pdf->Cell(40,6,"Suma k zápoètu Eur","B",1,"R");
$zaciatokzavazky=0;
          }

$pdf->Cell(30,6," ","0",0,"R");$pdf->Cell(30,6,"$rtov->fak","0",0,"R");$pdf->Cell(30,6,"$dasx_sk","0",0,"L");$pdf->Cell(10,6," ","0",0,"L");
$pdf->Cell(30,6,"$rtov->hodx","0",0,"R");
$pdf->Cell(40,6,"$rtov->hoz","0",1,"R");
$suzavazky=1;
     }

if( $rtov->poh == 997 AND $suzavazky == 1 )
     {
$pdf->Cell(100,6,"SPOLU záväzky k zápoètu: ","T",0,"L");
$pdf->Cell(30,6," ","T",0,"R");$pdf->Cell(40,6,"$rtov->hoz","T",1,"R");
     }

if( $rtov->poh == 999 )
     {
if( $ekorobot == 0 ) { 
$pdf->Cell(0,2,"  ","0",1,"R");
$pdf->SetFont('arial','',12);
$pdf->Cell(170,6,"Rozdiel vo výške : $rtov->hoz Eur","1",1,"L");
                                        }

if( $ekorobot == 1 AND $rtov->hodx != 0 AND $rtov->hoz != 0 ) { 
$pdf->Cell(0,2,"  ","0",1,"R");
$pdf->SetFont('arial','',12);
$pdf->Cell(170,6,"Rozdiel vo výške : $rtov->hodx Eur","1",1,"L");
                                        }


     }

}
$i = $i + 1;
$j = $j + 1;

//if( $j == 8 ) { $j=0; }

  }
//koniec while
           }
//koniec ak su polozky

$pdf->SetFont('arial','',10);
//zapocet za polozkami
if( $h_pen != 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$pole = explode("\r", $h_vzpz);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,6,"  ","0",1,"R");
}
     }
//koniec zapocet za polozkami

$poziciay=$pdf->GetY();
if( $poziciay < 254 ) $pdf->SetY(254);

$pdf->Cell(180,8,"      ","0",1,"L");
$pdf->Cell(60,6,"za $fir_fnaz          ","T",0,"L");$pdf->Cell(30,6," ","0",0,"L");
$pdf->Cell(60,6,"za $rtovnai","T",0,"L");$pdf->Cell(30,6," ","0",1,"L");


$pdf->Output("../tmp/upom$cislo_dok.$kli_uzid.pdf")


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/upom<?php echo $cislo_dok; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php 
//////////////////////////////////////////////////////ak nie je email
          }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zápoèet PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Zápoèet</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

$sqltt = "DROP TABLE F".$kli_vxcf."_prcvzp".$kli_uzid;
//$sql = mysql_query("$sqltt");

?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
