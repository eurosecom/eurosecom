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

$zkosika = 0;
$analyzy = 0;
$_REQUEST['h_dobd']=12;
$kli_vume=$_REQUEST['kli_vume'];

$akoposlatandroid=1*$_REQUEST['akoposlatandroid'];

  }

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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
if( $zandroidu == 1 AND $akoposlatandroid == 1 ) { $posem=1; }

$odsuhlas=0;
//h_pen 0=upomienka,1=penalizacna,2=odsuhlasenie
if( $h_pen == 2 ) { $h_pen=0; $odsuhlas=1; }

//hspl=0vsetky,1zaplatene,2nezaplatene
$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

//echo "h_spl".$h_spl;
//exit;

//echo $h_spl." dsp".$h_dsp;
//exit;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

$dnes = $h_dsp;
if( $dnes == '00.00.0000' ) $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
if( $dnes == '' ) $dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqlt = <<<prsaldo
(
   cupo        INT,
   dau         DATE,
   druh        INT,
   pox1        INT,
   pox2        INT,
   pox         INT,
   drupoh      INT,
   uce         VARCHAR(10),
   puc         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         INT(10),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         VARCHAR(10),
   hdp         DECIMAL(10,2),
   hdu         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   uhr         DECIMAL(10,2),
   zos         DECIMAL(10,2)
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctupomienky'.$sqlt;
$vytvor = mysql_query("$vsql");

//pen,ppe,hpe
$sql = "ALTER TABLE F$kli_vxcf"."_uctupomienky ADD hpe DECIMAL(10,2) DEFAULT 0 AFTER zos";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctupomienky ADD ppe DECIMAL(10,2) DEFAULT 0 AFTER zos";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctupomienky ADD pen DECIMAL(2,0) DEFAULT 0 AFTER zos";
$vysledek = mysql_query("$sql");

$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctupomienky'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctupomienky$kli_uzid SELECT * FROM F".$kli_vxcf."_uctupomienky WHERE cupo = 0";
$vysledek = mysql_query("$sql");

//prac.subor uhrad
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctupouhrad'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<prsaldo
(
   pox          INT,
   cupo         INT,
   das          DATE,
   dau          DATE,
   dok          INT(8),
   uce          VARCHAR(10),
   ico          INT(10),
   fak          DECIMAL(10,0),
   hod          DECIMAL(10,2),
   uhr          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   hpe          DECIMAL(10,2),
   hodu         DECIMAL(10,2),
   penu         DECIMAL(2,0),
   ppeu         DECIMAL(10,2),
   hpeu         DECIMAL(10,2),
   puc          DECIMAL(10,0),
   pucu         DECIMAL(10,0)
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctupouhrad'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");



?>
<?php

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


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
$tabl="prsaldoico".$kli_uzid;
$uctpol="uctupomienky";

$dnes_sql=SqlDatum($dnes);
$dness = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dness_sql=SqlDatum($dness);

//penalizacia jednej faktury
if ( $copern == 10 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupomienky".
" WHERE ico = $cislo_ico AND fak = $cislo_fak AND druh = 10 AND dau = '$dness_sql' ";
$dsql = mysql_query("$dsqlt");

$newdok=1;
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupomienky ORDER by cupo DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $newdok=$riadmax->cupo+1;
  }


if( $h_pen == 100 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky$kli_uzid".
" SELECT '$newdok','$dnes_sql','$copern',pox1,pox2,pox,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,'$h_pen','$h_ppe',0 ".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE ico = $cislo_ico AND fak = $cislo_fak AND uce = $h_uce AND puc > 0 AND pox = 1 ";
$dsql = mysql_query("$dsqlt");
}

if( $h_pen > 0 OR $h_pen == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky$kli_uzid".
" SELECT '$newdok','$dnes_sql','$copern',0,0,1,drupoh,uce,puc,ume,dat,das,F$kli_vxcf"."_prsaldoicofakp$kli_uzid.dau,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,'$h_pen','$h_ppe',0 ".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE ico = $cislo_ico AND fak = $cislo_fak AND uce = $h_uce ";
$dsql = mysql_query("$dsqlt");

$dnesok = $h_dsp;
if( $dnes == '00.00.0000' ) $dnesok = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$dnesok_sql=SqlDatum($dnesok);

$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ".
" WHERE uhr = 0 AND cupo = $newdok ";
$oznac = mysql_query("$sqtoz");

//penalizacia uhradenych
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 1,'$newdok','0000-00-00',dau,dok,uce,ico,fak,0,0,0,0,uhr,'$h_pen','$h_ppe',0,0,0 ".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE ico = $cislo_ico AND uce = $h_uce AND uhr != 0 AND dau != '0000-00-00' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 1,'$newdok','0000-00-00',dat,dok,ucd,ico,fak,0,0,0,0,hod,'$h_pen','$h_ppe',0,0,0 ".
" FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE ico = $cislo_ico AND ucd = $h_uce AND hod != 0 ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid,F$kli_vxcf"."_uctupomienky$kli_uzid ".
" SET F$kli_vxcf"."_uctupouhrad$kli_uzid.das=F$kli_vxcf"."_uctupomienky$kli_uzid.das, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.pox=2, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.hod=F$kli_vxcf"."_uctupomienky$kli_uzid.hod, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.uhr=F$kli_vxcf"."_uctupomienky$kli_uzid.uhr, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.zos=F$kli_vxcf"."_uctupomienky$kli_uzid.zos ".
" WHERE F$kli_vxcf"."_uctupouhrad$kli_uzid.ico=F$kli_vxcf"."_uctupomienky$kli_uzid.ico ".
" AND   F$kli_vxcf"."_uctupouhrad$kli_uzid.fak=F$kli_vxcf"."_uctupomienky$kli_uzid.fak ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupouhrad$kli_uzid WHERE pox != 2";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET pucu=TO_DAYS(dau)-TO_DAYS(das) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET pucu=0 WHERE pucu < 0 ";
$oznac = mysql_query("$sqtoz");

}
//koniec h_pen > 0

if( $h_ppe > 0 OR $h_ppe == 0 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ".
" WHERE cupo = $newdok AND uhr = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpeu=pucu*(hodu*$h_ppe)/36000 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 99,cupo,das,dau,dok,uce,ico,fak,hod,uhr,zos,hpe,hodu,penu,ppeu,SUM(hpeu),puc,MAX(pucu) ".
" FROM F$kli_vxcf"."_uctupouhrad$kli_uzid".
" WHERE ico = $cislo_ico AND uce = $h_uce GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpe=hpe+hpeu ";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupouhrad$kli_uzid WHERE pox != 99";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=pucu WHERE zos <= 0 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid,F$kli_vxcf"."_uctupouhrad$kli_uzid ".
" SET F$kli_vxcf"."_uctupomienky$kli_uzid.hpe=F$kli_vxcf"."_uctupouhrad$kli_uzid.hpe, ".
"     F$kli_vxcf"."_uctupomienky$kli_uzid.puc=F$kli_vxcf"."_uctupouhrad$kli_uzid.puc ".
" WHERE F$kli_vxcf"."_uctupouhrad$kli_uzid.ico=F$kli_vxcf"."_uctupomienky$kli_uzid.ico ".
" AND   F$kli_vxcf"."_uctupouhrad$kli_uzid.fak=F$kli_vxcf"."_uctupomienky$kli_uzid.fak ";
$oznac = mysql_query("$sqtoz");

if( $h_ppe > 0 AND $h_pen > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky".
" SELECT * FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE hpe > 0";
$dsql = mysql_query("$dsqlt");
}

if( $h_ppe == 0 OR $h_pen == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky".
" SELECT * FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE zos > 0";
$dsql = mysql_query("$dsqlt");
}

}
//koniec h_ppe > 0



$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE cupo = $newdok ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";

}

//penalizacia vsetky za ICO
if ( $copern == 20 )
{
$dness = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dness_sql=SqlDatum($dness);

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupomienky".
" WHERE ico = $cislo_ico AND druh = 20 AND dau = '$dness_sql' ";
$dsql = mysql_query("$dsqlt");

$newdok=1;
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupomienky ORDER by cupo DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $newdok=$riadmax->cupo+1;
  }

$podmucex="uce = $h_uce";
$podmucdx="ucd = $h_uce";
if( $metalco == 1 )
{
$podmucex="( LEFT(uce,3) = 311 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 314  )"; 
$podmucdx="( LEFT(ucd,3) = 311 OR LEFT(ucd,3) = 315 OR LEFT(ucd,3) = 314  )"; 
}

if( $h_pen == 100 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky$kli_uzid".
" SELECT '$newdok','$dnes_sql','$copern',pox1,pox2,pox,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,'$h_pen','$h_ppe',0  ".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE ico = $cislo_ico AND $podmucex AND puc > 0 AND pox = 1 ";
$dsql = mysql_query("$dsqlt");
}

if( $h_pen > 0 OR $h_pen == 0 )
{
$podmzos="zos >= 0 ";
if( $agrostav == 1 AND $h_uce == 37830 ) { $podmzos="zos != 0 "; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky$kli_uzid".
" SELECT '$newdok','$dnes_sql','$copern',0,0,1,drupoh,uce,puc,ume,dat,das,F$kli_vxcf"."_prsaldoicofakp$kli_uzid.dau,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,'$h_pen','$h_ppe',0 ".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE ico = $cislo_ico AND $podmucex AND F$kli_vxcf"."_prsaldoicofakp$kli_uzid.$podmzos";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


if( $h_spl == 1 ) {
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE zos != 0 ";
$oznac = mysql_query("$sqtoz");
                  } 

//exit;

$dnesok = $h_dsp;
if( $dnes == '00.00.0000' ) $dnesok = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$dnesok_sql=SqlDatum($dnesok);
if( $dnesok_sql == '0000-00-00' ) $dnesok_sql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if( $h_pen > 0 ) {
$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ".
" WHERE uhr = 0 AND cupo = $newdok ";
$oznac = mysql_query("$sqtoz");
                 }
if( $h_pen == 0 ) {
$podmzos=" zos <= 0 ";
if( $agrostav == 1 AND $h_uce == 37830 ) { $podmzos=" zos = 0 "; }

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE $podmzos ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ".
" WHERE cupo = $newdok ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$podmpuc=" puc <= 0 ";
if( $agrostav == 1 AND $h_uce == 37830 ) { $podmpuc=" puc > 99999 "; }
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE $podmpuc ";
$oznac = mysql_query("$sqtoz"); 
                 }

//exit;

$nerob=0;
if( $metalco == 1 AND $h_uce == 31411 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ".
" WHERE cupo = $newdok ";
$oznac = mysql_query("$sqtoz");

$nerob=1;
}

if( $h_pen > 0 )
     {
//penalizacia uhradenych
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 1,'$newdok','0000-00-00',dau,dok,uce,ico,fak,0,0,0,0,uhr,'$h_pen','$h_ppe',0,0,0 ".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE ico = $cislo_ico AND $podmucex AND uhr != 0 AND dau != '0000-00-00' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 1,'$newdok','0000-00-00',dat,dok,ucd,ico,fak,0,0,0,0,hod,'$h_pen','$h_ppe',0,0,0 ".
" FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE ico = $cislo_ico AND $podmucdx AND hod != 0 ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid,F$kli_vxcf"."_uctupomienky$kli_uzid ".
" SET F$kli_vxcf"."_uctupouhrad$kli_uzid.das=F$kli_vxcf"."_uctupomienky$kli_uzid.das, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.pox=2, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.hod=F$kli_vxcf"."_uctupomienky$kli_uzid.hod, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.uhr=F$kli_vxcf"."_uctupomienky$kli_uzid.uhr, ".
"     F$kli_vxcf"."_uctupouhrad$kli_uzid.zos=F$kli_vxcf"."_uctupomienky$kli_uzid.zos ".
" WHERE F$kli_vxcf"."_uctupouhrad$kli_uzid.ico=F$kli_vxcf"."_uctupomienky$kli_uzid.ico ".
" AND   F$kli_vxcf"."_uctupouhrad$kli_uzid.fak=F$kli_vxcf"."_uctupomienky$kli_uzid.fak ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupouhrad$kli_uzid WHERE pox != 2";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET pucu=TO_DAYS(dau)-TO_DAYS(das) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET pucu=0 WHERE pucu < 0 ";
$oznac = mysql_query("$sqtoz");
     }

}

//exit;

if( $h_ppe > 0 OR $h_ppe == 0 )
{

if( $h_ppe >= 1 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ".
" WHERE cupo = $newdok AND uhr = 0 ";
$dsql = mysql_query("$dsqlt");
                      }

if( $h_ppe <  1 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET hpe=puc*(zos*$h_ppe)/100 ".
" WHERE cupo = $newdok AND uhr = 0 ";
$dsql = mysql_query("$dsqlt");
                      }

if( $metalco == 1 AND $h_uce == 31411 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ".
" WHERE cupo = $newdok ";
$dsql = mysql_query("$dsqlt");
}
//exit;


if( $nerob == 0 ) {
//echo "robim";

if( $h_ppe >= 1 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpeu=pucu*(hodu*$h_ppe)/36000 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ";
$dsql = mysql_query("$dsqlt");
                      }

if( $h_ppe <  1 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpeu=pucu*(hodu*$h_ppe)/100 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpe=puc*(zos*$h_ppe)/100 ";
$dsql = mysql_query("$dsqlt");
                      }

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupouhrad$kli_uzid".
" SELECT 99,cupo,das,dau,dok,uce,ico,fak,hod,uhr,zos,hpe,hodu,penu,ppeu,SUM(hpeu),puc,MAX(pucu) ".
" FROM F$kli_vxcf"."_uctupouhrad$kli_uzid".
" WHERE ico = $cislo_ico AND $podmucex GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET hpe=hpe+hpeu ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctupouhrad$kli_uzid WHERE pox != 99";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupouhrad$kli_uzid SET puc=pucu WHERE zos <= 0 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid,F$kli_vxcf"."_uctupouhrad$kli_uzid ".
" SET F$kli_vxcf"."_uctupomienky$kli_uzid.hpe=F$kli_vxcf"."_uctupouhrad$kli_uzid.hpe, ".
"     F$kli_vxcf"."_uctupomienky$kli_uzid.puc=F$kli_vxcf"."_uctupouhrad$kli_uzid.puc ".
" WHERE F$kli_vxcf"."_uctupouhrad$kli_uzid.ico=F$kli_vxcf"."_uctupomienky$kli_uzid.ico ".
" AND   F$kli_vxcf"."_uctupouhrad$kli_uzid.fak=F$kli_vxcf"."_uctupomienky$kli_uzid.fak ";
$oznac = mysql_query("$sqtoz");
                    }
//exit;

if( $metalco == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET puc=TO_DAYS('$dnesok_sql')-TO_DAYS(das) ".
" WHERE cupo = $newdok AND zos > 0 AND hpe = 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky$kli_uzid SET hpe=puc*(zos*$h_ppe)/36000 ".
" WHERE cupo = $newdok AND zos > 0 AND hpe = 0 ";
$dsql = mysql_query("$dsqlt");
}

if( $h_ppe > 0 AND $h_pen > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky".
" SELECT * FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE hpe > 0";
$dsql = mysql_query("$dsqlt");
}


if( $h_ppe == 0 OR $h_pen == 0 )
{
$podmzos=" zos > 0 ";
if( $agrostav == 1 AND $h_uce == 37830 ) { $podmzos=" zos != 0 "; };

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctupomienky".
" SELECT * FROM F$kli_vxcf"."_uctupomienky$kli_uzid WHERE $podmzos ";
$dsql = mysql_query("$dsqlt");
if ( $posem == 1 )
          {
$dness = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnesssql=SqlDatum($dness);


$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky".
" SET pox2=1, dau='$dnesssql' WHERE cupo = $newdok ";
$dsql = mysql_query("$dsqlt");


          }
}

}

if( $agrostav == 1 AND $h_uce == 37830 ) 
{ 
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky".
" SET hod=uhr, zos=uhr, uhr=0  WHERE fak = 309915 AND ico = 309915 ";
$dsql = mysql_query("$dsqlt"); 
}


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE cupo = $newdok ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";
//echo $tovtt;

}

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

//echo $tvpol;
//exit;

//Ak su polozky
if( $jetovar == 1 )
           {
$j=0;
$i=0;
  while ($i <= $koniec )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == "00.00.0000" ) $dat_sk="";
$das_sk=SkDatum($rtov->das);
if( $das_sk == "00.00.0000" ) $das_sk="";
$daz_sk=SkDatum($rtov->daz);
if( $daz_sk == "00.00.0000" ) $daz_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

if( $j == 0 )
{
$celkomstrana=0;

if( $i > 0 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);

$sety=10;
$pdf->SetY($sety);
}


$pdf->SetFont('arial','',10);
if( $jednapolozka >= 0 AND $h_pen == 0 ) 
{
$pdf->Cell(180,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc, tel: $fir_ftel, email: $fir_fem1 ","B",1,"L");
}
if( $jednapolozka >= 0 AND $h_pen == 1 ) 
{
$pdf->Cell(180,6,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc, tel: $fir_ftel, email: $fir_fem1 ","0",1,"L");
$pdf->Cell(180,6,"I»O: $fir_fico DI»: $fir_fdic I»DPH: $fir_ficd ","B",1,"L");
}

$pdf->SetFont('arial','',10);
$pdf->Cell(180,5,"     ","0",1,"L");
$pdf->Cell(90,6,"     ","0",0,"L");$pdf->Cell(180,6,"$rtov->nai","0",1,"L");
$pdf->Cell(90,6,"     ","0",0,"L");$pdf->Cell(180,6,"$rtov->uli","0",1,"L");
$pdf->Cell(90,6,"     ","0",0,"L");$pdf->Cell(180,6,"$rtov->psc $rtov->mes","0",1,"L");
if( $h_pen == 1 ) 
{
$pdf->Cell(90,6,"     ","0",0,"L");$pdf->Cell(180,6,"I»O:$rtov->ico DI»:$rtov->dic I»DPH:$rtov->icd","0",1,"L");

}


$pdf->Cell(180,5,"     ","0",1,"L");
if( $h_pen != 1 )
     {
if( $odsuhlas == 0 ) { $pdf->Cell(180,10,"Vec: UPOMIENKA NEZAPLATEN›CH FAKT⁄R PO LEHOTE SPLATNOSTI. ","0",1,"L"); }
if( $odsuhlas == 1 ) { $pdf->Cell(180,10,"Vec: ODS⁄HLASENIE NEZAPLATEN›CH FAKT⁄R PO LEHOTE SPLATNOSTI. ","0",1,"L"); }
     }
if( $h_pen == 1 )
     {
$pdf->Cell(180,10,"Vec: PENALIZA»N¡ FAKT⁄RA ËÌslo $rtov->cupo/$kli_vrok ","0",1,"L");
     }

//upomienka pred polozkami
if( $h_pen != 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_upop=$riaddok->upop;
  $h_upoz=$riaddok->upoz;
  }

$pole = explode("\r", $h_upop);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$hodnota=str_replace("\n","",$hodnota);
$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,6,"  ","0",1,"R");
}
     }
