<HTML>
<?php
//VYTLACI SALDOKONTO VO FORMATE PDF

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

  }

if( $zandroidu == 0 )
  {
$sys = 'UCT';
$urov = 1000;
$zkosika = 1*$_REQUEST['zkosika'];
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
if( $zkosika == 1 ) { $sys='UCT'; $urov=1; }
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
$vsetko=1;
if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$h_uce = $_REQUEST['h_uce'];
$h_obd = $_REQUEST['h_obd'];
$h_ico = 1*$_REQUEST['h_ico'];
$cislo_fak = 1*$_REQUEST['cislo_fak'];
//ci tlacit len sumy za ico alebo aj polozky
$sumico = 1*$_REQUEST['sumico'];

$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

$h_su = 1*$_REQUEST['h_su'];
$h_al = 1*$_REQUEST['h_al'];

$h_nai = $_REQUEST['h_nai'];

//echo $h_nai." ";
//exit;

if( $zkosika == 0 ) {
$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
                    }
//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//ak volame z cico.php v agrostave pre tlac saldo z ciselnika ico
$zico = 1*$_REQUEST['zico'];
if( $kli_vxcf == 3 AND $agrostav == 1 ) { $kli_uzid=17; $kli_vxcf=110; }
if( $kli_vxcf == 4 AND $agrostav == 1 ) { $kli_uzid=17; $kli_vxcf=111; }
if( $kli_vxcf == 5 AND $agrostav == 1 ) { $kli_uzid=17; $kli_vxcf=112; }
if( $kli_vxcf == 6 AND $agrostav == 1 ) { $kli_uzid=17; $kli_vxcf=123; }
if( $kli_vxcf == 7 AND $agrostav == 1 ) { $kli_uzid=17; $kli_vxcf=124; }

//ak volame z kosik_tlac.php v eshope pre tlac saldo z eshopu kosika
$zkosika = 1*$_REQUEST['zkosika'];
if( $zkosika == 1 ) { $kli_uzid=38; $kli_vxcf=53; }


$hhmmss = Date ("i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/saldo_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/saldo_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 AND $copern != 14 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 OR $copern == 14 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


////////////////////////////////////////////////////////datum pociatku a konca salda

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

$h_obdcel=$h_obd.".".$kli_vrok;
$pole = explode(".", $h_obdcel);
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

//exit;

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

////////////////////////////////////////////////////////koniec datum pociatku a konca salda


////////////////////////////////////////////////////////////nastavenia co brat vsetky/nesparovane , obdobie

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
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
   zos         DECIMAL(10,2),
   dau         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $copern == 12 ) { $h_obd=0; $vsetko=1; $drupoh=2; }

if( $copern == 14 ) { $h_obd=0; $vsetko=1; $drupoh=4; }

if ( $h_obd == 0 ) { $datpod = ""; }

$datmr=$kli_vrok."-01-01";
if ( $h_obd == 100 ) { $datpod = "AND ( ( dat < '$datmr' AND dat != '0000-00-00' ) OR ( dau < '$datmr' AND dau != '0000-00-00') )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod = "AND ( ( dat != '0000-00-00' AND dat <= '".$datk_dph."' ) OR ( dau <= '".$datk_dph."' AND dau != '0000-00-00' ) )"; }

$podmucex="uce = $h_uce";
if ( $h_su == 1 ) { $h_uce3=substr($h_uce,0,3); $podmucex="LEFT(uce,3) = $h_uce3"; }
if ( $h_al == 1 ) { $podmucex="( LEFT(uce,2) = 31 OR LEFT(uce,2) = 32 OR LEFT(uce,2) = 37 OR LEFT(uce,2) = 39 )"; }

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE $podmucex ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");
                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 ) { 


$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,MAX(das),daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE $podmucex ".$datpod." ".
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;
                   }
//koniec vyrobenia noveho saldoicofak podla obdobia


//zober vsetky
if ( $drupoh == 1 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE $podmucex ".$datpod.
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky

//uprava ak len nesparovane vsetko=0
if ( $drupoh == 1 AND $vsetko == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE zos != 0 ".$datpod.
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak len nesparovane vsetko=0

//exit;

//uprava ak za vsetky ico daj sucty
if ( $drupoh == 1 AND $h_ico == 0  )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0


//sucet za ucet
if ( $drupoh == 1 AND $h_ico > 0 AND ( $h_su > 0 OR $h_al > 0 ))
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 AND ico = $h_ico AND pox = 1".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

}
//koniec sucet za ucet


//sucet za ucet
if ( $drupoh == 1 AND $h_ico == 0 AND ( $h_su > 0 OR $h_al > 0 ))
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1999,0,1999,drupoh,uce,puc,ume,dat,das,daz,dok,99999999,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 AND pox = 1".
" GROUP BY uce";
$dsql = mysql_query("$dsqlt");

}
//koniec sucet za ucet


//zober vsetky za jednu fakturu
if ( $drupoh == 2 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldo$kli_uzid.fak = $cislo_fak AND F$kli_vxcf"."_prsaldo$kli_uzid.ico = $h_ico ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky za jednu fakturu

//zober vsetky za vsetky faktury
if ( $drupoh == 4 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldo$kli_uzid.fak >= 0 AND F$kli_vxcf"."_prsaldo$kli_uzid.ico >= 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky za vsetky faktury

//exit;

////////////////////////////////////////////////////////////koniec nastavenia co brat


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = SqlDatum($h_dsp);
if( $dnes == '0000-00-00' ) $dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");

//echo $datk_dph;
//exit;

$nulovazostava=1;

////////////////////////////////////////////////////////////////////////////////pre jedno ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico > 0 )
{
if( $analyzy == 1) 
     {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_anauceico'.$kli_uzid;
$sql = mysql_query("$sqlt");

$sqlt = <<<anal
(
   uce         VARCHAR(30),
   ico         VARCHAR(30)
);
anal;
$sqlt = 'CREATE TABLE F'.$kli_vxcf.'_anauceico'.$kli_uzid.$sqlt;
$sql = mysql_query("$sqlt");

$ttvv = "INSERT INTO F$kli_vxcf"."_anauceico".$kli_uzid." ( uce,ico ) VALUES ( '$h_uce', '$h_ico' )";
$ttqq = mysql_query("$ttvv");
     }


$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.ico = $h_ico AND $podmucex ".
"";

//echo $sqltt;
$sql = mysql_query("$sqltt");
     

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);
$strana=1;
$hod=0;
$uhr=0;
$zos=0;

//koniec hlavicka pred

//zaciatok vypisu tovaru
if( $metalco == 1 )
{
$tovttu = "UPDATE F$kli_vxcf"."_$uctpol SET dat=dau".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND $podmucex AND dat = '0000-00-00' ";
$tovu = mysql_query("$tovttu");
}

if( $alchem == 1 )
{
$tovttu = "DELETE FROM F$kli_vxcf"."_$uctpol ".
" WHERE uce = 37950 ";
$tovu = mysql_query("$tovttu");
}

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND $podmucex ".
" ORDER BY uce,pox,dat,dok,fak";

//echo $tovtt;

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

//ak j=0
if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 ) { $pdf->Cell(90,5,"Saldokonto nesp·rovanÈ","LTB",0,"L"); }

$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="PoËiatoËn˝ stav";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"⁄Ëet: $rtov->uce","0",0,"L");
$pdf->Cell(90,4,"Obdobie: $h_obdn","0",1,"L");
$pdf->Cell(180,4,"I»O: $h_ico, $hlavicka->nai, $hlavicka->mes $hlavicka->tel $hlavicka->em1 ","0",1,"L");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystaven·","1",0,"L");$pdf->Cell(20,4,"Splatn·","1",0,"L");
$pdf->Cell(10,4,"poSPL","1",0,"L");
$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"UhradenÈ","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");


      }
