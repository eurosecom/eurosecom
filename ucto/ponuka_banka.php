<HTML>
<?php
//VYTLACI POMOC PRI UHRADACH BANKOVE UCTY ALEBO SALDO PODLA HODNOTY ALEBO SALDO ZA ICO
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
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
$vsetko=0;
if( $copern == 13 ) { $copern=10; $vsetko=0; $sumico = 0; $h_obd=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$h_uce = 31100;
$h_ucm = 1*$_REQUEST['h_ucm'];
$h_ucd = 1*$_REQUEST['h_ucd'];
$h_ico = 1*$_REQUEST['h_ico'];
$h_hop = 1*$_REQUEST['h_hop'];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/ponban_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/ponban_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $copern == 10 ) { 

$h_ucm2=substr($h_ucm,0,2);
$h_ucd2=substr($h_ucd,0,2);
if( $h_ucd2 == 31 OR $h_ucd2 == 32 ) $h_uce=$h_ucd; 
if( $h_ucm2 == 31 OR $h_ucm2 == 32 ) $h_uce=$h_ucm; 


$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofak".$kli_uzid;

$strana=1;
//zaciatok vypisu tovaru


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE uce = $h_uce AND F$kli_vxcf"."_$uctpol.ico = $h_ico".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,fak";

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 ) { $pdf->Cell(90,5,"Saldokonto nespárované","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Všetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="Poèiatoèný stav";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"Úèet: $h_uce","0",1,"L");

$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystavená","1",0,"L");$pdf->Cell(20,4,"Splatná","1",0,"L");
$pdf->Cell(20,4,"Faktúra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"Uhradené","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");

$pdf->Cell(90,4,"IÈO: $rtov->ico, $rtov->nai, $rtov->mes","0",1,"L");

if( $sumico == 1 ) $j=1;
      }
//koniec j=0

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$poz=$rtov->poz;
if( $alchem == 1 AND $rtov->poz == '(55)odber. faktúra' ) $poz="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";


$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");$pdf->Cell(20,4,"$das_sk","0",0,"L");
$pdf->Cell(20,4,"$rtov->fak","0",0,"R");
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");


}
$i = $i + 1;
$j = $j + 1;

  }

           }
//koniec ak je tovar


}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec copern == 10

///////////////////////////////////////////////////////bankove ucty
if ( $copern == 11 ) { 

$strana=1;
//zaciatok vypisu tovaru


$tovtt = "SELECT * FROM F$kli_vxcf"."_ico".
" ORDER BY nai,ico";

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',8);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(90,5,"Bankové úèty","LTB",0,"L"); 
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$pdf->Cell(95,4,"Firma","1",0,"L");$pdf->Cell(0,4,"Bankové úèty","1",1,"L");

      }
//koniec j=0


$pdf->Cell(95,4,"$rtov->ico, $rtov->nai, $rtov->mes","B",0,"L");

$pdf->Cell(30,4,"$rtov->uc1 / $rtov->nm1 ","B",0,"L");
$pdf->Cell(30,4,"$rtov->uc2 / $rtov->nm2 ","B",0,"L");
$pdf->Cell(30,4,"$rtov->uc3 / $rtov->nm3 ","B",0,"L");
$pdf->Cell(0,4," ","B",1,"L");
}
$i = $i + 1;
$j = $j + 1;

  }

           }
//koniec ak je tovar


}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec copern == 11 banky

///////////////////////////////////////////////////////hodnoty
if ( $copern == 12 ) { 

$strana=1;
//zaciatok vypisu tovaru


$h_ucm2=substr($h_ucm,0,2);
$h_ucd2=substr($h_ucd,0,2);
if( $h_ucd2 == 31 OR $h_ucd2 == 32 ) $h_uce=$h_ucd; 
if( $h_ucm2 == 31 OR $h_ucm2 == 32 ) $h_uce=$h_ucm; 

$podmhop=" AND zos != 0";
if( $h_hop != 0 ) { $h_hop1=$h_hop-100; $h_hop2=$h_hop+100; $podmhop=" AND ( zos != 0 AND zos >= ".$h_hop1." AND zos <= ".$h_hop2." ) ";  }

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofak".$kli_uzid;

$strana=1;
//zaciatok vypisu tovaru


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE uce = $h_uce $podmhop".
" ORDER BY zos";

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',8);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(90,5,"Faktúry zoradené pod¾a hodnoty","LTB",0,"L"); 
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$pdf->Cell(95,4,"Firma","1",0,"L");$pdf->Cell(30,4,"Faktúra","1",0,"R");$pdf->Cell(30,4,"Hodnota","1",0,"R");$pdf->Cell(30,4,"Zostatok","1",1,"R");

      }
//koniec j=0


$pdf->Cell(95,4,"$rtov->ico, $rtov->nai, $rtov->mes","B",0,"L");
$pdf->Cell(30,4,"$rtov->fak","B",0,"R");$pdf->Cell(30,4,"$rtov->hod","B",0,"R");$pdf->Cell(30,4,"$rtov->zos","B",0,"R");

$pdf->Cell(0,4," ","0",1,"L");
}
$i = $i + 1;
$j = $j + 1;

  }

           }
//koniec ak je tovar


}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec copern == 12 hodnoty

if( $nulovazostava == 1 )
{
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 0 ) { $pdf->Cell(90,5,"Saldokonto dolehotné","LTB",0,"L"); }
if( $vsetko == 0 AND $pol == 1 ) { $pdf->Cell(90,5,"Saldokonto polehotné","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(105,4,"Prázdna zostava","0",1,"R");

}



$pdf->Output("$outfilex");


?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Ponuka BU</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Saldokonto PDF formát</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesproz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}

?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