//koniec upomienka pred polozkami

//penalizacna pred polozkami
if( $h_pen == 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_penp=$riaddok->penp;
  $h_penz=$riaddok->penz;
  }

$pole = explode("\r", $h_penp);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$hodnota=str_replace("\n","",$hodnota);
$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,6,"  ","0",1,"R");
}
     }
//koniec penalizacna pred polozkami

$pdf->SetFont('arial','',8);
if( $h_ppe <= 0 )
     {
$pdf->Cell(20,6,"Fakt˙ra","B",0,"R");$pdf->Cell(20,6,"Vystaven·","B",0,"L");$pdf->Cell(20,6,"Splatn·","B",0,"L");
$pdf->Cell(30,6,"Dni po splatnosti","B",0,"L");
$pdf->Cell(30,6,"Hodnota","B",0,"R");$pdf->Cell(30,6,"UhradenÈ","B",0,"R");
$pdf->Cell(30,6,"Zostatok $mena1 ","B",1,"R");
     }
if( $h_ppe > 0 )
     {
$pdf->Cell(20,6,"Fakt˙ra","B",0,"R");$pdf->Cell(20,6,"Vystaven·","B",0,"L");$pdf->Cell(20,6,"Splatn·","B",0,"L");
$pdf->Cell(25,6,"Dni po splatnosti","B",0,"L");
$pdf->Cell(25,6,"Hodnota","B",0,"R");$pdf->Cell(25,6,"UhradenÈ","B",0,"R");
$pdf->Cell(25,6,"Zostatok $mena1 ","B",0,"R");$pdf->Cell(25,6,"Pen·le $mena1 ","B",1,"R");
     }
}