//koniec j=0


$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

//sumare napocet

if( $rtov->pox == 1 )
           {
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);
           }

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

if( $rtov->pox == 1 )
           {
$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");$pdf->Cell(20,4,"$das_sk","0",0,"L");
$pdf->Cell(10,4,"$pospl","0",0,"R");

$odkaz="../ucto/saldo_htm.php?copern=12&h_uce=".$rtov->uce."&h_ico=".$rtov->ico."&h_obd=0&cislo_fak=".$rtov->fak."&drupoh=1&ajspat=1";


$pdf->Cell(20,4,"$rtov->fak","0",0,"R",0,$odkaz);
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");
if( $rtov->poz != '' ) { $pdf->Cell(85,4," ","0",0,"R");$pdf->Cell(0,4,"$rtov->poz","0",1,"L"); $j=$j+1; }
           }

if( $rtov->pox == 1 )
           {
if( $h_spl == 1 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl == 1 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl == 2 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl == 3 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl == 4 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl == 5 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl >  5 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 2 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >  0 AND $pospl <=  5 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  5 AND $pospl <= 14 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl > 14 AND $pospl <= 30 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl > 30 AND $pospl <= 60 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 60 AND $pospl <= 90 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 90 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 3 ) { 
     if( $pospl <   1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >   0 AND $pospl <=  30 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  30 AND $pospl <=  60 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  60 AND $pospl <=  90 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  90 AND $pospl <= 180 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 180 AND $pospl <= 360 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 360 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 4 ) { 
     if( $pospl <    1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >    0 AND $pospl <=  180 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  180 AND $pospl <=  360 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  360 AND $pospl <=  720 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  720 AND $pospl <= 1080 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 1080 AND $pospl <= 1440 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 1440 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }

           }

if( $rtov->pox == 1999 )
           {

$pdf->Cell(105,4,"Spolu ˙Ëet $rtov->uce","T",0,"L");
$pdf->Cell(25,4,"$rtov->hod","T",0,"R");$pdf->Cell(25,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
$pdf->Cell(90,1,"","0",1,"L");
$j=$j+2;
           }

}
$i = $i + 1;
$j = $j + 1;


//stranka jedno ICO
//$pdf->Cell(20,4,"$j do 60","0",1,"R");
if( $j >= 60 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

$pdf->Cell(90,1,"","0",1,"L");
$pdf->Cell(105,4,"SPOLU celkom","T",0,"R");
$pdf->Cell(25,4,"$Shod","T",0,"R");$pdf->Cell(25,4,"$Suhr","T",0,"R");$pdf->Cell(0,4,"$Szos","T",1,"R");

  }
//koniec hlavicky pre jedno ICO


//vyhodnotenie splatnosti
if( $h_spl > 0 )
     {
$pdf->Cell(90,5,"","0",1,"L");
$pdf->Cell(160,5,"NeuhradenÈ fakt˙ry rozdelenÈ podæa doby po splatnosti k $h_dsp","0",1,"L");
if( $h_spl == 1 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"1deÚ po","1",0,"R");$pdf->Cell(23,4,"2dni po","1",0,"R");$pdf->Cell(23,4,"3dni po","1",0,"R");
$pdf->Cell(23,4,"4dni po","1",0,"R");$pdf->Cell(23,4,"5dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 2 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 5dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 14dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 30dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 60dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 90dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 3 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 30dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 60dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 90dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 180dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 360dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 4 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 180dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 360dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 720dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 1080dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 1440dnÌ po","1",0,"R");$pdf->Cell(23,4,"nad 1440dnÌ po","1",1,"R");
                  }

$pdf->Cell(23,4,"$stlp1","1",0,"R");$pdf->Cell(23,4,"$stlp8","1",0,"R");
$pdf->Cell(23,4,"$stlp2","1",0,"R");$pdf->Cell(23,4,"$stlp3","1",0,"R");$pdf->Cell(23,4,"$stlp4","1",0,"R");
$pdf->Cell(23,4,"$stlp5","1",0,"R");$pdf->Cell(23,4,"$stlp6","1",0,"R");$pdf->Cell(23,4,"$stlp7","1",1,"R");
     }
//koniec vyhodnotenie splatnosti


//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy

}
///////////////////////////////////////////////////////////////////////////////koniec pre jedno ICO


