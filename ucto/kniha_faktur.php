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


$_REQUEST['h_obdp'] = 1;
$_REQUEST['h_obdk'] = 12;
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

$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$h_obdp = $_REQUEST['h_obdp'];
$h_obdk = $_REQUEST['h_obdk'];
$h_drp = $_REQUEST['h_drp'];
$typ = $_REQUEST['typ'];

//echo " h_drp ".$h_drp." typ ".$typ;

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

$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$copern = $_REQUEST['copern'];

$tlacR=0;
$tlacitR = $_REQUEST['tlacitR'];
if( $tlacitR == 1 ) { $tlacR=1; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Kniha Faktúr</title>
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

<SCRIPT Language="JavaScript">
    <!--

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }


    // -->
</SCRIPT>

</HEAD>
<BODY class="white" onload="">
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

<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na sirku okraje vl=15 vp=15 hr=15 dl=15  


if ( $h_drp == 1 ) $tabl = "fakodb";
if ( $h_drp == 2 ) $tabl = "fakdod";
if ( $h_drp == 3 ) $tabl = "fakodb";
if ( $h_drp == 4 ) $tabl = "fakdod";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   prx         INT,
   ume         FLOAT(8,4),
   uce         INT,
   dok         INT,
   fak         DECIMAL(10,0),
   ico         INT,
   dat         DATE,
   daz         DATE,
   das         DATE,
   uhr         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   poz         TEXT
);
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $h_drp == 1 OR $h_drp == 2 OR $h_drp == 3 OR $h_drp == 4  )
{
$ume_poc= $h_obdp.".".$kli_vrok;
$ume_kon= $h_obdk.".".$kli_vrok;

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 1,ume,uce,dok,fak,ico,dat,daz,das,".
"0,hod,txp FROM F$kli_vxcf"."_$tabl WHERE dok > 0 AND ume >= $ume_poc AND ume <= $ume_kon ".
" ORDER BY dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 9,ume,uce,dok,fak,ico,dat,daz,das,".
"0,SUM(hod),poz FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE dok > 0  ".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}



if ( $h_drp == 1 OR $h_drp == 2 OR $h_drp == 3 OR $h_drp == 4 )
  {
$sqltt = "SELECT *".
" FROM F$kli_vxcf"."_zozprc$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_zozprc$kli_uzid.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok > 0 ".
" ORDER BY prx,uce,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
  }


$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/knifa_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/knifa_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');




$tvpol = mysql_num_rows($sql);
$i=0;
$j=0;
$strana=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$rtov=mysql_fetch_object($sql);
//$dat_sk = SkDatum($rtov->dat);

//hlavicka
if( $j == 0 ) {

$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

if ( $h_drp == 1 )
  {
$pdf->Cell(90,5,"Kniha odberate¾ských faktúr za obdobie $ume_poc až $ume_kon","LTB",0,"L");$pdf->Cell(0,5,"$vyb_naz - strana $strana","RTB",1,"R");
  }

if ( $h_drp == 2 )
  {
$pdf->Cell(90,5,"Kniha dodávate¾ských faktúr za obdobie $ume_poc až $ume_kon","LTB",0,"L");$pdf->Cell(0,5,"$vyb_naz - strana $strana","RTB",1,"R");
  }


if ( $h_drp == 3 )
  {
$pdf->Cell(90,5,"Kniha poh¾adávok za obdobie $ume_poc až $ume_kon","LTB",0,"L");$pdf->Cell(0,5,"$vyb_naz - strana $strana","RTB",1,"R");
  }

if ( $h_drp == 4 )
  {
$pdf->Cell(90,5,"Kniha záväzkov za obdobie $ume_poc až $ume_kon","LTB",0,"L");$pdf->Cell(0,5,"$vyb_naz - strana $strana","RTB",1,"R");
  }

if ( $h_drp == 1 OR $h_drp == 3 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(10,5,"Úèet","1",0,"R");
$pdf->Cell(17,5,"Doklad","1",0,"R");$pdf->Cell(17,5,"Faktúra","1",0,"R");$pdf->Cell(14,5,"Vystavená","1",0,"R");
$pdf->Cell(14,5,"Zdan.pln.","1",0,"R");$pdf->Cell(14,5,"Splatná","1",0,"R");
$pdf->Cell(80,5,"Odberate¾","1",0,"L");

$pdf->Cell(0,5,"Hodnota","1",1,"R");
}


if ( $h_drp == 2 OR $h_drp == 4 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(10,5,"Úèet","1",0,"R");
$pdf->Cell(17,5,"Doklad","1",0,"R");$pdf->Cell(17,5,"Faktúra","1",0,"R");$pdf->Cell(14,5,"Doruèená","1",0,"R");
$pdf->Cell(14,5,"Zdan.pln.","1",0,"R");$pdf->Cell(14,5,"Splatná","1",0,"R");
$pdf->Cell(80,5,"Dodávate¾","1",0,"L");

$pdf->Cell(0,5,"Hodnota","1",1,"R");
}


              }
//koniec hlavicky


//polozky

$dat=SkDatum($rtov->dat);
$daz=SkDatum($rtov->daz);
$das=SkDatum($rtov->das);

if ( ( $h_drp == 1 OR $h_drp == 2 OR $h_drp == 3 OR $h_drp == 4 ) AND $rtov->prx == 1 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(10,5,"$rtov->uce","T",0,"R");
$pdf->Cell(17,5,"$rtov->dok","T",0,"R");$pdf->Cell(17,5,"$rtov->fak","T",0,"R");$pdf->Cell(14,5,"$dat","T",0,"R");
$pdf->Cell(14,5,"$daz","T",0,"R");$pdf->Cell(14,5,"$das","T",0,"R");
$pdf->Cell(80,5,"$rtov->ico $rtov->nai $rtov->mes","T",0,"L");

$pdf->Cell(0,5,"$rtov->hod","T",1,"R");

if( $rtov->poz != '' ) {
$j=$j+1;
$pdf->Cell(0,5,"$rtov->poz","0",1,"L");
                       }

  }


if ( ( $h_drp == 1 OR $h_drp == 2 OR $h_drp == 3 OR $h_drp == 4 ) AND $rtov->prx == 9 )
  {
$pdf->SetFont('arial','',7);
$pdf->Cell(100,5,"CELKOM všetky faktúry","1",0,"L");
$pdf->Cell(0,5,"$rtov->hod","1",1,"R");
  }


//koniec polozky

}
$i = $i + 1;
$j = $j + 1;
if( $j == 50 ) $j=0;

  }



$pdf->Output("$outfilex");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>