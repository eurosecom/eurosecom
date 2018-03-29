<HTML>
<?php
$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }

$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//userhash
$userhash = $_REQUEST['userhash'];

require_once('../androidfanti/MCrypt.php');
$mcrypt = new MCrypt();
//#Encrypt
//$encrypted = $mcrypt->encrypt("Text to encrypt");
$encrypted=$userhash;
#Decrypt
$userxplus = $mcrypt->decrypt($encrypted);

//user
$userx=$userxplus;
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];
$cislo_dok=1*$poleu[12];

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";

$anduct=1*$_REQUEST['anduct'];
if( $anduct == 1 )
  {
//nastav databazu
$kli_vrok=1*$_REQUEST['rokx'];
$kli_vxcf=1*$_REQUEST['firx'];
$dbsed="../".$adrsxxx."/nastavdbase.php";
$sDat = include("$dbsed");
mysql_select_db($databaza);
$kli_vxcfez=DB_FIR;
$databazaez=DB_DATABASETOP.".";
  }

if( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }


$druhid=0;
$cuid=0;
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=10;
    $cuid=1*$riaddok->cuid;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."F".$kli_vxcfez."_ezak WHERE ez_id = $usidxxx AND ez_heslo = '$pswdxxx' ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cuid=1*$riaddok->cuid;
    $druhid=20;
    }
$sqldok = mysql_query("SELECT * FROM ".$databazaez."klienti WHERE id_klienta = $cuid AND all_prav > 20000 ORDER BY id_klienta DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=99;
    }
if( $druhid < 20 ) { exit; }
$kli_uzid=$cuid;
if( $kli_uzid == 0 ) { exit; }


$_REQUEST['h_dap']="01.01.".$kli_vrok;
$_REQUEST['h_dak']="31.12.".$kli_vrok;
$_REQUEST['h_stp']=1;
$_REQUEST['h_stk']=999;
$_REQUEST['h_aky']=1;
$kli_vume=$_REQUEST['kli_vume'];

  }

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }

do
{

if( $zandroidu == 0 )
  {
require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
  }

$celeeura = 1*$_REQUEST['celeeura'];
$h_zos = $_REQUEST['h_zos'];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = 1*$_REQUEST['h_drp'];
$suborxml = 1*$_REQUEST['suborxml'];

if( $kli_vrok < 2012 AND $zandroidu == 0 )
{
?>
<script type="text/javascript">
  var okno = window.open("../ucto/vprivyd2011.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&celeeura=<?php echo $celeeura; ?>
&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&suborxml=<?php echo $suborxml; ?>","_self");
</script>
<?php
exit;
}


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//uprava generovania vykazu prijmov a vydavkov
if( $kli_vrok == 2013 AND $kli_vduj == 9 )
   {
$sql = "SELECT * FROM F$kli_vxcf"."_uctgenvpv2013 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {
$sql = "UPDATE F$kli_vxcf"."_uctosnova SET crv=5 WHERE crv = 6 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctosnova SET crv=10 WHERE crv = 9 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_uctosnova SET crv=9 WHERE uce = 26 AND crv = 10 ";
$vysledek = mysql_query("$sql");



$sqlt = <<<prcdatum
(
   uxx         VARCHAR(10)
);
prcdatum;

$vsql = "CREATE TABLE F".$kli_vxcf."_uctgenvpv2013 ".$sqlt;
$vytvor = mysql_query("$vsql");
 }
   }
//koniec uprava generovania vykazu prijmov a vydavkov

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/privyd_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/privyd_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

//350=sirka obdlznika 0 znamena do konca , 15=vyska obdlznika , $riadok-text , "1"=border ano 0 nie
//parameter druhy zlava 1=kurzor prejde na zaciatok riadku,0 kurzor pokracuje na riadku,2 kurzor ide nad riadok
//L=zarovnanie left alebo C=center R=right
//$pdf->Cell(350,15,"$riadok","1",1,"L");
//$rest = substr("abcdef", 0, 4); // vrátí "abcd"

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = <<<prcvprivyds
(
   prx          INT,
   uce          INT,
   ucm          INT,
   ucd          INT,
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,2),
   pri          DECIMAL(10,2),
   vyd          DECIMAL(10,2),
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r98          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   ico          INT
);
prcvprivyds;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvprivyds'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$psys=1;
while ($psys <= 6 ) 
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

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvprivyds$kli_uzid"." SELECT".
" 0,ucm,ucm,0,0,0,0,0,F$kli_vxcf"."_$uctovanie.hod,0,0,0,0,0,0,0,0,0,0,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvprivyds$kli_uzid"." SELECT".
" 0,ucd,0,ucd,0,0,0,F$kli_vxcf"."_$uctovanie.hod,0,0,0,0,0,0,0,0,0,0,0,0,0,0,$fir_fico".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

}
$psys=$psys+1;
  }

