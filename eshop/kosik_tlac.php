<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {

$zmtz=1*$_REQUEST['zmtz'];
$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {

//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }
//$serverx="www.ala.sk/androideshop";

$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//user
if (isset($_REQUEST['userx'])) { $userx = $_REQUEST['userx']; }
//$userx="NICK/adra234/USID/2016/PSWD/cp41cs";
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];

$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
$db = new DB_CONNECT();

if( AKY_CHARSET == "utf8" ) { mysql_query("SET NAMES cp1250"); }

$kli_vxcf=DB_FIR;
$kli_uzid=$usidxxx;

$druhid=0;
$cuid=0;
$sqldok = mysql_query("SELECT * FROM F".DB_FIR."_ezak WHERE ez_id = $usidxxx ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=10;
    }
$sqldok = mysql_query("SELECT * FROM F".DB_FIR."_ezak WHERE ez_id = $usidxxx AND ez_heslo = '$pswdxxx' ORDER BY ez_id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $cuid=1*$riaddok->cuid;
    $druhid=20;
    }
$sqldok = mysql_query("SELECT * FROM klienti WHERE id_klienta = $cuid AND all_prav > 20000 ORDER BY id_klienta DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $druhid=99;
    }
if( $druhid < 20 ) { exit; }
  }

if( $zmtz == 1 )
  {
$sys = 'SKL';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }
if( $zmtz == 0 )
  {
session_start(); 
$h5rtgh5 = include("../odpad2010/h5rtgh5.php");
//$kli_vxcf=53;
$kli_uzid=1*$_SESSION['ez_id'];
if( $kli_uzid == 0 ) exit;
  }

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$html = 1*$_REQUEST['html'];

if( $zmtz != 2 )
  {
  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
  }
if( $zmtz == 2 ) { $zmtz=1; }

$citwebs = include("../funkcie/citaj_webs.php");
$kli_vxcf=$webs_fir;
if( $kli_vxcf == 0 ) exit;

$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR".$kli_vxcf."/autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//zmazat polozku
if( $copern == 6001 )
{
$plux = 1*$_REQUEST['plux'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_kosik  WHERE xcpl = $plux ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=1;
}
//koniec zmazat polozku

//zmazat kosik cely
if( $copern == 6601 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_kosik WHERE xid = $kli_uzid ";
$dsql = mysql_query("$dsqlt");

$html=1;
$copern=1;
}
//koniec zmazat kosik cely

//tlac kosik cely
if( $copern == 7001 )
{



$html=0;
$copern=1;
}
//koniec tlac kosik cely

//objednaj kosik cely
if( $copern == 8001 )
{
?>
<script type="text/javascript">
if( confirm ("Chcete uzavrieù objedn·vku ?") )
  var okno = window.open("kosik_tlac.php?copern=8002&drupoh=1&page=1&ffd=0","_self");
else
{ }
</script>
<?php
$html=1;
$copern=1;
}
if( $copern == 8002 )
{
$sql = "SELECT xcpo FROM F$kli_vxcf"."_kosikobj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_kosikobj';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   xdok         int DEFAULT 0,
   xfak         decimal(10,0) DEFAULT 0,
   xsx1         decimal(10,0) DEFAULT 0,
   xsx2         decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xdx1         DATE not null,
   xdx2         DATE not null,
   xdx3         DATE not null,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xcpo         int PRIMARY KEY not null auto_increment,
   xcpl         decimal(10,0) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kosikobj'.$sqlt;
$vytvor = mysql_query("$vsql");

 }

$dsqlt = "INSERT INTO F$kli_vxcf"."_kosikobj ".
" SELECT xdok,0,0,0,0,'','','',xice,xodbm,0,xcpl,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,now() FROM F$kli_vxcf"."_kosik WHERE xid = $kli_uzid ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kosik WHERE xid = $kli_uzid ";
$dsql = mysql_query("$dsqlt");

?>
<script type="text/javascript">
alert ("V·ö n·kupn˝ koöÌk bol objednan˝. \r Potvrdenie objedn·vky dostanete do V·öho emailu. \r œakujeme za objedn·vku. ");
window.close();
</script>
<?php
exit;
}
//koniec objednaj kosik cely

//platba ?
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $cislo_dok ";
$platba=1;
$sqldok = mysql_query("$sqlfir");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platba=1*$riaddok->nas1;
  } 
