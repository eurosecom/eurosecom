<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if ( !isset($kli_vxcf) ) $kli_vxcf = 1;
do
{
require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = $_REQUEST['cislo_dok'];
//stlpec doplnujuci text
$ajtext = 1*$_REQUEST['ajtext'];


$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/priku_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/priku_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');


if ( $ajtext == 0 ) { $pdf=new FPDF("P","mm","A4"); }
if ( $ajtext == 1 ) { $pdf=new FPDF("L","mm","A4"); }


$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(15);
$pdf->SetTopMargin(15); 

$sety=10;
$pdf->SetY($sety);

if ( $drupoh == 1 )
{
$tabl = "uctpriku";
$uctpol = "uctprikp";
}

if ( $copern == 20 AND $drupoh == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN klienti".
" ON F$kli_vxcf"."_$tabl.id=klienti.id_klienta".
" LEFT JOIN F$kli_vxcf"."_dban".
" ON F$kli_vxcf"."_$tabl.uce=F$kli_vxcf"."_dban.dban".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");
}
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);
if ( $dat_sk == "00.00.0000" ) $dat_sk="";

//zaciatok vypisu poloziek
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" WHERE F$kli_vxcf"."_$uctpol.dok = $cislo_dok ".
" ORDER BY cpl";
//echo $tovtt;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
$koniec=$tvpol-1;
if ( $tvpol > 0 ) $jetovar=1;
$jednapolozka=0;
if ( $tvpol == 1 ) $jednapolozka=1;

//Ak su polozky
if ( $jetovar == 1 )
     {
$j=0;
$i=0;
  while ( $i <= $koniec )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if ( $j == 0 )
{
$celkomstrana=0;

if ( $i > 0 ) //dopyt nechápem podmienku, keï mám vyššie nastavené parametre
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$sety=10;
$pdf->SetY($sety);
}
//NADPIS
//nazov banky
$pdf->SetFont('arial','',14);
$pdf->Cell(70,6,"$hlavicka->nban","0",0,"L");
//druh prikazu
if ( $ajtext == 0 ) { $sirka_nadpis="110"; }
if ( $ajtext == 1 ) { $sirka_nadpis="0"; }
$pdf->SetFont('arial','',12);
if ( $jednapolozka != 1 ) $pdf->Cell($sirka_nadpis,5,"Hromadný príkaz na úhradu","0",1,"R");
if ( $jednapolozka == 1 ) $pdf->Cell($sirka_nadpis,5,"Príkaz na úhradu","0",1,"R");
$pdf->Cell(70,6," ","0",0,"L");
if ( $jednapolozka != 1 ) $pdf->Cell($sirka_nadpis,5,"Bulk Payment Order","0",1,"R");
if ( $jednapolozka == 1 ) $pdf->Cell($sirka_nadpis,5,"Payment Order","0",1,"R");
$pdf->SetFont('arial','',9);

//ZAHLAVIE
$pdf->Cell(180,5," ","0",1,"L");
$pdf->Cell(82,7,"IBAN - BIC platite¾a / Payer´s IBAN - BIC","1",0,"C");$pdf->Cell(26,3.5,"Celková suma","T",0,"C");
$pdf->Cell(20,3.5,"Mena","LT",0,"C");$pdf->Cell(28,3.5,"Dátum splatnosti","LTR",1,"C");
$pdf->Cell(82,0," ","0",0,"C");$pdf->Cell(26,3.5,"Total Amount","R",0,"C");$pdf->Cell(20,3.5,"Currency ","0",0,"C");$pdf->Cell(28,3.5,"Due Date","LR",1,"C");
$pdf->SetFont('arial','',10);
$pdf->Cell(82,7,"$hlavicka->iban - $hlavicka->twib","1",0,"C");$pdf->Cell(26,7," ","1",0,"C");$pdf->Cell(20,7,"$hlavicka->mena","1",0,"C");$pdf->Cell(28,7,"$dat_sk","1",1,"C");
$pdf->SetFont('arial','',9);

//POLOZKY
$pdf->Cell(180,3," ","0",1,"L");
//zahlavie poloziek
if ( $ajtext == 0 ) {
$pdf->Cell(56,7,"IBAN príjemcu / Beneficiary´s IBAN","LTR",0,"C");$pdf->Cell(26,3.5,"BIC príjemcu","RT",0,"C");
$pdf->Cell(26,7,"Suma / Amount","LT",0,"C");$pdf->Cell(24,3.5,"Variabilný sym.","LT",0,"C");
$pdf->Cell(24,3.5,"Špecifický sym.","LT",0,"C");$pdf->Cell(24,3.5,"Konštantný sym.","LTR",1,"C");
$pdf->Cell(56,0," ","0",0,"C");$pdf->Cell(26,3.5,"Beneficiary´s BIC","RB",0,"C");$pdf->Cell(26,0," ","0",0,"C");
$pdf->Cell(24,3.5,"Variable sym.","L",0,"C");$pdf->Cell(24,3.5,"Specific sym.","L",0,"C");
$pdf->Cell(24,3.5,"Constant sym.","LR",1,"C");
                    }
if ( $ajtext == 1 ) {
$pdf->Cell(53,7,"IBAN príjemcu / Beneficiary´s IBAN","LTRB",0,"C");$pdf->Cell(29,3.5,"BIC príjemcu","RT",0,"C");
$pdf->Cell(26,7,"Suma / Amount","LTB",0,"C");$pdf->Cell(26,3.5,"Variabilný sym.","LT",0,"C");
$pdf->Cell(26,3.5,"Špecifický sym.","LT",0,"C");$pdf->Cell(26,3.5,"Konštantný sym.","LTR",0,"C");
$pdf->Cell(0,7,"Doplòujúci text / Remittance information","LTRB",1,"C");
$pdf->Cell(180,-3.5," ","0",1,"L");
$pdf->Cell(53,0," ","0",0,"C");$pdf->Cell(29,3.5,"Beneficiary´s BIC","RB",0,"C");$pdf->Cell(26,0," ","0",0,"C");
$pdf->Cell(26,3.5,"Variable sym.","LB",0,"C");$pdf->Cell(26,3.5,"Specific sym.","LB",0,"C");
$pdf->Cell(26,3.5,"Constant sym.","LRB",0,"C");$pdf->Cell(0,0," ","",1,"C");
$pdf->Cell(180,3.5," ","0",1,"L");
                    }
}
$celkomstrana=$celkomstrana+$rtov->hodm;
$Cislo=$celkomstrana+"";
$Hcelkomstrana=sprintf("%0.2f", $Cislo);