//nastav crv,prv podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET rdk=F$kli_vxcf"."_uctosnova.crv, prv=F$kli_vxcf"."_uctosnova.prm1 ".
" WHERE F$kli_vxcf"."_prcvprivyds$kli_uzid.uce = F$kli_vxcf"."_uctosnova.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//rozdel do riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r01=pri-vyd WHERE rdk = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r02=pri-vyd WHERE rdk = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r03=pri-vyd WHERE rdk = 3 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r04=r01+r02+r03, r98=r01+r02+r03+r04 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r05=vyd-pri WHERE rdk = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r06=vyd-pri WHERE rdk = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r07=vyd-pri WHERE rdk = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r08=vyd-pri WHERE rdk = 8 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r09=vyd-pri WHERE rdk = 9 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r10=vyd-pri WHERE rdk = 10 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r11=r05+r06+r07+r08+r09+r10 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds$kli_uzid SET r12=r04-r11 WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");



//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvprivyds$kli_uzid "." SELECT".
" 1,uce,ucm,ucd,rdk,prv,hod,pri,vyd,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r98),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),$fir_fico".
" FROM F$kli_vxcf"."_prcvprivyds$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zaokruhli
if( $celeeura == 1 )
  {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds1000x'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$sqlt = <<<prcvprivyds
(
   prx          INT,
   uce          INT,
   ucm          INT,
   ucd          INT,
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,0),
   pri          DECIMAL(10,0),
   vyd          DECIMAL(10,0),
   r01          DECIMAL(10,0),
   r02          DECIMAL(10,0),
   r03          DECIMAL(10,0),
   r04          DECIMAL(10,0),
   r98          DECIMAL(10,0),
   r05          DECIMAL(10,0),
   r06          DECIMAL(10,0),
   r07          DECIMAL(10,0),
   r08          DECIMAL(10,0),
   r09          DECIMAL(10,0),
   r10          DECIMAL(10,0),
   r11          DECIMAL(10,0),
   r12          DECIMAL(10,0),
   ico          INT
);
prcvprivyds;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvprivyds1000x'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvprivyds1000x$kli_uzid "." SELECT".
" 1,uce,ucm,ucd,rdk,prv,hod,pri,vyd,SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r98),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),$fir_fico".
" FROM F$kli_vxcf"."_prcvprivyds$kli_uzid".
" WHERE prx = 1 ".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//znovu prepocitaj
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds1000x$kli_uzid SET r11=r05+r06+r07+r08+r09+r10  WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvprivyds1000x$kli_uzid SET r12=r04-r11  WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//premenuj
$sqtoz = "DROP TABLE F$kli_vxcf"."_prcvprivyds$kli_uzid ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcvprivyds$kli_uzid SELECT * FROM F$kli_vxcf"."_prcvprivyds1000x$kli_uzid ";
$oznac = mysql_query("$sqtoz");

  }
//koniec zaokruhli




//obdobie vypocitaj
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
if( $kli_mdph < 10 ) $kli_mdph='0'.$kli_mdph;

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