$celkomstrana=$celkomstrana+$rtov->zos;
$Cislo=$celkomstrana+"";
$Hcelkomstrana=sprintf("%0.2f", $Cislo);

$celkomstranap=$celkomstranap+$rtov->hpe;
$Cislo=$celkomstranap+"";
$Pcelkomstrana=sprintf("%0.2f", $Cislo);

if( $h_ppe <= 0 )
     {
$pdf->Cell(20,6,"$rtov->fak","0",0,"R");$pdf->Cell(20,6,"$dat_sk","0",0,"L");$pdf->Cell(20,6,"$das_sk","0",0,"L");
$pdf->Cell(30,6,"$pospl","0",0,"L");
$pdf->Cell(30,6,"$rtov->hod","0",0,"R");$pdf->Cell(30,6,"$rtov->uhr","0",0,"R");
$pdf->Cell(30,6,"$rtov->zos","0",1,"R");
     }
if( $h_ppe > 0 )
     {
$pdf->Cell(20,6,"$rtov->fak","0",0,"R");$pdf->Cell(20,6,"$dat_sk","0",0,"L");$pdf->Cell(20,6,"$das_sk","0",0,"L");
$pdf->Cell(25,6,"$pospl","0",0,"L");
$pdf->Cell(25,6,"$rtov->hod","0",0,"R");

if( $h_pen == 0 ) { $pdf->Cell(25,6,"$rtov->uhr","0",0,"R");$pdf->Cell(25,6,"$rtov->zos","0",0,"R"); }
if( $h_pen == 1 AND $rtov->uhr == 0 ) { $pdf->Cell(25,6,"$rtov->uhr","0",0,"R");$pdf->Cell(25,6,"$rtov->zos","0",0,"R"); }
if( $h_pen == 1 AND $rtov->uhr != 0 ) 
{ $pdf->Cell(17,6,"$rtov->uhr","0",0,"R");$pdf->Cell(15,6,"$daz_sk","0",0,"L");$pdf->Cell(18,6,"$rtov->zos","0",0,"R"); }

$pdf->Cell(25,6,"$rtov->hpe","0",1,"R");
     }

}
$i = $i + 1;
$j = $j + 1;