$twib=trim($rtov->twib);

if ( $ajtext == 0 )
     {
$pdf->Cell(56,6,"$rtov->iban","1",0,"L");$pdf->Cell(26,6,"$rtov->pbic","B",0,"C");$pdf->Cell(26,6,"$rtov->hodm","1",0,"R");
$pdf->Cell(24,6,"$rtov->vsy","1",0,"C");$pdf->Cell(24,6,"$rtov->ssy","1",0,"C");$pdf->Cell(24,6,"$rtov->ksy","1",1,"C");
     }

if ( $ajtext == 1 )
     {
$pdf->Cell(53,6,"$rtov->iban","1",0,"C");$pdf->Cell(29,6,"$rtov->pbic","B",0,"C");$pdf->Cell(26,6,"$rtov->hodm","1",0,"R");
$pdf->Cell(26,6,"$rtov->vsy","1",0,"C");$pdf->Cell(26,6,"$rtov->ssy","TB",0,"C");$pdf->Cell(26,6,"$rtov->ksy","1",0,"C");
$pdf->Cell(0,6,"$twib","RB",1,"L");
     }

}
$i = $i + 1;
$j = $j + 1;

$polozieknastranu=8;
$xbxbxb=1*$hlavicka->txp;
if ( $xbxbxb > 0 ) { $polozieknastranu=$xbxbxb; }
if ( $j == $polozieknastranu ) { $j=0; }

