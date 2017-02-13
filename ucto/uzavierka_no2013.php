<HTML>
<?php
do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
$len1 = 1*$_REQUEST['len1'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//dropni stare nastavenie v ufirdalsie
$dat0101=$kli_vrok."-01-01";
$sqltt = "UPDATE F$kli_vxcf"."_ufirdalsie SET ".
" datbod='0000-00-00', datbdo='0000-00-00', datmod='0000-00-00', datmdo='0000-00-00', datk='0000-00-00' WHERE datbod < '$dat0101' ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if ( File_Exists("../tmp/uzavierka.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/uzavierka.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid."  WHERE prx = 1  "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str1.jpg',0,0,210,297);
}

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

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

//nacitaj uzavierka k datumu z ufirdalsie
$datksk="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datksk=SkDatum($riadok->datk);
  }

if ( $datksk != '' AND $datksk != '00.00.0000' ) { $datk_sk=$datksk; }

//zostavena k
$pdf->Cell(190,17,"     ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,29,"     ","$rmc1",1,"L");
$textxx="1234567890";
$text=$fir_fdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7,"     ","$rmc1",1,"L");
$textxx="12345678";
$text=$fir_fico;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//sknace
$pdf->Cell(190,7,"     ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$pdf->Cell(27,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$pdf->SetFont('arial','',8);
$riadna=""; if ( $h_drp == 1 ) $riadna="x";
$mimor=""; if ( $h_drp == 2 ) $mimor="x";
if ( $h_zos != '' )
{
$krizzos="x";
if ( trim($h_sch) != '' ) { $krizzos=" "; }
}
if ( $h_sch != '' )
{
$krizsch="x";
}
$pdf->SetY(66);
$pdf->Cell(64,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$riadna","$rmc",0,"C");$pdf->Cell(26,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizzos","$rmc",1,"C");
$pdf->SetY(75);
$pdf->Cell(64,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$mimor","$rmc",0,"C");$pdf->Cell(26,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$krizsch","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.12.".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
     }
  }
$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;

//za obdobie
$me1="0"; $me2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1);
}
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);
$pdf->SetY(62);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$me1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(71);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$Am","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bm","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//predchadzajuce obdobie
$mep1="0"; $mep2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1);
}
$kli_prdph=$kli_rdph-1;
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);
$pdf->SetY(80);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$mep1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
}
$pdf->SetY(89);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$mepm1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");
$pdf->SetFont('arial','',8);