$sqlkk = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sqlkk,0))
  {
  $riadok=mysql_fetch_object($sqlkk);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datk_sk;
//exit;

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

$pole = explode(".", $datk_sk);
$denk_sk=$pole[0];
$mesk_sk=$pole[1];
$rokk_sk=$pole[2]-2000;
if( $rokk_sk < 10 ) $rokk_sk='0'.$rokk_sk;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvprivyds".$kli_uzid." WHERE prx = 1 "."";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i < $pol )
  {

//strana1
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_ju2013/privyd_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2013/privyd_str1.jpg',0,0,210,297);
}
//tuto nastavenie rozmerov strany 1 a od tadeto presne nastavenie

$rmc=0;

$pdf->SetY(10);
$pdf->SetFont('arial','',12);

$pdf->Cell(190,21,"     ","$rmc",1,"L");

//dic
$pdf->Cell(0,28," ","$rmc",1,"C");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(2,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",0,"C");

$pdf->Cell(0,5," ","$rmc",1,"C");


//ico
$pdf->Cell(0,8," ","$rmc",1,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);


$pdf->Cell(2,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");

//sknace
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);

$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$sn2c=substr($sknacec,1,1);

$pdf->Cell(7,5," ","$rmc",0,"L");
$pdf->Cell(3,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$sn1a","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$sn2a","$rmc",0,"C");
$pdf->Cell(4,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$sn1b","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$sn1c","$rmc",0,"C");$pdf->Cell(4,5,"$sn2c","$rmc",1,"C");



//nazov
$pdf->Cell(10,10," ","$rmc",1,"C");

$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);

$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);

$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);

$A2=substr($fir_fnaz,30,1);$B2=substr($fir_fnaz,31,1);$C2=substr($fir_fnaz,32,1);$D2=substr($fir_fnaz,33,1);$E2=substr($fir_fnaz,34,1);

$A3=substr($fir_fnaz,35,1);$B3=substr($fir_fnaz,36,1);


$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$A2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$A3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");



$pdf->Cell(1,6," ","$rmc",1,"C");

//ulica cislo
$pdf->Cell(190,22,"     ","$rmc",1,"L");

$A=substr($fir_fuli,0,1);$B=substr($fir_fuli,1,1);$C=substr($fir_fuli,2,1);$D=substr($fir_fuli,3,1);$E=substr($fir_fuli,4,1);
$F=substr($fir_fuli,5,1);$G=substr($fir_fuli,6,1);$H=substr($fir_fuli,7,1);$I=substr($fir_fuli,8,1);$J=substr($fir_fuli,9,1);

$K=substr($fir_fuli,10,1);$L=substr($fir_fuli,11,1);$M=substr($fir_fuli,12,1);$N=substr($fir_fuli,13,1);$O=substr($fir_fuli,14,1);
$P=substr($fir_fuli,15,1);$R=substr($fir_fuli,16,1);$S=substr($fir_fuli,17,1);$T=substr($fir_fuli,18,1);$U=substr($fir_fuli,19,1);

$V=substr($fir_fuli,20,1);$W=substr($fir_fuli,21,1);$X=substr($fir_fuli,22,1);$Y=substr($fir_fuli,23,1);$Z=substr($fir_fuli,24,1);
$A1=substr($fir_fuli,25,1);$B1=substr($fir_fuli,26,1);$C1=substr($fir_fuli,27,1);

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");

$A=substr($fir_fcdm,0,1);$B=substr($fir_fcdm,1,1);$C=substr($fir_fcdm,2,1);$D=substr($fir_fcdm,3,1);$E=substr($fir_fcdm,4,1);
$F=substr($fir_fcdm,5,1);$G=substr($fir_fcdm,6,1);$H=substr($fir_fcdm,7,1);

$pdf->Cell(6,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",1,"C");


//psc,obec
$pdf->Cell(190,7,"     ","$rmc",1,"L");

$fir_fpsc=str_replace(" ","",$fir_fpsc);
$A=substr($fir_fpsc,0,1);$B=substr($fir_fpsc,1,1);$C=substr($fir_fpsc,2,1);$D=substr($fir_fpsc,3,1);$E=substr($fir_fpsc,4,1);

$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");


$A=substr($fir_fmes,0,1);$B=substr($fir_fmes,1,1);$C=substr($fir_fmes,2,1);$D=substr($fir_fmes,3,1);$E=substr($fir_fmes,4,1);
$F=substr($fir_fmes,5,1);$G=substr($fir_fmes,6,1);$H=substr($fir_fmes,7,1);$I=substr($fir_fmes,8,1);$J=substr($fir_fmes,9,1);

$K=substr($fir_fmes,10,1);$L=substr($fir_fmes,11,1);$M=substr($fir_fmes,12,1);$N=substr($fir_fmes,13,1);$O=substr($fir_fmes,14,1);
$P=substr($fir_fmes,15,1);$R=substr($fir_fmes,16,1);$S=substr($fir_fmes,17,1);$T=substr($fir_fmes,18,1);$U=substr($fir_fmes,19,1);

$V=substr($fir_fmes,20,1);$W=substr($fir_fmes,21,1);$X=substr($fir_fmes,22,1);$Y=substr($fir_fmes,23,1);$Z=substr($fir_fmes,24,1);
$A1=substr($fir_fmes,25,1);$B1=substr($fir_fmes,26,1);$C1=substr($fir_fmes,27,1);$D1=substr($fir_fmes,28,1);$E1=substr($fir_fmes,29,1);
$A2=substr($fir_fmes,30,1);$B2=substr($fir_fmes,31,1);$C2=substr($fir_fmes,32,1);

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$C1","$rmc",0,"C");

$pdf->Cell(5,6,"$A2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C2","$rmc",1,"C");


//telefon fax
$pdf->Cell(190,7,"     ","$rmc",1,"L");

$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if( $tel_pred == 0 ) $tel_pred="";
if( $tel_za == 0 ) $tel_za="";
$text=$tel_pred.$tel_za;

$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);

$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
if( $fax_pred == 0 ) $fax_pred="";
if( $fax_za == 0 ) $fax_za="";
$text=$fax_pred.$fax_za;

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);