//popis pod polozkami
if ( $j == 0 AND $i < $tvpol ) {
if ( $ajtext == 0 ) {
$pdf->Cell(56,6," ","LR",0,"R");$pdf->Cell(26,6," ","LR",0,"R");$pdf->Cell(26,6," ","LR",0,"R");
$pdf->Cell(24,6," ","LR",0,"R");$pdf->Cell(24,6," ","LR",0,"R");$pdf->Cell(24,6," ","LR",1,"R");
$pdf->Cell(56,6," ","LRB",0,"R");$pdf->Cell(26,6," ","LRB",0,"R");$pdf->Cell(26,6," ","LRB",0,"R");
$pdf->Cell(24,6," ","LRB",0,"R");$pdf->Cell(24,6," ","LRB",0,"R");$pdf->Cell(24,6," ","LRB",1,"R");
                    }
if ( $ajtext == 1 ) {
$pdf->Cell(53,12," ","LRB",0,"R");$pdf->Cell(29,12," ","LRB",0,"R");$pdf->Cell(26,12," ","LRB",0,"R");
$pdf->Cell(26,12," ","LRB",0,"R");$pdf->Cell(26,12," ","LRB",0,"R");$pdf->Cell(26,12," ","LRB",0,"R");
$pdf->Cell(0,12," ","LRB",1,"R");
                    }
$pdf->Cell(35,6," ","0",1,"R");
$pdf->Cell(35,6,"Doruèil:","0",1,"L");
if ( $sekov == 1 ) {
$pdf->Cell(35,6,"Miesto: $fir_fmes","0",0,"L");$pdf->Cell(75,6," ","0",0,"L");$pdf->Cell(70,6," ","0",1,"R");
                   }
$pdf->Cell(35,6,"Dòa:","0",0,"L");$pdf->Cell(75,6," ","0",0,"R");$pdf->Cell(70,6," ","0",1,"R");
//podpis,peciatka
if ( $ajtext == 0 ) { $medzera="75"; }
if ( $ajtext == 1 ) { $medzera="155"; }
$pdf->Cell(35,6," ","0",0,"L");$pdf->Cell($medzera,6," ","0",0,"R");$pdf->Cell(70,6,"podpis,peèiatka príkazcu","T",1,"C");

$koniec=270;
if ( $ajtext == 1 ) { $koniec=180; }
$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec);
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vystavil(a): $hlavicka->meno $hlavicka->priezvisko / $hlavicka->id","0",1,"L");

$sumary=33;
$sumarx=87;
$pdf->SetY($sumary);
$pdf->SetX($sumarx);
$pdf->SetFont('arial','',10);
$pdf->Cell(35,6,"$Hcelkomstrana","0",0,"R");
                               }
//koniec popis pod polozkami

  }
//koniec while
     }
//koniec ak su polozky


//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy

$pdf->Cell(35,6," ","0",1,"R");
$pdf->Cell(35,6,"Doruèil:","0",1,"L");
if ( $sekov == 1 ) {
$pdf->Cell(35,6,"Miesto: $fir_fmes","0",0,"L");$pdf->Cell(75,6," ","0",0,"L");$pdf->Cell(70,6," ","0",1,"R");
                  }
$pdf->Cell(35,6,"Dòa:","0",0,"L");$pdf->Cell(75,6," ","0",0,"R");$pdf->Cell(70,6," ","0",1,"R");
$pdf->Cell(35,6," ","0",0,"L");$pdf->Cell(75,6," ","0",0,"R");$pdf->Cell(70,6,"podpis, peèiatka príkazcu","T",1,"C");

$koniec=270;
if ( $ajtext == 1 ) { $koniec=170; }
$pdf->SetY($koniec);
$pdf->Line(15, $koniec, 195, $koniec); 
$pdf->SetY($koniec+2);
$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"Vystavil(a): $hlavicka->meno $hlavicka->priezvisko / $hlavicka->id","0",1,"L");

$sumary=32.5;
$sumarx=97;
$pdf->SetY($sumary);
$pdf->SetX($sumarx);
$pdf->SetFont('arial','',10);
$pdf->Cell(26,6,"$Hcelkomstrana","0",0,"R");
  }
//koniec hlavicky

$pdf->Output("$outfilex");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Príkaz na úhradu PDF</title>
</HEAD>
<BODY class="white">
 <table class="h2" width="100%" >
 <tr>
  <td>EuroSecom  -  Príkaz na úhradu PDF formát</td>
  <td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
 </tr>
 </table>
<br />

<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>