//prilozene sucasti
$pdf->Cell(190,10,"     ","$rmc1",1,"L");
$pdf->Cell(16,5," ","$rmc1",0,"C");$pdf->Cell(3,3,"x","$rmc",0,"C");$pdf->Cell(59,5," ","$rmc1",0,"C");$pdf->Cell(3,3,"x","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//nazov
$pdf->Cell(190,17,"     ","$rmc1",1,"L");
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$pdf->Cell(190,3,"     ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,30,30);
$A=substr($fir_fnazr2,0,1);
$B=substr($fir_fnazr2,1,1);
$C=substr($fir_fnazr2,2,1);
$D=substr($fir_fnazr2,3,1);
$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);
$G=substr($fir_fnazr2,6,1);
$H=substr($fir_fnazr2,7,1);
$I=substr($fir_fnazr2,8,1);
$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);
$L=substr($fir_fnazr2,11,1);
$M=substr($fir_fnazr2,12,1);
$N=substr($fir_fnazr2,13,1);
$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);
$R=substr($fir_fnazr2,16,1);
$S=substr($fir_fnazr2,17,1);
$T=substr($fir_fnazr2,18,1);
$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);
$W=substr($fir_fnazr2,21,1);
$X=substr($fir_fnazr2,22,1);
$Y=substr($fir_fnazr2,23,1);
$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);
$B1=substr($fir_fnazr2,26,1);
$C1=substr($fir_fnazr2,27,1);
$D1=substr($fir_fnazr2,28,1);
$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);
$G1=substr($fir_fnazr2,31,1);
$H1=substr($fir_fnazr2,32,1);
$I1=substr($fir_fnazr2,33,1);
$J1=substr($fir_fnazr2,34,1);
$K1=substr($fir_fnazr2,35,1);
$L1=substr($fir_fnazr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Sidlo uctovej jednotky
//ulica
$pdf->Cell(190,13,"     ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$fir_fuli;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");

//cislo
$textxx="111122";
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","0",1,"L");
$text=$fir_fpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text=$fir_ftel;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//cislo faxu
$text=$fir_ffax;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(12,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t11","$rmc",1,"L");

//email
$pdf->Cell(190,6,"     ","$rmc1",1,"L");
$fir_fulicis=$fir_fem1;
$A=substr($fir_fulicis,0,1);
$B=substr($fir_fulicis,1,1);
$C=substr($fir_fulicis,2,1);
$D=substr($fir_fulicis,3,1);
$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);
$G=substr($fir_fulicis,6,1);
$H=substr($fir_fulicis,7,1);
$I=substr($fir_fulicis,8,1);
$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);
$L=substr($fir_fulicis,11,1);
$M=substr($fir_fulicis,12,1);
$N=substr($fir_fulicis,13,1);
$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);
$R=substr($fir_fulicis,16,1);
$S=substr($fir_fulicis,17,1);
$T=substr($fir_fulicis,18,1);
$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);
$W=substr($fir_fulicis,21,1);
$X=substr($fir_fulicis,22,1);
$Y=substr($fir_fulicis,23,1);
$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);
$B1=substr($fir_fulicis,26,1);
$C1=substr($fir_fulicis,27,1);
$D1=substr($fir_fulicis,28,1);
$E1=substr($fir_fulicis,29,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//datum zostavenia
$pdf->Cell(190,10,"     ","$rmc1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//datum schvalenia
$pdf->Cell(190,12,"     ","$rmc1",1,"L");
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dopyt, toto spoji, kde je pozícia, pod¾a mòa zbytoèné, užívate¾ nevidí link
//odkaz na datum uzavierky k
$pdf->SetY(25);
$pdf->SetX(60);

$odkaz="../cis/ufirdalsie.php?copern=202";
if ( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                                }

$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(60);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);

//odkaz na uctovne obdobia
$pdf->SetY(55);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);


//strana 2 prijmy a vydavky
if( $len1 == 0 )
  {
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str2.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str2.jpg',0,0,210,297);
}