//if( $j == 8 ) { $j=0; }

  }
//koniec while
           }
//koniec ak su polozky

if( $h_ppe <= 0 )
     {
$pdf->Cell(20,6," ","T",0,"R");$pdf->Cell(20,6," ","T",0,"L");$pdf->Cell(20,6," ","T",0,"L");
$pdf->Cell(30,6," ","T",0,"L");
$pdf->Cell(30,6," ","T",0,"R");$pdf->Cell(30,6,"CELKOM","T",0,"R");
$pdf->Cell(30,6,"$Hcelkomstrana","T",1,"R");
     }
if( $h_ppe > 0 )
     {
$pdf->Cell(20,6," ","T",0,"R");$pdf->Cell(20,6," ","T",0,"L");$pdf->Cell(20,6," ","T",0,"L");
$pdf->Cell(25,6," ","T",0,"L");
$pdf->Cell(25,6," ","T",0,"R");$pdf->Cell(25,6,"CELKOM","T",0,"R");
$pdf->Cell(25,6,"$Hcelkomstrana","T",0,"R");$pdf->Cell(25,6,"$Pcelkomstrana","T",1,"R");
     }

$pdf->SetFont('arial','',10);
if( $h_ppe > 0 )
     {
$pdf->Cell(180,5,"     ","0",1,"L");
if( $rtov->ppe >= 1 ) { $pdf->Cell(180,6,"Percento vypoËÌtanÈho pen·le $rtov->ppe % ppa.","0",1,"L"); }
if( $rtov->ppe <  1 ) { $pdf->Cell(180,6,"Percento vypoËÌtanÈho pen·le $rtov->ppe % na deÚ omeökania.","0",1,"L"); }
     }