///////////////////////////////////////////////////////////////////////////////pre vsetky ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico == 0 )
{

//ak zadany text h_nai pohladaj len ktore vyhovuju
$podmnaz="";
$podmcic="";
if ( $h_ico == 0 AND $h_nai != "" )
     {
$naidlzka=strlen($h_nai);
if ( $naidlzka > 2 )  {

$pole = explode(",", $h_nai);
$h_nai1=trim($pole[0]); if( strlen($h_nai1) <= 2 ) $h_nai1="";  $c_nai1=1*$h_nai1;
$h_nai2=trim($pole[1]); if( strlen($h_nai2) <= 2 ) $h_nai2="";  $c_nai2=1*$h_nai2;
$h_nai3=trim($pole[2]); if( strlen($h_nai3) <= 2 ) $h_nai3="";  $c_nai3=1*$h_nai3;
$h_nai4=trim($pole[3]); if( strlen($h_nai4) <= 2 ) $h_nai4="";  $c_nai4=1*$h_nai4;
$h_nai5=trim($pole[4]); if( strlen($h_nai5) <= 2 ) $h_nai5="";  $c_nai5=1*$h_nai5;

if( $h_nai1 != '' ) $podmnaz=" AND nai LIKE '%$h_nai1%' ";
if( $h_nai1 != '' AND $h_nai2 != '' ) $podmnaz=" AND ( nai LIKE '%$h_nai1%' OR nai LIKE '%$h_nai2%' ) ";
if( $h_nai1 != '' AND $h_nai2 != '' AND $h_nai3 != '' ) $podmnaz=" AND ( nai LIKE '%$h_nai1%' OR nai LIKE '%$h_nai2%' OR nai LIKE '%$h_nai3%' ) ";
if( $h_nai1 != '' AND $h_nai2 != '' AND $h_nai3 != '' AND $h_nai4 != '' ) 
$podmnaz=" AND ( nai LIKE '%$h_nai1%' OR nai LIKE '%$h_nai2%' OR nai LIKE '%$h_nai3%' OR nai LIKE '%$h_nai4%' ) ";
if( $h_nai1 != '' AND $h_nai2 != '' AND $h_nai3 != '' AND $h_nai4 != '' AND $h_nai5 != '' ) 
$podmnaz=" AND ( nai LIKE '%$h_nai1%' OR nai LIKE '%$h_nai2%' OR nai LIKE '%$h_nai3%' OR nai LIKE '%$h_nai4%' OR nai LIKE '%$h_nai5%' ) ";

if( $c_nai1 > 0 ) 
{
$podmnaz="";

if( $c_nai1 != '' ) $podmcic=" AND F$kli_vxcf"."_$uctpol.ico = $c_nai1 ";
if( $c_nai1 != '' AND $c_nai2 != '' ) $podmcic=" AND ( F$kli_vxcf"."_$uctpol.ico = $c_nai1 OR F$kli_vxcf"."_$uctpol.ico = $c_nai2 ) ";
if( $c_nai1 != '' AND $c_nai2 != '' AND $c_nai3 != '' ) $podmcic=" AND ( F$kli_vxcf"."_$uctpol.ico = $c_nai1 OR F$kli_vxcf"."_$uctpol.ico = $c_nai2 OR F$kli_vxcf"."_$uctpol.ico = $c_nai3 ) ";
if( $c_nai1 != '' AND $c_nai2 != '' AND $c_nai3 != '' AND $c_nai4 != '' ) 
$podmcic=" AND ( F$kli_vxcf"."_$uctpol.ico = $c_nai1 OR F$kli_vxcf"."_$uctpol.ico = $c_nai2 OR F$kli_vxcf"."_$uctpol.ico = $c_nai3 OR F$kli_vxcf"."_$uctpol.ico = $c_nai4 ) ";
if( $c_nai1 != '' AND $c_nai2 != '' AND $c_nai3 != '' AND $c_nai4 != '' AND $c_nai5 != '' ) 
$podmcic=" AND ( F$kli_vxcf"."_$uctpol.ico = $c_nai1 OR F$kli_vxcf"."_$uctpol.ico = $c_nai2 OR F$kli_vxcf"."_$uctpol.ico = $c_nai3 OR F$kli_vxcf"."_$uctpol.ico = $c_nai4 OR F$kli_vxcf"."_$uctpol.ico = $c_nai5 ) ";

}

                      }
     }
//koniec ak zadany text h_nai

$strana=1;
//zaciatok vypisu tovaru
if( $metalco == 1 )
{
$tovttu = "UPDATE F$kli_vxcf"."_$uctpol SET dat=dau".
" WHERE $podmucex $podmnaz $podmcic AND dat = '0000-00-00' ";
$tovu = mysql_query("$tovttu");
}

$trdico="nai,";
if( $slovakiaplay == 1 ) { $trdico=""; }


if( $analyzy == 1) 
     {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_anauceico'.$kli_uzid;
$sql = mysql_query("$sqlt");

$sqlt = <<<anal
(
   uce         VARCHAR(30),
   ico         VARCHAR(30)
);
anal;
$sqlt = 'CREATE TABLE F'.$kli_vxcf.'_anauceico'.$kli_uzid.$sqlt;
$sql = mysql_query("$sqlt");

$ttvv = "INSERT INTO F$kli_vxcf"."_anauceico".$kli_uzid." ( uce,ico ) VALUES ( '$h_uce', '$h_ico' )";
$ttqq = mysql_query("$ttvv");
     }


$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE $podmucex $podmnaz $podmcic".
" ORDER BY uce,pox1,".$trdico."F$kli_vxcf"."_$uctpol.ico,pox,dat,dok,fak";


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

//ak j=0
if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 ) { $pdf->Cell(90,5,"Saldokonto nesp·rovanÈ","LTB",0,"L"); }

