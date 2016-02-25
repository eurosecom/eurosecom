<HTML>
<?php
$sys = 'HIM';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


$h_trd = 1*$_REQUEST['h_trd'];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $drupoh == 1 )
{
$tabl = "majmaj";
}


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


//tlac inventura
if( $copern == 10 )
{


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprcospo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprxospo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   pol          INT,
   druh         INT(2),
   drm          INT(7),
   inv          DECIMAL(15,0),
   naz          VARCHAR(40),
   zar          DATE,
   rzv          INT(4),
   str          INT,
   zak          INT,
   cen          DECIMAL(12,2),
   ops          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   ros          DECIMAL(12,2),
   cend          DECIMAL(12,2),
   opsd          DECIMAL(12,2),
   zosd          DECIMAL(12,2),
   rosd          DECIMAL(12,2),
   ceneu          DECIMAL(12,2),
   opseu          DECIMAL(12,2),
   zoseu          DECIMAL(12,2),
   roseu          DECIMAL(12,2),
   censr          DECIMAL(12,2),
   opssr          DECIMAL(12,2),
   zossr          DECIMAL(12,2),
   rossr          DECIMAL(12,2),
   spo          INT,
   sku          INT,
   perc         DECIMAL(10,2),
   meso         DECIMAL(10,2),
   zosux          DECIMAL(12,2),
   rosux          DECIMAL(12,2),
   zosdx          DECIMAL(12,2),
   rosdx          DECIMAL(12,2)
)
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprcospo'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprxospo'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$zar1=$kli_vrok."-01-01";
$zar2=$kli_vrok."-12-31";


if( $drupoh == 1 )
{

          $vyslettt = "SELECT * FROM F$kli_vxcf"."_majtextmaj WHERE invt > 0 AND ospo > 0 ORDER BY invt ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {
          //zaciatok cyklu

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcospo$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen_dan,(ops_dan+hd5),0,hd5,0,0,0,0,0,0,0,0,0,0,0,0,spo_dan,sku_dan,'$riadok->ospo',0,0,0,0,0 ".
" FROM F$kli_vxcf"."_$tabl WHERE inv = $riadok->invt ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt."<br />";

          }
          //koniec cyklu         

}

$dsqlt = "UPDATE F$kli_vxcf"."_zozprcospo$kli_uzid SET zos=cen-ops WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprcospo$kli_uzid SET zosd=zos, cend=cen, opsd=ops, rosd=ros WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");


//pomerna z majtextmaj

$dsqlt = "UPDATE F$kli_vxcf"."_zozprcospo$kli_uzid SET rosdx=(100-perc)*rosd/100 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_zozprcospo$kli_uzid SET zosdx=rosd-rosdx ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_zozprcospo$kli_uzid  SET druh=1 ";
$dsql = mysql_query("$dsqlt");


//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprxospo$kli_uzid ".
" SELECT SUM(pol),999,9999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),SUM(ros),SUM(cend),SUM(opsd),SUM(zosd),SUM(rosd),".
"SUM(ceneu),SUM(opseu),SUM(zoseu),SUM(roseu),SUM(censr),SUM(opssr),SUM(zossr),SUM(rossr),spo,sku,perc,meso,SUM(zosux),SUM(rosux),SUM(zosdx),SUM(rosdx) ".
" FROM F$kli_vxcf"."_zozprcospo$kli_uzid WHERE druh = 1".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprcospo$kli_uzid".
" SELECT pol,druh,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,ros,cend,opsd,zosd,rosd,".
" ceneu,opseu,zoseu,roseu,censr,opssr,zossr,rossr,spo,sku,perc,meso,zosux,rosux,zosdx,rosdx".
" FROM F$kli_vxcf"."_zozprxospo$kli_uzid".
"";
$dsql = mysql_query("$dsqlt");

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/invmaj_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/invmaj_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$strana=0;