//upomienka za polozkami
if( $h_pen != 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$pole = explode("\r", $h_upoz);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$hodnota=str_replace("\n","",$hodnota);
$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,6,"  ","0",1,"R");
}
     }
//koniec upomienka za polozkami

//penale za polozkami
if( $h_pen == 1 )
     {
$pdf->Cell(180,2,"     ","0",1,"L");

$pole = explode("\r", $h_penz);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$hodnota=str_replace("\n","",$hodnota);
$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,6,"  ","0",1,"R");
}
     }
//koniec penale za polozkami

$pdf->Cell(180,6,"     ","0",1,"L");
if( $h_pen != 1 )
     {
$pdf->Cell(90,6,"$fir_fmes dÚa: $dnes ","0",0,"L");$pdf->Cell(90,6,"Vybavuje: $kli_uzmeno $kli_uzprie, ËÌslo upomienky: $rtov->cupo ","0",1,"L");
     }
if( $h_pen == 1 )
     {
$pdf->Cell(90,6,"$fir_fmes dÚa: $dnes ","0",0,"L");$pdf->Cell(90,6,"Vybavuje: $kli_uzmeno $kli_uzprie, ËÌslo penaliz·cie: $rtov->cupo ","0",1,"L");
     }

$sumary=34;
$sumarx=70;
$pdf->SetY($sumary);
$pdf->SetX($sumarx);
$pdf->SetFont('arial','',10);
//$pdf->Cell(35,6,"$Hcelkomstrana","0",0,"R");