$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="PoËiatoËn˝ stav";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"⁄Ëet: $rtov->uce","0",0,"L");
$pdf->Cell(90,4,"Obdobie: $h_obdn","0",1,"L");

$pdf->Cell(90,4,"Firma","1",0,"L");
$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystaven·","1",0,"L");$pdf->Cell(20,4,"Splatn·","1",0,"L");
$pdf->Cell(10,4,"poSPL","1",0,"L");
$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"UhradenÈ","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");

if( $sumico == 1 ) $j=1;
      }
//koniec j=0

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$poz=$rtov->poz;
if( $alchem == 1 AND $rtov->poz == '(55)odber. fakt˙ra' ) $poz="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//sumare napocet
if( $rtov->pox == 1 )
           {
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);
           }

if( $rtov->pox == 1 )
           {
if( $sumico == 0 )
{
$pdf->Cell(90,4,"I»O: $rtov->ico, $rtov->nai, $rtov->mes","0",0,"L");
$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");$pdf->Cell(20,4,"$das_sk","0",0,"L");
$pdf->Cell(10,4,"$pospl","0",0,"R");

$odkaz="../ucto/saldo_htm.php?copern=12&h_uce=".$rtov->uce."&h_ico=".$rtov->ico."&h_obd=0&cislo_fak=".$rtov->fak."&drupoh=1&ajspat=1&pdfx=$outfilex";


$pdf->Cell(20,4,"$rtov->fak","0",0,"R",0,$odkaz);
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");
if( $poz != '' ) { $pdf->Cell(0,4,"$poz","0",1,"L"); $j=$j+1; }
}
if( $h_spl == 1 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl == 1 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl == 2 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl == 3 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl == 4 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl == 5 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl >  5 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 2 ) { 
     if( $pospl <  1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >  0 AND $pospl <=  5 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  5 AND $pospl <= 14 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl > 14 AND $pospl <= 30 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl > 30 AND $pospl <= 60 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 60 AND $pospl <= 90 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 90 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 3 ) { 
     if( $pospl <   1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >   0 AND $pospl <=  30 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  30 AND $pospl <=  60 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  60 AND $pospl <=  90 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  90 AND $pospl <= 180 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 180 AND $pospl <= 360 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 360 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }
if( $h_spl == 4 ) { 
     if( $pospl <    1 ) $stlp1=$stlp1+$rtov->zos;
     if( $pospl >    0 AND $pospl <=  180 ) $stlp2=$stlp2+$rtov->zos;
     if( $pospl >  180 AND $pospl <=  360 ) $stlp3=$stlp3+$rtov->zos;
     if( $pospl >  360 AND $pospl <=  720 ) $stlp4=$stlp4+$rtov->zos;
     if( $pospl >  720 AND $pospl <= 1080 ) $stlp5=$stlp5+$rtov->zos;
     if( $pospl > 1080 AND $pospl <= 1440 ) $stlp6=$stlp6+$rtov->zos;
     if( $pospl > 1440 ) $stlp7=$stlp7+$rtov->zos;
     if( $pospl >  0 ) $stlp8=$stlp8+$rtov->zos;
                  }

           }

if( $rtov->pox == 999 )
           {
if( $sumico == 0 )
{
$pdf->Cell(195,4,"$rtov->uce spolu za I»O","T",0,"R");
$pdf->Cell(25,4,"$rtov->hod","T",0,"R");$pdf->Cell(25,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
if( $sumico == 1 )
{
$pdf->Cell(195,4,"I»O: $rtov->ico, $rtov->nai, $rtov->mes"," ",0,"L");
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$rtov->zos","0",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
}
           }

if( $rtov->pox == 1999 )
           {

$pdf->Cell(195,4,"Spolu ˙Ëet $rtov->uce","T",0,"L");
$pdf->Cell(25,4,"$rtov->hod","T",0,"R");$pdf->Cell(25,4,"$rtov->uhr","T",0,"R");$pdf->Cell(0,4,"$rtov->zos","T",1,"R");
$pdf->Cell(90,1,"","0",1,"L");
$pdf->Cell(90,1,"","0",1,"L");
           }

$rtovpox=$rtov->pox;
}
$i = $i + 1;

//stranka vsetky ICO
//$pdf->Cell(20,4,"$j do 37","0",1,"R");

if( $sumico == 0 ) { $j = $j + 1; }
if( $j >= 36 AND $sumico == 0 ) { $j=0; $strana=$strana+1; }
if( $sumico == 1 AND $rtovpox == 999 ) { $j = $j + 1; }
if( $j >= 32 AND $sumico == 1 ) { $j=0; $strana=$strana+1; }
if( $rtovpox == 1999 ) { $j = 0; }

  }

           }
//koniec ak je tovar

$pdf->Cell(90,4,"","0",1,"L");
$pdf->Cell(195,4,"SPOLU celkom","T",0,"R");
$pdf->Cell(25,4,"$Shod","T",0,"R");$pdf->Cell(25,4,"$Suhr","T",0,"R");$pdf->Cell(0,4,"$Szos","T",1,"R");

//vyhodnotenie splatnosti
if( $h_spl > 0 )
     {
$pdf->Cell(90,5,"","0",1,"L");
$pdf->Cell(160,5,"NeuhradenÈ fakt˙ry rozdelenÈ podæa doby po splatnosti k $h_dsp","0",1,"L");
if( $h_spl == 1 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"1deÚ po","1",0,"R");$pdf->Cell(23,4,"2dni po","1",0,"R");$pdf->Cell(23,4,"3dni po","1",0,"R");
$pdf->Cell(23,4,"4dni po","1",0,"R");$pdf->Cell(23,4,"5dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 2 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 5dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 14dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 30dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 60dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 90dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 3 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 30dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 60dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 90dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 180dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 360dnÌ po","1",0,"R");$pdf->Cell(23,4,"ViacdnÌ po","1",1,"R");
                  }
if( $h_spl == 4 ) { 
$pdf->Cell(23,4,"Do lehoty","1",0,"R");$pdf->Cell(23,4,"Po lehote","1",0,"R");
$pdf->Cell(23,4,"do 180dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 360dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 720dnÌ po","1",0,"R");
$pdf->Cell(23,4,"do 1080dnÌ po","1",0,"R");$pdf->Cell(23,4,"do 1440dnÌ po","1",0,"R");$pdf->Cell(23,4,"nad 1440dnÌ po","1",1,"R");
                  }
$pdf->Cell(23,4,"$stlp1","1",0,"R");$pdf->Cell(23,4,"$stlp8","1",0,"R");
$pdf->Cell(23,4,"$stlp2","1",0,"R");$pdf->Cell(23,4,"$stlp3","1",0,"R");$pdf->Cell(23,4,"$stlp4","1",0,"R");
$pdf->Cell(23,4,"$stlp5","1",0,"R");$pdf->Cell(23,4,"$stlp6","1",0,"R");$pdf->Cell(23,4,"$stlp7","1",1,"R");
     }
