<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

/////////////////////////////////////////////////VYTLAC Potvrdenie o zaplatení dane z príjmov zo závislej èinnosti
if ( $copern == 10 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane2strana WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$zp2dat = $fir_riadok->zp2dat;
$zp2datsk =SkDatum($zp2dat);
$zp2dak = $fir_riadok->zp2dak;
$zp2daksk =SkDatum($zp2dak);
$zp2hod = $fir_riadok->zp2hod;
if ( $fir_riadok->zp2hod == 0 ) $zp2hod="";
if ( $fir_riadok->zp2dat == '0000-00-00' ) $zp2datsk="";
if ( $fir_riadok->zp2dak == '0000-00-00' ) $zp2daksk="";
mysql_free_result($fir_vysledok);

if ( File_Exists("../tmp/potvrdzapldan.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/potvrdzapldan.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany);
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//statna prislusnost z statistiky treximaoc
$statznec="SK";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_treximaoc WHERE idec = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $statznec=trim($riaddok->stprisl);
  }
if ( $statznec == '' ) { $statznec="SK"; }

//titul za zo ziadosti o rz
$titulza="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_rocneziadost WHERE oc = $cislo_oc LIMIT 1 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $titulza=trim($riaddok->ztitl);
  }

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdrocnedane".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdrocnedane.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdrocnedane.oc = $cislo_oc AND konx1 = 2 ORDER BY konx1,prie,meno";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/rz/rz_potvrdenie_dane_v13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/dan_zo_zavislej2013/rz/rz_potvrdenie_dane_v13.jpg',0,0,210,297);
}

//za rok
$pdf->Cell(190,23," ","$rmc1",1,"L");
$pdf->Cell(155,4," ","$rmc1",0,"L");$pdf->Cell(35,7,"$kli_vrok","$rmc",0,"L");

//I. ZAMESTNANEC
$pdf->Cell(190,26," ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,6,"$hlavicka->prie","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(35,6,"$hlavicka->meno","$rmc",0,"L");
$dar=SkDatum($hlavicka->dar);
$tlacrd="$hlavicka->rdc / $hlavicka->rdk";
if ( $tlacrd == "0 / " ) { $tlacrd="$dar"; }
$pdf->Cell(24,4," ","$rmc1",0,"L");$pdf->Cell(34,6,"$tlacrd","$rmc",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(190,1,"                          ","$rmc1",1,"L");
$pdf->Cell(42,4," ","$rmc1",0,"L");$pdf->Cell(25,4,"$hlavicka->titl","$rmc",0,"L");$pdf->Cell(63,4," ","$rmc1",0,"L");$pdf->Cell(27,4,"$titulza","$rmc",1,"L");
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,5,"$hlavicka->zuli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(28,5,"$hlavicka->zcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,5,"$hlavicka->zpsc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$hlavicka->zmes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(70,4,"$statznec","$rmc",1,"L");
$pdf->SetFont('arial','',10);

//II. ZAMESTNAVATEL
if ( $fir_uctt03 == 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$dtitul = $dtitl." / ".$dtitz;

$uli = $fir_riadok->duli;
$cdm = $fir_riadok->dcdm;
$psc = $fir_riadok->dpsc;
$mes = $fir_riadok->dmes;
$fstat = $fir_riadok->xstat;  
}
if ( $fir_uctt03 != 999 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po".
" WHERE psys = 0 ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$naz = $fir_fnaz;
$uli = $fir_fuli;
$cdm = $fir_fcdm;
$psc = $fir_fpsc;
$mes = $fir_fmes;
$fstat = $fir_riadok->xstat; 
}
//FO
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$pdf->Cell(18,4," ","$rmc1",0,"L");$pdf->Cell(63,7,"$dprie","$rmc",0,"L");$pdf->Cell(2,4," ","$rmc1",0,"L");$pdf->Cell(35,7,"$dmeno","$rmc",0,"L");
$pdf->Cell(5,4," ","$rmc1",0,"L");$pdf->Cell(50,7,"$dtitl $dtitz","$rmc",1,"L");
//PO
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(28,4," ","$rmc1",0,"L");$pdf->Cell(150,7,"$naz","$rmc",1,"L");
//adresa
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(75,6,"$uli","$rmc",0,"L");$pdf->Cell(9,5," ","$rmc1",0,"L");$pdf->Cell(28,6,"$fir_fcdm","$rmc",0,"L");
$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(32,6,"$psc","$rmc",1,"L");
$pdf->Cell(27,5," ","$rmc1",0,"L");$pdf->Cell(74,4,"$mes","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(69,4,"$fstat","$rmc",1,"L");
//danove
$pdf->Cell(26,5," ","$rmc1",0,"L");$pdf->Cell(46,7,"$fir_fdic","$rmc",0,"L");$pdf->Cell(45,5," ","$rmc1",0,"L");$pdf->Cell(61,7,"Daòový úrad $fir_uctt01","$rmc",1,"L");

//UDAJE
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");
$r06=$hlavicka->r06;
$Cislo=$r06+"";
$r06=sprintf("%0.2f", $Cislo);
if ( $r06 == 0.00 ) $r06="";
$r10=$hlavicka->r10;
$Cislo=$r10+"";
$r10=sprintf("%0.2f", $Cislo);
if ( $hlavicka->r10 == 0.00 ) $r10="";
$roz=$hlavicka->r06-$hlavicka->r10;
if ( $roz < 0 ) $roz=0;
$Cislo=$roz+"";
$roz=sprintf("%0.2f", $Cislo);
if ( $roz == 0.00 ) $roz="";
$r17n=$hlavicka->r17n;
$Cislo=$r17n+"";
$r17n=sprintf("%0.2f", $Cislo);
if ( $hlavicka->r17n == 0.00 ) $r17n="";
$pdf->Cell(150,11," ","$rmc1",0,"L");$pdf->Cell(28,10,"$r06","$rmc",1,"R");
$pdf->Cell(150,10," ","$rmc1",0,"L");$pdf->Cell(28,11,"$r10","$rmc",1,"R");
$pdf->Cell(150,10," ","$rmc1",0,"L");$pdf->Cell(28,10,"$roz","$rmc",1,"R");
$pdf->Cell(150,6," ","$rmc1",0,"L");$pdf->Cell(28,7,"$r17n","$rmc",1,"R");
$pdf->Cell(158,7," ","$rmc1",0,"L");$pdf->Cell(20,6,"$zp2daksk","$rmc",1,"R");
$pdf->Cell(150,6," ","$rmc1",0,"L");$pdf->Cell(28,8,"$zp2hod","$rmc",1,"R");

//Vypracoval
$pdf->Cell(190,19,"                          ","$rmc1",1,"L");
$pdf->Cell(50,5," ","$rmc1",0,"L");$pdf->Cell(47,5,"$kli_uzprie $kli_uzmeno","$rmc",0,"L");$pdf->Cell(8,5," ","$rmc1",0,"L");$pdf->Cell(42,5,"$zp2datsk","$rmc",1,"C");
}
$i = $i + 1;
  }
$pdf->Output("../tmp/potvrdzapldan.$kli_uzid.pdf");
?>

<script type="text/javascript">
 var okno = window.open("../tmp/potvrdzapldan.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA Potvrdenie o zaplatení dane z príjmov zo závislej èinnosti
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;
</script>
</HEAD>

<BODY id="white" onload="ObnovUI();">
<table class="h2" width="100%" >
 <tr>
  <td>EuroSecom - Potvrdenie o zaplatení dane z príjmov zo závislej èinnosti</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
 </tr>
</table>

<?php
//celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
} while (false);
?>
</BODY>
</HTML>