$pdf->Output("../tmp/upom$cislo_dok.$kli_uzid.pdf");

 
//////////////////////////////////////////////////////ak nie je email
          }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Upomienka PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php if( $zandroidu == 0 ) { ?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Upomienka</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php                       } ?> 

<?php if( $zandroidu == 1 ) { ?> 
<table class="h2" width="100%" >
<tr>
<td>Zostava PDF prebran·, tlaËidlo Sp‰ù - do saldokonta</td>
<td align="right"></td>
</tr>
</table>
<br />
<?php                       } ?> 


<?php 
//////////////////////////////////////////////////////ak nie je email
if ( $posem == 0 )
          {
?>
<script type="text/javascript">
  var okno = window.open("../tmp/upom<?php echo $cislo_dok; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
          }
//////////////////////////////////////////////////////koniec ak nie je email

//////////////////////////////////////////////////////ak je email
if ( $posem == 1 )
          {


$predmet=$fir_fnaz.", ".$fir_fmes." UPOMIENKA NEZAPLATEN›CH FAKT⁄R PO LEHOTE SPLATNOSTI ";
//$predmet = iconv("CP1250", "UTF-8", $predmet);
$predmet = StrTr($predmet, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$riadok1="Vazeny odberatel, "."\n";
$riadok2="kontrolou nasho saldokonta sme zistili tieto neuhradene faktury po lehote splatnosti vystavene na Vasu spolocnost ."."\n"."\n";
$riadok3="____Faktura Vystavena_ Splatna___ Dni po splatnosti ___Hodnota __Uhradene _Zostatok Eur"."\n";

$sprava=$riadok1.$riadok2.$riadok3;
$fakrd="";

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
  while ($i <= $koniec )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if( $i == 0 )
  {
$odberatel="\n"."Pre firmu ICO ".$rtov->ico." ".$rtov->nai.", ".$rtov->mes."\n"."\n";
$odberatel = StrTr($odberatel, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$sprava=$sprava.$odberatel;
  }

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == "00.00.0000" ) $dat_sk="";
$das_sk=SkDatum($rtov->das);
if( $das_sk == "00.00.0000" ) $das_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

$celkomstrana=$celkomstrana+$rtov->zos;
$Cislo=$celkomstrana+"";
$Hcelkomstrana=sprintf("%0.2f", $Cislo);

$h_fak=sprintf("% 10s",$rtov->fak);
$h_pos=sprintf("% 17s",$pospl);
$h_hod=sprintf("% 10s",$rtov->hod);
$h_uhr=sprintf("% 10s",$rtov->uhr);
$h_zos=sprintf("% 13s",$rtov->zos);

$sprava=$sprava." ".$h_fak." ".$dat_sk." ".$das_sk." ".$h_pos." ".$h_hod." ".$h_uhr." ".$h_zos." "."\n";
$fakrd=$fakrd." ".$rtov->fak." ".$dat_sk." ".$das_sk." ".$pospl." ".$rtov->hod." ".$rtov->uhr." ".$rtov->zos." "."\n";

$emailkomu=$rtov->em1;
//echo $emailkomu;
}
$i = $i + 1;
$j = $j + 1;


  }
//koniec while
           }