//koniec vyhodnotenie splatnosti


}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec pre vsetky ICO


////////////////////////////////////////////////////////////////////////////////pre jednu fakturu
if ( $copern == 12 AND $drupoh == 2 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.ico = $h_ico AND $podmucex".
"";

//echo $sqltt;
$sql = mysql_query("$sqltt");
     

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);
$strana=1;
$hod=0;
$uhr=0;
$zos=0;

//koniec hlavicka pred

//zaciatok vypisu tovaru

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND uce = $h_uce ".
" ORDER BY dat,dok";

//echo $tovtt;

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

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto za fakt˙ru $cislo_fak","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"⁄Ëet: $h_uce","0",0,"L");
$pdf->Cell(90,4,"Obdobie: $h_obdn","0",1,"L");
$pdf->Cell(180,4,"I»O: $h_ico, $hlavicka->nai, $hlavicka->mes $hlavicka->tel $hlavicka->em1 ","0",1,"L");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystaven·","1",0,"L");$pdf->Cell(20,4,"Splatn·","1",0,"L");
$pdf->Cell(10,4,"poSPL","1",0,"L");
$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"UhradenÈ","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");


      }
//koniec j=0


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//sumare napocet
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");
if( $rtov->drupoh < 10 ) { $pdf->Cell(20,4,"$das_sk","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(20,4," ","0",0,"L"); }

if( $rtov->drupoh < 10 ) { $pdf->Cell(10,4,"$pospl","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(10,4," ","0",0,"L"); }

$pdf->Cell(20,4,"$rtov->fak","0",0,"R");
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$Szos","0",1,"R");
if( $rtov->poz != '' ) { $pdf->Cell(85,4," ","0",0,"R");$pdf->Cell(0,4,"$rtov->poz","0",1,"L"); $j=$j+1; }
}
$i = $i + 1;
$j = $j + 1;

//stranka pre jednu fakturu
if( $j >= 45 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

$pdf->Cell(105,4,"SPOLU","T",0,"R");
$pdf->Cell(25,4,"$Shod","T",0,"R");$pdf->Cell(25,4,"$Suhr","T",0,"R");$pdf->Cell(0,4,"$Szos","T",1,"R");

  }
//koniec hlavicky pre jedno ICO

}
///////////////////////////////////////////////////////////////////////////////koniec pre jednu fakturu


////////////////////////////////////////////////////////////////////////////////pre  vsetky faktury polozkovite
if ( $copern == 14 AND $drupoh == 4 )
{
$podmucexy=" = $h_uce ";
//echo "hal".$h_al;
//echo " ico".$h_ico;

if( $h_al > 0 AND $h_ico > 0 ) {  $podmucexy=" > 0 "; }
if( $h_su > 0 AND $h_ico > 0 ) {  $podmucexy=" > 0 "; }

//sumar vsetko pox=999 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,999,999,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce $podmucexy GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//vlozim tam sumar za kazdu fakturu ten mi bude nulovat napocet hod,uhr,zos pox=1 a pox1=1
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1,0,1,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,0,0,0,dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce $podmucexy GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vlozim tam sumar za ico pox=10 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,10,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce $podmucexy GROUP BY uce,ico";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//hlavicka ico pox=0 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,0,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce $podmucexy GROUP BY uce,ico";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $h_ico == 0 ) {
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE uce != $h_uce ";
$dsql = mysql_query("$dsqlt");
                  }

if( $h_al == 0 ) {
$h_uce3=substr($h_uce,0,3); 

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE LEFT(uce,3) != $h_uce3 ";
$dsql = mysql_query("$dsqlt");
                  }

//zaciatok vypisu tovaru

$podmicoy="";
if( $h_ico > 0 ) { $podmicoy="F$kli_vxcf"."_$uctpol.ico = $h_ico AND "; }

$trdico="nai,";
if( $slovakiaplay == 1 ) { $trdico=""; }

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE $podmicoy $podmucex ".
" ORDER BY uce,pox2,".$trdico."F$kli_vxcf"."_$uctpol.ico,pox,fak,pox1,dat,dok";

//echo $tovtt;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
$strana=1;
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

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto poloûkovitÈ ","LTB",0,"L"); }
$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"⁄Ëet: $rtov->uce","0",0,"L");
$pdf->Cell(90,4,"Obdobie: $h_obdn","0",1,"L");
if( $vsetko != 1 ) { $pdf->Cell(180,4,"I»O: $h_ico, $hlavicka->nai, $hlavicka->mes $hlavicka->tel $hlavicka->em1 ","0",1,"L"); }

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystaven·","1",0,"L");$pdf->Cell(20,4,"Splatn·","1",0,"L");
$pdf->Cell(10,4,"poSPL","1",0,"L");
$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"UhradenÈ","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");


      }