$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($fax_za,0,1);$B=substr($fax_za,1,1);$C=substr($fax_za,2,1);
$D=substr($fax_za,3,1);$E=substr($fax_za,4,1);$F=substr($fax_za,5,1);
$G=substr($fax_za,6,1);$H=substr($fax_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pdf->Cell(1,6," ","$rmc",1,"C");

//email
$pdf->Cell(190,6,"     ","$rmc",1,"L");
$A=substr($fir_fem1,0,1);$B=substr($fir_fem1,1,1);$C=substr($fir_fem1,2,1);$D=substr($fir_fem1,3,1);$E=substr($fir_fem1,4,1);
$F=substr($fir_fem1,5,1);$G=substr($fir_fem1,6,1);$H=substr($fir_fem1,7,1);$I=substr($fir_fem1,8,1);$J=substr($fir_fem1,9,1);

$K=substr($fir_fem1,10,1);$L=substr($fir_fem1,11,1);$M=substr($fir_fem1,12,1);$N=substr($fir_fem1,13,1);$O=substr($fir_fem1,14,1);
$P=substr($fir_fem1,15,1);$R=substr($fir_fem1,16,1);$S=substr($fir_fem1,17,1);$T=substr($fir_fem1,18,1);$U=substr($fir_fem1,19,1);

$V=substr($fir_fem1,20,1);$W=substr($fir_fem1,21,1);$X=substr($fir_fem1,22,1);$Y=substr($fir_fem1,23,1);$Z=substr($fir_fem1,24,1);
$A1=substr($fir_fem1,25,1);$B1=substr($fir_fem1,26,1);$C1=substr($fir_fem1,27,1);$D1=substr($fir_fem1,28,1);$E1=substr($fir_fem1,29,1);

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",1,"C");

//miesto podnikania berie z ufirdalsie Miesto podnikania 
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$pruli = $fir_riadok->pruli;
$prcdm = $fir_riadok->prcdm;
$prpsc = $fir_riadok->prpsc;
$prmes = $fir_riadok->prmes;
$prtel = $fir_riadok->prtel;
$prfax = $fir_riadok->prfax;


//miesto podnikania ulica cislo
$pdf->Cell(190,13,"     ","$rmc",1,"L");

$A=substr($pruli,0,1);$B=substr($pruli,1,1);$C=substr($pruli,2,1);$D=substr($pruli,3,1);$E=substr($pruli,4,1);
$F=substr($pruli,5,1);$G=substr($pruli,6,1);$H=substr($pruli,7,1);$I=substr($pruli,8,1);$J=substr($pruli,9,1);

$K=substr($pruli,10,1);$L=substr($pruli,11,1);$M=substr($pruli,12,1);$N=substr($pruli,13,1);$O=substr($pruli,14,1);
$P=substr($pruli,15,1);$R=substr($pruli,16,1);$S=substr($pruli,17,1);$T=substr($pruli,18,1);$U=substr($pruli,19,1);

$V=substr($pruli,20,1);$W=substr($pruli,21,1);$X=substr($pruli,22,1);$Y=substr($pruli,23,1);$Z=substr($pruli,24,1);
$A1=substr($pruli,25,1);$B1=substr($pruli,26,1);$C1=substr($pruli,27,1);

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");

$A=substr($prcdm,0,1);$B=substr($prcdm,1,1);$C=substr($prcdm,2,1);$D=substr($prcdm,3,1);$E=substr($prcdm,4,1);
$F=substr($prcdm,5,1);$G=substr($prcdm,6,1);$H=substr($prcdm,7,1);

$pdf->Cell(6,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",1,"C");


//miesto podnikania psc,obec
$pdf->Cell(190,7,"     ","$rmc",1,"L");

$prpsc=str_replace(" ","",$prpsc);
$A=substr($prpsc,0,1);$B=substr($prpsc,1,1);$C=substr($prpsc,2,1);$D=substr($prpsc,3,1);$E=substr($prpsc,4,1);

$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");


$A=substr($prmes,0,1);$B=substr($prmes,1,1);$C=substr($prmes,2,1);$D=substr($prmes,3,1);$E=substr($prmes,4,1);
$F=substr($prmes,5,1);$G=substr($prmes,6,1);$H=substr($prmes,7,1);$I=substr($prmes,8,1);$J=substr($prmes,9,1);

$K=substr($prmes,10,1);$L=substr($prmes,11,1);$M=substr($prmes,12,1);$N=substr($prmes,13,1);$O=substr($prmes,14,1);
$P=substr($prmes,15,1);$R=substr($prmes,16,1);$S=substr($prmes,17,1);$T=substr($prmes,18,1);$U=substr($prmes,19,1);

$V=substr($prmes,20,1);$W=substr($prmes,21,1);$X=substr($prmes,22,1);$Y=substr($prmes,23,1);$Z=substr($prmes,24,1);
$A1=substr($prmes,25,1);$B1=substr($prmes,26,1);$C1=substr($prmes,27,1);$D1=substr($prmes,28,1);$E1=substr($prmes,29,1);

$A2=substr($prmes,30,1);

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$C1","$rmc",0,"C");
$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",1,"C");

//miesto podnikania telefon fax
$pdf->Cell(190,7,"     ","$rmc",1,"L");

$pole = explode("/", $prtel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if( $tel_pred == 0 ) $tel_pred="";
if( $tel_za == 0 ) $tel_za="";
$text=$tel_pred.$tel_za;

$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);

$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pole = explode("/", $prfax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
if( $fax_pred == 0 ) $fax_pred="";
if( $fax_za == 0 ) $fax_za="";
$text=$fax_pred.$fax_za;

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);

$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($fax_za,0,1);$B=substr($fax_za,1,1);$C=substr($fax_za,2,1);
$D=substr($fax_za,3,1);$E=substr($fax_za,4,1);$F=substr($fax_za,5,1);
$G=substr($fax_za,6,1);$H=substr($fax_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pdf->Cell(1,6," ","$rmc",1,"C");


//zostavena, schvalena
$pdf->SetY(220);
$pdf->SetX(9);

$da1=substr($h_zos,0,1);
$da2=substr($h_zos,1,1);
$da3=substr($h_zos,3,1);
$da4=substr($h_zos,4,1);
$da5=substr($h_zos,6,1);
$da6=substr($h_zos,7,1);
$da7=substr($h_zos,8,1);
$da8=substr($h_zos,9,1);

$pdf->Cell(3,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da2","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da4","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da8","$rmc",1,"C");


//uzavierka k z ufirdalsie
if( $kli_vrok >= 2013 )
          {

$sqldtu = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sqldtu,0))
  {
  $riadokdtu=mysql_fetch_object($sqldtu);
  if( $riadokdtu->datk != '0000-00-00' )
    {
  $datk_sk=SkDatum($riadokdtu->datk);
  $pole = explode(".", $datk_sk);
  $denk_sk=$pole[0];
  $mesk_sk=$pole[1];
  $rokk_sk=$pole[2]-2000;
  if( $rokk_sk < 10 ) $rokk_sk="0".$rokk_sk;
    }
  }
          }


//obdobie k 
$Adenk=substr($denk_sk,0,1);
$Bdenk=substr($denk_sk,1,1);
$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,0,1);
$Brokk=substr($rokk_sk,1,1);

$pdf->SetY(25);
$pdf->SetX(72);
$pdf->Cell(5,6,"$Adenk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bdenk","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesk","$rmc",0,"C");
$pdf->Cell(14,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokk","$rmc",1,"C");



if( $kli_vrok >= 2013 )
{

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sqldtu = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sqldtu,0))
  {
  $riadokdtu=mysql_fetch_object($sqldtu);

if ( $riadokdtu->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadokdtu->datbod);
  $datbdosk=SkDatum($riadokdtu->datbdo);
  $datmodsk=SkDatum($riadokdtu->datmod);
  $datmdosk=SkDatum($riadokdtu->datmdo);
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

$obdr1=substr($obdr1,2,2);
$obdr2=substr($obdr2,2,2);
$obmr1=substr($obmr1,2,2);
$obmr2=substr($obmr2,2,2);
}
//koniec rok 2013


//uctovne obdobie od do 
$rokp_sk=$obdr1;
$mesp_sk=$obdm1;
$rokk_sk=$obdr2;
$mesk_sk=$obdm2;;

$Amesp=substr($mesp_sk,0,1);
$Bmesp=substr($mesp_sk,1,1);
$Arokp=substr($rokp_sk,0,1);
$Brokp=substr($rokp_sk,1,1);

$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,0,1);
$Brokk=substr($rokk_sk,1,1);