if( $h_trd == 0 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprcospo$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_majtextmaj".
" ON F$kli_vxcf"."_zozprcospo$kli_uzid.inv=F$kli_vxcf"."_majtextmaj.invt".
" WHERE inv >= 0 ORDER BY druh,inv";
}



//echo $sqltt;
$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$j=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_zar = SkDatum($rtov->zar);


//nova strana j=0
if( $j == 0 )
{
if( $i > 0 ) { $pdf->Cell(180,0," ","T",1,"R"); }

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
$strana=$strana+1;


if( $drupoh == 1 )
{
$pdf->Cell(80,5,"Zostava Osobnej spotreby daòových odpisov majetku ","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

$pdf->SetFont('arial','',6);
$pdf->Cell(20,5,"Inv.è.","1",0,"R");$pdf->Cell(63,5,"Popis","1",0,"L");
$pdf->Cell(30,5,"Cena obstarania","1",0,"R");$pdf->Cell(30,5,"Oprávky","1",0,"R");$pdf->Cell(30,5,"Zostatková cena","1",0,"R");
$pdf->SetFont('arial','',5);
$pdf->Cell(30,5,"Roèný odpis Celý","1",0,"R");$pdf->Cell(30,5,"Roèný odpis Uplatnená èas","1",0,"R");
$pdf->Cell(30,5,"Roèný odpis Neuplatnená èas","1",0,"R");
$pdf->Cell(0,5," ","RTB",1,"L");
$pdf->SetFont('arial','',7);
}
//koniec j=0


if ( $rtov->druh == 1 )
{
$pdf->Cell(20,4,"$rtov->inv","T",0,"R");$pdf->Cell(80,4,"$rtov->naz","T",0,"L");

$pdf->Cell(14,4,"zaradené:","T",0,"L");$pdf->Cell(14,4,"$sk_zar","T",0,"L");
$pdf->Cell(20,4,"% osobnej spotreby:","T",0,"L");$pdf->Cell(14,4,"$rtov->perc","T",0,"R");
$pdf->Cell(0,4," ","0",1,"L");



$pdf->Cell(78,4,"daòové odpisy","0",0,"L");
$pdf->Cell(5,4," ","0",0,"L");
$pdf->Cell(30,4,"$rtov->cend","0",0,"R");$pdf->Cell(30,4,"$rtov->opsd","0",0,"R");$pdf->Cell(30,4,"$rtov->zosd","0",0,"R");
$pdf->Cell(30,4,"$rtov->rosd","0",0,"R");$pdf->Cell(30,4,"$rtov->rosdx","0",0,"R");$pdf->Cell(30,4,"$rtov->zosdx","0",1,"R");

}



if ( $rtov->druh == 999 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(0,1," ","T",1,"L");
$pdf->Cell(0,4," ","T",1,"L");


$pdf->Cell(78,4,"SPOLU daòové odpisy","0",0,"L");
$pdf->Cell(5,4," ","0",0,"L");
$pdf->Cell(30,4,"$rtov->cend","0",0,"R");$pdf->Cell(30,4,"$rtov->opsd","0",0,"R");$pdf->Cell(30,4,"$rtov->zosd","0",0,"R");
$pdf->Cell(30,4,"$rtov->rosd","0",0,"R");$pdf->Cell(30,4,"$rtov->rosdx","0",0,"R");$pdf->Cell(30,4,"$rtov->zosdx","0",1,"R");

$pdf->SetFont('arial','',7);
}



}
$i = $i + 1;
$j = $j + 1;
if( $j > 64 ) $j=0;
  }

$pdf->Cell(0,10," ","0",1,"R");



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprcospo'.$kli_uzid;
if( $kli_vmes != 12 ) { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprxospo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$koniec=184;
$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec); 
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vytlaèil(a): $kli_uzmeno $kli_uzprie / $kli_uzid ","0",1,"L");



$pdf->Output("$outfilex");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
//koniec tlac inventura
}
?>




<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Inventúra majetku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;


    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Inventúra MAJETKU</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />




<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
