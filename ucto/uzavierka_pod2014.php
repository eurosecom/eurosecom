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



$kompletka = 1*$_REQUEST['kompletka'];
$lenvzs = 1*$_REQUEST['lenvzs'];
$lensuv = 1*$_REQUEST['lensuv'];
$tlacsuv=1;
$tlacvzs=1;
if( $lensuv == 0 ) { $tlacsuv=0; }
if( $lenvzs == 0 ) { $tlacvzs=0; }

//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-1.jpg',0,0,210,297);
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
$pdf->Cell(190,15," ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,28," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
//dopyt, chýba priebežná
$pdf->SetFont('arial','',8);
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
$pdf->SetY(62);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadna","$rmc",0,"C");
$pdf->SetY(71);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$mimor","$rmc",0,"C");
$pdf->SetY(80);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$priebez","$rmc",0,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
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
$pdf->SetY(58);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$me1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(67);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$Am","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Bm","$rmc",0,"C");
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
$pdf->SetY(76);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$mep1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
}
$pdf->SetY(85);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$mepm1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//nazov
$pdf->Cell(190,22," ","$rmc1",1,"L");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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

//Sidlo uctovej jednotky
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
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

//obchodny register
$pdf->Cell(190,7," ","$rmc1",1,"L");
$A=substr($fir_obreg,0,1);
$B=substr($fir_obreg,1,1);
$C=substr($fir_obreg,2,1);
$D=substr($fir_obreg,3,1);
$E=substr($fir_obreg,4,1);
$F=substr($fir_obreg,5,1);
$G=substr($fir_obreg,6,1);
$H=substr($fir_obreg,7,1);
$I=substr($fir_obreg,8,1);
$J=substr($fir_obreg,9,1);
$K=substr($fir_obreg,10,1);
$L=substr($fir_obreg,11,1);
$M=substr($fir_obreg,12,1);
$N=substr($fir_obreg,13,1);
$O=substr($fir_obreg,14,1);
$P=substr($fir_obreg,15,1);
$R=substr($fir_obreg,16,1);
$S=substr($fir_obreg,17,1);
$T=substr($fir_obreg,18,1);
$U=substr($fir_obreg,19,1);
$V=substr($fir_obreg,20,1);
$W=substr($fir_obreg,21,1);
$X=substr($fir_obreg,22,1);
$Y=substr($fir_obreg,23,1);
$Z=substr($fir_obreg,24,1);
$A1=substr($fir_obreg,25,1);
$B1=substr($fir_obreg,26,1);
$C1=substr($fir_obreg,27,1);
$D1=substr($fir_obreg,28,1);
$E1=substr($fir_obreg,29,1);
$F1=substr($fir_obreg,30,1);
$G1=substr($fir_obreg,31,1);
$H1=substr($fir_obreg,32,1);
$I1=substr($fir_obreg,33,1);
$J1=substr($fir_obreg,34,1);
$K1=substr($fir_obreg,35,1);
$L1=substr($fir_obreg,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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


$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_obregr2="";
$A=substr($fir_obregr2,0,1);
$B=substr($fir_obregr2,1,1);
$C=substr($fir_obregr2,2,1);
$D=substr($fir_obregr2,3,1);
$E=substr($fir_obregr2,4,1);
$F=substr($fir_obregr2,5,1);
$G=substr($fir_obregr2,6,1);
$H=substr($fir_obregr2,7,1);
$I=substr($fir_obregr2,8,1);
$J=substr($fir_obregr2,9,1);
$K=substr($fir_obregr2,10,1);
$L=substr($fir_obregr2,11,1);
$M=substr($fir_obregr2,12,1);
$N=substr($fir_obregr2,13,1);
$O=substr($fir_obregr2,14,1);
$P=substr($fir_obregr2,15,1);
$R=substr($fir_obregr2,16,1);
$S=substr($fir_obregr2,17,1);
$T=substr($fir_obregr2,18,1);
$U=substr($fir_obregr2,19,1);
$V=substr($fir_obregr2,20,1);
$W=substr($fir_obregr2,21,1);
$X=substr($fir_obregr2,22,1);
$Y=substr($fir_obregr2,23,1);
$Z=substr($fir_obregr2,24,1);
$A1=substr($fir_obregr2,25,1);
$B1=substr($fir_obregr2,26,1);
$C1=substr($fir_obregr2,27,1);
$D1=substr($fir_obregr2,28,1);
$E1=substr($fir_obregr2,29,1);
$F1=substr($fir_obregr2,30,1);
$G1=substr($fir_obregr2,31,1);
$H1=substr($fir_obregr2,32,1);
$I1=substr($fir_obregr2,33,1);
$J1=substr($fir_obregr2,34,1);
$K1=substr($fir_obregr2,35,1);
$L1=substr($fir_obregr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");

//cislo faxu
$t01=substr($fir_ffax,0,1);
$t02=substr($fir_ffax,1,1);
$t03=substr($fir_ffax,2,1);
$t04=substr($fir_ffax,3,1);
$t05=substr($fir_ffax,4,1);
$t06=substr($fir_ffax,5,1);
$t07=substr($fir_ffax,6,1);
$t08=substr($fir_ffax,7,1);
$t09=substr($fir_ffax,8,1);
$t10=substr($fir_ffax,9,1);
$t11=substr($fir_ffax,10,1);
$t12=substr($fir_ffax,11,1);
$t13=substr($fir_ffax,12,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
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
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
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
$pdf->Cell(190,9," ","$rcm1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//datum schvalenia
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(5,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//odkaz na datum uzavierky k
//podla mna zbytocne
$pdf->SetY(25);
$pdf->SetX(60);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
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
//koniec prva strana


//tlacit suvahu
if( $tlacsuv == 1 ) {

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid." WHERE prx = 1 "; 

if( $tis > 0 ) { 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 "; 

}

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//V pod 2014 POUZIVAME LEN STLPCE r01-r78,rk01-rk78,rn01-rn145 a rm01-rm145
$rn01=$hlavicka->rn01; if ( $hlavicka->rn01 == 0 ) $rn01='';
$rn02=$hlavicka->rn02; if ( $hlavicka->rn02 == 0 ) $rn02='';
$rn03=$hlavicka->rn03; if ( $hlavicka->rn03 == 0 ) $rn03='';
$rn04=$hlavicka->rn04; if ( $hlavicka->rn04 == 0 ) $rn04='';
$rn05=$hlavicka->rn05; if ( $hlavicka->rn05 == 0 ) $rn05='';
$rn06=$hlavicka->rn06; if ( $hlavicka->rn06 == 0 ) $rn06='';
$rn07=$hlavicka->rn07; if ( $hlavicka->rn07 == 0 ) $rn07='';
$rn08=$hlavicka->rn08; if ( $hlavicka->rn08 == 0 ) $rn08='';
$rn09=$hlavicka->rn09; if ( $hlavicka->rn09 == 0 ) $rn09='';
$rn10=$hlavicka->rn10; if ( $hlavicka->rn10 == 0 ) $rn10='';
$rn11=$hlavicka->rn11; if ( $hlavicka->rn11 == 0 ) $rn11='';
$rn12=$hlavicka->rn12; if ( $hlavicka->rn12 == 0 ) $rn12='';
$rn13=$hlavicka->rn13; if ( $hlavicka->rn13 == 0 ) $rn13='';
$rn14=$hlavicka->rn14; if ( $hlavicka->rn14 == 0 ) $rn14='';
$rn15=$hlavicka->rn15; if ( $hlavicka->rn15 == 0 ) $rn15='';
$rn16=$hlavicka->rn16; if ( $hlavicka->rn16 == 0 ) $rn16='';
$rn17=$hlavicka->rn17; if ( $hlavicka->rn17 == 0 ) $rn17='';
$rn18=$hlavicka->rn18; if ( $hlavicka->rn18 == 0 ) $rn18='';
$rn19=$hlavicka->rn19; if ( $hlavicka->rn19 == 0 ) $rn19='';
$rn20=$hlavicka->rn20; if ( $hlavicka->rn20 == 0 ) $rn20='';
$rn21=$hlavicka->rn21; if ( $hlavicka->rn21 == 0 ) $rn21='';
$rn22=$hlavicka->rn22; if ( $hlavicka->rn22 == 0 ) $rn22='';
$rn23=$hlavicka->rn23; if ( $hlavicka->rn23 == 0 ) $rn23='';
$rn24=$hlavicka->rn24; if ( $hlavicka->rn24 == 0 ) $rn24='';
$rn25=$hlavicka->rn25; if ( $hlavicka->rn25 == 0 ) $rn25='';
$rn26=$hlavicka->rn26; if ( $hlavicka->rn26 == 0 ) $rn26='';
$rn27=$hlavicka->rn27; if ( $hlavicka->rn27 == 0 ) $rn27='';
$rn28=$hlavicka->rn28; if ( $hlavicka->rn28 == 0 ) $rn28='';
$rn29=$hlavicka->rn29; if ( $hlavicka->rn29 == 0 ) $rn29='';
$rn30=$hlavicka->rn30; if ( $hlavicka->rn30 == 0 ) $rn30='';
$rn31=$hlavicka->rn31; if ( $hlavicka->rn31 == 0 ) $rn31='';
$rn32=$hlavicka->rn32; if ( $hlavicka->rn32 == 0 ) $rn32='';
$rn33=$hlavicka->rn33; if ( $hlavicka->rn33 == 0 ) $rn33='';
$rn34=$hlavicka->rn34; if ( $hlavicka->rn34 == 0 ) $rn34='';
$rn35=$hlavicka->rn35; if ( $hlavicka->rn35 == 0 ) $rn35='';
$rn36=$hlavicka->rn36; if ( $hlavicka->rn36 == 0 ) $rn36='';
$rn37=$hlavicka->rn37; if ( $hlavicka->rn37 == 0 ) $rn37='';
$rn38=$hlavicka->rn38; if ( $hlavicka->rn38 == 0 ) $rn38='';
$rn39=$hlavicka->rn39; if ( $hlavicka->rn39 == 0 ) $rn39='';
$rn40=$hlavicka->rn40; if ( $hlavicka->rn40 == 0 ) $rn40='';
$rn41=$hlavicka->rn41; if ( $hlavicka->rn41 == 0 ) $rn41='';
$rn42=$hlavicka->rn42; if ( $hlavicka->rn42 == 0 ) $rn42='';
$rn43=$hlavicka->rn43; if ( $hlavicka->rn43 == 0 ) $rn43='';
$rn44=$hlavicka->rn44; if ( $hlavicka->rn44 == 0 ) $rn44='';
$rn45=$hlavicka->rn45; if ( $hlavicka->rn45 == 0 ) $rn45='';


$sqlttps = "SELECT * FROM F$kli_vxcf"."_pos_pod2014 WHERE dok > 0 ORDER BY dok "; 
$sqlps = mysql_query("$sqlttps");
if($sqlps) { $polps = mysql_num_rows($sqlps); }

$ips=0;
  while ($ips <= $polps )
  {
  if (@$zaznam=mysql_data_seek($sqlps,$ips))
{
$hlavickps=mysql_fetch_object($sqlps);

$riadok=1*$hlavickps->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickps->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickps->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickps->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickps->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickps->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickps->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickps->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickps->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickps->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickps->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickps->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickps->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickps->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickps->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickps->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickps->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickps->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickps->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickps->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickps->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickps->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickps->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickps->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickps->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickps->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickps->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickps->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickps->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickps->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickps->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickps->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickps->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickps->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickps->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickps->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickps->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickps->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickps->hod; }
if( $riadok == 39 ) { $rm39=1*$hlavickps->hod; }
if( $riadok == 40 ) { $rm40=1*$hlavickps->hod; }
if( $riadok == 41 ) { $rm41=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 43 ) { $rm43=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 45 ) { $rm45=1*$hlavickps->hod; }

}
$ips = $ips + 1;
  }


//strana 2
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-2.jpg') )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//AKTIVA
//riadok 1
$pdf->Cell(190,15," ","$rmc1",1,"L");
$rn01=sprintf('% 11s',$rn01);
$A=substr($rn01,0,1);
$B=substr($rn01,1,1);
$C=substr($rn01,2,1);
$D=substr($rn01,3,1);
$E=substr($rn01,4,1);
$F=substr($rn01,5,1);
$G=substr($rn01,6,1);
$H=substr($rn01,7,1);
$I=substr($rn01,8,1);
$J=substr($rn01,9,1);
$K=substr($rn01,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm01=sprintf('% 11s',$rm01);
$A=substr($rm01,0,1);
$B=substr($rm01,1,1);
$C=substr($rm01,2,1);
$D=substr($rm01,3,1);
$E=substr($rm01,4,1);
$F=substr($rm01,5,1);
$G=substr($rm01,6,1);
$H=substr($rm01,7,1);
$I=substr($rm01,8,1);
$J=substr($rm01,9,1);
$K=substr($rm01,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 2
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn02=sprintf('% 11s',$rn02);
$A=substr($rn02,0,1);
$B=substr($rn02,1,1);
$C=substr($rn02,2,1);
$D=substr($rn02,3,1);
$E=substr($rn02,4,1);
$F=substr($rn02,5,1);
$G=substr($rn02,6,1);
$H=substr($rn02,7,1);
$I=substr($rn02,8,1);
$J=substr($rn02,9,1);
$K=substr($rn02,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm02=sprintf('% 11s',$rm02);
$A=substr($rm02,0,1);
$B=substr($rm02,1,1);
$C=substr($rm02,2,1);
$D=substr($rm02,3,1);
$E=substr($rm02,4,1);
$F=substr($rm02,5,1);
$G=substr($rm02,6,1);
$H=substr($rm02,7,1);
$I=substr($rm02,8,1);
$J=substr($rm02,9,1);
$K=substr($rm02,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 3
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn03=sprintf('% 11s',$rn03);
$A=substr($rn03,0,1);
$B=substr($rn03,1,1);
$C=substr($rn03,2,1);
$D=substr($rn03,3,1);
$E=substr($rn03,4,1);
$F=substr($rn03,5,1);
$G=substr($rn03,6,1);
$H=substr($rn03,7,1);
$I=substr($rn03,8,1);
$J=substr($rn03,9,1);
$K=substr($rn03,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm03=sprintf('% 11s',$rm03);
$A=substr($rm03,0,1);
$B=substr($rm03,1,1);
$C=substr($rm03,2,1);
$D=substr($rm03,3,1);
$E=substr($rm03,4,1);
$F=substr($rm03,5,1);
$G=substr($rm03,6,1);
$H=substr($rm03,7,1);
$I=substr($rm03,8,1);
$J=substr($rm03,9,1);
$K=substr($rm03,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 4
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn04=sprintf('% 11s',$rn04);
$A=substr($rn04,0,1);
$B=substr($rn04,1,1);
$C=substr($rn04,2,1);
$D=substr($rn04,3,1);
$E=substr($rn04,4,1);
$F=substr($rn04,5,1);
$G=substr($rn04,6,1);
$H=substr($rn04,7,1);
$I=substr($rn04,8,1);
$J=substr($rn04,9,1);
$K=substr($rn04,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm04=sprintf('% 11s',$rm04);
$A=substr($rm04,0,1);
$B=substr($rm04,1,1);
$C=substr($rm04,2,1);
$D=substr($rm04,3,1);
$E=substr($rm04,4,1);
$F=substr($rm04,5,1);
$G=substr($rm04,6,1);
$H=substr($rm04,7,1);
$I=substr($rm04,8,1);
$J=substr($rm04,9,1);
$K=substr($rm04,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 5
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn05=sprintf('% 11s',$rn05);
$A=substr($rn05,0,1);
$B=substr($rn05,1,1);
$C=substr($rn05,2,1);
$D=substr($rn05,3,1);
$E=substr($rn05,4,1);
$F=substr($rn05,5,1);
$G=substr($rn05,6,1);
$H=substr($rn05,7,1);
$I=substr($rn05,8,1);
$J=substr($rn05,9,1);
$K=substr($rn05,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm05=sprintf('% 11s',$rm05);
$A=substr($rm05,0,1);
$B=substr($rm05,1,1);
$C=substr($rm05,2,1);
$D=substr($rm05,3,1);
$E=substr($rm05,4,1);
$F=substr($rm05,5,1);
$G=substr($rm05,6,1);
$H=substr($rm05,7,1);
$I=substr($rm05,8,1);
$J=substr($rm05,9,1);
$K=substr($rm05,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 6
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn06=sprintf('% 11s',$rn06);
$A=substr($rn06,0,1);
$B=substr($rn06,1,1);
$C=substr($rn06,2,1);
$D=substr($rn06,3,1);
$E=substr($rn06,4,1);
$F=substr($rn06,5,1);
$G=substr($rn06,6,1);
$H=substr($rn06,7,1);
$I=substr($rn06,8,1);
$J=substr($rn06,9,1);
$K=substr($rn06,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm06=sprintf('% 11s',$rm06);
$A=substr($rm06,0,1);
$B=substr($rm06,1,1);
$C=substr($rm06,2,1);
$D=substr($rm06,3,1);
$E=substr($rm06,4,1);
$F=substr($rm06,5,1);
$G=substr($rm06,6,1);
$H=substr($rm06,7,1);
$I=substr($rm06,8,1);
$J=substr($rm06,9,1);
$K=substr($rm06,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 7
$pdf->Cell(190,6," ","$rmc1",1,"L");
$rn07=sprintf('% 11s',$rn07);
$A=substr($rn07,0,1);
$B=substr($rn07,1,1);
$C=substr($rn07,2,1);
$D=substr($rn07,3,1);
$E=substr($rn07,4,1);
$F=substr($rn07,5,1);
$G=substr($rn07,6,1);
$H=substr($rn07,7,1);
$I=substr($rn07,8,1);
$J=substr($rn07,9,1);
$K=substr($rn07,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm07=sprintf('% 11s',$rm07);
$A=substr($rm07,0,1);
$B=substr($rm07,1,1);
$C=substr($rm07,2,1);
$D=substr($rm07,3,1);
$E=substr($rm07,4,1);
$F=substr($rm07,5,1);
$G=substr($rm07,6,1);
$H=substr($rm07,7,1);
$I=substr($rm07,8,1);
$J=substr($rm07,9,1);
$K=substr($rm07,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 8
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn08=sprintf('% 11s',$rn08);
$A=substr($rn08,0,1);
$B=substr($rn08,1,1);
$C=substr($rn08,2,1);
$D=substr($rn08,3,1);
$E=substr($rn08,4,1);
$F=substr($rn08,5,1);
$G=substr($rn08,6,1);
$H=substr($rn08,7,1);
$I=substr($rn08,8,1);
$J=substr($rn08,9,1);
$K=substr($rn08,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm08=sprintf('% 11s',$rm08);
$A=substr($rm08,0,1);
$B=substr($rm08,1,1);
$C=substr($rm08,2,1);
$D=substr($rm08,3,1);
$E=substr($rm08,4,1);
$F=substr($rm08,5,1);
$G=substr($rm08,6,1);
$H=substr($rm08,7,1);
$I=substr($rm08,8,1);
$J=substr($rm08,9,1);
$K=substr($rm08,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 9
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn09=sprintf('% 11s',$rn09);
$A=substr($rn09,0,1);
$B=substr($rn09,1,1);
$C=substr($rn09,2,1);
$D=substr($rn09,3,1);
$E=substr($rn09,4,1);
$F=substr($rn09,5,1);
$G=substr($rn09,6,1);
$H=substr($rn09,7,1);
$I=substr($rn09,8,1);
$J=substr($rn09,9,1);
$K=substr($rn09,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm09=sprintf('% 11s',$rm09);
$A=substr($rm09,0,1);
$B=substr($rm09,1,1);
$C=substr($rm09,2,1);
$D=substr($rm09,3,1);
$E=substr($rm09,4,1);
$F=substr($rm09,5,1);
$G=substr($rm09,6,1);
$H=substr($rm09,7,1);
$I=substr($rm09,8,1);
$J=substr($rm09,9,1);
$K=substr($rm09,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 10
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn10=sprintf('% 11s',$rn10);
$A=substr($rn10,0,1);
$B=substr($rn10,1,1);
$C=substr($rn10,2,1);
$D=substr($rn10,3,1);
$E=substr($rn10,4,1);
$F=substr($rn10,5,1);
$G=substr($rn10,6,1);
$H=substr($rn10,7,1);
$I=substr($rn10,8,1);
$J=substr($rn10,9,1);
$K=substr($rn10,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm10=sprintf('% 11s',$rm10);
$A=substr($rm10,0,1);
$B=substr($rm10,1,1);
$C=substr($rm10,2,1);
$D=substr($rm10,3,1);
$E=substr($rm10,4,1);
$F=substr($rm10,5,1);
$G=substr($rm10,6,1);
$H=substr($rm10,7,1);
$I=substr($rm10,8,1);
$J=substr($rm10,9,1);
$K=substr($rm10,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 11
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn11=sprintf('% 11s',$rn11);
$A=substr($rn11,0,1);
$B=substr($rn11,1,1);
$C=substr($rn11,2,1);
$D=substr($rn11,3,1);
$E=substr($rn11,4,1);
$F=substr($rn11,5,1);
$G=substr($rn11,6,1);
$H=substr($rn11,7,1);
$I=substr($rn11,8,1);
$J=substr($rn11,9,1);
$K=substr($rn11,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm11=sprintf('% 11s',$rm11);
$A=substr($rm11,0,1);
$B=substr($rm11,1,1);
$C=substr($rm11,2,1);
$D=substr($rm11,3,1);
$E=substr($rm11,4,1);
$F=substr($rm11,5,1);
$G=substr($rm11,6,1);
$H=substr($rm11,7,1);
$I=substr($rm11,8,1);
$J=substr($rm11,9,1);
$K=substr($rm11,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 12
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn12=sprintf('% 11s',$rn12);
$A=substr($rn12,0,1);
$B=substr($rn12,1,1);
$C=substr($rn12,2,1);
$D=substr($rn12,3,1);
$E=substr($rn12,4,1);
$F=substr($rn12,5,1);
$G=substr($rn12,6,1);
$H=substr($rn12,7,1);
$I=substr($rn12,8,1);
$J=substr($rn12,9,1);
$K=substr($rn12,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm12=sprintf('% 11s',$rm12);
$A=substr($rm12,0,1);
$B=substr($rm12,1,1);
$C=substr($rm12,2,1);
$D=substr($rm12,3,1);
$E=substr($rm12,4,1);
$F=substr($rm12,5,1);
$G=substr($rm12,6,1);
$H=substr($rm12,7,1);
$I=substr($rm12,8,1);
$J=substr($rm12,9,1);
$K=substr($rm12,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 13
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn13=sprintf('% 11s',$rn13);
$A=substr($rn13,0,1);
$B=substr($rn13,1,1);
$C=substr($rn13,2,1);
$D=substr($rn13,3,1);
$E=substr($rn13,4,1);
$F=substr($rn13,5,1);
$G=substr($rn13,6,1);
$H=substr($rn13,7,1);
$I=substr($rn13,8,1);
$J=substr($rn13,9,1);
$K=substr($rn13,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm13=sprintf('% 11s',$rm13);
$A=substr($rm13,0,1);
$B=substr($rm13,1,1);
$C=substr($rm13,2,1);
$D=substr($rm13,3,1);
$E=substr($rm13,4,1);
$F=substr($rm13,5,1);
$G=substr($rm13,6,1);
$H=substr($rm13,7,1);
$I=substr($rm13,8,1);
$J=substr($rm13,9,1);
$K=substr($rm13,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 14
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn14=sprintf('% 11s',$rn14);
$A=substr($rn14,0,1);
$B=substr($rn14,1,1);
$C=substr($rn14,2,1);
$D=substr($rn14,3,1);
$E=substr($rn14,4,1);
$F=substr($rn14,5,1);
$G=substr($rn14,6,1);
$H=substr($rn14,7,1);
$I=substr($rn14,8,1);
$J=substr($rn14,9,1);
$K=substr($rn14,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm14=sprintf('% 11s',$rm14);
$A=substr($rm14,0,1);
$B=substr($rm14,1,1);
$C=substr($rm14,2,1);
$D=substr($rm14,3,1);
$E=substr($rm14,4,1);
$F=substr($rm14,5,1);
$G=substr($rm14,6,1);
$H=substr($rm14,7,1);
$I=substr($rm14,8,1);
$J=substr($rm14,9,1);
$K=substr($rm14,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 15
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn15=sprintf('% 11s',$rn15);
$A=substr($rn15,0,1);
$B=substr($rn15,1,1);
$C=substr($rn15,2,1);
$D=substr($rn15,3,1);
$E=substr($rn15,4,1);
$F=substr($rn15,5,1);
$G=substr($rn15,6,1);
$H=substr($rn15,7,1);
$I=substr($rn15,8,1);
$J=substr($rn15,9,1);
$K=substr($rn15,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm15=sprintf('% 11s',$rm15);
$A=substr($rm15,0,1);
$B=substr($rm15,1,1);
$C=substr($rm15,2,1);
$D=substr($rm15,3,1);
$E=substr($rm15,4,1);
$F=substr($rm15,5,1);
$G=substr($rm15,6,1);
$H=substr($rm15,7,1);
$I=substr($rm15,8,1);
$J=substr($rm15,9,1);
$K=substr($rm15,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 16
$pdf->Cell(190,8," ","$rmc1",1,"L");
$rn16=sprintf('% 11s',$rn16);
$A=substr($rn16,0,1);
$B=substr($rn16,1,1);
$C=substr($rn16,2,1);
$D=substr($rn16,3,1);
$E=substr($rn16,4,1);
$F=substr($rn16,5,1);
$G=substr($rn16,6,1);
$H=substr($rn16,7,1);
$I=substr($rn16,8,1);
$J=substr($rn16,9,1);
$K=substr($rn16,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm16=sprintf('% 11s',$rm16);
$A=substr($rm16,0,1);
$B=substr($rm16,1,1);
$C=substr($rm16,2,1);
$D=substr($rm16,3,1);
$E=substr($rm16,4,1);
$F=substr($rm16,5,1);
$G=substr($rm16,6,1);
$H=substr($rm16,7,1);
$I=substr($rm16,8,1);
$J=substr($rm16,9,1);
$K=substr($rm16,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 17
$pdf->Cell(190,7," ","$rmc1",1,"L");
$rn17=sprintf('% 11s',$rn17);
$A=substr($rn17,0,1);
$B=substr($rn17,1,1);
$C=substr($rn17,2,1);
$D=substr($rn17,3,1);
$E=substr($rn17,4,1);
$F=substr($rn17,5,1);
$G=substr($rn17,6,1);
$H=substr($rn17,7,1);
$I=substr($rn17,8,1);
$J=substr($rn17,9,1);
$K=substr($rn17,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm17=sprintf('% 11s',$rm17);
$A=substr($rm17,0,1);
$B=substr($rm17,1,1);
$C=substr($rm17,2,1);
$D=substr($rm17,3,1);
$E=substr($rm17,4,1);
$F=substr($rm17,5,1);
$G=substr($rm17,6,1);
$H=substr($rm17,7,1);
$I=substr($rm17,8,1);
$J=substr($rm17,9,1);
$K=substr($rm17,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 18
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn18=sprintf('% 11s',$rn18);
$A=substr($rn18,0,1);
$B=substr($rn18,1,1);
$C=substr($rn18,2,1);
$D=substr($rn18,3,1);
$E=substr($rn18,4,1);
$F=substr($rn18,5,1);
$G=substr($rn18,6,1);
$H=substr($rn18,7,1);
$I=substr($rn18,8,1);
$J=substr($rn18,9,1);
$K=substr($rn18,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm18=sprintf('% 11s',$rm18);
$A=substr($rm18,0,1);
$B=substr($rm18,1,1);
$C=substr($rm18,2,1);
$D=substr($rm18,3,1);
$E=substr($rm18,4,1);
$F=substr($rm18,5,1);
$G=substr($rm18,6,1);
$H=substr($rm18,7,1);
$I=substr($rm18,8,1);
$J=substr($rm18,9,1);
$K=substr($rm18,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 19
$pdf->Cell(190,6," ","$rmc1",1,"L");
$rn19=sprintf('% 11s',$rn19);
$A=substr($rn19,0,1);
$B=substr($rn19,1,1);
$C=substr($rn19,2,1);
$D=substr($rn19,3,1);
$E=substr($rn19,4,1);
$F=substr($rn19,5,1);
$G=substr($rn19,6,1);
$H=substr($rn19,7,1);
$I=substr($rn19,8,1);
$J=substr($rn19,9,1);
$K=substr($rn19,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm19=sprintf('% 11s',$rm19);
$A=substr($rm19,0,1);
$B=substr($rm19,1,1);
$C=substr($rm19,2,1);
$D=substr($rm19,3,1);
$E=substr($rm19,4,1);
$F=substr($rm19,5,1);
$G=substr($rm19,6,1);
$H=substr($rm19,7,1);
$I=substr($rm19,8,1);
$J=substr($rm19,9,1);
$K=substr($rm19,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 20
$pdf->Cell(190,7," ","$rmc1",1,"L");
$rn20=sprintf('% 11s',$rn20);
$A=substr($rn20,0,1);
$B=substr($rn20,1,1);
$C=substr($rn20,2,1);
$D=substr($rn20,3,1);
$E=substr($rn20,4,1);
$F=substr($rn20,5,1);
$G=substr($rn20,6,1);
$H=substr($rn20,7,1);
$I=substr($rn20,8,1);
$J=substr($rn20,9,1);
$K=substr($rn20,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm20=sprintf('% 11s',$rm20);
$A=substr($rm20,0,1);
$B=substr($rm20,1,1);
$C=substr($rm20,2,1);
$D=substr($rm20,3,1);
$E=substr($rm20,4,1);
$F=substr($rm20,5,1);
$G=substr($rm20,6,1);
$H=substr($rm20,7,1);
$I=substr($rm20,8,1);
$J=substr($rm20,9,1);
$K=substr($rm20,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 21
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn21=sprintf('% 11s',$rn21);
$A=substr($rn21,0,1);
$B=substr($rn21,1,1);
$C=substr($rn21,2,1);
$D=substr($rn21,3,1);
$E=substr($rn21,4,1);
$F=substr($rn21,5,1);
$G=substr($rn21,6,1);
$H=substr($rn21,7,1);
$I=substr($rn21,8,1);
$J=substr($rn21,9,1);
$K=substr($rn21,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm21=sprintf('% 11s',$rm21);
$A=substr($rm21,0,1);
$B=substr($rm21,1,1);
$C=substr($rm21,2,1);
$D=substr($rm21,3,1);
$E=substr($rm21,4,1);
$F=substr($rm21,5,1);
$G=substr($rm21,6,1);
$H=substr($rm21,7,1);
$I=substr($rm21,8,1);
$J=substr($rm21,9,1);
$K=substr($rm21,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 22
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn22=sprintf('% 11s',$rn22);
$A=substr($rn22,0,1);
$B=substr($rn22,1,1);
$C=substr($rn22,2,1);
$D=substr($rn22,3,1);
$E=substr($rn22,4,1);
$F=substr($rn22,5,1);
$G=substr($rn22,6,1);
$H=substr($rn22,7,1);
$I=substr($rn22,8,1);
$J=substr($rn22,9,1);
$K=substr($rn22,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm22=sprintf('% 11s',$rm22);
$A=substr($rm22,0,1);
$B=substr($rm22,1,1);
$C=substr($rm22,2,1);
$D=substr($rm22,3,1);
$E=substr($rm22,4,1);
$F=substr($rm22,5,1);
$G=substr($rm22,6,1);
$H=substr($rm22,7,1);
$I=substr($rm22,8,1);
$J=substr($rm22,9,1);
$K=substr($rm22,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 23
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn23=sprintf('% 11s',$rn23);
$A=substr($rn23,0,1);
$B=substr($rn23,1,1);
$C=substr($rn23,2,1);
$D=substr($rn23,3,1);
$E=substr($rn23,4,1);
$F=substr($rn23,5,1);
$G=substr($rn23,6,1);
$H=substr($rn23,7,1);
$I=substr($rn23,8,1);
$J=substr($rn23,9,1);
$K=substr($rn23,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm23=sprintf('% 11s',$rm23);
$A=substr($rm23,0,1);
$B=substr($rm23,1,1);
$C=substr($rm23,2,1);
$D=substr($rm23,3,1);
$E=substr($rm23,4,1);
$F=substr($rm23,5,1);
$G=substr($rm23,6,1);
$H=substr($rm23,7,1);
$I=substr($rm23,8,1);
$J=substr($rm23,9,1);
$K=substr($rm23,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");


//strana 3
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-3.jpg') )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-3.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//PASIVA
//riadok 24
$pdf->Cell(190,15," ","$rmc1",1,"L");
$rn24=sprintf('% 11s',$rn24);
$A=substr($rn24,0,1);
$B=substr($rn24,1,1);
$C=substr($rn24,2,1);
$D=substr($rn24,3,1);
$E=substr($rn24,4,1);
$F=substr($rn24,5,1);
$G=substr($rn24,6,1);
$H=substr($rn24,7,1);
$I=substr($rn24,8,1);
$J=substr($rn24,9,1);
$K=substr($rn24,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm24=sprintf('% 11s',$rm24);
$A=substr($rm24,0,1);
$B=substr($rm24,1,1);
$C=substr($rm24,2,1);
$D=substr($rm24,3,1);
$E=substr($rm24,4,1);
$F=substr($rm24,5,1);
$G=substr($rm24,6,1);
$H=substr($rm24,7,1);
$I=substr($rm24,8,1);
$J=substr($rm24,9,1);
$K=substr($rm24,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 25
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn25=sprintf('% 11s',$rn25);
$A=substr($rn25,0,1);
$B=substr($rn25,1,1);
$C=substr($rn25,2,1);
$D=substr($rn25,3,1);
$E=substr($rn25,4,1);
$F=substr($rn25,5,1);
$G=substr($rn25,6,1);
$H=substr($rn25,7,1);
$I=substr($rn25,8,1);
$J=substr($rn25,9,1);
$K=substr($rn25,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm25=sprintf('% 11s',$rm25);
$A=substr($rm25,0,1);
$B=substr($rm25,1,1);
$C=substr($rm25,2,1);
$D=substr($rm25,3,1);
$E=substr($rm25,4,1);
$F=substr($rm25,5,1);
$G=substr($rm25,6,1);
$H=substr($rm25,7,1);
$I=substr($rm25,8,1);
$J=substr($rm25,9,1);
$K=substr($rm25,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 26
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn26=sprintf('% 11s',$rn26);
$A=substr($rn26,0,1);
$B=substr($rn26,1,1);
$C=substr($rn26,2,1);
$D=substr($rn26,3,1);
$E=substr($rn26,4,1);
$F=substr($rn26,5,1);
$G=substr($rn26,6,1);
$H=substr($rn26,7,1);
$I=substr($rn26,8,1);
$J=substr($rn26,9,1);
$K=substr($rn26,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm26=sprintf('% 11s',$rm26);
$A=substr($rm26,0,1);
$B=substr($rm26,1,1);
$C=substr($rm26,2,1);
$D=substr($rm26,3,1);
$E=substr($rm26,4,1);
$F=substr($rm26,5,1);
$G=substr($rm26,6,1);
$H=substr($rm26,7,1);
$I=substr($rm26,8,1);
$J=substr($rm26,9,1);
$K=substr($rm26,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 27
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn27=sprintf('% 11s',$rn27);
$A=substr($rn27,0,1);
$B=substr($rn27,1,1);
$C=substr($rn27,2,1);
$D=substr($rn27,3,1);
$E=substr($rn27,4,1);
$F=substr($rn27,5,1);
$G=substr($rn27,6,1);
$H=substr($rn27,7,1);
$I=substr($rn27,8,1);
$J=substr($rn27,9,1);
$K=substr($rn27,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm27=sprintf('% 11s',$rm27);
$A=substr($rm27,0,1);
$B=substr($rm27,1,1);
$C=substr($rm27,2,1);
$D=substr($rm27,3,1);
$E=substr($rm27,4,1);
$F=substr($rm27,5,1);
$G=substr($rm27,6,1);
$H=substr($rm27,7,1);
$I=substr($rm27,8,1);
$J=substr($rm27,9,1);
$K=substr($rm27,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 28
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn28=sprintf('% 11s',$rn28);
$A=substr($rn28,0,1);
$B=substr($rn28,1,1);
$C=substr($rn28,2,1);
$D=substr($rn28,3,1);
$E=substr($rn28,4,1);
$F=substr($rn28,5,1);
$G=substr($rn28,6,1);
$H=substr($rn28,7,1);
$I=substr($rn28,8,1);
$J=substr($rn28,9,1);
$K=substr($rn28,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm28=sprintf('% 11s',$rm28);
$A=substr($rm28,0,1);
$B=substr($rm28,1,1);
$C=substr($rm28,2,1);
$D=substr($rm28,3,1);
$E=substr($rm28,4,1);
$F=substr($rm28,5,1);
$G=substr($rm28,6,1);
$H=substr($rm28,7,1);
$I=substr($rm28,8,1);
$J=substr($rm28,9,1);
$K=substr($rm28,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 29
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn29=sprintf('% 11s',$rn29);
$A=substr($rn29,0,1);
$B=substr($rn29,1,1);
$C=substr($rn29,2,1);
$D=substr($rn29,3,1);
$E=substr($rn29,4,1);
$F=substr($rn29,5,1);
$G=substr($rn29,6,1);
$H=substr($rn29,7,1);
$I=substr($rn29,8,1);
$J=substr($rn29,9,1);
$K=substr($rn29,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm29=sprintf('% 11s',$rm29);
$A=substr($rm29,0,1);
$B=substr($rm29,1,1);
$C=substr($rm29,2,1);
$D=substr($rm29,3,1);
$E=substr($rm29,4,1);
$F=substr($rm29,5,1);
$G=substr($rm29,6,1);
$H=substr($rm29,7,1);
$I=substr($rm29,8,1);
$J=substr($rm29,9,1);
$K=substr($rm29,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 30
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn30=sprintf('% 11s',$rn30);
$A=substr($rn30,0,1);
$B=substr($rn30,1,1);
$C=substr($rn30,2,1);
$D=substr($rn30,3,1);
$E=substr($rn30,4,1);
$F=substr($rn30,5,1);
$G=substr($rn30,6,1);
$H=substr($rn30,7,1);
$I=substr($rn30,8,1);
$J=substr($rn30,9,1);
$K=substr($rn30,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm30=sprintf('% 11s',$rm30);
$A=substr($rm30,0,1);
$B=substr($rm30,1,1);
$C=substr($rm30,2,1);
$D=substr($rm30,3,1);
$E=substr($rm30,4,1);
$F=substr($rm30,5,1);
$G=substr($rm30,6,1);
$H=substr($rm30,7,1);
$I=substr($rm30,8,1);
$J=substr($rm30,9,1);
$K=substr($rm30,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 31
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn31=sprintf('% 11s',$rn31);
$A=substr($rn31,0,1);
$B=substr($rn31,1,1);
$C=substr($rn31,2,1);
$D=substr($rn31,3,1);
$E=substr($rn31,4,1);
$F=substr($rn31,5,1);
$G=substr($rn31,6,1);
$H=substr($rn31,7,1);
$I=substr($rn31,8,1);
$J=substr($rn31,9,1);
$K=substr($rn31,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm31=sprintf('% 11s',$rm31);
$A=substr($rm31,0,1);
$B=substr($rm31,1,1);
$C=substr($rm31,2,1);
$D=substr($rm31,3,1);
$E=substr($rm31,4,1);
$F=substr($rm31,5,1);
$G=substr($rm31,6,1);
$H=substr($rm31,7,1);
$I=substr($rm31,8,1);
$J=substr($rm31,9,1);
$K=substr($rm31,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 32
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn32=sprintf('% 11s',$rn32);
$A=substr($rn32,0,1);
$B=substr($rn32,1,1);
$C=substr($rn32,2,1);
$D=substr($rn32,3,1);
$E=substr($rn32,4,1);
$F=substr($rn32,5,1);
$G=substr($rn32,6,1);
$H=substr($rn32,7,1);
$I=substr($rn32,8,1);
$J=substr($rn32,9,1);
$K=substr($rn32,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm32=sprintf('% 11s',$rm32);
$A=substr($rm32,0,1);
$B=substr($rm32,1,1);
$C=substr($rm32,2,1);
$D=substr($rm32,3,1);
$E=substr($rm32,4,1);
$F=substr($rm32,5,1);
$G=substr($rm32,6,1);
$H=substr($rm32,7,1);
$I=substr($rm32,8,1);
$J=substr($rm32,9,1);
$K=substr($rm32,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 33
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn33=sprintf('% 11s',$rn33);
$A=substr($rn33,0,1);
$B=substr($rn33,1,1);
$C=substr($rn33,2,1);
$D=substr($rn33,3,1);
$E=substr($rn33,4,1);
$F=substr($rn33,5,1);
$G=substr($rn33,6,1);
$H=substr($rn33,7,1);
$I=substr($rn33,8,1);
$J=substr($rn33,9,1);
$K=substr($rn33,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm33=sprintf('% 11s',$rm33);
$A=substr($rm33,0,1);
$B=substr($rm33,1,1);
$C=substr($rm33,2,1);
$D=substr($rm33,3,1);
$E=substr($rm33,4,1);
$F=substr($rm33,5,1);
$G=substr($rm33,6,1);
$H=substr($rm33,7,1);
$I=substr($rm33,8,1);
$J=substr($rm33,9,1);
$K=substr($rm33,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 34
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn34=sprintf('% 11s',$rn34);
$A=substr($rn34,0,1);
$B=substr($rn34,1,1);
$C=substr($rn34,2,1);
$D=substr($rn34,3,1);
$E=substr($rn34,4,1);
$F=substr($rn34,5,1);
$G=substr($rn34,6,1);
$H=substr($rn34,7,1);
$I=substr($rn34,8,1);
$J=substr($rn34,9,1);
$K=substr($rn34,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm34=sprintf('% 11s',$rm34);
$A=substr($rm34,0,1);
$B=substr($rm34,1,1);
$C=substr($rm34,2,1);
$D=substr($rm34,3,1);
$E=substr($rm34,4,1);
$F=substr($rm34,5,1);
$G=substr($rm34,6,1);
$H=substr($rm34,7,1);
$I=substr($rm34,8,1);
$J=substr($rm34,9,1);
$K=substr($rm34,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 35
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn35=sprintf('% 11s',$rn35);
$A=substr($rn35,0,1);
$B=substr($rn35,1,1);
$C=substr($rn35,2,1);
$D=substr($rn35,3,1);
$E=substr($rn35,4,1);
$F=substr($rn35,5,1);
$G=substr($rn35,6,1);
$H=substr($rn35,7,1);
$I=substr($rn35,8,1);
$J=substr($rn35,9,1);
$K=substr($rn35,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm35=sprintf('% 11s',$rm35);
$A=substr($rm35,0,1);
$B=substr($rm35,1,1);
$C=substr($rm35,2,1);
$D=substr($rm35,3,1);
$E=substr($rm35,4,1);
$F=substr($rm35,5,1);
$G=substr($rm35,6,1);
$H=substr($rm35,7,1);
$I=substr($rm35,8,1);
$J=substr($rm35,9,1);
$K=substr($rm35,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 36
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn36=sprintf('% 11s',$rn36);
$A=substr($rn36,0,1);
$B=substr($rn36,1,1);
$C=substr($rn36,2,1);
$D=substr($rn36,3,1);
$E=substr($rn36,4,1);
$F=substr($rn36,5,1);
$G=substr($rn36,6,1);
$H=substr($rn36,7,1);
$I=substr($rn36,8,1);
$J=substr($rn36,9,1);
$K=substr($rn36,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm36=sprintf('% 11s',$rm36);
$A=substr($rm36,0,1);
$B=substr($rm36,1,1);
$C=substr($rm36,2,1);
$D=substr($rm36,3,1);
$E=substr($rm36,4,1);
$F=substr($rm36,5,1);
$G=substr($rm36,6,1);
$H=substr($rm36,7,1);
$I=substr($rm36,8,1);
$J=substr($rm36,9,1);
$K=substr($rm36,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 37
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn37=sprintf('% 11s',$rn37);
$A=substr($rn37,0,1);
$B=substr($rn37,1,1);
$C=substr($rn37,2,1);
$D=substr($rn37,3,1);
$E=substr($rn37,4,1);
$F=substr($rn37,5,1);
$G=substr($rn37,6,1);
$H=substr($rn37,7,1);
$I=substr($rn37,8,1);
$J=substr($rn37,9,1);
$K=substr($rn37,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm37=sprintf('% 11s',$rm37);
$A=substr($rm37,0,1);
$B=substr($rm37,1,1);
$C=substr($rm37,2,1);
$D=substr($rm37,3,1);
$E=substr($rm37,4,1);
$F=substr($rm37,5,1);
$G=substr($rm37,6,1);
$H=substr($rm37,7,1);
$I=substr($rm37,8,1);
$J=substr($rm37,9,1);
$K=substr($rm37,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 38
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn38=sprintf('% 11s',$rn38);
$A=substr($rn38,0,1);
$B=substr($rn38,1,1);
$C=substr($rn38,2,1);
$D=substr($rn38,3,1);
$E=substr($rn38,4,1);
$F=substr($rn38,5,1);
$G=substr($rn38,6,1);
$H=substr($rn38,7,1);
$I=substr($rn38,8,1);
$J=substr($rn38,9,1);
$K=substr($rn38,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm38=sprintf('% 11s',$rm38);
$A=substr($rm38,0,1);
$B=substr($rm38,1,1);
$C=substr($rm38,2,1);
$D=substr($rm38,3,1);
$E=substr($rm38,4,1);
$F=substr($rm38,5,1);
$G=substr($rm38,6,1);
$H=substr($rm38,7,1);
$I=substr($rm38,8,1);
$J=substr($rm38,9,1);
$K=substr($rm38,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 39
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn39=sprintf('% 11s',$rn39);
$A=substr($rn39,0,1);
$B=substr($rn39,1,1);
$C=substr($rn39,2,1);
$D=substr($rn39,3,1);
$E=substr($rn39,4,1);
$F=substr($rn39,5,1);
$G=substr($rn39,6,1);
$H=substr($rn39,7,1);
$I=substr($rn39,8,1);
$J=substr($rn39,9,1);
$K=substr($rn39,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm39=sprintf('% 11s',$rm39);
$A=substr($rm39,0,1);
$B=substr($rm39,1,1);
$C=substr($rm39,2,1);
$D=substr($rm39,3,1);
$E=substr($rm39,4,1);
$F=substr($rm39,5,1);
$G=substr($rm39,6,1);
$H=substr($rm39,7,1);
$I=substr($rm39,8,1);
$J=substr($rm39,9,1);
$K=substr($rm39,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 40
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn40=sprintf('% 11s',$rn40);
$A=substr($rn40,0,1);
$B=substr($rn40,1,1);
$C=substr($rn40,2,1);
$D=substr($rn40,3,1);
$E=substr($rn40,4,1);
$F=substr($rn40,5,1);
$G=substr($rn40,6,1);
$H=substr($rn40,7,1);
$I=substr($rn40,8,1);
$J=substr($rn40,9,1);
$K=substr($rn40,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm40=sprintf('% 11s',$rm40);
$A=substr($rm40,0,1);
$B=substr($rm40,1,1);
$C=substr($rm40,2,1);
$D=substr($rm40,3,1);
$E=substr($rm40,4,1);
$F=substr($rm40,5,1);
$G=substr($rm40,6,1);
$H=substr($rm40,7,1);
$I=substr($rm40,8,1);
$J=substr($rm40,9,1);
$K=substr($rm40,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 41
$pdf->Cell(190,4," ","$rmc1",1,"L");
$rn41=sprintf('% 11s',$rn41);
$A=substr($rn41,0,1);
$B=substr($rn41,1,1);
$C=substr($rn41,2,1);
$D=substr($rn41,3,1);
$E=substr($rn41,4,1);
$F=substr($rn41,5,1);
$G=substr($rn41,6,1);
$H=substr($rn41,7,1);
$I=substr($rn41,8,1);
$J=substr($rn41,9,1);
$K=substr($rn41,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm41=sprintf('% 11s',$rm41);
$A=substr($rm41,0,1);
$B=substr($rm41,1,1);
$C=substr($rm41,2,1);
$D=substr($rm41,3,1);
$E=substr($rm41,4,1);
$F=substr($rm41,5,1);
$G=substr($rm41,6,1);
$H=substr($rm41,7,1);
$I=substr($rm41,8,1);
$J=substr($rm41,9,1);
$K=substr($rm41,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 42
$pdf->Cell(190,6," ","$rmc1",1,"L");
$rn42=sprintf('% 11s',$rn42);
$A=substr($rn42,0,1);
$B=substr($rn42,1,1);
$C=substr($rn42,2,1);
$D=substr($rn42,3,1);
$E=substr($rn42,4,1);
$F=substr($rn42,5,1);
$G=substr($rn42,6,1);
$H=substr($rn42,7,1);
$I=substr($rn42,8,1);
$J=substr($rn42,9,1);
$K=substr($rn42,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm42=sprintf('% 11s',$rm42);
$A=substr($rm42,0,1);
$B=substr($rm42,1,1);
$C=substr($rm42,2,1);
$D=substr($rm42,3,1);
$E=substr($rm42,4,1);
$F=substr($rm42,5,1);
$G=substr($rm42,6,1);
$H=substr($rm42,7,1);
$I=substr($rm42,8,1);
$J=substr($rm42,9,1);
$K=substr($rm42,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 43
$pdf->Cell(190,5," ","$rmc1",1,"L");
$rn43=sprintf('% 11s',$rn43);
$A=substr($rn43,0,1);
$B=substr($rn43,1,1);
$C=substr($rn43,2,1);
$D=substr($rn43,3,1);
$E=substr($rn43,4,1);
$F=substr($rn43,5,1);
$G=substr($rn43,6,1);
$H=substr($rn43,7,1);
$I=substr($rn43,8,1);
$J=substr($rn43,9,1);
$K=substr($rn43,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm43=sprintf('% 11s',$rm43);
$A=substr($rm43,0,1);
$B=substr($rm43,1,1);
$C=substr($rm43,2,1);
$D=substr($rm43,3,1);
$E=substr($rm43,4,1);
$F=substr($rm43,5,1);
$G=substr($rm43,6,1);
$H=substr($rm43,7,1);
$I=substr($rm43,8,1);
$J=substr($rm43,9,1);
$K=substr($rm43,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 44
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn44=sprintf('% 11s',$rn44);
$A=substr($rn44,0,1);
$B=substr($rn44,1,1);
$C=substr($rn44,2,1);
$D=substr($rn44,3,1);
$E=substr($rn44,4,1);
$F=substr($rn44,5,1);
$G=substr($rn44,6,1);
$H=substr($rn44,7,1);
$I=substr($rn44,8,1);
$J=substr($rn44,9,1);
$K=substr($rn44,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm44=sprintf('% 11s',$rm44);
$A=substr($rm44,0,1);
$B=substr($rm44,1,1);
$C=substr($rm44,2,1);
$D=substr($rm44,3,1);
$E=substr($rm44,4,1);
$F=substr($rm44,5,1);
$G=substr($rm44,6,1);
$H=substr($rm44,7,1);
$I=substr($rm44,8,1);
$J=substr($rm44,9,1);
$K=substr($rm44,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");

//riadok 45
$pdf->Cell(190,3," ","$rmc1",1,"L");
$rn45=sprintf('% 11s',$rn45);
$A=substr($rn45,0,1);
$B=substr($rn45,1,1);
$C=substr($rn45,2,1);
$D=substr($rn45,3,1);
$E=substr($rn45,4,1);
$F=substr($rn45,5,1);
$G=substr($rn45,6,1);
$H=substr($rn45,7,1);
$I=substr($rn45,8,1);
$J=substr($rn45,9,1);
$K=substr($rn45,10,1);
$pdf->Cell(75,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm45=sprintf('% 11s',$rm45);
$A=substr($rm45,0,1);
$B=substr($rm45,1,1);
$C=substr($rm45,2,1);
$D=substr($rm45,3,1);
$E=substr($rm45,4,1);
$F=substr($rm45,5,1);
$G=substr($rm45,6,1);
$H=substr($rm45,7,1);
$I=substr($rm45,8,1);
$J=substr($rm45,9,1);
$K=substr($rm45,10,1);
$pdf->Cell(4,6," ","$rmc1",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$K","$rmc",1,"C");


//strana 4
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-4.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");



//strana 5
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-5.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-5.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");



//strana 7
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-7.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-7.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");


//strana 8
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-8.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-8.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");


//strana 9
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-9.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-9.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");


}
$i = $i + 1;
  }
//koniec while suvaha


                    }
//koniec tlacit suvahu

//tlacit VZaS
if( $tlacvzs == 1 ) { 

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid." WHERE prx = 1 ";

if( $tis > 0 ) { 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid." WHERE prx = 1 "; 

}

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//V pod 2014 POUZIVAME LEN STLPCE r01-r61 a rm01-rm61
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
$r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $r38="";

$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; 
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_pod2014 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
if($sqlpv) { $polpv = mysql_num_rows($sqlpv); }

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }

}
$ipv = $ipv + 1;
  }

//strana 10
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-10.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-10.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");


//strana 11
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-11.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-11.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");


//strana 12
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',12);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-12.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/UZPODv14 v1 9-12.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic
$pdf->Cell(190,1," ","$rmc1",1,"L");
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
$pdf->Cell(41,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
//ico
$t01=substr($fir_fico,0,1);
$t02=substr($fir_fico,1,1);
$t03=substr($fir_fico,2,1);
$t04=substr($fir_fico,3,1);
$t05=substr($fir_fico,4,1);
$t06=substr($fir_fico,5,1);
$t07=substr($fir_fico,6,1);
$t08=substr($fir_fico,7,1);
$pdf->Cell(11,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");




}
$i = $i + 1;
  }
//koniec while vykazziskov


                    }
//koniec tlacit VZaS


$pdf->Output("../tmp/uzavierka.$kli_uzid.pdf");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvaha'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykzis'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvyk1000ziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/uzavierka.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzavierka POD PDF</title>
</HEAD>
<BODY class="white">
<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>
