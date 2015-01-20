<HTML>
<?php
$sys = 'HIM';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uprav = 1*$_REQUEST['uprav'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];



?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Účtovanie majetku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

  
</script>
</HEAD>
<BODY class="white" id="white"  >


<?php
//zostava zauctovania za doklad
  if ( $copern == 361 )
          {
$nazsub="zauctovanie";


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   hod         DECIMAL(10,2),
   ucm         VARCHAR(10),
   ucd         VARCHAR(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc3'.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_uctmaj ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";

$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,SUM(hod),ucm,ucd FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY dok,ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 2,ume,dat,dok,ico,fak,str,zak,SUM(hod),ucm,ucd FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY dru".
"";
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/$nazsub.pdf")) { $soubor = unlink("../tmp/$nazsub.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY dru,dok,ucm,ucd,str,zak";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

  if ( $j == 0 )
  {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY dru,dok,ucm,ucd,str,zak";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);


  if ( $drupoh == 2 ) { $pdf->Cell(140,5,"Zaúčtovanie podsystému Dlhodobý majetok","0",0,"L"); }

$pdf->Cell(100,5,"ume $h_obdp.$kli_vrok / $h_obdk.$kli_vrok $kli_nxcf strana.$strana ","0",1,"R");
$pdf->Cell(20,5,"Úč.mes.","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(25,5,"Doklad","1",0,"R");
$pdf->Cell(25,5,"Účet Mádať","1",0,"R");$pdf->Cell(25,5,"Účet Dal","1",0,"R");
$pdf->Cell(25,5,"IČO","1",0,"R");$pdf->Cell(25,5,"faktúra","1",0,"R");$pdf->Cell(25,5,"STR","1",0,"R");$pdf->Cell(25,5,"ZÁK","1",0,"R");
$pdf->Cell(30,5,"Hodnota","1",1,"R");

$strana=$strana+1;
$pdf->SetFont('arial','',8);

  }
//koniec j=0

  if ( $rtov->dru == 1 )
  {
$pdf->Cell(20,5,"$rtov->ume","0",0,"R");$pdf->Cell(20,5,"$rtov->dat","0",0,"R");$pdf->Cell(25,5,"$rtov->dok","0",0,"R");
$pdf->Cell(25,5,"$rtov->ucm","0",0,"R");$pdf->Cell(25,5,"$rtov->ucd","0",0,"R");
$pdf->Cell(25,5,"$rtov->ico","0",0,"R");$pdf->Cell(25,5,"$rtov->fak","0",0,"R");$pdf->Cell(25,5,"$rtov->str","0",0,"R");$pdf->Cell(25,5,"$rtov->zak","0",0,"R");
$pdf->Cell(30,5,"$rtov->hod","0",1,"R");
  }

  if ( $rtov->dru == 2 )
  {
$pdf->Cell(215,5,"CELKOM všetky doklady","1",0,"R");
$pdf->Cell(30,5,"$rtov->hod","1",1,"R");
  }

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;

  }

$pdf->Cell(30,5," ","0",1,"R");
$pdf->Cell(40,7,"Zaúčtoval:","1",0,"R");$pdf->Cell(40,7," ","1",0,"R");
$pdf->Cell(40,7,"Schválil:","1",0,"R");$pdf->Cell(40,7," ","1",1,"R");

$pdf->Output("../tmp/$nazsub.pdf");

//koniec zauctovanie za doklad
          }




  if ( $copern == 361 OR $copern == 362 )
          {
?>

<script type="text/javascript">
  var okno = window.open("../tmp/<?php echo $nazsub; ?>.pdf","_self");
</script>

<?php
          }
//koniec rozuctovania 


// celkovy koniec dokumentu
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");



       } while (false);
?>
</BODY>
</HTML>