$pdf->SetY(63);
$pdf->SetX(166);
$pdf->Cell(4,6,"$Amesp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesp","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Arokp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokp","$rmc",0,"C");

$pdf->SetY(72);
$pdf->SetX(166);
$pdf->Cell(4,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesk","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Arokk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokk","$rmc",1,"C");


//krizik riadna,mimoriadna,priebezna
$riadna="x"; $mimoriadna=" "; $priebezna=" ";
if( $h_drp == 2 ) { $riadna=" "; $mimoriadna="x"; $priebezna=" "; }
if( $h_drp == 3 ) { $riadna=" "; $mimoriadna=" "; $priebezna="x"; }

$pdf->SetY(59);
$pdf->SetX(107);
$pdf->Cell(3,3,"$riadna","$rmc",1,"C");
$pdf->SetY(66);
$pdf->SetX(107);
$pdf->Cell(3,3,"$mimoriadna","$rmc",1,"C");
$pdf->SetY(74);
$pdf->SetX(107);
$pdf->Cell(3,3,"$priebezna","$rmc",1,"C");

//odkaz na miesto podnikania
$pdf->SetY(162);
$pdf->SetX(10);

$odkaz="../cis/ufirdalsie.php?copern=102";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=102";
                               }

$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);
$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);
$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);
$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);
$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);
$pdf->Cell(160,5,"                                                                                                           ","0",1,"L",0,$odkaz);