if( $platba == 0 ) { $platba=1; }
//koniec platba

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
KoöÌk
</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
function ZmazPLU(plu)
                {

var plux = plu;

window.open('kosik_tlac.php?copern=6001&drupoh=1&page=1&plux='+ plux + '&ffd=0',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZmazKosik()
                {

window.open('kosik_tlac.php?copern=6601&drupoh=1&page=1&ffd=0',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacKosik()
                {

window.open('kosik_tlac.php?copern=7001&drupoh=1&page=1&ffd=0',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

function ObjednajKosik()
                {

window.open('kosik_tlac.php?copern=8001&drupoh=1&page=1&ffd=0',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function MojeObjednavky()
                {
window.open('obj_tlac.php?copern=1&drupoh=1&page=1&ffd=0&html=1',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
                }

function MojeFaktury(icox)
                {
var h_ico = icox;

window.open('../ucto/saldo_pdf.php?h_uce=31100&h_nai=&h_ico=' + h_ico + '&h_obd=0&copern=10&drupoh=1&page=1&h_su=0&h_al=1&analyzy=0&zkosika=1',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>
<?php if( $zandroidu == 0 ) { echo "EuroSecom  -  N·kupn˝ koöÌk"; } ?>  
<?php if( $zandroidu == 1 ) { echo "Doklad PDF prebran˝, tlaËidlo Sp‰ù - do zoznamu objedn·vok"; } ?> 
</td>
</tr>
</table>
<br />

<?php
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/objed_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/objed_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xcpl         int(10) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdx3         VARCHAR(80) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$tlacobj = 1*$_REQUEST['tlacobj'];
if( $tlacobj == 0 )
  {
//zober z kosika
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,0,xcpl,xcis,xnat,'',xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm FROM F$kli_vxcf"."_kosik ".
" WHERE xid = $kli_uzid ".
"";
$dsql = mysql_query("$dsqlt");
  }
if( $tlacobj == 1 )
  {
//zober z objednavok
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx3,xcpl,xcis,xnat,xdx3,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm FROM F$kli_vxcf"."_kosikobj ".
" WHERE xdok = $cislo_dok ".
"";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
//exit;
  }

//group vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 10,xdok,xice,xodbm,0,xcpl,xcis,xnat,xdx3,xdph,xcep,xced,SUM(xmno),SUM(xhdb),SUM(xhdd),xid,xdatm  FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE xdok > 0 GROUP BY xdok".
"";
$dsql = mysql_query("$dsqlt");


if ( $html == 1 )  
{
?>
<table class="h2" width="100%" >
<tr>
<td class="bmenu" colspan="4">N·kupn˝ koöÌk </td>
</tr>
<?php
}

if ( $drupoh == 1 )
  {
$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_mzdprcx".$kli_uzid.".xcis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( xdok > 0 ) ORDER BY pox,xcpl ";
  }



//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

if( $i == 0 )
  {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ico = $fir_riadok->ico; $dic = $fir_riadok->dic; $icd = $fir_riadok->icd;
$nai = $fir_riadok->nai; $na2 = $fir_riadok->na2; $uli = $fir_riadok->uli;
$psc = $fir_riadok->psc; $mes = $fir_riadok->mes; $tel = $fir_riadok->tel; $fax = $fir_riadok->fax; $em1 = $fir_riadok->em1;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ezak WHERE ez_id = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->ez_kto; $etel = $fir_riadok->ez_tel; $email = $fir_riadok->ez_ema; $odbx = 1*$fir_riadok->cxx1; $icoezak = 1*$fir_riadok->ez_ico;
$icox=$riadok->xice;


if( $riadok->xid < 900 AND trim($ekto) == '' )
  {
$sqlfir = "SELECT * FROM klienti WHERE id_klienta = $riadok->xid ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$ekto = $fir_riadok->meno." ".$fir_riadok->priezvisko; $etel = ""; $email = ""; $odbx = 0; $icoezak = 0;

  }

if( $icoezak == 99999999 ) { $odbx=1*$riadok->xodbm; }

$sqlfir = "SELECT * FROM F$kli_vxcf"."_webslu ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) 
{ 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$platba01 = $fir_riadok->kat04h01;
$platba02 = $fir_riadok->kat04h02;
$platba03 = $fir_riadok->kat04h03;
$platba04 = $fir_riadok->kat04h04;
$platba05 = $fir_riadok->kat04h05;
$platba06 = $fir_riadok->kat04h06;
$platba07 = $fir_riadok->kat04h07;
$platba08 = $fir_riadok->kat04h08;
$platba09 = $fir_riadok->kat04h09;
$platba10 = $fir_riadok->kat04h10;

$platbap = $fir_riadok->kat04p;
} 


  }

//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$chcemhlavicku=1;
//hlavicka
if( $html == 0  )
          {
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg') AND $chcemhlavicku == 1 )
{
$rozmerhlv1="15"; $rozmerhlv2="10"; $rozmerhlv3="185"; $rozmerhlv4="20"; 

$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',$rozmerhlv1,$rozmerhlv2,$rozmerhlv3,$rozmerhlv4);
}
          }
//koniec hlavicka

$posun=$rozmerhlv2+$rozmerhlv4+5;

if( $chcemhlavicku == 1 ) { $pdf->SetY($posun); }

$pdf->SetFont('arial','',10);
if ( $copern == 1 AND $drupoh == 1 AND $tlacobj == 0 )  { $pdf->Cell(0,6,"N·kupn˝ koöÌk Ë.$riadok->xdok ","1",1,"L"); }
if ( $copern == 1 AND $drupoh == 1 AND $tlacobj == 1 )  { $pdf->Cell(0,6,"Objedn·vka Ë.$riadok->xdok ","1",1,"L"); }

$skdatum=SkDatum($riadok->xdatm);

$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"Objednal:","1",0,"L");$pdf->Cell(0,5,"$ekto, Tel: $etel, Email: $email ","0",1,"L");
$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"D·tum:","1",0,"L");$pdf->Cell(0,5,"$skdatum","0",1,"L");
$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"Firma:","1",0,"L");$pdf->Cell(0,5,"$nai $na2, $uli, $mes, $psc ","0",1,"L");

if( $odbx > 0 ) { 

$sqlfir = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $icox AND odbm = $odbx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$onai = $fir_riadok->onai; $ona2 = $fir_riadok->ona2; $ouli = $fir_riadok->ouli;
$opsc = $fir_riadok->opsc; $omes = $fir_riadok->omes; 

$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"OdbernÈ miesto:","1",0,"L");$pdf->Cell(0,5,"$onai $ona2, $ouli, $omes, $opsc ","0",1,"L");

                }

$pdf->Cell(0,2," ","0",1,"R");
$pdf->Cell(30,5,"Kontakty:","1",0,"L");$pdf->Cell(0,5,"Tel: $tel, Fax: $fax, Email: $em1 ","0",1,"L");
$pdf->Cell(0,5,"I»O: $ico, DI»: $dic, I»DPH: $icd ","0",1,"L");

if ( $autoreg == 1 )  {

if( $platba == 1 ) { $platbax=$platba01; }
if( $platba == 2 ) { $platbax=$platba02; }
if( $platba == 3 ) { $platbax=$platba03; }
if( $platba == 4 ) { $platbax=$platba04; }
if( $platba == 5 ) { $platbax=$platba05; }
if( $platba == 6 ) { $platbax=$platba06; }
if( $platba == 7 ) { $platbax=$platba07; }
if( $platba == 8 ) { $platbax=$platba08; }
if( $platba == 9 ) { $platbax=$platba09; }
if( $platba == 10 ) { $platbax=$platba10; }

$pdf->SetFont('arial','',7);
$pdf->Cell(30,5,"$platbap:","1",0,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(0,5,"$platbax ","0",1,"L");
                      }

$pdf->Cell(0,2," ","0",1,"R");

$pdf->SetFont('arial','',10);

if ( $copern == 1 AND $drupoh == 1 )  {

if( $riadok->xhdb != 0 )
     {
$pdf->Cell(80,5,"Poloûka","1",0,"L");$pdf->Cell(30,5,"Mnoûstvo","1",0,"R");$pdf->Cell(30,5,"Cena bez/s DPH","1",0,"R");
$pdf->Cell(0,5,"Hodnota bez/s DPH","1",1,"R");
     }
                                      }



if ( $copern == 1 AND $drupoh == 1 AND $html == 1 )  {
?>
<tr>
<td class="hvstup" colspan="4">Objednal: <?php echo $ekto; ?>, Tel: <?php echo $etel; ?>, Email: <?php echo $email; ?></td>
</tr>
<tr>
<tr>
<td class="hvstup" colspan="4">D·tum: <?php echo $skdatum; ?></td>
</tr>
<tr>
<td class="hvstup" colspan="4">Firma: <?php echo $nai; ?> <?php echo $na2; ?>, <?php echo $uli; ?>, <?php echo $mes; ?>, <?php echo $psc; ?></td>
</tr>
<tr>
<td class="hvstup" colspan="4">Tel: <?php echo $tel; ?>, Fax: <?php echo $fax; ?>, Email: <?php echo $em1; ?> </td>
</tr>
<tr>
<tr>
<td class="hvstup" colspan="4">I»O: <?php echo $ico; ?>, DI»: <?php echo $dic; ?>, I»DPH: <?php echo $icd; ?></td>
</tr>
<tr>
<td class="bmenu" align="left" width="40%" >Poloûka</td>
<td class="bmenu" align="right" width="20%" >Mnoûstvo</td>
<td class="bmenu" align="right" width="20%" >Cena s DPH</td>
<td class="bmenu" align="right" width="20%" >Hodnota s DPH</td>
</tr>
<?php
                                      }



     }
//koniec hlavicky j=0



if( $riadok->pox == 1 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',10);

$nat=$riadok->nat;
$xcis=1*$riadok->xcis;

if( $riadok->xsx3 == 0 AND $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }

if( $riadok->xsx3 == 1 AND $riadok->xcis > 0 )
  {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sluzby WHERE slu = $xcis ORDER BY slu LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $natx=$riaddok->nsl;
 $xcisx=$riaddok->slu;
 }
$nat=$natx;
$xcis=$xcisx;

if( $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }
  }

if( $riadok->xsx3 == 1 AND $xcis == 0 ) { $nat=$riadok->xnat; $xcis=0; }

$xcistlac=$xcis;
if( $xcis == 0 ) { $xcistlac=""; }

$mnotlac=$riadok->xmno;
if( $riadok->xmno == 0 ) { $mnotlac=""; }
$cenatlac=$riadok->xcep." / ".$riadok->xced;
if( $riadok->xcep == 0 ) { $cenatlac=""; }
$hodnotatlac=$riadok->xhdb." / ".$riadok->xhdd;
if( $riadok->xhdb == 0 ) { $hodnotatlac=""; }

$textdopln=$riadok->xdx3;
if( $textdopln == '0000-00-00' ) { $textdopln=""; }

$pdf->Cell(80,5,"$xcistlac $nat $textdopln","B",0,"L");$pdf->Cell(30,5,"$mnotlac","B",0,"R");$pdf->Cell(30,5,"$cenatlac","B",0,"R");
$pdf->Cell(0,5,"$hodnotatlac","B",1,"R");

$pdf->SetFont('arial','',10);

if( $html == 1 )
 {
?>
<tr>
<td class="hvstup">
<a href="#" onClick="ZmazPLU(<?php echo $riadok->xcpl; ?>);">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='Zmazaù poloûku' ></a>

<?php echo $riadok->xcis; ?> <?php echo $riadok->nat; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xmno; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xced; ?></td>
<td class="hvstup" align="right"><?php echo $riadok->xhdd; ?></td>
</tr>
<?php
 }

}


if( $riadok->pox == 10 AND $drupoh == 1 )
{

$pdf->SetFont('arial','',10);

if( $riadok->xhdb != 0 )
     {
$pdf->Cell(140,5,"Celkom bez/s DPH","1",0,"L");
$pdf->Cell(0,5,"$riadok->xhdb / $riadok->xhdd EUR","1",1,"R");
     }

if( $html == 1 )
 {
?>
<tr>
<td class="bmenu">Celkom koöÌk Ë.<?php echo $riadok->xdok; ?></td>
<td class="bmenu" align="right"><?php echo $riadok->xmno; ?></td>
<td class="bmenu" align="right"> </td>
<td class="bmenu" align="right"><?php echo $riadok->xhdd; ?></td>
</tr>
<?php
 }

}





}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 AND $html == 0 ) $j=0;

  }


if( $html == 1 )
 {
?>
<tr>
<td class="bmenu"> 
<a href="#" onClick="ZmazKosik();">
<img src='../obr/zmazuplne.png' width=20 height=20 border=0 title='Zmazaù cel˝ koöÌk' ></a>
</td>
<td class="bmenu" align="right">
<a href="#" onClick="TlacKosik();">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù objedn·vku celÈho koöÌka' ></a>
</td>
<td class="bmenu" align="right"> 
<a href="#" onClick="ObjednajKosik();">
<img src='../obr/ok.png' width=20 height=20 border=0 title='Potvrdiù objedn·vku celÈho koöÌka' ></a>
</td>
<td class="bmenu" align="right"> 
<a href="#" onClick="MojeObjednavky();">
<img src='../obr/zoznam.png' width=20 height=20 border=0 title='Zoznam mojÌch nevybaven˝ch objedn·vok' ></a>

<a href="#" onClick="MojeFaktury(<?php echo $ico; ?>);">
<img src='../obr/zoznam.png' width=20 height=20 border=0 title='Zoznam mojÌch neuhraden˝ch fakt˙r' ></a>

</td>
</tr>
<?php
  }

if( $html == 0 ) { 

$poznx="";
$sqlfir = "SELECT * FROM F$kli_vxcf"."_kosiktext WHERE invt = $riadok->xdok ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $poznx = $fir_riadok->itxt; }

$polestr2 = explode("\r\n", $poznx);

if( $polestr2[0] != ''  )
    {
$rmc=0;
$ipole=1;
foreach( $polestr2 as $hodnota ) {

if( $ipole == 1 ) { $pdf->Cell(150,2," ","$rmc",1,"L"); $pdf->Cell(150,5,"Pozn·mka:","$rmc",1,"L"); }

$pdf->Cell(150,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$pdf->Output("$outfilex"); }


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

if( $html == 0 ) {
?> 

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
       
<?php
                 }
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