//koniec j=0


$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//prva uroven faktury a uhrady
if( $rtov->pox == 1 AND $rtov->pox1 == 0 )      {

//sumare napocet
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");
if( $rtov->drupoh < 10 ) { $pdf->Cell(20,4,"$das_sk","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(20,4," ","0",0,"L"); }

if( $rtov->drupoh < 10 ) { $pdf->Cell(10,4,"$pospl","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(10,4," ","0",0,"L"); }

$pdf->Cell(20,4,"$rtov->fak","0",0,"R");
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(90,4,"$rtov->poz","0",0,"L");
$pdf->Cell(0,4,"$Szos","0",1,"R");
$j = $j + 1;

                           }
//koniec prva uroven faktury a uhrady

//sumar za fakturu bude mi nulovat sumar
if( $rtov->pox == 1 AND $rtov->pox1 == 1 )      {

//sumare napocet
$hod = 0;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = 0;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = 0;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

$pdf->Cell(20,4," ","0",1,"R");
$j=$j+1;

                           }
//koniec prva uroven faktury a uhrady


//hlavicka ico
if( $rtov->pox == 0 )      {


$pdf->Cell(0,4,"⁄Ëet $rtov->uce FIRMA I»O $rtov->ico $rtov->nai $rtov->mes tel.$rtov->tel","0",1,"L");
$j = $j + 1;

                           }
//koniec sumar za ico

//sumar za ico
if( $rtov->pox == 10 )      {


$pdf->Cell(105,4,"⁄Ëet $rtov->uce CELKOM za I»O $rtov->ico $rtov->nai $rtov->tel","B",0,"L");
$pdf->Cell(25,4,"$rtov->hod","B",0,"R");$pdf->Cell(25,4,"$rtov->uhr","B",0,"R");$pdf->Cell(0,4,"$rtov->zos","B",1,"R");
$j = $j + 1;

                           }
//koniec sumar za ico

//sumar vsetko
if( $rtov->pox2 == 999 )      {

$pdf->Cell(0,4," ","0",1,"R");
$pdf->Cell(105,4,"CELKOM za vöetky I»O","1",0,"L");
$pdf->Cell(25,4,"$rtov->hod","1",0,"R");$pdf->Cell(25,4,"$rtov->uhr","1",0,"R");$pdf->Cell(0,4,"$rtov->zos","1",1,"R");
$j = $j + 1;

                           }
//koniec sumar za ico

}
$i = $i + 1;

//stranka vsetky faktury polozkovite
//$pdf->Cell(20,4,"$j do 37","0",1,"R");
if( $j >= 37 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar




}
///////////////////////////////////////////////////////////////////////////////koniec pre vsetky faktury polozkovite


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
if( $vsetko == 0 ) { $pdf->Cell(90,5,"Saldokonto nesp·rovanÈ","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(105,4,"Pr·zdna zostava","0",1,"R");

}



$pdf->Output("$outfilex");


?> 
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Saldo PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php if( $zandroidu == 0 ) { ?> 
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Saldokonto PDF form·t</td>
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

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php 

if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
}

?>


<a href="../tmp/test<?php echo $kli_uzid; ?>.pdf">../tmp/test<?php echo $kli_uzid; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
