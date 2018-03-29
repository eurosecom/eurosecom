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
$celeeura= 1*$_REQUEST['celeeura'];

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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

$citfir = include("../cis/citaj_fir.php");
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/uzavju_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/uzavju_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str1.jpg',0,0,210,297);
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
$pdf->Cell(190,17," ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(63,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,30," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$textxx="12345678";
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//sknace
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
//$sn2c=substr($sknacec,1,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$pdf->SetFont('arial','',10);
$riadna=""; $mimor=""; $priebez="";
if ( $h_drp == 1 ) { $riadna="x"; }
if ( $h_drp == 2 ) { $mimor="x"; }
if ( $h_drp == 3 ) { $priebez="x"; }
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
$pdf->Cell(72,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadna","$rmc",0,"C");
$pdf->SetY(73);
$pdf->Cell(72,3," ","$rmc1",0,"C");$pdf->Cell(3,5,"$mimor","$rmc",0,"C");
$pdf->SetY(81);
$pdf->Cell(72,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$priebez","$rmc",0,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
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
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$me1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(71);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$Am","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$Bm","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

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
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mep1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
}
$pdf->SetY(89);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mepm1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//nazov
$pdf->Cell(190,9," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$fir_fnazr2="";
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,37,36);
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Miesto podnikania
//ulica
$pdf->Cell(190,13," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");

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
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$t01=substr($fir_ftel,0,1);
$t02=substr($fir_ftel,1,1);
$t03=substr($fir_ftel,2,1);
$t04=substr($fir_ftel,3,1);
$t05=substr($fir_ftel,4,1);
$t06=substr($fir_ftel,5,1);
$t07=substr($fir_ftel,6,1);
$t08=substr($fir_ftel,7,1);
$t09=substr($fir_ftel,8,1);
$t10=substr($fir_ftel,9,1);
$t11=substr($fir_ftel,10,1);
$t12=substr($fir_ftel,11,1);
$t13=substr($fir_ftel,12,1);
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",1,"C");

//email
$pdf->Cell(190,6," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//datum zostavenia
$pdf->Cell(190,16," ","$rcm1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(2,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");


//odkaz na datum uzavierky k
//podla mna zbytocne
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
if ( $_SESSION['chrome'] == 1 ) {
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
//koniec prva strana


//strana 2
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvprivyds".$kli_uzid." WHERE prx = 1 ";
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
if ( File_Exists('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str2.jpg') )
{
$pdf->Image('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";

//tu si nastavis premenne od r01 az po r12 v celych eurach
$xr01=1000001;
$xr02=1000002;
$xr03=1000003;
$xr04=1000004;
$xr05=1000005;
$xr06=1000006;
$xr07=1000007;
$xr08=1000008;
$xr09=1000009;
$xr10=1000010;
$xr11=1000011;
$xr12=1000012;

//dic
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(42,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//PRIJMY
//riadok 01
$pdf->Cell(190,27," ","$rmc1",1,"L");
$h_r01=sprintf("% 12s",$r01);
$A=substr($h_r01,0,1);
$B=substr($h_r01,1,1);
$C=substr($h_r01,2,1);
$D=substr($h_r01,3,1);
$E=substr($h_r01,4,1);
$F=substr($h_r01,5,1);
$G=substr($h_r01,6,1);
$H=substr($h_r01,7,1);
$I=substr($h_r01,8,1);
$J=substr($h_r01,9,1);
$K=substr($h_r01,10,1);
$L=substr($h_r01,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 02
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r02=sprintf("% 12s",$r02);
$A=substr($h_r02,0,1);
$B=substr($h_r02,1,1);
$C=substr($h_r02,2,1);
$D=substr($h_r02,3,1);
$E=substr($h_r02,4,1);
$F=substr($h_r02,5,1);
$G=substr($h_r02,6,1);
$H=substr($h_r02,7,1);
$I=substr($h_r02,8,1);
$J=substr($h_r02,9,1);
$K=substr($h_r02,10,1);
$L=substr($h_r02,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 03
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r03=sprintf("% 12s",$r03);
$A=substr($h_r03,0,1);
$B=substr($h_r03,1,1);
$C=substr($h_r03,2,1);
$D=substr($h_r03,3,1);
$E=substr($h_r03,4,1);
$F=substr($h_r03,5,1);
$G=substr($h_r03,6,1);
$H=substr($h_r03,7,1);
$I=substr($h_r03,8,1);
$J=substr($h_r03,9,1);
$K=substr($h_r03,10,1);
$L=substr($h_r03,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 04
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r04=sprintf("% 12s",$r04);
$A=substr($h_r04,0,1);
$B=substr($h_r04,1,1);
$C=substr($h_r04,2,1);
$D=substr($h_r04,3,1);
$E=substr($h_r04,4,1);
$F=substr($h_r04,5,1);
$G=substr($h_r04,6,1);
$H=substr($h_r04,7,1);
$I=substr($h_r04,8,1);
$J=substr($h_r04,9,1);
$K=substr($h_r04,10,1);
$L=substr($h_r04,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//VYDAVKY
//riadok 05
$pdf->Cell(190,24," ","$rmc1",1,"L");
$h_r05=sprintf("% 12s",$r05);
$A=substr($h_r05,0,1);
$B=substr($h_r05,1,1);
$C=substr($h_r05,2,1);
$D=substr($h_r05,3,1);
$E=substr($h_r05,4,1);
$F=substr($h_r05,5,1);
$G=substr($h_r05,6,1);
$H=substr($h_r05,7,1);
$I=substr($h_r05,8,1);
$J=substr($h_r05,9,1);
$K=substr($h_r05,10,1);
$L=substr($h_r05,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 06
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r06=sprintf("% 12s",$r06);
$A=substr($h_r06,0,1);
$B=substr($h_r06,1,1);
$C=substr($h_r06,2,1);
$D=substr($h_r06,3,1);
$E=substr($h_r06,4,1);
$F=substr($h_r06,5,1);
$G=substr($h_r06,6,1);
$H=substr($h_r06,7,1);
$I=substr($h_r06,8,1);
$J=substr($h_r06,9,1);
$K=substr($h_r06,10,1);
$L=substr($h_r06,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 07
$pdf->Cell(190,5," ","$rmc1",1,"L");
$h_r07=sprintf("% 12s",$r07);
$A=substr($h_r07,0,1);
$B=substr($h_r07,1,1);
$C=substr($h_r07,2,1);
$D=substr($h_r07,3,1);
$E=substr($h_r07,4,1);
$F=substr($h_r07,5,1);
$G=substr($h_r07,6,1);
$H=substr($h_r07,7,1);
$I=substr($h_r07,8,1);
$J=substr($h_r07,9,1);
$K=substr($h_r07,10,1);
$L=substr($h_r07,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 08
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r08=sprintf("% 12s",$r08);
$A=substr($h_r08,0,1);
$B=substr($h_r08,1,1);
$C=substr($h_r08,2,1);
$D=substr($h_r08,3,1);
$E=substr($h_r08,4,1);
$F=substr($h_r08,5,1);
$G=substr($h_r08,6,1);
$H=substr($h_r08,7,1);
$I=substr($h_r08,8,1);
$J=substr($h_r08,9,1);
$K=substr($h_r08,10,1);
$L=substr($h_r08,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 09
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r09=sprintf("% 12s",$r09);
$A=substr($h_r09,0,1);
$B=substr($h_r09,1,1);
$C=substr($h_r09,2,1);
$D=substr($h_r09,3,1);
$E=substr($h_r09,4,1);
$F=substr($h_r09,5,1);
$G=substr($h_r09,6,1);
$H=substr($h_r09,7,1);
$I=substr($h_r09,8,1);
$J=substr($h_r09,9,1);
$K=substr($h_r09,10,1);
$L=substr($h_r09,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 10
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r10=sprintf("% 12s",$r10);
$A=substr($h_r10,0,1);
$B=substr($h_r10,1,1);
$C=substr($h_r10,2,1);
$D=substr($h_r10,3,1);
$E=substr($h_r10,4,1);
$F=substr($h_r10,5,1);
$G=substr($h_r10,6,1);
$H=substr($h_r10,7,1);
$I=substr($h_r10,8,1);
$J=substr($h_r10,9,1);
$K=substr($h_r10,10,1);
$L=substr($h_r10,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 11
$pdf->Cell(190,4," ","$rmc1",1,"L");
$h_r11=sprintf("% 12s",$r11);
$A=substr($h_r11,0,1);
$B=substr($h_r11,1,1);
$C=substr($h_r11,2,1);
$D=substr($h_r11,3,1);
$E=substr($h_r11,4,1);
$F=substr($h_r11,5,1);
$G=substr($h_r11,6,1);
$H=substr($h_r11,7,1);
$I=substr($h_r11,8,1);
$J=substr($h_r11,9,1);
$K=substr($h_r11,10,1);
$L=substr($h_r11,11,1);
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

//riadok 12
$pdf->Cell(190,4," ","$rmc1",1,"L");
$strata=0;
if ( $r12 < 0 ) { $strata=1; $r12=str_replace("-"," ",$r12); }
$h_r12=sprintf("% 12s",$r12);
$A=substr($h_r12,0,1);
$B=substr($h_r12,1,1);
$C=substr($h_r12,2,1);
$D=substr($h_r12,3,1);
$E=substr($h_r12,4,1);
$F=substr($h_r12,5,1);
$G=substr($h_r12,6,1);
$H=substr($h_r12,7,1);
$I=substr($h_r12,8,1);
$J=substr($h_r12,9,1);
$K=substr($h_r12,10,1);
$L=substr($h_r12,11,1);
if ( $strata == 1 ) $A="-";
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",1,"C");

}
$i = $i + 1;
  }
//koniec while privyd



//strana 3
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." WHERE prx = 1 ";
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
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str3.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2014/fo2014/uzfo_v14_str3.jpg',0,0,210,297);
}
$pdf->SetY(10);

$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $r21="";
$r98=$hlavicka->r98; if ( $hlavicka->r98 == 0 ) $r98="";
$r99=$hlavicka->r99; if ( $hlavicka->r99 == 0 ) $r99="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_uctpocmajzav WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
if ($sqlpv) { $polpv = mysql_num_rows($sqlpv); }

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if ( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }

}
$ipv = $ipv + 1;
  }

//tu si nastavis premenne od r01 az po r21 a rm01 az rm21 v celych eurach
$r01x=1000001;
$r02x=1000002;
$r03x=1000003;
$r04x=1000004;
$r05x=1000005;
$r06x=1000006;
$r07x=1000007;
$r08x=1000008;
$r09x=1000009;
$r10x=1000010;
$r11x=1000011;
$r12x=1000012;
$r13x=1000013;
$r14x=1000014;
$r15x=1000015;
$r16x=1000016;
$r17x=1000017;
$r18x=1000018;
$r19x=1000019;
$r20x=1000020;
$r21x=1000021;

$rm01x=2000001;
$rm02x=2000002;
$rm03x=2000003;
$rm04x=2000004;
$rm05x=2000005;
$rm06x=2000006;
$rm07x=2000007;
$rm08x=2000008;
$rm09x=2000009;
$rm10x=2000010;
$rm11x=2000011;
$rm12x=2000012;
$rm13x=2000013;
$rm14x=2000014;
$rm15x=2000015;
$rm16x=2000016;
$rm17x=2000017;
$rm18x=2000018;
$rm19x=2000019;
$rm20x=2000020;
$rm21x=2000021;

//dic
$pdf->Cell(190,5," ","$rmc1",1,"L");
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
$pdf->Cell(42,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$text=$fir_fico;
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//MAJETOK
//riadok 01
$pdf->Cell(100,21," ","$rmc1",1,"L");
$h_rm01=sprintf("% 12s",$rm01);
$A=substr($h_rm01,0,1);
$B=substr($h_rm01,1,1);
$C=substr($h_rm01,2,1);
$D=substr($h_rm01,3,1);
$E=substr($h_rm01,4,1);
$F=substr($h_rm01,5,1);
$G=substr($h_rm01,6,1);
$H=substr($h_rm01,7,1);
$I=substr($h_rm01,8,1);
$J=substr($h_rm01,9,1);
$K=substr($h_rm01,10,1);
$L=substr($h_rm01,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r01=sprintf("% 12s",$r01);
$A=substr($h_r01,0,1);
$B=substr($h_r01,1,1);
$C=substr($h_r01,2,1);
$D=substr($h_r01,3,1);
$E=substr($h_r01,4,1);
$F=substr($h_r01,5,1);
$G=substr($h_r01,6,1);
$H=substr($h_r01,7,1);
$I=substr($h_r01,8,1);
$J=substr($h_r01,9,1);
$K=substr($h_r01,10,1);
$L=substr($h_r01,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 02
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm02=sprintf("% 12s",$rm02);
$A=substr($h_rm02,0,1);
$B=substr($h_rm02,1,1);
$C=substr($h_rm02,2,1);
$D=substr($h_rm02,3,1);
$E=substr($h_rm02,4,1);
$F=substr($h_rm02,5,1);
$G=substr($h_rm02,6,1);
$H=substr($h_rm02,7,1);
$I=substr($h_rm02,8,1);
$J=substr($h_rm02,9,1);
$K=substr($h_rm02,10,1);
$L=substr($h_rm02,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r02=sprintf("% 12s",$r02);
$A=substr($h_r02,0,1);
$B=substr($h_r02,1,1);
$C=substr($h_r02,2,1);
$D=substr($h_r02,3,1);
$E=substr($h_r02,4,1);
$F=substr($h_r02,5,1);
$G=substr($h_r02,6,1);
$H=substr($h_r02,7,1);
$I=substr($h_r02,8,1);
$J=substr($h_r02,9,1);
$K=substr($h_r02,10,1);
$L=substr($h_r02,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 03
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm03=sprintf("% 12s",$rm03);
$A=substr($h_rm03,0,1);
$B=substr($h_rm03,1,1);
$C=substr($h_rm03,2,1);
$D=substr($h_rm03,3,1);
$E=substr($h_rm03,4,1);
$F=substr($h_rm03,5,1);
$G=substr($h_rm03,6,1);
$H=substr($h_rm03,7,1);
$I=substr($h_rm03,8,1);
$J=substr($h_rm03,9,1);
$K=substr($h_rm03,10,1);
$L=substr($h_rm03,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r03=sprintf("% 12s",$r03);
$A=substr($h_r03,0,1);
$B=substr($h_r03,1,1);
$C=substr($h_r03,2,1);
$D=substr($h_r03,3,1);
$E=substr($h_r03,4,1);
$F=substr($h_r03,5,1);
$G=substr($h_r03,6,1);
$H=substr($h_r03,7,1);
$I=substr($h_r03,8,1);
$J=substr($h_r03,9,1);
$K=substr($h_r03,10,1);
$L=substr($h_r03,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 04
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm04=sprintf("% 12s",$rm04);
$A=substr($h_rm04,0,1);
$B=substr($h_rm04,1,1);
$C=substr($h_rm04,2,1);
$D=substr($h_rm04,3,1);
$E=substr($h_rm04,4,1);
$F=substr($h_rm04,5,1);
$G=substr($h_rm04,6,1);
$H=substr($h_rm04,7,1);
$I=substr($h_rm04,8,1);
$J=substr($h_rm04,9,1);
$K=substr($h_rm04,10,1);
$L=substr($h_rm04,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r04=sprintf("% 12s",$r04);
$A=substr($h_r04,0,1);
$B=substr($h_r04,1,1);
$C=substr($h_r04,2,1);
$D=substr($h_r04,3,1);
$E=substr($h_r04,4,1);
$F=substr($h_r04,5,1);
$G=substr($h_r04,6,1);
$H=substr($h_r04,7,1);
$I=substr($h_r04,8,1);
$J=substr($h_r04,9,1);
$K=substr($h_r04,10,1);
$L=substr($h_r04,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 05
$pdf->Cell(100,5," ","$rmc1",1,"L");
$h_rm05=sprintf("% 12s",$rm05);
$A=substr($h_rm05,0,1);
$B=substr($h_rm05,1,1);
$C=substr($h_rm05,2,1);
$D=substr($h_rm05,3,1);
$E=substr($h_rm05,4,1);
$F=substr($h_rm05,5,1);
$G=substr($h_rm05,6,1);
$H=substr($h_rm05,7,1);
$I=substr($h_rm05,8,1);
$J=substr($h_rm05,9,1);
$K=substr($h_rm05,10,1);
$L=substr($h_rm05,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r05=sprintf("% 12s",$r05);
$A=substr($h_r05,0,1);
$B=substr($h_r05,1,1);
$C=substr($h_r05,2,1);
$D=substr($h_r05,3,1);
$E=substr($h_r05,4,1);
$F=substr($h_r05,5,1);
$G=substr($h_r05,6,1);
$H=substr($h_r05,7,1);
$I=substr($h_r05,8,1);
$J=substr($h_r05,9,1);
$K=substr($h_r05,10,1);
$L=substr($h_r05,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 06
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm06=sprintf("% 12s",$rm06);
$A=substr($h_rm06,0,1);
$B=substr($h_rm06,1,1);
$C=substr($h_rm06,2,1);
$D=substr($h_rm06,3,1);
$E=substr($h_rm06,4,1);
$F=substr($h_rm06,5,1);
$G=substr($h_rm06,6,1);
$H=substr($h_rm06,7,1);
$I=substr($h_rm06,8,1);
$J=substr($h_rm06,9,1);
$K=substr($h_rm06,10,1);
$L=substr($h_rm06,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r06=sprintf("% 12s",$r06);
$A=substr($h_r06,0,1);
$B=substr($h_r06,1,1);
$C=substr($h_r06,2,1);
$D=substr($h_r06,3,1);
$E=substr($h_r06,4,1);
$F=substr($h_r06,5,1);
$G=substr($h_r06,6,1);
$H=substr($h_r06,7,1);
$I=substr($h_r06,8,1);
$J=substr($h_r06,9,1);
$K=substr($h_r06,10,1);
$L=substr($h_r06,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 07
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm07=sprintf("% 12s",$rm07);
$A=substr($h_rm07,0,1);
$B=substr($h_rm07,1,1);
$C=substr($h_rm07,2,1);
$D=substr($h_rm07,3,1);
$E=substr($h_rm07,4,1);
$F=substr($h_rm07,5,1);
$G=substr($h_rm07,6,1);
$H=substr($h_rm07,7,1);
$I=substr($h_rm07,8,1);
$J=substr($h_rm07,9,1);
$K=substr($h_rm07,10,1);
$L=substr($h_rm07,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r07=sprintf("% 12s",$r07);
$A=substr($h_r07,0,1);
$B=substr($h_r07,1,1);
$C=substr($h_r07,2,1);
$D=substr($h_r07,3,1);
$E=substr($h_r07,4,1);
$F=substr($h_r07,5,1);
$G=substr($h_r07,6,1);
$H=substr($h_r07,7,1);
$I=substr($h_r07,8,1);
$J=substr($h_r07,9,1);
$K=substr($h_r07,10,1);
$L=substr($h_r07,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 08
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm08=sprintf("% 12s",$rm08);
$A=substr($h_rm08,0,1);
$B=substr($h_rm08,1,1);
$C=substr($h_rm08,2,1);
$D=substr($h_rm08,3,1);
$E=substr($h_rm08,4,1);
$F=substr($h_rm08,5,1);
$G=substr($h_rm08,6,1);
$H=substr($h_rm08,7,1);
$I=substr($h_rm08,8,1);
$J=substr($h_rm08,9,1);
$K=substr($h_rm08,10,1);
$L=substr($h_rm08,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r08=sprintf("% 12s",$r08);
$A=substr($h_r08,0,1);
$B=substr($h_r08,1,1);
$C=substr($h_r08,2,1);
$D=substr($h_r08,3,1);
$E=substr($h_r08,4,1);
$F=substr($h_r08,5,1);
$G=substr($h_r08,6,1);
$H=substr($h_r08,7,1);
$I=substr($h_r08,8,1);
$J=substr($h_r08,9,1);
$K=substr($h_r08,10,1);
$L=substr($h_r08,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 09
$pdf->Cell(100,5," ","$rmc1",1,"L");
$h_rm09=sprintf("% 12s",$rm09);
$A=substr($h_rm09,0,1);
$B=substr($h_rm09,1,1);
$C=substr($h_rm09,2,1);
$D=substr($h_rm09,3,1);
$E=substr($h_rm09,4,1);
$F=substr($h_rm09,5,1);
$G=substr($h_rm09,6,1);
$H=substr($h_rm09,7,1);
$I=substr($h_rm09,8,1);
$J=substr($h_rm09,9,1);
$K=substr($h_rm09,10,1);
$L=substr($h_rm09,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r09=sprintf("% 12s",$r09);
$A=substr($h_r09,0,1);
$B=substr($h_r09,1,1);
$C=substr($h_r09,2,1);
$D=substr($h_r09,3,1);
$E=substr($h_r09,4,1);
$F=substr($h_r09,5,1);
$G=substr($h_r09,6,1);
$H=substr($h_r09,7,1);
$I=substr($h_r09,8,1);
$J=substr($h_r09,9,1);
$K=substr($h_r09,10,1);
$L=substr($h_r09,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 10
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm10=sprintf("% 12s",$rm10);
$A=substr($h_rm10,0,1);
$B=substr($h_rm10,1,1);
$C=substr($h_rm10,2,1);
$D=substr($h_rm10,3,1);
$E=substr($h_rm10,4,1);
$F=substr($h_rm10,5,1);
$G=substr($h_rm10,6,1);
$H=substr($h_rm10,7,1);
$I=substr($h_rm10,8,1);
$J=substr($h_rm10,9,1);
$K=substr($h_rm10,10,1);
$L=substr($h_rm10,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r10=sprintf("% 12s",$r10);
$A=substr($h_r10,0,1);
$B=substr($h_r10,1,1);
$C=substr($h_r10,2,1);
$D=substr($h_r10,3,1);
$E=substr($h_r10,4,1);
$F=substr($h_r10,5,1);
$G=substr($h_r10,6,1);
$H=substr($h_r10,7,1);
$I=substr($h_r10,8,1);
$J=substr($h_r10,9,1);
$K=substr($h_r10,10,1);
$L=substr($h_r10,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 11
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm11=sprintf("% 12s",$rm11);
$A=substr($h_rm11,0,1);
$B=substr($h_rm11,1,1);
$C=substr($h_rm11,2,1);
$D=substr($h_rm11,3,1);
$E=substr($h_rm11,4,1);
$F=substr($h_rm11,5,1);
$G=substr($h_rm11,6,1);
$H=substr($h_rm11,7,1);
$I=substr($h_rm11,8,1);
$J=substr($h_rm11,9,1);
$K=substr($h_rm11,10,1);
$L=substr($h_rm11,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r11=sprintf("% 12s",$r11);
$A=substr($h_r11,0,1);
$B=substr($h_r11,1,1);
$C=substr($h_r11,2,1);
$D=substr($h_r11,3,1);
$E=substr($h_r11,4,1);
$F=substr($h_r11,5,1);
$G=substr($h_r11,6,1);
$H=substr($h_r11,7,1);
$I=substr($h_r11,8,1);
$J=substr($h_r11,9,1);
$K=substr($h_r11,10,1);
$L=substr($h_r11,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 12
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm12=sprintf("% 12s",$rm12);
$A=substr($h_rm12,0,1);
$B=substr($h_rm12,1,1);
$C=substr($h_rm12,2,1);
$D=substr($h_rm12,3,1);
$E=substr($h_rm12,4,1);
$F=substr($h_rm12,5,1);
$G=substr($h_rm12,6,1);
$H=substr($h_rm12,7,1);
$I=substr($h_rm12,8,1);
$J=substr($h_rm12,9,1);
$K=substr($h_rm12,10,1);
$L=substr($h_rm12,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r12=sprintf("% 12s",$r12);
$A=substr($h_r12,0,1);
$B=substr($h_r12,1,1);
$C=substr($h_r12,2,1);
$D=substr($h_r12,3,1);
$E=substr($h_r12,4,1);
$F=substr($h_r12,5,1);
$G=substr($h_r12,6,1);
$H=substr($h_r12,7,1);
$I=substr($h_r12,8,1);
$J=substr($h_r12,9,1);
$K=substr($h_r12,10,1);
$L=substr($h_r12,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 13
$pdf->Cell(100,4," ","$rmc1",1,"L");
$znamienko=" ";
if( $rm13 < 0 ) { $znamienko="-"; $rm13=-1*$rm13; }
$h_rm13=sprintf("% 12s",$rm13);
$A=substr($h_rm13,0,1);
$B=substr($h_rm13,1,1);
$C=substr($h_rm13,2,1);
$D=substr($h_rm13,3,1);
$E=substr($h_rm13,4,1);
$F=substr($h_rm13,5,1);
$G=substr($h_rm13,6,1);
$H=substr($h_rm13,7,1);
$I=substr($h_rm13,8,1);
$J=substr($h_rm13,9,1);
$K=substr($h_rm13,10,1);
$L=substr($h_rm13,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");

$znamienko=" ";
if( $r13 < 0 ) { $znamienko="-"; $r13=-1*$r13; }
$h_r13=sprintf("% 12s",$r13);
$A=substr($h_r13,0,1);
$B=substr($h_r13,1,1);
$C=substr($h_r13,2,1);
$D=substr($h_r13,3,1);
$E=substr($h_r13,4,1);
$F=substr($h_r13,5,1);
$G=substr($h_r13,6,1);
$H=substr($h_r13,7,1);
$I=substr($h_r13,8,1);
$J=substr($h_r13,9,1);
$K=substr($h_r13,10,1);
$L=substr($h_r13,11,1);
$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 14
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm14=sprintf("% 12s",$rm14);
$A=substr($h_rm14,0,1);
$B=substr($h_rm14,1,1);
$C=substr($h_rm14,2,1);
$D=substr($h_rm14,3,1);
$E=substr($h_rm14,4,1);
$F=substr($h_rm14,5,1);
$G=substr($h_rm14,6,1);
$H=substr($h_rm14,7,1);
$I=substr($h_rm14,8,1);
$J=substr($h_rm14,9,1);
$K=substr($h_rm14,10,1);
$L=substr($h_rm14,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r14=sprintf("% 12s",$r14);
$A=substr($h_r14,0,1);
$B=substr($h_r14,1,1);
$C=substr($h_r14,2,1);
$D=substr($h_r14,3,1);
$E=substr($h_r14,4,1);
$F=substr($h_r14,5,1);
$G=substr($h_r14,6,1);
$H=substr($h_r14,7,1);
$I=substr($h_r14,8,1);
$J=substr($h_r14,9,1);
$K=substr($h_r14,10,1);
$L=substr($h_r14,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 15
$pdf->Cell(100,4," ","$rmc1",1,"L");
$znamienko=" ";
if( $rm15 < 0 ) { $znamienko="-"; $rm15=-1*$rm15; }
$h_rm15=sprintf("% 12s",$rm15);
$A=substr($h_rm15,0,1);
$B=substr($h_rm15,1,1);
$C=substr($h_rm15,2,1);
$D=substr($h_rm15,3,1);
$E=substr($h_rm15,4,1);
$F=substr($h_rm15,5,1);
$G=substr($h_rm15,6,1);
$H=substr($h_rm15,7,1);
$I=substr($h_rm15,8,1);
$J=substr($h_rm15,9,1);
$K=substr($h_rm15,10,1);
$L=substr($h_rm15,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$znamienko=" ";
if( $r15 < 0 ) { $znamienko="-"; $r15=-1*$r15; }
$h_r15=sprintf("% 12s",$r15);
$A=substr($h_r15,0,1);
$B=substr($h_r15,1,1);
$C=substr($h_r15,2,1);
$D=substr($h_r15,3,1);
$E=substr($h_r15,4,1);
$F=substr($h_r15,5,1);
$G=substr($h_r15,6,1);
$H=substr($h_r15,7,1);
$I=substr($h_r15,8,1);
$J=substr($h_r15,9,1);
$K=substr($h_r15,10,1);
$L=substr($h_r15,11,1);
$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//ZAVAZKY
//riadok 16
$pdf->Cell(100,18," ","$rmc1",1,"L");
$h_rm16=sprintf("% 12s",$rm16);
$A=substr($h_rm16,0,1);
$B=substr($h_rm16,1,1);
$C=substr($h_rm16,2,1);
$D=substr($h_rm16,3,1);
$E=substr($h_rm16,4,1);
$F=substr($h_rm16,5,1);
$G=substr($h_rm16,6,1);
$H=substr($h_rm16,7,1);
$I=substr($h_rm16,8,1);
$J=substr($h_rm16,9,1);
$K=substr($h_rm16,10,1);
$L=substr($h_rm16,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r16=sprintf("% 12s",$r16);
$A=substr($h_r16,0,1);
$B=substr($h_r16,1,1);
$C=substr($h_r16,2,1);
$D=substr($h_r16,3,1);
$E=substr($h_r16,4,1);
$F=substr($h_r16,5,1);
$G=substr($h_r16,6,1);
$H=substr($h_r16,7,1);
$I=substr($h_r16,8,1);
$J=substr($h_r16,9,1);
$K=substr($h_r16,10,1);
$L=substr($h_r16,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 17
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm17=sprintf("% 12s",$rm17);
$A=substr($h_rm17,0,1);
$B=substr($h_rm17,1,1);
$C=substr($h_rm17,2,1);
$D=substr($h_rm17,3,1);
$E=substr($h_rm17,4,1);
$F=substr($h_rm17,5,1);
$G=substr($h_rm17,6,1);
$H=substr($h_rm17,7,1);
$I=substr($h_rm17,8,1);
$J=substr($h_rm17,9,1);
$K=substr($h_rm17,10,1);
$L=substr($h_rm17,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r17=sprintf("% 12s",$r17);
$A=substr($h_r17,0,1);
$B=substr($h_r17,1,1);
$C=substr($h_r17,2,1);
$D=substr($h_r17,3,1);
$E=substr($h_r17,4,1);
$F=substr($h_r17,5,1);
$G=substr($h_r17,6,1);
$H=substr($h_r17,7,1);
$I=substr($h_r17,8,1);
$J=substr($h_r17,9,1);
$K=substr($h_r17,10,1);
$L=substr($h_r17,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 18
$pdf->Cell(100,5," ","$rmc1",1,"L");
$h_rm18=sprintf("% 12s",$rm18);
$A=substr($h_rm18,0,1);
$B=substr($h_rm18,1,1);
$C=substr($h_rm18,2,1);
$D=substr($h_rm18,3,1);
$E=substr($h_rm18,4,1);
$F=substr($h_rm18,5,1);
$G=substr($h_rm18,6,1);
$H=substr($h_rm18,7,1);
$I=substr($h_rm18,8,1);
$J=substr($h_rm18,9,1);
$K=substr($h_rm18,10,1);
$L=substr($h_rm18,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r18=sprintf("% 12s",$r18);
$A=substr($h_r18,0,1);
$B=substr($h_r18,1,1);
$C=substr($h_r18,2,1);
$D=substr($h_r18,3,1);
$E=substr($h_r18,4,1);
$F=substr($h_r18,5,1);
$G=substr($h_r18,6,1);
$H=substr($h_r18,7,1);
$I=substr($h_r18,8,1);
$J=substr($h_r18,9,1);
$K=substr($h_r18,10,1);
$L=substr($h_r18,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 19
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm19=sprintf("% 12s",$rm19);
$A=substr($h_rm19,0,1);
$B=substr($h_rm19,1,1);
$C=substr($h_rm19,2,1);
$D=substr($h_rm19,3,1);
$E=substr($h_rm19,4,1);
$F=substr($h_rm19,5,1);
$G=substr($h_rm19,6,1);
$H=substr($h_rm19,7,1);
$I=substr($h_rm19,8,1);
$J=substr($h_rm19,9,1);
$K=substr($h_rm19,10,1);
$L=substr($h_rm19,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");

$h_r19=sprintf("% 12s",$r19);
$A=substr($h_r19,0,1);
$B=substr($h_r19,1,1);
$C=substr($h_r19,2,1);
$D=substr($h_r19,3,1);
$E=substr($h_r19,4,1);
$F=substr($h_r19,5,1);
$G=substr($h_r19,6,1);
$H=substr($h_r19,7,1);
$I=substr($h_r19,8,1);
$J=substr($h_r19,9,1);
$K=substr($h_r19,10,1);
$L=substr($h_r19,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 20
$pdf->Cell(100,4," ","$rmc1",1,"L");
$h_rm20=sprintf("% 12s",$rm20);
$A=substr($h_rm20,0,1);
$B=substr($h_rm20,1,1);
$C=substr($h_rm20,2,1);
$D=substr($h_rm20,3,1);
$E=substr($h_rm20,4,1);
$F=substr($h_rm20,5,1);
$G=substr($h_rm20,6,1);
$H=substr($h_rm20,7,1);
$I=substr($h_rm20,8,1);
$J=substr($h_rm20,9,1);
$K=substr($h_rm20,10,1);
$L=substr($h_rm20,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$h_r20=sprintf("% 12s",$r20);
$A=substr($h_r20,0,1);
$B=substr($h_r20,1,1);
$C=substr($h_r20,2,1);
$D=substr($h_r20,3,1);
$E=substr($h_r20,4,1);
$F=substr($h_r20,5,1);
$G=substr($h_r20,6,1);
$H=substr($h_r20,7,1);
$I=substr($h_r20,8,1);
$J=substr($h_r20,9,1);
$K=substr($h_r20,10,1);
$L=substr($h_r20,11,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

//riadok 21
$pdf->Cell(100,4," ","$rmc1",1,"L");
$znamienko=" ";
if( $rm21 < 0 ) { $znamienko="-"; $rm21=-1*$rm21; }
$h_rm21=sprintf("% 12s",$rm21);
$A=substr($h_rm21,0,1);
$B=substr($h_rm21,1,1);
$C=substr($h_rm21,2,1);
$D=substr($h_rm21,3,1);
$E=substr($h_rm21,4,1);
$F=substr($h_rm21,5,1);
$G=substr($h_rm21,6,1);
$H=substr($h_rm21,7,1);
$I=substr($h_rm21,8,1);
$J=substr($h_rm21,9,1);
$K=substr($h_rm21,10,1);
$L=substr($h_rm21,11,1);
$pdf->Cell(65,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"C");
$znamienko=" ";
if( $r21 < 0 ) { $znamienko="-"; $r21=-1*$r21; }
$h_r21=sprintf("% 12s",$r21);
$A=substr($h_r21,0,1);
$B=substr($h_r21,1,1);
$C=substr($h_r21,2,1);
$D=substr($h_r21,3,1);
$E=substr($h_r21,4,1);
$F=substr($h_r21,5,1);
$G=substr($h_r21,6,1);
$H=substr($h_r21,7,1);
$I=substr($h_r21,8,1);
$J=substr($h_r21,9,1);
$K=substr($h_r21,10,1);
$L=substr($h_r21,11,1);
$pdf->Cell(4,6,"$znamienko","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",1,"C");

}
$i = $i + 1;
  }
//koniec while majzav




$pdf->Output("$outfilex");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds1000x'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvmajzavs'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvmajzavs1000x'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzavierka JU PDF</title>
</HEAD>
<BODY class="white">
<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>