//koniec ak su polozky

$h_cel=sprintf("% 13s",$celkomstrana);
$sprava=$sprava."___________________________________________________________________CELKOM ".$h_cel." "."\n"."\n";

$sprava=$sprava."ProsÌme o Vaöu kontrolu nezaplaten˝ch fakt˙r po lehote splatnosti."."\n";
$sprava=$sprava."Pokiaæ ste uvedenÈ fakt˙ry po lehote splatnosti doposiaæ nezaplatili, urobte tak prosÌm ihneÔ na n·ö"."\n";
$sprava=$sprava."bankov˝ ˙Ëet ".$fir_fuc1." / ".$fir_fnm1." . "."\n";
$sprava=$sprava."V prÌpade, ûe ste uvedenÈ fakt˙ry po lehote splatnosti uhradili, povaûujte prosÌm t˙to upomienku za bezpredmetn˙ . "."\n"."\n";
$sprava=$sprava."Vybavuje: $kli_uzmeno $kli_uzprie, ËÌslo upomienky: $rtov->cupo "."\n";



$sprava = StrTr($sprava, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");


$emailodkoho=$fir_fem3;
//echo $emailodkoho;

if( $emailkomu == '' )
{
 echo "Vybran˝ odberateæ nem· zadan˝ email Ë.1 v ËÌselnÌku I»O <br />";
 exit;
}

if( $emailodkoho == '' )
{
 echo "Nem·te zadan˝ email Ë.3 v ˙dajoch o Vaöej firme <br />";
 exit;
}

if(mail("$emailkomu, $fir_fem3","$predmet","$sprava","From: $emailodkoho"))
{
$dsqlt = "UPDATE F$kli_vxcf"."_uctupomienky SET poz='$emailkomu', pox2=1 WHERE cupo = $newdok ";
$dsql = mysql_query("$dsqlt");

 echo "Komu: ".$emailkomu."<br />";
 echo "Od: ".$emailodkoho."<br />";
 echo $predmet."<br />";
 echo $riadok1."<br />";
 echo $riadok2."<br />";
 echo $riadok3."<br />";
 echo $fakrd."<br />";

 echo "<br />";
 echo "<br />";

 print "Email bol ˙speöne odoslan˝. <br />";
}
else
{
 print "Email nebol odoslan˝ zopakujte odosielanie.<br>\n";
}

//////////////////////////////////////////////////////koniec ak je email
          }

?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