//odkaz na uzavierka k
$pdf->SetY(23);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(65);$pdf->Cell(80,5,"                                                                    ","0",1,"L",0,$odkaz);
$pdf->SetX(65);$pdf->Cell(80,5,"                                                                    ","0",1,"L",0,$odkaz);


//odkaz na uzavierka obdobie
$pdf->SetY(51);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);
$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);
$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);
$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);
$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);
$pdf->SetX(148);$pdf->Cell(52,5,"                                             ","0",1,"L",0,$odkaz);

//koniec strana1

//strana2
if ( $j == 0 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_ju2013/privyd_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_ju2013/privyd_str2.jpg',0,1,210,296);
}
//tuto nastavenie rozmerov strany 2 a od tadeto presne nastavenie

$pdf->SetFont('arial','',12);
$pdf->Cell(190,5,"     ","$rmc",1,"L");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(42,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");


$pdf->Cell(6,6," ","$rmc",0,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(6,6," ","$rmc",1,"C");

}

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12="";


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


//od tadeto presne nastavenie

$pdf->Cell(190,28,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,23,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,5,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");

$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


$pdf->Cell(190,4,"     ","$rmc",1,"L");

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


$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


$pdf->Cell(190,4,"     ","$rmc",1,"L");

$strata=0;
if( $r12 < 0 ) { $strata=1; $r12=str_replace("-"," ",$r12); }
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
if( $strata == 1 ) $A="-";

$pdf->Cell(103,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(7,6,"","$rmc",1,"R");


}
$i = $i + 1;
$j = $j + 1;

if( $j == 27 ) $j=0;

  }
//koniec hlavicky

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$suborxml = 1*$_REQUEST['suborxml'];
if( $suborxml == 1 )                     { ?>
<script type="text/javascript">
window.open('../ucto/vprivyd_xml2013.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>', '_self' );
</script>
<?php 
exit;
                                         } 


$pdf->Output("$outfilex");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvprivyds1000x'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Vykaz PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >
<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 0 ) { echo "EuroSecom "; } ?> 
<?php if( $zandroidu == 1 ) { echo "Zostava PDF prebraná, tlaèidlo Spä - do úètovných zostáv"; } ?> 
</td>
<td align="right"> </td>
</tr>
</table>
<br />

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