$r01=$hlavicka->r01;
if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13;
if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14;
if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15;
if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16;
if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17;
if ( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18;
if ( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19;
if ( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20;
if ( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21;
if ( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22;
if ( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23;
if ( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24;
if ( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25;
if ( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26;
if ( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27;
if ( $hlavicka->r27 == 0 ) $r27="";

$rpc01=$hlavicka->rpc01;
if ( $hlavicka->rpc01 == 0 ) $rpc01="";
$rpc02=$hlavicka->rpc02;
if ( $hlavicka->rpc02 == 0 ) $rpc02="";
$rpc04=$hlavicka->rpc04;
if ( $hlavicka->rpc04 == 0 ) $rpc04="";
$rpc06=$hlavicka->rpc06;
if ( $hlavicka->rpc06 == 0 ) $rpc06="";
$rpc09=$hlavicka->rpc09;
if ( $hlavicka->rpc09 == 0 ) $rpc09="";
$rpc10=$hlavicka->rpc10;
if ( $hlavicka->rpc10 == 0 ) $rpc10="";
$rpc11=$hlavicka->rpc11;
if ( $hlavicka->rpc11 == 0 ) $rpc11="";
$rpc12=$hlavicka->rpc12;
if ( $hlavicka->rpc12 == 0 ) $rpc12="";
$rpc13=$hlavicka->rpc13;
if ( $hlavicka->rpc13 == 0 ) $rpc13="";
$rpc14=$hlavicka->rpc14;
if ( $hlavicka->rpc14 == 0 ) $rpc14="";
$rpc15=$hlavicka->rpc15;
if ( $hlavicka->rpc15 == 0 ) $rpc15="";
$rpc16=$hlavicka->rpc16;
if ( $hlavicka->rpc16 == 0 ) $rpc16="";
$rpc17=$hlavicka->rpc17;
if ( $hlavicka->rpc17 == 0 ) $rpc17="";
$rpc18=$hlavicka->rpc18;
if ( $hlavicka->rpc18 == 0 ) $rpc18="";
$rpc19=$hlavicka->rpc19;
if ( $hlavicka->rpc19 == 0 ) $rpc19="";
$rpc20=$hlavicka->rpc20;
if ( $hlavicka->rpc20 == 0 ) $rpc20="";
$rpc21=$hlavicka->rpc21;
if ( $hlavicka->rpc21 == 0 ) $rpc21="";
$rpc22=$hlavicka->rpc22;
if ( $hlavicka->rpc22 == 0 ) $rpc22="";
$rpc23=$hlavicka->rpc23;
if ( $hlavicka->rpc23 == 0 ) $rpc23="";
$rpc24=$hlavicka->rpc24;
if ( $hlavicka->rpc24 == 0 ) $rpc24="";
$rpc25=$hlavicka->rpc25;
if ( $hlavicka->rpc25 == 0 ) $rpc25="";
$rpc26=$hlavicka->rpc26;
if ( $hlavicka->rpc26 == 0 ) $rpc26="";
$rpc27=$hlavicka->rpc27;
if ( $hlavicka->rpc27 == 0 ) $rpc27="";

//ico
$pdf->Cell(195,3,"     ","$rmc1",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(99,6," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");


//PRIJMY
$pdf->Cell(195,26,"     ","$rmc1",1,"L");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r01","$rmc",0,"R");$pdf->Cell(33,6,"$rpc01","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r02","$rmc",0,"R");$pdf->Cell(33,7,"$rpc02","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r03","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r04","$rmc",0,"R");$pdf->Cell(33,6,"$rpc04","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r05","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r06","$rmc",0,"R");$pdf->Cell(33,6,"$rpc06","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r07","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r08","$rmc",1,"R");
$pdf->Cell(108,8," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r09","$rmc",0,"R");$pdf->Cell(33,6,"$rpc09","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r10","$rmc",0,"R");$pdf->Cell(33,7,"$rpc10","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r11","$rmc",0,"R");$pdf->Cell(33,7,"$rpc11","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r12","$rmc",0,"R");$pdf->Cell(33,6,"$rpc12","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r13","$rmc",0,"R");$pdf->Cell(33,7,"$rpc13","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r14","$rmc",0,"R");$pdf->Cell(33,7,"$rpc14","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r15","$rmc",0,"R");$pdf->Cell(33,6,"$rpc15","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r16","$rmc",0,"R");$pdf->Cell(33,7,"$rpc16","$rmc",1,"R");

//VYDAVKY
$pdf->Cell(195,33,"     ","$rmc1",1,"L");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r17","$rmc",0,"R");$pdf->Cell(33,6,"$rpc17","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r18","$rmc",0,"R");$pdf->Cell(33,7,"$rpc18","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r19","$rmc",0,"R");$pdf->Cell(33,6,"$rpc19","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r20","$rmc",0,"R");$pdf->Cell(33,7,"$rpc20","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r21","$rmc",0,"R");$pdf->Cell(33,7,"$rpc21","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r22","$rmc",0,"R");$pdf->Cell(33,6,"$rpc22","$rmc",1,"R");
$pdf->Cell(108,5," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r23","$rmc",0,"R");$pdf->Cell(33,7,"$rpc23","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r24","$rmc",0,"R");$pdf->Cell(33,7,"$rpc24","$rmc",1,"R");
$pdf->Cell(108,7," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r25","$rmc",0,"R");$pdf->Cell(33,7,"$rpc25","$rmc",1,"R");
$pdf->Cell(108,7," ","$rmc1",0,"R");$pdf->Cell(33,6,"$r26","$rmc",0,"R");$pdf->Cell(33,6,"$rpc26","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"R");$pdf->Cell(33,7,"$r27","$rmc",0,"R");$pdf->Cell(33,7,"$rpc27","$rmc",1,"R");
}
$i = $i + 1;
  }
//koniec while prijmy a vydavky

//vytlac majetok a zavazky
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." WHERE prx = 1 ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

if ( $pol == 0 )
     {
$sqltt = "INSERT INTO F$kli_vxcf"."_prcvmajzavs".$kli_uzid." ( prx ) VALUES ( 1 ) ";
$sql = mysql_query("$sqltt");
     }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." ".
" LEFT JOIN F$kli_vxcf"."_uctpocmajzavnoju_stl".
" ON F$kli_vxcf"."_prcvmajzavs$kli_uzid.prx=F$kli_vxcf"."_uctpocmajzavnoju_stl.fic".
" WHERE prx = 1 "."";
//echo $sqltt;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str3.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/uzno2013/UZNOv13_str3.jpg',0,0,210,297);
}

//ico
$pdf->Cell(195,9,"     ","$rmc1",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(98,6," ","$rmc1",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",1,"C");

$r01=$hlavicka->r01;
if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13;
if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14;
if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15;
if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16;
if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17;
if ( $hlavicka->r17 == 0 ) $r17="";

$rm01=$hlavicka->rm01;
if ( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02;
if ( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03;
if ( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04;
if ( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05;
if ( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06;
if ( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07;
if ( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08;
if ( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09;
if ( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10;
if ( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11;
if ( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12;
if ( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13;
if ( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14;
if ( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15;
if ( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16;
if ( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17;
if ( $hlavicka->rm17 == 0 ) $rm17="";

//MAJETOK
$pdf->Cell(100,30,"     ","$rmc1",1,"L");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r01","$rmc",0,"R");$pdf->Cell(32,9,"$rm01","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r02","$rmc",0,"R");$pdf->Cell(32,9,"$rm02","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r03","$rmc",0,"R");$pdf->Cell(32,9,"$rm03","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,8,"$r04","$rmc",0,"R");$pdf->Cell(32,8,"$rm04","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r05","$rmc",0,"R");$pdf->Cell(32,9,"$rm05","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r06","$rmc",0,"R");$pdf->Cell(32,9,"$rm06","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r07","$rmc",0,"R");$pdf->Cell(32,9,"$rm07","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,8,"$r08","$rmc",0,"R");$pdf->Cell(32,8,"$rm08","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r09","$rmc",0,"R");$pdf->Cell(32,9,"$rm09","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r10","$rmc",0,"R");$pdf->Cell(32,9,"$rm10","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,8,"$r11","$rmc",0,"R");$pdf->Cell(32,8,"$rm11","$rmc",1,"R");

//ZAVAZKY
$pdf->Cell(100,42,"     ","$rmc1",1,"L");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,8,"$r12","$rmc",0,"R");$pdf->Cell(32,8,"$rm12","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r13","$rmc",0,"R");$pdf->Cell(32,9,"$rm13","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r14","$rmc",0,"R");$pdf->Cell(32,9,"$rm14","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r15","$rmc",0,"R");$pdf->Cell(32,9,"$rm15","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,9,"$r16","$rmc",0,"R");$pdf->Cell(32,9,"$rm16","$rmc",1,"R");
$pdf->Cell(108,6," ","$rmc1",0,"C");$pdf->Cell(33,8,"$r17","$rmc",0,"R");$pdf->Cell(32,8,"$rm17","$rmc",1,"R");
}
$i = $i + 1;
  }
//koniec while majzav
//koniec ak len1 = 0 if( $len1 == 0 )
  }

$pdf->Output("../tmp/uzavierka.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/uzavierka.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD> <!-- dopyt, preèo takto -->
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzavierka NUJ PDF</title>
</HEAD>
<BODY class="white" >

<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>